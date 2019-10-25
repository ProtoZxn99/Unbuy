<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_trans
 *
 * @author Rampa Praditya <PRA-MEDIA.com>
 */
class m_trans extends CI_Model{
    
    public function getAll() {
        $this->db->from("webtransaction a");
        $this->db->join("webuser b","a.buyer_id = b.user_id");
        return $this->db->get();
    }
    
    public function getAllDetil($kode_buyer) {
        $this->db->from("webtransaction a");
        $this->db->join("webuser b","a.buyer_id = b.user_id");
        $this->db->where("a.buyer_id", $kode_buyer);
        return $this->db->get();
    }
    
}
