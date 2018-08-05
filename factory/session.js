app.service('userSession', ['$rootScope','$localStorage', function ($rootScope, $localStorage) {
        return {
            cart : [],
            user : {},
            setSession: function (data, cb) {
                this.cart.push(data);
                $localStorage.cart = this.cart;
                cb($localStorage.cart);
            },
            
            getSession: function () {
               return $localStorage.cart;
            },
            
            getUserSession : function(){
                return $localStorage.user;
            },
            
            clearState : function (){
                $localStorage.$reset();
            }
        }
        
}]);