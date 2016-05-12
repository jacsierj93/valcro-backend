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
    private $debtsIds = array(4);

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

    /**lista de proveedores con sus atributos de pagos y facturas
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getProvidersList()
    {
        $provs = Provider::all();
        $abonos = $this->payIds; ///id de los abonos AD,NDC,RBY
        $deudas = $this->debtsIds; ///id de deudas
        // echo MasterFinancialController::getCostByCoin(50000,2,3);


        $result = array();
        foreach ($provs as $prv) {

            $temp["id"] = $prv->id;
            $temp["razon_social"] = $prv->razon_social;
            $docs = $prv->getDocuments()->get();

            $total_abonos = 0;
            $total_deuda = 0;
            $nvencido = 0; ///vencidos
            $nv7 = 0; ///vence 7
            $nv30 = 0; ///vence30
            $nv60 = 0; ///vence60
            $nv90 = 0; ///vence90
            $nv100 = 0; ///vence +90


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
                //  $vence = $this->dateDiff($doc->fecha_vence, $currenDate);
                $vence = $this->getVencimiento($doc->fecha_vence);

                if ($vence == 0) {
                    $nvencido++;
                } else if ($vence == 7) {
                    $nv7++;
                } else if ($vence == 30) {
                    $nv30++;
                } else if ($vence == 60) {
                    $nv60++;
                } else if ($vence == 90) {
                    $nv90++;
                } else {
                    $nv100++;
                }


            }

            $temp["tabono"] = $total_abonos;
            $temp["tdeuda"] = $total_deuda;
            $temp["vencido"] = $nvencido;
            $temp["vence7"] = $nv7;
            $temp["vence30"] = $nv30;
            $temp["vence60"] = $nv60;
            $temp["vence90"] = $nv90;
            $temp["vence100"] = $nv100;

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


    /**trae nombre del proveedor, deudas y pagos
     * @param $provId
     * @return mixed
     */
    public function getProvById($provId)
    {

        $proveedor = Provider::findOrFail($provId); ///trayendo datos del proveedor
        Session::put("PROVNAME", $proveedor->razon_social); ///nombre provedor
        Session::put("PROVID", $provId); ///setea sesion del proveedor actual

        $data["id"] = $proveedor->id;
        $data["razon_social"] = $proveedor->razon_social;
        $data["pagos"] = $this->getPayListFact($provId);
        $data["deudas"] = $this->getDebtsList($provId);

        return $data;

    }


    /** para seleccionar el detalle del documento
     * @param $id
     * @return mixed
     */
    public function getDocById($id)
    {

        $doc = DocumentCP::findOrFail($id);

        $data["prov_nombre"] = Session::get("PROVNAME");
        $data["prov_id"] = Session::get("PROVID");
        $data["doc_id"] = $doc->id;
        $data["doc_tipo"] = $doc->tipo_id;
        $data["doc_factura"] = $doc->nro_factura;
        $data["doc_vence"] = $doc->fecha_vence;
        $data["doc_vencimiento"] = 'v' . $this->getVencimiento($doc->fecha_vence); ///color del punto
        $data["doc_descripcion"] = $doc->descripcion;
        if (in_array($doc->tipo_id, $this->debtsIds)) { ////en caso de ser una deuda

            $cuotas = $doc->cuotas();
            $cdata = array();
            foreach ($cuotas as $cc){

                $temp["id"] = $cc->id;
                $temp["fecha_vence"] = $cc->fecha_vence;
                $temp["nro_factura"] = $cc->nro_factura;
                $temp["descripcion"] = $cc->descripcion;
                $temp["vencimiento"] = 'v'.$cc->vencimiento();
                $cdata[] = $temp;
            }

            $data["doc_cuotas"] = $cdata;

        }


        return $data;

    }


    /**lista de pagos hechas al proveedor CON FACTURA
     * @return mixed
     */
    public function getPayListFact($provId)
    {
        $pagos = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->payIds)->get();

        $result = array();
        foreach ($pagos as $pago) {

            $temp["id"] = $pago->id;
            $temp["nro_factura"] = $pago->nro_factura;
            $temp["fecha"] = $pago->fecha;
            $temp["tipo"] = $pago->tipo->descripcion;
            $temp["saldo"] = $pago->saldo;
            $temp["pagado"] = $pago->monto - $pago->saldo;


            $result[] = $temp;
        }


        return $result;
    }


    /**pagos hechos sin factura
     * @return array
     */
    public function getPayList(){


        $provId = Session::get("PROVID");
        $pagos = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->payIds)->get();

        $result = array();
        foreach ($pagos as $pago) {

            $temp["id"] = $pago->id;
            $temp["nro_factura"] = $pago->nro_factura;
            $temp["origen"] = $pago->org_factura;
            $temp["fecha"] = $pago->fecha;
            $temp["monto"] = $pago->monto;
            $temp["moneda"] = $pago->moneda->codigo;
            $temp["tasa"] = $pago->tasa;
            $temp["tipo"] = $pago->tipo->descripcion;
            $temp["saldo"] = $pago->saldo;
            $temp["pagado"] = $pago->monto - $pago->saldo;

            $result[] = $temp;
        }

        return $result;
        
    }
    
    


    /**deudas del proveedor
     * @return mixed
     */
    public function getDebtsList($provId)
    {
        $deudas = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->debtsIds)->get();
        $result = array();
        foreach ($deudas as $deuda) {

            $temp["id"] = $deuda->id;
            $temp["nro_factura"] = $deuda->nro_factura;
            $temp["fecha"] = $deuda->fecha;
            $temp["vence"] = $deuda->fecha_vence;
            $temp["vencido"] = 'v' . $this->getVencimiento($deuda->fecha_vence); ///color del punto
            $temp["tipo"] = $deuda->tipo->descripcion;
            $temp["saldo"] = $deuda->saldo;
            $temp["monto"] = $deuda->monto;
            $temp["cuotas"] = $deuda->ncuotas();
            $temp["pagado"] = $deuda->monto - $deuda->saldo;

            $result[] = $temp;
        }

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

    /**calcula el rango de vencimiento segun la fecha dada
     * @param $fecha
     * @return int
     */
    private function getVencimiento($fecha)
    {

        $currenDate = date("Y-m-d"); ///fecha actual
        $dias = $this->dateDiff($fecha, $currenDate); ///calculo de dias para el vencimiento

        if ($dias <= 0) {
            $estatus = 0; ///vencido
        } else if ($dias <= 7) {
            $estatus = 7; ///vence en 7 dias o menos ...
        } else if ($dias > 7 && $dias <= 30) {
            $estatus = 30;
        } else if ($dias > 30 && $dias <= 60) {
            $estatus = 60;
        } else if ($dias > 60 && $dias <= 90) {
            $estatus = 90;
        } else {
            $estatus = 100; ///mas de 90
        }

        return $estatus;


    }


}
