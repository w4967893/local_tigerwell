<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PayController extends HomeBase {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct(){
        parent::__construct();
        $this->load->model('PayModel');
        $this->load->model('ChangeMoneyModel');
        $this->load->model('UserModel');
    }

    //支付宝支付接口
    public function alipay()
    {
        $total_fee = $this->input->get('total_fee');//付款外币金额，必填
        $body = $this->input->get('body');//商品描述，可空

        $out_trade_no = $this->alipayNo();//商户订单号，商户网站订单系统中唯一订单号，必填
        $currency = 'USD';//付款外币币种，必填
        $subject = 'Tigerwell商城充值';//订单名称，必填

        //存入充值表
        $userId = $this->session->userdata('id');
        $insert = ['user_id' => $userId, 'out_trade_no' => $out_trade_no, 'total_fee' => $total_fee, 'currency' => $currency];
        $this->PayModel->insertOne($insert);

        $this->load->library('alipay/AlipayConfig', '', 'alipayConfig');
        $alipay_config = $this->alipayConfig->config();
        $this->load->library('alipay/lib/AlipaySubmit', $alipay_config, 'alipaySubmit');
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],

            "out_trade_no"	=> $out_trade_no,
            "subject"	=> $subject,
            "total_fee"	=> $total_fee,
            "body"	=> $body,
            "currency" => $currency,
            "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://ds.alipay.com/fd-ij9mtflt/home.html
            //如"参数名"=>"参数值"

        );
        $html_text = $this->alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }

    //同步回调
    public function synchronous()
    {
        $tradeStatus = $this->input->get('trade_status');//交易状态 TRADE_CLOSED/TRADE_FINISHED
        $tradeNo = $this->input->get('trade_no');//支付宝交易号
        $outTradeNo = $this->input->get('out_trade_no');//境外商户交易号
        $currency = $this->input->get('currency');//结算币种
        $totalFee = $this->input->get('total_fee');//商品的外币金额

        $notifyTime = $this->input->get('notify_time');//返回充值时间（系统时间)
        $update = ['trade_status' => $tradeStatus, 'trade_no' => $tradeNo, 'currency' => $currency, 'total_fee' => $totalFee, 'notify_time' => $notifyTime];
        $where = ['out_trade_no' => $outTradeNo];

        //验证是否该更新充值表   如果异步通知比同步通知更早则会出现这种状况
        $payObj = $this->PayModel->getOne($where);
        if (!$payObj['trade_no']) {
            //更新充值表
            $bool = $this->PayModel->update($update, $where);
            if ($bool) {
                $this->changeBalance($outTradeNo, $totalFee);
            }
            if ($tradeStatus == 'TRADE_FINISHED') {
                echo '支付成功';
            } else {
                echo '支付失败';
            }
        } else {
            echo '支付成功';exit;
        }
    }

    //异步通知可能比同步返回先到达
    //异步回调 25小时以内完成8次通知（通知的间隔频率一般是：4m,10m,10m,1h,2h,6h,15h)
    public function asynchronous()
    {
        $notifyType = $this->input->post('notify_type');//通知类型
        $notifyId = $this->input->post('notify_id');//支付宝通知流水号，境外商户可以用这个流水号询问支付宝该条通知的合法性
        $notifyTime = $this->input->post('notify_time');//通知时间（支付宝时间）

        $tradeStatus = $this->input->post('trade_status');//交易状态
        $tradeNo = $this->input->post('trade_no');//支付宝交易号
        $outTradeNo = $this->input->post('out_trade_no');//境外商户交易号
        $currency = $this->input->post('currency');//结算币种
        $totalFee = $this->input->post('total_fee');//商品的外币金额

        $update = ['notify_type' => $notifyType, 'notify_id' => $notifyId, 'trade_status' => $tradeStatus, 'trade_no' => $tradeNo, 'currency' => $currency, 'total_fee' => $totalFee, 'notify_time' => $notifyTime];
        $where = ['out_trade_no' => $outTradeNo];

        //验证是否该更新充值表   如果同步通知之后异步通知继续回调
        $payObj = $this->PayModel->getOne($where);
        if (!$payObj['trade_no']) {
            //异步通知验证是否有效
            $vbool = $this->validation($notifyId);
            if ($vbool) {
                //更新充值表
                $bool = $this->PayModel->update($update, $where);
                if ($bool) {
                    $change = $this->changeBalance($outTradeNo, $totalFee);
                    if ($change) {
                        echo 'success';
                    } else {
                        echo 'false';
                    }
                }
            } else {
                echo 'false';
            }
        } else {
            echo 'success';
        }
    }

    //改变余额
    public function changeBalance($outTradeNo, $totalFee)
    {
        //查询user_id
        $PayObj = $this->PayModel->getOne(['out_trade_no' => $outTradeNo]);
        //查询原余额
        $UserObj = $this->UserModel->getOne(['id' => $PayObj['user_id']]);
        $changeBalance = $UserObj['balance'] + $totalFee;
        //修改用户余额
        $bool = $this->UserModel->update(['id' => $PayObj['user_id']], ['balance' => $changeBalance]);
        if ($bool) {
            return true;
        } else {
            return false;
        }
    }

    //生成支付宝唯一订单号
    public function alipayNo()
    {
        ini_set('date.timezone','PRC');
        $data = date('YmdHis',time());
        $outTradeNo = $data.rand(10000,99999);
        return $outTradeNo;
    }

    //异步通知验证
    public function validation($notifyId)
    {
        $this->load->library('alipay/AlipayConfig', '', 'alipayConfig');
        $alipay_config = $this->alipayConfig->config();

        $url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&partner='.$alipay_config['partner'].'&notify_id='.$notifyId;
        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        if ($data == 'true') {
            return true;
        } else {
            false;
        }
    }
}
