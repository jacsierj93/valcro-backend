<?php

namespace App\Http\Controllers\Orders;

use App\Models\Sistema\KitchenBoxs\KitchenBox;
use App\Models\Sistema\Provider;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\Product;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\Order\OrderType;
use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Order\Order;
use App\Models\Sistema\Order\OrderStatus;
use App\Models\Sistema\Order\OrderCondition;
use App\Models\Sistema\Order\OrderReason;
use App\Models\Sistema\Order\OrderPriority;
use App\Models\Sistema\ProviderAddress;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;
//CustomOrder

class OrderController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getProviderList()
    {

        // $data = Provider::skip(10)->take(5)->get();
        $data = Provider::where('id',1)->get();
        $i=0;
        foreach($data as $aux){
            $data[$i]['total']= $aux->getFullPaymentOrders();
            $i++;
        }


        return $data;
    }

    /***/
    public function getFilterData()
    {

        $data= Array();
        $data['monedas']= Monedas::select('nombre', 'id')->where("deleted_at",NULL)->get();
        $data['tipoEnvio']= ProvTipoEnvio::select('nombre', 'id')->where("deleted_at",NULL)->get();

        return $data;
    }

    /**
     * regresa la lista de pedidos segun id del provedor
     */
    public function getProviderListOrder(Request $req)
    {
        $data=Array();

        $prov=Provider::findOrFail($req->id);
        $orders= Provider::findOrFail($req->id)->getOrders()
            //   ->select('id','nro_doc','nro_proforma', 'emision', 'nro_factura', 'monto', 'tipo_pedido_id')
            ->get();
        $i=0;
        foreach($orders as $aux){
            $orders[$i]['tipo']=OrderType::findOrFail($orders[$i]->tipo_pedido_id)->first()->tipo;
            $i++;
        }
        $data['pedidos']=$orders;
        $data['proveedor']=$prov;

        return $data;

    }

    /**
     * carga formulario
     * @param Request $req
     */
    public function getForm()
    {

        $data= Array();
        /**maestros*/
        //$data['proveedor']= Provider::select('razon_social', 'id')->where("deleted_at",NULL)->get();
        $data['tipoPedido'] = OrderType::select('tipo', 'id')->where("deleted_at",NULL)->get();
        $data['motivoPedido']= OrderReason::select('motivo', 'id')->where("deleted_at",NULL)->get();
        $data['prioridadPedido'] = OrderPriority::select('descripcion', 'id')->where("deleted_at",NULL)->get();
        $data['condicionPedido'] = OrderCondition::select('nombre', 'id')->where("deleted_at",NULL)->get();
        $data['estadoPedido'] = OrderStatus::select('estado', 'id')->where("deleted_at",NULL)->get();
        $data['tipoDepago'] = PaymentType::select('descripcion', 'id')->where("deleted_at",NULL)->get();
        return $data;

    }

    /**
     * obtiene las ordenes de compra de un pedido
     */
    public function getOrdenPurchaseOrder(Request $req){
        return $ped = Order::findOrFail($req->id)->getOrders()->get();
    }

    /**
     * obtiene los contra pedidos de un proveedor
     */
    public function getCustomOrders(Request $req){
        $model =CustomOrder::where('prov_id',$req->prov_id);

        return $model->get();
    }

    /**
     * obtiene los kitchen box de un proveedor
     */
    public function getKitchenBoxs(Request $req){
        $model =KitchenBox::where('prov_id',$req->prov_id);

        return $model->get();
    }
    /**
     * obtiene las ordenes de compra de un pedido
     */

    public function getOrden(Request $req){
        $data=Order::findOrFail($req->id);
        $data['ordenes']= $data->getOrders()->get();
        return $data;
    }
    /**
     * Obtiene las ordenes de compra de un provedor
     ***/
    public function getProviderOrder(Request $req){
        $model = new PurchaseOrder();
        $data = $model->where('prov_id',$req->id)
            //->where(pedido_id,null)
            ->get();
        $i=0;
        foreach( $data as $aux){
            $data[$i]['size']= $aux->getItems()->count();
            $i++;
        }
        return $data;
    }

    public function addPurchaseOrder(Request $req){
        $model= PurchaseOrder::findOrFail($req->id);
        $model->pedido_id=$req->pedido_id;
        $model->save();
    }

    public function RemovePurchaseOrder(Request $req){
        $model= PurchaseOrder::findOrFail($req->id);
        $model->pedido_id=null;
        $model->save();
    }
    /**
     * Obtiene la orden de compra
     ***/
    public function getPurchaseOrder(Request $req){
        $model =PurchaseOrder::findOrFail($req->id);
        $products=Array();

        $i=0;
        foreach( $model->getItems()->get() as $aux){
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
        $model=  ProviderAddress::where('prov_id',$req->id)->get();
        $pais= Array();
        foreach( $model as $aux){
            $pais[]= $aux->country()->first();

        }
        return $pais;
    }

    /**
     * obtiene los direcciones de almacen
     * donde un proveeed
     * almacen
     **/
    public function getAddressCountry(Request $req){
        return ProviderAddress::where('pais_id',$req->id)->get();
    }

    /**
     * Las getProviderCoin de un proveedro
     * @see
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


    /***
     * Guarda un registro en la base de datos
     * @param $req la data del registro a guradar
     * @return json donde el primer valor representa 'error' en caso de q falle y
     * 'succes' si se realizo la accion
     ******/
    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'tipo_pedido_id' => 'required',
            'prov_id' => 'required',
            'pais_id' => 'required',
            'monto' => 'required',
            'prov_moneda_id' => 'required',
            'motivo_pedido_id' => 'required',
            'prioridad_id' => 'required',
            'condicion_pago_id' => 'required',
        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new Order();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }

            $model->tipo_pedido_id = $req->tipo_pedido_id;
            $model->prioridad_id = $req->prioridad_id;
            $model->prov_id = $req->prov_id;
            $model->pais_id = $req->pais_id;
            $model->monto = $req->monto;
            $model->condicion_pago_id = $req->condicion_pago_id;
            $model->prov_moneda_id = $req->prov_moneda_id;
            $model->motivo_pedido_id = $req->motivo_pedido_id;
            $model->prioridad_id = $req->prioridad_id;

            if($req->has('nro_proforma')){
                $model->nro_proforma = $req->nro_proforma;
            }
            if($req->has('nro_factura')){
                $model->nro_factura = $req->nro_factura;
            }
            if($req->has('comentario')){
                $model->comentario = $req->comentario;
            }
            if($req->has('pedido_estado_id')){
                $model->pedido_estado_id = $req->pedido_estado_id;
            }
            if($req->has('direccion_almacen_id')){
                $model->direccion_almacen_id = $req->direccion_almacen_id;
            }
            if($req->has('condicion_pedido_id')){
                $model->condicion_pedido_id = $req->condicion_pedido_id;
            }
            if($req->has('mt3')){
                $model->mt3 = $req->mt3;
            }
            if($req->has('peso')){
                $model->peso = $req->peso;
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

            if($req->has('tasa')){
                $model->tasa_fija=1;
                $model->tasa=$req->tasa;
            }else{
                $model->tasa_fija=0;
                $model->tasa=  Monedas::findOrFail($req->prov_moneda_id)->precio_usd;
            }
            $model->save();
            $result['pedido']=$model;
            /* for($i=0;$i<sizeof($req->items);$i++){

                 $item= PurchaseOrder::findOrFail(trim($req->items[$i]['id']));
                 $item->pedido_id=$model->id;
                 $item->save();
             }

             if ($req->has("del")) {
                 $result['data']="iset";
                 for($i=0;$i<sizeof($req->del);$i++){
                     $item= new ProviderCondPayItem();
                     // $item->destroy(trim($req->del[$i]));
                 }
             }*/

        }

        return response()->json($result); /// respuesta json

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

}
