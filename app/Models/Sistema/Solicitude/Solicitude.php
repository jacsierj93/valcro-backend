<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Solicitude;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\ProdTime;
use App\Models\Sistema\TiemAproTran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Collection;

use DB;
use Carbon\Carbon;

class Solicitude extends Model
{
    use SoftDeletes;
    protected $table = "tbl_solicitud";
    protected $dates = ['deleted_at'];

    public function  getTipo(){
        return 'Solicitud';
    }
    public function  getTipoId(){
        return 21;
    }

    public function type_origen(){
        return $this->hasOne('App\Models\Sistema\Other\SourceType', 'tipo_origen_id');
    }

    public function provider(){
        return $this->belongsTo('App\Models\Sistema\Providers\Provider', 'prov_id');
    }
    public function CondPay(){
        return $this->belongsTo('App\Models\Sistema\Providers\ProviderCondPay', 'condicion_pago_id');
    }
    public function country(){
        return $this->belongsTo('App\Models\Sistema\Masters\Country', 'pais_id');
    }
    public function store(){
        return $this->belongsTo('App\Models\Sistema\Providers\ProviderAddress', 'direccion_almacen_id');
    }
    public function port(){
        return $this->belongsTo('App\Models\Sistema\Masters\Ports', 'puerto_id');

    }
    public function coin(){
        return $this->belongsTo('App\Models\Sistema\Masters\Monedas', 'prov_moneda_id');

    }


    public function items(){
        return $this->hasMany('App\Models\Sistema\Solicitude\SolicitudeItem', 'doc_id');
    }

    public function answerds(){
        return $this->hasMany('App\Models\Sistema\Solicitude\SolicitudeAnswer', 'doc_id');
    }


    public function customOrders(){

        $items = $this->items()
            ->join('tbl_contra_pedido_item', 'tbl_contra_pedido_item.uid', '=', 'tbl_solicitud_item.uid')
            ->join('tbl_contra_pedido', 'tbl_contra_pedido_item.doc_id', '=', 'tbl_contra_pedido.id');
        return $items;
    }
    public function kitchenBoxs(){

        $items = $this->items()
            ->join('tbl_kitchen_box', 'tbl_kitchen_box.uid', '=', 'tbl_solicitud_item.uid');
        return $items;
    }
    public function sustitutes(){

        $items = $this->items()
            ->join('tbl_solicitud', 'tbl_solicitud.id', '=', 'tbl_solicitud_item.doc_id')
            ->where('tipo_origen_id',21)
        ;
        return $items;
    }

    /**
     * adjuntos del documento
     */
    public function attachments(){
        return $this->hasMany('App\Models\Sistema\Solicitude\SolicitudeAttachment', 'doc_id');
    }

    public function newItem(){
        return new SolicitudeItem();
    }
    public function newAttachment(){
        return new SolicitudeAttachment();
    }

    /**
     * @return el numero de contra pedido asignados a este pedido
     */
    public function getNumItem($tipo){
        $i=0;
        $items = $this->items()->get();
        foreach($items as $aux){
            $tip=$this->getTypeProduct($aux);
            if($tip == $tipo){
                $i++;
            }

        }

        return $i;
    }

    /**
     * Metodo que calcula la categoria de llegada del pedido
     * @return categoria de llegada
     */
    public function arrival(){
        $estatus = 100;

        if(
            $this->culminacion != null
            && $this->cancelacion == null
            && $this->aprob_gerencia == 1
//           && $this->aprob_compras == 1

        ){
            $auxCul= date_create($this->culminacion);
            $culminacion= Carbon::createFromDate($auxCul->format("Y"),$auxCul->format("m"),$auxCul->format("d"));
            $tmFabri = ProdTime::where('prov_id',$this->prov_id)->first()->max_dias;
            $tmTrn = TiemAproTran::where('prov_id',$this->prov_id)->first()->max_dias;

            $can_dias= $tmFabri + $tmTrn;
            $llegada= $culminacion->copy()->addDay($can_dias);

            $dias=Carbon::now()->diffInDays($llegada);

            if ($dias <= 0) {
                $estatus = 0;
            } else if ($dias <= 7) {
                $estatus = 7;
            } else if ($dias > 7 && $dias <= 30) {
                $estatus = 30;
            } else if ($dias > 30 && $dias <= 60) {
                $estatus = 60;
            } else if ($dias > 60 && $dias <= 90) {
                $estatus = 90;
            }

        }

        return $estatus;//->format("d");
    }


    /**
     * Metodo que calcula la categoria de llegada del pedido
     * @return categoria de llegada
     */
    public function daysCreate(){
        $estatus = 100;
        $auxDate= date_create($this->emision);
        $auxEmit= Carbon::createFromDate($auxDate->format("Y"),$auxDate->format("m"),$auxDate->format("d"));
        $dias=Carbon::now()->diffInDays($auxEmit);
        if ($dias <= 0) {
            $estatus = 0;
        } else if ($dias <= 7) {
            $estatus = 7;
        } else if ($dias > 7 && $dias <= 30) {
            $estatus = 30;
        } else if ($dias > 30 && $dias <= 60) {
            $estatus = 60;
        } else if ($dias > 60 && $dias <= 90) {
            $estatus = 90;
        }



        return $estatus;//->format("d");
    }

    /**
     * Metodo que calcula la categoria de llegada del pedido
     * @return categoria de llegada
     */
    public function catLastReview(){
        if($this->ult_revision  == null ){
            return   $this->daysCreate();
        }
        $estatus = 100;
        $auxDate= date_create($this->ult_revision);
        $auxEmit= Carbon::createFromDate($auxDate->format("Y"),$auxDate->format("m"),$auxDate->format("d"));
        $dias=Carbon::now()->diffInDays($auxEmit);
        if ($dias <= 0) {
            $estatus = 0;
        } else if ($dias <= 7) {
            $estatus = 7;
        } else if ($dias > 7 && $dias <= 30) {
            $estatus = 30;
        } else if ($dias > 30 && $dias <= 60) {
            $estatus = 60;
        } else if ($dias > 60 && $dias <= 90) {
            $estatus = 90;
        }
        return $estatus;//->format("d");
    }
    /**
     * @deprecated */
    private function dateDiff($dateIni, $dateEnd)
    {
        $from = date_create($dateIni);
        $to = date_create($dateEnd);
        $diff = date_diff($to, $from);
        return (int)$diff->format('%R%d');
    }

    /**
     * @return el tipo de producto original
     */
    private function getTypeProduct($producto){

        $idType=$producto->tipo_origen_id;

        if($idType == 4){
            $i=0;
            $aux= $producto;
            do {
                $aux= SolicitudeItem::findOrFail($aux->origen_item_id);
                $idType=$aux->tipo_origen_id;
                $i++;

            } while ($idType == 4 && $i<3);
        }
        return SourceType::findOrFail($idType)->id;

    }
    /**************************** descontinuado**********************

    /*     */
    public function getOrders(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseOrder', 'pedido_id');
    }

    /**
     */
    public function getTypeOrder(){
        return $this->belongsTo('App\Models\Sistema\Order\OrderType', 'tipo_pedido_id');
    }

}