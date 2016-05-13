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
$app->get('payments/typeDocsList', 'Payments\PaymentController@getDocumentTypes'); ///tipos de documentos
$app->get('payments/payDocsList', 'Payments\PaymentController@getDocumentPayTypes'); ///tipos de documentos de pago

$app->get('payments/getProv/{id}','Payments\PaymentController@getProvById'); ///selecciona un proveedor
$app->get('payments/getDocById/{id}','Payments\PaymentController@getDocById'); ///selecciona un documento
$app->get('payments/getAbonos','Payments\PaymentController@getAbonoList'); ///trae los pagos a favor
$app->post('payments/saveAbono', 'Payments\PaymentController@abonoSaveOrUpdate'); ///guarda un documento de abono




