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
class login extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->library('enigma_c');
    }
    
    public function index(){
        $this->load->view('login/index');
    }
    
    public function process() {
        session_start();
        $user = $this->input->post('txt_user');
        $pass = $this->input->post('txt_pass');
        $pass1 = $this->enigma_c->enigma($pass, true);
        $q_cek = mysql_query("SELECT count(*) as jml FROM webuser where user_email = '".$user."' and user_password = '".$pass1."';");
        $data_cek = mysql_fetch_array($q_cek);
        if($data_cek['jml'] > 0){
            $q_data = mysql_query("SELECT user_id, user_name, user_email, user_level FROM webuser where user_email = '".$user."' and user_password = '".$pass1."';");
            $data_user = mysql_fetch_array($q_data);
            
            if($data_user['user_level'] == '-'){
                $this->modul->halaman('login');
            }else{
                $sess_array = array('id' => $data_user['user_id'], 'name' => $data_user['user_name'], 'level' => $data_user['user_level']);
                $this->session->set_userdata('logged', $sess_array);
                $this->modul->halaman('home');
            }
        }else{
            $this->modul->halaman('login');
        }
        
    }
    
    public function forgot(){
        $email = 'a@a.com';
        $msg = $this->input->post('emailreset');
        mail($email, 'Reset Password', $msg);
        $this->modul->pesan_halaman('We will be contacting you soon!','home');
    }
}
