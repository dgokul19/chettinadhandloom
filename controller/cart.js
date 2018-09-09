app.controller('cartController', function($scope,$rootScope, accountFactory,cart_factory,userSession){
    var userDetails = userSession.getUserSession();
    console.log(userDetails);

    $scope.addresses = {};
    $scope.cart_summary = {};
    $scope.isValidForm = true;

    var get_countries = function (){
       cart_factory.get_countries().then(function(response){
            if(response.data.status === 'success'){
                $scope.get_countries = response.data.data;
                $scope.addresses.fields.country = '0';
            } else {
                console.log('error in country select :', response);
            }
       });
    }

    var calculate_summary = function (cart_lines){
        var total = 0.00;
        _.each(cart_lines, function(line){
        console.log(line);

           total += parseInt(line.product_quantity) * parseFloat(line.product_price);
        });
        console.log(total);
        $scope.cart_summary.sub_total = total;
    };

    var load_cart_details = function (){
        $scope.loader = true;
        var opts = {"user_id" : userDetails.userID};
        cart_factory.get_cart_details(opts, function(err, products){
            if (err) return console.log(err);
            $scope.products =  products;
            calculate_summary($scope.products)
            $scope.loader = false;
        });
    };

    var get_user_addresses = function (){
        var opts = {"user_id" : userDetails.userID};
        cart_factory.get_address_data(opts, function(err, addres_list){
            if (err) return console.log(err);
            $scope.user_addresses = addres_list;
        });
    };
    
    $scope.removeItem = function (item){
        var opts = {
            "user_id":userDetails.userID,
            "product_id":item.product_id,
        }
        cart_factory.remove_product(opts, function(err, resp){
            if (err) return console.log(err);
            if (resp == null)
                load_cart_details();
        });
    };

    var get_phone_code = function (country_id){
        _.each($scope.get_countries, function(list){
            if (list.id == country_id)
                $scope.addresses.fields.ph_country_code = list.phonecode;
        });
    };

    $scope.updateLineQuantity = function (line){
        console.log(line);
        if(line.product_quantity != ''){
            var opts = {
                user_id : userDetails.userID,
                product_id :  line.product_id,
                quantity : line.product_quantity
            }
            cart_factory.update_line_qty(opts, function(err, data){
                if(err) console.log(err);
                load_cart_details();
            });
        }
    };

    $scope.addresses = {
        fields: {
            full_name : '',
            address_line_1 : '',
            address_line_2 : '',
            country : '',
            state : '',
            city : '',
            ph_country_code : '',
            pincode : '',
            phone_number : '',
        },
        onChangeCountry : function(country_id){
            cart_factory.get_state(country_id).then(function(response){
                if(response.data.status === 'success'){
                    $scope.states_list = response.data.data;
                    $scope.addresses.fields.state = $scope.states_list[0].id;
                    get_phone_code(country_id);
                } else {
                    console.log('error in country select :', response);
                }
            });
        },
        onChangeState : function (state_id){
            cart_factory.get_city(state_id).then(function(response){
                if(response.data.status === 'success'){
                    $scope.cities_list = response.data.data;
                    $scope.addresses.fields.city = $scope.cities_list && $scope.cities_list[0] && $scope.cities_list[0].id || 0;
                    console.log(' $scope.cities_list :', $scope.cities_list);
                } else {
                    console.log('error in country select :', response);
                }
            });
        },
        formSubmit : function (addresses) {
            console.log('addresses=======', addresses);
            if (addresses.full_name == '' || addresses.address_line_1 == '' || addresses.address_line_2 == ''
                ||( addresses.country == '' ||  addresses.country == '0') || (addresses.state == '' || addresses.state == '0') || (addresses.city == '' || addresses.city == '0') || addresses.pincode == '' || addresses.phone_number == ''){
                $scope.isValidForm = false;
            } else {
                $scope.isValidForm = true;
                addresses.user_id = userDetails.userID;
                addresses.title = '',
                cart_factory.save_addresses(addresses, function(data){
                    $scope.active_card =  data.item_id;
                    get_user_addresses();
                });
            }
        }
    };

     var init = function (){
        get_countries();
        get_user_addresses();
        load_cart_details();
     };

    if(userDetails){
        init();
    } else {
        location.href = "#/loomspace"
    }
});