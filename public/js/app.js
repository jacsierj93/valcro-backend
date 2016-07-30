var dependency = ['ngMaterial', 'ngRoute','ngResource','ngMessages'/*,'ngSanitize'*/,'clickOut','ui.mask', 'ui.utils.masks','ngFileUpload'];
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

MyApp.config(function ($provide, $httpProvider, $locationProvider) {

    $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

    // Intercept http calls.
    var path= "http://"+window.location.hostname+"/"+window.location.pathname.split("/")[1]+"/";

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
                    if(rejection.status == 401){
                        location.replace(path +'login');
                    }
                // Return the promise rejection.
                return $q.reject(rejection);
            }
        };
    });

    // Add the interceptor to the $httpProvider.
    $httpProvider.interceptors.push('MyHttpInterceptor');
   // $locationProvider.html5Mode(true);


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
/*filtro para filtrar los option de los selects basandose en un array */
MyApp.filter('filterSelect', function() {
    return function(arr1, arr2) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        return arr1.filter(function(val) {
            return arr2.indexOf(val.id) === -1;//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    }
});

MyApp.filter('filterSearch', function() {
    return function(arr1, arr2) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        return arr1.filter(function(val) {
            return (arr2.indexOf(""+val.id) !== -1 || arr2.indexOf(val.id) !== -1);//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    }
});

MyApp.filter('customFind', function() {
    return function(arr1,arr2, func) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        return arr1.filter(function(val) {
            return func(val,arr2);
        });
    }
});


MyApp.directive('global', function (Layers, setNotif) {
    return {
        link: function (scope) {
            scope.module= Layers.getModule();
            scope.LayersAction = Layers.setAccion;
            scope.NotifAction = setNotif.addNotif;
           /* scope.scrollTo = function(newHash){
                if ($location.hash() !== newHash) {
                    $location.hash(newHash);
                } else {
                    $anchorScroll();
                }
            }*/
        }
    };
});

MyApp.directive('listBox', function ($timeout) {

    return {
        link: function (scope, elem, attrs,ctrl) {
            elem.bind("keydown",function(e){
                if(angular.element(elem).is("#launchList")){
                    if(e.which=="40"){
                        $timeout(function(){
                            angular.element('#listado').find(".boxList").first().focus();
                        },50)
                    }
                }else{
                    if(e.which=="40"){
                        var next = (angular.element(elem).next().length>0)?angular.element(elem).next():angular.element(elem).prevAll().last();
                        scope.$parent.scrollTo(next[0].id);
                        next[0].focus();
                    }else if(e.which=="38"){
                        var prev = (angular.element(elem).prev().length>0)?angular.element(elem).prev():angular.element(elem).nextAll().last();
                        scope.$parent.scrollTo(prev[0].id);
                        prev[0].focus();
                    }else if(e.which=="13"){
                        $timeout(function(){
                            angular.element(elem).click();
                        },0)
                    }

                }

            })

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

MyApp.directive('alpha', function () {
    return {
        link: function (scope, elem, attrs,ctrl) {

            elem[0].addEventListener('input', function(){
                var  num = this.value.match(/^[A-Z a-z]+$/);
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
                var  num = this.value.match(/^[\d\-\+\.\(\)]+$/);
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
        var elem = (typeof jqObject == "string")?angular.element("#"+jqObject):jqObject;
        var list = angular.element(elem).parents("form").first().find("[step]:not([disabled]):visible");
        if(list.index(elem)<list.length-1){
            $timeout(function(){
                if(angular.element(list[list.index(elem)+1]).is("md-select")){
                    angular.element(list[list.index(elem)+1]).focus().click();
                }else if(angular.element(list[list.index(elem)+1]).is("vlc-group")) {
                    $timeout(function(){
                        angular.element(list[list.index(elem)+1]).find("span").first().focus();
                    },0);
                }else{
                    angular.element(list[list.index(elem)+1]).focus();
                }

            },50);
        }else{
            var next = angular.element(elem).parents("form").first().nextAll("form:has([step]:not([disabled]):visible)").first();
            var nextFrm = angular.element(next).find("[step]:not([disabled]):visible").first();
            $timeout(function(){
                angular.element(next).click();
                $timeout(function(){
                    if(angular.element(nextFrm[0]).is("md-select")){
                        angular.element(nextFrm[0]).focus().click();
                    }else if(angular.element(nextFrm[0]).is("vlc-group")) {
                        $timeout(function(){
                            angular.element(nextFrm[0]).find("span").first().focus();
                        },0);
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
                    if(angular.element(elem).is("div")){
                        angular.element(elem).attr("tab-index","-1");
                    }
                    if(e.which == "13"){
                        skip(elem)
                        /*var list = angular.element(elem).parents("form").first().find("[step]:not([disabled]):visible");
                        if(list.index(elem)<list.length-1){
                            if(angular.element(list[list.index(elem)+1]).is("md-select")){
                                angular.element(list[list.index(elem)+1]).focus().click();
                            }else if(angular.element(list[list.index(elem)+1]).is("vlc-group")) {
                                $timeout(function(){
                                    angular.element(list[list.index(elem)+1]).find("span").first().focus();
                                },0);
                            }else{
                                $timeout(function(){
                                    angular.element(list[list.index(elem)+1]).focus();
                                },0);
                            }
                        }else{
                            var next = angular.element(elem).parents("form").first().nextAll("form:has([step]:not([disabled]):visible)").first();
                            var nextFrm = angular.element(next).find("[step]:not([disabled]):visible").first();
                            $timeout(function(){
                                angular.element(next).click();
                                $timeout(function(){
                                    if(angular.element(nextFrm[0]).is("md-select")){
                                        angular.element(nextFrm[0]).focus().click();
                                    }else if(angular.element(nextFrm[0]).is("vlc-group")) {
                                        $timeout(function(){
                                            angular.element(nextFrm[0]).find("span").first().focus();
                                        },0);
                                    }else{
                                        angular.element(nextFrm[0]).focus();
                                    }
                                },50);

                            },50);
                        }*/

                    }else if((e.which == "39" || e.which == "37") && angular.element(elem).is("div")){
                        angular.element(elem).parents("form").first().find("[chip]").first().focus().click();
                    }else if(e.which=="40"){
                        if(!angular.element("#lyrAlert").hasClass("md-closed")){
                            if(angular.element("#lyrAlert").find(".alertTextOpcs:visible").length > 0){
                               var focus =angular.element("#lyrAlert").find(".alertTextOpcs:visible > div").first();
                                angular.element(focus).focus();
                            };
                        }
                    }
                });
            }
            $compile(element[0])(scope);
        }
    };
});

/*MyApp.directive('skipNotif', function ($compile,$timeout) {
    return {
        priority: 1001,
        terminal:true,
        link: function (scope, element, attrs) {
            element.bind("keydown",function(e){
                if(e.which=="39"){
                    x = element.next();
                    if(x.length>0){
                        x.focus();
                    }else{
                        element.parent().find("[skip-notif]").first().focus();
                    }
                }else if(e.which=="37"){
                    x = element.prev();
                    if(x.length>0){
                        x.focus();
                    }else{
                        element.parent().find("[skip-notif]").last().focus();
                    }
                }else if(e.which=="13"){
                    $timeout(function(){element.click()},0);
                }
            })
            $compile(element[0])(scope)
        }
    }
})*/

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


MyApp.directive('range', function () {
    function validateRange(viewValue,min,max){
        if(viewValue === undefined || viewValue=="" || viewValue==null){
            console.log('view value', viewValue);
            return false;
        }
        if(min){
            return parseInt(min ) <= parseInt(viewValue);
        }
        if(max){
            return parseInt(max) <= parseInt(viewValue);
        }
    }

    return  {
        restrict: 'A',
        require: 'ngModel',
        link: function (scope, elem, attrs, ctrl) {
            /*        console.log("atttr", attrs);
             console.log("atttr", elem);
             console.log("escope", scope);
             console.log("ctrol", ctrl);*/
            var validate = false;
            attrs.$observe('range', function(range){
                if(range == "true" ){
                    validate= true;
                    if(ctrl.$viewValue == "0"){
                        ctrl.$render();
                        ctrl.$setViewValue("");
                        ctrl.$render();
                    }
                }else{
                    validate= false;
                    if(ctrl.$viewValue != "0"){
                        ctrl.$render();
                        ctrl.$setViewValue("0");
                        ctrl.$render();


                    }
                }

            });


            ctrl.$validators.range = function(modelValue, viewValue) {
                if(validate == true){
                    var paso= validateRange(viewValue,attrs.minval,attrs.maxval);
                    if(!paso){
                        elem[0].focus();
                    }
                    return paso;
                }
                return true;
            };

        }
    };
});

MyApp.directive('rowSelect', function () {
    return {
        link: function (scope, elem, attrs,ctrl) {
            elem.bind("keydown",function(e){
                if(e.which=="40"){
                    var next =angular.element(elem).next();
                    var focus = angular.element(next).find(".cellSelect");
                    focus[0].focus();
                }else if(e.which=="38"){
                    var prev =angular.element(elem).prev();
                    var focus = angular.element(prev).find(".cellSelect");
                    focus[0].focus();
                }else if(e.which=="13"){
                   /* $timeout(function(){
                        angular.element(elem).click();
                    },0)*/
                }
            })

        }
    };
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


MyApp.controller('AppMain', function ($scope,$mdSidenav,$http,$filter,setGetProv, Layers,App) {

    $scope.accion = App.getAccion();
    $scope.secciones = [
        {
            secc: 'Inicio',
            key:'inicio',
            url: 'modules/home/index',
            selct: 'btnDot'
        }, {
            secc: 'Proveedores',
            key:'proveedores',
            url: 'modules/proveedores/index',
            selct: 'btnDot'
        }, {
            secc: 'Embarques',
            key:'embarques',
            url: 'modules/embarques/index',
            selct: 'btnDot'
        }, {
            secc: 'Pagos',
            key: 'pagos',
            url: 'modules/pagos/index',
            selct: 'btnDot'
        }, {
            secc: 'Pedidos',
            key:'pedidos',
            url: 'modules/pedidos/index',
            selct: 'btnDot'
        }];
    $scope.seccion = $scope.secciones[0];
    $scope.seccLink = function (item){
        $scope.seccion = angular.copy(item);
        Layers.setModule($scope.seccion.key);
        angular.forEach($scope.secciones, function(value, key) {
            if( $scope.seccion.key == value.key){
                value.selct = 'btnLine';
            }else{
                value.selct = 'btnDot';
            }
        });
    };
    $scope.$watch('accion.estado', function (newval){
        if(newval){
            console.log("data", $scope.accion );
            var data = $scope.accion.value;
            if(data.msm){
                var msm ={to:data.module,from:$scope.seccion.key,msm:data.msm}

                App.setMsm(msm);
            }
            if (data.module){
                var mnew=  angular.copy($filter("customFind")($scope.secciones,data.module,function(current,compare){return current.key==compare})[0]);
                $scope.seccLink(mnew);
            }
        }
    });



    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //$scope.toggleLeft = buildToggler('left');

   /* $scope.toggleRight = buildToggler('right');
    $scope.toggleOtro = buildToggler('otro');
    function buildToggler(navID) {
        return function() {
            // Component lookup should always be available since we are not using `ng-if`
            $mdSidenav(navID).toggle();
        }
    }*/
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3

});

MyApp.controller("FilesController" ,['$filter','$scope','$mdSidenav','$resource','$timeout','Upload','SYSTEM','filesService','Layers','setNotif', function($filter, $scope,$mdSidenav,$resource,$timeout,Upload ,SYSTEM,filesService, Layers,setNotif){

    $scope.template = "modules/home/files";
    $scope.accion= filesService.getAccion();
    $scope.isOpen = filesService.isOpen();
    $scope.titulo = filesService.getTitle();
    $scope.pitures = filesService.getFiles();
    $scope.module = Layers.getModule();
    $scope.moduleAccion = Layers.getAccion();
    $scope.cola = filesService.getProcess();
    $scope.allowUpload = filesService.allowUpload();
    filesService.setAllowUpload(false);
    $scope.inLayer = "";
    $scope.expand=false;
    $scope.imgSelec = null;
    $scope.resource = $resource('master/files/:type', {}, {
        query: {method: 'GET',params: {type: "getFiles"}, isArray: true},
        get: {method: 'GET',params: {type:"getFile"}, headers: {'Content-Type': 'image/png'},isArray: false},

    });

    /***
     * indicador de progreso
     * usar $watch para saber si se terminaron de subir todos los archivos
     *  filesService.getProcess().estado;
     *  cuando olVal =='loading' && newVal == 'finished' se acaba de subir los archivos
     * ***/
    $scope.$watchGroup(['cola.total',
        'cola.terminados.length','cola.estado'], function(newVal){
        if(newVal[0]> 0 && newVal[2] == 'wait'){/// si entra en modo de espera
            $scope.cola.estado='loading';

        }
        if(newVal[0] == newVal[1] && newVal[2] == 'loading'){
            $scope.cola.estado='finished';
        }
    });

    /** cerrado de la grilla en modo small**/
    $scope.closeSideFile = function(e){
        if(!angular.element(e.target).is("#ngf-fileInput")){
            if($scope.isOpen){
                filesService.close();
            }
        }
    };

    $scope.selectImg= function(doc){
        console.log("upload ", $scope.allowUpload);
        Layers.setAccion({open:{name:'sideFiles',before:
            function(){$scope.expand=true;}
        }});

        if(doc.tipo.startsWith("image")){
            $scope.imgSelec =SYSTEM.PATHAPP +"master/files/getFile?id="+doc.id;
            $scope.pdfSelec= undefined;
        }else {
            $scope.imgSelec =undefined;
            $scope.pdfSelec= SYSTEM.PATHAPP +"master/files/getFile?id="+doc.id;
        }
    };

    /** subida de archivos  al servidor */
    $scope.upload = function(files){

        $scope.isUploading = false;
        $scope.cola.total = files.length;
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                Upload.upload({
                    url: 'master/files/upload',
                    data :{ folder:filesService.getFolder(),file: file}
                }).progress(function (evt) {
                    uploadNow = parseInt(100.0 * evt.loaded / evt.total);
                }).success(function (data, status, headers, config) {
                    $scope.pitures.push(data);
                    $scope.cola.terminados.push(data);
                }).error(function(){
                    $scope.cola.estado = "error";
                });
            }
        }
    };

    $scope.$watch("accion.estado", function(newval){

        if(newval){

            if($scope.accion.data.open ){
                $scope.inLayer = angular.copy($scope.module.layer);
                if($scope.inLayer){
                    var exp = angular.element(document).find("#"+$scope.inLayer).find("#expand");
                    if(exp.length > 0){
                        exp.animate({width:"336px"},400);
                    }
                }

                var sn = angular.element(document).find("#sideFiles");
                sn.css('width','336px');
                sn.css('z-index',String(Layers.getModule().index + 60));

                $mdSidenav("sideFiles").open().then(function(){
                    $scope.isOpen= true;
                });
                $scope.accion.estado=false;
            }else  if($scope.accion.data.close ){
                if($scope.inLayer){
                    var exp = angular.element(document).find("#"+$scope.inLayer).find("#expand");
                    if(exp.length > 0){
                        exp.animate({width:"0px"},400);

                    }
                }

                if(!$scope.expand){
                    console.log("cerrado")

                    $mdSidenav("sideFiles").close().then(function(){
                        if($scope.expand){
                            $scope.expand=false;
                        }
                        console.log("cerrado ");
                        $scope.isOpen= false;
                    });


                }else{
                    $scope.isOpen= false;
                    $scope.expand = false;
                    console.log("cerrado ");
                }
                $scope.accion.estado=false;


            }

        }
    });

    $scope.$watch('module.layer', function(newVal){
        if(newVal){
            $timeout(function(){
                if($scope.isOpen && newVal != "sideFiles" ){
                    filesService.close();
                }
            },200);

        }

    });

}]);


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

MyApp.service('App' ,[function(){

    var accion ={estado :false,value:{}};
    var msm ={};
    return {

        getAccion : function(){
            return accion;
        },
        changeModule : function( data){
            accion.value = data;
            accion.estado= true;
        },
        setMsm: function(data){
            msm =data;
        },
        getMsm: function(){
        return  msm;
        },
        clearMsm : function(){
            msm= {}
        }
    }


}]);

MyApp.service('filesService' ,function(){
    var all = new Array();
    var accion ={estado:false,data:{}};
    var isOpen= false;
    var titulo ="Adjuntos";
    var folder ="";
    var process = {
        total : 0 ,
        terminados: new Array(),
        estado:'wait'
    };
    var allowUpload = {val:false};
    return {
        setFiles: function(data){
            all.splice(0,all.length);
            angular.forEach(data, function(v){
                all.push(v);
            });
            console.log();

        },
        getFiles: function(){
            return all;
        },
        getAccion : function(){
            return accion;
        },
        open : function(){
            accion.data ={open:true};
            accion.estado=true;

        },
        close : function(){
            accion.data ={close:true};
            accion.estado=true;
        },
        isOpen : function(){
            return isOpen;
        },
        getTitle: function(){
            return titulo;
        },
        setTitle : function(value){
            titulo =value;
        },
        setFolder: function(value){
            folder = value;
        },
        getFolder : function (){
            return folder;
        },
        getProcess : function(){
            return process;
        },
        getRecentUpload : function(){
            var data = angular.copy(process.terminados);
            process.terminados.splice(0,process.terminados.length);
            process.total =0;
            process.estado ='wait';
            return data;
        },
        allowUpload : function(){return allowUpload;},
        setAllowUpload : function(value){
            allowUpload.val= value;
        }


    };
});

MyApp.service('Layers' , function(){

    var modules ={};
    var accion ={estado:false,data:{}};
    var modulekey="";
    return {
        setModule: function (name){
            if(!modules[name]){
                modules[name]={historia: [],layers:{},index: 0,layer:undefined,block:false};

            }else{
                modules[name].historia = [];
                modules[name].layers = {};
                modules[name].layer =undefined;
                modules[name].index =0;
                modules[name].block =false;

            }
            modulekey=name;
            return modules[name];
        }, getModule : function(name){
            if(!name){
                return modules[modulekey];
            }else{
                return modules[name];
            }

        },
        getAccion : function(){
            return accion;
        },
        setAccion: function(arg){

            accion.data=arg;
            accion.estado=true;
        }
        /*,
         getIndex : function (){
         return  modules[modulekey].layer;
         },
         getModuleKey : function(){ return modulekey;}*/
    }
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



/*MyApp.run(['$route', function($route)  {
 $route.reload();
 }]);*/

/*
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
*/




/*function DemoCtrl1 ($timeout, $q, $log) {
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
    /!**
     * Search for states... use $timeout to simulate
     * remote dataservice call.
     *!/
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
    /!**
     * Build `states` list of key/value pairs
     *!/
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
    /!**
     * Create filter function for a query string
     *!/
    function createFilterFor(query) {
        var lowercaseQuery = angular.lowercase(query);
        return function filterFn(state) {
            return (state.value.indexOf(lowercaseQuery) === 0);
        };
    }
}*/

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

MyApp.constant('SYSTEM',{
    ROOT:"http://"+window.location.hostname,
    BASE:"/"+window.location.pathname.split("/")[1]+"/",
    PATHAPP : "http://"+window.location.hostname+"/"+window.location.pathname.split("/")[1]+"/"
});



