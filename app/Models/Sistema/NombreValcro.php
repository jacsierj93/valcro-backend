<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 08/04/2016
 * Time: 17:19
 */

namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NombreValcro extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_nomb_valcro";

    ///foreing key
/*    public function proveedor()
    {
        return $this->belongsTo('App\Models\Sistema\Proveedor', 'cargo_id');
    }*/

}