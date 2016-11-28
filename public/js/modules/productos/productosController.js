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

    $scope.openCrit = function(line){
        critForm.setLine(line);
        $scope.$parent.LayersAction({open:{name:"layer1"}});
        /*$mdSidenav("layer1").open();*/
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

    $scope.saveNewLine = function(){
        criterios.put({type:"createLine"},$scope.newLine,function(data){
            $scope.newLine.id = data.id;
            if(data.action=="new"){
                var line = {
                        id:$scope.newLine.id,
                        linea:$scope.newLine.name,
                        siglas:$scope.newLine.letter,
                        hasCrit: true
                };
                $scope.listLines.push(line);
                setNotif.addNotif("ok", "Nueva Linea Creada", [
                ],{autohidden:3000});
            }else{
                var line = $filter("filterSearch")($scope.listLines ,[data.id])[0];
                line.linea = $scope.newLine.name;
                line.siglas = $scope.newLine.letter;
            }
            $timeout(function(){
                $scope.$parent.LayersAction({close:{all:true,after:function(){
                    $scope.newLine.id = false;
                    $scope.newLine.name = "";
                    $scope.newLine.letter = "";
                    $timeout(function(){
                        angular.element("#mainList").find("#lineId"+line.id).click();
                    },500);
                }}});
            },500)

        });
    };
    $scope.over = false;
    $scope.showMsg = function(){
        $scope.over = true;
        console.log($scope.over);
        $timeout(function(){
           if($scope.over){
               if($scope.LineProd.$pristine){
                   setNotif.addNotif("info", "Si desea regresar sin cargar ninguna nueva linea porfavor de click en la flecha \"atras\"", [
                   ],{autohidden:3000});
               }

           }else if(!$scope.LineProd.$valid && !$scope.LineProd.$pristine){
               setNotif.addNotif("alert", "es imposible continuar con al creacion de la linea, porfavor corrija los errores", [
               ],{autohidden:3000});
           }
        },300);
    }
    
    
}]);

MyApp.controller('prodMainController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {
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
    $scope.newCrit = function(){
        $scope.LayersAction({open:{name:"layer0"}});
    };
    $scope.newLine = function(){
        $scope.LayersAction({open:{name:"layer2"}});
    };

    $scope.prevLayer = function(){
        $scope.LayersAction({close:true});
    };

    $scope.listLines = mastersCrit.getLines();
    $scope.line = critForm.getLine();
    $scope.fields = mastersCrit.getFields();
    $scope.tipos = mastersCrit.getTypes();
    $scope.critField = critForm.getEdit();
    $scope.listOptions = critForm.getOptions();

    $scope.opcValue = {
        info: {
            opc_id: 8,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        place: {
            opc_id: 9,
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


    $scope.checkSave = function(e,model){
        var self = angular.element(e.currentTarget).parents(".optHolder").first();
        var parent = angular.element(e.relatedTarget).parents("#"+self.attr("id"));
        if(parent.length!=0 || (self.find(".Frm-value").hasClass("ng-pristine") && self.find(".Frm-msg").hasClass("ng-pristine"))){
            return false;
        }
        if(self.find(".Frm-value").val()==""){
            setNotif.addNotif("alert", "el campo esta vacio, el valor no se guardara", [
                {
                    name: "deacuerdo",
                    action: function () {
                       
                    }
                },
                {
                    name: "Dejame Cambiarlos",
                    action: function () {
                        self.find(".Frm-value").focus();
                    }
                }
            ]);
            return false;
        }

        if(self.find(".Frm-value").val()!="" && self.find(".Frm-msg").val()=="" ){

            setNotif.addNotif("alert", "no has especificado un mensaje para esta opcion, seguro deseas continuar?", [
                {
                    name: "Si, continuare",
                    action: function () {
                        saveOptions($scope.opcValue);
                    }
                },
                {
                    name: "Dejame Cambiarlos",
                    action: function () {
                        self.find(".Frm-msg").focus();
                    }
                }
            ]);
        }else{
            saveOptions($scope.opcValue);
        }


    };

    $scope.getoptSet = function(id){
        return $filter("filterSearch")($scope.listOptions ,[id])[0];
    };

    $scope.setOptSel = function(id){
        
        if(id){
            $scope.opcValue.opts.valor.unshift(id);
            console.log($scope.ctrl);
            $timeout(function(){$scope.ctrl.searchOptions = null},0);
            saveOptions($scope.opcValue)
        }

    };

    var saveOptions = function(datos){

        criterios.put({type:"saveOptions"},$scope.opcValue,function(data){
            angular.forEach(data, function(value, key){
                if(key.match(/^[^\$]/g) && ("id" in value)) {
                    $scope.opcValue[key].id = value.id;
                    critForm.updOptions($scope.opcValue[key]);
                }
            });
            setNotif.addNotif("ok", "GUARDADO!!", [
            ],{autohidden:1000});

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
                    value.valor = [];
                    angular.forEach($filter("filterSearch")($scope.critField.opcs,[value.opc_id]), function(valor, key){
                        value.valor.push(valor.pivot.value);
                    });
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
        $scope.LayersAction({open:{name:"layer1"}});
    };
    
    $scope.addField= function(type){
        critForm.add(type);
    };
    
    $scope.createNewIten = function(nuevo){
        criterios.put({type:"saveNewItemList"},{name:nuevo},function(data){
            setNotif.addNotif("ok", "item creado", [
            ],{autohidden:3000});
        });
    };
    $scope.addDepend = function(){
        $mdSidenav("lyrConfig").open();
        angular.element("#lyrConst3").animate({"width": (angular.element("#lyrConst3").width()+468)+"px"},500)
    };


}]);

MyApp.service("critForm",function(criterios,mastersCrit,$filter){

    var lines = mastersCrit.getLines();
    var fields = mastersCrit.getFields();
    var tipos = mastersCrit.getTypes();
    var listado = [];
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
            listado = criterios.query({ type:"getCriteria",id:curLine.id});
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
                        camp_tipo: "array",
                        descripcion: "Opcion",
                        id: opt.opc_id,
                        pivot: {
                            id: opt.id,
                            lct_id: opt.field_id,
                            opc_id: opt.opc_id,
                            value: value,
                            message: ""
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
    $scope.line = critForm.getLine();
    $scope.listOptions = critForm.getOptions();
    $scope.$watch("line.id",function(){
        $scope.criteria = critForm.get();
    });
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
                })[0] || {pivot:{value:""}};
            }else{
                return $filter("customFind")(obj.options,[filt.id],function(c,v){
                    return c.descripcion == obj.tipo && c.pivot.value == v[0];
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


MyApp.controller('treeViewController',['$scope', 'setNotif','masters','critForm','$mdSidenav','$timeout','$filter',function ($scope, setNotif, masters,critForm,$mdSidenav,$timeout,$filter) {
    $scope.line = critForm.getLine();
    $scope.$watch("line.id",function(){
        $scope.criteria = critForm.get();
    });
  
}]);

MyApp.controller('dependencyController',['$scope', 'setNotif','critForm','$mdSidenav','$timeout','$filter',function ($scope, setNotif,critForm,$mdSidenav,$timeout,$filter) {
    $scope.line = critForm.getLine();
    $scope.$watch("line.id",function(){
        $scope.criteria = critForm.get();
    });
    $scope.currentLct = critForm.getEdit();
    $scope.$watch("currentLct.id",function(nvo){
        $scope.currentCrit = $filter("filterSearch")($scope.criteria,[nvo])[0];
        $scope.configDep = {
            id:false,
            lct_id:nvo,
            parent_id:false,
            operator:'',
            action:null
        };
        console.log($scope.currentCrit);
    });
    $scope.operator = [
        {
            op:"=",
            descripcion:"es Igual"
        },{
            op:">",
            descripcion:"es Mayor"
        },{
            op:"<",
            descripcion:"es Menor"
        },{
            op:"!=",
            descripcion:"es diferente"
        },{
            op:">>",
            descripcion:"existe en"
        }
    ];
    $scope.setCfg = function(cfg,val){
        $scope.configDep[cfg] = val;
    };

}]);

MyApp.directive('formPreview', function() {
        return {
            templateUrl: function(elem, attr) {
                return 'modules/productos/textForm';
            }
        };
});

MyApp.directive('treeBranch', function() {

        return {
            scope: { branch: '=treeBranch' },
            templateUrl: function(elem, attr) {
                return 'modules/productos/textForm';
            }
        };
});