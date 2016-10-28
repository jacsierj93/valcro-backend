/**
 * Created by jacsiel on 04/10/16.
 */
MyApp.factory('criterios', ['$resource',
    function ($resource) {
        return $resource('criterio/:type/:id', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.controller('prodMainController',['$scope', 'setNotif','masters','$mdSidenav','critForm','criterios',function ($scope, setNotif, masters,$mdSidenav,critForm,criterios) {
    $scope.clicked = function(){
        $mdSidenav("layer0").open();
    };
    $scope.listLines = masters.query({ type:"prodLines"});
    $scope.fields = criterios.query({type:"fieldList"});
    $scope.tipos = criterios.query({type:"typeList"});
    $scope.critField = {
        id:false,
        line:null,
        type:null,
        field:null
    };

    $scope.createField = function(data,type){

    };
    $scope.opennext = function(){
        $mdSidenav("layer1").open();
    };
    $scope.addField= function(type){
        critForm.add(type);
    };

}]);

MyApp.service("critForm",function(criterios){
    var factory = criterios.query({ type:"getCriteria"});
    var listado = criterios.query({ type:"getCriteria"});
    return {
        add:function(datos){
            var nuevo = angular.copy(factory[datos]);
            nuevo.campo = listado.length+1
            listado.push(nuevo);
        },
        get:function(){
            return listado;
        }
    }
});




MyApp.controller('formPreview',['$scope', 'setNotif','masters','critForm',function ($scope, setNotif, masters,critForm) {
   $scope.criteria = critForm.get();
}]);

MyApp.directive('formPreview', function($http,$timeout) {
        return {
            link:function(scope,elem,attr){
                elem.find(">:not(["+attr.formPreview+"])").remove();
            },
            templateUrl: function(elem, attr) {
                return 'modules/productos/textForm';
            }
        };
});