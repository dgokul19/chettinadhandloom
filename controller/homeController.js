
app.controller('homeController', function($scope,$rootScope){
	$rootScope.bodyClass = 'homeBody';	
})
app.controller('journeyController', function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('placesController', function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('serviceController', function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('categoryController', function($scope,$rootScope){
	$rootScope.bodyClass = '';
})


app.controller('contactCtrl',function(socialfac,$scope,$rootScope){
	$rootScope.bodyClass = '';

	$scope.formSubmit = function(){
		var variable = {			
				name 	: 	$scope.formName,
				email	: 	$scope.formEmail,
				phone	: 	$scope.formPhone,
				msg		: 	$scope.formMsg					
		}

			socialfac.contactFrm(variable).then(function(response){
				$scope.formName = $scope.formEmail = $scope.formPhone = $scope.formMsg="";
			})
	}
	
})
app.controller('footyCtrl', function($scope,$rootScope,emailSubbs){
	$scope.subsCEmail = function(){
		var emailSub = {
			"data"  : $scope.subsEmail
		};
		emailSubbs.getDetails(emailSub).then(function(response){
			$scope.subsEmail = "";			
		})
		
	}
})