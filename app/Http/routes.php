<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$app->get('/hola', function () use ($app) {
    return "hola";
});


$app->get('/date', function () use ($app) {
    return date("Y-m-d H:i:s");
});

$app->get('pass/{word}','Api\UserController@newPass');

///////rutas de api de profit articulo
$app->get('articulo/{id}',"Api\\PrfArticuloController@getArtById");

$app->get('profit', 'Api\\PrfArticuloController@getProductosProfit');

$app->get('contraPedido', 'Api\\PrfArticuloController@execSP');

$app->get('/api/info', 'Api\UserController@info');
$app->get('test', 'Admin\AccountController@main');


/**
 * rutas de la administración
 * con AdminLTE
 */

$app->get('/', 'Account\AccountController@main'); ///pagina principal
$app->get('/login', [
    'as' => 'login', 'uses' => 'Account\AccountController@showLogin'
]); ///login
$app->post("api/user/login",'Api\UserController@login'); ///login api
$app->get('/logout', 'Account\AccountController@logout'); ///logout


