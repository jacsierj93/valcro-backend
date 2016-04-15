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
$app->get('login', [
    'as' => 'login', 'uses' => 'Account\AccountController@showLogin'
]); ///login
$app->post("api/user/login",'Api\UserController@login'); ///login api
$app->get('logout', 'Account\AccountController@logout'); ///logout


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


///Proveedores

$app->get("proveedores/provList",'Proveedores\ProveedorController@getList'); ///obtener lista general de proveedores
$app->get("proveedores/provNomValList",'Proveedores\ProveedorController@provNombreval'); ///obtener lista general de proveedores
$app->get("proveedores/getToken",'Proveedores\ProveedorController@gettoken'); ///obtener lista general de proveedores

///contactos-proveedores
$app->get("contactos/contList",'Proveedores\ProveedorController@listContactos'); ///obtener lista general de contactos
$app->get("monedas/monedaList",'Proveedores\ProveedorController@listMonedas'); ///obtener lista general de MONEDAS
$app->get("monedasProv/monedaProvList",'Proveedores\ProveedorController@Monedas'); ///obtener lista general


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

$app->get("proveedores/provList",'Proveedores\ProveedorController@getList'); ///obtener lista general de proveedores
$app->get("proveedores/provNomValList",'Proveedores\ProveedorController@provNombreval'); ///obtener lista general de proveedores
$app->get("proveedores/getToken",'Proveedores\ProveedorController@gettoken'); ///obtener lista general de proveedores

///contactos-proveedores
$app->get("contactos/contList",'Proveedores\ProveedorController@listContactos'); ///obtener lista general de contactos
$app->get("monedas/monedaList",'Proveedores\ProveedorController@listMonedas'); ///obtener lista general de MONEDAS
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
$app->get('catalogs/PurchasingOrderList', 'Catalogs\PurchasingOrderController@getList'); ///lista
$app->get('catalogs/PurchasingOrderForm', 'Catalogs\PurchasingOrderController@getForm'); ///form
$app->post("catalogs/PurchasingOrderSave",'Catalogs\PurchasingOrderController@saveOrUpdate'); ///guardar o editar
$app->post("catalogs/PurchasingOrderDel",'Catalogs\PurchasingOrderController@delete'); ///borrar
$app->post("catalogs/ProviderProduct",'Catalogs\PurchasingOrderController@getProviderProduct'); ///getProductos de provedor


