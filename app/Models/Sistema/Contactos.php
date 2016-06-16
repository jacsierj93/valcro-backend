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
        return $this->belongsToMany('App\Models\Sistema\Provider', 'tbl_prov_cont', 'cont_id', 'prov_id')->withPivot("direccion","responsabilidades");
    }

    public function cont_telefono()
    {
        return $this->belongsToMany('App\Models\Sistema\Provider', 'tbl_prov_cont', 'cont_id', 'prov_id')->withPivot("direccion","responsabilidades");
    }

    public function cargos(){
        return $this->belongsToMany('App\Models\Sistema\CargoContact', 'tbl_cargo_contacto', 'contacto_id', 'cargo_id');
    }

    public function idiomas(){
        return $this->belongsToMany('App\Models\Sistema\Language', 'tbl_contacto_languaje', 'contacto_id', 'languaje_id');
    }
}