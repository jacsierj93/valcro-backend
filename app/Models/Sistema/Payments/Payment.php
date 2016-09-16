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


class Payment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_pago";
    protected $dates = ['deleted_at'];


    /**@return Proveedor de pago */
    public function proveedor()
    {
        return $this->belongsTo('App\Models\Sistema\Provider', 'prov_id');
    }


    public function documentos()
    {
        return $this->hasMany('App\Models\Sistema\Purchase\PaymentDocumentCP', 'pago_id');
    }


    /**@return BankAccountProvidert  de provedor* */
    public function cuentaBancariaProveedor()
    {
        return $this->belongsTo('App\Models\Sistema\Providers\BankAccount', 'prov_cuenta_id');
    }

    ////foreing key
    public function moneda()
    {
        return $this->belongsTo('App\Models\Sistema\Masters\Monedas', 'moneda_id');
    }


    /**nombre del estatus
     * @return string
     */
    public function estatus_nombre()
    {
        switch ($this->estatus) {
            case 1:
                $nombre = "Nuevo";
                break;
            case 2:
                $nombre = "Procesado";
                break;
            case 3:
                $nombre = "Cancelado";
                break;
        }

        return $nombre;
    }


}