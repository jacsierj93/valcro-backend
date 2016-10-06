<?php

$app->get('embarques/embqList', 'Embarques\EmbarquesController@getEmbarquesList');
$app->get('embarques/Provider', 'Embarques\EmbarquesController@getProvList');
$app->get('embarques/Shipment', 'Embarques\EmbarquesController@getShipment');