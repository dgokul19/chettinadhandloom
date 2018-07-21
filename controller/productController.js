app.controller('prodctController', function($location, $scope, $rootScope, productCartApi, toaster){
    
    $scope.openDetails = function (item){
        var opts = '?id='+ item.id + '?code=' + item.code;
        opts = encodeURIComponent(opts);
        $location.path('/details'+ opts);
    }
    
    $scope.load_products = function (){
        productCartApi.api().then(function(response){
            if(response.data.status == 'success'){
                $scope.category_data = response.data.category_data;
            } else {
                console.log('Error in data fetching', response.data);
            } 
        });
    }
    
    
    var showToast =  function(type, title, messages){     
        toaster.pop({
            type    :   type,
            title   :   title,
            body    :   messages,
            timeout : 2000,
            showCloseButton: true
        });
    };
    $scope.load_products();
});