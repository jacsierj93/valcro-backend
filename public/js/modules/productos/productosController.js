MyApp.factory('productos', ['$resource',function ($resource) {
        return $resource('productos/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            filt: {method: 'POST', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);
MyApp.service("popUpService",function($mdSidenav){
    var actives = [];

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
                $mdSidenav(sideNav).open().then(function(){
                    serv.add(sideNav);
                    if(fn && fn.after){
                        fn.after();
                    }
                })
            }

        }
    }
})
MyApp.service("productsServices",function(masters,masterSrv,criterios,productos,mastersCrit,$filter){
    var providers = masterSrv.getProvs();
    var listProv = productos.query({type:'provsProds'});
    var prov ={};
    var bckup = null;

    var prod = {id:false,datos:{}};
    var extraList = {
        common:{
            data:[],
            filter:{},
            order:"id"
        }
    };
    var commonDetail = {
        linea:"",
        sublinea:"",
        codigo:"",
        descripcion:"",
        serial:"",
        id:false,
        parent:false,
        prod:false,
        comment:""
    }
    var prodToSave = {
        id:false,
        prov:false,
        line:false,
        serie:"",
        cod:"",
        desc:"",
        prodCrit:[]
    }
    
    
    return{
        getProvs:function(){
            return providers;
        },
        getAssign:function(){
            return listProv;
        },
        setProvprod:function(item){

            if(typeof(item)!="boolean" && typeof(item)!="object" ){
                item  = $filter("filterSearch")(providers,[item])[0];
            }
            prov.id = item.id;
            prov.razon_social = item.razon_social;
            prov.siglas = item.siglas;
            prov.tipo_id = item.tipo_id;
            prodToSave.prov = item.id || false;
        },
        getProv:function(){
            return prov;
        },
        setProd:function(item){

            prod.id = item.id;
            prod.datos = item;
            bckup = angular.copy(prod.datos);
            console.log(angular.equals(bckup,prod.datos,angular))
            prodToSave.id = item.id || false;
            prodToSave.prov = item.prov_id || false;
            prodToSave.line = item.linea_id || false;
            prodToSave.serie = item.serie || false;
            prodToSave.cod = item.codigo || false;
            prodToSave.desc = item.descripcion || false;
            extraList.common.data = prod.datos.commons;
        },
        syncProd : function(edit){
            prod.datos.id = edit.id || null;
            prod.datos.prov_id = edit.prov || null;
            prod.datos.linea_id = edit.line || null;
            prod.datos.serie = edit.serie || null;
            prod.datos.codigo = edit.cod || null;
            prod.datos.descripcion = edit.desc || null;
        },
        showChange:function(){
            console.log(prod.datos,bckup,angular.equals(prod.datos,bckup));
        },
        getProd : function(){
            return prod
        },
        getDataCrit : function(){
            return prod.datos.prod_crit;
        },
        getToSavedProd:function(){
            return prodToSave;
        },
        getLists : function(){
            return extraList;
        },
        getCommon : function(){
            return commonDetail;
        }

    }
})

MyApp.controller('listProdController',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
    $scope.listProvs = {
        provs:productsServices.getProvs(),
        withpProv:productsServices.getAssign()
    }
    $scope.prov = productsServices.getProv();

    
    $scope.getByProv = function(prov,e){
        productsServices.setProvprod(prov);
        $scope.$parent.LayersAction({open:{name:"prodLayer1"}});
    };
}]);

MyApp.controller('gridAllController',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
    $scope.prov = productsServices.getProv();
    $scope.listByProv = {
        data:[],
        order:"id",
        filter:{}
    };
    $scope.$watchCollection("prov",function(n,o){
        $scope.listByProv.data = (n.id)?productos.query({type:'prodsByProv',id:n.id}):[];
    });

    $scope.testNext = function(){
        alert("yujuuu");
    };

    $scope.isValid = function(){
        return true;
    };

    $scope.openProd = function(prd){
        $scope.$parent.LayersAction({open:{name:"prodLayer2",before:function () {
            productsServices.setProd(prd);
        }}});
    }

}]);


MyApp.controller('prodSumary',['$scope', 'setNotif','productos','productsServices','$timeout',function ($scope, setNotif,productos,productsServices,$timeout) {
    $scope.prod = productsServices.getProd();


    $scope.brcdOptions = {
        width: 3,
        height: 40,
        displayValue: false,
        font: 'monospace',
        textAlign: 'center',
        fontSize: 15,
        backgroundColor: '#fff',
        lineColor: '#000'
    }
}]);

MyApp.controller('createProd',['$scope','$timeout', 'setNotif','productos','productsServices','masterSrv',function ($scope,$timeout, setNotif,productos,productsServices,masterSrv) {
    $scope.listProviders = productsServices.getProvs();
    $scope.lines = masterSrv.getLines();
    $scope.prod = productsServices.getToSavedProd();
    $scope.prodCrit = [];
    $scope.$criteria = [];
    $scope.$watch("prod.prov",function(n,o){
        $timeout(function(){
            if(typeof(n)== "undefined"){
                return false;
            }
            if(n!=o){
                productsServices.setProvprod(n);
            }
        },0)

    });
    $scope.$watch("prod.id",function(n,o){
        if(n){
            var data = productsServices.getDataCrit();
            $timeout(function(){
                angular.forEach(data,function(v,k){
                    $scope.prodCrit[v.crit_id].value = v.value;
                })

            },2000)
        }

    });
    $scope.$watchCollection("prod",function(n,o){
        if(n.line && (n.line!=o.line)){

                productos.query({ type:"getCriterio",id:n.line},function(data){
                    $scope.prodCrit.splice(0,$scope.prodCrit.length);
                    $timeout(function(){
                        $scope.criteria = data;
                    },0);
                });


        }

    });

    $scope.saveProd = function(){

        if($scope.prodMainFrm.$invalid || $scope.prodMainFrm.$invalid){
            return false;
        }
      $scope.prod.prodCrit = $scope.prodCrit;
      productos.put({type:"prodSave"},$scope.prod,function (data) {
          if(data.action == "new"){
              $scope.prod.id = data.id;
              productsServices.syncProd($scope.prod);
              setNotif.addNotif("ok","producto Creado",[],{autohidden:3000});
          }else if(data.action == "upd"){
              productsServices.syncProd($scope.prod);
              setNotif.addNotif("ok","se actualizaron los datos",[],{autohidden:3000});
          }

      })

        $scope.$parent.LayersAction({open:{name:"prodLayer4"}});
    };

    $scope.isValid = function(){
        if($scope.prodMainFrm.$invalid ||  $scope.prodCritFrm.$invalid){
            return false;
        }
        return true;
    }
}]);


MyApp.controller('mainProdController',['$scope', 'setNotif','productos','$mdSidenav','productsServices',function ($scope, setNotif,productos,$mdSidenav,productsServices) {
    $scope.nxtAction = null;
    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old){
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
    });

    $scope.openForm = function(id){
        $scope.LayersAction({open:{name:"prodLayer3"},before:function(){
            productsServices.setProd(id);
        }});
    };

    $scope.prevLayer = function(){
        $scope.LayersAction({close:true});
    };
    $scope.prod = productsServices.getToSavedProd();

    $scope.items = []
}]);
MyApp.controller('extraDataController',['$scope', 'setNotif','productos','$mdSidenav','productsServices','popUpService',function ($scope, setNotif,productos,$mdSidenav,productsServices,popUpService) {
    $scope.goToAnalisis = function () {
        productsServices.showChange();
        $scope.LayersAction({open:{name:"prodLayer5"}});
    };

    $scope.list = productsServices.getLists();

    $scope.editCommon = function(data){
        popUpService.popUpOpen({
            'prodComp':{
                before:function(){
                    var prod = productsServices.getCommon();
                    prod.linea = data.line.linea;
                    prod.codigo = data.codigo;
                    prod.descripcion = data.descripcion;
                    prod.serial = data.serial;
                    prod.id = data.pivot.id;
                    prod.parent = data.pivot.parent_prod;
                    prod.prod = data.pivot.comp_prod;
                    prod.comment = data.pivot.comentario;
                    return true;
                },
                after:null
            }
        })
    }

    $scope.delete = function(idx,dato){
        console.log(dato);
        setNotif.addNotif("error","va desvincular este producto del compuesto, esta seguro?",[
            {
                name:"Si, si lo estoy",
                action:function(){
                    productos.put({type:"prodDelCommon"},dato,function (data) {
                        setNotif.addNotif("ok","producto eliminado",[],{autohidden:3000});
                        //srch = $filter("filterSearch")($scope.list.common.data,[dato.id],"pivot.id");
                        $scope.list.common.data.splice(idx,1);
                    })
                },
                default:defaultTime
            },
            {
                name:"No, olvidalo",
                action:null
            }
        ]);
    }
    
    $scope.bef=function(data){
        var prod = productsServices.getCommon();
        prod.linea = "";
        prod.codigo = "";
        prod.descripcion = "";
        prod.serial = "";
        prod.id = false;
        prod.prod = false
        prod.comment = "";
        return true;

    };
    $scope.aft=function(){
        console.log("AFTER");

    }
}]);
MyApp.controller('addCompController',['$scope', 'setNotif','productos','$mdSidenav','productsServices','$timeout','masterSrv',"$filter",function ($scope, setNotif,productos,$mdSidenav,productsServices,$timeout,masterSrv,$filter) {
    $scope.prod = productsServices.getToSavedProd();
    $scope.lines = masterSrv.getLines();
    $scope.list = productsServices.getLists();
    $scope.filtCm = {
        line:false,
        sublin:false,
        desc:"",
        prod:false
    };
    $scope.prodDetail = productsServices.getCommon();

    $scope.$watch("prod.id",function(n,o){
        $scope.filtCm.prod = n;
        $scope.prodDetail.parent = n;
    });

    $scope.searching = false;

    $scope.filterLs = [];

    var timeOut = null;
    $scope.$watchCollection("filtCm",function(n,o){
        $scope.searching = true;
        $timeout.cancel(timeOut);
        if(n.line || n.sublin || n.desc != ""){
            timeOut = $timeout(function(){
                productos.filt({ type:"getFiltersProd"},n,function(data){
                    $scope.filterLs.splice(0,$scope.filterLs.length);
                    angular.forEach(data,function (v,k) {
                        $scope.filterLs.push(v);
                    });
                    $scope.searching = false;

                });
            },2000);
        }else{
            $scope.filterLs.splice(0,$scope.filterLs.length);
            $scope.searching = false;
        }

    });

    $scope.setDetail = function(dat){
        $scope.prodDetail.codigo = dat.codigo;
        $scope.prodDetail.descripcion = dat.descripcion;
        $scope.prodDetail.linea = dat.line.linea;
        $scope.prodDetail.serie = dat.serie;
        $scope.prodDetail.prod = dat.id;
    };

    var saveCommon = function(){
        productos.put({type:"prodSaveCommon"},$scope.prodDetail,function (data) {
            if(data.action == "new"){
                $scope.prodDetail.id = data.id;
                setNotif.addNotif("ok","producto Agregado",[],{autohidden:3000});
                $scope.list.common.data.push({
                    pivot:{
                        id:data.id,
                        common_id:$scope.prodDetail.prod,
                        parent_prod:$scope.prodDetail.parent
                    },
                    codigo:$scope.prodDetail.codigo,
                    descripcion:$scope.prodDetail.descripcion,
                    linea:{linea:$scope.prodDetail.codigo}
                })
            }else if(data.action == "upd"){
                setNotif.addNotif("ok","se actualizaron los datos",[],{autohidden:3000});
            }
        })
    };



    $scope.onClose = function(){

        if(($scope.filtCm.line || $scope.filtCm.sublin || $scope.filtCm.desc != "" ) && !$scope.prodDetail.prod){
            var ret = {wait : null};

            setNotif.addNotif("alert","ha realizado una busqueda, pero no selecciono nada, esta seguro?",[
                {
                    name:"Si, si lo estoy",
                    action:function(){
                       ret.wait=true;
                    },
                    default:defaultTime
                },
                {
                    name:"No, dejame cambiarlo",
                    action:function(){
                        ret.wait=false;
                    }
                }
            ]);
            return ret;
        }else if($scope.prodDetail.prod){
            saveCommon();
            return true;
        }else{
            return true;
        }

    }

}]);


MyApp.directive('showNext', function() {

    return {
        replace: true,
        transclude: true,
        scope:{
            nextFn:"=?onNext",
            nextValid:"=?valid"
        },
        controller:function($scope,$mdSidenav,nxtService,Layers){
            $scope.cfg = nxtService.getCfg();
            if(!("onNext" in  $scope)){
                $scope.onNext = ($scope.$parent)
            }
            if(!("nextValid" in  $scope)){
                $scope.nextValid = function(){return true};
            }

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
                if($scope.nextValid()){
                    $scope.cfg.show = true;
                    $scope.cfg.fn = $scope.nextFn;
                }
            }
        },
        template: '<div class="showNext" style="width: 16px;" ng-mouseover="show()"> </div>'
    };
});

MyApp.directive('nextRow', function() {

    return {

        scope:{

        },
        controller:function($scope,$mdSidenav,nxtService){
            $scope.cfg = nxtService.getCfg();
            $scope.nxtAction = function(e){
                $scope.cfg.fn();
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
});

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
})
    .directive('autoClose',function(popUpService,$mdSidenav,$compile,$interval){
    return {
        terminal: true, //this setting is important, see explanation below
        priority: 1000, //this setting is important, see explanation below

        link:function(scope,object,attr){
            scope.fn = scope.$eval(attr.autoClose);
            scope.sideNav = object.parents("md-sidenav").first().attr("md-component-id");

            scope.closer = function(){
                $mdSidenav(scope.sideNav).close().then(function(){
                    popUpService.remove(idx);
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
                                scope.closer();
                            }else if(pre.wait===false){
                                $interval.cancel(x);
                                return false;
                            }
                        },1000)
                    }else{
                        scope.closer();
                    }

                };
            };

            object.attr("click-out","close()")
            object.removeAttr("auto-close");
            $compile(object)(scope);
        },
    }
});


