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
            
            setUserSession : function(user, cb){
                this.user = user;
                $localStorage.user = this.user;
                cb();
            },
           
            setParamCart : function(cart_url, cb){
                $localStorage.url = cart_url;
                if($localStorage.url)
                    cb('true');
                else   
                    cb('false');
            },
            getParamCart : function(){
                return $localStorage.url;
            },

            getUserSession : function(){
                return $localStorage.user;
            },
            
            clearState : function (){
                $localStorage.$reset();
            }
        }
        
}]);