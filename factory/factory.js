
var base_url = 'http://'+window.location.hostname + window.location.pathname + 'crm/api/';

app.factory('productCartApi', function($http, $mdToast){
	return{
		get_categories : function (){
			return $http({
				url : base_url + 'products/loomspace',
				method : 'GET',
			})
		},		
		filter_categories : function (){
			return $http({
				url : base_url + 'products/get-categories',
				method : 'GET',
			})
		},		
		filter_price_range : function (){
			return $http({
				url : base_url + 'products/price-range-filter',
				method : 'GET',
			})
		},		
		filter_get_album : function (params){
			var opts = {"category_id" : params.album_id, "category_code" : params.album_code};
			return $http({
				url : base_url + 'products/get-category-albums',
				method : 'POST',
				data : JSON.stringify(opts)
			})
		},	
		filter_applied : function (params, cb){
			return $http({
				url : base_url + 'products/filter-applied-call',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if (response.data.status === 'success'){
					cb(null, response.data.data);
				}
			});
		},	
		get_album_details : function (params, callback){
			return $http({
				url : base_url + 'products/get-album-products',
				method : 'POST',
				data : JSON.stringify(params)
			}).then(function(response){
				if(response.data.status === 'success'){
					callback(null, response.data);
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
					toastClass: type ? 'success' : 'error',
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
