MyApp.controller('PedidosCtrll', function ($scope,$http, $mdSidenav, masters) {

    var historia= [15];
    var index=0;
    $scope.provSelec={
        id:'-1',
        razon_social:'',
        pedidos: new Array()
    }
    $scope.todos = new Array();
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
        estado:0   // no se le a asignado valor
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

            // console.log(response);

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

        $http({
            method: 'POST',
            url: 'Order/OrderDataForm',
            data:{ id:pedido.id}
        }).then(function successCallback(response) {
            $scope.pedidoSelec=response.data.pedido;
            $scope.detallePedido.$setPristine();
            $scope.pedidoSelec.estado=1; // cargado

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

    //detalle de pedido
    $scope.$watch('pedidoSelec.estado', function(newVal, oldVal) {
        console.log(' se mode', newVal);
            if(newVal  == 1){

            }
        pedidoSelec.estado=2;
        }
    );

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['detallePedido.$valid','detallePedido.$pristine'], function(nuevo) {
        console.log('form',nuevo);
        if(nuevo[0] && !nuevo[1]) {
           save();
        }
    });

    /*************************Guardado*************************************************/
    $scope.saveDetaillPedido=saveDetaillPedido;
    function saveDetaillPedido (){

        //carga los giltros
        $http({
            method: 'POST',
            url: 'Order/Save',
            data:$scope.pedidoSelec
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
});
