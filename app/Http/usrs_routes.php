<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$app->get('usrs/listUsrs', function() {
    return "algo";
});
$app->get('usrs/usr', 'Api\UserController@actlUser');
// Usuarios --------------------------------------------------------------------
$app->get('usrs/listUsuarios','Users\UserController@getUsuarios');
$app->get('usrs/seltdUser/{id}','Users\UserController@seltdUser');
// Cargos ----------------------------------------------------------------------
$app->get('usrs/cargos/{id}', 'Users\UserController@getCargos');
// Niveles ---------------------------------------------------------------------
$app->get('usrs/niveles/{id}', 'Users\UserController@getNiveles');
// Niveles ---------------------------------------------------------------------
$app->get('usrs/estatus/{id}', 'Users\UserController@getEstatus');
// Guardar Usuarios ------------------------------------------------------------
$app->post("usrs/userSave",'Users\UserController@saveUser');