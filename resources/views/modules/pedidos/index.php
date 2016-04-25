<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION PEDIDOS########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex  ng-controller="PedidosCtrll">
    <!-- 2) ########################################## AREA DEL MENU ########################################## -->
    <div layout="row" flex="none" class="menuBarHolder">
        <!-- 3) ########################################## MENU ########################################## -->
        <div layout="row" layout-align="start center" class="menu">
            <div flex layout-align="center center">
                Menu
            </div>
            <div layout="column" style="width: 48px; height: 48px;" layout-align="center center">
                <?= HTML::image("images/btn_nextArrow.png") ?>
            </div>
        </div>
        <!-- 4) ########################################## BOTONERA ########################################## -->
        <div class="botonera" layout layout-align="start center">
            <div layout="column" layout-align="center center">

            </div>
            <div layout="column" layout-align="center center" >
                <!--<i class="fa fa-plus"></i>-->
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center">
                <!--<i class="fa fa-filter"></i>-->
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center" >
                <!--<i class="fa fa-minus"></i>-->
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>
        <!-- 4) ########################################## FILTROS ########################################## -->

        <div  layout layout-align="start center" flex>

            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Proveedor</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="state in states" value="{{state.id}}">
                            {{state.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25">
                <md-input-container class="md-block" >
                    <label>Moneda</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="state in states" value="{{state.id}}">
                            {{state.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>
            <div layout="column" layout-align="center center" flex="25" >
                <md-input-container class="md-block" >
                    <label>Tipo envio</label>
                    <md-select ng-model="dtaPrv.type" name ="state">
                        <md-option ng-repeat="state in states" value="{{state.id}}">
                            {{state.nombre}}
                        </md-option>
                    </md-select>

                </md-input-container>
            </div>

            <div layout="column" layout-align="center center" >
                <md-input-container class="md-block">
                    <md-switch class="md-primary" aria-label="Activo">
                        Activo
                    </md-switch>
                </md-input-container>
            </div>
        </div>
    </div><!---fin menu-->

    <div class="contentHolder" layout="row" flex>
        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral" >

            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex ng-click="setProv(this)">
                <div class="boxList" layout="column" flex>
                    <div flex>Nombre del proveedor</div>
                    <div layout="row" style="height: 24px;">
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #003000;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #006600;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #009A00;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantFactDeb" style="background-color: #00CD00;">
                                85
                            </div>
                        </div>
                        <div flex layout layout-align="center center">
                            <div layout layout-align="center center" class="cantPediLlegar" style="background-color: #00CCA2;">
                                85
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </md-content>
    </div>

</div>