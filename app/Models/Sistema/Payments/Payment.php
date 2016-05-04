<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Payments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\BankAccount;
use App\Models\Sistema\BankAccountProvidert;



class Payment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_pago";


    /**@return Proveedor de pago*/
    public function getProveedor(){
        return $this->belongsTo('App\Models\Sistema\Proveedor', 'prov_id');
    }

    /**@return BankAccount bancaria**/
    public function getBankAccount(){
        return $this->belongsTo('App\Models\Sistema\BankAccount', 'cuenta_id');
    }

    /**@return BankAccountProvidert  de provedor**/
    public function getBankAccountProvider(){
        return $this->belongsTo('App\Models\Sistema\BankAccountProvider', 'prov_cuenta_id');
    }

    ////foreing key
    public function moneda()
    {
        return $this->hasOne('App\Models\Monedas', 'moneda_id');
    }


}