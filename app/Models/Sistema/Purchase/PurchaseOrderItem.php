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



class PurchaseOrderItem extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden_item";

    public  function getProductoProfit(){
        return $this->belongsTo('App\Models\Sistema\Product', 'producto_id', 'id');

    }

}