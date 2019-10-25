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
class cart extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
    }
    
    public function index(){
        $session_data = $this->session->userdata('logged');
        $data['user'] = $session_data['id'];
        $data['name'] = $session_data['name'];
        $data['level'] = $session_data['level'];
        session_start();
        $this->load->view('head', $data);
        $this->load->view('menu', $data);
        $this->load->view('cart/index.php');
        $this->load->view('foot');
        
    }
    
    public function setcart(){
        session_start();
        $id = $this->uri->segment(3);
        $qty = $this->uri->segment(4);
        $q_item = mysql_query("select item_stock from item where item_id = '".$id."';");
        $stock = mysql_fetch_array($q_item);
        if($stock[0]<$qty){
            $qty=$stock[0];
        }    
        $_SESSION['cart'][$id] = $qty;
        if($_SESSION['cart'][$id]<1){
            unset($_SESSION['cart'][$id]);
        }
    }
    
    public function cek_login_as_buyer() {
        $status = "";
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $level = $session_data['level'];
            if($level == 0){
                $status = "ok";
            }else{
                $status = "Please login as buyer";
            }
        }else{
            $status = "Please login first";
        }
        echo json_encode(array("status" => $status));
    }
    
}
