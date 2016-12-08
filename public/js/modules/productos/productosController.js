MyApp.factory('productos', ['$resource',function ($resource) {
        return $resource('productos/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.service("productsServices",function(criterios,mastersCrit,$filter){
    var prov ={
        id:false
    }
    return{
        setProvprod:function(item){
            prov = item
        },
        getProv:function(){
            return prov;
        }
    }
})

MyApp.controller('listController',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
    $scope.listProvs = productos.query({type:'provsProds'});
    
    $scope.getByProv = function(prov,e){
        
    }
}]);

MyApp.controller('gridAllController',['$scope', 'setNotif','productos',function ($scope, setNotif,productos) {
    $scope.prov = productsServices.getProv();
    $scope.$watchCollection("prov",function(n,o){
        $scope.listByProv = productos.query({type:'prodsByProv',id:n.id});
    })

}]);


MyApp.controller('mainProdController',['$scope', 'setNotif','productos',function ($scope, setNotif,productos) {

}]);
