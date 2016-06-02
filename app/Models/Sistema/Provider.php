<?phpnamespace App\Models\Sistema;use App\Quotation;use DB;use Illuminate\Database\Eloquent\Collection;use Illuminate\Database\Eloquent\Model;use Illuminate\Database\Eloquent\SoftDeletes;class Provider extends  Model{    use SoftDeletes;    protected $table = 'tbl_proveedor';    ////soft deletes    protected $dates = ['deleted_at'];    ////foreing key    public function nombres_valcro()    {        return $this->hasMany('App\Models\Sistema\NombreValcro', 'prov_id');    }    public function address()    {        return $this->hasMany('App\Models\Sistema\ProviderAddress', 'prov_id');    }    public function contacts()    {        return $this->belongsToMany('App\Models\Sistema\Contactos', 'tbl_prov_cont', 'prov_id', 'cont_id');    }    public function proveedor_product()    {        return $this->hasMany('App\Models\Sistema\Product', 'prov_id');    }    /**     */    public function getProviderCoin(){        return $this->belongsToMany('App\Models\Sistema\Monedas', 'tbl_prov_moneda', 'prov_id','moneda_id')->withPivot('punto');    }    /**     * obtiene las cuentas bancarias del proveedor     */    public function bankAccount(){        return $this->hasMany('App\Models\Sistema\BankAccount','prov_id');    }    /**     * obtiene los limites de credito     */    public function limitCredit(){        return $this->hasMany('App\Models\Sistema\ProviderCreditLimit','prov_id');    }    /**     * obtiene los factores de conversion     */    public function convertFact(){        return $this->hasMany('App\Models\Sistema\ProviderFactor','prov_id');    }    /**     * obtiene los tiempos de produccion     */    public function prodTime(){        return $this->hasMany('App\Models\Sistema\ProdTime','prov_id');    }    /**     * obtiene los tiempos de produccion     */    public function transTime(){        return $this->hasMany('App\Models\Sistema\TiemAproTran','prov_id');    }    /**     * obtiene los Puntos configurado     */    public function points(){        return $this->hasMany('App\Models\Sistema\Point','prov_id');    }    /**     * @deprecated     * obtiene las direcciones de almacen de los proveedor     */    public function getAddress(){        return $this->hasMany('App\Models\Sistema\ProviderAddress','prov_id');    }    /**     * obtiene las condiciones de pago asignadas al proveedor     * @deprecated     */    public function getPaymentCondition(){        return $this->hasMany('App\Models\Sistema\ProviderCondPay','prov_id');    }    /**     * obtiene los pedidos     */    public function Order(){        return $this->hasMany('App\Models\Sistema\Order\Order','prov_id');    }    /**     * obtiene los contra pedidos     */    public function CustomOrder(){        return $this->hasMany('App\Models\Sistema\CustomOrders\CustomOrder','prov_id');    }    /**     * obtien la deuda de ese proveedor     * @deprecated     */    public function getFullPaymentOrders(){        return $this->getOrders()->sum('monto');    }    public function getDocuments(){        return $this->hasMany('App\Models\Sistema\Payments\DocumentCP','prov_id');    }    /**     * retorna los paises donde un proveedor tiene direciones    */    public function getCountry(){        $data = Collection::make(array());        $dirs = $this->address()->get();        foreach($dirs as $aux){            if(!$data->contains($aux->pais_id)){                $data->push(Country::find($aux->pais_id));            }        }        return$data;    }}