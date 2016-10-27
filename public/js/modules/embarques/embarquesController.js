MyApp.controller('embarquesController', ['$scope', '$mdSidenav','$timeout','$interval','form', 'shipment','setGetShipment','filesService', function ($scope, $mdSidenav,$timeout,$interval,form,$resource, $model, filesService) {

    //?review
    filesService.setFolder('orders');

    $scope.alerts =[];
    $scope.provSelec ={};
    $scope.provs =[];
    $scope.paises =[];
    $scope.shipment ={objs:{}};
    $scope.bindShipment =$model.bind();
    $scope.session = {global:'new', isblock: false};
    $scope.permit={
        created:true
    };
    $resource.query({type:"Provider"}, {}, function(response){$scope.provs= response; });

    $scope.search = function(){
        var data =[];
        if($scope.provs.length > 0){
            return $scope.provs;
        }
        return data;
    }

    $scope.setProvedor = function(prov){
        console.log("setprov form", form);
        if($scope.module.index == 0 || $scope.module.layer == 'listShipment'  ){
            $scope.provSelec= prov;
            $scope.listShipmentCtrl(prov);
        }else if($scope.module.layer == 'detailShipment'){
            $scope.provSelec= prov;
            $scope.save();
        }

    };

    $scope.reloadDates = function () {
        $resource.getMod({type:"Shipment", mod:"Dates", id:$scope.$parent.shipment.id,fecha_carga:true}, {}, function (response) {
            $model.setDates(response);
            $resource.postMod({type:"Shipment", mod:"SaveDates"},
                { id:$scope.$parent.shipment.id,
                    fecha_carga:response.fecha_carga,
                    fecha_tienda:response.fecha_tienda,
                    fecha_vnz:response.fecha_vnz
                }
                , function (response) {

                    $model.setDates(response);
                });
        });
    };


    $scope.closeSide = function(){
        $timeout(function () {
            if(form.getState() == "process"){
                $scope.validChangeFor();
            }else {
                interval= null;
                $scope.LayersAction({close:{search:true}});
            }
            /*if(!form.getValid()){

             }if(form.getState() == "process"){ $scope.validChangeFor();}else {
             $scope.validChangeFor();
             }*/
        },500);

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


    $scope.$watch('bindShipment.estado', function(newVal){

        if(newVal){
            $scope.shipment = $model.getData();
            if( $scope.shipment.objs){
                $scope.provSelec = $scope.shipment.objs.prov_id;
            }



        }
    });

    $scope.$watchGroup(['module.layer', 'module.index'] ,function(newVal){
        $scope.layer= newVal[0];
        $scope.index= newVal[1];
        if(newVal[1] == 0 || newVal[0] == 'listShipmentUncloset'){
            $model.clear();
            $scope.provSelec= undefined;
        }


    });




}]);

MyApp.controller('listShipmentCtrl', ['$scope','shipment','setGetShipment',  function ($scope,shipment, setGetShipment) {
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };

    $scope.load =  function () {
        $scope.tbl.data.splice(0,$scope.tbl.data.length);
        var demo = {
            titulo:"demo "+$scope.provSelec.razon_social,
            nro_factura:"demo ",
            id:-1,
            carga:new Date(),
            fecha_llegada_vnz:
                new Date(),
            fecha_llegada_tiend:
                new Date(),
            flete:{monto:0,simbol:'$'}
            ,nacionalizacion:{monto:0, simbol:"$"}
        }
        $scope.tbl.data.push(demo);
    };
    $scope.$parent.listShipmentCtrl = function(prov){
        if ($scope.$parent.module.index == 0 ){
            $scope.LayersAction({open:{name:"listShipment", after:$scope.load }});
        }else {
            $scope.load();
        }
    }
    $scope.setData = function (data){
        setGetShipment.setData(data);
        $scope.summaryShipmentCtrl();
    }



}]);

MyApp.controller('listShipmentUnclosetCtrl', ['$scope','shipment','setGetShipment',  function ($scope,$resource, setGetShipment) {
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };

    $scope.$parent.listShipmentCtrl = function(){
        if ($scope.$parent.module.index == 0 ){
            $scope.LayersAction({open:{name:"listShipmentUncloset", after: function () {
                $scope.$parent.provSelec = null;
                $resource.query({type:"Uncloset"},{}, function (response) {
                    if(response.length == 0){
                        $scope.$parent.LayersAction({close:true});
                    }else{
                        $scope.tbl.data= response;
                    }
                })
            }}});
        }else {

        }
    };
    $scope.setData = function (data){
        $resource.get({type:"Shipment", id:data.id},{}, function (response) {
            setGetShipment.setData(response);
            $scope.OpenShipmentCtrl(response);
        })

    }



}]);

MyApp.controller('summaryShipmentCtrl', ['$scope',  'shipment','setGetShipment',  function($scope,shipment, setGetShipment ){

    $scope.$parent.summaryShipmentCtrl = function(){
        $scope.LayersAction({open:{name:"summaryShipment", after: function(){
        }}});
    }

}]);

MyApp.controller('OpenShipmentCtrl', ['$scope', '$timeout','shipment','setGetShipment',function($scope,$timeout ,$resource,$model){

    $scope.provSelec = null;
    $scope.provSelecText = undefined;
    $scope.form= 'head';
    $scope.formOptions={
        head:{expand:true} ,
        date:{expand:true}  ,
        doc:{expand:true}  ,
        pago:{expand:true}  ,
        agreds:{expand:true}
    };
    $scope.$watch("provSelec", function(newVal){
        if(newVal != null && newVal.id && $scope.$parent.provSelec != null){
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
            $scope.$parent.provSelec= null;
        }
    });
    $scope.$watch("$parent.provSelec", function(newVal){
        if(newVal!= null){
            if(newVal.id ){
                if($scope.provSelec == null || newVal.id != $scope.provSelec.id ){
                    $scope.provSelec=newVal;
                    $scope.detailShipmenthead.$setDirty();
                }

            }
        }else{
            $scope.provSelec=null;
        }

    });

    $scope.$watchGroup(['detailShipmenthead.$valid', 'detailShipmenthead.$pristine'], function(newVal){
        if(!newVal[1]){
            $scope.$parent.save(function () {
                $scope.detailShipmenthead.$setPristine()
            });

        }
    });

    $scope.$parent.OpenShipmentCtrl = function(data){

        $scope.form= 'head';
        $scope.detailShipmenthead.$setPristine();
        $scope.detailShipmenthead.$setUntouched();
        $scope.$parent.LayersAction({open:{name:"detailShipment", after: function(){
            if(!data){
                $scope.detailShipmenthead.$setDirty();
            }
        }}});
    };

    $scope.toEditHead= function(id,val){
        if( $scope.session.global != 'new'){
            $model.change("shipment",id,val);
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
    //fechas

    $scope.clickFecha_carga = function () {

      if($scope.$parent.shipment.fechas.fecha_carga.confirm)  {

      }
    };



}]);

MyApp.controller('listTariffCtrl',['$scope','$timeout', 'shipment','tarifForm','setGetShipment',   function($scope,$timeout,  $resource,tarifForm, $model){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.pais_idSelec = null;
    $scope.pais_idText = undefined;
    $scope.puerto_idSelec = null;
    $scope.puerto_idText = undefined;
    $scope.tarifBind= tarifForm.bind();
    $scope.tarifaSelect = {};

    $scope.$parent.listTariffCtrl = function(){

        $scope.LayersAction({open:{name:"listTariff",
            before:function(){
                if($scope.$parent.shipment.tarifa_id  != null && $scope.$parent.shipment.tarifa_id.model){
                    console.log("$scope.$parent.shipment.objs", $scope.$parent.shipment.objs);
                    angular.forEach($scope.$parent.shipment.objs.tarifa_id.model, function(v,k){
                        $scope.tarifaSelect[k] =v;
                    });

                }
            }
        }});
    };

    $scope.setData = function(data){
        if($scope.tarifaSelect.id != data.id){


            angular.forEach(data, function(v,k){
                $scope.tarifaSelect[k] =v;
            });
            console.log(data);
            $scope.$parent.shipment.tarifa_id = data.id;

            $scope.$parent.shipment.objs.tarifa_id.freight_forwarder = angular.copy(data.objs.freight_forwarder_id);//tarifa_id.freight_forwarder
            $scope.$parent.shipment.objs.tarifa_id.naviera = angular.copy(data.objs.naviera_id);
            $resource.getMod({type:"Shipment", mod:"Dates", id:$scope.$parent.shipment.id,fecha_carga:true}, {}, function (response) {
                console.log("dates", response);
                $model.setDates(response);
                $resource.postMod({type:"Shipment", mod:"SaveDates"},
                    { id:$scope.$parent.shipment.id,
                        fecha_carga:response.fecha_carga,
                        fecha_tienda:response.fecha_tienda,
                        fecha_vnz:response.fecha_vnz
                    }
                    , function (response) {

                        $model.setDates(response);
                    });


            });



        }


    };
    $scope.$watch("tarifBind.estado", function (newVal, oldVal) {
        if(newVal && newVal == 'created' && tarifForm.get()){
            $scope.tbl.data.push(tarifForm.get());
            angular.forEach(tarifForm.get(), function(v,k){
                $scope.tarifaSelect[k] =v;
            });
            tarifForm.setState("waith");
            $resource.getMod({type:"Shipment", mod:"Dates", id:$scope.$parent.shipment.id,fecha_carga:true}, {}, function (response) {
                console.log("dates", response);
                $model.setDates(response);
                $resource.postMod({type:"Shipment", mod:"SaveDates"},
                    { id:$scope.$parent.shipment.id,
                        fecha_carga:response.fecha_carga,
                        fecha_tienda:response.fecha_tienda,
                        fecha_vnz:response.fecha_vnz
                    }
                    , function (response) {

                        $model.setDates(response);
                    });


            });
        }
    });
    $scope.$watch('$parent.shipment.objs.pais_id', function(newVal){

        $scope.pais_idSelec=newVal;
        if(newVal && newVal!= null ){
            $resource.query({type:"Country", mod:"Ports", pais_id:newVal.id},{}, function(response){
                $scope.pais_idSelec.ports = response;
            });
        }
    });
    $scope.$watch('$parent.shipment.objs.puerto_id', function(newVal){
        $scope.puerto_idSelec=newVal;
    });
    $scope.$watch('puerto_idSelec', function(newVal){
        if(newVal && newVal !=null){
            $resource.queryMod({type:"Tariff",mod:"List", puerto_id:$scope.puerto_idSelec.id},{}, function (response) {
                $scope.tbl.data= response;
            });
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

MyApp.controller('miniContainerCtrl',['$scope','$mdSidenav','$timeout','form','shipment',function($scope, $mdSidenav,$timeout,formSrv, $resource){
    $scope.isOpen= false;
    $scope.tipo_select = null;
    $scope.tipo_text = undefined;
    $scope.model ={};
    $scope.copy ={};
    $scope.containers = [{name:"20sd"},{name:"40sd"},{name:"40'ot"},{name:"40ot"}];
    $scope.options ={form:false};
    $scope.select ={};


    //constructor
    $scope.$parent.miniContainerCtrl = function(){
        $scope.containerForm.$setPristine();
        $scope.containerForm.$setUntouched();
        $scope.select ={};
        $mdSidenav("miniContainer").open().then(function(){
            $scope.isOpen= true;

            formSrv.getValid =function () { return (!$scope.containerForm.$pristine) && $scope.isOpen };
            if($scope.$parent.shipment.containers.length == 0){
                $scope.options.edit= false;
                $scope.options.creat= true;
            }
        });
    };

    // metodos
    $scope.close = function(){
        $scope.inClose();
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
    $scope.update = function (){

        var paso = true;
        if(!$scope.select.id){
            $scope.$parent.NotifAction("error", "Por favor haga click en el container que desea modificar y vuelva a presionarme  ",[],{autohidden:1500});
            paso= false;
        }
        else
        if(!$scope.containerForm.$pristine && $scope.model.id){
            console.log("a",$scope.copy) ;
            console.log("b",$scope.model );
            console.log("compare",angular.equals($scope.model,$scope.copy) );
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
                                    console.log("promise", response);
                                    if(response.action== 'upd'){
                                        // $scope.$parent.NotifAction("ok", "Container Actualizado",[],{autohidden:1500});

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
        console.log(e);
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

                        });
                    }
                }
            ]);

    };
    $scope.save = function (){
        if($scope.containerForm.$valid && !$scope.containerForm.$pristine){
            if($scope.containerForm.$valid ){
                $scope.model.embarque_id= $scope.$parent.shipment.id;
                $resource.postMod({type:"Container",mod:"Save"},$scope.model, function(response){
                    if(response.action== 'new'){
                        console.log("paren",$scope.$parent.shipment);
                        $scope.$parent.shipment.containers.push(response.model);
                        $scope.$parent.NotifAction("ok", "Container Agregado",[],{autohidden:2000});
                        $timeout(function () {
                            formSrv.setState("continue");
                            $scope.inClose();
                        },0);
                        $timeout(function(){
                            $scope.containerForm.$setPristine();
                            $scope.containerForm.$setUntouched();
                            $scope.options.form= false;
                        },100);
                    }else{
                        if(response.action== 'upd'){
                            $scope.$parent.NotifAction("ok", "Container Actualizado",[],{autohidden:2000});
                            angular.forEach(response.model, function(v,k){
                                $scope.select[k]=v;
                            });
                            $timeout(function(){
                                $scope.containerForm.$setPristine();
                                $scope.containerForm.$setUntouched();
                                $scope.options.form= false;
                            },100);

                        }
                    }
                    $scope.model.id=undefined;
                    $scope.model.volumen=undefined;
                    $scope.model.cantidad=undefined;
                    $scope.model.tipo=undefined;
                    $scope.model.peso=undefined;
                    $scope.tipo_text = undefined;

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

        }
    }

}]);

MyApp.controller('listOrdershipmentCtrl',['$scope','shipment', function($scope,$resource){
    $scope.tbl ={
        order:"id",
        filter:{}
    };
    $scope.select ={};
    $scope.$parent.listOrdershipment = function(){
        $scope.select ={};
        $scope.LayersAction({open:{name:"listOrdershipment", after: function(){


            if($scope.select.id){
                $resource.getMod({type:"Order", mod:"Order", id:$scope.select.id, embarque_id:$scope.$parent.shipment.id},{},function (response) {
                    $scope.select.isTotal= response.isTotal;
                });
            }


        }}});
    };
    $scope.changeAsig = function (data) {
        console.log("data");
        var send = {doc_origen_id:data.id, embarque_id:$scope.$parent.shipment.id};
        if(data.asignado){
            $resource.postMod({type:"Order", mod:"Save"},send,function (response) {
                $scope.$parent.NotifAction("ok", "Pedido agregado al embarque",[],{autohidden:1500});
                if(response.doc_origen_id){
                    var odc= response.doc_origen_id;
                    odc.asignado =true;
                    odc.isTotal = true;
                    $scope.$parent.shipment.odcs.push(odc)
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

MyApp.controller('listOrderAddCtrl',['$scope','shipment', function($scope, $resource){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.select = {};

    $scope.$parent.listOrderAdd = function(){
        $scope.select = {};

        $scope.LayersAction({open:{name:"listOrderAdd", after: function(){
            $resource.queryMod({type:"Order", mod:"List", prov_id:$scope.$parent.shipment.prov_id, embarque_id: $scope.$parent.shipment.id},{},function (response) {
                $scope.tbl.data= response;
            });
        }}});
    }

    $scope.changeAsig = function (data) {
        console.log("data");
        var send = {doc_origen_id:data.id, embarque_id:$scope.$parent.shipment.id};
        if(data.asignado){
            $resource.postMod({type:"Order", mod:"Save"},send,function (response) {
                $scope.$parent.NotifAction("ok", "Pedido agregado al embarque",[],{autohidden:1500});
                if(response.doc_origen_id){
                    var odc= response.doc_origen_id;
                    odc.asignado =true;
                    odc.isTotal = true;
                    $scope.$parent.shipment.odcs.push(odc)
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


        }
        if(newVal && formSrv.name == 'DetailProductCreate'){
            console.log("new object",formSrv.getData() );
            angular.forEach(formSrv.getData(), function (v, k) {
                $scope.select[k]= v;
            });

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
        if(!$scope.select.id){
            $scope.$parent.NotifAction("error", "Por favor selecione un articulo primero", [], {autohidden:2000});
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
                doc_origen_id:$scope.select.doc_origen_id
            };

            console.log("data en upadtea", data);
            $scope.$parent.DetailProductShipment(data);


        }

    }

    $scope.created = function () {
        formSrv.name= 'DetailProductCreate';
        $scope.$parent.CreatProduct();
    }
}]);

MyApp.controller('listProductAddCtrl',['$scope','shipment','form', 'setGetShipment',function($scope,$resource, formSrv, $model){
    $scope.tbl ={
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
                $resource.getMod({type:"Shipment", mod:"Dates", id:$scope.$parent.shipment.id,fecha_carga:true}, {}, function (response) {
                    console.log("dates", response);
                    $model.setDates(response);
                    $resource.postMod({type:"Shipment", mod:"SaveDates"},
                        { id:$scope.$parent.shipment.id,
                            fecha_carga:response.fecha_carga,
                            fecha_tienda:response.fecha_tienda,
                            fecha_vnz:response.fecha_vnz
                        }
                        , function (response) {

                            $model.setDates(response);
                        });


                });


        }
    });
    $scope.select = {};
    $scope.$parent.listProductAdd = function(){
        $scope.select = {};
        $resource.queryMod({type:"Order", mod:"Products", embarque_id:$scope.$parent.shipment.id},{}, function (response) {
            $scope.tbl.data = response;
        });
        $scope.LayersAction({open:{name:"listProductAdd", after: function(){

        }}});
    };

    /**change asignado en clik espcial */
    $scope.changeAsig = function (data) {

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

}]);

MyApp.controller('historyProductCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.isOpen = false;
    $scope.$parent.historyProduct = function(){
        $mdSidenav("miniHistoryProd").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniHistoryProd").close().then(function(){
                $scope.isOpen = false;
            });;
        }

    };
}]);

/**Mark
 * agregado de productos
 * **/
MyApp.controller('CreatProductCtrl',['$scope','$mdSidenav','masters','form','shipment', function($scope,$mdSidenav, masters, formSrv, $resource){
    $scope.isOpen = false;
    $scope.model ={};

    $scope.lineas = [];
    $scope.lineaSelec = null;
    $scope.lineaText = undefined;

    $scope.almacn = [];
    $scope.almacnSelect = null;
    $scope.almacnText = undefined ;

    $scope.$parent.CreatProduct = function(){
        masters.query({type:"prodLines"},{}, function (response) {
            $scope.lineas= response;
        });
        masters.query({type:"DirStores"},{}, function (response) {
            $scope.almacn= response;
        });
        $scope.model.prov_id= $scope.$parent.shipment.prov_id;
        $mdSidenav("miniCreatProduct").open().then(function(){
            $scope.isOpen = true;
        });
    };

    $scope.close= function(){


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
                $resource.postMod({type:"Product", mod:"CreateOnAdd"},$scope.model,function (response) {
                    $scope.$parent.shipment.items.push(response.model);
                    $scope.$parent.NotifAction("ok", "Producto creado y añadido",[],{autohidden:2000});
                    $scope.inClose();
                    formSrv.setData(response.model);
                    formSrv.setState("continue");
                });
            }

        }

    };

    $scope.inClose =  function(){
        $mdSidenav("miniCreatProduct").close().then(function(){
            $scope.isOpen = false;
        });
    }


}]);

MyApp.controller('miniMblCtrl',['$scope','$mdSidenav','$timeout','$interval','filesService','shipment', function($scope,$mdSidenav,$timeout, $interval,filesSrv, $resource){
    $scope.isOpen = false;
    $scope.cola ={estado:'waith', data :[], upload:0, cola:0};
    //{{up:[}, size, estado:'waith'}
    //{estado:'wait',cu}


    $scope.$parent.miniMbl = function(){
        $scope.head.$setPristine();
        $scope.head.$setUntouched();
        $mdSidenav("miniMbl").open().then(function(){
            $scope.isOpen = true;
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
    var interval = null;
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            $scope.cola.estado='uploading';
            $scope.cola.cola = $scope.cola.cola + 1;
            var pr =Object.create( $scope.asign($scope.files,"nro_mbl"));
            $scope.cola.data.push(pr);
            if(interval== null){
                interval = $interval(function () {
                    console.log("interval ",$scope.cola );
                    var finisAll= true;
                    angular.forEach($scope.cola.data,function (v, k) {

                        if(v.isFinish()){
                            finisAll=true;
                            console.log("filse fin", v)
                            angular.forEach(v.getFilesUp(), function (sv,sf) {
                                $scope.$parent.shipment.nro_mbl.adjs.push(sv);
                            });
                            if(v.getFilesError().length > 0){
                                console.log("error subiendo archivos", v.getFilesError());
                            }
                        }
                        if(v.getState() == 'waith'){
                            console.log("waith", v);
                            finisAll= false;
                            v.start();
                        }
                        if(v.getState() == 'up'){
                            finisAll= false;
                            console.log("up", v);
                        }


                    });
                    if(finisAll){
                        $scope.cola.estado='finish';
                        $interval.cancel(interval);

                        interval=  null;
                    }
                },500);
            }
        }
    });
    $scope.asign = function (files, doc) {
        var estado ="waith";
        var filesUp = [];
        var filesError = [];
        var all =[];
        var finish= false;
        var asig = function (file) {
            $resource.postMod({type:"Attachment", mod:"Save"},{archivo_id:file.id,documento:doc, embarque_id:$scope.$parent.shipment.id}, function (response) {
                all.push({state:'good', file:response});
                filesUp.push(response);
                if(all.length == files.length){
                    finish= true;
                    estado= 'finish';
                }
            }, function (error) {
                console.log("error", error);
            })
        };

        return {
            getState: function () {return estado;},
            getFiles : function () {return files;},
            getSize: function(){return files.length ;},
            getFilesUp:function () {return filesUp;},
            getFilesError : function(){return filesError},
            isFinish : function () {return   finish},
            getAll : function () {return   all},
            start: function () {
                estado =  'up';
                filesSrv.setFolder("orders");
                /*                var x = $timeout(function () {
                 if(estado != 'fin'){
                 estado='error';
                 }
                 },60000);*/
                angular.forEach(files, function(v) {
                    filesSrv.Upload({
                        file: v,
                        success: function (data) {
                            asig(data);
                        },
                        error: function (data) {
                            all.push({state:'bad', file:response});
                            filesError.push(data);
                            if(all.length== files.length){
                                finish= true;
                            }
                        }
                    })
                });
            }


        }
    }
    $scope.close= function(e){
        if($scope.isOpen){
            $mdSidenav("miniMbl").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('miniHblCtrl',['$scope','$mdSidenav','$timeout','$interval','filesService','shipment', function($scope,$mdSidenav,$timeout, $interval,filesSrv, $resource){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.cola ={estado:'waith', data :[], upload:0, cola:0};

    $scope.$parent.miniHbl = function(){
        $mdSidenav("miniHbl").open().then(function(){
            $scope.isOpen = true;
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
    var interval = null;
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            $scope.cola.estado='uploading';
            $scope.cola.cola = $scope.cola.cola + 1;
            var pr =Object.create( $scope.asign($scope.files,"nro_hbl"));
            $scope.cola.data.push(pr);
            if(interval== null){
                interval = $interval(function () {
                    console.log("interval ",$scope.cola );
                    var finisAll= true;
                    angular.forEach($scope.cola.data,function (v, k) {

                        if(v.isFinish()){
                            finisAll=true;
                            console.log("filse fin", v)
                            angular.forEach(v.getFilesUp(), function (sv,sf) {
                                $scope.$parent.shipment.nro_hbl.adjs.push(sv);
                            });
                            if(v.getFilesError().length > 0){
                                console.log("error subiendo archivos", v.getFilesError());
                            }
                        }
                        if(v.getState() == 'waith'){
                            console.log("waith", v);
                            finisAll= false;
                            v.start();
                        }
                        if(v.getState() == 'up'){
                            finisAll= false;
                            console.log("up", v);
                        }


                    });
                    if(finisAll){
                        $scope.cola.estado='finish';
                        $interval.cancel(interval);

                        interval=  null;
                    }
                },500);
            }
        }
    });
    $scope.asign = function (files, doc) {
        var estado ="waith";
        var filesUp = [];
        var filesError = [];
        var all =[];
        var finish= false;
        var asig = function (file) {
            $resource.postMod({type:"Attachment", mod:"Save"},{archivo_id:file.id,documento:doc, embarque_id:$scope.$parent.shipment.id}, function (response) {
                all.push({state:'good', file:response});
                filesUp.push(response);
                if(all.length == files.length){
                    finish= true;
                    estado= 'finish';
                }
            }, function (error) {
                console.log("error", error);
            })
        };

        return {
            getState: function () {return estado;},
            getFiles : function () {return files;},
            getSize: function(){return files.length ;},
            getFilesUp:function () {return filesUp;},
            getFilesError : function(){return filesError},
            isFinish : function () {return   finish},
            getAll : function () {return   all},
            start: function () {
                estado =  'up';
                filesSrv.setFolder("orders");
                /*                var x = $timeout(function () {
                 if(estado != 'fin'){
                 estado='error';
                 }
                 },60000);*/
                angular.forEach(files, function(v) {
                    filesSrv.Upload({
                        file: v,
                        success: function (data) {
                            asig(data);
                        },
                        error: function (data) {
                            all.push({state:'bad', file:response});
                            filesError.push(data);
                            if(all.length== files.length){
                                finish= true;
                            }
                        }
                    })
                });
            }


        }
    }


    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniHbl").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('miniExpAduanaCtrl',['$scope','$mdSidenav','$timeout','$interval','filesService','shipment', function($scope,$mdSidenav,$timeout, $interval,filesSrv, $resource){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.cola ={estado:'waith', data :[], upload:0, cola:0};

    $scope.$parent.miniExpAduana = function(){
        $mdSidenav("miniExpAduana").open().then(function(){
            $scope.isOpen = true;
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
    var interval = null;
    $scope.$watch('files.length', function(newValue){
        if(newValue > 0){
            $scope.cola.estado='uploading';
            $scope.cola.cola = $scope.cola.cola + 1;
            var pr =Object.create( $scope.asign($scope.files,"nro_dua"));
            $scope.cola.data.push(pr);
            if(interval== null){
                interval = $interval(function () {
                    console.log("interval ",$scope.cola );
                    var finisAll= true;
                    angular.forEach($scope.cola.data,function (v, k) {

                        if(v.isFinish()){
                            finisAll=true;
                            console.log("filse fin", v)
                            angular.forEach(v.getFilesUp(), function (sv,sf) {
                                $scope.$parent.shipment.nro_dua.adjs.push(sv);
                            });
                            if(v.getFilesError().length > 0){
                                console.log("error subiendo archivos", v.getFilesError());
                            }
                        }
                        if(v.getState() == 'waith'){
                            console.log("waith", v);
                            finisAll= false;
                            v.start();
                        }
                        if(v.getState() == 'up'){
                            finisAll= false;
                            console.log("up", v);
                        }


                    });
                    if(finisAll){
                        $scope.cola.estado='finish';
                        $interval.cancel(interval);

                        interval=  null;
                    }
                },500);
            }
        }
    });
    $scope.asign = function (files, doc) {
        var estado ="waith";
        var filesUp = [];
        var filesError = [];
        var all =[];
        var finish= false;
        var asig = function (file) {
            $resource.postMod({type:"Attachment", mod:"Save"},{archivo_id:file.id,documento:doc, embarque_id:$scope.$parent.shipment.id}, function (response) {
                all.push({state:'good', file:response});
                filesUp.push(response);
                if(all.length == files.length){
                    finish= true;
                    estado= 'finish';
                }
            }, function (error) {
                console.log("error", error);
            })
        };

        return {
            getState: function () {return estado;},
            getFiles : function () {return files;},
            getSize: function(){return files.length ;},
            getFilesUp:function () {return filesUp;},
            getFilesError : function(){return filesError},
            isFinish : function () {return   finish},
            getAll : function () {return   all},
            start: function () {
                estado =  'up';
                filesSrv.setFolder("orders");
                /*                var x = $timeout(function () {
                 if(estado != 'fin'){
                 estado='error';
                 }
                 },60000);*/
                angular.forEach(files, function(v) {
                    filesSrv.Upload({
                        file: v,
                        success: function (data) {
                            asig(data);
                        },
                        error: function (data) {
                            all.push({state:'bad', file:response});
                            filesError.push(data);
                            if(all.length== files.length){
                                finish= true;
                            }
                        }
                    })
                });
            }


        }
    }
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniExpAduana").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

// detalle de peido agregado mark
MyApp.controller('detailOrderShipmentCtrl',['$scope','shipment','form', function($scope, $resource, form){
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
            console.log("entro",$scope.prodSelect);
        }
    });

    $scope.$parent.detailOrderShipment = function(data){
        $scope.prodSelect = {};
        $resource.getMod({type:"Order", mod:"Order", id:data.id, embarque_id:$scope.$parent.shipment.id},{},function (response) {
            angular.forEach(response, function (v,k) {
                $scope.select[k]=v;
            });

        } );

        $scope.$parent.LayersAction({open:{name:"detailOrder", after: function(){

        }}});

    };
    $scope.open = function (model) {
        form.name = 'DetailProductShip';
        console.log("name set",form.name);

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
            doc_origen_id:$scope.select.id
        };

        console.log("data", data)
        $scope.$parent.DetailProductShipment(data);
    }


}]);

MyApp.controller('detailOrderAddCtrl',['$scope','shipment','form', function($scope, $resource, form){
    $scope.isOpen = false;
    $scope.tbl ={data:[]};
    $scope.prdSelect ={};
    $scope.select={};
    $scope.bindForm= form.bind();

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


        }
    });



    $scope.$parent.detailOrderAdd = function(data){

        $resource.getMod({type:"Order", mod:"Order", id:data.id, embarque_id:$scope.$parent.shipment.id},{},function (response) {
            angular.forEach(response, function (v,k) {
                $scope.select[k]=v;
            });

        } );
        $scope.$parent.LayersAction({open:{name:"detailOrderAdd"}});

    };

    $scope.openProd = function (model) {
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
            doc_origen_id:$scope.select.id
        };

        console.log("data", data)
        $scope.$parent.DetailProductShipment(data);


    }

}]);

MyApp.controller('DetailProductShipmentCtrl',['$scope','$mdSidenav', '$timeout', 'form','shipment', function($scope,$mdSidenav, $timeout, formSrv, $resource){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.select = {asignado:0};
    $scope.original= {};
    $scope.isUpdate= false;
    var time = null;


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

                                    if(response.rm_odc){
                                        var index = -1;
                                        angular.forEach($scope.$parent.shipment.odcs,function (v, k) {
                                            if(response.rm_odc == v.id){
                                                index = k;
                                                return 0;
                                            }
                                        } );
                                        if(index != -1){
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
                    embarque_id: $scope.$parent.shipment.id ,
                    doc_origen_id:($scope.select.doc_origen_id) ? $scope.select.doc_origen_id : $scope.select.doc_id,
                    producto_id: $scope.select.producto_id
                };
                $resource.postMod({type:"OrderItem", mod:"Save"},send, function (response) {

                    $scope.$parent.NotifAction("ok", "Articulo atualizado", [], {autohidden:1500});

                    if(response.doc_origen_id){
                        var doc = angular.copy(response.doc_origen_id);
                        doc.asignado= true;
                        $scope.$parent.shipment.odcs.push(doc);

                    }
                    if(response.accion == 'new'){
                        $scope.$parent.shipment.items.push(response.model);
                    }
                    $scope.select.embarque_item_id= response.id;
                    $scope.select.cantidad = response.cantidad;
                    $scope.select.saldo = response.saldo;
                    $scope.select.model = response.model;
                    $scope.select.asignado = true;
                    formSrv.setData(angular.copy($scope.select));
                    formSrv.setBind(true);
                    $scope.inClose();
                });
            }
        }
    };

    $scope.inClose = function () {
        $scope.select ={};
        $mdSidenav("miniDetailProductShipment").close().then(function(){
            $scope.isOpen = false;
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
                    shipment.get({type:"Shipment", id:data.data[0].id},{}, function(response){
                        $model.setData(response);
                        $scope.$parent.OpenShipmentCtrl(response);
                        $scope.close();
                    });
                }else{
                    $scope.close();
                    $scope.$parent.listShipmentCtrl();

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

MyApp.controller('CreatTariffCtrl',['$scope','$mdSidenav','$timeout','form','tarifForm','masters','shipment', function($scope,$mdSidenav,$timeout,formSrv,tarifForm,masters ,$resource){
    $scope.isOpen = false;
    $scope.isLoad =false;
    $scope.data ={adjs:[]};
    $scope.form='';
    $scope.model ={};

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

    $scope.$parent.CreatTariff = function(){
        $scope.head.$setPristine();
        $scope.bond.$setPristine();
        $scope.head.$setUntouched();
        $scope.bond.$setUntouched();
        $mdSidenav("miniCreatTariff").open().then(function(){
            $scope.isOpen = true;


            $timeout(function () {
                var elem = angular.element("#miniCreatTariff #head");
                elem[0].click();
            },0);
            formSrv.name = "CreatTariff";
            $scope.loadFF();
            $scope.loadData();
        });
    };

    $scope.close= function(e){
        if($scope.isOpen){
            if($scope.head.$pristine && $scope.bond.$pristine  ){
                $scope.inClose();
            }else {
                if($scope.head.$valid && $scope.bond.$valid ){
                    formSrv.setState("process");
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

                        },1500)
                    });

                }else {
                    formSrv.setState("process");
                    $scope.$parent.NotifAction("alert", "No se puede crear las tarifa con los datos suministrados ¿Que desea hacer?",
                        [
                            {name:"Cancelar la creacion ", default:10,action:
                                function () { formSrv.setState("continue"); $scope.inClose();}

                            },
                            {name:"Corregir", action:function () {
                                formSrv.back= function () {
                                    $timeout(function () {
                                        var elem = angular.element("#miniCreatTariff ng-invalid");
                                        console.log("invlaid", elem);
                                        elem[0].focus();
                                        tarifForm.setState("waith");
                                    },0);
                                }
                                formSrv.setState("cancel");

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
        if(pais != null){
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
            $resource.queryMod({type:"Freight_Forwarder", mod:"List", pais_id:$scope.$parent.shipment.pais_id},{}, function (response) {
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
    /*


     console.log("antes de eidit", $scope.f);
     $scope.f.isValid = function () {
     $scope.f.state= "valid";
     console.log("dentro de valid", this);
     return $scope.head.$valid && $scope.bond.$valid;
     };
     $scope.f.save = function () {
     console.log("dentro de save", this);
     $scope.f.state= "saving";
     $scope.f.state= "save";
     tarifForm.set($scope.model);
     tarifForm.setState("save");


     return true;
     };
     $scope.f.getData = function () {
     return $scope.model;
     };*/



}]);


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
            valid=false;
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
        }
        ,
        setData : function(doc){
            bindin.estado = false;

            shipment.get({type:"Shipment", id:doc.id},{}, function (response) {
                angular.forEach(response,function (v, k) {
                    if(typeof (v) == 'string' || v == null){
                        Shipment[k]=v;
                    }
                });
                Shipment.objs= {};
                angular.forEach(response.objs,function (v, k) {
                    Shipment.objs[k]=v;
                });
                if(response.fechas){
                    Shipment.fechas= {};
                    if(response.fechas.fecha_carga.value){
                        Shipment.fechas.fecha_carga={};
                        Shipment.fechas.fecha_carga.confirm=response.fechas.fecha_carga.confirm;
                        Shipment.fechas.fecha_carga.isManual=response.fechas.fecha_carga.isManual;
                        Shipment.fechas.fecha_carga.value = DateParse.toDate(response.fechas.fecha_carga.value);
                    }
                    if(response.fechas.fecha_tienda.value){
                        Shipment.fechas.fecha_tienda={};
                        Shipment.fechas.fecha_tienda.confirm=response.fechas.fecha_carga.confirm;
                        Shipment.fechas.fecha_tienda.isManual=response.fechas.fecha_carga.isManual;
                        Shipment.fechas.fecha_tienda.value = DateParse.toDate(response.fechas.fecha_tienda.value);
                    }
                    if(response.fechas.fecha_vnz.value){
                        Shipment.fechas.fecha_vnz={};
                        Shipment.fechas.fecha_vnz.confirm=response.fechas.fecha_vnz.confirm;
                        Shipment.fechas.fecha_vnz.isManual=response.fechas.fecha_carga.isManual;
                        Shipment.fechas.fecha_vnz.value = DateParse.toDate(response.fechas.fecha_vnz.value);
                    }
                }

                Shipment.emision = (response.emision!= null) ? DateParse.toDate(response.emision) : null;
                Shipment.containers = response.containers;
                Shipment.odcs = response.odcs;
                Shipment.items = response.items;
                Shipment.nro_mbl = {
                    adjs:response.nro_mbl.adjs,
                    documento: response.nro_mbl.documento,
                    emision:(response.nro_mbl.emision== null)? undefined: DateParse.toDate(response.nro_mbl.emision)
                } ;
                Shipment.nro_hbl = {
                    adjs:response.nro_hbl.adjs,
                    documento: response.nro_hbl.documento,
                    emision:(response.nro_hbl.emision== null)? undefined: DateParse.toDate(response.nro_hbl.emision)
                } ;
                Shipment.nro_dua = {
                    adjs:response.nro_dua.adjs,
                    documento: response.nro_dua.documento,
                    emision:(response.nro_dua.emision== null)? undefined: DateParse.toDate(response.nro_dua.emision)
                } ;
                console.log("chipment", Shipment);
                bindin.estado = true;

            });



        },
       setDates : function (fechas) {
           Shipment.fechas= {};
           if(fechas.fecha_carga.value){
               Shipment.fechas.fecha_carga={};
               Shipment.fechas.fecha_carga.confirm=fechas.fecha_carga.confirm;
               Shipment.fechas.fecha_carga.isManual=fechas.fecha_carga.isManual;
               Shipment.fechas.fecha_carga.value = DateParse.toDate(fechas.fecha_carga.value);
           }
           if(fechas.fecha_tienda.value){
               Shipment.fechas.fecha_tienda={};
               Shipment.fechas.fecha_tienda.confirm=fechas.fecha_carga.confirm;
               Shipment.fechas.fecha_tienda.isManual=fechas.fecha_carga.isManual;
               Shipment.fechas.fecha_tienda.value = DateParse.toDate(fechas.fecha_tienda.value);
           }
           if(fechas.fecha_vnz.value){
               Shipment.fechas.fecha_vnz={};
               Shipment.fechas.fecha_vnz.confirm=fechas.fecha_vnz.confirm;
               Shipment.fechas.fecha_vnz.isManual=fechas.fecha_carga.isManual;
               Shipment.fechas.fecha_vnz.value = DateParse.toDate(fechas.fecha_vnz.value);
           }

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
            forms ={};
            interno= 'new';
            externo= 'new';
             bindin.estado=false;
            Shipment.nro_dua={};
            Shipment.nro_dua.documento = undefined;
            Shipment.nro_dua.emision =undefined;
            Shipment.nro_dua.emision =undefined;
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
                   Shipment.objs[k]=null;
               });
           }
            angular.forEach(Shipment,function (v, k) {
               if(typeof v =='string'){
                   Shipment[k]= undefined;
               }
            });
            bindin.estado = true;

        }


    };
});


/*
 MyApp.service('setGet', function(DateParse, shipment) {

 var forms ={};
 var interno= 'new';
 var externo= 'new';
 var data={};
 var bindin ={estado:false, comit:"none"};

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

 bind:bindin,
 setBindState: function (data) {
 bindin.estado= data;
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
 /!*angular.forEach(field, function(v,k2){
 if(v!=null && typeof (v) != 'object' && typeof (v) != 'array' && typeof (k) !='numer' && !angular.isNumber(k)){
 forms[k][k2].v= v;
 forms[k][k2].estado='upd';
 forms[k][k2].trace.push(v);
 }

 });*!/
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
 },
 setData : function(doc){
 data=doc;
 },
 reload: function(doc){
 bindin.estado=false;
 bindin.estado=true;
 },
 getData : function(){
 return data;
 },
 clear: function(){
 forms ={};
 interno= 'new';
 externo= 'new';
 Shipment={};
 bindin.estado=false;
 }


 };
 });
 */
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
/**

 <div layout="row" layout-align="end center" class="table-filter ng-isolate-scope layout-align-end layout-column ng-valid" ng-click="test()" ng-model="tbl" key="emision" role="button" tabindex="0" aria-invalid="false" style="margin-left: -8px;">

 <img src="images/TrianguloUp.png" style="
 margin-bottom: -4px;
 "><div style="
 border-bottom: solid 1.5px rgb(225, 225, 225);
 margin-bottom: 18px;
 "><img src="images/TrianguloDown.png">
 </div>

 </div>

 */
MyApp.controller("orderByCtrl", ['$scope', function($scope){
    console.log("$scope", $scope);
}]);