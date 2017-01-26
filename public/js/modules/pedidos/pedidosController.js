
MyApp.controller('PedidosCtrll',['$scope','$mdSidenav', '$timeout','$interval','$filter','Order','setGetOrder','DateParse','ExtRedirect','lmbCountRequest','App',function ($scope,$mdSidenav,$timeout,$interval,$filter, Order, setGetOrder, DateParse , ExtRedirect, lmbCountRequest, App) {
    $scope.permit= Order.get({type:"Permision"});
    // controlers
    $scope.Docsession = {isCopyable:false,global:"new", block:true};
    $scope.formMode ={};
    $scope.layer= undefined;
    $scope.index= 0;
    $scope.forModeAvilable={
        Correo: {
            name: "Correo",
            value:20,
            mod:"None"

        }, solicitud: {
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

    $scope.showFilterPed=false;
    $scope.showLateralFilter=false;
    $scope.showLateralFilterCpl=false;
    $scope.imgLateralFilter="images/Down.png";

    $scope.preview=true;
    $scope.provSelec ={};
    $scope.document  = setGetOrder.getOrder();
    $scope.docBind= setGetOrder.bind();
    $scope.todos =[];
    Order.query({type:"OrderProvList"},{},function(response){
        $scope.todos = response;

        $timeout(function () {
            var data =angular.copy( ExtRedirect.get());
            if(data){
                $scope.NotifAction("alert", "Se ha abierto el modulo desde un vinculo externo , ¿Desea ver el documento asociado?",
                    [
                        {name:"Ver Documento", action:function () {
                            data.tipo = parseInt(data.tipo);
                            ExtRedirect.del();
                            $scope.OrderDetalleCtrl(data);
                        }}, {name:"Cancelar", action:function () {

                    }},
                        {name:"Cancelar y no volver a preguntar", action:function () {
                            ExtRedirect.del();
                        }}
                    ]
                    ,{block:true});
            }
        }, 100);

    });

    // filtros para las grillas de documentos
    $scope.filterDocuments = function (data, obj){

        if(data){


            if(data.length > 0 && obj){
                data = $filter("customFind")(data, obj,function(current,compare){
                    if(compare.id ){
                        if(current.id.toLowerCase().indexOf(compare.id)== -1){
                            return false;
                        }
                    }
                    if(compare.documento && compare.documento != '-1'){
                        if($scope.forModeAvilable.getXname(current.documento).value != compare.documento){
                            return false;
                        }
                    }

                    if(compare.titulo && current.titulo){
                        if( current.titulo.toLowerCase().indexOf(compare.titulo)== -1){
                            return false;
                        }
                    }

                    if(compare.nro_proforma){
                        if(!current.nro_proforma){
                            return false;
                        }
                        if( current.nro_proforma.toLowerCase().indexOf(compare.nro_proforma)== -1){
                            return false;
                        }

                    }
                    if(compare.proveedor){
                        if(!current.proveedor){
                            return false;
                        }
                        if(current.toLowerCase().indexOf(compare.proveedor) == -1){
                            return false;
                        };
                    }
                    if(compare.nro_factura ){
                        if(!current.nro_factura){
                            return false;
                        }
                        if(current.nro_factura.toLowerCase().indexOf(compare.nro_factura) == -1){
                            return false;
                        }

                    }
                    if(compare.emision){
                        var patern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
                        if( patern.test(compare.emision)){
                            var dc=new Date(Date.parse(current.emision));
                            var m;
                            if ((m = patern.exec(compare.emision)) !== null) {
                                var aux, dcp;
                                if(m[0].indexOf('-') != -1){
                                    aux = m[0].split('-');
                                    dcp = new Date(aux[1]+"-"+aux[0]+"-"+aux[2]);
                                    return dc.getDate() == dcp.getDate() &&  dc.getFullYear() == dcp.getFullYear()

                                }else if(m[0].indexOf('/') != -1){
                                    aux = m[0].split('/');
                                    dcp = new Date(aux[1]+"-"+aux[0]+"-"+aux[2]);
                                }
                                if(dc.getDate() != dcp.getDate() || dc.getMonth() != dc.getMonth() || dcp.getFullYear() != dcp.getFullYear()){
                                    return false;
                                }

                            }
                        }else{
                            var date=DateParse.toDate(current.emision);

                            return date.getDay().toString().toLowerCase().indexOf(compare.emision)!= -1
                                || (date.getMonth() + 1).toString().toLowerCase().indexOf(compare.emision)!= -1
                                || ("0"+(date.getMonth() + 1).toString().toLowerCase()).indexOf(compare.emision)!= -1
                                || ("0"+(date.getDate() ).toString().toLowerCase()).indexOf(compare.emision)!= -1
                                || date.getDate().toString().toLowerCase().indexOf(compare.emision)!= -1
                                || date.getFullYear().toString().toLowerCase().indexOf(compare.emision)!= -1
                                || date.toString().toLowerCase().indexOf(compare.emision)!= -1;
                        }
                    }

                    if(compare.diasEmit && compare.diasEmit != '-1'){
                        if( current.diasEmit != compare.diasEmit){
                            return false;
                        }
                    }
                    if(compare.monto){
                        if(!current.monto){
                            return false;
                        }
                        if(current.monto.toString().toLowerCase().indexOf(compare.monto) == -1){
                            return false;
                        }

                    }
                    if(compare.comentario){
                        if(!current.comentario){
                            return false;
                        }
                        if(current.comentario.toLowerCase().indexOf(compare.comentario) == -1){

                            return false;
                        }

                    }

                    return true;
                });

            }
        }
        return data;
    };

    // recarga el documento
    $scope.reloadDoc = function () {
        if(setGetOrder.getInternalState() != 'new' && setGetOrder.getState() != 'reload'){
            setGetOrder.reload();
            setGetOrder.setState('reload');
        }
    };

    // limpiaa el modulo
    $scope.clearForHead = function (){
        $scope.provSelec ={};
        $scope.ctrl = {};
        $scope.ctrl.pais_id= null;
        $scope.ctrl.searchPais=undefined ;
        $scope.ctrl.direccion_facturacion_id= null;
        $scope.ctrl.searchdirFact= undefined;
        $scope.ctrl.direccion_almacen_id= null;
        $scope.ctrl.searchdirAlmacenSelec= undefined;
        $scope.ctrl.prov_moneda_id= null;
        $scope.ctrl.searchMonedaSelec= undefined;
        $scope.ctrl.condicion_pago_id= null;
        $scope.ctrl.searchcondPagoSelec= undefined;
    };


    /********************************************GUI ********************************************/
// muestra los datos de los dot de lista de proveedores
    $scope.showDotData= function(item,emit,review, dias){
        if(emit && review){
            item.emit= angular.copy(emit);
            item.review= angular.copy(review);
            item.show = true;
            item.dias=dias;
            if(dias== 0){
                item.text = " hoy ";
            }else{
                item.text = " hace " + dias+" dias ";
            }
        }else{
            item.show = false;
        }

    };
    // muestra el filtro de proveedores
    $scope.FilterLateral = function(){
        if(!$scope.showLateralFilter){
            jQuery("#menu").animate({height:"258px"},500);
            $scope.showLateralFilter=true;
        }
    };
    // amplia  el filtro de proveedores
    $scope.FilterLateralMas = function(){
        if(!$scope.showLateralFilterCpl){
            var ele= jQuery("#barraLateral");
            var newHeight =ele.height() - (176);
            if(newHeight >= 176){
                jQuery("#menu").animate({height:newHeight},400);
            }else{
                jQuery("#menu").animate({height:"100%"},400);
            }


            $scope.showLateralFilterCpl=true;
            $scope.imgLateralFilter="images/Down.png";
        }else {
            jQuery("#menu").animate({height:"48px"},400);
            $scope.showLateralFilter=false;
            $scope.showLateralFilterCpl=false;


        }
    };

    // verifiaca la salida del layers
    $scope.verificExit = function(){
        var model = $scope.buildfinalDoc();
        if(!(Object.keys(model.document).length == 0 &&
            Object.keys(model.contra).length == 0 &&
            Object.keys(model.pedidoSusti).length == 0 &&
            Object.keys(model.import).length == 0 &&
            Object.keys(model.todos).length == 0)
        ){
            console.log("llamando norificaciones");
            $scope.NotifAction("alert","¿esta seguro de salir sin culminar?",[
                {
                    name:"No",
                    action: function(){
                    }
                },
                {
                    name:"Si",
                    action: function(){
                        $scope.LayersAction({close:{first:true, search:true}});

                    }
                }

            ],{block:true});
            return false;
        }
        return true;

    };

    /********************************************EVENTOS ********************************************/
    $scope.allowEdit = function(){


        if($scope.Docsession.block){
            if(!$scope.document.permit.update){
                $scope.NotifAction("error","No tiene para realizar esa accion ",[],{autohidden:2500});
                return false;
            }else{
                $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder modificar",[],{autohidden:2500});
                return false;
            }
        }else if($scope.document.isAprobado){
            $scope.NotifAction("error","Este documento ya fue aprobado y no se puede modificar",[],{autohidden:3000});
            return false;
        }
        return true;
    };

    /******************************************** filtros ********************************************/

    //proveedores
    $scope.search = function(){
        var data  =[];
        if($scope.todos.length > 0){
            data = $filter("customFind")($scope.todos,$scope.filterProv,
                function(current,compare){
                    var paso = true;
                    current.prioridad = 0;
                    if(compare.razon_social){
                        if(current.razon_social.toLowerCase().indexOf(compare.razon_social.toLowerCase()) != -1){
                            current.prioridad ++;
                        }else{
                            paso = false;
                        }
                    }
                    if(compare.pais){
                        var i= $filter("customFind")(current.paises,compare.pais, function(c,cp){ return c.toLowerCase().indexOf(cp.toLowerCase()) == -1}).length;
                        if(i>0){
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }

                    if(compare.pc == true){
                        if(current.puntoCompra > 0 ){
                            //paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }

                    if(compare.cp == true){
                        if(current.contrapedido > 0 ){
                            paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }

                    if(compare.monto){
                        if(compare.op == '+'){
                            if(parseFloat(current.deuda) < parseFloat(compare.monto)){
                                paso = false;
                            }
                        }
                        if(compare.op == '-'){
                            if(parseFloat(current.deuda) > parseFloat(compare.monto)){
                                paso = false;
                            }
                        }
                    }

                    if(compare.f0 == true){
                        if(current.emit0 > 0  ||  current.review0 > 0){
                            //paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }
                    if(compare.f7 == true){
                        if(current.emit7 > 0  ||  current.review7 > 0){
                            //  paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }
                    if(compare.f30 == true){
                        if(current.emit30 > 0  ||  current.review30 > 0){
                            //  paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }
                    if(compare.f60 == true){
                        if(current.emit60 > 0  ||  current.review60 > 0){
                            //  paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }
                    if(compare.f90 == true){
                        if(current.emit90 > 0  ||  current.review90 > 0){
                            //  paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }if(compare.f100 == true){
                        if(current.emit100 > 0  ||  current.review100 > 0){
                            //  paso = true;
                            current.prioridad ++;
                        }else {
                            paso = false;
                        }
                    }
                    return paso;

                });
        }
        return  data;
        //  return data;
    };

    // productos del documentos
    $scope.filterProdDoc = function(data, obj){

        if(data){
            if(data.length > 0 && obj){
                data = $filter("customFind")(data,obj, function(current, compare){
                    if(compare.cod_producto){
                        if(current.cod_producto.toString().indexOf(compare.cod_producto) == -1){
                            return false;
                        }
                    }
                    if(compare.descripcion && current.descripcion){
                        if(current.descripcion.toLowerCase().indexOf(compare.descripcion) == -1){
                            return false;
                        }
                    }
                    if(compare.documento && current.documento){
                        if(current.documento.toLowerCase().indexOf(compare.documento) == -1){
                            return false;
                        }
                    }
                    if(compare.saldo){
                        if(current.saldo.toString().indexOf(compare.saldo) == -1){
                            return false;
                        }
                    }

                    return true;
                });
            }
        }

        return data;
    };

    //productos del proveedor
    $scope.filterProd = function(data,obj){
        if(data){
            if(data.length > 0 && obj){
                data  = $filter("customFind")(data, obj,function(current,compare){
                    if(compare.codigo){
                        if(current.codigo.toString().toLowerCase().indexOf(compare.codigo) == -1){
                            return false;
                        }
                    }
                    if(compare.codigo_fabrica){
                        if(!current.codigo_fabrica){
                            return false;
                        }
                        if(current.codigo_fabrica.toString().toLowerCase().indexOf(compare.codigo_fabrica) == -1){
                            return false;
                        }
                    }

                    if(compare.descripcion){
                        if(!current.descripcion){
                            return false;
                        }
                        if(current.descripcion.toString().toLowerCase().indexOf(compare.descripcion) == -1){
                            return false;
                        }
                    }
                    if(compare.saldo){
                        if(current.saldo.toString().toLowerCase().indexOf(compare.saldo) == -1){
                            return false;
                        }
                    }

                    return true;


                });
            }
        }
        return data;
    };
    // filtra la grilla dwe contrapedidos
    $scope.filterContraPed = function(data, obj){
        if(data){
            if(data.length > 0 && obj){
                data  = $filter("customFind")(data, obj,function(current,compare){
                    if(compare.id){
                        if(current.id.toString().toLowerCase().indexOf((compare.id)) == -1){
                            return false;
                        }
                    }

                    if(compare.fecha){
                        if($scope.EqualsDate(current.fecha,compare.fecha)){
                            return true;
                        }else{
                            var date=DateParse.toDate(current.fecha);


                            if( date.getDay().toString().toLowerCase().indexOf(compare.fecha)== -1
                                && (date.getMonth() + 1).toString().toLowerCase().indexOf(compare.fecha) == -1
                                && ("0"+(date.getMonth() + 1).toString().toLowerCase()).indexOf(compare.fecha) == -1
                                && ("0"+(date.getDate() ).toString().toLowerCase()).indexOf(compare.fecha) == -1
                                && date.getDate().toString().toLowerCase().indexOf(compare.fecha) == -1
                                && date.getFullYear().toString().toLowerCase().indexOf(compare.fecha) == -1
                                && date.toString().toLowerCase().indexOf(compare.fecha) == -1){
                                return false;
                            }
                        }
                    }
                    if(compare.titulo){
                        if(!current.titulo){
                            return  false;
                        }
                        if(current.titulo.toLowerCase().indexOf((compare.titulo)) == -1){
                            return false;
                        }
                    }


                    if(compare.fecha_aprox_entrega){
                        if(!current.fecha_aprox_entrega){
                            return false;
                        }
                        if($scope.EqualsDate(current.fecha_aprox_entrega,compare.fecha_aprox_entrega)){
                            return true;
                        }else{
                            var date=DateParse.toDate(current.fecha_aprox_entrega);


                            if( date.getDay().toString().toLowerCase().indexOf(compare.fecha_aprox_entrega)== -1
                                && (date.getMonth() + 1).toString().toLowerCase().indexOf(compare.fecha_aprox_entrega) == -1
                                && ("0"+(date.getMonth() + 1).toString().toLowerCase()).indexOf(compare.fecha_aprox_entrega) == -1
                                && ("0"+(date.getDate() ).toString().toLowerCase()).indexOf(compare.fecha_aprox_entrega) == -1
                                && date.getDate().toString().toLowerCase().indexOf(compare.fecha_aprox_entrega) == -1
                                && date.getFullYear().toString().toLowerCase().indexOf(compare.fecha_aprox_entrega) == -1
                                && date.toString().toLowerCase().indexOf(compare.fecha_aprox_entrega) == -1){
                                return false;
                            }
                        }
                    }

                    if(compare.monto){
                        if(!current.monto){
                            return false;
                        }
                        if(current.monto.toString().toLowerCase().indexOf((compare.monto)) == -1){
                            return false;
                        }
                    }
                    if(compare.comentario){
                        if(!current.comentario){
                            return  false;
                        }
                        if(current.comentario.toLowerCase().indexOf((compare.comentario)) == -1){
                            return false;
                        }
                    }
                    return true;
                });

            }
        }
        return data;
    };
    //convierte el texto en images del select
    $scope.transforDocToImg = function(doc){
        var mode = $scope.forModeAvilable.getXname(doc);
        if(mode){
            switch(mode.value){
                case 21:return "images/solicitud_icon_48x48.gif";
                case 22:return "images/proforma_icon_48x48.gif";
                case 23:return "images/odc_icon_48x48.gif";
                default: return "";
            }
        }
    };
    //llama al siguiente layer
    $scope.next = function (data) {
        data();
        $scope.showNext();
    };

    // muestra la flecha next
    $scope.showNext = function (status) {
        if (status) {
            $mdSidenav("NEXT").open();
        } else {
            $mdSidenav("NEXT").close()
        }

    };
    // funcion de cierre
    $scope.closeSide = function(){

        var paso= true;
        if($scope.layer == 'resumenPedido'  && setGetOrder.getInternalState() != 'new'){
            paso = false;
        }

        if($scope.layer == 'detalleDoc'){
            paso = false;
        }

        if(!paso){
            paso = $scope.verificExit();
            if(paso){
                $scope.LayersAction({close:{search:true}});
            }
            console.log("in exi  internet", paso);
        }else {
            $scope.LayersAction({close:{search:true}});
        }

    };
    // actualiza el proveedor
    $scope.updateProv= function(calback){
        Order.get({type:"Provider", id: $scope.provSelec.id},{}, function(response){
            console.log("response un update",response);
            $scope.provSelec= response;
            angular.forEach($scope.provSelec,function(v,k){
                $scope.provSelec[k] = response[k];
            });
            if(calback){
                calback();
            }
        });
    };

    /****** **************************listener ***************************************/
// actualiza el documento
    $scope.$watch('docBind.estado', function(newVal){
        if(newVal){
            $scope.document=setGetOrder.getOrder();
            if( $scope.document.prov_id ){
                Order.get({type:"Provider",  id: $scope.document.prov_id},{}, function(response){
                    $scope.ctrl.provSelec=response;
                    $scope.provSelec=response;
                });
            }
        }

    });

    // actuliza module index moduel layer
    $scope.$watchGroup(['module.index','module.layer'], function(newVal, oldVal){
        $scope.layer= newVal[1];
        $scope.index= newVal[0];

        if( newVal[1] == "unclosetDoc" || newVal[1] == "priorityDocs" ){
            $timeout(function(){
                $scope.document ={};
                $scope.provSelec ={};
                $scope.ctrl.searchProveedor= undefined;
                setGetOrder.clear();
                $scope.Docsession.global='new';
                $scope.Docsession.isCopyableable = false;



            },400);

        }
        if(newVal[1] == "listPedido" || newVal[1] == "menuAgr" ){
            $timeout(function(){
                $scope.document ={};
                $scope.document ={};
                $scope.Docsession ={};
                $scope.Docsession.global='new';
                setGetOrder.clear();
                $scope.ctrl.pais_id= null;
                $scope.ctrl.searchPais= undefined;
                $scope.ctrl.direccion_facturacion_id= null;
                $scope.ctrl.searchdirFact= undefined;
                $scope.ctrl.direccion_almacen_id= null;
                $scope.ctrl.searchdirAlmacenSelec= undefined;
                $scope.ctrl.prov_moneda_id= null;
                $scope.ctrl.searchMonedaSelec= undefined;
                $scope.ctrl.condicion_pago_id= null;
                $scope.ctrl.searchcondPagoSelec= undefined;
                $scope.ctrl.puerto_id= null;
                $scope.ctrl.searchPuerto= undefined;
                $scope.Docsession.isCopyableable = false;



            },400);

        }
        if(newVal[0]  == 0 ){

            $timeout(function(){
                if($scope.module.index==0){
                    $scope.getAlerts();
                }
            },400);
            $scope.tempDoc= {};

            $scope.Docsession.isCopyableable = false;
            /*$scope.provSelec ={};
             $scope.ctrl = {};
             $scope.ctrl.pais_id= null;
             $scope.ctrl.searchPais=undefined ;
             $scope.ctrl.direccion_facturacion_id= null;
             $scope.ctrl.searchdirFact= undefined;
             $scope.ctrl.direccion_almacen_id= null;
             $scope.ctrl.searchdirAlmacenSelec= undefined;
             $scope.ctrl.prov_moneda_id= null;
             $scope.ctrl.searchMonedaSelec= undefined;
             $scope.ctrl.condicion_pago_id= null;
             $scope.ctrl.searchcondPagoSelec= undefined;*/
            $scope.clearForHead();
            setGetOrder.clear();

        }

        if(newVal[0] == 0 || newVal[0] == 1){


            if($scope.layer != "detalleDoc"){
                $scope.gridView= 1;
                $scope.imagenes = [];
                $scope.isTasaFija= true;
                setGetOrder.restore();
                $scope.Docsession.isCopyableable = false;

            }

        }
        if(newVal[1] == "agrPed" || newVal[1] == "newVal" || newVal[1] == "finalDoc" || newVal[1] == "detalleDoc"){
            if($scope.document.id != '' && typeof($scope.document.id) !== 'undefined' && setGetOrder.getState() != 'load'){
                setGetOrder.reload();
                setGetOrder.setState('load');
            }
        }

    });


    $scope.buildfinalDoc = function(){
        var model = {contra:{},kitchen:{},pedidoSusti:{},import:{}, todos:{}, document:{}, fecha_aprob_gerencia:{}, fecha_aprob_compr:{}};
/*
        console.log("$scope.$parent.document", $scope.document);*/
        console.log("setGetOrder.getForm() ", setGetOrder.getForm());
        angular.forEach(setGetOrder.getForm(), function(v,k){
                if(k.startsWith('contra')){
                    model.contra[v.id] = (v.original) ? 'upd' : 'created';
                }
                if(k.startsWith('kitchen')){
                    model.kitchen[v.id] = (v.original) ? 'upd' : 'created';
                }
                if(k.startsWith('pedidoSusti')){
                    model.pedidoSusti[v.id] = (v.original) ? 'upd' : 'created';
                }
                if(k.startsWith('productos')){
                    model.todos[v.id] = (v.original) ? 'upd' : 'created';
                }


            }
        );
        angular.forEach(setGetOrder.getForm('document'), function(v,k){
                if(v.estado  && v.estado  != 'new'){
                    model.document[k]= v;
                    model.document.estado = 'upd';
                }
            }

        );
        angular.forEach(setGetOrder.getForm('fecha_aprob_compra'), function(v,k){
                if(v.estado  && v.estado  != 'new'){
                    model.fecha_aprob_compra[k]= v;
                    model.fecha_aprob_compra.estado = (v.original) ? 'upd' : 'created';
                }
            }

        );
        angular.forEach(setGetOrder.getForm('fecha_aprob_gerencia'), function(v,k){
                if(v.estado  && v.estado  != 'new'){
                    model.fecha_aprob_gerencia[k]= v;
                    model.fecha_aprob_gerencia.estado = (v.original) ? 'upd' : 'created';
                }
            }

        );
       // console.log("final ", model);
        return model;


    };

    /// experimento
    $scope.bindGets = lmbCountRequest;
    var timeBlock ;
    $scope.$watchCollection('bindGets', function (newVal, oldVal) {
        //console.log('bindGets', newVal);
        if(newVal.get > 0){
            if(timeBlock != null){
                $timeout.cancel(timeBlock);
            }
            App.setBlock({block:true, level:  89});
        }
        if(newVal.get == 0) {
            if(timeBlock != null){
                $timeout.cancel(timeBlock);
            }
            timeBlock = $timeout(function () {
                App.setBlock({block:false, level:  0});
            },500);

        }
    })


}]);


MyApp.controller('resumenPedidoCtrl',['$scope','$timeout','DateParse', 'Order', function ($scope, $timeout,DateParse, Order) {



    $scope.$parent.resumenPedidoCtrl = function (document) {
        $scope.$parent.formMode=$scope.$parent.forModeAvilable.getXValue(document.tipo);
        $scope.resumen= document;

        $scope.$parent.notCloseSumary();
        if($scope.$parent.module.layer != 'resumenPedido'){
            $scope.opaque = true;
            $scope.LayersAction({open:{name:"resumenPedido"}});

        }
        return  $scope.opaque;

    };
    $scope.$parent.notCloseSumary = function () {
        if($scope.timeClose){
            $timeout.cancel($scope.timeClose);
            console.log("no closet");
        }
        $scope.timeClose =$timeout(function () {
            if( $scope.opaque && $scope.$parent.module.layer == 'resumenPedido'){
                $scope.close();
            }
        }, 3000);
    }
    $scope.close = function () {
        $scope.LayersAction({close:true});
    };
    $scope.next = function () {

    };
    $scope.canNext = function () {

        return true;
    };


}]);

MyApp.controller('OrderResumenOldDocCtrl',['$scope','$timeout','DateParse', 'Order', function ($scope, $timeout,DateParse, Order) {

    $scope.$parent.OrderResumenOldDocCtrl = function (data) {
        $scope.model = {};
        Order.get({type:"Document", id:data.id,tipo: data.tipo}, {},function(response) {
            response.emision= DateParse.toDate(response.emision);
            $scope.model = response;
        });
        $scope.LayersAction({open:{name:"OrderResumenOldDoc"}});

        $scope.$watch('$parent.module.layer', function (newVal, oldVal) {

            if(oldVal == 'OrderResumenOldDoc'){
                $scope.model = {};
            }
        });
    }
}]);

MyApp.controller('OrderOldDocsCtrl',['$scope','$timeout', 'DateParse','Order','setGetOrder','form' ,function ($scope,$timeout, DateParse, Order,setGetOrder, formSrv) {

    $scope.tbl = {
        data:[],
        order:'id'
    };
    $scope.load = function () {
        Order.queryMod({type:$scope.formMode.mod,mod:"Versions", id:$scope.document.id},{}, function(response){
            angular.forEach(response, function(v){
                v.emision= DateParse.toDate(v.emision);
                $scope.tbl.data.push(v);
            });
        });
    };
    $scope.$parent.OrderOldDocsCtrl = function () {
        $scope.tbl.data.splice(0, $scope.tbl.data.length);

        $scope.LayersAction({open:{name:"OrderOldDocs",
            before: function(){
                $timeout(function () {
                    $scope.load();
                }, 400);
            }}});
    };
    $scope.openVersions  = function (){
        $scope.LayersAction({open:{name:"OrderOldDocs",
            before: function(){
                Order.queryMod({type:$scope.formMode.mod,mod:"Versions", id:$scope.document.id},{}, function(response){
                    if(!$scope.oldDocs){
                        $scope.oldDocs =[];
                    }
                    $scope.oldDocs.splice(0, $scope.oldDocs.length);
                    angular.forEach(response, function(v){
                        v.emision= DateParse.toDate(v.emision);
                        $scope.oldDocs.push(v);
                    });
                });
            }, after: function(){
            }
        }});
    };

    $scope.open= function (item) {
        $scope.$parent.OrderResumenOldDocCtrl(item);
    };

    $scope.back = function (data) {
        Order.postMod({type:$scope.formMode.mod, mod:"Restore"},{princ_id:$scope.document.id,reemplace_id:data.id},function(response){
            setGetOrder.reload({id:response.id,tipo: $scope.formMode.value});
            $scope.LayersAction({search:{name:"detalleDoc", search:true}});
        })
    };
    $scope.restore = function (item) {
        $scope.NotifAction("alert", "¡Perderas los cambios que hallas hecho!, ¿esta seguro de volver a esta version ?",[

                {name:"Cancelar", default:10, action: function () {

                }},
                {name:"Si, Deshacer cambios", action: function () {
                    $scope.back(item);
                }}


            ],
            {block:true, save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}})
    }

    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {

        if(oldVal == 'OrderOldDocs'){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }
    });


}]);

MyApp.controller('OrderlistPedidoCtrl',['$scope','$timeout','$filter','DateParse','clickCommitSrv','Order', function ($scope,$timeout,$filter,DateParse,commitSrv, Order) {

    $scope.clikBind = commitSrv.bind();
    $scope.tbl = {
        data: [],
        order:'id'
    };
    $scope.resumen  ={};
    $scope.$parent.OrderlistPedidoCtrl = function () {
        $scope.isHover = false;
        $scope.LayersAction({open:{name:"listPedido", after:function(){
            $scope.load( $scope.$parent.ctrl.provSelec.id);
        }}});
    };

    $scope.load = function(id){
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        Order.query({type:"OrderProvOrder", id:id}, {},function(response){

            angular.forEach(response, function (v, k) {
                v.emision= DateParse.toDate(v.emision);
                v.monto= parseFloat(v.monto);
                v.tasa= parseFloat(v.tasa);
                if(v.ult_revision){
                    v.ult_revision= DateParse.toDate(v.ult_revision);
                }
                $scope.tbl.data.push(v);
            });
        });
    };

    $scope.$watch('clikBind.state', function (newVal) {
        if(newVal){
            $timeout(function () {
                var data = commitSrv.get();
                commitSrv.setState(false);
                if(data.commiter == 'setProveedor'){
                    if($scope.$parent.module.index == 0){
                        $scope.$parent.ctrl.provSelec = data.scope.item;
                        $scope.$parent.OrderlistPedidoCtrl ();
                        commitSrv.setState(false);
                    }else if($scope.$parent.module.layer == 'listPedido'){
                        $scope.$parent.ctrl.provSelec = data.scope.item;
                        $scope.load(data.scope.item.id);
                        commitSrv.setState(false);
                    }

                }
            },0);

        }
    });


    $scope.DtPedido = function (doc) {
        $scope.OrderDetalleCtrl(doc);
    };

    $scope.addAnswer = function (item) {
        $scope.$parent.OrderAddAnswer({id:item.id, documento:item.documento});
    }

    $scope.hoverpedido= function(document){
        if(document){
            if($scope.timePreview){
                $timeout.cancel($scope.timePreview);
            }
            $scope.timePreview= $timeout(function(){
               $scope.preview =  $scope.$parent.resumenPedidoCtrl(document);
            }, 1000);

        }else{
            if($scope.timePreview){
                $timeout.cancel($scope.timePreview);
            }
        }
    };

    $scope.notCloseSumary = function () {
        console.log("no closeeeeee");
        $scope.$parent.notCloseSumary();
    };

    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {

        if(oldVal == 'listPedido'){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }
    });

}]);

MyApp.controller('OrderlistEmailsImportCtrl',['$scope','$timeout','DateParse','Order','providers','setGetOrder','clickCommitSrv',  function ($scope,$timeout,DateParse, Order,providers, setGetOrder,commitSrv) {

    $scope.tbl = {data:[], order:'id'};
    $scope.$parent.OrderlistEmailsImportCtrl = function () {
        $scope.LayersAction({search:{name:"listEmailsImport" }});
    };
    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'listEmailsImport'){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }
    });
}]);

MyApp.controller('OrderlistDocImportCtrl',['$scope','$timeout','DateParse','Order','providers','setGetOrder','clickCommitSrv',  function ($scope,$timeout,DateParse, Order,providers, setGetOrder,commitSrv) {

    $scope.tbl = {data:[], order:'id'};
    $scope.load = function(id){
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        Order.query({mod:"Imports",type:$scope.$parent.formMode.mod, prov_id:$scope.$parent.ctrl.provSelec.id, id:$scope.$parent.document.id}, {},function(response){

            angular.forEach(response, function (v, k) {
                v.emision= DateParse.toDate(v.emision);
                v.monto= parseFloat(v.monto);
                v.tasa= parseFloat(v.tasa);
                if(v.ult_revision){
                    v.ult_revision= DateParse.toDate(v.ult_revision);
                }
                $scope.tbl.data.push(v);
            });
        });
    };


    $scope.save = function (model, fn) {
        Order.post({mod:"SetParent",type:$scope.$parent.formMode.mod}, model,function(response){
            $scope.LayersAction({close:{ after: function () {
                angular.forEach(response.changes, function (v, k) {
                    setGetOrder.change('document',k,v);
                });
                angular.forEach(response.new, function (v, k) {
                    setGetOrder.change('todos'+v.id,undefined,v);
                });
                setGetOrder.setState('upd');
                console.log("si lo hizo");
                $timeout(function () {
                    $scope.NotifAction("ok","Realizado",[],{autohidden:1500});
                },500);

            }}});

        });
    };

    $scope.open = function (doc){
        Order.get({mod:"Compare",type:$scope.$parent.formMode.mod, id:$scope.$parent.document.id, compare:doc.id}, {},function(response){
            var errors = response.error;
            var globalData = response;
            var send = {doc_parent_id:doc.id,doc_parent_origen_id:$scope.$parent.formMode.value - 1 , id : $scope.document.id, items:[], prov_id:$scope.$parent.provSelec.id};
            angular.forEach(response.items ,function (v,k){
                send.items.push(v.id);
            });
            angular.forEach(globalData.asignado, function(v,k){
                send[k]=v;
            });

            if(Object.keys(errors).length == 0 && Object.keys(response.asignado).length == 0 &&  Object.keys(response.items).length == 0 ){
                $scope.NotifAction("alert"," Sin cambios, ¿Desea que se asigne  la "+$scope.$parent.formMode.name+" como origen del nuevo ?",
                    [
                        {name: "Si", default:2,
                            action:function(){
                                $scope.save(send);
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
                                $scope.save(send);
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
                                $scope.save(send, function () {
                                    setGetOrder.reload();
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
                                $scope.save(send, function () {
                                    setGetOrder.reload();
                                });

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
                            $scope.save(send);

                        }
                    }
                    ,{name:"Dejarme elegir ",
                        action:function(){
                            $scope.NotifAction("error"," ¿Que desea hacer? "
                                ,[
                                    {name:" Usar solicitud ",
                                        action:function(){
                                            angular.forEach(globalData.error, function(v,k){
                                                send[k]=v[0].key;
                                            });
                                            $scope.save(send);

                                        }
                                    }
                                    ,{name:"Usar proforma",
                                        action:function(){

                                            angular.forEach(globalData.error, function(v,k){
                                                send[k]=v[1].key;
                                            });
                                            $scope.save(send);


                                        }
                                    },
                                    {name:"Preguntarme en cada caso("+Object.keys(errors).length+")",action:function(){
                                        var tasa;
                                        if(errors.prov_moneda_id){
                                            var tasa = angular.copy(errors.tasa);
                                            delete  errors.tasa;
                                        }
                                        $scope.question = {
                                            question:[],
                                            answers:[],
                                            cancel:false,
                                            index:0

                                        };


                                        $scope.$watchGroup(
                                            ['question.cancel',
                                                'question.question.length','question.answers.length'], function(newVal){
                                                if(newVal[0]){
                                                    $scope.NotifAction("error", "Cancelado",[],{autohidden:autohidden});
                                                    delete $scope.accions;
                                                }else if(newVal[1] > 0 && $scope.question.index < newVal[1] ){
                                                    var q=$scope.question.question[$scope.question.index ];
                                                    $scope.NotifAction("alert",q.title,
                                                        [
                                                            {name: q.textA, action:
                                                                function(){
                                                                    $scope.question.answers.push({key: q.key, value: q.optA});
                                                                    q.answer= q.optA;
                                                                    $scope.question.index++;
                                                                }
                                                            },
                                                            {name: q.textB, action:
                                                                function(){
                                                                    $scope.question.answers.push({key: q.key, value: q.optB});
                                                                    q.answer= q.optB;
                                                                    $scope.question.index++;
                                                                }
                                                            }
                                                        ]
                                                        ,{block:true});
                                                }else  if(newVal[1] == newVal[2] && newVal[2] >0)  {
                                                    angular.forEach($scope.question.answers, function(v,k){
                                                        send[v.key]= v.value;
                                                    });
                                                    $scope.save(send, function () {
                                                        setGetOrder.reload();
                                                    });
                                                }
                                            });

                                        if(errors.prov_moneda_id){
                                            $scope.question.question.push({key:'prov_moneda_id',title:"Selecione moneda a usar",
                                                textA:errors.prov_moneda_id[0].text,
                                                textB:errors.prov_moneda_id[1].text,
                                                optA:errors.prov_moneda_id[0].key,
                                                optB:errors.prov_moneda_id[1].key
                                            });
                                        }
                                        if(errors.titulo){
                                            $scope.question.question.push({key:'titulo',title:"Selecione titulo a usar",
                                                textA:errors.titulo[0].key,
                                                textB:errors.titulo[1].key,
                                                optA:errors.titulo[0].key,
                                                optB:errors.titulo[1].key
                                            });
                                        }
                                        if(errors.comentario){
                                            $scope.question.question.question.push({key:'comentario',title:"Selecione comentario a usar",
                                                textA:errors.comentario[0].key,
                                                textB:errors.comentario[1].key,
                                                optA:errors.comentario[0].key,
                                                optB:errors.comentario[1].key
                                            });
                                        }
                                        if(errors.pais_id){
                                            $scope.question.question.push({key:'pais_id',title:"Selecione pais a usar",
                                                textA:errors.pais_id[0].text,
                                                textB:errors.pais_id[1].text,
                                                optA:errors.pais_id[0].key,
                                                optB:errors.pais_id[1].key
                                            });
                                        }
                                        if(errors.condicion_pago_id){
                                            $scope.question.question.push({key:'condicion_pago_id',title:"Selecione condicion de pago a usar",
                                                textA:errors.condicion_pago_id[0].text,
                                                textB:errors.condicion_pago_id[1].text,
                                                optA:errors.condicion_pago_id[0].key,
                                                optB:errors.condicion_pago_id[1].key
                                            });

                                        }

                                        if(errors.direccion_facturacion_id){
                                            $scope.question.question.push({key:'direccion_facturacion_id',title:"Selecione la direcion de facturacion a usar",
                                                textA:errors.direccion_facturacion_id[0].text,
                                                textB:errors.direccion_facturacion_id[1].text,
                                                optA:errors.direccion_facturacion_id[0].key,
                                                optB:errors.direccion_facturacion_id[1].key
                                            });
                                        }
                                        if(errors.puerto_id){
                                            $scope.question.question.push({key:'puerto_id',title:"Selecione la direcion de facturacion a usar",
                                                textA:errors.puerto_id[0].text,
                                                textB:errors.puerto_id[1].text,
                                                optA:errors.puerto_id[0].key,
                                                optB:errors.puerto_id[1].key
                                            });
                                        }

                                    }
                                    },
                                    {name:"Cancelar",action:function(){}}
                                ]);
                        }
                    },
                    {name:"Cancelar",action:function(){}}
                ],{});

            }

        });

    };
    $scope.$parent.OrderlistDocImportCtrl = function () {
        $scope.LayersAction({search:{name:"OrderlistImportDoc", after:$scope.load }});
    }

    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'OrderlistImportDoc'){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }
    });
}]);

MyApp.controller('OrderDetalleDocCtrl',['$scope','$timeout','DateParse','Order','masters','providers','setGetOrder','clickCommitSrv','form',  function ($scope,$timeout,DateParse, Order,masters,providers, setGetOrder,commitSrv, formSrv) {

    $scope.estadosDoc = masters.query({type: 'getOrderStatus'});
    $scope.$parent.openImport = function(){


        if($scope.Docsession.block ){
            $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder importar el documento",[],{autohidden:2000});
        }else{

            if($scope.formMode.value == 21){
                $scope.$parent.OrderlistEmailsImportCtrl();

            }else  if($scope.formMode.value == 22 || $scope.formMode.value ==23 ){
                $scope.$parent.OrderlistDocImportCtrl();
            }
        }

    };
    $scope.docBind= setGetOrder.bind();
    $scope.clikBind = commitSrv.bind();
    $scope.formBind = formSrv.bind();
    $scope.formData = {direccionesFact:[],monedas: [],paises:[] ,condicionPago:[],direcciones:[]};

    $scope.$parent.OrderDetalleCtrl = function (data, fn) {
        $scope.$parent.Docsession.block = true;
        $scope.FormHeadDocument.$setUntouched();
        $scope.FormHeadDocument.$setPristine();
        $scope.isTasaFija=true;


        if(data){
            $scope.gridView= 1;
            setGetOrder.setOrder({id:data.id, tipo:data.tipo});
            setGetOrder.setState("select");
            if(data.documento){
                $scope.$parent.formMode= $scope.$parent.forModeAvilable.getXname(data.documento);
            }else{
                $scope.$parent.formMode= $scope.$parent.forModeAvilable.getXValue(data.tipo);
            }

            $scope.$parent.Docsession.global='upd';
            $scope.$parent.preview = false;
            $scope.$parent.Docsession.isCopyableable = true;

        }else{
            $scope.$parent.Docsession.global="new";
            $scope.$parent.Docsession.isCopyableable = false;
            $scope.$parent.Docsession.block=false;
            setGetOrder.clear();
            if($scope.$parent.provSelec && $scope.$parent.provSelec.id){
                $scope.$parent.document.prov_id=$scope.provSelec.id;
            }

            Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.$parent.document, function(response){
                setGetOrder.setOrder({id:response.id,tipo:$scope.formMode.value});
                setGetOrder.setState('select');
            });
        }


        if(fn){
            fn($scope);
        }
        $scope.LayersAction({search:{name:"detalleDoc" , after: $scope.$parent.reloadDoc}});



    };
    $scope.$watchCollection("FormHeadDocument.$error",function(n,o){

    });
    $scope.jsonValidator = function () {

        if($scope.$parent.formMode.value == 23){
             return {
                 "get_provider_coin": "Este Provedor no tiene monedas, y no se puede asignar",
                 "get_payment_condition": "Este Provedor no tiene condiciones de pago,y no se puede asignar"
             };
        }
         return {"get_provider_coin": "Este Provedor no tiene monedas, y no se puede asignar "};
    };
    $scope.canNext = function () {
        if (!$scope.FormHeadDocument.$valid) {
            $scope.NotifAction("error",
                "Existen campos pendientes por completar, por favor verifica que información le falta."
                ,[],{autohidden:2000});

            $timeout(function(){
                var inval = angular.element(" form[name=FormHeadDocument] .ng-invalid ");
                if(inval[0]){
                    inval[0].focus();
                }else{
                    inval = angular.element(" form[name=FormHeadDocument] ng-untouched");
                    console.log(" terro ", inval)
                    inval[0].focus();
                }
            },0);

            return false;

        }
        return true;
    };

    $scope.changeProd = function (item) {

        if($scope.$parent.allowEdit()){
            if(item.asignado){
                $scope.NotifAction("alert","¿Esta seguro de eliminar este producto?",
                    [
                        {name:"Si eliminar", action: function () {
                            $scope.delete(item);
                        }},

                        {name:"Cancelar", action: function () {

                        }}
                    ]
                    ,{block:true});
            }else{
                $scope.restore(item);
            }
        }

    };

    $scope.delete = function (item) {
        Order.post( {type:$scope.$parent.formMode.mod, mod:"DeleteItem"},{id:item.id}, function (response){
            $scope.$parent.NotifAction("ok", "Eliminado",[], {autohidden:1500});
            item.asignado=false;
            setGetOrder.change('todos'+item.id,'id', undefined);

        });
    };

    $scope.restore = function (item) {
        Order.post( {type:$scope.$parent.formMode.mod, mod:"RestoreItem"},{id:item.id}, function (response){
            $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
            item.asignado=true;
            setGetOrder.change('todos'+item.id,'id', item.id);
        });
    };
    $scope.openProd = function (data) {
        var send = angular.copy(data);
        formSrv.name= 'OrderDetalleDocCtrl';
        $scope.OrderminiChangeItemCtrl(send);
    };

    $scope.changeProvMoneda = function(newVal ){


        if(!$scope.FormHeadDocument.$Pristine){

        if(newVal == null){

            $scope.document.prov_moneda_id= null;
            if( angular.equals(angular.element("#detalleDoc #prov_moneda_id input[type=search]"),angular.element(":focus"))){
                setGetOrder.change("document","prov_moneda_id",undefined);
            }


        }else{
            if(angular.equals(angular.element("#detalleDoc #prov_moneda_id input[type=search]"),angular.element(":focus") )){
                setGetOrder.change("document","prov_moneda_id",newVal.id);
            }
            var tasa = parseFloat(newVal.precio_usd);
            $scope.$parent.document.prov_moneda_id= newVal.id;
            if(!$scope.document.tasa || $scope.isTasaFija){
                $scope.document.tasa = tasa;
                setGetOrder.change('document','tasa', tasa);
            }else {
                if($scope.document.tasa !=  tasa && !$scope.isTasaFija ){
                    $scope.NotifAction("alert","La tasa del "+newVal.nombre+" es diferente de la fijada ¿Que desea hacer? ",
                        [
                            {name:"Mantener la tasa actual ", default:2000,action:
                                function(){

                                }
                            },{name:"Asignar la tasa del "+newVal.nombre+" a la "+ $scope.formMode.name, action:
                            function(){
                                $scope.document.tasa = tasa;
                                $scope.isTasaFija=true;
                                setGetOrder.change('document','tasa', tasa);
                            }}
                        ]
                        ,{block:true});
                }
            }

        }
        }
    };
    $scope.toEditHead= function(form, id,val){

        if(!$scope.FormHeadDocument.$pristine){
           // console.log(id, val);
            setGetOrder.change(form,id,val);
        }

    };
    $scope.editTasa= function(){
        if( $scope.isTasaFija && $scope.document.permit.update){
            $scope.NotifAction("alert","Desea asignar una tasa unica para esta "+$scope.formMode.name,[
                {
                    name:"No",
                    action: function(){

                    }
                },
                {
                    name:"Si",
                    action: function(){
                        $scope.isTasaFija=false;
                        var mo= jQuery("#tasa");
                        mo[0].focus();
                    }
                }

            ],{block:true});

        }
    };

    $scope.$watch('formBind.estado', function (newVal) {
        if(newVal){
            if( formSrv.name == 'OrderDetalleDocCtrl'){
                var data = formSrv.getData();
                angular.forEach($scope.$parent.document.productos.todos, function (v) {
                    if(data.response.model.id == v.id){
                        v.saldo= data.response.model.saldo;
                        v.id= data.response.model.id;
                        v.cantidad= data.response.model.cantidad;
                        v.costo_unitario= data.response.model.costo_unitario;
                        setGetOrder.change('todos'+ data.response.id,'id', data.response.id);
                        setGetOrder.change('todos'+ data.response.id,'cantidad', data.response.cantidad);
                        setGetOrder.change('todos'+ data.response.id,'costo_unitario', data.response.costo_unitario);
                        setGetOrder.change('todos'+ data.response.id,'saldo', data.response.saldo);
                        console.log("cambion en OrderDetalleDocCtrl");
                        return 0;
                    }
                });
            }

        }
    });

    $scope.$watch('$parent.document.titulo',function (newVal ) {

    });

    $scope.$watch('clikBind.state', function (newVal) {
        if(newVal){
            $timeout(function () {
                var data = commitSrv.get();
                commitSrv.setState(false);
                if(data.commiter == 'setProveedor'){
                    //onsole.log("data in commiter", $scope.$parent);

                    if($scope.$parent.module.layer == 'detalleDoc' && !$scope.$parent.Docsession.block ){
                        $scope.$parent.ctrl.provSelec =angular.copy( data.scope.item);
                        //$scope.ctrl.searchProveedor = $scope.$parent.ctrl.provSelec.razon_social;
                        //console.log("data in commiter asing", $scope.$parent.ctrl.provSelec);

                    }

                }
            },0);

        }
    });
    $scope.$watchGroup(['FormHeadDocument.$valid', 'FormHeadDocument.$pristine'], function (newVal) {
        if(!newVal[1] &&  $scope.formMode.mod && $scope.provSelec.id){
            $scope.document.prov_id = angular.copy($scope.provSelec.id);
            Order.postMod({type:$scope.$parent.formMode.mod, mod:"Save"},$scope.document, function(response){
                $scope.FormHeadDocument.$setPristine();
                $scope.$parent.document.uid= response.uid;
            });
        }
        if(newVal[0] && $scope.$parent.document.id){
            $scope.$parent.document.isAprobable=true;
        }
    });
    $scope.$watch('$parent.ctrl.provSelec', function (newVal, oldVal) {

        if(newVal ){

            if( !oldVal || (oldVal.id != newVal.id)){
                $scope.$parent.provSelec= newVal;
                $scope.formData.direccionesFact.splice(0,$scope.formData.direccionesFact.length);
                $scope.formData.monedas.splice(0,$scope.formData.monedas.length);
                $scope.formData.paises.splice(0,$scope.formData.paises.length);
                $scope.formData.condicionPago.splice(0,$scope.formData.condicionPago.length);
                Order.query({type:"InvoiceAddress", prov_id:newVal.id},{}, function(response){
                    $scope.formData.direccionesFact=response;
                });
                providers.query({type: "provCoins", id_prov: newVal.id},{}, function(response){
                    $scope.formData.monedas =response;
                });
                Order.query({type:"ProviderCountry",prov_id:newVal.id},{}, function(response){
                    $scope.formData.paises=response;
                });
                Order.query({type:"ProviderPaymentCondition", prov_id:newVal.id},{}, function(response){
                    angular.forEach(response, function(v){
                        $scope.formData.condicionPago.push(v);
                    })
                    // $scope.formData.condicionPago=response;
                });
                $timeout(function(){
                    var elem=angular.element("#prov"+newVal.id);
                    angular.element(elem).parent().scrollTop(angular.element(elem).outerHeight()*angular.element(elem).index());
                },0);

            }
        }else{
            $scope.$parent.provSelec= undefined;
        }

    });
  /*  $scope.$watch('$parent.document.objs.direccion_facturacion_id', function (newVal) {
        if(newVal ){

            $scope.$parent.document.direccion_facturacion_id = newVal.id;

        }

    });*/
    $scope.$watch('$parent.document.objs.direccion_almacen_id', function (newVal) {



        if(newVal ){

            $scope.$parent.document.direccion_almacen_id = newVal.id;
            $scope.$parent.ctrl.puerto_id= null;
            Order.query({type:"AdrressPorts", direccion_id: newVal.id},{}, function(response){
                $scope.formData.puertos = response;
            });

        }else{
            if( angular.equals(angular.element("#detalleDoc #direccion_almacen_id input[type=search]"),angular.element(":focus"))){
                $scope.$parent.document.direccion_almacen_id= null;
                $scope.$parent.ctrl.puerto_id= null;
            }


        }

    });
    $scope.$watch('document.objs.pais_id', function (newVal) {

        if(newVal && $scope.provSelec.id){
            $scope.document.pais_id = newVal.id;
            $scope.formData.direcciones.splice(0,$scope.formData.direcciones.length);
            $scope.ctrl.direccion_almacen_id= null;
            Order.query({type:"StoreAddress", prov_id:$scope.provSelec.id, pais_id:newVal.id},{}, function(response){

                $scope.formData.direcciones = response;
            });
            if( $scope.Docsession.global!= 'new'){

            }
        }else{
            if(!$scope.Docsession.block){
                $scope.document.pais_id= null;
                $scope.ctrl.searchdirAlmacenSelec= null;
                $scope.ctrl.direccion_almacen_id= null;
            }


        }


    });
    $scope.$watch('$parent.document.objs.condicion_pago_id', function (newVal) {

        if( angular.equals(angular.element("#detalleDoc #condicion_pago_id input[type=search]"),angular.element(":focus"))){


            if(newVal ){
                if(newVal != 0){
                    $scope.$parent.document.condicion_pago_id = newVal.id;
                    // setGetOrder.change("document","condicion_pago_id", newVal.id);
                }
            }else{
                //  setGetOrder.change("document","condicion_pago_id",undefined);
            }
        }

    });

    // limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {

        if(oldVal == 'detalleDoc'){
            $scope.FormHeadDocument.$setUntouched();
            $scope.FormHeadDocument.$setPristine();
            console.log()
        }
    });


}]);

MyApp.controller('OrderPriorityDocsCtrl',['$scope','DateParse','Order','masters', function ($scope,DateParse,Order,masters) {

    $scope.tbl= {data:[],order:'id'}
    $scope.openOldDocs = function (){
        $scope.LayersAction({open:{name:"priorityDocs",
            before: function(){

            }, after: function(){
            }
        }});
    };

    $scope.openTempDoc = function(doc){
        $scope.$parent.OrderDetalleCtrl(doc);
    };

    $scope.$parent.OrderPriorityDocsCtrl = function () {


        $scope.LayersAction({search:{name:"priorityDocs",
            before:function(){
                $scope.tbl.data.splice(0,$scope.tbl.data.length);
                Order.get({type:"OldReviewDocs"},{}, function(response){
                    angular.forEach(response.docs, function (v, k) {
                        if(v.emision && v.emision != null){
                            v.emision = DateParse.toDate(v.emision)
                        }
                        $scope.tbl.data.push(v);
                    });

                });
            }
        }});
    };
    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'priorityDocs'){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }
    });


}]);

MyApp.controller('OrderUnclosetDocCtrl',['$scope','DateParse','Order','masters', function ($scope,DateParse,Order,masters) {

    $scope.tbl= {data:[],order:'id'};
    $scope.$parent.OrderUnclosetDocCtrl = function () {

        $scope.LayersAction({search:{name:"unclosetDoc",
            after:function(){

                $scope.$parent.ctrl.provSelec = undefined;
                console.log("in parent",$scope.$parent);
              //  $scope.tbl.data.splice(0,$scope.tbl.data.length);
                Order.query({type:"UnClosetDoc"},{}, function(response){
                    angular.forEach(response, function (v, k) {
                        if(v.emision && v.emision != null){
                            v.emision = DateParse.toDate(v.emision)
                        }
                        $scope.tbl.data.push(v);
                    });

                });
            }
        }});
    };
    $scope.open = function (item) {
        $scope.$parent.OrderDetalleCtrl(item, function () {
            $scope.$parent.Docsession.block= false;
        });
    };
    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'unclosetDoc'){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }

    });
}]);

MyApp.controller('OrderlistProducProvCtrl',['$scope','$timeout', 'Order','masters','setGetOrder','form', function ($scope,$timeout, Order,masters,setGetOrder,formSrv) {

    $scope.bindForm = formSrv.bind();
    masters.query({type:"prodLines"},{}, function (response) {
        $scope.lineas= response;
    });

    $scope.$parent.OrderlistProducProvCtrl = function () {
        $scope.LayersAction({search:{name:"listProducProv"}});
    };

    $scope.$parent.OrderlistCreatedProducProvCtrl = function () {
        formSrv.name= 'OrderCreateProdCtrl';
        $scope.$parent.OrderCreateProdCtrl({prov_id: $scope.$parent.document.prov_id});
    };

    $scope.openItem= function (data, index) {
        var send = {
            tipo_origen_id:1,
            asignado:data.asignado,
            reng_id: data.reng_id,
            id:data.id,
            origen_item_id:data.id,
            costo_unitario:data.costo_unitario,
            descripcion: data.descripcion,
            codigo: data.codigo,
            codigo_fabrica: data.codigo_fabrica,
            codigo_profit: data.codigo_fabrica,
            doc_id: $scope.$parent.document.id,
            producto_id: data.id,
            cantidad: data.cantidad,
            saldo: data.cantidad,
            uid: data.uid,
            index: index
        };
        $scope.select= data;
        formSrv.name= 'OrderlistProducProvCtrl';
        $scope.$parent.OrderminiAddProductCtrl(send);

    };

    $scope.delete = function (item) {
        Order.post( {type:$scope.$parent.formMode.mod, mod:"DeleteProductItem"},{id:item.reng_id}, function () {
            $scope.NotifAction("ok","Removido",[],{autohidden:1500});
            item.asignado= false;
            item.cantidad= 0;
        });
    };
    $scope.change = function (data, event) {
        if($scope.allowEdit()) {

            var send = {
                tipo_origen_id: 1,
                asignado: data.asignado,
                reng_id: data.reng_id,
                id: data.id,
                origen_item_id: data.id,
                costo_unitario: data.costo_unitario,
                descripcion: data.descripcion,
                codigo: data.codigo,
                codigo_fabrica: data.codigo_fabrica,
                codigo_profit: data.codigo_fabrica,
                doc_id: $scope.$parent.document.id,
                producto_id: data.id,
                uid: data.uid

            };
            $scope.select = data;
            if (!data.asignado) {
                formSrv.name = 'OrderlistProducProvCtrl';
                $scope.$parent.OrderminiAddProductCtrl(send);

            } else {
                $scope.select = undefined;
                $scope.NotifAction("alert", "Esta seguro de remover el producto",
                    [
                        {
                            name: "Cancelar", action: function () {

                        }
                        },
                        {
                            name: "Si, estoy seguro", action: function () {
                            $scope.delete(data);
                        }
                        }
                    ]
                    , {block: true});
            }
        }
        //  if(!$scope.$parent.Docsession.block){

        ///}

    };


    $scope.next = function () {
        $scope.$parent.OrderAgrPedCtrl();
    };
    $scope.canNext = function () {
        if (!$scope.listProductoItems.$valid && $scope.module.layer== 'listProducProv') {

            $scope.NotifAction("error",
                "No se pueden asignar productos sin asignarle una cantidad verifique que todos los productos tienen cantidad correctas"
                ,[],{autohidden:2000});
            return false;

        }
        return true;
    };

    $scope.$watch('lineaSelec', function (newVal, oldVal) {
        if(newVal ){
            masters.query({type:"prodSubLines", linea_id: newVal.id},{}, function (response) {
                $scope.subLineas =response;
            });

        }
    });

    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal  ){
            if(formSrv.name == 'OrderlistProducProvCtrl'){
                var data = formSrv.getData();
                var model = {};
                angular.forEach($scope.providerProds, function (v,k) {
                    if(data.model.producto_id == v.id){
                        model= v;
                        return 0;
                    }
                });
                model.asignado= (data.response.accion  == 'new' || data.response.accion  == 'upd')  ;
                model.reng_id = data.response.reng_id;
                model.cantidad = data.response.cantidad;
                model.saldo = data.response.saldo;
                if(data.response.accion  == 'new'){

                    setGetOrder.change('producto'+data.response.reng_id,undefined,angular.copy( model.saldo));
                    $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
                    setGetOrder.setState('upd');
                }if(data.response.accion  == 'upd'){
                    setGetOrder.change('producto'+data.response.reng_id,'asignado',model.asignado);
                    setGetOrder.change('producto'+data.response.reng_id,'reng_id',model.reng_id);
                    setGetOrder.change('producto'+data.response.reng_id,'cantidad',model.cantidad);
                    setGetOrder.change('producto'+data.response.reng_id,'saldo',model.saldo);
                    $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
                    setGetOrder.setState('upd');
                }
            }
            if(formSrv.name == 'OrderCreateProdCtrl'){
                var data = formSrv.getData();
                var prod = angular.copy(data.response);
                prod.cantidad = 0;
                prod.saldo = 0;
                $scope.providerProds.push(prod);
                $scope.openItem(prod, $scope.providerProds.length -1  );

            }


        }
    });

    //limpieza
    $scope.$watch('$parent.ctrl.provSelec', function (newVal, oldVal) {
        if(newVal && newVal != null){
            $timeout(function () {
                $scope.providerProds = [];
                Order.query({type:"ProviderProds", id:newVal.id,tipo:$scope.$parent.formMode.value, doc_id:$scope.document.id},{}, function(response){

                    angular.forEach(response , function(v,k){

                        v.saldo=parseFloat(v.saldo);
                        $scope.providerProds.push(v);
                    });
                });

            },0);
        }else{
            //$scope.providerProds = [];
        }

    });

}]);


/**
 * qui se decide el tipo de resumen dependiendo de la condicion del documento
 ***/
MyApp.controller('OrderAgrPedCtrl',['$scope','Order','masters','clickCommitSrv', function ($scope,Order,masters,clickCommitSrv) {

    $scope.$parent.OrderAgrPedCtrl = function () {
        $scope.LayersAction({search:{name:"agrPed",before: function(){}}});
    };
    $scope.canNext = function () {
        return true;
    };
    $scope.next = function () {
        if($scope.document.productos.contraPedido.length == 0
            && $scope.document.productos.kitchenBox.length == 0
            && !$scope.document.isAprobado
        ){

            $scope.NotifAction("alert", "¡No agregaste ni un contra pedido, ni un kitchenBox, es raro no cargar al menos un contra pedido, ¿igual quieres continuar?",
                [{name:"Si, continuar", action: function () {
                    $scope.$parent.OrderfinalDocCtrl();
                }},{name:"Cancelar", action: function () {

                }}]
                , {block:true})
        }else{
            $scope.$parent.OrderfinalDocCtrl();
        }



    };
    $scope.openCp = function () {
        $scope.$parent.OrderAgrContPed()
    };
    $scope.openk = function () {
        $scope.$parent.OrderAgrKitBoxs();
    };
    $scope.openSust = function () {
        $scope.$parent.OrderAgrPedPendCtrl();
    };




}]);


MyApp.controller('OrderAgrPedPendCtrl',['$scope','Order','setGetOrder' ,function ($scope,Order,setGetOrder) {

    $scope.tbl = {
        data:[],
        order:'id'
    };
    $scope.load = function () {
        $scope.tbl.data.splice(0,$scope.tbl.data.length);
        Order.query({type:$scope.formMode.mod,mod:"Substitutes",tipo: $scope.$parent.formMode.value, prov_id: $scope.$parent.provSelec.id, doc_id: $scope.$parent.document.id},{}, function (response) {
            angular.forEach(response, function (v,k) {
                $scope.tbl.data.push(v);
            })
        });
    };

    $scope.$parent.OrderAgrPedPendCtrl = function () {
        $scope.LayersAction({search:{name:"OrderAgrPedPend",before:  $scope.load}});
    };

    $scope.open = function (item) {
        $scope.$parent.OrderResumenPedidoSusCtrl(item);
    };

    $scope.review = function (item) {


    };

    $scope.remove = function (item) {
        Order.postMod({type:$scope.formMode.mod,mod:"RemoveSustitute"},{princ_id:$scope.document.id,reemplace_id:item.id},function(response){
            $scope.NotifAction("ok","Removido",[],{autohidden:1500});
            item.asignado = false;
            item.reng_id = undefined;
            setGetOrder.reload({id:response.id, tipo:$scope.$parent.formMode.value});
        });
    };

    $scope.add = function (item) {
        Order.postMod({type:$scope.formMode.mod,mod:"AddSustitute"},{princ_id:$scope.document.id,reemplace_id:item.id},function(response){
            $scope.NotifAction("ok","Asignado",[],{autohidden:1500});
            item.asignado = true;
            setGetOrder.reload({id:response.id, tipo:$scope.$parent.formMode.value});
        });
    };
    $scope.change = function (item) {
        if($scope.allowEdit()){
            if(!item.asignado){
                $scope.add(item);
            }else {
                $scope.NotifAction("alert","¿Esta seguro de quitarlo ?",
                    [
                        {name:"Si", action: function () {
                            $scope.remove(item);
                        }},
                        {name:"Cancelar", action: function () {

                        }}
                    ],{block:true})
            }
        }


    };
    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'unclosetDoc'){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
        }
    });

}]);






MyApp.controller('OrderAgrContPed',['$scope','Order','setGetOrder' ,function ($scope,Order,setGetOrder) {

    $scope.tbl = {
        data:[],
        order:'id'
    };

    $scope.load = function () {
        $scope.tbl.data.splice(0,$scope.tbl.data.length);
        Order.query({type:"CustomOrders",tipo: $scope.$parent.formMode.value, prov_id: $scope.$parent.provSelec.id, doc_id: $scope.$parent.document.id},{}, function (response) {
            angular.forEach(response, function (v,k) {
                $scope.tbl.data.push(v);
            })
        });
    };
    $scope.$parent.OrderAgrContPed = function () {
        $scope.LayersAction({search:{name:"agrContPed",after:  $scope.load}});
    };

    $scope.open = function (item) {
        $scope.$parent.OrderResumenContraPedidoCtrl(item);
    };

    $scope.reviewCp = function (item) {
        Order.query({type:"CustomOrderReview", id: item.id, tipo: $scope.$parent.formMode.value, doc_id:$scope.$parent.document.id},{},function(response){
            item.doc_id=$scope.document.id;
            if(response.length > 0){
                $scope.NotifAction("alert",
                    "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
                    ,[
                        {name: 'Si',
                            action:function(){
                                $scope.addCp(item);
                            }
                        },{name: 'No',
                            action:function(){}
                        }
                    ]);
            }else{
                $scope.addCp(item);
            }



        });

    };

    $scope.removeCp = function (item) {
        Order.postMod({type:$scope.formMode.mod,mod:"RemoveCustomOrder"},{id:item.id, doc_id: $scope.$parent.document.id,tipo: $scope.$parent.formMode.value,},function(response){
            $scope.NotifAction("ok","Removido",[],{autohidden:1500});
            setGetOrder.change('contraPedido'+item.id,'id',item);
            setGetOrder.setState("upd");
            angular.forEach(response.keys, function (v, k) {
                setGetOrder.change('contraPedido'+v,'id',undefined);
            });
            item.asignado= false;
        });
    };

    $scope.addCp = function (item) {
        Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},{id:item.id, doc_id: $scope.$parent.document.id},function(response){
            $scope.NotifAction("ok","Asignados "+response.newitems.length +" articulos ",[],{autohidden:1500});
            setGetOrder.change('contraPedido'+item.id,'id',undefined);
            setGetOrder.setState("change");

            item.asignado= true;
        });
    };

    $scope.questionCp = function (item) {
        if(item.import){
            $scope.NotifAction("alert", "Este contra pedido fue importado desde otro documento. Por favor confirmanos que desea eliminarlo ",
                [
                    {name:"Eliminalo", action: function () {
                        $scope.removeCp(item);
                    }},{name:"Cancelar", action: function () {

                }}
                ]
                , {block:true, save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
        }else{
            $scope.NotifAction("alert", "¿Esta seguro de elimnar este contra pedido?",
                [
                    {name:"Eliminalo", action: function () {
                        $scope.removeCp(item);
                    }},{name:"Cancelar", action: function () {

                }}
                ]
                , {block:true, save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});

        }
    };

    $scope.change = function (item) {
        if($scope.allowEdit()){
            if(!item.asignado){
                if($scope.provSelec.contrapedido != '1'){
                    $scope.NotifAction("alert","El proveedor "+ $scope.provSelec.razon_social +
                        " no admite contra pedidos ¿Esta seguro de asignarlo ?",
                        [
                            {name:"No", action : function(){
                            }},
                            {name:"Si", action:
                                function(){
                                    $scope.reviewCp(item);
                                }
                            }
                        ]
                        ,{block: true, save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
                }else {
                    $scope.reviewCp(item);
                }

            }else{
                $scope.questionCp(item);
            }
        }


    };
    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'agrContPed'){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
        }
    });


}]);

MyApp.controller('OrderAgrKitBoxsCtrl',['$scope','$timeout','Order','setGetOrder','form' ,function ($scope,$timeout,Order,setGetOrder, formSrv) {
    $scope.bindForm = formSrv.bind();
    $scope.tbl = {
        data:[],
        order:'id'
    };

    $scope.load = function () {
        $scope.tbl.data.splice(0,$scope.tbl.data.length);
        Order.query({type:"KitchenBoxs",tipo: $scope.$parent.formMode.value, prov_id: $scope.$parent.provSelec.id, doc_id: $scope.$parent.document.id},{}, function (response) {
            angular.forEach(response, function (v,k) {
                $scope.tbl.data.push(v);
            })
        });
    };
    formSrv.name = 'OrderAgrKitBoxsCtrl';
    $scope.$parent.OrderAgrKitBoxs = function () {
        $scope.LayersAction({search:{name:"agrKitBoxs",after:  $scope.load}});
    };

    $scope.open = function (item) {
        $scope.$parent.OrderResumenKitchenboxCtrl(item);
    };

    $scope.review = function (item) {


    };

    $scope.remove = function (item) {
        Order.postMod({
            type: $scope.formMode.mod,
            mod: "RemovekitchenBox"
        }, {id:item.reng_id}, function (response) {
            setGetOrder.change('kitchenBox'+item.id,'id',undefined);
            setGetOrder.setState("upd");
            $scope.NotifAction("ok", "Removido", [], {autohidden: 1500});
            item.asignado= false;
            item.reng_id=undefined;
            item.costo_unitario=undefined;
        });

    };

    $scope.openItem= function (data) {
        $scope.select= data;
        var send = {
            tipo_origen_id:1,
            asignado:data.asignado,
            reng_id: data.reng_id,
            id:data.id,
            origen_item_id:data.id,
            costo_unitario:data.costo_unitario,
            descripcion: data.titulo,
            codigo: data.codigo,
            codigo_fabrica: data.codigo_fabrica,
            codigo_profit: data.codigo_fabrica,
            doc_id: $scope.$parent.document.id,
            producto_id: data.id,
            cantidad: data.cantidad,
            saldo: data.cantidad,
            uid: data.uid
        };
        formSrv.name= 'OrderAgrKitBoxsCtrl';
        $scope.OrderminiAddKitchenBoxCtrl(send);
    };

    $scope.question = function (item) {
        $scope.NotifAction("alert",
            "Se eliminara el KitchenBox ¿Desea continuar?"
            , [
                {
                    name: 'Si',
                    action: function () {
                        $scope.remove(item);
                    }
                }, {
                    name: 'Cancel',
                    action: function () {

                    }
                }
            ]);
    };

    $scope.review = function (item) {
        Order.query({type:"KitchenBoxReview", id: item.id, tipo: $scope.$parent.formMode.value, doc_id:$scope.$parent.document.id},{},function (response) {
            if(response.length > 0){
                $scope.NotifAction("alert",
                    "Ya se encuentra asignado a otro documento. Por favor confirmanos que deseas agregarlo"
                    , [
                        {
                            name: 'Si', action: function () {
                            $scope.openItem(item);}
                        },
                        {
                            name: 'No',action: function () {}
                        }
                    ],{block:true,  save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
            }else {
                $scope.openItem(item);
            }

        });
    };

    $scope.change = function (item) {
        if($scope.allowEdit()){
            if(!item.asignado){
                $scope.review(item);
            }else{
                $scope.question(item);
            }
        }


    };
    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && formSrv.name == 'OrderAgrKitBoxsCtrl'){
            var data = formSrv.getData();
            var model = {};
            angular.forEach($scope.tbl.data, function (v, k) {
                if(v.id == data.model.id){
                    model=v;
                }
            });

            model.asignado = (data.response.action  == 'new' || data.response.action  == 'upd') ;
            model.reng_id= data.response.item.id;
            model.costo_unitario= data.response.item.costo_unitario;

            $timeout(function () {
                if(data.response.action  == 'new'){
                    setGetOrder.change('kitchenBox'+model.id,undefined,data.response.item);
                    $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
                }if(data.response.action  == 'upd'){
                    setGetOrder.change('kitchenBox'+model.id,'asignado', model.asignado);
                    setGetOrder.change('kitchenBox'+model.id,'reng_id', model.reng_id);
                    setGetOrder.change('kitchenBox'+model.id,'costo_unitario', model.costo_unitario);
                    $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
                }
            },200);


            setGetOrder.setState("upd");

        }
    });

    //limpieza
    $scope.$watch('$parent.module.layer', function (newVal, oldVal) {
        if(oldVal == 'agrKitBoxs'){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
        }
    });
}]);



MyApp.controller('OrderResumenPedidoSusCtrl',['$scope', '$timeout','Order','form',function ($scope,$timeout,Order, formSrv) {

    $scope.bindForm = formSrv.bind();

    $scope.tbl = {
        data:[],
        order:'id'
    };
    $scope.$parent.OrderResumenPedidoSusCtrl = function (item) {
        $scope.model = {};
        $scope.tbl.data.splice(0, $scope.tbl.data.length );
        $timeout(function () {
            Order.get({type:"Susstitute", id:item.id,tipo:$scope.$parent.formMode.value,doc_id: $scope.$parent.document.id}, {},function(response){
                $scope.pedidoSusPedSelec = response;
                $scope.pedidoSusPedSelec.emision = DateParse.toDate(response.emision);
            });
        },500);
        $scope.LayersAction({search:{name:"resumenPedidoSus" }});
    };

}]);

MyApp.controller('OrderResumenKitchenboxCtrl',['$scope', '$timeout','Order','form',function ($scope,$timeout,Order, formSrv) {

    $scope.bindForm = formSrv.bind();

    $scope.$parent.OrderResumenKitchenboxCtrl = function (item) {
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
        $scope.LayersAction({search:{name:"resumenKitchenbox" }});
    };

    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && formSrv.name == 'OrderResumenKitchenboxCtrl'){
            var data = formSrv.getData();
            if(data.response.accion  == 'new'){
                $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
            }if(data.response.accion  == 'upd'){
                $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
            }

        }
    });

}]);


MyApp.controller('OrderResumenContraPedidoCtrl',['$scope', '$timeout','Order','form',function ($scope,$timeout,Order, formSrv) {

    $scope.bindForm = formSrv.bind();

    $scope.tbl = {
        data:[],
        order:'id'
    };

    $scope.$parent.OrderResumenContraPedidoCtrl = function (data) {
        $scope.model = {};
        $scope.tbl.data.splice(0, $scope.tbl.data.length );
        $timeout(function () {
            Order.get({type:"CustomOrder", id: data.id, doc_id: $scope.$parent.document.id, tipo: $scope.$parent.formMode.value}, {},function (response) {
                angular.forEach(response, function (v, k) {
                    $scope.model[k]= v;
                });
                angular.forEach(response.items, function (v, k) {
                    $scope.tbl.data.push(v);
                });

            });
        },500);
        $scope.LayersAction({search:{name:"resumenContraPedido" }});
    };
    $scope.remove = function (item) {
        Order.post( {type:$scope.$parent.formMode.mod, mod:"DeleteProductItem"},{id:item.reng_id}, function () {
            $scope.NotifAction("ok","Removido",[],{autohidden:1500});
            item.asignado= false;
            item.inDoc= 0;
        });

    };
    $scope.change = function (data) {
        if($scope.allowEdit()){
            $scope.select= data;
            var send = {
                reng_id: data.reng_id,
                origen_item_id:data.id,
                costo_unitario:data.costo_unitario,
                descripcion: data.descripcion,
                codigo: data.codigo,
                codigo_fabrica: data.codigo_fabrica,
                codigo_profit: data.codigo_fabrica,
                doc_id: $scope.$parent.document.id,
                disponible: data.disponible,
                producto_id: data.producto_id,
                uid: data.uid

            };
            if(!data.asignado){
                if(data.asignadoOtro.length == 0){
                    formSrv.name= 'OrderResumenContraPedidoCtrl';
                    $scope.$parent.OrderminiAddProductCtrl(send, {type:$scope.$parent.formMode.mod, mod:"SaveCustomOrderItem"});
                }else {
                    $scope.NotifAction("alert","Este articulo ya sido agregado a otro documento,  por favor confirmanos que desea agregarlo",
                        [
                            {name:"Si, añadirlo ", action: function () {
                                formSrv.name= 'OrderResumenContraPedidoCtrl';
                                $scope.$parent.OrderminiAddProductCtrl(send, {type:$scope.$parent.formMode.mod, mod:"SaveCustomOrderItem"});
                            }},
                            {name:"Cancelar", action: function () {

                            }}
                        ]
                        , {block: true,  save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}} );
                }
            }else{
                $scope.NotifAction("alert", "Esta seguro de remover el articulo selecionado",
                    [
                        {name:"Si, remover el articulo", action: function () {
                            $scope.remove(data);
                        }}
                        ,
                        {name:"Cancelar", action: function () {
                            $scope.remove(data);
                        }}
                    ]
                    ,{block:true})

            }
        }
    };
    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && formSrv.name == 'OrderResumenContraPedidoCtrl'){
            var data = formSrv.getData();
            $scope.select.asignado = (data.response.accion  == 'new' || data.response.accion  == 'upd') ;
            $scope.select.reng_id = data.response.reng_id;
            $scope.select.disponible = data.response.disponible;
            $scope.select.inDoc = data.response.inDoc;
            $scope.select.inDocBlock = data.response.inDocBlock;
            if(data.response.accion  == 'new'){
                $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
            }if(data.response.accion  == 'upd'){
                $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
            }

        }
    });

}]);

MyApp.controller('OrderfinalDocCtrl',['$scope','$timeout', 'App','Order','clickerTime', 'masters','setGetOrder', function ($scope,$timeout,App,Order,clickerTime, masters, setGetOrder) {

    $scope.switchBack=  {
        head:{model:true,change:false},
        contraPedido:{model:true,change:false},
        kichenBox:{model:true,change:true},
        changeItems:{model:true,change:true},
        pedidoSusti:{model:true,change:false}

    };
    $scope.finalDoc = {contra:{},kitchen:{},pedidoSusti:{}, todos:[], document:{}, aprob_gerencia:{}, aprob_compras:{}};
    $scope.$parent.OrderfinalDocCtrl = function () {
        $scope.switchBack=  {
            head:{model:true,change:false},
            contraPedido:{model:true,change:false},
            kichenBox:{model:true,change:true},
            changeItems:{model:true,change:true},
            pedidoSusti:{model:true,change:false}

        };

        $scope.gridViewFinalDoc = 1;
        $scope.action = undefined;
        Order.get({type:$scope.$parent.formMode.mod, mod:"Summary",tipo: $scope.$parent.formMode.value,id: $scope.$parent.document.id},{}, function (response) {
            $scope.finalDoc.productos = response.productos;
        });

        $scope.LayersAction({search:{name:"finalDoc",after:  function () {
            $scope.finalDoc = $scope.$parent.buildfinalDoc();
            console.log("in final final doc", $scope.finalDoc);
        }}});
    };
    $scope.toSideNave = function(elem ,msm, data){

        $scope.NotifAction("alert", msm,[

            {name:"Cancelar", action:function(){
                elem.model= !elem.model;
            }},{name:'Ver', action:function (){
                clickerTime({to:data,time:400});
            }}
        ],{block:true});


    };

    $scope.excepProdFinal = function(item){

        if(!$scope.isOpenexcepAddCP){
            angular.element(document).find("#finalDoc").find("#expand").animate({width:"336px"},400);

            $mdSidenav("excepAddCP").open().then(function(){
                $scope.isOpenexcepAddCP = true;
            });

        }
        $scope.finalProdSelec = item;


    };

    $scope.getAction = function(){
        var accions = [];

        Order.postMod({type:$scope.formMode.mod, mod:"CloseAction"},{id:$scope.$parent.document.id, seccion:$scope.Docsession.global }, function(response){

            if(response.actions){
                accions.push( {name:"Solo Guardar",action:$scope.save});
                if(response.actions.indexOf('sendPrv') != -1){
                    accions.push( {name:"Enviar al proveedor ",action:function () { $scope.send({action:'sendPrv'})}});
                }
                if(response.actions.indexOf('sendIntern') != -1){
                    accions.push( {name:"Informar a departamentos",action:function () { $scope.send({action:'sendIntern', op:response.actions.sendIntern})}});
                }
                accions.push({name:"Cancelar", action:function () {}});
                $scope.NotifAction("alert", "¿Que desea hacer?",accions,{block:true});

            }
        });
    };

    $scope.send = function (data) {
        $scope.action = data.action;
        $scope.$parent.OrderSendMail(data);
    };

    $scope.save = function(){
        if($scope.$parent.formMode.value == 22 && $scope.$parent.document.isAprobado && $scope.$parent.document.condicion_pago_id && !$scope.$parent.document.pago_factura_id){
            $scope.NotifAction("alert","Esta proforma ya tienes los datos suficiente para generar las ordenes de pago, ¿Quieres que creemos la ordenes de pago?",
                [
                    {name:"Si, puedes crearlas", action: function () {
                        Order.postMod({type:$scope.formMode.mod, mod:"MakePayments"},{id:$scope.document.id }, function(response){

                            $scope.OnlySave();
                        });
                    }}
                    ,
                    {name:"No, solo guardar", action: function () {
                        $scope.OnlySave();
                    }}

                ]
                ,{block:true});
        }else{
            $scope.OnlySave();
        }

    };

    $scope.OnlySave= function (fn ) {
        $scope.inProcess = true;
        App.setBlock({block:true,level:89});
        Order.postMod({type:$scope.formMode.mod, mod:"Close"},{id:$scope.document.id }, function(response){
            $scope.inProcess = false;
            App.setBlock({block:false});
            $scope.NotifAction("ok","Realizado",[],{autohidden:1500});
            $scope.updateProv();
            $timeout(function(){
                $scope.LayersAction({close:{all:true, search:true}});
            },1400);
        });
    };





    $scope.canNext = function () {
        if(Object.keys($scope.finalDoc.document).length == 0 &&
            Object.keys($scope.finalDoc.contra).length == 0 &&
            Object.keys($scope.finalDoc.pedidoSusti).length == 0 &&
            Object.keys($scope.finalDoc.import).length == 0 &&
            Object.keys($scope.finalDoc.todos).length == 0
        ){
            $scope.NotifAction("ok","Sin cambios no se realizara ninguna accion",[],{autohidden:2000});
            return false;
        }
        return true;
    };

    $scope.next = function () {
        $scope.getAction();
    }

}]);

MyApp.controller('OrderMenuAgrCtrl',['$scope','Order','masters','clickCommitSrv','setGetOrder', function ($scope,Order,masters,clickCommitSrv,setGetOrder) {

    $scope.$parent.OrderMenuAgrCtrl = function () {
        $scope.LayersAction({close:{all:true}});
        setGetOrder.clear();
        $scope.LayersAction({open:{name:"menuAgr", before: function(){

        }}
        })};

    $scope.newDoc= function(formMode){
        $scope.$parent.formMode=formMode;

        $scope.$parent.OrderDetalleCtrl();

    };

}]);

MyApp.controller('OrderSendMail',['$scope','$mdSidenav','$timeout','$sce', 'App','setGetOrder','Order','masters','SYSTEM', function($scope,$mdSidenav,$timeout,$sce, App, setGetOrder,Order,masters , SYSTEM){

    $scope.origenes = {};
    $scope.correos = [];
    $scope.to = [];
    $scope.cc = [];
    $scope.ccb = [];
    $scope.destinos = [];
    $scope.langs = {};
    $scope.prfLang = '';
    $scope.asunto = undefined;
    $scope.lang = undefined;
    $scope.model = {to:[], cc: [], ccb:[], adjs:[],asunto:undefined, content:''};
    $scope.adjsUp = [];
    $scope.adjsLoaded = [];


    $scope.$parent.OrderSendMail = function (data) {
        $scope.data  = data;
        $scope.LayersAction({search:{name:"OrderSendEmail",before: function(){}}});
        $scope.correos.splice(0,  $scope.correos.length);
        $scope.model.to = [];
        $scope.model.cc = [];
        $scope.model.ccb = [];
        $scope.model.adjs = [];
        $scope.model.action = angular.copy(data.action);
        $scope.model.op = angular.copy(data.op);
        $scope.asunto = undefined;
        $scope.template = '';
        $scope.mailFn.clear();
        $scope.noNew= false;
        Order.getMod({type:$scope.formMode.mod, mod:(data.action == 'sendPrv') ? "ProviderTemplates":'InternalTemplates',id:$scope.document.id},{}, function(response){
            $scope.correos = response.correos;
            $scope.origenes = response.templates;
            $scope.model.tipo = response.tipo;
            if(response.to){
                angular.forEach(response.to, function (v) {
                    $scope.model.to.push(v);
                });
            }
        });



        if(data.action == 'sendPrv'){

        }


    };
    $scope.upfileFinis = function (file) {
        $scope.model.adjs.push(file);
    };

    $scope.canNext = function () {
        if($scope.state == 'load' && $scope.model.to.length > 0){
            return true;
        }else if($scope.state != 'load'){
            $scope.NotifAction("error","Disculpe debes selecionar un idioma para poder enviar el correo ",[],{autohidden:3000});

        }else if($scope.model.to.length  == 0){
            $scope.NotifAction("error","No se han cargado destinatarios",[],{autohidden:3000});
        }

    };

    $scope.next = function () {
        $scope.model.content =$sce.getTrustedHtml($scope.template);
        $scope.model.id = angular.copy($scope.$parent.document.id);
        $scope.inProgress=true;
        App.setBlock({block:true,level:89});
        Order.postMod({type:$scope.formMode.mod, mod:"Send"},$scope.model, function(response){
            if(response.email.is){
                $scope.$parent.NotifAction("ok","Correo enviado",[], {autohidden:2000});
                $timeout(function () {
                    if($scope.$parent.module.historia[1] == 'detalleDoc'){
                        $scope.LayersAction({close:{all:true}});
                    }else{
                        $scope.LayersAction({close:{first:true, search:true}});
                    }
                    $scope.inProgress=false;
                    App.setBlock({block:false,level:0});
                },2200);
            }else{
                $scope.$parent.NotifAction("error", "Ocurrio un error al enviar el correo, si el problema persiste por favor contacte con el administrados, ¿Desea intentar enviar el correo nuevamente? ",
                    [
                        {name:"Reintentar", default:15, action: function () {
                            $scope.resend(response.email.id);
                        }},
                        {name:"Cancelar, lo hare mas tarde", action: function () {

                        }}
                    ]
                    ,{block:true});
            }
        });
    };
    $scope.resend = function (id) {
        Order.post({type:"Mail", mod:"resend"},{id:id}, function (response) {
            if(response.is){
                $scope.$parent.NotifAction("ok","Correo enviado",[], {autohidden:2000});
                $timeout(function () {
                    if($scope.$parent.module.historia[1] == 'detalleDoc'){
                        $scope.LayersAction({close:{all:true}});
                    }else{
                        $scope.LayersAction({close:{first:true, search:true}});
                    }
                    $scope.inProgress=false;
                    App.setBlock({block:false,level:0});
                },2200);
            }else{
                $scope.$parent.NotifAction("error", "Ocurrio un error al enviar el correo, si el problema persiste por favor contacte con el administrados, ¿Desea intentar enviar el correo nuevamente? ",
                    [
                        {name:"Reintentar", default:15, action: function () {
                            $scope.resend(response.id);
                        }},
                        {name:"Cancelar, lo hare mas tarde", action: function () {

                        }}
                    ]
                    ,{block:true});
            }
        });
    };
    $scope.upFiles = function (newVal,olv, data) {
    };
}]);

/**
 * controller for mdsidenav mail, this controller is responsable de send correo option
 * */
MyApp.controller('MailCtrl',['$scope','masters','Order', function($scope, masters,Order){
    $scope.model = {to:[], cc:[], ccb:[],adjs:[], asunto:undefined};
    $scope.inProgress=false;
    $scope.mailSystem =  masters.get({type:"SystemMail"});
    $scope.user =  masters.get({type:"User"});
    $scope.upModel= [];
    $scope.loades = [];
    $scope.correos = [];

    $scope.$parent.openEmail= function(){
        $scope.inProgress=false;
        $scope.load();
        $scope.mode= 'list';
        $scope.model.inMyMail = true;
        $scope.model.to.splice(0, $scope.model.to.length);
        $scope.model.cc.splice(0, $scope.model.cc.length);
        $scope.model.ccb.splice(0, $scope.model.ccb.length);
        $scope.model.adjs.splice(0, $scope.model.adjs.length);
        $scope.model.from = angular.copy($scope.user);
        $scope.btnText = 'Correo de respuesta : '+ angular.copy( $scope.model.from.email);
        $scope.loades.splice(0, $scope.loades.length);
        $scope.$parent.LayersAction({open:{name:"email"}});
    };

    $scope.change= function (data) {
        if(data){
            $scope.model.from = angular.copy($scope.user);
        }  else{
            $scope.model.from = angular.copy($scope.mailSystem);
        }
        if($scope.mode == 'list'){
            $scope.btnText = 'Correo de respuesta : '+ angular.copy( $scope.model.from.email);
        }
    };
    $scope.fnfile = function (item) {
        $scope.model.adjs.push(item);
    };

    $scope.send = function () {
        $scope.inProgress=true;
        Order.post({type:"Mail", mod:"send"},$scope.model, function (response) {
            if(response.email.is){
                $scope.NotifAction("ok","Correo enviado, ¿desea enviar otro?",
                    [
                        {name:"Si, quitar destinararios y adjuntos",action:function () {
                            $scope.mainFn.clear();
                            $scope.AdjFn.clear();
                        }},
                        {name:"Si, Mantener destinararios y adjuntos",action:function () {

                        }},
                        {name:"No",action:function () {
                            $scope.LayersAction({close:{all:true}});
                        }}
                    ]
                    , {block:true});
                $scope.inProgress=false;
            }else{
                $scope.$parent.NotifAction("error", "Ocurrio un error al enviar el correo, si el problema persiste por favor contacte con el administrador, ¿Desea intentar enviar el correo nuevamente? ",
                    [
                        {name:"Reintentar", default:15, action: function () {
                            $scope.resend(response.email.id);
                        }},
                        {name:"Cancelar, lo hare mas tarde", action: function () {

                        }}
                    ]
                    ,{block:true});
            }
        });

    };
    $scope.resend = function (id) {
        Order.post({type:"Mail", mod:"resend"},{id:id}, function (response) {
            if(response.is){
                $scope.NotifAction("ok","Correo enviado, ¿desea enviar otro?",
                    [
                        {name:"Si, quitar destinararios y adjuntos",action:function () {
                            $scope.mainFn.clear();
                            $scope.AdjFn.clear();
                        }},
                        {name:"Si, Mantener destinararios y adjuntos",action:function () {

                        }},
                        {name:"No",action:function () {
                            $scope.LayersAction({close:{all:true}});
                        }}
                    ]
                    , {block:true});
                $scope.inProgress=false;
            }else{
                $scope.$parent.NotifAction("error", "Ocurrio un error al enviar el correo, si el problema persiste por favor contacte con el administrados, ¿Desea intentar enviar el correo nuevamente? ",
                    [
                        {name:"Reintentar", default:15, action: function () {
                            $scope.resend(response.id);
                        }},
                        {name:"Cancelar, lo hare mas tarde", action: function () {

                        }}
                    ]
                    ,{block:true});
            }
        });
    };
    $scope.load=  function () {
        Order.query({type:"Mail", mod:"Providers"},{}, function (response) {
            $scope.correos = response;
        });
    }

}]);


/***mini **/
MyApp.controller('OrderCreateProdCtrl',['$scope','$mdSidenav','$timeout', 'Order','masters','form', function ($scope,$mdSidenav,$timeout,Order,masters,formSrv) {

    $scope.isOpen = false;
    $scope.inProcess = false;

    $scope.$parent.OrderCreateProdCtrl= function (data) {
        if($scope.allowEdit()){
            $scope.almacnAdd = [];
            $scope.model = {};
            $scope.form.$setPristine();
            $scope.form.$setUntouched();
            if(data){
                angular.forEach(data, function (v, k) {
                    $scope.model[k]=v;
                });
            }
            $scope.open();
        }

    };
    masters.query({type:"prodLines"},{}, function (response) {
        $scope.lineas= response;
    });
    masters.query({type:"DirStores"},{}, function (response) {
        $scope.almacn= response;
    });

    $scope.createProduct = function(item){

        /*if(item && item.saldo  && item.descripcion){
         var copy= angular.copy(item);
         copy.prov_id =$scope.provSelec.id;
         Order.post({type:"CreateTemp"},copy,function(response){
         var aux ={
         asignado:false,cantidad:parseFloat(response.cantidad),saldo:parseFloat(response.saldo),codigo:response.codigo,codigo_fabrica :response.codigo_fabrica,
         descripcion :response.descripcion,id: response.id,otre:null,puntoCompra:false,stock:0,tipo_producto:response.tipo_producto,
         tipo_producto_id:response.tipo_producto};
         $timeout(function(){
         aux.asignado= true;
         item = {};

         },0);

         });
         }else{
         if(!item){
         $scope.NotifAction("error","Por favor ingrese una cantidad y una descripcion valida del producto que desea crear",[],{autohidden:autohidden});
         $timeout(function(){
         angular.element.find("#listProducProv #listProducProDescripcion ")[0].focus();
         },0);
         }else{
         if(!item.saldo){
         $scope.NotifAction("error","Por favor ingrese una cantidad del producto que desea crear",[],{autohidden:autohidden});
         $timeout(function(){
         angular.element.find("#listProducProv #listProducProSaldo ")[0].focus();
         },0);
         }else if(!item.descripcion){
         $scope.NotifAction("error","Por favor ingrese una cantidad del producto que desea crear",[],{autohidden:autohidden});
         $timeout(function(){
         angular.element.find("#listProducProv #listProducProDescripcion ")[0].focus();
         },0);
         }
         }


         }*/
    };

    $scope.open = function(fn){
        if(!$scope.isOpen){
            $mdSidenav("OrderCreateProd").open().then(function(){
                $scope.isOpen = true;
                if(fn){
                    fn();
                }
            });
        }
    };

    $scope.inClose = function () {
        $mdSidenav("OrderCreateProd").close().then(function(){
            $scope.isOpen= false;
            $scope.inProcess= false;
        });
    };
    $scope.close = function(e){
        if($scope.isOpen && !$scope.inProcess

        ){ $scope.inProcess= true;
            if(!$scope.form.$pristine){
                if(!$scope.form.$valid ){
                    $scope.NotifAction("alert", "Disculpe no has colocado suficiente informacion como para guardar el producto",
                        [
                            {name:"Dejarme corregirlo", default: 5,action:function () {

                            }},
                            {name:"Cancelar",action:function () {

                            }}
                        ]
                        , {block:true})
                }else{
                    $scope.save(function () {
                        $scope.inClose();
                    });


                }
            }else{
                $scope.inClose();
            }

        }
    };

    $scope.save = function (fn ) {
        Order.post({type:"CreateTemp"},$scope.model,function(response){
            formSrv.setData({model:angular.copy($scope.model), response:response});
            formSrv.setBind(true);
            $timeout(function () {
                formSrv.setBind(false);
            },5);
            $scope.NotifAction("ok", "Articulo creado",[] ,{autohidden: 1500})
            if(fn){
                fn();
            }
        });
    };
    $scope.isAddAlmacen = function(val){
        return $scope.almacnAdd.indexOf(val.id) === -1
    };

    $scope.addAlmacen = function (val) {

        if(val){
            $scope.model.almcenes.push(val);
            $scope.almacnAdd.push(val.id);
            $timeout( function () {
                $scope.almacnText = undefined ;
            },0);

        }
    }

    $scope.removeAlmacen = function (val, index) {
        $scope.almacnAdd.splice(index,1);
        $scope.model.almcenes.splice(index,1);
    };

    $scope.$watch('lineaSelec', function (newVal, oldVal) {
        if(newVal ){
            masters.query({type:"prodSubLines", linea_id: newVal.id},{}, function (response) {
                $scope.subLineas =response;
            });

        }
    });
}]);

MyApp.controller('OrderNrFacturaCtrl',['$scope','$mdSidenav', 'Order','setGetOrder', function ($scope,$mdSidenav,Order,setGetOrder) {
    $scope.upModel = [];
    $scope.adjs = [];
    $scope.model = {};
    $scope.$parent.OrderNrFacturaCtrl = function () {
        $scope.model = {id: angular.copy($scope.$parent.document.id),adjs:[]};
        angular.forEach($scope.$parent.document.nro_factura.adjs, function (v,k) {
            $scope.adjs.push(v);
        });
        $scope.open();
    };
    $scope.fnfile = function (item) {
        $scope.model.adjs.push({archivo_id:item.id,documento:'factura'});
    };
    $scope.uploTe = function (newVal, oldVall, data) {
        if(newVal== 'finish'){
            Order.postMod({type:$scope.formMode.mod, mod:"AddAttachments"},$scope.model, function (response) {
                angular.forEach(response.files, function (v,k) {
                    $scope.$parent.document.nro_factura.adjs.push(v);
                });
            });
        }


    };

    $scope.open = function (fn) {

        $mdSidenav("OrderNrFactura").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderNrFactura").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){
                fn();
            }
        });

    };
    $scope.close= function (e) {
        if($scope.isOpen && !$scope.isProcess){
            $scope.inClose();
        }
    };

}]);

MyApp.controller('OrderNrProformaCtrl',['$scope','$mdSidenav', 'Order','setGetOrder', function ($scope,$mdSidenav,Order,setGetOrder) {
    $scope.upModel = [];
    $scope.loades = [];
    $scope.model = {};
    $scope.fnfile = function (item) {
        $scope.model.adjs.push({archivo_id:item.id,documento:'proforma'});
    };
    $scope.uploTe = function (newVal, oldVall, data) {
        if(newVal== 'finish'){
            Order.postMod({type:$scope.formMode.mod, mod:"AddAttachments"},$scope.model, function (response) {
                angular.forEach(response.files, function (v,k) {
                    $scope.$parent.document.nro_proforma.adjs.push(v);
                });
            });
        }

    };
    $scope.$parent.OrderNrProformaCtrl = function () {
        $scope.model = {id: angular.copy($scope.$parent.document.id),adjs:[]};
        angular.forEach($scope.$parent.document.nro_proforma.adjs, function (v,k) {
            $scope.adjs.push(v);
        });
        $scope.open();
    };
    $scope.open = function (fn) {
        $mdSidenav("OrderNrProforma").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderNrProforma").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){
                fn();
            }
        });

    };
    $scope.close= function (e) {
        if($scope.isOpen && !$scope.isProcess){
            $scope.inClose();
        }
    };



}]);

MyApp.controller('OrderCancelDocCtrl',['$scope','$sce','$timeout',  'App','Order', function ($scope,$sce, $timeout,App, Order) {
    $scope.upModel = [];
    $scope.loades = [];
    $scope.model = {adjs:[],to:[],cc:[], ccb:[]};
    $scope.inProgress = false;

    $scope.fnfile = function (item) {
        $scope.model.adjs.push(item);
    };
    $scope.$parent.OrderCancelDocCtrl = function () {
        $scope.mode = 'list';
        $scope.model.adjs.splice(0,$scope.model.adjs.length);
        $scope.model.to.splice(0,$scope.model.to.length);
        $scope.model.cc.splice(0,$scope.model.cc.length);
        $scope.model.ccb.splice(0,$scope.model.ccb.length);
        $scope.model.comentario = undefined;
        $scope.model.content = undefined;
        $scope.open();
        $scope.mailFn.clear();
    };
    $scope.open = function (fn) {
        Order.getMod({type:$scope.formMode.mod, mod:'InternalCancel',id:$scope.document.id},{}, function(response){
            $scope.correos = response.correos;
            $scope.origenes = response.templates;
            $scope.model.tipo = response.tipo;
            if(response.to){
                angular.forEach(response.to, function (v) {
                    $scope.model.to.push(v);
                });
            }
        });
        $scope.$parent.LayersAction({open:{name:'OrderCancel'}});

    };
    $scope.inClose = function (fn) {


    };

    $scope.canNext = function () {
        if(!$scope.formData.$valid ){
            $scope.NotifAction("error","¡Muy pocos datos! No has colocado suficiente informacion para poder cancelar el documento ",
                [], {autohidden: 3000});
            return false;
        }
        if($scope.state != 'load'){
            $scope.NotifAction("error","Disculpe debes selecionar un idioma para poder enviar el correo ",[],{autohidden:3000});
            return false;

        }else if($scope.model.to.length  == 0){
            $scope.NotifAction("error","No se han cargado destinatarios",[],{autohidden:3000});
            return false;
        }

        return true;
    };

    $scope.next = function () {
        if($scope.model.adjs.length == 0){
            $scope.NotifAction("alert","¡No has cargado adjuntos! es preferible que adjuntes algun documento que soporte la cancelacion.  Confirmanos que no posees ese soporte",
                [
                    {name:"No tengo soporte",default:10, action:function () {
                        $scope.save();
                    }},

                    {name:"Dejame colocarlo", action:function () {

                    }}
                ], {block: true,save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
        }else{
            $scope.save();
        }
    };
    $scope.save = function (fn) {

        $scope.model.id= $scope.$parent.document.id;
        $scope.model.content =$sce.getTrustedHtml($scope.template);
        $scope.NotifAction("ok","¿ Esta seguro de cancelar la "+$scope.formMode.name +" ? ",[
            {name: "Si",
                action:function(){
                    $scope.inProgress = true;
                    App.setBlock({block:true,level:89});
                    Order.postMod({type:$scope.formMode.mod, mod:"Cancel"},$scope.model, function(response){

                        App.setBlock({block:false});
                        if (response.success) {
                            $scope.NotifAction("ok","La "+$scope.formMode.name +" a sido cancelada ",[],{autohidden:2000});
                            $timeout(function () {
                                $scope.inProgress = false;
                                $scope.LayersAction({close:{all:true}});
                            },2500);
                        }
                    });
                }},
            {name:"No", action:
                function(){
                    $scope.mtvCancelacion=undefined;
                }}
        ],{block:true});
    };

}]);

MyApp.controller('OrderminiAddKitchenBoxCtrl',['$scope','$timeout','$mdSidenav','Order','form',  function($scope, $timeout,$mdSidenav,Order, formSrv){

    $scope.defaultUrl =  {type:$scope.$parent.formMode.mod, mod:"SaveProductItem"};
    $scope.block= false;
    $scope.next = undefined;
    $scope.isOpen = false;
    $scope.select ={};
    $scope.event =undefined;
    $scope.$parent.OrderminiAddKitchenBoxCtrl= function (data, url) {
        $scope.url = url;
        $scope.copyTem = angular.copy(data);
        if(!$scope.isOpen){
            $scope.open(function () {

                $scope.select= data;
                $scope.copy = angular.copy(data);
                $scope.copyTem= undefined;
            });
        }

    };
    $scope.close = function (event) {
        if( $scope.isOpen && !$scope.isProcess){
            $scope.isProcess = true;
            var parent = angular.element(event.target).parents("*[OrderminiAddProductCtrl]");
            if(!$scope.prod.$pristine ){
                if(!$scope.validateModel()){
                    $scope.NotifAction("alert", "¡Muy pocos datos! No has colocado suficientes datos como para guardar el producto ",
                        [
                            {name:"Descartar", action: function () {
                                if(parent.length > 0){
                                    $scope.inClose(function () {

                                        $scope.open(function () {
                                            $timeout(function () {
                                                $scope.select=  angular.copy($scope.copyTem);
                                                $scope.copy = angular.copy($scope.copyTem);
                                            },5);
                                        }) ;
                                    });
                                }else{
                                    $scope.inClose();
                                }

                            }},
                            {name:"Corregir", action: function () {
                                $scope.isProcess = false;
                            }}
                        ]
                        ,{block:true});

                }else {
                    $scope.save(function () {
                        if(parent.length > 0){
                            $scope.inClose(function () {
                                $scope.open(function () {
                                    $timeout(function () {
                                        $scope.select=  angular.copy($scope.copyTem); ;
                                        $scope.copy = angular.copy($scope.copyTem);
                                    },5);
                                }) ;
                            });
                        }else{
                            $scope.inClose();
                        }
                    });
                }

            }else {
                if(parent.length > 0){
                    $scope.inClose(function () {
                        $scope.open(function () {
                            $timeout(function () {
                                $scope.select=  angular.copy($scope.copyTem); ;
                                $scope.copy = angular.copy($scope.copyTem);
                            },2);
                        }) ;
                    });
                }else{
                    $scope.inClose();
                }
            }
        }
    };
    $scope.validateModel = function (fn) {
        return $scope.prod.$valid;
    };
    $scope.save = function (fn) {
        if(fn){
            fn();
        }
        var send = angular.copy( $scope.select);
        Order.postMod({
            type: $scope.formMode.mod,
            mod: "SavekitchenBox"
        }, send, function (response) {
            formSrv.setData({model:send, response:response});
            formSrv.setBind(true);
            $timeout(function () {
                formSrv.setBind(false);
            },5);

            if(fn){
                fn();
            }
        });



    };
    $scope.delete = function (fn) {
        /*   $scope.NotifAction("alert","Eliminado",[],{autohidden:1500});*/
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderminiAddKitchenBox").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){
                fn();
            }
        });

    };
    $scope.open = function (fn ) {
        $scope.prod.$setPristine();
        $scope.prod.$setUntouched();
        $mdSidenav("OrderminiAddKitchenBox").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.setData = function (data) {
        $scope.select = data;
    };
}]);

MyApp.controller('OrderminiAddProductCtrl',['$scope','$timeout','$mdSidenav','Order','form', 'setGetOrder', function($scope, $timeout,$mdSidenav,Order, formSrv,$model){

    $scope.defaultUrl =  {type:$scope.$parent.formMode.mod, mod:"SaveProductItem"};
    $scope.block= false;
    $scope.next = undefined;
    $scope.isOpen = false;
    $scope.select ={};
    $scope.event =undefined;
    $scope.$parent.OrderminiAddProductCtrl= function (data, url) {
        if($scope.allowEdit()){
            $scope.url = url;
            $scope.copyTem = angular.copy(data);
            if(!$scope.isOpen){
                $scope.open(function () {

                    $scope.select= data;
                    $scope.copy = angular.copy(data);
                    $scope.copyTem= undefined;
                });
            }
        }


    };
    $scope.close = function (event) {
        if( $scope.isOpen && !$scope.isProcess){
            $scope.isProcess = true;
            var parent = angular.element(event.target).parents("*[OrderminiAddProductCtrl]");
            if(!$scope.prod.$pristine ){
                if(!$scope.validateModel()){
                    $scope.NotifAction("alert", "¡Muy pocos datos! No has colocado suficientes datos como para guardar el producto ",
                        [
                            {name:"Descartar", action: function () {
                                if(parent.length > 0){
                                    $scope.inClose(function () {

                                        $scope.open(function () {
                                            $timeout(function () {
                                                $scope.select=  angular.copy($scope.copyTem);
                                                $scope.copy = angular.copy($scope.copyTem);
                                            },5);
                                        }) ;
                                    });
                                }else{
                                    $scope.inClose();
                                }

                            }},
                            {name:"Corregir", action: function () {
                                $scope.isProcess = false;
                            }}
                        ]
                        ,{block:true});

                }else if($scope.select.disponible  && parseFloat($scope.select.saldo) >   parseFloat($scope.select.disponible)){
                    $scope.NotifAction("alert", "Estas excediendo el limite permitido, por favor confirmanos que es la cantidad correcta ",
                        [
                            {name:"Descartar", action: function () {
                                if(parent.length > 0){
                                    $scope.inClose(function () {
                                        $scope.open(function () {
                                            $timeout(function () {
                                                $scope.select=  angular.copy($scope.copyTem);
                                                $scope.copy = angular.copy($scope.copyTem);
                                            },5);
                                        }) ;
                                    });
                                }else{
                                    $scope.inClose();
                                }
                            }},
                            {name:"Corregir", action: function () {
                                $scope.isProcess = false;
                            }}
                        ]
                        ,{block:true, save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
                }else{
                    $scope.save(function () {
                        if(parent.length > 0){
                            $scope.inClose(function () {
                                $scope.open(function () {
                                    $timeout(function () {
                                        $scope.select=  angular.copy($scope.copyTem); ;
                                        $scope.copy = angular.copy($scope.copyTem);
                                    },5);
                                }) ;
                            });
                        }else{
                            $scope.inClose();
                        }
                    });
                }

            }else {
                if(parent.length > 0){
                    $scope.inClose(function () {
                        $scope.open(function () {
                            $timeout(function () {
                                $scope.select=  angular.copy($scope.copyTem); ;
                                $scope.copy = angular.copy($scope.copyTem);
                            },2);
                        }) ;
                    });
                }else{
                    $scope.inClose();
                }
            }
        }



    };
    $scope.validateModel = function (fn) {
        return $scope.prod.$valid;
    };
    $scope.save = function (fn) {
        var send = angular.copy( $scope.select);
        Order.postMod(($scope.url) ? $scope.url : {type:$scope.$parent.formMode.mod, mod:"SaveProductItem"}, send, function(response){
            $scope.isProcess= false;
            formSrv.setData({model:send, response:response});
            formSrv.setBind(true);

            send.reng_id = response.reng_id;
            if(response.accion == 'new'){
                $model.change("productos"+response.reng_id,undefined,send);
            }else{
                $model.change("productos"+response.reng_id,'cantidad',response.cantidad);
                $model.change("productos"+response.reng_id,'saldo',response.saldo);
                $model.change("productos"+response.reng_id,'reng_id',response.reng_id);
            }
            $timeout(function () {
                formSrv.setBind(false);
            },5);
        });

        $scope.select.asignado= true;
        if(fn){
            fn();
        }
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderminiAddProduct").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){

                fn();
            }
        });

    };


    $scope.open = function (fn ) {
        $scope.prod.$setPristine();
        $scope.prod.$setUntouched();
        $mdSidenav("OrderminiAddProduct").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.setData = function (data) {
        $scope.select = data;
    };


    /*
     $scope.$watch('clikBind.state', function (newVal) {
     if(newVal){
     $timeout(function () {
     var data = commitSrv.get();
     commitSrv.setState(false);
     if(data.commiter == 'OrderminiAddProductCtrl'){
     $scope.inRow = true;
     if(!$scope.isOpen ){
     $scope.prod.$setPristine();
     $scope.prod.$setUntouched();
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);
     $mdSidenav("OrderminiCreatProduct").open().then(function(){
     $scope.isOpen = true;
     $scope.inRow= false;
     });
     }else{
     if($scope.prod.$pristine || !$scope.prod.$valid ){
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);
     }else  if(!angular.equals($scope.select,$scope.copy )) {
     if($scope.validateModel()){
     $scope.NotifAction("alert","¿Deseas guardar las cambios realizados?",
     [
     {name:"Guardar", action: function () {
     $scope.save(function () {
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);
     });
     }},
     {name:"Descartar", action: function () {
     $scope.prod.$setPristine();
     $scope.prod.$setUntouched();
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);

     }}
     ]
     );
     }else{

     }
     }

     }

     }
     },0);

     }
     });
     */

}]);

MyApp.controller('OrderminiChangeItemCtrl',['$scope','$timeout','$mdSidenav','Order','form',  function($scope, $timeout,$mdSidenav,Order, formSrv){

    $scope.block= false;
    $scope.next = undefined;
    $scope.isOpen = false;
    $scope.select ={};
    $scope.event =undefined;
    $scope.noEdit=  false;
    $scope.$parent.OrderminiChangeItemCtrl= function (data, url) {
        if($scope.allowEdit()){
            $scope.noEdit=  false;
            $scope.noEditAsign= false;
            $scope.url = url;
            $scope.copyTem = angular.copy(data);

            if(!$scope.isOpen){
                $scope.open(function () {
                    if(!(data.tipo_origen_id == '1' || data.tipo_origen_id == '2' || data.tipo_origen_id == '3') && data.costo_unitario){
                        $scope.noEdit= true;
                    }
                    if(data.first.tipo_origen_id == '3' || data.tipo_origen_id == '3'){
                        $scope.noEditAsign= true;
                    }
                    $scope.select= data;
                    $scope.copy = angular.copy(data);
                    $scope.copyTem= undefined;
                });
            }
        }

    };

    $scope.close = function (event) {
        if( $scope.isOpen && !$scope.isProcess){
            $scope.isProcess = true;
            var parent = angular.element(event.target).parents("*[OrderminiChangeItemCtrl]");
            if(!$scope.form.$pristine ){
                if(!$scope.form.$valid){
                    $scope.$parent.NotifAction("alert", "No colocaste suficiente informacion para guardar el articulo. ¿Que deseas hacer?",
                        [
                            {name:"Corregir", default:10, action: function () {

                            }},
                            {name:"Cancelar", action: function () {
                                if(parent.length > 0){
                                    $scope.inClose(function () {
                                        $scope.open(function () {
                                            $timeout(function () {
                                                $scope.select=  angular.copy($scope.copyTem); ;
                                                $scope.copy = angular.copy($scope.copyTem);
                                            },2);
                                        }) ;
                                    });
                                }else{
                                    $scope.inClose();
                                }
                            }}
                        ]
                        , {block:true});
                }else{
                    $scope.save(function () {
                        if(parent.length > 0){
                            $scope.inClose(function () {
                                $scope.open(function () {
                                    $timeout(function () {
                                        $scope.select=  angular.copy($scope.copyTem); ;
                                        $scope.copy = angular.copy($scope.copyTem);
                                    },2);
                                }) ;
                            });
                        }else{
                            $scope.inClose();
                        }
                    });
                }

            }else {
                if(parent.length > 0){
                    $scope.inClose(function () {
                        $scope.open(function () {
                            $timeout(function () {
                                $scope.select=  angular.copy($scope.copyTem); ;
                                $scope.copy = angular.copy($scope.copyTem);
                            },2);
                        }) ;
                    });
                }else{
                    $scope.inClose();
                }
            }
        }



    };

    $scope.validateModel = function (fn) {
        return $scope.form.$valid;
    };
    $scope.save = function (fn) {
        Order.postMod(
            {type:$scope.formMode.mod, mod:"ChangeItem"},$scope.select,function(response){
                $scope.NotifAction("ok","Actualizado",[],{autohidden:2000});
                formSrv.setData({model:angular.copy($scope.select), 'response':response});
                formSrv.setBind(true);
                $timeout(function () {
                    formSrv.setBind(false);
                },5);
                if(fn){
                    fn();
                }
            });
    };
    $scope.delete = function (fn) {
        $scope.NotifAction("alert","Eliminado",[],{autohidden:1500});
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderminiChangeItem").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){

                fn();
            }
        });

    };


    $scope.open = function (fn ) {
        $scope.form.$setPristine();
        $scope.form.$setUntouched();
        $mdSidenav("OrderminiChangeItem").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.setData = function (data) {
        $scope.select = data;
    };

    $scope.forceAsign = function () {
        if(!$scope.noEditAsign){
            if($scope.noEdit){
                $scope.NotifAction("alert","Este articulo fue agregado desde otro documento, ¿estas seguro que quieres modificarlo ?",
                    [
                        {name:"Si, modificalo", action: function () {
                            $scope.noEdit = false;
                        }},
                        {name:"Cancelar", action: function () {

                        }}
                    ]
                    , {block:true, save:{doc_origen_id:$scope.$parent.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
            }
        }else{
            $scope.NotifAction("alert","¡Esto no se modifica!, para articulo no se se le suele alterar la cantidad, por favor confirmanos que desea modificarla",
                [
                    {name:"Si, modificalo", action: function () {
                        $scope.noEdit = false;
                        $scope.noEditAsign= false;
                    }},
                    {name:"Cancelar", action: function () {

                    }}
                ]
                , {block:true, save:{doc_origen_id:$scope.$parent.document.id, tipo_origen_id: $scope.$parent.formMode.value, comentario:'para el '+$scope.select.documento+" con el id "+$scope.select.id}});
        }
    };
    $scope.forceCosto = function () {
        if($scope.noEdit){
            $scope.NotifAction("alert","Este articulo fue agregado desde otro documento, ¿estas seguro que quieres modificarlo ?",
                [
                    {name:"Si, modificalo", action: function () {
                        $scope.noEdit = false;
                    }},
                    {name:"Cancelar", action: function () {

                    }}
                ]
                , {block:true, save:{doc_origen_id:$scope.$parent.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
        }
    };

    /*
     $scope.$watch('clikBind.state', function (newVal) {
     if(newVal){
     $timeout(function () {
     var data = commitSrv.get();
     commitSrv.setState(false);
     if(data.commiter == 'OrderminiAddProductCtrl'){
     $scope.inRow = true;
     if(!$scope.isOpen ){
     $scope.prod.$setPristine();
     $scope.prod.$setUntouched();
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);
     $mdSidenav("OrderminiCreatProduct").open().then(function(){
     $scope.isOpen = true;
     $scope.inRow= false;
     });
     }else{
     if($scope.prod.$pristine || !$scope.prod.$valid ){
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);
     }else  if(!angular.equals($scope.select,$scope.copy )) {
     if($scope.validateModel()){
     $scope.NotifAction("alert","¿Deseas guardar las cambios realizados?",
     [
     {name:"Guardar", action: function () {
     $scope.save(function () {
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);
     });
     }},
     {name:"Descartar", action: function () {
     $scope.prod.$setPristine();
     $scope.prod.$setUntouched();
     $scope.select= data.scope;
     $scope.copy = angular.copy(data.scope);

     }}
     ]
     );
     }else{

     }
     }

     }

     }
     },0);

     }
     });
     */

}]);

MyApp.controller('OrderAddAnswer',['$scope','$timeout','$mdSidenav','Order','form',  function($scope, $timeout,$mdSidenav,Order, formSrv) {

    $scope.isOpen = false;
    $scope.isProcess = false;
    $scope.model = {};

    $scope.tbl = {data:[]};
    $scope.adjs = [];
    $scope.$parent.OrderAddAnswer = function (data) {
        $scope.formMode= $scope.$parent.forModeAvilable.getXname(data.documento);
        $scope.model = {adjs:[]};
        $scope.mode= 'list';
        $scope.isUpFile= false;
        angular.forEach(data, function (v, k) {
            $scope.model[k]=v;
        });
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        Order.query({type:$scope.formMode.mod, mod:"Answerds", id:data.id},{}, function (response) {
            angular.forEach(response, function (v, k) {
                $scope.tbl.data.push(v);
            });
        });
        $scope.open();
    };

    $scope.open = function () {
        $mdSidenav("OrderAddAnswer").open().then(function(){
            $scope.isOpen = true;
            angular.element(document).find("#OrderAddAnswer").find("#textarea").focus();
        });
    };

    $scope.save= function (fn ) {
        Order.postMod(
            {type:$scope.formMode.mod, mod:"AddAnswer"},$scope.model,function(response){
                $scope.NotifAction("ok","Se agregado la respuesta del proveedor al documento ",[],{autohidden:2500});
                $scope.tbl.data.push(response.model);
                if(fn){
                    fn();
                }
            });
    };
    $scope.close= function () {
        if($scope.isOpen &&  !$scope.isProcess){
            $scope.isProcess = true;
            if(!$scope.form.$pristine || $scope.isUpFile){
                if(!$scope.form.$valid){
                    $scope.NotifAction("alert","No has colocado una descripcion! por favor dinos a que conclusion has llegado con el proveedor ",
                        [
                            {name:"Dejame agregarla", action: function () {

                            }},

                            {name:"Cancelar", action: function () {
                                $scope.inclose();
                            }}
                        ]
                        , {block:true})
                }else{
                    $scope.save(function () {
                        $scope.inclose();
                    });
                }
            }else{
                $scope.inclose();
            }

        }
    };
    $scope.inclose = function () {
        $mdSidenav("OrderAddAnswer").close().then(function () {
            $scope.isOpen = false;
            $timeout(function () {
                $scope.mode= 'list';
                $scope.isProcess= false;
            },500);
        });
    };

    $scope.fnfile = function (item) {
        $scope.isUpFile= true;
        $scope.model.adjs.push(item);
    };

}]);

MyApp.controller('OrderAprobCtrl',['$scope','$mdSidenav', 'Order','setGetOrder', function ($scope,$mdSidenav,Order,setGetOrder) {
    $scope.upModel = [];
    $scope.loades = [];
    $scope.model = {};
    $scope.fnfile = function (item) {
        $scope.model.adjs.push(item);
    };
    $scope.$parent.OrderAprobCtrl = function () {
        $scope.formData.$setPristine();
        $scope.formData.$setUntouched();
        if($scope.allowEdit() && !$scope.$parent.document.isAprobado){
            $scope.model = {adjs:[]};
            $scope.open();
            if($scope.$parent.document.isAprobado){
                $scope.model.nro_doc= angular.copy($scope.$parent.document.aprobado.nro_doc);
                angular.forEach($scope.$parent.document.aprobado.adjs, function (v, k) {
                    $scope.model.adjs.push(v);
                });
            }
        }

    };
    $scope.open = function (fn) {
        $mdSidenav("OrderAprob").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderAprob").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){
                fn();
            }
        });

    };
    $scope.close= function (e) {
        if($scope.isOpen && !$scope.isProcess){
            if(!$scope.formData.$pristine){
                if(!$scope.formData.$valid){
                    $scope.NotifAction("alert","¡Muy pocos datos! No has colocado suficiente informacion para poder aprobar ",
                        [
                            {name:"Corregir",default:5, action:function () {

                            }},

                            {name:"Cancelar", action:function () {
                                $scope.inClose();
                            }}
                        ], {block: true});
                }else if($scope.model.adjs.length == 0){
                    $scope.NotifAction("alert","¡No has cargado adjuntos! es preferible que adjuntes algun documento que soporte la aprobacion.  Confirmanos que no posees ese soporte",
                        [
                            {name:"No tengo soporte",default:15, action:function () {
                                $scope.save(function () {
                                    $scope.inClose();
                                });
                            }},

                            {name:"Dejame subirlo", action:function () {
                                $scope.inClose();
                            }}
                        ], {block: true, save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
                }else {
                    $scope.save(function () {
                        $scope.inClose();
                    });
                }
            }else{
                $scope.inClose();
            }

        }
    }
    $scope.save = function (fn) {
        $scope.model.id= $scope.$parent.document.id;
        Order.postMod({type:$scope.formMode.mod, mod:"Approved"},$scope.model,function(response){
            if(response.accion == 'ap_gerencia'){
                $scope.NotifAction("ok","Se ha realizado la aprobacion por parte de gerencia",[],{autohidden: 1500});
                $scope.$parent.document.fecha_aprob_gerencia = angular.copy($scope.model.fecha);
                $scope.$parent.document.isAprobado= true;
                setGetOrder.change('fecha_aprob_gerencia', 'fecha', $scope.model.fecha );
                setGetOrder.change('fecha_aprob_gerencia', 'nro_doc', $scope.model.nro_doc );
            }
            if(response.accion == 'ap_compras'){
                $scope.NotifAction("ok","Se ha realizado la aprobacion por parte de compras",[],{autohidden: 1500});
                $scope.$parent.document.fecha_aprob_compras = angular.copy($scope.model.fecha);
                $scope.$parent.document.isAprobado= true;
                setGetOrder.change('fecha_aprob_compra', 'fecha', $scope.model.fecha );
                setGetOrder.change('fecha_aprob_compra', 'nro_doc', $scope.model.nro_doc );

            }
            if(fn){
                fn()
            }
        });
    };


}]);

MyApp.controller('OrderModuleMsmCtrl',['$scope','$mdSidenav','Order','masters','clickCommitSrv','setGetOrder', function ($scope,$mdSidenav,Order,masters,clickCommitSrv,setGetOrder) {



    $scope.$parent.getAlerts = function(){
        Order.query({type:'Notifications'},{}, function(response){
            $scope.$parent.alerts  = response;
            $scope.$parent.OrderModuleMsmCtrl();
        });

    };

    $scope.openNoti = function(item){
        switch (item.key){
            case "priorityDocs":
                $scope.$parent.OrderPriorityDocsCtrl();
                break;
            case "unclosetDoc":
                $scope.$parent.OrderUnclosetDocCtrl();
                break;
        };
        $mdSidenav("moduleMsm").close();


    };
    $scope.$parent.OrderModuleMsmCtrl = function () {
        if($scope.$parent.alerts.length > 0){
            $mdSidenav("moduleMsm").open().then(function () {
                $scope.isOpen= true
            });
        }

    };

    $scope.close= function(e){
        if($mdSidenav("moduleMsm").isOpen() &&  $scope.isOpen){
            $mdSidenav("moduleMsm").close().then(function () {
                $scope.isOpen= false;
            });
        }
    };

}]);

/***no gui **/
MyApp.controller('OrderAccCopyDoc',['$scope','Order','setGetOrder', function ($scope,Order) {

    $scope.copy= function () {
        Order.postMod({type:$scope.formMode.mod, mod:"Copy"},{id:$scope.$parent.document.id}, function(response){

            $scope.$parent.OrderDetalleCtrl({id:response.id,tipo: $scope.$parent.formMode.value }, function () {
                $scope.NotifAction("ok","Nueva version creada",[],{autohidden:2000});
                $scope.Docsession.block= false;
                //  setGetOrder.change("document", 'id', response.id);
            });


        });
    }

    $scope.$parent.copyDoc = function() {
        $scope.$parent.NotifAction("alert","Esta seguro de crear una copia del documento actual",
            [
                {name:"Duplicar", action:$scope.copy} ,
                {name:"Cancelar", action:function () {

                }}
            ]
            ,{block:true});

    };
}]);

MyApp.controller('OrderUpdateDoc',['$scope','Order','setGetOrder', function ($scope,Order,$model) {

    $scope.updateForm = function () {
        $scope.Docsession.block=false;
        $scope.Docsession.isCopyableable=false;
        Order.postMod({type:$scope.formMode.mod,mod:"Update"},{id: $scope.document.id},function(response){
            $scope.isTasaFija=true;
            var mo= jQuery("#"+$scope.layer).find("md-content");
            mo[0].focus();
            if(response.id){
                $model.reload({id:response.id, tipo:$scope.$parent.formMode.value});
            }
        });
        $model.change("document","final_id", undefined);
        $model.setState('upd');
        $scope.Docsession.global='upd';
    };

}]);


/**globales */

MyApp.controller("LayersCtrl",function($mdSidenav,$timeout, Layers, $scope){

    $scope.accion= Layers.getAccion();
    $scope.$watch("accion.estado", function(newVal){
        if(newVal){
            var module = Layers.getModule();
            var arg = $scope.accion.data;
            $timeout(function () {
                $scope.accion.estado=false;
            },0);
            $timeout(function () {
                if(arg.open){
                    open(arg.open, module);
                }else
                if(arg.close){

                    close(arg.close,module);
                }else
                if(arg.search){
                    search(arg.search, module);
                }
            },0);


        }
    });

    function callfn (fn){
        var res=fn();

        if(res == false){
            return false;
        }
        return true;
    }

    function search(arg, module){
        if(!module.block){
            var acc = angular.copy(arg);
            if (module.historia.indexOf(arg.name) == -1){
                open(acc, module);
            }else{
                close(acc, module);
            }
        }
    }
    function close(arg, module){
        if(module.index>0 && !module.block){
            var close =1;
            var paso=true;
            if(arg.before){
                paso= callfn(arg.before);
                close = paso ? 1 : 0;
            }



            if(paso){
                if(arg.name){
                    var aux = module.historia.indexOf(arg.name);
                    close = (aux != -1) ? ((module.historia.length -1)  - aux ) : 0;

                }
                else if(arg.to){
                    close = arg.to;

                }else if(arg.all){
                    close = module.index ;
                }else if(arg.first ){
                    close = module.index -1;
                }
            }
            paso = (close != 0) ;

            if(paso){
                module.block=true;

                var current= module.index;


                var  l;
                for( var i=0; i<close -1;i++){
                    l = module.historia[current];
                    $mdSidenav(l).close().then(function(){
                        /*

                         if(arg.after){
                         arg.after();
                         }
                         */

                    });
                    module.historia.splice(-1);
                    current--;

                }
                var  l = module.historia[current];
                $mdSidenav(l).close().then(function(){

                    if(arg.after){
                        arg.after();
                    }

                });
                module.historia.splice(-1);
                current--;




                module.index= current;
                module.layer = module.historia[module.index];
                module.block= false;
                if(arg.search){
                    if(module.layer){
                        if(module.layers[module.layer].after){
                            callfn(module.layers[module.layer].after);
                        }

                    }


                }
            }else {
                if(arg.after){
                    arg.after();
                }
            }

        }
    }
    //**operacion apertura */
    function open(arg, module){
        var paso= true;
        if (module.historia.indexOf(arg.name) == -1) {
            if(arg.before){
                paso= callfn(arg.before);

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
                module.layers[arg.name]= arg;
                module.layer = arg.name;
                return true;
            }

        }
        return false;
    }
});


/*
 Servicio que almacena la informacion del docuemnto y monitoriza cambios
 */
MyApp.service('setGetOrder', function(DateParse, Order, providers, $q) {

    var forms ={};
    var interno= 'new';
    var externo= 'new';
    var order={};
    var data = {};
    var bindin ={estado:false};

    var change = function(form,fiel, value){

        var exist= true;

        if(!forms[form]){
            forms[form]={};
            exist=false;


        }

        if(!forms[form][fiel] ){
            if(typeof (value) == 'object'){

                angular.forEach(value, function(v2,k2){
                    if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !isNaN(k2)){
                        forms[form][k2]= {original:v2, v:v2, estado:'created',trace:[]};
                    }
                });
            }else{
                forms[form][fiel] = {original:value, v:value, estado:'created',trace:[]};
            }
            exist=false;

            interno='upd';
        };

        if( exist){
            if(typeof (value) == 'undefined' &&  forms[form][fiel]){
                forms[form][fiel].estado='del';
                forms[form][fiel].trace.push();
            }else if(forms[form][fiel].original != value  ){
                forms[form][fiel].v= value;
                forms[form][fiel].trace.push(value);
                forms[form][fiel].estado='upd';
                interno='upd';

            }else
            if(forms[form][fiel].original == value ){
                forms[form][fiel].estado='new';
                forms[form][fiel].trace.push(value);
                forms[form][fiel].v= value;
                var band= "new";
                if(interno != 'new'){
                    angular.forEach(forms[form], function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(forms[form][fiel].estado != 'new' ){
                                band='upd'
                            }
                        });
                    });
                    interno=band;
                }

            }
        }


    };
    return {

        bind: function(){
            return  bindin;
        },
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
        change:function(form,fiel, value){
            externo='upd';
            change(form,fiel, value);

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
            order ={};
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
        ,
        setOrder : function(doc){
            // order={};
            if(doc.id && doc.tipo){
                bindin.estado=false;
                Order.get({type:"Document", id:doc.id,tipo: doc.tipo}, {},function(response) {
                    order ={};
                    order.emision = DateParse.toDate(response.emision);
                    order.monto = parseFloat(response.monto);
                    order.tasa = parseFloat(response.tasa);
                    forms = {};
                    forms['document']={};
                    order['objs'] ={};
                    forms['document']['monto'] =  {original:response.monto, v:response.monto, estado:'new',trace:[]};
                    forms['document']['tasa'] =  {original:response.tasa, v:response.tasa, estado:'new',trace:[]};

                    if (response.fecha_aprob_compra = !null && response.fecha_aprob_compra) {
                        order.fecha_aprob_compra = DateParse.toDate(response.fecha_aprob_compra);
                    }

                    if (response.ult_revision = !null && response.ult_revision) {
                        order = DateParse.toDate(response.ult_revision);
                    }



                    angular.forEach(response,function(v,k){
                        if(!order[k]){
                            order[k]= v;
                            if(v !=null && typeof (v) != 'object' && typeof (v) != 'array' && isNaN(k)){
                                forms['document'][k]={original:v, v:v, estado:'new',trace:[]};
                            }

                        }
                    });


                    angular.forEach(response.productos.contraPedido, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && isNaN(k2)){
                                if(!forms['contraPedido'+ v.id]){
                                    forms['contraPedido'+ v.id] ={};
                                }
                                forms['contraPedido'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });
                    angular.forEach(response.productos.kitchenBox, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && isNaN(k2)){
                                if(!forms['kitchenBox'+ v.id]){
                                    forms['kitchenBox'+ v.id] ={};
                                }
                                forms['kitchenBox'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });

                    angular.forEach(response.productos.pedidoSusti, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && isNaN(k2)){
                                if(!forms['pedidoSusti'+ v.id]){
                                    forms['pedidoSusti'+ v.id] ={};
                                }
                                forms['pedidoSusti'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });
                    angular.forEach(response.productos.todos, function(v){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && isNaN(k2)){
                                if(!forms['todos'+ v.id]){
                                    forms['todos'+ v.id] ={};
                                }
                                forms['todos'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:[]};
                            }

                        });
                    });
                    angular.forEach(response.objs, function(v,k){
                        order['objs'][k]=v;
                    });
                    bindin.estado=true;
                })
            }
        },
        reload: function(doc){
            doc= (doc) ? doc : {id:order.id, tipo:order.tipo};
            bindin.estado=false;
            order.id=doc.id;
            Order.get({type:"Document", id:doc.id,tipo: doc.tipo}, {},function(response) {
                order.emision = DateParse.toDate(response.emision);
                order.monto = parseFloat(response.monto);
                order.tasa = parseFloat(response.tasa);
                if (response.fecha_aprob_compra = !null && response.fecha_aprob_compra) {
                    order.fecha_aprob_compra = DateParse.toDate(response.fecha_aprob_compra);
                }

                if (response.ult_revision = !null && response.ult_revision) {
                    order = DateParse.toDate(response.ult_revision);
                }
                order.productos.contraPedido.splice(0,order.productos.contraPedido.length);
                order.productos.kitchenBox.splice(0,order.productos.kitchenBox.length);
                order.productos.pedidoSusti.splice(0,order.productos.pedidoSusti.length);
                order.productos.todos.splice(0,order.productos.todos.length);

                angular.forEach(response.productos.contraPedido, function(v){
                    order.productos.contraPedido.push(v);
                });
                angular.forEach(response.productos.kitchenBox, function(v){
                    order.productos.kitchenBox.push(v);
                });
                angular.forEach(response.productos.pedidoSusti, function(v){
                    v.emision = DateParse.toDate(v.emision);
                    order.productos.pedidoSusti.push(v);
                });
                angular.forEach(response.productos.todos, function(v){
                    order.productos.todos.push(v);
                });
                angular.forEach(response,function(v,k){
                    if(typeof (order[k]) == 'string' ){
                        order[k]= v;

                    }
                });
                angular.forEach(response.objs, function(v,k){
                    order['objs'][k]=v;
                });
                bindin.estado=true;

            });


        },
        getOrder : function(){
            return order;
        },
        clear: function(){
            forms ={};
            interno= 'new';
            externo= 'new';
            angular.forEach(order, function (v, k) {
                delete order[k];
            });
            data = {};
            bindin.estado=false;
        }


    };
});

MyApp.service('emails', function(){
    var email = [];

    return {
        getEmails : function(){
            return email;

        },
        setEmails : function (data){
            email.splice(0,email.length);
            angular.forEach(data, function(v){
                email.push(v);
            });
        }, clear: function(){
            email.splice(0,email.length);
        }
    }
});

MyApp.service('IsEmail', function() {
    return function (text){
        var reg = new RegExp("^[A-Za-z]+[^\\s\\+\\-\\\\\/\\(\\)\\[\\]\\-]*@[A-Za-z]+[A-Za-z0-9]*\\.[A-Za-z]{2,}$");

        if(!reg.test(text)){
            return null;
        }
        return text
    }
});

MyApp.service('clickerTime',['$timeout', function($timeout){
    return function (data){
        var index= (data.time) ? data.time : 400;
        var sume =  (data.time) ? data.time : 400;
        angular.forEach(data.to, function(v,k){
            $timeout(function(){
                var clicker=angular.element(v);
                clicker[0].click();
                if(data.calback && k == data.to.length -1){
                    data.calback();
                }
            },index);
            index = index + sume;
        });
    };
}]);
/**
 *
 * Servicio encargado de la realizacion de peticiones del modulo de pedidos
 * @param type especifica el documento a hacer la peticion['Order', 'Purchase','Solicitude']
 * @param mod accion a realizar ['update', 'save'....]
 * */
MyApp.factory('Order', ['$resource','$q','App',
    function ($resource,$q, App) {

        return $resource('Order/:type/:mod', {}, {
            query: {method: 'GET',params: {type: ""}, isArray: true, interceptor:
            {
                'response': function(response) {
                    return response.data;
                },
                'responseError': function(rejection) {

                    return $q.reject(rejection);
                }
            }
            },
            get: {method: 'GET',params: {type:""}, isArray: false},
            html: {method: 'GET',params: {type:""},isArray: false ,headers: { 'Content-Type': 'text/html' }},
            htmlMod: {method: 'GET',params: {type:"", mod:""},isArray: false ,headers: { 'Content-Type': 'text/html' }},
            post: {method: 'POST',params: {type:" "}, isArray: false},
            postMod: {method: 'POST',params: {type:" ",mod:""}, isArray: false},
            getMod: {method: 'GET',params: {type:"",mod:""}, isArray: false},
            queryMod: {method: 'GET',params: {type: "", mod:""}, isArray: true},
            postAll: {method: 'POST',params: {type:" "}, isArray: false}

        });
    }
]);


/**
 *
 * fabrica de objetos ideales para $watch de angular
 *
 * */
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


/**
 * filtro paraa poder visualizar codigo html que venga de peticiones
 * */
MyApp.filter("sanitize", ['$sce', function($sce) {
    return function(htmlCode){
        return $sce.trustAsHtml(htmlCode);
    }
}]);


/**
 * valida campos del formulario, solo admite numeros y puntos
 * */
MyApp.directive('decimal', function () {
    return {
        require: 'ngModel',
        link: function (scope, elem, attrs,ctrl) {

            elem.bind("keydown",function(e){
                var key = window.Event ? e.which : e.keyCode;

                if(!((key >= 48 && key <= 57) || (key==8)  || (key==16)  ||
                    (key >= 96 && key <= 105) || key == 188 || key == 190 ||key == 110 )   ){
                    e.preventDefault();
                }
            });

            ctrl.$validators.decimal = function(modelValue, viewValue) {

                if(viewValue === undefined || viewValue=="" || viewValue==null || viewValue == 'NaN' || !viewValue.match){
                    return true;
                }
                var  num = viewValue.match(/^\-?(\d{0,3}\.?)+\,?\d{1,3}$/);

                return !(num === null)
            };

        }
    };
});

MyApp.directive('loader', function() {

    return {
        replace: true,
        transclude: true,
        link: function(scope, element){
            element.addClass("loader");
            element.removeAttr("loader");
        },
        templateUrl:"modules/home/loader"
    };
});


MyApp.directive('vlNext', function($timeout, vlNextSrv) {

    return {
        replace: true,
        controller: 'vlNextCtrl',
        scope:{
            'show' : "=vlShow",
            'click': '=?click'
        },
        link: function(scope, elem, attr, ctrl){

        },
        template: function(elem, attr){
            return ' <div style="width: 16px;" ng-mouseenter="showNext($event, click, show, this);" > </div>';
        }
    };
});

MyApp.controller('vlNextCtrl', ['$scope','$mdSidenav','vlNextSrv', function ($scope,$mdSidenav,vlNextSrv) {


    $scope.showNext = function (e, click, show, all) {
        if (e ) {
            vlNextSrv.set({click:click,show:show, all: all});
            if(show){
                console.log("tiene show", e);
                if(show()){

                    if(show()){
                        $mdSidenav("NEXT").open().then(function () {
                        });
                    }
                }
            }
        }else{
            $mdSidenav("NEXT").close().then(function () {

            });
        }
    }

    // en el scopde de next
    $scope.clicker = function (e) {
        var event = vlNextSrv.get();
        event.click(event);
    }

}]);

MyApp.service('vlNextSrv',function () {
    var call = undefined;
    return {
        set : function (data) {
            console.log("in service", data)
            call= data;
        }, get : function () {
            return call;
        }
    }
});
MyApp.directive('alert', function(setNotif) {

    return {
        scope: {
            alert: '=',
            alertShow:'='
        },
        link: function(scope, element){
            element.on("focus","input", function(e) {
                if(scope.alert[scope.alertShow]){
                    setNotif.addNotif("alert",scope.alert[scope.alertShow],[],{autohidden:5000});
                }
            });


        }
    };
});

/*

 MyApp.directive('vlcGridOrdder', function($compile) {


 return {
 replace: true,
 require: 'ngModel',
 transclude: true,
 link: function(scope, elem, attr,ctrl){
 elem.removeAttr("vlc-grid-order");
 var up = angular.element("");
 var html =
 '<div  class=\'cell-filter-order\' layout-align=\'center center\'  >' +
 '<div ng-click=' + (attr.ngModel) + '=\''
 + attr.key +
 '\'> <img ng-src={{('+  attr.ngModel + ' == \'' + attr.key + '\' ) ? \'images/TrianguloUp.png\' : \'images/Triangulo_2_claro-01.png\ }> </div>' +
 '</div>';
 elem.html(html);
 //$compile(elem[0])(scope);
 }
 /!*
 template:function(elem, att){

 return '<div>"value"</div>'

 /!* return "<div class='cell-filter-order' layout-align='center center'> " +
 '<div ng-click="value"= '+"'"+att.key+"'" + '>' +
 '<img ng-src= {{("value" == '+"'"+att.key+"'" +") ? 'images/TrianguloUp.png' :  'images/Triangulo_2_claro-01.png'}} >"
 +
 "</div>"+
 "</div>";*!/
 /!*
 return '<div class="cell-filter-order" layout-align="center center" >' +
 '<div ng-click="value" = '+"'" + att.key +"'" +'> <img ng-src="{{(docOrder.order == 'documento') ? 'images/TrianguloUp.png' : 'images/Triangulo_2_claro-01.png'}}" </div>'+
 '</div>';
 *!/
 }
 *!/


 };
 });


 */
