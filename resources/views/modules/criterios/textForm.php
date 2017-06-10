<div style="display: none" ng-init="createModel(field)"></div>
<md-input-container id="text-{{$index}}"
                    class="md-block"
                    flex
                    prevText
                    ng-if="(field.type.directive == 'prevText' || field.type.directive == null)"
                    ng-class="{'onlyread' : (field.type.directive == 'prevText'),'obsolete':field.obsoleto}"
                    >
    <label>{{field.options.placeholder[0].pivot.value || field.field.descripcion}} {{(field.obsoleto)?'OBSOLETO':''}}</label>
    <input skip-tab
           ng-disabled="field.obsoleto"
           ng-model="crit[field.id].value"
           info="{{field.options.Info[0].pivot.value || ''}}"
           info-nowait
           autocomplete="off"
           ng-required="{{field.options.Requerido[0].pivot.value || false}}"
           min-length="{{field.options.Minimo[0].pivot.value || 0}}"
           max-lenght="{{field.options.Max[0].pivot.value || 9999}}"
           md-no-asterisk

           erro-listener
           min-imp-msg = "{t:'error',m:field.options.MinImp[0].pivot.message || ''}"
           min-length-msg="{t:'alert',m:field.options.Minimo[0].pivot.message || ''}"
           max-length-msg="{t:'alert',m:field.options.Max[0].pivot.message || ''}"
           max-imp-msg="{t:'error',m:field.options.MaxImp[0].pivot.message || ''}"
           id="{{field.id}}">

</md-input-container>


<md-input-container id="number-{{$index}}"
                    class="md-block"
                    flex
                    prevNum
                    ng-if="(field.type.directive == 'prevNum' || field.type.directive == null)"
                    ng-class="{'onlyread' : (field.type.directive == 'prevNum'),'obsolete':field.obsoleto}"
                    >
    <label>{{field.options.placeholder[0].pivot.value || field.field.descripcion}} {{(field.obsoleto)?'OBSOLETO':''}}</label>
    <input skip-tab
           ng-disabled="field.obsoleto"
           ng-model="crit[field.id].value"
           info="{{field.options.Info[0].pivot.value || ''}}"
           info-nowait
           autocomplete="off"
           ng-required="{{field.options.Requerido[0].pivot.value || false}}"
           number
           type="number"
           min="{{field.options.Minimo[0].pivot.value || 0}}"
           max="{{field.options.Max[0].pivot.value || 9999}}"
           lmb-min-imp="{{field.options.MinImp[0].pivot.value || 0}}"
           lmb-max-imp="{{field.options.MaxImp[0].pivot.value || 9999}}"
           md-no-asterisk
           erro-listener
           min-imp-msg = "{t:'error',m:field.options.MinImp[0].pivot.message || ''}"
           min-msg="{t:'alert',m:field.options.Minimo[0].pivot.message || ''}"
           max-msg="{t:'alert',m:field.options.Max[0].pivot.message || ''}"
           max-imp-msg="{t:'error',m:field.options.MaxImp[0].pivot.message || ''}"
           id="{{field.id}}">

</md-input-container>


<md-input-container flex prevAutocomplete  ng-if="(field.type.directive == 'prevAutocomplete')" layout="row" ng-class="{'obsolete':field.obsoleto}">
    <label>{{field.options.placeholder[0].pivot.value || field.field.descripcion}} {{(field.obsoleto)?'OBSOLETO':''}}</label>
    <md-autocomplete md-selected-item="ctrl[field.id].sel"
                     model="crit[field.id].value"
                     ng-disabled="field.obsoleto"
                     flex
                     skip-tab
                     ng-required="{{field.options.Requerido[0].pivot.value || ''}}"
                     info="{{field.options.Info[0].pivot.value || ''}}"
                     info-nowait
                     md-search-text="ctrl[field.id].searchSel"
                     key="item.elem.id"
                     md-no-cache
                     md-items="item in field.options.Opcion || []  | filterSearch: formFilters[field.id] : 'elem.id' | stringKey : ctrl[field.id].searchSel: 'elem.nombre'"
                     md-item-text="item.elem.nombre"
                     md-no-asterisk
                     md-min-length="0"
                     id="{{field.id}}">

        <md-item-template>
            <span>{{item.elem.nombre}}</span>
        </md-item-template>
    </md-autocomplete>

</md-input-container>

<lmb-collection class="rad-contain"
                layout="row"
                ng-disabled="field.obsoleto"
                lmb-type="items"
                lmb-model="crit[field.id].value"
                lmb-display="elem.nombre"
                lmb-itens="field.options.Opcion"
                lmb-label="field.options.placeholder[0].pivot.value || field.field.descripcion"
                lmb-key="elem.id"
                id="{{field.id}}"
                ng-attr-multiple="field.options.multi[0].pivot.value==1"
                lmb-filter="filterSearch: formFilters[field.id] : 'elem.id' "
                ng-if="(field.type.directive == 'prevRadio')"
               >

</lmb-collection>