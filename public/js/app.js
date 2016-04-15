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


MyApp.controller('AppCtrl', function ($scope,$mdSidenav) {
    /*$scope.project = {
     description: 'Nuclear Missile Defense System',
     rate: 500
     };*/

    $scope.secciones = [
        {
            secc: 'Inicio',
            url: 'modules/home/index'
        }, {
            secc: 'Proveedores',
            url: 'modules/proveedores/index'
        }, {
            secc: 'Productos',
            url: 'modules/home/logedout'
        }, {
            secc: 'Pagos',
            url: 'modules/home/404'
        }];
    $scope.seccion = $scope.secciones[0];

    $scope.seccLink = function (indx){
        $scope.seccion = $scope.secciones[indx.$index];
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

    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    $scope.toggleLeft = buildToggler('left');
    $scope.toggleRight = buildToggler('right');
    $scope.toggleOtro = buildToggler('otro');
    function buildToggler(navID) {
        return function() {
            // Component lookup should always be available since we are not using `ng-if`
            $mdSidenav(navID).toggle();
        }
    }
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3


});


MyApp.controller('TipoDirecc', function ($scope) {
    $scope.tipos = ('Facturacion Fabrica Almacen').split(' ').map(function (tipo) {
        return {nombre : tipo};
    });
});

MyApp.controller('ListPaises', function ($scope,$http) {
    $http({
        method: 'GET',
        url: 'master/getCountries'
    }).then(function successCallback(response) {
        $scope.paises = response.data;
    }, function errorCallback(response) {
        console.log("error=>",response)
    });
});


MyApp.controller('ListHerramientas', function ($scope) {
    $scope.tools = [
        {
            tool: 'Calculadora',
            url: '/inicio'
        }, {
            tool: 'Extensiones',
            url: '/proveedores'
        }, {
            tool: 'Hora Mundial',
            url: '/productos'
        }, {
            secc: 'Factor',
            url: '/pagos'
        }];
});

/*MyApp.run(['$route', function($route)  {
    $route.reload();
}]);*/

MyApp.controller('ListProv', function ($scope,$http) {
    $http({
        method: 'GET',
        url: 'proveedores/provList'
    }).then(function successCallback(response) {
        $scope.todos = response.data;
    }, function errorCallback(response) {
        console.log("errorrr");
    });

});




    function DemoCtrl1 ($timeout, $q, $log) {
        var self = this;
        self.simulateQuery = false;
        self.isDisabled    = false;
        // list of `state` value/display objects
        self.states        = loadAll();
        self.querySearch   = querySearch;
        self.selectedItemChange = selectedItemChange;
        self.searchTextChange   = searchTextChange;
        self.newState = newState;
        function newState(state) {
            alert("Sorry! You'll need to create a Constituion for " + state + " first!");
        }
        // ******************************
        // Internal methods
        // ******************************
        /**
         * Search for states... use $timeout to simulate
         * remote dataservice call.
         */
        function querySearch (query) {
            var results = query ? self.states.filter( createFilterFor(query) ) : self.states,
                deferred;
            if (self.simulateQuery) {
                deferred = $q.defer();
                $timeout(function () { deferred.resolve( results ); }, Math.random() * 1000, false);
                return deferred.promise;
            } else {
                return results;
            }
        }
        function searchTextChange(text) {
            $log.info('Text changed to ' + text);
        }
        function selectedItemChange(item) {
            $log.info('Item changed to ' + JSON.stringify(item));
        }
        /**
         * Build `states` list of key/value pairs
         */
        function loadAll() {
            var allStates = 'Alabama, Alaska, Arizona, Arkansas, California, Colorado, Connecticut, Delaware,\
              Florida, Georgia, Hawaii, Idaho, Illinois, Indiana, Iowa, Kansas, Kentucky, Louisiana,\
              Maine, Maryland, Massachusetts, Michigan, Minnesota, Mississippi, Missouri, Montana,\
              Nebraska, Nevada, New Hampshire, New Jersey, New Mexico, New York, North Carolina,\
              North Dakota, Ohio, Oklahoma, Oregon, Pennsylvania, Rhode Island, South Carolina,\
              South Dakota, Tennessee, Texas, Utah, Vermont, Virginia, Washington, West Virginia,\
              Wisconsin, Wyoming';
            return allStates.split(/, +/g).map( function (state) {
                return {
                    value: state.toLowerCase(),
                    display: state
                };
            });
        }
        /**
         * Create filter function for a query string
         */
        function createFilterFor(query) {
            var lowercaseQuery = angular.lowercase(query);
            return function filterFn(state) {
                return (state.value.indexOf(lowercaseQuery) === 0);
            };
        }
    }


MyApp.controller('DemoCtrl', DemoCtrl1);



    function DemoCtrl2 ($timeout, $q) {
        var self = this;
        self.readonly = false;
        self.selectedItem = null;
        self.searchText = null;
        self.querySearch = querySearch;
        self.vegetables = loadVegetables();
        self.selectedVegetables = [];
        self.numberChips = [];
        self.numberChips2 = [];
        self.numberBuffer = '';
        self.autocompleteDemoRequireMatch = true;
        self.transformChip = transformChip;
        /**
         * Return the proper object when the append is called.
         */
        function transformChip(chip) {
            // If it is an object, it's already a known chip
            if (angular.isObject(chip)) {
                return chip;
            }
            // Otherwise, create a new one
            return { name: chip, type: 'new' }
        }
        /**
         * Search for vegetables.
         */
        function querySearch (query) {
            var results = query ? self.vegetables.filter(createFilterFor(query)) : [];
            return results;
        }
        /**
         * Create filter function for a query string
         */
        function createFilterFor(query) {
            var lowercaseQuery = angular.lowercase(query);
            return function filterFn(vegetable) {
                return (vegetable._lowername.indexOf(lowercaseQuery) === 0) ||
                    (vegetable._lowertype.indexOf(lowercaseQuery) === 0);
            };
        }
        function loadVegetables() {
            var veggies = [
                {
                    'name': 'Ingles',
                    'type': 'Brassica'
                },
                {
                    'name': 'Español',
                    'type': 'Brassica'
                },
                {
                    'name': 'Italiano',
                    'type': 'Umbelliferous'
                },
                {
                    'name': 'Chino',
                    'type': 'Composite'
                },
                {
                    'name': 'Aleman',
                    'type': 'Goosefoot'
                }
            ];
            return veggies.map(function (veg) {
                veg._lowername = veg.name.toLowerCase();
                veg._lowertype = veg.type.toLowerCase();
                return veg;
            });
        }
    }


MyApp.controller('CustomInputDemoCtrl', DemoCtrl2);





