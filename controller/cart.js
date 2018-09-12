app.controller('cartController', function($scope,$mdToast,$rootScope,$timeout,accountFactory,cart_factory,userSession){
    var userDetails = userSession.getUserSession();
    console.log(userDetails);

    $scope.addresses = {};
    $scope.cart_summary = {
        "sub_total" : '0.00',
        "shipping_amount" : '0.00'
    };
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
           total += parseInt(line.product_quantity) * parseFloat(line.product_price);
        });
        $scope.cart_summary.sub_total = total.toFixed(2);
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
            $scope.selected_addr = $scope.user_addresses[$scope.user_addresses.length - 1].item_id;
            $scope.cart_summary.shipping_amount = parseFloat($scope.user_addresses[$scope.user_addresses.length - 1].shipping_cost).toFixed(2);

            $scope.user_addresses[$scope.user_addresses.length - 1].sortByFilter = '1';
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
        if(line.product_quantity != ''){
            var opts = {
                user_id : userDetails.userID,
                product_id :  line.product_id,
                quantity : line.product_quantity
            }
            cart_factory.update_line_qty(opts, function(err, data){
                if(err) console.log(err);
                load_cart_details();
                showToast('Success', '', 'Quantity has been updated');
            });
        }
    };

    $scope.selected_address = function (obj){
        $scope.selected_addr = obj.item_id;
        $scope.cart_summary.shipping_amount = parseFloat(obj.shipping_cost).toFixed(2);
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
            if (addresses.full_name == '' || addresses.address_line_1 == '' || addresses.address_line_2 == ''
                ||( addresses.country == '' ||  addresses.country == '0') || (addresses.state == '' || addresses.state == '0') || (addresses.city == '' || addresses.city == '0') || addresses.pincode == '' || addresses.phone_number == ''){
                $scope.isValidForm = false;
            } else {
                $scope.isValidForm = true;
                addresses.user_id = userDetails.userID;
                addresses.title = '',
                cart_factory.save_addresses(addresses, function(data){
                    $scope.addresses = {};
                    $scope.addressForm.$setPristine();
                    $scope.show_new = false;
                    get_user_addresses();
                });
            }
        }
    };

    var showToast  =  function(type, title, messages){     
        $mdToast.show(
            $mdToast.simple({
                hideDelay: 3000,
                position: 'top right fit',
                content: title + ' : ' + messages,
                toastClass: type ? 'success' : 'error',
            })
        );
    }		

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