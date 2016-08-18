<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION PEDIDOS########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="PedidosCtrll" global xmlns="http://www.w3.org/1999/html" >
    <div class="contentHolder" layout="row" flex>
        <div class="barraLateral" layout="column" id="barraLateral" >


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

                <div layout="column" flex="" tabindex="-1"  style="padding: 0px 4px 0px 4px;" tabindex="-1">
                    <form name="provdiderFilter" tabindex="-1">
                        <div class="menuFilter" id="expand1" style="height: 176px;" layout-align="start start" tabindex="-1">
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Razon  Social</label>
                                <input  type="text" ng-model="filterProv.razon_social"  tabindex="-1" >
                            </md-input-container>

                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Pais</label>
                                <input  type="text" ng-model="filterProv.pais"  tabindex="-1" >
                            </md-input-container>

                            <!--<md-autocomplete style="background-color: transparent; margin-top: 0px !important;"
                                             class="filter"
                                             md-selected-item="filterProv.pais"
                                             md-search-text="texto"
                                             md-items="item in paises | filter : texto "
                                             md-item-text="item"
                                             md-no-asterisk
                                             md-input-id ="autoFilter"

                                             placeholder="Pais">
                                <md-item-template>
                                    <span >{{item}}</span>
                                </md-item-template>
                                <md-not-found>
                                    No hay resultados
                                </md-not-found>
                            </md-autocomplete>-->

                            <div layout="row" class="dotRow" style="height: 24px;">
                                <div flex layout layout-align="center center" ng-click="filterProv.f100 = !filterProv.f100  ">
                                    <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterProv.f100 ,'dot-filter100':!filterProv.f100}" >
                                        +
                                    </div>
                                </div>
                                <div flex layout layout-align="center center"  ng-click="filterProv.f90 = !filterProv.f90  ">
                                    <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterProv.f90 ,'dot-filter90':!filterProv.f90}" >
                                        90
                                    </div>
                                </div>
                                <div flex layout layout-align="center center"  ng-click="filterProv.f60 = !filterProv.f60  ">
                                    <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterProv.f60 ,'dot-filter60':!filterProv.f60}">
                                        60
                                    </div>
                                </div>
                                <div flex layout layout-align="center center"  ng-click="filterProv.f30 = !filterProv.f30  " >
                                    <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterProv.f30 ,'dot-filter30':!filterProv.f30}">
                                        30
                                    </div>
                                </div>
                                <div flex layout layout-align="center center"  ng-click="filterProv.f7 = !filterProv.f7  " >
                                    <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterProv.f7 ,'dot-filter7':!filterProv.f7}" >
                                        7
                                    </div>
                                </div>
                                <div flex layout layout-align="center center"  ng-click="filterProv.f0 = !filterProv.f0  " >
                                    <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterProv.f0 ,'dot-filter0':!filterProv.f0}">
                                        0
                                    </div>
                                </div>
                            </div>
                            <div style="height:48px; padding-right: 16px;" layout="row" layout-align="space-between center">
                                <div flex="" style="overflow: hidden;" layout="row" ng-init="filterProv.op = '+'">
                                    <div  style="width: 16px;" layout="column" layout-align="center center" ng-click="filterProv.op = (filterProv.op == '+') ? '-' : '+' " >
                                        <img src="{{(filterProv.op == '+') ? 'images/TrianguloUp.png' : 'images/TrianguloDown.png' }}" >
                                        <!-- <span  style="font-size: 24px"  >  {{filterProv.op }} </span>-->
                                    </div>
                                    <md-input-container class="md-block" flex >
                                        <label>Monto</label>
                                        <input  type="text" ng-model="filterProv.monto"   >
                                    </md-input-container>
                                </div>

                                <div flex="20" layout="row"  layout-align="center center" ng-click="filterProv.pc = !filterProv.pc" >
                                    <div layout="column" layout-align="center center" >
                                        <span class="icon-PuntoCompra" style="font-size: 24px"  ng-class= "{'item-select' : filterProv.pc ,'item-no-select':!filterProv.pc}"></span>
                                    </div>
                                </div>
                                <div flex="20" layout="row"  layout-align="center center" ng-click="filterProv.cp = !filterProv.cp" >
                                    <div layout="column" layout-align="center center" >
                                        <span class="icon-Contrapedidos" style="font-size: 24px"  ng-class= "{'item-select' : filterProv.cp ,'item-no-select':!filterProv.cp}"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div id="expand2" flex >

                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;" ng-click="FilterLateralMas()">
                        <img ng-src="{{imgLateralFilter}}">
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>
            </div>

            <div id="listado" flex  style="overflow-y:auto;"  >
                <div class="boxList"  layout="column" flex ng-repeat="item in search() | orderBy : 'prioridad' "  list-box ng-click="setProvedor(item, this)" ng-init="item.order = 1"
                     ng-class="{'listSel' : (item.id == provSelec.id)}"
                     id="prov{{item.id}}"
                     class="boxList"
                >

                    <div  style="overflow: hidden; text-overflow: ellipsis;" flex>{{item.razon_social}}</div>
                    <div layout="column" class="dot-text">
                        <div id="dot-show{{item.id}}" layout="column" flex ng-show="item.show">
                            <div layout="row">
                                <div flex="70">Emitidos: </div>
                                <div flex>{{item.emit}}</div>
                            </div>
                            <div layout="row">
                                <div flex="70">Revisados: </div>
                                <div flex>{{item.review}}</div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" class="dotRow">
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit100,item.review100)">
                            <div layout layout-align="center center" class="dot-item emit100" >
                                +
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit90,item.review90)">
                            <div layout layout-align="center center" class="dot-item emit90" >
                                90
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) "ng-mouseenter = "showDotData(item,item.emit60,item.review60)">
                            <div layout layout-align="center center" class="dot-item emit60">
                                60
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit30,item.review30)">
                            <div layout layout-align="center center" class="dot-item emit30" >
                                30
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit7,item.review7)">
                            <div layout layout-align="center center" class="dot-item emit7" >
                                7
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit0,item.review0)">
                            <div layout layout-align="center center" class="dot-item emit0">
                                0
                            </div>
                        </div>
                    </div>

                    <div style="height:40px;" layout="row" layout-align="space-between center">
                        <div flex="" style="overflow: hidden; margin-right: 1px;">{{item.deuda| number:2}}</div>

                        <div flex="30" layout="row" style="height: 19px;" layout-align="end center" ng-show="item.puntoCompra > 0" >
                            <div >{{item.puntoCompra}}</div>
                            <img  style="float: left;" src="images/punto_compra.png"/>
                        </div>
                        <div flex="30" layout="row"  layout-align="end center" style="height: 19px;" ng-show="item.contrapedido ==  1 " >
                            <div >{{item.contraPedido}}</div>
                            <img  style="float: left;" src="images/contra_pedido.png"/>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div layout="column" flex class="md-whiteframe-1dp">

            <div class="botonera" layout="row" layout-align="start center">
                <div style="width: 240px;" layout="row">
                    <div layout="column" layout-align="center center"></div>

                    <div layout="column" ng-show="(module.index < 1 || module.layer == 'listPedido' )" layout-align="center center" ng-click="menuAgregar()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && formBlock && !document.aprob_gerencia && !document.aprob_compras && document.id )" ng-click="updateForm()">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                    </div>
                    <!-- <div layout="column" layout-align="center center"  ng-show="layer == 'listPedido' " ng-click="FilterListPed()">
                         <span class="icon-Filtro" style="font-size: 24px"></span>
                     </div>-->
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && document.estado_id != 3 && document.id)"
                         ng-click="cancelDoc()">
                        <span class="icon-Eliminar" style="font-size: 24px"></span>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && formBlock && !document.aprob_gerencia && !document.aprob_compras    )"
                         ng-click="copyDoc()">
                        <span style="font-size: 24px"> CP</span>
                    </div>

                    <!--  <div layout="column" layout-align="center center"
                           ng-click="printTrace()">
                          <span style="font-size: 24px"> TEST</span>
                      </div>-->
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
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center" ng-click="closeSide()">
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
                <form layout="row">
                    <div active-left  ></div>
                    <div flex layout="column">
                        <div class="titulo_formulario" style="height: 39px;">
                            <div>
                                {{forModeAvilable.getXValue(formMode.value -1 ).name}}
                            </div>
                        </div>
                    </div>
                </form>
                <form layout="row">
                    <div active-left ></div>
                    <div layout="row" flex ng-init="tbl_listImport.order = 'id'" >
                        <div flex="5">
                            <md-input-container flex>
                                <label>-</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tbl_listImport.filter.id"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" >
                                <div ng-click="tbl_listImport.order = 'id' " ng-class="{'filter-select':(tbl_listImport.order == 'id')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-id' " ng-class="{'filter-select':(tbl_listImport.order == '-id')}"><span>-</span></div>
                            </div>
                        </div>
                        <div flex >
                            <md-input-container flex>
                                <label>Titulo</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tbl_listImport.filter.titulo"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" >
                                <div ng-click="tbl_listImport.order = 'titulo' " ng-class="{'filter-select':(tbl_listImport.order == 'titulo')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-titulo' " ng-class="{'filter-select':(tbl_listImport.order == '-titulo')}"><span>-</span></div>
                            </div>
                        </div>

                        <div flex="15" >
                            <md-input-container flex>
                                <label>Proforma</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tbl_listImport.filter.nro_proforma"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" >
                                <div ng-click="tbl_listImport.order = 'nro_proforma' " ng-class="{'filter-select':(tbl_listImport.order == 'nro_proforma')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-nro_proforma' " ng-class="{'filter-select':(tbl_listImport.order == '-nro_proforma')}"><span>-</span></div>
                            </div>
                        </div>
                        <div flex="10" layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Emision</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tbl_listImport.filter.emision"
                                       skip-tab
                                >
                            </md-input-container >
                            <div class="cell-filter-order" layout-align="center center" >
                                <div ng-click="tbl_listImport.order = 'emision' " ng-class="{'filter-select':(tbl_listImport.order == 'emision')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-emision' " ng-class="{'filter-select':(tbl_listImport.order == '-emision')}"><span>-</span></div>
                            </div>
                        </div>
                        <div style="width: 80px;" layout="row">
                            <md-input-container class="md-block"  flex>
                                <label></label>
                                <md-select ng-model="tbl_listImport.filter.diasEmit"  ng-init="tbl_listImport.filter.diasEmit = '-1'">
                                    <md-option value="-1">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item" style="border: 1px solid #bbb9b9;color: #bbb9b9;">
                                                All
                                            </div>
                                        </div>
                                    </md-option>
                                    <md-option value="100">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item emit100 " >
                                                +
                                            </div>
                                        </div>
                                    </md-option>
                                    <md-option value="90">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item emit90 " >
                                                90
                                            </div>
                                        </div>
                                    </md-option>
                                    <md-option value="60">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item emit60 " >
                                                60
                                            </div>
                                        </div>
                                    </md-option>
                                    <md-option value="30">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item emit30 " >
                                                30
                                            </div>
                                        </div>
                                    </md-option>
                                    <md-option value="7">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item emit7 " >
                                                7
                                            </div>
                                        </div>
                                    </md-option>
                                    <md-option value="0">
                                        <div flex layout layout-align="center center">
                                            <div layout layout-align="center center" class="dot-item emit0" >
                                                Hoy
                                            </div>
                                        </div>
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" >
                                <div ng-click="tbl_listImport.order = 'diasEmit' " ng-class="{'filter-select':(tbl_listImport.order == 'diasEmit')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-diasEmit' " ng-class="{'filter-select':(tbl_listImport.order == '-diasEmit')}"><span>-</span></div>
                            </div>
                        </div>
                        <div flex="10" layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Factura</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_listImport.filter.nro_factura"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" >
                                <div ng-click="tbl_listImport.order = 'nro_factura' " ng-class="{'filter-select':(tbl_listImport.order == 'nro_factura')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-nro_factura' " ng-class="{'filter-select':(tbl_listImport.order == '-nro_factura')}"><span>-</span></div>
                            </div>
                        </div>
                        <div flex="" layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Monto</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_listImport.filter.monto"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" >
                                <div  ng-click="tbl_listImport.order = 'monto' " ng-class="{'filter-select':(tbl_listImport.order == 'monto')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-monto' " ng-class="{'filter-select':(tbl_listImport.order == '-monto')}"><span>-</span></div>
                            </div>
                        </div>
                        <div flex layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Comentario</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_listImport.filter.comentario"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center"  >
                                <div  ng-click="tbl_listImport.order = 'comentario' " ng-class="{'filter-select':(tbl_listImport.order == 'comentario')}"><span>+</span></div>
                                <div ng-click="tbl_listImport.order = '-comentario' " ng-class="{'filter-select':(tbl_listImport.order == '-comentario')}"><span>-</span></div>
                            </div>
                        </div>
                    </div>
                </form>
                <form layout="row"  class="gridContent">
                    <div active-left before="verificExit" ></div>
                    <div layout="column" flex>
                        <div   ng-repeat="item in filterDocuments(docImports, tbl_listImport.filter) | orderBy : tbl_listImport.order" >
                            <div layout="row" class="cellGridHolder" ng-click="docImport(item)" >
                                <div flex="5" class="cellGrid" ng-click="docImport(item)" > {{item.tipo}}</div>
                                <div flex="5" class="cellGrid" ng-click="docImport(item)"> {{item.id}}</div>
                                <div flex="15" class="cellGrid" ng-click="docImport(item)"> {{item.titulo}}</div>
                                <div flex="15" class="cellGrid" ng-click="docImport(item)"> {{item.nro_proforma}}</div>
                                <div flex="10" class="cellGrid" ng-click="docImport(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                <div flex="5" class="cellGrid" ng-click="docImport(item)">
                                    <div style="width: 16px; height: 16px; border-radius: 50%"
                                         class="emit{{item.diasEmit}}"></div>
                                </div>
                                <div flex="15" class="cellGrid" ng-click="docImport(item)" > {{item.nro_factura}}</div>
                                <div flex class="cellGrid" ng-click="docImport(item)" > {{item.monto | currency :item.symbol :2}}</div>
                                <div flex class="cellGrid" ng-click="docImport(item)" >{{item.comentario}}</div>
                            </div>
                        </div>

                    </div>
                </form>
            </md-content>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listEmailsImport" id="listEmailsImport">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <form layout="row">
                    <div active-left before="verificExit" ></div>



                </form>
                <form layout="row" flex>
                    <div active-left before="verificExit"></div>
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
                <div layout="column" flex>
                    <form layout="row">
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div class="titulo_formulario" style="height: 39px; margin-left: 24px;" flex>
                            <div>
                                <span style="color: #000;">{{provSelec.razon_social}}</span>
                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div layout="row" flex ng-init="docOrder.order == id " tabindex="0">
                            <div class="cellEmpty"> </div>
                            <div layout="row" style="width: 80px;">
                                <md-input-container class="md-block"  flex>
                                    <md-select ng-model="docOrder.filter.documento" ng-init="docOrder.filter.documento ='-1'">

                                        <md-option value="-1" layout="row">
                                            <img src="images/Documentos.png" style="width:20px;">
                                        </md-option>
                                        <md-option value="21" layout="row" >
                                            <img src="images/solicitud_icon_48x48.gif" style="width:20px;">
                                        </md-option>
                                        <md-option value="22" layout="row">
                                            <img src="images/proforma_icon_48x48.gif" style="width:20px;">

                                        </md-option>
                                        <md-option value="23" layout="row">
                                            <img src="images/odc_icon_48x48.gif" style="width:20px;">
                                        </md-option>
                                    </md-select>

                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="docOrder.order = 'documento' " ng-class="{'filter-select':(docOrder.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-documento' " ng-class="{'filter-select':(docOrder.order == '-documento')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="5" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="docOrder.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="docOrder.order = 'id' " ng-class="{'filter-select':(docOrder.order == 'id')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="docOrder.order = '-id' " ng-class="{'filter-select':(docOrder.order == '-id')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="docOrder.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="docOrder.order = 'titulo' " ng-class="{'filter-select':(docOrder.order == 'titulo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-titulo' " ng-class="{'filter-select':(docOrder.order == '-titulo')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="docOrder.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="docOrder.order = 'nro_proforma' " ng-class="{'filter-select':(docOrder.order == 'nro_proforma')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-nro_proforma' "ng-class="{'filter-select':(docOrder.order == '-nro_proforma')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Emision</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="docOrder.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container >
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="docOrder.order = 'emision' " ng-class="{'filter-select':(docOrder.order == 'emision')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-emision' " ng-class="{'filter-select':(docOrder.order == '-emision')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div style="width: 80px;" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label></label>
                                    <md-select ng-model="docOrder.filter.diasEmit"  ng-init="docOrder.filter.diasEmit = '-1'">
                                        <md-option value="-1">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item" style="border: 1px solid #bbb9b9;color: #bbb9b9;">
                                                    All
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="100">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item emit100 " >
                                                    +
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="90">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item emit90 " >
                                                    90
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="60">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item emit60 " >
                                                    60
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="30">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item emit30 " >
                                                    30
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="7">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item emit7 " >
                                                    7
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="0">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" class="dot-item emit0" >
                                                    Hoy
                                                </div>
                                            </div>
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="docOrder.order = 'diasEmit' " ng-class="{'filter-select':(docOrder.order == 'diasEmit')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-diasEmit' " ng-class="{'filter-select':(docOrder.order == '-diasEmit')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="docOrder.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="docOrder.order = 'nro_factura' " ng-class="{'filter-select':(docOrder.order == 'nro_factura')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-nro_factura' " ng-class="{'filter-select':(docOrder.order == '-nro_factura')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="docOrder.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div  ng-click="docOrder.order = 'monto' " ng-class="{'filter-select':(docOrder.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="docOrder.order = '-monto' " ng-class="{'filter-select':(docOrder.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="docOrder.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center"  >
                                    <div  ng-click="docOrder.order = 'comentario' " ng-class="{'filter-select':(docOrder.order == 'comentario')}"><img src="images/TrianguloUp.png" /></div>
                                    <div ng-click="docOrder.order = '-comentario' " ng-class="{'filter-select':(docOrder.order == '-comentario')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div style="width: 80px;"></div>



                        </div>
                    </form>
                    <form layout="row"  class="gridContent">
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div layout="column" flex="" ng-mouseleave="hoverLeave(false)"  >
                            <div   ng-repeat="item in filterDocuments(provDocs, docOrder.filter) | orderBy : docOrder.order "   id="doc{{$index}}" row-select >
                                <div layout="row" class="cellGridHolder" >
                                    <div  class=" cellEmpty" ng-mouseover="hoverpedido(item)"  ng-mouseenter="hoverEnter()" ng-mouseleave="hoverLeave(false)"  ng-click="DtPedido(item)"> </div>
                                    <div style="width: 80px;" class="cellEmpty cellSelect"  ng-mouseover="hoverPreview(true)" tabindex="{{$index + 1}}">

                                        <div layout-align="center center"  style="text-align: center; width: 100%; ">
                                            <img style="width: 20px;" ng-src="{{transforDocToImg(item.documento)}}" />
                                        </div>

                                    </div>
                                    <div flex="5" class="cellGrid"  ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> <span>{{item.id}}</span> </div>
                                    <div flex class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.titulo}}</div>
                                    <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.nro_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                    <div style="width: 80px;text-align: -webkit-center; " class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)">
                                        <div style="width: 16px; height: 16px; border-radius: 50%"
                                             class="emit{{item.diasEmit}}"></div>
                                    </div>
                                    <!--                  <div flex="10" layout="row" class="cellGrid cellGridImg"  style="float: left;">
                                    <div  ng-show="item.aero == 1 " style="margin-right: 8px;">
                                        <span class="icon-Aereo" style="font-size: 24px"></span>

                                    </div>
                                    <div  ng-show="item.maritimo == 1 " ><?/*= HTML::image("images/maritimo.png") */?></div>
                                </div>-->
                                    <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.monto | currency :item.symbol :2}}</div>
                                    <div flex class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)">{{item.comentario}}</div>
                                    <div style="width: 80px; text-align: -webkit-center;"  class="cellEmpty "
                                         layout-align="center center" layout="row"
                                         ng-click="sideaddAnswer(this, item)"
                                    >
                                        <div class="dot-empty dot-attachment "  layout-align="center center" >
                                            <div style=" margin-top: 2.5px;">M</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div id="expand"></div>
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

                <div active-left before="verificExit"></div>
                <!----PRIMERA COLUMNA DETALLE DE PEDIDO---->
                <div layout="column" flex="25" style="margin-right:8px;">
                    <div class="titulo_formulario" style="height:39px;">
                        <div>
                            {{formMode.name}}
                        </div>
                    </div>
                    <div style="overflow-y:auto; overflow-x: hidden "
                         class="rowRsm" style="margin-right: 8px;" layout="row"  >
                        <div layout="row" class="rowRsmTitle" flex="40">
                            <div > ID: </div>
                            <div flex> {{resumen.id}} </div>
                        </div>
                        <div layout="row" class="rms" flex="">
                            <div > Version: </div>
                            <div flex> {{resumen.version}} </div>
                        </div>
                    </div>
                    <div layout="row" class="rowRsm">
                        <div class="rowRsmTitle" flex="40"> Creado: </div>
                        <div class="rms" flex layout="row" >
                            <div flex="">{{resumen.emision | date:'dd/MM/yyyy' }}</div>
                            <div style="width: 16px; height: 16px; border-radius: 50% ; float: left;margin-left: 2px;margin-right: 2px;"
                                 class="emit{{document.diasEmit}}"></div>
                        </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle" flex="40"> Ult. Modif. </div>
                        <div class="rms" flex > {{resumen.ult_revision | date:'dd/MM/yyyy' }}
                        </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle" flex="40"> Estado</div>
                        <div class="rms" flex> {{resumen.estado }}</div>
                    </div>
                    <div layout="row"  class="rowRsm" ng-show="document.prioridad">
                        <div class="rowRsmTitle" flex="40"> Prioridad: </div>
                        <div class="rms" flex> {{resumen.prioridad}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle" flex="40"> Proveedor: </div>
                        <div flex class="rms"> {{resumen.proveedor}} </div>
                    </div>
                    <div layout="row" class="rowRsm"  ng-show="document.pais_id">
                        <div class="rowRsmTitle" flex="40"> Pais: </div>
                        <div class="rms" flex > {{resumen.pais}} </div>
                    </div>
                    <div layout="row"  class="rowRsm"  ng-show="document.direccion_almacen_id">
                        <div class="rowRsmTitle" flex="40" > Almacen: </div>
                        <div class="rms"flex > {{resumen.almacen}} </div>
                    </div>
                    <div layout="row"  class="rowRsm" ng-show="document.document.nro_proforma">
                        <div class="rowRsmTitle" flex="40"> N° Proforma: </div>
                        <div class="rms" flex> {{resumen.nro_proforma}} </div>
                    </div>
                    <div layout="row"  class="rowRsm" ng-show="document.nro_factura">
                        <div class="rowRsmTitle" flex="40"> N° Factura: </div>
                        <div class="rms" flex> {{resumen.nro_factura}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle" flex="40"> Monto: </div>
                        <div class="rms" flex> {{resumen.monto}} </div>
                    </div>
                    <div layout="row"  class="rowRsm">
                        <div class="rowRsmTitle" flex="40"> Moneda: </div>
                        <div class="rms" flex> {{resumen.moneda}} </div>
                    </div>
                    <div layout="row"  class="rowRsm" ng-show="document.productos.todos.length > 0">
                        <div class="rowRsmTitle" flex="40" > Productos: </div>
                        <div class="rms" flex> {{resumen.productos.todos.length}} </div>
                    </div>
                </div>

                <div  layout="column" flex >
                    <form layout="row" class="focused">
                        <div flex layout="row">
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Productos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tblResumenPe.order = 'cod_producto' ">
                        <div flex="15" layout="row"  >
                            <md-input-container class="md-block"  flex>
                                <label>Codigo</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.cod_producto"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'cod_producto' " ng-class="{'filter-select':(tblResumenPe.order == 'cod_producto')}"><img src="images/TrianguloUp.png" ></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-cod_producto' " ng-class="{'filter-select':(tblResumenPe.order == '-cod_producto')}"><img src="images/TrianguloDown.png"/></div>
                            </div>

                        </div>
                        <div flex layout="row"  >
                            <md-input-container class="md-block"  flex>
                                <label>Descripicion</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.descripcion"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'descripcion' " ng-class="{'filter-select':(tblResumenPe.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-descripcion' " ng-class="{'filter-select':(tblResumenPe.order == '-descripcion')}"><img src="images/TrianguloDown.png"/></div>
                            </div>

                        </div>

                        <div flex layout="row"  >
                            <md-input-container class="md-block"  flex>
                                <label>Origen</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.documento"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'documento' " ng-class="{'filter-select':(tblResumenPe.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-documento' " ng-class="{'filter-select':(tblResumenPe.order == '-documento')}"><img src="images/TrianguloDown.png"/></div>
                            </div>

                        </div>

                        <div flex="10" layout="row"  >
                            <md-input-container class="md-block"  flex>
                                <label>Cantidad</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.saldo"
                                       skip-tab
                                >
                            </md-input-container>
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'saldo' " ng-class="{'filter-select':(tblResumenPe.order == 'saldo')}"><img src="images/TrianguloUp.png" ></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-saldo' " ng-class="{'filter-select':(tblResumenPe.order == '-saldo')}"><img src="images/TrianguloDown.png"/></div>
                            </div>

                        </div>

                    </form>
                    <form layout="row"  class="gridContent">
                        <div  layout="column" flex="">
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in resumen.productos.todos |filter: tblResumenPe.filter:strict | orderBy :tblResumenPe.order" id="resumenPeItem{{$index}}" row-select>
                                    <div flex="15" class="cellSelect cellEmpty" tabindex="{{$index + 1}}" > {{item.cod_producto}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
                                    <div flex="10" class="cellGrid"> {{item.saldo}}</div>
                                </div>
                            </div>
                        </div>
                    </form>



                    <!--  <div layout="row" class="headGridHolder" table="tblResumenPe">
                          <div flex="15" class="headGrid" orderBy="cod_producto"> Cod. Producto</div>
                          <div flex class="headGrid"  orderBy="descripcion"> Descripción.</div>
                          <div flex class="headGrid"  orderBy="documento"> Documento</div>
                          <div flex="10" class="headGrid"  orderBy="saldo"> Cantidad</div>
                      </div>-->
                    <!-- <div flex class="gridContent">
                         <div >

                         </div>
                     </div>-->
                </div>

                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER MENU AGREGAR DOCUMENTO  ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="menuAgr" id="menuAgr">
            <!--  ########################################## CONTENDOR  RESUMEN PEDIDO ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" flex  >
                <div active-left ></div>
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
                        <div style="margin: 8px; color: white;">Mensaje Nuevo</div>
                    </div>
                    <!--<md-contact-chips ng-model="email.destinarios "
                                      md-contacts="ContactosSearch($query)"
                                      md-contact-name="name"
                                      md-contact-image="image"
                                      md-contact-email="email"
                                       md-require-match="false"
                                      md-transform-chip="transformChip($chip)"
                                      md-highlight-flags="i" filter-selected="true" placeholder="Para">
                    </md-contact-chips>-->
                    <md-chips ng-model="email.destinos"
                              md-transform-chip="transformChip($chip)"
                              style="  height: 48px;">
                        <md-autocomplete
                            md-search-text="emailToText"
                            md-items="item in searchEmails(emailToText)"
                            md-item-text="item.email"
                            placeholder="Para:">
                            <span md-highlight-text="direccionesFactsearchText">{{item.email}}</span>

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
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detalleDoc" id="detalleDoc">

            <md-content  layout="row" flex class="sideNavContent">
                <div  layout="column" flex="" layout-align=" none" >
                    <form name="FormHeadDocument" layout="row" ng-class="{focused: gridView == 1}" >
                        <div active-left></div>
                        <div layout="column" flex >
                            <div layout="row" class="row" >
                                <div layout="column"
                                     ng-hide="document.doc_parent_id != null || document.doc_parent_id || !provSelec.id"
                                     layout-align="center center" ng-click="openImport()">
                                    <span class="icon-Importar" style="font-size: 24px"></span>
                                </div>
                                <div class="titulo_formulario" layout="column" layout-align="start start"  ng-click=" gridView = 1">
                                    <div>
                                        Datos de {{formMode.name}}
                                    </div>
                                </div>
                            </div>
                            <div   ng-show="( gridView != 5 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex="50" ng-click="allowEdit()" >
                                    <label>Proveedor</label>
                                    <md-autocomplete md-selected-item="ctrl.provSelec"
                                                     info="Seleccione un proveedor para el documento"
                                                     required
                                                     ng-disabled="( document.id )"
                                                     ng-click="toEditHead('prov_id', provSelect.id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="ctrl.searchProveedor"
                                                     md-auto-select="true"
                                                     md-items="item in todos | stringKey : ctrl.searchProveedor : 'razon_social' "
                                                     md-item-text="item.razon_social"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true">
                                        <md-item-template>
                                            <span>{{item.razon_social}}</span>
                                        </md-item-template>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block" flex="15" ng-click="allowEdit()">
                                    <label>N° de Pedido</label>
                                    <input  ng-model="document.id"
                                            ng-disabled="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div layout="column" flex="15" style="margin-top: 8px;" ng-click="allowEdit()">
                                    <md-datepicker ng-model="document.emision"
                                                   md-placeholder="Fecha"
                                                   ng-disabled="(true)"
                                                   skip-tab
                                    ></md-datepicker>
                                </div>
                            </div>

                            <div ng-show="( gridView != 5 )"  layout="row" class="row" >
                                <md-input-container   ng-show="( gridView != 5 )"  class="md-block" flex ng-click="allowEdit()" >
                                    <label>Titulo</label>
                                    <input  ng-model="document.titulo"
                                            ng-disabled="( formBlock )"
                                            required
                                            ng-change="toEditHead('titulo', document.titulo)"
                                            info="Escriba un titulo para facilitar identificacion del documento"
                                            skip-tab


                                    >
                                </md-input-container>
                            </div>

                            <div ng-show="( gridView != 5 )"  layout="row" class="row"  >

                                <md-input-container class="md-block" flex="30" ng-click="allowEdit()">
                                    <label>Pais</label>
                                    <md-autocomplete md-selected-item="ctrl.pais_id"
                                                     info="Selecione el pais de origen de los productos"
                                                     ng-disabled="( formBlock || !provSelec.id )"
                                                     ng-click="toEditHead('pais_id', document.pais_id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="ctrl.searchPais"
                                                     md-items="item in formData.paises | stringKey : ctrl.searchPais : 'short_name' "
                                                     md-item-text="item.short_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                                     md-no-cache="true"
                                                     md-delay="0"
                                                     md-escape-options=" blur clear "
                                    >
                                        <md-item-template>
                                            <span>{{item.short_name}}</span>
                                        </md-item-template>
                                    </md-autocomplete>
                                    <!-- <md-select ng-model="document.pais_id" md-no-ink
                                                ng-disabled="( formBlock || !provSelec.id )"
                                                ng-change="toEditHead('pais_id', document.pais_id)"
                                                info="Selecione el pais de origen de los productos"
                                                skip-tab
                                                id="pais_id"

                                     >
                                         <md-option ng-repeat="item in formData.paises" value="{{item.id}}">
                                             {{item.short_name}}
                                         </md-option>
                                         <md-option  value="-1" >
                                             Nuevo Pais
                                         </md-option>
                                     </md-select>-->
                                </md-input-container>
                                <md-input-container class="md-block"  flex ng-click="allowEdit()">
                                    <label>Direccion Facturacion</label>
                                    <md-autocomplete md-selected-item="ctrl.direccion_facturacion_id"
                                                     ng-disabled="( formBlock || provSelec.id == '' )"
                                                     ng-click="toEditHead('direccion_facturacion_id', document.direccion_facturacion_id)"
                                                     info="Selecione la direccion que debe especificarse en la factura"
                                                     id="direccion_facturacion_id"
                                                     skip-tab
                                                     id="direccion_facturacion_id"
                                                     md-search-text="ctrl.searchdirFact"
                                                     md-auto-select="true"
                                                     md-items="item in formData.direccionesFact | stringKey : ctrl.searchdirFact : 'direccion' "
                                                     md-item-text="item.direccion"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                    >
                                        <md-item-template>
                                            <span>{{item.direccion}}</span>
                                        </md-item-template>
                                    </md-autocomplete>

                                    <!--<md-select ng-model="document.direccion_facturacion_id"
                                               md-no-ink
                                               ng-disabled="( formBlock || provSelec.id == '' )"
                                               ng-change="toEditHead('direccion_facturacion_id', document.direccion_facturacion_id)"
                                               info="Selecione la direccion que debe especificarse en la factura"
                                               id="direccion_facturacion_id"
                                               skip-tab
                                               id="direccion_facturacion_id"



                                    >
                                        <md-option ng-repeat="dir in formData.direccionesFact" value="{{dir.id}}" skip-tab>
                                            {{dir.direccion}}
                                        </md-option>
                                        <md-option  value="-1" >
                                            Nueva Direccion de facturacion
                                        </md-option>
                                    </md-select>-->
                                </md-input-container>

                            </div>
                            <div ng-show="( gridView != 5 )"  layout="row" class="row">

                                <md-input-container class="md-block"  flex ng-click="allowEdit()">
                                    <label>Direccion almacen</label>
                                    <md-autocomplete md-selected-item="ctrl.direccion_almacen_id"
                                                     ng-disabled="( formBlock || provSelec.id == '' )"
                                                     ng-click="toEditHead('direccion_almacen_id', document.direccion_almacen_id)"
                                                     info="Selecione la direccion que debe especificarse en la factura"
                                                     id="direccion_almacen_id"
                                                     skip-tab
                                                     id="direccion_almacen_id"
                                                     skip-tab
                                                     md-search-text="ctrl.searchdirAlmacenSelec"
                                                     md-auto-select="true"
                                                     md-items="item in formData.direcciones | stringKey : ctrl.searchdirAlmacenSelec : 'direccion' "
                                                     md-item-text="item.direccion"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                    >
                                        <md-item-template>
                                            <span>{{item.direccion}}</span>
                                        </md-item-template>
                                    </md-autocomplete>
                                    <!-- <md-select ng-model="document.direccion_almacen_id"
                                                md-no-ink
                                                ng-disabled="( formBlock || !provSelec.id || !document.pais_id  )"
                                                ng-change="toEditHead('direccion_almacen_id', document.direccion_almacen_id)"
                                                info="Seleccione la direccion desde donde se despachara la mercancia"
                                                id="direccion_almacen_id"
                                                skip-tab
                                                id="direccion_almacen_id"




                                     >
                                         <md-option ng-repeat="dir in formData.direcciones" value="{{dir.id}}" skip-tab>
                                             {{dir.direccion}}
                                         </md-option>
                                         <md-option  value="-1" >
                                             Nuevo Direccion de almacen
                                         </md-option>
                                     </md-select>-->
                                </md-input-container>
                            </div>
                            <div ng-show="( gridView != 5 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex="15" ng-click="allowEdit()">
                                    <label>Monto</label>
                                    <input  ng-model="document.monto"
                                            decimal
                                            ng-disabled="( formBlock )"
                                            required
                                            ng-change="toEditHead('monto', document.monto)"
                                            info="Monto aproximado a pagar"
                                            skip-tab


                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" ng-click="allowEdit()">
                                    <label>Moneda</label>
                                    <md-autocomplete md-selected-item="ctrl.prov_moneda_id"
                                                     ng-disabled="( formBlock)"
                                                     required
                                                     ng-click="toEditHead('prov_moneda_id', document.prov_moneda_id)"
                                                     info="Seleccione la moneda en la que se realizara el pago"
                                                     id="prov_moneda_id"
                                                     skip-tab
                                                     md-search-text="ctrl.searchMonedaSelec"
                                                     md-auto-select="true"
                                                     md-items="item in formData.monedas | stringKey : ctrl.searchMonedaSelec : 'nombre' "
                                                     md-item-text="item.nombre"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                    >
                                        <md-item-template>
                                            <span>{{item.nombre}}</span>
                                        </md-item-template>
                                    </md-autocomplete>
                                    <!-- <md-select ng-model="document.prov_moneda_id" md-no-ink
                                                ng-disabled="( formBlock)"
                                                required
                                                ng-change="toEditHead('prov_moneda_id', document.prov_moneda_id)"
                                                info="Seleccione la moneda en la que se realizara el pago"
                                                id="prov_moneda_id"
                                                skip-tab

                                     >
                                         <md-option ng-repeat="moneda in formData.monedas" value="{{moneda.id}}" skip-tab >
                                             {{moneda.nombre}}
                                         </md-option>
                                         <md-option  value="-1" >
                                             Nuevo Moneda
                                         </md-option>
                                     </md-select>-->
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" ng-dblclick="editTasa()"  ng-click="allowEdit()">
                                    <label>Tasa</label>
                                    <input  ng-model="document.tasa"
                                            type="number"
                                            ng-disabled="( formBlock || document.prov_moneda_id == '' ||  !document.prov_moneda_id)"
                                            ng-readonly="isTasaFija"
                                            required
                                            info="Tasa segun la moneda selecionada"
                                            skip-tab
                                            id="tasa"
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="" ng-click="allowEdit()">
                                    <label>Condicion de pago</label>
                                    <md-autocomplete md-selected-item="ctrl.condicion_pago_id"
                                                     ng-disabled="( formBlock  || !provSelec.id)"
                                                     ng-click="toEditHead('condicion_pago_id', document.condicion_pago_id)"
                                                     md-no-ink
                                                     ng-required ="(formMode.value == 23)"
                                                     info="Seleccione una condicion para la realizacion del pago"
                                                     skip-tab
                                                     id="condicion_pago_id"
                                                     md-search-text="ctrl.searchcondPagoSelec"
                                                     md-auto-select="true"
                                                     md-items="item in formData.condicionPago | stringKey : ctrl.searchcondPagoSelec : 'titulo' "
                                                     md-item-text="item.titulo"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                    >
                                        <md-item-template>
                                            <span>{{item.titulo}}</span>
                                        </md-item-template>
                                    </md-autocomplete>
                                    <!--<md-select ng-model="document.condicion_pago_id" ng-disabled="( formBlock  || !provSelec.id)"
                                               ng-change="toEditHead('condicion_pago_id', document.condicion_pago_id)"
                                               md-no-ink
                                               ng-required ="(formMode.value == 23)"
                                               info="Seleccione una condicion para la realizacion del pago"
                                               skip-tab
                                               id="condicion_pago_id"



                                    >
                                        <md-option ng-repeat="conPago in formData.condicionPago" value="{{conPago.id}}" skip-tab>
                                            {{conPago.titulo}}
                                        </md-option>

                                        <md-option  value="-1" >
                                            Nueva Condicion de pago
                                        </md-option>
                                    </md-select>-->
                                </md-input-container>

                            </div>
                            <div ng-show="( gridView != 5 )"  layout="row" class="row" >

                                <md-input-container class="md-block" flex  >
                                    <label>N° Factura:</label>
                                    <input ng-model="document.nro_factura"  ng-disabled="( formBlock)"
                                           ng-change="toEditHead('nro_factura', document.nro_factura)"
                                           info="Introducir Nro de factura en caso de tenerla"
                                           skip-tab



                                    >
                                </md-input-container>
                                <div layout="column" layout-align="center center" ng-click="openAdj('Factura')"
                                     info=" Cargar adjuntos de la factura "

                                >
                                    <span class="icon-Adjuntar" style="font-size: 24px"></span>
                                </div>

                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( formBlock)"
                                           ng-required ="(formMode.value == 22 || formMode.value == 23 )"
                                           ng-change="toEditHead('nro_proforma', document.nro_proforma)"
                                           info="Introducir Nro de proforma en caso de tenerla"
                                           skip-tab

                                    >
                                </md-input-container>
                                <div layout="column" layout-align="center center" ng-click="openAdj('Proforma')"
                                     info="Cargar adjuntos de la proforma "

                                >
                                    <span class="icon-Adjuntar" style="font-size: 24px"></span>

                                </div>
                                <md-input-container class="md-block" flex="10">
                                    <label>Mt3</label>
                                    <input ng-model="document.mt3"  name="mt3"
                                           ng-model="number" decimal
                                           ng-disabled="( formBlock)"
                                           ng-change="toEditHead('mt3', document.mt3)"
                                           info="Metros cubicos"
                                           skip-tab
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="document.peso" name="peso" decimal
                                           ng-disabled="( formBlock)"
                                           ng-change="toEditHead('peso', document.peso)"
                                           info="Sumatoria de los pesos de productos"
                                           skip-tab

                                    >
                                </md-input-container>

                            </div>
<!--                            <div ng-show="( gridView != 5 )"  layout="row" class="row" >



                            </div>-->
                            <div ng-show="( gridView != 5 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Comentario</label>
                                    <input ng-model="document.comentario"  ng-disabled="( formBlock)"
                                           ng-change="toEditHead('nro_proforma', document.nro_proforma)"
                                           info="Algun texto adicional referente al documento"
                                           skip-tab

                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <div ng-show="document.final_id != null || document.version > 1">
                        <form name="FormEstatusDoc"ng-class="{focused: gridView == 2}" layout="row">
                            <div active-left></div>
                            <div></div>
                            <div layout="column" flex >
                                <div layout="row" flex class="row">
                                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-click=" gridView = 2">
                                        <div>
                                            Aprobacion de Gerente
                                        </div>
                                    </div>
                                </div>

                                <div layout="row" ng-show="( gridView == 2 )" class="row" >

                                    <md-input-container class="md-block" flex="">
                                        <label>Estatus</label>
                                        <md-select ng-model="document.estado_id"  ng-disabled="formBlock"
                                                   ng-change="toEditHead('estado_id', document.estado_id)"
                                                   skip-tab
                                                   id="condicion_pago_id"

                                        >
                                            <md-option ng-repeat="item in estadosDoc" value="{{item.id}}" skip-tab>
                                                {{item.estado}}
                                            </md-option>


                                        </md-select>
                                    </md-input-container>

                                </div>
                            </div>

                        </form>
                        <form name="FormAprobCompras" ng-class="{focused: gridView == 3}" layout="row" >
                            <div active-left></div>
                            <div layout="column" flex>
                                <div layout="row" flex class="row" >
                                    <div class="titulo_formulario" layout="column" layout-align="start start" ng-click=" gridView = 3">
                                        <div>
                                            Aprobación
                                        </div>
                                    </div>
                                </div>

                                <div layout="row"  ng-show="( gridView == 3 )"  class="row" >

                                    <div  style="height: 30px;margin-top: 9px;  color: #999999;" >
                                        Fecha de Aprobación
                                    </div>

                                    <div layout="column" flex="20">
                                        <md-datepicker ng-model="document.fecha_aprob_compra" md-placeholder="Fecha"
                                                       ng-disabled="(formBlock)"
                                                       ng-change="toEditHead('fecha_aprob_compra', (document.fecha_aprob_compra) ? document.fecha_aprob_compra.toString(): undefined)"

                                        ></md-datepicker skip-tab>
                                    </div>

                                    <md-input-container class="md-block" flex="20">
                                        <label>N° Documento</label>
                                        <input ng-model="document.nro_doc"  ng-disabled="(formBlock)"
                                               ng-click="toEditHead('nro_doc', document.nro_doc)"
                                               required

                                        >
                                    </md-input-container>

                                    <div layout="column" layout-align="center center" ng-click="openAdj('Factura')"
                                         info=" Cargar adjuntos de la aprobacion " >
                                        <span class="icon-Adjuntar" style="font-size: 24px"></span>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <form name="FormCancelDoc" ng-class="{focused: gridView == 4}" layout="row" >
                            <div active-left></div>
                            <div layout="column" flex>
                                <div layout="row" flex class="row" >

                                    <div class="titulo_formulario" layout="column" layout-align="start start" ng-click=" gridView = 4">
                                        <div>
                                            Cancelacion
                                        </div>
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex  ng-show="( gridView == 4 )" class="row" >
                                    <label>Motivo de cancelacion </label>
                                    <input  ng-model="document.comentario_cancelacion"
                                            ng-disabled="(formBlock)"
                                            id="mtvCancelacion"
                                            ng-change="toEditHead('comentario_cancelacion', document.comentario_cancelacion)"
                                            required

                                    >
                                </md-input-container>

                            </div>
                        </form>
                    </div>
                    <form layout="row" ng-class="{focused: (gridView == 5)}">
                        <div active-left></div>
                        <div layout="row"  flex class="row" >
                            <div layout-align="center center" layout="column">
                                <span style="color: #1f1f1f" ng-show="(document.productos.todos.length > 0 )">
                                        ({{document.productos.todos.length}})</span>
                            </div>
                            <div flex>
                                <div class="titulo_formulario" layout="column" layout-align="start start"  ng-click=" gridView = 5">
                                    <div>
                                        Productos
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-class="{focused: (gridView == 5) }" ng-show="(gridView == 5) ">
                        <div active-left></div>
                        <div layout="row" flex ng-init="tbl_dtDoc.order = 'id' " class="row">
                            <div flex="5">

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl_dtDoc.filter.cod_producto"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_dtDoc.order = 'cod_producto' " ng-class="{'filter-select':(tbl_dtDoc.order == 'cod_producto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_dtDoc.order = '-cod_producto' " ng-class="{'filter-select':(tbl_dtDoc.order == '-cod_producto')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>

                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Descripcion</label>
                                    <input  ng-model="tbl_dtDoc.filter.descripcion"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_dtDoc.order = 'descripcion' " ng-class="{'filter-select':(tbl_dtDoc.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_dtDoc.order = '-descripcion' " ng-class="{'filter-select':(tbl_dtDoc.order == '-descripcion')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Documento</label>
                                    <input  ng-model="tbl_dtDoc.filter.documento"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_dtDoc.order = 'documento' " ng-class="{'filter-select':(tbl_dtDoc.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_dtDoc.order = '-documento' " ng-class="{'filter-select':(tbl_dtDoc.order == '-documento')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cantidad</label>
                                    <input  ng-model="tbl_dtDoc.filter.saldo"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_dtDoc.order = 'saldo' " ng-class="{'filter-select':(tbl_dtDoc.order == 'saldo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_dtDoc.order = '-saldo' " ng-class="{'filter-select':(tbl_dtDoc.order == '-saldo')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                        </div>

                    </form>
                    <form class="gridContent"  layout="row"  ng-show="(gridView == 5) ">
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div ng-repeat="item in filterProdDoc(document.productos.todos,tbl_dtDoc.filter) | orderBy : tbl_dtDoc.order " id="prodDt{{$index}}" row-select>
                                    <div layout="row" class="cellGridHolder" >
                                        <div flex="5" class="cellEmpty">
                                            <md-switch class="md-primary" ng-change="addRemoveItem(item)"
                                                       ng-disabled="( formBlock )" ng-model="item.asignado"> </md-switch>
                                        </div>
                                        <div flex="10" class="cellSelect"> {{item.cod_producto}}</div>
                                        <div flex class="cellGrid">  {{item.descripcion}}</div>
                                        <div flex class="cellGrid"> {{item.documento}}</div>
                                        <md-input-container class="md-block" flex="10" >
                                            <input  ng-model="item.saldo"
                                                    ng-change="changeItem(item)"
                                                    decimal
                                                    ng-disabled="(formBlock || !item.asignado )"
                                                    ng-readonly = "!item.edit"
                                                    ng-click="isEditItem(item)"
                                                    id="prodDtInp{{item.id}}"
                                            />
                                        </md-input-container>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>

                </div>
                <div   id="expand"></div>
                <div style="width: 16px;"   ng-mouseover="showNext(true)"  > </div>
            </md-content>


        </md-sidenav>


        <!--  ########################################## LAYER Agregar Pedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPed" id="agrPed">
            <!-- ) ########################################## Agregar Pedidos ########################################## -->
            <md-content  layout="row" class="sideNavContent" flex ng-init="overSusitu = -1">

                <div active-left></div>
                <div layout="row" flex>
                    <div layout="column" flex>
                        <form>
                            <div class="titulo_formulario md-block"  layout="row"  >

                                <!-- <div style="width: 24px;" layout-align="center center">
                                     <div class="dot-empty dot-exception" ></div>
                                 </div>-->
                                <div>
                                    Contrapedidos
                                </div>


                                <div  ng-click="openSide('agrContPed')" style="width:24px;">
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
                                    ng-click="openSide('agrKitBoxs')"
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
                                    ng-click="openSide('agrPedPend')"

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
                <div  layout="column" flex class="layerColumn" >

                    <form  layout="row">
                        <!----FILTROS ---->
                        <div active-left ></div>
                        <div class="titulo_formulario md-block"  layout="row" >
                            <div>
                                Productos
                            </div>
                        </div>
                    </form>
                    <form name="newProd" layout="row">
                        <!----FILTROS ---->
                        <div active-left ></div>
                        <div layout="column" flex>
                            <div layout="row" class="headGridHolder" ng-init="tbl_listProducProv.order = 'id' ">
                                <div flex="5" class="">
                                    <!--                            <md-switch class="md-primary" ng-model="productoSearch.asignado" ></md-switch>
                                    -->                        </div>

                                <div layout="row" flex="20">
                                    <md-input-container class="md-block"  flex>
                                        <label>Codigo</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl_listProducProv.filter.codigo"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <div class="cell-filter-order" layout-align="center center" >
                                        <div ng-click="tbl_listProducProv.order = 'codigo' " ng-class="{'filter-select':(tbl_listProducProv.order == 'codigo')}"><img src="images/TrianguloUp.png" ></div>
                                        <div ng-click="tbl_listProducProv.order = '-codigo' "ng-class="{'filter-select':(tbl_listProducProv.order == '-codigo')}"><img src="images/TrianguloDown.png" ></div>
                                    </div>
                                </div>

                                <div layout="row" flex="20">
                                    <md-input-container class="md-block" flex>
                                        <label>Cod. Fabrica</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl_listProducProv.filter.codigo_fabrica"
                                               skip-tab

                                        >
                                    </md-input-container>
                                    <div class="cell-filter-order" layout-align="center center" >
                                        <div ng-click="tbl_listProducProv.order = 'codigo_fabrica' " ng-class="{'filter-select':(tbl_listProducProv.order == 'codigo_fabrica')}"><img src="images/TrianguloUp.png" ></div>
                                        <div ng-click="tbl_listProducProv.order = '-codigo_fabrica' "ng-class="{'filter-select':(tbl_listProducProv.order == '-codigo_fabrica')}"><img src="images/TrianguloDown.png" ></div>
                                    </div>
                                </div>
                                <div layout="row" flex >
                                    <md-input-container class="md-block" flex >
                                        <label>Descripcion</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl_listProducProv.filter.descripcion"
                                               skip-tab

                                        >
                                    </md-input-container>
                                    <div class="cell-filter-order" layout-align="center center" >
                                        <div ng-click="tbl_listProducProv.order = 'descripcion' " ng-class="{'filter-select':(tbl_listProducProv.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                        <div ng-click="tbl_listProducProv.order = '-descripcion' "ng-class="{'filter-select':(tbl_listProducProv.order == '-descripcion')}"><img src="images/TrianguloDown.png" ></div>
                                    </div>
                                </div>

                                <div flex="10" ng-disabled="(prodResult && prodResult.length == 0 )">
                                    <md-switch class="md-primary" ng-model="tbl_listProducProv.filter.puntoCompra" ng-disabled="true"></md-switch>
                                </div>

                                <div layout="row" flex="15">
                                    <md-input-container class="md-block" flex>
                                        <label>Cantidad</label>
                                        <input type="text"
                                               ng-model="tbl_listProducProv.filter.saldo"
                                               class="inputFilter"
                                               skip-tab

                                        >
                                    </md-input-container>
                                    <div class="cell-filter-order" layout-align="center center" >
                                        <div ng-click="tbl_listProducProv.order = 'cantidad' " ng-class="{'filter-select':(tbl_listProducProv.order == 'cantidad')}"><img src="images/TrianguloUp.png" ></div>
                                        <div ng-click="tbl_listProducProv.order = '-cantidad' "ng-class="{'filter-select':(tbl_listProducProv.order == '-cantidad')}"><img src="images/TrianguloDown.png" ></div>
                                    </div>
                                    <div style="width: 48px; height: 100%;" ng-click="allowEdit()" layout-align="center center">
                                        <div ng-click="createProduct(tbl_listProducProv.filter)" style="width: 24px;" ng-show="(!formBlock)" ng-disabled="(formBlock)">
                                            <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                                        </div skip-tab >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form name="listProductoItems" class="gridContent"  layout="row" >
                        <div active-left ></div>
                        <div  flex >
                            <div   ng-repeat="item in filterProd(providerProds, tbl_listProducProv.filter) | orderBy : tbl_listProducProv.order"
                                   ng-mouseenter = "mouseEnterProd(item) " row-select>
                                <div layout="row" class="cellGridHolder" >
                                    <div flex="5" class="cellEmpty cellSelect">
                                        <md-switch class="md-primary"  ng-change=" addRemoveProd(item) " ng-disabled="(formBlock)" ng-model="item.asignado"></md-switch>
                                    </div>
                                    <div flex="20" class="cellGrid" > {{item.codigo}}</div>
                                    <div flex="20" class="cellGrid" > {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid" > {{item.descripcion}}</div>
                                    <div flex="10" class="cellGrid" >
                                        <md-switch class="md-primary" ng-disabled="true" ng-model="item.puntoCompra"></md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid">
                                        <input  ng-model="item.saldo" ng-change=" changeProducto(item) "
                                                type="number" range="{{item.asignado}}" minVal="1" maxVal="6"id="p{{item.id}}" ng-disabled="(!item.asignado || formBlock) " />
                                    </div>



                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (6) Agregar Contrapedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrContPed" id="agrContPed">
            <!-- ) ########################################## CONTENDOR Agregar Contrapedidos ########################################## -->
            <md-content layout="row" class="sideNavContent" flex>
                <div  layout="column" flex class="layerColumn" >
                    <form layout="row">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex class="titulo_formulario" layout="Column" layout-align="start start">
                                <div>
                                    Agregar Contrapedidos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tbl_agrContPed.order = 'id' ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5" layout="row"  ></div>

                            <div flex="5" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrContPed.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_agrContPed.order = 'id' " ng-class="{'filter-select':(tbl_agrContPed.order == 'id')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_agrContPed.order = '-id' " ng-class="{'filter-select':(tbl_agrContPed.order == '-id')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrContPed.filter.fecha"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_agrContPed.order = 'fecha' " ng-class="{'filter-select':(tbl_agrContPed.order == 'fecha')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_agrContPed.order = '-fecha' " ng-class="{'filter-select':(tbl_agrContPed.order == '-fecha')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>

                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrContPed.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_agrContPed.order = 'titulo' " ng-class="{'filter-select':(tbl_agrContPed.order == 'titulo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_agrContPed.order = '-titulo' " ng-class="{'filter-select':(tbl_agrContPed.order == '-titulo')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>

                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Entrega</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrContPed.filter.fecha_aprox_entrega"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_agrContPed.order = 'fecha_aprox_entrega' " ng-class="{'filter-select':(tbl_agrContPed.order == 'fecha_aprox_entrega')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_agrContPed.order = '-fecha_aprox_entrega' " ng-class="{'filter-select':(tbl_agrContPed.order == '-fecha_aprox_entrega')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="15" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrContPed.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_agrContPed.order = 'monto' " ng-class="{'filter-select':(tbl_agrContPed.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_agrContPed.order = '-monto' " ng-class="{'filter-select':(tbl_agrContPed.order == '-monto')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>

                            <div flex="" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrContPed.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_agrContPed.order = 'comentario' " ng-class="{'filter-select':(tbl_agrContPed.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_agrContPed.order = '-comentario' " ng-class="{'filter-select':(tbl_agrContPed.order == '-comentario')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <form name="addContraPedidos" class="gridContent" layout="row" >
                        <div active-left></div>
                        <div flex >
                            <div layout="row" class="cellGridHolder" ng-repeat="item in filterContraPed(formData.contraPedido,tbl_agrContPed.filter) | orderBy: tbl_agrContPed.order">
                                <div class="cellEmpty" flex="5" ng-click="allowEdit()">
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
                <div  layout="column" flex class="layerColumn" >
                    <form layout="row" class="focused">
                        <div active-left></div>
                        <div class="titulo_formulario" layout="column" layout-align="start start">
                            <div>
                                Agregar Kitchen Boxs
                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left></div>
                        <div layout="row" flex ng-init="tbl_agrKitBoxs.order = 'id' ">
                            <div flex="5"></div>

                            <div flex="5" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'id' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'id')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-id' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-id')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label> Fecha </label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.fecha"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'fecha' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'fecha')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-fecha' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-fecha')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="15" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma </label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.num_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'num_proforma' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'num_proforma')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-num_proforma' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-num_proforma')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Adjunto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.img_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'img_proforma' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'img_proforma')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-img_proforma' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-img_proforma')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="15" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'monto' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-monto' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="15" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Precio</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.precio"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'precio' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'precio')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-precio' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-precio')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Precio</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrKitBoxs.filter.fecha_aprox_entrega"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrKitBoxs.order = 'fecha_aprox_entrega' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == 'fecha_aprox_entrega')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrKitBoxs.order = '-fecha_aprox_entrega' " ng-class="{'filter-select':(tbl_agrKitBoxs.order == '-fecha_aprox_entrega')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                        </div>

                    </form>
                    <form name="KitchenBoxs" class="gridContent" layout="row">
                        <div active-left></div>
                        <div   layout="column" flex>
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in formData.kitchenBox | filter:tbl_agrKitBoxs.filter:strict | orderBy : tbl_agrKitBoxs.order ">
                                    <div class="cellEmpty" flex="5" ng-click="allowEdit()">
                                        <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeKitchenBox(item)" ng-disabled="(formBlock)"></md-switch>
                                    </div>
                                    <div flex="5" class="cellGrid"  ng-click="selecKitchenBox(item)"> {{item.id}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.fecha | date:'dd/MM/yyyy'}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.num_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.img_proforma}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.monto}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.precio}}</div>
                                    <div flex class="cellGrid"  ng-click="selecKitchenBox(item)" > {{item.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
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
                <div layout="column" flex>
                    <form layout="row" class="focused">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div class="titulo_formulario" layout="Column" layout-align="start start">
                                <div>
                                    {{formMode.name}} Pendientes
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5"></div>
                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrPedPend.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrPedPend.order = 'id' " ng-class="{'filter-select':(tbl_agrPedPend.order == 'id')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrPedPend.order = '-id' " ng-class="{'filter-select':(tbl_agrPedPend.order == '-id')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrPedPend.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrPedPend.order = 'nro_proforma' " ng-class="{'filter-select':(tbl_agrPedPend.order == 'nro_proforma')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrPedPend.order = '-nro_proforma' " ng-class="{'filter-select':(tbl_agrPedPend.order == '-nro_proforma')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrPedPend.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrPedPend.order = 'emision' " ng-class="{'filter-select':(tbl_agrPedPend.order == 'emision')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrPedPend.order = '-emision' " ng-class="{'filter-select':(tbl_agrPedPend.order == '-emision')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="15" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrPedPend.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrPedPend.order = 'nro_factura' " ng-class="{'filter-select':(tbl_agrPedPend.order == 'nro_factura')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrPedPend.order = '-nro_factura' " ng-class="{'filter-select':(tbl_agrPedPend.order == '-nro_factura')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrPedPend.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrPedPend.order = 'monto' " ng-class="{'filter-select':(tbl_agrPedPend.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrPedPend.order = '-monto' " ng-class="{'filter-select':(tbl_agrPedPend.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_agrPedPend.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_agrPedPend.order = 'comentario' " ng-class="{'filter-select':(tbl_agrPedPend.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_agrPedPend.order = '-comentario' " ng-class="{'filter-select':(tbl_agrPedPend.order == '-comentario')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                        </div>

                    </form>
                    <form name="gridPagosPendientes"  class="gridContent" layout="row" >
                        <div active-left></div>
                        <div  layout="column" flex>
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in docsSustitos | filter:tbl_agrPedPend.filter:strict | orderBy: tbl_agrPedPend.order " >
                                    <div flex="5" class="cellEmpty" ng-click="allowEdit()">
                                        <md-switch class="md-primary" ng-model="item.asignado"
                                                   ng-change="changePedidoSustituto(item)"
                                                   ng-disabled="(formBlock)"></md-switch>
                                    </div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.id}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.nro_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.emision | date:'dd/MM/yyyy'}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.nro_factura}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.monto}}</div>
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
                                    <md-select ng-model="provSelec.id" ng-disabled="true"

                                    >
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
                                        <md-option ng-repeat="item in formDataContraP.tipoEnvio" value="{{item.id}}">
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
                                        <md-option ng-repeat="item in formData.monedas" value="{{item.id}}">
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
                                <div layout="row" class="headGridHolder" table="tbl_resumenContraPedido">

                                    <div flex="5" class="cellGrid">

                                    </div>
                                    <div flex="15" class="headGrid" orderBy="asignado" > Codigo</div>
                                    <div flex class="headGrid" orderBy="codigo"> Cod. Fabrica</div>
                                    <div flex class="headGrid" orderBy="codigo_fabrica"> Descripción.</div>
                                    <div flex="10" class="headGrid" orderBy="saldo"> Cantidad</div>
                                    <div flex class="headGrid" orderBy="comentario"> Comentario</div>
                                    <div flex class="headGrid" orderBy="adjunto"> Adjunto</div>
                                </div>
                                <div class="gridContent">
                                    <div flex>
                                        <div layout="row" class="cellGridHolder" ng-repeat="item in contraPedSelec.productos | orderBy : tbl_resumenContraPedido ">
                                            <div flex="5" class="cellEmpty">
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



                <form name="resumenContraPed" layout="row" flex>
                    <div active-left> </div>
                    <div  layout="column" flex class="layerColumn" >
                        <div class="titulo_formulario" layout="Column" layout-align="start start">
                            <div>
                                Resumen de Kitchen Box
                            </div>
                        </div>
                        <div layout="row" >

                            <md-input-container class="md-block" flex="10">
                                <label>Nº</label>
                                <input  ng-model="kitchenBoxSelec.id" ng-disabled="true">
                            </md-input-container>

                            <div layout="column" flex="15">
                                <md-datepicker ng-model="kitchenBoxSelec.fecha" md-placeholder="Fecha" ng-disabled="true"></md-datepicker>
                            </div>

                            <md-input-container class="md-block" flex>
                                <label>Fabrica</label>
                                <md-select ng-model="kitchenBoxSelec.prov_id" ng-disabled="true">
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
                            <div style="width: 40px;">
                                <?= HTML::image("images/adjunto.png",'null', array('id' => 'imgAdj')) ?>

                            </div>

                            <md-input-container class="md-block" flex>
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
                    </div>
                </form>

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

                            <div layout="row" class="headGridHolder" table="tbl_resumenPedidoSus">
                                <div flex="5" class="headGrid" orderBy="asignado" ></div>
                                <div flex="15" class="headGrid" orderBy="codigo"> Codigo </div>
                                <div flex="15" class="headGrid" orderBy="codigo_fabrica"> Cod. Fabrica </div>
                                <div flex class="headGrid" orderBy="documento"> Origen</div>
                                <div flex class="headGrid" orderBy="descripcion"> Descripción.</div>
                                <div flex="10" class="headGrid" orderBy="saldo"> Cantidad</div>
                                <div flex class="headGrid" orderBy="comentario"> Comentario</div>
                                <!--<div flex class="headGrid"> Adjunto</div>-->
                            </div>
                            <div  class="gridContent">
                                <div flex>
                                    <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSusPedSelec.productos | orderBy :tbl_resumenPedidoSus ">
                                        <div flex="5" class="cellEmpty" >
                                            <md-switch class="md-primary"
                                                       ng-disabled="( formBlock )" ng-model="item.asignado">
                                            </md-switch>
                                        </div>
                                        <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                        <div flex="15" class="cellGrid">  {{item.codigo_fabrica}}</div>
                                        <div flex class="cellGrid"> {{item.documento}}</div>
                                        <div flex class="cellGrid">  {{item.descripcion}}</div>
                                        <div flex="10" class="cellGrid">{{item.saldo}}</div>
                                        <div flex class="cellGrid">  {{item.comentario}}</div>
                                        <!-- <div flex class="cellGrid">  {{item.adjunto}}</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div layout="column" ng-show="pedidoSusPedSelec.productos >0 && gridViewSus == 1 " class="showMoreDiv" style="height: 40px" ng-click=" gridViewSus = 2" >
                        <div flex style="border: dashed 1px #f1f1f1; text-align: center">ver mas ({{contraPedSelec.productos.length}})</div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!--  ##########################################  FINAL DOCUMENTO########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="finalDoc" id="finalDoc">
            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" id="headFinalDoc"  ng-class="{preview: isOpenexcepAddCP }">
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
                                    <div flex="40"> ID: </div>
                                    <div flex> {{document.id}} </div>
                                </div>
                                <div layout="row" class="rms" flex >
                                    <div flex="40" > Version: </div>
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
                                <div class="rms" flex> {{document.titulo  }}</div>
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
                                <div  class="rms" > {{finalDoc.ult_revision | date:'dd/MM/yyyy' }}</div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="gridViewFinalDoc == 1">
                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'created' && finalDoc.estado_id.trace-length > 0"  layout-align="center center" >
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
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.prioridad_id.estado == 'created'"
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
                                <div class="rowRsmTitle" flex="40"> Proveedor: </div>
                                <div  class="rms" flex > {{document.proveedor}} </div>
                            </div>
                            <div layout="row" class="rowRsm" ng-show="(document.pais_id && gridViewFinalDoc == 1)" >
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.pais_id.estado == 'created' && finalDoc.pais_id.trace.length"
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.pais_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Pais </div>
                                </div>
                                <div class="rms" flex> {{document.pais}} </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="(document.direccion_almacen_id && gridViewFinalDoc == 1)">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.direccion_almacen_id.estado == 'created'"
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
                            <div layout="row"  class="rowRsm" ng-show="( gridViewFinalDoc == 1 && (document.nro_proforma ||finalDoc.adjProforma.length > 0 ))" >
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
                                    <div>{{document.nro_proforma}}</div>
                                    <div class="circle" ng-click="openAdj('proforma')" ng-show="finalDoc.adjProforma.length > 0">{{finalDoc.adjProforma.length}}</div>
                                </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="( gridViewFinalDoc == 1 && ( document.nro_factura || finalDoc.adjFactura.length > 0) )">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.nro_factura.estado == 'created'"
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
                                    <div class="circle"  ng-click="openAdj('factura')" ng-show="finalDoc.adjFactura.length > 0" >{{finalDoc.adjFactura.length}}</div>

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
                            <!-- <div layout="row"  class="rowRsm" ng-show="(document.productos.todos.length > 0  && gridViewFinalDoc == 1)">
                                 <div class="rowRsmTitle" flex="40"> Productos: </div>
                                 <div class="rms" flex> {{document.productos.todos.length}} </div>
                             </div>-->
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
                                <md-content style="margin: 4px;">

                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.contraPedido" layout-align="space-between center" >
                                        <div layout="row"  flex="40">
                                            <div  layout="column" ng-show="item.id.estado == 'new' && item.id.trace.length > 0"
                                                  layout-align="center center">
                                                <span class="icon-Agregar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                                <span class="icon-Actualizar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                                <span class="icon-Eliminar" style="font-size: 16px"></span>
                                            </div>
                                            <div>{{item.id.v}}</div>
                                        </div>

                                        <div  flex>{{item.titulo.v}}</div>
                                    </div>
                                </md-content>
                            </div>
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
                                <md-content style="margin: 4px;">

                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.kitchenBox" layout-align="space-between center" >
                                        <div layout="row"  flex="40">
                                            <div  layout="column" ng-show="item.id.estado == 'new' && item.id.trace.length > 0"
                                                  layout-align="center center">
                                                <span class="icon-Agregar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                                <span class="icon-Actualizar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                                <span class="icon-Eliminar" style="font-size: 16px"></span>
                                            </div>
                                            <div>{{item.id.v}}</div>
                                        </div>

                                        <div  flex>{{item.titulo.v}}</div>
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
                                <md-content style="margin: 4px;">

                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.pedidoSusti" layout-align="space-between center" >
                                        <div layout="row"  flex="40">
                                            <div  layout="column" ng-show="item.id.estado == 'new' && item.id.trace.length > 0"
                                                  layout-align="center center">
                                                <span class="icon-Agregar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                                <span class="icon-Actualizar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                                <span class="icon-Eliminar" style="font-size: 16px"></span>
                                            </div>
                                            <div>{{item.id.v}}</div>
                                        </div>

                                        <div  flex>{{item.titulo.v}}</div>
                                    </div>
                                </md-content>
                            </div>

                        </div>
                    </form>
                </div>
                <div flex layout="column">
                    <form layout="row" class="focused">
                        <div flex layout="row">
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Productos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tbl_finalDoc.order = 'codigo'">
                        <div layout="row" flex>
                            <div flex="20" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Codigo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_finalDoc.filter.codigo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_finalDoc.order = 'codigo' " ng-class="{'filter-select':(tbl_finalDoc.order == 'codigo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_finalDoc.order = '-codigo' " ng-class="{'filter-select':(tbl_finalDoc.order == '-codigo')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="20" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Cod. Fabrica</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_finalDoc.filter.codigo_fabrica"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_finalDoc.order = 'codigo_fabrica' " ng-class="{'filter-select':(tbl_finalDoc.order == 'codigo_fabrica')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_finalDoc.order = '-codigo_fabrica' " ng-class="{'filter-select':(tbl_finalDoc.order == '-codigo_fabrica')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Descripion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_finalDoc.filter.descripcion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_finalDoc.order = 'descripcion' " ng-class="{'filter-select':(tbl_finalDoc.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_finalDoc.order = '-descripcion' " ng-class="{'filter-select':(tbl_finalDoc.order == '-descripcion')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>

                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Cantidad</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_finalDoc.filter.cantidad"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_finalDoc.order = 'cantidad' " ng-class="{'filter-select':(tbl_finalDoc.order == 'cantidad')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_finalDoc.order = '-cantidad' " ng-class="{'filter-select':(tbl_finalDoc.order == '-cantidad')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div  style="width: 80px;" ng-show="formMode.value == 23" ></div>

                        </div>
                    </form>
                    <form layout="row"  class="gridContent">
                        <div  layout="column" flex>
                            <div flex >
                                <div  ng-repeat="item in finalDoc.productos | filter:tbl_finalDoc.filter:strict |orderBy : tbl_finalDoc  "  >
                                    <div layout="row" class="cellGridHolder" >
                                        <div flex="20" class="cellSelect" ng-class="{'cellSelect':( finalProdSelec.id  != item.id) ,'cellSelect-select':(finalProdSelec.id  == item.id )}" > {{item.codigo}}</div>
                                        <div flex="20" class="cellGrid" > {{item.codigo_fabrica}}</div>
                                        <div flex class="cellGrid" > {{item.descripcion}}</div>
                                        <div flex="15" class="cellGrid">{{item.cantidad | number:2}}</div>
                                        <div style="width: 80px;"  class="cellEmpty " ng-show="formMode.value == 23"
                                             layout-align="center center" layout="column" ng-click="excepProdFinal(item)">
                                            <div class="dot-empty dot-attachment "  layout-align="center center" >
                                                <div style=" margin-top: 2.5px;">   {{item.condicion_pago.length}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
                <!--   <form layout="row" flex  >
                       <div active-left ng-show="isOpenexcepAddCP"> </div>
                       <div layout="column" flex>
                           <div class="titulo_formulario" style="height:39px;" ng-click=" gridViewFinalDoc = 1">
                               <div>
                                   Productos
                               </div>
                           </div>
                           <div flex layout="column">
                            <div flex class="gridContent" >
                                   <div flex >

                                   </div>

                               </div>

                           </div>
                       </div>
                   </form>-->

                <div   id="expand"></div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER LISTA DE DOCUMENTOS SIN FINALIZAR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="unclosetDoc" id="unclosetDoc">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >

                <div  layout="column" flex="" class="layerColumn">
                    <form layout="row" class="focused">
                        <div active-left  before="verificExit" ></div>
                        <div  layout="row" flex>
                            <div class="titulo_formulario" style="height: 39px; margin-left: 24px;">
                                <div>
                                    Documentos sin finalizar
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left  before="verificExit" ></div>
                        <div flex layout="row">
                            <div layout="row" style="width: 80px;">
                                <md-input-container class="md-block"  flex>
                                    <md-select ng-model="tbl_unclosetDoc.filter.documento" ng-init="tbl_unclosetDoc.filter.documento ='-1'">

                                        <md-option value="-1" layout="row">
                                            <img src="images/Documentos.png" style="width:20px;">
                                        </md-option>
                                        <md-option value="21" layout="row" >
                                            <img src="images/solicitud_icon_48x48.gif" style="width:20px;">
                                        </md-option>
                                        <md-option value="22" layout="row">
                                            <img src="images/proforma_icon_48x48.gif" style="width:20px;">

                                        </md-option>
                                        <md-option value="23" layout="row">
                                            <img src="images/odc_icon_48x48.gif" style="width:20px;">
                                        </md-option>
                                    </md-select>

                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_unclosetDoc.order = 'documento' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_unclosetDoc.order = '-documento' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-documento')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="5" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_unclosetDoc.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_unclosetDoc.order = 'id' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'id')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_unclosetDoc.order = '-id' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-id')}"><img src="images/TrianguloDown.png"/></div>
                                </div>


                            </div>

                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_unclosetDoc.filter.proveedor"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_unclosetDoc.order = 'proveedor' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'proveedor')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_unclosetDoc.order = '-proveedor' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-proveedor')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_unclosetDoc.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_unclosetDoc.order = 'titulo' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'titulo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_unclosetDoc.order = '-titulo' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-titulo')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_unclosetDoc.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_unclosetDoc.order = 'emision' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'emision')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_unclosetDoc.order = '-emision' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-emision')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_unclosetDoc.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_unclosetDoc.order = 'monto' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_unclosetDoc.order = '-monto' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_unclosetDoc.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_unclosetDoc.order = 'comentario' " ng-class="{'filter-select':(tbl_unclosetDoc.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_unclosetDoc.order = '-comentario' " ng-class="{'filter-select':(tbl_unclosetDoc.order == '-comentario')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                        </div>
                    </form>

                    <form layout="row"  class="gridContent">
                        <div active-left  before="verificExit" ></div>
                        <div layout="column" flex>
                            <div  flex >
                                <div   ng-repeat="item in filterDocuments(unclosetDoc ,tbl_unclosetDoc.filter) | orderBy : tbl_unclosetDoc.order " ng-click="openTempDoc(item)" row-select >
                                    <div layout="row" class="cellGridHolder" >
                                        <div style="width: 80px;" class="cellEmpty cellSelect"  ng-mouseover="hoverPreview(true)" tabindex="{{$index + 1}}">
                                            <div>
                                                <div layout-align="center center"  style="text-align: center;     margin-left: 12px;">
                                                    <img style="width: 20px;" ng-src="{{transforDocToImg(item.documento)}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div flex="5" class="cellSelect"  tabindex="{{$index + 1}}" > {{item.id}}</div>
                                        <!-- <div flex="15" class="cellGrid"> {{item.documento}}</div>-->
                                        <div flex class="cellGrid"> {{item.proveedor}}</div>
                                        <div flex class="cellGrid" > {{item.titulo}}</div>
                                        <div flex="10" class="cellGrid" > {{item.emision| date:'dd/MM/yyyy' }}</div>
                                        <div flex class="cellGrid" > {{item.monto | currency :item.symbol :2}}</div>
                                        <div flex class="cellGrid" >{{item.comentario}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>


                </div>
            </md-content>
        </md-sidenav>


        <!-- ########################################## LAYER LISTA DE DOCUMENTOS con prioridad alta ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="priorityDocs" id="priorityDocs">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" flex>
                    <form layout="row">
                        <div active-left  before="verificExit" ></div>
                        <div layout="row" flex>
                            <div class="titulo_formulario" style="height: 39px;">
                                <div>
                                    Documentos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left  before="verificExit" ></div>
                        <div layout="row" flex>
                            <div layout="row" style="width: 80px;">
                                <md-input-container class="md-block"  flex>
                                    <md-select ng-model="tbl_priorityDocs.filter.documento" ng-init="tbl_priorityDocs.filter.documento ='-1'">

                                        <md-option value="-1" layout="row">
                                            <img src="images/Documentos.png" style="width:20px;">
                                        </md-option>
                                        <md-option value="21" layout="row" >
                                            <img src="images/solicitud_icon_48x48.gif" style="width:20px;">
                                        </md-option>
                                        <md-option value="22" layout="row">
                                            <img src="images/proforma_icon_48x48.gif" style="width:20px;">

                                        </md-option>
                                        <md-option value="23" layout="row">
                                            <img src="images/odc_icon_48x48.gif" style="width:20px;">
                                        </md-option>
                                    </md-select>

                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_priorityDocs.order = 'documento' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_priorityDocs.order = '-documento' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-documento')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>

                            <div flex="5" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_priorityDocs.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_priorityDocs.order = 'id' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'id')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_priorityDocs.order = '-id' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-id')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_priorityDocs.filter.proveedor"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_priorityDocs.order = 'proveedor' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'proveedor')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_priorityDocs.order = '-proveedor' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-proveedor')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_priorityDocs.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_priorityDocs.order = 'titulo' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'titulo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_priorityDocs.order = '-titulo' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-titulo')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_priorityDocs.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_priorityDocs.order = 'emision' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'emision')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_priorityDocs.order = '-emision' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-emision')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_priorityDocs.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_priorityDocs.order = 'monto' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_priorityDocs.order = '-monto' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_priorityDocs.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_priorityDocs.order = 'comentario' " ng-class="{'filter-select':(tbl_priorityDocs.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_priorityDocs.order = '-comentario' " ng-class="{'filter-select':(tbl_priorityDocs.order == '-comentario')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div style="width: 80px;"   ></div>

                        </div>

                    </form>
                    <form layout="row" class="gridContent">
                        <div active-left  before="verificExit" ></div>
                        <div layout="column" flex>
                            <div flex>
                                <div ng-repeat="item in filterDocuments(priorityDocs, tbl_priorityDocs.filter) | orderBy : tbl_priorityDocs.order "  row-select>
                                    <div layout="row" class="cellGridHolder" >

                                        <div style="width: 80px;" ng-click="openTempDoc(item)" class="cellEmpty cellSelect" tabindex="{{$index + 1}}">
                                            <div>
                                                <div layout-align="center center"  style="text-align: center;     margin-left: 12px;">
                                                    <img style="width: 20px;" ng-src="{{transforDocToImg(item.documento)}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div flex="5" class="cellSelect" ng-click="openTempDoc(item)"
                                             ng-class="{'cellGrid':( addAnswer.doc_id  != item.id) ,'cellSelect-select':(addAnswer.doc_id  == item.id )}"
                                             tabindex="{{$index + 1}}"
                                        > {{item.id}}</div>
                                        <div flex class="cellGrid" ng-click="openTempDoc(item)"> {{item.proveedor}}</div>
                                        <div flex class="cellGrid" ng-click="openTempDoc(item)" > {{item.titulo}}</div>
                                        <div flex="10" class="cellGrid" ng-click="openTempDoc(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                        <div flex class="cellGrid" ng-click="openTempDoc(item)" > {{item.monto | currency :item.symbol :2}}</div>
                                        <div flex class="cellGrid"  ng-click="openTempDoc(item)" >{{item.comentario}}</div>
                                        <div style="width: 80px;"  class="cellEmpty " ng-click="sideaddAnswer(this, item)"
                                             layout-align="center center" layout="column" >
                                            <div class="dot-empty dot-attachment "  layout-align="center center" >
                                                <div style=" margin-top: 2.5px;">  M</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div id="expand"></div>
            </md-content>
        </md-sidenav>


        <!-- ########################################## LAYER LISTA DE PREVIEW HYML ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="htmlViewer" id="htmlViewer">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <div active-left   ></div>

                <div  layout="column" flex="" class="layerColumn" style="padding: ">
                    <div contenteditable ng-model="previewHtmltext " style="min-height: 48px" > Texto adicional </div>


                    <div ng-bind-html="previewHtmlDoc" flex="">
                    </div>
                </div>
            </md-content>
        </md-sidenav>


        <!-- ########################################## LAYER exception AGREGAR CONDICION DE PAGO ########################################## -->

        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="excepAddCP" id="excepAddCP"

        >

            <md-content   layout="row" flex class="sideNavContent" >
                <div  layout="column" flex="" class="layerColumn"   click-out="closeExcep($event)">
                    <form layout="row" >
                        <div class="activeleft "></div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" >
                                <div>
                                    Condicion de pago del Producto
                                </div>
                            </div>
                            <div layout="row"  class="rowRsm"  >
                                <div layout="row" flex="30" >

                                    <div class="rowRsmTitle"> Codigo </div>
                                </div>
                                <div class="rms" flex> {{finalProdSelec.codigo}} </div>
                            </div>

                            <div layout="row"  class="rowRsm"  >
                                <div layout="row" flex="30" >

                                    <div class="rowRsmTitle"> Cod. Fabrica </div>
                                </div>
                                <div class="rms" flex> {{finalProdSelec.codigo_fabrica}} </div>
                            </div>
                            <div layout="row"  class="rowRsm"  >
                                <div layout="row" flex="30" >

                                    <div class="rowRsmTitle"> Descripción </div>
                                </div>
                                <div class="rms" flex> {{finalProdSelec.descripcion}} </div>
                            </div>
                            <div layout="row"  class="rowRsm"  >
                                <div layout="row" flex="30" >

                                    <div class="rowRsmTitle"> Cantidad </div>
                                </div>
                                <div class="rms" flex> {{finalProdSelec.cantidad | number: 2}} </div>
                            </div>
                        </div>
                    </form>
                    <form name="formExcepAddCP" layout="row" >
                        <div class="activeleft "></div>

                        <md-input-container class="md-block" flex="30" >
                            <label>Cantidad</label>
                            <input ng-model="excepAddCP.cantidad"
                                   decimal
                                   info="Cantidad de articulos en la que se aplicara la condición de pago"
                                   required
                                   skip-tab
                            />
                        </md-input-container>

                        <md-input-container class="md-block" flex="30" >
                            <label>Dias</label>
                            <input ng-model="excepAddCP.dias"
                                   decimal
                                   info="Numero de dias en que se debe realizar el pago"
                                   required
                                   skip-tab
                            />
                        </md-input-container>

                        <md-input-container class="md-block" flex >
                            <label>Monto</label>
                            <input ng-model="excepAddCP.monto"
                                   decimal info="Monto en que se debe pagar"
                                   required
                                   skip-tab
                                   ng-keypress="($event.which === 13)? addexcepProdFinal(): 0 "

                            />
                        </md-input-container>
                    </form>

                    <form layout="row" name="gridExcepProdFinal"  >
                        <div class="activeleft"></div>
                        <md-content flex  >
                            <div ng-repeat="item in finalProdSelec.condicion_pago" ng-click="removeExcepProdFinal(this)"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex="35" class="cellGrid" >{{item.cantidad}} </div>
                                    <div flex="33" class="cellGrid"> {{item.dias}}</div>
                                    <div flex class="cellGrid"> {{item.monto}}</div>
                                </div>
                            </div>

                        </md-content>

                    </form>
                </div>


            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER exception  respuesta ########################################## -->

        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="addAnswer" id="addAnswer"

        >

            <md-content   layout="row" flex class="sideNavContent" class="cntLayerHolder" layout-padding >
                <div  layout="column" flex="" class="layerColumn"   click-out="closeAddAnswer($event)">


                    <div layout="row" style="min-height: 36px;" ng-init="addAnswerMode == 1">
                        <div class="titulo_formulario" layout="column" flex layout-align="start start">
                            <div>
                                Respuesta del proveedor
                            </div>
                        </div>

                    </div>
                    <div flex style="overflow: auto;">
                        <form flex layout="column" name="formAnswerDoc">
                            <div  >
                                <md-input-container class="md-block" flex >
                                <textarea ng-model="addAnswer.descripcion"
                                          info="Por favor ingrese un texto que describa la conclusion que se llego con el proveedor "
                                          required
                                          id="textarea"
                                ></textarea>

                                </md-input-container>

                            </div>

                        </form>
                    </div>
                    <div style="height: : '{{ !(addAnswer.adjs) ? 0 : (20 * addAnswer.adjs.length) }}px'">
                        <div layout="row" layout-align="center space-between" style="border: 1px solid rgb(84, 180, 234);"
                             ngf-drop ngf-select  ng-model="answerfiles"
                             ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="AnswerfileInput"

                        >
                            <div  class="vlc-buttom" style="margin-top: 0; background-color: rgb(84, 180, 234); ">{{addAnswer.adjs.length}}</div>
                            <div flex layout-align=" center start " layout="column">Adjuntos</div>
                            <div style="width: 16px"  layout-align=" center left " layout="column"></div>
                        </div>
                    </div>
                </div>

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
            ng-mouseleave="showNext(false)" ng-click="next()" >
            <?= HTML::image("images/btn_nextArrow.png") ?>
        </md-sidenav>


        <!------------------------------------------- Alertas ------------------------------------------------>
        <div ng-controller="notificaciones" ng-include="template"></div>
        <!------------------------------------------- files ------------------------------------------------>

        <div ng-controller="FilesController" ng-include="template"></div>

    </div>
</div>

