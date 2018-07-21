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
//        echo FCPATH."assets\app\images\category\chettinaad-handloom-category-01.jpg";die;
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
                
                $getCategory_products = $this->app_model->get_all(PRODUCT_DETAILS,['status'=>'available','category_id'=>$fetchCategory->id]);
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

                $json = ['status'=>"success",'err_code'=>NULL,'msg'=>"","data"=>$json];
                echo json_encode($json);

            }else{
                $json = ['status'=>"failed",'err_code'=>'no_record','msg'=>"No record found"];
                echo json_encode($json);
            }
        }
        
    }

    public function test(){
        echo strtolower(random_string('nozero',6));
    }
    
}