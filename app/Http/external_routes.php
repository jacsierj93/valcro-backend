<?php
use Illuminate\Http\Request;

$app->get("External/Email",function (Request $req){

    $uid= rand();
   /* if(!$req->session()->has('services')){
        $req->session()->put('services', ['email'=>[]]);
    }*/
    $req->session()->put('services.email', $req->all());
    $req->session()->put('services.email', $req->all());
    $req->session()->put('services.email', $req->all());
    if (!$req->session()->has('DATAUSER')) {
        redirect()->route('login');
    }else{
        return view("home");
    }

    dd($req);
});


