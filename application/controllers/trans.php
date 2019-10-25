<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trans
 *
 * @author Rampa Praditya <PRA-MEDIA.com>
 */
class trans extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->model('m_trans');
    }
    
    public function index(){
	$session_data = $this->session->userdata('logged');
        $level = $session_data['level'];
        if(($level==2) || ($level==1)){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];

            // bar atas
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
            $this->load->view('menu', $data);
            $this->load->view('statistic/transaction');
            $this->load->view('foot');
        }else{
            $this->modul->pesan_halaman('home',"You don't have the authority to access this page");
        }    
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $id = $session_data['id'];
            // load data
            $data = array();
            $list = $this->m_trans->getAll($id);
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->trans_id;
                $val[] = $this->modul->tampilGambar($row->trans_receipt);
                $val[] = $row->trans_status;
                $val[] = $row->user_name;
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
