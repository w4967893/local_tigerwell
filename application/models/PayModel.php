<?php

class PayModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //插入单条数据
    public function insertOne($insert)
    {
        $query = $this->db->insert('pay', $insert);
        return $query;
    }

    //更新数据
    public function update($data, $where)
    {
        return $this->db->update('pay', $data, $where);
    }

    //根据where条件获取一条数据
    public function getOne($where)
    {
        $query = $this->db->get_where('pay', $where)->row_array();
        return $query;
    }
}