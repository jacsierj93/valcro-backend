<div layout="column" flex style="overflow: auto; margin-left: 4px;" >
    <div layout="row" class=" mail-preview-head" layout-align="end start">
        <div layout="row" layout-align="start center" flex >
            <div  ng-repeat="(id, value) in origenes" style="color:rgb(204, 204, 204);" ng-click="selectLang(id)" >
                <span info="{{lang.lang}}" class="iconInput iconCircle" icon-group  ng-class="{'iconActive':select == id, 'dot-gold':def == id}"
                    >
                    {{value.lang.substring(0,2)}}
                </span>
            </div>

        </div>
        <div  layout="row" class="actions">
           <!-- <div layout="column " layout-align="center center"  class="action" ng-click="load()"  >L</div>-->
            <div layout="column " layout-align="center center"   class="action" ng-click="back()" ng-show="changes.index && changes.index > 0"><</div>
            <div layout="column " layout-align="center center"   class="action" ng-click="next()" ng-show="changes.trace.length > 0 && (changes.index < (changes.trace.length - 1))">></div>
        </div>
    </div>
    <div layout="column "  flex class="mail-preview-content" id="content">
        <div id="templateContent" ng-bind-html="template"  style="" ng-show="state == 'load'" ng-click="listener($event)" >
        </div>
        <div flex ng-show="state != 'load'" style="width: 100%;" layout="column " layout-align="center center" class="loading">
            <div layout="column"  layout-align="center center" style="color: rgb(92,183,235);">
                {{centerText}}
            </div>
        </div>
    </div>
</div>