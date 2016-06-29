<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION PEDIDOS########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="PedidosCtrll" global xmlns="http://www.w3.org/1999/html">
    <div class="contentHolder" layout="row" flex>
        <div class="barraLateral" layout="column" >


            <div id="menu" layout="column" class="md-whiteframe-1dp" style="height: 48px; overflow: hidden; background-color: #f1f1f1;
             min-height: 48px;">
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


            <!--

                        <md-virtual-repeat-container  flex>

                            <div   class="boxList" layout="column" flex  md-virtual-repeat="item in  provList " md-on-demand ng-click="setProvedor(item)"  ng-class="{'listSel' : (item.id == provSelec.id)}">

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

                        </md-virtual-repeat-container>
            -->
        </div>
        <div layout="column"flex class="md-whiteframe-1dp">

            <div class="botonera" layout="row" layout-align="start center">
                <div style="width: 240px;" layout="row">
                    <div layout="column" layout-align="center center"></div>

                    <div layout="column" ng-show="(module.index < 1 || module.layer == 'listPedido' )" layout-align="center center" ng-click="menuAgregar()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && formBlock && !document.aprob_gerencia && !document.aprob_compras )" ng-click="updateForm()">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"  ng-show="layer == 'listPedido' " ng-click="FilterListPed()">
                        <span class="icon-Filtro" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && document.estado_id != 3 && document.id)"
                         ng-click="cancelDoc()">
                        <span class="icon-Eliminar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && formBlock && !document.aprob_gerencia && !document.aprob_compras    )"
                         ng-click="test('Copi doc')">
                        <span style="font-size: 24px"> CP</span>
                    </div>

                    <div layout="column" layout-align="center center"
                         ng-click="printTrace()">
                        <span style="font-size: 24px"> TEST</span>
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
                closeLayer        </md-input-container>-->

                    </div>
                </div>
            </div>


            <div flex layout="row">
                <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center" ng-click="moduleAccion({close:true})">
                    <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
                    <?= HTML::image("images/btn_prevArrow.png","",array("ng-show"=>"(module.index >0)")) ?>
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

        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listImport" id="listImport">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <form name="projectForm" layout="row" flex>
                    <div active-left></div>
                    <div  layout="column" flex class="layerColumn">
                        <div class="titulo_formulario" style="height: 39px; margin-left: 24px;">
                            <div>
                                {{forModeAvilable.getXValue(formMode.value -1 ).name}}
                            </div>
                        </div>
                        <div layout="row" class="headGridHolder">
                            <!--                            <div class="headGrid cellEmpty"> </div>
                            -->                            <div flex="5" class="headGrid"> - </div>
                            <div flex="5" class="headGrid"> N° </div>
                            <div flex="15" class="headGrid"> Titulo</div>
                            <div flex="15" class="headGrid"> N° Proforma</div>
                            <div flex="10" class="headGrid"> Fecha</div>
                            <div flex="5" class="headGrid"> </div>
                            <div flex="10" class="headGrid"> Transporte</div>
                            <div flex="15" class="headGrid"> N° Factura</div>
                            <div flex class="headGrid"> Monto</div>
                            <div flex class="headGrid"> Comentario</div>
                        </div>
                        <div class="gridContent"  ng-mouseleave="hoverLeave(false)" >
                            <div   ng-repeat="item in docImports" >
                                <div layout="row" class="cellGridHolder" ng-click="docImport(item)" >
                                    <!--                                    <div  class=" cellGrid cellEmpty"  > </div>
                                    -->                                    <div flex="5" class="cellGrid" ng-click="docImport(item)" > {{item.tipo}}</div>
                                    <div flex="5" class="cellGrid" ng-click="docImport(item)"> {{item.id}}</div>
                                    <div flex="15" class="cellGrid" ng-click="docImport(item)"> {{item.titulo}}</div>
                                    <div flex="15" class="cellGrid" ng-click="docImport(item)"> {{item.nro_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="docImport(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                    <div flex="5" class="cellGrid" ng-click="docImport(item)">
                                        <div style="width: 16px; height: 16px; border-radius: 50%"
                                             class="emit{{item.diasEmit}}"></div>
                                    </div>
                                    <div flex="10" layout="row" class="cellGrid cellGridImg"  style="float: left;" ng-click="docImport(item)">
                                        <div  ng-show="item.aero == 1 " style="margin-right: 8px;">
                                            <span class="icon-Aereo" style="font-size: 24px"></span>

                                        </div>
                                        <div  ng-show="item.maritimo == 1 " ><?= HTML::image("images/maritimo.png") ?></div>
                                    </div>
                                    <div flex="15" class="cellGrid" ng-click="docImport(item)" > {{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)" > {{item.monto | currency :item.symbol :2}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)" >{{item.comentario}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listEmailsImport" id="listEmailsImport">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <form layout="row" flex>
                    <div active-left></div>
                    <div  layout="column" flex="" class="layerColumn">
                        <div class="titulo_formulario" style="height: 39px; margin-left: 24px;">
                            <div>
                                Correos
                            </div>
                        </div>
                        <div layout="row" class="headGridHolder">
                            <div flex class="headGrid"> Enviado </div>
                            <div flex class="headGrid"> Provedor </div>
                            <div flex class="headGrid"> Asunto</div>
                            <div flex class="headGrid"> Correo</div>
                            <div flex class="headGrid">  Desde</div>
                        </div>
                        <div class="gridContent"   >
                            <div   ng-repeat="item in emails" ng-click="test('email')">
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid"  >{{item.emision}}</div>
                                    <div flex class="cellGrid"  >{{item.provedor}}</div>
                                    <div flex= class="cellGrid" > {{item.titulo}}</div>
                                    <div flex= class="cellGrid"  > {{item.email_destino}}</div>
                                    <div flex= class="cellGrid" > {{item.email_origen}}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER LISTA DE PEDIDOS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listPedido" id="listPedido">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <!--           <div class="backDiv"
                                ng-show="(!preview && layer != 'listPedido')"
                                ng-click="layers.closeLayer('listPedido')">

                           </div>-->
                <div active-left  ng-show="(!preview && layer != 'listPedido')" before="cancelClose"></div>
                <div  layout="column" flex="" class="layerColumn">
                    <div class="titulo_formulario" style="height: 39px; margin-left: 24px;">
                        <div>
                            Pedidos : <span style="color: #000;">{{provSelec.razon_social}}</span>
                        </div>
                    </div>
                    <div layout="row" class="headGridHolder">
                        <div class="headGrid cellEmpty"> </div>
                        <div flex="5" class="headGrid"> N° </div>
                        <div flex="15" class="headGrid"> Documento</div>
                        <div flex class="headGrid"> Titulo</div>
                        <div flex="10" class="headGrid"> N° Proforma</div>
                        <div flex="10" class="headGrid"> Fecha</div>
                        <div flex="5" class="headGrid"> </div>
                        <div flex="10" class="headGrid"> Transporte</div>
                        <div flex="10" class="headGrid"> N° Factura</div>
                        <div flex class="headGrid"> Monto</div>
                        <div flex class="headGrid"> Comentario</div>
                    </div>
                    <div class="gridContent"  ng-mouseleave="hoverLeave(false)" >
                        <div   ng-repeat="item in provSelec.pedidos" ng-click="DtPedido(item)">
                            <div layout="row" class="cellGridHolder" >
                                <div  class=" cellGrid cellEmpty" ng-mouseover="hoverpedido(item)"  ng-mouseenter="hoverEnter()" ng-mouseleave="hoverLeave(false)" > </div>
                                <div flex="5" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.id}}</div>
                                <div flex="15" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.documento}}</div>
                                <div flex class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.titulo}}</div>
                                <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.nro_proforma}}</div>
                                <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                <div flex="5" class="cellGrid" ng-mouseover="hoverPreview(true)">
                                    <div style="width: 16px; height: 16px; border-radius: 50%"
                                         class="emit{{item.diasEmit}}"></div>
                                </div>
                                <div flex="10" layout="row" class="cellGrid cellGridImg"  style="float: left;">
                                    <div  ng-show="item.aero == 1 " style="margin-right: 8px;">
                                        <span class="icon-Aereo" style="font-size: 24px"></span>

                                    </div>
                                    <div  ng-show="item.maritimo == 1 " ><?= HTML::image("images/maritimo.png") ?></div>
                                </div>
                                <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)"> {{item.nro_factura}}</div>
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
            <md-content  layout="row" flex class="sideNavContent"
                         ng-class="{preview: preview }"
                         flex ng-mouseover="hoverPreview(false)"
            >
                <!--  ##########################################  DIV BUT ########################################## -->
                <div class="backDiv"
                     ng-click="layers.closeLayer('resumenPedido')">
                </div>

                <!----PRIMERA COLUMNA DETALLE DE PEDIDO---->
                <div layout="column" flex="30" style="margin-right:8px;">
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            {{formMode.name}}
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

                <div  layout="column" flex >
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            Productos
                        </div>
                    </div>

                    <div layout="row" class="headGridHolder">
                        <div flex="15" class="headGrid"> Cod. Producto</div>
                        <div flex class="headGrid"> Descripción.</div>
                        <div flex class="headGrid"> Documento</div>
                        <div flex="10" class="headGrid"> Cantidad</div>
                    </div>
                    <div flex class="gridContent">
                        <div >
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.todos">
                                    <div flex="15" class="cellGrid"> {{item.cod_producto}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
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
            <md-content  layout="row" flex class="sideNavContent" flex >
                <div class="backDiv" ng-click="layers.closeLayer('menuAgr')">
                </div>
                <div style="width: 96px" layout="column" layout-align="space-between center">
                    <div class="docButton" layout="column" flex  ng-click="openEmail()"> <img src="images/mail_icon_48x48.gif" width="48" height="48"/></div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.solicitud)"> <img src="images/solicitud_icon_48x48.gif" width="48" height="48"/></div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.proforma)"> <img src="images/proforma_icon_48x48.gif"  width="48" height="48"/></div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.odc)"><img src="images/odc_icon_48x48.gif"  width="48" height="48"/> </div>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER EMAIL ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="email" id="email">
            <!--  ########################################## CONTENDOR  EMAIL ########################################## -->
            <md-content  layout="row" flex class="sideNavContent">

                <div  layout="column" flex="" >
                    <div style="background-color: #0a0a0a; width: 100%; height: 36px; min-height: 36px;">
                        <div style="margin: 8px;">Mensaje Nuevo</div>
                    </div>
                    <md-chips ng-model="email.destinos"
                              md-transform-chip="transformChip($chip)"
                              style="  height: 48px;">
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
                    <input  ng-model="email.asunto" placeholder="Asunto" style="border-top: 0; border-left: 0; border-right:0 ;">
                    <div flex layout="column" style="padding: 2px;">
                        <md-content   >
                            <div contenteditable
                                 ng-model="emailText"
                                 strip-br="true"
                                 required style="min-height: 20px; width: 100%;"></div>
                        </md-content>
                        <div></div>
                    </div>

                    <div layout="row"
                         style="background-color: #f5f5f5;width: 100%; min-height: 44px; height: 44px;">
                        <div  layout="column" layout-align="center center"   style="width: 80px;" ng-click="sendEmail()">
                            <div class="btn">Enviar</div>
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
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detalleDoc" id="detalleDoc">

            <md-content  layout="row" flex class="sideNavContent">
                <div  layout="column" flex="" >
                    <form name="FormHeadDocument" layout="row">
                        <div active-left></div>
                        <div layout="column" flex>
                            <div layout="row" flex style="height: 39px; min-height: 39px;">
                                <div layout="column"
                                     ng-show="document.doc_parent_id == 'null' || !document.doc_parent_id"
                                     layout-align="center center" ng-click="openImport()">
                                    <span class="icon-Importar" style="font-size: 24px"></span>
                                </div>
                                <div class="titulo_formulario" layout="column" layout-align="start start"  ng-click=" gridView = -1">
                                    <div>
                                        Datos de {{formMode.name}}
                                    </div>
                                </div>
                            </div>
                            <!--<div ng-show="( gridView != 4 )" >-->
                            <div   ng-show="( gridView != 4 )"  layout="row"  >
                                <md-input-container class="md-block" flex="50" >
                                    <label>Proveedor</label>
                                    <md-select ng-model="provSelec.id"
                                               md-no-ink
                                               info="Seleccione un proveedor para el documento"
                                               required
                                               ng-disabled="( formBlock || formGlobal == 'upd')"
                                               ng-click="toEditHead('prov_id', provSelect.id)"

                                    >
                                        <md-option ng-repeat="prov in todos" value="{{prov.id}}">
                                            {{prov.razon_social}}
                                        </md-option>
                                        <!--<md-option  value="-1">
                                           Nuevo P
                                        </md-option>-->
                                    </md-select>
                                </md-input-container>
                                <md-input-container class="md-block" flex="15">
                                    <label>N° de Pedido</label>
                                    <input  ng-model="document.id"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div layout="column" flex="15" style="margin-top: 8px;">
                                    <md-datepicker ng-model="document.emision"
                                                   md-placeholder="Fecha"
                                                   ng-disabled="(true)"
                                    ></md-datepicker>
                                </div>
                            </div>
                            <md-input-container   ng-show="( gridView != 4 )"  class="md-block" flex>
                                <label>Titulo</label>
                                <input  ng-model="document.titulo"
                                        ng-disabled="( formBlock )"
                                        required
                                        ng-change="toEditHead('titulo', document.titulo)"

                                >
                            </md-input-container>
                            <div  ng-show="( gridView != 4 )"  layout="row" >

                                <md-input-container class="md-block" flex="30">
                                    <label>Pais</label>
                                    <md-select ng-model="document.pais_id" md-no-ink
                                               ng-disabled="( formBlock )"
                                               ng-change="toEditHead('pais_id', document.pais_id)"


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
                                               ng-change="toEditHead('direccion_almacen_id', document.direccion_almacen_id)"


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
                                               ng-change="toEditHead('direccion_facturacion_id', document.direccion_facturacion_id)"


                                    >
                                        <md-option ng-repeat="dir in formData.direccionesFact" value="{{dir.id}}">
                                            {{dir.direccion}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>

                            </div>
                            <div   ng-show="( gridView != 4 )"  layout="row" >
                                <md-input-container class="md-block" flex="15">
                                    <label>Monto</label>
                                    <input  ng-model="document.monto"
                                            decimal
                                            ng-disabled="( formBlock )"
                                            required
                                            ng-change="toEditHead('monto', document.monto)"


                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10">
                                    <label>Moneda</label>
                                    <md-select ng-model="document.prov_moneda_id" md-no-ink
                                               ng-disabled="( formBlock)"
                                               required
                                               ng-change="toEditHead('prov_moneda_id', document.prov_moneda_id)"

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
                                            ng-click="toEditHead('tasa', document.tasa)"
                                            ng-only="document.tasa_fija != 1"
                                            required

                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="">
                                    <label>Condicion de pago</label>
                                    <md-select ng-model="document.condicion_pago_id" ng-disabled="( formBlock)"
                                               ng-change="toEditHead('condicion_pago_id', document.condicion_pago_id)"
                                               md-no-ink
                                               ng-required ="(formMode.value == 23)"

                                    >
                                        <md-option ng-repeat="conPago in formData.condicionPago" value="{{conPago.id}}">
                                            {{conPago.titulo}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>

                            </div>
                            <div   ng-show="( gridView != 4 )" layout="row" >

                                <md-input-container class="md-block" flex="10">
                                    <label>Mt3</label>
                                    <input ng-model="document.mt3"  name="mt3"
                                           ng-model="number" decimal
                                           ng-disabled="( formBlock)"
                                           ng-change="toEditHead('mt3', document.mt3)"
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="document.peso" name="peso" decimal
                                           ng-disabled="( formBlock)"
                                           ng-change="toEditHead('peso', document.peso)"

                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10">
                                    <label>Puerto</label>
                                    <md-select ng-model="document.puerto_id"
                                               md-no-ink
                                               ng-disabled="( formBlock || document.direccion_almacen_id =='' || !document.direccion_almacen_id)"
                                               ng-change="toEditHead('puerto_id', document.puerto_id)"
                                    >
                                        <md-option ng-repeat="item in formData.puertos" value="{{item.id}}">
                                            {{item.Main_port_name}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <div flex layout="row" flex ng-click="test()">
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
                            <div   ng-show="( gridView != 4 )"  layout="row">
                                <md-input-container class="md-block" flex="20">
                                    <label>Condiciones  </label>
                                    <md-select ng-model="document.condicion_id" md-no-ink
                                               ng-disabled="( formBlock)"
                                               ng-click="toEditHead('condicion_id', document.condicion_id)"
                                    >
                                        <md-option ng-repeat="condPed in formData.condicionPedido" value="{{condPed.id}}">
                                            {{condPed.nombre}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>

                                <md-input-container class="md-block" flex >
                                    <label>N° Factura:</label>
                                    <input ng-model="document.nro_factura"  ng-disabled="( formBlock)"
                                           ng-change="toEditHead('nro_factura', document.nro_factura)"

                                    >
                                </md-input-container>
                                <div layout="column" layout-align="center center" ng-click="openAdj('Factura')">
                                    <span class="icon-Adjuntar" style="font-size: 24px"></span>
                                </div>

                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( formBlock)"
                                           ng-required ="(formMode.value == 23)"
                                           ng-change="toEditHead('nro_proforma', document.nro_proforma)"

                                    >
                                </md-input-container>
                                <div layout="column" layout-align="center center" ng-click="openAdj('Proforma')">
                                    <span class="icon-Adjuntar" style="font-size: 24px"></span>
                                </div>                            </div>
                            <div   ng-show="( gridView != 4 )"  layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Comentario</label>
                                    <input ng-model="document.comentario"  ng-disabled="( formBlock)"
                                           ng-change="toEditHead('nro_proforma', document.nro_proforma)"

                                    >
                                </md-input-container>
                            </div>
                            <!--  </div>-->
                        </div>
                    </form>
                    <div ng-show="document.final_id != null ">
                        <form name="FormEstatusDoc" layout="row">
                            <div active-left></div>
                            <div></div>
                            <div layout="column" flex >
                                <div layout="row" flex style="height: 39px; min-height: 39px;">
                                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-click=" gridView = 1">
                                        <div>
                                            Aprobacion de Gerente
                                        </div>
                                    </div>
                                </div>

                                <div layout="row" ng-show="( gridView == 1 )" >

                                    <md-input-container class="md-block" flex="">
                                        <label>Estatus</label>
                                        <md-select ng-model="document.estado_id"  ng-disabled="formBlock"
                                                   ng-change="toEditHead('estado_id', document.estado_id)"

                                        >
                                            <md-option ng-repeat="item in estadosDoc" value="{{item.id}}">
                                                {{item.estado}}
                                            </md-option>
                                        </md-select>
                                    </md-input-container>

                                </div>
                            </div>

                        </form>
                        <form name="FormAprobCompras" layout="row">
                            <div active-left></div>
                            <div layout="column" flex>
                                <div layout="row" flex style="height: 39px; min-height: 39px;">
                                    <div class="titulo_formulario" layout="column" layout-align="start start" ng-click=" gridView = 2">
                                        <div>
                                            Aprobación
                                        </div>
                                    </div>
                                </div>

                                <div layout="row"  ng-show="( gridView == 2 )" >

                                    <div  style="height: 30px;margin-top: 9px;  color: #999999;" >
                                        Fecha de Aprobación
                                    </div>

                                    <div layout="column" flex="20">
                                        <md-datepicker ng-model="document.fecha_aprob_compra" md-placeholder="Fecha"
                                                       ng-disabled="(formBlock)"
                                                       ng-change="toEditHead('fecha_aprob_compra', document.fecha_aprob_compra)"

                                        ></md-datepicker>
                                    </div>

                                    <md-input-container class="md-block" flex="20">
                                        <label>N° Documento</label>
                                        <input ng-model="document.nro_doc"  ng-disabled="(formBlock)"
                                               ng-click="toEditHead('nro_doc', document.nro_doc)"

                                        >
                                    </md-input-container>

                                    <div flex layout="row" flex ng-click="test()">
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
                            </div>
                        </form>
                        <form name="FormCancelDoc" layout="row" >
                            <div active-left></div>
                            <div layout="column" flex>
                                <div layout="row" flex style="height: 39px; min-height: 39px;">

                                    <div class="titulo_formulario" layout="column" layout-align="start start" ng-click=" gridView = 3">
                                        <div>
                                            Cancelacion
                                        </div>
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex  ng-show="( gridView == 3 )" >
                                    <label>Motivo de cancelacion </label>
                                    <input  ng-model="document.comentario_cancelacion"
                                            ng-disabled="(formBlock)"
                                            id="mtvCancelacion"
                                            ng-change="toEditHead('comentario_cancelacion', document.comentario_cancelacion)"

                                    >
                                </md-input-container>

                            </div>
                        </form>
                    </div>
                    <form name=" productos" layout="row">
                        <div active-left></div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" layout="column" layout-align="start start" ng-click=" gridView = 4">
                                <div>
                                    <span style="color: #1f1f1f" ng-show="(document.productos.todos && document.productos.todos >0 )">({{document.productos.todos.length}})</span>
                                    Productos
                                </div>

                            </div>
                            <div ng-show="gridView == 4" layout="column" flex>
                                <div layout="row" class="headGridHolder">

                                    <div flex="5" class="headGrid"></div>
                                    <div flex="15" class="headGrid"> Cod. Producto</div>
                                    <div flex class="headGrid"> Descripción.</div>
                                    <div flex class="headGrid"> Doc. Origen</div>
                                    <div flex="10" class="headGrid"> Cantidad</div>

                                </div>
                                <div flex class="gridContent">
                                    <div >
                                        <div ng-repeat="item in document.productos.todos">
                                            <div layout="row" class="cellGridHolder" >
                                                <div flex="5" class="cellGrid">
                                                    <md-switch class="md-primary" ng-change="addRemoveItem(item)" ng-disabled="( formBlock )" ng-model="item.asignado"</md-switch>
                                                </div>
                                                <div flex="15" class="cellGrid"> {{item.cod_producto}}</div>
                                                <div flex class="cellGrid">  {{item.descripcion}}</div>
                                                <div flex class="cellGrid"> {{item.documento}}</div>
                                                <md-input-container class="md-block" flex="10" >
                                                    <input  ng-model="item.saldo"
                                                            ng-change="changeItem(item)"
                                                            ui-number-mask
                                                            ng-disabled="(formBlock || !item.asignado )"
                                                    />
                                                </md-input-container>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div   class="md-whiteframe-2dp" id="adjuntoProforma" style="width: 0px; display:none; padding: 4px;  height: 100%;" >
                    <div class="titulo_formulario" layout="column" layout-align="start start" style="heigth:39px;">
                        <div layout="row">
                            <div layout="column" layout-align="center center" ng-click="closeAdj()" >
                                <span class="icon-Inactivo" style="font-size: 24px; margin-right: 8px; color: black;"></span>
                            </div>
                            <div ng-click="">
                                {{folder}} Adjuntos
                            </div>
                        </div>
                    </div>
                    <div ngf-drop ngf-select="upload($files)" ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                         ngf-multiple="true" ngf-allow-dir="true" accept="image/*,application/pdf">
                        insertar archivo
                    </div>
                    <md-content flex>
                        <div class="imgItem" ng-repeat="item in imagenes | filter:folder">
                            <img ng-src="images/thumbs/{{item.thumb}}"/></div>

                    </md-content>


                </div>

                <div style="width: 16px;"  ng-show="!openAdjDtPedido"  ng-mouseover="showNext(true)"  > </div>
            </md-content>


        </md-sidenav>

        <!---- deprecated -->

        <!--  ########################################## LAYER ORDENES DE COMPRAS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="odc" id="odc">
            <!--) ########################################## CONTENDOR SECCION ORDENES DE COMPRA ########################################## -->
            <md-content  layout="column" class="sideNavContent" flex>

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
            <md-content  layout="row" class="sideNavContent" flex ng-init="overSusitu = -1">

                <div class="backDiv"      ng-click="closeLayer('agrPed')" > </div>
                <div layout="row" flex>
                    <div layout="column" flex>
                        <form>
                            <div class="titulo_formulario md-block"  layout="row"  >

                                <div>
                                    Contrapedidos
                                </div>

                                <div  ng-click="moduleAccion({open:{name:'agrContPed'}})" style="width:24px;">
                                    <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>

                                </div>
                            </div>
                        </form>
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
                        <form>
                            <div class="titulo_formulario md-block"   layout="row" >
                                <div>
                                    Kitchen Boxs
                                </div>
                                <div
                                    ng-click="moduleAccion({open:{name:'agrKitBoxs'}})"
                                    style="width:24px;">
                                    <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                                </div>
                            </div>
                        </form>
                        <div >
                            <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.kitchenBox" ng-class="{resalt : overSusitu == item.sustituto }">

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
                        <form>
                            <div class="titulo_formulario md-block"  layout="row" >
                                <div>
                                    {{formMode.name}} a Sustituir
                                </div>
                                <div
                                    ng-click="openDocSusti()"

                                    style="width: 24px;">
                                    <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                                </div>
                            </div>
                        </form>
                        <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                            <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.pedidoSusti" ng-mouseover = "overSusitu =  item.id">

                                <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>
                                <!-- <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>-->
                                <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.emision.substring(0, 10) | date:'dd/MM/yyyy' }}</div>
                                <div flex="10" class="cellGrid" ng-click="removeList(item)">
                                    <span class="icon-Eliminar fontEli"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- <div layout="column" flex>
                         <div class="titulo_formulario md-block" layout-padding  layout="row" >
                             <div>
                                 Otros
                             </div>
                             <div ng-click="test('addd otro')" style="width:24px;">
                                 <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                             </div>
                         </div>

                         <div layout="column" flex="" style="margin-left: 8px; margin-top: 8px;">
                             <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.otros">

                                 <div flex class="cellGrid" ng-click="test('detalle producto')"> {{item.id}}</div>
                                 <!-- <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>-->
                    <!-- <div flex class="cellGrid" ng-click="test('detalle producto')"> {{item.emision.substring(0, 10) | date:'dd/MM/yyyy' }}</div>
                     <div flex="10" class="cellGrid" ng-click="test('detalle producto')">
                         <span class="icon-Eliminar fontEli"></span>
                     </div>
                 </div>
             </div>

         </div>-->

                </div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!--  ########################################## LAYER PRODUCTOS PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listProducProv" id="listProducProv">

            <md-content  layout="row" flex class="sideNavContent">

                <div class="backDiv"  ng-click="closeLayer('listProducProv')"> </div>
                <div  layout="column" flex class="layerColumn" >
                    <div class="titulo_formulario md-block"  layout="row" >
                        <div>
                            Productos
                        </div>
                    </div>
                    <form name="newProd">
                        <!----FILTROS ---->
                        <div layout="row" class="headGridHolder">
                            <div flex="5" class="">
                                <!--                            <md-switch class="md-primary" ng-model="productoSearch.asignado" ></md-switch>
                                -->                        </div>

                            <md-input-container class="md-block  " flex="20">
                                <label>Cod. Fabrica</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="productoSearch.codigo"

                                >
                            </md-input-container>
                            <md-input-container class="md-block  " flex="20">
                                <label>Cod. Fabrica</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="productoSearch.codigo_fabrica"

                                >
                            </md-input-container>
                            <md-input-container class="md-block  " flex>
                                <label>Descripcion</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="productoSearch.descripcion"


                                >
                            </md-input-container>

                            <div flex="10" ng-disabled="(prodResult && prodResult.length == 0 )">
                                <md-switch class="md-primary" ng-model="productoSearch.puntoCompra" ></md-switch>
                            </div>

                            <md-input-container class="md-block  " flex="10">
                                <label>Cantidad</label>
                                <input type="text"
                                       ng-model="productoSearch.cantidad"
                                       class="inputFilter"

                                >
                            </md-input-container>
                            <div flex="5">
                                <div ng-click="createProduct(productoSearch)" style="width: 24px;" ng-show="( prodResult && prodResult.length == 0 && !formBlock)" ng-disabled="(formBlock)">
                                    <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!--- fin filtros-->
                    <div layout="row" class="headGridHolder">
                        <div flex="5" class="headGrid"> - </div>
                        <div flex="20" class="headGrid"> Cod. </div>
                        <div flex="20" class="headGrid"> Cod. Fabrica </div>
                        <div flex class="headGrid"> Descripcion</div>
                        <div flex="10" class="headGrid"> P. Compra</div>
                        <div flex="15" class="headGrid"> Cantidad</div>

                    </div>
                    <form name="listProductoItems" class="gridContent"  >
                        <div  flex >
                            <div   ng-repeat="item in providerProds | filter:productoSearch:strict as prodResult "
                                   ng-mouseenter = "mouseEnterProd(item) ">
                                <div layout="row" class="cellGridHolder" >
                                    <div flex="5" class="cellGrid">
                                        <md-switch class="md-primary"  ng-change=" changeProducto(item) " ng-disabled="(formBlock)" ng-model="item.asignado"></md-switch>
                                    </div>
                                    <div flex="20" class="cellGrid" > {{item.codigo}}</div>
                                    <div flex="20" class="cellGrid" > {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid" > {{item.descripcion}}</div>
                                    <div flex="10" class="cellGrid" >
                                        <md-switch class="md-primary" ng-disabled="true" ng-model="item.puntoCompra"></md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid">
                                        <input  ng-model="item.saldo" ng-change=" changeProducto(item) "
                                                type="number" min="1" id="p{{item.id}}" ng-disabled="(!item.asignado || formBlock) "/>
                                    </div>



                                </div>
                            </div>

                        </div>
                    </form>
                    <div layout="column" style=" height: 102px;padding: 8px;">
                        <div flex>
                            {{productTexto}}
                        </div>
                    </div>
                </div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (6) Agregar Contrapedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrContPed" id="agrContPed">
            <!-- ) ########################################## CONTENDOR Agregar Contrapedidos ########################################## -->
            <md-content layout="row" class="sideNavContent" flex>

                <div active-left></div>
                <div  layout="column" flex class="layerColumn" >

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Agregar Contrapedidos
                        </div>
                    </div>
                    <form name="addContraPedidos" >
                        <div layout="row" class="headGridHolder">
                            <div flex="5" class="headGrid"> % </div>
                            <div flex="5" class="headGrid"> Id </div>
                            <div flex="10" class="headGrid"> Fecha</div>
                            <div flex class="headGrid"> Titulo</div>
                            <div flex="10" class="headGrid"> Fecha Aprox</div>
                            <div flex="15" class="headGrid"> Monto</div>
                            <div flex class="headGrid"> Comentario</div>


                        </div>
                        <div flex class="gridContent">
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
                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (7) Agregar KITCHEN BOXS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrKitBoxs" id="agrKitBoxs">
            <!-- ) ########################################## CONTENDOR Agregar KITCHEN BOXS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent">

                <div class="backDiv"  ng-click="closeLayer('listProducProv')"> </div>
                <div  layout="column" flex class="layerColumn" >
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Agregar Kitchen Boxs
                        </div>
                    </div>

                    <form name="KitchenBoxs" >
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
                </div>
            </md-content>
        </md-sidenav>

        <!-- 17) ########################################## LAYER (8) Pedidos Pendientes########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPedPend" id="agrPedPend">
            <!-- ) ########################################## CONTENDOR  Pedidos Pendientes # ########################################## -->
            <md-content  layout="row" flex class="sideNavContent">
                <div class="backDiv"  ng-click="closeLayer('agrPedPend')"> </div>
                <div  layout="column" flex class="layerColumn" >
                    <form name="gridPagosPendientes" >
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                {{formMode.name}} Pendientes
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


                                <div layout="row" class="cellGridHolder" ng-repeat="item in docsSustitos" >
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
                </div>
            </md-content>
        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN CONTRA PEDIDO ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenContraPedido" id="resumenContraPedido" >
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE CONTRA PEDIDO ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" flex>
                    <form name="projectForm" layout="row" >
                        <div active-left></div>
                        <div  layout="column" flex class="layerColumn">
                            <div class="titulo_formulario" layout="column" layout-align="start start" ng-click=" gridViewCp = 1" >
                                <div>
                                    Resumen de Contra Pedido
                                </div>
                            </div>
                            <div layout="row" ng-show="gridViewCp == 1" >

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
                            <div layout="row"   ng-show="gridViewCp == 1">
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
                            <div layout="row"  ng-show="gridViewCp == 1">
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
                            <div layout="row"  ng-show="gridViewCp == 1">
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
                            <div layout="row"  ng-show="gridViewCp == 1">
                                <md-input-container class="md-block" flex>
                                    <label>Comentario:</label>
                                    <input name="coment" ng-model="contraPedSelec.comentario"  ng-disabled="true" >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <form name="FormResumenContra"  layout="row" flex >
                        <div active-left></div>
                        <div  layout="column" flex class="layerColumn">
                            <div class="titulo_formulario" layout="column" layout-align="start start" >
                                <div>
                                    Productos
                                </div>
                            </div>
                            <div >
                                <div layout="row" class="headGridHolder">

                                    <div flex="5" class="cellGrid">

                                    </div>
                                    <div flex="15" class="headGrid"> Codigo</div>
                                    <div flex class="headGrid"> Cod. Fabrica</div>
                                    <div flex class="headGrid"> Descripción.</div>
                                    <div flex="10" class="headGrid"> Cantidad</div>
                                    <div flex class="headGrid"> Comentario</div>
                                    <div flex class="headGrid"> Adjunto</div>
                                </div>
                                <div class="gridContent">
                                    <div flex>
                                        <div layout="row" class="cellGridHolder" ng-repeat="item in contraPedSelec.productos">
                                            <div flex="5" class="cellGrid">
                                                <md-switch class="md-primary"
                                                           ng-model="item.asignado"
                                                           ng-change="addRemoveCpItem(item)"
                                                           ng-disabled="(formBlock)"></md-switch>
                                            </div>
                                            <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                            <div flex class="cellGrid"> {{item.codigo_fabrica}}</div>
                                            <div flex class="cellGrid">  {{item.descripcion}}</div>
                                            <div flex="10"  class="cellGrid" >{{item.saldo}}</div>
                                            <div flex class="cellGrid">  {{item.comentario}}</div>
                                            <div flex class="cellGrid">  {{item.adjunto}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div layout="column" ng-show="contraPedSelec.productos.length >0 && gridViewCp == 1 " class="showMoreDiv" style="height: 40px" ng-click=" gridViewCp = 2" >
                        <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{contraPedSelec.productos.length}})</div>
                    </div>
                </div>

            </md-content>

        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN KICTCHEN BOX ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenKitchenbox" id="resumenKitchenbox" >
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE  KICTCHEN BOX  ########################################## -->

            <md-content  layout="row" flex class="sideNavContent">
                <div class="backDiv"  ng-click="closeLayer('resumenKitchenbox')"> </div>
                <div  layout="column" flex class="layerColumn" >
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Resumen de Kitchen Box
                        </div>
                    </div>
                    <form name="resumenContraPed" >

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
                </div>
            </md-content>

        </md-sidenav>


        <!-- 14) ########################################## LAYER (5) RESUMEN de Pedido a sustotuir########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; "  class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenPedidoSus" id="resumenPedidoSus" >
            <!-- ) ########################################## CONTENDOR SECCION PEDIDO SUSTITO ########################################## -->

            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" flex>
                    <form name="FormPedidoSusProduc" layout="row" >
                        <div active-left></div>
                        <div  layout="column" flex class="layerColumn">
                            <div class="titulo_formulario" layout="Column" layout-align="start start">
                                <div>
                                    Datos de la {{formMode.name}}
                                </div>
                            </div>
                            <div layout="row" ng-show="gridViewSus == 1" >
                                <md-input-container class="md-block" flex="15">
                                    <label>N° de Pedido</label>
                                    <input  ng-model="pedidoSusPedSelec.id" ng-disabled="true">
                                </md-input-container>

                                <div layout="column" flex="15">
                                    <md-datepicker ng-model="pedidoSusPedSelec.emision"
                                                   md-placeholder="Emision"
                                                   ng-disabled="true"
                                    ></md-datepicker>
                                </div>
                                <md-input-container class="md-block" flex >
                                    <label>Titulo</label>
                                    <input  ng-model="pedidoSusPedSelec.titulo" ng-disabled="true">
                                </md-input-container>
                            </div>
                            <div layout="row"  ng-show="gridViewSus == 1" >
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
                            <div layout="row"  ng-show="gridViewSus == 1" >
                                <md-input-container class="md-block" flex >
                                    <label>Comentario</label>
                                    <input ng-model="pedidoSusPedSelec.comentario"  ng-disabled="true">
                                </md-input-container>
                            </div>
                            <div layout="row"  ng-show="gridViewSus == 1" >
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
                            <div layout="row"  ng-show="gridViewSus == 1">
                                <md-input-container class="md-block" flex="">
                                    <label>Condicion de pago</label>
                                    <md-select ng-model="document.pedidoSusPedSelec" ng-disabled="( formBlock)"
                                               md-no-ink
                                               ng-required ="(formMode.value == 23)"

                                    >
                                        <md-option ng-repeat="conPago in formData.condicionPago" value="{{conPago.id}}">
                                            {{conPago.titulo}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <md-input-container class="md-block" flex="20" >
                                    <label>Monto</label>
                                    <input ng-model="pedidoSusPedSelec.monto"  decimal  ng-disabled="true">
                                </md-input-container>
                            </div>
                        </div>

                    </form>
                    <form name="FormResumenContra"  layout="row" flex >
                        <div active-left></div>
                        <div  layout="column" flex class="layerColumn">
                            <div class="titulo_formulario" layout="column" layout-align="start start" >
                                <div>
                                    Productos
                                </div>
                            </div>

                            <div layout="row" class="headGridHolder">
                                <div flex="5" class="cellGrid">
                                </div>
                                <div flex="15" class="headGrid"> Codigo </div>
                                <div flex="15" class="headGrid"> Cod. Fabrica </div>
                                <div flex class="headGrid"> Tipo</div>
                                <div flex class="headGrid"> Descripción.</div>
                                <div flex="10" class="headGrid"> Cantidad</div>
                                <div flex class="headGrid"> Comentario</div>
                                <div flex class="headGrid"> Adjunto</div>
                            </div>
                            <div  class="gridContent">
                                <div flex>
                                    <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSusPedSelec.productos.todos">
                                        <div flex="5" class="cellGrid">
                                        </div>
                                        <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                        <div flex="15" class="cellGrid">  {{item.codigo_fabrica}}</div>
                                        <div flex class="cellGrid"> {{item.tipo}}</div>
                                        <div flex class="cellGrid">  {{item.descripcion}}</div>
                                        <div flex="10" class="cellGrid">{{item.saldo}}</div>
                                        <div flex class="cellGrid">  {{item.comentario}}</div>
                                        <div flex class="cellGrid">  {{item.adjunto}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div layout="column" ng-show="pedidoSusPedSelec.productos >0 && gridViewSus == 1 " class="showMoreDiv" style="height: 40px" ng-click=" gridViewSus = 2" >
                            <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{contraPedSelec.productos.length}})</div>
                        </div>
                </div>
        </md-sidenav>

        <!--  ##########################################  FINAL DOCUMENTO########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="finalDoc" id="finalDoc">
            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" flex="30">
                    <form></form><!-- solucion angular se como el form-->
                    <form layout="row" >
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" style="height:39px;" ng-click=" gridViewFinalDoc = 1">
                                <div>
                                    {{formMode.name}}
                                </div>
                            </div>
                            <div  flex style="overflow-y:auto; overflow-x: hidden " ng-show="gridViewFinalDoc == 1"
                                 class="rowRsm"  layout="row"  >
                                <div layout="row" class="rowRsmTitle" flex="40" >
                                    <div > ID: </div>
                                    <div flex> {{document.id}} </div>
                                </div>
                                <div layout="row" class="rms" flex ng-show="document.version > 1">
                                    <div > Version: </div>
                                    <div flex> {{document.version}} </div>
                                </div>
                            </div>
                            <div layout="row" flex  class="rowRsm" ng-show="gridViewFinalDoc == 1">
                                <div class="rowRsmTitle" flex="40"> Creado: </div>

                                <div class="rms" flex  layout="row" layout-align="space-between center">
                                    <div>{{document.emision | date:'dd/MM/yyyy' }}</div>
                                    <div style="width: 16px; height: 16px; border-radius: 50% ; float: left;margin-left: 2px;margin-right: 2px;"
                                         class="emit{{document.diasEmit}}"></div>
                                </div>
                            </div>
                            <div layout="row" flex  class="rowRsm" ng-show="gridViewFinalDoc == 1" >

                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm"
                                         ng-show="finalDoc.titulo.estado == 'new' && finalDoc.titulo.trace.length > 0"
                                         layout-align="center center">
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.titulo.estado == 'upd'" layout-align="center center" >
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div layout="column"  class="divIconRsm" ng-show="finalDoc.titulo.estado == 'del'" layout-align="center center" >
                                        <span class="icon-Eliminar"></span>
                                    </div>
                                    <div class="rowRsmTitle">Titulo</div>
                                </div>
                                <div class="rms" > {{finalDoc.titulo.v | date:'dd/MM/yyyy' }}</div>
                            </div>
                            <div layout="row" flex  class="rowRsm" ng-show="(document.ult_revision && gridViewFinalDoc == 1) ">

                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.ult_revision.estado == 'new' && finalDoc.titulo.trace.length > 0"
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.ult_revision.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Revisado </div>
                                </div>
                                 <div  class="rms" > {{finalDoc.ult_revision.v | date:'dd/MM/yyyy' }}</div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="gridViewFinalDoc == 1">
                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'new' && finalDoc.estado_id.trace-length > 0"  layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Estado </div>
                                </div>
                                <div class="rms" flex> {{document.estado }}</div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="(document.prioridad && gridViewFinalDoc == 1 )">
                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.prioridad_id.estado == 'new'"
                                        layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.prioridad_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle" flex> Prioridad </div>
                                </div>
                                <div class="rms" > {{document.prioridad}} </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="gridViewFinalDoc == 1">
                                <div class="rowRsmTitle"> Proveedor: </div>
                                <div  class="rms" > {{document.proveedor}} </div>
                            </div>
                            <div layout="row" class="rowRsm" ng-show="(document.pais_id && gridViewFinalDoc == 1)" >
                                <div layout="row" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.pais_id.estado == 'new' && finalDoc.pais_id.trace.length"
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.pais_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Pais </div>
                                </div>
                                <div class="rms" > {{document.pais}} </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="(document.direccion_almacen_id && gridViewFinalDoc == 1)">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.direccion_almacen_id.estado == 'new'"
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.direccion_almacen_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Almacen </div>
                                </div>
                                <div class="rms" flex> {{document.almacen}} </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="( gridViewFinalDoc == 1)" >
                                <div layout="row" flex="40"  >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.nro_proforma.estado == 'new' && finalDoc.nro_proforma.trace.length > 0 "
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.nro_proforma.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle" flex> Proforma </div>
                                </div>
                                <div class="rms" flex  layout="row" layout-align="space-between center">
                                    <div>{{finalDoc.nro_proforma}}</div>
                                    <div class="circle">{{finalDoc.adjProforma.length}}</div>
                                </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="( gridViewFinalDoc == 1)">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.nro_factura.estado == 'new'"
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.nro_factura.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Factura </div>
                                </div>
                                <div class="rms" flex  layout="row" layout-align="space-between center">
                                    <div>{{document.nro_factura}}</div>
                                    <div class="circle">{{finalDoc.adjFactura.length}}</div>

                                </div>
                            </div>
                            <div layout="row"  class="rowRsm"  ng-show="( document.monto && gridViewFinalDoc == 1) ">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.monto.estado == 'new' && finalDoc.monto.trace.length > 0 "
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.direccion_almacen_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Monto </div>
                                </div>
                                <div class="rms" flex> {{document.monto}} </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="(document.moneda_prov_id && gridViewFinalDoc == 1 ) ">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.prov_moneda_id.estado == 'new' && finalDoc.prov_moneda_id.trace.length > 0 "
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.prov_moneda_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle" flex> Moneda </div>
                                </div>
                                <div class="rms"> {{document.moneda}} </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="(document.productos.todos.length > 0  && gridViewFinalDoc == 1)">
                                <div class="rowRsmTitle" flex="40"> Productos: </div>
                                <div class="rms" flex> {{document.productos.todos.length}} </div>
                            </div>
                        </div>
                    </form>
                    <form   layout="row" ng-show="document.productos.contraPedido.length > 0">
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" style="height:39px;" ng-click=" gridViewFinalDoc = 2">
                                <div>
                                    ContraPedido
                                </div>
                            </div>
                            <div flex ng-show="gridViewFinalDoc == 2">
                                <md-content>

                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.contraPedido" >
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'new' && finalDoc.titulo.trace.length > 0" layout-align="center center">
                                            <span class="icon-Agregar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                            <span class="icon-Actualizar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                            <span class="icon-Eliminar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid">{{item.id.v}}</div>
                                        <div class="cellGrid" flex>{{item.titulo.v}}</div>
                                    </div>
                                </md-content>
                            </div>
<!---
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
--->
                        </div>

                    </form>
                    <form   layout="row" ng-show="document.productos.kitchenBox.length > 0" >
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" style="height:39px;" ng-click=" gridViewFinalDoc = 3">
                                <div>
                                    KitchenBox
                                </div>
                            </div>
                            <div flex ng-show="gridViewFinalDoc == 3">
                                <md-content >
                                    <div layout="row" class="cellGridHolder" ng-repeat=" item in finalDoc.kitchenBox">
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'new' && finalDoc.titulo.trace.length > 0" layout-align="center center">
                                            <span class="icon-Agregar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                            <span class="icon-Actualizar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                            <span class="icon-Eliminar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid">{{item.id.v}}</div>
                                        <div class="cellGrid" flex>{{item.titulo.v}}</div>
                                    </div>
                                </md-content>
                            </div>

                        </div>
                    </form>
                    <form   layout="row" ng-show="document.productos.pedidoSusti.length > 0">
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" style="height:39px;" ng-click=" gridViewFinalDoc = 4">
                                <div>
                                    {{formMode.name}} Sustitutos
                                </div>
                            </div>
                            <div flex ng-show="gridViewFinalDoc == 4">
                                <md-content>
                                    <div layout="row" class="cellGridHolder" ng-repeat=" item in finalDoc.pedidoSusti">
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'new' && finalDoc.titulo.trace.length > 0" layout-align="center center">
                                            <span class="icon-Agregar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                            <span class="icon-Actualizar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid" layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                            <span class="icon-Eliminar" style="font-size: 16px"></span>
                                        </div>
                                        <div class="cellGrid">{{item.id.v}}</div>
                                        <div flex class="cellGrid">{{item.titulo.v}}</div>
                                    </div>
                                </md-content>
                            </div>

                        </div>
                    </form>
                </div>

                <div flex >
                    <div layout="column">
                        <div class="titulo_formulario" style="height:39px;" ng-click=" gridViewFinalDoc = 1">
                            <div>
                                Productos
                            </div>
                        </div>
                        <div flex>

                            <div layout="row" class="headGridHolder">
                                <div flex="20" class="headGrid"> Codigo </div>
                                <div flex="20" class="headGrid"> Cod. Fabrica </div>
                                <div flex class="headGrid"> Descripcion</div>
                                <div flex="15" class="headGrid"> Cantidad</div>
                            </div>

                            <div class="gridContent"  >
                                <div  flex >
                                    <div  ng-repeat="item in finalDoc.productos ">

                                        <div layout="row" class="cellGridHolder" >
                                            <div flex="20" class="cellGrid" > {{item.codigo}}</div>
                                            <div flex="20" class="cellGrid" > {{item.codigo_fabrica}}</div>
                                            <div flex class="cellGrid" > {{item.descripcion}}</div>
                                            <div flex="15" class="cellGrid">{{item.cantidad}}</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>


                    </div>

                </div>
                <div flex="20" ng-show="false"></div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!--
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: 360px; z-index:66;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true"
                    md-component-id="adjuntoProforma" id="adjuntoProforma"
        >
            <md-content class="cntLayerHolder" layout="column" layout-padding flex >
                <div class="titulo_formulario" layout="column" layout-align="start start" style="heigth:39px;">
                    <div ng-click="">
                        Adjuntos
                    </div>
                </div>
                <div flex layout="column">
                    <div ngf-drop ngf-select ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                         ngf-multiple="true" ngf-allow-dir="true" accept="image/*,application/pdf">
                        insertar archivo
                    </div>

                    <md-content flex>

                        <div class="imgItem" ng-repeat="pic in imgs"><img height="149px" width="149px" src="images/prueba/pagos/{{pic}}"/></div>
                    </md-content>
                </div>
            </md-content>
        </md-sidenav>
    -->

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

