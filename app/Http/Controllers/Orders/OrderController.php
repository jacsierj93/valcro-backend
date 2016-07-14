<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Masters\MasterProductController;
use App\Libs\Utils\Files;

use App\Models\Sistema\Country;
use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\FileModel;
use App\Models\Sistema\Order\OrderAttachment;
use App\Models\Sistema\Product\Product;
use App\Models\Sistema\CustomOrders\CustomOrderPriority;
use App\Models\Sistema\CustomOrders\CustomOrderReason;
use App\Models\Sistema\KitchenBoxs\KitchenBox;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\Order\Order;
use App\Models\Sistema\Order\OrderCondition;
use App\Models\Sistema\Order\OrderItem;
use App\Models\Sistema\Order\OrderPriority;
use App\Models\Sistema\Order\OrderReason;
use App\Models\Sistema\Order\OrderStatus;
use App\Models\Sistema\Order\OrderType;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Ports;
use App\Models\Sistema\Product\ProductType;
use App\Models\Sistema\Provider;
use App\Models\Sistema\ProviderAddress;
use App\Models\Sistema\ProviderCondPayItem;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\Purchase\Purchase;
use App\Models\Sistema\Purchase\PurchaseAttachment;
use App\Models\Sistema\Purchase\PurchaseItem;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Solicitude\Solicitude;
use App\Models\Sistema\Solicitude\SolicitudeAttachment;
use App\Models\Sistema\Solicitude\SolicitudeItem;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

class OrderController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    /*********************** SYSTEM ************************/
    /**
     * trae los documentos que no fueron fnalizados
     */
    public function getUnClosetDocument(){
        $docsUnclose = array();
        $data = array();
        $monedas = Monedas::get();


        $docsUnclose[0] = Solicitude::whereNull("final_id")
//            ->where('aprob_compras',0)
//            ->where('aprob_gerencia',0)
            ->whereNull('cancelacion')
            ->get();

        $docsUnclose[1] = Order::whereNull("final_id")
//            ->where('aprob_compras',0)
//            ->where('aprob_gerencia',0)
            ->whereNull('cancelacion')
            ->get();
        $docsUnclose[2] = Purchase::whereNull("final_id")
//            ->where('aprob_compras',0)
//            ->where('aprob_gerencia',0)
//            ->whereNull('cancelacion')
            ->get();
        foreach($docsUnclose as $docs){
            foreach($docs  as $aux){
                $temp= array();
                $temp['id']=$aux->id;
                $temp['documento'] = $aux->getTipo();
                $temp['titulo'] = $aux->titulo;
                $temp['monto'] = $aux->monto;
                $temp['symbol'] = $monedas->where('id',$aux->prov_moneda_id)->first()->simbolo;
                $temp['emision'] = $aux->emision;
                $temp['comentario'] = $aux->comentario;
                $temp['prov_id'] = $aux->prov_id;
                $temp['productos'] = $this->getProductoItem($aux);

                $data[] = $temp;


            }
        }
        return $data;
    }

    public function UpLoadFiles(Request $req){

        $fil= array();
        $archivo = new Files("orders");
        //  dd($req->file("file"));
        $archivo->upload("file"); ///probando
        $resul['accion']= "upLoad";

        $fil['id']= $archivo->getCurrentFileId();
        $fil['file']= $archivo->getCurrentFileName();
        $fil['thumb']= $archivo->getCurrentFileThumbName();
        $fil['tipo']= $archivo->getCurrentFileType();
        $resul['file']= $fil;

        return $resul;
    }

    /*********************** PROVIDER ************************/

    /**
     * obtiene la lista de proveedores
     */
    public function getProviderList(Request $req)
    {

        $rawn = "id, razon_social ,(select sum(monto)
         from tbl_proveedor as proveedor inner join tbl_compra_orden on proveedor.id = tbl_compra_orden.prov_id
         where tbl_compra_orden.prov_id = tbl_proveedor.id and tbl_compra_orden.deleted_at is null  ) as deuda";

        $rawn .= " , (".$this->generateProviderQuery("emision","<=0").") as emit0 ";
        $rawn .= " , (".$this->generateProviderQuery("emision"," BETWEEN 1 and  7 ").") as emit7 ";
        $rawn .= " , (".$this->generateProviderQuery("emision"," BETWEEN 7 and  30 ").") as emit30 ";
        $rawn .= " , (".$this->generateProviderQuery("emision"," BETWEEN 31 and  60 ").") as emit60 ";
        $rawn .= " , (".$this->generateProviderQuery("emision"," BETWEEN 61 and  90 ").") as emit90 ";
        $rawn .= " , (".$this->generateProviderQuery("emision"," > 90 ").") as emit100 ";

        $rawn .= " , (".$this->generateProviderQuery("ult_revision","<=0").") as review0 ";
        $rawn .= " , (".$this->generateProviderQuery("ult_revision"," BETWEEN 1 and  7 ").") as review7 ";
        $rawn .= " , (".$this->generateProviderQuery("ult_revision"," BETWEEN 7 and  30 ").") as review30 ";
        $rawn .= " , (".$this->generateProviderQuery("ult_revision"," BETWEEN 31 and  60 ").") as review60 ";
        $rawn .= " , (".$this->generateProviderQuery("ult_revision"," BETWEEN 61 and  90 ").") as review90 ";
        $rawn .= " , (".$this->generateProviderQuery("ult_revision"," > 90 ").") as review100 ";
       // echo $rawn;



        $provs = Provider::selectRaw($rawn)->get();
        //dd($provs);
        $data = array();
        //  $auxCp= Collection::make(array());

        foreach($provs as $prv){
            $paso= true;
            /*if(sizeof($prv->getCountry())>0){
                $paso= true;
            }*/
            if($paso){
                $temp["id"] = $prv->id;
                $temp["razon_social"] = $prv->razon_social;
               /* $temp['deuda']= $prv->purchase()->whereNotNull('final_id')->sum('monto');
                //  $temp['productos']= $prv->proveedor_product()->get();
                $temp['paises'] = $prv->getCountry();
                $peds=$prv->getOrderDocuments();


                $nCp=0;
                $nE0=0;
                $nE7=0;
                $nE30=0;
                $nE60=0;
                $nE90=0;
                $nE100=0;

                $nR0=0;
                $nR7=0;
                $nR30=0;
                $nR60=0;
                $nR90=0;
                $nR100=0;

                foreach($peds as $ped){
                    $arrival=$ped->daysCreate();

                    if ($arrival == 0) {
                        $nE0++;
                    } else if ($arrival == 7) {
                        $nE7++;
                    } else if ($arrival == 30) {
                        $nE30++;
                    } else if ($arrival == 60) {
                        $nE60++;
                    } else if ($arrival == 90) {
                        $nE90++;
                    } else if($arrival == 100 ){
                        $nE100++;
                    }
                    if($ped->comentario_cancelacion == null && $ped->aprob_compras == 0 &&   $ped->aprob_gerencia == 0){
                        $review=$ped->catLastReview();
                        if ($review == 0) {
                            $nR0++;
                        } else if ($review == 7) {
                            $nR7++;
                        } else if ($review == 30) {
                            $nR30++;
                        } else if ($review == 60) {
                            $nR60++;
                        } else if ($arrival == 90) {
                            $nR90++;
                        } else if($review == 100 ){
                            $nR100++;
                        }
                    }

                    if($ped->getTipoId() == 23){
                        $nCp +=$ped->getNumItem(2);
                    }


                }
                $temp['emit0']=$nE0;
                $temp['emit7']=$nE7;
                $temp['emit30']=$nE30;
                $temp['emit60']=$nE60;
                $temp['emit90']=$nE90;
                $temp['emit100']=$nE100;

                $temp['review0']=$nE0;
                $temp['review7']=$nE7;
                $temp['review30']=$nE30;
                $temp['review60']=$nE60;
                $temp['review90']=$nE90;
                $temp['review100']=$nE100;


                $temp['contraPedido']= $nCp;*/
                $data[] =$temp;
            }

        }

        return $provs;
    }

    /**
     * cuentas los provedores que pueden hacer pedidos
     */

    public function countProvider(){
        //$data =Provider::selectRaw("count('id')")->get()->get(0)[0];
        $data['value'] =Provider::selectRaw("count('id')")->get()->get(0)[0];

        return $data;
    }

    /**
     * traue a los provedores
     */

    public function getProviders(Request $req){
        $data = array();
        $provs = Provider::
        //   where('id', 2)->
        Orderby('razon_social')->
        skip($req->skit)->take($req->take)->


        get();
        $data = array();
        //  $auxCp= Collection::make(array());

        foreach($provs as $prv){
            $paso= true;
            if(sizeof($prv->getCountry())>0){
                $paso= true;
            }
           /* if($req->has('skitProv')){
                $exclu = json_decode($req->skitProv);
               foreach($req->skitProv as $aux){
                   if($aux['id'] == $prv->id ){
                       $paso= false;
                       break;
                   }
               }
            }*/
            if($paso){
                $temp["id"] = $prv->id;
                $temp["razon_social"] = $prv->razon_social;
                $temp['deuda']= $prv->purchase()->whereNotNull('final_id')->sum('monto');
                //  $temp['productos']= $prv->proveedor_product()->get();
                $temp['paises'] = $prv->getCountry();
                $peds=$prv->getOrderDocuments();


                $nCp=0;
                $nE0=0;
                $nE7=0;
                $nE30=0;
                $nE60=0;
                $nE90=0;
                $nE100=0;

                $nR0=0;
                $nR7=0;
                $nR30=0;
                $nR60=0;
                $nR90=0;
                $nR100=0;

                foreach($peds as $ped){
                    $arrival=$ped->daysCreate();

                    if ($arrival == 0) {
                        $nE0++;
                    } else if ($arrival == 7) {
                        $nE7++;
                    } else if ($arrival == 30) {
                        $nE30++;
                    } else if ($arrival == 60) {
                        $nE60++;
                    } else if ($arrival == 90) {
                        $nE90++;
                    } else if($arrival == 100 ){
                        $nE100++;
                    }
                    if($ped->comentario_cancelacion == null && $ped->aprob_compras == 0 &&   $ped->aprob_gerencia == 0){
                        $review=$ped->catLastReview();
                        if ($review == 0) {
                            $nR0++;
                        } else if ($review == 7) {
                            $nR7++;
                        } else if ($review == 30) {
                            $nR30++;
                        } else if ($review == 60) {
                            $nR60++;
                        } else if ($arrival == 90) {
                            $nR90++;
                        } else if($review == 100 ){
                            $nR100++;
                        }
                    }

                    if($ped->getTipoId() == 23){
                        $nCp +=$ped->getNumItem(2);
                    }


                }
                $temp['emit0']=$nE0;
                $temp['emit7']=$nE7;
                $temp['emit30']=$nE30;
                $temp['emit60']=$nE60;
                $temp['emit90']=$nE90;
                $temp['emit100']=$nE100;

                $temp['review0']=$nE0;
                $temp['review7']=$nE7;
                $temp['review30']=$nE30;
                $temp['review60']=$nE60;
                $temp['review90']=$nE90;
                $temp['review100']=$nE100;


                $temp['contraPedido']= $nCp;
                $data[] =$temp;
            }

        }

        return $data;
    }



    /**
     * traue a los provedores
     */

    public function getProvider(Request $req){
        $prv = Provider::findOrFail($req->id);
        $temp["id"] = $prv->id;
        $temp["razon_social"] = $prv->razon_social;
        $temp['deuda']= $prv->purchase()->whereNotNull('final_id')->sum('monto');
        $temp['paises'] = $prv->getCountry();
        $peds=$prv->getOrderDocuments();
        $nCp=0;
        $nE0=0;
        $nE7=0;
        $nE30=0;
        $nE60=0;
        $nE90=0;
        $nE100=0;
        $nR0=0;
        $nR7=0;
        $nR30=0;
        $nR60=0;
        $nR90=0;
        $nR100=0;

        foreach($peds as $ped){
            $arrival=$ped->daysCreate();
            if ($arrival == 0) {
                $nE0++;
            } else if ($arrival == 7) {
                $nE7++;
            } else if ($arrival == 30) {
                $nE30++;
            } else if ($arrival == 60) {
                $nE60++;
            } else if ($arrival == 90) {
                $nE90++;
            } else if($arrival == 100 ){
                $nE100++;
            }
            if($ped->comentario_cancelacion == null && $ped->aprob_compras == 0 &&   $ped->aprob_gerencia == 0){
                $review=$ped->catLastReview();
                if ($review == 0) {
                    $nR0++;
                } else if ($review == 7) {
                    $nR7++;
                } else if ($review == 30) {
                    $nR30++;
                } else if ($review == 60) {
                    $nR60++;
                } else if ($arrival == 90) {
                    $nR90++;
                } else if($review == 100 ){
                    $nR100++;
                }
            }

            if($ped->getTipoId() == 23){
                $nCp +=$ped->getNumItem(2);
            }
        }
        $temp['emit0']=$nE0;
        $temp['emit7']=$nE7;
        $temp['emit30']=$nE30;
        $temp['emit60']=$nE60;
        $temp['emit90']=$nE90;
        $temp['emit100']=$nE100;
        $temp['review0']=$nE0;
        $temp['review7']=$nE7;
        $temp['review30']=$nE30;
        $temp['review60']=$nE60;
        $temp['review90']=$nE90;
        $temp['review100']=$nE100;
        $temp['contraPedido']= $nCp;




        return $temp;
    }

    /***
     * obtiene todos los documentos que pueden ser importado por una solictud
     */

    public  function getEmails(Request $req){
        $data = array();

        return $data;
    }

    /*********************** UPDATE ************************/

    public  function UpdateOrder(Request $req){
        $resul['action']="upd";
        $model  = Order::findOrFail($req->id);
        $model->final_id = null;
        $model->save();
        return $resul;
    }

    public  function PurchaseUpdate(Request $req){
        $resul['action']="upd";
        $model  = Purchase::findOrFail($req->id);
        $model->final_id = null;
        $model->save();
        return $resul;
    }

    public  function SolicitudeUpdate(Request $req){
        $resul['action']="upd";
        $model  = Solicitude::findOrFail($req->id);
        $model->final_id = null;
        $model->save();
        return $resul;
    }

    /*********************** IMPORT ************************/

    /**
     * obtiene los pedidos que se pueden inportar
     */
    public  function getOrderToImport(Request $req){
        $data = array();
        $items = Order::where('id', "<>" ,$req->id)
            //  ->where('aprob_compras' ,1)
            //  ->where("aprob_gerencia", 1)
            ->whereNull("comentario_cancelacion");

        $type = OrderType::get();
        $items = $items->get();
        $prov = Provider::findOrFail($req->prov_id);
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();
        $purchase = Purchase::get();
        foreach($items as $aux){
            $paso= true;
            if(sizeof($purchase->where('doc_parent_id', $aux->id)->where('doc_parent_origen_id','21'))>0){
                $paso=false;
            }
            if($paso){
                //para maquinas
                $tem = array();
                $tem['id']=$aux->id;
                //$tem['tipo_id']=$aux->tipo_pedido_id;
                $tem['pais_id']=$aux->pais_id;
                $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
                $tem['condicion_pago_id']=$aux->condicion_pago_id;
                $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
                $tem['prioridad_id']=$aux->prioridad_id;
                $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
                $tem['prov_moneda_id']=$aux->prov_moneda_id;
                $tem['estado_id']=$aux->estado_id;
                // $tem['tipo_value']=$aux->typevalue;
                // pra humanos
                $tem['comentario']=$aux->comentario;
                $tem['titulo']=$aux->titulo;
                $tem['tasa']=$aux->tasa;
                $tem['proveedor']=$prov->razon_social;
                $tem['documento']= $aux->getTipo();
                $tem['diasEmit']=$aux->daysCreate();
                $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
                $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
                $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
                $tem['img_aprob'] =$aux->fecha_aprob_compra ;


                if($aux->motivo_id){
                    $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
                }
                if($aux->pais_id){
                    //$tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
                }
                if($aux->prioridad_id){
                    $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
                }
                if($aux->prov_moneda_id){
                    $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
                }
                if($aux->prov_moneda_id){
                    $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
                }
                if($aux->tipo_id != null){
                    $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
                }


                $tem['nro_proforma']=$aux->nro_proforma;
                $tem['nro_factura']=$aux->nro_factura;
                $tem['img_proforma']=$aux->img_proforma;
                $tem['img_factura']=$aux->img_factura;
                $tem['mt3']=$aux->mt3;
                $tem['peso']=$aux->peso;
                $tem['emision']=$aux->emision;
                $tem['monto']=$aux->monto;

                /**actualizar cuando este el final**/
                $tem['almacen']="Desconocido";

                // modificar cuando se sepa la logica
                $tem['aero']=1;
                $tem['version']=$aux->version;
                $tem['maritimo']=1;
                $data[]=$tem;}
        }


        return $data;
    }

    /**
     * obtiene las solicitudes actas para importacion
     */
    public  function getSolicitudeToImport(Request $req){
        $data = array();
        $items = Solicitude::where('id', "<>" ,$req->id)

            //where('aprob_compras' ,1)
            //  ->where("aprob_gerencia", 1)

            ->whereNull("comentario_cancelacion");
        $type = OrderType::get();
        $items = $items->get();
        $prov = Provider::findOrFail($req->prov_id);
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();
        $ord = Order::get();
        $purchase = Order::get();
        foreach($items as $aux){
            $paso =true;
            $tem = array();

            if(sizeof($ord->where('doc_parent_id', $aux->id)->where('doc_parent_origen_id','21'))>0){
                $paso=false;
            }
            if(sizeof($purchase->where('doc_parent_id', $aux->id)->where('doc_parent_origen_id','21'))>0){
                $paso=false;
            }

            if($paso){
                //para maquinas
                $tem['id']=$aux->id;
                //$tem['tipo_id']=$aux->tipo_pedido_id;
                $tem['pais_id']=$aux->pais_id;
                $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
                $tem['condicion_pago_id']=$aux->condicion_pago_id;
                $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
                $tem['prioridad_id']=$aux->prioridad_id;
                $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
                $tem['prov_moneda_id']=$aux->prov_moneda_id;
                $tem['estado_id']=$aux->estado_id;
                // $tem['tipo_value']=$aux->typevalue;
                // pra humanos
                $tem['comentario']=$aux->comentario;
                $tem['tasa']=$aux->tasa;
                $tem['proveedor']=$prov->razon_social;
                $tem['titulo']=$aux->titulo;
                $tem['documento']= $aux->getTipo();
                $tem['diasEmit']=$aux->daysCreate();
                $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
                $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
                $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
                $tem['img_aprob'] =$aux->fecha_aprob_compra ;


                if($aux->motivo_id){
                    $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
                }
                if($aux->pais_id){
                    $tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
                }
                if($aux->prioridad_id){
                    $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
                }
                if($aux->prov_moneda_id){
                    $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
                }
                if($aux->prov_moneda_id){
                    $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
                }
                if($aux->tipo_id != null){
                    $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
                }


                $tem['nro_proforma']=$aux->nro_proforma;
                $tem['nro_factura']=$aux->nro_factura;
                $tem['img_proforma']=$aux->img_proforma;
                $tem['img_factura']=$aux->img_factura;
                $tem['mt3']=$aux->mt3;
                $tem['peso']=$aux->peso;
                $tem['emision']=$aux->emision;
                $tem['monto']=$aux->monto;

                /**actualizar cuando este el final**/
                $tem['almacen']="Desconocido";

                // modificar cuando se sepa la logica
                $tem['aero']=1;
                $tem['version']=1;
                $tem['maritimo']=1;
                $data[]=$tem;
            }
        }


        return $data;

    }

    /*********************** SUMMARY ************************/

    /**
     * contrulle el resumen preliminar de la solicitud
     */
    public function getSolicitudeSummary(Request $req){
        $data = array();
        $prod = array();
        $model= Solicitude::findOrFail($req->id);
        $provProd = Product::where('prov_id',$model->prov_id)->get();
        $items =$model->items()->selectRaw("*, sum(saldo) as cant")->groupBy('producto_id')->get();
        $atts =$model->attachments()->get();
        foreach($items as $aux){
            $temp= array();
            $p= $provProd->where('id',$aux->producto_id)->first();
            $temp['id']=$aux->id;
            $temp['producto_id']=$aux->producto_id;
            $temp['codigo']=$p->codigo;
            $temp['codigo_fabrica']=$p->codigo_fabrica;
            $temp['descripcion']=$aux->descripcion;
            $temp['cantidad']=$aux->cant;
            $temp['extra']= $p;
            $prod[]= $temp;
        }

        $data['adjuntos']= $atts;
        $data['productos']= $prod;
        return $data;
    }


    /**
     * construye el resumen preliminar del pedido
     */
    public function getOrderSummary(Request $req){
        $data = array();
        $prod = array();
        $model= Order::findOrFail($req->id);
        $provProd = Product::where('prov_id',$model->prov_id)->get();
        $items =$model->items()->selectRaw("*, sum(saldo) as cant")->groupBy('producto_id')->get();
        $atts =$model->attachments()->get();
        foreach($items as $aux){
            $temp= array();
            $p= $provProd->where('id',$aux->producto_id)->first();
            $temp['id']=$aux->id;
            $temp['producto_id']=$aux->producto_id;
            $temp['codigo']=$p->codigo;
            $temp['codigo_fabrica']=$p->codigo_fabrica;
            $temp['descripcion']=$aux->descripcion;
            $temp['cantidad']=$aux->cant;
            $temp['extra']= $p;
            $prod[]= $temp;
        }

        $data['adjuntos']= $atts;
        $data['productos']= $prod;
        return $data;
    }

    /**
     * construye el resumen preliminar del pedido
     */
    public function getPurchaseSummary(Request $req){
        $data = array();
        $prod = array();
        $model= Purchase::findOrFail($req->id);
        $provProd = Product::where('prov_id',$model->prov_id)->get();
        $items =$model->items()->selectRaw("*, sum(saldo) as cant")->groupBy('producto_id')->get();
        $atts =$model->attachments()->get();
        foreach($items as $aux){
            $temp= array();
            $p= $provProd->where('id',$aux->producto_id)->first();
            $temp['id']=$aux->id;
            $temp['producto_id']=$aux->producto_id;
            $temp['codigo']=$p->codigo;
            $temp['codigo_fabrica']=$p->codigo_fabrica;
            $temp['descripcion']=$aux->descripcion;
            $temp['cantidad']=$aux->cant;
            $temp['extra']= $p;
            $prod[]= $temp;
        }

        $data['adjuntos']= $atts;
        $data['productos']= $prod;
        return $data;
    }

    /*********************** SUSTITUTE ************************/

    /**
     * obtiene las solicitudes que pueden ser reempladas
     */

    public  function  getSolicitudeToReplace(Request $req){
        $items = Solicitude::where('id', '<>', $req->id)
            ->whereNull('fecha_sustitucion')
            ->get();
        $data = array();
        $type = OrderType::get();
        $prov = Provider::findOrFail($req->prov_id);
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        foreach($items as $aux){
            //para maquinas
            $tem = array();
            $tem['id']=$aux->id;
            //$tem['tipo_id']=$aux->tipo_pedido_id;
            $tem['pais_id']=$aux->pais_id;
            $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
            $tem['condicion_pago_id']=$aux->condicion_pago_id;
            $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
            $tem['prioridad_id']=$aux->prioridad_id;
            $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
            $tem['prov_moneda_id']=$aux->prov_moneda_id;
            $tem['estado_id']=$aux->estado_id;
            // $tem['tipo_value']=$aux->typevalue;
            // pra humanos
            $tem['comentario']=$aux->comentario;
            $tem['tasa']=$aux->tasa;
            $tem['proveedor']=$prov->razon_social;
            $tem['documento']= $aux->getTipo();
            $tem['diasEmit']=$aux->daysCreate();
            $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
            $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
            $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
            $tem['img_aprob'] =$aux->fecha_aprob_compra ;


            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                //$tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->prioridad_id){
                $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
            }
            if($aux->prov_moneda_id){
                $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
            }
            if($aux->prov_moneda_id){
                $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
            }
            if($aux->tipo_id != null){
                $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
            }


            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['img_proforma']=$aux->img_proforma;
            $tem['img_factura']=$aux->img_factura;
            $tem['mt3']=$aux->mt3;
            $tem['peso']=$aux->peso;
            $tem['emision']=$aux->emision;
            $tem['monto']=$aux->monto;

            /**actualizar cuando este el final**/
            $tem['almacen']="Desconocido";

            // modificar cuando se sepa la logica
            $tem['aero']=1;
            $tem['version']=1;
            $tem['maritimo']=1;
            $data[]=$tem;

        }
        return $data;

    }

    /**
     * agrega la solicitud al nuevo documento
     */
    public  function  addSustituteSolicitude(Request $req){
        $resul = array();
        $princi = Solicitude::findOrFail($req->princ_id);
        $reemplaze = Solicitude::findOrFail($req->reemplace_id);
        $model = new Solicitude();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);


        $princi->parent_id = $reemplaze->id;
        $princi->version = $reemplaze->version + 1;
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();

        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($princi->items()->get() as $oldItem){
            $newItem = new SolicitudeItem();
            /*            $newItem->final_id =$oldItem->final_id;*/
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new SolicitudeItem();
            /*            $newItem->final_id =$oldItem->final_id."&temp";*/
            $newItem->tipo_origen_id =21;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$reemplaze->id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;

    }
    /**
     * remueve la solicitud al documento
     */
    public function removeSustiteSolicitude(Request $req){
        $resul = array();
        $princi = Solicitude::findOrFail($req->princ_id);
        $reemplaze = Solicitude::findOrFail($req->reemplace_id);

        $model = new Solicitude();
        $model = $this->transferDataDoc($princi,$model);
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->save();
        $newIts= array();

        foreach($princi->items()->where('doc_origen_id','<>', $reemplaze->id)->get() as $oldItem){
            $newItem = new SolicitudeItem();
            $newItem->final_id =$oldItem->final_id;
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }


        $resul['accion']= "inpor";
        $resul['id']= $model->id;
        $reemplaze->fecha_sustitucion=null;
        $reemplaze->final_id= $this->getFinalId($reemplaze);
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    /**
     * obtiene las proformas que pueden ser reempladas
     */

    public  function  getOrderToReplace(Request $req){
        $items = Order::where('id', '<>', $req->id)
            ->whereNull('fecha_sustitucion')
            ->get();
        $data = array();
        $type = OrderType::get();
        $prov = Provider::findOrFail($req->prov_id);
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        foreach($items as $aux){
            //para maquinas
            $tem = array();
            $tem['id']=$aux->id;
            //$tem['tipo_id']=$aux->tipo_pedido_id;
            $tem['pais_id']=$aux->pais_id;
            $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
            $tem['condicion_pago_id']=$aux->condicion_pago_id;
            $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
            $tem['prioridad_id']=$aux->prioridad_id;
            $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
            $tem['prov_moneda_id']=$aux->prov_moneda_id;
            $tem['estado_id']=$aux->estado_id;
            // $tem['tipo_value']=$aux->typevalue;
            // pra humanos
            $tem['comentario']=$aux->comentario;
            $tem['tasa']=$aux->tasa;
            $tem['proveedor']=$prov->razon_social;
            $tem['documento']= $aux->getTipo();
            $tem['diasEmit']=$aux->daysCreate();
            $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
            $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
            $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
            $tem['img_aprob'] =$aux->fecha_aprob_compra ;


            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                //$tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->prioridad_id){
                $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
            }
            if($aux->prov_moneda_id){
                $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
            }
            if($aux->prov_moneda_id){
                $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
            }
            if($aux->tipo_id != null){
                $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
            }


            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['img_proforma']=$aux->img_proforma;
            $tem['img_factura']=$aux->img_factura;
            $tem['mt3']=$aux->mt3;
            $tem['peso']=$aux->peso;
            $tem['emision']=$aux->emision;
            $tem['monto']=$aux->monto;

            /**actualizar cuando este el final**/
            $tem['almacen']="Desconocido";

            // modificar cuando se sepa la logica
            $tem['aero']=1;
            $tem['version']=1;
            $tem['maritimo']=1;
            $data[]=$tem;

        }
        return $data;

    }

    /**
     * agrega la solicitud al nuevo documento
     */
    public  function  addSustituteOrder(Request $req){
        $resul = array();
        $princi = Order::findOrFail($req->princ_id);
        $reemplaze = Order::findOrFail($req->reemplace_id);
        $model = new Order();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);


        $princi->parent_id = $reemplaze->id;
        $princi->version = $reemplaze->version + 1;
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();

        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($princi->items()->get() as $oldItem){
            $newItem = new OrderItem();
            /*            $newItem->final_id =$oldItem->final_id;*/
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new OrderItem();
            /*            $newItem->final_id =$oldItem->final_id."&temp";*/
            $newItem->tipo_origen_id =21;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$reemplaze->id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;

    }
    /**
     * remueve la solicitud al documento
     */
    public function removeSustiteOrder(Request $req){
        $resul = array();
        $princi = Order::findOrFail($req->princ_id);
        $reemplaze = Order::findOrFail($req->reemplace_id);

        $model = new Order();
        $model = $this->transferDataDoc($princi,$model);
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->save();
        $newIts= array();

        foreach($princi->items()->where('doc_origen_id','<>', $reemplaze->id)->get() as $oldItem){
            $newItem = new OrderItem();
            $newItem->final_id =$oldItem->final_id;
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }


        $resul['accion']= "inpor";
        $resul['id']= $model->id;
        $reemplaze->fecha_sustitucion=null;
        $reemplaze->final_id= $this->getFinalId($reemplaze);
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    /**
     * obtiene las proformas que pueden ser reempladas
     */

    public  function  getPurchaseToReplace(Request $req){
        $items = Purchase::where('id', '<>', $req->id)
            ->whereNull('fecha_sustitucion')
            ->get();
        $data = array();
        $type = OrderType::get();
        $prov = Provider::findOrFail($req->prov_id);
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        foreach($items as $aux){
            //para maquinas
            $tem = array();
            $tem['id']=$aux->id;
            //$tem['tipo_id']=$aux->tipo_pedido_id;
            $tem['pais_id']=$aux->pais_id;
            $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
            $tem['condicion_pago_id']=$aux->condicion_pago_id;
            $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
            $tem['prioridad_id']=$aux->prioridad_id;
            $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
            $tem['prov_moneda_id']=$aux->prov_moneda_id;
            $tem['estado_id']=$aux->estado_id;
            // $tem['tipo_value']=$aux->typevalue;
            // pra humanos
            $tem['comentario']=$aux->comentario;
            $tem['tasa']=$aux->tasa;
            $tem['proveedor']=$prov->razon_social;
            $tem['documento']= $aux->getTipo();
            $tem['diasEmit']=$aux->daysCreate();
            $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
            $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
            $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
            $tem['img_aprob'] =$aux->fecha_aprob_compra ;


            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                //$tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->prioridad_id){
                $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
            }
            if($aux->prov_moneda_id){
                $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
            }
            if($aux->prov_moneda_id){
                $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
            }
            if($aux->tipo_id != null){
                $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
            }


            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['img_proforma']=$aux->img_proforma;
            $tem['img_factura']=$aux->img_factura;
            $tem['mt3']=$aux->mt3;
            $tem['peso']=$aux->peso;
            $tem['emision']=$aux->emision;
            $tem['monto']=$aux->monto;

            /**actualizar cuando este el final**/
            $tem['almacen']="Desconocido";

            // modificar cuando se sepa la logica
            $tem['aero']=1;
            $tem['version']=1;
            $tem['maritimo']=1;
            $data[]=$tem;

        }
        return $data;

    }

    /**
     * agrega la solicitud al nuevo documento
     */
    public  function  addPurchaseOrder(Request $req){
        $resul = array();
        $princi = Purchase::findOrFail($req->princ_id);
        $reemplaze = Purchase::findOrFail($req->reemplace_id);
        $model = new Purchase();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);


        $princi->parent_id = $reemplaze->id;
        $princi->version = $reemplaze->version + 1;
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();

        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($princi->items()->get() as $oldItem){
            $newItem = new PurchaseItem();
            /*            $newItem->final_id =$oldItem->final_id;*/
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new PurchaseItem();
            /*            $newItem->final_id =$oldItem->final_id."&temp";*/
            $newItem->tipo_origen_id =21;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$reemplaze->id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;

    }
    /**
     * remueve la solicitud al documento
     */
    public function removePurchaseOrder(Request $req){
        $resul = array();
        $princi = Purchase::findOrFail($req->princ_id);
        $reemplaze = Purchase::findOrFail($req->reemplace_id);

        $model = new Purchase();
        $model = $this->transferDataDoc($princi,$model);
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->save();
        $newIts= array();

        foreach($princi->items()->where('doc_origen_id','<>', $reemplaze->id)->get() as $oldItem){
            $newItem = new PurchaseItem();
            $newItem->final_id =$oldItem->final_id;
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newIts[] = $newItem;
        }


        $resul['accion']= "inpor";
        $resul['id']= $model->id;
        $reemplaze->fecha_sustitucion=null;
        $reemplaze->final_id= $this->getFinalId($reemplaze);
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    /*********************** Attachments ************************/

    /***
     * adjuntos para la solicitud
     **/
    public function addAttachmentsSolicitude (Request $req){
        $resul= array();
        $model = Solicitude::findOrFail($req->id);
        $attacs= array();
        foreach($req->adjuntos  as $aux){
            $attac=  new SolicitudeAttachment();
            $attac->archivo_id = $aux['id'];
            $attac->doc_id = $model->id;
            $attac->documento = strtoupper($aux['documento']);
            $attacs[]= $attac;
        }
        $resul['accion']= "new";
        $resul['items']= $attacs;
        $resul['response']= $model->attachments()->saveMany($attacs);
        return $resul;
    }

    /**
     * adjuntos para el pedido
     **/
    public function addAttachmentsOrder(Request $req){
        $resul= array();
        $model = Order::findOrFail($req->id);
        $attacs= array();
        foreach($req->adjuntos  as $aux){
            $attac=  new OrderAttachment();
            $attac->archivo_id = $aux['id'];
            $attac->doc_id = $model->id;
            $attac->documento = strtoupper($aux['documento']);
            $attacs[]= $attac;
        }
        $resul['accion']= "new";
        $resul['items']= $attacs;
        $resul['response']= $model->attachments()->saveMany($attacs);
        return $resul;
    }


    /**
     * adjuntos para la ordern de compra
     **/
    public function addAttachmentsPurchase(Request $req){
        $resul= array();
        $model = Purchase::findOrFail($req->id);
        $attacs= array();
        foreach($req->adjuntos  as $aux){
            $attac=  new PurchaseAttachment();
            $attac->archivo_id = $aux['id'];
            $attac->doc_id = $model->id;
            $attac->documento = strtoupper($aux['documento']);
            $attacs[]= $attac;
        }
        $resul['accion']= "new";
        $resul['items']= $attacs;
        $resul['response']= $model->attachments()->saveMany($attacs);
        return $resul;
    }

    /*********************** COMPARE ************************/
    /**
     *  compara una solicitud  y un pedido y muestra las diferencias por campos entre ellos
     */
    public function getDiffbetweenSolicitudToOrder (Request $req){
        $data  = array();
        $error = array();
        $asigna = array();
        $values = array();
        $compare =array('titulo', 'pais_id',  'motivo_id','prov_moneda_id','mt3','peso',
            'direccion_almacen_id','direccion_facturacion_id','puerto_id','condicion_id','tasa', 'comentario'
        );
        $princi = Order::findOrFail($req->princ_id);// id de la proforma
        $import = Solicitude::findOrFail($req->impor_id);// id de la solicitud
        $values['monto'] =$princi->monto + $import->monto;
        $values['mt3'] =$princi->mt3 + $import->mt3;

        foreach($compare as $aux){
            $ordval = $princi->getAttributeValue($aux);
            $solval = $import->getAttributeValue($aux);
            $data['comp'][]= array('ord' =>$ordval, 'solv' => $solval ,'key' => $aux);
            if($solval == null &&  $ordval != null) {
                $asigna[$aux] = $ordval;
            }else if($solval != null &&  $ordval != null) {

                if($solval != $ordval){
                    $temp0 = array();
                    $temp1 = array();
                    $temp0['key'] = $solval;
                    $temp1['key'] =$ordval;

                    switch($aux){

                        case "prov_moneda_id":
                            $mon=Monedas::findOrFail($solval);
                            $mon2=Monedas::findOrFail($ordval);
                            $temp0['text'] =$mon->nombre;
                            $temp1['text'] =$mon2->nombre;
                            break;
                        case "pais_id":
                            $mon=Country::find($solval);
                            $mon2=Country::find($ordval);
                            if($mon!=null){
                                $temp0['text'] =$mon->short_name;
                            }
                            if($mon2!=null){
                                $temp1['text'] =$mon2->short_name;
                            }
                            break;
                        case "motivo_id":
                            $mon=OrderReason::findOrFail($solval);
                            $mon2=OrderReason::findOrFail($ordval);
                            $temp0['text'] =$mon->motivo;
                            $temp1['text'] =$mon2->motivo;
                            break;
                        case "direccion_almacen_id"  ||  "direccion_facturacion_id":
                            $mon=ProviderAddress::find($solval);
                            $mon2=ProviderAddress::find($ordval);
                            if($mon!=null){
                                $temp0['text'] =$mon->short_name;
                            }
                            if($mon2!=null){
                                $temp1['text'] =$mon2->short_name;
                            }

                            break;
                        /*       case "direccion_facturacion_id":
                                   $mon=ProviderAddress::findOrFail($solval);
                                   $mon2=ProviderAddress::findOrFail($ordval);
                                   $temp0['text'] =$mon->direccion;
                                   $temp1['text'] =$mon2->direccion;
                                   break;*/
                        case "puerto_id" :
                            $mon=Ports::findOrFail($solval);
                            $mon2=Ports::findOrFail($ordval);
                            $temp0['text'] =$mon->Main_port_name;
                            $temp1['text'] =$mon2->Main_port_name;
                            break;
                        case "condicion_id" :
                            $mon=OrderCondition::findOrFail($solval);
                            $mon2=OrderCondition::findOrFail($ordval);
                            $temp0['text'] =$mon->Main_port_name;
                            $temp1['text'] =$mon2->Main_port_name;
                            break;


                    }
                    $error[$aux][] =$temp0;
                    $error[$aux][] =$temp1;

                }
            }
        }
        $data['error'] = $error;
        $data['asignado'] = $asigna;
        $solItms= $import->items()->get();
        $data['items']=  $solItms;


        return $data;
    }

    /**
     * moetod que compara un pedido  y una orden de compra y muestra las diferencias por campos entre ellos
     */
    public function getDiffbetweenOrderToPurchase (Request $req){
        $data  = array();
        $error = array();
        $asigna = array();
        $compare =array('titulo', 'pais_id',  'motivo_id','prov_moneda_id','mt3','peso',
            'direccion_almacen_id','direccion_facturacion_id','puerto_id','condicion_id','tasa', 'comentario'
        );
        $prin = Purchase::findOrFail($req->princ_id);// id de la proforma
        $import = Order::findOrFail($req->impor_id);// id de la solicitud princ_id
        //$asigna['monto'] = $prin->monto + $import->monto;
        // validadando la cabecera
        foreach($compare as $aux){
            $ordval = $prin->getAttributeValue($aux);
            $solval = $import->getAttributeValue($aux);
            $data['comp'][]= array('ord' =>$ordval, 'solv' => $solval ,'key' => $aux);
            if($solval == null &&  $ordval != null) {
                $asigna[$aux] = $ordval;
            }else if($solval != null &&  $ordval != null) {

                if($solval != $ordval){
                    $temp0 = array();
                    $temp1 = array();
                    $temp0['key'] = $solval;
                    $temp1['key'] =$ordval;

                    switch($aux){
                        case "prov_moneda_id":
                            $mon=Monedas::findOrFail($solval);
                            $mon2=Monedas::findOrFail($ordval);
                            $temp0['text'] =$mon->nombre;
                            $temp1['text'] =$mon2->nombre;
                            break;
                        case "pais_id":
                            $mon=Country::find($solval);
                            $mon2=Country::find($ordval);
                            if($mon !=null ){
                                $temp0['text'] =$mon->short_name;
                                $temp1['text'] =$mon2->short_name;
                            }
                            if($mon2 !=null ){
                                $temp1['text'] =$mon2->short_name;
                            }


                            break;
                        case "motivo_id":
                            $mon=OrderReason::findOrFail($solval);
                            $mon2=OrderReason::findOrFail($ordval);
                            $temp0['text'] =$mon->motivo;
                            $temp1['text'] =$mon2->motivo;
                            break;
                        case "direccion_almacen_id"  ||  "direccion_facturacion_id":
                            if($solval != 0 &&  $ordval !=0){
                                $mon=ProviderAddress::findOrFail($solval);
                                $mon2=ProviderAddress::findOrFail($ordval);
                                $temp0['text'] =$mon->direccion;
                                $temp1['text'] =$mon2->direccion;
                            }

                            break;
                        /*       case "direccion_facturacion_id":
                                   $mon=ProviderAddress::findOrFail($solval);
                                   $mon2=ProviderAddress::findOrFail($ordval);
                                   $temp0['text'] =$mon->direccion;
                                   $temp1['text'] =$mon2->direccion;
                                   break;*/
                        case "puerto_id" :
                            $mon=Ports::findOrFail($solval);
                            $mon2=Ports::findOrFail($ordval);
                            $temp0['text'] =$mon->Main_port_name;
                            $temp1['text'] =$mon2->Main_port_name;
                            break;
                        case "condicion_id" :
                            $mon=OrderCondition::findOrFail($solval);
                            $mon2=OrderCondition::findOrFail($ordval);
                            $temp0['text'] =$mon->Main_port_name;
                            $temp1['text'] =$mon2->Main_port_name;
                            break;


                    }
                    $error[$aux][] =$temp0;
                    $error[$aux][] =$temp1;

                }
            }
        }


        $solItms= $import->items()->get();
        if(sizeof($solItms) > 0 ){
            $prods=  array();
        }

        $data['error'] = $error;
        $data['asignado'] = $asigna;
        $data['items']= $solItms;
        return $data;
    }


    public function  getAddressrPort(Request $req){
        $data =array();
        if($req->has('id')){
            $data = ProviderAddress::findOrfail($req->id)->ports()->get();
            if(sizeof($data)>0){
                return $data;
            }
        }

        return $data;
    }

    /*********************** COPY ************************/

    /**
     * crea una copia del documento
     * @param id del documento a copiar
     * @param tipo de documento
     */
    public  function copySolicitude(Request $req){
        $resul["action"] ="copy";
        $newItems= array();
        $newAtt= array();
        $newModel= new Solicitude();
        $oldModel= Solicitude::findOrFail($req->id);

        $newModel = $this->transferDataDoc($oldModel,$newModel);
        $newModel->parent_id=$oldModel->id;
        $newModel->version=$oldModel->version+1;
        $newModel->save();
        $oldModel->cancelacion= Carbon::now();
        $oldModel->comentario_cancelacion= "#sistema: copiado por new id#".$newModel->id;
        $oldModel->save();

        foreach($oldModel->items() as $aux){
            $it=$newModel->newItem();
            $it= $this->transferItem($aux, $it);
            $it->doc_id=$newModel->id;
            $newItems[]=$it;

        }

        $newModel->items()->saveMany($newItems);
        $resul['id']= $newModel->id;
        /*        $resul['doc']= $newModel;
                $resul['adjs']= $newAtt;
                $resul['items']= $newItems;*/
        return $resul;

    }

    /**
     * crea una copia del documento
     * @param id del documento a copiar
     * @param tipo de documento
     */
    public  function copyOrder(Request $req){
        $resul["action"] ="copy";
        $newItems= array();
        $newAtt= array();
        $newModel= new Order();
        $oldModel= Order::findOrFail($req->id);

        $newModel = $this->transferDataDoc($oldModel,$newModel);
        $newModel->parent_id=$oldModel->id;
        $newModel->version=$oldModel->version+1;
        $newModel->save();
        $oldModel->cancelacion= Carbon::now();
        $oldModel->comentario_cancelacion= "#sistema: copiado por new id#".$newModel->id;
        $oldModel->save();

        foreach($oldModel->items() as $aux){
            $it=$newModel->newItem();
            $it= $this->transferItem($aux, $it);
            $it->doc_id=$newModel->id;
            $newItems[]=$it;

        }

        $newModel->items()->saveMany($newItems);
        $resul['id']= $newModel->id;
        /*        $resul['doc']= $newModel;
                $resul['adjs']= $newAtt;
                $resul['items']= $newItems;*/
        return $resul;

    }

    /**
     * crea una copia del documento
     * @param id del documento a copiar
     * @param tipo de documento
     */
    public  function copyPurchase(Request $req){
        $resul["action"] ="copy";
        $newItems= array();
        $newAtt= array();
        $newModel= new Purchase();
        $oldModel= Purchase::findOrFail($req->id);

        $newModel = $this->transferDataDoc($oldModel,$newModel);
        $newModel->parent_id=$oldModel->id;
        $newModel->version=$oldModel->version+1;
        $newModel->save();
        $oldModel->cancelacion= Carbon::now();
        $oldModel->comentario_cancelacion= "#sistema: copiado por new id#".$newModel->id;
        $oldModel->save();

        foreach($oldModel->items() as $aux){
            $it=$newModel->newItem();
            $it= $this->transferItem($aux, $it);
            $it->doc_id=$newModel->id;
            $newItems[]=$it;

        }

        $newModel->items()->saveMany($newItems);
        $resul['id']= $newModel->id;
        /*        $resul['doc']= $newModel;
                $resul['adjs']= $newAtt;
                $resul['items']= $newItems;*/
        return $resul;

    }

    /*********************** PRODUCTOS ************************/
    public function getProviderProducts(Request $req){
        $data = array();
        $items = Provider::findOrFail($req->id)
            ->proveedor_product()
            ->where('tipo_producto_id', '<>', 3)
            ->get();
        $types = ProductType::get();
        $i=0;

        $model= $this->getDocumentIntance($req->tipo);
        $model = $model->findOrFail($req->doc_id);
        $modelIts= $model->items()->where('tipo_origen_id', '1')->get();
        foreach($items as $aux){
            $temp= array();
            $temp['id'] = $aux->id;
            $temp['descripcion'] = $aux->descripcion;
            $temp['codigo'] = "(demo".$i.")";
            $temp['codigo_fabrica'] =$aux->codigo_fabrica;
            $temp['puntoCompra'] = false;
            $temp['cantidad'] =0;
            $temp['saldo'] =0;
            $temp['stock'] = $i;
            $temp['tipo_producto_id'] = $aux->tipo_producto_id;
            $temp['tipo_producto'] = $types->where('id',$aux->tipo_producto_id)->first()->descripcion;
            $temp['asignado'] = false;
            $i++;
            if($aux->descripcion == null){
                $temp['descripcion'] = "Profit ".$aux->descripcion_profit;
            }
            $itMo=$modelIts->where('producto_id',$aux->id)->first();
            $temp['otre']=$itMo;
            if($itMo != null){
                $temp['asignado'] = true;
                $temp['saldo'] = $itMo->saldo;
                $temp['reng_id'] = $itMo->id;

            }
            $data[]=$temp;


        }
        return $data;

    }

    /**
     * crea un producto temporarl
     */
    public function createTemp(Request $req){
        $prodTemp = MasterProductController::createProduct($req->all());
        $temp= array();
        $temp['id'] = $prodTemp->id;
        $temp['descripcion'] = $prodTemp->descripcion;
        $temp['codigo'] = "(demo".")";
        $temp['codigo_fabrica'] =$prodTemp->codigo_fabrica;
        $temp['puntoCompra'] = false;
        $temp['cantidad'] = 0;
        $temp['saldo'] = 0;


        $temp['stock'] = 0;
        $temp['tipo_producto_id'] = $prodTemp->tipo_producto_id;
        $temp['tipo_producto'] = ProductType::findOrFail($prodTemp->tipo_producto_id)->descripcion;
        $temp['asignado'] = false;
        if($prodTemp->descripcion == null){
            $temp['descripcion'] = "Profit ".$prodTemp->descripcion_profit;
        }
        if($req->has('cantidad')){
            $temp['cantidad'] = $req->cantidad;
            $temp['saldo'] = $req->cantidad;
        }




        return $temp;
    }


    /*********************** SOLICITUD ************************/

    /**
     * asigna el producto a la solicitud
     */
    public  function  changeProductoSolicitud (Request $req){
        $res= array();
        $item= new SolicitudeItem();
        $res['accion']= "new";
        if($req->asignado){

            if($req->has('reng_id')){
                $item = SolicitudeItem::findOrFail($req->reng_id);
                $res['accion'] ='upd';
            }
            $item->tipo_origen_id=1;
            $item->doc_id=$req->doc_id;
            $item->origen_item_id=$req->id;
            $item->cantidad = $req->cantidad;
            $item->saldo = $req->saldo;
            $item->producto_id = $req->id;
            $item->descripcion = $req->descripcion;
            $item->save();
            $res['reng_id'] = $item->id;
            $res['items'] = $item;
        }else{
            if($req->has('reng_id')){
                $item = SolicitudeItem::findOrFail($req->reng_id);
                $res['accion'] ='del';
                $item->destroy($item);
            }
        }

        return $res;


    }

    /**asigna el producto a la solicitud */

    public  function  changeProductoOrden (Request $req){
        $res= array();
        $item= new OrderItem();
        $res['accion']= "new";
        if($req->asignado){

            if($req->has('reng_id')){
                $item = OrderItem::findOrFail($req->reng_id);
                $res['accion'] ='upd';
            }
            $item->tipo_origen_id=1;
            $item->doc_id=$req->doc_id;
            $item->origen_item_id=$req->id;
            // $item->cantidad = $req->cantidad;
            $item->saldo = $req->saldo;
            $item->descripcion = $req->descripcion;

            $item->producto_id = $req->id;
            $item->save();
            $res['reng_id'] = $item->id;
            $res['items'] = $item;
        }else{
            if($req->has('reng_id')){
                $item = OrderItem::findOrFail($req->reng_id);
                $res['accion'] ='del';
                $item->destroy($item);
            }
        }
        return $res;

    }

    /**asigna el producto a la solicitud */

    public  function  changeProductoPurchase (Request $req){
        $res= array();
        $item= new PurchaseItem();
        $res['accion']= "new";
        if($req->asignado){

            if($req->has('reng_id')){
                $item = PurchaseItem::findOrFail($req->reng_id);
                $res['accion'] ='upd';
            }
            $item->tipo_origen_id=1;
            $item->doc_id=$req->doc_id;
            $item->origen_item_id=$req->id;
            $item->cantidad = $req->cantidad;
            $item->saldo = $req->saldo;
            $item->descripcion = $req->descripcion;
            $item->producto_id = $req->id;
            $item->save();
            $res['reng_id'] = $item->id;
            $res['items'] = $item;
        }else{
            if($req->has('reng_id')){
                $item = PurchaseItem::findOrFail($req->reng_id);
                $res['accion'] ='del';
                $item->destroy($item);
            }
        }
        return $res;


    }

    /**agrega o quita item de la solicitud*/
    public function addRemoveSolicitudItem(Request $req){
        $resul['accion']= "new";
        if($req->asignado){
            $model = new SolicitudeItem();
            $model->tipo_origen_id = $req->tipo_origen_id;
            $model->doc_id = $req->doc_id;
            $model->origen_item_id= $req->id;
            $model->doc_origen_id= $req->doc_origen_id;
            $model->cantidad= $req->cantidad;
            $model->saldo= $req->saldo;
            $model->producto_id= $req->producto_id;
            $model->descripcion= $req->descripcion;
            $resul['response']=$model->save();
            $resul['renglon_id']=$model->id;


        }else{
            $resul['accion']= "del";
            //  $resul['response']=SolicitudeItem::destroy($req->renglon_id);
        }
        return $resul;
    }

    /**agrega o quita item de la solicitud*/
    public function addRemoveSolicitudItems(Request $req){
        $resul['accion']= "new";
        $asig= array();
        $remo= array();
        $model= Solicitude::findOrFail($req->doc_id);
        /*foreach($req->items  as $aux){
            /*if($req->asignado){
                $item = new SolicitudeItem();
//                $item->tipo_origen_id = $aux->tipo_origen_id;
//                $item->doc_id = $req->doc_id;
//                $item->origen_item_id= $aux->origen_item_id;
//                $item->doc_origen_id= $aux->doc_origen_id;
//                $item->cantidad= $aux->cantidad;
//                $item->saldo= $aux->saldo;
//                $item->producto_id= $aux->producto_id;
//                $item->descripcion= $aux->descripcion;
//                $item->save();
//                $asig[]=$item;

            }else{
                $remo[]= $aux->id;
                $resul['accionSub']= "del";
            }*/
        //}

        $resul['new']= $asig;
        $resul['del']= $remo;
        $resul['success']= "Items agregados";
        $model->destroy($remo);

        return $resul;
    }

    /**agrega o quita item de la solicitud*/
    public function addRemoveOrderItems(Request $req){
        $resul['accion']= "new";
        $asig= array();
        $remo= array();
        $model= Order::findOrFail($req->doc_id);
        foreach($req->items  as $aux){
            if($req->asignado){
                $item = new OrderItem();
                $item->tipo_origen_id = $aux['tipo_origen_id'];
                $item->doc_id = $req->doc_id;
                $item->origen_item_id= $aux['origen_item_id'];
                $item->doc_origen_id= $aux['doc_origen_id'];
                $item->cantidad= $aux['cantidad'];
                $item->saldo= $aux['saldo'];
                $item->producto_id= $aux['producto_id'];
                $item->descripcion= $aux['descripcion'];
                $item->save();
                $asig[]=$aux;

            }else{
                $remo[]= $aux->id;
                $resul['accionSub']= "del";
            }
        }

        $resul['new']= $asig;
        $resul['del']= $remo;
        $resul['success']= "Items agregados";
        $model->destroy($remo);

        return $resul;
    }

    /**agrega o quita item de la solicitud*/
    public function addRemovePurchaseItems(Request $req){
        $resul['accion']= "new";
        $asig= array();
        $remo= array();
        $model= Purchase::findOrFail($req->doc_id);
        foreach($req->items  as $aux){
            if($req->asignado){
                $item = new PurchaseItem();
                $item->tipo_origen_id = $aux->tipo_origen_id;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id= $aux->origen_item_id;
                $item->doc_origen_id= $aux->doc_origen_id;
                $item->cantidad= $aux->saldo;
                $item->saldo= $aux->saldo;
                $item->producto_id= $aux->producto_id;
                $item->descripcion= $aux->descripcion;
                $item->save();
                $asig[]=$item;

            }else{
                $remo[]= $aux->id;
                $resul['accionSub']= "del";
            }
        }

        $resul['new']= $asig;
        $resul['del']= $remo;
        $resul['success']= "Items agregados";
        $model->destroy($remo);

        return $resul;
    }


    /**agrega o quita item de la solicitud*/
    public function addRemovePurchaseItem(Request $req){
        $resul['accion']= "new";
        if($req->asignado){
            $model = new PurchaseItem();
            $model->tipo_origen_id = $req->tipo_origen_id;
            $model->doc_id = $req->doc_id;
            $model->origen_item_id= $req->origen_item_id;
            $model->doc_origen_id= $req->doc_origen_id;
            $model->cantidad= $req->cantidad;
            $model->saldo= $req->saldo;
            $model->producto_id= $req->producto_id;
            $model->descripcion= $req->descripcion;
            if($req->has("final_id")){
                $model->final_id= $req->final_id;

            }
            $resul['response']=$model->save();
            $resul['id']=$model->id;


        }else{
            $resul['accion']= "del";
            $resul['response']=PurchaseItem::destroy($req->id);
        }
        return $resul;
    }

    /**agrega o quita item de la solicitud*/
    public function addRemoveOrderItem(Request $req){
        $resul['accion']= "new";
        if($req->asignado){
            $model = new OrderItem();
            $model->tipo_origen_id = $req->tipo_origen_id;
            $model->doc_id = $req->doc_id;
            $model->origen_item_id= $req->origen_item_id;
            $model->doc_origen_id= $req->doc_origen_id;
            $model->cantidad= $req->cantidad;
            $model->saldo= $req->saldo;
            $model->producto_id= $req->producto_id;
            $model->descripcion= $req->descripcion;
            if($req->has("final_id")){
                $model->final_id= $req->final_id;

            }
            $resul['response']=$model->save();
            $resul['id']=$model->id;


        }else{
            $resul['accion']= "del";
            $resul['response']=OrderItem::destroy($req->id);
        }
        return $resul;
    }



    /**
     * cambio el estado de una solicitud
     */
    public function setStatusSolicitude(Request $req){
        $resul = array();
        $model = Solicitude::finOrFail($req->id);
        $status = OrderStatus::findOrfail($req->estado_id);
        $model->estado->id = $status->id;
        $model->save();
        $resul['accion']='upd';
        $resul['item'] = $status;
        return $resul;
    }

    /**
     * Asigna el parent a un pedido(proforma)
     */
    public function setParentOrder(Request $req){
        $resul = array();
        $princ = Order::findOrFail($req->princ_id);
        $princ->doc_parent_id = $req->doc_parent_id;
        $princ->doc_parent_origen_id = 21;
        $princ->save();
        return $resul;
    }

    /**
     * Asigna el parent a un pedido(proforma)
     */
    public function setParentPurchase(Request $req){
        $resul = array();
        $princ = Purchase::findOrFail($req->princ_id);
        $princ->doc_parent_id = $req->doc_parent_id;
        $princ->doc_parent_origen_id = 21;
        $princ->save();

        return $resul;
    }

    /**
     * Asigna el parent a un pedido(proforma)
     */
    public function setParentSolicitude(Request $req){
        $resul = array();
        $princ = Solicitude::findOrFail($req->princ_id);
        $princ->doc_parent_id = $req->doc_parent_id;
        $princ->doc_parent_origen_id = 21;
        $princ->save();

        return $resul;
    }
    /**
     * cambio el estado de una solicitud
     */
    public function setStatusOrder(Request $req){
        $resul = array();
        $model = Order::findOrFail($req->id);
        $status = OrderStatus::findOrfail($req->estado_id);
        $model->estado_id = $status->id;
        $model->save();
        $resul['accion']='upd';
        $resul['item'] = $status;
        return $resul;
    }
    /**
     * cambio el estado de una solicitud
     */
    public function setStatusPurchase(Request $req){
        $resul = array();
        $model = Purchase::finOrFail($req->id);
        $status = OrderStatus::findOrfail($req->estado_id);
        $model->estado->id = $status->id;
        $model->save();
        $resul['accion']='upd';
        $resul['item'] = $status;
        return $resul;
    }

    public function changeItemSolicitude(Request $req){
        $resul['accion']= "upd";
        $model = SolicitudeItem::findOrFail($req->id);
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id= $req->origen_item_id;
        $model->doc_origen_id= $req->doc_origen_id;
        $model->cantidad= $req->cantidad;
        $model->saldo= $req->saldo;
        $model->producto_id= $req->producto_id;
        $model->descripcion= $req->descripcion;
        if($req->has("final_id")){
            $model->final_id= $req->final_id;
        }
        $resul['response']=$model->save();
        $resul['id']=$model->id;
        return $resul;
    }

    public function changeItemPurchase(Request $req){
        $resul['accion']= "upd";
        $model = PurchaseItem::findOrFail($req->id);
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id= $req->origen_item_id;
        $model->doc_origen_id= $req->doc_origen_id;
        $model->cantidad= $req->cantidad;
        $model->saldo= $req->saldo;
        $model->producto_id= $req->producto_id;
        $model->descripcion= $req->descripcion;
        if($req->has("final_id")){
            $model->final_id= $req->final_id;
        }
        $resul['response']=$model->save();
        $resul['id']=$model->id;
        return $resul;
    }



    public function changeItemOrder(Request $req){
        $resul['accion']= "upd";
        $model = OrderItem::findOrFail($req->id);
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id= $req->origen_item_id;
        $model->doc_origen_id= $req->doc_origen_id;
        $model->cantidad= $req->cantidad;
        $model->saldo= $req->saldo;
        $model->producto_id= $req->producto_id;
        $model->descripcion= $req->descripcion;
        if($req->has("final_id")){
            $model->final_id= $req->final_id;
        }
        $resul['response']=$model->save();
        $resul['id']=$model->id;
        return $resul;
    }



    /**
     * llena los camppos de los filtros
     */
    public function getFilterData()
    {

        $data= Array();
        $data['monedas']= Monedas::select('nombre', 'id')->where("deleted_at",NULL)->get();
        $data['tipoEnvio']= ProvTipoEnvio::select('nombre', 'id')->where("deleted_at",NULL)->get();
        return $data;
    }



    /**
     * prueba para metodos
     * @deprecated
     */
    function test(Request $req){
        $model = Provider::findOrFail(1);
        $pedidos =$model->Order()
            ->get();
        $llds=array();
        foreach ($pedidos as $aux){
            $tem['id']=$aux->id;
            $tem['llega']=$aux->arrival();
            $llds[]= $tem;
        }

        $data['provedor']=$model;
        $data['pedidos']=$llds;

        return $data;
    }
    /**
     * Remuevo todos lo item de un pedido segun el documento de origen
     * @parm id el id de cabezera de documento
     * @parm pedido_id el pedido donde se desea borrar
     **/
    public function removeToOrden(Request $req){
        $items = OrderItem::where('doc_origen_id', $req->id)
            ->where('pedido_id', $req->pedido_id)
            ->get();
        $ids=Array();
        $resul= Array();
        foreach($items as $aux){
            $ids[]=$aux->id;
        }
        $resul['response']=OrderItem::destroy($ids);
        $resul['accion']="elimnar";
        $resul['items']=$ids;
        return $resul;
    }

    /**
     * remueve el item del pedido
     * @param id
     **/
    public  function removeOrderItem(Request $req){
        $resul['accion']= "eliminar";
        $item = OrderItem:: findOrFail($req->id);
        $resul['response']= $item->destroy($item->id);

        return $resul;
    }


    /**
     * edita el item de pedido y ajusta los valores del anterior
     */

    public function EditPedido(Request $req){

        $model= OrderItem::findOrfail($req->id);
        $model->cantidad = $req->cantidad;
        $model->saldo = $req->saldo;
        $model->save();

        $resul['accion']= "edicion ". $req->tipo_origen_id;
        $resul['item']= $model;
        return $resul;

    }
    /**
     * regresa la lista de docuemnts segun id del provedor
     */
    public function getProviderListOrder(Request $req)
    {
        $data=Array();
        $prov= Provider::findOrFail($req->id);
        $items = $prov->getOrderDocuments()->where('fecha_sustitucion',null)->where('comentario_cancelacion', null);
//        $items =$items->where('final_id','!=', null)->all();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();
        foreach($items as $aux){
            //para maquinas
            $tem = array();
            $tem['id']=$aux->id;
            //$tem['tipo_id']=$aux->tipo_pedido_id;
            $tem['pais_id']=$aux->pais_id;
            $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
            $tem['condicion_pago_id']=$aux->condicion_pago_id;
            $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
            $tem['prioridad_id']=$aux->prioridad_id;
            $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
            $tem['prov_moneda_id']=$aux->prov_moneda_id;
            $tem['estado_id']=$aux->estado_id;
            $tem['final_id']=$aux->final_id;
            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['tasa']=$aux->tasa;
            $tem['ult_revision']=$aux->ult_revision;
            // $tem['tipo_value']=$aux->typevalue;
            // pra humanos
            $tem['comentario']=$aux->comentario;
            $tem['tasa']=$aux->tasa;
            $tem['proveedor']=$prov->razon_social;
            $tem['titulo']=$aux->titulo;
            $tem['documento']= $aux->getTipo();
            $tem['diasEmit']=$aux->daysCreate();
            $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
            $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
            $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
            $tem['img_aprob'] =$aux->fecha_aprob_compra ;

            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                $tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->prioridad_id){
                $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
            }
            if($aux->prov_moneda_id){
                $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
            }
            if($aux->prov_moneda_id){
                $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
            }
            if($aux->tipo_id != null){
                $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
            }





            $tem['productos'] = $this->getProductoItem($aux);




            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['img_proforma']=$aux->img_proforma;
            $tem['img_factura']=$aux->img_factura;
            $tem['mt3']=$aux->mt3;
            $tem['peso']=$aux->peso;
            $tem['emision']=$aux->emision;
            $tem['monto']=$aux->monto;

            /**actualizar cuando este el final**/
            $tem['almacen']="Desconocido";

            // modificar cuando se sepa la logica
            $tem['aero']=1;
            $tem['version']=1;
            $tem['maritimo']=1;
            $data[]=$tem;
        }

        return $data;

    }

    /**
     * carga formulario
     * @param Request $req
     * @deprecated
     */
    public function getForm()
    {

        $data= Array();
        /**maestros*/
        //$data['proveedor']= Provider::select('razon_social', 'id')->where("deleted_at",NULL)->get();
        $data['motivoPedido']= OrderReason::select('motivo', 'id')->where("deleted_at",NULL)->get();
        $data['condicionPedido'] = OrderCondition::select('nombre', 'id')->where("deleted_at",NULL)->get();
        $data['estadoPedido'] = OrderStatus::select('estado', 'id')->where("deleted_at",NULL)->get();
        $data['tipoDepago'] = PaymentType::select('nombre', 'id')->where("deleted_at",NULL)->get();
        return $data;

    }


    /*********************************** PEDIDOS A SUSTITUIR ***********************************/

    /**
     * @deprecated
     * agrega todo el pedido viejo al nuevo pedido
     * id  siempre va a ser del articulo a
     * asigna un pedido a un nuevo pedido
     **/
    public function addOrderSubstitute(Request $req){
        $oldOrder=Order::findOrFail($req->id);
        $newOrder=Order::findOrFail($req->pedido_id);
        $itemOlds= Array();
        $itemNews= Array();

        foreach($oldOrder->OrderItem()->get() as $aux){
            $item= new OrderItem();
            $item->tipo_origen_id = 4;
            $item->pedido_id =  $req->pedido_id;
            $item->doc_origen_id =  $aux->pedido_id;
            $item->origen_item_id = $aux->id;
            $item->descripcion = $aux->descripcion;
            $item->cantidad = $aux->saldo;
            $item->saldo = $aux->saldo;

            $aux->saldo=0;
            $itemOlds[]=$aux;
            $itemNews[]=$item;
        }
        $oldOrder->OrderItem()->saveMany($itemOlds);
        $newOrder->OrderItem()->saveMany($itemNews);
        return $itemNews;

    }

    public  function OrderSubstituteItem(Request $req){
        $resul['accion']= "agregacion";

        $old= OrderItem::findOrFail($req->id);
        $item = new OrderItem();

        if($req->has('renglon_id')){
            $item = OrderItem:: findOrFail($req->renglon_id);
            $resul['accion']= "edicion";
        }else{
            $item->cantidad= $old->saldo;
        }
        $item->tipo_origen_id = 4;
        $item->pedido_id =  $req->pedido_id;
        $item->doc_origen_id =  $old->pedido_id;
        $item->origen_item_id = $req->id;
        $item->descripcion = $old->descripcion;
        $item->saldo = $req->saldo;

        if($req->saldo >= $old->saldo){
            $old->saldo=0;
        }else{
            $old->saldo = $old->saldo - $req->saldo;
        }
        $old->save();
        $item->save();

        $resul['item']=$item;
        $resul['renglon_id']=$item->id;
        return $resul;

    }

    /**
     * elimina un pedido a un nuevo pedido
     **/
    public function removeOrderSubstitute(Request $req){

        $res= Array();
        $model = OrderItem::where('pedido_id',$req->pedido_id)
            ->where('producto_id',$req->id)
            ->where('pedido_tipo_origen_id','3')
            ->first();

        $moveItem = DB::table('tbl_pedido_item')->select('id')->where('pedido_id',$req->id)->get();

        foreach(  $moveItem  as $aux){
            dd($aux);
            $newItem = OrderItem::where('producto_id', $aux)

                ->where('pedido_id', $req->pedido_id)->first();
            $res[]=$aux;
            //OrderItem::destroy($newItem->id);
        }
        //OrderItem::destroy($model->id);
        return $res;
    }

    /**
     * obtiene todos las solicitudes que son sustituibles
     **/

    public function getSolicitudeSubstitutes(Request $req){
        $data = array();
        $items = Solicitude::where('id','<>', $req->doc_id)
            ->whereNotNull('final_id')
            ->get();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();
        $model = Solicitude::findOrFail($req->doc_id);

        foreach($items as $aux){
            $paso =true;

            //para maquinas
            $tem = array();
            $tem['asignado']=false;
            if($aux->fecha_sustitucion != null){
                if($aux->id == $model->parent_id){
                    $tem['asignado']=true;
                }else{
                    $paso= false;
                }
            }

            if($paso){


                $tem['id']=$aux->id;
                //$tem['tipo_id']=$aux->tipo_pedido_id;
                $tem['pais_id']=$aux->pais_id;
                $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
                $tem['condicion_pago_id']=$aux->condicion_pago_id;
                $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
                $tem['prioridad_id']=$aux->prioridad_id;
                $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
                $tem['prov_moneda_id']=$aux->prov_moneda_id;
                $tem['estado_id']=$aux->estado_id;
                // $tem['tipo_value']=$aux->typevalue;
                // pra humanos
                $tem['comentario']=$aux->comentario;
                $tem['tasa']=$aux->tasa;
                $tem['documento']= $aux->getTipo();
                $tem['diasEmit']=$aux->daysCreate();
                $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
                $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
                $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
                $tem['img_aprob'] =$aux->fecha_aprob_compra ;
                $tem['aprob_compras'] =$aux->aprob_compras ;
                $tem['cancelacion'] =$aux->cancelacion ;
                $tem['parent_id'] =$aux->parent_id ;



                if($aux->motivo_id){
                    $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
                }
                if($aux->pais_id){
                    $tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
                }
                if($aux->prioridad_id){
                    $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
                }
                if($aux->prov_moneda_id){
                    $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
                }
                if($aux->prov_moneda_id){
                    $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
                }
                if($aux->tipo_id != null){
                    $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
                }
                $tem['productos'] = $this->getProductoItem($aux);
                $tem['nro_proforma']=$aux->nro_proforma;
                $tem['nro_factura']=$aux->nro_factura;
                $tem['img_proforma']=$aux->img_proforma;
                $tem['img_factura']=$aux->img_factura;
                $tem['mt3']=$aux->mt3;
                $tem['peso']=$aux->peso;
                $tem['emision']=$aux->emision;
                $tem['monto']=$aux->monto;
                /**actualizar cuando este el final**/
                $tem['almacen']="Desconocido";
                // modificar cuando se sepa la logica
                $tem['aero']=1;
                $tem['version']=1;
                $tem['maritimo']=1;


                $data[]=$tem;
            }
        }
        return $data;
    }

    /**
     * obtiene todos las ordenes de compras que son sustituibles
     **/

    public function getPurchaseSubstitutes(Request $req){
        $data = array();
        $items = Purchase::where('id','<>', $req->doc_id)
            ->whereNotNull('final_id')
            ->get();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();

        foreach($items as $aux){
            //para maquinas
            $tem = array();
            $tem['id']=$aux->id;
            //$tem['tipo_id']=$aux->tipo_pedido_id;
            $tem['pais_id']=$aux->pais_id;
            $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
            $tem['condicion_pago_id']=$aux->condicion_pago_id;
            $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
            $tem['prioridad_id']=$aux->prioridad_id;
            $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
            $tem['prov_moneda_id']=$aux->prov_moneda_id;
            $tem['estado_id']=$aux->estado_id;
            // $tem['tipo_value']=$aux->typevalue;
            // pra humanos
            $tem['comentario']=$aux->comentario;
            $tem['tasa']=$aux->tasa;
            $tem['documento']= $aux->getTipo();
            $tem['diasEmit']=$aux->daysCreate();
            $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
            $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
            $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
            $tem['img_aprob'] =$aux->fecha_aprob_compra ;
            $tem['aprob_compras'] =$aux->aprob_compras ;
            $tem['cancelacion'] =$aux->cancelacion ;



            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                $tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->prioridad_id){
                $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
            }
            if($aux->prov_moneda_id){
                $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
            }
            if($aux->prov_moneda_id){
                $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
            }
            if($aux->tipo_id != null){
                $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
            }
            $tem['productos'] = $this->getProductoItem($aux);
            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['img_proforma']=$aux->img_proforma;
            $tem['img_factura']=$aux->img_factura;
            $tem['mt3']=$aux->mt3;
            $tem['peso']=$aux->peso;
            $tem['emision']=$aux->emision;
            $tem['monto']=$aux->monto;
            /**actualizar cuando este el final**/
            $tem['almacen']="Desconocido";
            // modificar cuando se sepa la logica
            $tem['aero']=1;
            $tem['version']=1;
            $tem['maritimo']=1;
            $data[]=$tem;
        }
        return $data;
    }

    /**
     * obtiene todos las ordenes de compras que son sustituibles
     **/

    public function getOrderSubstitutes(Request $req){
        $data = array();
        $items = Order::where('id','<>', $req->doc_id)
            ->whereNotNull('final_id')

            ->get();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();

        foreach($items as $aux){
            //para maquinas
            $tem = array();
            $tem['id']=$aux->id;
            //$tem['tipo_id']=$aux->tipo_pedido_id;
            $tem['pais_id']=$aux->pais_id;
            $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
            $tem['condicion_pago_id']=$aux->condicion_pago_id;
            $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
            $tem['prioridad_id']=$aux->prioridad_id;
            $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
            $tem['prov_moneda_id']=$aux->prov_moneda_id;
            $tem['estado_id']=$aux->estado_id;
            // $tem['tipo_value']=$aux->typevalue;
            // pra humanos
            $tem['comentario']=$aux->comentario;
            $tem['tasa']=$aux->tasa;
            $tem['documento']= $aux->getTipo();
            $tem['diasEmit']=$aux->daysCreate();
            $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
            $tem['fecha_aprob_compra'] =$aux->fecha_aprob_compra ;
            $tem['fecha_aprob_gerencia'] =$aux->fecha_aprob_compra ;
            $tem['img_aprob'] =$aux->fecha_aprob_compra ;
            $tem['aprob_compras'] =$aux->aprob_compras ;
            $tem['cancelacion'] =$aux->cancelacion ;



            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                $tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->prioridad_id){
                $tem['prioridad']=$prioridad->where('id',$aux->prioridad_id)->first()->descripcion;
            }
            if($aux->prov_moneda_id){
                $tem['moneda']=$coin->where('id',$aux->prov_moneda_id)->first()->nombre;
            }
            if($aux->prov_moneda_id){
                $tem['symbol']=$coin->where('id',$aux->prov_moneda_id)->first()->simbolo;
            }
            if($aux->tipo_id != null){
                $tem['tipo']=$type->where('id',$aux->tipo_id)->first()->tipo;
            }
            $tem['productos'] = $this->getProductoItem($aux);
            $tem['nro_proforma']=$aux->nro_proforma;
            $tem['nro_factura']=$aux->nro_factura;
            $tem['img_proforma']=$aux->img_proforma;
            $tem['img_factura']=$aux->img_factura;
            $tem['mt3']=$aux->mt3;
            $tem['peso']=$aux->peso;
            $tem['emision']=$aux->emision;
            $tem['monto']=$aux->monto;
            /**actualizar cuando este el final**/
            $tem['almacen']="Desconocido";
            // modificar cuando se sepa la logica
            $tem['aero']=1;
            $tem['version']=1;
            $tem['maritimo']=1;
            $data[]=$tem;
        }
        return $data;
    }

    /**
     * obtiene todos los pedido que son sustituibles
     **/


    /**
     * obtine el pedido con sus item sin separar
     */
    public function getOrderSustitute(Request $req){

        $model= Order::findOrFail($req->id);
        $items= $model->OrderItem()->get();
        $products= Array();
        foreach($items as $aux){

            // $aux['origen']=MasterOrderController::getTypeProduct($aux)['descripcion'];
            $aux['asignado']=false;
            $ordI= OrderItem::where('pedido_id', $req->pedido_id)
                ->where('origen_item_id', $aux->id)
                ->first();
            if($ordI != null){
                $aux['asignado']=true;
            }

            $products[]=$aux;
        }
        $model['productos']= $products;

        return $model;
    }



    /*********************************** CONTRAPEDIDOS ***********************************/

    /**
     *  obtiene los motivo de contra pedido
     */
    public function getCustomOrderResons()
    {
        return CustomOrderReason:: get();
    }

    /**
     *  obtiene las prioridad de contra pedido
     */
    public function getCustomOrderPriority()
    {
        return CustomOrderPriority:: get();
    }

    /**
     * obtiene un contra pedido con sus productos
     */
    public function getCustomOrder(Request $req){

        $model=CustomOrder:: findOrFail($req->id);
        $doc= $this->getDocumentIntance($req->tipo);
        $doc = $doc->findOrFail($req->doc_id);
        $prods = array();
        $docIts = $doc->items()->where('tipo_origen_id',2)->get();
        $items =$model->CustomOrderItem()->get();
        $orderIts = OrderItem::where('tipo_origen_id',2)->get();
        $purchaIts = PurchaseItem::where('tipo_origen_id',2)->get();
        $solIts = SolicitudeItem::where('tipo_origen_id',2)->get();
        $prodsProv= Product::where('prov_id', $model->prov_id)->get();

        $sourceType = SourceType::get();
        $data = array();

        foreach($items as $aux){
            $tem = array();
            $tem['asignado'] = false;

            $asigOtro = array();
            $paso = true;
            if($aux->saldo <= 0){
                //$tem['saldo'] = $aux->saldo;
                $paso= false;
            }
            if($paso){

                switch ($req->tipo){
                    case  21:
                        if(sizeof($orderIts->where('origen_item_id',$aux->id)) > 0){
                            $asigOtro[] = array( $sourceType->get(21)->descripcion,$orderIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($purchaIts->where('origen_item_id',$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(23)->descripcion ,$purchaIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($solIts->where('origen_item_id',"<>",$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(22)->descripcion,$solIts->where('doc_origen_id',$aux->id) );
                        }
                        ;break;
                    case  22:
                        if(sizeof($solIts->where('origen_item_id',$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(21)->descripcion ,$solIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($purchaIts->where('origen_item_id',$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(23)>descripcion ,$purchaIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($orderIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(22)->descripcion ,$orderIts->where('doc_origen_id',$aux->id) );
                        }

                        ;break;
                    case  23:
                        $tem['extra'] =$solIts;
                        if(sizeof($solIts->where('origen_item_id',$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(21)->descripcion ,$solIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($orderIts->where('origen_item_id',$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(22)->descripcion ,$orderIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($purchaIts->where('origen_item_id',"<>",$aux->id)) > 0){
                            $asigOtro[] = array($sourceType->get(23)->descripcion  ,$purchaIts->where('doc_origen_id',$aux->id) );
                        }
                        ;break;
                }

            }

            if($paso){
                $prd = $prodsProv->where('id',$aux->producto_id)->first();
                $tem['id'] = $aux->id;
                $tem['tipo_origen_id'] = $aux->tipo_origen_id;
                $tem['doc_origen_id'] = $aux->doc_origen_id;
                $tem['contra_pedido_id'] = $aux->contra_pedido_id;
                $tem['doc_origen_id'] = $aux->doc_origen_id;
                $tem['origen_id'] = $aux->origen_id;
                $tem['descripcion'] = $aux->descripcion;
                $tem['producto_id'] = $aux->producto_id;
                $tem['cantidad'] = $aux->cantidad;
                $tem['saldo'] = $aux->saldo;
                $tem['asignadoOtro']=  $asigOtro;
                //pertence a productos
                $tem['codigo_fabrica'] =$prd->codigo_fabrica;
                $tem['codigo'] =$prd->codigo;

                $exist =$docIts->where('origen_item_id', $aux->id)->first();
                if(sizeof($exist) >0){
                    $tem['asignado'] = true;
                    $tem['renglon_id'] = $exist->id;
                    $tem['saldo'] = $exist->saldo;
                    $tem['cantidad'] = $exist->cantidad;
                }


                $prods[]= $tem;

            }

        }



        $data['id'] =$model->id;
        $data['fecha'] =$model->fecha;
        $data['motivo_contrapedido_id'] =$model->motivo_contrapedido_id;
        $data['tipo_envio_id'] =$model->tipo_envio_id;
        $data['prioridad_id'] =$model->prioridad_id;
        $data['comentario'] =$model->comentario;
        $data['prov_id'] =$model->prov_id;
        $data['fecha_ref_profit'] =$model->fecha_ref_profit;
        $data['cod_ref_profit'] =$model->cod_ref_profit;
        $data['img_ref_profit'] =$model->img_ref_profit;
        $data['fecha_aprox_entrega'] =$model->fecha_aprox_entrega;
        $data['monto'] =$model->monto;
        $data['moneda_id'] =$model->moneda_id;
        $data['abono'] =$model->abono;
        $data['img_abono'] =$model->img_abono;
        $data['fecha_abono'] =$model->fecha_abono;
        $data['tipo_pago_contrapedido_id'] =$model->tipo_pago_contrapedido_id;
        $data['aprobada'] =$model->aprobada;
        $data['titulo'] =$model->titulo;
        $data['productos']= $prods;

        return $data;
    }

    /**
     * agrega un contra pedido al documento
     *
     */
    public  function addCustomOrderItem(Request $req){

        $resul= array();


//        $cpIt= CustomOrderItem::findOrFail($req->id);
//        $item = new OrderItem();
//        if($req->has('renglon_id')){
//            $item = OrderItem:: findOrFail($req->renglon_id);
//
//        }else{
//            $item->cantidad = $req->saldo;
//        }
//        $item->tipo_origen_id = 2;
//        $item->pedido_id =  $req->pedido_id;
//        $item->doc_origen_id =  $req->doc_origen_id;
//        $item->origen_item_id = $req->id;
//        $item->descripcion = $req->descripcion;
//        $item->saldo = $req->saldo;
//
//        if($req->saldo >= $req->cantidad){
//            $cpIt->saldo=0;
//        }else{
//            $cpIt->saldo = $req->cantidad - $req->saldo;
//        }
//        $cpIt->save();
//        $item->save();

        //   return $item;

    }

    public  function removeCustomOrderItem(Request $req){
        $item = OrderItem:: findOrFail($req->id);
        $item->destroy($item->id);
    }


    /**
     *
     * revisar por intergar al maestro de Order
     * obtiene los contra pedidos de un proveedor
     */
    public function getCustomOrders(Request $req){

        $data = Array();
        $items = CustomOrder::
        where('aprobada','1')
            ->where('prov_id',$req->prov_id)
            ->get();
        $purchaIts=PurchaseItem::where('tipo_origen_id',2)->get();
        $orderIts=OrderItem::where('tipo_origen_id',2)->get();
        $solIts=SolicitudeItem::where('tipo_origen_id',2)->get();

        $doc= $this->getDocumentIntance($req->tipo);
        $doc = $doc->findOrFail($req->doc_id);
        $docIts = $doc->items()->get();
        $remplace= $docIts->where('tipo_origen_id', $req->tipo);
        $imports= array();
        if($req->tipo == 22){
            $imports = $docIts->where('tipo_origen_id','21');
        }
        if($req->tipo == 23){
            $imports = $docIts->where('tipo_origen_id','22');

        }
        foreach($items as $aux){
            $auxIts = $aux->CustomOrderItem()->get();
            $paso=true;
            $tem['asignado'] = false;
            $asigOtro=array();

            // fue aasignado
            if(sizeof($docIts->where('doc_origen_id', $aux->id))>0){
                $tem['asignado'] = true;
            }

            // vino de otro docuemento igual?
            if(sizeof($remplace->where('doc_origen_id', $aux->id))>0){
                $tem['asignado'] = true;
            }

            // fue importado
            foreach($imports as $imps){
                $first= $this->getFirstProducto($imps);
                if($first->tipo_origen_id == 2 && $first->doc_origen_id == $aux->id){
                    $tem['asignado'] = true;
                    $tem['import'] = $imps;
                }
            }

            if(!$tem['asignado'] && sizeof($auxIts->sum('saldo')) == 0){
                $paso= false;
            }else{

                switch ($req->tipo){
                    case  21:
                        if(sizeof($orderIts->where('doc_origen_id',$aux->id)) > 0){
                            $asigOtro[] = array("Proforma" ,$orderIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($purchaIts->where('doc_origen_id',$aux->id)) > 0){
                            $asigOtro[] = array("Orden de Compra" ,$purchaIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($solIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                            $asigOtro[] = array("Solicitud" ,$solIts->where('doc_origen_id',$aux->id) );
                        }
                        ;break;
                    case  22:
                        if(sizeof($solIts->where('doc_origen_id',$aux->id)) > 0){
                            $asigOtro[] = array("Solicitud" ,$solIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($purchaIts->where('doc_origen_id',$aux->id)) > 0){
                            $asigOtro[] = array("Orden de Compra" ,$purchaIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($orderIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                            $asigOtro[] = array("Proforma" ,$orderIts->where('doc_origen_id',$aux->id) );
                        }

                        ;break;
                    case  23:
                        $tem['extra'] =$solIts;
                        if(sizeof($solIts->where('doc_origen_id',$aux->id)) > 0){
                            $asigOtro[] = array("Solicitud" ,$solIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($orderIts->where('doc_origen_id',$aux->id)) > 0){
                            $asigOtro[] = array("Proforma" ,$orderIts->where('doc_origen_id',$aux->id) );
                        }
                        if(sizeof($purchaIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                            $asigOtro[] = array("Orden de Compra" ,$purchaIts->where('doc_origen_id',$aux->id) );
                        }
                        ;break;
                }
            }

            if($paso){
                $tem['id'] =$aux->id;
                $tem['fecha'] =$aux->fecha;
                $tem['motivo_contrapedido_id'] =$aux->motivo_contrapedido_id;
                $tem['tipo_envio_id'] =$aux->tipo_envio_id;
                $tem['prioridad_id'] =$aux->prioridad_id;
                $tem['comentario'] =$aux->comentario;
                $tem['prov_id'] =$aux->prov_id;
                $tem['fecha_ref_profit'] =$aux->fecha_ref_profit;
                $tem['cod_ref_profit'] =$aux->cod_ref_profit;
                $tem['img_ref_profit'] =$aux->img_ref_profit;
                $tem['fecha_aprox_entrega'] =$aux->fecha_aprox_entrega;
                $tem['monto'] =$aux->monto;
                $tem['moneda_id'] =$aux->moneda_id;
                $tem['abono'] =$aux->abono;
                $tem['img_abono'] =$aux->img_abono;
                $tem['fecha_abono'] =$aux->fecha_abono;
                $tem['tipo_pago_contrapedido_id'] =$aux->tipo_pago_contrapedido_id;
                $tem['aprobada'] =$aux->aprobada;
                $tem['titulo'] =$aux->titulo;
                $tem['asignadoOtro'] =$asigOtro;
                $data[]=$tem;
            }
            // }
        }
        return $data;
    }

    public function getDocument(Request $req){
        switch($req->tipo){
            case 21:
                $model= Solicitude::findOrFail($req->id);
                break;
            case 22:
                $model= Order::findOrFail($req->id);
                break;
            case 23:
                $model= Purchase::findOrFail($req->id);
                break;
        }
        $prov= Provider::findOrFail($model->prov_id);
        $mone=Monedas::findOrFail($model->prov_moneda_id);
        $adjs = array();
        //para maquinas
        $tem = array();
        $tem['id']=$model->id;
        $tem['tipo_id']=$model->tipo_id;
        $tem['pais_id']=$model->pais_id;
        $tem['final_id']=$model->final_id;
        $tem['direccion_almacen_id']=$model->direccion_almacen_id;
        $tem['condicion_pago_id']=$model->condicion_pago_id;
        $tem['motivo_pedido_id']=$model->motivo_pedido_id;
        $tem['prioridad_id']=$model->prioridad_id;
        $tem['condicion_pedido_id']=$model->condicion_pedido_id;
        $tem['prov_moneda_id']=$model->prov_moneda_id;
        $tem['estado_id']=$model->estado_id;
        $tem['doc_parent_id']=$model->doc_parent_id;
        $tem['doc_parent_origen_id']=$model->doc_parent_origen_id;
        // pra humanos
        $tem['comentario']=$model->comentario;
        $tem['tasa']=$model->tasa;
        $tem['proveedor']=$prov->razon_social;
        $tem['documento']= $model->type;
        $tem['titulo']= $model->titulo;
        $tem['diasEmit']=$model->daysCreate();
        $tem['fecha_aprob_compra'] =$model->fecha_aprob_compra ;
        $tem['fecha_aprob_gerencia'] =$model->fecha_aprob_compra ;
        $tem['img_aprob'] =$model->fecha_aprob_compra ;


        $tem['estado']=OrderStatus::findOrFail($model->estado_id)->estado;

        if($model->motivo_id){
            $tem['motivo']=OrderReason::findOrFail($model->motivo_id)->motivo;
        }
        if($model->pais_id){
            $tem['pais']=Country::findOrFail($model->pais_id)->short_name;
        }
        if($model->prioridad_id){
            $tem['prioridad']=OrderPriority::findOrFail($model->prioridad_id)->descripcion;
        }
        if($model->prov_moneda_id){
            $tem['moneda']=$mone->nombre;
        }
        if($model->prov_moneda_id){
            $tem['symbol']=$mone->simbolo;
        }
        if($model->tipo_id != null){
            $tem['tipo']= OrderType::findOrFail($model->tipo_id)->tipo;
        }

        $tem['nro_proforma']=$model->nro_proforma;
        $tem['nro_factura']=$model->nro_factura;
        $tem['img_proforma']=$model->img_proforma;
        $tem['img_factura']=$model->img_factura;
        $tem['mt3']=$model->mt3;
        $tem['peso']=$model->peso;
        $tem['emision']=$model->emision;
        $tem['monto']=$model->monto;
        $tem['productos'] =$this->getProductoItem($model);

        /*      foreach( as $aux){
                  $at= array();
                  $at['id']= $aux->id
                  {id:data.file.id,thumb:data.file.thumb,tipo:data.file.tipo,name:data.file.file, documento:$scope.folder};
              }*/

        /**actualizar cuando este el final**/
        $tem['almacen']="Desconocido";

        // modificar cuando se sepa la logica
        $tem['aero']=1;
        $tem['version']=1;
        $tem['maritimo']=1;
        $atts = array();
        //                                var data ={id:data.file.id,thumb:data.file.thumb,tipo:data.file.tipo,name:data.file.file, documento:$scope.folder};

        foreach($model->attachments()->get() as $aux){
            $auxFile= array();
            $file= FileModel::findOrFail($aux->archivo_id);
            $att['id'] = $aux->id;
            $att['final_id'] = $aux->final_id;
            $att['archivo_id'] = $aux->archivo_id;
            $att['doc_id'] = $aux->doc_id;
            $att['documento'] = $aux->documento;
            $att['comentario'] = $aux->comentario;

            $auxFile['id']=$file->id;
            $auxFile['thumb']=$file->getThumbName();
            $auxFile['tipo']=$file->tipo;
            $auxFile['file'] = $file->archivo;
            $att['file'] = $auxFile;
            $atts[]= $att;



        }
        $tem['adjuntos'] = $atts;

        return $tem;

    }

    /**
     * asigna la orden de compra a una solicitud
     *
     **/
    public function addCustomOrderSolicitud(Request $req){

        $model= CustomOrder::findOrFail($req->id);
        $items = $model->CustomOrderItem()->get();
        $resul= array();
        $resul['action']= "new";
        $newItems= array();
        $oldItems= array();
        $doc =Solicitude::findOrFail($req->doc_id);

        $docItms= $doc->items()->where("tipo_origen_id",2)->get();
        foreach($items as $aux){
            if(
                sizeof($docItms->where('origen_item_id',$aux->id)->where('doc_origen_id',$req->id)) == 0){
                $item= $doc->newItem();
                $item->tipo_origen_id = 2;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id = $aux->id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->descripcion = $aux->descripcion;
                $item->producto_id = $aux->producto_id;
                $item->doc_origen_id = $aux->contra_pedido_id;
                //$aux->saldo=0;
                $oldItems[]=$aux;
                $newItems[]=$item;
            }
        }
        $resul['newitems']=$newItems;
        $resul['oldItems']=$oldItems;
        $doc->items()->saveMany($newItems);
        $model->CustomOrderItem()->saveMany($oldItems);
        return $resul;
    }

    /**
     * asigna la orden de compra a una orden de compra
     *
     **/
    public function addCustomOrderPurchase(Request $req){

        $model= CustomOrder::findOrFail($req->id);
        $items = $model->CustomOrderItem()->get();
        $resul= array();
        $resul['action']= "new";
        $newItems= array();
        $oldItems= array();
        $doc =Purchase::findOrFail($req->doc_id);

        $docItms= $doc->items()->where("tipo_origen_id",2)->get();
        foreach($items as $aux){
            if(
                sizeof($docItms->where('origen_item_id',$aux->id)->where('doc_origen_id',$req->id)) == 0){
                $item= $doc->newItem();
                $item->tipo_origen_id = 2;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id = $aux->id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->descripcion = $aux->descripcion;
                $item->producto_id = $aux->producto_id;
                $item->doc_origen_id = $aux->contra_pedido_id;
                $aux->saldo=0;
                $oldItems[]=$aux;
                $newItems[]=$item;
            }
        }
        $resul['newitems']=$newItems;
        $resul['oldItems']=$oldItems;
        $doc->items()->saveMany($newItems);
        $model->CustomOrderItem()->saveMany($oldItems);
        return $resul;
    }

    /**
     * asigna la orden de compra a una orden de compra
     *
     **/
    public function addCustomOrderOrder(Request $req){

        $model= CustomOrder::findOrFail($req->id);
        $items = $model->CustomOrderItem()->get();
        $resul= array();
        $resul['action']= "new";
        $newItems= array();
        $oldItems= array();
        $doc =Order::findOrFail($req->doc_id);

        $docItms= $doc->items()->where("tipo_origen_id",2)->get();
        foreach($items as $aux){
            if(
                sizeof($docItms->where('origen_item_id',$aux->id)->where('doc_origen_id',$req->id)) == 0){
                $item= $doc->newItem();
                $item->tipo_origen_id = 2;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id = $aux->id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->descripcion = $aux->descripcion;
                $item->producto_id = $aux->producto_id;
                $item->doc_origen_id = $aux->contra_pedido_id;
                $aux->saldo=0;
                $oldItems[]=$aux;
                $newItems[]=$item;
            }
        }
        $resul['newitems']=$newItems;
        $resul['oldItems']=$oldItems;
        $doc->items()->saveMany($newItems);
        $model->CustomOrderItem()->saveMany($oldItems);
        return $resul;
    }
    /**
     * elimina los item
     **/
    public function RemoveCustomOrderSolicitud(Request $req){
        $resul["accion"]= "del";
        $model = SolicitudeItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->get();
        $ids = array();

        foreach($model as $aux){
            $ids[]= $aux->id;
        }

        SolicitudeItem::destroy($ids);
        $resul["keys"]=$ids;
        return $resul;

    }

    /**
     * elimina los item
     **/
    public function RemoveCustomOrderPurchase(Request $req){
        $resul["accion"]= "del";
        $model = PurchaseItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->get();
        $ids = array();

        foreach($model as $aux){
            $ids[]= $aux->id;
        }

        PurchaseItem::destroy($ids);
        $resul["keys"]=$ids;
        return $resul;

    }

    /**
     * elimina los item
     **/
    public function RemoveCustomOrderOrder(Request $req){
        $resul["accion"]= "del";
        $model = OrderItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->get();
        $ids = array();

        foreach($model as $aux){
            $ids[]= $aux->id;
        }

        OrderItem::destroy($ids);
        $resul["keys"]=$ids;
        return $resul;

    }

    /*********************************** kitchen box (cocinas)*********************************************/


    public function getKitchenBox(Request $req){
        $model=KitchenBox:: findOrFail($req->id);
        return $model;
    }
    /**
     * falta incluir a algortimo que determina si esta aprobado o no
     * obtiene los kitchen box de un proveedor
     */
    public function getKitchenBoxs(Request $req){

        $data = Array();
        $items = KitchenBox::
        where('prov_id',$req->prov_id)
            ->where('precio_bs','<>',0)
            ->whereNotNull('img_conf_gerente')
            ->whereNotNull('fecha_conf_gerente')
            ->get();
        $purchaIts=PurchaseItem::where('tipo_origen_id',3)->get();
        $orderIts=OrderItem::where('tipo_origen_id',3)->get();
        $solIts=SolicitudeItem::where('tipo_origen_id',3)->get();
        $doc= $this->getDocumentIntance($req->tipo);
        $doc = $doc->findOrFail($req->doc_id);
        // $coins= Monedas::get();
        $impors= $doc->items()->where('tipo_origen_id', $req->tipo)->get();

        foreach($items as $aux){
            $paso=true;
            $tem['asignado'] =false;

            $asigOtro=array();


            if(sizeof($purchaIts->where('doc_origen_id',$aux->id)) > 0){
                if($req->tipo ==23){

                    if(sizeof($purchaIts->where('doc_id',$req->doc_id)) > 0){
                        $tem['asignado'] = true;
                    }

                }
            }
            if(sizeof($orderIts->where('doc_origen_id',$aux->id)) > 0){
                if($req->tipo ==22){
                    if(sizeof($orderIts->where('doc_id',$req->doc_id)) > 0){
                        $tem['asignado'] = true;
                    }

                }
            }
            if(sizeof($solIts->where('doc_origen_id',$aux->id)) > 0){
                if($req->tipo ==21){
                    if(sizeof($solIts->where('doc_id',$req->doc_id)) > 0){
                        $tem['asignado'] = true;
                    }

                }
            }

            /*** importados*/
            //$tem['ex']= $impors;
            foreach($impors as $imps){
                $first= $this->getFirstProducto($imps);
                //$tem['exf']=$first->tipo_origen_id;
                if($first->tipo_origen_id == 3){
                    // $tem['exf2']=$first->tipo_origen_id;

                    if($first->doc_origen_id == $aux->id){
                        $tem['asignado'] = true;
                        $tem['import'] = $imps;
                    }
                }

            }
            switch ($req->tipo){
                case  21:
                    if(sizeof($orderIts->where('doc_origen_id',$aux->id)) > 0){
                        $asigOtro[] = array("Proforma" ,$orderIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($purchaIts->where('doc_origen_id',$aux->id)) > 0){
                        $asigOtro[] = array("Orden de Compra" ,$purchaIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($solIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                        $asigOtro[] = array("Solicitud" ,$solIts->where('doc_origen_id',$aux->id) );
                    }
                    ;break;
                case  22:
                    if(sizeof($solIts->where('doc_origen_id',$aux->id)) > 0){
                        $asigOtro[] = array("Solicitud" ,$solIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($purchaIts->where('doc_origen_id',$aux->id)) > 0){
                        $asigOtro[] = array("Orden de Compra" ,$purchaIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($orderIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                        $asigOtro[] = array("Proforma" ,$orderIts->where('doc_origen_id',$aux->id) );
                    }

                    ;break;
                case  23:
                    $tem['extra'] =$solIts;
                    if(sizeof($solIts->where('doc_origen_id',$aux->id)) > 0){
                        $asigOtro[] = array("Solicitud" ,$solIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($orderIts->where('doc_origen_id',$aux->id)) > 0){
                        $asigOtro[] = array("Proforma" ,$orderIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($purchaIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                        $asigOtro[] = array("Orden de Compra" ,$purchaIts->where('doc_origen_id',$aux->id) );
                    }
                    ;break;
            }


            if($paso){
                $tem['id']=$aux->id;
                $tem['prov_id']=$aux->prov_id;
                $tem['nro_proforma']=$aux->nro_proforma;
                $tem['img_proforma']=$aux->img_proforma;
                $tem['monto']=$aux->monto;
                $tem['moneda_id']=$aux->moneda_id;
                $tem['precio_bs']=$aux->precio_bs;
                $tem['tipo_envio_id']=$aux->tipo_envio_id;
                $tem['fecha_aprox_entrega']=$aux->fecha_aprox_entrega;
                $tem['prioridad_id']=$aux->prioridad_id;
                $tem['condicion_pago_id']=$aux->condicion_pago_id;
                $tem['comentario']=$aux->comentario;
                $tem['fecha_ref_profit']=$aux->fecha_ref_profit;
                $tem['codigo_ref_profit']=$aux->codigo_ref_profit;
                $tem['descripcion_ref_profit']=$aux->descripcion_ref_profit;
                $tem['clientes_id']=$aux->clientes_id;
                $tem['monto_abono']=$aux->monto_abono;
                $tem['fecha_abono']=$aux->fecha_abono;
                $tem['img_abono']=$aux->img_abono;
                $tem['fecha_pedido']=$aux->fecha_pedido;
                $tem['img_ada']=$aux->img_ada;
                $tem['fecha_conf_fabrica']=$aux->fecha_conf_fabrica;
                $tem['img_conf_fabrica']=$aux->img_conf_fabrica;
                $tem['fecha_conf_gerente']=$aux->fecha_conf_gerente;
                $tem['img_conf_gerente']=$aux->img_conf_gerente;
                $tem['fecha_conf_valcro']=$aux->fecha_conf_valcro;
                $tem['img_conf_valcro']=$aux->img_conf_valcro;
                $tem['fecha_evaluacion']=$aux->fecha_evaluacion;
                $tem['descripcion']=$aux->descripcion;
                $tem['tipo_origen_id']=$aux->tipo_origen_id;
                $tem['producto_id']=$aux->producto_id;
                $tem['origen_id']=$aux->origen_id;
                $tem['img_evaluacion']=$aux->img_evaluacion;
                $tem['usuario']=$aux->usuario;
                $tem['asignadoOtro']=$asigOtro;


                $data[]= $tem;
            }

        }


        return $data;
    }


    /**
     * asigna un kitchenbox a un pedido
     **/
    public function addkitchenBoxSolicitude(Request $req){

        $resul['action']="new";
        $resul= array();
        $doc =Solicitude::findOrFail($req->doc_id);
        $k= kitchenBox::findOrFail($req->id);
        $item= $doc->newItem();
        $item->tipo_origen_id = 3;
        $item->doc_id = $req->doc_id;// solicitud/compra/ pedido
        $item->origen_item_id = $k->id;
        $item->cantidad = 1;
        $item->saldo = 1;
        $item->descripcion = $k->descripcion;
        $item->producto_id = $k->producto_id;
        $item->doc_origen_id = $k->id;/// reemplazr cuando se sepa la logica
        $resul['response']=$item->save();
        $resul['item']=$item;
    }

    /**
     * asigna un kitchenbox a un pedido
     **/
    public function addkitchenBoxOrder(Request $req){

        $resul['action']="new";
        $resul= array();
        $doc =Order::findOrFail($req->doc_id);
        $k= kitchenBox::findOrFail($req->id);
        $item= $doc->newItem();
        $item->tipo_origen_id = 3;
        $item->doc_id = $req->doc_id;// solicitud/compra/ pedido
        $item->origen_item_id = $k->id;
        $item->cantidad = 1;
        $item->saldo = 1;
        $item->descripcion = $k->descripcion;
        $item->producto_id = $k->producto_id;
        $item->doc_origen_id = $k->id;/// reemplazr cuando se sepa la logica
        $resul['response']=$item->save();
        $resul['item']=$item;
    }
    /**
     * asigna un kitchenbox a un pedido
     **/
    public function addkitchenBoxPurchase(Request $req){

        $resul['action']="new";
        $resul= array();
        $doc =Purchase::findOrFail($req->doc_id);
        $k= kitchenBox::findOrFail($req->id);
        $item= $doc->newItem();
        $item->tipo_origen_id = 3;
        $item->doc_id = $req->doc_id;// solicitud/compra/ pedido
        $item->origen_item_id = $k->id;
        $item->cantidad = 1;
        $item->saldo = 1;
        $item->descripcion = $k->descripcion;
        $item->producto_id = $k->producto_id;
        $item->doc_origen_id = $k->id;/// reemplazr cuando se sepa la logica
        $resul['response']=$item->save();
        $resul['item']=$item;
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBoxSolicitude(Request $req){
        $resul["accion"]= "del";
        $model = SolicitudeItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->where('tipo_origen_id', 3)
            ->get();
        $ids = array();

        foreach($model as $aux){
            $ids[]= $aux->id;
        }

        SolicitudeItem::destroy($ids);
        $resul["keys"]=$ids;
        return $resul;
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBoxPurchase(Request $req){
        $resul["accion"]= "del";
        $model = PurchaseItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->where('tipo_origen_id', 3)
            ->get();
        $ids = array();

        foreach($model as $aux){
            $ids[]= $aux->id;
        }

        PurchaseItem::destroy($ids);
        $resul["keys"]=$ids;
        return $resul;
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBoxOrder(Request $req){
        $resul["accion"]= "del";
        $model = OrderItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->where('tipo_origen_id', 3)
            ->get();
        $ids = array();

        foreach($model as $aux){
            $ids[]= $aux->id;
        }

        OrderItem::destroy($ids);
        $resul["keys"]=$ids;
        return $resul;

    }
    /*************************************** ORDEDENES DE COMPRA *****************************************

    /**
     * @deprecated
     * obtiene las ordenes de compra de un pedido
     */
    public function getOrdenPurchaseOrder(Request $req){
        return Order::findOrFail($req->id)->item()->where('pedido_tipo_origen_id',1);
    }

    /**
     * @deprecated
     * obtiene toda la data de un pedido
     */
    public function getOrden(Request $req){
        $aux=Order::findOrFail($req->id);
        $tem['id']=$aux->id;
        $tem['tipo_pedido_id']=$aux->tipo_pedido_id;
        $tem['pais_id']=$aux->pais_id;
        $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
        $tem['condicion_pago_id']=$aux->condicion_pago_id;
        $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
        $tem['prioridad_id']=$aux->prioridad_id;
        $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
        $tem['prov_moneda_id']=$aux->prov_moneda_id;
        // pra humanos
        $tem['comentario']=$aux->comentario;
        $tem['proveedor']=Provider::findOrFail($aux->prov_id)->razon_social;
        $tem['motivo']=OrderReason::findOrFail($aux->motivo_pedido_id)->motivo;
        $tem['pais']=Country::findOrFail($aux->pais_id)->short_name;
        $tem['nro_proforma']=$aux->nro_proforma;
        $tem['nro_factura']=$aux->nro_factura;
        $tem['img_proforma']=$aux->img_proforma;
        $tem['img_factura']=$aux->img_factura;
        $tem['mt3']=$aux->mt3;
        $tem['peso']=$aux->peso;
        $tem['emision']=$aux->emision;
        $tem['monto']=$aux->monto;
        $tem['estado']=OrderStatus::findOrFail($aux->estado_id)->estado;
        $tem['prioridad']=OrderPriority::findOrFail($aux->prioridad_id)->descripcion;
        $tem['moneda']=Monedas::findOrFail($aux->prov_moneda_id)->nombre;
        $tem['symbol']=Monedas::findOrFail($aux->prov_moneda_id)->simbolo;
        $tem['diasEmit']=$aux->daysCreate();
        $tem['tipo']= OrderType::findOrFail($aux->tipo_pedido_id)->tipo;
        // $tem['productos'] = $this->getProductoOrden($aux);
        /**actualizar cuando este el final**/
        $tem['almacen']="Desconocido";

        // modificar cuando se sepa la logica
        $tem['aero']=1;
        $tem['version']=1;
        $tem['maritimo']=1;

        return $tem;

    }

    /**
     * obtiene todos los producto de un pedido
     * @param obj Order
     * @return array de productos
     */
    private function getProductoItem($order){

        $items= $order->items()->get();
        $origen = SourceType::get();
        $contra=Collection::make(Array());
        $kitchen= Collection::make(Array());
        $pediSus= Collection::make(Array());
        $all= Collection::make(Array());
        $prod_prov = Product::where('prov_id', $order->prov_id)->get();

        /** contra pedido*/
        foreach($items->where('tipo_origen_id', '2') as $aux){
            if(!$contra->contains($aux->doc_origen_id)){
                $contra->push(CustomOrder::find($aux->doc_origen_id));
            }

        }
        /** kitceh box*/
        foreach($items->where('tipo_origen_id', '3') as $aux){
            $kitchen->push(KitchenBox::find($aux->origen_item_id));
        }

        /** importados */
        foreach($items->where('tipo_origen_id', ''.$order->getTipoId()) as $aux){
            $first= $this->getFirstProducto($aux);
            switch($first->tipo_origen_id){
                case 2:
                    $tem= CustomOrder::findOrFail($first->doc_origen_id);
                    $tem['sustitute'] = $aux->doc_origen_id;
                    $contra->push($tem);
                    break;
                case 3:
                    $kitchen->push($aux);
                    $tem= KitchenBox::findOrFail($first->doc_origen_id);
                    $tem['sustituto'] = $aux->doc_origen_id;
                    break;
            }
            if(!$pediSus->contains($aux->doc_origen_id)){
                $pediSus[]=$order::find($aux->doc_origen_id);
            }

        }

        /** todos */
        foreach($items as $aux){
            $tem = array();
            $tem['id']= $aux->id;
            $tem['cantidad']= $aux->cantidad;
            $tem['saldo']= $aux->saldo;
            $tem['descripcion']= $aux->descripcion;
            $tem['tipo_origen_id']= $aux->tipo_origen_id;
            $tem['origen_item_id']= $aux->origen_item_id;
            $tem['doc_origen_id']= $aux->doc_origen_id;
            $tem['doc_id']= $aux->doc_id;
            $tem['producto_id']= $aux->producto_id;
            $tem['cod_producto']= $aux->id;
            $tem['codigo_fabrica']=$prod_prov->where('id',''.$aux->producto_id)->first()->codigo_fabrica;
            $tem['documento']=  $origen->where('id', $aux->tipo_origen_id)->first()->descripcion;

            $tem['asignado']= true;
            //$tem['origen']= MasterOrderController::getTypeProduct($aux)['descripcion'];
            $all->push($tem);
        }

        $data['contraPedido'] = $contra;
        $data['kitchenBox'] = $kitchen;
        $data['pedidoSusti'] = $pediSus;
        $data['todos'] = $all;
        return $data;
    }

    private function getDocumentIntance($tipo){
        switch($tipo){
            case 21:
                return new Solicitude();
                break;
            case 22:
                return new Order();
                break;
            case 23:
                return new  Purchase();
                break;
        }
    }

    /**
     * obtiene los paises donde un provedor tiene paises
     */
    private function getCountryProvider($id){
        $model=  ProviderAddress::where('prov_id',$id)->get();
        $data= Collection::make(array());
        foreach($model as $aux){
            if(!$data->contains($aux->pais_id)){
                $p=Country::find($aux->pais_id);
                $data->push($p);
            }

        }
        return $data;
    }


    /**
     * Obtiene las ordenes de compra de un provedor
     ***/
    public function getProviderOrder(Request $req){

        $model =PurchaseOrder::
        select(DB::raw("tbl_compra_orden.id , nro_orden, emision , aprobada, comentario , "
            ." (select count(*) from tbl_pedido_item where deleted_at is null and
            pedido_tipo_origen_id = 1 and origen_id= tbl_compra_orden.id"
            .") as asignado"
        ))
            ->leftJoin('tbl_pedido_item','tbl_compra_orden.id','=','tbl_pedido_item.origen_id')
            ->where('aprobada','1')
            //  ->where('tbl_pedido_item.pedido_id',$req->pedido_id)
            ->where('prov_id',$req->prov_id)
            ->Where(function($query) use ($req)
            {
                $query->where('tbl_pedido_item.pedido_id',null)
                    ->Orwhere('tbl_pedido_item.pedido_id',$req->pedido_id)
                ;

            })
            ->groupby('tbl_compra_orden.id')
            ->get();
        $i=0;
        foreach( $model as $aux){
            $model[$i]['size']= $aux->PurchaseOrderItem()->count();
            $i++;
        }
        return $model;
    }

    /**
     * Obtiene la orden de compra
     ***/
    public function getPurchaseOrder(Request $req){
        $model =PurchaseOrder::findOrFail($req->id);
        $products=Array();

        $i=0;
        foreach( $model->PurchaseOrderItem()->get() as $aux){
            $products[$i]['id']= $aux->id;
            $auxPro=Product::findOrFail($aux->producto_id);
            $products[$i]['profit_id']=$auxPro->codigo_profit;
            $products[$i]['tipo']='desconocido';
            $products[$i]['descripcion']=$auxPro->descripcion_profit;
            $products[$i]['cantidad']=$aux->cantidad;
            $products[$i]['comentario']="  ";// no comentario
            $products[$i]['adjunto']="";// no adjuntos
        }
        $model['productos']= $products;
        return $model;
    }

    /**
     * obtiene los paises en que un provedor tiene
     * almacen
     **/
    public function getProviderCountry(Request $req){
        /*
                $model=  ProviderAddress::where('prov_id',$req->id)->get();
                $data= Collection::make(array());
                foreach($model as $aux){
                    if(!$data->contains($aux->pais_id)){
                        $p=Country::find($aux->pais_id);
                        $data->push($p);
                    }

                }*/

        return $this->getCountryProvider($req->id);
    }



    /**
     * obtiene los direcciones de
     * donde un proveeed
     * almacen
     **/
    public function getInvoiceAddressCountry(Request $req){
        $data =ProviderAddress::where('prov_id', $req->prov_id)->where(
            function ($query){
                $query->where('tipo_dir',1)->orWhere('tipo_dir',3);
            })->get();
        if($req->has('pais_id')){
            $data = $data->where('pais_id', $req->pais_id);
        }
        return $data;
    }

    public function getStoreAddressCountry(Request $req){
        $data =ProviderAddress::where('prov_id', $req->prov_id)->where(
            function ($query){
                $query->where('tipo_dir',2)->orWhere('tipo_dir',3);
            })->get();        if($req->has('pais_id')){
            $data = $data->where('pais_id', $req->pais_id);
        }
        return $data;
    }

    /**
     * Las getProviderCoin de un proveedro
     * @deprecated
     **/
    public function getProviderCoins(Request $req){
        $model=  Provider::findOrFail($req->id);
        return $model->getProviderCoin()->get();
    }
    /**
     * Condiciones de pago de un proveedor
     **/
    public function getProviderPaymentCondition(Request $req){
        $auxCond=Provider::findOrFail($req->id)->first()->getPaymentCondition()->get();
        $cond= Array();
        $i=0;
        $text='';
        foreach( $auxCond as $aux){
            $cond[$i]['id']= $aux->id;
            foreach( $aux->getItems()->get() as $aux2){
                $text=$text.$aux2->porcentaje.'% al '.$aux2->descripcion.$aux2->dias.' dias';
            }
            $cond[$i]['titulo']= $text;
            $text='';
            $i++;
        }
        return $cond;
    }

    /************************************* REEMPLACE **************************************/
    /**
     * importa todos lo items a una nueva solictud y cancel ala anterior
     * @param  doc_id el ducumento donde se importara los items
     * @param id el id anterior
     * @return items modificados sin id
     **/
    /*public function reemplaceSolicitude(Request $req){
        $origen = Solicitude::findOrFail($req->id);
        $destino = Solicitude::findOrFail($req->doc_id);
        $newIts= array();
        $oldIts = array();
        $result = array();

        foreach($origen->items()->get() as $oldItem){
            $newItem = new SolicitudeItem();
            $newItem->tipo_origen_id =21;
            $newItem->doc_id =$destino->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$req->id;
            $newItem->cantidad =$oldItem->saldo;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $oldItem->saldo=0;

            $newIts[]= $newItem;
            $oldIts[]= $oldItem;
        }
        $result['action']="inport";
        $result['newitems']=$newIts;
        $result['olditems']=$oldIts;

        $destino->saveMay($newIts);
        $origen->saveMany($oldIts);
        $origen->comentario_cancelacion = "&system reemplazdo por ".$destino->id;
        $origen->save();
        return $result;

    }*/

    /*************************************** SAVE *****************************************/

    public function saveSolicitude(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'monto' => 'required',
            'tasa' => 'required',
            'prov_moneda_id'=> 'required'
        ]);
        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        }else{
            $result = array("success" => "Registro guardado con éxito","action"=>"new");
            $model = new Solicitude();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }
            $model= $this->setDocItem($model, $req);

            if($req->has("close")){
                $model->final_id=
                    "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
                    ."-a".sizeof($model->attachments()->get());
            }
            $model->save();
            $result['id']= $model->id;



        }


        return $result;

    }



    public function savePurchaseOrder(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'monto' => 'required',
            'tasa' => 'required',
            'prov_moneda_id'=> 'required'
        ]);
        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        }else{
            $result = array("success" => "Registro guardado con éxito","action"=>"new");
            $model = new Purchase();
            $aux = $this->setDocItem($model, $req);
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }
            if ($req->has('copy')) {
                $aux = new Purchase();
                $aux = $this->setDocItem($aux, $req);
                $aux->version = $model->version+1;
            }


            if($req->has("close")){
                $model->final_id=
                    "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
                    ."-a".sizeof($model->attachments()->get())
                ;
                $cps =$model->builtPaymentDocs();
                $result['sub']= $cps;
            }
            $model= $this->setDocItem($model, $req);
            $model->save();
            $result['id']= $model->id;

        }


        return $result;

    }



    /***
     * Guarda un registro en la base de datos
     * @param $req la data del registro a guradar
     * @return json donde el primer valor representa 'error' en caso de q falle y
     * 'succes' si se realizo la accion
     ******/
    public function saveOrder(Request $req)
    {

        $result= array();
        //////////validation
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required'
        ]);

        if ($validator->fails()) { ///ups... erorres

            $result['error'] =  "errores en campos de formulario";

        } else {  ///ok
//
            $result['success'] = "Registro guardado con éxito!";
            $result['action'] = "new";
            $model = new Order();
            //////////condicion para editar
//            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="upd";
            }
            $model = $this->setDocItem($model,$req);

            if($req->has("close")){
                $result["action2"]="close";
                $model->final_id=
                    "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
                    ."-a".sizeof($model->attachments()->get());
            }

            $result['response']= $model->save();
            $result['id']=$model->id;


        }

        return $result;

    }

    /***/
    public function CloseSolicitude(Request $req)
    {
        $result['success'] = "Registro guardado con éxito!";
        $result['action'] = "new";
        $model = Solicitude::findOrFail($req->id);
        $model->final_id=
            "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
            ."-a".sizeof($model->attachments()->get());
        $model->save();
        //  EmailController::sendEmail("emails.prueba", [],[]);
        $result['template'] = view("emails.prueba");
        //dd( $result['template']);


        return $result;

    }

    /***/
    public function ClosePurchase(Request $req)
    {
        $result['success'] = "Registro guardado con éxito!";
        $result['action'] = "new";
        $model = Purchase::findOrFail($req->id);
        $model->final_id=
            "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
            ."-a".sizeof($model->attachments()->get());
        $model->save();
        // $result['template'] = EmailController::sendEmail("emails.prueba", [],[]);


        return $result;

    }
    /***/
    public function CloseOrder(Request $req)
    {
        $result['success'] = "Registro guardado con éxito!";
        $result['action'] = "new";
        $model = Order::findOrFail($req->id);
        $model->final_id=
            "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
            ."-a".sizeof($model->attachments()->get());
        $model->save();
        // $result['template'] = EmailController::sendEmail("emails.prueba", [],[]);


        return $result;

    }


    /** Elimina el registro de la base de datos7
     * @param $req el id del registro a borrar
     ***/
    public function delete(Request $req)
    {


        $model = new ProviderCondPay();
        $id = $req->input("id", 0);

        $items= $model->getItems()->get();
        for($i=0;$i<sizeof($items);$i++){
            $item= new ProviderCondPayItem();
            $item->destroy($items[$i]->id);

        }
        $model->destroy($id);


    }

    /**
     * setea toda la data del modelo
     **/
    private function setDocItem($model, Request $req){
        $model->ult_revision = Carbon::now();
        if($req->has('monto')){
            $model->monto = $req->monto;
        }
        if($req->has('tasa')){
            $model->tasa = $req->tasa;
        }
        if($req->has('direccion_facturacion_id')){
            $model->direccion_facturacion_id = $req->tasa;
        }


        if($req->has('prov_id')){
            $model->prov_id = $req->prov_id;
        }
        if($req->has('monto')){
            $model->monto = $req->monto;
        }
        if($req->has('tasa')){
            $model->tasa = $req->tasa;
        }
        if($req->has('pais_id')){
            $model->pais_id = $req->pais_id;
        }
        if($req->has('condicion_pago_id')){
            $model->condicion_pago_id = $req->condicion_pago_id;
        }
        if($req->has('prov_moneda_id')){
            $model->prov_moneda_id = $req->prov_moneda_id;
        }
        if($req->has('nro_proforma')){
            $model->nro_proforma = $req->nro_proforma;
        }
        if($req->has('nro_factura')){
            $model->nro_factura = $req->nro_factura;
        }
        if($req->has('comentario')){
            $model->comentario = $req->comentario;
        }
        if($req->has('estado_id')){
            $model->estado_id = $req->estado_id;
        }
        if($req->has('direccion_almacen_id')){
            $model->direccion_almacen_id = $req->direccion_almacen_id;
        }
        if($req->has('condicion_id')){
            $model->condicion_id = $req->condicion_id;
        }
        if($req->has('mt3')){
            $model->mt3 = $req->mt3;
        }
        if($req->has('peso')){
            $model->peso = $req->peso;
        }
        if($req->has('puerto_id')){
            $model->puerto_id = $req->puerto_id;
        }
        if($req->has('nro_doc')){
            $model->nro_doc = $req->nro_doc;
        }

        if($req->has('comentario_cancelacion','cancelacion')){
            $model->comentario_cancelacion = $req->comentario_cancelacion;
            $model->cancelacion = $req->cancelacion;
        }

        if($req->has('aprob_compras')){
            $model->aprob_compras = $req->aprob_compras;
        }

        if($req->has('aprob_gerencia')){
            $model->aprob_gerencia = $req->aprob_gerencia;
        }

        if($req->has('titulo')){
            $model->titulo = $req->titulo;
        }

        if($req->has('doc_parent_id')){
            $model->doc_parent_id = $req->doc_parent_id;
        }

        if($req->has('doc_parent_origen_id')){
            $model->doc_parent_id = $req->doc_parent_id;
        }

        return $model;

    }

    private function transferDataDoc($oldmodel, $newModel){
        $resul = array();
        //$newModel->final_id = $oldmodel->final_id;
        $newModel->nro_proforma = $oldmodel->nro_proforma;
        $newModel->nro_factura = $oldmodel->nro_factura;
        $newModel->img_proforma = $oldmodel->img_proforma;
        $newModel->img_punto_compra = $oldmodel->img_punto_compra;
        $newModel->img_abono = $oldmodel->img_abono;
        $newModel->monto = $oldmodel->monto;
        $newModel->comentario = $oldmodel->comentario;
        $newModel->prov_id = $oldmodel->prov_id;
        $newModel->pais_id = $oldmodel->tipo_id;
        $newModel->condicion_pago_id = $oldmodel->condicion_pago_id;
        $newModel->motivo_id = $oldmodel->motivo_id;
        $newModel->estado_id = $oldmodel->estado_id;
        $newModel->prov_moneda_id = $oldmodel->prov_moneda_id;
        $newModel->direccion_almacen_id = $oldmodel->direccion_almacen_id;
        $newModel->direccion_facturacion_id = $oldmodel->direccion_facturacion_id;
        $newModel->puerto_id = $oldmodel->puerto_id;
        $newModel->comentario_cancelacion = $oldmodel->comentario_cancelacion;
        $newModel->condicion_id = $oldmodel->condicion_id;
        $newModel->mt3 = $oldmodel->mt3;
        $newModel->peso = $oldmodel->peso;
        $newModel->fecha_aprob_compra = $oldmodel->fecha_aprob_compra;
        $newModel->fecha_aprob_gerencia = $oldmodel->fecha_aprob_gerencia;
        $newModel->aprob_compras = $oldmodel->aprob_compras;
        $newModel->aprob_gerencia = $oldmodel->aprob_gerencia;
        $newModel->culminacion = $oldmodel->culminacion;
        $newModel->nro_doc = $oldmodel->nro_doc;
        $newModel->tasa = $oldmodel->tasa;
        $newModel->version = $oldmodel->version;
        $newModel->titulo = $oldmodel->titulo;
        return $newModel;
    }

    private  function  transferItem($oldItem, $newItem){
        //$newItem->final_id =$oldItem->final_id;
        $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
        $newItem->doc_id =$oldItem->doc_id;
        $newItem->origen_item_id =$oldItem->origen_item_id;
        $newItem->doc_origen_id =$oldItem->doc_origen_id;
        $newItem->cantidad =$oldItem->cantidad;
        $newItem->saldo =$oldItem->saldo;
        $newItem->producto_id =$oldItem->producto_id;
        $newItem->descripcion =$oldItem->descripcion;

        return $newItem;

    }

    private function getFirstProducto($model){
        $aux = $model->replicate();

        $i =0;
        $traza= array();
        //dd($type);
        while(true || $i <5){
            if($aux->tipo_origen_id == 2 || $aux->tipo_origen_id == 3 || $aux->tipo_origen_id == 1){
                break;
            }
            $aux = $model->findOrFail($aux->origen_item_id);
            $i = $i +1;
            $traza[]= $aux;
        }

        return $aux;
    }

    private  function  transferAttachments($oldItem, $newItem){


    }

    private function getFinalId($model){
        return  "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
        ."-a".sizeof($model->attachments()->get());
    }

    private function generateProviderQuery($campo, $condicion){
        $q= "IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
            ." tbl_compra_orden where tbl_proveedor.id= prov_id and tbl_compra_orden.final_id <> null),0) "
            ." + "
            ."IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
            ." tbl_pedido where tbl_proveedor.id= prov_id and tbl_pedido.final_id <> null),0) "
             ." + "
             ."IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
             ." tbl_solicitud where tbl_proveedor.id= prov_id and tbl_solicitud.final_id <> null),0) "
             .""
        ;
        return $q;
    }


}
