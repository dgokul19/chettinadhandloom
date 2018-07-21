<?php
class Templates extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        redirect(base_url('masters/view'),'refresh');
    }
    
    public function view(){
        $data['page_title'] = "View Templates";
        $this->load->view('templates/view_all_templates',$data);
    }

    public function tax_masters(){
        $data['page_title'] = "Tax Masters";
        $this->load->view('masters/tax_masters',$data);
    }
}
