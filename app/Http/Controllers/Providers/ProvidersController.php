<?php

/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 08/04/2016
 * Time: 16:08
 */

namespace App\Http\Controllers\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\NombreValcro;
use Session;
use Validator;

class ProvidersController extends BaseController
{
/*    public function __construct()
    {

        $this->middleware('auth');
    }*/

    public function getList()
    {
        $provs = new Proveedor();
        $data = $provs->select("id","razon_social as description","contrapedido as contraped","limite_credito  as limCred", "siglas")->where("deleted_at",NULL)->get();
        /*   foreach($data as $k => $v){
            $v['nombreValcro']=$v->nombres_valcro()->get();
        }*/
        return $data;
    }

    public function getProv(request $prv)
    {

        //$prov = new Proveedor();
        $data = Proveedor::select("id","razon_social as description","contrapedido as contraped","limite_credito as limCred", "siglas","tipo_id as type","tipo_envio_id as envio")->where("id",$prv->id)->get()->first();
        /*   foreach($data as $k => $v){
            $v['nombreValcro']=$v->nombres_valcro()->get();
        }*/
        $data->contraped = ($data->contraped == 1);
        return $data;
    }


    public function saveOrUpdateProv(request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $prov =  Proveedor::findOrFail($req->id);
            $result['action']="update";
        }else{
            $prov =  new Proveedor();
        }
        $prov->razon_social = $req->description;
        $prov->tipo_id = $req->type;
        $prov->siglas = $req->siglas;
        $prov->tipo_envio_id = $req->envio;
        $prov->contrapedido = $req->contraped;

        $prov->save();
        $result['id']=$prov->id;
        return $result;
    }

    public function provNombreval(Request $req)
    {

        dd($req);
    }

/*    public function saveDataProv(){

    }*/
}