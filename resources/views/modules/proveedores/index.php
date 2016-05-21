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
            <div layout="column" layout-align="center center" ng-click="editProv()" ng-show="prov.id">
                <!--<i class="fa fa-filter"></i>-->
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleOtro()" ng-show="prov.id">
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
            <div class="boxList" layout="column" flex ng-repeat="item in todos" ng-click="setProv(this)" ng-class="{'listSel' : (item.id ==prov.id)}">
                <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ item.razon_social }}</div>
                <div style="height:40px; font-size:31px; overflow: hidden;">{{(item.limCred)?item.limCred:'000000'}}</div>
                <div style="height:40px;">
                    <!--<i ng-show="(item.contraped==1)" class="fa fa-gift" style="font-size:24px;"></i>-->
                    <img ng-show="(item.contrapedido==1)" src="images/contra_pedido.png"/>
                    <img ng-show="(item.tipo_envio_id==1 || item.tipo_envio_id==3)"src="images/aereo.png"/>
                    <img ng-show="(item.tipo_envio_id==2 || item.tipo_envio_id==3)"src="images/maritimo.png"/>
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
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer0">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="row" flex ng-controller="resumenProv">
                <!-- 12) ########################################## COLUMNA 1 RESUMEN ########################################## -->
                <div layout="column" flex >
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Proveedor
                        </div>
                    </div>
                    <div layout="row">
                        <div class="textResm" flex="70" layout="Column" layout-align="start start">
                            <div>
                                {{prov.razon_social}}
                            </div>
                        </div>

                        <div class="textResm" flex="30" layout="Column" layout-align="start start">
                            <div>
                                {{prov.siglas}}
                            </div>
                        </div>
                    </div>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Nombres Valcro
                        </div>
                    </div>
                    <md-grid-list md-cols="2" md-gutter="6px" md-row-height="4:1" style="margin-right: 8px;" ng-repeat="name in prov.nomValc">
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    {{name.nombre}}
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
                            <img ng-show="(prov.tipo_envio_id==1 || prov.tipo_envio_id==3)"src="images/aereo.png"/>
                            <img ng-show="(prov.tipo_envio_id==2 || prov.tipo_envio_id==3)"src="images/maritimo.png"/>
                        </div>
                    </div>

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Tiempos Estimados
                        </div>
                    </div>
                    <div layout="column">
                        <div flex>
                            Produccion:
                        </div>
                        <div flex ng-repeat="tiempo in prov.tiemposP">
                            <div flex >de: {{tiempo.min_dias}} a {{tiempo.max_dias }} para {{tiempo.lines.linea}}</div>
                        </div>
                    </div>
                    <div layout="column">
                        <div flex>
                            Transito:
                        </div>
                        <div flex ng-repeat="tiempo in prov.tiemposT">
                            <div flex >de: {{tiempo.min_dias}} a {{tiempo.max_dias }} desde {{tiempo.country.short_name}}</div>
                        </div>
                    </div>

                </div>


                <!-- 13) ########################################## COLUMNA 2 RESUMEN ########################################## -->
                <div layout="column" flex >
                    <div flex="50" layout="column">
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                Direcciones
                            </div>
                        </div>

                        <div flex layout="column">

                            <div ng-repeat="direccion in prov.direcciones" layout="column" style="border-bottom: 1px solid rgb(84, 180, 234)">
                                <div layout="row">
                                    <div flex="50">{{direccion.tipo.descripcion}}</div>
                                    <div flex="50" style="overflow-x: hidden; text-overflow: ellipsis;">
                                        {{direccion.country.short_name}}
                                    </div>
                                </div>
                                <div flex>
                                    {{direccion.direccion}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div flex="50" layout="column">
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                Contactos
                            </div>
                        </div>
                        <div flex ng-repeat="contact in prov.contacts" layout="column" style="border-bottom: 1px solid rgb(84, 180, 234)">
                            <div layout="row">
                                <div flex="50">{{contact.nombre}}</div>
                                <div flex="50"  >
                                    <span ng-repeat="cargo in contact.cargos">{{cargo.cargo}}, </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- 14) ########################################## COLUMNA 3 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div flex="10">
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                Monedas
                            </div>
                        </div>
                        <div flex layout="column">
                            <div ng-repeat="moneda in prov.monedas" layout="column" style="border-bottom: 1px solid rgb(84, 180, 234)">
                                {{moneda.nombre}} ({{moneda.simbolo}})
                            </div>
                        </div>
                    </div>
                    <div flex="20">
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                Puntos
                            </div>
                        </div>
                        <div ng-repeat="point in prov.monedas" ng-show="point.pivot.punto" layout="row" style="border-bottom: 1px solid rgb(84, 180, 234)">
                            <div flex="30">{{point.nombre}}</div>
                            <div flex="70">{{point.pivot.punto}} {{point.simbolo}}</div>
                        </div>
                    </div>

                    <div flex="20">
                        <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'title_error' : (prov.limCred.length < 1)}">
                            <div>
                                Limites de Credito
                            </div>
                        </div>
                        <div ng-repeat="lim in prov.limites" layout="row" style="border-bottom: 1px solid rgb(84, 180, 234)">
                            <div flex="30">{{lim.moneda.nombre}}</div>
                            <div flex="70">{{lim.limite}} {{lim.moneda.simbolo}}</div>
                        </div>
                    </div>
                    <div flex="50">
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                Cuentas Bancarias
                            </div>
                        </div>
                        <div ng-repeat="bank in prov.banks" layout="column" style="border-bottom: 1px solid rgb(84, 180, 234)">
                            <div flex>{{bank.banco}}</div>
                            <div flex>{{bank.cuenta}}</div>
                        </div>
                    </div>
                </div>

            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'layer1')" >

            </div>

        </md-sidenav>


        <!-- 15) ########################################## LAYER (2) FORMULARIO INFORMACION DEL PROVEEDOR ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">

            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <!-- 17) ########################################## FORMULARIO "Datos Basicos del Proveedor" ########################################## -->
                <form name="projectForm" ng-controller="DataProvController"  ng-disabled="true">

                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit && prov.id)}">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo</label>
                            <md-select ng-model="dtaPrv.type" ng-disabled="$parent.enabled && prov.id" md-no-ink>
                                <md-option ng-repeat="type in types" value="{{type.id}}">
                                    {{type.nombre}}
                                </md-option>
                            </md-select>

                            <!--<div ng-messages="projectForm.type.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>


                        <md-input-container class="md-block" flex>
                            <label>Razon Social</label>
                            <input maxlength="80" ng-minlength="3" required md-no-asterisk name="description" ng-model="dtaPrv.description" ><!--ng-disabled="($parent.enabled || (toCheck && projectForm.description.$valid))"-->  <!--INICIO DE DIRECTIVA PARA FUNCION DE SOLO CHEQUEO (SKIP RED TO RED)-->
                            <!--<div ng-messages="projectForm.description.$error" ng-hide>
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="10" ng-click="inputSta(true)">
                            <label>Siglas</label>
                            <input maxlength="6" ng-minlength="3"  required name="siglas" ng-model="dtaPrv.siglas" ng-disabled="$parent.enabled && prov.id" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo de Envio</label>
                            <md-select ng-model="dtaPrv.envio" ng-disabled="$parent.enabled && prov.id" md-no-ink>
                                <md-option ng-repeat="envio in envios" value="{{envio.id}}">
                                    {{envio.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="envio.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-switch class="md-primary" ng-model="dtaPrv.contraped" aria-label="Contrapedidos"  ng-disabled="$parent.enabled && prov.id">
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
                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Nombres Valcro
                        </div>
                        <div flex="20" style="height: 30px;">
                            <span ng-repeat="dep in deps" ng-class="{'iconActive':(exist(dep.id,0)),'iconFav':(exist(dep.id,1))}" ng-click="setDepa(this)" ng-dblclick="setFav(this)" class="{{dep.icon}} iconInactive" style="font-size: 18px; margin-left: 8px; color:black"></span>
                            <!--<span style="font-size: 18px; margin-left: 8px" class="icon-barco"></span>
                            <span style="font-size: 18px; margin-left: 8px" class="icon-gift"></span>-->
                        </div>
                    </div>
                    <md-input-container class="md-block" flex id="valcroName">
                        <label>Nombre...</label>
                        <input duplicate="allName" field="nombre" ng-minlength="3" required name="siglas"
                               ng-model="valName.name" ng-disabled="$parent.enabled">
                    </md-input-container>

                    <div ng-show="isShow">
                        <div ng-repeat="name in valcroName" class="itemName" ng-click="toEdit(this)" ng-class="{'gridSel':(name.id==valName.id)}" ng-mouseleave="over(false)" ng-mouseover="over(this)">{{name.name}} <span ng-show="(name.id==valName.id)" class="icon-bs" ng-click="rmValName(this)"></span></div>
                    </div>
                </form>

                <!-- 19) ########################################## FORMULARIO "Direcciones del Proveedor" ########################################## -->
                <form name="direccionesForm" ng-controller="provAddrsController"  ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Direcciones
                        </div>
                    </div>

                    <div layout="row">

                        <md-input-container class="md-block" flex="20">
                            <label>Tipo de Direccion</label>
                            <md-select ng-model="dir.tipo" md-no-ink ng-disabled="$parent.enabled">
                                <md-option ng-repeat="tipo in tipos" value="{{tipo.id}}">
                                    {{tipo.descripcion}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="user.tipo.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="30">
                            <label>Pais</label>
                            <md-select ng-model="dir.pais" md-no-ink ng-disabled="$parent.enabled">
                                <md-option ng-repeat="pais in paises" value="{{pais.id}}" >
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="user.pais.$error">
                                <div ng-message="required">Campo Obligatorio.</div>

                            </div>-->
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Codigo Postal</label>
                            <input md-no-asterisk ng-model="dir.zipCode" ng-disabled="$parent.enabled" />
                        </md-input-container>

                        <md-input-container class="md-block" flex="30">
                            <label>Telefono</label>
                            <input name="provTelf"  required md-no-asterisk ng-model="dir.provTelf" ng-disabled="$parent.enabled" />
                        </md-input-container>

                    </div>
                    <md-input-container class="md-block" flex ng-show="dir.tipo==2">
                        <label>puertos</label>
                        <md-select ng-model="dir.ports" multiple="" md-no-ink ng-disabled="$parent.enabled || !dir.pais">
                            <md-option ng-repeat="port in ports | customFind : dir.pais : searchPort" value="{{port.id}}" >
                                {{port.Main_port_name}}
                            </md-option>
                        </md-select>
                    </md-input-container>
                    <md-input-container class="md-block" flex>
                        <label>Direccion</label>
                        <input ng-disabled="$parent.enabled" maxlength="250" ng-minlength="5" required md-no-asterisk name="direccProv" ng-model="dir.direccProv" >
                    </md-input-container>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="10" class="headGrid"> Tipo</div><div flex="20" class="headGrid"> Pais</div><div flex class="headGrid"> Direccion</div><div flex="20" class="headGrid"> Telefono</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="add in address" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="10" class="cellGrid"> {{add.tipo.descripcion}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{add.pais.short_name}}</div><div flex class="cellGrid">{{add.direccion}}</div><div flex="20" class="cellGrid">{{add.telefono}}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <!-- 20) ########################################## FORMULARIO "Contactos del Proveedor" ########################################## -->
                <form name="provContactosForm" ng-controller="contactProv" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Contactos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="30">
                            <label>Nombre y Apellido</label>
                            <input ng-disabled="$parent.enabled" name="nombreCont" maxlength="55" ng-minlength="3" required md-no-asterisk ng-model="cnt.nombreCont" ng-dblclick  ="book()">
                        </md-input-container>

                        <md-input-container class="md-block" flex="35">
                            <label>Email</label>
                            <input ng-disabled="$parent.enabled" name="emailCont" minlength="10" maxlength="100" required ng-model="cnt.emailCont"
                                   ng-pattern="/^.+@.+\..+$/"/>
                        </md-input-container>
                        <md-input-container class="md-block" flex="15">
                            <label>Pais de Residencia</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="cnt.pais" ng-disabled="(cnt.id===false)" md-no-ink>
                                <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Telefono</label>
                            <input ng-disabled="$parent.enabled" name="contTelf" md-no-asterisk ng-model="cnt.contTelf" ng-disabled="(cnt.id===false)" />
                        </md-input-container>

                    </div>
                    <div layout="row">
                        <div layout="row" flex="30">
                            <md-input-container flex>
                                <label>Idiomas</label>
                                <md-select ng-disabled="$parent.enabled" ng-model="cnt.languaje" multiple="" ng-disabled="(cnt.id===false)" md-no-ink>
                                    <md-option ng-value="lang.id" ng-repeat="lang in languaje">{{lang.lang}}</md-option>

                                </md-select>
                            </md-input-container>
                        </div>

                        <div layout="row" flex="30">
                            <md-input-container flex>
                                <label>cargos</label>
                                <md-select ng-model="cnt.cargo" multiple="" ng-disabled="(cnt.id===false) || $parent.enabled" md-no-ink>
                                    <md-option ng-value="cargo.id" ng-repeat="cargo in cargos">{{cargo.cargo}}</md-option>
                                </md-select>
                            </md-input-container>
                        </div>

                        <md-input-container class="md-block" flex="40">
                            <label>Responsabilidades</label>
                            <input ng-disabled="$parent.enabled" name="cntcRespon" maxlength="100" ng-minlength="3" ng-model="cnt.responsability" ng-disabled="(cnt.id===false)">
                        </md-input-container>

                    </div>
                    <div layout="row" flex>
                        <md-input-container class="md-block" flex>
                            <label>Direccion de Oficina</label>
                            <input ng-disabled="$parent.enabled" name="cntcDirOfc" maxlength="200" ng-model="cnt.dirOff" ng-minlength="3" ng-disabled="(cnt.id===false)">
                        </md-input-container>
                    </div>


                    <div layout="column" ng-show="isShow">

                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> Nombre</div><div flex class="headGrid"> Email</div><div flex="10" class="headGrid"> Telefono</div><div flex="20" class="headGrid"> Pais</div></div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
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

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="nomValLyr">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="nomValAssign">
                <div layout="column" flex style="overflow-x: hidden;">
                    <div class="titulo_formulario" layout="column" layout-align="start start">
                        <div ng-click="closeNomValLyr()">
                            Existentes
                        </div>
                    </div>
                    <div style="height: 100%; overflow:scroll">
                        <div flex ng-repeat="line in lines.list" flex="column" ng-click="toEdit(this)">
                            <div layout="column" layout-wrap class="cellGridHolder cellGrid" style="height: 50px" >
                                <div flex style="height: 24px">{{line.nombre}} </div>
                            </div>

                        </div>

                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="contactBook">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="addressBook">
                <div class="titulo_formulario" layout="column" layout-align="start start">
                    <div ng-click="closeContackBook()">
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

                <!-- ########################################## FORMULARIO INFO BANCARIA ########################################## -->
                <form ng-controller="bankInfoController" name="bankInfoForm" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex  ng-class="{'onlyread' : (!$parent.edit)}">
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
                            <md-select ng-disabled="$parent.enabled" ng-model="bnk.pais" name ="state" ng-disabled="$parent.enabled" ng-change="setState(this)" md-no-ink>
                                <md-option ng-repeat="country in countries" value="{{country.id}}">
                                    {{country.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20" >
                            <label>Estado</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="bnk.est" name ="state" ng-disabled="$parent.enabled || (bnk.pais==false)" md-no-ink>
                                <md-option ng-repeat="state in states" value="{{state.id}}">
                                    {{state.local_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Ciudad</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="bnk.ciudad" name ="state" ng-disabled="$parent.enabled || (bnk.est==false)" required md-no-ink>
                                <md-option ng-repeat="city in cities" value="{{city.id}}">
                                    {{city.local_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>SWIF</label>
                            <input ng-disabled="$parent.enabled" ng-model="bnk.bankSwift" required/>

                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>IBAN</label>
                            <input ng-disabled="$parent.enabled" ng-model="bnk.bankIban" required/>

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

                <!-- ########################################## FORMULARIO MONEDAS ########################################## -->
                <form name="provMoneda" ng-controller="coinController">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Moneda
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>{{(coins.length == filt.length)?'no quedan monedas':'Monedas'}}</label>
                            <md-select ng-model="cn.coin" name ="state" ng-disabled="(coins.length == filt.length) || $parent.enabled" required md-no-ink>
                                <md-option ng-repeat="coin in coins | filterSelect: filt" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <div layout="row" ng-repeat="coinSel in coinAssign">
                            <div layout="10">{{coinSel.nombre}} ({{coinSel.simbolo}})</div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="provCred" ng-controller="creditCtrl" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit || coins.length<1)}" >
                        <div>
                            Credito
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="30">
                            <label>Limite de Credito</label>
                            <input ng-disabled="$parent.enabled || coins.length<1" ng-model="cred.amount" required >
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Moneda</label>
                            <md-select ng-model="cred.coin" name ="state" ng-disabled="$parent.enabled || coins.length<1" ng-controller="provCoins" required md-no-ink>
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
                            <div flex class="headGrid"></div>
                        </div>
                        <div id="grid">
                            <div flex ng-repeat="lim in limits" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <!--<div flex="20" class="cellGrid"> {{lim.fecha}}</div>-->
                                    <div flex="20" class="cellGrid"> {{lim.limite}}</div>
                                    <div flex="30" class="cellGrid">{{lim.moneda.nombre}}</div>
                                    <div flex class="cellGrid"></div>
                                </div>
                            </div>

                        </div>

                    </div>
                </form>

                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="condHeadFrm" ng-controller="condPayList" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}" >
                        <div flex>
                           Condiciones de pago
                        </div>

                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="60">
                            <label>Titulo</label>
                            <input ng-disabled="$parent.enabled" ng-model="condHead.title" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Linea</label>
                            <md-select ng-model="condHead.line" ng-disabled="$parent.enabled" required md-no-ink>
                                <md-option ng-repeat="line in lines" value="{{line.id}}">
                                    {{line.linea}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <div style="width:24px;">
                            <?= HTML::image("images/menu.png","",array("ng-click"=>"openFormCond()","ng-show"=>"(condHead.id)")) ?>
                        </div>
                    </div>
                    <div layout="column" ng-show="isShow">

                        <div layout="row" class="headGridHolder">
                            <!--<div flex="20" class="headGrid"> Fecha</div>-->
                            <div flex="20" class="headGrid"> Titulo</div>
                            <div flex="30" class="headGrid"> Linea</div>
                            <div flex class="headGrid"></div>
                        </div>
                        <div id="grid">
                            <div flex ng-repeat="condition in conditions" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder" style="height: 50px">
<!--                                    <div flex layout="row">-->
                                        <div flex="30" class="cellGrid"> {{condition.titulo}}</div>
                                        <div flex="30" class="cellGrid">{{condition.line.linea}}</div>
                                        <div flex class="cellGrid"><span ng-repeat="item in condition.items">{{item.porcentaje}}% {{item.dias}} dias, {{item.descripcion}} | </span></div>
<!--                                    </div>-->
<!--                                    <div flex layout="row">-->
<!--                                        <span ng-repeat="item in condition.items">{{item.porcentaje}} {{item.dias}} {{item.descripcion}}</span>-->
<!--                                    </div>-->
                                </div>
                            </div>

                        </div>

                    </div>
                </form>
                <!-- ########################################## FORMULARIO FACTOR CONVERSION ########################################## -->
                <form name="provConv" ng-controller="convController" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex  ng-class="{'onlyread' : (!$parent.edit || coins.length < 1)}">
                        <div>
                            Factor de Conversión
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>% Flete</label>
                            <input ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.freight">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>% Gastos</label>
                            <input ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.expens">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>% Ganancia</label>
                            <input ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.gain">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>% Descuento</label>
                            <input ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.disc">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                            <label>Moneda</label>
                            <md-select ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.coin" name="state" required md-no-ink>
                                <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> Flete</div><div flex="20" class="headGrid"> Gastos</div><div flex="20" class="headGrid"> Ganancia </div><div flex="20" class="headGrid"> Descuento</div><div flex="20" class="headGrid"> Moneda</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="factor in factors" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="20" class="cellGrid"> {{factor.flete}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{factor.gastos}}</div><div flex="20" class="cellGrid">{{factor.ganancia}}</div><div flex="20" class="cellGrid">{{factor.descuento}}</div><div flex="20" class="cellGrid">{{factor.moneda.nombre}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO PUNTOS ########################################## -->
                <form name="provPoint" ng-controller="provPointController" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex  ng-class="{'onlyread' : (!$parent.edit || coins.length < 1)}">
                        <div>
                            Puntos
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="30">
                            <label>Costo del punto</label>
                            <input ng-disabled="$parent.enabled || coins.length < 1" ng-model="pnt.cost" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                            <label>Moneda</label>
                            <md-select ng-disabled="$parent.enabled || coins.length < 1" ng-model="pnt.coin" required md-no-ink>
                                <md-option ng-repeat="coin in coins" ng-hide="(coin.pivot.punto)" value="{{coin.id}}">
                                    {{coin.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="30" class="headGrid"> punto</div><div flex="20" class="headGrid"> Moneda</div><div flex class="headGrid"></div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="point in coins" ng-click="toEdit(this)" ng-show="point.pivot.punto">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="30" class="cellGrid"> {{point.pivot.punto}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{point.nombre}}</div><div flex class="cellGrid"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'layer3')" >

            </div>
        </md-sidenav>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="payCond">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="payCondItemController" >
                <div class="titulo_formulario" layout="column" layout-align="start start" ng-click="closeCondition()">
                    <div>
                       {{head.title}} <i>({{head.line}})</i>
                    </div>
                </div>
                <!--<form name="headCond">
                    <div layout="row">
                        <md-input-container class="md-block" flex="60">
                            <label>Titulo</label>
                            <input ng-disabled="$parent.enabled" ng-model="condHead.title" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Linea</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="condHead.line" ng-disabled="$parent.enabled" required md-no-ink>
                                <md-option ng-repeat="line in lines" value="{{line.id}}">
                                    {{line.linea}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                </form>-->
                <form name="itemCondForm">
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>%</label>
                            <input ng-disabled="$parent.enabled" ng-model="condItem.percent" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Dias</label>
                            <input ng-disabled="$parent.enabled" ng-model="condItem.days" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Condicion</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="condItem.condit" ng-disabled="$parent.enabled" required md-no-ink>
                                <md-option ng-repeat="cond in [{name:'adelanto',id:0},{name:'contra BL',id:1},{name:'despues de carga',id:2},{name:'antes carga',id:3},]" value="{{cond.name}}">
                                    {{cond.name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div id="grid">
                        <div flex ng-repeat="condition in conditions" ng-click="toEdit(this)">
                            <div layout="row" layout-wrap class="cellGridHolder">
                                <!--                                    <div flex layout="row">-->
                                <div flex="30" class="cellGrid"> {{condition.porcentaje}}</div>
                                <div flex="30" class="cellGrid">{{condition.dias}}</div>
                                <div flex class="cellGrid">{{condition.descripcion}}</div>
                            </div>
                        </div>

                    </div>
                </form>
            </md-content>
        </md-sidenav>
        <!-- ########################################## LAYER (4) TIEMPOS (PRODUCCION/TRANSITO) ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer3" id="layer3">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <!-- ########################################## FORMULARIO TIEMPO PRODUCCION ########################################## -->
                <form name="timeProd" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex  ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Tiempo Aproximado de Producción
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>De (Dias)</label>
                            <input ng-disabled="$parent.enabled" ng-model="tp.from" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>A (Dias)</label>
                            <input ng-disabled="$parent.enabled" ng-model="tp.to" required>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Linea</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="tp.line" name ="state" ng-disabled="$parent.enabled" md-no-ink>
                                <md-option ng-repeat="line in lines" value="{{line.id}}">
                                    {{line.linea}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> minimo dias</div><div flex="20" class="headGrid">Maximo Dias</div><div flex class="headGrid">Linea</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="time in timesP" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="20" class="cellGrid"> {{time.min_dias}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{time.max_dias}}</div><div flex class="cellGrid">{{time.lines.linea}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO TIEMPO TRANSITO ########################################## -->
                <form name="timeTrans" ng-controller="transTimeController" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex  ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Tiempo Aproximado de Transito
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>De (Dias)</label>
                            <input ng-disabled="$parent.enabled" ng-model="ttr.from">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>A (Dias)</label>
                            <input ng-disabled="$parent.enabled" ng-model="ttr.to">
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="ttr.country" name ="state" ng-disabled="$parent.enabled" md-no-ink required>
                                <md-option ng-repeat="country in provCountries" value="{{country.pais.id}}">
                                    {{country.pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> minimo dias</div><div flex="20" class="headGrid">Maximo Dias</div><div flex class="headGrid">Pais</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="time in timesT" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="20" class="cellGrid"> {{time.min_dias}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{time.max_dias}}</div><div flex class="cellGrid">{{time.country.short_name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form name="provPrecList">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex  ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Listas de Precios
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="40">
                            <label>Referencia</label>
                            <input ng-disabled="$parent.enabled" ng-model="lp.ref">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Archivo</label>
                            <input id="upListPrice" type="file" name="files[]" data-url="" multiple>
                            <input ng-disabled="$parent.enabled" ng-model="lp.file">
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
        <div ng-controller="notificaciones">
        <md-sidenav layout="row" style="top: calc(100% - 144px); height: 96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="lyrAlert" id="lyrAlert">
            <!-- OK   ############################################################################################## -->
            <div class="alertBox alertOkColor" flex ng-show="alerts.ok.length > 0" layout="row">
                <div class="alertPrevArrow" ng-click="alertPrev('ok')" ng-show="alerts.ok.length > 1"></div>
                <md-tabs class="alertContainer" layout="column" md-selected="selected.ok" flex>
                    <md-tab label="{{tab.title}}" layout="column" class="alertItem" flex ng-repeat="tab in alerts.ok">
                        <div class="alertTextContent" style="">
                            {{tab.content}}
                        </div>
                        <div class="alertTextOpcs" layout="row">
                            <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('ok');ok(this)" >
                                {{opc.name}}
                            </div>
                        </div>
                    </md-tab>
                </md-tabs>
                <div class="alertNextArrow" ng-click="alertNext('ok')" ng-show="alerts.ok.length > 1" style="width: 50px;">
                    <div  ng-show="alerts.ok.length>1">{{selected.ok + 1}}/{{alerts.ok.length}}</div>
                </div>
            </div>
            <!-- ALERT ############################################################################################## -->
            <div class="alertBox alertAlertColor" flex ng-show="alerts.alert.length > 0" layout="row">
                <div class="alertPrevArrow" ng-click="alertPrev('alert')" ng-show="alerts.alert.length > 1"></div>
                <md-tabs class="alertContainer" layout="column" md-selected="selected.alert" flex>
                    <md-tab label="{{tab.title}}" layout="column" class="alertItem" ng-repeat="tab in alerts.alert">
                        <div class="alertTextContent" style="">
                            {{tab.content}}
                        </div>
                        <div class="alertTextOpcs" layout="row">
                            <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('alert');ok(this)">
                                {{opc.name}}
                            </div>
                        </div>
                    </md-tab>
                </md-tabs>
                <div class="alertNextArrow" ng-click="alertNext('alert')" ng-show="alerts.alert.length > 1" style="width: 50px;">
                    <div  ng-show="alerts.alert.length>1">{{selected.alert + 1}}/{{alerts.alert.length}}</div>
                </div>
            </div>
            <!-- ERROR ############################################################################################## -->
            <div class="alertBox alertErrorColor" flex ng-show="alerts.error.length > 0" layout="row">
                <div class="alertPrevArrow" ng-click="alertPrev('error')" ng-show="alerts.error.length > 1"></div>
                <md-tabs class="alertContainer"  md-selected="selected.error" flex>
                    <md-tab label="{{tab.title}}" class="alertItem" ng-repeat="tab in alerts.error">
                        <div class="alertTextContent" style="">
                            {{tab.content}}
                        </div>
                        <div class="alertTextOpcs" layout="row">
                            <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('error');ok(this)">
                                {{opc.name}}
                            </div>
                        </div>
                    </md-tab>
                </md-tabs>
                <div class="alertNextArrow" ng-click="alertNext('error')" ng-show="alerts.error.length > 1" style="width: 50px;">
                    <div  ng-show="alerts.error.length>1">{{selected.error + 1}}/{{alerts.error.length}}</div>
                </div>
            </div>
            <!-- INFO ############################################################################################## -->
            <div class="alertBox alertInfoColor" flex ng-show="alerts.info.length > 0" layout="row">
                <div class="alertPrevArrow" ng-click="alertPrev('info')" ng-show="alerts.info.length > 1"></div>
                <md-tabs class="alertContainer" md-selected="selected.info" flex>
                    <md-tab label="{{tab.title}}" class="alertItem" ng-repeat="tab in alerts.info">
                        <div class="alertTextContent" style="">
                            {{tab.content}}
                        </div>
                        <div class="alertTextOpcs" layout="row">
                            <div flex ng-repeat="opc in tab.opcs" ng-click="closeThis('info');ok(this)" >
                                {{opc.name}}
                            </div>
                        </div>

                    </md-tab>
                </md-tabs>
                <div class="alertNextArrow" ng-click="alertNext('info')" ng-show="alerts.info.length > 1" style="width: 50px;">
                    <div  ng-show="alerts.info.length>1">{{selected.info + 1}}/{{alerts.info.length}}</div>
                </div>
            </div>
        </md-sidenav>
</div>
    </div>

</div>


