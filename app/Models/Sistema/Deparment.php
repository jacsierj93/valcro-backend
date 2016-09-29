<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Deparment extends Model
{

    use SoftDeletes;
    protected $table = 'tbl_departament';
    protected $dates = ['deleted_at'];


}