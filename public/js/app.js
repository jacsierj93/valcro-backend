var dependency = ['ngMaterial', 'ngRoute','ngResource','ngMessages','vlcClickOut','ngSanitize','ngFileUpload','io-barcode','treeControl'];
var urls = [
    {
        secc: 'Inicio',
        key:'inicio',
        url: 'modules/home/index',
        selct: 'btnPie'
    }, {
        secc: 'Proveedores',
        key:'proveedores',
        url: 'modules/proveedores/index',
        selct: 'btnPie'
    }, {
        secc: 'Embarques',
        key:'embarques',
        url: 'modules/embarques/index',
        selct: 'btnPie'
    }, {
        secc: 'Pagos',
        key: 'pagos',
        url: 'modules/pagos/index',
        selct: 'btnPie'
    }, {
        secc: 'Pedidos',
        key:'order',
        url: 'modules/pedidos/index',
        selct: 'btnPie'
    }, {
        secc: 'Criterios',
        key:'criterios',
        url: 'modules/criterios/index',
        selct: 'btnPie'
    }, {
        secc: 'Productos',
        key:'productos',
        url: 'modules/productos/index',
        selct: 'btnPie'
    }, {
        secc: 'Usuarios',
        key:'usuarios',
        url: 'modules/usuarios/index',
        selct: 'btnPie'
    }];

var MyApp = angular.module('MyApp', dependency, function() {

});

/********************************************************/

window.addEventListener("keydown", function(e) {
    // space and arrow keys

    if([37, 38, 39, 40,27,9].indexOf(e.keyCode) > -1 ) {
        if(angular.element(e.target).is("input") || angular.element(e.target).is("textarea")) {
            if ([38, 40, 27, 9].indexOf(e.keyCode) > -1){
                e.preventDefault();
            }
        }else{
            e.preventDefault();
        }

    }
}, false);
/*angular.element(document).ready(function(){
    angular.element("body").on("focus","textarea",function(){

        val = angular.element(this).val();
        angular.element(this).val("").val(val);
    })
})*/

MyApp.config(function ($provide, $httpProvider) {

    /*    localStorageServiceProvider
     .setStorageType('localStorage')
     .setDefaultToCookie(false);
     */

    $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

    // Intercept http calls.
    var path= "http://"+window.location.hostname+"/"+window.location.pathname.split("/")[1]+"/";

    $provide.factory('MyHttpInterceptor', function ($q, lmbCountRequest) {

        return {
            // On request success
            request: function (config) {
                // console.log(config); // Contains the data about the request before it is sent.
                //console.log("in config reques", config);
                lmbCountRequest[(config.method == 'GET') ? 'get' : 'post' ] ++;
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
                lmbCountRequest[(response.config.method == 'GET') ? 'get' : 'post' ]--;
                return response || $q.when(response);
            },

            // On response failture
            responseError: function (rejection) {
                lmbCountRequest[(rejection.config.method == 'GET') ? 'get' : 'post' ]--;
                // console.log(rejection); // Contains the data about the error.
                if(rejection.status == 401){
                    //location.replace(path +'login');
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
MyApp.service('lmbCountRequest', function () {
    var count =   {
        get:0,
        post:0
    };

    return {
        get:0,
        post:0
    };

});

/// agregado por miguel cambio de formato de fecha
MyApp.config(function($mdDateLocaleProvider) {
    $mdDateLocaleProvider.formatDate = function(date) {

        if(date){
            var day = date.getDate();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            return day + '/' + (monthIndex + 1) + '/' + year;
        }else{
            return null;
        }


    };
});
//###########################################################################################3
//##############################REST service (factory)#############################################3
//###########################################################################################3
/*
 MyApp.factory('masters', ['$resource',
 function ($resource) {
 return $resource('master/:type/:id', {}, {
 query: {method: 'GET', params: {type: "",id:""}, isArray: true}
 });
 }
 ]);

 */

MyApp.factory('masters', ['$resource',
    function ($resource) {
        return $resource('master/:type/:id', {}, {
            query: {method: 'GET', params: {type: "",id:""}, isArray: true},
            post: {method: 'POST', params: {type: "",id:""}, isArray: false}
        });
    }
]);

MyApp.service("generic",function(masters){
    var units = masters.query({ type:"getUnits"});
    return {
        units : function(){
            return units;
        }
    };

});
MyApp.factory('user', ['$resource',
    function ($resource) {
        return $resource('usrs/:type/:id', {}, {
            get: {method: 'GET', params: {type: "",id:""}, isArray: false},
            query: {method: 'GET', params: {type: "",id:""}, isArray: false},
        });
    }
]);


/*filtro para filtrar los option de los selects basandose en un array */
MyApp.filter('filterSelect', function() {
    return function(arr1, arr2,id) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        if(!arr2){
            return [];
        }
        if(!id){
            id="id";
        }

        return arr1.filter(function(val) {
            return arr2.indexOf(eval("val."+id)) === -1;//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    };
});

MyApp.filter('filterSearch', function() {
    return function(arr1, arr2,id) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        if(!id){
            id="id";//el tercer argumento puede especificar el campo por el cual se va a buscar, esto puede ser en notacion de punto, ej obj1.obj2.id
        }
        if(!arr2 || arr2.length == 0){
            return arr1;
        }
        return arr1.filter(function(val) {
            return (arr2.indexOf(eval("val."+id+".toString()")) !== -1 || arr2.indexOf(parseInt(eval("val."+id))) !== -1);//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    };
});
MyApp.filter('filterSearchBlnk', function() {
    return function(arr1, arr2,id) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        if(!id){
            id="id";//el tercer argumento puede especificar el campo por el cual se va a buscar, esto puede ser en notacion de punto, ej obj1.obj2.id
        }
        if(!arr2 || arr2.length == 0){
            return [];
        }
        return arr1.filter(function(val) {
            return (arr2.indexOf(eval("val."+id+".toString()")) !== -1 || arr2.indexOf(parseInt(eval("val."+id))) !== -1);//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    };
});

/**
 * filtra para buscar dentro de array de json
 * @param data el array de objetos
 * @param compare el valor a evaluar
 * @param key clave que corresponde al json
 *@return un array de resultados
 * **/
MyApp.filter('stringKey', function() {

    return function(data,compare, key) {
        return (!data) ? [] :data.filter(function(val) {
            str = eval("val."+key);
            return (!str || !compare || typeof(compare)=='undefined' || compare.length == 0 ) ? true:  str.toLowerCase().indexOf(compare.toLowerCase())!==-1;
        });
    };
});
MyApp.filter('customFind', function() {

    return function(arr1,arr2, func) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        if(!arr1) return false;

        return arr1.filter(function(val) {
            return  (func) ? func(val,arr2) : true;
        });
    };
});

MyApp.filter('filtCountry', function() {
    return function(lists, search) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        if(search==""){
            return lists;
        }
        return lists.filter(function(val) {
            return val.short_name.toLowerCase().indexOf(search.toLowerCase()) != -1 ;//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    };
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
                        },50);
                    }
                }else{
                    if(e.which=="40"){
                        var next = (angular.element(elem).next().length>0)?angular.element(elem).next():angular.element(elem).prevAll().last();
                        angular.element(elem).parent().scrollTop(angular.element(elem).parent().scrollTop() + next.outerHeight());
                        next[0].focus();
                    }else if(e.which=="38"){
                        var prev = (angular.element(elem).prev().length>0)?angular.element(elem).prev():angular.element(elem).nextAll().last();
                        if(prev.offset().top < 0){
                            angular.element(elem).parent().scrollTop(angular.element(elem).parent().scrollTop() - prev.outerHeight());
                        }
                        prev[0].focus();
                    }
                }
            });
            elem.bind("click",function(e){
                $timeout(function(){
                    angular.element(elem).parent().scrollTop(angular.element(elem).outerHeight()*angular.element(elem).index());
                },0);
            });

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

            elem.bind("keydown",function(e){


                var key = window.Event ? e.which : e.keyCode;
                if(!((key >= 48 && key <= 57) || (key==8)  || (key >= 96 && key <= 105
                        || key == 188 || key == 190 ||key == 110 || key == 17 || key == 16 || key == 20 || key == 93 || key == 225)
                        || (key >= 112 && key <= 123)
                    )   ){
                    if(key != 13){
                        e.preventDefault();
                    }


                }
            });

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
            });

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
        var genericList = angular.element("[step]:not([disabled]):visible");
        if(list.index(elem)<list.length-1){

            $timeout(function(){
                if(angular.element(list[list.index(elem)+1]).hasClass("autoclick")){
                    angular.element(list[list.index(elem)+1]).focus().click();
                }else if(angular.element(list[list.index(elem)+1]).is("vlc-group")) {
                    $timeout(function(){
                        angular.element(list[list.index(elem)+1]).find("span").first().focus();
                    },0);
                }else if(angular.element(list[list.index(elem)+1]).is("md-autocomplete")) {
                    angular.element(list[list.index(elem)+1]).find("input").focus().click();
                }else{

                    angular.element(list[list.index(elem)+1]).focus();
                }

            },50);

        }else if((angular.element(elem).parents("form").first().nextAll("form:visible:has([step]:not([disabled]))").length>0) || (genericList.index(elem)<genericList.length-1)){

            if(!scope.endLayer) {
                var next = angular.element(elem).parents("form").first().nextAll("form:has([step]:not([disabled]))").first();
                if(next.length==0){
                    next = angular.element(genericList[genericList.index(elem)+1]).parents("form").first();
                }
                var nextFrm = angular.element(next).find("[step]:not([disabled])").first();
                $timeout(function () {
                    angular.element(next).click();
                    angular.element(":focus").blur();
                    $timeout(function () {
                        if (angular.element(nextFrm[0]).is("md-select")) {
                            angular.element(nextFrm[0]).focus().click();
                        } else if (angular.element(nextFrm[0]).is("vlc-group")) {
                            $timeout(function () {
                                angular.element(nextFrm[0]).find("span").first().focus();
                            }, 0);
                        }else if(angular.element(nextFrm[0]).is("md-autocomplete")) {
                            $timeout(function () {
                                angular.element(nextFrm[0]).find("input").focus();
                            }, 0);
                        } else {
                            angular.element(nextFrm[0]).focus();
                        }
                    }, 500);
                }, 0);
            }else{
                scope.endLayer();
            }
        }else{
            $timeout(function(){
                if(!angular.element(elem).parents("md-sidenav.popUp").length>0){ //evalua si el sidenav que esta a fnalizar No es un popUp
                    if(!scope.endLayer) {
                        var shower = angular.element(elem).parents("md-sidenav").find(".showNext");
                        shower.trigger('mouseover');
                        show = (shower.attr("valid"))?scope.$eval(shower.attr("valid")+"()"):true;
                        angular.element(elem).blur();
                        //angular.element(elem).parents("md-content").delay(200).click();
                        if(show){
                            angular.element("[md-component-id='NEXT']").find("img").delay(500).trigger('click');
                        }

                        /*angular.element("[md-component-id='NEXT']").focus();*/
                    }else{
                        scope.endLayer(function(){
                            angular.element(elem).parents("md-sidenav").find(".showNext").trigger('mouseover');
                            angular.element(elem).blur();
                            //angular.element(elem).parents("md-content").delay(200).click();
                            angular.element("[md-component-id='NEXT']").find("img").delay(500).trigger('click');
                        },elem);
                    }
                }else{

                    if(scope.endLayer){
                        scope.endLayer(function(elem){
                            angular.element(elem).parents("md-sidenav").find(".showNext").trigger('mouseover');
                            angular.element(elem).blur();
                            //angular.element(elem).parents("md-content").delay(200).click();
                            angular.element("[md-component-id='NEXT']").find("img").delay(500).trigger('click');
                        });
                    }
                }
            },0);

        }
    };

    return {
        priority: 1010,
        terminal:true,
        link: function (scope, element, attrs) {
            //console.log(element)
            if(attrs["skipTab"] != "off"){
                element.attr("step","");
            }
            if(attrs["skipTab"] == "autoClik"){
                element.addClass("autoclick");
            }
            element.removeAttr("skip-tab");
            if(angular.element(element).is("div")){
                angular.element(element).attr("tab-index","-1");
            }
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
                    //console.log("ELEMENT ==>",elem)
                    if(e.which == "13"){
                        skip(elem,scope);
                    }else if((e.which == "39" || e.which == "37") && angular.element(elem).is("div")){
                        angular.element(elem).parents("form").first().find("[chip]").first().focus().click();
                    }else if(e.which=="40"){
                        if(!angular.element("#lyrAlert").hasClass("md-closed")){
                            scope.$parent.prevFocus = angular.element(":focus");
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

MyApp.directive('skipNotif', function ($compile,$timeout) {
    return {
        /*priority: 1001,
         terminal:true,*/
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
                    $timeout(function(){
                        element.click();
                    },0);
                    scope.$parent.prevFocus.focus();
                }
            });
            //$compile(element[0])(scope)
        }
    };
});

MyApp.directive('info', function($timeout,setNotif,$filter, $sce,$parse) {
    var old ={element:"",info:"",scope:null};
    var ref = false;

    return {
        restrict: 'A',
        require: '?mdAutocomplete',
        link: function(scope, element, attrs,model) {
            /*if(("model" in  attrs)){
                var mod = scope.$eval(attrs.model);
                model.scope.itemChange = function(){
                    mod = (model.scope.selectedItem)?model.scope.selectedItem.id : false;
                }
            }
            if(("src" in  attrs)) {

            }*/
            if(element.is("md-autocomplete") &&  attrs.model){
                var src = scope.$eval(attrs.mdItems.split(/ in /i)[1].split(/ \| /)[0]);
                var ngmodel = attrs.model;
                var local = false;
                var keyVal = attrs.key || "item.id";

                var text = attrs.mdItemText.split(".")[1];

                model.scope.itemChange = function(cambio){
                    if(typeof(cambio)=="undefined"){
                        return false;
                    }
                    local = true;
                    
                    var valor = eval("cambio."+keyVal);
                    scope.$eval(attrs.model+" = "+valor);

                };
                scope.$watch(ngmodel, function (newVall, olVal) {

                    if(typeof(newVall)=="undefined"){
                        return false;
                    }
                    if(local){
                        local = false;
                        return false;
                    }
                    var aux = (newVall)? $filter("filterSearch")(src, [newVall],keyVal.replace("item.","")) : [];

                    if(aux.length > 0 && !angular.equals(aux[0],model.mdSelectedItem)){
                            model.scope.selectedItem = (aux.length>0)?aux[0] : null;
                    }
                });
            }

            if(attrs.lmbRequired){
                model.scope.$watch("selectedItem", function (newVall, olVal) {
                    if(newVall){
                        var json = JSON.parse(attrs.lmbRequired);

                        var error = [];

                        angular.forEach(json, function (v, k) {

                            if(!(k  in model.scope.selectedItem) ){

                            }else{
                                var e =  model.scope.selectedItem[k];
                                if((typeof(e) == 'array' && e.length == 0)|| (typeof(e) == 'object' && Object.keys(e).length == 0)  ){
                                    error.push(v);
                                }
                            }
                        });
                        if(error.length > 0){
                            
                            angular.forEach(error, function (v, k) {
                                setNotif.addNotif("error", v,[],{autohidden:7000});
                            });
                            if('lmbRequiredClearOnFail' in  attrs){
                                $timeout(function () {
                                    model.scope.searchText = undefined;
                                    console.log("limpiando", model.scope);
                                }, 100);
                            }

                        }
                    }
                });

            }

            element.bind("blur", function(e) {
                $timeout(function() {
                    setNotif.hideByContent("info",attrs.info);
                }, 0);

            });

            var showInfo = function(){
                if(attrs.info){
                    $timeout(function() {
                        if(old.element!=element[0]){
                            setNotif.addNotif((attrs.tipo)? attrs.tipo : 'info',attrs.info,[],{autohidden:5000});
                            old.element = element[0];
                            old.info = attrs.info;
                        }
                        $timeout.cancel(ref);
                        ref = $timeout(function() {
                            old = {element:"",info:""};
                        },30000);
                    }, 0);
                }
            };

            if(element.is("span")){
                element.on("mouseover", function(e) {
                    $timeout(function(){
                        showInfo();
                    },700);

                });

                element.on("mouseleave", function(e) {
                    $timeout(function() {
                        setNotif.hideByContent("info",attrs.info);
                    }, 0);
                });
            };

            if(element.is("md-autocomplete")){
                element.on("focus","input", function(e) {
                    this.select();
                    showInfo();

                });

                element.on("blur","input", function(e) {
                    if(!model.scope.selectedItem && !angular.element(e.relatedTarget).is("li[md-virtual-repeat]")){

                        if(model.matches.length > 0 && (model.scope.searchText!=undefined && model.scope.searchText != "")){
                            model.scope.selectedItem = model.matches[0];
                        }else{
                            if(!attrs.$attr.vlNoClear){
                                model.scope.searchText = undefined;
                            }

                        }
                    }




                });
            }else{
                element.bind("focus", function(e){
                    showInfo();
                });
            }


        }
    };
});

MyApp.directive('duplicate', function($filter,$q,$timeout,setNotif) {

    return {
        require: '?ngModel',
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

                    modelValue = modelValue.toString();
                    if ($filter("customFind")(scope[srcScope],modelValue,function(current,compare){return current[fld].toUpperCase() == compare.toUpperCase() && (scope.localId !=current.id)}).length<1) {
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


MyApp.directive('lmbMinImp', function($filter,$q,$timeout,setNotif) {

    return {
        require: '?ngModel',
        link: function(scope, elm, attrs, ctrl) {
            //console.log(scope, elm, attrs, ctrl)
            //var targ = attrs.integer;
            ctrl.$validators.minImp = function(modelValue, viewValue) {
                if (ctrl.$isEmpty(modelValue) || ctrl.$pristine) {
                    return true;
                }
                if(parseInt(modelValue) < parseInt(attrs.lmbMinImp)){
                    return false;
                }
                return true;

            };
        }
    };
});

MyApp.directive('lmbMaxImp', function($filter,$q,$timeout,setNotif) {

    return {
        require: '?ngModel',
        link: function(scope, elm, attrs, ctrl) {
            //var targ = attrs.integer;
            ctrl.$validators.maxImp = function(modelValue, viewValue) {
                if (ctrl.$isEmpty(modelValue) || ctrl.$pristine || modelValue===true) {
                    //console.log("entrooooo",modelValue)
                    return true;
                }
                if(parseInt(modelValue) > parseInt(attrs.lmbMaxImp)){

                    return false;
                }

                return true;

            };
        }
    };
});

MyApp.directive('erroListener', function($filter,$q,$timeout,setNotif){
    return {
        require: '?ngModel',
        scope:{
            email:"=?emailMsg",
            max:"=?maxMsg",
            maxlength:"=?maxlengthMsg",
            min:"=?minMsg",
            minlength:"=?minlengthMsg",
            number:"=?numberMsg",
            pattern:"=?patternMsg",
            required:"=?requiredMsg",
            url:"=?urlMsg",
            date:"=?dateMsg",
            datetimelocal:"=?datetimelocalMsg",
            time:"=?timeMsg",
            week:"=?weekMsg",
            month:"=?monthMsg",
            minImp:"=?minImpMsg",
            maxImp:"=?maxImpMsg",
            mdMinLength:"=?mdMinLength",
            duplicate:"=?duplicateMsg"

        },
        link: function(scope, elm, attrs, ctrl) {

            scope.errors = ctrl.$error;
           // console.log(ctrl)
            scope.$watchCollection("errors",function(n,o){
                //console.log(ctrl)
                if(ctrl.$dirty){
                    angular.forEach(o,function(k,v){
                        if(!(v in n)){
                            if(v in scope){
                                setNotif.hideByContent(scope[v].t,scope[v].m);
                            }

                        }
                    });
                    angular.forEach(n,function(k,v){
                        if((v in scope)){
                            btn = (scope[v].t == "alert")?[{name:"ok",action:function(){
                                ctrl.$setValidity(v, true);
                                //console.log(ctrl.$error)
                            }}]:[];

                            setNotif.addNotif(scope[v].t,scope[v].m,btn);
                        }

                    });
                }

            });

        }
    };
});

MyApp.directive('range', function () {
    function validateRange(viewValue,min,max){
        if(viewValue === undefined || viewValue=="" || viewValue==null){
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
            /*            console.log("atttr", attrs);
             console.log("atttr", elem);
             console.log("escope", scope);
             console.log("ctrol", ctrl);*/
            elem.bind("keydown",function(e){
                var key = window.Event ? e.which : e.keyCode;
                if(!((key >= 48 && key <= 57) || (key==8)  || (key >= 96 && key <= 105
                        || key == 188 || key == 190 ||key == 110 || key == 17 || key == 16 || key == 20 || key == 93 || key == 225)
                        || (key >= 112 && key <= 123)
                    )   ){
                    if(key != 13){
                        e.preventDefault();
                    }
                }
            });
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
                    if(!ctrl.$valid){
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
                        //  elem[0].focus();
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
MyApp.controller('AppFoot',['$scope','$location',  'App','Layers',function ($scope,$location,  App, Layers) {
    $scope.secciones= urls;
    $scope.seccion = App.getSeccion();
    $scope.$on('$locationChangeSuccess', function(event, newVal, olval) {
       var path = newVal.substr(newVal.indexOf('#')+1, newVal.length);
       var asig = false;
        angular.forEach($scope.secciones, function (v,k) {
            if(path == '/'+v.key){
                App.setSeccion(v);
                Layers.setModule(v);
                v.selct = 'btnPieSelc';
                asig= true;
                return 0;
            }else{
                v.selct = 'btnPie';
            }
        });
        if(!asig){
            $scope.secciones[0].selct=  'btnPieSelc';
        }

    });
    $scope.seccLink = function (item){
         var url = '/'+item.key;
        $location.path(url);

    };


}]);

MyApp.controller('AppMain', function ($scope,$timeout,$mdSidenav,$location,$filter,setGetProv, Layers,App,$routeParams, ExtRedirect, user) {

    $scope.bindBlock=App.getBindBloc();
    
     user.get({ type:"usr"},function(data){
         $scope.usr = data.nombre;
    });

    
});

MyApp.controller('AppBlock', ['$scope','App',function ($scope, App){
    $scope.bindBlock=App.getBindBloc();
    $scope.$watch('bindBlock.estado' , function(newval){

        if(newval){
            $scope.block= App.getBindBloc().value;
            console.log('in app', $scope.block);


        }
    });

}]);

MyApp.config(['$routeProvider', '$locationProvider',
    function($routeProvider, $locationProvider) {


        angular.forEach(urls, function (v) {
            var data = { templateUrl:v.url};
            if(v.controller){
                data.controller = v.controller;
            }
            $routeProvider.when('/'+v.key,data);
        });
        $routeProvider.when('/', {
            templateUrl: 'modules/home/index'
        });
        $routeProvider.otherwise({ redirectTo: '/' });
        //$locationProvider.html5Mode(true);
    }]);

MyApp.controller("FilesController" ,['$filter','$scope','$mdSidenav','$resource','$timeout','Upload','SYSTEM','filesService','Layers','setNotif', function($filter, $scope,$mdSidenav,$resource,$timeout,Upload ,SYSTEM,filesService, Layers,setNotif){

    $scope.template = "modules/home/files";
    $scope.accion= filesService.getAccion();
    $scope.isOpen = filesService.isOpen();
    $scope.titulo = filesService.getTitle();
    $scope.pitures = filesService.getFiles();
    $scope.module = Layers.getModule();
    $scope.moduleAccion = Layers.getAccion();
    $scope.cola = filesService.getProcess();
    $scope.uploading = false;
    $scope.progress = 0;
    $scope.allowUpload = filesService.allowUpload();
    filesService.setAllowUpload(false);
    $scope.inLayer = "";
    $scope.expand=false;
    $scope.imgSelec = null;
    $scope.resource = $resource('master/files/:type', {}, {
        query: {method: 'GET',params: {type: "getFiles"}, isArray: true},
        get: {method: 'GET',params: {type:"getFile"}, isArray: false},

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

    $scope.$watch('$$childHead.serviceFiles.length', function(newValue){

        if(newValue > 0){
            console.log("files data", $scope.$$childHead.serviceFiles);
            $scope.upload( $scope.$$childHead.serviceFiles );
            //$scope.$$childHead.serviceFiles =[]
        }
    });

    $scope.up = function(val){
        alert("");
        console.log("val", val)
        console.log("scope " ,$scope);

        console.log("serviceFiles " ,$scope.serviceFiles);

        $timeout(function(){
            console.log("serviceFiles 2 " ,$scope.serviceFiles);


        }, 100);
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
                    // progress=evt.loaded;
                    uploaded = parseInt(100.0 * evt.loaded / evt.total)

                    //$scope.progress = ($scope.cola.terminados.length != $scope.cola.total)?(($scope.cola.terminados.length*100) + uploaded) / $scope.cola.total:($scope.cola.terminados.length*100)/$scope.cola.total;

                    //console.log(uploaded,"progreso",$scope.progress)
                }).success(function (data, status, headers, config) {
                    $scope.pitures.push(data);
                    $scope.cola.terminados.push(data);
                }).error(function(){
                    $scope.cola.estado = "error";
                });
            }

            $scope.uploading = 0;

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

                    $mdSidenav("sideFiles").close().then(function(){
                        if($scope.expand){
                            $scope.expand=false;
                        }
                        filesService.clear();
                        $scope.isOpen= false;
                    });


                }else{
                    $scope.isOpen= false;
                    $scope.expand = false;
                    console.log("cerrado ");
                    filesService.clear();
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

MyApp.service('App' ,['$timeout',function($timeout){

    var accion ={estado :false,value:{}};
    var msm ={};
    var seccion = undefined;

    var bindBloc = {
        estado:false,
        value:{}
    };
    return {

        setSeccion : function (data) {
            seccion= data;
        },
        getSeccion : function () {
            return seccion;
        },
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
        },
        getBlock: bindBloc.block,
        getLevel: bindBloc.level,
        setBlock: function(data){
            bindBloc.estado=true;
            bindBloc.value=data;
            $timeout(function () {
                bindBloc.estado=false;
            },0);

        },
        getBindBloc: function(){
            return bindBloc;
        }

    }


}]);

MyApp.service('filesService' ,function(Upload){
    var all = [];
    var accion ={estado:false,data:{}};
    var isOpen= false;
    var titulo ="Adjuntos";
    var folder ="";
    var progress = "";
    var process = {
        total : 0 ,
        terminados: [],
        estado:'wait'
    };
    var allowUpload = {val:false};
    return {
        setFiles: function(data){
            all.splice(0,all.length);
            angular.forEach(data, function(v){
                all.push(v);
            });

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
        },
        clear : function(){
            all.splice(0,all.length);
            titulo ="Adjuntos";


        },
        Upload :function (data){
            var send= {url:"master/files/upload", data:{ folder:folder, file:data.file}};

            console.log("data", data);
            console.log("send", send);

            Upload.upload(send).progress( !(data.progress) ? function(){} : data.progress)
                .success(!(data.success) ? function(){} : data.success)
                .error(!(data.error) ? function(){} : data.error);


        },
        getProgress : function(){
            return progress;
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

MyApp.service('ExtRedirect' , function($http){
    var model  ;

    return {
        load: function (fn) {
            /*$http.get("External/Get").success(function (response) {
             data= response;
             if(fn){
             fn(response);
             }
             });*/
        },
        set: function (redirect) {
            model = redirect;
            /*$http.get("External/Get").success(function (response) {
             data= response;
             if(fn){
             fn(response);
             }
             });*/
        },
        del : function(fn){
            /* $http.get("External/Del").success(function (response) {
             data =null;
             if(fn){
             fn(response);
             }
             });*/
        }, get: function () {
            return model;
        }
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
                aux=text.substring(0, 10).replace("-","/");
            }
            return new Date(Date.parse(aux));
        }

    };
    this.plusDays =  function (compare, plus) {
        if(compare){
            return   new Date(compare.getFullYear(),
                compare.getMonth(),
                compare.getDate()+ plus,
                compare.getHours(),
                compare.getMinutes(),
                compare.getSeconds()
            )
        }
    }
});
/*
 MyApp.service('DateParse', function() {
 var todate = function (text) {
 var aux= text;
 if(typeof (text) != 'undefined'){
 if(text.length >= 10){
 aux=text.substring(0, 10).replace("-","/");
 }
 return new Date(Date.parse(aux));
 };
 return {
 toDate : todate,
 plusDays : function (compare, plus) {
 if(compare){
 return   new Date(compare.getFullYear(),
 compare.getMonth(),
 compare.getDate()+ plus,
 compare.getHours(),
 compare.getMinutes(),
 compare.getSeconds()
 );
 }

 }
 }
 }

 });
 */
MyApp.constant('SYSTEM',{
    ROOT:"http://"+window.location.hostname,
    BASE:"/"+window.location.pathname.split("/")[1]+"/",
    PATHAPP : "http://"+window.location.hostname+"/"+window.location.pathname.split("/")[1]+"/",
    noti_autohidden :3000
});






