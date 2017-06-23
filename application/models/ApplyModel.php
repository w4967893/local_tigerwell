<?php

class ApplyModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //根据where条件获取一条数据
    public function getOne($where)
    {
        $query = $this->db->get_where('apply', $where)->row_array();
        return $query;
    }

    //插入单条数据
    public function insertOne($insert)
    {
        $query = $this->db->insert('apply', $insert);
        return $query;
    }
}