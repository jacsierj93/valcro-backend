<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\PurchasingDocumentType;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class PurchasingDocumentTypeController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = PurchasingDocumentType::all();

        return view('modules.catalogs.purschasing-doc-type-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new PurchasingDocumentType();

        if ($req->has('id')) {
            $datos = PurchasingDocumentType::findOrFail($req->id);
        }


        return view('modules.catalogs.purschasing-doc-type-form', ["data" => $datos]);

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'descripcion' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new PurchasingDocumentType();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }

            $model->descripcion = $req->descripcion;
            $model->save(); ////edita/inserta aviso


        }

        return response()->json($result); /// respuesta json

    }


    public function delete(Request $req)
    {


        $model = new PurchasingDocumentType();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
