app.controller('loginController',function($scope, $mdToast, $rootScope, $location, userSession ,accountFactory){
	
	$scope.regisForm = function(user){
        var data = {
            "fullname" : user.fullname,
            "email_id" : user.email_id,
            "country_code" : "+91", 
            "phone_numnber" : user.mobile_no,
            "password" : user.password
        }

		accountFactory.useregister(data).then(function(response){
 			if(response.data.status == 'success'){
                 $scope.user = [];
                 $scope.signUpform.$setPristine();
                 $scope.signUpform.$setUntouched();
                 showToast('success', 'Success', 'Created Successfully !!');
                 $scope.signSoc = false;
 			}else if(response.data.status == 'failed'){
                showToast('error', 'Error', response.data.msg);
 			}
 		})
	}

	$scope.authenticateMe = function(user){
		var opts = {
			email_id : user.email_id,
			password : user.password
		}
		accountFactory.userAuthenticate(opts).then(function(resp){
			if(resp.data.status === 'success'){
                userSession.setUserSession(resp.data.data, function(){
                    var param = userSession.getParamCart()
                    showToast('success', 'Success', 'User Authenticated !!');
                    if(!param)
                        location.href="#/loomspace";
                    else
                        location.href="#/products/"+ btoa(param.product_id) + '/' + param.product_code + '/' + param.product_name;
                });
			} else {
                showToast('error', 'Error', resp.data.msg);
            }
		})
    }
    
    var showToast = function(type, title, messages){     
        if(type == 'success')
            _class = 'success'
        else
            _class = 'error'
        $mdToast.show(
            $mdToast.simple({
                hideDelay: 3000,
                position: 'top right fit',
                content: title + ' ' + messages,
                toastClass: _class,
            })
        );
    }		
});