

<md-input-container id="text" class="md-block" flex>
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


