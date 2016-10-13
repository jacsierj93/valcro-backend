<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex >



    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex ng-controller="prodMainController">

        <div class="barraLateral" layout="column" >
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
                <div class="boxList"  layout="column" list-box flex ng-repeat="line in listLines" id="lineId{{line.id}}" ng-click="clicked()" >
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
                    <span class="icon-Agregar" style="font-size: 23px"></span>
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
                    <!--creacion o edicion de la linea-->
                    <form name="LineProd" layout="row" class="focused" >
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
                                               ng-model="dtaPrv.description"
                                        >

                                    </md-input-container>
                                    <md-input-container class="md-block" flex="10">
                                        <label>Siglas</label>
                                        <input skip-tab
                                               info="Siglas para esta linea"
                                               autocomplete="off"
                                               name="linea"
                                               maxlength="80"
                                               ng-minlength="3"
                                               required
                                               md-no-asterisk

                                        >

                                    </md-input-container>
                                    </div>
                            </div>
                        </div>

                    </form>

                    <!--creacion y carga de sublineas-->
                    <form name="subLine" layout="row" class="focused" >
                        <div active-left></div>
                        <div flex layout="column">
                            <div class="titulo_formulario" layout="column" layout-align="start start">
                                <div>
                                    Sub Linea
                                </div>
                            </div>
                            <div flex layout="column" class="area-form">
                                <div class="row" layout="row">

                                    <md-input-container class="md-block" flex>
                                        <label>Nombre de Sublinea</label>
                                        <input skip-tab
                                               info="indique el nombre del proveedor"
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
                                               ng-model="dtaPrv.description"
                                        >

                                    </md-input-container>
                                    <md-input-container class="md-block" flex="10">
                                        <label>Siglas</label>
                                        <input skip-tab
                                               info="Siglas para esta linea"
                                               autocomplete="off"
                                               name="linea"
                                               maxlength="80"
                                               ng-minlength="3"
                                               required
                                               md-no-asterisk

                                        >

                                    </md-input-container>
                                </div>
                                <div class="row" layout="row">
                                    <md-input-container class="md-block" flex>
                                        <label>Comentario</label>
                                        <input skip-tab
                                               info="comentarios"
                                               autocomplete="off"
                                               name="linea"
                                               maxlength="80"
                                               ng-minlength="3"
                                               required
                                               md-no-asterisk

                                        >

                                    </md-input-container>
                                </div>
                              <!--  <div layout="column" class="row showMore">
                                    <div flex style="border: dashed 1px #f1f1f1; text-align: center"><img src="images/Down.png"/></div>
                                </div>-->
                                <div layout="column" flex>

                                    <div layout="row" class="headGridHolder" style="font-weight: bolder;">
                                        <div flex class="headGrid row"> Nombre</div>
                                        <div flex="20" class="headGrid row"> Siglas</div>
                                        <!--<div flex="10" class="headGrid row"> Comentario</div>-->
                                        <div flex="5" class="headGrid row"> Criterio</div>
                                    </div>
                                    <md-content id="grid" flex >
                                        <div flex ng-repeat="cont in [0,1,2,3,4,5,6]" class="row" ng-click="opennext()">
                                            <div layout="row" layout-wrap class="cellGridHolder" >
                                                <div flex class="headGrid row"> Nombre</div>
                                                <div flex="20" class="headGrid row"> Siglas</div>
                                                <!--<div flex="10" class="headGrid row"> Comentario</div>-->
                                                <div flex="5" class="headGrid row"> Criterio</div>
                                            </div>
                                        </div>
                                    </md-content>
                                    <div layout="column" class="row" >
                                        <div flex style="border: dashed 1px #f1f1f1; text-align: center"><span class="icon-Above"></span></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                    <div flex></div>
                </md-content>
            </div>
        </md-sidenav>


        <md-sidenav  style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" layout="column" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->

            <input type="hidden" md-autofocus>
            <div layout="row" flex>
                <md-content class="cntLayerHolder" layout="row" flex style="padding: 0 0 0 0 !important;">
                    <div flex="30" layout="column" ng-controller="formPreview">
                        <form name="LineProd" layout="row" class="focused" >
                            <div active-left></div>
                            <div flex layout="column">
                                <div class="titulo_formulario" layout="column" layout-align="start start">
                                    <div>
                                        vista previa Formulario
                                    </div>
                                </div>
                                <div flex>
                                    <div ng-repeat="field in criteria" class="row" bind-directive="field.type.directive">

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div flex="15" layout="column" class="md-whiteframe-2dp">
                        <md-content style="margin: 0 8px 0 8px !important;">
                            <div ng-repeat="i in [0,1,2,3,4,5,6,7]" class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                <div>campo {{i}}</div>
                            </div>
                        </md-content>
                    </div>
                    <div flex="15" layout="column" class="md-whiteframe-2dp">
                        <md-content style="margin: 0 8px 0 8px !important;">
                            <div ng-repeat="i in tipos" class="row" layout="column" layout-align="center center" style="border-bottom: 1px solid #ccc">
                                <div>{{i}}</div>
                            </div>
                        </md-content>
                    </div>
                    <div flex layout="column" class="md-whiteframe-2dp">

                    </div>
                </md-content>
            </div>
        </md-sidenav>
    </div>
</div>