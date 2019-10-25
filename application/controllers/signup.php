<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author Patrick
 */
class signup extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->library('enigma_c');
        $this->load->model('m_webuser');
    }
    
    public function index(){
        $this->load->view('signup/index');
    }
    
    public function register() {
        // cek apakah email tersebut sudah pernah mendaftar
        $q_cek = mysql_query("SELECT count(*) as jml FROM webuser where user_email = '".$this->input->post('txt_email')."';");
        $data_cek = mysql_fetch_array($q_cek);
        if($data_cek['jml'] > 0){
            $this->modul->pesan_halaman("User email already register",'signup');
        }else{
            $data = array(
                'user_id' => $this->modul->autokode('U','user_id','webuser'),
                'user_name' => $this->input->post('txt_user'),
                'user_password' => $this->enigma_c->enigma($this->input->post('txt_pass'), true),
                'user_email' => $this->input->post('txt_email'),
                'user_birth' => $this->input->post('txt_bd'),
                'user_date' => $this->modul->TanggalWaktu(),
                'user_telephone' => $this->input->post('txt_tel'),
                'user_level' => $this->input->post('mode'),
                'user_address' => $this->input->post('txt_address')
            );
            $simpan = $this->m_webuser->add($data);
            if($simpan == 1){
                $sess_array = array('id' => $data['user_id'], 'name' => $this->input->post('txt_user'), 'level' => "0");
                $this->session->set_userdata('logged', $sess_array);

                $status = "Welcome to unbuy!";
                $this->modul->pesan_halaman($status,'home');
            }else{
                $status = "Data failed to save";
                $this->modul->pesan_halaman($status,'signup');
            }
        }
    }
}
