MyApp.controller('notificaciones', ['$scope', '$mdSidenav','setNotif', function ($scope, $mdSidenav,setNotif) {

    $scope.alertar = function(){
        $mdSidenav('lyrAlert').open();
    }
    // ####################################################################################################
    $scope.alerts = setNotif.listNotif();

    $scope.ok = function(call){
        call.opc.action();
    }

    $scope.closeThis = function(target){
      $scope.alerts[target].splice($scope.selected[target],1);
    };

    $scope.callInfo = function(){
        setNotif.addNotif('info','prueba111','Mensajeee de prueba con texto ramdom'+count,[{name:'pushMe',action:function(){console.log('thanks')}},{name:'dont pushMe',action:function(){console.log('WHY?? :(')}}]);
        count ++;
    };
    var count =0;
    $scope.callOk = function(){
        setNotif.addNotif('ok','pruebaOK','ad doloren ipsun :) '+count,[{name:'me! me!',action:function(){console.log('wiiii')}},{name:'nos',action:function(){console.log('hahah')}}]);
        count++;
    };
    $scope.callAdv = function(){
        setNotif.addNotif('alert','pruebaOK','ad doloren ipsun :) '+count,[{name:'me! me!',action:function(){console.log('wiiii')}},{name:'nos',action:function(){console.log('hahah')}}]);
        count++;
    };
    $scope.callErr = function(){
        setNotif.addNotif('error','pruebaOK','ad doloren ipsun :) '+count,[{name:'me! me!',action:function(){console.log('wiiii')}},{name:'nos',action:function(){console.log('hahah')}}]);
        count++;
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

    /*$scope.$watch('alerts', function (current, old) {
        console.log(current);
    });*/

    $scope.$watchGroup(['alerts.ok.length','alerts.alert.length','alerts.error.length','alerts.info.length'], function(newValues) {
        // newValues array contains the current values of the watch expressions
        // with the indexes matching those of the watchExpression array
        // i.e.
        // newValues[0] -> $scope.foo
        // and
        // newValues[1] -> $scope.bar
        console.log(newValues)

        var open = false;
        angular.forEach(newValues, function(value, key) {
            if(value > 0 ){
                open = true;
                $mdSidenav('lyrAlert').open();
                return false;
            }
            if(key == newValues.length-1 && !open){
                $mdSidenav('lyrAlert').close();
            }
        });

        //console.log(newValues);

    });


    /*$scope.$watch('selectedIndex', function (current, old) {
     previous = selected;
     selected = tabs[current];
     if (old + 1 && (old != current)) $log.debug('Goodbye ' + previous.title + '!');
     if (current + 1)                 $log.debug('Hello ' + selected.title + '!');
     });*/


}]);

MyApp.service("setNotif",function(){
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
       addNotif : function(obj,title, view,opcs){
           list[obj].unshift({title: title, content: view, opcs: opcs});
       }
   }

});


MyApp.controller('embarquesController', ['$scope', '$mdSidenav','setNotif', function ($scope, $mdSidenav,setNotif) {

    $scope.callInfo = function(){

        setNotif.addNotif("info","", "Esta es una prueba", [{name:"algo",action:function(){alert();}}]);
    }

}]);
