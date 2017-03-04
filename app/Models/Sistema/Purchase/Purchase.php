<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Purchase;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\Payments\DocumentCP;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\ProviderCondPayItem;
use App\Models\Sistema\Providers\ProviderCondPay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Http\Traits\Journal;




class Purchase extends Model
{
    use SoftDeletes;
    use Journal;

    protected $table = "tbl_compra_orden";
    protected $dates = ['deleted_at'];
    public  $deuda =  null;

    /****************************** NO MODIFICABLES *****************************/

    public function  getTipo(){
        return 'Orden de Compra';
    }
    public function  getTipoId(){
        return 23;
    }
    /****************************** FIN NO MODIFICABLES *****************************/
    /****************************** RELACIONALES *****************************/

    public function type_origen(){
        return $this->hasOne('App\Models\Sistema\Other\SourceType', 'tipo_origen_id');
    }
    public function items(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseItem', 'doc_id');
    }

    public function answerds(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseAnswer', 'doc_id');
    }
    /**
     * adjuntos del documento
     */
    public function attachments(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseAttachment', 'doc_id');
    }

    public function provider(){
        return $this->belongsTo('App\Models\Sistema\Providers\Provider', 'prov_id');
    }
    /**
     */
    public function getTypeOrder(){
        return $this->belongsTo('App\Models\Sistema\Order\OrderType', 'tipo_pedido_id');
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

    public function docPayment(){
        return $this->belongsTo('App\Models\Sistema\Payments', 'pago_factura_id');
    }

    //TODO normalizar
    public function estado(){
        return $this->belongsTo('App\Models\Sistema\Order\OrderStatus', 'estado_id');
    }
    /****************************** FIN RELACIONALES *****************************/
    /******************************  RELACIONAL FOR QUERYS *****************************/

    public function customOrders(){

        $items = $this->items()
            ->join('tbl_contra_pedido_item', 'tbl_contra_pedido_item.uid', '=', 'tbl_compra_orden_item.uid')
            ->join('tbl_contra_pedido', 'tbl_contra_pedido_item.doc_id', '=', 'tbl_contra_pedido.id');
        return $items;
    }
    public function kitchenBoxs(){

        $items = $this->items()
            ->join('tbl_kitchen_box', 'tbl_kitchen_box.uid', '=', 'tbl_compra_orden_item.uid');
        return $items;
    }
    public function sustitutes(){
        $items = $this->items()
            ->join('tbl_compra_orden', 'tbl_compra_orden.id', '=', 'tbl_compra_orden_item.doc_id')
            ->where('tipo_origen_id',23)
        ;
        return $items;
    }

    /******************************  END RELACIONAL  FOR QUERYS *****************************/

    /******************************   CALCULATED *****************************/

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
     * e
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
     * genera los documentos de pago
     */
    /******************************  END CALCULATED *****************************/

    /******************************  TRAP *****************************/

    public function builtPaymentDocs(){
        //**generacion de cuotas de pago*/
        $resul=array();
        $resul['acction'] = "new";
        $codItems = \App\Models\Sistema\Providers\ProviderCondPayItem::where('id_condicion', $this->condicion_pago_id)->get();
        $cps= array();
        $hoy= Carbon::now();
        $prv= Provider::findOrFail($this->prov_id);

        // factura
        $cp = new DocumentCP();
        $fVence= $hoy->addDays($codItems->sum('dias'));
        $cp->moneda_id = $this->prov_moneda_id;
        $cp->fecha = $hoy;
        $cp->monto = $this->monto;
        $cp->saldo = $this->monto;
        $cp->tasa = $this->tasa;
        $cp->fecha_vence = $fVence;
        $cp->descripcion ="Factura generada desde una Orden de Compra";
        $cp->tipo_id=4;
        $cp->tipo_prov=$prv->tipo_id;
        $cp->nro_factura = $this->nro_factura;
        $cp->doc_orig="PROF";
        $cp->nro_orig = $this->nro_proforma;
        $cp->prov_id=$this->prov_id;
        if(!$this->nro_factura){
            $cp->nro_factura = $this->nro_proforma;
            $cp->descripcion =$cp->descripcion." perteneciente a la proforma ".$this->nro_proforma;
        }
        $cp->save();
        $id=$cp->id;
        $this->pago_factura_id = $id;
        $this->save();
        $cps[] = $cp;
        if(sizeof($codItems)>1){
            $fac= $cp->replicate();
            foreach($codItems as $aux){
                $cp = new DocumentCP();
                $cp->prov_id=$this->prov_id;
                $fVence= $hoy->addDays($aux->dias);
                $cp->moneda_id = $this->prov_moneda_id;
                $cp->fecha = $hoy;
                $cp->monto = floatval($this->monto * (floatval(  $aux->porcentaje /100)));
                $cp->saldo = floatval($this->monto * (floatval( $aux->porcentaje / 100)));
                $cp->tasa = $this->tasa;
                $cp->fecha_vence = $fVence;
                $cp->descripcion = $aux->getText();
                $cp->tipo_id=5;// cuota
                $cp->tipo_prov=$prv->tipo_id;
                $cp->doc_orig="FACT";
                $cp->nro_orig = $id;
                if(!$this->nro_factura){
                    $cp->nro_factura = $this->nro_proforma;
                }
                $cps[] = $cp;
                $cp->save();
            }
            $fac->fecha_vence=$fVence;

        }else{
            $cp->saldo=0;
            $cp->save();
        }
        $resul['items'] = $cps;

        return $resul;


        /*$auxDate= date_create($this->emision);
        $auxEmit= Carbon::createFromDate($auxDate->format("Y"),$auxDate->format("m"),$auxDate->format("d"));*/



    }

    public function makedebt(){

        $this->deuda = 3000;
    }
    public function newItem(){
        return new PurchaseItem();
    }
    public function newAttachment(){
        return new PurchaseAttachment();
    }


}