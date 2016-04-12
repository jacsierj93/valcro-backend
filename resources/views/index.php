<!DOCTYPE html>
<html lang="es" ng-app="MyApp">
<head>
    <title>Angular Material - Starter App</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1"/>

    <?=HTML::style("http://fonts.googleapis.com/css?family=Roboto:100,400,500,700,400italic") ?>
    <?=HTML::style("components/angular-material/angular-material.css") ?>
    <?=HTML::style("css/styles.css") ?>
    <?=HTML::style("components/font-awesome/css/font-awesome.min.css") ?>

    <?= HTML::script("components/jquery/dist/jquery.min.js") ?>
    <?= HTML::script("components/angular/angular.js") ?>
    <?= HTML::script("components/angular-resource/angular-resource.min.js") ?>
    <?= HTML::script("components/angular-route/angular-route.min.js") ?>
    <?= HTML::script("components/angular-animate/angular-animate.js") ?>
    <?= HTML::script("components/angular-aria/angular-aria.js") ?>
    <?= HTML::script("components/angular-messages/angular-messages.js") ?>
    <?= HTML::script("components/angular-material/angular-material.js") ?>

    <base href="/angular/">

</head>

<body  ng-cloak layout="column">




    <!-- <div class="sideBar" layout></div>

     <div flex="100" class="content" layout>


         <div ng-controller="AppCtrl" layout="column">
             <md-toolbar md-scroll-shrink ng-if="true">
                 <div class="md-toolbar-tools">
                     <h3>
                         <span>Datos del Proveedor</span>
                     </h3>
                 </div>
             </md-toolbar>


             <md-content layout>
                 <form name="projectForm">

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
                             <input md-maxlength="150" required md-no-asterisk name="description"
                                    ng-model="project.description">
                             <div ng-messages="projectForm.description.$error">
                                 <div ng-message="required">Campo Obligatorio.</div>
                                 <div ng-message="md-maxlength">The name has to be less than 30 characters long.</div>
                             </div>
                         </md-input-container>

                         <md-input-container class="md-block" flex="10">
                             <label>Siglas</label>
                             <input md-maxlength="4" required name="siglas" ng-model="project.siglas">
                             <div ng-messages="projectForm.siglas.$error">
                                 <div ng-message="required">Campo Obligatorio.</div>
                                 <div ng-message="md-maxlength">Las siglas desben tener un maximo de 4 caracteres.</div>
                             </div>
                         </md-input-container>

                     </div>

                     <div>

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


                     </div>


                     <md-input-container class="md-block">
                         <label>Client Email</label>
                         <input required type="email" name="clientEmail" ng-model="project.clientEmail"
                                minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/"/>
                         <div ng-messages="projectForm.clientEmail.$error" role="alert">
                             <div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
                                 Your email must be between 10 and 100 characters long and look like an e-mail address.
                             </div>
                         </div>
                     </md-input-container>
                     <md-input-container class="md-block">
                         <label>Hourly Rate (USD)</label>
                         <input required type="number" step="any" name="rate" ng-model="project.rate" min="800"
                                max="4999" ng-pattern="/^1234$/"/>
                         <div ng-messages="projectForm.rate.$error" multiple md-auto-hide="false">
                             <div ng-message="required">
                                 You've got to charge something! You can't just <b>give away</b> a Missile Defense
                                 System.
                             </div>
                             <div ng-message="min">
                                 You should charge at least $800 an hour. This job is a big deal... if you mess up,
                                 everyone dies!
                             </div>
                             <div ng-message="pattern">
                                 You should charge exactly $1,234.
                             </div>
                             <div ng-message="max">
                                 {{projectForm.rate.$viewValue | currency:"$":0}} an hour? That's a little ridiculous. I
                                 doubt even Bill Clinton could afford that.
                             </div>
                         </div>
                     </md-input-container>
                 </form>
             </md-content>
         </div>


     </div>-->





    <div class="cabezera" layout="row" layout-align="start center">
        <div style="width: 132px; height: 48px;">
            <?=HTML::image("images/logo_inicio.png") ?>
        </div>
        <div flex></div>
        <div layout style="width: 132px; height: 48px;">
            <a href="logout">
                Salir
            </a>
        </div>

    </div>

   <!-- -->

    <div layout="row" flex class="middle">

        <div class="barraHerramientas" layout="column" layout-align="center center" ng-controller="ListHerramientas">

            <div layout="column" layout-align="center center" ng-repeat="item in tools"><img src="{{item.icon}}" title="{{item.tool}}"></div>

        </div>
        <md-content class="barraLateral" ng-controller="ListProv">

            <div flex style="height: 192px;" ng-repeat="item in todos" ng-click="null">
                <div style="height:96px;">{{ item.who }}</div>
                <div style="height:48px; font-size:31px;">{{$index}}00000</div>
                <div style="height:48px;">
                    <i class="fa fa-gift" style="font-size:24px;"></i>
                    <i class="fa fa-paper-plane"  style="font-size:18px; color: #03a9f4;"></i>
                </div>
            </div>

        </md-content>
        <md-content class="contenido" layout="column" layout-padding flex ng-controller="AppCtrl">

            <form name="projectForm">

                <div class="titulo_formulario" layout="row">
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

                    <md-input-container class="md-block" flex>
                        <md-switch class="md-primary" ng-model="data.cb1" aria-label="Contrapedidos">
                            Contrapedidos?
                        </md-switch>
                    </md-input-container>

                </div>
            </form>

            <form name="nomvalcroForm">
                <div class="titulo_formulario" layout="row">
                    Nombres Valcro
                </div>

            </form>



        </md-content>

    </div>

    <div class="pie" layout="row" layout-align="start center" ng-controller="ListSecciones">

        <div layout="column" layout-align="center center" ng-repeat="item in secc">
            <a href="{{item.url}}">
                <img src="{{item.icon}}" alt="{{item.secc}}">
            </a>
        </div>

    </div>


    <?=HTML::script('js/app.js')?>


</body>


</html>
