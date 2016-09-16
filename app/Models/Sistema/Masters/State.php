<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 28/04/2016
 * Time: 18:30
 */

namespace App\Models\Sistema\Masters;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Quotation;

class State extends Model
{
    protected $table = "tbl_estado";

    public function cities(){
        return $this->hasMany('App\Models\Sistema\Masters\City', 'in_location');
    }

    public function country(){
        return $this->belongsTo("App\Models\Sistema\Masters\Country","in_location");
    }
}