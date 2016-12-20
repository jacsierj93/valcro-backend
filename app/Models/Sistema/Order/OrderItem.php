<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Order;
use App\Models\Sistema\Purchase\PurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class OrderItem extends Model
{
    use SoftDeletes;
    protected $table = "tbl_pedido_item";
    protected $dates = ['deleted_at'];

    public function producto (){
        return $this->belongsTo('App\Models\Sistema\Product\Product', 'producto_id');
    }

    public function document(){
        return $this->belongsTo('App\Models\Sistema\Order\Order', 'doc_id');
    }
}