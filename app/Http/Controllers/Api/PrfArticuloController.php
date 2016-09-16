<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 4:01 PM
 */

namespace App\Http\Controllers\Api;

use App\Models\Profit\Articulo;
use App\Models\Valcro2\ProductoProfit;
use Laravel\Lumen\Routing\Controller as BaseController;


class PrfArticuloController extends BaseController
{


    /**metodo para traer el articulo de profit por el id
     * @param $id
     */
    public function getArtById($id)
    {

        // $art =  Articulo::take(5000)->offset(0)->get();
        $art = Articulo::all();
        dd($art);
        /*foreach ($art as $datos){
            print $datos->co_art.' - '.$datos->art_des.'<br>';

        }*/

    }


    public function getProductosProfit()
    {
        $prod = new ProductoProfit();

        $data = $prod->select("co_prov","descripcion")->get();

        return $data;


    }


    public function execSP(){
        $prod = new ProductoProfit();
        $data = $prod->execSp();
        return $data;
    }


}