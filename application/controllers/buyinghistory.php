<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of buyinghistory
 *
 * @author LAB-PC
 */
class buyinghistory extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('mtrasn');
        $this->load->model('m_trans');
        $this->load->model('m_users');
        $this->load->model('m_itemseller');
        $this->load->library('modul');
    }
    
    public function index(){
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            $data['user'] = $session_data['id'];
            
            if($session_data['level'] == 0){
                $this->load->view('head', $data);
                $this->load->view('menu', $data);
                $this->load->view('history/buying', $data);
                $this->load->view('foot');
            }else if($session_data['level'] == 2){
                $this->load->view('head', $data);
                $this->load->view('menu', $data);
                $this->load->view('history/buying_admin', $data);
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
            $list = $this->mtrasn->getAll($kode_user);
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->trans_id;
                $val[] = '<img src="data:image/jpg;base64,'.$row->trans_receipt.'" class="img-thumbnail" style="width: 200px; height: auto;">';
                $val[] = $row->trans_status;
                $val[] = $row->trans_date;
                $val[] = $row->trans_total;
                $temp = '<table id="example" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>';
                $temp .= '</tbody>';
                $q_detil = mysql_query("SELECT * FROM transaction_item where trans_id = '".$row->trans_id."';");
                while ($row1 = mysql_fetch_array($q_detil)) {
                    // mencari nama item
                    $q_nama_item = mysql_query("select item_name from item where item_id = '".$row1['item_id']."';");
                    $nama_item = mysql_fetch_array($q_nama_item)['item_name'];
                    
                    $temp .= '<tr>';
                    $temp .= '<td>'.$row1['item_id'].'</td>';
                    $temp .= '<td>'.$nama_item.'</td>';
                    $temp .= '<td>'.$row1['item_order'].'</td>';
                    $temp .= '</tr>';
                }
                $temp .= '</table>';
                $val[] = $temp;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list_cust() {
        if($this->session->userdata('logged')){
            $data = array();
            $list = $this->m_users->getAllPembeli();
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
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            $data['user'] = $session_data['id'];
            $data['kode_pembeli'] = $this->uri->segment(3);
            // data user
            $data_user = $this->m_itemseller->get_user_by_id($this->uri->segment(3));
            $data['nama'] = $data_user->user_name;
            $data['alamat'] = $data_user->user_address;
            $data['tlp'] = $data_user->user_telephone;
            
            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('history/buying_admin_detil', $data);
            $this->load->view('foot');
            
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list_history() {
        if($this->session->userdata('logged')){
            $data = array();
            $list = $this->m_trans->getAllDetil($this->uri->segment(3));
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->trans_id;
                $val[] = $row->trans_status;
                $val[] = $row->trans_date;
                $val[] = $row->trans_total;
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('home');
        }
    }
}
