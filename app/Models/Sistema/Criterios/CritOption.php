<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 20/10/16
 * Time: 03:27 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CritOption extends Model
{
    use SoftDeletes;
    protected $table = "tbl_crit_opc";
    public function config(){
        return $this->belongsToMany('App\Models\Sistema\Criterios\CritTipoCamp', 'tbl_crit_lct_cfg', 'lct_id', 'opc_id');
    }
}