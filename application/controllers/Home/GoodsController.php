<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GoodsController extends CI_Controller {

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
        $this->load->library("session");//加载session
        $this->load->model('GoodsModel');
    }

    /**
     * 商品列表
     *
     * @return json
     */
    public function gList()
    {
        $goodsArr = $this->GoodsModel->gList(['status' => 1]);
        if ($goodsArr) {
            echo $this->requestReturn('获取数据成功', true, $goodsArr);
        } else {
            echo $this->requestReturn('暂无商品', false);
        }
    }
}
