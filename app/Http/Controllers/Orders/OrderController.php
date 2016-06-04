<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Masters\MasterOrderController;
use App\Models\Sistema\Country;
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
use App\Models\Sistema\Payments\DocumentCP;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Product;
use App\Models\Sistema\Provider;
use App\Models\Sistema\ProviderAddress;
use App\Models\Sistema\ProviderCondPayItem;
use App\Models\Sistema\ProvTipoEnvio;
use App\Models\Sistema\Purchase\Purchase;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Solicitude\Solicitude;
use DB;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * obtiene la lista de proveedores
     */
    public function getProviderList()
    {

        $provs = Provider::
        //where('id', 1)->
        /*            Orderby('razon_social')->
                skip(0)->take(20)->*/


        get();
        $data = array();
        //  $auxCp= Collection::make(array());

        foreach($provs as $prv){
            $paso= false;
            if(sizeof($prv->getCountry())>0){
                $paso= true;
            }
            if($paso){
                $temp["id"] = $prv->id;
                $temp["razon_social"] = $prv->razon_social;
                $temp['deuda']= $prv->Order()->sum('monto');
                $temp['productos']= $prv->proveedor_product()->get();
                $temp['paises'] = $prv->getCountry();

                $temp['puntoCompra']= 0;
                $nCp=0;
                $nE0=0;
                $nE7=0;
                $nE30=0;
                $nE60=0;
                $nE90=0;
                $nE100=0;

                $peds=$prv->getOrderDocuments();

                foreach($peds as $ped){
                    $arrival=$ped->daysCreate();
                    $nCp +=$ped->getNumItem(2);
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

                }

                $temp['emit0']=$nE0;
                $temp['emit7']=$nE7;
                $temp['emit30']=$nE30;
                $temp['emit60']=$nE60;
                $temp['emit90']=$nE90;
                $temp['emit100']=$nE100;
                $temp['contraPedido']= $nCp;

                $data[] =$temp;
            }

        }

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
     * regresa la lista de pedidos segun id del provedor
     */
    public function getProviderListOrder(Request $req)
    {
        $data=Array();
        $prov= Provider::findOrFail($req->id);
        $items = $prov->getOrderDocuments();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();

        /*        $paises= $this->getCountryProvider($req->id);*/
        $paises= Country::get();
        //dd($items);

        /* $almacen= ProviderAddress::get();*/
        foreach($items as $aux){
            //para maquinas
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
            $tem['tasa']=$aux->tasa;
            $tem['proveedor']=$prov->razon_social;
            $tem['documento']= $aux->type;
            $tem['diasEmit']=$aux->daysCreate();

            if($aux->motivo_id){
                $tem['motivo']=$motivo->where('id',$aux->motivo_id)->first()->motivo;
            }
            if($aux->pais_id){
                $tem['pais']=$paises->where('id',$aux->pais_id)->first()->short_name;
            }
            if($aux->estado_id){
                $tem['estado']=$estados->where('id',$aux->estado_id)->first()->estado;
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
            if($aux->tipo_pedido_id){
                $tem['tipo']=$type->where('id',$aux->tipo_pedido_id)->first()->tipo;
            }


            /*

            $tem['productos'] = $this->getProductoOrden($aux);
            $tem['diasEmit']=$aux->daysCreate();

            */


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
     * obtiene todos los pedido que son sustituibles
     **/

    public function getOrderSubstituteOrder(Request $req){
        $data= Array();
        $items =Order::where('prov_id',$req->prov_id)
            ->where('id','<>',$req->pedido_id)
            ->where('aprob_gerencia',1)
            ->get();

        foreach($items as $aux){
            if(sizeof($aux->OrderItem()->get() )> 0){
                $aux['asignado']=false;
                $auxAsig = null;
                $auxAsig=OrderItem::where('tipo_origen_id',4)
                    ->where('doc_origen_id', $aux->id)
                    //  ->where('pedido_id', $req->pedido_id)
                    ->first();
                if($auxAsig == null){
                    $data[]=$aux;
                }else{
                    if($auxAsig->pedido_id== $req->pedido_id){
                        $aux['asignado']=true;
                        $data[]=$aux;
                    }
                }

            }

        }
        return $data;
    }

    /**
     * obtine el pedido con sus item sin separar
     */
    public function getOrderSustitute(Request $req){

        $model= Order::findOrFail($req->id);
        $items= $model->OrderItem()->get();
        $products= Array();
        foreach($items as $aux){

            $aux['origen']=MasterOrderController::getTypeProduct($aux)['descripcion'];
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
        $prods= Array();
        $items =$model->CustomOrderItem()->get();
        $pedido=$req->pedido_id;
        if($req->has('renglon_id')){
            $pedido= OrderItem::findOrFail($req->renglon_id)->doc_origen_id;
        }
        foreach( $items as $aux ){
            $it=$aux;
            $it->tipo_origen_id='2';
            $it= MasterOrderController::getQuantityAvailableProduct($aux,$pedido);
            $it->tipo_origen_id=$aux->tipo_origen_id;
            $prods[] =$aux;
        }
        $model['productos']=$prods;

        return $model;
    }

    public  function addCustomOrderItem(Request $req){

        $cpIt= CustomOrderItem::findOrFail($req->id);
        $item = new OrderItem();
        if($req->has('renglon_id')){
            $item = OrderItem:: findOrFail($req->renglon_id);

        }else{
            $item->cantidad = $req->saldo;
        }
        $item->tipo_origen_id = 2;
        $item->pedido_id =  $req->pedido_id;
        $item->doc_origen_id =  $req->doc_origen_id;
        $item->origen_item_id = $req->id;
        $item->descripcion = $req->descripcion;
        $item->saldo = $req->saldo;

        if($req->saldo >= $req->cantidad){
            $cpIt->saldo=0;
        }else{
            $cpIt->saldo = $req->cantidad - $req->saldo;
        }
        $cpIt->save();
        $item->save();

        return $item;

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
        $OrdItems= Array();
        $CusItems= Array();

        foreach(  $model->CustomOrderItem()->get() as $aux){
            $item = new OrderItem();
            $exi=OrderItem::where('pedido_id', $req->pedido_id)
                ->where('origen_item_id',$aux->id)
                ->first();
            $item->tipo_origen_id = 2;
            $item->pedido_id =  $req->pedido_id;
            $item->doc_origen_id =  $aux->doc_origen_id;
            $item->origen_item_id = $aux->id;
            $item->descripcion = $aux->descripcion;
            $item->cantidad = $aux->saldo;
            $item->saldo = $aux->saldo;
            if($exi != null && $aux->tipo_origen_id != 3){
                $item->saldo += $aux->saldo;
                $item=$exi;
            }


            $resul['accion_ ori'][]=$aux->tipo_origen_id;
            if($aux->tipo_origen_id == 3){
                $item->cantidad = 1;
                $item->saldo = 1;
            }
            $aux->saldo=0;
            $OrdItems[]=$item;
            $CusItems[]=$aux;
        }
        $resul['accion']="full insert";
        $resul['newItem']=$OrdItems;
        $resul['response2']=Order::findOrFail($req->pedido_id)->OrderItem()->saveMany($OrdItems);
        $resul['response']=$model->CustomOrderItem()->saveMany($CusItems);
        return $resul;

    }

    /**
     * @deprecated
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
            $it->tipo_origen_id='3';
            $it= MasterOrderController::getAvailableProduct($it, $req->pedido_id);
            $it->tipo_origen_id=$aux->tipo_origen;
            if(!$it->asignado  ){
                $data[]=$it;
            }else{
                $ordI = OrderItem::findOrFail($it->renglon_id);
                if($ordI->pedido_id == $req->pedido_id){
                    $data[]=$it;
                }
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
        $item->origen_item_id=$k->id;/// reemplazr cuando se sepa la logica
        $item->tipo_origen_id='3';
        $item->doc_origen_id=$k->id;
        $item->cantidad=1;
        $item->saldo=1;
        $item->save();
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBox(Request $req){

        $model = OrderItem::where('origen_item_id', $req->id)
            ->where('pedido_id',$req->pedido_id)
            ->get();
        foreach(  $model as $aux){
            $aux->destroy($aux->id);
        }
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
        $tem['productos'] = $this->getProductoOrden($aux);
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
    private function getProductoOrden($order){

        $items= $order->OrderItem()->get();
        $contra=Collection::make(Array());
        $kitchen= Collection::make(Array());
        $pediSus= Collection::make(Array());
        $all= Collection::make(Array());

        /** contra pedido*/
        foreach($items->where('tipo_origen_id', '2') as $aux){
            $contra->push(CustomOrder::find($aux->doc_origen_id));
        }
        /** kitceh box*/
        foreach($items->where('tipo_origen_id', '3') as $aux){
            $kitchen->push(KitchenBox::find($aux->origen_item_id));
        }
        /** importados */
        foreach($items->where('tipo_origen_id', '4') as $aux){

            $id =MasterOrderController::getTypeProduct($aux)['tipo_origen_id'];
            $imp=MasterOrderController::getOriginalHead($aux);
            $aux['titulo']="transferido del ";
            $aux['renglon_id']= $aux->id;
            $aux->id=$imp->id;
            switch($id){
                case 2:
                    $contra->push($aux);
                    break;
                case 3:
                    $kitchen->push($aux);

                    break;
            }
            if(!$pediSus->contains($aux->doc_origen_id)){
                $pediSus[]=Order::find($aux->doc_origen_id);
            }

        }

        /** todos */
        foreach($items as $aux){
            $tem['id']= $aux->id;
            $tem['cantidad']= $aux->cantidad;
            $tem['saldo']= $aux->saldo;
            $tem['descripcion']= $aux->descripcion;
            $tem['tipo_origen_id']= $aux->tipo_origen_id;
            $tem['asignado']= true;
            $tem['origen']= MasterOrderController::getTypeProduct($aux)['descripcion'];
            $all->push($tem);
        }

        $data['contraPedido'] = $contra;
        $data['kitchenBox'] = $kitchen;
        $data['pedidoSusti'] = $pediSus;
        $data['todos'] = $all;
        return $data;
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
     * obtiene los direcciones de almacen
     * donde un proveeed
     * almacen
     **/
    public function getAddressCountry(Request $req){
        $data = array();
        if($req->has('id')){
            $data=ProviderAddress::where('pais_id',$req->id)->get();
            if($req->has('tipo_dir')){
                $data =$data->where('tipo_dir',$req->tipo_dir );
            }
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
                $model->getPaymentsDoc();





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

    /**
     * setea toda la data del modelo
     **/
    private function setDocItem($model, Request $req){

        if($req->has('monto')){
            $model->monto = $req->monto;
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

        if($req->has('tipo_id')){
            $model->tipo_id = $req->tipo_id;
        }
        if($req->has('prioridad_id')){
            $model->prioridad_id = $req->prioridad_id;
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
        /*
        if($req->has('motivo_id')){
             $model->motivo_id = $req->motivo_id;
         }
         if($req->has('prioridad_id')){
             $model->prioridad_id = $req->prioridad_id;
         }

        */
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


        return $model;

    }

}
