<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Payments;

use App\Quotation;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentForm extends Model
{

    use SoftDeletes;
    protected $table = "tbl_pago_forma_pago";

    protected $dates = ['deleted_at'];

    public function tipo()
    {
        return $this->belongsTo('App\Models\Sistema\Payments\PaymentType', 'tipo_id');
    }

    public function pago()
    {
        return $this->belongsTo('App\Models\Sistema\Payments\Payment', 'pago_id');
    }


}