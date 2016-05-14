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
    protected $dates = ['deleted_at'];


    /**
     * obtiene los item de pedidos
     */
    public function OrderItem(){
        return $this->hasMany('App\Models\Sistema\Order\OrderItem', 'pedido_id');
    }

    public function getCustomOrder(){
        $data  = $this->OrderItem()
            ->get();
        return $data;
    }





    /**************************** descontinuado**********************

    /**
     * Get all of the tags for the post.
*/
    public function PurchaseOrder()
    {
//        $this->morphMany('Photo', 'imageable')->where('type', '=', 'Photo');;
        return $this->morphToMany('App\Models\Sistema\Purchase\Purchase', 'tbl_pedido_items')->
        where('pedido_tipo_origen_id','=','1');
    }



     /**si es mal uso
    public function PurchaseOrder(){
  /*      return $this->belongsToMany('App\Models\Sistema\Purchase\Purchase', 'tbl_pedido_items','pedido_id', 'origen_idd');
    }

    /*     */
    public function getOrders(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseOrder', 'pedido_id');
    }

    /**
     */
    public function getTypeOrder(){
        return $this->belongsTo('App\Models\Sistema\Order\OrderType', 'tipo_pedido_id');
    }

    /**
     *  contien lo sontra pedidos
     */
    public function customOrder(){
        return $this->belongsToMany('App\Models\Sistema\CustomOrders\CustomOrder', 'tbl_pedido_contrapedido', 'pedido_id','contra_pedido_id');
    }

    /**
     *  contien lo sontra pedidos
     */
    public function kitchenBox(){
        return $this->belongsToMany('App\Models\Sistema\KitchenBoxs\KitchenBox', 'tbl_pedido_kitchenbox', 'pedido_id','kitchen_box_id');
    }

    public function getEmisionAttribute($value)
    {
        return date("Y-m-d", strtotime($value));;
    }

}