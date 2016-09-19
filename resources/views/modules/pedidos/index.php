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
                    <md-tooltip md-direction="right">
                        Click para desplegar opciones
                    </md-tooltip>
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
                <div class="boxList"  layout="column" flex ng-repeat="item in todos | orderBy : 'prioridad' "  list-box ng-click="setProvedor(item, this)" ng-init="item.order = 1"
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

            <div class="botonera" layout="row" layout-align="space-between center">
                <div style="width: 240px;" layout="row">
                    <div layout="column" layout-align="center center"></div>

                    <div layout="column" ng-show="(module.index < 1 || module.layer == 'listPedido' )" layout-align="center center" ng-click="menuAgregar()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Crear un nuevo documento
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && Docsession.block && !document.aprob_gerencia && !document.aprob_compras && document.id )" ng-click="updateForm()">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Actualizar la  {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && document.estado_id != 3 && document.id)"
                         ng-click="cancelDoc()">
                        <span class="icon-Eliminar" style="font-size: 24px"></span>
                        <md-tooltip>
                            Cancelar la {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="( document.id && Docsession.isCopyableable )"
                         ng-click="copyDoc()">
                        <span class="icon-Copiado" style="font-size: 24px"> </span>
                        <md-tooltip >
                            Crear una copia de la {{formMode.name}} (Sin adjuntos)
                        </md-tooltip>
                    </div>

                    <div layout="column" layout-align="center center"
                         ng-show="( document.id &&  document.version && document.version > 1  )"
                         ng-click="openVersions()">
                        <span style="font-size: 24px"> OLD </span>
                        <md-tooltip >
                            Ver las versiones anteriores de la {{formMode.name}}
                        </md-tooltip>
                    </div>

                </div>
                <!-- ########################################## FILTROS CABECERA ########################################## -->

                <div layout="row" flex layout-align="start center ">

                </div>
                <div style="width: 48px;" layout="column"   layout-align="center center" id="noti-button" >
                    <div class="{{(alerts.length > 0 ) ? 'animation-arrow' : 'animation-arrow-disable'}}" ng-click="openNotis()" id="noti-button"
                         layout="column" layout-align="center center"  style=text-align:center; >
                        <img src="images/btn_prevArrow.png" style="width: 14px;margin-top: 8px;" />
                    </div>
                    <md-tooltip>
                        {{alerts.length > 0 ? 'Tiene notificaciones pendiente por revisar, haz click aqui para verlas' : 'Sin Notificaciones por revisar, gracias por estar pendiente '}}
                    </md-tooltip>
                </div>
            </div>


            <div flex layout="row">
                <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center" ng-click="closeSide()">
                    <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
                    <?= HTML::image("images/btn_prevArrow.png","",array("ng-show"=>"(module.index >0)")) ?>
                </div>

                <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
                <div layout="column" flex >
                    <div  layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22); width: 100%; height: 100%;">
                        <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                            D
                        </div>
                        <br> DashBoard
                    </div>
                </div>

            </div>
        </div>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listImport" id="listImport">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" flex>
                    <form layout="row" class="focused">
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
                            <div flex layout="row" >
                                <md-input-container flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_listImport.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_listImport.order = 'titulo' " ng-class="{'filter-select':(tbl_listImport.order == 'titulo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-titulo' " ng-class="{'filter-select':(tbl_listImport.order == '-titulo')}"><img src="images/TrianguloDown.png"/></div>
                                </div>
                            </div>
                            <div flex="15" layout="row" >
                                <md-input-container flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_listImport.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_listImport.order = 'nro_proforma' " ng-class="{'filter-select':(tbl_listImport.order == 'nro_proforma')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-nro_proforma' " ng-class="{'filter-select':(tbl_listImport.order == '-nro_proforma')}"><img src="images/TrianguloDown.png"/></div>
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
                                    <div ng-click="tbl_listImport.order = 'emision' " ng-class="{'filter-select':(tbl_listImport.order == 'emision')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-emision' " ng-class="{'filter-select':(tbl_listImport.order == '-emision')}"><img src="images/TrianguloDown.png"/></div>
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
                                    <div ng-click="tbl_listImport.order = 'diasEmit' " ng-class="{'filter-select':(tbl_listImport.order == 'diasEmit')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-diasEmit' " ng-class="{'filter-select':(tbl_listImport.order == '-diasEmit')}"><img src="images/TrianguloDown.png"/></div>
                                </div>
                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl_listImport.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_listImport.order = 'nro_factura' " ng-class="{'filter-select':(tbl_listImport.order == 'nro_factura')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-nro_factura' " ng-class="{'filter-select':(tbl_listImport.order == '-nro_factura')}"><img src="images/TrianguloDown.png"/></div>
                                </div>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl_listImport.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div  ng-click="tbl_listImport.order = 'monto' " ng-class="{'filter-select':(tbl_listImport.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-monto' " ng-class="{'filter-select':(tbl_listImport.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
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
                                    <div  ng-click="tbl_listImport.order = 'comentario' " ng-class="{'filter-select':(tbl_listImport.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_listImport.order = '-comentario' " ng-class="{'filter-select':(tbl_listImport.order == '-comentario')}"><img src="images/TrianguloDown.png"/></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form  flex layout="row"  class="gridContent">
                        <div active-left before="verificExit" ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in filterDocuments(docImports, tbl_listImport.filter) | orderBy : tbl_listImport.order" >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="docImport(item)"> {{item.titulo}}</div>
                                    <div flex="15" class="cellGrid" ng-click="docImport(item)"> {{item.nro_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="docImport(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                    <div  style="width: 80px;text-align: -webkit-center; "class="cellGrid" ng-click="docImport(item)">
                                        <div style="width: 16px; height: 16px; border-radius: 50%"
                                             class="emit{{item.diasEmit}}"></div>                                    </div>
                                    <div flex="15" class="cellGrid" ng-click="docImport(item)" > {{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)" > {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)" >{{item.comentario}}</div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
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
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div layout="column" flex="" ng-mouseleave="hoverLeave(false)"  >
                            <div   ng-repeat="item in filterDocuments(provDocs, docOrder.filter) | orderBy : docOrder.order "   id="doc{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div  class=" cellEmpty" ng-mouseover="hoverpedido(item)"  ng-mouseenter="hoverEnter()" ng-mouseleave="hoverLeave(false)"  ng-click="DtPedido(item)"> </div>
                                    <div style="width: 80px;" class="cellEmpty cellSelect"  ng-mouseover="hoverPreview(true)" tabindex="{{$index + 1}}">

                                        <div layout-align="center center"  style="text-align: center; width: 100%; ">
                                            <img style="width: 20px;" ng-src="{{transforDocToImg(item.documento)}}" />
                                        </div>

                                    </div>
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
                                    <div flex class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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
                <div style="width: 96px" layout="column" layout-align="space-between start">
                    <div class="docButton" layout="column" flex  ng-click="openEmail()">
                        <img src="images/mail_icon_48x48.gif" width="48" height="48"/>
                        <md-tooltip md-direction="right">
                            Correo
                        </md-tooltip>

                    </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.solicitud)">
                        <img src="images/solicitud_icon_48x48.gif" width="48" height="48"/>
                        <md-tooltip md-direction="right">
                            Solicitud
                        </md-tooltip>
                    </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.proforma)">
                        <img src="images/proforma_icon_48x48.gif"  width="48" height="48"/>
                        <md-tooltip md-direction="right">
                            Proforma
                        </md-tooltip>
                    </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.odc)">
                        <img src="images/odc_icon_48x48.gif"  width="48" height="48"/>
                        <md-tooltip md-direction="right" >
                            Orden de Compra
                        </md-tooltip>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER EMAIL ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; font-family: Roboto, 'Helvetica Neue', sans-serif;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="email" id="email">
            <!--  ########################################## CONTENDOR  EMAIL ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" ng-controller="MailCtrl">
                <div  layout="column" flex >
                    <form name="mail" layout="row" flex class="focused">
                        <div active-left ></div>
                        <div layout="column" flex style="padding-right: 4px;">
                            <div layout="row" >
                                <div class="titulo_formulario">
                                    <div>
                                        Envio de Correo
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start" class="mail-option">

                                    <div layout="row" style="width: 28px" ng-click=" showHead = !showHead " >
                                        <span>{{(showHead) ? '/' : '()'}}</span>
                                    </div>
                                    <div layout="row" style="width: 20px" ng-click="showCc = !showCc ; showHead = true ;"   ng-class="{'mail-option-select': (showCc) }">
                                        Cc
                                    </div>
                                    <div layout="row" style="width: 28px" ng-click="showCco = !showCco ;showHead = true ; "  ng-class="{'mail-option-select': (showCco) }">
                                        Cco
                                    </div>
                                </div>
                            </div>
                            <div  flex layout="column" layout-align="start none">
                                <div layout="row" class="row">
                                    <md-switch class="md-primary"
                                               ng-model="usePersonal">
                                    </md-switch>
                                    <div flex style="padding-top: 12px;">
                                        <span style="margin-left: 8px;">¿Recibir respuesta a mi correo?</span>
                                    </div>
                                </div>
                                <md-chips ng-model="to"
                                          required
                                          md-transform-chip="transformChip($chip)"
                                          style="height: inherit;"
                                          ng-show="showHead "
                                          md-on-add =" addEmail($chip) "
                                          md-on-remove =" removeEmail($chip) "
                                          ng-style="(selectTo == 1 && destinos.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                >
                                    <md-autocomplete
                                        md-search-text="searchDestinos"
                                        md-items="item in correos  | stringKey : searchDestinos : 'valor' | customFind : destinos : isAddMail "
                                        md-item-text="item.valor"
                                        placeholder="Para:">
                                        <span >{{item.valor}} </span>



                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <md-chips ng-model="cc"
                                          md-transform-chip="transformChip($chip)"
                                          style="height: inherit;"
                                          ng-show="(showHead && showCc)"
                                          md-on-add =" addEmail($chip) "
                                          md-on-remove =" removeEmail($chip) "
                                          ng-style="(selectTo == 1 && cc.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                >
                                    <md-autocomplete
                                        md-search-text="searchCc"
                                        md-items="item in correos | stringKey : searchCc : 'valor' | customFind : destinos : isAddMail  "
                                        md-item-text="item.valor"
                                        placeholder="Cc:">
                                        <span >{{item.valor}} </span>

                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <md-chips ng-model="cco"
                                          md-transform-chip="transformChip($chip)"
                                          md-item-text="item.valor"
                                          style="height: inherit;"
                                          ng-show="(showHead && showCco)"
                                          md-on-add =" addEmail($chip) "
                                          md-on-remove =" removeEmail($chip) "
                                          ng-style="(selectTo == 1 && cco.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                >
                                    <md-autocomplete
                                        md-search-text="searchCco"
                                        md-items="item in correos | stringKey : searchCco : 'valor' | customFind : destinos : isAddMail "
                                        md-item-text="item.valor"
                                        placeholder="Cco:">
                                        <span >{{item.valor}} </span>
                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <div layout="row" class="row-min" style="padding-right: -4px;" ng-show="showHead">
                                    <md-input-container flex>
                                        <label>Asunto:</label>
                                        <input  ng-model="asunto" required >
                                    </md-input-container>
                                </div>
                                <div layout="row" flex class="text-box" >

                                    <div style="" layout="column" >
                                        <textarea ng-model="texto"
                                                  id="textarea"
                                                  required
                                                  flex
                                                  placeHolder="Texto"

                                        ></textarea>
                                        <div >
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <div layout="row" layout-align="start center" style="margin: 4px 0 4px 4px;">
                        <div  class="blue-btn " ng-click="send()" style="width: 80px;  ">
                            <div layout="row" class="layout-row " aria-hidden="true" style="padding: 3px;">
                                <div >
                                    Enviar
                                </div>
                            </div>
                        </div>
                        <div layout="row" flex class="mail-attaments" layout-align="end center">
                            <div layout layout-align="center center"  >
                                A
                            </div>
                            <div layout layout-align="center center"  >
                                A
                            </div>

                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!-- ) ########################################## LAYER  FORMULARIO INFORMACION DEL DOCUMENTO ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detalleDoc" id="detalleDoc">

            <md-content  layout="row" flex class="sideNavContent">
                <div  layout="column" flex="" layout-align=" none" >
                    <form name="FormHeadDocument" layout="row" ng-class="{focused: gridView == 1}" ng-style="(gridView != 5 && tbl_dtDoc.extend == 0 ) ? {'min-height' : '320px'} : {} ">
                        <div active-left></div>
                        <div layout="column" flex ng-init=" tbl_dtDoc.extend = 0" >
                            <div layout="row" class="row" >
                                <div layout="column"
                                     ng-hide="document.doc_parent_id != null || document.doc_parent_id || !provSelec.id"
                                     layout-align="center center" ng-click="openImport()">
                                    <span class="icon-Importar" style="font-size: 24px"></span>
                                </div>
                                <div class="titulo_formulario" layout="column" layout-align="start start"  ng-click=" gridView = 1 ; tbl_dtDoc.extend = 0 ;">
                                    <div>
                                        Datos de {{formMode.name}}
                                    </div>
                                </div>
                            </div>
                            <div   ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
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
                                                     md-require-match="true"
                                                     md-no-cache="true"
                                                     md-select-on-match


                                    >
                                        <md-item-template>
                                            <span>{{item.razon_social}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro el proveedor {{searchProveedor}}. ¿Desea crearlo?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <!--<md-input-container class="md-block" flex="15" ng-click="allowEdit()">
                                    <label>N° de Pedido</label>
                                    <input  ng-model="document.id"
                                            ng-disabled="true"
                                            skip-tab
                                    >
                                </md-input-container>-->
                                <div layout="column" flex="15" style="margin-top: 8px;" ng-click="allowEdit()">
                                    <md-datepicker ng-model="document.emision"
                                                   md-placeholder="Fecha"
                                                   ng-disabled="(true)"
                                                   skip-tab
                                    ></md-datepicker>
                                </div>
                            </div>

                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container   ng-show="( gridView != 5 )"  class="md-block" flex ng-click="allowEdit()" >
                                    <label>Titulo</label>
                                    <input  ng-model="document.titulo"
                                            ng-change=" toEditHead('titulo', document.titulo ) "
                                            ng-disabled="( Docsession.block )"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del documento"
                                            skip-tab


                                    >
                                </md-input-container>
                            </div>

                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row"  >

                                <md-input-container class="md-block" flex="40" ng-click="allowEdit()"  alert="{'none':'No hay data para '+provSelec.razon_social} " alert-show="(formData.paises.length > 0) ? '': 'none'" >
                                    <label>Pais</label>
                                    <md-autocomplete md-selected-item="ctrl.pais_id"
                                                     info="'Selecione el pais de origen de los productos'"
                                                     ng-disabled="( Docsession.block || !provSelec.id )"
                                                     ng-click="toEditHead('pais_id', document.pais_id)"
                                                     skip-tab
                                                     md-search-text="ctrl.searchPais"
                                                     md-items="item in formData.paises | stringKey : ctrl.searchPais : 'short_name' "
                                                     md-item-text="item.short_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"


                                    >
                                        <md-item-template>
                                            <span>{{item.short_name}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro el país {{ctrl.searchPais}}. {{provSelec.razon_social}},¿Desea asignarlo?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block"  flex ng-click="allowEdit()" alert="{'none':'No se le han creado direciones de facturacion a '+provSelec.razon_social} " alert-show="(formData.direccionesFact.length > 0) ? '': 'none'" >
                                    <label>Direccion Facturacion</label>
                                    <md-autocomplete md-selected-item="ctrl.direccion_facturacion_id"
                                                     ng-disabled="( Docsession.block || provSelec.id == '' ||  !provSelec.id)"
                                                     ng-click="toEditHead('direccion_facturacion_id', document.direccion_facturacion_id)"
                                                     info="Selecione la direccion que debe especificarse en la factura "
                                                     skip-tab
                                                     id="direccion_facturacion_id"
                                                     md-search-text="ctrl.searchdirFact"
                                                     md-auto-select="true"
                                                     md-items="item in formData.direccionesFact | stringKey : ctrl.searchdirFact : 'direccion' "
                                                     md-item-text="item.direccion"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-select-on-match

                                    >
                                        <md-item-template>
                                            <span>{{item.direccion}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la dirección {{ctrl.direccion_facturacion_id}}. ¿Desea crearla?
                                        </md-not-found>
                                    </md-autocomplete>

                                </md-input-container>

                            </div>
                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >

                                <md-input-container class="md-block"  flex ng-click="allowEdit()"  alert="{'none':'No se la han asignado direcciones de almacen a'+provSelec.razon_social} " alert-show="(formData.direcciones.length > 0) ? '': 'none'">
                                    <label>Direccion almacen</label>
                                    <md-autocomplete md-selected-item="ctrl.direccion_almacen_id"
                                                     ng-disabled="( Docsession.block || provSelec.id == '' ||  !provSelec.id  || ctrl.pais_id ==  null )"
                                                     ng-click="toEditHead('direccion_almacen_id', document.direccion_almacen_id)"
                                                     info="'Selecione la direccion que debe especificarse en la factura"
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
                                                     md-no-cache="true"
                                                     md-select-on-match
                                    >
                                        <md-item-template>
                                            <span>{{item.direccion}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la direccion  {{ctrl.direccion_almacen_id}}. ¿Desea crearla?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block"  flex ng-click="allowEdit()" alert="{'none':'No se le han asignado puertos a'+provSelec.razon_social} " alert-show="(formData.puertos.length > 0) ? '': 'none'">
                                    <label>Puerto</label>
                                    <md-autocomplete md-selected-item="ctrl.puerto_id"
                                                     ng-disabled="( Docsession.block || provSelec.id == '' ||  !provSelec.id || ctrl.direccion_almacen_id == null)"
                                                     ng-click="toEditHead('puerto_id', document.puerto_id)"
                                                     info=" Selecione la direccion que debe especificarse en la factura "
                                                     id="puerto_id"
                                                     skip-tab
                                                     md-search-text="ctrl.searchPuerto"
                                                     md-auto-select="true"
                                                     md-items="item in formData.puertos | stringKey : ctrl.searchPuerto : 'Main_port_name' "
                                                     md-item-text="item.Main_port_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                    >
                                        <md-item-template>
                                            <span>{{item.Main_port_name}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro el puerto  {{ctrl.puerto_id}}. ¿Desea asignarlo?
                                        </md-not-found>

                                    </md-autocomplete>
                                </md-input-container>
                            </div>
                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex="15" ng-click="allowEdit()">
                                    <label>Monto</label>
                                    <input  ng-model="document.monto"
                                            decimal
                                            ng-disabled="( Docsession.block )"
                                            required
                                            ng-change="toEditHead('monto', document.monto)"
                                            info="Monto aproximado a pagar"
                                            skip-tab
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" ng-click="allowEdit()" alert="{'none':'No se le han asignado monedas a'+provSelec.razon_social} " alert-show="(formData.monedas.length > 0) ? '': 'none'">
                                    <label>Moneda</label>
                                    <md-autocomplete md-selected-item="ctrl.prov_moneda_id"
                                                     ng-disabled="( Docsession.block || provSelec.id == '' ||  !provSelec.id )"
                                                     required
                                                     ng-click="toEditHead('prov_moneda_id', document.prov_moneda_id)"
                                                     info="Seleccione la moneda en la que se realizara el pago': 'No se le han asignado monedas a '+provSelec.razon_social"
                                                     id="prov_moneda_id"
                                                     skip-tab
                                                     md-search-text="ctrl.searchMonedaSelec"
                                                     md-auto-select="true"
                                                     md-items="item in formData.monedas | stringKey : ctrl.searchMonedaSelec : 'nombre' "
                                                     md-item-text="item.nombre"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                    >
                                        <md-item-template>
                                            <span>{{item.nombre}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la moneda {{ctrl.prov_moneda_id}}. ¿Desea asignarla?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" ng-dblclick="editTasa()"  ng-click="allowEdit()">
                                    <label>Tasa</label>
                                    <input  ng-model="document.tasa"
                                            ng-disabled="( Docsession.block || document.prov_moneda_id == '' ||  !document.prov_moneda_id)"
                                            ng-readonly="isTasaFija"
                                            required
                                            info="Tasa segun la moneda selecionada"
                                            skip-tab
                                            id="tasa"
                                            decimal
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="" ng-click="allowEdit()" alert="{'none':'No se le ha asignado condiciones de pago a '+provSelec.razon_social} " alert-show="(formData.condicionPago.length > 0) ? '': 'none'">
                                    <label>Condicion de pago</label>
                                    <md-autocomplete md-selected-item = "ctrl.condicion_pago_id"
                                                     ng-disabled = "( Docsession.block  || !provSelec.id)"
                                                     ng-click="toEditHead('condicion_pago_id', document.condicion_pago_id)"
                                                     info="Seleccione una condicion para la realizacion del pago"
                                                     ng-required ="(formMode.value == 23 )"
                                                     skip-tab
                                                     md-input-name = "autocomplete"
                                                     md-search-text = "ctrl.searchcondPagoSelec"
                                                     md-items = "item in formData.condicionPago | stringKey : ctrl.searchcondPagoSelec : 'titulo' "
                                                     md-item-text="item.titulo"
                                                     md-min-length="0"
                                                     md-input-minlength="0"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                    >
                                        <md-item-template>
                                            <span>{{item.titulo}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la condicion de pago {{ctrl.condicion_pago_id}}. ¿Desea crearla?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

                            </div>
                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0  )"  layout="row" class="row" >

                                <md-input-container class="md-block" flex  >
                                    <label>N° Factura:</label>
                                    <input ng-model="document.nro_factura"  ng-disabled="( Docsession.block)"
                                           ng-change="toEditHead('nro_factura', document.nro_factura)"
                                           info="Introducir Nro de factura en caso de tenerla"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="adj-box">
                                    <div ng-click="openAdj('Factura')"  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}" skip-tab  style="float:left">
                                        {{ (document.adjuntos | stringKey :'factura': 'documento' ).length || 0 }}
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( Docsession.block)"
                                           ng-required ="(formMode.value == 22 || formMode.value == 23 )"
                                           ng-change="toEditHead('nro_proforma', document.nro_proforma)"
                                           info="Introducir Nro de proforma en caso de tenerla"
                                           skip-tab

                                    >
                                </md-input-container>
                                <div  class="adj-box">
                                    <div ng-click="openAdj('Proforma')" class="vlc-buttom" ng-class="{'ng-disable':Docsession.block}" skip-tab  style="float:left">
                                        {{ (document.adjuntos | stringKey :'proforma' : 'documento' ).length || 0 }}
                                    </div>
                                </div>
                                <md-input-container class="md-block" flex="10">
                                    <label>Mt3</label>
                                    <input ng-model="document.mt3"  name="mt3"
                                           ng-model="number" decimal
                                           ng-disabled="( Docsession.block)"
                                           ng-change="toEditHead('mt3', document.mt3)"
                                           info="Metros cubicos"
                                           skip-tab
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="document.peso" name="peso" decimal
                                           ng-disabled="( Docsession.block)"
                                           ng-change="toEditHead('peso', document.peso)"
                                           info="Sumatoria de los pesos de productos"
                                           skip-tab
                                    >
                                </md-input-container>

                            </div>

                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Comentario</label>
                                    <input ng-model="document.comentario"  ng-disabled="( Docsession.block)"
                                           ng-change="toEditHead('nro_proforma', document.nro_proforma)"
                                           info="Algun texto adicional referente al documento"
                                           skip-tab

                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <form name="FormEstatusDoc" ng-class="{'focused': gridView == 2 }" layout="row" ng-show=" tbl_dtDoc.extend == 0 && (document.final_id != null || document.version > 1 || Docsession.global != 'new' )">
                        <div active-left></div>
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
                                    <md-select ng-model="document.estado_id"
                                               ng-disabled="( gridView != 2 ||  Docsession.block )"
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
                    <form name="FormAprobCompras" ng-class="{focused: gridView == 3}" layout="row"ng-show="tbl_dtDoc.extend == 0 &&  (document.final_id != null || document.version > 1 || Docsession.global != 'new')" >
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
                                                   ng-disabled="(Docsession.block)"
                                                   ng-change="toEditHead('fecha_aprob_compra', (document.fecha_aprob_compra) ? document.fecha_aprob_compra.toString(): undefined)"

                                    ></md-datepicker skip-tab>
                                </div>

                                <md-input-container class="md-block" flex="20">
                                    <label>N° Documento</label>
                                    <input ng-model="document.nro_doc"  ng-disabled="(Docsession.block)"
                                           ng-click="toEditHead('nro_doc', document.nro_doc)"
                                           required

                                    >
                                </md-input-container>

                                <div class="adj-box">
                                    <div ng-click="openAdj('AprobCompras')"  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}" skip-tab  style="float:left">
                                        {{ (document.adjuntos | stringKey :'AprobCompras': 'documento' ).length || 0 }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <form name="FormCancelDoc" ng-class="{focused: gridView == 4}" layout="row" ng-show="tbl_dtDoc.extend == 0 && (document.final_id != null || document.version > 1 || Docsession.global != 'new') " >
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
                                        ng-disabled="(Docsession.block)"
                                        id="mtvCancelacion"
                                        ng-change="toEditHead('comentario_cancelacion', document.comentario_cancelacion)"
                                        required

                                >
                            </md-input-container>

                        </div>
                    </form>
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
                    <form class="gridContent"  layout="row" name="dtdocProductos" flex >
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div ng-repeat="item in filterProdDoc(document.productos.todos,tbl_dtDoc.filter) | orderBy : tbl_dtDoc.order as docProdFilter " id="prodDt{{$index}}" row-select>
                                    <div layout="row" class="cellGridHolder" >
                                        <div flex="5" class="cellEmpty">
                                            <md-switch class="md-primary" ng-change="addRemoveItem(item)"
                                                       ng-disabled="( Docsession.block )" ng-model="item.asignado"> </md-switch>
                                        </div>
                                        <div flex="10" class="cellSelect"> {{item.cod_producto}}</div>
                                        <div flex class="cellGrid">  {{item.descripcion}}</div>
                                        <div flex class="cellGrid"> {{item.documento}}</div>
                                        <md-input-container class="md-block" flex="10" >
                                            <input  ng-model="item.saldo"
                                                    ng-change="changeItem(item)"
                                                    decimal
                                                    ng-disabled="(Docsession.block || !item.asignado )"
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
                    <div layout="column"  class="row" ng-click=" tbl_dtDoc.extend = ( tbl_dtDoc.extend == 0) ? 1: 0 " ng-show="docProdFilter.length > 0 && (gridView == 5) ">
                        <div flex style="border: dashed 1px #f1f1f1; text-align: center" layout="column" layout-align="end none">
                            <span class="{{ ( tbl_dtDoc.extend == 0) ? 'icon-Up' : 'icon-Above' }}"></span>
                        </div>
                    </div>

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
                        <div layout="row" style="padding: 0 8px 0 0;">
                            <div layout=""  layout-align="center center">
                                <div layout layout-align="center center" class="circle" >
                                    {{document.productos.contraPedido.length}}
                                </div>
                            </div>
                            <div flex class="titulo_formulario md-block"  layout="row"  >
                                <div flex>
                                    Contrapedidos
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" id="btnAgrCp" ng-click="openSide('agrContPed')" style="width:24px;">
                                <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>

                            </div>
                        </div>
                        <form  layout="column" class="gridContent" flex  style="margin-left: 8px; margin-top: 8px;">
                            <div >
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.contraPedido">

                                    <div flex="" class="cellGrid" ng-click="selecContraP(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div layout="column" flex>
                        <div layout="row">
                            <div  layout layout-align="center center">
                                <div layout layout-align="center center" class="circle" >
                                    {{document.productos.kitchenBox.length}}
                                </div>
                            </div>
                            <div flex class="titulo_formulario md-block"   layout="row" >

                                <div flex>
                                    KitchenBoxs
                                </div>

                            </div>
                            <div
                                layout="column" layout-align="center center"
                                id="btnAgrKitchen"
                                ng-click="openSide('agrKitBoxs')"
                                style="width:24px;">
                                <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                            </div>
                        </div>
                        <form  layout="column" class="gridContent" flex  style="margin-top: 8px;">
                            <div>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.kitchenBox" ng-class="{resalt : overSusitu == item.sustituto }">
                                    <div flex class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid"ng-click="selecKitchenBox(item)" > {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                        </form >

                    </div>

                    <div layout="column" flex>
                        <div layout="row">
                            <div layout layout-align="center center">
                                <div layout layout-align="center center" class="circle" >
                                    {{document.productos.pedidoSusti.length}}
                                </div>
                            </div>
                            <div flex class="titulo_formulario md-block"  layout="row" >
                                <div flex>
                                    {{formMode.name}} a Sustituir
                                </div>
                            </div>
                            <div
                                layout="column" layout-align="center center"
                                id="btnAgrPedSusti"
                                ng-click="openSide('agrPedPend')"
                                style="width: 24px;">
                                <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                            </div>
                        </div>

                        <form  layout="column" class="gridContent" flex  style="margin-top: 8px;">
                            <div>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.pedidoSusti" ng-mouseover = "overSusitu =  item.id">
                                    <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.emision | date:'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>

            </md-content>
        </md-sidenav>

        <!--  ########################################## LAYER PRODUCTOS PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listProducProv" id="listProducProv">

            <md-content  layout="row" flex class="sideNavContent">
                <div  layout="column" flex class="layerColumn" >
                    <form  layout="row" class="focused">
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
                                <div flex="5" class=""></div>

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
                                               id="listProducProDescripcion"


                                        >
                                    </md-input-container>
                                    <div class="cell-filter-order" layout-align="center center" >
                                        <div ng-click="tbl_listProducProv.order = 'descripcion' " ng-class="{'filter-select':(tbl_listProducProv.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                        <div ng-click="tbl_listProducProv.order = '-descripcion' "ng-class="{'filter-select':(tbl_listProducProv.order == '-descripcion')}"><img src="images/TrianguloDown.png" ></div>
                                    </div>
                                </div>

                                <div flex="10" ng-disabled="(prodResult && prodResult.length == 0 )"></div>

                                <div layout="row" flex="15">
                                    <md-input-container class="md-block" flex>
                                        <label>Cantidad</label>
                                        <input type="text"
                                               ng-model="tbl_listProducProv.filter.saldo"
                                               class="inputFilter"
                                               skip-tab
                                               id="listProducProSaldo"

                                        >
                                    </md-input-container>
                                    <div class="cell-filter-order" layout-align="center center" >
                                        <div ng-click="tbl_listProducProv.order = 'cantidad' " ng-class="{'filter-select':(tbl_listProducProv.order == 'cantidad')}"><img src="images/TrianguloUp.png" ></div>
                                        <div ng-click="tbl_listProducProv.order = '-cantidad' "ng-class="{'filter-select':(tbl_listProducProv.order == '-cantidad')}"><img src="images/TrianguloDown.png" ></div>
                                    </div>
                                    <div style="width: 48px; height: 100%;" ng-click="allowEdit()" layout-align="center center">
                                        <div ng-click="openCreateProduct()" style="width: 24px; margin-top:8px;" ng-show="(!Docsession.block)" ng-disabled="(Docsession.block)">
                                            <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                                        </div skip-tab >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form name="listProductoItems" class="gridContent"  layout="row" flex >
                        <div active-left ></div>
                        <div  flex >
                            <div   ng-repeat="item in providerProds | filter:tbl_listProducProv.filter:strict | orderBy : tbl_listProducProv.order "
                                   ng-mouseenter = "mouseEnterProd(item) " row-select>
                                <div layout="row" class="cellGridHolder" >
                                    <div flex="5" class="cellEmpty cellSelect">
                                        <md-switch class="md-primary"  ng-change=" addRemoveProd(item) " ng-disabled="(Docsession.block)" ng-model="item.asignado"></md-switch>
                                    </div>
                                    <div flex="20" class="cellGrid" > {{item.codigo}}</div>
                                    <div flex="20" class="cellGrid" > {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid" > {{item.descripcion}}</div>
                                    <div flex="10" class="cellGrid" >
                                        <md-switch class="md-primary" ng-disabled="true" ng-model="item.puntoCompra"></md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid cellGrid-input {{(provRow ==  item.id) ? 'cellGrid-input-focus' : 'cellGrid-input-no-focus'}}"

                                    >
                                        <input  ng-model="item.saldo" ng-change=" changeProducto(item) "
                                                type="number" range="{{item.asignado}}" minVal="1" maxVal="6" id="p{{item.id}}"
                                                ng-disabled="(!item.asignado || Docsession.block) " ng-focus="provRow = item.id "  ng-blur="provRow = '-1'" />
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
                    <form flex name="addContraPedidos" class="gridContent" layout="row" >
                        <div active-left></div>
                        <div flex >
                            <div layout="row" class="cellGridHolder" ng-repeat="item in filterContraPed(formData.contraPedido,tbl_agrContPed.filter) | orderBy: tbl_agrContPed.order">
                                <div class="cellEmpty" flex="5" ng-click="allowEdit()">
                                    <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeContraP(item)" ng-disabled="(Docsession.block)"></md-switch>
                                </div>
                                <div flex="10" class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.titulo}}</div>
                                <div flex="10" class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha_aprox_entrega | date:'dd/MM/yyyy' }}</div>
                                <div flex="15" class="cellGrid" ng-click="selecContraP(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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
                                KitchenBoxs
                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left></div>
                        <div layout="row" flex ng-init="tbl_agrKitBoxs.order = 'id' ">
                            <div flex="5"></div>

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
                    <form flex name="KitchenBoxs" class="gridContent" layout="row">
                        <div active-left></div>
                        <div   layout="column" flex>
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in formData.kitchenBox | filter:tbl_agrKitBoxs.filter:strict | orderBy : tbl_agrKitBoxs.order ">
                                    <div class="cellEmpty" flex="5" ng-click="allowEdit()">
                                        <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeKitchenBox(item)" ng-disabled="(Docsession.block)"></md-switch>
                                    </div>
                                    <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.fecha | date:'dd/MM/yyyy'}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.num_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.img_proforma}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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
                                                   ng-disabled="(Docsession.block)"></md-switch>
                                    </div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.nro_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.emision | date:'dd/MM/yyyy'}}</div>
                                    <div flex="15" class="cellGrid" ng-click="selecPedidoSust(item)">{{item.nro_factura}}</div>
                                    <div flex="10" class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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
                    <form  layout="row" >
                        <div active-left></div>
                        <div  layout="column" flex  ng-init="tbl_resumenContraPedido.extend = 0 ">
                            <div class="titulo_formulario" layout="Column" layout-align="start start" class="row" ng-click="tbl_pediSutitut.extend = 0 " >
                                <div>
                                    Contra Pedido
                                </div>
                            </div>
                            <div layout="row" ng-show="tbl_resumenContraPedido.extend == 0" >
                                <md-input-container class="md-block" flex>
                                    <label>Titulo:</label>
                                    <input ng-model="contraPedSelec.titulo" ng-disabled="true" >
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
                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado: </div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <div>{{contraPedSelec.fecha | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>



                            </div>
                            <div layout="row"   ng-show="tbl_resumenContraPedido.extend == 0">
                                <md-input-container class="md-block" flex="20">
                                    <label>Motivo:</label>
                                    <input ng-model="contraPedSelec.motivo_contrapedido" ng-disabled="true">
                                </md-input-container>

                                <md-input-container class="md-block" flex="20">
                                    <label>Tipo Envio:</label>
                                    <input ng-model="contraPedSelec.tipo_envio" ng-disabled="true"/>
                                </md-input-container>

                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center" >
                                        <div>Fecha Entrega: </div>
                                    </div>
                                    <div  class="md-block" layout="column" layout-align="center center" >
                                        <div>{{contraPedSelec.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex >
                                    <label>Prioridad:</label>
                                    <input ng-model="contraPedSelec.prioridad" ng-disabled="true"/>
                                </md-input-container>




                            </div>
                            <div layout="row"  ng-show="tbl_resumenContraPedido.extend == 0">

                                <md-input-container class="md-block" flex>
                                    <label>Comentario:</label>
                                    <input name="coment" ng-model="contraPedSelec.comentario"  ng-disabled="true" >
                                </md-input-container>

                                <md-input-container class="md-block" flex="20">
                                    <label>Monto:</label>
                                    <input ng-model="contraPedSelec.monto" ng-disabled="true" >
                                </md-input-container>

                                <md-input-container class="md-block" flex="20" >
                                    <label>Moneda</label>
                                    <input ng-model="contraPedSelec.moneda" ng-disabled="true">
                                    </input>
                                </md-input-container>


                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div class="titulo_formulario" layout="column" layout-align="start start" >
                                <div>
                                    Productos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tbl_resumenContraPedido.order= 'codigo'">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5" ></div>

                            <div flex="15" layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl_resumenContraPedido.filter.cod_producto">
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_resumenContraPedido.order = 'cod_producto' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == 'cod_producto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_resumenContraPedido.order = '-cod_producto' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == '-cod_producto')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label> Cod. Fabrica</label>
                                    <input  ng-model="tbl_resumenContraPedido.filter.codigo_fabrica">
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_resumenContraPedido.order = 'codigo_fabrica' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == 'codigo_fabrica')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_resumenContraPedido.order = '-codigo_fabrica' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == '-codigo_fabrica')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label> Descripción </label>
                                    <input  ng-model="tbl_resumenContraPedido.filter.descripcion">
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_resumenContraPedido.order = 'descripcion' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_resumenContraPedido.order = '-descripcion' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == '-descripcion')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label> Cantidad </label>
                                    <input  ng-model="tbl_resumenContraPedido.filter.saldo">
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_resumenContraPedido.order = 'saldo' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == 'saldo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_resumenContraPedido.order = '-saldo' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == '-saldo')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label> Comentario </label>
                                    <input  ng-model="tbl_resumenContraPedido.filter.comentario">
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_resumenContraPedido.order = 'comentario' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_resumenContraPedido.order = '-comentario' " ng-class="{'filter-select':(tbl_resumenContraPedido.order == '-comentario')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" class="gridContent" flex>
                        <div active-left></div>
                        <div layout="column" flex>
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in contraPedSelec.productos | filter : tbl_resumenContraPedido.filter:strict | orderBy : tbl_resumenContraPedido.order ">
                                    <div flex="5" class="cellEmpty">
                                        <md-switch class="md-primary"
                                                   ng-model="item.asignado"
                                                   ng-change="addRemoveCpItem(item)"
                                                   ng-disabled="(Docsession.block)"></md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                    <div flex="15" class="cellGrid"> {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex="10"  class="cellGrid" >{{item.saldo}}</div>
                                    <div flex class="cellGrid">  {{item.comentario}}</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </md-content>

        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN KICTCHEN BOX ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenKitchenbox" id="resumenKitchenbox" >
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE  KICTCHEN BOX  ########################################## -->

            <md-content  layout="row" flex class="sideNavContent">
                <div layout="column" flex>
                    <form name="resumenContraPed" layout="row" class="focused">
                        <div active-left> </div>
                        <div  layout="column" flex >
                            <div class="titulo_formulario" layout="Column" layout-align="start start">
                                <div>
                                    Kitchen Box
                                </div>
                            </div>
                            <div layout="row" class="row" >

                                <md-input-container class="md-block" flex >
                                    <label>Titulo </label>
                                    <input  ng-model="kitchenBoxSelec.titulo" ng-disabled="true">
                                </md-input-container>


                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado: </div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <div>{{kitchenBoxSelec.fecha | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>
                            </div>
                            <div layout="row">

                                <md-input-container class="md-block" flex >
                                    <label>Prioridad:</label>
                                    <md-select ng-model="kitchenBoxSelec.prioridad" ng-disabled="true">
                                        <md-option ng-repeat="item in formDataContraP.contraPedidoPrioridad" value="{{item.id}}">
                                            {{item.descripcion}}
                                        </md-option>
                                    </md-select>
                                </md-input-container>

                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Fecha Entrega: </div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <div>{{kitchenBoxSelec.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>
                            </div>

                            <div layout="row">
                                <md-input-container class="md-block" flex="15">
                                    <label>Monto </label>
                                    <input  ng-model="kitchenBoxSelec.monto"  type="text"
                                            ng-disabled="true" >
                                </md-input-container>
                                <md-input-container class="md-block" flex="15">
                                    <label>Abono </label>
                                    <input  ng-model="kitchenBoxSelec.monto_abono"  type="text"
                                            ng-disabled="true" >
                                </md-input-container>

                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Fecha Abono: </div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <div>{{kitchenBoxSelec.fecha_abono | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>

                                <div style="width: 40px;" layout="column" layout-align="center center">
                                    <?= HTML::image("images/adjunto.png",'null', array('id' => 'imgAdj')) ?>
                                </div>

                                <md-input-container class="md-block" flex>
                                    <label>Condiciones de pago</label>
                                    <input ng-model="kitchenBoxSelec.condicion_pago" ng-disabled="true"/>
                                </md-input-container>
                            </div>

                            <div layout="row">
                                <md-input-container class="md-block" flex>
                                    <label>Comentario:</label>
                                    <input name="coment" ng-model="kitchenBoxSelec.comentario"  ng-disabled="true" >
                                </md-input-container>
                            </div>

                        </div>
                    </form>
                    <form layout="row" class="gridContent" flex>
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row">
                                <div class="titulo_formulario" layout="column" layout-align="start start">
                                    <div>
                                        Adjuntos
                                    </div>
                                </div>
                            </div>
                            <div layout="column" flex>

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
                <div layout="column" flex >
                    <form name="FormPedidoSusProduc" layout="row"  ng-style="(tbl_pediSutitut.extend == 0 ) ? {'min-height' : '204px'} : {} " ng-class="{'focused' : (tbl_pediSutitut.extend == 0 )}">
                        <div active-left></div>
                        <div  layout="column" flex ng-init="tbl_pediSutitut.extend = 0 ">
                            <div class="titulo_formulario" layout="Column" layout-align="start start" class="row" ng-click="tbl_pediSutitut.extend = 0 " >
                                <div>
                                    Datos de la {{formMode.name}}
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="tbl_pediSutitut.extend == 0 ">
                                <md-input-container class="md-block" flex >
                                    <label>Titulo</label>
                                    <input  ng-model="pedidoSusPedSelec.titulo" ng-disabled="true">
                                </md-input-container>
                                <div layout="column" class="md-block" layout-align="center center" >
                                    <div>Creado: </div>
                                </div>
                                <div flex="20" class="md-block" layout="column" layout-align="center center" >
                                    <div>{{pedidoSusPedSelec.emision | date:'dd/MM/yyyy'}}</div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="tbl_pediSutitut.extend == 0 ">
                                <md-input-container class="md-block" flex="20">
                                    <label>Pais</label>
                                    <input ng-model="pedidoSusPedSelec.pais" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex>
                                    <label>Almacen</label>
                                    <input ng-model="pedidoSusPedSelec.dir_almacen" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="15" >
                                    <label>Puerto</label>
                                    <input ng-model="pedidoSusPedSelec.puerto" md-no-ink
                                           ng-disabled="true" />
                                </md-input-container>

                            </div>
                            <div layout="row" class="row" ng-show="tbl_pediSutitut.extend == 0 ">
                                <md-input-container class="md-block" flex="" >
                                    <label>Dir. Facturación</label>
                                    <input ng-model="pedidoSusPedSelec.dir_facturacion" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="30" >
                                    <label>Prioridad</label>
                                    <input ng-model="pedidoSusPedSelec.prioridad" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="pedidoSusPedSelec.mt3" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="pedidoSusPedSelec.peso" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                            </div>
                            <div layout="row" class="row" ng-show="tbl_pediSutitut.extend == 0 ">
                                <md-input-container class="md-block" flex="10">
                                    <label>Monto</label>
                                    <input ng-model="pedidoSusPedSelec.monto" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="15">
                                    <label>Moneda</label>
                                    <input ng-model="pedidoSusPedSelec.moneda" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Tasa</label>
                                    <input ng-model="pedidoSusPedSelec.tasa" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex >
                                    <label>Condicion de pago</label>
                                    <input ng-model="pedidoSusPedSelec.condicion_pago" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                            </div>

                        </div>
                    </form>
                    <form layout="row" class=""  ng-class="{'focused' : (tbl_pediSutitut.extend == 1 )}">
                        <div active-left></div>
                        <div layout="row" flex ng-class="{'focused' : (tbl_pediSutitut.extend == 1 )}">
                            <div class="titulo_formulario" layout="column" layout-align="start start" >
                                <div>
                                    Productos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tbl_pediSutitut.order= 'cod_producto' ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5" ></div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl_pediSutitut.filter.cod_producto"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_pediSutitut.order = 'cod_producto' " ng-class="{'filter-select':(tbl_pediSutitut.order == 'cod_producto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_pediSutitut.order = '-cod_producto' " ng-class="{'filter-select':(tbl_pediSutitut.order == '-cod_producto')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="15" layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Cod. Fabrica</label>
                                    <input  ng-model="tbl_pediSutitut.filter.codigo_fabrica"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_pediSutitut.order = 'codigo_fabrica' " ng-class="{'filter-select':(tbl_pediSutitut.order == 'codigo_fabrica')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_pediSutitut.order = '-codigo_fabrica' " ng-class="{'filter-select':(tbl_pediSutitut.order == '-codigo_fabrica')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Origen</label>
                                    <input  ng-model="tbl_pediSutitut.filter.documento"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_pediSutitut.order = 'documento' " ng-class="{'filter-select':(tbl_pediSutitut.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_pediSutitut.order = '-documento' " ng-class="{'filter-select':(tbl_pediSutitut.order == '-documento')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Descripcion</label>
                                    <input  ng-model="tbl_pediSutitut.filter.descripcion"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_pediSutitut.order = 'descripcion' " ng-class="{'filter-select':(tbl_pediSutitut.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_pediSutitut.order = '-descripcion' " ng-class="{'filter-select':(tbl_pediSutitut.order == '-descripcion')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cantidad</label>
                                    <input  ng-model="tbl_pediSutitut.filter.saldo"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_pediSutitut.order = 'saldo' " ng-class="{'filter-select':(tbl_pediSutitut.order == 'saldo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_pediSutitut.order = '-saldo' " ng-class="{'filter-select':(tbl_pediSutitut.order == '-saldo')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="gridContent"  layout="row" flex >
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSusPedSelec.productos | filter :tbl_pediSutitut.filter:strict | orderBy :tbl_pediSutitut.order   ">
                                    <div flex="5" class="cellEmpty" >
                                        <md-switch class="md-primary"
                                                   ng-disabled="( Docsession.block )" ng-model="item.asignado" ng-change="addRemoveDocSusItem(item)">
                                        </md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                    <div flex="15" class="cellGrid">  {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex="10" class="cellGrid">{{item.saldo}}</div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div layout="column"  class="row" ng-click=" tbl_pediSutitut.extend = ( tbl_pediSutitut.extend == 0) ? 1: 0 " ng-show="pedidoSusPedSelec.productos.length > 0">
                        <div flex style="border: dashed 1px #f1f1f1; text-align: center" layout="column" layout-align="end none">
                            <span class="{{ ( tbl_pediSutitut.extend == 0) ? 'icon-Up' : 'icon-Above' }}"></span>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN de version anterior ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; "  class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenOldDoc" id="resumenOldDoc" >


            <md-content  layout="row" flex  >
                <div layout="column" flex >
                    <form name="FormPedidoSusProduc" layout="row"  ng-style="(tbl_oldDoc.extend == 0 ) ? {'min-height' : '204px'} : {} " ng-class="{'focused' : (tbl_oldDoc.extend == 0 )}">
                        <div active-left></div>
                        <div  layout="column" flex ng-init="tbl_oldDoc.extend = 0 ">
                            <div class="titulo_formulario" layout="Column" layout-align="start start" class="row" ng-click="tbl_oldDoc.extend = 0 " >
                                <div>
                                    Datos de la {{formMode.name}}
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex >
                                    <label>Titulo</label>
                                    <input  ng-model="oldVersionSelect.titulo" ng-disabled="true">
                                </md-input-container>
                                <div layout="column" class="md-block" layout-align="center center" >
                                    <div>Creado: </div>
                                </div>
                                <div flex="20" class="md-block" layout="column" layout-align="center center" >
                                    <div>{{oldVersionSelect.emision | date:'dd/MM/yyyy'}}</div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex="20">
                                    <label>Pais</label>
                                    <input ng-model="oldVersionSelect.pais" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex>
                                    <label>Almacen</label>
                                    <input ng-model="oldVersionSelect.dir_almacen" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="15" >
                                    <label>Puerto</label>
                                    <input ng-model="oldVersionSelect.puerto" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>



                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex="" >
                                    <label>Dir. Facturación</label>
                                    <input ng-model="oldVersionSelect.dir_facturacion" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="30" >
                                    <label>Prioridad</label>
                                    <input ng-model="oldVersionSelect.prioridad" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="oldVersionSelect.mt3" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="oldVersionSelect.peso" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex="10">
                                    <label>Monto</label>
                                    <input ng-model="oldVersionSelect.monto" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="15">
                                    <label>Moneda</label>
                                    <input ng-model="oldVersionSelect.moneda" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Tasa</label>
                                    <input ng-model="oldVersionSelect.tasa" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex >
                                    <label>Condicion de pago</label>
                                    <input ng-model="oldVersionSelect.condicion_pago" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                            </div>

                        </div>
                    </form>
                    <form layout="row" class=""  ng-class="{'focused' : (tbl_oldDoc.extend == 1 )}">
                        <div active-left></div>
                        <div layout="row" flex ng-class="{'focused' : (tbl_oldDoc.extend == 1 )}">
                            <div class="titulo_formulario" layout="column" layout-align="start start" >
                                <div>
                                    Productos
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tbl_oldDoc.order= 'cod_producto' ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl_oldDoc.filter.cod_producto"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_oldDoc.order = 'cod_producto' " ng-class="{'filter-select':(tbl_oldDoc.order == 'cod_producto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_oldDoc.order = '-cod_producto' " ng-class="{'filter-select':(tbl_oldDoc.order == '-cod_producto')}"><img src="images/TrianguloDown.png" ></div>
                                </div>

                            </div>
                            <div flex="15" layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Cod. Fabrica</label>
                                    <input  ng-model="tbl_oldDoc.filter.codigo_fabrica"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_oldDoc.order = 'codigo_fabrica' " ng-class="{'filter-select':(tbl_oldDoc.order == 'codigo_fabrica')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_oldDoc.order = '-codigo_fabrica' " ng-class="{'filter-select':(tbl_oldDoc.order == '-codigo_fabrica')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Origen</label>
                                    <input  ng-model="tbl_oldDoc.filter.documento"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_oldDoc.order = 'documento' " ng-class="{'filter-select':(tbl_oldDoc.order == 'documento')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_oldDoc.order = '-documento' " ng-class="{'filter-select':(tbl_oldDoc.order == '-documento')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex layout="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Descripcion</label>
                                    <input  ng-model="tbl_oldDoc.filter.descripcion"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_oldDoc.order = 'descripcion' " ng-class="{'filter-select':(tbl_oldDoc.order == 'descripcion')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_oldDoc.order = '-descripcion' " ng-class="{'filter-select':(tbl_oldDoc.order == '-descripcion')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cantidad</label>
                                    <input  ng-model="tbl_oldDoc.filter.saldo"
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" >
                                    <div ng-click="tbl_oldDoc.order = 'saldo' " ng-class="{'filter-select':(tbl_oldDoc.order == 'saldo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div ng-click="tbl_oldDoc.order = '-saldo' " ng-class="{'filter-select':(tbl_oldDoc.order == '-saldo')}"><img src="images/TrianguloDown.png" ></div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="gridContent"  layout="row" flex >
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div layout="row" class="cellGridHolder" ng-repeat="item in oldVersionSelect.productos.todos | filter :tbl_oldDoc.filter:strict | orderBy :tbl_oldDoc.order   ">
                                    <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                    <div flex="15" class="cellGrid">  {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex="10" class="cellGrid">{{item.saldo}}</div>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div layout="column"  class="row" ng-click=" tbl_oldDoc.extend = ( tbl_oldDoc.extend == 0) ? 1: 0 " ng-show="tbl_oldDoc.productos.length > 0">
                        <div flex style="border: dashed 1px #f1f1f1; text-align: center" layout="column" layout-align="end none">
                            <span class="{{ ( tbl_oldDoc.extend == 0) ? 'icon-Up' : 'icon-Above' }}"></span>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!--  ##########################################  FINAL DOCUMENTO########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="finalDoc" id="finalDoc">
            <md-content  layout="row" flex class="sideNavContent" >
                <div flex="30"layout="column" id="headFinalDoc"  >
                    <form layout="row" >
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row" class="row">
                                <div class="titulo_formulario" ng-click=" gridViewFinalDoc = 1" >
                                    <div>
                                        {{formMode.name}}
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start">
                                    <md-switch class="md-primary"
                                               ng-model="ctrlZHead" ng-change ="toSideNave(ctrlZHead,['#detalleDoc div.activeleft '])" ng-disabled="( Docsession.block )"

                                    >
                                    </md-switch>
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
                            <div layout="row"  class="rowRsm" ng-show="(document.puerto_id && gridViewFinalDoc == 1)">
                                <div layout="row" flex="40" >
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.puerto_id.estado == 'created'"
                                         layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.puerto_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Puerto </div>
                                </div>
                                <div class="rms" flex> {{document.puerto_id}} </div>
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

                        </div>
                    </form>
                    <form   layout="row" ng-show="document.productos.contraPedido.length > 0">
                        <div active-left> </div>
                        <div layout="column" flex >
                            <div layout="row" class="row">
                                <div class="titulo_formulario"ng-click=" gridViewFinalDoc = 2">
                                    <div>
                                        ContraPedido
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start">
                                    <md-switch class="md-primary"
                                               ng-model="ctrlZCp" ng-change ="toSideNave(ctrlZCp,['#agrPed div.activeleft ','#agrPed div#btnAgrCp'])" ng-disabled="( Docsession.block )"
                                    >
                                    </md-switch>
                                </div>
                            </div>

                            <div flex ng-show="gridViewFinalDoc == 2" >
                                <md-content style="margin: 4px;">

                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.contraPedido" layout-align="space-between center" >
                                        <div layout="row"  flex>
                                            <div  layout="column" ng-show="(item.id.estado == 'new' && item.id.trace.length > 0) || item.id.estado == 'created'"
                                                  layout-align="center center">
                                                <span class="icon-Agregar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                                <span class="icon-Actualizar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                                <span class="icon-Eliminar" style="font-size: 16px"></span>
                                            </div>
                                            <div class="rowRsm ">{{item.titulo.v}}</div>
                                        </div>
                                    </div>
                                </md-content>
                            </div>

                        </div>

                    </form>
                    <form   layout="row" ng-show="document.productos.kitchenBox.length > 0" >
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row" class="row">
                                <div class="titulo_formulario" ng-click=" gridViewFinalDoc = 3" >
                                    <div>
                                        KitchenBox
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start">
                                    <md-switch class="md-primary"
                                               ng-model="ctrlZHead" ng-change ="toSideNave(ctrlZCp,['#agrPed div.activeleft ','#agrPed div#btnAgrKitchen'])" ng-disabled="( Docsession.block )"

                                    >
                                    </md-switch>
                                </div>
                            </div>
                            <div flex ng-show="gridViewFinalDoc == 3">
                                <md-content style="margin: 4px;">
                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.kitchenBox" layout-align="space-between center" >
                                        <div layout="row" >
                                            <div  layout="column" ng-show="(item.id.estado == 'new' && item.id.trace.length > 0) || item.id.estado == 'created'"
                                                  layout-align="center center">
                                                <span class="icon-Agregar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                                <span class="icon-Actualizar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                                <span class="icon-Eliminar" style="font-size: 16px"></span>
                                            </div>
                                            <div class="rowRsm " >{{item.titulo.v}}</div>
                                        </div>
                                    </div>
                                </md-content>

                            </div>

                        </div>
                    </form>
                    <form   layout="row" ng-show="document.productos.pedidoSusti.length > 0">
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row" class="row">
                                <div class="titulo_formulario" ng-click=" gridViewFinalDoc = 4" >
                                    <div>
                                        {{formMode.name}}
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start">
                                    <md-switch class="md-primary"
                                               ng-model="ctrlZHead" ng-change ="toSideNave(ctrlZCp,['#agrPed div.activeleft ','#agrPed div#btnAgrPedSusti'])" ng-disabled="( Docsession.block )"

                                    >
                                    </md-switch>
                                </div>
                            </div>
                            <div flex ng-show="gridViewFinalDoc == 4">
                                <md-content style="margin: 4px;">

                                    <div layout="row" class="cellGridHolder "  ng-repeat=" item in finalDoc.pedidoSusti" layout-align="space-between center" >
                                        <div layout="row"  flex >
                                            <div  layout="column" ng-show="(item.id.estado == 'new' && item.id.trace.length > 0) || item.id.estado == 'created'"
                                                  layout-align="center center">
                                                <span class="icon-Agregar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'upd'" layout-align="center center" >
                                                <span class="icon-Actualizar" style="font-size: 16px"></span>
                                            </div>
                                            <div  layout="column" ng-show="item.id.estado == 'del'" layout-align="center center" >
                                                <span class="icon-Eliminar" style="font-size: 16px"></span>
                                            </div>
                                            <div class="rowRsm">{{item.titulo.v}}</div>
                                        </div>

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
                                <md-input-container class="md-block"  flex="15">
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
                                        <div flex="20" class="cellSelect" ng-class="{'cellSelect':( finalProdSelec.id  != item.id) ,'cellSelect-select':(finalProdSelec.id  == item.id )}" >
                                            {{item.codigo}}
                                        </div>
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

                    <form layout="row"  flex class="gridContent">
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
                                        <div flex class="cellGrid"> {{item.proveedor}}</div>
                                        <div flex class="cellGrid" > {{item.titulo}}</div>
                                        <div flex="10" class="cellGrid" > {{item.emision| date:'dd/MM/yyyy' }}</div>
                                        <div flex class="cellGrid" > {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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
                                <div ng-repeat="item in filterDocuments(priorityDocs.docs, tbl_priorityDocs.filter) | orderBy : tbl_priorityDocs.order "  row-select>
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
                                        <div flex class="cellGrid" ng-click="openTempDoc(item)" > {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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

        <!-- ########################################## LAYER LISTA DE DOCUMENTOS con versiones antigual del documento ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="oldDocs" id="oldDocs">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" >
                <div layout="column" flex>
                    <form layout="row">
                        <div active-left  before="verificExit" ></div>
                        <div layout="row" flex>
                            <div class="titulo_formulario" style="height: 39px;">
                                <div>
                                    Versiones de la  {{formMode.name}} con el titulo {{document.titulo}}
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row" ng-init="tbl_oldDocs.order = '-version'">
                        <div active-left  before="verificExit" ></div>
                        <div layout="row" flex>

                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Version</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_oldDocs.filter.version"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_oldDocs.order = 'version' " ng-class="{'filter-select':(tbl_oldDocs.order == 'version')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_oldDocs.order = '-version' " ng-class="{'filter-select':(tbl_oldDocs.order == '-version')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_oldDocs.filter.proveedor"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_oldDocs.order = 'proveedor' " ng-class="{'filter-select':(tbl_oldDocs.order == 'proveedor')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_oldDocs.order = '-proveedor' " ng-class="{'filter-select':(tbl_oldDocs.order == '-proveedor')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_oldDocs.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_oldDocs.order = 'titulo' " ng-class="{'filter-select':(tbl_oldDocs.order == 'titulo')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_oldDocs.order = '-titulo' " ng-class="{'filter-select':(tbl_oldDocs.order == '-titulo')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex="10" layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_oldDocs.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_oldDocs.order = 'emision' " ng-class="{'filter-select':(tbl_oldDocs.order == 'emision')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_oldDocs.order = '-emision' " ng-class="{'filter-select':(tbl_oldDocs.order == '-emision')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_oldDocs.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_oldDocs.order = 'monto' " ng-class="{'filter-select':(tbl_oldDocs.order == 'monto')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_oldDocs.order = '-monto' " ng-class="{'filter-select':(tbl_oldDocs.order == '-monto')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                            <div flex layout="row"  >
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl_oldDocs.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="cell-filter-order" layout-align="center center" layout="column" >
                                    <div  layout-align="end center" ng-click="tbl_oldDocs.order = 'comentario' " ng-class="{'filter-select':(tbl_oldDocs.order == 'comentario')}"><img src="images/TrianguloUp.png" ></div>
                                    <div layout-align="star center" ng-click="tbl_oldDocs.order = '-comentario' " ng-class="{'filter-select':(tbl_oldDocs.order == '-comentario')}"><img src="images/TrianguloDown.png"/></div>
                                </div>

                            </div>
                        </div>

                    </form>
                    <form layout="row" class="gridContent">
                        <div active-left  before="verificExit" ></div>
                        <div layout="column" flex>
                            <div flex>
                                <div ng-repeat="item in filterDocuments(oldDocs, tbl_priorityDocs.filter) | orderBy : tbl_priorityDocs.order "  row-select>
                                    <div layout="row" class="cellGridHolder" >


                                        <div flex="10" class="cellSelect" ng-click="openOld(item)"
                                             ng-class="{'cellGrid':( oldVersionSelect.id  != item.id) ,'cellSelect-select':( oldVersionSelect.id &&  oldVersionSelect.id  == item.id  )}"
                                             tabindex="{{$index + 1}}"
                                        > {{item.version}}</div>
                                        <div flex class="cellGrid" ng-click="openOld(item)"> {{item.proveedor}}</div>
                                        <div flex class="cellGrid" ng-click="openOld(item)" > {{item.titulo}}</div>
                                        <div flex="10" class="cellGrid" ng-click="openOld(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                        <div flex class="cellGrid" ng-click="openOld(item)" > {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                        <div flex class="cellGrid"  ng-click="openOld(item)" >{{item.comentario}}</div>
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
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="previewEmail" id="previewEmail">
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderMailPreview" >
                <div layout="column" flex>
                    <form layout="row"  >
                        <div active-left   ></div>
                        <div layout="column" flex>
                            <div class="activeleft"></div>
                            <div layout="column" style="margin-bottom: 8px;">
                                <div layout="row" >
                                    <div class="titulo_formulario">
                                        <div>
                                            Envio de Correo
                                        </div>
                                    </div>
                                    <div flex layout="row"  layout-align="end start" class="mail-option">
                                        <div layout="row" style="width: 28px" ng-click=" showHead = !showHead " >
                                            <span>{{(showHead) ? '/' : '()'}}</span>
                                        </div>
                                        <div layout="row" style="width: 20px" ng-click="showCc = !showCc ; showHead = true ;"   ng-class="{'mail-option-select': (showCc) }">
                                            Cc
                                        </div>
                                        <div layout="row" style="width: 28px" ng-click="showCco = !showCco ;showHead = true ; "  ng-class="{'mail-option-select': (showCco) }">
                                            Cco
                                        </div>
                                    </div>
                                </div>
                                <div layout="row" class="row">
                                    <md-switch class="md-primary"
                                               ng-model="usePersonal">
                                    </md-switch>
                                    <div flex style="padding-top: 12px;">
                                        <span style="margin-left: 8px;">¿Recibir respuesta a mi correo?</span>
                                    </div>
                                </div>
                                <md-chips ng-model="to"
                                          required
                                          md-transform-chip="transformChip($chip)"
                                          style="height: inherit;"
                                          md-on-add =" addEmail($chip) "
                                          md-on-remove =" removeEmail($chip) "
                                          ng-style="(selectTo == 1 && destinos.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                          ng-show="showHead"
                                >
                                    <md-autocomplete
                                        md-search-text="searchDestinos"
                                        md-items="item in correos  | stringKey : searchDestinos : 'valor' | customFind : destinos : isAddMail "
                                        md-item-text="item.valor"
                                        placeholder="Para:">
                                        <span >{{item.valor}} </span>



                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <md-chips ng-model="cc"
                                          md-transform-chip="transformChip($chip)"
                                          style="height: inherit;"
                                          ng-show="(showHead && showCc)"
                                          md-on-add =" addEmail($chip) "
                                          md-on-remove =" removeEmail($chip) "
                                          ng-style="(selectTo == 1 && cc.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                >
                                    <md-autocomplete
                                        md-search-text="searchCc"
                                        md-items="item in correos | stringKey : searchCc : 'valor' | customFind : destinos : isAddMail  "
                                        md-item-text="item.valor"
                                        placeholder="Cc:">
                                        <span >{{item.valor}} </span>

                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <md-chips ng-model="cco"
                                          md-transform-chip="transformChip($chip)"
                                          md-item-text="item.valor"
                                          style="height: inherit;"
                                          ng-show="(showHead && showCco)"
                                          md-on-add =" addEmail($chip) "
                                          md-on-remove =" removeEmail($chip) "
                                          ng-style="(selectTo == 1 && cco.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                >
                                    <md-autocomplete
                                        md-search-text="searchCco"
                                        md-items="item in correos | stringKey : searchCco : 'valor' | customFind : destinos : isAddMail "
                                        md-item-text="item.valor"
                                        placeholder="Cco:">
                                        <span >{{item.valor}} </span>
                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <div layout="row" class="row" ng-show="!showHead">
                                    <md-input-container flex>
                                        <label>Titulo</label>
                                        <input ng-model="titulo" >
                                    </md-input-container>
                                </div><div layout="row" class="row" ng-show="!showHead">
                                    <md-input-container flex>
                                        <label>Descripción</label>
                                        <input ng-model="descripcion">
                                    </md-input-container>
                                </div>
                                <div layout="row" class="row-min" style="padding-right: 4px;" ng-show="showHead" >
                                    <md-input-container flex>
                                        <label>Asunto:</label>
                                        <input  ng-model="asunto" required >
                                    </md-input-container>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div flex style="overflow: auto; padding: 8px;">
                        <div id="templateContent" ng-bind-html="template" flex="">
                        </div>


                    </div>
                </div>

            </md-content>
        </md-sidenav>


        <!-- ########################################## LAYER Mensaje de notificacion########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(30%); z-index: 60 ;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="moduleMsm" id="moduleMsm"


        >

            <md-content   layout="row" flex class="sideNavContent" >
                <div  layout="column" flex="" class="layerColumn"  click-out="closeNotis($event)" >
                    <form layout="row" class="focused" >
                        <div class="activeleft "></div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" >
                                <div>
                                    Mensajes
                                </div>
                            </div>

                        </div>
                    </form>
                    <form layout="row" >
                        <div class="activeleft"></div>
                        <md-content flex  >
                            <div ng-repeat="item in alerts"  >
                                <div layout="row" class="cellGridHolder" ng-click="openNoti(item.key)" >
                                    <div flex="10" class="cellGrid" >{{item.cantidad}} </div>
                                    <div flex class="cellGrid"> {{item.titulo}}</div>
                                </div>
                            </div>

                        </md-content>

                    </form>
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
                                    <div flex class="cellGrid"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
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

        <!-- ########################################## LAYER send correo ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="sendEmail" id="sendEmail"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="OrderSendMail"    >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <form name="FormSendMail" flex layout="row" class="focused">
                        <div class="activeleft"></div>
                        <div layout="column" flex>
                            <div layout="row" >
                                <div class="titulo_formulario">
                                    <div>
                                        Envio de Correo
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start" class="mail-option">
                                    <div layout="row" style="width: 28px" ng-click=" showHead = !showHead " >
                                        <span>{{(showHead) ? '/' : '()'}}</span>
                                    </div>
                                    <div layout="row" style="width: 20px" ng-click="showCc = !showCc ; showHead = true ;"   ng-class="{'mail-option-select': (showCc) }">
                                        Cc
                                    </div>
                                    <div layout="row" style="width: 28px" ng-click="showCco = !showCco ;showHead = true ; "  ng-class="{'mail-option-select': (showCco) }">
                                        Cco
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="showHead">
                                <md-switch class="md-primary"
                                           ng-model="usePersonal">
                                </md-switch>
                                <div flex style="padding-top: 12px;">
                                    <span style="margin-left: 8px;">¿Recibir respuesta a mi correo?</span>
                                </div>
                            </div>
                            <md-chips ng-model="to"
                                      required
                                      md-transform-chip="transformChip($chip)"
                                      style="height: inherit;"
                                      md-on-add =" addEmail($chip) "
                                      md-on-remove =" removeEmail($chip) "
                                      ng-style="(selectTo == 1 && destinos.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                      ng-show="showHead"
                                      skip-tab
                            >
                                <md-autocomplete
                                    md-search-text="searchDestinos"
                                    md-items="item in correos  | stringKey : searchDestinos : 'valor' | customFind : destinos : isAddMail "
                                    md-item-text="item.valor"
                                    placeholder="Para:">
                                    <span >{{item.valor}} </span>



                                </md-autocomplete>
                                <md-chip-template>
                                    <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                </md-chip-template>
                            </md-chips>
                            <md-chips ng-model="cc"
                                      md-transform-chip="transformChip($chip)"
                                      style="height: inherit;"
                                      ng-show="(  showHead && showCc)"
                                      md-on-add =" addEmail($chip) "
                                      md-on-remove =" removeEmail($chip) "
                                      ng-style="(selectTo == 1 && cc.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                      skip-tab
                            >
                                <md-autocomplete
                                    md-search-text="searchCc"
                                    md-items="item in correos | stringKey : searchCc : 'valor' | customFind : destinos : isAddMail  "
                                    md-item-text="item.valor"
                                    placeholder="Cc:">
                                    <span >{{item.valor}} </span>

                                </md-autocomplete>
                                <md-chip-template>
                                    <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                </md-chip-template>
                            </md-chips>
                            <md-chips ng-model="cco"
                                      md-transform-chip="transformChip($chip)"
                                      md-item-text="item.valor"
                                      style="height: inherit;"
                                      ng-show="(showHead && showCco)"
                                      md-on-add =" addEmail($chip) "
                                      md-on-remove =" removeEmail($chip) "
                                      ng-style="(selectTo == 1 && cco.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                      skip-tab
                            >
                                <md-autocomplete
                                    md-search-text="searchCco"
                                    md-items="item in correos | stringKey : searchCco : 'valor' | customFind : destinos : isAddMail "
                                    md-item-text="item.valor"
                                    placeholder="Cco:">
                                    <span >{{item.valor}} </span>
                                </md-autocomplete>
                                <md-chip-template>
                                    <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                </md-chip-template>
                            </md-chips>
                            <div layout="row" class="row-min" style="padding-right: 4px;" ng-show="showHead" >
                                <md-input-container flex>
                                    <label>Asunto:</label>
                                    <input  ng-model="asunto" required >
                                </md-input-container>
                            </div>
                            <div layout="row" flex class="text-box" >

                                <div style="" layout="column" >
                                        <textarea ng-model="texto"
                                                  id="textarea"
                                                  required
                                                  flex
                                                  placeholder="Texto"

                                        ></textarea>
                                    <div >
                                    </div>
                                </div>

                            </div>

                        </div>
                    </form>
                    <div  class="blue-btn " ng-click="send()"  skip-tab >
                        <div layout="row" class="layout-row " aria-hidden="true">
                            <div >
                                Enviar
                            </div>
                        </div>
                    </div>
                </div>
                <loader ng-show="inProgress"></loader>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER add contactos para correo ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="addEMail" id="addEMail"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="OrderContactMail"    >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <form name="FormaddEMail" flex layout="row" class="focused">
                        <div class="activeleft"></div>
                        <div layout="column" flex>
                            <div layout="row" >
                                <div class="titulo_formulario">
                                    <div>
                                        Envio de Correo
                                    </div>
                                </div>
                                <div flex layout="row"  layout-align="end start" class="mail-option">
                                    <div layout="row" style="width: 20px" ng-click="showCc = !showCc ; showHead = true ;"   ng-class="{'mail-option-select': (showCc) }">
                                        Cc
                                    </div>
                                    <div layout="row" style="width: 28px" ng-click="showCco = !showCco ;showHead = true ; "  ng-class="{'mail-option-select': (showCco) }">
                                        Cco
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row">
                                <md-switch class="md-primary"
                                           ng-model="usePersonal">
                                </md-switch>
                                <div flex style="padding-top: 12px;">
                                    <span style="margin-left: 8px;">¿Recibir respuesta a mi correo?</span>
                                </div>
                            </div>
                            <md-chips ng-model="to"
                                      id="toaddEMail"
                                      required
                                      md-transform-chip="transformChip($chip)"
                                      style="height: inherit;"
                                      md-on-add =" addEmail($chip) "
                                      md-on-remove =" removeEmail($chip) "
                                      ng-style="(selectTo == 1 && destinos.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                      skip-tab
                            >
                                <md-autocomplete
                                    md-search-text="searchDestinos"
                                    md-items="item in correos  | stringKey : searchDestinos : 'valor' | customFind : destinos : isAddMail "
                                    md-item-text="item.valor"
                                    placeholder="Para:">
                                    <span >{{item.valor}} </span>



                                </md-autocomplete>
                                <md-chip-template>
                                    <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                </md-chip-template>
                            </md-chips>
                            <md-chips ng-model="cc"
                                      md-transform-chip="transformChip($chip)"
                                      style="height: inherit;"
                                      ng-show="(showCc)"
                                      md-on-add =" addEmail($chip) "
                                      md-on-remove =" removeEmail($chip) "
                                      ng-style="(selectTo == 1 && cc.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                      skip-tab
                            >
                                <md-autocomplete
                                    md-search-text="searchCc"
                                    md-items="item in correos | stringKey : searchCc : 'valor' | customFind : destinos : isAddMail  "
                                    md-item-text="item.valor"
                                    placeholder="Cc:">
                                    <span >{{item.valor}} </span>

                                </md-autocomplete>
                                <md-chip-template>
                                    <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                </md-chip-template>
                            </md-chips>
                            <md-chips ng-model="cco"
                                      md-transform-chip="transformChip($chip)"
                                      md-item-text="item.valor"
                                      style="height: inherit;"
                                      ng-show="(showCco)"
                                      md-on-add =" addEmail($chip) "
                                      md-on-remove =" removeEmail($chip) "
                                      ng-style="(selectTo == 1 && cco.length == 0 ) ? {'heigth': '30px'} : {'heigth': 'inherit'}"
                                      skip-tab
                            >
                                <md-autocomplete
                                    md-search-text="searchCco"
                                    md-items="item in correos | stringKey : searchCco : 'valor' | customFind : destinos : isAddMail "
                                    md-item-text="item.valor"
                                    placeholder="Cco:">
                                    <span >{{item.valor}} </span>
                                </md-autocomplete>
                                <md-chip-template>
                                    <strong>{{$chip.valor}}/{{$chip.razon_social}} </strong>
                                </md-chip-template>
                            </md-chips>
                            <div layout="row" class="row-min" style="padding-right: 4px;" >
                                <md-input-container flex>
                                    <label>Asunto:</label>
                                    <input  ng-model="asunto" required skip-tab >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <div   skip-tab class="blue-btn " ng-click="send()" >
                        <div layout="row" class="layout-row " aria-hidden="true">
                            <div >
                                Enviar
                            </div>
                        </div>
                    </div>
                </div>
                <loader ng-show="inProgress"></loader>

            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER crear nuevo producto ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="createProd" id="createProd"
        >
            <md-content   layout="row" flex class="cntLayerHolder" layout-padding >
                <div  layout="column" flex="" class="layerColumn"   click-out="CloseCreateProduct($event)" >
                    <form layout="row" class="focused" name="createdProd" >
                        <div layout="column" flex>
                            <div class="titulo_formulario" >
                                <div>
                                    Crear Producto
                                </div>
                            </div>
                            <md-input-container class="md-block"  >
                                <label>Descripcion</label>
                                <input ng-model="createProd.descripcion"
                                       info="Descripción del producto "
                                       required
                                       skip-tab

                                />
                            </md-input-container>
                            <md-input-container class="md-block"  >
                                <label>Cantidad</label>
                                <input ng-model="createProd.saldo"
                                       decimal info="Cantidad del producto a solicitar "
                                       required
                                       skip-tab
                                       decimal

                                />
                            </md-input-container>
                            <md-input-container class="md-block"  >
                                <label>Cod. Fabrica</label>
                                <input ng-model="createProd.codigo_fabrica"
                                       info=" Codigo  de fabrica del producto "
                                       skip-tab
                                       ng-keypress="($event.which === 13)? doClick('#createProd :first '): 0 "

                                />
                            </md-input-container>

                        </div>
                    </form>

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
            ng-mouseleave="showNext(false)" ng-click="next()" click-out="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png") ?>
        </md-sidenav>

        <!------------------------------------------- Alertas ------------------------------------------------>
        <div ng-controller="notificaciones" ng-include="template"></div>
        <!------------------------------------------- files ------------------------------------------------>

        <div ng-controller="FilesController" ng-include="template"></div>

    </div>
</div>

