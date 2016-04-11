<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvMoneda extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_prov_moneda';
    protected $dates = ['deleted_at'];
    ////foreing key
    public function moneda()
    {
        return $this->belongsTo('App\Models\Sistema\Monedas', 'id');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Sistema\Proveedor', 'id', 'nombre');
    }
}