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
    <?= HTML::style("components/font-awesome/css/font-awesome.min.css") ?>




    <base href="/angular/">
</head>

<body id="inicio" ng-cloak layout="column">


<div class="cabezera" layout="row" layout-align="start center">
    <?= HTML::image("images/logo_inicio.png") ?>
</div>


<div layout="row" flex class="middle">

    <div class="barraHerramientas" layout="column" layout-align="center center" ng-controller="ListHerramientas">

        <div layout="column" layout-align="center center" ng-repeat="item in tools">



            <img src="<?=url('images/btn_dot.png')?>" title="{{item.tool}}">
        </div>

    </div>
    <!--<md-content class="contenido" layout="column" layout-padding layout-align="end center" flex>
        <h1>Bienvenido!</h1>
        Para acceder a una seccion haga click en los puntos de larte inferior!
        <i class="fa fa-angle-down"></i>
    </md-content>-->
    <!-- ######################### CONTENIDO #############################33-->

    <ng-view layout="column" layout-padding flex></ng-view>


</div>

<div class="pie" layout="row" layout-align="start center" ng-controller="ListSecciones">

    <div layout="column" layout-align="center center" ng-repeat="item in secc"><img src="<?=url('images/btn_dot.png')?>" alt="{{item.secc}}"></div>

</div>

<?= HTML::script("components/jquery/dist/jquery.min.js") ?>
<?= HTML::script("components/angular/angular.js") ?>
<?= HTML::script("components/angular-resource/angular-resource.min.js") ?>
<?= HTML::script("components/angular-route/angular-route.min.js") ?>
<?= HTML::script("components/angular-animate/angular-animate.js") ?>
<?= HTML::script("components/angular-aria/angular-aria.js") ?>
<?= HTML::script("components/angular-messages/angular-messages.js") ?>
<?= HTML::script("components/angular-material/angular-material.js") ?>

<?= HTML::script('js/app.js') ?>
</body>
</html>