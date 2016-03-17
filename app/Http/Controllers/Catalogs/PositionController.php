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
            $datos = Position::find($req->id);
        }

        ////lista de departamentos
        $deps = Departament::lists('nombre', 'id')->all();


        return view('modules.catalogs.dep-form', ["data" => $datos, 'deps' => $deps]);

    }


    public function delete(Request $req)
    {

        $model = new Position();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }


}
