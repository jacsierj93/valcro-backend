MyApp.controller('notificaciones', ['$scope', '$mdSidenav','setNotif',"$filter", function ($scope, $mdSidenav,setNotif,$filter) {

    $scope.template = "modules/home/notificaciones";

    $scope.alertar = function(){
        $mdSidenav('lyrAlert').open();
    };

    var tipos = ["ok","error","alert","info"];
    // ####################################################################################################
    $scope.alerts = setNotif.listNotif();

    $scope.ok = function(call){
        call.opc.action();
    };

    $scope.closeThis = function(target){
        $scope.alerts[target].splice($scope.selected[target],1);
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

    $scope.launchParam = function(tab){
        console.log("select",tab);
    }


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
                list[obj].unshift({title: "", content: mnsg, opcs: opcs, uid: uid, param: param});
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
                $timeout.cancel(noti[0].timeOut);
                list[type].splice(list[type].indexOf(noti[0]),1);
            }

        }
    }
});