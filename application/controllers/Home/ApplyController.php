<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApplyController extends CI_Controller {

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
        $this->load->model('ApplyModel');
    }


    /**
     * 申请试用
     *
     * @param string truename 真实姓名
     * @param string email 邮件
     * @param string phone 手机
     * @param string company 公司
     * @param string position 职位
     * @param string desc 备注
     * @return json
     */
    public function apply()
    {
        $truename = $this->input->get('truename');
        $email = $this->input->get('email');
        $phone = $this->input->get('phone');
        $company = $this->input->get('company');
        $position = $this->input->get('position');
        $desc = $this->input->get('desc');
        if (!$truename || !$email || !$phone || !$company || !$position) {
            echo $this->requestReturn('请填写完整信息', false);exit;
        }
        if (!$desc) {
            $desc = 0;
        }
        $insert = ['truename' => $truename, 'email' => $email, 'phone' => $phone, 'company' => $company, 'position' => $position, 'desc' => $desc];
        $bool = $this->ApplyModel->insertOne($insert);
        if ($bool) {
            echo $this->requestReturn('申请成功', true);exit;
        } else {
            echo $this->requestReturn('申请失败', false);exit;
        }
    }
}
