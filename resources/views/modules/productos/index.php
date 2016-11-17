<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="prodMainController">



    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex >

        <div class="barraLateral" layout="column" ng-controller="listController">
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
                <div class="boxList"  layout="column" list-box flex ng-repeat="line in listLines | customFind : true : filtAvaiable" id="lineId{{line.id}}" ng-click="clicked(line)" ng-class="{'listSel' : (line.id == curLine.id)}">
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ line.linea }}</div>

                </div>
            </div>
            <!--</md-content>-->
        </div>

        <div layout="column" flex class="md-whiteframe-1dp">
            <!-- 4) ########################################## BOTONERA ########################################## -->
            <div class="botonera" layout layout-align="start center">
                <div layout="column" layout-align="center center">

                </div>
                <div layout="column" layout-align="center center">
                    <!--<i class="fa fa-plus"></i>-->
                    <span class="icon-Agregar" ng-click="newCrit()" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center">
                    <span class="icon-Actualizar" style="font-size: 23px"></span>
                    <!-- --><?/*= HTML::image("images/actualizar.png") */?>
                </div>
                <div layout="column" layout-align="center center" >
                    <span class="icon-Filtro" style="font-size: 24px"></span>

                </div>
            </div>

            <div flex layout="row">
                <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
                    <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
                    <?= HTML::image("images/btn_prevArrow.png","",array("ng-click"=>"prevLayer()","ng-show"=>"(index>0)")) ?>
                </div>

                <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
                <div class="loadArea" ng-class="{'loading':list2()==0}" layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
                    <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; " >
                        C
                    </div>
                    <br> Selecciones una Linea
                </div>
            </div>
        </div>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer0" id="layer0">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex>
                <md-content class="cntLayerHolder" layout="column" flex style="padding-left: 8px">
                    <div style="height: 48px;">
                        <form name="LineProd" layout="row" class="focused" >
                            <div class="titulo_formulario" layout="row" layout-align="start start" flex>
                                <div>
                                    Linea
                                </div>
                                <div style="width: 24px; font-size:24px;" ng-click="newLine()">+</div>
                            </div>

                        </form>
                    </div>
                    <div class="barraLateral" layout="column" ng-controller="listController">
                        <!--<md-content flex class="barraLateral" ng-controller="ListProv">-->
                        <div id="launchList" style="width:0px;height: 0px;" tabindex="-1" list-box></div>
                        <div id="listado" flex  style="overflow-y:auto;" ng-click="showAlert(45)" >
                            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
                            <div class="boxList"  layout="column" list-box flex ng-repeat="line in listLines | customFind : false : filtAvaiable" id="lineId{{line.id}}" ng-click="clicked(line)" ng-class="{'listSel' : (line.id == curLine.id)}">
                                <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ line.linea }}</div>

                            </div>
                        </div>
                        <!--</md-content>-->
                    </div>
                </md-content>
            </div>
        </md-sidenav>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 332px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer2" id="layer2">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex>
                <md-content class="cntLayerHolder" layout="column" flex style="padding-left: 8px">
                    <!--creacion o edicion de la linea-->
                    <form name="LineProd" layout="row" class="focused" ng-controller="lineController">
                        <div active-left></div>
                        <div flex layout="column">
                            <div class="titulo_formulario" layout="column" layout-align="start start">
                                <div>
                                    Linea
                                </div>
                            </div>
                            <div flex layout="column" class="area-form">
                                <div class="row" layout="row">

                                    <md-input-container class="md-block" flex>
                                        <label>Nombre de Linea</label>
                                        <input skip-tab
                                               info="indique el nombre del proveedor"

                                               autocomplete="off"
                                               duplicate="listLines"
                                               duplicate-msg="esta linea ya existe"
                                               field="linea"
                                               name="razon_social"
                                               maxlength="80"
                                               ng-minlength="3"
                                               required
                                               md-no-asterisk
                                               ng-model="newLine.name"
                                        >

                                    </md-input-container>
                                    <md-input-container class="md-block" flex="10">
                                        <label>Siglas</label>
                                        <input skip-tab
                                               info="Siglas para esta linea"
                                               duplicate="listLines"
                                               duplicate-msg="estas siglas ya existen"
                                               field="siglas"
                                               autocomplete="off"
                                               name="linea"
                                               maxlength="4"
                                               ng-minlength="3"
                                               required
                                               md-no-asterisk
                                               ng-model="newLine.letter"
                                        >

                                    </md-input-container>
                                    </div>
                            </div>
                        </div>

                    </form>

                    <!--creacion y carga de sublineas-->

                    <div flex></div>
                </md-content>
            </div>
        </md-sidenav>


        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex>
                <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">
                    <div style="width:440px;padding:8px" layout="column" ng-controller="formPreview">
                        <form name="LineProd" layout="row" class="focused" >
                            <div active-left></div>
                            <div flex layout="column">
                                <div class="titulo_formulario" layout="row" layout-align="start start" flex>
                                    <div>
                                        Linea
                                    </div>
                                    <div style="width: 24px; font-size:24px;" ng-click="setEdit(true)">+</div>
                                </div>

                                <md-content layout="column" style="margin: 0px 4px 0px 4px">
                                    <div ng-repeat="field in criteria" class="row"
                                         ng-dblclick="setEdit(field)"
                                         form-preview="{{ field.type.directive }}">

                                    </div>
                                </md-content>
                            </div>
                        </form>
                    </div>
                    <div flex></div>
                    <!--<div flex="15" layout="column" class="md-whiteframe-2dp" >
                        <md-content style="margin: 0 8px 0 8px !important;">
                            <div ng-repeat="field in fields" class="row" ng-class="{'rowSel':field.id == critField.field}" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                <div ng-click="createField(field,'field')">{{field.descripcion}}</div>
                            </div>
                        </md-content>
                    </div>
                    <div flex="15" layout="column" class="md-whiteframe-2dp">
                        <md-content style="margin: 0 8px 0 8px !important;">
                            <div ng-repeat="type in tipos" ng-class="{'rowSel':type.id == critField.type}"  class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                <div ng-click="createField(type,'type')" >{{type.descripcion}}</div>
                            </div>
                        </md-content>
                    </div>
                    <div flex layout="column" class="md-whiteframe-2dp" style="padding:8px;">
                        <div flex>
                            <div class="titulo_formulario" layout="column" layout-align="start start">
                                <div ng-click="show()">
                                    Opciones
                                </div>
                            </div>
                            <div flex>
                                <form name="optionsForm" layout="column">
                                    <div ng-repeat="opcion in options" ng-init="inicialize(opcion)" style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                        <div layout="column" class="optHolder" ng-show="opcion.descripcion == 'Requerido'" flex tabindex="0" id="{{opcion.descripcion}}">
                                            <md-input-container class="md-block" flex>

                                                <md-switch ng-model="opcValue[opcion.descripcion].valor"
                                                           ng-blur="checkSave($event)"
                                                >
                                                    {{opcion.descripcion}}
                                                </md-switch>
                                            </md-input-container>
                                            <md-input-container class="md-block" flex ng-show="opcValue[opcion.descripcion].valor != ''">
                                                <label>{{opcion.descripcion}} mensaje</label>
                                                <input skip-tab
                                                       ng-model="opcValue[opcion.descripcion].msg"
                                                       ng-blur="checkSave($event)"
                                                      >
                                            </md-input-container>
                                        </div>

                                        <div layout="column" class="optHolder" ng-show="opcion.descripcion != 'Requerido'" tabindex="0" id="{{opcion.descripcion}}">
                                            <md-input-container class="md-block" flex>
                                                <label>{{opcion.descripcion}}</label>
                                                <input skip-tab
                                                       ng-model="opcValue[opcion.descripcion].valor"
                                                       ng-blur="checkSave($event)"
                                                       >
                                            </md-input-container>
                                            <md-input-container class="md-block" flex ng-show="opcValue[opcion.descripcion].valor != ''">
                                                <label>{{opcion.descripcion}} mensaje</label>
                                                <input skip-tab
                                                       ng-model="opcValue[opcion.descripcion].msg"
                                                       ng-blur="checkSave($event)"
                                                       >
                                            </md-input-container>
                                        </div>


                                    </div>
                                </form>

                            </div>

                        </div>

                    </div>-->
                </md-content>
            </div>
        </md-sidenav>

        <div>
            <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 736px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyrConst1" >
                <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

                <input type="hidden" md-autofocus>
                <div layout="row" flex>
                    <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">

                        <div style="width:192px;" layout="column" >
                            <md-content style="margin: 0 8px 0 8px !important;">
                                <div ng-repeat="field in fields" class="row" ng-class="{'rowSel':field.id == critField.field}" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                    <div ng-click="createField(field,'field')">{{field.descripcion}}</div>
                                </div>
                            </md-content>
                        </div>
                        <div flex ></div>
                    </md-content>
                </div>
            </md-sidenav>
            <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 928px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyrConst2" >
                <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

                <input type="hidden" md-autofocus>
                <div layout="row" flex>
                    <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">

                        <div style="width:192px;" layout="column" >
                            <md-content style="margin: 0 8px 0 8px !important;">
                                <div ng-repeat="type in tipos" ng-class="{'rowSel':type.id == critField.type}"  class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                    <div ng-click="createField(type,'type')" >{{type.descripcion}}</div>
                                </div>
                            </md-content>
                        </div>
                        <div flex ></div>
                    </md-content>
                </div>
            </md-sidenav>
            <md-sidenav  style="margin-top:96px; margin-bottom:48px; width:calc(100% - 1120px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyrConst3" >
                <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

                <input type="hidden" md-autofocus>
                <div layout="row" flex>
                    <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">
                        <div flex layout="column" style="padding:8px;">
                            <div flex>
                                <div class="titulo_formulario" layout="column" layout-align="start start">
                                    <div ng-click="show()">
                                        Opciones
                                    </div>
                                </div>
                                <div flex>
                                    <form name="optionsForm" layout="column">
                                        <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                            <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                <md-input-container class="md-block" flex >
                                                    <label>info</label>
                                                    <input skip-tab
                                                           ng-model="opcValue.info.valor"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>
                                        </div>

                                        <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                            <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                <md-input-container class="md-block" flex>

                                                    <md-switch ng-model="opcValue.req.valor"
                                                               ng-blur="checkSave($event)"
                                                    >
                                                        {{opcion.descripcion}}
                                                    </md-switch>
                                                </md-input-container>
                                            </div>
                                            <md-input-container class="md-block" flex ng-show="opcValue.req.valor != ''">
                                                <label>{{opcion.descripcion}} mensaje</label>
                                                <input skip-tab
                                                       ng-model="opcValue.req.msg"
                                                       ng-blur="checkSave($event)"
                                                >
                                            </md-input-container>
                                        </div>
                                        <div ng-show="critField.type == 2" >

                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                    <md-input-container class="md-block" flex >
                                                        <label>Minimo</label>
                                                        <input skip-tab
                                                               ng-model="opcValue.min.valor"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>
                                                </div>
                                                <md-input-container class="md-block" flex ng-show="opcValue.min.valor != ''">
                                                    <label>mensaje de Minimo</label>
                                                    <input skip-tab
                                                           ng-model="opcValue.min.msg"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>
                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                    <md-input-container class="md-block" flex >
                                                        <label>Maximo</label>
                                                        <input skip-tab
                                                               ng-model="opcValue.max.valor"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>
                                                </div>
                                                <md-input-container class="md-block" flex ng-show="opcValue.max.valor != ''">
                                                    <label>mensaje</label>
                                                    <input skip-tab
                                                           ng-model="opcValue.max.msg"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>
                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                    <md-input-container class="md-block" flex >
                                                        <label>Minimo Imposible</label>
                                                        <input skip-tab
                                                               ng-model="opcValue.minI.valor"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>
                                                </div>
                                                <md-input-container class="md-block" flex ng-show="opcValue.minI.valor != ''">
                                                    <label>mensaje</label>
                                                    <input skip-tab
                                                           ng-model="opcValue.minI.msg"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>
                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                    <md-input-container class="md-block" flex >
                                                        <label>Maximo  Imposible</label>
                                                        <input skip-tab
                                                               ng-model="opcValue.maxI.valor"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>
                                                </div>
                                                <md-input-container class="md-block" flex ng-show="opcValue.maxI.valor != ''">
                                                    <label>mensaje</label>
                                                    <input skip-tab
                                                           ng-model="opcValue.maxI.msg"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>

                                        </div>

                                        <div ng-show="critField.type == 1 || critField.type == 3">

                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                    <md-input-container flex>
                                                        <label>opciones</label>
                                                        <md-autocomplete md-selected-item="ctrl.selOption"
                                                                         flex
                                                                         skip-tab
                                                                         ng-required="(cnt.languaje.length==0)"
                                                                         md-selected-item-change="setOptSel(ctrl.selOption.id)"
                                                                         info="opcion a agregar"
                                                                         md-search-text="ctrl.searchOpctions"
                                                                         md-items="item in listOptions | stringKey : ctrl.searchOpctions: 'nombre' | filterSelect: opcValue.opts.valor"
                                                                         md-item-text="item.nombre"
                                                                         md-no-asterisk
                                                                         md-min-length="0"
                                                                         vl-no-clear
                                                        >
                                                            <input >
                                                            <md-item-template>
                                                                <span>{{item.nombre}}</span>
                                                            </md-item-template>
                                                            <md-not-found>
                                                                <a ng-click="createNewIten(ctrl.searchOpctions)">la opcion {{ctrl.searchOpctions}}, no existe
                                                                    crearla?</a>
                                                            </md-not-found>
                                                        </md-autocomplete>

                                                    </md-input-container>
                                                </div>
                                                <md-input-container class="md-block" flex ng-show="opcValue[opcion.descripcion].valor != ''">
                                                    <label>{{opcion.descripcion}} mensaje</label>
                                                    <input skip-tab
                                                           ng-model="opcValue[opcion.descripcion].msg"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>

                                            <md-content>
                                                <div ng-repeat="opt in opcValue.opts.valor" class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                                    {{getoptSet(opt).nombre}}
                                                </div>
                                            </md-content>
                                        </div>
                                        <!--<div ng-repeat="opcion in options" ng-init="inicialize(opcion)" style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                            <div layout="column" class="optHolder" flex tabindex="0" id="{{opcion.descripcion}}">
                                                <md-input-container class="md-block" flex ng-show="opcion.descripcion == 'Requerido'">

                                                    <md-switch ng-model="opcValue[opcion.descripcion].valor"
                                                               ng-blur="checkSave($event)"
                                                    >
                                                        {{opcion.descripcion}}
                                                    </md-switch>
                                                </md-input-container>

                                                <md-input-container class="md-block" flex ng-show="opcion.descripcion != 'Requerido'" >
                                                    <label>{{opcion.descripcion}}</label>
                                                    <input skip-tab
                                                           ng-model="opcValue[opcion.descripcion].valor"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>

                                                <md-input-container flex ng-show="opcion.descripcion == 'Requerido'" >
                                                    <label>opciones</label>
                                                    <md-autocomplete md-selected-item=""
                                                                     flex
                                                                     skip-tab
                                                                     ng-required="(cnt.languaje.length==0)"
                                                                     info="opcion a agregar"
                                                                     md-search-text="ctrl.searchOpctions"
                                                                     md-items="item in listOptions | stringKey : ctrl.searchOpctions: 'nombre'"
                                                                     md-item-text="item.nombre"
                                                                     md-no-asterisk
                                                                     md-min-length="0"
                                                                     vl-no-clear
                                                                    >
                                                        <input >
                                                        <md-item-template>
                                                            <span>{{item.nombre}}</span>
                                                        </md-item-template>
                                                        <md-not-found>
                                                            <a ng-click="createNewIten(ctrl.searchOpctions)">la opcion {{ctrl.searchOpctions}}, no existe
                                                            crearla?</a>
                                                        </md-not-found>
                                                    </md-autocomplete>

                                                </md-input-container>


                                                <md-input-container class="md-block" flex ng-show="opcValue[opcion.descripcion].valor != ''">
                                                    <label>{{opcion.descripcion}} mensaje</label>
                                                    <input skip-tab
                                                           ng-model="opcValue[opcion.descripcion].msg"
                                                           ng-blur="checkSave($event)"
                                                    >
                                                </md-input-container>
                                            </div>


                                        </div>-->
                                    </form>

                                </div>

                            </div>

                        </div>
                    </md-content>
                </div>
            </md-sidenav>

        </div>
    </div>
    <div ng-controller="notificaciones" ng-include="template"></div>
</div>