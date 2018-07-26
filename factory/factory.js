
var base_url = 'http://'+window.location.hostname + window.location.pathname + 'crm/api/';

app.factory('productCartApi', function($http, $mdToast){
	return{
		get_categories : function (){
			return $http({
				url : base_url + 'products/category',
				method : 'GET',
			});
		},		
		get_category_details : function (params, callback){
			return $http({
				url : base_url + 'products/list-category-products',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data.data);
				} else{
					productCartApi.showToast('error','Error!!', 'Error in data');
					callback('Error in :', response.data.err_code);
				}
			});
		},
		get_product_details : function (params, callback){
			return $http({
				url : base_url + 'products/detailed_view',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data.data);
				} else{
					productCartApi.showToast('error','Error!!', 'Error in data');
					callback('Error in :', response.data.err_code);
				}
			});
		},
		showToast : function(type, title, messages){     
			$mdToast.show(
				$mdToast.simple({
					hideDelay: 3000,
					position: 'top right fit',
					content: title + ' : ' + messages,
					toastClass: type ? 'success' : 'success',
					toastClass: type ? 'error' : 'error',
				})
			);
		}		
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
