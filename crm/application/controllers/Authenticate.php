<?php
class Login extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
//        echo "asd";die();
        redirect(base_url('login'),'refresh');
    }
    
    public function login(){
        echo "loaded";
    }
    
}
