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
        return $this->hasOne('App\Models\Sistema\Proveedor', 'id', 'prov_id');
    }

    /**@return BankAccount bancaria**/
    public function getBankAccount(){
        return $this->hasOne('App\Models\Sistema\BankAccount', 'id', 'cuenta_id');
    }

    /**@return BankAccountProvidert  de provedor**/
    public function getBankAccountProvider(){
        return $this->hasOne('App\Models\Sistema\BankAccountProvider', 'id', 'prov_cuenta_id');
    }


}