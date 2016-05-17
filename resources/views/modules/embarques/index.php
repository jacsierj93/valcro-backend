<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="embarquesCtrll">
    <span ng-click="openLayer('lyrAlert')"> ABRIRRRR </span>

    <md-sidenav layout="row" style="top: calc(100% - 128px); height: 80px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="lyrAlert" id="lyrAlert">
        <div flex ng-show="alerts.alert[0]">
            <md-tabs style="background-color: yellow;" flex>
                <md-tab label="{{tab.title}}" ng-repeat="tab in alerts.alert[1]">
                    {{tab.content}}
                </md-tab>
            </md-tabs>
        </div>
        <div flex ng-show="alerts.error[0]">
            <md-tabs style="background-color: #ac2925;" flex>
                <md-tab label="{{tab.title}}" ng-repeat="tab in alerts.error[1]">
                    {{tab.content}}
                </md-tab>
            </md-tabs>
        </div>
        <div flex ng-show="alerts.info[0]">
            <md-tabs style="background-color: transparent;" flex>
                <md-tab label="{{tab.title}}" ng-repeat="tab in alerts.info[1]">
                    {{tab.content}}
                </md-tab>
            </md-tabs>
        </div>
    </md-sidenav>

</div>