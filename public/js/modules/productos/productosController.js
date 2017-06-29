MyApp.factory('productos', ['$resource',function ($resource) {
        return $resource('productos/:type/:id/:sec', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id:"",sec:""}, isArray: true},
            filt: {method: 'POST', cancellable:true, params: {type: "",id:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

//GLOBAL


MyApp.service("productsServices",function(masters,masterSrv,criterios,productos,mastersCrit,$filter){
    var providers = masterSrv.getProvs();
    var listProv = productos.query({type:'provsProds'});
    var prov ={};
    var bckup = null;
    var criteria = {line:false,criteria:[]};

    var prod = {id:false,datos:{}};
    var extraList = {
        common:{
            data:[],
            filter:{},
            order:"id"
        },
        rela:{
            data:[],
            filter:{},
            order:"id"
        }
    };
    var commonDetail = {
        linea:"",
        sublinea:"",
        codigo:"",
        descripcion:"",
        serial:"",
        id:false,
        parent:false,
        prod:false,
        comment:""
    };
    var prodToSave = {
        id:false,
        prov:false,
        line:false,
        serie:"",
        cod:"",
        desc:"",
        prodCrit:[]
    };
    
    
    return{
        getProvs:function(){
            return providers;
        },
        getAssign:function(){
            return listProv;
        },
        setProvprod:function(item){

            if(typeof(item)!="boolean" && typeof(item)!="object" ){
                item  = $filter("filterSearch")(providers,[item])[0];
            }
            prov.id = item.id || false;
            prov.razon_social = item.razon_social|| "";
            prov.siglas = item.siglas|| "";
            prov.tipo_id = item.tipo_id|| false;
            prodToSave.prov = item.id || false;
        },
        getProv:function(){
            return prov;
        },
        setProd:function(item){
            console.log("entrooo")
            prod.id = item.id || false;
            prod.datos = item || [];
            bckup = angular.copy(prod.datos);
            prodToSave.id = item.id || false;
            //prodToSave.prov = item.prov_id || false;
            prodToSave.line = item.linea_id || false;
            prodToSave.serie = item.serie || false;
            prodToSave.cod = item.codigo || false;
            prodToSave.desc = item.descripcion || false;
            extraList.common.data = prod.datos.commons || [];
            extraList.rela.data = prod.datos.relationed || [];
        },
        syncProd : function(edit){
            prod.id = edit.id || null;
            prod.datos.id = edit.id || null;
            prod.datos.prov_id = edit.prov || null;
            prod.datos.prov = {id:edit.prov,razon_social: $filter("filterSearch")(providers,[edit.prov])[0].razon_social}
            prod.datos.linea_id = edit.line || null;
            prod.datos.serie = edit.serie || null;
            prod.datos.codigo = edit.cod || null;
            prod.datos.descripcion = edit.desc || null;
        },
        showChange:function(){

           return !angular.equals(prod.datos,bckup);
        },
        getProd : function(){
            return prod
        },/*
        getDataCrit : function(){
            return prod.datos.prod_crit;
        },*/
        getToSavedProd:function(){
            return prodToSave;
        },
        getLists : function(){
            return extraList;
        },
        getCommon : function(){
            return commonDetail;
        },

        getCriteria:function(){
            return criteria;
        }

    }
});

MyApp.controller('mainProdController',['$scope', 'setNotif','productos','$mdSidenav','productsServices',function ($scope, setNotif,productos,$mdSidenav,productsServices) {
    $scope.nxtAction = null;
    $scope.$watchGroup(['module.layer','module.index'],function(nvo,old) {
        $scope.index = nvo[1];
        $scope.layerIndex = nvo[0];
        $scope.layer = nvo[0];
    });

    $scope.openForm = function(id){
        $scope.LayersAction({open:{name:"prodLayer3"},before:function(){
            productsServices.setProd(id);
        }});
    };

    $scope.prevLayer = function(){
        if($scope.index==1 && productsServices.showChange()){
            setNotif.addNotif("alert","ha realizado cambios en el producto, desea salir",[
                {
                    name:"Si",
                    action:function(){
                        $scope.LayersAction({close:true,before:function(){
                            productsServices.setProvprod(false);
                        }});
                    },
                    default:defaultTime
                },
                {
                    name:"No",
                    action:function(){

                    }
                }
            ]);
        }else{
            $scope.LayersAction({close:true});
        }

    };


    // Acciones de la capa resumen -------------------------
    $scope.goToResumen = function(id){
        $scope.LayersAction({open:{name:"prodLayer6"}});
    };

    $scope.goToEnd = function(){
        $scope.LayersAction({close:{all:true,before:function(){
            //critForm.setLine(false);
        },
            after:function(){
                setNotif.addNotif("ok", "El producto se ha finalizado correctamente", [
                ],{autohidden:2000});
            }}});
    };
    // -------------------------------------------------------


    $scope.prod = productsServices.getToSavedProd();

    $scope.items = []

}]);

MyApp.controller('listProdController',['$scope', 'setNotif','productos','productsServices',function ($scope, setNotif,productos,productsServices) {
    $scope.listProvs = {
        provs:productsServices.getProvs(),
        withpProv:productsServices.getAssign()
    }
    $scope.prov = productsServices.getProv();

    
    $scope.getByProv = function(prov,e){

        if(productsServices.showChange() && $scope.prov.id){
            setNotif.addNotif("alert","ha realizado cambios en el producto, desea cambiarse",[
                {
                    name:"Si",
                    action:function(){
                        $scope.$parent.LayersAction({close:{all:true,before:function(){
                            productsServices.setProvprod(prov);
                            productsServices.setProd(false);

                        },
                            after:function(){
                                $scope.$parent.LayersAction({open:{name:"prodLayer1"}});
                            }}});


                    },
                    default:defaultTime
                },
                {
                    name:"No",
                    action:function(){

                    }
                }
            ]);
        }else {
            if($scope.$parent.index > 0){
                $scope.$parent.LayersAction({close:{all:true,before:function(){
                    productsServices.setProvprod(prov);
                    productsServices.setProd(false);
                },
                    after:function(){
                        $scope.$parent.LayersAction({open:{name:"prodLayer1"}});
                    }}});
            }else{
                $scope.$parent.LayersAction({open:{name:"prodLayer1",before:function(){
                    productsServices.setProvprod(prov);
                    productsServices.setProd(false);
                }}});
            }


        }

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
        $scope.listByProv.data = (n.id)?productos.query({type:'prodsByProv',id:n.id}):[];
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


MyApp.controller('prodSumary',['$scope', 'setNotif','productos','productsServices','$timeout',function ($scope, setNotif,productos,productsServices,$timeout) {
    $scope.prod = productsServices.getProd();


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

MyApp.controller('createProd',['$scope','$timeout', 'setNotif','productos','productsServices','masterSrv',function ($scope,$timeout, setNotif,productos,productsServices,masterSrv) {
    $scope.listProviders = productsServices.getProvs();
    $scope.lines = masterSrv.getLines();
    $scope.prod = productsServices.getToSavedProd();
    $scope.prodCrit = [];
    $scope.criteria = [];
    //$scope.dataCrit = [];
    $scope.criterioShared = productsServices.getCriteria();
    $scope.$watch("prod.prov",function(n,o){
        $timeout(function(){
            if(typeof(n)== "undefined"){
                return false;
            }
            if(n!=o){
                productsServices.setProvprod(n);
            }
        },0)

    });
   /* $scope.$watch("prod.id",function(n,o){


    });*/


    $scope.$watchCollection("prod",function(n,o){
        if(n.line && (n.line!=o.line)){

                productos.query({ type:"getCriterio",id:n.line,sec:n.id},function(data){
                    $scope.prodCrit.splice(0,$scope.prodCrit.length);
                    $timeout(function(){
                        $scope.criteria = data;
                        $scope.criterioShared.line = n.line;
                        $scope.criterioShared.criteria = data;
                    },0);
                });


        }



    });

    $scope.saveProd = function(){

        if($scope.prodMainFrm.$invalid || $scope.prodMainFrm.$invalid){
            return false;
        }
      $scope.prod.prodCrit = $scope.prodCrit;
      productos.put({type:"prodSave"},$scope.prod,function (data) {
          if(data.action == "new"){
              $scope.prod.id = data.id;
              productsServices.syncProd($scope.prod);
              setNotif.addNotif("ok","producto Creado",[],{autohidden:3000});
          }else if(data.action == "upd"){
              productsServices.syncProd($scope.prod);
              setNotif.addNotif("ok","se actualizaron los datos",[],{autohidden:3000});
          }

      })

        $scope.$parent.LayersAction({open:{name:"prodLayer4"}});
    };

    $scope.isValid = function(){
        if($scope.prodMainFrm.$invalid ||  $scope.prodCritFrm.$invalid){
            return false;
        }
        return true;
    }
}]);



MyApp.controller('extraDataController',['$scope', 'setNotif','productos','$mdSidenav','productsServices','popUpService','App','generic',function ($scope, setNotif,productos,$mdSidenav,productsServices,popUpService,App,generic) {
    $scope.prod = {
        id:false,
        pntBuy:"",
        pntSald:""
    };
    $scope.misc = {
        id:false,
        storage:"",
        cantDis:"",
        unitDis:"",
        cantLib:"",
        unitLib:"",
        cantDon:"",
        unitDon:"",
        reqStrg:"",
        tools:""
    };
    $scope.units  = generic.units();
    $scope.prodMain = productsServices.getProd();
    $scope.prodEdit = productsServices.getToSavedProd();
    $scope.$watch("prodMain.id",function(n,o){
        if(App.getSeccion().key!=="productos"){
            return false;
        }
        if(n){
            $scope.prod.id = n;
            $scope.misc.id = n;

            $scope.prod.pntBuy = parseFloat($scope.prodMain.datos.point_buy);
            $scope.prod.pntBuyU = parseInt($scope.prodMain.datos.pbuy_unit);
            $scope.prod.pntSald = parseFloat($scope.prodMain.datos.point_credit);
            $scope.prod.pntSaldU = parseInt($scope.prodMain.datos.pcred_unit);
            $scope.misc.storage = $scope.prodMain.datos.almacen_id;
            $scope.misc.cantDis = $scope.prodMain.datos.descarte;
            $scope.misc.unitDis = parseInt($scope.prodMain.datos.descar_unit);
            $scope.misc.cantLib = $scope.prodMain.datos.biblioteca;
            $scope.misc.unitLib = parseInt($scope.prodMain.datos.biblioteca_unit);
            $scope.misc.cantDon = $scope.prodMain.datos.donaciones;
            $scope.misc.unitDon = parseInt($scope.prodMain.datos.dona_unit);
            $scope.misc.reqStrg = $scope.prodMain.datos.notas_alma;
            $scope.misc.tools = $scope.prodMain.datos.herramientas;
            
        }
    });

    $scope.$watch("prodEdit.id",function(n,o){
        if(App.getSeccion().key!=="productos"){
            return false;
        }
        if(n) {
            $scope.prod.id = n;
            $scope.misc.id = n;
        }
    });

    $scope.saveExtraData = function(frm){
        if(App.getSeccion().key!=="productos"){
            return false;
        }
       if(!$scope.$eval(frm).$pristine && $scope.$eval(frm).$valid){
           if(frm=="frmPoints"){
               productos.put({type:"savePoints"},$scope.prod,function (data) {
                   if(data.action!="equal"){
                       $scope.prodMain.datos.point_buy = $scope.prod.pntBuy;
                       $scope.prodMain.datos.point_cred = $scope.prod.pntSald;
                       setNotif.addNotif("ok","datos guardados",[],{autohidden:1500});
                       $scope.$eval(frm).$setPristine();
                       $scope.$eval(frm).$setUntouched();
                   }
                   /*$scope.list.common.data.splice(idx,1);*/
               })
           }else if(frm=="frmMisc"){
               productos.put({type:"saveMisc"},$scope.misc,function (data) {
                   if(data.action!="equal"){
                       setNotif.addNotif("ok","datos guardados",[],{autohidden:1500});
                       $scope.$eval(frm).$setPristine();
                       $scope.$eval(frm).$setUntouched();
                   }
                   /*$scope.list.common.data.splice(idx,1);*/
               })
           }

       }
    }

    $scope.goToAnalisis = function () {
        productsServices.showChange();
        $scope.LayersAction({open:{name:"prodLayer5"}});
    };

    $scope.list = productsServices.getLists();

    $scope.editCommon = function(data){
        popUpService.popUpOpen({
            'prodComp':{
                before:function(){
                    var prod = productsServices.getCommon();
                    prod.linea = data.line.linea;
                    prod.codigo = data.codigo;
                    prod.descripcion = data.descripcion;
                    prod.serial = data.serial;
                    prod.id = data.pivot.id;
                    prod.parent = data.pivot.parent_prod;
                    prod.prod = data.pivot.comp_prod;
                    prod.comment = data.pivot.comentario;
                    prod.cant = data.pivot.cantidad;
                    return true;
                },
                after:null
            }
        })
    }

    $scope.delete = function(idx,dato){
        setNotif.addNotif("error","va desvincular este producto del compuesto, esta seguro?",[
            {
                name:"Si, si lo estoy",
                action:function(){
                    productos.put({type:"prodDelCommon"},dato,function (data) {
                        setNotif.addNotif("ok","producto eliminado",[],{autohidden:3000});
                        $scope.list.common.data.splice(idx,1);
                    })
                },
                default:defaultTime
            },
            {
                name:"No, olvidalo",
                action:null
            }
        ]);
    }
    
    $scope.bef=function(){

        /*var prod = productsServices.getCommon();
        prod.linea = "";
        prod.codigo = "";
        prod.descripcion = "";
        prod.serial = "";
        prod.id = false;
        prod.prod = false
        prod.comment = "";
        prod.cant = "";*/
        return true;

    };
    $scope.aft=function(){
        console.log("AFTER");
    }
}]);
MyApp.controller('addCompController',['$scope', 'setNotif','productos','$mdSidenav','productsServices','$timeout','masterSrv',"$filter","$q",function ($scope, setNotif,productos,$mdSidenav,productsServices,$timeout,masterSrv,$filter,$q) {
    $scope.prod = productsServices.getToSavedProd();
    $scope.lines = masterSrv.getLines();
    $scope.list = productsServices.getLists();
    $scope.filtCm = {
        line:false,
        sublin:false,
        desc:"",
        prod:false
    };
    $scope.prodDetail = productsServices.getCommon();

    $scope.$watch("prod.id",function(n,o){
        $scope.filtCm.prod = n;
        $scope.prodDetail.parent = n;
       /* if(o && !n){
            $scope.filtCm.line=false;
            $scope.filtCm.sublin=false;
            $scope.filtCm.prod=false;
            $scope.filtCm.desc="";
            $scope.filterLs.splice(0,$scope.filterLs.length);
        }*/
    });

    var clear = function(){

        $scope.prodDetail.prod = false;
        $scope.filtCm.line=null;
        $scope.filtCm.sublin='';
        $scope.filtCm.prod='';
        $scope.filtCm.desc="";
        $scope.filterLs.splice(0,$scope.filterLs.length);
        $scope.prodDetail.codigo = "";
        $scope.prodDetail.descripcion = "";
        $scope.prodDetail.linea = "";
        $scope.prodDetail.serie = "";
        $scope.prodDetail.cant = "";
        $scope.prodDetail.comment = "";

    }

    $scope.searching = false;

    $scope.filterLs = [];

    var timeOut = null;
    $scope.$watchCollection("filtCm",function(n,o){
        $scope.searching = true;
        $timeout.cancel(timeOut);
        if(n.line || n.sublin || n.desc != ""){
            timeOut = $timeout(function(){
                productos.filt({ type:"getFiltersProd"},n,function(data){
                    $scope.filterLs.splice(0,$scope.filterLs.length);
                    angular.forEach(data,function (v,k) {
                        $scope.filterLs.push(v);
                    });
                    $scope.searching = false;

                });
            },2000);
        }else{
            $scope.filterLs.splice(0,$scope.filterLs.length);
            $scope.searching = false;
        }

    });

    $scope.setDetail = function(dat){
        $scope.prodDetail.codigo = dat.codigo;
        $scope.prodDetail.descripcion = dat.descripcion;
        $scope.prodDetail.linea = dat.line.linea;
        $scope.prodDetail.serie = dat.serie;
        $scope.prodDetail.comment = dat.comentario;
        $scope.prodDetail.prod = dat.id;
    };

    var saveCommon = function(){
        var def = $q.defer();
        var promise = def.promise;
        productos.put({type:"prodSaveCommon"},$scope.prodDetail,function (data) {
            if(data.action == "new"){
                $scope.prodDetail.id = data.id;
                setNotif.addNotif("ok","producto Agregado",[],{autohidden:3000});
                $scope.list.common.data.push({
                    pivot:{
                        id:data.id,
                        common_id:$scope.prodDetail.prod,
                        parent_prod:$scope.prodDetail.parent
                    },
                    codigo:$scope.prodDetail.codigo,
                    descripcion:$scope.prodDetail.descripcion,
                    linea:{linea:$scope.prodDetail.codigo}
                })
                def.resolve("ok");
            }else if(data.action == "upd"){
                setNotif.addNotif("ok","se actualizaron los datos",[],{autohidden:3000});
                def.resolve("ok");
            }

        })

        return promise;
    };



    $scope.onClose = function(){

        if(($scope.filtCm.line || $scope.filtCm.sublin || $scope.filtCm.desc != "" ) && !$scope.prodDetail.prod){
            var ret = {wait : null};

            setNotif.addNotif("alert","ha realizado una busqueda, pero no selecciono nada, esta seguro?",[
                {
                    name:"Si, si lo estoy",
                    action:function(){
                        clear();
                       ret.wait=true;
                    },
                    default:defaultTime
                },
                {
                    name:"No, dejame cambiarlo",
                    action:function(){
                        ret.wait=false;
                    }
                }
            ]);
            return ret;
        }else if($scope.prodDetail.prod){
            saveCommon().then(clear);
            return true;
        }else{
            clear();
            return true;
        }

    }

}]);

MyApp.controller('addRelaController',['$scope', 'setNotif','productos','$mdSidenav','productsServices','$timeout','masterSrv',"$filter","$q",function ($scope, setNotif,productos,$mdSidenav,productsServices,$timeout,masterSrv,$filter,$q) {
    $scope.prod = productsServices.getToSavedProd();
    $scope.lines = masterSrv.getLines();
    $scope.list = productsServices.getLists();
    $scope.provs = productsServices.getProvs(),

    $scope.filtRl = {
        line:false,
        sublin:false,
        prov:false,
        desc:"",
        prod:false
    };
    $scope.prodDetail = productsServices.getCommon();

    $scope.$watch("prod.id",function(n,o){
        $scope.filtRl.prod = n;
        $scope.prodDetail.parent = n;

    });

    var clear = function(){

        $scope.prodDetail.prod = false;
        $scope.filtRl.line=false;
        $scope.filtRl.sublin=false;
        $scope.filtRl.prov=false;
        $scope.filtRl.prod=false;
        $scope.filtRl.desc="";
        $scope.filterLs.splice(0,$scope.filterLs.length);
        $scope.prodDetail.codigo = "";
        $scope.prodDetail.descripcion = "";
        $scope.prodDetail.linea = "";
        $scope.prodDetail.serie = "";
        $scope.prodDetail.cant = "";
        $scope.prodDetail.comment = "";

    };

    $scope.searching = false;

    $scope.filterLs = [];

    var timeOut = null;
    $scope.$watchCollection("filtRl",function(n,o){
        $scope.searching = true;
        $timeout.cancel(timeOut);
        if(n.prov ||n.line || n.sublin || n.desc != ""){
            timeOut = $timeout(function(){
                productos.filt({ type:"getFiltersProd"},n,function(data){
                    $scope.filterLs.splice(0,$scope.filterLs.length);
                    angular.forEach(data,function (v,k) {
                        $scope.filterLs.push(v);
                    });
                    $scope.searching = false;

                });
            },2000);
        }else{
            $scope.filterLs.splice(0,$scope.filterLs.length);
            $scope.searching = false;
        }

    });

    $scope.setDetail = function(dat){
        $scope.prodDetail.codigo = dat.codigo;
        $scope.prodDetail.descripcion = dat.descripcion;
        $scope.prodDetail.linea = dat.line.linea;
        $scope.prodDetail.serie = dat.serie;
        $scope.prodDetail.prod = dat.id;
    };

    var saveRela = function(){
        var def = $q.defer();
        var promise = def.promise;
        productos.put({type:"prodSaveRela"},$scope.prodDetail,function (data) {
            if(data.action == "new"){
                $scope.prodDetail.id = data.id;
                setNotif.addNotif("ok","producto Agregado",[],{autohidden:3000});
                $scope.list.rela.data.push({
                    pivot:{
                        id:data.id,
                        common_id:$scope.prodDetail.prod,
                        parent_prod:$scope.prodDetail.parent
                    },
                    codigo:$scope.prodDetail.codigo,
                    descripcion:$scope.prodDetail.descripcion,
                    linea:{linea:$scope.prodDetail.codigo}
                })
                def.resolve("ok");
            }else if(data.action == "upd"){
                setNotif.addNotif("ok","se actualizaron los datos",[],{autohidden:3000});
                def.resolve("ok");
            }


        })
        return promise;
    };



    $scope.onClose = function(){
        if(($scope.filtRl.line || $scope.filtRl.sublin || $scope.filtRl.desc != "" ) && !$scope.prodDetail.prod){
            var ret = {wait : null};

            setNotif.addNotif("alert","ha realizado una busqueda, pero no selecciono nada, esta seguro?",[
                {
                    name:"Si, si lo estoy",
                    action:function(){
                        clear();
                        ret.wait=true;
                    },
                    default:defaultTime
                },
                {
                    name:"No, dejame cambiarlo",
                    action:function(){
                        ret.wait=false;
                    }
                }
            ]);
            return ret;
        }else if($scope.prodDetail.prod){
            saveRela().then(clear);
            return true;
        }else{
            clear();
            return true;
        }
    }

}]);

MyApp.controller('prodResumen',['$scope', 'setNotif','productos','productsServices','$timeout', function ($scope, setNotif,productos,productsServices,$timeout) {
    $scope.prod = productsServices.getProd();

    $scope.crit = productsServices.getCriteria();

	$scope.prodCrir = 
	[{
		"campo" : "Serie",
		"valor" : "Algo"
	},{
		"campo" : "Codigo",
		"valor" : "Algo"
	},{
		"campo" : "Ancho",
		"valor" : "111"
	},{
		"campo" : "Profundidad",
		"valor" : "111"
	},{
		"campo" : "Unidas",
		"valor" : "Pieza"
	},{
		"campo" : "Caracteristicas",
		"valor" : "Mesedora"
	},{
		"campo" : "Voltaje",
		"valor" : "220V"
	},{
		"campo" : "Acabdo",
		"valor" : "Pulido"
	},{
		"campo" : "Acabado Base",
		"valor" : "Cromo"
	}];

}]);



