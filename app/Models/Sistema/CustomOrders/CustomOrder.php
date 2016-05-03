<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\CustomOrders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class CustomOrder extends Model
{
    use SoftDeletes;
    protected $table = "tbl_contra_pedido";


    public function getfechaAttribute($value)
    {
        return date("Y-m-d", strtotime($value));;
    }

}