<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 28/04/2016
 * Time: 18:33
 */

namespace App\Models\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Quotation;

class City extends Model
{
    protected $table = "tbl_ciudad";

    public function estate(){
        return $this->belongsTo("App\Models\Sistema\State","in_location");
    }
}