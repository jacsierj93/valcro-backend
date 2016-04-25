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

class OrderStatus extends Model
{

    use SoftDeletes;
    protected $table = "tbl_pedido_estado";

    protected $dates = ['deleted_at'];


}