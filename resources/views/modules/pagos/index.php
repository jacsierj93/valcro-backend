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
            <div ng-show="provData.id!=''" layout="column" layout-align="center center" ng-click="setFormAdelanto()">
                <span class="icon-Agregar" style="font-size: 24px"></span>
            </div>
            <div ng-show="false" layout="column" layout-align="center center">
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div ng-show="false" layout="column" layout-align="center center">
                <?= HTML::image("images/filtro.png") ?>
            </div>
            <div ng-show="true" layout="column" layout-align="center center" ng-click="getAbonos()"
                 style="width: 144px;">
                Documentos de Pago
            </div>

        </div>


    </div>

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>
        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral" data-ng-init="getProvs()">
            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div data-ng-repeat="prov in provs" class="boxList" layout="column" flex ng-click="setProv(prov)"
                 ng-class="{'listSel' : (prov.id ==provData.id)}">
                <div style="overflow: hidden; text-overflow: ellipsis" flex>{{prov.razon_social}}</div>
                <div layout="row" style="height: 24px;">
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="cantFactDeb v0">
                            {{prov.vencido}}
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="cantFactDeb v7">
                            {{prov.vence7}}
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="cantFactDeb v30">
                            {{prov.vence30}}
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="cantFactDeb v60">
                            {{prov.vence60}}
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="cantFactDeb v90">
                            {{prov.vence90}}
                        </div>
                    </div>
                    <div flex layout layout-align="center center">
                        <div layout layout-align="center center" class="cantFactDeb v90">
                            {{prov.vence100}}
                        </div>
                    </div>

                </div>
                <div style="height: 32px; text-align: right;">
                    Deudas {{prov.tdeuda | currency : $ : 2}}
                </div>
                <div style="height: 32px; text-align: right;">
                    Abonos {{prov.tabono | currency : $ : 2}}
                </div>

            </div>
        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <?= HTML::image("images/btn_prevArrow.png", "", array("ng-click" => "closeLayer()", "ng-show" => "(index>0)")) ?>
        </div>

        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div
                style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                PG
            </div>
            <br>
            Selecciones un Proveedor
        </div>


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr1pag"
                    id="lyr1pag">

            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>

                <md-tabs md-dynamic-height md-border-bottom md-no-ink>
                    <md-tab label="Deudas" md-no-ink>
                        <md-content style="padding-top: 10px;">
                            <form>

                                <div class="titulo_formulario" layout="Column" layout-align="start start">
                                    <div>
                                        Pagos Pendientes a:
                                        <spam style="color: #000;">{{provData.nombre}}</spam>
                                    </div>
                                </div>
                                <div layout="row" class="headGridHolder">
                                    <div flex="10" class="headGrid"> N° Factura</div>
                                    <div flex="10" class="headGrid"> Emitido</div>
                                    <div flex="10" class="headGrid"> Vence</div>
                                    <div flex="5" class="headGrid"></div>
                                    <div flex class="headGrid"> Cuotas</div>
                                    <div flex class="headGrid"> Total Deuda</div>
                                    <div flex class="headGrid"> Pagado</div>
                                    <div flex class="headGrid"> Saldo</div>
                                </div>
                                <div id="grid">
                                    <div ng-repeat="deuda in provData.deudas" flex>
                                        <div layout="row" class="cellGridHolder" ng-click="setDeduda(deuda)">
                                            <div flex="10" class="cellGrid"> {{deuda.nro_factura}}</div>
                                            <div flex="10" class="cellGrid">{{deuda.fecha}}</div>
                                            <div flex="10" class="cellGrid">{{deuda.vence}}</div>
                                            <div flex="5" class="cellGrid" style="text-align: right;">
                                                <div style="width: 16px; height: 16px; border-radius: 50%"
                                                     class="{{deuda.vencido}}"></div>
                                            </div>
                                            <div flex class="cellGrid"> {{deuda.cuotas}}</div>
                                            <div flex class="cellGrid"> {{deuda.monto | currency : $ : 2}}$</div>
                                            <div flex class="cellGrid"> {{deuda.pagado | currency : $ : 2}}$</div>
                                            <div flex class="cellGrid"> {{deuda.saldo | currency : $ : 2}}$</div>
                                        </div>
                                    </div>

                                </div>

                            </form>

                        </md-content>
                    </md-tab>
                    <md-tab label="Pagos">
                        <md-content style="padding-top: 10px;">

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
                                <div ng-repeat="pago in provData.pagos" flex>
                                    <div layout="row" class="cellGridHolder" ng-click="setPago(pago)">
                                        <div flex="20" class="cellGrid">{{pago.nro_factura}}</div>
                                        <div flex="10" class="cellGrid">{{pago.fecha}}</div>
                                        <div flex class="cellGrid">{{pago.tipo}}</div>
                                        <div flex class="cellGrid">{{pago.pagado | currency : $ : 2}}</div>
                                        <div flex class="cellGrid"> Data 5</div>
                                        <div flex class="cellGrid"> Data 6</div>
                                    </div>
                                </div>

                            </div>

                        </md-content>
                    </md-tab>
                </md-tabs>


            </md-content>

            <div style="width: 16px;">

            </div>
        </md-sidenav>


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr2pag"
                    id="lyr2pag">
            <!-- ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" flex>

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Listado de cuotas:
                        <spam style="color: #000;">Factura Nro. {{debData.factura}}, Proveedor: {{debData.provname}}
                        </spam>
                    </div>
                </div>

                <div layout="row" class="headGridHolder">
                    <div ng-show="debData.factura_tipo=='cc'" flex="10" class="headGrid"> N° Cuota</div>
                    <div flex="10" class="headGrid"> Vencimiento</div>
                    <div flex class="headGrid"> Descripcion</div>
                    <div flex class="headGrid"> Condicion Cuota</div>
                    <div flex="10" class="headGrid"> Estatus</div>
                    <div flex="10" class="headGrid"> Saldo</div>
                </div>
                <div id="grid" flex style="overflow-y: auto;">
                    <div ng-repeat="cuota in debData.cuotas" flex>
                        <div layout="row" class="cellGridHolder" ng-click="setPagoCuota(debData,cuota,$index)">
                            <div ng-show="debData.factura_tipo=='cc'" flex="10" class="cellGrid">{{$index+1}}</div>
                            <div flex="10" class="cellGrid">{{cuota.fecha_vence}}</div>
                            <div flex class="cellGrid">{{cuota.nro_factura}}</div>
                            <div flex class="cellGrid">{{cuota.descripcion}}</div>
                            <div flex="10" class="cellGrid">
                                <div style="width: 16px; height: 16px; border-radius: 50%"
                                     class="{{cuota.vencimiento}}"></div>
                            </div>
                            <div flex="10" class="cellGrid">{{cuota.saldo | currency : $ : 2}}</div>
                        </div>
                    </div>
                </div>


            </md-content>

            <div style="width: 16px;">

            </div>
        </md-sidenav>


        <!--        FORM: FPAGO1-->

        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr3pag"
                    id="lyr3pag">
            <!-- ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->


            <md-content class="cntLayerHolder" layout="column" flex>

                <form name="formPago" ng-submit="saveFormPago()">

                    <div class="titulo_formulario" layout="column" layout-align="start start" flex>
                        <div>
                            Pago: <span style="color: #000;"><span ng-show="debData.factura_tipo=='cc'">CUOTA Nro. {{debData.actual+1}}, </span>
                                Factura Nro. {{debData.factura}}, Proveedor: {{debData.provname}}</span>
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="15">
                            <label>Nro. Documento</label>
                            <input ng-model="pago.nro_doc" required/>
                        </md-input-container>


                        <div layout="column" flex>
                            <md-datepicker ng-model="pago.fecha" required md-placeholder="fecha"></md-datepicker>
                        </div>

                        <md-input-container class="md-block" flex="15">
                            <label>Monto</label>
                            <input ng-change="calculateDeuda2(abonos2,pago)" ng-model="pago.monto" required/>
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Moneda</label>
                            <md-select ng-model="pago.moneda_id" ng-change="getTasaByCoinId(pago.moneda_id,'pago')"
                                       required md-no-ink>
                                <md-option ng-repeat="moneda in monedas" value="{{moneda.id}}">
                                    {{moneda.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Tasa</label>
                            <input ng-model="pago.tasa" ng-readonly="true" required/>

                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Tipo Pago</label>
                            <md-select ng-model="pago.tipo_id" required md-no-ink>
                                <md-option ng-repeat="tipoPago in tipoPagos" value="{{tipoPago.id}}">
                                    {{tipoPago.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-button style="height: 20px;" md-no-ink flex="10">Adjuntar</md-button>

                    </div>

                    <div class="titulo_formulario" layout="column" layout-align="start start" flex>
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
                        <div flex="10" class="headGrid"> Utilizar</div>
                    </div>
                    <div id="grid" flex style="overflow-y: auto;">
                        <div flex ng-repeat="abono in abonos2">
                            <div layout="row" class="cellGridHolder">
                                <div flex="10" class="cellGrid">
                                    <md-switch class="md-primary"
                                               ng-model="abono.asignado"
                                               ng-change="calculateDeuda2(abonos2,pago)"
                                               ng-disabled="enabled">
                                    </md-switch>
                                </div>
                                <div flex="10" class="cellGrid"> {{abono.nro_factura}}</div>
                                <div flex="10" class="cellGrid"> {{abono.tipo}}</div>
                                <div flex="10" class="cellGrid"> {{abono.fecha}}</div>
                                <div flex class="cellGrid"> {{abono.fact_orig}}</div>
                                <div flex="10" class="cellGrid"> {{abono.monto}}</div>
                                <div flex="10" class="cellGrid"> {{abono.saldo}}</div>
                                <div flex="10" class="cellGrid">
                                    <input type="number" ng-model="abono.montoUsado" ng-change="calculateDeuda2(abonos2,pago)" ng-disabled="!abono.asignado" ng-value="abono.saldo" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="titulo_formulario" layout="column" layout-align="start start" flex>
                        <div>

                        </div>
                    </div>

                    <div layout="row">
                        <div flex="50">

                        </div>
                        <md-input-container class="md-block" flex>
                            <label>Saldo</label>
                            <input ng-readonly="true" ng-model="debData.saldo"/>
                        </md-input-container>
                        <div flex="5">

                        </div>
                        <md-input-container class="md-block" flex>
                            <label>Total A Pagar</label>
                            <input ng-readonly="true" ng-model="debData.total"/>
                        </md-input-container>

                    </div>

                </form>

            </md-content>

            <div style="width: 16px;" ng-mouseover="showNext(true,'END')">


            </div>
        </md-sidenav>


        <!--        listado de documentos a favor, (pagos que no han sido consumidos)-->


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr4pag"
                    id="lyr4pag">
            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>
                <div class="titulo_formulario" layout="column" layout-align="start start">
                    <div>
                        Listado de documentos a favor
                    </div>
                </div>

                <div layout="row" class="headGridHolder">
                    <div flex="10" class="headGrid" contenteditable> N° Docu.</div>
                    <div flex="10" class="headGrid" contenteditable> Tipo</div>
                    <div flex class="headGrid" contenteditable> Origen</div>
                    <div flex="10" class="headGrid"> Fecha</div>
                    <div flex="10" class="headGrid"> Monto</div>
                    <div flex="5" class="headGrid" contenteditable> Mnd.</div>
                    <div flex="5" class="headGrid"> Tasa</div>
                    <div flex="10" class="headGrid"> Saldo</div>
                </div>

                <div id="grid" flex style="overflow-y: auto;">
                    <div flex>
                        <div layout="row" class="cellGridHolder" ng-repeat="pay in abonos">
                            <div flex="10" class="cellGrid"> {{pay.nro_factura}}</div>
                            <div flex="10" class="cellGrid"> {{pay.tipo}}</div>
                            <div flex class="cellGrid"> {{pay.origen}}</div>
                            <div flex="10" class="cellGrid"> {{pay.fecha}}</div>
                            <div flex="10" class="cellGrid"> {{pay.monto | currency : $ : 2 }}</div>
                            <div flex="5" class="cellGrid"> {{pay.moneda}}</div>
                            <div flex="5" class="cellGrid">{{pay.tasa}}</div>
                            <div flex="10" class="cellGrid"> {{pay.saldo | currency : $ : 2 }}</div>
                        </div>
                    </div>
                </div>


            </md-content>

            <div style="width: 16px;">

            </div>
        </md-sidenav>


        <!--        FORM: FABONO-->


        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr5pag"
                    id="lyr5pag" ng-scope>
            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>


                <form name="formAbono" ng-submit="saveFormAbono()">

                    <div class="titulo_formulario" layout="column" layout-align="start start">
                        <div>
                            Carga de Pagos
                        </div>
                    </div>


                    <div layout="row">


                        <md-input-container class="md-block" flex="20">
                            <label>Tipo Pago</label>
                            <md-select ng-model="abono.tipo_id" required md-no-ink>
                                <md-option ng-repeat="tipoPago in tipoDocsPago" value="{{tipoPago.id}}">
                                    {{tipoPago.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                        <!--espacio-->
                        <span style="padding-right: 300px">&nbsp; </span>
                        <!--espacio-->


<!--                        <div>Id del pago: #100</div>-->

                        <!--espacio-->
                        <span style="padding-right: 100px">&nbsp; </span>
                        <!--espacio-->
                     <!--   <div>Fecha: <?/*= date("d-m-Y") */?></div>-->

                    </div>


                    <div layout="row">


                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->
                        <!-- Este campo debe cargar las cuentas acrgadas desde el provedor y asignarle una al pago en cuestion --->
                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->

                        <md-input-container ng-hide="abono.tipo_id!=1" class="md-block" flex>
                            <label>Cuenta destino provedor</label>
                            <md-select ng-model="abono.cuenta_id" md-no-ink>
                                <md-option ng-repeat="cuenta in cuentasBancarias" value="{{cuenta.id}}">
                                    {{cuenta.banco}} , {{cuenta.cuenta}} , {{cuenta.beneficiario}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->


                        <md-input-container ng-hide="abono.tipo_id==1" class="md-block" flex>
                            <label>Nro. Documento Origen</label>
                            <input ng-model="abono.org_factura"/>
                        </md-input-container>


                        <md-input-container class="md-block" flex>
                            <label>Nro. Documento</label>
                            <input ng-model="abono.nro_doc" required/>
                        </md-input-container>

                        <div layout="column" flex>
                            <md-datepicker ng-model="abono.fecha" required md-placeholder="fecha"></md-datepicker>
                        </div>

                        <md-input-container ng-show="abono.tipo_id==2" class="md-block" flex>
                            <label>Nro. Reclamo</label>
                            <input ng-model="abono.nro_rec"/>
                        </md-input-container>


                    </div>


                    <div layout="row">

                        <md-input-container ng-hide="abono.tipo_id!=1" class="md-block" flex>
                            <label>Metodo de Pago</label>
                            <md-select ng-model="abono.pago_id" md-no-ink>
                                <md-option ng-repeat="metodoPago in tipoPagos" value="{{metodoPago.id}}">
                                    {{metodoPago.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container ng-hide="abono.tipo_id!=1" class="md-block" flex="15">
                            <label>Referencia</label>
                            <input ng-model="abono.ref_pago" type="number"/>
                        </md-input-container>


                        <md-input-container class="md-block" flex="15">
                            <label>Monto</label>
                            <input ng-change="getRecargoPercent('m')" ng-model="abono.monto" required/>

                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Moneda</label>
                            <md-select ng-model="abono.moneda_id" required
                                       ng-change="getTasaByCoinId(abono.moneda_id,'abono')" md-no-ink>
                                <md-option ng-repeat="moneda in monedas" ng-value="{{moneda.id}}">
                                    {{moneda.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                        <md-input-container class="md-block" flex="10">
                            <label>Tasa</label>
                            <input ng-model="abono.tasa" ng-readonly="true" required/>

                        </md-input-container>


                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->
                        <!-- ################################### Estos dos campos son calculados del monto ingresado ################################ -->
                        <!-- ################################################################################################ -->
                        <!-- Estos varian dependiendo del procentaje o el monto solocados en uno de los 3 campos (Monto, Monto recargo y porcentaje recargo) -->

                        <md-input-container ng-hide="abono.tipo_id!=1" class="md-block" flex="15">
                            <label>Monto Recargo</label>
                            <input ng-change="getRecargoPercent('r')" ng-model="abono.monto_rec"/>
                        </md-input-container>

                        <md-input-container ng-hide="abono.tipo_id!=1" class="md-block" flex="15">
                            <label>% Recargo</label>
                            <input ng-change="getRecargoPercent('p')" ng-model="abono.monto_recp"/>
                        </md-input-container>


                        <md-input-container ng-show="abono.tipo_id>1" class="md-block" flex="35">


                            <md-switch class="md-primary" ng-disabled="enabled">
                            </md-switch>
                            <label>Restricción Limitante</label>

                        </md-input-container>

                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->
                        <!-- ################################################################################################ -->


                    </div>

                    <div layout="row">
                        <md-input-container class="md-block" flex>
                            <label>Comentarios</label>
                            <input ng-model="abono.descripcion" required/>

                        </md-input-container>

                        <md-button style="height: 20px;" md-no-ink flex="10">Adjuntar</md-button>

                    </div>

                </form>

            </md-content>

            <div style="width: 16px;" ng-mouseover="showNext(true,'lyr6pag')">


            </div>
        </md-sidenav>


        <!--    **********************************    SELECCIONAR DEUDAS A PAGAR CON EL DOCUMENTO ******************-->
        <!--        FORM: FABONO2-->

        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr6pag"
                    id="lyr6pag">
            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>

                <form name="formAbono" ng-submit="saveFormAbono()">

                    <div class="titulo_formulario" layout="column" layout-align="start start" style="height: 39px;">
                        <div>
                            Uso del pago a Proveedor: <span style="color:#000">{{provData.nombre}}</span>
                        </div>
                    </div>

                    <!-- datos del pago-->

                    <div layout="row" style="height: 39px;">


                        <md-input-container class="md-block" flex="20">
                            <label>Tipo Pago</label>
                            <md-select ng-model="abono.tipo_id" required md-no-ink>
                                <md-option ng-repeat="tipoPago in tipoDocsPago"
                                           ng-selected="tipoPago.id==abono.tipo_id" value="{{tipoPago.id}}">
                                    {{tipoPago.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                        <!--espacio-->
                        <span style="padding-right: 300px">&nbsp; </span>
                        <!--espacio-->


<!--                        <div>Id del pago: #100</div>-->

                        <!--espacio-->
                        <span style="padding-right: 100px">&nbsp; </span>
                        <!--espacio-->
          <!--              <div>Fecha: <?/*= date("d-m-Y") */?></div>-->


                    </div>

                    <div layout="row" style="height: 39px;">

                        <md-input-container class="md-block" flex="15">
                            <label>Monto</label>
                            <input ng-readonly="true" ng-model="abono.monto" required/>
                        </md-input-container>

                        <div flex="15">
                            <md-datepicker ng-model="abono.fecha" required md-placeholder="fecha"></md-datepicker>
                        </div>


                        <!--espacio-->
                        <span style="padding-right: 300px">&nbsp; </span>
                        <!--espacio-->


                        <md-input-container class="md-block" flex="15">
                            <label>Moneda</label>
                            <md-select ng-model="abono.moneda_id" required
                                       ng-change="getTasaByCoinId(abono.moneda_id,'abono')" md-no-ink>
                                <md-option
                                    ng-selected="moneda.id==abono.moneda_id"
                                    ng-repeat="moneda in monedas" ng-value="{{moneda.id}}">
                                    {{moneda.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                        <md-input-container class="md-block" flex="15">
                            <label>Tasa</label>
                            <input ng-model="abono.tasa" ng-value="abono.tasa" required/>
                        </md-input-container>

                    </div>


                    <div class="titulo_formulario" layout="column" layout-align="start start" style="height: 39px;">
                        <div>
                            Montos: abono/deuda
                        </div>
                    </div>

                    <div layout="row" style="height: 39px;">

                        <md-input-container class="md-block" flex="35">
                            <span class="balance_plus">{{abono.monto - abono.monto_rec | currency : $ : 2}} </span> / <span
                                class="balance_sub">{{provSelected.tdeuda | currency : $ : 2}}</span>
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Proceder el Pago</label>
                            <md-select ng-model="abono.tipo" md-no-ink>
                                <md-option ng-repeat="metodoPago in [{id:1,nombre: 'Todo por llegar'},
                            {id:2,nombre: 'Vencidos'} ]" value="{{metodoPago.id}}">
                                    {{metodoPago.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                        <!--espacio-->
                        <span style="padding-right: 40px">&nbsp; </span>
                        <!--espacio-->


                        <md-input-container class="md-block" flex="20">
                            <md-checkbox ng-model="isDisabled" aria-label="Disabled">
                                Pagar todo?
                            </md-checkbox>
                        </md-input-container>


                    </div>


                    <div class="titulo_formulario" layout="column" layout-align="start start" style="height: 39px;">
                        <div>
                            Deudas adquiridas con el proveedor
                        </div>
                    </div>

                    <div layout="row" class="headGridHolder">
                        <div>&nbsp;</div>
                        <div flex="10" class="headGrid"> Tipo Doc</div>
                        <div flex="10" class="headGrid"> Doc Origen</div>
                        <div flex class="headGrid"> Emitido</div>
                        <div flex class="headGrid"> Vence</div>
                        <div>&nbsp;</div>
                        <div flex="10" class="headGrid"> Total Deuda</div>

                        <div flex="10" class="headGrid"> Pagado</div>
                        <div flex="10" class="headGrid"> Saldo</div>
                        <div flex="10" class="headGrid"> Pagar</div>
                    </div>

                </form>

                <div id="grid" flex style="overflow-y: auto;">
                    <div ng-repeat="doc in provData.deudas2" flex>
                        <div layout="row" class="cellGridHolder">
                            <div class="cellGrid">
                                <md-switch ng-true-value="1" ng-false-value="0" class="md-primary"
                                           ng-model="doc.seleccionado"
                                           ng-disabled="enabled">
                                </md-switch>
                            </div>
                            <div flex="10" class="cellGrid">{{doc.tipo}}</div>
                            <div flex="10" class="cellGrid">{{doc.doc_orig}}</div>
                            <div flex class="cellGrid">{{doc.fecha}}</div>
                            <div flex class="cellGrid">{{doc.vence}}</div>
                            <div flex class="cellGrid">
                                <div style="width: 16px; height: 16px; border-radius: 50%"
                                     class="{{doc.vencido}}"></div>
                            </div>
                            <div flex="10" class="cellGrid">{{doc.monto | currency : $ : 2}}</div>
                            <div flex="10" class="cellGrid">{{doc.saldo | currency : $ : 2}}</div>
                            <div flex="10" class="cellGrid">{{doc.saldo | currency : $ : 2}}</div>
                            <div flex="10" class="cellGrid">{{doc.saldo | currency : $ : 2}}</div>

                        </div>
                    </div>
                </div>


            </md-content>

            <div style="width: 16px;" ng-mouseover="showNext(true,'lyr7pag','123')">

            </div>
        </md-sidenav>


        <!--    **********************************   EJECUTA EL ABONO PANTALLA FINAL ******************-->
        <!--        FORM: FABONO3-->


        <md-sidenav layout="column" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);"
                    class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr7pag"
                    id="lyr7pag">


            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>

                <div class="titulo_formulario" layout="column" layout-align="start start" style="height: 39px;">
                    <div style="text-align: center">
                        SE HA REALIZADO LA OPERACION CORRECTAMENTE
                    </div>
                </div>


                <div layout="row" style="height: 39px;">

                    <md-input-container class="md-block" flex="35">
                        <span class="balance_plus">{{abono.monto | currency : $ : 2}} </span> / <span
                            class="balance_sub">{{provSelected.tdeuda | currency : $ : 2}}</span>
                    </md-input-container>


                </div>


                <div class="titulo_formulario" layout="column" layout-align="start start" style="height: 39px;">
                    <div>
                        Deudas pagadas por selección
                    </div>
                </div>


                <div layout="row" class="headGridHolder">
                    <div flex="10" class="headGrid"> Tipo Doc</div>
                    <div flex="10" class="headGrid"> Doc Origen</div>
                    <div flex class="headGrid"> Emitido</div>
                    <div flex class="headGrid"> Vence</div>
                    <div flex="10" class="headGrid"> Total Deuda</div>

                    <div flex="10" class="headGrid"> Pagado</div>
                    <div flex="10" class="headGrid"> Saldo</div>
                    <div flex="10" class="headGrid"> Pagar</div>
                </div>
                <div id="grid" flex style="overflow-y: auto;">
                    <div ng-repeat="doc in provData.deudas2  | filter:{ seleccionado: 1 }" flex>
                        <div layout="row" class="cellGridHolder">
                            <div flex="10" class="cellGrid">{{doc.tipo}}</div>
                            <div flex="10" class="cellGrid">{{doc.doc_orig}}</div>
                            <div flex class="cellGrid">{{doc.fecha}}</div>
                            <div flex class="cellGrid">{{doc.fecha_vence}}
                                <div style="width: 16px; height: 16px; border-radius: 50%"
                                     class="{{doc.vencimiento}}"></div>
                            </div>
                            <div flex="10" class="cellGrid">{{doc.monto | currency : $ : 2}}</div>
                            <div flex="10" class="cellGrid">{{doc.saldo | currency : $ : 2}}</div>
                            <div flex="10" class="cellGrid">{{doc.saldo | currency : $ : 2}}</div>
                            <div flex="10" class="cellGrid">{{doc.saldo | currency : $ : 2}}</div>

                        </div>
                    </div>
                </div>

            </md-content>


        </md-sidenav>

        
        
        

        <!-- boton para registrar pago nuevo-->
        <md-sidenav
            style="margin-top:96px; margin-bottom:48px; width:96px; background-color: transparent; background-image: url('images/btn_backBackground.png');"
            layout="column" layout-align="center center" class="md-sidenav-right" md-disable-backdrop="true"
            md-component-id="NEXT" ng-mouseleave="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png", "", array('ng-click' => "openLayer()")) ?>
        </md-sidenav>
        <!-- boton para registrar pago nuevo-->


    </div>


</div>