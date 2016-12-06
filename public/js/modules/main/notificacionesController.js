MyApp.controller('notificaciones', ['$scope', '$mdSidenav','setNotif',"$filter","$timeout","$interval",'masters','App', function ($scope, $mdSidenav,setNotif,$filter,$timeout,$interval,masters,App) {

    $scope.template = "modules/home/notificaciones";

    $scope.alertar = function(){
        $mdSidenav('lyrAlert').open();
    };
    // ####################################################################################################
    $scope.alerts = setNotif.listNotif();

    $scope.ok = function(call, data){

        if(call.opc.action){
            call.opc.action(call,data);
            $scope.saveAnswer(call,data );
        }else{
            $scope.curFocus.focus();
        }



    };

    $scope.closeThis = function(target){
        var curr = angular.copy($scope.alerts[target][$scope.selected[target]]);
        $scope.alerts[target].splice($scope.selected[target],1);

        if(curr.param && "block" in curr.param){

            $scope.block = false;
            //$scope.block--;
        }
    };

    // ========================================================================
    // ========================================================================
    $scope.selected = {alert: 0, error: 0, info: 0, ok: 0, input:0};
    // ========================================================================
    $scope.alertNext = function (obj) {
        var total = $scope.alerts[obj].length - 1;
        var actual = $scope.selected[obj];
        if (total == actual) {
            $scope.selected[obj] = 0;
        } else {
            $scope.selected[obj] = actual + 1;
        }
    };
    // ========================================================================
    $scope.alertPrev = function (obj) {
        var total = $scope.alerts[obj].length - 1;
        var actual = $scope.selected[obj];
        if (actual == 0) {
            $scope.selected[obj] = total;
        } else {
            $scope.selected[obj] = actual - 1;
        }
    };

    $scope.curFocus = null;
    var names = ["ok","alert","error","info","input"];
    $scope.$watchGroup(['alerts.ok.length','alerts.alert.length','alerts.error.length','alerts.info.length', 'alerts.input.length'], function(newValues,old) {
        var open = false;
        var prev = false;
        angular.forEach(newValues, function(v, k) {
            /*escucha nuevas notificaciones e invoca los parametros*/
            if(old[k]<v){
                //console.log("nueva")
                $scope.invoiceParams($scope.alerts[names[k]][v-1]);
            }
            if(v > 0 ){
                open = true;
                $scope.curFocus = angular.element(":focus");
                $mdSidenav('lyrAlert').open();
                //return false;
            }
            if(old[k]>0){
                prev = true;
            }
            if((k == newValues.length-1 && !open) && prev){
                $mdSidenav('lyrAlert').close();
            }

        });

    });

    /*comiensan las funciones para la configuracion de parametros de las notificaciones*/
    $scope.block = 0;
    $scope.invoiceParams = function(notif){

        if(params = notif.param){
            /*            if ("autohidden" in params) {
             notif.timeOut = $timeout(function () {

             list[notif.type].splice(list[notif.type].indexOf($filter("customFind")(list[notif.type], uid, function (current, compare) {
             return current.uid == compare
             })[0]), 1);
             }, params.autohidden);
             }*/



            if("block" in params){
                angular.element(":focus").blur();
                $scope.block = notif.type;
                //$scope.block++;
                $timeout(function(){
                    angular.element("#lyrAlert").find(".alertTextOpcs:visible > div").first().focus();
                },50);

            }
            if("inputTitle" in params){
                $scope.inputTitle = params.inputTitle;
            }

        };

        var def = $filter("customFind")(notif.opcs,"default",function(current,compare){return (compare in  current);})[0];
        if(def){
            def.count = def.default;
            def.end = $interval(function(){
                def.count--;
                /* if(def.count==1){
                 angular.element("[autotrigger='"+def.$$hashKey+"']").focus();
                 }*/
                if(def.count<=0){
                    $interval.cancel(def.end);
                    $timeout(function(){
                        //angular.element("[autotrigger='"+def.$$hashKey+"']").focus();
                        $timeout(function(){
                            angular.element("[autotrigger='"+def.$$hashKey+"']").trigger("click");
                        },100)

                    },0);

                }
            },1000);

        }
        //console.log(def);
    };
    $scope.shakeOnBlock = function(){
        angular.element("#"+$scope.block).addClass("shake");
        $timeout(function(){
            angular.element("#"+$scope.block).removeClass("shake");
        },1000);
    };

    $scope.isBlocked = function(){
        return ($filter('customFind')($scope.alerts.alert,'block',function (x,z){
            return (x.param && z in x.param);
        }).length>0
            ||
        $filter('customFind')($scope.alerts.error,'block',function (x,z){
            
            return (x.param && z in x.param);
        }).length>0)

    };

    $scope.saveAnswer = function (call, data) {
        if(data.noti.param && data.noti.param.save){


            $timeout(function () {
                var send = {
                    texto:data.noti.content,modulo: App.getSeccion().secc};

                    angular.forEach(data.noti.param.save, function (v, k) {
                        send[k]= v;
                    });
                send.items = [];
                send.items.push({texto:call.opc.name, isSelecionada:1});
                angular.forEach(data.noti.opcs , function (v, k) {
                    if(v.name != call.opc.name){
                        send.items.push({texto:v.name, isSelecionada:0});
                    }

                });
                masters.post({type:"alerts",id:"save"},send);
            },0);
               }
    };
/*
    $scope.$watch("alerts.input.length", function(newVal){

    });*/

}]);



MyApp.service("setNotif",function($filter,$timeout){
    var list =  {
        ok: [],
        alert: [],
        error: [],
        info: [],
        input: []
    };
    return {
        listNotif : function(){
            return list;
        },
        addNotif : function(obj,mnsg,opcs,param){
            if($filter("customFind")(list[obj],mnsg,function(current,compare){return current.content == compare}).length<=0 && list.error.length == 0) {
                var Self = this;
                var uid = Math.random();

                list[obj].unshift({title: "", content: mnsg, opcs: opcs, uid: uid, param: param,type:obj});
                if (param && "autohidden" in param) {
                    list[obj][0].timeOut = $timeout(function () {
                        list[obj].splice(list[obj].indexOf($filter("customFind")(list[obj], uid, function (current, compare) {
                            return current.uid == compare
                        })[0]), 1);
                    }, param.autohidden);
                }
            }
        },
        hideByContent: function(type,content){
            var noti = $filter("customFind")(list[type],content,function(current,compare){return current.content == compare});
            if(noti.length>0){
                $timeout(function(){
                    $timeout.cancel(noti[0].timeOut);
                    list[type].splice(list[type].indexOf(noti[0]),1);
                },0);

            }

        }
    }
});