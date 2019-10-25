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
class home extends CI_Controller{
    
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
        
        $data['query_awal_barang'] = "SELECT *, format(item_price,2) as harga  FROM item order by item_date desc;";
        
        // mencari jumlah user yang sudah registrasi
        $q_jmluser = mysql_query("SELECT count(*) as jml_user FROM webuser where user_level in('0','1');");
        $data['jml_user'] = mysql_fetch_array($q_jmluser)['jml_user'];
        
        // mencari pembeli paling sering beli
        $q_pembeli_loyal = mysql_query("SELECT buyer_id, sum(item_order) as jml_beli 
            FROM webtransaction a, transaction_item b 
            where a.trans_id = b.trans_id 
            group by a.buyer_id order by sum(item_order) desc limit 1;");
        $data_pembeli_loyal = mysql_fetch_array($q_pembeli_loyal);
        
        // mencari nama pembeli
        $kode_pembeli = $data_pembeli_loyal['buyer_id'];
        $q_nama_pembeli = mysql_query("select user_name from webuser where user_id = '".$kode_pembeli."';");
        $nama_pembeli = mysql_fetch_array($q_nama_pembeli)['user_name'];
        $data['nama_user'] = $nama_pembeli;
        
        // mencari barang paling laris
        $q_penjual_pling_laris = mysql_query("select seller_id, count(*) as jml from transaction_item group by seller_id order by count(*) desc limit 1");
        $data_penjual_terlaris = mysql_fetch_array($q_penjual_pling_laris);
        // mencari nama penjual
        $q_nama_penjual = mysql_query("select user_name from webuser where user_id = '".$data_penjual_terlaris['seller_id']."';");
        $nama_penjual = mysql_fetch_array($q_nama_penjual)['user_name'];
        $data['penjual'] = $nama_penjual;
        
        // total transaksi bulan ini
        $q_total_trans_bulan_ini = mysql_query("SELECT count(*) as jml FROM webtransaction where date(trans_date) = '".$this->modul->TangalSekarang()."';");
        $jml_trans_bulan_ini = mysql_fetch_array($q_total_trans_bulan_ini)['jml'];
        $data['jml_trans'] = $jml_trans_bulan_ini;
        
        $this->load->view('head', $data);
        $this->load->view('menu');
        $this->load->view('home/index', $data);
        $this->load->view('foot');
    }
    
    
    function logout(){
        session_start();
        $this->session->unset_userdata('logged');
        session_destroy();
        //$this->session->unset_userdata('cart');
        $this->modul->halaman('home');
    }
}
