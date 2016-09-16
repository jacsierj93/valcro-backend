<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Providers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class BankAccount extends Model
{
    use SoftDeletes;
    protected $table = "tbl_cuenta_bancaria";
    protected $touches = ['provider'];

    public  function getAdvancePaymentProvider(){
        return $this->belongsTo('App\Models\Sistema\AdvancePaymentProvider', 'cuenta_id');
    }

    public function provider(){
        return $this->belongsTo('App\Models\Sistema\Providers\Provider', 'cuenta_id');
    }

    /**@return ciudad de la cuenta*/
    public function ciudad(){
        return $this->belongsTo('App\Models\Sistema\Masters\City', 'ciudad_id');
    }




}