<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itemseller
 *
 * @author Rampa Praditya <PRA-MEDIA.com>
 */
class itemseller extends CI_Controller{
    
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->model('m_itemseller');
    }
    
    public function index(){
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            
            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('menu1_admin/seller');
            $this->load->view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged')){
            $data = array();
            $list = $this->m_itemseller->getSeller();
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->user_id;
                $val[] = $row->user_name;
                $val[] = $row->user_email;
                $val[] = $row->user_birth;
                $val[] = $row->user_telephone;
                $val[] = $row->user_address;
                $val[] = '<div style="text-align: center;">'
                        .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Pilih" onclick="pilih('."'".$row->user_id."'".')"><i class="glyphicon glyphicon-ok"></i> Pilih</a>'
                        .'</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function detil(){
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
            $this->load->view('menu1_admin/item_seller',$data);
            $this->load->view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list_item() {
        if($this->session->userdata('logged')){
            $kode_seller = $this->uri->segment(3);
            // load data
            $data = array();
            $list = $this->m_itemseller->getItem($kode_seller);
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->item_id;
                $val[] = $row->item_name;
                $val[] = $row->item_date;
                $val[] = $row->item_price;
                $val[] = $row->item_text;
                $val[] = '<div style="text-align: center;">'
                        .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Delete" onclick="hapus('."'".$row->item_id."'".')"><i class="glyphicon glyphicon-trash"></i> Del</a>'
                        .'</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function hapus() {
        if($this->session->userdata('logged')){
            $kode = $this->uri->segment(3);
            $hapus = $this->m_itemseller->delete($kode);
            if($hapus == 1){
                $status = "Delete success";
            }else{
                $status = "Delete failed";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('home');
        }
    }
}
