<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION PEDIDOS########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex  ng-controller="PedidosCtrll">
    <!-- 2) ########################################## AREA DEL MENU ########################################## -->
    <div layout="row" flex="none" class="menuBarHolder">
        <!-- 3) ########################################## MENU ########################################## -->
        <div layout="row" layout-align="start center" class="menu">
            <div flex layout-align="center center">
                Menu
            </div>
            <div layout="column" style="width: 48px; height: 48px;" layout-align="center center">
                <?= HTML::image("images/btn_nextArrow.png") ?>
            </div>
        </div>
        <!-- 4) ########################################## BOTONERA ########################################## -->
        <div class="botonera" layout layout-align="start center">
            <div layout="column" layout-align="center center">

            </div>
            <div layout="column" layout-align="center center" >
                <!--<i class="fa fa-plus"></i>-->
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center">
                <!--<i class="fa fa-filter"></i>-->
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center" >
                <!--<i class="fa fa-minus"></i>-->
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>
        <!-- 4) ########################################## FILTROS ########################################## -->

        <div  layout layout-align="start center" flex>

            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Proveedor</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="state in states" value="{{state.id}}">
                            {{state.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25">
                <md-input-container class="md-block" >
                    <label>Moneda</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="state in states" value="{{state.id}}">
                            {{state.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Tipo envio</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="state in states" value="{{state.id}}">
                            {{state.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>

            <div layout="column" layout-align="center center" >
                <md-input-container class="md-block">
                    <md-switch class="md-primary" aria-label="Activo">
                        Activo
                    </md-switch>
                </md-input-container>
            </div>
        </div>
    </div><!---fin menu-->

    <div class="contentHolder" layout="row" flex>
        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral" >

            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex ng-click="setPed('right')">

                <div class="boxList" layout="column" flex>

                    <div  style="height: 80px;">Nombre del proveedor</div>
                    <div layout="row" style="height: 40px;">
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #003000;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #006600;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #009A00;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #00CD00;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantPediLlegar" style="background-color: #00CCA2;">
                                85
                            </div>
                        </div>
                    </div>
                    <div style="height: 24px"></div>

                </div>
            </div>

        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
            <?= HTML::image("images/btn_prevArrow.png") ?>
        </div>
        <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                P
            </div>
            <br>
            Seleccione un Proveedor
        </div>

        <!-- 10) ########################################## LAYER (1) LISTA PEDIDOS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="right">
            <!-- 11) ########################################## CONTENDOR SECCION ORDENES DE COMPRA ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <form name="projectForm" ng-controller="PedidosCtrll">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Ordenes de Compra
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex class="headGrid"> a</div>
                        <div flex class="headGrid"> Nº de ODC</div>
                        <div flex class="headGrid"> Proveedor</div>
                        <div flex class="headGrid"> Cant.</div>
                        <div flex class="headGrid"> Fecha</div>
                        <div flex class="headGrid"> Status</div>
                        <div flex class="headGrid"> Comentarios</div>
                    </div>
                    <div id="grid">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-click="setPed('left')">
                                <div flex class="cellGrid">
                                    <md-switch class="md-primary" ng-model="dtaPrv.cb1"></md-switch>
                                </div>
                                <div flex class="cellGrid"> Data 2</div>
                                <div flex class="cellGrid"> Data 3</div>
                                <div flex class="cellGrid"> Data 4</div>
                                <div flex class="cellGrid"> Data 5</div>
                                <div flex class="cellGrid"> Data 6</div>
                                <div flex class="cellGrid"> Data 7</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <!-- 11) ########################################## LAYER (2) RESUMEN ODC ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="left">
            <!-- 11) ########################################## CONTENDOR SECCION ORDENES DE COMPRA ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <form name="projectForm" ng-controller="PedidosCtrll">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Resumen de Orden de Compra
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="20">
                            <label>Nº ODC:</label>
                            <md-select ng-model="dtaPed.type" name ="odc">
                                <md-option ng-repeat="states in states" value="{{index}}">
                                    {{states.abbrev}}
                                </md-option>
                            </md-select>

                            <div ng-messages="projectForm.type.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>
                        </md-input-container>


                        <md-input-container class="md-block" flex>
                            <label>Fecha:</label>
                            <input md-maxlength="4" required md-no-asterisk name="fecha"
                                   ng-model="dtaPed.fecha">
                            <div ng-messages="projectForm.fecha.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block" flex>
                            <label>Fabrica:</label>
                            <input md-maxlength="80" required name="fabrica" ng-model="dtaPed.fabrica" >
                            <div ng-messages="projectForm.fabrica.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">La fabrica no debe tener mas de 80 caracteres.</div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block" flex>
                            <label>Pais:</label>
                            <input md-maxlength="40" required name="pais" ng-model="dtaPed.pais" >
                            <div ng-messages="projectForm.pais.$error">
                                <div ng-message="required">Obligatorio.</div>
                            </div>
                        </md-input-container>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>Status:</label>
                            <input md-maxlength="10" required name="status" ng-model="dtaPed.status" >
                            <div ng-messages="projectForm.status.$error">
                                <div ng-message="required">Obligatorio.</div>
                            </div>
                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Comentario:</label>
                            <input md-maxlength="100" required name="coment" ng-model="dtaPed.coment" >
                            <div ng-messages="projectForm.coment.$error">
                                <div ng-message="required">Obligatorio.</div>
                            </div>
                        </md-input-container>
                    </div>
                    <div class="titulo_formulario"  style='margin-top: 20px;' layout="Column" layout-align="start start">
                        <div>
                            Productos a Solicitar
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex class="headGrid"> Tipo</div>
                        <div flex class="headGrid"> Cod. Producto</div>
                        <div flex class="headGrid"> Cod. Profit</div>
                        <div flex class="headGrid"> Descripción.</div>
                        <div flex class="headGrid"> Cantidad</div>
                        <div flex class="headGrid"> Comentarios</div>
                        <div flex class="headGrid"> Adjuntos</div>
                    </div>
                    <div id="grid">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-click="setPed('agrPed')">
                                <div flex class="cellGrid"> Data 1</div>
                                <div flex class="cellGrid"> Data 2</div>
                                <div flex class="cellGrid"> Data 3</div>
                                <div flex class="cellGrid"> Data 4</div>
                                <div flex class="cellGrid"> Data 5</div>
                                <div flex class="cellGrid"> Data 6</div>
                                <div flex class="cellGrid"> Data 7</div>
                            </div>
                        </div>
                    </div>
                <form>
            </md-content>
        </md-sidenav>

        <!-- 11) ########################################## LAYER (3)  ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPed">
            <!-- 11) ########################################## CONTENDOR SECCION ORDENES DE COMPRA ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <form name="projectForm" ng-controller="PedidosCtrll">

                    <div class="titulo_formulario" layout="row" layout-align="start start">
                        <div>
                            Contra Pedidos
                            <div layout="column" layout-align="center center" >
                                <!--<i class="fa fa-plus"></i>-->
                                <?= HTML::image("images/agregar.png") ?>
                            </div>
                        </div>
                    </div>
                    <div class="titulo_formulario" layout="row" layout-align="start start">
                        <div>
                            Kitchen Boxs
                            <div layout="column" layout-align="center center" >
                                <!--<i class="fa fa-plus"></i>-->
                                <?= HTML::image("images/agregar.png") ?>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>
    </div>
</div>

