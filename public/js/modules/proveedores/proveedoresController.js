//var proveedores = angular.module('proveedores', []);
//###########################################################################################3
//##############################REST service (factory)#############################################3
//###########################################################################################3


var defaultTime = 15;
MyApp.directive('iconGroup', function ($timeout) {
     return {
         link: function (scope, elem, attrs,ctrl) {
             elem.attr("tab-index","-1");
             elem.bind("keydown",function(e){
                 if(e.which=="39"){
                     var next = (angular.element(elem).next().length>0)?angular.element(elem).next():angular.element(elem).prevAll().last();
                     next[0].focus();
                 }else if(e.which=="37"){
                     var prev = (angular.element(elem).prev().length>0)?angular.element(elem).prev():angular.element(elem).nextAll().last();
                     prev[0].focus();
                 }
             });


         }
     };
 });
MyApp.factory('masters', ['$resource',
    function ($resource) {
        return $resource('master/:type/:id', {}, {
            query: {method: 'GET', params: {type: "",id:""}, isArray: true},
            post: {method: 'POST', params: {type: "",id:""}, isArray: false}
        });
    }
]);
MyApp.factory('providers', ['$resource',
    function ($resource) {
        return $resource('provider/:type/:id_prov', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id_prov:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);
MyApp.service("masterLists",function(masters) {
    var coins =[];
    var countries = [];
    var languaje = [];
    var typeDir = [];
    var provType = [];
    var provTypeSend = [];
    var prodLines = [];
    var ports = [];
    var commonCountry = [{"id" : 11,"cant" : 1},{"id" : 48,"cant" : 21},{"id" : 55,"cant" : 1},{"id" : 56,"cant" : 2},{"id" : 58,"cant" : 1},{"id" : 64,"cant" : 2},{"id" : 67,"cant" : 13},{"id" : 74,"cant" : 2},{"id" : 88,"cant" : 2},{"id" : 94,"cant" : 1},{"id" : 107,"cant" : 1},{"id" : 109,"cant" : 42},{"id" : 172,"cant" : 5},{"id" : 183,"cant" : 2},{"id" : 222,"cant" : 5},{"id" : 230,"cant" : 5},{"id" : 235,"cant" : 2}];
    return {
        setMain:function(){
            countries = masters.query({ type:"getCountries"});
            typeDir =  masters.query({ type:"addressType"});
            provType = masters.query({ type:"getProviderType"});
            provTypeSend = masters.query({ type:"getProviderTypeSend"});
            coins = masters.query({ type:"getCoins"});
            prodLines = masters.query({ type:"prodLines"});
            languaje = masters.query({type:"languajes"});
            ports = masters.query({type:"getPorts"});
        },
        getCountries:function(){
            return countries;
        },
        getTypeDir:function(){
            return typeDir;
        },
        getTypeProv:function(){
            return provType;
        },
        getSendTypeProv:function(){
            return provTypeSend;
        },
        getAllCoins:function(){
            return coins;
        },
        getLines : function(){
            return prodLines;
        },
        getLanguaje : function(){
            return languaje;
        },
        getPorts : function(){
            return ports;
        },
        getCommonCountry : function(){
            return commonCountry;
        }
    }
});
MyApp.service("listCoins",function(providers) {
    var selCoins =[];
    var coinIds = [];

    return {
        setProv:function(id_prov){

            if(id_prov) {
                selCoins = providers.query({type: "provCoins", id_prov: id_prov || 0});
                coinIds = providers.query({type: "listCoin", id_prov: id_prov || 0})
            }else{
                selCoins = [];
                coinIds = [];
            }
        },
        getCoins:function(){
            return selCoins;
        },
        addCoin:function(coin){
            selCoins.push(coin)
            coinIds.push(coin.id);
        },
        getIdCoins: function(){
            return coinIds;
        }
    }
});
MyApp.controller('AppCtrl', function ($scope,$mdSidenav,$http,setGetProv,masters,masterLists,setGetContac,setNotif,Layers,$timeout,$interval,saveForm) {
    $scope.expand = false;
    $scope.isSetting = setGetProv.isSetting();
    $scope.prov=setGetProv.getProv();
    $scope.chang = setGetProv.getChng();
    $scope.$watch('prov.id',function(nvo,old) {
        if(nvo && $scope.prov.new){
            $scope.prov.new = false;
            $scope.enabled = false;
            $scope.edit = true;
        }
    });


    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old){
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
    });


    $scope.checkLayer = function(compare){
        //console.log(compare);
        //return compare != $scope.layer;
    };

    $scope.data = {
        cb1: true
    };
    $scope.setProv = function(prov,indx){
        endProvider(chngProv,null,prov);
    };

    var interval = null;
    $scope.block=saveForm.isBlock();
    $scope.nextLayer = function(to,e){
        console.log(e)
       $timeout(function(){
           if(saveForm.isBlock()=="wait"){
               interval = $interval(function(){
                   if(saveForm.isBlock()=="go"){
                       $interval.cancel(interval);
                       saveForm.setBlock(false);
                       if(e.isTrigger){
                           stepLayer(to,e)
                       }
                       //
                   }else if(saveForm.isBlock()=="reject"){
                       $interval.cancel(interval);
                       saveForm.setBlock(false);
                       //$scope.block=false;
                   }
               },500)
           }else{
               stepLayer(to,e)
           }
       },500    )


    };

    var stepLayer = function(to,e){
        if(to!="END"){
            if(e.isTrigger){
                $scope.LayersAction({open:{name:to,after:function(){
                    angular.element("#"+to).find("form:has([step]:not([disabled]))").first().find("[step]:not([disabled])").first().focus().click();
                }}});
            }else{
                $scope.LayersAction({open:{name:to}});
            }
            
        }else{
            endProvider(noProv)
        }

        $scope.showNext(false);
    }

    var backLayer = function(){
        if($scope.index==1){
            endProvider(noProv);
        }else{
            $scope.LayersAction({close:true});
        }
    }


    $scope.prevLayer = function(){
        $timeout(function() {
            if (saveForm.isBlock() == "wait") {
                interval = $interval(function(){
                    if(saveForm.isBlock()=="go"){
                        $interval.cancel(interval);
                        saveForm.setBlock(false);
                        //backLayer();
                    }else if(saveForm.isBlock()=="reject"){
                        $interval.cancel(interval);
                        saveForm.setBlock(false);
                    }
                },500)
            }else{
                backLayer();
            }
        },500)


    };

    var chngProv = function(prov){


        setGetProv.cancelNew();
        $scope.edit = false;
        $scope.enabled = true;
        setGetProv.setProv(prov.item);
        if($scope.module.index>0){
            $scope.LayersAction({close:{first:true}});
        }else{
            $scope.LayersAction({open:{name:"layer0"}});
        }


        //openLayer("layer0");//modificado para mostrar resumen proveedor
    };

    var noProv = function(){
        $scope.LayersAction({close:{all:true}});
        setGetProv.cancelNew();
        $scope.edit = false;
        $scope.enabled = true;
        setGetProv.setProv(false);
    };

    $scope.addProv = function(){
        endProvider(newProv,null);
    };

    var endProvider = function(yes,not,id){
        if($scope.prov.id){
            $timeout(function(){
                not = not||null;
                id = id||null;
                if(setGetProv.haveChang()){
                    $scope.LayersAction({open:{name:"layer5"}});
                    setNotif.addNotif("alert", "ha realizado estos cambios en el proveedor. ¿son correctos?", [
                        {
                            name: "Estoy de acuerdo",
                            action: function () {
                                yes(id);
                            }
                        },
                        {
                            name: "Dejame Cambiarlos",
                            action: function () {
                            }
                        }
                    ]);
                }else{
                    yes(id);
                }
            },1000);
        }else{
            yes(id);
        }

    };



    var newProv = function(){
        $scope.LayersAction({close:{fisrt:true}});
        setGetProv.setProv(false);
        $scope.LayersAction({close:{all:true}});
        //closeLayer(true);
        $scope.edit = false;
        $scope.enabled = true;
        $scope.LayersAction({open:{name:"layer1",after:function(){
            angular.element("#provType").find("input").focus();
        }}});
       // $scope.openLayer("layer1","first");
        setGetProv.addToList({
            razon_social: "Nuevo Proveedor  ",
            contrapedido: 0,
            tipo_envio_id: 0,
            id: false,
            siglas:""
        });
       /* $timeout(function(){

        },100)*/

    };

    $scope.editProv = function(){
        $scope.edit = true;
        $scope.enabled =false;
        $scope.LayersAction({open:{name:"layer1"}});
    };

    $scope.showNext = function(status,to){
        if(status){
            $scope.nextLyr = to;
            $mdSidenav("NEXT").open()
        }else{
            $mdSidenav("NEXT").close()
        }
    };
    masterLists.setMain();
    setGetContac.setList();

    var activesPopUp = [];
    $scope.closePopUp = function(sideNav,fn){
        idx = activesPopUp.indexOf(sideNav);
        if(idx != -1){
            if(fn.before){
                pre = fn.before();
            }else{
                pre = true;
            }

            if(!pre){
                return false;
            }
            //after = fn.after || null;

            //console.log(idx);
            $mdSidenav(sideNav).close().then(function(){
                console.log("after")
                activesPopUp.splice(idx,1);
                if(fn.after){
                    fn.after();
                }
            });
            //console.log(activesPopUp);
        };
    };

    $scope.openPopUp = function(sideNav){
        if(activesPopUp.indexOf(sideNav)==-1){
            $mdSidenav(sideNav).open().then(function(){
                activesPopUp.push(sideNav);
            })
        }

    };
});
MyApp.controller('resumenProv', function ($scope,setGetProv,providers) {
    $scope.provider = setGetProv.getProv();
    $scope.prov = {tiemposP:[],tiemposT:[],direcciones:[]};
    $scope.$watch('provider.id',function(nvo){
        $scope.prov = setGetProv.getFullProv();
    })
});
MyApp.controller('provCoins', function ($scope,listCoins,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.coins = listCoins.getCoins();
    })


});
/*MyApp.run(['$route', function($route)  {
 $route.reload();
 }]);*/

MyApp.controller('ListProv', function ($scope,setGetProv,providers, $location, $anchorScroll,$timeout) {
    $scope.showLateralFilter = false;
    $scope.filterProv = {razon_social:"",contraped:null,aereo:null,maritimo:null};
    $scope.FilterLateral = function(){
        if(!$scope.showLateralFilter){
            jQuery("#menu").animate({height:"176px"},500);
            $scope.showLateralFilter=true;
        }else{
            jQuery("#menu").animate({height:jQuery("#menu").height()-176+"px"},500);
            $scope.showLateralFilter=false;
        }
    };
    $scope.togglecheck = function(e,lmbModel){
        if(e.keyCode==32 || e.type=="click"){
            $scope.filterProv[lmbModel] = ($scope.filterProv[lmbModel]=="0")?"1":"0";
        }
    };
    $scope.filterList = function(prov,filt){
        var valid = prov.razon_social.toLowerCase().indexOf(filt.razon_social.toLowerCase())!=-1;
        if(filt.contraped && valid){
            valid = prov.contrapedido == filt.contraped;
        }
        if(filt.aereo && valid){
            valid = prov.tipo_envio_id==1 || prov.tipo_envio_id==3
            valid = (filt.aereo==0)?!valid:valid;
        }
        if(filt.maritimo && valid){
            valid = prov.tipo_envio_id==2 || prov.tipo_envio_id==3
            valid = (filt.maritimo==0)?!valid:valid;
        }
        return valid;
    };

    setGetProv.setList( $scope.todos = providers.query({type:"provList"}));
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        newHash ='prov' + nvo;
    });
    $scope.$watch('todos.$promise.$$state.status',function(nvo){
        if(nvo==1){
            $timeout(function(){
                angular.element("#listado").focus();

            },0)

        }
    });


    $scope.scrollTo = function(newHash){
        if ($location.hash() !== newHash) {
            $location.hash(newHash);
        } else {
            $anchorScroll();
        }

    }


});

//###########################################################################################3
//###################Service Providers (comunication betwen controllers)###################3
//###########################################################################################3
MyApp.service("setGetProv",function($http,providers,$q){
    var prov = {id:false,type:"",description:"",siglas:"",envio:"",contraped:true,limCred:0,created:false};
    var fullProv = {};
    var itemsel = {};
    var list = {};
    var statusProv = {};
    var rollBack = {"dataProv":{},"dirProv":{},"valName":{},"contProv":{},"infoBank":{},"limCred":{},"payCond":{},"factConv":{},"point":{},"timeProd":{},"timeTrans":{},"provCoin":{},"priceList":{}};
    var changes =  {"dataProv":{},"dirProv":{},"valName":{},"contProv":{},"infoBank":{},"limCred":{},"payCond":{},"factConv":{},"point":{},"timeProd":{},"timeTrans":{},"provCoin":{},"priceList":{}};
    var onSet = {setting:false};
    return {
        getProv: function () {
            return prov;
        },
        setProv: function(index) {
            onSet.setting = true;
            rollBack = {"dataProv":{},"dirProv":{},"valName":{},"contProv":{},"infoBank":{},"limCred":{},"payCond":{},"factConv":{},"point":{},"timeProd":{},"timeTrans":{},"provCoin":{},"priceList":{}};
            changes.dataProv = {};changes.dirProv = {};changes.valName = {};changes.contProv = {};changes.infoBank={};changes.limCred={};changes.payCond={};changes.factConv={};changes.point={};changes.timeProd={};changes.timeTrans={};changes.provCoin={};changes.priceList={};
            if (index){
                itemsel = index;
                id = itemsel.id;
                providers.get({type:"getProv"},{id:id},function(data){
                    fullProv = data;
                    //console.log(fullProv);
                    prov.id = data.id;
                    prov.description = data.razon_social;
                    prov.siglas = data.siglas;
                    prov.type = data.tipo_id;
                    prov.envio = data.tipo_envio_id;
                    prov.contraped = (data.contrapedido==1)?true:false;
                    prov.created = false;
                    rollBack.dataProv[parseInt(prov.id)] = angular.copy(prov);
                    onSet.setting = false;
                });

            }else{
                fullProv = {};
                prov.id = false;prov.description = "";prov.siglas = "";prov.type = "";prov.envio = "";prov.contraped = false;prov.created =true;
                itemsel = {};
            }
        },
        updateItem: function(upd){
            itemsel.id = upd.id;
            itemsel.razon_social = upd.description;
            itemsel.limCred = upd.limCred;
            itemsel.contrapedido = upd.contraped;
            itemsel.tipo_envio_id= upd.envio;
        },
        setList : function(val){
            list = val;
        },
        addToList : function(elem){
            if(list[0].id){
                list.unshift(elem);
                itemsel = list[0];
            }
        },
        cancelNew : function(){
            if(!list[0].id){
                list.splice(0,1);
            }
        },
        seeList : function(){
            return list;
        },
        setComplete : function(field,value){
            statusProv[field]=value;
        },
        isSetting : function(){
            return onSet;
        },
        getFullProv : function(){
            return fullProv;
        },
        addToRllBck : function(val,form){
            //console.log(val)
            if(rollBack[form][parseInt(val.id)] === undefined){
                rollBack[form][parseInt(val.id)] = angular.copy(val);
            }
            //console.log(rollBack)
        },
        addChng : function(val,action,form){
            if((changes[form][parseInt(val.id)]===undefined) || !angular.equals(val,rollBack[form][parseInt(val.id)])){
                if(changes[form][parseInt(val.id)]){
                    changes[form][parseInt(val.id)].datos = angular.copy(val);
                    if(!(changes[form][parseInt(val.id)].action=="new" && action=="upd")){
                        changes[form][parseInt(val.id)].action = action;
                    }
                }else{
                    changes[form][parseInt(val.id)] = {
                        datos:angular.copy(val),
                        action:action
                    }
                }
            }else{
                delete changes[form][parseInt(val.id)];
            }
        },
        getChng : function(){
            return changes;
         },
        haveChang : function(){

            var i = 1;
            x = false;
            angular.forEach(changes,function(v,k){
                if(Object.keys(v).length>0){
                    x=true;
                }
            });
            return x;
        },
        getNomVal : function(){
            return fullProv.nomValc || [];
        },
        getAddress : function(){
            return fullProv.direcciones || [];
        },
        getContacts : function(){
            return fullProv.contacts || [];
        },
        getBanks : function(){
            return fullProv.banks || [];
        },
        getLimits : function(){
            return fullProv.limites || [];
        },
        getFactors : function(){
            return fullProv.factors || [];
        },
        getPoints : function(){
            return fullProv.points || [];
        },
        getProdTime : function(){
            return fullProv.prodTime || [];
        },
        getTransTime : function(){
            return fullProv.transTime || [];
        },
        getPayCond : function(){
            return fullProv.payCondition || [];
        },
        getListPrice : function(){
            return fullProv.listPrice || [];
        }

    };
});

/*function purgeJson (json){
  var exept = ["updated_at","created_at","deleted_at"];
  angular.forEach(json, function(value, key) {
  if(exept.indexOf(key)!==-1) {
  delete json[key];
  }else if(typeof value === 'object'){
  purgeJson (value);
  }
  });
  }
*/
//###########################################################################################3
//##############################FORM CONTROLLERS#############################################3
//###########################################################################################3
MyApp.controller('DataProvController', function ($scope,setGetProv,$mdToast,providers,$filter,setNotif,masterLists,$timeout) {
    $scope.id="DataProvController";
    $scope.inputSta = function(inp){
        $scope.toCheck = true;
    };
    $scope.onSet = setGetProv.isSetting

    $scope.filTipo = function(elem,text){
        return elem.nombre.toLowerCase().indexOf(text.toLowerCase()) != -1;
    };

    $scope.togglecheck = function(e){
        if(e.keyCode==32 || e.type=="click"){
            $scope.dtaPrv.contraped = !$scope.dtaPrv.contraped;
        }

        $scope.projectForm.$setDirty();
    };
    $scope.types = masterLists.getTypeProv();
    $scope.envios =masterLists.getSendTypeProv();

    $scope.prov = setGetProv.getProv();
    $scope.list = setGetProv.seeList();
    $scope.$watch('prov.id',function(nvo){
        $scope.localId = nvo;
        $scope.ctrl.typeProv = $filter("filterSearch")($scope.types,[$scope.prov.type])[0];
        $scope.ctrl.typeSend = $filter("filterSearch")($scope.envios,[$scope.prov.envio])[0];
    });
    $scope.ctrl = {typeProv:{id:""},typeSend:{id:""}};
    $scope.$watch("ctrl.typeProv.id",function(nvo){
        if(!$scope.projectForm.$pristine) {
            $scope.dtaPrv.type = nvo;
            $scope.projectForm.$setDirty();
        }
    });

    $scope.$watch("ctrl.typeSend.id",function(nvo){
        if(nvo==1 && $scope.projectForm.$dirty){
                setNotif.addNotif("alert","un proveedor, solo aereo es muy extraño... estas seguro?",[{name:"Si, si lo estoy",action:null,default:defaultTime},{name:"No, dejame cambiarlo",action:function(){
                    angular.element("#provTypesend").find("input").focus();
                }}]);
        }


    });
   /* $scope.$watch('dtaPrv.envio',function(nvo){


    });*/
    $scope.$watch('projectForm.provType.$modelValue',function(nvo){
        //console.log($scope.projectForm)
        if(nvo==4 && !$scope.projectForm.provType.$untouched){
            setNotif.addNotif("alert","estas seguro que es tipo TRADER/FABRICA?",[{name:"Si, si lo estoy",action:function(){
            },default:defaultTime},{name:"No, dejame cambiarlo",action:function(){
                document.getElementsByName("provType")[0].click();
            }}]);
        }
    });

    var lawletters = new RegExp(["S.L.U.","S.L.","CO","LTD.","LLC","S.A.","LDA","S.P.A.","s.p.a.","LIMITED","CORP.","S.A.E","S.L.","S.R.L.","S.A.S","INC.","INC","GMBH CO.KG","NV","CO."].join("| ")+"$");
    $scope.check = function(elem){
        
        var htmlElem = document.getElementsByName(elem)[0];
        if($scope.projectForm[elem].$error.duplicate){
            setNotif.addNotif("error","existe un Proveedor con el mismo nombre o siglas",[{name:"corregir!",action:function(){
                htmlElem.focus();
            }}],{block:true});
        }

        if(elem == "razon_social" && htmlElem.value!=""){
            if(!lawletters.test(htmlElem.value.toUpperCase())){
                setNotif.addNotif("alert","esta razon social no termina en siglas conocidas, esta seguro?",
                    [
                        {
                            name:"corregir!",
                            action:function(){
                                htmlElem.focus();
                            }
                        },
                        {
                            name:"esta bien",
                            action:null,
                            default:defaultTime
                        },
                    ]
                );
            };
        };

        if(elem == "siglas" && htmlElem.value!=""){
            //console.log($scope.dtaPrv);
            var nomProv = $scope.dtaPrv.description.replace(lawletters, "");
            var consonantes = nomProv.replace(/[aeiou ]/gi,"");
            var first = consonantes[0];
            var primero = new RegExp(first,"g");
            var last = consonantes.replace(primero,"").substr(-1)
            consonantes = consonantes.substr(1,consonantes.length-2);
            var patt = new RegExp("^"+first+"["+consonantes+"]"+"+"+last+"$","i");
            if(!patt.test(htmlElem.value)){
               setNotif.addNotif("alert","estas siglas no se parecen a la razon social, estas seguro que son correctas?",
                    [
                        {
                            name:"si, lo estoy",
                            action:null,/*function(){
                                console.log(focus)
                                angular.element(focus).focus();
                                focus = null;
                            },*/
                            default:defaultTime
                        },
                        {
                            name:"dejame corregirlo",
                            action:function(){
                                htmlElem.focus();
                            },

                        },
                    ]
                );
            }
        }
    };

    $scope.dtaPrv = setGetProv.getProv();
    $scope.$watchGroup(['projectForm.$valid','projectForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            //console.log("proveedor",$scope.dtaPrv)
            providers.put({type:"saveProv"},$scope.dtaPrv,function(data){
                $scope.dtaPrv.id = data.id;
                $scope.projectForm.$setPristine();
                setGetProv.updateItem($scope.dtaPrv);
                if(data.action=="new"){
                    $scope.dtaPrv.new = true;
                    setNotif.addNotif("ok", "Proveedor agregado", [
                    ],{autohidden:3000});
                };
                setGetProv.addChng($scope.dtaPrv,data.action,"dataProv");
            });
        }
    });

    $scope.show = function(stat){
        $scope.isShow = stat;
        $scope.$parent = "DataProvController";
    }



});
//###########################################################################################3
MyApp.controller('provAddrsController', function ($scope,setGetProv,providers,masterLists,$filter,setNotif,$timeout,$mdSidenav,asignPort,saveForm)   {
    $scope.id = "provAddrsControllers";
    $scope.prov = setGetProv.getProv(); //obtiene en local los datos del proveedor actual
    var dirSel = {};
    var preId = null;
    var currentOrig = {};
    var lryOpen = false;
    $scope.setting = false;
    $scope.tipos = masterLists.getTypeDir();
    $scope.paises = masterLists.getCountries();
    $scope.ports = masterLists.getPorts();
    $scope.svPort = asignPort.getPorts();
    /*escucha cambios en el proveedor seleccionado y carga las direcciones correspondiente*/
    $scope.$watch('prov.id',function(nvo){
        $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
        $scope.address = setGetProv.getAddress()//(nvo)?providers.query({type: "dirList", id_prov: $scope.prov.id || 0}):[];
        $scope.isShow = false;
    });
    $scope.$watch('address.length',function(nvo){
        setGetProv.setComplete("address",nvo);
    });


    $scope.$watch('dir.ports.length', function(nvo,old) {
        if(preId==$scope.dir.id){
            //$scope.dir.ports = $scope.svPort.ports;
            $scope.direccionesForm.$setDirty();
        }else{
            preId =$scope.dir.id;
        }
    });




    /*filter para que funcione el md-autocomplete de tipo de direccion*/
    $scope.filTipo = function(elem,text){
        return elem.descripcion.toLowerCase().indexOf(text.toLowerCase()) != -1;
    };

    $scope.$watch('ctrl.selPais.id',function(nvo,old){
        //console.log("pais",nvo);
        if((nvo) && $filter("filterSearch")(masterLists.getCommonCountry(),[nvo]).length <= 0 && $scope.direccionesForm.$dirty){
            setNotif.addNotif("alert","al parecer este pais no es muy comun, esta seguro que esta correcto?", [
                {
                    name: "corregir",
                    action: function () {
                        angular.element("#dirPais").find("input").focus();
                    }
                },{
                    name: "esta bien",
                    action: function () {
                        $scope.dir.pais = nvo;
                        asignPort.setCountry(nvo);
                    },
                    default:defaultTime
                }
            ])
        }

        $scope.dir.pais = nvo;
        asignPort.setCountry(nvo);
        var preVal = angular.element("#dirPhone").val();
        if(preVal){
            angular.element("#dirPhone").val(preVal.replace(/\(\+[0-9\-]+\)/,$filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone))
        }else{
            angular.element("#dirPhone").val($filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone);
        }

    });

    $scope.checkCode = function(){
        if($scope.dir.provTelf){
            if($scope.dir.provTelf.indexOf($filter("filterSearch")($scope.paises, [$scope.dir.pais])[0].area_code.phone)==-1){
                setNotif.addNotif("alert","el codigo de area indicado no coincide con el pais seleccionado", [
                    {
                        name: "corregir",
                        action: function () {
                            document.getElementsByName("dirprovTelf")[0].focus();
                        }
                    },{
                        name: "esta bien",
                        action:null,
                        default:defaultTime
                    }
                ])
            }
        };
    };

    $scope.searchPort = function(ports,pais){
        return ports.pais_id == pais;
    };
    $scope.$watch('ctrl.dirType.id',function(nvo){
        if($scope.direccionesForm.$dirty){
            $scope.dir.tipo = nvo;
        }
       // setGetProv.setComplete("address",nvo);
    });




    $scope.toEdit = function(addrs){

        saveAddress(function(el){
            dirSel = el;
            $scope.dir.id = dirSel.id;
            $scope.dir.id_prov = dirSel.prov_id;
            $scope.dir.direccProv = dirSel.direccion;
            //$scope.dir.tipo = dirSel.tipo_dir;
            $scope.ctrl['selPais'] = dirSel.pais;
            $scope.ctrl['dirType'] = dirSel.tipo;
            // $scope.dir.pais = dirSel.pais_id;
            asignPort.setCountry(dirSel.pais_id);
            $scope.dir.provTelf = dirSel.telefono;
            $scope.dir.ports = dirSel.ports;
            asignPort.setPorts(dirSel.ports);
            $scope.dir.zipCode = parseInt(dirSel.codigo_postal);
            currentOrig = angular.copy($scope.dir);
            setGetProv.addToRllBck($scope.dir,"dirProv");

        },addrs.add)

    };

   /* /!*escuah el estatus del formulario y guarda cuando este valido*!/
    $scope.$watchGroup(['direccionesForm.$valid','direccionesForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {

        }
    });*/

    var saveAddress = function(onSuccess,elem){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.direccionesForm,
                model:$scope.dir,
                list:dirSel,
                save:function(onSuccess,list,next){
                    dirSel = list;
                    providers.put({type:"saveProvAddr"},$scope.dir,function(data){
                        $scope.dir.id = data.id;
                        setGetProv.addChng($scope.dir,data.action,"dirProv");
                        $scope.direccionesForm.$setPristine();
                        dirSel.id = $scope.dir.id;
                        dirSel.direccion =  $scope.dir.direccProv;
                        dirSel.tipo_dir=$scope.dir.tipo;
                        dirSel.tipo=$filter("filterSearch")($scope.tipos,[$scope.dir.tipo])[0];
                        dirSel.pais_id=$scope.dir.pais;
                        dirSel.pais=$filter("filterSearch")($scope.paises,[$scope.dir.pais])[0];
                        dirSel.telefono = $scope.dir.provTelf;
                        dirSel.ports = $scope.dir.ports;
                        dirSel.codigo_postal = $scope.dir.zipCode;
                        if(data.action=="new"){
                            $scope.address.unshift(dirSel);
                            setNotif.addNotif("ok", "Nueva Direccion!", [
                            ],{autohidden:3000});
                        }else{
                            //$scope.address.unshift(dirSel);
                            setNotif.addNotif("ok", "Datos Actualizados", [
                            ],{autohidden:3000});
                        }
                        onSuccess(next);
                    });
                }
            }
        );

        
    };

    $scope.rmAddres = function(elem){
        setNotif.addNotif("alert", "desea borrar esta direccion?", [
            {
                name: "SI",
                action: function () {
                    addr = elem.add;

                        providers.put({type:"delAddr"},addr,function(data){
                            setGetProv.addChng($scope.dir,data.action,"dirProv");
                            $scope.address.splice(elem.$index,1);
                            //$scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
                            dirSel = {};
                            $scope.direccionesForm.$setUntouched();
                            $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
                            $scope.ctrl.searchCountry = undefined;
                            $scope.ctrl.searchType = undefined;
                            setNotif.addNotif("ok", "Direccion borrada", [
                            ],{autohidden:3000});
                        });


                }
            },
            {
                name: "NO",
                action: function () {
                },
                default:defaultTime
            }
        ]);
    };

    $scope.showGrid = function(elem,event){
        $scope.setting=true;
        //if((jQuery(event.target).parents("#lyrAlert").length==0) && (angular.element(event.target).parents("md-sidenav.popUp").length==0)) {
            $scope.isShow = elem;
            if(!elem) {
                saveAddress(function(){
                    asignPort.setPorts(false);
                    $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
                    $scope.ctrl.searchCountry = undefined;
                    $scope.ctrl.searchType = undefined;
                    currentOrig = {};
                    $scope.direccionesForm.$setPristine();
                    $scope.direccionesForm.$setUntouched();
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                });
            }
            
            $timeout(function(){$scope.setting = false;},100)
        //}
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"provAddrsControllers":false;

    };


});

MyApp.controller('portsControllers', function ($scope,masterLists,asignPort,setNotif,$filter) {
    $scope.paises = masterLists.getCountries();
    $scope.ports = masterLists.getPorts();
    $scope.asignPorts = asignPort.getPorts();
    $scope.country = asignPort.getCountry();
    $scope.searchPort = function(ports,pais){
        return ((ports.pais_id == pais) && $scope.asignPorts.ports.indexOf(ports.id)==-1);
    };

    $scope.searchAssig = function(ports,asign){
        return asign.indexOf(ports.id)!=-1;
    };

    $scope.assign = function(port){
        $scope.asignPorts.ports.push(port.id);
        setNotif.addNotif("ok", "puerto añadido", [
        ],{autohidden:3000});
    };

    $scope.remove = function(index){
        $scope.asignPorts.ports.splice($scope.asignPorts.ports.indexOf(index.id),1);
        setNotif.addNotif("ok", "se removio el puerto", [
        ],{autohidden:3000});
    }
});

MyApp.service("asignPort",function(){
    var assignPorts = {ports:[],aux:true};
    var defaultCountry = {default:""};
    return{
        setPorts : function(ports){
            assignPorts.ports = ports || [];
            assignPorts.aux = !assignPorts.aux;
        },
        getPorts : function(){
            return assignPorts;
        },
        setCountry : function(pais){
            defaultCountry.default = pais;
        },
        getCountry : function(){
            return defaultCountry;
        }
    }
});

MyApp.controller('valcroNameController', function($scope,setGetProv,$http,providers,$mdSidenav,$filter,valcroNameDetail,setNotif,$timeout) {
    $scope.prov = setGetProv.getProv(); //obtiene en local los datos del proveedor actual
    $scope.allName = providers.query({type:"allValcroName"});
    $scope.deps = [
        {
            id:1,
            icon:"icon-CarritoCompra",
            desc:"Ventas"
        },
        {
            id:2,
            icon:"icon-Aereo",
            desc:"Compras / importacion"
        },
        {
            id:3,
            icon:"icon-TransTerrestre",
            desc:"Almacen"
        }
    ];
    var valcroName = {};
    $scope.$watch('prov.id',function(nvo){
        $scope.valcroName = setGetProv.getNomVal();
        //$scope.valcroName = (nvo)?providers.query({type: "provNomValList", id_prov: $scope.prov.id || 0}):[];
        $scope.valName={id:false,name:"",departments:{0:"current"},fav:"",prov_id:$scope.prov.id || 0};
    });

    $scope.order = function(v){
        var fav = 0;
        angular.forEach(v.departments,function(v,k){
            if(fav==0){
                fav = parseInt(v.pivot.fav);
            }
        });
        return fav;
    };

    $scope.exist = function(id,fav){
        if($scope.valName.departments[id]){
            return $scope.valName.departments[id].fav==fav;
        }else{
            return false;
        }
    };

    var currentDeps = Object();
    $scope.over = function(nomVal){
        if (nomVal) {
            //console.log("true",$scope.valName.departments)
            if($scope.valName.departments[0] == "current"){
                currentDeps = $scope.valName.departments;
            }
            $scope.overId = nomVal.name.id;
            $scope.valName.departments = {0:"over"};
            //console.log(typeOf());
            angular.forEach(nomVal.name.departments, function (v, k) {
                var fav = {"fav": v.pivot.fav};
                $scope.valName.departments[v.id] = fav;
            });

        } else {

            if($scope.valName.departments[0] != "current"){
                $scope.valName.departments = angular.copy(currentDeps);
            }

        }

    };
    $scope.toEdit = function(nomVal){
        valcroName = nomVal.name;
        $scope.valName.id = valcroName.id;
        $scope.valName.prov_id = $scope.prov.id;
        $scope.valName.fav = valcroName.fav;
        $scope.valName.name = valcroName.name;
        $scope.valName.departments = {0:"current"};
        angular.forEach(valcroName.departments,function(v,k){
            var fav = {"fav":v.pivot.fav};
            $scope.valName.departments[v.id] = fav;
        });
        //valcroName.departments.forEach();
        setGetProv.addToRllBck($scope.valName,"valName");
    };
    $scope.$watch('valcroName.length',function(nvo){
        setGetProv.setComplete("valcroName",nvo);
    });

    var saving = false;
    function saveValcroname(preFav,onSuccess){

        if(!$scope.nomvalcroForm.$valid){
//            console.log("adasdasdasdasdasdasdasdasdasdasdasd")
            onSuccess();
            return false;
        }

        if(saving){
            return false;
        }
        saving = false;
        if(preFav.length>0){
            $scope.valName.preFav = preFav;
        }else{
            $scope.valName.preFav = false;
        }
        providers.put({type: "saveValcroName"}, $scope.valName, function (data) {

            $scope.valName.id = data.id;
            setGetProv.addChng($scope.valName,data.action,"valName");
            $scope.nomvalcroForm.$setPristine();
            $scope.valName.id = data.id;
            valcroName.id = data.id;
            valcroName.name = $scope.valName.name;
            var temp = [];
            var i = 0;
            angular.forEach($scope.valName.departments,function(k,v){
                if(v>0){
                    if(k!=1){
                        temp.push({id: v,pivot:{fav:k.fav}});
                    }
                    if(i==Object.keys($scope.valName.departments).length-1){
                        valcroName.departments = temp;
                    }
                }

                i++;
            });
            if (data.action == "new") {
                valcroName.departments = {};
                $scope.valName.departments = {0:"current"};
                $scope.valcroName.unshift(valcroName);
                setNotif.addNotif("ok", "Nuevo Nombre Valcro", [
                ],{autohidden:3000});
            }else{
                setNotif.addNotif("ok", "Actualizé el Nombre Valcro", [
                ],{autohidden:3000});
            };

            $scope.valcroName = $filter('orderBy')( $scope.valcroName, "departments.fav");
            setGetProv.addChng( $scope.valName,data.action,"valName");
            preFav = [];
            saving = false;
            onSuccess();
        });
    };

    $scope.rmValName = function(name){

        setNotif.addNotif("alert", "desea borrar este nombre valcro", [
            {
                name: "SI",
                action: function () {
                    chip = name.name;
                    $http({
                        method: 'POST',
                        url: "provider/delValcroName",
                        data: chip
                    }).then(function successCallback(response) {
                        //console.log(name);
                        $scope.valcroName.splice($scope.valcroName.indexOf($filter("filterSearch")($scope.valcroName,[chip.id])[0]),1);
                        //console.log($scope.valcroName);
                        setGetProv.addChng( $scope.valName,response.data.action,"valName");
                        $scope.valName={id:false,name:"",departments:{0:"current"},fav:"",prov_id:$scope.prov.id || 0};
                        valcroName = {};
                        $scope.nomvalcroForm.$setUntouched();
                        setNotif.addNotif("ok", "Nombre valcro borrado", [
                        ],{autohidden:3000});
                    }, function errorCallback(response) {
                        //console.log("error=>", response)
                    });
                }
            },
            {
                name: "no",
                action: function () {
                }
            }
        ]);

    };

    $scope.showGrid = function(elem,a){
        if(!elem){
            //if(jQuery(a.target).parents("#lyrAlert").length==0 && jQuery(a.target).parents("#nomValLyr").length==0){
                if($scope.valName.id && Object.keys($scope.valName.departments).length<=0){
                    //console.log("cond1");
                    /*CLICK EN UN FUERA DEL FORMULARIO, CON DATOS EN INPUT, VERIFICA Y RESETEA EL FORMUALRIO Y SALE DEL FOCUS*/
                    setNotif.addNotif("alert","el nombre valcro no fue asignado a ningun departamento, desea finalizar",[
                        {
                            name:"SI",
                            action:function(){
                                saveValcroname(preFav,function(){
                                    $scope.isShow = elem;
                                    $scope.valName={id:false,name:"",departments:{0:"current"},fav:"",prov_id:$scope.prov.id || 0};
                                    valcroName = {};
                                    $scope.nomvalcroForm.$setUntouched();
                                });

                            },
                            default:defaultTime
                        },
                        {
                            name:"NO",
                            action:function(){
                                document.getElementsByName("name")[0].focus()
                            }
                        }
                    ],{block:true});
                }else{
                    /*CLICK EN UN FUERA DEL FORMULARIO, RESETEA EL FORMULARIO Y SALE DEL FOCUS*/
                    console.log("fuera del folder")
                    $timeout(function(){
                        saveValcroname(preFav,function(){
                            $scope.isShow = elem;
                            $scope.valName={id:false,name:"",departments:{0:"current"},fav:"",prov_id:$scope.prov.id || 0};
                            valcroName = {};
                            $scope.nomvalcroForm.$setUntouched();
                        });
                    },500);


                }

            //}

        }else{
            /*CLICK EN UN LUGAR DEL FORMULARIO, VACIA EL INPUT Y DEVUELVE EL FOCUS*/
            if(!(angular.element(a.target).is("[chip],#transition") || angular.element(a.target).parents("#valNameContainer").length>0)){
                console.log("fuera del folder")
                saveValcroname(preFav,function(){
                    $scope.nomvalcroForm.$setUntouched();
                    $scope.valName={id:false,name:"",departments:{0:"current"},fav:"",prov_id:$scope.prov.id || 0};
                    valcroName = {};
                    document.getElementsByName("name")[0].focus();
                });

            }
            $scope.isShow = elem;
        }
    };

    $scope.coinc = [];
    $scope.$watch('nomvalcroForm.name.$viewValue',function(nvo){
        if(nvo!=""){
            valcroNameDetail.setList($scope.coinc = $filter("customFind")($scope.allName,nvo,function(c,v){
                return c.nombre.indexOf(v)!==-1 && c.id != $scope.valName.id;
            }));
        }else{
            valcroNameDetail.setList($scope.coinc = []);
        }

    });
    $scope.openCoinc = function(){
        $mdSidenav("nomValLyr").open();
    };


    var preFav = [];
    var setFav = function(dep){

        if(!$scope.nomvalcroForm.$valid){
            return false;
        }
        var temp = $filter("customFind")($scope.valcroName,{id: dep.id,pivot:{fav:1}},function(current,compare){return $filter("customFind")(current.departments,compare,function(x,e){ return (parseInt(x.id) == parseInt(e.id)) && (parseInt(x.pivot.fav)== parseInt(e.pivot.fav))}).length>0});

        if(temp.length>0){
            setNotif.addNotif("alert","ya existe un favorito para este departamento, desea reasignar",[
                {
                    name:"SI",
                    action:function(){
                        $filter("customFind")(temp[0].departments,dep.id,function(current,local){ return parseInt(current.id)==parseInt(local)})[0].pivot.fav=0;
                        if($scope.valName.departments[dep.id]){
                            $scope.valName.departments[dep.id].fav = 1;
                        }else{
                            var fav = {fav:1};
                            $scope.valName.departments[dep.id]=fav;
                        }
                        preFav.push({"id":temp[0].id,"dep":dep.id});
                        currentDeps =$scope.valName.departments;
                    }
                },
                {
                    name:"NO",
                    action:function(){
                        //console.log("error")
                    }
                }
            ]);
        }else{
            var fav = {fav:1};
            $scope.valName.departments[dep.id]=fav;
            currentDeps =$scope.valName.departments;
        }


    };
    var unsetFav = function(dep){
        if(!$scope.nomvalcroForm.$valid){
            return false;
        }
        $scope.valName.departments[dep.id].fav=0;
        currentDeps =$scope.valName.departments;
        setNotif.addNotif("ok", "favorito quitado", [
        ],{autohidden:3000});
    };

    $scope.setDepa = function(dep,e){
        if(e.keyCode==32 || e.type=="click") {
            if (!$scope.nomvalcroForm.$valid) {
                return false;
            }
            if ($scope.valName.departments[dep.dep.id]) {
                var favFn = unsetFav;
                if ($scope.valName.departments[dep.dep.id].fav == 1) {
                    favFn = unsetFav;
                    fav = true;
                } else {
                    favFn = setFav;
                    fav = false;
                }
                setNotif.addNotif("alert", "que desea hacer?", [
                    {
                        name: (fav) ? "Quitar Favorito" : "volver favorito",
                        action: function () {
                            $timeout(function () {
                                favFn(dep.dep);
                            }, 10);
                        }
                    },
                    {
                        name: "desvincular",
                        action: function () {
                            var temp = {};
                            var i = 0;
                            angular.forEach($scope.valName.departments, function (k, v) {
                                if (v > 0) {
                                    if (parseInt(v) != parseInt(dep.dep.id)) {
                                        temp[v] = k;
                                    }
                                    if (i == Object.keys($scope.valName.departments).length - 1) {
                                        $scope.valName.departments = temp;
                                    }
                                }

                                i++;
                            });
                            currentDeps = $scope.valName.departments
                            setNotif.addNotif("ok", "departamento desvinculado", [], {autohidden: 3000});
                        }
                    },
                    {
                        name: "no",
                        action: function () {
                        }
                    }
                ]);
            } else {
                var fav = {fav: 0};
                $scope.valName.departments[dep.dep.id] = fav;
                //saveValcroname();
                setNotif.addNotif("ok", "departamento añadido", [], {autohidden: 3000});
            }

            $scope.nomvalcroForm.$setDirty();
        }
    };


});

MyApp.service("valcroNameDetail",function(){
    var valcroNames = {list:[],last:null};

    return {
        setList : function(list){
            var d = new Date();
            valcroNames.list = list;
            valcroNames.last = d.getDate();
        },
        getList : function(){
            return valcroNames;
        }
    }
});

MyApp.controller('nomValAssign', function ($scope,setGetProv,valcroNameDetail,$mdSidenav) {
    $scope.prov = setGetProv.getProv();
    $scope.lines = valcroNameDetail.getList();
    $scope.closeNomValLyr = function () {
        $mdSidenav("nomValLyr").close();
    }
});

MyApp.controller('contactProv', function($scope,setGetProv,providers,$mdSidenav,setGetContac,masters,masterLists,$filter,setNotif,$timeout,saveForm) {
    $scope.id = "contactProv";
    $scope.prov = setGetProv.getProv();
    $scope.cnt = setGetContac.getContact();
    $scope.paises = masterLists.getCountries();
    $scope.languaje = masterLists.getLanguaje();
    $scope.allContact = setGetContac.getList();
    $scope.cargos = masters.query({type:"cargoContact"});
    $scope.setting =  false;

    $scope.$watch('prov.id',function(nvo){
        $scope.contacts = setGetProv.getContacts();//(nvo)?providers.query({type: "contactProv", id_prov: $scope.prov.id || 0}):[];
        $scope.dirAssign = setGetProv.getAddress();
        $scope.cnt.prov_id=$scope.prov.id;
    });


    $scope.$watch('ctrl.pais.id',function(nvo,old)
    {

        var preVal = angular.element("#contTelf").find("input").val();
        if(preVal){
            if(preVal!=""){
                angular.element("#contTelf").find("input").val(preVal.replace(/\(\+[0-9\-]+\)/,$filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone))
            }else{
                angular.element("#contTelf").find("input").val($filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone);
            }
        }
        //$scope.cnt.contTelf.valor = (nvo!=0 && $scope.cnt.contTelf.valor=="")?$scope.cnt.contTelf.valor.replace(prev,$filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone):$scope.cnt.contTelf.valor;
    });

    $scope.$watch('ctrl.lang.id',function(nvo,old)
    {
        if(nvo){
            $scope.cnt.languaje.unshift(nvo);
            $scope.cnt.languaje.length
            $scope.ctrl.searchLang = null;
            $scope.provContactosForm.$setDirty();
        }

        /*if($filter("customFind")($scope.dirAssign,nvo,function(x,e){return x.pais_id == e;}).length==0 && $scope.provContactosForm.$dirty){
         setNotif.addNotif("alert", "este pais no coincide con ninguno de las direcciones esta seguro?",[{
         name:"si",
         action:function(){

         }
         },{
         name:"no",
         action:function(){
         console.log($scope.provContactosForm);
         }
         }]);
         }*/
       /* var preVal = angular.element("#contTelf").find("input").val();
        if(preVal){
            if(preVal!=""){
                angular.element("#contTelf").find("input").val(preVal.replace(/\(\+[0-9\-]+\)/,$filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone))
            }else{
                angular.element("#contTelf").find("input").val($filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone);
            }
        }*/
        //$scope.cnt.contTelf.valor = (nvo!=0 && $scope.cnt.contTelf.valor=="")?$scope.cnt.contTelf.valor.replace(prev,$filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone):$scope.cnt.contTelf.valor;
    });

    $scope.$watch('contacts.length',function(nvo){
        setGetProv.setComplete("contact",nvo);
    });

    var chipCont = {};

    angular.element("#contTelf").on("focus","input",function(e){
        if(angular.element("#contTelf").find("input").val()==""){
            angular.element("#contTelf").find("input").val($scope.ctrl.pais.area_code.phone);
        }

    });


    angular.element("#contTelf").on("keyup","input",function(e){
        if(angular.element(this).val().indexOf($scope.ctrl.pais.area_code.phone)==-1 && (e.keyCode != 32 && e.keyCode != 13)){
            setNotif.addNotif("alert","el codigo de area no coincide con el del pais seleccionado",[{
                name:"corregir",
                action:function(){
                    var preVal = angular.element("#contTelf").find("input").val();
                    if(preVal){
                        if(preVal!=""){
                            angular.element("#contTelf").find("input").val(preVal.replace(/\(\+[0-9\-]+\)/,$scope.ctrl.pais.area_code.phone));
                        }else{
                            angular.element("#contTelf").find("input").val($filter("filterSearch")($scope.ctrl.pais.area_code.phone));
                        }
                    }
                }
            }]);
        }else{
            setNotif.hideByContent("alert","el codigo de area no coincide con el del pais seleccionado");
        }
    });
    $scope.editChip = function(chip,event){
        chipCont = chip;
        //
        var input = angular.element(event.currentTarget).parents("md-chips-wrap").find(".md-chip-input-container").detach();

        var x = angular.element(event.currentTarget).parents("md-chip").replaceWith(input)
        $timeout(function(){
            angular.element(input).find("input").val(chipCont.valor);
            angular.element(input).find("input").focus()
        },100)

    };
    /*funcion que transforma el texto ingresado en el mdchips en un objeto */
    $scope.transformChipEmail = function(chip,erro){
        if (angular.isObject(chip)) {
            return chip;
        }
        var reg = new RegExp("^[A-Za-z]+[^\\s\\+\\-\\\\\/\\(\\)\\[\\]\\-]*@[A-Za-z]+[A-Za-z0-9]*\\.[A-Za-z]{2,}$");

        if(!reg.test(chip)){
            setNotif.addNotif("error", "el email no tiene un formato adecuado", [
            ],{autohidden:3000});
            return null ;
        }

        if($filter("customFind")($scope.allContact,chip,function(val,compare){return val.email == compare;}).length>0){
            setNotif.addNotif("alert", "este email ya existe en la libreta de contactos", [
            ],{autohidden:3000});
            if(!$scope.cnt.id){
                $scope.$parent.openPopUp('contactBook')
            }
            return null;
        }
        if(Object.keys(chipCont).length==0){
            var chip = {id:false,valor:chip,cont_id:$scope.cnt.id,prov_id:$scope.prov.id};
        }else{
            $scope.cnt.emailCont.splice($scope.cnt.emailCont.indexOf($filter("customFind")($scope.cnt.emailCont,chipCont.$$hashKey,function(e,c){return e.$$hashKey == c})[0]),1);
            var chip = {  id:chipCont.id,valor:chip,cont_id:$scope.cnt.id,prov_id:$scope.prov.id};
            //return null;
        };

        chipCont = {};

        return chip;


    };

    $scope.transformChipTlf = function(chip){
        if (angular.isObject(chip)) {
            return chip;
        }

        var reg = new RegExp("^\\(?\\+[0-9]{1,3}\\-?[0-9]{0,3}[\\)\\-\\s]{1}[0-9\\-]{10}$");
        if(!reg.test(chip)){
            $timeout(function(){
                if(angular.element(":focus").parents("#contTelf").length>0){
                    if(chip!="" && chip != $scope.ctrl.pais.area_code.phone){
                        setNotif.addNotif("error", "el telefono no posee un formato adecuado, recuerda ingresarlo en formato internacional", [
                        ],{autohidden:5000});
                    }else{
                        setNotif.addNotif("error", "el telefono no posee un formato adecuado, recuerda ingresarlo en formato internacional", [
                        ],{autohidden:5000});
                        angular.element("#contTelf").find("input").val($scope.ctrl.pais.area_code.phone);
                    }
                }

            },500)


            return null ;
        }
        if(Object.keys(chipCont).length==0){
            var chip = {id:false,valor:chip,cont_id:$scope.cnt.id,prov_id:$scope.prov.id};
        }else{
            $scope.cnt.contTelf.splice($scope.cnt.contTelf.indexOf($filter("customFind")($scope.cnt.contTelf,chipCont.$$hashKey,function(e,c){return e.$$hashKey == c})[0]),1);
            var chip = {id:chipCont.id,valor:chip,cont_id:$scope.cnt.id,prov_id:$scope.prov.id};
            //return null;
        };
        chipCont = {};
        $timeout(function(){
            angular.element("#contTelf").find("input").val($filter("filterSearch")($scope.paises,[$scope.cnt.pais])[0].area_code.phone);
        },100)

        return chip;
    };

    var contact = {}; //var auxiliar para manejar los datos del grid contra los del scope editado
    var currentOrig = {};

    var saveContact = function(onSuccess,elm){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elm,
                form:$scope.provContactosForm,
                model:$scope.cnt,
                list:contact,
                save:function(onSuccess,list,next){
                    contact = list;
                    providers.put({type: "saveContactProv"}, $scope.cnt, function (data) {
                        $scope.cnt.id = data.id;

                        contact.id = $scope.cnt.id;
                        contact.nombre = $scope.cnt.nombreCont;
                        contact.pais_id = $scope.cnt.pais;
                        contact.pais = $filter("filterSearch")($scope.paises, [$scope.cnt.pais])[0];
                        contact.responsabilidades =  $scope.cnt.responsability;
                        contact.direccion = $scope.cnt.dirOff;
                        contact.agente = $scope.cnt.isAgent;
                        contact.prov_id = $scope.cnt.prov_id;
                        contact.languages = $scope.cnt.languaje;
                        contact.cargos = $scope.cnt.cargo;

                        if (data.action == "new") {
                            $scope.cnt.autoSave = false;
                            $scope.contacts.unshift(contact);
                            setGetContac.addUpd(contact,angular.copy($scope.prov));
                            setNotif.addNotif("ok", "contacto añadido", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "contacto Actualizado", [
                            ],{autohidden:3000});
                        };
                        setGetProv.addChng($scope.cnt,data.action,"contProv");
                        onSuccess(next);

                    });
                }
            }
        );
    };

    /*seteado de Cargos para el contacto (tipo departamento nombre valcro*/
    $scope.setCargo = function(elem,e){
        if(e.keyCode==32 || e.type=="click"){
            var cargo = elem.id;
            var k = $scope.cnt.cargo.indexOf(cargo);
            if(k!=-1){
                $scope.cnt.cargo.splice(k,1);
            }else{
                $scope.cnt.cargo.push(""+cargo);
            }
            $scope.provContactosForm.$setDirty();
        }


    };

    /*borra el contacto seleccioado, esta funcion es llamada directo desde el icono de borrado*/
    $scope.rmContact = function(elem){
        setNotif.addNotif("alert", "desea desvincular este Contacto del proveedor?", [
            {
                name: "SI",
                action: function () {
                    cont = elem.cont;
                    providers.put({type:"delContac"},cont,function(data){
                        setGetProv.addChng($scope.cnt,data.action,"contProv");
                        $scope.contacts.splice(elem.$index,1);
                        setGetContac.addUpd(cont,$scope.prov);
                        contact = {};
                        setGetContac.setContact(false);
                        $scope.provContactosForm.$setUntouched();
                        setNotif.addNotif("ok", "Contacto desviculado!", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    /*setea el contacto del grid para edicion en el formulario
    en el caso de contactos lo setea mediante el servicio "setGetContact"*/
    $scope.toEdit = function(element){
        saveContact(function(contact){
            //$scope.setting = true;
            console.log("elemento")
            $scope.provContactosForm.$setUntouched();
            $scope.provContactosForm.$setPristine();
            contact.prov_id = $scope.prov.id;
            $scope.ctrl['pais'] = $filter("filterSearch")($scope.paises,[contact.pais_id])[0]
            setGetContac.setContact(contact);
            currentOrig = angular.copy($scope.cnt);
            setGetProv.addToRllBck($scope.cnt,"contProv")

        },element.cont)

    };

    /*muestra u oculta la franaj de ver mas en los form, en el click y clickout (focus,focusout)*/
    $scope.showGrid = function(elem,event){
        //$scope.setting = true;
        //if((jQuery(event.target).parents("#contactBook").length==0) && (jQuery(event.target).parents("#lyrAlert").length==0)){
            if(!elem){
                saveContact(function(){
                    console.log("ENTROOOOOOOOOOOO")
                    $scope.provContactosForm.$setUntouched();
                    $scope.provContactosForm.$setPristine();
                    contact = {};
                    setGetContac.setContact(false);
                    $scope.ctrl.searchCountry = "";

                    angular.element("#contTelf").find("input").val("");
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                    //$timeout(function(){$scope.setting = false;},500)
                });


            }else{
                if($scope.dirAssign.length>0 && !$scope.isShow && $scope.provContactosForm.$pristine){
                    var def = $scope.dirAssign[0];
                    setGetContac.setContact({pais_id:def.pais_id});
                    $scope.ctrl['pais'] = $filter("filterSearch")($scope.paises,[def.pais_id])[0];
                    $timeout(function(){$scope.setting = false;},500)
                    console.log($scope.provContactosForm)
                }
            }
            //$timeout(function(){$scope.setting = false;},500)
            $scope.isShow = elem;

       // }
    };

    /*muestra u oculta los grid y pide el colapsado de los demas form */
    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"contactProv":false; // setea en "expand" del $scope padre (AppController) con el "$scope.id" asignado a este controller, los demas forma collapsan autoamtico
    };


});

MyApp.controller('addressBook', function($scope,providers,$mdSidenav,setGetContac,setGetProv,$filter,setNotif) {
    $scope.prov = setGetProv.getProv();
    $scope.allContact =  setGetContac.getList();
    $scope.filtByprov = function(a,b){
        return $filter("customFind")(a.provs,b,function(val,compare){return val.prov_id == compare}).length==0;
    };
    function instance(contact2){

        contact2.autoSave =true;
        contact2.prov_id = $scope.prov.id;
        setGetContac.setContact(contact2);
        $mdSidenav("contactBook").close();
    }
    $scope.toEdit = function(element){
        setNotif.addNotif("alert", "desea que este contacto se convierta en un agente?", [
            {
                name:"si",
                action:function(){
                    element.cont.agente = 1;
                    instance(element.cont)
                }
            },
            {
                name:"no",
                action:function(){
                    instance(element.cont)
                }
            }
        ]);



    };

    $scope.closeContackBook = function(){
        $mdSidenav("contactBook").close();
    }

});

MyApp.service("setGetContac",function(providers,setGetProv,$filter){
    var contact = {id:false,nombreCont:"",emailCont:[],contTelf:[],pais:"",languaje:[],cargo:[],responsability:"",notes:"",dirOff:"",prov_id:false, isAgent:0,autoSave:false};
    var listCont = [];
    return {
        setContact : function(cont){
                var prov = setGetProv.getProv();
                contact.id = cont.id||false;
                contact.nombreCont = cont.nombre||"";
                contact.emailCont = cont.emails||[];
                contact.contTelf = cont.phones||[];
                contact.pais = cont.pais_id||"  ";
                contact.responsability = cont.responsabilidades||"";
                contact.notes = cont.notas||"";
                contact.dirOff = cont.direccion||"";
                contact.isAgent = cont.agente || 0;
                contact.autoSave = cont.autoSave || false;
                contact.prov_id = cont.prov_id||prov.id;
                contact.languaje = cont.languages||[];
                contact.cargo = cont.cargos||[];
        },
        getContact : function(){
            return contact;
        },
        addUpd : function(cont,prov){
            var contact = $filter("customFind")(listCont,cont.id,function(val,compare){return  val.id == compare;});
            if(contact.length>0){
                var provs = $filter("customFind")(contact[0].provs,prov.id,function(val,compare){return  val.prov_id == compare;});
                if(provs.length>0){
                    contact[0].provs.splice(contact[0].provs.indexOf(provs[0]),1);
                }else{
                    contact[0].provs.push({"prov_id":prov.id,"prov":prov.siglas});
                }
            }else{
                cont.provs = [{"prov_id":prov.id,"prov":prov.siglas}];
                listCont.push(cont);
            }
        },
        setList : function(list){
            listCont = providers.query({type:"allContacts"});
        },
        getList:function(){
            return listCont;
        }
    }
});

MyApp.controller('bankInfoController', function ($scope,masters,masterLists,providers,setGetProv,setNotif,$filter,$timeout,$q) {
    $scope.id = "bankInfoController";
    $scope.prov = setGetProv.getProv();
    $scope.countries = masterLists.getCountries();
    $scope.setting = false;
    /*$scope.cities = masters.query({ type:"getCities"});*/
    $scope.$watch('prov.id',function(nvo){
        $scope.bnk={id:false,bankName:"",bankBenef:"",bankBenefAddr:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad:"",idProv: $scope.prov.id||0};
        $scope.accounts = setGetProv.getBanks();
    });
    $scope.$watch('accounts.length',function(nvo){
        setGetProv.setComplete("bank",nvo);
    });

    $scope.querySearch = function(search){
        if(search){

            var results = $filter("customFind")($scope.cities,search,function(c,v){
                return c.local_name.toLowerCase().indexOf(v)!==-1;
            });
            var deferred = $q.defer();
            $timeout(function () { deferred.resolve( results ); },2000, false);
            return deferred.promise;
        }else{

            return [];
        }

    };

    $scope.$watch('ctrl.pais.id', function(nvo) {
        //$scope.bnk.pais = nvo;
        $scope.states = (nvo)?masters.query({ type:"getStates",id:nvo||0}):[];
    });
    $scope.$watch('ctrl.state.id', function(nvo) {
        //$scope.bnk.est = nvo;
        $scope.cities = (nvo)?masters.query({ type:"getCities",id:nvo||0}):[];
    });
    /*$scope.$watch('ctrl.city.id', function(nvo) {
        $scope.bnk.ciudad = nvo;
        //$scope.cities = (nvo)?masters.query({ type:"getCities",id:nvo||0}):[];
    });*/

    var account = {};

    /*escuha el estatus del formulario y guarda cuando este valido*/
   /* $scope.$watchGroup(['bankInfoForm.$valid','bankInfoForm.$pristine'], function(nuevo) {

        if(nuevo[0] && !nuevo[1]) {


        }
    });*/



    var saveBank = function(onSuccess,elem){
        var next = elem || false;
        if((angular.equals(currentOrig,$scope.bnk) && $scope.bnk.id) || ($scope.bankInfoForm.$pristine )){
//            console.log("blanco")
            onSuccess(next);
            return false;
        }

        if(!$scope.bankInfoForm.$valid && !$scope.bankInfoForm.$pristine){
            $scope.$parent.block="wait";
            var prefocus = angular.element(":focus");
            $timeout(function(){
                angular.element("[name='bankInfoForm']").click();
                $timeout(function(){
                    angular.element(":focus").blur();
                })

            },0);

            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??",[{
                name:"descartalos",
                action:function(){
                    $scope.$parent.block="go";
                    onSuccess(next);
                    $timeout(function(){
                        prefocus.click();
                        prefocus.focus();
                    },10)
                }
            },{
                name:"dejame Corregirlos",
                action:function(){
                    $scope.$parent.block="reject";
                    angular.element("[name='bankInfoForm']").find(".ng-invalid").first().focus()
                }
            }]);

        }

        if($scope.bankInfoForm.$valid && !$scope.bankInfoForm.$pristine){
            providers.put({type:"saveBank"},$scope.bnk,function(data){
                $scope.bnk.id = data.id;
                $scope.bankInfoForm.$setPristine();
                account.prov_id = $scope.bnk.id_prov;
                account.banco = $scope.bnk.bankName;
                account.beneficiario = $scope.bnk.bankBenef;
                account.dir_beneficiario = $scope.bnk.bankBenefAddr;
                account.dir_banco = $scope.bnk.bankAddr;
                account.swift = $scope.bnk.bankSwift;
                account.cuenta = $scope.bnk.bankIban;
                account.ciudad_id = $scope.bnk.ciudad;
                if(data.action=="new"){
                    account.id = $scope.bnk.id;
                    $scope.accounts.unshift(account);
                    setNotif.addNotif("ok", "nueva info bancaria", [
                    ],{autohidden:3000});
                }else{
                    setNotif.addNotif("ok", "Datos Actualizados", [
                    ],{autohidden:3000});
                }
                setGetProv.addChng($scope.bnk,data.action,"infoBank");
                onSuccess(next)
            });
        }else{
            //console.log("invalid")
        }

    };

    $scope.rmBank = function(elem){
        setNotif.addNotif("alert", "desea eliminar esta informacion bancaria", [
            {
                name: "SI",
                action: function () {
                    bnk = elem.account;
                    providers.put({type:"delBank"},bnk,function(data){
                        setGetProv.addChng($scope.bnk,data.action,"infoBank");
                        $scope.accounts.splice(elem.$index,1);
                        $scope.bnk={id:false,bankName:"",bankBenef:"",dirBenef:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad_id:"",idProv: $scope.prov.id};
                        account={};
                        $scope.bankInfoForm.$setUntouched();
                        setNotif.addNotif("ok", "Informacion Eliminada", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    var currentOrig = {};
    $scope.toEdit = function(acc){

        saveBank(function(account){
            $scope.setting=true;
            $scope.bnk.id = account.id;
            $scope.bnk.id_prov = account.prov_id;
            $scope.bnk.bankName = account.banco;
            $scope.bnk.bankBenef = account.beneficiario;
            $scope.bnk.bankBenefAddr = account.dir_beneficiario;
            $scope.bnk.bankAddr = account.dir_banco;
            $scope.bnk.bankSwift = account.swift;
            $scope.bnk.bankIban = account.cuenta;
            $scope.bnk.pais = account.pais.id;
            $scope.ctrl.pais = account.pais;
            $scope.bnk.est = account.estado.id;
            $scope.ctrl.state = account.estado;
            $scope.bnk.ciudad = account.ciudad_id;
            $scope.ctrl.city = account.ciudad;
            currentOrig = angular.copy($scope.bnk);
            setGetProv.addToRllBck($scope.bnk,"infoBank")
            $timeout(function(){$scope.setting = false;},100)
        },acc.account)

    };

    $scope.showGrid = function(elem,event){
       $scope.setting = true;
            if(!elem) {
                saveBank(function(){
                    $scope.bnk={id:false,bankName:"",bankBenef:"",bankBenefAddr:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad_id:"",idProv: $scope.prov.id};
                    $scope.ctrl = {searchCity:"",searchCountry:"",searchState:""};
                    account={};
                    currentOrig = {};
                    $scope.bankInfoForm.$setPristine();
                    $scope.bankInfoForm.$setUntouched();
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                })
            }else{
                if(!$scope.isShow){
                    $scope.bnk.bankBenef = $scope.prov.description;
                    $scope.bnk.bankBenefAddr = $filter("customFind")(setGetProv.getAddress(),["1","3"],function(c,v){
                        return v.indexOf(c.tipo.id)!==-1;
                    })[0].direccion || "";
                }
            }
            $timeout(function(){$scope.setting = false;},100)
            $scope.isShow = elem;
       // }
    };
    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"bankInfoController":false;
    };
});

MyApp.controller('coinController', function ($scope,masters,providers,setGetProv,listCoins,masterLists,$filter,setNotif,$timeout) {
    $scope.id="coinController";
    $scope.prov = setGetProv.getProv();
    $scope.coins =masterLists.getAllCoins();
    $scope.setting = false;
    $scope.$watch('prov.id',function(nvo){
        if(nvo){
            listCoins.setProv(nvo);
        }

        $scope.coinAssign = listCoins.getCoins();
        $scope.cn = {id:"",coin:"",prov_id:$scope.prov.id||0};
        $scope.filt = listCoins.getIdCoins();
    });
    $scope.$watch('coinAssign.length',function(nvo){
        setGetProv.setComplete("coin",nvo);
    });
    $scope.$watchGroup(['provMoneda.$valid','provMoneda.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            $scope.setting = true;
            providers.put({type: "saveCoin"}, $scope.cn, function (data) {
                $scope.ctrl.searchCoin = undefined;
                $scope.provMoneda.$setPristine();
                var newCoin = $filter("filterSearch")($scope.coins,[$scope.cn.coin])[0];
                newCoin.pivot = {prov_id:$scope.cn.prov_id};
                listCoins.addCoin(newCoin);
                $scope.coinAssign = listCoins.getCoins();
                $scope.filt = listCoins.getIdCoins();
                setNotif.addNotif("ok", "Moneda cargada", [
                ],{autohidden:3000});
                setGetProv.addChng($scope.cn,"new","provCoin");
                $timeout(function(){$scope.setting = false;},100)
            })
        }
    });
    var coin = {};
    var currentOrig = {};
    $scope.toEdit = function(coin){
        $scope.setting = true;
        coin = coin.coinSel;
        $scope.cn.id=coin.id;
        $scope.cn.coin=coin.id;
        $scope.cn.coin=$scope.prov.id;
        $scope.ctrl.coin = $scope.coin;
        currentOrig = angular.copy($scope.cn);
        setGetProv.addToRllBck($scope.cn,"provCoin")
        $timeout(function(){$scope.setting = false;},100)
    };

    $scope.rmCoin = function(elem){
        setNotif.addNotif("alert", "desea eliminar esta Moneda", [
            {
                name: "SI",
                action: function () {
                    coin = elem.coinSel;
                    providers.put({type:"delCoin"},coin,function(data){
                        setGetProv.addChng($scope.cn,data.action,"provCoin");
                        $scope.coinAssign.splice(elem.$index,1);
                        $scope.filt.splice($scope.filt.indexOf(elem.coinSel.id),1);
                        $scope.cn = {coin:"",prov_id:$scope.prov.id||0};
                        $scope.provMoneda.$setUntouched();

                        setNotif.addNotif("ok", "Moneda Eliminada", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.createCoin = function(){
        setNotif.addNotif("alert", "¿desea crear una nueva moneda?", [
            {
                name:"Crearla",
                action:function(){
                    $scope.$parent.openPopUp('newCoin');
                }
            },
            {
                name:"olvidalo",
                action:function(){
                    angular.element("#selCoin").focus().click();
                }
            }
        ],{block:true})
    }

    $scope.showGrid = function(elem,event){
        $scope.setting = true;
        if(!elem){
            $scope.ctrl.searchCoin = undefined;
        }
        //if((jQuery(event.target).parents("#lyrAlert").length==0) && (angular.element(event.target).parents("md-sidenav.popUp").length==0)) {
        $scope.isShow = elem;
        $timeout(function(){$scope.setting = false;},100)
        /*if(!elem) {
         saveAddress(function(){
         asignPort.setPorts(false);
         $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
         $scope.ctrl.searchCountry = "";
         currentOrig = {};
         $scope.direccionesForm.$setPristine();
         $scope.direccionesForm.$setUntouched();
         if($scope.$parent.expand==$scope.id){
         $scope.isShowMore = elem;
         $scope.$parent.expand = false;
         }
         });
         }
         if(lryOpen){
         $mdSidenav("portsLyr").close().then(function(){
         lryOpen = false;
         });
         }*/
        // }
    };

});

MyApp.controller('creditCtrl', function ($scope,providers,setGetProv,$filter,listCoins,masterLists,setNotif,$timeout,saveForm) {
    $scope.id="creditCtrl";
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.setting = false;
    $scope.$watch('prov.id',function(nvo){
        $scope.cred = {id:false,coin:"",amount:"",line:"",id_prov: $scope.prov.id||0};
        $scope.limits =  setGetProv.getLimits();
        $scope.coins = (nvo)?listCoins.getCoins():[];
    });
    $scope.$watch('limits.length',function(nvo){
        setGetProv.setComplete("limits",nvo);
    });
    /*$scope.$watch('ctrl.coin.id',function(nvo){
        $scope.cred.coin = nvo;
    });
    $scope.$watch('ctrl.line.id',function(nvo){
        $scope.cred.line = nvo;
    });*/
    var credit = {};

    var currentOrig = {};
    var saveCredit = function(onSuccess,elem){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.provCred,
                model:$scope.cred,
                list:credit,

                save:function(onSuccess,list,next){
                    credit = list;
                    providers.put({type:"saveLim"},$scope.cred,function(data){
                        $scope.cred.id = data.id;
                        $scope.provCred.$setPristine();
                        $scope.setting = true;
                        credit.moneda_id = $scope.cred.coin;
                        credit.moneda = $filter("filterSearch")($scope.coins,[$scope.cred.coin])[0];
                        credit.limite = $scope.cred.amount;
                        credit.linea_id = $scope.cred.line;
                        credit.line = $filter("filterSearch")($scope.lines,[$scope.cred.line])[0];
                        if($scope.cred.amount >= $scope.prov.limCred){
                            $scope.prov.limCred = $scope.cred.amount;
                            setGetProv.updateItem($scope.prov);
                        }

                        if(data.action=="new"){
                            credit.id= $scope.cred.id;
                            $scope.limits.unshift(credit);
                            setNotif.addNotif("ok", "nuevo limite de credito", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "Limite de Credito Actualizado", [
                            ],{autohidden:3000});
                        }
                        setGetProv.addChng($scope.cred,data.action,"limCred");
                        $timeout(function(){$scope.setting=false;},100)
                        onSuccess(next);
                    });
                }
            }
        );

        /*var next = elem || false;
        if((angular.equals(currentOrig,$scope.cred) && $scope.cred.id ) || ($scope.provCred.$pristine )){
            onSuccess(next);
            return false;
        }

        if(!$scope.provCred.$valid && !$scope.provCred.$pristine){
            var prefocus = angular.element(":focus");

            $scope.$parent.block="wait";
            $timeout(function(){
                angular.element("[name='provCred']").click();
                $timeout(function(){
                    angular.element(":focus").blur();
                })

            },0);
            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??",[{
                name:"descartalos",
                action:function(){
                    $scope.$parent.block="go";
                    onSuccess(next);
                    $timeout(function(){
                        prefocus.click();
                        prefocus.focus();
                    },10)
                }
            },{
                name:"dejame Corregirlos",
                action:function(){
                    $scope.$parent.block="reject";
                    angular.element("[name='provCred']").find(".ng-invalid").first().focus()
                }
            }]);
            return false;
        }

        providers.put({type:"saveLim"},$scope.cred,function(data){
            $scope.cred.id = data.id;
            $scope.provCred.$setPristine();
            $scope.setting = true;
            credit.moneda_id = $scope.cred.coin;
            credit.moneda = $filter("filterSearch")($scope.coins,[$scope.cred.coin])[0];
            credit.limite = $scope.cred.amount;
            credit.linea_id = $scope.cred.line;
            credit.line = $filter("filterSearch")($scope.lines,[$scope.cred.line])[0];
            if($scope.cred.amount >= $scope.prov.limCred){
                $scope.prov.limCred = $scope.cred.amount;
                setGetProv.updateItem($scope.prov);
            }

            if(data.action=="new"){
                credit.id= $scope.cred.id;
                $scope.limits.unshift(credit);
                setNotif.addNotif("ok", "nuevo limite de credito", [
                ],{autohidden:3000});
            }else{
                setNotif.addNotif("ok", "Limite de Credito Actualizado", [
                ],{autohidden:3000});
            }
            setGetProv.addChng($scope.cred,data.action,"limCred");
            $timeout(function(){$scope.setting=false;},100)
            onSuccess(next);
        });*/
    };

    $scope.rmCredit = function(elem){
        setNotif.addNotif("alert", "desea eliminar este limite de Credito", [
            {
                name: "SI",
                action: function () {
                    cred = elem.lim;
                    providers.put({type:"delLimCred"},cred,function(data){
                        setGetProv.addChng($scope.cred,data.action,"limCred");
                        $scope.limits.splice(elem.$index,1);
                        $scope.cred = {id: false, coin: "", amount: "", line: "", id_prov: $scope.prov.id};
                        credit = {};
                        $scope.provCred.$setUntouched();
                        setNotif.addNotif("ok", "Limite de Credito borrado", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };
    $scope.toEdit = function(cred){
        //console.log(cred)
        //credit = cred.lim;
        saveCredit(function(el){
            credit = el;
            $scope.cred.id = credit.id;
            $scope.cred.id_prov = credit.prov_id;
            $scope.cred.coin = credit.moneda_id;
            $scope.cred.amount = credit.limite;
            $scope.cred.line = credit.linea_id;
            $scope.ctrl.coin=credit.moneda;
            $scope.ctrl.line=credit.line;
            currentOrig = angular.copy($scope.bnk);
            setGetProv.addToRllBck($scope.bnk,"limCred");
            //$timeout(function(){$scope.setting=false;},100)
        },cred.lim);

    };

    $scope.showGrid = function(elem,event){

        // if(jQuery(event.target).parents("#lyrAlert").length==0) {
        if(!elem) {
                saveCredit(function(elem){
                    //$scope.setting=true;
                    $scope.cred = {id: false, coin: "", amount: "", line: "", id_prov: $scope.prov.id};
                    $scope.ctrl.searchLine = undefined;
                    $scope.ctrl.searchCoin = undefined;
                    credit = {};
                    currentOrig = {};
                    $scope.provCred.$setUntouched();
                    $scope.provCred.$setPristine();
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                    //$timeout(function(){$scope.setting=false;},500)
                },elem)
        }else{
            if(!$scope.isShow){
                //$scope.setting = true;
                $scope.cred.line = 0;
                $scope.ctrl.line = $filter("filterSearch")($scope.lines,["0"])[0];
                //$timeout(function(){$scope.setting=false;},500)
            }

        }

        $scope.isShow = elem;

    };

    /*var clearForm = function(elem){

    };*/

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"creditCtrl":false;
    };

});

MyApp.controller('convController', function ($scope,$mdSidenav,providers,setGetProv,$filter,listCoins,masterLists,setNotif,$timeout,saveForm) {
    $scope.id = "convController";
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",id_prov: $scope.prov.id||0};
    $scope.setting = false;
    $scope.$watch('prov.id',function(nvo){
        $scope.coins = (nvo)?listCoins.getCoins():[];
        $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",line:"",id_prov: $scope.prov.id||0};
        $scope.factors =  setGetProv.getFactors();//(nvo)?providers.query({type:"provFactors",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('factors.length',function(nvo){
        setGetProv.setComplete("factors",nvo);
    });

    var factor = {};
    var currentOrig = {};

    var saveConv = function(onSuccess,elem){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.provConv,
                model:$scope.conv,
                list:factor,
                save:function(onSuccess,list,next){
                    console.log(factor)
                    //factor = foreign.elList;
                    //console.log(list)
                    providers.put({type:"saveConv"},$scope.conv,function(data){
                        $scope.conv.id = data.id;
                        factor.prov_id = $scope.conv.id_prov
                        factor.moneda_id = $scope.conv.coin;
                        factor.moneda = $filter("filterSearch")($scope.coins,[$scope.conv.coin])[0];
                        factor.flete = $scope.conv.freight ;
                        factor.gastos = $scope.conv.expens;
                        factor.ganancia = $scope.conv.gain;
                        factor.descuento = $scope.conv.disc;
                        factor.linea_id = $scope.conv.line;
                        factor.linea = $scope.ctrl.line;
                        if(data.action=="new"){
                            factor.id =  $scope.conv.id;
                            $scope.factors.unshift(factor);
                            setNotif.addNotif("ok", "factor creado", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "factor Actualizado", [
                            ],{autohidden:3000});
                        }
                        setGetProv.addChng($scope.conv,data.action,"factConv");
                        onSuccess(next);

                    });
                }
            }
        )
    };
    $scope.rmConv = function(elem){
        setNotif.addNotif("alert", "desea eliminar este Factor de conversion", [
            {
                name: "SI",
                action: function () {
                    conv = elem.factor;
                    providers.put({type:"delFactor"},conv,function(data){
                        setGetProv.addChng($scope.conv,data.action,"factConv");
                        $scope.factors.splice(elem.$index,1);
                        $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",line:"",id_prov: $scope.prov.id};
                        factor = {};
                        $scope.ctrl.searchLine = undefined;
                        $scope.ctrl.searchCoin = undefined;
                        $scope.provConv.$setUntouched();
                        $scope.provConv.$setPristine();
                        setNotif.addNotif("ok", "Factor Borrado", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(fact){

        saveConv(function(el) {
            factor = el;
            $scope.setting = true;
            $scope.conv.id = factor.id;
            $scope.conv.id_prov = factor.prov_id;
            $scope.conv.coin = factor.moneda_id;
            $scope.conv.freight = factor.flete;
            $scope.conv.expens = factor.gastos;
            $scope.conv.gain = factor.ganancia;
            $scope.conv.disc = factor.descuento;
            $scope.conv.line = factor.linea_id;
            $scope.ctrl.line = factor.linea;
            $scope.ctrl.coin = factor.moneda;
            currentOrig = angular.copy($scope.conv);
            setGetProv.addToRllBck($scope.conv, "factConv");
            $timeout(function(){$scope.setting=false;},500)
        },fact.factor)
    };

    $scope.showGrid = function(elem,event){
        //if((angular.element(event.target).parents("#lyrAlert").length==0) && (angular.element(event.target).parents(".popUp").length==0)) {
        //$scope.setting=true;
        if(!elem) {
            saveConv(function(){
                //setting=true;
                $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",line:"",id_prov: $scope.prov.id};

                factor = {};
                currentOrig = {};

                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }
                $timeout(function(){
                    $scope.ctrl.searchLine = undefined;
                    $scope.ctrl.searchCoin = undefined;
                    $scope.provConv.$setUntouched();
                    $scope.provConv.$setPristine();
                    //$timeout(function(){$scope.setting=false;},500)
                },500)


            })

        }else{
            if(!$scope.isShow){
                //$scope.setting=true;
                $scope.conv.line = 0;
               // $timeout(function(){$scope.setting=false;},1000)
            }
        }
        $scope.isShow = elem;
        //}
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"convController":false;
    };

});

MyApp.controller('provPointController', function ($scope,providers,setGetProv,listCoins,masterLists,$filter,setNotif,$timeout,saveForm) {
    $scope.id = "provPointController";
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.setting = false;
    $scope.$watch('prov.id',function(nvo){
        $scope.coins = (nvo)?listCoins.getCoins():[];
        $scope.pnt = {id:false,cost:"",coin:"",line:"",id_prov: $scope.prov.id||0};
        $scope.points =  setGetProv.getPoints()//(nvo)?providers.query({type:"provPoint",id_prov:$scope.prov.id||0}):[];
    });

    var point = {};
    var currentOrig = {};
    var savePoint = function(onSuccess,elem)    {
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.provPoint,
                model:$scope.pnt,
                list:point,
                save:function(onSuccess,list,next){
                    point = list;
                    providers.put({type:"savePoint"},$scope.pnt,function(data){
                        $scope.pnt.id = data.id;

                        point.moneda_id = $scope.pnt.coin;
                        point.prov_id = $scope.pnt.id_prov;
                        point.costo = $scope.pnt.cost;
                        point.linea_id = $scope.pnt.line;
                        point.moneda = $filter("filterSearch")($scope.coins,[$scope.pnt.coin])[0];
                        point.linea = $filter("filterSearch")($scope.lines,[$scope.pnt.line])[0];
                        if(data.action=="new"){
                            point.id = $scope.pnt.id;
                            $scope.points.unshift(point);
                            setNotif.addNotif("ok", "nuevo valor del punto guardado", [
                            ],{autohidden:3000});

                        }else{
                            setNotif.addNotif("ok", "Punto Actualizado", [
                            ],{autohidden:3000});
                        }
                        currentOrig = {};
                        setGetProv.addChng($scope.pnt,data.action,"point");
                        onSuccess();
                    });
                }
            }
        );


    };

    $scope.rmPoint = function(elem){
        setNotif.addNotif("alert", "desea Borrar este Punto para este proveedor", [
            {
                name: "SI",
                action: function () {
                    point = elem.point;
                    providers.put({type:"delPoint"},point,function(data){
                        setGetProv.addChng($scope.pnt,data.action,"point");
                        $scope.points.splice(elem.$index,1);
                        $scope.pnt = {id: false, cost: "", coin: "", line:"", id_prov: $scope.prov.id};
                        $scope.ctrl.searchLine = undefined;
                        $scope.ctrl.searchCoin = undefined;
                        $scope.provPoint.$setUntouched();
                        $scope.provPoint.$setPristine();
                        point = {};
                        setNotif.addNotif("ok", "punto Borrado", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(element){
        //point = element.point;
        savePoint(function(point){
            $scope.pnt.id = point.id;
            $scope.pnt.coin = point.moneda_id;
            $scope.pnt.id_prov = point.prov_id;
            $scope.pnt.cost = point.costo;
            $scope.pnt.line = point.linea_id;
            $scope.ctrl.coin = point.moneda;
            $scope.ctrl.line = point.linea;
            currentOrig = angular.copy($scope.pnt);
            setGetProv.addToRllBck($scope.pnt,"factConv")
        },element.point)

    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.target).parents("#lyrAlert").length==0) {

            if(!elem) {
                savePoint(function(){
                    $scope.pnt = {id: false, cost: "", coin: "", line:"", id_prov: $scope.prov.id};

                    point = {};
                    currentOrig = {};
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                    $timeout(function(){
                        $scope.ctrl.searchLine = undefined;
                        $scope.ctrl.searchCoin = undefined;
                        $scope.provPoint.$setUntouched();
                        $scope.provPoint.$setPristine();
                    },500)
                })

            }else{
                if(!$scope.isShow){
                    $scope.pnt.line = 0;
                }
            }
            $scope.isShow = elem;
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"provPointController":false;
    };
});

MyApp.controller('prodTimeController', function ($scope,providers,setGetProv,masterLists,$filter,setNotif,$timeout,saveForm) {
    $scope.id = 'prodTimeController';
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.$watch('prov.id',function(nvo){
        $scope.tp = {id:false,from:"",to:"",line:"",id_prov: $scope.prov.id};
        $scope.timesP = setGetProv.getProdTime();//(nvo)?providers.query({type:"prodTimes",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('timesP.length',function(nvo){
        setGetProv.setComplete("timesP",nvo);
    });
    var time = {};
    var currentOrig = {};

    var saveTimeProd = function(onSuccess,elem){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.timeProd,
                model:$scope.tp,
                list:time,
                save:function(onSuccess,list,next){
                    time = list;
                    providers.put({type:"saveProdTime"},$scope.tp,function(data){
                        $scope.tp.id = data.id;
                        $scope.timeProd.$setPristine();
                        time.min_dias = $scope.tp.from;
                        time.max_dias = $scope.tp.to;
                        time.linea_id = $scope.tp.line;
                        time.lines =  $filter("filterSearch")($scope.lines,[$scope.tp.line])[0];
                        if(data.action=="new"){
                            time.id = $scope.tp.id;
                            $scope.timesP.unshift(time);
                            setNotif.addNotif("ok", "nuevo tiempo de produccion", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "tiempo de produccion actualizado", [
                            ],{autohidden:3000});
                        }
                        setGetProv.addChng($scope.tp,data.action,"timeProd");
                        onSuccess(next);
                    });
                }
            }
        );
        /*if((angular.equals(currentOrig,$scope.tp) && $scope.tp ) || ($scope.timeProd.$pristine )){
            onSuccess();
            return false;
        }

        if(!$scope.timeProd.$valid && !$scope.timeProd.$pristine){
            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??",[{
                name:"descartalos",
                action:function(){
                    onSuccess();
                }
            },{
                name:"dejame Corregirlos",
                action:function(){
                    //console.log($scope.timeProd);
                }
            }]);
            return false;
        }

        providers.put({type:"saveProdTime"},$scope.tp,function(data){
            $scope.tp.id = data.id;
            $scope.timeProd.$setPristine();
            time.min_dias = $scope.tp.from;
            time.max_dias = $scope.tp.to;
            time.linea_id = $scope.tp.line;
            time.lines =  $filter("filterSearch")($scope.lines,[$scope.tp.line])[0];
            if(data.action=="new"){
                time.id = $scope.tp.id;
                $scope.timesP.unshift(time);
                setNotif.addNotif("ok", "nuevo tiempo de produccion", [
                ],{autohidden:3000});
            }else{
                setNotif.addNotif("ok", "tiempo de produccion actualizado", [
                ],{autohidden:3000});
            }
            setGetProv.addChng($scope.tp,data.action,"timeProd");
            onSuccess();
        });*/
    };

    $scope.toEdit = function(element){
        //time = element.time;
        saveTimeProd(function(){
            $scope.tp.id = time.id;
            $scope.tp.id_prov = time.prov_id;
            $scope.tp.from = time.min_dias;
            $scope.tp.to = time.max_dias;
            $scope.tp.line = time.linea_id;
            currentOrig = angular.copy($scope.tp);
            setGetProv.addToRllBck($scope.tp,"timeProd")
        },element.time)

    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.target).parents("#lyrAlert").length==0){

            if(!elem){
                saveTimeProd(function(){
                    $scope.tp = {id:false,from:"",to:"",line:"",id_prov: $scope.prov.id};
                    time = {};
                    currentOrig = {};

                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                    $timeout(function(){
                        $scope.ctrl.searchLine = undefined;

                        $scope.timeProd.$setPristine();
                        $scope.timeProd.$setUntouched();
                    },500)

                })

            }else{
                if(!$scope.isShow){
                    $scope.tp.line = 0;
                }
            }
            $scope.isShow = elem;
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"prodTimeController":false;
    };
});

MyApp.controller('transTimeController', function ($scope,providers,setGetProv,$filter,masterLists,setNotif,$timeout,saveForm) {
    $scope.id="transTimeController";
    $scope.prov = setGetProv.getProv();
    var paises = masterLists.getCountries();
    $scope.$watch('prov.id',function(nvo){
        $scope.ttr = {id:false,from:"",to:"",line:"",country:"",id_prov: $scope.prov.id||0};
        $scope.provCountries =(nvo)?providers.query({type:"provCountries",id_prov:$scope.prov.id||0}):[];
        $scope.timesT =  setGetProv.getTransTime();
    });
    $scope.$watch('timesT.length',function(nvo){
        setGetProv.setComplete("timesT",nvo);
    });
    var time = {};
    var currentOrig = {};
    var exeption = false;
    var saveTimeTrans = function(onSuccess,elem){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.timeTrans,
                model:$scope.ttr,
                list:time,
                save:function(onSuccess,list,next){
                    time = list;
                    providers.put({type:"saveTransTime"},$scope.ttr,function(data){
                        $scope.ttr.id = data.id;
                        $scope.timeTrans.$setPristine();
                        time.min_dias = $scope.ttr.from;
                        time.max_dias = $scope.ttr.to;
                        time.id_pais = $scope.ttr.country;
                        time.country =  $filter("filterSearch")(paises,[$scope.ttr.country])[0];
                        if(data.action=="new"){
                            time.id = $scope.ttr.id;
                            $scope.timesT.unshift(time);
                            setNotif.addNotif("ok", "nuevo tiempo de Transito", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "se ha actualizado el Tiempo de Transito", [
                            ],{autohidden:3000});
                        }
                        setGetProv.addChng($scope.ttr,data.action,"timeTrans");
                        onSuccess(next);

                    });
                }
            }
        );

    };

    $scope.toEdit = function(element){
        saveTimeTrans(function (){
            $scope.ttr.id = time.id;
            $scope.ttr.id_prov = time.prov_id;
            $scope.ttr.from = time.min_dias;
            $scope.ttr.to = time.max_dias;
            $scope.ttr.country = time.id_pais;
            currentOrig = angular.copy($scope.ttr);
            setGetProv.addToRllBck($scope.ttr,"timeTrans")
        },element.time)

    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.target).parents("#lyrAlert").length==0){
            $scope.isShow = elem;
            if(!elem){
                saveTimeTrans(function(){
                    $scope.ttr = {id:false,from:"",to:"",line:"",country:"",id_prov: $scope.prov.id};
                    time = {};
                    currentOrig = {};
                    exeption = false;

                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    };
                    $timeout(function(){
                        $scope.ctrl.searchCountry = undefined;
                        $scope.timeTrans.$setPristine();
                        $scope.timeTrans.$setUntouched();
                    },500)
                });

            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"transTimeController":false;
    };

});

MyApp.service("setgetCondition",function(){
    var title = {id_cond:"",title:"",line:""};
    var form = null;

    return {
        getTitle:function(){
            return title;
        },
        getForm : function(){
          return form;
        },
        setTitle:function(cond,frm){
            title.id = cond.id;
            title.title = cond.title;
            //title.line = cond.line.linea;
            title.items = cond.items;
            form = frm;
        }
    }
});

MyApp.controller('condPayList', function ($scope,$mdSidenav,masterLists,setGetProv,providers,$filter,setgetCondition,setNotif,$timeout,saveForm) {
    $scope.id="condPayList";
    $scope.lines = masterLists.getLines();
    $scope.prov = setGetProv.getProv();
    $scope.setting = false;
    $scope.$watch('prov.id',function(nvo) {
        $scope.condHead = {id:false,title:"",line:"",items:[],id_prov:$scope.prov.id||0};
        $scope.conditions = setGetProv.getPayCond();//(nvo)?providers.query({type:"payConditions",id_prov:$scope.prov.id}):[];
    });

   /* $scope.$watch('ctrl.line.id',function(nvo) {
        $scope.condHead.line = nvo;
    });*/
    $scope.openFormCond = function(e){
        console.log(e);
        if((e.isTrigger && $scope.condHead.items.length>0 &&  $scope.condHeadFrm.$pristine)|| e.keyCode==13){
            if(e.isTrigger){
                angular.element(":focus").blur();
                angular.element("form[name='condHeadFrm']").find("[step]").last().focus();
            }
           return false;
        }else{
            setgetCondition.setTitle($scope.condHead,$scope.condHeadFrm);
            $scope.$parent.openPopUp("payCond")
        }

    };
    var cond = {};
    var currentOrig = {};
    //var auxItem = 0;
    var saveConvHead = function(onSuccess,elem){

        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.condHeadFrm,
                model:$scope.condHead,
                list:cond,
                valid:function(){
                    //console.log($scope.condHead.items)
                    return $scope.condHead.items.length>0
                },
                save:function(onSuccess,list,next){
                    contact = list;
                    providers.put({type:"saveHeadCond"},$scope.condHead,function(data){
                        $scope.condHead.id = data.id;
                        $scope.condHeadFrm.$setPristine();
                        var auxItem = $filter("filterSearch")(cond.items||[],[false]);
                        for(i=0; i>auxItem.length;i++){
                            auxItem[i].id=data.items[i];
                        }
                        cond.id = $scope.condHead.id;
                        cond.titulo = $scope.condHead.title;
                        cond.linea_id = $scope.condHead.line;
                        cond.prov_id = $scope.condHead.id_prov;
                        cond.line =  $filter("filterSearch")($scope.lines,[$scope.condHead.line])[0];
                        if(data.action=="new"){
                            $scope.conditions.unshift(cond);
                            setNotif.addNotif("ok", "nueva condicion de pago", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "Datos Actualizados", [
                            ],{autohidden:3000});
                        }
                        setGetProv.addChng($scope.condHead,data.action,"payCond");
                        onSuccess(next)
                    });
                }
            }
        );
        /*var next = elem || false;
        if((angular.equals(currentOrig,$scope.condHead) && $scope.condHead.id) || ($scope.condHeadFrm.$pristine )){
            onError(next);
            return false;
        }

        if(!$scope.condHeadFrm.$valid && !$scope.condHeadFrm.$pristine){
            $scope.$parent.block="wait";
            var prefocus = angular.element(":focus");
            $timeout(function(){
                angular.element("[name='condHeadFrm']").click();
                $timeout(function(){
                    angular.element(":focus").blur();
                })

            },0);

            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??",[{
                name:"descartalos",
                action:function(){
                    $scope.$parent.block="go"
                    onError(next);
                    $timeout(function(){
                        prefocus.click();
                        prefocus.focus();
                    },10)
                }
            },{
                name:"dejame Corregirlos",
                action:function(){
                    $scope.$parent.block="reject";
                    angular.element("[name='condHeadFrm']").find(".ng-invalid").first().focus()
                }
            }]);
            return false;
        }

        if($scope.condHeadFrm.$valid && !$scope.condHeadFrm.$pristine){
            providers.put({type:"saveHeadCond"},$scope.condHead,function(data){
                $scope.condHead.id = data.id;
                $scope.condHeadFrm.$setPristine();
                cond.id = $scope.condHead.id;
                cond.titulo = $scope.condHead.title;
                cond.linea_id = $scope.condHead.line;
                cond.prov_id = $scope.condHead.id_prov;
                cond.line =  $filter("filterSearch")($scope.lines,[$scope.condHead.line])[0];
                if(data.action=="new"){
                    $scope.conditions.unshift(cond);
                    setNotif.addNotif("ok", "nueva condicion de pago", [
                    ],{autohidden:3000});
                }else{
                    setNotif.addNotif("ok", "Datos Actualizados", [
                    ],{autohidden:3000});
                }
                setGetProv.addChng($scope.condHead,data.action,"payCond");
                onSuccess(next)
            });

        }else{

        }
*/
    };

/*    $scope.endLayer = function(nextfn,elem){
        saveConvHead(  $scope.condHead = {id:false,title:"",line:"",id_prov:$scope.prov.id||0};
            $scope.ctrl.searchLine = "";
            cond = {};
            currentOrig = {};
            $scope.condHeadFrm.$setUntouched();
            if($scope.$parent.expand==$scope.id){
                $scope.isShowMore = false;
                $scope.$parent.expand = false;
            }
            nextfn(elem);
        },elem)

    };*/


    $scope.rmCond = function(elem){
        setNotif.addNotif("alert", "desea Borrar toda esta Condicion de pago", [
            {
                name: "SI",
                action: function () {
                    cond = elem.condition;
                    providers.put({type:"delCondition"},cond,function(data){
                        $scope.conditions.splice(elem.$index,1);
                        $scope.condHead = {id:false,title:"",line:"",id_prov:$scope.prov.id||0};
                        cond = {};
                        $scope.condHeadFrm.$setUntouched();
                        setNotif.addNotif("ok", "Condicion Borrada", [
                        ],{autohidden:3000});
                        $scope.ctrl.searchLine = undefined;
                        $scope.condHeadFrm.$setUntouched();

                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(element){
        //$scope.setting = true;
        saveConvHead(function(condit){
            console.log(condit)
            cond = condit;
            $scope.condHead.id = cond.id;
            $scope.condHead.id_prov = cond.prov_id;
            $scope.condHead.title = cond.titulo;
            $scope.condHead.line = cond.linea_id;
            $scope.condHead.items = cond.items;
            $scope.ctrl.line = cond.line;
            currentOrig = angular.copy($scope.condHead);
            setGetProv.addToRllBck($scope.condHead,"payCond")
            $timeout(function(){$scope.setting=false;},500)
        },element.condition);

    };

    $scope.showGrid = function(elem,event){
        //if((jQuery(event.target).parents("#payCond").length==0) && (jQuery(event.target).parents("#lyrAlert").length==0)){
            if(!elem){
                saveConvHead(function() {
                    //$scope.setting = true;
                    $scope.condHead = {id: false, title: "", line: "",items:[], id_prov: $scope.prov.id || 0};
                    cond = {};
                    currentOrig = {};
                    $scope.condHeadFrm.$setUntouched();
                    if ($scope.$parent.expand == $scope.id) {
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                    $timeout(function(){
                        $scope.ctrl.searchLine = undefined;
                        $scope.condHeadFrm.$setUntouched();
                        $scope.condHeadFrm.$setPristine();
                        //$timeout(function(){$scope.setting=false;},500)
                    },500)
                })

            }else{
                if(!$scope.isShow){
                    //$scope.setting = true;
                    $scope.condHead.title = $scope.conditions.length+1;
                    //$scope.ctrl.line = $filter("filterSearch")($scope.lines,["0"])[0];
                    //$timeout(function(){$scope.setting=false;},500)
                }


            }
            $scope.isShow = elem;
        //}
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"condPayList":false;
    };
});

MyApp.controller('payCondItemController', function ($scope,providers,setGetProv,$filter,$mdSidenav,setgetCondition,setNotif,$timeout) {
    $scope.closeCondition = function(){

        $scope.$parent.closePopUp("payCond",{
            before:function(){
                var x = $scope.max == 0;
                if(!x){
                    setNotif.addNotif("error","los items no suman un 100% en total",[]);
                    angular.element("[name='itemCondForm']").find("step").first().focus();
                }
                return x;
            },
            after:function(){
                console.log(angular.element("form[name='condHeadFrm']").find("[step]").last())
                angular.element("form[name='condHeadFrm']").find("[step]").last().focus();
            }
        })
       // $mdSidenav("payCond").close().then();
    };
    $scope.head = setgetCondition.getTitle();

    $scope.$watch('head.title',function(nvo) {
        $scope.condItem = {id:false,days:"",percent:"",condit:"",id_head:$scope.head.id||0};
        $scope.conditions = $scope.head.items || [];
        $scope.formHead = setgetCondition.getForm();
        calcMax();
    });


    var item = {};
/*    $scope.$watchGroup(['itemCondForm.$valid','itemCondForm.$pristine'], function(nuevo) {
        if (nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveItemCond"},$scope.condItem,function(data){
                $scope.condItem.id = data.id;
                $scope.itemCondForm.$setPristine();
                item.porcentaje = $scope.condItem.percent;
                item.dias = $scope.condItem.days;
                item.descripcion =  $scope.condItem.condit;
                calcMax();
                if(data.action=="new"){
                    item.id = $scope.condItem.id;
                    $scope.conditions.unshift(item);
                    setNotif.addNotif("ok", "nuevo Item cargado", [
                    ],{autohidden:3000});
                }
            });
        }
    });*/



    var calcMax = function(){
        $scope.max = 100;
        angular.forEach($scope.conditions,function(v,k){
            //if($scope.condItem.dias != v.days){
                console.log("entr",v.porcentaje)
                $scope.max-= parseFloat(v.porcentaje);
            //}
        });
        //$scope.maxconsole.log( $scope.max )
        //$scope.max = max;
        //return max;
    };

    $scope.toEdit = function(element){
        item = element.condition;
        $scope.condItem.modif = true;
        $scope.condItem.id = item.id;
        $scope.condItem.days = item.dias;
        $scope.condItem.percent = parseFloat(item.porcentaje);
        $scope.condItem.condit = item.descripcion;
        //$scope.condItem.id_head = $scope.head.id;
        calcMax();
    };

    $scope.showInterGrid = function(elem,event){
        if((jQuery(event.target).parents("#lyrAlert").length==0)){
            if(!elem){
                $scope.condItem = {id:false,days:"",percent:0.00,condit:"",id_head:$scope.head.id||0};
                item = {};
                $scope.itemCondForm.$setUntouched();
                calcMax();
            }
        }
    }

    $scope.endLayer = function(callFn){


            if($scope.itemCondForm.$valid && $scope.itemCondForm.$dirty){
                console.log($scope.formHead.$setDirty())
                $scope.formHead.$setDirty();
                item.id = $scope.condItem.id;
                item.porcentaje = $scope.condItem.percent;
                item.dias = $scope.condItem.days;
                item.descripcion =  $scope.ctrl.cond.name;
                item.id_condicion = $scope.condItem.condit;
                if(!$scope.condItem.modif){
                    $scope.conditions.unshift(item);
                    setNotif.addNotif("ok", "nuevo Item cargado", [
                    ],{autohidden:3000});
                }else{
                    setNotif.addNotif("ok", "item modificado", [
                    ],{autohidden:3000});
                }
                $scope.condItem = {id:false,days:"",percent:"",condit:"",id_head:$scope.head.id||0};
                $scope.ctrl.searchCond=undefined;
                item = {};
                calcMax();

                $scope.itemCondForm.$setPristine();
                $scope.itemCondForm.$setUntouched();
                console.log($scope.max)
                $timeout(function(){
                    if($scope.max==0){
                        $scope.closeCondition();
                    }else{
                        angular.element("#condItemPerc").focus();
                    }
                },500)


            }else{
                setNotif.addNotif("error", "los datos son invalidos", [
                ],{autohidden:3000});
                if($scope.itemCondForm.$dirty){
                    angular.element("[name='itemCondForm']").find(".ng-invalid").first().focus();
                }else{
                    angular.element("#condItemPerc").focus();
                }

            }


    }
});

MyApp.controller('priceListController',function($scope,$mdSidenav,setGetProv,providers,filesService,setNotif,saveForm ){
    $scope.id="priceListController";
    filesService.setFolder("prov");
    $scope.openAdj = function(e){
        if(e.keyCode==32 || e.type=="click"){
            filesService.open();
        }

    }

    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.lp = {id:false,ref:"",idProv: $scope.prov.id||0,adjs:[]};
        $scope.lists = setGetProv.getListPrice();
    });

    $scope.fileProcces = filesService.getProcess();

    $scope.$watch('fileProcces.estado', function() {//console.log($scope.fileProcces);
        recents = [];
        if($scope.fileProcces.estado=="finished"){
            var aux = [];
            recents = filesService.getRecentUpload();
            recents.forEach(function(v,k){
                aux.push(v.id);
                list.files.push(v);
            });
            $scope.lp.adjs = $scope.lp.adjs.concat(aux);
            $scope.provPrecList.$setDirty();
        }
    });


    $scope.$watch('$parent.enabled',function(nvo) {
        filesService.setAllowUpload(!nvo);
    });

    var list = {files:[]};
    var currentOrig = {};
    $scope.toEdit = function(ls){
        list = ls.add;
        $scope.lp.id = list.id;
        $scope.lp.ref = list.referencia;
        $scope.lp.adjs = [];
        angular.forEach(list.files,function(v,k){
            $scope.lp.adjs.push(v.id);
        });
        filesService.setFiles(list.files)
        currentOrig = angular.copy($scope.lp);
        setGetProv.addToRllBck($scope.lp,"priceList")
    };

    var saveList = function(onSuccess,elem){
        saveForm.execute(
            {
                orig:currentOrig,
                success:onSuccess,
                elem:elem,
                form:$scope.provPrecList,
                model:$scope.lp,
                list:list,
                save:function(onSuccess,list,next){
                    list = list;
                    providers.put({type:"savePriceList"},$scope.lp,function(data){
                        $scope.lp.id = data.id;
                        list.referencia=$scope.lp.ref;
                        if(data.action=="new"){
                            list.id = $scope.lp.id;
                            $scope.lists.unshift(list);
                            setNotif.addNotif("ok", "lista de precios cargada", [
                            ],{autohidden:3000});
                        }else{
                            setNotif.addNotif("ok", "se modifico la lista de precios", [
                            ],{autohidden:3000});
                        }
                        setGetProv.addChng($scope.lp,data.action,"priceList");
                        onSuccess();
                    });
                }
            }
        );

        /*if((angular.equals(currentOrig,$scope.lp) && $scope.lp ) || ($scope.provPrecList.$pristine )){
            onSuccess();
            return false;
        }

        if(!$scope.provPrecList.$valid && !$scope.provPrecList.$pristine){
            $scope.$parent.block="wait";
            var prefocus = angular.element(":focus");
            $timeout(function(){
                angular.element("[name='condHeadFrm']").click();
                $timeout(function(){
                    angular.element(":focus").blur();
                })

            },0);

            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??",[{
                name:"descartalos",
                action:function(){
                    $scope.$parent.block="go"
                    onError();
                    $timeout(function(){
                        prefocus.click();
                        prefocus.focus();
                    },10)
                }
            },{
                name:"dejame Corregirlos",
                action:function(){
                    $scope.$parent.block="reject";
                    angular.element("[name='provPrecList']").find(".ng-invalid").first().focus()
                }
            }]);
            return false;
        }

        providers.put({type:"savePriceList"},$scope.lp,function(data){
            $scope.lp.id = data.id;
            list.referencia=$scope.lp.ref;
            if(data.action=="new"){
                list.id = $scope.lp.id;
                $scope.lists.unshift(list);
                setNotif.addNotif("ok", "lista de precios cargada", [
                ],{autohidden:3000});
            }else{
                setNotif.addNotif("ok", "se modifico la lista de precios", [
                ],{autohidden:3000});
            }
            setGetProv.addChng($scope.lp,data.action,"priceList");
            onSuccess();
        });*/
    };



    $scope.showGrid = function(elem,event){

        if((jQuery(event.target).parents("#lyrAlert").length==0) && (jQuery(event.target).parents(".popUp").length==0) && !jQuery(event.target).is("[type='file']")) {
            if(!elem) {
               /* if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }*/
                saveList(function(){
                    $scope.lp = {id:false,ref:"",idProv: $scope.prov.id||0,adjs:[]};
                    list={files:[]};
                    currentOrig = {};
                    $scope.provPrecList.$setPristine();
                    $scope.provPrecList.$setUntouched();
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }
                })

            }else{
                /*if(!$scope.isShow){
                    $scope.bnk.bankBenef = $scope.prov.description;
                }*/
            }
            $scope.isShow = elem;
        }
    };
    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"priceListController":false;
    };

});

MyApp.controller('newCoinController',function($scope,setGetProv,providers,masters,setNotif,masterLists){
    $scope.coins =masterLists.getAllCoins();
    $scope.newCoin = {id:false,name:"",code:"",usd:""};

    var saveNewCoin = function(e){
        if(!$scope.newCoinForm.$valid && !$scope.newCoinForm.$pristine){
            var prefocus = angular.element(":focus");

            $timeout(function(){
                angular.element("[name='newCoinForm']").click();
                $timeout(function(){
                    angular.element(":focus").blur();
                })

            },0);
            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??",[{
                name:"descartalos",
                action:function(){
                    onSuccess();
                    $timeout(function(){
                        prefocus.click();
                        prefocus.focus();
                    },10)

                }
            },{
                name:"dejame Corregirlos",
                action:function(){
                    angular.element("[name='newCoinForm']").find(".ng-invalid").first().focus()
                }
            }]);
            return false;
        }
        masters.post({type:"newCoin"},$scope.newCoin,function(resp){
            if(resp.action=="new"){
                $scope.coins.unshift({id:resp.id,nombre:$scope.newCoin.name,codigo:$scope.newCoin.code,precio_usd:$scope.newCoin.usd});
                $scope.newCoin = {id:false,name:"",code:"",usd:""};
                setNotif.addNotif("ok", "Moneda Creada!!", [
                ],{autohidden:3000});
                $scope.$parent.closePopUp('newCoin')
                angular.element("#selCoin").focus().click();
            }
        });
    };

    $scope.endLayer = saveNewCoin;
});

MyApp.controller('resumenProvFinal', function ($scope,providers,setGetProv,$filter,$mdSidenav,setgetCondition,setNotif,masterLists,$timeout,masters) {
     $scope.provider = setGetProv.getProv();
     $scope.prov = setGetProv.getChng();
     var foraneos = Object();
     foraneos.typeDir = masterLists.getTypeDir();
     foraneos.countries = masterLists.getCountries();
     foraneos.ports = masterLists.getPorts();
     foraneos.coins = masterLists.getAllCoins();
     foraneos.lines = masterLists.getLines();
     foraneos.depsValcroName = [
         {
             id:"1",
             icon:"icon-CarritoCompra"
         },
         {
             id:"2",
             icon:"icon-Aereo"
         },
         {
             id:"3",
             icon:"icon-TransTerrestre"
         }
     ];


     $scope.getDato = function(id,find,field){
         if(id!=0){
             return $filter("filterSearch")(foraneos[find],[id])[0][field];
         }else{
             return [];
         }

     };

    $scope.checkSimil = function(elem,campo){
        var find = {
            table:"tbl_proveedor",
            campo:"razon_social",
            search:elem.datos[campo],
            provId : $scope.provider.id
        };
        return masters.post({type:"search"},find);
        //console.log(simil[$scope.provider.id]);

    };

    $scope.isEdit = {direccionesForm:true,nomvalcroForm:true,provContactosForm:true,bankInfoForm:true,provCred:true,provConv:true,provPoint:true};
    $scope.toForm = function(nvo){
       if(!$scope.isEdit[nvo]){
            setNotif.addNotif("alert", "desea regresar a este formulario",[{
                name:"llevame alli",
                action:function(){
                    goForm(nvo);
                    $scope.isEdit[nvo] = true;
                }
            },{
                name:"olvidalo",
                action:function(){
                    $scope.isEdit[nvo] = true;
                }
            }]);
        }else{
           setNotif.hideByContent("alert", "desea regresar a este formulario");
       }

    };

     $scope.has = function(obj){
         if(obj){
             return Object.keys(obj).length
         }else{
             return 0;
         }
     };

    var goForm = function(formName){
        $timeout(function(){
            angular.element("[name='"+formName+"']").find(".activeleft").click();
            $timeout(function(){
                angular.element("[name='"+formName+"']").find(".showMore").click();
            })
        },0)

    };
     //$scope.finalProv = $scope.dataProv.dataProv[parseInt($scope.prov.id)];
 });

MyApp.service("saveForm",function($timeout,providers,setGetProv,setNotif,$filter){
    var foreign = {
        currentOrig : {},
        onSuccess : null,
        onFail:null,
        elem:{},
        form:null,
        model:null,
        saveFn : null,
        valid: null,
        elList : {}
    };
    var block = false;
    var next = false;
    var genericSave = function() {
        next = foreign.elem || false;

        if ((angular.equals(foreign.currentOrig, foreign.model) && foreign.model.id ) || (foreign.form.$pristine )) {

            foreign.onSuccess(next);
            //}
            return false;
        }


        var isValid = (foreign.valid)?foreign.valid():true;

        console.log(foreign.form,isValid);

        if (!foreign.form.$valid && !foreign.form.$pristine || (!isValid && foreign.form.$dirty)) {
            var prefocus = angular.element(":focus");
            block = "wait";
            $timeout(function () {
                angular.element("[name='"+foreign.form.$name+"']").click();
                $timeout(function () {
                    angular.element(":focus").blur();
                })

            }, 0);
            console.log("falla",foreign.form.$name)
            setNotif.addNotif("alert", "los datos no son validos para guardarlos, que debo hacer??", [{
                name: "descartalos",
                action: function () {
                    block = "go";
                    if(foreign.onFail){
                        foreign.onFail(next);
                    }else{
                        foreign.onSuccess(next);
                    }
                    $timeout(function () {
                        if(!next){
                            prefocus.click();
                        }
                        prefocus.focus();
                    }, 10)
                    $timeout(function(){block=false;},400)
                }
            }, {
                name: "dejame Corregirlos",
                action: function () {
                    block = "reject";
                    angular.element("[name='"+foreign.form.$name+"']").find(".ng-invalid").first().focus();
                    $timeout(function(){block=false;},400)
                }

            }]);
            return false;



        }
        foreign.saveFn(foreign.onSuccess,foreign.elList,next);
    };

    return {
        execute:function(param){
            if(!block){
                foreign.currentOrig = param.orig;
                foreign.onSuccess = param.success;
                foreign.onFail = param.fail || null;
                foreign.elem = param.elem;
                foreign.form = param.form;
                foreign.model = param.model;
                foreign.saveFn = param.save;
                foreign.elList = param.list;
                foreign.valid = (param.valid)?param.valid:null;
                genericSave();
            }

        },

        isBlock : function(){
            return block;
        },
        setBlock:function(valor){
            block = valor;
        }
    }
});




