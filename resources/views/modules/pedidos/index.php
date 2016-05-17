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
            <div layout="column" layout-align="center center" ng-click="DtPedido('null')">
                <!--<i class="fa fa-plus"></i>-->
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center" ng-show="(index>0)" ng-click="updateForm()">
                <!--<i class="fa fa-filter"></i>-->
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center"  ng-show="index>0" ng-click="openLayer('detallePedido')">
                <!--<i class="fa fa-minus"></i>-->
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>
        <!-- 4) ########################################## FILTROS ########################################## -->

        <div  layout layout-align="start center" flex>

            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Proveedor</label>
                    <md-select ng-model="filterOption.prov_id" >
                        <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                            {{prov.razon_social}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25">
                <md-input-container class="md-block" >
                    <label>Moneda</label>
                    <md-select ng-model="filterOption.moneda_id" >
                        <md-option ng-repeat="moneda in filterData.monedas" value="{{moneda.id}}">
                            {{moneda.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Tipo envio</label>
                    <md-select ng-model="filterOption.tipo_env_id" >
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
            <div class="boxList" layout="column" flex  ng-repeat="item in todos" ng-click="setProvedor(item)"  ng-class="{'listSel' : (item.id == provSelec.id)}">

                <div  style="overflow: hidden; text-overflow: ellipsis; height: 80px;">{{item.razon_social}}</div>

                <div layout="row" style="height: 40px;">
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="dop-item" style="background-color: #006837;">
                            85
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="dop-item" style="background-color: #00862c;">
                            85
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="dop-item" style="background-color: #00a421;">
                            85
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="dop-item" style="background-color: #00c316;">
                            85
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="dop-item" style="background-color: #00e10b;">
                            85
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="dop-item" style="background-color: #00ff00;">
                            85
                        </div>
                    </div>
                </div>
                <div style="height:40px;" layout="row" layout-align="start end">
                    <div flex="" style="overflow: hidden; text-overflow: ellipsis; margin-right: 1px;">{{item.deuda| number:2}}</div>
                    <div flex="">860</div>
                    <div flex="" layout="row" style="height: 19px;">
                        <div >{{item.contraPedido}}</div>
                        <img  style="float: left;" src="images/contra_pedido.png"/>
                    </div>


                </div>

            </div>

        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center" ng-click="closeLayer()" ng-show="index>0">
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
                    <div id="grid" ng-repeat="pedido in provSelec.pedidos" ng-click="DtPedido(pedido)">
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
                    <!--
                    <div layout="row" style="height: 25px;" >
                        <div  flex="15" class="md-block" style=" color: #999999;" >
                            Ordenes de Compra
                        </div>
                        <div ng-click="openOdcs()"> <?= HTML::image("images/agregar.png") ?></div>

                        <div flex=""   class="md-block" layout="row" style="overflow: hidden;"  ng-disabled="pedidoSelec.estado_id!=1">
                            <div style="margin-right: 4px; margin-left:4px;" ng-repeat="orden in pedidoSelec.ordenes" >
                                {{orden.nro_orden}}
                            </div>

                        </div>
                    </div>
                    -->

                    <div layout="row"  class=rowInput>
                        <md-input-container class="md-block" flex="15">
                            <label>Tipo de Pedido</label>
                            <md-select ng-model="pedidoSelec.tipo_pedido_id" ng-value="{{pedidoSelec.tipo_pedido_id}}"
                                       ng-disabled="(pedidoSelec.estado_id !=1 || formBlock)" required>
                                <md-option ng-repeat="tipo in formData.tipo" ng-value="{{tipo.id}}">
                                    {{tipo.tipo}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="15">
                            <label>N° de Pedido</label>
                            <input  ng-model="pedidoSelec.id" ng-disabled="true">
                        </md-input-container>

                        <div layout="row"  flex="25"  class="dateRow" >
                            <div class="dateRowTitle"> Fecha </div>
                            <md-datepicker ng-model="pedidoSelec.emision"
                                           md-placeholder="{{pedidoSelec.emision | date:'dd/MM/yyyy'}}"
                                           ng-disabled="true"></md-datepicker>
                        </div>

                        <md-input-container class="md-block" flex >
                            <label>Proveedor</label>
                            <md-select ng-model="provSelec.id" md-no-ink ng-disabled="(provSelec.save || formBlock)" required >
                                <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                    {{prov.razon_social}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>

                    <div layout="row"  class=rowInput>


                        <md-input-container class="md-block" flex="30">
                            <label>Pais</label>
                            <md-select ng-model="pedidoSelec.pais_id" name ="pais_id" md-no-ink
                                       ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                                <md-option ng-repeat="pais in formData.paises" value="{{pais.id}}">
                                    {{pais.short_name}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block"  flex>
                            <label>Direccion</label>
                            <md-select ng-model="pedidoSelec.direccion_almacen_id"
                                       md-no-ink ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                                <md-option ng-repeat="dir in formData.direcciones" value="{{dir.id}}">
                                    {{dir.direccion}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="15">
                            <label>Monto</label>
                            <input  ng-model="pedidoSelec.monto" ui-number-mask type="text"
                                    ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Moneda</label>
                            <md-select ng-model="pedidoSelec.prov_moneda_id" md-no-ink
                                       ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                                <md-option ng-repeat="moneda in formData.monedas" value="{{moneda.id}}" >
                                    {{moneda.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="10" ng-dblclick=" pedidoSelec.tasa_fija = 1 " >
                            <label>Tasa</label>
                            <input  ng-model="pedidoSelec.tasa"  ui-number-mask
                                    ng-readonly="pedidoSelec.tasa_fija == 0 " ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)"required>
                        </md-input-container>

                        <md-input-container class="md-block" flex="">
                            <label>Condicion de pago</label>
                            <md-select ng-model="pedidoSelec.condicion_pago_id" ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required md-no-ink required>
                                <md-option ng-repeat="conPago in formData.condicionPago" value="{{conPago.id}}">
                                    {{conPago.titulo}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="">
                            <label>Motivo Pedido </label>
                            <md-select ng-model="pedidoSelec.motivo_pedido_id" required md-no-ink
                                       ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                                <md-option ng-repeat="motivoPed in formData.motivoPedido" value="{{motivoPed.id}}">
                                    {{motivoPed.motivo}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Prioridad Pedido </label>
                            <md-select  ng-model="pedidoSelec.prioridad_id"  required md-no-ink
                                        ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                                <md-option ng-repeat="prioPed in formData.prioridadPedido" value="{{prioPed.id}}">
                                    {{prioPed.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Condiciones Pedido </label>
                            <md-select ng-model="pedidoSelec.condicion_pedido_id" md-no-ink
                                       ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                                <md-option ng-repeat="condPed in formData.condicionPedido" value="{{condPed.id}}">
                                    {{condPed.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="row" >
                        <md-input-container class="md-block" flex >
                            <label>Comentario</label>
                            <input ng-model="pedidoSelec.comentario"  ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)">
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="20">
                            <label>Mt3</label>
                            <input ng-model="pedidoSelec.mt3"  name="mt3"  ng-model="number" ui-number-mask
                                   ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required >
                        </md-input-container>

                        <md-input-container class="md-block" flex="20" required>
                            <label>Peso</label>
                            <input ng-model="pedidoSelec.peso" name="peso"  ng-model="number" ui-number-mask
                                   ng-disabled="(pedidoSelec.estado_id!=1 || formBlock)" required>
                        </md-input-container>
                    </div>

                </form>
                <!--
                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Aprobacion de Gerente
                    </div>
                </div>

                <div layout="row" >

                    <md-input-container class="md-block" flex="">
                        <label>Estatus</label>
                        <md-select ng-model="pedidoSelec.estado_id"  ng-disabled="formBlock">
                            <md-option ng-repeat="item in formData.estadoPedido" value="{{item.id}}">
                                {{item.estado}}
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

                        <md-datepicker  flex="25" name="fecha_aprob" ng-model="date"
                                        required md-min-date="minDate" md-max-date="maxDate"
                                        md-date-filter="onlyWeekendsPredicate" ng-disabled="(pedidoSelec.estado_id!=2 || formBlock)">
                        </md-datepicker>

                        <md-input-container class="md-block" flex="25">
                            <label>Tipo de pago</label>
                            <md-select ng-model="pedidoSelec.tipo" name ="tipo_pago" value="{{pedidoSelec.tipo}}" ng-disabled="(pedidoSelec.estado_id!=2 || formBlock)">
                                <md-option ng-repeat="tipo in formData.pedidos">
                                    {{tipo.id}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="30">
                            <label>N° Documento</label>
                            <input ng-model="pedidoSelec.nro_doc"  ng-disabled="(pedidoSelec.estado_id!=2 || formBlock)">

                        </md-input-container>

                    </div>
                    <div layout="row" flex="30" >
                        <div flex="">
                            Imagen Adjunto
                        </div>

                        <div flex="10" style="rgb(153, 153, 153)" ng-click="simulateClick('#imgAprob')">
                            <input type="file" id="imgAprob" style="display: none;" />
                            <?= HTML::image("images/adjunto.png",'null', array('id' => 'adjAprob', 'class' => 'image')) ?>
                        </div>
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
                            <input  ng-model="pedidoSelec.comentario_cancelacion"  ng-disabled="(pedidoSelec.estado_id!=3 || formBlock)">
                        </md-input-container>
                    </div>
                </form>
                -->
                <!--
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
                                                       md-date-filter="onlyWeekendsPredicate" ng-disabled="pedidoSelec.estado_id!=3">
                                        </md-datepicker>
                                        <div flex="20" style="height: 30px;margin-top: 9px;  color: #999999;" >
                                            Fecha limite de credito
                                        </div>
                                        <div flex="15"  style="height: 30px;margin-top: 9px;  color: #999999;">
                                            <md-switch  class="md-primary"
                                                        ng-model="dtaPrv.fijaT"
                                                        name="fijaT" aria-label="fijaT" ng-disabled="pedidoSelec.estado_id!=3">

                                            </md-switch>
                                        </div>

                                    </div>


                                </form>
                -->
            </md-content>
            <!-----flecha siguiente -->
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
                        <div flex="5" class="headGrid"> Cant.</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="20" class="headGrid"> Status</div>
                        <div flex class="headGrid"> Comentarios</div>
                    </div>
                    <div id="gridOdc">
                        <div flex>
                            <div layout="row" class="cellGridHolder"  ng-repeat="odc in formData.odc">
                                <div class="cellGrid" flex="5" ng-disabled="(pedidoSelec.estado_id !=1 || formBlock)">
                                    <md-switch class="md-primary" ng-model="odc.asig" ng-change="change(odc)" ></md-switch>
                                </div>
                                <div flex="10" class="cellGrid" ng-click="selecOdc(odc)"> {{odc.nro_orden}}</div>
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
                            <input  ng-model="odcSelec.id" ng-disabled="true">

                        </md-input-container>


                        <md-input-container class="md-block" flex="15">
                            <label>Fecha:</label>
                            <input md-maxlength="4"  md-no-asterisk name="fecha"
                                   ng-model="odcSelec.emision" ng-disabled="true" >
                        </md-input-container>

                        <md-input-container class="md-block" flex="40">
                            <label>Fabrica</label>
                            <md-select ng-model="provSelec.id"ng-disabled="true">
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
                            <input name="coment" ng-model="odcSelec.comentario"  ng-disabled="true" >
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


        <!-- 15) ########################################## LAYER (5) Agregar Pedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPed" id="agrPed">
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE ODC ########################################## -->
            <md-content  layout="row" style="'margin-top:0px;'" layout-padding flex>

                <!--<div class="titulo_formulario" layout="row" flex>-->
                <div layout="column" flex>
                    <div class="titulo_formulario md-block" layout-padding layout="row"  >
                        <div>
                            Contrapedidos
                        </div>
                        <div ng-click=" openLayer('agrContPed');">
                            <?= HTML::image("images/agregar.png",'null', array('class' => 'image') ) ?>
                        </div>
                    </div>

                    <div >
                        <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                            <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSelec.contraPedido">

                                <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.id}}</div>
                                <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.titulo}}</div>
                                <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="removeLisContraP(item)"> <?= HTML::image("images/eliminar.png",'null', array('class' => 'image') ) ?> </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div layout="column" flex>
                    <div class="titulo_formulario md-block" layout-padding  layout="row" >
                        <div>
                            Kitchen Boxs
                        </div>
                        <div ng-click="openLayer('agrKitBoxs')">
                            <?= HTML::image("images/agregar.png",'null', array('class' => 'image')) ?>
                        </div>
                    </div>

                    <div >
                        <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                            <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSelec.kitchenBox">

                                <div flex class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.id}}</div>
                                <div flex class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.titulo}}</div>
                                <div flex class="cellGrid"ng-click="selecKitchenBox(item)" > {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="removeLisKitchenBox(item)"> <?= HTML::image("images/eliminar.png",'null', array('class' => 'image') ) ?> </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div layout="column" flex>
                    <div class="titulo_formulario md-block" layout-padding  layout="row" >
                        <div>
                            Pedidos a Sustituir
                        </div>
                        <div ng-click="openLayer('agrPedPend')">
                            <?= HTML::image("images/agregar.png",'null', array('class' => 'image')) ?>
                        </div>
                    </div>

                    <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                        <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSelec.pedidoSusti">

                            <div flex class="cellGrid"> {{item.id}}</div>
                            <div flex class="cellGrid"> {{item.id}}</div>
                            <div flex class="cellGrid"> {{item.emision | date:'dd/MM/yyyy' }}</div>
                            <div flex class="cellGrid" ng-click="removeLisPedidoSus(item)"> <?= HTML::image("images/eliminar.png",'null', array('class' => 'image') ) ?> </div>
                        </div>
                    </div>
                </div>
                <!--</div>-->
            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (6) Agregar Contrapedidos ########################################## -->
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
                        <div flex="10" class="headGrid"> Fecha Aprox</div>
                        <div flex="15" class="headGrid"> Monto</div>
                        <div flex class="headGrid"> Comentario</div>


                    </div>
                    <div id="gridContPed">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="item in formData.contraPedido">
                                <div class="cellGrid" flex="5">
                                    <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeContraP(item)" ng-disabled="(pedidoSelec.estado_id !=1 || formBlock)"></md-switch>
                                </div>
                                <div flex="5" class="cellGrid" ng-click="selecContraP(item)"> {{item.id}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.titulo}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha_aprox_entrega | date:'dd/MM/yyyy' }}</div>
                                <div flex="15" class="cellGrid" ng-click="selecContraP(item)"> {{item.monto}}</div>
                                <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.comentario}}</div>

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
                            <div layout="row" class="cellGridHolder" ng-repeat="item in formData.kitchenBox">
                                <div class="cellGrid" flex="5">
                                    <md-switch class="md-primary" ng-model="item.asig" ng-change="changeKitchenBox(item)" ng-disabled="(pedidoSelec.estado_id !=1 || formBlock)"></md-switch>
                                </div>
                                <div flex="5" class="cellGrid"  ng-click="selecKitchenBox(item)"> {{item.id}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.fecha | date:'dd/MM/yyyy'}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.num_proforma}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.img_proforma}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.monto}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.precio}}</div>
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
                        <div flex="5" class="headGrid">-</div>
                        <div flex="10" class="headGrid"> Pedido</div>
                        <div flex="10" class="headGrid"> Proforma</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="15" class="headGrid"> Nº de Factura</div>
                        <div flex="10" class="headGrid"> Monto</div>
                        <div flex class="headGrid"> Comentario</div>

                    </div>
                    <div id="gridPedPend">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="item in formData.pedidoSust" >
                                <div flex="5" class="cellGrid">
                                    <md-switch class="md-primary" ng-model="item.asig"
                                               ng-change="changePedidoSustituto(item)"
                                               ng-disabled="(pedidoSelec.estado_id !=1 || formBlock)"></md-switch>
                                </div>
                                <div flex="10" class="cellGrid"> {{item.id}}</div>
                                <div flex="10" class="cellGrid">{{item.nro_proforma}}</div>
                                <div flex="10" class="cellGrid">{{item.emision | date:'dd/MM/yyyy'}}</div>
                                <div flex="10" class="cellGrid">{{item.nro_factura}}</div>
                                <div flex="15" class="cellGrid"> {{item.monto}}</div>
                                <div flex class="cellGrid">{{item.comentario}}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN CONTRA PEDIDO ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenContraPedido" id="resumenContraPedido" >
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE CONTRA PEDIDO ########################################## -->


            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Resumen de Contra Pedido
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="10">
                            <label>Nº</label>
                            <input  ng-model="contraPedSelec.id" ng-disabled="true">

                        </md-input-container>


                        <md-input-container class="md-block" flex="15">
                            <label>Fecha:</label>
                            <input ng-model="contraPedSelec.fecha" ng-disabled="true" >
                        </md-input-container>

                        <md-input-container class="md-block" flex="40">
                            <label>Fabrica</label>
                            <md-select ng-model="provSelec.id"ng-disabled="true">
                                <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                    {{prov.razon_social}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Status:</label>
                            <md-select ng-model="contraPedSelec.aprobada" name ="status" ng-disabled="true">
                                <md-option value="1">
                                    Aprobada
                                </md-option>
                                <md-option value="0">
                                    No Aprobada
                                </md-option>
                            </md-select>

                        </md-input-container>
                    </div>

                    <div layout="row" flex>

                        <md-input-container class="md-block" flex="20">
                            <label>Motivo:</label>
                            <md-select ng-model="contraPedSelec.motivo_contrapedido_id" ng-disabled="true">
                                <md-option ng-repeat="item in formDataContraP.contraPedidoMotivo" value="{{item.id}}">
                                    {{item.motivo}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Tipo Envio:</label>
                            <md-select ng-model="contraPedSelec.tipo_envio_id" ng-disabled="true">
                                <md-option ng-repeat="item in filterData.tipoEnv" value="{{item.id}}">
                                    {{item.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block"flex="20" >
                            <label>Prioridad:</label>
                            <md-select ng-model="contraPedSelec.prioridad_id" ng-disabled="true">
                                <md-option ng-repeat="item in formDataContraP.contraPedidoPrioridad" value="{{item.id}}">
                                    {{item.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                    </div>

                    <div layout="row">
                        <md-input-container class="md-block" flex>
                            <label>Titulo:</label>
                            <input ng-model="contraPedSelec.titulo" ng-disabled="true" >
                        </md-input-container>

                        <div layout="row"  flex  style="height: 30px; margin-top: 6px;">
                            <div style="margin-right: 8px;" > Entrega Aproximada: </div>
                            <div >{{contraPedSelec.fecha_aprox_entrega | date:'dd/MM/yyyy' }}</div>
                        </div>
                    </div>


                    <div layout="row">
                        <md-input-container class="md-block" flex="20">
                            <label>Monto:</label>
                            <input ng-model="contraPedSelec.monto" ng-disabled="true" >
                        </md-input-container>

                        <md-input-container class="md-block" flex="20" >
                            <label>Moneda</label>
                            <md-select ng-model="contraPedSelec.moneda_id" ng-disabled="true">
                                <md-option ng-repeat="item in filterData.monedas" value="{{item.id}}">
                                    {{item.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>

                    <div layout="row">
                        <md-input-container class="md-block" flex>
                            <label>Comentario:</label>
                            <input name="coment" ng-model="contraPedSelec.comentario"  ng-disabled="true" >
                        </md-input-container>
                    </div>

                <form name="FormResumenContra" >

                <div class="titulo_formulario"  style='margin-top: 20px;' layout="column" layout-align="start start">
                        <div>
                            Productos a Solicitar
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">

                        <div flex="5" class="cellGrid">

                        </div>
                        <div flex="15" class="headGrid"> Cod. Producto</div>
                        <div flex class="headGrid"> Cod. Profit</div>
                        <div flex class="headGrid"> Descripción.</div>
                        <div flex="10" class="headGrid"> Cantidad</div>
                        <div flex class="headGrid"> Comentario</div>
                        <div flex class="headGrid"> Adjunto</div>
                    </div>
                    <div id="gridResOdc">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="item in contraPedSelec.productos">
                                <div flex="5" class="cellGrid">
                                    <md-switch class="md-primary"
                                               ng-model="item.asignado"
                                               ng-change="changeContraPItem(item)"
                                               ng-disabled="(pedidoSelec.estado_id !=1 || formBlock)"></md-switch>
                                </div>
                                <div flex="15" class="cellGrid">  {{item.id}}</div>
                                <div flex class="cellGrid"> {{item.cod_profit}}</div>
                                <div flex class="cellGrid">  {{item.descripcion}}</div>
                                <md-input-container class="md-block" flex="10" >
                                    <input  ng-model="item.monto"
                                            ng-change="changeContraPItem(item)"
                                            ui-number-mask type="text"
                                            max="{{item.disponible}}"
                                            ng-disabled="(pedidoSelec.estado_id !=1 || formBlock || !item.asignado )"
                                    />
                                </md-input-container>
                                <div flex class="cellGrid">  {{item.comentario}}</div>
                                <div flex class="cellGrid">  {{item.adjunto}}</div>
                            </div>
                        </div>
                    </div>

                </form>

            </md-content>




        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN KICTCHEN BOX ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenKitchenbox" id="resumenKitchenbox" >
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE  KICTCHEN BOX  ########################################## -->


            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <form name="resumenContraPed" >
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Resumen de Kitchen Box
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="10">
                            <label>Nº</label>
                            <input  ng-model="kitchenBoxSelec.id" ng-disabled="true">
                        </md-input-container>

                        <div layout="row"  flex="30"  class="dateRow" >
                            <div class="dateRowTitle"> Fecha </div>
                            <md-datepicker ng-model="kitchenBoxSelec.fecha" md-placeholder="{{kitchenBoxSelec.fecha | date:'dd/MM/yyyy'}}"  ng-disabled="true"></md-datepicker>
                        </div>

                        <md-input-container class="md-block" flex="40">
                            <label>Fabrica</label>
                            <md-select ng-model="kitchenBoxSelec.prov_id"ng-disabled="true">
                                <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                    {{prov.razon_social}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>
                    <div layout="row">
                        <md-input-container class="md-block" flex>
                            <label>Titulo:</label>
                            <input ng-model="kitchenBoxSelec.titulo" ng-disabled="true" >
                        </md-input-container>

                        <div layout="row"  flex="40"  class="dateRow">
                            <div style=""  class="dateRowTitle"> Entrega Aproximada: </div>
                            <md-datepicker ng-model="kitchenBoxSelec.fecha_aprox_entrega" md-placeholder="{{kitchenBoxSelec.fecha_aprox_entrega | date:'dd/MM/yyyy'}}"  ng-disabled="true"></md-datepicker>
                        </div>

                        <md-input-container class="md-block"flex="20" >
                            <label>Prioridad:</label>
                            <md-select ng-model="kitchenBoxSelec.prioridad_id" ng-disabled="true">
                                <md-option ng-repeat="item in formDataContraP.contraPedidoPrioridad" value="{{item.id}}">
                                    {{item.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                    </div>

                    <div layout="row">
                        <md-input-container class="md-block" flex="15">
                            <label>Abono </label>
                            <input  ng-model="kitchenBoxSelec.monto_abono" ui-number-mask type="text"
                                    ng-disabled="true" required>
                        </md-input-container>

                        <div layout="row"  flex="30"  class="dateRow">
                            <div style=""  class="dateRowTitle"> Fecha Abono </div>
                            <md-datepicker ng-model="kitchenBoxSelec.fecha_abono" md-placeholder="{{kitchenBoxSelec.fecha_aprox_entrega | date:'dd/MM/yyyy'}}"  ng-disabled="true"></md-datepicker>
                        </div>
                        <div flex="">
                            <!-- imga maqueta -->
                            <?= HTML::image("images/adjunto.png",'null', array('id' => 'imgAdj')) ?>

                        </div>

                        <md-input-container class="md-block" flex="40">
                            <label>Condciones de pago</label>
                            <md-select ng-model="provSelec.id"ng-disabled="true">
                                <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                    {{prov.razon_social}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>

                    <div layout="row">
                        <md-input-container class="md-block" flex>
                            <label>Comentario:</label>
                            <input name="coment" ng-model="kitchenBoxSelec.comentario"  ng-disabled="true" >
                        </md-input-container>
                    </div>

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Adjuntos
                        </div>
                    </div>

                </form>

            </md-content>

        </md-sidenav>


        <!------------------------------------------- Flecha de siguiente------------------------------------------------------------------------->
        <md-sidenav ng-show="pedidoSelec.id > 0";
                    style="margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');"
                    layout="column" layout-align="center center" class="md-sidenav-right"
                    md-disable-backdrop="true" md-component-id="NEXT" id="NEXT"
                    ng-mouseleave="showNext(false)" ng-click="next()">
            <?= HTML::image("images/btn_nextArrow.png") ?>
        </md-sidenav>
    </div>
</div>

