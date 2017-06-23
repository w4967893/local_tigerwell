<?php

class GoodsModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //插入单条数据
    public function insertOne($insert)
    {
        $query = $this->db->insert('goods', $insert);
        return $query;
    }

    //根据where条件获取一条数据
    public function getOne($where)
    {
        $query = $this->db->get_where('goods', $where)->row_array();
        return $query;
    }

    //获取列表
    public function gList($where)
    {
        return $this->db->get_where('goods', $where)->result_array();
    }
}