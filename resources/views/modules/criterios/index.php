<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="CritMainController" global>



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
            <div id="mainList" flex  style="overflow-y:auto;" ng-click="showAlert(45)" >
                <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
                <div class="boxList"  layout="column" list-box flex ng-repeat="line in listLines | customFind : true : filtAvaiable" id="lineId{{line.id}}" ng-click="openCrit(line)" ng-class="{'listSel' : (line.id == curLine.id)}">
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
                <div layout="column" layout-align="center center" ng-show="!line.id">
                    <!--<i class="fa fa-plus"></i>-->
                    <span class="icon-Agregar" ng-click="newCrit()" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-show="line.id">
                   <!-- <span class="" style="font-size: 23px" ng-click="openPopUp('treeLayer')">Tree</span>-->
                    <?= HTML::image("images/Mapa.png","",array("pop-up-open"=>"{'treeLayer':{before:null,after:null}}")) ?>
                </div>
                <!--<div layout="column" layout-align="center center" >
                    <span class="icon-Filtro" style="font-size: 24px"></span>

                </div>-->
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

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="critlayer0" id="critlayer0">
            <!-- 11) ########################################## LINEAS #SIN CRITERIO ########################################## -->

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
                            <div class="boxList"  layout="column" list-box flex ng-click="openCrit(line)" ng-repeat="line in listLines | customFind : false : filtAvaiable" id="lineId{{line.id}}" ng-class="{'listSel' : (line.id == curLine.id)}">
                                <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ line.linea }}</div>

                            </div>
                        </div>
                        <!--</md-content>-->
                    </div>
                </md-content>
            </div>
        </md-sidenav>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 332px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer2" id="layer2">
            <!-- 11) ########################################## NUEVA LINEA ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex  ng-controller="lineController">
                <md-content class="cntLayerHolder" layout="column" flex style="padding-left: 8px">
                    <!--creacion o edicion de la linea-->
                    <form name="LineProd" layout="row" class="focused">
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
                <div class="showNext" style="width: 16px;" ng-mouseover="(LineProd.$valid && !LineProd.$pristine)?$parent.showNext(true,saveNewLine):showMsg()" ng-mouseleave="over = false;">
                </div>
            </div>
        </md-sidenav>


        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="critLayer1" id="critLayer1">
            <!-- 11) ########################################## LAYER PREVIEW DEL FORMULARIO ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex>
                <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">


                        <div  style="width:440px;padding:8px" layout="column">
                                <form flex name="LineProd" layout="row" class="focused" ng-controller="formPreview">
                                    <div active-left></div>
                                    <div flex layout="column">
                                        <div class="titulo_formulario row" layout="row" layout-align="start start">
                                            <div>
                                                Linea
                                            </div>
                                            <div style="width: 24px; font-size:24px;" ng-click="setEdit(true)">+</div>
                                        </div>

                                        <md-content layout="column" flex style="margin: 0px 4px 0px 4px">
                                            <div ng-repeat="field in criteria" class="row"
                                                 ng-class="{'field-sel':field.id==formId.id}"
                                                 test="{{field.id}}"
                                                 form-preview="{{field.type.directive}}"
                                                 ng-dblclick="setEdit(field)"
                                                 ng-show="isShow[field.id]"
                                                 >

                                            </div>
                                        </md-content>
                                    </div>
                                </form>
                        </div>


                    <div flex></div>

                </md-content>
                <show-next on-next="endCriterio" ></show-next>
            </div>
        </md-sidenav>

        <div id="critConstruct">
            <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 736px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyrConst1" >
                <!-- 11) ########################################## MINI LAYER SELECTOR NOMBRE CAMPO ########################################## -->

                <input type="hidden" md-autofocus>
                <div layout="row" flex>
                    <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">

                        <div style="width:192px; padding: 0 8px 0 8px !important" layout="column" >
                            <div class="titulo_formulario row" layout="row" layout-align="start start" >
                                <div>
                                    Nombre del Campo
                                </div>
                                <div style="width: 24px; font-size:24px;" pop-up-open="{'newField':{before:null,after:null}}">+</div>
                            </div>

                            <md-content flex>
                                <div ng-repeat="field in fields" class="row" ng-class="{'assign':(used(field) && field.id != critField.field),'field-sel':field.id == critField.field}" layout="column" layout-align="center left" style="border-bottom: 1px solid #ccc; padding-left: 4px;">
                                    <div ng-click="(!used(field))?createField(field,'field'):isUsed()">{{field.descripcion}}</div>
                                </div>
                            </md-content>
                        </div>
                        <div flex ></div>
                    </md-content>
                </div>
            </md-sidenav>
            <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 928px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyrConst2" >
                <!-- 11) ########################################## MINI LAYER SELECTOR TIPO DE CAMPO ########################################## -->

                <input type="hidden" md-autofocus>
                <div layout="row" flex>
                    <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">

                        <div style="width:192px; padding: 0 8px 0 8px !important" layout="column" >
                            <div class="titulo_formulario row" layout="row" layout-align="start start" >
                                <div>
                                    Tipo de Campo
                                </div>
                              <!--  <div style="width: 24px; font-size:24px;" ng-click="setEdit(true)">+</div>-->
                            </div>
                            <lmb-collection
                                lmb-type="list"
                                lmb-model="critField.type"
                                lmb-itens="tipos"
                                lmb-icon="icon"
                                valid = "{f:checkType,c:callback}"
                                flex
                            >

                            </lmb-collection>
                            <!--<md-content flex>
                                <div ng-repeat="type in tipos" ng-class="{'field-sel':type.id == critField.type}"  class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                    <div ng-click="createField(type,'type')" >{{type.descripcion}}</div>
                                </div>
                            </md-content>-->
                        </div>
                        <div flex ></div>
                    </md-content>
                </div>
            </md-sidenav>
            <md-sidenav  style="margin-top:96px; margin-bottom:48px; width:calc(100% - 1120px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyrConst3" id="lyrConst3" >

                <input type="hidden" md-autofocus>
                <div layout="row" flex >
                    <md-content class="cntLayerHolder" layout="row" style="padding: 0 0 0 0 !important; width: 246px;">

                        <div flex layout="column" style="padding:8px;">
                            <form name="optionsForm" layout="column" flex="70">
                                <!--<div >-->
                                    <div class="titulo_formulario row" layout="column" layout-align="start start">
                                        <div ng-click="show()">
                                            Opciones
                                        </div>
                                    </div>

                                    <md-content flex layout="column">
                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px" class="row">
                                                    <div layout="column" class="optHolder" flex tabindex="0" id="prevInfo">
                                                        <md-input-container class="md-block" flex >
                                                            <label>info</label>
                                                            <input skip-tab
                                                                   class="Frm-value"
                                                                   ng-model="opcValue.info.valor"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                    </div>
                                            </div>
                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px" class="row">
                                                <div layout="column" class="optHolder" flex tabindex="0" id="prevInfo">
                                                    <md-input-container class="md-block" flex >
                                                        <label>placeholder</label>
                                                        <input skip-tab
                                                               class="Frm-value"
                                                               ng-model="opcValue.place.valor"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>
                                                </div>
                                            </div>

                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px" >
                                                <div layout="column" flex tabindex="0" id="prevReq" >
                                                    <md-input-container class="md-block" class="row">

                                                        <md-switch ng-model="opcValue.req.valor"
                                                                   ng-blur="checkSave($event)"
                                                                   ng-true-value="1"
                                                                   ng-false-value="0"
                                                                   class="Frm-value"
                                                        >
                                                            &nbsp;Requerido
                                                        </md-switch>
                                                    </md-input-container>
                                                    <md-input-container class="md-block" flex ng-show="opcValue.req.valor != ''" class="row">
                                                        <label>Requerido mensaje</label>
                                                        <input skip-tab
                                                               ng-model="opcValue.req.msg"

                                                               class="Frm-msg"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>
                                                </div>

                                            </div>

                                            <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px" >
                                                <div layout="column" flex tabindex="0" id="prevReq" >
                                                    <md-input-container class="md-block" class="row">

                                                        <md-switch ng-model="opcValue.coder.valor"
                                                                   ng-true-value="1"
                                                                   ng-false-value="0"
                                                                   ng-blur="checkSave($event)"
                                                                   class="Frm-value"
                                                        >
                                                            &nbsp;codificador
                                                        </md-switch>
                                                    </md-input-container>

                                                </div>

                                            </div>
                                            <div ng-if="critField.type == 2 || critField.type == 4" flex>

                                                <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                    <div layout="column" class="optHolder" flex tabindex="0" id="prevMin">
                                                        <md-input-container class="md-block" flex >
                                                            <label>Minimo</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.min.valor"
                                                                   class="Frm-value"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                        <md-input-container class="md-block" flex ng-show="opcValue.min.valor != ''">
                                                            <label>mensaje de Minimo</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.min.msg"
                                                                   class="Frm-msg"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                    </div>

                                                </div>
                                                <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                    <div layout="column" class="optHolder" flex tabindex="0" id="prevMax">
                                                        <md-input-container class="md-block" flex >
                                                            <label>Maximo</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.max.valor"
                                                                   class="Frm-value"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                        <md-input-container class="md-block" flex ng-show="opcValue.max.valor != ''">
                                                            <label>mensaje</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.max.msg"
                                                                   class="Frm-msg"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                    </div>
                                                </div>
                                                <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                    <div layout="column" class="optHolder" flex tabindex="0" id="prevMinI">
                                                        <md-input-container class="md-block" flex >
                                                            <label>Minimo Imposible</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.minI.valor"
                                                                   class="Frm-value"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                        <md-input-container class="md-block" flex ng-show="opcValue.minI.valor != ''">
                                                            <label>mensaje</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.minI.msg"
                                                                   class="Frm-msg"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                    </div>
                                                </div>
                                                <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                    <div layout="column" class="optHolder" flex tabindex="0" id="prevMaxI">
                                                        <md-input-container class="md-block" flex >
                                                            <label>Maximo  Imposible</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.maxI.valor"
                                                                   class="Frm-value"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                        <md-input-container class="md-block" flex ng-show="opcValue.maxI.valor != ''">
                                                            <label>mensaje</label>
                                                            <input skip-tab
                                                                   ng-model="opcValue.maxI.msg"
                                                                   class="Frm-msg"
                                                                   ng-blur="checkSave($event)"
                                                            >
                                                        </md-input-container>
                                                    </div>
                                                </div>

                                            </div flex>

                                            <div ng-if="critField.type == 1 || critField.type == 3" flex>
                                                <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px" >
                                                    <div layout="column" flex tabindex="0" id="prevReq" >
                                                        <md-input-container class="md-block" class="row">

                                                            <md-switch ng-model="opcValue.multi.valor"
                                                                       ng-true-value="1"
                                                                       ng-false-value="0"
                                                                       ng-blur="checkSave($event)"
                                                                       class="Frm-value"
                                                            >
                                                                &nbsp;Multiple?
                                                            </md-switch>
                                                        </md-input-container>

                                                    </div>

                                                </div>
                                                <div style="border-bottom: 1px solid #f1f1f1; margin-bottom: 4px">
                                                    <div layout="column" class="optHolder row" flex tabindex="0" id="prevOpc">
                                                        <md-input-container flex>
                                                            <label>VALORES</label>
                                                            <md-autocomplete md-selected-item="ctrl.selOption"
                                                                             flex
                                                                             skip-tab
                                                                             ng-required="(cnt.languaje.length==0)"
                                                                             md-selected-item-change="setOptSel(ctrl)"
                                                                             info="opcion a agregar"
                                                                             md-search-text="ctrl.searchOptions"
                                                                             md-items="item in listOptions | stringKey : ctrl.searchOptions: 'nombre' | filterSelect: opcValue.opts.valor"
                                                                             md-item-text="item.nombre"
                                                                             md-no-asterisk
                                                                             md-min-length="0"
                                                                             vl-no-clear
                                                                             class="Frm-value"
                                                            >
                                                                <input >
                                                                <md-item-template>
                                                                    <span>{{item.nombre}}</span>
                                                                </md-item-template>
                                                                <md-not-found>
                                                                    <a ng-click="createNewIten(ctrl)">la opcion <b>{{ctrl.searchOptions}}</b>, no existe
                                                                        crearla?</a>
                                                                </md-not-found>
                                                            </md-autocomplete>

                                                        </md-input-container>
                                                    </div>
                                                   <!-- <md-input-container class="md-block" flex ng-show="opcValue[opcion.descripcion].valor != ''">
                                                        <label>{{opcion.descripcion}} mensaje</label>
                                                        <input skip-tab
                                                               ng-model="opcValue[opcion.descripcion].msg"
                                                               ng-blur="checkSave($event)"
                                                        >
                                                    </md-input-container>-->
                                                </div>

                                                <md-content flex>
                                                    <div ng-repeat="opt in opcValue.opts.valor track by $index" class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                                        {{getoptSet(opt).nombre}}
                                                    </div>
                                                </md-content>
                                            </div>
                                        </md-content>

                                <!--</div>-->
                            </form>
                            <div flex>
                                <div class="titulo_formulario row" layout="column" layout-align="start start">
                                    <div ng-click="addDepend(false)">
                                        Dependencias
                                    </div>
                                </div>
                                <md-content flex>
                                    <div ng-repeat="dep in selCrit.deps track by $index" ng-click="addDepend(dep)" class="row" layout="row" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                        {{dep.parent.descripcion}} {{dep.operador}} {{dep.valor}}
                                    </div>
                                </md-content>

                            </div>

                        </div>
                    </md-content>
                    <show-next on-next="endCriterio" ></show-next>
                </div>
            </md-sidenav>

        </div>
        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" style="width:calc(100% - 928px);" md-disable-backdrop="true" md-component-id="newField" id="newField">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="createFieldController">
                <input type="hidden" >
                <form name="fieldForm" layout="row" class="focused" auto-close="{before:null,after:aftClose}">
                    <div style="width:24px; height: 100%;"></div>
                    <div flex>
                        <div class="titulo_formulario" layout="column" layout-align="start start" style="heigth:39px;">
                            <div>
                                Nuevo Campo
                            </div>
                        </div>
                        <div layout="row" class="column">
                            <md-input-container class="md-block" flex>
                                <label>Nombre del campo</label>
                                <input md-autofocus skip-tab minlength="2" required duplicate="fields" field="descripcion"  info="escribe el nombre del nuevo campo ej. \"acabado\"" alpha autocomplete="off" ng-disabled="$parent.enabled" ng-model="newField.descripcion">
                            </md-input-container>
                            <md-input-container class="md-block" flex>
                                <label>Tipo de Campo</label>
                                <md-autocomplete md-selected-item="ctrl.field"
                                                 flex
                                                 md-selected-item-change="newField.tipo_id = ctrl.field.id"
                                                 info="este sera el tipo por defecto para este campo"
                                                 skip-tab
                                                 required
                                                 md-require-match="true"
                                                 md-search-text="ctrl.searchType"
                                                 md-items="item in types | stringKey : ctrl.searchType: 'descripcion'"
                                                 md-item-text="item.descripcion"
                                                 md-no-asterisk
                                                 md-min-length="0">
                                    <input >
                                    <md-item-template>
                                        <span>{{item.descripcion}}</span>
                                    </md-item-template>
                                </md-autocomplete>
                                <!--  <label>Moneda</label>
                                  <md-select id="convCoin" skip-tab ng-disabled="$parent.enabled || coins.length < 1" ng-model="conv.coin" name="state" required md-no-ink>
                                      <md-option ng-repeat="coin in coins" value="{{coin.id}}">
                                          {{coin.nombre}}
                                      </md-option>
                                  </md-select>-->
                            </md-input-container>
                        </div>

                    </div>

                </form>

            </md-content>
        </md-sidenav>

        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 894px); z-index:80;" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" click-out="closeDepend()" md-component-id="lyrConfig" id="lyrConfig" >
            <!-- 11) ########################################## MINI LAYER SELECTOR TIPO DE CAMPO ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex ng-controller="dependencyController">
                <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">

                    <div style="padding: 0 8px 0 8px !important" layout="column" flex>
                        <div class="titulo_formulario row" layout="row" layout-align="start start" >
                            <div>
                                Configuraciones
                            </div>
                            <div style="width: 24px; font-size:24px;" ng-click="setEdit(true)"> + </div>
                            <div style="width: 24px; font-size:24px;" ng-click="setEdit(true)"> - </div>
                        </div>
                        <div layout="row" flex>
                            <div layout="row" flex="40">
                                <div style="background: url(images/shadowLeft.jpg) right repeat-y; width:1px">
                                </div>
                                <md-content flex layout="column">
                                    <div ng-repeat="field in criteria | filterSelect: configDep.lct_id" id="cfg_{{field.id}}" ng-class="{'field-sel':configDep.parent_id == field.id}" ng-click="setCfg('parent_id',field.id)" class="row itemCrit" layout="column" layout-align="center left" style="padding: 4px;">
                                        {{field.field.descripcion}}
                                    </div>
                                </md-content>
                            </div>
                            <div layout="row" flex="25">
                                <div style="background: url(images/shadowLeft.jpg) right repeat-y; width:1px"></div>
                                <div flex layout="column">
                                    <md-content >
                                        <div ng-repeat="oper in operator" id="cfg_{{$index}}" ng-if="oper.cfg=='all' || (oper.cfg.indexOf(currentParent.type.descripcion) != -1)" ng-click="setCfg('operator',oper.op)" ng-class="{'field-sel':configDep.operator == oper.op}"  class="row itemCrit" layout="column" layout-align="center center">
                                            {{oper.descripcion}}
                                        </div>
                                    </md-content>
                                </div>
                            </div>
                            <div layout="row" flex>
                                <div style="background: url(images/shadowLeft.jpg) right repeat-y; width:1px"></div>
                                <div flex layout="column">
                                    <div style="height: 160px; border-bottom:1px solid #ccc">

                                            <div class="titulo_formulario row" layout="row" layout-align="start start" >
                                                <div>
                                                    Condicion
                                                </div>
                                            </div>
                                            <md-content flex  ng-if="currentParent.type.descripcion == 'selector' || currentParent.type.descripcion == 'opciones'">
                                                <div
                                                    ng-repeat="opt in currentParent.options.Opcion track by $index"

                                                    ng-click="setCfg('condition',opt.pivot.value)"
                                                    class="row"
                                                    ng-class="{'field-sel':configDep.condition == opt.pivot.value}"
                                                    layout="column"
                                                    layout-align="center center"
                                                    style="border-bottom: 1px solid #ccc">
                                                    {{getoptSet(opt.pivot.value).nombre}}
                                                </div>
                                            </md-content>
                                            <md-input-container id="text" class="md-block" flex prevText ng-if="currentParent.type.descripcion == 'texto' || currentParent.type.descripcion == 'numerico'" ng-class="{'onlyread' : (field.type.directive == 'prevText')}">
                                                <label>valor</label>
                                                <input skip-tab
                                                       info="ingrese el valor contra el que se comparara"
                                                       autocomplete="off"
                                                       ng-model="configDep.condition"
                                                       md-no-asterisk
                                                       >

                                            </md-input-container>

                                    </div>
                                    <div flex>
                                        <div class="titulo_formulario row" layout="row" layout-align="start start" >
                                            <div>
                                                Acciones
                                            </div>
                                        </div>
                                        <md-input-container class="md-block row">
                                            <lmb-collection class="rad-contain"
                                                            layout="row"
                                                            style="width:100px;"
                                                            lmb-type="items"
                                                            lmb-model="configDep.action"
                                                            lmb-display="nombre"
                                                            lmb-itens="visibility"
                                                            lmb-key="id"

                                            >

                                        </md-input-container>
                                        <div class="row"></div>
                                        <div flex ng-if="currentCrit.type.descripcion == 'selector' || currentCrit.type.descripcion == 'opciones'">
                                            <div class="row">
                                                <div class="titulo_formulario row" layout="row" layout-align="start start" >
                                                    <div>
                                                        Valores posibles
                                                    </div>
                                                </div>
                                            </div>

                                            <lmb-collection class="rad-contain"
                                                            layout="column"
                                                            lmb-type="list"
                                                            multiple
                                                            ng-disabled="configDep.action == 'true' || configDep.action == 'false'"
                                                            lmb-model="configDep.action"
                                                            lmb-display="elem.nombre"
                                                            lmb-itens="selCrit.options.Opcion"
                                                            lmb-key="elem.id"

                                            >

                                            </lmb-collection>
                                            <!--<md-content flex>
                                                <div ng-repeat="opt in opcValue.opts.valor track by $index" class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                                    {{getoptSet(opt).nombre}}
                                                </div>
                                            </md-content>
-->
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </md-content>
                <div class="showNext" style="width: 16px;" ng-mouseover="(checkValid())?$parent.showNext(true,saveDependency):showAlert()" ng-mouseleave="over = false;">
                </div>
            </div>

        </md-sidenav>

        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" style="width:calc(100% - 928px);" md-disable-backdrop="true" md-component-id="treeLayer" id="treeLayer" click-out="closePopUp('treeLayer',$event)">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <input type="hidden" >
                <form name="fieldForm" layout="row" class="focused" ng-controller="treeController">
                    <div style="width:24px; height: 100%;"></div>
                    <div flex auto-close="{before:null,after:null}">
                        <div class="titulo_formulario" layout="column" layout-align="start start" style="heigth:39px;">
                            <div>
                                Tree
                            </div>
                        </div>
                        <div layout="row" class="column">

                            <treecontrol class="tree-light" tree-model="treedata">


                               <span ng-if="node.field" >
                                   {{node.field.descripcion}}
                                </span>


                            </treecontrol>
                        </div>

                    </div>

                </form>

            </md-content>
        </md-sidenav>
    </div>

    <next-row></next-row>

    <div ng-controller="notificaciones" ng-include="template"></div>
</div>