
<md-input-container id="text" class="md-block" flex prevText ng-if="(field.type.directive == 'prevText' || field.type.directive == null)" ng-class="{'onlyread' : (field.type.directive == 'prevText')}">
    <label>{{get(true,{tipo:'placeholder',options:field.options}).pivot.value || ''}}</label>
    <input skip-tab
           ng-model="crit[field.id]"
           info="{{get(true,{tipo:'Info',options:field.options}).pivot.value}}"
           autocomplete="off"
           name="razon_social"
           maxlength="{{get(true,{tipo:'Max',options:field.options}).pivot.value || 9999}}"
           type="number"
           ng-required="{{get(true,{tipo:'Requerido',options:field.options}).pivot.value}}"
           number
           min="50"
           max="90"
           lmb-min-imp="30"
           lmb-max-imp="100"
           md-no-asterisk
           erro-listener
           min-imp-msg = "{t:'error',m:'este valor es muy bajo para ser posible'}"
           min-msg="{t:'alert',m:'es muy baja,estas seguro'}"
           max-msg="{t:'alert',m:'es muy alta,estas seguro'}"
           max-imp-msg="{t:'error',m:'es muy alto para ser cierto!'}"
           id="{{field.id}}">

</md-input-container>


<md-input-container flex prevAutocomplete  ng-if="(field.type.directive == 'prevAutocomplete')">
    <label>{{get(true,{tipo:'placeholder',options:field.options}).pivot.value || ''}}</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     ng-model="crit[field.id]"
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

<!--<lmb-collection class="rad-contain" layout="row"  lmb-type="items" lmb-model="item" lmb-itens="listOptions | customFind : {tipo:'Opcion',options:field.options} : get" ng-show="(field.type.directive == 'prevRadio')">

</lmb-collection>-->