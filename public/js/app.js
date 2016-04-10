angular.module('MyApp', ['ngMaterial', 'ngMessages']).controller('AppCtrl', function ($scope) {
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






}).controller('ListSecciones', function ($scope) {
    var imagePath = 'http://10.15.2.111/valcrodev/images/btn_dot.png';
    $scope.secc = [
        {
            icon : imagePath,
            secc: 'Inicio',
            url: '/inicio'
        },{
            icon : imagePath,
            secc: 'Proveedores',
            url: '/proveedores'
        },{
            icon : imagePath,
            secc: 'Productos',
            url: '/productos'
        },{
            icon : imagePath,
            secc: 'Pagos',
            url: '/pagos'
        }];
}).controller('ListHerramientas', function ($scope) {
    var imagePath = 'http://10.15.2.111/valcrodev/images/btn_dot.png';
    $scope.tools = [
        {
            icon : imagePath,
            tool: 'Calculadora',
            url: '/inicio'
        },{
            icon : imagePath,
            tool: 'Extensiones',
            url: '/proveedores'
        },{
            icon : imagePath,
            tool: 'Hora Mundial',
            url: '/productos'
        },{
            icon : imagePath,
            secc: 'Factor de conversion',
            url: '/pagos'
        }];
}).controller('ListProv', function ($scope) {

    var imagePath = 'https://material.angularjs.org/latest/img/list/60.jpeg?0';
    $scope.todos = [
        {
            face : imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face : imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face : imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face : imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        },
        {
            face : imagePath,
            what: 'Brunch this weekend?',
            who: 'Min Li Chan',
            when: '3:08PM',
            notes: " I'll be in your neighborhood doing errands"
        }

    ];

});