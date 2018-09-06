app.controller('cartController', function($scope, $rootScope, accountFactory,cart_factory,userSession){
    var userDetails = userSession.getUserSession();
    if(userDetails){
        var opts = {"user_id" : userDetails.userID};
        cart_factory.get_cart_details(opts, function(err, products){
            if (err) return console.log(err);
            $scope.products =  products;
        });
    } else {
        location.href = "#/loomspace"
    }
});