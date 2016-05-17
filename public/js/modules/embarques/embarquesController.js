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


    $scope.alerts = {
        alert: [true, [
            {title: 'One', content: "Tabs will become paginated if there isn't enough room for them."},
            {title: 'Two', content: "You can swipe left and right on a mobile device to change tabs."},
            {title: 'Three', content: "You can bind the selected tab via the selected attribute on the md-tabs element."}
        ]],
        error: [true, [{title: 'One', content: "Tabs will become paginated if there isn't enough room for them."}]],
        info: [true, [{title: 'Three', content: "You can bind the selected tab via the selected attribute on the md-tabs element."}]]
    };

    $scope.addTab = function (title, view) {
        view = view || title + " Content View";
        tabs.push({title: title, content: view, disabled: false});
    };

    console.log($scope.alerts);


    var tabs = [
            {title: 'One', content: "Tabs will become paginated if there isn't enough room for them."},
            {title: 'Two', content: "You can swipe left and right on a mobile device to change tabs."},
            {title: 'Three', content: "You can bind the selected tab via the selected attribute on the md-tabs element."}
        ],
        selected = null,
        previous = null;
    $scope.tabs = tabs;
    $scope.selectedIndex = 2;

    $scope.$watch('selectedIndex', function (current, old) {
        previous = selected;
        selected = tabs[current];
        if (old + 1 && (old != current)) $log.debug('Goodbye ' + previous.title + '!');
        if (current + 1)                 $log.debug('Hello ' + selected.title + '!');
    });


}]);