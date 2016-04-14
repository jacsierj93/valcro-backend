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
        $dato['monedas_rel'] = $dato->proveedor_moneda()->get();
       // dd($dato);
        foreach($dato['monedas_rel'] as $d){
            $d['nomMoneda'] = $d->moneda()->get();
        }
        //dd($dato);
 /*       $data = $provs->where("deleted_at",NULL)->get();
        foreach($data as $k => $v){
            $v['prov_moneda']=$v->proveedor_moneda()->get();
          foreach($data as $v){
              $v['nomb_moneda']= $v->moneda;
          }
        }*/
        return $dato;
        //return $data;
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
        $mon = new Moneda();
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