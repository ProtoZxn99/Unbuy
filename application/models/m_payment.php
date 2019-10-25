<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_payment
 *
 * @author LAB-PC
 */
class m_payment extends CI_Model{
    
    public function getAll() {
        $this->db->from("webtransaction");
        return $this->db->get();
    }
    
    public function add($data){
        $simpan = $this->db->insert('webtransaction',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('trans_id', $id);
        $delete = $this->db->delete('webtransaction');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("webtransaction");
        $this->db->where('trans_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('webtransaction', $data);
        return $update;
    }
}
