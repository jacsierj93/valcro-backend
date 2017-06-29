<md-sidenav  layout="row" class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="sideFiles" id="sideFiles" click-out="closeSideFile($event)">

    <md-content  layout="row" flex class="sideNavContent" ng-init="localizame = true" >
        <div layout="row" flex style="padding: 4px; overflow-x: hidden;">
            <!--<div class="activeleft "
                 ng-click="closeSide()" ng-class="{'white': ('detalleDoc'!=layer)}"  style="" ng-show="expand"></div>-->
            <vld-file-up-img style="border-bottom: solid 0.1px #ccc;" funciones="AdjFn" up-model="upModel" fn-file-up="fnfile" key="MailCtrl" up-adjs="loades" storage="proveedores"></vld-file-up-img>
        </div>

    </md-content>
</md-sidenav>
