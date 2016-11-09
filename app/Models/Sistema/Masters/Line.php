<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 09/05/2016
 * Time: 17:24
 */

namespace App\Models\Sistema\Masters;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Line extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_lineas';
    public function prodTime()
    {
        return $this->belongsTo('App\Models\Sistema\Providers\ProdTime','linea_id');
    }

    public function criterios(){
        return $this->hasMany('App\Models\Sistema\Criterios\CritLinCamTip','linea_id',"id");
    }
}