app.service('userSession', ['$rootScope','$localStorage', function ($rootScope, $localStorage) {
        return {
            cart : [],
            setSession: function (data, cb) {
                this.cart.push(data);
                $localStorage.cart = this.cart;
                cb($localStorage.cart);
            },
    
            getSession: function () {
               return $localStorage.cart;
            },
            clearState : function (){
                $localStorage.$reset();
            }
        }
        
}]);