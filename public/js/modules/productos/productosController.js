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
       },
       {
           campo:"codigo de producto",
           type:{
               tipo:"text",
               directive:'prevText'
           }
       },
       {
           campo:"linea",
           type:{
               tipo:"autocomplete",
               directive:'prevAutocomplete'
           }
       }
   ]


}]);

MyApp.directive('formPreview', function($http,$timeout) {
        return {
            link:function(scope,elem,attr){

                console.log(elem.find(">:not(["+attr.formPreview+"])"))
                elem.find(">:not(["+attr.formPreview+"])").remove();
            },
            templateUrl: function(elem, attr) {
                return 'modules/productos/textForm';
            }
        };
});