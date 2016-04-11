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
use App\Models\Sistema\Contactos;
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
        $data = $provs->where("deleted_at",NULL)->get();
        foreach($data as $k => $v){
            $v['nombreValcro']=$v->nombres_valcro()->get();
        }
        return $data;
    }

    public function gettoken(){
        echo csrf_token();
    }

    public function saveOrUpdateProv(Request $req){

    }

    public function provNombreval(Request $req)
    {

        dd($req);
    }

    public function listContactos()
    {
        $cont = new Contactos();
        $data = $cont->where("deleted_at",NULL)->get();
        return $data;
    }

    /*    public function saveDataProv(){

        }*/
}