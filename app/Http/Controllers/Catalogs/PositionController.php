<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\Departament;
use App\Models\Sistema\Position;
use Illuminate\Http\Request;
use Validator;
use Laravel\Lumen\Routing\Controller as BaseController;


class PositionController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = Position::all();

        return view('modules.catalogs.cargos-list', ['data' => $data]);
    }


    public function getForm(Request $req)
    {

        $datos = new Position();

        if ($req->has('id')) {
            $datos = Position::findOrFail($req->id);
        }

        ////lista de departamentos
        $deps = Departament::lists('nombre', 'id')->all();


        return view('modules.catalogs.cargos-form', ["data" => $datos, 'deps' => $deps]);

    }


    public function delete(Request $req)
    {

        $model = new Position();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }



    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'departamento_id' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new Position();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }

            $model->nombre = $req->nombre;
            $model->descripcion = $req->descripcion;
            $model->departamento_id =  $req->departamento_id;
            $model->save(); ////edita/inserta aviso


        }

        return response()->json($result); /// respuesta json

    }






}
