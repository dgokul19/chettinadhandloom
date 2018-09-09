<?php

class Master extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    private function first_run($method,$req_all=true){
        $req_obj = file_get_contents("php://input");
        $req_Arr = json_decode($req_obj,true);
        
        if($_SERVER['REQUEST_METHOD'] != $method){
            $json = ['status'=>"failed",'err_code'=>'invalid_request_method','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
        
        if($req_all == true){
            
            if(empty($req_Arr)){
                $json = ['status'=>"failed",'err_code'=>'invalid_request','msg'=>"Incorrect Request"];
                echo json_encode($json);
                die;
            }
            
            $i=0;$empty_key=[];
            foreach($req_Arr as $index=>$value){
                if(empty($value)){
                    $empty_key[$i] = $index;
                    $i++;
                }
            }

            if(!empty($empty_key)){
                $json = ['status'=>"failed",'err_code'=>'invalid_request_value','msg'=>"Empty values in request",'empty_index'=>$empty_key];
                echo json_encode($json);
                die;
            }
        }
        
        return $req_Arr;
    }
    
    public function getCountries(){
        $api_req = $this->first_run('GET',false);
        $sql = $this->app_model->ExecuteQuery("SELECT id,sortname, name, phonecode FROM `ch_master_countries`");
        $i=0;$data=[];
        foreach ($sql->result() as $key){
            $data[$i] = [
                'id' => $key->id,
                'sortname' => $key->sortname,
                'name' => $key->name,
                'phonecode' => $key->phonecode
            ];
            $i++;
        }
        $json = ['status'=>"success","err_code"=>NULL,"data"=>$data];
        echo json_encode($json);
    }
    
    public function getStates(){
        $api_req = $this->first_run('GET',FALSE);
        $country_id = $_GET['id'];
        if(!empty($country_id)){
            $sql = $this->app_model->ExecuteQuery("SELECT id,name FROM `ch_master_states` WHERE `country_id`=$country_id");
            $i=0;$data=[];
            foreach ($sql->result() as $key){
                $data[$i] = [
                    'id' => $key->id,
                    'name' => $key->name
                ];
                $i++;
            }
            $json = ['status'=>"success","err_code"=>NULL,"data"=>$data];
        }else{
            $json = ['status'=>"failed",'err_code'=>'invalid_request','msg'=>"Incorrect Request"];
        }
        
        echo json_encode($json);
    }
    
    public function getCities(){
        $api_req = $this->first_run('GET',FALSE);
        $state_id = $_GET['id'];
        if(!empty($state_id)){
            $sql = $this->app_model->ExecuteQuery("SELECT id,name FROM `ch_master_cities` WHERE `state_id`=$state_id");
            $i=0;$data=[];
            foreach ($sql->result() as $key){
                $data[$i] = [
                    'id' => $key->id,
                    'name' => $key->name
                ];
                $i++;
            }
            $json = ['status'=>"success","err_code"=>NULL,"data"=>$data];
        }else{
            $json = ['status'=>"failed",'err_code'=>'invalid_request','msg'=>"Incorrect Request"];
        }
        
        echo json_encode($json);
    }
}
?>