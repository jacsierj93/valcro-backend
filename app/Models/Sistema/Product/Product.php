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



class Product extends Model
{
    use SoftDeletes;
    protected $table = "tbl_producto";

    public function getType(){
        return $this->hasOne('App\Models\Sistema\Product\ProductType','tipo_producto_id');
    }


}