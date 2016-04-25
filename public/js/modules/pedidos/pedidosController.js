MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav) {

    var historia= [15];
    var index=0;
    $scope.provSelec={
        razon_social:'Desconocido',
        pedidos: new Array()
    }
    init();
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



    /**inicializacion**/
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


});
