<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class search extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        
    }
    
    public function index(){
        session_start();
        $session_data = $this->session->userdata('logged');
        $data['user'] = $session_data['id'];
        $data['name'] = $session_data['name'];
        $data['level'] = $session_data['level'];
        $data['query_awal_barang'] = "SELECT *, format(item_price,2) as harga FROM item order by item_date desc;";
        $this->load->view('head', $data);
        $this->load->view('menu', $data);
        $this->load->view('search/index');
        $this->load->view('foot');
    }
    
    public function item() {
        session_start();
        $session_data = $this->session->userdata('logged');
        $data['name'] = $session_data['name'];
        $data['level'] = $session_data['level'];
        $nama_barang = $this->input->post('pencarian');
        $data['query_awal_barang'] = "SELECT *, format(item_price,2) as harga FROM item where item_name like '%".$nama_barang."%' order by item_date desc;";
        $this->load->view('head', $data);
        $this->load->view('menu');
        $this->load->view('search/index');
        $this->load->view('foot');
    }
    
    public function detail() {
        session_start();
        $id = $this->uri->segment(3);
        $q_data = mysql_query("select * from item where item_id = '".$id."';");
        $data = mysql_fetch_array($q_data);
        
        $q_user = mysql_query("select user_name from webuser where user_id = '".$data['user_id']."';");
        $d_user = mysql_fetch_array($q_user);
        $data['user_name'] = $d_user['user_name'];
        $data['qty'] = '0';
        if(isset($_SESSION['cart'][$id])){
            $data['qty'] = $_SESSION['cart'][$id];
        }
        echo json_encode($data);
    }
    
    public function cart() {
        session_start();
        $id = $this->input->post('form_id');
        $quantity = $this->input->post('form_quantity');
        
            $q_item = mysql_query("select item_stock from item where item_id = '".$id."';");
            $stock = mysql_fetch_array($q_item);

            if(isset($_SESSION['cart'][$id])){
                $quantity = $_SESSION['cart'][$id] + $quantity;
            }

            if($stock[0]<$quantity){
               $quantity = $stock[0]; 
            }
            if($quantity>0){
                $_SESSION['cart'][$id] = $quantity;
            }
        $status = "";

        foreach ($_SESSION['cart'] as $item=>$item_q) {
            $status .= $_SESSION['cart'][$item];
        }
        echo json_encode(array("status" => $status));
    }
 
    public function gambar() {
        $kode = $this->uri->segment(3);
        $q_gambar = mysql_query("SELECT item_photo FROM item where item_id = '".$kode."';");
        $data_gambar = mysql_fetch_array($q_gambar)['item_photo'];
        if(strlen($data_gambar) > 0){
            $status = "data:image/jpg;base64,".$data_gambar;
        }else{
            $status = base_url()."img/B0001.jpg";
        }
        echo json_encode(array("status1" => $status));
    }
}
