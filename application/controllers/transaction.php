<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of confirmbayar
 *
 * @author LAB-PC
 */
class transaction extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('m_confirmpay');
        $this->load->library('modul');
    }
    
    public function index(){
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            if($session_data['level'] == "2"){
                $this->load->view('head', $data);
                $this->load->view('menu', $data);
                $this->load->view('transaction/konfirmasi_bayar', $data);
                $this->load->view('foot');
            }
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_list() {
        if($this->session->userdata('logged')){
            $data = array();
            $query = mysql_query("SELECT * FROM webtransaction where trans_status in ('unconfirmed','confirmed') order by trans_status asc, trans_date desc;");
            while ($row = mysql_fetch_array($query)) {
                $val = array();
                $val[] = $row['trans_id'];
                $val[] = '<img src="data:image/jpg;base64,'.$row['trans_receipt'].'" class="img-thumbnail" style="width: 200px; height: auto;">';
                $val[] = $row['trans_status'];
                $val[] = $row['buyer_id'];
                $val[] = $row['trans_date'];
                $val[] = $row['trans_total'];
                if($row['trans_status'] == 'unconfirmed'){
                    $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Confirm" onclick="confirm('."'".$row['trans_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Confirm</a>'
                        .'</div>';
                }else if($row['trans_status'] == 'confirmed'){
                    $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Unconfirm" onclick="unconfirm('."'".$row['trans_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Unconfirm</a>'
                        .'</div>';
                }
                
                $data[] = $val;
            }
            
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function setuju() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == "2"){
                // merubah jd confirm berdasarkan kode
                $kode = $this->uri->segment(3);
                $update = mysql_query("update webtransaction set trans_status = 'confirmed' where trans_id = '".$kode."';");
                if($update == 1){
                    $status = "Confirm success";
                }else{
                    $status = "Confirm failed";
                }
            }else{
                $status = "Not your autority";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function tidaksetuju() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == "2"){
                // merubah jd confirm berdasarkan kode
                $kode = $this->uri->segment(3);
                $update = mysql_query("update webtransaction set trans_status = 'unconfirmed' where trans_id = '".$kode."';");
                if($update == 1){
                    $status = "Unconfirm success";
                }else{
                    $status = "Unconfirm failed";
                }
            }else{
                $status = "Not your autority";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
