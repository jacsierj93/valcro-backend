<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class ProviderAddress extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_direccion";

    public function getPais(){
        return $this->belongsTo('App\Models\Sistema\Country','pais_id');
    }

}