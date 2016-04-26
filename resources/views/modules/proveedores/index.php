<div layout="column" class="md-whiteframe-1dp" flex>

    <div layout="row" flex="none" class="menuBarHolder">
        <div layout layout-align="start center" class="menu md-whiteframe-1dp">
            Menu
        </div>
        <div class="botonera" layout layout-align="start center">
            <div layout="column" layout-align="center center">

            </div>
            <div layout="column" layout-align="center center" ng-click="toggleLeft()">
                <i class="fa fa-plus"></i>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleRight()">
                <i class="fa fa-filter"></i>
            </div>
            <div layout="column" layout-align="center center" ng-click="toggleOtro()">
                <i class="fa fa-minus"></i>
            </div>
        </div>

    </div>

    <div class="contentHolder" layout="row" flex>

        <md-content class="barraLateral" ng-controller="ListProv">

            <div class="boxList" layout="column" flex ng-repeat="item in todos" ng-click="setProv(this)">
                <div flex>{{ item.razon_social }}</div>
                <div style="height:40px; font-size:31px;">{{item.limite_credito}}00000</div>
                <div style="height:40px;">
                    <i ng-show="(item.contrapedido==1)" class="fa fa-gift" style="font-size:24px;"></i>
                    <i class="fa fa-paper-plane" style="font-size:18px; color: #03a9f4;"></i>
                    <i class="fa fa-plane" style="font-size:20px;"></i>
                </div>
            </div>

        </md-content>

        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>
        </div>

        <div layout="column" layout-align="center center" flex style="color: rgba(0,0,0,0.22);">
            <div style="width: 96px; height: 96px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.22); font-size: 72px; text-align: center; font-weight: 100; color: rgba(0,0,0,0.22);">
                P
            </div>
            <br>
            Selecciones un Proveedor
        </div>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="left">

        <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

            <form name="projectForm" ng-controller="DataProvController">

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Datos Proveedor
                    </div>
                </div>
                <div layout="row">

                    <md-input-container class="md-block" flex="20">
                        <label>Tipo de Proveedor</label>
                        <md-select ng-model="dtaPrv.type" name ="state">
                            <md-option ng-repeat="state in states" value="{{index}}">
                                {{state.abbrev}}
                            </md-option>
                        </md-select>

                        <div ng-messages="projectForm.type.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                        </div>
                    </md-input-container>


                    <md-input-container class="md-block" flex>
                        <label>Razon Social</label>
                        <input md-maxlength="80" required md-no-asterisk name="description"
                               ng-model="dtaPrv.description">
                        <div ng-messages="projectForm.description.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block" flex="10">
                        <label>Siglas</label>
                        <input md-maxlength="4" required name="siglas" ng-model="dtaPrv.siglas" >
                        <div ng-messages="projectForm.siglas.$error">
                            <div ng-message="required">Obligatorio.</div>
                            <div ng-message="md-maxlength">maximo 4</div>
                        </div>
                    </md-input-container>


                </div>

                <div layout="row">

                    <md-input-container class="md-block" flex="20">
                        <label>Tipo de Envio</label>
                        <md-select ng-model="dtaPrv.envio">
                            <md-option ng-repeat="envio in envios" value="{{envio.tipo}}">
                                {{envio.tipo}}
                            </md-option>
                        </md-select>
                        <div ng-messages="envio.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block">
                        <md-switch class="md-primary" ng-model="dtaPrv.cb1" aria-label="Contrapedidos">
                            Contrapedidos?
                        </md-switch>
                    </md-input-container>

                    <div flex></div>

                </div>
            </form>

            <form name="nomvalcroForm">
                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Nombres Valcro
                    </div>
                </div>

                <md-input-container class="md-block" flex>
                    <label>Nombre Valcro</label>
                    <input md-maxlength="60" required md-no-asterisk name="nomValcro" ng-model="project.nomValcro">
                    <div ng-messages="nomvalcroForm.nomValcro.$error">
                        <div ng-message="required">Campo Obligatorio.</div>
                        <div ng-message="md-maxlength">Este nombre debe tener maximo 60 caracteres.</div>
                    </div>
                </md-input-container>
            </form>

            <form name="nomvalcroForm">
                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Direcciones
                    </div>
                </div>

                <md-input-container class="md-block" flex>
                    <label>Direccion</label>
                    <input md-maxlength="250" required md-no-asterisk name="direccProv" ng-model="project.direccProv">
                    <div ng-messages="nomvalcroForm.direccProv.$error">
                        <div ng-message="required">Campo Obligatorio.</div>
                        <div ng-message="md-maxlength">La direccion debe tener maximo 250 caracteres.</div>
                    </div>
                </md-input-container>


                <div layout="row">

                    <md-input-container class="md-block" flex="20" ng-controller="TipoDirecc">
                        <label>Tipo de Direccion</label>
                        <md-select ng-model="user.tipo">
                            <md-option ng-repeat="tipo in tipos" value="{{tipo.nombre}}">
                                {{tipo.nombre}}
                            </md-option>
                        </md-select>
                        <div ng-messages="user.tipo.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block" flex="50" ng-controller="ListPaises">
                        <label>Pais</label>
                        <md-select ng-model="user.pais">
                            <md-option ng-repeat="pais in paises" value="{{pais.nombre}}">
                                {{pais.nombre}}
                            </md-option>
                        </md-select>
                        <div ng-messages="user.pais.$error">
                            <div ng-message="required">Campo Obligatorio.</div>

                        </div>
                    </md-input-container>

                    <md-input-container class="md-block" flex="40">
                        <label>Telefono</label>
                        <input name="provTelf" required md-no-asterisk ng-model="project.provTelf"
                               ng-pattern="/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/"/>
                        <div ng-messages="nomvalcroForm.provTelf.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="pattern">0241-123-1234, ingrese un numero valido.</div>
                        </div>
                    </md-input-container>

                </div>


            </form>


            <form name="provContactosForm">
                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Contactos Proveedor
                    </div>
                </div>
                <div layout="row">

                    <md-input-container class="md-block" flex="40">
                        <label>Nombre y Apellido</label>
                        <input name="nombreCont" md-maxlength="55" required md-no-asterisk
                               ng-model="project.nombreCont">
                        <div ng-messages="provContactosForm.nombreCont.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">Debe tener maximo 55 caracteres.</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block" flex="30">
                        <label>Email</label>
                        <input name="emailCont" minlength="10" maxlength="100" required ng-model="project.emailCont"
                               ng-pattern="/^.+@.+\..+$/"/>
                        <div ng-messages="provContactosForm.emailCont.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="pattern">Inserte un email valido.</div>
                            <!--<div ng-message-exp="['minlength', 'maxlength']">
                                El debe tener entre 10 y 100 caracteres.
                            </div>-->
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block" flex="30">
                        <label>Telefono</label>
                        <input name="contTelf" required md-no-asterisk ng-model="project.contTelf"
                               ng-pattern="/^[0-9]{4}-[0-9]{3}-[0-9]{4}$/"/>
                        <div ng-messages="provContactosForm.contTelf.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="pattern">0241-123-1234, ingrese un numero valido.</div>
                        </div>
                    </md-input-container>

                </div>

                <div ng-controller="DemoCtrl3 as ctrl" layout="row">
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

                </div>
            </form>
        </md-content>





        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="right">
            DOS
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="otro">
            TRES
        </md-sidenav>

    </div>






</div>