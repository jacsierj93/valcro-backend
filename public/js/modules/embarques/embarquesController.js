MyApp.controller('embarquesController', ['$scope', '$mdSidenav','$timeout', 'shipment','setGetShipment', function ($scope, $mdSidenav,$timeout,shipment, setGetShipment) {

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

        if($scope.module.index == 0 || $scope.module.layer == 'listShipment'  ){
            $scope.provSelec= prov;
            $scope.listShipmentCtrl(prov);
        }

    };
    $scope.closeSide = function(){
        $scope.LayersAction({close:true});
    };


    $scope.$watch('bindShipment.estado', function(newVal){
        console.log("bind", newVal);
        if(newVal){
            console.log("bind", newVal);
            $scope.shipment = setGetShipment.getData();
            if($scope.shipment.objs.prov_id){
                $scope.provSelec= $scope.shipment.objs.prov_id;
            }
        }
    });

    $scope.$watchGroup(['module.layer', 'module.index'] ,function(newVal){
        $scope.layer= newVal[0];
        $scope.index= newVal[1];
    });
    $timeout(function(){
        console.log("scope parent", $scope);
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

MyApp.controller('summaryShipmentCtrl', ['$scope',  'shipment','setGetShipment',  function($scope,shipment, setGetShipment ){

    $scope.$parent.summaryShipmentCtrl = function(){
        $scope.LayersAction({open:{name:"summaryShipment", after: function(){
        }}});
    }

}]);

MyApp.controller('OpenShipmentCtrl', ['$scope', '$timeout','shipment','setGetShipment',function($scope,$timeout ,$resource,$model){

    $scope.provSelec = null;
    $scope.provSelecText = undefined;

    $scope.$watch("provSelec", function(newVal){
        console.log("newval", newVal);
        if(newVal != null && newVal.id){
            $resource.query({type:"ProviderDir", id:newVal.id}, {}, function(response){$scope.$parent.provSelec.direcciones= response;});
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
        }else{
            $scope.$parent.provSelec= {};
        }
    });
    $scope.$watch("$parent.provSelec", function(newVal){
      if(newVal.id ){
          if($scope.provSelec == null){
              $scope.provSelec=newVal;
          }else{
              if(newVal.id != $scope.provSelec.id){
                  //$scope.provSelec=newVal;
              }
          }

      }
    });
    $scope.toEditHead= function(id,val){
        if( $scope.session.global != 'new'){
            $model.change("shipment",id,val);
        }
    };
    $scope.form= 'head';
    $scope.$watchGroup(['detailShipmenthead.$valid', 'detailShipmenthead.$pristine'], function(newVal){
         console.log("newval",newVal);
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
        $scope.LayersAction({open:{name:"detailShipment", after: function(){
            if(!data){
                $scope.detailShipmenthead.$setDirty();
            }
        }}});
    };

    $scope.test= function(){
        alert('');
    }

}]);

MyApp.controller('listTariffCtrl',['$scope', function($scope){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.pais_idSelec = null;
    $scope.pais_idText = undefined;
    $scope.puerto_idSelec = null;
    $scope.puerto_idText = undefined;

    $scope.$parent.listTariffCtrl = function(){
        $scope.LayersAction({open:{name:"listTariff", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
        }}});
    }


}]);


MyApp.controller('miniContainerCtrl',['$scope','$mdSidenav', function($scope, $mdSidenav){
    $scope.containers =[];
    $scope.isOpen= false;
    $scope.$parent.miniContainerCtrl = function(){
        $mdSidenav("miniContainer").open().then(function(){
            $scope.isOpen= true;
        });
    }
    $scope.close = function($e){
        if($scope.isOpen){
            $mdSidenav("miniContainer").close().then(function(){
                $scope.isOpen = false;
            });
        }

    }
}]);

MyApp.controller('listOrdershipmentCtrl',['$scope', function($scope){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.$parent.listOrdershipment = function(){
        $scope.LayersAction({open:{name:"listOrdershipment", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
        }}});
    }
}]);

MyApp.controller('listOrderAddCtrl',['$scope', function($scope){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.$parent.listOrderAdd = function(){
        $scope.LayersAction({open:{name:"listOrderAdd", after: function(){
            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            $scope.tbl.data.push({id:-1});
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


MyApp.controller('miniMblCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.$parent.miniMbl = function(){
        $mdSidenav("miniMbl").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
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

    $scope.close =  function(e){
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
                   alert("no implementado")
                }
                break;
        }

    }


}]);

MyApp.controller('CreatTariffCtrl',['$scope','$mdSidenav', function($scope,$mdSidenav){
    $scope.isOpen = false;
    $scope.data ={adjs:[]};
    $scope.form='';

    $scope.$parent.CreatTariff = function(){
        $mdSidenav("miniCreatTariff").open().then(function(){
            $scope.isOpen = true;
        });
    };
    $scope.close= function(){
        if($scope.isOpen){
            $mdSidenav("miniCreatTariff").close().then(function(){
                $scope.isOpen = false;
            });
        }

    };
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


/*
* obtiene el formulario con el que se esta trabajando
* */
MyApp.service('form',function(){
    var name= "none";
    var prototype = {
        isChange : false,
        state: "waith",
        save: function(){
            return true;
        }
    };
    var form = Object.create(prototype);

    return {
        created: function(){
            return Object.create(prototype);
        },
        setForm: function(setform){
            form = setform;
        },
        getForm: function (){
            return form;
        },
        setName: function(formName){
            name = formName;
        },
        getName: name


    }
});

    /*
     Servicio que almacena la informacion del embarque
     */
MyApp.service('setGetShipment', function(DateParse, Order, providers, $q) {

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
            bindin.estado=false;
            Shipment= doc;
            bindin.estado=true;

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