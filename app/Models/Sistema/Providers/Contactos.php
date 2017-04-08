<?php
namespace App\Models\Sistema\Providers;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Http\Traits\Journal;
use App\Http\Traits\Approvable;
class Contactos extends  Model
{

    use SoftDeletes;
    use Approvable;
    use Journal;
    protected $table = 'tbl_contacto';

    ////foreing key
    public function contacto_proveedor()
    {
        return $this->belongsToMany('App\Models\Sistema\Providers\Provider', 'tbl_prov_cont', 'cont_id', 'prov_id');
    }

    public function campos()
    {
        return $this->hasMany('App\Models\Sistema\Providers\ContactField', 'cont_id');
    }

    public function country()
    {
        return $this->hasOne('App\Models\Sistema\Masters\Country','id','pais_id');
    }

    public function cont_telefono()
    {
        return $this->belongsToMany('App\Models\Sistema\Providers\Provider', 'tbl_prov_cont', 'cont_id', 'prov_id')->withPivot("direccion","responsabilidades");
    }

    public function cargos(){
        return $this->belongsToMany('App\Models\Sistema\Providers\CargoContact', 'tbl_cargo_contacto', 'contacto_id', 'cargo_id');
    }

    public function idiomas(){
        return $this->belongsToMany('App\Models\Sistema\Masters\Language', 'tbl_contacto_languaje', 'contacto_id', 'languaje_id');
    }
}