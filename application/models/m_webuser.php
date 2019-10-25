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
class m_webuser extends CI_Model{
    
    public function getAll() {
        $this->db->from("webuser");
        return $this->db->get();
    }
            
    public function add($data){
        $simpan = $this->db->insert('webuser',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('user_id', $id);
        $delete = $this->db->delete('webuser');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("webuser");
        $this->db->where('user_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('webuser', $data);
        return $update;
    }
}
