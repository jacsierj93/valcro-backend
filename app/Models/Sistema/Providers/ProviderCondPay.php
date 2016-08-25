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



class ProviderCondPay extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_cond_pag";

    public function getItems(){
        return $this->hasMany('App\Models\Sistema\Providers\ProviderCondPayItem', 'id_condicion', 'id');
    }

    public function line(){
        return $this->hasOne('App\Models\Sistema\Masters\Line','id','linea_id');
    }


}