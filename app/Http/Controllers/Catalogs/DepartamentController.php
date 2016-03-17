<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Sistema\Departament;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;


class DepartamentController extends BaseController
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

        return view('modules.catalogs.dep-form');

    }

    public function saveOrUpdate(Request $req)
    {

        //////////validation
        $validator = Validator::make($req->all(), [
            'nombre' => 'required',
            'descripcion' => 'required'

        ]);

        if ($validator->fails()) {
            return 'error en campos de formulario';

        } else {

            $model = new Departament();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->find($req->id);
            }

            $model->nombre = $req->nombre;
            $model->descripcion = $req->descripcion;
            $model->save(); ////edita/inserta aviso


        }
    }



    public function delete(Request $req){


        $model = new Departament();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
