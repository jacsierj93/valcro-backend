<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 08/04/2016
 * Time: 17:19
 */

namespace App\Models\Sistema\Providers;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NombreValcro extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_nomb_valcro";

    public function departamento()
    {
        return $this->belongsToMany('App\Models\Sistema\Providers\Departament','tbl_nom_valcro_departameno','nomVal_id','depa_id')->withPivot("fav");
    }
    public function providers()
    {
        return $this->belongsTo('App\Models\Sistema\Providers\Provider','prov_id');
    }
}