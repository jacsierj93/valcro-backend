MyApp.controller('notificaciones', ['$scope', '$mdSidenav','setNotif',"$filter","$timeout","$interval", function ($scope, $mdSidenav,setNotif,$filter,$timeout,$interval) {

    $scope.template = "modules/home/notificaciones";

    $scope.alertar = function(){
        $mdSidenav('lyrAlert').open();
    };
    // ####################################################################################################
    $scope.alerts = setNotif.listNotif();

    $scope.ok = function(call){
        call.opc.action();
    };

    $scope.closeThis = function(target){
        var curr = angular.copy($scope.alerts[target][$scope.selected[target]]);
        $scope.alerts[target].splice($scope.selected[target],1);

        if(curr.param && "block" in curr.param){
            $scope.block = false;
        }
    };

    // ========================================================================
    // ========================================================================
    $scope.selected = {alert: 0, error: 0, info: 0, ok: 0};
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

 /*   $scope.launchParam = function(tab){
        console.log("select",tab);
    };*/

    $scope.curFocus = angular.element("#test");
    $scope.$watchGroup(['alerts.ok.length','alerts.alert.length','alerts.error.length','alerts.info.length'], function(newValues,old) {
        var open = false;
        var prev = false;
        angular.forEach(newValues, function(v, k) {
            if(v > 0 ){
                open = true;
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
    $scope.block = false;
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
                if(def.count==0){
                    $interval.cancel(def.end);
                    $timeout(function(){
                        angular.element("[autotrigger='"+def.$$hashKey+"']").focus();
                        $timeout(function(){
                            angular.element("[autotrigger='"+def.$$hashKey+"']").click();
                        },100)

                    },0);

                }
            },1000);

        }
        console.log(def);
    };
        $scope.shakeOnBlock = function(){
            console.log("shake");
            console.log(angular.element("#"+$scope.block));

            angular.element("#"+$scope.block).addClass("shake");
            $timeout(function(){
                angular.element("#"+$scope.block).removeClass("shake");
            },1000);
        };

}]);



MyApp.service("setNotif",function($filter,$timeout){
    var list =  {
        ok: [],
        alert: [],
        error: [],
        info: []
    };
    return {
        listNotif : function(){
            return list;
        },
        addNotif : function(obj,mnsg,opcs,param){
            if($filter("customFind")(list[obj],mnsg,function(current,compare){return current.content == compare}).length<=0) {
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