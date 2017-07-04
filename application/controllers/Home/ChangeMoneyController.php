<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ChangeMoneyController extends HomeBase {

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
        $this->load->model('ChangeMoneyModel');
    }

    /**
     * 用户资金变动列表
     *
     * @return json
     */
    public function userChange()
    {
        $userId = $this->session->userdata('id');
        $userList = $this->ChangeMoneyModel->userList(['user_id' => $userId]);
        echo $this->requestReturn('获取数据成功', true, $userList); exit;
    }
}
