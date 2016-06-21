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
// systema
$app->get("Order/UnClosetDoc",'Orders\OrderController@getUnClosetDocument'); ///trae tod el detalle de pedido



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
$app->get("Order/CustomOrders",'Orders\OrderController@getCustomOrders'); /// obtiene los contra pedidos de proveedor
$app->get("Order/CustomOrder",'Orders\OrderController@getCustomOrder'); ///trae tod el detalle de contraPedido


// import
$app->get("Order/SolicitudeToImport",'Orders\OrderController@getSolicitudeToImport'); ///obtine los paises donde un proveedor tiene almacenes
$app->get("Order/OrderToImport",'Orders\OrderController@getOrderToImport'); ///obtine los paises donde un proveedor tiene almacenes

// compare
$app->get("Order/BetweenOrderToSolicitud",'Orders\OrderController@getDiffbetweenSolicitudToOrder'); ///obtine los paises donde un proveedor tiene almacenes
$app->get("Order/BetweenOrderToPurchase",'Orders\OrderController@getDiffbetweenOrderToPurchase'); ///obtine los paises donde un proveedor tiene almacenes

// productos

$app->post("Order/CreateTemp",'Orders\OrderController@createTemp'); ///crea un producto temporar
$app->post("Order/Solicitude/ProductChange",'Orders\OrderController@changeProductoSolicitud'); ///guarda el pedido
$app->post("Order/Purchase/ProductChange",'Orders\OrderController@changeProductoPurchase'); ///guarda el pedido
$app->post("Order/Order/ProductChange",'Orders\OrderController@changeProductoOrden'); ///guarda el pedido


$app->get("Order/Document",'Orders\OrderController@getDocument'); ///obtiene el documento
//$app->get("Order/DocumentsImport",'Orders\OrderController@getDocumentsToImport'); ///obtiene el documento
$app->post("Order/DocumentCopy",'Orders\OrderController@copyDoc'); ///guarda el pedido

//pedidos
$app->post("Order/Order/Save",'Orders\OrderController@saveOrder'); ///guarda la solicitud
$app->post("Order/Order/AdddRemoveItem",'Orders\OrderController@addRemoveOrderItem'); ///asigna y remove item a l solicitud
$app->post("Order/Order/ChangeItem",'Orders\OrderController@changeItemOrder'); ///actuliza el item de solicitud
$app->post("Order/Order/AddCustomOrder",'Orders\OrderController@addCustomOrderOrder'); ///agrega el contra pedido
$app->post("Order/Order/RemoveCustomOrder",'Orders\OrderController@RemoveCustomOrderOrder'); ///actuliza el item de solicitud
$app->post("Order/Order/AddkitchenBox",'Orders\OrderController@addkitchenBoxOrder'); ///agrega un kitchen box
$app->post("Order/Order/RemovekitchenBox",'Orders\OrderController@removekitchenBoxOrder'); ///quita  kitchen box
$app->get("Order/Order/Substitutes",'Orders\OrderController@getOrderSubstitutes'); ///lista de todos los pedidos que se úeden sustituir
$app->post("Order/Order/SetStatus",'Orders\OrderController@setStatusOrder'); // cambia el estado del documento
$app->post("Order/Order/AdddRemoveItems",'Orders\OrderController@addRemoveOrderItems'); // agrega y quita items a la solicud por lotes
$app->post("Order/Order/Close",'Orders\OrderController@CloseOrder'); // cierra el documento y notifica por correo
$app->post("Order/Order/SetParent",'Orders\OrderController@setParentOrder'); // cierra el documento y notifica por correo




//Orden de compra
$app->post("Order/Purchase/Save",'Orders\OrderController@savePurchaseOrder'); ///guarda el pedido
$app->post("Order/Purchase/AdddRemoveItem",'Orders\OrderController@addRemovePurchaseItem'); ///asigna y remove item a l solicitud
$app->post("Order/Purchase/ChangeItem",'Orders\OrderController@changeItemPurchase'); ///actuliza el item de solicitud
$app->post("Order/Purchase/AddCustomOrder",'Orders\OrderController@addCustomOrderPurchase'); ///actuliza el item de solicitud
$app->post("Order/Purchase/RemoveCustomOrder",'Orders\OrderController@RemoveCustomOrderPurchase'); ///actuliza el item de solicitud
$app->post("Order/Purchase/AddkitchenBox",'Orders\OrderController@addkitchenBoxPurchase'); ///actuliza el item de solicitud
$app->post("Order/Purchase/RemovekitchenBox",'Orders\OrderController@removekitchenBoxPurchase'); ///quita  kitchen box
$app->get("Order/Purchase/Substitutes",'Orders\OrderController@getPurchaseSubstitutes'); ///lista de todos los pedidos que se úeden sustituir
$app->post("Order/Purchase/SetStatus",'Orders\OrderController@setStatusPurchase'); // cambia el estado del documento
$app->post("Order/Purchase/AdddRemoveItems",'Orders\OrderController@addRemovePurchaseItems'); // agrega y quita items a la solicud por lotes
$app->post("Order/Purchase/Close",'Orders\OrderController@ClosePurchase'); // cierra el documento y notifica por correo
$app->post("Order/Purchase/SetParent",'Orders\OrderController@setParentPurchase'); // cierra el documento y notifica por correo




// solicitudes
$app->post("Order/Solicitude/Save",'Orders\OrderController@saveSolicitude'); ///guarda la solicitud
$app->post("Order/Solicitude/AdddRemoveItem",'Orders\OrderController@addRemoveSolicitudItem'); ///asigna y remove item a l solicitud
$app->post("Order/Solicitude/ChangeItem",'Orders\OrderController@changeItemSolicitude'); ///actuliza el item de solicitud
$app->post("Order/Solicitude/AddCustomOrder",'Orders\OrderController@addCustomOrderSolicitud'); ///actuliza el item de solicitud
$app->post("Order/Solicitude/RemoveCustomOrder",'Orders\OrderController@RemoveCustomOrderSolicitud'); ///actuliza el item de solicitud
$app->post("Order/Solicitude/AddkitchenBox",'Orders\OrderController@addkitchenBoxSolicitude'); ///actuliza el item de solicitud
$app->post("Order/Solicitude/RemovekitchenBox",'Orders\OrderController@removekitchenBoxSolicitude'); ///quita  kitchen box
$app->post("Order/Solicitude/AdddRemoveItems",'Orders\OrderController@addRemoveSolicitudItems'); // agrega y quita items a la solicud por lotes
$app->post("Order/Solicitude/SetStatus",'Orders\OrderController@setStatusSolicitude'); // cambia el estado del documento
$app->post("Order/Solicitude/Close",'Orders\OrderController@CloseSolicitude'); // cierra el documento y notifica por correo
$app->post("Order/Solicitude/SetParent",'Orders\OrderController@setParentSolicitude'); // cierra el documento y notifica por correo
$app->post("Order/Solicitude/Replace",'Orders\OrderController@replaceSolicitude'); // reemplaza la solicutud

$app->post("Order/Solicitude/Copy",'Orders\OrderController@copySolicitude'); ///lista de todos los pedidos que se úeden sustituir

$app->get("Order/Solicitude/Substitutes",'Orders\OrderController@getSolicitudeSubstitutes'); ///lista de todos los pedidos que se úeden sustituir





$app->get("Solicitude/Get",'Orders\OrderController@getSolicitude'); ///guarda el pedido

//Genericos
$app->post("Order/RemoveToOrden",'Orders\OrderController@removeToOrden'); ///trae tod el detalle de contraPedido
$app->post("Order/RemoveOrdenItem",'Orders\OrderController@removeOrderItem'); ///trae tod el detalle de contraPedido
$app->post("Order/EditOrdenItem",'Orders\OrderController@EditPedido'); ///trae tod el detalle de contraPedido
//$app->post("Order/Copy",'Orders\OrderController@copyDoc'); ///trae tod el detalle de contraPedido



// contra pedidos
$app->get("Order/CustomOrderReason",'Orders\OrderController@getCustomOrderResons'); ///trae los motivos de contrapedido
$app->get("Order/CustomOrderPriority",'Orders\OrderController@getCustomOrderPriority'); ///trae tod el detalle de contraPedido
$app->post("Order/RemoveCustomOrder",'Orders\OrderController@removeCustomOrder'); ///elimina el contra pedido
$app->post("Order/AddCustomOrderItem",'Orders\OrderController@addCustomOrderItem'); ///agrega un item de contra pedido
$app->post("Order/RemoveCustomOrderItem",'Orders\OrderController@removeCustomOrderItem'); ///agrega un item de contra pedido

// kitchenBox
$app->get("Order/KitchenBox",'Orders\OrderController@getKitchenBox'); ///trae tod el detalle de kitchenbox
$app->get("Order/KitchenBoxs",'Orders\OrderController@getKitchenBoxs'); /// obtiene las kitchen box de proveedor
$app->post("Order/AddkitchenBox",'Orders\OrderController@addkitchenBox'); /// obtiene las kitchen box de proveedor
$app->post("Order/RemovekitchenBox",'Orders\OrderController@removekitchenBox'); /// obtiene las kitchen box de proveedor

// pedido a  sustituir
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




