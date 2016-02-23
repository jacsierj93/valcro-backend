<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 3:53 PM
 */

namespace App\Models\Profit;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{

    protected $table = "art";
    protected $primaryKey = "co_art";
    protected $connection = "profit";





}