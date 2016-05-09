<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 05/05/2016
 * Time: 17:19
 */

namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProdTime extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_prov_tiempo_fab';

    ////soft deletes
    protected $dates = ['deleted_at'];

    public function provider(){
        return $this->belongsTo('App\Models\Sistema\Provider',"prov_id");
    }

    public function country(){
        return $this->hasOne('App\Models\Sistema\Country',"id");
    }
}