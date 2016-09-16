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

class UserPreference extends Model
{

    use SoftDeletes;
    protected $table = "tbl_usuario_preferencia";


    ///foreing key
    public function user()
    {
        return $this->belongsTo('App\Models\Sistema\User', 'usuario_id');
    }


    protected $dates = ['deleted_at'];


}