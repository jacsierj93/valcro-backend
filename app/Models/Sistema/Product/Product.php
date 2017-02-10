<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Product;
use App\Models\Sistema\SysCustom\customBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;



class Product extends customBaseModel
{
    use SoftDeletes;
    use Journal;
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

    public function prodCrit(){
        return $this->belongsToMany('App\Models\Sistema\Criterios\CritLinCamTip', 'tbl_prod_crit', 'prod_id', 'crit_id')
            ->withPivot("value")
            ->withTimestamps()
            ->whereNull("tbl_prod_crit.deleted_at");
    }

    
}