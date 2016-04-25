<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 02:31 PM
 */


namespace App\Http\Controllers\Purchases;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\Purchase\OrderType;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Purchase\Order;
use App\Models\Sistema\Purchase\OrderStatus;
use App\Models\Sistema\Purchase\OrderCondition;
use App\Models\Sistema\Purchase\OrderReason;
use App\Models\Sistema\ProviderAddress;
use App\Models\Sistema\Purchase\PriorityOrders;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;



class OrderController  extends BaseController{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getListForm()
    {

        $provedores = Proveedor::lists('razon_social', 'id')->all();

        return view('modules.catalogs.order-list', ['provedores' => $provedores]);
    }

    /**
     * regresa la lista de pedidos segun id del provedor
    */
    public function getList(Request $req)
    {
        $orders= Proveedor::findOrFail($req->id)->getOrders()
            ->select('id','nro_doc','nro_proforma', 'emision', 'nro_factura', 'monto', 'tipo_pedido_id')
            ->get();
        $i=0;
        foreach($orders as $aux){
            $orders[$i]['tipo']=OrderType::findOrFail($orders[$i]->tipo_pedido_id)->first()->tipo;
            $i++;
        }
        return $orders;

    }

    /**
     * carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new Order();
        $provedores = Proveedor::lists('razon_social', 'id')->all();
        $TypeOrders = OrderType::lists('tipo', 'id')->all();
        $OrderReason = OrderReason::lists('motivo', 'id')->all();
        $PriorityOrders = PriorityOrders::lists('descripcion', 'id')->all();
        $OrderCondition = OrderCondition::lists('nombre', 'id')->all();
        $OrderStatus = OrderStatus::lists('estado', 'id')->all();
        //
        if ($req->has('id')) {
            $datos = Order::findOrFail($req->id);
        }


        return view('modules.catalogs.order-form',
            ["data" => $datos,
                'provedores' => $provedores,
                'tipoPedido' => $TypeOrders,
                'motivoPedido' => $OrderReason,
                'PriorityOrders' => $PriorityOrders,
                'OrderCondition' => $OrderCondition,
                'OrderStatus' => $OrderStatus,
            ]);

    }

    /**
     * Obtiene las ordenes de compra de un provedor
     ***/
    public function getProviderOrder(Request $req){
        $model = new PurchaseOrder();
        $data = $model->where('prov_id',$req->id)->
            where('pedido_id',null)
                ->get();
        $i=0;
        foreach( $data as $aux){
            $data[$i]['size']= $aux->getItems()->count();
            $i++;
        }
        return $data;
    }
    /**
     * Obtiene las ordenes de compra de un provedor
     ***/
    public function getPurchaseOrder(Request $req){
        return PurchaseOrder::where('id',$req->id)->first();
    }

    /**
     * obtiene los paises en que un provedor tiene
     * almacen
     **/
    public function getProviderCountry(Request $req){
        $model=  ProviderAddress::where('prov_id',$req->id)->get();
        $data= Array();
        $i=0;
        foreach( $model as $aux){
            $data[$i]['id']= $aux->getPais()->first()->id;
            $data[$i]['pais']= $aux->getPais()->first()->short_name;
            $i++;
        }

        return $data;
    }

    /**
     * Las getProviderCoin de un proveedro
     * @see
     **/
    public function getProviderCoins(Request $req){
        $model=  Proveedor::findOrFail($req->id);
        return $model->getProviderCoin()->get();
    }
    /**
     * Condiciones de pago de un proveedor
     **/
    public function getProviderPaymentCondition(Request $req){
        $model=  Proveedor::findOrFail($req->id);
        return $model->getPaymentCondition()->get();
    }

    /**
     * obtiene las direcioness de almacen del proveedor
     **/
    public function getProviderAdressStore(Request $req){
        $data = Proveedor::findOrFail($req->id)->getAddress();

        if ($req->has('pais_id')) {
            $data->where('pais_id', $req->pais_id);
        }

        return $data->get();

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
            'items' => 'required'
            //    'nro_doc' =>'required|min 20'
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
            $model->nro_proforma = $req->nro_proforma;
            $model->nro_factura = $req->nro_factura;
            $model->monto = $req->monto;
            $model->comentario = $req->comentario;
            $model->prov_id = $req->prov_id;
            $model->pais_id = $req->pais_id;
            $model->prioridad_id = $req->prioridad_id;
            $model->pedido_estado_id = $req->pedido_estado_id;
            $model->prov_moneda_id = $req->prov_moneda_id;
            $model->direccion_almacen_id = $req->direccion_almacen_id;
            $model->condicion_pedido_id = $req->condicion_pedido_id;
            $model->motivo_pedido_id = $req->motivo_pedido_id;
            $model->mt3 = $req->mt3;
            $model->peso = $req->peso;
            $model->nro_doc = $req->nro_doc;


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

            for($i=0;$i<sizeof($req->items);$i++){

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
            }

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