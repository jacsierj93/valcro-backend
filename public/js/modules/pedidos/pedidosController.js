MyApp.controller('PedidosCtrll', function ($scope,$http, $mdSidenav, masters) {

    var historia= [15];
    var index=0;
    $scope.provSelec={
        id:'-1',
        razon_social:'',
        pedidos: new Array()
    }
    $scope.todos = new Array();
    $scope.monedas = new Array();// nop controler
    $scope.tipoEnv = new Array();//no controller
    $scope.todos = new Array();
    $scope.id= $scope.provSelec.id;
    $scope.id_moneda='-1';
    $scope.direccion= new Array();
    $scope.condPago= new Array();
    $scope.motPed=  new Array();
    $scope.prioridadPed = new Array();
    $scope.condicionPed= new Array();
    $scope.paisProv= new Array();
    $scope.aprobacionGerente = $scope.provSelec.aprob_gerencia;


    $scope.pedidoSelec={
        id:'-1',
        ordenes_compra:new Array(),
        tipo_pedido_id:'',
        pais_id:'',
        almacen_id:'',
        prov_moneda_id:'',
        direccion_almacen_id:'',
        condicion_pago_id:'',
        motivo_pedido_id:'',
        motivo_id:'',
        prioridad_id:'',
        nro_doc:'',
        prov_id:'',
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
        pedidos: new Array(),
        tipo: new Array(),
        monedas: new Array(),
        direcciones:new Array()
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
    $scope.setProv= setProv;
    $scope.openLayer=openLayer;
    $scope.selecPedido=selecPedido;
    $scope.closeLayer=closeLayer;

    //al selecionar provedor
    function setProv(id){
        $scope.id=id;

        $http({
            method: 'POST',
            url: 'Order/OrderProvOrder',
            data:{ id:id}
        }).then(function successCallback(response) {
            $scope.provSelec.pedidos=response.data.pedidos;
            $scope.provSelec.razon_social=response.data.proveedor.razon_social;

            console.log(response);

        }, function errorCallback(response) {
            console.log("errorrr");
        });
        openLayer('listPedido');
    }

    // abirti un layer
    function openLayer(layer){
        var base =288;
        index++;
        /*
        var newsize =288+(24*index);
        console.log('new size',newsize);
        var layer=$("#"+layer);
       // layer.css('width',"'"+newsize+"'");*/
        $mdSidenav(layer).open();
        historia[index]=layer;
    }

    function selecPedido(pedido){
        openLayer('detallePedido');
       /* $scope.id_moneda=pedido.prov_moneda_id;
        $scope.direccion= pedido.direccion_almacen_id;
        $scope.motPed= pedido.motivo_pedido_id;
        $scope.condPago= pedido.condicion_pago_id;
        $scope.prioridadPed= pedido.prioridad_id;
        //$scope.condicionPed= pedido.condicion_pedido_id;
        $scope.paisProv= pedido.pais_id;
        $scope.aprobacionGerente = pedido.aprob_gerencia;*/
        //get de pedidos
         $http({
         method: 'POST',
         url: 'Order/OrderDataForm',
         data:{ id:pedido.id}
         }).then(function successCallback(response) {
            $scope.pedidoSelec=response.data.pedido;
             $scope.formData.tipo=response.data.tipoPedido;
             $scope.formData.monedas=response.data.monedas;
             $scope.formData.motivoPedido=response.data.motivoPedido;
             $scope.formData.condicionPago=response.data.condicionPago;
             $scope.formData.prioridadPedido=response.data.prioridadPedido;
             $scope.formData.condicionPedido=response.data.condicionPedido;
             $scope.formData.paises= response.data.paises;
             $scope.formData.aprob_gerencia= response.data.aprob_gerencia;

            console.log('monedas',response.data.monedas);

         }, function errorCallback(response) {
         console.log("errorrr");
         });

    }

    function closeLayer(){
        var layer=historia[index];
        index--;
        $mdSidenav(layer).close();
    }
    /*******por integrar***/
    $scope.setPed= function(ped){
        openLayer(ped);
    }
});
