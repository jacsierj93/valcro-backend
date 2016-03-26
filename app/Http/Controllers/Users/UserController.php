<?php

namespace App\Http\Controllers\Users;

use App\Models\Sistema\Country;
use App\Models\Sistema\CountryLang;
use App\Models\Sistema\Position;
use App\Models\Sistema\Sucursal;
use App\Models\Sistema\User;
use App\Models\Sistema\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
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
        Session::put('UserId',0); ///vacio la variable de sesion si es insertar nuevo


        if ($req->has('id')) {
            $datos = User::findOrFail($req->id);
            Session::put('UserId',$req->id); ///si es editar un usuario
        }

        $cargos = Position::lists('nombre', 'id')->all();
        $niveles = UserLevel::lists('nombre', 'id')->all();
        $paises = Country::lists('short_name', 'id')->all();
        $sucursales = Sucursal::lists('nombre', 'id')->all();
        $lenguajes = CountryLang::lists('iso_lang', 'id')->all();
        $tipos = array("OFICINA" => "OFICINA", "MOVIL" => "MOVIL", "HOGAR" => "HOGAR");

        return view('modules.users.users-form', ["data" => $datos,
            "cargos" => $cargos, "niveles" => $niveles,
            "paises" => $paises, "lenguajes" => $lenguajes,
            "sucursales" => $sucursales, "tipos" => $tipos]);

    }

    public function saveOrUpdate(Request $req)
    {


        $userId = Session::get('UserId',0); ///en el caso de que no este creado el usuario

        if ($req->part == 1) { ////datos basicos

            //////////validation
            $validar = [
                'nombre' => 'required',
                'apellido' => 'required',
                'email' => 'required',
                'cargo_id' => 'required'

            ];

        }else{ ///datos de acceso

            //////////validation
            $validar = [
                'user' => 'required',
                'password' => 'required',
                'nivel_id' => 'required',

            ];

        }


        $validator = Validator::make($req->all(),$validar);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito", "action" => "new");

            $model = new User();


            if($userId){
                $model = User::findOrFail($userId);
            }

            if ($req->part == 1) { ////datos basicos

                $model->nombre = $req->nombre;
                $model->apellido = $req->apellido;
                $model->email = $req->email;
                $model->cargo_id = $req->cargo_id;
                $model->responsabilidades = $req->responsabilidades;
                $model->save(); ////edita/inserta


            } else { ///datos de acceso

                $model->user = $req->user;
                $model->password = Hash::make($req->password); ///hashing
                $model->nivel_id = $req->nivel_id;
                $model->status = ($req->has('status'))?1:0; ///estatus
                $model->save(); ////edita/inserta

            }

            /////se creo un usuario nuevo
            if(!$userId){
                Session::put('UserId',$model->id);
            }


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