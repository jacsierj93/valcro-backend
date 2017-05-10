<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 13/02/17
 * Time: 12:07 PM
 */

namespace App\Models\Sistema\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;

class ProductComponent extends Model
{
    use SoftDeletes;
    use Journal;
    protected $table = "tbl_prod_comp";
}