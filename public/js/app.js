var dependency = ['ngMaterial', 'ngRoute','ngResource','ngMessages','clickOut','ui.mask', 'ui.utils.masks','ngFileUpload'];
var MyApp = angular.module('MyApp', dependency, function() {

});
/***Jacsiel 06-06-2016
 * prevent open files on drop in browser ****/
window.addEventListener("dragover",function(e){
    e = e || event;
    e.preventDefault();
},false);
window.addEventListener("drop",function(e){
    e = e || event;
    e.preventDefault();
},false);
/********************************************************/


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

MyApp.directive('number', function () {
    return {
        require: 'ngModel',
        link: function (scope, elem, attrs,ctrl) {

            elem[0].addEventListener('input', function(){
               var  num = this.value.match(/^[\d\-+\.]+$/);
                if (num === null) {
                    this.value = this.value.substr(0, this.value.length - 1);
                }
            },false);

        }
    };
});

MyApp.directive('chip', function ($timeout) {
    return {
        link: function (scope, elem, attrs,ctrl) {
            elem.bind("keydown",function(e){
                e.stopPropagation();
                if(e.which=="39"){
                    x = elem.next();
                    if(x.length>0){
                        x.focus().click();
                     }else{
                        elem.parent().find("[chip]").first().focus().click();
                     }
                }else if(e.which=="37"){
                    x = elem.prev();
                    if(x.length>0 && !x.is("#valNameContainer")){
                        x.focus().click();
                    }else{
                        elem.parent().find("[chip]").last().focus().click();
                    }
                }else if(e.which=="13"){
                    $timeout(function(){elem.parent().find("input").focus()},0);
                }

            });

            elem.bind("click",function(){
                $timeout(function(){elem[0].focus();},0);
            })

        }
    };
});

MyApp.directive('activeLeft', function ($compile) {
    return {
        link: function (scope, elem, attrs) {
            elem.removeAttr("active-left");
            elem.addClass("activeleft");
            elem.attr("ng-click","$parent.closeLayer()");
            elem.attr("ng-class","{'white': '"+jQuery(elem).parents("md-sidenav").first().attr("id")+"'!=$parent.layer}");
            $compile(elem[0])(scope);
        }
    };
});

MyApp.directive('skipTab', function ($compile,$timeout) {
    var skip = function(jqObject,scope){
        var elem = angular.element("[name='"+jqObject+"']");
        var list = angular.element(elem).parents("form").first().find("[step]:visible");
        if(list.index(elem)<list.length-1){
            $timeout(function(){
                angular.element(list[list.index(elem)+1]).focus().click();
            },100);
        }else{
            $timeout(function(){
                angular.element(elem).parents("form").first().next().find("[step]").first().click().delay(100).focus();
            },0);
            //console.log(angular.element(elem).parents("form").first().next().find("[step]").first().focus())
            if(scope.showGrid){
                scope.showGrid(false,elem)
            }else{
                scope.isShow=false;
                scope.projectForm.$setUntouched();
            }

        }
    };

    return {
        priority: 1001,
        terminal:true,
        link: function (scope, element, attrs) {
            element.removeAttr("skip-tab");
            element.attr("step","");
            //console.log("")
            if(angular.element(element).is("md-switch")){
                element.attr("ng-change","skip('"+element.attr("name")+"',this)");
                if(!("skip" in  scope)){
                    scope.skip = skip;
                }
                //console.log(scope)
            }else if(angular.element(element).is("md-select")){
                element.attr("md-on-close","skip('"+element.attr("name")+"',this)");

                if(!("skip" in  scope)){
                    scope.skip = skip;
                }


            }else{
                element.bind("keypress",function(e){
                    if(e.which == "13"){
                        e.stopPropagation();
                        var list = angular.element(this).parents("form").first().find("[step]:visible");
                        if(list.index(this)<list.length-1){
                            angular.element(list[list.index(this)+1]).focus().click();
                        }else{
                            console.log("entro")
                            var nextFrm = angular.element(this).parents("form").first().next().find("[step]").first();
                            if(angular.element(nextFrm[0]).is("input")){
                                angular.element(nextFrm[0]).focus();
                            }else{
                                angular.element(nextFrm[0]).click();
                            }

                            /*$timeout(function(){
                                angular.element(nextFrm[0]).focus();
                            },100);*/
                            scope.showGrid(false,element)
                        }

                    }
                });
            }
            $compile(element[0])(scope);
        }
    };
});

MyApp.directive('info', function($timeout,setNotif) {
    var old ={element:"",info:"",scope:null};
    var ref = false;
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            element.bind("blur", function(e) {
                $timeout(function() {
                    setNotif.hideByContent("info",attrs.info);
                },0);

            });
/*
            element.bind("keypress",function(e){
                if(e.which  == 13 && !angular.element(this).is("md-select")){
                    e.stopPropagation();
                    var list = angular.element(this).parents("form").first().find("[info]:visible");
                    if(list.index(this)<list.length-1){
                        angular.element(list[list.index(this)+1]).focus().click();
                    }else{
                        angular.element(this).parents("form").first().next().find("[info]:visible").first().focus();
                        scope.showGrid(false,element)
                    }
                }
            });
*/
            element.bind("focus", function(e) {
                $timeout(function() {
                    if(old.element!=element[0]){
                        setNotif.addNotif("info",attrs.info,[],{autohidden:5000});
                        old.element = element[0];
                        old.info = attrs.info;
                        scope.isShow = true;
                    }
                    $timeout.cancel(ref);
                    ref = $timeout(function() {
                        old ={element:"",info:""};
                    },30000);

                }, 0);
            })
        }
    }
});

MyApp.directive('duplicate', function($filter,$q,$timeout) {

    return {
        require: 'ngModel',
        link: function(scope, elm, attrs, ctrl) {
            //var targ = attrs.integer;
            ctrl.$asyncValidators.duplicate = function(modelValue, viewValue) {
                var srcScope = attrs['duplicate'];
                var fld = attrs['field'];
                if (ctrl.$isEmpty(modelValue) || ctrl.$pristine) {
                    // consider empty models to be valid
                    return $q.when();
                }

                var def = $q.defer();

                $timeout(function() {

                    // Mock a delayed response

                    if ($filter("customFind")(scope[srcScope],modelValue,function(current,compare){return current[fld].toUpperCase() == compare.toUpperCase() && (scope.localId !=current.id)}).length<1) {
                        // it is valid
                        def.resolve();
                    }else{
                        def.reject();
                    }
                }, 50);

                return def.promise;

            };
        }
    };
});

MyApp.directive('2valName', function() {
    console.log("entor en la direcytiva")

});



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
                location.replace(PATHAPP +'#home');
            }
        }, function errorCallback(response) {
            console.log(response);
        });

    };

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
            secc: 'Embarques',
            url: 'modules/embarques/index',
            selct: 'btnDot'
        }, {
            secc: 'Pagos',
            url: 'modules/pagos/index',
            selct: 'btnDot'
        }, {
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

/******************* Agregado por miguel, convertidor de date de la base de datos  *******************/
/** obj date javascrip
 * probado con  campo 'datetime' de base de datos
 * @param string del campo
 * @return  Date
 * **/
MyApp.service('DateParse', function() {
    this.toDate = function (text) {
        var aux= text;
        if(text.length >= 10){
            aux=text.substring(0, 10);
            console.log(aux);
        }
        return new Date(Date.parse(aux));
    }
});





