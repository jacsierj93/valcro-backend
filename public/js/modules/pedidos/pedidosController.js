MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav) {

    var historia= [15];
    var index=0;
    $scope.provSelec={
        id:'-1',
        razon_social:'',
        pedidos: new Array()
    }
    $scope.todos = new Array();
    $scope.id= $scope.provSelec.id;
    $scope.pedidoSelec={
        pais_id:'-1',
        id:''
    }
    $scope.status = 0;
    $scope.selec = function(status) {
        if (status ==1 || status ==3) {
            return true;
        } else {
            return false;
        }
    }


    $scope.filterData={
        monedas: new Array(),
        tipoEnv: new Array()
    }

    $scope.formData={
        pedidos: new Array(),
        tipo: new Array(),
        monedas: new Array(),
        direcciones:new Array()
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

    //al selecionar provedor
    function setProv(id){
        $scope.id=id;
        $http({
            method: 'POST',
            url: 'Order/OrderProvOrder',
            data:{ id:id}
        }).then(function successCallback(response) {
            $scope.provSelec.pedidos=response.data.pedidos;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
        openLayer('listPedido');
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
            if(!response.data.error){
                $scope.pedidoSelec.id=response.data.pedido.id;
            }
            console.log(response);


        }, function errorCallback(response) {
            console.log("errorrr");
        });

    }

});
