//var proveedores = angular.module('proveedores', []);

MyApp.controller('AppCtrl', function ($scope,$mdSidenav,$http,setGetProv) {
    /*$scope.project = {
     description: 'Nuclear Missile Defense System',
     rate: 500
     };*/


    $http({
        method: 'POST',
        url: 'master/getProviderType'
    }).then(function successCallback(response) {
        $scope.states = response.data
    }, function errorCallback(response) {
        console.log("error=>",response)
    });

    $http({
        method: 'POST',
        url: 'master/getProviderTypeSend'
    }).then(function successCallback(response) {
        $scope.envios = response.data
    }, function errorCallback(response) {
        console.log("error=>",response)
    });

    $scope.data = {
        cb1: true
    };
    $scope.setProv = function(prov){
        setGetProv.setProv(prov)
        $mdSidenav("left").close().then(function(){
            $mdSidenav("left").open();
        })

    }


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

MyApp.controller('ListProv', function ($scope,$http,setGetProv) {
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

//###########################################################################################3
//###################Service Proveedores (comunication betwen controllers)###################3
//###########################################################################################3
MyApp.service("setGetProv",function($http){
    var prov = {id:false,type:"",description:"",siglas:"",envio:"",contraped:true,limCred:0};
    var itemsel = {};
    return {
        getProv: function () {
            return prov;
        },
        setProv: function(index) {
            if (index){
                itemsel = index;
                id = itemsel.item.id;
                $http({
                    method: 'POST',
                    url: "proveedores/getProv",
                    data: {
                        id: id
                    }
                }).then(function successCallback(response) {
                    data = response.data;
                    prov.id = data.id;
                    prov.description = data.description;
                    prov.siglas = data.siglas;
                    prov.type = data.type;
                    prov.envio = data.envio;
                    prov.contraped = data.contraped;
                }, function errorCallback(response) {
                    console.log("error=>", response)
                });
            }else{
                prov.id = false;prov.description = "";prov.siglas = "";prov.type = "";prov.envio = "";prov.contraped = false;
            }
        },
        updateItem: function(upd){
            itemsel.item.description = upd.description;
            itemsel.item.limCred = upd.limCred;
            itemsel.item.contraped = upd.contraped;
        }

    };
})
//###########################################################################################3
//##############################FORM CONTROLLERS#############################################3
//###########################################################################################3
MyApp.controller('DataProvController', function ($scope,setGetProv,$http) {
    $scope.dtaPrv = setGetProv.getProv();
    $scope.$watchGroup(['projectForm.$valid','projectForm.$pristine'], function(nuevo) {
        console.log($scope.projectForm)
        if(nuevo[0] && !nuevo[1]) {
            $http({
                method: 'POST',
                url: "proveedores/saveProv",
                data: $scope.dtaPrv,
            }).then(function successCallback(response) {
                $scope.dtaPrv.id = response.data.id
                $scope.projectForm.$setPristine();
                setGetProv.updateItem($scope.dtaPrv);
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });

});

//###########################################################################################3



MyApp.controller('idiomasController', function($scope) {
    $scope.idiomas = [
        { name: 'Español' },
        { name: 'Ingles' },
        { name: 'Frances' },
        { name: 'Portugues' },
        { name: 'Aleman' },
        { name: 'Chino' },
        { name: 'Ruso' },
        { name: 'Papiamento' }
    ];

    $scope.idiomasSeleccionados = [];

});