<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Tariffs;
use App\Models\Sistema\Masters\Monedas;
use App\Models\Sistema\Masters\Ports;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TariffAttachment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_tarifa_doc_adj";
    protected $dates = ['deleted_at'];


}

