<?php
class Newsfeed extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function subcripstion_list(){
        $post_data = $this->input->post('post_data');
        $post_data = "auto"; 
        if(!empty($post_data)){
            $subs = $this->ch_model->get_all(NEWS_LETTER_SUBSCRIBERS);
            $json = ['status'=>'success','msg'=>$subs];
        }else{
            $json = ['status'=>"failed",'msg'=>"No Inputs"];
        }        
        echo json_encode($json);
    }
    
    public function subscribe_newsletter(){

        if(isset($_GET['data'])){
            $obj = $_GET['data'];
            $tmp = json_decode($obj,true);
            
            echo json_encode(['status'=>'success','response'=>$tmp['data']]);
        }else{
            echo json_encode(['msg'=>'URL HITTED']);
        }
die;
        
//        $get = $_GET['data'];
         // echo $_GET['data'];die;
        
        $post_data = $this->input->post('post_data');
        if(!empty($post_data)){
            $json = $post_data;
        }else{
            $json = ['status'=>"failed",'msg'=>"No Inputs"];
        }        
        echo json_encode($json);
    }
    
}