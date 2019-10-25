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
class m_rating extends CI_Model{
    
    public function getAll() {
        $this->db->from("rating");
        return $this->db->get();
    }
    
    public function get_by_item($id){
        $this->db->from("rating");
        $this->db->where('item_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function add($data){
        $simpan = $this->db->insert('rating',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('rating_id', $id);
        $delete = $this->db->delete('rating');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("rating");
        $this->db->where('rating_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('rating', $data);
        return $update;
    }
}
