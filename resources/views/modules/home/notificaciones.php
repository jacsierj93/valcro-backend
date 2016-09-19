<div id="notifBlock" ng-click="shakeOnBlock()" style="
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0px;
    left: 0px;
    z-index: 99;
    background: transparent;
    cursor: default;
" ng-show="(block>0)">

</div>
<md-sidenav md-on-close="curFocus[0].focus()" layout="row" style="top: calc(100% - 120px); height: 72px; margin-bottom:24px; width: calc(100% - {{264 + (24*$parent.index)}}px); z-index:100" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="lyrAlert" id="lyrAlert">
    <!-- OK   ############################################################################################## -->
    <input id="test" type="hidden" md-autofocus> <!-- set autofocus a campo hidden para evitar perdida de focus en campo actual-->
    <div class="alertBox alertOkColor" flex ng-show="alerts.ok.length > 0" layout="row" id="ok">
        <div class="alertPrevArrow" ng-click="alertPrev('ok')" ng-show="alerts.ok.length > 1"></div>
        <md-tabs class="alertContainer" layout="column" md-selected="selected.ok" flex>
            <md-tab label="{{tab.title}}" layout="column" class="alertItem" flex ng-repeat="tab in alerts.ok">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('ok');ok(this)" skip-notif>
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
    <div class="alertBox alertAlertColor" flex ng-show="alerts.alert.length > 0" layout="row" id="alert">
        <div class="alertPrevArrow" ng-click="alertPrev('alert')" ng-show="alerts.alert.length > 1"></div>
        <md-tabs class="alertContainer" layout="column" md-selected="selected.alert" flex>
            <md-tab label="{{tab.title}}" layout="column" class="alertItem" ng-class="{'toBlock':tab.param.block}" ng-repeat="tab in alerts.alert" md-on-select="launchParam(this)">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex layout="row" ng-repeat="opc in tab.opcs" autotrigger="{{opc.$$hashKey}}" tabindex="0" ng-click="closeThis('alert');ok(this)" skip-notif>
                        <div style="width:32px" ng-show="opc.default"><span class="icon-Tiempo" >{{opc.count}}</span></div>
                        <div flex>{{opc.name}}</div>
                    </div>
                </div>
            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('alert')" ng-show="alerts.alert.length > 1" style="width: 50px;">
            <div  ng-show="alerts.alert.length>1">{{selected.alert + 1}}/{{alerts.alert.length}}</div>
        </div>
    </div>
    <!-- ERROR ############################################################################################## -->
    <div class="alertBox alertErrorColor" flex ng-show="alerts.error.length > 0" layout="row" id="error">
        <div class="alertPrevArrow" ng-click="alertPrev('error')" ng-show="alerts.error.length > 1"></div>
        <md-tabs class="alertContainer"  md-selected="selected.error" flex>
            <md-tab label="{{tab.title}}" class="alertItem" ng-class="{'toBlock':tab.param.block}" ng-repeat="tab in alerts.error">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('error');ok(this)" skip-notif>
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
    <div class="alertBox alertInfoColor" flex ng-show="alerts.info.length > 0" layout="row" id="info">
        <div class="alertPrevArrow" ng-click="alertPrev('info')" ng-show="alerts.info.length > 1"></div>
        <md-tabs class="alertContainer" md-selected="selected.info" flex>
            <md-tab label="{{tab.title}}" class="alertItem" ng-repeat="tab in alerts.info">
                <div class="alertTextContent" style="">
                    {{tab.content}}
                </div>
                <div class="alertTextOpcs" layout="row">
                    <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('info');ok(this)" skip-notif>
                        {{opc.name}}
                    </div>
                </div>

            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('info')" ng-show="alerts.info.length > 1" style="width: 50px;">
            <div  ng-show="alerts.info.length>1">{{selected.info + 1}}/{{alerts.info.length}}</div>
        </div>
    </div>
    <!-- INPUT ############################################################################################## -->
    <div class="alertBox"  style="background-color: #f1f1f1"  flex ng-show="alerts.input.length > 0" layout="row" id="info">
        <div class="alertPrevArrow" ng-click="alertPrev('input')" ng-show="alerts.input.length > 1"></div>
        <md-tabs  md-selected="selected.info" flex>
            <md-tab label="{{tab.title}}" ng-repeat="tab in alerts.input" flex>
                <div style="" class="alertTextContent" >
                    {{tab.content}}
                </div>
                <div  layout="row" flex>
                    <md-input-container class="md-block" layout-align="center center" flex   style="height: 24px;">
                        <label>{{tab.content}}</label>
                        <input  type="text" ng-model="text"  style="background: none; border: none;" flex>
                    </md-input-container>
                    <div flex layout="row" style="height: 39px;">
                        <div layout="column" layout-align="center center" ng-click="closeThis('info');" flex >
                            <span class="icon-Filtro" style="font-size: 16px"></span>
                        </div>
                        <div layout="column" layout-align="center center"  ng-click="closeThis('info');ok(this)" flex="" >
                            <span class="icon-Filtro" style="font-size: 16px"></span>
                        </div>
                    </div>
                </div>
            </md-tab>
        </md-tabs>
        <div class="alertNextArrow" ng-click="alertNext('input')" ng-show="alerts.input.length > 1" style="width: 50px;">
            <div  ng-show="alerts.input.length>1">{{selected.input + 1}}/{{alerts.input.length}}</div>
        </div>
    </div>


</md-sidenav>