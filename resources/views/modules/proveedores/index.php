<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="AppCtrl">

    <!-- 2) ########################################## AREA DEL MENU ########################################## -->
    <!--<div layout="row" flex="none" class="menuBarHolder">



    </div>-->

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

        <div class="barraLateral" layout="column">
            <div id="menu" layout="row" flex="none" class="menuBarHolder md-whiteframe-1dp" style="height: 48px">
                <!-- 3) ########################################## MENU ########################################## -->
                <div layout="row" layout-align="start center" class="menu" style="height: 48px;">
                    <div flex layout-align="center center" ng-click="showAlert()">
                        Menu
                    </div>
                    <div layout="column" style="width: 48px; height: 48px;" layout-align="center center" ng-click="menuExpand()">
                        <?= HTML::image("images/btn_nextArrow.png") ?>
                    </div>
                </div>
            </div>
            <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
            <!--<md-content flex class="barraLateral" ng-controller="ListProv">-->
            <div flex ng-controller="ListProv" style="overflow-y:auto;">
                <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
                <div class="boxList" layout="column" flex ng-repeat="item in todos" ng-click="setProv(this)" ng-class="{'listSel' : (item.id ==prov.id),'listSelTemp' : (!item.id)}">
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ item.razon_social }}</div>
                    <div style="height:40px; font-size:31px; overflow: hidden;">{{(item.limCred)?item.limCred:'000000'}}</div>
                    <div style="height:40px;">
                        <!--<i ng-show="(item.contraped==1)" class="fa fa-gift" style="font-size:24px;"></i>-->

                       <!-- <img ng-show="(item.contrapedido==1)" src="images/contra_pedido.png" />-->

                        <span ng-show="(item.contrapedido==1)" class=" icon2-contrapedidos" style="font-size: 23px"></span>
                        <span ng-show="(item.tipo_envio_id==1 || item.tipo_envio_id==3)" class="icon-Aereo" style="font-size: 24px"></span>
                       <!-- <img ng-show="(item.tipo_envio_id==1 || item.tipo_envio_id==3)" src="images/Aereo.svg" />-->
                       <!-- <img ng-show="(item.tipo_envio_id==1 || item.tipo_envio_id==3)" src="images/aereo.png" />-->
                        <img ng-show="(item.tipo_envio_id==2 || item.tipo_envio_id==3)" src="images/maritimo.png" />
                    </div>
                </div>
            </div>
            <!--</md-content>-->
        </div>

        <div layout="column" flex class="md-whiteframe-1dp">
            <!-- 4) ########################################## BOTONERA ########################################## -->
            <div class="botonera" layout layout-align="start center">
                <div layout="column" layout-align="center center">

                </div>
                <div layout="column" layout-align="center center" ng-click="addProv()">
                    <!--<i class="fa fa-plus"></i>-->
                    <span class="icon-Agregar" style="font-size: 24px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="editProv()" ng-show="prov.id">
                    <span class="icon-Actualizar" style="font-size: 24px"></span>
                   <!-- --><?/*= HTML::image("images/actualizar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="showAlert()" ng-show="prov.id">
                    <span class="icon-Filtro" style="font-size: 24px"></span>
                    <?/*= HTML::image("images/filtro.png") */?>
                </div>
            </div>

            <div flex layout="row">
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
                    <br> Selecciones un Proveedor
                </div>
            </div>
        </div>


        <!-- 10) ########################################## LAYER (1) RESUMEN DEL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer0">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="row" flex ng-controller="resumenProv">
                <!-- 12) ########################################## COLUMNA 1 RESUMEN ########################################## -->
                <div layout="column" flex style="margin-right:8px;">
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            Proveedor
                        </div>
                    </div>
                    <div style="height:39px;">
                        <div class="textResm" style="width:calc(70% - 8px); height:39px; float:left;">
                            {{prov.razon_social}}

                        </div>

                        <div class="textResm" style="width:calc(30% - 8px); height:39px; float:left;">
                            {{prov.siglas}}
                        </div>
                    </div>
                    <div class="titulo_formulario" style="height:39px;" layout-align="start start">
                        <div>
                            Nombres Valcro
                        </div>
                    </div>
                    <div flex style="overflow-y:auto;">
                        <div class="itemName" ng-repeat="name in prov.nomValc">
                            {{name.nombre}}
                        </div>
                    </div>
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            Tipo de envio
                        </div>
                    </div>
                    <div style="height:39px;">
                        <div flex>
                            <img ng-show="(prov.tipo_envio_id==1 || prov.tipo_envio_id==3)" src="images/aereo.png" />
                            <img ng-show="(prov.tipo_envio_id==2 || prov.tipo_envio_id==3)" src="images/maritimo.png" />
                        </div>
                    </div>

                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            Tiempos Estimados
                        </div>
                    </div>
                    <div style="height:24px;">
                        Produccion:
                    </div>
                    <div flex style="overflow-y: auto;">
                        <div style="height:23px; overflow: hidden; text-overflow: ellipsis; margin-top: 8px; margin-bottom: 8px;" ng-repeat="tiempo in prov.tiemposP">
                            de: <b>{{tiempo.min_dias}}</b> a <b>{{tiempo.max_dias }}</b> para <b>{{tiempo.lines.linea}}</b>
                        </div>
                    </div>
                    <div style="height:24px;">
                        Transito:
                    </div>
                    <div flex style="overflow-y: auto;">
                        <div style="height:23px; overflow: hidden; text-overflow: ellipsis; margin-top: 8px; margin-bottom: 8px;" ng-repeat="tiempo in prov.tiemposT">
                            de: <b>{{tiempo.min_dias}}</b> a <b>{{tiempo.max_dias }}</b> desde <b>{{tiempo.country.short_name}}</b>
                        </div>
                    </div>

                </div>

                <!-- 13) ########################################## COLUMNA 2 RESUMEN ########################################## -->
                <div layout="column" flex style="margin-right:8px;">
                    <div flex>
                        <div class="titulo_formulario" style="height: 39px;">
                            <div>
                                Direcciones
                            </div>
                        </div>
                        <div style="overflow-y: auto; height: calc(100% - 39px);">
                            <div ng-repeat="direccion in prov.direcciones" style="height: 60px; width:100%;">
                                <div style="width: 30%; height: 20px; float: left; overflow: hidden; text-overflow: ellipsis; font-weight:bold;">
                                    {{direccion.tipo.descripcion}}
                                </div>
                                <div style="width: 70%; height: 20px; float: left; overflow: hidden; text-overflow: ellipsis;">
                                    {{direccion.country.short_name}}
                                </div>
                                <div style="width: 100%; height: 39px; float: left; overflow: hidden; text-overflow: ellipsis;">
                                    {{direccion.direccion}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div flex>
                        <div class="titulo_formulario" style="height: 39px;">
                            <div>
                                Contactos
                            </div>
                        </div>
                        <div style="overflow-y: auto; height: calc(100% - 39px);">
                            <div ng-repeat="contact in prov.contacts" style="height: 39px;">
                                <div style="width: 100%; height: 39px; float: left; overflow: hidden; text-overflow: ellipsis;">
                                    <span style="font-weight: bold !important; float:left;">{{contact.nombre}}: </span>
                                    <span style="float:left;" ng-repeat="cargo in contact.cargos">{{cargo.cargo}},</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 14) ########################################## COLUMNA 3 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div style="height:78px;">
                        <div class="titulo_formulario" style="height: 39px;">
                            <div>
                                Monedas
                            </div>
                        </div>
                        <div style="overflow-y: auto; height: calc(100% - 39px);">
                            <div ng-repeat="moneda in prov.monedas" style="float:left; height:24px;">
                                <span style="font-weight:bold;">{{moneda.nombre}} &nbsp;</span>({{moneda.simbolo}})
                            </div>
                        </div>
                    </div>
                    <div flex>
                        <div class="titulo_formulario" style="height: 39px;">
                            <div>
                                Puntos
                            </div>
                        </div>
                        <div style="overflow-y: auto; height: calc(100% - 39px);">
                            <div ng-repeat="point in prov.monedas" ng-show="point.pivot.punto">
                                <div style="width: 30%; float:left;">{{point.nombre}}</div>
                                <div style="width: 70%; float:left;">{{point.pivot.punto}} {{point.simbolo}}</div>
                            </div>
                        </div>
                    </div>

                    <div flex>
                        <div class="titulo_formulario" style="height: 39px;" ng-class="{'title_error' : (prov.limCred.length < 1)}">
                            <div>
                                Limites de Credito
                            </div>
                        </div>
                        <div style="overflow-y: auto; height: calc(100% - 39px);">
                            <div ng-repeat="lim in prov.limites" style="width: 100%;">
                                <div style="width: 30%; float:left;">{{lim.moneda.nombre}}</div>
                                <div style="width: 70%; float:left;">{{lim.limite}} {{lim.moneda.simbolo}}</div>
                            </div>
                        </div>
                    </div>
                    <div flex>
                        <div class="titulo_formulario" style="height: 39px;">
                            <div>
                                Cuentas Bancarias
                            </div>
                        </div>
                        <div style="overflow-y: auto; height:calc(100% - 39px); posi">
                            <div ng-repeat="bank in prov.banks" style="width: 100%;">
                                <div style="width: 100%; height:24px; font-weight:bold;">{{bank.banco}}</div>
                                <div style="width: 100%; height:24px;">{{bank.cuenta}}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'layer1')">

            </div>

        </md-sidenav>


        <!-- 15) ########################################## LAYER (2) FORMULARIO INFORMACION DEL PROVEEDOR ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">

            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <!-- 17) ########################################## FORMULARIO "Datos Basicos del Proveedor" ########################################## -->
                <form name="projectForm" ng-controller="DataProvController" ng-disabled="true" click-out="projectForm.$setUntouched()">

                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit && prov.id)}">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo</label>
                            <md-select info="seleccione un tipo de proveedor" ng-model="dtaPrv.type" ng-disabled="$parent.enabled && prov.id" md-no-ink>
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
                            <input info="indique el nombre del proveedor" autocomplete="off" ng-blur="check('description')" duplicate="list" field="razon_social" maxlength="80" ng-minlength="3" required md-no-asterisk name="description" ng-model="dtaPrv.description">
                            <!--ng-disabled="($parent.enabled || (toCheck && projectForm.description.$valid))"-->
                            <!--INICIO DE DIRECTIVA PARA FUNCION DE SOLO CHEQUEO (SKIP RED TO RED)-->
                            <!--<div ng-messages="projectForm.description.$error" ng-hide>
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="10" ng-click="inputSta(true)">
                            <label>Siglas</label>
                            <input info="minimo 3 letras maximo 4" autocomplete="off" ng-blur="check('siglas')" duplicate="list" field="siglas" maxlength="6" ng-minlength="3" required name="siglas" ng-model="dtaPrv.siglas" ng-disabled="$parent.enabled && prov.id">
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo de Envio</label>
                            <md-select info="seleccione un tipo de envio" ng-model="dtaPrv.envio" ng-disabled="$parent.enabled && prov.id" md-no-ink>
                                <md-option ng-repeat="envio in envios" value="{{envio.id}}">
                                    {{envio.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="envio.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-switch info="puede hacer contrapedidos a este proveedor" class="md-primary" ng-model="dtaPrv.contraped" aria-label="Contrapedidos" ng-disabled="$parent.enabled && prov.id">
                                Contrapedidos?
                            </md-switch>
                        </md-input-container>



                    </div>

                    <div layout="row">


                        <div flex></div>

                    </div>
                </form>

                <!-- 18) ########################################## FORMULARIO "Nombres Valcro" ########################################## -->
                <form name="nomvalcroForm" ng-controller="valcroNameController"  ng-click="showGrid(true)" click-out="showGrid(false,$event)">
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
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <md-input-container class="md-block" flex id="valcroName">
                            <label>Nombre...</label>
                            <input autocomplete="off" autocomplete="off" duplicate="allName" field="nombre" ng-minlength="3" required name="siglas" ng-model="valName.name" ng-disabled="$parent.enabled">
                        </md-input-container>

                        <div ng-show="isShow">
                            <div ng-repeat="name in valcroName" class="itemName" ng-click="toEdit(this)" ng-class="{'gridSel':(name.id==valName.id)}" ng-mouseleave="over(false)" ng-mouseover="over(this)"><span ng-class="{'rm' : (name.id==valName.id) || (name.id==overId)}" style="font-size:11px; margin-right: 8px; color: #f1f1f1;" class="icon-Eliminar" ng-click="rmValName(this)"></span>{{name.name}} </div>
                        </div>
                    </div>
                </form>

                <!-- 19) ########################################## FORMULARIO "Direcciones del Proveedor" ########################################## -->
                <form name="direccionesForm" ng-controller="provAddrsController" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Direcciones
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
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
                                    <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                        {{pais.short_name}}
                                    </md-option>
                                </md-select>
                                <!--<div ng-messages="user.pais.$error">
                                    <div ng-message="required">Campo Obligatorio.</div>

                                </div>-->
                            </md-input-container>
                            <md-input-container class="md-block" flex="20">
                                <label>Codigo Postal</label>
                                <input autocomplete="off" md-no-asterisk ng-model="dir.zipCode" ng-disabled="$parent.enabled" />
                            </md-input-container>

                            <md-input-container class="md-block" flex="30">
                                <label>Telefono</label>
                                <input autocomplete="off" ng-blur="checkCode()" name="provTelf" required md-no-asterisk ng-model="dir.provTelf" ng-disabled="$parent.enabled" />
                            </md-input-container>

                        </div>
                        <md-input-container class="md-block" flex ng-show="dir.tipo==2">
                            <label>puertos</label>
                            <md-select ng-model="dir.ports" multiple="" md-no-ink ng-disabled="$parent.enabled || !dir.pais">
                                <md-option ng-repeat="port in ports | customFind : dir.pais : searchPort" value="{{port.id}}">
                                    {{port.Main_port_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Direccion</label>
                            <input autocomplete="off"  ng-disabled="$parent.enabled" maxlength="250" ng-minlength="5" required md-no-asterisk name="direccProv" ng-model="dir.direccProv">
                        </md-input-container>
                        <div layout="column" ng-show="isShow && !isShowMore" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{address.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>
                            <div layout="row" class="headGridHolder">
                                <div flex="10" class="headGrid"> Tipo</div>
                                <div flex="20" class="headGrid"> Pais</div>
                                <div flex class="headGrid"> Direccion</div>
                                <div flex="20" class="headGrid"> Telefono</div>
                            </div>
                            <div id="grid" style="overflow-y: auto">
                                <div flex ng-repeat="add in address" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(add.id == dir.id)}">
                                        <div ng-show="(add.id==dir.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmAddres(this)"></div>
                                        <div flex="10" class="cellGrid"> {{add.tipo.descripcion}}</div>
                                        <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{add.pais.short_name}}</div>
                                        <div flex class="cellGrid">{{add.direccion}}</div>
                                        <div flex="20" class="cellGrid">{{add.telefono}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

                <!-- 20) ########################################## FORMULARIO "Contactos del Proveedor" ########################################## -->
                <form name="provContactosForm" ng-controller="contactProv" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Contactos Proveedor
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">

                            <md-input-container class="md-block" flex="30">
                                <label>Nombre y Apellido</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || cnt.isAgent==1" name="nombreCont" maxlength="55" ng-minlength="3" required md-no-asterisk ng-model="cnt.nombreCont" ng-dblclick="book()">
                            </md-input-container>

                            <md-input-container class="md-block" flex="35">
                                <label>Email</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || cnt.isAgent==1" name="emailCont" minlength="10" maxlength="100" required ng-model="cnt.emailCont" ng-pattern="/^.+@.+\..+$/" />
                            </md-input-container>
                            <md-input-container class="md-block" flex="15">
                                <label>Pais de Residencia</label>
                                <md-select ng-model="cnt.pais" ng-disabled="(cnt.id===false)  || $parent.enabled || cnt.isAgent==1" md-no-ink>
                                    <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                        {{pais.short_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>Telefono</label>
                                <input autocomplete="off" name="contTelf" md-no-asterisk ng-model="cnt.contTelf" ng-disabled="(cnt.id===false) || $parent.enabled || cnt.isAgent==1" />
                            </md-input-container>

                        </div>
                        <div layout="row">
                            <div layout="row" flex="30">
                                <md-input-container flex>
                                    <label>Idiomas</label>
                                    <md-select  ng-model="cnt.languaje" multiple="" ng-disabled="(cnt.id===false) || $parent.enabled || cnt.isAgent==1" md-no-ink>
                                        <md-option ng-value="lang.id" ng-repeat="lang in languaje">{{lang.lang}}</md-option>

                                    </md-select>
                                </md-input-container>
                            </div>

                            <div layout="row" flex="30">
                                <md-input-container flex>
                                    <label>cargos</label>
                                    <md-select ng-model="cnt.cargo" multiple="" ng-disabled="(cnt.id===false) || $parent.enabled || cnt.isAgent==1" md-no-ink>
                                        <md-option ng-value="cargo.id" ng-repeat="cargo in cargos">{{cargo.cargo}}</md-option>
                                    </md-select>
                                </md-input-container>
                            </div>

                            <md-input-container class="md-block" flex="40">
                                <label>Responsabilidades</label>
                                <input autocomplete="off" name="cntcRespon" maxlength="100" ng-minlength="3" ng-model="cnt.responsability" ng-disabled="(cnt.id===false)  || $parent.enabled || cnt.isAgent==1">
                            </md-input-container>

                        </div>
                        <div layout="row" flex>
                            <md-input-container class="md-block" flex>
                                <label>Direccion de Oficina</label>
                                <input autocomplete="off" name="cntcDirOfc" maxlength="200" ng-model="cnt.dirOff" ng-minlength="3" ng-disabled="(cnt.id===false)  || $parent.enabled || cnt.isAgent==1">
                            </md-input-container>
                        </div>

                        <div layout="column" ng-show="isShow && !isShowMore" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{contacts.length}})</div>
                        </div>

                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder">
                                <div flex="20" class="headGrid"> Nombre</div>
                                <div flex class="headGrid"> Email</div>
                                <div flex="10" class="headGrid"> Telefono</div>
                                <div flex="20" class="headGrid"> Pais</div>
                            </div>
                            <div id="grid" style="overflow-y: auto; height: 120px">
                                <div flex ng-repeat="cont in contacts" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(cont.id == cnt.id)}">
                                        <div ng-show="(cont.id==cnt.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmContact(this)"></div>
                                        <div flex="20" class="cellGrid"> {{cont.nombre}}</div>
                                        <div flex class="cellGrid"> {{cont.email}}</div>
                                        <div flex="10" class="cellGrid">{{cont.telefono}}</div>
                                        <div flex="20" class="cellGrid">{{cont.pais.short_name}}</div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>


            </md-content>

            <div style="width: 16px;" ng-mouseover="showNext(true,'layer2')">

            </div>

        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="nomValLyr">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="nomValAssign">
                <div layout="column" flex style="overflow-x: hidden;">
                    <div class="titulo_formulario" layout="column" layout-align="start start">
                        <div ng-click="closeNomValLyr()">
                            Existentes
                        </div>
                    </div>
                    <div style="height: 100%; overflow:scroll">
                        <div flex ng-repeat="line in lines.list" flex="column" ng-click="toEdit(this)">
                            <div layout="column" layout-wrap class="cellGridHolder cellGrid" style="height: 50px">
                                <div flex style="height: 24px">{{line.nombre}} </div>
                            </div>

                        </div>

                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="contactBook" id="contactBook">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="addressBook">
                <div class="titulo_formulario" layout="column" layout-align="start start" style="heigth:39px;">
                    <div ng-click="closeContackBook()">
                        Contactos Existentes
                    </div>
                </div>
                <div style="height: calc(100% - 39px); overflow-y: auto">
                    <div ng-repeat="cont in allContact | customFind : prov.id : filtByprov " layout="column" ng-click="toEdit(this)">
                        <div layout="column" layout-wrap class="cellGridHolder cellGrid" ng-class="{'ligthCell':cont.provs.length==0}"  style="height: 72px">
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
                <form ng-controller="bankInfoController" name="bankInfoForm" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Informacion Bancaria
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="30">
                                <label>Banco</label>
                                <input autocomplete="off" ng-model="bnk.bankName" required/>

                            </md-input-container>
                            <md-input-container class="md-block" flex="30">
                                <label>Nombre Beneficiario</label>
                                <input autocomplete="off" ng-model="bnk.bankBenef" required/>

                            </md-input-container>
                            <md-input-container class="md-block" flex="40">
                                <label>Direccion</label>
                                <input autocomplete="off" ng-model="bnk.bankAddr" />

                            </md-input-container>
                        </div>

                        <div layout="row">
                            <md-input-container class="md-block" flex="20">
                                <label>Pais</label>
                                <md-select ng-disabled="$parent.enabled" ng-model="bnk.pais" name="state" ng-disabled="$parent.enabled" ng-change="setState(this)" md-no-ink>
                                    <md-option ng-repeat="country in countries" value="{{country.id}}">
                                        {{country.short_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>Estado</label>
                                <md-select ng-disabled="$parent.enabled" ng-model="bnk.est" name="state" ng-disabled="$parent.enabled || (bnk.pais==false)" md-no-ink>
                                    <md-option ng-repeat="state in states" value="{{state.id}}">
                                        {{state.local_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>Ciudad</label>
                                <md-select ng-disabled="$parent.enabled" ng-model="bnk.ciudad" name="state" ng-disabled="$parent.enabled || (bnk.est==false)" required md-no-ink>
                                    <md-option ng-repeat="city in cities" value="{{city.id}}">
                                        {{city.local_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>SWIF</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="bnk.bankSwift" required/>

                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>IBAN</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="bnk.bankIban" required/>

                            </md-input-container>
                        </div>

                        <div layout="column" ng-show="isShow && !isShowMore" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{accounts.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder">
                                <div flex="20" class="headGrid"> Banco</div>
                                <div flex class="headGrid"> Beneficiario</div>
                                <div flex="30" class="headGrid"> Cuenta</div>
                            </div>
                            <div id="grid">
                                <div flex ng-repeat="account in accounts" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(account.id == bnk.id)}">
                                        <div ng-show="(account.id==bnk.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmBank(this)"></div>
                                        <div flex="20" class="cellGrid"> {{account.banco}}</div>
                                        <div flex class="cellGrid"> {{account.beneficiario}}</div>
                                        <div flex="30" class="cellGrid">{{account.cuenta}}</div>

                                    </div>
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
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="20">
                                <label>{{(coins.length == filt.length)?'no quedan monedas':'Monedas'}}</label>
                                <md-select ng-model="cn.coin" name="state" ng-disabled="(coins.length == filt.length) || $parent.enabled" required md-no-ink>
                                    <md-option ng-repeat="coin in coins | filterSelect: filt" value="{{coin.id}}">
                                        {{coin.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <div layout="row" ng-repeat="coinSel in coinAssign">
                                <div class="coinDiv">{{coinSel.simbolo}}</div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="provCred" ng-controller="creditCtrl" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit || coins.length<1)}">
                        <div>
                            Credito
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="30">
                                <label>Limite de Credito</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || coins.length<1" ng-model="cred.amount" required>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>Moneda</label>
                                <md-select ng-model="cred.coin" name="state" ng-disabled="$parent.enabled || coins.length<1" ng-controller="provCoins" required md-no-ink>
                                    <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                        {{coin.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="30">
                                <label>Linea</label>
                                <md-select ng-disabled="$parent.enabled" ng-model="cred.line" name="state" ng-disabled="$parent.enabled" md-no-ink>
                                    <md-option ng-repeat="line in lines" value="{{line.id}}">
                                        {{line.linea}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div layout="column" ng-show="isShow && !isShowMore" class="showMoreDiv" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{limits.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder">
                                <!--<div flex="20" class="headGrid"> Fecha</div>-->
                                <div flex="20" class="headGrid"> Limite</div>
                                <div flex="30" class="headGrid"> Moneda</div>
                                <div flex="30" class="headGrid"> Linea</div>
                                <div flex class="headGrid"></div>
                            </div>
                            <div id="grid">
                                <div flex ng-repeat="lim in limits" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(lim.id == cred.id)}">
                                        <div ng-show="(lim.id==cred.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmCredit(this)"></div>
                                        <div flex="20" class="cellGrid"> {{lim.limite}}</div>
                                        <div flex="30" class="cellGrid">{{lim.moneda.nombre}}</div>
                                        <div flex="30" class="cellGrid">{{lim.line.linea}}</div>
                                        <div flex class="cellGrid"></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>

                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="condHeadFrm" ng-controller="condPayList" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Condiciones de pago
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="60">
                                <label>Titulo</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="condHead.title" required>
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
                        <div layout="column" ng-show="isShow && !isShowMore" class="showMoreDiv" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{conditions.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder">
                                <!--<div flex="20" class="headGrid"> Fecha</div>-->
                                <div flex="20" class="headGrid"> Titulo</div>
                                <div flex="30" class="headGrid"> Linea</div>
                                <div flex class="headGrid"></div>
                            </div>
                            <div id="grid">
                                <div flex ng-repeat="condition in conditions" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" style="height: 50px"  ng-class="{'rowSel':(condition.id == condHead.id)}">
                                        <div ng-show="(condition.id==condHead.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmCond(this)"></div>
                                        <div flex="30" class="cellGrid"> {{condition.titulo}}</div>
                                        <div flex="30" class="cellGrid">{{condition.line.linea}}</div>
                                        <div flex class="cellGrid"><span ng-repeat="item in condition.items">{{item.porcentaje}}% {{item.dias}} dias, {{item.descripcion}} | </span></div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO FACTOR CONVERSION ########################################## -->
                <form name="provConv" ng-controller="convController" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit || coins.length < 1)}">
                        <div>
                            Factor de Conversión
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="10">
                                <label>% Flete</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.freight">
                            </md-input-container>
                            <md-input-container class="md-block" flex="10">
                                <label>% Gastos</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.expens">
                            </md-input-container>
                            <md-input-container class="md-block" flex="10">
                                <label>% Ganancia</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.gain">
                            </md-input-container>
                            <md-input-container class="md-block" flex="10">
                                <label>% Descuento</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.disc">
                            </md-input-container>
                            <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                                <label>Moneda</label>
                                <md-select ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.coin" name="state" required md-no-ink>
                                    <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                        {{coin.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <md-input-container class="md-block" flex>
                                <label>Linea</label>
                                <md-select ng-model="conv.line" ng-disabled="$parent.enabled" required md-no-ink>
                                    <md-option ng-repeat="line in lines" value="{{line.id}}">
                                        {{line.linea}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div layout="column" ng-show="isShow && !isShowMore" class="showMoreDiv" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{factors.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>
                            <div layout="row" class="headGridHolder">
                                <div flex="10" class="headGrid"> Flete</div>
                                <div flex="10" class="headGrid"> Gastos</div>
                                <div flex="10" class="headGrid"> Ganancia </div>
                                <div flex="10" class="headGrid"> Descuento</div>
                                <div flex="30" class="headGrid"> Moneda</div>
                                <div flex="30" class="headGrid"> Linea</div>
                            </div>
                            <div id="grid" style="overflow-y: auto; height: 120px">
                                <div flex ng-repeat="factor in factors" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder"  ng-class="{'rowSel':(factor.id == conv.id)}">
                                        <div ng-show="(factor.id==conv.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmConv(this)"></div>
                                        <div flex="10" class="cellGrid"> {{factor.flete}}</div>
                                        <div flex="10" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{factor.gastos}}</div>
                                        <div flex="10" class="cellGrid">{{factor.ganancia}}</div>
                                        <div flex="10" class="cellGrid">{{factor.descuento}}</div>
                                        <div flex class="cellGrid">{{factor.moneda.nombre}}</div>
                                        <div flex="30" class="cellGrid">{{factor.linea.linea}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO PUNTOS ########################################## -->
                <form name="provPoint" ng-controller="provPointController" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit || coins.length < 1)}">
                        <div>
                            Puntos
                        </div>
                    </div>
                    <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="30">
                                <label>Costo del punto</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="pnt.cost" required>
                            </md-input-container>
                            <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                                <label>Moneda</label>
                                <md-select ng-disabled="$parent.enabled || coins.length < 1" ng-model="pnt.coin" required md-no-ink>
                                    <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                        {{coin.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <md-input-container class="md-block" flex>
                                <label>Linea</label>
                                <md-select ng-model="pnt.line" ng-disabled="$parent.enabled" required md-no-ink>
                                    <md-option ng-repeat="line in lines" value="{{line.id}}">
                                        {{line.linea}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div layout="column" ng-show="isShow && !isShowMore" class="showMoreDiv" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{points.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>
                            <div layout="row" class="headGridHolder">
                                <div flex="30" class="headGrid"> punto</div>
                                <div flex="20" class="headGrid"> Moneda</div>
                                <div flex="20" class="headGrid"> Linea</div>
                                <div flex class="headGrid"></div>
                            </div>
                            <div id="grid" style="overflow-y: auto; height: 120px">
                                <div flex ng-repeat="point in points" ng-click="toEdit(this)" >
                                    <div layout="row" layout-wrap class="cellGridHolder">
                                        <div flex="30" class="cellGrid"> {{point.costo}}</div>
                                        <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{point.moneda.nombre}}</div>
                                        <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{point.linea.linea}}</div>
                                        <div flex class="cellGrid"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'layer3')">

            </div>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: 360px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="payCond" id="payCond">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="payCondItemController">
                <div class="titulo_formulario" layout="column" layout-align="start start" ng-click="closeCondition()">
                    <div>
                        {{head.title}} <i>({{head.line}})</i>
                    </div>
                </div>

                <form name="itemCondForm" click-out="showInterGrid(false,$event)">

                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>%</label>
                            <input autocomplete="off" type="number" max="{{max}}"  ng-disabled="$parent.enabled || max<=0" ng-model="condItem.percent" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Dias</label>
                            <input autocomplete="off" ng-disabled="$parent.enabled || max<=0" ng-model="condItem.days" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Condicion</label>
                            <md-select ng-disabled="$parent.enabled || max<=0" ng-model="condItem.condit" ng-disabled="$parent.enabled" required md-no-ink>
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
                <form name="timeProd" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Tiempo Aproximado de Producción
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>De (Dias)</label>
                            <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="tp.from" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>A (Dias)</label>
                            <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="tp.to" required>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Linea</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="tp.line" name="state" ng-disabled="$parent.enabled" md-no-ink>
                                <md-option ng-repeat="line in lines" value="{{line.id}}">
                                    {{line.linea}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> minimo dias</div>
                            <div flex="20" class="headGrid">Maximo Dias</div>
                            <div flex class="headGrid">Linea</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="time in timesP" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="20" class="cellGrid"> {{time.min_dias}}</div>
                                    <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{time.max_dias}}</div>
                                    <div flex class="cellGrid">{{time.lines.linea}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ########################################## FORMULARIO TIEMPO TRANSITO ########################################## -->
                <form name="timeTrans" ng-controller="transTimeController" ng-click="showGrid(true)" click-out="showGrid(false)">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Tiempo Aproximado de Transito
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>De (Dias)</label>
                            <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="ttr.from">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>A (Dias)</label>
                            <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="ttr.to">
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-disabled="$parent.enabled" ng-model="ttr.country" name="state" ng-disabled="$parent.enabled" md-no-ink required>
                                <md-option ng-repeat="country in provCountries" value="{{country.pais.id}}">
                                    {{country.pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="20" class="headGrid"> minimo dias</div>
                            <div flex="20" class="headGrid">Maximo Dias</div>
                            <div flex class="headGrid">Pais</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="time in timesT" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="20" class="cellGrid"> {{time.min_dias}}</div>
                                    <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{time.max_dias}}</div>
                                    <div flex class="cellGrid">{{time.country.short_name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <form name="provPrecList">
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                        <div>
                            Listas de Precios
                        </div>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="40">
                            <label>Referencia</label>
                            <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="lp.ref">
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Archivo</label>

                            <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="lp.file">
                        </md-input-container>
                    </div>

                    <div layout="column" ng-show="isShow">
                        <div layout="row" class="headGridHolder">
                            <div flex="70" class="headGrid"> Referencias</div>
                            <div flex="30" class="headGrid"> Archivo</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="add in [{ref:'dasdnl',file:'img.jpg'},{ref:'dasdnl',file:'img.jpg'},{ref:'dasdnl',file:'img.jpg'}]" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="70" class="cellGrid"> {{add.ref}}</div>
                                    <div flex="30" class="headGrid"> {{add.file}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'END')">

            </div>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer5">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="row" flex ng-controller="resumenProvFinal">
                <div flex>
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-show="dataProv.dataProv.length>0">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>

                </div>
                <div flex>

                </div>
                <div flex>

                </div>
            </md-content>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');" layout="column" layout-align="center center" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="NEXT" ng-mouseleave="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png","",array('ng-click'=>"openLayer()")) ?>
        </md-sidenav>
        <!-- 8) ########################################## BOTON Next ########################################## -->
        <div ng-controller="notificaciones" ng-include="template"></div>
</div>

</div>
