<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Tariffs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreigthForwarder extends Model
{
    use SoftDeletes;
    protected $table = "tbl_freight_forwarder";
    protected $dates = ['deleted_at'];



}

