<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sellinghistory
 *
 * @author LAB-PC
 */
class sellinghistory extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mtrasn');
        $this->load->model('m_itemseller');
        $this->load->library('modul');
    }
    
    public function index(){
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            if($session_data['level'] == 1){
                $this->load->view('head', $data);
                $this->load->view('menu', $data);
                $this->load->view('history/selling', $data);
                $this->load->view('foot');
            }else if($session_data['level'] == 2){
                $this->load->view('head', $data);
                $this->load->view('menu', $data);
                $this->load->view('history/selling_admin', $data);
                $this->load->view('foot');
            }
            
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_list() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $kode_user = $session_data['id'];
            // load data
            $data = array();
            $list = $this->mtrasn->getAllSelling($kode_user);
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->trans_id;
                $val[] = $row->item_id;
                $val[] = $row->item_name;
                // mencari tanggal berdasarkan transaksi itu
                $q_tgl = mysql_query("SELECT trans_date FROM webtransaction where trans_id = '".$row->trans_id."';");
                $tgl = mysql_fetch_array($q_tgl)['trans_date'];
                $val[] = $tgl;
                $val[] = $row->item_order;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function detil() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            $data['kode_seller'] = $this->uri->segment(3);
            // data user
            $data_user = $this->m_itemseller->get_user_by_id($this->uri->segment(3));
            $data['nama'] = $data_user->user_name;
            $data['alamat'] = $data_user->user_address;
            $data['tlp'] = $data_user->user_telephone;
            
            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('history/selling_admin_detil',$data);
            $this->load->view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list_history() {
        if($this->session->userdata('logged')){
            $kode_penjual = $this->uri->segment(3);
            // load data
            $data = array();
            $list = $this->mtrasn->getJualDetil($kode_penjual);
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->item_id;
                $val[] = $row->item_name;
                $val[] = $row->qty;
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
}
