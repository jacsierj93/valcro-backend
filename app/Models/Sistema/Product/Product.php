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
use App\Http\Traits\Audittrail;



class Product extends Model
{
    use SoftDeletes;
    use Audittrail;
    protected $table = "tbl_producto";

    public function getType(){
        return $this->hasOne('App\Models\Sistema\Product\ProductType','id','tipo_producto_id');
    }

    public function prov(){
        return $this->belongsTo('App\Models\Sistema\Providers\Provider','prov_id');
    }
    public function subLin(){
        return $this->hasOne('App\Models\Sistema\Product\SubLine','id','sublinea_id');
    }
    public function line(){
        return $this->hasOne('App\Models\Sistema\Masters\Line','id','linea_id');
    }

    
}