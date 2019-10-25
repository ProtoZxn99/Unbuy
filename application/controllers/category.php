<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author munil
 */
class category extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('m_category');
        $this->load->library('modul');
    }
    
    public function index(){
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            
            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('category/index', $data);
            $this->load->view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }

    public function ajax_list() {
        if($this->session->userdata('logged')){
            $data = array();
            $list = $this->m_category->getAll();
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->cat_id;
                $val[] = $row->cat_name;
                $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->cat_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;'
                            .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->cat_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
                        .'</div>';
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if($this->session->userdata('logged')){
            $q_cek = mysql_query("SELECT count(*) as jml FROM category where cat_name = '".$this->input->post('cat_name')."';");
            $data_cek = mysql_fetch_array($q_cek);
            if($data_cek['jml'] > 0){
                $status = "Data already exists";
            }else{
                $data = array(
                    'cat_id' => $this->modul->autokode('C','cat_id','category'),
                    'cat_name' => $this->input->post('cat_name')
                );
                $simpan = $this->m_category->add($data);
                if($simpan == 1){
                    $status = "Data saved successfully";
                }else{
                    $status = "Data save failed";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->session->userdata('logged')){
            $kode = $this->uri->segment(3);
            $hapus = $this->m_category->delete($kode);
            if($hapus == 1){
                $status = "Data deleted";
            }else{
                $status = "Data failed deleted";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function detil() {
        if($this->session->userdata('logged')){
            $id = $this->uri->segment(3);
            $data = $this->m_category->get_by_id($id);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged')){
            $kode = $this->input->post('id');
            $q_cek = mysql_query("SELECT count(*) as jml FROM category where cat_id = '".$kode."';");
            $data_cek = mysql_fetch_array($q_cek);
            if($data_cek['jml'] > 0){
                $data = array(
                    'cat_name' => $this->input->post('cat_name')
                );
                $condition['cat_id'] = $kode;
                $update = $this->m_category->update($data, $condition);
                if($update == 1){
                    $status = "Data was updated successfully";
                }else{
                    $status = "Data failed update";
                }
            }else{
                $status = "Data tidak ditemukan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
}
