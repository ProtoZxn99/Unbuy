<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_category
 *
 * @author munil
 */
class m_category extends CI_Model{
    
    public function getAll() {
        $this->db->from("category");
        return $this->db->get();
    }
    
    public function add($data){
        $simpan = $this->db->insert('category',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('cat_id', $id);
        $delete = $this->db->delete('category');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("category");
        $this->db->where('cat_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('category', $data);
        return $update;
    }
}
