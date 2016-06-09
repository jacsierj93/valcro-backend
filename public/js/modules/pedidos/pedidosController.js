MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav,$timeout ,$filter,$log,ORDER,Layers,setGetOrder,setNotif, DateParse) {

    // var historia = [15];
    var autohidden= 2000;

    // controlers
    $scope.formBlock = true;
    $scope.module= Layers.setModule("pedidos");
    console.log($scope.module);

    $scope.email= {};
    $scope.email.destinos = new Array();
    $scope.email.content = new Array();
    $scope.formMode = null;
    $scope.tempDoc= new Array();

    $scope.forModeAvilable={
        solicitud: {
            name: "Solicitud",
            value:21
        },
        proforma: {
            name: "Proforma",
            value:22
        },
        odc: {
            name: "Orden de Compra",
            value:23
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

    /**testes **/





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
        review();
    },1000);
    $timeout(function(){
        init();
    },2000);


    $http.get("Order/OrderProvList").success(function (response) {$scope.todos = response;});

    function init() {
        $http.get("master/getCountriesProvider").success(function (response) {$scope.filterData.paises = response;});
        $http.get("master/getOrderReason").success(function (response) {$scope.formData.motivoPedido=response;});
        $http.get("master/getOrderCondition").success(function (response) {$scope.formData.condicionPedido=response;});
        $http.get("master/getOrderStatus").success(function (response) {$scope.formData.estadoPedido=response;});
        $http.get("master/getPaymentType").success(function (response) {$scope.formData.tipoDepago= response;});
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
    }

    $scope.FilterLateral = function(){
        if(!$scope.showLateralFilter){
            jQuery("#menu").animate({height:"232px"},500);
            $scope.showLateralFilter=true;
        }
    }

    $scope.FilterLateralMas = function(){
        if(!$scope.showLateralFilterCpl){
            jQuery("#menu").animate({height:"80%"},400);
            $scope.showLateralFilterCpl=true;
            $scope.imgLateralFilter="images/Down.png";
        }else {
            jQuery("#menu").animate({height:"48px"},400);
            $scope.showLateralFilter=false;
        }
    }

    $scope.filtOpen= function(){
        if($scope.isOpen){
            $scope.isOpen=false;
        }else {
            $scope.isOpen=true;
        }
    }

    /******************************************** ROLLBACK SETTER **/

    $scope.toEditHead= function(id,val){
        console.log('faaaa');
        var aux= {id:id,value:val};
        setGetOrder.addTrace(aux,"FormHeadDocument");

    }
    /********************************************EVENTOS ********************************************/


    $scope.hoverpedido= function(document){
        document.isNew=false;

        $timeout(function(){
            if(document &&  $scope.mouseProview){
                console.log(document);
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


    }

    $scope.hoverEnter=  function(){
        $scope.mouseProview= true;
    }
    $scope.hoverPreview= function(val){
        $scope.preview=val;
    }

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

    /********************************************DEBUGGIN ********************************************/

    $scope.test = function (test) {
        alert(test);
    }
    $scope.simulateClick = function (id) {
        var a = angular.element(document).find(id);
        a.click();
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

    $scope.menuAgregar= function(){
        $scope.moduleAccion({close:"all"});

        $scope.moduleAccion({open:{name:"menuAgr"}});

    }

    $scope.openEmail= function(){
        $scope.moduleAccion({open:{name:"email"}});
        $http.get("Email/ProviderEmails").success(function (response) { $scope.email.contactos = response});
    }

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

        $scope.formDataContraP.contraPedidoMotivo = ORDER.query({type: 'CustomOrderReason'});
        $scope.formDataContraP.contraPedidoPrioridad = ORDER.query({type: 'CustomOrderPriority'});
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
                $scope.moduleAccion({open:{name:"detalleDoc"}});

            case "listProducProv":
                $scope.moduleAccion({open:{name:"agrPed"}});
                break;
            case "agrPed":
                $scope.moduleAccion({open:{name:"finalDoc"}});
                break;
            case "finalDoc":
                saveDoc();
                break;
        }
        $scope.showNext(false);
    }

    $scope.showNext = function (status) {
        if (status) {
            if (!$scope.FormHeadDocument.$valid && $scope.module.layer== 'detalleDoc') {
                setNotif.addNotif("error",
                    "Existen campos pendientes por completar, por favor verifica que información le falta."
                    ,[],{autohidden:autohidden});

            } else {
                $mdSidenav("NEXT").open();
            }

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
        if (item.asignado) {

            $http.post("Order/AddCustomOrder", { id:item.id, doc_id:$scope.document.id, tipo:$scope.formMode.value})
                .success(function (response) {
                    setNotif.addNotif("ok","Asignado",[],{autohidden:autohidden});
                });

        } else {

            setNotif.addNotif("alert",
                "Se eliminara el contra pedido ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            $http.post("Order/RemoveCustomOrder", { id:item.id, pedido_id:$scope.document.id})
                                .success(function (response) {
                                    setNotif.addNotif("ok","Removido",[],{autohidden:autohidden});
                                });
                        }
                    },{name: 'Cancel',
                        action:function(){item.asignado=true;}
                    }
                ]);
        }

    }


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
        if (item.asignado) {
            $http.post("Order/AddkitchenBox",{ id:item.id, doc_id:$scope.document.id, tipo:$scope.formMode.value})
                .success(function (response) {
                    if (item.renglon_id == null) {
                        setNotif.addNotif("ok","Asignado",[],{autohidden:autohidden});

                    }
                });
        } else {
            setNotif.addNotif("alert",
                "Se removera el Kitchenbox ¿Desea continuar?"
                ,[
                    {name: 'Ok',
                        action:function(){
                            $http.post("Order/RemovekitchenBox", {id: item.id, pedido_id:$scope.document.id})
                                .success(function (response) {
                                    setNotif.addNotif("ok","Removido" ,[],{autohidden:autohidden});
                                    loadDoc($scope.document.id);
                                });
                        }
                    },{name: 'Cancel',
                        action:function(){
                            item.asignado=true;
                        }
                    }
                ]);
        }

    }

    $scope.changePedidoSustituto = function (item) {

        if (item.asignado) {

            addPedidoSustituto(item.id, $scope.document.id);
        } else {
            removePedidoSustituto(item.id, $scope.document.id);
        }

    }

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
            console.log(prov);
            Layers.setAccion({open:{name:"listPedido"}});
        }else{
            if($scope.module.layer == "listPedido" ){
                $scope.provSelec = prov;
                loadPedidosProvedor($scope.provSelec.id);
            }else{

            }
        }

    }

    function openLayer(layer) {

        /*   if (historia.indexOf(layer) == -1) {
         var l = angular.element(document).find("#" + layer);
         var base = 264;
         $scope.index++;
         var w = base + (24 * $scope.index);
         l.css('width', 'calc(100% - ' + w + 'px)');
         $mdSidenav(layer).open();
         l.css('z-index', String(60  + $scope.index));
         historia[$scope.index] = layer;
         $scope.layer = layer;
         return true;
         }
         return false;*/
    }

    function DtPedido(doc) {


        restore("document");
        var aux= angular.copy(doc);
        if(doc && $scope.module.index <2){
            if (segurity('editPedido')) {
                document.isNew=false;
                $scope.document=aux;
                $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
                $scope.preview=false;
                setGetOrder.setGlobalAction("upd");
               // $scope.formAction="upd";
                $scope.moduleAccion({open:{name:"resumenPedido"}})
            }
            else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        }
    }

    function closeLayer(opt) {
        /* if($scope.index>0){
         var close =1;
         var index= $scope.index;
         if(typeof (opt) == 'string'){
         switch (opt){
         case 'all':break;{
         close = historia.length -1;
         }

         default:
         var aux = historia.indexOf(opt);
         if(aux!= -1){
         close= index - aux;
         }else{
         console.log("no esta abierto", opt);
         close=0;
         }
         }


         }else if(typeof (opt) == 'number'){
         close= opt;
         }

         for(var i=0; i<close;i++){
         var layer = historia[index];
         $mdSidenav(layer).close();
         historia[index]=null;
         index--;
         }
         $scope.index= index;
         $scope.layer = historia[index];
         }*/

    }

    /**@deprecated*/
    function closeLayeValid() {
        var layer = historia[$scope.index];

        var paso = true;
        switch (layer) {
            case 'resumenContraPedido':

                if (!$scope.FormResumenContra.$valid) {
                    alert('problemas en el formulario');
                    paso = false;
                }
                break;
        }

        if (paso) {
            LayersCtrl.closeLayer();
        }
    }

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

        });

    /**layers*/
    $scope.$watchGroup(['module.index','module.layer'], function(newVal){
        console.log('new value', newVal[1]);
        switch (newVal[0]){
            case 0:
                restore('provSelec');// inializa el proveedor
                restore('document');// inializa el pedido
                //  restore('FormData');// inializa el proveedor
               // loadDataFor();
                setGetOrder.setGlobalAction("new");
                $scope.gridView=4;

                break;
            default:
                console.log('changes',setGetOrder.getChanges());
                $scope.FormHeadDocument.$setUntouched();
        }

        if (newVal[1] != '' && typeof(newVal[1]) !== 'undefined') {
            var layer= newVal[1];
            console.log("entro a validar");
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
                if(layer == "agrPedPend" ){
                    $http.get("Order/OrderSubstitutes",{params:{id:$scope.document.id,tipo:$scope.formMode.value}}).success(function (response) {


                    });

                }
                if(layer == "listProducProv" ){
                    $http.get("Order/ProviderProds",{params:{id:$scope.document.id,tipo:$scope.formMode.value}}).success(function (response) {
                        var items=new Array();
                        $scope.provSelec.productos= response;

                    });
                }
                if(layer == "agrPed" || layer == "detalleDoc" || layer == "agrPed" || layer == "finalDoc"
                ){
                    if(!$scope.document.isNew){
                        $http.get("Order/Document",{
                            params:{id:$scope.document.id,tipo:$scope.formMode.value}}
                        ).success(function (response) {
                            $scope.document= response;
                            $scope.document.emision=DateParse.toDate(response.emision);
                            $scope.document.monto=parseFloat(response.monto);
                            $scope.document.tasa=parseFloat(response.tasa);
                            if(response.fecha_aprob_compra){
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

            saveDoc();
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
        switch ($scope.formMode.value){
            case 21:url="Solicitude/Save";break;
            case 22:url="Order/Save";break;
            case 23:url="PurchaseOrder/Save";break;
        }

        $scope.document.prov_id = $scope.provSelec.id;

        $http.post(url,  $scope.document)
            .success(function (response) {
                $scope.FormHeadDocument.$setPristine();
                if (response.success) {
                    $scope.FormHeadDocument.$setUntouched();
                    $scope.document.id = response.id;
                    if(response.success  ){
                        if(response['action'] == 'new'){
                            setNotif.addNotif("ok","Creado, Puede continuar",[],{autohidden:autohidden});
                        }
                        if($scope.module.layer == "finalDoc"){
                            $scope.formBlock=true;
                            setNotif.addNotif("ok","Realizado",[{name:"ok",action:function(){
                                Layers.setAccion({close:{all:true}});
                            }}],{autohidden:autohidden});
                            switch ($scope.formMode){
                                case "Solicitud":

                                    break;
                                case "Orden de Compra":

                                    break;
                            }
                        }

                    }


                }else{
                    console.log('error ', response);
                }

            });
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

    }
    function loadDoc(id){
        /* restore("document");
         var url="";
         switch ($scope.formMode){
         case 'Solicitud':
         url="Solicitude/Get"
         break;
         case 'Orden de Compra':
         url="PurchaseOrder/Get"
         break;
         default :
         console.log('ruta actualizacion no definidad');
         }
         $http.get(url,{params:{id:id}}).success(function (response) {

         $scope.document = response;
         $scope.document.emision=DateParse.toDate(response.emision);
         $scope.document.monto=parseFloat(response.monto);
         $scope.document.tasa=parseFloat(response.tasa);
         });*/
    }

    function loadDataFor(){
       /* $http.get("Order/OrderDataForm").success(function (response) {
            $scope.formData.motivoPedido=response.motivoPedido;
            $scope.formData.tipo= response.tipoPedido;
            $scope.filterData.tipoPedidos=response.tipoPedido;
            $scope.formData.prioridadPedido=response.prioridadPedido;
            $scope.formData.condicionPedido=response.condicionPedido;
            $scope.formData.estadoPedido=response.estadoPedido;
            $scope.formData.tipoDepago= response.tipoDepago;

        });*/
    }


    function loadDirProvider(id, tipo){
        $http.get("Order/Address",{params:{id:id,tipo_dir: tipo}}).success(function (response) {
            $scope.formData.direcciones=response;
            // $scope.document.direccion_almacen_id= response[0].id;
        });
    }

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
            console.log("pedidos",items);
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
            console.log("errorrr");
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
            console.log("errorrr");
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

    function loadPedidosASustituir(id){
        $http.get("Order/OrderSubstitutes",{params:{prov_id:id, pedido_id: $scope.document.id}}).success(function (response) {
            $scope.formData.pedidoSust= response;

        });
    }

    /*********************************  peticiones  guardado $http ********************* ************/

    function addOrdenCompra(id, pedido_id){
        $http({
            method: 'POST',
            url: 'Order/AddPurchaseOrder',
            data:{ id:id, pedido_id:pedido_id}
        }).then(function successCallback(response) {
            alert('Asignado');
        }, function errorCallback(response) {
            console.log("errorrr");
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
    }

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


    return {
        setModule: function (name){
            if(!modules[name]){
                modules[name]={historia: new Array(),layers:new Array(),index: 0,layer:"",blockBack:false};

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
        }
    }

});

MyApp.controller("LayersCtrl",function($mdSidenav, Layers, $scope){

    $scope.accion= Layers.getAccion();

    $scope.$watch("accion.estado", function(newVal){

        if(newVal){
            var module = Layers.getModule();
            var arg = $scope.accion.data;
            console.log("modulo", module);
            console.log("acc", arg);
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

MyApp.factory('ORDER', ['$resource',
    function ($resource) {
        return $resource('Order/:type/:id', {}, {
            query: {method: 'GET',params: {type: "",id:""}, isArray: true},
            get: {method: 'GET',params: {type:" "}, isArray: false},
            post: {method: 'POST',params: {type:" "}, isArray: false},
            postAll: {method: 'POST',params: {type:" "}, isArray: false}

        });
    }
]);
