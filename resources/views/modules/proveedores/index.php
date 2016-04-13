<div layout="row" flex>

    <md-content class="barraLateral" ng-controller="ListProv">

        <div flex style="height: 192px;" ng-repeat="item in todos" ng-click="null">
            <div style="height:96px;">{{ item.who }}</div>
            <div style="height:48px; font-size:31px;">{{$index}}00000</div>
            <div style="height:48px;">
                <i class="fa fa-gift" style="font-size:24px;"></i>
                <i class="fa fa-paper-plane" style="font-size:18px; color: #03a9f4;"></i>
            </div>
        </div>

    </md-content>

    <md-content layout="column" layout-padding flex ng-controller="AppCtrl">

        <form name="projectForm">

            <div class="titulo_formulario" layout="row" layout-align="start center">
                Datos Proveedor
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
                        <div ng-message="required">Campo Obligatorio.</div>
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
            <div class="titulo_formulario" layout="row">
                Nombres Valcro
            </div>

        </form>

    </md-content>

</div>