<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Tariffs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;

class Naviera extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_naviera";
    protected $dates = ['deleted_at'];

    /**
     * tarifas
     */
    public function tariffs(){
        return $this->hasMany('App\Models\Sistema\Tariffs\Tariff', 'naviera_id');

    }

}

