<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 20/10/2016
 * Time: 10:25
 * almacenes de valcro en venezuela
 */

namespace App\Models\Sistema\Masters;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreValcro extends Model
{
    use SoftDeletes;
    protected $table = 'tbl_almacen';


}