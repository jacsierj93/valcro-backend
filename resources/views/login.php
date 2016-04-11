<!DOCTYPE html>
<html lang="en">
<head>
    <title>Valcro Sistema</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1"/>
    <?=HTML::style("http://fonts.googleapis.com/css?family=Roboto:400,500,700,400italic") ?>
    <?=HTML::style("components/angular-material/angular-material.css") ?>
    <?=HTML::style("css/styles.css") ?>
    <?=HTML::style("components/font-awesome/css/font-awesome.min.css") ?>

    <?=HTML::script("components/angular/angular.js") ?>
    <?=HTML::script("components/angular-animate/angular-animate.js") ?>
    <?=HTML::script("components/angular-aria/angular-aria.js") ?>
    <?=HTML::script("components/angular-messages/angular-messages.js") ?>
    <?=HTML::script("components/angular-material/angular-material.js") ?>


</head>

<body id="login" ng-app="MyApp" ng-cloak layout="column">

<div id="loginTop" flex layout layout-align="center center">

    <div class="msjBienvenida" layout layout-align="center center">
        “Casi todo lo que realice será</br>insignificante, PERO ES MUY</br>IMPORTANTE QUE LO HAGA”</br>Mahatma Gandhi.
    </div>

</div>

<div id="loginBottom" layout="row" ng-controller="login">

    <div class="logoHolder" layout layout-align="center center">
        <?=HTML::image("images/login_logo.png") ?>
    </div>
    <div flex>
    </div>
    <md-input-container>
        <label style="color: #ffffff">Usuario</label>
        <input ng-model="user.usr"  style="color: #ffffff">
    </md-input-container>
    <md-input-container>
        <label  style="color: #ffffff">Clave</label>
        <input ng-model="user.pss" type="password" style="color: #ffffff">
    </md-input-container>
    <div class="btnHolder" layout layout-align="center center">
        <i class="fa fa-angle-right"></i>
    </div>
</div>


<?=HTML::script('js/app.js')?>

</body>
</html>