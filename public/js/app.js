var MyApp = angular.module('MyApp', ['ngMaterial', 'ngMessages', 'ngRoute','ngResource']);


MyApp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider){
        $routeProvider.
        when('/beta', {
            templateUrl : 'modules/home/index'
        }).

        otherwise({
            redirectTo : '/'
        });
        $locationProvider.html5Mode(true);
    }
]);





/*MyApp.config(['$routeProvider',function($routeProvider){
    $routeProvider
        .when('/home',  {templateUrl:"modules/home"})
}]);*/


MyApp.controller('login', ['$scope', '$http', function ($scope, $http) {
    var usr = lgnForm.usr;
    var pss = lgnForm.pss;

    $scope.lgn = function () {
        console.log(usr.value, pss.value);
        $http({
            method: 'POST',
            url: PATHAPP + 'api/user/login',
            data: {
                usr: usr.value,
                pss: pss.value
            }
        }).then(function successCallback(response) {
            if (response.data.success) {
                $("#holderLogin").animate({
                    opacity: 0
                }, 1000, function () {

                    location.replace('angular/#beta');
                });
            }
        }, function errorCallback(response) {
            console.log(response);
        });


    }

}]);


MyApp.controller('AppCtrl', function ($scope) {
    /*$scope.project = {
     description: 'Nuclear Missile Defense System',
     rate: 500
     };*/

    $scope.states = ('Fabrica Trader Agente Trader/Fabrica').split(' ').map(function (state) {
        return {abbrev: state};
    });

    $scope.envios = ('Aereo Maritimo Terrestre').split(' ').map(function (envio) {
        return {tipo: envio};
    });


    $scope.data = {
        cb1: true
    };

});

MyApp.controller('ListSecciones', function ($scope) {
    var imagePath = 'images/btn_dot.png';
    $scope.secc = [
        {
            icon: imagePath,
            secc: 'Inicio',
            url: '/inicio'
        }, {
            icon: imagePath,
            secc: 'Proveedores',
            url: '/proveedores'
        }, {
            icon: imagePath,
            secc: 'Productos',
            url: '/productos'
        }, {
            icon: imagePath,
            secc: 'Pagos',
            url: '/pagos'
        }];
});

MyApp.controller('ListHerramientas', function ($scope) {
    var imagePath = 'images/btn_dot.png';
    $scope.tools = [
        {
            icon: imagePath,
            tool: 'Calculadora',
            url: '/inicio'
        }, {
            icon: imagePath,
            tool: 'Extensiones',
            url: '/proveedores'
        }, {
            icon: imagePath,
            tool: 'Hora Mundial',
            url: '/productos'
        }, {
            icon: imagePath,
            secc: 'Factor',
            url: '/pagos'
        }];
});


/*
MyApp.run(['$route', function($route)  {
    $route.reload();
}]);*/



MyApp.controller('ListProv', function ($scope) {

    var imagePath = 'https://material.angularjs.org/latest/img/list/60.jpeg?0';
    $scope.todos = [
        {
            face: imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face: imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face: imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face: imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face: imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        }

    ];

});