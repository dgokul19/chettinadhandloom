<?php

class User extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    private function first_run($method){
        $req_obj = file_get_contents("php://input");
        $req_Arr = json_decode($req_obj,true);
        
        if($_SERVER['REQUEST_METHOD'] != $method){
            $json = ['status'=>"failed",'err_code'=>'invalid_request_method','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
        
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
        
        return $req_Arr;
    }
    
    public function signup(){
        $req_Arr = $this->first_run('POST');
        
        $fullname = $req_Arr['fullname'];
        $email_id = $req_Arr['email_id'];
        $country_code = $req_Arr['country_code'];
        $phone_number = $req_Arr['phone_numnber'];
        $password = $req_Arr['password'];
        
        if(!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
            $json = ['status'=>"failed",'err_code'=>'invalid_email_id','msg'=>"Incorrect email ID"];
            echo json_encode($json);
            die;
        }
        
        if(!is_numeric($phone_number)){
            $json = ['status'=>"failed",'err_code'=>'invalid_phone_number','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
        
        $check_email = $this->app_model->get_all(APP_USERS,['email_id'=>$email_id],'','id');
        if($check_email->num_rows() == 0){
            $ins_arr = [
                'full_name'=> $fullname,
                'email_id'=> $email_id,
                'country_code'=> $country_code,
                'mobile_no'=> $phone_number,
                'password'=> md5($password),
                'email_otp' => random_string('nozero', 8)
            ];
            $sql = $this->app_model->simple_insert(APP_USERS,$ins_arr);
            if($sql){
                $insert_id = $this->db->insert_id();
                $userData = [
                    'userID' => $this->app_model->encode($insert_id),
                    'name' => $fullname,
                    'email_id' => $email_id,
                    'country_code' => $country_code,
                    'phone_number' => $phone_number,
                    'is_email_verified' => FALSE,
                ];
                $json = ['status'=>"success",'err_code'=>NULL,'data'=>$userData];
            }else{
                $dberror = $this->db->error();
                $err_code = $dberror['code'];
                $err_msg = $dberror['message'];
                $json = ['status'=>"failed",'err_code'=>'db_error','error_data'=>$dberror];
            }
            echo json_encode($json);
        }else{
            $json = ['status'=>"failed",'err_code'=>'email_already_exist','msg'=>"An Account already exist with this email ID."];
            echo json_encode($json);
            die;
        }
        
    }
    
    public function authenticate(){
        $api_req = $this->first_run('POST');
        
        $email_id = $api_req['email_id'];
        $password = $api_req['password'];
        
        $fetch = $this->app_model->get_all(APP_USERS,['email_id'=>$email_id]);
        if($fetch->num_rows() != 0){
            $get_data = $fetch->row();
            if($get_data->password === md5($password)){
                $userData = [
                    'userID' => $this->app_model->encode($get_data->id),
                    'name' => $get_data->full_name,
                    'email_id' => $get_data->email_id,
                    'country_code' => $get_data->country_code,
                    'phone_number' => $get_data->mobile_no,
                    'is_email_verified' => ($get_data->is_email_verified == 1)? TRUE : FALSE
                ];
                $json = ['status'=>"success",'err_code'=>NULL,'data'=>$userData];
            }else{
                $json = ['status'=>"failed",'err_code'=>"incorrect_password",'msg'=>"Incorrect passoword"];
            }
        }else{
            $json = ['status'=>"failed",'err_code'=>"incorrect_email_id",'msg'=>"Incorrect email ID"];
        }
        echo json_encode($json);
    }
    
    public function add_to_cart(){
        $api_req = $this->first_run('POST');
        
        $user_id_enc = $api_req['user_id'];
        $user_id = $this->app_model->decode($user_id_enc);
        $product_id = $api_req['product_id'];
        $product_quantity = $api_req['product_quantity'];
        
        $fetch = $this->app_model->get_all(APP_USERS,['id'=>$user_id]);
        if($fetch->num_rows() != 0){
            $fetch_prd = $this->app_model->get_all(PRODUCT_DETAILS,['id'=>$product_id]);
            if($fetch_prd->num_rows() != 0){
                $insert_arr = [
                    'user_id'=>$user_id,
                    'product_id'=>$product_id,
                    'quantity'=>$product_quantity
                ];
                
                $redundant_check = $this->app_model->get_all(USER_CART,['user_id'=>$user_id, 'product_id'=>$product_id]);
                if($redundant_check->num_rows() == 0){
                    $exe = $this->app_model->simple_insert(USER_CART,$insert_arr);
                    if($exe){
                        $json = ['status'=>"success",'err_code'=>NULL,'msg'=>'Product has been added to cart'];
                    }else{
                        $json = ['status'=>"failed",'err_code'=>"sql_error",'msg'=>$this->db->error()];
                    }
                }else{
                    $existing_qnty = $redundant_check->row()->quantity;
                    if($existing_qnty == $product_quantity){
                        $json = ['status'=>"success",'err_code'=>NULL,'msg'=>'Product already added to cart'];
                    }else{
                        $exe = $this->app_model->simple_update(USER_CART,$insert_arr,['id'=>$redundant_check->row()->id]);
                        if($exe){
                            $json = ['status'=>"failed",'err_code'=>NULL,'msg'=>'Product has been updated in the cart'];
                        }else{
                            $json = ['status'=>"failed",'err_code'=>"sql_error",'msg'=>$this->db->error()];
                        }
                    }
                }
            }else{
                $json = ['status'=>"failed",'err_code'=>"invalid_product_id",'msg'=>"Product cannot be added to cart"];
            }
        }else{
            $json = ['status'=>"failed",'err_code'=>"invalid_user_id",'msg'=>"Please Login again"];
        }
        echo json_encode($json);
    }
    
}
?>