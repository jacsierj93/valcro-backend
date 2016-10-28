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
        return $this->hasOne('App\Models\Sistema\Masters\Line',"id","linea_id");
    }
    public function field(){
        return $this->hasOne('App\Models\Sistema\Criterios\CritCampos','id','campo_id');
    }
    public function type(){
        return $this->hasOne('App\Models\Sistema\Criterios\CritTipoCamp','id','tipo_id');
    }
}