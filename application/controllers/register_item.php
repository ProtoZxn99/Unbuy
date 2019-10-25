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
class register_item extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->model('m_items');
    }
    
    public function index(){
        session_start();
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            
            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('register_item/index');
            $this->load->view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_list() {
        if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $kode_user = $session_data['id'];
            // load
            $data = array();
            $list = $this->m_items->getAll($kode_user);
            foreach ($list->result() as $row) {
                $val = array();
                $val[] = $row->item_id;
                $val[] = $row->item_name;
                $val[] = $row->item_date;
                $val[] = $row->item_price;
                $val[] = $this->modul->tampilGambar($row->item_photo);
                $val[] = $row->item_stock;
                $val[] = $row->item_text;
                $val[] = '<div style="text-align: center;">'
                            .'<a class="btn btn-xs btn-primary" href="javascript:void(0)" title="Edit" onclick="ganti('."'".$row->item_id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>&nbsp;'
                            .'<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus('."'".$row->item_id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>'
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
                            $kode_item = $this->modul->autokode('I','item_id','item');
                            $image_string = $this->modul->image_text($path);
                            $data = array(
                                'item_id' => $kode_item,
                                'item_name' => $this->input->post('item_name'),
                                'item_date' => $this->modul->TanggalWaktu(),
                                'item_price' => $this->input->post('item_price'),
                                'item_photo' => $image_string,
                                'user_id' => $kode_user,
                                'item_stock' => $this->input->post('item_stock'),
                                'item_text' => $this->input->post('item_text')
                            );
                            $simpan = $this->m_items->add($data);
                            if($simpan == 1){
                                // simpan juga linknya
                                $data_cat_id = $this->input->post('cat_id');
                                $panjang_cat_id = strlen($data_cat_id)-1;
                                $data_array = explode("~", substr($data_cat_id, 0, $panjang_cat_id));
                                // simpan kategori barangnya
                                for($i=0; $i<count($data_array); $i++){
                                    mysql_query("insert into category_item values ('".$data_array[$i]."','".$kode_item."');");
                                }
                                unlink($path); // hapus file
                                
                                $status = "Data save successful";
                            }  else {
                                $status = "Data save failed";
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
    
    public function hapus() {
        if($this->session->userdata('logged')){
            $kode_item = $this->uri->segment(3);
            $hapus = $this->m_items->delete($kode_item);
            if($hapus == 1){
                $status = "Item delete successful";
            }else{
                $status = "Item delete failed";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('home');
        }
    }
    
    public function detil() {
        if($this->session->userdata('logged')){
            $id = $this->uri->segment(3);
            $data = $this->m_items->get_by_id($id);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
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
                            $kode_item = $this->input->post('id');
                            $image_string = $this->modul->image_text($path);
                            $data = array(
                                'item_name' => $this->input->post('item_name'),
                                'item_date' => $this->modul->TanggalWaktu(),
                                'item_price' => $this->input->post('item_price'),
                                'item_photo' => $image_string,
                                'user_id' => $kode_user,
                                'item_stock' => $this->input->post('item_stock'),
                                'item_text' => $this->input->post('item_text')
                            );
                            $kondisi['item_id'] = $kode_item;
                            $simpan = $this->m_items->update($data, $kondisi);
                            if($simpan == 1){
                                mysql_query("delete from category_item where item_id = '".$kode_item."';");
                                // simpan juga linknya
                                $data_cat_id = $this->input->post('cat_id');
                                $panjang_cat_id = strlen($data_cat_id)-1;
                                $data_array = explode("~", substr($data_cat_id, 0, $panjang_cat_id));
                                // simpan kategori barangnya
                                for($i=0; $i<count($data_array); $i++){
                                    mysql_query("insert into category_item values ('".$data_array[$i]."','".$kode_item."');");
                                }
                                unlink($path); // hapus file
                                
                                $status = "Data update successful";
                                
                            }  else {
                                $status = "Data update failed";
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
}
