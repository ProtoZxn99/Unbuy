<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_itemseller
 *
 * @author Rampa Praditya <PRA-MEDIA.com>
 */
class m_itemseller extends CI_Model{
    
    public function getSeller() {
        $this->db->from("webuser");
        $this->db->where("user_level","1");
        return $this->db->get();
    }
    
    public function get_user_by_id($id){
        $this->db->from("webuser");
        $this->db->where('user_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getItem($kode_seller) {
        $this->db->from("item");
        $this->db->where("user_id",$kode_seller);
        return $this->db->get();
    }
    
    public function delete($id){
        $this->db->where('item_id', $id);
        $delete = $this->db->delete('item');
        return $delete;
    }
}
