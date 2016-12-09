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


MyApp.controller('mainProdController',['$scope', 'setNotif','productos','$mdSidenav',function ($scope, setNotif,productos,$mdSidenav) {
    $scope.nxtAction = null;
    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old){
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
    });
    $scope.showNext = function(status,to){
        if(status){
            $scope.nxtAction = to;
            $mdSidenav("NEXT").open()
        }else{
            $mdSidenav("NEXT").close()
        }
    };
    $scope.prevLayer = function(){
        $scope.LayersAction({close:true});
    };
}]);

/*MyApp.directive('showNext', function() {

    return {
        replace: true,
        transclude: true,
        scope:{
            nextFn:"=?onNext",
            nextValid:"=?valid"
        },
        controller:function($scope,$mdSidenav,nxtService){
            if(!("onNext" in  $scope)){
                $scope.onNext = ($scope.$parent)
            }
            if(!("nextValid" in  $scope)){
                $scope.nextValid = true;
            }
            $scope.show = function(status){
                if($scope.nextValid){
                    if(status){
                        $mdSidenav("NEXT").open()
                    }else{
                        $mdSidenav("NEXT").close()
                    }
                }


            }
        },
        template: '<div class="showNext" style="width: 16px;" ng-mouseover="(checkValid())?$parent.showNext(true,saveDependency):showAlert()"> </div>'
    };
});*/

