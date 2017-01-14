<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Shipments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;


class ShipmentItem extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_embarque_item";
    protected $dates = ['deleted_at'];

    public function order_item(){
        return $this->belongsTo('App\Models\Sistema\Purchase\PurchaseItem', 'origen_item_id');
    }





}