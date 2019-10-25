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
class m_item extends CI_Model{
    
    public function getBarang($kode_user) {
        $this->db->from("item");
        $this->db->where("user_id", $kode_user);
        return $this->db->get();
    }
    
    public function getAll() {
        $this->db->from("category_item");
        return $this->db->get();
    }
    
    public function get_stock($id){
        $this->db->from("item");
        $this->db->where($id);
        return $this->db->get();
    }
    
    public function get_by_item($id){
        $this->db->from("item");
        $this->db->where('item_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_cat($id){
        $this->db->from("category_item");
        $this->db->where('cat_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function add($data){
        $simpan = $this->db->insert('category_item',$data);
        return $simpan;
    }
    
    public function delete_item($id){
        $this->db->where('item_id', $id);
        $delete = $this->db->delete('category_item');
        return $delete;
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('item', $data);
        return $update;
    }
}
