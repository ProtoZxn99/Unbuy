<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of promo
 *
 * @author LAB-PC
 */
class promo extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->model('m_promo');
    }
    
    public function index(){
	$session_data = $this->session->userdata('logged');
        $level = $session_data['level'];
        if($level==2){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];

            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('promo/index');
            $this->load->view('foot');
        }else{
            $this->modul->pesan_halaman('home',"You don't have the authority to access this page");
        }    
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged')){
            $data = array();
            $list = $this->m_promo->getAll();
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->promo_id;
                $val[] = $row->promo_name;
                $val[] = '<img src="'.$row->promo_image.'" class="img-thumbnail" alt="Picture">';
                $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->promo_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;'
                            .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->promo_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
                        .'</div>';
                
                $data[] = $val;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function ajax_add() {
        if($this->session->userdata('logged')){
            // proses
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
                            $kode = $this->modul->autokode('P','promo_id','promo');
                            $data = array(
                                "promo_id" => $kode,
                                "promo_name" => $this->input->post('promo_name'),
                                "promo_image" => $path
                            );
                            $simpan = $this->m_promo->add($data);
                            if($simpan == 1){
                                $status = "Promotion saved";
                            }else{
                                $status = "Promotion save failed";
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
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if($this->session->userdata('logged')){
            $kode = $this->uri->segment(3);
            $path = $this->m_promo->get_by_id($kode);
            if(file_exists($path->promo_image)){
                unlink($path->promo_image);
            }
            
            $hapus = $this->m_promo->delete($kode);
            if($hapus == 1){
                $status = "Item deleted";
            }else{
                $status = "Item delete failed";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if($this->session->userdata('logged')){
            // klo ada file nya hapus dulu
            $kode = $this->input->post('id');
            $path = $this->m_promo->get_by_id($kode);
            if(file_exists($path->promo_image)){
                unlink($path->promo_image);
            }
            
            // proses
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
                            $data = array(
                                "promo_name" => $this->input->post('promo_name'),
                                "promo_image" => $path
                            );
                            $condisi['promo_id'] = $kode;
                            $simpan = $this->m_promo->update($data, $condisi);
                            if($simpan == 1){
                                $status = "Promotion saved";
                            }else{
                                $status = "Promotion save failed";
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
            $this->modul->halaman('login');
        }
    }
    
    public function detil() {
        if($this->session->userdata('logged')){
            $id = $this->uri->segment(3);
            $data = $this->m_promo->get_by_id($id);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
}
