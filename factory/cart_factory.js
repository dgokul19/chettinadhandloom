
var base_url = 'http://'+window.location.hostname + window.location.pathname + 'crm/api/';

app.factory('cart_factory', function($http, $mdToast){
    return {
		add_to_cart : function (params, callback){
			return $http({
				url : base_url + 'user/add-to-cart',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data);
				} else{
					callback('Error in :', response);
				}
			});
		},
		get_cart_details : function (params, callback){
			return $http({
				url : base_url + 'user/show-cart',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data.data);
				} else{
					callback(response);
				}
			});
		},
		get_address_data : function (params, callback){
			return $http({
				url : base_url + 'user/getAddress',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data.data);
				} else{
					callback(response);
				}
			});
		},
		remove_product : function (params, callback){
			return $http({
				url : base_url + 'user/remove-cart-item',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data.data);
				} else{
					callback(response);
				}
			});
		},
		showToast : function(type, title, messages){     
			$mdToast.show(
				$mdToast.simple({
					hideDelay: 3000,
					position: 'top right fit',
					content: title + ' : ' + messages,
					toastClass: type ? 'success' : 'error',
				})
			);
		}		
	}	
});