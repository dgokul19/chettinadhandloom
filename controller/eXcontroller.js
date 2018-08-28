	function onLoadFunctn (){
					gapi.client.setApiKey('AIzaSyAjsFfN9fXCmHgTQF3W9q03FCW4ju4l5-U');
					gapi.client.load('plus','v1',function(){
						
						var request = gapi.client.plus.people.get(
								{
									'userId' : 'me'
								}
							);

							request.execute(function(resp){
								console.log(JSON.stringify(resp));
							})
						

					});
				}
		(function(){
			var p = document.createElement('script');
				p.type = 'text/javascript';
				p.async = true;
				p.src = 'https://apis.google.com/js/client.js?onload=onLoadFunctn';
			var d = document.getElementsByTagName('script')[0];
				d.parentNode.insertBefore(p,d);	
		})();


app.controller('prodctHme',function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('homeController',function($scope,$rootScope){
	$rootScope.bodyClass = 'homeBody';	
})
app.controller('journeyController',function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('placesController',function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('serviceController',function($scope,$rootScope){
	$rootScope.bodyClass = '';
})
app.controller('testiController',function($scope,$rootScope, $timeout,$http){
	$scope.loader = true;
	$rootScope.bodyClass = '';
    $scope.colors = ['color0','color1', 'color2','color3','color4','color5','color6','color7'];
    $scope.reviewerData = [];

	window.fbAsyncInit = function () {
        FB.init({
            appId: '1636056169769914',
            cookie: true,
            xfbml: true,
            version: 'v2.8'
        });
        FB.AppEvents.logPageView(); 
        getReviews();    
    };


      (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
	
    function getReviews (){
		FB.api(
	    '/377668609047430/ratings', 
			 'GET',
			 { access_token: 'EAAXPZCALU67oBADyAIGyBC9SieUT5jEZAfIf4mZBlC2ZBGx4k3eMFB1G9WZBES4C29V8Y8XZByCHhOMbhXaBtn5BwZAuB3RplQJulHpFcHguUruz0ntBPr8eTSu2BP8Wolm1fZB8t3q8PZA00zFOtCtZABQF7sRyrd1C3k70q2WxfMipxVYrsz6hRk' },
		function (Response) { 
			console.log(JSON.stringify(Response));
			$scope.revWsData = Response.data;	
			$scope.revWsLoad = Response.paging;	
				$scope.re();
		});
		
    }	

    $scope.loadMore = function(url){
    	$scope.revWsData = [];
    		$scope.showRevw = false;
    		$http.get(url).then(function(response){
    			$scope.revWsData = response.data;
    			$scope.re();
    		})
    	}

   var z = 0;

    	$scope.re = function(){
    		 if(z < $scope.revWsData.length){
    		 	FB.api('/'+  $scope.revWsData[z].reviewer.id,{access_token: 'EAAXPZCALU67oBADyAIGyBC9SieUT5jEZAfIf4mZBlC2ZBGx4k3eMFB1G9WZBES4C29V8Y8XZByCHhOMbhXaBtn5BwZAuB3RplQJulHpFcHguUruz0ntBPr8eTSu2BP8Wolm1fZB8t3q8PZA00zFOtCtZABQF7sRyrd1C3k70q2WxfMipxVYrsz6hRk',fields: "id,gender,name,picture.width(200).height(200),email,birthday"}, function(response) {
				    $scope.reviewerData.push({
				    	reviewer 	: 	response,
			     		time 		:   $scope.revWsData[z].created_time,
			     		name 		:  	$scope.revWsData[z].reviewer.name,
			     		rating 		:  	$scope.revWsData[z].rating,
			     		review_text :  	$scope.revWsData[z].review_text
		     		});
		     		z = z + 1;
					$scope.re();					
				})	
    		}else{
    			$timeout(function(){
			    	$scope.loader = false;
			    },100)
		     	z = 0;		     	
		    }	
		     		      
    	}
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