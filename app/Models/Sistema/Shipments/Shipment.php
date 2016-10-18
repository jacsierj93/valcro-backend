<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Shipments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sistema\Masters\FileModel;


class Shipment extends Model
{
    use SoftDeletes;
    protected $table = "tbl_embarque";
    protected $dates = ['deleted_at'];
    protected  $adjuntos =[];
    /**
     * adjuntos del documento
     */
    public function attachments(){
       // $this->adjuntos = $this->hasMany('App\Models\Sistema\Shipments\ShipmentAttachment', 'embarque_id')->get();
        return $this->hasMany('App\Models\Sistema\Shipments\ShipmentAttachment', 'embarque_id');

    }

    public function attachmentsFile($doc){
        $models= $this->attachments()->where('documento',$doc)->get();
        $data = [];

        foreach($models as $att){
            $aux = [];
            $file= File::findOrFail($aux->archivo_id);
            $att['id'] = $aux->id;
            $att['archivo_id'] = $aux->archivo_id;
            $att['documento'] = $aux->documento;
            $att['comentario'] = $aux->comentario;
            $att['thumb']=$file->getThumbName();
            $att['tipo']=$file->tipo;
            $att['file'] = $file->archivo;
            $data[]= $att;
        }
        return $data;
    }
    /**
     *Container del embarq
     */
    public function containers(){
        return $this->hasMany('App\Models\Sistema\Shipments\Container', 'embarque_id');
    }

}