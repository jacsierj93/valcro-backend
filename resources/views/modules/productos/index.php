<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="mainProdController" >

    <!-- 2) ########################################## AREA DEL MENU ########################################## -->
    <!--<div layout="row" flex="none" class="menuBarHolder">



    </div>-->

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

        <div class="barraLateral" layout="column" ng-controller="listController">
            <div id="menu" layout="column" class="md-whiteframe-1dp" style="height: 48px; overflow: hidden; background-color: #f1f1f1; min-height: 48px;">
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
                <div layout="column" flex="" tabindex="-1"  style="padding: 0px 4px 0px 4px;">
                    <form name="provdiderFilter" tabindex="-1">
                        <div class="menuFilter" id="expand1" style="height: 176px;" layout-align="start start" tabindex="-1">
                            <div>
                                <span class="icon-Contrapedidos iconInput" tab-index="-1" ng-click="togglecheck($event,'contraped')" ng-class="{'iconActive':filterProv.contraped=='1','iconInactive':filterProv.contraped=='0'}" style="font-size:23px;margin-rigth:8px"></span>
                                <span class="icon-Aereo" style="font-size: 23px" ng-click="togglecheck($event,'aereo')" ng-class="{'iconActive':filterProv.aereo=='1','iconInactive':filterProv.aereo=='0'}" ></span>
                                <span class="icon-Barco" style="font-size: 23px" ng-click="togglecheck($event,'maritimo')" ng-class="{'iconActive':filterProv.maritimo=='1','iconInactive':filterProv.maritimo=='0'}" /></span>
                            </div>
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Razon  Social</label>
                                <input  type="text" ng-model="filterProv.razon_social"  tabindex="-1" >
                            </md-input-container>
                            <md-input-container class="md-block" style="width: calc(100% - 16px); height: 24px;">
                                <label>Pais</label>
                                <input  type="text" ng-model="filterProv.pais"  tabindex="-1" >
                            </md-input-container>
                        </div>
                    </form>
                    <div id="expand2" flex >

                    </div>
                    <div style="width: calc(100% - 16px); height: 24px; cursor: pointer; text-align: center;" ng-click="FilterLateral()">
                       <!-- <img ng-src="{{imgLateralFilter}}">-->
                        <span class="icon-Up" style="font-size: 24px; width: 24px; height: 24px; color:#ccc" ></span>
                        <!--<span class="icon-Down" style="font-size: 24px; width: 24px; height: 24px;" ></span>-->
                    </div>
                </div>
            </div>

            <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
            <!--<md-content flex class="barraLateral" ng-controller="ListProv">-->
            <div id="launchList" style="width:0px;height: 0px;" tabindex="-1" list-box></div>
            <div id="listado" flex  style="overflow-y:auto;" ng-click="showAlert(45)" >
                <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
                <div class="boxList"  layout="column" list-box flex ng-repeat="item in listProvs " ng-click="getByProv(item,$event)" ng-class="{'listSel' : (item.id ==prov.id),'listSelTemp' : (!item.id || (item.id ==prov.id && prov.created)), 'reserved':(item.reserved)}">
                    <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ item.razon_social }}</div>
                  
                    <div style="height:40px;">
                   
                      </div>
                </div>
            </div>
            <!--</md-content>-->
        </div>

        <div layout="column" flex class="md-whiteframe-1dp">
            <!-- 4) ########################################## BOTONERA ########################################## -->
            <div class="botonera" layout layout-align="start center">
                <div layout="column" layout-align="center center">

                </div>
                <div layout="column" layout-align="center center" ng-click="addProv()">
                    <!--<i class="fa fa-plus"></i>-->
                    <span class="icon-Agregar" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="editProv()" ng-show="prov.id">
                    <span class="icon-Actualizar" style="font-size: 23px"></span>
                   <!-- --><?/*= HTML::image("images/actualizar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="showAlert()" ng-show="prov.id">
                    <span class="icon-Filtro" style="font-size: 24px"></span>
                    <?/*= HTML::image("images/filtro.png") */?>
                </div>
                <div layout="row" layout-align="center right" flex id="progress_percent">
                   <div layout="row" layout-align="right center" ng-repeat="i in [0,1,2,3]" flex id="progress_{{i}}">
                       <div style="height: 5px; background: #ccc;" flex>
                           <div class="load_area" style="height: 100%; width:0%; background: #5cb85c;" ng-class="{'lineAnimate':line}"></div>
                       </div>
                       <span info="{{i}}" class="iconInput iconCircle" style="margin-left: 0px;" ng-click="line=true;">
                           {{i}}
                       </span>

                   </div>
                </div>
            </div>

            <div flex layout="row">
                <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
                <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
                    <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
                    <?= HTML::image("images/btn_prevArrow.png","",array("ng-click"=>"prevLayer()","ng-show"=>"(index>0)")) ?>
                </div>

                <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
                <div class="loadArea" ng-class="{'loading':list2()==0}" layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
                    <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; ">
                        P
                    </div>
                    <br> Selecciones un Proveedor
                </div>
            </div>
        </div>

        <!-- 15) ########################################## LAYER (2) FORMULARIO INFORMACION DEL PROVEEDOR ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="layer1" id="layer1">

            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                <input type="hidden" md-autofocus>
                <div layout="column" flex>
                    <div layout="row" class="focused">
                        <div active-left ></div>
                        <div layout="row" flex class="form-row-head form-row-head-select">
                            <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                <div>
                                    <span >Productos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div layout="row">
                        <div active-left  before="$parent.layerExit"   ></div>
                        <div layout="row"  flex style="padding-right: 4px;">
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>codigo</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.codigo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="id"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Descripcion</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.nro_factura"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="nro_factura"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Proveedor</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.titulo"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="titulo"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Linea</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_carga"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_carga"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Sub-Linea</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_vnz"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_vnz"></grid-order-by>

                            </div>
                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Stock</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.fecha_tienda"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="fecha_tienda"></grid-order-by>

                            </div>


                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Precio</label>
                                    <input type="text" class="inputFilter"  ng-minlength="2"
                                           ng-model="tbl.filter.flete_tt"
                                           skip-tab
                                    >
                                </md-input-container>
                                <grid-order-by ng-model="tbl" key="flete_tt"></grid-order-by>

                            </div>

                            <div flex layout="row">
                                <md-input-container class="md-block"  flex>
                                    <label>Tipo</label>
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
                        <div active-left></div>
                        <div layout="column" flex=""   >
                            <div   ng-repeat="item in tbl.data | filter : tbl.filter:strict | orderBy : tbl.order as filter">
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

            <div class="showNext" style="width: 16px;" ng-mouseover="showNext(true,'layer2')">

            </div>

        </md-sidenav>

    <div id="blockSection" style="
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0px;
        left: 0px;
        z-index: 89;
        background: rgba(255,255,255,0.2);
        cursor: default;
    " ng-show="secBlock" ng-show="list2()==0"></div>


        <!-- 8) ########################################## BOTON Next ########################################## -->
        <div ng-controller="notificaciones" ng-include="template"></div>
        <div ng-controller="FilesController" ng-include="template"></div>
</div>


