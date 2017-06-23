<?php

class OrderModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //插入单条数据
    public function insertOne($insert)
    {
        $query = $this->db->insert('order', $insert);
        return $query;
    }
}