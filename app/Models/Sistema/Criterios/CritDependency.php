<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 24/11/16
 * Time: 02:23 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CritDependency extends Model
{
    use SoftDeletes;
    protected $table = "tbl_crit_dependencia";


    public function parent(){
        return $this->hasOne('App\Models\Sistema\Criterios\CritLinCamTip','id','lct_id')
            ->join('tbl_crit_campos','campo_id',"=",'tbl_crit_campos.id');
    }
}