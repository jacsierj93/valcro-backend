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
use App\Models\Sistema\Product\ProductComponent;
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
            ->with(array("commons"=>function($q){
                return $q->selectRaw("codigo,descripcion,serie,linea_id")->with(array("line"=>function($query){
                    return $query->selectRaw("id,linea");
                }));
            }))

            ->where("prov_id",$prov)
            ->distinct("id")
            ->get();

        return json_encode($all);
    }

    public function filterProd(Request $filt){

        $datos =  Product::with(
            array("prov"=>function($query){
                return $query->selectRaw("id,razon_social");
            }))
            ->with(array("line"=>function($query){
                return $query->selectRaw("id,linea");
            }))
            ->with(array("subLin"=>function($q){
                return $q->selectRaw("id,sublinea");
            }))
            ->with(array("getType"=>function($q){
                return $q->selectRaw("id,descripcion");
            }))
            ->where("id","<>",$filt->prod)
            ->distinct("id");

            if($filt->line){
                $datos->where("linea_id",$filt->line);
            }

            if($filt->sublin){
                $datos->where("sublinea_id",$filt->sublin);
            }

            if($filt->desc != ""){
                $datos->where("codigo","like",$filt->desc."%")
                ->orWhere("descripcion","like",$filt->desc."%");
            }

            return $datos->get();


    }

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
    
    public function saveCommon(Request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $comm =  ProductComponent::findOrFail($req->id);
            $result['action']="upd";
        }else{
            $comm =  new ProductComponent();
        }
        $comm->parent_prod = $req->parent;
        $comm->comp_prod = $req->prod;
        $comm->comentario = $req->comment;

        if($comm->isDirty()){
            $comm->save();
        }else{
            $result['action']="equal";
        }
        return $result;
    }
    public function delCommon(Request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "upd","id"=>"");
        if($req->id){
            $comm =  ProductComponent::findOrFail($req->pivot['id']);
            if(!$comm->delete()){
                $result['action']="err";
            }
        }else{
            $result['action']="equal";
        }

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