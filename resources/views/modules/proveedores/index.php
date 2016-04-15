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

            <div class="boxList" layout="column" flex ng-repeat="item in todos" ng-click="null">
                <div flex>{{ item.who }}</div>
                <div style="height:40px; font-size:31px;">{{$index}}00000</div>
                <div style="height:40px;">
                    <i class="fa fa-gift" style="font-size:24px;"></i>
                    <i class="fa fa-paper-plane" style="font-size:18px; color: #03a9f4;"></i>
                    <i class="fa fa-plane" style="font-size:20px;"></i>
                </div>
            </div>

        </md-content>

        <div style="width: 48px; background-color: #ffffff;" layout="column" layout-align="center center">
            <i class="fa fa-angle-left" style="font-size: 48px; color: #999999;"></i>
        </div>


        <md-content class="md-whiteframe-2dp cntLayerHolder" layout="column" layout-padding flex
                    ng-controller="AppCtrl">

            <form name="projectForm">

                <div class="titulo_formulario" layout="Column" layout-align="start start">
                    <div>
                        Datos Proveedor
                    </div>
                </div>
                <div layout="row">

                    <md-input-container class="md-block" flex="20">
                        <label>Tipo de Proveedor</label>
                        <md-select ng-model="user.state">
                            <md-option ng-repeat="state in states" value="{{state.abbrev}}">
                                {{state.abbrev}}
                            </md-option>
                        </md-select>
                        <div ng-messages="user.state.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                        </div>
                    </md-input-container>


                    <md-input-container class="md-block" flex>
                        <label>Razon Social</label>
                        <input md-maxlength="80" required md-no-asterisk name="description"
                               ng-model="project.description">
                        <div ng-messages="projectForm.description.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">La razon social debe tener un maximo de 80 caracteres.</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block" flex="10">
                        <label>Siglas</label>
                        <input md-maxlength="4" required name="siglas" ng-model="project.siglas">
                        <div ng-messages="projectForm.siglas.$error">
                            <div ng-message="required">Obligatorio.</div>
                            <div ng-message="md-maxlength">maximo 4</div>
                        </div>
                    </md-input-container>


                </div>

                <div layout="row">

                    <md-input-container class="md-block" flex="20">
                        <label>Tipo de Envio</label>
                        <md-select ng-model="project.envio">
                            <md-option ng-repeat="envio in envios" value="{{envio.tipo}}">
                                {{envio.tipo}}
                            </md-option>
                        </md-select>
                        <div ng-messages="project.envio.$error">
                            <div ng-message="required">Campo Obligatorio.</div>
                            <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                        </div>
                    </md-input-container>

                    <md-input-container class="md-block">
                        <md-switch class="md-primary" ng-model="data.cb1" aria-label="Contrapedidos">
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

                <div layout="row">

                    <div ng-controller="CustomInputDemoCtrl as ctrl">
                        <md-chips ng-model="ctrl.selectedVegetables"
                                  md-autocomplete-snap
                                  md-transform-chip="ctrl.transformChip($chip)"
                                  md-require-match="ctrl.autocompleteDemoRequireMatch">
                            <md-autocomplete flex
                                md-selected-item="ctrl.selectedItem"
                                md-search-text="ctrl.searchText"
                                md-items="item in ctrl.querySearch(ctrl.searchText)"
                                md-item-text="item.name"
                                placeholder="Cargos">
                                <span md-highlight-text="ctrl.searchText">{{item.name}} :: {{item.type}}</span>
                            </md-autocomplete>
                            <md-chip-template>
                                <span>
                                  <strong>{{$chip.name}}</strong>
                                  <em>({{$chip.type}})</em>
                                </span>
                            </md-chip-template>
                        </md-chips>
                    </div>

                <!--<div ng-controller="DemoCtrl as ctrl">
                    <md-autocomplete
                        ng-disabled="ctrl.isDisabled"
                        md-no-cache="ctrl.noCache"
                        md-selected-item="ctrl.selectedItem"
                        md-search-text-change="ctrl.searchTextChange(ctrl.searchText)"
                        md-search-text="ctrl.searchText"
                        md-selected-item-change="ctrl.selectedItemChange(item)"
                        md-items="item in ctrl.querySearch(ctrl.searchText)"
                        md-item-text="item.display"
                        md-min-length="0"
                        placeholder="What is your favorite US state?">
                        <md-item-template>
                            <span md-highlight-text="ctrl.searchText" md-highlight-flags="^i">{{item.display}}</span>
                        </md-item-template>
                        <md-not-found>

                            <a ng-click="ctrl.newState(ctrl.searchText)">Create a new one!</a>
                        </md-not-found>
                    </md-autocomplete>
                </div>-->

                </div>
            </form>
        </md-content>


        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 288px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="left">
            UNO
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 312px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="right">
            DOS
        </md-sidenav>

        <md-sidenav style="margin-top:96px; margin-bottom:48px; width: calc(100% - 336px);" class="md-sidenav-right md-whiteframe-2dp" md-disable-backdrop="true" md-component-id="otro">
            TRES
        </md-sidenav>

    </div>






</div>