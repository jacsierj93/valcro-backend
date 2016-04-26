MyApp.controller('PedidosCtrll', function ($scope,$http, $mdSidenav, masters) {

    var historia= [15];
    var index=0;
    $scope.provSelec={
        razon_social:'Desconocido',
        pedidos: new Array()
    }
    $scope.pedidoSelec={
        id:'-1',
        ordenes:'100000,0000,000,',
        nro_doc:'',
        tipo:-1

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
        //selecionar provedor
    $scope.setProv= function(arg){
        $mdSidenav("listPedido").open();
        index++;
        historia[index]='listPedido';
//get de pedidos
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

    $scope.openLayer= function(name){
        $mdSidenav(name).open();
        index++;
        historia[index]='name';

    }


    $scope.selecPedido= function(arg){
        $mdSidenav("detallePedido").open();
        index++;
        historia[index]='detallePedido';
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

    $scope.closeLayer= function (){
        var layer=historia[index];
        index--;
        $mdSidenav(layer).close();



    }
    $scope.setPed= function(ped){
        $mdSidenav(ped).close().then(function(){
            $mdSidenav(ped).open();
        });
        index++;
        historia[index]=ped;
    }

    MyApp.factory('masters', ['$resource',
        function ($resource) {
            return $resource('master/:type', {}, {
                query: {method: 'GET', params: {type: ""}, isArray: true},
            });
        }
    ]);
});
