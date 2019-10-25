<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transactionsend
 *
 * @author LAB-PC
 */
class transactionsend extends CI_Controller{
    
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
            if($session_data['level'] == "1"){
                $this->load->view('head', $data);
                $this->load->view('menu', $data);
                $this->load->view('transaction/konfirmasi_sending', $data);
                $this->load->view('foot');
            }
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_list() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $user = $session_data['id'];
            // load data
            $data = array();
            $query = mysql_query("SELECT distinct a.trans_id, trans_receipt, trans_status, buyer_id, trans_date, trans_total FROM webtransaction a, transaction_item b where a.trans_id = b.trans_id and b.seller_id = '".$user."' and a.trans_status in('confirmed','sending');");
            while ($row = mysql_fetch_array($query)) {
                $val = array();
                $val[] = $row['trans_id'];
                $val[] = '<img src="data:image/jpg;base64,'.$row['trans_receipt'].'" class="img-thumbnail" style="width: 200px; height: auto;">';
                $val[] = $row['trans_status'];
                $val[] = $row['buyer_id'];
                $val[] = $row['trans_date'];
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
                $q_detil = mysql_query("SELECT * FROM transaction_item where trans_id = '".$row['trans_id']."' and seller_id = '".$user."';");
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
                if($row['trans_status'] == 'confirmed'){
                    $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Sending" onclick="sending('."'".$row['trans_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Sending</a>'
                        .'</div>';
                }else if($row['trans_status'] == 'sending'){
                    $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Cancel Sending" onclick="cancelsending('."'".$row['trans_id']."'".')"><i class="glyphicon glyphicon-pencil"></i> Cancel Sending</a>'
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
    
    public function sending() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == "1"){
                // merubah jd confirm berdasarkan kode
                $kode = $this->uri->segment(3);
                $update = mysql_query("update webtransaction set trans_status = 'sending' where trans_id = '".$kode."';");
                if($update == 1){
                    $status = "Sending success";
                }else{
                    $status = "Sending failed";
                }
            }else{
                $status = "Not your autority";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function cancelsending() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == "1"){
                // merubah jd confirm berdasarkan kode
                $kode = $this->uri->segment(3);
                $update = mysql_query("update webtransaction set trans_status = 'confirmed' where trans_id = '".$kode."';");
                if($update == 1){
                    $status = "Sending canceled";
                }else{
                    $status = "Sending cancel failed";
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
