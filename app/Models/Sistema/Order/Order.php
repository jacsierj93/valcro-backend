<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Order extends Model
{
    use SoftDeletes;
    protected $table = "tbl_pedido";

    /**
     */
    public function PurchaseOrder(){
        return $this->belongsToMany('App\Models\Sistema\Purchase\Purchase', 'tbl_compra_orden', 'pedido_id','orden_compra_id');
    }

    /**
     */
    public function getOrders(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseOrder', 'pedido_id');
    }

    /**
     */
    public function getTypeOrder(){
        return $this->belongsTo('App\Models\Sistema\Order\OrderType', 'tipo_pedido_id');
    }

    /**
     */
    public function customOrder(){
        return $this->belongsToMany('App\Models\Sistema\CustomOrders\CustomOrder', 'tbl_pedido_contrapedido', 'pedido_id','contra_pedido_id');
    }

    public function getEmisionAttribute($value)
    {
        return date("Y-m-d", strtotime($value));;
    }

}