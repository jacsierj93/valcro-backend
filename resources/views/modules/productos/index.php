<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="mainProdController" global>

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

        <div class="barraLateral" layout="column" ng-controller="listProdController">
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
                <div class="boxList"  layout="column" list-box flex ng-repeat="item in listProvs.provs | filterSearch : listProvs.withpProv" ng-click="getByProv(item,$event)" ng-class="{'listSel' : (item.id ==prov.id), 'reserved':(item.reserved)}">
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
                <div layout="column" layout-align="center center" ng-click="openForm()">
                    <!--<i class="fa fa-plus"></i>-->
                    <span class="icon-Agregar" style="font-size: 23px"></span>
                    <?/*= HTML::image("images/agregar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="openForm(prod.id)" ng-show="prod.id">
                    <span class="icon-Actualizar" style="font-size: 23px"></span>
                   <!-- --><?/*= HTML::image("images/actualizar.png") */?>
                </div>
                <div layout="column" layout-align="center center" ng-click="showAlert()" ng-show="prov.id">
                    <span class="icon-Filtro" style="font-size: 24px"></span>
                    <?/*= HTML::image("images/filtro.png") */?>
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
                        PR
                    </div>
                    <br> Selecciones un Proveedor
                </div>
            </div>
        </div>

        <!-- 15) ########################################## LAYER (2) GRID DE PRODUCTOS ASIGNADOS AL PROVEEDOR########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodLayer1" id="prodLayer1">
            <div layout="row" flex ng-controller="gridAllController">
            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
                <md-content class="cntLayerHolder" layout="column" layout-padding flex >
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
                                               ng-model="listByProv.filter.codigo"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="codigo"></grid-order-by>

                                </div>
                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Descripcion</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.descripcion"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="descripcion"></grid-order-by>

                                </div>
                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Proveedor</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.prov.razon_social"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="prov_id"></grid-order-by>

                                </div>
                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Linea</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.line.linea"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="linea_id"></grid-order-by>

                                </div>
                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Sub-Linea</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.sublinea_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="sublinea_id"></grid-order-by>

                                </div>
                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Stock</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.stock"
                                               decimal
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="stock"></grid-order-by>

                                </div>


                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Precio</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.precio"
                                               decimal
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="precio"></grid-order-by>

                                </div>

                                <div flex layout="row">
                                    <md-input-container class="md-block"  flex>
                                        <label>Tipo</label>
                                        <input type="text" class="inputFilter"  ng-minlength="2"
                                               ng-model="listByProv.filter.tipo_producto_id"
                                               skip-tab
                                        >
                                    </md-input-container>
                                    <grid-order-by ng-model="listByProv" key="tipo_producto_id"></grid-order-by>

                                </div>
                            </div>
                        </div>
                        <form layout="row"  class="gridContent" flex>
                            <div active-left></div>
                            <div layout="column" flex=""   >
                                <div   ng-repeat="item in listByProv.data | filter : listByProv.filter:strict | orderBy : listByProv.order as filter">
                                    <div layout="row" class="cellGridHolder" ng-click="openProd(item)" >

                                        <div flex class="cellGrid" >{{item.codigo}}</div>
                                        <div flex class="cellGrid" >{{item.descripcion}}</div>
                                        <div flex class="cellGrid" > {{item.prov.razon_social}}</div>
                                        <div flex class="cellGrid" >{{item.line.linea}}</div>
                                        <div flex class="cellGrid" >{{item.subLin.sublinea}}</div>
                                        <div flex class="cellGrid" >{{item.stock}}</div>
                                        <div flex class="cellGrid" >{{item.precio}}</div>
                                        <div flex class="cellGrid" >{{item.getType.descripcion}}</div>
                                    </div>
                                </div>
                                <div layout="column" layout-align="center center" flex ng-show="filter == 0">
                                    No hay datos para mostrar
                                </div>
                            </div>
                        </form>

                    </div>
                </md-content>

                <!--<show-next on-next="testNext" valid="isValid"></show-next>-->

            </div>
        </md-sidenav>


        <!-- 15) ########################################## LAYER CON DETALLE DEL PRODUCTO SELECCIONADO ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodLayer2" id="prodLayer2">
            <div layout="row" flex ng-controller="prodSumary">
            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
                <md-content class="cntLayerHolder" layout="column" layout-padding flex>
                    <input type="hidden" md-autofocus>

                    <div layout="row" flex>
                        <div active-left ></div>
                        <div flex="66" style="margin-right: 4px;" layout="column">
                            <div layout="column" class="form-row-head form-row-head-select">
                                <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                    <div>
                                        <span>Datos del Producto</span>
                                    </div>
                                </div>
                            </div>
                            <div flex layout="row">
                                <div flex layout="column">
                                    <div style="height: 80px" layout="row">
                                        <div flex layout="column" layout-align="start start">
                                            <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                                <div layout="column" layout-align="start start" style="padding-top:0px">
                                                    <span>Proveedor</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div flex>
                                            {{prod.datos.prov.razon_social}}
                                        </div>
                                    </div>
                                    <div class="row" layout="row">
                                        <div flex layout="column" layout-align="start start">
                                            <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                                <div layout="column" layout-align="start start" style="padding-top:0px">
                                                    <span>Codigo</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div flex>
                                            {{prod.datos.codigo}}
                                        </div>
                                    </div>
                                    <div style="height: 80px" layout="row">
                                        <div flex layout="column" layout-align="start start">
                                            <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                                <div layout="column" layout-align="start start" style="padding-top:0px">
                                                    <span>Descripcion</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div flex>
                                            {{prod.datos.descripcion}}
                                        </div>
                                    </div>
                                    <div class="row" layout="row">
                                        <div flex layout="column" layout-align="start start">
                                            <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                                <div layout="column" layout-align="start start" style="padding-top:0px">
                                                    <span>Linea</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div flex>
                                            {{prod.datos.line.linea}}
                                        </div>
                                    </div>
                                    <div class="row" layout="row">
                                        <div flex layout="column" layout-align="start start">
                                            <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                                <div layout="column" layout-align="start start" style="padding-top:0px">
                                                    <span>Sub-Linea</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div flex>
                                            {{prod.datos.subLin.sublinea}}
                                        </div>
                                    </div>
                                </div>
                                <div flex layout="column">
                                    <div style="height: 80px" layout="row">
                                        <div flex layout="column" layout-align="start start">  </div>
                                        <div flex>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div flex="33" layout="column">
                            <div flex>
                                <div layout="row" flex class="form-row-head form-row-head-select">
                                    <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                        <div>
                                            <span>Detalles</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" layout="row">
                                    <div flex>
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Stock</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div flex>
                                        {{prod.datos.stock}}
                                    </div>
                                </div>
                                <div class="row" layout="row">
                                    <div flex>
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Precio Venta</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div flex layout="column" layout-align="center center">
                                        <div>{{prod.datos.precio}}</div>
                                    </div>
                                </div>
                                <div class="row" layout="row">
                                    <div flex>
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Cod Barras</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div flex layout="column" layout-align="center center">
                                       <io-barcode flex code="{{prod.datos.codigo}}" type="CODE128B" options="brcdOptions"></io-barcode>
                                    </div>
                                </div>
                                <div class="row" layout="row">
                                    <div flex>
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Punto de Compra</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div flex layout="column" layout-align="center center">
                                        <div>{{prod.datos.precio}}</div>
                                    </div>
                                </div>
                                <div class="row" layout="row">
                                    <div flex>
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Punto de Saldo</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div flex layout="column" layout-align="center center">
                                        <div>{{prod.datos.precio}}</div>
                                    </div>
                                </div>
                                <div class="row" layout="row">
                                    <div flex>
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Biblioteca</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div flex layout="column" layout-align="center center">
                                        <div>{{prod.datos.precio}}</div>
                                    </div>
                                </div>
                            </div>
                            <div flex>
                                <div layout="row" flex class="form-row-head form-row-head-select">
                                    <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                        <div>
                                            <span>Complementarios</span>
                                        </div>
                                    </div>
                                </div>
                                <md-content flex>
                                    <div class="row" ng-repeat="common in prod.datos.commons" layout="row">
                                        <div flex style="font-weight: bolder">
                                            {{common.codigo}}
                                        </div>
                                        <div flex>
                                            {{common.descripcion}}
                                        </div>
                                    </div>
                                </md-content>
                            </div>
                        </div>
                    </div>

                </md-content>
                <div class="showNext" style="width: 16px;" ng-mouseover="showNext(true,saveDependency)">
                </div>
            </div>
        </md-sidenav>
        <!-- 16) ########################################## Layer Creacion / Edicion de producto ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodLayer3" id="prodLayer3">
            <div layout="row" flex ng-controller="createProd">
                <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
                <md-content class="cntLayerHolder" layout="column" layout-align="start none" layout-padding flex>
                   <!-- <input type="hidden" md-autofocus>-->
                    <div layout="row" flex>
                        <div active-left ></div>
                        <div layout="column" flex>
                            <div style="height: 160px;">
                                <form name="prodMainFrm" ng-class="{'focused':true}" >
                                    <div class="titulo_formulario" layout="row" layout-align="start start"  class="row">
                                        <div>
                                            Producto
                                        </div>
                                    </div>
                                    <div flex>
                                        <div layout="row" class="row">
                                            <md-input-container class="md-block" flex>
                                                <label>Proveedor</label>
                                                <md-autocomplete md-selected-item="ctrl.prov"
                                                                 flex
                                                                 id="prodProv"
                                                                 info="busque el proveedor"
                                                                 model="prod.prov"
                                                                 skip-tab
                                                                 md-search-text="ctrl.searchProv"
                                                                 md-items="item in listProviders | stringKey : ctrl.searchProv : 'razon_social'"
                                                                 md-item-text="item.razon_social"
                                                                 require
                                                                 require-match="true"
                                                                 md-no-asterisk
                                                                 md-min-length="0">
                                                    <input >
                                                    <md-item-template>
                                                        <span>{{item.razon_social}}</span>
                                                    </md-item-template>
                                                </md-autocomplete>

                                            </md-input-container>

                                        </div>
                                        <div class="row" layout="row" >
                                            <md-input-container class="md-block" flex="30">
                                                <label>Codigo</label>
                                                <input autocomplete="off"
                                                       skip-tab
                                                       name="condHeadTitle"
                                                       md-autofocus
                                                       ng-disabled="$parent.enabled"
                                                       ng-model="prod.cod"
                                                       required>
                                            </md-input-container>
                                            <md-input-container class="md-block" flex="20">
                                                <label>Linea</label>
                                                <md-autocomplete md-selected-item="ctrl.line"
                                                                 flex
                                                                 id="prodLine"
                                                                 info="busque la linea"
                                                                 model = "prod.line"
                                                                 skip-tab
                                                                 md-search-text="ctrl.searchLine"
                                                                 md-items="item in lines | stringKey : ctrl.searchLine : 'linea' "
                                                                 md-item-text="item.linea"
                                                                 require
                                                                 require-match="true"
                                                                 md-no-asterisk
                                                                 md-min-length="0">
                                                    <input >
                                                    <md-item-template>
                                                        <span>{{item.linea}}</span>
                                                    </md-item-template>
                                                </md-autocomplete>

                                            </md-input-container>
                                            <!--<md-input-container class="md-block" flex="20">
                                                <label>Sublinea</label>
                                                <input autocomplete="off" skip-tab="off" name="condHeadTitle" duplicate="conditions" field="titulo" ng-disabled="$parent.enabled" ng-model="condHead.title" required>
                                            </md-input-container>-->
                                            <md-input-container class="md-block" flex="30">
                                                <label>Serie</label>
                                                <input
                                                    autocomplete="off"
                                                    skip-tab
                                                    name="condHeadTitle"

                                                    ng-disabled="$parent.enabled"
                                                    ng-model="prod.serie"
                                                    required>
                                            </md-input-container>
                                        </div>
                                        <div class="row" layout="row" >
                                            <md-input-container class="md-block" flex>
                                                <label>Descripcion</label>
                                                <input
                                                    autocomplete="off"
                                                    skip-tab
                                                    name="condHeadTitle"
                                                    ng-disabled="$parent.enabled"
                                                    ng-model="prod.desc"
                                                    required>
                                            </md-input-container>

                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div flex layout="column">
                                <form name="prodCritFrm" ng-class="{'focused':true}" flex layout="column">
                                    <div class="titulo_formulario" layout="row" layout-align="start start"  class="row">
                                        <div>
                                            Detalles
                                        </div>
                                    </div>
                                    <md-content flex crit-model="prodCrit" >
                                        <div ng-repeat="field in criteria" class="row"
                                             ng-class="{'field-sel':field.id==formId.id}"
                                             test="{{formId.id}}"
                                             form-preview="{{field.type.directive}}"
                                             ng-dblclick="setEdit(field)"
                                             ng-show="isShow[field.id]"
                                             style="width: 30%; float:left;"
                                        >

                                        </div>
                                        <!--<div class="row" style="float:left; width:32%;" ng-repeat="item in [1,2,3,4,5,6,7,8,9]">

                                            <lmb-collection class="rad-contain" layout="row"  lmb-type="items" lmb-model="item" lmb-itens="[{id:1,descripcion:'prod1'},{id:2,descripcion:'prod2'},{id:3,descripcion:'prod3'},{id:4,descripcion:'prod4'}]">

                                            </lmb-collection>
                                        </div>
        -->

                                    </md-content>
                                </form>
                            </div>
                        </div>

                    </div>
                </md-content>
                <show-next on-next="saveProd" valid="isValid"></show-next>
            </div>
        </md-sidenav>
        <!-- 16) ########################################## LAYER CON DATA EXTRA DEL PRODUCTO ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodLayer4" id="prodLayer4">
            <div layout="row" flex ng-controller="extraDataController">
                <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
                <md-content class="cntLayerHolder" layout="column" layout-align="start none" layout-padding flex>
                    <!--<input type="hidden" md-autofocus>-->
                    <div layout="row" flex>
                        <div active-left ></div>
                        <div flex="33" layout="column">
                            <div flex>
                                <form name="frmPoints" click-out="saveExtraData('frmPoints')">
                                    <div layout="row" flex class="form-row-head form-row-head-select">
                                        <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span>Asignacion de Datos</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>Punto de Compra</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   md-autofocus
                                                   info="indica el punto del stock en que debe solicitarse nuevamente"
                                                   name="pointBuy"
                                                   type="number"
                                                   number
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="prod.pntBuy"
                                                   required>
                                        </md-input-container>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>Punto de Saldo</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="indica el punto del stock en que pasa a cosiderarse Saldo"
                                                   name="pointBuy"
                                                   type="number"
                                                   number
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="prod.pntSald"
                                                   required
                                            >
                                        </md-input-container>
                                    </div>
                                </form>
                                <form name="frmMisc" click-out="saveExtraData('frmMisc')">
                                    <div class="row" layout="row">
                                        <div layout="row" flex class="form-row-head form-row-head-select">
                                            <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                                <div>
                                                    <span>Datos de Almacenamiento</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>Almacen</label>
                                            <md-autocomplete md-selected-item="ctrl.stor"
                                                             flex
                                                             id="prodStorage"
                                                             info="seleccione un almacen"
                                                             model="misc.storage"
                                                             skip-tab
                                                             md-search-text="ctrl.searchStorage"
                                                             md-items="item in [{descripcion:'Los Colorados',id:1},{descripcion:'El Socorro',id:2}] | stringKey : ctrl.searchStorage : 'descripcion'"
                                                             md-item-text="item.descripcion"
                                                             require
                                                             require-match="true"
                                                             md-no-asterisk
                                                             md-min-length="0">
                                                <input >
                                                <md-item-template>
                                                    <span>{{item.descripcion}}</span>
                                                </md-item-template>
                                            </md-autocomplete>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>cantidad Biblioteca</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="que cantidad sera reservada para biblioteca"
                                                   name="pointBuy"
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="misc.cantLib"

                                            >
                                        </md-input-container>
                                        <md-input-container class="md-block" flex>
                                            <label>Unidad Biblioteca</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="unidad de esta cantidad"
                                                   name="pointBuy"
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="misc.unitLib"

                                            >
                                        </md-input-container>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>cantidad Donaciones</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="que cantidad sera reservada para biblioteca"
                                                   name="pointBuy"
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="misc.cantDon"

                                            >
                                        </md-input-container>
                                        <md-input-container class="md-block" flex>
                                            <label>Unidad donaciones</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="unidad de esta cantidad"
                                                   name="pointBuy"
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="misc.unitDon"

                                            >
                                        </md-input-container>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>Descarte</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="que cantidad sera reservada para biblioteca"
                                                   name="pointBuy"
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="misc.cantDis"

                                            >
                                        </md-input-container>
                                        <md-input-container class="md-block" flex>
                                            <label>Unidad descarte</label>
                                            <input autocomplete="off"
                                                   skip-tab
                                                   info="unidad de esta cantidad"
                                                   name="pointBuy"
                                                   ng-disabled="$parent.enabled"
                                                   ng-model="misc.unitDis"

                                            >
                                        </md-input-container>
                                    </div>
                                    <div class="row" layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>Requerimientos de Almacenamiento</label>
                                            <textarea autocomplete="off"
                                                   skip-tab
                                                   row="3"
                                                   wrap="off"
                                                   info="indique requerimientos de almacenmiento"
                                                   name="pointBuy"
                                                   ng-model="misc.reqStrg"

                                            ></textarea>
                                        </md-input-container>
                                    </div>
                                    <div layout="row">
                                        <md-input-container class="md-block" flex>
                                            <label>Herramientas </label>
                                            <textarea autocomplete="off"
                                                   skip-tab
                                                   row="3"
                                                   col="10"
                                                   wrap="off"
                                                   info="Herrameintas o equipas necesarios para el reempaletado"
                                                   name="pointBuy"
                                                   ng-model="misc.tools"
                                            ></textarea>
                                        </md-input-container>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <div flex="66" style="margin-right: 4px;" layout="column">
                            <div flex>

                                <div layout="row" class="focused">

                                    <div layout="row" flex class="form-row-head form-row-head-select row">
                                        <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span >Productos que lo Componen</span>
                                            </div>
                                        </div>
                                        <div style="width:24px" layout="column" pop-up-open="{'prodComp':{before:bef ,after:aft}}"><img layout-align="center center" ng-src="images/Agregar.png"/></div>
                                    </div>
                                </div>
                                <div layout="row">
                                    <div active-left  before="$parent.layerExit"   ></div>
                                    <div layout="row"  flex style="padding-right: 4px;">
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>codigo</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.codigo"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="codigo"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Descripcion</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.descripcion"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="descripcion"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Proveedor</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.prov.razon_social"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="prov_id"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Linea</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.line.linea"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="linea_id"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Sub-Linea</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.sublinea_id"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="sublinea_id"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Stock</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.stock"
                                                       decimal
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="stock"></grid-order-by>

                                        </div>


                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Precio</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.precio"
                                                       decimal
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="precio"></grid-order-by>

                                        </div>

                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Tipo</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.tipo_producto_id"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="tipo_producto_id"></grid-order-by>

                                        </div>
                                    </div>
                                </div>
                                <form layout="row"  class="gridContent" flex>
                                    <div active-left></div>
                                    <div layout="column" flex=""   >
                                        <div   ng-repeat="item in list.common.data | filter : list.common.filter:strict | orderBy : list.common.order as filter">
                                            <div layout="row" class="cellGridHolder" ng-dblclick="editCommon(item)" >
                                                <div ng-click="delete($index,item)"><span class="icon-Eliminar" style="font-size: 23px"></span></div>
                                                <div flex class="cellGrid" >{{item.codigo}}</div>
                                                <div flex class="cellGrid" >{{item.descripcion}}</div>
                                                <div flex class="cellGrid" > {{item.prov.razon_social}}</div>
                                                <div flex class="cellGrid" >{{item.line.linea}}</div>
                                                <div flex class="cellGrid" >{{item.subLin.sublinea}}</div>
                                                <div flex class="cellGrid" >{{item.stock}}</div>
                                                <div flex class="cellGrid" >{{item.precio}}</div>
                                                <div flex class="cellGrid" >{{item.getType.descripcion}}</div>
                                            </div>
                                        </div>
                                        <div layout="column" layout-align="center center" flex ng-show="filter == 0">
                                            No hay datos para mostrar
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div flex>
                                <!--<div layout="column" class="form-row-head form-row-head-select">
                                    <div class="titulo_formulario" style="color: rgb(92, 183, 235);" flex>
                                        <div>
                                            <span>Productos que lo Componen</span>
                                        </div>
                                    </div>
                                </div>-->
                                <div layout="row" class="focused">
                                    <div active-left ></div>
                                    <div layout="row" flex class="form-row-head form-row-head-select">
                                        <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                            <div>
                                                <span >Productos Complementarios</span>
                                            </div>
                                        </div>
                                        <div style="width:24px" layout="column"  pop-up-open="{'prodRela':{before:befR ,after:aftR}}"><img layout-align="center center" info="HOLA!!" ng-src="images/Agregar.png"/></div>
                                    </div>
                                </div>
                                <div layout="row">
                                    <div active-left  before="$parent.layerExit"   ></div>
                                    <div layout="row"  flex style="padding-right: 4px;">
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>codigo</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.codigo"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="codigo"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Descripcion</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.descripcion"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="descripcion"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Proveedor</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.prov.razon_social"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="prov_id"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Linea</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.line.linea"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="linea_id"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Sub-Linea</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.sublinea_id"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="sublinea_id"></grid-order-by>

                                        </div>
                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Stock</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.stock"
                                                       decimal
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="stock"></grid-order-by>

                                        </div>


                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Precio</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.precio"
                                                       decimal
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="precio"></grid-order-by>

                                        </div>

                                        <div flex layout="row">
                                            <md-input-container class="md-block"  flex>
                                                <label>Tipo</label>
                                                <input type="text" class="inputFilter"  ng-minlength="2"
                                                       ng-model="listByProv.filter.tipo_producto_id"
                                                       skip-tab
                                                >
                                            </md-input-container>
                                            <grid-order-by ng-model="listByProv" key="tipo_producto_id"></grid-order-by>

                                        </div>
                                    </div>
                                </div>
                                <form layout="row"  class="gridContent" flex>
                                    <div active-left></div>
                                    <div layout="column" flex=""   >
                                        <div   ng-repeat="item in listByProv.data | filter : listByProv.filter:strict | orderBy : listByProv.order as filter">
                                            <div layout="row" class="cellGridHolder" ng-click="openProd(item)" >

                                                <div flex class="cellGrid" >{{item.codigo}}</div>
                                                <div flex class="cellGrid" >{{item.descripcion}}</div>
                                                <div flex class="cellGrid" > {{item.prov.razon_social}}</div>
                                                <div flex class="cellGrid" >{{item.line.linea}}</div>
                                                <div flex class="cellGrid" >{{item.subLin.sublinea}}</div>
                                                <div flex class="cellGrid" >{{item.stock}}</div>
                                                <div flex class="cellGrid" >{{item.precio}}</div>
                                                <div flex class="cellGrid" >{{item.getType.descripcion}}</div>
                                            </div>
                                        </div>
                                        <div layout="column" layout-align="center center" flex ng-show="filter == 0">
                                            No hay datos para mostrar
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </md-content>
                <show-next on-next="goToAnalisis" ></show-next>
            </div>
        </md-sidenav>

        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodComp" id="prodComp">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="addCompController">
                <input type="hidden" md-autofocus>
                <div flex layout="column" auto-close="{before:onClose,after:null}">
                    <div layout="column" class="form-row-head form-row-head-select">
                        <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                            <div>
                                <span >Seleccione prductos que lo componen</span>
                            </div>
                        </div>
                    </div>

                    <div flex layout="column">
                        <div ng-if="!prodDetail.id" flex layout="column">
                            <div class="row">
                                <md-input-container class="md-block">
                                    <label>Linea</label>
                                    <md-autocomplete md-selected-item="ctrl.line"
                                                     flex
                                                     id="compProv"
                                                     info="seleccione la linea"
                                                     model = "filtCm.line"
                                                     skip-tab
                                                     md-search-text="ctrl.searchLine"
                                                     md-items="item in lines | stringKey : ctrl.searchLine : 'linea' "
                                                     md-item-text="item.linea"
                                                     require
                                                     require-match="true"
                                                     md-no-asterisk
                                                     md-min-length="0">

                                        <md-item-template>
                                            <span>{{item.linea}}</span>
                                        </md-item-template>
                                    </md-autocomplete>

                                </md-input-container>
                            </div>
                            <div class="row">
                                <md-input-container class="md-block " >
                                    <label>Sub-Linea</label>
                                    <md-autocomplete md-selected-item="ctrl.sublin"
                                                     flex
                                                     id="commSublin"
                                                     info="seleccione la sub-linea"
                                                     model = "filtCm.sublin"
                                                     skip-tab
                                                     md-search-text="ctrl.searchSubLine"
                                                     md-items="item in sublines | stringKey : ctrl.searchSubLine : 'sublinea' "
                                                     md-item-text="item.sublin"
                                                     require
                                                     require-match="true"
                                                     md-no-asterisk
                                                     md-min-length="0">
                                        <md-item-template>
                                            <span>{{item.sublin}}</span>
                                        </md-item-template>
                                    </md-autocomplete>

                                </md-input-container>
                            </div>
                            <div class="row">
                                <md-input-container class="md-block">
                                <label>Codigo o Descripcion</label>
                                <input
                                    autocomplete="off"
                                    skip-tab
                                    name="condHeadTitle"
                                    info="escriba el codigo o la descripcion del producto"
                                    ng-model="filtCm.desc"
                                    >
                            </md-input-container>
                            </div>


                            <div ng-if="searching" flex layout="column" layout-align="center center" style="color:#ccc; font-size:24px">
                                BUSCANDO...
                            </div>

                            <md-content ng-if="!searching && filterLs.length>0" flex layout="column">
                                <div>
                                    <div ng-repeat="item in filterLs" class="row" ng-class="{'field-sel':(item.id==prodDetail.prod)}" layout="column" layout-align="center start" style="border-bottom:1px solid #ccc;" ng-click="setDetail(item)">
                                        {{item.descripcion}}
                                    </div>
                                    {{listar}}
                                </div>
                                <div ng-if="!searching && filterLs.length==0" flex layout="column" layout-align="center center" style="color:#ccc; font-size:24px">
                                    no hay coincidencia =(
                                </div>

                            </md-content>

                        </div>
                        <div flex style="padding-top: 40px">
                            <div class="row" layout="row">

                                <div layout-align="center center" style="color:rgb(92, 183, 235); width:150px"  >

                                        <span >codigo</span>

                                </div>

                                <div flex="grow" layout-align="center center">
                                    {{prodDetail.codigo}}
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div layout-align="center center" style="color:rgb(92, 183, 235);width:150px" >

                                    <span >Descripcion</span>

                                </div>

                                <div flex="grow" layout-align="center center">
                                    {{prodDetail.descripcion}}
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div layout-align="center center" style="color:rgb(92, 183, 235);width:150px" >

                                    <span >Serie</span>

                                </div>

                                <div flex="grow" layout-align="center center">
                                    {{prodDetail.serie}}
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div flex="grow" layout-align="center center">
                                    <md-input-container class="md-block row">
                                        <label>cantidad que compone</label>
                                        <input
                                            autocomplete="off"
                                            skip-tab
                                            info="que cantidad de este articulo forma parte del compuesto. "
                                            ng-model="prodDetail.cant"
                                        >
                                    </md-input-container>
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div flex="grow" layout-align="center center">
                                    <md-input-container class="md-block row">
                                        <label>descripcion de complementario</label>
                                        <input
                                            autocomplete="off"
                                            skip-tab
                                            info="como complementa este producto al principal"
                                            ng-model="prodDetail.comment"
                                        >
                                    </md-input-container>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <md-sidenav class="popUp md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodRela" id="prodRela">
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="addRelaController">
                <input type="hidden" md-autofocus>
                <div flex layout="column" auto-close="{before:onClose,after:null}">
                    <div layout="column" class="form-row-head form-row-head-select">
                        <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                            <div>
                                <span >Seleccione productos relacionados</span>
                            </div>
                        </div>
                    </div>

                    <div flex layout="column">
                        <div ng-if="!prodDetail.id" flex layout="column">
                            <div class="row">
                                <md-input-container class="md-block">
                                    <label>Proveedor</label>
                                    <md-autocomplete md-selected-item="ctrl.prov"
                                                     flex
                                                     id="compProv"
                                                     info="Seleccione el Proveedor"
                                                     model = "filtRl.prov"
                                                     skip-tab
                                                     md-search-text="ctrl.searchProv"
                                                     md-items="item in provs | stringKey : ctrl.searchProv : 'razon_social' "
                                                     md-item-text="item.razon_social"
                                                     require
                                                     require-match="true"
                                                     md-no-asterisk
                                                     md-min-length="0">

                                        <md-item-template>
                                            <span>{{item.razon_social}}</span>
                                        </md-item-template>
                                    </md-autocomplete>

                                </md-input-container>
                            </div>
                            <div class="row">
                                <md-input-container class="md-block">
                                    <label>Linea</label>
                                    <md-autocomplete md-selected-item="ctrl.line"
                                                     flex
                                                     id="compProv"
                                                     info="seleccione la linea"
                                                     model = "filtRl.line"
                                                     skip-tab
                                                     md-search-text="ctrl.searchLine"
                                                     md-items="item in lines | stringKey : ctrl.searchLine : 'linea' "
                                                     md-item-text="item.linea"
                                                     require
                                                     require-match="true"
                                                     md-no-asterisk
                                                     md-min-length="0">

                                        <md-item-template>
                                            <span>{{item.linea}}</span>
                                        </md-item-template>
                                    </md-autocomplete>

                                </md-input-container>
                            </div>
                           <!-- <div class="row">
                                <md-input-container class="md-block " >
                                    <label>Sub-Linea</label>
                                    <md-autocomplete md-selected-item="ctrl.sublin"
                                                     flex
                                                     id="commSublin"
                                                     info="seleccione la sub-linea"
                                                     model = "filtRl.sublin"
                                                     skip-tab
                                                     md-search-text="ctrl.searchSubLine"
                                                     md-items="item in sublines | stringKey : ctrl.searchSubLine : 'sublinea' "
                                                     md-item-text="item.sublin"
                                                     require
                                                     require-match="true"
                                                     md-no-asterisk
                                                     md-min-length="0">
                                        <md-item-template>
                                            <span>{{item.sublin}}</span>
                                        </md-item-template>
                                    </md-autocomplete>

                                </md-input-container>
                            </div>-->
                            <div class="row">
                                <md-input-container class="md-block">
                                <label>Codigo o Descripcion</label>
                                <input
                                    autocomplete="off"
                                    skip-tab
                                    name="condHeadTitle"
                                    info="escriba el codigo o la descripcion del producto"
                                    ng-model="filtRl.desc"
                                    >
                            </md-input-container>
                            </div>


                            <div ng-if="searching" flex layout="column" layout-align="center center" style="color:#ccc; font-size:24px">
                                BUSCANDO...
                            </div>

                            <md-content ng-if="!searching && filterLs.length>0" flex layout="column">
                                <div>
                                    <div ng-repeat="item in filterLs" class="row" ng-class="{'field-sel':(item.id==prodDetail.prod)}" layout="column" layout-align="center start" style="border-bottom:1px solid #ccc;" ng-click="setDetail(item)">
                                        {{item.descripcion}}
                                    </div>
                                    {{listar}}
                                </div>
                                <div ng-if="!searching && filterLs.length==0" flex layout="column" layout-align="center center" style="color:#ccc; font-size:24px">
                                    no hay coincidencia =(
                                </div>

                            </md-content>

                        </div>
                        <div flex style="padding-top: 40px">
                            <div class="row" layout="row">

                                <div layout-align="center center" style="color:rgb(92, 183, 235); width:150px"  >

                                        <span >codigo</span>

                                </div>

                                <div flex="grow" layout-align="center center">
                                    {{prodDetail.codigo}}
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div layout-align="center center" style="color:rgb(92, 183, 235);width:150px" >

                                    <span >Descripcion</span>

                                </div>

                                <div flex="grow" layout-align="center center">
                                    {{prodDetail.descripcion}}
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div layout-align="center center" style="color:rgb(92, 183, 235);width:150px" >

                                    <span >Serie</span>

                                </div>

                                <div flex="grow" layout-align="center center">
                                    {{prodDetail.serie}}
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div flex="grow" layout-align="center center">
                                    <md-input-container class="md-block row">
                                        <label>cantidad que compone</label>
                                        <input
                                            autocomplete="off"
                                            skip-tab
                                            info="que cantidad de este articulo forma parte del compuesto. "
                                            ng-model="prodDetail.cant"
                                        >
                                    </md-input-container>
                                </div>
                            </div>
                            <div class="row" layout="row">
                                <div flex="grow" layout-align="center center">
                                    <md-input-container class="md-block row">
                                        <label>descripcion de complementario</label>
                                        <input
                                            autocomplete="off"
                                            skip-tab
                                            info="como complementa este producto al principal"
                                            ng-model="prodDetail.comment"
                                        >
                                    </md-input-container>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </md-content>
        </md-sidenav>

        <!-- 16) ########################################## LAYER ANALISIS DE COSTOS ########################################## -->
        <md-sidenav layout="row" style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="prodLayer5" id="prodLayer5">
            <div layout="row" flex >
                <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
                <md-content class="cntLayerHolder" layout="column" layout-align="start none" layout-padding flex>
                    <input type="hidden" md-autofocus>
                    <div layout="row" flex>
                        <div active-left ></div>
                        <div layout="column" flex class="focused">
                            <div layout="row" class="form-row-head form-row-head-select row">
                                <div class="titulo_formulario" style="height: 39px;color: rgb(92, 183, 235);" flex>
                                    <div>
                                        <span >Analisis de Costo</span>
                                    </div>
                                </div>
                            </div>
                            <div flex>
                            </div>
                        </div>
                    </div>
                </md-content>
                <show-next on-next="goToAnalisis" ></show-next>
            </div>
        </md-sidenav>
        <next-row></next-row>
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


        <div ng-controller="notificaciones" ng-include="template"></div>


        
</div>


