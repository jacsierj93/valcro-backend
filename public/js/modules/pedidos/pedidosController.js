MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav, ORDER, Navi) {

    $scope.formBlock=true;

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

    $scope.setProvedor= setProvedor;
    // $scope.openLayer=openLayer;
    $scope.selecPedido=selecPedido;
    //$scope.closeLayer=closeLayer;
    $scope.DtPedido=DtPedido;
    $scope.openContraPedido =openContraPedido;
    $scope.openPedsust =openPedsust;
    $scope.addkitChenBox =addkitChenBox;
    $scope.openOdcs =openOdcs;
    $scope.selecOdc=selecOdc;
    $scope.selecContraP=selecContraP;
    $scope.selecKitchenBox=selecKitchenBox;

    $scope.removeLisContraP=removeLisContraP;
    $scope.removeLisKitchenBox=removeLisKitchenBox;
    $scope.removeLisPedidoSus=removeLisPedidoSus;

    Navi.built($scope);
    $scope.updateForm= function(){
        $scope.formBlock=false;

    }

    //  carga la primera data del sistema filtros  y proveedores
    init();

    //loadPedidosASustituir('1')
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
        loadDataFor();
    }

    /********************************************EVENTOS ********************************************/

    $scope.test= function(){
        alert('');
    }
    $scope.simulateClick= function(id){
        var a= angular.element(document).find(id);
        console.log('click ', a);
        a.click();
    }
    function removeLisContraP(aux){
        removeContraPedido(aux.id,$scope.pedidoSelec.id);
        loadPedido($scope.pedidoSelec.id);
    }

    function removeLisKitchenBox(aux){
        removekitchenBox(aux.id,$scope.pedidoSelec.id);
        loadPedido($scope.pedidoSelec.id);
    }

    function removeLisPedidoSus(aux){
        removePedidoSustituto(aux.oldId, $scope.pedidoSelec.id);
        loadPedido($scope.pedidoSelec.id);
    }
    function selecOdc (odc){
        restore('odcSelec');
        loadOdc(odc.id);
        Navi.openLayer("resumenodc");

    }
    function selecContraP (item){
        restore('contraPedSelec');
        $scope.formDataContraP.contraPedidoMotivo = ORDER.query({type:'CustomOrderReason'});
        $scope.formDataContraP.contraPedidoPrioridad = ORDER.query({type:'CustomOrderPriority'});
        loadContraP(item.id);
        Navi.openLayer("resumenContraPedido");
    }

    function selecKitchenBox(item){
        restore('FormDataKitchenBox');
        console.log('item id', item);
        $scope.kitchenBoxSelec = ORDER.get({type:'KitchenBox',id:item.id});

        /* $scope.formDataKitchenBox.contraPedidoMotivo = ORDER.query({type:'resumenKitchenbox'});
         $scope.formDataKitchenBox.contraPedidoPrioridad = ORDER.query({type:'CustomOrderPriority'});
         loadContraP(item.id);*/
        Navi.openLayer("resumenKitchenbox");
    }


    function openOdcs(){
        loadOrdenesDeCompraProveedor($scope.provSelec.id);
        Navi.openLayer('odc');
    }

    function openContraPedido(){
        Navi.openLayer("agrContPed");
        loadContraPedidosProveedor($scope.provSelec.id);
    }

    function openPedsust(){
        Navi.openLayer("agrPedPend");
        loadPedidosASustituir($scope.provSelec.id);
    }

    function addkitChenBox(){
        Navi.openLayer("agrKitBoxs");
        loadkitchenBoxProveedor($scope.provSelec.id);

    }


    /** al pulsar la flecha siguiente**/
    $scope.next = function (){
        var  curren= $scope.layer;
        console.log('navi', Navi);
        console.log('current', curren);

        switch (curren){
            case 'detallePedido':
                Navi.openLayer('agrPed');
                break;
        }
    }

    $scope.showNext = function(status){
        if(status){
            if(!$scope.FormdetallePedido.$valid){
                alert('no validoExisten campos pendientes por completar, por favor verifica que información le falta.');
            }else{
                $mdSidenav("NEXT").open();
            }

        }else{
            $mdSidenav("NEXT").close()
        }
    }
    $scope.change= function(odc){
        if(odc.asig){
            addOrdenCompra(odc.id,$scope.pedidoSelec.id);
        }else{
            removeOrdenCompra(odc.id,$scope.pedidoSelec.id);
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

    $scope.changePedidoSustituto= function(item){
        if(item.asig){

            addPedidoSustituto(item.id,$scope.pedidoSelec.id);
        }else{
            removePedidoSustituto(item.id, $scope.pedidoSelec.id);
        }
        loadPedido($scope.pedidoSelec.id);
    }

    function setProvedor(prov){
        $scope.provSelec=prov;
        console.log('prov id='+prov.id+"  scop prov ="+ $scope.provSelec.id)
        loadPedidosProvedor(prov.id);
        //loadOrdenesDeCompraProveedor(prov.id);
        Navi.openLayer('listPedido');
    }
    /*
     function openLayer(layer){
     if(historia.indexOf(layer)==-1){
     var l=angular.element(document).find("#"+layer);
     console.log('layer ',l);
     var base =264;
     $scope.index++;
     var w= base+(24*$scope.index);
     console.log(' width', w);
     l.css('width','calc(100% - '+w+'px)');
     $mdSidenav(layer).open();
     historia[$scope.index]=layer;
     $scope.layer=layer;

     return true;
     }
     return false;
     }*/

    function DtPedido(pedido){

        if(Navi.openLayer('detallePedido')){

            if(pedido == 'null'){
                restore('pedidoSelec');

            }
            if($scope.index <= 1){
                restore('provSelec');
            }

            $scope.FormdetallePedido.$setPristine();
        }
    }

    function selecPedido(pedido){
        Navi.openLayer('detallePedido');

        loadPedido(pedido.id);
        loadCoinProvider(pedido.prov_id);
        loadCountryProvider(pedido.prov_id);
        loadPaymentCondProvider(pedido.prov_id);
        loadDirProvider($scope.pedidoSelec.pais_id);
    }

    function closeLayer(){
        var layer=historia[$scope.index];
        historia[$scope.index]=null;
        $scope.index--;
        $mdSidenav(layer).close();
        $scope.layer=layer;
    }

    $scope.setPed= function(ped){
        Navi.openLayer(ped);
    }

    /****** **************************listener ***************************************/

    $scope.$watch('pedidoSelec.pais_id',function(newVal){
        if(newVal != '' && typeof(newVal) !== 'undefined' ){
            loadDirProvider(newVal);
        }
    });

    $scope.$watch('layer',function(newVal){
        if(newVal != '' && typeof(newVal) !== 'undefined' ){
            console.log(' select layer ', newVal);
            switch (newVal){
                case 'odc' | 'asdf':
                    loadPedido($scope.pedidoSelec.id);
                    break;
            }
        }
    });

    $scope.$watch('provSelec.id',function(newVal){
        if(newVal != '' && typeof(newVal) !== 'undefined'){
            loadCoinProvider(newVal);
            loadCountryProvider(newVal);
            loadPaymentCondProvider(newVal);
        }
    });

    $scope.$watch('pedidoSelec.prov_moneda_id',function(newVal){
        if(newVal != '' && typeof(newVal) !== 'undefined'){
            loadTasa(newVal);
        }
    });

    $scope.$watchGroup(['FormdetallePedido.$valid','FormdetallePedido.$pristine'], function(nuevo) {
        console.log('estado',nuevo);
        if(nuevo[0] && !nuevo[1]) {
            console.log('peddio',$scope.pedidoSelec);
            saveDetaillPedido();
        }
        console.log('i', i);
    });

    /*************************Guardados*************************************************/

    function saveDetaillPedido (){


        if($scope.pedidoSelec.id == ''){
            delete $scope.pedidoSelec.id;
        }
        $scope.pedidoSelec.prov_id=$scope.provSelec.id;
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
        if(odc.aprobada == '1'){
            return 'Aprobada';
        }else {
            return 'No Aprobada';
        }
    }


    /*********************************  peticiones  carga $http ********************* ************/

    function loadPedido(id){
        $scope.pedidoSelec= ORDER.post({type:'Order'},{id:id});
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
            data:{id:id}
        }).then(function successCallback(response) {
            $scope.contraPedSelec= response.data;
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
            var contraPs = new Array();
            for(var i=0;i<response.data.length;i++){
                var aux=response.data[i];
                aux.asig=false;
                if(aux.asignado != 0){
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

        ORDER.post({type:'KitchenBoxs'},{prov_id:id, pedido_id: $scope.pedidoSelec.id}, function(data){
            //  $scope.formData.kitchenBox=data;
            //  $scope.formData.kitchenBox=data;
            alert('finite');
            console.log('order data', data);
        });

        $http({
            method: 'POST',
            url: 'Order/KitchenBoxs',
            data:{prov_id:id, pedido_id: $scope.pedidoSelec.id}
        }).then(function successCallback(response) {
            console.log('response ',response);
            var auxs = new Array();
            for(var i=0;i < response.data.length;i++){
                var aux=response.data[i];
                aux.asig=false;
                if(aux.asignado != 0){
                    aux.asig=true;
                }
                auxs.push(aux);
            }
            console.log(' kit response ',response);
             $scope.formData.kitchenBox= auxs;
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function loadPedidosASustituir(id){
        $http({
            method: 'POST',
            url: 'Order/OrderSubstituteOrder',
            data:{prov_id:id, pedido_id: $scope.pedidoSelec.id}
        }).then(function successCallback(response) {
            var auxs = new Array();
            for(var i=0;i<response.data.length;i++){
                var aux=response.data[i];
                aux.asig=false;
                if(aux.asignado != 0){
                    aux.asig=true;
                }
                auxs.push(aux);
            }
            $scope.formData.pedidoSust= auxs;
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
        $http({
            method: 'POST',
            url: 'Order/RemoveCustomOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert(' Removido ');
        }, function errorCallback(response) {
            console.log("errorrr");
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

            case 'kitchenBoxSelec':
                $scope.contraPedSelec={ id:''};
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

MyApp.service("Navi",function($mdSidenav) {
    var historia= [15];
    var sp;

    function openLayer(layer){

        if(historia.indexOf(layer)==-1){
            var l=angular.element(document).find("#"+layer);
            var base =264;
            sp.index++;
            var w= base+(24*sp.index);
            l.css('width','calc(100% - '+w+'px)');
            $mdSidenav(layer).open();
            historia[sp.index]=layer;
            sp.layer=layer;
            return true;
        }
        return false;
    }

    function closeLayer(data){
        var numclose=1;
        console.log(' tipo', typeof(data));

        if (typeof(data) === 'number'){
            numclose=data;
        }else  if (typeof(data) === 'string') {
            if(data=='END'){
                numclose= historia.length;
            }else {
                var index= historia.indexOf(data);
                if(index==-1){
                    numclose=0;
                    console.log('no se ha abierto el layer');
                }
                else {
                    numclose =  historia.length - (index +1);
                }
            }
        }

        for(var i=0; i<numclose ;i++){
            var layer=historia[sp.index];
            $mdSidenav(layer).close();
            historia[sp.index]=null;
            sp.index--;
            sp.layer = historia[sp.index];
        }




    }

    return {
        built: function(scope){
            sp=scope;
            sp.index = 0;
            sp.layer = '';
            sp.openLayer = openLayer;
            sp.closeLayer = closeLayer;
        },
        openLayer:openLayer,
        closeLayer:closeLayer
    }
});

