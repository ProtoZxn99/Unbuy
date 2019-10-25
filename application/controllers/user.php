<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Yohanes
 */
class user extends CI_Controller{   
    
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->model('m_webuser');
    }
    
    public function index(){
	$session_data = $this->session->userdata('logged');
        $level = $session_data['level'];
        if($level==2){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];

            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('user/index');
            $this->load->view('foot');
        }else{
            $this->modul->pesan_halaman('home',"You don't have the authority to access this page");
        }    
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged')){
            $data = array();
            $list = $this->m_webuser->getAll();
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->user_id;
                $val[] = $row->user_name;
                $val[] = $row->user_email;
                $val[] = $row->user_birth;
                $val[] = $row->user_telephone;
                $val[] = $row->user_address;
                $val[] = $row->user_level;
                if($row->user_level == "-"){
                    $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Unblock" onclick="unblock('."'".$row->user_id."'".')"><i class="glyphicon glyphicon-ok"></i> Unblock</a>'
                        .'</div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Block" onclick="block('."'".$row->user_id."'".')"><i class="glyphicon glyphicon-ok"></i> Block</a>'
                        .'</div>';
                }
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function block() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == 2){
                $userid = $this->uri->segment(3);
                $q_level = mysql_query("SELECT user_level FROM webuser where user_id = '".$userid."';");
                $level = mysql_fetch_array($q_level);
                
                // pindah posisi
                $q_pindah = mysql_query("update webuser set block = '".$level['user_level']."', user_level = '-' where user_id = '".$userid."';");
                if($q_pindah == 1){
                    $status = "User berhasil diblokir";
                }else{
                    $status = "User gagal diblokir";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('home');
        }
        
    }
    
    public function unblock() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == 2){
                $userid = $this->uri->segment(3);
                $q_level = mysql_query("SELECT block FROM webuser where user_id = '".$userid."';");
                $level = mysql_fetch_array($q_level);
                
                // pindah posisi
                $q_pindah = mysql_query("update webuser set block = '-', user_level = '".$level['block']."' where user_id = '".$userid."';");
                if($q_pindah == 1){
                    $status = "Unblock user berhasil";
                }else{
                    $status = "Unblock user gagal";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('home');
        }
    }
}
