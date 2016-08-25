<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 10/05/2016
 * Time: 18:42
 */

namespace App\Models\Sistema\Masters;
use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;
    protected $table="tbl_languages";
}