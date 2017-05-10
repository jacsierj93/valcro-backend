<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class ProductStorage extends Model
{
    use SoftDeletes;
    protected $table = "tbl_producto_almacen";

    public function producto(){
        return $this->belongsTo('App\Models\Sistema\Product\Product','producto_id');
    }

    public function almacen(){
        return $this->belongsTo('App\Models\Sistema\Master\StoreValcro','almacen_id');
    }

}