
app.controller('detailsController', function($scope,$rootScope, $timeout, $routeParams, cart_factory, userSession, productCartApi){
    var product_id = atob($routeParams.product_id);
    var product_code = $routeParams.product_code;
    var product_name = $routeParams.product_name;
    $scope.product_name = angular.copy(product_name);
    var _param_define = {
        "product_id"  : atob($routeParams.product_id),
        "product_code" : $routeParams.product_code,
        "product_name" : $routeParams.product_name
    }
    $scope.cartIsEmpty = true;
    $scope.cart = [];
    var user_details = userSession.getUserSession(); 




    $scope.change_qty = function (qty, type){
        if(type === 'add'){
            $scope.products.qty = parseInt(qty) + 1;
        } else{
            qty = parseInt(qty) - 1;
            if(qty < 1){
                $scope.products.qty = 1;
                productCartApi.showToast('error', 'Error', 'Quantity must be greater than 1 !!');
            }else{
                $scope.products.qty = qty;
            }
        }
    };
    
    var load_page_crumb = function (objects){
        $scope.pages = [];
        
        if(objects && objects.item_category && objects.item_category.category_name)
            $scope.pages.push(objects.item_category.category_name);
        if(objects && objects.item_album && objects.item_album.album_name)
            $scope.pages.push(objects.item_album.album_name);
        if(objects && objects.item_name)
            $scope.pages.push(objects.item_name);
    };

    $scope.addtoCart = function (product){
        if(user_details){
           
            var opts = {
                "user_id" :  user_details.userID,
                "product_id" : product.item_id, 
                "product_quantity" :product.qty
            }
            cart_factory.add_to_cart(opts, function(err, data){
                if (err) return console.log(err);
                if(data.status == 'success')
                    $scope.cartIsEmpty = false;
                else
                    console.log('Error :', err_code);
            });
        } else {
            var access_ques = confirm("Please login to add the products into cart");
            if(access_ques){
                userSession.setParamCart(_param_define, function(status){
                    if(status)
                        location.href = "#/login";
                });
            }
        }
    }
    $scope.continue_shopping = function(products){
        if(user_details){
            var opts = {
                "user_id" :  user_details.userID,
                "product_id" : products.item_id, 
                "product_quantity" :products.qty
            }
            cart_factory.add_to_cart(opts, function(err, data){
                if (err) return console.log(err);
                if(data.status == 'success')
                    location.href = "#/loomspace";
                else
                    console.log('Error :', err_code);
            });
        } else{
            $scope.cartIsEmpty = true;
        }
    }


    $scope.get_product_details = function (){
        productCartApi.get_product_details(_param_define, function(err, response){
            if (err) return console.log(err);
            response.qty = '1';
            $scope.products = response;
            load_page_crumb($scope.products);
        });
    }
    
    $scope.goCart = function (){
        if(user_details){
            location.href = "#/cart"
        }
    };

    $scope.get_product_details();
});