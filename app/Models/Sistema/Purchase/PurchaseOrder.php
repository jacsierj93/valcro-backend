<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class PurchaseOrder extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden";


    /**@return Proveedor de pago*/
    public function getProveedor(){
        return $this->belongsTo('App\Models\Sistema\Proveedor', 'prov_id', 'id');
    }

    /**@return Proveedor de pago*/
    public function getReason(){
        return $this->hasOne('App\Models\Sistema\Purchase\OrderReason', 'id', 'motivo_id');
    }

    public function getItems(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseOrderItem', 'compra_orden_id', 'id');
    }
}