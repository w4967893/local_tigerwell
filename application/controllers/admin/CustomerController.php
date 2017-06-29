<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerController extends AdminBase {

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
        $this->load->model('UserModel');
    }

    //获取客户的相关信息
    public function info()
    {
        $userArr = $this->UserModel->info();
        $this->load->view('CustomerView', ['data' => $userArr]);
    }

    //重置密码
    public function resetPassword()
    {
        $id = $this->input->post('id');
        $password = $this->input->post('password');
        $password = crypt($password, 'tigerwell');
        $bool = $this->UserModel->update(['id' => $id], ['password' => $password]);
        if ($bool) {
            echo $this->requestReturn('重置成功', true);exit;
        } else {
            echo $this->requestReturn('重置失败', false);exit;
        }
    }
}
