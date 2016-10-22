<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="embarquesController" global >
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

                <div layout="column" flex=""   style="padding: 0px 4px 0px 4px;" tabindex="-1">
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

            <div id="listado" flex  style="overflow-y:auto;word-break: break-all;"  >
                <div class="boxList"  layout="column" flex ng-repeat="item in search()  "  list-box ng-click="setProvedor(item, this)"
                     ng-class="{'listSel' : (item.id == provSelec.id)}"
                     id="prov{{item.id}}"
                     class="boxList"
                >

                    <div  style="overflow: hidden; text-overflow: ellipsis;word-break: break-all;" flex>{{item.razon_social}}</div>
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
                <!-- botonera left -->
                <div style="width: 240px;" layout="row">
                    <div layout="column" layout-align="center center"></div>

                    <div layout="column" ng-show="((module.index < 1 || module.layer == 'listShipment') && permit.created)" layout-align="center center" ng-click="OpenShipmentCtrl()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Nuevo Embarque
                        </md-tooltip>
                    </div>
                    <div layout="column" ng-show="(module.layer == 'listOrdershipment')" layout-align="center center" ng-click="listOrderAdd()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Nuevo Pedido
                        </md-tooltip>
                    </div>
                    <div layout="column" ng-show="(module.layer == 'listTariff')" layout-align="center center" ng-click="CreatTariff()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Nueva tarifa
                        </md-tooltip>
                    </div>

                    <div layout="column" layout-align="center center"
                         ng-show="(module.index > 1 && Docsession.block && document.permit.update )" ng-click="updateForm()">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Actualizar la  {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="( module.layer == 'delalleDoc' && !FormHeadDocument.$valid && document.permit.del )"
                         ng-click="delete(document)" >
                        <span class="icon-Eliminar" style="font-size: 24px"></span>
                        <md-tooltip>
                            Eliminar la {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="( FormHeadDocument.$valid && Docsession.global != 'new' && document.permit.cancel)"
                         ng-click="cancelDoc()" >
                        <span  style="font-size: 24px">(/)</span>
                        <md-tooltip>
                            Cancelar la {{formMode.name}}
                        </md-tooltip>
                    </div>
                    <div layout="column" layout-align="center center"
                         ng-show="( document.id && Docsession.isCopyableable && document.permit.update)"
                         ng-click="copyDoc()">
                        <span class="icon-Copiado" style="font-size: 24px"> </span>
                        <md-tooltip >
                            Crear una copia de la {{formMode.name}} (Sin adjuntos)
                        </md-tooltip>
                    </div>

                    <div layout="column"
                         ng-show="(!document.doc_parent_id && provSelec.id && module.layer == 'detalleDoc')"
                         layout-align="center center" ng-click="openImport()">
                        <span class="icon-Importar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Importar desde {{forModeAvilable.getXValue(formMode.value - 1 ) > 21 ? 'una': 'un' }}  {{ forModeAvilable.getXValue(formMode.value - 1 ).name}}
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

                <!-- botonera center -->
                <div layout="row" flex layout-align="start center "></div>

                <!-- botonera rigth -->
                <div style="width: 48px;" layout="column"   layout-align="center center" id="noti-button" ng-show= "module.index == 0">
                    <div class="{{(alerts.length > 0 ) ? 'animation-arrow' : 'animation-arrow-disable'}}" ng-click="moduleMsmCtrl()" id="noti-button"
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

        <!------------------------------------------- lista de embarques creados ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listShipment" id="listShipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listShipmentCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >Embarques</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>N° Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Carga</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="carga"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>En venezuela el</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_vnz"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_llegada_vnz"></grid-order-by>

                            </div>
                            <div flex layout="row"
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Flete</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="flete"></grid-order-by>

                            </div>

                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Nacionalizacion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nacionalizacion"></grid-order-by>

                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.carga}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.fecha_llegada_vnz}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.fecha_llegada_tiend}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.flete.monto}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(item)">{{item.nacionalizacion.monto}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex>
                                No hay datos para mostrar
                            </div>
                        </div>
                    </form>

                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- lista de embarques sin culminar ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listShipmentUncloset" id="listShipmentUncloset"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listShipmentUnclosetCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >Embarques</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>N° Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Carga</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_carga"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>En venezuela el</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_vnz"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_vnz"></grid-order-by>

                            </div>
                            <div flex layout="row"
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Flete</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="flete_tt"></grid-order-by>

                            </div>

                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Nacionalizacion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nacionalizacion"></grid-order-by>

                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict as filter"   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.fecha_carga}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.fecha_vnz}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.flete_tt}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.nacionalizacion}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="filter.length == 0">
                                No hay datos para mostrar
                            </div>
                        </div>
                    </form>

                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- resumen de embarque de embarques creados ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="summaryShipment" id="summaryShipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "summaryShipmentCtrl" >
                <div active-left  ></div>
                <div layout="column" flex>
                    <div layout="row">
                        <div class="titulo_formulario" style="height:39px;">
                            <div>
                                Embarque:
                            </div>
                        </div>
                        <div flex layout="column" layout-align="center start"> {{$parent.shipment.titulo }}</div>
                    </div>
                    <div layout="row" flex>
                        <div layout="column" flex="40" >
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Id</div>
                                <div class="rms" flex> {{$parent.shipment.id }}</div>
                                <md-tooltip >
                                    Numero de embarque
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Pais</div>
                                <div class="rms" flex> {{$parent.shipment.pais}}</div>
                                <md-tooltip >
                                    Pais de origen del embarque
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Puerto</div>
                                <div class="rms" flex> {{$parent.shipment.puerto}}</div>
                                <md-tooltip >
                                    Puerto de origen del embarque
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Freigth Fowarder</div>
                                <div class="rms" flex> {{$parent.shipment.freigth}}</div>
                                <md-tooltip >
                                    Compañia de traslado
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Naviera</div>
                                <div class="rms" flex> {{$parent.shipment.naviera}}</div>
                                <md-tooltip >
                                    Compañia de embarcacion
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Carga el</div>
                                <div class="rms" flex> {{$parent.shipment.carga | date :'dd-MM-yyyy'}}</div>
                                <md-tooltip >
                                    fecha de carga
                                </md-tooltip>
                            </div>

                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">En Venezuela</div>
                                <div class="rms" flex> {{shipment.fecha_llegada_vnz | date :'dd-MM-yyyy'}}</div>
                                <md-tooltip >
                                    fecha de llegada a venezuela
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">En tienda</div>
                                <div class="rms" flex> {{$parent.shipment.fecha_llegada_tiend | date :'dd-MM-yyyy'}}</div>
                                <md-tooltip >
                                    fecha de llegada a la tienda
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">N° MBL</div>
                                <div class="rms" flex> {{$parent.$parent.shipment.nro_mbl}}</div>
                                <md-tooltip >
                                    N° 'Master bill landig'
                                </md-tooltip>
                            </div>

                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">N° HBL</div>
                                <div class="rms" flex> {{$parent.shipment.nro_hbl}}</div>
                                <md-tooltip >
                                    N° 'House Bill of Lading'
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Exp. Aduana</div>
                                <div class="rms" flex> {{$parent.shipment.exp_aduanal}}</div>
                                <md-tooltip >
                                    N° de expediente aduanal
                                </md-tooltip>
                            </div>
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Flete
                                </div>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Terrestre</div>
                                <div class="rms" flex> {{$parent.shipment.monto_tt }}</div>
                                <md-tooltip >
                                    Monto a pagar flete terrestre
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Maritimo</div>
                                <div class="rms" flex> {{$parent.shipment.monto_mrt }}</div>
                                <md-tooltip >
                                    Monto a pagar flete maritimo
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Nacionalizacion</div>
                                <div class="rms" flex> {{$parent.shipment.monto_nacionalizacion}}</div>
                                <md-tooltip >
                                    Monto a pagar flete maritimo
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">DUA</div>
                                <div class="rms" flex> {{$parent.shipment.monto_dua}}</div>
                                <md-tooltip >
                                    Monto de declaracion unica de aduanas
                                </md-tooltip>
                            </div>

                        </div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" style="height:39px; padding: 0;" >
                                <div style="padding: 0;" >
                                    Pedidos
                                </div>
                            </div>
                            <div flex="30" class="gridContent" > </div>
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Productos
                                </div>
                            </div>
                            <div flex="20" class="gridContent"> </div>
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Container
                                </div>
                            </div>
                            <div flex class="gridContent"> </div>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- detalle de embarques creados ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="detailShipment" id="detailShipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "OpenShipmentCtrl" >
                <div layout="column" flex style="padding-right: 2px;">
                    <form name="detailShipmenthead" layout="row"  ng-class="{'focused':form== 'head'}" ng-click="form = 'head' ">
                        <div active-left  ></div>
                        <div layout="column" flex>

                            <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form== 'head'}" >
                                <div class="titulo_formulario" style="height:39px;" flex>
                                    <div>
                                        Embarque
                                    </div>
                                </div>
                                <div layout="row" layout-align="center end" class="form-row-head-option">
                                    <div flex layout="column" layout-align="center center" ng-click="formOptions.head.expand = !formOptions.head.expand;">
                                        <span class="{{(formOptions.head.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.head.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="formOptions.head.expand" >
                                <md-input-container class="md-block" flex  >
                                    <label>Proveedor</label>
                                    <md-autocomplete md-selected-item="provSelec"
                                                     info="Seleccione el proveedor del embarque"
                                                     required
                                                     ng-disabled="( session.isBlock )"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="provSelecText "
                                                     md-items="item in $parent.provs | stringKey : provSelecText : 'razon_social' "
                                                     md-item-text="item.razon_social"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                                     md-selected-item-change="$parent.shipment.prov_id = provSelec.id ;$parent.shipment.objs.prov_id = provSelec;"
                                    >
                                        <md-item-template>
                                            <span>{{item.razon_social}}</span>
                                        </md-item-template>
                                        <md-not-found >
                                            No se encontro el proveedor {{searchProveedor}}. ¿Desea crearlo?
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block" flex="15">
                                    <label>N°</label>
                                    <input  ng-model="$parent.shipment.id"
                                            ng-disabled="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div layout="row" class="date-row" ng-show="$parent.shipment.emision" style="min-width: 0;width: 158px;">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado</div>
                                    </div>
                                    <div layout="column" class="md-block" layout-align="center center"><div>{{$parent.shipment.emision | date : 'dd-MM-yyyy'}}</div></div>
                                </div>
                            </div>
                            <div layout="row" class="row"  ng-show="formOptions.head.expand" >
                                <md-input-container flex>
                                    <label>Titulo</label>
                                    <input  ng-model="$parent.shipment.titulo"
                                            ng-change="toEditHead('titulo', document.titulo ) "
                                            ng-disabled="( session.isblock )"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del embarque"
                                            skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div layout="row" class="row"  ng-click="openTarif();"   ng-show="formOptions.head.expand" >
                                <div class="adj-box-left" flex="10" style="color: rgb(176,176,176);margin-right: 8px;" >
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left;margin-right: 0">T </div>
                                    <div style="margin-top: 8px;    border-bottom: dotted 0.6px rgb(176,176,176);margin-left: 26px;">Tarifa</div>
                                </div>
                                <md-input-container class="md-block" flex  >
                                    <label>Pais</label>
                                    <input ng-model="$parent.shipment.objs.pais_id.short_name" ng-readonly="true" ng-disabled="(!$parent.shipment.objs.pais_id || $parent.shipment.objs.pais_id == null ) " />
                                </md-input-container>
                                <md-input-container class="md-block" flex="20"  >
                                    <label>Puerto</label>
                                    <input ng-model="$parent.shipment.objs.puerto_id.Main_port_name" ng-readonly="true" ng-disabled="(!$parent.shipment.objs.puerto_id || $parent.shipment.objs.puerto_id == null)" />
                                </md-input-container>

                                <md-input-container flex>
                                    <label>Freigth Forwarder</label>
                                    <input  ng-model="$parent.shipment.objs.tarifa_id.fregth_forwarder"
                                            ng-disabled="($parent.shipment.objs.tarifa_id.tbl_tarifa || $parent.shipment.objs.tarifa_id.tbl_tarifa == null) "
                                            ng-readonly="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container flexs>
                                    <label>Naviera</label>
                                    <input  ng-model="$parent.shipment.objs.tarifa_id.naviera"
                                            ng-readonly="true"
                                            ng-disabled="($parent.shipment.objs.tarifa_id.tbl_tarifa || $parent.shipment.objs.tarifa_id.tbl_tarifa == null) "
                                            skip-tab
                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <form name="date" layout="row" ng-class="{'focused':form== 'date'}" ng-click="form = 'date' " >
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form== 'date'}" >
                                <div flex class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Fechas
                                    </div>
                                </div>
                                <div layout="row" layout-align="center end" class="form-row-head-option">
                                    <div flex layout="column" layout-align="center center" ng-click="formOptions.date.expand = !formOptions.date.expand;">
                                        <span class="{{(formOptions.date.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.date.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="formOptions.date.expand" >
                                <div layout="row" class="date-row" flex="" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Carga</div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <md-datepicker ng-model="$parent.shipment.fecha_carga.value"
                                                       ng-disabled="( session.isBlock )"
                                                       skip-tab
                                        ></md-datepicker >
                                    </div>

                                </div>
                                <div layout="row" class="date-row" flex="" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En Venenzuela</div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <md-datepicker ng-model="$parent.shipment.fecha_llegada_vnz.value"
                                                       ng-disabled="( session.isBlock )"
                                                       skip-tab
                                        ></md-datepicker >
                                    </div>
                                </div>
                                <div layout="row" class="date-row" flex="" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En tienda</div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <md-datepicker ng-model="$parent.shipment.fecha_tienda.value"
                                                       ng-disabled="( session.isBlock )"
                                                       skip-tab
                                        ></md-datepicker >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form name="doc" layout="row" ng-class="{'focused':form== 'doc'}" ng-click="form = 'doc' ">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row"  class="form-row-head" ng-class="{'form-row-head-select':form== 'doc'}">
                                <div flex class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Documentos
                                    </div>
                                </div>
                                <div layout="row" layout-align="center end" class="form-row-head-option">
                                    <div flex layout="column" layout-align="center center" ng-click="formOptions.doc.expand = !formOptions.doc.expand;">
                                        <span class="{{(formOptions.doc.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.doc.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="formOptions.doc.expand" >
                                <md-input-container class="md-block" flex ng-click="$parent.miniMbl()" >
                                    <label>MBL</label>
                                    <input  ng-model="$parent.shipment.nro_mbl.documento"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div class="adj-box-rigth">
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">{{$parent.shipment.nro_mbl.adjs.length}} </div>
                                </div>
                                <md-input-container class="md-block" flex  ng-click="$parent.miniHbl()" >
                                    <label>HBL</label>
                                    <input  ng-model="$parent.shipment.nro_hbl.documento"
                                            ng-disabled="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div class="adj-box-rigth">
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">{{$parent.shipment.nro_hbl.adjs.length}} </div></div>

                                <md-input-container class="md-block" flex ng-click="$parent.miniExpAduana()" >
                                    <label>Exp. Aduanal</label>
                                    <input  ng-disabled="true"  ng-model="$parent.shipment.nro_dua.documento"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div class="adj-box-rigth">
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">{{$parent.shipment.nro_dua.adjs.length}} </div></div>

                            </div>
                        </div>
                    </form>
                    <form name="pago" layout="row" ng-class="{'focused':form== 'pago'}" ng-click="form = 'pago' ">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row"  class="form-row-head" ng-class="{'form-row-head-select':form== 'pago'}">
                                <div flex class="titulo_formulario" style="height:39px;" >
                                    <div>
                                        Pago
                                    </div>
                                </div>
                                <div layout="row" layout-align="center end" class="form-row-head-option" >
                                    <div flex layout="column" layout-align="center center" ng-click="formOptions.pago.expand = !formOptions.pago.expand;">
                                        <span class="{{(formOptions.pago.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.pago.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" ng-show="formOptions.pago.expand" >
                                <md-input-container class="md-block" >
                                    <label>Flete</label>
                                    <input  ng-model="$parent.shipment.monto"
                                            required
                                            skip-tab
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" >
                                    <label>Terrestre</label>
                                    <input  ng-model="$parent.shipment.flete.monto_terreste"
                                            required
                                            skip-tab
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" >
                                    <label>Nacionalizacion</label>
                                    <input  ng-model="$parent.shipment.flete.monto_nacionalizacion"
                                            required
                                            skip-tab
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" >
                                    <label>DUA</label>
                                    <input  ng-model="$parent.shipment.flete.monto_dua"
                                            required
                                            skip-tab
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <form name="agreds" layout="row" flex  ng-class="{'focused':form== 'agreds'}" ng-click="form = 'agreds' ">
                        <div active-left  ></div>
                        <div flex layout="column" >
                            <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form== 'agreds'}" ng-click="form = 'agreds' "  >
                                <div flex class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Agregados
                                    </div>
                                </div>

                                <div layout="row" layout-align="center end" class="form-row-head-option">
                                    <div flex layout="column" layout-align="center center" ng-click="formOptions.agreds.expand = !formOptions.agreds.expand;">
                                        <span class="{{(formOptions.agreds.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.agreds.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>
                            </div>
                            <div layout="row" flex  ng-show="formOptions.agreds.expand">
                                <div flex layout="column" >
                                    <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form== 'agreds'}">
                                        <div class="titulo_formulario" style="height:39px;" flex>
                                            <div>
                                                Container
                                            </div>
                                        </div>
                                        <div layout="column" layout-align="center center" id="btnAgrCp" ng-click="miniContainerCtrl()" style="width:24px;">
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>
                                    </div>
                                    <div flex class="gridContent">
                                        <div ng-repeat="item in $parent.shipment.containers" >
                                            <div layout="row" class="cellGridHolder" >
                                                <div flex class="cellGrid" >{{item.tipo}} </div>
                                                <div flex class="cellGrid"> {{item.peso}}</div>
                                                <div flex class="cellGrid"> {{item.volumen}}</div>
                                                <div flex class="cellGrid"> {{item.cantidad}}</div>
                                            </div>
                                        </div>
                                        <div flex layout="column" layout-align="center center" ng-show="$parent.shipment.containers.length == 0 ">
                                            No hay datos para mostrar
                                        </div>
                                    </div>
                                </div>
                                <div flex layout="column"  style="padding: 0 4px 0 4px;">
                                    <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form== 'agreds'}" >
                                        <div flex class="titulo_formulario" style="height:39px;">
                                            <div>
                                                Pedidos
                                            </div>
                                        </div>
                                        <div layout="column" layout-align="center center" ng-click="listOrdershipment()" style="width:24px;">
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>

                                    </div>
                                    <div flex class="gridContent">
                                        <div ng-repeat="item in $parent.shipment.odcs" >
                                            <div layout="row" class="cellGridHolder" >
                                                <div flex class="cellGrid" >{{item.id}} </div>
                                                <div flex class="cellGrid"> {{item.monto}}</div>
                                                <div flex class="cellGrid"> {{item.mt3}}</div>
                                                <div flex class="cellGrid"> {{item.peso}}</div>
                                            </div>
                                        </div>
                                        <div flex layout="column" layout-align="center center" ng-show="$parent.shipment.odcs.length == 0 ">
                                            No hay datos para mostrar
                                        </div>
                                    </div>

                                </div>
                                <div flex layout="column" >
                                    <div layout="row" class="form-row-head" ng-class="{'form-row-head-select': form == 'agreds'}" >
                                        <div flex class="titulo_formulario" style="height:39px;">
                                            <div>
                                                Productos
                                            </div>
                                        </div>
                                        <div layout="column" layout-align="center center" id="btnAgrCp" ng-click="listProductshipment()" style="width:24px;">
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>

                                    </div>
                                    <div flex class="gridContent">
                                        <div ng-repeat="item in $parent.shipment.prods" >
                                            <div layout="row" class="cellGridHolder" >
                                                <div flex class="cellGrid" >{{item.id}} </div>
                                                <div flex class="cellGrid"> {{item.monto}}</div>
                                                <div flex class="cellGrid"> {{item.mt3}}</div>
                                                <div flex class="cellGrid"> {{item.peso}}</div>
                                            </div>
                                        </div>
                                        <div flex layout="column" layout-align="center center" ng-show="$parent.shipment.prods.length == 0 ||  !$parent.shipment.prods">
                                            No hay datos para mostrar
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </md-content>
        </md-sidenav>


        <!------------------------------------------- detalle de orden asignada ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="detailOrder" id="detailOrder"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "detailOrderShipmentCtrl" >
                <div layout="column" flex>
                    <form layout="row" class="focused">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row" >
                                <div layout="row"  class="form-row-head form-row-head-select" flex >
                                    <div class="titulo_formulario" style="height: 39px;" flex>
                                        <div>
                                            <div >Detalle de Pedido Agregado</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" flex  >
                                    <label>Titulo</label>
                                    <input  ng-model="select.titulo"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En producion</div>
                                    </div>
                                    <div layout="column"  layout-align="center center">{{select.fecha_produccion}}</div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Aprobacion</div>
                                    </div>
                                    <md-datepicker ng-model="select.fecha_aprob_gerencia"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>
                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="select.nro_proforma.documento"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                                <div  class="adj-box-rigth">
                                    <div  class="vlc-buttom  ng-disbled"  style="float:left">
                                        {{ select.nro_proforma.documento.adjs.length|| 0 }}
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Monto</label>
                                    <input ng-model="select.monto"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso(Kg)</label>
                                    <input ng-model="select.peso"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="select.mt3"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div layout="row" class="row" style="color: #c3c3c3;" >
                                <div layout="row" layout-align="center center">
                                    <div>Tipo asignacion:</div>
                                    <div>{{select.isTotal ? 'Total' : 'Parcial' }}</div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div layout="column" flex>
                        <div layout="row" class="focused" >
                            <div active-left  ></div>
                            <div layout="row" >
                                <div class="titulo_formulario"  class="form-row-head form-row-head-select" flex>
                                    <div>
                                        <span style="color: rgb(92, 183, 235);">Productos</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div layout="row">
                            <div active-left  ></div>

                            <div layout="row"  flex style="padding-right: 4px;">

                                <div  layout="row" class="table-filter-head" style="width: 40px; margin:  0 2px 0 2px;"></div>

                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Cod</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.carga"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="codigo"></grid-order-by>
                                </div>


                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Cod.  Fabrica</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.fecha_llegada_tiend"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="cod_fabrica"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Descripcion</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.flete"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="descripcion"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Origen</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.origen.text"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="descripcion"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <!--   saldo en odc maximo a asignar-->
                                    <md-input-container class="md-block"  flex>
                                        <label>Total</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.cantidad"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="total"></grid-order-by>
                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <!--   saldo en el emarques [asignado durante la sesion del doc]  validar contra cantidad-->
                                    <md-input-container class="md-block"  flex>
                                        <label>Asignado</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.saldo"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="fecha_aprob_gerencia"></grid-order-by>

                                </div>

                            </div>
                        </div>
                        <form layout="row"  class="gridContent" flex>
                            <div active-left  ></div>
                            <div layout="column" flex>
                                <div   ng-repeat="item in select.prods | filter : tbl.filter:strict as filter "   >
                                    <div layout="row" class="cellGridHolder"  ng-class="{'table-row-select':(prodSelect.id == item.id)}" >
                                        <div  ng-click="open(item)" class="cellEmpty" style="width: 40px;margin: 0 2px 0 2px;">
                                            <md-switch ng-disabled="true" class="md-primary" ng-model="item.asignado" ng-change="changeAsig(item)"> </md-switch>
                                        </div>
                                        <div flex class="cellGrid" ng-click="open(item)">{{item.codigo}}</div>
                                        <div flex class="cellGrid" ng-click="open(item)" >{{item.cod_fabrica}}</div>
                                        <div flex class="cellGrid" ng-click="open(item)" >{{item.descripcion}}</div>
                                        <div flex class="cellGrid" ng-click="open(item)" >{{item.origen.text}}</div>
                                        <div flex class="cellGrid" ng-click="open(item)" >{{item.cantidad}}</div>
                                        <div flex class="cellGrid" ng-click="open(item)" >{{item.saldo}}</div>

                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" flex ng-show="filter.length == 0 ">
                                    No hay datos para mostrar
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- detalle de embarques creados ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="detailOrderAdd" id="detailOrderAdd"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "detailOrderAddCtrl" >
                <div layout="column" flex>
                    <form layout="row" class="focused">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row" >
                                <div layout="row"  class="form-row-head form-row-head-select " flex>
                                    <div class="titulo_formulario" flex>
                                        <div>
                                            <span >Detalle de Pedido</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" flex  >
                                    <label>Titulo</label>
                                    <input  ng-model="select.titulo"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En producion</div>
                                    </div>
                                    <div layout="column"  layout-align="center center">{{select.fecha_produccion}}</div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Aprobacion</div>
                                    </div>
                                    <md-datepicker ng-model="select.fecha_aprob_gerencia"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>
                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="select.nro_proforma.documento"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <div  class="adj-box-rigth">
                                    <div  class="vlc-buttom  ng-disbled"  style="float:left">
                                        {{ select.nro_proforma.documento.adjs.length|| 0 }}
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Monto</label>
                                    <input ng-model="select.monto"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso(Kg)</label>
                                    <input ng-model="select.peso"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="select.mt3"  ng-disabled="( true )"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <div layout="column" flex>
                        <div layout="row" class="focused" >
                            <div active-left  ></div>
                            <div layout="row"  class="row" class="form-row-head form-row-head-select " >
                                <div class="titulo_formulario"  flex>
                                    <div>
                                        <span >Productos</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div layout="row">
                            <div active-left  ></div>

                            <div layout="row"  flex style="padding-right: 4px;">
                                <div flex layout="row" class="table-filter-head">


                                    <md-input-container class="md-block"  flex>
                                        <label>Cod</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.codigo"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="codigo"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Cod.  Fabrica</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.codigo_fabrica"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="codigo_fabrica"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Descripcion</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.descripcion"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="descripcion"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Origen</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.origen.text"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="origen_item_id"></grid-order-by>

                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <!--   saldo en odc maximo a asignar-->
                                    <md-input-container class="md-block"  flex>
                                        <label>Total</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.cantidad"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="cantidad"></grid-order-by>
                                </div>
                                <div flex layout="row" class="table-filter-head">
                                    <!--   saldo en el emarques [asignado durante la sesion del doc]  validar contra cantidad-->
                                    <md-input-container class="md-block"  flex>
                                        <label>Asignado</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.saldo"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>

                                </div>

                            </div>
                        </div>
                        <form layout="row"  class="gridContent" flex>
                            <div active-left  ></div>
                            <div layout="column" flex>
                                <div   ng-repeat="item in select.prods | filter : tbl.filter:strict as filter "   >
                                    <div layout="row" class="cellGridHolder" ng-class="{'table-row-select':(prdSelect.id == item.id)}">
                                        <div flex class="cellGrid"  ng-click="openProd(item)" >{{item.codigo}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)">{{item.codigo_fabrica}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)">{{item.descripcion}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)">{{item.origen.text}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)">{{item.cantidad}}</div>
                                        <div flex class="cellGrid" ng-click="openProd(item)" >{{item.saldo}}</div>

                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" flex ng-show="filter.length == 0 ">
                                    No hay datos para mostrar
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- lista de tarifas------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listTariff" id="listTariff"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listTariffCtrl" >
                <div layout="column" flex="70">
                    <div layout="row"  >
                        <div active-left ></div>
                        <div flex layout="row" class="form-row-head form-row-head-select" >
                            <div class="titulo_formulario row" flex>
                                <div>
                                    <span style="">Tarifas</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <form layout="row" name="tariffF1">
                        <div active-left ></div>
                        <div layout="column" flex>
                            <div layout="row" class="row" style="overflow: hidden;">
                                <md-input-container class="md-block" flex >
                                    <label>Pais</label>
                                    <md-autocomplete md-selected-item="pais_idSelec"
                                                     info="Selecione el pais de origen para el embarque"
                                                     ng-disabled="( session.isBlock )"
                                                     ng-click="$parent.toEditHead('pais_id', provSelect.id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="pais_idText"
                                                     md-auto-select="true"
                                                     md-items="item in $parent.provSelec.direcciones | stringKey : pais_idText : 'short_name' "
                                                     md-item-text="item.short_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                                     md-selected-item-change="$parent.shipment.pais_id = pais_idSelec.id ;$parent.shipment.objs.pais_id = pais_idSelec;"
                                    >
                                        <md-item-template>
                                            <span>{{item.short_name}}</span>
                                        </md-item-template>
                                        <md-not-found >
                                            No se encontro el pais {{pais_idText}}
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                                <md-input-container class="md-block" flex="30" >
                                    <label>Puerto</label>
                                    <md-autocomplete md-selected-item="puerto_idSelec"
                                                     requiered
                                                     info="Selecione el puerto de origen para el embarque"
                                                     ng-disabled="( session.isBlock )"
                                                     skip-tab
                                                     md-search-text="puerto_idText"
                                                     md-auto-select="true"
                                                     md-items="item in (pais_idSelec ==  null) ? [] :pais_idSelec.ports  | stringKey : puerto_idSelec : 'Main_port_name' "
                                                     md-item-text="item.Main_port_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-selected-item-change="$parent.shipment.puerto_id = pais_idSelec.id ;$parent.shipment.objs.puerto_id = puerto_idSelec;"

                                    >
                                        <md-item-template>
                                            <span>{{item.Main_port_name}}</span>
                                        </md-item-template>
                                        <md-not-found >
                                            No se encontro el puerto {{puerto_idText}}
                                        </md-not-found>
                                    </md-autocomplete>
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex layout="row" class="table-filter-head">

                                <md-input-container class="md-block"  flex>
                                    <label>T/T</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.dias_tt"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="dias_tt"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>20' SD </label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.sd20"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="sd20"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>40' SD</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.sd40"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="sd40"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>40' HC</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.hc40"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="hc40"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>40' OT</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.ot40"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="ot40"></grid-order-by>
                            </div>

                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict as filter "   id="row{{$index}}" ng-click="setData(item)" >
                                <div layout="row" class="cellGridHolder" ng-class="{'table-row-select':(tarifaSelect.id == item.id)}" >
                                    <div flex class="cellGrid" >{{item.dias_tt}}</div>
                                    <div flex class="cellGrid">{{item.sd20}}</div>
                                    <div flex class="cellGrid" >{{item.sd40}}</div>
                                    <div flex class="cellGrid">{{item.hc40}}</div>
                                    <div flex class="cellGrid" >{{item.ot40}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filter.length == 0" flex>
                                No hay datos para mostrar
                            </div>
                        </div>

                    </form>

                </div>
                <div layout="column" flex class="gridContent" style="margin:0 0 0 4px">
                    <div  layout="row" class="form-row-head form-row-head-select" >
                        <div class="titulo_formulario" flex>
                            <div>
                                <span >Bondades</span>
                            </div>
                        </div>
                    </div>
                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Freigth Fowarder</div>
                        <div class="rms" flex> {{tarifaSelect.fregth_forwarder}}</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>
                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Naviera</div>
                        <div class="rms" flex>  {{tarifaSelect.naviera}}</div>
                        <md-tooltip >
                            Naviera
                        </md-tooltip>
                    </div>
                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Puerto</div>
                        <div class="rms" flex>  {{tarifaSelect.objs.puerto_id.Main_port_name}}</div>
                        <md-tooltip >
                            Puerto de salida
                        </md-tooltip>
                    </div>

                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">T/T</div>
                        <div class="rms" flex>  {{tarifaSelect.dias_tt}}</div>
                        <md-tooltip >
                            Tiempo de transito
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">GRT</div>
                        <div class="rms" flex>  {{tarifaSelect.grt}}</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row"flex >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Documento</div>
                        <div class="rms" flex> {{tarifaSelect.documento}}</div>
                        <md-tooltip >
                            Costo en documento
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Mensajeria</div>
                        <div class="rms" flex> {{tarifaSelect.mensajeria}}</div>
                        <md-tooltip >
                            Compañia de mensajeria
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Seguros</div>
                        <div class="rms" flex> {{tarifaSelect.seguro}}</div>
                        <md-tooltip >
                            Costo de seguro
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Consolidacion</div>
                        <div class="rms" flex> {{tarifaSelect.consolidacion}}</div>
                        <md-tooltip >
                            Costo de consolidacion
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">20'SD</div>
                        <div class="rms" flex> {{tarifaSelect.sd20}}</div>
                        <md-tooltip >
                            Costo container 20'SD
                        </md-tooltip>
                    </div>
                    <div layout="row"flex >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">40'SD</div>
                        <div class="rms" flex> {{tarifaSelect.sd40}}</div>
                        <md-tooltip >
                            Costo de container 40 ' SD
                        </md-tooltip>
                    </div>
                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">40'HC</div>
                        <div class="rms" flex> {{tarifaSelect.hc40}}</div>
                        <md-tooltip >
                            costo de container 40' HC
                        </md-tooltip>
                    </div>
                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">40'OT</div>
                        <div class="rms" flex> {{tarifaSelect.ot40}}</div>
                        <md-tooltip >
                            costo de container 40'OT
                        </md-tooltip>
                    </div>
                </div>
            </md-content>

        </md-sidenav>

        <!------------------------------------------- lista de pedidos para agregar------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listOrderAdd" id="listOrderAdd"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listOrderAddCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" flex>
                                <div>
                                    <span style="">Pedidos para Agregar</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div class="cellEmpty" style="width: 40px;margin: 0 2px 0 2px;"></div>
                            <div flex layout="row" class="table-filter-head">

                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Creado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_produccion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_produccion"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Aprobado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_aprob_gerencia"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.monto"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>Mt3</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.mt3"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>Peso</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.peso"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="peso"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict as filtre"     >
                                <div layout="row" class="cellGridHolder"   ng-class="{'table-row-select':(prdSelect.id == item.id)}" >
                                    <div class="cellEmpty" style="width: 40px;margin: 0 2px 0 2px;">
                                        <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeAsig(item)"> </md-switch>
                                    </div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.fecha_produccion}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.fecha_aprob_gerencia}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.nro_proforma}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.monto}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.mt3}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.peso}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show=" filtre.length == 0">
                                No hay datos para mostrar
                            </div>
                            <!-- <div  style="position: absolute; top: 0;">
                                 <div> {{plusdata.data | json}}</div>
                             </div>-->
                        </div>

                    </form>

                </div>

            </md-content>

        </md-sidenav>

        <!------------------------------------------- lista de pedidos agregados------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listOrdershipment" id="listOrdershipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listOrdershipmentCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">

                            <div class="titulo_formulario" flex>
                                <div>
                                    <span style="">Pedidos Agregados</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div class="cellEmpty" style="width: 40px;margin: 0 2px 0 2px;"></div>
                            <div flex layout="row" class="table-filter-head">

                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Creado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_produccion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_produccion"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Aprobado</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_aprob_gerencia"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Proforma</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_proforma"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>Monto</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>Mt3</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.mt3"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>Peso</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.peso"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="peso"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label></label>
                                    <md-select ng-model="tbl.filter.isTotal"  skip-tab  >
                                        <md-option value="0">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" >
                                                    P
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="1">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" >
                                                    T
                                                </div>
                                            </div>
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="isTotal"></grid-order-by>
                            </div>

                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in $parent.shipment.odcs | filter : tbl.filter:strict as filter "    >
                                <div layout="row" class="cellGridHolder"  ng-class="{'table-row-select':(select.id == item.id)}"  >
                                    <div class="cellEmpty" style="width: 40px;margin: 0 2px 0 2px;">
                                        <md-switch class="md-primary" ng-model="item.asignado" ng-change="changeAsig(item)"> </md-switch>
                                    </div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.fecha_produccion | date :'dd/MM/yyyy' }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)"  >{{item.fecha_aprob_gerencia | date :'dd/MM/yyyy' }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.nro_proforma   }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.monto   }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.mt3  }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.peso }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{(item.isTotal == 1) ?  'T': 'P' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show=" filter.length == 0 ">
                                No hay datos para mostrar
                            </div>
                        </div>

                    </form>

                </div>
            </md-content>

        </md-sidenav>

        <!------------------------------------------- lista de productos agregados------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listProductshipment" id="listProductshipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listProducttshipmentCtrl" >
                <div layout="column" flex="70"  style="padding-right: 8px;">
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select" >
                            <div class="titulo_formulario row" flex >
                                <div>
                                    <span style="">Productos agregados</span>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-click="$parent.listProductAdd()" style="width:24px;">
                                <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                <md-tooltip >
                                    Agregar producto
                                </md-tooltip>
                            </div>
                            <div layout="column" layout-align="center center" ng-click="$parent.CreatProduct()" style="width:24px;">
                                <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                <md-tooltip >
                                    Crear producto
                                </md-tooltip>
                            </div>
                        </div>

                    </div>

                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex layout="row" class="table-filter-head">

                                <md-input-container class="md-block"  flex>
                                    <label>Cod</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cod_fabrica"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Cod.  Fabrica</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_tiend"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cod_profic"></grid-order-by>

                            </div>

                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Descripcion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_aprob_gerencia"></grid-order-by>

                            </div>

                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Cantidad</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                            </div>


                        </div>
                    </div>
                    <div layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" >{{item.titulo}}</div>
                                    <div flex class="cellGrid">{{item.id}}</div>
                                    <div flex class="cellGrid" >{{item.nro_factura}}</div>
                                    <div flex class="cellGrid">{{item.carga}}</div>
                                    <div flex class="cellGrid" >{{item.fecha_llegada_vnz}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex>
                                No hay datos para mostrar
                            </div>
                        </div>

                    </div>

                </div>
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div layout="row" flex  class="mini-content-title">

                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="">Detalle de Producto</span>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center"  style="width:24px;">
                                <span class="icon-Actualizar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                            </div>
                        </div>

                    </div>
                    <div flex class="gridContent" style="margin-top: 8px;">
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cantidad </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Cantidad asignada al embarque
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Codigo </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Codigo del producto
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Fabrica </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Codigo de fabrica
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Descripcion </div>
                            <div class="rms" style="height: 240px; white-space: normal;" flex> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan, velit a imperdiet commodo, arcu ex mollis justo, vel venenatis justo leo eget dui. Morbi congue augue vitae dui consequat.</div>
                            <md-tooltip >
                                Codigo de fabrica
                            </md-tooltip>
                        </div>

                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">c/u </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Costo Unitario
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">c/t </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Costo Total
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Chequeado </div>
                            <div class="rms" flex> Si</div>
                            <md-tooltip >
                                Revision de llegada de producto en almacen
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Calidad </div>
                            <div class="rms" flex> Si</div>
                            <md-tooltip >
                                Revision de calidad del producto en almacen
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Exhibicion </div>
                            <div class="rms" flex> Si</div>
                            <md-tooltip >
                                Solicitud de productos para revision?
                            </md-tooltip>
                        </div>
                    </div>
                </div>
            </md-content>

        </md-sidenav>

        <!------------------------------------------- lista de productos por agregar------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listProductAdd" id="listProductAdd"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listProductAddCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row"  class="form-row-head form-row-head-select"  flex>
                            <div class="titulo_formulario" flex>
                                <div>
                                    <span style="">Productos por culminar</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div class="cellEmpty" style="width: 40px;margin: 0 2px 0 2px;"></div>
                            <div flex layout="row" class="table-filter-head">

                                <md-input-container class="md-block"  flex>
                                    <label>Cod</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cod_fabrica"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Cod.  Fabrica</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_tiend"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cod_profic"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Descripcion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_aprob_gerencia"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>Cantidad</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>c/u</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="monto"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>c/t</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.mt3"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter as filter"   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder"  ng-class="{'table-row-select':(select.id == item.id)}" >
                                    <div class="cellEmpty" style=" width: 40px;margin: 0 2px 0 2px;" ng-click="changeAsig(item)">
                                        <md-switch class="md-primary" ng-disabled="true" ng-model="item.asignado" > </md-switch>
                                    </div>
                                    <div flex class="cellGrid" >{{item.codigo}}</div>
                                    <div flex class="cellGrid" >{{item.codigo_fabrica}}</div>
                                    <div flex class="cellGrid" >{{item.descripcion}}</div>
                                    <div flex class="cellGrid" >{{item.cantidad}}</div>
                                    <div flex class="cellGrid" >{{item.precio}}</div>
                                    <div flex class="cellGrid" >{{item.total}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show=" filter.length == 0">
                                No hay datos para mostrar
                            </div>
                        </div>

                    </form>
                </div>

            </md-content>

        </md-sidenav>

        <!------------------------------------------- mini layer historial de producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniHistoryProd" id="miniHistoryProd"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="historyProductCtrl"    >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)" style="padding-left: 12px">
                    <div layout="row"  class="form-row-head form-row-head-select"  >
                        <div class="titulo_formulario" style="height:39px;">
                            <div>
                                Historial
                            </div>
                        </div>
                    </div>

                    <div layout="row" style="padding-right: 4px;">
                        <md-input-container class="md-block" flex  >
                            <label>Tipo</label>
                            <md-autocomplete md-selected-item="tipo.select"
                                             info="Tipo de container"
                                             required
                                             skip-tab
                                             md-search-text="tipo.text"
                                             md-auto-select="true"
                                             md-items="item in containers | filter :tipo.text"
                                             md-item-text="item.razon_social"
                                             md-autoselect = "true"
                                             md-no-asterisk
                                             md-min-length="0"
                                             md-require-match="true"
                                             md-no-cache="true"
                                             md-select-on-match
                            >
                                <md-item-template>
                                    <span>{{item.nombre}}</span>
                                </md-item-template>
                            </md-autocomplete>
                        </md-input-container>
                        <md-input-container flex>
                            <label>N° </label>
                            <input  ng-model="filter.fecha" skip-tab
                            >
                        </md-input-container>

                        <md-input-container flex>
                            <label>Fecha</label>
                            <input  ng-model="container.volumen" skip-tab
                            >
                        </md-input-container>

                        <md-input-container flex>
                            <label>Cantidad</label>
                            <input  ng-model="container.cantidad" skip-tab
                            >
                        </md-input-container>
                        <md-input-container flex>
                            <label>Costo?</label>
                            <input  ng-model="container.cantidad" skip-tab
                            >
                        </md-input-container>
                    </div>
                    <form flex layout="column" class="gridContent">
                        <div ng-repeat="item in $parent.shipment.containers" >
                            <div layout="row" class="cellGridHolder" >
                                <div flex class="cellGrid" >{{item.tipo}} </div>
                                <div flex class="cellGrid"> {{item.peso}}</div>
                                <div flex class="cellGrid"> {{item.volumen}}</div>
                                <div flex class="cellGrid"> {{item.cantidad}}</div>
                            </div>
                        </div>
                    </form>
                </div>
            </md-content>
        </md-sidenav>


        <!------------------------------------------- mini layer master bill landing------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniMbl" id="miniMbl"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniMblCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div  layout="column" flex style="padding-left: 12px">
                        <form name="head" layout="column" flex="">
                            <div layout="row"  class="form-row-head form-row-head-select"  >
                                <div class="titulo_formulario" style="color:rgb(84, 180, 234);">
                                    <div>
                                        Master bill landing
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <div layout="row" class="row">
                                    <md-input-container class="md-block" >
                                        <label>N°</label>
                                        <input  type="text" ng-model="$parent.shipment.nro_mbl.documento"   >
                                    </md-input-container>
                                </div>
                                <div layout="row" class="row">
                                    <div layout="row" class="date-row" >
                                        <div layout="column" class="md-block" layout-align="center center"  >
                                            <div style="width: 88px;">Emitido</div>
                                        </div>
                                        <md-datepicker ng-model="$parent.shipment.nro_mbl.emision"
                                                       skip-tab
                                                       required
                                        ></md-datepicker >
                                    </div>
                                </div>
                                <div style="padding: 2px;; min-height: 56px;" layout="row" >
                                    <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                         ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                        Insertar archivo
                                    </div>
                                </div>

                            </div>

                            <div flex class="gridContent" ng-show="$parent.shipment.nro_mbl.adjs.length > 0">
                                <div class="imgItem" ng-repeat="item in $parent.shipment.nro_mbl.adjs " ng-click="selectImg(item)">
                                    <img ng-src="images/thumbs/{{item.thumb}}"/>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="$parent.shipment.nro_mbl.adjs.length == 0" >
                                No hay adjuntos cargados
                            </div>

                        </form>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer house bill landing------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniHbl" id="miniHbl"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniHblCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div  layout="column" flex style="padding-left: 12px">
                        <form  name="head" layout="column" flex="">
                            <div layout="row"  class="form-row-head form-row-head-select"  >
                                <div class="titulo_formulario" style="color:rgb(84, 180, 234);" >
                                    <div>
                                        House bill landing
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <md-input-container class="md-block" >
                                    <label>N°</label>
                                    <input  type="text" ng-model="$parent.shipment.nro_hbl.documento"  tabindex="-1" >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div  style="width: 88px;">Emitido</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.nro_hbl.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>

                            </div>
                            <div style="padding: 2px;; min-height: 56px;" layout="row" >
                                <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                     ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                    Insertar archivo
                                </div>
                            </div>

                            <div flex class="gridContent" ng-show="$parent.shipment.nro_hbl.adjs.length > 0">
                                <div class="imgItem" ng-repeat="item in $parent.shipment.nro_hbl.adjs " ng-click="selectImg(item)">
                                    <img ng-src="images/thumbs/{{item.thumb}}"/>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="$parent.shipment.nro_hbl.adjs.length == 0" >
                                No hay adjuntos cargados
                            </div>

                        </form>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer DUA bill landing------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniExpAduana" id="miniExpAduana"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniExpAduanaCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div  layout="column" flex style="padding-left: 12px">
                        <form  name="head" layout="column" flex="">
                            <div layout="row"  class="form-row-head form-row-head-select"  >
                                <div class="titulo_formulario" style="color:rgb(84, 180, 234);">
                                    <div >
                                        Expediante de aduana
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <md-input-container class="md-block" >
                                    <label>N°</label>
                                    <input  type="text" ng-model="$parent.shipment.nro_dua.documento"  tabindex="-1" >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div style="width: 88px;">Emitido</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.nro_dua.emision"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>

                            </div>
                            <div style="padding: 2px;; min-height: 56px;" layout="row" >
                                <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                     ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                    Insertar archivo
                                </div>
                            </div>
                            <div flex class="gridContent" ng-show="$parent.shipment.nro_dua.adjs.length > 0">
                                <div class="imgItem" ng-repeat="item in $parent.shipment.nro_dua.adjs " ng-click="selectImg(item)">
                                    <img ng-src="images/thumbs/{{item.thumb}}"/>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="$parent.shipment.nro_dua.adjs.length == 0" >
                                No hay adjuntos cargados
                            </div>

                        </form>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer agregar container ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniContainer" id="miniContainer"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="miniContainerCtrl"    >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)" style="    padding-right: 4px;">
                    <div layout="row" layout-align="start center" class="focused" style="padding-left: 12px">
                        <div layout="row" class="form-row-head form-row-head-select" flex  >
                            <div flex  class="titulo_formulario" flex>
                                <div>
                                    Containers
                                </div>
                            </div>
                            <div layout="row" layout-align="center end" class="form-row-head-option">
                                <div flex layout="column" layout-align="center center" ng-click="created()">
                                    <span class="icon-Agregar" style="font-size: 12px"></span>
                                    <md-tooltip >
                                        Nuevo Container
                                    </md-tooltip>
                                </div>
                                <div flex layout="column" layout-align="center center" ng-click="update()" >
                                    <span class="icon-Actualizar" style="font-size: 12px" ng-style="(!select.id) ? {'color':'rgb(171,171,171)'} : {}"></span>
                                    <md-tooltip >
                                        Actualizar Container
                                    </md-tooltip>
                                </div>
                            </div>

                        </div>

                    </div>

                    <form name="containerForm" layout="row" style="padding-right: 4px;" ng-show="options.form">
                        <div  style="padding-left: 24px" layout="row">
                            <div style="width: 16px;"></div>
                            <md-input-container class="md-block" flex  >
                                <label>Tipo</label>
                                <md-autocomplete md-selected-item="tipo_select"
                                                 info="Tipo de container"
                                                 required
                                                 skip-tab
                                                 md-search-text="tipo_text"
                                                 md-auto-select="true"
                                                 md-items="item in containers | filter : tipo_text "
                                                 md-item-text="item.name"
                                                 md-autoselect = "true"
                                                 md-no-asterisk
                                                 md-min-length="0"
                                                 md-no-cache="true"
                                                 md-select-on-match="true"
                                                 md-selected-item-change="model.tipo = item.name;"
                                >
                                    <md-item-template>
                                        <span>{{item.name}}</span>
                                    </md-item-template>
                                </md-autocomplete>
                            </md-input-container>
                            <md-input-container flex>
                                <label>Peso</label>
                                <input  ng-model="model.peso" skip-tab decimal required>
                            </md-input-container>

                            <md-input-container flex>
                                <label>Volumen</label>
                                <input  ng-model="model.volumen" skip-tab required >
                            </md-input-container>

                            <md-input-container flex>
                                <label>Cantidad</label>
                                <input  ng-model="model.cantidad" skip-tab required   ng-keypress="($event.which === 13)? save(): 0 ">
                            </md-input-container>
                        </div>


                    </form>
                    <form flex layout="row" class="gridContent">
                        <div style="width: 12px;" ></div>
                        <div layout="column" flex>
                            <div ng-repeat="item in $parent.shipment.containers" >
                                <div layout="row" class="cellGridHolder" ng-click="setData(item, this)" ng-class="{'table-row-select':(select.id == item.id)}" >
                                    <div style="width: 24px;padding-top: 15px;border: none;">
                                        <div  layout="column" layout-align="center center"  ng-click="delete(item, this)"  >
                                            <span class="icon-Eliminar" style="font-size: 12px"></span>
                                        </div>
                                    </div>
                                    <div flex class="cellGrid" >{{item.tipo}} </div>
                                    <div flex class="cellGrid"> {{item.peso}}</div>
                                    <div flex class="cellGrid"> {{item.volumen}}</div>
                                    <div flex class="cellGrid"> {{item.cantidad}}</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer crear  producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniCreatProduct" id="miniCreatProduct"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="CreatProductCtrl" style="padding-left: 12px" >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row" class="form-row-head form-row-head-select" >

                        <div class="titulo_formulario">
                            <div>
                                Crear producto
                            </div>
                        </div>
                    </div>
                    <div flex class="gridContent" layout="column" style="padding-right:4px">
                        <md-input-container class="md-block" >
                            <label>Codigo</label>
                            <input  type="text" ng-model="prod.cod"  tabindex="-1" >

                        </md-input-container>
                        <md-input-container class="md-block" >
                            <label>Cod. Profit</label>
                            <input  type="text" ng-model="prod.cod_profit"  tabindex="-1" >

                        </md-input-container>
                        <md-input-container class="md-block" >
                            <label>Cod. fabrica</label>
                            <input  type="text" ng-model="prod.cod_fabrica"  tabindex="-1" >

                        </md-input-container>
                        <md-input-container class="md-block" >
                            <label>Cod. Barra</label>
                            <input  type="text" ng-model="prod.cod_barra"  tabindex="-1" >
                        </md-input-container>

                        <md-input-container class="md-block" >
                            <label>Precio</label>
                            <input  type="text" ng-model="prod.precio"  tabindex="-1" >
                        </md-input-container>
                        <md-input-container class="md-block"   >
                            <label>Linea</label>
                            <md-autocomplete md-selected-item="autoCp.provSele.select"
                                             info="Seleccione el proveedor del embarque"
                                             required
                                             ng-disabled="( session.isBlock )"
                                             ng-click="$parent.toEditHead('prov_id', provSelect.id)"
                                             id="prov_id"
                                             skip-tab
                                             md-search-text="autoCp.provSele.text"
                                             md-auto-select="true"
                                             md-items="item in $parent.provs | stringKey : autoCp.provSele.text : 'razon_social' "
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
                                <md-not-found >
                                    No se encontro el proveedor {{searchProveedor}}. ¿Desea crearlo?
                                </md-not-found>
                            </md-autocomplete>
                        </md-input-container>
                        <md-input-container class="md-block"   >
                            <label>Sub-linea</label>
                            <md-autocomplete md-selected-item="autoCp.provSele.select"
                                             info="Seleccione el proveedor del embarque"
                                             required
                                             ng-disabled="( session.isBlock )"
                                             ng-click="$parent.toEditHead('prov_id', provSelect.id)"
                                             id="prov_id"
                                             skip-tab
                                             md-search-text="autoCp.provSele.text"
                                             md-auto-select="true"
                                             md-items="item in $parent.provs | stringKey : autoCp.provSele.text : 'razon_social' "
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
                                <md-not-found >
                                    No se encontro el proveedor {{searchProveedor}}. ¿Desea crearlo?
                                </md-not-found>
                            </md-autocomplete>
                        </md-input-container>

                        <div>
                            <md-input-container class="md-block"   >
                                <label>Almacenes</label>
                                <md-autocomplete md-selected-item="autoCp.provSele.select"
                                                 info="Seleccione el proveedor del embarque"
                                                 required
                                                 ng-disabled="( session.isBlock )"
                                                 ng-click="$parent.toEditHead('prov_id', provSelect.id)"
                                                 id="prov_id"
                                                 skip-tab
                                                 md-search-text="autoCp.provSele.text"
                                                 md-auto-select="true"
                                                 md-items="item in $parent.provs | stringKey : autoCp.provSele.text : 'razon_social' "
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
                                    <md-not-found >
                                        No se encontro el proveedor {{searchProveedor}}. ¿Desea crearlo?
                                    </md-not-found>
                                </md-autocomplete>
                            </md-input-container>
                        </div>
                        <md-input-container class="md-block" >
                            <label>Descripcion</label>
                            <input  type="text" ng-model="prod.descripcion"  tabindex="-1" >
                        </md-input-container>
                    </div>

                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer crear  tarifa ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniCreatTariff" id="miniCreatTariff"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="CreatTariffCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <form  ng-click="form = 'head'" name="head" ng-class="{'focused':form== 'head'}" >
                        <div  id="head">
                            <div layout="row" class="form-row-head "  ng-class="{'form-row-head-select': form == 'head' }" style="margin-left: 12px;" >
                                <div class="titulo_formulario" flex>
                                    <div>
                                        Tarifa
                                    </div>
                                </div>
                            </div>
                            <div layout="column"   ng-class="{'form-row-head-select': form == 'head' ,'form-body-select':form == 'head'}" >
                                <div style="padding-left: 12px ; padding-right: 4px;" >
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50">
                                            <div layout="column" layout-align="center center">Vecimiento</div>
                                        </div>
                                        <md-input-container class="md-block" flex >
                                            <md-datepicker ng-model="model.vencimiento" style="margin-left: -12px;"
                                                           skip-tab
                                                           required
                                            ></md-datepicker >
                                        </md-input-container class="md-block" flex >
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50" >
                                            <div layout="column" layout-align="center center">T/T </div>
                                        </div>
                                        <md-input-container class="md-block rms" flex >
                                            <input  type="text" ng-model="model.dias_tt" decimal required >
                                        </md-input-container>
                                        <md-tooltip >Transito Terrestre</md-tooltip>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50">
                                            <div layout="column" layout-align="center center">Fregth Forwarder</div>
                                        </div>
                                        <md-input-container class="md-block" flex >
                                            <input ng-model="model.fregth_forwarder" required />
                                        </md-input-container>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50">
                                            <div layout="column" layout-align="center center">Naviera</div>
                                        </div>
                                        <md-input-container class="md-block" flex >
                                            <input ng-model="model.naviera" />
                                        </md-input-container>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50" >
                                            <div layout="column" layout-align="center center">Pais </div>
                                        </div>
                                        <md-input-container class="md-block" flex >
                                            <md-autocomplete md-selected-item="paisSelec"
                                                             info="Selecione el pais dela nueva tarifa"
                                                             required
                                                             skip-tab
                                                             md-search-text="pais_idText"
                                                             md-items="item in $parent.provSelec.direcciones | stringKey : pais_idText : 'short_name' "
                                                             md-item-text="item.short_name"
                                                             md-autoselect = "true"
                                                             md-no-asterisk
                                                             md-min-length="0"
                                                             md-no-cache="true"
                                                             md-select-on-match
                                                             md-selected-item-change="model.pais_id = paisSelec.id ;loadPorts(paisSelec);"
                                            >
                                                <md-item-template>
                                                    <span>{{item.short_name}}</span>
                                                </md-item-template>
                                            </md-autocomplete>
                                        </md-input-container>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50" >
                                            <div layout="column" layout-align="center center">Puerto </div>
                                        </div>
                                        <md-input-container class="md-block" flex  >
                                            <md-autocomplete md-selected-item="puertoSelect"
                                                             info="Selecione el pueto para la nueva tarifa"
                                                             required
                                                             skip-tab
                                                             md-search-text="puertoText"
                                                             md-items="item in puertos | stringKey : puertoText : 'Main_port_name' "
                                                             md-item-text="item.Main_port_name"
                                                             md-autoselect = "true"
                                                             md-no-asterisk
                                                             md-min-length="0"
                                                             md-no-cache="true"
                                                             md-selected-item-change="model.puerto_id = puertoSelect.id ;"
                                                             ng-disabled="paisSelec == null"

                                            >
                                                <md-item-template>
                                                    <span>{{item.Main_port_name}}</span>
                                                </md-item-template>
                                            </md-autocomplete>
                                        </md-input-container>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50" >
                                            <div layout="column" layout-align="center center">Moneda </div>
                                        </div>
                                        <md-input-container class="md-block"  flex>
                                            <md-autocomplete md-selected-item="monedaSelect"
                                                             info="Selecione la moneda par la tarifa"
                                                             required
                                                             skip-tab
                                                             md-search-text="monedaText"
                                                             md-auto-select="true"
                                                             md-items="item in monedas | stringKey : monedaText : 'nombre' "
                                                             md-item-text="item.nombre"
                                                             md-autoselect = "true"
                                                             md-no-asterisk
                                                             md-min-length="0"
                                                             md-no-cache="true"
                                                             md-select-on-match
                                                             md-selected-item-change="model.moneda_id = monedaSelect.id ;"

                                            >
                                                <md-item-templatess>
                                                    <span>{{item.nombre}}</span>
                                                </md-item-templatess>
                                            </md-autocomplete>
                                        </md-input-container>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <form  name="bond" ng-class="{'focused':form== 'bond'}" flex layout="column" ng-click="form = 'bond'" ng-class="{'form-row-head-select': form == 'bond' ,'form-body-select':form == 'bond'}">
                        <div layout="row" class="form-row-head " style="margin-left: 12px ;" ng-class="{'form-row-head-select': form == 'bond' ,'form-body-select':form == 'bond'}">
                            <div class="titulo_formulario" flex>
                                <div>
                                    Bondades
                                </div>
                            </div>
                        </div>

                        <div flex class="gridContent" layout="column" style="padding-right:4px"  ng-class="{'form-body-select':form == 'bond'}">
                            <div style="padding-left: 12px; height: 100%;" >

                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">GRT </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.grt"   decimal  >
                                    </md-input-container>
                                    <md-tooltip >GRT</md-tooltip>
                                </div>
                                <div layout="row" class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Documento </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.documento" decimal   >
                                    </md-input-container>
                                    <md-tooltip >Documento</md-tooltip>
                                </div>
                                <div layout="row" class="row"  >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Mensajeria </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.mensajeria"  decimal  >
                                    </md-input-container>
                                    <md-tooltip >Mensajeria</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Seguros </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.seguro" decimal   >
                                    </md-input-container>
                                    <md-tooltip >Seguros</md-tooltip>
                                </div>
                                <div layout="row" class="row"  >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Consodilacion </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.consolidacion"  decimal  >
                                    </md-input-container>
                                    <md-tooltip >Consolidacion</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">20'SD </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.sd20"  decimal  >
                                    </md-input-container>
                                    <md-tooltip >20' SD</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">40'SD </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.sd40"  decimal  >
                                    </md-input-container>
                                    <md-tooltip >40' SD</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">40'HC </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.hc40" decimal   >
                                    </md-input-container>
                                    <md-tooltip >40' HC</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">40'OT </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" ng-model="model.ot40"  decimal  >
                                    </md-input-container>
                                    <md-tooltip >40'OT</md-tooltip>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer detalle del  producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniDetailProductShipment" id="miniDetailProductShipment"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="DetailProductShipmentCtrl" style="padding-left: 12px" >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row" class="form-row-head form-row-head-select" >
                        <div class="titulo_formulario">
                            <div>
                                Detalle Producto
                            </div>
                        </div>
                    </div>

                    <form name="prod" flex class="gridContent" layout="column" style="padding-right:4px">

                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Asignado </div>
                            </div>

                            <md-input-container class="md-block rms" flex >
                                <input   id="input" type="text" ng-model="select.saldo" range minVal="0.1" maxVal="{{select.cantidad}}"   >
                            </md-input-container>

                            <md-tooltip >
                                Cantidad asignada al embarque
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cantidad </div>
                            <div class="rms" flex> {{select.cantidad}}</div>
                            <md-tooltip >
                                Cantidad Pedida
                            </md-tooltip>
                        </div>
                        <div layout="row" ng-show="select.precio">
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Precio </div>
                            <div class="rms" flex> {{select.precio}}</div>
                            <md-tooltip >
                               Precio de venta actual
                            </md-tooltip>
                        </div>
                        <div layout="row" ng-show="select.total">
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Total</div>
                            <div class="rms" flex> {{select.total}}</div>
                            <md-tooltip >
                               Total a pagar
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Disponible </div>
                            <div class="rms" flex> {{select.disponible}}</div>
                            <md-tooltip >
                                disponible para asignacion
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Codigo </div>
                            <div class="rms" flex> {{select.codigo}} </div>
                            <md-tooltip >
                                Codigo
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Fabrica </div>
                            <div class="rms" flex> {{select.codigo_profit}} </div>
                            <md-tooltip >
                                Codigo en profit
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Barra </div>
                            <div class="rms" flex> {{select.codigo_barra}} </div>
                            <md-tooltip >
                                Codigo de barra
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Descripcion </div>
                            <div class="rms" style="height: 240px; white-space: normal;" flex> {{select.descripcion}} </div>
                            <md-tooltip >
                                Codigo de fabrica
                            </md-tooltip>
                        </div>
                    </form>

                </div>
            </md-content>
        </md-sidenav>

        <!-- ########################################## LAYER Mensaje de notificacion########################################## -->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    class="md-sidenav-right md-whiteframe-2dp popUp"
                    md-disable-backdrop="true" md-component-id="moduleMsm" id="moduleMsm"



        >

            <md-content   layout="row" flex class="sideNavContent"  ng-controller="moduleMsmCtrl" >
                <div  layout="column" flex="" class="layerColumn"  click-out="close($event)" style="padding-left: 12px" >
                    <div layout="row" class="form-row-head form-row-head-select" >
                        <div class="titulo_formulario">
                            <div>
                                Mensajes
                            </div>
                        </div>
                    </div>
                    <form layout="row" >
                        <md-content flex  >
                            <div ng-repeat="item in $parent.alerts"  >
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