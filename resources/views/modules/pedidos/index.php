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

                <div style="height: 24px"></div>
                <div style="height:40px;" layout="row" layout-align="start end">
                    <div flex="">$1000</div>
                    <div flex="">860</div>
                    <div flex="" layout="row">
                        <div style="margin: 4px;">860</div>
                        <img  style="float: left;" src="images/contra_pedido.png"/>
                    </div>


                </div>

            </div>

        </md-content>
        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <!--agregar-->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center" ng-click="closeLayer()">
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

        <!-- 10) ########################################## LAYER (1) Lista de pedidos ########################################## -->
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
                    <div id="grid" ng-repeat="pedido in provSelec.pedidos" ng-click="selecPedido(pedido)">
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

        <!-- 11) ########################################## LAYER (2) FORMULARIO INFORMACION DEL pedido ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detallePedido">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex >
                <form name="detallePedido">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos del Pedido
                        </div>
                    </div>
                    <div layout="row"  >
                        <div  flex="15" class="md-block" style=" color: #999999;" >
                            Ordenes de Compra:
                        </div>

                        <div flex=""   class="md-block" style=" color: #999999;"  ng-click="setPed('odc')">
                            {{pedidoSelec.ordenes_compra}}
                        </div>
                    </div>

                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block" flex="30">
                            <label>Tipo de Pedido</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="state" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="30">
                            <label>N° de Pedido</label>
                            <input maxlength="80" ng-minlength="3" required md-no-asterisk name="description"
                                   ng-model="pedidoSelec.nro_doc">
                        </md-input-container>
                    </div>

                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block" flex="40">
                            <label>Proveedor</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="proveedor" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="pais" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>
                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block"  flex>
                            <label>Direccion</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="direccion" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>
                    <div layout="row" >
                        <md-input-container class="md-block" flex="20">
                            <label>Monto</label>
                            <input maxlength="6"  name="monto" ng-minlength="3"  >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Moneda</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="moneda" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Tasa</label>
                            <input maxlength="6"  name ="tasa"  ng-minlength="3"  >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <div layout="row" flex="" >
                            <md-input-container class="md-block" flex="20">
                                <label>Fijar tasa</label>
                                <input maxlength="6"  name="tasa" ng-minlength="3"  >
                                <!--<div ng-messages="projectForm.siglas.$error">
                                    <div ng-message="required">Obligatorio.</div>
                                    <div ng-message="md-maxlength">maximo 4</div>
                                </div>-->
                            </md-input-container>

                            <div flex=""  style="height: 30px;margin-top: 9px;  color: #999999;">
                                <md-switch  class="md-primary"
                                            ng-model="dtaPrv.fijaT"
                                            name="fijaT" aria-label="fijaT">

                                </md-switch>
                            </div>
                        </div>



                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="">
                            <label>Condicion de pago</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="condiPago" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="">
                            <label>Motivo Pedido </label>
                            <md-select ng-model="pedidoSelec.tipo" name ="motivo_ped" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Prioridad Pedido </label>
                            <md-select ng-model="pedidoSelec.tipo" name ="prioridad" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Condicion Pedido </label>
                            <md-select ng-model="pedidoSelec.tipo" name ="condicion" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="row" >
                        <md-input-container class="md-block" flex >
                            <label>Comentario</label>
                            <input maxlength="6"  name="comentario" ng-minlength="3"  >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="20">
                            <label>Mt3</label>
                            <input maxlength="6"  name="mt3" ng-minlength="3"  >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Peso</label>
                            <input maxlength="6"  name="peso" ng-minlength="3"  >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Aprovacion de Gerente
                        </div>
                    </div>

                    <div layout="row" >

                        <md-input-container class="md-block" flex="">
                            <label>Estatus</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="aprv_gerente" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Aprovacion
                        </div>
                    </div>
                    <div layout="row" >
                        <div flex="15" style="height: 30px;margin-top: 9px;  color: #999999;" >
                            Fecha de Aprobación
                        </div>

                        <md-datepicker  flex="25" name="fecha_aprob" ng-model="myDate"
                                        required md-min-date="minDate" md-max-date="maxDate"
                                        md-date-filter="onlyWeekendsPredicate">
                        </md-datepicker>

                        <md-input-container class="md-block" flex="25">
                            <label>Tipo de pago</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="tipo_pago" value="{{pedidoSelec.tipo}}">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="30">
                            <label>N° Documento</label>
                            <input maxlength="6"  name="nro_doc_pay" ng-minlength="3"  >

                        </md-input-container>

                    </div>
                    <div layout="row" flex="" >

                        <md-input-container class="md-block" flex="30">
                            <label>Imagen Adjunto</label>
                            <input maxlength="6"  name="img_pago" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Cancelacion
                        </div>
                    </div>
                    <div layout="row"  >
                        <md-input-container class="md-block" flex >
                            <label>Imagen Abono</label>
                            <input maxlength="6"  name="cancelacion" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Compromiso
                        </div>
                    </div>
                    <div layout="row"  >
                        <md-input-container class="md-block" flex>
                            <label>Imagen Adjunto</label>
                            <input maxlength="6"  name="cancelacion" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>


                    <div layout="row"  flex="" >
                        <div flex="25" style="height: 30px;margin-top: 9px;  color: #999999;" >
                            Fecha estimada de Compromiso
                        </div>

                        <md-datepicker flex="25" name="fecha_est_compro" ng-model="myDate"
                                       required md-min-date="minDate" md-max-date="maxDate"
                                       md-date-filter="onlyWeekendsPredicate">
                        </md-datepicker>
                        <div flex="20" style="height: 30px;margin-top: 9px;  color: #999999;" >
                            Fecha limite de credito
                        </div>
                        <div flex="15"  style="height: 30px;margin-top: 9px;  color: #999999;">
                            <md-switch  class="md-primary"
                                        ng-model="dtaPrv.fijaT"
                                        name="fijaT" aria-label="fijaT">

                            </md-switch>
                        </div>

                    </div>


                </form>

            </md-content>
        </md-sidenav>

        <!-- 12) ########################################## LAYER (3)ORDENES DE COMPRAS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="odc">
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
                            <div layout="row" class="cellGridHolder" ng-click="setPed('resumenodc')">
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
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 360px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenodc">
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
    </div>


</div>

