app.controller('categoryController', function($scope,$rootScope,$routeParams){
    var category_id = $routeParams.categ_id;
    var category_code = $routeParams.categ_code;





    $scope.load_products = function (){
        var opts = {category_id : category_id, category_code : category_code}
        productCartApi.get_category_details(params, function(err, response){
            if (err) return console.log(err);
            response.qty = '1';
            $scope.categories = response;
            load_page_crumb($scope.products);
        });
    }
    
   
    $scope.load_products();
});