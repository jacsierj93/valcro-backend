

<md-input-container id="text" class="md-block" flex prevText ng-show="(field.type.directive == 'prevText' || field.type.directive == null)" ng-class="{'onlyread' : (field.type.directive == 'prevText')}">
    <label>{{field.field.descripcion}}{{field.type.directive}}</label>
    <input skip-tab
           info="{{get('Info',field)}}"
           autocomplete="off"
           name="razon_social"
           maxlength="80"
           ng-minlength="3"
           required
           md-no-asterisk
           id="{{field.id}}">

</md-input-container>


<md-input-container flex prevAutocomplete  ng-show="(field.type.directive == 'prevAutocomplete')">
    <label>{{field.field.descripcion}}</label>
    <md-autocomplete md-selected-item="ctrl.lang"
                     flex
                     skip-tab
                     id="langCont"
                     ng-required="(cnt.languaje.length==0)"
                     info="{{get('Info',field.options).pivot.value || ''}}"
                     md-search-text="ctrl.searchLang"
                     md-items="item in listOptions | stringKey : ctrl.searchLang: 'nombre'"
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

<div vlc-buttomGroup layout="row" ng-show="(field.type.directive == 'prevRadio')">
    <div ng-repeat="item in [222,33,4,5,51,21]" class="rad-button" flex >{{item}}</div>
</div>