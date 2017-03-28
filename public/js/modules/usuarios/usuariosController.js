/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// ############################################################################################################
// Funcion llamado global a db USUARIOS #######################################################################
// ############################################################################################################
MyApp.factory('users', ['$resource',
    function ($resource) {
        return $resource('usrs/:type/:id', {}, {
            query: {method: 'GET', params: {type: "", id: ""}, isArray: true},
            algo: {method: 'GET', params: {type: "", id: ""}, isArray: true},
            post: {method: 'POST', params: {type: "", id: ""}, isArray: false}
        });
    }
]);
// ############################################################################################################
// Servicio contenedor varibles FLOTANTES #####################################################################
// ############################################################################################################
/*MyApp.service("usersServices", function () {
 var user = {};
 
 return{
 getUser: function () {
 return user;
 },
 setUser: function (item) {
 user.admin = item.admin || false;
 user.apellido = item.apellido || false;
 user.cargo_id = item.cargo_id || false;
 user.co_us = item.co_us || false;
 user.email = item.email || false;
 user.id = item.id || false;
 user.nivel_id = item.nivel_id || false;
 user.nombre = item.nombre || false;
 user.responsabilidades = item.responsabilidades || false;
 user.status = item.status || false;
 user.user = item.user || false;
 }
 };
 
 });*/

/*
 // ############################################################################################################
 // Controlador global MODULO USUARIOS #########################################################################
 // ############################################################################################################
 MyApp.controller('mainUsersController', ['$scope', 'setNotif', function ($scope, setNotif) {
 $scope.index = 1;
 $scope.openForm = function (id) {
 $scope.LayersAction({open: {name: "userLayer3"}});
 };
 }]);
 // ############################################################################################################
 // Controlador del LISTADO DE USUARIOS ########################################################################
 // ############################################################################################################
 MyApp.controller('listUsersController', ['$scope', 'setNotif', 'users', 'usersServices','$http', function ($scope, setNotif, users, usersServices, $http) {
 // Lista de usuarios --------------------------------------------------------------------------------
 $scope.users = users.query({type: "listUsuarios"});
 // Asignacion del usuario selccionado en la lista de usuarios -----------------------------------
 $scope.seltUser = function (usr) {
 // Consultando a DB usuario seleccionado ----------------------------------------------------
 $http.get('usrs/seltdUser/'+usr.id).success(function (response) {
 $scope.selUser = response[0];
 $scope.LayersAction({open: {name: "userLayer3", before: function () {
 usersServices.setUser($scope.selUser);
 }}});
 });
 };
 }]);
 // ######################################################################################################
 // Controlador del FORMULARIO DE USUARIOS ###############################################################
 // ######################################################################################################
 MyApp.controller('userForm', ['$scope', 'setNotif', 'users', 'usersServices', function ($scope, setNotif, users, usersServices) {
 //var userSeted = usersServices.getUser();
 //console.log("USUARIO SELECCIONADO",userSeted);
 $scope.selected = usersServices.getUser();
 // Metodos del input de CARGOS ==================================================================
 var self = this;
 // Lista de cargos ------------------------------------------------------------------------------
 self.cargos = users.query({type: 'cargos'});
 self.querySearch = querySearch;
 self.selectedItemChange = selectedItemChange;
 self.nvoCargo = nvoCargo;
 // Llamado solicitud de nuevo cargo -------------------------------------------------------------
 function nvoCargo(cargo) {
 console.log("Sorry! You'll need to create a Constitution for " + cargo + " first!");
 }
 
 function querySearch(query) {
 var results = query ? self.cargos.filter(createFilterFor(query)) : self.cargos, deferred;
 return results;
 }
 
 function selectedItemChange(item) {
 console.log(item);
 }
 
 function createFilterFor(query) {
 var lowercaseQuery = angular.lowercase(query);
 return function filterFn(cargo) {
 var nom = angular.lowercase(cargo.nombre);
 return (nom.indexOf(lowercaseQuery) === 0);
 };
 }
 
 
 }]);*/

// PEDIENTE:
// 1) Boton de atras debe desaparecen al verrar todas las capas.
// 2) Los selectores auto complete deben hacer al llamado al funcion que solicita la creacion de un nuevo item.
// 3) En la funcion selectedEstatus(ide) esta consultando un array plano en el controller, que retorna un JSON

// ######################################################################################################
// Controlador global MODULO USUARIOS ###################################################################
// ######################################################################################################
MyApp.controller('mainUsersController', ['$scope', 'setNotif', '$http', '$mdSidenav', 'users', function ($scope, setNotif, $http, $mdSidenav, users) {
        // ==================================================================================================
        // Variables globales del modulo ====================================================================
        $scope.index = 1;
        $scope.camposForm = {
                "id": null,
                "usr_nombre": null,
                "usr_apellido": null,
                "user": null,
                "password": null,
                "admin": "0",
                "crg_id": null,
                "co_us": null,
                "email": null,
                "nvl_id": null,
                "responsabilidades": null,
                "status": null};
        $scope.userSelected = angular.copy($scope.camposForm);
        $scope.useBase = angular.copy($scope.camposForm);
        // ==================================================================================================
        // Funcion de apertura de capas ---------------------------------------------------------------------
        $scope.openForm = function (id) {
            $scope.LayersAction({open: {name: "userLayer3"}});
            $scope.resetFormUsuario();
        };
        // ==================================================================================================
        // Funcion de cerrado de capas ---------------------------------------------------------------------
        $scope.prevLayer = function () {
            if ($scope.index === 1) {
                //$scope.LayersAction({close: true});
                //$scope.resetFormUsuario();
                $scope.outForm1();
            }
        };

        // ######################################################################################################
        // Controlador del LISTADO DE USUARIOS ##################################################################
        // ######################################################################################################
        // ==================================================================================================
        // Lista de usuarios ================================================================================
        $http.get('usrs/listUsuarios').success(function (response) {
            $scope.users = response;
        });
        // ==================================================================================================
        // Asignacion del usuario selccionado en la lista de usuarios =======================================
        $scope.seltUser = function (usr) {
            // Consultando a DB usuario seleccionado --------------------------------------------------------
            $http.get('usrs/seltdUser/' + usr.id).success(function (response) {
                $scope.responseUser = response[0];
                // variable de usuarios selecctionado -------------------------------------------------------
                $scope.userSelected = angular.copy($scope.responseUser);
                // variable de compracion -------------------------------------------------------------------
                $scope.useBase = angular.copy($scope.responseUser);
                $scope.LayersAction({open: {name: "userLayer3"}});
            });
        };

        // ######################################################################################################
        // Controlador del FORMULARIO DE USUARIOS ###############################################################
        // ######################################################################################################
        
        var self = this;
        // Reseteo del formulario --------------------------------------------------------------------------
        $scope.resetFormUsuario = function(){
            // Reset Variables que contiene datos del producto seleccionado ---------------------------------
            $scope.userSelected = angular.copy($scope.camposForm);
            $scope.useBase = angular.copy($scope.camposForm);
            // Reset Selectores ----------------------------------------------------------------------------
            self.selectedCargo = false;
            self.selectedNivel = false;
            self.selectedEstatus = false;
        };

        $scope.validar = function(){
            console.log($scope.userSelected);
        };
        
        // ==================================================================================================
        // Metodos del input de CARGOS ======================================================================

        // Lista de cargos ----------------------------------------------------------------------------------
        self.cargos = users.query({type: 'cargos', id: 0});

        // Llamado solicitud de nuevo cargo -----------------------------------------------------------------
        $scope.nvoCargo = function(cargo) {
            alert("Solicitud de creacion del cargo:" + cargo);
        };

        // ==================================================================================================
        // Metodos del input Nivel ==========================================================================

        // Lista de cargos ----------------------------------------------------------------------------------
        self.niveles = users.query({type: 'niveles', id: 0});

        // Llamado solicitud de nuevo Nivel -----------------------------------------------------------------
        function nvoNivel(nivel) {
            alert("Solicitud de creacion del Nivel:" + nivel);
        }

        // ==================================================================================================
        // Metodos del input Estatus ==========================================================================

        // Lista de Estatus ----------------------------------------------------------------------------------
        self.estatus = users.query({type: 'estatus', id: -1});

        // Llamado solicitud de nuevo Estatus -----------------------------------------------------------------
        function nvoEstatus(estatus) {
            alert("Solicitud de creacion del Estatus:" + estatus);
        }

        // ===================================================================================================
        // Validacion del campo de email ---------------------------------------------------------------------
        $scope.validEmail = function (dta) {
            var reg = new RegExp("^[A-Za-z]+[^\\s\\+\\-\\\\\/\\(\\)\\[\\]\\-]*@[A-Za-z]+[A-Za-z0-9]*\\.[A-Za-z]{2,}$");

            if (!reg.test(dta)) {
                setNotif.addNotif("error", "El email no tiene un formato adecuado", [], {autohidden: 3000});
                return null;
            }
        };

        // =====================================================================================================
        // Valida que los campos requeridos esten llenos -------------------------------------------------------
        $scope.isValid = function(){
            if(!$scope.userInfoForm.$invalid ||  !$scope.userAccesForm.$invalid){
                return false;
            }
            return true;
        };
        // =====================================================================================================
        // Verifica si exsisten cabios hecho en el formulario antes de guardar ---------------------------------
        $scope.saveForm1 = function(){
            $.each($scope.userSelected, function (key, value) {
                if(typeof(value)==="number"){
                    $scope.userSelected[key] = value.toString();
                }else if(value == "undefined"){
                    $scope.userSelected[key] = null;
                }else if(key == "admin"){
                    $scope.userSelected[key] = "0";
                }
                console.log(key,":",$scope.useBase[key],"=",value,"->",$scope.useBase[key] !== value);
            });
            
            
            /*$.each($scope.userSelected, function (key, value) {
                if(typeof(value)==="number"){
                    value = value.toString();
                }else if(value == "undefined"){
                    $scope.userSelected[key] = null;
                }else if(key == "admin"){
                    console.log($scope.userSelected[key]);
                    $scope.userSelected[key] = 0;
                }
                console.log(key,":",$scope.useBase[key],"=",value,"->",$scope.useBase[key] !== value);
                if($scope.useBase[key] !== value){
                    //change = true;
                };
            });*/
            
            if(!angular.equals($scope.userSelected,$scope.useBase)){
                console.log("enviar datos");
                //console.log($scope.userSelected);
                //if($scope.isValid){
                if(!$scope.userInfoForm.$invalid || !$scope.userAccesForm.$invalid){
                    $http.post('usrs/userSave', $scope.userSelected).success(function (data, status, headers, config) {
                        console.log(data);
                    });
                }else{
                    setNotif.addNotif("error","Existen campos que requieren atencion.",[],{autohidden:3000});
                }
            }else{
                console.log("no existen cambios para guardar");
                setNotif.addNotif("alert","no existen datos que guardar.",[],{autohidden:3000});
            }
        };
        // Valida si existen cambios en el formulario antes de salir --------------------------------------------------
        $scope.outForm1 = function(){
            $.each($scope.userSelected, function (key, value) {
                if(typeof(value)==="number"){
                    $scope.userSelected[key] = value.toString();
                }else if(value===""){
                    $scope.userSelected[key] = null;
                }
            });
            
            if(!angular.equals($scope.userSelected,$scope.useBase)){
                console.log("Existen cambios desea descartarlos");
                
                setNotif.addNotif("alert","Existen cambios desea descartarlos",[
                    {
                        name:"Si",
                        action:function(){
                            $scope.LayersAction({close: true});
                            $scope.resetFormUsuario();
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
                console.log("Solo vacia y cierra");
                $scope.LayersAction({close: true});
                $scope.resetFormUsuario();
            }
        };

    }]);