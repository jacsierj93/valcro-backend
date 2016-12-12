MyApp.factory('productos', ['$resource',function ($resource) {
        return $resource('productos/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.service("productsServices",function(criterios,mastersCrit,$filter){
    var prov ={};
    var prod = {id:false,datos:{}};
    return{
        setProvprod:function(item){
            prov.id = item.id;
            prov.razon_social = item.razon_social;
            prov.siglas = item.siglas;
            prov.tipo_id = item.tipo_id;
        },
        getProv:function(){
            return prov;
        },
        setProd:function(item){
            prod.id = item.id;
            prod.datos = item;
        },
        getProd : function(){
            return prod
        }

    }
})

MyApp.controller('listController',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
    $scope.listProvs = productos.query({type:'provsProds'});
    
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
        $scope.listByProv.data = productos.query({type:'prodsByProv',id:n.id});
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

MyApp.controller('createProd',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
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
        backgroundColor: '#ddd',
        lineColor: '#5cb7eb'
    }
}]);

MyApp.controller('datCritProds',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
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


MyApp.controller('mainProdController',['$scope', 'setNotif','productos','$mdSidenav',function ($scope, setNotif,productos,$mdSidenav) {
    $scope.nxtAction = null;
    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old){
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
    });
    $scope.addProd = function(){
        $scope.LayersAction({open:{name:"prodLayer3"}});
    };
    $scope.prevLayer = function(){
        $scope.LayersAction({close:true});
    };
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
        show : false
    };

    return {
      /*  setFn :function(fn){
            cfg.fn = fn;
        },*/
        getCfg : function(){
            return cfg;
        }
    }
})

