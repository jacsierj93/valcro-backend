var login = angular.module('login', []);

login.controller('loginCtrll', ['$scope', '$http', function ($scope, $http) {
    var usr = lgnForm.usr;
    var pss = lgnForm.pss;

    $scope.lgn = function () {
        console.log(usr.value, pss.value);
        $http({
            method: 'POST',
            url: PATHAPP + 'api/user/login',
            data: {
                usr: usr.value,
                pss: pss.value
            }
        }).then(function successCallback(response) {
            if (response.data.success) {

                location.replace('/valcro-backend/public/#home');

                /*$("#holderLogin").animate({
                 opacity: 0
                 }, 1000, function () {
                 location.replace('angular/#home');
                 });*/
            }
        }, function errorCallback(response) {
            console.log(response);
        });


    }

}]);