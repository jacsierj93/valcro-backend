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

//form
$app->get("Order/Order",'Orders\OrderController@getOrden'); ///trae tod el detalle de pedido
$app->get("Order/OrderProvList",'Orders\OrderController@getProviderList'); ///lista de todos los proveedores
$app->get("Order/OrderFilterData",'Orders\OrderController@getFilterData'); ///llenado de filtros a proveedores
$app->get("Order/OrderProvOrder",'Orders\OrderController@getProviderListOrder'); ///lista de todos los pedidos de un proveedor segun su id
$app->get("Order/OrderDataForm",'Orders\OrderController@getForm'); //data para el llenado de formulario
$app->get("Order/ProviderPaymentCondition",'Orders\OrderController@getProviderPaymentCondition'); ///obtiene las condiciones de pago a proveedor
$app->get("Order/ProviderAdressStore",'Orders\OrderController@getProviderAdressStore'); ///obtiene las direcciones de almacen de un proveedor
$app->get("Order/Address",'Orders\OrderController@getAddressCountry'); ///obtiene las direcciones de almacen de un proveedor en un pais
$app->get("Order/ProviderCountry",'Orders\OrderController@getProviderCountry'); ///obtine los paises donde un proveedor tiene almacenes
$app->get("Order/AdrressPorts",'Orders\OrderController@getAddressrPort'); ///obtine los paises donde un proveedor tiene almacenes
$app->get("Order/ProviderProds",'Orders\OrderController@getProviderProducts'); ///obtine los paises donde un proveedor tiene almacenes
$app->get("Order/Document",'Orders\OrderController@getDocument'); ///obtiene el documento

//pedidos
$app->post("Order/Save",'Orders\OrderController@saveOrder'); ///guarda el pedido

//Orden de compra
$app->post("PurchaseOrder/Save",'Orders\OrderController@savePurchaseOrder'); ///guarda el pedido
$app->get("PurchaseOrder/Get",'Orders\OrderController@getPurchaseOrder'); ///guarda el pedido

// solicitudes
$app->post("Solicitude/Save",'Orders\OrderController@saveSolicitude'); ///guarda el pedido
$app->get("Solicitude/Get",'Orders\OrderController@getSolicitude'); ///guarda el pedido


//Genericos
$app->post("Order/RemoveToOrden",'Orders\OrderController@removeToOrden'); ///trae tod el detalle de contraPedido
$app->post("Order/RemoveOrdenItem",'Orders\OrderController@removeOrderItem'); ///trae tod el detalle de contraPedido
$app->post("Order/EditOrdenItem",'Orders\OrderController@EditPedido'); ///trae tod el detalle de contraPedido


// contra pedidos
$app->get("Order/CustomOrder",'Orders\OrderController@getCustomOrder'); ///trae tod el detalle de contraPedido
$app->get("Order/CustomOrderReason",'Orders\OrderController@getCustomOrderResons'); ///trae tod el detalle de contraPedido
$app->get("Order/CustomOrderPriority",'Orders\OrderController@getCustomOrderPriority'); ///trae tod el detalle de contraPedido
$app->post("Order/RemoveCustomOrder",'Orders\OrderController@removeCustomOrder'); ///elimina el contra pedido
$app->post("Order/AddCustomOrder",'Orders\OrderController@addCustomOrder'); ///agrega el  contrapedido
$app->post("Order/AddCustomOrderItem",'Orders\OrderController@addCustomOrderItem'); ///agrega un item de contra pedido
$app->post("Order/RemoveCustomOrderItem",'Orders\OrderController@removeCustomOrderItem'); ///agrega un item de contra pedido
$app->get("Order/CustomOrders",'Orders\OrderController@getCustomOrders'); /// obtiene los contra pedidos de proveedor

// kitchenBox
$app->get("Order/KitchenBox/{id}",'Orders\OrderController@getKitchenBox'); ///trae tod el detalle de contraPedido
$app->get("Order/KitchenBoxs",'Orders\OrderController@getKitchenBoxs'); /// obtiene las kitchen box de proveedor
$app->post("Order/AddkitchenBox",'Orders\OrderController@addkitchenBox'); /// obtiene las kitchen box de proveedor
$app->post("Order/RemovekitchenBox",'Orders\OrderController@removekitchenBox'); /// obtiene las kitchen box de proveedor

// pedido a  sustituir
$app->get("Order/OrderSubstitutes",'Orders\OrderController@getOrderSubstituteOrder'); ///lista de todos los pedidos que se úeden sustituir
$app->post("Order/RemoveOrderSubstitute",'Orders\OrderController@removeOrderSubstitute'); ///elimina todo el pedido sustituto
$app->post("Order/AddOrderSubstitute",'Orders\OrderController@addOrderSubstitute'); ///agrega todo el pedido sustituto
$app->post("Order/AddOrderSubstituteItem",'Orders\OrderController@OrderSubstituteItem'); ///agrega todo el pedido sustituto
$app->get("Order/OrderSubstitute",'Orders\OrderController@getOrderSustitute'); ///agrega el pedido sustituto

// sin uso
$app->post("Order/Del",'Orders\OrderController@delete'); ///elimina el pedido
$app->get("Order/test",'Orders\OrderController@test'); ///elimina el pedido

//deprecated
$app->post("Order/ProviderOrder",'Orders\OrderController@getProviderOrder'); ///Obtiene todas las ordenes de compra de un proveedor segun su id
$app->post("Order/PurchaseOrder",'Orders\OrderController@getPurchaseOrder'); ///obtiene una orden de compra segun su id
$app->post("Order/RemovePurchaseOrder",'Orders\OrderController@removePurchaseOrder'); ///elimina el pedido
$app->post("Order/AddPurchaseOrder",'Orders\OrderController@addPurchaseOrder'); ///elimina el pedido




