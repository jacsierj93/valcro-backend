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

            <div id="listado" flex  style="overflow-y:auto;"  >
                <div class="boxList"  layout="column" flex ng-repeat="item in search()  "  list-box ng-click="setProvedor(item, this)"
                     ng-class="{'listSel' : (item.id == provSelec.id)}"
                     id="prov{{item.id}}"
                     class="boxList"
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
                <!-- botonera left -->
                <div style="width: 240px;" layout="row">
                    <div layout="column" layout-align="center center"></div>

                    <div layout="column" ng-show="((module.index < 1 || module.layer == 'listShipment') && permit.created)" layout-align="center center" ng-click="OpenShipmentCtrl()">
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
                <div style="width: 48px;" layout="column"   layout-align="center center" id="noti-button" >
                    <div class="{{(alerts.length > 0 ) ? 'animation-arrow' : 'animation-arrow-disable'}}" ng-click="openNotis()" id="noti-button"
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
                        <div class="titulo_formulario" style="height: 39px;" flex>
                            <div>
                                <span style="color: #000;">Embarques</span>
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
                <div id="expand"></div>
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
                <div layout="column" flex>
                    <form layout="row">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Embarque
                                </div>
                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" flex  >
                                    <label>Proveedor</label>
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
                                <md-input-container class="md-block" flex="15">
                                    <label>N°</label>
                                    <input  ng-model="$parent.shipment.id"
                                            ng-disabled="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>
                            </div>
                            <div layout="row" class="row" >
                                <md-input-container flex>
                                    <label>Titulo</label>
                                    <input  ng-model="$parent.shipment.titulo"
                                            ng-change=" toEditHead('titulo', document.titulo ) "
                                            ng-disabled="( session.isblock )"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del documento"
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="20"  >
                                    <label>Pais</label>
                                    <md-autocomplete md-selected-item="autoCp.pais_id.select"
                                                     info="Selecione el pais de origen para el embarque"
                                                     required
                                                     ng-disabled="( session.isBlock )"
                                                     ng-click="$parent.toEditHead('pais_id', provSelect.id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="autoCp.pais_id.text"
                                                     md-auto-select="true"
                                                     md-items="item in $parent.paises | stringKey : autoCp.pais_id.text : 'short_name' "
                                                     md-item-text="item.razon_social"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
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
                                <md-input-container class="md-block" flex="20"  >
                                    <label>Puerto</label>
                                    <md-autocomplete md-selected-item="autoCp.puerto_id.select"
                                                     info="Selecione el pais de origen para el embarque"
                                                     required
                                                     ng-disabled="( session.isBlock )"
                                                     ng-click="$parent.toEditHead('pais_id', provSelect.id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="autoCp.pais_id.text"
                                                     md-auto-select="true"
                                                     md-items="item in $parent.puertos | stringKey : autoCp.puerto_id.text : 'main_port_name' "
                                                     md-item-text="item.razon_social"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
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

                                <md-input-container flex>
                                    <label>Freigth Forwarder</label>
                                    <input  ng-model="$parent.shipment.titulo"
                                            ng-change=" toEditHead('titulo', document.titulo ) "
                                            ng-disabled="( session.isblock )"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del documento"
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container flex>
                                    <label>Naviera</label>
                                    <input  ng-model="$parent.shipment.titulo"
                                            ng-change=" toEditHead('titulo', document.titulo ) "
                                            ng-disabled="( session.isblock )"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del documento"
                                            skip-tab
                                    >
                                </md-input-container>


                            </div>
                            <div layout="row" class="row" >
                                <div layout="row" class="date-row" flex="30" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Carga</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.carga"
                                                   ng-disabled="( session.isBlock )"
                                                   skip-tab
                                                   required
                                                   ng-change="toEditHead('fecha_aprob_compra', (document.fecha_aprob_compra) ? document.fecha_aprob_compra.toString(): undefined)"
                                    ></md-datepicker >

                                </div>
                                <div layout="row" class="date-row" flex="30" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En Venenzuela</div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <md-datepicker ng-model="$parent.shipment.fecha_llegada_vnz"
                                                       ng-disabled="( session.isBlock )"
                                                       skip-tab
                                                       required
                                                       ng-change="toEditHead('fecha_aprob_compra', (document.fecha_aprob_compra) ? document.fecha_aprob_compra.toString(): undefined)"
                                        ></md-datepicker >
                                    </div>
                                </div>
                                <div layout="row" class="date-row" flex="30" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En tienda</div>
                                    </div>
                                    <div class="md-block" layout="column" layout-align="center center" >
                                        <md-datepicker ng-model="$parent.shipment.$parent.shipment.fecha_llegada_tiend"
                                                       ng-disabled="( session.isBlock )"
                                                       skip-tab
                                                       required
                                                       ng-change="toEditHead('fecha_aprob_compra', (document.fecha_aprob_compra) ? document.fecha_aprob_compra.toString(): undefined)"
                                        ></md-datepicker >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form layout="row">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row">
                                <div class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Documentos
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" flex ng-click="$parent.miniMbl()" >
                                    <label>MBL</label>
                                    <input  ng-model="$parent.shipment.mbl"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div class="adj-box">
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">0 </div>
                                </div>
                                <md-input-container class="md-block" flex  ng-click="$parent.miniHbl()" >
                                    <label>HBL</label>
                                    <input  ng-model="$parent.shipment.hbl"
                                            ng-disabled="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">0 </div>

                                <md-input-container class="md-block" flex ng-click="$parent.miniExpAduana()" >
                                    <label>Exp. Aduanal</label>
                                    <input  ng-disabled="true"  ng-model="$parent.shipment.nro_exp_aduana"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">0 </div>

                            </div>
                        </div>
                    </form>

                    <form layout="row">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row">
                                <div layout="column" layout-align="center center" id="btnTariff"  style="width:24px;" ng-click="listTariffCtrl()">
                                    <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                </div>
                                <div class="titulo_formulario" style="height:39px;" >
                                    <div>
                                        Tarifa
                                    </div>
                                </div>
                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" >
                                    <label>Flete</label>
                                    <input  ng-model="$parent.shipment.monto"
                                            required
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" >
                                    <label>Terrestre</label>
                                    <input  ng-model="$parent.shipment.flete.monto_terreste"
                                            required
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" >
                                    <label>Nacionalizacion</label>
                                    <input  ng-model="$parent.shipment.flete.monto_nacionalizacion"
                                            required
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" >
                                    <label>DUA</label>
                                    <input  ng-model="$parent.shipment.flete.monto_dua"
                                            required
                                            skip-tab
                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <form layout="row" flex>
                        <div active-left  ></div>
                        <div flex layout="column" >
                            <div layout="row">
                                <div class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Agregados
                                    </div>
                                </div>
                            </div>
                            <div layout="row" flex>
                                <div flex layout="column" >
                                    <div layout="row" layout-align="start center">
                                        <div layout="column" layout-align="center center" id="btnAgrCp" ng-click="miniContainerCtrl()" style="width:24px;">
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>
                                        <div class="titulo_formulario" style="height:39px;">
                                            <div>
                                                Container
                                            </div>
                                        </div>

                                    </div>
                                    <div flex></div>
                                </div>
                                <div flex layout="column" >
                                    <div layout="row" layout-align="start center">
                                        <div layout="column" layout-align="center center" ng-click="listOrdershipment()" style="width:24px;">
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>
                                        <div class="titulo_formulario" style="height:39px;">
                                            <div>
                                                Pedidos
                                            </div>
                                        </div>

                                    </div>
                                    <div flex></div>

                                </div>
                                <div flex layout="column" >
                                    <div layout="row" layout-align="start center">
                                        <div layout="column" layout-align="center center" id="btnAgrCp" ng-click="listProductshipment()" style="width:24px;">
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>
                                        <div class="titulo_formulario" style="height:39px;">
                                            <div>
                                                Productos
                                            </div>
                                        </div>

                                    </div>
                                    <div flex></div>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </md-content>
        </md-sidenav>


        <!------------------------------------------- detalle de embarques creados ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="detailOrder" id="detailOrder"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "detailOrderShipmentCtrl" >
                <div layout="column" flex>
                    <form layout="row">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row" class="focused" style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                                <div layout="row" >
                                    <div class="titulo_formulario" style="height: 39px;" flex>
                                        <div>
                                            <span style="color: rgb(92, 183, 235);">Detalle de Pedido</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" flex  >
                                    <label>Titulo</label>
                                    <input  ng-model="$parent.shipment.mbl"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex  >
                                    <label>Estado</label>
                                    <input  ng-model="$parent.shipment.mbl"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado</div>
                                    </div>
                                    <div layout="column"  layout-align="center center">00-00-1192</div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Aprobacion</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>
                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <div  class="adj-box">
                                    <div  class="vlc-buttom" ng-class="{'ng-disable':Docsession.block}"  style="float:left">
                                        {{ (document.adjuntos | stringKey :'proforma' : 'documento' ).length || 0 }}
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Monto</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso(Kg)</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <div layout="column" flex>
                        <div layout="row" class="focused" >
                            <div active-left  ></div>
                            <div layout="row" >
                                <div class="titulo_formulario" style="height: 39px;" flex>
                                    <div>
                                        <span style="color: rgb(92, 183, 235);">Productos</span>
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
                                        <label>Asignado</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.nacionalizacion"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="nro_proforma"></grid-order-by>
                                </div>
                                <div style="width: 32px"></div>


                            </div>
                        </div>
                        <form layout="row"  class="gridContent" flex>
                            <div active-left  ></div>
                            <div layout="column" flex>
                                <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                    <div layout="row" class="cellGridHolder" ng-click="$parent.DetailProductShipment(item)" >
                                        <div flex class="cellGrid" >{{item.titulo}}</div>
                                        <div layout="column" layout-align="center center" style="width:32px;" >
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>

                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" flex>
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
                    <form layout="row">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row" class="focused" style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                                <div layout="row" >
                                    <div class="titulo_formulario" style="height: 39px;" flex>
                                        <div>
                                            <span style="color: rgb(92, 183, 235);">Detalle del pedido</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <md-input-container class="md-block" flex  >
                                    <label>Titulo</label>
                                    <input  ng-model="$parent.shipment.mbl"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex  >
                                    <label>Estado</label>
                                    <input  ng-model="$parent.shipment.mbl"
                                            ng-disabled="true"
                                    >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Creado</div>
                                    </div>
                                    <div layout="column"  layout-align="center center">00-00-1192</div>
                                </div>

                            </div>
                            <div layout="row" class="row" >
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Aprobacion</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>
                                <md-input-container class="md-block" flex >
                                    <label>N° Proforma:</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <div  class="adj-box">
                                    <div  class="vlc-buttom" ng-class="{'ng-disable':Docsession.block}"  style="float:left">
                                        {{ (document.adjuntos | stringKey :'proforma' : 'documento' ).length || 0 }}
                                    </div>
                                </div>

                                <md-input-container class="md-block" flex="10" >
                                    <label>Monto</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Peso(Kg)</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                                <md-input-container class="md-block" flex="10" >
                                    <label>Mt3</label>
                                    <input ng-model="document.nro_proforma"  ng-disabled="( true )"
                                           skip-tab

                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </form>
                    <div layout="column" flex>
                        <div layout="row" class="focused" >
                            <div active-left  ></div>
                            <div layout="row" >
                                <div class="titulo_formulario" style="height: 39px;" flex>
                                    <div>
                                        <span style="color: rgb(92, 183, 235);">Productos</span>
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
                                    <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>
                                </div>
                                <div style="width: 32px"></div>


                            </div>
                        </div>
                        <form layout="row"  class="gridContent" flex>
                            <div active-left  ></div>
                            <div layout="column" flex>
                                <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                    <div layout="row" class="cellGridHolder" ng-click="$parent.DetailProductShipment(item)" >
                                        <div flex class="cellGrid" >{{item.titulo}}</div>
                                        <div layout="column" layout-align="center center" style="width:32px;" >
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>

                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" flex>
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
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div class="titulo_formulario" style="height: 39px;" flex>
                            <div>
                                <span style="color: #000;">Tarifas</span>
                            </div>
                        </div>
                    </div>
                    <form layout="row" name="tariffF1">
                        <div active-left ></div>
                        <div layout="column" flex>
                            <div layout="row" class="row" style="overflow: hidden;">
                                <md-input-container class="md-block" flex="30" >
                                    <label>Origen</label>
                                    <md-autocomplete md-selected-item="autoCp.pais_id.select"
                                                     info="Selecione el pais de origen para el embarque"
                                                     required
                                                     ng-disabled="( session.isBlock )"
                                                     ng-click="$parent.toEditHead('pais_id', provSelect.id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="autoCp.pais_id.text"
                                                     md-auto-select="true"
                                                     md-items="item in $parent.paises | stringKey : autoCp.pais_id.text : 'short_name' "
                                                     md-item-text="item.razon_social"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
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
                        </div>
                    </form>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex layout="row" class="table-filter-head">

                                <md-input-container class="md-block"  flex>
                                    <label>T/T</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="emision"></grid-order-by>

                            </div>
                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>20' SD </label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_tiend"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_llegada_tiend"></grid-order-by>

                            </div>

                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>40' SD</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="flete"></grid-order-by>

                            </div>

                            <div flex layout="row" class="table-filter-head">
                                <md-input-container class="md-block"  flex>
                                    <label>40' HC</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nacionalizacion"></grid-order-by>
                            </div>

                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>40' OT</label>
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

                    </form>

                </div>

                <div layout="column" flex class="gridContent" style="margin:0">
                    <div class="titulo_formulario" style="height: 39px;" flex>
                        <div>
                            <span style="color: #000;">Bondades</span>
                        </div>
                    </div>
                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Freigth Fowarder</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>
                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Naviera</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>
                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Puerto</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row" >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">T/T</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">GRT</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row"flex >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Documento</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Mensajeria</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Seguros</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Consolidacion</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>

                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">20'SD</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>
                    <div layout="row"flex >
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">40'SD</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>
                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">40'HC</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
                        </md-tooltip>
                    </div>
                    <div layout="row" flex>
                        <div layout="row" flex="50" style="color: rgb(84, 180, 234);">40'OT</div>
                        <div class="rms" flex> demo</div>
                        <md-tooltip >
                            Compañia de traslado
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
                        <div layout="row" flex style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="color: #000;">Pedidos para Agregar</span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div>
                        <div layout="row">
                            <div active-left  ></div>
                            <div layout="row"  flex style="padding-right: 4px;">
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
                                               ng-model="tbl.filter.fecha_llegada_tiend"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="fecha_llegada_tiend"></grid-order-by>

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
                                               ng-model="tbl.filter.nacionalizacion"
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
                                    <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                                </div>
                                <div flex layout="row" class="table-filter-head" >
                                    <md-input-container class="md-block"  flex>
                                        <label></label>
                                        <md-select ng-model="tbl.filter.tipo"  skip-tab  >
                                            <md-option value="p">
                                                <div flex layout layout-align="center center">
                                                    <div layout layout-align="center center" >
                                                        p
                                                    </div>
                                                </div>
                                            </md-option>
                                            <md-option value="t">
                                                <div flex layout layout-align="center center">
                                                    <div layout layout-align="center center" >
                                                        t
                                                    </div>
                                                </div>
                                            </md-option>
                                        </md-select>
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                                </div>
                                <div style="width: 32px;"></div>

                            </div>
                        </div>
                        <form layout="row"  class="gridContent" flex>
                            <div active-left  ></div>
                            <div layout="column" flex>
                                <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                    <div layout="row" class="cellGridHolder" ng-click="$parent.detailOrderAdd(data)" >
                                        <div flex class="cellGrid" >{{item.titulo}}</div>
                                        <div layout="column" layout-align="center center" style="width:32px;" >
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>
                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" flex>
                                    No hay datos para mostrar
                                </div>
                                <!-- <div  style="position: absolute; top: 0;">
                                     <div> {{plusdata.data | json}}</div>
                                 </div>-->
                            </div>

                        </form>
                    </div>
                </div>

            </md-content>

        </md-sidenav>

        <!------------------------------------------- lista de pedidos agregados------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listOrdershipment" id="listOrdershipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listOrdershipmentCtrl" >
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">

                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="color: #000;">Pedidos Agregados</span>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-click="$parent.listOrderAdd()" style="width:24px;">
                                <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                            </div>
                        </div>

                    </div>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
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
                                           ng-model="tbl.filter.fecha_llegada_tiend"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_llegada_tiend"></grid-order-by>

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
                                           ng-model="tbl.filter.nacionalizacion"
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
                                <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label></label>
                                    <md-select ng-model="tbl.filter.tipo"  skip-tab  >
                                        <md-option value="p">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" >
                                                    p
                                                </div>
                                            </div>
                                        </md-option>
                                        <md-option value="t">
                                            <div flex layout layout-align="center center">
                                                <div layout layout-align="center center" >
                                                    t
                                                </div>
                                            </div>
                                        </md-option>
                                    </md-select>
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="mt3"></grid-order-by>
                            </div>

                            <!--                            <div style="width: 32px;"></div>
                            -->                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder"  >
                                    <div flex class="cellGrid" ng-click="$parent.detailOrderShipment(item)">{{item.titulo}}</div>

                                    <!--                                    <div layout="column" layout-align="center center" style="width:32px;" ng-mouseenter="showplusData($event,data)" ng-mouseleave="showplusData()">
                                                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                                                        </div>
                                    -->                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex>
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
                        <div layout="row" flex style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="color: #000;">Productos agregados</span>
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
                    <div>
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
                        <form layout="row"  class="gridContent" flex>
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

                        </form>
                    </div>
                </div>
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div layout="row" flex  class="mini-content-title">

                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="color: #000;">Detalle de Producto</span>
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
                        <div layout="row" flex>
                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="color: #000;">Productos por culminar</span>
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
                            <div style="width: 32px"> </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" >{{item.titulo}}</div>
                                    <div layout="column"  layout-align="center center" class="cellGrid cellEmpty" style="width: 32px;" ng-click="$parent.historyProduct(item)"><div> H</div></div>
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

        <!------------------------------------------- mini layer historial de producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniHistoryProd" id="miniHistoryProd"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="historyProductCtrl"    >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)" style="padding-left: 12px">
                    <div layout="row"  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;" >
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
                        <form layout="column" flex="">
                            <div layout="row"  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                                <div class="titulo_formulario">
                                    <div>
                                        Master bill landing
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <md-input-container class="md-block" >
                                    <label>N°</label>
                                    <input  type="text" ng-model="prod.cod_barra"  tabindex="-1" >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Emitido</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>

                            </div>

                            <div flex class="gridContent" ng-show="dataadjs.length">

                            </div>
                            <div layout="column" layout-align="center center" flex>
                                No hay adjuntos cargados
                            </div>

                        </form>
                    </div>
                    <div>
                        <div layout="row" layout-align="center space-between" style="border: 1px solid rgb(84, 180, 234);"
                             ngf-drop ngf-select  ng-model="answerfiles"
                             ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="AnswerfileInput"

                        >
                            <div  class="vlc-buttom" style="margin-top: 0; background-color: rgb(84, 180, 234); ">{{adjs.length}}</div>
                            <div flex layout-align=" center start " layout="column">Adjuntos</div>
                            <div style="width: 16px"  layout-align=" center left " layout="column"></div>
                        </div>
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
                        <form layout="column" flex="">
                            <div layout="row"  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                                <div class="titulo_formulario">
                                    <div>
                                        House bill landing
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <md-input-container class="md-block" >
                                    <label>N°</label>
                                    <input  type="text" ng-model="prod.cod_barra"  tabindex="-1" >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Emitido</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>

                            </div>

                            <div flex class="gridContent" ng-show="dataadjs.length">

                            </div>
                            <div layout="column" layout-align="center center" flex>
                                No hay adjuntos cargados
                            </div>

                        </form>
                    </div>
                    <div>
                        <div layout="row" layout-align="center space-between" style="border: 1px solid rgb(84, 180, 234);"
                             ngf-drop ngf-select  ng-model="answerfiles"
                             ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="AnswerfileInput"

                        >
                            <div  class="vlc-buttom" style="margin-top: 0; background-color: rgb(84, 180, 234); ">{{adjs.length}}</div>
                            <div flex layout-align=" center start " layout="column">Adjuntos</div>
                            <div style="width: 16px"  layout-align=" center left " layout="column"></div>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer house bill landing------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniExpAduana" id="miniExpAduana"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniExpAduanaCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div  layout="column" flex style="padding-left: 12px">
                        <form layout="column" flex="">
                            <div layout="row"  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                                <div class="titulo_formulario">
                                    <div>
                                        Expediante de aduana
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <md-input-container class="md-block" >
                                    <label>N°</label>
                                    <input  type="text" ng-model="prod.cod_barra"  tabindex="-1" >
                                </md-input-container>
                                <div layout="row" class="date-row" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>Emitido</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.emision"
                                                   ng-disabled="true"
                                                   skip-tab
                                                   required
                                    ></md-datepicker >
                                </div>

                            </div>

                            <div flex class="gridContent" ng-show="data.djs.length">

                            </div>
                            <div layout="column" layout-align="center center" flex>
                                No hay adjuntos cargados
                            </div>

                        </form>
                    </div>
                    <div>
                        <div layout="row" layout-align="center space-between" style="border: 1px solid rgb(84, 180, 234);"
                             ngf-drop ngf-select  ng-model="answerfiles"
                             ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="AnswerfileInput"

                        >
                            <div  class="vlc-buttom" style="margin-top: 0; background-color: rgb(84, 180, 234); ">{{adjs.length}}</div>
                            <div flex layout-align=" center start " layout="column">Adjuntos</div>
                            <div style="width: 16px"  layout-align=" center left " layout="column"></div>
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>

        <!------------------------------------------- mini layer agregar container ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniContainer" id="miniContainer"
        >
            <md-content   layout="row" flex class="sideNavContent" ng-controller="miniContainerCtrl"    >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <form layout="row" layout-align="start center" class="focused">
                        <div class="titulo_formulario" style="height:39px;">
                            <div>
                                Containers
                            </div>
                        </div>


                    </form>
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
                            <label>Peso</label>
                            <input  ng-model="container.peso" skip-tab
                            >
                        </md-input-container>

                        <md-input-container flex>
                            <label>volumen</label>
                            <input  ng-model="container.volumen" skip-tab
                            >
                        </md-input-container>
                        <md-input-container flex>
                            <label>Cantidad</label>
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

        <!------------------------------------------- mini layer crear  producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniCreatProduct" id="miniCreatProduct"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="CreatProductCtrl" style="padding-left: 12px" >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row"  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
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

        <!------------------------------------------- mini layer crear  producto ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniDetailProductShipment" id="miniDetailProductShipment"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="DetailProductShipmentCtrl" style="padding-left: 12px" >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div layout="row"  style="border-bottom: solid 1.5px rgb(92, 183, 235);height: 33px;">
                        <div class="titulo_formulario">
                            <div>
                                Detalle Producto
                            </div>
                        </div>
                    </div>

                    <div flex class="gridContent" layout="column" style="padding-right:4px">

                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">
                                <div layout="column" layout-align="center center">Asignado </div>
                            </div>

                            <md-input-container class="md-block rms" flex >
                                <input  type="text" ng-model="prod.asigado"  tabindex="-1" >
                            </md-input-container>

                            <md-tooltip >
                                Cantidad asignada al embarque
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cantidad </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Cantidad en el pedido
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Codigo </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Codigo
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Profit </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Codigo en profit
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Barra </div>
                            <div class="rms" flex> demo</div>
                            <md-tooltip >
                                Codigo de barra
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Descripcion </div>
                            <div class="rms" style="height: 240px; white-space: normal;" flex> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan, velit a imperdiet commodo, arcu ex mollis justo, vel venenatis justo leo eget dui. Morbi congue augue vitae dui consequat.</div>
                            <md-tooltip >
                                Codigo de fabrica
                            </md-tooltip>
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
            ng-mouseleave="showNext(false)" ng-click="next()" click-out="showNext(false)">
            <?= HTML::image("images/btn_nextArrow.png") ?>
        </md-sidenav>

        <!------------------------------------------- Alertas ------------------------------------------------>
        <div ng-controller="notificaciones" ng-include="template"></div>
        <!------------------------------------------- files ------------------------------------------------>

        <div ng-controller="FilesController" ng-include="template"></div>

    </div>

</div>