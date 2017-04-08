<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 25/04/2016
 * Time: 14:49
 */

namespace App\Models\Sistema\Providers;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;
use App\Http\Traits\Approvable;


class ProviderAddress extends Model
{
    use SoftDeletes;
    use Journal;
    use Approvable;
    protected $with = array("isAprov");
    protected $table = 'tbl_prov_direccion';
    
    public function providers()
    {
        return $this->belongsTo('App\Models\Sistema\Providers\Provider', 'prov_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Sistema\Masters\Country', 'id', 'pais_id');
    }

    public function tipo()
    {
        return $this->hasOne('App\Models\Sistema\Providers\TypeAddress', 'id', 'tipo_dir');
    }

    public function ports()
    {
        return $this->belongsToMany('App\Models\Sistema\Masters\Ports', 'tbl_direcciones_puerto', 'direccion_id','puerto_id');
    }
}