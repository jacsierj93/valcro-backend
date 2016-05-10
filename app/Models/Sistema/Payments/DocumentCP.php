<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Payments;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentCP extends Model
{

    use SoftDeletes;
    protected $table = "tbl_docum_cp";
    protected $dates = ['deleted_at'];
    public $currentDate;

    /**
     * DocumentCP constructor.
     * @param $currentDate
     */


    /**@return Proveedor de pago */
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Sistema\Provider', 'prov_id');
    }

    /**tipo de documento
     * @return mixed
     */
    public function tipo()
    {
        return $this->belongsTo('App\Models\Sistema\Payments\DocumentCPType', 'tipo_id');
    }

    /**trae el numero de cuotas de la factura en caso de deuda
     * @return mixed
     */
    public function ncuotas(){

        return DocumentCP::where("nro_orig",$this->nro_factura)->where("tipo_id",5)->count();

    }


    /**trae las cuotas de la deuda
     * @return mixed
     */
    public function cuotas(){
        return DocumentCP::where("nro_orig",$this->nro_factura)->where("tipo_id",5)->get();
    }

    
    ////foreing key
    public function moneda()
    {
        return $this->hasOne('App\Models\Monedas', 'moneda_id');
    }





    /**funcion que trae la diferencia de fechas en dias
     * @param $dateIni
     * @param $dateEnd
     * @return mixed
     */
    private function dateDiff($dateIni, $dateEnd)
    {
        $from = date_create($dateIni);
        $to = date_create($dateEnd);
        $diff = date_diff($to, $from);
        return (int)$diff->format('%R%d');
    }

    /**calcula el rango de vencimiento segun la fecha de vencimiento
     * @param $fecha
     * @return int
     */
    public function vencimiento()
    {

        $currenDate = date("Y-m-d"); ///fecha actual
        $dias = $this->dateDiff($this->fecha_vence, $currenDate); ///calculo de dias para el vencimiento

        if ($dias <= 0) {
            $estatus = 0; ///vencido
        } else if ($dias <= 7) {
            $estatus = 7; ///vence en 7 dias o menos ...
        } else if ($dias > 7 && $dias <= 30) {
            $estatus = 30;
        } else if ($dias > 30 && $dias <= 60) {
            $estatus = 60;
        } else if ($dias > 60 && $dias <= 90) {
            $estatus = 90;
        } else {
            $estatus = 100; ///mas de 90
        }

        return $estatus;


    }





}