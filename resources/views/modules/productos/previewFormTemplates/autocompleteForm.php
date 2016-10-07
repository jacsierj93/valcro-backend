<md-input-container flex>
    <label>{{field.campo}}</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     flex
                     skip-tab
                     id="langCont"
                     ng-required="(cnt.languaje.length==0)"
                     info="marque cada idioma que hable este contacto"
                     md-search-text="ctrl.searchLang"
                     md-items="item in languaje | stringKey : ctrl.searchLang: 'lang' | filterSelect: cnt.languaje"
                     md-item-text="item.lang"
                     md-no-asterisk
                     ng-disabled="$parent.enabled || cnt.isAgent==1"
                     md-min-length="0">
        <input >
        <md-item-template>
            <span>{{item.lang}}</span>
        </md-item-template>
    </md-autocomplete>

</md-input-container>