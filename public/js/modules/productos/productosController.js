/**
 * Created by jacsiel on 04/10/16.
 */

MyApp.controller('prodMainController',['$scope', 'setNotif','masters','$mdSidenav',function ($scope, setNotif, masters,$mdSidenav) {
    $scope.clicked = function(){
        $mdSidenav("layer0").open();
    };
    $scope.listLines = masters.query({ type:"prodLines"});
    $scope.tipos = ['texto','numero','selector','checkbox','radio'];
    $scope.opennext = function(){
        $mdSidenav("layer1").open();
    }
}]);


MyApp.controller('formPreview',['$scope', 'setNotif','masters',function ($scope, setNotif, masters) {
   $scope.criteria = [
       {
           campo:"serie",
           type:{
               tipo:"text",
               directive:'prevText'
           }
       }
   ]


}]);

MyApp.directive('prevText', function() {
        return {
            templateUrl: function(elem, attr) {
                return 'modules/productos/formPreviewTemplates.html#text';
            },
            link:function(){
                alert();
            }
        };
});