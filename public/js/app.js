var MyApp = angular.module('MyApp', ['ngMaterial', 'ngMessages', 'ngRoute','ngResource']);


/*MyApp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider){
        $routeProvider.
        when('/', {
            templateUrl : 'modules/home/index'
        }).when('/proveedores', {
            templateUrl : 'modules/proveedores/index'
        }).when('/logout', {
            redirectTo : 'logout'
        }).
        otherwise({
            redirectTo : '/'
            //templateUrl : 'modules/home/404'
        });
        $locationProvider.html5Mode(true);
    }
]);*/


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

                location.replace('angular/#home');

                /*$("#holderLogin").animate({
                    opacity: 0
                }, 1000, function () {
                    location.replace('angular/#home');
                });*/
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

    $scope.templates =[
        { url: 'modules/home/index'},
        { url: 'modules/proveedores/index'},
        { url: 'modules/home/logedout'},
        { url: 'modules/home/404'}
    ];
    $scope.template = $scope.templates[0];

    var imagePath = 'images/btn_dot.png';
    $scope.secc = [
        {
            icon: imagePath,
            secc: 'Inicio',
            url: 'home'
        }, {
            icon: imagePath,
            secc: 'Proveedores',
            url: 'proveedores'
        }, {
            icon: imagePath,
            secc: 'Productos',
            url: '/productos'
        }, {
            icon: imagePath,
            secc: 'Pagos',
            url: '/pagos'
        }];

    $scope.seccLink = function (indx){
        console.log(indx.$index);
        $scope.template = $scope.templates[indx.$index];
    }




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



MyApp.controller('TipoDirecc', function ($scope) {
    $scope.tipos = ('Facturacion Fabrica Almacen').split(' ').map(function (tipo) {
        return {nombre : tipo};
    });
});

/*MyApp.controller('ListSecciones', function ($scope) {
    var imagePath = 'images/btn_dot.png';
    $scope.secc = [
        {
            icon: imagePath,
            secc: 'Inicio',
            url: 'home'
        }, {
            icon: imagePath,
            secc: 'Proveedores',
            url: 'proveedores'
        }, {
            icon: imagePath,
            secc: 'Productos',
            url: '/productos'
        }, {
            icon: imagePath,
            secc: 'Pagos',
            url: '/pagos'
        }];
});*/

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



/*MyApp.run(['$route', function($route)  {
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