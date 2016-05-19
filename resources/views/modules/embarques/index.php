<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="embarquesController">

    <span ng-click="callInfo()"> NUEVA </span>
    <span ng-click="callOk()"> NUEVA2 </span>
    <span ng-click="callErr()"> NUEVA3 </span>
    <span ng-click="callAdv()"> NUEVA4 </span>

    <div ng-controller="notificaciones" ng-include="template"></div>

</div>