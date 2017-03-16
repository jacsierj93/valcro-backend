<?php

namespace App\Http\Controllers\Users;

use App\Models\Sistema\Country;
use App\Models\Sistema\CountryLang;
use App\Models\Sistema\Position;
use App\Models\Sistema\Sucursal;
use App\Models\Sistema\User;
use App\Models\Sistema\UserLevel;
use App\Models\Sistema\UserPreference;
use App\Models\Sistema\Deparment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
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
        $prefs = new UserPreference();
        Session::put('UserId', 0); ///vacio la variable de sesion si es insertar nuevo


        if ($req->has('id')) {
            $datos = User::findOrFail($req->id);
            $prefs = UserPreference::where("usuario_id",$req->id)->first();
            if($prefs==null) $prefs = new UserPreference();

            Session::put('UserId', $req->id); ///si es editar un usuario
        }

        $cargos = Position::lists('nombre', 'id')->all();
        $niveles = UserLevel::lists('nombre', 'id')->all();
        $paises = ['' => 'Seleccionar'] + Country::lists('short_name', 'id')->all();
        $sucursales = ['' => 'Seleccionar'] + Sucursal::lists('nombre', 'id')->all();
        $lenguajes = ['' => 'Seleccionar'] + CountryLang::lists('iso_lang', 'id')->all();
        $tipos = array("OFICINA" => "OFICINA", "MOVIL" => "MOVIL", "HOGAR" => "HOGAR");

        return view('modules.users.users-form', ["data" => $datos,
            "prefs"=>$prefs,
            "cargos" => $cargos, "niveles" => $niveles,
            "paises" => $paises, "lenguajes" => $lenguajes,
            "sucursales" => $sucursales, "tipos" => $tipos]);

    }

    public function saveOrUpdate(Request $req)
    {


        $userId = Session::get('UserId', 0); ///en el caso de que no este creado el usuario

        if ($req->part == 1) { ////datos basicos

            //////////validation
            $validar = [
                'nombre' => 'required',
                'apellido' => 'required',
                'email' => 'required',
                'cargo_id' => 'required'

            ];

        } else { ///datos de acceso

            //////////validation
            $validar = [
                'user' => 'required',
                'password' => 'required',
                'nivel_id' => 'required',

            ];

        }


        $validator = Validator::make($req->all(), $validar);

        if ($validator->fails()) { ///ups... erorres

            $result = array("error" => "errores en campos de formulario");

        } else {  ///ok

            $result = array("success" => "Registro guardado con éxito", "action" => "new");

            $model = new User();


            if ($userId) {
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
                $model->status = ($req->has('status')) ? 1 : 0; ///estatus
                $model->save(); ////edita/inserta

            }

            /////se creo un usuario nuevo
            if (!$userId) {
                Session::put('UserId', $model->id);
            }


        }

        return response()->json($result); /// respuesta json

    }


    public function savePreferences(Request $req)
    {

        $userId = Session::get('UserId', 0); ///en el caso de que no este creado el usuario


        if ($userId) {

            $result = array("success" => "Registro guardado con éxito");


            $model = UserPreference::where("usuario_id", $userId)->first(); ///intenta buscarlo

            if($model==null) $model = new UserPreference();


            $model->usuario_id = $userId; ///id del usuario

            if ($req->has('pais_id')) {
                $model->pais_id = $req->pais_id;
            }

            if ($req->has('sucursal_id')) {
                $model->sucursal_id = $req->sucursal_id;
            }

            if ($req->has('idioma_id')) {
                $model->idioma_id = $req->idioma_id;
            }

            $model->save();

        } else {

            $result = array("error" => "no existe un usuario para asignar preferencias");

        }

        return response()->json($result); /// respuesta json

    }


    public function delete(Request $req)
    {

        $model = new User();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }
    
    public function getUsuarios() {
        $usuarios = User::select('id', 'nombre', 'apellido', 'user')->get();
        return $usuarios->toJson();
    }

    public function seltdUser($usr) {
        $usuarios = User::where('id', $usr)
                ->get(['id', 'nombre AS usr_nombre', 'apellido AS usr_apellido', 'user', 'password', 'admin', 'cargo_id AS crg_id', 'co_us', 'email', 'nivel_id AS nvl_id', 'responsabilidades', 'status', 'user']);
        /*$usuarios = User::where('tbl_usuario.id', $usr)
                    ->join('tbl_cargo', 'tbl_usuario.cargo_id', '=', 'tbl_cargo.id')
                    ->join('tbl_nivel', 'tbl_usuario.nivel_id', '=', 'tbl_nivel.id')
                    ->get(['tbl_usuario.id', 'tbl_usuario.nombre AS usr_nombre', 'tbl_usuario.apellido AS usr_apellido', 'user', 'admin', 'cargo_id AS crg_id', 'tbl_cargo.nombre AS crg_nombre', 'co_us', 'email', 'nivel_id AS nvl_id', 'tbl_nivel.nombre AS nvl_nombre', 'responsabilidades', 'status', 'user']);*/

 
        foreach ($usuarios as $usuario) {
            $usuario->password = "";
            $usuario[4] = "";
        }

        return $usuarios->toJson();
        //return $usuarios;

    }

    public function getCargos($ide) {
        if($ide == 0){
            $cargos = Position::select('id', 'nombre', 'descripcion')->get();
        }else{
            $cargos = Position::where('id', $ide)->get(['id', 'nombre', 'descripcion']);
        }
        return $cargos->toJson();
    }
    
    public function getNiveles($ide) {
        if($ide == 0){
            $niveles = UserLevel::select('id', 'nombre', 'descripcion')->get();
        }else{
            $niveles = UserLevel::where('id', $ide)->get(['id', 'nombre', 'descripcion']);
        }
        return $niveles->toJson();
    }

    public function getEstatus($ide) {
        $data = array(array("id" => 1, "nombre" => "Activo"), array("id" => 0, "nombre" => "Inactivo"));
        if ($ide == -1) {
            return json_encode($data);
        } else {
            foreach ($data as $clave => $valor) {
                if($valor["id"] == $ide){
                    $estatus = $valor;
                    return json_encode($estatus);
                }
            }
        }
    }
    
    public function saveUser(Request $req){
        $result = array("success" => "Registro guardado con éxito", "action" => "new","id"=>"");
        if($req->id){
            $user =  User::findOrFail($req->id);
            
            /*User::where('id', $req->id)->update([
                'nombre' => $req->usr_nombre,
                'apellido' => $req->usr_apellido,
                'user' => $req->user,
                'password' => Hash::make($req->password),
                'admin' => $req->admin,
                'cargo_id' => $req->crg_id,
                'co_us' => $req->co_us,
                'email' => $req->email,
                'nivel_id' => $req->nvl_id,
                'responsabilidades' => $req->responsabilidades,
                'status' => $req->status]);*/
            $result['action']="upd";
            $result['id']=$req->id;
        }else{
            $user =  new User();
            /*$id = User::insertGetId([
                'nombre' => $req->usr_nombre,
                'apellido' => $req->usr_apellido,
                'user' => $req->user,
                'password' => Hash::make($req->password),
                'admin' => $req->admin,
                'cargo_id' => $req->crg_id,
                'co_us' => $req->co_us,
                'email' => $req->email,
                'nivel_id' => $req->nvl_id,
                'responsabilidades' => $req->responsabilidades,
                'status' => $req->status]);
            $result['id']=$id;*/
        }

        
        $user->nombre = $req->usr_nombre;
        $user->apellido = $req->usr_apellido;
        $user->user = $req->user;
        $user->password = Hash::make($req->password); ///hashing
        $user->admin = $req->admin;
        $user->cargo_id = $req->crg_id;
        $user->co_us = $req->co_us;
        $user->email = $req->email;
        $user->nivel_id = $req->nvl_id;
        $user->responsabilidades = $req->responsabilidades;
        $user->status = $req->status;
        
        if($user->isDirty()){
            $user->save();
        }else{
            $result['action']="equal";
        }
        $result['id']=$user->id;

        return $result;
    }

}
