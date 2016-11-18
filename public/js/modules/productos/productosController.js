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
        //Lines : masters.query({ type:"prodLines"}),
        Fields : criterios.query({type:"fieldList"}),
        Types : criterios.query({type:"typeList"}),
        AvaiableLines :criterios.query({type:"avaiableLines"}),
    };
    return {
        getLines:function(){
            return lists.AvaiableLines;
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
                    setNotif.addNotif("ok", "Nueva Linea Creada", [
                    ],{autohidden:3000});
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
    $scope.index = 2;
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
    $scope.listOptions = critForm.getOptions();
    //$scope.opcValue =critForm.getOptions();

    $scope.opcValue = {
        info: {
            opc_id: 8,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        req: {
            opc_id: 3,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        min: {
            opc_id: 2,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        max: {
            opc_id: 1,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        maxI: {
            opc_id: 7,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        minI: {
            opc_id: 6,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        opts: {
            opc_id: 4,
            field_id: $scope.critField.id,
            id: false,
            valor: [],
            msg: ''
        }
    };


    $scope.checkSave = function(e){
        var id = angular.element(e.currentTarget).parents(".optHolder").first().attr("id");
        if(angular.element(e.relatedTarget).parents("#"+id).length!=0){
           return false;
        }
        console.log("beforeSave",$scope.opcValue)
        saveOptions($scope.opcValue)
    };

    $scope.getoptSet = function(id){
        return $filter("filterSearch")($scope.listOptions ,[id])[0];
    };

    $scope.setOptSel = function(id){
        
        if(id){
            $scope.opcValue.opts.valor.unshift(id);
            $timeout(function(){$scope.ctrl.searchOpctions = null},0);
        }

    };

    var saveOptions = function(datos){

        criterios.put({type:"saveOptions"},$scope.opcValue,function(data){
            angular.forEach(data, function(value, key){
                if(key.match(/^[^\$]/g) && ("id" in value)) {
                    /*$.grep($scope.opcValue, function(e){
                       if(e.opc_id == value.opc_id){
                           e.id = value.id;
                           return true;
                       }
                    });
                    */
                    $scope.opcValue[key].id = value.id;
                    critForm.updOptions($scope.opcValue[key]);
                }
            });

        });
    };

    $scope.$watch("critField.type",function(val){
        $scope.options = (val)?$filter("filterSearch")($scope.tipos ,[val])[0].cfg:[];
    });
    $scope.$watch("critField.id",function(val){
        $timeout(function(){

            angular.forEach($scope.opcValue, function(value, key){
                value.field_id = val
                if(key!="opts"){
                    var v =  $filter("customFind")($scope.critField.opcs,[value.opc_id],function(c,v){
                        return c.pivot.opc_id == v[0];
                    })[0];

                    if(v){
                        value.id=v.pivot.id || false;
                        value.valor=v.pivot.value || "";
                        value.msg=v.pivot.message || "";
                    }
                }else{
                    angular.forEach($filter("filterSearch")($scope.critField.opcs,[value.opc_id]), function(valor, key){
                        value.valor.push(valor.id);
                    })
                }

            });
        },0)

    });

    $scope.createField = function(data,campo){
        $scope.critField[campo]=data.id;
        criterios.put({type:"save"},$scope.critField,function(data){
            $scope.critField.id = data.id;
            $scope.critField.ready = data.ready;
            critForm.add($scope.critField);
        });
    };
    $scope.opennext = function(){
        $mdSidenav("layer1").open();
    };
    
    $scope.addField= function(type){
        critForm.add(type);
    };
    
    $scope.createNewIten = function(nuevo){
        criterios.put({type:"saveNewItemList"},{name:nuevo},function(data){
            setNotif.addNotif("ok", "item creado", [
            ],{autohidden:3000});
           /* $scope.listOptions.push({
                id:data.id,
                nombre:nuevo
            });*/

        });
    }

}]);

MyApp.service("critForm",function(criterios,mastersCrit,$filter){

    var lines = mastersCrit.getLines();
    var fields = mastersCrit.getFields();
    var tipos = mastersCrit.getTypes();
    var listado = criterios.query({ type:"getCriteria"});
    var masterOptions = criterios.query({ type:"masterOptions"});
    var ListOptions = criterios.query({ type:"optionLists"});
    var curLine = {id:false};
    var factory = {
        linea_id: "1",
        campo_id: "1",
        tipo_id: "2",
        line:{},
        field:$filter("filterSearch")(fields,[1])[0],
        type:$filter("filterSearch")(tipos,[2])[0],
        id:false,
        ready:false
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
                elem = angular.copy(factory);
                listado.push(elem);
            }
            elem.id=datos.id;
            elem.ready = datos.ready;
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
            edit.id = campo.id || false;
            edit.line = campo.linea_id || curLine.id;
            edit.field = campo.campo_id || null;
            edit.type = campo.tipo_id || null;
            edit.opcs = campo.options || [];

        },
        getEdit:function(){
            return edit;
        },
        updOptions:function (opt) {
            var aux = $filter("filterSearch")(listado,[opt.field_id])[0];
            if(opt.opc_id == 4){
                var valAux = angular.copy(opt.valor);
                angular.forEach(aux.options, function(value, key){
                    if(value.id==opt.opc_id){
                        var idx = valAux.indexOf(parseInt(value.id))
                        if(idx==-1){
                            aux.options.splice(key,1);
                        }else{
                            valAux.splice(idx,1);
                        }
                    }
                });
                angular.forEach(valAux, function(value, key) {
                    aux.options.push({
                        camp_tipo: "txt",
                        descripcion: "Opcion",
                        id: value.opc_id,
                        pivot: {
                            id: value.id,
                            lct_id: value.field_id,
                            opc_id: value.opc_id,
                            value: value.valor,
                            message: value.msg
                        }
                    })
                });
            }else{
                var upd =  $filter("filterSearch")(aux.options,[opt.opc_id])[0];
                if(upd){
                    upd.pivot.value =  opt.valor;
                    upd.pivot.message =  opt.msg;
                }else{
                    var temp = angular.copy($filter("filterSearch")(masterOptions,[opt.opc_id])[0]);
                    temp.pivot= {
                        id: opt.id,
                        lct_id: opt.field_id,
                        opc_id: opt.opc_id,
                        value: opt.valor,
                        message: opt.msg
                    };
                    aux.options.push(temp);
                }
            }
        },
        getOptions:function () {
            return ListOptions;
        }

    }
});




MyApp.controller('formPreview',['$scope', 'setNotif','masters','critForm','$mdSidenav','$timeout','$filter',function ($scope, setNotif, masters,critForm,$mdSidenav,$timeout,$filter) {
    $scope.criteria = critForm.get();
    $scope.listOptions = critForm.getOptions();
    $scope.setEdit = function(campo){

        $scope.openConstruct(function () {
            critForm.setEdit(campo);
        });
    };
    $scope.formId = critForm.getEdit();
    
    $scope.get = function (filt,obj) {
        if(obj.options.length>0){
            if(obj.tipo != "Opcion"){
                return $filter("customFind")(obj.options,[obj.tipo],function(c,v){
                    return c.descripcion == v[0];
                })[0];
            }else{
                return $filter("customFind")(obj.options,[filt.id],function(c,v){
                    return c.descripcion == obj.tipo && c.id == v[0];
                }).length > 0;
            }
        }


    };

    $scope.openConstruct = function(callback){
        $mdSidenav("lyrConst1").open();
        $timeout(function(){
            $mdSidenav("lyrConst2").open()
        },250);
        $timeout(function(){
            $mdSidenav("lyrConst3").open().then(callback)
        },500);
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