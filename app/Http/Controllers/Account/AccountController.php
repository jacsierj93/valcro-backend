<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 5/11/2015
 * Time: 9:07 AM
 */
namespace App\Http\Controllers\Account;

use App\Libs\Api\RestApi;
use App\Models\Documento;
use App\Models\Obra;
use App\Models\Sistema\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;

class AccountController extends BaseController
{


    /**
     * the model instance
     * @var User
     */
    protected $session;

    /**
     * Create a new authentication controller instance.
     *
     * @param  Authenticator $auth
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth', ['except' => ['showLogin', 'doLogin']]);
        $this->middleware('guest', ['only' => ['showLogin', 'doLogin']]);
    }


    /**
     * muestra la vista de login
     */
    public function showLogin()
    {
        return view('login');
    }

    public function showUnauth()
    {
        return view("errors.unAuth");
    }

    /**muestra la pagina principal del admin
     * @return mixed
     */
    public function main()
    {

        return view("home");
    }


    /**
     * @param Request $request
     * @return mixed
     */
    public function doLogin(Request $request)
    {

        $dataInput = $request->only('email', 'password');
        $resp = new RestApi();

        $usuarios = new User();
        $datos = $usuarios->where('email', $dataInput["email"])->first();

        ///////comparacion con el password de labase de datos
        if (Hash::check($dataInput['password'], $datos["password"])) {
            // The passwords match...

            ////verificando que este activo
            if ($datos["estatus"] == 1) {
                $request->session()->put('DATAUSER', $datos); ///datos del usuario
                $resp->setContent($datos);

            } else {
                $resp->setError("El usuario se encuentra inactivo");
            }

        } else {
            ///it doesn't match
            $resp->setError("Usuario ó Clave inválidos");
        }

        return $resp->responseJson();

    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        return $redirect = redirect()->route('login');


    }


    public function myAccount(Request $request)
    {

        $user = new User();

        $id = $request->session()->get("DATAUSER")->id;
        $data = $user->getUserData($id);

        // print_r($data);

        return view("admin.account.mydata", ['data' => $data]);
    }


    public function editUser(Request $request)
    {

        $id = $request->session()->get("DATAUSER")->id; ///id usuario
        $user = new User();
        $data["nombre"] = $request->session()->get("DATAUSER")->nombre = $request->input("nombre");
        $data["apellido"] = $request->session()->get("DATAUSER")->apellido = $request->input("apellido");
        $data["email"] = $request->session()->get("DATAUSER")->email = $request->input("email");
        $data["identificacion"] = $request->input("cedula");
        $data["tlf1"] = $request->input("tlf1");

        $user->where('id', '=', $id)->update($data);

        $result = array("titulo" => "Exito", "mensaje" => "Datos actualizados con éxito",
            "nombre" => $data["nombre"], "apellido" => $data["apellido"]);
        return response()->json($result); /// json
    }


    public function getDataById(Request $req)
    {
        $user = new User();
        $data = $user->find($req->id);

        return $data;
    }


    public function password()
    {

        return view("admin.account.password");

    }


    public function changePassword(Request $req)
    {

        $id = $req->session()->get("DATAUSER")->id; ///id usuario


        $model = User::find($id);


        if (Hash::check($req->input("mypass"), $model->password)) {
            $model->password = Hash::make($req->input("pass1")); ///hashing
            $model->save();

            ////////envio de correo
            $nombre = $req->session()->get("DATAUSER")->nombre . ' ' . $req->session()->get("DATAUSER")->apellido;
            $clave = $req->input("pass1");
            $email = $req->session()->get("DATAUSER")->email;
            $this->sendPassword($nombre, $clave, $email);
            /////////////////

            $result = array("titulo" => "Exito",
                "mensaje" => "la clave ha sido cambiada", "tipo" => "info");
        } else {
            $result = array("titulo" => "Error",
                "mensaje" => "error la clave actual no corresponde con la del sistema",
                "tipo" => "error");
        }

        return response()->json($result); /// json

    }


    private function sendPassword($nombre, $newPass, $email)
    {

        $data = array(
            'nombre' => $nombre,
            'clave' => $newPass
        );

        Mail::send('admin.emails.password', $data, function ($message) use ($nombre, $email) {

            $message->from(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));

            $message->to($email, $nombre)->subject('Cambio de Password de usuario');

        });

    }


}