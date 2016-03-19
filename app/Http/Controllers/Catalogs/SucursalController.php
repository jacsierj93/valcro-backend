<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\Sucursal;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class SucursalController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = Sucursal::all();

        return view('modules.catalogs.suc-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new Sucursal();

        if ($req->has('id')) {
            $datos = Sucursal::find($req->id);
        }


        return view('modules.catalogs.suc-form', ["data" => $datos]);

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'razon_social' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new Sucursal();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->find($req->id);
                $result["action"]="edit";
            }

            $model->nombre = $req->nombre;
            $model->razon_social = $req->razon_social;
            $model->telefono1 = $req->telefono1;
            $model->telefono2 = $req->telefono2;
            $model->direccion = $req->direccion;
            $model->save(); ////edita/inserta aviso


        }

        return response()->json($result); /// respuesta json

    }


    public function delete(Request $req)
    {

        $model = new Sucursal();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
