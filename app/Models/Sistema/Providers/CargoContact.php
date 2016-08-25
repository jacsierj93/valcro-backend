<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 11/05/2016
 * Time: 14:11
 */

namespace App\Models\Sistema\Providers;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class CargoContact extends Model
{
    use SoftDeletes;
    protected $table="tbl_cargos_contacto";

    public function contactos(){
        return $this->belongsToMany('App\Models\Sistema\Providers\Contactos', 'tbl_cargo_contacto', 'cargo_id', 'cont_id');
    }
}