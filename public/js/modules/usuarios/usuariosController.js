/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
MyApp.factory('users', ['$resource',
    function ($resource) {
        return $resource('usrs/:type/:id', {}, {

            query: {method: 'GET', params: {type: "",id:""}, isArray: true},
            post: {method: 'POST', params: {type: "",id:""}, isArray: false}
        });
    }
]);



MyApp.controller('mainUsersController', ['$scope', 'setNotif', function ($scope, setNotif) {
        $scope.index = 1;
        $scope.openForm = function (id) {
            $scope.LayersAction({open: {name: "userLayer3"}});
        };


    }]);

MyApp.controller('listUsersController', ['$scope', 'setNotif' ,'users' , function ($scope, setNotif, users) {
        console.log(users.query)
        users.query({ type:"listUsuarios"},function(data){
            $scope.users = data;
            console.log($scope.users);
        });
    }]);


MyApp.controller('userForm', ['$scope', 'setNotif', 'users', function ($scope, setNotif, users) {
        ////lista de USUARIOS
        users.query({ type:"cargos"},function(data){
            $scope.cargos = data;
            console.log($scope.cargos);
        });
    }]);