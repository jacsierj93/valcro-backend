<?php

/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 08/04/2016
 * Time: 16:08
 */

namespace App\Http\Controllers\Proveedores;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\NombreValcro;
use Session;
use Validator;

class ProveedorController extends BaseController
{
/*    public function __construct()
    {

        $this->middleware('auth');
    }*/

    public function getList()
    {
        $provs = new Proveedor();
        $data = $provs->select("id","razon_social","contrapedido","limite_credito", "siglas")->where("deleted_at",NULL)->get();
        /*   foreach($data as $k => $v){
            $v['nombreValcro']=$v->nombres_valcro()->get();
        }*/
        return $data;
    }

    public function getProv(request $prv)
    {

        //$datos = Proveedor::findOrFail();
        $data = Proveedor::select("id","razon_social","contrapedido","limite_credito", "siglas")->find($prv->id)->where("deleted_at",NULL)->get();
        /*   foreach($data as $k => $v){
            $v['nombreValcro']=$v->nombres_valcro()->get();
        }*/
        return $data;
    }


    public function saveOrUpdateProv(Request $req){

    }

    public function provNombreval(Request $req)
    {

        dd($req);
    }

/*    public function saveDataProv(){

    }*/
}