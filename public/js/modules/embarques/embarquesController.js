MyApp.controller('embarquesController', ['$scope', '$mdSidenav','$timeout','$interval','form', 'shipment','setGetShipment','filesService', function ($scope, $mdSidenav,$timeout,$interval,form,shipment, setGetShipment, filesService) {

    //?review
    filesService.setFolder('orders');


    $scope.alerts =[];
    $scope.provSelec ={};
    $scope.provs =[];
    $scope.paises =[];
    $scope.shipment ={objs:{}};
    $scope.bindShipment =setGetShipment.bind();
    $scope.session = {global:'new', isblock: false};
    $scope.permit={
        created:true
    };
    shipment.query({type:"Provider"}, {}, function(response){$scope.provs= response; });

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
        }

    };

    $scope.closeSide = function(){
        $timeout(function () {
            console.log("getvalid",form.getValid());
            if(!form.getValid()){
                interval= null;
                $scope.LayersAction({close:{search:true}});
            }else {
                $scope.validChangeFor();
            }
        },0);

    };
    var interval = null;
    $scope.validChangeFor= function () {
        if(form.getState() == "process" && interval == null){
            interval= $interval(function () {
                console.log("interval", form.getState());
                if(form.getState() == "continue"){
                    $scope.LayersAction({close:{search:true}});
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
            $scope.shipment = setGetShipment.getData();
            $scope.provSelec= $scope.shipment.objs.prov_id;
        }
    });

    $scope.$watchGroup(['module.layer', 'module.index'] ,function(newVal){
        $scope.layer= newVal[0];
        $scope.index= newVal[1];
    });
    $timeout(function(){

    },1000);




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
            $resource.post({type:"Save"},$scope.$parent.shipment, function(response){
                $scope.$parent.session.session_id= response.session_id;
                $scope.$parent.shipment.id = response.id;
                $scope.detailShipmenthead.$setPristine()
            });
        }
    });

    $scope.$parent.OpenShipmentCtrl = function(data){
        $scope.form= 'head';
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

}]);

MyApp.controller('listTariffCtrl',['$scope','shipment','tarifForm',  function($scope, $resource,tarifForm){
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
                if($scope.$parent.shipment.tarifa_id){
                    $scope.setData($scope.$parent.shipment.objs.tarifa_id);
                }
            }
        }});
    };

    $scope.setData = function(data){
        angular.forEach(data, function(v,k){
            $scope.tarifaSelect[k] =v;
        });
    };
    $scope.$watch("tarifaSelect.id", function (newVal, oldVal){

        if(newVal){
            $scope.$parent.shipment.tarifa_id = $scope.tarifaSelect.id;
            $scope.$parent.shipment.objs.tarifa_id=$scope.tarifaSelect;
            $resource.post({type:"Save"},$scope.$parent.shipment);
        }
    });
    $scope.$watch("tarifBind.estado", function (newVal, oldVal) {
        if(newVal && newVal == 'created'){
            $scope.tbl.data.push(tarifForm.get());
            $scope.setData(tarifForm.get());
            tarifForm.setState("waith");
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
        if(!newVal[1]){
            $resource.post({type:"Save"},$scope.$parent.shipment, function(response){
                $scope.$parent.session.session_id= response.session_id;
                $scope.$parent.shipment.id = response.id;
                $scope.tariffF1.$setPristine()
                if($scope.puerto_idSelec!= null){

                }

            });
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
    $scope.$parent.listOrdershipment = function(){
        $scope.LayersAction({open:{name:"listOrdershipment", after: function(){

        }}});
    }
}]);

MyApp.controller('listOrderAddCtrl',['$scope','shipment', function($scope, $resource){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.$parent.listOrderAdd = function(){
        $resource.queryMod({type:"Order", mod:"List", prov_id:$scope.$parent.shipment.prov_id},{},function (response) {
            $scope.tbl.data= response;
        });
        $scope.LayersAction({open:{name:"listOrderAdd", after: function(){

        }}});
    }
}]);

MyApp.controller('listProducttshipmentCtrl',['$scope', function($scope){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.$parent.listProductshipment = function(){
        console.log("tratando de abrir");
        $scope.LayersAction({open:{name:"listProductshipment", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
        }}});
    }
}]);

MyApp.controller('listProductAddCtrl',['$scope', function($scope,$mdSidenav){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.$parent.listProductAdd = function(){
        $scope.LayersAction({open:{name:"listProductAdd", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
        }}});
    };
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

MyApp.controller('CreatProductCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.isOpen = false;
    $scope.prod ={};
    $scope.$parent.CreatProduct = function(){
        $mdSidenav("miniCreatProduct").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniCreatProduct").close().then(function(){
                $scope.isOpen = false;
            });;
        }

    };
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
                            angular.forEach(v.getFilesUp(), function (sv,sf) {
                                $parent.shipment.nro_mb.adjs.push(sv);
                            });
                            if(v.getFilesError().length > 0){
                                console.log("error subiendo archivos", v.getFilesError());
                            }
                        }
                        if(v.getState() == 'waith'){
                            finisAll= false;
                            v.start();
                        }
                        if(v.getState() == 'up'){
                            finisAll= false;
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
            $resource.postMod({type:"Attachment", mod:"Save"},{file:file,documento:doc, embarque_id:$scope.$parent.shipment.id}, function (response) {
                all.push({state:'good', file:response});
                filesUp.push(response);
                if(all.length== files.length){
                    finish= true;
                }
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

MyApp.controller('miniHblCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.$parent.miniHbl = function(){
        $mdSidenav("miniHbl").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniHbl").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('miniExpAduanaCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.$parent.miniExpAduana = function(){
        $mdSidenav("miniExpAduana").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniExpAduana").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('detailOrderShipmentCtrl',['$scope', function($scope){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.tbl ={data:[]};
    $scope.$parent.detailOrderShipment = function(data){
        $scope.$parent.LayersAction({open:{name:"detailOrder", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
        }}});

    };
}]);

MyApp.controller('detailOrderAddCtrl',['$scope', function($scope){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.tbl ={data:[]};
    $scope.$parent.detailOrderAdd = function(data){
        $scope.$parent.LayersAction({open:{name:"detailOrderAdd", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
        }}});

    };
}]);


MyApp.controller('DetailProductShipmentCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};

    $scope.$parent.DetailProductShipment = function(data){
        $mdSidenav("miniDetailProductShipment").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniDetailProductShipment").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
}]);

MyApp.controller('moduleMsmCtrl',['$scope','$mdSidenav','shipment','setGetShipment',function($scope,$mdSidenav, shipment, $model){
    $scope.isOpen = false;
    shipment.query({type:"Notification"}, {}, function(response){$scope.$parent.alerts= response; });
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
            if(!$scope.isLoad){
                $scope.loadData();
            }
            $timeout(function () {
                var elem = angular.element("#miniCreatTariff #head");
                elem[0].click();
            },0);
            formSrv.name = "CreatTariff";
            formSrv.getValid =function () { return (!$scope.head.$pristine || !$scope.bond.$pristine) && $scope.isOpen };

        });
        //return $scope.f;
    };

    $scope.close= function(e){
        if($scope.isOpen){
            if($scope.head.$pristine && $scope.bond.$pristine  ){
                $scope.inClose();
            }else {
                if($scope.head.$valid && $scope.bond.$valid ){
                    formSrv.setState("process");
                    $resource.postMod({type:"Tariff",mod:"Save"},$scope.model,function (response) {
                        $scope.$parent.NotifAction("ok", "Tarifa creada",[],{autohidden:1500});
                        tarifForm.set(response.model);
                        tarifForm.setState("created");
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
    var back = function () {}

    return {
        name:name,

        getValid:function () {
            return false;
        },
        setState: function (data) {
            state= data;
        },
        getState:function () {
            return state;
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
MyApp.service('setGetShipment', function(DateParse, shipment, providers, $q) {

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
                console.log("sdefosdaf", response);
                angular.forEach(response,function (v, k) {
                    if(typeof (v) == 'string' || v == null){
                        Shipment[k]=v;
                    }
                });
                Shipment.objs= {};
                angular.forEach(response.objs,function (v, k) {
                    Shipment.objs[k]=v;
                });
                Shipment.fecha_carga= (response.fecha_carga.value!= null) ? DateParse.toDate(response.fecha_carga.value) : null;
                Shipment.fecha_vnz= (response.fecha_vnz.value!= null) ? DateParse.toDate(response.fecha_vnz.value) : null;
                Shipment.fecha_tienda= (response.fecha_tienda.value!= null) ? DateParse.toDate(response.fecha_tienda.value) : null;
                Shipment.emision = (response.emision!= null) ? DateParse.toDate(response.emision) : null;
                Shipment.containers = response.containers;
                Shipment.nro_mbl = response.nro_mbl;
                Shipment.nro_hbl = response.nro_hbl;
                Shipment.nro_dua = response.nro_dua;

                bindin.estado = true;

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
            forms ={};
            interno= 'new';
            externo= 'new';
            Shipment={};
            bindin.estado=false;
        }


    };
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