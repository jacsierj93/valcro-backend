<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monedas extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_moneda';
    protected $dates = ['deleted_at'];
    ////foreing key
    public function moneda_proveedor()
    {
        return $this->hasMany('App\Models\Sistema\ProvMoneda', 'moneda_id');
    }
}