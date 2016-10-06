MyApp.controller('embarquesController', ['$scope', '$mdSidenav', 'shipment','setGetShipment', function ($scope, $mdSidenav,shipment, setGetShipment) {

    $scope.provSele ={};
    $scope.provs =[];
    $scope.paises =[];
    $scope.shipment ={};
    $scope.bindShipment =setGetShipment.bind()
    $scope.session = {global:'new', isblock: false};
    $scope.permit={
        created:true
    };
    shipment.query({type:"Provider"}, {}, function(response){$scope.provs= response; });

    $scope.toEditHead= function(id,val){
        if( $scope.session.global != 'new'){
            setGetShipment.change("shipment",id,val);
        }
    };
    $scope.search = function(){
       var data =[];
        if($scope.provs.length > 0){
            return $scope.provs;
        }
        return data;
    }

    $scope.setProvedor = function(prov){
        $scope.provSele= prov;
        $scope.listShipmentCtrl(prov);
    };
    $scope.closeSide = function(){
        $scope.LayersAction({close:true});
    };


    $scope.$watch('bindShipment.estado', function(newVal){
        console.log("bind", newVal);
        if(newVal){
            console.log("bind", newVal);
            $scope.shipment = setGetShipment.getShipment();
        }
    });

}]);

MyApp.controller('listShipmentCtrl', ['$scope','shipment','setGetShipment',  function ($scope,shipment, setGetShipment) {
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.$parent.listShipmentCtrl = function(prov){
        $scope.LayersAction({open:{name:"listShipment", after: function(){

            $scope.tbl.data.splice(0,$scope.tbl.data.length);
            var demo = {
                titulo:"demo ",
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

        }}});

    }
    $scope.setShipment = function (data){
        setGetShipment.setShipment(data);
        $scope.summaryShipmentCtrl();
    }
}]);

MyApp.controller('summaryShipmentCtrl', ['$scope',  'shipment','setGetShipment',  function($scope,shipment, setGetShipment ){

    $scope.$parent.summaryShipmentCtrl = function(){
        $scope.LayersAction({open:{name:"summaryShipment", after: function(){
        }}});
    }

}]);

MyApp.controller('OpenShipmentCtrl', ['$scope', function($scope){
    $scope.autoCp ={
        provSele:{
            select:null,
            text:undefined
        },
        pais_id:{
            select:null,
            text:undefined
        }

    };
    $scope.$parent.OpenShipmentCtrl = function(){
        $scope.LayersAction({open:{name:"detailShipment", after: function(){


        }}});
    }
}]);

MyApp.controller('listTariffCtrl',['$scope', function($scope){
    $scope.tbl ={
        order:"id",
        filter:{},
        data:[]
    };
    $scope.listTariffCtrl = function(){
        $scope.LayersAction({open:{name:"listShipment", after: function(){}}});
    }



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
    var form = Object.create(prototype);;

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
        setShipment : function(doc){
            bindin.estado=false;
            Shipment= doc;
            bindin.estado=true;

        },
        reload: function(doc){
            bindin.estado=false;
            bindin.estado=true;
        },
        getShipment : function(){
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

MyApp.directive('gridOrderBy', function() {
    return {
        required:"ngModel",
        replace: true,
        transclude: true,
        link: function(scope, elem, attr, ctrl){
            console.log("ctrl", ctrl);
            console.log("attr", attr);
        },
        template: function(){
            return "<div>hi</div>";
        }
    };
});