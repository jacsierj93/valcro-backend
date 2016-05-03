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
            <div layout="column" layout-align="center center" ng-click="addPedido()">
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
                    <md-select ng-model="id" name ="prov_id">
                        <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                            {{prov.razon_social}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25">
                <md-input-container class="md-block" >
                    <label>Moneda</label>
                    <md-select ng-model="pedidoSelec.prov_moneda_id"  required>
                        <md-option ng-repeat="moneda in filterData.monedas" value="{{moneda.id}}">
                            {{moneda.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Tipo envio</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="env in filterData.tipoEnv" value="{{env.id}}">
                            {{env.nombre}}
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
    </form>

    <div class="contentHolder" layout="row" flex>

        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral" >

            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex  ng-repeat="item in todos" ng-click="setProvedor(item)">

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
                    <div flex="" style="overflow: hidden; text-overflow: ellipsis; margin-right: 1px;">{{item.total| number:2}}</div>
                    <div flex="">860</div>
                    <div flex="" layout="row" style="height: 19px;">
                        <div >860</div>
                        <img  style="float: left;" src="images/contra_pedido.png"/>
                    </div>


                </div>

            </div>

        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
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
            Selecciones un Proveedor
        </div>

        <!-- 10) ########################################## LAYER (1) lista de pedidos########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listPedido" id="listPedido">
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
                                <div flex="15" class="cellGrid"> {{pedido.id}}</div>
                                <div flex="15" class="cellGrid"> {{pedido.nro_proforma}}</div>
                                <div flex="10" class="cellGrid"> {{pedido.emision | date:'dd/MM/yyyy' }}</div>
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
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detallePedido" id="detallePedido">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex >

                <form name="FormdetallePedido">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos del Pedido
                        </div>
                    </div>
                    <div layout="row"  >
                        <div  flex="15" class="md-block" style=" color: #999999;" >
                            Ordenes de Compra:
                        </div>
                        <div flex=""   class="md-block" layout="row" style="overflow: hidden;" ng-click="openOdcs()">
                            <div style="margin-right: 4px; margin-left:4px;" ng-repeat="orden in pedidoSelec.ordenes" ng-disabled="status == 2">
                                {{orden.nro_orden}}
                            </div>

                        </div>
                    </div>

                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block" flex="30">
                            <label>Tipo de Pedido</label>
                            <md-select ng-model="pedidoSelec.tipo_pedido_id" name ="tipo_pedido_id" ng-value="{{pedidoSelec.tipo_pedido_id}}">
                                <md-option ng-repeat="tipo in formData.tipo" ng-value="{{tipo.id}}">
                                    {{tipo.tipo}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="30">
                            <label>N° de Pedido</label>
                            <input  name="nro_doc"
                                    ng-model="pedidoSelec.id" ng-disabled="true">
                        </md-input-container>
                    </div>

                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block" flex="40">
                            <label>Proveedor</label>
                            <md-select ng-model="id" name ="prov_id" ng-disabled="true">
                                <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                    {{prov.razon_social}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-model="pedidoSelec.pais_id" name ="pais_id" ng-disabled="status == 2">
                                <md-option ng-repeat="pais in formData.paises" value="{{pais.id}}">
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>
                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block"  flex>
                            <label>Direccion</label>
                            <md-select ng-model="pedidoSelec.direccion_almacen_id" name ="direccion_almacen_id" ng-disabled="status == 2">
                                <md-option ng-repeat="dir in formData.direcciones" value="{{dir.id}}">
                                    {{dir.direccion}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>
                    <div layout="row" >
                        <md-input-container class="md-block" flex="20">
                            <label>Monto</label>
                            <input  ng-model="pedidoSelec.monto" name="monto" required  ng-disabled="status == 2">
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Moneda</label>
                            <md-select ng-model="pedidoSelec.prov_moneda_id" name ="prov_moneda_id" ng-disabled="status == 2">
                                <md-option ng-repeat="moneda in formData.monedas" value="{{moneda.id}}">
                                    {{moneda.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Tasa</label>
                            <input  ng-model="pedidoSelec.tasa" name ="tasa" ng-disabled="status == 2">
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <div layout="row" flex="" >
                            <md-input-container class="md-block" flex="20">
                                <label>Fijar tasa</label>
                                <input   name="tasa"  ng-disabled="status == 2" >
                                <!--<div ng-messages="projectForm.siglas.$error">
                                    <div ng-message="required">Obligatorio.</div>
                                    <div ng-message="md-maxlength">maximo 4</div>
                                </div>-->
                            </md-input-container>

                            <div flex=""  style="height: 30px;margin-top: 9px;  color: #999999;">
                                <md-switch  class="md-primary"  ng-model="pedidoSelec.tasa_fija" ng-disabled="status == 2">

                                </md-switch>
                            </div>
                        </div>

                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="">
                            <label>Condicion de pago</label>
                            <md-select ng-model="pedidoSelec.condicion_pago_id"  ng-disabled="status == 2" required>
                                <md-option ng-repeat="conPago in formData.condicionPago" value="{{conPago.id}}">
                                    {{conPago.titulo}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="">
                            <label>Motivo Pedido </label>
                            <md-select ng-model="pedidoSelec.motivo_pedido_id"  ng-disabled="status == 2" required>
                                <md-option ng-repeat="motivoPed in formData.motivoPedido" value="{{motivoPed.id}}">
                                    {{motivoPed.motivo}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Prioridad Pedido </label>
                            <md-select  ng-model="pedidoSelec.prioridad_id"  ng-disabled="status == 2" required>
                                <md-option ng-repeat="prioPed in formData.prioridadPedido" value="{{prioPed.id}}">
                                    {{prioPed.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Condiciones Pedido </label>
                            <md-select ng-model="pedidoSelec.condicion_pedido_id" ng-disabled="status == 2">
                                <md-option ng-repeat="condPed in formData.condicionPedido" value="{{condPed.id}}">
                                    {{condPed.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="row" >
                        <md-input-container class="md-block" flex >
                            <label>Comentario</label>
                            <input ng-model="pedidoSelec.comentario"  ng-disabled="status == 2">
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="20">
                            <label>Mt3</label>
                            <input ng-model="pedidoSelec.mt3"  name="mt3"  ng-disabled="status == 2">
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Peso</label>
                            <input ng-model="pedidoSelec.peso" name="peso" ng-disabled="status == 2">
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>

                </form>

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Aprovacion de Gerente
                    </div>
                </div>

                <div layout="row" >

                    <md-input-container class="md-block" flex="">
                        <label>Estatus</label>
                        <md-select ng-model="status" name ="estado" >
                            <md-option  value="1" >
                                Pendiente
                            </md-option>
                            <md-option  value="2">
                                Aprobado
                            </md-option>
                            <md-option  value="3">
                                Cancelado
                            </md-option>
                        </md-select>
                    </md-input-container>
                </div>

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Aprobación
                    </div>
                </div>
                <form name="aprobacion">

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
                            <input maxlength="6"  name="nro_doc_pay" ng-minlength="3"  nng-disabled="status == 2">

                        </md-input-container>

                    </div>
                    <div layout="row" flex="" >

                        <md-input-container class="md-block" flex="30">
                            <label>Imagen Adjunto</label>
                            <input flex maxlength="180" type="file" style="display: none;" id="img" name="img_abono"  ng-disabled="status == 3">
                            <?= HTML::image("images/adjunto.png",'null', array('id' => 'adjunto', 'class' => 'image')) ?>
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>
                </form>

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Cancelacion
                    </div>
                </div>
                <form name="cancelacion">
                    <div layout="row"  >
                        <md-input-container class="md-block" flex >
                            <label>Motivo de cancelacion </label>
                            <input  ng-model="pedidoSelec.comentario_cancelacion" name="comentario_cancelacion" ng-disabled="status == 2 || status == 3" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>
                    </div>
                </form>

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Compromiso
                    </div>
                </div>

                <form name="compromiso">

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
            <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>
        </md-sidenav>

        <!-- 12) ########################################## LAYER (3)ORDENES DE COMPRAS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="odc" id="odc">
            <!--) ########################################## CONTENDOR SECCION ORDENES DE COMPRA ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>

                <form name="gridPedidos">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Ordenes de Compra
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex="5" class="headGrid"> % </div>
                        <div flex="10" class="headGrid"> Nº de ODC</div>
                        <div flex="20" class="headGrid"> Proveedor</div>
                        <div flex="5" class="headGrid"> Cant.</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="20" class="headGrid"> Status</div>
                        <div flex class="headGrid"> Comentarios</div>
                    </div>
                    <div id="gridOdc">
                        <div flex>
                            <div layout="row" class="cellGridHolder"  ng-repeat="odc in formData.odc">
                                <div class="cellGrid" flex="5">
                                    <md-switch class="md-primary" ng-model="odc.asig" ng-change="change(odc)" ></md-switch>
                                </div>
                                <div flex="10" class="cellGrid" ng-click="selecOdc(odc)"> {{odc.nro_orden}}</div>
                                <div flex="20" class="cellGrid" ng-click="selecOdc(odc)"> {{provSelec.razon_social}}</div>
                                <div flex="5" class="cellGrid" ng-click="selecOdc('odc')"> {{odc.size}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecOdc(odc)">{{odc.emision | date:'dd-MM-yyyy'}}</div>
                                <div flex="20" class="cellGrid" ng-click="selecOdc(odc)"> {{odcEstatus(odc)}}</div>
                                <div flex class="cellGrid"ng-click="selecOdc(odc)" > {{odc.comentario}}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <!-- 13) ########################################## LAYER (4) RESUMEN ODC ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenodc" id="resumenodc">
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE ODC ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>

                <form name="resumenOdc" >

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Resumen de Orden de Compra
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="10">
                            <label>Nº ODC:</label>
                            <input  ng-model="odcSelec.id" name="monto" required  ng-disabled="true">

                        </md-input-container>


                        <md-input-container class="md-block" flex="15">
                            <label>Fecha:</label>
                            <input md-maxlength="4" required md-no-asterisk name="fecha"
                                   ng-model="odcSelec.emision" ng-disabled="true" >
                        </md-input-container>

                        <md-input-container class="md-block" flex="40">
                            <label>Fabrica</label>
                            <md-select ng-model="id" name ="prov_id" ng-disabled="true">
                                <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                    {{prov.razon_social}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Pais</label>
                            <md-select ng-model="pedidoSelec.pais_id" name ="pais_id" ng-disabled="true">
                                <md-option ng-repeat="pais in formData.paises" value="{{pais.id}}">
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>Status:</label>
                            <md-select ng-model="odcSelec.aprobada" name ="status" ng-disabled="true">
                                <md-option value="1">
                                    Aprobada
                                </md-option>
                                <md-option value="0">
                                    No Aprobada
                                </md-option>
                            </md-select>

                        </md-input-container>
                        <md-input-container class="md-block" flex>
                            <label>Comentario:</label>
                            <input name="coment" ng-model="odcSelec.comentario" >


                        </md-input-container>
                    </div>
                    <div class="titulo_formulario"  style='margin-top: 20px;' layout="column" layout-align="start start">
                        <div>
                            Productos a Solicitar
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex="10" class="headGrid"> Tipo</div>
                        <div flex="15" class="headGrid"> Cod. Producto</div>
                        <div flex class="headGrid"> Cod. Profit</div>
                        <div flex class="headGrid"> Descripción.</div>
                        <div flex="10" class="headGrid"> Cantidad</div>
                        <div flex class="headGrid"> Comentario</div>
                        <div flex class="headGrid"> Adjunto</div>
                    </div>
                    <div id="gridResOdc">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="product in odcSelec.productos">
                                <div flex="10" class="cellGrid"> {{product.tipo}}</div>
                                <div flex="15" class="cellGrid">  {{product.id}}</div>
                                <div flex class="cellGrid"> {{product.profit_id}}</div>
                                <div flex class="cellGrid">  {{product.descripcion}}</div>
                                <div flex="10" class="cellGrid">  {{product.cantidad}}</div>
                                <div flex class="cellGrid">  {{product.comentario}}</div>
                                <div flex class="cellGrid">  {{product.adjunto}}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) Agregar Pedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPed" id="agrPed">
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE ODC ########################################## -->
            <md-content  layout="row" style="'margin-top:0px;'" layout-padding flex>

                <!--<div class="titulo_formulario" layout="row" flex>-->
                <div layout="column" flex>
                    <div class="titulo_formulario md-block" layout-padding layout="row" layout-align="end start" flex>
                        <div>
                            Contrapedidos
                        </div>
                        <div ng-click="openContraPedido()">
                            <?= HTML::image("images/agregar.png",'null', array('class' => 'image') ) ?>
                        </div>
                    </div>

                    <div >
                        <div layout="column" flex="" style="margin-left: 8px;">
                            <div layout="row" class="cellGridHolder" ng-repeat="contraP in pedidoSelec.contraPedido">

                                <div flex class="cellGrid"> {{contraP.id}}</div>
                                <div flex class="cellGrid"> {{contraP.titulo}}</div>
                                <div flex class="cellGrid"> {{contraP.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="removeLisContraP(contraP)"> <?= HTML::image("images/eliminar.png",'null', array('class' => 'image') ) ?> </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div layout="column" flex>
                    <div class="titulo_formulario md-block" layout-padding layout="row" layout-align="end start" flex>
                        <div>
                            Kitchen Boxs
                        </div>
                        <div ng-click="addkitChenBox()">
                            <?= HTML::image("images/agregar.png",'null', array('class' => 'image')) ?>
                        </div>
                    </div>

                    <div >
                        <div layout="column" flex="" style="margin-left: 8px;">
                            <div layout="row" class="cellGridHolder" ng-repeat="contraP in pedidoSelec.kitchenBox">

                                <div flex class="cellGrid"> {{contraP.id}}</div>
                                <div flex class="cellGrid"> {{contraP.titulo}}</div>
                                <div flex class="cellGrid"> {{contraP.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="removeLisContraP(contraP)"> <?= HTML::image("images/eliminar.png",'null', array('class' => 'image') ) ?> </div>
                            </div>
                        </div>
                    </div>



                </div>
                <div layout="Column" flex>
                    <div class="titulo_formulario md-block" layout-padding layout="row" layout-align="end start" flex>
                        <div>
                            Pedidos a Sustituir
                        </div>
                        <div ng-click="setPed('agrPedPend')">
                            <?= HTML::image("images/agregar.png",'null', array('class' => 'image')) ?>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </md-content>
        </md-sidenav>

        <!-- 15) ########################################## LAYER (6) Agregar Contrapedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrContPed" id="agrContPed">
            <!-- ) ########################################## CONTENDOR Agregar Contrapedidos ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <form name="addContraPedidos" >

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Agregar Contrapedidos
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex="5" class="headGrid"> % </div>
                        <div flex="5" class="headGrid"> Id </div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex class="headGrid"> Titulo</div>
                        <div flex class="headGrid"> Comentario</div>
                        <div flex="10" class="headGrid"> Fecha Aprox</div>
                        <div flex="15" class="headGrid"> Monto</div>

                    </div>
                    <div id="gridContPed">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="contraP in formData.contraPedido">
                                <div class="cellGrid" flex="5">
                                    <md-switch class="md-primary" ng-model="contraP.asig" ng-change="changeContraP(contraP)"></md-switch>
                                </div>
                                <div flex="5" class="cellGrid"> {{contraP.id}}</div>
                                <div flex="10" class="cellGrid"> {{contraP.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid"> {{contraP.titulo}}</div>
                                <div flex class="cellGrid"> {{contraP.comentario}}</div>
                                <div flex="10" class="cellGrid"> {{contraP.fecha_aprox_entrega | date:'dd/MM/yyyy' }}</div>
                                <div flex="15" class="cellGrid"> {{contraP.monto}}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (7) Agregar KITCHEN BOXS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrKitBoxs" id="agrKitBoxs">
            <!-- ) ########################################## CONTENDOR Agregar KITCHEN BOXS ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <form name="KitchenBoxs" >

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Agregar Kitchen Boxs
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex="5" class="headGrid"> % </div>
                        <div flex="5" class="headGrid">ID</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="15" class="headGrid"> Nº de Proforma</div>
                        <div flex="10" class="headGrid"> IMG Proforma</div>
                        <div flex="15" class="headGrid"> Monto</div>
                        <div flex="15" class="headGrid"> Precio</div>
                        <div flex class="headGrid"> Tiemp. Aprox. de Entrega</div>

                    </div>
                    <div id="gridKitBoxs">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="kitchenBox in formData.kitchenBox">
                                <div class="cellGrid" flex="5">
                                    <md-switch class="md-primary" ng-model="kitchenBox.asig" ng-change="changeKitchenBox(kitchenBox)"></md-switch>
                                </div>
                                <div flex="5" class="cellGrid"> {{kitchenBox.id}}</div>
                                <div flex="10" class="cellGrid"> {{kitchenBox.fecha | date:'dd/MM/yyyy'}}</div>
                                <div flex="15" class="cellGrid"> {{kitchenBox.num_proforma}}</div>
                                <div flex="10" class="cellGrid"> {{kitchenBox.img_proforma}}</div>
                                <div flex="15" class="cellGrid"> {{kitchenBox.monto}}</div>
                                <div flex="15" class="cellGrid"> {{kitchenBox.precio}}</div>
                                <div flex class="cellGrid"> {{kitchenBox.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>
        <!-- 17) ########################################## LAYER (8) Pedidos Pendientes########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPedPend" id="agrPedPend">
            <!-- ) ########################################## CONTENDOR  Pedidos Pendientes # ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <form name="gridPagosPendientes" >

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Pedidos Pendientes
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex class="headGrid">-</div>
                        <div flex class="headGrid">-</div>
                        <div flex class="headGrid"> Nº de Pedido</div>
                        <div flex class="headGrid"> Nombre Proveedor</div>
                        <div flex class="headGrid"> Nº de Proforma</div>
                        <div flex class="headGrid"> Fecha</div>
                        <div flex class="headGrid"> Nº de Factura</div>
                        <div flex class="headGrid"> Monto</div>
                        <div flex class="headGrid"> Comentario</div>

                    </div>
                    <div id="gridPedPend">
                        <div flex>
                            <div layout="row" class="cellGridHolder">
                                <div class="cellGrid">
                                    <md-switch class="md-primary" ng-model="dtaPrv.cb1"></md-switch>
                                </div>
                                <div flex class="cellGrid"> Data 2</div>
                                <div flex class="cellGrid"> Data 3</div>
                                <div flex class="cellGrid"> Data 4</div>
                                <div flex class="cellGrid"> Data 5</div>
                                <div flex class="cellGrid"> Data 6</div>
                                <div flex class="cellGrid"> Data 7</div>
                                <div flex class="cellGrid"> Data 8</div>
                                <div flex class="cellGrid"> Data 9</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>
        <!------------------------------------------- Flecha de siguiente------------------------------------------------------------------------->
        <md-sidenav
            style="margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');"
            layout="column" layout-align="center center" class="md-sidenav-right"
            md-disable-backdrop="true" md-component-id="NEXT" id="NEXT"
            ng-mouseleave="showNext(false)" ng-click="next()">
            <?= HTML::image("images/btn_nextArrow.png") ?>
        </md-sidenav>
    </div>
</div>

