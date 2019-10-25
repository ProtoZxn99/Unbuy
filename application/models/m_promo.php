<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_promo
 *
 * @author LAB-PC
 */
class m_promo extends CI_Model{
    
    public function getAll() {
        $this->db->from("promo");
        return $this->db->get();
    }
    
    public function add($data){
        $simpan = $this->db->insert('promo',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('promo_id', $id);
        $delete = $this->db->delete('promo');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("promo");
        $this->db->where('promo_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('promo', $data);
        return $update;
    }
}
