<?php
use Illuminate\Http\Request;

$app->get("External/Email",function (Request $req){
    $req->session()->put('external', $req->all());
    return redirect()->route('login');

});
$app->get("External/Get",function (Request $req){
    return $req->session()->get('external');

});
$app->get("External/Del",function (Request $req){
    for ($i = 0; $i< 5; $i++){
        $req->session()->forget('external');
    }

    return ['accion'=>'realizado'];
});


