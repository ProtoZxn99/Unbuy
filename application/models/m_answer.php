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
class m_answer extends CI_Model{
    
    public function getAll() {
        $this->db->from("answer");
        return $this->db->get();
    }
    
    public function get_by_question($id){
        $this->db->from("answer");
        $this->db->where('question_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function add($data){
        $simpan = $this->db->insert('answer',$data);
        return $simpan;
    }
    
    public function delete($id){
        $this->db->where('answer_id', $id);
        $delete = $this->db->delete('item');
        return $delete;
    }
    
    public function get_by_id($id){
        $this->db->from("answer");
        $this->db->where('answer_id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function update($data, $condition){
        $this->db->where($condition);
        $update = $this->db->update('answer', $data);
        return $update;
    }
}
