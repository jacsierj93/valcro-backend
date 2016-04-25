<!-- 1) ########################################## CONTENEDOR GENERAL DE LA SECCION ########################################## -->
<div layout="column" class="md-whiteframe-1dp" flex ng-controller="AppCtrl">

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
            <div layout="column" layout-align="center center" ng-click="toggleLeft()">
                <!--<i class="fa fa-plus"></i>-->
                <?= HTML::image("images/agregar.png") ?>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleRight()">
                <!--<i class="fa fa-filter"></i>-->
                <?= HTML::image("images/actualizar.png") ?>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleOtro()">
                <!--<i class="fa fa-minus"></i>-->
                <?= HTML::image("images/filtro.png") ?>
            </div>
        </div>

    </div>

    <!-- 5) ########################################## AREA CONTENEDORA DE LA INFOMACION ########################################## -->
    <div class="contentHolder" layout="row" flex>

        <!-- 6) ########################################## LISTADO LATERAL ########################################## -->
        <md-content class="barraLateral" ng-controller="ListProv">

            <!-- 7) ########################################## ITEN A REPETIR EN EL LISTADO DE PROVEEDORES ########################################## -->
            <div class="boxList" layout="column" flex ng-repeat="item in todos" ng-click="setProv(this)">
                <div style="overflow: hidden; text-overflow: ellipsis;" flex>{{ item.description }}</div>
                <div style="height:40px; font-size:31px;">{{item.limCred}}00000</div>
                <div style="height:40px;">
                    <!--<i ng-show="(item.contraped==1)" class="fa fa-gift" style="font-size:24px;"></i>-->
                    <img ng-show="(item.contraped==1)" src="images/contra_pedido.png"/>
                    <img src="images/aereo.png"/>
                    <img src="images/maritimo.png"/>
                </div>
            </div>

        </md-content>

        <!-- 8) ########################################## BOTON REGRESAR ########################################## -->
        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <!--<i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>-->
            <?= HTML::image("images/btn_prevArrow.png") ?>
        </div>

        <!-- 9) ########################################## AREA CARGA DE LAYERS ########################################## -->
        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                P
            </div>
            <br>
            Selecciones un Proveedor
        </div>

        <!-- 10) ########################################## LAYER (1) RESUMEN DEL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="right">
            <!-- 11) ########################################## CONTENDOR SECCION RESUMEN DEL PROVEEDOR ########################################## -->
            <md-content class="cntLayerHolder" layout="row" flex>
                <!-- 12) ########################################## COLUMNA 1 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Proveedor
                        </div>
                    </div>
                    <div layout="row">
                        <div class="textResm" flex="70" layout="Column" layout-align="start start">
                            <div>
                                CECRISA REVESTIMIENTO CERAMICOS, S.A
                            </div>
                        </div>

                        <div class="textResm" flex="30" layout="Column" layout-align="start start">
                            <div>
                                CRCSA
                            </div>
                        </div>
                    </div>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Nombres Valcro
                        </div>
                    </div>
                    <md-grid-list md-cols="2" md-gutter="6px" md-row-height="4:1" style="margin-right: 8px;">
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                        <md-grid-tile>
                            <div class="textResm" flex layout="Column" layout-align="start start">
                                <div style="overflow: hidden; text-overflow: ellipsis;">
                                    CECRISA REVESTIMIENTO CERAMICOS, S.A
                                </div>
                            </div>
                        </md-grid-tile>
                    </md-grid-list>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Tipo de envio
                        </div>
                    </div>
                    <div layout="row">
                        <div flex>

                        </div>
                    </div>

                </div>
                <!-- 13) ########################################## COLUMNA 2 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                </div>
                <!-- 14) ########################################## COLUMNA 3 RESUMEN ########################################## -->
                <div layout="column" flex>
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                </div>
            </md-content>
        </md-sidenav>


        <!-- 15) ########################################## LAYER (2) FORMULARIO INFORMACION DEL PROVEEDOR ########################################## -->
        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="left">

            <!-- 16) ########################################## CONTENEDOR DE LOS FORMULARIOS (Permite scroll) ########################################## -->
            <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

                <!-- 17) ########################################## FORMULARIO "Datos Basicos del Proveedor" ########################################## -->
                <form name="projectForm" ng-controller="DataProvController">

                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Datos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo</label>
                            <md-select ng-model="dtaPrv.type" name ="state">
                                <md-option ng-repeat="state in states" value="{{state.id}}">
                                    {{state.nombre}}
                                </md-option>
                            </md-select>

                            <!--<div ng-messages="projectForm.type.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>


                        <md-input-container class="md-block" flex>
                            <label>Razon Social</label>
                            <input maxlength="80" ng-minlength="3" required md-no-asterisk name="description"
                                   ng-model="dtaPrv.description">
                            <!--<div ng-messages="projectForm.description.$error" ng-hide>
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="10">
                            <label>Siglas</label>
                            <input maxlength="6" ng-minlength="3"  required name="siglas" ng-model="dtaPrv.siglas" >
                            <!--<div ng-messages="projectForm.siglas.$error">
                                <div ng-message="required">Obligatorio.</div>
                                <div ng-message="md-maxlength">maximo 4</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="15">
                            <label>Tipo de Envio</label>
                            <md-select ng-model="dtaPrv.envio">
                                <md-option ng-repeat="envio in envios" value="{{envio.id}}">
                                    {{envio.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="envio.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block">
                            <md-switch class="md-primary" ng-model="dtaPrv.contraped" aria-label="Contrapedidos">
                                Contrapedidos?
                            </md-switch>
                        </md-input-container>



                    </div>

                    <div layout="row">


                        <div flex></div>

                    </div>
                </form>

                <!-- 18) ########################################## FORMULARIO "Nombres Valcro" ########################################## -->
                <form name="nomvalcroForm">
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Nombres Valcro
                        </div>
                    </div>

                    <md-input-container class="md-block" flex>
                        <label>Nombre Valcro</label>
                        <input maxlength="60" ng-minlength="3" required md-no-asterisk name="nomValcro" ng-model="project.nomValcro">
                        <!--<div ng-messages="nomvalcroForm.nomValcro.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">Este nombre debe tener maximo 60 caracteres.</div>
                        </div>-->
                    </md-input-container>
                </form>

                <!-- 19) ########################################## FORMULARIO "Direcciones del Proveedor" ########################################## -->
                <form name="direccionesForm" ng-controller="provAddrsController">
                    <div class="titulo_formulario" layout="Column" layout-align="start start" ng-click="showGrid()">
                        <div>
                            Direcciones
                        </div>
                    </div>

                    <md-input-container class="md-block" flex>
                        <label>Direccion</label>
                        <input maxlength="250" ng-minlength="5" required md-no-asterisk name="direccProv" ng-model="dir.direccProv">
                        <!--<div ng-messages="nomvalcroForm.direccProv.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">La direccion debe tener maximo 250 caracteres.</div>
                        </div>-->
                    </md-input-container>


                    <div layout="row">

                        <md-input-container class="md-block" flex="20" ng-controller="TipoDirecc">
                            <label>Tipo de Direccion</label>
                            <md-select ng-model="dir.tipo">
                                <md-option ng-repeat="tipo in tipos" value="{{tipo.nombre}}">
                                    {{tipo.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="user.tipo.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="50" ng-controller="ListPaises">
                            <label>Pais</label>
                            <md-select ng-model="dir.pais">
                                <md-option ng-repeat="pais in paises" value="{{pais.nombre}}">
                                    {{pais.nombre}}
                                </md-option>
                            </md-select>
                            <!--<div ng-messages="user.pais.$error">
                                <div ng-message="required">Campo Obligatorio.</div>

                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="40">
                            <label>Telefono</label>
                            <input name="provTelf" required md-no-asterisk ng-model="dir.provTelf"
                                   ng-pattern="/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/"/>
                            <!--<div ng-messages="nomvalcroForm.provTelf.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="pattern">0241-123-1234, ingrese un numero valido.</div>
                            </div>-->
                        </md-input-container>

                    </div>

                    <div layout="column">
                        <div layout="row" class="headGridHolder">
                            <div flex="10" class="headGrid"> Tipo</div><div flex="20" class="headGrid"> Pais</div><div flex class="headGrid"> Direccion</div><div flex="20" class="headGrid"> Telefono</div>
                        </div>
                        <div id="grid" style="overflow-y: auto">
                            <div flex ng-repeat="add in address" ng-click="toEdit(this)">
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="10" class="cellGrid"> {{add.tipo_dir}}</div><div flex="20" class="cellGrid" style="overflow: hidden; text-overflow:ellipsis "> {{add.pais.short_name}}</div><div flex class="cellGrid">{{add.direccion}}</div><div flex="20" class="cellGrid">{{add.telefono}}</div>
                                </div>
                            </div>
<!--                            <div flex>
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="10" class="cellGrid"> Facbrica</div><div flex="20" class="cellGrid"> United Arab Emirates</div><div flex class="cellGrid"> Morbi sit amet ultricies turpis, id rhoncus est. Nulla facilisi. Sed luctus tristique convallis.</div><div flex="20" class="cellGrid">+582411233232</div>
                                </div>
                            </div>-->
                        </div>
                    </div>

                </form>

                <!-- 20) ########################################## FORMULARIO "Contactos del Proveedor" ########################################## -->
                <form name="provContactosForm">
                    <div class="titulo_formulario" layout="Column" layout-align="start start">
                        <div>
                            Contactos Proveedor
                        </div>
                    </div>
                    <div layout="row">

                        <md-input-container class="md-block" flex="30">
                            <label>Nombre y Apellido</label>
                            <input name="nombreCont" maxlength="55" ng-minlength="3" required md-no-asterisk
                                   ng-model="project.nombreCont">
                            <!--<div ng-messages="provContactosForm.nombreCont.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="md-maxlength">Debe tener maximo 55 caracteres.</div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="35">
                            <label>Email</label>
                            <input name="emailCont" minlength="10" maxlength="100" required ng-model="project.emailCont"
                                   ng-pattern="/^.+@.+\..+$/"/>
                            <!--<div ng-messages="provContactosForm.emailCont.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="pattern">Inserte un email valido.</div>
                                <div ng-message-exp="['minlength', 'maxlength']">
                                    El debe tener entre 10 y 100 caracteres.
                                </div>
                            </div>-->
                        </md-input-container>

                        <md-input-container class="md-block" flex="20">
                            <label>Telefono</label>
                            <input name="contTelf" required md-no-asterisk ng-model="project.contTelf"
                                   ng-pattern="/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/"/>
                            <!--<div ng-messages="provContactosForm.contTelf.$error">
                                <div ng-message="required">Campo Obligatorio.</div>
                                <div ng-message="pattern">0241-123-1234, ingrese un numero valido.</div>
                            </div>-->
                        </md-input-container>


                        <md-input-container class="md-block" flex="15" ng-controller="ListPaises">
                            <label>Pais de Residencia</label>
                            <md-select ng-model="user.pais">
                                <md-option ng-repeat="pais in paises" value="{{pais.nombre}}">
                                    {{pais.nombre}}
                                </md-option>
                            </md-select>
                        </md-input-container>


                    </div>




                    <!--<div ng-controller="DemoCtrl3 as ctrl" layout="row">
                        <md-autocomplete flex required
                                         md-input-name="autocompleteField"
                                         md-input-minlength="2"
                                         md-input-maxlength="18"
                                         md-no-cache="ctrl.noCache"
                                         md-selected-item="ctrl.selectedItem"
                                         md-search-text="ctrl.searchText"
                                         md-items="item in ctrl.querySearch(ctrl.searchText)"
                                         md-item-text="item.display"
                                         md-floating-label="Cargos">
                            <md-item-template>
                                <span md-highlight-text="ctrl.searchText">{{item.display}}</span>
                            </md-item-template>
                            <div ng-messages="searchForm.autocompleteField.$error" ng-if="searchForm.autocompleteField.$touched">
                                <div ng-message="required">Debe indicar un cargo</div>
                                <div ng-message="minlength">Your entry is not long enough.</div>
                                <div ng-message="maxlength">Your entry is too long.</div>
                            </div>
                        </md-autocomplete>


                        <div ng-controller="DemoCtrl4 as ctrl" layout="column" ng-cloak="" class="chipsdemoCustomInputs" ng-app="MyApp">

                            <md-chips
                                ng-model="ctrl.selectedVegetables"
                                md-autocomplete-snap=""
                                md-transform-chip="ctrl.transformChip($chip)"
                                md-require-match="ctrl.autocompleteDemoRequireMatch">
                                <md-autocomplete
                                    md-selected-item="ctrl.selectedItem"
                                    md-search-text="ctrl.searchText"
                                    md-items="item in ctrl.querySearch(ctrl.searchText)"
                                    md-item-text="item.name"
                                    md-floating-label="Cargos">
                                    <span md-highlight-text="ctrl.searchText">{{item.name}}</span>
                                </md-autocomplete>
                                <md-chip-template>
                                    <span>
                                      {{$chip.name}}
                                    </span>
                                </md-chip-template>
                            </md-chips>


                        </div>

                    </div>-->

                    <div layout="row">
                        <div ng-controller="idiomasController" layout="row" flex="10">
                            <md-input-container flex>
                                <label>Idiomas</label>
                                <md-select ng-model="idiomasSeleccionados" multiple="">
                                    <md-option ng-value="idioma.name" ng-repeat="idioma in idiomas">{{idioma.name}}</md-option>
                                    </md-optgroup>
                                </md-select>
                            </md-input-container>
                        </div>

                        <md-input-container class="md-block" flex="40">
                            <label>Responsabilidades</label>
                            <input name="cntcRespon" maxlength="100" ng-minlength="3" required>
                        </md-input-container>

                        <md-input-container class="md-block" flex>
                            <label>Direccion de Oficina</label>
                            <input name="cntcDirOfc" maxlength="200" ng-minlength="3" required>
                        </md-input-container>

                    </div>


                    <div layout="column">

                        <div layout="row" class="headGridHolder">
                            <div flex="10" class="headGrid"> Nombre</div><div flex="20" class="headGrid"> Email</div><div flex class="headGrid"> Telefono</div><div flex="20" class="headGrid"> Pais</div>
                        </div>
                        <div id="grid">
                            <div flex>
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="10" class="cellGrid"> Email</div><div flex="20" class="cellGrid"> United Arab Emirates</div><div flex class="cellGrid"> Morbi sit amet ultricies turpis, id rhoncus est. Nulla facilisi. Sed luctus tristique convallis.</div><div flex="20" class="cellGrid">+582411233232</div>
                                </div>
                            </div>
                            <div flex>
                                <div layout="row" layout-wrap class="cellGridHolder">
                                    <div flex="10" class="cellGrid"> Facbrica</div><div flex="20" class="cellGrid"> United Arab Emirates</div><div flex class="cellGrid"> Morbi sit amet ultricies turpis, id rhoncus est. Nulla facilisi. Sed luctus tristique convallis.</div><div flex="20" class="cellGrid">+582411233232</div>
                                </div>
                            </div>

                        </div>

                    </div>


                </form>

            </md-content>

        </md-sidenav>




        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="otro">
            TRES
        </md-sidenav>

    </div>






</div>

