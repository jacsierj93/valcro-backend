var MyApp = angular.module('MyApp', ['ngMaterial', 'ngMessages', 'ngRoute', 'ngResource']);


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


MyApp.controller('AppCtrl', function ($scope, $mdSidenav) {
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

    $scope.seccLink = function (indx) {
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
        return function () {
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
        return {nombre: tipo};
    });
});

MyApp.controller('ListPaises', function ($scope, $http) {
    /*    $http({
     method: 'GET',
     url: 'master/getCountries'
     }).then(function successCallback(response) {
     $scope.paises = response;
     }, function errorCallback(response) {
     // called asynchronously if an error occurs
     // or server returns response with an error status.
     });*/
    var countries = "Andorra;United Arab Emirates;Afghanistan;Antigua and Barbuda;Anguilla;Albania;Armenia;Netherlands Antilles;Angola;Antarctica;Argentina;American Samoa;Austria;Australia;Aruba;Aland Islands;Ã…land Islands;Azerbaijan;Bosnia and Herzegovina;Barbados;Bangladesh;Belgium;Burkina Faso;Bulgaria;Bahrain;Burundi;Benin;Saint Barthlemy;Bermuda;Brunei Darussalam;Bolivia;Bolivia, Plurinational state of;Brazil;Bahamas;Bhutan;Bouvet Island;Botswana;Belarus;Belize;Canada;Cocos (Keeling) Islands;Congo, The Democratic Republic of the;Central African Republic;Congo;Switzerland;CÃ´te d'Ivoire;Cook Islands;Chile;Cameroon;China;Colombia;Costa Rica;Cuba;Cape Verde;Christmas Island;Cyprus;Czech Republic;Germany;Djibouti;Denmark;Dominica;Dominican Republic;Algeria;Ecuador;Estonia;Egypt;Western Sahara;Eritrea;Spain;Ethiopia;Finland;Fiji;Falkland Islands (Malvinas);Micronesia, Federated States of;Faroe Islands;France;Gabon;United Kingdom;Grenada;Georgia;French Guiana;Guernsey;Ghana;Gibraltar;Greenland;Gambia;Guinea;Guadeloupe;Equatorial Guinea;Greece;South Georgia and the South Sandwich Islands;Guatemala;Guam;Guinea-Bissau;Guyana;Hong Kong;Heard Island and McDonald Islands;Honduras;Croatia;Haiti;Hungary;Indonesia;Ireland;Israel;Isle of Man;India;British Indian Ocean Territory;Iraq;Iran, Islamic Republic of;Iceland;Italy;Jersey;Jamaica;Jordan;Japan;Kenya;Kyrgyzstan;Cambodia;Kiribati;Comoros;Saint Kitts and Nevis;Korea, Democratic People&#39;s Republic of;Korea, Republic of;Kuwait;Cayman Islands;Kazakhstan;Lao People&#39;s Democratic Republic;Lebanon;Saint Lucia;Liechtenstein;Sri Lanka;Liberia;Lesotho;Lithuania;Luxembourg;Latvia;Libyan Arab Jamahiriya;Morocco;Monaco;Moldova, Republic of;Montenegro;Saint Martin;Madagascar;Marshall Islands;Macedonia;Mali;Myanmar;Mongolia;Macao;Northern Mariana Islands;Martinique;Mauritania;Montserrat;Malta;Mauritius;Maldives;Malawi;Mexico;Malaysia;Mozambique;Namibia;New Caledonia;Niger;Norfolk Island;Nigeria;Nicaragua;Netherlands;Norway;Nepal;Nauru;Niue;New Zealand;Oman;Panama;Peru;French Polynesia;Papua New Guinea;Philippines;Pakistan;Poland;Saint Pierre and Miquelon;Pitcairn;Puerto Rico;Palestinian Territory, Occupied;Portugal;Palau;Paraguay;Qatar;RÃ©union;Romania;Serbia;Russian Federation;Rwanda;Saudi Arabia;Solomon Islands;Seychelles;Sudan;Sweden;Singapore;Saint Helena;Slovenia;Svalbard and Jan Mayen;Slovakia;Sierra Leone;San Marino;Senegal;Somalia;Suriname;Sao Tome and Principe;El Salvador;Syrian Arab Republic;Swaziland;Turks and Caicos Islands;Chad;French Southern Territories;Togo;Thailand;Tajikistan;Tokelau;Timor-Leste;Turkmenistan;Tunisia;Tonga;Turkey;Trinidad and Tobago;Tuvalu;Taiwan;Tanzania, United Republic of;Ukraine;Uganda;United States Minor Outlying Islands;United States;Uruguay;Uzbekistan;Holy See (Vatican City State);Saint Vincent and the Grenadines;Venezuela, Bolivarian Republic of;Virgin Islands, British;Virgin Islands, U.S.;Viet Nam;Vanuatu;Wallis and Futuna;Samoa;Yemen;Mayotte;South Africa;Zambia;Zimbabwe";

    $scope.paises = countries.split(';').map(function (pais) {
        return {nombre: pais};
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

MyApp.controller('ListProv', function ($scope, $http) {

    //var imagePath = 'https://material.angularjs.org/latest/img/list/60.jpeg?0';
    $http({
        method: 'GET',
        url: 'proveedores/provList'
    }).then(function successCallback(response) {
        $scope.todos = response.data;
        //console.log($scope)
    }, function errorCallback(response) {
        console.log("errorrr",response);
    });


    /* $scope.todos = [
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

     ];*/

});


function DemoCtrl1($timeout, $q, $log) {
    var self = this;
    self.simulateQuery = false;
    self.isDisabled = false;
    // list of `state` value/display objects
    self.states = loadAll();
    self.querySearch = querySearch;
    self.selectedItemChange = selectedItemChange;
    self.searchTextChange = searchTextChange;
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
    function querySearch(query) {
        var results = query ? self.states.filter(createFilterFor(query)) : self.states,
            deferred;
        if (self.simulateQuery) {
            deferred = $q.defer();
            $timeout(function () {
                deferred.resolve(results);
            }, Math.random() * 1000, false);
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
        return allStates.split(/, +/g).map(function (state) {
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


function DemoCtrl2($timeout, $q) {
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
        return {name: chip, type: 'new'}
    }

    /**
     * Search for vegetables.
     */
    function querySearch(query) {
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





