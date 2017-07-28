/**
 * Created by miguel on 01/12/2016.
 */
/*************************  e-mail *******************************/

/**
 * directiva que genera preciew rederizado de un string html editable
 * */
MyApp.directive('vldhtmlPreview', function() {

    return {
        controller:'vldChtmlPreview',
        replace: true,
        scope:{
            'origenes' : "=load",
            'centerText' : "=?text",
            'title' : "=?title",
            'options' : "=?optionId",
            'template' : "=?template",
            'langs' : "=?langs",
            'lang' : "=?lang",
            'contacts': "=?contacts",
            'asuntos': "=?asuntos",
            'asunto': "=?asunto",
            'funciones' : "=?funciones",
            'state' : "=?state"
        },
        transclude: true,
        link: function(scope, elem, attr, ctrl){},
        templateUrl: function(elem, attr){
            return 'modules/directives/htmlPreview';
        }
    };
});
MyApp.controller('vldChtmlPreview',['$scope','$timeout','$sce','setNotif',function($scope,$timeout, $sce,setNotif){

    $scope.changes= {trace:[], index:0};
    $scope.state = 'wait';
    $scope.prf= undefined;
    $scope.funciones = {
        clear: function () {
            $scope.changes.trace.splice(0, $scope.changes.trace.length);$scope.changes.index=0;
            $scope.state = 'wait';

        }
    };

    $scope.load = function (key) {
        $scope.state = 'loading';
        $scope.centerText= 'cargando';
    };

    $scope.selectLang = function (id) {

        if(id != $scope.select){
            if($scope.contacts && $scope.contacts.length > 0){
                if( !$scope.reviewContact(id)){
                    setNotif.addNotif("alert", 'Segun nuestros datos '+$scope.error.nombre +" no habla este idioma ¿estas seguro de selecionar el idioma ?" ,

                        [
                            {name:"Si, estoy seguro", action :function () {
                                $scope.confirmChange(id);
                            }},
                            {name:"Cancelar ", action :function () {

                            }}
                        ]
                        ,{});
                }else{
                    $scope.confirmChange(id);
                }
            }else{
                $scope.confirmChange(id);
            }

        }
    };

    $scope.reviewContact = function (id) {
        var paso = true;
        $scope.error = undefined;
        angular.forEach($scope.contacts, function (v, k) {
            if(v.langs  && v.langs.length > 0){
                paso=false;

                angular.forEach(v.langs, function (lang) {

                    if(lang == id){
                        paso=true;
                    }
                });
                if(!paso){
                    $scope.error = v;
                    return false ;
                }

            }
        });
        return paso;
    };


    $scope.confirmChange = function (id) {
        if($scope.changes.index > 0){
            setNotif.addNotif("alert","!Perderas los cambios! ¿Estas seguro de cambiar la plantilla?",
                [
                    {
                        name:"Si, estoy seguro", action: function () {
                        $scope.changeLang(id);
                    }
                    },{
                    name:"Cancelar", action: function () {

                    }
                }
                ]
                ,{block:true});
        }else{
            $scope.changeLang (id);
        }
    };
    $scope.changeLang = function (id) {
        $scope.lang = id;
        $scope.template= '<div></div>';
        $scope.centerText= '';
        $scope.template= $sce.trustAsHtml(angular.copy($scope.origenes[id].body));
        $scope.state = 'load';
        $scope.changes= {trace:[], index:0};
        if($scope.asuntos && $scope.origenes[id].subjets && $scope.origenes[id].subjets.length > 0){
            $scope.asuntos.splice(0, $scope.asuntos.length);
            angular.forEach($scope.origenes[id].subjets, function (v, k) {
                $scope.asuntos.push(v);
            });
            $scope.asunto =  $scope.asuntos[0];
            setNotif.addNotif("info", "Se ha actualizado la lista de asuntos disponibles, por favor revisala y recuerda siempre se debe escribir el asunto en el idioma selecionado",[], {autohidden:5000})
            $scope.select= id;
        }

    };

    $scope.change = function (e) {
        var el = angular.element(e.currentTarget);
        var k =  el.attr('id');
        $scope.isChange = true;
        if(  $scope.options && $scope.options[k] && $scope.options[k].change){
            $scope.options[k] && $scope.options[k].change(e);
        }

    };

    $scope.blur = function (e) {
        var el = angular.element(e.currentTarget);
        if(el.is('[contenteditable="true"]')){
            var n = {ele:el[0],value: el[0].innerText};
            if(!angular.equals(n,$scope.changes.trace[$scope.changes.index])){
                $scope.changes.trace[$scope.changes.index] = n;
                $scope.changes.index ++;
            }
        }

    };

    $scope.listener = function (e) {
        var el = angular.element(e.target);
        if(el.is('[contenteditable="true"]')){
            if( !el.attr('bind')){
                el.bind("keydown", $scope.change);
                el.bind("blur", $scope.blur);
                el.attr('bind', true);
                var n = {ele:el[0],value: el[0].innerText};
                if(!angular.equals(n,$scope.changes.trace[$scope.changes.index])){

                    $scope.changes.trace[$scope.changes.index] = n;
                    $scope.changes.index ++;
                }
            }
        }
    };

    $scope.back = function () {
        $timeout(function () {
            if( $scope.changes.index > 0){

                $scope.changes.index = $scope.changes.index  - 1;
                var el = $scope.changes.trace[$scope.changes.index].ele;
                el.innerText =  $scope.changes.trace[$scope.changes.index].value;
            }
        },10);
    }
    $scope.next = function () {
        $timeout(function () {
            if($scope.changes.trace.length > 0 && $scope.changes.trace[$scope.changes.index + 1 ] && (($scope.changes.index + 1 ) <= $scope.changes.trace.length) ){

                var el = $scope.changes.trace[$scope.changes.index + 1 ].ele;
                el.innerText =  $scope.changes.trace[$scope.changes.index + 1 ].value;
                $scope.changes.index++;
            }
        },10);
    }

    $scope.$watchCollection(
        "langs",
        function( newValue, oldValue ) {
            //console.log(newValue);
            if(newValue){
                var prf =undefined;
                var mayor =  -1;
                var fallidos = [];
                angular.forEach(newValue, function (v, k) {
                    if(!$scope.origenes[k]){
                        fallidos.push(k);
                    }else{
                        if(v > mayor){
                            mayor = v;
                            prf = k;
                        }
                    }

                });
                $scope.prf  = prf;
                $scope.selectLang(prf);
            }
        }
    );
}]) ;

/**
 * crear los campos to , cc,ccb de envio de correos
 * */
MyApp.directive('vldhMailContacts', function() {

    return {
        controller:'vldCMailContacts',
        replace: true,
        scope:{
            'to' : "=?to",
            'cc' : "=?cc",
            'ccb' : "=?ccb",
            'noNew': "=?noNew",
            'correos' : "=?correos",
            'out' : "=?senders",
            'asuntos' : "=?asuntos",
            'asunto' : "=?asunto",
            'addlangs' : "=?langs",
            'funciones' : "=?funciones",
            'lang' : "=?lang"

        },
        transclude: true,
        link: function(scope, elem, attr, ctrl){},
        templateUrl: function(elem, attr){
            return 'modules/directives/mailContacts';
        }
    };
});
MyApp.controller('vldCMailContacts',['$scope','$timeout','$filter','IsEmail','setNotif',function($scope,$timeout,$filter, IsEmail,setNotif){


    $scope.destinos = [];
    $scope.addlangs = {};
    $scope.funciones = {

        clear: function () {
            $scope.subject = undefined;
            $scope.asunto = undefined;
            if($scope.to){
                $scope.to.splice(0,$scope.to.length);
            }
            if($scope.cc){
                $scope.cc.splice(0,$scope.cc.length);
            }
            if($scope.ccb){
                $scope.ccb.splice(0,$scope.ccb.length);
            }
        }
    };

    if(!$scope.asuntos){
        $scope.asuntos = [];
    }






    $scope.all  = function () {
        if(!$scope.correos){
            return [];
        }
        return $filter("customFind")($scope.correos,{} ,
            function(c,cp){
                return  $scope.destinos.indexOf(c.correo) == -1;
            });
    };
    $scope.isAddMail = function(val){
        return  $scope.destinos.indexOf(val.correo) === -1;
    };
    if(!$scope.asuntos){
        $scope.asuntos = [];
    }
    $scope.transformChip = function(chip) {

        if (angular.isObject(chip) && $scope.destinos.indexOf(chip.correo) === -1) {
            return chip;
        }
        if(IsEmail(chip)!= null &&  $scope.isAddMail({correo:chip})){
            if( !$scope.noNew){
                return {nombre:chip,correo:chip,lang:[]};
            }else{
                setNotif.addNotif("error","No se admite la agregacion de nuevos destinatario",[], {autohidden:2000})
            }

        }
        return null;
    };
    $scope.addEmail = function(chip, tipo){
        chip.tipo= tipo;
        if($scope.lang){
            $scope.reviewContact(chip, tipo);
        }
        $timeout(function () {
            $scope.$apply();
        },20);
    };

    $scope.reviewContact = function (chip, tipo) {
        var paso = true;
        if(chip.langs && chip.langs.length > 0){
            paso= false;
            angular.forEach(chip.langs, function (v, k) {
                if (v == $scope.lang){
                    paso= true;
                }
            });
        }

        if(!paso){
            setNotif.addNotif("alert", "Segun nuestra informacion "+ chip.nombre+" no habla el idioma selecionado ¿Esta seguro de agregarlo?",
                [
                    {name:"Si, estoy seguro", action: function(){

                    }},
                    {name:"Cancelar", action: function () {
                        var index = -1;
                        angular.forEach($scope[tipo], function (v, k) {
                            if(v.correo == chip.correo){
                                index  = k;
                            }
                        });
                        $scope[tipo].splice( index  , 1);
                        $scope.removeEmail(chip,tipo);

                    }

                    }
                ]
                ,{block:true})
        }
    };
    $scope.removeEmail = function(chip){
/*
        $scope.destinos.splice($scope.destinos.indexOf(chip.correo),1);
*/
        angular.forEach(chip.langs, function (v, k) {
            $scope.addlangs[v] -- ;
        });
    };


    $scope.$watch('to.length', function (newVall, oldVall) {
        if(newVall){
            if( newVall > 0 && newVall > oldVall  && $scope.addlangs){

                angular.forEach($scope.to[newVall - 1].langs, function (v, k) {
                    if( $scope.addlangs[v]){
                        $scope.addlangs[v] ++;
                    }else{
                        $scope.addlangs[v] = 1;
                    }

                });
            }
        }



    });
    $scope.$watch('cc.length', function (newVall, oldVall) {
        if(newVall){
            if( newVall > 0 && newVall > oldVall  && $scope.addlangs){
                angular.forEach($scope.to[newVall - 1].langs, function (v, k) {
                    if( $scope.addlangs[v]){
                        $scope.addlangs[v] ++;
                    }else{
                        $scope.addlangs[v] = 1;
                    }
                });
            }
        }
    });
    $scope.$watch('ccb.length', function (newVall, oldVall) {
        if(newVall){
            if( newVall > 0 && newVall > oldVall  && $scope.addlangs){
                angular.forEach($scope.to[newVall - 1].langs, function (v, k) {
                    if( $scope.addlangs[v]){
                        $scope.addlangs[v] ++;
                    }else{
                        $scope.addlangs[v] = 1;
                    }
                });
            }
        }
    });

    $scope.$watchGroup(['to.length', 'cc.length', 'ccb.length'], function (newVal, oldVal) {
        $scope.destinos.splice(0, $scope.destinos.length);
        if($scope.to){
            angular.forEach($scope.to, function (v, k) {
                $scope.destinos.push(v.correo);
            });
        }
        if($scope.cc){
            angular.forEach($scope.cc, function (v, k) {
                $scope.destinos.push(v.correo);
            });
        }
        if($scope.ccb){
            angular.forEach($scope.ccb, function (v, k) {
                $scope.destinos.push(v.correo);
            });
        }
    })
}]);

/**
 * combina  vldhtmlPreview con vldCMailContacts para generar un visisro de envio de correos

 * */
MyApp.directive('vldMailWithAdj', function() {

    return {
        controller:'vldCMailWithAdj',
        replace: true,
        scope:{
            'origenes' : "=load",
            'centerText' : "=?text",
            'title' : "=?title",
            'options' : "=?optionId",
            'template' : "=?template",
            'langs' : "=?langs",
            'lang' : "=?lang",
            'to': "=?to",
            'cc': "=?cc",
            'ccb': "=?ccb",
            'noNew': "=?noNew",
            'asuntos': "=?asuntos",
            'asunto': "=?asunto",
            'correos': "=?correos",
            'funciones': "=?funciones",
            'state' : "=?state",
            //adjuntos
            'adjs' : "=upModel",
            'fileUp' : "=fnFileUp",
            'finish' : "=fnUpWatch",
            'loadeds' : "=?loaded",
        },
        transclude: true,
        link: function(scope, elem, attr, ctrl){
            scope.title  =  (attr.titulo) ? attr.titulo : 'Correo';


        },
        template: function(elem, attr){
            return '<div layout ="column" flex>' +
                    '<div  layout="row"  layout-align="start center" style="    height: 32px;color: rgb(92,183,235);border-bottom: solid 1.5px;  margin-left: 4px;   padding-left: 4px;">' +
                '<div flex style="margin-top : 8px;">{{title}} </div>' +
                ' <div style="width: 24px;" layout="column" layout-align="center center" ng-click="(mode == \'list\') ? mode = \'adjs\' : mode = \'list\' ">' +
                    ' <img ng-src="{{(mode == \'list\') ? \'images/adjunto.png\' : \'images/listado.png\'}}"> </div> ' +
                '</div>'+
                '<div    layout ="column" flex >' +
                ' <vldh-mail-contacts correos="correos" funciones="fnContacts" senders="contacts" to="to" cc="cc" ccb="ccb"  langs="langs" no-new="noNew" lang="lang"  asuntos="asuntos" asunto="asunto"> </vldh-mail-contacts>' +
                ' <vldhtml-preview load="origenes" funciones="fnPreview" state="state"  template="template" contacts="contacts" langs="langs" text="centerText" lang="lang"  ng-show="mode == \'list\'"  asuntos="asuntos"  asunto="asunto"  ></vldhtml-preview>' +
                ' <vld-file-up-img  loaded="loadeds" ng-show="mode != \'list\'" up-model="adjs"  key="'+attr.key+'"  storage="'+attr.storage+'" fn-file-up="fileUp" fn-up-watch="finish" ></vld-file-up-img>' +
            ' </div>' +
                '</div>';
        }
    };
});

MyApp.controller('vldCMailWithAdj',['$scope','$timeout',function($scope, $timeout){
    $scope.mode ='list';
    $scope.funciones = {
        clear: function () {
            $scope.fnContacts.clear();
            $scope.fnPreview.clear();
            $scope.loadeds.splice(0, $scope.loadeds.length);
        }
    };
    $timeout(function () {
        if(!$scope.contacts){
            $scope.contacts=  [];
        }
        if(!$scope.asuntos){
            $scope.asuntos=  [];
        }
    },100);
    }
    ]
);

/**
 * sube archivos al sevidor y muestra el  preview y barra de carga
 *
 * */
MyApp.directive('vldFileUpImg', function() {

    return {
        controller:'vldCFileUpImg',
        replace: true,
        scope:{
            'adjs' : "=upModel",
            'key' : "=key",
            'fileUp' : "=fnFileUp",
            'finish' : "=fnUpWatch",
            'loadeds' : "=?loaded",
            'noUp' : "=?noUp",
            'funciones': "=?funciones",
        },
        transclude: true,
        link: function(scope, elem, attr, ctrl){
            scope.storage = attr.storage;
            scope.key = attr.key;
        },
        templateUrl: function(elem, attr){
            return 'modules/directives/fileUpImg';
        }
    };
});
MyApp.controller('vldCFileUpImg',['$scope','$timeout', 'setNotif', 'fileSrv',function($scope,$timeout, setNotif, fileSrv ){
    $scope.bindFiles = fileSrv.bin();
    $timeout(function () {
        if(!$scope.loadeds){
            $scope.loadeds = [];
        }if(!$scope.adjs){
            $scope.adjs = [];
        }

    },1000);

    $scope.funciones = {};
    $scope.$watch('adjs.length', function(newValue){
        if(newValue > 0 ){
            if(!$scope.noUp){
                fileSrv.storage($scope.storage);
                fileSrv.setKey($scope.key);
                angular.forEach(fileSrv.upload($scope.adjs), function (v, k) {
                    $scope.loadeds.push(v);
                });
            }else{
                setNotif.addNotif("error", "Disculpe pero no se permite agregar nuevos archivos ",[], {autohidden:3000})
            }

        }
    });
    $scope.$watch('bindFiles.estado', function (newVal,oldVal) {
        if(fileSrv.getKey() == $scope.key && $scope.finish){
            $scope.finish(newVal,oldVal, fileSrv.get());
        }
    });
}]);

/**
 * Dibuja la minatura de subida de archivos*/
MyApp.directive('vlThumb', function( fileSrv) {
    return {
        replace: true,
        transclude: true,
        scope:{
            'model' : "=ngModel",
            'up' : "=vlUp",
            /*'fail' : "=vlFail",
             'progress' : "=vlLoad"*/
        },
        link: function(scope, elem, attr, ctrl){
            scope.$watch('model.state', function (newVal,oldVal) {
                if(newVal == 'up'){
                    delete scope.model.up;
                    if( scope.up){
                        scope.up(scope.model);
                    }
                }
                if(newVal == 'fail'){
                    scope.model.fail = true;
                    /*if(scope.fail){
                     scope.model
                     //scope.fail(scope.model);
                     }*/
                }
            });
            scope.reinten = function (item) {
                fileSrv.upFile(item);
            }
        },
        template: function () {

            return '<div layout="column"  layout-align="center center" style="background-color: rgba(88, 181, 234,{{( model.up)/100}}); height: 100%">'  +
                '<img ng-src="images/thumbs/{{model.thumb}}"/>' +
                ' <div style="position: absolute; vertical-align: middle;" ng-show="model.up && !model.fail">{{model.up}}%</div> ' +
                ' <div style="position: absolute; vertical-align: bottom; background-color: #0a6ebd;" ng-show="model.fail" ng-click="reinten(model)">fail</div> ' +
                '</div>'
        }
    };
});

/**
 * difunde el click en un evento
 * @param key un identificador para el consumo
 *
 * */
MyApp.directive('clickCommit', function(clickCommitSrv) {

    return {
        link: function(scope, elem, attr){
            elem.bind('click', function (e) {
                clickCommitSrv.commit(attr.key, scope, e);
            });
        }

    };
});
MyApp.service('clickCommitSrv', function() {
    var event = undefined;
    var scope = undefined;
    var key = '';
    var  bind = {state:false};
    var consume = false;
    return {
        bind: function () {
            return bind;
        },
        consume:function () {
            consume= true;
        },
        isConsume : function () {
            return consume;
        },
        commit: function (k,sp,e) {
            if( !bind.state ){
                key= k;
                scope= sp;
                event= e;
                bind.state=true;
                consume= false;
            }

        },
        setState: function (data) {
            bind.state=data;
        },
        get: function () {
            return {event:event, scope:scope,commiter:key}
        }

    }
});


MyApp.service('formPreviewSrv',function(){
    var commons = {
        crit:[],
        isShow:[],
        formFilters:[],
        watchers:{}
    };
    return {
        getCrits:function(){
            return commons.crit;
        },
        getShows:function(){
            return commons.isShow;
        },
        getFilters:function(){
            return commons.formFilters;
        },
        getWatchers:function(){
            return commons.watchers;
        }
    }
});
//directive with controller for draw Criterios FORM (productos and Criterios)
MyApp.directive('formPreview', function() {
    return {
        controller:function($scope,$filter,$timeout,formPreviewSrv){
            $scope.crit = formPreviewSrv.getCrits();
            $scope.isShow = formPreviewSrv.getShows();
            $scope.formFilters = formPreviewSrv.getFilters();
            $scope.watchers = formPreviewSrv.getWatchers();
            var validators = {};

            function clearWatchers(line){
                $scope.watchers[line].forEach(function(v,k){
                    v();
                    if(k==$scope.watchers[line].length-1){
                        delete $scope.watchers[line];
                    }
                })
            }
            $scope.createModel = function(field){

                if(!field.id){
                    return false;
                }

                $scope.crit[''+field.id] = {
                    value :null,
                    childs:[]
                };
                if(field.value != null){
                    $scope.crit[''+field.id].value =(("multi" in field.options) && field.options.multi[0].pivot.value==1)?field.value.split(">>"):(parseInt(field.value)==field.value)?parseInt(field.value):field.value;
                }
                $scope.isShow[field.id] = true;
                $scope.formFilters[field.id] = [];

                if(!(field.linea_id in $scope.watchers)){
                    if(Object.keys($scope.watchers).length>0){
                        clearWatchers(Object.keys($scope.watchers)[0]);
                    }
                    $scope.watchers[field.linea_id]=[];
                }
                for(i=0;i<field.deps.length;i++){
                    var key = $scope.$eval("crit["+field.deps[i].lct_id+"]");
                        if(key)key.childs.push(field.deps[i]);
                    if($filter("customFind")($scope.$$watchers,"crit["+field.deps[i].lct_id+"]",function(a,b){ return a.exp == b;}).length==0){


                        $scope.watchers[field.linea_id].push($scope.$watchCollection("crit["+field.deps[i].lct_id+"]",function(n,o){
                            isShow(n);
                        }));
                    }


                }
            };
            var isShow = function(val){

                if(!val || !("childs" in  val)){
                    return false;
                }
                angular.forEach(val.childs,function(dep,k){
                    var ret = eval(dep.accion);
                    switch (dep.operador){
                        case "=":
                            if(typeof(ret) == "boolean"){
                                $scope.isShow[dep.sub_lct_id] = (val.value == dep.valor)?ret:!ret;

                            }else{
                                $scope.formFilters[dep.sub_lct_id] = (val.value == dep.valor)?ret:[];
                            }

                            break;
                        case ">":
                            if(typeof(ret) == "boolean"){
                                $scope.isShow[dep.sub_lct_id] = (val.value > parseFloat(dep.valor))?ret:!ret;
                            }else{
                                $scope.formFilters[dep.sub_lct_id] = (val.value > dep.valor)?ret:[];
                            }
                            break;
                        case "<":
                            if(typeof(ret) == "boolean"){
                                $scope.isShow[dep.sub_lct_id] = (val.value < parseFloat(dep.valor))?ret:!ret;
                            }else{
                                $scope.formFilters[dep.sub_lct_id] = (val.value < dep.valor)?ret:[];
                            }
                            break;
                        case "!=":
                            if(typeof(ret) == "boolean"){
                                $scope.isShow[dep.sub_lct_id] = (val.value != dep.valor)?ret:!ret;
                            }else{
                                $scope.formFilters[dep.sub_lct_id] = (val.value != dep.valor)?ret:[];
                            }
                            break;
                    }



                });
                //return show;
            };
        },
        templateUrl: function(elem, attr) {
            return 'modules/criterios/textForm';
        }
    };
});


MyApp.service('masterSrv',function(masters){
    var providers = masters.query({type:'allProviders'});
    var lines = masters.query({ type:"prodLines"});
    var buyUnit = masters.query({ type:"getUnitsCompras"});
    return {
        getProvs:function(){
            return providers
        },
        getLines:function(){
            return lines;
        },
        getBuyUnits:function(){
            return buyUnit;
        },
        getFilters:function(){
            return commons.formFilters;
        }
    }
});

MyApp.directive('critModel', function(formPreviewSrv) {
    return {
        link: function(scope, elem, attr){
            scope[attr.critModel] = formPreviewSrv.getCrits();

        }

    };
});


/*directiva lmb-collection,*/
MyApp.directive('lmbCollection', function() {

    return {
        replace: true,
        transclude: true,
        require: '?ngModel',
        scope: {
            itens: '=lmbItens',
            model: '=lmbModel',
            label: '=lmbLabel',
            valid: '=?valid',
            filtSearch: '=?filtparm1',
            filtSecond: '=?filtparm2',
            dis: '=?ngDisabled'
        },
        controller:function($scope){

            $scope.curVal = {};
            if(!("valid" in $scope)){
                $scope.valid = {
                    f:function(){return true},
                    c:function(){return true},
                }
            }
            $scope.setIten=function(dat){
                $scope.curVal = dat;
                if($scope.valid.f(dat)){
                    done()
                }else{
                    $scope.valid.c(done)
                }
            };

            var done = function(){
                var dat = $scope.curVal;
                if($scope.multi){
                    //console.log($scope.model)
                    if(typeof($scope.model) !='object' || $scope.model==null){

                        $scope.model = [];
                    }

                    if($scope.model.indexOf(eval("dat."+$scope.key)) != -1 || $scope.model.indexOf(eval("dat."+$scope.key)+"") !== -1){
                        idx = ($scope.model.indexOf(eval("dat."+$scope.key))!=-1)?$scope.model.indexOf(eval("dat."+$scope.key)):$scope.model.indexOf(eval("dat."+$scope.key)+"");
                        $scope.model.splice(idx,1);
                    }else{
                        $scope.model.push(eval("dat."+$scope.key));
                    }

                }else{
                    $scope.model = eval("dat."+$scope.key);
                }

                if($scope.prntFrm){
                    $scope.prntFrm.$setDirty();
                }

                if($scope.also){
                    $scope.$eval($scope.also);
                }
            };



            $scope.exist = function(dat){
                if($scope.multi){
                   /* if(typeof($scope.model)!="array"){
                        $scope.model = new Array($scope.model);

                    }*/
                    if($scope.model){
                        return $scope.model.indexOf(eval("dat."+$scope.key)) !== -1 || $scope.model.indexOf(eval("dat."+$scope.key)+"") !== -1;
                    }

                }else{
                    return $scope.model == eval("dat."+$scope.key);
                }

            };

        },
        link:function(scope,elem,attr,model){
            //console.log(attr)
            scope.ident = attr;
            //scope.multi = ('multiple' in attr);
            scope.key = ('lmbKey' in attr)?attr.lmbKey:'id';
            scope.also = ('lmbAlso' in attr)?attr.lmbAlso:false;
            scope.prntFrm = false;
            if((elem.parents("form").length>0)){
                var sup = scope.$parent;
                do{
                    if((elem.parents("form").attr("name") in sup)){
                        scope.prntFrm = sup[elem.parents("form").attr("name")];
                    }else{
                        sup = sup.$parent;
                    }
                }while(!scope.prntFrm)

            }
            attr.$observe('disabled', function (newValue) {
                if(newValue){
                    elem.css("color","#f1f1f1");
                }else{
                    elem.css("color","#000");
                }
            });
            attr.$observe('multiple', function (newValue) {
                //console.log("multi",scope.$eval(newValue));
                if(newValue || ("multiple" in attr)){
                    scope.multi = scope.$eval(newValue);
                }else{
                    scope.multi = false;
                }
            });
        },
        template: function(elem,attr){
            /*define que campo del json se va a mostrar en los item,
             por defecto "descripcion" a menos que se especifiq otra cosa con lmb-display*/
            var show = "descripcion"
            if("lmbDisplay" in attr){
                show = attr.lmbDisplay;
            }

            /*transclude es una variable que almacena en estring atributos pasados que se copiaran a cada item creado,
             los atributos deben especificarse con lmba-[nombre del tributo] ej. lmba-NG-CLASS*/
            transclude = ""
            angular.forEach(attr,function(v,k){
                if(k.indexOf("lmba")!=-1){
                    transclude+=' '+(k.replace("lmba","").replace(/\W+/g, '-')
                            .replace(/([a-z\d])([A-Z])/g, '$1-$2'))+'="'+v+'"'
                }
            });

            /*lmbFilter se usa para pasar un filtro para el atributo items, debe ser pasado etal como si se usa normal desps del |
             ej: filterSearch : [ids]
             */
            var filt = "";
            if("lmbFilter" in attr){
                filtPart = attr.lmbFilter.split(":");
                filt = " | "+filtPart[0].trim()+" : filtSearch ";
                delete attr.lmbFilter;
                elem.removeAttr("lmb-filter")
                attr.filtparm1 = filtPart[1];
                if(filtPart[2]){
                    filt+=":filtSecond ";
                    attr.filtparm2 = filtPart[2];
                }
            }
            /*si se especifica un valor en lmb-icon este sera usado como icono junto al texto de lmb-display
             * el icono debe estar en formato .png*/
            var iconField = "item."+attr.lmbIcon || "";
            if(attr.lmbType=="items"){
                return '<div>' +
                    '<div flex layout="column">' +
                    '<div style="height:10px; font-size: 10px; color:rgba(0,0,0,0.54); font-weight:bold; text-transform: uppercase">{{label}}</div>' +
                    '<div style="height:27px;margin-top: 3px" layout="row">' +
                    '<div ng-repeat="item in itens'+filt+'" ng-click="(!dis)?setIten(item):false" '+transclude+' ng-class="{\'field-sel\':exist(item)}" class="rad-button" flex layout="row" layout-align="center center">' +
                    '<md-tooltip>{{item.'+show+'}}</md-tooltip>' +
                    '<div ng-if="item.icon" layout="column" layout-align="center center" class="{{item.icon}}">' +
                    '<img ng-if="item.icon.indexOf(\'.png\')!=-1" ng-src="images/{{item.icon}}"/>' +
                    '</div>' +
                    '<span>{{item.'+show+'}}</span>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }else{
                return '<md-content flex layout="column">'+
                    '<div layout="row" ng-repeat="item in itens'+filt+'" class="row" ng-click="(!dis)?setIten(item):false" '+transclude+' ng-class="{\'field-sel\':exist(item)}" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc"> <div flex>{{item.'+show+'}}</div><div ng-show="'+iconField+' != \'\'" flex><img ng-src="images/{{'+iconField+'}}"/></div> </div>'

                    +'</md-content>';
            }


        }

    };
});

/*servicio y directiva de los pop-up*/
MyApp.service("popUpService",function($mdSidenav,$interval){
    var actives = [];
    sv = this;
    var closer = function(sideNav,fn,idx){
        $mdSidenav(sideNav).close();
        actives.splice(idx,1);
        if(fn.after){
            fn.after();
        }
    };

    var close = function(sv,sideNav,fn){

        idx = sv.exist(sideNav);

        if(idx != -1){
            if(fn.before){

                pre= fn.before();
            }else{
                pre = true;
            }


            if(!pre){
                return false;
            }
            else if(typeof(pre) == "object" && 'wait' in pre){
                var x = $interval(function(){
                    if(pre.wait===true){
                        $interval.cancel(x);
                        //console.log(serviceRefer,sv )
                        closer(sideNav,fn,idx);
                    }else if(pre.wait===false){
                        $interval.cancel(x);
                        return false;
                    }
                },1000)
            }else{
                closer(sideNav,fn,idx);
            }

        };
    };
    return {
        exist : function(name){

            return actives.indexOf(name);
        },
        remove : function(idx){
            actives.splice(idx,1);
        },
        add:function(name){
            actives.push(name);
        },
        popUpOpen:function(datos){

            var sideNav = Object.keys(datos)[0];
            var fn = datos[sideNav];

            if(this.exist(sideNav)==-1){
                if(fn && fn.before){
                    pre = fn.before();
                }else{
                    pre = true;
                }

                if(!pre){
                    return false;
                }
                var serv = this;
                $mdSidenav(sideNav).open();
                serv.add(sideNav);
                if(fn && fn.after){
                    fn.after();
                }
            }else{
                console.info("el sidenav ya se encuentra abierto",actives)
            }

        },
        popUpClose:function(obj){
            var side = Object.keys(obj)[0];
            //console.log(obj,side,Object.keys(obj))
            close(this,side,obj[side]);
        }
    }
})
MyApp.directive('popUpOpen', function(popUpService,$mdSidenav) {

    return {
        scope:{
            side:"=popUpOpen"
        },
        link:function(scope,object,attr){
            scope.open = function(){

                var sideNav = Object.keys(scope.side)[0];
                var fn = scope.side[sideNav];

                if(popUpService.exist(sideNav)==-1){
                    if(fn && fn.before){
                        pre = fn.before();
                    }else{
                        pre = true;
                    }

                    if(!pre){
                        return false;
                    }
                    $mdSidenav(sideNav).open().then(function(){
                        popUpService.add(sideNav);
                        if(fn && fn.after){
                            fn.after();
                        }
                    })
                }

            };
            object.bind("click",function(){
                scope.open();
            })

        }
    };
})//GLOBAL
    .directive('autoClose',function(popUpService,$mdSidenav,$compile,$interval){
        return {
            terminal: true, //this setting is important, see explanation below
            priority: 1000, //this setting is important, see explanation below

            link:function(scope,object,attr){
                scope.fn = scope.$eval(attr.autoClose);
                scope.sideNav = object.parents("md-sidenav").first().attr("md-component-id");

                /* scope.close = function(){
                 x[scope.sideNav] = scope.fn;
                 popUpService.popUpClose(x);
                 }*/
                scope.closer = function(idx){
                    popUpService.remove(idx)
                    $mdSidenav(scope.sideNav).close().then(function(){
                        ;
                        if(scope.fn.after){
                            scope.fn.after();
                        }
                    });
                };
                scope.close = function(){

                    idx = popUpService.exist(scope.sideNav);

                    if(idx != -1){
                        if(scope.fn.before){
                            pre= scope.fn.before();
                        }else{
                            pre = true;
                        }


                        if(!pre){
                            return false;
                        }
                        else if(typeof(pre) == "object" && 'wait' in pre){
                            var x = $interval(function(){
                                if(pre.wait===true){
                                    $interval.cancel(x);
                                    scope.closer(idx);
                                }else if(pre.wait===false){
                                    $interval.cancel(x);
                                    return false;
                                }
                            },1000)
                        }else{
                            scope.closer(idx);
                        }

                    };
                };

                object.attr("click-out","close()")
                object.removeAttr("auto-close");
                $compile(object)(scope);
            },
        }
    });//GLOBAL

/*servicio y directiva que muestra la flechita de next, con los siguientes parametros
    valid=llama una funcion de validacion que condiciona la apricion ono de la flecha
    on-next= si se pasa una funcion la configura para ser llamada al  hacer click en le next,
            tambien se puede pasar un string que sea el nombre de un sidenav para abrilo
    on-error=si valid retorna false, y esta ocpion esta configurada, llamara a la funcion aqui especificada*/

MyApp.service("nxtService",function(){
    var cfg = {
        nxtFn : null,
        show : undefined
    };

    return {
        getCfg : function(){
            return cfg;
        }
    }
});//GLOBAL
MyApp.directive('showNext', function() {

    return {
        replace: true,
        transclude: true,
        scope:{
            nextFn:"=?onNext",
            nextValid:"=?valid",
            nextError:"=?onError"
        },
        controller:function($scope,$mdSidenav,nxtService,$timeout,Layers,setNotif){
            $scope.cfg = nxtService.getCfg();
            if(!("onNext" in  $scope)){
                $scope.onNext = ($scope.$parent)
            }
            if(!("nextValid" in  $scope)){
                $scope.nextValid = function(){return true};
            }/*else{
                console.log(typeof($scope.nextValid))
                if(!typeof($scope.nextValid)=="function"){
                    $scope.nextValid = function(){return $scope.eval($scope.nextValid)};
                }
            }*/

            $scope.$watch("cfg.show",function (status) {
                if(typeof(status)!="boolean" ){
                    return false;
                }
                if(status){
                    $mdSidenav("NEXT").open();
                }else{
                    $mdSidenav("NEXT").close()
                }
            });
            $scope.show = function(){

                if((typeof($scope.nextValid)=="function")?$scope.nextValid():$scope.nextValid){
                    $scope.cfg.show = true;
                    $scope.cfg.fn = $scope.nextFn;
                }else{
                    if(("nextError" in  $scope)){
                        (typeof($scope.nextError)=="function")?$scope.nextError():setNotif.addNotif("error",$scope.nextError,[],{autohidden:2000});
                        //$scope.nextValid = function(){return true};
                    }
                }
            }
        },
        template: '<div class="showNext" style="width: 16px; height: 100%;" ng-mouseover="show()"> </div>'
    };
});//GLOBAL

/*directiva que crea la flecha next y la asocia a los datos de showNext
para usarla es <next-row></next-row>
 */
MyApp.directive('nextRow', function() {

    return {

        scope:{

        },
        controller:function($scope,$mdSidenav,nxtService,Layers){
            $scope.LayersAction = Layers.setAccion;

            $scope.cfg = nxtService.getCfg();
            $scope.nxtAction = function(e){
                if(typeof($scope.cfg.fn) === "string"){
                    $scope.LayersAction({open:{name:$scope.cfg.fn}});
                }else{
                    $scope.cfg.fn();
                }

                $scope.hideNext();
            };
            $scope.hideNext = function(){
                $scope.cfg.show = false;
            }
        },
        template: '<md-sidenav style="z-index:100; margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url(\'images/btn_backBackground.png\');" layout="column" layout-align="center center" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="NEXT" ng-mouseleave="hideNext()">'+
        '<img src="images/btn_nextArrow.png" ng-click="nxtAction(\$event)"/>'+
        '</md-sidenav>'
    };
});//GLOBAL

MyApp.service("focusedService",function(){
    var cfg = {
        formName : null,
    };

    return {
        getCfg : function(){
            return cfg;
        }
    }
});

MyApp.directive('focused', function(focusedService) {

    return {
        link: function (scope, object, attr) {
            //console.log("bind")
            var x = focusedService.getCfg();

            angular.element(object).on("focus",'input',function(){
                if(x.formName != attr.name){
                    angular.element("[name='"+x.formName+"']").removeClass("focused");
                    angular.element(object).addClass("focused");
                    x.formName = attr.name;
                }
            })

        }
    }
});//GLOBAL










