<md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="sideFiles" id="sideFiles">

    <md-content  layout="row" flex class="sideNavContent">
        <div layout="column" flex="">
            <div layout="row">
                <div layout="column" layout-align="center center" ng-click="close()" >
                    <span class="icon-Inactivo" style="font-size: 24px;color: black;"></span>
                </div>
                <div class="titulo_formulario" layout="column" flex layout-align="start start" style="heigth:39px;">
                    <div>
                        {{titulo}}
                    </div>
                </div>
            </div>

            <div style="padding: 2px;" layout="row">
            <div ngf-drop ngf-select="upload($files)" ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                 ngf-multiple="true" ngf-allow-dir="true" accept="image/*,application/pdf">
                insertar archivo
            </div>
            </div>
            <div flex="" style="overflow: auto;">

            <md-content >
                <div class="imgItem" ng-repeat="item in pitures ">
                    <img ng-src="images/thumbs/{{item.thumb}}"/>
                </div>
            </md-content>
            </div>
        </div>

    </md-content>
</md-sidenav>
