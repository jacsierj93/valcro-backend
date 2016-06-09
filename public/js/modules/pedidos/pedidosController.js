MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav,$timeout ,$filter,$log,ORDER,Layers,FormChange,setNotif, DateParse) {

    // var historia = [15];
    var autohidden= 2000;

    // controlers
    $scope.formBlock = true;

    $scope.email= {};
    $scope.email.destinos = new Array();
    $scope.email.content = new Array();
    $scope.formMode = null;
    $scope.formAction="new";
    /**/
    var forms ={FormHeadDocument:{isSave:false, isNew:true, isCopy:false},productosDoc:{isSave:false, isNew:true, isCopy:false}};
    FormChange.setForms(forms);



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


    //$scope.openLayer =  LayersCtrl.openLayer;
    //$scope.closeLayer = LayersCtrl.closeLayer;
    //$scope.index = LayersCtrl.index;
    //$scope.layer =LayersCtrl.layer;
    $scope.layers=LayersCtrl;
    $scope.demo=Layers;


    //$scope.layers=LayersCtrl.get();
    $scope.setProvedor = setProvedor;
    $scope.DtPedido = DtPedido;
    $scope.selecOdc = selecOdc;
    $scope.selecContraP = selecContraP;
    $scope.selecPedidoSust = selecPedidoSust;
    $scope.selecKitchenBox = selecKitchenBox;
    console.log($scope.layers);
    init();

    //$filter("customFind")($scope.valcroName,$scope.valName.name,function(current,compare){return current.name==compare})
    function init() {
        /*    $http({
         method: 'POST',
         url: 'Order/OrderFilterData'
         }).then(function successCallback(response) {
         $scope.filterData.monedas = response.data.monedas;
         $scope.filterData.tipoEnv = response.data.tipoEnvio;
         }, function errorCallback(response) {
         console.log("errorrr");
         });*/

        $http.get("Order/OrderProvList").success(function (response) {$scope.todos = response;});
        $http.get("master/getCountriesProvider").success(function (response) {$scope.filterData.paises = response;});
        loadDataFor();
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
        FormChange.addTrace(aux,"FormHeadDocument");

    }
    /********************************************EVENTOS ********************************************/


    $scope.hoverpedido= function(document){
        document.isNew=false;

        $timeout(function(){
            if(document &&  $scope.mouseProview){
                console.log(document);
                $scope.formMode=$scope.forModeAvilable.getXValue(document.tipo_value);
                $scope.document=document;
                if($scope.layers.layer !='resumenPedido' ){
                    LayersCtrl.openLayer("resumenPedido");
                    $scope.formAction="upd";

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
            if($scope.preview && $scope.layers.layer== 'resumenPedido' && !$scope.mouseProview){
                LayersCtrl.closeLayer();
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

    }

    $scope.closeTo = function(layer){
        LayersCtrl.closeLayer(layer);
    }

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
        LayersCtrl.closeLayer("all");
        LayersCtrl.openLayer("menuAgr");
    }

    $scope.openEmail= function(){
        LayersCtrl.openLayer("email");
        $http.get("Email/ProviderEmails").success(function (response) { $scope.email.contactos = response});
    }

    $scope.newDoc= function(formMode){

        // openLayer("finalDoc");
        $scope.formMode=formMode;
        restore("document");
        if($scope.provSelec.id){
            //$scope.document.prov_id=$scope.provSelec.id;
        }
        LayersCtrl.openLayer("detalleDoc");
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
        LayersCtrl.openLayer("resumenodc");

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
        LayersCtrl.openLayer("resumenContraPedido");
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
        LayersCtrl.openLayer("resumenKitchenbox");
    }

    /** al pulsar la flecha siguiente**/
    $scope.next = function () {
        switch($scope.layers.layer){
            case "resumenPedido":
                LayersCtrl.openLayer("detalleDoc");
                //loadPedidos($scope.document.id);
                break;
            case "detalleDoc":
                LayersCtrl.openLayer("listProducProv");break;
            case "listProducProv":
                LayersCtrl.openLayer("agrPed");
                break;
            case "agrPed":
                LayersCtrl.openLayer("finalDoc");break;
            case "finalDoc":
                saveDoc();
                break;
        }
        $scope.showNext(false);
    }

    $scope.showNext = function (status) {
        if (status) {
            if (!$scope.FormHeadDocument.$valid && $scope.layer== 'detalleDoc') {
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

        if($scope.demo.index == 0){
            $scope.provSelec = prov;
            console.log(prov);
            Layers.accion({open:{name:"listPedido",after:function(){alert("text");}}});
        }else{
            if($scope.layers.layer == "listPedido" ){
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
        if(doc && $scope.layers.index <2){
            if (segurity('editPedido')) {
                document.isNew=false;
                $scope.document=aux;
                $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
                $scope.preview=false;
                $scope.formAction="upd";
                LayersCtrl.openLayer('resumenPedido');
                // loadDoc(pedido.id);
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
                FormChange.addChange({id:"pais_id",value:newVal,text:"Pais"},$scope.formAction,"FormHeadDocument");
            }
        }
    });
    $scope.$watch('document.direccion_almacen_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                FormChange.addChange({id:"direccion_almacen_id",value:newVal,text:"Almacen"},$scope.formAction,"FormHeadDocument");
            }
            $http.get("Order/AdrressPorts",{params:{id:newVal}})
                .success(function(response){$scope.formData.puertos=response;});
        }
    });

    $scope.$watch('document.prov_moneda_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                FormChange.addChange({id:"prov_moneda_id",value:newVal,text:"Moneda"},$scope.formAction,"FormHeadDocument");
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
                FormChange.addChange({id:"prov_id",value:newVal,text:"Proveedor"},$scope.formAction,"FormHeadDocument");
            }
        }
    });
    //para los select
    $scope.$watch("document.tipo_id", function (newVal){
        if (newVal != '' && typeof(newVal) !== 'undefined' && newVal && $scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine) {
            if($scope.FormHeadDocument.$valid && !$scope.FormHeadDocument.$pristine){
                FormChange.addChange({id:"tipo_id",value:newVal,text:"Tipo"},$scope.formAction,"FormHeadDocument");
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
    $scope.$watchGroup(['demo.index','demo.layer'], function(newVal){
        console.log('new value', newVal[0]);
        switch (newVal[0]){
            case 0:
                restore('provSelec');// inializa el proveedor
                restore('document');// inializa el pedido
                //  restore('FormData');// inializa el proveedor
                loadDataFor();
                $scope.formAction="new";


                $scope.gridView=4;
                break;
            default:
                console.log('changes',FormChange.getChanges());
                $scope.FormHeadDocument.$setUntouched();
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
                if(layer == "agrPedPend" ){
                    loadPedidosASustituir($scope.provSelec.id);
                }
                if(layer == "listProducProv" ){
                    $http.get("Order/ProviderProds",{params:{id:$scope.provSelec.id}}).success(function (response) {
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
        if($scope.layers.layer == "finalDoc"){
            $scope.document.close=true;
        }
        if($scope.layers.layer == "finalDoc"){
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
                        if($scope.layers.layer == "finalDoc"){
                            $scope.formBlock=true;
                            setNotif.addNotif("ok","Realizado",[{name:"ok",action:function(){LayersCtrl.closeLayer($scope.layers.index );}}],{autohidden:autohidden});
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
        $http.get("Order/OrderDataForm").success(function (response) {
            $scope.formData.motivoPedido=response.motivoPedido;
            $scope.formData.tipo= response.tipoPedido;
            $scope.filterData.tipoPedidos=response.tipoPedido;
            $scope.formData.prioridadPedido=response.prioridadPedido;
            $scope.formData.condicionPedido=response.condicionPedido;
            $scope.formData.estadoPedido=response.estadoPedido;
            $scope.formData.tipoDepago= response.tipoDepago;

        });
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


MyApp.service('FormChange', function() {
    var trace = {};
    var changes ={};
    var forms ={};
    var formAction= "new";

    this.setForms =function(data){
        forms= data;
        angular.forEach(data, function (v, k) {
            trace[k]={};
            changes[k]={};
        });
    };

    this.addTrace = function(val,form){
        console.log("focus");
        if(trace[form][parseInt(val.id)] === undefined){
            trace[form][parseInt(val.id)] = angular.copy(val);
        }
    }

    this.addChange = function(val,action,form){

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
    this.getChanges= function(){
        return changes;
    }
    this.setformAction= function(action){
        formAction=action;
    };
});
/*

MyApp.service('LayersCtrl', function($mdSidenav){
    this.historia= [30];
    this.layer="";
    this.index=0;
    this.blockBack=false;
    this.openLayer= function(name){
        console.log("abriendo");
        if (this.historia.indexOf(name) == -1) {
            console.log("abriendo entro");
            var l = angular.element(document).find("#" + name);
            var base = 264;
            this.index++;
            var w = base + (24 * this.index);
            l.css('width', 'calc(100% - ' + w + 'px)');
            $mdSidenav(name).open();
            l.css('z-index', String(60  + this.index));
            this.historia[this.index] = name;
            this.layer = name;
            return true;
        }
        return false;
    };

    this.closeLayer= function(opt){
        if(this.index>0 && !this.blockBack){
            this.blockBack=true;
            var close =1;
            var current= this.index;
            if(typeof (opt) == 'string'){
                switch (opt){
                    case 'all':break;{
                        close = this.historia.length -1;
                    }

                    default:
                        var aux = this.historia.indexOf(opt);
                        if(aux!= -1){
                            close= current - aux;
                        }else{
                            console.log("no esta abierto", opt);
                            close=0;
                        }
                }


            }else if(typeof (opt) == 'number'){
                close= opt;
            }

            for(var i=0; i<close;i++){
                var l = this.historia[current];
                $mdSidenav(l).close();
                this.historia[current]=null;
                current--;
            }
            this.index= current;
            this.layer = this.historia[this.index];
            this.blockBack=false;
        }
    };

    this.clearLayer= function(){
        this.historia= new Array();
        this. layer="";
        this.index=0;
        this.blockBack=false;
    };
    this.get = function(){
        this.clearLayer();
        return this;
    }


});
*/

MyApp.service('Layers', function($mdSidenav){



});

MyApp.controller("LayersCtrl",function($mdSidenav){});

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

/**
 this.historia= [30];
 this.layer="";
 this.index=0;
 this.blockBack=false;
 this.layers= new Array();
 this.accion = function(arg){
        if(arg.open){
            this.openLayer(arg.open);
        }
        if(arg.layers){
            this.layers=arg.layer;
        }
    }
 this.openLayer= function(arg){
        console.log("abriendo");
        var paso= true;
        if (this.historia.indexOf(arg.name) == -1) {
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
                   this.index++;
                   var w = base + (24 * this.index);
                   l.css('width', 'calc(100% - ' + w + 'px)');
                   l.css('z-index', String(60  + this.index));
               } else{
                   l.css('width', 'calc(100% - ' + arg.width + 'px)');
               }
                $mdSidenav(arg.name).open().then(function(){
                    if(arg.after){
                        arg.after();
                    }
                });
                this.historia[this.index] = arg.name;
                this.layer = arg.name;
                return true;
            }

        }
        return false;
    };

 this.closeLayer= function(opt){
        if(this.index>0 && !this.blockBack){
            this.blockBack=true;
            var close =1;
            var current= this.index;
            if(typeof (opt) == 'string'){
                switch (opt){
                    case 'all':break;{
                        close = this.historia.length -1;
                    }

                    default:
                        var aux = this.historia.indexOf(opt);
                        if(aux!= -1){
                            close= current - aux;
                        }else{
                            console.log("no esta abierto", opt);
                            close=0;
                        }
                }


            }else if(typeof (opt) == 'number'){
                close= opt;
            }

            for(var i=0; i<close;i++){
                var l = this.historia[current];
                $mdSidenav(l).close();
                this.historia[current]=null;
                current--;
            }
            this.index= current;
            this.layer = this.historia[this.index];
            this.blockBack=false;
        }
    };

 this.clearLayer= function(){
        this.historia= new Array();
        this. layer="";
        this.index=0;
        this.blockBack=false;
    };
 this.get = function(){
        this.clearLayer();
        return this;
    }    this.historia= [30];
 this.layer="";
 this.index=0;
 this.blockBack=false;
 this.layers= new Array();
 this.accion = function(arg){
        if(arg.open){
            this.openLayer(arg.open);
        }
        if(arg.layers){
            this.layers=arg.layer;
        }
    }
 this.openLayer= function(arg){
        console.log("abriendo");
        var paso= true;
        if (this.historia.indexOf(arg.name) == -1) {
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
                   this.index++;
                   var w = base + (24 * this.index);
                   l.css('width', 'calc(100% - ' + w + 'px)');
                   l.css('z-index', String(60  + this.index));
               } else{
                   l.css('width', 'calc(100% - ' + arg.width + 'px)');
               }
                $mdSidenav(arg.name).open().then(function(){
                    if(arg.after){
                        arg.after();
                    }
                });
                this.historia[this.index] = arg.name;
                this.layer = arg.name;
                return true;
            }

        }
        return false;
    };

 this.closeLayer= function(opt){
        if(this.index>0 && !this.blockBack){
            this.blockBack=true;
            var close =1;
            var current= this.index;
            if(typeof (opt) == 'string'){
                switch (opt){
                    case 'all':break;{
                        close = this.historia.length -1;
                    }

                    default:
                        var aux = this.historia.indexOf(opt);
                        if(aux!= -1){
                            close= current - aux;
                        }else{
                            console.log("no esta abierto", opt);
                            close=0;
                        }
                }


            }else if(typeof (opt) == 'number'){
                close= opt;
            }

            for(var i=0; i<close;i++){
                var l = this.historia[current];
                $mdSidenav(l).close();
                this.historia[current]=null;
                current--;
            }
            this.index= current;
            this.layer = this.historia[this.index];
            this.blockBack=false;
        }
    };

 this.clearLayer= function(){
        this.historia= new Array();
        this. layer="";
        this.index=0;
        this.blockBack=false;
    };
 this.get = function(){
        this.clearLayer();
        return this;
    }
 **/