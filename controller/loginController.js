app.controller('loginController',function($scope,$rootScope,$location,socialfac){
	
	$scope.regisForm = function(){
		var data = {
			user_id		: 	$scope.user.user_id,
			userType	: 	$scope.user.userType,
			first_name	: 	$scope.user.first_name,
			last_name	: 	$scope.user.last_name,
			mobile_no	: 	$scope.user.mobile_no,
			email 		: 	$scope.user.email,
			password	: 	$scope.user.userPwd,
		}

		socialfac.useregister(data).then(function(response){
			console.log(JSON.stringify(response));
 			if(response.data.status == 'success'){
 				$scope.user = [];
 				// location.href = "/";
 			}else if(response.data.status == 'failed' && response.data.msg == 'email_already_in_use'){
 				alert('Email id already in use');
 			}
 		})
	}

	$scope.logiFunc = function(){
		var logData = {
			username : $scope.userEmail,
			password : $scope.userPwd
		}

		socialfac.loginDets(logData).then(function(resp){
			console.log(JSON.stringify(resp));
			var errCode = resp.data.err_code;
			$scope.otpNumber = resp.data.data.user_id
			if(resp.data.status === 'failed'){
				if(errCode == 'invalid_credentials'){
					alert(resp.data.msg);
				}else{
					alert(resp.data.msg);
				}
				jQuery('#otpPop_u').modal();
			} else{
				if(resp.data.OTP_status === false){
					jQuery('#otpPop_u').modal();
				}else{
					location.href="/";
				}
			}
		})
	}

	$scope.confirmOtP = function(){
		var id = {
			user_id : $scope.otpNumber,
			otp_code: $scope.otpNumb
		}
		socialfac.otpRegis(id).then(function(response){
			location.href="/home";
		})
	}
})