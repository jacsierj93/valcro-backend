<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 01/11/16
 * Time: 04:52 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CritCampoOption extends Model
{
    use SoftDeletes;
    protected $table = "tbl_crit_lct_opc";

    public function opciones(){
        return $this->hasOne("App\Models\Sistema\Criterios\CritOption","id","opc_id");
    }
}