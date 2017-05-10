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

use App\Http\Traits\Journal;


class CritDependency extends Model
{
    use SoftDeletes;
    use Journal;
    protected $table = "tbl_crit_dependencia";


    public function parent(){
        return $this->hasOne('App\Models\Sistema\Criterios\CritLinCamTip','id','lct_id')
            ->join('tbl_crit_campos','campo_id',"=",'tbl_crit_campos.id');
    }

    public function children(){
        return $this->hasMany('App\Models\Sistema\Criterios\CritLinCamTip','id','sub_lct_id')
            ->selectRaw('id,linea_id, tipo_id,campo_id')
            ->with(array('field'=>function($query){
                $query->selectRaw('id,descripcion');
            }))
            ->with('childCfg');
            
    }
}