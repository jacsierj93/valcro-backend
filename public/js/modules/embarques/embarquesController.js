MyApp.controller('embarquesController', ['$scope', '$mdSidenav', 'setNotif', function ($scope, $mdSidenav, setNotif) {

    $scope.callInfo = function () {
        setNotif.addNotif("alert", "Aqui vas a escribir el mensaje que monstrara el Alerta", [
        {
            name: "Titulo del Boton 1",
            action: function () {
                alert("algo");
            }
        }, {
            name: " Boton 2",
            action: function () {
                console.log("Ejecuta cualquier accion o funcion que se programe aqui.");
            }
        }
        ]);
    }

}]);
