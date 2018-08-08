app.controller('prodctController', function($location, $window, $scope, $rootScope, $timeout, productCartApi){
    $scope.productsLoad = false;
    
    $scope.openDetails = function (item){
        var opts = btoa(item.id) + '/' + item.code + '/' + item.name;
        $location.path('/products/'+ opts);
    }

    $scope.explore_products = function(items){
        var opts = btoa(items.category_id) + '/' + items.category_code;
        $location.path('/category/'+ opts);
    }; 
    
    $scope.load_products = function (){
        productCartApi.get_categories().then(function(response){
            if(response.data.status == 'success'){
                $scope.category_data = response.data.category_data;
                $scope.productsLoad = true;
            } else {
                console.log('Error in data fetching', response.data);
            } 
        });
    }
    $timeout(function(){
        $scope.load_products();
    },500);
});