<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

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
    }
}

class AdminBase extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library("session");//加载session
        $this->load->helper('url');
        $this->isLogin();
    }

    //是否登录
    public function isLogin()
    {
        if (!$this->session->userdata('admin')) {
            //没有登录,重定向
//            redirect('http://local.tigerwill.com/auth/login', 'refresh');
            echo $this->requestReturn('请登录', false);exit;
        }
    }
}

class HomeBase extends MY_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library("session");//加载session
        $this->load->helper('url');
        $this->isLogin();
    }

    //是否登录
    public function isLogin()
    {
        if (!$this->session->userdata('id')) {
            //没有登录,重定向
//            redirect('http://local.tigerwill.com/auth/login', 'refresh');
            echo $this->requestReturn('请登录', false);exit;
        }
    }
}
