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
$app->get("Order/UnClosetDoc",'Orders\OrderController@getUnClosetDocument'); ///trae los docuemntos que no tengan final id
$app->get("Order/OldReviewDocs",'Orders\OrderController@getOldReviewDoc'); ///trae los docuemntos que tienen que ser revisados
$app->get("Order/Notifications",'Orders\OrderController@getNotifications'); ///trae los mensajes del sistema

//Genericos
$app->post("Order/RemoveToOrden",'Orders\OrderController@removeToOrden'); /// @deprecated
$app->post("Order/RemoveOrdenItem",'Orders\OrderController@removeOrderItem'); ///
$app->post("Order/EditOrdenItem",'Orders\OrderController@EditPedido'); //

//otros modulos
$app->get("Order/InvoiceAddress",'Orders\OrderController@getInvoiceAddressCountry'); ///obtiene las direcciones de facturacion
$app->get("Order/StoreAddress",'Orders\OrderController@getStoreAddressCountry'); ///obtiene las direcciones de almacen
$app->get("Order/ProviderEmails",'Orders\OrderController@getProviderEmails'); ///obtiene los correo de un proveedor
$app->get("Order/Emails",'Orders\OrderController@getEmails'); ///obtiene las direcciones de almacen
$app->post("Order/Mailsend",'Orders\OrderController@sendMail'); ///envia el correo

//$app->get("Order/CloseAction",'Orders\OrderController@closeAction'); ///obtiene los correo de un proveedor

//form
$app->get("Order/Order",'Orders\OrderController@getOrden'); ///@deprecated
$app->get("Order/OrderProvList",'Orders\OrderController@getProviderList'); ///lista de todos los proveedores
$app->get("Order/Provider",'Orders\OrderController@getProvider'); /// detalle de estado de un proveedor
$app->get("Order/OrderProvCount",'Orders\OrderController@countProvider'); ///@deprecated
$app->get("Order/OrderFilterData",'Orders\OrderController@getFilterData'); ///@deprecated
$app->get("Order/OrderProvOrder",'Orders\OrderController@getProviderListOrder'); ///lista de todos los pedidos de un proveedor segun su id
$app->get("Order/OrderDataForm",'Orders\OrderController@getForm'); //data para el llenado de formulario
$app->get("Order/ProviderPaymentCondition",'Orders\OrderController@getProviderPaymentCondition'); ///obtiene las condiciones de pago a proveedor
$app->get("Order/ProviderAdressStore",'Orders\OrderController@getProviderAdressStore'); ///@deprecated
$app->get("Order/ProviderCountry",'Orders\OrderController@getProviderCountry'); ///obtine los paises donde un proveedor tiene almacenes
$app->get("Order/AdrressPorts",'Orders\OrderController@getAddressrPort'); ///obtine lospuertos de un proveedor
$app->get("Order/ProviderProds",'Orders\OrderController@getProviderProducts'); ///obtine los produtos de un proveedor
$app->get("Order/CustomOrders",'Orders\OrderController@getCustomOrders'); /// obtiene los contra pedidos de proveedor
$app->get("Order/CustomOrder",'Orders\OrderController@getCustomOrder'); ///trae tod el detalle de contraPedido


// import
$app->get("Order/SolicitudeToImport",'Orders\OrderController@getSolicitudeToImport'); /// obtiens las solicitudes aptas para importar
$app->get("Order/OrderToImport",'Orders\OrderController@getOrderToImport'); /// obtien los pedidos(Proforma) q son aptas para importar

// compare
$app->get("Order/BetweenOrderToSolicitud",'Orders\OrderController@getDiffbetweenSolicitudToOrder'); /// campara y trae las diferencias entre un pedido(Proforma y una solicitud)
$app->get("Order/BetweenOrderToPurchase",'Orders\OrderController@getDiffbetweenOrderToPurchase'); /// compara y trae las diferncias entre un Pedido(Proforma) y una orden de copra


$app->post("Order/CreateTemp",'Orders\OrderController@createTemp'); ///crea un producto temporal
$app->get("Order/Document",'Orders\OrderController@getDocument'); ///obtiene el documento


//pedidos
$app->post("Order/Order/Save",'Orders\OrderController@saveOrder'); ///guarda la solicitud
$app->post("Order/Order/AdddRemoveItem",'Orders\OrderController@addRemoveOrderItem'); ///asigna y remove item a l solicitud
$app->post("Order/Order/ChangeItem",'Orders\OrderController@changeItemOrder'); ///actuliza el item de solicitud
$app->post("Order/Order/AddCustomOrder",'Orders\OrderController@addCustomOrderOrder'); ///agrega el contra pedido
$app->post("Order/Order/RemoveCustomOrder",'Orders\OrderController@RemoveCustomOrderOrder'); ///remueve un contra pedido de un pedido
$app->post("Order/Order/AddkitchenBox",'Orders\OrderController@addkitchenBoxOrder'); ///agrega un kitchen box
$app->post("Order/Order/RemovekitchenBox",'Orders\OrderController@removekitchenBoxOrder'); ///quita  kitchen box
$app->post("Order/Order/SetStatus",'Orders\OrderController@setStatusOrder'); // cambia el estado del documento
$app->post("Order/Order/AdddRemoveItems",'Orders\OrderController@addRemoveOrderItems'); // agrega y quita items a la solicud por lotes
$app->post("Order/Order/Close",'Orders\OrderController@CloseOrder'); // cierra el documento y notifica por correo
$app->post("Order/Order/SetParent",'Orders\OrderController@setParentOrder'); // cierra el documento y notifica por correo
$app->post("Order/Order/AddSustitute",'Orders\OrderController@addSustituteOrder'); // add un solicitud vieja a un anueva
$app->post("Order/Order/RemoveSustitute",'Orders\OrderController@removeSustiteOrder'); // quita la solicitud anterio
$app->post("Order/Order/AddAdjuntos",'Orders\OrderController@addAttachmentsOrder'); ///agrega adjuntos al pedido
$app->post("Order/Order/Update",'Orders\OrderController@UpdateOrder'); ///retira el final id y notifica que se actualizara el documento
$app->post("Order/Order/Copy",'Orders\OrderController@copyOrder'); /// crea una copia sin adjuntos
$app->post("Order/Order/AddAnswer",'Orders\OrderController@AddAnswerOrder'); /// agrega una respuesta tipo snoze a al a proforma
$app->post("Order/Order/ApprovedPurchases",'Orders\OrderController@ApprovedPurchasesOrder'); /// realiza la aprobacion por comprass
$app->post("Order/Order/Cancel",'Orders\OrderController@cancelOrder'); /// cancela el pedido
$app->post("Order/Order/ProductChange",'Orders\OrderController@changeProductoOrden'); /// cambia un producto item
$app->post("Order/Order/Restore",'Orders\OrderController@restoreOrden'); /// restaura a una version anterior
$app->post("Order/Order/Send",'Orders\OrderController@sendOrder'); /// envia la solicitud al proveedor
$app->post("Order/Order/CloseAction",'Orders\OrderController@closeActionOrder'); /// define que acion se debe realizar para cerrar la accion


$app->get("Order/Order/Substitutes",'Orders\OrderController@getOrderSubstitutes'); ///lista de todos los pedidos que se peden sustituir
$app->get("Order/Order/Summary",'Orders\OrderController@getOrderSummary'); /// trae el resumen final de un pedido
$app->get("Order/Order/Versions",'Orders\OrderController@getOldOrden'); /// trae todas las versiones que a generado el documento
$app->get("Order/Order/EmailEstimate",'Orders\OrderController@EmailEstimateOrder'); ///trau preview del  presupuesto a enviar al provedor
$app->get("Order/Order/EmailSummary",'Orders\OrderController@EmailSummaryDocDocOrder'); ///trau preview de el resumen del documento


//Orden de compra
$app->post("Order/Purchase/Save",'Orders\OrderController@savePurchaseOrder'); ///guarda  la orden de compra
$app->post("Order/Purchase/AdddRemoveItem",'Orders\OrderController@addRemovePurchaseItem'); ///asigna y remove item a l solicitud
$app->post("Order/Purchase/ChangeItem",'Orders\OrderController@changeItemPurchase'); ///actuliza el item de solicitud
$app->post("Order/Purchase/AddCustomOrder",'Orders\OrderController@addCustomOrderPurchase'); //  agrega un contra pedido a la orden de compra
$app->post("Order/Purchase/RemoveCustomOrder",'Orders\OrderController@RemoveCustomOrderPurchase'); // remove el contra pedido
$app->post("Order/Purchase/AddkitchenBox",'Orders\OrderController@addkitchenBoxPurchase'); /// agrga un kitchen box
$app->post("Order/Purchase/RemovekitchenBox",'Orders\OrderController@removekitchenBoxPurchase'); ///quita  kitchen box
$app->post("Order/Purchase/SetStatus",'Orders\OrderController@setStatusPurchase'); // cambia el estado del documento
$app->post("Order/Purchase/AdddRemoveItems",'Orders\OrderController@addRemovePurchaseItems'); // agrega y quita items a la solicud por lotes
$app->post("Order/Purchase/Close",'Orders\OrderController@ClosePurchase'); // cierra el documento y notifica por correo
$app->post("Order/Purchase/SetParent",'Orders\OrderController@setParentPurchase'); // asigna el paren a la orden de compra
$app->post("Order/Purchase/AddSustitute",'Orders\OrderController@addPurchaseOrder'); // agrega un sustito
$app->post("Order/Purchase/RemoveSustitute",'Orders\OrderController@removePurchaseOrder'); // quita la orden de compra
$app->post("Order/Purchase/AddAdjuntos",'Orders\OrderController@addAttachmentsPurchase'); ///agrega adjuntos a la orden de compra
$app->post("Order/Purchase/Update",'Orders\OrderController@PurchaseUpdate'); /// marca la orden de compra como temporar
$app->post("Order/Purchase/Copy",'Orders\OrderController@copyPurchase'); /// crea una copia de la orden de compra sina adjutos
$app->post("Order/Purchase/AddProdConditionPay",'Orders\OrderController@addProdConditionPurchase'); //@exception//agrega una cndicion de pago a un producto
$app->post("Order/Purchase/RemoveProdConditionPay",'Orders\OrderController@removeProdConditionPurchase'); //@exception//agrega una cndicion de pago a un producto
$app->post("Order/Purchase/AddAnswer",'Orders\OrderController@AddAnswerPurchase'); ///agrega una respuesta tipo snoze a la orden de compra
$app->post("Order/Purchase/ApprovedPurchases",'Orders\OrderController@ApprovedPurchasesPurchase'); // agreaga la aprobacion por compras
$app->post("Order/Purchase/Cancel",'Orders\OrderController@cancelPurchase'); /// Cancela el documento
$app->post("Order/Purchase/ProductChange",'Orders\OrderController@changeProductoPurchase'); // cambia el producto
$app->post("Order/Purchase/Restore",'Orders\OrderController@restorePurchase'); /// restaura a una version anterior
$app->post("Order/Purchase/Send",'Orders\OrderController@sendPurchase'); /// envia la solicitud al proveedor
$app->post("Order/Purchase/Create",'Orders\OrderController@CreatePurchase'); /// envia la solicitud al proveedor
$app->post("Order/Purchase/CloseAction",'Orders\OrderController@closeActionPurchase'); /// define que acion se debe realizar para cerrar la accion


$app->get("Order/Purchase/Substitutes",'Orders\OrderController@getPurchaseSubstitutes'); ///lista de todos las ordenes de compra que se púeden sustituir
$app->get("Order/Purchase/Versions",'Orders\OrderController@getOldPurchase'); /// trae todas las versiones que a generado el documento
$app->get("Order/Purchase/Summary",'Orders\OrderController@getPurchaseSummary'); ///resumen final de la orden de compra
$app->get("Order/Purchase/EmailEstimate",'Orders\OrderController@EmailEstimatePurchase'); ///trau preview del  presupuesto a enviar al provedor
$app->get("Order/Purchase/EmailSummary",'Orders\OrderController@EmailSummaryDocPurchase'); ///trau preview del  presupuesto a enviar al provedor



// solicitudes
$app->post("Order/Solicitude/Save",'Orders\OrderController@saveSolicitude'); ///guarda la solicitud
$app->post("Order/Solicitude/AdddRemoveItem",'Orders\OrderController@addRemoveSolicitudItem'); ///asigna y remove item a l solicitud
$app->post("Order/Solicitude/ChangeItem",'Orders\OrderController@changeItemSolicitude'); /// camia el item de la solicitud
$app->post("Order/Solicitude/AddCustomOrder",'Orders\OrderController@addCustomOrderSolicitud'); ///agrega aun contra pedido
$app->post("Order/Solicitude/RemoveCustomOrder",'Orders\OrderController@RemoveCustomOrderSolicitud'); // remove un contra pedido
$app->post("Order/Solicitude/AddkitchenBox",'Orders\OrderController@addkitchenBoxSolicitude'); ///agrega u kitchen box
$app->post("Order/Solicitude/RemovekitchenBox",'Orders\OrderController@removekitchenBoxSolicitude'); ///quita  kitchen box
$app->post("Order/Solicitude/AdddRemoveItems",'Orders\OrderController@addRemoveSolicitudItems'); // agrega y quita items a la solicud por lotes
$app->post("Order/Solicitude/SetStatus",'Orders\OrderController@setStatusSolicitude'); // cambia el estado del documento
$app->post("Order/Solicitude/Close",'Orders\OrderController@CloseSolicitude'); // cierra el documento y notifica por correo
$app->post("Order/Solicitude/SetParent",'Orders\OrderController@setParentSolicitude'); // asigna un nuevo paren al docuemnto
$app->post("Order/Solicitude/AddSustitute",'Orders\OrderController@addSustituteSolicitude'); // agrega un aolicitud vieja a una nueva
$app->post("Order/Solicitude/RemoveSustitute",'Orders\OrderController@removeSustiteSolicitude'); // quita la solicitud anterior
$app->post("Order/Solicitude/Copy",'Orders\OrderController@copySolicitude'); ///crea un a copia de la solicutd sin adjuntos
$app->post("Order/Solicitude/AddAdjuntos",'Orders\OrderController@addAttachmentsSolicitude'); /// agrega adjuntos a la solicitud
$app->post("Order/Solicitude/Update",'Orders\OrderController@SolicitudeUpdate'); //// coloca la solicitud en un estado de edicio
$app->post("Order/Solicitude/AddAnswer",'Orders\OrderController@AddAnswerSolicitude'); ///agrega una respuesta a la solicutd
$app->post("Order/Solicitude/ApprovedPurchases",'Orders\OrderController@ApprovedPurchasesSolicitude'); ///agrega la aprobacion de compras
$app->post("Order/Solicitude/Cancel",'Orders\OrderController@cancelSolicitude'); /// cancela la solicitud
$app->post("Order/Solicitude/ProductChange",'Orders\OrderController@changeProductoSolicitud'); /// actualiza un producto de solicitude
$app->post("Order/Solicitude/Restore",'Orders\OrderController@restoreSolicitude'); /// restaura a una version anterior
$app->post("Order/Solicitude/Send",'Orders\OrderController@sendSolicitude'); /// envia la solicitud al proveedor
$app->post("Order/Solicitude/Create",'Orders\OrderController@CreateSolicitude'); /// envia la solicitud al proveedor
$app->post("Order/Solicitude/CloseAction",'Orders\OrderController@closeActionSolicitude'); /// define que acion se debe realizar para cerrar la accion


$app->get("Order/Solicitude/Substitutes",'Orders\OrderController@getSolicitudeSubstitutes'); ///lista de todos las solicitudes que son sustituibles
$app->get("Order/Solicitude/Summary",'Orders\OrderController@getSolicitudeSummary'); ///tre el resulme final de la solicutd
$app->get("Order/Solicitude/Versions",'Orders\OrderController@getOldSolicitude'); /// trae todas las versiones que a generado el documento
$app->get("Order/Solicitude/EmailEstimate",'Orders\OrderController@EmailEstimateSolicitude'); ///trau preview del  presupuesto a enviar al provedor
$app->get("Order/Solicitude/EmailSummary",'Orders\OrderController@EmailSummaryDocSolicitude'); ///trau preview del  presupuesto a enviar al provedor


$app->get("Solicitude/Get",'Orders\OrderController@getSolicitude'); ///guarda el pedido @deprecated

// contra pedidos
$app->get("Order/CustomOrderReview",'Orders\OrderController@getCustomOrderReview'); ///trae tod el detalle de contraPedido
$app->get("Order/CustomOrderReason",'Orders\OrderController@getCustomOrderResons'); ///trae los motivos de contrapedido
$app->get("Order/CustomOrderPriority",'Orders\OrderController@getCustomOrderPriority'); ///trae tod el detalle de contraPedido

$app->post("Order/RemoveCustomOrder",'Orders\OrderController@removeCustomOrder'); ///elimina el contra pedido @deprecated
$app->post("Order/AddCustomOrderItem",'Orders\OrderController@addCustomOrderItem'); ///agrega un item de contra pedido @deprecated
$app->post("Order/RemoveCustomOrderItem",'Orders\OrderController@removeCustomOrderItem'); ///agrega un item de contra pedido @deprecated

// kitchenBox
$app->get("Order/KitchenBoxReview",'Orders\OrderController@getKitchenBoxReview'); ///trae tod el detalle de kitchenbo @deprecated

$app->get("Order/KitchenBox",'Orders\OrderController@getKitchenBox'); ///trae tod el detalle de kitchenbox
$app->get("Order/KitchenBoxs",'Orders\OrderController@getKitchenBoxs'); /// obtiene las kitchen box de proveedor
$app->post("Order/AddkitchenBox",'Orders\OrderController@addkitchenBox'); /// obtiene las kitchen box de proveedor@deprecated
$app->post("Order/RemovekitchenBox",'Orders\OrderController@removekitchenBox'); /// obtiene las kitchen box de proveedor@deprecated

// pedido a  sustituir
$app->post("Order/RemoveOrderSubstitute",'Orders\OrderController@removeOrderSubstitute'); ///elimina todo el pedido sustituto @deprecated
$app->post("Order/AddOrderSubstitute",'Orders\OrderController@addOrderSubstitute'); ///agrega todo el pedido sustituto @deprecated
$app->post("Order/AddOrderSubstituteItem",'Orders\OrderController@OrderSubstituteItem'); ///agrega todo el pedido sustituto@deprecated
$app->get("Order/OrderSubstitute",'Orders\OrderController@getOrderSustitute'); ///agrega el pedido sustituto

// sin uso
$app->post("Order/Del",'Orders\OrderController@delete'); ///elimina el pedido @deprecated
$app->get("Order/test",'Orders\OrderController@test'); ///elimina el pedido @deprecated


//deprecated
$app->post("Order/ProviderOrder",'Orders\OrderController@getProviderOrder'); ///Obtiene todas las ordenes de compra de un proveedor segun su id
$app->post("Order/PurchaseOrder",'Orders\OrderController@getPurchaseOrder'); ///obtiene una orden de compra segun su id
$app->post("Order/RemovePurchaseOrder",'Orders\OrderController@removePurchaseOrder'); ///elimina el pedido
$app->post("Order/AddPurchaseOrder",'Orders\OrderController@addPurchaseOrder'); ///elimina el pedido
$app->get("Order/mail",'Orders\OrderController@getMail'); ///elimina el pedido




