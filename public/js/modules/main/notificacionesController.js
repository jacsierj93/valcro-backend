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
        angular.forEach(newValues, function(v, k) {
            if(v > 0 ){
                open = true;
                $mdSidenav('lyrAlert').open();
                //return false;
            }
            if(k == newValues.length-1 && !open){
                console.log(open);
                $mdSidenav('lyrAlert').close();
            }

            /*
            if(v!=old[k]){
                var curr = $scope.alerts[tipos[k]][v-1];
                if(curr.param.autohidden){

                    setTimeout(function(trg,hash){
                        console.log($scope.alerts[trg].indexOf($filter("customFind")($scope.alerts[trg],hash,function(current,compare){return current.$$hashKey == compare})[0]))
                        $scope.alerts[trg].splice($scope.alerts[trg].indexOf($filter("customFind")($scope.alerts[trg],hash,function(current,compare){return current.$$hashKey == compare})[0]),1);
                        console.log($scope.alerts[trg]);
                    },1000,tipos[k],curr.$$hashKey)
                }
            }*/
        });

    });

}]);


MyApp.service("setNotif",function($filter){
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
            list[obj].unshift({title:"", content: mnsg, opcs: opcs,param:{autohidden:2000}});
            /*setTimeout(function(id,trg){
                //console.log($filter("customFind")(list[obj],id,function(current,compare){return current.uid == compare}));
                console.log(Self);
                Self.delNotif(trg,list[trg].indexOf($filter("customFind")(list[obj],id,function(current,compare){return current.uid == compare})[0]))
            },3000,uid,obj);*/
        },
        delNotif:function(trg,item){
            list[trg].splice(item,1);
            console.log(list[trg])
        }
    }
});