<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_confirmpay
 *
 * @author LAB-PC
 */
class m_confirmpay extends CI_Model{
    
    public function getAll() {
        $this->db->from("webtransaction");
        $this->db->where("trans_status in", "('unconfirmed','confirmed')");
        $this->db->order_by("trans_status","asc");
        $this->db->order_by("trans_date","desc");
        return $this->db->get();
    }
    
    public function getAllFilter($status) {
        $this->db->from("webtransaction a");
        $this->db->join("transaction_item b","a.trans_id = b.trans_id");
        $this->db->where("a.trans_status", $status);
        $this->db->order_by("a.trans_status","asc");
        $this->db->order_by("a.trans_date","desc");
        return $this->db->get();
    }
}
