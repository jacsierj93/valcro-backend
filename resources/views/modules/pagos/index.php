

<div layout="column" class="md-whiteframe-1dp" flex ng-controller="pagosCtrll">

    <div layout="row" flex="none" class="menuBarHolder">
        <div layout layout-align="start center" class="menu md-whiteframe-1dp">
            Menu
        </div>
        <div class="botonera" layout layout-align="start center">
            <div layout="column" layout-align="center center">

            </div>
            <div layout="column" layout-align="center center" ng-click="lyrOpenClose('lyr1pag')">
                <i class="fa fa-plus"></i>
            </div>
            <div layout="column" layout-align="center center" ng-click="lyrOpenClose()">
                <i class="fa fa-filter"></i>
            </div>
            <div layout="column" layout-align="center center" ng-click="lyrOpenClose()">
                <i class="fa fa-minus"></i>
            </div>
        </div>

    </div>

    <div class="contentHolder" layout="row" flex>

        <md-content class="barraLateral">
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
                        <div layout layout-align="center center" class="cantFactDeb" style="background-color: #00CCA2;">
                            85
                        </div>
                    </div>
                </div>
                <div style="height: 24px; text-align: right;">
                    999.999.999
                </div>
                <div style="height: 24px; text-align: right;">
                    ND/C. 999.999.999
                </div>
                <div style="height: 24px; text-align: right;">
                    RBY. 999.999.999
                </div>
            </div>
        </md-content>

        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>
        </div>

        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                PG
            </div>
            <br>
            Selecciones un Proveedor
        </div>


        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr1pag">

            <md-content class="cntLayerHolder" layout="column" layout-padding flex>

            <form name="projectForm">

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Pagos Pendientes
                    </div>
                </div>
                <div layout="row" class="headGridHolder">
                    <div flex class="headGrid"> N° Factura</div>
                    <div flex class="headGrid"> Emitido</div>
                    <div flex class="headGrid"> Tipo</div>
                    <div flex class="headGrid"> Pagado</div>
                    <div flex class="headGrid"> Resta</div>
                    <div flex class="headGrid"> 000000</div>
                </div>
                <div id="grid">
                    <div flex>
                        <div layout="row" class="cellGridHolder">
                            <div flex class="cellGrid"> Data 1</div>
                            <div flex class="cellGrid"> Data 2</div>
                            <div flex class="cellGrid"> Data 3</div>
                            <div flex class="cellGrid"> Data 4</div>
                            <div flex class="cellGrid"> Data 5</div>
                            <div flex class="cellGrid"> Data 6</div>
                        </div>
                    </div>
                </div>

            </form>

                </md-content>
        </md-sidenav>


    </div>


</div>