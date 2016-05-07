<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Masters\MasterFinancialController;
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
        $abonos = array(1, 2, 3); ///id de los abonos AD,NDC,RBY
        $deudas = array(4); ///id de deudas
        $currenDate = date("Y-m-d");
        // echo MasterFinancialController::getCostByCoin(50000,2,3);


        $total_abonos = 0;
        $total_deuda = 0;
        $nvencido = 0; ///vencidos
        $nv7 = 0; ///vence 7
        $nv30 = 0; ///vence30
        $nv60 = 0; ///vence60
        $nv90 = 0; ///vence90


        $result = array();
        foreach ($provs as $prv) {

            $temp["id"] = $prv->id;
            $temp["razon_social"] = $prv->razon_social;
            $docs = $prv->getDocuments();

            foreach ($docs as $doc) {

                ////////totalizando abonos
                if (in_array($doc->tipo_id, $abonos)) {
                    $total_abonos += MasterFinancialController::getCostByCoin($doc->monto, $doc->moneda_id); //base $
                }

                ////total deudas
                if (in_array($doc->tipo_id, $deudas)) {
                    $total_deuda += MasterFinancialController::getCostByCoin($doc->monto, $doc->moneda_id); //base $
                }


                ////nfact vence
                $vence = $this->dateDiff($doc->fecha_vence, $currenDate);

                if ($vence <= 0) {
                    $nvencido++;
                } else if ($vence <= 7) {
                    $nv7++;
                } else if ($vence > 7 && $vence <= 30) {
                    $nv30++;
                } else if ($vence > 30 && $vence <= 60) {
                    $nv60++;
                } else if ($vence > 60 && $vence <= 90) {
                    $nv90++;
                }


            }

            $temp["tabono"] = $total_abonos;
            $temp["tdeuda"] = $total_deuda;
            $temp["vencido"] = $nvencido;
            $temp["vence7"] = $nv7;
            $temp["vence30"] = $nv30;
            $temp["vence60"] = $nv60;
            $temp["vence90"] = $nv90;

            $result[] = $temp;

        }


        return $result;
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


    public function getProvById($provId)
    {

        Session::put("PROVID", $provId); ///setea sesion del proveedor actual

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


    /**funcion que trae la diferencia de fechas en dias
     * @param $dateIni
     * @param $dateEnd
     * @return mixed
     */
    private function dateDiff($dateIni, $dateEnd)
    {
        $from = date_create($dateIni);
        $to = date_create($dateEnd);
        $diff = date_diff($to, $from);
        return (int)$diff->format('%R%d');
    }


}
