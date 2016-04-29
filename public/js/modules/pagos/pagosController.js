MyApp.controller('pagosCtrll', function ($scope,$mdSidenav) {

    /*var historial= [20];
    $scope.toggleLeft = function() {
        $mdSidenav("left").close().then(function () {
            $mdSidenav("left").open();
        })
    }*/

    $scope.lyrOpenClose = function(navID) {
        //console.log(navID);
        $mdSidenav(navID).open();

    }


    function init(){
        // cargar proveedores
    }


});



/*
MyApp.controller('ListProvPag', function ($scope,$http) {
    $http({
        method: 'POST',
        url: 'provider/provList'
    }).then(function successCallback(response) {
        $scope.todos = response.data;
    }, function errorCallback(response) {
        console.log("errorrr");
    });

});*/