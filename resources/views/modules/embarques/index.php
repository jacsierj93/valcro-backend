<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="embarquesController">

    <span ng-click="callInfo()"> ABRIR ALERTA </span>

    <div ng-controller="notificaciones" ng-include="template"></div>

</div>