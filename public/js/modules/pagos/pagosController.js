MyApp.controller('pagosCtrll', function ($scope, $mdSidenav, $http, $location, $routeParams, $resource) {

    var historia = [15];
    $scope.index = index = 0;
    var base = 264;
    $scope.provData = {"nombre": '', "pagos": {}, "deudas": {}};
    $scope.debData = {"provname": '', "provid": '', "factura": '', "cuotas":''};
    $scope.payData = {"provname": '', "provid": '', "factura": ''};

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

    /////lista monedas
    $scope.getCoins = function () {
        $http.get('master/getCoins').success(function (response) {
            $scope.monedas = response;
            console.log("lista de monedas");
        });
    };


    $scope.tipoPagoSel = "";

    /////lista de formas de pago
    $scope.getPayTypes = function () {
        $http.get('payments/typeList').success(function (response) {
            $scope.tipoPagos = response;
            console.log("tipos de pago");
        });
    };


    ////lista de proveedores
    $scope.getProvs = function () {
        $http.get('payments/provList').success(function (response) {
            $scope.provs = response;
            console.log("lista de proveedores");
        });
    };


    ////setear proveedor
    $scope.setProv = function (prov) {

        $http.get('payments/getProv/' + prov.id).success(function (response) {

            ///setiando datos del proveedor
            $scope.provData.nombre = response.razon_social;
            $scope.provData.pagos = response.pagos;
            $scope.provData.deudas = response.deudas;

            console.log("trayendo proveedor con id:" + prov.id);
        });

        //  closeLayer(true);
        openLayer('lyr1pag');

    };


    ////setear documento deuda
    $scope.setDeduda = function (doc) {

        openLayer('lyr2pag');

        $http.get('payments/getDocById/' + doc.id).success(function (response) {

            ///setiando datos de la deuda
            $scope.debData.provname = response.prov_nombre;
            $scope.debData.provid = response.prov_id;
            $scope.debData.factura = response.doc_factura;
            $scope.debData.cuotas = response.doc_cuotas;

            console.log("trayendo datos deuda:" + doc.id);
        });

    };

    


    $scope.setPago = function (doc) {

        openLayer('lyr3pag');

        $http.get('payments/getDocById/' + doc.id).success(function (response) {

            ///setiando datos de la deuda
            $scope.payData.provname = response.prov_nombre;
            $scope.payData.provid = response.prov_id;
            $scope.payData.factura = response.doc_factura;

            console.log("trayendo datos pago:" + doc.id);
        });
        

        $scope.getCoins();
        $scope.getPayTypes();

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