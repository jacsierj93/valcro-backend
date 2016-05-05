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



class ProviderCreditLimit extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_lim_credito";

    public function provider(){
        $this->belongsTo('App\Models\Sistema\Provider',"prov_id");
    }

    public function coins(){
        $this->hasOne('App\Models\Sistema\Monedas',"monedas_id");
    }
}