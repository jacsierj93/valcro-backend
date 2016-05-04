<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 23/2/2016
 * Time: 6:39 PM
 */

namespace App\Models\Sistema\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Quotation;

class DocumentCP extends Model
{

    use SoftDeletes;
    protected $table = "tbl_docum_cp";
    protected $dates = ['deleted_at'];



    /**@return Proveedor de pago*/
    public function proveedor(){
        return $this->belongsTo('App\Models\Sistema\Provider', 'prov_id');
    }

    /**tipo de documento
     * @return mixed
     */
    public function tipo(){
        return $this->belongsTo('App\Models\Sistema\Payments\DocumentCPType', 'tipo_id');
    }

    ////foreing key
    public function moneda()
    {
        return $this->hasOne('App\Models\Monedas', 'moneda_id');
    }




}