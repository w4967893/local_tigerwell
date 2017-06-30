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

    //获取列表
    public function oList($where = [], $offset = 0, $limit = 20)
    {
//        $this->db->get_where('order', $where)->result_array();
        $this->db->select('order.*, user.username, goods.goods_name');
        $this->db->from('order');
        $this->db->join('goods', 'order.goods_id = goods.id', 'left');
        $this->db->join('user', 'order.user_id = user.id', 'left');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('order.create_time', 'DESC');
        $this->db->limit($limit, $offset);
        $orderArr = $this->db->get()->result_array();
        return $orderArr;
    }

    //根据where条件获取一条数据
    public function getOne($where)
    {
        $this->db->select('goods.goods_name, goods.version');
        $this->db->from('order');
        $this->db->join('goods', 'order.goods_id = goods.id', 'left');
        $this->db->where($where);
        $query = $this->db->get()->row_array();
        return $query;
    }
}