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
               directive:'prevComplete'
           }
       }
   ]


}]);

MyApp.directive('formPreview', function() {
        return {
            link:function(scope,elem,attr){
                attr.directive=scope.$eval(attr.formPreview);
            },
            templateUrl: function(elem, attr) {
                //console.log(scope.$eval(attr.formPreview))
                if(attr.formPreview == "prevText"){
                    return 'modules/productos/previewFormTemplates/textForm';
                }else if(attr.formPreview == "autocomplete"){
                    return 'modules/productos/previewFormTemplates/autocompleteForm';
                }
            }
        };
});