<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="pagosCtrll">

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
            <div layout="column" layout-align="center center">
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center">
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center">
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>


    </div>

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>
        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral">
            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex ng-click="openLayer('lyr1pag')">
                <div flex>Nombre del proveedor</div>
                <div layout="row" style="height: 24px;">
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
                        <div layout layout-align="center center" class="cantFactDeb" style="background-color: #00CCA2;">
                            85
                        </div>
                    </div>
                </div>
                <div style="height: 32px; text-align: right;">
                    999.999.999
                </div>
                <div style="height: 32px; text-align: right;">
                    ND/C. 999.999.999
                </div>
                <div style="height: 32px; text-align: right;">
                    RBY. 999.999.999
                </div>
            </div>
        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <?= HTML::image("images/btn_prevArrow.png","",array("ng-click"=>"closeLayer()","ng-show"=>"(index>0)")) ?>
        </div>

        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                PG
            </div>
            <br>
            Selecciones un Proveedor
        </div>


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr1pag" id="lyr1pag">

            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>

                <md-tabs md-dynamic-height md-border-bottom md-no-ink>
                    <md-tab label="Deudas" md-no-ink>
                        <md-content style="padding-top: 10px;">
                            <form>

                                <div class="titulo_formulario" layout="Column" layout-align="start start">
                                    <div>
                                        Pagos Pendientes a: <spam style="color: #000;">NOMBRE DEL PROVEEDOR</spam>
                                    </div>
                                </div>
                                <div layout="row" class="headGridHolder">
                                    <div flex="10" class="headGrid"> N° Factura</div>
                                    <div flex="10" class="headGrid"> Emitido</div>
                                    <div flex="10" class="headGrid"> Vence</div>
                                    <div flex="5" class="headGrid"> </div>
                                    <div flex class="headGrid"> Cuotas</div>
                                    <div flex class="headGrid"> Total Deuda</div>
                                    <div flex class="headGrid"> Pagado</div>
                                    <div flex class="headGrid"> Saldo</div>
                                </div>
                                <div id="grid">
                                    <div flex>
                                        <div layout="row" class="cellGridHolder" ng-click="openLayer('lyr2pag')">
                                            <div flex="10" class="cellGrid"> TET56276-2015</div>
                                            <div flex="10" class="cellGrid"> 26/02/2016</div>
                                            <div flex="10" class="cellGrid"> 26/05/2016 </div>
                                            <div flex="5" class="cellGrid" style="text-align: right;"> <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #ff6f4c;"></div></div>
                                            <div flex class="cellGrid"> 4 </div>
                                            <div flex class="cellGrid"> 4.212$ </div>
                                            <div flex class="cellGrid"> 2.230$ </div>
                                            <div flex class="cellGrid"> 1.982$ </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </md-content>
                    </md-tab>
                    <md-tab label="Pagos">
                        <md-content  style="padding-top: 10px;">
                            <form>

                                <div class="titulo_formulario" layout="Column" layout-align="start start">
                                    <div>
                                        Pagos Realizados
                                    </div>
                                </div>
                                <div layout="row" class="headGridHolder">
                                    <div flex="20" class="headGrid"> N° Factura</div>
                                    <div flex="10" class="headGrid"> Emitido</div>
                                    <div flex class="headGrid"> Tipo</div>
                                    <div flex class="headGrid"> Pagado</div>
                                    <div flex class="headGrid"> Resta</div>
                                    <div flex class="headGrid"> 000000</div>
                                </div>
                                <div id="grid">
                                    <div flex>
                                        <div layout="row" class="cellGridHolder" ng-click="openLayer('lyr3pag')">
                                            <div flex="20" class="cellGrid"> TET56276-2015</div>
                                            <div flex="10" class="cellGrid"> 26/02/2016</div>
                                            <div flex class="cellGrid"> Data 3</div>
                                            <div flex class="cellGrid"> Data 4</div>
                                            <div flex class="cellGrid"> Data 5</div>
                                            <div flex class="cellGrid"> Data 6</div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </md-content>
                    </md-tab>
                </md-tabs>






                </md-content>

            <div style="width: 16px;" >

            </div>
        </md-sidenav>

        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr2pag" id="lyr2pag">
            <!-- ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" flex >

                <div class="titulo_formulario" layout="Column" layout-align="start start" >
                    <div>
                        Listado de cuotas: <spam style="color: #000;">Factura Nro. NUMERO DE FACTURA, Proveedor: NOMBRE DEL PROVEEDOR</spam>
                    </div>
                </div>

                <div layout="row" class="headGridHolder">
                    <div flex="10" class="headGrid"> N° Cuota</div>
                    <div flex="10" class="headGrid"> Vencimiento</div>
                    <div flex class="headGrid"> Descripcion</div>
                    <div flex class="headGrid"> Condicion Cuota</div>
                    <div flex="10" class="headGrid"> Estatus</div>
                </div>
                <div id="grid" flex style="overflow-y: auto;">
                    <div flex>
                        <div layout="row" class="cellGridHolder" ng-click="openLayer('lyr3pag')">
                            <div flex="10" class="cellGrid"> 1</div>
                            <div flex="10" class="cellGrid"> 26/02/2016</div>
                            <div flex class="cellGrid"> Esta es una cuota de prueba</div>
                            <div flex class="cellGrid"> 10% Contra BL</div>
                            <div flex="10" class="cellGrid"> <div style="width: 16px; height: 16px; border-radius: 50%; background-color: #ff6f4c;"></div></div>
                        </div>
                    </div>
                </div>




            </md-content>

            <div style="width: 16px;" >

            </div>
        </md-sidenav>


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr3pag" id="lyr3pag">
            <!-- ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" flex >
                <form>
                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Pago cuota: <span style="color: #000;">Nro. NUMERO DE LA CUOTA, Factura Nro. NUMERO DE FACTURA, Proveedor: NOMBRE DEL PROVEEDOR</span>
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="20">
                            <label>Nro. Documento</label>
                            <input required/>
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Fecha</label>
                            <input required/>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Monto</label>
                            <input />

                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Moneda</label>
                            <md-select ng-model="monedaSel" required md-no-ink>
                                <md-option ng-repeat="moneda in monedas" value="{{moneda.id}}">
                                    {{moneda.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Tasa</label>
                            <input />

                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Tipo Pago</label>
                            <md-select ng-model="tipoPagoSel" required md-no-ink>
                                <md-option ng-repeat="tipoPago in tipoPagos" value="{{tipoPago.id}}">
                                    {{tipoPago.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-button style="height: 20px;" md-no-ink flex="10">Adjuntar</md-button>

                    </div>

                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>
                            Adelantos y Notas de credito
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div flex="10" class="cellGrid"> Accion</div>
                        <div flex="10" class="headGrid"> N° Documento</div>
                        <div flex="10" class="headGrid"> Tipo</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex class="headGrid"> Factura</div>
                        <div flex="10" class="headGrid"> Monto</div>
                        <div flex="10" class="headGrid"> Saldo</div>
                    </div>
                    <div id="grid" flex style="overflow-y: auto;">
                        <div flex>
                            <div layout="row" class="cellGridHolder">
                                <div flex="10" class="cellGrid">
                                    <md-switch class="md-primary"  ng-disabled="enabled">
                                    </md-switch>
                                </div>
                                <div flex="10" class="cellGrid"> 17622</div>
                                <div flex="10" class="cellGrid"> ND/C</div>
                                <div flex="10" class="cellGrid"> 21/11/2015</div>
                                <div flex class="cellGrid"> 33637IUD</div>
                                <div flex="10" class="cellGrid"> 2000$</div>
                                <div flex="10" class="cellGrid"> 1000$</div>
                            </div>
                            <div layout="row" class="cellGridHolder">
                                <div flex="10" class="cellGrid">
                                    <md-switch class="md-primary"  ng-disabled="enabled">
                                    </md-switch>
                                </div>
                                <div flex="10" class="cellGrid"> 17622</div>
                                <div flex="10" class="cellGrid"> ND/C</div>
                                <div flex="10" class="cellGrid"> 21/11/2015</div>
                                <div flex class="cellGrid"> 33637IUD</div>
                                <div flex="10" class="cellGrid"> 2000$</div>
                                <div flex="10" class="cellGrid"> 1000$</div>
                            </div>
                        </div>
                    </div>

                    <div class="titulo_formulario" layout="column" layout-align="start start" flex >
                        <div>

                        </div>
                    </div>

                    <div layout="row">
                        <div flex="50">

                            </div>
                        <md-input-container class="md-block" flex>
                            <label>Saldo</label>
                            <input required/>
                        </md-input-container>
                        <div flex="5">

                        </div>
                        <md-input-container class="md-block" flex>
                            <label>Total A Pagar</label>
                            <input required/>
                        </md-input-container>

                    </div>

                    </form>
                </md-content>

                <div style="width: 16px;" ng-mouseover="showNext(true,'END')" >

                </div>
            </md-sidenav>





        <md-sidenav style="margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');" layout="column" layout-align="center center" class="md-sidenav-right" md-disable-backdrop="true" md-component-id="NEXT" ng-mouseleave="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png","",array('ng-click'=>"openLayer()")) ?>
        </md-sidenav>

    </div>


</div>