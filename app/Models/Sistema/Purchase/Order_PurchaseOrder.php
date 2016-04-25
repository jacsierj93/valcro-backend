<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Purchase;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Quotation;

class Order_PurchaseOrder extends Model
{

    use SoftDeletes;
    protected $table = "tbl_pedido_orden_compra";

    protected $dates = ['deleted_at'];

    public function getOrder()
    {
        return $this->belongsTo('App\Models\Sistema\Purchase\Order', 'prov_id');
    }

    public function getPurchaseOrder()
    {
        return $this->belongsToMany('App\Models\Sistema\Purchase\PurchaseOrder', 'orden_compra_id');
    }

}