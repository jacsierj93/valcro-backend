<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 5/11/2015
 * Time: 9:07 AM
 */
namespace App\Http\Controllers\Api;

use App\Libs\Api\RestApi;
use App\Models\Obra;
use App\Models\Sistema\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{


    public function info()
    {
        return phpinfo();
    }


    /**metodo que permite el acceso al sistema requiere el 'usuario' y 'password' de la persona
     * @param Request $request
     */
    public function login(Request $request)
    {

        $dataInput = $request->only('usr', 'pss');
        $resp = new RestApi();

        $usuarios = new User();
        $datos = $usuarios->where('user', $dataInput["usr"])->select("id", "nivel_id", "nombre", "apellido", "email", "password", "status")->first();

        //$datos = $usuarios->where('user', $dataInput["usr"])->first();

        ///////comparacion con el password de la base de datos
        if (Hash::check($dataInput['pss'], $datos["password"])) {
            // The passwords match...

            ////verificando que este activo
            if ($datos["status"] == 1) {


                /*    /////modulos a los que puede acceder
                                    $modulos = $datos->profile->moduleSelected()->get();
                                    foreach ($modulos as $mod)
                                        $mods[] = $mod->modulo_id;
                                    $datos["accesos"] = (isset($mods)) ? $mods : 0; ///trae los accesos sino 0
                                    ////////*/

                $dataUser = array("id" => $datos->id
                , "nombre" => $datos->nombre
                , "apellido" => $datos->apellido
                , "nivel" => $datos->nivel_id
                , "email" => $datos->email);


                $request->session()->put('DATAUSER', $dataUser); ///datos del usuario
                $resp->setContent($dataUser);

            } else {
                $resp->setError("El usuario se encuentra inactivo");
            }

        } else {
            ///it doesn't match
            $resp->setError("Usuario ó Clave inválidos");
        }

        return $resp->responseJson();

    }


    public function newPass($word)
    {
        return Hash::make($word);
    }


}