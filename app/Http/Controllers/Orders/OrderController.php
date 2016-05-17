<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Masters\MasterOrderController;
use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\CustomOrders\CustomOrderItem;
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
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Product;
use App\Models\Sistema\Provider;
use App\Models\Sistema\ProviderAddress;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\Purchase\PurchaseOrder;
use DB;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;

//OrderItem


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
     * @deprecated
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

        foreach( $items as $aux ){
            $it=$aux;
            $it->tipo_origen_id='2';
            $it= MasterOrderController::getQuantityAvailableProduct($aux,$req->pedido_id);
            $it->tipo_origen_id=$aux->tipo_origen_id;
            $prods[] =$it;

        }

        $model['productos']=$prods;

        return $model;
    }

    public  function addCustomOrderItem(Request $req){

        $item = new OrderItem();
        if($req->has('renglon_id')){
            $item = OrderItem:: findOrFail($req->renglon_id);
        }
        $item->tipo_origen_id = 2;
        $item->pedido_id =  $req->pedido_id;
        $item->doc_origen_id =  $req->doc_origen_id;
        $item->origen_item_id = $req->id;
        $item->descripcion = $req->descripcion;
        $item->cantidad = $req->monto;
        $item->save();
        return $item;

    }

    public  function removeCustomOrderItem(Request $req){
        $item = OrderItem:: findOrFail($req->id);
        $item->destroy($item->id);

    }
    /**
     * revisar por intergar al maestro de Order
     * obtiene los contra pedidos de un proveedor
     */
    public function getCustomOrders(Request $req){

        $data = Array();
        $items = CustomOrder::
        where('aprobada','1')
            ->where('prov_id',$req->prov_id)
            ->get();

        foreach( $items as $aux ){
            $item=$aux;
            $CItems= $aux->CustomOrderItem()->get();

            foreach( $CItems as $aux2 ){

                $reng =null;
                $reng = OrderItem::
                where('tipo_origen_id',2)
                    ->where('origen_item_id',$aux2->id)->get();

                if( sizeof($reng) <= 0){
                    $data[]= $item;
                }
                else {
                    $item['asignado']=false;
                    $item['renglen_id']=null;
                    $sum=0.0;
                    foreach( $reng as $aux3 )
                    {
                        if($aux3->pedido_id == $req->pedido_id){
                            $item['asignado']=true;
                            $item['renglen_id']= $aux3->id;
                            $data[]= $item;
                            break 2;
                        }else{
                            $sum+=$aux3->cantidad;
                        }
                    }
                    if($sum <$aux2->cantidad){
                        $data[]= $item;
                    }

                }
            }

        }
        return $data;
    }

    /**
     * asigna la orden de compra a un pedido
     *
     **/
    public function addCustomOrder(Request $req){

        $model= CustomOrder::findOrFail($req->id);

        $model->CustomOrderItem()->get();
        $items= Array();
        foreach(  $model->CustomOrderItem()->get() as $aux){
            $it=$aux;
            $it->tipo_origen_id='2';
            $it= MasterOrderController::getQuantityAvailableProduct($aux,$req->pedido_id);
            $it->tipo_origen_id=$aux->tipo_origen_id;
            $items[]=$it;
            if($it['asignado']){
                $orI= OrderItem::findOrFail($it['renglon_id']);
                $orI=$it['disponible'];
                $orI->save();
            }else{
                $item = new OrderItem();
                $item->tipo_origen_id = 2;
                $item->pedido_id =  $req->pedido_id;
                $item->doc_origen_id =  $aux->doc_origen_id;
                $item->origen_item_id = $aux->id;
                $item->descripcion = $aux->descripcion;
                $item->cantidad = $it['disponible'];
                $item->save();
            }
        }
        return $items;


        /*
        foreach(  $model->CustomOrderItem()->get() as $aux){
            $item = new OrderItem();
            $item->pedido_id=$req->pedido_id;
            $item->producto_id=$aux->id;
            $item->pedido_tipo_origen_id='4';// 4 es contra pedido
            $item->origen_id=$req->id;
            $item->save();
        }*/
    }

    /**
     * elimina los renglones de un contra pedido
     **/
    public function RemoveCustomOrder(Request $req){
        $model = OrderItem::where('doc_origen_id', $req->id)
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

        $data = Array();
        $items = KitchenBox::
       where('prov_id',$req->prov_id)
            ->where('precio_bs','<>',0)
            ->whereNotNull('img_conf_gerente')
            ->whereNotNull('fecha_conf_gerente')
            ->get();

        foreach($items as $aux){
            $it=$aux;
            $it->tipo_origen='2';
            $it= MasterOrderController::getAvailableProduct($it, $req->pedido_id);
            $it->tipo_origen=$aux->tipo_origen;
            if(!$it['asignado']){
                $data[]=$it;
            }
        }
        return $data;
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

        $order=Order::findOrFail($req->id);
        $data= $order;
        $items= $order->OrderItem()->get();

        $contra=Array();
        foreach($items->where('tipo_origen_id', '2') as $aux){

            $contra[]= CustomOrder::find($aux->doc_origen_id);
            // $data['contraPedido'][] =
        }



        $data['contraPedido'] = $contra;
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
