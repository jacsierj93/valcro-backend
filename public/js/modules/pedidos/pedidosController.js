MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav,$timeout ,$filter,$log,$location, $anchorScroll,Order,masters,providers,Upload,Layers,setGetOrder, DateParse, Accion,filesService) {

    // var historia = [15];
    var autohidden= 2000;

    // controlers
    $scope.formBlock = true;
    //$scope.module= Layers.getModule();
    $scope.email= {};
    $scope.email.destinos = new Array();
    $scope.email.content = new Array();
    $scope.formMode = null;
    $scope.tempDoc= {};
    $scope.emails = new Array();
    $scope.docImports= new Array();
    $scope.providerProds= new Array();
    $scope.docsSustitos= new Array();
    $scope.estadosDoc= new Array();
    $scope.formGlobal = "new";
    $scope.tasa_fija= true;
    $scope.skiPro = new Array();
    $scope.navCtrl = Accion.create();
    $scope.previewHtmltext = "Introdusca texto ";
    $scope.previewHtmlDoc ="";

    filesService.setFolder('orders');

    $scope.filesProcess = filesService.getProcess();

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
    //$scope.imagenes = new Array();
    $scope.imgKey=0;

    var timePreview;
    // filtros
    $scope.fRazSocial="";
    $scope.fPais="";
    $scope.fpaisSelec="";
    $scope.email.contactos = new Array();
    $scope.emailToText = null;
    $scope.emailText = "demo";
    $scope.emailAsunto = "demo";
    $scope.productoSearch={};


    //gui
    // $scope.showGripro=false;
    $scope.showFilterPed=false;
    $scope.showLateralFilter=false;
    $scope.showLateralFilterCpl=false;
    $scope.imgLateralFilter="images/Down.png";
    $scope.selecPed=false;
    $scope.preview=true;
    $scope.mouseProview= false;
    $scope.gridView =-1;
    $scope.gridViewCp= 1;
    $scope.gridViewSus= 1;
    $scope.gridViewFinalDoc= 1;
    $scope.productTexto="";
    $scope.currenSide = null;
    $scope.unclosetDoc = new Array();



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
        init();
    },0);

    $scope.todos = Order.query({type:"OrderProvList"});



    $scope.reviewDoc = function(){
        $scope.unclosetDoc = [];
        Order.query({type:"UnClosetDoc"},{}, function(response){
            $scope.unclosetDoc = response;
            if(response.length > 0){
                $scope.NotifAction("alert","Existen "+response.length + " documentos sin finalizar ",[
                    {
                        name:"Revisar luego",
                        action:function(){

                        }
                    }, {
                        name:"Ver",
                        action: function(){
                            $scope.navCtrl.value="unclosetDoc";
                            $scope.navCtrl.estado=true;
                        }
                    }
                ],{block:true});
            }


        });




    };
    function init() {
        $scope.filterData.motivoPedido = masters.query({type: 'getOrderReason'});
        $scope.filterData.tipoDepago = masters.query({type: 'getPaymentType'});
        $scope.estadosDoc = masters.query({type: 'getOrderStatus'});

        // $scope.formData.condicionPedido = masters.query({type: 'getOrderCondition'});
    }



    /********************************************GUI ********************************************/
    $scope.FilterListPed = function(){
        $scope.showFilterPed = ($scope.showFilterPed) ? false : true;
        /*        if($scope.showFilterPed){
         $scope.showFilterPed=false;
         }else{
         $scope.showFilterPed=true;
         }*/
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
            $scope.showLateralFilterCpl=false;


        }
    };

    $scope.filtOpen= function(){
        $scope.isOpen = ($scope.isOpen) ? false : true;
    };

    $scope.mouseEnterProd = function(prod){
        //$scope.productTexto =prod;
    };

    /******************************************** ROLLBACK SETTER **/

    $scope.toEditHead= function(id,val){
        console.log("gloabel", $scope.formGlobal);
        if($scope.formGlobal != 'new'){
            setGetOrder.change('document',id,val);
        }

    };



    $scope.verificExit = function(){
        var paso = true;
        console.log(' internasl', setGetOrder.getInternalState());
        if(setGetOrder.getInternalState() != 'new'){

            $scope.NotifAction("alert","Se han realizado cambio en la "+$scope.formMode.name+ " ¿esta seguro de salir sin culminar?",[
                {
                    name:"No",
                    action: function(){

                    }
                },
                {
                    name:"Si",
                    action: function(){
                        $scope.moduleAccion({close:{first:true}});
                        filesService.close();

                    }
                }

            ],{block:true});
            paso =false;
        }

        return paso;
    };

    $scope.verificBackExit = function(){
        var paso = true;
        if(setGetOrder.getInternalState() != 'new'){

            $scope.NotifAction("alert","Se han realizado cambio en la "+$scope.formMode.name+ " ¿esta seguro de salir sin culminar?",[
                {
                    name:"No",
                    action: function(){

                    }
                },
                {
                    name:"Si",
                    action: function(){
                        $scope.LayersAction({close:{init:true}});
                    }
                }

            ],{block:true});
            return false;
        }
        if(!paso){

        }
        return paso;
    };

    /********************************************EVENTOS ********************************************/

    $scope.editTasa= function(){
        $scope.NotifAction("alert","Desea asignar una tasa unica para esta "+$scope.formMode.name,[
            {
                name:"No",
                action: function(){

                }
            },
            {
                name:"Si",
                action: function(){
                    $scope.tasa_fija=false;
                }
            }

        ],{block:true});
    };
    $scope.sendEmail = function(){
        $scope.NotifAction("ok","Enviado",[
            {
                name:"ok",
                action: function(){
                    $scope.moduleAccion({close:true});
                }
            }
        ],{block:true});
    };

    /***
     * indicador de progreso
     * usar $watch para saber si se terminaron de subir todos los archivos
     *  filesService.getProcess().estado;
     *  cuando olVal =='loading' && newVal == 'finished' se acaba de subir los archivos
     *  usar filesService.getRecentUpload()
     *  para obtener los archivos recien subidos!! y resetear el servicio de subida
     * ***/
    $scope.$watch('filesProcess.estado', function(newVal, oldVal){
        if(newVal == 'finished' && oldVal == 'loading' ){
            var items = filesService.getRecentUpload();
            var data = new Array();
            angular.forEach(items, function(v){
                data.push({id: v.id, documento:$scope.folder});
                setGetOrder.change("adjunto"+ v.id,'id', v.id);
            });
            Order.postMod({type:$scope.formMode.mod, mod:"AddAdjuntos"},
                {id:$scope.document.id,adjuntos: data}, function(response){
                    $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                    $scope.reloadDoc();

                });
            $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
            //$scope.NotifAction
        }else if(newVal == "error"){
            console.log("error ");
            $scope.NotifAction('error', "No se pudieron subir los archivos",[],{autohidden:autohidden});
            filesService.getRecentUpload();
        }


    });

    $scope.allowEdit = function(){
        if($scope.formBlock){
            $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder modificar",[],{autohidden:autohidden});

        }
    };

    $scope.hoverpedido= function(document){
        document.isNew=false;

        $timeout(function(){
            if(document &&  $scope.mouseProview){
                $scope.formMode=$scope.forModeAvilable.getXValue(document.tipo_value);
                $scope.document=document;
                if($scope.module.layer !='resumenPedido' ){
                    $scope.moduleAccion({open:{name:"resumenPedido"}});
                }
            }
        }, 1000);
    };

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
        Order.postMod({type:$scope.formMode.mod,mod:"Update"},{id: $scope.document.id});
        setGetOrder.change("document","final_id", undefined);
    };
    /***@deprecated **/
    /*    $scope.showProduc= function () {
     $scope.showGripro = $scope.showGripro ? false : true;
     if($scope.showGripro){
     $scope.showGripro=false;
     }else {
     $scope.showGripro=true;
     }

     };*/

    $scope.closeTo = function(layer){
        $scope.moduleAccion({close:layer});

    };

    $scope.cancelDoc = function(){

        $scope.formBlock= false;
        $scope.moduleAccion({search:{name:"detalleDoc", after: function(){
            $scope.document.estado_id=3;// se cambia el estado a cancelado
            $scope.gridView =3;
            var mo= jQuery("#mtvCancelacion");
            mo[0].autofocus = true;
        }}});



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

    $scope.copyDoc = function() {

        Order.postMod({type:$scope.formMode.mod, mod:"Copy"},{id:$scope.document.id}, function(response){
            $scope.document.id = response.id;
            $scope.NotifAction("ok","Nueva version creada",[],{autohidden:autohidden});
            $scope.reloadDoc();
            $scope.formBlock=false;
            $scope.navCtrl.value="detalleDoc";
            $scope.navCtrl.estado=true;
            setGetOrder.change("document", 'id', response.id);

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
    };

    $scope.cancelClose = function(){
        console.log("entrp al cancel");
        return false;
    };
    $scope.printTrace = function(){
        if($scope.previewHtmltext == "Introdusca texto "){
            $scope.previewHtmltext="";
        }

        $scope.previewHtmlDoc ="";
        $http.get("Order/test").success(function (response) { $scope.previewHtmlDoc = response;});

               $scope.LayersAction({open:{name:"htmlViewer"}});


    };

    $scope.buildfinalDoc = function(){
        var final={};
        var cp= new Array();
        var kit =  new Array();
        var sus = new Array();
        ///var todos = new Array();
        angular.forEach(setGetOrder.getForm(), function(v,k){
                if(k.startsWith('contra')){
                    cp.push(v);
                }else
                if(k.startsWith('kitchen')){
                    kit.push(v);
                }
                else
                if(k.startsWith('pedidoSusti')){
                    sus.push(v);
                }
            }

        );
        angular.forEach(setGetOrder.getForm('document'), function(v,k){
                final[k]=v;
            }

        );
        final.contraPedido = cp;
        final.kitchenBox = kit;
        final.pedidoSusti = sus;
        return final;
    };


    /******************************************** filtros ********************************************/
    $scope.searchCountry = function(item,texto){
        return item.short_name.indexOf(texto) > -1;
    };

    $scope.search = function(){
        return $scope.todos;
    };

    $scope.searchEmails= function(){
        return $scope.email.contactos;
    };

    $scope.provShow = function(item){
        /* if(item!= null){
         if($scope.provdiderFilter.$valid){
         console.log(" filtro valido", item);
         if(item.razon_social.includes($scope.fRazSocial)){
         return true;
         }
         return false;
         }
         }
         */
        return true;

    };

    /*    var timeFilter ;
     $scope.$watchGroup(['provdiderFilter.$valid', 'provdiderFilter.$pristine'], function (nuevo) {

     if (nuevo[0] && !nuevo[1]) {
     $scope.provdiderFilter.$setPristine();

     }

     });*/




    /******************************************** APERTURA DE LAYERS ********************************************/

    $scope.openSide = function(name){
        $scope.navCtrl.value = name;
        $scope.navCtrl.estado=true;
    };
    $scope.openAdj = function(folder){
        if($scope.document.id){
            filesService.open();
            var items = new Array();
            $scope.folder = folder;
            filesService.setTitle(folder);
            var data= $filter("customFind")($scope.document.adjuntos,folder.toUpperCase(),function(current,compare){return current.documento==compare});

            if($scope.document.adjuntos.length >0 ){
                angular.forEach(data,function(v,k){
                    items.push(v.file);
                });

            }
            filesService.setFiles(items);
        }else {
            $scope.NotifAction("error","Debe completar los campos obligatorios para realizar esta accion",[],{autohidden:autohidden});

        }



    };
    /*
     $scope.openDocSusti = function(){
     $scope.docsSustitos = new Array();
     $scope.moduleAccion({open:{name:"agrPedPend", before: function(){

     Order.queryMod({type:$scope.formMode.mod,mod:"Substitutes", doc_id:$scope.document.id},function(response){
     $scope.docsSustitos =response;
     });
     }}});


     };*/
    $scope.openImport = function(){
        $scope.document.prov_id = $scope.provSelec.id;
        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){
            $scope.document.id = response.id;
            setGetOrder.addForm('document',$scope.document);
            setGetOrder.setState('select');

        });
        if($scope.formBlock ){
            $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder importar el documento",[],{autohidden:autohidden});
        }else{

            if($scope.formMode.value == 21){
                $scope.navCtrl.value="listEmailsImport";
                $scope.navCtrl.estado=true;

            }else  if($scope.formMode.value == 22 || $scope.formMode.value ==23 ){
                $scope.navCtrl.value="listImport";
                $scope.navCtrl.estado=true;

            }
        }

    };

    $scope.menuAgregar= function(){
        $scope.moduleAccion({close:"all"});
        $scope.moduleAccion({open:{name:"menuAgr"}});
        $scope.gridView=-1;
        $scope.preview =false;

    };

    $scope.openEmail= function(){
        $scope.moduleAccion({open:{name:"email"}});
        $http.get("Email/ProviderEmails").success(function (response) { $scope.email.contactos = response});
    };

    $scope.newDoc= function(formMode){

        $scope.formMode=formMode;
        $scope.formGlobal="new";
        $scope.document = {};
        if($scope.provSelec.id){
            $scope.document.prov_id=$scope.provSelec.id;
        }
        $scope.navCtrl.value="detalleDoc";
        $scope.navCtrl.estado= true;
        $scope.formBlock=false;
    };

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
        $scope.moduleAccion({open:{name:"resumenContraPedido", before: function(){

            Order.get({type:"CustomOrder", id: item.id, doc_id: $scope.document.id, tipo: $scope.formMode.value}, {},
                function(response){
                    console.log("respnose customer", response);
                    $scope.contraPedSelec= response;
                    if(response.fecha_aprox_entrega != null){
                        $scope.contraPedSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
                    }
                    if(response.fecha != null){
                        $scope.contraPedSelec.fecha = new Date(Date.parse(response.fecha));

                    }

                });

            if($scope.formDataContraP.contraPedidoMotivo.length <= 0){
                $scope.formDataContraP.contraPedidoPrioridad = Order.query({type: 'CustomOrderReason'});
            }
            if($scope.formDataContraP.contraPedidoPrioridad.length <= 0){
                $scope.formDataContraP.contraPedidoPrioridad = Order.query({type: 'CustomOrderPriority'});
            }
        }}});

    }

    function selecPedidoSust(item) {
        restore('pedidoSusPedSelec');
        $scope.moduleAccion({open:{name:"resumenPedidoSus", before: function(){
            Order.get({type:"Document", id:item.id,tipo:$scope.formMode.value}, {},function(response){
                console.log("sustitu", response);
                $scope.pedidoSusPedSelec = response;
            });

        }}});

    }

    function selecKitchenBox(item) {

        $scope.moduleAccion({open:{name:"resumenKitchenbox", before: function(){

            Order.get({type:"KitchenBox", id: item.id, doc_id: $scope.document.id, tipo: $scope.formMode.value}, {},
                function(response){
                    $scope.kitchenBoxSelec = response;
                    if (response.fecha != null) {
                        $scope.kitchenBoxSelec.fecha = new Date(Date.parse(response.fecha));
                    }
                    if (response.fecha_aprox_entrega != null) {
                        $scope.kitchenBoxSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
                    }

                });
        }}});
    };

    /** al pulsar la flecha siguiente
     *  working
     * **/
    $scope.next = function () {
        $scope.showNext(false);
        switch($scope.module.layer){
            case "resumenPedido":
                $scope.formMode= $scope.forModeAvilable.getXname($scope.document.documento);
                $scope.navCtrl.value = "detalleDoc" ;
                $scope.navCtrl.estado= true;

                break;
            case "detalleDoc":
                $scope.navCtrl.value = "listProducProv" ;
                $scope.navCtrl.estado= true;
                break;
            case "listProducProv":
                $scope.navCtrl.value = "agrPed" ;
                $scope.navCtrl.estado= true;
                break;
            case "agrPed":
                if($scope.document.productos.kitchenBox.length == 0
                    && $scope.document.productos.contraPedido.length == 0
                    && $scope.document.productos.kitchenBox.length  == 0
                    && setGetOrder.getInternalState() != "new"
                )
                {
                    $scope.NotifAction("alert",
                        "No se a selecionado ningun documento para la "+$scope.formMode.name+ "¿desea continuar de todas formas? "
                        ,[
                            {name:"Cancelar", action: function(){}}
                            ,{name:"Continuar",action: function(){
                                $scope.navCtrl.value = "finalDoc" ;
                                $scope.navCtrl.estado= true;

                            }}
                        ],{block:true});
                }

                else{
                    $scope.navCtrl.value = "finalDoc" ;
                    $scope.navCtrl.estado= true;
                }

                break;
            case "finalDoc":
                if($scope.document.productos.todos.length == 0 && setGetOrder.getInternalState() != "new")
                {
                    $scope.NotifAction("alert",
                        "No se ha cargado ningun articulo para la "+$scope.formMode.name+ "¿desea continuar? "
                        ,[
                            {name:"Cancelar", action: function(){}}
                            ,{name:"Continuar",action: function(){
                                $scope.navCtrl.value = "close" ;
                                $scope.navCtrl.estado= true;

                            }}
                        ],{block:true});
                }else{
                    $scope.navCtrl.value = "close";
                    $scope.navCtrl.estado= true;
                }


        }
        $scope.showNext(false);



    };

    $scope.showNext = function (status) {
        if (status) {
            if (!$scope.FormHeadDocument.$valid && $scope.module.layer== 'detalleDoc') {
                $scope.NotifAction("error",
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

    $scope.reloadSide = function(){

    };
    /*********************************************** EVENTOS CHANGE ***********************************************/

    $scope.onchangePeditem=  function (item){
        if(item.asignado){
            $http.post("Order/EditOrdenItem", item)
                .success(function (response) {

                });
        }
    };
    /* /!**@deprecated
     * *!/
     $scope.change = function (odc) {
     if (odc.asig) {
     addOrdenCompra(odc.id, $scope.document.id);
     } else {
     removeOrdenCompra(odc.id, $scope.document.id);
     }

     };*/
    $scope.changeContraP = function (item) {
        var paso=true;
        if(item.import){
            $scope.NotifAction("error",
                "Este Contra pedido fue agregado a partir de otra solicitud "
                ,[],{autohidden:autohidden});
            item.asignado=true;
            paso= false;

        }
        if(paso){
            item.doc_id=$scope.document.id;
            if(item.asignado){
                if(item.asignadoOtro.length >0){
                    $scope.NotifAction("alert",
                        "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
                        ,[
                            {name: 'Si',
                                action:function(){
                                    Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
                                        $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                                        setGetOrder.change('contraPedido'+item.id,'id',item);
                                    });
                                }
                            },{name: 'No',
                                action:function(){item.asignado=false;}
                            }
                        ]);
                }else {
                    Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
                        $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                        setGetOrder.change('contraPedido'+item.id,'id',item);

                    });
                }

            }
            else{
                $scope.NotifAction("alert",
                    "Se eliminara el contra pedido ¿Desea continuar?"
                    ,[
                        {name: 'Ok',
                            action:function(){
                                Order.postMod({type:$scope.formMode.mod,mod:"RemoveCustomOrder"},item,function(response){
                                    $scope.NotifAction("ok","Removido",[],{autohidden:autohidden});
                                    setGetOrder.change('contraPedido'+item.id,'id',undefined);

                                });
                            }
                        },{name: 'Cancel',
                            action:function(){item.asignado=true;}
                        }
                    ]);
            }
        }

    };

    $scope.changeProducto = function (item){
        var paso = true;
        if(item.asignado && item.saldo > 0){
            item.prov_id =$scope.provSelec.id;
            item.doc_id =$scope.document.id;
            Order.postMod({type:$scope.formMode.mod,mod:"ProductChange"},item,function(response){
                if(!item.reng_id){
                    $scope.NotifAction("alert",
                        "agregado"
                        ,[],{autohidden:autohidden});
                    var prod= angular.copy(response);
                    prod.cantidad = parseFloat(prod.cantidad);
                    $scope.providerProds.push(prod);


                }
                item.reng_id=response.reng_id;
                setGetOrder.change('producto'+item.id,'id',item);
            });
        }else if(!item.asignado && item.reng_id){
            $scope.NotifAction("alert",
                "Se eliminara el producto del documento ¿Deseas continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            Order.postMod({type:$scope.formMode.mod,mod:"ProductChange"},item,function(response){
                                $scope.NotifAction("info",
                                    "Removido"
                                    ,[],{autohidden:autohidden});
                                setGetOrder.change('producto'+item.id,'id',undefined);
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
                $scope.NotifAction("alert","Eliminado",[],{autohidden:autohidden});
                setGetOrder.change('producto'+item.id,'id',undefined);


            } else if(response.accion == "new"){
                $scope.NotifAction("alert","Agregado",[],{autohidden:autohidden});
                item.id=response.id;
                setGetOrder.change('producto'+item.id,'id',item);

            }
        });
    };

    /**
     * @review
     * */
    $scope.changeItem = function(item){
        Order.postMod({type:$scope.formMode.mod, mod:"ChangeItem"},item, function(response){
            setGetOrder.change('producto'+item.id,'id',item);
        });
    };


    /**
     * @review
     * */
    $scope.addRemoveCpItem = function(item){
        console.log(" item ",item);
        var aux = {
            asignado:item.asignado,
            tipo_origen_id: 2,
            doc_origen_id: item.contra_pedido_id,
            doc_id: $scope.document.id,
            cantidad:  item.cantidad,
            saldo:  item.cantidad,
            producto_id:  item.producto_id,
            descripcion:  item.descripcion,
            id:item.id

        };
        if(item.asignado){
            if(item.asignadoOtro.length == 0){
                Order.postMod({type:$scope.formMode.mod,mod:"AdddRemoveItem"},aux,function(response){
                    if(response.accion == "new"){
                        $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                        item.renglon_id= response.renglon_id;
                    }

                });
            }else{
                var text="Este item se encuentra agregado a ";
                angular.forEach(item.asignadoOtro, function(v,k){
                    text += v[0] +" " + v[1].length +" veces ";
                });
                $scope.NotifAction("alert",text,[
                    {name:'Cancelar',default: 2,
                        action: function(){

                        }
                    },
                    {name:'Continuar de todas formas',
                        action: function(){
                            Order.postMod({type:$scope.formMode.mod,mod:"AdddRemoveItem"},aux,function(response){
                                if(response.accion == "new"){
                                    $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                                    item.renglon_id= response.renglon_id;
                                }

                            });
                        }
                    }
                ]);
            }
        }else if(!item.asignado && item.renglon_id){
            $scope.NotifAction("alert","Se Removera el articulo",[
                {name:'Cancelar',default:2,
                    action: function(){

                    }
                },
                {name:'Continuar',
                    action: function(){
                        Order.postMod({type:$scope.formMode.mod,mod:"AdddRemoveItem"},aux,function(response){
                            if(response.accion == "new"){
                                $scope.NotifAction("ok","Removido",[],{autohidden:autohidden});
                                item.renglon_id= response.renglon_id;
                            }
                        });

                    }
                }
            ]);
        }



    };

    $scope.changeKitchenBox = function (item) {
        var paso = true;
        if (item.import) {
            $scope.NotifAction("error",
                "Este KitchenBox fue agregado a partir de otra solicitud "
                , [], {autohidden: autohidden});
            item.asignado = true;
            paso = false;

        }
        if (paso) {
            item.doc_id = $scope.document.id;
            if (item.asignado) {
                if (item.asignadoOtro.length > 0) {
                    $scope.NotifAction("alert",
                        "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
                        , [
                            {
                                name: 'Si',
                                action: function () {
                                    Order.postMod({
                                        type: $scope.formMode.mod,
                                        mod: "AddkitchenBox"
                                    }, item, function (response) {
                                        $scope.NotifAction("ok", "Asignado", [], {autohidden: autohidden});
                                        setGetOrder.change('kitchenBox'+item.id,'id',item);
                                    });
                                }
                            }, {
                                name: 'No',
                                action: function () {
                                    item.asignado = false;
                                }
                            }
                        ]);
                } else {
                    Order.postMod({type: $scope.formMode.mod, mod: "AddkitchenBox"}, item, function (response) {
                        $scope.NotifAction("ok", "Asignado", [], {autohidden: autohidden});
                        setGetOrder.change('kitchenBox'+item.id,'id',item);
                    });
                }

            }
            else {
                $scope.NotifAction("alert",
                    "Se eliminara el KitchenBox ¿Desea continuar?"
                    , [
                        {
                            name: 'Ok',
                            action: function () {
                                Order.postMod({
                                    type: $scope.formMode.mod,
                                    mod: "RemovekitchenBox"
                                }, item, function (response) {
                                    setGetOrder.change('kitchenBox'+item.id,'id',undefined);
                                    $scope.NotifAction("ok", "Removido", [], {autohidden: autohidden});
                                });
                            }
                        }, {
                            name: 'Cancel',
                            action: function () {
                                item.asignado = true;
                            }
                        }
                    ]);
            }

        };

    };

    $scope.changePedidoSustituto = function (item) {

        if (item.asignado) {
            Order.postMod({type:$scope.formMode.mod,mod:"AddSustitute"},{princ_id:$scope.document.id,reemplace_id:item.id},function(response){
                $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                $scope.document.id = response.id;
                setGetOrder.change('pedidoSusti'+item.id,'id',item);

            });
        } else {
            Order.postMod({type:$scope.formMode.mod,mod:"RemoveSustitute"},{princ_id:$scope.document.id,reemplace_id:item.id},function(response){
                $scope.NotifAction("ok","Removido",[],{autohidden:autohidden});
                $scope.document.id = response.id;
                setGetOrder.change('pedidoSusti'+item.id,'id',undefined);
                $scope.reloadDoc();

            });
        }

    };

    /**
     * @deprecated**/
    $scope.changePedidoSustitutoItem = function (item) {
        item.pedido_id = $scope.document.id;
        if(item.asignado){
            if ($scope.FormPedidoSusProduc.$valid) {
                $http.post("Order/AddOrderSubstituteItem", item)
                    .success(function (response) {
                        if (item.renglon_id == null) {
                            $scope.NotifAction("info",
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
                $scope.NotifAction("warn",
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
            $scope.NotifAction("alert",
                "Se eliminara el Pedido a sustituir ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            $http.post("Order/RemoveOrdenItem", {id: item.renglon_id,pedido_id:$scope.document.id})
                                .success(function (response) {
                                    $scope.NotifAction("info",
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

    };
    /*********************************************** EVENTOS FOCUS LOST ***********************************************/


    function setProvedor(prov, p) {

        $scope.provIndex= angular.copy(p.$index);

        if($scope.module.layer == "listPedido" ){
            $scope.provSelec = prov;
            loadPedidosProvedor(prov.id);
        }else if($scope.module.layer != "listPedido" && $scope.module.index == 0 ){
            $scope.navCtrl.value="listPedido";
            $scope.navCtrl.estado=true;
            $scope.provSelec = prov;
        }else{
            if(!$scope.document.id){
                $scope.provSelec = prov;

            }else {
                $scope.verificExit();
            }
        }



    }

    $scope.closeSide = function(){
        var paso= true;
        if($scope.document.id){
            if($scope.layer == 'resumenPedido'  && setGetOrder.getInternalState() != 'new'){
                paso = false;
            }

            if($scope.layer == 'detalleDoc' && $scope.module.historia.indexOf('resumenPedido') == -1 && setGetOrder.getInternalState() != 'new'){
                paso = false;
            }
        }

        if(!paso){
            $scope.verificExit();
        }else {
            var back= angular.copy($scope.module.historia[$scope.index -1]);

            if($scope.module.layer == "sideFiles"){
                $scope.LayersAction({close:true});
                filesService.close();
            }else{
                if(back){
                    console.log("back ",back);
                    $scope.navCtrl.value=back;
                    $scope.navCtrl.estado = true;

                    // $scope.nextSide=back;
                }else{
                    $scope.nextSide="";
                    $scope.LayersAction({close:true});
                }
            }
        }

    };

    function DtPedido(doc) {

        restore("document");

        $scope.gridView=-1;
        //init();
        var aux= angular.copy(doc);
        if(doc && $scope.module.index <2){
            if (segurity('editPedido')) {
                $scope.document.isNew=false;
                $scope.document=aux;

                $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
                $scope.preview=false;
                setGetOrder.setState('select');
                $scope.formGlobal ="upd";
                $scope.navCtrl.value="detalleDoc";
                $scope.navCtrl.estado=true;
            }
            else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        }
    }

    $scope.openTempDoc = function(doc){
        $scope.gridView=-1;
        //init();
        var aux= angular.copy(doc);
        if (segurity('editPedido')) {
            $scope.document.isNew=false;
            $scope.document.id=aux.id;
            $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
            setGetOrder.setState('select');
            $scope.formGlobal ="upd";
            //$scope.provSelec.id= aux.prov_id;
            $scope.provSelec = $filter("customFind")($scope.todos, aux.prov_id,function(current,compare){return current.id==compare})[0];
            $scope.navCtrl.value="detalleDoc";
            $scope.navCtrl.estado=true;
        }
        else {

        }


    };

    $scope.buildDocChange  = function(doc){

        setGetOrder.addForm('document',doc);
        angular.forEach(doc.productos.contraPedido, function(v,k){
            setGetOrder.addForm('contraPedido'+ v.id,v);

        });
        angular.forEach(doc.productos.kitchenBox, function(v,k){
            setGetOrder.addForm('kitchenBox'+ v.id,v);

        });
        angular.forEach(doc.productos.kitchenBox, function(v,k){
            setGetOrder.addForm('kitchenBox'+ v.id,v);

        });
        angular.forEach(doc.productos.pedidoSusti, function(v,k){
            setGetOrder.addForm('pedidoSusti'+ v.id,v);

        });

    };


    $scope.saveFinal = function(){
        Order.postMod({type:$scope.formMode.mod, mod:"Close"},$scope.document, function(response){

            if (response.success) {
                $scope.updateProv();
                $scope.NotifAction("ok","Finalizado",[
                    {name:"Ok", action: function(){
                        $scope.navCtrl.value=angular.copy($scope.module.historia[1]);
                        $scope.navCtrl.estado=true;
                    }}
                ],{block:true});
            }});


    };

    $scope.updateProv= function(){
        Order.get({type:"Provider", id: $scope.provSelec.id},{}, function(response){
            var prov = $filter("customFind")($scope.todos, $scope.provSelec.id,function(current,compare){return current.id==compare})[0];
            console.log('original prov', prov);
            console.log("response data", response);
            angular.forEach(prov,function(v,k){
                prov[k] = response[k];
            });
            console.log(" final ", $filter("customFind")($scope.todos, $scope.provSelec.id,function(current,compare){return current.id==compare})[0]);
             //$scope.provSelec = response;
        });
    };
    /****** **************************import  ***************************************/


    $scope.docImport = function (doc){

        var url="";

        if($scope.formMode.value == 22){
            url="BetweenOrderToSolicitud";
        }
        else{
            url="BetweenOrderToPurchase";
        }
        Order.get({type:url, princ_id:$scope.document.id,impor_id: doc.id}, {},function(response){
            var errors = response.error;

            if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length == 0 &&  Object.keys(response.items).length == 0 ){
                $scope.NotifAction("alert"," Sin cambios, ¿Desea que se asigne  la "+$scope.formMode.name+" como origen del nuevo?",
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.document.prov_id=$scope.provSelec.id;
                                setGetOrder.change("document","doc_parent_id",doc.id);
                                setGetOrder.setState("upd");
                                Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                $scope.NotifAction("ok","Realizado",[
                                    {
                                        name:"Ok",default:2,
                                        action: function(){
                                            $scope.navCtrl.value="detalleDoc";
                                            $scope.navCtrl.estado=true;
                                        }
                                    }
                                ] ,{block:true});

                            }
                        },
                        {name: "Cancelar",
                            action:function(){

                            }
                        }
                    ],{block:true});
            }else if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length == 0 &&  Object.keys(response.items).length > 0 ){
                $scope.NotifAction("alert"," Se Agregaran " +Object.keys(response.items).length+" productos ",
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
                                        $scope.NotifAction("ok","Realizado",[
                                            {name:"Ok",default:2, action: function(){
                                                $scope.moduleAccion({close:true});}} ] ,{block:true});
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

                $scope.NotifAction("alert"," Se asignaran " +Object.keys(response.items).length+" productos  y se modificaran " +Object.keys(response.asignado).length ,
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
                                        $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
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

                $scope.NotifAction("alert"," Se modificaran " +Object.keys(response.asignado).length,
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.document.prov_id=$scope.provSelec.id;
                                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                            }
                        },
                        {name: "Cancelar",
                            action:function(){

                            }
                        }
                    ],{block:true});


            }else {

                $scope.NotifAction("error"," El documento a utilizar posee algunas diferecias que deben revisarse antes de poder importar " +
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
                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
                        }
                    }
                    ,{name:"Dejarme elegir ",
                        action:function(){
                            $scope.NotifAction("error"," ¿Que desea hacer? "
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
                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
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
                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.moduleAccion({close:true});}} ] ,{block:true});
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
                                        $scope.accions = {
                                            cancel:false,
                                            total:Object.keys(errors).length,
                                            data : new Array()
                                        };
                                        $scope.$watchGroup(
                                            ['accions.cancel',
                                                'accions.total','accions.data.length'], function(newVal){
                                                if(newVal[0]){
                                                    $scope.NotifAction("error", "Cancelado",[],{autohidden:autohidden});
                                                    delete $scope.accions;
                                                }else{
                                                    if(newVal[1] == newVal[2]){
                                                        angular.forEach($scope.accions.data, function(v,k){
                                                            $scope.document[v.k]= v.v;
                                                            setGetOrder.change("document", v.k, v.v);
                                                        });
                                                        if(response.items.length > 0){
                                                            var aux ={}
                                                            var items = new Array();
                                                            angular.forEach(response.items ,function (v,k){
                                                                aux.tipo_origen_id = $scope.forModeAvilable.getXValue($scope.formMode.value - 1 );
                                                                aux.origen_item_id = v.id;
                                                                aux.doc_origen_id = doc.id;
                                                                aux.cantidad = v.saldo;
                                                                aux.saldo = v.saldo;
                                                                aux.producto_id = v.producto_id;
                                                                aux.descripcion = v.descripcion;
                                                                items.push(aux);
                                                            });
                                                            var data=  {
                                                                doc_id : $scope.document.id,
                                                                asignado:true,
                                                                items: items
                                                            };
                                                            Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                                                $scope.reloadDoc();
                                                            });
                                                        }

                                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document);
                                                        Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                                        $scope.NotifAction("ok","Realizado",[
                                                            {name:"Ok",default:2,
                                                                action: function(){
                                                                    setGetOrder.setState("upd");
                                                                    $scope.navCtrl.value="detalleDoc";
                                                                    $scope.navCtrl.estado = true;
                                                                }
                                                            }
                                                        ] ,{block:true});
                                                    }
                                                }
                                            });

                                        if(errors.prov_moneda_id){
                                            $scope.NotifAction("alert", "Selecione moneda a usar",[
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
                                            $scope.NotifAction("alert", "Selecione titulo a usar",[
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
                                            $scope.NotifAction("alert", "Selecione comentario a usar",[
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
                                            $scope.NotifAction("alert", "Selecione pais a usar",[
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
                                            $scope.NotifAction("alert", "Selecione la condicon de pago a usar",[
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
                                            $scope.NotifAction("alert", "Selecione la direcion de facturacion a usar",[
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
                                            $scope.NotifAction("alert", "Selecione el puerto a usar",[
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
                                            $scope.NotifAction("alert", "Selecione la condicion a usar",[
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
                                            $scope.NotifAction("alert", "Selecione la tasa a usar",[
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

    $scope.$watch('provSelec.id',function(nvo){

        var newHash ='prov' + nvo;
        if ($location.hash() !== newHash) {
            $location.hash(newHash);
        } else {

            $anchorScroll();
        }
    });


    $scope.$watch("formBlock",function(newVal){
        if(newVal == true){
            filesService.setallowUpLoad(false);
        }else if( newVal == false){
            filesService.setallowUpLoad(true);
        }

    });
    /** formulario  head*/
    $scope.$watch('document.pais_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            $scope.formData.direcciones= Order.query({type:"StoreAddress", prov_id:$scope.provSelec.id, pais_id:newVal});

            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){

                setGetOrder.addChange({id:"pais_id",value:newVal,text:"Pais"},$scope.formAction,"FormHeadDocument");
            }
        }
    });

    $scope.$watch('navCtrl.estado', function (newState) {
        if(newState){
            var newVal  = $scope.navCtrl.value;

            if (newVal != '' && typeof(newVal) !== 'undefined' && newVal != null){
                switch (newVal){
                    case "detalleDoc":
                        $scope.moduleAccion({search:{name:"detalleDoc",
                            before: function(){
                                $scope.FormHeadDocument.$setUntouched();
                                $scope.FormEstatusDoc.$setUntouched();
                                $scope.FormAprobCompras.$setUntouched();
                                $scope.FormCancelDoc.$setUntouched();
                            }
                        }})
                        ;break;
                    case "resumenPedido":
                        $scope.moduleAccion({search:{name:"resumenPedido",
                            before: function(){

                            }
                        }});
                        break;
                    case "listPedido" :
                        $scope.moduleAccion({search:{name:"listPedido",
                            before: function(){
                                loadPedidosProvedor($scope.provSelec.id);
                                $scope.hoverPreview(true);
                            }
                        }});
                        break;
                    case "agrContPed":
                        $scope.moduleAccion({search:{name:"agrContPed",
                            before: function(){
                                loadContraPedidosProveedor($scope.provSelec.id);;
                            }
                        }});
                        break;
                    case "agrKitBoxs":
                        $scope.moduleAccion({search:{name:"agrKitBoxs",
                            before: function(){
                                loadContraPedidosProveedor($scope.provSelec.id);
                            }
                        }});
                        break;
                    case "listProducProv":
                        $scope.moduleAccion({search:{name:"listProducProv",
                            before: function(){
                                Order.query({type:"ProviderProds", id:$scope.provSelec.id,tipo:$scope.formMode.value, doc_id:$scope.document.id},{}, function(response){
                                    var data = new Array();
                                    var aux ={};
                                    angular.forEach(response , function(v,k){
                                        aux ={};
                                        aux = v;
                                        aux.saldo=parseFloat(v.saldo);
                                        data.push(aux);
                                    });
                                    $scope.providerProds= data;
                                });
                            }
                        }});
                        break;
                    case "listImport":
                        $scope.moduleAccion({search:{name:"listImport",
                            before: function(){
                                if($scope.formMode.value !=21){
                                    var url='';
                                    switch ($scope.formMode.value){
                                        case  22: url = "SolicitudeToImport";break;
                                        case  23: url = "OrderToImport";break;
                                    }
                                    Order.query({type: url, id:$scope.document.id,tipo:$scope.formMode.value, prov_id:$scope.provSelec.id},{},function(response){
                                        var data = new Array();
                                        var aux ={};
                                        angular.forEach(response,function(v,k){
                                            aux = v;
                                            if(v.fecha_aprob_compra =! null && v.fecha_aprob_compra ){
                                                aux.fecha_aprob_compra= DateParse.toDate(v.fecha_aprob_compra);
                                            }

                                            if(v.ult_revision =! null && v.ult_revision ){
                                                aux.ult_revision= DateParse.toDate(v.ult_revision);
                                            }
                                            if(v.emision =! null && v.emision ){
                                                aux.emision= DateParse.toDate(v.emision);
                                            }
                                            data.push(aux);
                                        });
                                        $scope.docImports = data;
                                    });
                                }
                            }
                        }});
                        break;
                    case "listEmailsImport":
                        $scope.moduleAccion({search:{name:"listEmailsImport",
                            before: function(){

                            }
                        }});
                        break;
                    case "agrPed":
                        $scope.moduleAccion({search:{name:"agrPed",
                            before: function(){

                            }
                        }});
                        break;
                    case "finalDoc":
                        $scope.moduleAccion({search:{name:"finalDoc",
                            before: function(){

                                if(  setGetOrder.getState() != "built"){

                                    $scope.finalDoc = $scope.buildfinalDoc();
                                    Order.getMod({type:$scope.formMode.mod, mod:'Summary',id:$scope.document.id},{},function(response){
                                        $scope.finalDoc.productos= response.productos;
                                        $scope.finalDoc.adjProforma = $filter("customFind")(response.adjuntos,'PROFORMA',function(current,compare){return current.documento==compare});
                                        $scope.finalDoc.adjFactura = $filter("customFind")(response.adjuntos,'FACTURA',function(current,compare){return current.documento==compare});

                                    });
                                    setGetOrder.setState("built")
                                }
                            }
                        }});
                        break;
                    case "agrPedPend":
                        $scope.moduleAccion({search:{name:"agrPedPend",
                            before: function(){
                                $scope.docsSustitos = Order.queryMod({type:$scope.formMode.mod,mod:"Substitutes", doc_id:$scope.document.id});
                            }
                        }});
                        break;
                    case  "close":


                        if(setGetOrder.getInternalState() == 'new' && $scope.formGlobal!='new' && $scope.document.final_id){
                            $scope.NotifAction("alert","Sin cambios no se llevara a cabo ninguna accion",[],{autohidden:autohidden});
                        }else {

                            $scope.saveFinal();
                        }
                        break;
                    case "unclosetDoc":
                        $scope.moduleAccion({search:{name:"unclosetDoc",
                            before: function(){
                                $scope.unclosetDoc =Order.query({type:"UnClosetDoc"});
                                $scope.tempDoc= {};

                            }
                        }});
                        break;
                    default : $scope.moduleAccion({close:true});


                }

                /***   multiples */
                if(newVal == "agrPed" || newVal == "newVal" || newVal == "finalDoc" || newVal == "detalleDoc"){
                    if($scope.document.id != '' && typeof($scope.document.id) !== 'undefined' && setGetOrder.getState() != 'load'){
                        $scope.reloadDoc();
                    }
                }

            }
        }
        $scope.navCtrl.estado=false;
    });



    $scope.$watch('document.direccion_almacen_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
            }
            $http.get("Order/AdrressPorts",{params:{id:newVal}})
                .success(function(response){$scope.formData.puertos=response;});
        }
    });

    $scope.$watch('document.prov_moneda_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            masters.get({type:'getCoin',id:newVal});
            loadTasa(newVal);
        }
    });


    $scope.$watch('provSelec.id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined' && newVal) {
            $scope.formData.direccionesFact= Order.query({type:"InvoiceAddress", prov_id:newVal});
            $scope.formData.monedas = providers.query({type: "provCoins", id_prov: newVal || 0});
            $scope.formData.paises= Order.query({type:"ProviderCountry",id:newVal});
            $scope.formData.condicionPago= Order.query({type:"ProviderPaymentCondition", id:newVal});
        }
    });





    /**layers
     working
     * */
    $scope.$watchGroup(['module.index','module.layer'], function(newVal, oldVal){
        $scope.layer= newVal[1];
        $scope.index= newVal[0];
        // va para atras

        if(newVal[0]  == 0 ){
            $scope.provSelec ={id:'',razon_social:'',save:false, pedidos: new Array() };
            $timeout(function(){$scope.reviewDoc()},1000);
            $scope.provIndex = null;
            $scope.tempDoc= {};

        }

        if(newVal[0] == 0 || newVal[0] == 1){
            restore('document');// inializa el pedido
            $scope.gridView=-1;
            $scope.imagenes = new Array();
            setGetOrder.restore();
            $scope.formBlock = true;
        }

        if (newVal[1] != '' && typeof(newVal[1]) !== 'undefined') {
            var layer= newVal[1];
            if($scope.provSelec.id != ''){
            }

        }
    });


    $scope.reloadDoc = function(){
        Order.get({type:"Document", id:$scope.document.id,tipo:$scope.formMode.value}, {},function(response){
            $scope.document= response;

            $scope.document.emision=DateParse.toDate(response.emision);
            $scope.document.monto=parseFloat(response.monto);
            $scope.document.tasa=parseFloat(response.tasa);
            if(response.fecha_aprob_compra =! null && response.fecha_aprob_compra ){
                $scope.document.fecha_aprob_compra= DateParse.toDate(response.fecha_aprob_compra);
            }

            if(response.ult_revision =! null && response.ult_revision ){
                $scope.document.ult_revision= DateParse.toDate(response.ult_revision);
            }
            if(setGetOrder.getState() =="select");
            $scope.buildDocChange($scope.document);
            setGetOrder.setState("load");


        });
    };

    /******************************** GUARDADOS ***************************************/

    var timeSave ;
    $scope.$watchGroup(['FormHeadDocument.$valid', 'FormHeadDocument.$pristine'], function (nuevo) {

//        console.log(" form head ", nuevo);

        if (nuevo[0] && !nuevo[1]) {

            if(timeSave){
                $timeout.cancel(timeSave);
            }
            timeSave =$timeout(function(){
                $scope.document.prov_id = angular.copy($scope.provSelec.id);
                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){
                    if (response.success) {
                        $scope.document.id = response.id;
                        $scope.FormHeadDocument.$setPristine();
                        if(response['action'] == 'new'){
                            $scope.NotifAction("ok","Creado, Puede continuar",[],{autohidden:autohidden});
                            setGetOrder.addForm('document',$scope.document);
                            setGetOrder.setState('load');
                            $scope.reloadDoc();
                        }
                        console.log(" save");

                    }
                });
            },500);

        }

    });


    $scope.$watchGroup(['FormEstatusDoc.$valid', 'FormEstatusDoc.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {

            $scope.document.prov_id = $scope.provSelec.id;
            //{id:$scope.document.id, estado_id:$scope.document.estado_id}
            Order.postMod({type:$scope.formMode.mod, mod:"SetStatus"},{id:$scope.document.id, estado_id:$scope.document.estado_id}, function(response){
                if (response.success) {
                    $scope.NotifAction("ok","Estado cambiado a "+response.item.estado,[],{autohidden:autohidden});
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
             $scope.NotifAction("ok","Estado cambiado a "+response.item.estado,[],{autohidden:autohidden});
             }

             });*/
        }


    });



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

        $scope.NotifAction("alert",
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
                         $scope.NotifAction("alert","Removido",[],{autohidden:autohidden});
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
        $scope.formData.monedas = providers.query({type: "provCoins", id_prov: id || 0});
        /* $http.get("provider/provCoins/"+id).success(function (response) {
         $scope.formData.monedas=response;
         //  $scope.document.prov_moneda_id= response[0].id;

         });*/
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
        Order.query({type:"OrderProvOrder", id:id}, {},function(response){
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
        $scope.formData.contraPedido = Order.query({type:"CustomOrders",  prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value});
        /* $http.get("Order/CustomOrders",{params:{ prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value}})
         .success(function (response) {
         $scope.formData.contraPedido= response;
         });*/
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

    function segurity(key){
        return true;
    }

    function  restore(key){
        switch (key){
            case 'provSelec':
                $scope.provSelec ={id:'',razon_social:'',save:false, pedidos: new Array() };
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


MyApp.controller("LayersCtrl",function($mdSidenav, Layers, $scope){

    $scope.accion= Layers.getAccion();
    $scope.$watch("accion.estado", function(newVal){
        if(newVal){
            var module = Layers.getModule();
            var arg = $scope.accion.data;
            $scope.accion.estado=false;
            if(arg.open){
                open(arg.open, module);
            }else
            if(arg.close){
                close(arg.close,module);
            }else
            if(arg.search){
                if(module.historia.indexOf(arg.search.name) == -1) {
                    open(arg.search, module);

                }else {
                    close(arg.search, module);
                }
            }else {
                console.log("error parametro no implemtnado")
            }
        }
    });

    function close(arg, module){
        if(module.index>0 && !module.blockBack){

            var paso=true;
            if(arg.before){
                var res=arg.before();

                if(res == false){
                    paso=false;
                }

            }
            if(paso){
                module.blockBack=true;
                var close =1;
                var current= module.index;
                if(arg.name){
                    var aux = module.historia.indexOf(arg.name);
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
                    $mdSidenav(l).close().then(function(){
                        if(arg.after){
                            arg.after();
                        }
                    });
                    module.historia[current]=null;
                    current--;
                }
                //module.historia.splice(0,current+1);
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

MyApp.controller("FilesController" ,['$filter','$scope','$mdSidenav','$resource','$timeout','Upload','SYSTEM','filesService','Layers','setNotif', function($filter, $scope,$mdSidenav,$resource,$timeout,Upload ,SYSTEM,filesService, Layers,setNotif){

    $scope.template = "modules/home/files";
    $scope.accion= filesService.getAccion();
    $scope.isOpen = filesService.isOpen();
    $scope.titulo = filesService.getTitle();
    $scope.pitures = filesService.getFiles();
    $scope.module = Layers.getModule();
    $scope.moduleAccion = Layers.getAccion();
    $scope.cola = filesService.getProcess();
    $scope.allowUpload = filesService.allowUpLoad();
    filesService.setallowUpLoad(false);
    $scope.inLayer = "";
    $scope.expand=false;
    $scope.imgSelec = null;
    $scope.resource = $resource('master/files/:type', {}, {
        query: {method: 'GET',params: {type: "getFiles"}, isArray: true},
        get: {method: 'GET',params: {type:"getFile"}, headers: {'Content-Type': 'image/png'},isArray: false},

    });
    /*    $scope.$watch('allowUpload.val', function(newVal){
     console.log(" cambio el permiso de subido a " ,newVal )
     });*/

    /***
     * indicador de progreso
     * usar $watch para saber si se terminaron de subir todos los archivos
     *  filesService.getProcess().estado;
     *  cuando olVal =='loading' && newVal == 'finished' se acaba de subir los archivos
     * ***/
    $scope.$watchGroup(['cola.total',
        'cola.terminados.length','cola.estado'], function(newVal){
        if(newVal[0]> 0 && newVal[2] == 'wait'){/// si entra en modo de espera
            $scope.cola.estado='loading';

        }
        if(newVal[0] == newVal[1] && newVal[2] == 'loading'){
            $scope.cola.estado='finished';
        }
    });

    /** cerrado de la grilla en modo small**/
    $scope.closeSideFile = function(){
        filesService.close();
    };

    /*****/
    $scope.selectImg= function(doc){
        console.log("upload ", $scope.allowUpload);
        Layers.setAccion({open:{name:'sideFiles',before:
            function(){$scope.expand=true;}
        }});

        if(doc.tipo.startsWith("image")){
            $scope.imgSelec =SYSTEM.PATHAPP +"master/files/getFile?id="+doc.id;
            $scope.pdfSelec= undefined;
        }else {
            $scope.imgSelec =undefined;
            $scope.pdfSelec= SYSTEM.PATHAPP +"master/files/getFile?id="+doc.id;
        }


    };

    /** subida de archivos  al servidor */
    $scope.upload = function(files){
        console.log("allowUpLoad", filesService.allowUpLoad());
        //if( filesService.allowUpLoad() == true){
        $scope.isUploading = false;
        $scope.cola.total = files.length;
        if (files && files.length) {
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                //$scope.pitures.push({thumb:'ImageDefect.jpg'});*/
                Upload.upload({
                    url: 'master/files/upload',
                    data :{ folder:filesService.getFolder(),file: file}
                }).progress(function (evt) {
                    // var progressPercentage = ;
                    uploadNow = parseInt(100.0 * evt.loaded / evt.total);
                }).success(function (data, status, headers, config) {
                    /*newFile.id= data.id;
                     newFile.file= data.file;
                     newFile.thumb= data.thumb;
                     newFile.tipo= data.tipo;
                     newFile.file= data.file;
                     newFile.folder= data.folder;*/
                    //$scope.pitures.pop();
                    $scope.pitures.push(data);
                    $scope.cola.terminados.push(data);

                }).error(function(){
                    $scope.cola.estado = "error";
                    //setNotif.addNotif('error', "No se pudieron subir algunos archivos");
                });
            }
        }
        /* }else{

         }*/
    };

    $scope.$watch("accion.estado", function(newval){

        if(newval){

            if($scope.accion.data.open ){
                $scope.inLayer = angular.copy($scope.module.layer);
                var exp = angular.element(document).find("#"+$scope.inLayer).find("#expand");
                var sn = angular.element(document).find("#sideFiles");
                sn.css('width','336px');
                sn.css('z-index',String(Layers.getModule().index + 60));
                if(exp.length > 0){
                    exp.animate({width:"336px"},400);
                }
                $mdSidenav("sideFiles").open().then(function(){


                });
                $scope.isOpen= true;
                $scope.accion.estado=false;
            }else  if($scope.accion.data.close ){
                var exp = angular.element(document).find("#"+$scope.inLayer).find("#expand");
                if(exp.length > 0){
                    exp.animate({width:"0px"},400);

                }
                if(!$scope.expand){
                    console.log("cerrado")
                    $mdSidenav("sideFiles").close().then(function(){

                        if($scope.expand){
                            $scope.expand=false;
                        }
                        console.log("cerrado ");
                        $scope.isOpen= false;
                    });
                }else{
                    $scope.isOpen= false;
                    console.log("cerrado ");
                }
                $scope.accion.estado=false;


            }

        }
    });

    $scope.$watch('module.layer', function(newVal){
        if(newVal){
            $timeout(function(){
                if($scope.isOpen && newVal != "sideFiles" ){
                    filesService.close();
                }
            },200);

        }

    });
    /*    $scope.$watch('moduleAccion.estado', function(newVal){
     if(newVal){
     $timeout(function(){
     if($scope.isOpen ){
     console.log("close")
     if(Layers.getModule().layer != 'sideFiles'){
     filesService.close();
     console.log("on layyer", $scope.inLayer);


     }
     }
     },200);

     }

     });*/

}]);



MyApp.service('setGetOrder', function() {

    var forms ={};
    var interno= 'new';
    var externo= 'new';
    return {

        addForm: function(k, field){
            if(!forms[k]){
                forms[k]={};
                angular.forEach(field, function(v,k2){
                    if(v!=null && typeof (v) != 'object' && typeof (v) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                        forms[k][k2]={original:v, v:v, estado:'new',trace:new Array()};
                    }

                });
            }else{
                /*angular.forEach(field, function(v,k2){
                 if(v!=null && typeof (v) != 'object' && typeof (v) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                 forms[k][k2].v= v;
                 forms[k][k2].estado='upd';
                 forms[k][k2].trace.push(v);
                 }

                 });*/
            }
        },
        change: function(form,fiel, value){
            externo='upd';
            interno='upd';
            if(!forms[form]){
                forms[form]={};
            }
            if(!forms[form][fiel] && typeof (value) != 'object'){
                forms[form][fiel]= {original:value, v:value, estado:'new',trace:new Array()};
            }
            if(!forms[form][fiel] && typeof (value) == 'object'){
                angular.forEach(value, function(v,k){
                    if(v!=null && typeof (v) != 'object' && typeof (v) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                        forms[form][k]={original:v, v:v, estado:'new',trace:new Array()};
                    }

                });
                value= angular.copy(value[fiel]);
            }
            if(typeof (value) != 'undefined'){
                if(forms[form][fiel].original != value  ){
                    forms[form][fiel].v= value;
                    forms[form][fiel].trace.push(value);
                    forms[form][fiel].estado='upd';

                }else
                if(forms[form][fiel].original == value  ){
                    forms[form][fiel].estado='new';
                    forms[form][fiel].trace.push(value);
                    forms[form][fiel].v= value;
                }
            }/*else if(typeof (value) == 'object'){
             forms[form][fiel].v=value[fiel];
             forms[form][fiel].estado='new';
             forms[form][fiel].trace=value[fiel];
             }*/
            else{
                forms[form][fiel].estado='del';
                forms[form][fiel].trace.push();
            }
        },
        getForm: function(name){
            if(name){
                return forms[name];
            }
            else{
                return forms;
            }
        },
        restore: function(){
            forms={};
            interno='new';
            externo= 'new';
        },
        setState : function(val){
            externo= val;
        },
        getState: function(){
            return externo;
        },
        getInternalState: function(){
            return interno;
        }


    };
});

MyApp.service('Layers' , function(){

    var modules ={};
    var accion ={estado:false,data:{}};
    var modulekey="";


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
        },
        setAccion: function(arg){

            accion.data=arg;
            accion.estado=true;
        },
        getIndex : function (){
            return  modules[modulekey].layer;
        },
        getModuleKey : function(){ return modulekey;}
    }


});

MyApp.service('filesService' ,function(){
    var all = new Array();
    var accion ={estado:false,data:{}};
    var isOpen= false;
    var titulo ="Adjuntos";
    var folder ="";
    var process = {
        total : 0 ,
        terminados: new Array(),
        estado:'wait'
    };
    var allowUpload = {val:false};
    return {
        setFiles: function(data){
            all.splice(0,all.length);
            angular.forEach(data, function(v){
                all.push(v);
            });
            console.log();

        },
        getFiles: function(){
            return all;
        },
        getAccion : function(){
            return accion;
        },
        open : function(){
            accion.data ={open:true};
            accion.estado=true;

        },
        close : function(){
            accion.data ={close:true};
            accion.estado=true;
        },
        isOpen : function(){
            return isOpen;
        },
        getTitle: function(){
            return titulo;
        },
        setTitle : function(value){
            titulo =value;
        },
        setFolder: function(value){
            folder = value;
        },
        getFolder : function (){
            return folder;
        },
        getProcess : function(){
            return process;
        },
        getRecentUpload : function(){
            var data = angular.copy(process.terminados);
            process.terminados.splice(0,process.terminados.length);
            process.total =0;
            process.estado ='wait';
            return data;
        },
        allowUpLoad : function(){return allowUpload;},
        setallowUpLoad : function(value){
            allowUpload.val= value;
        }


    };
});

MyApp.factory('Order', ['$resource',
    function ($resource) {
        return $resource('Order/:type/:mod', {}, {
            query: {method: 'GET',params: {type: ""}, isArray: true},
            get: {method: 'GET',params: {type:""}, isArray: false},
            html: {method: 'GET',params: {type:""},isArray: false ,headers: { 'Content-Type': 'text/html' }},
            post: {method: 'POST',params: {type:" "}, isArray: false},
            postMod: {method: 'POST',params: {type:" ",mod:""}, isArray: false},
            getMod: {method: 'GET',params: {type:"",mod:""}, isArray: false},
            queryMod: {method: 'GET',params: {type: "", mod:""}, isArray: true},
            postAll: {method: 'POST',params: {type:" "}, isArray: false}

        });
    }
]);
//

MyApp.factory('Accion', function(){
    function  Accion (){
        return {
            estado:true,
            value: ''

        }
    }
    return {
        create : function(){
            return new Accion();
        }
    };

});
MyApp.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode){
        return $sce.trustAsHtml(htmlCode);
    }
}]);
MyApp.constant('SYSTEM',{
    ROOT:"http://"+window.location.hostname,
    BASE:"/"+window.location.pathname.split("/")[1]+"/",
    PATHAPP : "http://"+window.location.hostname+"/"+window.location.pathname.split("/")[1]+"/"

});
/******************************** trash ***********************************/
