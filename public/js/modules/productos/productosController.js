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
        desc:""
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


MyApp.controller('prodSumary',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
    $scope.prod = productsServices.getProd();
    $scope.$watchCollection("prod",function(n,o){
        
    });

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

MyApp.controller('createProd',['$scope', 'setNotif','productos','productsServices','masterSrv',function ($scope, setNotif,productos,productsServices,masterSrv) {
    $scope.listProviders = productsServices.getProvs();
    $scope.lines = masterSrv.getLines();
    $scope.prod = productsServices.getToSavedProd();
console.log($scope.prod)
    $scope.$watch("prod.prov",function(n,o){

        if(n!=o){
            productsServices.setProvprod(n);
        }
    })

    $scope.saveProd = function(){
        if($scope.prodMainFrm.$pristine || $scope.prodMainFrm.$invalid){
            return false;
        }
      productos.put({type:"prodSave"},$scope.prod,function (data) {
          if(data.action == "new"){
              $scope.prod.id = data.id;
              setNotif.addNotif("ok","producto Creado",[],{autohidden:3000});
          }
      })
    };
    console.log("in scope",$scope.prod);
}]);

MyApp.controller('datCritProds',['$scope','$timeout', 'setNotif','productos','productsServices',function ($scope,$timeout, setNotif,productos,productsServices) {
    $scope.prod = productsServices.getToSavedProd();
    $scope.prodCrit = [];

    $scope.$watchCollection("prod",function(n,o){
        if(n.id && n.line && (n.line!=o.line)){
            //console.log($scope.prodCrit)
            $scope.prodCrit.splice(0,$scope.prodCrit.length);
            $timeout(function(){
                productos.query({ type:"getCriterio",id:n.line},function(data){
                    $scope.criteria = data;
                });
                //console.log($scope.prodCrit)
            },0);

        }

    });
    /*productos.query({ type:"getCriterio",id:5},function(data){
        $scope.criteria = data;
    });*/

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

