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
use App\Http\Traits\Approvable;


class Product extends customBaseModel
{
    use SoftDeletes;
    use Journal;
    use Approvable;
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
    public function commons(){
        return $this->belongsToMany('App\Models\Sistema\Product\Product', 'tbl_prod_comp', 'parent_prod', 'comp_prod')
            ->withPivot("comentario",'id',"cantidad")
            ->withTimestamps()
            ->whereNull("tbl_prod_comp.deleted_at");
    }
    public function relationed(){
        return $this->belongsToMany('App\Models\Sistema\Product\Product', 'tbl_prod_rela', 'id_prod', 'id_prod_rel')
            ->withPivot("comentario",'id')
            ->withTimestamps()
            ->whereNull("tbl_prod_rela.deleted_at");
    }
    
//    public function isAprov(){
//        //dd($this->MorphMany('App\Models\Sistema\SysCustom\Approval','approvable','tabla','campo_id')->toSql());
//        return $this->MorphMany('App\Models\Sistema\SysCustom\Approval','approvable');
//    }
    

    
}