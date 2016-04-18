<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_proveedor';

    ////foreing key
    public function nombres_valcro()
    {
        return $this->hasMany('App\Models\Sistema\NombreValcro', 'prov_id');
    }
    public function proveedor_moneda()
    {
        return $this->hasMany('App\Models\Sistema\ProvMoneda', 'prov_id');
    }

    public function proveedor_product()
    {
        return $this->hasMany('App\Models\Sistema\Product', 'prov_id');
    }

    /**
    */
    public function monedas(){
        return $this->belongsToMany('App\Models\Sistema\Monedas', 'tbl_prov_moneda', 'prov_id','moneda_id');
    }

    /**
     * obtiene las direcciones de almacen de los proveedor
    */
    public function getDireciones(){
        return $this->hasMany('App\Models\Sistema\ProviderAddress','prov_id');
    }
}