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
        $this->load->model('AdminUserModel');
    }

    //登录页面
    public function index()
    {
        $this->load->view('loginview');
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
        $userArr = $this->AdminUserModel->getOne($userWhere);
        if (!$userArr) {
            echo $this->requestReturn('用户密码不正确', false);exit;
        }
        //存入session
        $this->session->set_userdata(['admin' => $userArr]);
        $this->session->userdata('admin');
        echo $this->requestReturn('登录成功', true);exit;
    }

    //退出登录
    public function logout()
    {
        $this->session->unset_userdata('admin');
        echo $this->requestReturn('退出登录成功', true);
    }
}
