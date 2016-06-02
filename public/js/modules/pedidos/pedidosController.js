MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav,$timeout ,$filter,ORDER, setNotif, DateParse) {

    var historia = [15];
    var autohidden= 2000;

    // controlers
    $scope.formBlock = true;
    $scope.index = 0;
    $scope.layer = '';
    $scope.email= {};
    $scope.email.destinos = new Array();
    $scope.email.content = new Array();
    // filtros
    $scope.fRazSocial="";
    $scope.fPais="";
    $scope.fpaisSelec="";
     $scope.email.contactos = new Array();
    $scope.emailToText = null;



    //gui
    $scope.showGripro=false;
    $scope.showFilterPed=false;
    $scope.showLateralFilter=false;
    $scope.showLateralFilterCpl=false;
    $scope.imgLateralFilter="images/Down.png";
    $scope.selecPed=false;
    $scope.preview=true;
    $scope.mode = null;





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
    $scope.openLayer = openLayer;
    $scope.closeLayer = closeLayer;
    $scope.DtPedido = DtPedido;
    $scope.selecOdc = selecOdc;
    $scope.selecContraP = selecContraP;
    $scope.selecPedidoSust = selecPedidoSust;
    $scope.selecKitchenBox = selecKitchenBox;
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


    /********************************************EVENTOS ********************************************/


    $scope.hoverpedido= function(document){

        if(document && /*!$scope.selecPed &&*/ $scope.preview){
            $scope.document=document;
            if($scope.layer !='resumenPedido' ){
                openLayer("resumenPedido");
            }
        }
    }

    $scope.hoverLeave= function(){

        $timeout(function(){
            if($scope.preview && $scope.layer== 'resumenPedido'){
                $scope.closeLayer();
                $scope.hoverPreview(true);
            }
        }, 20);
    }
    $scope.hoverPreview= function(val){
        $scope.preview=val;
        console.log('preview ', val);
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
        console.log('close to',layer);
        closeLayer(layer);
    }

    /********************************************DEBUGGIN ********************************************/

    $scope.test = function (test) {
        alert(test);
    }
    $scope.simulateClick = function (id) {
        var a = angular.element(document).find(id);
        console.log('click ', a);
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
        closeLayer("all");
        openLayer("menuAgr");
    }

    $scope.openEmail= function(){
        openLayer("email");
         $http.get("Email/ProviderEmails").success(function (response) { $scope.email.contactos = response});
    }

    $scope.newDoc= function(mode){
        $scope.mode=mode;
        restore("document");
        if($scope.provSelec.id){
            //$scope.document.prov_id=$scope.provSelec.id;
        }
        openLayer("detallePedido");
        $scope.formBlock=false;
    }

    /*************** conversores **********/

    $scope.transformChip = function(chip) {

        console.log('hola', chip);
        if (angular.isObject(chip)) {
            console.log('es objeto', chip);
            return chip;
        }
        console.log('es texto', chip);

        return { email: chip}
    }
    function selecOdc(odc) {
        restore('odcSelec');
        loadOdc(odc.id);
        openLayer("resumenodc");

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
                console.log('contra P',response);

                if(response.fecha_aprox_entrega != null){
                    $scope.contraPedSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
                }
                if(response.fecha != null){
                    $scope.contraPedSelec.fecha = new Date(Date.parse(response.fecha));

                }

            });

        $scope.formDataContraP.contraPedidoMotivo = ORDER.query({type: 'CustomOrderReason'});
        $scope.formDataContraP.contraPedidoPrioridad = ORDER.query({type: 'CustomOrderPriority'});
        openLayer("resumenContraPedido");
    }

    function selecPedidoSust(item) {
        restore('pedidoSusPedSelec');
        $http.get("Order/OrderSubstitute", {params: {id: item.id, pedido_id: $scope.document.id}})
            .success(function (response) {
                $scope.pedidoSusPedSelec = response;
            });
        openLayer("resumenPedido");
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
        openLayer("resumenKitchenbox");
    }

    /** al pulsar la flecha siguiente**/
    $scope.next = function () {
        switch($scope.layer){
            case "resumenPedido":
                openLayer("detallePedido");
                break;
            case "detallePedido":
                openLayer("agrPed");
                break;
            case "agrPed":
                console.log('open',"listProducProv");
                openLayer("listProducProv");
                break;
        }
        $scope.showNext(false);
    }

    $scope.showNext = function (status) {
        console.log('estada', status);
        if (status) {
            if (!$scope.FormdetallePedido.$valid) {
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

            $http.post("Order/AddCustomOrder", { id:item.id, pedido_id:$scope.document.id})
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
        item.pedido_id = $scope.document.id;
        if ($scope.FormResumenContra.$valid) {
            if (item.asignado) {
                var paso=true;
                if(item.renglon_id == null && item.saldo >item.cantidad){
                    setNotif.addNotif("ok","el monto excede la cantidad por defecto",[],{autohidden:autohidden});
                }
                if(paso){
                    $http.post("Order/AddCustomOrderItem", item)
                        .success(function (response) {
                            if (item.renglon_id == null) {
                                setNotif.addNotif("info","Asignado",[],{autohidden:autohidden});

                            }
                            item.renglon_id = response.id;
                        });
                }
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
        }

    }


    $scope.changeKitchenBox = function (item) {
        if (item.asignado) {
            $http.post("Order/AddkitchenBox", { id:item.id, pedido_id:$scope.document.id})
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
                                    loadPedido($scope.document.id);
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
        $scope.provSelec = prov;
        openLayer('listPedido');
    }

    function openLayer(layer) {

        if (historia.indexOf(layer) == -1) {
            var l = angular.element(document).find("#" + layer);
            var base = 264;
            $scope.index++;
            var w = base + (24 * $scope.index);
            console.log('width ', w);
            l.css('width', 'calc(100% - ' + w + 'px)');

            $mdSidenav(layer).open();
            l.css('z-index', String(60  + $scope.index));
            historia[$scope.index] = layer;
            $scope.layer = layer;
            return true;
        }
        return false;
    }

    function DtPedido(pedido) {

        if(pedido && $scope.index <2){
            if (segurity('editPedido')) {
                openLayer('resumenPedido');
                loadPedido(pedido.id);
            }
            else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        }
    }

    function closeLayer(opt) {
        if($scope.index>0){
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


            }

            for(var i=0; i<close;i++){
                var layer = historia[index];
                $mdSidenav(layer).close();
                historia[index]=null;
                index--;
            }
            $scope.index= index;
            $scope.layer = historia[index];
        }

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
            closeLayer();
        }
    }

    /****** **************************listener ***************************************/

    $scope.$watch('document.pais_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            loadDirProvider(newVal);
        }
    });

    $scope.$watchGroup(['index','layer'], function(newVal){
        console.log('listener', newVal);
        switch (newVal[0]){
            case 0:
                restore('provSelec');// inializa el proveedor
                restore('document');// inializa el proveedor
                //  restore('FormData');// inializa el proveedor
                loadDataFor();
                break;
        }
        if (newVal[1] != '' && typeof(newVal[1]) !== 'undefined') {
            switch (newVal[1]) {
                case 'listPedido':
                    if ($scope.provSelec.id != '') {
                        loadPedidosProvedor($scope.provSelec.id);
                    }
                    break;
                case 'agrContPed':
                    loadContraPedidosProveedor($scope.provSelec.id);
                    break;
                case 'agrKitBoxs':
                    loadkitchenBoxProveedor($scope.provSelec.id);
                    break;
                case 'agrPedPend':
                    loadPedidosASustituir($scope.provSelec.id);
                    break;
                case 'agrPed':
                    loadPedido($scope.document.id);
                    break;
                default :
                    ;
            }
        }
    });
    $scope.$watch('provSelec.id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            loadCoinProvider(newVal);
            loadCountryProvider(newVal);
            loadPaymentCondProvider(newVal);
        }
    });

    $scope.$watch('document.prov_moneda_id', function (newVal) {
        if (newVal != '' && typeof(newVal) !== 'undefined') {
            loadTasa(newVal);
        }
    });

    $scope.$watchGroup(['FormdetallePedido.$valid', 'FormdetallePedido.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {

            saveDoc();
        }

    });

    /*************************Guardados*************************************************/

    function saveDoc() {


        if ($scope.document.id == '') {
            delete $scope.document.id;
        }

        $scope.document.prov_id = $scope.provSelec.id;
        setNotif.addNotif("ok"," Puede continuar",[],{autohidden:2000});
/*
        $http.post("Order/Save",  $scope.document)
            .success(function (response) {
                $scope.FormdetallePedido.$setPristine();
                if (response.success && response.action== 'new') {
                    $scope.document.id = response.pedido.id;
                    setNotif.addNotif("info",
                        "Creado, Puede continuar"
                        ,[
                            {name: 'Ok',
                                action:function(){}
                            }
                        ],{autohidden:2000});
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

    }
    function loadPedido(id){
        restore("document");
        $http.get("Order/Order",{params:{id:id}}).success(function (response) {

            $scope.document = response;
            $scope.document.emision=DateParse.toDate(response.emision);
        });
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


    function loadDirProvider(id){
        $http.get("Order/Address",{params:{id:id}}).success(function (response) {
            $scope.formData.direcciones=response;
           // $scope.document.direccion_almacen_id= response[0].id;
        });
    }

    function loadTasa(id){
        $http.get("master/getCoin/"+id).success(function (response) {
            $scope.document.tasa=response.precio_usd;
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
                console.log('v ', v);
                console.log('k ', k);
                v.emision= DateParse.toDate(v.emision);
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
        $http.get("Order/CustomOrders",{params:{prov_id:id, pedido_id: $scope.document.id}}).success(function (response) {
            $scope.formData.contraPedido= response;
        });
    }

    function loadkitchenBoxProveedor(id){

        $http.get("Order/KitchenBoxs",{params:{prov_id:id, pedido_id: $scope.document.id}}).success(function (response) {
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
            loadPedido($scope.document.id);
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
            loadPedido($scope.document.id);
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
                    prov_moneda_id:'', tasa:'0', emision:new Date()};
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
                    estadoPedido:new Array(), pedidoSust: new Array(),
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

