
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

    productCartApi.get_product_details(params, function(err, response){
        if (err) return console.log(err);
        response.qty = '1';
        $scope.products = response;
    });
});