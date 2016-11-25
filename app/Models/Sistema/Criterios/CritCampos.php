<?php

/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 20/10/16
 * Time: 03:09 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CritCampos extends Model
{
    use SoftDeletes;
    protected $table = "tbl_crit_campos";

    public function getLine(){
        return $this->belongsToMany('App\Models\Sistema\Masters\Line','tbl_crit_lin_cam_tip','campo_id','linea_id')->whereNull('tbl_crit_lin_cam_tip.deleted_at')->groupBy("linea_id") // Table `group_user` has column `deleted_at`
        ->withTimestamps();
    }
}