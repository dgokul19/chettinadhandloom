
app.controller('detailsController', function($scope,$mdToast,$rootScope, $timeout, $routeParams,productCartApi){
    var product_id = atob($routeParams.product_id);
    var product_code = $routeParams.product_code;
    var params = {
        "product_id" : product_id,
        "product_code" : product_code
    }

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

    $scope.get_product_details = function (){
        productCartApi.get_product_details(params, function(err, response){
            if (err) return console.log(err);
            response.qty = '1';
            $scope.products = response;
            load_page_crumb($scope.products);
        });
    }
    
   
        $scope.get_product_details();
});