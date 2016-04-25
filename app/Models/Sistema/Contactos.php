<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactos extends  Model
{

    use SoftDeletes;
    protected $table = 'tbl_contactos';

    ////foreing key
    public function contacto_proveedor()
    {
        return $this->hasMany('App\Models\Sistema\Proveedor', 'provedores_id');
    }
}