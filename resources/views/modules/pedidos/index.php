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
            <div class="boxList" layout="column" flex  ng-repeat="item in todos" ng-click="setProv(item.id)">

                <div class="boxList" layout="column" flex >

                    <div  style="overflow: hidden; text-overflow: ellipsis; height: 80px;">{{item.razon_social}}</div>

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
                    <div style="height:40px;" layout="row" layout-align="start end">
                        <div flex="">$1000</div>
                        <div flex="">860</div>
                        <div flex="" layout="row">
                            <div style="margin: 4px;">860</div>
                            <img  style="float: left;" src="images/contra_pedido.png"/>
                        </div>


                    </div>

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
            Selecciones un Proveedor
        </div>

        <!-- 10) ########################################## LAYER (1) RESUMEN DEL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listPedido">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>

                <form name="projectForm">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Pedidos : <span>{{provSelec.razon_social}}</span>
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex="5" class="headGrid"> - </div>
                        <div flex="15" class="headGrid"> N° Pedido</div>
                        <div flex="15" class="headGrid"> N° Proforma</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="15" class="headGrid"> N° Factura</div>
                        <div flex class="headGrid"> Monto</div>
                        <div flex class="headGrid"> Comentario</div>
                    </div>
                    <div id="grid" ng-repeat="pedido in provSelec.pedidos">
                        <div flex>
                            <div layout="row" class="cellGridHolder">
                                <div flex="5" class="cellGrid"> {{pedido.tipo}}</div>
                                <div flex="15" class="cellGrid"> {{pedido.nro_doc}}</div>
                                <div flex="15" class="cellGrid"> {{pedido.nro_proforma}}</div>
                                <div flex="10" class="cellGrid"> {{pedido.emision  }}</div>
                                <div flex="15" class="cellGrid"> {{pedido.nro_factura}}</div>
                                <div flex class="cellGrid"> {{pedido.monto}}</div>
                                <div flex class="cellGrid">{{pedido.comentario}}</div>
                            </div>
                        </div>
                    </div>

                </form>

            </md-content>
        </md-sidenav>


    </div>



</div>

