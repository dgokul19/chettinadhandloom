app.controller('categoryController', function($scope, $rootScope, $routeParams, productCartApi){
    var category_id = atob($routeParams.categ_id);
    var category_code = $routeParams.categ_code;
    $scope.filter_album = [];
    
    var get_categorys = function (){
        productCartApi.filter_categories().then(function(response){
            $scope.filter_categories = response.data.data;
        })
    }

    $scope.get_album = function (code){
        for(var i in $scope.filter_categories){
            if(code == $scope.filter_categories[i].category_code){
                var params = $scope.filter_categories[i];
                productCartApi.filter_get_album(params).then(function(response){
                    $scope.filter_album = response.data.data;
                });
                return false;
            }
        };
    }

    var load_page_crumb = function (objects){
        $scope.pages = [];
        
        if(objects && objects.item_category && objects.item_category.category_name)
            $scope.pages.push(objects.item_category.category_name);
        if(objects && objects.item_album && objects.item_album.album_name)
            $scope.pages.push(objects.item_album.album_name);
        if(objects && objects.item_name)
            $scope.pages.push(objects.item_name);
    };

    $scope.load_products = function (){
        var opts = {category_id : category_id, category_code : category_code}
        productCartApi.get_category_details(opts, function(err, response){
            if (err) return console.log(err);
            if(response.status === 'success')
                $scope.categories = response.data;
            load_page_crumb($scope.categories);
        });
    }
    
        //Code Execution Starts Here
    var init = function (cb){
        get_categorys();
        cb();
    }
       
   init(function(){
        $scope.filter = {
            'category'  :  category_code,
            'album'     : 'All'
        };
        $scope.load_products();
   });
});