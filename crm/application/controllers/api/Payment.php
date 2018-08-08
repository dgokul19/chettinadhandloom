<?php
class Payment extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
    }

    public function payumoney_settings(){
        
        /*
        |Test MID: 4934580
        |Test Key: rjQUPktU
        |Test Salt: e5iIg1jwi8
        |Test Authorization Header: y8tNAC1Ar0Sd8xAHGjZ817UGto5jt37zLJSX/NHK3ok=
        |
        |Test card details
        |	Card Name: Test
        |	Card Number: 5123 4567 8901 2346
        |	CVV: 123
        |	Expiry: 05/2020
        |	
        |	Ref_URL : https://www.payumoney.com/dev-guide/development/general.html
        |	
        */
        $payment_env = "TEST";
        switch ($payment_env){
            case "TEST" : 
                $MERCHANT_KEY = "rjQUPktU";
                $SALT = "e5iIg1jwi8";
                $PAYU_BASE_URL = "https://test.payu.in/_payment";
                break;
            case "LIVE":
                $MERCHANT_KEY = "5qfgFtCk";
                $SALT = "AbBPZ939yg";
                $PAYU_BASE_URL = "https://secure.payu.in/_payment";
                
        }
        
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        // Hash Sequence
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $SALT;

        $hash = strtolower(hash('sha512', $hash_string));
        
        $surl   = base_url('Payment/success/'.$txnid);
        $furl   = base_url('Payment/failed/'.$txnid);
        $c_url  = base_url('Payment/cancelled/'.$txnid);
        
        $json['status'] = "success";
        $json['data']['key']    = $MERCHANT_KEY;
        $json['data']['txnid']  = $txnid;
        $json['data']['action'] = $PAYU_BASE_URL;
        $json['data']['hash']   = $hash;
        $json['data']['surl']   = $surl;
        $json['data']['furl']   = $furl;
        $json['data']['curl']   = $c_url;
        
        echo json_encode($json);
        
    }
    
    public function success(){
        echo "Payment Success";
    }
    
    public function failed(){
        echo "Payment failed";
    }
    
    public function cancelled(){
        echo "Payment cancelled";
    }
}
