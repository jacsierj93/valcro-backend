<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\KitchenBoxs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class KitchenBox extends Model
{
    use SoftDeletes;
    protected $table = "tbl_kitchen_box";


}