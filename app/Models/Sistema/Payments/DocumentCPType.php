<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Quotation;

class DocumentCPType extends Model
{

    use SoftDeletes;
    protected $table = "tbl_docum_cp_tipo";

    protected $dates = ['deleted_at'];


}