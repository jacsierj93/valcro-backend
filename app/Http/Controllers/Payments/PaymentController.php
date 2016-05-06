<?php

namespace App\Http\Controllers\Payments;

use App\Models\Sistema\Payments\DocumentCP;
use App\Models\Sistema\Payments\DocumentCPType;
use App\Models\Sistema\Payments\Payment;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Provider;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;


class PaymentController extends BaseController
{


    private $payIds = array(1, 2, 3);
    private $debtsIds = array(4, 5);

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

        $datos = new Departament();

        if ($req->has('id')) {
            $datos = Departament::findOrFail($req->id);
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

            $result = array("success" => "Registro guardado con éxito", "action" => "new");

            $model = new Departament();
            //////////condicion para editar
            if ($req->has('id')) {
                $model = $model->findOrFail($req->id);
                $result["action"] = "edit";
            }

            $model->nombre = $req->nombre;
            $model->descripcion = $req->descripcion;
            $model->save(); ////edita/inserta aviso


        }

        return response()->json($result); /// respuesta json

    }

    public function delete(Request $req)
    {


        $model = new Departament();
        $id = $req->input("id", 0);
        $model->destroy($id);


    }



    /////lista de proveedores

    /**lista de proveedores
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProvidersList()
    {
        $provs = Provider::all();
        return $provs;
    }


    /**tipos de pago
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPaymentTypes()
    {
        $types = PaymentType::all();
        return $types;

    }

    /**tipos de documentos
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getDocumentTypes()
    {

        $dtype = DocumentCPType::all();
        return $dtype;
    }


    /**trae los pagos de un proveedor
     * @param Request $req
     */
    public function getPaymentsByProvId(Request $req)
    {

        $prov = $req->prov_id;
        $pagos = Payment::where("prov_id", $prov)->get();

        $result = array();
        foreach ($pagos as $pago) {

            $temp["id"] = $pago->id;
            $temp["monto"] = $pago->monto;
            $temp["fecha"] = $pago->fecha_pago;
            $temp["tasa"] = $pago->tasa;
            $temp["moneda"] = $pago->moneda->nombre;

            $result[] = $temp;
        }

        return response()->json($result); /// json
    }



    public function getProvById($provId){

        Session::put("PROVID",$provId); ///setea sesion del proveedor actual

        $proveedor = Provider::findOrFail($provId); ///trayendo datos del proveedor

    }



    /**lista de pagos hechas al proveedor
     * @return mixed
     */
    public function getPayList()
    {
        $provId = Session::get("PROVID");
        $pagos = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->payIds)->get();
        $result = $pagos;
        return $result;
    }


    /**deudas del proveedor
     * @return mixed
     */
    public function getDebtsList()
    {
        $provId = Session::get("PROVID");
        $deudas = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->debtsIds)->get();
        $result = $deudas;
        return $result;
    }


}
