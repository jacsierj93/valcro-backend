<?php

namespace App\Http\Controllers\Orders;

use App\Models\Sistema\Provider;
use App\Models\Sistema\Monedas;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\Purchase\OrderType;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Purchase\Order;
use App\Models\Sistema\Purchase\OrderStatus;
use App\Models\Sistema\Purchase\OrderCondition;
use App\Models\Sistema\Purchase\OrderReason;
use App\Models\Sistema\ProviderAddress;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


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

        return $data;
    }

    /**
     * regresa la lista de pedidos segun id del provedor
     */
    public function getProviderListOrder(Request $req)
    {
        $orders= Provider::findOrFail($req->id)->getOrders()
         //   ->select('id','nro_doc','nro_proforma', 'emision', 'nro_factura', 'monto', 'tipo_pedido_id')
            ->get();
        $i=0;
        foreach($orders as $aux){
            $orders[$i]['tipo']=OrderType::findOrFail($orders[$i]->tipo_pedido_id)->first()->tipo;
            $i++;
        }
        return $orders;

    }
    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new Provider();

        if ($req->has('id')) {
            $datos = Departament::findOrFail($req->id);
        }


        return view('modules.catalogs.dep-form', ["data" => $datos]);

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'descripcion' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new Departament();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }

            $model->nombre = $req->nombre;
            $model->descripcion = $req->descripcion;
            $model->save(); ////edita/inserta aviso


        }

        return response()->json($result); /// respuesta json

    }

    public function delete(Request $req)
    {


        $model = new Departament();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
