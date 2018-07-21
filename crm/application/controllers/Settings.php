<?php
class Settings extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        redirect(base_url('settings/general-settings'),'refresh');
    }
    
    public function general_settings(){
        $data['page_title'] = "General Settings";
        $this->load->view('settings/general_settings',$data);
    }

    public function tax_masters(){
        $data['page_title'] = "Tax Masters";
        $data['data'] = $this->app_model->get_all(SETTINGS_MATERIAL_TYPE);
        $this->load->view('settings/tax_masters',$data);
    }

    public function quantity_settings(){
        $data['page_title'] = "Qunatity Settings";
        $data['data'] = $this->app_model->get_all(SETTINGS_MATERIAL_TYPE);
        $this->load->view('settings/quantity_settings',$data);
    }

    /* ----- Material Type -----*/
    public function material_type(){
        $data['data'] = $this->app_model->get_all(SETTINGS_MATERIAL_TYPE);
        $data['page_title'] = "Material Type";
        $this->load->view('settings/material_type',$data);
    }
    
    public function add_new_material_type(){
        if($_POST){
            $mt_name = $this->input->post('mt_name');
            $mt_amount = $this->input->post('mt_amount');
            $comments = $this->input->post('comments');
            if(!empty($mt_name) && !empty($mt_amount)){
                $arr = [
                    'material_name'=>$mt_name,
                    'comments'=>$comments,
                    'unit_price'=>$mt_amount
                ];
                $sql = $this->app_model->simple_insert(SETTINGS_MATERIAL_TYPE,$arr);
                // $sql=False;
                if($sql){
                    $this->session->set_flashdata('success_alert', 'Material type added successfully');
                }else{
                    $this->session->set_flashdata('error_alert', 'Error Occured. Please try again.');
                }
            }
        }
        redirect(base_url('settings/material-type'),'refresh');
    }

    public function erase_material_type(){
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $id = $_POST['id'];
            $sql= $this->app_model->simple_delete(SETTINGS_MATERIAL_TYPE,['id'=>$id]);
            if($sql){
                $json = ['status'=>'success','msg'=>'Record Deleted'];
            }else{
                $json = ['status'=>'failure','msg'=>'Internal server error'];
            }
        }else{
            $json = ['status'=>'error','msg'=>'unknown_arg'];
        }
        echo json_decode($json);
    }

}
