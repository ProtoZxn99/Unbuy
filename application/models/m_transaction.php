<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_webuser
 *
 * @author munil
 */
class m_transaction extends CI_Model{
    
    public function getAll() {
        $this->db->from("transaction");
        return $this->db->get();
    }
    
    public function get_by_user($id){
        $this->db->from("transaction");
        $this->db->where('user_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
       
    public function get_by_buyer($id){
        $this->db->from("transaction");
        $this->db->where('buyer_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_seller($id){
        $this->db->from("transaction");
        $this->db->where('seller_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_status($id){
        $this->db->from("transaction");
        $this->db->where('status_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function add($data){
        $simpan = $this->db->insert('transaction',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('trans_id', $id);
        $delete = $this->db->delete('transaction');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("transaction");
        $this->db->where('trans_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('transaction', $data);
        return $update;
    }
}
