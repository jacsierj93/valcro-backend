<?php

namespace App\Http\Controllers\Orders;

use App\Models\Sistema\CustomOrders\CustomOrderItem;
use App\Models\Sistema\KitchenBoxs\KitchenBox;
use App\Models\Sistema\Provider;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\Product;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\Order\OrderType;//OrderItem
use App\Models\Sistema\Order\OrderItem;
use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\CustomOrders\CustomOrderReason;
use App\Models\Sistema\CustomOrders\CustomOrderPriority;
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
use DB;


class OrderController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getProviderList()
    {

        // $data = Provider::skip(10)->take(5)->get();
        $data = Provider::where('id','1')->get();
        $i=0;
        foreach($data as $aux){
            $data[$i]['deuda']= $aux->Order()->sum('monto');
            // $data[$i]['pedidos']= $aux->getOrders()->count();
            $data[$i]['contraPedido']= $aux->CustomOrder()->count();

            $i++;
        }


        return $data;
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
     * regresa la lista de pedidos segun id del provedor
     */
    public function getProviderListOrder(Request $req)
    {
        $data=Array();

        $prov=Provider::findOrFail($req->id);
        $orders= Provider::findOrFail($req->id)->Order()
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
        $data['tipoDepago'] = PaymentType::select('nombre', 'id')->where("deleted_at",NULL)->get();
        return $data;

    }

    /*********************************** PEDIDOS A SUSTITUIR ***********************************/
    /**
     * obtiene todos los pedido que son sustituibles
     **/

    public function getOrderSubstituteOrder(Request $req){
        $model =Order::
        select(DB::raw("id , nro_proforma, emision , nro_factura, monto, comentario, "
            ." (select count(*) from tbl_pedido_item where deleted_at is null and pedido_id= "
            .$req->pedido_id
            ." and pedido_tipo_origen_id = 3 and origen_id = tbl_pedido.id "
            .") as asignado "
        ));
        $model->where('prov_id',$req->prov_id);
        $model->where('id','<>',$req->pedido_id);

        return $model->get();
    }
    /**
     * obtiene las ordenes de compra de un pedido
     */
    public function getOrdenPurchaseOrder(Request $req){
        return Order::findOrFail($req->id)->item()->where('pedido_tipo_origen_id',1);
    }


    /***********************************Contra pedidos ***********************************/

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
        $prods= Array();
        $items =$model->CustomOrderItem()->get();

        foreach( $items as $aux){
            $it['contraPItem'] = $aux;
            $reng=OrderItem::where('producto_id', $aux->id)
                ->where('tipo_origen_id', '2')
                ->where('origen_id', $aux->contra_pedido_id)->first();
            $it['pedidoItem']= $reng;
            $it['disponible']=$aux->cantidad;

            if($reng != null){

                $it['disponible']= $aux->cantidad - $reng->cantidad;
            }

            $prods[]=$it;
        }

        $model['productos']=$prods;

        return $model;
    }

    /**
     * obtiene un contra pedido con sus productos
     */
    public function getCustomOrderItem(Request $req){

        $model=CustomOrder:: findOrFail($req->id);
        $prods= Array();
        $items =$model->CustomOrderItem()->get();

        foreach( $items as $aux){
            $it['contraPItem'] = $aux;
            $reng=OrderItem::where('producto_id', $aux->id)
                ->where('tipo_origen_id', '2')
                ->where('origen_id', $aux->contra_pedido_id)->first();
            $it['pedidoItem']= $reng;
            $it['monto']=$aux->cantidad;

            if($reng != null){

                $it['monto']= $aux->cantidad - $reng->cantidad;
            }

            $prods[]=$it;
        }

        $model['productos']=$prods;

        return $model;
    }

    public  function addCustomOrderItem(Request $req){

        return $req;
    }
    /**
     * obtiene los contra pedidos de un proveedor
     */
    public function getCustomOrders(Request $req){

        $model =CustomOrder::
        select(DB::raw("tbl_contra_pedido.id ,
        fecha, comentario , monto, titulo, fecha_aprox_entrega, tbl_contra_pedido.aprobada , "
            ." (select count(*) from tbl_pedido_item where deleted_at is null
            and tipo_origen_id = 2 and origen_id= tbl_contra_pedido.id"
            .") as asignado"
        ))
            ->leftJoin('tbl_pedido_item','tbl_contra_pedido.id','=','tbl_pedido_item.origen_id')
            ->where('aprobada','1')
            ->where('prov_id',$req->prov_id)
            ->Where(function($query) use ($req)
            {
                $query->where('tbl_pedido_item.pedido_id',null)
                    ->Orwhere('tbl_pedido_item.pedido_id',$req->pedido_id)
                ;

            })
            ->get();

        $data = $model->filter(function ($item) use ($req){
            if($item->asignado > 0){
                if($item->pedido_id != $req->pedido_id){
                    return false;
                }
            }
            return true;
        });
        return array_values($data->toArray());
    }

    /**
     * asigna la orden de compra a un pedido
     *
     **/
    public function addCustomOrder(Request $req){

        $model= CustomOrder::findOrFail($req->id);

        $model->CustomOrderItem()->get();
        foreach(  $model->CustomOrderItem()->get() as $aux){
            $item = new OrderItem();
            $item->pedido_id=$req->pedido_id;
            $item->producto_id=$aux->id;
            $item->pedido_tipo_origen_id='4';// 4 es contra pedido
            $item->origen_id=$req->id;
            $item->save();
        }
    }

    /**
     * elimina los renglones de un contra pedido
     **/
    public function RemoveCustomOrder(Request $req){
        $model = OrderItem::where('origen_id', $req->id)
            ->where('pedido_id',$req->pedido_id)
            ->get();
        foreach(  $model as $aux){
            $aux->destroy($aux->id);
        }

    }

    /*********************************** kitchen box (cocinas)*********************************************/


    public function getKitchenBox($id){
        $model=KitchenBox:: findOrFail($id);
        return $model;
    }
    /**
     * falta incluir a algortimo que determina si esta aprobado o no
     * obtiene los kitchen box de un proveedor
     */
    public function getKitchenBoxs(Request $req){

        $model =KitchenBox::
        select(DB::raw("tbl_kitchen_box.id , fecha, nro_proforma , img_proforma, monto, precio_bs, fecha_aprox_entrega,
        tbl_pedido_item.pedido_id as pedidoIdentifi,
        tbl_pedido_item.origen_id, tbl_pedido_item.pedido_id ,"
            ." ( select count(*) from tbl_pedido_item where deleted_at is null
        and pedido_tipo_origen_id = 3 and tbl_pedido_item.origen_id= tbl_kitchen_box.id"
            .") as asignado"
        ))
            ->distinct()
            ->leftJoin('tbl_pedido_item','tbl_kitchen_box.id','=','tbl_pedido_item.origen_id')
            // ->where('aprobada','1')
            ->where('prov_id',$req->prov_id)
            ->get();
        $data = $model->filter(function ($item) use ($req){
            if($item->asignado > 0){
                if($item->pedido_id != $req->pedido_id){
                    return false;
                }
            }
            return true;
        });
        return array_values($data->toArray());
    }


    /**
     * asigna un kitchenbox a un pedido
     **/
    public function addkitchenBox(Request $req){


        $k= kitchenBox::findOrFail($req->id);
        $item = new OrderItem();
        $item->pedido_id=$req->pedido_id;
        $item->producto_id=$k->id;/// reemplazr cuando se sepa la logica
        $item->pedido_tipo_origen_id='2';
        $item->origen_id=$req->id;
        $item->save();
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBox(Request $req){

        $model = OrderItem::where('origen_id', $req->id)
            ->where('pedido_id',$req->pedido_id)
            ->get();
        foreach(  $model as $aux){
            $aux->destroy($aux->id);
        }
    }




    /**
     * obtiene toda la data de un pedido
     */

    public function getOrden(Request $req){
        $data=Order::findOrFail($req->id);
        $data['contraPedido'] = $data->getCustomOrder();
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
     * asigna la orden de compra a un pedido
     **/
    public function addPurchaseOrder(Request $req){

        $odc= PurchaseOrder::findOrFail($req->id);

        foreach(  $odc->PurchaseOrderItem()->get() as $aux){
            $item = new OrderItem();
            $item->pedido_id=$req->pedido_id;
            $item->producto_id=$aux->id;
            $item->pedido_tipo_origen_id='1';
            $item->origen_id=$req->id;
            $item->save();
        }

    }

    /**
     * elimina la orden de compra de un pedido
     **/
    public function RemovePurchaseOrder(Request $req){
        $model = OrderItem::where('origen_id', $req->id)
            ->where('pedido_id',$req->pedido_id)
            ->get();
        foreach(  $model as $aux){
            $aux->destroy($aux->id);
        }
    }



    /***************** Pedidos a sustituir ***************************/


    /**
     *      * id  siempre va a ser del articulo a

     * asigna un pedido a un nuevo pedido
     **/
    public function addOrderSubstitute(Request $req){

        $oldPed= Order:: findOrFail($req->id);// se destruye la orden anterior
        $newPed= Order:: findOrFail($req->pedido_id);// se destruye la orden anterior

        $orSus = new OrderItem();
        $orSus->pedido_id=$req->pedido_id;
        $orSus->producto_id = $req->id;
        $orSus->pedido_tipo_origen_id = '3';
        $orSus->origen_id = $req->pedido_id;
        $orSus->save();

        $items = OrderItem::where('pedido_id',$req->id)->get();// los item a asignar al pedidos

        // se mueven los item a el nuevo pedido
        foreach( $items as $aux){
            $item = new OrderItem();
            $item->pedido_id = $req->pedido_id;
            $item->producto_id = $aux->producto_id;
            $item->pedido_tipo_origen_id = $aux->pedido_tipo_origen_id;
            $item->origen_id = $aux->origen_id;
            $item->save();
            $aux->destroy($aux->id); // se destruyen los iten anteriores
        }

        $newPed->parent=$oldPed->id;
        $newPed->save();
        Order::destroy($oldPed->id);// se detruye el anteri

        /* $model = Order::where($req->id);// buscamos el pedido a asignar


         foreach(  $model->OrderItem()->get() as $aux){
             $item = new OrderItem();
             $item->pedido_id = $req->pedido_id;
             $item->producto_id = $aux->producto_id;
             $item->pedido_tipo_origen_id = $aux->pedido_tipo_origen_id;
             $item->origen_id = $aux->pedido_tipo_origen_id;
             $item->save();
         }*/


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

        //  $parent=Order::select('parent')->where('id',$model->producto_id);// id del pedido se guarda aqui
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
        if($req->has('id')){
            return ProviderAddress::where('pais_id',$req->id)->get();
        }
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
