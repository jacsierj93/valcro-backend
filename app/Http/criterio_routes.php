<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 20/10/16
 * Time: 04:41 PM
 */
$app->get("criterio/avaiableLines",'Criterio\CritController@getAvaiableLines');
$app->get("criterio/optionLists",'Criterio\CritController@getListType');
$app->get("criterio/fieldList",'Criterio\CritController@getCampos');
$app->get("criterio/typeList",'Criterio\CritController@getTypes');
$app->get("criterio/getCriteria",'Criterio\CritController@getCriterio');
$app->post("criterio/save",'Criterio\CritController@saveCritField');
$app->post("criterio/saveOptions",'Criterio\CritController@saveOptions');
$app->post("criterio/createLine",'Criterio\CritController@createLine');
$app->post("criterio/saveNewItemList",'Criterio\CritController@createOptionList');
