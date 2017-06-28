<?php

class AdminUserModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //根据where条件获取一条数据
    public function getOne($where)
    {
        $query = $this->db->get_where('admin_user', $where)->row_array();
        return $query;
    }

}