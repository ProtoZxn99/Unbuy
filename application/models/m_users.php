<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_users
 *
 * @author Rampa Praditya <PRA-MEDIA.com>
 */
class m_users extends CI_Model{
    
    public function getAll() {
        $level = array('1', '0');
        
        $this->db->from("webuser");
        $this->db->where_in('user_level', $level);
        return $this->db->get();
    }
    
    public function getAllPembeli() {
        $level = array('0');
        
        $this->db->from("webuser");
        $this->db->where_in('user_level', $level);
        return $this->db->get();
    }
}
