<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\CustomOrders;
use App\Models\Sistema\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;



class CustomOrder extends Model
{
    use SoftDeletes;
    use Journal;
    protected $table = "tbl_contra_pedido";

    /**
     */
    public function CustomOrderItem(){
        return $this->hasMany('App\Models\Sistema\CustomOrders\CustomOrderItem', 'doc_id', 'id');
    }

/*
    public function getfechaAttribute($value)
    {
        return date("Y-m-d", strtotime($value));
    }*/
}