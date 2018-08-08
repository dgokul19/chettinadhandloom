app.controller('categoryController', function($scope,$location, $rootScope, $routeParams, productCartApi){
    var category_id = atob($routeParams.categ_id);
    var category_code = $routeParams.categ_code;
    var album_id = 'all';
    var album_code = 'all';
    var pr_option_id = 'all';

    $scope.title = {};
    $scope.filter_album = [];
    
    var get_category_name = function(c_code, _categ_arrays){
        _.each(_categ_arrays, function(_line){
            if (_line.category_code == c_code){
                console.log(_line);
                $scope.title = {
                    "name" : _line.category_description
                };
            }
        });
        console.log($scope.title);
    };

    var get_categorys = function (){
        productCartApi.filter_categories().then(function(response){
            $scope.filter_categories = response.data.data;
        });
    }

    var get_price_range = function (){
        productCartApi.filter_price_range().then(function(response){
            $scope.price_ranges = response.data.data;
        });
    }


    var get_categcode_row = function(code, cb){
        for(var i in $scope.filter_categories){
            if(code === $scope.filter_categories[i].category_code){
                var params = $scope.filter_categories[i];
                return cb(null, params)
            }
        };    
    }

    $scope.get_category_filter = function (code){
        get_categcode_row(code, function(err, params){
            productCartApi.filter_get_album(params).then(function(response){
                $scope.filter_album = response.data.data;
                var opts = {category_id : params.album_id, category_code : params.category_code};
                $scope.filter_applied(opts);
                get_category_name(params.category_code, $scope.filter_categories);
            });
        });
    };

    $scope.get_album_filter = function(args){
        get_categcode_row(args.category, function(err, params){
            var opts = {
                "category_id"   : params.album_id, 
                "category_code" : params.category_code,
                "album_id"		: args.album && args.album.album_id || "all",
                "album_code"	: args.album && args.album.album_code || "all",
            };
            $scope.filter_applied(opts);
        });
    }
    
    $scope.get_price_filter = function (price_id){
        var opts = {
            "category_id"   : category_id, 
            "category_code" : category_code,
            "album_id"		: album_id,
            "album_code"	: album_code,
            "pr_option_id"  : price_id
        };
        $scope.filter_applied(opts);
    };

    $scope.filter_applied = function (params){
        var opts = {
            "category_id"   : params.category_id, 
            "category_code" : params.category_code,
            "album_id"		: params.album_id || "all",
            "album_code"	: params.album_code || "all",
            "pr_option_id"	: params.pr_option_id || "all"
        };
        productCartApi.filter_applied (opts, function(err, response){
            $scope.categories = angular.copy(response);
            category_id = params.category_id;
            category_code = params.category_code;
            album_id	= params.album_id;
            album_code	= params.album_code;
            pr_option_id	= params.pr_option_id;
        });
    };

    var load_page_crumb = function (objects){
        $scope.pages = [];
        if(objects && objects.item_category && objects.item_category.category_name)
            $scope.pages.push(objects.item_category.category_name);
        if(objects && objects.item_album && objects.item_album.album_name)
            $scope.pages.push(objects.item_album.album_name);
        if(objects && objects.item_name)
            $scope.pages.push(objects.item_name);
    };

    $scope.load_products = function (opts){
        productCartApi.get_category_details(opts, function(err, response){
            if (err) return console.log(err);
            if(response.status === 'success')
                $scope.categories = response.data;
                load_page_crumb($scope.categories);
                get_category_name(opts.category_code,  $scope.filter_categories);
        });
    };

    $scope.openDetails = function (item){
        console.log(item);
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
        $scope.filter = {
            'category'  :  category_code,
            'album'     : 'all'
        };
        var opts = {category_id : category_id, category_code : category_code};
        $scope.load_products(opts);
   });
});