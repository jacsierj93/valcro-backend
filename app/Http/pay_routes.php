<?php
/*
|--------------------------------------------------------------------------
| Application Routes servicios de pagos
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('payments/provList', 'Payments\PaymentController@getProvidersList'); ///lista de proveedores
$app->get('payments/typeList', 'Payments\PaymentController@getPaymentTypes'); ///tipos de pagos