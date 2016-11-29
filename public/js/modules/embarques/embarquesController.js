MyApp.controller('embarquesController', ['$scope', '$mdSidenav','$timeout','$interval','$filter','form', 'shipment','setGetShipment', function ($scope, $mdSidenav,$timeout,$interval,$filter,form,$resource, $model) {
    $scope.list ='provider';
    $scope.alerts =[];
    $scope.provs =[];
    $scope.paises =[];
    $scope.shipment ={objs:{}};
    $scope.bindShipment =$model.bind();
    $scope.session = {global:'new', isblock: false};

    $scope.complete = {data:[{id:''},{id:''},{id:''},{id:''},{id:''}]};
    $scope.permit={
        created:true
    };
    $timeout(function () {
        $resource.query({type:"Providers"}, {}, function(response){$scope.provs= response; });
    },0);

    $timeout(function () {
        $resource.query({type:"Countrys"}, {}, function(response){$scope.paises= response; });
    },0);
    $scope.test = function () {
        $scope.NotifAction("alert",'demo',[
            {name:"a",action:function () {
                console.log("a")
            }
            },{name:"b",action:function () {
                console.log("b")
            }
            }
        ],{save:{doc_origen_id:$scope.shipment.id, tipo_origen_id:25,comentario:"hola mundo"}});
    };

    $scope.progreso =$model.timeline();
    /*$scope.progreso = {index:0,
     data:[
     {index:1, st:'false', text:
     {
     true:'Felicidades se han llenado los minimos datos para la aprobacion',
     false:'Disculpa aun no has llenado los datos minimos para solicitar la aprobacion',
     'this':'Estamos esperando la aprobacion de este embarque'
     }
     },
     {index:2, st:'false' ,text:
     {
     true:'¡EL embarque ya fue aprobado!',
     false:'¡Aun no se ha aprobado el embarque!',
     'this':'Estamos esperando el cumplimiento de la fecha de carga'
     }
     },
     {index:3, st:'false' ,        text:
     {
     true:'Ya se cargo el embarque',
     false:'Aun no se ha empezado ha cargar el embarque',
     'this':'En espera de la llegada a venezuela'
     }
     },
     {index:4, st:'false', text:
     {
     true:'Ya esta en Venezuela',
     false:'Aun no ha llegado a Venezuela',
     'this':'Esperando la llegada a la tienda'
     }
     },
     {index:5, st:'false',text:
     {
     true:'Ya esta en la tienda',
     false:'Aun no ha llegado a la tienda',
     'this':'Finalizado, Por favor confirmar recepcion'
     }
     }
     ]};

     */


    /*    $scope.search = function(){
     var data =[];
     if($scope.provs.length > 0){
     return $scope.provs;
     }
     return data;
     }*/

    $scope.search = function(){
        var data  =[];
        if($scope.provs.length > 0){
            data = $filter("customFind")($scope.provs,$scope.filterProv,
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
                    if($scope.paisSelec && $scope.paisSelec.providersn && $scope.paisSelec.id){
                        paso = $scope.paisSelec.providers.indexOf(current.id) != -1;
                    }
                    return paso;

                });
        }
        return  data;
        //  return data;
    };

    $scope.searchCountry = function(){
        var data  =[];
        if($scope.paises.length > 0){
            data = $filter("customFind")($scope.paises,$scope.filterCountry,
                function(current,compare){
                    var paso = true;
                    current.prioridad = 0;
                    if(compare.short_name){
                        if(current.short_name.toLowerCase().indexOf(compare.short_name.toLowerCase()) != -1){
                            current.prioridad ++;
                        }else{
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
                    if($scope.provSelec && $scope.provSelec.countrys && $scope.provSelec.id){
                        paso = $scope.provSelec.countrys.indexOf(current.id) != -1;
                    }
                    return paso;

                });
        }
        return  data;
        //  return data;
    };

    $scope.setProvedor = function(prov, e){
        if($scope.module.index == 0 || $scope.module.layer == 'listShipment'  ){
            $scope.provSelec = prov;
            $scope.shipment.prov_id= prov.id;
            $scope.listShipmentCtrl({prov_id: prov.id});
        }else if($scope.module.layer == 'detailShipment' && !$scope.session.isblock){

            if(!$scope.shipment.tarifa_id){
                $scope.provSelec= prov;
                $scope.shipment.prov_id= prov.id;
                $model.change('document','prov_id',  prov.id);
                $scope.save();
            }else {

                $model.setNext(function () {
                    $scope.LayersAction({close:{all:true, after:function () {
                        $timeout(function () {
                            var element = angular.element(e.target);
                            console.log("click", element);
                            element.click();
                        },500);

                    }}})

                });
                $model.exit();
            }

        }else{

            $model.setNext(function () {
                if($scope.module.historia[1] == 'detailShipment'){
                    $scope.LayersAction({close:{all:true}});
                }else{
                    $scope.LayersAction({close:{first:true, search:true}});
                }

            });
            $model.exit();

        }

    };


    $scope.setPais = function(pais){

        if($scope.module.index == 0 || $scope.module.layer == 'listShipment'  ){
            $scope.paisSelec = pais;
            $scope.shipment.pais_id= pais.id;
            $scope.listShipmentCtrl({pais_id: pais.id});
        }else if(($scope.module.layer == 'detailShipment' || $scope.module.layer == 'listTariff') && !$scope.session.isblock){

            console.log("scope", $scope);
            if(!$scope.shipment.tarifa_id ){
                $scope.paisSelec= pais;
                $scope.shipment.pais_id= pais.id;
                $model.change('tarifa','pais_id',  pais.id);
                $scope.save();
            }else {
                $model.setNext(function () {
                    $scope.LayersAction({close:{all:true, after:function () {
                        $scope.paisSelec= pais;
                        $scope.listShipmentCtrl({pais_id: pais.id});
                    }}})
                });
                $model.exit();
            }
        }else{

            $model.setNext(function () {
                $scope.LayersAction({close:{all:true, after:function () {
                    $scope.paisSelec= pais;
                    $scope.listShipmentCtrl({pais_id: pais.id});
                }}})

            });
            $model.exit();

        }

    };

    $scope.reloadDates = function () {
        var from =  undefined;
        if(!$scope.shipment.fechas.fecha_tienda.confirm && !$scope.shipment.fechas.fecha_tienda.isManual){
            from='fecha_tienda';
        }
        if(!$scope.shipment.fechas.fecha_vnz.confirm && !$scope.shipment.fechas.fecha_vnz.isManual){
            from='fecha_vnz';
        }
        if(!$scope.shipment.fechas.fecha_carga.confirm && !$scope.shipment.fechas.fecha_carga.isManual) {
            from='fecha_carga';
        }

        if(from){
            $resource.getMod({type:"Shipment", mod:"Dates", id:$scope.shipment.id,from:from}, {}, function (response) {
                $model.setDates(response);

                $resource.postMod({type:"Shipment", mod:"SaveDates"},
                    { id:$scope.shipment.id,
                        fecha_carga:response.fecha_carga,
                        fecha_tienda:response.fecha_tienda,
                        fecha_vnz:response.fecha_vnz
                    }
                    , function (response) {


                        $model.setDates(response);

                        ;
                    });
            });

        }



    };

    $scope.reloadProv= function (fn) {
        if( $scope.provSelec && $scope.provSelec.id){
            $resource.get({type:"Provider", id:$scope.provSelec.id}, {}, function(response){
                angular.forEach(response, function (v,k) {
                    $scope.provSelec[k]=v;
                });
                if(fn){
                    fn($scope.provSelec);
                }
            });
        }


    }
    $scope.reloadCountry= function (fn) {
        if( $scope.paisSelec && $scope.paisSelec.id){
            $resource.get({type:"Country",id:$scope.paisSelec.id}, {}, function(response){
                $scope.paisSelec = {};
                angular.forEach(response, function (v,k) {
                    $scope.paisSelec[k]=v;
                });
                if(fn){
                    fn($scope.paisSelec);
                }
            });
        }


    }

    $scope.closeSide = function(){
        $timeout(function () {
            if(form.getState() == "process"){
                $scope.validChangeFor();
            }else if($scope.module.layer == 'detailShipment' && !$scope.session.isblock){
                $model.setNext(function () {
                    if($scope.module.layer== 'updateShipment'){
                        $scope.LayersAction({close:{all:true}});
                    }else{
                        $scope.LayersAction({close:true});
                    }
                });
                $model.exit();
            }else{
                $scope.LayersAction({close:{search:true}});
            }
        },0);

    };

    var timeUp= null
    $scope.save = function (fn) {
        timeUp = $timeout(function () {
            $resource.post({type:"Save"},$scope.shipment, function(response){
                $scope.shipment.id = response.id;
                $scope.shipment.session_id = response.session_id;
                if(response.emision){
                    $scope.shipment.emision;
                }

                $timeout.cancel(timeUp);
                timeUp= null;
                if(fn){
                    fn(response);
                }
            });
        },500);


    };

    var interval = null;
    $scope.validChangeFor= function () {
        if(form.getState() == "process" ){
            if(interval != null){
                $interval.cancel(interval);
            }
            interval= $interval(function () {
                console.log("interval", form.getState());
                if(form.getState() == "continue"){
                    $scope.LayersAction({close:{search:true}});
                    $interval.cancel(interval);
                    interval= null;
                }else if(form.getState() == "cancel"){
                    if(form.back){
                        form.back();
                    }
                    $interval.cancel(interval);
                    interval= null;
                }
            },500);
        }
    };

    $scope.showNext = function (status) {
        if (status) {
            $mdSidenav("NEXT").open();
        } else {
            $mdSidenav("NEXT").close()
        }

    };

    $scope.next = function (e) {
        if($scope.module.layer== 'detailShipment'  ){

            $model.setNext(function () {
                $resource.postAll({type:'Shipment',mod:'Close'},{id:$scope.shipment.id}, function (response) {
                    if($scope.module.historia[1] == 'detailShipment'){
                        $scope.LayersAction({close:{all:true}});
                    }else{
                        $scope.LayersAction({close:{first:true, search:true}});
                    }
                });
            });
            $model.exit();

        }else{
            if($scope.setNext){
                $scope.setNext(e);
            }
        }

    };

    $scope.sessionExit = function () {
        var val =$scope.updateShipmentCtrl();

        if(!val  ){
            {
                if($scope.shipment.id){
                    $scope.NotifAction("alert", "¿Esta seguro de salir?",
                        [
                            {name:"Si,estoy eguro",action:function () {
                                if($scope.module.historia[1] == 'detailShipment'){
                                    $scope.LayersAction({close:{all:true}});
                                }else{
                                    $scope.LayersAction({close:{first:true, search:true}});
                                }
                            } },
                            {name:"No", action: function () {

                            }}
                        ]
                        ,{block:true});
                }else{
                    if($scope.module.historia[1] == 'detailShipment'){
                        $scope.LayersAction({close:{all:true}});
                    }else{
                        $scope.LayersAction({close:{first:true, search:true}});
                    }
                }

            }

        }
        return val;
    };


    $scope.unblock = function (id) {
        //console.log("inblock", id);
        $scope.session.isblock =false;
    };

    $scope.layerExit = function(){
        if( !$scope.session.isblock ){
            $model.setNext(function () {
                if($scope.module.historia[1] == 'detailShipment'){
                    $scope.LayersAction({close:{all:true}});
                }else{
                    $scope.LayersAction({close:{first:true, search:true}});
                }
            });
            $model.exit();

            return false;
        }
        return true;
    };

    $scope.reloadTimeLineShipment = function () {


        $timeout(function () {

            $model.timelineUpdate();
        }, 100);


    };

    $scope.$watch('bindShipment.estado', function(newVal){

        if(newVal){
            $timeout(function () {
                $scope.shipment = $model.getData();
                if( $scope.shipment.objs ){
                }

                $timeout(function () {

                    $scope.reloadTimeLineShipment();

                },500);


            },0);
        }
    });

    $scope.$watchGroup(['module.layer', 'module.index'] ,function(newVal){
        $scope.layer= newVal[0];
        $scope.index= newVal[1];
        if(newVal[1] == 0 || newVal[0] == 'listShipmentUncloset'){
            $timeout(function () {
                $model.clear();
                $scope.reloadProv(function () {
                    $scope.provSelec = undefined;
                });
                $scope.reloadCountry(function () {
                    $scope.paisSelec =undefined;
                });
                $scope.session.global = 'new';
                $scope.session.isblock = true;
                $scope.reloadTimeLineShipment();
            },0);
        }
        if(newVal[0] == 'listShipment'){
            $model.clear();
            $scope.reloadTimeLineShipment();
        }
    });



    /**@deprecated*/
    $scope.isModif = function () {
        var isModif = false;
        if($model.getInternalState() == 'new'){
            return false;
        }else{
            var form = $model.getForm();
            angular.forEach($model.getForm('fecha_carga'), function (v, k){
                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('tarifa'), function (v, k){
                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('fecha_tienda'), function (v, k){
                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('fecha_vnz'), function (v, k){
                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('nro_mbl'), function (v, k) {

                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('nro_hbl'), function (v, k) {
                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('nro_eaa'), function (v, k) {

                if(v.estado && v.estado != 'new'){
                    isModif=true;
                }
            });
            angular.forEach($model.getForm('document'), function (v, k) {

                if(v.estado && v.estado != 'new'){

                    isModif=true;

                }
            });
            angular.forEach(form, function (v, k) {
                if(k.startsWith("container")){
                    if(v.peso.estado != 'new' || v.tipo.estado != 'new' ||  v.volumen.estado !='new' || v.id.estado != 'new'){

                        isModif=true;
                    }
                }
                if(k.startsWith("item")){
                    if(v.total.estado !='new' || v.saldo.estado !='new'  || v.disponible.estado !='new' || v.id.estado !='new'){

                        isModif=true;

                    }

                }
                if(k.startsWith("odc")){
                    if(v.id.estado != 'new'){
                        isModif=true;
                    }

                }
            });
            return isModif;
        }
    }


    $scope.FilterLateral = function(){
        if(!$scope.showLateralFilter){
            angular.element("#menu").animate({height:"258px"},500);
            $scope.showLateralFilter=true;
        }else{
            angular.element("#menu").animate({height:"48px"},500);
            $scope.showLateralFilter=false;
        }
    };

    $scope.showDotData= function(item,emit,review, dias){

        if(emit && review){
            item.emit= angular.copy(emit);
            item.review= angular.copy(review);
            item.show = true;
            item.dias=dias;
            if(dias== 0){
                item.text = " hoy ";
            }else{
                item.text = "" + dias+" dias ";
            }
        }else{
            item.show = false;
        }

    };

    $scope.addDays = function (model,compare, plus) {
        if(model && compare){
            model = new Date(compare.getFullYear(),
                compare.getMonth(),
                compare.getDate()+ plus,
                compare.getHours(),
                compare.getMinutes(),
                compare.getSeconds()
            );
        }

    }

}]);

MyApp.controller('listShipmentCtrl', ['$scope','shipment','setGetShipment',  function ($scope,$resource, setGetShipment) {
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };

    $scope.data;
    $scope.load = function (data) {
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        var send = {type:"Shipments" };
        angular.forEach(data, function (v, k) {
            send[k]= v;
        });
        // console.log("send ", send);
        $resource.query(send,{}, function (response) {
            angular.forEach(response, function (v, k) {
                $scope.tbl.data.push(v);
            })
        })
    };

    $scope.$parent.listShipmentCtrl = function(data, fn){
        $scope.data = data;
        $scope.LayersAction({search:{name:"listShipment", after: function () {
            $scope.load(data);
            if(fn){
                fn();
            }
        }}});
    };
    $scope.setData = function (data){
        setGetShipment.setData(data);
        $scope.summaryShipmentCtrl();
    }

    $scope.ShipmentFinish = function () {
        console.log("llamo correcto");
        $scope.$parent.listShipmentFinish( angular.copy($scope.data));
    }

}]);



MyApp.controller('superAprobCtrl', ['$scope', function ($scope) {

    $scope.basic = function () {
        console.log("in aprob")
        if($scope.$parent.shipment.prov_id && $scope.$parent.shipment.pais_id && $scope.$parent.shipment.puerto_id && $scope.$parent.shipment.tarifa_id  ){
            return true;
        }
        return false;
    };
    $scope.fechas = function () {
        if($scope.shipment.fechas.fecha_carga.value && $scope.shipment.fechas.fecha_vnz.value && $scope.shipment.fechas.fecha_tienda.value){
            return true;
        }
        return false;
    };
    $scope.monto = function () {
        if($scope.$parent.shipment.flete_maritimo){
            return true;
        }
        return false;
    };
    $scope.articulos = function () {
        if($scope.$parent.shipment.items.length > 0){
            return true;
        }
        return false;
    };

    $scope.save = function () {
        $scope.$parent.shipment.aprob_superior = true;
        $scope.$parent.save(function () {
            $scope.NotifAction("ok","Documento aprobado",[], {autohidden:2000});
        })

    };
    $scope.aprob = function () {
        console.log("in aprob", $scope.$parent.shipment);
        var save = function () {
            $scope.NotifAction("alert","Despues de aprobar el embarque no se podran agregar nuevos productos, ¿Esta seguro de Aprobar el embarque?",
                [
                    {name:"Aprobar", action: function () {
                        $scope.save();
                    }
                    },
                    {name:"Aprobar y agregar comentario", action: function () {
                        $scope.$parent.miniAprobShipment();
                    }
                    },
                    {name:"Cancelar", action:function () {}}]
                ,{block:true})
        };
        if($scope.$parent.shipment.criterios.isAprobable && !$scope.$parent.shipment.aprob_superior){
            if(!$scope.basic()){
                $scope.NotifAction("error", "¡Hay muy pocos datos!. Debes colocar al menos un proveedor, una tarifa un puerto y en pais de origen " ,[], {autohidden:3000});
            }else if(!$scope.articulos()){
                $scope.NotifAction("error", "¡No hay articulos!. Todo embarque debe tener algun articulo " ,[], {autohidden:3000});
            }else if(!$scope.fechas()){
                $scope.NotifAction("alert", "¡Faltan algunas fechas!. " +
                    " Se suelen colocar fechas aproximadas de carga, de llagada a Venezuela y de llegada a la tienda, " +
                    "por favor confirmanos que deseas dejar fechas en blanco" ,
                    [
                        {name:"Si, Dejalas en blanco, luego justificare el motivo",
                            action: function () {
                                $scope.$parent.miniAprobShipment();
                            }
                        },{name:"Cancelar", action:function () {}}
                    ],{block:true,save:{mod:'embarque',doc_tipo_id:"24", doc_id:$scope.$parent.shipment.id}});

            }else if( !$scope.monto()){
                $scope.NotifAction("alert", "¡No se le ha colocado un monto maritimo!. " +
                    "Se recomienda colocar un monto para el flete maritimo. Por favor confirmanos que lo deseas dejarlo el blanco" ,
                    [
                        {name:"Si, Dejalo en blanco, luego justificare el motivo",
                            action: function () {
                                $scope.$parent.miniAprobShipment();
                            }
                        },{name:"Cancelar", action:function () {}}
                    ],{block:true,save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            }else{

                save();
            }
        }else if(!$scope.$parent.shipment.criterios.isAprobable ){
            $scope.NotifAction("error", "No tienes permisos para aprobar este documento",[],
                {autohidden:2000,save:{mod:'embarque',doc_tipo_id:"24", doc_id:$scope.$parent.shipment.id}});
        }
    }
}]);

MyApp.controller('listShipmentUnclosetCtrl', ['$scope','shipment','setGetShipment','DateParse' , function ($scope,$resource, $model, DateParse) {
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.select = {};

    $scope.load = function (){
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        $resource.query({type:"Uncloset"},{}, function (response) {
            if(response.length == 0){
                $scope.$parent.LayersAction({close:true});
            }else{
                angular.forEach(response, function (v) {
                    var aux ={};
                    angular.forEach(v, function (v2,k) {
                        if(k == 'fecha_carga' || k == 'fecha_vnz' || k == 'fecha_tienda'){
                            if(v2 != null){
                                aux[k]= DateParse.toDate(v2);
                            }
                        }else{
                            aux[k]= v2;
                        }

                    });
                    $scope.tbl.data.push(aux);
                })
            }
        });
    }

    $scope.$parent.listUnclosetCtrl = function(){
        $scope.select = {};
        $scope.LayersAction({open:{name:"listShipmentUncloset", after: $scope.load}});

    };
    $scope.setData = function (data){
        $scope.select = angular.copy(data);

        $model.setData(data, function () {
            $scope.session.global = 'uncloset';

            $scope.$parent.unblock({doc_id:data.id});

            $model.change('sistem',undefined,{uncloset:true});
        });
        $scope.$parent.OpenShipmentCtrl(data);

    }



}]);

MyApp.controller('summaryShipmentCtrl', ['$scope',  'shipment','setGetShipment',  function($scope,shipment, setGetShipment ){

    $scope.$parent.summaryShipmentCtrl = function(){
        $scope.LayersAction({open:{name:"summaryShipment", after: function(){
        }}});
    }

}]);

MyApp.controller('OpenShipmentCtrl', ['$scope', '$timeout','shipment','DateParse','setGetShipment',function($scope,$timeout ,$resource,DateParse,$model){

    $scope.fechas =  {
        fecha_carga:{
            in: undefined
        },
        fecha_vnz:{
            in: undefined,
        },
        fecha_tienda:{
            in: undefined,
            out:undefined
        },
        calc:undefined,
        send:{},
        bind:{
            estado:false
        }
    };

    $scope.provSelec = undefined;
    $scope.provSelecText = undefined;
    $scope.form= 'head';
    $scope.formOptions={
        head:{expand:true} ,
        date:{expand:true}  ,
        doc:{expand:true}  ,
        pago:{expand:true}  ,
        agreds:{expand:true}
    };

    $scope.$watch("fechas.bind.estado", function (newVal, oldVal) {
        if(newVal){
            $scope.fechas.bind.estado = false;
            $scope.fechas.send.id= angular.copy($scope.shipment.id);

            if($scope.fechas.calc){
                $resource.postMod({type:"Shipment",mod:"SaveDates"}, $scope.fechas.send,function () {
                    $resource.getMod({type:"Shipment",mod:"Dates", from:$scope.fechas.calc, id: $scope.$parent.shipment.id}, {},function (response) {
                        var send = response;
                        send.id = $scope.$parent.shipment.id;
                        $resource.postMod({type:"Shipment",mod:"SaveDates"}, send,function (response) {
                            $model.setDates(response);

                            $scope.$parent.NotifAction("ok", "Las fechas fueron actualizadas",[], {autohidden:1500});

                        });
                    })
                })
            }else{
                $resource.postMod({type:"Shipment",mod:"SaveDates"}, $scope.fechas.send,function (response) {
                    $model.setDates(response);
                    $scope.$parent.NotifAction("ok", "Actualizado",[], {autohidden:1500});
                });
            }
        }
    });
    $scope.$watch("provSelec", function(newVal){
        if(newVal != null && newVal.id && $scope.$parent.provSelec != null && $scope.$parent.provSelec){
            $resource.queryMod({type:"Provider",mod:"Dir", id:newVal.id}, {}, function(response){$scope.$parent.provSelec.direcciones= response;});
        }
    });
    $scope.$watch("provSelec", function(newVal){

        if(newVal && $scope.$parent.provSelec){
            if(newVal.id != $scope.$parent.provSelec.id){
                $scope.$parent.provSelec = newVal;
                $timeout(function(){
                    var elem=angular.element("#prov"+newVal.id);
                    angular.element(elem).parent().scrollTop(angular.element(elem).outerHeight()*angular.element(elem).index());
                },0)
            }
        } else if(newVal && $scope.$parent.provSelec == null){
            $scope.$parent.provSelec= newVal
        }else{
            $scope.$parent.provSelec= undefined;
        }
    });
    $scope.$watch("$parent.provSelec", function(newVal){
        $scope.provSelec = newVal;
    });


    $scope.$watchGroup(['detailShipmenthead.$valid', 'detailShipmenthead.$pristine'], function(newVal){
        if(!newVal[1]){
            $scope.$parent.save(function () {
                $scope.detailShipmenthead.$setPristine()
            });

        }
    });



    $scope.$parent.OpenShipmentCtrl = function(data){

        $scope.pagos =  {
            flete_tt:{val:undefined, confirm: false},
            flete_maritimo:{val:undefined, confirm: false},
            nacionalizacion:{val:undefined, confirm: false},
            dua:{val:undefined, confirm: false}
        };
        $scope.form= 'head';
        $scope.detailShipmenthead.$setPristine();
        $scope.detailShipmenthead.$setUntouched();

        $scope.pago.$setPristine();
        $scope.pago.$setUntouched();

        $scope.doc.$setPristine();
        $scope.doc.$setUntouched();

        $scope.date.$setPristine();
        $scope.date.$setUntouched();
        $scope.fechas =  {
            fecha_carga:{
                in: undefined
            },
            fecha_vnz:{
                in: undefined,
            },
            fecha_tienda:{
                in: undefined,
                out:undefined
            },
            calc:undefined,
            send:{},
            bind:{
                estado:false
            }
        };

        $scope.$parent.LayersAction({open:{name:"detailShipment", after: function(){
            if(!data){
                $scope.$parent.save(function (response) {
                    $model.setData({id:response.id});
                    $scope.$parent.unblock({doc_id:response.id});
                });
            }
        }}});
    };

    $scope.toEditHead= function(id,val){

        if($scope.$parent.module.layer == 'detailShipment' && val){

            $model.change("document",id,val);
        }

    };

    $scope.openTarif = function () {
        if($scope.provSelec == null){
            $scope.$parent.NotifAction("error", "selecione un proveedor ",[],{autohidden:2000});
        }else {
            $scope.$parent.listTariffCtrl();
        }

    }

    $scope.test= function(){
        alert('');
    }

    // fechas
    $scope.inDate = function (v,k) {
        $scope.fechas[k].in= angular.copy(v);

    };

    $scope.setSend = function (fecha, cal,clear) {
        if(clear){
            $scope.fechas.send ={};
        }

        console.log('set', fecha);
        angular.forEach(fecha, function (v, k) {
            $scope.fechas.send[k]=v;
        })
        $scope.fechas.calc= cal;
    };
    $scope.changeFecha_carga = function () {


        if(!$scope.date.$pristine){
            var cambiar = function () {
                $timeout(function () {
                    if($scope.$parent.shipment.fechas.fecha_carga.value <= new Date()){
                        $scope.$parent.NotifAction("alert","Esta fecha es definitiva",
                            [
                                {
                                    name:"Si, es la definitiva",action : function () {
                                    $scope.fechas.send.fecha_carga.confirm = true;
                                    $scope.fechas.bind.estado = true;
                                }
                                },{
                                name:"No ",action : function () {
                                    $scope.fechas.bind.estado = true;
                                }
                            }
                            ]
                            , {block:true});
                    }else{
                        $scope.fechas.bind.estado = true;
                    }
                },0);

            };

            var cambiarRv = function () {
                $timeout(function () {
                    if($scope.$parent.shipment.fechas.fecha_vnz.value || $scope.$parent.shipment.fechas.fecha_tienda.value ){ // si tiene datos asignados
                        if($scope.$parent.shipment.fechas.fecha_vnz.isManual || $scope.$parent.shipment.fechas.fecha_tienda.isManual )
                        {// si son valores fueron asignados a mano
                            $scope.$parent.NotifAction("alert",
                                "Se a asignado la fecha de  llegada a Venezuela o  la fecha de llegada a la tienda manualmente",
                                [
                                    {name:"Cambiar segun la nueva fecha", default:10,
                                        action: function () {
                                            $scope.setSend ({fecha_carga:{value: angular.copy($scope.$parent.shipment.fechas.fecha_carga.value),isManual:true,confirm: false}},'fecha_vnz', true);
                                            cambiar();
                                        }
                                    },
                                    {name:"Mantener fechas actuales",
                                        action: function () {
                                            $scope.setSend ({fecha_carga:{value: angular.copy($scope.$parent.shipment.fechas.fecha_carga.value),isManual:true,confirm: false}},undefined, true);
                                            cambiar();
                                        }
                                    },
                                    {name:"Cancelar",
                                        action: function () {
                                            $scope.fechas.send ={};
                                            $scope.calc =undefined;
                                            $scope.$parent.shipment.fechas.fecha_carga = angular.copy($scope.fechas.fecha_carga.in);

                                        }
                                    }

                                ]);
                        }
                        else{
                            $scope.setSend ({fecha_carga:{value: angular.copy($scope.$parent.shipment.fechas.fecha_carga.value),isManual:true,confirm: false}},'fecha_vnz', true);
                            cambiar();

                        }
                    }else{
                        $scope.setSend ({fecha_carga:{value: angular.copy($scope.$parent.shipment.fechas.fecha_carga.value),isManual:true,confirm: false}},'fecha_vnz', true);
                        cambiar();
                    }
                },0);

            };

            if($scope.$parent.shipment.fechas.fecha_carga.max){

                var max = DateParse.toDate($scope.$parent.shipment.fechas.fecha_carga.max);
                console.log("max", max);

                if($scope.$parent.shipment.fechas.fecha_carga.value > max){
                    $scope.$parent.NotifAction("alert", "La fecha ideal para la carga, es "+ max.getDate()+"/"+max.getMonth()+"/"+max.getFullYear()+" ¿Esta seguro que la fecha es correcta?",
                        [
                            {name:"Si, estoy seguro", action: function ()
                            {
                                cambiarRv();
                            }
                            }
                            ,{name:"No, dejame corregirlo", action: function ()
                        {
                            $scope.$parent.shipment.fechas.fecha_carga.value = angular.copy($scope.fechas.fecha_carga.in);
                        }
                        }
                        ]
                        ,{block:true,save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
                }else{
                    cambiarRv();
                }
            }
            else{
                cambiarRv();
            }
        }
    };
    $scope.changeFecha_vnz = function () {

        if(!$scope.date.$pristine){

            var cambiar = function () {
                $timeout(function () {
                    if($scope.$parent.shipment.fechas.fecha_vnz.value <= new Date() && $scope.$parent.shipment.fechas.fecha_carga.confirm){
                        $scope.$parent.NotifAction("alert","Esta fecha es definitiva",
                            [
                                {
                                    name:"Si, es la definitiva",action : function () {
                                    $scope.fechas.send.fecha_vnz.confirm = true;
                                    $scope.fechas.bind.estado = true;
                                }
                                },{
                                name:"No no es la definitiva",action : function () {
                                    $scope.fechas.bind.estado = true;
                                }
                            }
                            ]
                            , {block:true});
                    }else{
                        $scope.fechas.bind.estado = true;
                    }

                },0);

            } ;
            var cambiarRv = function () {
                $timeout(function () {
                    if(!$scope.$parent.shipment.fechas.fecha_vnz.confirm){
                        if($scope.$parent.shipment.fechas.fecha_tienda.value ){ // si tiene datos asignados
                            if($scope.$parent.shipment.fechas.fecha_tienda.isManual ){// si son valores fueron asignados a mano
                                $scope.$parent.NotifAction("alert",
                                    "Se a asignado la fecha de llegada a la tienda manualmente ¿Que desea hacer?",
                                    [
                                        {name:"Cambiar segun la nueva fecha", default:5,
                                            action: function () {
                                                $scope.setSend ({fecha_vnz:{value: angular.copy($scope.$parent.shipment.fechas.fecha_vnz.value),isManual:true,confirm: false}},'fecha_tienda', true);
                                                cambiar();
                                            }
                                        },
                                        {name:"Mantener la fecha de llegada a la tienda",
                                            action: function () {
                                                $scope.setSend ({fecha_vnz:{value: angular.copy($scope.$parent.shipment.fechas.fecha_vnz.value),isManual:true,confirm: false}},undefined, true);
                                                cambiar();
                                            }
                                        },
                                        {name:"Cancelar",
                                            action: function () {
                                                $scope.fechas.send ={};
                                                $scope.calc =undefined;
                                                $scope.$parent.shipment.fechas.fecha_vnz = angular.copy($scope.fechas.fecha_vnz.in);
                                            }
                                        }

                                    ]);
                            }else{
                                $scope.setSend ({fecha_vnz:{value: angular.copy($scope.$parent.shipment.fechas.fecha_vnz.value),isManual:true,confirm: false}},'fecha_tienda', true);
                                cambiar();
                            }
                        }else{
                            $scope.setSend ({fecha_vnz:{value: angular.copy($scope.$parent.shipment.fechas.fecha_vnz.value),isManual:true,confirm: false}},'fecha_tienda', true);
                            cambiar();

                        }

                    }
                });

            };
            if($scope.$parent.shipment.fechas.fecha_vnz.max){

                var max = DateParse.toDate($scope.$parent.shipment.fechas.fecha_vnz.max);
                if($scope.$parent.shipment.fechas.fecha_vnz.value > max){
                    $scope.$parent.NotifAction("alert", "La fecha ideal para la llegada a venezuela, es "+ max.getDate()+"/"+max.getMonth()+"/"+max.getFullYear()+" ¿Esta seguro que la fecha es correcta?",
                        [
                            {name:"Si, estoy seguro", action: function ()
                            {
                                cambiarRv();
                            }
                            }
                            ,{name:"No, dejame corregirlo", action: function ()
                        {
                            $scope.$parent.shipment.fechas.fecha_vnz.value = angular.copy($scope.fechas.fecha_vnz.in);
                        }
                        }
                        ]
                        ,{block:true,save:{doc_tipo_id:"24", doc_id:$scope.$parent.shipment.id}});
                }else{
                    cambiarRv();
                }
            }
            else{
                cambiarRv();
            }






        }
    };

    $scope.changeFecha_tienda = function () {

        var cambiar = function () {
            $timeout(function () {
                $scope.fechas.calc = undefined;
                $scope.setSend ({fecha_tienda:{value: angular.copy($scope.$parent.shipment.fechas.fecha_tienda.value),isManual:true,confirm: false}},undefined, true);
                if($scope.$parent.shipment.fechas.fecha_tienda.value <= new Date() && $scope.$parent.shipment.fechas.fecha_vnz.confirm){
                    $scope.$parent.NotifAction("alert","Esta fecha es definitiva",
                        [
                            {
                                name:"Si, es la definitiva",action : function () {
                                $scope.fechas.send.fecha_tienda.confirm = true;
                                $scope.fechas.bind.estado = true;
                            }
                            },{
                            name:"No ",action : function () {
                                $scope.fechas.send.fecha_tienda.confirm = false;
                                $scope.fechas.bind.estado = true;
                            }
                        }
                        ]
                        , {block:true});
                }else{
                    $scope.fechas.bind.estado = true;
                }
            },0);

        };

        if($scope.$parent.shipment.fechas.fecha_tienda.max){
            var max = DateParse.toDate($scope.$parent.shipment.fechas.fecha_tienda.max);

            if($scope.$parent.shipment.fechas.fecha_tienda.value > max){
                $scope.$parent.NotifAction("alert", "La fecha de tienda ideal  es "+ max.getDate()+"/"+max.getMonth()+"/"+max.getFullYear()+" ¿Esta seguro que la fecha es correcta?",
                    [
                        {name:"Si, estoy seguro", action: function ()
                        {
                            cambiar();
                        }
                        }
                        ,{name:"No, dejame corregirlo", action: function ()
                    {
                        $scope.$parent.shipment.fechas.fecha_tienda.value = angular.copy($scope.fechas.fecha_tienda.in);
                    }
                    }
                    ]
                    ,{block:true,save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            }else{
                cambiar();
            }
        }else{
            cambiar();
        }



    }
    $scope.desblockFecha_carga = function () {


        console.log("desbloqueo forsoso");
    };
    $scope.desblockFecha_tienda = function () {
        console.log("desbloqueo forsoso");
    };
    $scope.desblockFecha_vnz = function () {
        console.log("desbloqueo forsoso");
    };

    //pagos+
    // fechas
    $scope.inPay = function (v,k) {
        $scope.pagos[k].val=  (v) ? v: undefined;

    };
    $scope.outPayMar = function () {
        var save = function () {
            $scope.$parent.save(function () {
                $scope.pago.$setPristine();
            });
        };
        if(!$scope.pago.$pristine &&  $scope.$parent.shipment.criterios.flete_maritimo ){
            var range = $scope.$parent.shipment.criterios.flete_maritimo;
            var val = parseFloat($scope.$parent.shipment.flete_maritimo);
            if(val < range.min ){
                var focus= angular.element("#detailShipment #flete_maritimo");
                $scope.$parent.NotifAction("alert", "¡Parece muy bueno para ser cierto! el monto que colocaste es un poco bajo" +
                    " para un flete maritimo. Por favor confirmanos que esta bien ",
                    [
                        {name:"Si, Es lo que muestra la factura ", action: function () {
                            $scope.pagos.flete_maritimo.confirm = true;
                            save();
                        }},
                        {name:"Corregir", action: function () {
                            focus.focus();
                            $scope.pagos.flete_maritimo.confirm = false;
                            $scope.$parent.shipment.flete_maritimo = angular.copy($scope.pagos.flete_maritimo.val);
                        }
                        }
                    ]
                    ,{block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            } if(val > range.max ){
                $scope.$parent.NotifAction("alert", "¡Parece que es mas de un contenedor! el monto que colocaste es un poco alto" +
                    " para un flete maritimo. Por favor confirmanos que está bien ",
                    [
                        {name:"Si, Es mas de un contenedor ", action: function () {
                            $scope.pagos.flete_maritimo.confirm = true;
                            save();
                        }},
                        {name:"Corregir", action: function () {
                            focus.focus();
                            $scope.pagos.flete_maritimo.confirm = false;
                            $scope.$parent.shipment.flete_maritimo = angular.copy($scope.pagos.flete_maritimo.val);
                        }
                        }
                    ]
                    ,{block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            }else{
                save();
            }
        }
    }

    $scope.outPayTerre = function () {
        var save = function () {
            $scope.$parent.save(function () {
                $scope.pago.$setPristine();
            });
        };
        if(!$scope.pago.$pristine &&  $scope.$parent.shipment.criterios.flete_tt ){
            var range = $scope.$parent.shipment.criterios.flete_tt;
            var val = parseFloat($scope.$parent.shipment.flete_tt);
            if(val < range.min ){
                var focus= angular.element("#detailShipment #flete_tt");
                $scope.$parent.NotifAction("alert", "¡Parece muy bueno para ser cierto! el monto que colocaste es un poco bajo" +
                    ". Por favor confirmanos que esta bien ",
                    [
                        {name:"Si, Es lo que muestra la factura ", action: function () {
                            $scope.pagos.flete_tt.confirm = true;
                            save();
                        }},
                        {name:"Corregir", action: function () {
                            focus.focus();
                            $scope.pagos.flete_tt.confirm = false;
                            $scope.$parent.shipment.flete_tt = angular.copy($scope.pagos.flete_tt.val);
                        }
                        }
                    ]
                    ,{block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            } if(val > range.max ){
                $scope.$parent.NotifAction("alert", "¡Parece que es mas de un contenedor! el monto que colocaste es un poco alto" +
                    ". Por favor confirmanos que está bien ",
                    [
                        {name:"Si, Es mas de un contenedor ", action: function () {
                            $scope.pagos.flete_tt.confirm = true;
                            save();
                        }},
                        {name:"Corregir", action: function () {
                            focus.focus();
                            $scope.pagos.flete_tt.confirm = false;
                            $scope.$parent.shipment.flete_tt = angular.copy($scope.pagos.flete_tt.val);
                        }
                        }
                    ]
                    ,{block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            }else{
                save();
            }
        }
    }

    $scope.outPayNac = function () {
        var save = function () {
            $scope.$parent.save(function () {
                $scope.pago.$setPristine();
            });
        };
        if(!$scope.pago.$pristine &&  $scope.$parent.shipment.criterios.nacionalizacion ){
            var range = $scope.$parent.shipment.criterios.nacionalizacion;
            var val = parseFloat($scope.$parent.shipment.nacionalizacion);
            if(val < range.min ){
                var focus= angular.element("#detailShipment #nacionalizacion");
                $scope.$parent.NotifAction("alert", "¡Parece muy bueno para ser cierto! En estos ultimos embarques hemos tenido muchos gastos y el monto que colocates es " +
                    " un poco bajo. Por favor confirmanos que esta bien",
                    [
                        {name:"Si", action: function () {
                            $scope.pagos.nacionalizacion.confirm = true;
                            save();
                        }},
                        {name:"Corregir", action: function () {
                            focus.focus();
                            $scope.pagos.nacionalizacion.confirm = false;
                            $scope.$parent.shipment.nacionalizacion = angular.copy($scope.pagos.nacionalizacion.val);
                        }
                        }
                    ]
                    ,{block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            } if(val > range.max ){
                $scope.$parent.NotifAction("alert", "¡Son muchos gastos! Parece que tuvimos algunos inconvenientes con este embarque" +
                    " . Por favor confirmanos que el monto que colocaste esta bien ",
                    [
                        {name:"Si", action: function () {
                            $scope.pagos.nacionalizacion.confirm = true;
                            save();
                        }},
                        {name:"Corregir", action: function () {
                            focus.focus();
                            $scope.pagos.nacionalizacion.confirm = false;
                            $scope.$parent.shipment.nacionalizacion = angular.copy($scope.pagos.nacionalizacion.val);
                        }
                        }
                    ]
                    ,{block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
            }else{
                save();
            }
        }
    }


    $scope.aprobFlete = function(){
        if($scope.$parent.shipment.flete_tt){
            if(!$scope.$parent.shipment.conf_monto_ft_tt){
                $scope.$parent.NotifAction("alert","¿Desea aprobar el monto de flete terrestre?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {
                            $scope.$parent.shipment.conf_monto_ft_tt = true;
                            $scope.$parent.save(function () {

                                $scope.$parent.NotifAction("ok", "Aprobacion realizada",[], {autohidden:1500});
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );

            }else{
                $scope.$parent.NotifAction("alert","¿Esta seguro de remover la aprobacion de flete terrestre?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {

                            $scope.$parent.shipment.conf_monto_ft_tt = true;
                            $scope.$parent.save(function () {

                                $scope.$parent.NotifAction("ok", "Aprobacion removida",[], {autohidden:1500});
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );
            }
        }

    };

    $scope.aprobMaritimo = function(){
        if($scope.$parent.shipment.flete_maritimo){
            if(!$scope.$parent.shipment.conf_monto_ft_maritimo){
                $scope.$parent.NotifAction("alert","¿Desea aprobar el monto de flete Maritmo?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {
                            $scope.$parent.shipment.conf_monto_maritimo = true;
                            $scope.$parent.save(function () {

                                $scope.$parent.NotifAction("ok", "Aprobacion realizada",[], {autohidden:1500});
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );

            }else{
                $scope.$parent.NotifAction("alert","¿Esta seguro de remover la aprobacion de flete terrestre?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {

                            $scope.$parent.shipment.conf_monto_maritimo = true;
                            $scope.$parent.save(function () {

                                $scope.$parent.NotifAction("ok", "Aprobacion removida",[], {autohidden:1500});
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );
            }
        }

    };
    $scope.aprobNac = function(){
        if($scope.$parent.shipment.nacionalizacion){
            if(!$scope.$parent.shipment.conf_monto_nac){
                $scope.$parent.NotifAction("alert","¿Desea aprobar el monto de nacionalizacion?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {
                            $scope.$parent.shipment.conf_monto_nac = true;
                            $scope.$parent.save(function () {

                                $scope.$parent.NotifAction("ok", "Aprobacion realizada",[], {autohidden:1500});

                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );

            }else{
                $scope.$parent.NotifAction("alert","¿Esta seguro de remover la aprobacion del monto de nacionalizacion?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {
                            $scope.$parent.shipment.conf_monto_nac = true;
                            $scope.$parent.save(function () {

                                $scope.$parent.NotifAction("ok", "Aprobacion removida",[], {autohidden:1500});
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );
            }
        }

    }
    $scope.aprobDua= function(){
        if($scope.$parent.shipment.dua){
            if(!$scope.$parent.shipment.conf_monto_dua){
                $scope.$parent.NotifAction("alert","¿Desea aprobar el monto a pagar por el documento unico de aduana?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {
                            $scope.$parent.shipment.conf_monto_dua = true;
                            $scope.$parent.save(function () {


                                $scope.$parent.NotifAction("ok", "Aprobacion realizada",[], {autohidden:1500});
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );

            }else{
                $scope.$parent.NotifAction("alert","¿Esta seguro de remover la aprobacion del pago por el documento unico de aduana?",
                    [
                        {name:"Si, eso quiero", default:9,action:function () {
                            $scope.$parent.NotifAction("ok", "Aprobacion removida",[], {autohidden:1500});
                            $scope.$parent.save(function () {

                                $scope.$parent.shipment.conf_monto_dya = true;
                            });
                        }},
                        {name:"No",action:function () {}}
                    ],{block:true}
                );
            }
        }

    }





}]);

MyApp.controller('listTariffCtrl',['$scope','$timeout', 'DateParse', 'shipment','tarifForm','setGetShipment',   function($scope,$timeout, DateParse, $resource,tarifForm, $model){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.pais_idSelec = undefined;
    $scope.pais_idText = undefined;
    $scope.puerto_idSelec = undefined;
    $scope.puerto_idText = undefined;
    $scope.tarifBind= tarifForm.bind();
    $scope.tarifaSelect = {};

    $scope.$parent.listTariffCtrl = function(fn){
        if($scope.$parent.shipment.tarifa_id  != null && $scope.$parent.shipment.objs.tarifa_id.model){
            angular.forEach($scope.$parent.shipment.objs.tarifa_id.model, function(v,k){
                $scope.tarifaSelect[k] =v;
            });
        }else{
            $scope.tarifaSelect ={};
        }
        if( !$scope.pais_idSelec ||  $scope.pais_idSelec.id || $scope.puerto_idSelec ||  $scope.puerto_idSelec.id){
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
        }
        $scope.LayersAction({open:{name:"listTariff",after: function () {
            $timeout(function () {
                var ele = angular.element("#listTariff input").first();
                ele.focus();
            },0);
        }
        }});
    };


    $scope.setData = function(data){
        if($scope.$parent.shipment.aprob_superior && $scope.shipment.tarifa_id){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y su tarifa no puede ser modificada",[], {autohidden:2000});
        }else{
            if($scope.tarifaSelect.id != data.id){
                if(!$scope.$parent.shipment.fechas.confirm){
                    if($scope.$parent.shipment.tarifa_id &&
                        ($scope.$parent.shipment.fechas.fecha_vnz.isManual || $scope.$parent.shipment.fechas.fecha_tienda.isManual) &&
                        $scope.$parent.shipment.objs.tarifa_id.model.dias_tt != data.dias_tt){
                        var text = (parseFloat($scope.$parent.shipment.objs.tarifa_id.model.dias_tt) < parseFloat(data.dias_tt)) ? 'aumentara' : 'disminuira';

                        $scope.$parent.NotifAction("alert", "La tarifa selecionada "+ text+ " la fecha de llegada a Venezuela y la fecha de llegada a la tienda",
                            [
                                {name:"Ajustar la fecha segun la nueva tarifa", action:function () {
                                    $scope.setTarif(data);
                                    $scope.$parent.shipment.tarifa_id = data.id;
                                    $scope.$parent.save(function () {
                                        $resource.getMod({type:"Shipment",mod:"Dates", from:'fecha_vnz', id: $scope.$parent.shipment.id}, {},function (response) {
                                            var send = response;
                                            send.id = $scope.$parent.shipment.id;
                                            $resource.postMod({type:"Shipment",mod:"SaveDates"}, send,function (response) {
                                                $model.setDates(response);
                                                $scope.$parent.NotifAction("ok", "Tarifa asignada las fechas fueron actualizadas",[], {autohidden:2000});
                                            });

                                        });
                                    });
                                }
                                },
                                {name:"Mantener la fechas actuales", action :function () {
                                    $scope.$parent.shipment.tarifa_id = data.id;
                                    $scope.setTarif(data);

                                    $scope.$parent.save();
                                }
                                },
                                {name:"Cancelar", action: function () {

                                }}
                            ]
                            ,{block:true})
                    }else{
                        $scope.setTarif(data, function () {

                            $scope.$parent.NotifAction("ok","Tarifa asignada ",[],{autohidden:1000});
                            $scope.$parent.reloadDates();
                        });
                    }
                }else{
                    console.log("cambio forsoso")
                }
            }
        }

    };

    $scope.setTarif = function (data,fn) {
        angular.forEach(data, function(v,k){
            $scope.tarifaSelect[k] =v;
        });
        $model.change('tarifa', 'tarifa_id',data.id);
        $scope.$parent.shipment.tarifa_id = data.id;
        if(!$scope.$parent.shipment.objs.tarifa_id){
            $scope.$parent.shipment.objs.tarifa_id= {};
        }
        if(!$scope.$parent.shipment.objs.naviera){
            $scope.$parent.shipment.objs.naviera= {};
        }

        $scope.$parent.shipment.objs.tarifa_id.freight_forwarder = angular.copy(data.objs.freight_forwarder_id);//tarifa_id.freight_forwarder
        $scope.$parent.shipment.objs.tarifa_id.naviera = angular.copy(data.objs.naviera_id);
        $model.change("tarifa",'freight_forwarder_id',$scope.$parent.shipment.objs.tarifa_id.freight_forwarder.id);
        $model.change("tarifa",'naviera_id',$scope.$parent.shipment.objs.tarifa_id.naviera.id);
        $scope.$parent.save(fn);

    };
    $scope.$watch("tarifBind.estado", function (newVal, oldVal) {
        if(newVal && newVal == 'created' && tarifForm.get()){
            $scope.tbl.data.push(tarifForm.get());
            angular.forEach(tarifForm.get(), function(v,k){
                $scope.tarifaSelect[k] =v;
            });
            $scope.setTarif(tarifForm.get())
            tarifForm.setState("waith");

            $scope.$parent.reloadDates();

        }
    });
    $scope.$watch("$parent.paisSelec", function(newVal){
        if($scope.$parent.paisSelec){
            $scope.pais_idSelec =  newVal;
        }

    });
    $scope.$watch("pais_idSelec", function (newVal) {
        if(newVal ){

            $scope.tbl.data.splice(0,  $scope.tbl.data.length);

        }
        if( $scope.$parent.module.layer == 'listTariff'){
            $model.change('tarifa', 'pais_id',(newVal) ? newVal.id: undefined);
            $scope.puerto_idText  = undefined;
            $scope.$parent.save();
        }

    })
    $scope.$watch("pais_idSelec", function(newVal){
//paisSelec
        if(newVal && $scope.$parent.paisSelec){
            if(newVal.id != $scope.$parent.paisSelec.id){
                $scope.$parent.paisSelec = newVal;
                $timeout(function(){
                    var elem=angular.element("#prov"+newVal.id);
                    angular.element(elem).parent().scrollTop(angular.element(elem).outerHeight()*angular.element(elem).index());
                },0)
            }
        } else if(newVal && $scope.$parent.paisSelec == null){
            $scope.$parent.paisSelec= newVal
        }else{
            $scope.$parent.paisSelec= undefined;
        }
    });
    $scope.$watch('$parent.shipment.objs.pais_id', function(newVal){

        $scope.pais_idSelec=newVal;
        if(newVal && newVal!= null && newVal.id ){


            $resource.query({type:"Country", mod:"Ports", pais_id:newVal.id},{}, function(response){
                $scope.pais_idSelec.ports = response;
            });
            //$scope.$parent.save();

        }
    });
    $scope.$watch('$parent.shipment.objs.puerto_id', function(newVal){
        if(newVal){
            $scope.puerto_idSelec=newVal;
        }

    });
    $scope.$watch('puerto_idSelec', function(newVal){


        if(newVal && newVal !=null){
            $resource.queryMod({type:"Tariff",mod:"List", puerto_id:$scope.puerto_idSelec.id},{}, function (response) {
                $scope.tbl.data= response;
            });



        }
        if( $scope.$parent.module.layer == 'listTariff'){
            $model.change('tarifa', 'puerto_id',(newVal) ? newVal.id: undefined);
            $scope.$parent.save();
        }
    });
    $scope.$watchGroup(['tariffF1.$valid', 'tariffF1.$pristine'], function(newVal){
        if(newVal[0] && !newVal[1]){

            $timeout(function () {
                $scope.$parent.save(function () {
                    $scope.tariffF1.$setPristine();
                });
            },1000);


        }
    });


}]);

MyApp.controller('miniContainerCtrl',['$scope','$mdSidenav','$timeout','form','shipment','setGetShipment',function($scope, $mdSidenav,$timeout,formSrv, $resource, $model){
    $scope.isOpen= false;
    $scope.tipo_select = undefined;
    $scope.tipo_text = undefined;
    $scope.model ={};
    $scope.model_in ={
        volumen:{val:undefined,confirm:false},
        peso:{val:undefined,confirm:false}
    };
    $scope.copy ={};

    //  peso en kgs volumen mt3
    $scope.containers = [
        {name:"20sd",peso:28230  , volumen:33 },
        {name:"40sd",peso:26700 , volumen:67 },
        {name:"40' hc",peso:26460 , volumen:76 },
        {name:"40'ot",26670 :400, volumen:65 },
    ];
    $scope.options ={form:false};
    $scope.select ={};


    //constructor
    $scope.$parent.miniContainerCtrl = function(fn){
        $scope.containerForm.$setPristine();
        $scope.containerForm.$setUntouched();
        $scope.select ={};
        $scope.model_in.peso.confirm= false;
        $mdSidenav("miniContainer").open().then(function(){
            $scope.isOpen= true;
            if($scope.$parent.shipment.containers.length == 0){
                if(fn){
                    fn($scope);
                }
            }
        });
    };

    $scope.outPeso = function () {
        if(!$scope.containerForm.$pristine && $scope.model.peso && !$scope.model_in.peso.confirm && parseFloat($scope.model.peso) > $scope.tipo_select.peso){
            $scope.$parent.NotifAction("alert","El peso del container excede el peso total del tipo de container selecionado ¿Esta seguro que es el peso correcto?",
                [
                    {name:"Si, estoy seguro", action:function ()
                    {
                        angular.element("#miniContainer #volumen").first().focus();
                        $scope.model_in.peso.confirm= true;

                    }
                    },
                    {name:"No, dejame corregirlo", action:function ()
                    {
                        angular.element("#miniContainer #peso").first().focus();
                        $scope.model_in.peso.confirm= false;
                    }
                    }
                ]
                , {block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}}
            );
        }

    };
    $scope.outVolumen= function () {
        if(!$scope.containerForm.$pristine && $scope.model.volumen && parseFloat($scope.model.volumen) > $scope.tipo_select.volumen){
            $scope.$parent.NotifAction("alert","El volumen del container excede el volumen total del tipo de container selecionado ¿Esta seguro que  el volumen es  correcto?",
                [
                    {name:"Si, estoy seguro", action:function ()
                    {
                        $scope.save();
                    }
                    },
                    {name:"No, dejame corregirlo", action:function ()
                    {
                        angular.element("#miniContainer #volumen").first().focus();
                        $scope.model.volumen = angular.copy($scope.model_in.volumen);
                    }
                    }
                ]
                , {block:true, save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});


        }else{
            $scope.save();
        }

    }
    // metodos
    $scope.close = function(){
        if($scope.options.form && !$scope.containerForm.$pristine ){
            formSrv.setState("process");
            if($scope.model.id){
                $scope.$parent.NotifAction("alert", "Se produjeron cambios en el container, ¿Que desea hacer?",
                    [
                        {name:"Descartar", action: function () {
                            $scope.inClose();
                            formSrv.setState("continue");
                        }
                        },
                        {name:"Guardar cambios", default:10 ,action: function () {
                            formSrv.setState("continue");
                            $scope.save(function () {
                                $scope.inClose();
                            });
                        }},
                        {name:"Cancelar", action: function () {
                            formSrv.setState("cancel");
                            $scope.inClose();
                        }}
                    ]

                );
            }else{
                if(!$scope.containerForm.$valid){
                    $scope.inClose();
                    formSrv.setState("continue");

                }else{
                    $scope.$parent.NotifAction("alert", "¿Agregar el container? antes de salir",
                        [
                            {name:"Si", default:10, action: function () {
                                $scope.save(function () {
                                    $scope.inClose();
                                });
                                formSrv.setState("continue");
                            }
                            }
                            ,{name:"No", action: function () {
                            formSrv.setState("continue");
                        }
                        },
                            {name:"Cancelar", action: function () {
                                formSrv.setState("cancel");
                            }
                            }

                        ]
                    );
                }

            }


        }else{
            $scope.inClose();
        }

    };
    $scope.inClose = function(){
        if($scope.isOpen){
            $mdSidenav("miniContainer").close().then(function(){
                $scope.isOpen = false;
            });
        }
    };
    $scope.created = function (){
        if($scope.select.id){
            //   $scope.$parent.NotifAction("error", "Por favor haga click en el container que desea modificar, ",[],{autohidden:1500});

        }else {
            var co= angular.copy($scope.select);
            $scope.model = co;
        }
        $scope.options.form= true;
    };


    $scope.update = function (data){
        if(data){
            $scope.select= data;
        }
        var paso = true;
        if(!$scope.select.id){
            $scope.$parent.NotifAction("error", "Por favor haga click en el container que desea modificar y vuelva a presionarme  ",[],{autohidden:1500});
            paso= false;
        }
        else
        if(!$scope.containerForm.$pristine && $scope.model.id){

            if(!angular.equals($scope.model,$scope.copy)){
                paso= false;
                $scope.$parent.NotifAction("error", "Se produjeron cambios en el container, ¿Que desea hacer?",
                    [
                        {name:"Descartar cambios", default:5, action:
                            function(){
                                $scope.copy= angular.copy($scope.select);
                                $scope.model =$scope.copy($scope.select);
                                $scope.options.form= true;
                            }
                        },
                        {name:"Guardar y continuar ",  action:
                            function(){
                                $scope.savePromise(function(response){
                                    if(response.action== 'upd'){
                                        $scope.copy= angular.copy($scope.select);
                                        $scope.model =$scope.copy($scope.select);
                                        $scope.options.form= true;
                                    }
                                });

                            }
                        }
                    ]
                    ,{block:true});
            }
        }

        if(paso){
            $scope.copy= angular.copy($scope.select);
            $scope.model =angular.copy($scope.select);
            $scope.tipo_select ={name: $scope.select.tipo}
            $scope.options.form= true;
        }

    };
    $scope.setData = function(item , e){
        $scope.select = item;

    };
    $scope.savePromise = function(promise){
        $resource.postMod({type:"Container",mod:"Save"},$scope.model,promise);
    };
    $scope.delete = function(item, e){

        $scope.$parent.NotifAction("alert", "¿Esta seguro de eliminar el container?",
            [
                {name:"No, no deseo eliminarlo",action:
                    function (){

                    }
                },
                {name:"Si estoy seguro", default:5 ,action:
                    function (){
                        $resource.postMod({type:"Container",mod:"Delete"},{id:item.id}, function(response){
                            console.log("response del", response);
                            $scope.$parent.NotifAction("ok", "Container eliminado",[],{autohidden:1500});
                            $scope.$parent.shipment.containers.splice(e.$index,1);
                            $model.change('container'+item.id,'id',undefined);


                        });
                    }
                }
            ]);

    };
    $scope.save = function (fn){
        if(!$scope.containerForm.$pristine){
            if($scope.containerForm.$valid ){
                $scope.model.doc_id= $scope.$parent.shipment.id;
                $resource.postMod({type:"Container",mod:"Save"},$scope.model, function(response){
                    if(response.action== 'new'){
                        console.log("paren",$scope.$parent.shipment);
                        $scope.$parent.shipment.containers.push(response.model);
                        $model.change('container'+response.model.id,undefined,response.model);
                        // forms['container'+ v.id]
                        $scope.$parent.NotifAction("ok", "Container Agregado",[],{autohidden:2000});
                        $timeout(function () {
                            formSrv.setState("continue");
                            $scope.inClose();
                        },0);
                        $timeout(function(){
                            $scope.containerForm.$setPristine();
                            $scope.containerForm.$setUntouched();
                            $scope.options.form= false;
                            $timeout(function(){
                                $scope.containerForm.$setPristine();
                                $scope.containerForm.$setUntouched();
                                $scope.options.form= false;
                                $scope.model.id=undefined;
                                $scope.model.volumen=undefined;
                                $scope.model.cantidad=undefined;
                                $scope.model.tipo=undefined;
                                $scope.model.peso=undefined;
                                $scope.tipo_text = undefined;
                            },100);
                        },500);
                    }else{
                        if(response.action== 'upd'){

                            $scope.$parent.NotifAction("ok", "Container Actualizado",[],{autohidden:2000});
                            angular.forEach(response.model, function(v,k){
                                $scope.select[k]=v;
                                $model.change('container'+response.model.id,k,v);
                            });
                            $timeout(function(){
                                $scope.containerForm.$setPristine();
                                $scope.containerForm.$setUntouched();
                                $scope.options.form= false;
                                $scope.model.id=undefined;
                                $scope.model.volumen=undefined;
                                $scope.model.cantidad=undefined;
                                $scope.model.tipo=undefined;
                                $scope.model.peso=undefined;
                                $scope.tipo_text = undefined;
                            },100);

                        }
                    }
                    if(fn){
                        fn();
                    }

                });
            }else{
                $scope.$parent.NotifAction("error", "Faltan datos en el formulario, por favor veriquelo",[],{autohidden:1500});
                $timeout(function () {
                    var ele = angular.element("#miniContainer ng-invalid");
                    if(ele.length == 0){
                        ele[0].focus();
                    }else{
                        ele = angular.element("#miniContainer ng-pristine");
                        console.log("asdfa", ele)
                    }
                },0);
            }

        }else {
            $scope.inClose();
        }
    }

}]);

MyApp.controller('listOrdershipmentCtrl',['$scope','shipment','setGetShipment', function($scope,$resource, $model){
    $scope.tbl ={
        order:"id",
        filter:{}
    };
    $scope.select ={};
    $scope.$parent.listOrdershipment = function(){
        $scope.select ={};
        $scope.LayersAction({open:{name:"listOrdershipment", after: function(){


            if($scope.select.id){
                $resource.getMod({type:"Order", mod:"Order", id:$scope.select.id, doc_id:$scope.$parent.shipment.id},{},function (response) {
                    $scope.select.isTotal= response.isTotal;
                });
            }


        }}});
    };
    $scope.changeAsig = function (data) {
        console.log("data");
        var send = {doc_origen_id:data.id, doc_id:$scope.$parent.shipment.id};
        if(data.asignado){
            $resource.postMod({type:"Order", mod:"Save"},send,function (response) {
                $scope.$parent.NotifAction("ok", "Pedido agregado al embarque",[],{autohidden:1500});
                if(response.doc_origen_id){
                    var odc= response.doc_origen_id;
                    odc.asignado =true;
                    odc.isTotal = true;
                    $scope.$parent.shipment.odcs.push(odc)
                    $model.change("odcs"+odc.id,undefined,odc);


                }
            });
        }else{

            $scope.$parent.NotifAction("alert", "¿Esta seguro de remover el pedido y todos sus elementos?",
                [
                    {name:"Si, estoy seguro", default:6, action:
                        function () {
                            $resource.postMod({type:"Order", mod:"Delete"},send,function (response) {
                                $scope.$parent.NotifAction("ok", "El pedido fue removido",[],{autohidden:1500});
                                var index = -1;
                                angular.forEach($scope.$parent.shipment.odcs,function (v, k) {
                                    if(data.id == v.id){
                                        index = k;
                                        return 0;
                                    }
                                } );

                                console.log("index", index);
                                $scope.$parent.shipment.odcs.splice(index,1);
                                $model.change("odcs"+data.id,'id',undefined);


                            });
                        }},
                    {name:"No", action: function () {
                        data.asignado = true;
                    }}

                ],
                {block:true});
        }
    };
    $scope.open = function (data) {
        $scope.select = data;
        $scope.detailOrderShipment(data);
    }
}]);

MyApp.controller('listOrderAddCtrl',['$scope','shipment','DateParse','$timeout', 'setGetShipment',function($scope, $resource,DateParse,$timeout, $model){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.select = {};

    $scope.load = function () {
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        $resource.queryMod({type:"Order", mod:"List", prov_id:$scope.$parent.shipment.prov_id, doc_id: $scope.$parent.shipment.id},{},function (response) {
            angular.forEach(response, function (v) {

                aux = angular.copy(v);
                if(v.fecha_aprob_compra != null){
                    v.fecha_aprob_compra = DateParse.toDate(v.fecha_aprob_compra);
                }
                if(v.fecha_aprob_gerencia != null){
                    v.fecha_aprob_gerencia = DateParse.toDate(v.fecha_aprob_gerencia);

                }
                if(v.fecha_produccion != null){
                    v.fecha_produccion = DateParse.toDate(v.fecha_produccion);

                }
                $scope.tbl.data.push(aux);

            })
        });
    };
    $scope.$parent.listOrderAdd = function(){
        $scope.select = {};

        $scope.LayersAction({open:{name:"listOrderAdd", after:$scope.load}});
    }

    $scope.changeAsig = function (data) {
        if($scope.$parent.shipment.aprob_superior){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y sus articulos no se pueden modificar",[], {autohidden:3500});
        }else{
            if(data.asignado){
                if(!$scope.$parent.shipment.fechas.fecha_carga.confirm){
                    if($scope.$parent.shipment.fechas.fecha_carga.isManual){
                        $resource.getMod({type:"Order", mod:"Order", id:data.id, doc_id:$scope.$parent.shipment.id},{},function (response){
                            var maxDate = DateParse.toDate(response.maxProducion);
                            if(maxDate > $scope.$parent.shipment.fechas.fecha_carga.value){
                                $scope.$parent.NotifAction("alert",
                                    "Esta orden de compra no estara lista para la fecha de carga asignada ¿Que desea hacer?",
                                    [
                                        {name:"Agregar y mantener fecha de carga ",default:15,action:
                                            function(){

                                                $scope.addOrder(data, function () {
                                                    $scope.$parent.reloadDates();
                                                });
                                            }
                                        },
                                        {name:"Agregar y ajustar fechas",action:
                                            function(){
                                                $scope.addOrder(data, function () {
                                                    $timeout(function () {
                                                        $resource.getMod({type:"Shipment",mod:"Dates", from:"fecha_carga", id: $scope.$parent.shipment.id}, {},function (response) {
                                                            var send = response;
                                                            send.id = $scope.$parent.shipment.id;
                                                            $resource.postMod({type:"Shipment",mod:"SaveDates"}, send,function (response) {
                                                                $model.setDates(response);
                                                                $scope.$parent.NotifAction("ok", "Las fechas fueron actualizadas",[], {autohidden:1500});
                                                                $scope.$parent.reloadDates();
                                                            });
                                                        });
                                                    },1000);
                                                });
                                            }
                                        },
                                        {name:"Cancelar",action:
                                            function(){

                                            }
                                        }
                                    ],
                                    {block:true}
                                );
                            }else{
                                $scope.addOrder(data, function () {
                                    $scope.$parent.reloadDates();
                                });

                            }
                        });
                    }else{
                        $scope.addOrder(data, function () {
                            $scope.$parent.reloadDates();
                        });
                    }
                }else{
                    alert("en processo");
                }
            }else{

                $scope.$parent.NotifAction("alert", "¿Esta seguro de remover el pedido y todos sus elementos?",
                    [
                        {name:"Si, estoy seguro", default:6, action:
                            function () {
                                $resource.postMod({type:"Order", mod:"Delete"},{doc_origen_id:data.id},function (response) {
                                    $scope.$parent.NotifAction("ok", "El pedido fue removido",[],{autohidden:1500});
                                    var index = -1;
                                    angular.forEach($scope.$parent.shipment.odcs,function (v, k) {
                                        if(data.id == v.id){
                                            index = k;
                                            return 0;
                                        }
                                    } );

                                    console.log("index", index);
                                    $model.change("odcs"+data.id,'id',undefined);
                                    $scope.$parent.shipment.odcs.splice(index,1);


                                });
                            }},
                        {name:"No", action: function () {
                            data.asignado = true;
                        }}

                    ],
                    {block:true});
            }
        }

    };

    $scope.addOrder = function (data, fn) {
        var send = {doc_origen_id:data.id, doc_id:$scope.$parent.shipment.id};
        $resource.postMod({type:"Order", mod:"Save"},send,function (response) {
            $scope.$parent.NotifAction("ok", "Pedido agregado al embarque",[],{autohidden:1500});
            if(response.doc_origen_id){
                var odc= response.doc_origen_id;
                odc.asignado =true;
                odc.isTotal = true;
                $scope.$parent.shipment.odcs.push(odc);
                $model.change("odcs"+data.id,undefined,odc);

                if(fn){
                    fn();
                }
                $timeout(function () {
                    $model.reloadItems();
                },0)
            }
        });
    }
    $scope.open = function (data) {
        $scope.select = data;
        $scope.$parent.detailOrderAdd(data);
    }


}]);

MyApp.controller('listProducttshipmentCtrl',['$scope','form', function($scope, formSrv){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.bindForm= formSrv.bind();

    $scope.$watch("bindForm.estado", function (newVal, oldVall) {

        if(newVal && formSrv.name == 'DetailProductProducShip'){
            var data = formSrv.getData();
            console.log("data", data);
            if(data.response && data.response.accion == 'del' ){


                angular.forEach($scope.select, function (v, k) {
                    $scope.select[k]= undefined;
                })
            }else{
                angular.forEach(data, function (v, k) {
                    $scope.select[k]= v;
                });
                $scope.select.cantidad= data.saldo;
            }

            $scope.$parent.reloadDates();
        }
        if(newVal && formSrv.name == 'DetailProductCreate'){
            console.log("new object",formSrv.getData() );
            angular.forEach(formSrv.getData(), function (v, k) {
                $scope.select[k]= v;
            });
            $scope.$parent.reloadDates();

        }


    });
    $scope.isUpdate = false;
    $scope.select = {};
    $scope.$parent.listProductshipment = function(){
        $scope.select = {};
        $scope.LayersAction({open:{name:"listProductshipment", after: function(){
            $scope.isUpdate = false;

        }}});
    }

    $scope.open =  function (data) {
        $scope.select = data;

    };

    $scope.update = function () {
        if($scope.$parent.shipment.aprob_superior){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y sus articulos no se pueden modificar",[], {autohidden:3500});
        }else{
            if(!$scope.select.id){
                $scope.$parent.NotifAction("error", "Por favor selecione un articulo primero", [], {autohidden:3500});
            }else{
                formSrv.name= 'DetailProductProducShip';
                var data = {
                    embarque_item_id:$scope.select.id,
                    tipo_origen_id:$scope.select.tipo_origen_id,
                    descripcion:$scope.select.descripcion,
                    origen_item_id:$scope.select.origen_item_id,
                    producto_id:$scope.select.producto_id,
                    saldo:$scope.select.cantidad,
                    cantidad:$scope.select.cantidad,
                    codigo_fabrica:$scope.select.codigo_fabrica,
                    disponible:$scope.select.disponible,
                    codigo:$scope.select.codigo,
                    doc_origen_id:$scope.select.doc_origen_id,
                    uid:$scope.select.uid
                };
                console.log("data en upadtea", data);
                $scope.$parent.DetailProductShipment(data);
            }
        }
    };

    $scope.created = function () {
        formSrv.name= 'DetailProductCreate';
        $scope.$parent.CreatProduct();
    }

    $scope.historia = function () {
        if(!$scope.select.id){
            $scope.$parent.NotifAction("error", "Por favor selecione un articulo primero", [], {autohidden:3500});
        }else{}
    }
}]);

MyApp.controller('updateShipmentCtrl',['$scope','shipment','setGetShipment', '$timeout','form','clickerTime',function ($scope,$resource,$model,$timeout,formSrv,clickerTime) {

    $scope.isModif = false;
    $scope.goTo = {
        titulo:true,
        tarifa_id:true,
        fechas:true,
        mbl:true,
        hbl:true,
        dua:true,
        pagos:true,
        containers:true,
        pedidos:true,
        productos:true
    };
    $scope.model ={document:{},items:[], odcs:[], containers:[]};

    $model.exit = function () {
        console.log("llamando a exit");
        if($model.getInternalState() == 'new'){

            $timeout(function () {
                $model.getNext()();
            },0);


        }else{
            $timeout(function () {
                $scope.Update();
            },0);

        }
    };
    $scope.Update = function(){
        console.log(" eit en upadte 2", $model.getForm());
        $scope.model ={document:{},items:[], odcs:[], containers:[], pagos:{}, tarifa:{}, fechas:{fecha_carga:{},fecha_vnz:{},fecha_tienda:{}}};
        var form = $model.getForm();
        $scope.isModif = false;
        $scope.model.nro_mbl= {};
        $scope.model.nro_hbl= {};
        $scope.model.nro_eaa= {};

        angular.forEach($model.getForm('fecha_carga'), function (v, k){
            if(v.estado && v.estado != 'new'){
                $scope.model.fechas.fecha_carga[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('tarifa'), function (v, k){
            if(v.estado && v.estado != 'new'){
                $scope.model.tarifa[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('fecha_tienda'), function (v, k){
            if(v.estado && v.estado != 'new'){
                $scope.model.fechas.fecha_tienda[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('fecha_vnz'), function (v, k){
            if(v.estado && v.estado != 'new'){
                $scope.model.fechas.fecha_vnz[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('nro_mbl'), function (v, k) {

            if(v.estado && v.estado != 'new'){
                $scope.model.nro_mbl[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('nro_hbl'), function (v, k) {
            if(v.estado && v.estado != 'new'){
                $scope.model.nro_hbl[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('nro_eaa'), function (v, k) {

            if(v.estado && v.estado != 'new'){
                $scope.model.nro_eaa[k]=v;
                $scope.isModif=true;
            }
        });
        angular.forEach($model.getForm('document'), function (v, k) {

            if(v.estado && v.estado != 'new'){
                if( k == 'flete_tt' || k == 'nacionalizacion'|| k =='dua'){
                    $scope.model.pagos[k]=v;
                }
                else{
                    $scope.model.document[k]=v;
                }
                $scope.isModif=true;

            }
        });
        angular.forEach(form, function (v, k) {
            if(k.startsWith("container")){
                if(v.peso.estado != 'new' || v.tipo.estado != 'new' ||  v.volumen.estado !='new' || v.id.estado != 'new'){
                    if(v.peso.estado == 'upd' || v.tipo.estado == 'upd' ||  v.volumen.estado =='upd'){
                        v.estado='upd'
                    }
                    if(v.peso.estado == 'created' || v.tipo.estado == 'created' ||  v.volumen.estado =='created'){
                        v.estado='created'
                    }
                    if( v.id.estado == 'del'){
                        v.estado='del'
                    }

                    $scope.model.containers.push(v);
                    $scope.isModif=true;
                }
            }
            if(k.startsWith("item")){
                if((v.total && v.total.estado !='new') || (v.saldo && v.saldo.estado !='new')  || (v.disponible && v.disponible.estado !='new') || (v.id && v.id.estado) !='new'){
                    if((v.total && v.total.estado == 'upd') || v.saldo.estado == 'upd' ||  v.saldo.estado =='upd'){
                        v.estado='upd'
                    }
                    if((v.total && v.total.estado == 'created') || v.saldo.estado == 'created' ||  v.disponible.estado =='created'){
                        v.estado='created'
                    }
                    if( v.id.estado == 'del'){
                        v.estado='del'
                    }
                    $scope.model.items.push(v);
                    $scope.isModif=true;

                }

            }
            if(k.startsWith("odc")){
                if(v.id.estado != 'new'){
                    $scope.model.odcs.push(v);
                    if(v.id.estado == 'upd'){
                        v.estado='upd'
                    }
                    if(v.id.estado == 'del'){
                        v.estado='del'
                    }
                    $scope.isModif=true;

                }

            }
        });
        if( $scope.isModif){
            console.log("final form", $scope.model);
            if($scope.$parent.module.layer!=  'updateShipment'){
                $scope.LayersAction({open:{name:"updateShipment", before: function(){

                    $scope.$parent.NotifAction("alert","Se ha realizado los siguientes cambios en el embarque son correctos",
                        [
                            {name:"Si, son correctos",default:10, action: function () {

                                $model.getNext()();
                            }
                            },
                            {name:"No, dejame corregirlos", action:function () {

                            }}
                        ]
                        , {block:true});
                }}});
            }else{
                $scope.$parent.NotifAction("alert","Se ha realizado los siguientes cambios en el embarque son correctos",
                    [
                        {name:"Si, son correctos",default:10, action: function () {

                            $model.getNext()();
                        }
                        },
                        {name:"No, dejame corregirlos", action:function () {

                        }}
                    ]
                    , {block:true});
            }
        }else{
            $model.getNext()();
        }
    };


    $scope.keyCount = function (obj) {
        return (obj)? Object.keys(obj) :[];
    };

    $scope.close = function (fn) {
        $resource.postMod({type:"Shipment", mod:'close'}, {id:$scope.$parent.shipment.id}, function (response) {
            if(fn){
                fn(response)
            }
        })
    };
    $scope.goTo = function(data){
        clickerTime({to:data,time:400});
    }

}]);

MyApp.controller('listProductAddCtrl',['$scope','$filter','shipment','form', 'setGetShipment',function($scope,$filter,$resource, formSrv, $model){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.tbl_historia ={
        order:"id",
        filter:{},
        data:[]
    };

    $scope.bindForm= formSrv.bind();
    $scope.select ={};

    $scope.$watch("bindForm.estado", function (newVal, oldVall) {


        if(newVal && formSrv.name == 'DetailProductProduc'){
            var data = formSrv.getData();

            angular.forEach(data, function (v, k) {
                $scope.select[k]=v;
            });

            $scope.$parent.reloadDates();


        }
    });
    $scope.select = {};
    $scope.$parent.listProductAdd = function(){
        $scope.select = {};
        $resource.queryMod({type:"Order", mod:"Products", doc_id:$scope.$parent.shipment.id},{}, function (response) {
            $scope.tbl.data = response;
        });
        $resource.queryMod({type:"Item", mod:"History", doc_id:$scope.$parent.shipment.id},{}, function (response) {
            $scope.tbl_historia.data = response;
        });
        $scope.LayersAction({open:{name:"listProductAdd", after: function(){

        }}});
    };

    /**change asignado en clik espcial */
    $scope.changeAsig = function (data) {
        if($scope.$parent.shipment.aprob_superior){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y sus articulos no se pueden modificar",[], {autohidden:3500});
        }else{
            if(!data.asignado){


                formSrv.name= 'DetailProductProduc';
                $scope.$parent.DetailProductShipment(data);
                $scope.select = data;
            }else{
                $scope.$parent.NotifAction("alert", "¿Esta seguro de eliminar el producto ?",
                    [
                        {name:"Si, estoy seguro", action:
                            function () {
                                var send = {id:data.embarque_item_id};
                                $resource.postMod({type:"OrderItem", mod:"Delete"},send,function (response){
                                    $scope.$parent.NotifAction("ok", "El producto fue removido",[], {autohidden:1500});
                                    var index = -1;
                                    angular.forEach($scope.$parent.shipment.items,function (v, k) {
                                        if(data.embarque_item_id == v.id){
                                            index = k;
                                            return 0;
                                        }
                                    } );
                                    $scope.select.asignado= false;
                                    $scope.select.cantidad= response.cantidad;

                                    console.log(" hola mundo", index);
                                    $scope.$parent.shipment.items.splice(index,1);
                                    $model.change("item"+data.embarque_item_id,'id', undefined);


                                });

                            }
                        },
                        {name:"No", action:function () {

                        }
                        }
                    ],
                    {block:true});
            }
        }

    }
    $scope.filterProd = function (key) {
        console.log("key", key);
        $scope.key={producto_id:key};
    };


    $scope.clear = function () {
        $scope.key.producto_id = undefined;
    }
    $scope.history = function () {
        if($scope.tbl_historia.data){
            if($scope.key){
                return  $filter("customFind")($scope.tbl_historia.data),$scope.key,function(current,compare){return current.producto_id==compare};
            }

            return $scope.tbl_historia.data;
        }
        return [];
    }

}]);

MyApp.controller('CreatProductCtrl',['$scope','$mdSidenav','$timeout','masters','form','shipment', 'setGetShipment',function($scope,$mdSidenav, $timeout,masters, formSrv, $resource, $model){
    $scope.isOpen = false;

    $scope.$parent.CreatProduct = function(){
        $scope.formProduct.$setPristine();
        $scope.formProduct.$setUntouched();
        $scope.almacnAdd = [] ;
        $scope.model ={almcenes:[]};
        $scope.model.prov_id= $scope.$parent.shipment.prov_id;
        $scope.lineas = [];
        $scope.lineaSelec = undefined;
        $scope.lineaText = undefined;
        $scope.almacn = [];
        $scope.almacnSelect = undefined;
        $scope.almacnText = undefined ;
        $scope.subLineas = [];
        $scope.SublineaSelec = undefined;
        $scope.SublineaText = undefined ;
        masters.query({type:"prodLines"},{}, function (response) {
            $scope.lineas= response;
        });
        masters.query({type:"DirStores"},{}, function (response) {
            $scope.almacn= response;
        });


        $mdSidenav("miniCreatProduct").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope. save = function (fn) {
        $resource.postMod({type:"Product", mod:"CreateOnAdd"},$scope.model,function (response) {
            $model.change("item"+response.model.id, undefined,response);
            $scope.$parent.shipment.items.push(response.model);
            $scope.$parent.NotifAction("ok", "Producto creado y añadido",[],{autohidden:2000});
            $scope.inClose();
            formSrv.setData(response.model);
            formSrv.setState("continue");
            if(fn){
                fn(response);
            }
        });
    }
    $scope.close= function(e){
        if($scope.isOpen){
            if($scope.formProduct.$pristine ){
                $scope.inClose();
            }else if(!$scope.formProduct.$pristine && !$scope.formProduct.$valid){
                formSrv.setState("porcess")
                $scope.NotifAction("alert","No se puede guardar el Producto ¿Que desea hacer?",
                    [
                        {name:"Cancelar", action: function () {
                            $scope.inClose();
                            formSrv.setState("continue");
                        }
                        },
                        {name:"Corregir", action: function () { formSrv.setState("cancelar");}}
                    ]
                    , {block:true});
            }else {
                $scope.save();
            }

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

    $scope.inClose =  function(){
        $mdSidenav("miniCreatProduct").close().then(function(){
            $scope.isOpen = false;
        });
    }

    $scope.$watch('lineaSelec', function (newVal, oldVal) {
        if(newVal ){
            masters.query({type:"prodSubLines", linea_id: newVal.id},{}, function (response) {
                $scope.subLineas =response;
            });

        }
    });


}]);

MyApp.controller('miniMblCtrl',['$scope','$mdSidenav','$timeout','$interval','fileSrv','shipment','setGetShipment', function($scope,$mdSidenav,$timeout, $interval,fileSrv, $resource, $model){
    $scope.isOpen = false;
    $scope.cola ={estado:'waith', data :[], upload:0, cola:0};
    $scope.bindFiles = fileSrv.bin();
    //{{up:[}, size, estado:'waith'}
    //{estado:'wait',cu}

    $scope.nro_mbl ={};
    $scope.$parent.miniMbl = function(){
        $scope.head.$setPristine();
        $scope.head.$setUntouched();
        $mdSidenav("miniMbl").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.toEditHead= function(id,val){

        if(id== 'emision'){
            if(val){

                $model.change("nro_mbl",id,val.toString());
            }else{
                $model.change("nro_mbl",id,undefined);
            }
        }else{
            $model.change("nro_mbl",id,val.toString());
        }

    };


    $scope.$watchGroup(['head.$valid', 'head.$pristine'], function(newVal){
        if($scope.isOpen && !newVal[1]){
            $resource.post({type:"Save"},$scope.$parent.shipment, function (response) {
                $scope.head.$setPristine();
            });
        }
    });

    $scope.fileUp= function (file) {
        $resource.postMod({type:"Attachment", mod:"Save"},{archivo_id:file.id,documento:'nro_mbl', doc_id:$scope.$parent.shipment.id}, function (response) {

        }, function (error) {
            console.log("error", error);
        });
    };

    /**adjuntos**/
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage("shipments");
            fileSrv.setKey("miniMblCtrl");
            angular.forEach(fileSrv.upload($scope.files), function (v, k) {
                $scope.$parent.shipment.nro_mbl.adjs.push(v);
            });
        }
    });

    $scope.$watch('bindFiles.estado', function (newVal) {
        if(fileSrv.getKey() == 'miniMblCtrl'){
            var result = angular.copy(fileSrv.get());
            if(newVal == 'finish'){
                var texto = '';
                //{succeces:[], error:[], total:[],upload:{}};
                if(result.succeces.length > 0){
                    texto += " Se agregaron "+result.succeces.length +" archivos";
                }
                if(result.error.length > 0){
                    texto += " fallaron "+result.error.length +" archivos";
                }
                if(result.total.length > 0){
                    texto += " de  "+result.total.length +" ";
                }
                if(texto.length > 1){
                    $scope.$parent.NotifAction("ok", texto, [],{autohidden:4000})
                }

            }
        }
    });



    $scope.close= function(e){
        if($scope.isOpen){
            $mdSidenav("miniMbl").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('miniHblCtrl',['$scope','$mdSidenav','$timeout','$interval','fileSrv','shipment','setGetShipment', function($scope,$mdSidenav,$timeout, $interval,fileSrv, $resource,$model){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.cola ={estado:'waith', data :[], upload:0, cola:0};
    $scope.bindFiles = fileSrv.bin();

    $scope.$parent.miniHbl = function(){
        $mdSidenav("miniHbl").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.toEditHead= function(id,val){
        $model.change("nro_hbl",id,val);
    };

    $scope.fileUp= function (file) {
        $resource.postMod({type:"Attachment", mod:"Save"},{archivo_id:file.id,documento:'nro_hbl', doc_id:$scope.$parent.shipment.id}, function (response) {

        }, function (error) {
            console.log("error", error);
        });
    };

    $scope.$watchGroup(['head.$valid', 'head.$pristine'], function(newVal){
        if($scope.isOpen && !newVal[1]){
            $resource.post({type:"Save"},$scope.$parent.shipment, function (response) {
                $scope.head.$setPristine();
            });
        }
    });
    /**adjuntos**/
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage("shipments");
            fileSrv.setKey("miniHblCtrl");
            angular.forEach(fileSrv.upload($scope.files), function (v, k) {
                $scope.$parent.shipment.nro_hbl.adjs.push(v);
            });
        }
    });

    $scope.$watch('bindFiles.estado', function (newVal) {
        if(fileSrv.getKey() == 'miniHblCtrl'){
            var result = angular.copy(fileSrv.get());
            if(newVal == 'finish'){
                var texto = '';
                //{succeces:[], error:[], total:[],upload:{}};
                if(result.succeces.length > 0){
                    texto += " Se agregaron "+result.succeces.length +" archivos";
                }
                if(result.error.length > 0){
                    texto += " fallaron "+result.error.length +" archivos";
                }                if(result.total.length > 0){
                    texto += " de  "+result.total.length +" ";
                }
                if(texto.length > 1){
                    $scope.$parent.NotifAction("ok", texto, [],{autohidden:4000})
                }

            }
        }
    });


    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniHbl").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('miniExpAduanaCtrl',['$scope','$mdSidenav','$timeout','$interval','fileSrv','shipment','setGetShipment', function($scope,$mdSidenav,$timeout, $interval,fileSrv, $resource,$model){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.cola ={estado:'waith', data :[], upload:0, cola:0};
    $scope.bindFiles = fileSrv.bin();

    $scope.$parent.miniExpAduana = function(){
        $mdSidenav("miniExpAduana").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.toEditHead= function(id,val){
        $model.change("nro_eaa",id,val);
    };
    $scope.fileUp= function (file) {
        $resource.postMod({type:"Attachment", mod:"Save"},{archivo_id:file.id,documento:'nro_eaa', doc_id:$scope.$parent.shipment.id}, function (response) {

        }, function (error) {
            console.log("error", error);
        });
    };

    $scope.$watchGroup(['head.$valid', 'head.$pristine'], function(newVal){
        if($scope.isOpen && !newVal[1]){
            $resource.post({type:"Save"},$scope.$parent.shipment, function (response) {
                $scope.head.$setPristine();
            });

        }
    });
    /**adjuntos**/
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage("shipments");
            fileSrv.setKey("miniExpAduanaCtrl");
            angular.forEach(fileSrv.upload($scope.files), function (v, k) {
                $scope.$parent.shipment.nro_eaa.adjs.push(v);
            });
        }
    });

    $scope.$watch('bindFiles.estado', function (newVal) {
        if(fileSrv.getKey() == 'miniExpAduanaCtrl'){
            var result = angular.copy(fileSrv.get());
            if(newVal == 'finish'){
                var texto = '';
                //{succeces:[], error:[], total:[],upload:{}};
                if(result.succeces.length > 0){
                    texto += " Se agregaron "+result.succeces.length +" archivos";
                }
                if(result.error.length > 0){
                    texto += " fallaron "+result.error.length +" archivos";
                }                if(result.total.length > 0){
                    texto += " de  "+result.total.length +" ";
                }
                if(texto.length > 1){
                    $scope.$parent.NotifAction("ok", texto, [],{autohidden:4000})
                }

            }
        }
    });
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniExpAduana").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('miniCancelShipmentCtrl',['$scope','$mdSidenav','$timeout','$interval','fileSrv','shipment','setGetShipment',function($scope,$mdSidenav,$timeout, $interval,fileSrv, $resource,$model){

    $scope.bindFiles = fileSrv.bin();

    $scope.$parent.miniCancelShipment = function () {
        $scope.model = {adjs:[]};
        $scope.mode = 'list';
        $mdSidenav("miniCancelShipment").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage("shipments");
            fileSrv.setKey("miniCancelShipmentCtrl");
            angular.forEach(fileSrv.upload($scope.files), function (v, k) {
                $scope.model.adjs.push(v);
            });
        }
    });

    $scope.$watch('bindFiles.estado', function (newVal) {
        if(fileSrv.getKey() == 'miniCancelShipmentCtrl'){
            var result = angular.copy(fileSrv.get());
            if(newVal == 'finish'){
                var texto = '';
                //{succeces:[], error:[], total:[],upload:{}};
                if(result.succeces.length > 0){
                    texto += " Se agregaron "+result.succeces.length +" archivos";
                }
                if(result.error.length > 0){
                    texto += " fallaron "+result.error.length +" archivos";
                }                if(result.total.length > 0){
                    texto += " de  "+result.total.length +" ";
                }
                if(texto.length > 1){
                    $scope.$parent.NotifAction("ok", texto, [],{autohidden:4000})
                }

            }
        }
    });
    $scope.inClose = function () {
        $mdSidenav("miniCancelShipment").close().then(function(){
            $scope.isOpen = false;
        });
    };

    $scope.close = function () {
        if( $scope.isOpen){
            if(!$scope.form.$pristine){
                if($scope.form.$valid){
                    $scope.save();
                }else{
                    $scope.$parent.NotifAction("alert", "No se agrego el motivo de cancelacion",
                        [
                            {name:"Corregir", action:function () {}},
                            {name:"Cancelar", action:function (){$scope.inClose();}
                            }
                        ]
                        ,{block:true});

                }

            }else{
                $scope.inClose();
            }
        }
    };


    $scope.send = function () {
        $scope.model.id=$scope.$parent.shipment.id;
        $resource.postMod({type:"Shipment", mod:"Cancel"},$scope.model, function (response) {
            $scope.inClose();
            $scope.$parent.NotifAction("ok", "Se ha cancelado el documento",[],{autohidden:2000});
            if($scope.module.historia[1] == 'detailShipment'){
                $scope.LayersAction({close:{all:true}});
            }else{
                $scope.LayersAction({close:{first:true, search:true}});
            }

        })
    };
    $scope.save = function () {

        $scope.$parent.NotifAction("alert", " ¿Esta seguro de Cancelar el embarque conl os datos suministrados? ",
            [
                {name:"Si, estoy completamente seguro", action:
                    function(){
                        $scope.send();
                    }
                },{name:"Olvide colocar algo, dejarme terminar", action:
                function(){
                    $scope.inClose();
                }
            },{name:"Cancelar", action:
                function(){
                    $scope.inClose();
                }
            }
            ]
            , {block:true,save:{mod:'embarque',tipo_origen_id:"24", doc_origen_id:$scope.$parent.shipment.id}});
    };

}]);

MyApp.controller('miniAprobShipmentCtrl',['$scope','$mdSidenav','shipment','setGetShipment','form',function($scope,$mdSidenav,$resource,$model,formSrv){


    $scope.$parent.miniAprobShipment = function () {
        $scope.block = false;

        $mdSidenav("miniAprobShipment").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.inClose = function () {
        $mdSidenav("miniAprobShipment").close().then(function(){
            $scope.isOpen = false;
        });
    };

    $scope.save = function (fn ) {
        $scope.$parent.shipment.aprob_superior_comentario= angular.copy($scope.model.texto);
        $scope.$parent.save(function () {
            $scope.block = false;
            $scope.NotifAction("ok","Documento aprobado",[], {autohidden:2000});
            if(fn){
                fn();
            }

        })
    };

    $scope.close = function () {
        if( $scope.isOpen){
            if(!$scope.block){
                $scope.block = true;
                if(!$scope.form.$pristine){
                    if($scope.form.$valid){
                        $scope.save(function () {
                            $scope.$parent.shipment.aprob_superior = true;
                            $scope.inClose();

                        });
                    }else{
                        formSrv.setState("process");
                        $scope.$parent.NotifAction("alert", "!No has colocado el comentario¡ ¿Esta seguro de salir ?",
                            [{name:"Salir, y no aprobar", action:function () {
                                $scope.$parent.shipment.aprob_superior = false;  $scope.save(function () {
                                    $scope.inClose();
                                    formSrv.setState("continue");
                                });
                            }},{name:"Salir, y aprobar sin agregar un comentario", action:function () {
                                $scope.$parent.shipment.aprob_superior = true; $scope.save(function () {
                                    $scope.inClose();
                                    formSrv.setState("continue");
                                });
                            }},{name:"Corregir", action:function () {
                                formSrv.setState("cancel");
                            }}

                            ]
                            , {block:true});
                    }
                }else{
                    $scope.inClose();
                }
            }

        }
    };

}]);

MyApp.controller('detailOrderShipmentCtrl',['$scope','DateParse','shipment','form', function($scope, DateParse,$resource, form){
    $scope.isOpen = false;
    $scope.tbl ={data:[]};
    $scope.select  ={};
    $scope.select={};
    $scope.bindForm= form.bind();


    $scope.$watch("bindForm.estado", function (newVal, oldVall) {


        if(newVal && form.name == 'DetailProductShip'){
            var data = form.getData();
            console.log("data entro", data);
            angular.forEach(data, function (v, k) {
                $scope.prodSelect[k]=v;
            });
            if(data.response){
                if(data.response.accion == 'del' && data.response.cantidad){
                    $scope.prodSelect.saldo = 0;
                    $scope.prodSelect.embarque_item_id = undefined;
                    $scope.prodSelect.asignado = false;
                    $scope.prodSelect.cantidad = data.response.cantidad;
                    $scope.prodSelect.disponible = data.response.cantidad;
                }

            }
            $scope.$parent.reloadDates();
        }
    });

    $scope.$parent.detailOrderShipment = function(data){
        $scope.prodSelect = {};
        $resource.getMod({type:"Order", mod:"Order", id:data.id, doc_id:$scope.$parent.shipment.id},{},function (response) {
            angular.forEach(response, function (v,k) {
                if(k == 'fecha_aprob_gerencia' || k == 'fecha_produccion'){
                    if(v!= null){
                        $scope.select[k] = DateParse.toDate(v);
                    }
                }else
                if(typeof (v) != 'array' ){
                    $scope.select[k]=v;
                }

            });
            $scope.select.prods = [];
            angular.forEach(response.prods, function (v) {
                var aux = {};
                angular.forEach(v, function (v2, k) {
                    if(k == 'minProducion' || k == 'maxProducion'){

                        aux[k] = DateParse.toDate(v2);
                    } else if(k == 'cantidad' || k == 'disponible'){
                        aux[k] = parseFloat(v2);
                    }else{
                        aux[k]= v2;
                    }
                });
                $scope.select.prods.push(aux);
            });
        } );
        $scope.$parent.LayersAction({open:{name:"detailOrder", after: function(){

        }}});
    };
    $scope.open = function (model) {
        if($scope.$parent.shipment.aprob_superior){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y sus articulos no se pueden modificar",[], {autohidden:3500});
        }else{
            form.name = 'DetailProductShip';
            $scope.prodSelect=model;
            var data = {
                embarque_item_id:$scope.prodSelect.embarque_item_id,
                tipo_origen_id:23,
                descripcion:$scope.prodSelect.descripcion,
                origen_item_id:$scope.prodSelect.id,
                producto_id:$scope.prodSelect.producto_id,
                saldo:$scope.prodSelect.saldo,
                codigo_fabrica:$scope.prodSelect.codigo_fabrica,
                disponible:$scope.prodSelect.disponible,
                codigo:$scope.prodSelect.codigo,
                uid:$scope.prodSelect.uid,
                doc_origen_id:$scope.select.id
            };
            $scope.$parent.DetailProductShipment(data);
        }

    }


}]);

MyApp.controller('detailOrderAddCtrl',['$scope','shipment','DateParse','form', '$timeout','setGetShipment',function($scope, $resource,DateParse, form, $timeout , $model){
    $scope.isOpen = false;
    $scope.tbl ={data:[]};
    $scope.prdSelect ={};
    $scope.select={};
    $scope.bindForm= form.bind();
    $scope.calc= undefined;


    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && form.name == 'DetailProductAdd'){
            var data = form.getData();
            console.log(data);
            angular.forEach(data, function (v, k) {
                $scope.prdSelect[k]=v;
            });
            if(data.response){
                if(data.response.accion == 'del' && data.response.cantidad){
                    $scope.prdSelect.saldo = 0;
                    $scope.prdSelect.embarque_item_id = undefined;
                    $scope.prdSelect.cantidad = data.response.cantidad;
                    $scope.prdSelect.disponible = data.response.cantidad;
                }
            }
            if( $scope.calc ){
                $timeout(function () {
                    $resource.getMod({type:"Shipment",mod:"Dates", from:$scope.calc, id: $scope.$parent.shipment.id}, {},function (response) {
                        var send = response;
                        send.id = $scope.$parent.shipment.id;
                        $resource.postMod({type:"Shipment",mod:"SaveDates"}, send,function (response) {
                            $model.setDates(response);
                            $scope.$parent.NotifAction("ok", "Las fechas has sido actualizadas",[], {autohidden:2000});
                        });

                    });
                },500);

            }


        }
    });

    $scope.$parent.detailOrderAdd = function(data){

        $resource.getMod({type:"Order", mod:"Order", id:data.id, doc_id:$scope.$parent.shipment.id},{},function (response) {


            angular.forEach(response, function (v,k) {
                if(k == 'fecha_aprob_gerencia' || k == 'fecha_produccion'){
                    if(v!= null){
                        $scope.select[k] = DateParse.toDate(v);
                    }
                }else
                if(typeof (v) != 'array' ){
                    $scope.select[k]=v;
                }

            });
            $scope.select.prods = [];

            angular.forEach(response.prods, function (v) {
                var aux = {};
                angular.forEach(v, function (v2, k) {
                    if(k == 'minProducion' || k == 'maxProducion'){
                        if(v2!= null){
                            aux[k] = DateParse.toDate(v2);
                        }

                    } else if(k == 'cantidad' || k == 'disponible'){
                        aux[k] = parseFloat(v2);
                    }else{
                        aux[k]= v2;
                    }
                });
                $scope.select.prods.push(aux);

            });
            console.log('order', $scope.select);





        } );
        $scope.$parent.LayersAction({open:{name:"detailOrderAdd"}});

    };

    $scope.openProd = function (model) {
        $scope.calc= undefined;
        if($scope.$parent.shipment.aprob_superior){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y sus articulos no se pueden modificar",[], {autohidden:3500});
        }else{
            if(
                !$scope.$parent.shipment.fechas.fecha_carga.confirm
            ){
                if(!model.asignado && ($scope.$parent.shipment.fechas.fecha_vnz.isManual || $scope.$parent.shipment.fechas.fecha_tienda.isManual || $scope.$parent.shipment.fechas.fecha_carga.isManual  )){

                    if (!model.asignado && model.maxProducion > $scope.$parent.shipment.fechas.fecha_carga.value){
                        $scope.$parent.NotifAction("alert", "Este producto tarda entre "+model.min_dias+" y "+model.max_dias +
                            " dias en fabricarse y no estaria listo para la fecha de carga establecida ¿Que desea hacer?",
                            [
                                {name:"Agregar sin modificar fechas", action:function(){
                                    $scope.setProduct(model);
                                }
                                }
                                ,{name:"Agregar y ajustar fechas", action:function(){
                                $scope.calc = "fecha_carga";
                                $scope.setProduct(model);
                            }
                            },
                                {name:"Cancelar", action:function(){

                                }
                                }

                            ]
                            ,{block:true});
                    }else{
                        $scope.setProduct(model);
                    }
                }else{
                    $scope.setProduct(model);
                }
            }else{

            }
        }



    }

    $scope.setProduct = function(model){
        if($scope.$parent.shipment.aprob_superior){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y sus articulos no se pueden modificar",[], {autohidden:3500});
        }else{
            form.name= 'DetailProductAdd';
            $scope.prdSelect=model;
            var data = {
                embarque_item_id:$scope.prdSelect.embarque_item_id,
                tipo_origen_id:23,
                descripcion:$scope.prdSelect.descripcion,
                origen_item_id:$scope.prdSelect.id,
                producto_id:$scope.prdSelect.producto_id,
                saldo:$scope.prdSelect.saldo,
                codigo_fabrica:$scope.prdSelect.codigo_fabrica,
                disponible:$scope.prdSelect.disponible,
                codigo:$scope.prdSelect.codigo,
                uid:$scope.prdSelect.uid,
                doc_origen_id:$scope.select.id
            };
            $scope.$parent.DetailProductShipment(data);
        }

    }

}]);

MyApp.controller('DetailProductShipmentCtrl',['$scope','$mdSidenav', '$timeout', 'form','shipment','setGetShipment', function($scope,$mdSidenav, $timeout, formSrv, $resource, $model){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.select = {asignado:0};
    $scope.original= {};
    $scope.isUpdate= false;


    $scope.$parent.DetailProductShipment = function(data){
        formSrv.setState("waith");
        formSrv.setBind(false);
        formSrv.getValid = function () {
            return formSrv.getState() == 'waith' &&  $scope.isOpen ;
        }
        $scope.original= angular.copy(data);
        angular.forEach(data, function (v, k) {
            $scope.select[k]=v;
        });
        $mdSidenav("miniDetailProductShipment").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){

        if( $scope.isOpen){

            if(parseFloat($scope.select.saldo) == parseFloat($scope.original.saldo)){ $scope.inClose();}
            else if(parseFloat($scope.select.saldo) == 0){
                if($scope.select.id || $scope.select.embarque_item_id ){
                    formSrv.setState("process");
                    $scope.$parent.NotifAction("error", "Si establece 0 como valor el articulo sera removido ¿Desea continuar ?",[
                        {name: "Si, deseo quitar el articulo" ,
                            action: function () {
                                var send = {id:$scope.select.embarque_item_id};
                                $resource.postMod({type:"OrderItem", mod:"Delete"},send,function (response){
                                    $scope.$parent.NotifAction("ok", "El articulo fue removido",[], {autohidden:1500});
                                    var index = -1;
                                    angular.forEach($scope.$parent.shipment.items,function (v, k) {
                                        if(send.id == v.id){
                                            index = k;
                                            return 0;
                                        }
                                    } );

                                    $scope.$parent.shipment.items.splice(index,1);
                                    $scope.select.response = response;
                                    $scope.select.accion = responce.accion;
                                    $model.change("item"+send.id, 'id',undefined);

                                    if(response.rm_odc){
                                        var index = -1;
                                        angular.forEach($scope.$parent.shipment.odcs,function (v, k) {
                                            if(response.rm_odc == v.id){
                                                index = k;
                                                return 0;
                                            }
                                        } );
                                        if(index != -1){
                                            $model.change("odcs"+response.rm_odc,'id',undefined);
                                            $scope.$parent.shipment.odcs.splice(index,1);
                                        }


                                    }

                                    $timeout(function () {
                                        formSrv.setData(angular.copy($scope.select));
                                        formSrv.setBind(true);
                                        $scope.inClose();
                                        formSrv.setState("continue");
                                    },1500);


                                });


                            }
                        },
                        {name: "No, dejame corregirlo" ,
                            action: function () {
                                formSrv.setState("cancelar");
                                var ele= angular.element("#miniDetailProductShipment #input");
                                ele.click();
                                ele.focus();

                            }
                        },
                        {name: "Cancelar" ,
                            action: function () {
                                $scope.inClose();
                                formSrv.setState("continue");

                            }
                        }

                    ], {block:true});
                }else{

                    $scope.inClose();
                }

            }else
            if(parseFloat($scope.select.saldo) > parseFloat($scope.original.disponible))
            {
                formSrv.setState("process");
                $scope.$parent.NotifAction("alert", "la cantidad indicada excede el disponible ",
                    [
                        {name: "Corregir" ,
                            action: function () {
                                formSrv.setState("cancelar");
                                var ele= angular.element("#miniDetailProductShipment #input");
                                ele.click();
                                ele.focus();
                            }
                        },
                        {name: "Cancelar " ,
                            action: function () {
                                $scope.inClose();
                                formSrv.setState("continue");
                            }
                        }

                    ],{block:true});

            }
            else{
                var send = {
                    id:$scope.select.embarque_item_id,
                    descripcion: $scope.select.descripcion,
                    origen_item_id: ($scope.select.origen_item_id) ? $scope.select.origen_item_id : $scope.select.id,
                    saldo: $scope.select.saldo,
                    tipo_origen_id:($scope.select.tipo_origen_id)? $scope.select.tipo_origen_id : 23,
                    doc_id: $scope.$parent.shipment.id ,
                    doc_origen_id:($scope.select.doc_origen_id) ? $scope.select.doc_origen_id : $scope.select.doc_id,
                    producto_id: $scope.select.producto_id,
                    uid: $scope.select.uid
                };
                $resource.postMod({type:"OrderItem", mod:"Save"},send, function (response) {

                    $scope.$parent.NotifAction("ok", "Articulo atualizado", [], {autohidden:1500});

                    if(response.doc_origen_id){
                        var doc = angular.copy(response.doc_origen_id);
                        doc.asignado= true;
                        $scope.$parent.shipment.odcs.push(doc);
                        $model.change("odcs"+doc.id,undefined, doc);

                    }
                    if(response.accion == 'new'){
                        $scope.$parent.shipment.items.push(response.model);
                        $model.change("item"+response.model.id, undefined,response.model);
                    }else if(response.accion == 'upd'){
                        angular.forEach(response.model, function (v, k) {
                            $model.change("item"+response.model.id, k,v);
                        });
                    }
                    $scope.select.embarque_item_id= response.id;
                    $scope.select.cantidad = response.cantidad;
                    $scope.select.saldo = response.saldo;
                    $scope.select.model = response.model;
                    $scope.select.asignado = true;
                    $scope.select.accion = response.accion;
                    formSrv.setData(angular.copy($scope.select));
                    formSrv.setBind(true);
                    $scope.inClose();
                });
            }
        }
    };

    $scope.inClose = function () {

        $mdSidenav("miniDetailProductShipment").close().then(function(){
            $scope.isOpen = false;
            $scope.select ={};
        });
    };
    $scope.$watchGroup(['prod.$valid','prod.$pristine'], function (newVal) {
        if(!newVal[1] && newVal[0]) {
            formSrv.setData($scope.select);
            formSrv.setState(($scope.original.saldo != $scope.select.saldo) ? 'upd' :'waith');
            $scope.prod.$setPristine();
        }
    });



}]);

MyApp.controller('moduleMsmCtrl',['$scope','$mdSidenav','shipment','setGetShipment',function($scope,$mdSidenav, shipment, $model){
    $scope.isOpen = false;

    $scope.$parent.moduleMsmCtrl = function(){
        $mdSidenav("moduleMsm").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.$watch("$parent.module.index", function(newVal){
        if($scope.isOpen && newVal ){

        }
    });

    $scope.close =  function(){
        if( $scope.isOpen){
            $mdSidenav("moduleMsm").close().then(function(){
                $scope.isOpen = false;
            });
        }
    }
    $scope.openNoti = function(data){
        switch (data.key){
            case "uncloset":
                if(data.cantidad == 1){
                    $scope.$parent.unblock({doc_id:data.data[0].id});
                    $scope.$parent.OpenShipmentCtrl(data.data[0].id);
                    $model.setData({id:data.data[0].id}, function () {
                        $model.change('sistem',undefined,{uncloset:true});
                    });

                    $scope.close();
                }else{
                    $scope.close();
                    $scope.$parent.listUnclosetCtrl();

                }
                break;
        }

    }

    $scope.$watch("$parent.index", function (newVal) {
        if(newVal == 0){
            shipment.query({type:"Notification"}, {}, function(response){$scope.$parent.alerts= response; });
        }
    })


}]);

MyApp.controller('CreatTariffCtrl',['$scope','$mdSidenav','$timeout','form','tarifForm','masters','shipment','fileSrv','setGetShipment',   function($scope,$mdSidenav,$timeout,formSrv,tarifForm,masters ,$resource, fileSrv, $model){
    $scope.isOpen = false;
    $scope.isLoad =false;
    $scope.data ={adjs:[]};
    $scope.form='';
    $scope.model ={};
    $scope.process = false;
    $scope.bindFiles = fileSrv.bin();

    $scope.ff =[];
    $scope.ffSelect =null;
    $scope.ffText = undefined;

    $scope.nv =[];
    $scope.nvSelect =null;
    $scope.nvText = undefined;

    $scope.paisSelec =null;
    $scope.pais_idText =undefined;

    $scope.monedas =[];
    $scope.moneda_idSelect =null;
    $scope.moneda_idText = undefined;

    $scope.puertos =[];
    $scope.puertoSelect =null;
    $scope.puertoText =undefined;
    $scope.mode = 'list';
    $scope.$parent.CreatTariff = function(){
        if($scope.$parent.shipment.aprob_superior && $scope.shipment.tarifa_id){
            $scope.NotifAction("error","Disculpe este embarque ya a sido aprobado y su tarifa no puede ser modificada",[], {autohidden:3500});
        }else{
            $scope.process = false;
            $scope.head.$setPristine();
            $scope.bond.$setPristine();
            $scope.head.$setUntouched();
            $scope.bond.$setUntouched();
            $scope.ffText = undefined;
            $scope.nvText = undefined;
            $scope.moneda_idText = undefined;
            $scope.model.diasd_tt = undefined;
            $scope.model.adjs = [];
            $scope.mode = 'list';
            $scope.upf = false;
            $scope.model.uid = Math.random();

            $mdSidenav("miniCreatTariff").open().then(function(){
                $scope.isOpen = true;
                $timeout(function () {
                    var elem = angular.element("#miniCreatTariff #head");
                    elem[0].click();
                },0);
                formSrv.name = "CreatTariff";
                $scope.loadFF();
                $scope.loadData();
                $scope.loadNv();
            });
        }

    };

    $scope.save = function (fn) {

        if($scope.ffSelect == null){
            $scope.model.ff= $scope.ffText;
        }
        if($scope.nvSelect == null){
            $scope.model.nav= $scope.nvText;
        }
        $resource.postMod({type:"Tariff",mod:"Save"},$scope.model,function (response) {
            $scope.$parent.NotifAction("ok", "Tarifa creada",[],{autohidden:1500});
            tarifForm.set(response.model);
            tarifForm.setState("created");
            if($scope.$parent.shipment.objs.tarifa_id== null){
                $scope.$parent.shipment.objs.tarifa_id ={};
            }

            $scope.$parent.shipment.objs.tarifa_id.freight_forwarder = response.model.objs.freight_forwarder_id;
            $scope.$parent.shipment.objs.tarifa_id.naviera = response.model.objs.naviera_id;
            $scope.$parent.shipment.tarifa_id = response.model.id;
            $scope.$parent.save();
            $scope.inClose();
            $timeout(function () {
                formSrv.setState("continue");$scope.inClose();

            },1500);
            if(fn){
                fn(response);
            }
        });
    }
    $scope.close= function(e){
        if($scope.isOpen && !$scope.process){

            if($scope.head.$pristine && $scope.bond.$pristine &&  !$scope.upf ){
                $scope.inClose();
            }else {
                $scope.process = true;
                formSrv.setState("process");
                if($scope.head.$valid && $scope.bond.$valid ){
                    var msm = [];
                    if($scope.$parent.shipment.pais_id && $scope.$parent.shipment.pais_id != $scope.paisSelec.id){
                        msm.push(" que el pais de la nueva tarifa es diferente al elegido anteriormente ");
                    }
                    if($scope.$parent.shipment.puerto_id && $scope.$parent.shipment.puerto_id != $scope.puertoSelect.id){
                        msm.push(" que el puerto de la nueva tarifa es diferente al elegido anteriormente ");
                    }

                    if(msm.length > 0){
                        var txt = 'Disculpe hemos notado ';
                        angular.forEach(msm, function (v, k) {
                            txt += v;
                            if(k < msm.length -1){
                                txt += 'y '
                            }
                        });
                        txt+="¿ Esta seguro que la informacion en correcta ?";
                        $scope.NotifAction("alert", txt,
                            [{name:"Si",
                                action:function () {
                                    $scope.$parent.shipment.objs.pais_id= angular.copy($scope.paisSelec);
                                    $scope.$parent.shipment.pais_id= $scope.paisSelec.id;
                                    $model.change("tarifa", 'pais_id', $scope.paisSelec.id);
                                    $scope.$parent.shipment.objs.puerto_id= angular.copy($scope.puertoSelect);
                                    $scope.$parent.shipment.puerto_id= $scope.puertoSelect.id;
                                    $model.change("tarifa", 'puerto_id', $scope.puertoSelect.id);
                                    $scope.save();

                                }},
                                {name:"No",
                                    action:function () {
                                        formSrv.setState("cancel");
                                    }}
                            ]
                            ,{block:true})

                    }else{
                        $scope.save();
                    }



                }else {

                    $scope.$parent.NotifAction("alert", "No se puede crear las tarifa con los datos suministrados ¿Que desea hacer?",
                        [
                            {name:"Cancelar la creacion ", default:10,action:
                                function () { formSrv.setState("continue"); $scope.inClose();}

                            },
                            {name:"Corregir", action:function () {
                                $scope.mode = 'list';
                                formSrv.back= function () {

                                    $timeout(function () {
                                        var elem = angular.element("#miniCreatTariff ng-invalid");
                                        console.log("invlaid", elem);
                                        elem[0].focus();
                                        tarifForm.setState("waith");
                                    },0);
                                }
                                formSrv.setState("cancel");
                                $scope.process = false;

                            }}
                        ]
                        ,{block:true});
                }
            }

        }

    };
    $scope.inClose= function () {
        $mdSidenav("miniCreatTariff").close().then(function(){
            $scope.isOpen = false;
        });
    };

    $scope.loadData  = function () {

        masters.query({type:"getCoins"},{}, function (response) {
            $scope.monedas = response;
        });
        $scope.isLoad =true;
    };

    $scope.loadPorts = function(pais){
        if(pais != null && pais && pais.id){
            $resource.queryMod({type:"Country",mod:"Ports",pais_id:pais.id},{},function (response) {
                $scope.puertos =response;
            });
        }else{
            $scope.puertos.splice(0,$scope.puertos.length);
            $scope.puertoSelect =null;
            $scope.puertoText =undefined
        }

    };

    $scope.loadFF = function () {
        if($scope.$parent.shipment.pais_id){
            $resource.queryMod({type:"Freight_Forwarder", mod:"List"},{}, function (response) {
                $scope.ff= response;
            });
        }
    };
    $scope.loadNv = function () {
        if($scope.$parent.shipment.pais_id){
            $resource.queryMod({type:"Naviera", mod:"List", ff_id:($scope.ffSelect)== null ? undefined: $scope.ffSelect.id},{}, function (response) {
                $scope.nv= response;
            });
        }

    };


    $scope.$watch('$parent.shipment.objs.pais_id', function(newVal){
        $scope.paisSelec=newVal;

    });
    $scope.$watch('$parent.shipment.objs.puerto_id', function(newVal){
        $scope.puertoSelect=newVal;

    });


    $scope.$watch('puertoSelect', function(newVal){
        if(newVal && !$scope.head.$pristine){

        }
    });

    // files
    $scope.fileUp= function (file) {
        $scope.upf = true;

        $resource.postMod({type:"Tariff", mod:"Attachment"},{archivo_id:file.id, uid:  $scope.model.uid}, function (response) {

        }, function (error) {

        });

    };
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage("shipments");
            fileSrv.setKey("miniHblCtrl");
            angular.forEach(fileSrv.upload($scope.files), function (v, k) {

                $scope.model.adjs.push(v);
            });
        }
    });

    $scope.$watch('bindFiles.estado', function (newVal) {
        if(fileSrv.getKey() == 'miniHblCtrl'){
            console.log("newVall");
            var result = angular.copy(fileSrv.get());
            if(newVal == 'finish'){
                var texto = '';
                //{succeces:[], error:[], total:[],upload:{}};
                if(result.succeces.length > 0){
                    texto += " Se agregaron "+result.succeces.length +" archivos";
                }
                if(result.error.length > 0){
                    texto += " fallaron "+result.error.length +" archivos";
                }                if(result.total.length > 0){
                    texto += " de  "+result.total.length +" ";
                }
                if(texto.length > 1){
                    $scope.$parent.NotifAction("ok", texto, [],{autohidden:4000})
                }

            }
        }
    });




}]);
/*************************  MODULO DE mail *******************************/
MyApp.controller('sendShipmentCtrl',['$scope','$timeout','$sce','Layers','vlResource',function($scope,$timeout, $sce,Layers,$resource){

    $scope.origenes = {};
    $scope.$parent.sendShipment = function () {
        Layers.setAccion({open:{name:'mailDemo'}});
        $scope.centerText ='Cargando recursos por favor espere ';

    };
    $scope.origenes = {1:{
        lang:'Español',
        iso_lang:'es-es',
        body:"<div>hola mundo</div>"

    }};
    $scope.centerText ='';
    $scope.options = {
        titulo:
        {
            change: function (e) {
                //   e.preventDefault();
            }
        }};

}]) ;



/*************************  MODULO DE CERRADO DE EMBARQUE *******************************/

MyApp.controller('detailShipmentFinalizeCtrl', ['$scope', '$timeout','shipment','DateParse','setGetShipment',function($scope,$timeout ,$resource,DateParse,$model){

    $scope.$parent.detailShipmentFinalize = function (data) {
        $scope.model = {};
        $resource.get({type:"Shipment", mod:"End", id:data.id},{}, function (response) {

            angular.forEach(response, function (v, k) {
                if(typeof v != 'array' && typeof v != 'object' ||  typeof v == 'string' ||  typeof v == 'number'){
                    $scope.model[k]= v;
                }
                $scope.model.fecha_tienda = DateParse.toDate( $scope.model.fecha_tienda);
                $scope.model.items = response.items;
                $scope.model.provider = response.provider;
            });
        });

        $scope.$parent.LayersAction({open:{name:"detailShipmentFinalize"}});
    }

    $scope.open= function (item) {

    }

    $scope.chequeado = function(value){
        return 'Sin decidir'
    }
    $scope.calida = function(value){
        return 'Sin revisar'
    }
    $scope.exhibicion = function(value){
        return 'Sin decidir'
    }

}]);


MyApp.controller('listShipmentFinalizeCtrl', ['$scope','shipment','setGetShipment',  function ($scope,$resource, setGetShipment) {
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };

    $scope.select ={};
    $scope.load = function (data) {
        $scope.tbl.data.splice(0, $scope.tbl.data.length);
        var send = {type:"Shipments", mod:"Finalize" };
        angular.forEach(data, function (v, k) {
            send[k]= v;
        });
        // console.log("send ", send);
        $resource.query(send,{}, function (response) {
            angular.forEach(response, function (v, k) {
                $scope.tbl.data.push(v);
            })
        })
    };

    $scope.$parent.listShipmentFinish = function(data, fn){
        $scope.LayersAction({search:{name:"listShipmentFinalize", after: function () {
            $scope.load(data);
            if(fn){
                fn();
            }
        }}});
    };
    $scope.setData = function (data){
        $scope.select=data;
        $scope.$parent.detailShipmentFinalize(data);
    }
}]);
/*************************  MODULO DE TARIFA *******************************/

MyApp.controller('miniTariffItemsCtrl',['$scope','$mdSidenav','$timeout','form','masters', 'shipment', function($scope,$mdSidenav,$timeout,formSrv,masters ,$resource){
    $scope.isOpen = false;
    $scope.model= {};
    $scope.monedas =[];
    $scope.moneda_idSelect =null;
    $scope.moneda_idText = undefined;
    $scope.puertos =[];
    $scope.puertoSelect =null;
    $scope.puertoText =undefined;
    masters.query({type:"getCoins"},{}, function (response) {
        $scope.monedas = response;
    });

    $scope.$parent.miniTariffItems = function(doc, itemplus){
        $scope.doc= doc;
        $scope.plus= itemplus;
        $scope.form = 'head';
        $mdSidenav("miniTariffItems").open().then(function(){
            $scope.isOpen = true;
        });
        angular.forEach($scope.model,function (v, k) {
            $scope.model[k]= undefined;
        });
        $scope.model= {};
        $scope.loadNv();

    };
    $scope.loadPorts = function(pais){
        if(pais != null && pais && pais.id){
            $resource.queryMod({type:"Country",mod:"Ports",pais_id:pais.id},{},function (response) {
                $scope.puertos =response;
            });
        }else{
            $scope.puertos.splice(0,$scope.puertos.length);
            $scope.puertoSelect =null;
            $scope.puertoText =undefined
        }

    };

    $scope.loadNv = function () {
            $resource.queryMod({type:"Naviera", mod:"List"},{}, function (response) {
                $scope.nv= response;
            });


    };

    $scope.close= function(e){
        var save = function () {

            $scope.save(function () {
                $scope.NotifAction("ok"," !Felicidades! la tarifa se a cargado satisfactoriamente ¿Desea agregar otra?",
                [{name:"Si, no quites lo que llene", default:5, accion:function () {

                }},
                    {name:"Si,pero quitame lo que llene ", accion:function () {
                        angular.forEach($scope.model,function (v, k) {
                            $scope.model[k]= undefined;
                        });
                        $scope.model= {};
                        $timeout(function () {
                          var el = angular.element("miniTariffItems [step]").first();
                            console.log("ele", el);
                            el.focus();
                        },0);
                    }},
                    {name:"No, ya he terminado", accion:function () {
                            $scope.inClose();
                    }}

                ]
                ,{block:true});
            });

        };
        if($scope.isOpen){
            formSrv.setState("waith");
            if($scope.head.$pristine && $scope.bond.$pristine &&  !$scope.upf ){
                $scope.inClose();
            }else {
                formSrv.setState('process');
                if(!$scope.head.$valid || !$scope.bond.$valid){
                    $scope.NotifAction("error", "¡Colocaste muy poco!, No se colaste suficientes datos com para crear una tarifa",[
                        {name:"Corregir", action:function () {
                            formSrv.setState('cancel');
                            $timeout(function () {
                                var el = angular.element("miniTariffItems [step]").first();
                                console.log("ele", el);
                                el.focus();
                            },0);
                        }},{name:"Cancelar", action:function () {
                            $scope.inClose();
                            formSrv.setState('continue');
                        }}
                        ]);
                }else{
                    save();

                }
            }

        }
    };

    $scope.inClose= function () {
        $mdSidenav("miniTariffItems").close().then(function(){
            $scope.isOpen = false;
        });
    };

    $scope.save = function (fn) {
        $scope.head.$setPristine();
        $scope.bond.$setPristine();
        $scope.head.$setUntouched();
        $scope.bond.$setUntouched();
        $scope.model.freight_forwarder_id = angular.copy($scope.doc.freight_forwarder_id);
        $scope.model.doc_id = angular.copy($scope.doc.id);
        $resource.post({type:"TariffDocItem", mod:'Save'}, $scope.model, function (response) {
            if(fn){
                fn();
            }
            $scope.plus(response);

        });
    }
}]);

MyApp.controller('listGlobalTarifCtrl',['$scope','DateParse','shipment',  function ($scope,DateParse,$resource) {
    $scope.tbl = {order:'id', data:[]};

    $scope.$parent.listGlobalTarif = function (fn) {
        $scope.tbl = {order:'id', data:[]};
        $scope.select = {};
        $resource.query({type:"TariffDocs"},{}, function (response) {
            $scope.tbl.data.splice(0, $scope.tbl.data.length);
            angular.forEach(response, function (v,k) {
                v.created_at = DateParse.toDate(v.created_at);
                $scope.tbl.data.push(v);
            });

       });
        $scope.$parent.LayersAction({open:{name:"listGlobalTarif"}});
    }

    $scope.setData = function (data) {
        $scope.$parent.detailGlobalTarif(angular.copy(data));
    }
}])

MyApp.controller('detailGlobalTarifCtrl',['$scope','$timeout','shipment','form',  function ($scope,$timeout,$resource,formSrv) {
    $scope.tbl = {order:'id', data:[]};
    $scope.model ={};
    $scope.sesion = {};
    $scope.bindForm = formSrv.bind();
    $scope.model ={};
    $resource.queryMod({type:"Freight_Forwarder", mod:"List"},{}, function (response) {
        $scope.ff= response;
    });

    $scope.$parent.detailGlobalTarif = function (data) {

        if(data){
            $scope.sesion.mod='upd';
            $resource.get({type:"TariffDoc",id:data.id},{}, function (response) {
                angular.forEach(response, function (v, k) {
                    if(typeof v != 'array' && typeof v != 'object' ||  typeof v == 'string' ||  typeof v == 'number'){
                        $scope.model[k]= v;
                    }

                });
                $scope.tbl.data = response.items;
                $scope.model.adjs= response.adjs;
                if($scope.tbl.data.length > 0){
                    $scope.ffSelect= $scope.tbl.data[0].objs.freight_forwarder_id;
                }
            });
        }else{
            $scope.ffText= undefined;
            $scope.model= {adjs:[], item:[]};
            $scope.tbl.data =[];
            $scope.save()
        }

        $scope.$parent.LayersAction({open:{name:"detailGlobalTarif"}});
    }

    $scope.openSideItem = function (fn) {
        if(fn){
            fn();
        }
        $scope.$parent.miniTariffItems($scope.model,  $scope.itemUp);
    };

    $scope.fileUp = function (file) {
        $scope.upd= true;
        $resource.postMod({type:"Tariff", mod:"Attachment"},{archivo_id:file.id, doc_id:  $scope.model.id}, function (response) {
            $scope.model.adjs.push(response.model);
        });
    };

    $scope.finish = function (newVal, oldVal, result) {

        if(newVal == 'finish'){
            var index = 1;
            if(result.succeces.length > 0){
                index++;
                $scope.$parent.NotifAction("ok", 'Se agregaron '+result.succeces.length +' de '+result.total.length, [],{autohidden:2000})
            }
            if(result.error.length > 0){
                $timeout(function () {
                    $scope.$parent.NotifAction("error", 'fallaron '+result.succeces.length +' de '+result.total.length, [],{autohidden:2000})
                },2000 * index)

            }

        }

    };

    $scope.itemUp = function (response) {
        $scope.tbl.data.push(response.model);
    };

    $scope.openAdjs = function () {
        $scope.$parent.miniAdjs('shipments', $scope.model.adjs,$scope.fileUp, $scope.finish);
    };

    $scope.openItems = function () {
        if(!$scope.ffSelect){
            if($scope.ffText){
                $scope.NotifAction("alert","¡Tienes que colocar un Freight Forwarder! o ¿Quieres crear el Freight Forwarder " +$scope.ffText +" ?",
                    [
                        {name:"Crear "+$scope.ffText, action:function () {
                            $scope.createdFreightForwarder(function () {
                                $scope.openSideItem();
                            });

                        }},
                        {name:"Cancelar ", action:function () { }}
                    ]
                    ,{});

            }else{
                $scope.NotifAction("error","Tienes que colocar un Freight Forwarder ",[],{autohidden:2500});
            }

        }else{
            $scope.openSideItem();
        }

    };

    $scope.createdFreightForwarder = function (fn) {
        $resource.post({type:"TariffDoc",mod:"Save"},{nombre:$scope.ffText, oo:'dadfs'}, function (response) {
            $scope.ffSelect = response;
            $scope.ff.push(response);
            if(fn){
                fn(response);
            }

        });
    };

    $scope.save = function (fn) {
        $resource.post({type:"TariffDoc",mod:'Save'}, $scope.model, function (response) {
            $scope.model.embarques =  response.embarques;
            $scope.model.id =  response.id;
            if(fn){
                fn(response);
            }
        });
    };

    $scope.delete = function (item, index) {

        if(item.embarques > 0){
           $scope.NotifAction("error", "Lo sentimos no puedes eliminar tarifa que esten siendo usadas en un embarque. ",[], {autohidden:3000});
        }else{
            $scope.NotifAction("alert", "Por favor confirmanos que en realidad quieres eliminar esta tarifa",
                [
                    {name:"Si, deseo eliminarla", action: function () {
                        $scope.del(item, index);
                    }},
                    {name:"Cancelar", action: function () {

                    }}
                ]
                , {block:true,save:{doc_origen_id:$scope.model.id, tipo_origen_id:25}});
        }
    };

    $scope.del = function (item,index) {
        $resource.post({type:"TariffDocItem", mod:"Delete"},{id:item.id}, function (response) {
            $scope.tbl.data.splice(index,1);
        });
    }

    $scope.$watchGroup(['head.$valid', 'head.$pristine'], function(newVal){
        if(!newVal[1]){
            $scope.save(function (head) {
                $scope.head.$setPristine();
            });


        }
    });

    $scope.$watch("bindForm.estado", function (newVal, oldVall) {
        if(newVal && formSrv.name == 'detailGlobalTarifCtrl'){
            var data = formSrv.getData();
            console.log("dasfasdf", data);

        }
    });
}]);

MyApp.controller('miniAdjsCtrl',['$scope','$mdSidenav','$timeout','form','tarifForm','masters','shipment','fileSrv','setGetShipment',   function($scope,$mdSidenav,$timeout,formSrv,tarifForm,masters ,$resource, fileSrv, $model){
    $scope.isOpen = false;
    $scope.bindFiles = fileSrv.bin();

    $scope.$parent.miniAdjs = function(storage,adjs,fileUp, finish){
        $scope.fileUp = fileUp;
        $scope.finish = finish;
        $scope.storage = storage;
        $scope.model = {adjs:[]};
        angular.forEach(adjs, function (v, k) {
            $scope.model.adjs.push(v);
        });
        $mdSidenav("miniAdjs").open().then(function(){
            $scope.isOpen= true;
        });
    };

    $scope.save = function (fn) {  };
    $scope.close= function(e){
        if($scope.isOpen){ $scope.inClose(); }
    };
    $scope.inClose= function () {
        $mdSidenav("miniAdjs").close().then(function(){
            $scope.isOpen = false;
        });
    };
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            fileSrv.storage($scope.storage);
            fileSrv.setKey('miniAdjsCtrl');
            angular.forEach(fileSrv.upload($scope.files), function (v, k) {
                $scope.model.adjs.push(v);
            });
        }
    });

    $scope.$watch('bindFiles.estado', function (newVal,oldVal) {
        if(fileSrv.getKey() == 'miniAdjsCtrl'){
            $scope.finish(newVal,oldVal, fileSrv.get());
        }
    });




}]);


/******************************************/


MyApp.factory('shipment', ['$resource',
    function ($resource) {
        return $resource('embarques/:type/:mod', {}, {
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

MyApp.service('tarifForm',function(){
    var tarifa ={
        model:{},
        bind:{estado:"waith"}
    }
    return{
        bind: function () {
            return tarifa.bind;
        },
        set: function (data) {
            tarifa.model=data;
        },
        get: function () {
            return tarifa.model;
        },
        setState: function (data) {
            console.log("new estat serv", data);
            tarifa.bind.estado=data;
        }
    }
});

MyApp.service('ContainerForm',function(){
    var dat ={
        model:{},
        bind:{estado:"waith"}
    }
    return{
        bind: function () {
            return dat.bind;
        },
        set: function (data) {
            dat.model=data;
        },
        get: function () {
            return dat.model;
        },
        setState: function (data) {
            console.log("new estat serv", data);
            dat.bind.estado=data;
        }
    }
});

/**prototipe built**/
MyApp.service('form',function(){
    var name= "none";
    var state = "waith";
    var back = function () {};
    var doc ={};
    var bind = {estado:false};

    return {
        name:name,
        bind: function () {
            return bind;
        },
        setBind:function (data) {
            bind.estado= data;
        },
        getValid:function () {
            return false;
        },
        setState: function (data) {
            state= data;
        },
        getState:function () {
            return state;
        },
        setData : function (data) {
            doc = data;
        },
        getData : function () {
            return doc;
        },
        back:back,
        clear:function () {
            name="none";

            state="waith";
        }
    }
});

/*
 Servicio que almacena la informacion del embarque
 */

MyApp.service('setGetShipment', function(DateParse, shipment) {

    var forms ={};
    var interno= 'new';
    var externo= 'new';
    var Shipment={};
    var next = undefined;
    var bindin ={estado:false};
    var progress ={index:0,
        data:[
            {index:1, st:'false', text:
            {
                true:'Felicidades se han llenado los minimos datos para la aprobacion',
                false:'Disculpa aun no has llenado los datos minimos para solicitar la aprobacion',
                'this':'Estamos esperando la aprobacion de este embarque'
            }
            },
            {index:2, st:'false' ,text:
            {
                true:'¡EL embarque ya fue aprobado!',
                false:'¡Aun no se ha aprobado el embarque!',
                'this':'Estamos esperando el cumplimiento de la fecha de carga'
            }
            },
            {index:3, st:'false' ,        text:
            {
                true:'Ya se cargo el embarque',
                false:'Aun no se ha empezado ha cargar el embarque',
                'this':'En espera de la llegada a venezuela'
            }
            },
            {index:4, st:'false', text:
            {
                true:'Ya esta en Venezuela',
                false:'Aun no ha llegado a Venezuela',
                'this':'Esperando la llegada a la tienda'
            }
            },
            {index:5, st:'false',text:
            {
                true:'Ya esta en la tienda',
                false:'Aun no ha llegado a la tienda',
                'this':'Finalizado, Por favor confirmar recepcion'
            }
            }
        ]};;

    var change = function(form,fiel, value){

        var exist= true;

        if(!forms[form]){
            forms[form]={};
            exist=false;
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
            interno='upd';

        };

        if( exist){
            if(typeof (value) == 'undefined'){
                console.log("eliminar ", forms[form][fiel]);
                forms[form][fiel].estado='del';
                forms[form][fiel].trace.push();
            }else if(forms[form][fiel].original != value  ){
                forms[form][fiel].v= value;
                forms[form][fiel].trace.push(value);
                forms[form][fiel].estado='upd';
                interno='upd';

            }else
            if(forms[form][fiel].original == value ){
                if(forms[form][fiel].estado = 'upd'){
                    forms[form][fiel].estado='new';
                }

                forms[form][fiel].trace.push(value);
                forms[form][fiel].v= value;
                var band= "new";
                if(interno != 'new'){
                    angular.forEach(forms[form], function(v){
                        angular.forEach(v, function(v2){
                            if(v2.estado != 'new' ){
                                band='upd'
                            }
                        });
                    });
                    interno=band;
                }

            }
        }



    };
    var progresso = function () {
        var index = 0;
        if(
            !(Shipment.prov_id &&
            Shipment.pais_id &&
            Shipment.puerto_id &&
            Shipment.tarifa_id &&
            Shipment.fechas.fecha_carga.value &&
            Shipment.fechas.fecha_vnz.value &&
            Shipment.fechas.fecha_tienda.value &&
            Shipment.flete_maritimo &&
            Shipment.items.length > 0)
        ){

            return index ;
        }else{
            index = 0;
            if(Shipment.aprob_superior){
                index = 1;
                if(Shipment.fechas.fecha_carga.value <= new Date() && Shipment.fechas.fecha_carga.confirm){
                    index  = 2;
                    if(Shipment.fechas.fecha_carga.value == new Date()){
                        return index;
                    }

                }
                if(Shipment.fechas.fecha_vnz.value <= new Date()&& Shipment.fechas.fecha_vnz.confirm){
                    index  = 3;
                    if(Shipment.fechas.fecha_vnz.value == new Date()){
                        return index;
                    }

                }
                if(Shipment.fechas.fecha_tienda.value <= new Date()&& Shipment.fechas.fecha_tienda.confirm){
                    index  = 4;
                    if(Shipment.fechas.fecha_tienda.value == new Date()){
                        return index;
                    }

                }
            }
        }
        return index;
    };
    return {

        timeline : function () {
            return progress;
        },
        timelineUpdate: function () {
            progress.index = progresso();
        },
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
            Shipment ={};
        },
        setState : function(val){
            externo= val;
        },
        getState: function(){
            return externo;
        },
        getInternalState: function(){
            return interno;
        }        ,
        setData : function(doc,fn){
            bindin.estado = false;

            shipment.get({type:"Shipment", id:doc.id},{}, function (response) {
                forms['document'] = {};
                forms['tarifa'] = {};
                angular.forEach(response,function (v, k) {
                    if((typeof (v) != 'object' && typeof (v) != 'array' )|| v == null){
                        Shipment[k]=v;
                    }
                    if(v !=null && typeof (v) != 'object' && typeof (v) != 'array' && !angular.isNumber(k)){
                        if(k == 'puerto_id' || k == 'pais_id'){

                        }else{
                            forms['document'][k]={original:v, v:v, estado:'new',trace:[]};
                        }

                    }
                });
                Shipment.criterios= response.criterios;
                Shipment.objs= {};
                angular.forEach(response.objs,function (v, k) {
                    Shipment.objs[k]=v;
                });
                Shipment.permit ={};
                angular.forEach(response.permit,function (v, k){
                    Shipment.permit[k]=v;
                });
                forms['fecha_carga'] = {};
                forms['fecha_tienda'] = {};
                forms['fecha_vnz'] = {};
                if(response.fechas){
                    Shipment.fechas= {fecha_carga:{}, fecha_tienda:{},fecha_vnz:{}};
                    if(response.fechas.fecha_carga.value){
                        Shipment.fechas.fecha_carga={};
                        Shipment.fechas.fecha_carga.confirm=response.fechas.fecha_carga.confirm;
                        Shipment.fechas.fecha_carga.isManual=response.fechas.fecha_carga.isManual;
                        Shipment.fechas.fecha_carga.value = DateParse.toDate(response.fechas.fecha_carga.value);
                        Shipment.fechas.fecha_carga.max = (response.fechas.fecha_carga.max) ? DateParse.toDate(response.fechas.fecha_carga.max) : undefined;
                        Shipment.fechas.fecha_carga.plus = DateParse.plusDays(Shipment.fechas.fecha_carga.value,2);
                        forms['fecha_carga']['confirm']={original:Shipment.fechas.fecha_carga.confirm, v:Shipment.fechas.fecha_carga.confirm, estado:'new',trace:[]};
                        forms['fecha_carga']['isManual']={original:Shipment.fechas.fecha_carga.isManual, v:Shipment.fechas.fecha_carga.isManual, estado:'new',trace:[]};
                        forms['fecha_carga']['value']={original:Shipment.fechas.fecha_carga.value, v:Shipment.fechas.fecha_carga.value, estado:'new',trace:[]};
                    }
                    if(response.fechas.fecha_tienda.value){
                        Shipment.fechas.fecha_tienda={};
                        Shipment.fechas.fecha_tienda.confirm=response.fechas.fecha_tienda.confirm;
                        Shipment.fechas.fecha_tienda.isManual=response.fechas.fecha_tienda.isManual;
                        Shipment.fechas.fecha_tienda.value = DateParse.toDate(response.fechas.fecha_tienda.value);
                        Shipment.fechas.fecha_tienda.max = (response.fechas.fecha_tienda.max) ? DateParse.toDate(response.fechas.fecha_tienda.max) : undefined;
                        Shipment.fechas.fecha_tienda.plus = DateParse.plusDays(Shipment.fechas.fecha_tienda.value,2);
                        forms['fecha_tienda']['confirm']={original:Shipment.fechas.fecha_tienda.confirm, v:Shipment.fechas.fecha_tienda.confirm, estado:'new',trace:[]};
                        forms['fecha_tienda']['isManual']={original:Shipment.fechas.fecha_tienda.isManual, v:Shipment.fechas.fecha_tienda.isManual, estado:'new',trace:[]};
                        forms['fecha_tienda']['value']={original:Shipment.fechas.fecha_tienda.value, v:Shipment.fechas.fecha_tienda.value, estado:'new',trace:[]};
                    }

                    if(response.fechas.fecha_vnz.value){
                        Shipment.fechas.fecha_vnz={};
                        Shipment.fechas.fecha_vnz.confirm=response.fechas.fecha_vnz.confirm;
                        Shipment.fechas.fecha_vnz.isManual=response.fechas.fecha_vnz.isManual;
                        Shipment.fechas.fecha_vnz.value = DateParse.toDate(response.fechas.fecha_vnz.value);
                        Shipment.fechas.fecha_vnz.max = (response.fechas.fecha_vnz.max) ? DateParse.toDate(response.fechas.fecha_vnz.max) : undefined;
                        Shipment.fechas.fecha_vnz.plus = DateParse.plusDays(Shipment.fechas.fecha_vnz.value,2);

                        forms['fecha_vnz']['confirm']={original:Shipment.fechas.fecha_vnz.confirm, v:Shipment.fechas.fecha_vnz.confirm, estado:'new',trace:[]};
                        forms['fecha_vnz']['isManual']={original:Shipment.fechas.fecha_vnz.isManual, v:Shipment.fechas.fecha_vnz.isManual, estado:'new',trace:[]};
                        forms['fecha_vnz']['value']={original:Shipment.fechas.fecha_vnz.value, v:Shipment.fechas.fecha_vnz.value, estado:'new',trace:[]};
                    }
                }

                Shipment.emision = (response.emision!= null) ? DateParse.toDate(response.emision) : null;
                Shipment.containers =[];
                angular.forEach( response.containers, function (v) {
                    Shipment.containers.push(v);
                    forms['container'+v.id];
                    angular.forEach( v, function (v2, k) {
                        if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                            if(!forms['container'+ v.id]){
                                forms['container'+ v.id] ={};
                            }
                            forms['container'+ v.id][k]={original:v2, v:v2, estado:'new',trace:[]};
                        }
                    })
                });


                Shipment.odcs =[];
                angular.forEach( response.odcs, function (v) {
                    Shipment.odcs.push(v);
                    forms['odcs'+v.id];
                    angular.forEach( v, function (v2, k) {
                        if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                            if(!forms['odcs'+ v.id]){
                                forms['odcs'+ v.id] ={};
                            }
                            forms['odcs'+ v.id][k]={original:v2, v:v2, estado:'new',trace:[]};
                        }
                    })
                });
                //Shipment.containers = response.containers;
                //Shipment.odcs = response.odcs;

                Shipment.items =[];
                angular.forEach( response.items, function (v) {
                    Shipment.items.push(v);
                    forms['item'+v.id];
                    angular.forEach( v, function (v2, k) {
                        if(v2!=null && typeof (v2) != 'object' && typeof (v2) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
                            if(!forms['item'+ v.id]){
                                forms['item'+ v.id] ={};
                            }
                            forms['item'+ v.id][k]={original:v2, v:v2, estado:'new',trace:[]};
                        }
                    })
                });
                Shipment.nro_mbl = {
                    adjs:response.nro_mbl.adjs,
                    documento: response.nro_mbl.documento,
                    emision:(response.nro_mbl.emision== null)? undefined: DateParse.toDate(response.nro_mbl.emision)
                } ;
                forms['nro_mbl'] = {};
                if(Shipment.nro_mbl.documento){
                    forms['nro_mbl']['documento']={original:Shipment.nro_mbl.documento, v:Shipment.nro_mbl.documento, estado:'new',trace:[]};
                }
                if(Shipment.nro_mbl.emision){
                    forms['nro_mbl']['emision']={original:Shipment.nro_mbl.emision.toString(), v:Shipment.nro_mbl.emision.toString(), estado:'new',trace:[]};
                }
                Shipment.nro_hbl = {
                    adjs:response.nro_hbl.adjs,
                    documento: response.nro_hbl.documento,
                    emision:(response.nro_hbl.emision== null)? undefined: DateParse.toDate(response.nro_hbl.emision)
                } ;

                forms['nro_hbl'] = {};
                if(Shipment.nro_hbl.documento){
                    forms['nro_hbl']['documento']={original:Shipment.nro_hbl.documento, v:Shipment.nro_hbl.documento, estado:'new',trace:[]};
                }
                if(Shipment.nro_hbl.emision){
                    forms['nro_hbl']['emision']={original:Shipment.nro_hbl.emision.toString(), v:Shipment.nro_hbl.emision.toString(), estado:'new',trace:[]};
                }
                Shipment.nro_eaa = {
                    adjs:response.nro_eaa.adjs,
                    documento: response.nro_eaa.documento,
                    emision:(response.nro_eaa.emision== null)? undefined: DateParse.toDate(response.nro_eaa.emision)
                } ;
                forms['nro_eaa'] = {};
                if(Shipment.nro_eaa.documento){
                    forms['nro_eaa']['documento']={original:Shipment.nro_eaa.documento, v:Shipment.nro_eaa.documento, estado:'new',trace:[]};
                }
                if(Shipment.nro_eaa.emision){
                    forms['nro_eaa']['emision']={original:Shipment.nro_eaa.emision.toString(), v:Shipment.nro_eaa.emision.toString(), estado:'new',trace:[]};
                }

                bindin.estado = true;

                if(fn){
                    fn(this);
                }
                console.log("in data ",Shipment );

            });



        },
        setDates : function (fechas) {
            var  plus = 2;
            Shipment.fechas= {};
            Shipment.fechas= {fecha_carga:{}, fecha_tienda:{},fecha_vnz:{}};
            if(fechas.fecha_carga.value){
                Shipment.fechas.fecha_carga={};
                Shipment.fechas.fecha_carga.confirm=fechas.fecha_carga.confirm;
                Shipment.fechas.fecha_carga.isManual=fechas.fecha_carga.isManual;
                Shipment.fechas.fecha_carga.value = DateParse.toDate(fechas.fecha_carga.value);
                Shipment.fechas.fecha_carga.max = (fechas.fecha_carga.max) ? DateParse.toDate(fechas.fecha_carga.max) : undefined;
                Shipment.fechas.fecha_carga.plus =  new Date(Shipment.fechas.fecha_carga.value.getFullYear(),
                    Shipment.fechas.fecha_carga.value.getMonth(),
                    Shipment.fechas.fecha_carga.value.getDate()+ plus,
                    Shipment.fechas.fecha_carga.value.getHours(),
                    Shipment.fechas.fecha_carga.value.getMinutes(),
                    Shipment.fechas.fecha_carga.value.getSeconds()
                );
                change('fecha_carga','confirm',Shipment.fechas.fecha_carga.confirm);
                change('fecha_carga','isManual',Shipment.fechas.fecha_carga.isManual);
                change('fecha_carga','value',Shipment.fechas.fecha_carga.value.toString());
            }
            if(fechas.fecha_tienda.value){
                Shipment.fechas.fecha_tienda={};
                Shipment.fechas.fecha_tienda.confirm=fechas.fecha_tienda.confirm;
                Shipment.fechas.fecha_tienda.isManual=fechas.fecha_tienda.isManual;
                Shipment.fechas.fecha_tienda.value = DateParse.toDate(fechas.fecha_tienda.value);
                Shipment.fechas.fecha_tienda.max = (fechas.fecha_tienda.max) ? DateParse.toDate(fechas.fecha_tienda.max) : undefined;

                Shipment.fechas.fecha_tienda.plus  =  new Date(Shipment.fechas.fecha_tienda.value.getFullYear(),
                    Shipment.fechas.fecha_tienda.value.getMonth(),
                    Shipment.fechas.fecha_tienda.value.getDate()+ plus,
                    Shipment.fechas.fecha_tienda.value.getHours(),
                    Shipment.fechas.fecha_tienda.value.getMinutes(),
                    Shipment.fechas.fecha_tienda.value.getSeconds()
                );
                change('fecha_tienda','confirm',Shipment.fechas.fecha_tienda.confirm);
                change('fecha_tienda','isManual',Shipment.fechas.fecha_tienda.isManual);
                change('fecha_tienda','value',Shipment.fechas.fecha_tienda.value.toString());
            }
            if(fechas.fecha_vnz.value){
                Shipment.fechas.fecha_vnz={};
                Shipment.fechas.fecha_vnz.confirm=fechas.fecha_vnz.confirm;
                Shipment.fechas.fecha_vnz.isManual=fechas.fecha_vnz.isManual;
                Shipment.fechas.fecha_vnz.value = DateParse.toDate(fechas.fecha_vnz.value);
                Shipment.fechas.fecha_vnz.max = (fechas.fecha_vnz.max) ? DateParse.toDate(fechas.fecha_vnz.max) : undefined;
                Shipment.fechas.fecha_vnz.plus  =  new Date(Shipment.fechas.fecha_tienda.value.getFullYear(),
                    Shipment.fechas.fecha_vnz.value.getMonth(),
                    Shipment.fechas.fecha_vnz.value.getDate()+ plus,
                    Shipment.fechas.fecha_vnz.value.getHours(),
                    Shipment.fechas.fecha_vnz.value.getMinutes(),
                    Shipment.fechas.fecha_vnz.value.getSeconds()
                );
                change('fecha_vnz','confirm',Shipment.fechas.fecha_vnz.confirm);
                change('fecha_vnz','isManual',Shipment.fechas.fecha_vnz.isManual);
                change('fecha_vnz','value',Shipment.fechas.fecha_vnz.value.toString());
            }
            progress.index = progresso();
            console.log(" progress.index", progress.index);

        },
        reloadItems : function () {
            shipment.queryMod({type:"Shipment", mod:"Items" ,id:Shipment.id},{}, function (response) {
                Shipment.items.splice(0, Shipment.items.length);
                angular.forEach(response, function (v) {
                    Shipment.items.push(v);
                })
            });
        },
        reload: function(doc){
            bindin.estado=false;
            bindin.estado=true;
        },
        getData : function(){
            return Shipment;
        },
        clear: function(){
            bindin.estado = false;
            bindin.estado=false;
            Shipment.nro_eaa={};
            Shipment.nro_eaa.documento = undefined;
            Shipment.nro_eaa.emision =undefined;
            Shipment.nro_hbl={};
            Shipment.nro_hbl.documento = undefined;
            Shipment.nro_hbl.emision =undefined;
            Shipment.nro_hbl.emision =undefined;
            Shipment.nro_mbl={};
            Shipment.nro_mbl.documento = undefined;
            Shipment.nro_mbl.emision =undefined;
            Shipment.nro_mbl.emision =undefined;
            Shipment.items = [];
            Shipment.odcs = [];
            Shipment.containers = [];
            Shipment.emision = undefined;
            Shipment.fechas= {};
            Shipment.fechas.fecha_vnz = {};
            Shipment.fechas.fecha_tienda = {};
            Shipment.fechas.fecha_carga = {};

            if(Shipment.objs){
                angular.forEach(Shipment.objs,function (v, k) {
                    Shipment.objs[k]=undefined;
                });
            }
            angular.forEach(Shipment,function (v, k) {
                if(typeof v !='array' && typeof v !='object' || typeof v =='string'){
                    Shipment[k]= undefined;
                }
            });
            bindin.estado = true;
            forms ={};
            interno= 'new';
            externo= 'new';
            progress.index = progresso();

        },
        setNext : function (data) {
            next=data;
        },
        getNext: function () {
            return next;
        },
        exit: function (val) {
            console.log("exit");
            if(val){
                next(val);
            }
        }






    };
});

/****/

MyApp.factory('vlResource', ['$resource',
    function ($resource) {
        return $resource(':mod/:lv1/:lv2/:lv3/', {}, {
            html: {method: 'GET',params: {mod:"sistema",lv1:"",lv2:"",lv3:""},isArray: false ,headers: { 'Content-Type': 'text/html' }}

        });
    }
]);
MyApp.service('fileSrv',['Upload','$timeout','$interval','$filter',function (Upload,$timeout,$interval,$filter) {
    var folder = 'none';
    var key = '';
    var bin = {estado:'wait', data: undefined};
    var upload =  {succeces:[], error:[], total:[],upload:{}};
    var start = function () {
        angular.forEach( upload.upload, function (v, k) {
            if(v.state == "wait"){
                var copy = upFile;
                copy(v);
                return 0;
            }
        });
        stop();
    };

    var stop= function () {
        var stop = true;
        angular.forEach( upload.upload, function (v, k) {
            if(v.state == "wait" || v.state == 'load' ){
                stop= false;
                return 0;
            }
        });

        if (stop){
            bin.estado= 'finish';

            $timeout(function () {

                bin.estado= 'wait';
                bin.data= undefined;

                clear();
            },500);

        }

    }
    var upFile = function (file) {
        if(file.fail){
            delete file.fail;
        }
        $timeout(function () {
            bin.data = file;
            bin.estado = 'up';
            var send = { folder:folder, file: file.file};
            Upload.upload({
                url: 'master/files/upload',
                data :send
            }).progress(function (evt) {
                file.state = 'load';
                file.up = parseInt(100.0 * evt.loaded / evt.total)
            }).success(function (data, status, headers, config) {
                file.state = 'up';
                angular.forEach(data,function (v, k) {
                    file[k]= v;
                });
                upload.total.push(file);
                upload.succeces.push(file);
                start();
            }).error(function(){
                upload.total.push(file);
                upload.error.push(file);
                file.state = 'fail';
                start();
            });
        },50*file.index );
    };

    var clear = function () {
        folder = 'none';

        bin.estado= 'wait';
        bin.data = undefined;
        upload.succeces.splice(0,upload.succeces.length);
        upload.error.splice(0,upload.error.length);
        upload.total.splice(0,upload.total.length);
        upload.upload = {};
    };

    return {
        bin:function () {
            return bin;
        },
        setKey: function (data) {
            key = angular.copy(data);
        },
        getKey: function () {
            return key;
        },
        upload : function (data) {
            angular.forEach(data, function (v, k) {
                var uid = Math.random();
                upload.upload[uid]= {uid:uid,file:v, state:'wait', up:0 , index : k+1};
            });
            start();
            return upload.upload;
        },
        upFile : upFile,
        get: function () {
            return upload;
        }
        ,storage : function (data) {
            folder = data;
        }
        ,clear : function () {

            clear();
        }



    }
}]);


MyApp.directive('vlThumb', function( fileSrv) {
    return {
        replace: true,
        transclude: true,
        scope:{
            'model' : "=ngModel",
            'up' : "=vlUp",
            /*'fail' : "=vlFail",
             'progress' : "=vlLoad"*/
        },
        link: function(scope, elem, attr, ctrl){
            scope.$watch('model.state', function (newVal,oldVal) {
                if(newVal == 'up'){
                    delete scope.model.up;
                    if( scope.up){
                        scope.up(scope.model);
                    }
                }
                if(newVal == 'fail'){
                    scope.model.fail = true;
                    /*if(scope.fail){
                     scope.model
                     //scope.fail(scope.model);
                     }*/
                }
            });
            scope.reinten = function (item) {
                fileSrv.upFile(item);
            }
        },
        template: function () {

            return '<div layout="column"  layout-align="center center" style="background-color: rgba(88, 181, 234,{{( model.up)/100}}); height: 100%">'  +
                '<img ng-src="images/thumbs/{{model.thumb}}"/>' +
                ' <div style="position: absolute; vertical-align: middle;" ng-show="model.up && !model.fail">{{model.up}}%</div> ' +
                ' <div style="position: absolute; vertical-align: bottom; background-color: #0a6ebd;" ng-show="model.fail" ng-click="reinten(model)">fail</div> ' +
                '</div>'
        }
    };
});




MyApp.directive('vlProgress', function( $timeout) {

    var next = function (item, time, last) {
        if(item){
            $timeout(function () {
                item.st = (!last) ? 'true' : 'this';
            }, time);
        }
    };
    var back = function (item, time, last) {
        console.log("item ", item)
        if(item){
            $timeout(function () {
                item.st = (!last) ? 'false' : 'this';
            }, time);
        }
    };
    return {
        transclude: true,
        replace: true,
        scope:{
            'model' : "=ngModel",
            'index':'=vlIndex'
        },
        link: function(scope, elem, attr, ctrl){
            scope.actual=0;
            scope.$watch('index', function (newVal,oldVall) {
                var i = 0;
                if(newVal >oldVall){
                    var i = oldVall;
                    while(i != newVal){
                        next(scope.model[i], (100 * i), ( i == newVal) );
                        i++;
                    }
                    next(scope.model[newVal], (100 * newVal), true );

                }else if(newVal < oldVall){

                    var i = oldVall;
                    while(i != newVal){
                        back(scope.model[i], 100* (i - oldVall),false );
                        i--;
                    }
                    back(scope.model[newVal], 100* (i - newVal),(newVal > 0 ));


                    scope.actual  = newVal;
                }
            });
        },
        template: function () {
            return '<div layout="row"  layout-align="start center " flex style="padding: 0 4px 0 4px;">' +
                '<div layout="row" class="vl-progress" layout-align="right center" ng-repeat="item in model" id="progress_{{i}}" ' +
                ' > ' +
                '<div info="{{item.text}}" class="iconCircle {{item.st}}" id="progress{{$index}}"  ng-class="{\'circleAnimate\':line}">' +
                '<div class="progress-bubble {{item.st}}" ng-class="{\'progress-bubble-first\':($index == 0),\'progress-bubble-last\':($index == (model.length -1 ))  }" >' +
                '<div>{{item.text[item.st]}}</div> <div style="" layout="row" class="progress-bubble-arrow {{item.st}} " ><div></div></div></div></div><div class="line {{item.st}}" style="" flex ng-show="$index < (model.length -1) " >' +
                '<div class="load_area" style="" ng-class="{\'lineAnimate\':item.st == \'rigth\'}" >' +
                '</div> </div> </div> </div>'
        }    };
});


MyApp.directive('gridOrderBy', function($timeout) {

    return {
        replace: true,
        transclude: true,
        scope:{
            'model' : "=ngModel"
        },
        link: function(scope, elem, attr, ctrl){},
        template: function(elem, attr){
            return '<div layout="column" layout-align="end" class="table-filter-order-by" pp="{{model.order}}">' +
                '<div ng-click="model.order =\''+ attr.key+'\'" layout="column" layout-align="start"  ><img ng-src=\"{{(model.order == \''+attr.key + '\') ? \'images/TrianguloUp.png\' : \'images/Triangulo_2_claro-01.png\' }}\" > </div>' +
                '<div ng-click="model.order =\'-'+ attr.key+'\'" >'+'<img ng-src=\"{{(model.order == \'-'+attr.key + '\') ? \'images/TrianguloDown.png\' : \'images/Triangulo_1_claro.png\' }}\"  ></div>'+
                '</div>';
        }
    };
});

/*************************  MODULO DE mail *******************************/
MyApp.directive('vldhtmlPreview', function($timeout) {

    return {
        controller:'vldChtmlPreview',
        replace: true,
        scope:{
            'origenes' : "=load",
            'centerText' : "=?text",
            'title' : "=?title",
            'options' : "=?optionId",
            'template' : "=?template",
            'state' : "=?state"
        },
        transclude: true,
        link: function(scope, elem, attr, ctrl){},
        templateUrl: function(elem, attr){
            return 'modules/directives/htmlPreview';
        }
    };
});
MyApp.controller('vldChtmlPreview',['$scope','$timeout','$sce','Layers','vlResource',function($scope,$timeout, $sce,Layers,$resource){

    $scope.changes= {};
    $scope.state = 'wait';
    $scope.template = '<div></div>';
    /*$scope.centerText ='Sin cargar';*/
   // $scope.title ='Hola mundo';
   /* $scope.origen = {mod:'embarques',lv1:'html',id:'316'};*/



    $scope.load = function (key) {
        $scope.state = 'loading';
        $scope.centerText= 'cargando';
       // $scope.template= '<div></div>';
       /* $resource.html($scope.origen,{},function(response){
            $scope.centerText= 'Dibujando';
            $timeout(function () {
                $scope.template= $sce.trustAsHtml(response.body);
                $scope.state = 'load';
                $scope.changes = {index:-1, trace:[]};

            },2000);

        });*/
    };

    $scope.selectLang = function (id) {
        $scope.template= '<div></div>';
        $scope.centerText= 'Dibujando';
        $scope.template= $sce.trustAsHtml(angular.copy($scope.origenes[id].body));
        $scope.state = 'load';
    };
    $scope.change = function (e) {
        var el = angular.element(e.currentTarget);
        var k =  el.attr('id');
        if( $scope.options[k] && $scope.options[k].change){
            $scope.options[k] && $scope.options[k].change(e);
        }

    };

    $scope.blur = function (e) {
        var el = angular.element(e.currentTarget);
        if(el.is('[contenteditable="true"]')){
            var n = {ele:el[0],value: el[0].innerText};
            if(!angular.equals(n,$scope.changes.trace[$scope.changes.index])){
                $scope.changes.index ++;
                $scope.changes.trace[$scope.changes.index] = n;
            }
        }
        console.log("changes ",  $scope.changes);

    };

    $scope.listener = function (e) {
        var el = angular.element(e.target);
        if(el.is('[contenteditable="true"]')){
            if( !el.attr('bind')){
                el.bind("keydown", $scope.change);
                el.bind("blur", $scope.blur);
                el.attr('bind', true);
                var n = {ele:el[0],value: el[0].innerText};
                if(!angular.equals(n,$scope.changes.trace[$scope.changes.index])){
                    $scope.changes.index ++;
                    $scope.changes.trace[$scope.changes.index] = n;
                }
            }
        }
    };

    $scope.back = function () {
        $timeout(function () {
            if( $scope.changes.index != 0){
                var el = $scope.changes.trace[$scope.changes.index -1 ].ele;
                el.innerText =  $scope.changes.trace[$scope.changes.index -1 ].value;
                $scope.changes.index--;
            }
        },500);
    }
    $scope.next = function () {
        $timeout(function () {
            if($scope.changes.trace.length > 0 && (($scope.changes.index + 1 ) <= $scope.changes.trace.length)){

                var el = $scope.changes.trace[$scope.changes.index + 1 ].ele;
                console.log("el entro " ,el);
                el.innerText =  $scope.changes.trace[$scope.changes.index + 1 ].value;
                $scope.changes.index++;
            }
        },500);
    }
}]) ;