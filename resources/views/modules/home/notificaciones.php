<md-sidenav layout="row" style="top: calc(100% - 144px); height: 96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="lyrAlert" id="lyrAlert">
    <!-- OK   ############################################################################################## -->
    <div class="alertBox alertOkColor" flex ng-show="alerts.ok.length > 0" layout="row">
        <div class="alertPrevArrow" ng-click="alertPrev('ok')" ng-show="alerts.ok.length > 1"></div>
        <md-tabs class="alertContainer" layout="column" md-selected="selected.ok" flex>
            <md-tab label="{{tab.title}}" layout="column" class="alertItem" flex ng-repeat="tab in alerts.ok">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('ok');ok(this)" >
                        {{opc.name}}
                    </div>
                </div>
            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('ok')" ng-show="alerts.ok.length > 1" style="width: 50px;">
            <div  ng-show="alerts.ok.length>1">{{selected.ok + 1}}/{{alerts.ok.length}}</div>
        </div>
    </div>
    <!-- ALERT ############################################################################################## -->
    <div class="alertBox alertAlertColor" flex ng-show="alerts.alert.length > 0" layout="row">
        <div class="alertPrevArrow" ng-click="alertPrev('alert')" ng-show="alerts.alert.length > 1"></div>
        <md-tabs class="alertContainer" layout="column" md-selected="selected.alert" flex>
            <md-tab label="{{tab.title}}" layout="column" class="alertItem" ng-repeat="tab in alerts.alert" md-on-select="launchParam(this)">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('alert');ok(this)">
                        {{opc.name}}
                    </div>
                </div>
            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('alert')" ng-show="alerts.alert.length > 1" style="width: 50px;">
            <div  ng-show="alerts.alert.length>1">{{selected.alert + 1}}/{{alerts.alert.length}}</div>
        </div>
    </div>
    <!-- ERROR ############################################################################################## -->
    <div class="alertBox alertErrorColor" flex ng-show="alerts.error.length > 0" layout="row">
        <div class="alertPrevArrow" ng-click="alertPrev('error')" ng-show="alerts.error.length > 1"></div>
        <md-tabs class="alertContainer"  md-selected="selected.error" flex>
            <md-tab label="{{tab.title}}" class="alertItem" ng-repeat="tab in alerts.error">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('error');ok(this)">
                        {{opc.name}}
                    </div>
                </div>
            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('error')" ng-show="alerts.error.length > 1" style="width: 50px;">
            <div  ng-show="alerts.error.length>1">{{selected.error + 1}}/{{alerts.error.length}}</div>
        </div>
    </div>
    <!-- INFO ############################################################################################## -->
    <div class="alertBox alertInfoColor" flex ng-show="alerts.info.length > 0" layout="row">
        <div class="alertPrevArrow" ng-click="alertPrev('info')" ng-show="alerts.info.length > 1"></div>
        <md-tabs class="alertContainer" md-selected="selected.info" flex>
            <md-tab label="{{tab.title}}" class="alertItem" ng-repeat="tab in alerts.info">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('info');ok(this)" >
                        {{opc.name}}
                    </div>
                </div>

            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('info')" ng-show="alerts.info.length > 1" style="width: 50px;">
            <div  ng-show="alerts.info.length>1">{{selected.info + 1}}/{{alerts.info.length}}</div>
        </div>
    </div>
</md-sidenav>