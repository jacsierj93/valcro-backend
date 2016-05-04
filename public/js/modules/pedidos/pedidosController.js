MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav, Order) {

    var historia= [15];
    var index=0;
    /******************* declaracion defunciones de eventos */
    $scope.setProvedor= setProvedor;
    $scope.openLayer=openLayer;
    $scope.selecPedido=selecPedido;
    $scope.closeLayer=closeLayer;
    $scope.addPedido=addPedido;
    $scope.openContraPedido =openContraPedido;
    $scope.addkitChenBox =addkitChenBox;
    $scope.openOdcs =openOdcs;
    $scope.selecOdc=selecOdc;
    $scope.removeLisContraP=removeLisContraP;


    /*******incializacion de $scope*****/
    $scope.todos = new Array();
    $scope.provSelec={id:'-1',razon_social:'', pedidos: new Array() }
    $scope.id= $scope.provSelec.id;
    $scope.pedidoSelec={ pais_id:'-1', id:''}
    $scope.odcSelec={ id:'-1'}
    $scope.filterData={ monedas: new Array(), tipoEnv: new Array() }
    $scope.formData={  pedidos: new Array(), tipo: new Array(),  monedas: new Array(),
        direcciones:new Array(), odc: new Array(), contraPedido: new Array(), kitchenBox: new Array()
    }
    //  carga la primera data del sistema filtros  y proveedores
    init();
    function init(){
        $http({
            method: 'POST',
            url: 'Order/OrderFilterData'
        }).then(function successCallback(response) {
            $scope.filterData.monedas=response.data.monedas;
            $scope.filterData.tipoEnv=response.data.tipoEnvio;
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
    }

    /********************************************EVENTOS ********************************************/

    function removeLisContraP(aux){
        removeContraPedido(aux.id,$scope.pedidoSelec.id);
        loadPedido($scope.pedidoSelec.id);
    }
    function selecOdc (odc){
        loadOdc(odc.id);
        openLayer("resumenodc");
    }

    function openOdcs(){
        loadOrdenesDeCompraProveedor($scope.provSelec.id);
        openLayer('odc');
    }

    function openContraPedido(){
        openLayer("agrContPed");
        loadContraPedidosProveedor($scope.provSelec.id);
    }

    function addkitChenBox(){
        openLayer("agrKitBoxs");
        loadkitchenBoxProveedor($scope.provSelec.id);

    }

    /** al pulsar la flecha siguiente**/
    $scope.next = function (){
        var  curren= historia[index];
        switch (curren){
            case 'detallePedido':
                openLayer('agrPed')
                break;
        }
    }

    $scope.showNext = function(status){
        if(status){
            $mdSidenav("NEXT").open()
        }else{
            $mdSidenav("NEXT").close()
        }
    }


    $scope.change= function(odc){
        if(odc.asig){
            addOrdenCompra(odc.id,$scope.pedidoSelec.id);
        }else{
            removeOrdenCompra(odc.id);
        }
        loadPedido($scope.pedidoSelec.id);
    }



    $scope.changeContraP= function(contraP){
        if(contraP.asig){

            addContraPedido(contraP.id,$scope.pedidoSelec.id);
        }else{
            removeContraPedido(contraP.id, $scope.pedidoSelec.id);
        }
        loadPedido($scope.pedidoSelec.id);
    }

    $scope.changeKitchenBox= function(contraP){
        if(contraP.asig){

            addkitchenBox(contraP.id,$scope.pedidoSelec.id);
        }else{
            removekitchenBox(contraP.id, $scope.pedidoSelec.id);
        }
        loadPedido($scope.pedidoSelec.id);
    }
    //al selecionar provedor
    function setProvedor(prov){
        $scope.id=prov.id;
        $scope.provSelec=prov;
        loadPedidosProvedor(prov.id);
        loadOrdenesDeCompraProveedor(prov.id);
        openLayer('listPedido');
    }

    function openLayer(layer){
        if(historia.indexOf(layer)==-1){
            var l=angular.element(document).find("#"+layer);
            console.log('layer ',l);
            var base =264;
            index++;
            var w= base+(24*index);
            console.log(' width', w);
            l.css('width','calc(100% - '+w+'px)');
            $mdSidenav(layer).open();
            historia[index]=layer;
            return true;
        }
        return false;
    }



    function addPedido(){
        if(openLayer('detallePedido')){
            loadDataFor();
            loadCoinProvider($scope.id);
            loadCountryProvider($scope.id);
            loadPaymentCondProvider($scope.id);
            $scope.pedidoSelec={
                pais_id:'',
                id:''
            }
            $scope.FormdetallePedido.$setPristine();
        }



    }

    function selecPedido(pedido){
        openLayer('detallePedido');
        loadDataFor();
        loadPedido(pedido.id);
        loadCoinProvider(pedido.prov_id);
        loadCountryProvider(pedido.prov_id);
        loadPaymentCondProvider(pedido.prov_id);
        loadDirProvider($scope.pedidoSelec.pais_id);
    }

    function closeLayer(){
        var layer=historia[index];
        historia[index]=null;
        index--;
        $mdSidenav(layer).close();
        switch (layer){
            case 'odc':
                loadPedido($scope.pedidoSelec.id);
                break;

        }
    }

    $scope.setPed= function(ped){
        openLayer(ped);
    }
    /*******por integrar***/
    $scope.setPed= function(ped){

        openLayer(ped);

    }
    var i=0;
    /****** **************************listener ***************************************/

    $scope.$watch('pedidoSelec.pais_id',function(newVal){
        if(newVal != '-1'){
            loadDirProvider(newVal);
        }
    });

    $scope.$watchGroup(['FormdetallePedido.$valid','FormdetallePedido.$pristine'], function(nuevo) {
        //alert(nuevo);
        i++;
        console.log('estado',nuevo);
        if(nuevo[0] && !nuevo[1]) {
            console.log('peddio',$scope.pedidoSelec);
            saveDetaillPedido();
        }
        console.log('i', i);
    });

    /*************************Guardado*************************************************/
    //$scope.saveDetaillPedido=saveDetaillPedido;
    function saveDetaillPedido (){

        if($scope.pedidoSelec.id == ''){
            delete $scope.pedidoSelec.id;
        }
        $scope.pedidoSelec.prov_id=$scope.id;
        console.log('send pedido ',$scope.pedidoSelec);
        $http({
            method: 'POST',
            url: 'Order/Save',
            data:$scope.pedidoSelec
        }).then(function successCallback(response) {
            $scope.FormdetallePedido.$setPristine();
            if(response.data.success){
                $scope.pedidoSelec.id=response.data.pedido.id;
            }
            console.log(response);


        }, function errorCallback(response) {
            console.log("errorrr");
        });

    }

    /**************************** Conversiones ****************/
    $scope.odcEstatus= function(odc){
        if(odc.pedido_id!=null){
            return 'Asignada';
        }else {
            return 'No asignada';
        }
    }


    /*********************************  peticiones $http ********************* ************/

    function loadPedido(id){
        $http({
            method: 'POST',
            url: 'Order/Order',
            data:{ id:id}
        }).then(function successCallback(response) {
            $scope.pedidoSelec=response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        })
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

    function loadCoinProvider(id){
        $http({
            method: 'POST',
            url: 'Order/ProviderCoins',
            data:{id:id}
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
            console.log("errorrr");
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
            data:{ id:id}
        }).then(function successCallback(response) {
            var odcs= new Array();
            for(var i=0;i<response.data.length;i++){
                var odc=response.data[i];
                odc.asig=false;
                if(odc.pedido_id != null){
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

    function loadContraPedidosProveedor(id){
        $http({
            method: 'POST',
            url: 'Order/CustomOrders',
            data:{prov_id:id}
        }).then(function successCallback(response) {
            var contraPs = new Array();
            for(var i=0;i<response.data.length;i++){
                var aux=response.data[i];
                aux.asig=false;
                if(aux.pedido_id != null){
                    aux.asig=true;
                }
                contraPs.push(aux);
            }
            $scope.formData.contraPedido= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadkitchenBoxProveedor(id){
        $http({
            method: 'POST',
            url: 'Order/KitchenBoxs',
            data:{prov_id:id}
        }).then(function successCallback(response) {
            var auxs = new Array();
            for(var i=0;i<response.data.length;i++){
                var aux=response.data[i];
                aux.asig=false;
                if(aux.pedido_id != null){
                    aux.asig=true;
                }
                auxs.push(aux);
            }
            $scope.formData.kitchenBox= auxs;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function addOrdenCompra(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddPurchaseOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removeOrdenCompra(id){
        $http({
            method: 'POST',
            url: 'Order/RemovePurchaseOrder',
            data:{ id:id}
        }).then(function successCallback(response) {

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

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removeContraPedido(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemoveCustomOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

});

//###########################################################################################3
//##############################REST service (factory) no funciona#############################################3
//###########################################################################################3
MyApp.factory('Order', ['$resource',
    function ($resource) {
        return $resource('Order/:type', {}, {
            query: {method: 'POST', params: {type: ""}}
        });
    }
]);

MyApp.directive('amount', function () {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, element, attrs, ctrl) {
            element.bind("keydown keypress", function (e) {
                var key = window.Event ? e.which : e.keyCode;
                console.log(key);
                // si marca una letra
                if(key >= 65 && key <= 90){
                    e.preventDefault();
                }
                //llave cochetes etc
                if(key >= 171 && key <= 175){
                    e.preventDefault();
                }
                //numpar +-*/
                if(key == 106 | key == 111 | key ==  107 | key ==  109){
                    e.preventDefault();
                }
                //signos de interrogacion
                if(key == 0 | key == 222 ){
                    e.preventDefault();
                }
                //<>
                if(key == 60){
                    e.preventDefault();
                }


            });

        }
    };
});