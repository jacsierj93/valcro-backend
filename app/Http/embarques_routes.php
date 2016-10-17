<?php
///sistema
$app->get('embarques/Notification', 'Embarques\EmbarquesController@getNotifications');
$app->get('embarques/Uncloset', 'Embarques\EmbarquesController@getUncloset');

//Tariff
$app->get('embarques/CountryPorts', 'Embarques\EmbarquesController@getPortCountry');
$app->post('embarques/TariffSave', 'Embarques\EmbarquesController@saveTariff');
$app->get('embarques/Tariffs', 'Embarques\EmbarquesController@getTariffs');


//providers
$app->get('embarques/Provider', 'Embarques\EmbarquesController@getProvList');
$app->get('embarques/ProviderDir', 'Embarques\EmbarquesController@getProvDir');

//Shipment
$app->get('embarques/Shipment', 'Embarques\EmbarquesController@getShipment');
$app->post('embarques/Save', 'Embarques\EmbarquesController@saveShipment');