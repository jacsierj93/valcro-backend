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

$app->get('/', function () use ($app) {
    return $app->welcome();
});

$app->get('/hola', function () use ($app) {
    return "hola";
});


$app->get('/date', function () use ($app) {
    return date("Y-m-d H:i:s");
});

///////rutas de api de profit articulo
$app->get('articulo/{id}',"Api\\PrfArticuloController@getArtById");
$app->get('/api/info', 'Api\UserController@info');
$app->get('test', 'Admin\AccountController@main');
