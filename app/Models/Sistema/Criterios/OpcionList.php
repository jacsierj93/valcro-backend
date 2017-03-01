<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 14/11/16
 * Time: 06:30 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;


class OpcionList extends Model
{
    use SoftDeletes;
    use Journal;
    protected $table = "tbl_crit_opcionList";
}