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

class TariffDoc extends Model
{
    use SoftDeletes;
    protected $table = "tbl_tarifa_doc";
    protected $dates = ['deleted_at'];

    public function items() {
        return $this->hasMany('App\Models\Sistema\Tariffs\Tariff', 'doc_id');
    }
    public function attachments() {
        return $this->hasMany('App\Models\Sistema\Tariffs\TariffAttachment', 'doc_id');
    }



}

