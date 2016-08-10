MyApp.controller('PedidosCtrll', function ($scope,$http,$mdSidenav,$timeout
    ,$filter,$log,$location, $anchorScroll,App, Order,masters,providers,
                                           Upload,Layers,setGetOrder, DateParse, Accion,filesService,SYSTEM) {

    var autohidden= SYSTEM.noti_autohidden;

    // controlers
    $scope.formBlock = true;
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
    $scope.formGlobal = "new";
    $scope.isTasaFija= true;
    $scope.skiPro = [];
    $scope.navCtrl = Accion.create();
    $scope.previewHtmltext = "Introdusca texto ";
    $scope.previewHtmlDoc ="";
    $scope.layer= undefined;
    $scope.index= 0;
    $scope.formData ={};
    $scope.formDataContraP ={};

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
    $scope.gridViewCp= 1;
    $scope.gridViewSus= 1;
    $scope.gridViewFinalDoc= 1;
    $scope.productTexto="";
    $scope.currenSide = null;
    $scope.unclosetDoc = [];
    $scope.provDocs = [];
    $scope.provSelec ={};
    $scope.document  = {};
    $scope.contraPedSelec ={};
    $scope.pedidoSusPedSelec={};
    $scope.paises = {};
    $scope.todos =[];


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

    $timeout(function(){$scope.init();},0);

    $scope.reviewDoc = function(){
        $scope.unclosetDoc = [];
        Order.query({type:"UnClosetDoc"},{}, function(response){
            // $scope.unclosetDoc = response;
            if(response.length > 0){
                $scope.NotifAction("alert","Existen "+response.length + " documentos sin finalizar ",[
                    {
                        name:"Revisar luego",
                        action:function(){
                            var mo= jQuery("#init");
                            mo[0].focus();
                        }
                    }, {
                        name:"Ver",
                        action: function(){
                            $scope.navCtrl.value="unclosetDoc";
                            $scope.navCtrl.estado=true;
                        }
                    }
                ],{block:true});
            }else{
                var mo= jQuery("#init");
                mo[0].focus();
            }


        });

    };

    $scope.oldReviewDoc = function (){
        Order.get({type:'OldReviewDocs'},{}, function(response){
            if(response.docs.length > 0){
                $scope.NotifAction("alert","Existen "+response.docs.length + " documentos con mas de "
                    +response.dias +" sin respuesta ",[
                    {
                        name:"Revisar luego",
                        action:function(){
                            /*var mo= jQuery("#init");
                             mo[0].focus();*/
                        }
                    }, {
                        name:"Ver",
                        action: function(){
                            $scope.LayersAction({open:{name:"priorityDocs",
                                before: function(){
                                    $scope.priorityDocs= [];
                                }, after: function(){
                                    Order.get({type:'OldReviewDocs'},{}, function(response){
                                        angular.forEach(response.docs, function(v){
                                            v.emision = DateParse.toDate(v.emision);
                                            $scope.priorityDocs.push(v);
                                        });
                                        if($scope.priorityDocs.length > 0){
                                            $timeout(function(){
                                                var mo= jQuery("#priorityDocs").find('.cellSelect')[0];
                                                mo.focus();

                                            }, 300);
                                        }


                                    });
                                }
                            }});

                        }
                    }
                ]);
            }else{

            }

        });
    };

    $scope.init = function () {
        $scope.estadosDoc = masters.query({type: 'getOrderStatus'});
    };

    $scope.redirect = function(data){
        // ng-click="redirect()"
        alert("redirect " +data.field);
        console.log("data sen", data);
        setGetOrder.setOrder(angular.copy($scope.document));
        App.changeModule(data);
    };

    $scope.calbackPais = function(response){
        // App.changeModule({module:"pedidos"});
        console.log("response del cambio de modulo");

        // $scope.formData.paises= Order.query({type:"ProviderCountry",id:});

    };






    /********************************************GUI ********************************************/

    $scope.showDotData= function(item,emit,review){
        if(emit && review){
            item.emit= angular.copy(emit);
            item.review= angular.copy(review);
            item.show = true;
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
        // console.log("gloabel", $scope.formGlobal);
        if($scope.formGlobal != 'new'){
            setGetOrder.change('document',id,val);
        }

    };


    $scope.verificExit = function(){
        var paso = true;
//        console.log(' internasl', setGetOrder.getInternalState());
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
        if( $scope.isTasaFija){
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
    $scope.sendEmail = function(){
        $scope.NotifAction("ok","Enviado",[
            {
                name:"ok",
                action: function(){
                    $scope.LayersAction({close:true});
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
            var data =[];
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
                console.log("hover doc", document);
                $scope.document=document;

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
    };



    $scope.updateForm = function () {
        $scope.formBlock = false;
        Order.postMod({type:$scope.formMode.mod,mod:"Update"},{id: $scope.document.id},function(){
            $scope.isTasaFija=false;
            var mo= jQuery("#"+$scope.layer).find("md-content");
//            console.log("mo", mo)
            mo[0].focus();
        });
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
        $scope.LayersAction({close:layer});

    };

    $scope.cancelDoc = function(){

        $scope.formBlock= false;
        $scope.LayersAction({search:{name:"detalleDoc", before: function(){
            $scope.document.estado_id=3;// se cambia el estado a cancelado
            $scope.gridView =3;
            var mo= jQuery("#mtvCancelacion");
            mo[0].focus();
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
        console.log("tet", test);
        console.log("escope", $scope);
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
        var cp= [];
        var kit =  [];
        var sus = [];
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



        console.log("final",final);
        return final;
    };


    /******************************************** filtros ********************************************/
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

    // documentos

    $scope.filterDocuments = function (data, obj){

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

                   /* if(current.documento.toLowerCase().indexOf(compare.documento)== -1){
                        return false;
                    }*/

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
        $scope.LayersAction({close:"all"});
        $scope.LayersAction({open:{name:"menuAgr", before: function(){
            $scope.document = {};
        }}});
        $scope.gridView= 1;
        $scope.preview =false;

    };

    $scope.openEmail= function(){
        $scope.LayersAction({open:{name:"email"}});
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
    $scope.transformChip = function(chip) {

        if (angular.isObject(chip)) {
            return chip;
        }

        return { email: chip}
    }

    $scope.selecContraP = function (item) {
        $scope.contraPedSelec ={};
        $scope.LayersAction({open:{name:"resumenContraPedido", before: function(){

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
                $scope.formMode= $scope.forModeAvilable.getXname($scope.document.documento);
                $scope.navCtrl.value = "detalleDoc" ;
                $scope.navCtrl.estado= true;
                return;
                break;
            case "detalleDoc":
                $scope.LayersAction({search:{name:"listProducProv",
                    before:function(){
                        $scope.providerProds = [];
                    },
                    after: function(){
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
                    }
                }});
                /*  $scope.navCtrl.value = "listProducProv" ;
                 $scope.navCtrl.estado= true;*/
                break;
            case "listProducProv":
                $scope.LayersAction({search:{name:"agrPed",
                    before: function(){


                    }
                }});

                break;
            case "agrPed":
                if($scope.document.productos.kitchenBox.length == 0
                    && $scope.document.productos.contraPedido.length == 0
                    && $scope.document.productos.kitchenBox.length  == 0
                    && !$scope.formBlock
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
                if($scope.document.productos.todos.length == 0 && !$scope.formBlock)
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

            }  if (!$scope.listProductoItems.$valid && $scope.module.layer== 'listProducProv') {

                $scope.NotifAction("error",
                    "No se pueden asignar productos sin asignarle una cantidad verifique que todos los productos tienen cantidad correctas"
                    ,[],{autohidden:autohidden});

            } else {
                $mdSidenav("NEXT").open();
            }
            // $mdSidenav("NEXT").open();

        } else {
            $mdSidenav("NEXT").close()
        }

    };

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
                            alert("abrir layer add contra pedido por excepcion");
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
                console.log("review contra pedido", response);
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
        console.log("item ", item);
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
        }


    };

    $scope.addRemoveProd = function (item){
        if(item.asignado){
            $timeout(function(){
                var mo= jQuery("#p"+item.id);
                mo[0].focus();
            },100);

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

    $scope.clearSelec = function(obj){
        console.log("obj", obj)
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
        Order.postMod({type:$scope.formMode.mod, mod:"ChangeItem"},item, function(response){
            setGetOrder.change('producto'+item.id,'id',item);
        });
    };

    $scope.isEditItem = function(item) {
        if (!$scope.formBlock) {
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


    $scope.setProvedor =function(prov, p) {

        $scope.provIndex= angular.copy(p.$index);

        if($scope.module.layer == "listPedido" ){
            $scope.provSelec = prov;
            loadPedidosProvedor(prov.id);
        }else if($scope.module.layer != "listPedido" && $scope.module.index == 0 ){
            $scope.navCtrl.value="listPedido";
            $scope.navCtrl.estado=true;
            $scope.provSelec = prov;
        }else if($scope.module.index > 0 && !$scope.document.id){
            $scope.NotifAction("alert", "¿Esta seguro de cambiar de proveedor?",
                [
                    {name:"No", action: function(){}},
                    {name: "Si", default :2, action: function(){$scope.provSelec = prov;}}
                ]);
            /*if(){
             $scope.provSelec = prov;

             }else {
             $scope.verificExit();
             }*/
        }else {
            $scope.verificExit();
        }



    };

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
            $scope.LayersAction({close:{ search:true}});
        }

    };

    $scope.DtPedido = function (doc) {
        $scope.document= {};
        $scope.gridView= 1;
        var aux= angular.copy(doc);
        if(doc && $scope.module.index <2){
            if (segurity('editPedido')) {
                $scope.document.id=aux.id;
                $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);
                $scope.preview=false;
                setGetOrder.setState('select');
                $scope.formGlobal ="upd";
                $scope.navCtrl.value="detalleDoc";
                $scope.navCtrl.estado=true;
                //$scope.reloadDoc();
            }
            else {
                alert('No tiene suficientes permiso para ejecutar esta accion');
            }
        }
    };

    $scope.openTempDoc = function(doc){
        $scope.gridView= 1;
        //init();
        var aux= angular.copy(doc);
        if (segurity('editPedido')) {
            $scope.provSelec = $filter("customFind")($scope.todos, aux.prov_id,function(current,compare){return current.id==compare})[0];
            $scope.document.id=aux.id;
            $scope.formMode= $scope.forModeAvilable.getXname(doc.documento);

            setGetOrder.setState("select");
            $scope.formGlobal ="upd";
            $scope.provSelec.id= aux.prov_id;
            $scope.reloadDoc();
            $scope.navCtrl.value="detalleDoc";
            $scope.navCtrl.estado=true;

            //$scope.buildDocChange(doc);
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
                    {name:"Ok",default:2, action: function(){
                        $scope.LayersAction({close:{first:true, search:true}});
                        filesService.close();

                    }}
                ],{block:true});
            }});


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
                console.log("response", response);
                $scope.finalProdSelec.condicion_pago.push(response.item);
                $scope.excepAddCP ={};
                $scope.formExcepAddCP.$setUntouched();


            });
    };

    $scope.removeExcepProdFinal = function(item){
        // console.log("this", item)
        //
        $scope.NotifAction("alert","¿Esta seguro de eliminar la condicion?",[
            {name:"No", action: function(){}},
            {name:"Si, estoy seguro", action: function(){
                $scope.finalProdSelec.condicion_pago.splice(item.$index,1);
                /* Order.postMod({type:$scope.formMode.mod, mod:"RemoveProdConditionPay"},
                 item.item, function(response){
                 console.log("response", response);
                 console.log("response", item);




                 });*/

            }}
        ],{block:true});
    };

    /****** ************************** agregar respuesta ***************************************/
    $scope.addAnswer={};
    $scope.addAnswer.adjs =[];
    $scope.isOpenaddAnswer= false;
    $scope.closeAddAnswer= function(e){

        if(jQuery(e.target).parents("#lyrAlert").length == 0 &&
            jQuery(e.target).parents("#"+$scope.layer).length == 0 &&
            $scope.isOpenaddAnswer &&
            !angular.element(e.target).is("#ngf-AnswerfileInput")) {

            if ($mdSidenav("addAnswer").open()) {

                if($scope.formAnswerDoc.$valid){
                    console.log("$scope.addAnswer", $scope.addAnswer)
                    Order.postMod(
                        {type:$scope.formMode.mod, mod:"AddAnswer"},{  descripcion:$scope.addAnswer.descripcion,doc_id: $scope.addAnswer.doc_id, adjs :( $scope.addAnswer.adjs.length > 0)  ? $scope.addAnswer.adjs : []},function(response){
                            console.log("response data", response)
                            $scope.priorityDocs.splice($scope.addAnswer.index,1);
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

            $mdSidenav("addAnswer").open().then(function(){
                $scope.isOpenaddAnswer = true;
                $scope.addAnswer.doc_id=angular.copy(item.id);
                $scope.addAnswer.index=data.$index;
                $scope.formMode= $scope.forModeAvilable.getXname(item.documento);


            });

        }

    };

    $scope.$watch('answerfiles.length', function(newValue){
        if(newValue > 0){
            console.log("file serve",filesService)
            filesService.setFolder("orders");
            angular.forEach($scope.answerfiles, function(v){

                filesService.Upload({file:v,
                    success: function(data){
                        console.log("data", data);
                        $scope.addAnswer.adjs.push(data);
                    },
                    error:function(){
                        console.log("error subiendo ",v);
                    }})
            });
            $scope.answerfiles =[]
        }
    });

    /*    $scope.uploadAnswer = function(data){
     console.log("this", data);
     console.log("scope", $scope);

     }*/


    ;
    $scope.updateProv= function(){
        Order.get({type:"Provider", id: $scope.provSelec.id},{}, function(response){
            angular.forEach($scope.provSelec,function(v,k){
                $scope.provSelec[k] = response[k];
            });
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
                                                $scope.LayersAction({close:true});}} ] ,{block:true});
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
                                        $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
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
                                $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
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
                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
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
                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
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
                                            $scope.NotifAction("ok","Realizado",[{name:"Ok",default:2, action: function(){$scope.LayersAction({close:true});}} ] ,{block:true});
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

        if(nvo && nvo != "-1" && $scope.layer!= "detalleDoc"){
            var newHash ='prov' + nvo;
            if ($location.hash() !== newHash) {
                $location.hash(newHash);
            } else {

                $anchorScroll();
            }
        }else if(nvo == "-1"){
            $scope.redirect({module:'proveedores', action:'new',calback:$scope.calbackPais});
        }

    });

    $scope.$watch('provSelec.id', function (newVal) {
        if(newVal){
            $scope.formData.direccionesFact= Order.query({type:"InvoiceAddress", prov_id:newVal});
            $scope.formData.monedas = providers.query({type: "provCoins", id_prov: newVal});
            $scope.formData.paises= Order.query({type:"ProviderCountry",id:newVal});
            $scope.formData.condicionPago= Order.query({type:"ProviderPaymentCondition", id:newVal});
            /* if($scope.layer != "detalleDoc" && $scope.document.id && $scope.layer != "detalleDoc" ){
             setGetOrder.restore();
             $scope.document={};
             }*/
        }

    });

    $scope.$watch('document.pais_id', function (newVal) {
        if(newVal && newVal != "-1"){
            $scope.formData.direcciones= Order.query({type:"StoreAddress", prov_id:$scope.provSelec.id, pais_id:newVal});

        }else if(newVal == "-1"){
            $scope.redirect({module:'proveedores', calback:$scope.calbackPais});
        }
    });

    $scope.$watch('document.direccion_almacen_id', function (newVal) {
        if(newVal && newVal != "-1"){
            $scope.formData.puertos =  Order.query({type:"AdrressPorts", id: newVal});
        }
        else if(newVal == "-1"){
            $scope.redirect({module:'proveedores', calback:$scope.calbackPais});
        }
    });

    $scope.$watch('document.direccion_facturacion_id', function (newVal) {
        if(newVal == "-1"){
            $scope.redirect({module:'proveedores',  calback:$scope.calbackPais});
        }
    });

    $scope.$watch('document.prov_moneda_id', function (newVal) {
        if(newVal && newVal != "-1"){
            masters.get({type:'getCoin',id:newVal},{}, function(response){
                var tasa = parseFloat(response.precio_usd);
                if(!$scope.document.tasa || $scope.formGlobal == "new"){
                    $scope.document.tasa = tasa;
                }else {
                    if(tasa != $scope.document.tasa  && !$scope.formBlock){
                        $scope.NotifAction("alert","La tasa fue cambiada segun moneda selecionada ",[],{autohidden:autohidden});
                        $scope.document.tasa = tasa;
                        $scope.isTasaFija= true;
                    }
                }
            });
        }else if(newVal == "-1"){
            $scope.redirect({module:'proveedores', field:'moneda', origen:$scope.document, response:$scope.calbackPais});
        }
    });

    $scope.$watch('document.condicion_pago_id', function (newVal) {
        if(newVal == "-1"){
            $scope.redirect({module:'proveedores', calback:$scope.calbackPais});
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
                                $timeout(function(){
                                    if($scope.provDocs.length > 0){
                                        var mo= angular.element("#"+$scope.layer+" .activeleft");
                                        console.log("focus ", mo);
                                        mo[0].focus();
                                    }
                                }, 100);


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
                            before: function(){ $scope.provDocs = [];},
                            after: function(){
                                loadPedidosProvedor($scope.provSelec.id, function(){
                                    $timeout(function(){
                                        if($scope.provDocs.length > 0){
                                            var mo= jQuery("#listPedido").find('.cellSelect')[0];
                                            mo.focus();
                                        }
                                    }, 100);
                                });
                                $scope.hoverPreview(true);


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
                                $scope.formData.kitchenBox=[]
                            },
                            after: function(){

                                $scope.formData.kitchenBox = Order.query({type:"KitchenBoxs",  prov_id:$scope.provSelec.id, doc_id:$scope.document.id, tipo:$scope.formMode.value});
                            }
                        }});
                        break;
                    case "listProducProv":

                        break;
                    case "listImport":
                        $scope.LayersAction({search:{name:"listImport",
                            after: function(){
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
                        $scope.LayersAction({search:{name:"listEmailsImport",
                            after: function(){

                            }
                        }});
                        break;
                    case "agrPed":


                        break;
                    case "finalDoc":
                        $scope.LayersAction({search:{name:"finalDoc",
                            after: function(){

                                if(  setGetOrder.getState() != "built"){
                                    if(setGetOrder.getInternalState() == "new"){
                                        $scope.buildDocChange($scope.document);
                                    }

                                    $scope.finalDoc = $scope.buildfinalDoc();
                                    Order.getMod({type:$scope.formMode.mod, mod:'Summary',id:$scope.document.id},{},function(response){
                                        $scope.finalDoc.productos= response.productos;
                                        $scope.finalDoc.adjProforma = $filter("customFind")(response.adjuntos,'PROFORMA',function(current,compare){return current.documento==compare});
                                        $scope.finalDoc.adjFactura = $filter("customFind")(response.adjuntos,'FACTURA',function(current,compare){return current.documento==compare});

                                    });
                                    setGetOrder.setState("built")
                                }
                            },
                            before: function(){
                                $scope.reloadDoc();
                            }
                        }});
                        break;
                    case "agrPedPend":
                        $scope.LayersAction({search:{name:"agrPedPend",
                            after: function(){
                                $scope.docsSustitos = Order.queryMod({type:$scope.formMode.mod,mod:"Substitutes", doc_id:$scope.document.id, prov_id:$scope.provSelec.id});
                            }
                        }});
                        break;
                    case  "close":
                        if(setGetOrder.getInternalState() == 'new' && $scope.formGlobal !='new' && $scope.document.final_id){
                            $scope.NotifAction("alert","Sin cambios no se llevara a cabo ninguna accion",[],{autohidden:autohidden});
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
                    default : $scope.LayersAction({close:true});


                }

                /***   multiples */


            }
        }
        $scope.navCtrl.estado=false;
    });

    $scope.$watch("formBlock",function(newVal){
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

        if($scope.layer){
              /* var form =  angular.element("#"+$scope.layer).find("form:first");
             console.log("form", form);
             if(form){
             form.focus();
             }*/
        }
        if(newVal[0]  == 0 ){
            $scope.provSelec ={};
            $scope.reviewDoc();
            $timeout(function(){
                $scope.oldReviewDoc();
            }, 200);


            //        $timeout(function(){$scope.reviewDoc()},1000);
            $scope.provIndex = null;
            $scope.tempDoc= {};
        }

        if(newVal[0] == 0 || newVal[0] == 1){


            if($scope.layer != "detalleDoc"){
                $scope.gridView= 1;
                $scope.imagenes = [];
                $scope.formBlock = true;
                $scope.isTasaFija= true;
                setGetOrder.restore();
            }

        }
        if(newVal[1] == "agrPed" || newVal[1] == "newVal" || newVal[1] == "finalDoc" || newVal[1] == "detalleDoc"){
            if($scope.document.id != '' && typeof($scope.document.id) !== 'undefined' && setGetOrder.getState() != 'load'){
                $scope.reloadDoc();
            }
        }

        if(newVal[1] == "unclosetDoc"){
            setGetOrder.restore();
            $scope.document={};
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

            if(setGetOrder.getState() =="select"  ){

                $scope.buildDocChange($scope.document);

            }
            setGetOrder.setState("load");
            setGetOrder.setOrder(angular.copy( $scope.document));


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
                    setGetOrder.change("document","estado",response.item.estado);
                    $scope.NotifAction("ok","Estado cambiado a "+response.item.estado,[],{autohidden:autohidden});
                    $scope.FormEstatusDoc.$setPristine();

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
                search(arg.search, module);
            }else {
                console.log("error parametro no implemtnado")
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
                    alert("asdfa");
                    close = module.index ;
                    console.log("all recibido", module);
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
                console.log("entro en cero")
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

/**************  SERVICIOS   ***********************/

MyApp.service('setGetOrder', function(DateParse, Order) {

    var forms ={};
    var interno= 'new';
    var externo= 'new';
    var order={};
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
                forms[form][fiel]= {original:value, v:value, estado:'created',trace:[]};
            }
            if(!forms[form][fiel] && typeof (value) == 'object'){
                angular.forEach(value, function(v,k){
                    if(v!=null && typeof (v) != 'object' && typeof (v) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                        forms[form][k]={original:v, v:v, estado:'new',trace:new Array()};
                    }

                });
                value= angular.copy(value[fiel]);
            }
            if(typeof (value) != 'undefined' && forms[form][fiel].estado !='created'){
                if(forms[form][fiel].original != value  ){
                    forms[form][fiel].v= value;
                    forms[form][fiel].trace.push(value);
                    forms[form][fiel].estado='upd';

                }else
                if(forms[form][fiel].original == value && forms[form][fiel].estado !='created' ){
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
        },
        setOrder : function(data){
            order= data;
        },
        getOrder : function(){
            return order;
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

MyApp.directive('table', function ($compile) {
    return {
        link: function (scope, elem, attrs) {
            var head =jQuery(elem).find("[orderBy]");
            var name = attrs.table;
            angular.forEach(head, function(v){
                var aux = angular.element(v);
                if(aux.attr("orderBy")){
                    aux.attr("ng-click",""+name+" = ( "+name+" == '"+aux.attr("orderBy")+"' ) ? '-"+aux.attr("orderBy")+"' : '"+aux.attr("orderBy")+"' ");
                    aux.removeAttr("orderBy");
                    $compile(aux[0])(scope);
                }
            });

        }
    };
});

MyApp.directive('vlcKeys', function ($compile) {
    return {
        link: function (scope, elem, attrs) {
            elem.bind("keydown",function(e){
                // teclas muertas
                if(e.which=="9"){
                    e.preventDefault();
                }


            })
        }
    };
});



/******************************** trash ***********************************/
