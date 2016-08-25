<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Providers;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Quotation;

class Departament extends Model
{

    use SoftDeletes;
    protected $table = "tbl_departamento";

    protected $dates = ['deleted_at'];

    ///foreing key
    public function nomVal()
    {
        return $this->belongsToMany('App\Models\Sistema\Providers\NombreValcro','tbl_nom_valcro_departameno','depa_id','nomVal_id');
    }
}