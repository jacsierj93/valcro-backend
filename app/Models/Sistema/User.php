<?php
namespace App\Models\Sistema;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class User extends Model
{

    use SoftDeletes;
    protected $table = 'tbl_usuario';


    protected $dates = ['deleted_at'];

}