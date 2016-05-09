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

    return {
        setMain:function(){
            countries = masters.query({ type:"getCountries"});
        },
        getCountries:function(){
            return countries;
        }
    }
})
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



MyApp.controller('AppCtrl', function ($scope,$mdSidenav,$http,setGetProv,masters,masterLists) {
    $scope.prov=setGetProv.getProv()
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

    }
    $scope.openLayer = openLayer;
    $scope.closeLayer = closeLayer;

    $scope.states = masters.query({ type:"getProviderType"}); //typeProv.query()

    $scope.envios = masters.query({ type:"getProviderTypeSend"});

    $scope.data = {
        cb1: true
    };

    $scope.setProv = function(prov){
        setGetProv.setProv(prov.item);
        closeLayer(true)
        openLayer("layer1");
    };

    $scope.showAlert = function(){
        $mdSidenav("alert").open();
    };

    $scope.addProv = function(){
        setGetProv.setProv(false)
        $scope.openLayer("layer1");
    }

    $scope.showNext = function(status,to){
        if(status){
            $scope.nextLyr = to;
            if($scope.prov.id)
                $mdSidenav("NEXT").open()
        }else{
            $mdSidenav("NEXT").close()
        }
    }

    masterLists.setMain();


});


MyApp.controller('TipoDirecc', function ($scope,masters) {
    $scope.tipos = masters.query({ type:"addressType"});
});

MyApp.controller('allCoinsController', function ($scope,masters,listCoins,setGetProv) {
    $scope.coins = masters.query({ type:"getCoins"});
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo) {
        $scope.filt = listCoins.getIdCoins();
    });
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
MyApp.service("setGetProv",function($http,providers){
    var prov = {id:false,type:"",description:"",siglas:"",envio:"",contraped:true,limCred:0};
    var itemsel = {};
    var list = {};
    return {
        getProv: function () {
            return prov;
        },
        setProv: function(index) {
            if (index){
                itemsel = index;
                id = itemsel.id;

                providers.get({type:"getProv"},{id:id},function(data){
                    prov.id = data.id;
                    prov.description = data.razon_social;
                    prov.siglas = data.siglas;
                    prov.type = data.tipo_id;
                    prov.envio = data.tipo_envio_id;
                    prov.contraped = (data.contrapedido==1)?true:false;
                });
            }else{
                prov.id = false;prov.description = "";prov.siglas = "";prov.type = "";prov.envio = "";prov.contraped = false;
                itemsel = {};
            }
        },
        updateItem: function(upd){
            itemsel.razon_social = upd.description;
            itemsel.limite_credito = upd.limCred;
            itemsel.contrapedido = upd.contraped;
            itemsel.tipo_envio_id= upd.envio;
        },
        setList : function(val){
            list = val;
            //itemsel.list[0];
        },
        addToList : function(elem){
            list.unshift(elem);
            itemsel = list[0];
            //setProv(elem);
        }

    };
});



//###########################################################################################3
//##############################FORM CONTROLLERS#############################################3
//###########################################################################################3
MyApp.controller('DataProvController', function ($scope,setGetProv,$mdToast,providers) {
    $scope.enabled = false;
    $scope.toCheck = false;
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
    $scope.dtaPrv = setGetProv.getProv();
    $scope.$watchGroup(['projectForm.$valid','projectForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveProv"},$scope.dtaPrv,function(data){
                $scope.dtaPrv.id = data.id;
                $scope.projectForm.$setPristine();
                setGetProv.updateItem($scope.dtaPrv);
                if(data.action=="new"){
                    setGetProv.addToList({
                        razon_social: $scope.dtaPrv.description,
                        contrapedido: $scope.dtaPrv.contraped,
                        tipo_envio_id: $scope.dtaPrv.envio,
                        id: $scope.dtaPrv.id,
                    });
                    $scope.showSimpleToast();
                }
            });
        }
    });

});

//###########################################################################################3

MyApp.controller('provAddrsController', function ($scope,setGetProv,$mdToast,providers,$http) {
    $scope.prov = setGetProv.getProv(); //obtiene en local los datos del proveedor actual
    var dirSel = {};
    /*escucha cambios en el proveedor seleccionado y carga las direcciones correspondiente*/
    $scope.$watch('prov.id',function(nvo){

        $scope.dir = {direccProv: "", tipo: "", pais: 0, provTelf: "", id: false, id_prov: $scope.prov.id};
        $scope.address = (nvo)?providers.query({type: "dirList", id_prov: $scope.prov.id || 0}):[];
        $scope.isShow = false;

    });

    $scope.toEdit = function(addrs){
        dirSel = addrs.add;
        $scope.dir.id = dirSel.id;
        $scope.dir.id_prov = dirSel.prov_id;
        $scope.dir.direccProv = dirSel.direccion;
        $scope.dir.tipo = dirSel.tipo_dir;
        $scope.dir.pais = dirSel.pais_id;
        $scope.dir.provTelf = dirSel.telefono;
    };

    /*escuah el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['direccionesForm.$valid','direccionesForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            $http({
                method: 'POST',
                url: "provider/saveProvAddr",
                data: $scope.dir
            }).then(function successCallback(response) {
                $scope.dir.id = response.data.id;
                $scope.direccionesForm.$setPristine();
                dirSel.direccion =  $scope.dir.direccProv;
                dirSel.tipo_dir = $scope.dir.tipo;
                dirSel.pais_id = $scope.dir.pais;
                dirSel.telefono = $scope.dir.provTelf;
                if(response.data.action=="new"){
                    $scope.address.unshift({
                        direccion:$scope.dir.direccProv,
                        tipo_dir:$scope.dir.tipo,
                        pais_id:$scope.dir.pais,
                        telefono:$scope.dir.provTelf
                    });
                    $scope.toEdit($scope.address[0])
                }
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });

    $scope.showGrid = function(elem){
      $scope.isShow = elem;
        if(!elem){
            $scope.dir = {direccProv:"",tipo:"",pais:0,provTelf:"",id:false,id_prov: $scope.prov.id};
            $scope.address = providers.query({type:"dirList",id_prov: $scope.prov.id||0});
        }
    }


});



MyApp.controller('idiomasController', function($scope) {
    $scope.idiomas = [
        { name: 'Español' },
        { name: 'Ingles' },
        { name: 'Frances' },
        { name: 'Portugues' },
        { name: 'Aleman' },
        { name: 'Chino' },
        { name: 'Ruso' },
        { name: 'Papiamento' }
    ];

    $scope.idiomasSeleccionados = [];

});
MyApp.controller('valcroNameController', function($scope,setGetProv,$http,providers) {
    $scope.enabled=true;
    $scope.prov = setGetProv.getProv(); //obtiene en local los datos del proveedor actual
    $scope.$watch('prov.id',function(nvo){
        $scope.valcroName = (nvo)?providers.query({type: "provNomValList", id_prov: $scope.prov.id || 0}):[];

    });

    $scope.$watchGroup(['valcroName.length','prov.id'],function(){
        var lastIndex = $scope.valcroName.length-1;
        /*lo siguiente guarda solo si es una nuevo item*/
        if(lastIndex>=0 && $scope.valcroName[lastIndex].id == false){
            $http({
                method: 'POST',
                url: "provider/saveValcroName",
                data: $scope.valcroName[lastIndex]
            }).then(function successCallback(response) {
                $scope.valcroName[lastIndex].id = response.data.id;
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });
    /*la siguiente funcion transforma lo escrito a un objeto para el render y hace el insert en la Bd*/
    $scope.transformChip = function transformChip(chip) {
        // If it is an object, it's already a known chip
        if (angular.isObject(chip)) {
            return chip;
        }
        var chip = { name: chip, dep: 'adm', fav:($scope.valcroName.length==0)?"1":"0", id:false, prov_id:$scope.prov.id};
        // Otherwise, create a new o
        return chip;
    };
    $scope.rmChip = function(fiel,chip){
        $http({
            method: 'POST',
            url: "provider/delValcroName",
            data: chip
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            console.log("error=>", response)
        });
    };
});

MyApp.controller('contactProv', function($scope,setGetProv,$http,providers,$mdSidenav,setGetContac,masters,$filter) {
    $scope.prov = setGetProv.getProv();
    $scope.cnt = setGetContac.getContact();
    $scope.paises = masters.query({ type:"getCountries"});
    $scope.$watch('prov.id',function(nvo){
        $scope.contacts = (nvo)?providers.query({type: "contactProv", id_prov: $scope.prov.id || 0}):[];

    });
    $scope.$watch('isShow',function(nvo,old){
        if(nvo!=old && nvo){
            $scope.contacts = providers.query({type:"contactProv",id_prov: $scope.prov.id||0});
        }
    })
    contact = {};
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provContactosForm.$valid','provContactosForm.$pristine',"cnt.autoSave"], function(nuevo) {
        console.log(nuevo[2]);
        if((nuevo[0] && !nuevo[1]) || nuevo[2]) {
            $http({
                method: 'POST',
                url: "provider/saveContactProv",
                data: $scope.cnt
            }).then(function successCallback(response) {
                $scope.cnt.id = response.data.id;
                $scope.provContactosForm.$setPristine();
                contact.nombre = $scope.cnt.nombreCont;
                contact.email = $scope.cnt.emailCont;
                contact.telefono = $scope.cnt.contTelf;
                var paisel =$filter("filterSearch")($scope.paises,[$scope.cnt.pais]);
                contact.pais = paisel[0];
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });

    $scope.showGrid = function(elem){
        $scope.isShow = elem;
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

MyApp.controller('addressBook', function($scope,providers,$mdSidenav,setGetContac,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.allContact =  providers.query({type:"allContacts"});
    $scope.toEdit = function(element){
        contact = element.cont;
        contact.autoSave =true;
        contact.prov_id = $scope.prov.id;
        setGetContac.setContact(contact);
        $mdSidenav("contactBook").close();
    }

});

MyApp.service("setGetContac",function(setGetProv){
    var contact = {id:false,nombreCont:"",emailCont:"",contTelf:"",pais:"",languaje:"",responsability:"",dirOff:"",prov_id:false, isAgent:0,autoSave:false};
    return {
        setContact : function(cont){
            contact.id=cont.id;
            contact.nombreCont=cont.nombre;
            contact.emailCont=cont.email;
            contact.contTelf=cont.telefono;
            contact.pais=cont.id_lang;
            contact.responsability=cont.responsabilidades;
            contact.dirOff=cont.direccion;
            contact.isAgent=0;
            contact.autoSave=cont.autoSave||false;
            contact.prov_id = cont.prov_id;
        },
        getContact : function(){
            return contact;
        }
    }
});

MyApp.service("listCoins",function(providers) {
    var selCoins =[];
    var coinIds = [];

    return {
        setProv:function(id_prov){
            if(id_prov){
                selCoins = providers.query({type:"provCoins",id_prov:id_prov||0});
                coinIds = providers.query({type:"listCoin",id_prov:id_prov||0});
            }

        },
        getCoins:function(){
            return selCoins;
        },
        getIdCoins: function(){
            return coinIds;
        }
    }
})

MyApp.controller('coinController', function ($scope,masters,providers,setGetProv,listCoins) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){

        listCoins.setProv(nvo);
        $scope.coinAssign = listCoins.getCoins();
        $scope.cn = {coin:"",prov_id:$scope.prov.id||0};
    })

    $scope.$watchGroup(['provMoneda.$valid','provMoneda.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type: "saveCoin"}, $scope.cn, function (data) {
                $scope.provMoneda.$setPristine();
                listCoins.setProv($scope.prov.id)
            })
        }
    })

});


MyApp.controller('bankInfoController', function ($scope,masters,providers,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.countries = masters.query({ type:"getCountries"});
    $scope.$watch('prov.id',function(nvo){
        $scope.bnk={id:false,bankName:"",bankBenef:"",dirBenef:"",bankAddr:"",bankSwift:"",bankIban:"", pais:"",est:"",ciudad:"",idProv: $scope.prov.id||0};
        $scope.accounts = (nvo)?providers.query({type:"getBankAccount",id_prov:$scope.prov.id||0}):[];
    });
    $scope.$watch('bnk.pais', function(nuevo) {
        $scope.states = masters.query({ type:"getStates",id:$scope.bnk.pais||0});
    });
    $scope.$watch('bnk.est', function(nuevo) {
        $scope.cities = masters.query({ type:"getCities",id:$scope.bnk.est||0});
    });

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['bankInfoForm.$valid','bankInfoForm.$pristine'], function(nuevo) {

        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveBank"},$scope.bnk,function(data){
                $scope.bnk.id = data.id;
                $scope.bankInfoForm.$setPristine();
                if(data.action=="new"){
                    var newElem = {banco:$scope.bnk.bankName,beneficiario:$scope.bnk.bankBenef,cuenta:$scope.bnk.bankIban};
                    $scope.accounts.unshift(newElem);
                }
            });

        }
    });

    $scope.showGrid = function(elem){
        $scope.isShow = elem;
        if(!elem){
            $scope.accounts = providers.query({type:"getBankAccount",id_prov:$scope.prov.id||0});
         }
    };

});


MyApp.controller('creditCtrl', function ($scope,providers,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.cred = {id:false,coin:"",amount:"",id_prov: $scope.prov.id||0};
        $scope.limits =  (nvo)?providers.query({type:"provLimits",id_prov:$scope.prov.id||0}):0;
    });

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provCred.$valid','provCred.$pristine'], function(nuevo) {

        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveLim"},$scope.cred,function(data){
                $scope.cred.id = data.id;
                $scope.provCred.$setPristine();
                if(data.action=="new"){
                    //var newElem = {banco:$scope.bnk.bankName,beneficiario:$scope.bnk.bankBenef,cuenta:$scope.bnk.bankIban};
                    alert("save");
                    // $scope.accounts.unshift(newElem);
                }
            });

        }
    });
});

MyApp.controller('convController', function ($scope,providers,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.conv = {id:false,freight:"",expens:"",gain:"",disc:"",coin:"",id_prov: $scope.prov.id||0};
        $scope.factors = (nvo)? providers.query({type:"provFactors",id_prov:$scope.prov.id||0}):[];
    });

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provConv.$valid','provConv.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveConv"},$scope.conv,function(data){
                $scope.conv.id = data.id;
                $scope.provConv.$setPristine();
                if(data.action=="new"){
                    //var newElem = {banco:$scope.bnk.bankName,beneficiario:$scope.bnk.bankBenef,cuenta:$scope.bnk.bankIban};
                    alert("save");
                    // $scope.accounts.unshift(newElem);
                }
            });

        }
    });
});

MyApp.controller('provPointController', function ($scope,providers,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.pnt = {id:false,cost:"",coin:"",id_prov: $scope.prov.id||0};
        //$scope.points =  providers.query({type:"provPoints",id_prov:$scope.prov.id||0});
    });

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provPoint.$valid','provPoint.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"savePoint"},$scope.pnt,function(data){

                $scope.provPoint.$setPristine();
            });

        }
    });
});

MyApp.controller('prodTimeController', function ($scope,providers,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.tp = {id:false,from:"",to:"",line:"",country:"",id_prov: $scope.prov.id||0};
        //$scope.provCountries = providers.query({type:"provCountries",id_prov:$scope.prov.id||0});
        $scope.timesP =  (nvo)?providers.query({type:"prodTimes",id_prov:$scope.prov.id||0}):[];
    });

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['timeProd.$valid','timeProd.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveProdTime"},$scope.tp,function(data){
                $scope.tp.id = data.id;
                $scope.timeProd.$setPristine();
                if(data.action=="new"){
                    //var newElem = {banco:$scope.bnk.bankName,beneficiario:$scope.bnk.bankBenef,cuenta:$scope.bnk.bankIban};
                    alert("save");
                    // $scope.accounts.unshift(newElem);
                }
            });

        }
    });
});

MyApp.controller('transTimeController', function ($scope,providers,setGetProv) {
    $scope.prov = setGetProv.getProv();
    $scope.$watch('prov.id',function(nvo){
        $scope.ttr = {id:false,from:"",to:"",line:"",country:"",id_prov: $scope.prov.id||0};
        $scope.provCountries = (nvo)?providers.query({type:"provCountries",id_prov:$scope.prov.id||0}):[];
        $scope.timesT =  (nvo)?providers.query({type:"transTimes",id_prov:$scope.prov.id||0}):[];
    });

    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['timeTrans.$valid','timeTrans.$pristine'], function(nuevo) {
        var sum = $scope.conv;
        if(nuevo[0] && !nuevo[1]) {
            providers.put({type:"saveTransTime"},$scope.ttr,function(data){
                $scope.ttr.id = data.id;
                $scope.timeTrans.$setPristine();
                if(data.action=="new"){
                    //var newElem = {banco:$scope.bnk.bankName,beneficiario:$scope.bnk.bankBenef,cuenta:$scope.bnk.bankIban};
                    alert("save");
                    // $scope.accounts.unshift(newElem);
                }
            });

        }
    });
});
