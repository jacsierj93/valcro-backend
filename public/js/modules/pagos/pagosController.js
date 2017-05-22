MyApp.factory('pays', ['$resource',function ($resource) {
        return $resource('payments/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            filt: {method: 'POST', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.factory('master', ['$resource',function ($resource) {
        return $resource('master/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            filt: {method: 'POST', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.controller('pagosCtrll', ['$scope', '$mdSidenav', '$http', 'Upload', 'pays', 'master', function ($scope, $mdSidenav, $http, Upload, pays, master) {

        // funcion para apertura de layer --------
        $scope.nxtAction = null;
        $scope.$watchGroup(['module.layer', 'module.index'], function (nvo, old) {
            $scope.index = nvo[1];
            $scope.layerIndex = nvo[0];
            $scope.layer = nvo[0];
        });

        $scope.validForm = function(){
            //return true;
           var x = $scope.fmrAbonos.$valid;
           if(!x){
               $scope.NotifAction("alert",'debe terminar los campos de formulario',[],{autohidden:2000});
           }
           return x;
        }

        $scope.gotoPage = function(){
            $scope.LayersAction({open:{name:"lyr6pag"}});
        }

        // Variables generales -------------
        var historia = [15];
        $scope.index = 0;
        var base = 264;
        $scope.toolBar = {"add": true, "edit": false, "filter": false}; ///botonera
        $scope.provData = {"id": '', "nombre": '', "pagos": [], "deudas": [], "deudas2": []};

        $scope.isShow = true;

        $scope.pago = {
            "id": null,
            "nro_doc": null,
            "fecha": null,
            "monto": 0,
            "moneda_id": null,
            "tasa": null,
            "tipo_id": null,
            "docs":[]
        };
        
        
        /**
         * funcion que resetea el valor de los objetos segun la opcion colocada
         */
        $scope.resetPayElement = function (opc) {

            if (opc == 'abono')
                $scope.abono = {"monto": '', "monto_rec": 0.0, "monto_recp": 0.0};

            if (opc == 'all') {
                ////elementos
                $scope.provData = {"id": '', "nombre": '', "pagos": [], "deudas": [], "deudas2": []};
                $scope.debData = {
                    "id": '',
                    "provname": '',
                    "provid": '',
                    "factura": '',
                    "cuotas": '',
                    "actual": '',
                    'total': 0.0,
                    'total2': 0.0, ///backup
                    'saldo': 0.0,
                    'saldo2': 0.0 ///backup
                };
                $scope.payData = {"id": '', "provname": '', "provid": '', "factura": ''};
                //$scope.pago = {"monto": ''};
                $scope.abonos = [];
                $scope.abonos2 = [];
                $scope.abono = {"monto": '', "monto_rec": 0.0, "monto_recp": 0.0};
                $scope.provSelected = [];
                $scope.deudaList = [];
            }

        };


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


        ///////calculo del recargo del abono
        $scope.getRecargoPercent = function (opc) {

            if (opc == 'r') ///rec
                $scope.abono.monto_recp = (($scope.abono.monto_rec * 100) / $scope.abono.monto).toFixed(2);
            else if (opc == 'p') ///%
                $scope.abono.monto_rec = (($scope.abono.monto * $scope.abono.monto_recp) / 100).toFixed(2);
            else {
                $scope.abono.monto_recp = (($scope.abono.monto_rec * 100) / $scope.abono.monto).toFixed(2);
                $scope.abono.monto_rec = (($scope.abono.monto * $scope.abono.monto_recp) / 100).toFixed(2);
            }

        };


        /**
         * rebaja o aumenta la deuda segun los documento y el monto del pago
         * @param abono
         * @param montoUsado
         */
        $scope.calculateDeuda2 = function (abonos2, pago) {
            console.log(abonos2);
            var tempAbono = 0;
            var tempSaldo = 0;
            var tempPago = (pago.monto == undefined) ? 0 : pago.monto;

            for (var d = 0, len = $scope.abonos2.length; d < len; d += 1) {
                if ($scope.abonos2[d].asignado == true) {
                    tempAbono = Number(tempAbono) + Number($scope.abonos2[d].montoUsado);
                    tempSaldo = Number(tempSaldo) + Number($scope.abonos2[d].montoUsado);
                } else {
                    $scope.abonos2[d].montoUsado = Number($scope.abonos2[d].saldo);
                }
            }

            $scope.debData.total = tempAbono + Number(tempPago);
            $scope.debData.saldo = Number($scope.debData.saldo2) - Number(tempSaldo) - Number(tempPago);

        };


        function openLayer(layr) {
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
                $scope.LayersAction({close:true});
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
        $scope.setTool = function (add, edit, filter) {
            $scope.toolBar = {"add": add, "edit": edit, "filter": filter}; ///botonera

        };
        /////retornando el valor del boton
        $scope.getToolValue = function (key) {
            return $scope.toolBar[key];
        };


        $scope.getTasaByCoinId = function (id, tipo) {

            $http.get('master/getCoin/' + id).success(function (response) {
                var tasa = response.precio_usd;

                if (tipo == 'abono')
                    $scope.abono.tasa = parseFloat(tasa).toFixed(1); ////abono
                else
                    $scope.pago.tasa = parseFloat(tasa).toFixed(1); ///pago

                console.log("trae tasa de la moneda");
            });


        };


        $scope.showNext = function (status, to) {
            if (status) {

                $scope.nextLyr = to;
                //console.log($scope.nextLyr);
                $mdSidenav("NEXT").open();
            } else {
                $mdSidenav("NEXT").close();
            }
        };

        /*$scope.lyrOpenClose = function(navID) {
         //console.log(navID);
         $mdSidenav(navID).open();
         
         };*/

        $scope.monedaSel = "";

        /////lista monedas
        //$scope.monedas = master.query({type:'getCoins'});
        $scope.getCoins = function () {
            $http.get('payments/getCoins').success(function (response) {
                $scope.monedas = response;
                console.log($scope.monedas);
                console.log("lista de monedas");
            });
        };


        $scope.tipoPagoSel = "";

        /////lista de formas de pago
        $scope.tipoPagos = pays.query({type:'typeList'});
        /*$scope.getPayTypes = function () {
            $http.get('payments/typeList').success(function (response) {
                $scope.tipoPagos = response;
                console.log("tipos de pago");
            });
        };*/


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
        };


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


            $scope.resetPayElement("all");
            closeLayer(true);
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
                $scope.debData.factura_tipo = response.factura_tipo;

                console.log("trayendo datos deuda:" + doc.id);
            });

        };


        $scope.setPagoCuota = function (doc, cuota, actual) {

            openLayer('lyr3pag');

            $http.get('payments/getDocById/' + doc.id).success(function (response) {

                ///setiando datos de la deuda (factura)
                $scope.payData.id = response.doc_id; ///id de la factura
                $scope.payData.provname = response.prov_nombre;
                $scope.payData.provid = response.prov_id;
                $scope.payData.factura = response.doc_factura;


                $scope.debData.actual = actual; ///cuota a pagar en  caso de...
                $scope.debData.total = 0;
                $scope.debData.total2 = 0;
                $scope.debData.saldo = cuota.saldo;
                $scope.debData.saldo2 = cuota.saldo;

                console.log("trayendo datos del pago de la cuota:" + cuota.id);
            });

            $scope.getCoins();
            //$scope.getPayTypes;
            $scope.getAbonosNew();

        };


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

        };


        /////abonos al proveedor TODOS
        $scope.getAbonos = function () {

            openLayer('lyr4pag');

            $http.get('payments/getAbonos/all').success(function (response) {

                $scope.abonos = response;
                //  $scope.abono = [];

                console.log("trayendo Abonos");
            });


        };

        $scope.getAbonosNew = function () {

            $http.get('payments/getAbonos/new').success(function (response) {

                $scope.abonos2 = response;
                //  $scope.abono = [];

                console.log("trayendo Abonos sin procesar");
            });

        };


        ////formulario de registro de adelanto
        $scope.setFormAdelanto = function () {

            openLayer('lyr5pag');

            //   openLayer('lyr6pag');

            $scope.getPayDocTypes(); //tipos de documento de pago
            $scope.getPayTypes(); ///tipos de pago
            $scope.getCoins(); //monedas
            $scope.getProvBankAccounts(); ///cuentas bancarias
        };


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


        };
        
        $scope.ctrl = {};
        $scope.ctrl.searchCoin = undefined;

        $scope.validFormPago = function(){
            //return true;
           var x = $scope.formPagoCuota.$valid;
           console.log($scope.formPagoCuota);
           if(!x){
               $scope.NotifAction("alert",'debe terminar los campos de formulario',[],{autohidden:2000});
           }
           return x;
        };

        $scope.showErrFormPago = function(){
            alert("prueba");
        };


        /////formulario de registro de pago
        $scope.saveFormPago = function () {

            
            for (var d = 0, len = $scope.abonos2.length; d < len; d += 1) {
                if ($scope.abonos2[d].asignado == true) {
                    $scope.pago.docs.push($scope.abonos2[d]);
                }
            }
            
            console.log($scope.pago);
            
            /*$http.post('payments/savePay', $scope.pago).success(function (data, status, headers, config) {

                        console.log(data);
                        //  $scope.NotifAction("alert","por favor escriba un monto",[{"name":"aceptar","action":null,"default":5}],{"autohidden":5})

                    }).error(function (data, status, header, config) {
                console.log("Error:enviando datos del pago...");
            });*/
        };





        /********SUBIDA DE ARCHIVOS ********/
        $scope.uploaded = [];
        $scope.uploadNow = '';

        $scope.$watch('files', function () {
            $scope.upload($scope.files);
        });
        $scope.$watch('file', function () {
            if ($scope.file != null) {
                $scope.upload([$scope.file]);
            }
        });


        $scope.upload = function (files) {
            if (files && files.length) {
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    Upload.upload({
                        url: 'payments/upload',
                        file: file
                    }).progress(function (evt) {
                        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                        uploadNow = progressPercentage;

                        console.log('subiendo: ' + progressPercentage + '% ' + evt.config.file.name);
                    }).success(function (data, status, headers, config) {
                        console.log('archivo subido con exito ' + config.file.name + ' uploaded. Response: ' + data);
                        $scope.uploadNow = data;
                        //   $scope.getfiles();
                    });
                }
            }
        };




    }]);
