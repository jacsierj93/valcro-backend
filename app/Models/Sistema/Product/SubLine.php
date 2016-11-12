<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 09/05/2016
 * Time: 17:24
 */

namespace App\Models\Sistema\Masters;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubLine extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_sublinea';

    public function linea()
    {
        return $this->belongsTo('App\Models\Sistema\Master\Line','linea_id');
    }

}