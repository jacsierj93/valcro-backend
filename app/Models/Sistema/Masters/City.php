<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 28/04/2016
 * Time: 18:33
 */

namespace App\Models\Sistema\Masters;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Quotation;

class City extends Model
{
    protected $table = "tbl_ciudad";

    public function state(){
        return $this->belongsTo("App\Models\Sistema\Masters\State","in_location");
    }
}