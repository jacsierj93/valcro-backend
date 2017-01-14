<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Journal;



/**@deprecate**/

class PurchasingDocumentType extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_docum_cp_tipo";
    protected $dates = ['deleted_at'];


}