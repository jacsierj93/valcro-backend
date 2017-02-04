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

MyApp.service("critForm",function(criterios,mastersCrit,$filter){

    var lines = mastersCrit.getLines();
    var fields = mastersCrit.getFields();
    var tipos = mastersCrit.getTypes();
    var listadobkup = [];
    var masterOptions = criterios.query({ type:"masterOptions"});
    var ListOptions = criterios.query({ type:"optionLists"});
    var curLine = {id:false,listado:[]};
    var factory = {
        linea_id: "1",
        campo_id: "1",
        tipo_id: "2",
        line:{},
        field:$filter("filterSearch")(fields,[1])[0],
        type:$filter("filterSearch")(tipos,[2])[0],
        id:false,
        options:{},
        deps:[],
        ready:false
    };
    var edit = {
        id:false,
        line:null,
        type:null,
        field:null,
        opcs:[]
    };
    var accept = false;

    var dependency = {
        id:false,
        lct_id:edit.id,
        parent_id:false,
        operator:'',
        condition:"",
        action:null
    };

    return {
        setLine:function(elem,force){
            //console.log(angular.equals(curLine.listado,listadobkup))
            if(!angular.equals(curLine.listado,listadobkup) && !force){
                return false;
            }

            if(!elem){
                curLine.id = false;
                listadobkup = [];
                curLine.listado = [];
                return true;
            }
            curLine.id = elem.id;
            criterios.query({ type:"getCriteria",id:elem.id},function(data){
                listadobkup = angular.copy(data) || [];
                curLine.listado = data || [];

            });


            return true;
        },
        getLine:function(){
            return curLine;
        },
        add:function(datos){
            var elem = {};
            elem = $filter("filterSearch")(curLine.listado,[datos.id])[0]
            if(!elem){
                elem = angular.copy(factory);
                curLine.listado.push(elem);
            }
            elem.id=datos.id;
            elem.ready = datos.ready;
            elem.linea_id=datos.line;
            elem.line = $filter("filterSearch")(lines,[datos.line])[0];
            elem.campo_id=datos.field;
            elem.field = $filter("filterSearch")(fields,[datos.field])[0];
            elem.tipo_id=datos.type;
            elem.type = $filter("filterSearch")(tipos,[datos.type])[0];
            //elem.opcs = elem.type.cfg;
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
            var aux = $filter("filterSearch")(curLine.listado,[opt.field_id])[0];
            if(!("options" in aux)) aux.options = [];
            if(opt.opc_id == 4){
                if(!("Opcion" in aux.options)){
                    aux.options.Opcion = [];
                }
                var valAux = angular.copy(opt.valor);
                angular.forEach(aux.options.Opcion, function(value, key){
                    if(value.id==opt.opc_id){
                        var idx = valAux.indexOf(parseInt(value.id))
                        if(idx==-1){
                            aux.options.Opcion.splice(key,1);
                        }else{
                            valAux.splice(idx,1);
                        }
                    }
                });

                angular.forEach(valAux, function(value, key) {

                    aux.options.Opcion.push({
                        camp_tipo: "array",
                        descripcion: "Opcion",
                        id: opt.opc_id,
                        elem:$filter("filterSearch")(ListOptions,[value])[0],
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
                var define = $filter("filterSearch")(masterOptions,[opt.opc_id])[0];
                var upd =  ((define.descripcion in aux.options) && aux.options[define.descripcion].length>0)?aux.options[define.descripcion][0]:false;
                if(upd){
                    upd.pivot.value =  opt.valor;
                    upd.pivot.message =  opt.msg;
                }else{
                    var temp = angular.copy(define);
                    temp.pivot= {
                        id: opt.id,
                        lct_id: opt.field_id,
                        opc_id: opt.opc_id,
                        value: opt.valor,
                        message: opt.msg
                    };
                    aux.options[define.descripcion]= [temp];
                }
            }
        },
        delOption :function(opt){
            var define = $filter("filterSearch")(masterOptions,[opt.opc_id])[0];
            var aux = $filter("filterSearch")(curLine.listado,[opt.field_id])[0].options[define.descripcion]
            aux.splice(0,1);
        },
        getOptions:function () {
            return ListOptions;
        },
        setDepend : function(depend){

            dependency.id = depend.id || false;
            dependency.parent_id = depend.lct_id || false;
            dependency.lct_id = depend.sub_lct_id || edit.id;
            dependency.operator = depend.operador || "";
            dependency.condition = depend.valor || "";
            dependency.action = depend.accion || undefined;

        },
        getDepend : function(){
            return dependency;
        }
    }
});


MyApp.controller('listController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {
    $scope.listLines = mastersCrit.getLines();

    $scope.openCrit = function(line){
        if(critForm.setLine(line)){
            $scope.$parent.LayersAction({open:{name:"critLayer1"}});
        }else{
            setNotif.addNotif("alert","esta editando un criterio actualmente desea cambiarlo, los cambios se guardaron automaticamente",[{
                name:"deacuerdo",
                action:function () {
                    critForm.setLine(line,true)
                    $scope.$parent.LayersAction({open:{name:"critLayer1"}});
                }
            },
                {
                    name:"cancelar",
                    action:function(){

                    }
                }
            ])
        }

    };
    $scope.curLine = critForm.getLine();
    $scope.filtAvaiable = function(c,v){
        //return true;
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

MyApp.controller('CritMainController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {
    $scope.nxtAction = null;
    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old){
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
        $timeout(function(){
            if($scope.index == 0){
                critForm.setLine(false);
            }
            if(old[0] == 'critLayer1'){
                if(!$mdSidenav(old[0]).isOpen()){
                    $scope.closeConstruct()
                }
            }

        })
    });

    $scope.closeConstruct = function(){
        $mdSidenav("lyrConst1").close();
        $timeout(function(){
            $mdSidenav("lyrConst2").close()
        },250);
        $timeout(function(){
            $mdSidenav("lyrConst3").close()
        },500);
    };
    var activesPopUp = [];
    $scope.closePopUp = function(sideNav,fn){
        idx = activesPopUp.indexOf(sideNav);
        if(idx != -1){
            if(fn.before){
                pre = fn.before();
            }else{
                pre = true;
            }

            if(!pre){
                return false;
            }
            $mdSidenav(sideNav).close().then(function(){

                activesPopUp.splice(idx,1);
                if(fn.after){
                    fn.after();
                }
            });
        };
    };

    $scope.openPopUp = function(sideNav,fn){
        if(activesPopUp.indexOf(sideNav)==-1){
            if(fn && fn.before){
                pre = fn.before();
            }else{
                pre = true;
            }

            if(!pre){
                return false;
            }
            $mdSidenav(sideNav).open().then(function(){
                activesPopUp.push(sideNav);
                if(fn && fn.after){
                    fn.after();
                }
            })
        }

    };

    $scope.showNext = function(status,to){
        if(status){
            $scope.nxtAction = to;
            $mdSidenav("NEXT").open()
        }else{
            $mdSidenav("NEXT").close()
        }
    };
    $scope.newCrit = function(){
        if(critForm.setLine(false)){
            $scope.LayersAction({open:{name:"critlayer0"}});
        }else{
            setNotif.addNotif("alert","esta editando un criterio actualmente desea cambiar, los cambios se guardaron automaticamente",[{
                name:"deacuerdo",
                action:function () {
                    critForm.setLine(false,true)
                    $scope.LayersAction({open:{name:"critlayer0"}});
                }
            },
                {
                    name:"cancelar",
                    action:function(){

                    }
                }
            ])
        }

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
    $scope.$watchCollection("line.listado",function(n,o){
        $scope.criteria = n
    });
    var accept = false;

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

    var chngLine = function(n,o){
        critForm.setEdit(n);
        clearOpts();
        if(n===false){
            $scope.closeConstruct();
        }

    };

    var clearOpts = function(){

       angular.forEach($scope.opcValue,function(v,k){
           v.id = false;
           v.valor = (k=="opts")?[]:"";
           v.msg = "";
       })
    };


    $scope.checkSave = function(e,model){
        var self = angular.element(e.currentTarget).parents(".optHolder").first();
        var parent = angular.element(e.relatedTarget).parents("#"+self.attr("id"));
        console.log(self,self.find(".Frm-value").hasClass("ng-pristine"),self.find(".Frm-msg").hasClass("ng-pristine"))
        if(parent.length!=0 || (self.find(".Frm-value").hasClass("ng-pristine") && self.find(".Frm-msg").hasClass("ng-pristine"))){
            return false;
        }
        console.log(parent.length,$scope.optionsForm.$pristine,$scope.optionsForm)
        if(parent.length ==0 && $scope.optionsForm.$pristine){

            return false;
        }
        if(self.find(".Frm-value").val()==""){
            setNotif.addNotif("alert", "el campo esta vacio, desea eliminar esta validacion", [
                {
                    name: "deacuerdo",
                    action: function () {
                        saveOptions($scope.opcValue);
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

    $scope.setOptSel = function(elem){
        if(elem.selOption) {
            $scope.opcValue.opts.valor.push(elem.selOption.id);

            $timeout(function () {
                saveOptions($scope.opcValue)
                elem.searchOptions = null
            }, 100);
        }

    };



    var saveOptions = function(datos){
        criterios.put({type:"saveOptions"},$scope.opcValue,function(data){
            angular.forEach(data, function(value, key){

                if(key.match(/^[^\$]/g) && ("id" in value)) {
                    $scope.opcValue[key].id = value.id;
                    critForm.updOptions($scope.opcValue[key]);
                }else if(key.match(/^[^\$]/g) && value.action == "del"){
                    critForm.delOption(angular.copy($scope.opcValue[key]))
                    $scope.opcValue[key].id = false;
                    $scope.opcValue[key].msg = ''
                }
            });
            $scope.optionsForm.$setPristine();
            $scope.optionsForm.$setUntouched();
            setNotif.addNotif("ok", "GUARDADO!!", [
            ],{autohidden:1000});

        });
    };

    $scope.$watch("critField.type",function(val,old){
            $scope.options = (val)?$filter("filterSearch")($scope.tipos ,[val])[0].cfg:[];
            advertOpcion();

    });

    $scope.$watchCollection("critField",function(n,o){
        if(n.id == o.id && n.line != null && n.type != null && n.field != null){
            criterios.put({type:"save"},$scope.critField,function(data){
                $scope.critField.id = data.id;
                $scope.critField.ready = data.ready;
                critForm.add($scope.critField);
            });
        }

    });

    $scope.checkType = function (dat) {
        if(!$scope.critField.field){
            return true;
        }
        var def = $filter("filterSearch")($scope.fields ,[$scope.critField.field])[0].tipo_id || false;
        return dat.id == def || def===false;
    };

    $scope.callback = function(ok){
        setNotif.addNotif("alert","este campo usualmente no es de este tipo, estas seguro del cambio",[
            {
                name: "SI",
                action: function () {
                    ok()
                }
            },
            {
                name:"NO",
                action: function(){

                }
            }
        ])
    };
    $scope.$watch("line.id",chngLine);
    $scope.$watch("critField.id",function(val){
        $timeout(function(){
            //accept = false;
            $scope.selCrit = $filter("filterSearch")($scope.criteria ,[val])[0] || [];
            $scope.opcValue.info.field_id= val;
            $scope.opcValue.info.id= ("Info" in $scope.critField.opcs)?$scope.critField.opcs.Info[0].pivot.id : false;
            $scope.opcValue.info.valor= ("Info" in $scope.critField.opcs)?$scope.critField.opcs.Info[0].pivot.value : "";
            $scope.opcValue.info.msg= ("Info" in $scope.critField.opcs)?$scope.critField.opcs.Info[0].pivot.message : "";

            $scope.opcValue.place.field_id= val;
            $scope.opcValue.place.id= ("placeholder" in $scope.critField.opcs)?$scope.critField.opcs.placeholder[0].pivot.id : false;
            $scope.opcValue.place.valor= ("placeholder" in $scope.critField.opcs)?$scope.critField.opcs.placeholder[0].pivot.value : "";
            $scope.opcValue.place.msg= ("placeholder" in $scope.critField.opcs)?$scope.critField.opcs.placeholder[0].pivot.message : "";

            $scope.opcValue.req.field_id= val;
            $scope.opcValue.req.id= ("Requerido" in $scope.critField.opcs)?$scope.critField.opcs.Requerido[0].pivot.id : false;
            $scope.opcValue.req.valor= ("Requerido" in $scope.critField.opcs)?$scope.critField.opcs.Requerido[0].pivot.value : "";
            $scope.opcValue.req.msg= ("Requerido" in $scope.critField.opcs)?$scope.critField.opcs.Requerido[0].pivot.message : "";

            $scope.opcValue.min.field_id= val;
            $scope.opcValue.min.id= ("Minimo" in $scope.critField.opcs)?$scope.critField.opcs.Minimo[0].pivot.id : false;
            $scope.opcValue.min.valor= ("Minimo" in $scope.critField.opcs)?$scope.critField.opcs.Minimo[0].pivot.value : "";
            $scope.opcValue.min.msg= ("Minimo" in $scope.critField.opcs)?$scope.critField.opcs.Minimo[0].pivot.message : "";

            $scope.opcValue.max.field_id= val;
            $scope.opcValue.max.id =  ("Max" in $scope.critField.opcs)?$scope.critField.opcs.Max[0].pivot.id : false;
            $scope.opcValue.max.valor= ("Max" in $scope.critField.opcs)?$scope.critField.opcs.Max[0].pivot.value : "";
            $scope.opcValue.max.msg= ("Max" in $scope.critField.opcs)?$scope.critField.opcs.Max[0].pivot.message : "";

            $scope.opcValue.maxI.field_id= val;
            $scope.opcValue.maxI.id = ("MaxImp" in $scope.critField.opcs)?$scope.critField.opcs.MaxImp[0].pivot.id : false;
            $scope.opcValue.maxI.valor = ("MaxImp" in $scope.critField.opcs)?$scope.critField.opcs.MaxImp[0].pivot.value : "";
            $scope.opcValue.maxI.msg = ("MaxImp" in $scope.critField.opcs)?$scope.critField.opcs.MaxImp[0].pivot.message : "";

            $scope.opcValue.minI.field_id= val;
            $scope.opcValue.minI.id = ("MinImp" in $scope.critField.opcs)?$scope.critField.opcs.MinImp[0].pivot.id : false;
            $scope.opcValue.minI.valor = ("MinImp" in $scope.critField.opcs)?$scope.critField.opcs.MinImp[0].pivot.value : "";
            $scope.opcValue.minI.msg = ("MinImp" in $scope.critField.opcs)?$scope.critField.opcs.MinImp[0].pivot.message : "";

            $scope.opcValue.opts.field_id = $scope.critField.id;
            $scope.opcValue.opts.valor = [];
            angular.forEach($scope.critField.opcs.Opcion, function(valor, key){
                $scope.opcValue.opts.valor.push(valor.pivot.value);
            });

        },0)

    });

    $scope.$watch("opcValue.opts.valor.length",function(n){
        advertOpcion();
        if(n<=4){
            accept = false;
        }
    });

    var advertOpcion = function(){

        if($scope.opcValue.opts.valor.length > 4 && $scope.critField.type == 1 && !accept){
            setNotif.addNotif("alert","esta cantidad de opciones no se ve bien en este tipo de campo, desea cambiarlo a selector?",[
                {
                    name: "SI",
                    action: function () {
                        $scope.critField.type = 3;
                    }
                },
                {
                    name:"NO",
                    action: function(){
                        accept = true;
                    }
                }
            ])
        }
    };

    $scope.createField = function(data,campo){
        $scope.critField[campo]=data.id;
        if(campo == "field"){
            //console.log(data)
            $scope.critField.type = data.tipo_id;
        }

    };
    $scope.opennext = function(){
        $scope.LayersAction({open:{name:"layer1"}});
    };
    
    $scope.addField= function(type){
        critForm.add(type);
    };

    $scope.callNew = function(){
        $mdSidenav("newField").open()
    };
    $scope.createNewIten = function(ctrl){
        var nuevo = ctrl.searchOptions;
        criterios.put({type:"saveNewItemList"},{name:nuevo},function(data){
            setNotif.addNotif("ok", "item creado", [
            ],{autohidden:1500});
            $scope.listOptions.push({id:data.id,nombre:nuevo})
            ctrl.selOption = {id:data.id,nombre:nuevo}

        });
    };

    $scope.opendDep = false;
    $scope.addDepend = function(deps){
        deps = deps || false;
        critForm.setDepend(deps)
        $mdSidenav("lyrConfig").open().then(function(){
            $scope.opendDep = true; 
        });
        angular.element("#lyrConst3").animate({"width": (angular.element("#lyrConst3").width()+468)+"px"},500)
    };

    $scope.closeDepend = function(){
        if($scope.opendDep){
            $mdSidenav("lyrConfig").close().then(function(){
                $scope.opendDep = false;
            });
            angular.element("#lyrConst3").animate({"width": (angular.element("#lyrConst3").width()-468)+"px"},500)
        }

    };

    $scope.used = function(field){
        return $filter("customFind")($scope.criteria,field,function(c,v){
            return c.campo_id == v.id;
        }).length > 0
    };

    $scope.isUsed = function(){
        setNotif.addNotif("error", "no se puede usar este campo dos veces", [
        ],{autohidden:3000});
    };

}]);

MyApp.controller('createFieldController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {
    $scope.types = mastersCrit.getTypes();
    $scope.fields = mastersCrit.getFields();
    $scope.newField = {
        id:false,
        descripcion:"",
        tipo_id:null
    };
    $scope.$watchGroup(['fieldForm.$valid','fieldForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            criterios.put({type:"saveNewField"},$scope.newField,function(data){
                $scope.newField.id = data.id;
                $scope.fieldForm.$setPristine();
                if(data.action=="new"){
                    
                    $scope.fields.push(angular.copy($scope.newField));
                    setNotif.addNotif("ok", "item creado", [
                    ],{autohidden:3000});
                };
            });

        }
    });

}]);

MyApp.controller('formPreview',['$scope', 'setNotif','masters','critForm','$mdSidenav','$timeout','$filter',function ($scope, setNotif, masters,critForm,$mdSidenav,$timeout,$filter) {
    $scope.line = critForm.getLine();
    $scope.listOptions = critForm.getOptions();
    //$scope.criteria =$scope.line.listado;
    
    $scope.$watchCollection("line.listado",function(n,o){
        $scope.criteria = n
    });
    $scope.setEdit = function(campo){
        $scope.openConstruct(function () {
            critForm.setEdit(campo);
        });
    };
    $scope.formId = critForm.getEdit();

    $scope.openConstruct = function(callback){
        $mdSidenav("lyrConst1").open();
        $timeout(function(){
            $mdSidenav("lyrConst2").open()
        },250);
        $timeout(function(){
            $mdSidenav("lyrConst3").open().then(callback)
        },500);
    };
    $scope.item = [];
}]);

MyApp.controller('treeController',['$scope', 'setNotif','masters','critForm','$mdSidenav','$timeout','$filter','criterios',function ($scope, setNotif, masters,critForm,$mdSidenav,$timeout,$filter,criterios) {
    $scope.line = critForm.getLine();

    $scope.$watch("line.id",function(n){
        criterios.query({type:"getTree",id:n},function(data){
            $scope.treedata =data || [];
        });
    });
    $scope.check = function(path,i,parent){
        console.log(path,i,parent);
    }

}]);

MyApp.controller('dependencyController',['$scope', 'setNotif','critForm','$mdSidenav','$timeout','$filter','criterios',function ($scope, setNotif,critForm,$mdSidenav,$timeout,$filter,criterios) {
    $scope.line = critForm.getLine();
    $scope.listOptions = critForm.getOptions();
    $scope.$watchCollection("line.listado",function(n,o){
        $scope.criteria = n;
    });
    $scope.currentLct = critForm.getEdit();
    $scope.configDep = critForm.getDepend();
    $scope.$watch("currentLct.id",function(nvo){
        if(nvo){
            $scope.currentCrit = $filter("filterSearch")($scope.criteria,[nvo])[0];
        }
    });

    $scope.visibility = [
        {
            id:'true',
            icon:"icon-checkMark"
        },
        {
            id:'false',
            icon:"icon-Eliminar"
        }
    ];

    $scope.saveDependency = function(){
        criterios.put({type:"saveDep"},$scope.configDep,function(data){
            $scope.configDep.id = data.id;
            updateDependency($scope.configDep,data.action);
            setNotif.addNotif("ok", "GUARDADO!!", [
            ],{autohidden:1000});
            $scope.$parent.closeDepend();
        });
    };

    var updateDependency = function(dat,act){
        depend = (act=="upd")?$filter("filterSearch")($scope.currentCrit.deps,[dat.id])[0]:{};
        depend.id = dat.id
        depend.lct_id = dat.parent_id
        depend.sub_lct_id = dat.lct_id
        depend.operador = dat.operator;
        depend.valor = dat.condition;
        depend.accion =  dat.action;
        if(act=="new"){
            $scope.currentCrit.deps.push(depend);
        }
    };


    $scope.getoptSet = function(id){
        return $filter("filterSearch")($scope.listOptions ,[id])[0];
    };

    $scope.checkValid = function(){
        return ($scope.configDep.parent_id && $scope.configDep.operator!='' && $scope.configDep.condition != '' && $scope.configDep.condition != null);
    };
    
    $scope.showAlert = function(){
        console.log($scope.configDep)
        setNotif.addNotif("error", "datos incomṕletos", [
        ],{autohidden:1000});
    };

    $scope.operator = [
        {
            op:"=",
            cfg:"all",
            descripcion:"es Igual"
        },{
            op:">",
            cfg:"texto",
            descripcion:"es Mayor"
        },{
            op:"<",
            cfg:"texto",
            descripcion:"es Menor"
        },{
            op:"!=",
            cfg:"texto",
            descripcion:"es diferente"
        },{
            op:">>",
            cfg:"texto",
            descripcion:"existe en"
        }
    ];
    $scope.setCfg = function(cfg,val){
        $scope.configDep[cfg] = val;
    };

    $scope.$watch("configDep.parent_id",function(nvo){
        if(nvo){
            $scope.currentParent = $filter("filterSearch")($scope.criteria,[nvo])[0];
        }

    })

}]);



MyApp.directive('treeBranch', function() {

        return {
            scope: { branch: '=treeBranch' },
            templateUrl: function(elem, attr) {
                return 'modules/criterios/textForm';
            }
        };
});

MyApp.directive("setAttr",function(){
    return {

        link:function(scope,elem,attr){
            scope.ats = scope.$eval(attr.setAttr);


            scope.$watchCollection("ats",function(ats){

                angular.forEach(ats.options,function(v,k){

                    scope[v.especificacion+"_live"] = v.pivot;
                    scope.$watchCollection(v.especificacion+"_live",function(){
                        if(v.especificacion == "label"){
                            elem.parent().find("label").html(scope[v.especificacion+"_live"].value);
                        }else if(v.especificacion != ""){
                            attr[v.especificacion] = scope[v.especificacion+"_live"].value;
                        }

                    });
                    if(v.especificacion == "label"){
                        elem.parent().find("label").html(v.pivot.value);
                    }else if(v.especificacion != ""){
                        attr.$observe(v.especificacion,function(){});
                        attr[v.especificacion] = v.pivot.value;
                        //console.log(attr);
                    }
                })
            });


        }
    };
})

MyApp.directive('lmbCollection', function() {

    return {
        replace: true,
        transclude: true,
        scope: {
            itens: '=lmbItens',
            model: '=lmbModel',
            valid: '=?valid',
            dis: '=?ngDisabled'
        },
        controller:function($scope){
            $scope.curVal = {};
            if(!("valid" in $scope)){
                $scope.valid = {
                    f:function(){return true},
                    c:function(){return true},
                }
            }
            $scope.setIten=function(dat){
                $scope.curVal = dat;
                if($scope.valid.f(dat)){
                    done()
                }else{
                    $scope.valid.c(done)
                }
            };

            var done = function(){
                var dat = $scope.curVal;
                if($scope.multi){
                    if(typeof($scope.model) !='object'){
                        $scope.model = [];
                    }
                    if($scope.model.indexOf(eval("dat."+$scope.key)) != -1){
                        $scope.model.splice($scope.model.indexOf(eval("dat."+$scope.key)),1);
                    }else{
                        $scope.model.push(eval("dat."+$scope.key));
                    }

                }else{
                    $scope.model = eval("dat."+$scope.key);
                }
            };

            $scope.exist = function(dat){
                if($scope.multi){
                    if($scope.model){
                        return $scope.model.indexOf(eval("dat."+$scope.key)) !== -1;
                    }

                }else{
                    return $scope.model == eval("dat."+$scope.key);
                }

            };

        },
        link:function(scope,elem,attr,model){
            scope.multi = ('multiple' in attr);
            scope.key = ('lmbKey' in attr)?attr.lmbKey:'id';
            attr.$observe('disabled', function (newValue) {
                if(newValue){
                    elem.css("color","#f1f1f1");
                }else{
                    elem.css("color","#000");
                }
            });
        },
        template: function(elem,attr){
            var show = "descripcion"
            if("lmbDisplay" in attr){
                show = attr.lmbDisplay;
            }
            var filt = ("filterBy" in attr)?" | "+attr.filterBy:"";
            attr.filterBy = null;
            var iconField = "item."+attr.lmbIcon || "";
            if(attr.lmbType=="items"){
                return '<div><div ng-repeat="item in itens'+filt+'" ng-click="(!dis)?setIten(item):false" ng-class="{\'field-sel\':exist(item)}" class="rad-button" flex layout="column" layout-align="center center"><span ng-if="item.icon" class="{{item.icon}}"></span>{{item.'+show+'}}</div></div>';
            }else{
                return '<md-content flex layout="column">'+
                    '<div layout="row" ng-repeat="item in itens'+filt+'" class="row" ng-click="(!dis)?setIten(item):false" ng-class="{\'field-sel\':exist(item)}" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc"> <div flex>{{item.'+show+'}}</div><div ng-show="'+iconField+' != \'\'" flex><img ng-src="images/{{'+iconField+'}}"/></div> </div>'

                +'</md-content>';
            }

            
        }

    };
});