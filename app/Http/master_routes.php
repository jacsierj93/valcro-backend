<?php

$app->get("master/getCountries",'Masters\MasterController@getCountries'); ///obtener listado de paises
$app->get("master/getProviderType",'Masters\MasterController@getProviderType'); ///obtener listado de tipos de proveedores
$app->get("master/getProviderTypeSend",'Masters\MasterController@getProviderTypeSend'); ///obtener listado de tipos de envio de proveedores
$app->get("master/getCoins",'Masters\MasterController@getCoins'); ///obtener listado de monedas
$app->get("master/getStates/{id}",'Masters\MasterController@getStates'); ///obtener listado de paises->estados
$app->get("master/getCities/{id}",'Masters\MasterController@getCities'); ///obtener listado de estados->ciudad
$app->get("master/getCoin/{id}",'Masters\MasterController@getCoin'); ///obtener una maneda
$app->get("master/addressType",'Masters\MasterController@getAddressType'); ///obtener una maneda
$app->post("master/getCountries",'Masters\MasterController@getCountries'); ///obtener lista general de proveedores

