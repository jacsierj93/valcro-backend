<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 20/10/16
 * Time: 03:11 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;

class CritTipoCamp extends Model
{
    use SoftDeletes;
    use Journal;
    protected $table = "tbl_crit_tipo";
    public function config(){
        return $this->belongsToMany('App\Models\Sistema\Criterios\CritOption', 'tbl_crit_lct_cfg', 'lct_id', 'opc_id');
    }
}