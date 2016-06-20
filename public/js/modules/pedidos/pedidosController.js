MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav,$timeout ,$filter,$log,Order,masters,Layers,setGetOrder,setNotif, DateParse) {

    // var historia = [15];
    var autohidden= 2000;

    // controlers
    $scope.formBlock = true;
    $scope.module= Layers.setModule("pedidos");
    $scope.email= {};
    $scope.email.destinos = new Array();
    $scope.email.content = new Array();
    $scope.formMode = null;
    $scope.tempDoc= new Array();
    $scope.emails = new Array();
    $scope.layer=$scope.module.layer;
    $scope.index=$scope.module.index;
    $scope.docImports= new Array();
    $scope.providerProds= new Array();
    $scope.docsSustitos= new Array();
    $scope.estadosDoc= new Array();


    $scope.formGlobal = "new";


    $scope.forModeAvilable={
        solicitud: {
            name: "Solicitud",
            value:21,
            mod:"Solicitude"

        },
        proforma: {
            name: "Proforma",
            value:22,
            mod:"Order"
        },
        odc: {
            name: "Orden de Compra",
            value:23,
            mod:"Purchase"
        },
        getXname: function(name){
            switch (name){
                case "Solicitud": return this.solicitud;break;
                case "Proforma": return this.proforma;break;
                case "Orden de Compra": return this.odc;break;
            }
        },
        getXValue: function(name){
            switch (name){
                case 21: return this.solicitud;
                case 22: return this.proforma;
                case 23: return this.odc;
            }
        }
    };

    var timePreview;
    // filtros
    $scope.fRazSocial="";
    $scope.fPais="";
    $scope.fpaisSelec="";
    $scope.email.contactos = new Array();
    $scope.emailToText = null;
    $scope.productoSearch={
        //codProducto:"",
        //descripcion:"",
        //pCompra:"",
        //cantidad:"",
        //stock:""

    };


    //gui
    // $scope.showGripro=false;
    $scope.showFilterPed=false;
    $scope.showLateralFilter=false;
    $scope.showLateralFilterCpl=false;
    $scope.imgLateralFilter="images/Down.png";
    $scope.selecPed=false;
    $scope.preview=true;
    $scope.mouseProview= false;
    $scope.gridView=4;
    $scope.productTexto="";
    $scope.layer ="";
    $scope.openAdjDtPedido= false;


    /******************* declaracion defunciones de eventos */
    /*******incializacion de $scope*****/

    restore('provSelec');// inializa el proveedor
    restore('document');// inializa el pedido
    restore('odcSelec');// inializa la prden de compra
    restore('contraPedSelec');// inializa contra pedido selecionado
    restore('kitchenBoxSelec');// inializa contra pedido selecionado
    restore('FormData');//// la data del formulario
    restore('filterData');/// la data de filtros
    restore('FormDataContraP');// formulario de contra pedidos
    restore('todos');// lista de proveedores
    restore('filterOption');//selecion de los filtros
    restore('FormDataKitchenBox'); // formulario de ckitchen box
    restore('pedidoSusPedSelec'); // pedido sustitu selecionado

    $scope.setProvedor = setProvedor;
    $scope.DtPedido = DtPedido;
    $scope.selecOdc = selecOdc;
    $scope.selecContraP = selecContraP;
    $scope.selecPedidoSust = selecPedidoSust;
    $scope.selecKitchenBox = selecKitchenBox;
    $scope.moduleAccion = Layers.setAccion;

    $timeout(function(){
        //review();
    },0);
    $timeout(function(){
        init();
    },0);


    $http.get("Order/OrderProvList").success(function (response) {$scope.todos = response;});


    function init() {
        $scope.filterData.paises = masters.query({type: 'getCountriesProvider'});
        $scope.filterData.motivoPedido = masters.query({type: 'getOrderReason'});
        $scope.filterData.condicionPedido = masters.query({type: 'getOrderCondition'});
        $scope.filterData.tipoDepago = masters.query({type: 'getPaymentType'});

        $scope.estadosDoc = masters.query({type: 'getOrderStatus'});


    }

    function review(){
        $http.get("Order/UnClosetDoc").success(function (response) {
            $scope.tempDoc = response;
            console.log("data ",$scope.tempDoc);
        });
    }

    /********************************************GUI ********************************************/
    $scope.FilterListPed = function(){
        if($scope.showFilterPed){
            $scope.showFilterPed=false;
        }else{
            $scope.showFilterPed=true;
        }
    };

    $scope.FilterLateral = function(){
        if(!$scope.showLateralFilter){
            jQuery("#menu").animate({height:"232px"},500);
            $scope.showLateralFilter=true;
        }
    };

    $scope.FilterLateralMas = function(){
        if(!$scope.showLateralFilterCpl){
            jQuery("#menu").animate({height:"80%"},400);
            $scope.showLateralFilterCpl=true;
            $scope.imgLateralFilter="images/Down.png";
        }else {
            jQuery("#menu").animate({height:"48px"},400);
            $scope.showLateralFilter=false;
        }
    };

    $scope.filtOpen= function(){
        if($scope.isOpen){
            $scope.isOpen=false;
        }else {
            $scope.isOpen=true;
        }
    };

    $scope.mouseEnterProd = function(prod){
        //$scope.productTexto =prod;
    };

    /******************************************** ROLLBACK SETTER **/

    $scope.toEditHead= function(id,val){
        var aux= {id:id,value:val};
        setGetOrder.addTrace(aux,"FormHeadDocument");

    };
    /********************************************EVENTOS ********************************************/


    $scope.hoverpedido= function(document){
        document.isNew=false;

        $timeout(function(){
            if(document &&  $scope.mouseProview){
                $scope.formMode=$scope.forModeAvilable.getXValue(document.tipo_value);
                $scope.document=document;
                if($scope.module.layer !='resumenPedido' ){
                    $scope.moduleAccion({open:{name:"resumenPedido"}});
                    //$scope.formAction="upd";

                }
            }
        }, 1000);
        /*
         }*/
    }

    $scope.hoverLeave= function( val){

        $scope.mouseProview= val;
        if(timePreview){
            $timeout.cancel(timePreview);
        }

        timePreview= $timeout(function(){
            if($scope.preview && $scope.module.layer== 'resumenPedido' && !$scope.mouseProview){
                $scope.moduleAccion({close:true});

                $scope.hoverPreview(true);
            }
        }, 1000);


    };

    $scope.hoverEnter=  function(){
        $scope.mouseProview= true;
    };
    $scope.hoverPreview= function(val){
        $scope.preview=val;
    };

    $scope.updateForm = function () {
        $scope.formBlock = false;
    }
    $scope.showProduc= function () {
        if($scope.showGripro){
            $scope.showGripro=false;
        }else {
            $scope.showGripro=true;
        }

    };

    $scope.closeTo = function(layer){
        $scope.moduleAccion({close:layer});

    };

    $scope.cancelDoc = function(){

        $scope.formBlock= false;
        $scope.moduleAccion({open:{name:"detalleDoc"}});
        $scope.document.estado_id=3;// se cambia el estado a cancelado
        $scope.gridView =3;
        var mo= jQuery("#mtvCancelacion");
        mo[0].autofocus = true;


    };

    $scope.createProduct = function(item){

        var copy= angular.copy(item);
        copy.prov_id =$scope.provSelec.id;
        Order.post({type:"CreateTemp"},copy,function(response){
            var aux ={asignado:false,cantidad:parseFloat(response.cantidad),codigo:response.codigo,codigo_fabrica :response.codigo_fabrica,
                descripcion :response.descripcion,id: response.id,otre:null,puntoCompra:false,stock:0,tipo_producto:response.tipo_producto,
                tipo_producto_id:response.tipo_producto};
            $scope.providerProds.push(aux);
        });
    };



    /********************************************DEBUGGIN ********************************************/

    $scope.test = function (test) {
        alert(test);
    };
    $scope.simulateClick = function (id) {
        var a = angular.element(document).find(id);
        a.click();
    };

    $scope.consoleTest = function(text){
        console.log("console test", text);
    }


    /******************************************** filtros ********************************************/
    $scope.searchCountry = function(item,texto){
        return item.short_name.indexOf(texto) > -1;
    }

    $scope.search = function(){
        return $scope.todos;
    };

    $scope.searchEmails= function(){
        return $scope.email.contactos;
    }




    /******************************************** APERTURA DE LAYERS ********************************************/

    $scope.openAdj = function(){
        var adjPane =angular.element("#adjuntoProforma");
        if($scope.openAdjDtPedido){
            adjPane.animate({width:"0px"},400, function(){
               adjPane.css({display:"none"});

            });

            $scope.openAdjDtPedido= false;
        }else {
            adjPane.animate({width:"360px", display:"block"},400, function(){


            });

            $scope.openAdjDtPedido= true;
        }

    };
    $scope.openDocSusti = function(){
        console.log("sdf");
        $scope.docsSustitos = new Array();
        Order.queryMod({type:$scope.formMode.mod,mod:"Substitutes", doc_id:$scope.document.id},function(response){
            $scope.docsSustitos =response;
            $scope.moduleAccion({open:{name:"agrPedPend"}});
        });

    };
    $scope.openImport = function(){

        console.log($scope.formBlock);
        if($scope.formBlock ){
            console.log("mode", $scope.formMode);
            setNotif.addNotif("error","Debe  Actualizar o Copiar antes de poder importar el documento",[],{autohidden:autohidden});
        }else{
            console.log("modee", $scope.formMode);
            if($scope.formMode.value == 21){
                $scope.moduleAccion({open:{name:"listEmailsImport"}});
            }else  if($scope.formMode.value == 22 || $scope.formMode.value ==23 ){
                $scope.moduleAccion({open:{name:"listImport"}});
            }
        }

    };
    $scope.menuAgregar= function(){
        $scope.moduleAccion({close:"all"});
        $scope.moduleAccion({open:{name:"menuAgr"}});
        $scope.gridView=-1;
    };

    $scope.openEmail= function(){
        $scope.moduleAccion({open:{name:"email"}});
        $http.get("Email/ProviderEmails").success(function (response) { $scope.email.contactos = response});
    };

    $scope.newDoc= function(formMode){

        // openLayer("finalDoc");
        $scope.formMode=formMode;
        restore("document");
        if($scope.provSelec.id){
            //$scope.document.prov_id=$scope.provSelec.id;
        }
        $scope.moduleAccion({open:{name:"detalleDoc"}});

        $scope.formBlock=false;
    }

    /*************** conversores **********/

    $scope.transformChip = function(chip) {

        if (angular.isObject(chip)) {
            return chip;
        }

        return { email: chip}
    }
    function selecOdc(odc) {
        restore('odcSelec');
        loadOdc(odc.id);
        $scope.moduleAccion({open:{name:"resumenodc"}});


    }

    function selecContraP(item) {
        restore('contraPedSelec');
        var data ={id: item.id, pedido_id: $scope.document.id};
        if(item.tipo_origen_id){
            data.tipo_origen_id=4;
            data.renglon_id=item.renglon_id;
        }
        $http.get("Order/CustomOrder", {params: data})
            .success(function (response) {
                $scope.contraPedSelec= response;

                if(response.fecha_aprox_entrega != null){
                    $scope.contraPedSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
                }
                if(response.fecha != null){
                    $scope.contraPedSelec.fecha = new Date(Date.parse(response.fecha));

                }

            });

        $scope.formDataContraP.contraPedidoMotivo = Order.query({type: 'CustomOrderReason'});
        $scope.formDataContraP.contraPedidoPrioridad = Order.query({type: 'CustomOrderPriority'});
        $scope.moduleAccion({open:{name:"resumenContraPedido"}});

    }

    function selecPedidoSust(item) {
        restore('pedidoSusPedSelec');
        $http.get("Order/OrderSubstitute", {params: {id: item.id, pedido_id: $scope.document.id}})
            .success(function (response) {
                $scope.pedidoSusPedSelec = response;
            });

        LayersCtrl.openLayer("resumenPedido");
    }

    function selecKitchenBox(item) {
        restore('kitchenBoxSelec');
        ORDER.get({type: 'KitchenBox', id: item.id}, {}, function (response) {
            $scope.kitchenBoxSelec = response;
            if (response.fecha != null) {
                $scope.kitchenBoxSelec.fecha = new Date(Date.parse(response.fecha));
            }
            if (response.fecha_aprox_entrega != null) {
                $scope.kitchenBoxSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
            }


        });
        $scope.moduleAccion({open:{name:"resumenKitchenbox"}});
    }

    /** al pulsar la flecha siguiente**/
    $scope.next = function () {
        switch($scope.module.layer){
            case "resumenPedido":
                $scope.moduleAccion({open:{name:"detalleDoc"}});
                //loadPedidos($scope.document.id);
                break;
            case "detalleDoc":
                $scope.moduleAccion({open:{name:"listProducProv"}})
                ;break;
            case "listProducProv":
                $scope.moduleAccion({open:{name:"agrPed"}});
                break;
            case "agrPed":
                $scope.moduleAccion({open:{name:"finalDoc"}});
                break;
            case "finalDoc":
                Order.postMod({type:$scope.formMode.mod, mod:"Close"},$scope.document, function(response){

                    if (response.success) {
                        setNotif.addNotif("ok","Finalizado",[
                            {name:"Ok", action: function(){
                                $scope.moduleAccion({close:{first:true}});
                            }}
                        ],{block:true});
                    }});
                break;
        }
        //docsSustitos
        $scope.showNext(false);
    };

    $scope.showNext = function (status) {
        if (status) {
            if (!$scope.FormHeadDocument.$valid && $scope.module.layer== 'detalleDoc') {
                setNotif.addNotif("error",
                    "Existen campos pendientes por completar, por favor verifica que información le falta."
                    ,[],{autohidden:autohidden});

            } else {
                $mdSidenav("NEXT").open();
            }
            // $mdSidenav("NEXT").open();

        } else {
            $mdSidenav("NEXT").close()
        }
    }

    /*********************************************** EVENTOS CHANGE ***********************************************/

    $scope.onchangePeditem=  function (item){
        if(item.asignado){
            $http.post("Order/EditOrdenItem", item)
                .success(function (response) {

                });
        }
    }
    /**@deprecated
     * */
    $scope.change = function (odc) {
        if (odc.asig) {
            addOrdenCompra(odc.id, $scope.document.id);
        } else {
            removeOrdenCompra(odc.id, $scope.document.id);
        }

    }
    $scope.changeContraP = function (item) {
        item.doc_id=$scope.document.id;
        if(item.asignado){
            if(item.asignadoOtro.length >0){
                setNotif.addNotif("alert",
                    "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
                    ,[
                        {name: 'Si',
                            action:function(){
                                Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
                                    setNotif.addNotif("ok","Asignado",[],{autohidden:autohidden});
                                });
                            }
                        },{name: 'No',
                            action:function(){item.asignado=true;}
                        }
                    ]);
            }else{
                Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
                    setNotif.addNotif("ok","Asignado",[],{autohidden:autohidden});
                });
            }

        }
        else{
            setNotif.addNotif("alert",
                "Se eliminara el contra pedido ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            Order.postMod({type:$scope.formMode.mod,mod:"RemoveCustomOrder"},item,function(response){
                                setNotif.addNotif("ok","Removido",[],{autohidden:autohidden});
                            });
                        }
                    },{name: 'Cancel',
                        action:function(){item.asignado=true;}
                    }
                ]);
        }

    };

    $scope.changeProducto = function (item){

        if(item.asignado){
            item.prov_id =$scope.provSelec.id;
            item.doc_id =$scope.document.id;
            Order.postMod({type:$scope.formMode.mod,mod:"ProductChange"},item,function(response){
                if(!item.reng_id){
                    setNotif.addNotif("alert",
                        "agregado"
                        ,[],{autohidden:autohidden});
                    var prod= angular.copy(response);
                    prod.cantidad = parseFloat(prod.cantidad);
                    $scope.providerProds.push(prod);
                }
                item.reng_id=response.reng_id;
            });
        }else{
            setNotif.addNotif("alert",
                "Se eliminara el producto del documento ¿Deseas continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            Order.postMod({type:$scope.formMode.mod,mod:"ProductChange"},item,function(response){
                                setNotif.addNotif("info",
                                    "Removido"
                                    ,[],{autohidden:autohidden});
                            });
                        }
                    },{name: 'Cancel',
                        action:function(){item.asignado=true;}
                    }
                ]);
        }

    };

    $scope.addRemoveItem = function(item){
        Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItem"},item, function(response){
            if(response.accion == "del"){
                setNotif.addNotif("alert","Eliminado",[],{autohidden:autohidden});
            } else if(response.accion == "new"){
                setNotif.addNotif("alert","Agregado",[],{autohidden:autohidden});
                item.id=response.id;
            }
        });
    };

    $scope.changeItem = function(item){
        Order.postMod({type:$scope.formMode.mod, mod:"ChangeItem"},item, function(response){
            if(response.accion == "del"){
                setNotif.addNotif("alert","Eliminado",[],{autohidden:autohidden});
            } else if(response.accion == "new"){
                setNotif.addNotif("alert","Agregado",[],{autohidden:autohidden});
                item.id=response.id;
            }
        });
    };


    $scope.changeContraPItem = function (item) {
        item.doc_id = $scope.document.id;
        if (item.asignado) {
            $http.post("Order/AddCustomOrderItem", item)
                .success(function (response) {
                    setNotif.addNotif("info","Asignado",[],{autohidden:autohidden});
                });

        } else {

            setNotif.addNotif("alert",
                "Se eliminara el contra pedido ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            $http.post("Order/RemoveCustomOrderItem", {id: item.renglon_id, pedido_id:$scope.document.id})
                                .success(function (response) {
                                    setNotif.addNotif("ok","Removido" ,[],{autohidden:autohidden});
                                });
                        }
                    },{name: 'Cancel',
                        action:function(){
                            item.asignado=true;
                        }
                    }
                ]);
        }

    };

    $scope.changeKitchenBox = function (item) {

        item.doc_id=$scope.document.id;
        if(item.asignado){
            if(item.asignadoOtro.length >0){
                setNotif.addNotif("alert",
                    "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
                    ,[
                        {name: 'Si',
                            action:function(){
                                Order.postMod({type:$scope.formMode.mod,mod:"AddkitchenBox"},item,function(response){
                                    setNotif.addNotif("ok","Asignado",[],{autohidden:autohidden});
                                });
                            }
                        },{name: 'No',
                            action:function(){item.asignado=false;}
                        }
                    ]);
            }else{
                Order.postMod({type:$scope.formMode.mod,mod:"AddkitchenBox"},item,function(response){
                    setNotif.addNotif("ok","Asignado",[],{autohidden:autohidden});
                });
            }

        }
        else{
            setNotif.addNotif("alert",
                "Se eliminara el KitchenBox ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            Order.postMod({type:$scope.formMode.mod,mod:"RemovekitchenBox"},item,function(response){
                                setNotif.addNotif("ok","Removido",[],{autohidden:autohidden});
                            });
                        }
                    },{name: 'Cancel',
                        action:function(){item.asignado=true;}
                    }
                ]);
        }

    };

    $scope.changePedidoSustituto = function (item) {

        if (item.asignado) {

            addPedidoSustituto(item.id, $scope.document.id);
        } else {
            removePedidoSustituto(item.id, $scope.document.id);
        }

    };

    $scope.changePedidoSustitutoItem = function (item) {
        item.pedido_id = $scope.document.id;
        if(item.asignado){
            if ($scope.FormPedidoSusProduc.$valid) {
                $http.post("Order/AddOrderSubstituteItem", item)
                    .success(function (response) {
                        if (item.renglon_id == null) {
                            setNotif.addNotif("info",
                                "Asignado"
                                ,[
                                    {name: 'Ok',
                                        action:function(){}
                                    }
                                ],{autohidden:2000});
                        }
                        item.renglon_id= response.renglon_id;
                    });
            }else
            // if(item.renglon_id == null)
            {
                setNotif.addNotif("warn",
                    "El saldo anterior supera la cantidad inicial "
                    ,[
                        {name: 'Ok',
                            action:function(){}
                        }
                    ],{autohidden:2000});
                $http.post("Order/AddOrderSubstituteItem", item)
                    .success(function (response) {
                        item.renglon_id= response.renglon_id;
                    });
            }
        }else {
            setNotif.addNotif("alert",
                "Se eliminara el Pedido a sustituir ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            $http.post("Order/RemoveOrdenItem", {id: item.renglon_id,pedido_id:$scope.document.id})
                                .success(function (response) {
                                    setNotif.addNotif("info",
                                        "Removido"
                                        ,[
                                            {name: 'Ok',
                                                action:function(){}
                                            }
                                        ],{autohidden:2000});
                                });
                        }
                    },{name: 'Cancel',
                        action:function(){}
                    }
                ]);
        }

    }
    /*********************************************** EVENTOS FOCUS LOST ***********************************************/

    $scope.focusLostCpitm = function (item) {
        item.pedido_id = $scope.document.id;
        if (!$scope.FormResumenContra.$valid) {
            alert('warnin\n Monto Excedido no se asignara el valor');
            item.saldo = item.cantidad;
        }
    }


    function setProvedor(prov) {

        if($scope.module.index == 0){
            $scope.provSelec = prov;
            Layers.setAccion({open:{name:"listPedido"}});
        }else{
            if($scope.module.layer == "listPedido" ){
                $scope.provSelec = prov;
                loadPedidosProvedor($scope.provSelec.id);
            }else{

            }
        }

    }
    function DtPedido(doc) {

        restore("document");
        $scope.gridView=-1;
        //init();
        var aux= angular.copy(doc);
        if(doc && $scope.module.index <2){
            if (segurity('editPedido')) {
                document.isNew=false;
                $scope.document=aux;
                $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
                $scope.preview=false;
                setGetOrder.setGlobalAction("upd");
                $scope.formGlobal ="upd";
                $scope.moduleAccion({open:{name:"resumenPedido"}})
            }
            else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        }
    }

    $scope.docImport = function (doc){

        var url="";
        saveDoc();
        if($scope.formMode.value == 22){
            url="BetweenOrderToSolicitud";
        }
        else{
            url="BetweenOrderToPurchase";
        }
        Order.get({type:url, princ_id:$scope.document.id,impor_id: doc.id}, {},function(response){
            var errors = response.error;

            if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length == 0 &&  Object.keys(response.items).length == 0 ){
                setNotif.addNotif("alert"," Sin cambios, ¿Desea que se asigne  la "+$scope.formMode.name+" como origen del nuevo?",
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.document.prov_id=$scope.provSelec.id;
                                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){
                                    if (response.success) {
                                        setNotif.addNotif("ok","Documento vinculado",[
                                            {name:"Ok", action: function(){
                                                $scope.moduleAccion({close:true});
                                            }}
                                        ],{block:true});
                                    }
                                });
                            }
                        },
                        {name: "Cancelar",
                            action:function(){

                            }
                        }
                    ],{block:true});
            }else if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length == 0 &&  Object.keys(response.items).length > 0 ){
                setNotif.addNotif("alert"," Se Agregaran " +Object.keys(response.items).length+" productos ",
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.document.prov_id=$scope.provSelec.id;
                                var data=  {
                                    doc_id : $scope.document.id,
                                    asignado:true,
                                    items: response.items
                                };
                                Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                    if (response.success) {
                                        $scope.document.productos.todos.push(response.new);
                                        angular.forEach(response.asignado, function(v,k){
                                            $scope.document[k]=v;
                                        });
                                        Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                        setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                                    }
                                });
                            }
                        },
                        {name: "Cancelar",
                            action:function(){

                            }
                        }
                    ],{block:true});
            }else
            if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length > 0 &&  Object.keys(response.items).length > 0){

                setNotif.addNotif("alert"," Se asignaran " +Object.keys(response.items).length+" productos  y se modificaran " +Object.keys(response.asignado).length ,
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.document.prov_id=$scope.provSelec.id;
                                var data=  {
                                    doc_id : $scope.document.id,
                                    asignado:true,
                                    items: response.items
                                };
                                Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                    if (response.success) {
                                        $scope.document.productos.todos.push(response.new);
                                        angular.forEach(response.asignado, function(v,k){
                                            $scope.document[k]=v;
                                        });
                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                        Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                        setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                                    }
                                });
                            }
                        },
                        {name: "Cancelar",
                            action:function(){

                            }
                        }
                    ],{block:true});


            }else   if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length > 0 &&  Object.keys(response.items).length == 0){

                setNotif.addNotif("alert"," Se modificaran " +Object.keys(response.asignado).length,
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.document.prov_id=$scope.provSelec.id;
                                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                            }
                        },
                        {name: "Cancelar",
                            action:function(){

                            }
                        }
                    ],{block:true});


            }else {

                setNotif.addNotif("error"," El documento a utilizar posee algunas diferecias que deben revisarse antes de poder importar " +
                    "\n¿ Que desea hacer ?",[
                    {name:" Omitir diferencias ",
                        action:function(){
                            $scope.document.prov_id=$scope.provSelec.id;

                            angular.forEach(response.asignado, function(v,k){
                                $scope.document[k]=v;
                            });
                            $scope.document.prov_id=$scope.provSelec.id;
                            Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                            setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                        }
                    }
                    ,{name:"Dejarme elegir ",
                        action:function(){
                            setNotif.addNotif("error"," ¿Que desea hacer? "
                                ,[
                                    {name:" Usar solicitud ",
                                        action:function(){
                                            $scope.document.prov_id=$scope.provSelec.id;
                                            angular.forEach(response.asignado, function(v,k){
                                                $scope.document[k]=v;
                                            });
                                            angular.forEach(response.error, function(v,k){
                                                $scope.document[k]= v[0].key;
                                            });
                                            if(response.items.length > 0){
                                                var data=  {
                                                    doc_id : $scope.document.id,
                                                    asignado:true,
                                                    items: response.items
                                                };
                                                Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                                    if (response.success) {
                                                        $scope.document.productos.todos.push(response.new);
                                                        angular.forEach(response.asignado, function(v,k){
                                                            $scope.document[k]=v;
                                                        });

                                                    }
                                                });
                                            }

                                            Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                            setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                                        }
                                    }
                                    ,{name:"Usar proforma",
                                        action:function(){
                                            $scope.document.prov_id=$scope.provSelec.id;

                                            angular.forEach(response.asignado, function(v,k){
                                                $scope.document[k]=v;
                                            });
                                            angular.forEach(response.error, function(v,k){
                                                $scope.document[k]= v[1].key;
                                            });
                                            if(response.items.length > 0){
                                                var data=  {
                                                    doc_id : $scope.document.id,
                                                    asignado:true,
                                                    items: response.items
                                                };
                                                Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                                    if (response.success) {
                                                        $scope.document.productos.todos.push(response.new);
                                                        angular.forEach(response.asignado, function(v,k){
                                                            $scope.document[k]=v;
                                                        });

                                                    }
                                                });
                                            }

                                            Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                            setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                                        }
                                    },
                                    {name:"Preguntarme en cada caso("+Object.keys(errors).length+")",action:function(){
                                        $scope.document.prov_id=$scope.provSelec.id;
                                        var tasa;
                                        if(errors.prov_moneda_id){
                                            var tasa = angular.copy(errors.tasa);
                                            delete  errors.tasa;
                                        }
                                        var direccion_almacen_id = angular.copy(errors.direccion_almacen_id);
                                        delete  errors.direccion_almacen_id;
                                        console.log("total ",Object.keys(errors).length );
                                        $scope.accions = {
                                            cancel:false,
                                            total:Object.keys(errors).length,
                                            data : new Array()
                                        };
                                        $scope.$watchGroup(
                                            ['accions.cancel',
                                                'accions.total','accions.data.length'], function(newVal){
                                                if(newVal[0]){
                                                    setNotif.addNotif("error", "Cancelado",[],{autohidden:autohidden});
                                                    delete $scope.accions;
                                                }else{
                                                    if(newVal[1] == newVal[2]){
                                                        angular.forEach($scope.accions.data, function(v,k){
                                                            $scope.document[k]= v;
                                                        });
                                                        if(response.items.length > 0){
                                                            var data=  {
                                                                doc_id : $scope.document.id,
                                                                asignado:true,
                                                                items: response.items
                                                            };
                                                            Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                                                if (response.success) {
                                                                    $scope.document.productos.todos.push(response.new);
                                                                    angular.forEach(response.asignado, function(v,k){
                                                                        $scope.document[k]=v;
                                                                    });

                                                                }
                                                            });
                                                        }

                                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                                        Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                                        setNotif.addNotif("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                                                    }
                                                }
                                            });

                                        if(errors.prov_moneda_id){
                                            setNotif.addNotif("alert", "Selecione moneda a usar",[
                                                {name:errors.prov_moneda_id[0].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'prov_moneda_id', v:errors.prov_moneda_id[0].key});
                                                        if(tasa) {
                                                            $scope.accions.data.push({k:'tasa', v:parseFloat(tasa[0].key)});
                                                        }
                                                        $scope.accions.finish++;

                                                    }
                                                },
                                                {name:errors.prov_moneda_id[1].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'prov_moneda_id', v:errors.prov_moneda_id[1].key});
                                                        if(tasa) {
                                                            $scope.accions.data.push({k:'tasa', v:parseFloat(tasa[1].key)});
                                                        }
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }
                                        if(errors.titulo){
                                            setNotif.addNotif("alert", "Selecione titulo a usar",[
                                                {name:errors.titulo[0].key,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'titulo', v:errors.titulo[0].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {name:errors.titulo[1].key,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'titulo', v:errors.titulo[1].key});
                                                        $scope.accions.finish++;

                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }
                                        if(errors.comentario){
                                            setNotif.addNotif("alert", "Selecione comentario a usar",[
                                                {name:errors.comentario[0].key,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'comentario', v:errors.comentario[0].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {name:errors.comentario[1].key,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'comentario', v:errors.comentario[1].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}

                                                }
                                            ]);
                                        }
                                        if(errors.pais_id){
                                            setNotif.addNotif("alert", "Selecione pais a usar",[
                                                {name:errors.pais_id[0].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'pais_id', v:errors.pais_id[0].key});
                                                        if(direccion_almacen_id){
                                                            if(direccion_almacen_id){
                                                                $scope.accions.data.push({k:'direccion_almacen_id', v:errors.direccion_almacen_id[0].key});
                                                            }
                                                        }
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {name:errors.pais_id[1].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'pais_id', v:errors.pais_id[1].key});
                                                        if(direccion_almacen_id){
                                                            if(direccion_almacen_id){
                                                                $scope.accions.data.push({k:'direccion_almacen_id', v:errors.direccion_almacen_id[1].key});
                                                            }
                                                        }
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }
                                        if(errors.condicion_pago_id){
                                            setNotif.addNotif("alert", "Selecione la condicon de pago a usar",[
                                                {name:errors.condicion_pago_id[0].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'condicion_pago_id', v:errors.condicion_pago_id[0].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {name:errors.condicion_pago_id[1].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'condicion_pago_id', v:errors.condicion_pago_id[1].key});
                                                        $scope.accions.finish++

                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }

                                        if(errors.direccion_facturacion_id){
                                            setNotif.addNotif("alert", "Selecione la direcion de facturacion a usar",[
                                                {name:errors.direccion_facturacion_id[0].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'direccion_facturacion_id', v:errors.direccion_facturacion_id[0].key});
                                                        $scope.accions.finish++;

                                                    }
                                                },
                                                {name:errors.direccion_facturacion_id[1].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'direccion_facturacion_id', v:errors.direccion_facturacion_id[1].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }

                                            ]);
                                        }
                                        if(errors.puerto_id){
                                            setNotif.addNotif("alert", "Selecione el puerto a usar",[
                                                {name:errors.puerto_id[0].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'puerto_id', v:errors.puerto_id[0].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {name:errors.puerto_id[1].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'puerto_id', v:errors.puerto_id[1].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }
                                        if(errors.condicion_id){
                                            setNotif.addNotif("alert", "Selecione la condicion a usar",[
                                                {name:errors.condicion_id[0].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'condicion_id', v:errors.condicion_id[0].key});
                                                        $scope.accions.finish++;

                                                    }
                                                },
                                                {name:errors.condicion_id[1].text,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'condicion_id', v:errors.condicion_id[1].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }
                                        if(errors.tasa){
                                            setNotif.addNotif("alert", "Selecione la tasa a usar",[
                                                {name:errors.tasa[0].key,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'tasa', v:errors.tasa[0].key});
                                                        $scope.accions.finish++;

                                                    }
                                                },
                                                {name:errors.tasa[1].key,
                                                    action: function(){
                                                        $scope.accions.data.push({k:'tasa', v:errors.tasa[0].key});
                                                        $scope.accions.finish++;
                                                    }
                                                },
                                                {
                                                    name:"Cancelar",action : function(){$scope.accions.cancel = true;}
                                                }
                                            ]);
                                        }
                                    }
                                    },
                                    {name:"Cancelar",action:function(){}}
                                ]);
                        }
                    },
                    {name:"Cancelar",action:function(){}}
                ]);

            }

        });
    };
    /****** **************************listener ***************************************/

    /** formulario  head*/
    $scope.$watch('document.pais_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            $http.get("Order/Address",{params:{id:newVal,tipo_dir: 2}}).success(function (response) {
                $scope.formData.direcciones=response;
            });
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){

                setGetOrder.addChange({id:"pais_id",value:newVal,text:"Pais"},$scope.formAction,"FormHeadDocument");
            }
        }
    });
    $scope.$watch('document.direccion_almacen_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                setGetOrder.addChange({id:"direccion_almacen_id",value:newVal,text:"Almacen"},$scope.formAction,"FormHeadDocument");
            }
            $http.get("Order/AdrressPorts",{params:{id:newVal}})
                .success(function(response){$scope.formData.puertos=response;});
        }
    });

    $scope.$watch('document.prov_moneda_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                setGetOrder.addChange({id:"prov_moneda_id",value:newVal,text:"Moneda"},$scope.formAction,"FormHeadDocument");
            }

            loadTasa(newVal);
        }
    });


    $scope.$watch('provSelec.id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined' && newVal) {

            loadCoinProvider(newVal);
            loadCountryProvider(newVal);
            loadPaymentCondProvider(newVal);
            $http.get("Order/Address",{params:{id:newVal,tipo_dir: 1}}).success(function (response) {
                $scope.formData.direccionesFact= response;
            });
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                setGetOrder.addChange({id:"prov_id",value:newVal,text:"Proveedor"},$scope.formAction,"FormHeadDocument");
            }
        }
    });
    //para los select
    $scope.$watch("document.tipo_id", function (newVal){
        if (newVal != '' && typeof(newVal) !== 'undefined' && newVal && $scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine) {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                setGetOrder.addChange({id:"tipo_id",value:newVal,text:"Tipo"},$scope.formAction,"FormHeadDocument");
            }
        }
    });


/*

    $scope.$watchGroup(
        ['document.tipo_id','document.direccion_facturacion_id',
            'document.condicion_pago_id','document.puerto_id','document.condicion_id'], function(newVal){

        });

    //para los campos de texto
    $scope.$watchGroup(
        ['document.tipo_id','document.direccion_facturacion_id',
            'document.monto', 'document.tasa', 'document.condicion_pago_id',
            'document.mt3','document.peso','document.puerto_id','document.condicion_id'
            ,'document.nro_factura',''], function(newVal){

        });*/

    /**layers*/
    $scope.$watchGroup(['module.index','module.layer'], function(newVal){
        $scope.layer= newVal[1];
        $scope.index= newVal[0];
        switch (newVal[0]){
            case 0:
                restore('provSelec');// inializa el proveedor
                restore('document');// inializa el pedido
                //  restore('FormData');// inializa el proveedor
                // loadDataFor();
                setGetOrder.setGlobalAction("new");
                $scope.gridView=4;
                $scope.FormHeadDocument.$setUntouched();

                break;
            case 1:$scope.FormHeadDocument.$setUntouched();break;
            default:;

        }

        if (newVal[1] != '' && typeof(newVal[1]) !== 'undefined') {
            var layer= newVal[1];
            if($scope.provSelec.id != ''){
                if(layer == "listPedido" ){
                    loadPedidosProvedor($scope.provSelec.id);
                }
                if(layer == "agrContPed" ){
                    loadContraPedidosProveedor($scope.provSelec.id);
                }
                if(layer == "agrKitBoxs" ){
                    loadkitchenBoxProveedor($scope.provSelec.id);
                }
                if(layer == "listPedido" ){
                    loadPedidosProvedor($scope.provSelec.id);
                }
                if(layer == "listProducProv" ){

                    $http.get("Order/ProviderProds",
                        {params:{id:$scope.provSelec.id,tipo:$scope.formMode.value, doc_id:$scope.document.id}}).success(function (response) {
                        $scope.providerProds= response;

                    });
                }
                if(layer == "listImport"){
                    if($scope.formMode.value ==21 ){

                    }else {
                        var url ="";
                        switch ($scope.formMode.value){
                            case  22: url = "SolicitudeToImport";break;
                            case  23: url = "OrderToImport";break;
                        }
                        $scope.docImports = Order.query({type: url, id:$scope.document.id,tipo:$scope.formMode.value, prov_id:$scope.provSelec.id});
                    }



                }



                if(layer == "agrPed" || layer == "detalleDoc" || layer == "agrPed" || layer == "finalDoc"
                ){
                    if($scope.document.id != '' && typeof($scope.document.id) !== 'undefined'){
                        Order.get({type:"Document", id:$scope.document.id,tipo:$scope.formMode.value}, {},function(response){
                            $scope.document= response;

                            $scope.document.emision=DateParse.toDate(response.emision);
                            $scope.document.monto=parseFloat(response.monto);
                            $scope.document.tasa=parseFloat(response.tasa);
                            if(response.fecha_aprob_compra =! null && response.fecha_aprob_compra ){
                                $scope.document.fecha_aprob_compra= DateParse.toDate(response.fecha_aprob_compra);
                            }
                        });
                    }
                }


            }

        }
    });


    $scope.$watchGroup(['FormHeadDocument.$valid', 'FormHeadDocument.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {
            $scope.document.prov_id = $scope.provSelec.id;

            Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){
                if (response.success) {
                    $scope.document.id = response.id;
                    if(response['action'] == 'new'){
                        setNotif.addNotif("ok","Creado, Puede continuar",[],{autohidden:autohidden});
                    }

                }
            });
        }

    });


    $scope.$watchGroup(['FormEstatusDoc.$valid', 'FormEstatusDoc.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {

            $scope.document.prov_id = $scope.provSelec.id;
            //{id:$scope.document.id, estado_id:$scope.document.estado_id}
            Order.postMod({type:$scope.formMode.mod, mod:"SetStatus"},{id:$scope.document.id, estado_id:$scope.document.estado_id}, function(response){
                if (response.success) {
                    setNotif.addNotif("ok","Estado cambiado a "+response.item.estado,[],{autohidden:autohidden});
                }

            });
        }
    });



    $scope.$watchGroup(['FormCancelDoc.$valid', 'FormCancelDoc.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {

           /* $scope.document.prov_id = $scope.provSelec.id;
            //{id:$scope.document.id, estado_id:$scope.document.estado_id}
            Order.postMod({type:$scope.formMode.mod, mod:"Cancel"},{id:$scope.document.id, estado_id:$scope.document.estado_id}, function(response){
                if (response.success) {
                    setNotif.addNotif("ok","Estado cambiado a "+response.item.estado,[],{autohidden:autohidden});
                }

            });*/
        }


    });

    /*************************Guardados*************************************************/

    function saveDoc() {

        var url =""
        if ($scope.document.id == '') {
            delete $scope.document.id;
        }
        if($scope.module.layer == "finalDoc"){
            $scope.document.close=true;
        }
        /* $scope.document.prov_id = $scope.provSelec.id;
         Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){});
         Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){

         if (response.success) {
         $scope.FormHeadDocument.$setUntouched();
         $scope.document.id = response.id;
         if(response.success  ){
         $scope.document.isNew= false;
         if(response['action'] == 'new'){
         setNotif.addNotif("ok","Creado, Puede continuar",[],{autohidden:autohidden});
         }
         if($scope.module.layer == "finalDoc"){
         $scope.formBlock=true;
         setNotif.addNotif("ok","Finalizado",[],{autohidden:autohidden});
         Layers.setAccion({close:{all:true}});
         switch ($scope.formMode){
         case "Solicitud":

         break;
         case "Orden de Compra":

         break;
         }
         }

         }

         }else{

         }
         });*/

    }

    /**************************** Conversiones ****************/
    $scope.odcEstatus = function (odc) {
        if (odc.aprobada == '1') {
            return 'Aprobada';
        } else {
            return 'No Aprobada';
        }
    }


    /*********************************  peticiones  carga $http ********************* ************/

    $scope.removeList= function(item){

        setNotif.addNotif("alert",
            "Se removera todos los productos asociados ¿Desea continuar?"
            ,[
                {name: 'Ok',
                    action:function(){
                        /*  var url="RemoveToOrden";
                         var id=item.id;
                         if(item.tipo_origen_id == 4){
                         url="RemoveOrdenItem";
                         id=item.renglon_id;
                         }
                         $http.post("Order/"+url, {id: id, pedido_id: $scope.document.id})
                         .success(function (response) {
                         setNotif.addNotif("alert","Removido",[],{autohidden:autohidden});
                         loadPedido($scope.document.id);
                         });*/
                    }
                },{name: 'Cancel',action:function(){}}
            ]);

    };

    function loadTasa(id){
        $http.get("master/getCoin/"+id).success(function (response) {
            $scope.document.tasa= parseFloat(response.precio_usd);
        });
    }

    function loadCoinProvider(id){

        $http.get("provider/provCoins/"+id).success(function (response) {
            $scope.formData.monedas=response;
            //  $scope.document.prov_moneda_id= response[0].id;

        });
    }

    function loadPaymentCondProvider(id){
        $http.get("Order/ProviderPaymentCondition",{params:{id:id}}).success(function (response) {
            $scope.formData.condicionPago=response;

            //  $scope.document.condicion_pago_id= response[0].id;

        });
    }

    function loadCountryProvider(id){
        $http.get("Order/ProviderCountry",{params:{id:id}}).success(function (response) {
            $scope.formData.paises= response;
            // $scope.document.pais_id= response[0].id;
        });
    }

    function loadPedidosProvedor(id){
        $scope.provSelec.pedidos= new Array();
        $http.get("Order/OrderProvOrder",{params:{id:id}}).success(function (response) {
            var items= new Array();

            angular.forEach(response, function (v, k) {
                v.emision= DateParse.toDate(v.emision);
                v.monto= parseFloat(v.monto);
                v.tasa= parseFloat(v.tasa);
                v.isNew=false;
                items.push(v);

            });
            $scope.provSelec.pedidos=items;
        });
    }

    /*@deprecated*/
    function  loadOrdenesDeCompraProveedor(id){

        $http({
            method: 'POST',
            url: 'Order/ProviderOrder',
            data:{prov_id:id, pedido_id: $scope.document.id}
        }).then(function successCallback(response) {
            var odcs= new Array();
            for(var i=0;i<response.data.length;i++){
                var odc=response.data[i];
                odc.asig=false;
                if(odc.asignado != 0){
                    odc.asig=true;
                }
                odcs.push(odc);
            }
            $scope.formData.odc=odcs;
        }, function errorCallback(response) {
        })
    }

    /**@deprecated*/
    function loadOdc(id){

        $http({
            method: 'POST',
            url: 'Order/PurchaseOrder',
            data:{id:id}
        }).then(function successCallback(response) {
            $scope.odcSelec= response.data;
        }, function errorCallback(response) {
        });
    }
    function loadContraPedidosProveedor(id){
        $http.get("Order/CustomOrders",{params:{ prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value}}).success(function (response) {
            $scope.formData.contraPedido= response;
        });
    }

    function loadkitchenBoxProveedor(id){

        $http.get("Order/KitchenBoxs",{params:{ prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value}}).success(function (response) {
            $scope.formData.kitchenBox= response;
            $scope.formData.kitchenBox.fecha = Date.parse(response.fecha);        });
    }
    /*
     function loadPedidosASustituir(id){
     $http.get("Order/OrderSubstitutes",{params:{prov_id:id, pedido_id: $scope.document.id}}).success(function (response) {
     $scope.formData.pedidoSust= response;

     });
     }*/

    /*********************************  peticiones  guardado $http ********************* ************/

    function addOrdenCompra(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddPurchaseOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('Asignado');
        }, function errorCallback(response) {
        });
    }
    function removeOrdenCompra(id,pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemovePurchaseOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('des Asignado');
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function addkitchenBox(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddkitchenBox',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removekitchenBox(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemovekitchenBox',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert(' Removido ');
            loadDoc($scope.document.id);
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function addContraPedido(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddCustomOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('asignado');
        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }
    function removeContraPedido(id, pedido_id){

        ORDER.post({type:'RemoveCustomOrder'},{ id:id, pedido_id:pedido_id}, function(data){
            alert(' Removido ');
            loadDoc($scope.document.id);
        });

    }

    /*****/
    function addPedidoSustituto(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddOrderSubstitute',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function removePedidoSustituto(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/RemoveOrderSubstitute',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {

        }, function errorCallback(response) {
            console.log("errorrr");
        });
    }

    function segurity(key){
        return true;
    }
    function  restore(key){
        switch (key){
            case 'provSelec':
                $scope.provSelec={id:'',razon_social:'',save:false, pedidos: new Array() };
                break;
            case 'document':
                $scope.document={ pais_id:'', id:'',estado_id:'1',
                    prov_moneda_id:'', tasa:0,direccion_almacen_id:'',  emision:new Date(), isNew:true};
                break;
            case 'odcSelec':
                $scope.odcSelec={ id:''};
                break;
            case 'contraPedSelec':
                $scope.contraPedSelec={ id:''};
                break;

            case 'pedidoSusPedSelec':
                $scope.pedidoSusPedSelec={ id:''};
                break;
            case 'kitchenBoxSelec':
                $scope.contraPedSelec={ id:'', fecha: new Date()};
                break;
            case 'FormData':
                $scope.formData={  pedidos: new Array(), tipo: new Array(),  monedas: new Array(),
                    direcciones:new Array(), odc: new Array(), contraPedido: new Array(), kitchenBox: new Array(),
                    estadoPedido:new Array(), pedidoSust: new Array(), puertos: new Array(), direcciones_fact: new Array()
                };
                break;
            case 'FormDataContraP':
                $scope.formDataContraP={
                    contraPedidoMotivo: new Array(),contraPedidoPrioridad: new Array()
                };
                break;
            case 'FormDataKitchenBox':
                $scope.formDataKitchenBox={
                };
                break;
            case 'filterData':
                $scope.filterData={ paises : new Array()};
                break;
            case 'todos':
                $scope.todos = new Array();
                break;
            case 'filterOption':
                $scope.filterOption={
                    tipo_pedido_id:-1,
                    min_id:'',
                    max_id:''
                };
                break;
            default: console.log('no existe key' + key);
        }
    }
});

/************** SERRVICIOS   ***********************/


MyApp.service('setGetOrder', function() {
    var trace = {};
    var changes ={};
    var globalAction= "new";

    var forms ={FormHeadDocument:{action:"new"},productosDoc:{action:"new"}};
    angular.forEach(forms, function (v, k) {
        trace[k]={};
        changes[k]={};
    });
    this.addTrace = function(val,form){
        console.log("focus");
        if(trace[form][parseInt(val.id)] === undefined){
            trace[form][parseInt(val.id)] = angular.copy(val);
        }
    };

    this.addChange = function(val,action,form){
        if(globalAction== "new"){
            action = "new";
        }
        if((changes[form][val.id]===undefined) || !angular.equals(val,trace[form][val.id])){
            if(changes[form][val.id]){
                changes[form][val.id].datos = angular.copy(val);
                if(!(changes[form][val.id].action=="new" && action=="upd")){
                    changes[form][val.id].action = action;
                }
            }else{
                changes[form][val.id] = {
                    datos:angular.copy(val),
                    action:action
                }
            }
        }else{
            delete changes[form][val.id];
        }
    }

    this.getChanges= function(){return changes; }
    this.setGlobalAction= function(action){globalAction=action; };
    this.getGlobagAction= function(){ return globalAction};

    this.setFormAction = function(key, action){
        forms[key].action=action;
    }
    this.setFormAction = function(key){
        return forms[key].action;
    }
});


MyApp.service('Layers' , function(){

    var modules ={};
    var accion ={estado:false,data:{}};
    var modulekey="";
    var layer = "";
    var index= 0;


    return {
        setModule: function (name){
            if(!modules[name]){
                modules[name]={historia: new Array(),layers:new Array(),index: 0,layer:"",blockBack:false};

            }else{
                modules[name].historia = new Array();
                modules[name].layers = new Array();
                modules[name].layer ="";
                modules[name].index ="";
                modules[name].blockBack =false;

            }
            modulekey=name;
            return modules[name];
        }, getModule : function(name){
            if(!name){
                return modules[modulekey];
            }else{
                return modules[name];
            }

        },
        getAccion : function(){
            return accion;
        }, setAccion: function(arg){
            console.log("accc", arg);
            accion.data=arg;
            accion.estado=true;
        },
        getLayer : function (){
            return layer;
        },
        setLayer: function( arg ){
            layer =   arg;
        }
    }


});

MyApp.controller("LayersCtrl",function($mdSidenav, Layers, $scope){

    $scope.accion= Layers.getAccion();
    console.log("lyer bien");
    $scope.$watch("accion.estado", function(newVal){

        if(newVal){
            var module = Layers.getModule();
            console.log("moduel est", module);
            var arg = $scope.accion.data;
            if(arg.open){
                open(arg.open, module);
            }
            if(arg.close){
                close(arg.close,module);
            }
            //if(arg.back){
            //    close(true, module);
            //}
            //if(arg.backTo){
            //    close(true, module);
            //}

        }
        $scope.accion.estado=false;





    });

    function close(arg, module){
        if(module.index>0 && !module.blockBack){
            var paso=true;
            if(arg.before){
                var aux=arg.before();
                console.log("respuesta ",aux);
                if(!aux){
                    paso=false;
                }

            }
            if(paso){
                module.blockBack=true;
                var close =1;
                var current= module.index;
                console.log("aas  ", arg);
                if(arg.name){
                    console.log("name  ", arg.name);
                    var aux = module.historia.indexOf(arg.name);
                    console.log("aux  ",aux);
                    if(aux!= -1){
                        close= current - aux;
                    }else{
                        close=0;
                    }
                }
                else if(arg.to){
                    close = arg.to;
                }else if(arg.all){
                    close = module.index ;
                }else if(arg.first){
                    close = module.index -1;
                }


                for(var i=0; i<close;i++){
                    var l = module.historia[current];
                    console.log("cerrando",l);
                    $mdSidenav(l).close().then(function(){
                        if(arg.after){
                            arg.after();
                        }
                    });
                    module.historia[current]=null;
                    current--;
                }
                module.index= current;
                module.layer = module.historia[module.index];
                module.blockBack=false;
            }

        }
    };
    //**operacion apertura */
    function open(arg, module){
        var paso= true;

        if (module.historia.indexOf(arg.name) == -1) {
            if(arg.before){
                if(!arg.validate){
                    arg.before();
                }else{
                    paso=arg.before();
                }
            }
            if(paso){
                var l = angular.element(document).find("#" + arg.name);
                if(!arg.width){
                    var base = 264;
                    module.index++;
                    var w = base + (24 * module.index);
                    l.css('width', 'calc(100% - ' + w + 'px)');
                    l.css('z-index', String(60  + module.index));
                } else{
                    l.css('width', 'calc(100% - ' + arg.width + 'px)');
                }
                $mdSidenav(arg.name).open().then(function(){
                    if(arg.after){
                        arg.after();
                    }
                });
                module.historia[module.index] = arg.name;
                module.layer = arg.name;
                return true;
            }

        }
        return false;
    }
});

MyApp.factory('Order', ['$resource',
    function ($resource) {
        return $resource('Order/:type/:mod', {}, {
            query: {method: 'GET',params: {type: ""}, isArray: true},
            get: {method: 'GET',params: {type:""}, isArray: false},
            post: {method: 'POST',params: {type:" "}, isArray: false},
            postMod: {method: 'POST',params: {type:" ",mod:""}, isArray: false},
            getMod: {method: 'GET',params: {type:"",mod:""}, isArray: false},
            queryMod: {method: 'GET',params: {type: "", mod:""}, isArray: true},
            postAll: {method: 'POST',params: {type:" "}, isArray: false}

        });
    }
]);
