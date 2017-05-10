<div layout="column" flex >
    <div style="padding: 2px;; min-height: 56px;" layout="row" >
        <div ngf-drop ngf-select  ng-model="adjs" class="drop-box" ngf-drag-over-class="dragover"
             ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" ng-disabled="noUp">
            Insertar archivo
        </div>
    </div>
    <div flex class="gridContent" >
        <div class="imgItem" ng-repeat="item in loadeds track by $index" >
            <vl-thumb ng-model="item" vl-up="fileUp" vl-fail="" progress="" ></vl-thumb>
        </div>
        <div  style="height: 100%;" layout="column" layout-align = "center center" flex ng-show="loadeds.length == 0" >
            No hay adjuntos cargados
        </div>

    </div>
</div>