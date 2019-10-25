<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of coba
 *
 * @author munil
 */
class coba extends CI_Controller{
    
    public function index() {
        session_start();
        
        $_SESSION['cart'] = array();
        $_SESSION['cart'][] = "Kursi";
        $_SESSION['cart'][] = "Meja";
        $_SESSION['cart'][] = "Komputer";
        
        
        for($i=0; $i<count($_SESSION['cart']); $i++)
        {
            echo $_SESSION['cart'][$i];
        }
    }
}
