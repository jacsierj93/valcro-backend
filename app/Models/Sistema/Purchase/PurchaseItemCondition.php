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
use App\Http\Traits\Journal;



/**@deprecate**/

class PurchaseItemCondition extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_compra_orden_item_cond";
    protected $dates = ['deleted_at'];


}