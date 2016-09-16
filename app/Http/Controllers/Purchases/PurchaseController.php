<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 02:31 PM
 */


namespace App\Http\Controllers\Purchases;
use App\Models\Sistema\Purchase;
use App\Models\Sistema\Purchaseitem;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;





class PurchaseController  extends BaseController{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getList()
    {

        $data = Purchase::all();

        return view('modules.catalogs.purchase-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new ProviderCondPay();

        if ($req->has('id')) {
            $datos = ProviderCondPay::findOrFail($req->id);
        }


        return view('modules.catalogs.prov-pay-cond-form', ["data" => $datos]);

    }


    public function getItems(Request $req){
        $model = new ProviderCondPay();
        $model = $model->findOrFail($req->id);
        return $model->getItems()->get();
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