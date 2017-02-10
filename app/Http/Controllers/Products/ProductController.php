<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 08/12/16
 * Time: 04:13 PM
 */

namespace App\Http\Controllers\Products;


use App\Models\Sistema\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Product\Product;
use Illuminate\Support\Facades\Auth;

class ProductController  extends BaseController
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function getProviders(Request $rq){

        return Provider::has("proveedor_product")->lists("id");
    }

    public function listByProv($prov){

        $all = Product::with("prov")
            ->with(array("line"=>function($query){
                return $query->selectRaw("id,linea");
            }))
            ->with(array("subLin"=>function($q){
                return $q->selectRaw("id,sublinea");
            }))
            ->with(array("getType"=>function($q){
                return $q->selectRaw("id,descripcion");
            }))
            ->with(array("prodCrit"=>function($q){
                return $q->selectRaw("crit_id,value");
            }))
            ->where("prov_id",$prov)
            ->distinct("id")
            ->get();

        return json_encode($all);
    }
/*
    public function getDetail($prov){

        return Product::with("prov")
            ->with("line")
            ->with("subLin")
            ->with("getType")
            ->where("prov_id",$prov)
            ->distinct("id")
            ->get();


    }*/

    public function saveProd(Request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $prod =  Product::findOrFail($req->id);
            $result['action']="upd";
        }else{
            $prod =  new Product();
        }

        $prod->prov_id = $req->prov;
        $prod->codigo = $req->cod;
        $prod->linea_id = $req->line;
        $prod->descripcion = $req->desc;
        $prod->serie = $req->serie;
        if($prod->isDirty()){
            $prod->save();
        }else{
            $result['action']="equal";
        }
        $result['id']=$prod->id;
        $crit= self::purge($req->prodCrit);
        $afected = $prod->prodCrit()->sync($crit);
        if(((count($afected['attached'])>0) || (count($afected['detached'])>0) || (count($afected['updated'])>0)) && $result['action']=="equal"){
            $result['action']="upd";
        }

        return $result;
    }

    private function purge($data){
        foreach ($data as $k=>$dat){
            unset($data[$k]["childs"]);
            if($data[$k] == null || $data[$k]['value']==""){
                unset($data[$k]);
            }
        }
        return $data;

        /*$result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $prod =  Product::findOrFail($req->id);
            $result['action']="upd";
        }else{
            $prod =  new Product();
        }
        $prod->prov_id = $req->prov;
        $prod->codigo = $req->cod;
        $prod->linea_id = $req->line;
        $prod->descripcion = $req->desc;
        $prod->serie = $req->serie;

        $prod->save();
        $result['id']=$prod->id;
        return $result;*/
    }


}