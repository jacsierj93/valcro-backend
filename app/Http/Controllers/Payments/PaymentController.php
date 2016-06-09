<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Masters\MasterFinancialController;
use App\Models\Sistema\BankAccountProvider;
use App\Models\Sistema\Payments\DocumentCP;
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
    private $factCuoIds = array(4, 5);

    public function __construct()
    {

        $this->middleware('auth');
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

            $temp = array();

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

                ////////totalizando pagos (documentos tipo NDC,ADE,REB sin terminar de consumir)
                if (in_array($doc->tipo_id, $abonos) && $doc->estatus==1) {
                    $total_abonos += MasterFinancialController::getCostByCoin($doc->saldo, $doc->moneda_id); //base $
                }

                ////total deudas (saldos de cuotas y (facturas sin cuotas) sin terminar de pagar por completo)
                if (in_array($doc->tipo_id, $deudas) && $doc->ncuotas()==0 && $doc->estatus==1) {
                    $total_deuda += MasterFinancialController::getCostByCoin($doc->saldo, $doc->moneda_id); //base $
                }


                ////nfact vence
                $vence = $doc->vencimiento();

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


        /////resetiando variables de sesion de proveedores
        Session::forget("PROVNAME");
        Session::forget("PROVID");


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


    /**trae los pagos de un proveedor
     * @param Request $req
     */
    public function getPaymentsByProvId(Request $req)
    {

        $prov = $req->prov_id;
        $pagos = Payment::where("prov_id", $prov)->get();

        $result = array();
        foreach ($pagos as $pago) {

            $temp = array();
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
        $data["deudas"] = $this->getDebtsList($provId); ////facturas
        $data["factCuo"] = $this->getFactCuoByProvId($provId); //cuotas y facturas sin cuotas

        return $data;

    }


    /**cuentas bancarias del proveedor
     * @return mixed
     */
    public function getProvBankAccounts()
    {

        $provid = Session::get("PROVID"); ///setea sesion del proveedor actual
        $data = BankAccountProvider::where("prov_id", $provid)->get();
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

            $temp = array();

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


    /**deudas del proveedor
     * @return mixed
     */
    public function getDebtsList($provId)
    {

        /////puras facturas no pagadas por completo
        $deudas = DocumentCP::where("prov_id", $provId)->where("estatus", 1)->whereIn('tipo_id', $this->debtsIds)->get();
        $result = array();
        foreach ($deudas as $deuda) {

            $temp = array();

            $temp["id"] = $deuda->id;
            $temp["nro_factura"] = $deuda->nro_factura;
            $temp["fecha"] = $deuda->fecha;
            $temp["vence"] = $deuda->fecha_vence;
            $temp["vencido"] = 'v' . $deuda->vencimiento(); ///color del punto
            $temp["tipo"] = $deuda->tipo->descripcion;
            $temp["saldo"] = $deuda->saldo;
            $temp["monto"] = $deuda->monto;
            $temp["cuotas"] = $deuda->ncuotas();
            $temp["pagado"] = $deuda->monto - $deuda->saldo;

            $result[] = $temp;
        }

        return $result;
    }


    public function getFactCuoByProvId($provId)
    {

        ////trayendo las facturas y cuotas que no hayan sido pagadas
        $deudas = DocumentCP::where("prov_id", $provId)->where("estatus", 1)->whereIn('tipo_id', $this->factCuoIds)->get();
        $result = array();
        foreach ($deudas as $deuda) {

            if ($deuda->ncuotas() == 0) { ///puras cuotas y facturas sin cuotas

                $temp = array();

                $temp["id"] = $deuda->id;
                $temp["nro_factura"] = $deuda->nro_factura;
                $temp["fecha"] = $deuda->fecha;
                $temp["vence"] = $deuda->fecha_vence;
                $temp["vencido"] = 'v' . $deuda->vencimiento(); ///color del punto
                $temp["tipo"] = $deuda->tipo->descripcion;
                $temp["saldo"] = $deuda->saldo;
                $temp["doc_orig"] = $deuda->doc_orig;
                $temp["nro_orig"] = $deuda->nro_orig;
                $temp["monto"] = $deuda->monto;
                $temp["pagado"] = $deuda->monto - $deuda->saldo;
                /////para saber si se selecciono
                $temp["seleccionado"] = 0;

            }


            $result[] = $temp;
        }

        return $result;


    }


    /********************************************************************************
     * ******************************OPERACIONES CRUD*****************************************
     *********************************************************************************/


    public function paySaveOrUpdate(Request $req)
    {

        dd($req->all());

    }


}
