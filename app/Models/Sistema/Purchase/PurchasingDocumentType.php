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


/**@deprecate**/

class PurchasingDocumentType extends Model
{
    use SoftDeletes;
    protected $table = "tbl_docum_cp_tipo";
    protected $dates = ['deleted_at'];


}