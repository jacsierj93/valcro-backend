<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 05/05/2016
 * Time: 12:26
 */

///Providers

$app->get("provider/provList",'Providers\ProvidersController@getList'); ///obtener lista general de proveedores
$app->post("provider/saveProv",'Providers\ProvidersController@saveOrUpdateProv'); ///guarda datos basicos de un prov
$app->post("provider/getProv",'Providers\ProvidersController@getProv'); ///obtener datos especificos de un prov
$app->post("provider/saveProvAddr",'Providers\ProvidersController@saveProvDir'); ///guardar direccion de proveedor
$app->post("provider/saveValcroName",'Providers\ProvidersController@saveValcroName'); ///obtener listado de direcciones
$app->post("provider/delValcroName",'Providers\ProvidersController@delValcroName'); //elimina un nombre Valcro
$app->post("provider/saveContactProv",'Providers\ProvidersController@saveContact'); //guarda informacion de contacto
$app->post("provider/saveBank",'Providers\ProvidersController@saveInfoBank');//guarda la informacion bancaria de un proveedor
$app->post("provider/saveCoin",'Providers\ProvidersController@saveCoin');//guarda relacion con una moneda
$app->post("provider/delCoin",'Providers\ProvidersController@delCoin');//elimina la relacion con una moneda
$app->post("provider/saveLim",'Providers\ProvidersController@saveLimCred');//guarda o actualiza un limite de credito
$app->post("provider/saveConv",'Providers\ProvidersController@saveFactorConvert');//guarda o actualiza un factor de conversion
$app->post("provider/saveProdTime",'Providers\ProvidersController@saveProdTime');//guarda o actualiza un tiempo de porduccion
$app->post("provider/saveTransTime",'Providers\ProvidersController@saveProdTrans');//guarda o actualiza un tiempo de transporte

$app->get("provider/provNomValList/{provId}",'Providers\ProvidersController@listValcroName'); ///obtener lista general de proveedores
$app->get("provider/dirList/{id}",'Providers\ProvidersController@listProvAddr'); ///obtener listado de direcciones
$app->get("provider/contactProv/{provId}",'Providers\ProvidersController@listContacProv'); ///obtener listado contactos Proveedores
$app->get("provider/allContacts",'Providers\ProvidersController@allContacts');
$app->get("provider/getBankAccount/{id}",'Providers\ProvidersController@getBank');//obtener datos apra grid de cuentas bancarias
$app->get("provider/provCoins/{id}",'Providers\ProvidersController@getCoins');///obtener Monedas asignadas al proveedor
$app->get("provider/listCoin/{id}",'Providers\ProvidersController@assignCoin');//obtener Monedas asignadas al proveedor(solo id)
$app->get("provider/provLimits/{id}",'Providers\ProvidersController@getCreditLimits');//obtener limites de creditos asignados al proveedor
$app->get("provider/provFactors/{id}",'Providers\ProvidersController@getFactorConvers');//obtener factores de conversion asignados al proveedor
$app->get("provider/provCountries/{id}",'Providers\ProvidersController@provCountries');//obtener factores de conversion asignados al proveedor
$app->get("provider/prodTimes/{id}",'Providers\ProvidersController@getProdTime');//obtener factores de conversion asignados al proveedor
$app->get("provider/transTimes/{id}",'Providers\ProvidersController@getProdTrans');//obtener factores de conversion asignados al proveedor