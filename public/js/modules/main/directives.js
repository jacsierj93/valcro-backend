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
        $scope.centerText= 'Dibujando';
        $scope.template= $sce.trustAsHtml(angular.copy($scope.origenes[id].body));
        $scope.state = 'load';
        $scope.changes= {trace:[], index:0};
        if($scope.asuntos && $scope.origenes[id].subjets && $scope.origenes[id].subjets.length > 0){
            $scope.asuntos.splice(0, $scope.asuntos.length);
            angular.forEach($scope.origenes[id].subjets, function (v, k) {
                $scope.asuntos.push(v);
            });
            setNotif.addNotif("info", "Se ha actualizado la lista de asuntos disponibles, por favor revisala y recuerda siempre se debe escribir el asunto en el idioma selecionado",[], {autohidden:5000})
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
        if(IsEmail(chip)!= null &&  $scope.isAddMail({correo:chip}) ){
            return {nombre:chip,correo:chip,lang:[]};
        }
        return null;
    };
    $scope.addEmail = function(chip, tipo){
        chip.tipo= tipo;
/*
        $scope.destinos.push(chip.correo);
*/
        $scope.out.push(chip);
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
        $scope.out.splice($scope.out.indexOf(chip.correo),1);
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
            'asuntos': "=?asuntos",
            'asunto': "=?asunto",
            'correos': "=?correos",
            'funciones': "=?funciones",
            'state' : "=?state",
            //adjuntos
            'adjs' : "=upModel",
            'fileUp' : "=fnFileUp",
            'finish' : "=fnUpWatch",
            'upAdjs' : "=?loaded"

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
                ' <vldh-mail-contacts correos="correos" funciones="fnContacts" senders="contacts" to="to" cc="cc" ccb="ccb"  langs="langs"  lang="lang"  asuntos="asuntos" asunto="asunto"> </vldh-mail-contacts>' +
                ' <vldhtml-preview load="origenes" funciones="fnPreview"  template="template" contacts="contacts" langs="langs" text="centerText" lang="lang"  ng-show="mode == \'list\'"  asuntos="asuntos"  asunto="asunto"  ></vldhtml-preview>' +
                ' <vld-file-up-img  ng-show="mode != \'list\'" up-model="adjs"  key="'+attr.key+'"  storage="'+attr.storage+'" fn-file-up="fileUp" fn-up-watch="finish" ></vld-file-up-img>' +
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
            'loadeds' : "=?loaded"
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
MyApp.controller('vldCFileUpImg',['$scope','$timeout', 'fileSrv',function($scope,$timeout, fileSrv){
    $scope.bindFiles = fileSrv.bin();
    $timeout(function () {
        if(!$scope.loadeds){
            $scope.loadeds = [];
        }
    },1000);

    $scope.$watch('adjs.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage($scope.storage);
            fileSrv.setKey($scope.key);
            angular.forEach(fileSrv.upload($scope.adjs), function (v, k) {
                $scope.loadeds.push(v);
            });
        }
    });
    $scope.$watch('bindFiles.estado', function (newVal,oldVal) {
        if(fileSrv.getKey() == $scope.key && $scope.finish){

            $scope.finish(newVal,oldVal, fileSrv.get());
        }
    });
}]);

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

