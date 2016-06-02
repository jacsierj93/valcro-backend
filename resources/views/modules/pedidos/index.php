<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION PEDIDOS########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex  ng-controller="PedidosCtrll" >

    <div class="contentHolder" layout="row" flex>

        <div class="barraLateral" layout="column" style="height: 100%;">


            <div id="menu" layout="column" class="md-whiteframe-1dp" style="height: 48px; overflow: hidden; background-color: #f1f1f1">
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

                <div layout="column" flex="" >
                    <div class="menuFilter" id="expand1" style="height: 167px;" layout-align="start start">
                        <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                            <label>Razon  Social</label>
                            <input  type="text" ng-model="fRazSocial" >
                        </md-input-container>
                        <!--
                                                <md-autocomplete
                                                    md-selected-item="fpaisSelec"
                                                    md-search-text="texto"
                                                    md-items="item in filterData.paises | customFind : texto : searchCountry "
                                                    md-item-text="item.short_name "
                                                    placeholder="Pais">
                                                    <md-item-template>
                                                        <span >{{item.short_name}}</span>
                                                    </md-item-template>
                                                    <md-not-found>
                                                        No hay resultados "{{ctrl.searchText}}"
                                                    </md-not-found>
                                                </md-autocomplete>
                        -->


                    </div>
                    <div id="expand2" flex >

                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;" ng-click="FilterLateralMas()">
                        <img ng-src="{{imgLateralFilter}}">
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>

            </div>

            <div  style="overflow-y:auto;" flex>

                <div class="boxList" layout="column" flex  ng-repeat="item in  search()" ng-click="setProvedor(item)"  ng-class="{'listSel' : (item.id == provSelec.id)}">

                    <div  style="overflow: hidden; text-overflow: ellipsis; height: 80px;">{{item.razon_social}}</div>

                    <div layout="row" style="height: 40px;">
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="dot-item emit100" >
                                {{item.emit100}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="dot-item emit90" >
                                {{item.emit90}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="dot-item emit60">
                                {{item.emit60}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="dot-item emit30" >
                                {{item.emit30}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="dot-item emit7" >
                                {{item.emit7}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="dot-item emit0">
                                {{item.emit0}}
                            </div>
                        </div>
                    </div>
                    <div style="height:40px;" layout="row" layout-align="space-between center">
                        <div flex="" style="overflow: hidden; margin-right: 1px;">{{item.deuda| number:2}}</div>

                        <div flex="30" layout="row" style="height: 19px;" layout-align="end center" ng-show="item.puntoCompra > 0" >
                            <div >{{item.puntoCompra}}</div>
                            <img  style="float: left;" src="images/punto_compra.png"/>
                        </div>
                        <div flex="30" layout="row"  layout-align="end center" style="height: 19px;" ng-show="item.contraPedido > 0" >
                            <div >{{item.contraPedido}}</div>
                            <img  style="float: left;" src="images/contra_pedido.png"/>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <div layout="column"flex class="md-whiteframe-1dp">

            <div class="botonera" layout="row" layout-align="start center">
                <div style="width: 240px;" layout="row">
                    <div layout="column" layout-align="center center"></div>

                    <div layout="column" ng-show="(index < 1 )" layout-align="center center" ng-click="menuAgregar()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center" ng-show="(index > 1 )" ng-click="updateForm()">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"  ng-show="layer == 'listPedido' " ng-click="FilterListPed()">
                        <span class="icon-Filtro" style="font-size: 24px"></span>

                    </div>
                    <div layout="column" layout-align="center center"></div>

                </div>
                <!-- ########################################## FILTROS CABECERA ########################################## -->

                <div layout="row" ng-show="(layer == 'listPedido')"  flex>
                    <!-- <div style="margin-left: 4px; margin-right: 4px" layout="colum"
                          layout-align="center center" ng-repeat="item in filterData.tipoPedidos"  >
                         {{item.tipo}}
                     </div>
                     <div style="margin-left: 4px; margin-right: 4px" layout="colum"
                          layout-align="center center"  >
                         Todos
                     </div>-->
                    <div layout="colum" style="height: 28px;" flex="25" layout-align="center center">
                        <!--<md-input-container class="md-block" layout-align="center center" flex  >
                            <md-select ng-model="filterOption.tipo_pedido_id" md-no-ink >
                                <md-option ng-repeat="item in filterData.tipoPedidos" >
                                    {{item.tipo}}
                                </md-option>
                                <md-option value ="-1">
                                    Todos
                                </md-option>
                            </md-select>
                        </md-input-container>-->

                    </div>
                </div>
            </div>


            <div flex layout="row">
                <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center" ng-click="closeLayer()">
                    <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
                    <?= HTML::image("images/btn_prevArrow.png","",array("ng-show"=>"(index >0)")) ?>
                </div>

                <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
                <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
                    <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                        P
                    </div>
                    <br> Selecciones un Proveedor
                </div>
            </div>
        </div>

        <!-- ########################################## LAYER LISTA DE PEDIDOS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listPedido" id="listPedido">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex style="height: 100%;" >
                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'listPedido')}"
                     ng-show="(layer != 'listPedido' && !preview)"
                     ng-click="closeTo('listPedido')"></div>
                <div  layout="column" flex="">
                    <div class="titulo_formulario" style="height: 39px; margin-left: 24px;">
                        <div>
                            Pedidos : <span style="color: #000;">{{provSelec.razon_social}}</span>
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div class="headGrid cellEmpty"> </div>
                        <div flex="5" class="headGrid"> - </div>
                        <div flex="10" class="headGrid"> N° Pedido</div>
                        <div flex="15" class="headGrid"> N° Proforma</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="5" class="headGrid"> </div>
                        <div flex="10" class="headGrid"> Transporte</div>
                        <div flex="15" class="headGrid"> N° Factura</div>
                        <div flex class="headGrid"> Monto</div>
                        <div flex class="headGrid"> Comentario</div>
                    </div>
                    <div class="gridContent" ng-mouseleave="hoverLeave()" >
                        <div   ng-repeat="item in provSelec.pedidos" ng-click="DtPedido(item)">
                            <div layout="row" class="cellGridHolder" >
                                <div  class=" cellGrid cellEmpty" ng-mouseover="hoverpedido(item)"  > </div>
                                <div flex="5" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.tipo}}</div>
                                <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.id}}</div>
                                <div flex="15" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.nro_proforma}}</div>
                                <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                <div flex="5" class="cellGrid" ng-mouseover="hoverPreview(true)">
                                    <div style="width: 16px; height: 16px; border-radius: 50%"
                                         class="emit{{item.diasEmit}}"></div>
                                </div>
                                <div flex="10" layout="row" class="cellGrid cellGridImg" ng-mouseover="hoverPreview()" style="float: left;">
                                    <div  ng-show="item.aero == 1 " style="margin-right: 8px;">
                                        <span class="icon-Aereo" style="font-size: 24px"></span>

                                    </div>
                                    <div  ng-show="item.maritimo == 1 " ><?= HTML::image("images/maritimo.png") ?></div>
                                </div>
                                <div flex="15" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.nro_factura}}</div>
                                <div flex class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.monto | currency :item.symbol :2}}</div>
                                <div flex class="cellGrid" ng-mouseover="hoverPreview(true)">{{item.comentario}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER RESUMEN PEDIDO   ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenPedido" id="resumenPedido">
            <!--  ########################################## CONTENDOR  RESUMEN PEDIDO ########################################## -->
            <md-content  layout="row" flex style="height: 100%;"
                         ng-class="{preview: preview , cntLayerHolder: layer == 'resumenPedido' }"
                         flex ng-mouseover="hoverPreview(false)"

            >
                <!--  ##########################################  DIV BUT ########################################## -->
                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'resumenPedido')}"
                     ng-show="(layer != 'resumenPedido')"
                     ng-click="closeLayer('resumenPedido')">
                </div>
                <!----PRIMERA COLUMNA DETALLE DE PEDIDO---->
                <div layout="column" flex="30" style="margin-right:8px;">
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            Pedido
                        </div>
                    </div>
                    <div style="overflow-y:auto; overflow-x: hidden "
                         class="rowRsm" style="margin-right: 8px;" layout="row"  >
                        <div layout="row" class="rowRsmTitle">
                            <div > ID: </div>
                            <div flex> {{document.id}} </div>
                        </div>
                        <div layout="row" class="rms" flex="">
                            <div > Version: </div>
                            <div flex> {{document.version}} </div>
                        </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Creado: </div>
                        <div class="rms" > {{document.emision | date:'dd/MM/yyyy' }}
                            <div style="width: 16px; height: 16px; border-radius: 50% ; float: left;margin-left: 2px;margin-right: 2px;"
                                 class="emit{{document.diasEmit}}"></div>
                        </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Ult. Modif. </div>
                        <div class="rms" > {{document.emision | date:'dd/MM/yyyy' }} (demo)
                        </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Estado</div>
                        <div class="rms" > {{document.estado }}</div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class=" rms rowRsmTitle"> Prioridad: </div>
                        <div class="rms" > {{document.prioridad}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Proveedor: </div>
                        <div > {{document.proveedor}} </div>
                    </div>
                    <div layout="row" class="rowRsm">
                        <div class="rowRsmTitle" > Pais: </div>
                        <div class="rms" > {{document.pais}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle" > Almacen: </div>
                        <div class="rms" > {{document.almacen}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Motivo: </div>
                        <div class="rms" > {{document.motivo}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> N° Proforma: </div>
                        <div class="rms"> {{document.nro_proforma}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> N° Factura: </div>
                        <div class="rms" > {{document.nro_factura}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Monto: </div>
                        <div class="rms" > {{document.monto}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Moneda: </div>
                        <div class="rms"> {{document.moneda}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle"> Productos: </div>
                        <div class="rms"> {{document.productos.todos.length}} </div>
                    </div>
                </div>
                <div  layout="column" flex style="height: 100%;">
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            Productos
                        </div>
                    </div>
                    <div flex>
                        <div layout="row" class="headGridHolder">

                            <!--                                <div flex="5" class="headGrid"></div>
                            -->
                            <div flex="15" class="headGrid"> Cod. Producto</div>
                            <div flex class="headGrid"> Descripción.</div>
                            <div flex class="headGrid"> Doc. Origen</div>
                            <div flex="10" class="headGrid"> Cantidad</div>

                        </div>
                        <div class="gridContent">
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.todos">
                                    <!--    <div flex="5" class="cellGrid">
                                            <md-switch class="md-primary" ng-model="item.asignado"</md-switch>
                                        </div>-->
                                    <div flex="15" class="cellGrid"> {{item.cod_producto}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex class="cellGrid"> {{item.origen}}</div>
                                    <div flex="10" class="cellGrid"> {{item.saldo}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER MENU AGREGAR DOCUMENTO  ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="menuAgr" id="menuAgr">
            <!--  ########################################## CONTENDOR  RESUMEN PEDIDO ########################################## -->
            <md-content  layout="row" flex style="height: 100%;"
                         ng-class="{cntLayerHolder: layer == 'menuAgr' }"
                         flex

            >
                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'menuAgr')}"
                     ng-show="(layer != 'menuAgr')"
                     ng-click="closeLayer('menuAgr')">
                </div>
                <div style="width: 96px" layout="column" layout-align="space-between center">
                    <div class="docButton" layout="column" flex  ng-click="openEmail()"><div layout="column" layout-align="end center"> Email</div> </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc('Solicitud')"> <div layout="column" layout-align="end center"> Solicitud</div></div>
                    <div class="docButton" layout="column" flex ng-click="newDoc('Pedido')"> <div layout="column" layout-align="end center"> Pedido</div></div>
                    <div class="docButton" layout="column" flex ng-click="newDoc('Orden de Compra')"><div layout="column" layout-align="end center"> Orden de Compra</div> </div>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER EMAIL ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="email" id="email">
            <!--  ########################################## CONTENDOR  EMAIL ########################################## -->
            <md-content  layout="row" flex style="height: 100%;"
                         flex
            >
                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'email')}"
                     ng-show="(layer != 'email')"
                     ng-click="closeLayer('email')">
                </div>

                <div layout="column" flex>
                    <div style="background-color: #0a0a0a; width: 100%; height: 48px; color: whitesmoke;">
                        <div style="margin: 8px;">Mensaje Nuevo</div>
                    </div>
                    <md-chips ng-model="email.destinos"
                              md-transform-chip="transformChip($chip)"
                              style=" padding-left:4px;">
                        <md-autocomplete
                            md-search-text="emailToText"
                            md-items="item in searchEmails(emailToText)"
                            md-item-text="item.email"
                            placeholder="Para:">
                            <span md-highlight-text="ctrl.searchText">{{item.email}}</span>

                        </md-autocomplete>

                        <md-chip-template>
                            <strong>{{$chip.email}}</strong>
                        </md-chip-template>
                    </md-chips>
                    <div class="gridContent" style="height: 100%;">
                        <md-input-container  style="overflow-y:auto; width: calc(100% - 10px);">
                            <textarea  ng-model="email.content"  style="border: 0px;"></textarea>

                        </md-input-container>
                    </div >
                    <div layout="row" layout-align="start center" style="background-color: #f5f5f5;width: 100%; color: whitesmoke; height: 48px;">
                        <div  layout="column"
                              layout-align="center center"
                              style="background-color: #0288ff; margin: 2px;height: 44px;width: 150px;">
                            <div>Enviar</div>
                        </div>
                        <div  layout="column"
                              layout-align="center center"
                              class="btnOptEmail">
                            <div>A</div>
                        </div>

                    </div>
                </div>


            </md-content>
        </md-sidenav>

        <!-- ) ########################################## LAYER  FORMULARIO INFORMACION DEL DOCUMENTO ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detallePedido" id="detallePedido">

            <md-content  layout="row" flex
                         ng-class="{cntLayerHolder: layer == 'detallePedido' }"

            >

                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'detallePedido')}"
                     ng-show="(layer != 'detallePedido')"
                     ng-click="closeLayer('detallePedido')">
                </div>
                <div  layout="column" flex="">

                    <form name="FormdetallePedido">

                        <div class="titulo_formulario" layout="column" layout-align="start start">
                            <div>
                                Datos de {{formMode}}
                            </div>
                        </div>

                        <div layout="row"  >
                            <md-input-container class="md-block" flex="50" >
                                <label>Proveedor</label>
                                <md-select ng-model="provSelec.id"
                                           md-no-ink
                                           required
                                >
                                    <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                        {{prov.razon_social}}
                                    </md-option>
                                </md-select>
                            </md-input-container>


                            <md-input-container class="md-block" flex="15">
                                <label>Tipo </label>
                                <md-select ng-model="document.tipo_id"
                                           ng-disabled="( formBlock || provSelec.id == '')"

                                           >
                                    <md-option ng-repeat="item in formData.tipo" value="{{item.id}}">
                                        {{item.tipo}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="15">
                                <label>N° de Pedido</label>
                                <input  ng-model="document.id" ng-disabled="true">
                            </md-input-container>

                            <div layout="column" flex="15" style="margin-top: 8px;">
                                <md-datepicker ng-model="document.emision"
                                               md-placeholder="Fecha"
                                               ng-disabled="(true)"
                                ></md-datepicker>
                            </div>


                        </div>

                        <div layout="row" >

                            <md-input-container class="md-block" flex="30">
                                <label>Pais</label>
                                <md-select ng-model="document.pais_id" md-no-ink
                                           ng-disabled="( formBlock )"

                                >
                                    <md-option ng-repeat="item in formData.paises" value="{{item.id}}">
                                        {{item.short_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block"  flex>
                                <label>Direccion almacen</label>
                                <md-select ng-model="document.direccion_almacen_id"
                                           md-no-ink
                                           ng-disabled="( formBlock || provSelec.id == '' || document.pais_id == ''  )"

                                >
                                    <md-option ng-repeat="dir in formData.direcciones" value="{{dir.id}}">
                                        {{dir.direccion}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block"  flex>
                                <label>Direccion Facturacion</label>
                                <md-select ng-model="document.direccion_facturacion_id"
                                           md-no-ink
                                           ng-disabled="( formBlock || provSelec.id == '' )"

                                >
                                    <md-option ng-repeat="dir in formData.direccionesFact" value="{{dir.id}}">
                                        {{dir.direccion}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                        </div>

                        <div layout="row" >
                            <md-input-container class="md-block" flex="15">
                                <label>Monto</label>
                                <input  ng-model="document.monto"
                                        type="number"

                                        ng-disabled="( formBlock )"
                                        ng-required="(formMode == 'Solicitud')"

                                >
                            </md-input-container>

                            <md-input-container class="md-block" flex="10">
                                <label>Moneda</label>
                                <md-select ng-model="document.prov_moneda_id" md-no-ink
                                           ng-disabled="( formBlock)"
                                           ng-required="(formMode == 'Solicitud')"
                                >
                                    <md-option ng-repeat="moneda in formData.monedas" value="{{moneda.id}}" >
                                        {{moneda.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <md-input-container class="md-block" flex="10" ng-dblclick=" document.tasa_fija = 1 " >
                                <label>Tasa</label>
                                <input  ng-model="document.tasa"
                                        type="number"
                                       ng-disabled="( formBlock || document.prov_moneda_id == '' ||  !document.prov_moneda_id)"
                                        ng-required="(formMode == 'Solicitud')"
                                >
                            </md-input-container>

                            <md-input-container class="md-block" flex="">
                                <label>Condicion de pago</label>
                                <md-select ng-model="document.condicion_pago_id" ng-disabled="( formBlock)"
                                           md-no-ink

                                >
                                    <md-option ng-repeat="conPago in formData.condicionPago" value="{{conPago.id}}">
                                        {{conPago.titulo}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                        </div>

                        <div layout="row" >
                            <md-input-container class="md-block" flex="">
                                <label>Motivo Pedido </label>
                                <md-select ng-model="document.motivo_id"  md-no-ink
                                           ng-disabled="( formBlock)"

                                >
                                    <md-option ng-repeat="motivoPed in formData.motivoPedido" value="{{motivoPed.id}}">
                                        {{motivoPed.motivo}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <md-input-container class="md-block" flex="">
                                <label>Prioridad  </label>
                                <md-select  ng-model="document.prioridad_id"   md-no-ink
                                            ng-disabled="( formBlock)"

                                >
                                    <md-option ng-repeat="prioPed in formData.prioridadPedido" value="{{prioPed.id}}">
                                        {{prioPed.descripcion}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <md-input-container class="md-block" flex="">
                                <label>Condiciones  </label>
                                <md-select ng-model="document.condicion_id" md-no-ink
                                           ng-disabled="( formBlock)"

                                >
                                    <md-option ng-repeat="condPed in formData.condicionPedido" value="{{condPed.id}}">
                                        {{condPed.nombre}}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>

                        <div layout="row" >
                            <md-input-container class="md-block" flex >
                                <label>Comentario</label>
                                <input ng-model="document.comentario"  ng-disabled="( formBlock)">
                            </md-input-container>
                        </div>

                        <div layout="row" >
                            <md-input-container class="md-block" flex="10">
                                <label>Mt3</label>
                                <input ng-model="document.mt3"  name="mt3"  ng-model="number" ui-number-mask
                                       ng-disabled="( formBlock)"  >
                            </md-input-container>

                            <md-input-container class="md-block" flex="10" >
                                <label>Peso</label>
                                <input ng-model="document.peso" name="peso"  ng-model="number" ui-number-mask
                                       ng-disabled="( formBlock)" >
                            </md-input-container>
                            <md-input-container class="md-block" flex="10">
                                <label>Puerto</label>
                                <md-select ng-model="document.puerto_id"
                                           md-no-ink
                                           ng-disabled="( formBlock || document.direccion_almacen_id =='' || !document.direccion_almacen_id)"

                                >
                                    <md-option ng-repeat="item in formData.puertos" value="{{item.id}}">
                                        {{item.Main_port_name}}
                                    </md-option>
                                </md-select>
                            </md-input-container>

                            <div flex layout="row" flex="40" ng-click="test()">
                                <md-input-container class="md-block"  flex>
                                    <label>Adjunto</label>
                                    <input ng-model="document.adj" name="peso"  ng-model="number" ui-number-mask
                                           ng-disabled="true"
                                    >
                                </md-input-container>

                                <div layout="column" layout-align="center center">
                                    <span class="icon-Agregar" style="font-size: 24px"></span>
                                </div>
                            </div>
                        </div>

                    </form>

                    <div class="titulo_formulario" layout="coumn" layout-align="start start" ng-click="showProduc()" >
                        <div>
                            <span style="color: #1f1f1f" ng-show="(document.productos.todos && document.productos.todos >0 )">({{document.productos.todos.length}})</span>
                            Productos
                        </div>

                    </div>

                    <div >
                        <div layout="row" class="headGridHolder">

                            <div flex="5" class="headGrid"></div>
                            <div flex="15" class="headGrid"> Cod. Producto</div>
                            <div flex="15" class="headGrid"> Cod. Profit</div>
                            <div flex class="headGrid"> Descripción.</div>
                            <div flex class="headGrid"> Doc. Origen</div>
                            <div flex="10" class="headGrid"> Cantidad</div>

                        </div>
                        <div id="gridResOdc">
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.todos">
                                    <div flex="5" class="cellGrid">
                                        <md-switch class="md-primary" ng-model="item.asignado"</md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid"> {{item.cod_producto}}</div>
                                    <div flex="15" class="cellGrid"> {{item.cod_profit}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex class="cellGrid"> {{item.origen}}</div>
                                    <md-input-container class="md-block" flex="10" >
                                        <input  ng-model="item.saldo"
                                                ui-number-mask type="text"
                                                ng-disabled="(formBlock || !item.asignado )"
                                        />
                                    </md-input-container>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-----flecha siguiente -->
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>
            </md-content>


        </md-sidenav>


        <!--  ########################################## LAYER ORDENES DE COMPRAS ########################################## -->
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
                                <div class="cellGrid" flex="5" ng-disabled="(formBlock)">
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

        <!-- ########################################## LAYER RESUMEN ODC ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenodc" id="resumenodc">
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE ODC ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <!--
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

                                        <div layout="column" flex>
                                            <md-datepicker ng-model="odcSelec.emision" md-placeholder="Fecha"
                                                           ng-disabled="true"
                                            ></md-datepicker>
                                        </div>


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
                                            <md-select ng-model="document.pais_id" name ="pais_id" ng-disabled="true">
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
                                --->
            </md-content>
        </md-sidenav>

        <!--  ########################################## LAYER Agregar Pedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPed" id="agrPed">
            <!-- ) ########################################## Agregar Pedidos ########################################## -->
            <md-content  layout="row" style="margin-top:0px; height: 100%;"
                         ng-class="{cntLayerHolder: agrPed == 'agrPed' }"
                         flex>

                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'agrPed')}"
                     ng-show="(layer != 'agrPed')"
                     ng-click="closeLayer('agrPed')" >
                </div>
                <div layout="row" flex>
                    <div layout="column" flex>
                        <div class="titulo_formulario md-block" layout-padding layout="row"  >
                            <div>
                                Contrapedidos
                            </div>
                            <div ng-click=" openLayer('agrContPed');">
                                <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>

                            </div>
                        </div>

                        <div >
                            <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.contraPedido">

                                    <div flex="10" class="cellGrid" ng-click="selecContraP(item)"> {{item.id}}</div>
                                    <div flex="" class="cellGrid" ng-click="selecContraP(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                    <div flex="10" class="cellGrid" ng-click="removeList(item)">
                                        <span class="icon-Eliminar fontEli"></span>
                                    </div>
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
                                <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                            </div>
                        </div>

                        <div >
                            <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.kitchenBox">

                                    <div flex class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid"ng-click="selecKitchenBox(item)" > {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                    <div flex="10" class="cellGrid" ng-click="removeList(item)">
                                        <span class="icon-Eliminar fontEli"></span>
                                    </div>
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
                                <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                            </div>
                        </div>

                        <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                            <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.pedidoSusti">

                                <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>
                                <!-- <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>-->
                                <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.emision.substring(0, 10) | date:'dd/MM/yyyy' }}</div>
                                <div flex="10" class="cellGrid" ng-click="removeList(item)">
                                    <span class="icon-Eliminar fontEli"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!--  ########################################## LAYER PRODUCTOS PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listProducProv" id="listProducProv">

            <md-content  layout="row" flex
                         ng-class="{ cntLayerHolder: layer == 'listProducProv' }"

            >

                <div class="backDiv"  ng-class="{'backDivSelec' : (layer != 'listProducProv')}"
                     ng-show="(layer != 'listProducProv')"
                     ng-click="closeLayer('listProducProv')">
                </div>
                <div  layout="column" flex="">
                    <div class="titulo_formulario md-block" layout-padding  layout="row" >
                        <div>
                            Productos
                        </div>
                        <div ng-click="openLayer('agrKitBoxs')">
                            <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                        </div>
                    </div>


                    <div layout="row" class="headGridHolder">
                        <div flex="5" class="headGrid"> - </div>
                        <div flex="10" class="headGrid"> Cod. Producto</div>
                        <div flex class="headGrid"> Descripcion</div>
                        <div flex="5" class="headGrid"> Stock</div>
                    </div>
                    <div class="gridContent"  >
                        <div   ng-repeat="item in provSelec.productos" >
                            <div layout="row" class="cellGridHolder" >
                                <div flex="5" class="cellGrid">
                                    <md-switch class="md-primary" ng-model="item.asignado" ></md-switch>
                                </div>                                <div flex="5" class="cellGrid" > {{item.codigo}}</div>
                                <div flex class="cellGrid" > {{item.descripcion}}</div>
                                <div flex="15" class="cellGrid"> {{item.stock}} (Demo)</div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                    <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeContraP(item)" ng-disabled="(formBlock)"></md-switch>
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
                                    <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeKitchenBox(item)" ng-disabled="(formBlock)"></md-switch>
                                </div>
                                <div flex="5" class="cellGrid"  ng-click="selecKitchenBox(item)"> {{item.id}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.fecha | date:'dd/MM/yyyy'}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.num_proforma}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.img_proforma}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.monto}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.precio}}</div>
                                <div flex class="cellGrid"> {{item.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
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
                                    <md-switch class="md-primary" ng-model="item.asignado"
                                               ng-change="changePedidoSustituto(item)"
                                               ng-disabled="(formBlock)"></md-switch>
                                </div>
                                <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.nro_proforma}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.emision.subString(0,10) | date:'dd/MM/yyyy'}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.nro_factura}}</div>
                                <div flex="15" class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.monto}}</div>
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


                    <div layout="column" flex="20">
                        <md-datepicker ng-model="contraPedSelec.fecha"
                                       md-placeholder="Fecha" ng-disabled="true"></md-datepicker>
                    </div>

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

                <div layout="row" >
                    <md-input-container class="md-block" flex="60">
                        <label>Titulo:</label>
                        <input ng-model="contraPedSelec.titulo" ng-disabled="true" >
                    </md-input-container>

                    <div layout="column" flex="20">
                        <md-datepicker ng-model="contraPedSelec.fecha_aprox_entrega"
                                       md-placeholder="Entrega" ng-disabled="true">
                        </md-datepicker>
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
                                               ng-disabled="(formBlock)"></md-switch>
                                </div>
                                <div flex="15" class="cellGrid">  {{item.id}}</div>
                                <div flex class="cellGrid"> {{item.cod_profit}}</div>
                                <div flex class="cellGrid">  {{item.descripcion}}</div>
                                <div flex="10"  class="cellGrid" >{{item.saldo}}</div>
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

                        <div layout="column" flex="15">
                            <md-datepicker ng-model="kitchenBoxSelec.fecha" md-placeholder="Fecha" ng-disabled="true"></md-datepicker>
                        </div>

                        <md-input-container class="md-block" flex>
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

                        <div layout="column" flex="20">
                            <md-datepicker ng-model="kitchenBoxSelec.fecha_aprox_entrega"
                                           md-placeholder="Entrega"
                                           ng-disabled="true"
                            ></md-datepicker>
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
                                    ng-disabled="true" >
                        </md-input-container>

                        <div layout="column" flex="20">
                            <md-datepicker ng-model="kitchenBoxSelec.fecha_abono"
                                           md-placeholder="Fecha Abono"
                                           ng-disabled="true"
                            ></md-datepicker>
                        </div>
                        <div flex="">
                            <!-- imga maqueta -->
                            <?= HTML::image("images/adjunto.png",'null', array('id' => 'imgAdj')) ?>

                        </div>

                        <md-input-container class="md-block" flex="40">
                            <label>Condciones de pago</label>
                            <md-select ng-model="kitchenBoxSelec.condicion_pago_id" ng-disabled="true">
                                <md-option >

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


        <!-- 14) ########################################## LAYER (5) RESUMEN de Pedido a sustotuir########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; "  class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenPedidoSus" id="resumenPedidoSus" >
            <!-- ) ########################################## CONTENDOR SECCION PEDIDO SUSTITO ########################################## -->


            <md-content class="cntLayerHolder" layout="column" layout-padding flex>

                <form name="FormdetallePedidoSus">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos del Pedido
                        </div>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="15">
                            <label>Tipo de Pedido</label>
                            <md-select ng-model="pedidoSusPedSelec.tipo_pedido_id"
                                       ng-disabled="true" >
                                <md-option ng-repeat="tipo in formData.tipo" ng-value="{{tipo.id}}">
                                    {{tipo.tipo}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="15">
                            <label>N° de Pedido</label>
                            <input  ng-model="pedidoSusPedSelec.id" ng-disabled="true">
                        </md-input-container>

                        <div layout="column" flex="15">
                            <md-datepicker ng-model="pedidoSusPedSelec.emision"
                                           md-placeholder="Fecha"
                                           ng-disabled="true"
                            ></md-datepicker>
                        </div>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="">
                            <label>Motivo Pedido </label>
                            <md-select ng-model="pedidoSusPedSelec.motivo_pedido_id"  md-no-ink
                                       ng-disabled="true" >
                                <md-option ng-repeat="item in formData.motivoPedido" value="{{item.id}}">
                                    {{item.motivo}}
                                </md-option>
                            </md-select>
                        </md-input-container>

                        <md-input-container class="md-block" flex="">
                            <label>Prioridad Pedido </label>
                            <md-select  ng-model="pedidoSusPedSelec.prioridad_id"  required md-no-ink
                                        ng-disabled="true" required>
                                <md-option ng-repeat="item in formData.prioridadPedido" value="{{item.id}}">
                                    {{item.descripcion}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                        <md-input-container class="md-block" flex="">
                            <label>Condiciones Pedido </label>
                            <md-select ng-model="pedidoSusPedSelec.condicion_pedido_id" md-no-ink
                                       ng-disabled="true" required>
                                <md-option ng-repeat="item in formData.condicionPedido" value="{{item.id}}">
                                    {{item.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex >
                            <label>Comentario</label>
                            <input ng-model="pedidoSusPedSelec.comentario"  ng-disabled="true">
                        </md-input-container>
                    </div>

                    <div layout="row" >
                        <md-input-container class="md-block" flex="20">
                            <label>Mt3</label>
                            <input ng-model="pedidoSusPedSelec.mt3"   ui-number-mask
                                   ng-disabled="true" required >
                        </md-input-container>

                        <md-input-container class="md-block" flex="20" >
                            <label>Peso</label>
                            <input ng-model="pedidoSusPedSelec.peso"   ui-number-mask
                                   ng-disabled="true">
                        </md-input-container>
                    </div>
                </form>
                <form name="FormPedidoSusProduc" >

                    <div class="titulo_formulario"  style='margin-top: 20px;' layout="column" layout-align="start start">
                        <div>
                            Productos a Solicitar
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">

                        <div flex="5" class="cellGrid">

                        </div>
                        <div flex="15" class="headGrid"> Cod. Producto</div>
                        <div flex class="headGrid"> Tipo</div>
                        <div flex class="headGrid"> Descripción.</div>
                        <div flex="10" class="headGrid"> Cantidad</div>
                        <div flex class="headGrid"> Comentario</div>
                        <div flex class="headGrid"> Adjunto</div>
                    </div>
                    <div id="gridResOdc">
                        <div flex>
                            <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSusPedSelec.productos">
                                <div flex="5" class="cellGrid">
                                    <md-switch class="md-primary"
                                               ng-change="changePedidoSustitutoItem(item)"
                                               ng-model="item.asignado"
                                               ng-disabled="(formBlock )"></md-switch>
                                </div>
                                <div flex="15" class="cellGrid">  {{item.id}}</div>
                                <div flex class="cellGrid"> {{item.tipo}}</div>
                                <div flex class="cellGrid">  {{item.descripcion}}</div>
                                <div flex="10" class="cellGrid">{{item.saldo}}</div>
                                <div flex class="cellGrid">  {{item.comentario}}</div>
                                <div flex class="cellGrid">  {{item.adjunto}}</div>
                            </div>
                        </div>
                    </div>

                </form>
            </md-content>

        </md-sidenav>

        <!------------------------------------------- Flecha de siguiente------------------------------------------------------------------------->
        <md-sidenav
            style="margin-top:96px;
                    margin-bottom:48px;
                    width:96px; background-color: transparent;
                    background-image: url('images/btn_backBackground.png');
                    z-index: 100;"
            layout="column" layout-align="center center" class="md-sidenav-right"
            md-disable-backdrop="true" md-component-id="NEXT" id="NEXT"
            ng-mouseleave="showNext(false)" ng-click="next()">
            <?= HTML::image("images/btn_nextArrow.png") ?>
        </md-sidenav>

        <!------------------------------------------- Alertas ------------------------------------------------>
        <div ng-controller="notificaciones" ng-include="template"></div>

    </div>
</div>

