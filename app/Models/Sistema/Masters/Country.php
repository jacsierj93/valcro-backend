<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Masters;




use App\Models\Sistema\Providers\Provider;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Quotation;

class Country extends Model
{
    protected $table = "tbl_pais";

    public function states(){
        return $this->hasMany('App\Models\Sistema\Masters\State', 'in_location');
    }

    public function areaCode(){
        return $this->hasOne('App\Models\Sistema\Masters\AreaCode', 'pais_id');
    }
    public function ports(){
        return $this->hasOne('App\Models\Sistema\Masters\Ports', 'pais_id');
    }

    public function providers_addres(){
        return $this->hasMany('App\Models\Sistema\Providers\ProviderAddress', 'pais_id');
    }
    public function providers(){
        $model = Provider::selectRaw('distinct tbl_proveedor.id, razon_social ')

            ->join('tbl_prov_direccion','tbl_prov_direccion.prov_id','=','tbl_proveedor.id' )
            ->where('tbl_prov_direccion.pais_id',$this->id);
        return $model;
    }
}