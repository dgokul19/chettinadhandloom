app.controller('prodctController', function($location, $window, $scope, $rootScope, $timeout, productCartApi){
    $scope.productsLoad = false;
    $scope.loader = true;

    $scope.explore_products = function(item){
        var opts = btoa(item.id) + '/' + item.code;
        console.log('opts', opts);
        $location.path('/category/'+ opts);
    }; 
    
    $scope.load_products = function (){
        productCartApi.get_categories().then(function(response){
            if(response.data.status == 'success'){
                $scope.category_data = response.data.category_data;
                $scope.productsLoad = true;
                $scope.loader = false;
            } else {
                console.log('Error in data fetching', response.data);
            } 
        });
    }
    $timeout(function(){
        $scope.load_products();
    },500);
});