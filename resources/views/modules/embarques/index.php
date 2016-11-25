<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="embarquesController" global >
    <div class="contentHolder" layout="row" flex>
        <div class="barraLateral" layout="column" id="barraLateral" >
            <div layout="row" class="md-whiteframe-1dp" >
                <div id="menu" layout="column"  style="height: 48px; overflow: hidden; background-color: #f1f1f1;
             min-height: 48px;">
                    <!-- 3) ########################################## MENU ########################################## -->
                    <div class="menu" style="min-height: 48px; width: 100%;padding-left: 0;" >
                        <div style="text-align: center; padding-top: 8px; height: 16px;" ng-click=" ">
                            <div layout="row" layout-align="center center" ng-click="(list == 'provider') ? list = 'country' : list = 'provider'  ">
                                {{(list== 'provider' ? 'Proveedores' : 'Paises')}}
                            </div>
                            <md-tooltip md-direction="right">
                                Para cambiar de vista
                            </md-tooltip>
                        </div>
                        <div style="; height: 24px; text-align: center;"
                             ng-click="FilterLateral()" ng-hide="showLateralFilter">
                            <img ng-src="images/Down.png">
                            <md-tooltip md-direction="right">
                                Ver filtros
                            </md-tooltip>
                        </div>

                    </div>


                    <div layout="column" flex=""   style="padding: 0px 4px 0px 4px;" tabindex="-1">
                        <div  tabindex="-1" flex  ng-show="list == 'provider'">
                            <form name="provdiderFilter" tabindex="-1">
                                <div class="menuFilter" id="expand1" style="height: 176px;" layout-align="start start" tabindex="-1">
                                    <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                        <label>Razon  Social</label>
                                        <input  type="text" ng-model="filterProv.razon_social"  tabindex="-1" >

                                    </md-input-container>
                                    <div layout="column" style="height: 28px;" class="layout-column"></div>
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
                        </div>

                        <div  tabindex="-1" flex  ng-show="list == 'country'">
                            <form name="country" tabindex="-1">
                                <div class="menuFilter" id="expand1" style="height: 176px;" layout-align="start start" tabindex="-1">
                                    <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                        <label>Nombre</label>
                                        <input  type="text" ng-model="filterCountry.short_name"  tabindex="-1" >

                                    </md-input-container>
                                    <div layout="column" style="height: 28px;" class="layout-column"></div>
                                    <div layout="row" class="dotRow" style="height: 24px;">
                                        <div flex layout layout-align="center center" ng-click="filterCountry.f100 = !filterCountry.f100  ">
                                            <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterCountry.f100 ,'dot-filter100':!filterCountry.f100}" >
                                                +
                                            </div>
                                        </div>
                                        <div flex layout layout-align="center center"  ng-click="filterCountry.f90 = !filterCountry.f90  ">
                                            <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterCountry.f90 ,'dot-filter90':!filterCountry.f90}" >
                                                90
                                            </div>
                                        </div>
                                        <div flex layout layout-align="center center"  ng-click="filterCountry.f60 = !filterCountry.f60  ">
                                            <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterCountry.f60 ,'dot-filter60':!filterCountry.f60}">
                                                60
                                            </div>
                                        </div>
                                        <div flex layout layout-align="center center"  ng-click="filterCountry.f30 = !filterCountry.f30  " >
                                            <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterCountry.f30 ,'dot-filter30':!filterCountry.f30}">
                                                30
                                            </div>
                                        </div>
                                        <div flex layout layout-align="center center"  ng-click="filterCountry.f7 = !filterCountry.f7  " >
                                            <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterCountry.f7 ,'dot-filter7':!filterCountry.f7}" >
                                                7
                                            </div>
                                        </div>
                                        <div flex layout layout-align="center center"  ng-click="filterCountry.f0 = !filterCountry.f0  " >
                                            <div layout layout-align="center center" class="dot-item " ng-class= "{'dot-select' : filterCountry.f0 ,'dot-filter0':!filterCountry.f0}">
                                                0
                                            </div>
                                        </div>
                                    </div>
                                    <div style="height:48px; padding-right: 16px;" layout="row" layout-align="space-between center">
                                        <div flex="" style="overflow: hidden;" layout="row" ng-init="filterCountry.op = '+'">
                                            <div  style="width: 16px;" layout="column" layout-align="center center" ng-click="filterCountry.op = (filterCountry.op == '+') ? '-' : '+' " >
                                                <img ng-src="{{(filterCountry.op == '+') ? 'images/TrianguloUp.png' : 'images/TrianguloDown.png' }}" >
                                                <!-- <span  style="font-size: 24px"  >  {{filterProv.op }} </span>-->
                                            </div>
                                            <md-input-container class="md-block" flex >
                                                <label>Monto</label>
                                                <input  type="text" ng-model="filterCountry.monto"   >
                                            </md-input-container>
                                        </div>

                                        <div flex="20" layout="row"  layout-align="center center" ng-click="filterCountry.pc = !filterCountry.pc" >
                                            <div layout="column" layout-align="center center" >
                                                <span class="icon-PuntoCompra" style="font-size: 24px"  ng-class= "{'item-select' : filterCountry.pc ,'item-no-select':!filterCountry.pc}"></span>
                                            </div>
                                        </div>
                                        <div flex="20" layout="row"  layout-align="center center" ng-click="filterCountry.cp = !filterCountry.cp" >
                                            <div layout="column" layout-align="center center" >
                                                <span class="icon-Contrapedidos" style="font-size: 24px"  ng-class= "{'item-select' : filterCountry.cp ,'item-no-select':!filterCountry.cp}"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div style="width: calc(100% - 16px); height: 24px; text-align: center;"
                             ng-click="FilterLateral()" ng-hide="!showLateralFilter">
                            <img ng-src="images/Down.png">
                            <md-tooltip md-direction="right">
                                Click para desplegar opciones
                            </md-tooltip>
                        </div>
                    </div>
                </div>
            </div>


            <div id="listado" flex  style="overflow-y:auto;word-break: break-all;"  ng-show="list == 'provider'">
                <div class="boxList"  layout="column" flex ng-repeat="item in search() as provFilter "  list-box ng-click="setProvedor(item, $event)"
                     ng-class="{'listSel' : (item.id == provSelec.id)}"
                     id="prov{{item.id}}"
                     class="boxList"
                >

                    <div  style="overflow: hidden; text-overflow: ellipsis;word-break: break-all;" flex>{{item.razon_social}}</div>
                    <div layout="column" style="height: 54px;">
                        <div style="font-size:14px;"  id="dot-show{{item.id}}" layout="column" flex ng-show="item.show">
                            <spand layout="row" >{{item.text}}</spand>
                            <div layout="row" style="font-size:12px;">
                                <div flex="70"  >En tienda: </div>
                                <div flex class="text{{item.dias}}">{{item.emit}}</div>
                            </div>

                            <div layout="row" style="font-size:12px;" >
                                <div flex="70" >Revisados: </div>
                                <div style=" font-weight: bolder !important;" flex class="text{{item.dias}}">{{item.review}}</div>
                            </div>
                        </div>
                    </div>
                    <div layout="row" class="dotRow">
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.dot1,item.review100,100)">
                            <div layout layout-align="center center" class="dot-item emit100" >
                                {{item.dot1}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.dot2,item.review90,90)">
                            <div layout layout-align="center center" class="dot-item emit90" >
                                {{item.dot2}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.dot3,item.review60,60)">
                            <div layout layout-align="center center" class="dot-item emit60">
                                {{item.dot3}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.dot4,item.review30,30)">
                            <div layout layout-align="center center" class="dot-item emit30" >
                                {{item.dot4}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.dot5,item.review7,7)">
                            <div layout layout-align="center center" class="dot-item emit7" >
                                {{item.dot5}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.dot6,item.review0,0)">
                            <div layout layout-align="center center" class="dot-item emit0">
                                {{item.dot6}}
                            </div>
                        </div>
                    </div>

                    <div style="height:40px;" layout="row" layout-align="space-between center">
                        <div flex="" style="overflow: hidden; margin-right: 1px;white-space: nowrap;">{{item.deuda| number:2}}</div>

                        <div flex="30" layout="row" style="height: 19px;white-space: nowrap;" layout-align="end center" >
                            <div >{{item.puntoCompra}}</div>
                            <img  style="float: left;" src="images/punto_compra.png"/>
                        </div>
                        <div flex="30" layout="row"  layout-align="end center" style="height: 19px;white-space: nowrap;" >
                            <div >{{item.contraPedido}}</div>
                            <img  style="float: left;" src="images/contra_pedido.png"/>
                        </div>
                    </div>

                </div>
            </div>

            <div id="listado" flex  style="overflow-y:auto;word-break: break-all;" ng-show="list == 'country'"  >
                <div class="boxList"  layout="column" flex ng-repeat="item in searchCountry() as countryFilter"  list-box
                     class="boxList" ng-click="setPais(item)" ng-class="{'listSel' : (item.id == paisSelec.id)}"
                >

                    <div  style="overflow: hidden; text-overflow: ellipsis;word-break: break-all;" flex>{{item.short_name}}</div>
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
                                {{item.dot1}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit90,item.review90,90)">
                            <div layout layout-align="center center" class="dot-item emit90" >
                                {{item.dot2}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) "ng-mouseenter = "showDotData(item,item.emit60,item.review60,60)">
                            <div layout layout-align="center center" class="dot-item emit60">
                                {{item.dot3}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit30,item.review30,30)">
                            <div layout layout-align="center center" class="dot-item emit30" >
                                {{item.dot4}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit7,item.review7,7)">
                            <div layout layout-align="center center" class="dot-item emit7" >
                                {{item.dot5}}
                            </div>
                        </div>
                        <div flex layout layout-align="center center"  ng-mouseleave ="showDotData(item) " ng-mouseenter = "showDotData(item,item.emit0,item.review0,0)">
                            <div layout layout-align="center center" class="dot-item emit0">
                                {{item.dot6}}
                            </div>
                        </div>
                    </div>

                    <div style="height:40px;" layout="row" layout-align="space-between center">
                        <div flex="" style="overflow: hidden; margin-right: 1px;">{{item.deuda| number:2}}</div>

                        <div flex="30" layout="row" style="height: 19px;" layout-align="end center" >
                            <div >{{item.puntoCompra}}</div>
                            <img  style="float: left;" src="images/punto_compra.png"/>
                        </div>
                        <div flex="30" layout="row"  layout-align="end center" style="height: 19px;" >
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
                <div  layout="row" layout-align="start center" style="width: 200px;">
                    <div layout="column" layout-align="center center" ng-click = " progreso.index = (progreso.index == 3) ? 0 : 3 ;"> </div>

                    <div layout="column" ng-show="((module.index < 1 || module.layer == 'listShipment') && permit.created)" layout-align="center center" ng-click="OpenShipmentCtrl()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Nuevo Embarque
                        </md-tooltip>
                    </div>
                    <div layout="column" ng-show="!shipment.id" layout-align="center center" ng-click="listGlobalTarif()">
                        < <img src="images/solicitud_icon_48x48.gif">
                        <md-tooltip >
                           Tarifas
                        </md-tooltip>
                    </div>

                    <div layout="column" ng-show="(module.layer == 'listOrdershipment')" layout-align="center center" ng-click="listOrderAdd()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Agregar pedido
                        </md-tooltip>
                    </div>
                    <div layout="column" ng-show="(module.layer == 'listTariff')" layout-align="center center" ng-click="CreatTariff()">
                        <span class="icon-Agregar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Nueva tarifa
                        </md-tooltip>
                    </div>

                    <div layout="column" ng-show="module.layer == 'summaryShipment'" layout-align="center center" ng-click="OpenShipmentCtrl(shipment);unblock({id:shipment.id})">
                        <span class="icon-Actualizar" style="font-size: 24px"></span>
                        <md-tooltip >
                            Actualizar
                        </md-tooltip>
                    </div>

                    <div layout="column" layout-align="center center" ng-click="miniCancelShipment()" ng-show="shipment.id" >
                        <img src="images/CancelarDocumento.png">
                        <md-tooltip >
                            Cancelar embarque
                        </md-tooltip>
                    </div>
                    <div ng-controller="superAprobCtrl" layout="column" layout-align="center center" ng-click="aprob()" ng-show="shipment.id"  ng-class="{'blue':'shipment.aprob_superior'}" >
                        <span class="icon-checkMark" style="font-size: 24px"></span>
                        <md-tooltip >
                            Aprobar embarque
                        </md-tooltip>
                    </div>

                    <!-- <div layout="column" layout-align="center center" ng-click="test()">
                        <span  style="font-size: 24px">tss</span>
                        <md-tooltip >
                          test
                        </md-tooltip>
                    </div>-->

                </div>

                <!-- botonera center -->
                <vl-progress ng-model="progreso.data" vl-index="progreso.index" ></vl-progress>
                <!-- botonera rigth -->
                <div layout="row"  layout-align="end center " >
                    <div style="width: 48px;" layout="column"   layout-align="center center" id="noti-button" ng-show= "module.index == 0">
                        <div class="{{(alerts.length > 0 ) ? 'animation-arrow' : 'animation-arrow-disable'}}" ng-click="moduleMsmCtrl()" id="noti-button"
                             layout="column" layout-align="center center"  style=text-align:center; >
                            <img ng-src="images/btn_prevArrow.png" style="width: 14px;margin-top: 8px;" />
                        </div>
                        <md-tooltip>
                            {{alerts.length > 0 ? 'Tiene notificaciones pendiente por revisar, haz click aqui para verlas' : 'Sin Notificaciones por revisar, gracias por estar pendiente '}}
                        </md-tooltip>
                    </div>
<!--                    <div layout="column" layout-align="center center" >
                        <div layout="column" layout-align="center center"  style="background-color: rgb(92, 183, 235);color: white;" >
                        <span class="icon-checkMark" style="font-size: 24px"></span>
                        <md-tooltip >
                           Aprobar
                        </md-tooltip>
                        </div>
                    </div>
                    <div layout="column" layout-align="center center" >
                        <div layout="column" layout-align="center center"  style="background-color: rgb(232, 129, 0);color: white;" >
                            <span class="icon-checkMark" style="font-size: 24px"></span>
                            <md-tooltip >
                                Aprobado
                            </md-tooltip>
                        </div>
                    </div>-->
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
                        <div active-left  before="$parent.layerExit"   ></div>
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
                                    <label>Carga</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_carga"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>En venezuela el</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_vnz"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_vnz"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>En  tienda</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_tienda"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_tienda"></grid-order-by>

                            </div>


                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Flete</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete_tt"
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
                        <div active-left before="$parent.layerExit"  ></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict | orderBy : tbl.order as filter"    >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.nro_factura}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)"> <div class=" date {{'green'+item.catfecha_carga}}">{{item.fecha_carga |  date:'dd/MM/yyyy' }}</div></div>
                                    <div flex class="cellGrid" ng-click="setData(item)"><div  class="date {{'green'+item.catfecha_vnz}}" >{{item.fecha_vnz | date:'dd/MM/yyyy'}}</div></div>
                                    <div flex class="cellGrid" ng-click="setData(item)"><div  class="date {{'green'+item.catfecha_tienda}}">{{item.fecha_tienda| date:'dd/MM/yyyy'}}</div></div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.flete_tt}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.nacionalizacion}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="filter == 0">
                                No hay datos para mostrar
                            </div>
                        </div>
                    </form>

                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- lista tarifas globales ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listGlobalTarif" id="listGlobalTarif"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listGlobalTarifCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario"  flex>
                                <div>
                                    <span >Tarifas Cargadas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left  before="$parent.layerExit"   ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div  layout="row" style="width: 98px;">
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
                                    <label>Titulo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Comentario</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>

                            </div>
                            <div layout="row" style="width: 200px;">
                                <md-input-container class="md-block"  flex>
                                    <label>Creada</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_carga"></grid-order-by>

                            </div>

                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left before="$parent.layerExit"  ></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict | orderBy : tbl.order as filter"    >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.comentario}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.created_at}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="filter == 0">
                                No hay datos para mostrar
                            </div>
                        </div>
                    </form>

                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- detalle de documento de tarifa ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="detailGlobalTarif" id="detailGlobalTarif"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "detailGlobalTarifCtrl" >
                <div layout="column" flex>
                    <form layout="row" class="focused">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row" >
                                <div layout="row"  class="form-row-head form-row-head-select" flex >
                                    <div class="titulo_formulario"  flex>
                                        <div>
                                            <div >Detalle de Tarifas</div>
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

                            </div>
                        </div>
                    </form>
                    <div layout="row" flex >
                        <div active-left  ></div>
                        <div layout="column" flex style="overflow: auto;">
                            <div layout="row" >
                                <div style="min-width: 254px;" layout="row" class="table-filter-head" >
                                    <md-input-container class="md-block" flex >
                                        <label>Freigth Forwarder</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.freigth_forwarder_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="freigth_forwarder_id"></grid-order-by>
                                </div>
                                <div style="min-width: 254px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Naviera</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.naviera_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="naviera_id"></grid-order-by>
                                </div>
                                <div style="min-width: 254px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Puerto</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.puerto_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="puerto_ide"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>T/T</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.dias_tt"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="dias_tt"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>D/L</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.dl"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="dl"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>GRT</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.grt"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="grt"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Documento</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.documento"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="documento"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Mensajeria</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.mensajeria"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="mensajeria"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Seguros</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.mensajeria"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="seguros"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Consolidacion</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.consolidacion"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="seguros"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>20' SD </label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.sd20"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="sd20"></grid-order-by>

                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>40' SD</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.sd40"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="sd40"></grid-order-by>

                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>40' HC</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.hc40"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="hc40"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head" >
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

                            <div layout="column" flex id="resss" style="width: 1884px;overflow-y: auto;">
                                <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict as filter "   id="row{{$index}}" ng-click="setData(item)" >
                                    <div layout="row" class="cellGridHolder" ng-class="{'table-row-select':(tarifaSelect.id == item.id)}" style="width: 1884px;">
                                        <div style="width: 250px; min-width: 250px; " class="cellGrid" >{{item.objs.freight_forwarder_id.nombre}}</div>
                                        <div style="width: 250px;min-width: 250px;  " class="cellGrid" >{{item.objs.naviera_id.nombre}}</div>
                                        <div style="width: 250px;min-width: 250px;  " class="cellGrid" >{{item.objs.puerto_id.Main_port_name}}</div>
                                        <div style="width: 98px;min-width: 98px; " class="cellGrid" >{{item.dias_tt}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.dl}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.grt}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid">{{item.sd20}}</div>
                                        <div style="width: 98px;min-width: 98px;  " class="cellGrid" >{{item.sd40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid">{{item.hc40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" ng-show="filter.length == 0" flex>
                                    No hay datos para mostrar
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <!------------------------------------------- lista de embarques sin culminar ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="listShipmentUncloset" id="listShipmentUncloset"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "listShipmentUnclosetCtrl">
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left before="$parent.layerExit" ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >Embarques sin culminar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left  ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex="10" layout="row">
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
                            <div style="width: 128px;"v layout="row">
                                <md-input-container class="md-block"  >
                                    <label>Carga</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_carga"></grid-order-by>

                            </div>
                            <div style="width: 128px;" layout="row">
                                <md-input-container class="md-block"  >
                                    <label>En venezuela el</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_llegada_vnz"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_vnz"></grid-order-by>

                            </div>

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
                                <grid-order-by ng-model="tbl" key="flete_nac"></grid-order-by>

                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict as filter track by $index "     >
                                <div layout="row" class="cellGridHolder" >
                                    <div flex="10" class="cellGrid" ng-click="setData(item)">{{item.id}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.nro_factura}}</div>
                                    <div style="width: 128px;" class="cellGrid" ng-click="setData(item)">{{item.fecha_carga | date :'dd/MM/yyyy'}}</div>
                                    <div style="width: 128px;" class="cellGrid" ng-click="setData(item)">{{item.fecha_vnz | date :'dd/MM/yyyy'}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.titulo}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.flete_tt}}</div>
                                    <div flex class="cellGrid" ng-click="setData(item)">{{item.flete_nac}}</div>
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

        <!------------------------------------------- resumen de embarque de embarques creado ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="summaryShipment" id="summaryShipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "summaryShipmentCtrl" >
                <div active-left before="$parent.layerExit" ></div>
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
                                <div class="rms" flex> {{($parent.shipment.objs.pais_id.short_name)? $parent.shipment.objs.pais_id.short_name: 'No asignado'}}</div>
                                <md-tooltip >
                                    Pais de origen del embarque
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Puerto</div>
                                <div class="rms" flex> {{($parent.shipment.objs.puerto_id.Main_port_name)? $parent.shipment.objs.puerto_id.Main_port_name:'No asignado'}}</div>
                                <md-tooltip >
                                    Puerto de origen del embarque
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Freigth Fowarder</div>
                                <div class="rms" flex> {{($parent.shipment.objs.tarifa_id.freight_forwarder.nombre)? $parent.shipment.objs.tarifa_id.freight_forwarder.nombre : 'No asignado'}}</div>
                                <md-tooltip >
                                    Compañia de traslado
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Naviera</div>
                                <div class="rms" flex> {{($parent.shipment.objs.tarifa_id.naviera.nombre) ? $parent.shipment.objs.tarifa_id.naviera.nombre : 'No asignado'}}</div>
                                <md-tooltip >
                                    Compañia de embarcacion
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Carga el</div>
                                <div class="rms" flex> {{($parent.shipment.fechas.fecha_carga.value)? ($parent.shipment.fechas.fecha_carga.value| date :'dd/MM/yyyy') : 'No asignada' }}</div>
                                <md-tooltip >
                                    fecha de carga
                                </md-tooltip>
                            </div>

                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">En Venezuela</div>
                                <div class="rms" flex> {{($parent.shipment.fechas.fecha_vnz.value)? ($parent.shipment.fechas.fecha_vnz.value | date :'dd/MM/yyyy') : 'No asignado'}}</div>
                                <md-tooltip >
                                    fecha de llegada a venezuela
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">En tienda</div>
                                <div class="rms" flex> {{($parent.shipment.fechas.fecha_tienda.value)?($parent.shipment.fechas.fecha_tienda.value | date :'dd/MM/yyyy'):'No asignado'}}</div>
                                <md-tooltip >
                                    fecha de llegada a la tienda
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">N° MBL</div>
                                <div class="rms" flex> {{($parent.$parent.shipment.nro_mbl.documento) ? $parent.shipment.nro_mbl: 'No asignado'}}</div>
                                <md-tooltip >
                                    N° 'Master bill landig'
                                </md-tooltip>
                            </div>

                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">N° HBL</div>
                                <div class="rms" flex> {{($parent.shipment.nro_hbl.documento)? $parent.shipment.nro_hbl.documento : 'No asignado'}}</div>
                                <md-tooltip >
                                    N° 'House Bill of Lading'
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Exp. Aduana</div>
                                <div class="rms" flex> {{($parent.shipment.nro_eaa.documento)? $parent.shipment.nro_eaa.documento :'No asignado'}}</div>
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
                                <div class="rms" flex> {{($parent.shipment.flete_tt)? $parent.shipment.flete_tt:'No asignado' }}</div>
                                <md-tooltip >
                                    Monto a pagar flete terrestre
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Maritimo</div>
                                <div class="rms" flex> {{($parent.shipment.flete_mrt) ? $parent.shipment.flete_mrt :'No asignado' }}</div>
                                <md-tooltip >
                                    Monto a pagar flete maritimo
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">Nacionalizacion</div>
                                <div class="rms" flex> {{($parent.shipment.nacionalizacion)?  $parent.shipment.nacionalizacion:'No asignado'}}</div>
                                <md-tooltip >
                                    Monto a pagar Nacionalizacion
                                </md-tooltip>
                            </div>
                            <div layout="row"  class="rowRsm">
                                <div layout="row" flex="50">DUA</div>
                                <div class="rms" flex> {{($parent.shipment.dua) ? $parent.shipment.dua : 'No asignado'}}</div>
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
                            <div flex="20" class="gridContent" style="overflow: auto;">
                                <div style="height: 100%;" >
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
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Productos
                                </div>
                            </div>
                            <div flex="30" class="gridContent">
                                <div flex class="gridContent">
                                    <div ng-repeat="item in $parent.shipment.items" >
                                        <div layout="row" class="cellGridHolder" >
                                            <div flex class="cellGrid"> {{item.descripcion}}</div>
                                            <div flex class="cellGrid"> {{item.saldo}}</div>
                                        </div>
                                    </div>
                                    <div flex layout="column" layout-align="center center" ng-show="$parent.shipment.items.length == 0 ||  !$parent.shipment.items">
                                        No hay datos para mostrar
                                    </div>
                                </div>
                            </div>
                            <div class="titulo_formulario" style="height:39px;">
                                <div>
                                    Container
                                </div>
                            </div>
                            <div flex class="gridContent">
                                <div ng-repeat="item in $parent.shipment.containers" >
                                    <div layout="row" class="cellGridHolder" >
                                        <div flex class="cellGrid" >{{item.tipo}} </div>
                                        <div flex class="cellGrid"> {{item.peso}}</div>
                                        <div flex class="cellGrid"> {{item.volumen}}</div>
                                    </div>
                                </div>
                                <div flex layout="column" layout-align="center center" ng-show="$parent.shipment.containers.length == 0 ">
                                    No hay datos para mostrar
                                </div>
                            </div>
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
                                <div class="titulo_formulario" style="height:39px;" flex ng-dblclick="formOptions.head.expand = !formOptions.head.expand;" >
                                    <div>
                                        Embarque
                                    </div>
                                </div>

                            </div>
                            <div layout="row" class="row" ng-show="formOptions.head.expand" >
                                <md-input-container class="md-block" flex  >
                                    <label>Proveedor</label>
                                    <md-autocomplete md-selected-item="provSelec"
                                                     info="Seleccione el proveedor del embarque"
                                                     skip-tab
                                                     required
                                                     ng-disabled="( session.isblock || $parent.shipment.tarifa_id || $parent.shipment.aprob_superior)"
                                                     md-search-text="provSelecText "
                                                     md-items="item in $parent.provFilter | stringKey : provSelecText : 'razon_social' "
                                                     md-item-text="item.razon_social"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-require-match="true"
                                                     md-no-cache="true"
                                                     md-select-on-match
                                                     md-selected-item-change="$parent.shipment.prov_id = provSelec.id ; $parent.shipment.objs.prov_id = provSelec; toEditHead('prov_id',$parent.shipment.prov_id )"
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
                                    <div layout="column" class="md-block" layout-align="center center"><div>{{$parent.shipment.emision | date : 'dd/MM/yyyy'}}</div></div>
                                </div>
                            </div>
                            <div layout="row" class="row"  ng-show="formOptions.head.expand" >
                                <md-input-container flex>
                                    <label>Titulo</label>
                                    <input  ng-model="$parent.shipment.titulo"
                                            ng-change="toEditHead('titulo', $parent.shipment.titulo ) "
                                            ng-disabled="( session.isblock || $parent.shipment.aprob_superior)"
                                            required
                                            info="Escriba un titulo para facilitar identificacion del embarque"
                                            skip-tab
                                    >
                                </md-input-container>
                            </div>
                            <div layout="row" class="row "  ng-click="openTarif();"   ng-show="formOptions.head.expand" >
                                <div class="adj-box-left autoclick " flex="10" style="color: rgb(176,176,176);margin-right: 8px;" skip-tab>
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left;margin-right: 0">T </div>
                                    <div style="margin-top: 8px;    border-bottom: dotted 0.6px rgb(176,176,176);margin-left: 26px;">Tarifa</div>
                                </div>
                                <md-input-container class="md-block" flex  >
                                    <label>Pais</label>
                                    <input ng-model="$parent.shipment.objs.pais_id.short_name" ng-readonly="true" ng-disabled="(!$parent.shipment.objs.pais_id || $parent.shipment.objs.pais_id == null || form != 'head') " />
                                </md-input-container>
                                <md-input-container class="md-block" flex="20"  >
                                    <label>Puerto</label>
                                    <input ng-model="$parent.shipment.objs.puerto_id.Main_port_name" ng-readonly="true" ng-disabled="(!$parent.shipment.objs.puerto_id || $parent.shipment.objs.puerto_id == null || form != 'head')" />
                                </md-input-container>

                                <md-input-container flex>
                                    <label>Freigth Forwarder</label>
                                    <input  ng-model="$parent.shipment.objs.tarifa_id.freight_forwarder.nombre"
                                            ng-disabled="($parent.shipment.objs.tarifa_id.tbl_tarifa || $parent.shipment.objs.tarifa_id.tbl_tarifa == null) "
                                            ng-readonly="true"
                                            skip-tab
                                    >
                                </md-input-container>
                                <md-input-container flexs>
                                    <label>Naviera</label>
                                    <input  ng-model="$parent.shipment.objs.tarifa_id.naviera.nombre"
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
                            <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form == 'date'}"  >
                                <div flex class="titulo_formulario" style="height:39px;" ng-dblclick="formOptions.date.expand = !formOptions.date.expand;" >
                                    <div>
                                        Fechas
                                    </div>
                                </div>

                            </div>
                            <div layout="row" class="row" ng-show="formOptions.date.expand" >

                                <div layout="row" class="date-row vlc-date" flex="" ng-class="{'vlc-date-no-edit':$parent.shipment.fechas.fecha_carga.confirm}"
                                     ng-click="inDate($parent.shipment.fechas.fecha_carga.value,'fecha_carga' )"

                                >
                                    <div layout="column" class="md-block" layout-align="center center" ng-click="($parent.shipment.fechas.fecha_carga.confirm) ? desblockFecha_carga() : 0" >
                                        <div>Carga</div>
                                    </div>
                                    <md-datepicker ng-model="$parent.shipment.fechas.fecha_carga.value"
                                                   ng-change="changeFecha_carga()"
                                                   ng-disabled="$parent.shipment.fechas.fecha_carga.confirm || session.isblock"
                                                   tipo="alert"
                                                   info="fecha en que se comenzo  la carga,esta fecha modificara la fecha de llagada a venezuela y la fecha de llegada a la tienda"
                                    ></md-datepicker >
                                </div>

                                <div  ng-click="inDate($parent.shipment.fechas.fecha_vnz.value,'fecha_vnz' )"  layout="row" class="date-row vlc-date" flex="" ng-class="{'vlc-date-no-edit':$parent.shipment.fechas.fecha_vnz.confirm}" >
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En Venezuela</div>
                                    </div>

                                    <md-datepicker ng-model="$parent.shipment.fechas.fecha_vnz.value"
                                                   ng-change="changeFecha_vnz()"
                                                   ng-disabled="$parent.shipment.fechas.fecha_vnz.confirm || session.isblock"
                                                   ng-click="(!$parent.shipment.fechas.fecha_carga.confirm) ? desblockFecha_vnz() : 0"
                                                   md-min-date="$parent.shipment.fechas.fecha_carga.plus"
                                                   tipo="alert"
                                                   info="fecha de llegada a venezuela, esta fecha modificara la fecha de llegada a la tienda"

                                                   skip-tab
                                    ></md-datepicker >


                                </div>


                                <div  ng-click="inDate($parent.shipment.fechas.fecha_tienda.value,'fecha_tienda' )"  layout="row" class="date-row vlc-date " flex=""  ng-class="{'vlc-date-no-edit':$parent.shipment.fechas.fecha_tienda.confirm}">
                                    <div layout="column" class="md-block" layout-align="center center"  >
                                        <div>En tienda</div>
                                    </div>

                                    <md-datepicker ng-model="$parent.shipment.fechas.fecha_tienda.value"
                                                   ng-change="changeFecha_tienda()"
                                                   ng-disabled="$parent.shipment.fechas.fecha_tienda.confirm || session.isblock"
                                                   ng-click="(!$parent.shipment.fechas.fecha_carga.confirm) ? desblockFecha_vnz() : 0"
                                                   skip-tab
                                                   md-min-date="$parent.shipment.fechas.fecha_carga.plus"
                                    ></md-datepicker >


                                </div>

                            </div>
                        </div>
                    </form>
                    <form name="doc" layout="row" ng-class="{'focused':form== 'doc'}" ng-click="form = 'doc' ">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row"  class="form-row-head" ng-class="{'form-row-head-select':form== 'doc'}">
                                <div flex class="titulo_formulario" style="height:39px;" ng-dblclick="formOptions.doc.expand = !formOptions.doc.expand;">
                                    <div>
                                        Documentos
                                    </div>
                                </div>
                                <!--<div layout="row" layout-align="center end" class="form-row-head-option">
                                    <div flex layout="column" layout-align="center center" ng-click="">
                                        <span class="{{(formOptions.doc.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.doc.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>-->
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
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">{{$parent.shipment.nro_hbl.adjs.length}} </div>
                                </div>

                                <md-input-container class="md-block" flex ng-click="$parent.miniExpAduana()" >
                                    <label>Exp. Aduanal</label>
                                    <input  ng-disabled="true"  ng-model="$parent.shipment.nro_eaa.documento"
                                            skip-tab
                                    >
                                </md-input-container>
                                <div class="adj-box-rigth">
                                    <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block)}"  style="float:left">{{$parent.shipment.nro_eaa.adjs.length}} </div></div>

                            </div>
                        </div>
                    </form>
                    <form name="pago" layout="row" ng-class="{'focused':form== 'pago'}" ng-click="form = 'pago' ">
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div layout="row"  class="form-row-head" ng-class="{'form-row-head-select':form== 'pago'}">
                                <div flex class="titulo_formulario" style="height:39px;" ng-dblclick="formOptions.pago.expand = !formOptions.pago.expand;" >
                                    <div>
                                        Pago
                                    </div>
                                </div>
                                <!--<div layout="row" layout-align="center end" class="form-row-head-option" >
                                    <div flex layout="column" layout-align="center center" ng-click="">
                                        <span class="{{(formOptions.pago.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.pago.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>-->
                            </div>
                            <div layout="row" class="row" ng-show="formOptions.pago.expand" >

                                <div layout="row" flex>

                                    <md-input-container class="md-block" ng-click="inPay($parent.shipment.flete_maritimo,'flete_maritimo')"  >
                                        <label>Maritimo</label>
                                        <input  ng-model="$parent.shipment.flete_maritimo"
                                                skip-tab
                                                ng-disabled="(!$parent.shipment.tarifa_id && $parent.shipment.conf_monto_dua) || $parent.shipment.aprob_superior"
                                                decimal
                                                minlength="2"
                                                ng-change="toEditHead('dua',$parent.shipment.nacionalizacion)"
                                                ng-blur="outPayMar($parent.shipment.flete_maritimo,'flete_maritimo', $event )"
                                                id="flete_maritimo"

                                        >
                                    </md-input-container>
                                    <div class="adj-box-rigth" ng-click="aprobMaritimo()">
                                        <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block),'vlc-buttom-aprob':$parent.shipment.conf_monto_dua}"  style="float:left">A</div>
                                    </div>
                                </div>
                                <div layout="row" flex class="vlc-option ">

                                    <md-input-container class="md-block" ng-click="inPay($parent.shipment.flete_tt,'flete_tt')"  >
                                        <label>Terrestre</label>
                                        <input  ng-model="$parent.shipment.flete_tt"
                                                skip-tab
                                                ng-disabled="(!$parent.shipment.tarifa_id && $parent.shipment.conf_monto_ft_tt)"
                                                minlength="2"
                                                decimal
                                                ng-change="toEdit('flete_tt',$parent.shipment.flete_tt)"
                                                ng-blur="outPayTerre()"
                                                id="flete_tt"
                                        >
                                    </md-input-container>
                                    <div class="adj-box-rigth" ng-click="aprobFlete()">
                                        <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block),'vlc-buttom-aprob':($parent.shipment.conf_monto_ft_tt)}"  style="float:left">A</div>
                                    </div>
                                </div>

                                <div layout="row"  flex >

                                    <md-input-container class="md-block"  ng-click="inPay($parent.shipment.nacionalizacion,'nacionalizacion')" >
                                        <label>Nacionalizacion</label>
                                        <input  ng-model="$parent.shipment.nacionalizacion"
                                                skip-tab
                                                ng-disabled="(!$parent.shipment.tarifa_id && $parent.shipment.conf_monto_nac)"
                                                decimal
                                                minlength="2"
                                                ng-change="toEditHead('conf_monto_nac',$parent.shipment.conf_monto_nac)"
                                                ng-blur="outPayNac($parent.shipment.nacionalizacion,'nacionalizacion', $event )"
                                                id="nacionalizacion"
                                        >
                                    </md-input-container>
                                    <div class="adj-box-rigth" ng-click="aprobNac()">
                                        <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block),'vlc-buttom-aprob':$parent.shipment.conf_monto_nac}"  style="float:left">A </div>
                                    </div>
                                </div>

                                <div layout="row" flex>

                                    <md-input-container class="md-block"  ng-click="inPay($parent.shipment.dua,'dua')"  >
                                        <label>DUA</label>
                                        <input  ng-model="$parent.shipment.dua"
                                                skip-tab
                                                ng-disabled="(!$parent.shipment.tarifa_id && $parent.shipment.conf_monto_dua)"
                                                decimal
                                                minlength="2"
                                                ng-change="toEditHead('dua',$parent.shipment.dua)"
                                                ng-blur="outPay($parent.shipment.dua,'dua', $event )"                                        >
                                    </md-input-container>
                                    <div class="adj-box-rigth" ng-click="aprobDua()">
                                        <div  class="vlc-buttom"  ng-class="{'ng-disable':(Docsession.block),'vlc-buttom-aprob':$parent.shipment.conf_monto_dua}"  style="float:left">A</div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </form>
                    <form name="agreds" layout="row" flex  ng-class="{'focused':form== 'agreds'}" ng-click="form = 'agreds' ">
                        <div active-left  ></div>
                        <div flex layout="column" >
                            <div layout="row" class="form-row-head " ng-class="{'form-row-head-select':form== 'agreds'}" ng-click="form = 'agreds' "   >
                                <div flex class="titulo_formulario" style="height:39px;" ng-dblclick="formOptions.agreds.expand = !formOptions.agreds.expand;" >
                                    <div>
                                        Agregados
                                    </div>
                                </div>

                                <!--<div layout="row" layout-align="center end" class="form-row-head-option">
                                    <div flex layout="column" layout-align="center center" ng-click="">
                                        <span class="{{(formOptions.agreds.expand) ? 'icon-Up' : 'icon-Above '}}" style="font-size: 12px"></span>
                                        <md-tooltip >
                                            {{(formOptions.agreds.expand) ? 'Ocultar' : 'Mostar'}}
                                        </md-tooltip>
                                    </div>
                                </div>-->
                            </div>
                            <div layout="row" flex  ng-show="formOptions.agreds.expand">
                                <div flex layout="column" >
                                    <div layout="row" class="form-row-head" ng-class="{'form-row-head-select':form== 'agreds'}">
                                        <div class="titulo_formulario" style="height:39px;" flex>
                                            <div>
                                                Container
                                            </div>
                                        </div>
                                        <div layout="column" layout-align="center center" id="btnAgrCp" ng-click="miniContainerCtrl()" style="width:24px;" skip-tab class="autoclick"  >
                                            <span class="icon-Agregar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                                        </div>
                                    </div>
                                    <div flex class="gridContent">
                                        <div ng-repeat="item in $parent.shipment.containers" >
                                            <div layout="row" class="cellGridHolder" >
                                                <div flex class="cellGrid" >{{item.tipo}} </div>
                                                <div flex class="cellGrid"> {{item.peso}}</div>
                                                <div flex class="cellGrid"> {{item.volumen}}</div>
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
                                        <div layout="column" layout-align="center center" ng-click="listOrdershipment()" style="width:24px;" skip-tab class="autoclick" >
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
                                    <div layout="row" class="form-row-head" ng-class="{'form-row-head-select': form == 'agreds'}" skip-tab class="autoclick" >
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
                                        <div ng-repeat="item in $parent.shipment.items" >
                                            <div layout="row" class="cellGridHolder" >
                                                <div flex class="cellGrid"> {{item.descripcion}}</div>
                                                <div flex class="cellGrid"> {{item.saldo}}</div>
                                            </div>
                                        </div>
                                        <div flex layout="column" layout-align="center center" ng-show="$parent.shipment.items.length == 0 ||  !$parent.shipment.items">
                                            No hay datos para mostrar
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div  style="width: 16px;" ng-mouseover="$parent.showNext(true)"  > </div>
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
                                    <div layout="column"  layout-align="center center">{{select.fecha_produccion | date : 'dd/MM/yyyy'}}</div>
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
                            <div layout="row" class="row" style="color: #828282;" >
                                <div layout="row" layout-align="start center">
                                    <div>Tipo asignacion:</div>
                                    <div style="margin-left:8px;">{{select.isTotal ? 'Total' : 'Parcial' }}</div>
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
                                        <label>Disponible</label>
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
                                    <div layout="column"  layout-align="center center">{{select.fecha_produccion | date :'dd/MM/yyyy' }}</div>
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
                                        <label>Disponible</label>
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
                <div layout="column" flex >
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
                                                     ng-disabled="( session.isblock  || $parent.shipment.fechas.fecha_carga.confirm || $parent.shipment.tarifa_id )"
                                                     ng-click="$parent.toEditHead('pais_id', provSelect.id)"
                                                     id="prov_id"
                                                     skip-tab
                                                     md-search-text="pais_idText"
                                                     md-auto-select="true"
                                                     md-items="item in $parent.countryFilter | stringKey : pais_idText : 'short_name' "
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
                                                     ng-disabled="( session.isblock  || $parent.shipment.fechas.fecha_carga.confirm || $parent.shipment.tarifa_id  )"
                                                     skip-tab
                                                     md-search-text="puerto_idText"
                                                     md-auto-select="true"
                                                     md-items="item in (pais_idSelec ==  null) ? [] :pais_idSelec.ports  | stringKey : puerto_idText : 'Main_port_name' "
                                                     md-item-text="item.Main_port_name"
                                                     md-autoselect = "true"
                                                     md-no-asterisk
                                                     md-min-length="0"
                                                     md-no-cache="true"
                                                     md-selected-item-change="$parent.shipment.puerto_id = puerto_idSelec.id ;$parent.shipment.objs.puerto_id = puerto_idSelec;"

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

                    <div layout="row" flex >
                        <div active-left  ></div>
                        <div layout="column" flex style="overflow: auto;">
                            <div layout="row" >
                                <div style="min-width: 254px;" layout="row" class="table-filter-head" >
                                    <md-input-container class="md-block" flex >
                                        <label>Freigth Forwarder</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.freigth_forwarder_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="freigth_forwarder_id"></grid-order-by>
                                </div>
                                <div style="min-width: 254px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Naviera</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.naviera_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="naviera_id"></grid-order-by>
                                </div>
                                <div style="min-width: 254px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Puerto</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.puerto_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="puerto_ide"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>T/T</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.dias_tt"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="dias_tt"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>D/L</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.dl"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="dl"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>GRT</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.grt"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="grt"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Documento</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.documento"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="documento"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Mensajeria</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.mensajeria"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="mensajeria"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Seguros</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.mensajeria"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="seguros"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>Consolidacion</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.consolidacion"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="seguros"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>20' SD </label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.sd20"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="sd20"></grid-order-by>

                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>40' SD</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.sd40"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="sd40"></grid-order-by>

                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head">
                                    <md-input-container class="md-block"  flex>
                                        <label>40' HC</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="tbl.filter.hc40"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="tbl" key="hc40"></grid-order-by>
                                </div>
                                <div style="min-width: 102px;" layout="row" class="table-filter-head" >
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

                            <div layout="column" flex id="resss" style="width: 1884px;overflow-y: auto;">
                                <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict as filter "   id="row{{$index}}" ng-click="setData(item)" >
                                    <div layout="row" class="cellGridHolder" ng-class="{'table-row-select':(tarifaSelect.id == item.id)}" style="width: 1884px;">
                                        <div style="width: 250px; min-width: 250px; " class="cellGrid" >{{item.objs.freight_forwarder_id.nombre}}</div>
                                        <div style="width: 250px;min-width: 250px;  " class="cellGrid" >{{item.objs.naviera_id.nombre}}</div>
                                        <div style="width: 250px;min-width: 250px;  " class="cellGrid" >{{item.objs.puerto_id.Main_port_name}}</div>
                                        <div style="width: 98px;min-width: 98px; " class="cellGrid" >{{item.dias_tt}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.dl}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.grt}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid">{{item.sd20}}</div>
                                        <div style="width: 98px;min-width: 98px;  " class="cellGrid" >{{item.sd40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid">{{item.hc40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                        <div style="width: 98px;min-width: 98px;" class="cellGrid" >{{item.ot40}}</div>
                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" ng-show="filter.length == 0" flex>
                                    No hay datos para mostrar
                                </div>
                            </div>

                        </div>
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
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.fecha_produccion | date :'dd/MM/yyyy' }}</div>
                                    <div flex class="cellGrid" ng-click="open(item)" >{{item.fecha_aprob_gerencia | date :'dd/MM/yyyy' }}</div>
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
                <div layout="column" flex  style="padding-right: 8px;">
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
                            <div layout="column" layout-align="center center" ng-click="created()" style="width:24px;">
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
                                    <label>Cantidad</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.saldo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="saldo"></grid-order-by>
                            </div>


                        </div>
                    </div>
                    <div layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in $parent.shipment.items | filter : tbl.filter:strict | orderBy : tbl.order as filter  "    >
                                <div layout="row" class="cellGridHolder" ng-class="{'table-row-select':(select.id == item.id)}" >
                                    <div ng-click="open(item)" flex class="cellGrid">{{item.codigo_fabrica}}</div>
                                    <div ng-click="open(item)"  flex class="cellGrid" >{{item.descripcion}}</div>
                                    <div ng-click="open(item)"  flex class="cellGrid" >{{item.cantidad}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" ng-show="filter.length == 0" flex>
                                No hay datos para mostrar
                            </div>
                        </div>

                    </div>

                </div>
                <div layout="column" style="width: 360px;">
                    <div layout="row" class="focused">
                        <div layout="row" flex  class="mini-content-title">

                            <div class="titulo_formulario" style="height: 39px;" flex>
                                <div>
                                    <span style="">Detalle de Producto</span>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center"  style="width:24px;" ng-click="update()">
                                <span class="icon-Actualizar" style="font-size: 12px; float: right; color: #0a0a0a"></span>
                            </div>

                        </div>

                    </div>
                    <div flex class="gridContent" style="margin-top: 8px;">
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cantidad </div>
                            <div class="rms" flex > {{select.cantidad}}</div>
                            <md-tooltip >
                                Cantidad asignada al embarque
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Codigo </div>
                            <div class="rms" flex> {{select.codigo}}</div>
                            <md-tooltip >
                                Codigo del producto
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Fabrica </div>
                            <div class="rms" flex> {{select.codigo_fabrica}}</div>
                            <md-tooltip >
                                Codigo de fabrica
                            </md-tooltip>
                        </div>


                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">c/u </div>
                            <div class="rms" flex> {{select.precio}}</div>
                            <md-tooltip >
                                Costo Unitario
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">c/t </div>
                            <div class="rms" flex> {{select.total}}</div>
                            <md-tooltip >
                                Costo Total
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Chequeado </div>
                            <div class="rms" flex> No</div>
                            <md-tooltip >
                                Revision de llegada de producto en almacen
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Calidad </div>
                            <div class="rms" flex> No</div>
                            <md-tooltip >
                                Revision de calidad del producto en almacen
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Exhibicion </div>
                            <div class="rms" flex> No</div>
                            <md-tooltip >
                                Solicitud de productos para revision?
                            </md-tooltip>
                        </div>
                        <div layout="row"  style="height: auto;white-space: inherit;">
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);height: auto;white-space: inherit;">Descripcion </div>
                            <div class="rms" flex  style="height: auto;white-space: inherit;" > {{select.descripcion}}</div>
                            <md-tooltip >
                                Codigo de fabrica
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
                                    <span style="">Productos por pedido</span>
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
                                    <label>Cantidad</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.cantidad"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="cantidad"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>c/u</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.precio"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="precio"></grid-order-by>
                            </div>
                            <div flex layout="row" class="table-filter-head" >
                                <md-input-container class="md-block"  flex>
                                    <label>c/t</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.mt3"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="total"></grid-order-by>
                            </div>
                        </div>
                    </div>
                    <form layout="row"  class="gridContent" flex>
                        <div active-left  ></div>
                        <div layout="column" flex>
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict | orderBy : tbl.order as filter"    >
                                <div layout="row" class="cellGridHolder"  ng-class="{'table-row-select':(select.id == item.id)}" ng-click="filterProd(item.producto_id)" >
                                    <div class="cellEmpty" ng-click="changeAsig(item)"  style=" width: 40px;margin: 0 2px 0 2px;">
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
                <div layout="column" style="width: 360px;padding-left: 8px;">
                    <div layout="row"  class="form-row-head form-row-head-select"  >
                        <div class="titulo_formulario" flex>
                            <div>
                                <span style="">Historial de productos</span>
                            </div>
                        </div>
                        <div layout="column" layout-align="center center"  style="width:24px;" ng-click="clear()" ng-show="key.producto_id">
                            <img src="images/BorrarFormulario.png">
                            <md-tooltip >
                                Quitar seleccion de producto
                            </md-tooltip>
                        </div>
                    </div>
                    <div layout="row"  style="padding-right: 4px;">
                        <div flex layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Codigo Fabrica</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_historia.filter.codigo_fabrica"
                                       skip-tab
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl_historia" key="codigo_fabrica"></grid-order-by>
                        </div>
                        <div flex layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Fecha</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_historia.filter.fecha"
                                       skip-tab
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl_historia" key="fecha"></grid-order-by>
                        </div>
                        <div flex layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>N° Pedido</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_historia.filter.doc_id"
                                       skip-tab
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl_historia" key="doc_id"></grid-order-by>
                        </div>
                        <div flex layout="row">
                            <md-input-container class="md-block"  flex>
                                <label>Costo</label>
                                <input type="text" class="inputFilter"  ng-minlength="2"
                                       ng-model="tbl_historia.filter.precio"
                                       skip-tab
                                >
                            </md-input-container>
                            <grid-order-by ng-model="tbl_historia" key="precio"></grid-order-by>
                        </div>
                    </div>

                    <form flex layout="column" class="gridContent">
                        <div ng-repeat="item in tbl_historia.data | filter: tbl_historia.filter:strict |  filter: key:strict | orderBy :tbl_historia.order " >
                            <div layout="row" class="cellGridHolder" ng-class="{'table-row-select':(key.producto_id == item.producto_id)}" >
                                <div flex class="cellGrid" >{{item.codigo_fabrica}} </div>
                                <div flex class="cellGrid"> {{item.fecha |date :'dd/MM/yyyy'}}</div>
                                <div flex class="cellGrid"> {{item.doc_id}}</div>
                                <div flex class="cellGrid"> {{item.precio}}</div>
                            </div>
                        </div>
                    </form>

                </div>

            </md-content>

        </md-sidenav>

        <!------------------------------------------- resumen de modificaciones de embarque ------------------------------------------------------------------------->
        <md-sidenav class="md-sidenav-right md-whiteframe-2dp md-sidenav-layer" md-disable-backdrop="true" md-component-id="updateShipment" id="updateShipment"   >
            <md-content  layout="row" flex class="sideNavContent" ng-controller= "updateShipmentCtrl" >
                <div active-left  ></div>
                <div layout="column" flex="25">
                    <div layout="column" style="padding-right: 4px;">
                        <div layout="row">
                            <div class="titulo_formulario" style="height:39px;" flex>
                                <div>
                                    Cambios en el  Embarque
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start"   ng-show="keyCount(model.document).length > 0" >
                                <md-switch class="md-primary"
                                           ng-model="goTo.titulo"
                                           ng-disabled="true"
                                >
                                </md-switch>
                            </div>
                        </div>

                        <div layout="column" style="height: 66px;overflow: auto;">
                            <div  style="height:24px;" layout="row" layout-align="start" ng-show="model.document.titulo.estado && model.document.titulo.estado !='new'" >
                                <div layout="row" style="min-width: 88px; color:#ccc">Titulo</div>
                                <div layout="row" style="color: #999">
                                    <div class="rms" flex> {{$parent.shipment.titulo}}</div>
                                </div>
                            </div>
                            <div  style="height:24px;" layout="row" layout-align="start" ng-show="(model.document.prov_id.estado && model.document.prov_id.estado != 'new')" >
                                <div layout="row" style="min-width: 88px; color:#ccc">Proveedor</div>
                                <div layout="row" style="color: #999">
                                    <div class="rms" flex> {{$parent.shipment.objs.prov_id.razon_social}}</div>
                                </div>
                            </div>


                            <div layout="column" layout-align="center center"
                                 ng-show="keyCount(model.document) == 0;"
                            >
                                <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                            </div>
                        </div>

                    </div>
                    <div layout="column" >
                        <div layout="row">
                            <div class="titulo_formulario" style="height:39px;" flex>
                                <div>
                                    Tarifa
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start"  ng-show="keyCount(model.tarifa).length > 0" >
                                <md-switch class="md-primary"
                                           ng-model="goTo.tarifa_id"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>
                        </div>

                        <div layout="column" style="height: 107px;overflow: auto;">
                            <div  style="height:24px;" layout="row" layout-align=" start"  ng-show="(model.tarifa.freight_forwarder_id && model.document.freight_forwarder_id.estado != 'new') "  >
                                <div layout="row" style="min-width: 130px;color:#ccc;">Freigth Fowarder</div>
                                <div layout="row" style="color:#999">
                                    <div class="rms" flex> {{$parent.shipment.objs.tarifa_id.freight_forwarder.nombre}}</div>
                                </div>
                            </div>
                            <div  style="height:24px;" layout="row" layout-align=" start"  ng-show="(model.tarifa.naviera_id && model.tarifa.naviera_id.estado != 'new')" >
                                <div layout="row" style="min-width: 130px;color:#ccc;">Naviera</div>
                                <div layout="row">
                                    <div class="rms" flex style="color:#999" > {{$parent.shipment.objs.tarifa_id.naviera.nombre}}</div>
                                </div>
                            </div>
                            <div  style="height:24px;" layout="row" layout-align=" start"  ng-show="model.tarifa.pais_id.estado &&  model.tarifa.pais_id.estado !='new'" >
                                <div layout="row" style="min-width: 130px; color:#ccc;">Pais</div>
                                <div layout="row" style="color:#999">
                                    <div class="rms" flex> {{$parent.shipment.objs.pais_id.short_name}}</div>
                                </div>
                            </div>
                            <div  style="height:24px;" layout="row" layout-align=" start"  ng-show="(model.tarifa.puerto_id.estado && model.tarifa.puerto_id.estado !='new')" >
                                <div layout="row" style="min-width: 130px; color:#ccc;">Puerto</div>
                                <div layout="row" style="color:#999">
                                    <div class="rms" flex> {{$parent.shipment.objs.puerto_id.Main_port_name}}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center"
                                 ng-show="keyCount(model.tarifa).length == 0"
                            >
                                <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                            </div>
                        </div>
                    </div>


                    <div layout="column">
                        <div layout="row">
                            <div flex class="titulo_formulario" style="height:38px;">
                                <div>
                                    MBL
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start"  ng-show="!((model.nro_mbl.emision.estado == 'new' && model.nro_mbl.emision.estado == 'new') || !(model.nro_mbl.emision.estado  && model.nro_mbl.emision.estado ) )" >
                                <md-switch class="md-primary"
                                           ng-model="goTo.mbl"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>
                        </div>

                        <div layout="column" style="height: 36px;overflow: auto;"  >

                            <div layout="row" layout-align=" start"  style="height:24px;" ng-show="model.nro_mbl.documento.estado &&  model.nro_mbl.documento.estado != 'new' ">
                                <div layout="row" style="min-width: 72px;color:#ccc;">N° </div>
                                <div layout="row"  style="color:#999;" >
                                    <div class="rms" flex> {{$parent.shipment.nro_mbl.documento }}</div>
                                </div>
                            </div>
                            <div layout="row" layout-align=" start"  style="height:24px;"  ng-show="model.nro_mbl.emision.estado &&  model.nro_mbl.emision.estado != 'new' ">
                                <div layout="row" style="min-width: 72px;color:#ccc;">Emision</div>
                                <div layout="row"  style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.nro_mbl.emision | date :'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center"
                                 ng-show="keyCount(model.nro_mbl) == 0;"
                            >
                                <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                            </div>
                        </div>

                    </div>
                    <div layout="column" >
                        <div layout="row">
                            <div flex class="titulo_formulario" style="height:39px;">
                                <div>
                                    HBL
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start" ng-show="!((model.nro_hbl.emision.estado == 'new' && model.nro_hbl.emision.estado == 'new') || !(model.nro_hbl.emision.estado && model.nro_hbl.emision.estado) )">
                                <md-switch class="md-primary"
                                           ng-model="goTo.hbl"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>
                        </div>

                        <div flex layout="column" style="height: 48px;overflow: auto;"  >

                            <div layout="row" layout-align=" start"  style="height:24px;" ng-show="model.nro_hbl.documento.estado && model.nro_hbl.documento.estado != 'new' ">
                                <div layout="row" style="min-width: 72px;color:#ccc;">N° HBL</div>
                                <div layout="row" style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.nro_hbl.documento }}</div>
                                </div>
                            </div>
                            <div layout="row" layout-align=" start"  style="height:24px;" ng-show=" model.nro_hbl.emision.estado && model.nro_hbl.emision.estado != 'new' ">
                                <div layout="row" style="min-width: 72px;color:#ccc;">Emision HBL</div>
                                <div layout="row" style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.nro_hbl.emision | date :'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" style="width: 65%%"
                                 ng-show="keyCount(model.nro_hbl) == 0;"
                            >
                                <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                            </div>
                        </div>
                    </div>
                    <div layout="column" >
                        <div layout="row">
                            <div flex class="titulo_formulario" style="height:39px;">
                                <div>
                                    DUA
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start" ng-show="!((model.nro_eaa.documento.estado == 'new' && model.nro_eaa.emision.estado == 'new') || !(model.nro_eaa.emision.estado && model.nro_eaa.documento.estado)) ">
                                <md-switch class="md-primary"
                                           ng-model="goTo.dua"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>
                        </div>

                        <div layout="column" style="height: 48px;overflow: auto;" >
                            <div layout="row" layout-align=" start"  style="height:24px;" ng-show="model.nro_eaa.documento && model.nro_eaa.documento.estado != 'new' ">
                                <div layout="row" style="min-width: 72px;color:#ccc;">N° DUA</div>
                                <div layout="row" style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.nro_eaa.documento }}</div>
                                </div>
                            </div>

                            <div layout="row" layout-align=" start"  style="height:24px;" ng-show="model.nro_eaa.emision && model.nro_eaa.emision.estado != 'new' ">
                                <div layout="row" style="min-width: 72px;color:#ccc;">Emision</div>
                                <div layout="row" style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.nro_eaa.emision | date :'dd/MM/yyyy' }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center"
                                 ng-show="keyCount(model.nro_eaa) == 0;"
                            >
                                <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                            </div>
                        </div>

                    </div>
                </div>

                <div layout="column" flex >
                    <div layout="column" >
                        <div layout="row">
                            <div flex class="titulo_formulario" style="height:39px;">
                                <div>
                                    Pagos
                                </div>
                            </div>

                            <div  layout="row"  layout-align="end start" ng-show="!((model.document.nacionalizacion.estado =='new' && model.document.flete_tt.estado =='new' &&  model.document.dua.estado =='new'  ) || !(model.document.nacionalizacion.estado && model.document.flete_tt.estado && model.document.dua.estado))" >
                                <md-switch class="md-primary"
                                           ng-model="goTo.pagos"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>
                        </div>
                        <div layout="column" style="height: 76px;overflow: auto;" >
                            <div  style="height:24px;" layout="row" layout-align=" start"  ng-show="model.document.flete_tt.estado && model.document.flete_tt.estado != 'new' ">
                                <div layout="row" style="min-width: 150px;color:#ccc;">Terrestre</div>
                                <div layout="row"  style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.flete_tt   }}</div>
                                </div>
                            </div>
                            <div  style="height:24px;"  layout="row" layout-align=" start" ng-show="model.document.nacionalizacion.estado && model.document.nacionalizacion.estado != 'new' " >
                                <div layout="row" style="min-width: 150px;color:#ccc;">Nacionalizacion</div>
                                <div layout="row"  style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.nacionalizacion }}</div>
                                </div>
                            </div>
                            <div  style="height:24px;" layout="row" layout-align= " start"  ng-show="model.document.dua.estado && model.document.dua.estado != 'new' " >
                                <div layout="row" style="min-width: 150px;color:#ccc;">DUA</div>
                                <div layout="row"  style="color:#999;">
                                    <div class="rms" flex> {{$parent.shipment.dua }}</div>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center"
                                 ng-show="(model.document.nacionalizacion.estado =='new' && model.document.flete_tt.estado =='new' &&  model.document.dua.estado =='new'  ) || !(model.document.nacionalizacion.estado && model.document.flete_tt.estado && model.document.dua.estado)"
                            >
                                <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                            </div>

                        </div>

                        <div layout="column" >
                            <div layout="row">
                                <div flex class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Fechas
                                    </div>
                                </div>
                                <div  layout="row"  layout-align="end start"  ng-show="keyCount(model.fechas.fecha_vnz) > 0 || keyCount(model.fechas.fecha_carga) > 0 || keyCount(model.fechas.fecha_tienda) > 0">
                                    <md-switch class="md-primary"
                                               ng-model="goTo.fechas"
                                               ng-disabled="true"

                                    >
                                    </md-switch>
                                </div>
                            </div>

                            <div layout="column" style="height: 76px;overflow: auto;" >
                                <div  style="height:24px;" layout="row" layout-align=" start"  ng-show="model.fechas.fecha_carga.value.estado && model.fecha_carga.value.estado != 'new' " >
                                    <div layout="row" style="min-width: 106px;color:#ccc;">Carga el</div>
                                    <div layout="row" style="color:#999;width: 125px;">
                                        <div class="rms" flex> {{$parent.shipment.fechas.fecha_carga.value | date :'dd/MM/yyyy' }}</div>
                                    </div>
                                    <div layout="column" layout-align="center center">
                                        <div class="dot-empty" ng-class="{'dot-vlc':(shipment.fechas.fecha_carga.confirm)}"></div>
                                        <md-tooltip >
                                            Esta fecha es definitiva
                                        </md-tooltip>
                                    </div>
                                </div>
                                <div  style="height:24px;"  layout="row" layout-align=" start" ng-show="model.fechas.fecha_vnz.value.estado && model.fecha_vnz.value.estado != 'new' ">
                                    <div layout="row" style="min-width: 106px;color:#ccc;">En Venezuela</div>
                                    <div layout="row"  style="color:#999; width: 125px;"  >
                                        <div class="rms" > {{$parent.shipment.fechas.fecha_vnz.value | date :'dd/MM/yyyy' }}</div>
                                    </div>
                                    <div layout="column" layout-align="center center">
                                        <div class="dot-empty" ng-class="{'dot-vlc':(shipment.fechas.fecha_vnz.confirm)}"></div>
                                        <md-tooltip >
                                            Esta fecha es final
                                        </md-tooltip>
                                    </div>
                                </div>
                                <div  style="height:24px;" layout="row" layout-align=" start" ng-show="model.fechas.fecha_vnz.value.estado && model.fecha_vnz.value.estado != 'new' " >
                                    <div layout="row" style="min-width: 106px;color:#ccc; width: 106px;">En tienda</div>
                                    <div layout="row" style="color:#999;width: 106px;" >
                                        <div class="rms" flex> {{$parent.shipment.fechas.fecha_tienda.value | date :'dd/MM/yyyy' }}</div>
                                    </div>
                                    <div layout="column" layout-align="center center">
                                        <div class="dot-empty" ng-class="{'dot-vlc':(shipment.fechas.fecha_tienda.confirm)}"></div>
                                        <md-tooltip >
                                            Esta fecha es definitiva
                                        </md-tooltip>

                                    </div>
                                </div>
                                <div layout="column" layout-align="center center"
                                     ng-show="keyCount(model.fechas.fecha_vnz) == 0 && keyCount(model.fechas.fecha_carga) == 0 && keyCount(model.fechas.fecha_tienda) == 0;"
                                >
                                    <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES EN ESTOS CAMPOS</span>
                                </div>

                            </div>
                        </div>

                        <div layout="column" flex >
                            <div layout="row">
                                <div flex class="titulo_formulario" style="height:39px;">
                                    <div>
                                        Containers
                                    </div>
                                </div>
                                <div  layout="row"  layout-align="end start" ng-show="model.containers.length > 0">
                                    <md-switch class="md-primary"
                                               ng-model="goTo.containers"
                                               ng-disabled="true"
                                    >
                                    </md-switch>
                                </div>
                            </div>

                            <div layout="row"  ng-show="model.containers.length > 0">
                                <div Style="width: 24px;"></div>
                                <div flex>Peso</div>
                                <div flex>Volumen</div>
                                <div flex>Tipo</div>
                            </div>
                            <div layout="column" flex style="overflow: auto;">
                                <div style="height:100%;" layout="column" >
                                    <div ng-repeat="item in model.containers" >
                                        <div  layout="row" class="cellGridHolder">
                                            <div  Style="width: 24px;" class="cellGrid cellEmpty" layout="column" layout-align="center center" >
                                                <div layout="column" layout-align="center center" ng-show="item.estado == 'upd'">
                                                    <span class="icon-Actualizar" style="font-size: 18px"></span>
                                                    <md-tooltip >
                                                        Actualizado
                                                    </md-tooltip>
                                                </div>
                                                <div layout="column" layout-align="center center" ng-show="item.estado == 'created'">
                                                    <span class="icon-Agregar" style="font-size: 18px"></span>
                                                    <md-tooltip >
                                                        Agregado
                                                    </md-tooltip>
                                                </div><div layout="column" layout-align="center center" ng-show="item.estado == 'del'">
                                                    <span class="icon-Eliminar" style="font-size: 18px"></span>
                                                    <md-tooltip >
                                                        Eliminado
                                                    </md-tooltip>
                                                </div>
                                            </div>
                                            <div flex class="cellGrid" >{{item.peso.v}}</div>
                                            <div flex class="cellGrid" >{{item.volumen.v}}</div>
                                            <div flex class="cellGrid" >{{item.tipo.v}}</div>
                                        </div>


                                    </div>
                                    <div layout="column" layout-align="center center"
                                         ng-show="model.containers.length == 0"
                                         flex
                                    >
                                        <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES DE CONTAINERS</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div layout="column" flex >
                    <div flex="35" layout="column" >
                        <div layout="row">
                            <div flex class="titulo_formulario" style="height:39px;">
                                <div>
                                    Pedidos
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start"  ng-show="model.odcs.length > 0">
                                <md-switch class="md-primary"
                                           ng-model="goTo.pedidos"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>
                        </div>

                        <div layout="row" ng-show="model.odcs.length > 0">
                            <div  Style="width: 28px;"></div>
                            <div flex>N° Proforma</div>
                            <div flex>Emitido</div>
                            <div flex>Tipo</div>
                        </div>
                        <div flex style="overflow: auto;" layout="column">
                            <div style="height:100%;" layout="column" >
                                <div ng-repeat="item in model.odcs">
                                    <div  layout="row" class="cellGridHolder" flex>
                                        <div  Style="width: 24px;" class="cellGrid cellEmpty" ></div>
                                        <div flex class="cellGrid" >{{item.peso.v}}</div>
                                        <div flex class="cellGrid" >{{item.fecha_produccion.v | date :'yyyy/MM/dd' }}</div>
                                        <div flex class="cellGrid" >{{(!item.isTotal.v == 0) ? 'Total' : 'Parcial'}}</div>
                                    </div>


                                </div>
                                <div layout="column" layout-align="center center"
                                     ng-show="model.odcs.length == 0"
                                     flex
                                >
                                    <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES DE PRODUCTOS</span>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div flex  layout="column">
                        <div layout="row">
                            <div flex class="titulo_formulario" style="height:39px;">
                                <div>
                                    Productos
                                </div>
                            </div>
                            <div  layout="row"  layout-align="end start"  ng-show="model.items.length > 0">
                                <md-switch class="md-primary"
                                           ng-model="goTo.productos"
                                           ng-disabled="true"

                                >
                                </md-switch>
                            </div>

                        </div>

                        <div layout="row"  ng-show="model.items.length > 0">
                            <div  Style="width: 28px;"></div>
                            <div flex>Descripcion</div>
                            <div flex>saldo</div>
                        </div>
                        <div flex style="overflow: auto;" layout="column" >
                            <div style="height:100%;" layout="column" >
                                <div  ng-repeat="item in model.items" >
                                    <div layout="row" class="cellGridHolder" flex>
                                        <div  Style="width: 24px;" class="cellGrid cellEmpty" layout="column" layout-align="center center" >
                                            <div layout="column" layout-align="center center" ng-show="item.estado == 'upd'">
                                                <span class="icon-Actualizar" style="font-size: 18px"></span>
                                                <md-tooltip >
                                                    Actualizado
                                                </md-tooltip>
                                            </div>
                                            <div layout="column" layout-align="center center" ng-show="item.estado == 'created'">
                                                <span class="icon-Agregar" style="font-size: 18px"></span>
                                                <md-tooltip >
                                                    Agregado
                                                </md-tooltip>
                                            </div><div layout="column" layout-align="center center" ng-show="item.estado == 'del'">
                                                <span class="icon-Eliminar" style="font-size: 18px"></span>
                                                <md-tooltip >
                                                    Eliminado
                                                </md-tooltip>
                                            </div>
                                        </div>
                                        <div flex class="cellGrid" >{{item.descripcion.v}}</div>
                                        <div flex class="cellGrid" >{{item.saldo.v }}</div>
                                    </div>
                                </div>
                                <div layout="column" layout-align="center center"
                                     ng-show="model.items.length == 0"
                                     flex
                                >
                                    <span style="margin:4px; font-size: 12px; color:#ccc;"> NO SE REALIZARON MODIFICACIONES DE PRODUCTOS</span>
                                </div>
                            </div>
                        </div>

                    </div>
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
                        <form name="head" layout="column" flex="" class="focused">
                            <div layout="row"  class="form-row-head form-row-head-select"  >
                                <div class="titulo_formulario" style="color:rgb(84, 180, 234);">
                                    <div>
                                        Master bill landing
                                    </div>
                                </div>
                            </div>
                            <div  layout="column" style="padding-right:4px">
                                <div layout="row" class="row">
                                    <md-input-container class="md-block" flex>
                                        <label>N°</label>
                                        <input  type="text"
                                                ng-model="$parent.shipment.nro_mbl.documento" ng-change="toEditHead('documento',$parent.shipment.nro_mbl.documento)"
                                                ng-disabled=" $parent.session.isblock"
                                                info="Numero del documento Master Bill landing  "
                                                skip-tab
                                        >
                                    </md-input-container>
                                </div>
                                <div layout="row" class="row" flex>
                                    <div layout="row" class="date-row" >
                                        <div layout="column" class="md-block" layout-align="center center"  >
                                            <div style="margin-bottom: 4px;">Emitido</div>
                                        </div>
                                        <md-datepicker ng-model="$parent.shipment.nro_mbl.emision"
                                                       skip-tab
                                                       ng-change="toEditHead('emision',$parent.shipment.nro_mbl.emision)"
                                                       ng-disabled = " session.isblock"
                                                       info="Fecha de emision del  Master Bill landing segun el documento "
                                        ></md-datepicker >
                                    </div>
                                </div>
                                <div style="padding: 2px;; min-height: 56px;" layout="row" ng-show="!$parent.session.isblock ">
                                    <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                         ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                        Insertar archivo
                                    </div>
                                </div>

                            </div>

                            <div flex class="gridContent" ng-show="$parent.shipment.nro_mbl.adjs.length > 0">
                                <div class="imgItem" ng-repeat="item in $parent.shipment.nro_mbl.adjs  track by $index" ng-click="selectImg(item)" >
                                    <vl-thumb ng-model="item" vl-up="fileUp" vl-fail="" progress="" ></vl-thumb>
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


        <!------------------------------------------- mini layer cancelar documento------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniCancelShipment" id="miniCancelShipment"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniCancelShipmentCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)" >
                    <div  layout="column" flex style="padding-left: 12px">
                        <form name="form" layout="column" flex="" class="focused">
                            <div layout="row"  class="form-row-head form-row-head-select"  >
                                <div class="titulo_formulario" style="color:rgb(84, 180, 234);" flex>
                                    <div>
                                        {{(mode == 'list') ? 'Motivo de cancelacion' : 'Adjunto'}}
                                    </div>
                                </div>
                                <div style="width: 24px;" layout="column" layout-align="center center" ng-click="(mode == 'list') ? mode = 'adjs' : mode = 'list' ">
                                    <img ng-src="{{(mode == 'list') ? 'images/adjunto.png' : 'images/listado.png'}}">
                                </div>
                            </div>
                            <!--------- modo lis --------->

                            <div flex class="gridContent" ng-show="mode == 'list'">
                                <textarea ng-model="model.texto"  skip-tab
                                          id="textarea"
                                          required
                                          flex
                                          placeholder="Ingrese aqui el motivo de cancelacion del documento "
                                          style=""

                                ></textarea>
                            </div>
                            <div layout="column" flex ng-show="mode != 'list'">
                                <div style="padding: 2px;; min-height: 56px;" layout="row" ng-show="!$parent.session.isblock ">
                                    <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                         ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                        Insertar archivo
                                    </div>
                                </div>
                                <div flex class="gridContent" >
                                    <div class="imgItem" ng-repeat="item in model.adjs track by $index" >
                                        <vl-thumb ng-model="item" vl-up="fileUp" vl-fail="" progress="" ></vl-thumb>
                                    </div>
                                    <div  style="height: 100%;" layout="column" layout-align = "center center" flex ng-show="model.adjs.length == 0" >
                                        No hay adjuntos cargados
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </md-content>
        </md-sidenav>
        <!------------------------------------------- mini layer aprobar documento------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniAprobShipment" id="miniAprobShipment"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniAprobShipmentCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)" >
                    <div  layout="column" flex style="padding-left: 12px">
                        <form name="form" layout="column" flex="" class="focused">
                            <div layout="row"  class="form-row-head form-row-head-select"  >
                                <div class="titulo_formulario" style="color:rgb(84, 180, 234);" flex>
                                    <div>
                                       Aprobacion de embarque
                                    </div>
                                </div>

                            </div>
                            <div flex class="gridContent">
                                <textarea ng-model="model.texto"  skip-tab
                                          id="textarea"
                                          required
                                          flex
                                          placeholder="Comentario de aprobacion"
                                          style=""
                                ></textarea>
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
                        <form  name="head" layout="column" flex="" class="focused">
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
                                    <input   info="Numero del documento House Bill landing  "  skip-tab  ng-disabled="$parent.session.isblock " type="text" ng-model="$parent.shipment.nro_hbl.documento"   ng-change="toEditHead('documento',$parent.shipment.nro_hbl.documento)" >
                                </md-input-container>
                                <div layout="row" class="row" flex>
                                    <div layout="row" class="date-row " >
                                        <div layout="column" class="md-block" layout-align="center center"  >
                                            <div  style="margin-bottom: 4px;" >Emitido</div>
                                        </div>
                                        <md-datepicker ng-model="$parent.shipment.nro_hbl.emision"
                                                       ng-disabled=" $parent.session.isblock "
                                                       ng-change="toEditHead('emision',($parent.shipment.nro_hbl.emision)? $parent.shipment.nro_hbl.emision.toString() : undefined )"
                                                       skip-tab
                                                       info="Fecha de emision del House Bill landing segun el documento "
                                        ></md-datepicker >
                                    </div>
                                </div>

                            </div>
                            <div style="padding: 2px;; min-height: 56px;" layout="row" ng-show="!$parent.session.isblock " >
                                <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                     ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                    Insertar archivo
                                </div>
                            </div>

                            <div flex class="gridContent" ng-show="$parent.shipment.nro_hbl.adjs.length > 0">
                                <div class="imgItem" ng-repeat="item in $parent.shipment.nro_hbl.adjs track by $index " ng-click="selectImg(item)">
                                    <vl-thumb ng-model="item" vl-up="fileUp" vl-fail="" progress="" ></vl-thumb>
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

        <!------------------------------------------- mini layer EAA bill landing------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniExpAduana" id="miniExpAduana"
        >
            <md-content   layout="row" flex class="sideNavContent"  ng-controller="miniExpAduanaCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)">
                    <div  layout="column" flex style="padding-left: 12px">
                        <form  name="head" layout="column" flex="" class="focused">
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
                                    <input   info="Numero del documento unico de aduana "  skip-tab type="text" ng-model="$parent.shipment.nro_eaa.documento"   ng-change="toEditHead('documento',$parent.shipment.nro_eaa.documento)" >
                                </md-input-container>
                                <div layout="row" class="row" flex>
                                    <div layout="row"class="date-row " >
                                        <div layout="column" class="md-block" layout-align="center center"  >
                                            <div style="margin-bottom: 4px;" >Emitido</div>
                                        </div>
                                        <md-datepicker ng-model="$parent.shipment.nro_eaa.emision"
                                                       info="Fecha de emision del Documento unico de aduana segun el mismo "
                                                       skip-tab
                                                       ng-change="toEditHead('emision',($parent.shipment.nro_eaa.emision) ? $parent.shipment.nro_eaa.emision.toString() : undefined )"
                                        ></md-datepicker >
                                    </div>
                                </div>

                            </div>
                            <div style="padding: 2px;; min-height: 56px;" layout="row"  ng-show="!$parent.session.isblock " >
                                <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                     ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                    Insertar archivo
                                </div>
                            </div>
                            <div flex class="gridContent" ng-show="$parent.shipment.nro_eaa.adjs.length > 0">
                                <div class="imgItem" ng-repeat="item in $parent.shipment.nro_eaa.adjs track by $index" ng-click="selectImg(item)">
                                    <vl-thumb ng-model="item" vl-up="fileUp" vl-fail="" progress="" ></vl-thumb>
                                </div>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show="$parent.shipment.nro_eaa.adjs.length == 0" >
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
                        <div layout="row" class="form-row-head  $scope.save" flex  >
                            <div flex  class="titulo_formulario" flex>
                                <div>
                                    Containers
                                </div>
                            </div>
                            <div layout="row" layout-align="center end" class="form-row-head-option">
                                <div flex layout="column" layout-align="center center" ng-click="created()">
                                    <span class="icon-Agregar" style="font-size: 12px; color:rgba(0,0,0,0.87);"></span>
                                    <md-tooltip >
                                        Nuevo Container
                                    </md-tooltip>
                                </div>
                                <div flex layout="column" layout-align="center center" ng-click="update()" >
                                    <span class="icon-Actualizar" style="font-size: 12px;color:rgba(0,0,0,0.87);"></span>
                                    <md-tooltip >
                                        Actualizar Container
                                    </md-tooltip>
                                </div>
                            </div>

                        </div>

                    </div>

                    <form name="containerForm" layout="row" style="padding-right: 4px;" ng-show="options.form">
                        <div  style="padding-left: 24px" layout="row">
                            <div Style="width: 24px;"></div>
                            <md-input-container class="md-block" flex ng-click="outPeso()" >
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
                            <md-input-container flex ng-click="model_in.peso.val = model.peso">
                                <label>Peso</label>
                                <input ng-keypress="($event.which === 13) ? outPeso() : 0" id="peso" ng-model="model.peso" skip-tab required ng-disabled="(!model.tipo) " range min-val="1" max-val="{{tipo_select.peso}}">
                            </md-input-container>

                            <md-input-container flex  ng-click="model_in.volumen.val = model.volumen">
                                <label>Volumen</label>
                                <input ng-click="outPeso()"  ng-keypress="($event.which === 13) ? outVolumen() : 0" id="volumen" ng-model="model.volumen" skip-tab required ng-disabled="(!model.peso) " range min-val="0" max-val="{{tipo_select.volumen}}" >
                            </md-input-container>

                        </div>


                    </form>
                    <form flex layout="row" class="gridContent">
                        <div style="width: 12px;" ></div>
                        <div layout="column" flex>
                            <div ng-repeat="item in $parent.shipment.containers" >
                                <div layout="row" class="cellGridHolder" ng-click="setData(item, this)" ng-class="{'table-row-select':(select.id == item.id)}"  >
                                    <div style="width: 24px;padding-top: 15px;border: none;">
                                        <div  layout="column" layout-align="center center"  ng-click="delete(item, this)"  >
                                            <span class="icon-Eliminar" style="font-size: 12px"></span>
                                        </div>
                                    </div>
                                    <div flex ng-dblclick="update(item)" class="cellGrid" >{{item.tipo}} </div>
                                    <div flex ng-dblclick="update(item)"class="cellGrid"> {{item.peso}}</div>
                                    <div flex ng-dblclick="update(item)" class="cellGrid"> {{item.volumen}}</div>
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
                    <form name="formProduct" class="focused">
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
                            <md-input-container class="md-block" >
                                <label>Cantidad</label>
                                <input  required type="text" ng-model="model.cantidad" decimal skip-tab >
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
                            <md-input-container class="md-block" >
                                <label>Precio</label>
                                <input  type="text" ng-model="model.precio"  decimal skip-tab >
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

        <!------------------------------------------- mini layer crear  tarifa ------------------------------------------------------------------------->
        <md-sidenav layout="row" class="md-sidenav-right md-whiteframe-2dp popUp md-sidenav-layer"
                    md-disable-backdrop="true" md-component-id="miniCreatTariff" id="miniCreatTariff"
        >
            <md-content   layout="row" flex class="sideNavContent"   ng-controller="CreatTariffCtrl"  >
                <div  layout="column" flex class="layerColumn"   click-out="close($event)" style="padding-left: 12px">
                    <form ng-show="mode == 'list'"  ng-click="form = 'head'" name="head" ng-class="{'focused':form== 'head'}" >
                        <div  id="head">
                            <div layout="row" class="form-row-head "  ng-class="{'form-row-head-select': form == 'head' }"  >
                                <div class="titulo_formulario" flex>
                                    <div>
                                        Tarifa
                                    </div>
                                </div>
                                <div style="width: 24px;" layout="column" layout-align="center center" ng-click="(mode == 'list') ? mode = 'adjs' : mode = 'list' "><img ng-src="{{(mode == 'list') ? 'images/adjunto.png' : 'images/listado.png'}}"> </div>


                            </div>
                            <div  layout="column"  ng-class="{'form-row-head-select': form == 'head' ,'form-body-select':form == 'head'}" ng-show="form == 'head'">
                                <div style="padding-left: 12px ; padding-right: 4px;" >

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
                                                             md-items="item in $parent.countryFilter | stringKey : pais_idText : 'short_name' "
                                                             md-item-text="item.short_name"
                                                             md-autoselect = "true"
                                                             md-no-asterisk
                                                             md-min-length="0"
                                                             md-no-cache="true"
                                                             md-select-on-match
                                                             md-selected-item-change="model.pais_id = paisSelec.id ;loadPorts(paisSelec);"
                                                             ng-disabled="( session.isblock  || $parent.shipment.fechas.fecha_carga.confirm || $parent.shipment.tarifa_id )"
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
                                                             ng-disabled="( session.isblock  || $parent.shipment.fechas.fecha_carga.confirm || $parent.shipment.tarifa_id  || paisSelec == null)"

                                            >
                                                <md-item-template>
                                                    <span>{{item.Main_port_name}}</span>
                                                </md-item-template>
                                            </md-autocomplete>
                                        </md-input-container>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50">
                                            <div layout="column" layout-align="center center">Expira</div>
                                        </div>
                                        <md-input-container class="md-block" flex >
                                            <md-datepicker ng-model="model.vencimiento" style="margin-left: -12px;"
                                                           skip-tab
                                                           required
                                            ></md-datepicker >
                                        </md-input-container class="md-block" flex >
                                    </div>

                                    <div layout="row" class="row">
                                        <div layout="row" flex="50">
                                            <div layout="column" layout-align="center center">Freight Forwarder</div>
                                        </div>
                                        <md-input-container class="md-block" flex  >
                                            <md-autocomplete md-selected-item="ffSelect"
                                                             info="Selecione el Freight Forwarder a usar"
                                                             required
                                                             skip-tab
                                                             md-search-text="ffText"
                                                             md-items="item in ff | stringKey : ffText : 'nombre'"
                                                             md-item-text="item.nombre"
                                                             md-no-asterisk
                                                             md-min-length="0"
                                                             md-no-cache="true"
                                                             md-selected-item-change="model.ff = (ffSelect == null)? ffText : undefined ; model.freight_forwarder_id = ffSelect.id"
                                                             md-autoselect = "true"
                                                             md-input-id="ffInput"
                                                             vl-no-clear
                                            >
                                                <md-item-template>
                                                    <span>{{item.nombre}}</span>
                                                </md-item-template>
                                                <!-- <md-not-found   >

                                                     <a  ng-click="createdFF(ffText, this)">Crear {{ffText}}</a>

                                                 </md-not-found>-->
                                            </md-autocomplete>
                                        </md-input-container>
                                        <div>{{filtterFF.length}}</div>
                                    </div>
                                    <div layout="row" class="row">
                                        <div layout="row" flex="50">
                                            <div layout="column" layout-align="center center">Naviera</div>
                                        </div>
                                        <md-input-container class="md-block" flex ng-click="loadNv()" >
                                            <md-autocomplete md-selected-item="nvSelect"
                                                             info="Selecione la naviera a usar"
                                                             required
                                                             skip-tab
                                                             md-search-text="nvText"
                                                             md-items="item in nv | stringKey : nvText : 'nombre' "
                                                             md-item-text="item.nombre"
                                                             md-autoselect = "true"
                                                             md-no-asterisk
                                                             md-min-length="0"
                                                             md-no-cache="true"
                                                             ng-disabled="ffSelect == null && !ffText "
                                                             md-input-id="navInput"
                                                             md-selected-item-change="model.naviera_id = nvSelect.id; model.nav = (nvSelect == null) ? nvText : undefined  "
                                                             vl-no-clear

                                            >
                                                <md-item-template>
                                                    <span>{{item.nombre}}</span>
                                                </md-item-template>
                                                <!--                                                <md-not-found   >

                                                                                                    <a href="#" ng-click="createdNv(nvText, this)">Crear {{ffText}}</a>

                                                                                                </md-not-found>-->

                                            </md-autocomplete>
                                        </md-input-container>
                                    </div>

                                    <div layout="row" class="row">
                                        <div layout="row" flex="50" >
                                            <div layout="column" layout-align="center center">T/T </div>
                                        </div>
                                        <md-input-container class="md-block rms" flex >
                                            <input skip-tab type="text" ng-model="model.dias_tt" decimal required >
                                        </md-input-container>
                                        <md-tooltip >Tiempo de transito</md-tooltip>
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
                                            <md-tooltip >Moneda de pago</md-tooltip>
                                        </md-input-container>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                    <form   ng-show="mode == 'list'"  name="bond" ng-class="{'focused':form== 'bond'}" flex layout="column" ng-click="form = 'bond';" ng-class="{'form-row-head-select': form == 'bond' ,'form-body-select':form == 'bond'}">
                        <div layout="row" class="form-row-head " style="margin-left: 12px ;" ng-class="{'form-row-head-select': form == 'bond' ,'form-body-select':form == 'bond'}">
                            <div class="titulo_formulario" flex>
                                <div>
                                    Bondades
                                </div>
                            </div>
                        </div>

                        <div flex class="gridContent" layout="column" style="padding-right:4px"  ng-class="{'form-body-select':form == 'bond'}" ng-show="form == 'bond'">
                            <div style="padding-left: 12px; height: 100%;" >

                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">GRT </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  skip-tab  type="text" ng-model="model.grt"   decimal info="Costo del tonelaje bruto de registro en metros cúbicos" >
                                    </md-input-container>
                                    <md-tooltip >GRT</md-tooltip>
                                </div>
                                <div layout="row" class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Documento </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" skip-tab  ng-model="model.document" decimal  info="Costo del documento"  >
                                    </md-input-container>
                                    <md-tooltip >Documento</md-tooltip>
                                </div>
                                <div layout="row" class="row"  >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Mensajeria </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  skip-tab  type="text" ng-model="model.mensajeria"  decimal  info="Costo del servicio de mensajeria"  >
                                    </md-input-container>
                                    <md-tooltip >Mensajeria</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Seguros </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  type="text" skip-tab  ng-model="model.seguro" decimal  info="Costo del seguro"   >
                                    </md-input-container>
                                    <md-tooltip >Seguros</md-tooltip>
                                </div>
                                <div layout="row" class="row"  >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">Consodilacion </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  skip-tab  type="text" ng-model="model.consolidacion"  decimal info="Costo de la consolidacion"  >
                                    </md-input-container>
                                    <md-tooltip >Consolidacion</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">20'SD </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input   skip-tab type="text" ng-model="model.sd20"  decimal info="Costo del container 20'sd "  >
                                    </md-input-container>
                                    <md-tooltip >20' SD</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">40'SD </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  skip-tab  type="text" ng-model="model.sd40"  decimal  info="Costo del container 40'sd " >
                                    </md-input-container>
                                    <md-tooltip >40' SD</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">40'HC </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  skip-tab  type="text" ng-model="model.hc40" decimal  info="Costo del container 40'hc "  >
                                    </md-input-container>
                                    <md-tooltip >40' HC</md-tooltip>
                                </div>
                                <div layout="row"  class="row" >
                                    <div layout="row" flex="50" >
                                        <div layout="column" layout-align="center center">40'OT </div>
                                    </div>
                                    <md-input-container class="md-block rms" flex >
                                        <input  skip-tab type="text" ng-model="model.ot40"  decimal info="Costo del container 40' ot "   >
                                    </md-input-container>
                                    <md-tooltip >40'OT</md-tooltip>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div layout="column" flex ng-show="mode == 'adjs'">
                        <div layout="row" class="form-row-head form-row-head-select" style="margin-left: 12px ;" >
                            <div class="titulo_formulario" flex>
                                <div>
                                    Adjuntos
                                </div>
                            </div>
                            <div style="width: 24px;" layout="column" layout-align="center center" ng-click="(mode == 'list') ? mode = 'adjs' : mode = 'list' "><img ng-src="{{(mode == 'list') ? 'images/adjunto.png' : 'images/listado.png'}}"> </div>

                        </div>
                        <div style="padding: 2px;; min-height: 56px;" layout="row"  ng-show="!$parent.session.isblock " >
                            <div ngf-drop ngf-select  ng-model="files" class="drop-box" ngf-drag-over-class="dragover"
                                 ngf-multiple="true" ngf-allow-dir="true"  accept="image/*,application/pdf" id="fileInput" >
                                Insertar archivo
                            </div>
                        </div>
                        <div flex class="gridContent" style="padding: 2px;">
                            <div class="imgItem" ng-repeat="item in model.adjs track by $index" >
                                <vl-thumb ng-model="item" vl-up="fileUp" ></vl-thumb>
                            </div>
                            <div layout="column" layout-align="center center" flex ng-show=" model.adjs == 0"  style="height:100%;">
                                No hay adjuntos cargados
                            </div>
                        </div>

                    </div>
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
                        <!--                        <div layout="row" >
                                                    <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cantidad </div>
                                                    <div class="rms" flex> {{select.cantidad}}</div>
                                                    <md-tooltip >
                                                        Cantidad Pedida
                                                    </md-tooltip>
                                                </div>-->
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
                        <div layout="row"  >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Maximo </div>
                            <div class="rms" flex> {{(select.disponible) ? select.disponible :'N/A'}}</div>
                            <md-tooltip >
                                disponible para asignacion
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Codigo </div>
                            <div class="rms" flex> {{(select.codigo) ? select.codigo :'No existe'}} </div>
                            <md-tooltip >
                                Codigo
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Fabrica </div>
                            <div class="rms" flex> {{select.codigo_fabrica}} </div>
                            <md-tooltip >
                                Codigo en profit
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Cod. Barra </div>
                            <div class="rms" flex> {{(select.codigo_barra) ? select.codigo_barra : 'No existe'}} </div>
                            <md-tooltip >
                                Codigo de barra
                            </md-tooltip>
                        </div>
                        <div layout="row" >
                            <div layout="row" flex="50" style="color: rgb(84, 180, 234);">Descripcion </div>
                            <div class="rms" style="height: 240px; white-space: normal;" flex> {{select.descripcion}} </div>
                            <md-tooltip >
                                Descripcion del producto
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