function DemoCtrl3($timeout, $q) {
    var self = this;
    // list of `state` value/display objects
    self.states = loadAll();
    self.selectedItem = null;
    self.searchText = null;
    self.querySearch = querySearch;
    // ******************************
    // Internal methods
    // ******************************
    /**
     * Search for states... use $timeout to simulate
     * remote dataservice call.
     */
    function querySearch(query) {
        var results = query ? self.states.filter(createFilterFor(query)) : self.states;
        //var deferred = $q.defer();
        //$timeout(function () {
        //deferred.resolve(results);
        //}, Math.random() * 1000, false);
        //return deferred.promise;
        return results;
    }

    /**
     * Build `states` list of key/value pairs
     */
    function loadAll() {
        var allStates = 'Alabama, Alaska, Arizona, Arkansas, California, Colorado, Connecticut, Delaware,\
              Florida, Georgia, Hawaii, Idaho, Illinois, Indiana, Iowa, Kansas, Kentucky, Louisiana,\
              Maine, Maryland, Massachusetts, Michigan, Minnesota, Mississippi, Missouri, Montana,\
              Nebraska, Nevada, New Hampshire, New Jersey, New Mexico, New York, North Carolina,\
              North Dakota, Ohio, Oklahoma, Oregon, Pennsylvania, Rhode Island, South Carolina,\
              South Dakota, Tennessee, Texas, Utah, Vermont, Virginia, Washington, West Virginia,\
              Wisconsin, Wyoming';
        return allStates.split(/, +/g).map(function (state) {
            return {
                value: state.toLowerCase(),
                display: state
            };
        });
    }

    /**
     * Create filter function for a query string
     */
    function createFilterFor(query) {
        var lowercaseQuery = angular.lowercase(query);
        return function filterFn(state) {
            return (state.value.indexOf(lowercaseQuery) === 0);
        };
    }
}

MyApp.controller('DemoCtrl3', DemoCtrl3);


MyApp.controller('DemoCtrl4',['$http',function($http) {
    var self = this;

    self.readonly = false;
    self.selectedItem = null;
    self.searchText = null;
    self.querySearch = querySearch;
    self.vegetables = loadVegetables($http);
    self.selectedVegetables = [];
    self.numberChips = [];
    self.numberChips2 = [];
    self.numberBuffer = '';
    self.autocompleteDemoRequireMatch = true;
    self.transformChip = transformChip;

    /**
     * Return the proper object when the append is called.
     */
    function transformChip(chip) {
        // If it is an object, it's already a known chip
        if (angular.isObject(chip)) {
            return chip;
        }

        // Otherwise, create a new one
        return {name: chip, type: 'new'}
    }

    /**
     * Search for vegetables.
     */
    function querySearch(query) {
        var results = query ? self.vegetables.filter(createFilterFor(query)) : [];
        return results;
    }

    /**
     * Create filter function for a query string
     */
    function createFilterFor(query) {
        var lowercaseQuery = angular.lowercase(query);

        return function filterFn(vegetable) {
            return (vegetable._lowername.indexOf(lowercaseQuery) === 0);
        };

    }

    function loadVegetables($http) {

        console.log("idiomas");
        //var veggies;

        /*$http({
            method: 'GET',
            url: 'catalogs/positionList'
        }).then(function successCallback(response) {
           console.log(response.data);
            veggies = response.data;
        }, function errorCallback(response) {
            console.log("error=>",response)
        });*/


        var veggies = [
            {
                'name': 'Español'
            },
            {
                'name': 'Ingles'
            },
            {
                'name': 'Chino'
            },
            {
                'name': 'Arabe'
            },
            {
                'name': 'Portugues'
            }
        ];

        return veggies.map(function (veg) {
            veg._lowername = veg.name.toLowerCase();
            return veg;
        });
    }
}]);


/*
MyApp.controller('DemoCtrl4', ['$http',DemoCtrl4($http)]);


va.controller('directorsCtrl', ['$scope', '$http', '$location', '$routeParams', '$resource',
    function($scope, $http, $location, $routeParams, $resource){

}*/