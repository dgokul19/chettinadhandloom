
var base_url = 'http://'+window.location.hostname + window.location.pathname + 'crm/api/';

app.factory('productCartApi',function($http){
	return{
		api : function (){
			return $http({
				url : base_url + 'products/category',
				method : 'GET',
			});
		},		
	}	
});
app.factory('emailSubbs',function($http){
	return{
		getDetails : function(data) {
			data = JSON.stringify(data);
	    	return $http({
	    		url: 'http://192.168.1.107/chettinad/app/newsfeed/subscribe-newsletter?data='+data,
	            method: 'GET'
	    	})
	    },
	}	
});
