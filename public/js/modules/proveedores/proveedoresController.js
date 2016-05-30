 //var proveedores = angular.module('proveedores', []);


//###########################################################################################3
//##############################REST service (factory)#############################################3
//###########################################################################################3
MyApp.factory('masters', ['$resource',
    function ($resource) {
        return $resource('master/:type/:id', {}, {
            query: {method: 'GET', params: {type: "",id:""}, isArray: true}
        });
    }
]);


MyApp.factory('providers', ['$resource',
    function ($resource) {
        return $resource('provider/:type/:id_prov', {}, {
            query: {method: 'GET', cancellable:true, params: {type: "",id_prov:""}, isArray: true},
            get:   {method: 'POST', params: {type: ""}, isArray: false},
            put:   {method: 'POST', params: {type: ""}, isArray: false}
        });
    }
]);

MyApp.service("masterLists",function(masters) {
    var coins =[];
    var countries = [];
    var languaje = [];
    var typeDir = [];
    var provType = [];
    var provTypeSend = [];
    var prodLines = [];
    var ports = [];
    return {
        setMain:function(){
            countries = masters.query({ type:"getCountries"});
            typeDir =  masters.query({ type:"addressType"});
            provType = masters.query({ type:"getProviderType"});
            provTypeSend = masters.query({ type:"getProviderTypeSend"});
            coins = masters.query({ type:"getCoins"});
            prodLines = masters.query({ type:"prodLines"});
            languaje = masters.query({type:"languajes"});
            ports = masters.query({type:"getPorts"});
        },
        getCountries:function(){
            return countries;
        },
        getTypeDir:function(){
            return typeDir;
        },
        getTypeProv:function(){
            return provType;
        },
        getSendTypeProv:function(){
            return provTypeSend;
        },
        getAllCoins:function(){
            return coins;
        },
        getLines : function(){
            return prodLines;
        },
        getLanguaje : function(){
            return languaje;
        },
        getPorts : function(){
            return ports;
        }
    }
});

MyApp.service("listCoins",function(providers) {
    var selCoins =[];
    var coinIds = [];

    return {
        setProv:function(id_prov){

            if(id_prov) {
                selCoins = providers.query({type: "provCoins", id_prov: id_prov || 0});
                coinIds = providers.query({type: "listCoin", id_prov: id_prov || 0})
            }else{
                selCoins = [];
                coinIds = [];
            }
        },
        getCoins:function(){
            return selCoins;
        },
        addCoin:function(coin){
            selCoins.push(coin)
            coinIds.push(coin.id);
        },
        getIdCoins: function(){
            return coinIds;
        }
    }
});

/*filtro para filtrar los option de los selects basandose en un array */
MyApp.filter('filterSelect', function() {
    return function(arr1, arr2) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        return arr1.filter(function(val) {
            return arr2.indexOf(val.id) === -1;//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
        });
    }
});


MyApp.filter('filterSearch', function() {
     return function(arr1, arr2) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
         return arr1.filter(function(val) {
             return arr2.indexOf(val.id) !== -1;//el punto id trunca a que el filtro sera realizado solo por el atributo id del array pasado
         });
     }
 });

MyApp.filter('customFind', function() {
    return function(arr1,arr2, func) { //arr2 SIEMPRE debe ser un array de tipo vector (solo numeros)
        return arr1.filter(function(val) {
            return func(val,arr2);
        });
    }
});

MyApp.controller('AppCtrl', function ($scope,$mdSidenav,$http,setGetProv,masters,masterLists,setGetContac,setNotif) {
    $scope.expand = false;
    $scope.prov=setGetProv.getProv();
    $scope.chang = setGetProv.getChng();
    $scope.$watch('prov.id',function(nvo,old) {
        if(nvo && $scope.prov.new){
            $scope.prov.new = false;
            $scope.enabled = false;
            $scope.edit = true;
        }
    });
/*    $scope.isNew = function(){

    };*/

    var historia= [15];
    $scope.index = index=0;
    var base =264;

    function openLayer(layr){
        $scope.showNext(false);
        layer = layr||$scope.nextLyr;
        if(historia.indexOf(layer)==-1 && layer!="END"){
            var l=angular.element("#"+layer);
            $scope.index++;
            var w= base+(24*$scope.index);
            l.css('width','calc(100% - '+w+'px)');
            $mdSidenav(layer).open();
            historia[$scope.index]=layer;
            return true;
        }else if(historia.indexOf(layer)==-1 && layer=="END"){
            closeLayer(true)
        }

    }

    function closeLayer(all){
        if(all){
            while($scope.index!=0){
                var layer=historia[$scope.index];
                historia[$scope.index]=null;
                $scope.index--;
                $mdSidenav(layer).close();
            }
        }else{
            var layer=historia[$scope.index];
            historia[$scope.index]=null;
            $scope.index--;
            $mdSidenav(layer).close();
        }
        if($scope.index==0){
            setGetProv.cancelNew();
            setGetProv.setProv(false);
        }

    }
    $scope.openLayer = openLayer;
    $scope.closeLayer = closeLayer;

    $scope.types = masterLists.getTypeProv();

    $scope.envios =masterLists.getSendTypeProv();

    $scope.data = {
        cb1: true
    };

    $scope.setProv = function(prov){
        console.log(setGetProv.haveChang())
        if(setGetProv.haveChang()){
            openLayer("layer5");
        }else{
            chngProv(prov);
        }

        //}

    };

    var chngProv = function(prov){
        closeLayer(true);
        setGetProv.cancelNew();
        $scope.edit = false;
        $scope.enabled = true;
        setGetProv.setProv(prov.item);
        openLayer("layer0");//modificado para mostrar resumen proveedor

    };

    $scope.showAlert = function(){
      console.log(setGetProv.getChng());
    };


    $scope.addProv = function(){
        /*if($scope.edit){
            var quit = confirm("desea crear un nuevo proveedor?");
            if(quit) {
                newProv();
            }
        }else{*/
            newProv();
        //}
    };

    var newProv = function(){
        setGetProv.setProv(false);
        closeLayer(true);
        $scope.edit = false;
        $scope.enabled = true;
        $scope.openLayer("layer1");
        setGetProv.addToList({
            razon_social: "Nuevo Proveedor  ",
            contrapedido: 0,
            tipo_envio_id: 0,
            id: false,
            siglas:""
        });
    };
    $scope.editProv = function(){
        $scope.edit = true;
        $scope.enabled =false;
        openLayer('layer1');
    };

    $scope.showNext = function(status,to){
        if(status){
            $scope.nextLyr = to;
            //if($scope.prov.id && to!="layer1") //excepcion creada apra layer1 desde resumen
                $mdSidenav("NEXT").open()
        }else{
            $mdSidenav("NEXT").close()
        }
    };
    masterLists.setMain();
    setGetContac.setList();
    $scope.menuExpand = function(){
        jQuery("#menu").animate({height:"200px"},500);
    }
});



MyApp.controller('resumenProv', function ($scope,setGetProv,providers) {
    $scope.provider = setGetProv.getProv();
    $scope.prov = {tiemposP:[],tiemposT:[],direcciones:[]};
    $scope.$watch('provider.id',function(nvo){
        $scope.prov = setGetProv.getFullProv();
    })
});



MyApp.controller('provCoins', function ($scope,listCoins,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.coins = listCoins.getCoins();
    })


});

MyApp.controller('ListPaises', function ($scope,masterLists) {
    $scope.paises = masterLists.getCountries();
});


MyApp.controller('ListHerramientas', function ($scope) {
    $scope.tools = [
        {
            tool: 'Calculadora',
            url: '/inicio'
        }, {
            tool: 'Extensiones',
            url: '/proveedores'
        }, {
            tool: 'Hora Mundial',
            url: '/productos'
        }, {
            secc: 'Factor',
            url: '/pagos'
        }];
});

/*MyApp.run(['$route', function($route)  {
 $route.reload();
 }]);*/

MyApp.controller('ListProv', function ($scope,$http,setGetProv,providers) {
    setGetProv.setList( $scope.todos = providers.query({type:"provList"}));
    $scope.prov = setGetProv.getProv();
});

//###########################################################################################3
//###################Service Providers (comunication betwen controllers)###################3
//###########################################################################################3
MyApp.service("setGetProv",function($http,providers,$q){
    var prov = {id:false,type:"",description:"",siglas:"",envio:"",contraped:true,limCred:0};
    var fullProv = {};
    var itemsel = {};
    var list = {};
    var statusProv = {};
    var rollBack = {"dataProv":{}};
    var changes = {"dataProv":{},"dirProv":{},"valName":{}};
    return {
        getProv: function () {
            return prov;
        },
        setProv: function(index) {
            if (index){
                itemsel = index;
                id = itemsel.id;
                providers.get({type:"getProv"},{id:id},function(data){
                    fullProv = data;
                    prov.id = data.id;
                    prov.description = data.razon_social;
                    prov.siglas = data.siglas;
                    prov.type = data.tipo_id;
                    prov.envio = data.tipo_envio_id;
                    prov.contraped = (data.contrapedido==1)?true:false;
                    rollBack.dataProv[parseInt(prov.id)] = angular.copy(prov);

                });

            }else{
                prov.id = false;prov.description = "";prov.siglas = "";prov.type = "";prov.envio = "";prov.contraped = false;
                itemsel = {};
                //rollBack.dataProv[0] = prov;
            }
        },
        updateItem: function(upd){
            console.log(upd.id)
            itemsel.id = upd.id;
            itemsel.razon_social = upd.description;
            itemsel.limCred = upd.limCred;
            itemsel.contrapedido = upd.contraped;
            itemsel.tipo_envio_id= upd.envio;

            //console.log(upd,itemsel)
        },
        setList : function(val){
            list = val;
            //itemsel.list[0];
        },
        addToList : function(elem){
            if(list[0].id){
                list.unshift(elem);
                itemsel = list[0];
            }

            //setProv(elem);
        },
        cancelNew : function(){
            if(!list[0].id){
                list.splice(0,1);
            }

        },
        seeList : function(){
            return list;
        },
        setComplete : function(field,value){
            statusProv[field]=value;
        },
        getStatus : function(){

        },
        getFullProv : function(){
            return fullProv;
        },
        seeNew : function(){
            return list.length;
        },
        addChng : function(val,action,form){
            if(action=="new" || !angular.equals(val,rollBack[form][val.id])){
                if(changes[form][val.id]){
                    changes[form][val.id].datos = val;
                    if(!(changes[form][val.id].action=="new" && action=="upd")){
                        changes[form][val.id].action = action;
                    }
                }else{
                    changes[form][val.id] = {
                        datos:val,
                        action:action
                    }
                }
            }else{
                delete changes[form][val.id];
            }


        },
        getChng : function(){
            return changes;
         },

        haveChang : function(){

            var i = 1;
            x = false;
            angular.forEach(changes,function(v,k){
                console.log(Object.keys(v).length)
                if(Object.keys(v).length>0){
                    x=true;
                    console.log("entro")
                }
            });
            return x;
        }
    };
});

function purgeJson (json){
    var exept = ["updated_at","created_at","deleted_at"];
    angular.forEach(json, function(value, key) {
        if(exept.indexOf(key)!==-1) {
            delete json[key];
        }else if(typeof value === 'object'){
             purgeJson (value);
         }
    });
}



//###########################################################################################3
//##############################FORM CONTROLLERS#############################################3
//###########################################################################################3
MyApp.controller('DataProvController', function ($scope,setGetProv,$mdToast,providers,$filter,setNotif) {
    $scope.inputSta = function(inp){
        $scope.toCheck = true;
    };
    $scope.showSimpleToast = function() {
        $mdToast.show(/*{
            template: "<md-toast style='width:100%'>prueba</md-toast>",
            hideDelay: 6000,
            position: 'bottom right'}*/
            $mdToast.simple()
                .textContent('guardado!')
                .hideDelay(3000)
        );
    };
    $scope.list = setGetProv.seeList();
    $scope.$watch('prov.id',function(nvo){
        $scope.localId = nvo
    });
    $scope.$watch('dtaPrv.envio',function(nvo){
        if(nvo==1 && !$scope.projectForm.$pristine){
            setNotif.addNotif("alert","un proveedor, solo aereo es muy extraño... estas seguro?",[{name:"Si, si lo estoy",action:function(){

            }},{name:"No, dejame cambiarlo",action:function(){

            }}]);
        }
    });
    $scope.check = function(elem){
        if($scope.projectForm[elem].$error.duplicate){
            setNotif.addNotif("alert","existe un Proveedor con el mismo nombre o siglas",[{name:"deshacer",action:function(){

            }}]);
        }
    };


    $scope.dtaPrv = setGetProv.getProv();
    $scope.$watchGroup(['projectForm.$valid','projectForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveProv"},$scope.dtaPrv,function(data){
                setGetProv.addChng($scope.dtaPrv,data.action,"dataProv");
                $scope.dtaPrv.id = data.id;
                $scope.projectForm.$setPristine();
                setGetProv.updateItem($scope.dtaPrv);
                if(data.action=="new"){
                    $scope.dtaPrv.new = true;
                    setNotif.addNotif("ok", "Proveedor agregado", [
                    ],{autohidden:3000});
                }
            });
        }
    });

});

//###########################################################################################3

MyApp.controller('provAddrsController', function ($scope,setGetProv,providers,masterLists,$filter,setNotif) {
    $scope.id = "provAddrsControllers";
    $scope.prov = setGetProv.getProv(); //obtiene en local los datos del proveedor actual
    var dirSel = {};
    $scope.tipos = masterLists.getTypeDir();
    $scope.paises = masterLists.getCountries();
    $scope.ports = masterLists.getPorts();
    /*escucha cambios en el proveedor seleccionado y carga las direcciones correspondiente*/
    $scope.$watch('prov.id',function(nvo){
        $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
        $scope.address = (nvo)?providers.query({type: "dirList", id_prov: $scope.prov.id || 0}):[];
        $scope.isShow = false;
    });
    $scope.$watch('address.length',function(nvo){
        setGetProv.setComplete("address",nvo);
    });
    $scope.$watch('dir.pais',function(nvo,old){
        var prev = (old != 0) ? $filter("filterSearch")($scope.paises, [old])[0].area_code.phone : "";
        $scope.dir.provTelf = (nvo != 0 && $scope.dir.provTelf=="") ? $scope.dir.provTelf.replace(prev, $filter("filterSearch")($scope.paises, [nvo])[0].area_code.phone) : $scope.dir.provTelf;
    });

    $scope.checkCode = function(){
        if($scope.dir.provTelf.indexOf($filter("filterSearch")($scope.paises, [$scope.dir.pais])[0].area_code.phone)==-1){
            setNotif.addNotif("alert","el codigo de area indicado no coincide con el pais seleccionado",[{name:"aceptar",acion:function(){}}])
        }
    }

    $scope.searchPort = function(ports,pais){
        return ports.pais_id == pais;
    };

    $scope.toEdit = function(addrs){
        dirSel = addrs.add;
        $scope.dir.id = dirSel.id;
        $scope.dir.id_prov = dirSel.prov_id;
        $scope.dir.direccProv = dirSel.direccion;
        $scope.dir.tipo = dirSel.tipo_dir;
        $scope.dir.pais = dirSel.pais_id;
        $scope.dir.provTelf = dirSel.telefono;
        $scope.dir.ports = dirSel.ports;
    };

    /*escuah el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['direccionesForm.$valid','direccionesForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveProvAddr"},$scope.dir,function(data){
                $scope.dir.id = data.id;
                setGetProv.addChng($scope.dir,data.action,"dirProv")
                $scope.direccionesForm.$setPristine();
                dirSel.id = $scope.dir.id;
                dirSel.direccion =  $scope.dir.direccProv;
                dirSel.tipo_dir=$scope.dir.tipo;
                dirSel.tipo=$filter("filterSearch")($scope.tipos,[$scope.dir.tipo])[0];
                dirSel.pais_id=$scope.dir.pais;
                dirSel.pais=$filter("filterSearch")($scope.paises,[$scope.dir.pais])[0];
                dirSel.telefono = $scope.dir.provTelf;
                dirSel.ports = $scope.dir.ports;
                if(data.action=="new"){
                    $scope.address.unshift(dirSel);
                    setNotif.addNotif("ok", "Nueva Direccion!", [
                    ],{autohidden:3000});
                }
            });
        }
    });

    $scope.rmAddres = function(elem){
        setNotif.addNotif("alert", "desea borrar esta direccion?", [
            {
                name: "SI",
                action: function () {
                    addr = elem.add;
                    console.log(addr)
                        providers.put({type:"delAddr"},addr,function(data){
                            setGetProv.addChng(addr,data.action,"dirProv");
                            $scope.address.splice(addr.$index,1);
                            $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "",ports:[],  id: false, id_prov: $scope.prov.id};
                            dirSel = {};
                            $scope.direccionesForm.$setUntouched();
                            setNotif.addNotif("ok", "Direccion borrada", [
                            ],{autohidden:3000});
                        });


                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.toElement).parents("#lyrAlert").length==0) {
            $scope.isShow = elem;
            if(!elem) {
                    $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "", id: false, id_prov: $scope.prov.id};
                    $scope.direccionesForm.$setUntouched();
                    if($scope.$parent.expand==$scope.id){
                        $scope.isShowMore = elem;
                        $scope.$parent.expand = false;
                    }

            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"provAddrsControllers":false;

    };


});



MyApp.controller('valcroNameController', function($scope,setGetProv,$http,providers,$mdSidenav,$filter,valcroNameDetail,setNotif) {
    $scope.prov = setGetProv.getProv(); //obtiene en local los datos del proveedor actual
    $scope.allName = providers.query({type:"allValcroName"});
    $scope.deps = [
        {
            id:1,
            icon:"icon-CarritoCompra"
        },
        {
            id:2,
            icon:"icon-Aereo"
        },
        {
            id:3,
            icon:"icon-Camion"
        }
    ];
    var valcroName = {};
    $scope.$watch('prov.id',function(nvo){
        $scope.valcroName = (nvo)?providers.query({type: "provNomValList", id_prov: $scope.prov.id || 0}):[];
        $scope.valName={id:false,name:"",departments:Object(),fav:"",prov_id:$scope.prov.id || 0};
    });

    $scope.exist = function(id,fav){
        if($scope.valName.departments[id]){
            return $scope.valName.departments[id].fav==fav;
        }else{
            return false;
        }
    };

    $scope.over = function(nomVal){
        if (nomVal) {
            $scope.overId = nomVal.name.id;
            $scope.valName.departments = Object();
            nomVal.name.departments.forEach(function (v, k) {
                var fav = {"fav": v.pivot.fav};
                $scope.valName.departments[v.id] = fav;

            })
        } else {
            $scope.overId = false;
            if($scope.valName.id){
                //$scope.valName.departments = Object();
                $scope.over({name:$filter("customFind")($scope.valcroName,$scope.valName.id,function(current,compare){return current.id==compare})[0]});
            }else{
                $scope.valName.departments = Object();
            }

        }

    }
    $scope.toEdit = function(nomVal){
        valcroName = nomVal.name;
        $scope.valName.id = valcroName.id;
        $scope.valName.prov_id = $scope.prov.id
        $scope.valName.fav = valcroName.fav;
        $scope.valName.name = valcroName.name;
        valcroName.departments.forEach(function(v,k){
            var fav = {"fav":v.pivot.fav};
            $scope.valName.departments[v.id] = fav;
        })
       /// console.log( $scope.valName.departments[v.id] = fav);
    };
    $scope.$watch('valcroName.length',function(nvo){
        setGetProv.setComplete("valcroName",nvo);
    });
    $scope.$watchGroup(['nomvalcroForm.$valid','nomvalcroForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            if($filter("customFind")($scope.valcroName,$scope.valName.name,function(current,compare){return current.name==compare}).length>1){
                //$scope.nomvalcroForm.$setValidity(false);
                setNotif.addNotif("alert","este nombre Vacro ya existe",[{name:"aceptar",action:function(){console.log("ok")}},{name:"cancelar",action:function(){console.log("error")}}]);
            }
            saveValcroname();
        }
    });
    function saveValcroname(){
        providers.put({type: "saveValcroName"}, $scope.valName, function (data) {
            $scope.valName.id = data.id;
            setGetProv.addChng($scope.valName,data.action,"valName");
            $scope.nomvalcroForm.$setPristine();
            $scope.valName.id = data.id;
            valcroName.id = data.id;
            valcroName.name = $scope.valName.name;
            var temp = [];
            var i = 0;
                angular.forEach($scope.valName.departments,function(k,v){
                if(k!=1){
                    temp.push({id: v,pivot:{fav:k.fav}});
                }
                if(i==Object.keys($scope.valName.departments).length-1){
                    valcroName.departments = temp;
                }
                i++;
            });
            if (data.action == "new") {
                valcroName.departments = Object();
                $scope.valName.departments = Object();
                $scope.valcroName.unshift(valcroName);
                setNotif.addNotif("ok", "Nuevo Nombre Valcro", [
                ],{autohidden:3000});
            }
        });
    };

    $scope.rmValName = function(name){

        setNotif.addNotif("alert", "desea borrar este nombre valcro", [
            {
                name: "SI",
                action: function () {
                    chip = name.name;
                    $http({
                        method: 'POST',
                        url: "provider/delValcroName",
                        data: chip
                    }).then(function successCallback(response) {
                        setGetProv.addChng(chip,response.data.action,"valName");
                        $scope.valcroName.splice(name.$index,1);
                        $scope.valName={id:false,name:"",departments:Object(),fav:"",prov_id:$scope.prov.id || 0};
                        valcroName = {};
                        $scope.nomvalcroForm.$setUntouched();
                        setNotif.addNotif("ok", "Nombre valcro borrado", [
                        ],{autohidden:3000});
                    }, function errorCallback(response) {
                        console.log("error=>", response)
                    });
                }
            },
            {
                name: "no",
                action: function () {
                }
            }
        ]);

    };

    $scope.showGrid = function(elem,a){
        if(!elem){
            if(jQuery(a.toElement).parents("#lyrAlert").length==0){

                if($scope.valName.id && Object.keys($scope.valName.departments).length<=0){
                    setNotif.addNotif("alert","el nombre valcro no fue asignado a ningun departamento, desea finalizar",[
                        {
                            name:"SI",
                            action:function(){
                                $scope.isShow = elem;
                                $scope.valName={id:false,name:"",departments:Object(),fav:"",prov_id:$scope.prov.id || 0};
                                valcroName = {};
                                $scope.nomvalcroForm.$setUntouched();
                            }
                        },
                        {
                            name:"NO",
                            action:function(){
                                jQuery(a.toElement).focus();
                            }
                        }
                    ]);
                }else{
                    $scope.isShow = elem;
                    $scope.valName={id:false,name:"",departments:Object(),fav:"",prov_id:$scope.prov.id || 0};
                    valcroName = {};
                    $scope.nomvalcroForm.$setUntouched();
                }

            }

        }else{
            $scope.isShow = elem;
        }
    };
    $scope.openCoinc = function(){
        $mdSidenav("nomValLyr").open();
    };

    $scope.setFav = function(dep){
        if(!$scope.valName.id){
            return false;
        }

        var temp = $filter("customFind")($scope.valcroName,{id: dep.dep.id,pivot:{fav:1}},function(current,compare){return $filter("customFind")(current.departments,compare,function(x,e){ return (parseInt(x.id) == parseInt(e.id)) && (parseInt(x.pivot.fav)== parseInt(e.pivot.fav))}).length>0});

        if(temp.length>0){
            setNotif.addNotif("alert","ya existe un favorito para este departamento, desea reasignar",[
                {
                    name:"SI",
                    action:function(){
                        $filter("customFind")(temp[0].departments,dep.dep.id,function(current,local){ return parseInt(current.id)==parseInt(local)})[0].pivot.fav=0;
                        if($scope.valName.departments[dep.dep.id]){
                            $scope.valName.departments[dep.dep.id].fav = 1;
                        }else{
                            var fav = {fav:1};
                            $scope.valName.departments[dep.dep.id]=fav;
                        }
                        saveValcroname();
                    }
                },
                {
                    name:"NO",
                    action:function(){
                        console.log("error")
                    }
                }
            ]);
        }else{
            if($scope.valName.departments[dep.dep.id]){
                $scope.valName.departments[dep.dep.id].fav = ($scope.valName.departments[dep.dep.id].fav==0)?1:0;
            }else{
                var fav = {fav:1};
                $scope.valName.departments[dep.dep.id]=fav;
            }
            saveValcroname();
        }

    };
    $scope.setDepa = function(dep){
        if(!$scope.valName.id){
            return false;
        }
        if($scope.valName.departments[dep.dep.id]){
            setNotif.addNotif("alert", "desea quitar este departamento?", [
                {
                    name: "SI",
                    action: function () {
                        var temp = {};
                        var i = 0;
                        angular.forEach($scope.valName.departments, function (k, v) {
                            if (parseInt(v) != parseInt(dep.dep.id)) {
                                temp[v] = k;
                            }
                            if (i == Object.keys($scope.valName.departments).length - 1) {
                                $scope.valName.departments = temp;
                            }
                            i++;
                        });
                        saveValcroname();
                        setNotif.addNotif("ok", "departamento desvinculado", [
                        ],{autohidden:3000});
                    }
                },
                {
                    name: "no",
                    action: function () {
                    }
                }
            ]);
        }else{
            var fav = {fav:0};
            $scope.valName.departments[dep.dep.id]=fav;
            saveValcroname();
            setNotif.addNotif("ok", "departamento añadido", [
            ],{autohidden:3000});
        }

    };

    $scope.closeNomValLyr = function () {
        $mdSidenav("nomValLyr").close();
    }
});

MyApp.service("valcroNameDetail",function(){
    var valcroNames = {list:[],last:null};

    return {
        setList : function(list){
            var d = new Date();
            valcroNames.list = list;
            valcroNames.last = d.getDate();
        },
        getList : function(){
            return valcroNames;
        }
    }
});

MyApp.controller('nomValAssign', function ($scope,setGetProv,valcroNameDetail) {
    $scope.prov = setGetProv.getProv();
    $scope.lines = valcroNameDetail.getList();
});

MyApp.controller('contactProv', function($scope,setGetProv,providers,$mdSidenav,setGetContac,masters,masterLists,$filter,setNotif) {
    $scope.id = "contactProv";
    $scope.prov = setGetProv.getProv();
    $scope.cnt = setGetContac.getContact();
    $scope.paises = masterLists.getCountries();
    $scope.languaje = masterLists.getLanguaje();
    $scope.allContact = setGetContac.getList();
    $scope.cargos = masters.query({type:"cargoContact"});
    $scope.$watch('prov.id',function(nvo){
        $scope.contacts = (nvo)?providers.query({type: "contactProv", id_prov: $scope.prov.id || 0}):[];
        $scope.cnt.prov_id=$scope.prov.id
    });
    $scope.$watch('cnt.pais',function(nvo,old){
        var prev =(old!=0)?$filter("filterSearch")($scope.paises,[old])[0].area_code.phone:"";
        $scope.cnt.contTelf = (nvo!=0 && $scope.cnt.contTelf=="")?$scope.cnt.contTelf.replace(prev,$filter("filterSearch")($scope.paises,[nvo])[0].area_code.phone):$scope.cnt.contTelf;
    });
    $scope.$watch('contacts.length',function(nvo){
        setGetProv.setComplete("contact",nvo);
    });
    var contact = {};
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provContactosForm.$valid','provContactosForm.$pristine',"cnt.autoSave"], function(nuevo) {
        if(((nuevo[0] && !nuevo[1])) || nuevo[2]) {

            if(!$scope.cnt.id && $filter("customFind")($scope.allContact,$scope.cnt.emailCont,function(val,compare){return val.email == compare;}).length>0){
                setNotif.addNotif("alert", "este email ya existe en la libreta de contactos", [
                ],{autohidden:3000});
                $mdSidenav("contactBook").open();
            }else {
                providers.put({type: "saveContactProv"}, $scope.cnt, function (data) {
                    $scope.cnt.id = data.id;
                    $scope.provContactosForm.$setPristine();
                    setGetProv.addChng($scope.cnt,data.action,"provContact");
                    contact.id = $scope.cnt.id;
                    contact.nombre = $scope.cnt.nombreCont;
                    contact.email = $scope.cnt.emailCont;
                    contact.telefono = $scope.cnt.contTelf;
                    contact.pais_id = $scope.cnt.pais;
                    contact.pais = $filter("filterSearch")($scope.paises, [$scope.cnt.pais])[0];
                    contact.responsabilidades =  $scope.cnt.responsability;
                    contact.direccion = $scope.cnt.dirOff;
                    contact.agente = $scope.cnt.isAgent;
                    contact.prov_id = $scope.cnt.prov_id;
                    contact.languages = $scope.cnt.languaje;
                    contact.cargos = $scope.cnt.cargo;
                    if (data.action == "new" || nuevo[2]) {
                        $scope.cnt.autoSave = false;
                        $scope.contacts.unshift(contact);
                        setGetContac.addUpd(contact,angular.copy($scope.prov));
                        setNotif.addNotif("ok", "contacto añadido", [
                        ],{autohidden:3000});
                    }
                });
            }
        }
    });

    $scope.rmContact = function(elem){
        setNotif.addNotif("alert", "desea desvincular este Contacto del proveedor?", [
            {
                name: "SI",
                action: function () {
                    cont = elem.cont;
                    providers.put({type:"delContac"},cont,function(data){
                        setGetProv.addChng(cont,data.action,"provContact");
                        $scope.contacts.splice(cont.$index,1);
                        setGetContac.addUpd(cont,$scope.prov);
                        contact = {};
                        setGetContac.setContact(false);
                        $scope.provContactosForm.$setUntouched();
                        setNotif.addNotif("ok", "Contacto desviculado!", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };



    $scope.showGrid = function(elem,event){
        if((jQuery(event.toElement).parents("#contactBook").length==0) && (jQuery(event.toElement).parents("#lyrAlert").length==0)){
            $scope.isShow = elem;
            if(!elem){
                contact = {};
                setGetContac.setContact(false);
                $scope.provContactosForm.$setUntouched();
                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }
            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"contactProv":false;
    };

    $scope.book=function(){
        $mdSidenav("contactBook").open();
    };

    $scope.toEdit = function(element){
        contact = element.cont;
        contact.prov_id = $scope.prov.id;
        setGetContac.setContact(contact);
    };
});

MyApp.controller('addressBook', function($scope,providers,$mdSidenav,setGetContac,setGetProv,$filter,setNotif) {
    $scope.prov = setGetProv.getProv();
    $scope.allContact =  setGetContac.getList();
    $scope.filtByprov = function(a,b){
        return $filter("customFind")(a.provs,b,function(val,compare){return val.prov_id == compare}).length==0;
    };
    $scope.toEdit = function(element){
        setNotif.addNotif("alert", "añadir este contacto, lo convertira en Agente y no podra ser editado.. esta deacuerdo?", [
            {
                name:"si",
                action:function(){
                    console.log("entro")
                    var contact2 = element.cont;
                    contact2.agente = 1;
                    contact2.autoSave =true;
                    contact2.prov_id = $scope.prov.id;
                    setGetContac.setContact(contact2);
                    $mdSidenav("contactBook").close();
                }
            },
            {
                name:"no",
                action:function(){

                }
            }
        ]);



    }

    $scope.closeContackBook = function(){
        $mdSidenav("contactBook").close();
    }

});

MyApp.service("setGetContac",function(providers,setGetProv,$filter){
    var contact = {id:false,nombreCont:"",emailCont:"",contTelf:"",pais:"",languaje:[],cargo:[],responsability:"",dirOff:"",prov_id:false, isAgent:0,autoSave:false};
    var listCont = [];
    return {
        setContact : function(cont){
                var prov = setGetProv.getProv();
                contact.id = cont.id||false;
                contact.nombreCont = cont.nombre||"";
                contact.emailCont = cont.email||"";
                contact.contTelf = cont.telefono||"";
                contact.pais = cont.pais_id||"";
                contact.responsability = cont.responsabilidades||"";
                contact.dirOff = cont.direccion||"";
                contact.isAgent = cont.agente || 0;
                contact.autoSave = cont.autoSave || false;
                contact.prov_id = cont.prov_id||prov.id;
                contact.languaje = cont.languages||[];
                contact.cargo = cont.cargos||[];
        },
        getContact : function(){
            return contact;
        },
        addUpd : function(cont,prov){

            var contact = $filter("customFind")(listCont,cont.id,function(val,compare){return  val.id == compare;});
            if(contact.length>0){
                var provs = $filter("customFind")(contact[0].provs,prov.id,function(val,compare){return  val.prov_id == compare;});
                if(provs.length>0){
                    contact[0].provs.splice(contact[0].provs.indexOf(provs[0]),1);
                }else{
                    contact[0].provs.push({"prov_id":prov.id,"prov":prov.siglas});
                }
            }else{
                cont.provs = [{"prov_id":prov.id,"prov":prov.siglas}];
                listCont.push(cont);
            }
        },
        setList : function(list){
            listCont = providers.query({type:"allContacts"});
        },
        getList:function(){
            return listCont;
        }
    }
});

MyApp.controller('coinController', function ($scope,masters,providers,setGetProv,listCoins,masterLists,$filter,setNotif) {
    $scope.prov = setGetProv.getProv();
    $scope.coins =masterLists.getAllCoins();
    $scope.$watch('prov.id',function(nvo){
        if(nvo){
            listCoins.setProv(nvo);
        }

        $scope.coinAssign = listCoins.getCoins();
        $scope.cn = {coin:"",prov_id:$scope.prov.id||0};
        $scope.filt = listCoins.getIdCoins();
    });
    $scope.$watch('coinAssign.length',function(nvo){
        setGetProv.setComplete("coin",nvo);
    });
    $scope.$watchGroup(['provMoneda.$valid','provMoneda.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type: "saveCoin"}, $scope.cn, function (data) {
                $scope.provMoneda.$setPristine();
                listCoins.addCoin($filter("filterSearch")($scope.coins,[$scope.cn.coin])[0]);
                $scope.coinAssign = listCoins.getCoins();
                $scope.filt = listCoins.getIdCoins();
                setNotif.addNotif("ok", "Moneda cargada", [
                ],{autohidden:3000});
            })
        }
    })

});

MyApp.controller('bankInfoController', function ($scope,masters,providers,setGetProv,setNotif) {
    $scope.id = "bankInfoController";
    $scope.prov = setGetProv.getProv();
    $scope.countries = masters.query({ type:"getCountries"});
    $scope.$watch('prov.id',function(nvo){
        $scope.bnk={id:false,bankName:"",bankBenef:"",dirBenef:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad:"",idProv: $scope.prov.id||0};
        $scope.accounts = (nvo)?providers.query({type:"getBankAccount",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('accounts.length',function(nvo){
        setGetProv.setComplete("bank",nvo);
    });
    $scope.$watch('bnk.pais', function(nvo) {
        $scope.states = (nvo)?masters.query({ type:"getStates",id:$scope.bnk.pais||0}):[];
    });
    $scope.$watch('bnk.est', function(nvo) {
        $scope.cities = (nvo)?masters.query({ type:"getCities",id:$scope.bnk.est||0}):[];
    });
    var account = {};

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['bankInfoForm.$valid','bankInfoForm.$pristine'], function(nuevo) {

        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveBank"},$scope.bnk,function(data){
                $scope.bnk.id = data.id;
                $scope.bankInfoForm.$setPristine();
                account.prov_id = $scope.bnk.id_prov;
                account.banco = $scope.bnk.bankName;
                account.beneficiario = $scope.bnk.bankBenef;
                account.dir_banco = $scope.bnk.bankAddr;
                account.swift = $scope.bnk.bankSwift;
                account.cuenta = $scope.bnk.bankIban;
                account.ciudad_id = $scope.bnk.ciudad;
                if(data.action=="new"){
                    account.id = $scope.bnk.id;
                    $scope.accounts.unshift(account);
                    setNotif.addNotif("ok", "nueva info bancaria", [
                    ],{autohidden:3000});
                }
            });

        }
    });

    $scope.rmBank = function(elem){
        setNotif.addNotif("alert", "desea eliminar esta informacion bancaria", [
            {
                name: "SI",
                action: function () {
                    bnk = elem.account;
                    providers.put({type:"delBank"},bnk,function(data){
                        $scope.accounts.splice(bnk.$index,1);
                        $scope.bnk={id:false,bankName:"",bankBenef:"",dirBenef:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad_id:"",idProv: $scope.prov.id};
                        account={};
                        $scope.bankInfoForm.$setUntouched();
                        setNotif.addNotif("ok", "Informacion Eliminada", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(acc){
        //console.log(cred)
        account = acc.account;
        $scope.bnk.id = account.id;
        $scope.bnk.id_prov = account.prov_id;
        $scope.bnk.bankName = account.banco;
        $scope.bnk.bankBenef = account.beneficiario;
        $scope.bnk.bankAddr = account.dir_banco;
        $scope.bnk.bankSwift = account.swift;
        $scope.bnk.bankIban = account.cuenta;
        $scope.bnk.ciudad = account.ciudad_id;
    };


    $scope.showGrid = function(elem,event){
        if(jQuery(event.toElement).parents("#lyrAlert").length==0) {
            $scope.isShow = elem;
            if(!elem) {
                $scope.bnk={id:false,bankName:"",bankBenef:"",dirBenef:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad_id:"",idProv: $scope.prov.id};
                account={};
                $scope.bankInfoForm.$setUntouched();
                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }
            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"bankInfoController":false;
    };

});

MyApp.controller('creditCtrl', function ($scope,providers,setGetProv,$filter,listCoins,masterLists,setNotif) {
    $scope.id="creditCtrl";
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.$watch('prov.id',function(nvo){
        $scope.cred = {id:false,coin:"",amount:"",line:"",id_prov: $scope.prov.id||0};
        $scope.limits =  (nvo)?providers.query({type:"provLimits",id_prov:$scope.prov.id||0}):0;
        $scope.coins = (nvo)?listCoins.getCoins():[];
    });
    $scope.$watch('limits.length',function(nvo){
        setGetProv.setComplete("limits",nvo);
    });
    var credit = {};
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provCred.$valid','provCred.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            console.log($scope.cred);
            providers.put({type:"saveLim"},$scope.cred,function(data){
                $scope.cred.id = data.id;
                $scope.provCred.$setPristine();
                credit.moneda_id = $scope.cred.coin;
                credit.moneda = $filter("filterSearch")($scope.coins,[$scope.cred.coin])[0];
                credit.limite = $scope.cred.amount;
                credit.linea_id = $scope.cred.line;
                credit.line = $filter("filterSearch")($scope.lines,[$scope.cred.line])[0];
                if($scope.cred.amount >= $scope.prov.limCred){
                    $scope.prov.limCred = $scope.cred.amount;
                    setGetProv.updateItem($scope.prov);
                }

                if(data.action=="new"){
                    credit.id= $scope.cred.id;
                    $scope.limits.unshift(credit);
                    setNotif.addNotif("ok", "nuevo limite de credito", [
                    ],{autohidden:3000});
                }
            });

        }
    });

    $scope.rmCredit = function(elem){
        setNotif.addNotif("alert", "desea eliminar este limite de Credito", [
            {
                name: "SI",
                action: function () {
                    cred = elem.lim;
                    providers.put({type:"delLimCred"},cred,function(data){
                        $scope.limits.splice(cred.$index,1);
                        $scope.cred = {id: false, coin: "", amount: "", line: "", id_prov: $scope.prov.id};
                        credit = {};
                        $scope.provCred.$setUntouched();
                        setNotif.addNotif("ok", "Limite de Credito borrado", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };
    $scope.toEdit = function(cred){
        //console.log(cred)
        credit = cred.lim;
        $scope.cred.id = credit.id;
        $scope.cred.id_prov = credit.prov_id;
        $scope.cred.coin = credit.moneda_id;
        $scope.cred.amount = credit.limite;
        $scope.cred.line = credit.linea_id;
        console.log($scope.cred);
    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.toElement).parents("#lyrAlert").length==0) {
            $scope.isShow = elem;
            if(!elem) {
                $scope.cred = {id: false, coin: "", amount: "", line: "", id_prov: $scope.prov.id};
                credit = {};
                $scope.provCred.$setUntouched();
                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }

            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"creditCtrl":false;
    };

});

MyApp.controller('convController', function ($scope,providers,setGetProv,$filter,listCoins,masterLists,setNotif) {
    $scope.id = "convController";
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",id_prov: $scope.prov.id||0};
    $scope.$watch('prov.id',function(nvo){
        $scope.coins = (nvo)?listCoins.getCoins():[];
        $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",line:"",id_prov: $scope.prov.id||0};
        $scope.factors =  (nvo)?providers.query({type:"provFactors",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('factors.length',function(nvo){
        setGetProv.setComplete("factors",nvo);
    });
    var factor = {};
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provConv.$valid','provConv.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveConv"},$scope.conv,function(data){
                $scope.conv.id = data.id;
                $scope.provConv.$setPristine();
                factor.prov_id = $scope.conv.id_prov
                factor.moneda_id = $scope.conv.coin;
                factor.moneda = $filter("filterSearch")($scope.coins,[$scope.conv.coin])[0];
                factor.flete = $scope.conv.freight ;
                factor.gastos = $scope.conv.expens;
                factor.ganancia = $scope.conv.gain;
                factor.descuento = $scope.conv.disc;
                factor.linea_id = $scope.conv.line;
                factor.linea = $filter("filterSearch")($scope.lines,[$scope.conv.line])[0];
                if(data.action=="new"){
                    factor.id =  $scope.conv.id;
                    $scope.factors.unshift(factor);
                    setNotif.addNotif("ok", "factor creado", [
                    ],{autohidden:3000});
                }
            });

        }
    });
    $scope.rmConv = function(elem){
        setNotif.addNotif("alert", "desea eliminar este Factor de conversion", [
            {
                name: "SI",
                action: function () {
                    conv = elem.factor;
                    providers.put({type:"delFactor"},conv,function(data){
                        $scope.factors.splice(conv.$index,1);
                        $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",line:"",id_prov: $scope.prov.id};
                        factor = {};
                        $scope.provConv.$setUntouched();
                        setNotif.addNotif("ok", "Factor Borrado", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(fact){
        factor = fact.factor;
        $scope.conv.id = factor.id;
        $scope.conv.id_prov = factor.prov_id;
        $scope.conv.coin = factor.moneda_id;
        $scope.conv.freight = factor.flete;
        $scope.conv.expens = factor.gastos;
        $scope.conv.gain = factor.ganancia;
        $scope.conv.disc = factor.descuento;
        $scope.conv.line = factor.linea_id;
    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.toElement).parents("#lyrAlert").length==0) {
            $scope.isShow = elem;
            if(!elem) {
                $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",line:"",id_prov: $scope.prov.id};
                factor = {};
                $scope.provConv.$setUntouched();
                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }
            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"convController":false;
    };
});

MyApp.controller('provPointController', function ($scope,providers,setGetProv,listCoins,masterLists,$filter,setNotif    ) {
    $scope.id = "provPointController";
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.$watch('prov.id',function(nvo){
        $scope.coins = (nvo)?listCoins.getCoins():[];
        $scope.pnt = {id:false,cost:"",coin:"",line:"",id_prov: $scope.prov.id||0};
        $scope.points =  (nvo)?providers.query({type:"provPoint",id_prov:$scope.prov.id||0}):[];
    });
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provPoint.$valid','provPoint.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"savePoint"},$scope.pnt,function(data){
                $scope.pnt.id = data.id;
                $scope.provPoint.$setPristine();
                point.moneda_id = $scope.pnt.coin;
                point.prov_id = $scope.pnt.id_prov;
                point.costo = $scope.pnt.cost;
                point.linea_id = $scope.pnt.line;
                point.moneda = $filter("filterSearch")($scope.coins,[$scope.pnt.coin])[0];
                point.linea = $filter("filterSearch")($scope.lines,[$scope.pnt.line])[0];
                if(data.action=="new"){
                    point.id = $scope.pnt.id;
                    $scope.points.unshift(point);
                    setNotif.addNotif("ok", "nuevo valor del punto guardado", [
                    ],{autohidden:3000});
                }
            });
        }
    });

    $scope.rmPoint = function(elem){
        setNotif.addNotif("alert", "desea Borrar este Punto para este proveedor", [
            {
                name: "SI",
                action: function () {
                    point = elem.point;
                    providers.put({type:"delPoint"},point,function(data){
                        $scope.points.splice(point.$index,1);
                        $scope.pnt = {id: false, cost: "", coin: "", line:"", id_prov: $scope.prov.id};
                        $scope.provPoint.$setUntouched();
                        point = {};
                        setNotif.addNotif("ok", "punto Borrado", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(element){
        point = element.point;
        $scope.pnt.id = point.id;
        $scope.pnt.coin = point.moneda_id;
        $scope.pnt.id_prov = point.prov_id;
        $scope.pnt.cost = point.costo;
        $scope.pnt.line = point.linea_id;
    };

    $scope.showGrid = function(elem,event){
        if(jQuery(event.toElement).parents("#lyrAlert").length==0) {
            $scope.isShow = elem;
            if(!elem) {
                $scope.pnt = {id: false, cost: "", coin: "", line:"", id_prov: $scope.prov.id};
                $scope.provPoint.$setUntouched();
                point = {};
                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }
            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"provPointController":false;
    };
});

MyApp.controller('prodTimeController', function ($scope,providers,setGetProv,masterLists,$filter,setNotif) {
    $scope.prov = setGetProv.getProv();
    $scope.lines = masterLists.getLines();
    $scope.$watch('prov.id',function(nvo){
        $scope.tp = {id:false,from:"",to:"",line:"",id_prov: $scope.prov.id};
        $scope.timesP =  (nvo)?providers.query({type:"prodTimes",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('timesP.length',function(nvo){
        setGetProv.setComplete("timesP",nvo);
    });
    var time = {};
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['timeProd.$valid','timeProd.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveProdTime"},$scope.tp,function(data){
                $scope.tp.id = data.id;
                $scope.timeProd.$setPristine();
                time.min_dias = $scope.tp.from;
                time.max_dias = $scope.tp.to;
                time.linea_id = $scope.tp.line;
                time.lines =  $filter("filterSearch")($scope.lines,[$scope.tp.line])[0];
                if(data.action=="new"){
                    time.id = $scope.tp.id;
                    $scope.timesP.unshift(time);
                    setNotif.addNotif("ok", "nuevo tiempo de produccion", [
                    ],{autohidden:3000});
                }
            });

        }
    });

    $scope.toEdit = function(element){
        time = element.time;
        $scope.tp.id = time.id;
        $scope.tp.id_prov = time.prov_id;
        $scope.tp.from = time.min_dias;
        $scope.tp.to = time.max_dias;
        $scope.tp.line = time.linea_id;
    };

    $scope.showGrid = function(elem){
        $scope.isShow = elem;
        if(!elem){
            $scope.tp = {id:false,from:"",to:"",line:"",id_prov: $scope.prov.id};
            time = {};
            $scope.timeProd.$setUntouched();
        }
    }
});

MyApp.controller('transTimeController', function ($scope,providers,setGetProv,$filter,masterLists,setNotif) {
    $scope.prov = setGetProv.getProv();
    var paises = masterLists.getCountries();
    $scope.$watch('prov.id',function(nvo){
        $scope.ttr = {id:false,from:"",to:"",line:"",country:"",id_prov: $scope.prov.id||0};
        $scope.provCountries = (nvo)?providers.query({type:"provCountries",id_prov:$scope.prov.id||0}):[];
        $scope.timesT =  (nvo)?providers.query({type:"transTimes",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('timesT.length',function(nvo){
        setGetProv.setComplete("timesT",nvo);
    });
    var time = {};
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['timeTrans.$valid','timeTrans.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveTransTime"},$scope.ttr,function(data){
                $scope.ttr.id = data.id;
                $scope.timeTrans.$setPristine();
                time.min_dias = $scope.ttr.from;
                time.max_dias = $scope.ttr.to;
                time.id_pais = $scope.ttr.country;
                time.country =  $filter("filterSearch")(paises,[$scope.ttr.country])[0];
                if(data.action=="new"){
                    time.id = $scope.ttr.id;
                    $scope.timesT.unshift(time);
                    setNotif.addNotif("ok", "nuevo tiempo de Transito", [
                    ],{autohidden:3000});
                }
            });

        }
    });

    $scope.toEdit = function(element){
        time = element.time;
        $scope.ttr.id = time.id;
        $scope.ttr.id_prov = time.prov_id;
        $scope.ttr.from = time.min_dias;
        $scope.ttr.to = time.max_dias;
        $scope.ttr.country = time.id_pais;
    };

    $scope.showGrid = function(elem){
        $scope.isShow = elem;
        if(!elem){
            $scope.ttr = {id:false,from:"",to:"",line:"",country:"",id_prov: $scope.prov.id};
            time = {};
            $scope.timeTrans.$setUntouched();
        }
    }
});

MyApp.service("setgetCondition",function(){
    var title = {id_cond:"",title:"",line:""};

    return {
        getTitle:function(){
            return title;
        },
        setTitle:function(cond){
            title.id = cond.id;
            title.title = cond.titulo;
            title.line = cond.line.linea;
            title.items = cond.items;
        }
    }
})

MyApp.controller('condPayList', function ($scope,$mdSidenav,masterLists,setGetProv,providers,$filter,setgetCondition,setNotif) {
    $scope.id="condPayList";
    $scope.lines = masterLists.getLines();
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo) {
        $scope.condHead = {id:false,title:"",line:"",id_prov:$scope.prov.id||0};
        $scope.conditions = (nvo)?providers.query({type:"payConditions",id_prov:$scope.prov.id}):[];
    });
    $scope.openFormCond = function(){
        setgetCondition.setTitle(cond);
        $mdSidenav("payCond").open();
    };
    var cond = {};
    $scope.$watchGroup(['condHeadFrm.$valid','condHeadFrm.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if (nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveHeadCond"},$scope.condHead,function(data){
                $scope.condHead.id = data.id;
                $scope.condHeadFrm.$setPristine();
                cond.titulo = $scope.condHead.title;
                cond.linea_id = $scope.condHead.line;
                cond.prov_id = $scope.condHead.id_prov;
                cond.line =  $filter("filterSearch")($scope.lines,[$scope.condHead.line])[0];
                if(data.action=="new"){
                    cond.id = $scope.condHead.id;
                    $scope.conditions.unshift(cond);
                    setNotif.addNotif("ok", "nueva condicion de pago", [
                    ],{autohidden:3000});
                }
            });
        }
    });

    $scope.rmCond = function(elem){
        setNotif.addNotif("alert", "desea Borrar toda esta Condicion de pago", [
            {
                name: "SI",
                action: function () {
                    cond = elem.condition;
                    providers.put({type:"delCondition"},cond,function(data){
                        $scope.conditions.splice(cond.$index,1);
                        $scope.condHead = {id:false,title:"",line:"",id_prov:$scope.prov.id||0};
                        cond = {};
                        $scope.condHeadFrm.$setUntouched();
                        setNotif.addNotif("ok", "Condicion Borrada", [
                        ],{autohidden:3000});
                    });
                }
            },
            {
                name: "NO",
                action: function () {
                }
            }
        ]);
    };

    $scope.toEdit = function(element){
        cond = element.condition;
        $scope.condHead.id = cond.id;
        $scope.condHead.id_prov = cond.prov_id;
        $scope.condHead.title = cond.titulo;
        $scope.condHead.line = cond.linea_id;
    };

    $scope.showGrid = function(elem,event){
        if((jQuery(event.toElement).parents("#payCond").length==0) && (jQuery(event.toElement).parents("#lyrAlert").length==0)){
            $scope.isShow = elem;
            if(!elem){
                $scope.condHead = {id:false,title:"",line:"",id_prov:$scope.prov.id||0};
                cond = {};
                $scope.condHeadFrm.$setUntouched();
                if($scope.$parent.expand==$scope.id){
                    $scope.isShowMore = elem;
                    $scope.$parent.expand = false;
                }
            }
        }
    };

    $scope.viewExtend = function(sel){
        $scope.isShowMore = sel;
        $scope.$parent.expand =(sel)?"condPayList":false;
    };
});
MyApp.controller('payCondItemController', function ($scope,providers,setGetProv,$filter,$mdSidenav,setgetCondition,setNotif) {
    $scope.closeCondition = function(){
        $mdSidenav("payCond").close();
    };
    $scope.head = setgetCondition.getTitle();
    $scope.$watch('head.id',function(nvo) {
        $scope.condItem = {id:false,days:"",percent:0.00,condit:"",id_head:$scope.head.id||0};
        $scope.conditions = $scope.head.items || [];
        calcMax();
    });


    var item = {};
    $scope.$watchGroup(['itemCondForm.$valid','itemCondForm.$pristine'], function(nuevo) {
        if (nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveItemCond"},$scope.condItem,function(data){
                $scope.condItem.id = data.id;
                $scope.itemCondForm.$setPristine();
                item.porcentaje = $scope.condItem.percent;
                item.dias = $scope.condItem.days;
                item.descripcion =  $scope.condItem.condit;
                calcMax();
                if(data.action=="new"){
                    item.id = $scope.condItem.id;
                    $scope.conditions.unshift(item);
                    setNotif.addNotif("ok", "nuevo Item cargado", [
                    ],{autohidden:3000});
                }
            });
        }
    });

    $scope.max = 100;

    var calcMax = function(){
        var max = 100;
        angular.forEach($scope.conditions,function(v,k){
            if($scope.condItem.id != v.id){
                max-= parseFloat(v.porcentaje);
            }
        });
        $scope.max = max;
    };

    $scope.toEdit = function(element){
        item = element.condition;
        $scope.condItem.id = item.id;
        $scope.condItem.days = item.dias;
        $scope.condItem.percent = parseFloat(item.porcentaje);
        $scope.condItem.condit = item.descripcion;
        $scope.condItem.id_head = $scope.head.id;
        calcMax();
    };

    $scope.showInterGrid = function(elem,event){
        if((jQuery(event.toElement).parents("#lyrAlert").length==0)){
            if(!elem){
                $scope.condItem = {id:false,days:"",percent:0.00,condit:"",id_head:$scope.head.id||0};
                item = {};
                $scope.itemCondForm.$setUntouched();
                calcMax();
            }
        }
    }
});

 MyApp.controller('resumenProvFinal', function ($scope,providers,setGetProv,$filter,$mdSidenav,setgetCondition,setNotif) {
     $dataProv = setGetProv.getChng();

 });
