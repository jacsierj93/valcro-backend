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



class BankAccount extends Model
{
    use SoftDeletes;
    protected $table = "tbl_cuenta_bancaria";

    public  function getAdvancePaymentProvider(){

        return $this->belongsTo('App\Models\Sistema\AdvancePaymentProvider', 'cuenta_id');
    }



}