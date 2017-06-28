<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderController extends AdminBase {

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

    //订单列表
    public function oList()
    {
        $orderArr = $this->OrderModel->oList();
        if (!$orderArr) {
            echo $this->requestReturn('获取列表失败', false);exit;
        } else {
            echo $this->requestReturn('获取列表成功', true, $orderArr);exit;
        }
    }
}
