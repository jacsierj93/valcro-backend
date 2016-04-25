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

}