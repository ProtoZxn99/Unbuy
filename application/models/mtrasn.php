<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mtrasn
 *
 * @author LAB-PC
 */
class mtrasn extends CI_Model{
    
    public function getAll($kode_user) {
        $this->db->from("webtransaction");
        $this->db->where("buyer_id", $kode_user);
        return $this->db->get();
    }
    
    public function getAllSelling($kode_user) {
        $this->db->from("transaction_item a");
        $this->db->join("item b","a.item_id = b.item_id");
        $this->db->where("seller_id", $kode_user);
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
    
    public function getJualDetil($kode_penjual) {
        $this->db->select("a.item_id, b.item_name, sum(a.item_order) as qty");
        $this->db->from("transaction_item a");
        $this->db->join("item b","a.item_id = b.item_id");
        $this->db->where("a.seller_id",$kode_penjual);
        $this->db->group_by("a.item_id");
        return $this->db->get();
    }
}
