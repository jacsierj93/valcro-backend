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

MyApp.service("mastersCrit",function(criterios,masters){
    var lists = {
        Lines : masters.query({ type:"prodLines"}),
        Fields : criterios.query({type:"fieldList"}),
        Types : criterios.query({type:"typeList"}),
    };
    return {
        getLines:function(){

            return lists.Lines;
        },
        getFields:function(){
            return lists.Fields;
        },
        getTypes:function(){
            return lists.Types;
        }
    }
});

MyApp.controller('prodMainController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios',function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios) {
    $scope.clicked = function(){
        $mdSidenav("layer0").open();
    };
    $scope.listLines = mastersCrit.getLines();
    $scope.fields = mastersCrit.getFields();
    $scope.tipos = mastersCrit.getTypes();
    $scope.critField = {
        id:false,
        line:1,
        type:null,
        field:null
    };
    $scope.options = [];
    $scope.opcValue = {};
    $scope.inicialize = function(obj){
        $scope.opcValue[obj.descripcion] = {
            descripcion:obj.descripcion,
            opc_id:obj.id,
            field_id:$scope.critField.id,
            id:false
        }

    };

    $scope.checkSave = function(){
        console.log($scope.optionsForm);
        console.log($scope.opcValue)
         saveOptions($scope.opcValue)
    };

    var saveOptions = function(datos){

        criterios.put({type:"saveOptions"},$scope.opcValue,function(data){
            console.log(data);

        });
    };
    
    $scope.createField = function(data,campo){
        if(campo == "type"){
            $scope.options = data.cfg;
        }

        $scope.critField[campo]=data.id;
        criterios.put({type:"save"},$scope.critField,function(data){
            $scope.critField.id = data.id;
            critForm.add($scope.critField);
        });
    };
    $scope.opennext = function(){
        $mdSidenav("layer1").open();
    };
    
    $scope.addField= function(type){
        critForm.add(type);
    };

}]);

MyApp.service("critForm",function(criterios,mastersCrit,$filter){

    var lines = mastersCrit.getLines();
    var fields = mastersCrit.getFields();
    var tipos = mastersCrit.getTypes();
    var listado = criterios.query({ type:"getCriteria"});
    var factory = {
        linea_id: "1",
        campo_id: "1",
        tipo_id: "2",
        line:{},
        field:$filter("filterSearch")(fields,[1])[0],
        type:$filter("filterSearch")(tipos,[2])[0],
        id:false
    };
    return {
        add:function(datos){
            var elem = {};
            elem = $filter("filterSearch")(listado,[datos.id])[0]
            if(!elem){
                elem = angular.copy(factory)
                listado.push(elem);
            }
            elem.id=datos.id;
            elem.linea_id=datos.line;
            elem.line = $filter("filterSearch")(lines,[datos.line])[0];
            elem.campo_id=datos.field;
            elem.field = $filter("filterSearch")(fields,[datos.field])[0];
            elem.tipo_id=datos.type;
            elem.type = $filter("filterSearch")(tipos,[datos.type])[0];
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
            /*link:function(scope,elem,attr){
                elem.find(">:not(["+attr.formPreview+"])").remove();
            },*/
            templateUrl: function(elem, attr) {
                return 'modules/productos/textForm';
            }
        };
});