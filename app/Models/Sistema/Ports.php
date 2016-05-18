<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 17/05/2016
 * Time: 10:50
 */

namespace App\Models\Sistema;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Quotation;
class Ports extends Model
{
    protected $table = "tbl_ports";
    protected $cast = array(
        "id"=>"int"
    );
}