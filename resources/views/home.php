<!DOCTYPE html>
<html lang="es" ng-app="MyApp">
<head>
    <title>Valcro Sistema</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1"/>
    <?= HTML::style("http://fonts.googleapis.com/css?family=Roboto:100,400,500,700,400italic") ?>
    <?= HTML::style("components/angular-material/angular-material.css") ?>
    <?= HTML::style("css/styles.css") ?>
    <?= HTML::style("css/pagos.css") ?>
    <?= HTML::style("components/font-awesome/css/font-awesome.min.css") ?>

    <?= HTML::script("components/jquery/dist/jquery.min.js") ?>
    <?= HTML::script("components/angular/angular.js") ?>
    <?= HTML::script("components/angular-resource/angular-resource.min.js") ?>
    <?= HTML::script("components/angular-route/angular-route.min.js") ?>
    <?= HTML::script("components/angular-animate/angular-animate.js") ?>
    <?= HTML::script("components/angular-aria/angular-aria.js") ?>
    <?= HTML::script("components/angular-messages/angular-messages.js") ?>
    <?= HTML::script("components/angular-material/angular-material.js") ?>

    <base href="/valcro-backend/public/">
</head>

<body id="inicio" ng-cloak layout="column" ng-controller="AppMain" style="overflow: hidden;">


<div class="cabezera" layout="row" layout-align="start center">
    <div layout layout-align="start center" style="width: 132px; height: 48px;">
        <?= HTML::image("images/logo_inicio.png") ?>
    </div>
    <div flex></div>
    <div layout layout-align="start center" style="width: 132px; height: 48px;">
        <a ng-href="logout">
            Salir
        </a>
    </div>
</div>


<div layout="row" flex class="middle">

    <div class="barraHerramientas" layout="column" layout-align="center center" ng-controller="ListHerramientas">

        <div layout="column" layout-align="center center" ng-repeat="item in tools">
            <div class="btnDot" title="{{item.tool}}"></div>
        </div>

    </div>

    <!-- ######################### CONTENIDO #############################-->
    <!--<ng-view layout="column" layout-padding flex></ng-view>-->
    <div id="contentHolder" flex ng-include="seccion.url" layout="column"></div>

</div>

<div class="pie" layout="row" layout-align="start center">

    <div layout="column" layout-align="center center" ng-repeat="item in secciones">
        <div class="btnDot" ng-click="seccLink(this)" title="{{item.secc}}"></div>
    </div>
    <div flex layout="row" layout-align="end center" style="font-size: 24px; font-weight: 100; color: #999999; padding-right: 24px;">
        {{seccion.secc}}
    </div>

</div>


<?= HTML::script('js/app.js') ?>
<?= HTML::script('js/appTemp.js') ?>
<?= HTML::script('js/modules/proveedores/proveedoresController.js') ?>
<?= HTML::script('js/modules/pagos/pagosController.js') ?>
</body>
</html>