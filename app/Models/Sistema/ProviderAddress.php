<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 25/04/2016
 * Time: 14:49
 */

namespace App\Models\Sistema;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProviderAddress extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_prov_direccion';

    public function providers()
    {
        return $this->belongsTo('App\Models\Sistema\Provider', 'prov_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Sistema\Country', 'id', 'pais_id');
    }

    public function tipo()
    {
        return $this->hasOne('App\Models\Sistema\TypeAddress', 'id', 'tipo_dir');
    }

    public function ports()
    {
        return $this->belongsToMany('App\Models\Sistema\Ports', 'tbl_direcciones_puerto', 'direccion_id','puerto_id');
    }
}