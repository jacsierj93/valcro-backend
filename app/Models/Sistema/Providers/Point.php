<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 27/05/2016
 * Time: 15:29
 */

namespace App\Models\Sistema\Providers;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Point extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_punto';

    public function moneda(){
        return $this->hasOne('App\Models\Sistema\Masters\Monedas',"id","moneda_id");
    }
    public function linea(){
        return $this->hasOne('App\Models\Sistema\Masters\Line',"id","linea_id");
    }
}