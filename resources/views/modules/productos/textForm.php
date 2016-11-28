<div> {{branch}}</div>

<md-input-container id="text" class="md-block" flex prevText ng-if="(field.type.directive == 'prevText' || field.type.directive == null)" ng-class="{'onlyread' : (field.type.directive == 'prevText')}">
    <label>{{get(true,{tipo:'placeholder',options:field.options}).pivot.value || ''}}</label>
    <input skip-tab
           info="{{get(true,{tipo:'placeholder',options:field.options}).pivot.value}}"
           autocomplete="off"
           name="razon_social"
           maxlength="80"
           ng-minlength="{{get(true,{tipo:'Requerido',options:field.options}).pivot.value}}"
           ng-required="{{get(true,{tipo:'Requerido',options:field.options}).pivot.value}}"
           md-no-asterisk
           id="{{field.id}}">

</md-input-container>


<md-input-container flex prevAutocomplete  ng-if="(field.type.directive == 'prevAutocomplete')">
    <label>{{get(true,{tipo:'placeholder',options:field.options}).pivot.value || ''}}</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     flex
                     skip-tab
                     id="langCont"
                     ng-required="(cnt.languaje.length==0)"
                     info="{{get(true,{tipo:'Info',options:field.options}).pivot.value || ''}}"
                     md-search-text="ctrl.searchLang"
                     md-items="item in listOptions | stringKey : ctrl.searchLang: 'nombre' | customFind : {tipo:'Opcion',options:field.options} : get"
                     md-item-text="item.nombre"
                     md-no-asterisk
                     md-min-length="0"
                     id="{{field.id}}">
        <input >
        <md-item-template>
            <span>{{item.nombre}}</span>
        </md-item-template>
    </md-autocomplete>

</md-input-container>

<div class="rad-contain" layout="row" ng-show="(field.type.directive == 'prevRadio')">
    <div ng-repeat="item in listOptions | customFind : {tipo:'Opcion',options:field.options} : get" class="rad-button" flex layout="column" layout-align="center center">{{item.nombre}}</div>
</div>