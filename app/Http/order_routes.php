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


// pedidos
$app->post("Order/OrderProvList",'Orders\OrderController@getProviderList'); ///lista de todos los proveedores
$app->post("Order/OrderFilterData",'Orders\OrderController@getFilterData'); ///llenado de filtros a proveedores
$app->post("Order/Order",'Orders\OrderController@getOrden'); ///llenado de filtros a proveedores
$app->post("Order/OrderProvOrder",'Orders\OrderController@getProviderListOrder'); ///lista de todos los pedidos de un proveedor segun su id
$app->post("Order/OrderDataForm",'Orders\OrderController@getForm'); //data para el llenado de formulario
$app->post("Order/ProviderOrder",'Orders\OrderController@getProviderOrder'); ///Obtiene todas las ordenes de compra de un proveedor segun su id
$app->post("Order/PurchaseOrder",'Orders\OrderController@getPurchaseOrder'); ///obtiene una orden de compra segun su id
$app->post("Order/ProviderCountry",'Orders\OrderController@getProviderCountry'); ///obtine los paises donde un proveedor tiene almacenes
$app->post("Order/ProviderCoins",'Orders\OrderController@getProviderCoins'); ///obtine las monedas de un proveedor
$app->post("Order/ProviderPaymentCondition",'Orders\OrderController@getProviderPaymentCondition'); ///obtiene las condiciones de pago a proveedor
$app->post("Order/ProviderAdressStore",'Orders\OrderController@getProviderAdressStore'); ///obtiene las direcciones de almacen de un proveedor
$app->post("Order/Address",'Orders\OrderController@getAddressCountry'); ///obtiene las direcciones de almacen de un proveedor en un pais
$app->post("Order/Save",'Orders\OrderController@saveOrUpdate'); ///guarda el pedido
$app->post("Order/Del",'Orders\OrderController@delete'); ///elimina el pedido
$app->post("Order/RemovePurchaseOrder",'Orders\OrderController@removePurchaseOrder'); ///elimina el pedido
$app->post("Order/AddPurchaseOrder",'Orders\OrderController@addPurchaseOrder'); ///elimina el pedido
$app->post("Order/CustomOrders",'Orders\OrderController@getCustomOrders'); /// obtiene los contra pedidos de proveedor
$app->post("Order/KitchenBoxs",'Orders\OrderController@getKitchenBoxs'); /// obtiene las kitchen box de proveedor
$app->post("Order/RemoveCustomOrder",'Orders\OrderController@removeCustomOrder'); ///elimina el pedido
$app->post("Order/AddCustomOrder",'Orders\OrderController@addCustomOrder'); ///elimina el pedido
$app->post("Order/RemovekitchenBox",'Orders\OrderController@removekitchenBox'); ///elimina el pedido
$app->post("Order/AddkitchenBox",'Orders\OrderController@addkitchenBox'); ///elimina el pedido