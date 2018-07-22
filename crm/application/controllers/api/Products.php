<?php

class Products extends CI_Controller
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
        }
        else{
            $json = ['status'=>"failed",'msg'=>"No Inputs"];
            echo json_encode($json);
        }
    }
    
    public function category(){
        if($_SERVER['REQUEST_METHOD'] != "GET"){
            $json = ['status'=>"failed",'err_code'=>'invalid_request_method','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
        
        $getCategory = $this->app_model->get_all(PRODUCT_CATEGORY,['is_active'=>1]);
        if($getCategory->num_rows() > 0){
            $i=0;$j=0;
            $json['status'] = 'success';
            $json['err_code'] = NULL;
            $cat_cover_picture_url = ASSETS."product-images/core/category/";
            $product_picture_url = ASSETS."product-images/products/";
            foreach($getCategory->result() as $fetchCategory){
                $json['category_data'][$i]['category_id'] = $fetchCategory->id;
                $json['category_data'][$i]['category_code'] = $fetchCategory->c_ref_code;
                $json['category_data'][$i]['category_name'] = $fetchCategory->category_name;
                $json['category_data'][$i]['category_name'] = $fetchCategory->category_name;
                $json['category_data'][$i]['description'] = $fetchCategory->description;
                $json['category_data'][$i]['cover_picture_url'] = $cat_cover_picture_url.$fetchCategory->cover_picture_url;
                
                $getCategory_products = $this->app_model->get_all(PRODUCT_DETAILS,['status'=>'available','category_id'=>$fetchCategory->id],['id'=>'DESC'],'','','4');
                if($getCategory_products->num_rows() != 0){
                    foreach($getCategory_products->result() as $inner_loop){
                        $json['category_data'][$i]['products'][$j]['id']=$inner_loop->id;
                        $json['category_data'][$i]['products'][$j]['name']=$inner_loop->pdt_name;
                        $json['category_data'][$i]['products'][$j]['code']=$inner_loop->product_code;
                        $json['category_data'][$i]['products'][$j]['price']=$inner_loop->price;
                        if($inner_loop->has_discount != 0){
                            $json['category_data'][$i]['products'][$j]['has_discount']=TRUE;
                            $json['category_data'][$i]['products'][$j]['discount_price']=$inner_loop->discount_price;
                            $json['category_data'][$i]['products'][$j]['discount_percentage']=$inner_loop->discount_percentage;
                        }else{
                            $json['category_data'][$i]['products'][$j]['has_discount']=FALSE;
                        }
                        $getProduct_images = $this->app_model->get_all(PRODUCT_IMAGES,['pdt_p_id'=>$inner_loop->id,'is_cover_image'=>'1','status'=>'1']);                        
                        $json['category_data'][$i]['products'][$j]['picture']=$product_picture_url.$getProduct_images->row()->picture_url;
                        $j++;
                    }
                    $j=0;
                }
                $i++;
            }
            
        }else{
            $json['status'] = 'failed';
            $json['err_code'] = 'no_records';
            $json['msg'] = 'No Active Category';
        }
        echo json_encode($json);
    }

    public function detailed_view(){
        $req_obj = file_get_contents("php://input");
        $req_Arr = json_decode($req_obj,true);

        /*
        $req_Arr = [
            'product_id'=>1,
            'product_code'=>'S1200'
        ];
        */

        if(empty($req_Arr)){
            $json = ['status'=>"failed",'err_code'=>'invalid_request_type','msg'=>"No Inputs"];
            echo json_encode($json);
            die;
        }else{
            $product_code = $req_Arr['product_code'];
            $product_id = $req_Arr['product_id'];

            $sql="SELECT A.*,B.c_ref_code,B.category_name,B.description as cat_comments,C.album_code,C.album_name,C.description as album_comments FROM `ch_product_details` as A 
                    INNER JOIN `ch_product_category` as B on A.category_id=B.id INNER JOIN `ch_product_albums` as C ON A.album_id=C.id
                    WHERE A.`id`='$product_id' AND A.`product_code`='$product_code'";
            $get_pd_details = $this->app_model->ExecuteQuery($sql);
            if($get_pd_details->num_rows() != 0){
                $fetch = $get_pd_details->row();

                $sql2 = $this->app_model->get_all(PRODUCT_IMAGES,['is_cover_image'=>'1','pdt_p_id'=>$fetch->id])->row();
                $product_picture_url = ASSETS."product-images/products/";
                $item_cover_picture = $product_picture_url.$sql2->picture_url;

                $item_gallery = null;$tmp_i=0;
                $sql3 = $this->app_model->get_all(PRODUCT_IMAGES,['is_cover_image'=>'0','pdt_p_id'=>$fetch->id]);
                foreach($sql3->result() as $key){
                    $item_gallery[$tmp_i] = $product_picture_url.$key->picture_url;
                }

                $json['item_id'] = $fetch->id;
                $json['item_code'] = $fetch->product_code;
                $json['item_name'] = $fetch->pdt_name;
                $json['item_description'] = $fetch->pdt_description;
                $json['tags'] = $fetch->tags;
                $json['item_price'] = $fetch->price;
                $json['item_status'] = ($fetch->status == "available")? TRUE:FALSE;

                $json['item_cover_picture'] = $item_cover_picture;
                $json['item_gallery'] = $item_gallery;
                
                $json['item_category']['category_code'] = $fetch->c_ref_code;
                $json['item_category']['category_name'] = $fetch->category_name;
                $json['item_category']['category_description'] = $fetch->cat_comments;

                $json['item_album']['album_code'] = $fetch->album_code;
                $json['item_album']['album_name'] = $fetch->album_name;
                $json['item_album']['album_description'] = $fetch->album_comments;

                $json_res = ['status'=>"success",'err_code'=>NULL,'msg'=>"","data"=>$json];
                echo json_encode($json_res);

            }else{
                $json = ['status'=>"failed",'err_code'=>'invalid_request_value','msg'=>"Incorrect product id or code"];
                echo json_encode($json);
            }
        }
        
    }

    public function list_category_products(){
        $request_method=$_SERVER["REQUEST_METHOD"];
        $req_obj = file_get_contents("php://input");
        $req_Arr = json_decode($req_obj,true);

        /*
        $req_Arr = [
            'category_id'=>1,
            'category_code'=>'pdc01'
        ];
        */

        if($request_method == "POST"){
            if(empty($req_Arr)){
                $json = ['status'=>"failed",'err_code'=>'invalid_request_type','msg'=>"No Inputs"];
                echo json_encode($json);
                die;
            }else{
                $category_id = $req_Arr['category_id'];
                $category_code = $req_Arr['category_code'];
                
                $check = $this->app_model->get_all(PRODUCT_CATEGORY,['id'=>$category_id,'c_ref_code'=>$category_code],'','category_name');
                if($check->num_rows() != 0){
                    $sql_avl = "SELECT A.*,B.c_ref_code,B.category_name,C.album_code,C.album_name FROM `ch_product_details` as A 
                        INNER JOIN `ch_product_category` as B on A.category_id=B.id INNER JOIN `ch_product_albums` as C ON A.album_id=C.id
                        WHERE A.`category_id`='$category_id' AND A.`status`='available' AND A.`published`='1' ";
                    $get_avl_pd_list = $this->app_model->ExecuteQuery($sql_avl);

                    $sql_sold = "SELECT A.*,B.c_ref_code,B.category_name,C.album_code,C.album_name FROM `ch_product_details` as A 
                        INNER JOIN `ch_product_category` as B on A.category_id=B.id INNER JOIN `ch_product_albums` as C ON A.album_id=C.id
                        WHERE A.`category_id`='$category_id' AND A.`status`='sold' AND A.`created_at` >= DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND A.`published`='1'";
                    $get_sold_pd_list = $this->app_model->ExecuteQuery($sql_avl);

                    $json = ['status'=>"success",'err_code'=>NULL];
                    $i=0;$data=NULL;
                    $product_picture_url = ASSETS."product-images/products/";
                    foreach($get_avl_pd_list->result() as $f1){
                        $sql_avl_image = $this->app_model->get_all(PRODUCT_IMAGES,['is_cover_image'=>'1','pdt_p_id'=>$f1->id])->row();
                        $item_cover_picture = $product_picture_url.$sql_avl_image->picture_url;

                        $data[$f1->id]['item_id']           = $f1->id;
                        $data[$f1->id]['item_code']         = $f1->product_code;
                        $data[$f1->id]['item_name']         = $f1->pdt_name;
                        $data[$f1->id]['item_description']  = $f1->pdt_description;
                        $data[$f1->id]['tags']              = $f1->tags;
                        
                        $data[$f1->id]['item_price']            = $f1->price;
                        $data[$f1->id]['item_status']           = ($f1->status == "available")? TRUE:FALSE;
                        $data[$f1->id]['item_cover_picture']    = $item_cover_picture;
                        $data[$f1->id]['category_code']         = $f1->c_ref_code;
                        $data[$f1->id]['category_name']         = $f1->category_name;

                        $data[$f1->id]['album_code']            = $f1->album_code;
                        $data[$f1->id]['album_name']            = $f1->album_name;
                        $i++;
                    }

                    foreach($get_sold_pd_list->result() as $f2){
                        $sql_sold_image = $this->app_model->get_all(PRODUCT_IMAGES,['is_cover_image'=>'1','pdt_p_id'=>$f2->id])->row();
                        $item_cover_picture = $product_picture_url.$sql_sold_image->picture_url;
                        
                        $data[$f2->id]['item_id']           = $f2->id;
                        $data[$f2->id]['item_code']         = $f2->product_code;
                        $data[$f2->id]['item_name']         = $f2->pdt_name;
                        $data[$f2->id]['item_description']  = $f2->pdt_description;
                        $data[$f2->id]['tags']              = $f2->tags;
                        
                        $data[$f2->id]['item_price']            = $f2->price;
                        $data[$f2->id]['item_status']           = ($f2->status == "available")? TRUE:FALSE;
                        $data[$f2->id]['item_cover_picture']    = $item_cover_picture;
                        $data[$f2->id]['category_code']         = $f2->c_ref_code;
                        $data[$f2->id]['category_name']         = $f2->category_name;

                        $data[$f2->id]['album_code']            = $f2->album_code;
                        $data[$f2->id]['album_name']            = $f2->album_name;
                        $i++;
                    }
                    // print_r($data);
                    // $data2 = krsort($data);   //sorting by key --> by ID
                    // print_r(($data2));die;

                    $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"$i Records Found","data"=>$data];
                    echo json_encode($json);

                }else{
                    $json = ['status'=>"failed",'err_code'=>'invalid_request_value','msg'=>"Incorrect category ID or code"];
                    echo json_encode($json);
                    die;
                }
            }
        }else{
            $json = ['status'=>"failed",'err_code'=>'invalid_request_method','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
    }

    public function get_categories(){
        $request_method=$_SERVER["REQUEST_METHOD"];
        $req_obj = file_get_contents("php://input");
        $req_Arr = json_decode($req_obj,true);

        /*
        $req_Arr = [
            'category_id'=>1,
            'category_code'=>'pdc01'
        ];
        */
        
        if($request_method == "GET"){
            $sql = $this->app_model->get_all(PRODUCT_CATEGORY,['is_active'=>1]);
                
            $i=0;$data=NULL;
            foreach($sql->result() as $fetch){
                $data[$i]['album_id'] = $fetch->id;
                $data[$i]['category_code'] = $fetch->c_ref_code;
                $data[$i]['category_description'] = $fetch->description;
                $i++;
            }
            $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"$i Records Found","data"=>$data];
            echo json_encode($json); 
        }else{
            $json = ['status'=>"failed",'err_code'=>'invalid_request_method','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
    }

    public function get_category_albums(){
        $request_method=$_SERVER["REQUEST_METHOD"];
        $req_obj = file_get_contents("php://input");
        $req_Arr = json_decode($req_obj,true);

        /*
        $req_Arr = [
            'category_id'=>1,
            'category_code'=>'pdc01'
        ];
        */

        if($request_method == "POST"){
            if(empty($req_Arr)){
                $json = ['status'=>"failed",'err_code'=>'invalid_request_type','msg'=>"No Inputs"];
                echo json_encode($json);
                die;
            }else{
                $category_id = $req_Arr['category_id'];
                $category_code = $req_Arr['category_code'];

                $check = $this->app_model->get_all(PRODUCT_CATEGORY,['id'=>$category_id,'c_ref_code'=>$category_code],'','category_name');
                if($check->num_rows() != 0){
                    $sql = $this->app_model->get_all(PRODUCT_ALBUMS,['category_id'=>$category_id,'status'=>1]);
                    
                    $i=0;$data=NULL;
                    foreach($sql->result() as $fetch){
                        $data[$i]['album_id'] = $fetch->id;
                        $data[$i]['album_code'] = $fetch->album_code;
                        $data[$i]['album_description'] = $fetch->description;
                        $i++;
                    }
                    $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"$i Records Found","data"=>$data];
                    echo json_encode($json);
                    
                }else{
                    $json = ['status'=>"failed",'err_code'=>'invalid_request_value','msg'=>"Incorrect category ID or code"];
                    echo json_encode($json);
                    die;
                }           
            }
        }else{
            $json = ['status'=>"failed",'err_code'=>'invalid_request_method','msg'=>"Incorrect Request Method"];
            echo json_encode($json);
            die;
        }
    }

    public function test(){
        // echo strtolower(random_string('nozero',6));
        $weight = array("5"=>['item_id'=>'5'], "3"=>['item_id'=>'5'], "7"=>['item_id'=>'5']);    
        print_r(ksort($weight));
        var_dump($weight);
        // print_r($weight);
    }
    
}