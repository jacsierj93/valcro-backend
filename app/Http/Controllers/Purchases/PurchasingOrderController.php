<?php

namespace App\Http\Controllers\Purchases;

use App\Models\Sistema\Purchase\OrderReason;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Purchase\PurchaseOrderItem;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\ProviderAddress;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;




class PurchasingOrderController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = PurchaseOrder::where('aprovada',0)->get();

        return view('modules.catalogs.purchasing-order-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new PurchaseOrder();

        $provedores = Proveedor::lists('razon_social', 'id')->all();
        $reason = OrderReason::lists('motivo', 'id')->all();

        if ($req->has('id')) {
            $datos = PurchaseOrder::findOrFail($req->id);
        }

        return view('modules.catalogs.purchasing-order-form', ["data" => $datos, "provedores" => $provedores ,
            "reason" => $reason ]);

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'motivo_id' => 'required',
            'nro_orden'=>'required'
        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");
            $model = new PurchaseOrder();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";

            }

            $model->direccion_id = $req->direccion_id;
            $model->aprovada = $req->aprovada;
            $model->nro_orden = $req->nro_orden;
            $model->prov_id = $req->prov_id;
            $model->motivo_id = $req->motivo_id;
            $model->comentario = $req->comentario;
            $model->save();

            if ($req->has('items')) {
                for($i=0;$i<sizeof($req->items);$i++){
                    $item= new PurchaseOrderItem();
                    if(isset($req->items[$i]["id"])){
                        $item = $item->findOrFail(trim($req->items[$i]["id"]));
                        $result["action2"]="edit";
                    }
                    $item->compra_orden_id= $model->id;
                    $item->producto_id= trim($req->items[$i]["producto_id"]);
                    $item->cantidad= trim($req->items[$i]["cantidad"]);
                    $item->unidad= trim($req->items[$i]["unidad"]);
                    $item->save();
                }
            }


            if ($req->has("del")) {
                $result['data']="iset";
                for($i=0;$i<sizeof($req->del);$i++){
                    $item= new PurchaseOrderItem();
                    $item->destroy(trim($req->del[$i]));
                }
            }


        }

        return response()->json($result); /// respuesta json

    }


    /**
     * obtiene los producto de  proveedor
     **/
    public function getProviderProduct(Request $req){
        $model = new Proveedor();
        //////////condicion para editar
        if ($req->has('id')) {
            $model = $model->findOrFail($req->id);
        }
        return $model->proveedor_product()->get();
    }


    /**
     * obtiene las direcioness de almacen del proveedor
     **/
    public function getProviderAlmacenDir(Request $req){
        $model = new Proveedor();
        //////////condicion para editar
        if ($req->has('id')) {
            $model = $model->findOrFail($req->id);
        }
        return $model->getAddress()->where('tipo_dir', 1)->get();

    }

    public function delete(Request $req)
    {


        $model = new PurchaseOrder();
        $id = $req->input("id", 0);
        $items= $model->getItems()->get();
        for($i=0;$i<sizeof($items);$i++){
            $item= new PurchaseOrderItem();
            $item->destroy($items[$i]->id);
        }
        $model->destroy($id);


    }


}
