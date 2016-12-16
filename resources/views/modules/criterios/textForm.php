
<md-input-container id="text" class="md-block" flex prevText ng-if="(field.type.directive == 'prevText' || field.type.directive == null)" ng-class="{'onlyread' : (field.type.directive == 'prevText')}">
    <label>error</label>
    <input skip-tab
           ng-model="crit[field.id]"
           info=""
           autocomplete="off"
           name="razon_social"
           maxlength=""
           type="number"
           set-attr="field"
           ng-required=""
           number
           min=""
           max=""
           lmb-min-imp=""
           lmb-max-imp=""
           md-no-asterisk
           erro-listener
           min-imp-msg = "{t:'error',m:'este valor es muy bajo para ser posible'}"
           min-msg="{t:'alert',m:'es muy baja,estas seguro'}"
           max-msg="{t:'alert',m:'es muy alta,estas seguro'}"
           max-imp-msg="{t:'error',m:'es muy alto para ser cierto!'}"
           id="{{field.id}}">

</md-input-container>


<md-input-container flex prevAutocomplete  ng-if="(field.type.directive == 'prevAutocomplete')" layout="row">
    <label>default</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     ng-model="crit[field.id]"
                     flex
                     skip-tab
                     set-attr="field"
                     id="langCont"
                     ng-required=""
                     info=""
                     md-search-text="ctrl.searchLang"
                     md-items="item in field.options | customFind : ctrl.searchLang : get"
                     md-item-text="item.elem.nombre"
                     md-no-asterisk
                     md-min-length="0"
                     id="{{field.id}}">

        <md-item-template>
            <span>{{item.elem.nombre}}</span>
        </md-item-template>
    </md-autocomplete>

</md-input-container>

<lmb-collection class="rad-contain" layout="row"  lmb-type="items" lmb-model="item" lmb-display="elem.nombre" lmb-itens="field.options" filter-by="customFind : true : get" ng-if="(field.type.directive == 'prevRadio')">

</lmb-collection>