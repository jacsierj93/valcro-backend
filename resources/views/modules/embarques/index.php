<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="embarquesController">

    <span ng-click="callInfo()"> ABRIR ALERTA </span>
    <span ng-click="callAlert()"> ABRIR ALERTA2 </span>
    <span ng-click="callInput()"> ABRIR ALERTA2 </span>
    <div ng-controller="notificaciones" ng-include="template"></div>




    <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">

    </md-sidenav>


</div>