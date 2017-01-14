<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Quotation;
use App\Http\Traits\Journal;


class OrderCondition extends Model
{

    use SoftDeletes;
    use Journal;

    protected $table = "tbl_pedido_condicion";

    protected $dates = ['deleted_at'];


}