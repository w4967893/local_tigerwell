<?php

class UserModel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Your own constructor code
    }

    //根据where条件获取一条数据
    public function getOne($where)
    {
        $query = $this->db->get_where('user', $where)->row_array();
        return $query;
    }

    //获取客户相关信息
    public function info($limit = 20, $offset = 0)
    {
        $this->db->select('');
        $this->db->from('user');
        $this->db->join('order', 'order.user_id = user.id', 'left');
        $this->db->where(['status' => 1]);
        $this->db->order_by('user.create_time', 'DESC');
        $this->db->limit($limit, $offset);
        $userArr = $this->db->get()->result_array();
        return $userArr;
    }

}