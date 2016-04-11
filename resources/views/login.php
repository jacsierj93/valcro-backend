<!DOCTYPE html>
<html lang="en">
<head>
    <title>Valcro Sistema</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1"/>
    <?= HTML::style("http://fonts.googleapis.com/css?family=Roboto:100,400,500,700,400italic") ?>
    <?= HTML::style("components/angular-material/angular-material.css") ?>
    <?= HTML::style("css/styles.css") ?>
    <?= HTML::style("components/font-awesome/css/font-awesome.min.css") ?>

    <?= HTML::script("components/jquery/dist/jquery.min.js") ?>
    <?= HTML::script("components/angular/angular.js") ?>
    <?= HTML::script("components/angular-animate/angular-animate.js") ?>
    <?= HTML::script("components/angular-aria/angular-aria.js") ?>
    <?= HTML::script("components/angular-messages/angular-messages.js") ?>
    <?= HTML::script("components/angular-material/angular-material.js") ?>
    <?= HTML::script("components/angular-route/angular-route.min.js") ?>

</head>

<body id="login" ng-app="MyApp" ng-cloak layout="column">


<div id="holderLogin" layout="column" flex>

    <div id="loginTop" flex layout layout-align="center center">

        <div class="msjBienvenida" layout layout-align="center center">
            “Casi todo lo que realice será</br>insignificante, PERO ES MUY</br>IMPORTANTE QUE LO HAGA”</br>Mahatma
            Gandhi.
        </div>

    </div>

    <div id="loginBottom" layout="row">

        <div class="logoHolder" layout layout-align="center center">
            <?= HTML::image("images/login_logo.png") ?>
        </div>
        <div flex>
        </div>
        <form id="lgnForm" name="lgnForm" ng-controller="login" layout="row">
            <md-input-container>
                <label style="color: #ffffff">Usuario</label>
                <input ng-model="user.usr" name="usr" style="color: #ffffff">
            </md-input-container>
            <md-input-container>
                <label style="color: #ffffff">Clave</label>
                <input ng-model="user.pss" name="pss" type="password" style="color: #ffffff">
            </md-input-container>
            <div class="btnHolder" layout layout-align="center center">
                <i class="fa fa-angle-right" ng-click="lgn()"></i>
            </div>
        </form>
    </div>


</div>

<div id="holderAll" layout="column" flex>
    <div class="cabezera" layout="row" layout-align="start center">
        <?= HTML::image("images/logo_inicio.png") ?>
    </div>

    <div layout="row" flex class="middle">

        <div class="barraHerramientas" layout="column" layout-align="center center" ng-controller="ListHerramientas">
            <div layout="column" layout-align="center center" ng-repeat="item in tools"><img src="{{item.icon}}" alt="{{item.tool}}"></div>
        </div>

        <!-- ######################### CONTENIDO #############################33-->
        <ng-view layout="column" layout-padding flex></ng-view>

    </div>

    <div class="pie" layout="row" layout-align="start center" ng-controller="ListSecciones">
        <div layout="column" layout-align="center center" ng-repeat="item in secc"><img src="{{item.icon}}" alt="{{item.secc}}"></div>
    </div>

</div>


<?= HTML::script('js/settings.js') ?>
<?= HTML::script('js/app.js') ?>

</body>
</html>