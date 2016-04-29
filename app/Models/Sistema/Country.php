<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema;




use Illuminate\Database\Eloquent\Model;
use DB;
use App\Quotation;

class Country extends Model
{
    protected $table = "tbl_pais";

    public function states(){
        return $this->hasMany('App\Models\Sistema\State', 'in_location');
    }

}