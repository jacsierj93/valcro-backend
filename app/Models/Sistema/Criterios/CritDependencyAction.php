<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 24/11/16
 * Time: 02:23 PM
 */

namespace App\Models\Sistema\Criterios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;


class CritDependencyAction extends Model
{
    use SoftDeletes;

    use Journal;
    protected $table = "tbl_crit_dependencia";

}