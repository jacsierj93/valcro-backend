<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\ProvTipoEnvio;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class ProviderTypesSendController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = ProvTipoEnvio::all();

        return view('modules.catalogs.typesSend-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new ProvTipoEnvio();

        if ($req->has('id')) {
            $datos = ProvTipoEnvio::findOrFail($req->id);
        }


        return view('modules.catalogs.typesSend-form', ["data" => $datos]);

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'descripcion' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "Debe llenar todos Los campos del formulario ");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new ProvTipoEnvio();
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


        $model = new ProvTipoEnvio();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
