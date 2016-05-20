<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Order;
use App\Models\Sistema\ProdTime;
use App\Models\Sistema\TiemAproTran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes;
    protected $table = "tbl_pedido";
    protected $dates = ['deleted_at'];


    /**
     * obtiene los item de pedidos
     */
    public function OrderItem(){
        return $this->hasMany('App\Models\Sistema\Order\OrderItem', 'pedido_id');
    }

    /**
     */

    public function arrival(){
        $estatus = -1;

        if(
            $this->culminacion != null
            && $this->cancelacion == null
            && $this->aprob_gerencia == 1
//           && $this->aprob_compras == 1

        ){
            $auxCul= date_create($this->culminacion);
            $culminacion= Carbon::createFromDate($auxCul->format("Y"),$auxCul->format("m"),$auxCul->format("d"));
            $tmFabri = ProdTime::where('prov_id',$this->prov_id)->first()->max_dias;
            $tmTrn = TiemAproTran::where('prov_id',$this->prov_id)->first()->max_dias;

            $can_dias= $tmFabri + $tmTrn;
            $llegada= $culminacion->copy()->addDay($can_dias);

            $dias=Carbon::now()->diffInDays($llegada);

            if ($dias <= 0) {
                $estatus = 0; 
            } else if ($dias <= 7) {
                $estatus = 7; 
            } else if ($dias > 7 && $dias <= 30) {
                $estatus = 30;
            } else if ($dias > 30 && $dias <= 60) {
                $estatus = 60;
            } else if ($dias > 60 && $dias <= 90) {
                $estatus = 90;
            } else if($dias >100){
                $estatus = 100; ///mas de 90
            }
        }

        return $estatus;//->format("d");
    }

    private function dateDiff($dateIni, $dateEnd)
    {
        $from = date_create($dateIni);
        $to = date_create($dateEnd);
        $diff = date_diff($to, $from);
        return (int)$diff->format('%R%d');
    }
    /**************************** descontinuado**********************

    /*     */
    public function getOrders(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseOrder', 'pedido_id');
    }

    /**
     */
    public function getTypeOrder(){
        return $this->belongsTo('App\Models\Sistema\Order\OrderType', 'tipo_pedido_id');
    }

}