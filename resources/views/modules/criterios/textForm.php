
<md-input-container id="text"
                    class="md-block"
                    flex
                    prevText
                    ng-if="(field.type.directive == 'prevText' || field.type.directive == null)"
                    ng-class="{'onlyread' : (field.type.directive == 'prevText')}"
                    >
    <label>{{field.options.placeholder[0].pivot.value || field.field.descripcion}}</label>
    <input skip-tab
           ng-model="crit[field.id]"
           info="{{field.options.Info[0].pivot.value || ''}}"
           autocomplete="off"
           name="razon_social"
           type="number"
           ng-required="{{field.options.Requerido[0].pivot.value || false}}"
           number
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


<md-input-container flex prevAutocomplete  ng-if="(field.type.directive == 'prevAutocomplete')" layout="row">
    <label>{{field.options.placeholder[0].pivot.value || field.field.descripcion}}</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     ng-model="crit[field.id]"
                     flex
                     skip-tab
                     id="langCont"
                     ng-required="{{field.options.Requerido[0].pivot.value || ''}}"
                     info="{{field.options.Info[0].pivot.value || ''}}"
                     md-search-text="ctrl.searchLang"
                     md-items="item in field.options.Opcion || [] | stringKey : ctrl.searchLang: 'elem.nombre'"
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
                lmb-type="items"
                lmb-model="item"
                lmb-display="elem.nombre"
                lmb-itens="field.options.Opcion"
                ng-if="(field.type.directive == 'prevRadio')"
               >

</lmb-collection>