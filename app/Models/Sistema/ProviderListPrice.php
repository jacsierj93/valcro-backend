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



class ProviderListPrice extends Model
{
    use SoftDeletes;
    protected $table = "tbl_prov_lista_precio";

    public function adjuntos(){
        return $this->belongsToMany('App\Models\Sistema\FileModel', 'tbl_listaprecio_archivo', 'listaprecio_id', 'archivo_id');
    }

}