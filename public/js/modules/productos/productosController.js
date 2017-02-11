MyApp.factory('productos', ['$resource',function ($resource) {
        return $resource('productos/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.service("productsServices",function(masters,masterSrv,criterios,productos,mastersCrit,$filter){
    var providers = masterSrv.getProvs();
    var listProv = productos.query({type:'provsProds'});
    var prov ={};
    var prod = {id:false,datos:{}};
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
            prodToSave.id = item.id || false;
            prodToSave.prov = item.prov_id || false;
            prodToSave.line = item.linea_id || false;
            prodToSave.serie = item.serie || false;
            prodToSave.cod = item.codigo || false;
            prodToSave.desc = item.descripcion || false;
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
        setSavedProd : function(){

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
              setNotif.addNotif("ok","producto Creado",[],{autohidden:3000});
          }else if(data.action == "upd"){
              setNotif.addNotif("ok","se actualizaron los datos",[],{autohidden:3000});
          }
      })

        $scope.$parent.LayersAction({open:{name:"prodLayer4"}});
    };

    $scope.isValid = function(){
        /*if($scope.prodMainFrm.$invalid ||  $scope.prodCritFrm.$invalid){
            return false;
        }*/
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
MyApp.controller('extraDataController',['$scope', 'setNotif','productos','$mdSidenav','productsServices',function ($scope, setNotif,productos,$mdSidenav,productsServices) {
    $scope.goToAnalisis = function () {
        $scope.LayersAction({open:{name:"prodLayer5"}});
    };
    $scope.bef=function(){
        console.log("BEFORE");

    }
    $scope.aft=function(){
        console.log("AFTER");

    }
}]);
MyApp.controller('addCompController',['$scope', 'setNotif','productos','$mdSidenav','productsServices','$timeout',function ($scope, setNotif,productos,$mdSidenav,productsServices,$timeout) {
    $scope.filtCm = {
        line:false,
        sublin:false,
        desc:""
    };

    var timeOut = null;
    $scope.$watchCollection("filtCm",function(n,o){
        if(n.line || n.sublin || n.desc != ""){
            $timeout.cancel(timeOut);
            timeOut = $timeout(function(){
                $timeout.cancel(timeOut);
                console.log("entro en el filtro");
                /*productos.query({ type:"getFiltersProd"},$scope.filtCm,function(data){

                    /!*$scope.prodCrit.splice(0,$scope.prodCrit.length);
                     $timeout(function(){
                     $scope.criteria = data;
                     },0);*!/
                });*/
            },2000);



        }else{
            $timeout.cancel(timeOut);
        }

    });
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

MyApp.service("popUpService",function(){
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
    .directive('autoClose',function(popUpService,$mdSidenav,$compile){
    return {
        terminal: true, //this setting is important, see explanation below
        priority: 1000, //this setting is important, see explanation below
        scope:{
            fn:"=autoClose"
        },
        link:function(scope,object,attr){
            scope.sideNav = attr.mdComponentId;
            scope.close = function(){
                idx = popUpService.exist(scope.sideNav);
                if(idx != -1){
                    if(scope.fn.before){
                        pre = scope.fn.before();
                    }else{
                        pre = true;
                    }

                    if(!pre){
                        return false;
                    }
                    $mdSidenav(scope.sideNav).close().then(function(){
                        popUpService.remove(idx);
                        if(scope.fn.after){
                            scope.fn.after();
                        }
                    });
                };
            };
             object.attr("click-out","close()")
             object.removeAttr("auto-close");
             $compile(object)(scope);
        },
    }
});


