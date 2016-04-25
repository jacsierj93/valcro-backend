<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FactConvProv extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_prov_factor';

    ////foreing key
    public function conversion_prov()
    {
        return $this->hasMany('App\Models\Sistema\Proveedor', 'prov_id');
    }
}