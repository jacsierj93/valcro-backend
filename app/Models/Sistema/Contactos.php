<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactos extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_contacto';

    ////foreing key
    public function contacto_proveedor()
    {
        return $this->belongsToMany('App\Models\Sistema\Provider', 'tbl_prov_cont', 'cont_id', 'prov_id');
    }
}