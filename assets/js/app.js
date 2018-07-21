var app = angular.module('chettiEcomm', 
	['ngMaterial','ngAnimate', 'ngMessages','ngRoute','jkAngularRatingStars','angularGrid']);

app.config(function($routeProvider,$locationProvider){

	$routeProvider
		.when("/",{
			templateUrl	: 	"template/home.html",
			controller	: 	"homeController"
		})
		
		.when("/journey",{
			templateUrl	: 	"template/journey.html",
			controller	: 	"journeyController"
		})

		.when("/places",{
			templateUrl	: 	"template/places.html",
			controller	: 	"placesController"
		})

		.when("/services",{
			templateUrl	: 	"template/services.html",
			controller	: 	"serviceController"
		})

		.when("/reachus",{
			templateUrl	: 	"template/contact.html",
			controller	: 	"contactCtrl"
		})

		.when("/loomspace",{
			templateUrl	: 	"template/product.html",
			controller	: 	"prodctHme"
		})

		.when("/category",{
			templateUrl	: 	"template/category.html",
			controller	: 	"categoryController"
		})

		.when("/details",{
			templateUrl	: 	"template/details.html",
			controller	: 	"detailsController"
		})

		.when("/login",{
			templateUrl	: 	"template/login.html",
			controller	: 	"loginController"
		})

		.when("/myaccount",{
			templateUrl	: 	"template/account/dashboard.html",
			controller	: 	"dashboardController"
		})
		$locationProvider.hashPrefix('');
})