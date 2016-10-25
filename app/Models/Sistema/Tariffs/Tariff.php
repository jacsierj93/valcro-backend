<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Tariffs;
use App\Models\Sistema\Masters\Monedas;
use App\Models\Sistema\Masters\Ports;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends Model
{
    use SoftDeletes;
    protected $table = "tbl_tarifa";
    protected $dates = ['deleted_at'];

  public function objs(){
      $return = ['freight_forwarder_id'=>null, 'naviera_id'=>null, 'puerto_id' => null];

      if($this->freight_forwarder_id != null){
          $return['freight_forwarder_id'] = FreigthForwarder::find($this->freight_forwarder_id);
      }
      if($this->naviera_id != null){
          $return['naviera_id'] = Naviera::find($this->naviera_id);
      }
      if($this->puerto_id != null){
          $return['puerto_id'] = Ports::find($this->puerto_id);
      }
      if($this->moneda_id != null){
          $return['moneda_id'] = Monedas::find($this->moneda_id);
      }
      return $return;
  }
}

