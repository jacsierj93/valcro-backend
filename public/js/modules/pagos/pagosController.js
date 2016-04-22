MyApp.controller('pagosCtrll', function ($scope,$mdSidenav,$http,setGetProv) {


    $scope.toggleLeft = function() {
        setGetProv.setProv(false)
        $mdSidenav("left").close().then(function () {
            $mdSidenav("left").open();
        })
    }

    //$scope.toggleRight = buildToggler(navID);
    $scope.lyrOpenClose = function(navID) {
        $mdSidenav(navID).toggle();
    }




});