<?php
namespace App\Models\Sistema\Providers;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LimitCreditoProv extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_prov_lim_credito';

    ////foreing key
    public function provider()
    {
        return $this->belongsTo('App\Models\Sistema\Providers\Proveedor', 'prov_id');
    }

}