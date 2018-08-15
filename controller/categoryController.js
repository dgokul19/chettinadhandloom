app.controller('categoryController', function($scope,$location, $rootScope, $routeParams, productCartApi){
    var album_id = atob($routeParams.album_id);
    var album_code = $routeParams.album_code;
    var category_id = 'all';
    var pr_option_id = 'all';

    $scope.loader = true;
    $scope.filter = {};
    $scope.filter_album = [];
    
    var setCategoryDetails = function(_details){
        $scope.category = {
            "name" : _details.category_name,
            "code" : _details.category_code,
            "category_cover" : _details.category_cover_picture,
            "category_description" : _details.category_description,
            "category_id" : _details.category_id
        };
        $scope.albums_details = {
            "name" : _details.album_name,
            "code" : _details.album_code,
            "album_cover" : _details.album_cover_picture,
            "album_description" : _details.album_description,
            "album_id" : _details.album_id
        };
        get_albums({"album_id" : $scope.category.category_id, "album_code" : $scope.category.code});
        $scope.filter = {"category" : $scope.category.category_id, "album" : $scope.albums_details.album_id};
    };

    var get_categorys = function (){
        productCartApi.filter_categories().then(function(response){
            $scope.filter_categories = response.data.data;
        });
    }
    var get_albums = function (opts){
        productCartApi.filter_get_album(opts).then(function(response){
            $scope.filter_album = response.data.data;
        });
    }

    var get_price_range = function (){
        productCartApi.filter_price_range().then(function(response){
            $scope.price_ranges = response.data.data;
        });
    }


    $scope.get_category_filter = function(id){
        var opts = {
            "category_id"   : id, 
            "album_id"		: "all",
        };
        $scope.filter_applied(opts);
    }

    $scope.get_album_filter = function(args){
        var opts = {
            "category_id"   : args.category || "all", 
            "album_id"		: args.album || "all",
        };
        $scope.filter_applied(opts);
    }
    
    $scope.get_price_filter = function (price_id){
        var opts = {
            "category_id"   : category_id, 
            "album_id"		: album_id,
            "pr_option_id"  : price_id
        };
        $scope.filter_applied(opts);
    };

    $scope.filter_applied = function (params){
        var opts = {
            "category_id"   : params.category_id, 
            "album_id"		: params.album_id || "all",
            "pr_option_id"	: params.pr_option_id || "all"
        };
        productCartApi.filter_applied (opts, function(err, response){
            $scope.albums_data = angular.copy(response);
            category_id     = params.category_id;
            album_id	    = params.album_id;
            pr_option_id	= params.pr_option_id;
            load_page_crumb(
                {"category_name" : $scope.albums_data && $scope.albums_data[0].category_name || '',
                "album_name" : $scope.albums_data && $scope.albums_data[0].album_name || ''},
            );
        });
    };

    var load_page_crumb = function (objects){
        $scope.pages = [];
        if(objects && objects.category_name)
            $scope.pages.push(objects.category_name);
        if(objects && objects.category_name)
            $scope.pages.push(objects.album_name);
        // console.log(' $scope.pages',  $scope.pages);
    };

    $scope.load_products = function (opts){
        productCartApi.get_album_details(opts, function(err, response){
            if (err) return console.log(err);
            if(response.status === 'success'){
                $scope.albums_data = response.data;
                $scope.loader = false;
                load_page_crumb(response.metadata);
                setCategoryDetails(response.metadata);
            }
        });
    };

    $scope.openDetails = function (item){
        // console.log(item);
        var opts = btoa(item.item_id) + '/' + item.item_code + '/' + item.item_name;
        $location.path('/products/'+ opts);
    };
    
    
    //Code Execution Starts Here
    var init = function (cb){
        get_categorys();
        get_price_range();
        cb();
    }
   init(function(){
        var opts = {"album_id" : album_id, "album_code" : album_code};
        $scope.load_products(opts);
   });
});