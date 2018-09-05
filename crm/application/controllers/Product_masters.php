<?php
class Product_masters extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        redirect(base_url('product-masters/category-masters'),'refresh');
    }

    public function category(){
        $data['page_title'] = 'categoty masters';
        $data['data'] = $this->app_model->get_all(PRODUCT_CATEGORY);
        $this->load->view('products/masters/category_masters',$data);
    }
    
}
