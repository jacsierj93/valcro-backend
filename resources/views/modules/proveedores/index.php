<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="AppCtrl">

    <!-- 2) ########################################## AREA DEL MENU ########################################## -->
    <div layout="row" flex="none" class="menuBarHolder">
        <!-- 3) ########################################## MENU ########################################## -->
        <div layout="row" layout-align="start center" class="menu" >
            <div flex layout-align="center center" ng-click="showAlert()">
            Menu
            </div>
            <div layout="column" style="width: 48px; height: 48px;" layout-align="center center" >
                <?= HTML::image("images/btn_nextArrow.png") ?>
            </div>
        </div>
        <!-- 4) ########################################## BOTONERA ########################################## -->
        <div class="botonera" layout layout-align="start center">
            <div layout="column" layout-align="center center">

            </div>
            <div layout="column" layout-align="center center" ng-click="addProv()">
                <!--<i class="fa fa-plus"></i>-->
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleRight()">
                <!--<i class="fa fa-filter"></i>-->
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleOtro()">
                <!--<i class="fa fa-minus"></i>-->
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>

    </div>

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral" ng-controller="ListProv">

            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex ng-repeat="item in todos" ng-click="setProv(this)">
                <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ item.razon_social }}</div>
                <div style="height:40px; font-size:31px;">{{item.limite_credito}}00000</div>
                <div style="height:40px;">
                    <!--<i ng-show="(item.contraped==1)" class="fa fa-gift" style="font-size:24px;"></i>-->
                    <img ng-show="(item.contrapedido==1)" src="images/contra_pedido.png"/>
                    <img src="images/aereo.png"/>
                    <img src="images/maritimo.png"/>
                </div>
            </div>

        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
            <?= HTML::image("images/btn_prevArrow.png","",array("ng-click"=>"closeLayer()","ng-show"=>"(index>0)")) ?>
        </div>

        <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                P
            </div>
            <br>
            Selecciones un Proveedor
        </div>

        <!-- 10) ########################################## LAYER (1) RESUMEN DEL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer0">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="row" flex>
                <!-- 12) ########################################## COLUMNA 1 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Proveedor
                        </div>
                    </div>
                    <div layout="row">
                        <div class="textResm" flex="70" layout="Column" layout-align="start start">
                            <div>
                                CECRISA REVESTIMIENTO CERAMICOS, S.A
                            </div>
                        </div>

                        <div class="textResm" flex="30" layout="Column" layout-align="start start">
                            <div>
                                CRCSA
                            </div>
                        </div>
                    </div>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Nombres Valcro
                        </div>
                    </div>
                    <md-grid-list md-cols="2" md-gutter="6px" md-row-height="4:1" style="margin-right: 8px;">
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                    </md-grid-list>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Tipo de envio
                        </div>
                    </div>
                    <div layout="row">
                        <div flex>

                        </div>
                    </div>

                </div>
                <!-- 13) ########################################## COLUMNA 2 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                </div>
                <!-- 14) ########################################## COLUMNA 3 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                </div>
            </md-content>


        </md-sidenav>


        <!-- 15) ########################################## LAYER (2) FORMULARIO INFORMACION DEL PROVEEDOR ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">

            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <!-- 17) ########################################## FORMULARIO "Datos Basicos del Proveedor" ########################################## -->
                <form name="projectForm" ng-controller="DataProvController"  ng-disabled="true">

                    <div class="titulo_formulario" layout="Column" layout-align="start start" >
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo</label>
                            <md-select ng-model="dtaPrv.type" name ="state" ng-disabled="enabled">
                                <md-option ng-repeat="state in states" value="{{state.id}}">
                                    {{state.nombre}}
                                </md-option>
                            </md-select>

                            <!--<div ng-messages="projectForm.type.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>


                        <md-input-container class="md-block" flex>
                            <label>Razon Social</label>
                            <input maxlength="80" ng-minlength="3" required md-no-asterisk name="description"
                                   ng-model="dtaPrv.description" ng-disabled="enabled">
                            <!--<div ng-messages="projectForm.description.$error" ng-hide>
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Siglas</label>
                            <input maxlength="6" ng-minlength="3"  required name="siglas" ng-model="dtaPrv.siglas" ng-disabled="enabled" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo de Envio</label>
                            <md-select ng-model="dtaPrv.envio" ng-disabled="enabled">
                                <md-option ng-repeat="envio in envios" value="{{envio.id}}">
                                    {{envio.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="envio.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-switch class="md-primary" ng-model="dtaPrv.contraped" aria-label="Contrapedidos"  ng-disabled="enabled">
                                Contrapedidos?
                            </md-switch>
                        </md-input-container>



                    </div>

                    <div layout="row">


                        <div flex></div>

                    </div>
                </form>

                <!-- 18) ########################################## FORMULARIO "Nombres Valcro" ########################################## -->
                <form name="nomvalcroForm" ng-controller="valcroNameController">
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Nombres Valcro
                        </div>
                    </div>

                    <!--<md-input-container class="md-block" flex>
                        <label>Nombre Valcro</label>-->
                        <md-chips  ng-disabled="enabled" class="md-block" flex ng-model="valcroName" md-autocomplete-snap=""  md-require-match="false" placeholder="Nombre Valcro" md-on-add="addChip(this)" md-transform-chip="transformChip($chip)" md-on-remove="rmChip(this,$chip)">
                            <md-chip-template>
                                <span>
                                  <img ng-show="($chip.fav=='1')" src="images/contra_pedido.png" height="16" width="16"/>
                                  <span>{{$chip.name}}</span>
                                </span>
                            </md-chip-template>
                        </md-chips>
                            <!--</md-input-container>-->
                </form>

                <!-- 19) ########################################## FORMULARIO "Direcciones del Proveedor" ########################################## -->
                <form name="direccionesForm" ng-controller="provAddrsController"  ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Direcciones
                        </div>
                    </div>

                    <md-input-container class="md-block" flex>
                        <label>Direccion</label>
                        <input maxlength="250" ng-minlength="5" required md-no-asterisk name="direccProv" ng-model="dir.direccProv" >
                        <!--<div ng-messages="nomvalcroForm.direccProv.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">La direccion debe tener maximo 250 caracteres.</div>
                        </div>-->
                    </md-input-container>


                    <div layout="row">

                        <md-input-container class="md-block" flex="20" ng-controller="TipoDirecc">
                            <label>Tipo de Direccion</label>
                            <md-select ng-model="dir.tipo">
                                <md-option ng-repeat="tipo in tipos" value="{{tipo.nombre}}">
                                    {{tipo.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="user.tipo.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="50" ng-controller="ListPaises">
                            <label>Pais</label>
                            <md-select ng-model="dir.pais">
                                <md-option ng-repeat="pais in paises" value="{{pais.id}}" >
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="user.pais.$error">
                                <div ng-message="required">Campo Obligatorio.</div>

                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="40">
                            <label>Telefono</label>
                            <input name="provTelf" required md-no-asterisk ng-model="dir.provTelf"
                                   ng-pattern="/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/"/>
                            <!--<div ng-messages="nomvalcroForm.provTelf.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="pattern">0241-123-1234, ingrese un numero valido.</div>
                            </div>-->
                        </md-input-container>

                    </div>

                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="10" class="headGrid"> Tipo</div><div flex="20" class="headGrid"> Pais</div><div flex class="headGrid"> Direccion</div><div flex="20" class="headGrid"> Telefono</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="add in address" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="10" class="cellGrid"> {{add.tipo_dir}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{add.pais.short_name}}</div><div flex class="cellGrid">{{add.direccion}}</div><div flex="20" class="cellGrid">{{add.telefono}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <!-- 20) ########################################## FORMULARIO "Contactos del Proveedor" ########################################## -->
                <form name="provContactosForm" ng-controller="contactProv" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Contactos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="30">
                            <label>Nombre y Apellido</label>
                            <input name="nombreCont" maxlength="55" ng-minlength="3" required md-no-asterisk ng-model="cnt.nombreCont" ng-click="book()">
                            <!--<div ng-messages="provContactosForm.nombreCont.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">Debe tener maximo 55 caracteres.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="35">
                            <label>Email</label>
                            <input name="emailCont" minlength="10" maxlength="100" required ng-model="cnt.emailCont"
                                   ng-pattern="/^.+@.+\..+$/"/>
                            <!--<div ng-messages="provContactosForm.emailCont.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="pattern">Inserte un email valido.</div>
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    El debe tener entre 10 y 100 caracteres.
                                </div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Telefono</label>
                            <input name="contTelf" md-no-asterisk ng-model="cnt.contTelf" ng-disabled="(cnt.id===false)" ng-pattern="/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/"/>
                            <!--<div ng-messages="provContactosForm.contTelf.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="pattern">0241-123-1234, ingrese un numero valido.</div>
                            </div>-->
                        </md-input-container>


                        <md-input-container class="md-block" flex="15">
                            <label>Pais de Residencia</label>
                            <md-select ng-model="cnt.pais" ng-disabled="(cnt.id===false)">
                                <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                    </div>
                    <div layout="row">
                        <div ng-controller="idiomasController" layout="row" flex="10">
                            <md-input-container flex>
                                <label>Idiomas</label>
                                <md-select ng-model="cnt.languaje" multiple="" ng-disabled="(cnt.id===false)">
                                    <md-option ng-value="idioma.id" ng-repeat="idioma in idiomas">{{idioma.name}}</md-option>
                                    </md-optgroup>
                                </md-select>
                            </md-input-container>
                        </div>

                        <md-input-container class="md-block" flex="40">
                            <label>Responsabilidades</label>
                            <input name="cntcRespon" maxlength="100" ng-minlength="3" ng-model="cnt.responsability" ng-disabled="(cnt.id===false)">
                        </md-input-container>

                        <md-input-container class="md-block" flex>
                            <label>Direccion de Oficina</label>
                            <input name="cntcDirOfc" maxlength="200" ng-model="cnt.dirOff" ng-minlength="3" ng-disabled="(cnt.id===false)">
                        </md-input-container>

                    </div>


                    <div layout="column" ng-show="isShow">

                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> Nombre</div><div flex class="headGrid"> Email</div><div flex="10" class="headGrid"> Telefono</div><div flex="20" class="headGrid"> Pais</div></div>
                        <div id="grid">
                           <div flex ng-repeat="cont in contacts" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="20" class="cellGrid"> {{cont.nombre}}</div><div flex class="cellGrid"> {{cont.email}}</div><div flex="10" class="cellGrid">{{cont.telefono}}</div><div flex="20" class="cellGrid">{{cont.pais.short_name}}</div>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>


            </md-content>

            <div style="width: 16px;" ng-mouseover="showNext(true,'layer2')" >

            </div>

        </md-sidenav>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="contactBook">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="addressBook">
                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Contactos Existentes
                    </div>
                </div>
                <div style="height: 100%; overflow:scroll">
                    <div flex ng-repeat="cont in allContact" flex="column" ng-click="toEdit(this)">
                        <div layout="column" layout-wrap class="cellGridHolder cellGrid" style="height: 72px" >
                            <div flex style="height: 24px">{{cont.nombre}} </div>
                            <div flex style="height: 24px"> {{cont.email}}</div>
                            <div flex style="height: 24px"><span ng-repeat="prov in cont.provs">{{prov.prov}}, </span></div>
                        </div>

                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER (3) INFORMACION FINANCIERA ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer2" id="layer2">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <!-- ########################################## FORMULARIO MONEDAS ########################################## -->
                <form name="provMoneda" ng-controller="coinController">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" flex>
                        <div>
                           Moneda
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20" ng-controller="allCoinsController">
                            <label>Moneda</label>
                            <md-select ng-model="cn.coin" name ="state" ng-disabled="enabled" required>
                                <md-option ng-repeat="coin in coins | filterSelect: filt" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>

                            <!--<div ng-messages="projectForm.type.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>
                        <div layout="row" ng-repeat="coinSel in coinAssign">
                            <div layout="10">{{coinSel.nombre}} ({{coinSel.simbolo}})</div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO INFO BANCARIA ########################################## -->
                <form ng-controller="bankInfoController" name="bankInfoForm" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Informacion Bancaria
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="30">
                            <label>Banco</label>
                            <input ng-model="bnk.bankName" required/>

                        </md-input-container>
                        <md-input-container class="md-block" flex="30">
                            <label>Nombre Beneficiario</label>
                            <input ng-model="bnk.bankBenef" required/>

                        </md-input-container>
                        <md-input-container class="md-block" flex="40">
                            <label>Direccion</label>
                            <input ng-model="bnk.bankAddr"/>

                        </md-input-container>
                    </div>

                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-model="bnk.pais" name ="state" ng-disabled="enabled" ng-change="setState(this)">
                                <md-option ng-repeat="country in countries" value="{{country.id}}">
                                    {{country.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20" >
                            <label>Estado</label>
                            <md-select ng-model="bnk.est" name ="state" ng-disabled="enabled || (bnk.pais==false)">
                                <md-option ng-repeat="state in states" value="{{state.id}}">
                                    {{state.local_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Ciudad</label>
                            <md-select ng-model="bnk.ciudad" name ="state" ng-disabled="enabled || (bnk.est==false)" required>
                                <md-option ng-repeat="city in cities" value="{{city.id}}">
                                    {{city.local_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>SWIF</label>
                            <input ng-model="bnk.bankSwift" required/>

                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>IBAN</label>
                            <input ng-model="bnk.bankIban" required/>

                        </md-input-container>
                    </div>
                 <div layout="column" ng-show="isShow">

                  <div layout="row" class="headGridHolder">
                   <div flex="20" class="headGrid"> Banco</div>
                   <div flex class="headGrid"> Beneficiario</div>
                   <div flex="30" class="headGrid"> Cuenta</div>
                  </div>
                  <div id="grid">
                   <div flex ng-repeat="account in accounts" ng-click="toEdit(this)">
                    <div layout="row" layout-wrap class="cellGridHolder">
                     <div flex="20" class="cellGrid"> {{account.banco}}</div>
                     <div flex class="cellGrid"> {{account.beneficiario}}</div>
                     <div flex="30" class="cellGrid">{{account.cuenta}}</div>

                    </div>
                   </div>

                  </div>

                 </div>

                </form>
                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="provCred" ng-controller="creditCtrl">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Credito
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="30">
                            <label>Limite de Credito</label>
                            <input ng-model="cred.amount" required >
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Moneda</label>
                            <md-select ng-model="cred.coin" name ="state" ng-disabled="enabled" ng-controller="provCoins" required>
                                <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">

                        <div layout="row" class="headGridHolder">
                            <!--<div flex="20" class="headGrid"> Fecha</div>-->
                            <div flex="20" class="headGrid"> Limite</div>
                            <div flex="30" class="headGrid"> Moneda</div>
                        </div>
                        <div id="grid">
                            <div flex ng-repeat="lim in limits" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <!--<div flex="20" class="cellGrid"> {{lim.fecha}}</div>-->
                                    <div flex="20" class="cellGrid"> {{lim.limite}}</div>
                                    <div flex="30" class="cellGrid">{{lim.moneda.nombre}}</div>

                                </div>
                            </div>

                        </div>

                    </div>
                </form>
                <!-- ########################################## FORMULARIO FACTOR CONVERSION ########################################## -->
                <form name="provConv" ng-controller="convController">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Factor de Conversión
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>% Flete</label>
                            <input ng-model="conv.freight">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>% Gastos</label>
                            <input ng-model="conv.expens">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>% Ganancia</label>
                            <input ng-model="conv.gain">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>% Descuento</label>
                            <input ng-model="conv.disc">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                            <label>Moneda</label>
                            <md-select ng-model="conv.coin" name ="state" ng-disabled="enabled" required>
                                <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO PUNTOS ########################################## -->
                <form name="provPoint" ng-controller="provPointController">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Puntos
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="30">
                            <label>Costo del punto</label>
                            <input ng-model="pnt.cost" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                            <label>Moneda</label>
                            <md-select ng-model="pnt.coin" ng-disabled="enabled" required>
                                <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                </form>

            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'layer3')" >

            </div>
        </md-sidenav>

        <!-- ########################################## LAYER (4) TIEMPOS (PRODUCCION/TRANSITO) ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer3" id="layer3">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <!-- ########################################## FORMULARIO TIEMPO PRODUCCION ########################################## -->
                <form name="timeProd" ng-controller="prodTimeController">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Tiempo Aproximado de Producción
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>De (Dias)</label>
                            <input ng-model="tp.from" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>A (Dias)</label>
                            <input ng-model="tp.to" required>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-model="tp.country" name ="state" ng-disabled="enabled">
                                <!--<md-option ng-repeat="country in provCountries" value="{{country.pais.id}}">
                                    {{country.pais.short_name}}
                                </md-option>-->
                            </md-select>
                        </md-input-container>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO TIEMPO TRANSITO ########################################## -->
                <form name="timeTrans" ng-controller="transTimeController">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Tiempo Aproximado de Transito
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>De (Dias)</label>
                            <input ng-model="ttr.from">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>A (Dias)</label>
                            <input ng-model="ttr.to">
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-model="ttr.country" name ="state" ng-disabled="enabled">
                                <md-option ng-repeat="country in provCountries" value="{{country.pais.id}}">
                                    {{country.pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                </form>

                <form name="provPrecList">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Listas de Precios
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="40">
                            <label>Referencia</label>
                            <input ng-model="lp.ref">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Archivo</label>
                            <input ng-model="lp.file">
                        </md-input-container>
                    </div>

                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="70" class="headGrid"> Referencias</div><div flex="30" class="headGrid"> Archivo</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="add in [{ref:'dasdnl',file:'img.jpg'},{ref:'dasdnl',file:'img.jpg'},{ref:'dasdnl',file:'img.jpg'}]" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="70" class="cellGrid"> {{add.ref}}</div><div flex="30" class="headGrid"> {{add.file}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'END')" >

            </div>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');" layout="column" layout-align="center center" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="NEXT" ng-mouseleave="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png","",array('ng-click'=>"openLayer()")) ?>
        </md-sidenav>
        <!-- 8) ########################################## BOTON Next ########################################## -->


    </div>

</div>


