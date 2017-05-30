<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 26/10/16
 * Time: 03:45 PM
 */

namespace App\Models\Sistema\Criterios;

use App\Models\Sistema\SysCustom\customBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;


class CritLinCamTip extends customBaseModel
{
    use SoftDeletes;
    use Journal;
    protected $table="tbl_crit_lin_cam_tip";

    public function line(){
        return $this->belongsTo('App\Models\Sistema\Masters\Line',"linea_id");
    }
    public function field(){
        return $this->hasOne('App\Models\Sistema\Criterios\CritCampos','id','campo_id');
    }
    public function type(){
        return $this->hasOne('App\Models\Sistema\Criterios\CritTipoCamp','id','tipo_id');
    }

    public function options(){
        return $this->belongsToMany('App\Models\Sistema\Criterios\CritOption','tbl_crit_lct_opc','lct_id','opc_id')
            ->withPivot("value","id","message")
            ->whereNull('tbl_crit_lct_opc.deleted_at') // Table `group_user` has column `deleted_at`
            ->withTimestamps();
    }

    public function dependency(){
        return $this->hasMany('App\Models\Sistema\Criterios\CritDependency','sub_lct_id','id');
    }
    public function childCfg(){
        return $this->hasMany('App\Models\Sistema\Criterios\CritDependency','lct_id','id');
    }
    public function children(){
        return $this->belongsToMany('App\Models\Sistema\Criterios\CritLinCamTip','tbl_crit_dependencia','lct_id','sub_lct_id')
            ->selectRaw('tbl_crit_lin_cam_tip.id as id,linea_id, tipo_id,campo_id,RAND() as random')
            ->with(array('field'=>function($query){
                $query->selectRaw('id,descripcion,RAND() as random');
            }))
            ->with('children');
    }

    public function products(){
        return $this->belongsToMany('App\Models\Sistema\Product\Product', 'tbl_prod_crit', 'crit_id', 'prod_id')
            ->withTimestamps()
            ->whereNull("tbl_prod_crit.deleted_at");
    }
}