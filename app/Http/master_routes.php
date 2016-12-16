<?php

$app->get("master/getCountries",'Masters\MasterController@getCountries'); ///obtener listado de paises
$app->get("master/getCountriesProvider",'Masters\MasterController@getCountriesHaveProvider'); ///obtener listado de paises donde tenemos provedores
$app->get("master/getProviderType",'Masters\MasterController@getProviderType'); ///obtener listado de tipos de proveedores
$app->get("master/getProviderTypeSend",'Masters\MasterController@getProviderTypeSend'); ///obtener listado de tipos de envio de proveedores
$app->get("master/getCoins",'Masters\MasterController@getCoins'); ///obtener listado de monedas
$app->get("master/getStates/{id}",'Masters\MasterController@getStates'); ///obtener listado de paises->estados
$app->get("master/getCities/{id}",'Masters\MasterController@getCities'); ///obtener listado de estados->ciudad
$app->get("master/getCities",'Masters\MasterController@getAllCities'); ///obtener listado de estados->ciudad
$app->get("master/getCoin/{id}",'Masters\MasterController@getCoin'); ///obtener una maneda
$app->get("master/addressType",'Masters\MasterController@getAddressType'); ///obtener tipo direccion
$app->get("master/prodLines",'Masters\MasterController@getLines'); ///obtener Lineas
$app->get("master/prodSubLines",'Masters\MasterController@getSubLines'); ///obtener sub lineas Lineas @option param linea_id
$app->get("master/DirStores",'Masters\MasterController@getDirStoresValcro'); ///obtner la lista de direcciones de almacen de valcro
$app->get("master/languajes",'Masters\MasterController@getLanguajes'); ///obtener Idiomas
$app->get("master/cargoContact",'Masters\MasterController@getCargos'); ///obtener Cargos
$app->get("master/getPorts",'Masters\MasterController@getPorts'); ///obtener Puertos
$app->get("master/getOrderReason",'Masters\MasterController@getReason'); ///obtener  motivo de pedido
$app->get("master/getOrderCondition",'Masters\MasterController@getCondition'); ///obtener condiciones de pedido
$app->get("master/getOrderStatus",'Masters\MasterController@getStatus'); ///obtener estado de pedidos
$app->get("master/getPaymentType",'Masters\MasterController@getPaymentType'); ///obtener tipos de pagos
$app->post("master/search",'Masters\Compare@search'); ///obtener tipos de pagos
$app->post("master/newCoin",'Masters\MasterController@newCoin'); ///obtener tipos de pagos
$app->post("master/alerts/save",'Masters\MasterController@saveAlert'); ///sube un archivo al servidors
$app->post("master/alerts/save",'Masters\MasterController@saveAlert'); ///sube un archivo al servidors

$app->post("master/files/upload",'Masters\FilesController@uploadFile'); ///sube un archivo al servidors
$app->get("master/files/getFile",'Masters\FilesController@getFileId'); /// obtiene el archivo
$app->get("master/files/getFiles",'Masters\FilesController@getFiles'); ///obtiene todos los archivo

$app->get("master/mailModule/resend",'Masters\FilesController@resendMailModulo'); ///obtiene todos los archivo

