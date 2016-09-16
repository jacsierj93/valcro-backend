<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class User extends Model
{

    use SoftDeletes;
    protected $table = 'tbl_usuario';


    ///foreing key
    public function position()
    {
        return $this->belongsTo('App\Models\Sistema\Position', 'cargo_id');
    }


    ////foreing key
    public function preferences()
    {
        return $this->hasOne('App\Models\UserPreference', 'usuario_id');
    }




    protected $dates = ['deleted_at'];

}