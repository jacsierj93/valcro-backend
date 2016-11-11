<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 26/10/16
 * Time: 03:45 PM
 */

namespace App\Models\Sistema\Criterios;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CritLinCamTip extends Model
{
    use SoftDeletes;
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
        return $this->belongsToMany('App\Models\Sistema\Criterios\CritOption','tbl_crit_lct_opc','lct_id','opc_id')->withPivot("value","id","message")->whereNull('tbl_crit_lct_opc.deleted_at') // Table `group_user` has column `deleted_at`
        ->withTimestamps(); ;
    }
}