app.factory('socialfac',function($http){
	return{
		loginDetails : function(data) {
	    	return $http({
	    		url: 'http://192.168.1.107/chettinad/app/enquiry/submit',
	            method: 'POST',
	            data:JSON.stringify(data),
	            contentType : "application/x-www-form-urlencoded"
	    	});
	    },	    
	    contactFrm : function(data) {
	    	return $http({
	    		url: 'http://192.168.1.107/chettinad/app/enquiry/submit',
	            method: 'POST',
	            data:JSON.stringify(data),
	            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
	    	});
	    },
	    fbregister : function(data) {
	    	return $http({
	    		url: 'http://192.168.1.107/chettinad/app/checklogin/sign-up',
	            method: 'POST',
	            data:JSON.stringify(data),
	             headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
	    	});
	    },	
	    useregister : function(data) {
	    	return $http({
	    		url: 'http://192.168.1.107/chettinad/app/checklogin/sign_up',
	            method: 'POST',
	            data:JSON.stringify(data),
	             headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
	    	});
	    },
	    loginDets : function(data) {
	    	return $http({
	    		url: 'http://192.168.1.107/chettinad/app/checklogin/authenticate',
	            method: 'POST',
	            data:JSON.stringify(data),
	             headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
	    	});
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
app.factory('userAccount', function($http){
	return {
		userRegistr   : function(data){
			return $http ({
				url: 'http://192.168.1.107/chettinad/app/enquiry/submit',
	            method: 'POST',
	            data:JSON.stringify(data),
	            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'},
			})
		}
	}
})
