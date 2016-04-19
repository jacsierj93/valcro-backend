<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 02:31 PM
 */


namespace App\Http\Controllers\Purchases;
use App\Models\Sistema\Proveedor;
use App\Models\Sistema\Purchase\TypeOrders;
use App\Models\Sistema\Purchase\PurchaseOrder;
use App\Models\Sistema\Purchase\Order;
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

    public function getList()
    {

        $provedores = Proveedor::lists('razon_social', 'id')->all();

        return view('modules.catalogs.order-list', ['provedores' => $provedores]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new Order();
        $provedores = Proveedor::lists('razon_social', 'id')->all();
        $TypeOrders = TypeOrders::lists('tipo', 'id')->all();
        $OrderReason = OrderReason::lists('motivo', 'id')->all();
        $PriorityOrders = PriorityOrders::lists('descripcion', 'id')->all();
        $OrderCondition = OrderCondition::lists('nombre', 'id')->all();
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
            ]);

    }


    public function getProviderOrder(Request $req){
        $model = new PurchaseOrder();
        $data = $model->where('prov_id',$req->id)->get();
        $i=0;
        foreach( $data as $aux){
            $data[$i]['size']= $aux->getItems()->count();
            $i++;
        }
        return $data;
    }

    public function getProviderAddresStore(Request $req){
        /*$model = new PurchaseOrder();
        $data = $model->where('prov_id',$req->id)->get();
        $i=0;
        foreach( $data as $aux){
            $data[$i]['size']= $aux->getItems()->count();
            $i++;
        }*/
        return null;
    }

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

    public function getProviderCoins(Request $req){
        $model=  Proveedor::findOrFail($req->id);
        return $model->monedas()->get();
    }


    /***
     * Guarda un registro en la bse de datos
     * @param $req la data del registro a guradar
     * @return json donde el primer valor representa 'error' en caso de q falle y
     * 'succes' si se realizo la accion
     ******/
    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'titulo' => 'required'
        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new ProviderCondPay();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }

            $model->titulo = $req->titulo;
            $model->save();

            for($i=0;$i<sizeof($req->items);$i++){
                $item= new ProviderCondPayItem();
                if(isset($req->items[$i]["id"])){
                    $item = $item->findOrFail(trim($req->items[$i]["id"]));
                    $result["action2"]="edit";
                }
                $item->id_condicion= $model->id;
                $item->porcentaje=trim($req->items[$i]["porcentaje"]);
                $item->dias= trim($req->items[$i]["dias"]);
                $item->descripcion=trim( $req->items[$i]["descripcion"]);
                $item->save();
            }

            if ($req->has("del")) {
                $result['data']="iset";
                for($i=0;$i<sizeof($req->del);$i++){
                    $item= new ProviderCondPayItem();
                    $item->destroy(trim($req->del[$i]));
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