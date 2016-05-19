MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav, ORDER) {

    var historia = [15];

    $scope.formBlock = true;
    $scope.index = 0;
    $scope.layer = '';

    /******************* declaracion defunciones de eventos */
    /*******incializacion de $scope*****/

    restore('provSelec');// inializa el proveedor
    restore('pedidoSelec');// inializa el pedido
    restore('odcSelec');// inializa la prden de compra
    restore('contraPedSelec');// inializa contra pedido selecionado
    restore('kitchenBoxSelec');// inializa contra pedido selecionado
    restore('FormData');//// la data del formulario
    restore('filterData');/// la data de filtros
    restore('FormDataContraP');// formulario de contra pedidos
    restore('todos');// lista de proveedores
    restore('filterOption');//selecion de los filtros
    restore('FormDataKitchenBox'); // formulario de ckitchen box
    restore('pedidoSusPedSelec'); // pedido sustitu selecionado


    $scope.setProvedor = setProvedor;
    $scope.openLayer = openLayer;
    $scope.closeLayer = closeLayer;
    //$scope.closeLayeValid=closeLayeValid;
    $scope.DtPedido = DtPedido;
    $scope.selecOdc = selecOdc;
    $scope.selecContraP = selecContraP;
    $scope.selecPedidoSust = selecPedidoSust;

    $scope.selecKitchenBox = selecKitchenBox;
    // $scope.removeLisContraP = removeLisContraP;
    //$scope.removeLisKitchenBox = removeLisKitchenBox;
    //$scope.removeLisPedidoSus = removeLisPedidoSus;
    //  carga la primera data del sistema filtros  y proveedores
    init();


    function init() {
        $http({
            method: 'POST',
            url: 'Order/OrderFilterData'
        }).then(function successCallback(response) {
            $scope.filterData.monedas = response.data.monedas;
            $scope.filterData.tipoEnv = response.data.tipoEnvio;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
        $http({
            method: 'POST',
            url: 'Order/OrderProvList'
        }).then(function successCallback(response) {
            $scope.todos = response.data;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
        loadDataFor();
    }

    /********************************************EVENTOS ********************************************/

    $scope.updateForm = function () {
        $scope.formBlock = !segurity('editPedido');
    }
    $scope.test = function () {
        alert('');
    }
    $scope.simulateClick = function (id) {
        var a = angular.element(document).find(id);
        console.log('click ', a);
        a.click();
    }

    function selecOdc(odc) {
        restore('odcSelec');
        loadOdc(odc.id);
        openLayer("resumenodc");

    }

    function selecContraP(item) {
        restore('contraPedSelec');
        var data ={id: item.id, pedido_id: $scope.pedidoSelec.id};
        if(item.tipo_origen_id){
            data.tipo_origen_id=4;
            data.renglon_id=item.renglon_id;
        }
        $http.get("Order/CustomOrder", {params: data})
            .success(function (response) {
                $scope.contraPedSelec= response;
                console.log('contra P',response);

                if(response.fecha_aprox_entrega != null){
                    $scope.contraPedSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
                }
                if(response.fecha != null){
                    $scope.contraPedSelec.fecha = new Date(Date.parse(response.fecha));

                }

            });
        $scope.formDataContraP.contraPedidoMotivo = ORDER.query({type: 'CustomOrderReason'});
        $scope.formDataContraP.contraPedidoPrioridad = ORDER.query({type: 'CustomOrderPriority'});
        //loadContraP(item.id);
        openLayer("resumenContraPedido");
    }

    function selecPedidoSust(item) {
        restore('pedidoSusPedSelec');
        $http.get("Order/OrderSubstitute", {params: {id: item.id, pedido_id: $scope.pedidoSelec.id}})
            .success(function (response) {
                $scope.pedidoSusPedSelec = response;
            });
        openLayer("resumenPedido");
    }

    function selecKitchenBox(item) {
        restore('kitchenBoxSelec');
        console.log('item id', item);
        ORDER.get({type: 'KitchenBox', id: item.id}, {}, function (response) {
            $scope.kitchenBoxSelec = response;
            if (response.fecha != null) {
                $scope.kitchenBoxSelec.fecha = new Date(Date.parse(response.fecha));
            }
            if (response.fecha_aprox_entrega != null) {
                $scope.kitchenBoxSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
            }


        });
        openLayer("resumenKitchenbox");
    }

    /** al pulsar la flecha siguiente**/
    $scope.next = function () {
        var curren = $scope.layer;
        console.log('current', curren);

        switch (curren) {
            case 'detallePedido':
                openLayer('agrPed');
                break;
        }
    }

    $scope.showNext = function (status) {
        if (status) {
            if (!$scope.FormdetallePedido.$valid) {
                alert('no validoExisten campos pendientes por completar, por favor verifica que información le falta.');
            } else {
                $mdSidenav("NEXT").open();
            }

        } else {
            $mdSidenav("NEXT").close()
        }
    }

    /*********************************************** EVENTOS CHANGE ***********************************************/
    $scope.change = function (odc) {
        if (odc.asig) {
            addOrdenCompra(odc.id, $scope.pedidoSelec.id);
        } else {
            removeOrdenCompra(odc.id, $scope.pedidoSelec.id);
        }

    }
    $scope.changeContraP = function (contraP) {
        if (contraP.asignado) {

            addContraPedido(contraP.id, $scope.pedidoSelec.id);
        } else {
            removeContraPedido(contraP.id, $scope.pedidoSelec.id);
        }

    }


    $scope.changeContraPItem = function (item) {
        item.pedido_id = $scope.pedidoSelec.id;
        if ($scope.FormResumenContra.$valid) {
            if (item.asignado) {
                var paso=true;
                if(item.renglon_id == null && item.saldo >item.cantidad){
                    alert('el monto excede la cantidad x defecto ' +
                        '\nCantidad precendente' + item.cantidad);
                }
                if(paso){
                    ORDER.post({type: 'AddCustomOrderItem'}, item, function (response) {
                        if (item.renglon_id == null) {
                            alert('asignado');
                        }
                        item.renglon_id = response.id;
                    });
                }
            } else {
                ORDER.post({type: 'RemoveCustomOrderItem'}, {id: item.renglon_id}, function (response) {
                    alert('removido');
                });

            }
        }
        /*
         else
         if(item.asignado && item.renglon_id == null){
         alert('EL monto excede la cantidad original');
         ORDER.post({type: 'AddCustomOrderItem'}, item, function (response) {
         item.renglon_id = response.id;
         });
         }*/
    }


    $scope.changeKitchenBox = function (item) {
        if (item.asignado) {

            addkitchenBox(item.id, $scope.pedidoSelec.id);
        } else {
            removekitchenBox(item.id, $scope.pedidoSelec.id);
        }

    }

    $scope.changePedidoSustituto = function (item) {

        if (item.asignado) {

            addPedidoSustituto(item.id, $scope.pedidoSelec.id);
        } else {
            removePedidoSustituto(item.id, $scope.pedidoSelec.id);
        }

    }

    $scope.changePedidoSustitutoItem = function (item) {
        item.pedido_id = $scope.pedidoSelec.id;
        if(item.asignado){
            if ($scope.FormPedidoSusProduc.$valid) {
                $http.post("Order/AddOrderSubstituteItem", item)
                    .success(function (response) {
                        if (item.renglon_id == null) {
                            alert('asignado');
                        }
                        item.renglon_id= response.renglon_id;
                    });
            }else
            // if(item.renglon_id == null)
            {
                alert('El saldo anterior supera la cantidad inicial ');
                $http.post("Order/AddOrderSubstituteItem", item)
                    .success(function (response) {
                        item.renglon_id= response.renglon_id;
                    });
            }
        }else {
            $http.post("Order/RemoveOrdenItem", {id: item.renglon_id,pedido_id:$scope.pedidoSelec.id})
                .success(function (response) {
                    alert('removido');
                });
        }

    }
    /*********************************************** EVENTOS FOCUS LOST ***********************************************/

    $scope.focusLostCpitm = function (item) {
        item.pedido_id = $scope.pedidoSelec.id;
        if (!$scope.FormResumenContra.$valid) {
            alert('warnin\n Monto Excedido no se asignara el valor');
            item.saldo = item.cantidad;
        }
    }


    function setProvedor(prov) {
        $scope.provSelec = prov;
        console.log('prov id=' + prov.id + "  scop prov =" + $scope.provSelec.id)
        loadPedidosProvedor(prov.id);
        //loadOrdenesDeCompraProveedor(prov.id);
        openLayer('listPedido');
    }

    function openLayer(layer) {

        if (historia.indexOf(layer) == -1) {
            var l = angular.element(document).find("#" + layer);
            var base = 264;
            $scope.index++;
            var w = base + (24 * $scope.index);
            l.css('width', 'calc(100% - ' + w + 'px)');
            $mdSidenav(layer).open();
            historia[$scope.index] = layer;
            $scope.layer = layer;
            return true;
        }
        return false;
    }

    function DtPedido(pedido) {

        if (pedido == 'null') {

            if (segurity('newPedido')) {
                if (openLayer('detallePedido')) {
                    $scope.formBlock = false;
                    restore('pedidoSelec');
                    if ($scope.index <= 1) {
                        restore('provSelec');
                    }
                }
            } else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        } else {
            if (segurity('editPedido')) {
                if (openLayer('detallePedido')) {
                    loadPedido(pedido.id);
                    loadDirProvider($scope.pedidoSelec.pais_id);
                }
            }
            else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        }
        $scope.FormdetallePedido.$setPristine();

    }

    function closeLayer() {
        var layer = historia[$scope.index];
        historia[$scope.index] = null;
        $scope.index--;
        $mdSidenav(layer).close();
        $scope.layer = historia[$scope.index];
    }

    /**@deprecated*/
    function closeLayeValid() {
        var layer = historia[$scope.index];
        console.log('curren layer', layer);
        var paso = true;
        switch (layer) {
            case 'resumenContraPedido':
                console.log('entro en el caso');
                if (!$scope.FormResumenContra.$valid) {
                    alert('problemas en el formulario');
                    paso = false;
                }
                break;
        }

        if (paso) {
            closeLayer();
        }
    }

    /****** **************************listener ***************************************/

    $scope.$watch('pedidoSelec.pais_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            loadDirProvider(newVal);
        }
    });

    $scope.$watch('index', function (newVal, olvValue) {
        //actualizacion segun el index layer abierto
        switch (newVal) {
            case 1:
                $scope.formBlock = true;
                ;
                break;
        }
    });


    $scope.$watch('layer', function (newVal, oldValue) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {

            switch (newVal) {
                case 'listPedido':
                    if ($scope.provSelec.id != '') {
                        loadPedidosProvedor($scope.provSelec.id);
                    }
                    break;
                case 'agrContPed':
                    loadContraPedidosProveedor($scope.provSelec.id);
                    break;
                case 'agrKitBoxs':
                    loadkitchenBoxProveedor($scope.provSelec.id);
                    break;
                case 'agrPedPend':
                    loadPedidosASustituir($scope.provSelec.id);
                    break;
                case 'agrPed':
                    loadPedido($scope.pedidoSelec.id);
                    break;
                default :
                    ;
            }
        }
    });


    $scope.$watch('provSelec.id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            loadCoinProvider(newVal);
            loadCountryProvider(newVal);
            loadPaymentCondProvider(newVal);
        }
    });

    $scope.$watch('pedidoSelec.prov_moneda_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            loadTasa(newVal);
        }
    });

    $scope.$watchGroup(['FormdetallePedido.$valid', 'FormdetallePedido.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {
            console.log('peddio', $scope.pedidoSelec);
            saveDetaillPedido();
        }
        console.log('i', i);
    });

    /*************************Guardados*************************************************/

    function saveDetaillPedido() {


        if ($scope.pedidoSelec.id == '') {
            delete $scope.pedidoSelec.id;
        }
        $scope.pedidoSelec.prov_id = $scope.provSelec.id;
        $http({
            method: 'POST',
            url: 'Order/Save',
            data: $scope.pedidoSelec
        }).then(function successCallback(response) {
            $scope.FormdetallePedido.$setPristine();
            if (response.data.success) {
                $scope.pedidoSelec.id = response.data.pedido.id;
            }
            console.log(response);
        }, function errorCallback(response) {
            console.log("errorrr");
        });

    }

    /**************************** Conversiones ****************/
    $scope.odcEstatus = function (odc) {
        if (odc.aprobada == '1') {
            return 'Aprobada';
        } else {
            return 'No Aprobada';
        }
    }


    /*********************************  peticiones  carga $http ********************* ************/

    $scope.removeList= function(item){
        var url="RemoveToOrden";
        var id=item.id;
        if(item.tipo_origen_id == 4){
            url="RemoveOrdenItem";
            id=item.renglon_id;
        }

        $http.post("Order/"+url, {id: id, pedido_id: $scope.pedidoSelec.id})
            .success(function (response) {
                alert('Eliminado');
                console.log('eliminado '+id,response);
                loadPedido($scope.pedidoSelec.id);

            });
    }
    function loadPedido(id){
        console.log();
        ORDER.post({type:'Order'},{id:id}, function(response){
            $scope.pedidoSelec = response;
        });
    }

    function loadDataFor(){
        $http({
            method: 'POST',
            url: 'Order/OrderDataForm'
        }).then(function successCallback(response) {
            $scope.formData.tipo=response.data.tipoPedido;
            $scope.formData.motivoPedido=response.data.motivoPedido;
            $scope.formData.prioridadPedido=response.data.prioridadPedido;
            $scope.formData.condicionPedido=response.data.condicionPedido;
            $scope.formData.estadoPedido=response.data.estadoPedido;
            $scope.formData.tipoDepago= response.data.tipoDepago;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }


    function loadDirProvider(id){
        $http({
            method: 'POST',
            url: 'Order/Address',
            data:{id:id}
        }).then(function successCallback(response) {
            $scope.formData.direcciones=response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadTasa(id){
        $http({
            method: 'GET',
            url: 'master/getCoin/'+id,
        }).then(function successCallback(response) {
            console.log('tasa',response);
            $scope.pedidoSelec.tasa=response.data.precio_usd;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadCoinProvider(id){

        $http({
            method: 'GET',
            url: 'provider/provCoins/'+id,
        }).then(function successCallback(response) {
            $scope.formData.monedas=response.data;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadPaymentCondProvider(id){
        $http({
            method: 'POST',
            url: 'Order/ProviderPaymentCondition',
            data:{id:id}
        }).then(function successCallback(response) {
            $scope.formData.condicionPago=response.data;
        }, function errorCallback(response) {
            console.log("erfrorrr");
        });
    }

    function loadCountryProvider(id){
        $http({
            method: 'POST',
            url: 'Order/ProviderCountry',
            data:{id:id}
        }).then(function successCallback(response) {
            $scope.formData.paises= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadPedidosProvedor(id){
        $http({
            method: 'POST',
            url: 'Order/OrderProvOrder',
            data:{ id:id}
        }).then(function successCallback(response) {
            $scope.provSelec.pedidos=response.data.pedidos;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function  loadOrdenesDeCompraProveedor(id){

        $http({
            method: 'POST',
            url: 'Order/ProviderOrder',
            data:{prov_id:id, pedido_id: $scope.pedidoSelec.id}
        }).then(function successCallback(response) {
            var odcs= new Array();
            for(var i=0;i<response.data.length;i++){
                var odc=response.data[i];
                odc.asig=false;
                if(odc.asignado != 0){
                    odc.asig=true;
                }
                odcs.push(odc);
            }
            $scope.formData.odc=odcs;
        }, function errorCallback(response) {
            console.log("errorrr");
        })
    }

    function loadOdc(id){
        $http({
            method: 'POST',
            url: 'Order/PurchaseOrder',
            data:{id:id}
        }).then(function successCallback(response) {
            $scope.odcSelec= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadContraP(id){


        $http({
            method: 'POST',
            url: 'Order/CustomOrder',
            data:{id:id, pedido_id: $scope.pedidoSelec.id}
        }).then(function successCallback(response) {
            $scope.contraPedSelec= response.data;
            console.log('contra P',response);

            if(response.data.fecha_aprox_entrega != null){
                $scope.contraPedSelec.fecha_aprox_entrega = new Date(Date.parse(response.data.fecha_aprox_entrega));
            }
            if(response.data.fecha != null){
                $scope.contraPedSelec.fecha = new Date(Date.parse(response.data.fecha));
                console.log(new Date(Date.parse(response.emision)));
            }
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }



    function loadContraPedidosProveedor(id){
        $http({
            method: 'POST',
            url: 'Order/CustomOrders',
            data:{prov_id:id, pedido_id: $scope.pedidoSelec.id}
        }).then(function successCallback(response) {
            $scope.formData.contraPedido= response.data;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadkitchenBoxProveedor(id){

        $http.post('Order/KitchenBoxs', {prov_id:id, pedido_id: $scope.pedidoSelec.id})
            .success(function(response){
                $scope.formData.kitchenBox= response;
                $scope.formData.kitchenBox.fecha = Date.parse(response.fecha);
            });

    }

    function loadPedidosASustituir(id){
        $http({
            method: 'POST',
            url: 'Order/OrderSubstitutes',
            data:{prov_id:id, pedido_id: $scope.pedidoSelec.id}
        }).then(function successCallback(response) {
            $scope.formData.pedidoSust= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    /*********************************  peticiones  guardado $http ********************* ************/

    function addOrdenCompra(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddPurchaseOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('Asignado');
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removeOrdenCompra(id,pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemovePurchaseOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('des Asignado');
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function addkitchenBox(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddkitchenBox',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removekitchenBox(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemovekitchenBox',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert(' Removido ');
            loadPedido($scope.pedidoSelec.id);
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function addContraPedido(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddCustomOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('asignado');
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removeContraPedido(id, pedido_id){

        ORDER.post({type:'RemoveCustomOrder'},{ id:id, pedido_id:pedido_id}, function(data){
            alert(' Removido ');
            loadPedido($scope.pedidoSelec.id);
        });

    }

    /*****/
    function addPedidoSustituto(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddOrderSubstitute',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function removePedidoSustituto(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemoveOrderSubstitute',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function segurity(key){
        return true;
    }
    function  restore(key){
        switch (key){
            case 'provSelec':
                $scope.provSelec={id:'',razon_social:'',save:false, pedidos: new Array() };
                break;
            case 'pedidoSelec':
                $scope.pedidoSelec={ pais_id:'', id:'',estado_id:'1',
                    prov_moneda_id:'', tasa:'0', emision:new Date()};
                break;
            case 'odcSelec':
                $scope.odcSelec={ id:''};
                break;
            case 'contraPedSelec':
                $scope.contraPedSelec={ id:''};
                break;

            case 'pedidoSusPedSelec':
                $scope.pedidoSusPedSelec={ id:''};
                break;
            case 'kitchenBoxSelec':
                $scope.contraPedSelec={ id:'', fecha: new Date()};
                break;
            case 'FormData':
                $scope.formData={  pedidos: new Array(), tipo: new Array(),  monedas: new Array(),
                    direcciones:new Array(), odc: new Array(), contraPedido: new Array(), kitchenBox: new Array(),
                    estadoPedido:new Array(), pedidoSust: new Array(),
                };
                break;
            case 'FormDataContraP':
                $scope.formDataContraP={
                    contraPedidoMotivo: new Array(),contraPedidoPrioridad: new Array()
                };
                break;
            case 'FormDataKitchenBox':
                $scope.formDataKitchenBox={
                };
                break;
            case 'filterData':
                $scope.filterData={ monedas: new Array(), tipoEnv: new Array() };
                break;
            case 'todos':
                $scope.todos = new Array();
                break;
            case 'filterOption':
                $scope.filterOption={
                    prov_id:'',
                    moneda_id:'',
                    tipo_env_id:''
                };
                break;
            default: console.log('no existe key' + key);
        }
    }
});


MyApp.factory('ORDER', ['$resource',
    function ($resource) {
        return $resource('Order/:type/:id', {}, {
            query: {method: 'GET',params: {type: "",id:""}, isArray: true},
            get: {method: 'GET',params: {type:" "}, isArray: false},
            post: {method: 'POST',params: {type:" "}, isArray: false},
            postAll: {method: 'POST',params: {type:" "}, isArray: false}

        });
    }
]);

