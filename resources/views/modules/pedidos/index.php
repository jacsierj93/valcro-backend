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

                            <!--  <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                  <label>Pais</label>
                                  <input  type="text" ng-model="filterProv.pais"  tabindex="-1" >
                              </md-input-container>-->

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
                                        <img ng-src="{{(filterProv.op == '+') ? 'images/TrianguloUp.png' : 'images/TrianguloDown.png' }}" >
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

            <div id="listado" flex  style="overflow-y:auto;">
                <div class="boxList"  layout="column" flex ng-repeat="item in search() | orderBy : 'prioridad' "  list-box ng-click="setProvedor(item, this)" ng-init="item.order = 1"
                     ng-class="{'listSel' : (item.id == provSelec.id)}"
                     id="prov{{item.id}}"
                     class="boxList"
                     click-commit="{{index == 0}} " key="setProveedor"
                >

                    <div  style="overflow: hidden; text-overflow: ellipsis;" flex>{{item.razon_social}}</div>
                    <div layout="column" style="height: 54px;">
                        <div style="font-size:14px;"  id="dot-show{{item.id}}" layout="column" flex ng-show="item.show">
                            <spand layout="row" >{{item.text}}</spand>
                            <div layout="row" style="font-size:12px;">
                                <div flex="70"  >Emitidos: </div>
                                <div flex class="text{{item.dias}}">{{item.emit}}</div>
                            </div>

                            <div layout="row" style="font-size:12px;" >
                                <div flex="70" >Revisados: </div>
                                <div style=" font-weight: bolder !important;" flex class="text{{item.dias}}">{{item.review}}</div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" class="dotRow">
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit100,item.review100,100)">
                            <div layout layout-align="center center" class="dot-item emit100" >
                                {{item.emit100}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit90,item.review90,90)">
                            <div layout layout-align="center center" class="dot-item emit90" >
                                {{item.emit90}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) "ng-mouseenter = "showDotData(item,item.emit60,item.review60,60)">
                            <div layout layout-align="center center" class="dot-item emit60">
                                {{item.emit60}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit30,item.review30,30)">
                            <div layout layout-align="center center" class="dot-item emit30" >
                                {{item.emit30}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit7,item.review7,7)">
                            <div layout layout-align="center center" class="dot-item emit7" >
                                {{item.emit7}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit0,item.review0,0)">
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

                    <div layout="column" ng-show="((module.index < 1 || module.layer == 'listPedido') && permit.created)" layout-align="center center" ng-click="menuAgregar()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Crear un nuevo documento
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && Docsession.block && document.permit.update )" ng-click="updateForm()">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Actualizar la  {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <div style="width: 48px; height: 100%;" ng-click="allowEdit()" layout-align="center center" ng-show=" module.layer == 'listProducProv' && !Docsession.block">
                        <div ng-click="OrderlistCreatedProducProvCtrl()" style="width: 24px; margin-top:8px;" ng-show="(!Docsession.block)" ng-disabled="(Docsession.block)">
                            <span class="icon-Agregar" style="font-size: 24px; float: right; color: #0a0a0a"></span>
                        </div skip-tab >
                        <md-tooltip >
                            Crear Producto
                        </md-tooltip>
                    </div>
                    <div layout="column"
                         ng-show="(!document.doc_parent_id && provSelec.id && module.layer == 'detalleDoc')"
                         layout-align="center center" ng-click="openImport()">
                        <span class="icon-Importar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Importar
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center" ng-controller="OrderAccCopyDoc"
                         ng-show="( document.id && Docsession.isCopyableable && document.permit.update)"
                         ng-click="copyDoc()">
                        <span class="icon-Copiado" style="font-size: 24px"> </span>
                        <md-tooltip >
                            Crear una copia (Sin adjuntos)
                        </md-tooltip>
                    </div>

                    <div layout="column" layout-align="center center"  ng-click="OrderAprobCtrl();" ng-class="{'blue':document.isAprobado}"  ng-show="document.id" >
                        <span class="icon-checkMark" style="font-size: 24px"></span>
                        <md-tooltip >
                            Aprobar
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="document.id"  ng-click="OrderCancelDocCtrl();" >
                        <img src="images/CancelarDocumento.png">
                        <md-tooltip>
                            Cancelar
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="( document.id &&  document.version && document.version > 1 && module.layer == 'detalleDoc' )"
                         ng-click="OrderOldDocsCtrl()">
                        <span style="font-size: 24px"> OLD </span>
                        <md-tooltip >
                            Ver las versiones anteriores de la {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <!--<div layout="column" layout-align="center center"

                         ng-click="test()">
                        <span style="font-size: 24px"> TEst </span>
                        <md-tooltip >
                            Ver las versiones anteriores de la {{formMode.name}}
                        </md-tooltip>
                    </div>-->

                </div>

                <div layout="row" flex layout-align="start center ">

                </div>
                <div style="width: 48px;" layout="column"   layout-align="center center" id="noti-button" ng-show="module.index == 0">
                    <div class="{{(alerts.length > 0 ) ? 'animation-arrow' : 'animation-arrow-disable'}}" ng-click="OrderModuleMsmCtrl();" id="noti-button"
                         layout="column" layout-align="center center"  style=text-align:center; >
                        <img ng-src="images/btn_prevArrow.png" style="width: 14px;margin-top: 8px;" />
                    </div>
                    <md-tooltip>
                        {{alerts.length > 0 ? 'Tiene notificaciones pendiente por revisar, haz click aqui para verlas' : 'Sin Notificaciones por revisar, gracias por estar pendiente '}}
                    </md-tooltip>
                </div>

                <!-- <div style="width: 48px;" layout="column"   layout-align="center center" id="noti-button" ng-show="module.layer == 'detalleDoc'">
                     Cl
                     <md-tooltip>
                         {{alerts.length > 0 ? 'Tiene notificaciones pendiente por revisar, haz click aqui para verlas' : 'Sin Notificaciones por revisar, gracias por estar pendiente '}}
                     </md-tooltip>
                 </div>-->
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
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderlistImportCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >  Correos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" class="table-filter">
                        <div active-left ></div>
                        <div layout="row" class="row" flex tyle="padding-right: 4px;">
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                            </div>

                            <div layout="row" style="width: 8px;">
                                <md-input-container class="md-block"  flex>
                                    <label>Emision</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>
                            </div>
                            <div layout="row" style="width: 8px;">
                                <md-input-container class="md-block"  flex>
                                    <label></label>
                                    <md-select ng-model="tbl.filter.diasEmit"  ng-init="tbl_listImport.filter.diasEmit = '-1'">
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
                                <grid-order-by ng-model="tbl" key="diasEmit"></grid-order-by>
                            </div>

                            <div layout="row" style="width: 8px;">
                                <md-input-container class="md-block"  flex>
                                    <label>Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>
                            </div>
                            <div layout="row" style="width: 8px;">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div layout="row" style="width: 8px;">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="comentario"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <form  flex layout="row"  class="gridContent">
                        <div active-left before="verificExit" ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in filterDocuments(tbl.data, tbl_listImport.filter) | orderBy : tbl.data.order as filter" >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="docImport(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)"> {{item.nro_proforma}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)"> {{item.emision| date:'dd/MM/yyyy' }}</div>
                                    <div class="cellGrid" ng-click="docImport(item)">
                                        <div style="width: 16px; height: 16px; border-radius: 50%"
                                             class="emit{{item.diasEmit}}"></div>                                    </div>
                                    <div  class="cellGrid" ng-click="docImport(item)" > {{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)" > {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                    <div flex class="cellGrid" ng-click="docImport(item)" >{{item.comentario}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filter.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </div>
                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listEmailsImport" id="listEmailsImport">
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderlistEmailsImportCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >  Correos</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div layout="row" class="table-filter">
                        <div active-left ></div>
                        <div layout="row" class="row" flex tyle="padding-right: 4px;">
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Enviado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_envio"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_envio"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Asunto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.asunto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="Asunto"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Contenido</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.contenido"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="contenido"></grid-order-by>
                            </div>
                            <div layout="row" style="width: 80px;">
                                <md-input-container class="md-block"  flex>
                                    <label>Adjs.</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.adjs"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="adjs"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <div class="gridContent" flex   >
                        <div   ng-repeat="item in tbl.data" ng-click="test('email')">
                            <div layout="row" class="cellGridHolder" >
                                <div flex class="cellGrid"  >{{item.fecha_envio}}</div>
                                <div flex class="cellGrid"  >{{item.asunto}}</div>
                                <div flex= class="cellGrid" > {{item.contenido}}</div>
                                <div  style="width: 80px;" > {{item.adjs}}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER LISTA DE PEDIDOS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listPedido" id="listPedido">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderlistPedidoCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >{{provSelec.razon_social}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div layout="row" class="table-filter">
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div layout="row" class="row" flex ng-init="docOrder.order == id " tyle="padding-right: 4px;">
                            <div class="cellEmpty"> </div>
                            <div layout="row" style="width: 120px;" >
                                <md-select ng-model="tbl.filter.documento" ng-init="tbl.filter.documento ='-1'" flex style="">
                                    <md-option value="-1" layout="row" style="overflow: hidden;">
                                        <img ng-src="images/Documentos.png" style="width:20px;"/> Todos
                                    </md-option>
                                    <md-option value="21" layout="row" >
                                        <img ng-src="images/solicitud_icon_48x48.gif" style="width:20px;">Solicitud
                                    </md-option>
                                    <md-option value="22" layout="row">
                                        <img ng-src="images/proforma_icon_48x48.gif" style="width:20px;">Proforma

                                    </md-option>
                                    <md-option value="23" layout="row">
                                        <img ng-src="images/odc_icon_48x48.gif" style="width:20px;">ODC
                                    </md-option>
                                </md-select>
                                <grid-order-by ng-model="tbl" key="documento"></grid-order-by>
                            </div>

                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Emision</label>
                                    <input type="text" class="inputFilter"  ng-minlength="1"
                                           ng-model="tbl.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container >
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>

                            </div>
                            <div style="width: 80px; color: white;" layout="row">
                                <md-select ng-model="tbl.filter.diasEmit"  ng-init="tbl.filter.diasEmit = '-1'">
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
                                <grid-order-by ng-model="tbl" key="diasEmit"></grid-order-by>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>


                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="comentario"></grid-order-by>

                            </div>
                            <div style="width: 80px;"></div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div layout="column" flex="" ng-mouseleave="hoverLeave(false)"  >
                            <div   ng-repeat="item in filterDocuments(tbl.data, tbl.filter) | orderBy : docOrder.order as filter"   id="doc{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div  class=" cellEmpty" ng-mouseover="hoverpedido(item)"  ng-mouseenter="hoverEnter()" ng-mouseleave="hoverLeave(false)"  ng-click="DtPedido(item)"> </div>
                                    <div style="width: 120px;" class="cellEmpty cellSelect"  ng-mouseover="hoverPreview(true)" tabindex="{{$index + 1}}">

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
                                    <div flex="10" class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                    <div flex class="cellGrid" ng-mouseover="hoverPreview(true)" ng-click="DtPedido(item)">{{item.comentario}}</div>
                                    <div style="width: 80px; text-align: -webkit-center;"  class="cellEmpty "
                                         layout-align="center center" layout="row"
                                         ng-click="addAnswer(item)"
                                    >
                                        <div class="dot-empty dot-attachment "  layout-align="center center" >
                                            <div style=" margin-top: 2.5px;">M</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filter.length == 0 " flex>
                                No hay datos para mostrar
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
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'cod_producto' " ><img ng-src="{{(tblResumenPe.order == 'cod_producto') ?'images/TrianguloUp.png' : 'images/Triangulo_2_claro-01.png'}}"></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-cod_producto' " ><img ng-src="{{(tblResumenPe.order == 'cod_producto') ?'images/TrianguloUp.png' : 'images/Triangulo_1_claro.png'}}"/></div>
                            </div>
                            <md-input-container class="md-block"  flex>
                                <label>Codigo</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.cod_producto"
                                       skip-tab
                                >
                            </md-input-container>

                        </div>
                        <div flex layout="row"  >
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'descripcion' " ><img ng-src="{{(tblResumenPe.order == 'descripcion')?'images/TrianguloUp.png' : 'images/Triangulo_2_claro-01.png'}}"></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-descripcion' "><img ng-src="{{(tblResumenPe.order == '-descripcion') ?'images/TrianguloUp.png' : 'images/Triangulo_1_claro.png'}}"/></div>
                            </div>

                            <md-input-container class="md-block"  flex>
                                <label>Descripicion</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.descripcion"
                                       skip-tab
                                >
                            </md-input-container>

                        </div>

                        <div flex layout="row"  >
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'documento' " ><img ng-src="{{(tblResumenPe.order == 'documento')?'images/TrianguloUp.png' : 'images/Triangulo_2_claro-01.png'}}"></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-documento' " ><img ng-src="{{(tblResumenPe.order == '-documento')?'images/TrianguloUp.png' : 'images/Triangulo_1_claro.png'}}"/></div>
                            </div>

                            <md-input-container class="md-block"  flex>
                                <label>Origen</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.documento"
                                       skip-tab
                                >
                            </md-input-container>

                        </div>

                        <div flex="10" layout="row"  >
                            <div class="cell-filter-order" layout-align="center center" layout="column" >
                                <div  layout-align="end center" ng-click="tblResumenPe.order = 'saldo' " ><img ng-src="{{(tblResumenPe.order == 'saldo') ?'images/TrianguloUp.png' : 'images/Triangulo_2_claro-01.png'}}"></div>
                                <div layout-align="star center" ng-click="tblResumenPe.order = '-saldo' " ><img ng-src="{{(tblResumenPe.order == '-saldo')?'images/TrianguloUp.png' : 'images/Triangulo_1_claro.png'}}"/></div>
                            </div>

                            <md-input-container class="md-block"  flex>
                                <label>Cantidad</label>
                                <input type="text" class="inputFilter"  ng-minlength="1"
                                       ng-model="tblResumenPe.filter.saldo"
                                       skip-tab
                                >
                            </md-input-container>

                        </div>

                    </form>
                    <form layout="row"  class="gridContent">
                        <div  layout="column" flex="">
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in resumen.productos.todos |filter: tblResumenPe.filter:strict | orderBy :tblResumenPe.order as filterResumenPed" id="resumenPeItem{{$index}}" row-select>
                                    <div flex="15" class="cellSelect cellEmpty" tabindex="{{$index + 1}}" > {{item.cod_producto}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
                                    <div flex="10" class="cellGrid"> {{item.saldo}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="listInportFilter.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </div>
                    </form>
                </div>

                <div style="width: 16px;" ng-mouseover="showNext(true)"  > </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER MENU AGREGAR DOCUMENTO  ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="menuAgr" id="menuAgr">

            <md-content  layout="row" flex class="sideNavContent" flex ng-controller="OrderMenuAgrCtrl"  >
                <div active-left before="verificExit" ></div>
                <div style="width: 96px" layout="column" layout-align="space-between start">
                    <div class="docButton" layout="column" flex  ng-click="openEmail()">
                        <img ng-src="images/mail_icon_48x48.gif" width="48" height="48"/>
                        <md-tooltip md-direction="right">
                            Correo
                        </md-tooltip>

                    </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.solicitud)">
                        <img ng-src="images/solicitud_icon_48x48.gif" width="48" height="48"/>
                        <md-tooltip md-direction="right">
                            Solicitud
                        </md-tooltip>
                    </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.proforma)">
                        <img ng-src="images/proforma_icon_48x48.gif"  width="48" height="48"/>
                        <md-tooltip md-direction="right">
                            Proforma
                        </md-tooltip>
                    </div>
                    <div class="docButton" layout="column" flex ng-click="newDoc(forModeAvilable.odc)">
                        <img ng-src="images/odc_icon_48x48.gif"  width="48" height="48"/>
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
                <loader ng-show="inProgress"></loader>

            </md-content>
        </md-sidenav>

        <!-- ) ########################################## LAYER  FORMULARIO INFORMACION DEL DOCUMENTO ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="detalleDoc" id="detalleDoc">
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderDetalleDocCtrl" >
                <div  layout="column" flex="" layout-align=" none" >
                    <form name="FormHeadDocument" layout="row" ng-class="{focused: gridView == 1}" ng-style="(gridView != 5 && tbl_dtDoc.extend == 0 ) ? {'min-height' : '320px'} : {} ">
                        <div active-left></div>
                        <div layout="column" flex ng-init=" tbl_dtDoc.extend = 0" >
                            <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':gridView == 1}"  ng-click="gridView = 1">
                                <div class="titulo_formulario" style="height:39px;" flex >
                                    <div>
                                        Datos de {{formMode.name}}
                                    </div>
                                </div>

                            </div>
                            <div   ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex ng-click="allowEdit()" >
                                    <label>Proveedor</label>
                                    <md-autocomplete md-selected-item="$parent.ctrl.provSelec"
                                                     info="Seleccione un proveedor para el documento"
                                                     required
                                                     ng-disabled="( $parent.document.uid == null || $parent.Docsession.block )"
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
                                                     md-item-change="toEditHead('document','prov_id',($parent.ctrl.provSelec)  ?  $parent.ctrl.provSelec.id : undefined );$scope.$parent.document.prov_id = $parent.ctrl.provSelec.id ;"


                                    >
                                        <md-item-template>
                                            <span>{{item.razon_social}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro el proveedor {{searchProveedor}}. ¿Desea crearlo?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado: </div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <div>{{document.emision | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>

                            </div>

                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container   ng-show="( gridView != 5 )"  class="md-block" flex ng-click="allowEdit()" >
                                    <label>Titulo</label>
                                    <input  ng-model="$parent.document.titulo"
                                            ng-change=" toEditHead('document','titulo', $parent.document.titulo ) "
                                            ng-disabled="( $parent.Docsession.block )"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del documento"
                                            skip-tab


                                    >
                                </md-input-container>
                            </div>

                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row"  >
                                <md-input-container class="md-block" flex="40" ng-click="allowEdit()"  alert="{'none':'No hay data para '+provSelec.razon_social} " alert-show="(formData.paises.length > 0) ? '': 'none'" >
                                    <label>Pais</label>
                                    <md-autocomplete md-selected-item="$parent.document.objs.pais_id"
                                                     info="'Selecione el pais de origen de los productos'"
                                                     ng-disabled="( $parent.Docsession.block || !$parent.provSelec.id )"
                                                     ng-click="$parent.toEditHead('pais_id', $parent.document.pais_id)"
                                                     skip-tab
                                                     md-search-text="$parent.ctrl.searchPais"
                                                     md-items="item in formData.paises | stringKey : ctrl.searchPais : 'short_name' "
                                                     md-item-text="item.short_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-item-change="toEditHead('document','pais_id',($parent.document.objs.pais_id)  ?  $parent.document.objs.pais_id : undefined );"



                                    >
                                        <md-item-template>
                                            <span>{{item.short_name}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro el país
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block"  flex ng-click="allowEdit()" alert="{'none':'No se le han creado direciones de facturacion a '+provSelec.razon_social} " alert-show="(formData.direccionesFact.length > 0) ? '': 'none'" >
                                    <label>Direccion Facturacion</label>
                                    <md-autocomplete md-selected-item="$parent.document.objs.direccion_facturacion_id"
                                                     ng-disabled="( $parent.Docsession.block || $parent.provSelec.id == '' ||  !$parent.provSelec.id)"
                                                     ng-click="toEditHead('direccion_facturacion_id', $parent.document.direccion_facturacion_id)"
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
                                                     md-item-change="toEditHead('document','direccion_facturacion_id',($parent.document.objs.pais_id)  ?  $parent.document.objs.pais_id: undefined );"


                                    >
                                        <md-item-template>
                                            <span>{{item.direccion}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la dirección
                                        </md-not-found>
                                    </md-autocomplete>

                                </md-input-container>
                            </div>
                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >

                                <md-input-container class="md-block"  flex ng-click="allowEdit()"  alert="{'none':'No se la han asignado direcciones de almacen a'+provSelec.razon_social} " alert-show="(formData.direcciones.length > 0) ? '': 'none'">
                                    <label>Direccion almacen</label>
                                    <md-autocomplete md-selected-item="$parent.document.objs.direccion_almacen_id"
                                                     ng-disabled="( Docsession.block || provSelec.id == '' ||  !provSelec.id  || document.objs.pais_id ==  null )"
                                                     info="'Selecione la direccion que debe especificarse en la factura"
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
                                            No se encontro la direccion  ¿Desea crearla?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block"  flex ng-click="allowEdit()" alert="{'none':'No se le han asignado puertos a'+provSelec.razon_social} " alert-show="(formData.puertos.length > 0) ? '': 'none'">
                                    <label>Puerto</label>
                                    <md-autocomplete md-selected-item="$parent.document.objs.puerto_id"
                                                     ng-disabled="( $parent.Docsession.block || $parent.provSelec.id == '' ||  !$parent.provSelec.id || $parent.document.objs.direccion_almacen_id == null)"
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
                                            No se encontro el puerto  {{ctrl.searchPuerto}}. ¿Desea asignarlo?
                                        </md-not-found>

                                    </md-autocomplete>
                                </md-input-container>
                            </div>
                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex="15" ng-click="allowEdit()">
                                    <label>Monto</label>
                                    <input  ng-model="$parent.document.monto"
                                            decimal
                                            ng-disabled="( Docsession.block )"
                                            required
                                            ng-change="toEditHead('document', 'monto', $parent.document.monto)"
                                            info="Monto aproximado a pagar"
                                            skip-tab
                                            type="text"
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" ng-click="allowEdit()" alert="{'none':'No se le han asignado monedas a'+provSelec.razon_social} " alert-show="(formData.monedas.length > 0) ? '': 'none'">
                                    <label>Moneda</label>
                                    <md-autocomplete md-selected-item="$parent.document.objs.prov_moneda_id"
                                                     ng-disabled="( Docsession.block || provSelec.id == '' ||  !provSelec.id )"
                                                     required
                                                     ng-click="toEditHead('prov_moneda_id', $parent.document.prov_moneda_id)"
                                                     info="Seleccione la moneda en la que se realizara el pago "
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
                                                     md-selected-item-change="changeProvMoneda(document.objs.prov_moneda_id)"
                                    >
                                        <md-item-template>
                                            <span>{{item.nombre}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la moneda
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" ng-dblclick="editTasa()"  ng-click="allowEdit()">
                                    <label>Tasa</label>
                                    <input  ng-model="$parent.document.tasa"
                                            ng-disabled="( Docsession.block || document.prov_moneda_id == '' ||  !document.prov_moneda_id)"
                                            ng-readonly="isTasaFija"
                                            ng-required="$parent.document.objs.prov_moneda_id && !$parent.document.tasa "
                                            info="Tasa segun la moneda selecionada"
                                            ng-change="toEditHead('document', 'tasa', $parent.document.tasa)"
                                            skip-tab
                                            id="tasa"
                                            decimal
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="" ng-click="allowEdit()" alert="{'none':'No se le ha asignado condiciones de pago a '+provSelec.razon_social} " alert-show="(formData.condicionPago.length > 0) ? '': 'none'">
                                    <label>Condicion de pago</label>
                                    <md-autocomplete md-selected-item = "$parent.document.objs.condicion_pago_id"
                                                     ng-disabled = "( Docsession.block  || !provSelec.id)"
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
                                                     md-selected-item-change=" toEditHead('document','condicion_pago_id',($parent.document.objs.condicion_pago_id)  ?  $parent.document.objs.condicion_pago_id: undefined );"
                                    >
                                        <md-item-template>
                                            <span>{{item.titulo}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la condicion de pago {{ctrl.searchcondPagoSelec}}. ¿Desea crearla?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

                            </div>
                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0  )"  layout="row" class="row" >


                                <md-input-container class="md-block" flex  >
                                    <label>N° Factura:</label>
                                    <input ng-model="$parent.document.nro_factura.doc"  ng-disabled="( Docsession.block)"
                                           ng-change="toEditHead('document', 'nro_factura', $parent.document.nro_factura)"
                                           info="Introducir Nro de factura en caso de tenerla"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div class="adj-box" ng-click="$parent.OrderNrFacturaCtrl()">
                                    <div   class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">
                                        {{ $parent.document.nro_factura.adjs.length || 0 }}
                                    </div>
                                </div>


                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="$parent.document.nro_proforma.doc"  ng-disabled="( Docsession.block)"
                                           ng-required ="(formMode.value == 22 || formMode.value == 23 )"
                                           ng-change="toEditHead('document', 'nro_proforma', $parent.document.nro_proforma)"
                                           info="Introducir Nro de proforma en caso de tenerla"
                                           skip-tab

                                    >
                                </md-input-container>
                                <div  class="adj-box" ng-click="$parent.OrderNrProformaCtrl()" >
                                    <div  class="vlc-buttom" ng-class="{'ng-disable':Docsession.block}"  style="float:left">
                                        {{ $parent.document.nro_proforma.adjs.length || 0 }}
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex="10">
                                    <label>Mt3</label>
                                    <input ng-model="$parent.document.mt3"  name="mt3"
                                           ng-model="number" decimal
                                           ng-disabled="( $parent.Docsession.block)"
                                           ng-change="toEditHead('document','mt3', document.mt3)"
                                           info="Metros cubicos"
                                           skip-tab
                                    >
                                </md-input-container>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="$parent.document.peso" name="peso" decimal
                                           ng-disabled="( $parent.Docsession.block)"
                                           ng-change="toEditHead('document','peso', $parent.document.peso)"
                                           info="Sumatoria de los pesos de productos"
                                           skip-tab
                                    >
                                </md-input-container>

                            </div>

                            <div ng-show="( gridView != 5 && tbl_dtDoc.extend == 0 )"  layout="row" class="row" >
                                <md-input-container class="md-block" flex >
                                    <label>Comentario</label>
                                    <input ng-model="$parent.document.comentario"  ng-disabled="( $parent.Docsession.block)"
                                           ng-change="$parent.toEditHead('documento','nro_proforma', $parent.document.nro_proforma)"
                                           info="Algun texto adicional referente al documento"
                                           skip-tab

                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>

                    <div  class="form-style" layout="row" ng-class="{focused: (gridView == 5)}" ng-show="tbl_dtDoc.extend == 0 && document.productos.todos.length > 0 ">
                        <div active-left></div>
                        <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':gridView == 5}" flex>
                            <div class="titulo_formulario" style="height:39px;" flex  ng-click="gridView = 5" >
                                <div>
                                    Productos agregados
                                </div>
                            </div>
                            <div layout-align="center center" layout="column">
                                <span style="color: #1f1f1f" ng-show="($parent.document.productos.todos.length > 0 )">
                                        ({{$parent.document.productos.todos.length}})</span>
                            </div>
                        </div>

                    </div>
                    <div  class="form-style" layout="row" ng-class="{focused: (gridView == 5) }">
                        <div active-left></div>
                        <div layout="row" flex ng-init="tbl_dtDoc.order = 'id' " class="row">
                            <div flex="5"></div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl_dtDoc.filter.cod_producto">
                                </md-input-container>
                                <grid-order-by ng-model="tbl_dtDoc" key="cod_producto"></grid-order-by>

                            </div>

                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Descripcion</label>
                                    <input  ng-model="tbl_dtDoc.filter.descripcion"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_dtDoc" key="descripcion"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Documento</label>
                                    <input  ng-model="tbl_dtDoc.filter.documento"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_dtDoc" key="documento"></grid-order-by>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cantidad</label>
                                    <input  ng-model="tbl_dtDoc.filter.saldo"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_dtDoc" key="saldo"></grid-order-by>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Costo</label>
                                    <input  ng-model="tbl_dtDoc.filter.costo_unitario"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_dtDoc" key="costo_unitario"></grid-order-by>
                            </div>
                        </div>

                    </div>
                    <div class="gridContent form-style"  layout="row"  flex >
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div ng-repeat="item in filterProdDoc(document.productos.todos,tbl_dtDoc.filter) | orderBy : tbl_dtDoc.order as docProdFilter " id="prodDt{{$index}}" row-select>
                                    <div layout="row" class="cellGridHolder" OrderminiChangeItemCtrl>
                                        <div flex="5" class="cellEmpty" ng-click="changeProd(item)" >
                                            <md-switch class="md-primary"
                                                       ng-disabled="true" ng-model="item.asignado"> </md-switch>
                                        </div>
                                        <div flex="10" class="cellSelect" ng-click="openProd(item)" > {{item.codigo}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)">  {{item.descripcion}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)" > {{item.documento}}</div>
                                        <div flex="10" class="cellGrid"  ng-click="openProd(item)" > {{item.saldo}}</div>
                                        <div flex="10" class="cellGrid"  ng-click="openProd(item)" > {{item.costo_unitario}}</div>

                                    </div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="docProdFilter.length == 0 && tbl_dtDoc.extend == 0 && Docsession.global == 'upd' && document.productos.todos.length > 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </div>
                   </div><!--
                    <div layout="column"  class="row" ng-click=" tbl_dtDoc.extend = ( tbl_dtDoc.extend == 0) ? 1: 0 " ng-show="docProdFilter.length > 0 && (gridView == 5) ">
                        <div flex style="border: dashed 1px #f1f1f1; text-align: center" layout="column" layout-align="end none">
                            <span class="{{ ( tbl_dtDoc.extend == 0) ? 'icon-Up' : 'icon-Above' }}"></span>
                        </div>
                    </div>-->

                </div>
                <div   id="expand"></div>
                <div style="width: 16px;"  ng-mouseenter="(gridView == 3) ? saveAprobCompras(): 0 ; (canNext()) ? $parent.showNext(true) :0 ;$parent.nextLayer = $parent.OrderlistProducProvCtrl" > </div>
            </md-content>
        </md-sidenav>

        <!--  ########################################## LAYER Agregar Pedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px;" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrPed" id="agrPed">
            <!-- ) ########################################## Agregar Pedidos ########################################## -->
            <md-content  layout="row" class="sideNavContent" flex ng-init="overSusitu = -1" ng-controller="OrderAgrPedCtrl">
                <div active-left></div>
                <div layout="row" flex>
                    <div layout="column" flex>
                        <div layout="row" class="form-row-head form-row-head-select " >
                            <div class="titulo_formulario" style="height:39px;" flex >
                                <div>
                                    Contrapedidos
                                </div>
                            </div>
                            <div layout=""  layout-align="center center"  ng-click="openCp()">
                                <div layout layout-align="center center" class="circle" >
                                    {{document.productos.contraPedido.length}}
                                </div>
                            </div>
                        </div>
                        <div  layout="column" class="gridContent" flex  style="margin-left: 8px; margin-top: 8px;">
                            <div >
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.contraPedido as filteragrePed">

                                    <div flex="" class="cellGrid" ng-click="selecContraP(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="selecContraP(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filteragrePed.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </div>
                    </div>
                    <div layout="column" flex style="margin-left: 4px;">

                        <div layout="row" class="form-row-head form-row-head-select " >
                            <div class="titulo_formulario" style="height:39px;" flex >
                                <div>
                                    KitchenBoxs
                                </div>
                            </div>
                            <div layout=""  layout-align="center center"  ng-click="openk()">
                                <div layout layout-align="center center" class="circle" >
                                    {{document.productos.kitchenBox.length}}
                                </div>
                            </div>
                        </div>
                        <form  layout="column" class="gridContent" flex  style="margin-top: 8px;">
                            <div>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.kitchenBox as filteragrKicthe" ng-class="{resalt : overSusitu == item.sustituto }">
                                    <div flex class="cellGrid" ng-click="selecKitchenBox(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid"ng-click="selecKitchenBox(item)" > {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filteragrKicthe.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </form >

                    </div>

                    <div layout="column" flex  style="margin-left: 4px;" >
                        <div layout="row" class="form-row-head form-row-head-select " >
                            <div class="titulo_formulario" style="height:39px;" flex >
                                <div>
                                    {{formMode.name}} a Sustituir
                                </div>
                            </div>
                            <div layout=""  layout-align="center center"  ng-click="openSust()">
                                <div layout layout-align="center center" class="circle" >
                                    {{document.productos.pedidoSusti.length}}
                                </div>
                            </div>
                        </div>
                        <form  layout="column" class="gridContent" flex  style="margin-top: 8px;">
                            <div>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in document.productos.pedidoSusti as filteragrPed" ng-mouseover = "overSusitu =  item.id">
                                    <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="selecPedidoSust(item)"> {{item.emision | date:'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filteragrPed.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </form>

                    </div>

                </div>
                <div style="width: 16px;"  ng-mouseenter="(canNext()) ? $parent.showNext(true) :0 ;$parent.nextLayer = next " > </div>


            </md-content>
        </md-sidenav>

        <!--  ########################################## LAYER PRODUCTOS PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="listProducProv" id="listProducProv">
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderlistProducProvCtrl">
                <div  layout="column" flex class="layerColumn" >

                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >  Productos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  layout="row" class="row">
                        <div active-left ></div>
                        <md-input-container class="md-block"  flex >
                            <label>Linea</label>
                            <md-autocomplete md-selected-item="lineaSelec"
                                             info="Linea del producto "
                                             skip-tab
                                             md-search-text="lineaText"
                                             md-auto-select="true"
                                             md-items="item in lineas | stringKey : lineaText : 'linea' "
                                             md-item-text="item.linea"
                                             md-autoselect = "true"
                                             md-no-asterisk
                                             md-min-length="0"
                                             md-require-match="true"
                                             md-no-cache="true"
                                             md-select-on-match
                                             md-selected-item-change="tbl_listProducProv.filter.linea_id = (lineaSelec.id && lineaSelec.id != 0 ) ? lineaSelec.id : undefined ;"
                            >
                                <md-item-template>
                                    <span>{{item.linea}}</span>
                                </md-item-template>
                            </md-autocomplete>
                        </md-input-container>
                        <md-input-container class="md-block"   flex>
                            <label>Sub-Linea</label>
                            <md-autocomplete md-selected-item="SublineaSelec"
                                             info="Sub linea  del producto "
                                             skip-tab
                                             md-search-text="SublineaText"
                                             md-items="item in subLineas | stringKey : lineaText : 'linea'  "
                                             md-item-text="item.sublinea"
                                             md-min-length="0"
                                             md-no-cache="true"
                                             md-select-on-match
                                             md-selected-item-change="tbl_listProducProv.filter.sub_linea = SublineaSelec.id;"
                                             ng-disabled="!lineaSelec"
                            >
                                <md-item-template>
                                    <span>{{item.sublinea}}</span>
                                </md-item-template>
                            </md-autocomplete>
                        </md-input-container>
                    </div>
                    <div  layout="row" class="row" style="margin-bottom: 10px;">
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
                                    <grid-order-by ng-model="tbl_listProducProv" key="codigo"></grid-order-by>
                                </div>
                                <div layout="row" flex="20">

                                    <md-input-container class="md-block" flex>
                                        <label>Cod. Fabrica</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl_listProducProv.filter.codigo_fabrica"
                                               skip-tab

                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl_listProducProv" key="codigo_fabrica"></grid-order-by>
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
                                    <grid-order-by ng-model="tbl_listProducProv" key="descripcion"></grid-order-by>
                                </div>
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
                                    <grid-order-by ng-model="tbl_listProducProv" key="saldo"></grid-order-by>

                                </div>
                            </div>
                        </div>
                    </div>
                    <form  name="listProductoItems" class="gridContent"  layout="row" flex OrderCreatProductCtrl >
                        <div active-left ></div>
                        <div  flex layout="column">
                            <div   ng-repeat="item in providerProds | filter:tbl_listProducProv.filter:strict | orderBy : tbl_listProducProv.order  as filterProductProv"
                                   ng-mouseenter = "mouseEnterProd(item) " row-select >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex="5" class="cellEmpty cellSelect">
                                        <md-switch class="md-primary"  ng-click="change(item, $event)"  ng-disabled="(true)" ng-model="item.asignado"></md-switch>
                                    </div>
                                    <div flex="20" class="cellGrid" ng-click="openItem(item)"> {{item.codigo}}</div>
                                    <div flex="20" class="cellGrid" ng-click="openItem(item)"> {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid" ng-click="openItem(item)"> {{item.descripcion}}</div>
                                    <div flex="15" class="cellGrid" ng-click="openItem(item)"> {{item.cantidad}}</div><!--cantidad total asignada -->
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filterProductProv.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </div>

                    </form>
                </div>
                <div style="width: 16px;"  ng-mouseenter="(canNext()) ? $parent.showNext(true) :0 ;$parent.nextLayer = next " > </div>



            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (6) Agregar Contrapedidos ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrContPed" id="agrContPed">
            <md-content layout="row" class="sideNavContent" flex ng-controller="OrderAgrContPed">
                <div  layout="column" flex class="layerColumn" >
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >Agregar ContraPedidos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" ng-init="tbl.order = 'id' ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5" layout="row"  ></div>
                            <div layout="row" flex="10">
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="codigo"></grid-order-by>
                            </div>
                            <div layout="row" flex="">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.codigo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>
                            </div>
                            <div layout="row" flex="10">
                                <md-input-container class="md-block"  flex>
                                    <label>Entrega</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_aprox_entrega"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_aprox_entrega"></grid-order-by>
                            </div>
                            <div layout="row" flex="15">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div layout="row" flex="">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="comentario"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <div flex name="addContraPedidos" class="gridContent" layout="row" >
                        <div active-left></div>
                        <div flex >
                            <div layout="row" class="cellGridHolder" ng-repeat="item in filterContraPed(tbl.data,tbl.filter) | orderBy: tbl.order as filter">
                                <div class="cellEmpty" flex="5" ng-click="change(item)">
                                    <md-switch class="md-primary" ng-disabled="true" ng-model="item.asignado" ></md-switch>
                                </div>
                                <div flex="10" class="cellGrid" ng-click="open(item)"> {{item.fecha | date:'dd/MM/yyyy' }}</div>
                                <div flex class="cellGrid" ng-click="open(item)"> {{item.titulo}}</div>
                                <div flex="10" class="cellGrid" ng-click="open(item)"> {{item.fecha_aprox_entrega | date:'dd/MM/yyyy' }}</div>
                                <div flex="15" class="cellGrid" ng-click="open(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                <div flex class="cellGrid" ng-click="open(item)"> {{item.comentario}}</div>

                            </div>
                            <div layout="column" layout-align="center center" ng-show="filter.length == 0 " flex>
                                No hay datos para mostrar
                            </div>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER (7) Agregar KITCHEN BOXS ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="agrKitBoxs" id="agrKitBoxs">
            <!-- ) ########################################## CONTENDOR Agregar KITCHEN BOXS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderAgrKitBoxsCtrl">
                <div  layout="column" flex class="layerColumn" >
                    <div layout="row" class="focused">
                        <div active-left></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span > KitchenBoxs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left></div>
                        <div flex="5"></div>
                        <div flex="10" layout="row">
                            <md-input-container class="md-block" flex >
                                <label>Fecha</label>
                                <input  ng-model="tbl.filter.fecha"
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl" key="fecha"></grid-order-by>
                        </div>
                        <div flex="15"  layout="row">
                            <md-input-container class="md-block" flex >
                                <label>Proforma</label>
                                <input  ng-model="tbl.filter.num_proforma"
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl" key="num_proforma"></grid-order-by>
                        </div>
                        <div flex="" layout="row">
                            <md-input-container class="md-block" flex >
                                <label>Adjunto</label>
                                <input  ng-model="tbl.filter.img_proforma"
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl" key="img_proforma"></grid-order-by>
                        </div>
                        <div flex="10" layout="row">
                            <md-input-container class="md-block" flex >
                                <label>Monto</label>
                                <input  ng-model="tbl.filter.monto"
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                        </div>
                        <div flex="15" layout="row">
                            <md-input-container class="md-block" flex >
                                <label>Precio</label>
                                <input  ng-model="tbl.filter.precio"
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl" key="precio"></grid-order-by>
                        </div>
                        <div flex="10" layout="row">
                            <md-input-container class="md-block" flex >
                                <label>Entrega</label>
                                <input  ng-model="tbl.filter.fecha_aprox_entrega"
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl" key="fecha_aprox_entrega"></grid-order-by>
                        </div>
                    </div>
                    <div flex class="gridContent" layout="row">
                        <div active-left></div>
                        <div   layout="column" flex>
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in tbl.data | filter:tbl.filter:strict | orderBy : tbl.order ">
                                    <div class="cellEmpty" flex="5" ng-click="change(item)"  >
                                        <md-switch class="md-primary" ng-model="item.asignado" ng-disabled="true"></md-switch>
                                    </div>
                                    <div flex="10" class="cellGrid" ng-click="open(item)"> {{item.fecha | date:'dd/MM/yyyy'}}</div>
                                    <div flex="15" class="cellGrid" ng-click="open(item)"> {{item.num_proforma}}</div>
                                    <div flex="" class="cellGrid" ng-click="open(item)"> {{item.img_proforma}}</div>
                                    <div flex="15" class="cellGrid" ng-click="open(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                    <div flex="15" class="cellGrid" ng-click="open(item)"> {{item.precio}}</div>
                                    <div flex="10" class="cellGrid"  ng-click="open(item)" > {{item.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </md-content>
        </md-sidenav>

        <!-- 17) ########################################## LAYER (8) Pedidos Pendientes########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="OrderAgrPedPend" id="OrderAgrPedPend">

            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderAgrPedPendCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >  {{formMode.name}} Pendientes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5"></div>

                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Proforma</label>
                                    <input  ng-model="tbl.filter.nro_proforma"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Fecha</label>
                                    <input  ng-model="tbl.filter.emision"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>
                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Factura</label>
                                    <input  ng-model="tbl.filter.nro_factura"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>
                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Monto</label>
                                    <input  ng-model="tbl.filter.monto"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div><div flex="" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Comentario</label>
                                    <input  ng-model="tbl.filter.comentario"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="comentario"></grid-order-by>
                            </div>
                        </div>

                    </div>
                    <div name=""  class="gridContent" layout="row" >
                        <div active-left></div>
                        <div  layout="column" flex>
                            <div flex>
                                <div layout="row" class="cellGridHolder" ng-repeat="item in tbl.data | filter:tbl.filter:strict | orderBy: tbl.order " >
                                    <div flex="5" class="cellEmpty" ng-click="change(item)">
                                        <md-switch class="md-primary" ng-model="item.asignado"

                                                   ng-disabled="true"></md-switch>
                                    </div>
                                    <div flex="10" class="cellGrid" ng-click="open(item)">{{item.nro_proforma}}</div>
                                    <div flex="10" class="cellGrid" ng-click="open(item)">{{item.emision | date:'dd/MM/yyyy'}}</div>
                                    <div flex="15" class="cellGrid" ng-click="open(item)">{{item.nro_factura}}</div>
                                    <div flex="10" class="cellGrid" ng-click="open(item)"> {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                    <div flex class="cellGrid">{{item.comentario}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN CONTRA PEDIDO ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenContraPedido" id="resumenContraPedido" >

            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderResumenContraPedidoCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span > Contra Pedido </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  layout="row" >
                        <div active-left></div>
                        <div  layout="column" flex  ng-init="tbl.extend = 0 ">
                            <div layout="row" ng-show="tbl.extend == 0" >
                                <md-input-container class="md-block" flex>
                                    <label>Titulo:</label>
                                    <input ng-model="model.titulo" ng-disabled="true" >
                                </md-input-container>
                                <md-input-container class="md-block" flex="20">
                                    <label>Status:</label>
                                    <md-select ng-model="model.aprobada" name ="status" ng-disabled="true">
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
                                        <div>{{model.fecha | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>
                            </div>
                            <div layout="row"   ng-show="tbl.extend == 0">
                                <md-input-container class="md-block" flex="20">
                                    <label>Motivo:</label>
                                    <input ng-model="model.motivo_contrapedido" ng-disabled="true">
                                </md-input-container>

                                <md-input-container class="md-block" flex="20">
                                    <label>Tipo Envio:</label>
                                    <input ng-model="model.tipo_envio" ng-disabled="true"/>
                                </md-input-container>

                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center" >
                                        <div>Fecha Entrega: </div>
                                    </div>
                                    <div  class="md-block" layout="column" layout-align="center center" >
                                        <div>{{model.fecha_aprox_entrega | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex >
                                    <label>Prioridad:</label>
                                    <input ng-model="model.prioridad" ng-disabled="true"/>
                                </md-input-container>
                            </div>
                            <div layout="row"  ng-show="tbl_resumenContraPedido.extend == 0">
                                <md-input-container class="md-block" flex>
                                    <label>Comentario:</label>
                                    <input name="coment" ng-model="model.comentario"  ng-disabled="true" >
                                </md-input-container>

                                <md-input-container class="md-block" flex="20">
                                    <label>Monto:</label>
                                    <input ng-model="model.monto" ng-disabled="true" >
                                </md-input-container>

                                <md-input-container class="md-block" flex="20" >
                                    <label>Moneda</label>
                                    <input ng-model="model.moneda" ng-disabled="true">
                                    </input>
                                </md-input-container>


                            </div>
                        </div>
                    </div>
                    <div  layout="column" flex>
                        <div layout="row">
                            <div active-left></div>
                            <div layout="row" flex>
                                <div class="titulo_formulario" layout="column" layout-align="start start" >
                                    <div>
                                        Productos
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div layout="row" >
                            <div active-left></div>
                            <div layout="row" flex>
                                <div flex="5" ></div>
                                <div layout="row" flex="15">
                                    <md-input-container class="md-block"  flex>
                                        <label>Codigo</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.cod_producto"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="cod_producto"></grid-order-by>
                                </div>
                                <div layout="row" flex="15">
                                    <md-input-container class="md-block"  flex>
                                        <label>Cod. Fabrica</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.codigo_fabrica"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="codigo_fabrica"></grid-order-by>
                                </div>
                                <div layout="row" flex="">
                                    <md-input-container class="md-block"  flex>
                                        <label>Descripción</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.descripcion"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="codigo_fabrica"></grid-order-by>
                                </div>
                                <div layout="row" flex="10">
                                    <md-input-container class="md-block"  flex>
                                        <label>Cantidad</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.saldo"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>
                                </div>
                                <div layout="row" flex="10">
                                    <md-input-container class="md-block"  flex>
                                        <label>Disponible</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.disponible"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="disponible"></grid-order-by>
                                </div>
                                <div layout="row" flex="">
                                    <md-input-container class="md-block"  flex>
                                        <label>Comentario</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.comentario"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="comentario"></grid-order-by>
                                </div>
                                <div layout="row" flex="10">
                                    <md-input-container class="md-block"  flex>
                                        <label>Agregado</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.inDoc"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="inDoc"></grid-order-by>
                                </div>

                            </div>
                        </div>
                        <div layout="row" class="gridContent" flex>
                            <div active-left></div>
                            <div layout="column" flex>
                                <div flex>
                                    <div layout="row" class="cellGridHolder" ng-repeat="item in tbl.data | filter : tbl.filter:strict | orderBy : tbl.order ">
                                        <div flex="5" class="cellEmpty" ng-click="allowEdit(); change(item);">
                                            <md-switch class="md-primary"
                                                       ng-model="item.asignado"

                                                       ng-disabled="true"></md-switch>
                                        </div>
                                        <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                        <div flex="15" class="cellGrid"> {{item.codigo_fabrica}}</div>
                                        <div flex class="cellGrid">  {{item.descripcion}}</div>
                                        <div flex="10"  class="cellGrid" >{{item.cantidad}}</div>
                                        <div flex="10"  class="cellGrid" >{{item.disponible}}</div>
                                        <div flex class="cellGrid">  {{item.comentario}}</div>
                                        <div flex="10"  class="cellGrid" >{{item.inDoc}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </md-content>

        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN KICTCHEN BOX ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenKitchenbox" id="resumenKitchenbox" >
            <!-- ) ########################################## CONTENDOR SECCION RESUMEN DE  KICTCHEN BOX  ########################################## -->

            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderResumenKitchenboxCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span > Kitchen Box </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  layout="row" class="focused">
                        <div active-left> </div>
                        <div  layout="column" flex >
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
                    </div>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span > Adjuntos </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row"  flex>
                        <div active-left> </div>
                        <div layout="column" flex class="gridContent" >
                            <div layout="column" flex>

                            </div>
                        </div>
                    </div>
                </div>
            </md-content>

        </md-sidenav>

        <!-- 14) ########################################## LAYER (5) RESUMEN de Pedido a sustotuir########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; "  class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="resumenPedidoSus" id="resumenPedidoSus" >
            <!-- ) ########################################## CONTENDOR SECCION PEDIDO SUSTITO ########################################## -->

            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderResumenPedidoSusCtrl" >
                <div layout="column" flex >
                    <div name="FormPedidoSusProduc" layout="row"  ng-style="(tbl_pediSutitut.extend == 0 ) ? {'min-height' : '204px'} : {} " ng-class="{'focused' : (tbl_pediSutitut.extend == 0 )}">
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
                    </div>
                    <div layout="row" class=""  ng-class="{'focused' : (tbl_pediSutitut.extend == 1 )}">
                        <div active-left></div>
                        <div layout="row" flex ng-class="{'focused' : (tbl_pediSutitut.extend == 1 )}">
                            <div class="titulo_formulario" layout="column" layout-align="start start" >
                                <div>
                                    Productos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" ng-init="tbl_pediSutitut.order= 'cod_producto' ">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="5" ></div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl.filter.cod_producto"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cod_producto"></grid-order-by>
                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cod. Fabrica</label>
                                    <input  ng-model="tbl.filter.codigo_fabrica"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="codigo_fabrica"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Origen</label>
                                    <input  ng-model="tbl.filter.codigo_fabrica"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="codigo_fabrica"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Descripcion</label>
                                    <input  ng-model="tbl.filter.descripcion"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="descripcion"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Asignado</label>
                                    <input  ng-model="tbl.filter.inDoc"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Disponible</label>
                                    <input  ng-model="tbl.filter.saldo"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <form class="gridContent"  layout="row" flex >
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div layout="row" class="cellGridHolder" ng-repeat="item in pedidoSusPedSelec.productos | filter :tbl_pediSutitut.filter:strict | orderBy :tbl_pediSutitut.order   ">
                                    <div flex="5" class="cellEmpty" ng-click="change(item)">
                                        <md-switch class="md-primary"
                                                   ng-disabled="true" ng-model="item.asignado">
                                        </md-switch>
                                    </div>
                                    <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                    <div flex="15" class="cellGrid">  {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex class="cellGrid">  {{item.saldo}}</div>
                                    <div flex="10" class="cellGrid">{{item.inDoc}}</div>
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
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; "  class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="OrderResumenOldDoc" id="OrderResumenOldDoc" >
            <md-content  layout="row" flex  ng-controller="OrderResumenOldDocCtrl" >
                <div layout="column" flex >
                    <div layout="row" ng-class="{'focused':gridView == 1}"   >
                        <div active-left></div>
                        <div flex layout="row" class="form-row-head" ng-class="{'form-row-head-select':gridView == 1}"  ng-click="gridView = 1">

                            <div class="titulo_formulario" style="height:39px;" flex >
                                <div>
                                    Datos de {{formMode.name}}
                                </div>
                            </div>
                        </div>
                    </div>


                    <div layout="row"  ng-style="(tbl_oldDoc.extend == 0 ) ? {'min-height' : '204px'} : {} " ng-class="{'focused' : (tbl_oldDoc.extend == 0 )}">
                        <div active-left></div>
                        <div  layout="column" flex ng-init="tbl_oldDoc.extend = 0 ">
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex >
                                    <label>Titulo</label>
                                    <input  ng-model="model.titulo" ng-disabled="true">
                                </md-input-container>
                                <div layout="row" class="date-row">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado: </div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <div>{{model.emision | date:'dd/MM/yyyy'}}</div>
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex="20">
                                    <label>Pais</label>
                                    <input ng-model="model.pais" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex>
                                    <label>Almacen</label>
                                    <input ng-model="model.dir_almacen" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="15" >
                                    <label>Puerto</label>
                                    <input ng-model="model.puerto" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>



                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex="" >
                                    <label>Dir. Facturación</label>
                                    <input ng-model="model.dir_facturacion" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>


                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="model.mt3" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso</label>
                                    <input ng-model="model.peso" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                            </div>
                            <div layout="row" class="row" ng-show="tbl_oldDoc.extend == 0 ">
                                <md-input-container class="md-block" flex="10">
                                    <label>Monto</label>
                                    <input ng-model="model.monto" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="15">
                                    <label>Moneda</label>
                                    <input ng-model="model.moneda" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Tasa</label>
                                    <input ng-model="model.tasa" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>
                                <md-input-container class="md-block" flex >
                                    <label>Condicion de pago</label>
                                    <input ng-model="model.condicion_pago" md-no-ink
                                           ng-disabled="true" />

                                </md-input-container>

                            </div>
                        </div>
                    </div>
                    <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':gridView == 2}"  ng-click="gridView = 2">
                        <div active-left></div>
                        <div class="titulo_formulario" style="height:39px;" flex >
                            <div>
                                Productos
                            </div>
                        </div>
                    </div>
                    <div layout="row" ng-init="tbl_oldDoc.order= 'cod_producto' " class="row">
                        <div active-left></div>
                        <div layout="row" flex>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl.filter.cod_producto">
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cod_producto"></grid-order-by>

                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cod. Fabrica</label>
                                    <input  ng-model="tbl.filter.codigo_fabrica">
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="codigo_fabrica"></grid-order-by>

                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Tipo</label>
                                    <input  ng-model="tbl.filter.documento">
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="documento"></grid-order-by>

                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Descripcion</label>
                                    <input  ng-model="tbl.filter.descripcion">
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="descripcion"></grid-order-by>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cantidad</label>
                                    <input  ng-model="tbl.filter.cantidad">
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cantidad"></grid-order-by>

                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Saldo</label>
                                    <input  ng-model="tbl.filter.saldo">
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>

                            </div>
                        </div>
                    </div>
                    <div class="gridContent"  layout="row" flex >
                        <div active-left></div>
                        <div layout="column" flex>
                            <div >
                                <div layout="row" class="cellGridHolder" ng-repeat="item in model.productos.todos | filter :tbl.filter:strict | orderBy :tbl_oldDoc.order ">
                                    <div flex="15" class="cellGrid">  {{item.codigo}}</div>
                                    <div flex="15" class="cellGrid">  {{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid"> {{item.documento}}</div>
                                    <div flex class="cellGrid">  {{item.descripcion}}</div>
                                    <div flex="10" class="cellGrid">{{item.cantidad}}</div>
                                    <div flex="10" class="cellGrid">{{item.saldo}}</div>
                                </div>
                            </div>
                        </div>

                    </div>
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
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderfinalDocCtrl">
                <div flex="35"layout="column" id="headFinalDoc"   style="margin-right: 4px;" class="focused">
                    <div layout="row"  class="form-style" ng-class="{'form-row-head-select' : gridViewFinalDoc == 1 }">
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select' : gridViewFinalDoc == 1 }" ng-click="gridViewFinalDoc = 1;">
                                <div class="titulo_formulario" style="height:39px;{{( gridViewFinalDoc != 1) ? 'color:#ccc' : ''}}" flex >
                                    <div>
                                        Datos de {{formMode.name}}
                                    </div>
                                </div>
                                <div  layout="row"  layout-align="end start" ng-show="finalDoc.document.estado == 'upd'">
                                    <md-switch class="md-primary"
                                               ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"

                                    >
                                    </md-switch>
                                </div>

                            </div>
                            <div layout="column" flex class="gridContent">
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
                                        <div>{{document.nro_proforma.doc}}</div>
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
                                        <div>{{document.nro_factura.doc}}</div>
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
                        </div>
                    </div>
                    <div  layout="row"  class="form-style" ng-class="{'form-row-head-select' : gridViewFinalDoc == 2 } "  ng-show="document.fecha_aprob_compra">
                        <div active-left> </div>
                        <div layout="column" flex >
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select' : gridViewFinalDoc == 2 }" ng-click="gridViewFinalDoc = 2" >
                                <div class="titulo_formulario" style="height:39px;{{( gridViewFinalDoc != 2) ? 'color:#ccc' : ''}} " flex >
                                    <div>
                                        Aprobacion compras
                                    </div>
                                </div>
                                <div layout=""  layout-align="center center"  >
                                    <div  layout="row"  layout-align="end start" ng-show="finalDoc.fecha_aprob_compra">
                                        <md-switch class="md-primary"
                                                   ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"
                                                   ng-show="switchBack.head.change"
                                        >
                                        </md-switch>
                                    </div>
                                </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="gridViewFinalDoc == 2">
                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'created' && finalDoc.estado_id.trace-length > 0"  layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Fecha </div>
                                </div>
                                <div class="rms" flex> {{document.estado }}</div>
                            </div>
                        </div>
                    </div>
                    <div  layout="row"  class="form-style" ng-class="{'form-row-head-select' : gridViewFinalDoc == 3 }" ng-show="document.fecha_aprob_gerencia">
                        <div active-left> </div>
                        <div layout="column" flex >
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select' : gridViewFinalDoc == 3 }" ng-click="gridViewFinalDoc = 3" >
                                <div class="titulo_formulario" style="height:39px;{{( gridViewFinalDoc != 3) ? 'color:#ccc' : ''}} " flex >
                                    <div>
                                        Aprobacion Gerencia
                                    </div>
                                </div>
                                <div layout=""  layout-align="center center"  >
                                    <div  layout="row"  layout-align="end start">
                                        <md-switch class="md-primary"
                                                   ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"
                                                   ng-show="switchBack.head.change"
                                        >
                                        </md-switch>
                                    </div>
                                </div>
                            </div>
                            <div layout="row"  class="rowRsm" ng-show="gridViewFinalDoc == 3">
                                <div layout="row" flex="40">
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'created' && finalDoc.estado_id.trace-length > 0"  layout-align="center center" >
                                        <span class="icon-Agregar" ></span>
                                    </div>
                                    <div layout="column" class="divIconRsm" ng-show="finalDoc.estado_id.estado == 'upd'" layout-align="center center">
                                        <span class="icon-Actualizar" ></span>
                                    </div>
                                    <div class="rowRsmTitle"> Fecha </div>
                                </div>
                                <div class="rms" flex> {{document.estado }}</div>
                            </div>
                        </div>
                    </div>
                    <div   class="form-style" ng-class="{'form-row-head-select' : gridViewFinalDoc == 4 }" layout="row" ng-show="document.contraPedido && document.contraPedido.length > 0">
                        <div active-left> </div>
                        <div layout="column" flex >
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select' : gridViewFinalDoc == 4 }" ng-click="gridViewFinalDoc = 4" >
                                <div class="titulo_formulario" style="height:39px;{{( gridViewFinalDoc != 4) ? 'color:#ccc' : ''}} " flex >
                                    <div>
                                        ContraPedido
                                    </div>
                                </div>
                                <div layout=""  layout-align="center center"  >
                                    <div  layout="row"  layout-align="end start">
                                        <md-switch class="md-primary"
                                                   ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"
                                                   ng-show="switchBack.head.change"
                                        >
                                        </md-switch>
                                    </div>
                                </div>
                            </div>
                            <div flex ng-show="gridViewFinalDoc == 2" >
                                <md-content style="margin: 4px;">
                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in document.contraPedido  track by $index " layout-align="space-between center" >
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

                    </div>
                    <div    class="form-style" ng-class="{'form-row-head-select' : gridViewFinalDoc == 5 }" layout="row"  ng-show="document.kitchenBox && document.kitchenBox.length > 0"  >
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select' : gridViewFinalDoc == 5 }" ng-click="gridViewFinalDoc = 5" >
                                <div class="titulo_formulario" style="height:39px;{{( gridViewFinalDoc != 5) ? 'color:#ccc' : ''}} " flex >
                                    <div>
                                        KitchenBox
                                    </div>
                                </div>
                                <div layout=""  layout-align="center center"  >
                                    <div  layout="row"  layout-align="end start">
                                        <md-switch class="md-primary"
                                                   ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"
                                                   ng-show="switchBack.head.change"
                                        >
                                        </md-switch>
                                    </div>
                                </div>
                            </div>

                            <div flex ng-show="gridViewFinalDoc == 5">
                                <md-content style="margin: 4px;">
                                    <div layout="row" class="cellGridHolder"  ng-repeat=" item in finalDoc.kitchenBox  track by $index " layout-align="space-between center" >
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
                    </div>
                    <div   class="form-style" ng-class="{'form-row-head-select' : gridViewFinalDoc == 6 }" layout="row"  ng-show="document.pedidoSusti && document.pedidoSusti.length > 0"  >
                        <div active-left> </div>
                        <div layout="column" flex>
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select' : gridViewFinalDoc == 6 }" ng-click="gridViewFinalDoc = 6" >
                                <div class="titulo_formulario" style="height:39px;{{( gridViewFinalDoc != 6) ? 'color:#ccc' : ''}} " flex >
                                    <div>
                                        {{formMode.name}} sustituidos
                                    </div>
                                </div>
                                <div layout=""  layout-align="center center"  >
                                    <div  layout="row"  layout-align="end start">
                                        <md-switch class="md-primary"
                                                   ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"
                                                   ng-show="switchBack.head.change"
                                        >
                                        </md-switch>
                                    </div>
                                </div>
                            </div>

                            <div flex ng-show="gridViewFinalDoc == 6">
                                <md-content style="margin: 4px;">

                                    <div layout="row" class="cellGridHolder "  ng-repeat=" item in finalDoc.pedidoSusti  track by $index " layout-align="space-between center" >
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
                    </div>
                </div>
                <div flex layout="column">
                    <div layout="row" class="focused" >
                        <div layout="row" flex class="form-row-head form-row-head-select "  >
                            <div class="titulo_formulario" style="height:39px;" flex >
                                <div>
                                    Productos
                                </div>
                            </div>
                            <div layout=""  layout-align="center center"  >
                                <div  layout="row"  layout-align="end start">
                                    <md-switch class="md-primary"
                                               ng-model="switchBack.head.model" ng-change ="(switchBack.head.model)? 0:toSideNave(switchBack.head,'¿Desea revisar los cambio realizados en la {{formMode.name}} ? ',['#detalleDoc div.activeleft '])"
                                               ng-show="switchBack.head.change"
                                    >
                                    </md-switch>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row" layout="row" ng-init="tbl_finalDoc.order = 'codigo'">
                        <div layout="row" flex>
                            <div flex="20" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Codigo</label>
                                    <input  ng-model="tbl.filter.codigo"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_finalDoc" key="codigo"></grid-order-by>
                            </div>
                            <div flex="20" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cod. Fabrica</label>
                                    <input  ng-model="tbl.filter.codigo_fabrica"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_finalDoc" key="codigo_fabrica"></grid-order-by>
                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Descripion</label>
                                    <input  ng-model="tbl.filter.descripcion"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_finalDoc" key="descripcion"></grid-order-by>
                            </div>
                            <div flex="15" layout="row">
                                <md-input-container class="md-block" flex >
                                    <label>Cantidad</label>
                                    <input  ng-model="tbl.filter.saldo"
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl_finalDoc" key="saldo"></grid-order-by>
                            </div>

                           <!-- <div  style="width: 80px;" ng-show="formMode.value == 23" ></div>-->

                        </div>
                    </div>
                    <div layout="row"  class="gridContent">
                        <div  layout="column" flex>
                            <div flex >
                                <div  ng-repeat="item in finalDoc.productos | filter:tbl_finalDoc.filter:strict |orderBy : tbl_finalDoc  "  >
                                    <div layout="row" class="cellGridHolder" >
                                        <div flex="20" class="cellSelect" ng-class="{'cellSelect':( finalProdSelec.id  != item.id) ,'cellSelect-select':(finalProdSelec.id  == item.id )}" >
                                            {{item.codigo}}
                                        </div>
                                        <div flex="20" class="cellGrid" > {{item.codigo_fabrica}}</div>
                                        <div flex class="cellGrid" > {{item.descripcion}}</div>
                                        <div flex="15" class="cellGrid">{{item.saldo | number:2}}</div>
                                  <!--      <div style="width: 80px;"  class="cellEmpty " ng-show="formMode.value == 23"
                                             layout-align="center center" layout="column" ng-click="excepProdFinal(item)">
                                            <div class="dot-empty dot-attachment "  layout-align="center center" >
                                                <div style=" margin-top: 2.5px;">   {{item.condicion_pago.length}}</div>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div   id="expand"></div>
                <div style="width: 16px;"  ng-mouseenter="(canNext()) ? $parent.showNext(true) :0 ;$parent.nextLayer = next " > </div>
                <loader ng-show="inProcess"></loader>

            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER LISTA DE DOCUMENTOS SIN FINALIZAR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="unclosetDoc" id="unclosetDoc">

            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderUnclosetDocCtrl" >

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
                    <div layout="row" class="table-filter">
                        <div active-left  before="verificExit"></div>
                        <div layout="row" class="row" flex ng-init="docOrder.order == id " tyle="padding-right: 4px;">
                            <div layout="row" style="width: 120px;" >
                                <md-select ng-model="tbl.filter.documento" ng-init="tbl.filter.documento ='-1'" flex style="">
                                    <md-option value="-1" layout="row" style="overflow: hidden;">
                                        <img ng-src="images/Documentos.png" style="width:20px;"/> Todos
                                    </md-option>
                                    <md-option value="21" layout="row" >
                                        <img ng-src="images/solicitud_icon_48x48.gif" style="width:20px;">Solicitud
                                    </md-option>
                                    <md-option value="22" layout="row">
                                        <img ng-src="images/proforma_icon_48x48.gif" style="width:20px;">Proforma

                                    </md-option>
                                    <md-option value="23" layout="row">
                                        <img ng-src="images/odc_icon_48x48.gif" style="width:20px;">ODC
                                    </md-option>
                                </md-select>
                                <grid-order-by ng-model="tbl" key="documento"></grid-order-by>
                            </div>
                            <div flex="5" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Nro.</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.proveedor"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="proveedor"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Creado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>


                        </div>
                    </div>

                    <form layout="row"  flex class="gridContent">
                        <div active-left  before="verificExit" ></div>
                        <div layout="column" flex>
                            <div  flex >
                                <div   ng-repeat="item in filterDocuments(tbl.data ,tbl.filter) | orderBy : tbl.order "  >
                                    <div layout="row" class="cellGridHolder" ng-click="open(item)">
                                        <div style="width: 120px;" class="cellEmpty cellSelect"  ng-mouseover="hoverPreview(true)" tabindex="{{$index + 1}}">
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
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderPriorityDocsCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span > Documentos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" class="table-filter">
                        <div active-left  ng-show="(!preview && layer != 'listPedido')" before="verificExit"></div>
                        <div layout="row" class="row" flex ng-init="docOrder.order == id " tyle="padding-right: 4px;">
                            <div active-left  before="verificExit" ></div>
                            <div layout="row" style="width: 120px;" >
                                <md-select ng-model="tbl.filter.documento" ng-init="tbl.filter.documento ='-1'" flex style="">
                                    <md-option value="-1" layout="row" style="overflow: hidden;">
                                        <img ng-src="images/Documentos.png" style="width:20px;"/> Todos
                                    </md-option>
                                    <md-option value="21" layout="row" >
                                        <img ng-src="images/solicitud_icon_48x48.gif" style="width:20px;">Solicitud
                                    </md-option>
                                    <md-option value="22" layout="row">
                                        <img ng-src="images/proforma_icon_48x48.gif" style="width:20px;">Proforma

                                    </md-option>
                                    <md-option value="23" layout="row">
                                        <img ng-src="images/odc_icon_48x48.gif" style="width:20px;">ODC
                                    </md-option>
                                </md-select>
                                <grid-order-by ng-model="tbl" key="documento"></grid-order-by>
                            </div>
                            <div flex="5" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Nro.</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.proveedor"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="proveedor"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Creado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div style="width: 80px;"></div>

                        </div>
                    </div>
                    <div layout="row" class="gridContent">
                        <div active-left  before="verificExit" ></div>
                        <div layout="column" flex>
                            <div flex>
                                <div ng-repeat="item in filterDocuments(tbl.data, tbl.filter) | orderBy : tbl.order "  row-select>
                                    <div layout="row" class="cellGridHolder" >

                                        <div style="width: 120px;" ng-click="openTempDoc(item)" class="cellEmpty cellSelect" tabindex="{{$index + 1}}">
                                            <div>
                                                <div layout-align="center center"  style="text-align: center;     margin-left: 12px;">
                                                    <img style="width: 20px;" ng-src="{{transforDocToImg(item.documento)}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div flex="5" class="cellSelect" ng-click="openTempDoc(item)"
                                             ng-class="{'cellGrid':( addAnswer.doc_id  != item.id) ,'cellSelect-select':(addAnswer.doc_id  == item.id )}"
                                             tabindex="{{$index + 1}}"
                                        > {{item.id}}
                                        </div>
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
                    </div>
                </div>
                <div id="expand"></div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER LISTA DE DOCUMENTOS con versiones antigual del documento ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="OrderOldDocs" id="OrderOldDocs">
            <!-- 11) ########################################## CONTENDOR LISTA DE PEDIDOS ########################################## -->
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderOldDocsCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span > Historico</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left  before="verificExit" ></div>
                        <div layout="row" flex>

                            <div style="width: 48px;"></div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Version</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.version"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="version"></grid-order-by>
                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.proveedor"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="proveedor"></grid-order-by>
                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>
                            </div>
                            <div flex="10" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Fecha</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.emision"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>
                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div flex="" layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.comentario"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="comentario"></grid-order-by>
                            </div>
                        </div>

                    </div>
                    <div layout="row" class="gridContent">
                        <div active-left  before="verificExit" ></div>
                        <div layout="column" flex>
                            <div flex>
                                <div ng-repeat="item in filterDocuments(tbl.data, tbl.filter) | orderBy : tbl.order "  row-select>
                                    <div layout="row" class="cellGridHolder" >

                                        <div style="width: 48px;" class="cellEmpty cellSelect"  tabindex="{{$index + 1}}" ng-click="open(item);">
                                            <div layout-align="center center"  style="text-align: center; width: 100%; ">
                                                <img style="width: 20px;" ng-src="images/lupa.png" />
                                            </div>
                                        </div>
                                        <div flex="10" class="cellGrid"  ng-click="restore(item);"  > {{item.version}}</div>
                                        <div flex class="cellGrid"  ng-click="restore(item);" > {{item.proveedor}}</div>
                                        <div flex class="cellGrid"  ng-click="restore(item);" > {{item.titulo}}</div>
                                        <div flex="10" class="cellGrid"  ng-click="restore(item);" > {{item.emision| date:'dd/MM/yyyy' }}</div>
                                        <div flex class="cellGrid"  ng-click="restore(item);" > {{item.monto | currency :(item.symbol)?item.symbol:'' :2}}</div>
                                        <div flex class="cellGrid"  ng-click="restore(item);"  >{{item.comentario}}</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="expand"></div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER LISTA DE PREVIEW HYML ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; " class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="previewEmail" id="previewEmail">
            <md-content  layout="row" flex class="sideNavContent" ng-controller="OrderMailPreview" >
                <div layout="column" flex>
                    <form layout="row"  class="focused" >
                        <div active-left  before="exitValidate"  ></div>
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
                                <md-input-container class="md-block" flex="" ng-click="allowEdit()" alert="{'none':'No se le ha asignado condiciones de pago a '+provSelec.razon_social} " alert-show="(formData.condicionPago.length > 0) ? '': 'none'">
                                    <label>Lenguaje</label>
                                    <md-autocomplete md-selected-item = "idioma"
                                                     info="Selecione el idioma para el correo"
                                                     md-input-name = "autocomplete"
                                                     md-search-text = "idiomaText"
                                                     md-items = "item in idiomas | stringKey : idiomaText : 'lang' "
                                                     md-item-text="item.lang"
                                                     md-min-length="0"
                                                     md-input-minlength="0"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                    >
                                        <md-item-template>
                                            <span>{{item.lang}}</span>
                                        </md-item-template>
                                        <md-not-found  ng-click="redirect({module:'proveedores'})">
                                            No se encontro la condicion de pago {{ctrl.searchcondPagoSelec}}. ¿Desea crearla?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>

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
                                          skitp-tab

                                >
                                    <md-autocomplete
                                        md-search-text="searchTo"
                                        md-items="item in correos | filter : searchTo  | customFind : destinos : isAddMail "
                                        md-item-text="item.valor"
                                        placeholder="Para:">
                                        <span >{{item.nombre}}/{{item.valor}} </span>
                                    </md-autocomplete>
                                    <md-chip-template>
                                        <strong>{{$chip.nombre}}/{{$chip.valor}} </strong>
                                    </md-chip-template>
                                </md-chips>
                                <!--     <md-chips ng-model="cc"
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
                                     </md-chips>-->
                                <div layout="row" class="row-min" style="padding-right: 4px;" ng-show="showHead" >
                                    <md-input-container flex>
                                        <label>Asunto:</label>
                                        <input  ng-model="asunto" required >
                                    </md-input-container>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div flex layout="row" >

                        <div flex style="overflow: auto; padding: 8px;">
                            <div id="templateContent" ng-bind-html="template" flex="">
                            </div>
                        </div>
                    </div>
                </div>
                <loader ng-show="inProgress"></loader>
                <div  style="width: 16px;" ng-mouseover="showNext(true)"  > </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer aprobar documento ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderAprob" id="OrderAprob"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderAprobCtrl" style="padding-left: 12px"  click-out="close($event)" >
                <div layout="column" flex>
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario">
                            <div>
                                Aprobacion
                            </div>
                        </div>
                    </div>
                    <form name="formData">
                        <div layout="row" class="date-row vlc-date row"  ng-class="{'vlc-date-no-edit':$parent.Docsession.block}"
                        >
                            <div layout="column" class="md-block" layout-align="center center" ng-click="($parent.shipment.fechas.fecha_carga.confirm) ? desblockFecha_carga() : 0" >
                                <div>Fecha Aprobación</div>
                            </div>
                            <md-datepicker ng-model="model.fecha"
                                           ng-disabled="($parent.Docsession.block)"
                                           skip-tab
                                           required
                                           ng-change="toEditHead('fecha_aprob_compra', ($parent.document.fecha_aprob_compra) ? $parent.document.fecha_aprob_compra.toString(): undefined)"
                            ></md-datepicker >
                        </div>
                        <md-input-container class="md-block row" >
                            <label>N° Documento</label>
                            <input ng-model="model.nro_doc"  ng-disabled="(Docsession.block)"
                                   ng-change="toEditHead('nro_doc', $parent.document.nro_doc)"
                                   required
                                   skip-tab
                            >
                        </md-input-container>

                        <vld-file-up-img up-model="upModel" fn-file-up="fnfile" key="OrderAprobCtrl" up-adjs="loades" storage="orders"></vld-file-up-img>
                    </form>
                </div>

            </md-content>
        </md-sidenav>
        <!------------------------------------------- mini nro_proforma------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderNrProforma" id="OrderNrProforma"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderNrProformaCtrl" style="padding-left: 12px"  click-out="close($event)" >
                <div layout="column" flex>
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario">
                            <div>
                                Proforma
                            </div>
                        </div>
                    </div>
                    <vld-file-up-img up-model="upModel"  fn-file-up="fnfile" fn-up-watch="uploTe" key="OrderNrProformaCtrl" storage="orders" loaded="adjs" no-up="(Docsession.block)" ></vld-file-up-img>

                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini nro_factura------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderNrFactura" id="OrderNrFactura"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderNrFacturaCtrl" style="padding-left: 12px"  click-out="close($event)" >
                <div layout="column" flex>
                    <div layout="row" class="form-row-head form-row-head-select" >
                        <div class="titulo_formulario">
                            <div>
                                Factura
                            </div>
                        </div>
                    </div>
                    <vld-file-up-img up-model="upModel" fn-file-up="fnfile" fn-up-watch="uploTe" key="OrderNrFactura" storage="orders" loaded="adjs" no-up="(Docsession.block)" ></vld-file-up-img>

                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer cancelacion documento ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderCancel" id="OrderCancel"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderCancelDocCtrl" style="padding-left: 12px"  click-out="close($event)" >
                <div layout="column" flex>
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario " flex>
                            <div>
                                Cancelacion
                            </div>
                        </div>
                        <div layout="row" layout-align="center end" class="form-row-head-option">
                            <div flex layout="column" layout-align="center center" ng-click="mode = (mode == 'adj') ? 'list': 'adj' ">
                                <img ng-src="{{(mode == 'list') ? 'images/adjunto.png' : 'images/listado.png'}}">

                                <md-tooltip >
                                    {{(mode == 'adj')  ? 'Redactar' : 'Adjuntar' }}
                                </md-tooltip>
                            </div>
                        </div>
                    </div>
                    <form name="formData" ng-show="mode != 'adj' " flex>
                       <textarea ng-model="model.comentario"
                                 info="Por favor estable el motivo de cancelacion"
                                 required
                                 skip-tab
                                 placeholder="Por favor estable el motivo de cancelacion"
                                 flex
                       ></textarea

                           <!--  -->
                    </form>
                    <vld-file-up-img ng-show="mode == 'adj' " up-model="upModel" fn-file-up="fnfile" key="OrderCancelDocCtrl" up-adjs="loades" storage="orders"></vld-file-up-img>
                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer agregar  producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderminiAddProduct" id="OrderminiAddProduct"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderminiAddProductCtrl" style="padding-left: 12px"  click-out="close($event)" >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario">
                            <div>
                                Agregar producto
                            </div>
                        </div>
                    </div>
                    <form name="prod" flex class="gridContent focused" layout="column" style="padding-right:4px">

                        <div layout="row" class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Asignado </div>
                            </div>

                            <md-input-container class="md-block rms" flex >
                                <input  skip-tab required id="input" type="text" ng-model="select.saldo" range minVal="0.1" maxVal="{{select.cantidad}}"   >
                            </md-input-container>

                            <md-tooltip >Cantidad a agregar</md-tooltip>
                        </div>

                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Costo unitario </div>
                            </div>
                            <md-input-container class="md-block rms" flex >
                                <input skip-tab ng-required="$parent.document.nro_proforma" id="input" type="text" ng-model="select.costo_unitario" decimal   >
                            </md-input-container>

                            <md-tooltip >Monto a pagar por unidad</md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Maximo</div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;"> {{(select.disponible) ? select.disponible :'N/A'}}</div>

                            <md-tooltip >
                                Disponible para asignacion
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Cod. Fabrica</div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;"> {{(select.codigo_fabrica) ? select.codigo_fabrica :'No existe'}} </div>

                            <md-tooltip >
                                Codigo en fabrica
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Codigo</div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;"> {{(select.codigo) ? select.codigo :'No existe'}} </div>

                            <md-tooltip >
                                Codigo
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Cod. Barra </div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;">{{(select.codigo_barra) ? select.codigo_barra : 'No existe'}} </div>
                            <md-tooltip >
                                Codigo de barra
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Descripcion </div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;">{{select.descripcion}} </div>
                            <md-tooltip >
                                Descripcion del producto
                            </md-tooltip>
                        </div>

                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer cambiar item  ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderminiChangeItem" id="OrderminiChangeItem"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderminiChangeItemCtrl" style="padding-left: 12px"  click-out="close($event)" >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario">
                            <div>
                               Cambiar {{(select.documento) ? select.documento : 'articulo'}}
                            </div>
                        </div>
                    </div>
                    <form name="form" flex class="gridContent focused" layout="column" style="padding-right:4px">

                        <div layout="row" class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Asignado </div>
                            </div>

                            <md-input-container class="md-block rms" flex  ng-dblclick="forceAsign()" >
                                <input  skip-tab required id="input" type="text" ng-model="select.saldo" range minVal="0.1" maxVal="{{select.cantidad}}"
                                        ng-readonly="noEdit" ng-disabled="noEditAsign"  >
                            </md-input-container>

                            <md-tooltip >Cantidad a agregar</md-tooltip>
                        </div>

                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Costo unitario </div>
                            </div>
                            <md-input-container class="md-block rms" flex ng-dblclick="forceCosto()" >
                                <input skip-tab ng-required="$parent.document.nro_proforma" id="input" type="text"
                                       ng-model="select.costo_unitario" decimal  ng-readonly="noEdit"

                                >
                            </md-input-container>

                            <md-tooltip >Monto a pagar por unidad</md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Maximo</div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;"> {{(select.disponible) ? select.disponible :'N/A'}}</div>

                            <md-tooltip >
                                Disponible para asignacion
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Cod. Fabrica</div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;"> {{(select.codigo_fabrica) ? select.codigo_fabrica :'No existe'}} </div>

                            <md-tooltip >
                                Codigo en fabrica
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Codigo</div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;"> {{(select.codigo) ? select.codigo :'No existe'}} </div>

                            <md-tooltip >
                                Codigo
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Cod. Barra </div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;">{{(select.codigo_barra) ? select.codigo_barra : 'No existe'}} </div>
                            <md-tooltip >
                                Codigo de barra
                            </md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Descripcion </div>
                            </div>
                            <div layout="column" layout-align="center start" flex style="padding-left: 2px;">{{select.descripcion}} </div>
                            <md-tooltip >
                                Descripcion del producto
                            </md-tooltip>
                        </div>

                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer agregar  kitchen box ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="OrderminiAddKitchenBox" id="OrderminiAddKitchenBox"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="OrderminiAddKitchenBoxCtrl" style="padding-left: 12px"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario">
                            <div>
                                Agregar KitchenBox
                            </div>
                        </div>
                    </div>
                    <form name="prod" flex class="gridContent focused" layout="column" style="padding-right:4px">

                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Monto a pagar </div>
                            </div>
                            <md-input-container class="md-block rms" flex >
                                <input skip-tab required id="input" type="text" ng-model="select.costo_unitario" decimal   >
                            </md-input-container>

                            <md-tooltip >Monto a pagar por unidad</md-tooltip>
                        </div>
                        <div layout="row"  class="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Descripcion</div>
                            </div>
                        </div>
                        <div layout="row"  class="row gridContent" >

                             <textarea ng-model="select.descripcion"
                                       info="Descripcion del kitchem box"
                                       required
                                       skip-tab
                                       placeholder="DEscripcion del kitchenBox"
                                       flex
                             ></textarea>
                        </div>

                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER Mensaje de notificacion########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(30%); z-index: 60 ;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="moduleMsm" id="moduleMsm"


        >

            <md-content   layout="row" flex class="sideNavContent" ng-controller="OrderModuleMsmCtrl" >
                <div  layout="column" flex="" class="layerColumn"  click-out="close($event)" >
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
                                <div layout="row" class="cellGridHolder" ng-click="openNoti(item)" >
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
                    md-disable-backdrop="true" md-component-id="OrderAddAnswer" id="OrderAddAnswer"
        >
            <md-content   layout="row" flex class="sideNavContent" class="cntLayerHolder" ng-controller="OrderAddAnswer" >
                <div  layout="column" flex="" class="layerColumn"   click-out="close($event)" style="padding-left: 12px" >

                    <div layout="row" class="form-row-head form-row-head-select" >
                        <div class="titulo_formulario" flex>
                            <div>
                                Respuestas del proveedor
                            </div>
                        </div>

                        <div layout="row" layout-align="center end" class="form-row-head-option">
                            <!--<div flex layout="column" layout-align="center center" ng-click="mode = 'add'">
                                <span class="icon-Agregar" style="font-size: 12px"></span>

                                <md-tooltip >
                                   Agregar
                                </md-tooltip>
                            </div>-->
                            <div flex layout="column" layout-align="center center" ng-click="mode = (mode == 'add') ? 'list': 'add' " style="color: #ccc;">
                                <img ng-src="images/listado.png" ng-show=" mode == 'add'">
                                <span class="icon-Agregar" style="font-size: 12px" ng-show=" mode == 'list'"></span>
                                <md-tooltip >
                                    {{(mode == 'adj')  ? 'Redactar' : 'Agregar' }}
                                </md-tooltip>
                            </div>
                        </div>
                    </div>
                    <div flex layout="column" class="gridContent" ng-show="mode == 'add'" >
                        <vld-file-up-img up-model="upModel" fn-file-up="fnfile" key="OrderAddAnswer" storage="orders"></vld-file-up-img>
                        <form flex="50"  layout="column " name="form" >
                                <textarea ng-model="model.descripcion"
                                          info="Por favor ingrese un texto que describa la conclusion que se llego con el proveedor "
                                          placeholder="Por favor ingrese un texto que describa la conclusion que se llego con el proveedor "
                                          required
                                          id="textarea"
                                          skip-tab
                                          style="width: inherit;"
                                ></textarea>


                        </form>

                    </div>
                    <div flex class="gridContent form-style" ng-show="mode == 'list'" >
                        <div ng-repeat="item in tbl.data" >
                            <div layout="row" class="cellGridHolder" >
                                <div flex class="cellGrid" >{{item.descripcion}} </div>
                            </div>
                        </div>
                        <div flex layout="column" layout-align="center center" ng-show="tbl.data.length == 0  " style="height: 100%;">
                            No hay datos para mostrar
                        </div>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER send correo ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="OrderSendEmail" id="OrderSendEmail"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="OrderSendMail"    >
                <vld-mail-with-adj
                    load="origenes" text="centerText" template="template" funciones = "mailFn"
                    correos="correos" no-new="noNew" to="model.to" cc="model.cc" ccb="model.ccb" langs="langs"  lang="lang" asunto="model.subject" up-model="adjsUp"
                    key="OrderSendEmail" storage="orders" fn-file-up="upfileFinis" fn-up-watch="upFiles" titulo="Correo"
                ></vld-mail-with-adj>
                <loader ng-show="inProgress"></loader>
                <div style="width: 16px;"  ng-mouseenter="(canNext()) ? $parent.showNext(true) :0 ; $parent.nextLayer = next" > </div>

            </md-content>
        </md-sidenav>


        <!-- ########################################## LAYER crear nuevo producto ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px;"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="OrderCreateProd" id="OrderCreateProd"
        >
            <md-content   layout="row" flex  ng-controller="OrderCreateProdCtrl" style="padding-left: 12px"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row" class="form-row-head form-row-head-select" >
                        <div class="titulo_formulario">
                            <div>
                                Crear producto
                            </div>
                        </div>
                    </div>
                    <form name="form" class="focused">
                        <div flex class="gridContent" layout="column" style="padding-right:4px">

                            <md-input-container class="md-block" >
                                <label>Cod. Fabrica</label>
                                <input  type="text" ng-model="model.codigo_fabrica" required skip-tab info="Codigo de fabrica del producto" >

                            </md-input-container>
                            <md-input-container class="md-block" >
                                <label>Descripcion Fabrica</label>
                                <input  type="text" ng-model="model.descripcion" required skip-tab info="Descripcion fabrica del producto" >
                            </md-input-container>
                            <md-input-container class="md-block" >
                                <label>Cod. Profit</label>
                                <input  type="text" ng-model="model.codigo_profit"  skip-tab info="Codigo en profit"  >

                            </md-input-container>
                            <md-input-container class="md-block" >
                                <label>Descripcion Profit</label>
                                <input  type="text" ng-model="model.descripcion_profit"  skip-tab info="Descripcion de porfit del producto" >
                            </md-input-container>

                            <md-input-container class="md-block"   >
                                <label>Linea</label>
                                <md-autocomplete md-selected-item="lineaSelec"
                                                 info="Linea del producto "
                                                 required
                                                 skip-tab
                                                 md-search-text="lineaText"
                                                 md-auto-select="true"
                                                 md-items="item in lineas | stringKey : lineaText : 'linea' "
                                                 md-item-text="item.linea"
                                                 md-autoselect = "true"
                                                 md-no-asterisk
                                                 md-min-length="0"
                                                 md-require-match="true"
                                                 md-no-cache="true"
                                                 md-select-on-match
                                                 md-selected-item-change="model.linea_id = lineaSelec.id;"
                                >
                                    <md-item-template>
                                        <span>{{item.linea}}</span>
                                    </md-item-template>
                                </md-autocomplete>
                            </md-input-container>
                            <md-input-container class="md-block"   >
                                <label>Sub-Linea</label>
                                <md-autocomplete md-selected-item="SublineaSelec"
                                                 info="Sub linea  del producto "

                                                 skip-tab
                                                 md-search-text="SublineaText"
                                                 md-items="item in subLineas | stringKey : lineaText : 'linea'  "
                                                 md-item-text="item.sublinea"
                                                 md-min-length="0"
                                                 md-no-cache="true"
                                                 md-select-on-match
                                                 md-selected-item-change="model.sublinea_id = SublineaSelec.id;"
                                                 ng-disabled="!lineaSelec"
                                >
                                    <md-item-template>
                                        <span>{{item.sublinea}}</span>
                                    </md-item-template>
                                </md-autocomplete>
                            </md-input-container>

                            <div layout="column" flex>
                                <md-input-container class="md-block"   >
                                    <label>Almacen</label>
                                    <md-autocomplete md-selected-item="almacnSelect"
                                                     info="Almacen de llegada del producto "
                                                     skip-tab
                                                     md-search-text="almacnText"
                                                     md-items="item in almacn | stringKey : almacnText : 'nombre' | customFind : almacnAdd : isAddAlmacen "
                                                     md-item-text="item.nombre"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                                     md-selected-item-change="model.almacen_id = almacnSelect.id;addAlmacen(almacnSelect)"
                                    >
                                        <md-item-template>
                                            <span>{{item.nombre}}</span>
                                        </md-item-template>
                                    </md-autocomplete>
                                </md-input-container>
                                <div flex class="gridContent" skip-tab>
                                    <div ng-repeat="item in model.almcenes"   >
                                        <div layout="row" class="cellGridHolder"  >
                                            <div style="width: 24px;padding-top: 15px;border: none;" ng-click="removeAlmacen(item, $index)" omit-out>
                                                <div  layout="column" layout-align="center center"   omit-out >
                                                    <span class="icon-Eliminar" style="font-size: 12px"omit-out ></span>
                                                </div>
                                            </div>
                                            <div flex class="cellGrid" >{{item.nombre}} </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

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
        >
            <div  style="width: 100%;" ng-mouseleave="showNext()"  layout="column" layout-align="center center" flex ng-click="next(nextLayer)">
                <?= HTML::image("images/btn_nextArrow.png") ?></div>

        </md-sidenav>

        <!------------------------------------------- Alertas ------------------------------------------------>
        <div ng-controller="notificaciones" ng-include="template"></div>
        <!------------------------------------------- files ------------------------------------------------>

        <div ng-controller="FilesController" ng-include="template"></div>

    </div>
</div>

