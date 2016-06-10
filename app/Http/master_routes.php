<?php

$app->get("master/getCountries",'Masters\MasterController@getCountries'); ///obtener listado de paises
$app->get("master/getCountriesProvider",'Masters\MasterController@getCountriesHaveProvider'); ///obtener listado de paises donde tenemos provedores
$app->get("master/getProviderType",'Masters\MasterController@getProviderType'); ///obtener listado de tipos de proveedores
$app->get("master/getProviderTypeSend",'Masters\MasterController@getProviderTypeSend'); ///obtener listado de tipos de envio de proveedores
$app->get("master/getCoins",'Masters\MasterController@getCoins'); ///obtener listado de monedas
$app->get("master/getStates/{id}",'Masters\MasterController@getStates'); ///obtener listado de paises->estados
$app->get("master/getCities/{id}",'Masters\MasterController@getCities'); ///obtener listado de estados->ciudad
$app->get("master/getCoin/{id}",'Masters\MasterController@getCoin'); ///obtener una maneda
$app->get("master/addressType",'Masters\MasterController@getAddressType'); ///obtener tipo direccion
$app->get("master/prodLines",'Masters\MasterController@getLines'); ///obtener Lineas
$app->get("master/languajes",'Masters\MasterController@getLanguajes'); ///obtener Idiomas
$app->get("master/cargoContact",'Masters\MasterController@getCargos'); ///obtener Cargos
$app->get("master/getPorts",'Masters\MasterController@getPorts'); ///obtener Puertos
$app->get("master/getOrderReason",'Masters\MasterController@getReason'); ///obtener  motivo de pedido
$app->get("master/getOrderCondition",'Masters\MasterController@getCondition'); ///obtener condiciones de pedido
$app->get("master/getOrderStatus",'Masters\MasterController@getStatus'); ///obtener estado de pedidos
$app->get("master/getPaymentType",'Masters\MasterController@getPaymentType'); ///obtener tipos de pagos