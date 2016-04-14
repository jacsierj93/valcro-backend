<div layout="column" class="md-whiteframe-1dp" flex>

    <div layout="row" flex="none" class="menuBarHolder">
        <div layout layout-align="start center" class="menu md-whiteframe-1dp">
            Menu
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
                </div>
            </div>

        </md-content>

        <md-content class="cntLayerHolder" layout="column" layout-padding flex ng-controller="AppCtrl">

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

                </div>



            </form>



        </md-content>

    </div>



</div>