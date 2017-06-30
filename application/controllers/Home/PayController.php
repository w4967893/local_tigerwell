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
        $this->load->model('OrderModel');
    }

    //支付宝支付接口
    public function alipay()
    {
        $out_trade_no = $this->input->post('out_trade_no');//商户订单号，商户网站订单系统中唯一订单号，必填
        $subject = $this->input->post('subject');//订单名称，必填
        $currency = $this->input->post('currency');//付款外币币种，必填
        $total_fee = $this->input->post('total_fee');//付款外币金额，必填
        $body = $this->input->post('body');//商品描述，可空

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
}
