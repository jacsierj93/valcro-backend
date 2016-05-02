MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav, Order) {

    var historia= [15];
    var index=0;

    $scope.todos = new Array();

    /* proveedor selecionado*/
    $scope.provSelec={
        id:'-1',
        razon_social:'',
        pedidos: new Array()
    }
    $scope.id= $scope.provSelec.id;

    /**pedido selecionado*/
    $scope.pedidoSelec={
        pais_id:'-1',
        id:''
    }

    $scope.status = 0;

    /** orden de compra selecionada */
    $scope.odcSelec={
        id:'-1',
        status: function(){
            return 'hola';
        }
    }

    /*$scope.selec = function(status) {
        if (status ==1 || status ==3) {
            return true;
        } else {
            return false;
        }
    }
*/

    $scope.filterData={
        monedas: new Array(),
        tipoEnv: new Array()
    }

    $scope.formData={
        pedidos: new Array(),
        tipo: new Array(),
        monedas: new Array(),
        direcciones:new Array(),
        odc: new Array(),
        contraPedido: new Array(),
        kitchenBox: new Array()
    }
    init();


    function init(){
        //carga los giltros
        $http({
            method: 'POST',
            url: 'Order/OrderFilterData'
        }).then(function successCallback(response) {
            $scope.filterData.monedas=response.data.monedas;
            $scope.filterData.tipoEnv=response.data.tipoEnvio;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
// obtiene la lista de proveedores
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
    $scope.setProv= setProv;
    $scope.openLayer=openLayer;
    $scope.selecPedido=selecPedido;
    $scope.closeLayer=closeLayer;
    $scope.addPedido=addPedido;
    $scope.addContraPedido =addContraPedido;
    $scope.addkitChenBox =addkitChenBox;

    $scope.selecOdc= function(odc){
        openLayer("resumenodc");
        $http({
            method: 'POST',
            url: 'Order/PurchaseOrder',
            data:{id:odc.id}
        }).then(function successCallback(response) {
            $scope.odcSelec= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function addContraPedido(){
        openLayer("agrContPed");
      //  contraPedido
        $http({
            method: 'POST',
            url: 'Order/CustomOrders',
            data:{prov_id:$scope.provSelec.id}
        }).then(function successCallback(response) {
             $scope.formData.contraPedido= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function addkitChenBox(){
        openLayer("agrKitBoxs");
       $http({
            method: 'POST',
            url: 'Order/KitchenBoxs',
            data:{prov_id:$scope.provSelec.id}
        }).then(function successCallback(response) {
           $scope.formData.kitchenBox= response.data;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
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
            $http({
                method: 'POST',
                url: 'Order/AddPurchaseOrder',
                data:{ id:odc.id, pedido_id:$scope.pedidoSelec.id}
            }).then(function successCallback(response) {
                // $scope.provSelec.pedidos=response.data.pedidos;

            }, function errorCallback(response) {
                console.log("errorrr");
            });
        }else{
            $http({
                method: 'POST',
                url: 'Order/RemovePurchaseOrder',
                data:{ id:odc.id}
            }).then(function successCallback(response) {
                //$scope.provSelec.pedidos=response.data.pedidos;

            }, function errorCallback(response) {
                console.log("errorrr");
            });
        }

    }

    //al selecionar provedor
    function setProv(prov){
        $scope.id=prov.id;
        $scope.provSelec=prov;

        $http({
            method: 'POST',
            url: 'Order/OrderProvOrder',
            data:{ id:prov.id}
        }).then(function successCallback(response) {
            $scope.provSelec.pedidos=response.data.pedidos;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
        openLayer('listPedido');

        $http({
            method: 'POST',
            url: 'Order/ProviderOrder',
            data:{ id:prov.id}
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
        });
    }

    // abirti un layer
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

    function selecPedido(pedido){
        openLayer('detallePedido');
        loadDataFor();
        $http({
            method: 'POST',
            url: 'Order/Order',
            data:{ id:pedido.id}
        }).then(function successCallback(response) {
            $scope.pedidoSelec=response.data;
            loadCoinProvider(pedido.prov_id);
            loadCountryProvider(pedido.prov_id);
            loadPaymentCondProvider(pedido.prov_id);
            loadDirProvider($scope.pedidoSelec.pais_id);
        }, function errorCallback(response) {
            console.log("errorrr");
        });

    }

    function closeLayer(){
        var layer=historia[index];
        historia[index]=null;
        index--;
        $mdSidenav(layer).close();
        switch (layer){
            case 'odc':
                $http({
                    method: 'POST',
                    url: 'Order/Order',
                    data:{ id:$scope.pedidoSelec.id}
                }).then(function successCallback(response) {
                    $scope.pedidoSelec=response.data;
                }, function errorCallback(response) {
                    console.log("errorrr");
                });
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
    /*escuha el estatus del formulario y guarda cuando este valido*/
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

    $scope.dateParse= function (data){
        var newData= Date.parse(data);
        return newData;
    }

    /**********  peticiones ************/

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