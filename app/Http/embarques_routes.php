<?php
///sistema
$app->get('embarques/Notification', 'Embarques\EmbarquesController@getNotifications');
$app->get('embarques/Uncloset', 'Embarques\EmbarquesController@getUncloset');

//Tariff
$app->get('embarques/Country/Ports', 'Embarques\EmbarquesController@getPortCountry');
$app->get('embarques/Tariff/List', 'Embarques\EmbarquesController@getTariffs');
$app->get('embarques/Freight_Forwarder/List', 'Embarques\EmbarquesController@getFreightForwarder');
$app->get('embarques/Naviera/List', 'Embarques\EmbarquesController@getNaviera');
$app->post('embarques/Tariff/Save', 'Embarques\EmbarquesController@saveTariff');

// containers
$app->post('embarques/Container/Save', 'Embarques\EmbarquesController@saveContainer');
$app->post('embarques/Container/Delete', 'Embarques\EmbarquesController@DeleteContainer');


//providers
$app->get('embarques/Provider', 'Embarques\EmbarquesController@getProvList');
$app->get('embarques/Provider/Dir', 'Embarques\EmbarquesController@getProvDir');

//Shipment
$app->get('embarques/Shipment', 'Embarques\EmbarquesController@getShipment');
$app->get('embarques/Shipment/Items', 'Embarques\EmbarquesController@getShipmentItems');
$app->get('embarques/Shipments', 'Embarques\EmbarquesController@getShipments');
$app->get('embarques/Shipment/Dates', 'Embarques\EmbarquesController@CalShipmentDates');
$app->post('embarques/Shipment/SaveDates', 'Embarques\EmbarquesController@saveShipmentDates');
$app->post('embarques/Save', 'Embarques\EmbarquesController@saveShipment');
$app->post('embarques/Attachment/Save', 'Embarques\EmbarquesController@SaveAttachment');
$app->post('embarques/OrderItem/Save', 'Embarques\EmbarquesController@SaveOrderItem');
$app->post('embarques/OrderItem/Delete', 'Embarques\EmbarquesController@DeleteOrderItem');
$app->post('embarques/Order/Save', 'Embarques\EmbarquesController@SaveOrder');
$app->post('embarques/Order/Delete', 'Embarques\EmbarquesController@DeleteOrder');

//ODC
$app->get('embarques/Order/List', 'Embarques\EmbarquesController@getOrdersForAsignment');
$app->get('embarques/Order/Asigment', 'Embarques\EmbarquesController@getOrdersAsignment');
$app->get('embarques/Order/Order', 'Embarques\EmbarquesController@getOrder');


//productos odc
$app->get('embarques/Order/Products', 'Embarques\EmbarquesController@getFinishedProduc');

// products
$app->post('embarques/Product/CreateOnAdd', 'Embarques\EmbarquesController@createOnSaveProduct');

