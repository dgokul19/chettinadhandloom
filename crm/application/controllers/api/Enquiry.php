<?php

class Enquiry extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function submit(){
        if(isset($_POST) && !empty($_POST)){
            $req_obj = file_get_contents("php://input");;
            $req_Arr = json_decode($req_obj,true);
            
            if(empty($req_Arr)){
                $json = ['status'=>"failed",'msg'=>"Error in decoding JSON parameter"];
                echo json_encode($json);
                die;
            }
            
            $inser_arr = [
                'en_name'=>$req_Arr['name'],
                'en_email_id'=>$req_Arr['email'],
                'en_phone'=>$req_Arr['phone'],
                'en_msg'=>$req_Arr['msg']
            ];
            
            $chk_ph = $this->ch_model->get_all(WEB_ENQUIRIES,['en_phone'=>$req_Arr['phone']]);
            if($chk_ph->num_rows() == 0){
                $sql = $this->ch_model->simple_insert(WEB_ENQUIRIES,$inser_arr);
            }else{
                $sql = $this->ch_model->simple_update(WEB_ENQUIRIES,$inser_arr,['id'=>$chk_ph->row()->id]);
            }
            
            if($sql){
                $json = ['status'=>"success",'msg'=>"Enquiry received"];
                echo json_encode($json);
            }else{
                $json = ['status'=>"failed",'msg'=>"internal server error","error_code"=>"500"];
                echo json_encode($json);
            }         
        }else{
            $json = ['status'=>"failed",'msg'=>"No Inputs"];
            echo json_encode($json);
        }        
        
    }
    
}