var dependency = ['ngMaterial', 'ngRoute','ngResource','ngMessages','clickOut'];
var MyApp = angular.module('MyApp', dependency);


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


MyApp.controller('AppMain', function ($scope,$mdSidenav,$http,setGetProv) {
    /*$scope.project = {
     description: 'Nuclear Missile Defense System',
     rate: 500
     };*/

    $scope.secciones = [
        {
            secc: 'Inicio',
            url: 'modules/home/index',
            selct: 'btnDot'
        }, {
            secc: 'Proveedores',
            url: 'modules/proveedores/index',
            selct: 'btnDot'
        }, {
            secc: 'Productos',
            url: 'modules/home/logedout',
            selct: 'btnDot'
        }, {
            secc: 'Pagos',
            url: 'modules/pagos/index',
            selct: 'btnDot'
        }
        , {
            secc: 'Pedidos',
            url: 'modules/pedidos/index',
            selct: 'btnDot'
        }];
    $scope.seccion = $scope.secciones[0];
    $scope.seccLink = function (indx){
        $scope.seccion = $scope.secciones[indx.$index];
        angular.forEach($scope.secciones, function(value, key) {
            if(key == indx.$index){
                value.selct = 'btnLine';
            }else{
                value.selct = 'btnDot';
            }
        });
    };



    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //$scope.toggleLeft = buildToggler('left');

    $scope.toggleLeft = function() {
        setGetProv.setProv(false)
        $mdSidenav("left").close().then(function () {
            $mdSidenav("left").open();
        })
    }
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



/*
MyApp.controller('ListPaises', function ($scope,$http) {
    $http({
        method: 'POST',
        url: 'master/getCountries'
    }).then(function successCallback(response) {
        $scope.paises = response.data;
    }, function errorCallback(response) {
        console.log("error=>",response)
    });
});
*/


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
        method: 'POST',
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








