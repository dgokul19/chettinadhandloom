app.directive('footerTemplate',function(){
	 return {
        restrict	: 	'AE',
		template	: 	'<footer class="subpages" ng-controller="footyCtrl">'+
			'<h3 class="txtCenter news_titl">NEWSLETTER SIGNUP</h3>'+
			'<p class="txtCenter news_sub">Get the latest news and special offers.</p>'+
			'<div class="layout-row layout-align-center-center">'+
				'<md-input-container class="flex-40 subscrbInp">'+
					'<label>Subscribe our newsletter</label>'+
					'<input type="text" ng-model="subsEmail">'+
				'</md-input-container>'+
				'<md-button class="md-primary subscrbBtn" ng-click="subsCEmail()">SUBMIT</md-button>'+
			'</div>'+

			'<div class ="footDivs layout-row">'+
				'<div class="container">'+
					'<div class="col-sm-3 footBox">'+
						'<h4>QUICK LINKS</h4>'+
						'<ul class="list-unstyled">'+
							'<li><a href="">Store Location</a></li>'+
							'<li><a href="">My Account</a></li>'+
							'<li><a href="">Size Guide</a></li>'+
							'<li><a href="">Terms & Condition</a></li>'+
							'<li><a href="">Return & Exchange</a></li>'+
						'</ul>'+
					'</div>'+

					'<div class="col-sm-3 footBox">'+
						'<h4>SHOP MENU</h4>'+
						'<ul class="list-unstyled">'+
							'<li><a href="">Accessories</a></li>'+
							'<li><a href="">Cotton Saree</a></li>'+
							'<li><a href="">Traditional Saree</a></li>'+
							'<li><a href="">Chettinaad Special</a></li>'+
							'<li><a href="">Blog</a></li>'+
						'</ul>'+
					'</div>'+

					'<div class="col-sm-3 footBox">'+
						'<h4>HELP</h4>'+
						'<ul class="list-unstyled">'+
							'<li><a href="">Contact us</a></li>'+
							'<li><a href="">Track Order</a></li>'+
							'<li><a href="">FAQs</a></li>'+
							'<li><a href="">Shiping & Delivery</a></li>'+
							'<li><a href="">Privacy Policy</a></li>'+
						'</ul>'+
					'</div>'+

					'<div class="col-sm-3 footBox">'+
						'<h4>GET IN TOUCH</h4>'+
						'<ul class="list-unstyled">'+
							'<li><a href="">Facebook</a></li>'+
							'<li><a href="">Twitter</a></li>'+
							'<li><a href="">Google +</a></li>'+
							'<li><a href="">Instagram</a></li>'+
							'<li><a href="">LinkedIn</a></li>'+
						'</ul>'+
					'</div>'+
				'</div>'+
			'</div>'+
		'</footer>'+
						'<div class="finalFt">'+
				          	'<div class="container">'+
				            	'<p class="margin0 pull-left">ChettinaadHandloom &copy; 2017 - All Rights Reserved</p>'+
				              	
				              	'<ul class="pull-right list-unstyled layout-row margin0">'+
				              		'<li><a href="">Home</a></li>'+
									'<li><a href="">Contact us</a></li>'+
									'<li><a href="">About us</a></li>'+
									'<li><a href="">Shop</a></li>'+
								'</ul>'+
							'</div>'+
						'</div>'
    };
})
app.directive('menuToggle',function(){
	 return {
          link: function ($scope, elem, attrs) {
              elem.bind('click', function () {
                  elem.siblings('.collapse.navbar-collapse').slideToggle();
              })
          }
      };
})