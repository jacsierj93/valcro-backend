MyApp.controller('embarquesController', ['$scope', '$mdSidenav','setNotif', function ($scope, $mdSidenav,setNotif) {
    $scope.callInfo = function(){
        setNotif.addNotif("info", "Esta es una prueba", [{name:"algo",action:function(){alert();}}]);
    }
}]);
