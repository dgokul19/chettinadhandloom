app.controller('cartController', function($scope, $rootScope, accountFactory, userSession){
    $scope.user = userSession.getUserSession();
    if(!$scope.user){
        console.log($scope.user);
    }
});