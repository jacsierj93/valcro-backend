<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class AdvancePaymentProvider extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_adelanto";

    /**@return tipo de pago*/
    public function getPaymentType(){
        return $this->hasOne('App\Models\Sistema\PaymentType', 'id', 'tipo_pago_id');
    }

    /**@return cuenta bancaria**/
    public function getBankAccount(){
        return $this->hasOne('App\Models\Sistema\BankAccount', 'id', 'cuenta_id');
    }

    /**@return cuenta bancaria de provedor**/
    public function getBankAccountProvider(){
        return $this->hasOne('App\Models\Sistema\BankAccountProvider', 'id', 'prov_cuenta_id');
    }

}