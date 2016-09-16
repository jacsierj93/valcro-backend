<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Quotation;

class Position extends Model
{

    use SoftDeletes;
    protected $table = "tbl_cargo";


    ///foreing key
    public function departament()
    {
        return $this->belongsTo('App\Models\Sistema\Departament', 'departamento_id');
    }

    protected $dates = ['deleted_at'];


}