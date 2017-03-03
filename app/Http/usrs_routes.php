<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$app->get('usrs/listUsrs', function() {
    return "algo";
});

$app->get('usrs/listUsuarios','Users\UserController@getUsuarios');

