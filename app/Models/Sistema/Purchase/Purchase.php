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
use App\Models\Sistema\Provider;
use App\Models\Sistema\ProviderCondPayItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;



class Purchase extends Model
{
    use SoftDeletes;
    protected $table = "tbl_compra_orden";
    protected $dates = ['deleted_at'];
    //protected $appends = array('tipo');

    public function  getTipo(){
        return 'Orden de Compra';
    }
    public function  getTipoId(){
        return 23;
    }

    public function type_origen(){
        return $this->hasOne('App\Models\Sistema\Other\SourceType', 'tipo_origen_id');
    }
    /*   public function getTypeAttribute()
      {

      }
     public function getTypevalueAttribute()
      {
          return 23;
      }
  */
    public function items(){
        return $this->hasMany('App\Models\Sistema\Purchase\PurchaseItem', 'doc_id');
    }

    public function newItem(){
        return new PurchaseItem();
    }
    public function newAttachment(){
        return new PurchaseAttachment();
    }

    /**
     * adjuntos del documento
     */
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

    public function builtPaymentDocs(){
        //**generacion de cuotas de pago*/
        $resul=array();
        $resul['acction'] = "new";
        $codItems = ProviderCondPayItem::where('id_condicion', $this->condicion_pago_id)->get();
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



    /**
     * @return el tipo de producto original
     */
    private function getTypeProduct($producto){

        $idType=$producto->tipo_origen_id;

        if($idType == 4){
            $i=0;
            $aux= $producto;
            do {
                $aux= PurchaseItem::findOrFail($aux->origen_item_id);
                $idType=$aux->tipo_origen_id;
                $i++;

            } while ($idType == 4 && $i<3);
        }
        return SourceType::findOrFail($idType)->id;

    }




    /*

    CREATE TABLE valcro_db2.tbl_compra_orden (
  id int(11) NOT NULL,
  final_id varchar(50) DEFAULT NULL,
  parent_id int(11) DEFAULT NULL,
  doc_parent_id int(11) DEFAULT NULL,
  doc_parent_origen_id int(11) DEFAULT NULL,
  fecha_sustitucion date DEFAULT NULL,
  version int(11) DEFAULT 1,
  emision datetime NOT NULL,
  titulo varchar(100) NOT NULL,
  ult_revision datetime DEFAULT NULL,
  nro_proforma varchar(45) DEFAULT NULL,
  nro_factura varchar(45) DEFAULT NULL,
  img_proforma varchar(100) DEFAULT NULL,
  img_factura varchar(100) DEFAULT NULL,
  img_punto_compra varchar(100) DEFAULT NULL,
  img_abono varchar(45) DEFAULT NULL,
  monto decimal(10, 4) DEFAULT 0.0000,
  comentario longtext DEFAULT NULL,
  prov_id int(11) DEFAULT NULL,
  pais_id int(11) DEFAULT NULL,
  condicion_pago_id int(11) DEFAULT NULL,
  motivo_id int(11) DEFAULT NULL,
  estado_id int(11) NOT NULL DEFAULT 1,
  prov_moneda_id int(11) DEFAULT NULL,
  direccion_almacen_id int(11) DEFAULT NULL,
  direccion_facturacion_id int(11) DEFAULT NULL,
  puerto_id int(11) DEFAULT NULL,
  comentario_cancelacion longtext DEFAULT NULL,
  condicion_id int(11) DEFAULT NULL,
  mt3 varchar(45) DEFAULT NULL,
  peso varchar(45) DEFAULT NULL,
  cancelacion date DEFAULT NULL,
  fecha_aprob_compra date DEFAULT NULL,
  fecha_aprob_gerencia date DEFAULT NULL,
  aprob_compras tinyint(1) DEFAULT NULL,
  aprob_gerencia tinyint(1) DEFAULT NULL,
  culminacion date DEFAULT NULL,
  nro_doc char(20) DEFAULT '',
  tasa decimal(10, 4) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  deleted_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  usuario_id int(11) NOT NULL,
  uid varchar(100) DEFAULT NULL,
  fecha_envio date DEFAULT NULL,
  edit_usuario_id varchar(100) DEFAULT NULL,
  fecha_prodcucion date DEFAULT NULL,
  UNIQUE INDEX id (id)
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;
   */



}