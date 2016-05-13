MyApp.controller('embarquesCtrll', ['$scope', '$mdSidenav', function ($scope, $mdSidenav) {

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


}]);