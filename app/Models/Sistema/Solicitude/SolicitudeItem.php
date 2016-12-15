<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Solicitude;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class SolicitudeItem extends Model
{
    use SoftDeletes;
    protected $table = "tbl_solicitud_item";
    protected $dates = ['deleted_at'];

    public function producto(){
        return $this->belongsTo('App\Models\Sistema\Product\Product', 'producto_id');
    }
}