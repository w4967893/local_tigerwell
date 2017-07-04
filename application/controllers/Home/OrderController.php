<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends HomeBase {

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
        $this->load->model('GoodsModel');
        $this->load->model('UserModel');
    }

    /**
     * 生成订单
     *
     * @param int goods_id 商品id
     * @param int month 维修月份数
     * @return json
     */
    public function buy()
    {
        $goodsId = $this->input->get('goods_id');
        $month = $this->input->get('month');
        if (!$goodsId || !$month) {
            echo $this->requestReturn('信息填写不完整', false);exit;
        }

        $goodsArr = $this->GoodsModel->getOne(['id' => $goodsId]);
        if (!$goodsArr) {
            echo $this->requestReturn('该商品不存在', false);exit;
        }
        //计算总价格
        $totalPrice = $goodsArr['price'] + $goodsArr['maintenance_price'] * $month;
        $goodsArr['total_price'] = $totalPrice;

        //判断余额是否充足
        //获取用户id
        $userId = $this->session->userdata('id');
        $userArr = $this->UserModel->getOne(['id' => $userId]);

        if ($totalPrice > $userArr['balance']) {
            echo $this->requestReturn('余额不足', false);exit;
        }

        //生成订单号码
        $orderNum = $this->orderNum();
        $insert = ['goods_id' => $goodsId, 'order_id' => $orderNum, 'user_id' => $userId, 'status' => 2, 'maintenance_month' => $month, 'total_price' => $totalPrice];
        $bool = $this->OrderModel->insertOne($insert);
        if (!$bool) {
            echo $this->requestReturn('购买失败', false);exit;
        } else {
            echo $this->requestReturn('购买成功', true);exit;
        }
    }

    /**
     * 生成订单号码
     *
     * @return int
     */
    protected function orderNum()
    {
        //年月日加随机数
        ini_set('date.timezone','PRC');
        $number = date("Ymd", time()).rand(10000,99999);
        return $number;
    }
}
