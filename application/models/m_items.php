<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_items
 *
 * @author munil
 */
class m_items extends CI_Model{
    
    public function getAll($kode_user) {
        $this->db->from("item a");
        $this->db->join("webuser b","a.user_id = b.user_id");
        $this->db->where("a.user_id", $kode_user);
        return $this->db->get();
    }
            
    public function add($data){
        $simpan = $this->db->insert('item',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('item_id', $id);
        $delete = $this->db->delete('item');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("item");
        $this->db->where('item_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('item', $data);
        return $update;
    }
}
