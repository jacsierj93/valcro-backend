MyApp.controller('pagosCtrll', function ($scope, $mdSidenav, $http, $location, $routeParams, $resource) {

    var historia = [15];
    $scope.index = index = 0;
    var base = 264;
    $scope.toolBar = {"add":true,"edit":false,"filter":false} ///botonera
    $scope.provData = {"id": '', "nombre": '', "pagos": {}, "deudas": {}, "deudas2":{}};
    $scope.debData = {"id": '', "provname": '', "provid": '', "factura": '', "cuotas": ''};
    $scope.payData = {"id": '', "provname": '', "provid": '', "factura": ''};
    $scope.abonos = {};
    $scope.provSelected = {};


    /**
     * traer proveedor actual
     * @param id
     * @returns {*}
     */
    function getProvById(id) {
        for (var d = 0, len = $scope.provs.length; d < len; d += 1) {
            if ($scope.provs[d].id === id) {
                return $scope.provs[d];
            }
        }
    }



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



    /////modificando botonera
    $scope.setTool = function(add,edit,filter){
        $scope.toolBar = {"add":add,"edit":edit,"filter":filter} ///botonera

    }
    /////retornando el valor del boton
    $scope.getToolValue = function(key){
       return $scope.toolBar[key];
    }



    $scope.getTasaByCoinId = function(id,tipo){

        $http.get('master/getCoin/'+id).success(function (response) {
            var tasa = response.precio_usd;

            if(tipo=='abono')
            $scope.abono.tasa = parseFloat(tasa).toFixed(1); ////abono
            else
            $scope.pago.tasa = parseFloat(tasa).toFixed(1); ///pago
                
            console.log("trae tasa de la moneda");
        });


    }


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


    /////lista de tipos de documento de pago
    $scope.getPayDocTypes = function () {
        $http.get('payments/payDocsList').success(function (response) {
            $scope.tipoDocsPago = response;
            console.log("tipos de documentos de pago");
        });
    };
    
    ////lista de cuentas bancarias
    $scope.getProvBankAccounts = function () {
        $http.get('payments/provider/getBankAccounts').success(function (response) {
            $scope.cuentasBancarias = response;
            console.log("trayendo cuentas bancarias del proveedor");
        });
        
    }


    ////lista de proveedores
    $scope.getProvs = function () {
        $http.get('payments/provList').success(function (response) {
            $scope.provs = response;
            console.log("lista de proveedores");
        });
    };


    //////trayendo lista de pagos sin cuota asociada


    ////setear proveedor
    $scope.setProv = function (prov) {

        $http.get('payments/getProv/' + prov.id).success(function (response) {

            ///setiando datos del proveedor
            $scope.provData.id = response.id;
            $scope.provData.nombre = response.razon_social;
            $scope.provData.pagos = response.pagos;
            $scope.provData.deudas = response.deudas;
            $scope.provData.deudas2 = response.factCuo; 

            $scope.provSelected = getProvById(response.id); ///proveedor seleccionado de la lista

            console.log("trayendo proveedor con id:" + prov.id);

        });
        



        closeLayer(true)
        openLayer("lyr1pag");

    };


    ////setear documento deuda
    $scope.setDeduda = function (doc) {

        openLayer('lyr2pag');
     //   $scope.setTool(true,"false",true); ///colocando funcion de filtro

        $http.get('payments/getDocById/' + doc.id).success(function (response) {

            ///setiando datos de la deuda
            $scope.debData.id = response.doc_id; ///id de la deuda
            $scope.debData.provname = response.prov_nombre;
            $scope.debData.provid = response.prov_id;
            $scope.debData.factura = response.doc_factura;
            $scope.debData.cuotas = response.doc_cuotas;

            console.log("trayendo datos deuda:" + doc.id);
        });

    };


    $scope.setPagoCuota = function (doc, cuota) {

        openLayer('lyr3pag')

        $http.get('payments/getDocById/' + doc.id).success(function (response) {

            ///setiando datos de la deuda (factura)
            $scope.payData.id = response.doc_id; ///id de la factura
            $scope.payData.provname = response.prov_nombre;
            $scope.payData.provid = response.prov_id;
            $scope.payData.factura = response.doc_factura;

            console.log("trayendo datos del pago de la cuota:" + cuota.id);
        });

        $scope.getCoins();
        $scope.getPayTypes();
        $scope.getAbonosNew();

    }


    $scope.setPago = function (doc) {

        openLayer('lyr3pag');

        $http.get('payments/getDocById/' + doc.id).success(function (response) {

            ///setiando datos de la deuda
            $scope.payData.provname = response.prov_nombre;
            $scope.payData.provid = response.prov_id;
            $scope.payData.factura = response.doc_factura;
            $scope.payData.id = response.doc_id; ///id de la deuda

            console.log("trayendo datos pago:" + doc.id);
        });


        $scope.getCoins();
        $scope.getPayTypes();

    }


    /////abonos al proveedor TODOS
    $scope.getAbonos = function () {

        openLayer('lyr4pag');

        $http.get('payments/getAbonos/all').success(function (response) {

            $scope.abonos = response;
          //  $scope.abono = {};

            console.log("trayendo Abonos");
        });


    }

    $scope.getAbonosNew=function () {

        $http.get('payments/getAbonos/new').success(function (response) {

            $scope.abonos2 = response;
            //  $scope.abono = {};

            console.log("trayendo Abonos sin procesar");
        });

    }



    ////formulario de registro de adelanto
    $scope.setFormAdelanto = function () {

        openLayer('lyr5pag');

     //   openLayer('lyr6pag');

        $scope.getPayDocTypes(); //tipos de documento de pago
        $scope.getPayTypes(); ///tipos de pago
        $scope.getCoins(); //monedas
        $scope.getProvBankAccounts() ///cuentas bancarias
    }


    $scope.saveFormAbono = function () {

        openLayer('lyr6pag'); ////tre lo que puedo pagar con el documento

     /*

        $http.post('payments/saveAbono', $scope.abono)
            .success(function (data, status, headers, config) {
                if(data.success){ ///guarda el registro
                //    closeLayer('lyr5pag');
                    openLayer('lyr6pag'); ////tre lo que puedo pagar con el documento
                  //  $scope.getAbonos(); ///yendo a la lista de abonos
                }else{ ///errores insertando
                    alert("falla guardando documento");
                }


            })
            .error(function (data, status, header, config) {
                console.log("Error:enviando datos del abono...")
            });*/



    }


    /////formulario de registro de pago
    $scope.saveFormPago = function () {
        $http.post('payments/savePay',$scope.pago)
            .success(function (data, status, headers, config){

                console.log(data);

            }).error(function (data, status, header, config) {
            console.log("Error:enviando datos del pago...")
        });
    }





});