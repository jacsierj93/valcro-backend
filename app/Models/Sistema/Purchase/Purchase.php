<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 03:02 PM
 */

namespace App\Models\Sistema\Purchase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;



class Purchase extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden";
    protected $dates = ['deleted_at'];
    protected $appends = array('tipo');

    public function getTypeAttribute()
    {
        return 'Orden de Compra';
    }

    public function items(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseItem', 'doc_id');
    }

    public function attachments(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseAttachment', 'doc_id');
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

    public function getPaymentsDoc(){
        //**generacion de cuotas de pago*/
        $codItems = ProviderCondPayItem::where('id_condicion', $this->condicion_pago_id)->get();
        $cps= array();
        $hoy= Carbon::now();

        // factura
        $aux = new DocumentCP();
        $fVence= $hoy->addDays($codItems->sum('dias'));
        $aux->nro_factura = $this->nro_factura;
        $aux->moneda_id = $this->prov_moneda_id;
        $aux->fecha = $hoy;
        $aux->monto = $this->monto;
        $aux->saldo = $this->monto;
        $aux->tasa = $this->tasa;
        $aux->fecha_vence = $fVence;



        /*$auxDate= date_create($this->emision);
        $auxEmit= Carbon::createFromDate($auxDate->format("Y"),$auxDate->format("m"),$auxDate->format("d"));*/



    }





}