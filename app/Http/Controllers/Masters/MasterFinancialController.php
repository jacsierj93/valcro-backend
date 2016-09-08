<?php

/*
|--------------------------------------------------------------------------
| Controllador genereico para servicios financieros
|--------------------------------------------------------------------------
|
|
*/

namespace app\Http\Controllers\Masters;

use App\Models\Sistema\Masters\Monedas;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class MasterFinancialController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**dado el costo(double) y el id(int) de la moneda, trae el costo en la moneda final por def es $
     * @param $cost
     * @param $coinId
     * @param int $coinDef
     */
    public static function getCostByCoin($cost, $coinId, $coinDef = 1)
    {

        $moneda1 = Monedas::findOrFail($coinId);
        $costo1 = (double)$moneda1->precio_usd * $cost;

        if ($coinDef != 1) { ///no es por defecto el $

            $moneda2 = Monedas::findOrFail($coinDef);
            $costo1 = (double) $costo1 / $moneda2->precio_usd;

        }

        return $costo1;


    }


}