<?php
namespace App\Models\Sistema\Providers;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvMoneda extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_prov_moneda';

    public function moneda()
    {
        return $this->belongsToMany('App\Models\Sistema\Providers\Proveedor', 'tbl_prov_moneda','prov_id','moneda_id');
    }

    public function getCoin()
    {
        return $this->belongsTo('App\Models\Sistema\Masters\Moneda','moneda_id');
    }


}