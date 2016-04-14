<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LimitCreditoProv extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_prov_lim_credito';

    ////foreing key
    public function limite_credito()
    {
        return $this->hasMany('App\Models\Sistema\Proveedor', 'prov_id');
    }
}