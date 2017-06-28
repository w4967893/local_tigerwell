<?php

class ChangeMoneyModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //根据where条件获取用户资金变动数据
    public function userList($where)
    {
        $query = $this->db->get_where('change_money', $where)->result_array();
        return $query;
    }

    //插入单条数据
    public function insertOne($insert)
    {
        $query = $this->db->insert('apply', $insert);
        return $query;
    }
}