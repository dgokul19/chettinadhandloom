<?php

class Checklogin extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function authenticate(){
        $post_obj = file_get_contents("php://input");
        $get_post_array = json_decode($post_obj,true);
        if(empty($get_post_array)){
            $json = ['status'=>"failed",'msg'=>"Error in decoding JSON parameter"];
            echo json_encode($json);
            die;
        }
        $username = $get_post_array['username'];            // either Phone number or Email id
        $password = md5($get_post_array['password']); 
        
//        $username = '8122701839';
//        $password = md5(123456);
        
        $where_field = (is_numeric($username))? 'mobile_no' : 'email';
        
        $check_login_ref = $this->ch_model->get_all(APP_USERS,[$where_field=>$username]);
        $check_login = $this->ch_model->get_all(APP_USERS,[$where_field=>$username,'password'=>$password]);
        if($check_login_ref->num_rows() == 1){
            if($check_login->num_rows() == 1){
                $OTP_status = $check_login->row()->otp_is_verified;
                $json['status'] = 'success';
                $user_id = $check_login->row()->id;
                $user_id_enc = $this->ch_model->encode($user_id);
                $json['data'] = [
                        'user_id'=>$user_id_enc,
                        'username'=>$check_login->row()->username
                    ];
                if($OTP_status == 0){
                    $json['OTP_status'] = FALSE;
                    $json['OTP'] = $check_login->row()->OTP;
                    $json['msg'] = 'OTP has to be verified';
                }else{
                    $json['OTP_status'] = TRUE;
                    $json['msg'] = 'Authentication successful';
                }
            }else{
                $json['status'] = 'failed';
                $json['err_code'] = 'wrong_password';
                $json['msg'] = 'wrong_password';
            }
        }else{
            $json['status'] = 'failed';
            $json['err_code'] = 'invalid_credentials';
            $json['msg'] = 'cannot identity the '.$where_field.' that you entered';
        }
        
        echo json_encode($json);
    }
    
    public function sign_up(){
       
//        $post_obj = '{"id":"476559399379944","cover":{"id":"433871663648718","offset_x":0,"offset_y":54,"source":"https://scontent.xx.fbcdn.net/v/t31.0-8/s720x720/18836874_433871663648718_8271214575237541264_o.jpg?oh=e9d917819228f954da713c4d83466075&oe=5A59AE8D"},"first_name":"Gokulan","last_name":"Dhatchinamoorthy","gender":"male","name":"Gokulan Dhatchinamoorthy","picture":{"data":{"height":320,"is_silhouette":false,"url":"https://scontent.xx.fbcdn.net/v/t1.0-1/p320x320/21230860_475715802797637_1496135717601066997_n.jpg?oh=5ccb426e73507226a8fdf7839101d1d6&oe=5A567CC8","width":320}},"accessToken":"EAAXPZCALU67oBAKvsRZCnOcjd4fbMnPwsMI7ZBZBSGZBfNrEaUI3kivmSZCz5qFTrGLZCRxIxYyac2N0MPIWAISZB9S9hdqYthweO74IfODacEzLZAeukBol0GLhlkspRa2jLef7EdnZAoqOt3qagIpeV1ifuw41jRhVfHbjmrg5YSnm6GHnZBSZCMPIc4AjdzpL59DhSGEdGw1anQZDZD","reg_inType":"fb"}';
//        $get_post_array = json_decode($post_obj,true);  
//        print_r($get_post_array);
//        echo $get_post_array['reg_inType'];
//          die;
        
        if(isset($_POST) && !empty($_POST)){
            $post_obj = file_get_contents("php://input");
            $get_post_array = json_decode($post_obj,true);  
//            print_r($get_post_array);die;
            if(empty($get_post_array)){
                $json = ['status'=>"failed",'err_code'=>'invalid_request','msg'=>"Error in decoding JSON parameter"];                
                echo json_encode($json);
                die;
            }
            $reg_inType = $get_post_array['reg_inType'];        //reg_inType = fb, google, regular  
            if(empty($reg_inType)){
                $json = ['status'=>"failed",'err_code'=>'invalid_request','msg'=>"reg_inType missing"];
                echo json_encode($json);
                die;
            }
            /*CALL AACTION METHOD*/
            switch ($reg_inType){
                case "fb" : $this->fb_signup($get_post_array);
                    break;
                case "google" : $this->google_signup($get_post_array);
                    break;
                case "regular" : $this->regular_signup($get_post_array);
                    break;
                default : $this->regular_signup($get_post_array);
//                default : $this->exception_action($get_post_array);
                    break;
            }
        }else{
            $json = ['status'=>"failed",'msg'=>"No Inputs"];
            echo json_encode($json);
        }  
    }
    /* REGULAR WEB SIGNUP */
    private function regular_signup($post_array)
    {
        
        $userType        = $post_array['userType'];        
        $Email           = trim($post_array['email']);
        $First_name      = trim($post_array['first_name']);
        $Last_name       = trim($post_array['last_name']);
        $Gender          = $post_array['gender'];
        $mobile_no       = ($post_array['mobile_no']);
        $password        = md5($post_array['password']);
        
        $check_email = $this->ch_model->get_all(APP_USERS,['email'=>$Email]);
        $check_mobile = $this->ch_model->get_all(APP_USERS,['mobile_no'=>$mobile_no]);
        $check_both = $this->ch_model->get_all(APP_USERS,['email'=>$Email,'mobile_no'=>$mobile_no]);
        
        if($check_mobile->num_rows() == 0){
            if($check_email->num_rows() == 0){
                $OTP = rand(100000,999999);
                $insert_array = [
                    'oauth_provider' => "",
                    'username' => $First_name." ".$Last_name,
                    'first_name' => $First_name,
                    'last_name' => $Last_name,
                    'email' => $Email,
                    'mobile_no' => $mobile_no,
                    'OTP' => $OTP,
                    'password' => $password,
                    'userType'=>strtolower($userType),
                    'status'=>1,
                ];
                $insertSQL = $this->ch_model->simple_insert(APP_USERS,$insert_array);
                $user_id = $this->db->insert();
                $user_id_enc = $this->ch_model->encode($user_id);
                $error = $this->db->error(); // Has keys 'code' and 'message'       
                if($error['code'] === 0 && $insertSQL === TRUE){                    
                    /*
                        SMS CODE
                    */                    
                    $json['status'] = 'success';
                    $json['err_code'] = NULL;
                    $json['OTP'] = $OTP;
                    $json['data'] = [
                        'user_id'=>$user_id_enc,
                        'username'=>$First_name." ".$Last_name
                    ];
                    $json['msg'] = 'profile created successfully';
                }else{
                    $this->db->_error_message();
                    $json['status'] = 'failed';
                    $json['err_code'] = 'DB_error';
                    $json['msg'] = 'database_error=>'.$error['message'];
                }
            }else{
                $json['status'] = 'failed';
                $json['err_code'] = 'email_in_use';
                $json['msg'] = 'Email ID already in use';
            }
        }else{
            $json['status'] = 'failed';
            $json['err_code'] = 'ph_in_use';
            $json['msg'] = 'mobile no already in use';
        }
        echo json_encode($json);
    }
    
     /* FACEBOOK SIGNUP */
     private function fb_signup($post_array)
    {
        echo json_encode(['status'=>'failed','msg'=>'suspended_for_a_while']);die;
        $fb_ID              = $post_array['id'];
        $fb_Email           = (isset($post_array['email'])) ? $post_array['email'] : NULL;
        $fb_Birthday        = (isset($post_array['birthday'])) ? $post_array['birthday'] : NULL;
        $fb_First_name      = $post_array['first_name'];
        $fb_Last_name       = $post_array['last_name'];
        $fb_Gender          = $post_array['gender'];

        $fb_Name            = $post_array['name'];
        $fb_AccessToken     = $post_array['accessToken'];                
        $fb_ProfilePicture  = $post_array['picture']['data']['url'];
        $fb_CoverPicture    = $post_array['cover']['source'];

        $insert_array = [
            'oauth_provider'=>$post_array['reg_inType'],
            'oauth_uid'=>$fb_ID,
            'access_token'=>$fb_AccessToken,
            'username'=>$fb_Name,
            'first_name'=>$fb_First_name,
            'last_name'=>$fb_Last_name,
            'email'=>$fb_Email,
            'gender'=>$fb_Gender,
            'DOB'=>$fb_Birthday,
            'picture_url'=>$fb_ProfilePicture,
            'cover_picture_url'=>$fb_CoverPicture
        ];
        
        $check_email = $this->ch_model->get_all(APP_USERS,['email'=>$fb_Email]);
        if($check_email->num_rows() == 0){
            $sql_insert = $this->ch_model->simple_insert(APP_USERS,$insert_array);
            $insert_id = $this->db->insert_id();
            $user_id = $this->ch_model->encode($insert_id);
            $json['status'] = 'success';
            $json['msg'] = ($fb_Email == "" || empty($fb_Email))? "emailID_not_exist" : "confirm_email_phone_on_nextStep";
            $json['user_id'] = $user_id;
        }else{
            if($check_email->row()->status == 0 || $check_email->row()->userProfile_status == "not_completed"){
                $json['status'] = 'failed';
                $json['msg'] = 'profile_not_completed';
                $json['userData']['first_name'] = $check_email->row()->first_name;
                $json['userData']['last_name'] = $check_email->row()->last_name;
                $json['userData']['email'] = $check_email->row()->email;
                $json['userData']['mobile_no'] = $check_email->row()->mobile_no;
                $json['userData']['user_id'] = $this->ch_model->encode($check_email->row()->id);
            }else{
                $json['status'] = 'failed';
                $json['msg'] = 'email_id_already_exist_pls_log_in';
            }
            
        }        
        echo json_encode($json);
    }
    /* GOOGLE SIGNUP */
    private function google_signup($post_array)
    {
        echo json_encode(['status'=>'failed','msg'=>'suspended_for_a_while']);die;
    }
    
    /* HANDLE EXCEPTION TYPE */
    private function exception_action($post_array)
    {
        $json['emailID_status'] = "failed";
        $json['status'] = 'failed';
        $json['msg'] = 'reg_inType is empty or invalid';
        echo json_encode($json);
    }
    
    /**/
    public function sign_up_call2(){
        $post_obj = file_get_contents("php://input");
        $post_array = json_decode($post_obj, true);
        if (empty($post_array)) {
            $json = ['status' => "failed", 'msg' => "Error in decoding JSON parameter"];
            echo json_encode($json);
            die;
        }
        $user_id = $this->ch_model->decode($post_array['user_id']);
        $first_name = $post_array['first_name'];
        $last_name = $post_array['last_name'];
        $email = $post_array['email'];
        $mobile_no = $post_array['mobile_no'];
        $password = $post_array['password'];
        $userType = $post_array['userType'];
        
        $check_email = $this->ch_model->get_all(APP_USERS,['email'=>$email,'status'=>1]);
        if($check_email->num_rows() == 0){
            $update_arr = [
                'first_name'=>$first_name,            
                'last_name'=>$last_name,            
                'email'=>$email,            
                'mobile_no'=>$mobile_no,            
                'password'=>md5($password),            
                'userType'=>strtolower($userType),
                'status'=>1,
                'userProfile_status'=>"completed"
            ];
            $this->ch_model->simple_update(APP_USERS,$update_arr,['id'=>$user_id]);
            $json['status'] = 'success';
            $json['msg'] = 'userProfile_updated';
        }else{
            $json['status'] = 'failed';
            $json['msg'] = 'email_already_in_use';
        }
        echo json_encode($json);
    }
    
    public function confirm_otp(){
        $post_obj = file_get_contents("php://input");
        $post_array = json_decode($post_obj, true);
        if (empty($post_array)) {
            $json = ['status' => "failed", 'msg' => "Error in decoding JSON parameter"];
            echo json_encode($json);
            die;
        }
        $user_id = $this->ch_model->decode($post_array['user_id']);
        $check = $this->ch_model->get_all(APP_USERS,['id'=>$user_id,'OTP'=>$post_array['otp_code']]);
        if($check->num_rows() == 1){
            $json=[
                'status'=>'success',
                'err_code'=>'valid_otp',
                'msg'=>'Mobile number Verified'
            ];
            $this->ch_model->simple_update(APP_USERS,['otp_is_verified'=>1],['id'=>$user_id]);
        }else{
            $json=[
                'status'=>'failed',
                'err_code'=>'invalid_otp',
                'msg'=>'Incorrect OTP'
            ];
        }
        echo json_encode($json);
    }
    
}