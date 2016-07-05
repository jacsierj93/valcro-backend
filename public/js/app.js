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

MyApp.config(function ($provide, $httpProvider) {

    // Intercept http calls.
    $provide.factory('MyHttpInterceptor', function ($q) {
        return {
            // On request success
            request: function (config) {
                // console.log(config); // Contains the data about the request before it is sent.
                return config || $q.when(config);
            },

            // On request failure
            requestError: function (rejection) {
                // console.log(rejection); // Contains the data about the error on the request.
          //      console.log("request ", rejection);
                // Return the promise rejection.
                return $q.reject(rejection);
            },

            // On response success
            response: function (response)
            {
                // Return the response or promise.
                return response || $q.when(response);
            },

            // On response failture
            responseError: function (rejection) {
                // console.log(rejection); // Contains the data about the error.
              //  console.log("reposnse error", rejection)
                // Return the promise rejection.
                return $q.reject(rejection);
            }
        };
    });

    // Add the interceptor to the $httpProvider.
    $httpProvider.interceptors.push('MyHttpInterceptor');

});

//###########################################################################################3
//##############################REST service (factory)#############################################3
//###########################################################################################3
MyApp.factory('masters', ['$resource',
    function ($resource) {
        return $resource('master/:type/:id', {}, {
            query: {method: 'GET', params: {type: "",id:""}, isArray: true}
        });
    }
]);



MyApp.directive('global', function (Layers, setNotif) {
    return {
        link: function (scope) {
            scope.module= Layers.getModule();
            scope.LayersAction = Layers.setAccion;
            scope.NotifAction = setNotif.addNotif;
            scope.index = Layers.getIndex();
        }
    };
});

MyApp.directive('number', function () {
    return {
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

MyApp.directive('phone', function (setNotif) {
    return {
        link: function (scope, elem, attrs,ctrl) {

            elem[0].addEventListener('input', function(){
                var  num = this.value.match(/^[\d\-+\.\(\)]+$/);
                if (num === null && this.value!="") {
                    setNotif.addNotif("error","no se permiten estos valores",[]);
                    this.value = this.value.substr(0, this.value.length - 1);
                }else{
                    setNotif.hideByContent("error","no se permiten estos valores");
                }
            },false);

        }
    };
});



MyApp.directive('decimal', function () {
    return {
        require: 'ngModel',
        link: function (scope, elem, attrs,ctrl) {
            ctrl.$validators.decimal = function(modelValue, viewValue) {
                if(viewValue === undefined || viewValue=="" || viewValue==null){
                    return true;
                }
                elem[0].value = viewValue.replace(/([a-z]|[A-Z]| )+/,"")

                var  num = viewValue.match(/^\-?(\d{0,3}\.?)+\,?\d{1,3}$/);

                return !(num === null)
            };
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

MyApp.directive('activeLeft', function ($compile, Layers) {
    return {
        link: function (scope, elem, attrs) {
            var ly =jQuery(elem).parents("md-sidenav").first().attr("id");
            elem.removeAttr("active-left");
            var jso="{close:{name:'"+ly+"'";
            var after = elem.attr('after');
            if(after){
                jso +=",after:"+after
            }
            var before = elem.attr('before');
            if(before){
                jso +=",before:"+before
            }

            elem.addClass("activeleft");
            elem.attr("ng-click","LayersAction("+jso+"}})");
            elem.attr("ng-class","{'white': ('"+ly+"'!=layer)}");
            $compile(elem[0])(scope);
        }
    };
});

MyApp.directive('contenteditable', function() {
    return {
        restrict: 'A', // only activate on element attribute
        require: '?ngModel', // get a hold of NgModelController
        link: function(scope, element, attrs, ngModel) {
            if(!ngModel) return; // do nothing if no ng-model

            // Specify how UI should be updated
            ngModel.$render = function() {
                element.html(ngModel.$viewValue || '');
            };

            // Listen for change events to enable binding
            element.on('blur keyup change', function() {
                scope.$apply(read);
            });
            read(); // initialize

            // Write data to the model
            function read() {
                var html = element.html();
                // When we clear the content editable the browser leaves a <br> behind
                // If strip-br attribute is provided then we strip this out
                if( attrs.stripBr && html == '<br>' ) {
                    html = '';
                }
                ngModel.$setViewValue(html);
            }
        }
    };
});


MyApp.directive('skipTab', function ($compile,$timeout) {
    var skip = function(jqObject,scope){
        var elem = angular.element("#"+jqObject);
        var list = angular.element(elem).parents("form").first().find("[step]:visible")
        if(list.index(elem)<list.length-1){
            $timeout(function(){
                if(angular.element(list[list.index(elem)+1]).is("md-select")){
                    angular.element(list[list.index(elem)+1]).focus().click();
                }else{
                    angular.element(list[list.index(elem)+1]).focus();
                }

            },50);
        }else{
            var nextFrm = angular.element(elem).parents("form").first().next().find("[step]").first();
            $timeout(function(){
                angular.element(elem).parents("form").first().next().click();
                $timeout(function(){
                    if(angular.element(nextFrm[0]).is("md-select")){
                        angular.element(nextFrm[0]).focus().click();
                    }else
                    {
                        angular.element(nextFrm[0]).focus();
                    }
                },50)
            },0);

        }
    };

    return {
        priority: 1001,
        terminal:true,
        link: function (scope, element, attrs) {
            element.removeAttr("skip-tab");
            element.attr("step","");
            if(angular.element(element).is("md-switch")){
                element.attr("ng-change","skip('"+element.attr("id")+"',this)");
                if(!("skip" in  scope)){
                    scope.skip = skip;
                }
            }else if(angular.element(element).is("md-select")){
                element.attr("md-on-close","skip('"+element.attr("id")+"',this)");
                if(!("skip" in  scope)){
                    scope.skip = skip;
                }
            }else{
                element.bind("keydown",function(e){
                    var elem =this;
                    if(e.which == "13"){
                        e.stopPropagation();
                        var list = angular.element(elem).parents("form").first().find("[step]:visible");
                       //console.log(list)
                        if(list.index(elem)<list.length-1){
                            if(angular.element(list[list.index(elem)+1]).is("md-select")){
                                angular.element(list[list.index(elem)+1]).focus().click();
                            }else{

                                $timeout(function(){
                                    console.log(elem, angular.element(list[list.index(elem)+1]).focus())
                                    /*var elem = angular.element(list[list.index(this)+1])

                                    angular.element(elem[0]).focus()*/
                                },0)


                            }
                        }else{

                            var nextFrm = angular.element(this).parents("form").first().next().find("[step]").first();
                            angular.element(this).parents("form").first().next().click();
                            $timeout(function(){
                                if(angular.element(nextFrm[0]).is("md-select")){
                                    angular.element(nextFrm[0]).focus().click();
                                }else{
                                    angular.element(nextFrm[0]).focus();
                                }
                            },50);


                            /*if(scope.showGrid){
                                scope.showGrid(false,{toElement:element});
                            }else{
                                scope.isShow=false;
                                scope.projectForm.$setUntouched();
                            }*/
                        }

                    }else if((e.which == "39" || e.which == "37") && angular.element(elem).is("div")){
                        angular.element(elem).parents("form").first().find("[chip]").first().focus().click();
                    }/*else if(e.which=="40"){
                        if(!angular.element("#lyrAlert").hasClass("md-closed")){
                            if(angular.element("#lyrAlert").find(".alertTextOpcs:visible").length > 0){
                               var focus =angular.element("#lyrAlert").find(".alertTextOpcs:visible > div").first();
                                angular.element(focus).focus();
                            };
                        }
                    }*/
                });
            }
            $compile(element[0])(scope);
        }
    };
});

MyApp.directive('notifButtom', function($compile,$timeout) {

    return {
        priority: 1001,
        terminal: true,
        link: function (scope, element, attrs) {
            element.removeAttr("notif-buttom");
            element.attr("notOpc","");
            element.bind("keydown",function(e){
                if(e.which == "39"){
                    element.next().focus();
                }else if(e.which == "37"){
                    element.prev().focus();
                }

            })
        }
    }
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
                }, 0);

            });


            element.bind("focus", function(e) {
                if(attrs.info){
                    $timeout(function() {
                        if(old.element!=element[0]){
                            setNotif.addNotif("info",attrs.info,[],{autohidden:5000});
                            old.element = element[0];
                            old.info = attrs.info;
                        }
                        $timeout.cancel(ref);
                        ref = $timeout(function() {
                            old ={element:"",info:""};
                        },30000);
                    }, 0);
                }
            })
        }
    }
});

MyApp.directive('duplicate', function($filter,$q,$timeout,setNotif) {

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
                        setNotif.hideByContent("alert","este nombre Vacro ya existe");
                        def.resolve();
                    }else{
                        setNotif.addNotif("alert","este nombre Vacro ya existe",[]);

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


MyApp.controller('AppMain', function ($scope,$mdSidenav,$http,setGetProv, Layers) {
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
        Layers.setModule($scope.seccion.secc);
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
        if(typeof (text) != 'undefined'){
            if(text.length >= 10){
                aux=text.substring(0, 10);
            }
            return new Date(Date.parse(aux));
        }

    }
});





