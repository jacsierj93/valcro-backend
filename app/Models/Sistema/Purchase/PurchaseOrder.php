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


/**@deprecate**/
class PurchaseOrder extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden";
    protected $dates = ['deleted_at'];


    /**@return Proveedor de pago*/
    public function getProveedor(){
        return $this->belongsTo('App\Models\Sistema\Proveedor', 'prov_id', 'id');
    }

    /**@return Proveedor de pago*/
    public function getReason(){
        return $this->hasOne('App\Models\Sistema\Purchase\OrderReason', 'id', 'motivo_id');
    }

    public function PurchaseOrderItem(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseOrderItem', 'compra_orden_id');
    }


    public function getemisionAttribute($value)
    {
        return date("d-m-Y", strtotime($value));;
    }

}