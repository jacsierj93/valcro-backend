
MyApp.controller('PedidosCtrll', function ($scope,$mdSidenav,$timeout,$interval
    ,$filter,$location,App, Order,masters,providers,
                                           Upload,Layers,setGetOrder, DateParse, Accion,filesService,clickerTime,SYSTEM) {

    var autohidden= SYSTEM.noti_autohidden;
    $scope.permit= Order.get({type:"Permision"});
    // controlers
    $scope.Docsession = {isCopyable:false,global:"new", block:true};

    $scope.email= {};
    $scope.email.destinos =[];
    $scope.email.content =[];
    $scope.formMode ={};
    $scope.tempDoc= {};
    $scope.emails = [];
    $scope.docImports= [];
    $scope.providerProds= [];
    $scope.docsSustitos= [];
    $scope.estadosDoc=[];
    $scope.isTasaFija= true;
    $scope.skiPro = [];
    $scope.navCtrl = Accion.create();
    $scope.previewHtmltext = "Introdusca texto ";
    $scope.previewHtmlDoc ="";
    $scope.layer= undefined;
    $scope.index= 0;
    $scope.formData ={direccionesFact:[],monedas:[], paises :[], condicionPago:[] , direcciones:[], puertos:[]};
    $scope.formDataContraP ={};
    $scope.clickerTime = clickerTime;

    filesService.setFolder('orders');
    $scope.filesProcess = filesService.getProcess();

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

    $scope.alerts = [];
    var timePreview;
    // filtros
    $scope.filterProv ={

    };
    $scope.fRazSocial="";
    $scope.fPais="";
    $scope.fpaisSelec="";
    $scope.email.contactos = [];
    $scope.emailToText = null;
    $scope.emailText = "demo";
    $scope.emailAsunto = "demo";
    $scope.productoSearch={};

    $scope.showFilterPed=false;
    $scope.showLateralFilter=false;
    $scope.showLateralFilterCpl=false;
    $scope.imgLateralFilter="images/Down.png";
    $scope.selecPed=false;
    $scope.preview=true;
    $scope.mouseProview= false;
    $scope.gridView = 1;
    //$scope.gridViewCp= 1;
    $scope.gridViewSus= 1;
    $scope.gridViewFinalDoc= 1;
    $scope.productTexto="";
    $scope.currenSide = null;
    $scope.unclosetDoc = [];
    $scope.provDocs = [];
    $scope.provSelec ={};
    $scope.document  = setGetOrder.getOrder();
    $scope.docBind= setGetOrder.bind();
    $scope.contraPedSelec ={};
    $scope.pedidoSusPedSelec={};
    $scope.paises = {};
    $scope.todos =[];
    $scope.priorityDocs ={};
    $scope.priorityDocs.dias="0";
    $scope.priorityDocs.docs=[];

    // final doc
    $scope.switchBack=  {
        head:{model:true,change:false},
        contraPedido:{model:true,change:false},
        kichenBox:{model:true,change:true},
        pedidoSusti:{model:true,change:false}

    };

    //// tablas

    $scope.docOrder ={};
    $scope.docOrder.order ='id';
    Order.get({type:"OrderProvList"},{},function(response){
        $scope.todos = response.proveedores;
        $scope.paises = response.paises;
        /*$timeout(function(){
         angular.forEach(response, function(v){
         /!*angular.forEach(function(v.paises))*!/
         });

         }, 100);*/

    });

    $timeout(function(){$scope.init();


        /*$timeout(function(){
         $scope.NotifAction("info", "Tutorial",[{name:"Aceptar",action:function (){
         console.log("sdfasdf");
         }}],{block:true} );
         },400)*/


    },0);



    $scope.getAlerts = function(){
        Order.query({type:'Notifications'},{}, function(response){
            $scope.alerts  =response;
            if( $scope.alerts.length > 0 && $scope.module.index == 0){
                $mdSidenav("moduleMsm").open();
            }
        });

    };

    $scope.openUncloseDoc = function (){
        $scope.navCtrl.value="unclosetDoc";
        $scope.navCtrl.estado=true;
    };

    $scope.openOldDocs = function (){
        $scope.LayersAction({open:{name:"priorityDocs",
            before: function(){
                Order.get({type:"OldReviewDocs"},{}, function(response){
                    $scope.priorityDocs =response;
                });
            }, after: function(){
            }
        }});
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
        // oldVersionSelect
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

    $scope.init = function () {
        $scope.estadosDoc = masters.query({type: 'getOrderStatus'});
        $scope.getAlerts();
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
            }else{
                $scope.NotifAction("error","Debe  Actualizar o Copiar antes de poder modificar",[],{autohidden:2500});
            }
        }
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


    /// cancelar no definido
    $scope.cancelDoc = function(){

        clickerTime({to:['#detalleDoc div.activeleft ','#detalleDoc #docCancel', '#detalleDoc input#mtvCancelacion '],time:400, calback: function(){
            console.log("last" );
            angular.element("#detalleDoc input#mtvCancelacion")[0].focus();
        }})
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


    $scope.copyDoc = function() {

        Order.postMod({type:$scope.formMode.mod, mod:"Copy"},{id:$scope.document.id}, function(response){
            setGetOrder.reload({id:response.id,tipo: $scope.formMode.value});
            $scope.NotifAction("ok","Nueva version creada",[],{autohidden:autohidden});
            $scope.Docsession.block= false;
            $scope.navCtrl.value="detalleDoc";
            $scope.navCtrl.estado=true;
            setGetOrder.change("document", 'id', response.id);
            filesService.close();
            filesService.clear();
            filesService.setFolder("orders");



        });
    };


    /********************************************DEBUGGIN ********************************************/


    $scope.test = function (test) {
        alert(test);
        console.log("tet", test);
        console.log("escope", $scope);
    };

    $scope.demo = function(){
        $scope.openMailPreview(function(){alert("dsf");});



    };
    /********************************************DEBUGGIN ********************************************/

    $scope.buildfinalDoc = function(){
        var final={};
        var cp= [];
        var kit =  [];
        var sus = [];
        var changeItems= false;
        var carefull=false;
        console.log("$scope.switchBack",$scope.switchBack)
        console.log("form",setGetOrder.getForm());
        ///var todos = new Array();
        angular.forEach(setGetOrder.getForm(), function(v,k){
                if(k.startsWith('contra')){
                    cp.push(v);
                    if(v.estado != 'new'){
                        $scope.switchBack.contraPedido.change= true;
                        $scope.switchBack.changeItems.change=true;
                        changeItems= true;
                        console.log("cambio c", v);

                    }

                }else
                if(k.startsWith('kitchen')){
                    kit.push(v);
                    if(v.estado != 'new'){
                        $scope.switchBack.kichenBox.change= true;
                        $scope.switchBack.changeItems.change=true;
                        console.log("cambio k", v);
                        changeItems= true;
                    }
                }
                else
                if(k.startsWith('pedidoSusti')){
                    sus.push(v);
                    if(v.estado != 'new'){
                        $scope.switchBack.pedidoSusti.change= true;
                        $scope.switchBack.changeItems.change=true;
                        console.log("cambio p", v);

                        changeItems= true;
                    }
                }
            }

        );
        angular.forEach(setGetOrder.getForm('document'), function(v,k){
                final[k]=v;
                if(v.estado != 'new'){
                    $scope.switchBack.head.change= true;
                    $scope.switchBack.changeItems.change=true;
                }
                /*if(k = ''){
                 31-05-12
                 }*/
            }

        );


        final.contraPedido = cp;
        final.kitchenBox = kit;
        final.pedidoSusti = sus;
        final.changeItems = changeItems;
        console.log("final ", final);
        return final;
    };


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

    // documentos
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
    $scope.openImport = function(){


        if($scope.Docsession.block ){
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
        $scope.LayersAction({close:{all:true}});
        $scope.LayersAction({open:{name:"menuAgr", before: function(){

            setGetOrder.clear();
        }}});
        $scope.gridView= 1;
        $scope.preview =false;

    };



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

    };

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

    $scope.selecPedidoSust =function (item) {
        $scope.pedidoSusPedSelec ={};
        $scope.LayersAction({open:{name:"resumenPedidoSus",
            after: function(){
                Order.get({type:"OrderSubstitute", id:item.id,tipo:$scope.formMode.value,doc_id: $scope.document.id}, {},function(response){
                    $scope.pedidoSusPedSelec = response;
                    $scope.pedidoSusPedSelec.emision = DateParse.toDate(response.emision);
                });

            }}});

    };

    $scope.selecKitchenBox=  function(item) {

        $scope.LayersAction({open:{name:"resumenKitchenbox", before: function(){

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
                setGetOrder.setOrder(angular.copy($scope.resumen));
                $scope.Docsession.isCopyableable = true;

                $scope.formMode= $scope.forModeAvilable.getXname($scope.resumen.documento);
                $scope.navCtrl.value = "detalleDoc" ;
                $scope.navCtrl.estado= true;
                return;
                break;
            case "detalleDoc":
                $scope.LayersAction({search:{name:"listProducProv",
                    before:function(){
                        $scope.providerProds = [];
                        Order.query({type:"ProviderProds", id:$scope.provSelec.id,tipo:$scope.formMode.value, doc_id:$scope.document.id},{}, function(response){
                            // var data =[];
                            // var aux ={};
                            angular.forEach(response , function(v,k){
                                //aux ={};
                                //aux = v;
                                v.saldo=parseFloat(v.saldo);
                                $scope.providerProds.push(v);
                            });
                            // $scope.providerProds= data;
                        });
                    },
                    after: function(){
                        //if(setGetOrder.getState() == 'new');
                        //$timeout(function(){
                        //    //setGetOrder.setOrder($scope.document);
                        //},0)
                    }
                }});
                /*  $scope.navCtrl.value = "listProducProv" ;
                 $scope.navCtrl.estado= true;*/
                break;
            case "listProducProv":



                $scope.LayersAction({search:{name:"agrPed",before: function(){}}});

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
        $scope.showNext(false);



    };
    $scope.showNext = function (status) {
        if (status) {
            if($scope.module.layer == 'detalleDoc'){
                if (!$scope.FormHeadDocument.$valid && $scope.module.layer == 'detalleDoc') {
                    $scope.NotifAction("error",
                        "Existen campos pendientes por completar, por favor verifica que información le falta."
                        ,[],{autohidden:autohidden});

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


                }else  if($scope.module.layer == 'detalleDoc' && !$scope.FormAprobCompras.$pristine)
                {
                } else{
                    $mdSidenav("NEXT").open();
                }
                /*else if(!$scope.FormAprobCompras.$valid && !$scope.FormAprobCompras.$pristine ){
                    $scope.NotifAction("error",
                        "¿Desea cancelar la aprobacion de la"+$scope.formMode.name+" ?"
                        ,[{name:"si",
                            action:function (){
                                $mdSidenav("NEXT").open();
                                $scope.document.nro_doc= null;
                                $scope.document.fecha_aprob_compra= null;
                                $scope.FormAprobCompras.$setDirty();

                            }
                        }, {name:"No",
                            action:function (){
                                $timeout(function(){
                                    var inval = angular.element(" form[name=FormAprobCompras] .ng-invalid ");
                                    if(inval[0]){
                                        inval[0].focus();
                                    }else{
                                        inval = angular.element(" form[name=FormAprobCompras] ng-untouched");
                                        console.log(" terro ", inval)
                                        inval[0].focus();
                                    }
                                },0);

                            }
                        }],{autohidden:autohidden});
                }*/

            } else if($scope.module.layer == 'listProducProv'){
                if (!$scope.listProductoItems.$valid && $scope.module.layer== 'listProducProv') {

                    $scope.NotifAction("error",
                        "No se pueden asignar productos sin asignarle una cantidad verifique que todos los productos tienen cantidad correctas"
                        ,[],{autohidden:autohidden});

                } else {
                    $mdSidenav("NEXT").open();
                }
            }else {
                $mdSidenav("NEXT").open();
            }
        } else {
            $mdSidenav("NEXT").close()
        }

    };

    $scope.reloadSide = function(){

    };
    /*********************************************** EVENTOS CHANGE ***********************************************/


    $scope.changeContraP = function (item) {
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


    };

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
        /*

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
         */
    };

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

    $scope.clearSelec = function(obj){
        if(!obj){
            delete obj;
        };
    }
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
    $scope.addRemoveCpItem = function(item){
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



    };

    $scope.addRemoveDocSusItem = function(item){
        var aux = {
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
            $scope.addRemoveKitchenBox(item);
        }

    };

    $scope.addRemoveKitchenBox = function(item){

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
                    }else{
                        Order.postMod({type: $scope.formMode.mod, mod: "AddkitchenBox"}, item, function (response) {
                            $scope.NotifAction("ok", "Asignado", [], {autohidden: autohidden});
                            setGetOrder.change('kitchenBox'+item.id,'id',item);
                        });
                    }

                });
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

    /*********************************************** EVENTOS FOCUS LOST ***********************************************/


    $scope.setProvedor =function(prov) {

        if( $scope.module.index == 0){
            $scope.LayersAction({open:{name:"listPedido", after:function(){
                $scope.ctrl.provSelec = prov;
                loadPedidosProvedor(prov.id);
            }}});
        }else if($scope.module.layer == "listPedido"){

            $scope.ctrl.provSelec = prov;
            loadPedidosProvedor(prov.id);
        }else if($scope.module.layer == "detalleDoc"){
            if($scope.document.uid != null){
                if($scope.ctrl.provSelec == null){
                    $scope.ctrl.provSelec=prov;
                }else if($scope.ctrl.provSelec.id != prov.prov_id){
                    $scope.ctrl.provSelec=prov;
                }
            }else{
                $timeout(function(){
                    var elem=angular.element("#prov"+$scope.ctrl.provSelec.id);
                    angular.element(elem).parent().scrollTop(angular.element(elem).outerHeight()*angular.element(elem).index());
                    elem[0].focus();
                },1);
            }

        }else if($scope.module.layer != "listPedido" && !$scope.provSelec.id){

            $scope.LayersAction({close:{init:true, after: function(){
                $scope.LayersAction({open:{name:"listPedido", after:function(){
                    $scope.ctrl.provSelec = prov;
                    loadPedidosProvedor(prov.id);
                }}});
            }}});
        }
        else if($scope.module.layer != "listPedido" && $scope.provSelec.id){
            if( setGetOrder.getInternalState() == 'new'){
                $scope.LayersAction({close:{all:true, after: function(){
                    $scope.LayersAction({open:{name:"listPedido", after:function(){
                        $scope.ctrl.provSelec = prov;
                        loadPedidosProvedor(prov.id);
                    }}});
                }}});
            }else{
                var focus = angular.element(":focus");
                $scope.NotifAction("alert","Se han realizado cambio en la "+$scope.formMode.name+ " ¿esta seguro de salir sin culminar?",[
                    {
                        name:"No",
                        action: function(){
                            focus.focus();
                        }
                    },
                    {
                        name:"Si",
                        action: function(){
                            $scope.LayersAction({close:{all:true, after: function(){
                                $scope.LayersAction({open:{name:"listPedido", after:function(){
                                    $scope.ctrl.provSelec = prov;
                                    loadPedidosProvedor(prov.id);
                                }}});
                            }}});


                        }
                    }

                ],{block:true});

            }



        }
    };

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

    $scope.DtPedido = function (doc) {
        // setGetOrder.clear();
        $scope.gridView= 1;
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

        }
    };

    $scope.openTempDoc = function(doc){
        $scope.gridView= 1;
        var aux= angular.copy(doc);
        if (segurity('editPedido')) {
            setGetOrder.setOrder(aux);
            setGetOrder.setState("select");
            $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
            $scope.preview=false;
            $scope.navCtrl.value="detalleDoc";
            $scope.navCtrl.estado=true;

            $scope.Docsession.global=(!doc.uid && !doc.final_id) ? 'upd' : 'temp';
            $scope.Docsession.block = (!doc.uid) ;
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

    $scope.saveFinal = function(){
        var accions = {};

        angular.forEach($scope.switchBack, function(v,k){
            accions[k] = v.change;
        });
        Order.postMod({type:$scope.formMode.mod, mod:"CloseAction"},{id:$scope.document.id,accion:accions, seccion:$scope.Docsession.global }, function(response){
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
                    console.log("no se que hacer");
                }
            }
        });
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

    $scope.excepProdFinal = function(item){

        if(!$scope.isOpenexcepAddCP){
            angular.element(document).find("#finalDoc").find("#expand").animate({width:"336px"},400);

            $mdSidenav("excepAddCP").open().then(function(){
                $scope.isOpenexcepAddCP = true;
            });

        }
        $scope.finalProdSelec = item;


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

    $scope.isOpencreateProd = false;
    $scope.createProduct = function(item){

        if(item && item.saldo  && item.descripcion){
            var copy= angular.copy(item);
            copy.prov_id =$scope.provSelec.id;
            Order.post({type:"CreateTemp"},copy,function(response){
                var aux ={asignado:false,cantidad:parseFloat(response.cantidad),saldo:parseFloat(response.saldo),codigo:response.codigo,codigo_fabrica :response.codigo_fabrica,
                    descripcion :response.descripcion,id: response.id,otre:null,puntoCompra:false,stock:0,tipo_producto:response.tipo_producto,
                    tipo_producto_id:response.tipo_producto};
                $scope.providerProds.push(aux);
                $timeout(function(){
                    aux.asignado= true;
                    $scope.changeProducto(aux);
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


        }
    };

    $scope.openCreateProduct = function(){
        if(!$scope.isOpencreateProd){
            $mdSidenav("createProd").open().then(function(){
                $scope.isOpencreateProd = true;
            });
        }
    };
    $scope.CloseCreateProduct = function(e){
        if($scope.isOpencreateProd
            && jQuery(e.target).parents("#lyrAlert").length == 0
            && jQuery(e.target).parents("#noti-button").length == 0
        ){
            $mdSidenav("createProd").close().then(function(){
                $scope.isOpencreateProd= false;
                if($scope.createdProd.$valid){
                    $scope.createProduct(angular.copy($scope.createProd));

                }
                $scope.createProd ={};
                $scope.createdProd.$setPristine();
            });
        }
    };
    /*************Notificaciones ******/
    /*$scope.openNotis  = function(){
     if($scope.module.index== 0){
     $mdSidenav("moduleMsm").open();
     }
     };*/

    $scope.openNoti = function(key){
        $scope.navCtrl.value=key;
        $scope.navCtrl.estado=true;
        $mdSidenav("moduleMsm").close();
    };

    $scope.closeNotis= function(e){
        if(jQuery(e.target).parents("#lyrAlert").length == 0
            && jQuery(e.target).parents("#noti-button").length == 0
            && $scope.index == 0
        ) {
            if($mdSidenav("moduleMsm").isOpen()){
                $mdSidenav("moduleMsm").close();
            }
        }
    };

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
    $scope.$watch('ctrl.provSelec', function (newVal) {
        if(newVal ){
            if($scope.provSelec.id != newVal.id){
                $scope.provSelec= newVal;
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
                },0)
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

    $scope.$watch('document.objs.direccion_facturacion_id', function (newVal) {

        if(newVal ){

            $scope.document.direccion_facturacion_id = newVal.id;
            if( $scope.Docsession.global != 'new'){
                setGetOrder.change("document","direccion_facturacion_id",newVal.id);
            }
        }

    });

    $scope.$watch('document.objs.direccion_almacen_id', function (newVal) {



        if(newVal ){

            $scope.document.direccion_almacen_id = newVal.id;
            $scope.ctrl.puerto_id= null;
            Order.query({type:"AdrressPorts", direccion_id: newVal.id},{}, function(response){
                $scope.formData.puertos = response;
            });
            if( angular.equals(angular.element("#detalleDoc #direccion_almacen_id input[type=search]"),angular.element(":focus"))){
                setGetOrder.change("document","direccion_almacen_id",newVal.id);
            }
        }else{
            if( angular.equals(angular.element("#detalleDoc #direccion_almacen_id input[type=search]"),angular.element(":focus"))){
                $scope.document.direccion_almacen_id= null;
                $scope.ctrl.puerto_id= null;
                setGetOrder.change("document","direccion_almacen_id",undefined);
                setGetOrder.change("document","puerto_id",undefined);

            }


        }

    });

    $scope.$watch('document.objs.prov_moneda_id', function (newVal) {

        /*if(newVal ){

         $scope.document.prov_moneda_id = newVal.id;
         if( $scope.Docsession.global != 'new' && $scope.$){
         setGetOrder.change("document","prov_moneda_id",newVal.id);
         }
         masters.get({type:'getCoin',id:newVal.id},{}, function(response){
         var tasa = parseFloat(response.precio_usd);
         if(!$scope.document.tasa ||  $scope.Docsession.global == "new"){
         $scope.document.tasa = tasa;
         }else {
         if(tasa != $scope.document.tasa  && !$scope.Docsession.block && $scope.layer == "detalleDoc"){
         $scope.NotifAction("alert","La tasa fue cambiada segun moneda selecionada ",[],{autohidden:autohidden});
         $scope.document.tasa = tasa;
         $scope.isTasaFija= true;
         }
         }
         });
         }*/

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
            $scope.document.prov_moneda_id= newVal.id;
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
    $scope.$watch('document.objs.condicion_pago_id', function (newVal) {

        if( angular.equals(angular.element("#detalleDoc #condicion_pago_id input[type=search]"),angular.element(":focus"))){


            if(newVal ){
                if(newVal != 0){
                    $scope.document.condicion_pago_id = newVal.id;
                    setGetOrder.change("document","condicion_pago_id", newVal.id);
                }
            }else{
                setGetOrder.change("document","condicion_pago_id",undefined);
            }
        }

    });
    $scope.$watch('document.objs.puerto_id', function (newVal) {

        if( angular.equals(angular.element("#detalleDoc #puerto_id input[type=search]"),angular.element(":focus"))){

            if(newVal ){
                if(newVal != 0){
                    $scope.document.puerto_id = newVal.id;
                    setGetOrder.change("document","puerto_id", newVal.id);
                }
            }else{
                if(!$scope.Docsession.block){
                    $scope.document.puerto_id= null;
                    setGetOrder.change("document","puerto_id",undefined);
                }
            }
        }

    });


    /****** **************************listener ***************************************/

    $scope.$watch('docBind.estado', function(newVal){
        if(newVal){
            $scope.document=setGetOrder.getOrder();
            $scope.docBind.estado= false;
            if( $scope.document.prov_id && ($scope.ctrl.provSelec == null || $scope.ctrl.provSelec.id !=$scope.document.prov_id )){
                Order.get({type:"Provider",  id: $scope.document.prov_id},{}, function(response){
                    $scope.ctrl.provSelec=response;
                });
            }
        }

    });



    $scope.$watch('navCtrl.estado', function (newState) {
        if(newState){
            var newVal  = $scope.navCtrl.value;

            if (newVal != '' && typeof(newVal) !== 'undefined' && newVal != null){
                switch (newVal){
                    case "detalleDoc":
                        $scope.LayersAction({search:{name:"detalleDoc",
                            before: function(){
                                $scope.FormHeadDocument.$setUntouched();
                                $scope.FormEstatusDoc.$setUntouched();
                                $scope.FormAprobCompras.$setUntouched();
                                $scope.FormCancelDoc.$setUntouched();

                            },
                            after: function(){
                                $scope.isTasaFija=true;
                            }
                        }})
                        ;break;
                    case "resumenPedido":
                        $scope.LayersAction({search:{name:"resumenPedido",
                            after: function(){

                            }
                        }});
                        break;
                    case "listPedido" :
                        $scope.LayersAction({search:{name:"listPedido",
                            before: function(){
                                $scope.provDocs = [];
                                loadPedidosProvedor($scope.provSelec.id, function(){
                                    $timeout(function(){
                                        if($scope.provDocs.length > 0){
                                            var mo= jQuery("#listPedido").find('.cellSelect')[0];
                                            mo.focus();
                                        }
                                    }, 100);
                                });
                                $scope.hoverPreview(true);
                            },
                            after: function(){



                            }
                        }});
                        break;
                    case "agrContPed":
                        $scope.LayersAction({search:{name:"agrContPed",
                            after: function(){
                                $scope.formData.contraPedido = Order.query({type:"CustomOrders",  prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value});
                            }
                        }});
                        break;
                    case "agrKitBoxs":

                        $scope.LayersAction({search:{name:"agrKitBoxs",
                            before : function(){
                                $scope.formData.kitchenBox=[];
                                $scope.formData.kitchenBox = Order.query({type:"KitchenBoxs",  prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value});

                            },
                            after: function(){

                            }
                        }});
                        break;
                    case "listProducProv":

                        break;
                    case "listImport":
                        $scope.LayersAction({search:{name:"listImport",
                            before: function(){
                                if($scope.formMode.value !=21 ){
                                    var url='';
                                    switch ($scope.formMode.value){
                                        case  22: url = "SolicitudeToImport";break;
                                        case  23: url = "OrderToImport";break;
                                    }
                                    Order.query({type: url, id:$scope.document.id,tipo:$scope.formMode.value, prov_id:$scope.provSelec.id},{},function(response){
                                        var data = [];
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
                        $scope.LayersAction({search:{name:"listEmailsImport",
                            after: function(){

                            }
                        }});
                        break;
                    case "agrPed":


                        break;
                    case "finalDoc":
                        $scope.LayersAction({search:{name:"finalDoc",
                            before: function(){

                                if(  setGetOrder.getState() != "built"){

                                    $scope.switchBack=  {
                                        head:{model:true,change:false},
                                        aprob_compras:{model:false,change:false},
                                        aprob_gerencia:{model:false,change:false},
                                        cancelacion:{model:false,change:false},
                                        contraPedido:{model:false,change:false},
                                        kichenBox:{model:false,change:false},
                                        pedidoSusti:{model:false,change:false},
                                        changeItems:{model:false,change:false}

                                    };
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
                        $scope.LayersAction({search:{name:"agrPedPend",
                            before:function(){
                                $scope.docsSustitos =[];
                                Order.queryMod({type:$scope.formMode.mod,mod:"Substitutes", doc_id:$scope.document.id, prov_id:$scope.provSelec.id},{},function(response){

                                    angular.forEach(response, function(v,k){
                                        if(v.emision){
                                            v.emision= DateParse.toDate(v.emision);
                                        }
                                        $scope.docsSustitos.push(v);
                                    });

                                });

                            },
                            after: function(){
                            }
                        }});
                        break;
                    case  "close":

                        if(setGetOrder.getInternalState() == 'new' && $scope.document.final_id){
                            $scope.NotifAction("ok","Sin cambios no se llevara a cabo ninguna accion",[
                                {name:"ok", default: 2,action:function(){
                                    $scope.LayersAction({close:{first:true, search:true}});
                                }}
                            ],{block:true});
                        }else {

                            $scope.saveFinal();
                        }
                        break;
                    case "unclosetDoc":
                        $scope.LayersAction({search:{name:"unclosetDoc",
                            after: function(){
                                $scope.unclosetDoc =[];
                                Order.query({type:"UnClosetDoc"},{},function(response){
                                    angular.forEach(response, function(v){
                                        v.emision= DateParse.toDate(v.emision);
                                        $scope.unclosetDoc.push(v);
                                    });
                                    if($scope.unclosetDoc.length == 0){
                                        $scope.LayersAction({close:{search:true}});
                                    }else{
                                        $timeout(function(){
                                            var mo= jQuery("#unclosetDoc").find('.cellSelect')[0];
                                            mo.focus();

                                        }, 100);
                                    }



                                });
                                $scope.tempDoc= {};

                            }
                        }});

                        break;
                    case "priorityDocs":;
                        $scope.LayersAction({open:{name:"priorityDocs",
                            before: function(){
                            }, after: function(){
                                $scope.priorityDocs.docs =[];
                                Order.get({type:'OldReviewDocs'},{}, function(response){
                                    angular.forEach(response.docs, function(v){
                                        v.emision = DateParse.toDate(v.emision);
                                        $scope.priorityDocs.docs.push(v);
                                    });
                                    if($scope.priorityDocs.docs.length > 0){
                                        $timeout(function(){
                                            var mo= jQuery("#priorityDocs").find('.cellSelect')[0];
                                            mo.focus();

                                        }, 300);
                                    }


                                });
                            }
                        }});
                        break;
                    default : $scope.LayersAction({close:true});


                }

                /***   multiples */


            }
        }
        $scope.navCtrl.estado=false;
    });


    $scope.$watch("Docsession.block",function(newVal){
        if(newVal == true){
            filesService.setAllowUpload(false);



        }else if( newVal == false){
            filesService.setAllowUpload(true);
        }

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

    $scope.$watchGroup(['FormHeadDocument.$valid', 'FormHeadDocument.$pristine'], function (newVal) {
        if(!newVal[1] &&  $scope.formMode.mod){
            $scope.document.prov_id = angular.copy($scope.provSelec.id);
            Order.postMod({type:$scope.formMode.mod, mod:"Save"},$scope.document, function(response){

                $scope.FormHeadDocument.$setPristine();
                if(!$scope.Docsession.msmNext && $scope.FormHeadDocument.$valid){
                    if($scope.Docsession.global == 'new'){
                        $scope.NotifAction("ok", "Creado puede continuar" , [],{autohidden:2000});
                    }else{
                        $scope.NotifAction("ok", "Puede continuar" , [],{autohidden:2000});
                    }
                    $scope.Docsession.msmNext= true;
                }
                $scope.document.uid= response.uid;
            });
        }
    });


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




    $scope.sendAprob = function(){
        var state= 'waith';
        var  saveAprob = function(){
                state='finish';
                if($scope.FormAprobCompras.$valid ){
                    $scope.NotifAction("ok", " La "+$scope.formMode.name+" a sido aprobada ",[ ],{autohidden:1500});

                }else{
                    $scope.NotifAction("alert", " La "+$scope.formMode.name+" no se a aprobado",[/*{name:"Esta", action:function(){}} */],{autohidden:1500});
                    $timeout(function(){
                        var inval = angular.element(" form[name=FormAprobCompras] .ng-invalid ");
                        if(inval[0]){
                            inval[0].focus();
                        }else{
                            inval = angular.element(" form[name=FormAprobCompras] ng-untouched");
                            inval[0].focus();
                        }
                    },1500);
                }

        };

        return  {
            save : function (){
                console.log("save");
                state='load';
                saveAprob();
            },
            isBlock: function(){
                return state;
            }
        }

    };

    $scope.saveAprobCompras  = function(e){

        if(!$scope.FormAprobCompras.$pristine){
            Order.postMod({type:$scope.formMode.mod, mod:"ApprovedPurchases"},$scope.document,function(response){$scope.FormAprobCompras.$setPristine()});
            if(e){
                if(jQuery(e.target).parents("#lyrAlert").length == 0
                    && jQuery(e.target).parents("#noti-button").length == 0
                    && jQuery(e.target).parents(".md-autocomplete-suggestions").length == 0
                    && jQuery(e.target).parents(".md-calendar-date").length == 0
                    &&  jQuery(e.target).attr("id") != "blockXLevel"){

                    if($scope.FormAprobCompras.$valid ){
                        Order.postMod({type:$scope.formMode.mod, mod:"ApprovedPurchases"},$scope.document,function(response){$scope.FormAprobCompras.$setPristine()});
                        $scope.NotifAction("ok", " La "+$scope.formMode.name+" a sido aprobada ",[ ],{autohidden:1500});

                    }else{
                        var focus = angular.element(":focus");
                        $scope.NotifAction("alert", " La "+$scope.formMode.name+" no se puede aprobar ¿Desea cancelar la aprobacion ?",[
                            {name:"Si", action:function(){
                                setGetOrder.change("document",'nro_doc',undefined);
                                setGetOrder.change("document",'fecha_aprob_compra',undefined);
                                $scope.document.nro_doc= null;
                                $scope.document.fecha_aprob_compra= null;
                                Order.postMod({type:$scope.formMode.mod, mod:"ApprovedPurchases"},$scope.document,function(response){$scope.FormAprobCompras.$setPristine()});
                                focus.focus();

                            }},
                            {name:"No, dejame corregirlos", action:function(){
                                Order.postMod({type:$scope.formMode.mod, mod:"ApprovedPurchases"},$scope.document,function(response){$scope.FormAprobCompras.$setPristine()});
                                $timeout(function(){
                                    var inval = angular.element(" form[name=FormAprobCompras] .ng-invalid ");
                                    if(inval[0]){
                                        inval[0].focus();
                                    }else{
                                        inval = angular.element(" form[name=FormAprobCompras] ng-untouched");
                                        inval[0].focus();
                                    }
                                },1500)
                            }}
                        ],{block:true});

                    }
                }
            }else{
                if(!$scope.FormAprobCompras.$valid ){
                    var focus = angular.element(":focus");
                    $scope.NotifAction("alert", " La "+$scope.formMode.name+" no se puede aprobar ¿Desea cancelar la aprobacion ?",[
                        {name:"Si", action:function(){
                            setGetOrder.change("document",'nro_doc',undefined);
                            setGetOrder.change("document",'fecha_aprob_compra',undefined);
                            $scope.document.nro_doc= null;
                            $scope.document.fecha_aprob_compra= null;
                            $mdSidenav("NEXT").open();
                            focus.focus();
                        }},
                        {name:"No, dejame corregirlos", action:function(){
                            $mdSidenav("NEXT").close();
                            $timeout(function(){
                                var inval = angular.element(" form[name=FormAprobCompras] .ng-invalid ");
                                if(inval[0]){
                                    inval[0].focus();
                                }else{
                                    inval = angular.element(" form[name=FormAprobCompras] ng-untouched");
                                    inval[0].focus();
                                }

                            },1500)
                        }}
                    ],{block:true});
                }
            }
        }
    };





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

    function loadPedidosProvedor(id, callback){
        $scope.provDocs = [];
        Order.query({type:"OrderProvOrder", id:id}, {},function(response){

            angular.forEach(response, function (v, k) {
                v.emision= DateParse.toDate(v.emision);
                v.monto= parseFloat(v.monto);
                v.tasa= parseFloat(v.tasa);
                if(v.ult_revision){
                    v.ult_revision= DateParse.toDate(v.ult_revision);
                }
                // v.isNew=false;
                $scope.provDocs.push(v);

            });
            if(callback){
                callback();
            }



            // $scope.provSelec.pedidos=items;
        });
    }

    /*********************************  peticiones  guardado $http ********************* ************/

    function segurity(key){
        return true;
    }

});

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
            },0)

            if(arg.open){
                open(arg.open, module);
            }else
            if(arg.close){

                close(arg.close,module);
            }else
            if(arg.search){
                search(arg.search, module);
            }else {
            }

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
            console.log("from ", form);
            console.log("fiel ", fiel);
            console.log("value ", value);

        }

        if(!forms[form][fiel] ){
            if(typeof (value) == 'object'){

                angular.forEach(value, function(v2,k2){
                    if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !angular.isNumber(k2)){
                        forms[form][k2]= {original:v2, v:v2, estado:'created',trace:[]};
                    }
                });
            }else{
                forms[form][fiel] = {original:value, v:value, estado:'created',trace:[]};
            }
            exist=false;
            console.log("from ", form);
            console.log("fiel ", fiel);
            console.log("value ", value);
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
                            if(v !=null && typeof (v) != 'object' && typeof (v) != 'array' && !angular.isNumber(k)){
                                forms['document'][k]={original:v, v:v, estado:'new',trace:[]};
                            }

                        }
                    });


                    angular.forEach(response.productos.contraPedido, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !angular.isNumber(k2)){
                                if(!forms['contraPedido'+ v.id]){
                                    forms['contraPedido'+ v.id] ={};
                                }
                                forms['contraPedido'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });
                    angular.forEach(response.productos.kitchenBox, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !angular.isNumber(k2)){
                                if(!forms['kitchenBox'+ v.id]){
                                    forms['kitchenBox'+ v.id] ={};
                                }
                                forms['kitchenBox'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
                            }

                        });
                    });

                    angular.forEach(response.productos.pedidoSusti, function(v,k){
                        angular.forEach(v, function(v2,k2){
                            if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k2) !='numer' && !angular.isNumber(k2)){
                                if(!forms['pedidoSusti'+ v.id]){
                                    forms['pedidoSusti'+ v.id] ={};
                                }
                                forms['pedidoSusti'+ v.id][k2]={original:v2, v:v2, estado:'new',trace:new Array()};
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
                if(viewValue === undefined || viewValue=="" || viewValue==null){
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
            console.log("in directiva", scope);
            scope.click= function (e) {
                console.log('hizo click',e)
            }

            scope.enter= function (e) {
                console.log('hover',e)
            }
            scope.leave= function (e) {
                console.log('hover',e)
            }

        },
        template: function(elem, attr){
            return ' <div style="width: 16px;" ng-mousehover="enter($event)" ng-mouseleave="showNext($event)"  > </div>';
        }
    };
});

MyApp.controller('vlNextCtrl', ['$scope','$mdSidenav', function ($scope,$mdSidenav) {


    $scope.showNext = function (e) {
        console.log("e ", e)
        if (e) {
            $mdSidenav("NEXT").open();
        }else {
            $mdSidenav("NEXT").close();
        }
    }
}]);

MyApp.service('vlNextSrv',function () {
    var call = undefined;
    return {
        set : function (data) {
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
