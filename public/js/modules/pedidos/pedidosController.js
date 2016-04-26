MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav) {

    var historia= [15];
    var index=0;
    $scope.provSelec={
        id:'-1',
        razon_social:'Desconocido',
        pedidos: new Array()
    }
    $scope.pedidoSelec={
        id:'-1',
        ordenes_compra:new Array(),
        tipo_pedido_id:'',
        pais_id:'',
        almacen_id:'',
        moneda_id:'',
        condicion_id:'',
        motivo_id:'',
        prioridad_id:'',
        nro_pedido:'',
        monto:'',
        tasa:'',
        tasa_fija:false,
        comentario:'',
        mt3:'',
        peso:'',
        aprob_gerencia:false,
        fecha_aprob:null

    }
    $scope.formData={
        pedidos: new Array()
    }
    init();

    function init(){
        $http({
            method: 'POST',
            url: 'Order/OrderProvList'
        }).then(function successCallback(response) {
            $scope.todos = response.data;

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    $scope.states = masters.query({ type:"getProviderType"}); //typeProv.query()

    $scope.envios = masters.query({ type:"getProviderTypeSend"});

    $scope.data = {
        cb1: true
    };


    $scope.provSelec={
        razon_social:''
    }


    function init(){
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
   //Inicializacion
    $scope.setProv= setProv;
    $scope.openLayer=openLayer;
    $scope.selecPedido=selecPedido;
    $scope.closeLayer=closeLayer;

    //al selecionar provedor
    function setProv(id){
        openLayer('listPedido');
        $http({
            method: 'POST',
            url: 'Order/OrderProvOrder',
            data:{ id:arg}
        }).then(function successCallback(response) {
            $scope.provSelec.pedidos=response.data;
            console.log(response.data);

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    // abirti un layer
    function openLayer(layer){
        $mdSidenav(layer).open();
        index++;
        historia[index]=layer;
    }

    function selecPedido(id){
        openLayer('detallePedido');
        /*
         //get de pedidos
         $http({
         method: 'POST',
         url: 'Order/OrderForm',
         data:{ id:arg.id}
         }).then(function successCallback(response) {
         $scope.pedidoSelec=response.data.pedido;
         console.log(response.data);

         }, function errorCallback(response) {
         console.log("errorrr");
         });
         */

    }

    function closeLayer(){
        var layer=historia[index];
        index--;
        $mdSidenav(layer).close();
    }
    /*******por integrar***/
    $scope.setPed= function(ped){
        $mdSidenav(ped).close().then(function(){
            $mdSidenav(ped).open();
        });
        index++;
        historia[index]=ped;
    }
});
