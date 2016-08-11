<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="AppCtrl" global>

    <!-- 2) ########################################## AREA DEL MENU ########################################## -->
    <!--<div layout="row" flex="none" class="menuBarHolder">



    </div>-->

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

        <div class="barraLateral" layout="column" ng-controller="ListProv">
            <div id="menu" layout="column" class="md-whiteframe-1dp" style="height: 48px; overflow: hidden; background-color: #f1f1f1; min-height: 48px;">
                <!-- 3) ########################################## MENU ########################################## -->
                <div class="menu" style="min-height: 48px; width: 100%;">
                    <div style="width: calc(100% - 16px); text-align: center; padding-top: 8px; height: 16px;">
                        Menu
                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;"
                         ng-click="FilterLateral()" ng-hide="showLateralFilter">
                        <img ng-src="images/Down.png">
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>
                <div layout="column" flex="" tabindex="-1"  style="padding: 0px 4px 0px 4px;">
                    <form name="provdiderFilter" tabindex="-1">
                        <div class="menuFilter" id="expand1" style="height: 176px;" layout-align="start start" tabindex="-1">
                            <div>
                                <span class="icon-Contrapedidos iconInput" tab-index="-1" ng-click="togglecheck($event,'contraped')" ng-class="{'iconActive':filterProv.contraped=='1','iconInactive':filterProv.contraped=='0'}" style="font-size:23px;margin-rigth:8px"></span>
                                <span class="icon-Aereo" style="font-size: 23px" ng-click="togglecheck($event,'aereo')" ng-class="{'iconActive':filterProv.aereo=='1','iconInactive':filterProv.aereo=='0'}" ></span>
                                <span class="icon-Barco" style="font-size: 23px" ng-click="togglecheck($event,'maritimo')" ng-class="{'iconActive':filterProv.maritimo=='1','iconInactive':filterProv.maritimo=='0'}" /></span>
                            </div>
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Razon  Social</label>
                                <input  type="text" ng-model="filterProv.razon_social"  tabindex="-1" >
                            </md-input-container>
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Pais</label>
                                <input  type="text" ng-model="filterProv.pais"  tabindex="-1" >
                            </md-input-container>
                        </div>
                    </form>
                    <div id="expand2" flex >

                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;" ng-click="FilterLateral()">
                       <!-- <img ng-src="{{imgLateralFilter}}">-->
                        <span class="icon-Up" style="font-size: 24px; width: 24px; height: 24px; color:#ccc" ></span>
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>
            </div>

            <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
            <!--<md-content flex class="barraLateral" ng-controller="ListProv">-->
            <div id="launchList" style="width:0px;height: 0px;" tabindex="-1" list-box></div>
            <div id="listado" flex  style="overflow-y:auto;" ng-click="showAlert(45)" >
                <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
                <div class="boxList"  layout="column" list-box flex ng-repeat="item in todos | customFind : filterProv : filterList" id="prov{{item.id}}" ng-click="setProv(this,$index)" ng-class="{'listSel' : (item.id ==prov.id),'listSelTemp' : (!item.id || (item.id ==prov.id && prov.created))}">
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ item.razon_social }}</div>
                    <div style="height:40px; font-size:31px; overflow: hidden;">{{(item.limCred)?item.limCred:'0' | number:2}}</div>
                    <div style="height:40px;">
                        <!--<i ng-show="(item.contraped==1)" class="fa fa-gift" style="font-size:24px;"></i>-->

                       <!-- <img ng-show="(item.contrapedido==1)" src="images/contra_pedido.png" />-->

                        <span ng-show="(item.contrapedido==1)" class=" icon-Contrapedidos" style="font-size: 23px"></span>
                        <span ng-show="(item.tipo_envio_id==1 || item.tipo_envio_id==3)" style="font-size: 23px" class="icon-Aereo" style="font-size: 24px"></span>
                        <span ng-show="(item.tipo_envio_id==2 || item.tipo_envio_id==3)" style="font-size: 23px" class="icon-Barco" /></span>
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
                    <span class="icon-Agregar" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="editProv()" ng-show="prov.id">
                    <span class="icon-Actualizar" style="font-size: 23px"></span>
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
                    <?= HTML::image("images/btn_prevArrow.png","",array("ng-click"=>"prevLayer()","ng-show"=>"(index>0)")) ?>
                </div>

                <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
                <div class="loadArea" ng-class="{'loading':!todos.$resolved}" layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
                    <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; ">
                        P
                    </div>
                    <br> Selecciones un Proveedor
                </div>
            </div>
        </div>


        <!-- 10) ########################################## LAYER (1) RESUMEN DEL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer0" id="layer0">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex>
                <md-content class="cntLayerHolder" layout="row" flex ng-controller="resumenProv">
                    <div style="width:24px"></div>
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

                            <div class="textResm" style="width:calc(30% - 40px); height:39px; float:left;">
                                {{prov.siglas}}
                            </div>
                            <span ng-show="(prov.contrapedido==1)" class=" icon-contrapedidos" style="font-size: 23px"></span>

                        </div>
                        <div class="titulo_formulario" style="height:39px;" layout-align="start start">
                            <div>
                                Nombres Valcro
                            </div>
                        </div>
                        <div flex style="overflow-y:auto;">
                            <div class="itemName" ng-repeat="name in prov.nomValc">
                                {{name.name}}
                            </div>
                        </div>
                        <div class="titulo_formulario" style="height:39px;">
                            <div>
                                Tipo de envio
                            </div>
                        </div>
                        <div style="height:39px;">
                            <div flex>
                                <span ng-show="(prov.tipo_envio_id==1 || prov.tipo_envio_id==3)" style="font-size: 23px" class="icon-Aereo" style="font-size: 24px"></span>
                                <span ng-show="(prov.tipo_envio_id==2 || prov.tipo_envio_id==3)" style="font-size: 23px" class="icon-Barco" /></span>

                               <!-- <img ng-show="(prov.tipo_envio_id==1 || prov.tipo_envio_id==3)" src="images/aereo.png" />
                                <img ng-show="(prov.tipo_envio_id==2 || prov.tipo_envio_id==3)" src="images/maritimo.png" />-->
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
                                    <div style="width: 70%; float:left;">{{point.pivot.punto | number:2}} {{point.simbolo}}</div>
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
                                    <div style="width: 70%; float:left;">{{lim.limite | number:2}} {{lim.moneda.simbolo}}</div>
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
            </div>
        </md-sidenav>

        <!-- 15) ########################################## LAYER (2) FORMULARIO INFORMACION DEL PROVEEDOR ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">

            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <input type="hidden" md-autofocus>
                <!-- 17) ########################################## FORMULARIO "Datos Basicos del Proveedor" ########################################## -->
                <form name="projectForm" layout="row" ng-controller="DataProvController" global ng-class="{'focused':isShow}" ng-disabled="true" ng-click="isShow = true" click-out="isShow = false; projectForm.$setUntouched()">
                    <div active-left></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" layout="column" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit && prov.id)}">
                            <div>
                                Datos Proveedor
                            </div>
                        </div>
                        <div flex layout="column" ng-hide="$parent.expand && id!=$parent.expand" class="area-form">
                            <div class="row" layout="row">

                            <md-input-container class="md-block" flex="15">
                                <label>Tipo</label>
                                <md-autocomplete md-selected-item="ctrl.typeProv"
                                                 flex
                                                 info="seleccione un tipo de proveedor"
                                                 skip-tab
                                                 id="provType"
                                                 md-search-text="ctrl.searchText"
                                                 ng-disabled="$parent.enabled && prov.id"
                                                 md-items="item in types | customFind : ctrl.searchText : filTipo "
                                                 md-item-text="item.nombre"
                                                 md-no-asterisk
                                                 md-min-length="0">
                                    <input >
                                    <md-item-template>
                                        <span>{{item.nombre}}</span>
                                    </md-item-template>
                                </md-autocomplete>

                            </md-input-container>


                            <md-input-container class="md-block" flex>
                                <label>Razon Social</label>
                                <input skip-tab info="indique el nombre del proveedor" ng-disabled="$parent.enabled && prov.id" autocomplete="off" ng-blur="check('razon_social')" duplicate="list" field="razon_social" name="razon_social" maxlength="80" ng-minlength="3" required md-no-asterisk ng-model="dtaPrv.description">
                                <!--ng-disabled="($parent.enabled || (toCheck && projectForm.description.$valid))"-->
                                <!--INICIO DE DIRECTIVA PARA FUNCION DE SOLO CHEQUEO (SKIP RED TO RED)-->
                                <!--<div ng-messages="projectForm.description.$error" ng-hide>
                                    <div ng-message="required">Campo Obligatorio.</div>
                                    <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                                </div>-->
                            </md-input-container>

                            <md-input-container class="md-block" flex="10" ng-click="inputSta(true)">
                                <label>Siglas</label>
                                <input skip-tab info="minimo 3 letras maximo 4" alpha autocomplete="off" ng-blur="check('siglas')" duplicate="list" field="siglas" maxlength="6" ng-minlength="3" required name="siglas" ng-model="dtaPrv.siglas" ng-disabled="$parent.enabled && prov.id">

                            </md-input-container>

                            <md-input-container class="md-block" flex="15">
                                <label>Tipo de Envio</label>
                                <md-autocomplete md-selected-item="ctrl.typeSend"
                                                 flex
                                                 id="provTypesend"
                                                 info="seleccione un tipo de envio"
                                                 ng-disabled="$parent.enabled && prov.id"
                                                 skip-tab
                                                 md-search-text="ctrl.searchSend"
                                                 md-items="item in envios | customFind : ctrl.searchSend : filTipo "
                                                 md-item-text="item.nombre"
                                                 md-autoselect = "true"
                                                 md-no-asterisk
                                                 md-min-length="0">
                                    <input >
                                    <md-item-template>
                                        <span>{{item.nombre}}</span>
                                    </md-item-template>
                                </md-autocomplete>

                               <!-- <md-select skip-tab info="seleccione un tipo de envio" id="provTypesend" ng-model="dtaPrv.envio" md-no-ink>
                                    <md-option ng-repeat="envio in envios" value="{{envio.id}}">
                                        {{envio.nombre}}
                                    </md-option>
                                </md-select>-->

                            </md-input-container>

                            <md-input-container class="md-block" style="margin-top:4px !important">
                                <span class="icon-Contrapedidos iconInput" tab-index="-1" skip-tab info="el proveedor acepta contrapedidos?" ng-click="togglecheck($event)" ng-class="{'iconActive':dtaPrv.contraped,'iconInactive':!dtaPrv.contraped}" style="font-size:23px;margin-rigth:8px"></span>
                                <!--<div class="circle"></div>-->
                               <!-- <md-switch skip-tab info="puede hacer contrapedidos a este proveedor" class="md-primary" ng-model="dtaPrv.contraped" aria-label="Contrapedidos" name="provContraped" ng-disabled="$parent.enabled && prov.id">
                                    Contrapedidos?
                                </md-switch>-->
                            </md-input-container>



                        </div>
                        </div>
                    </div>

                </form>

                <!-- 18) ########################################## FORMULARIO "Nombres Valcro" ########################################## -->
                <form name="nomvalcroForm" layout="row" ng-controller="valcroNameController" global ng-class="{'focused':isShow,'preNew':!prov.id}"  ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)" >
                    <div active-left></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" layout="row" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Nombres Valcro
                            </div>

                        </div>
                        <div class="area-form" ng-hide="$parent.expand && id!=$parent.expand">
                        <div ng-show="isShow">
                            <div layout="row" id="valNameContainer">
                                <md-input-container flex id="valcroName">
                                    <label>Nombre...</label>
                                    <input skip-tab info="indique el o los nombre(s) o marca(s) con el que se conoce este proveedor en los departamentos" autocomplete="off" duplicate="allName" duplicateMsg="este nombre Vacro ya existe" field="nombre" ng-minlength="3" required name="name" id="name" ng-model="valName.name" ng-disabled="$parent.enabled">
                                </md-input-container>
                                <span class="icon-Lupa" style="width:24px;" ng-click="openCoinc()" ng-show="coinc.length>0" ng-bind="coinc.length"> </span>
                                <div class="iconValName">
                                    <span ng-repeat="dep in deps" ng-class="{'iconActive':(exist(dep.id,0)),'iconFav':(exist(dep.id,1))}" ng-click="setDepa(this)" ng-dblclick="setFav(this)" class="{{dep.icon}} iconInactive" style="font-size: 18px; margin-left: 8px; color:black"></span>
                                </div>
                            </div>
                            <!--<md-input-container class="md-block" style="float:left; width:1px" ng-click="inputSta(true)">

                            </md-input-container>--> <div skip-tab tabindex="-1" info="" style="float:left; width:8px; cursor:none; border:none"></div>
                            <div ng-repeat="name in valcroName | orderBy:order:true" chip class="itemName" ng-click="toEdit(this); $event.stopPropagation();" ng-class="{'gridSel':(name.id==valName.id)}" ng-mouseleave="over(false)" ng-mouseover="over(this)"><span ng-class="{'rm' : (name.id==valName.id) || (name.id==overId)}" style="font-size:11px; margin-right: 8px; color: #f1f1f1;" class="icon-Eliminar" ng-click="rmValName(this)"></span>{{name.name}} </div>
                        </div>
                    </div>
                    </div>
                </form>
                <!--<div class="space"> <img src="images/box_tansparent_16x16.png" width="16" height="16" /> </div>-->
                <!-- 19) ########################################## FORMULARIO "Direcciones del Proveedor" ########################################## -->
                <form name="direccionesForm" layout="row" ng-controller="provAddrsController" global ng-class="{'focused':isShow,'preNew':!prov.id, 'required':address.length==0}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex layout="column">

                        <div class="titulo_formulario" layout="row" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Direcciones
                            </div>
                            <!--<div style="width:24px">
                                <span class="icon-Agregar"></span>
                            </div>-->
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand" flex layout="column" class="area-form">
                        <div layout="row" class="row">
                            <md-input-container class="md-block" flex="20">
                                <label>Tipo de Direccion</label>
                                <md-select skip-tab id="dirType" info="es facturacion o Almacen?" ng-model="dir.tipo" md-no-ink ng-disabled="$parent.enabled">
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
                                <md-autocomplete md-selected-item="dir.pais"
                                                 flex
                                                 id="dirPais"
                                                 info="indica el pais de la direccion"
                                                 skip-tab
                                                 md-search-text="ctrl.searchCountry"
                                                 md-items="item in paises | filtCountry : ctrl.searchCountry"
                                                 md-item-text="item.short_name"
                                                 md-autoselect = "true"
                                                 md-no-asterisk
                                                 md-min-length="0">
                                    <input >
                                    <md-item-template>
                                        <span>{{item.short_name}}</span>
                                    </md-item-template>
                                </md-autocomplete>

                                <!--<md-select skip-tab id="dirPais" info="indica el pais de la direccion" ng-model="dir.pais" md-no-ink ng-disabled="$parent.enabled">
                                    <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                        {{pais.short_name}}
                                    </md-option>
                                </md-select>-->
                                <!--<div ng-messages="user.pais.$error">
                                    <div ng-message="required">Campo Obligatorio.</div>

                                </div>-->
                            </md-input-container>
                            <div style="width:100px; padding: 3px;" ng-show="dir.tipo==2 || dir.tipo==3">
                                <span style="float: left;height: 25px;margin-top: 3px;padding-right: 4px;background: #f1f1f1;padding-left: 4px;">puertos</span>
                                <div ng-click="openPorts()" ng-class="{'ng-disable':$parent.enabled}" class="vlc-buttom" style="float:left">
                                    {{dir.ports.length || 0}}
                                </div>
                            </div>

                            <md-input-container class="md-block" flex>
                                <label>Codigo Postal</label>
                                <input skip-tab id="disZipCode" type="number" ng-pattern="/^[\d\-\.]+$/" info="codigo postal (zip code)" autocomplete="off" md-no-asterisk ng-model="dir.zipCode" ng-disabled="$parent.enabled" />
                            </md-input-container>
                            <md-input-container class="md-block" flex="30">
                                <label>Telefono</label>
                                <input skip-tab id="dirPhone" phone info="telefono de oficina" autocomplete="off" ng-blur="checkCode()" name="dirprovTelf" required md-no-asterisk ng-model="dir.provTelf" ng-disabled="$parent.enabled" />
                            </md-input-container>

                        </div>

                        <md-input-container class="md-block">
                            <label>Direccion</label>
                            <input skip-tab info="indique la direccion de la mejor manera" autocomplete="off"  ng-disabled="$parent.enabled" maxlength="250" ng-minlength="5" required md-no-asterisk name="direccProv" ng-model="dir.direccProv">
                        </md-input-container>

                        <div layout="column" ng-show="(isShow && !isShowMore) && address.length>0" class="row showMore" ng-click="viewExtend(true)">
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                        </div>

                        <div layout="column" ng-show="isShowMore" flex>
                            <div layout="row" class="headGridHolder" class="row">
                                <div flex="10" class="headGrid"> Tipo</div>
                                <div flex="20" class="headGrid"> Pais</div>
                                <div flex class="headGrid"> Direccion</div>
                                <div flex="20" class="headGrid"> Telefono</div>
                            </div>
                            <md-content id="grid" flex>
                                <div flex ng-repeat="add in address" ng-click="toEdit(this)" class="row">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(add.id == dir.id)}">
                                        <div ng-show="(add.id==dir.id)" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmAddres(this)"></div>
                                        <div flex="10" class="cellGrid"> {{add.tipo.descripcion}}</div>
                                        <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{add.pais.short_name}}</div>
                                        <div flex class="cellGrid">{{add.direccion}}</div>
                                        <div flex="20" class="cellGrid">{{add.telefono}}</div>
                                    </div>
                                </div>
                            </md-content>
                            <div layout="column" class="row" ng-click="viewExtend(false)">
                                <div flex style="border: dashed 1px #f1f1f1; text-align: center"><span class="icon-Above"></span></div>
                            </div>
                        </div>
                    </div>
                     </div>
                </form>
                <!--div class="space"> <img src="images/box_tansparent_16x16.png" width="16" height="16" /> </div>-->
                <!-- 20) ########################################## FORMULARIO "Contactos del Proveedor" ########################################## -->
                <form name="provContactosForm" layout="row" ng-controller="contactProv" global ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" layout="row" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Contactos Proveedor
                            </div>
                            <!--<div style="width:24px">
                                <span class="icon-Agregar"></span>
                            </div>-->
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand" flex layout="column" class="area-form">
                        <div class="row" layout="row">

                            <md-input-container class="md-block" flex="30">
                                <label>Nombre y Apellido</label>
                                <input skip-tab info="Nombre del contacto" autocomplete="off" ng-disabled="$parent.enabled || cnt.isAgent==1" name="nombreCont" maxlength="55" ng-minlength="3" required md-no-asterisk ng-model="cnt.nombreCont" >
                            </md-input-container>
                            <div ng-click="book()" ng-class="{'ng-disable':$parent.enabled}" class="vlc-buttom"> A </div>

                            <md-input-container class="md-block" flex>
                                <label>Pais de Residencia</label>
                                <md-autocomplete md-selected-item="ctrl.pais"
                                                 flex
                                                 id="paisCont"
                                                 info="pais de residencia del contacto (no es el mismo de direcciones)"
                                                 skip-tab
                                                 md-search-text="ctrl.searchCountry"
                                                 md-items="item in paises | filtCountry : ctrl.searchCountry"
                                                 md-item-text="item.short_name"
                                                 md-autoselect = "true"
                                                 md-no-asterisk
                                                 ng-disabled="$parent.enabled || cnt.isAgent==1"
                                                 md-min-length="0">
                                    <input >
                                    <md-item-template>
                                        <span>{{item.short_name}}</span>
                                    </md-item-template>
                                </md-autocomplete>
                                <!--<md-select id="paisCont" skip-tab info="pais de residencia del contacto (no es el mismo de direcciones)" ng-model="cnt.pais" ng-disabled="$parent.enabled || cnt.isAgent==1" md-no-ink>
                                    <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                        {{pais.short_name}}
                                    </md-option>
                                </md-select>-->
                            </md-input-container>

                            <div layout="row" flex="30">
                                <md-input-container flex>
                                    <label>Idiomas</label>
                                    <md-select id="langCont" skip-tab info="marque cada idioma que hable este contacto"  ng-model="cnt.languaje" multiple="" ng-disabled=" $parent.enabled || cnt.isAgent==1" md-no-ink>
                                        <md-option ng-value="lang.id" ng-repeat="lang in languaje">{{lang.lang}}</md-option>

                                    </md-select>
                                </md-input-container>
                            </div>
                        </div>
                        <div class="row" layout="row">
                            <!--<div flex style="height: 100%; margin-top:6px" layout="row">
                                <div style="max-width: calc(100% - 200px); overflow-x: auto; height:24px; margin-top:5px; border-bottom:1px solid #ccc">
                                        <div ng-repeat="block in cnt.emailCont" style="overflow: hidden;height: 24px; width: 24px; background: #ccc; color:white; font-weight: bolder; float: left; margin-right: 8px;">
                                            {{block.valor}}
                                        </div>
                                </div>
                                <md-input-container class="md-block" flex>
                                    <label>Email</label>
                                    <input skip-tab info="detalles de las responsabilidades" autocomplete="off" name="cntcRespon" maxlength="100" ng-minlength="3" ng-disabled=" $parent.enabled ">
                                </md-input-container>

                            </div>-->
                            <md-chips skip-tab flex ng-required="true"  info="email de contacto ej. fulano@valcro.co" name="emailCont" autocomplete="off" ng-disabled="$parent.enabled " id="emailCont" ng-model="cnt.emailCont"  class="md-block"  md-require-match="false" md-separator-keys="[13,32]" placeholder="Email" md-on-add="addContEmail(this)" md-transform-chip="transformChipEmail($chip)" md-on-remove="rmContEmail(this,$chip)">
                                <md-chip-template ng-dblclick="editChip($chip,$event)">
                                    <span>
                                      <strong>{{$chip.valor}}</strong>
                                    </span>
                                </md-chip-template>
                            </md-chips>

                            <md-chips skip-tab flex ng-required="true" info="telefono de contacto (en formato internacional)"  name="contTelf" autocomplete="off" ng-disabled="$parent.enabled " id="contTelf" ng-model="cnt.contTelf"  class="md-block"  md-require-match="false" md-transform-chip="transformChipTlf($chip)"  md-separator-keys="[13,32]">
                                <input phone placeholder="Telefonos Contacto">
                                <md-chip-template ng-dblclick="editChip($chip,$event)">
                                    <span>
                                      <strong>{{$chip.valor}}</strong>
                                    </span>
                                </md-chip-template>
                            </md-chips>

                        </div>

                        <div class="row" layout="row">
                            <md-input-container class="md-block" flex>
                                <label>Responsabilidades</label>
                                <input skip-tab info="detalles de las responsabilidades" autocomplete="off" name="cntcRespon" maxlength="100" ng-minlength="3" ng-model="cnt.responsability" ng-disabled=" $parent.enabled ">
                            </md-input-container>

                            <div layout="column" style="width:{{(cargos.length*40)}}px;">
                                <!--<div style="text-transform: uppercase !important;font-weight: 500 !important; height: 19px">CARGOS</div>-->
                                <vlc-group skip-tab>

                                     <span info="{{cargo.cargo}}" class="iconInput iconCircle" icon-group style="margin-left: 8px;border: 1px solid #ccc;border-radius: 25px;height: 25px;width: 25px;line-height: 25px;text-align: center; display: block; float: left;" ng-click="($parent.enabled) || setCargo(cargo,$event)" ng-class="{'iconActive':cnt.cargo.includes(cargo.id)}" ng-repeat="cargo in cargos">{{cargo.cargo.substring(0,1)}}

                                     </span>
                                </vlc-group>
                                <!--<md-input-container flex>
                                    <label>cargos</label>
                                    <md-select info="el cargo que desempeña el contacto en el proveedor"  ng-model="cnt.cargo" multiple="" ng-disabled="(cnt.id===false) || $parent.enabled || cnt.isAgent==1" md-no-ink>
                                        <md-option ng-value="cargo.id" ng-repeat="cargo in cargos">{{cargo.cargo}}</md-option>
                                    </md-select>
                                </md-input-container>-->
                            </div>
                        </div>

                        <div class="row" layout="row">
                            <md-input-container class="md-block" flex>
                                <label>Direccion de Oficina</label>
                                <input skip-tab info="direccion oficina (no es la misma de direcciones del proveedor)" autocomplete="off" name="cntcDirOfc" maxlength="200" ng-model="cnt.dirOff" ng-minlength="3" ng-disabled=" $parent.enabled">
                            </md-input-container>
                        </div>
                        <div layout="row">
                            <md-input-container class="md-block" flex>
                                <label>Notas</label>
                                <textarea style="max-height: 80px;" skip-tab info="alguna informaciona adicional para el contacto" autocomplete="off" name="cntNotes" ng-model="cnt.notes" ng-minlength="3" ng-disabled=" $parent.enabled "></textarea>
                            </md-input-container>
                        </div>
                        <div layout="column" ng-show="(isShow && !isShowMore) && contacts.length>0" class="row showMore" ng-click="viewExtend(true)">
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder">
                                <div flex="20" class="headGrid row"> Nombre</div>
                                <div flex class="headGrid row"> Email</div>
                                <div flex="10" class="headGrid row"> Telefono</div>
                                <div flex="20" class="headGrid row"> Pais</div>
                            </div>
                            <md-content id="grid" flex>
                                <div flex ng-repeat="cont in contacts" ng-click="toEdit(this)" class="row">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(cont.id == cnt.id)}">
                                        <div ng-show="(cont.id==cnt.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmContact(this)"></div>
                                        <div flex="20" class="cellGrid"> {{cont.nombre}}</div>
                                        <div flex class="cellGrid"> {{cont.email}}</div>
                                        <div flex="10" class="cellGrid">{{cont.telefono}}</div>
                                        <div flex="20" class="cellGrid">{{cont.pais.short_name}}</div>
                                    </div>
                                </div>
                            </md-content>
                            <div layout="column" class="row" ng-click="viewExtend(false)">
                                <div flex style="border: dashed 1px #f1f1f1; text-align: center"><span class="icon-Above"></span></div>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
                <!--<div class="space"> <img src="images/box_tansparent_16x16.png" width="16" height="16" /> </div>-->

            </md-content>

            <div style="width: 16px;" ng-mouseover="showNext(true,'layer2')">

            </div>

        </md-sidenav>
        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="nomValLyr" id="nomValLyr">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="nomValAssign">
                <input type="hidden" md-autofocus>
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
        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="contactBook" id="contactBook">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="addressBook">
                <input type="hidden" md-autofocus>
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
        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="portsLyr" id="portsLyr">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="portsControllers">
                <input type="hidden" md-autofocus>
                <div layout="column" flex style="overflow-x: hidden;">
                    <div class="titulo_formulario" layout="column" layout-align="start start">
                        <div ng-click="closeNomValLyr()">
                            Puertos
                        </div>
                    </div>
                    <div layout="column">
                        <div>
                            <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                                <div>
                                    Puertos Disponibles
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <md-input-container class="md-block" flex>
                                    <label>Pais</label>
                                    <md-select info="" ng-model="country.default" md-no-ink ng-disabled="$parent.enabled">
                                        <md-option ng-repeat="pais in paises" value="{{pais.id}}">
                                            {{pais.short_name}}
                                        </md-option>
                                    </md-select>
                                    <!--<div ng-messages="user.pais.$error">
                                        <div ng-message="required">Campo Obligatorio.</div>

                                    </div>-->
                                </md-input-container>
                            </div>
                            <md-content flex style="max-height: 200px;">
                                <div ng-repeat="port in ports | customFind : country.default : searchPort" style="border-bottom: 1px solid #f1f1f1; height: 32px;" ng-dblclick="assign(port)">
                                    <div layout="column" >
                                        <div layout="row" flex="grow">
                                            <div flex>
                                                {{port.Main_port_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </md-content>
                        </div>
                        <div>
                            <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                                <div>
                                    Puertos Asignados
                                </div>
                            </div>

                            <md-content flex style="max-height: 200px;">
                                <div  ng-repeat="port in ports | customFind : asignPorts.ports : searchAssig" ng-dblclick="remove(port)" style="border-bottom: 1px solid #f1f1f1; height: 32px;">
                                    <div layout="column" >
                                        <div layout="row" flex="grow">
                                            <div flex>
                                                {{port.Main_port_name}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </md-content>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER (3) INFORMACION FINANCIERA ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer2" id="layer2">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <input type="hidden" md-autofocus>
                <!-- ########################################## FORMULARIO INFO BANCARIA ########################################## -->
                <form ng-controller="bankInfoController" global layout="row" name="bankInfoForm" ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex  layout="column">
                        <div class="titulo_formulario" class="row" layout="row" layout-align="start start" ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Informacion Bancaria
                            </div>
                            <div style="width:24px" ng-show="bankInfoController.$touched">
                                <span class="icon-Agregar"></span>
                            </div>
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand" flex layout="column" class="area-form">
                        <div  class="row" layout="row">
                            <md-input-container class="md-block" flex>
                                <label>Nombre del Banco</label>
                                <input skip-tab name="bankName" autocomplete="off" ng-model="bnk.bankName" required/>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>Pais</label>
                                <md-select skip-tab id="bankPais" required ng-disabled="$parent.enabled" ng-model="bnk.pais" name="state" ng-disabled="$parent.enabled" ng-change="setState(this)" md-no-ink>
                                    <md-option ng-repeat="country in countries" value="{{country.id}}">
                                        {{country.short_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>{{(states.length==0)?'sin estados para mostrar':'Estado'}}</label>
                                <md-select skip-tab id="bankState" required ng-disabled="$parent.enabled || states.length==0" ng-model="bnk.est" name="state" ng-disabled="$parent.enabled || (bnk.pais==false)" md-no-ink>
                                    <md-option ng-repeat="state in states" value="{{state.id}}">
                                        {{state.local_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>{{(states.length==0)?'sin ciudades para mostrar':'Ciudades'}}</label>
                                <md-select skip-tab id="bankCity" ng-disabled="$parent.enabled || cities.length==0" ng-model="bnk.ciudad" name="state" ng-disabled="$parent.enabled || (bnk.est==false)" required md-no-ink>
                                    <md-option ng-repeat="city in cities" value="{{city.id}}">
                                        {{city.local_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>



                           <!-- <md-autocomplete md-match-case-insensitive="true" md-delay="500" md-selected-item="bnk.ciudad" md-search-text="ctrl.searchText"  md-items="item in querySearch(ctrl.searchText)" md-item-text="item.local_name" md-min-length="0" placeholder="ciudad del banco">
                                <md-item-template>
                                    <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.local_name}}</span>
                                </md-item-template>
                                <md-not-found>
                                    No existe la ciudad indicada
                                    <a ng-click="ctrl.newState(ctrl.searchText)">Create a new one!</a>
                                </md-not-found>
                            </md-autocomplete>-->
                        </div>

                        <md-input-container class="md-block row">
                            <label>Direccion del banco</label>
                            <input skip-tab name="bankAddr" autocomplete="off" ng-model="bnk.bankAddr" required/>

                        </md-input-container>

                        <div layout="row" class="row">
                            <md-input-container class="md-block row" flex>
                                <label>Beneficiario</label>
                                <input skip-tab name="bankBenf" autocomplete="off" ng-model="bnk.bankBenef" required/>

                            </md-input-container>
                            <md-input-container class="md-block" flex="20">
                                <label>SWIF</label>
                                <input skip-tab name="bankSwif" number autocomplete="off" ng-disabled="$parent.enabled" ng-model="bnk.bankSwift" required/>

                            </md-input-container>
                            <md-input-container class="md-block" flex="20">
                                <label>IBAN</label>
                                <input skip-tab name="bankIban" number autocomplete="off" ng-disabled="$parent.enabled" ng-model="bnk.bankIban" required/>

                            </md-input-container>
                        </div>
                        <md-input-container class="md-block row">
                            <label>Direccion Beneficiario</label>
                            <input skip-tab name="bankBenfAddr" required autocomplete="off" ng-model="bnk.bankBenefAddr" required/>

                        </md-input-container>

                        <div layout="column" ng-show="(isShow && !isShowMore) && accounts.length>0" class="row" ng-click="viewExtend(true)">
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder" class="row">
                                <div flex="20" class="headGrid"> Banco</div>
                                <div flex class="headGrid"> Beneficiario</div>
                                <div flex="30" class="headGrid"> Cuenta</div>
                            </div>
                            <md-content id="grid">
                                <div  class="row" ng-repeat="account in accounts" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(account.id == bnk.id)}">
                                        <div ng-show="(account.id==bnk.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmBank(this)"></div>
                                        <div flex="20" class="cellGrid"> {{account.banco}}</div>
                                        <div flex class="cellGrid"> {{account.beneficiario}}</div>
                                        <div flex="30" class="cellGrid">{{account.cuenta}}</div>

                                    </div>
                                </div>

                            </md-content>
                            <div layout="column" class="row" ng-click="viewExtend(false)">
                                <div flex style="border: dashed 1px #f1f1f1; text-align: center"><span class="icon-Above"></span></div>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>

                <!-- ########################################## FORMULARIO MONEDAS ########################################## -->
                <form name="provMoneda" layout="row"  ng-controller="coinController"  ng-class="{'focused':isShow,'preNew':!prov.id}">
                    <div active-left></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" layout="row" layout-align="start start" class="row" ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Moneda
                            </div>
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand" flex layout="column" class="area-form">
                            <div layout="row" class="row">
                                <md-input-container class="md-block" flex="20">
                                    <label>{{(coins.length == filt.length)?'no quedan monedas':'Monedas'}}</label>
                                    <md-select id="selCoin" ng-model="cn.coin" name="state" ng-disabled="(coins.length == filt.length) || $parent.enabled" required md-no-ink>
                                        <md-option ng-repeat="coin in coins | filterSelect: filt" value="{{coin.id}}">
                                            {{coin.nombre}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <!--<div ng-repeat="name in valcroName | orderBy:order:true" chip class="itemName" ng-click="toEdit(this); $event.stopPropagation();" ng-class="{'gridSel':(name.id==valName.id)}" ng-mouseleave="over(false)" ng-mouseover="over(this)"><span ng-class="{'rm' : (name.id==valName.id) || (name.id==overId)}" style="font-size:11px; margin-right: 8px; color: #f1f1f1;" class="icon-Eliminar" ng-click="rmValName(this)"></span>{{name.name}} </div>-->
                                <div flex layout="column">
                                    <div flex>
                                        <div class="itemName" style="width:80px" ng-repeat="coinSel in coinAssign" ng-click="toEdit(this);" ng-class="{'gridSel':(coinSel.id==cn.id)}" layout="row"><span ng-class="{'rm' : (coinSel.id==cn.id)}" style="font-size:11px; margin-right: 8px; color: #f1f1f1;" class="icon-Eliminar" ng-click="rmCoin(this)"></span><div flex>{{coinSel.nombre}}</div> <div style="width:16px">{{coinSel.simbolo}}</div></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="provCred" layout="row" ng-controller="creditCtrl" global  ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div layout="column" flex>
                        <div class="titulo_formulario" layout="row" layout-align="start start"  class="row" ng-class="{'onlyread' : (!$parent.edit || coins.length<1)}">
                            <div>
                                Credito
                            </div>
                           <!-- <div style="width:24px">
                                <span class="icon-Agregar"></span>
                            </div>-->
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand" flex layout="column" class="area-form">
                        <div class="row" layout="row">
                            <md-input-container class="md-block" flex="30">
                                <label>Limite de Credito</label>
                                <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled || coins.length<1" ng-model="cred.amount" required>
                            </md-input-container>

                            <md-input-container class="md-block" flex="20">
                                <label>Moneda</label>
                                <md-select id="credCoin" skip-tab ng-model="cred.coin" name="state" ng-disabled="$parent.enabled || coins.length<1" ng-controller="provCoins" required md-no-ink>
                                    <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                        {{coin.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex>
                                <label>Linea</label>
                                <md-select id="credLine" skip-tab ng-disabled="$parent.enabled" ng-model="cred.line" name="state" ng-disabled="$parent.enabled" md-no-ink>
                                    <md-option ng-repeat="line in lines" value="{{line.id}}">
                                        {{line.linea}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div layout="column" ng-show="(isShow && !isShowMore) && limits.length>0" class="row" ng-click="viewExtend(true)">
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                        </div>

                        <div layout="column" ng-show="isShowMore" flex>

                            <div layout="row" class="headGridHolder">
                                <!--<div flex="20" class="headGrid"> Fecha</div>-->
                                <div flex="20" class="headGrid"> Limite</div>
                                <div flex="30" class="headGrid"> Moneda</div>
                                <div flex="30" class="headGrid"> Linea</div>
                                <div flex class="headGrid"></div>
                            </div>
                            <md-content id="grid">
                                <div flex ng-repeat="lim in limits" class="row" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(lim.id == cred.id)}">
                                        <div ng-show="(lim.id==cred.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmCredit(this)"></div>
                                        <div flex="20" class="cellGrid"> {{lim.limite}}</div>
                                        <div flex="30" class="cellGrid">{{lim.moneda.nombre}}</div>
                                        <div flex="30" class="cellGrid">{{lim.line.linea}}</div>
                                        <div flex class="cellGrid"></div>
                                    </div>
                                </div>

                            </md-content>
                            <div layout="column" class="row" ng-click="viewExtend(false)">
                                <div flex style="border: dashed 1px #f1f1f1; text-align: center"><span class="icon-Above"></span></div>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>

                <!-- ########################################## FORMULARIO CREDITOS ########################################## -->
                <form name="condHeadFrm" layout="row" ng-controller="condPayList" global  ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div layout="column" flex>
                        <div class="titulo_formulario" layout="row" layout-align="start start"  class="row" ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Condiciones de pago
                            </div>
                            <div style="width:24px">
                                <span class="icon-Agregar"></span>
                            </div>
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand" flex layout="column" class="area-form">
                            <div layout="row" class="row">
                                <md-input-container class="md-block" flex="60">
                                    <label>Titulo</label>
                                    <input autocomplete="off" duplicate="conditions" field="titulo" ng-disabled="$parent.enabled" ng-model="condHead.title" required>
                                </md-input-container>
                                <md-input-container class="md-block" flex>
                                    <label>Linea</label>
                                    <md-select id="conLine" skip-tab ng-model="condHead.line" ng-disabled="$parent.enabled" md-no-ink>
                                        <md-option ng-repeat="line in lines" value="{{line.id}}">
                                            {{line.linea}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <div style="width:24px;">
                                    <?= HTML::image("images/menu.png","",array("ng-click"=>"openFormCond()","ng-show"=>"(condHead.id)")) ?>
                                </div>
                            </div>
                            <div layout="column" ng-show="(isShow && !isShowMore) && conditions.length>0" class="row" ng-click="viewExtend(true)">
                                <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                            </div>

                            <div layout="column" ng-show="isShowMore" flex>

                                <div layout="row" class="headGridHolder row">
                                    <!--<div flex="20" class="headGrid"> Fecha</div>-->
                                    <div flex="20" class="headGrid"> Titulo</div>
                                    <div flex="30" class="headGrid"> Linea</div>
                                    <div flex class="headGrid"></div>
                                </div>
                                <md-content id="grid" flex>
                                    <div  class="row" ng-repeat="condition in conditions" ng-click="toEdit(this)">
                                        <div layout="row" layout-wrap class="cellGridHolder" ng-class="{'rowSel':(condition.id == condHead.id)}">
                                            <div ng-show="(condition.id==condHead.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmCond(this)"></div>
                                            <div flex="30" class="cellGrid"> {{condition.titulo}}</div>
                                            <div flex="30" class="cellGrid">{{condition.line.linea}}</div>
                                            <div flex class="cellGrid"><span ng-repeat="item in condition.items">{{item.porcentaje}}% {{item.dias}} dias, {{item.descripcion}} | </span></div>
                                        </div>
                                    </div>

                                </md-content>
                                <div layout="column" class="row" ng-click="viewExtend(false)">
                                    <div flex style="border: dashed 1px #f1f1f1; text-align: center"><span class="icon-Above"></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'layer3')">

            </div>
        </md-sidenav>
        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="payCond" id="payCond">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="payCondItemController" style="margin-left:24px">
                <input type="hidden" md-autofocus>
                <div class="titulo_formulario" layout="column" layout-align="start start" ng-click="closeCondition()">
                    <div>
                        {{head.title}} <i>({{head.line}})</i>
                    </div>
                </div>

                <form name="itemCondForm" click-out="showInterGrid(false,$event)">

                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>%</label>
                            <input type="number" autocomplete="off" type="number" max="{{max}}"  ng-disabled="$parent.enabled || max<=0" ng-model="condItem.percent" required>
                        </md-input-container>
                        <md-input-container class="md-block" flex="20">
                            <label>Dias</label>
                            <input type="number" autocomplete="off" ng-disabled="$parent.enabled || max<=0" ng-model="condItem.days" required>
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
                <!-- ########################################## FORMULARIO FACTOR CONVERSION ########################################## -->
                <input type="hidden" md-autofocus>
                <form name="provConv" layout="row" ng-controller="convController" global  ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex>
                        <div class="titulo_formulario" ng-click="$parent.openPopUp('excepFactor')" layout="row" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit || coins.length < 1)}">
                            <div>
                                Factor de Conversión
                            </div>
                            <!--<div style="width:24px">
                                <span class="icon-Agregar"></span>
                            </div>-->
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand">
                            <div layout="row">
                                <md-input-container class="md-block" flex="10">
                                    <label>% Flete</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.freight">
                                </md-input-container>
                                <md-input-container class="md-block" flex="10">
                                    <label>% Gastos</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.expens">
                                </md-input-container>
                                <md-input-container class="md-block" flex="10">
                                    <label>% Ganancia</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.gain">
                                </md-input-container>
                                <md-input-container class="md-block" flex="10">
                                    <label>% Descuento</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.disc">
                                </md-input-container>
                                <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                                    <label>Moneda</label>
                                    <md-select id="convCoin" skip-tab ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.coin" name="state" required md-no-ink>
                                        <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                            {{coin.nombre}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <md-input-container class="md-block" flex>
                                    <label>Linea</label>
                                    <md-select id="convLine" skip-tab ng-model="conv.line" ng-disabled="$parent.enabled"ñ md-no-ink>
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
                                            <div flex="10" class="cellGrid"> {{factor.flete | number:2}}</div>
                                            <div flex="10" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{factor.gastos | number:2}}</div>
                                            <div flex="10" class="cellGrid">{{factor.ganancia | number:2}}</div>
                                            <div flex="10" class="cellGrid">{{factor.descuento | number:2}}</div>
                                            <div flex class="cellGrid">{{factor.moneda.nombre}}</div>
                                            <div flex="30" class="cellGrid">{{factor.linea.linea}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- ########################################## FORMULARIO PUNTOS ########################################## -->
                <form name="provPoint" layout="row" ng-controller="provPointController" global ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit || coins.length < 1)}">
                            <div>
                                Puntos
                            </div>
                            <!--<div style="width:24px">
                                <span class="icon-Agregar"></span>
                            </div>-->
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand">
                            <div layout="row">
                                <md-input-container class="md-block" flex="30">
                                    <label>Costo del punto</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled || coins.length < 1" ng-model="pnt.cost" required>
                                </md-input-container>
                                <md-input-container class="md-block" flex="20" ng-controller="provCoins">
                                    <label>Moneda</label>
                                    <md-select id="pointCoin" skip-tab ng-disabled="$parent.enabled || coins.length < 1" ng-model="pnt.coin" required md-no-ink>
                                        <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                            {{coin.nombre}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <md-input-container class="md-block" flex>
                                    <label>Linea</label>
                                    <md-select id="pointLine" skip-tab ng-model="pnt.line" ng-disabled="$parent.enabled" required md-no-ink>
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
                                            <div ng-show="(point.id==pnt.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmPoint(this)"></div>
                                            <div flex="30" class="cellGrid"> {{point.costo | number:2}}</div>
                                            <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{point.moneda.nombre}}</div>
                                            <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{point.linea.linea}}</div>
                                            <div flex class="cellGrid"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--<div class="space"> <img src="images/box_tansparent_16x16.png" width="16" height="16" /> </div>-->

                <!-- ########################################## FORMULARIO TIEMPO PRODUCCION ########################################## -->
                <form name="timeProd" layout="row" ng-click="showGrid(true,$event)" ng-controller="prodTimeController" global ng-class="{'focused':isShow,'preNew':!prov.id}" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Tiempo Aproximado de Producción
                            </div>
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container class="md-block" flex="20">
                                <label>De (Dias)</label>
                                <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled" ng-model="tp.from" required>
                            </md-input-container>
                            <md-input-container class="md-block" flex="20">
                                <label>A (Dias)</label>
                                <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled" ng-model="tp.to" required>
                            </md-input-container>

                            <md-input-container class="md-block" flex   >
                                <label>Linea</label>
                                <md-select id="timePLine" skip-tab ng-disabled="$parent.enabled" ng-model="tp.line" name="state" ng-disabled="$parent.enabled" md-no-ink>
                                    <md-option ng-repeat="line in lines" value="{{line.id}}">
                                        {{line.linea}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div layout="column" ng-show="isShow && !isShowMore" class="showMoreDiv" style="height: 40px" ng-click="viewExtend(true)" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{timesP.length}})</div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>
                            <div layout="row" class="headGridHolder">
                                <div flex="20" class="headGrid"> minimo dias</div>
                                <div flex="20" class="headGrid">Maximo Dias</div>
                                <div flex class="headGrid">Linea</div>
                            </div>
                            <div id="grid" style="overflow-y: auto; height: 120px">
                                <div flex ng-repeat="time in timesP" ng-click="toEdit(this)">
                                    <div layout="row" layout-wrap class="cellGridHolder">
                                        <div ng-show="(time.id==tp.id)" style="width: 32px" class="cellGrid"><span style="margin-left: 8px;" class="icon-Eliminar rm" ng-click="rmTimeProd(this)"></div>
                                        <div flex="20" class="cellGrid"> {{time.min_dias}}</div>
                                        <div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{time.max_dias}}</div>
                                        <div flex class="cellGrid">{{time.lines.linea}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   </div>
                </form>

                <!-- ########################################## FORMULARIO TIEMPO TRANSITO ########################################## -->
                <form name="timeTrans" layout="row" ng-controller="transTimeController" global ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Tiempo Aproximado de Transito
                            </div>
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand">
                            <div layout="row">
                                <md-input-container class="md-block" flex="20">
                                    <label>De (Dias)</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled" ng-model="ttr.from">
                                </md-input-container>
                                <md-input-container class="md-block" flex="20">
                                    <label>A (Dias)</label>
                                    <input skip-tab number autocomplete="off" ng-disabled="$parent.enabled" ng-model="ttr.to">
                                </md-input-container>

                                <md-input-container class="md-block" flex>
                                    <label>Pais</label>
                                    <md-select id="paistimeP" skip-tab ng-disabled="$parent.enabled" ng-model="ttr.country" name="state" ng-disabled="$parent.enabled" md-no-ink required>
                                        <md-option ng-repeat="country in provCountries" value="{{country.pais.id}}">
                                            {{country.pais.short_name}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                            </div>
                            <div layout="column" ng-show="isShow && !isShowMore" class="showMoreDiv" style="height: 40px" ng-click="viewExtend(true)" >
                                <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{timesP.length}})</div>
                            </div>
                            <div layout="column" ng-show="isShowMore" flex>
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
                        </div>
                    </div>
                </form>
                <form name="provPrecList" layout="row" ng-controller="priceListController" global ng-class="{'focused':isShow,'preNew':!prov.id}" ng-click="showGrid(true,$event)" click-out="showGrid(false,$event)">
                    <div active-left></div>
                    <div flex>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex ng-class="{'onlyread' : (!$parent.edit)}">
                            <div>
                                Listas de Precios
                            </div>
                        </div>
                        <div ng-hide="$parent.expand && id!=$parent.expand">
                        <div layout="row">
                            <md-input-container skip-tab class="md-block" flex="40">
                                <label>Referencia</label>
                                <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="lp.ref">
                            </md-input-container>
                            <div style="width:100px; padding: 3px;">
                                <span style="float: left;height: 25px;margin-top: 3px;padding-right: 4px;background: #f1f1f1;padding-left: 4px;">listas</span>
                                <div ng-click="openAdj()" ng-class="{'ng-disable':$parent.enabled}" class="vlc-buttom" style="float:left">
                                    {{lp.adjs.length || 0}}
                                </div>
                            </div>
                            <!--<md-input-container class="md-block" flex="20" ng-click="openAdj()">
                                <label>Archivo</label>

                                <input autocomplete="off" ng-disabled="$parent.enabled" ng-model="lp.file">
                            </md-input-container>-->
                        </div>
                        <div layout="column" ng-show="(isShow && !isShowMore) && lists.length>0" class="row" ng-click="viewExtend(true)">
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                        </div>
                        <div layout="column" ng-show="isShowMore" flex>
                        <div layout="row" class="headGridHolder">
                            <div flex="70" class="headGrid"> Referencias</div>
                            <div flex="30" class="headGrid"> Archivo</div>
                        </div>
                        <div id="grid" style="overflow-y: auto; height: 120px">
                            <div flex ng-repeat="add in lists" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="70" class="cellGrid"> {{add.referencia}}</div>
                                    <div flex="30" class="headGrid"> {{add.files.length}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </form>
            </md-content>
            <div style="width: 16px;" ng-mouseover="showNext(true,'END')">

            </div>
        </md-sidenav>
        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="excepFactor" id="excepFactor" click-out="closePopUp('excepFactor',$event)">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex >
                <input type="hidden" md-autofocus>
                <md-tabs md-dynamic-height="" md-border-bottom="">
                    <md-tab label="productos">
                        <h1 class="md-display-2">por linea</h1>
                        <h2>sub Linea</h2>
                        <h3>productos</h3>
                    </md-tab>
                    <md-tab label="temporada">
                        <md-content class="md-padding">
                            <h1 class="md-display-2">por temporada </h1>
                            <h2>puertos</h2>

                        </md-content>
                    </md-tab>
                    <md-tab label="otros">
                        <md-content class="md-padding">
                            <h3 class="md-display-2">otros con comentario y adjuntos</h3>

                        </md-content>
                    </md-tab>
                </md-tabs>
            </md-content>
        </md-sidenav>
        <!-- ########################################## LAYER (5) RESUMEN FINAL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="row" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer5" id="layer5">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="row" flex="grow" ng-controller="resumenProvFinal">
                <input type="hidden" md-autofocus>
                <div active-left></div>
                <div flex layout="column">
                    <div>
                        <div class="titulo_formulario" layout="column" layout-align="start start" flex ng-click="has()">
                            <div>
                                Datos Proveedor
                            </div>
                        </div>
                        <div>
                            <span ng-show="!has(prov.dataProv)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <div ng-repeat="(k,finalProv) in prov.dataProv" >
                            <div layout="column">
                                {{finalProv.datos.description}}
                            </div>
                            <div layout="row">
                                <div style="width: 32px">
                                    <span ng-show="(finalProv.datos.contraped)" style="font-size: 23px" class="icon-contrapedidos" style="font-size: 24px"></span>
                                </div>
                                <div flex>
                                    {{finalProv.datos.siglas}}
                                </div>

                            </div>
                            <div layout="row">
                                <div>
                                    <span ng-show="(finalProv.datos.envio==1 || finalProv.datos.envio==3)" style="font-size: 23px" class="icon-Aereo" style="font-size: 24px"></span>
                                    <span ng-show="(finalProv.datos.envio==2 || finalProv.datos.envio==3)" style="font-size: 23px" class="icon-Barco" /></span>

                                </div>
                                <div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Nombres Valcro
                            </div>
                            <md-switch ng-hide="!has(prov.valName)" md-no-ink ng-model="isEdit.nomvalcroForm" ng-change="toForm('nomvalcroForm')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.valName)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <!--<div layout="row" >
                            <div flex></div><div ng-click="toForm('nomvalcroForm')">edit</div>
                        </div>-->
                        <md-content flex style="max-height: 200px;">
                            <div ng-repeat="(k,name) in prov.valName" style="border-bottom: 1px solid #f1f1f1; height: 32px;">

                                <div layout="column" ng-click="checkSimil(name,'name')" ><!--ng-class="{'title_del' :name.action =='del','title_upd' :name.action =='upd','title_new' :name.action =='new'}"-->
                                    <div layout="row" flex="grow">
                                        <div ng-show="name.action =='new'" style="margin-right: 8px; font-size: 18px;"><span class="icon-Agregar"></span></div>
                                        <div ng-show="name.action =='upd'" style="margin-right: 8px; font-size: 18px;"><span class="icon-Actualizar"></span></div>
                                        <div ng-show="name.action =='del'" style="margin-right: 8px; font-size: 18px;"><span class="icon-Eliminar"></span></div>
                                        <div flex>
                                            {{name.datos.name}}
                                        </div>
                                        <div style="width:128px">
                                            <span ng-repeat="(id,dep) in name.datos.departments" style="font-size:23px; margin-right: 8px;" class="{{getDato(id,'depsValcroName','icon')}}" ng-class="{'iconFav' : (dep.fav == 1)}"></span>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </md-content>
                    </div>

                    <div layout="column">
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Direcciones
                            </div>
                            <md-switch md-no-ink ng-model="isEdit.direccionesForm" ng-change="toForm('direccionesForm')" aria-label="No Ink Effects">
                               <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.dirProv)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <!--<div layout="row" ng-hide="!has(prov.dirProv)">
                            <div flex></div>
                        </div>-->
                        <md-content flex>
                            <div ng-repeat="(k,dir) in prov.dirProv" style="border-bottom: 1px solid #f1f1f1; height: 128px; margin-right: 8px;">

                                <div layout="column" >
                                    <div ng-show="name.action =='new'" style="margin-right: 8px; font-size: 18px;"><span class="icon-Agregar"></span></div>
                                    <div ng-show="name.action =='upd'" style="margin-right: 8px; font-size: 18px;"><span class="icon-Actualizar"></span></div>
                                    <div ng-show="name.action =='del'" style="margin-right: 8px; font-size: 18px;"><span class="icon-Eliminar"></span></div>
                                    <div layout="row">
                                        <div flex="30">
                                            {{getDato(dir.datos.tipo,'typeDir','descripcion')}}
                                        </div>
                                        <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                            {{getDato(dir.datos.pais,'countries','short_name')}}
                                            <md-tooltip style="overflow:visible; float:left; width:200px">
                                                {{getDato(dir.datos.pais,'countries','short_name')}}
                                            </md-tooltip>
                                        </div>
                                    </div>
                                    <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                        <span style="font-weight: bolder">Direccion :</span>{{dir.datos.direccProv}}
                                        <md-tooltip >
                                            {{dir.datos.direccProv}}
                                        </md-tooltip>
                                    </div>
                                    <div layout="row">
                                        <span style="font-weight: bolder">postal :</span>
                                        <div flex="30">
                                             {{dir.datos.zipCode}}
                                        </div>
                                        <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                            {{dir.datos.provTelf}}
                                        </div>
                                    </div>
                                    <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                        <p style="float: left" ng-repeat="port in dir.datos.ports">{{getDato(port,'ports','Main_port_name')}}; </p>
                                       <!-- <md-tooltip ng-bind="myText">

                                        </md-tooltip>-->
                                    </div>
                                </div>

                            </div>
                        </md-content>
                    </div>

                    <div layout="column">
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex="5" >
                            <div>
                                Contactos
                            </div>
                            <md-switch ng-hide="!has(prov.contProv)" md-no-ink ng-model="isEdit.provContactosForm" ng-change="toForm('provContactosForm')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.contProv)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <!--<div layout="row" ng-hide="!has(prov.contProv)">
                            <div flex></div><div ng-click="toForm('provContactosForm')">edit</div>
                        </div>-->
                        <md-content flex>
                            <div ng-repeat="(k,cont) in prov.contProv" layout="column" style="border-bottom: 1px solid #f1f1f1; height: 128px; margin-right: 8px;">
                                <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                    <span style="font-weight: bolder">Nombre :</span>{{cont.datos.nombreCont}}
                                    <md-tooltip >
                                        {{cont.datos.nombreCont}}
                                    </md-tooltip>
                                </div>
                                <div flex class="collapseResum">
                                    <span style="font-weight: bolder">Email :</span>{{cont.datos.emailCont.valor}}
                                    <md-tooltip >
                                        {{cont.datos.emailCont.valor}}
                                    </md-tooltip>
                                </div>
                              <!--  <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                    {{cont.datos.emailCont}}
                                    <md-tooltip >
                                        {{cont.datos.emailCont}}
                                    </md-tooltip>
                                </div>-->
                                <div flex style="overflow: hidden; text-overflow: ellipsis; height: 32px; white-space:nowrap;">
                                    <span style="font-weight: bolder">Telf :</span>{{cont.datos.contTelf}}
                                </div>

                            </div>
                        </md-content>

                    </div>

                </div>
                <div  flex="33" layout="column">
                    <div>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Info Bancaria
                            </div>
                            <md-switch ng-hide="!has(prov.infoBank)" md-no-ink ng-model="isEdit.bankInfoForm" ng-change="toForm('bankInfoForm')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.infoBank)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <div ng-repeat="(k,bnk) in prov.infoBank" layout="column">
                            <div layout="column" class="collapseResum">
                                {{bnk.datos.bankBenef}}
                                <md-tooltip >
                                    {{bnk.datos.bankBenef}}
                                </md-tooltip>
                            </div>
                            <div layout="column" class="collapseResum">
                                {{bnk.datos.bankIban}}
                                <md-tooltip >
                                    {{bnk.datos.bankIban}}
                                </md-tooltip>
                            </div>
                            <div layout="column" class="collapseResum">
                                {{bnk.datos.bankBenefAddr}}
                                <md-tooltip >
                                    {{bnk.datos.bankBenefAddr}}
                                </md-tooltip>
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Limite de Credito
                            </div>
                            <md-switch ng-hide="!has(prov.limCred)" md-no-ink ng-model="isEdit.provCred" ng-change="toForm('provCred')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.limCred)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <div ng-repeat="(k,lim) in prov.limCred">

                            <div layout="column" ng-class="{'title_del' :lim.action =='del','title_upd' :lim.action =='upd','title_new' :lim.action =='new'}">
                                {{lim.datos.nombreCont}}
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Factor de conversion
                            </div>
                            <md-switch ng-hide="!has(prov.factConv)" md-no-ink ng-model="isEdit.provConv" ng-change="toForm('provConv')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.factConv)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <div ng-repeat="(k,conv) in prov.factConv">

                            <div layout="column" ng-class="{'title_del' :conv.action =='del','title_upd' :conv.action =='upd','title_new' :conv.action =='new'}">
                                {{conv.datos.nombreCont}}
                            </div>

                        </div>
                    </div>
                    <div>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Puntos
                            </div>
                            <md-switch ng-hide="!has(prov.point)" md-no-ink ng-model="isEdit.provPoint" ng-change="toForm('provPoint')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.point)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <div ng-repeat="(k,point) in prov.point">

                            <div layout="column" ng-class="{'title_del' :point.action =='del','title_upd' :point.action =='upd','title_new' :point.action =='new'}">
                                {{point.datos.nombreCont}}
                            </div>

                        </div>
                    </div>


                </div>
                <div   flex="33" layout="column">
                    <div>
                        <div class="titulo_formulario" layout="row" layout-align="start start" flex >
                            <div>
                                Puntos
                            </div>
                            <md-switch ng-hide="!has(prov.point)" md-no-ink ng-model="isEdit.provPoint" ng-change="toForm('provPoint')" aria-label="No Ink Effects">
                                <!-- editar-->
                            </md-switch>
                        </div>
                        <div>
                            <span ng-show="!has(prov.point)" style="margin:8px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                        </div>
                        <div ng-repeat="(k,point) in prov.point">

                            <div layout="column" ng-class="{'title_del' :point.action =='del','title_upd' :point.action =='upd','title_new' :point.action =='new'}">
                                {{point.datos.nombreCont}}
                            </div>

                        </div>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <md-sidenav style="z-index:100; margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');" layout="column" layout-align="center center" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="NEXT" ng-mouseleave="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png","",array('ng-click'=>"nextLayer(nextLyr)")) ?>
        </md-sidenav>


        <!-- 8) ########################################## BOTON Next ########################################## -->
        <div ng-controller="notificaciones" ng-include="template"></div>
        <div ng-controller="FilesController" ng-include="template"></div>
</div>


