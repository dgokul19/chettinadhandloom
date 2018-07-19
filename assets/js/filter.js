app.filter('reviewFilter', function () {
    return function (input) {
        var result = [];
        angular.forEach(items, function (value, key) {
            angular.forEach(value, function (value2, key2) {
                if (value2 === search) {
                    result.push(value2);
                }
            })
        });
        return result;

    }
});