var main = angular.module('main', ['ngMaterial', 'ngMessages', 'ngRoute','ngResource']);

main.controller('AppCtrl', function ($scope,$mdSidenav) {
    /*$scope.project = {
     description: 'Nuclear Missile Defense System',
     rate: 500
     };*/

    $scope.secciones = [
        {
            secc: 'Inicio',
            url: 'modules/home/index'
        }, {
            secc: 'Proveedores',
            url: 'modules/proveedores/index'
        }, {
            secc: 'Productos',
            url: 'modules/home/logedout'
        }, {
            secc: 'Pagos',
            url: 'modules/home/404'
        }];
    $scope.seccion = $scope.secciones[0];

    $scope.seccLink = function (indx){
        $scope.seccion = $scope.secciones[indx.$index];
    }

    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    $scope.toggleLeft = buildToggler('left');
    $scope.toggleRight = buildToggler('right');
    $scope.toggleOtro = buildToggler('otro');
    function buildToggler(navID) {
        return function() {
            // Component lookup should always be available since we are not using `ng-if`
            $mdSidenav(navID).toggle();
        }
    }
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3
    //###########################################################################################3


});