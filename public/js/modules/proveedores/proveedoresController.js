//var proveedores = angular.module('proveedores', []);

MyApp.controller('AppCtrl', function ($scope,$mdSidenav,$http,setGetProv,masters) {
    $scope.states = masters.query({ type:"getProviderType"}); //typeProv.query()

    $scope.envios = masters.query({ type:"getProviderTypeSend"});

    $scope.data = {
        cb1: true
    };

    $scope.setProv = function(prov){
        setGetProv.setProv(prov.item);
        $mdSidenav("left").close().then(function(){
            $mdSidenav("left").open();
        });
    }
});


MyApp.controller('TipoDirecc', function ($scope) {

    $scope.tipos = ('Facturacion Fabrica Almacen').split(' ').map(function (tipo) {
        return {nombre : tipo};
    });
});

MyApp.controller('ListPaises', function ($scope,$http,masters) {
    $scope.paises = masters.query({ type:"getCountries"});

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
        url: 'provider/provList'
    }).then(function successCallback(response) {
        $scope.todos = response.data;
        setGetProv.setList($scope.todos||[]);
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
//###################Service Providers (comunication betwen controllers)###################3
//###########################################################################################3
MyApp.service("setGetProv",function($http){
    var prov = {id:false,type:"",description:"",siglas:"",envio:"",contraped:true,limCred:0};
    var itemsel = {};
    var list = {};
    var addrs = {id:false,pais:{short_name:""},telefono:"",direccion:""};
    return {
        getProv: function () {
            return prov;
        },
        setProv: function(index) {
            if (index){
                itemsel = index;
                id = itemsel.id;
                $http({
                    method: 'POST',
                    url: "provider/getProv",
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
            itemsel.description = upd.description;
            itemsel.limCred = upd.limCred;
            itemsel.contraped = upd.contraped;
        },
        setList : function(val){
            list = val;
            itemsel.list[0];
        },
        addToList : function(elem){
            list.unshift(elem);
        },
        getSel : function(){
            return prov;
        }

    };
})

//###########################################################################################3
//##############################REST service (factory)#############################################3
//###########################################################################################3
MyApp.factory('masters', ['$resource',
    function ($resource) {
        return $resource('master/:type', {}, {
            query: {method: 'GET', params: {type: ""}, isArray: true},
        });
    }
]);

MyApp.factory('providers', ['$resource',
    function ($resource) {
        return $resource('provider/:type/:id_prov', {}, {
            query: {method: 'GET', params: {type: "",id_prov:""}, isArray: true},
        });
    }
]);

//###########################################################################################3
//##############################FORM CONTROLLERS#############################################3
//###########################################################################################3
MyApp.controller('DataProvController', function ($scope,setGetProv,$http,$mdToast) {
    $scope.showSimpleToast = function() {
        //var pinTo = $scope.getToastPosition();

        $mdToast.show(/*{
            template: "<md-toast style='width:100%'>prueba</md-toast>",
            hideDelay: 6000,
            position: 'bottom right'}*/
            $mdToast.simple()
                .textContent('guardado!')
                .hideDelay(3000)
        );
    };
    $scope.dtaPrv = setGetProv.getProv();
    $scope.$watchGroup(['projectForm.$valid','projectForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            $http({
                method: 'POST',
                url: "provider/saveProv",
                data: $scope.dtaPrv,
            }).then(function successCallback(response) {
                $scope.dtaPrv.id = response.data.id;
                $scope.projectForm.$setPristine();
                setGetProv.updateItem($scope.dtaPrv);
                if(response.data.action=="new"){
                    var newProv = angular.copy($scope.dtaPrv);
                    setGetProv.addToList(newProv);
                    $scope.showSimpleToast();
                }
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });

});

//###########################################################################################3

MyApp.controller('provAddrsController', function ($scope,setGetProv,$mdToast,providers,$http) {
    $scope.prov = setGetProv.getSel(); //obtiene en local los datos del proveedor actual
    var dirSel = {};
    /*escucha cambios en el proveedor seleccionado y carga las direcciones correspondiente*/
    $scope.$watch('prov.id',function(nvo){
        $scope.dir = {direccProv:"",tipo:"",pais:0,provTelf:"",id:false,id_prov: $scope.prov.id};
        $scope.address = providers.query({type:"dirList",id_prov: $scope.prov.id||0});
    })

    $scope.toEdit = function(addrs){
        dirSel = addrs.add;
        $scope.dir.id = dirSel.id;
        $scope.dir.id_prov = dirSel.prov_id;
        $scope.dir.direccProv = dirSel.direccion;
        $scope.dir.tipo = dirSel.tipo_dir;
        $scope.dir.pais = dirSel.pais_id;
        $scope.dir.provTelf = dirSel.telefono;
    }

    /*escuah el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['direccionesForm.$valid','direccionesForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            $http({
                method: 'POST',
                url: "provider/saveProvAddr",
                data: $scope.dir,
            }).then(function successCallback(response) {
                $scope.dir.id = response.data.id;
                $scope.direccionesForm.$setPristine();
                dirSel.direccion =  $scope.dir.direccProv;
                dirSel.tipo_dir = $scope.dir.tipo;
                dirSel.pais_id = $scope.dir.pais;
                dirSel.telefono = $scope.dir.provTelf;
                if(response.data.action=="new"){

                }
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });


});



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