MyApp.controller('embarquesCtrll', ['$scope', '$mdSidenav','setNotif', function ($scope, $mdSidenav,setNotif) {

    var historia = [15];
    $scope.index = index = 0;
    var base = 264;

    $scope.openLayer = function (layr) {
        $scope.showNext(false);
        var layer = layr || $scope.nextLyr;
        if (historia.indexOf(layer) == -1 && layer != "END") {
            var l = angular.element("#" + layer);
            $scope.index++;
            var w = base + (24 * $scope.index);
            l.css('width', 'calc(100% - ' + w + 'px)');
            $mdSidenav(layer).open();
            historia[$scope.index] = layer;
            return true;
        } else if (historia.indexOf(layer) == -1 && layer == "END") {
            closeLayer(true);
        }

        console.log(historia);
    };

    $scope.closeLayer = function (all) {
        if (all) {
            while ($scope.index != 0) {
                var layer = historia[$scope.index];
                historia[$scope.index] = null;
                $scope.index--;
                $mdSidenav(layer).close();
            }
        } else {
            layer = historia[$scope.index];
            historia[$scope.index] = null;
            $scope.index--;
            $mdSidenav(layer).close();
        }
    };

    $scope.showNext = function (status, to) {
        if (status) {
            $scope.nextLyr = to;
            $mdSidenav("NEXT").open()
        } else {
            $mdSidenav("NEXT").close()
        }
    };


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
    var d = new Date();
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

MyApp.controller("test",function($scope,setNotif) {
    $scope.outside = function(){
        setNotif.addNotif('info','prueba111','llamada desde otro controller',[{name:'pushMe',action:function(){alert("desde otro controllador")}},{name:'dont pushMe',action:function(){console.log('WHY?? :(')}}]);
    }
});
