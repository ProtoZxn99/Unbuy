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
class m_question extends CI_Model{
    
    public function getAll() {
        $this->db->from("question");
        return $this->db->get();
    }
    
    public function get_by_user($id){
        $this->db->from("question");
        $this->db->where('user_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_by_item($id){
        $this->db->from("question");
        $this->db->where('item_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function add($data){
        $simpan = $this->db->insert('question',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('question_id', $id);
        $delete = $this->db->delete('question');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("question");
        $this->db->where('question_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('question', $data);
        return $update;
    }
}
