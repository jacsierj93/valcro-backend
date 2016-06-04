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


$app->get('payments/typeDocsList', 'Payments\DocumentController@getDocumentTypes'); ///tipos de documentos
$app->get('payments/payDocsList', 'Payments\DocumentController@getDocumentPayTypes'); ///tipos de documentos de pago
$app->get('payments/getDocById/{id}','Payments\DocumentController@getDocById'); ///selecciona un documento
$app->post('payments/saveAbono', 'Payments\DocumentController@abonoSaveOrUpdate'); ///guarda un documento de abono
$app->get('payments/getAbonos/{type}','Payments\DocumentController@getAbonoList'); ///trae los abonos a favor segun estatus

$app->get('payments/provList', 'Payments\PaymentController@getProvidersList'); ///lista de proveedores
$app->get('payments/typeList', 'Payments\PaymentController@getPaymentTypes'); ///tipos de pagos
$app->get('payments/getProv/{id}','Payments\PaymentController@getProvById'); ///selecciona un proveedor
$app->get('payments/provider/getBankAccounts','Payments\PaymentController@getProvBankAccounts'); ///lista de cuentas bancarias del proveedor
$app->post('payments/savePay', 'Payments\PaymentController@paySaveOrUpdate'); ///guarda un documento de abono

$app->post('payments/upload','Payments\DocumentController@testUpload');







