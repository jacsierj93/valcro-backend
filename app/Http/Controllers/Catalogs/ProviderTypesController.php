<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 28/03/16
 * Time: 02:31 PM
 */


namespace App\Http\Controllers\Catalogs;
use App\Models\Sistema\ProviderType;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;





class ProviderTypesController  extends BaseController{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getList()
    {

        $data = ProviderType::all();

        return view('modules.catalogs.prov-type-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new ProviderType();

        if ($req->has('id')) {
            $datos = ProviderType::findOrFail($req->id);
        }


        return view('modules.catalogs.prov-type-form', ["data" => $datos]);

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
            'nombre' => 'required',
            'descripcion' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new ProviderType();
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

    /** Elimina el registro de la base de datos7
     * @param $req el id del registro a borrar
     ***/
    public function delete(Request $req)
    {


        $model = new ProviderType();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }
}