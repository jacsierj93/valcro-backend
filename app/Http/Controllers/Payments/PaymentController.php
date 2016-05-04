<?php

namespace App\Http\Controllers\Payments;

use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Provider;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class PaymentController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = Departament::all();

        return view('modules.catalogs.dep-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new Departament();

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



    /////lista de proveedores
    
    public function getProvidersList(){
        $provs = Provider::all();
        return $provs;
    }


    public function getPaymentTypes(){
        $types = PaymentType::all();
        return $types;

    }
    

}
