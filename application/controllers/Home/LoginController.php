<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

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
        $this->load->model('userModel');
        $this->load->model('orderModel');
    }

    //用户登录
    public function login()
    {
        $username = $this->input->get('username');
        $password = $this->input->get('password');
        if (!$username || !$password) {
            echo $this->requestReturn('用户名,密码不能为空', false);exit;
        }
        $password = crypt($password, 'tigerwell');
        $userWhere = ['username' => $username, 'password' => $password];
        $userArr = $this->userModel->getOne($userWhere);
        if (!$userArr) {
            echo $this->requestReturn('用户密码不正确', false);exit;
        }
        //获取用户订购商品
        $orderArr  = $this->orderModel->getOne(['order.user_id' => $userArr['id'], 'order.status' => 1]);
        $userArr['goods_name'] = $orderArr['goods_name'];
        $userArr['version'] = $orderArr['version'];
        //存入session
        $this->session->set_userdata($userArr);
        echo $this->requestReturn('登录成功', true, $userArr);exit;
    }

    //退出登录
    public function logout()
    {
        $this->session->sess_destroy();
        echo $this->requestReturn('退出登录成功', true);
    }
}
