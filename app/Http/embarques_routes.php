<?php

$app->get('embarques/embqList', 'Embarques\EmbarquesController@getEmbarquesList');
$app->get('embarques/Provider', 'Embarques\EmbarquesController@getProvList');