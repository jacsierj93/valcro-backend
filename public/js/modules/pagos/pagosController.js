

MyApp.controller('pagosCtrll', function ($scope, $mdSidenav, $http, $location, $routeParams, $resource) {

    var historia = [15];
    $scope.index = index = 0;
    var base = 264;

    function openLayer(layr) {
        console.log(layr);
        $scope.showNext(false);
        var layer = layr || $scope.nextLyr;
        if (historia.indexOf(layer) == -1 && layer != "END") {
            var l = angular.element("#" + layer);
            $scope.index++;
            var w = base + (24 * $scope.index);
            l.css('width', 'calc(100% - ' + w + 'px)');
            $mdSidenav(layer).open();
            historia[$scope.index] = layer;
            return true;
        } else if (historia.indexOf(layer) == -1 && layer == "END") {
            closeLayer(true);
        }
    }

    function closeLayer(all) {
        if (all) {
            while ($scope.index != 0) {
                var layer = historia[$scope.index];
                historia[$scope.index] = null;
                $scope.index--;
                $mdSidenav(layer).close();
            }
        } else {
            layer = historia[$scope.index];
            historia[$scope.index] = null;
            $scope.index--;
            $mdSidenav(layer).close();
        }
    }

    $scope.openLayer = openLayer;
    $scope.closeLayer = closeLayer;

    $scope.showNext = function (status, to) {
        if (status) {
            $scope.nextLyr = to;
            //console.log($scope.nextLyr);
            $mdSidenav("NEXT").open()
        } else {
            $mdSidenav("NEXT").close()
        }
    };

    /*$scope.lyrOpenClose = function(navID) {
     //console.log(navID);
     $mdSidenav(navID).open();

     };*/

    $scope.monedaSel = "";
    $scope.monedas = [{
        id : 1,
        nombre: "dolar"
    },{
        id : 2,
        nombre: "Euro"
    },{
        id : 3,
        nombre: "Yen"
    }];


    $scope.tipoPagoSel = "";
    $scope.tipoPagos = [{
        id : 1,
        nombre: "Tranferencia"
    },{
        id : 2,
        nombre: "Cheque"
    },{
        id : 3,
        nombre: "Efectivo"
    }];
    
    
    ////lista de proveedores
    $scope.getProvs = function() {
        $http.get('payments/provList').success(function(response){
            $scope.provs = response;
            console.log("trayendo lista de proveedores");
        });
    };





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