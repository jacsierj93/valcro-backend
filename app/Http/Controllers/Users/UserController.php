<?php

namespace App\Http\Controllers\Users;
use App\Models\Sistema\User;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class UserController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = User::all();

        return view('modules.users.users-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new User();

        if ($req->has('id')) {
            $datos = Departament::find($req->id);
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

            $model = new User();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->find($req->id);
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


        $model = new User();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
