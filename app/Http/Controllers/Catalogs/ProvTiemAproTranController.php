<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\TiemAproTran;
use App\Models\Sistema\Country;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class ProvTiemAproTranController extends BaseController
{

    public function __construct()
    {

        $this->middleware('auth');
    }


    public function getList()
    {

        $data = TiemAproTran::all();


        return view('modules.catalogs.tiemAproTran-list', ['data' => $data]);
    }

    /**carga formulario
     * @param Request $req
     */
    public function getForm(Request $req)
    {

        $datos = new TiemAproTran();

        if ($req->has('id')) {
            $datos = TiemAproTran::findOrFail($req->id);
        }

        $paises = ['' => 'Seleccionar'] + Country::lists('short_name', 'id')->all();
        return view('modules.catalogs.tiemAproTran-form', ["data" => $datos, 'paises' => $paises]);

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'min_dia' => 'required',
            'max_dia' => 'required',
            'pais' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "Debe llenar todos Los campos del formulario ");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito","action"=>"new");

            $model = new TiemAproTran();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"]="edit";
            }

            $model->min_dia = $req->min_dia;
            $model->max_dia = $req->max_dia;
            $model->pais = $req->pais;
            $model->save(); ////edita/inserta aviso


        }

        return response()->json($result); /// respuesta json

    }


    public function delete(Request $req)
    {


        $model = new TiemAproTran();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
