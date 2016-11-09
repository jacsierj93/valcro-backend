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
        Lines : criterios.query({type:"avaiableLines"}),
        Fields : criterios.query({type:"fieldList"}),
        Types : criterios.query({type:"typeList"}),
        AvaiableLines :criterios.query({type:"avaiableLines"}),
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
        },
        getLinesDisp:function(){
            return lists.AvaiableLines;
        }
    }
});



MyApp.controller('listController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {
    $scope.listLines = mastersCrit.getLines();

    $scope.clicked = function(line){
        critForm.setLine(line);
        $mdSidenav("layer1").open();
    };
    $scope.curLine = critForm.getLine();
    $scope.filtAvaiable = function(c,v){
        console.log(c,v)
        return c.hasCrit == v;
    };

}]);

MyApp.controller('lineController',['$scope', 'setNotif','mastersCrit','$mdSidenav','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,criterios,$filter,$timeout) {
    $scope.newLine = {
        id:false,
        name:"",
        letter:""
    };

    $scope.list = mastersCrit.getLinesDisp();

    $scope.$watchGroup(['LineProd.$valid','LineProd.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            criterios.put({type:"createLine"},$scope.newLine,function(data){
                $scope.newLine.id = data.id;
                if(data.action=="new"){
                    $scope.listLines.push({
                        id:$scope.newLine.id,
                        linea:$scope.newLine.name,
                        siglas:$scope.newLine.letter
                    });
                }else{
                   var line = $filter("filterSearch")($scope.listLines ,[data.id])[0];
                    line.linea = $scope.newLine.name;
                    line.siglas = $scope.newLine.letter;
                }
            });
        }
    });
    
}]);

MyApp.controller('prodMainController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {

    $scope.newCrit = function(){
        $mdSidenav("layer0").open();
    };
    $scope.newLine = function(){

        $mdSidenav("layer2").open();
    };

    $scope.listLines = mastersCrit.getLines();
    $scope.line = critForm.getLine();
    $scope.fields = mastersCrit.getFields();
    $scope.tipos = mastersCrit.getTypes();
    $scope.critField = critForm.getEdit();

    $scope.opcValue =critForm.getOptions();
    $scope.inicialize = function(obj){
        $scope.opcValue[obj.descripcion] = {
            descripcion:obj.descripcion,
            opc_id:obj.id,
            field_id:$scope.critField.id,
            id:false,
            valor:''
        }

    };

    $scope.checkSave = function(){
        
         saveOptions($scope.opcValue)
    };

    var saveOptions = function(datos){

        criterios.put({type:"saveOptions"},$scope.opcValue,function(data){
            angular.forEach(data, function(value, key){
                if(key.match(/^[^\$]/g) && ("id" in value)) {
                    $scope.opcValue[key].id = value.id;
                }
            });

        });
    };

    $scope.$watch("critField.type",function(val){

        $scope.options = (val)?$filter("filterSearch")($scope.tipos ,[val])[0].cfg:[];
    });
    $scope.$watch("critField.id",function(val){
        $timeout(function(){
            angular.forEach($scope.critField.opcs,function(v,k){
                var key = v.descripcion;
                $scope.opcValue[key].id=v.pivot.id;
                $scope.opcValue[key].opc_id=v.pivot.opc_id;
                $scope.opcValue[key].field_id=v.pivot.lct_id;
                $scope.opcValue[key].valor=v.pivot.value;
            })
        },1000)

    });

    $scope.createField = function(data,campo){

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
    var curLine = {id:false};
    var options = {};
    var factory = {
        linea_id: "1",
        campo_id: "1",
        tipo_id: "2",
        line:{},
        field:$filter("filterSearch")(fields,[1])[0],
        type:$filter("filterSearch")(tipos,[2])[0],
        id:false
    };
    var edit = {
        id:false,
        line:null,
        type:null,
        field:null,
        opcs:[]
    };
    return {
        setLine:function(elem){
            curLine.id = elem.id;
        },
        getLine:function(){
            return curLine;
        },
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
            elem.opcs = elem.type.cfg;
        },
        get:function(){
            return listado;
        },
        setEdit:function(campo){
            edit.id = campo.id;
            edit.line = campo.linea_id;
            edit.field = campo.campo_id;
            edit.type = campo.tipo_id;
            edit.opcs = campo.options;

        },
        getEdit:function(){
            return edit;
        },
        getOptions:function () {
            return options;
        }

    }
});




MyApp.controller('formPreview',['$scope', 'setNotif','masters','critForm',function ($scope, setNotif, masters,critForm) {
    $scope.criteria = critForm.get();
    $scope.setEdit = function(campo){
        critForm.setEdit(campo);
    }
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