

<md-input-container id="text" class="md-block" flex prevText>
    <label>{{field.campo}}</label>
    <input skip-tab
           info="fasfafs"
           ng-disabled="$parent.enabled && prov.id"
           autocomplete="off"
           ng-blur="check('razon_social')"
           duplicate="list"
           duplicate-msg="ya existe un proveedor con esta razon social"
           field="razon_social"
           name="razon_social"
           maxlength="80"
           ng-minlength="3"
           required
           md-no-asterisk
           ng-model="dtaPrv.description" >

</md-input-container>


<md-input-container flex prevAutocomplete>
    <label>{{field.campo}}</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     flex
                     skip-tab
                     id="langCont"
                     ng-required="(cnt.languaje.length==0)"
                     info="marque cada idioma que hable este contacto"
                     md-search-text="ctrl.searchLang"
                     md-items="item in field.opciones | stringKey : ctrl.searchLang: 'nombre'"
                     md-item-text="item.lang"
                     md-no-asterisk
                     ng-disabled="$parent.enabled || cnt.isAgent==1"
                     md-min-length="0">
        <input >
        <md-item-template>
            <span>{{item.nombre}}</span>
        </md-item-template>
    </md-autocomplete>

</md-input-container>