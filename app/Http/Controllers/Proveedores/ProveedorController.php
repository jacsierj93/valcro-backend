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
use App\Models\Sistema\Monedas;
use App\Models\Sistema\ProvMoneda;
use App\Models\Sistema\LimitCreditoProv;
use App\Models\Sistema\FactConvProv;
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
        $dato = $provs->find(1);
        $mone= $dato->monedas();
        $moneProv= Array();
        foreach( $mone->get() as $aux){
            $moneProv[]=$aux->nombre;
        }
        $dato['nomMoneda']=$moneProv;
        return $dato;
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
    public function Monedas()
    {
        $mon = new Monedas();
        $data = $mon->where("deleted_at",NULL)->get();
        return $data;
    }
    public function listMonedas()
    {
        $provmon = new ProvMoneda();
        $data = $provmon->where("deleted_at",NULL)->get();
        return $data;
    }
    public function listLimitCred()
    {
        $limitCre = new LimitCreditoProv();
        $data = $limitCre->where("deleted_at",NULL)->get();
        return $data;
    }
    public function listConvPro()
    {
        $factConv = new FactConvProv();
        $data = $factConv->where("deleted_at",NULL)->get();
        return $data;
    }
    /*    public function saveDataProv(){

        }*/
}