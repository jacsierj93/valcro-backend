
MyApp.controller('PedidosCtrll', function ($scope,$mdSidenav,$timeout,$interval
    ,$filter,$location,App, Order,masters,providers,
                                           Upload,Layers,setGetOrder, DateParse, Accion,clickerTime) {

    $scope.permit= Order.get({type:"Permision"});
    // controlers
    $scope.Docsession = {isCopyable:false,global:"new", block:true};
    $scope.formMode ={};
    $scope.layer= undefined;
    $scope.index= 0;
    /*
     $scope.formData ={direccionesFact:[],monedas:[], paises :[], condicionPago:[] , direcciones:[], puertos:[]};
     */
    /*
     $scope.formDataContraP ={};
     */
    /*
     $scope.clickerTime = clickerTime;
     */

    // filesService.setFolder('orders');
    // $scope.filesProcess = filesService.getProcess();

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

    var timePreview;


    $scope.showFilterPed=false;
    $scope.showLateralFilter=false;
    $scope.showLateralFilterCpl=false;
    $scope.imgLateralFilter="images/Down.png";
    $scope.selecPed=false;
    $scope.preview=true;
    $scope.mouseProview= false;
    $scope.provSelec ={};
    $scope.document  = setGetOrder.getOrder();
    $scope.docBind= setGetOrder.bind();
    $scope.todos =[];

    /*
     // final doc

     */

    //// tablas

    /*    $scope.docOrder ={};
     $scope.docOrder.order ='id';*/
    Order.query({type:"OrderProvList"},{},function(response){
        $scope.todos = response;
    });

    /****filtros para todas las tablas de documentos*/
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

                    if(compare.titulo){
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
    /**final @deprecated*/
    $scope.setProvedor =function(prov, all) {

    };

    $scope.openVersions  = function (){
        $scope.LayersAction({open:{name:"oldDocs",
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

    $scope.openOld = function (data){

        $scope.NotifAction("ok", "¿Que desea hacer?",
            [
                {name:"Ver la "+$scope.formMode.name ,
                    action : function(){
                        $scope.oldVersionSelect = data;
                        $scope.LayersAction({open:{name:"resumenOldDoc"}});
                    }
                },
                {name:"Regresar a esta version  de la "+$scope.formMode.name,
                    action: function(){
                        Order.postMod({type:$scope.formMode.mod, mod:"Restore"},{princ_id:$scope.document.id,reemplace_id:data.id},function(response){
                            setGetOrder.reload({id:response.id,tipo: $scope.formMode.value});
                            $scope.LayersAction({search:{name:"detalleDoc", search:true}});
                        });
                    }
                },
                {
                    name:"Cancelar",
                    action : function(){

                    }
                }
            ],{block:true}
        );
    };

    /**Clear form head */
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

    $scope.oldReviewDoc = function (){

    };



    $scope.redirect = function(data){
        alert("redirect " +data.field);
        App.changeModule(data);
    };


    /********************************************GUI ********************************************/

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

    $scope.FilterListPed = function(){
        $scope.showFilterPed = ($scope.showFilterPed) ? false : true;
    };

    $scope.FilterLateral = function(){
        if(!$scope.showLateralFilter){
            jQuery("#menu").animate({height:"258px"},500);
            $scope.showLateralFilter=true;
        }
    };

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

    $scope.filtOpen= function(){
        $scope.isOpen = ($scope.isOpen) ? false : true;
    };


    /******************************************** ROLLBACK SETTER **/

    $scope.toEditHead= function(id,val){
        if( $scope.Docsession.global != 'new'){
            setGetOrder.change("document",id,val);
        }

    };


    $scope.verificExit = function(){
        var paso = true;
        if(!$scope.Docsession.block && $scope.document.id){
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
            var data =[];
            angular.forEach(items, function(v){
                data.push({id: v.id, documento:$scope.folder});
                setGetOrder.change("adjunto"+ v.id,'id', v.id);
            });
            Order.postMod({type:$scope.formMode.mod, mod:"AddAdjuntos", tempId:$scope.Docsession.Temuid},
                {id:$scope.document.id,adjuntos: data}, function(response){
                    $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                    if($scope.document.id){
                        setGetOrder.reload();
                    }else{
                        $scope.Docsession.Temuid= response.id;
                    }

                });
            $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
            //$scope.NotifAction
        }else if(newVal == "error"){
            $scope.NotifAction('error', "No se pudieron subir los archivos",[],{autohidden:autohidden});
            filesService.getRecentUpload();
        }


    });

    $scope.allowEdit = function(){


        if($scope.Docsession.block){
            if(!$scope.document.permit.update){
                $scope.NotifAction("error","No tiene para realizar esa accion ",[],{autohidden:2500});
                return false;
            }else{
                $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder modificar",[],{autohidden:2500});
                return false;
            }
        }
        return true;
    };

    $scope.hoverpedido= function(document){
        document.isNew=false;

        $timeout(function(){
            if(document &&  $scope.mouseProview){
                $scope.formMode=$scope.forModeAvilable.getXValue(document.tipo);
                //setGetOrder.setOrder(document);
                $scope.resumen=document;

                if($scope.module.layer !='resumenPedido' ){
                    $scope.LayersAction({open:{name:"resumenPedido"}});
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
                $scope.LayersAction({close:true});
                $scope.hoverPreview(true);
            }
        }, 1000);


    };

    $scope.hoverEnter=  function(){
        $scope.mouseProview= true;
    };
    $scope.hoverPreview= function(val){
        $scope.preview=val;
        if(val== false){
            // delete $scope.resumen;
        }
    };



    $scope.updateForm = function () {
        $scope.Docsession.block=false;
        $scope.Docsession.isCopyableable=false;
        Order.postMod({type:$scope.formMode.mod,mod:"Update"},{id: $scope.document.id},function(){
            $scope.isTasaFija=true;
            var mo= jQuery("#"+$scope.layer).find("md-content");
            mo[0].focus();
        });
        setGetOrder.change("document","final_id", undefined);
        $scope.Docsession.global='upd';
    };
    /***@deprecated **/

    $scope.closeTo = function(layer){
        $scope.LayersAction({close:layer});

    };

    $scope.delete = function(doc){
        $scope.NotifAction("alert", "¿Esta seguro  de eliminar "+doc.documento+"?",
            [
                {name:"Cancelar",action: function(){

                }
                },{name:"Si, estoy seguro ", action:function(){
                Order.postMod({type:$scope.formMode.mod, mod:"Delete"},$scope.document, function(response){

                });
            }}
            ],{block:true});

    };





    /********************************************DEBUGGIN ********************************************/


    $scope.test = function (test) {
        $scope.OrderCreatProduct();
    };

    $scope.demo = function(){
        $scope.openMailPreview(function(){alert("dsf");});



    };
    /********************************************DEBUGGIN ********************************************/



    /******************************************** filtros ********************************************/

    $scope.EqualsDate = function(current,compare){
        var patern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
        if( patern.test(compare)){
            var dc=new Date(Date.parse(current));
            var m;
            if ((m = patern.exec(compare)) !== null) {
                var aux, dcp;
                if(m[0].indexOf('-') != -1){
                    aux = m[0].split('-');
                    dcp = new Date(aux[1]+"-"+aux[0]+"-"+aux[2])


                }else if(m[0].indexOf('/') != -1){
                    aux = m[0].split('/');
                    dcp = new Date(aux[1]+"-"+aux[0]+"-"+aux[2]);
                }
                return dc.getDate() == dcp.getDate() &&  dc.getFullYear() == dcp.getFullYear() && dc.getMonth() == dcp.getMonth()
            }
        }
        return false;
    };

    $scope.searchCountry = function(item,texto){
        return item.short_name.indexOf(texto) > -1;
    };

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

    $scope.searchXText = function(data, text, key){

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

    $scope.searchEmails= function(){
        return $scope.email.contactos;
    };


    /******************************************** APERTURA DE LAYERS ********************************************/

    $scope.openSide = function(name){

        $scope.navCtrl.value = name;
        $scope.navCtrl.estado=true;

    };


    $scope.openAdj = function(folder){
        if($scope.document.id){
            filesService.open();
            var items = [];
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
            filesService.open();
            $scope.folder = folder;
            filesService.setTitle(folder);
        }



    };




    $scope.menuAgregar= function(){
        $scope.LayersAction({close:{all:true}});
        $scope.LayersAction({open:{name:"menuAgr", before: function(){

            setGetOrder.clear();
        }}});
        $scope.gridView= 1;
        $scope.preview =false;

    };


    /*
     $scope.newDoc= function(formMode){

     console.log(" mode", formMode);
     $scope.formMode=formMode;
     $scope.Docsession.global="new";
     $scope.Docsession.isCopyableable = false;
     $scope.Docsession.block=false;
     setGetOrder.clear();
     if($scope.provSelec.id){
     $scope.document.prov_id=$scope.provSelec.id;
     }
     Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){
     $scope.document.id = response.id;
     setGetOrder.setOrder({id:response.id,tipo:$scope.formMode.value});
     setGetOrder.setState('select');
     });

     $scope.navCtrl.value="detalleDoc";
     $scope.navCtrl.estado= true;

     };*/

    /*************** conversores **********/

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
    }


    /*
     $scope.selecContraP = function (item) {
     $scope.contraPedSelec ={};
     $scope.LayersAction({open:{name:"resumenContraPedido", before: function(){

     Order.get({type:"CustomOrder", id: item.id, doc_id: $scope.document.id, tipo: $scope.formMode.value}, {},
     function(response){

     $scope.contraPedSelec= response;
     if(response.fecha_aprox_entrega != null){
     $scope.contraPedSelec.fecha_aprox_entrega = new Date(Date.parse(response.fecha_aprox_entrega));
     }
     if(response.fecha != null){
     $scope.contraPedSelec.fecha = new Date(Date.parse(response.fecha));

     }

     });

     if(!$scope.formDataContraP.contraPedidoMotivo){
     $scope.formDataContraP.contraPedidoMotivo = Order.query({type: 'CustomOrderReason'});
     }
     if(!$scope.formDataContraP.contraPedidoPrioridad){
     $scope.formDataContraP.contraPedidoPrioridad = Order.query({type: 'CustomOrderPriority'});
     }

     if(!$scope.formDataContraP.tipoEnvio){
     $scope.formDataContraP.tipoEnvio = masters.query({type: 'getProviderTypeSend'});
     }
     }}});

     }
     */





    /** al pulsar la flecha siguiente
     *  working
     * **/
    $scope.next = function (data) {
        if(data){
            data();
        }else{


            switch($scope.module.layer){
                case "resumenPedido":
                    setGetOrder.setOrder(angular.copy($scope.resumen));
                    $scope.Docsession.isCopyableable = true;

                    $scope.formMode= $scope.forModeAvilable.getXname($scope.resumen.documento);
                    $scope.navCtrl.value = "detalleDoc" ;
                    $scope.navCtrl.estado= true;
                    return;
                    break;
                case "detalleDoc":
                    break;
                case "listProducProv":
                    break;
                case "agrPed":

                    if($scope.document.productos.todos.length == 0
                        && $scope.document.productos.contraPedido.length == 0
                        && $scope.document.productos.kitchenBox.length  == 0
                        && $scope.document.productos.pedidoSusti.length  == 0
                        && !$scope.Docsession.block
                    )
                    {
                        $scope.NotifAction("alert",
                            "No se a selecionado ningun documento para la "+$scope.formMode.name+ " ¿desea continuar de todas formas? "
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

                    if($scope.finalDoc.productos.length == 0 && !$scope.Docsession.block)
                    {
                        $scope.NotifAction("alert",
                            "No se ha cargado ningun articulo para la "+$scope.formMode.name+ " ¿desea continuar? "
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
                    break;
                case "previewEmail":
                    $scope.sendPreviewEmail();


            }
        }


        $scope.showNext();

    };

    $scope.testShow = function () {
        return $scope.docProdFilter.length > 0
    }


    $scope.showNext = function (status) {
        if (status) {
            $mdSidenav("NEXT").open();
        } else {
            $mdSidenav("NEXT").close()
        }

    };

    $scope.reloadSide = function(){

    };
    /*********************************************** EVENTOS CHANGE ***********************************************/


    /*$scope.changeContraP = function (item) {
     if(item.import){
     $scope.NotifAction("error",
     "Este Contra pedido fue agregado a partir de otra solicitud "
     ,[],{autohidden:autohidden});
     item.asignado=true;

     }else
     if($scope.provSelec.contrapedido != '1' && item.asignado){
     $scope.NotifAction("alert","El proveedor "+ $scope.provSelec.razon_social +
     " no admite contra pedidos ¿Esta seguro de asignarlo ?",
     [
     {name:"No", action : function(){item.asignado = false;}},
     {name:"Si", action:
     function(){
     $scope.addRemoveContraPe(item);
     }
     }


     ]
     ,{});
     }else {
     $scope.addRemoveContraPe(item);
     }


     };*/

    /*
     $scope.addRemoveContraPe = function(item){
     if(item.asignado){
     Order.query({type:"CustomOrderReview", id: item.id, tipo: $scope.formMode.value, doc_id:$scope.document.id},{},function(response){
     item.doc_id=$scope.document.id;
     if(response.length > 0){
     $scope.NotifAction("alert",
     "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
     ,[
     {name: 'Si',
     action:function(){
     Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
     $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
     setGetOrder.change('contraPedido'+item.id,'id',item);
     setGetOrder.setState("change");
     });
     }
     },{name: 'No',
     action:function(){item.asignado=false;}
     }
     ]);
     }else{
     Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
     $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
     setGetOrder.change('contraPedido'+item.id,'id',item);


     });
     }



     });
     }else {
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
     /!*

     if(item.asignado){
     if(item.asignadoOtro.length >0){

     }else {
     Order.postMod({type:$scope.formMode.mod,mod:"AddCustomOrder"},item,function(response){
     $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
     setGetOrder.change('contraPedido'+item.id,'id',item);


     });
     }

     }
     else{

     }
     *!/
     };
     */


    $scope.clearSelec = function(obj){
        if(!obj){
            delete obj;
        };
    }


    /**
     * @review
     * */
    $scope.changeItem = function(item){
        if($scope.dtdocProductos.$valid){
            Order.postMod({type:$scope.formMode.mod, mod:"ChangeItem"},item, function(response){
                setGetOrder.change('producto'+item.id,'id',item);
            });
        }

    };

    $scope.isEditItem = function(item) {
        if (!$scope.Docsession.block) {
            if (item.tipo_origen_id == 1 || !item.tipo_origen_id){
                item.edit = true;
                var mo= jQuery("#prodDtInp"+item.id);
                mo[0].focus();
            }else if ($scope.formMode.value == 21) {
                if(! item.edit){
                    $scope.NotifAction("alert","No suele ser usual modificar la cantidad de este tipo de articulos" +
                        " ¿Esta seguro de editar esta cantidad?",
                        [
                            {name:"No", action: function(){}},
                            {name: "Si", action: function(){
                                item.edit = true;
                                var mo= jQuery("#prodDtInp"+item.id);
                                mo[0].focus();

                            }}

                        ],{block:true});
                }

            }else if ($scope.formMode.value == 22 || $scope.formMode.value == 23) {
                if(!item.edit){
                    if(item.tipo_origen_id == 2 || item.tipo_origen_id == 3){
                        $scope.NotifAction("alert","No suele ser usual modificar la cantidad de este tipo de articulos" +
                            " ¿Esta seguro de editar esta cantidad?",
                            [
                                {name:"No", action: function(){}},
                                {name: "Si", action: function(){
                                    item.edit = true;
                                    var mo= jQuery("#prodDtInp"+item.id);
                                    mo[0].focus();
                                }}

                            ],{block:true});
                    }else{
                        $scope.NotifAction("alert","Este articulo fue importado de otro documento" +
                            " ¿Esta seguro de editar esta cantidad?",
                            [
                                {name:"No", action: function(){}},
                                {name: "Si", action: function(){
                                    alert("moificar cantidad por excepcion");
                                    // item.edit = true;
                                }}

                            ],{block:true}
                        );
                    }
                }

            }

        }


    };

    /**
     * @review
     * */
    /*    $scope.addRemoveCpItem = function(item){
     var aux = {
     asignado:item.asignado,
     tipo_origen_id: 2,
     doc_origen_id: item.contra_pedido_id,
     doc_id: $scope.document.id,
     cantidad:  item.saldo,
     saldo:  item.saldo,
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



     };*/






    /*********************************************** EVENTOS FOCUS LOST ***********************************************/




    $scope.closeSide = function(){

        var paso= true;
        if($scope.layer == 'resumenPedido'  && setGetOrder.getInternalState() != 'new'){
            paso = false;
        }

        if($scope.layer == 'detalleDoc'){
            paso = false;
        }
        if(!paso){
            if($scope.verificExit()){
                $scope.LayersAction({close:{search:true}});
            };
        }else {
            $scope.LayersAction({close:{search:true}});
        }

    };





    /**@deprecated*/
    $scope.saveWithContactMail= function(){
        $scope.OpenContactMail(function(issend){
            if(issend){
                Order.postMod({type:$scope.formMode.mod, mod:"Close"},$scope.document, function(response){
                    if (response.success) {
                        $timeout(function(){
                            var layer=angular.element("#"+$scope.layer);
                            layer[0].click();
                        },0);

                        $scope.updateProv(function(){
                            $scope.NotifAction("ok","Realizado",[
                                {name:"Ok", action: function(){
                                    $scope.LayersAction({close:{first:true, search:true}});
                                }}
                            ],{block:true});

                        });

                    }});
            }

        });
    };
    /**@deprecated*/

    $scope.saveWithSenMail= function (){
        $scope.openSendMail(function(isSend){
            if(isSend){
                Order.postMod({type:$scope.formMode.mod, mod:"Close"},$scope.document, function(response){
                    if (response.success) {
                        $timeout(function(){
                            var layer=angular.element("#"+$scope.layer);
                            layer[0].click();

                        },0);

                        $scope.updateProv(function(){
                            $scope.NotifAction("ok","Realizado",[
                                {name:"Ok", action: function(){
                                    $scope.LayersAction({close:{first:true, search:true}});

                                }}
                            ],{block:true});

                        });

                    }});
            }
        });
    };

    $scope.saveWithPreview= function (){
        $scope.openMailPreview(
            function(isSend){
                if(isSend){
                    console.log("llamado a calback");
                    Order.postMod({type:$scope.formMode.mod, mod:"Close"},$scope.document, function(response){
                        if (response.success) {
                            $timeout(function(){
                                var layer=angular.element("#"+$scope.layer);
                                layer[0].click();

                            },0);

                            $scope.updateProv(function(){
                                $scope.NotifAction("ok","Realizado",[],{autohidden:1500});
                                $timeout(function(){
                                    $scope.LayersAction({close:{first:true, search:true}});
                                },1500);

                            });

                        }});
                }
            }
        );
    };

    $scope.saveDoc = function(){
        $scope.inProcess = true;
        App.setBlock({block:true,level:89});
        Order.postMod({type:$scope.formMode.mod, mod:"Close"},{id:$scope.document.id}, function(response){
            $scope.inProcess = false;
            App.setBlock({block:false});
            $scope.NotifAction("ok","Realizado",[],{autohidden:1500});
            $scope.updateProv();
            $timeout(function(){
                $scope.LayersAction({close:{first:true, search:true}});
            },1400);
        });
    };




    /******************     excepciones       **********/

    $scope.isOpenexcepAddCP = false;

    $scope.closeExcep= function(e){

        if(jQuery(e.target).parents("#lyrAlert").length == 0 && jQuery(e.target).parents("#gridProdFinalDoc").length == 0 && $scope.isOpenexcepAddCP) {
            if ($mdSidenav("excepAddCP").open()) {
                angular.element(document).find("#finalDoc").find("#expand").animate({width:"0"},400);
                $mdSidenav("excepAddCP").close().then(function () {
                    $scope.isOpenexcepAddCP = false;
                });

                $scope.finalProdSelec = {};
                $scope.formExcepAddCP.$setUntouched();
            }
        }
    };


    $scope.addexcepProdFinal = function(){

        if(!$scope.formExcepAddCP.$valid){
            $scope.NotifAction('error', "Todos los campos son obligatorios, por favor verirfiquelos",[], {autohidden:autohidden});
            return false;
        }
        if(parseFloat($scope.excepAddCP.cantidad) > parseFloat($scope.finalProdSelec.cantidad)){
            $scope.NotifAction('error', "La cantidad introducidad,  excede el total de los productos a solicitar, " +
                "por favor introdusca una cantidad menor "
                ,[], {autohidden:autohidden});
            return false;

        }

        if(parseFloat($scope.excepAddCP.monto) > parseFloat($scope.document.monto)){
            $scope.NotifAction('error', "El monto introducido,  excede el monto de la Orden de compra" +
                "por favor introdusca un monto menor "
                ,[], {autohidden:autohidden });
            return false;

        }

        var cant=0;
        var mont = 0.0;
        angular.forEach($scope.finalProdSelec.condicion_pago, function(v){
            cant+= parseFloat(v.cantidad);
            mont+= parseFloat(v.monto);
        });

        if((parseFloat($scope.excepAddCP.cantidad) + cant)> parseFloat($scope.finalProdSelec.cantidad)){
            $scope.NotifAction('error', "Si introduce "+$scope.excepAddCP.cantidad+ " excedera la cantidad total de articulos a solicitar" +
                "por favor introdusca una cantidad menor "

                ,[], {autohidden:autohidden});
            return false;
        }

        if((parseFloat($scope.excepAddCP.monto) + mont) > parseFloat($scope.document.monto)){
            $scope.NotifAction('error', "Si introduce "+$scope.excepAddCP.monto+ " excedera el monto del documento" +
                "por favor introdusca una cantidad menor ó modifique el monto del documento "

                ,[], {autohidden:autohidden});
            return false;
        }
        $scope.submitAddExcepProdFinal();
        return true;
    };

    $scope.submitAddExcepProdFinal = function(){
        Order.postMod({type:$scope.formMode.mod, mod:"AddProdConditionPay"},
            {id:$scope.finalProdSelec.id,
                doc_id:$scope.document.id,
                cantidad:$scope.excepAddCP.cantidad,
                dias:$scope.excepAddCP.dias,
                monto:$scope.excepAddCP.monto

            }, function(response){
                $scope.finalProdSelec.condicion_pago.push(response.item);
                $scope.excepAddCP ={};
                $scope.formExcepAddCP.$setUntouched();


            });
    };

    $scope.removeExcepProdFinal = function(item){

        $scope.NotifAction("alert","¿Esta seguro de eliminar la condicion?",[
            {name:"No", action: function(){}},
            {name:"Si, estoy seguro", action: function(){
                $scope.finalProdSelec.condicion_pago.splice(item.$index,1);
            }}
        ],{block:true});
    };





    /****** ************************** agregar respuesta ***************************************/
    $scope.addAnswer={};
    $scope.addAnswer.adjs =[];
    $scope.isOpenaddAnswer= false;

    $scope.closeAddAnswer= function(e){

        if(jQuery(e.target).parents("#lyrAlert").length == 0 &&
            /*
             jQuery(e.target).parents("#"+$scope.layer).length == 0 &&
             */
            $scope.isOpenaddAnswer &&
            !angular.element(e.target).is("#ngf-AnswerfileInput")) {

            if ($mdSidenav("addAnswer").isOpen()) {

                if($scope.formAnswerDoc.$valid){
                    Order.postMod(
                        {type:$scope.formMode.mod, mod:"AddAnswer"},{  descripcion:$scope.addAnswer.descripcion,doc_id: $scope.addAnswer.doc_id, adjs :( $scope.addAnswer.adjs.length > 0)  ? $scope.addAnswer.adjs : []},function(response){
                            $scope.priorityDocs.docs.splice($scope.addAnswer.index,1);
                            $scope.addAnswer={};
                            $scope.addAnswer.adjs =[];
                            $scope.NotifAction("ok","Se agregado la respuesta del proveedor al documento ",[],{autohidden:autohidden});
                        });



                }
                angular.element(document).find("#"+$scope.layer).find("#expand").animate({width:"0"},400);
                $mdSidenav("addAnswer").close().then(function () {
                    $scope.isOpenaddAnswer = false;
                });

            }


        }
    };
    $scope.sideaddAnswer = function(data, item){

        if(!$scope.isOpenaddAnswer){
            angular.element(document).find("#"+$scope.layer).find("#expand").animate({width:"336px"},400);
            $scope.formAnswerDoc.$setUntouched();
            $mdSidenav("addAnswer").open().then(function(){
                $scope.isOpenaddAnswer = true;
                $scope.addAnswer.doc_id=angular.copy(item.id);
                $scope.addAnswer.index=data.$index;
                $scope.formMode= $scope.forModeAvilable.getXname(item.documento);
                angular.element(document).find("#addAnswer").find("#textarea").focus();


            });

        }

    };


    /***  Crear producto ***/



    $scope.$watch('answerfiles.length', function(newValue){
        if(newValue > 0){
            filesService.setFolder("orders");
            angular.forEach($scope.answerfiles, function(v){

                filesService.Upload({file:v,
                    success: function(data){
                        $scope.addAnswer.adjs.push(data);
                    },
                    error:function(){
                    }})
            });
            $scope.answerfiles =[]
        }
    });



    $scope.updateProv= function(calback){
        Order.get({type:"Provider", id: $scope.provSelec.id},{}, function(response){

            angular.forEach($scope.provSelec,function(v,k){
                $scope.provSelec[k] = response[k];
            });
            if(calback){
                calback();
            }
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
            var globalData = response;

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
                                            $scope.LayersAction({close:true});
                                            setGetOrder.reload({id:$scope.document.id,tipo:$scope.formMode.value});
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

                                var items =[];
                                angular.forEach(response.items ,function (v,k){
                                    var aux ={};
                                    aux.tipo_origen_id = $scope.forModeAvilable.getXValue($scope.formMode.value - 1).value;
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

                                    if (response.success) {
                                        Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id});
                                        $scope.NotifAction("ok","Realizado",[
                                            {name:"Ok",default:2, action: function(){
                                                $scope.LayersAction({close:true});
                                                setGetOrder.reload({id:$scope.document.id,tipo:$scope.formMode.value});
                                            }} ] ,{block:true});
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

                                var items =[];
                                angular.forEach(response.items ,function (v,k){
                                    var aux ={};
                                    aux.tipo_origen_id = $scope.forModeAvilable.getXValue(angular.copy($scope.formMode.value) - 1).value;
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
                                    if (response.success) {
                                        angular.forEach(globalData.asignado, function(v,k){
                                            $scope.document[k]=v;
                                        });
                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                                setGetOrder.reload({id:$scope.document.id,tipo:$scope.formMode.value});
                                                $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){
                                                    setGetOrder.reload();
                                                    $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
                                                }} ] ,{block:true});
                                            });
                                        });
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
                                angular.forEach(globalData.asignado, function(v,k){
                                    $scope.document[k]=v;

                                });
                                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                    Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                        setGetOrder.reload();
                                        $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});

                                    });

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
                            $scope.document.prov_id=$scope.provSelec.id;

                            angular.forEach(globalData.asignado, function(v,k){
                                $scope.document[k]=v;
                            });
                            $scope.document.prov_id=$scope.provSelec.id;
                            if(globalData.items.length > 0){

                                var items =[];
                                angular.forEach(globalData.items ,function (v,k){
                                    var aux ={};
                                    aux.tipo_origen_id = $scope.forModeAvilable.getXValue($scope.formMode.value - 1).value;
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
                                    if (response.success) {
                                        // $scope.document.productos.todos.push(response.new);
                                        angular.forEach(globalData.asignado, function(v,k){
                                            $scope.document[k]=v;
                                        });

                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                                $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){
                                                    setGetOrder.reload();
                                                    $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});

                                                }} ] ,{block:true});

                                            });
                                        });

                                    }
                                });
                            }else{
                                $scope.document.productos.todos.push(response.new);
                                angular.forEach(globalData.asignado, function(v,k){
                                    $scope.document[k]=v;

                                });

                                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                    Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                        $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){
                                            setGetOrder.reload();
                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
                                        }} ] ,{block:true});

                                    });
                                });
                            }

                        }
                    }
                    ,{name:"Dejarme elegir ",
                        action:function(){
                            $scope.NotifAction("error"," ¿Que desea hacer? "
                                ,[
                                    {name:" Usar solicitud ",
                                        action:function(){
                                            $scope.document.prov_id=$scope.provSelec.id;
                                            angular.forEach(globalData.asignado, function(v,k){
                                                $scope.document[k]=v;
                                            });
                                            angular.forEach(globalData.error, function(v,k){
                                                $scope.document[k]= v[0].key;
                                            });

                                            if(response.items.length > 0){

                                                var items =[];
                                                angular.forEach(response.items ,function (v,k){
                                                    var aux ={};
                                                    aux.tipo_origen_id = $scope.forModeAvilable.getXValue($scope.formMode.value - 1).value;
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
                                                    if (response.success) {
                                                        $scope.document.productos.todos.push(response.new);
                                                        angular.forEach(globalData.asignado, function(v,k){
                                                            $scope.document[k]=v;
                                                        });

                                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                                                $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){
                                                                    setGetOrder.reload();
                                                                    $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});

                                                                }} ] ,{block:true});

                                                            });
                                                        });

                                                    }
                                                });
                                            }else{
                                                $scope.document.productos.todos.push(response.new);
                                                angular.forEach(globalData.asignado, function(v,k){
                                                    $scope.document[k]=v;

                                                });

                                                Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                                    Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                                        $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){
                                                            setGetOrder.reload();
                                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
                                                        }} ] ,{block:true});

                                                    });
                                                });
                                            }
                                        }
                                    }
                                    ,{name:"Usar proforma",
                                        action:function(){
                                            $scope.document.prov_id=$scope.provSelec.id;
                                            angular.forEach(globalData.asignado, function(v,k){
                                                $scope.document[k]=v;

                                            });
                                            angular.forEach(globalData.error, function(v,k){
                                                $scope.document[k]= v[1].key;

                                            });
                                            var data=  {
                                                doc_id : $scope.document.id,
                                                asignado:true,
                                                items: response.items
                                            };
                                            Order.postMod({type:$scope.formMode.mod, mod:"AdddRemoveItems"},data, function(response){
                                                if (response.success) {
                                                    //$scope.document.productos.todos.push(response.new);
                                                    angular.forEach(globalData.asignado, function(v,k){
                                                        $scope.document[k]=v;

                                                    });
                                                    Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                                        Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id},function(){
                                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){
                                                                setGetOrder.reload();
                                                                $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
                                                            }
                                                            } ] ,{block:true});

                                                        });
                                                    });
                                                }
                                            });


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
                                                        $scope.document[v.key]= v.value;
                                                        setGetOrder.change("document", v.key, v.value);
                                                        console.log(v.key, v.value);
                                                    });
                                                    $scope.FormHeadDocument.$setDirty();
                                                    var items =[];
                                                    angular.forEach(response.items ,function (v,k){
                                                        var aux={};
                                                        aux.tipo_origen_id = $scope.forModeAvilable.getXValue($scope.formMode.value - 1).value;
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

                                                        Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(){
                                                            Order.postMod({type:$scope.formMode.mod, mod:"SetParent"},{princ_id: $scope.document.id,doc_parent_id:doc.id}, function(){
                                                                $scope.NotifAction("ok","Realizado",[
                                                                    {name:"Ok",default:2,
                                                                        action: function(){
                                                                            setGetOrder.reload();
                                                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
                                                                        }
                                                                    }
                                                                ] ,{block:true});

                                                            });

                                                        });

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
                ]);

            }

        });
    };

    /****** ************************** autocomplete ***************************************/






    /****** **************************listener ***************************************/

    $scope.$watch('docBind.estado', function(newVal){
        if(newVal){
            $scope.document=setGetOrder.getOrder();
            $scope.docBind.estado= false;
            if( $scope.document.prov_id ){
                Order.get({type:"Provider",  id: $scope.document.prov_id},{}, function(response){
                    $scope.ctrl.provSelec=response;
                    $scope.provSelec=response;
                });
            }
        }

    });



    $scope.$watch("Docsession.block",function(newVal){
    });



    /**layers
     working
     * */
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

        }

        if(newVal[0] == 0 || newVal[0] == 1){


            if($scope.layer != "detalleDoc"){
                $scope.gridView= 1;
                $scope.imagenes = [];
                $scope.Docsession.block= true;
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

    /******************************** GUARDADOS ***************************************/




    $scope.$watchGroup(['FormEstatusDoc.$valid', 'FormEstatusDoc.$pristine'], function (nuevo) {

        if (nuevo[0] && !nuevo[1]) {

            Order.postMod({type:$scope.formMode.mod, mod:"SetStatus"},{id:$scope.document.id, estado_id:$scope.document.estado_id}, function(response){
                if (response.success) {
                    setGetOrder.change("document","estado",response.item.estado);
                    $scope.NotifAction("ok","Estado cambiado a "+response.item.estado,[],{autohidden:autohidden});
                    $scope.FormEstatusDoc.$setPristine();

                }

            });
        }
    });


    /* $scope.$watchGroup(['FormCancelDoc.$valid', 'FormCancelDoc.$pristine'], function (nuevo) {

     /!* if (nuevo[0] && !nuevo[1]) {

     $scope.document.prov_id = $scope.provSelec.id;
     Order.postMod({type:$scope.formMode.mod, mod:"Cancel"},$scope.document, function(response){
     $scope.FormCancelDoc.$setPristine();

     if (response.success && response.accion == 'new') {
     $scope.NotifAction("ok","Cancelado",[],{autohidden:autohidden});
     }

     });
     }*!/


     });*/

    $scope.$watchGroup(['FormAprobCompras.$valid', 'FormAprobCompras.$pristine'],function(newVal){
        if(!newVal[1]){

        }
    });
    $scope.Docsession.msmAprobComTrue= false;
    $scope.Docsession.msmAprobComfalse= false;








    /*********************************  peticiones  carga $http ********************* ************/

    $scope.removeList= function(item){

        $scope.NotifAction("alert",
            "Se removera todos los productos asociados ¿Desea continuar?"
            ,[
                {name: 'Ok',
                    action:function(){

                    }
                },{name: 'Cancel',action:function(){}}
            ]);

    };

    $scope.doClick = function (name){
        $timeout( function(){
            var obj= angular.element(name);
            obj.click();
        }, 100);

    };






});

/***lista de documentos  de un proveedor*/
MyApp.controller('OrderlistPedidoCtrl',['$scope','$timeout','$filter','DateParse','clickCommitSrv','Order', function ($scope,$timeout,$filter,DateParse,commitSrv, Order) {

    $scope.clikBind = commitSrv.bind();
    $scope.tbl = {
        data: [],
        order:'id'
    };

    $scope.$parent.OrderlistPedidoCtrl = function (prov) {
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
        // setGetOrder.clear();
        /*   $scope.gridView= 1;
         var  paso=  true;
         if ($mdSidenav("addAnswer").isOpen()){
         paso=false;

         }

         var aux= angular.copy(doc);
         if(doc && $scope.module.index <2 && paso){
         if (segurity('editPedido')) {
         //$scope.document = aux;;
         setGetOrder.setOrder(aux);
         setGetOrder.setState("select");
         $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
         $scope.Docsession.global='upd';
         $scope.preview=false;
         $scope.navCtrl.value="detalleDoc";
         $scope.navCtrl.estado=true;
         $scope.Docsession.isCopyableable = true;
         $scope.Docsession.block = true;

         }

         }*/
    };
}]);

MyApp.controller('OrderlistEmailsImportCtrl',['$scope','$timeout','DateParse','Order','providers','setGetOrder','clickCommitSrv',  function ($scope,$timeout,DateParse, Order,providers, setGetOrder,commitSrv) {

    $scope.tbl = {data:[], order:'id'};
    $scope.$parent.OrderlistEmailsImportCtrl = function () {
        $scope.LayersAction({search:{name:"listEmailsImport" }});
    }
}]);

MyApp.controller('OrderlistImportCtrl',['$scope','$timeout','DateParse','Order','providers','setGetOrder','clickCommitSrv',  function ($scope,$timeout,DateParse, Order,providers, setGetOrder,commitSrv) {

    $scope.tbl = {data:[], order:'id'};
    $scope.$parent.OrderlistImportCtrl = function () {
        $scope.LayersAction({search:{name:"listImport" }});
    }
}]);

MyApp.controller('OrderDetalleDocCtrl',['$scope','$timeout','DateParse','Order','masters','providers','setGetOrder','clickCommitSrv',  function ($scope,$timeout,DateParse, Order,masters,providers, setGetOrder,commitSrv) {

    $scope.estadosDoc = masters.query({type: 'getOrderStatus'});
    $scope.$parent.openImport = function(){


        if($scope.Docsession.block ){
            $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder importar el documento",[],{autohidden:autohidden});
        }else{

            if($scope.formMode.value == 21){
                $scope.$parent.OrderlistEmailsImportCtrl();

            }else  if($scope.formMode.value == 22 || $scope.formMode.value ==23 ){
                $scope.$parent.OrderlistImportCtrl
            }
        }

    };

    $scope.clikBind = commitSrv.bind();
    $scope.formData = {direccionesFact:[],monedas: [],paises:[] ,condicionPago:[],direcciones:[]};

    $scope.$parent.OrderDetalleCtrl = function (data, fn) {
        $scope.FormHeadDocument.$setUntouched();
        /*        $scope.FormEstatusDoc.$setUntouched();
         $scope.FormAprobCompras.$setUntouched();
         $scope.FormCancelDoc.$setUntouched();*/
        $scope.isTasaFija=true;


        if(data){
            $scope.gridView= 1;
            setGetOrder.setOrder({id:data.id, tipo:data.tipo});
            setGetOrder.setState("select");
            $scope.$parent.formMode= $scope.$parent.forModeAvilable.getXname(data.documento);
            $scope.$parent.Docsession.global='upd';
            $scope.$parent.preview = false;
            $scope.$parent.Docsession.isCopyableable = true;
            $scope.$parent.Docsession.block = true;
        }else{
            $scope.$parent.Docsession.global="new";
            $scope.$parent.Docsession.isCopyableable = false;
            $scope.$parent.Docsession.block=false;
            setGetOrder.clear();
            if($scope.$parent.provSelec.id){
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
        $scope.LayersAction({search:{name:"detalleDoc" }});




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
    }
    $scope.$watch('clikBind.state', function (newVal) {
        if(newVal){

            $timeout(function () {
                var data = commitSrv.get();
                commitSrv.setState(false);
                if(data.commiter == 'setProveedor'){
                    if($scope.$parent.module.layer == 'detalleDoc' && !$scope.$parent.Docsession.block &&  $scope.$parent.Docsession.global == "new"){
                        $scope.$parent.ctrl.provSelec = data.scope.item;
                    }

                }
            },0);

        }
    });

    /* if(!$scope.Docsession.msmNext && $scope.FormHeadDocument.$valid){
     if($scope.Docsession.global == 'new'){
     $scope.NotifAction("ok", "Creado puede continuar" , [],{autohidden:2000});
     }else{
     $scope.NotifAction("ok", "Puede continuar" , [],{autohidden:2000});
     }
     $scope.Docsession.msmNext= true;
     }*/
    $scope.$watchGroup(['FormHeadDocument.$valid', 'FormHeadDocument.$pristine'], function (newVal) {
        if(!newVal[1] &&  $scope.formMode.mod){
            $scope.document.prov_id = angular.copy($scope.provSelec.id);
            Order.postMod({type:$scope.$parent.formMode.mod, mod:"Save"},$scope.document, function(response){
                $scope.FormHeadDocument.$setPristine();
                $scope.$parent.document.uid= response.uid;
            });
        }
    });

    $scope.$watch('$parent.ctrl.provSelec', function (newVal) {
        if(newVal ){
            if($scope.$parent.provSelec.id != newVal.id){
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



        }

    });



    $scope.$watch('$parent.document.objs.direccion_facturacion_id', function (newVal) {
        if(newVal ){

            $scope.$parent.document.direccion_facturacion_id = newVal.id;
            if( $scope.$parent.Docsession.global != 'new'){
                setGetOrder.change("document","direccion_facturacion_id",newVal.id);
            }
        }

    });

    $scope.$watch('$parent.document.objs.direccion_almacen_id', function (newVal) {



        if(newVal ){

            $scope.$parent.document.direccion_almacen_id = newVal.id;
            $scope.$parent.ctrl.puerto_id= null;
            Order.query({type:"AdrressPorts", direccion_id: newVal.id},{}, function(response){
                $scope.formData.puertos = response;
            });
            if( angular.equals(angular.element("#detalleDoc #direccion_almacen_id input[type=search]"),angular.element(":focus"))){
                setGetOrder.change("document","direccion_almacen_id",newVal.id);
            }
        }else{
            if( angular.equals(angular.element("#detalleDoc #direccion_almacen_id input[type=search]"),angular.element(":focus"))){
                $scope.$parent.document.direccion_almacen_id= null;
                $scope.$parent.ctrl.puerto_id= null;
                setGetOrder.change("document","direccion_almacen_id",undefined);
                setGetOrder.change("document","puerto_id",undefined);

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
                setGetOrder.change("document","pais_id",newVal.id);
            }
        }else{
            if(!$scope.Docsession.block){
                $scope.document.pais_id= null;
                $scope.ctrl.direccion_almacen_id= null;
            }


        }


    });

    $scope.changeProvMoneda = function(newVal ){


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
                            }}
                        ]
                        ,{block:true});
                }
            }

        }
    };

    $scope.$watch('$parent.document.objs.condicion_pago_id', function (newVal) {

        if( angular.equals(angular.element("#detalleDoc #condicion_pago_id input[type=search]"),angular.element(":focus"))){


            if(newVal ){
                if(newVal != 0){
                    $scope.$parent.document.condicion_pago_id = newVal.id;
                    setGetOrder.change("document","condicion_pago_id", newVal.id);
                }
            }else{
                setGetOrder.change("document","condicion_pago_id",undefined);
            }
        }

    });
    $scope.$watch('$parent.document.objs.puerto_id', function (newVal) {

        if( angular.equals(angular.element("#detalleDoc #puerto_id input[type=search]"),angular.element(":focus"))){

            if(newVal ){
                if(newVal != 0){
                    $scope.$parent.document.puerto_id = newVal.id;
                    setGetOrder.change("document","puerto_id", newVal.id);
                }
            }else{
                if(!$scope.Docsession.block){
                    $scope.$parent.document.puerto_id= null;
                    setGetOrder.change("document","puerto_id",undefined);
                }
            }
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



}]);

MyApp.controller('OrderUnclosetDocCtrl',['$scope','DateParse','Order','masters', function ($scope,DateParse,Order,masters) {

    $scope.tbl= {data:[],order:'id'};
    $scope.$parent.OrderUnclosetDocCtrl = function () {
        $scope.LayersAction({search:{name:"unclosetDoc",
            before:function(){
                $scope.tbl.data.splice(0,$scope.tbl.data.length);
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



}]);

MyApp.controller('OrderlistProducProvCtrl',['$scope','Order','masters','form', function ($scope,Order,masters,formSrv) {

    $scope.bindForm = formSrv.bind();
    masters.query({type:"prodLines"},{}, function (response) {
        $scope.lineas= response;
    });

    $scope.$parent.OrderlistProducProvCtrl = function () {
        $scope.LayersAction({search:{name:"listProducProv",
            before:function(){
                $scope.providerProds = [];
                Order.query({type:"ProviderProds", id:$scope.$parent.ctrl.provSelec.id,tipo:$scope.$parent.formMode.value, doc_id:$scope.document.id},{}, function(response){

                    angular.forEach(response , function(v,k){

                        v.saldo=parseFloat(v.saldo);
                        $scope.providerProds.push(v);
                    });
                });
            },
            after: function(){
            }
        }});
    };

    $scope.openItem= function (data) {
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
            uid: data.uid
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
            uid: data.uid

        };
        $scope.select= data;
        if(!data.asignado){
            formSrv.name= 'OrderlistProducProvCtrl';
            $scope.$parent.OrderminiAddProductCtrl(send);

        }else{
            $scope.select= undefined;
            $scope.NotifAction("alert","Esta seguro de remover el producto",
                [
                    {name:"Cancelar", action:function () {

                    }
                    },
                    {name:"Si, estoy seguro", action:function () {
                        $scope.delete(data);
                    }
                    }
                ]
                ,{block:true}) ;
        }
    };

    /*    $scope.showNext = function () {
     if (!$scope.listProductoItems.$valid) {

     $scope.NotifAction("error",
     "No se pueden asignar productos sin asignarle una cantidad verifique que todos los productos tienen cantidad correctas"
     ,[],{autohidden:2000});

     return false;
     }
     return true;
     };*/

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

    /*
     $scope.changeProducto = function (item){
     var paso = true;
     if(item.asignado && item.saldo > 0){
     item.prov_id =$scope.provSelec.id;
     item.doc_id =$scope.document.id;
     Order.postMod({type:$scope.formMode.mod,mod:"ProductChange"},item,function(response){
     if(!item.reng_id){
     $scope.NotifAction("ok",
     "agregado"
     ,[],{autohidden:autohidden});
     var prod= angular.copy(response);
     prod.cantidad = parseFloat(prod.cantidad);
     }
     item.reng_id=response.reng_id;
     setGetOrder.change('producto'+item.id,'id',item);
     });
     }


     };

     $scope.addRemoveProd = function (item){
     if(item.asignado){
     $timeout(function(){
     var mo= jQuery("#p"+item.id);
     mo[0].focus();
     item.saldo=1;
     $scope.changeProducto(item);

     },100);

     }else if(!item.asignado && item.reng_id){
     $scope.NotifAction("alert",
     "Se eliminara el producto ¿Deseas continuar?"
     ,[
     {name: 'Ok',
     action:function(){
     Order.postMod({type:$scope.formMode.mod,mod:"ProductChange"},item,function(response){
     $scope.NotifAction("info",
     "Removido"
     ,[],{autohidden:autohidden});
     setGetOrder.change('producto'+item.id,'id',undefined);
     delete item.reng_id;
     item.saldo = 0;
     item.cantidad = 0;
     });
     }
     },{name: 'Cancel',
     action:function(){item.asignado=true;}
     }
     ],{block:true});
     }

     };

     */
    $scope.$watch('lineaSelec', function (newVal, oldVal) {
        if(newVal ){
            masters.query({type:"prodSubLines", linea_id: newVal.id},{}, function (response) {
                $scope.subLineas =response;
            });

        }
    });

    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && formSrv.name == 'OrderlistProducProvCtrl'){
            var data = formSrv.getData();
            $scope.select.asignado = (data.response.accion  == 'new' || data.response.accion  == 'upd') ;
            $scope.select.reng_id = data.response.reng_id;
            $scope.select.cantidad = data.response.cantidad;
            $scope.select.saldo = data.response.saldo;
            if(data.response.accion  == 'new'){
                $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
            }if(data.response.accion  == 'upd'){
                $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
            }

        }
    });


}]);

MyApp.controller('OrderCreateProdCtrl',['$scope','$mdSidenav','$timeout', 'Order','masters','form', function ($scope,$mdSidenav,$timeout,Order,masters,formSrv) {

    $scope.isOpen = false;
    $scope.inProcess = false;
    $scope.$parent.OrderCreateProdCtrl= function () {
        $scope.open();
    };
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

        ){
            $scope.inProcess= true;
            $scope.inClose();
        }
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

MyApp.controller('OrderAccCopyDoc',['$scope','Order','setGetOrder', function ($scope,Order,setGetOrder) {
    $scope.$parent.copyDoc = function() {

        Order.postMod({type:$scope.formMode.mod, mod:"Copy"},{id:$scope.$parent.document.id}, function(response){

            $scope.$parent.OrderDetalleCtrl({id:response.id,tipo: $scope.$parent.formMode.value }, function () {
                $scope.NotifAction("ok","Nueva version creada",[],{autohidden:2000});
                $scope.Docsession.block= false;
                setGetOrder.change("document", 'id', response.id);
            });


        });
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
        $scope.model = {adjs:[]};
        $scope.open();
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
                }else if($scope.loades.length == 0){
                    $scope.NotifAction("alert","¡No has cargado adjuntos! es preferible que adjuntes algun documento que soporte la aprobacion.  Confirmanos que no posees ese soporte",
                        [
                            {name:"No tengo soporte",default:5, action:function () {
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
        $scope.model.adjs=angular.copy( $scope.loades);
        Order.postMod({type:$scope.formMode.mod, mod:"Approved"},$scope.model,function(response){
            if(response.accion == 'ap_gerencia'){
                $scope.NotifAction("ok","Se ha realizado la aprobacion por parte de gerencia",[],{autohidden: 1500});
                $scope.$parent.document.fecha_aprob_gerencia = angular.copy($scope.model.fecha);
                $scope.$parent.document.isAprobado= true;
            }
            if(response.accion == 'ap_compras'){
                $scope.NotifAction("ok","Se ha realizado la aprobacion por parte de compras",[],{autohidden: 1500});
                $scope.$parent.document.fecha_aprob_compras = angular.copy($scope.model.fecha);
                $scope.$parent.document.isAprobado= true;

            }
            if(fn){
                fn()
            }
        });
    };


}]);
MyApp.controller('OrderCancelDocCtrl',['$scope','$mdSidenav','$timeout',  'Order','setGetOrder', function ($scope,$mdSidenav, $timeout, Order,setGetOrder) {
    $scope.upModel = [];
    $scope.loades = [];


    $scope.fnfile = function (item) {
        $scope.model.adjs.push(item);
    };
    $scope.$parent.OrderCancelDocCtrl = function () {
        $scope.mode = 'list';
        $scope.model = {adjs:[]};
        $scope.open();
    };
    $scope.open = function (fn) {
        $mdSidenav("OrderCancel").open().then(function(){
            $scope.isOpen = true;

            if(fn){
                fn($scope);
            }
        });
    };
    $scope.inClose = function (fn) {

        $mdSidenav("OrderCancel").close().then(function(){
            $scope.isOpen = false;
            $scope.isProcess= false;
            if(fn){
                fn();
            }
        });

    };
    $scope.close= function (e) {
        if($scope.isOpen && !$scope.isProcess){
            console.log('$scope',$scope )
            if(!$scope.formData.$pristine){
                if(!$scope.formData.$valid){
                    $scope.NotifAction("alert","¡Muy pocos datos! No has colocado suficiente informacion para poder canclar el documento ",
                        [
                            {name:"Corregir",default:10, action:function () {

                            }},

                            {name:"Cancelar", action:function () {
                                $scope.inClose();
                            }}
                        ], {block: true});
                }else if($scope.upModel.length == 0){
                    $scope.NotifAction("alert","¡No has cargado adjuntos! es preferible que adjuntes algun documento que soporte la cancelacion.  Confirmanos que no posees ese soporte",
                        [
                            {name:"No tengo soporte",default:10, action:function () {
                                $scope.save(function () {
                                    $scope.inClose();
                                });
                            }},

                            {name:"Dejame colocarlo", action:function () {

                            }}
                        ], {block: true,save:{doc_origen_id:$scope.document.id, tipo_origen_id: $scope.$parent.formMode.value}});
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
        Order.postMod({type:$scope.formMode.mod, mod:"Cancel"},$scope.model,function(response){
            $scope.$parent.NotifAction("ok", "Cancelado",[],{autohidden:1500});
            if(fn){
                fn()
            }
            $timeout(function () {
                if($scope.$parent.module.historia[1] == 'detalleDoc'){
                    $scope.LayersAction({close:{all:true}});
                }else{
                    $scope.LayersAction({close:{first:true, search:true}});
                }
            },500);
        });
    };

    $scope.saveCancelDoc = function(){

        if($scope.FormCancelDoc.$valid && !$scope.FormCancelDoc.$pristine){
            $scope.NotifAction("ok","¿ Esta seguro de cancelar la "+$scope.formMode.name +" ? ",[
                {name: "Si",
                    action:function(){
                        Order.postMod({type:$scope.formMode.mod, mod:"Cancel"},$scope.document, function(response){
                            if (response.success) {
                                $scope.NotifAction("ok","La "+$scope.formMode.name +" a sido cancelada ",[
                                    {name:"Ok",action:
                                        function(){
                                            $scope.LayersAction({close:{init:true, search:true}});
                                        }
                                    }
                                ],{autohidden:autohidden});
                            }
                        });
                    }},
                {name:"No", action:
                    function(){
                        $scope.mtvCancelacion=undefined;
                    }}
            ],{block:true});

        }

    };
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
        $scope.$parent.OrderfinalDocCtrl();
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
  /*  $scope.selecPedidoSust =function (item) {
        $scope.pedidoSusPedSelec ={};
        $scope.LayersAction({open:{name:"resumenPedidoSus",
            after: function(){
                Order.get({type:"OrderSubstitute", id:item.id,tipo:$scope.formMode.value,doc_id: $scope.document.id}, {},function(response){
                    $scope.pedidoSusPedSelec = response;
                    $scope.pedidoSusPedSelec.emision = DateParse.toDate(response.emision);
                });

            }}});

    };*/
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

    $scope.question = function (item) {

    };

    $scope.change = function (item) {
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

    };

/*
 $scope.changePedidoSustituto = function (item) {

 if (item.asignado) {
 Order.postMod({type:$scope.formMode.mod,mod:"AddSustitute"},{princ_id:$scope.document.id,reemplace_id:item.id},function(response){
 $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
 $scope.document.id = response.id;
 setGetOrder.reload({id:response.id, tipo:$scope.formMode.value});

 });
 } else {
 Order.postMod({type:$scope.formMode.mod,mod:"RemoveSustitute"},{princ_id:$scope.document.id,reemplace_id:item.id},function(response){
 $scope.NotifAction("ok","Removido",[],{autohidden:autohidden});
 $scope.document.id = response.id;
 setGetOrder.change('pedidoSusti'+item.id,'id',undefined);
 setGetOrder.reload({id:response.id, tipo:$scope.formMode.value});


 });
 }

 };

*/

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
        $scope.LayersAction({search:{name:"agrContPed",before:  $scope.load}});
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
            setGetOrder.setState("change");
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

    };



}]);


MyApp.controller('OrderAgrKitBoxsCtrl',['$scope','Order','setGetOrder','form' ,function ($scope,Order,setGetOrder, formSrv) {
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
        if(!item.asignado){
            $scope.review(item);
        }else{
            $scope.question(item);
        }

    };
    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && formSrv.name == 'OrderAgrKitBoxsCtrl'){
            var data = formSrv.getData();

            $scope.select.asignado = (data.response.action  == 'new' || data.response.action  == 'upd') ;
            $scope.select.reng_id= data.response.item.id;
            $scope.select.costo_unitario= data.response.item.costo_unitario;
            setGetOrder.change('kitchenBox'+$scope.select.id,'id',data.response.item.id);
            setGetOrder.change('kitchenBox'+$scope.select.costo_unitario,'id',data.response.item.costo_unitario);
            if(data.response.action  == 'new'){
                $scope.$parent.NotifAction("ok", "Agregado",[], {autohidden:1500});
            }if(data.response.action  == 'upd'){
                $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
            }

        }
    });


    /**
     * @deprecated
     * */
    $scope.changeKitchenBox = function (item) {
        /*   var paso = true;
         if (item.import) {
         $scope.NotifAction("error",
         "Este KitchenBox fue agregado a partir de otra solicitud "
         , [], {autohidden: 1500});
         item.asignado = true;
         paso = false;

         }
         if (paso) {
         $scope.addRemoveKitchenBox(item);
         }
         */

    };

    $scope.addRemoveKitchenBox = function(item){
        /*

         item.doc_id = $scope.document.id;
         if (item.asignado) {
         Order.query({type:"KitchenBoxReview", id: item.id, tipo: $scope.formMode.value, doc_id:$scope.document.id},{},
         function(response){
         if(response.length > 0){
         $scope.NotifAction("alert",
         "Ya se encuentra asignado a otro documento ¿Desea agregarlo de igual manera?"
         , [
         {
         name: 'Si',
         action: function () {

         }
         }, {
         name: 'No',
         action: function () {
         item.asignado = false;
         }
         }
         ]);
         }else{
         Order.postMod({type: $scope.formMode.mod, mod: "AddkitchenBox"}, item, function (response) {
         $scope.NotifAction("ok", "Asignado", [], {autohidden: autohidden});
         setGetOrder.change('kitchenBox'+item.id,'id',item);
         });
         }

         });
         }
         else {

         }
         */

    };

}]);

MyApp.controller('OrderResumenContraPedidoCtrl',['$scope', '$timeout','Order','form',function ($scope,$timeout,Order, formSrv) {

    $scope.bindForm = formSrv.bind();

    $scope.tbl = {
        data:[],
        order:'id'
    };

    $scope.$parent.OrderResumenContraPedidoCtrlCtrl = function (data) {
        $scope.model = {};
        $scope.tbl.data.splice(0, $scope.tbl.data.length );
        $timeout(function () {
            Order.get({type:"CustomOrder", id: data.id, doc_id: $scope.$parent.document.id, tipo: $scope.$parent.formMode.value}, {},function (response) {
                console.log(response);
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
                            $scope.$parent.OrderminiAddProductCtrl(send, {type:$scope.$parent.formMode.mod, mod:"SaveCustomOrder"});
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
    };
    $scope.addRemoveCpItem = function(item){


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
    $scope.remove = function (item) {


    };
    $scope.change = function (data) {

    };

    $scope.addRemoveDocSusItem = function(item){
    /*    var aux = {
            asignado:item.asignado,
            tipo_origen_id: $scope.formMode.value,
            doc_origen_id: item.doc_id,
            doc_id: $scope.document.id,
            cantidad:  item.saldo,
            saldo:  item.saldo,
            producto_id:  item.producto_id,
            descripcion:  item.descripcion,
            id:item.id

        };
        if(item.asignado){
            Order.postMod({type:$scope.formMode.mod,mod:"AdddRemoveItem"},aux,function(response){
                if(response.accion == "new"){
                    $scope.NotifAction("ok","Asignado",[],{autohidden:autohidden});
                    item.renglon_id= response.renglon_id;
                }

            });

        }else if(!item.asignado && item.renglon_id){
            $scope.NotifAction("alert","Se Removera el articulo",[
                {name:'Cancelar',
                    action: function(){

                    }
                },
                {name:'Continuar',default:4,
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
        }*/



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

    $scope.remove = function (item) {


    };
    $scope.change = function (data) {

    };
    $scope.addRemoveCpItem = function(item){


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

MyApp.controller('OrderfinalDocCtrl',['$scope','Order','masters','setGetOrder', function ($scope,Order,masters, setGetOrder) {

    $scope.switchBack=  {
        head:{model:true,change:false},
        contraPedido:{model:true,change:false},
        kichenBox:{model:true,change:true},
        changeItems:{model:true,change:true},
        pedidoSusti:{model:true,change:false}

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

    $scope.saveFinal = function(){
        var accions = {};

        angular.forEach($scope.switchBack, function(v,k){
            accions[k] = v.change;
        });
        Order.postMod({type:$scope.formMode.mod, mod:"CloseAction"},{id:$scope.$parent.document.id,accion:accions, seccion:$scope.Docsession.global }, function(response){
            if(response.action){
                if(response.action == 'question'){
                    $scope.NotifAction("alert", "¿Que desea hacer?",[
                        {name:"Enviar", action:$scope.saveWithPreview},
                        {name:"Solo Guardar",action:$scope.saveDoc}
                    ],{block:true});
                }else if(response.action == 'save' ){
                    $scope.saveDoc();
                }else if(response.action == 'send'){
                    $scope.saveWithPreview();
                }else if(response.action == 'close'){
                    $scope.LayersAction({close:{first:true, search:true}});
                }else{

                }
            }
        });
    };

    $scope.buildfinalDoc = function(){
        var final={contra:[],kitchen:[],pedidoSusti:[], todos:[], document:[], aprob_gerencia:[], aprob_compras:[]};
        console.log("$scope.switchBack",$scope.switchBack);
        console.log("form",setGetOrder.getForm());
        angular.forEach(setGetOrder.getForm(), function(v,k){
                if(k.startsWith('contra')){

                }

                if(k.startsWith('kitchen')){

                }

                if(k.startsWith('pedidoSusti')){

                }
                if(k.startsWith('todos')){

                }
            }
        );
        angular.forEach(setGetOrder.getForm('document'), function(v,k){

            }

        );

        console.log("final ", final);
        return final;
    };

    $scope.$parent.OrderfinalDocCtrl = function () {
        $scope.switchBack=  {
            head:{model:true,change:false},
            contraPedido:{model:true,change:false},
            kichenBox:{model:true,change:true},
            changeItems:{model:true,change:true},
            pedidoSusti:{model:true,change:false}

        };
        $scope.finalDoc = $scope.buildfinalDoc();
        $scope.gridViewFinalDoc = 1;
        Order.get({type:$scope.$parent.formMode.mod, mod:"Summary",tipo: $scope.$parent.formMode.value,id: $scope.$parent.document.id},{}, function (response) {
            $scope.finalDoc.productos = response.productos;
        });

        $scope.LayersAction({search:{name:"finalDoc",before: function(){}}});
    };

    $scope.canNext = function () {

        return true;
    };

    $scope.next = function () {
        $scope.saveFinal();
    }
}]);

MyApp.controller('OrderMenuAgrCtrl',['$scope','Order','masters','clickCommitSrv','setGetOrder', function ($scope,Order,masters,clickCommitSrv,setGetOrder) {



    $scope.$parent.OrderMenuAgrCtrl = function () {
        $scope.LayersAction({search:{name:"finalDoc",before: function(){}}});
    };

    $scope.newDoc= function(formMode){
        $scope.$parent.formMode=formMode;

        $scope.$parent.OrderDetalleCtrl();

    };

}]);

/**
 * controller for mdsidenav mail type popUp, this controller is responsable de send correo option, this is used for send text,
 * in lieu of de template
 * */
MyApp.controller('OrderSendMail',['$scope','$mdSidenav','$timeout','App','setGetOrder','Order','IsEmail','SYSTEM', function($scope,$mdSidenav,$timeout,App, setGetOrder,Order, IsEmail, SYSTEM){
    $scope.isOpen= false;
    $scope.destinos =[];
    $scope.emailToText='';
    $scope.inProgress=false;
    $scope.transformChip = function(chip) {
        if (angular.isObject(chip)) {
            return chip;
        }
        if(IsEmail(chip)!= null){
            return {valor:chip,razon_social:''};
        }
        return null;
    };
    $scope.$parent.openSendMail = function(calback){
        if (calback){
            $scope.calback=calback;
        }else{
            delete $scope.calback;
        }
        $mdSidenav("sendEmail").open().then(function(){
            $scope.isOpen= true;
            $scope.showHead= true;
            $scope.showCc= false;
            $scope.showCco= false;
            $scope.usePersonal= true;
            $scope.to = [];
            $scope.cc = [];
            $scope.cco = [];
            $scope.asunto='';
            $scope.text='';
            $scope.FormSendMail.$setPristine();
            $scope.FormSendMail.$setUntouched();


            Order.query({type:'ProviderEmails',prov_id:$scope.$parent.provSelec.id},{},function(response){
                $scope.correosProvider= response;
            });
        });
    };

    $scope.close = function(e){
        if(jQuery(e.target).parents("#lyrAlert").length == 0
            && jQuery(e.target).parents("#sendEmail").length == 0
            && jQuery(e.target).parents("#noti-button").length == 0
            && jQuery(e.target).parents(".md-chip-remove").length == 0
            && jQuery(e.target).parents("#blockXLevel").length == 0

            && $scope.isOpen

        ){
            $mdSidenav("sendEmail").close().then(function(){
                $scope.isOpen = false;
                $scope.emailToText='';
                $scope.useMailSyte= false;
            });
        }

    };


    $scope.addEmail = function(chip){
        $scope.destinos.push(chip.valor+chip.razon_social);
    };

    $scope.removeEmail = function(chip){
        var index = $scope.destinos.indexOf(chip.valor+chip.razon_social);
        $scope.destinos.splice(index,1);
    };
    $scope.isAddMail = function(val){
        return  $scope.destinos.indexOf(val.valor+val.razon_social) === -1;
    };

    $scope.send = function(){
        if($scope.to.length == 0){
            $scope.$parent.NotifAction('error','Debe asignar al menos un destinatario',[],{autohidden:SYSTEM.noti_autohidden});
        }
        else if(!$scope.FormSendMail.$valid){
            $scope.$parent.NotifAction('error','Por favor asigne un texto',[],{autohidden:SYSTEM.noti_autohidden});

        }else{
            $scope.inProgress=true;
            App.setBlock({block:true,level:89});
            Order.post({type:"Mailsend"} ,{asunto:$scope.asunto, texto:$scope.texto, to:$scope.to,cc:$scope.cc, cco:$scope.cco ,local:!$scope.usePersonal}, function(response){
                if(response.accion){
                    if( $scope.calback){
                        $scope.calback(response.accion);
                    }
                    $scope.inProgress=false;
                    App.setBlock({block:false});
                }



            });
        }
    }

}]);

/**
 * controller for mdsidenav mail type popUp, this controller is responsable de send correo option, this is used for select
 * destination mail, the mail is filter for provider select
 *
 * */
MyApp.controller('OrderContactMail',['$scope','$mdSidenav','$timeout','App','setGetOrder','Order','IsEmail','SYSTEM', function($scope,$mdSidenav,$timeout,App,setGetOrder,Order, IsEmail, SYSTEM){

    // $scope.bind =setGetOrder.bind();
    $scope.isOpen= false;
    $scope.destinos =[];
    $scope.emailToText='';
    $scope.useMailSyte= false;
    $scope.correosProvider =[];
    $scope.inProgress= false;
    $scope.transformChip = function(chip) {
        if (angular.isObject(chip)) {
            return chip;
        }
        if(IsEmail(chip)!= null){
            return {valor:chip};
        }

        return null;
    };

    $scope.$parent.OpenContactMail = function(calback){

        if(calback){
            $scope.calback=calback;
        }else{
            delete  $scope.$scope.calback;
        }
        $mdSidenav("addEMail").open().then(function(){
            $scope.isOpen= true;
            $scope.to =[];
            $scope.cc =[];
            $scope.cco =[];
            $scope.correos = [];
            $scope.usePersonal= true;
            $scope.FormaddEMail.$setPristine();
            $scope.FormaddEMail.$setUntouched();

            $scope.asunto='';
            $scope.text='';
            Order.query({type:'ProviderEmails',prov_id:$scope.$parent.provSelec.id},{},function(response){
                $scope.correos= response;

            });
        });
    };

    $scope.close = function(e){
        if(jQuery(e.target).parents("#lyrAlert").length == 0
            && jQuery(e.target).parents("#addEMail").length == 0
            && jQuery(e.target).parents("#noti-button").length == 0
            && jQuery(e.target).parents(".md-autocomplete-suggestions").length == 0
            && jQuery(e.target).parents(".md-chip-remove").length == 0
            &&  jQuery(e.target).attr("id") != "blockXLevel"
            && $scope.isOpen
        ){
            $mdSidenav("addEMail").close().then(function(){
                $scope.isOpen = false;
                $scope.destinos.splice(0,  $scope.destinos.length);
                $scope.emailToText='';
                $scope.useMailSyte= false;
            });
        }

    };

    $scope.addEmail = function(chip){
        $scope.destinos.push(chip.valor+chip.razon_social);

    };

    $scope.removeEmail = function(chip){
        var index = $scope.destinos.indexOf(chip.valor+chip.razon_social);
        $scope.destinos.splice(index,1);
    };
    $scope.isAddMail = function(val){
        return  $scope.destinos.indexOf(val.valor+val.razon_social) === -1;
    };

    $scope.send = function(){
        if($scope.destinos.length == 0){
            $scope.NotifAction("error","Por favor selecione al menos un destinatario",[],{autohidden:SYSTEM.noti_autohidden});

        }else{
            $scope.inProgress= true;
            App.setBlock({block:true, level:89});

            Order.postMod({type:$scope.formMode.mod, mod:"Send"},
                {id:$scope.document.id, to:$scope.to, cc:$scope.cc, cco:$scope.cco,local:$scope.usePersonal, asunto:$scope.asunto},
                function(response){
                    $scope.inProgress= false;
                    App.setBlock({block:false,level:0});

                    $mdSidenav("addEMail").close().then(function(){
                        $scope.isOpen = false;
                        if( $scope.calback){
                            $scope.calback(response.accion);
                            delete $scope.calback;
                        }

                    });


                });
        }

    }
}]);

MyApp.controller('OrderminiAddProductCtrl',['$scope','$timeout','$mdSidenav','Order','form',  function($scope, $timeout,$mdSidenav,Order, formSrv){

    $scope.defaultUrl =  {type:$scope.$parent.formMode.mod, mod:"SaveProductItem"};
    $scope.block= false;
    $scope.next = undefined;
    $scope.isOpen = false;
    $scope.select ={};
    $scope.event =undefined;
    $scope.$parent.OrderminiAddProductCtrl= function (data, url) {
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
            $timeout(function () {
                formSrv.setBind(false);
            },5);
        });

        $scope.select.asignado= true;
        if(fn){
            fn();
        }
    };
    $scope.delete = function (fn) {
        $scope.NotifAction("alert","Eliminado",[],{autohidden:1500});
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

MyApp.controller('OrderMailPreview',['$scope',"$sce",'setGetOrder','Order','IsEmail','SYSTEM','App', function($scope,$sce, setGetOrder,Order,IsEmail,SYSTEM, App){

    $scope.isLoad= false;
    $scope.template ={};
    $scope.idiomas =[];
    $scope.idioma= null;
    $scope.contactos =[];
    $scope.correos =[];
    $scope.to =[];
    $scope.cc =[];
    $scope.cco =[];
    $scope.destinos = [];

    $scope.$parent.openMailPreview = function(data){
        if(data){
            console.log("tienen calbacl");
            $scope.calback = data;
        }else{
            delete  $scope.calback;
        }
        $scope.$parent.LayersAction({open:{name:'previewEmail' ,before: function(){

            console.log("parent", $scope.$parent);
            Order.get({type:"ProviderContacts", prov_id: $scope.$parent.document.prov_id},{}, function(response){
                console.log("response contact",  response);
                $scope.idiomas= response.idiomas;
                $scope.idioma=response.default;
                $scope.contactos = response.contactos;
                $scope.correos.splice(0,$scope.correos.length);
                angular.forEach(response.contactos, function(cv){
                    angular.forEach(cv.email, function(ev){
                        $scope.correos.push({nombre:cv.nombre,valor:ev.valor,id:cv.id})
                    });
                });

                $scope.loadPreview();
            });
        }}});

    };

    $scope.transformChip = function (chip){
        if (angular.isObject(chip)) {
            console.log("es chipc", chip);
            return chip;
        }
        if(IsEmail(chip)!= null){
            return {nombre:'new',valor:chip};
        }
        return null;

    };

    $scope.addEmail = function(chip){
        $scope.destinos.push(chip.valor+chip.nombre);
    };
    $scope.removeEmail = function(chip){
        var index = $scope.destinos.indexOf(chip.valor+chip.nombre);
        $scope.destinos.splice(index,1);
    };
    $scope.isAddMail = function(val){
        return  $scope.destinos.indexOf(val.valor+val.razon_social) === -1;
    };
    $scope.loadPreview = function(){
        Order.htmlMod({type:$scope.$parent.formMode.mod, mod:'EmailEstimate',id:$scope.$parent.document.id, lang:$scope.idioma.iso_lang},{},function(response){
            $scope.template= $sce.trustAsHtml(response.body);
        });
    };
    $scope.exitValidate = function(){
        return true;
    }
    $scope.$parent.sendPreviewEmail = function(){
        if($scope.to.length == 0){
            $scope.$parent.NotifAction('error','Debe asignar al menos un destinatario',[],{autohidden:SYSTEM.noti_autohidden});
        }else{
            $scope.inProgress=true;
            App.setBlock({block:true, level:99});
            var html = angular.element("#templateContent");
            Order.postMod({type:$scope.$parent.formMode.mod,mod:"Send"} ,{id:$scope.$parent.document.id,asunto:$scope.asunto, texto:html.html(), to:$scope.to,cc:$scope.cc, cco:$scope.cco ,local:!$scope.usePersonal}, function(response){
                $scope.inProgress=false;
                App.setBlock({block:false, level:0});
                if($scope.calback){
                    console.log("calback",response );
                    $scope.calback(response);
                }
            });
        }
    }

}]);

/**
 * controller for mdsidenav mail, this controller is responsable de send correo option
 * */
MyApp.controller('MailCtrl',['$scope','SYSTEM','IsEmail','Order', function($scope,SYSTEM,IsEmail, Order){
    $scope.destinos =[];
    $scope.cc =[];
    $scope.cco =[];
    $scope.correos = [];
    $scope.inProgress=false;
    $scope.transformChip = function(chip) {
        if (angular.isObject(chip)) {
            return chip;
        }
        if(IsEmail(chip)!= null){
            return {valor:chip,razon_social:'new'};
        }

        return null;
    };
    $scope.$parent.openEmail= function(){
        $scope.to =[];
        $scope.cc =[];
        $scope.cco =[];
        $scope.correos = [];
        $scope.usePersonal= true;
        $scope.showHead =true;
        $scope.mail.$setPristine();

        $scope.$parent.LayersAction({open:{name:"email", after: function(){
            Order.query({type:'Emails'},{},function(response){
                $scope.correos = response;
                $scope.usePersonal= true;
                $scope.mail.$setPristine();
                $scope.mail.$setUntouched();
                $scope.to =[];
                $scope.cc =[];
                $scope.cco =[];
                $scope.asunto="";
                $scope.texto="";
            });
        }}});

    };

    $scope.addEmail = function(chip){
        $scope.destinos.push(chip.valor+chip.razon_social);
    };

    $scope.removeEmail = function(chip){
        var index = $scope.destinos.indexOf(chip.valor+chip.razon_social);
        $scope.destinos.splice(index,1);
    };
    $scope.isAddMail = function(val){
        return  $scope.destinos.indexOf(val.valor+val.razon_social) === -1;
    };

    $scope.send = function(){
        if($scope.to.length == 0){
            $scope.$parent.NotifAction('error','Debe asignar al menos un destinatario',[],{autohidden:SYSTEM.noti_autohidden});
        }
        else if(!$scope.mail.$valid){
            $scope.$parent.NotifAction('error','Por favor asigne un texto',[],{autohidden:SYSTEM.noti_autohidden});

        }else{
            $scope.inProgress=true;
            Order.post({type:"Mailsend"} ,{asunto:$scope.asunto, texto:$scope.texto, to:$scope.to,cc:$scope.cc, cco:$scope.cco ,local:!$scope.usePersonal}, function(response){
                $scope.inProgress=false;
                $scope.$parent.LayersAction({close:true});
            });
        }
    }


}]);

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
 MyApp.service('vlMiniSideNav',function () {
 var obj = function (key ) {
 var bind  = {estado:false, key:key}
 return {}
 }

 return function ( key, data) {
 var model =  new obj(key);
 angular.forEach(data, function (v, k) {
 model[k] = v;
 })
 };
 });*/


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
            if(typeof (value) == 'undefined'){
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
                    if (response.fecha_aprob_compra = !null && response.fecha_aprob_compra) {
                        order.fecha_aprob_compra = DateParse.toDate(response.fecha_aprob_compra);
                    }

                    if (response.ult_revision = !null && response.ult_revision) {
                        order = DateParse.toDate(response.ult_revision);
                    }

                    forms = {};
                    forms['document']={};
                    order['objs'] ={};

                    angular.forEach(response,function(v,k){
                        if(!order[k]){
                            order[k]= v;
                            if(v !=null && typeof (v) != 'object' && typeof (v) != 'array' && !isNaN(k)){
                                forms['document'][k]={original:v, v:v, estado:'new',trace:[]};
                            }

                        }
                    });


                    angular.forEach(response.productos.contraPedido, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !isNaN(k2)){
                                if(!forms['contraPedido'+ v.id]){
                                    forms['contraPedido'+ v.id] ={};
                                }
                                forms['contraPedido'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });
                    angular.forEach(response.productos.kitchenBox, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !isNaN(k2)){
                                if(!forms['kitchenBox'+ v.id]){
                                    forms['kitchenBox'+ v.id] ={};
                                }
                                forms['kitchenBox'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });

                    angular.forEach(response.productos.pedidoSusti, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !isNaN(k2)){
                                if(!forms['pedidoSusti'+ v.id]){
                                    forms['pedidoSusti'+ v.id] ={};
                                }
                                forms['pedidoSusti'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });
                    angular.forEach(response.productos.todos, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !isNaN(k2)){
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
            order={};
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
MyApp.factory('Order', ['$resource',
    function ($resource) {
        return $resource('Order/:type/:mod', {}, {
            query: {method: 'GET',params: {type: ""}, isArray: true},
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
 * filtra para buscar dentro de array de json
 * @param data el array de objetos
 * @param compare el valor a evaluar
 * @param key clave que corresponde al json
 *@return un array de resultados
 * **/
MyApp.filter('stringKey', function() {

    return function(data,compare, key) {
        return (!data) ? [] :data.filter(function(val) {
            return (!val[key] || !compare || typeof(compare)=='undefined' || compare.length == 0 ) ? true:  val[key].toLowerCase().indexOf(compare.toLowerCase())!==-1;
        });
    }
});

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

                if(viewValue === undefined || viewValue=="" || viewValue==null || viewValue == 'NaN' ){
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
