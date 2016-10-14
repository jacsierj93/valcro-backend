/**
 * Created by jacsiel on 04/10/16.
 */

MyApp.controller('prodMainController',['$scope', 'setNotif','masters','$mdSidenav','critForm',function ($scope, setNotif, masters,$mdSidenav,critForm) {
    $scope.clicked = function(){
        $mdSidenav("layer0").open();
    };
    $scope.listLines = masters.query({ type:"prodLines"});
    $scope.tipos = ['texto','numero','selector','checkbox','radio'];
    $scope.opennext = function(){
        $mdSidenav("layer1").open();
    };
    $scope.addField= function(type){
        critForm.add(type);
        //console.log(type)
        /*  var newField = angular.copy(factory[type]);
         newField.campo = name;
         $scope.criteria.push(newFieldw);*/
    };

}]);

MyApp.service("critForm",function(){
    var factory = {
        "texto": {
            campo: "",
            type: {
                tipo: "text",
                directive: 'prevText'
            }
        },

        "selector": {
            campo: "",
            type: {
                tipo: "autocomplete",
                directive: 'prevAutocomplete'
            },
            opciones:[
                {
                    id:1,
                    nombre:'oopcion1'
                },{
                    id:2,
                    nombre:'oopcion2'
                },{
                    id:3,
                    nombre:'oopcion3'
                },
            ]
        }
    };
    var listado = [];
    return {
        add:function(datos){
            var nuevo = angular.copy(factory[datos]);
            nuevo.campo = listado.length+1
            listado.push(nuevo);
        },
        get:function(){
            return listado;
        }
    }
});




MyApp.controller('formPreview',['$scope', 'setNotif','masters','critForm',function ($scope, setNotif, masters,critForm) {

   $scope.criteria = critForm.get();


}]);

MyApp.directive('formPreview', function($http,$timeout) {
        return {
            link:function(scope,elem,attr){
                elem.find(">:not(["+attr.formPreview+"])").remove();
            },
            templateUrl: function(elem, attr) {
                return 'modules/productos/textForm';
            }
        };
});