app.controller('prodctController', function($location, $scope, $rootScope, productCartApi){
    
    $scope.openDetails = function (item){
        var opts = btoa(item.id) + '/' + item.code;
        console.log('Error in data fetching', opts);
        $location.path('/products/'+ opts);
    }
    
    $scope.load_products = function (){
        productCartApi.get_categories().then(function(response){
            if(response.data.status == 'success'){
                $scope.category_data = response.data.category_data;
            } else {
                console.log('Error in data fetching', response.data);
            } 
        });
    }

    $scope.load_products();
});