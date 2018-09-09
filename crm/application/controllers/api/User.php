<?php

class User extends CI_Controller
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
        
        if(empty($req_Arr)){
            $json = ['status'=>"failed",'err_code'=>'invalid_request','msg'=>"Incorrect Request"];
            echo json_encode($json);
            die;
        }
        
        if($req_all == true){
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
                        $json = ['status'=>"success",'err_code'=>NULL,'msg'=>'Product has already been added to cart'];
                    }else{
                        $exe = $this->app_model->simple_update(USER_CART,$insert_arr,['id'=>$redundant_check->row()->id]);
                        if($exe){
                            $json = ['status'=>"success",'err_code'=>NULL,'msg'=>'Product has been updated in the cart'];
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
    
    public function show_cart(){
        $api_req = $this->first_run('POST');
        
        $user_id_enc = $api_req['user_id'];
        $user_id = $this->app_model->decode($user_id_enc);
        
        $fetch = $this->app_model->get_all(APP_USERS,['id'=>$user_id]);
        if($fetch->num_rows() != 0){
            
            $sql_state = "SELECT A.product_id,A.quantity,B.product_code,B.pdt_name,B.pdt_description,B.unit,B.price,B.available_quantity,B.status,B.published,C.picture_url FROM `ch_user_cart` as A "
                    . "INNER JOIN `ch_product_details` as B ON A.product_id=B.id LEFT JOIN `ch_product_images` as C ON A.product_id=C.pdt_p_id WHERE A.user_id='$user_id' AND C.is_cover_image=1 AND B.published=1";
            $sql_exe = $this->app_model->ExecuteQuery($sql_state);
            $data = [];$i=0;
            $product_picture_url = ASSETS."product-images/products/";
            foreach($sql_exe->result() as $key){
                switch ($key->status){
                    case 'available': $status = "available";
                        break;
                    case 'booked': $status = "booked";
                        break;
                    case 'sold': $status = "sold";
                        break;
                }
                $data[$i]=[
                   'product_id'=> $key->product_id,
                   'product_code'=> $key->product_code,
                   'product_name'=> $key->pdt_name,
                   'product_description'=> $key->pdt_description,
                   'product_unit'=> $key->unit,
                   'product_price'=> $key->price,
                   'product_quantity'=> $key->quantity,
                   'product_cover_img'=> $product_picture_url.$key->picture_url,
                   'product_status'=> $status
                ];  
                $i++;
            }
            
            $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"$i products available",'data'=>$data];
        }else{
            $json = ['status'=>"failed",'err_code'=>"invalid_user_id",'msg'=>"Please Login again"];
        }
        echo json_encode($json);
    }
    
    public function save_address(){
        $api_req = $this->first_run('POST',false);
        
        $user_id_enc = $api_req['user_id'];
        $user_id = $this->app_model->decode($user_id_enc);
        
        $fetch = $this->app_model->get_all(APP_USERS,['id'=>$user_id]);
        if($fetch->num_rows() != 0){
            
            $insert_Arr = [
                'user_id'=>$user_id,
                'title'=>$api_req['title'],
                'full_name'=>$api_req['full_name'],
                'address_line_1'=>$api_req['address_line_1'],
                'address_line_2'=>$api_req['address_line_2'],
                'city'=>$api_req['city'],
                'state'=>$api_req['state'],
                'country'=>$api_req['country'],
                'land_mark'=>$api_req['land_mark'],
                'pincode'=>$api_req['pincode'],
                'ph_country_code'=>$api_req['ph_country_code'],
                'phone_number'=>$api_req['phone_number']
            ];
            
            $exe = $this->app_model->simple_insert(USER_ADDRESSES,$insert_Arr);
            if($exe){
                $data = ['item_id'=>$this->db->insert_id()];
                $json = ['status'=>"success",'err_code'=>NULL,'msg'=>'Address has been saved successfully','data'=>$data];
            }else{
                $json = ['status'=>"failed",'err_code'=>"sql_error",'msg'=>$this->db->error()];
            }
        }else{
            $json = ['status'=>"failed",'err_code'=>"invalid_user_id",'msg'=>"Please Login again"];
        }
        echo json_encode($json);
    }
    
    public function getAddress(){
        $api_req = $this->first_run('POST');
        
        $user_id_enc = $api_req['user_id'];
        $user_id = $this->app_model->decode($user_id_enc);
        
        $fetch = $this->app_model->get_all(APP_USERS,['id'=>$user_id]);
        if($fetch->num_rows() != 0){
            $data = [];$i=0;
            
            $fetch = $this->app_model->get_all(USER_ADDRESSES,['user_id'=>$user_id]);
            foreach($fetch->result() as $key){
                
                $ship_country_sql = "SELECT fixed_cost,shipping_amount FROM `ch_master_countries` WHERE id=".$key->country.";";
                $ship_country = $this->app_model->ExecuteQuery($ship_country_sql);
                if($ship_country->row()->fixed_cost == 0){
                    $ship_states_sql = "SELECT fixed_cost,shipping_amount FROM `ch_master_states` WHERE id=".$key->state.";";
                    $ship_states = $this->app_model->ExecuteQuery($ship_states_sql);
                    $shipping_cost = $ship_states->row()->shipping_amount;
                }else{
                    $shipping_cost = $ship_country->row()->shipping_amount;
                }
                $data[$i]=[
                    'item_id'=>$key->id,
                    'title'=>$key->title,
                    'full_name'=>$key->full_name,
                    'address_line_1'=>$key->address_line_1,
                    'address_line_2'=>$key->address_line_2,
                    'city'=>$this->app_model->getCityName($key->city),
                    'state'=>$this->app_model->getStateName($key->state),
                    'country'=>$this->app_model->getCountryName($key->country),
                    'land_mark'=>$key->land_mark,
                    'pincode'=>$key->pincode,
                    'ph_country_code'=>$key->ph_country_code,
                    'phone_number'=>$key->phone_number,
                    'shipping_cost'=>$shipping_cost
                ];
                $i++;
            }
            
            $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"$i Address available",'data'=>$data];
        }else{
            $json = ['status'=>"failed",'err_code'=>"invalid_user_id",'msg'=>"Please Login again"];
        }
        echo json_encode($json);
        
    }
    
    public function remove_cart_item(){
        $api_req = $this->first_run('POST');
        
        $user_id_enc = $api_req['user_id'];
        $user_id = $this->app_model->decode($user_id_enc);
        
        if(empty($api_req['product_id'])){
            $json = ['status'=>"failed",'err_code'=>"invalid_request",'msg'=>"Product ID missing"];
            echo json_encode($json);
            die;
        }else{
            $product_id = $api_req['product_id'];
        }
        
        $fetch = $this->app_model->get_all(APP_USERS,['id'=>$user_id]);
        if($fetch->num_rows() != 0){
            $fetch2 = $this->app_model->get_all(USER_CART,['product_id'=>$product_id,'user_id'=>$user_id]);
            if($fetch2->num_rows() != 0){
                $remove = $this->app_model->simple_delete(USER_CART,['product_id'=>$product_id,'user_id'=>$user_id]);
                if($remove){
                    $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"Item has been removed from the cart",'data'=>NULL];
                }else{
                    $json = ['status'=>"failed",'err_code'=>"sql_error",'msg'=>$this->db->error()];
                }
            }else{
                $json = ['status'=>"failed",'err_code'=>"item_not_found",'msg'=>'Product does not exist in the cart'];
            }
            
        }else{
            $json = ['status'=>"failed",'err_code'=>"invalid_user_id",'msg'=>"Please Login again"];
        }
        echo json_encode($json);
    }
    
    public function update_cart_item(){
        $api_req = $this->first_run('POST');
        
        $user_id_enc = $api_req['user_id'];
        $user_id = $this->app_model->decode($user_id_enc);
        
        if(empty($api_req['product_id'])){
            $json = ['status'=>"failed",'err_code'=>"invalid_request",'msg'=>"Product ID missing"];
            echo json_encode($json);
            die;
        }else{
            $product_id = $api_req['product_id'];
        }
        
        if(empty($api_req['quantity'])){
            $json = ['status'=>"failed",'err_code'=>"invalid_request",'msg'=>"Quantity value missing"];
            echo json_encode($json);
            die;
        }else{
            $quantity = $api_req['quantity'];
        }
        
        $fetch = $this->app_model->get_all(APP_USERS,['id'=>$user_id]);
        if($fetch->num_rows() != 0){
            $fetch2 = $this->app_model->get_all(USER_CART,['product_id'=>$product_id,'user_id'=>$user_id]);
            if($fetch2->num_rows() != 0){
                $remove = $this->app_model->simple_update(USER_CART,['quantity'=>$quantity],['product_id'=>$product_id,'user_id'=>$user_id]);
                if($remove){
                    $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"Quantity has been updated",'data'=>NULL];
                }else{
                    $json = ['status'=>"failed",'err_code'=>"sql_error",'msg'=>$this->db->error()];
                }
            }else{
                $json = ['status'=>"failed",'err_code'=>"item_not_found",'msg'=>'Product does not exist in the cart'];
            }
            
        }else{
            $json = ['status'=>"failed",'err_code'=>"invalid_user_id",'msg'=>"Please Login again"];
        }
        echo json_encode($json);
    }
    
}
?>