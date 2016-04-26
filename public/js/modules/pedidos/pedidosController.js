MyApp.controller('PedidosCtrll', function ($scope,$http, $mdSidenav, masters) {
    $scope.states = masters.query({ type:"getProviderType"}); //typeProv.query()

    $scope.envios = masters.query({ type:"getProviderTypeSend"});

    $scope.data = {
        cb1: true
    };


    $scope.provSelec={
        razon_social:''
    }
   // init();
    $scope.setPed= function(ped){
       // setGetPed.setPed(ped.item);
        $mdSidenav(ped).close().then(function(){
            $mdSidenav(ped).open();
        });
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

    MyApp.factory('masters', ['$resource',
        function ($resource) {
            return $resource('master/:type', {}, {
                query: {method: 'GET', params: {type: ""}, isArray: true},
            });
        }
    ]);
});
