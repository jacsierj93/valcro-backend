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
                                <gridOrder ng-model="tbl" key="id"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="id"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>N°</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.id"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="nro_factura"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>N° Factura</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="emision"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>Carga</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="fecha_llegada_vnz"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>En venezuela el</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_vnz"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="fecha_llegada_tiend"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>En tienda el </label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_tiend"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="flete"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>Flete</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div flex layout="row">
                                <gridOrder ng-model="tbl" key="nacionalizacion"></gridOrder>
                                <md-input-container class="md-block"  flex>
                                    <label>Nacionalizacion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nacionalizacion"
                                           skip-tab
                                    >
                                </md-input-container>
                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data "   id="shipments{{$index}}"  >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.id}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.carga}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.fecha_llegada_vnz}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.fecha_llegada_tiend}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.flete}}</div>
                                    <div flex class="cellGrid" ng-click="setShipment(data)">{{data.nacionalizacion}}</div>
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

        <!------------------------------------------- lista de embarques creados ------------------------------------------------------------------------->
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
                        <div flex> {{$parent.shipment.titulo }}</div>
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