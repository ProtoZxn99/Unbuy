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
class payment extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->model('m_payment');
    }
    
    public function index(){
        session_start();
        $session_data = $this->session->userdata('logged');
        $data['user'] = $session_data['id'];
        $data['name'] = $session_data['name'];
        $data['level'] = $session_data['level'];
        $this->load->view('head', $data);
        $this->load->view('menu', $data);
        $this->load->view('payment/index.php');
        $this->load->view('foot');  
    }
    
    public function proses() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $kode_user = $session_data['id'];
            $config['upload_path'] = './img/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
            $config['max_filename'] = '255';
            $config['encrypt_name'] = FALSE;
            $config['max_size'] = '3024'; //3 MB

            if (isset($_FILES['file']['name'])) {
                if(0 < $_FILES['file']['error']) {
                    $status = "Error during file upload ".$_FILES['file']['error'];
                }else{
                    $path = './img/'.str_replace(" ", "_", $_FILES['file']['name']);
                    if(file_exists($path)) {
                        $status = "File already exists ".str_replace(" ", "_", $_FILES['file']['name']);
                    } else {
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('file')) {
                            $kode_trans = $this->modul->autokode('T','trans_id','webtransaction');
                            $image_string = $this->modul->image_text($path);
                            $data = array(
                                'trans_id' => $kode_trans,
                                'trans_receipt' => $image_string,
                                'trans_status' => 'unconfirmed',
                                'buyer_id' => $kode_user,
                                'trans_date' => $this->modul->TanggalWaktu(),
                                'trans_total' => $this->input->post('total')
                            );
                            $simpan = $this->m_payment->add($data);
                            if($simpan == 1){
                                unlink($path); // hapus file
                                $status = $kode_trans;
                            }  else {
                                $status = "Transaction save failed";
                            }
                        } else {
                            $status = $this->upload->display_errors();
                        }
                    }
                }
            }else{
                $status = "Please choose a file";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function proses1() {
        if($this->session->userdata('logged')){
            $kode_trans = $this->uri->segment(3);
            $data_item_id = $this->input->post('item_id');
            $data_item_order = $this->input->post('item_order');
            $data_seller_id = $this->input->post('seller_id');
            
            for($i=0; $i<count($data_item_id); $i++){
                mysql_query("insert into transaction_item values ('".$kode_trans."','".$data_item_id[$i]."','".$data_item_order[$i]."','".$data_seller_id[$i]."');");
            }
            $status = "Transaction saved";
                    
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function kembalihome() {
        session_start();
        unset($_SESSION['cart']);
        $this->modul->halaman('home');
    }
    
}
