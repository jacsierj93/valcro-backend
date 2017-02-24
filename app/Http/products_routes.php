<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 08/12/16
 * Time: 05:49 PM
 */
$app->get("productos/provsProds",'Products\ProductController@getProviders');
$app->get("productos/prodsByProv/{id}",'Products\ProductController@listByProv');
$app->get("productos/getCriterio/{line}",'Criterio\CritController@getCriterio');

$app->post("productos/prodSave",'Products\ProductController@saveProd');
$app->post("productos/savePoints",'Products\ProductController@savePoint');
$app->post("productos/prodSaveCommon",'Products\ProductController@saveCommon');
$app->post("productos/prodDelCommon",'Products\ProductController@delCommon');
$app->post("productos/getFiltersProd",'Products\ProductController@filterProd');