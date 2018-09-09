app.controller('cartController', function($scope,$http,$rootScope, accountFactory,cart_factory,userSession){
    var userDetails = userSession.getUserSession();
    console.log(userDetails);

    $scope.addresses = {};

    var get_countries = function (){
       cart_factory.get_countries().then(function(response){
            if(response.data.status === 'success'){
                $scope.get_countries = response.data.data;
                console.log('$scope.get_countries',  $scope.get_countries);

            }
       });
    }

    var load_cart_details = function (){
        $scope.loader = true;
        var opts = {"user_id" : userDetails.userID};
        cart_factory.get_cart_details(opts, function(err, products){
            if (err) return console.log(err);
            $scope.products =  products;
            $scope.loader = false;
        });
    };

    var get_user_addresses = function (){
        var opts = {"user_id" : userDetails.userID};
        cart_factory.get_address_data(opts, function(err, addres_list){
            if (err) return console.log(err);
            $scope.user_addresses = addres_list;
        });
    };
    
    $scope.removeItem = function (item){
        var opts = {
            "user_id":userDetails.userID,
            "product_id":item.product_id,
        }
        cart_factory.remove_product(opts, function(err, resp){
            if (err) return console.log(err);
            if (resp == null)
                load_cart_details();
        });
    };

     var init = function (){
        load_cart_details();
        get_user_addresses();
        // get_countries();
     };

    if(userDetails){
        init();
    } else {
        location.href = "#/loomspace"
    }
});