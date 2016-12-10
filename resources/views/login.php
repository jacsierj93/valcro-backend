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
    <?= HTML::script("components/angular-resource/angular-resource.min.js") ?>
    <?= HTML::script("components/angular-route/angular-route.min.js") ?>
    <?= HTML::script("components/angular-animate/angular-animate.js") ?>
    <?= HTML::script("components/angular-aria/angular-aria.js") ?>
    <?= HTML::script("components/angular-messages/angular-messages.js") ?>
    <?= HTML::script("components/angular-material/angular-material.js") ?>
    <?= HTML::script("components/angular-ui-mask/dist/mask.js") ?>
    <?= HTML::script("components/angular-input-masks/angular-input-masks-standalone.min.js") ?>
    <?= HTML::script("components/angular-sanitize/angular-sanitize.min.js") ?>

    <?= HTML::script("components/angular-io-barcode/build/angular-io-barcode.min.js") ?>

    <!--    custom click-out library, more ifo in file-->
    <?= HTML::script('js/modules/main/vlcClickOut.js') ?>
    <!--    demo file upload-->
    <?= HTML::script("components/ng-file-upload/ng-file-upload.min.js") ?>

    <base href="<?=$_SERVER['REQUEST_URI'] ?>">
</head>

<body id="login" ng-app="MyApp" ng-cloak layout="column"  >


    <div id="loginTop" flex layout layout-align="center center">

        <div class="msjBienvenida" layout layout-align="center center">
            “Casi todo lo que realice será</br>insignificante, PERO ES MUY</br>IMPORTANTE QUE LO HAGA”</br>Mahatma
            Gandhi.
        </div>

    </div>

    <div id="loginBottom" layout="row" >

        <div class="logoHolder" layout layout-align="center center">
            <?= HTML::image("images/login_logo.png") ?>
        </div>
        <div flex>
        </div>
        <form id="lgnForm" name="lgnForm" ng-controller="login" layout="column" layout-align="center center">
            <div class="row" layout="row">
                <md-input-container>
                    <label style="color: #ffffff">Usuario</label>
                    <input ng-model="user.usr" skip-tab name="usr" autocomplete="off" style="color: #ffffff"

                    >
                </md-input-container>
                <md-input-container>
                    <label style="color: #ffffff">Clave</label>
                    <input ng-model="user.pss" skip-tab name="pss" type="password" style="color: #ffffff"
                           ng-keypress="($event.which === 13)? lgn(): 0 "
                    >
                </md-input-container>
                <div class="btnHolder" style="height: auto" layout layout-align="center center">
                    <i class="fa fa-angle-right" ng-click="lgn()"></i>
                </div>
            </div>
        </form>
    </div>





<?= HTML::script('js/settings.js') ?>
<?= HTML::script('js/app.js') ?>

</body>
</html>