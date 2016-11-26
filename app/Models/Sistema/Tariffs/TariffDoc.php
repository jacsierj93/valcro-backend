<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Tariffs;
use App\Models\Sistema\Masters\FileModel;
use App\Models\Sistema\Masters\Monedas;
use App\Models\Sistema\Masters\Ports;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TariffDoc extends Model
{
    use SoftDeletes;
    protected $table = "tbl_tarifa_doc";
    protected $dates = ['deleted_at'];

    public function items() {
        return $this->hasMany('App\Models\Sistema\Tariffs\Tariff', 'doc_id');
    }
    public function attachments() {
        return $this->hasMany('App\Models\Sistema\Tariffs\TariffAttachment', 'doc_id');
    }

    public function attachmentsFile(){
        $models= $this->attachments()->get();
        $data = [];

        foreach($models as $aux){
            $att = [];
            $file= FileModel::findOrFail($aux->archivo_id);
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

    public function shipments() {
            return $this->hasMany('App\Models\Sistema\Tariffs\Tariff', 'doc_id');
    }

    public function countShipments(){
       return $this->items()
            ->join('tbl_embarque','tbl_embarque.tarifa_id','=','tbl_tarifa.id' )
            ->where('tbl_tarifa.doc_id', $this->id)
            ->whereNull('tbl_embarque.deleted_at')
            ->count('tbl_tarifa.id');
    }





}

