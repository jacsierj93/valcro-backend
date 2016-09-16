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



class ProviderCondPayItem extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_cond_pag_item";

    public function getText(){
        return  $this->porcentaje.'% al '.$this->descripcion." ".$this->dias.' dias';

    }

}