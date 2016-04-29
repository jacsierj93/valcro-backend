<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/



$app->get('/hola', function () use ($app) {
    return "hola";
});


$app->get('/date', function () use ($app) {
    return date("Y-m-d H:i:s");
});

$app->get('pass/{word}','Api\UserController@newPass');

///////rutas de api de profit articulo
$app->get('articulo/{id}',"Api\\PrfArticuloController@getArtById");

$app->get('profit', 'Api\\PrfArticuloController@getProductosProfit');

$app->get('contraPedido', 'Api\\PrfArticuloController@execSP');

$app->get('/api/info', 'Api\UserController@info');
$app->get('test', 'Admin\AccountController@main');


/**
 * rutas de la administración
 * con AdminLTE
 */

$app->get('/', 'Account\AccountController@main'); ///pagina principal


$app->get('/angular', 'Account\AccountController@prueba'); ///pagina principal

$app->get('login', [
    'as' => 'login', 'uses' => 'Account\AccountController@showLogin'
]); ///login
$app->post("api/user/login",'Api\UserController@login'); ///login api
$app->get('logout', 'Account\AccountController@logout'); ///logout

////carga de vistas dinamica
$app->get('/modules/{resource}/{action}', function ($resource, $action) {
    return view("/modules/$resource/$action");
});



////usuarios
$app->get('users/usersList', 'Users\UserController@getList'); ///lista de usuarios
$app->get('users/userForm', 'Users\UserController@getForm'); ///form de usuarios
$app->post('users/saveOrUpdate', 'Users\UserController@saveOrUpdate'); ///guardar usuario
$app->post('users/savePrefs', 'Users\UserController@savePreferences'); ///guardar usuario prefs
$app->post("users/userDel",'Users\UserController@delete'); ///borrar usuario

/////cargos
$app->get('catalogs/positionForm', 'Catalogs\PositionController@getForm'); ///form de cargos
$app->get('catalogs/positionList', 'Catalogs\PositionController@getList'); ///lista de cargos
$app->post("catalogs/positionSave",'Catalogs\PositionController@saveOrUpdate'); ///guardar cargo
$app->post("catalogs/positionDel",'Catalogs\PositionController@delete'); ///borrar cargo

////departamentos
$app->get('catalogs/departamentList', 'Catalogs\DepartamentController@getList'); ///lista de dep
$app->get('catalogs/departamentForm', 'Catalogs\DepartamentController@getForm'); ///nuevo dep
$app->post("catalogs/departamentSave",'Catalogs\DepartamentController@saveOrUpdate'); ///guardar dep
$app->post("catalogs/departamentDel",'Catalogs\DepartamentController@delete'); ///borrar dep

/////sucursal
$app->get('catalogs/sucursalForm', 'Catalogs\SucursalController@getForm'); ///form
$app->get('catalogs/sucursalList', 'Catalogs\SucursalController@getList'); ///lista
$app->post("catalogs/sucursalSave",'Catalogs\SucursalController@saveOrUpdate'); ///guardar
$app->post("catalogs/sucursalDel",'Catalogs\SucursalController@delete'); ///borrar


////tipo de provedores
$app->get('catalogs/providerTypesList', 'Catalogs\ProviderTypesController@getList'); ///lista de tipo de prov
$app->get('catalogs/providerTypesForm', 'Catalogs\ProviderTypesController@getForm'); ///nuevo tipo prov
$app->post("catalogs/providerTypesSave",'Catalogs\ProviderTypesController@saveOrUpdate'); ///guardar tipo prov
$app->post("catalogs/providerTypesDel",'Catalogs\ProviderTypesController@delete'); ///borrar tipo prov

////Condiciones de Pago por Proveedo
$app->get('catalogs/CondPagoProvList', 'Catalogs\ProviderPayconditionController@getList'); ///lista de tipo de prov
$app->get('catalogs/CondPagoProvForm', 'Catalogs\ProviderPayconditionController@getForm'); ///nuevo tipo prov
$app->post("catalogs/CondPagoProvSave",'Catalogs\ProviderPayconditionController@saveOrUpdate'); ///guardar tipo prov
$app->post("catalogs/CondPagoProvItems",'Catalogs\ProviderPayconditionController@getItems'); ///guardar tipo prov
$app->post("catalogs/CondPagoProvDel",'Catalogs\ProviderPayconditionController@delete'); ///borrar tipo prov

////tipo de envio
$app->get('catalogs/providerTypesSendList', 'Catalogs\ProviderTypesSendController@getList'); ///lista de tipo de envio
$app->get('catalogs/providerTypesSendForm', 'Catalogs\ProviderTypesSendController@getForm'); ///nuevo tipo de envio
$app->post("catalogs/providerTypesSendSave",'Catalogs\ProviderTypesSendController@saveOrUpdate'); ///guardar tipo envio
$app->post("catalogs/providerTypesSendDel",'Catalogs\ProviderTypesSendController@delete'); ///borrar tipo envio

///Tiempo aproximado de transito
$app->get('catalogs/tiemAproTranList', 'Catalogs\ProvTiemAproTranController@getList'); ///lista de tiempo aproximado de transito
$app->get('catalogs/tiemAproTranForm', 'Catalogs\ProvTiemAproTranController@getForm'); ///nuevo tiempo aproximado d transito
$app->post("catalogs/tiemAproTranSave",'Catalogs\ProvTiemAproTranController@saveOrUpdate'); ///guardar tiempo apro. transito
$app->post("catalogs/tiemAproTranDel",'Catalogs\ProvTiemAproTranController@delete'); ///borrar tiempo aprox. trans.


///Providers

$app->get("provider/provList",'Providers\ProvidersController@getList'); ///obtener lista general de proveedores
$app->post("provider/saveProv",'Providers\ProvidersController@saveOrUpdateProv'); ///obtener lista general de proveedores
$app->post("provider/getProv",'Providers\ProvidersController@getProv'); ///obtener datos especificos de un prov
$app->post("provider/saveProvAddr",'Providers\ProvidersController@saveProvDir'); ///obtener datos especificos de un prov
$app->post("provider/saveValcroName",'Providers\ProvidersController@saveValcroName'); ///obtener listado de direcciones
$app->post("provider/delValcroName",'Providers\ProvidersController@delValcroName');
$app->post("provider/saveContactProv",'Providers\ProvidersController@saveContact');
$app->get("provider/provNomValList/{provId}",'Providers\ProvidersController@listValcroName'); ///obtener lista general de proveedores
$app->get("provider/dirList/{id}",'Providers\ProvidersController@listProvAddr'); ///obtener listado de direcciones
$app->get("provider/contactProv/{provId}",'Providers\ProvidersController@listContacProv'); ///obtener listado contactos Proveedores
$app->get("provider/allContacts",'Providers\ProvidersController@allContacts');

//MASTERS
$app->get("master/getCountries",'Masters\MasterController@getCountries'); ///obtener listado de paises
$app->get("master/getProviderType",'Masters\MasterController@getProviderType'); ///obtener listado de tipos de proveedores
$app->get("master/getProviderTypeSend",'Masters\MasterController@getProviderTypeSend'); ///obtener listado de tipos de envio de proveedores
$app->get("master/getCoins",'Masters\MasterController@getCoins'); ///obtener listado de monedas
$app->get("master/fullCountries",'Masters\MasterController@getFullCountry'); ///obtener listado de paises->estados->ciudades

///contactos-proveedores
$app->get("contactos/contList",'Proveedores\ProveedorController@listContactos'); ///obtener lista general de contactos
$app->get("getProviderCoin/monedaList",'Proveedores\ProveedorController@listMonedas'); ///obtener lista general de MONEDAS
$app->get("monedasProv/monedaProvList",'Proveedores\ProveedorController@Monedas'); ///obtener lista general


$app->get("creditoProv/creditoProvList",'Proveedores\ProveedorController@listLimitCred'); ///obtener lista general
$app->get("factConvProv/factorProvList",'Proveedores\ProveedorController@listConvPro'); ///obtener lista general



////tipo de provedores
$app->get('catalogs/providerTypesList', 'Catalogs\ProviderTypesController@getList'); ///lista de tipo de prov
$app->get('catalogs/providerTypesForm', 'Catalogs\ProviderTypesController@getForm'); ///nuevo tipo prov
$app->post("catalogs/providerTypesSave",'Catalogs\ProviderTypesController@saveOrUpdate'); ///guardar tipo prov
$app->post("catalogs/providerTypesDel",'Catalogs\ProviderTypesController@delete'); ///borrar tipo prov

////Condiciones de Pago por Proveedo
$app->get('catalogs/CondPagoProvList', 'Catalogs\ProviderPayconditionController@getList'); ///lista de tipo de prov
$app->get('catalogs/CondPagoProvForm', 'Catalogs\ProviderPayconditionController@getForm'); ///nuevo tipo prov
$app->post("catalogs/CondPagoProvSave",'Catalogs\ProviderPayconditionController@saveOrUpdate'); ///guardar tipo prov
$app->post("catalogs/CondPagoProvItems",'Catalogs\ProviderPayconditionController@getItems'); ///guardar tipo prov
$app->post("catalogs/CondPagoProvDel",'Catalogs\ProviderPayconditionController@delete'); ///borrar tipo prov

////tipo de envio
$app->get('catalogs/providerTypesSendList', 'Catalogs\ProviderTypesSendController@getList'); ///lista de tipo de envio
$app->get('catalogs/providerTypesSendForm', 'Catalogs\ProviderTypesSendController@getForm'); ///nuevo tipo de envio
$app->post("catalogs/providerTypesSendSave",'Catalogs\ProviderTypesSendController@saveOrUpdate'); ///guardar tipo envio
$app->post("catalogs/providerTypesSendDel",'Catalogs\ProviderTypesSendController@delete'); ///borrar tipo envio

///Tiempo aproximado de transito
$app->get('catalogs/tiemAproTranList', 'Catalogs\ProvTiemAproTranController@getList'); ///lista de tiempo aproximado de transito
$app->get('catalogs/tiemAproTranForm', 'Catalogs\ProvTiemAproTranController@getForm'); ///nuevo tiempo aproximado d transito
$app->post("catalogs/tiemAproTranSave",'Catalogs\ProvTiemAproTranController@saveOrUpdate'); ///guardar tiempo apro. transito
$app->post("catalogs/tiemAproTranDel",'Catalogs\ProvTiemAproTranController@delete'); ///borrar tiempo aprox. trans.


///Proveedores

$app->post("proveedores/provList",'Proveedores\ProveedorController@getList'); ///obtener lista general de proveedores
$app->post("proveedores/provNomValList",'Proveedores\ProveedorController@provNombreval'); ///obtener lista general de proveedores
$app->post("proveedores/getProv",'Proveedores\ProveedorController@getProv'); ///obtener datos especificos de un prov

//MASTERS
$app->post("master/getCountries",'Masters\MasterController@getCountries'); ///obtener lista general de proveedores
///contactos-proveedores
$app->get("contactos/contList",'Proveedores\ProveedorController@listContactos'); ///obtener lista general de contactos
$app->get("getProviderCoin/monedaList",'Proveedores\ProveedorController@listMonedas'); ///obtener lista general de MONEDAS
$app->get("monedasProv/monedaProvList",'Proveedores\ProveedorController@Monedas'); ///obtener lista general

//******Maestro de tipos de pago******/
$app->get('catalogs/PayTypesList', 'Catalogs\PayTypesController@getList'); ///lista de tiempo aproximado de transito
$app->get('catalogs/PayTypesForm', 'Catalogs\PayTypesController@getForm'); ///nuevo tiempo aproximado d transito
$app->post("catalogs/PayTypesSave",'Catalogs\PayTypesController@saveOrUpdate'); ///guardar tiempo apro. transito
$app->post("catalogs/PayTypesDel",'Catalogs\PayTypesController@delete'); ///borrar tiempo aprox. trans.


//******Maestro de tipo de docuemnto de compra******/
$app->get('catalogs/PurchasingDocumentTypeList', 'Catalogs\PurchasingDocumentTypeController@getList'); ///lista
$app->get('catalogs/PurchasingDocumentTypeForm', 'Catalogs\PurchasingDocumentTypeController@getForm'); ///form
$app->post("catalogs/PurchasingDocumentTypeSave",'Catalogs\PurchasingDocumentTypeController@saveOrUpdate'); ///guardar o editar
$app->post("catalogs/PurchasingDocumentTypeDel",'Catalogs\PurchasingDocumentTypeController@delete'); ///borrar


//******Orden de compra******/
$app->get('catalogs/PurchasingOrderList', 'Purchases\PurchasingOrderController@getList'); ///lista
$app->get('catalogs/PurchasingOrderForm', 'Purchases\PurchasingOrderController@getForm'); ///form
$app->post("catalogs/PurchasingOrderSave",'Purchases\PurchasingOrderController@saveOrUpdate'); ///guardar o editar
$app->post("catalogs/PurchasingOrderDel",'Purchases\PurchasingOrderController@delete'); ///borrar


/******Pedidos *****/
$app->get('catalogs/OrderProviderList', 'Purchases\OrderController@getListForm'); ///view for
$app->get('catalogs/OrderForm', 'Purchases\OrderController@getForm'); ///form
$app->post("catalogs/OrderSave",'Purchases\OrderController@saveOrUpdate'); ///guardar o editar
$app->post("catalogs/OrderDel",'Purchases\OrderController@delete'); ///borrar
$app->post('catalogs/OrderList', 'Purchases\OrderController@getList'); ///lista

//anexar a Proveedores
$app->post("catalogs/ProviderOrder",'Purchases\OrderController@getProviderOrder'); ///ontiene los pedidos de un proveedor de provedor
$app->post("catalogs/ProviderCountry",'Purchases\OrderController@getProviderCountry'); ///ontiene los pedidos de un proveedor de provedor
$app->post("catalogs/ProviderCoins",'Purchases\OrderController@getProviderCoins'); ///ontiene los pedidos de un proveedor de provedor
$app->post("catalogs/ProviderProduct",'Purchases\PurchasingOrderController@getProviderProduct'); ///getProductos de provedor
$app->post("catalogs/ProviderAdressStore",'Purchases\OrderController@getProviderAdressStore'); ///getProductos de provedor
$app->post("catalogs/ProviderPaymentCondition",'Purchases\OrderController@getProviderPaymentCondition'); ///getProductos de provedor


//anexar a Orden
$app->post("catalogs/PurchaseOrder",'Purchases\OrderController@getPurchaseOrder'); ///getProductos de provedor
//

// pedidos
$app->post("Order/OrderProvList",'Orders\OrderController@getProviderList'); ///lista de todos los proveedores
$app->post("Order/OrderFilterData",'Orders\OrderController@getFilterData'); ///lista de todos los proveedores
$app->post("Order/OrderProvOrder",'Orders\OrderController@getProviderListOrder'); ///lista de todos los pedidos de un proveedor segun su id
$app->post("Order/OrderDataForm",'Orders\OrderController@getForm'); //data para el llenado de formulario
$app->post("Order/ProviderOrder",'Orders\OrderController@getProviderOrder'); ///Obtiene todas las ordenes de compra de un proveedor segun su id
$app->post("Order/PurchaseOrder",'Orders\OrderController@getPurchaseOrder'); ///obtiene una orden de compra segun su id
$app->post("Order/ProviderCountry",'Orders\OrderController@getProviderCountry'); ///obtine los paises donde un proveedor tiene almacenes
$app->post("Order/ProviderCoins",'Orders\OrderController@getProviderCoins'); ///obtine las monedas de un proveedor
$app->post("Order/ProviderPaymentCondition",'Orders\OrderController@getProviderPaymentCondition'); ///obtiene las condiciones de pago a proveedor
$app->post("Order/ProviderAdressStore",'Orders\OrderController@getProviderAdressStore'); ///obtiene las direcciones de almacen de un proveedor
$app->post("Order/Save",'Orders\OrderController@saveOrUpdate'); ///guarda el pedido
$app->post("Order/Del",'Orders\OrderController@delete'); ///elimina el pedido
$app->post("Order/RemovePurchaseOrder",'Orders\OrderController@removePurchaseOrder'); ///elimina el pedido
$app->post("Order/AddPurchaseOrder",'Orders\OrderController@addPurchaseOrder'); ///elimina el pedido
