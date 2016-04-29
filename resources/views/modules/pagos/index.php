<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="pagosCtrll">

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
            <div layout="column" layout-align="center center">
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center">
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center">
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>


    </div>

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>
        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral">
            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex ng-click="lyrOpenClose('lyr1pag')">
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
                <div style="height: 32px; text-align: right;">
                    999.999.999
                </div>
                <div style="height: 32px; text-align: right;">
                    ND/C. 999.999.999
                </div>
                <div style="height: 32px; text-align: right;">
                    RBY. 999.999.999
                </div>
            </div>
        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <?= HTML::image("images/btn_prevArrow.png") ?>
        </div>

        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                PG
            </div>
            <br>
            Selecciones un Proveedor
        </div>


        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="lyr1pag">

            <md-content class="cntLayerHolder" layout="column" style="margin-top: 0;" flex>

                <md-tabs md-dynamic-height md-border-bottom>
                    <md-tab label="Deudas">
                        <md-content>
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
                    </md-tab>
                    <md-tab label="Pagos">
                        <md-content>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla venenatis ante augue. Phasellus volutpat neque ac dui mattis vulputate. Etiam consequat aliquam cursus. In sodales pretium ultrices. Maecenas lectus est, sollicitudin consectetur felis nec, feugiat ultricies mi. Aliquam erat volutpat. Nam placerat, tortor in ultrices porttitor, orci enim rutrum enim, vel tempor sapien arcu a tellus. Vivamus convallis sodales ante varius gravida. Curabitur a purus vel augue ultrices ultricies id a nisl. Nullam malesuada consequat diam, a facilisis tortor volutpat et. Sed urna dolor, aliquet vitae posuere vulputate, euismod ac lorem. Sed felis risus, pulvinar at interdum quis, vehicula sed odio. Phasellus in enim venenatis, iaculis tortor eu, bibendum ante. Donec ac tellus dictum neque volutpat blandit. Praesent efficitur faucibus risus, ac auctor purus porttitor vitae. Phasellus ornare dui nec orci posuere, nec luctus mauris semper.</p>
                            <p>Morbi viverra, ante vel aliquet tincidunt, leo dolor pharetra quam, at semper massa orci nec magna. Donec posuere nec sapien sed laoreet. Etiam cursus nunc in condimentum facilisis. Etiam in tempor tortor. Vivamus faucibus egestas enim, at convallis diam pulvinar vel. Cras ac orci eget nisi maximus cursus. Nunc urna libero, viverra sit amet nisl at, hendrerit tempor turpis. Maecenas facilisis convallis mi vel tempor. Nullam vitae nunc leo. Cras sed nisl consectetur, rhoncus sapien sit amet, tempus sapien.</p>
                            <p>Integer turpis erat, porttitor vitae mi faucibus, laoreet interdum tellus. Curabitur posuere molestie dictum. Morbi eget congue risus, quis rhoncus quam. Suspendisse vitae hendrerit erat, at posuere mi. Cras eu fermentum nunc. Sed id ante eu orci commodo volutpat non ac est. Praesent ligula diam, congue eu enim scelerisque, finibus commodo lectus.</p>
                        </md-content>
                    </md-tab>
                </md-tabs>






                </md-content>
        </md-sidenav>


    </div>


</div>