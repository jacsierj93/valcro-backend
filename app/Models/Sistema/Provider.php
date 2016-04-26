<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_proveedor';

    ////foreing key
    public function nombres_valcro()
    {
        return $this->hasMany('App\Models\Sistema\NombreValcro', 'prov_id');
    }

    public function address()
    {
        return $this->hasMany('App\Models\Sistema\ProviderAddress', 'prov_id');
    }

    public function proveedor_product()
    {
        return $this->hasMany('App\Models\Sistema\Product', 'prov_id');
    }

    /**
    */
    public function getProviderCoin(){
        return $this->belongsToMany('App\Models\Sistema\Monedas', 'tbl_prov_moneda', 'prov_id','moneda_id');
    }

    /**
     * obtiene las direcciones de almacen de los proveedor
    */
    public function getAddress(){
        return $this->hasMany('App\Models\Sistema\ProviderAddress','prov_id');
    }

    /**
     * obtiene las condiciones de pago asignadas al proveedor
     */
    public function getPaymentCondition(){
        return $this->hasMany('App\Models\Sistema\ProviderCondPay','prov_id');
    }

    /**
     * obtiene las condiciones de pago asignadas al proveedor
     */
    public function getOrders(){
        return $this->hasMany('App\Models\Sistema\Order\Order','prov_id');
    }

    /**
     * obtiene las condiciones de pago asignadas al proveedor
     */
    /**
     * obtiene las condiciones de pago asignadas al proveedor
     */
    public function getFullPaymentOrders(){
        return $this->getOrders()->sum('monto');
    }

}