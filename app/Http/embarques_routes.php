<?php

///sistema
$app->get('embarques/Notification', 'Embarques\EmbarquesController@getNotifications');

//providers
$app->get('embarques/Provider', 'Embarques\EmbarquesController@getProvList');

//Shipment
$app->get('embarques/Shipment', 'Embarques\EmbarquesController@getShipment');
$app->post('embarques/Save', 'Embarques\EmbarquesController@saveShipment');