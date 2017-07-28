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
    var depWork = {parent:false,target:false};
    var factory = {
        linea_id: "",
        campo_id: "",
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

    var curCrit = {};

    return {
        setLine:function(elem,force){

            if(!angular.equals(curLine.listado,listadobkup) && !force){
                return false;
            }
            if(curLine.listado.length==0 && curLine.id){
                $filter("filterSearch")(lines,[curLine.id])[0].hasCrit=false;
            }
            if(!elem){
                console.log("entro en donde deveria setear a 0")
                curLine.id = false;
                listadobkup = [];
                curLine.listado = [];
                return true;

            }



            curLine.id = elem.id;
            criterios.query({ type:"getCriteria",id:elem.id},function(data){

                elem.hasCrit = true;
                listadobkup = angular.copy(data) || [];
                curLine.listado = data || [];

            });


            return true;
        },
        getLine:function(){
            return curLine;
        }  ,
        add:function(datos){
            //curCrit = (datos.id)?$filter("filterSearch")(curLine.listado,[datos.id])[0]:false;
            curCrit = angular.copy(factory);
            curCrit.linea_id = curLine.id;
            curLine.listado.push(curCrit);

            return curCrit;
        },
        rm:function(id){
            curLine.listado.splice(curLine.listado.indexOf($filter("filterSearch")(curLine.listado,[id])[0]),1);
            curCrit = new Object();
        },
        get:function(){
            return listado;
        },
        setEdit:function(campo){
            edit.id = campo.id || false;
             /*edit.line = campo.linea_id || curLine.id;
            edit.field = campo.campo_id || null;
            edit.type = campo.tipo_id || null;*/
            if(campo){
                edit.opcs = campo.options;
            }else{
                edit.opcs = [];
            }

            edit.curCrit = (campo.id)?$filter("filterSearch")(curLine.listado,[campo.id])[0]:false;


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
        },
        dependSel : function(){
            return depWork
        }
    }
});


MyApp.controller('listController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout) {
    $scope.listLines = mastersCrit.getLines();

    $scope.openCrit = function(line){
        if(critForm.setLine(line)){

            $scope.$parent.LayersAction({open:{name:"critLayer1"}});
        }else{
            setNotif.addNotif("alert","esta editando un criterio actualmente desea cambiarlo,perdera los cambios no guardados",[{
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
                    },1000);
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

MyApp.controller('CritMainController',['$scope', 'setNotif','mastersCrit','$mdSidenav','critForm','criterios','$filter',"$timeout","App","popUpService","$q",function ($scope, setNotif, mastersCrit,$mdSidenav,critForm,criterios,$filter,$timeout,App,popUpService,$q) {


    var backCrit = {crit:{},opc:{}};
    $scope.nxtAction = null;
    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old){
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
       /* $timeout(function(){
            if($scope.index == 0){
                critForm.setLine(false);
            }

        })*/
    });


    $scope.endCriterio = function(){
        $scope.LayersAction({close:{all:true,before:function(){
            critForm.setLine(false);
        },
        after:function(){
            setNotif.addNotif("ok", "El Criterio se ha guardado satisfactoriamente", [
            ],{autohidden:2000});
        }}});

    }

    $scope.newCrit = function(){
        if(critForm.setLine(false)){
            $scope.LayersAction({open:{name:"critlayer0"}});
        }else{
            setNotif.addNotif("alert","esta editando un criterio actualmente desea cambiar,perdera los cambios no guardados",[{
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
        if(critForm.setLine(false)){

            $scope.LayersAction({close:true});
        }else{
            setNotif.addNotif("alert","esta editando un criterio actualmente desea cambiarlo,perdera los cambios no guardados",[{
                name:"deacuerdo",
                action:function () {
                    critForm.setLine(false,true)
                    $scope.LayersAction({close:true});
                }
            },
                {
                    name:"cancelar",
                    action:function(){

                    }
                }
            ])
        }
        //$scope.LayersAction({close:true});
    };

    $scope.listLines = mastersCrit.getLines();
    $scope.line = critForm.getLine();
    $scope.fields = mastersCrit.getFields();
    $scope.tipos = mastersCrit.getTypes();
    $scope.critField = critForm.getEdit();
/*    $scope.$watchCollection("line.listado",function(n,o){
        console.log
        closeConst()
        $scope.criteria = n

    });*/

    $scope.$watchCollection("line.id",function(n,o){
        closeConst()

        //$scope.criteria = $scope.line.listado;
        /*console.log(n,n.id, o.id)
         if(n.id != o.id){

         chngLine(n,o);

         }*/
    });
    $scope.newField = {type:false}
    $scope.elem = {};
    $scope.$watch("newField.type",function(n,o){

        if(n){
            //$scope.critField.type = n

            popUpService.popUpOpen({
                'nuevoConst':{
                    before:function(){
                        $scope.elem = critForm.add($scope.critField);
                        $scope.elem.tipo_id=n;
                        $scope.elem.type = $filter("filterSearch")($scope.tipos,[n])[0];
                        return true;
                    },
                    after:null
                }
            })
        }

    });
    var accept = false;

    $scope.listOptions = critForm.getOptions();

    function saveCriterio(ext=false){

        wait = $q.defer();
        var ret = wait.promise;
        criterios.put({type:"save"},{crite:$scope.elem,options:$scope.opcValue,adapt:ext},function(data){
            $scope.elem.id = data.id;

            var i = 0;
            angular.forEach(data.opciones, function(value, key){
                i++;
                if(key.match(/^[^\$]/g) && ("id" in value)) {
                    $scope.opcValue[key].id = value.id;
                    $scope.opcValue[key].field_id = data.id;
                    critForm.updOptions($scope.opcValue[key]);
                }else if(key.match(/^[^\$]/g) && value.action == "del"){
                    critForm.delOption(angular.copy($scope.opcValue[key]))
                    $scope.opcValue[key].id = false;
                    $scope.opcValue[key].msg = ''
                }
                //console.log(i,Object.keys(data.opciones).length)
                if(i==Object.keys(data.opciones).length){
                    wait.resolve(data.id);
                }
            });
            if(!("deps" in $scope.elem)){
               $scope.elem.deps = [];
            }

            setNotif.addNotif("ok", "datos guardados", [
            ],{autohidden:1000});

        });
        return ret;
    }

    function preSave(){
        if($scope.elem.hasProd && !angular.equals(backCrit.crit,$scope.elem)){
            setNotif.addNotif("alert", "ya existen productos creados que implementan este criterio, ¿que desea hacer?", [
                {
                    name:"resetear los campos",
                    action:function(){
                        alert("algo");
                    }
                },
                {
                    name:"adecuar",
                    action:function(){
                        alert("adecuar");
                    }
                },
                {
                    name:"mantenerlos",
                    action:function(){
                        saveCriterio({act:"stay"}).then(closeConst);
                    }
                }

                ]);
        }else{
            saveCriterio().then(closeConst);
        }
    }

    $scope.saveCrit = function(){
        //console.log($scope.fieldForm.$pristine , angular.equals(backCrit.crit,$scope.elem), angular.equals(backCrit.opc,$scope.opcValue))
        if($scope.fieldForm.$pristine || (angular.equals(backCrit.crit,$scope.elem) && angular.equals(backCrit.opc,$scope.opcValue))){
            closeConst();
            return true;
        }
        //console.log("entoroooooo")
        preSave();

    };
    
    $scope.precheck = function () {
        if(!$scope.fieldForm.$pristine && !$scope.fieldForm.$valid){
            setNotif.addNotif("error", "existen campos necesarios que no han sido llenos ", [],{autohidden:2000});
            return false;
        }
        return true;
    };

    $scope.closeConst = function(){
        if(!$scope.fieldForm.$pristine){
            setNotif.addNotif("alert", "si cierra perdera todos los datos no guardados, porfavor haga click > para guardar", [
                {
                    name:"descartar los cambios ",
                    action:function(){
                        closeConst()
                    }
                },
                {
                    name:"continuar editando/creando",
                    action:null,
                }
            ]);
            return false;
        }
        closeConst()

    };
    function closeConst(){
        popUpService.popUpClose({
            'nuevoConst':{
                before:function(){
                    return true;
                },
                after:function() {
                    if(!$scope.elem.id){
                        critForm.rm($scope.elem.id);
                    }
                    critForm.setEdit(false);
                    //critForm.setLine(false);
                    $scope.newField.type = false;
                    clearOpts();
                    $scope.fieldForm.$setUntouched();
                    $scope.fieldForm.$setPristine();
                }
            }
        })
    }

    $scope.opcValue = {
        coder: {
            opc_id: 10,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
        multi: {
            opc_id: 11,
            field_id: $scope.critField.id,
            id: false,
            valor: '',
            msg: ''
        },
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

/*
    $scope.checkSave = function(e,model){
        var self = angular.element(e.currentTarget).parents(".optHolder").first();
        var parent = angular.element(e.relatedTarget).parents("#"+self.attr("id"));
        if(parent.length!=0 || (self.find(".Frm-value").hasClass("ng-pristine") && self.find(".Frm-msg").hasClass("ng-pristine"))){
            return false;
        }
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
*/

    $scope.getoptSet = function(id){
        return $filter("filterSearch")($scope.listOptions ,[id])[0];
    };

    $scope.setOptSel = function(elem){
        if(elem.selOption) {
            $scope.opcValue.opts.valor.push(elem.selOption.id);
            elem.searchOptions = null
           /* $timeout(function () {
                saveOptions($scope.opcValue)

            }, 100);*/
        }

    }

    $scope.removeOpt = function(idx){
        console.log(idx,$scope.opcValue.opts.valor)
        setNotif.addNotif("error", "¿desea retirar esta opcion?", [
            {
                name:"SI",
                action:function(){
                    $scope.opcValue.opts.valor.splice(idx,1);
                    $scope.fieldForm.$setDirty();
                    setNotif.addNotif("ok", "Efectuado", [
                    ],{autohidden:1000});
                }
            },
            {
                name:"NO",
                action:null,
                default:defaultTime
            }

        ]);
    }

/*    var saveOptions = function(datos){
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
    };*/

    $scope.$watchCollection("critField",function(n,o){
        if(n.type != o.type){
            $scope.options = (val)?$filter("filterSearch")($scope.tipos ,[val])[0].cfg:[];
            advertOpcion();
        }

        if(n.id != o.id){
            $timeout(function(){

                $scope.elem = n.curCrit;
                val = $scope.elem.id;
                $scope.selCrit = $filter("filterSearch")($scope.line.listado ,[val])[0] || [];
                $scope.opcValue.coder.field_id= val;
                $scope.opcValue.coder.id= ("codificador" in $scope.critField.opcs)?$scope.critField.opcs.codificador[0].pivot.id : false;
                $scope.opcValue.coder.valor= ("codificador" in $scope.critField.opcs)?parseInt($scope.critField.opcs.codificador[0].pivot.value): 0;
                $scope.opcValue.coder.msg= ("codificador" in $scope.critField.opcs)?$scope.critField.opcs.codificador[0].pivot.message : "";

                $scope.opcValue.multi.field_id= val;
                $scope.opcValue.multi.id= ("multi" in $scope.critField.opcs)?$scope.critField.opcs.multi[0].pivot.id : false;
                $scope.opcValue.multi.valor= ("multi" in $scope.critField.opcs)?parseInt($scope.critField.opcs.multi[0].pivot.value): 0;
                $scope.opcValue.multi.msg= ("multi" in $scope.critField.opcs)?$scope.critField.opcs.multi[0].pivot.message : "";

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
                $scope.opcValue.req.valor= ("Requerido" in $scope.critField.opcs)?parseInt($scope.critField.opcs.Requerido[0].pivot.value): "";
                $scope.opcValue.req.msg= ("Requerido" in $scope.critField.opcs)?$scope.critField.opcs.Requerido[0].pivot.message : "";

                $scope.opcValue.min.field_id= val;
                $scope.opcValue.min.id= ("Minimo" in $scope.critField.opcs)?$scope.critField.opcs.Minimo[0].pivot.id : false;
                $scope.opcValue.min.valor= ("Minimo" in $scope.critField.opcs)?parseInt($scope.critField.opcs.Minimo[0].pivot.value) : "";
                $scope.opcValue.min.msg= ("Minimo" in $scope.critField.opcs)?$scope.critField.opcs.Minimo[0].pivot.message : "";

                $scope.opcValue.max.field_id= val;
                $scope.opcValue.max.id =  ("Max" in $scope.critField.opcs)?$scope.critField.opcs.Max[0].pivot.id : false;
                $scope.opcValue.max.valor= ("Max" in $scope.critField.opcs)?parseInt($scope.critField.opcs.Max[0].pivot.value) : "";
                $scope.opcValue.max.msg= ("Max" in $scope.critField.opcs)?$scope.critField.opcs.Max[0].pivot.message : "";

                $scope.opcValue.maxI.field_id= val;
                $scope.opcValue.maxI.id = ("MaxImp" in $scope.critField.opcs)?$scope.critField.opcs.MaxImp[0].pivot.id : false;
                $scope.opcValue.maxI.valor = ("MaxImp" in $scope.critField.opcs)?parseInt($scope.critField.opcs.MaxImp[0].pivot.value) : "";
                $scope.opcValue.maxI.msg = ("MaxImp" in $scope.critField.opcs)?$scope.critField.opcs.MaxImp[0].pivot.message : "";

                $scope.opcValue.minI.field_id= val;
                $scope.opcValue.minI.id = ("MinImp" in $scope.critField.opcs)?$scope.critField.opcs.MinImp[0].pivot.id : false;
                $scope.opcValue.minI.valor = ("MinImp" in $scope.critField.opcs)?parseInt($scope.critField.opcs.MinImp[0].pivot.value) : "";
                $scope.opcValue.minI.msg = ("MinImp" in $scope.critField.opcs)?$scope.critField.opcs.MinImp[0].pivot.message : "";

                $scope.opcValue.opts.field_id = $scope.critField.id;
                $scope.opcValue.opts.valor = [];
                angular.forEach($scope.critField.opcs.Opcion, function(valor, key){
                    $scope.opcValue.opts.valor.push(valor.pivot.value);
                });
                $timeout(function(){
                    backCrit.crit = angular.copy($scope.elem);
                    backCrit.opc = angular.copy($scope.opcValue)
                },100)

            },0)
        }

        /*if(n.id == o.id && n.line != null && n.type != null && n.field != null){
            criterios.put({type:"save"},$scope.critField,function(data){
                $scope.critField.id = data.id;
                $scope.critField.ready = data.ready;
                critForm.add($scope.critField);
            });
        }*/

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

    $scope.$watchCollection("elem",function(n,o){
        if(n.tipo_id){
            n.type = $filter("filterSearch")($scope.tipos ,[n.tipo_id])[0];
        }
    });
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
        if(!$scope.elem.id){
            setNotif.addNotif("alert","primero debemos guardar lo que ha creado hasta ahora, ¿esta deacuerdo?",[
                {
                    name: "CANCELAR",
                    action: null
                },
                {
                    name:"GUARDALO",
                    action: function(){
                        deps = deps || false;
                        popUpService.popUpOpen({
                            'lyrConfig':{
                                before:function(){
                                    critForm.setDepend(false)
                                    $scope.openDep=true;
                                },
                                after:null
                            }
                        })
                    }
                }
            ])
        }else{
            deps = deps || false;
            critForm.setDepend(deps)
            $mdSidenav("lyrConfig").open().then(function(){
                $scope.opendDep = true;
            });
        }

        //angular.element("#lyrConst3").animate({"width": (angular.element("#lyrConst3").width()+468)+"px"},500)
    };

    $scope.closeDepend = function(){
        if($scope.opendDep){
            $mdSidenav("lyrConfig").close().then(function(){
                $scope.opendDep = false;
            });
            angular.element("#lyrConst3").animate({"width": (angular.element("#lyrConst3").width()-468)+"px"},500)
        }

    };

    $scope.used=function(c,v){
        //console.log($scope.line.listado,c,v)
        x = $filter("customFind")(v,c,function(c,v){
                return c.campo_id == v.id;
            }).length == 0
        //console.log(x);
        return x;

    }

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
    $scope.aftClose = function(){

        $scope.newField.id = false;
        $scope.newField.descripcion = "";
        $scope.newField.tipo_id = null;
        $scope.fieldForm.$setUntouched();
        $scope.fieldForm.$setPristine();
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


MyApp.controller('formPreview',['$scope', 'setNotif','masters','critForm','$mdSidenav','$timeout','$filter','popUpService',function ($scope, setNotif, masters,critForm,$mdSidenav,$timeout,$filter,popUpService) {
    $scope.line = critForm.getLine();
    $scope.listOptions = critForm.getOptions();

    $scope.dependSel = critForm.dependSel();

    $scope.list = [1,2,3,4,5,6,7];
    $scope.list2 = [];

    $scope.$watchCollection("line.listado",function(n,o){
        $scope.criteria = n
    });
    $scope.setEdit = function(campo){
        popUpService.popUpOpen({
            'nuevoConst':{
                before:function(){

                    return true;
                },
                after:null
            }
        })
        critForm.setEdit(campo);
        /*$scope.openConstruct(function () {
            critForm.setEdit(campo);
        });*/
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

MyApp.controller('dependencyController',['$scope', 'setNotif','critForm','$mdSidenav','$timeout','$filter','criterios','$q',function ($scope, setNotif,critForm,$mdSidenav,$timeout,$filter,criterios,$q) {
    $scope.line = critForm.getLine();
    $scope.listOptions = critForm.getOptions();
    $scope.$watchCollection("line.listado",function(n,o){
        $scope.criteria = n;
    });

    $scope.dependSel = critForm.dependSel();
    $scope.configDep = critForm.getDepend();
    $scope.$watch("configDep.lct_id",function(nvo){
        $scope.dependSel.target = nvo;
        if(nvo){
            $scope.currentCrit = $filter("filterSearch")($scope.criteria,[nvo])[0];

        }
    });

    $scope.creating = false;

    $scope.addDepend = function(deps){
        $scope.creating = true;
        critForm.setDepend(deps)
    };

    $scope.visibility = [
        {
            id:'true',
            icon:"eye_true.png"
        },
        {
            id:'false',
            icon:"eye_false.png"
        }
    ];

    $scope.closeDepend = function(){
        saveDepend().then($scope.$parent.closeDepend)
    };
    $scope.toList = function(){
        saveDepend().then(function(){
            $scope.creating=false;
        })
    };


    function clearDepend(){
        $scope.configDep.id = false;
        $scope.configDep.parent_id = false;
        $scope.configDep.operator = '';
        $scope.configDep.condition = '';
        $scope.configDep.condition = null;
        /*$scope.setDepend.$setPristine();
        $scope.setDepend.$setUntouched();*/
    }


    function saveDepend(){
        var defer = $q.defer();
        var promise = defer.promise;


        if($scope.configDep.parent_id && $scope.configDep.operator!='' && $scope.configDep.condition != '' && $scope.configDep.condition != null){
            criterios.put({type:"saveDep"},$scope.configDep,function(data){
                $scope.configDep.id = data.id;
                updateDependency($scope.configDep,data.action);
                setNotif.addNotif("ok", "GUARDADO!!", [
                ],{autohidden:1000});
               defer.resolve();
            });
        }else{
            setNotif.addNotif("alert", "los datos estan incompletos que desea hacer?", [
                {
                    name:"descartarlos",
                    action:function(){
                        clearDepend();
                        defer.resolve();
                    }
                },
                {
                    name:"Corregir",
                    action:function(){
                        defer.reject();
                    }
                }
            ]);
        }

        return promise;

    }

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
        //console.log($scope.criteria);
        $scope.currentCrit = angular.copy($scope.currentCrit);
        idx = $scope.criteria.indexOf($scope.currentCrit);
        $scope.criteria.splice(idx,1,$scope.currentCrit);
        clearDepend();
    };


    $scope.getoptSet = function(id){
        return $filter("filterSearch")($scope.listOptions ,[id])[0];
    };

    $scope.checkValid = function(){
        return ($scope.configDep.parent_id && $scope.configDep.operator!='' && $scope.configDep.condition != '' && $scope.configDep.condition != null);
    };
    
    $scope.showAlert = function(){
        
        setNotif.addNotif("error", "datos incomṕletos", [
        ],{autohidden:1000});
    };

    $scope.shower = function(a,x){
        return a.cfg=='all' || a.cfg.indexOf(x) != -1;
    };

    $scope.operator = [
        {
            op:"=",
            cfg:"all",
            descripcion:" == "
        },{
            op:">",
            cfg:["texto","numerico"],
            descripcion:" > "
        },{
            op:"<",
            cfg:["texto","numerico"],
            descripcion:" < "
        },{
            op:"!=",
            cfg:["texto","numerico"],
            descripcion:" != "
        },{
            op:">>",
            cfg:["texto","numerico"],
            descripcion:" exist "
        }
    ];
    $scope.setCfg = function(cfg,val){
        $scope.configDep[cfg] = val;
    };

    $scope.$watch("configDep.parent_id",function(nvo){
        $scope.dependSel.parent = nvo;
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
                    }
                })
            });


        }
    };
})
