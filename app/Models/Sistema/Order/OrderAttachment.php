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



class OrderAttachment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden_adj";
    protected $dates = ['deleted_at'];


}



