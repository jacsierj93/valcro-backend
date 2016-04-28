//var proveedores = angular.module('proveedores', []);

MyApp.controller('AppCtrl', function ($scope,$mdSidenav,$http,setGetProv,masters) {
    $scope.states = masters.query({ type:"getProviderType"}); //typeProv.query()

    $scope.envios = masters.query({ type:"getProviderTypeSend"});

    $scope.data = {
        cb1: true
    };

    $scope.setProv = function(prov){
        setGetProv.setProv(prov.item);
        $mdSidenav("left").close().then(function(){
            $mdSidenav("left").open();
        });
    }
});


MyApp.controller('TipoDirecc', function ($scope) {

    $scope.tipos = ('Facturacion Fabrica Almacen').split(' ').map(function (tipo) {
        return {nombre : tipo};
    });
});

MyApp.controller('ListPaises', function ($scope,$http,masters) {
    $scope.paises = masters.query({ type:"getCountries"});

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

});

//###########################################################################################3
//###################Service Providers (comunication betwen controllers)###################3
//###########################################################################################3
MyApp.service("setGetProv",function($http){
    var prov = {id:false,type:"",description:"",siglas:"",envio:"",contraped:true,limCred:0};
    var itemsel = {};
    var list = {};
    var addrs = {id:false,pais:{short_name:""},telefono:"",direccion:""};
    return {
        getProv: function () {
            return prov;
        },
        setProv: function(index) {
            if (index){
                itemsel = index;
                id = itemsel.id;
                $http({
                    method: 'POST',
                    url: "provider/getProv",
                    data: {
                        id: id
                    }
                }).then(function successCallback(response) {
                    data = response.data;
                    prov.id = data.id;
                    prov.description = data.description;
                    prov.siglas = data.siglas;
                    prov.type = data.type;
                    prov.envio = data.envio;
                    prov.contraped = data.contraped;
                }, function errorCallback(response) {
                    console.log("error=>", response)
                });
            }else{
                prov.id = false;prov.description = "";prov.siglas = "";prov.type = "";prov.envio = "";prov.contraped = false;
                itemsel = {};
            }
        },
        updateItem: function(upd){
            itemsel.description = upd.description;
            itemsel.limCred = upd.limCred;
            itemsel.contraped = upd.contraped;
        },
        setList : function(val){
            list = val;
            //itemsel.list[0];
        },
        addToList : function(elem){
            list.unshift(elem);
            this.setProv(list[0]);
        },
        getSel : function(){
            return prov;
        }

    };
})


//###########################################################################################3
//##############################REST service (factory)#############################################3
//###########################################################################################3
MyApp.factory('masters', ['$resource',
    function ($resource) {
        return $resource('master/:type', {}, {
            query: {method: 'GET', params: {type: ""}, isArray: true},
        });
    }
]);

MyApp.factory('providers', ['$resource',
    function ($resource) {
        return $resource('provider/:type/:id_prov', {}, {
            query: {method: 'GET', params: {type: "",id_prov:""}, isArray: true},
        });
    }
]);

//###########################################################################################3
//##############################FORM CONTROLLERS#############################################3
//###########################################################################################3
MyApp.controller('DataProvController', function ($scope,setGetProv,$http,$mdToast) {
    $scope.enabled = false;
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
            $http({
                method: 'POST',
                url: "provider/saveProv",
                data: $scope.dtaPrv,
            }).then(function successCallback(response) {
                $scope.dtaPrv.id = response.data.id;
                $scope.projectForm.$setPristine();
                setGetProv.updateItem($scope.dtaPrv);
                if(response.data.action=="new"){
                    var newProv = angular.copy($scope.dtaPrv);
                    setGetProv.addToList(newProv);
                    $scope.showSimpleToast();
                }
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });

});

//###########################################################################################3

MyApp.controller('provAddrsController', function ($scope,setGetProv,$mdToast,providers,$http) {
    $scope.prov = setGetProv.getSel(); //obtiene en local los datos del proveedor actual
    var dirSel = {};
    /*escucha cambios en el proveedor seleccionado y carga las direcciones correspondiente*/
    $scope.$watch('prov.id',function(nvo){
        $scope.dir = {direccProv:"",tipo:"",pais:0,provTelf:"",id:false,id_prov: $scope.prov.id};
        $scope.address = providers.query({type:"dirList",id_prov: $scope.prov.id||0});
        $scope.isShow = false;
    })

    $scope.toEdit = function(addrs){
        dirSel = addrs.add;
        $scope.dir.id = dirSel.id;
        $scope.dir.id_prov = dirSel.prov_id;
        $scope.dir.direccProv = dirSel.direccion;
        $scope.dir.tipo = dirSel.tipo_dir;
        $scope.dir.pais = dirSel.pais_id;
        $scope.dir.provTelf = dirSel.telefono;
    }

    /*escuah el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['direccionesForm.$valid','direccionesForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            $http({
                method: 'POST',
                url: "provider/saveProvAddr",
                data: $scope.dir,
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
    $scope.prov = setGetProv.getSel(); //obtiene en local los datos del proveedor actual
    $scope.$watch('prov.id',function(nvo){
        $scope.valcroName = providers.query({type:"provNomValList",id_prov: $scope.prov.id||0});
    })

    $scope.$watchGroup(['valcroName.length','prov.id'],function(nvo,old){
        var lastIndex = $scope.valcroName.length-1;
        /*lo siguiente guarda solo si es una nuevo item*/
        if(lastIndex>=0 && $scope.valcroName[lastIndex].id == false){
            $http({
                method: 'POST',
                url: "provider/saveValcroName",
                data: $scope.valcroName[lastIndex],
            }).then(function successCallback(response) {
                $scope.valcroName[lastIndex].id = response.data.id;
            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    })
    /*la siguiente funcion transforma lo escrito a un objeto para el render y hace el insert en la Bd*/
    $scope.transformChip = function transformChip(chip) {
        // If it is an object, it's already a known chip
        if (angular.isObject(chip)) {
            return chip;
        }
        var chip = { name: chip, dep: 'adm', fav:($scope.valcroName.length==0)?"1":"0", id:false, prov_id:$scope.prov.id};
        // Otherwise, create a new o
        return chip;
    }
    $scope.rmChip = function(fiel,chip){
        $http({
            method: 'POST',
            url: "provider/delValcroName",
            data: chip,
        }).then(function successCallback(response) {
            console.log(response);
        }, function errorCallback(response) {
            console.log("error=>", response)
        });
    }
})

MyApp.controller('contactProv', function($scope,setGetProv,$http,providers,$mdSidenav,setGetContac) {
    $scope.prov = setGetProv.getSel();
    $scope.cnt = setGetContac.getContact();
    $scope.$watch('prov.id',function(nvo){
        $scope.contacts = providers.query({type:"contactProv",id_prov: $scope.prov.id||0});
    })
    /*escuha el estatus del formulario y guarda cuando este valido*/
    $scope.$watchGroup(['provContactosForm.$valid','provContactosForm.$pristine'], function(nuevo) {
        if(nuevo[0] && !nuevo[1]) {
            $http({
                method: 'POST',
                url: "provider/saveContactProv",
                data: $scope.cnt,
            }).then(function successCallback(response) {
                $scope.cnt.id = response.data.id;
                $scope.provContactosForm.$setPristine();
                $scope.contacts = providers.query({type:"contactProv",id_prov: $scope.prov.id||0});

            }, function errorCallback(response) {
                console.log("error=>", response)
            });
        }
    });

    $scope.showGrid = function(elem){
        $scope.isShow = elem;
        /*if(!elem){
            $scope.cnt = {id:false,nombreCont:"",emailCont:"",contTelf:"",pais:"",languaje:"",responsability:"",dirOff:"",prov_id:$scope.prov.id||0, isAgent:0};
        }*/
    }

    $scope.book=function(){
        $mdSidenav("contactBook").open();
    }

    $scope.toEdit = function(element){
        contact = element.cont;
        setGetContac.setContact(contact);

    }

})

MyApp.controller('addressBook', function($scope,providers,$mdSidenav,setGetContac) {
    $scope.allContact =  providers.query({type:"allContacts"});
    $scope.toEdit = function(element){
        contact = element.cont;
        setGetContac.setContact(contact);
        $mdSidenav("contactBook").close();
    }

})

MyApp.service("setGetContac",function(){
    var contact = {id:false,nombreCont:"dasd",emailCont:"",contTelf:"",pais:"",languaje:"",responsability:"",dirOff:"",prov_id:0, isAgent:0};
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
        },
        getContact : function(){
            return contact;
        }
    }
})
