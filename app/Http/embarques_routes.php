<?php
///sistema
$app->get('embarques/Notification', 'Embarques\EmbarquesController@getNotifications');
$app->get('embarques/Uncloset', 'Embarques\EmbarquesController@getUncloset');
$app->get('embarques/Test', 'Embarques\EmbarquesController@testPdf');
$app->get('embarques/html', 'Embarques\EmbarquesController@html');

//Tariff

$app->get('embarques/Country/Ports', 'Embarques\EmbarquesController@getPortCountry');
$app->get('embarques/Freight_Forwarder/List', 'Embarques\EmbarquesController@getFreightForwarder');
$app->get('embarques/Freight_Forwarder/Save', 'Embarques\EmbarquesController@saveFreightForwarder');
$app->get('embarques/Naviera/List', 'Embarques\EmbarquesController@getNaviera');
$app->get('embarques/Tariff/List', 'Embarques\EmbarquesController@getTariffs');
$app->post('embarques/Tariff/Save', 'Embarques\EmbarquesController@saveTariff');
$app->post('embarques/Tariff/Attachment', 'Embarques\EmbarquesController@setTarrifAttachment');

// tarfficct doc
$app->get('embarques/TariffDocs', 'Embarques\EmbarquesController@getTariffDocs');
$app->get('embarques/TariffDoc', 'Embarques\EmbarquesController@getTariffDoc');
$app->post('embarques/TariffDoc/Save', 'Embarques\EmbarquesController@saveTariffDoc');
$app->post('embarques/TariffDocItem/Save', 'Embarques\EmbarquesController@saveTariffDocItem');
$app->post('embarques/TariffDocItem/Delete', 'Embarques\EmbarquesController@deleteTariffDocItem');


// containers
$app->post('embarques/Container/Save', 'Embarques\EmbarquesController@saveContainer');
$app->post('embarques/Container/Delete', 'Embarques\EmbarquesController@DeleteContainer');


//providers
$app->get('embarques/Providers', 'Embarques\EmbarquesController@getProvList');
$app->get('embarques/Provider', 'Embarques\EmbarquesController@getProvider');
$app->get('embarques/Provider/Dir', 'Embarques\EmbarquesController@getProvDir');

// country
$app->get('embarques/Countrys', 'Embarques\EmbarquesController@getCountryList');
$app->get('embarques/Country', 'Embarques\EmbarquesController@getCountry');


//Shipment
$app->get('embarques/Shipment', 'Embarques\EmbarquesController@getShipment');
$app->post('embarques/Shipment/Close', 'Embarques\EmbarquesController@closeShipment');
$app->post('embarques/Shipment/Cancel', 'Embarques\EmbarquesController@cancelShipment');
$app->get('embarques/Shipment/Items', 'Embarques\EmbarquesController@getShipmentItems');
$app->get('embarques/Item/History', 'Embarques\EmbarquesController@getItemHistory');
$app->get('embarques/Shipments', 'Embarques\EmbarquesController@getShipments');
$app->get('embarques/Shipments/Finalize', 'Embarques\EmbarquesController@getShipmentsFinalize');
$app->get('embarques/Shipment/End', 'Embarques\EmbarquesController@getShipmentsEnd');
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

