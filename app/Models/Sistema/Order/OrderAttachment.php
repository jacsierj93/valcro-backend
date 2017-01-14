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
use App\Http\Traits\Journal;




class OrderAttachment extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_pedido_adj";
    protected $dates = ['deleted_at'];


}



