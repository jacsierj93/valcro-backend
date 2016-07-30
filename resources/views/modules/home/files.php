<md-sidenav layout="row" class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="sideFiles" id="sideFiles" click-out="closeSideFile($event)">

    <md-content  layout="row" flex class="sideNavContent" >
        <div layout="row" flex style="padding: 4px; overflow-x: hidden;">
            <!--<div class="activeleft "
                 ng-click="closeSide()" ng-class="{'white': ('detalleDoc'!=layer)}"  style="" ng-show="expand"></div>-->
            <div layout="column" style="width: 326px;">
                <div layout="row" style="min-height: 36px;">
                    <!--<div layout="column" layout-align="center center" ng-click="closeSideFile()" ng-show="!expand">
                        <span class="icon-Inactivo" style="font-size: 24px;color: black;"></span>
                    </div>-->
                    <div class="titulo_formulario" layout="column" flex layout-align="start start" style="heigth:39px;">
                        <div>
                            {{titulo}}
                        </div>
                    </div>
                </div>

                <div style="padding: 2px;; min-height: 56px;" layout="row" ng-show="allowUpload.val">
                    <div ngf-drop ngf-select="upload($files)" ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                         ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                        insertar archivo
                    </div>
                </div>
                <div flex="" style="overflow: auto; padding: 0px 4px 4px 4px; overflow: auto;">
                    <div class="imgItem" ng-repeat="item in pitures " ng-click="selectImg(item)">
                        <img ng-src="images/thumbs/{{item.thumb}}"/>
                    </div>
                </div>
            </div>
            <div flex="" layout="column"layout-align="space-between stretch" ng-show="expand">
                <div layout="row" style="min-height: 24px;"></div>
                <div layout="column" flex style="padding:16px;">
                    <div style="overflow: auto;">
                    <div style="width: 100%; height: 100%;">
                        <img style="width: 100%; height: 100%;" ng-src="{{imgSelec}}" ng-show="imgSelec" >
                        <iframe style="width: 100%; height: 100%;"  ng-src="{{pdfSelec}}" ng-show="pdfSelec">

                        </iframe>
                    </div>
                    </div>
                </div>
                <div layout="row" layout-align="center center" style="min-height: 56px;">
                    <div>%%</div><div style="width: 24px;"></div><div>%%</div>
                </div>
            </div>
        </div>

    </md-content>
</md-sidenav>
