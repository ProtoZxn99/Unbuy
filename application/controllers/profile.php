<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profile
 *
 * @author LAB-PC
 */
class profile extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->library('modul');
        $this->load->library('upload');
        $this->load->model('m_webuser');
    }
    
    public function index(){
	if($this->session->userdata('logged')){
            $session_data = $this->session->userdata('logged');
            $data['user'] = $session_data['id'];
            $data['name'] = $session_data['name'];
            $data['level'] = $session_data['level'];
            
            // menampilkan data yang sudah login
            $q_data = mysql_query("SELECT * FROM webuser where user_id = '".$session_data['id']."';");
            $data_user = mysql_fetch_array($q_data);
            $data['id'] = $data_user['user_id'];
            $data['nama'] = $data_user['user_name'];
            $data['email'] = $data_user['user_email'];
            $data['tgllahir'] = $data_user['user_birth'];
            $data['tlp'] = $data_user['user_telephone'];
            $data['alamat'] = $data_user['user_address'];
            $data['bank'] = $data_user['user_bank'];
            
            $this->load->view('head', $data);
            $this->load->view('menu', $data);
            $this->load->view('profile/index', $data);
            $this->load->view('foot');
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function proses() {
        if($this->session->userdata('logged')){
            $q_cek = mysql_query("SELECT count(*) as jml FROM webuser where user_id = '".$this->input->post('id')."';");
            $data_cek = mysql_fetch_array($q_cek);
            if($data_cek['jml'] > 0){
                $update = $this->update();
                if($update == 1){
                    $status = "Data update successful";
                }else{
                    $status = "Data update failed";
                }
            }else{
                $simpan = $this->simpan();
                if($simpan == 1){
                    $status = "Data save successful";
                }else{
                    $status = "Data save failed";
                }
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function simpan() {
        $data = array(
            "user_id" => $this->modul->autokode('U','user_id','webuser'),
            "user_name" => $this->input->post('username'),
            "user_email" => $this->input->post('user_email'),
            "user_birth" => $this->input->post('birth_date'),
            "user_telephone" => $this->input->post('user_telephone'),
            "user_address" => $this->input->post('user_address'),
            "user_bank" => $this->input->post('user_bank')
        );
        $simpan = $this->m_webuser->add($data);
        return $simpan;
    }
    
    public function update() {
        $data = array(
            "user_name" => $this->input->post('username'),
            "user_email" => $this->input->post('user_email'),
            "user_birth" => $this->input->post('birth_date'),
            "user_telephone" => $this->input->post('user_telephone'),
            "user_address" => $this->input->post('user_address'),
            "user_bank" => $this->input->post('user_bank')
        );
        $kondisi['user_id'] = $this->input->post('id');
        $update = $this->m_webuser->update($data, $kondisi);
        return $update;
    }
    
    public function simpangambar() {
        $session_data = $this->session->userdata('logged');
        $username = $session_data['id'];
            
        $config['upload_path'] = './assets/lampiran/'; //path folder
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload

        $this->upload->initialize($config);
        if(!empty($_FILES['file']['name'])){

            if ($this->upload->do_upload('file')){
                $gbr = $this->upload->data();
                //Compress Image
                $config['image_library']='gd2';
                $path = './assets/lampiran/'.$gbr['file_name'];
                $config['source_image'] = './assets/lampiran/'.$gbr['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['quality']= '50%';
                $config['width']= 350;
                $config['height']= 350;
                $config['new_image']= './assets/lampiran/'.$gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                // simpan ke database
                $file_asli = $this->modul->image_text($path);
                mysql_query("update webuser set user_photo = '".$file_asli."' where user_id = '".$username."';");
                // hapus setelah disimpan
                unlink($path);

                $status = "Image uploaded";
            }
        }else{
            $status = "Image empty";
        }
        echo json_encode(array("status" => $status));
    }
}
