var proveedores = angular.module('proveedores', []);

proveedores.controller('AppCtrl', function ($scope,$mdSidenav) {
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


proveedores.controller('TipoDirecc', function ($scope) {
    $scope.tipos = ('Facturacion Fabrica Almacen').split(' ').map(function (tipo) {
        return {nombre : tipo};
    });
});

proveedores.controller('ListPaises', function ($scope,$http) {
    $http({
        method: 'GET',
        url: 'master/getCountries'
    }).then(function successCallback(response) {
        $scope.paises = response.data;
    }, function errorCallback(response) {
        console.log("error=>",response)
    });
});


proveedores.controller('ListHerramientas', function ($scope) {
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

/*proveedores.run(['$route', function($route)  {
 $route.reload();
 }]);*/

proveedores.controller('ListProv', function ($scope,$http) {
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


proveedores.controller('DemoCtrl', DemoCtrl1);



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


proveedores.controller('CustomInputDemoCtrl', DemoCtrl2);
