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



class ProviderFactor extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_factor";

    public function linea()
    {
        return $this->hasOne('App\Models\Sistema\Line', 'id', 'linea_id');
    }
}