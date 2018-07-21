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
    
}