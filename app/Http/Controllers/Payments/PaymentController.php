<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Masters\MasterFinancialController;
use App\Models\Sistema\Providers\BankAccount;
use App\Models\Sistema\Payments\DocumentCP;
use App\Models\Sistema\Payments\Payment;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Providers\Provider;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;
use DB;


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
//        $provs = Provider::all();
//        $abonos = $this->payIds; ///id de los abonos AD,NDC,RBY
//        $deudas = $this->debtsIds; ///id de deudas
//        // echo MasterFinancialController::getCostByCoin(50000,2,3);
//
//
//        $result = array();
//        foreach ($provs as $prv) {
//
//            $temp = array();
//
//            $temp["id"] = $prv->id;
//            $temp["razon_social"] = $prv->razon_social;
//            $docs = $prv->getDocuments()->get();
//
//            $total_abonos = 0;
//            $total_deuda = 0;
//            $nvencido = 0; ///vencidos
//            $nv7 = 0; ///vence 7
//            $nv30 = 0; ///vence30
//            $nv60 = 0; ///vence60
//            $nv90 = 0; ///vence90
//            $nv100 = 0; ///vence +90
//
//
//            foreach ($docs as $doc) {
//
//                ////////totalizando pagos (documentos tipo NDC,ADE,REB sin terminar de consumir)
//                if (in_array($doc->tipo_id, $abonos)) {
//                    $total_abonos += MasterFinancialController::getCostByCoin($doc->monto, $doc->moneda_id); //base $
//                }
//
//                ////total deudas (saldos de cuotas y (facturas sin cuotas) sin terminar de pagar por completo)
//                if (in_array($doc->tipo_id, $deudas)) {
//                    $total_deuda += MasterFinancialController::getCostByCoin($doc->monto, $doc->moneda_id); //base $
//                }
//
//
//                ////nfact vence
//                $vence = $doc->vencimiento();
//
//                if ($vence == 0) {
//                    $nvencido++;
//                } else if ($vence == 7) {
//                    $nv7++;
//                } else if ($vence == 30) {
//                    $nv30++;
//                } else if ($vence == 60) {
//                    $nv60++;
//                } else if ($vence == 90) {
//                    $nv90++;
//                } else {
//                    $nv100++;
//                }
//
//
//            }
//
//            $temp["tabono"] = $total_abonos;
//            $temp["tdeuda"] = $total_deuda;
//            $temp["vencido"] = $nvencido;
//            $temp["vence7"] = $nv7;
//            $temp["vence30"] = $nv30;
//            $temp["vence60"] = $nv60;
//            $temp["vence90"] = $nv90;
//            $temp["vence100"] = $nv100;
//
//            $result[] = $temp;
//
//        }




        
        
        $qry = "SELECT
        prov.id,
        prov.razon_social,
        (SELECT -- Abonos -----------------------------------------------------------------------
              CASE
                WHEN SUM(tdc.saldo * tm.precio_usd) IS NULL THEN 0 ELSE SUM(tdc.saldo * tm.precio_usd)
              END AS monto
        FROM tbl_docum_cp AS tdc
          INNER JOIN tbl_moneda AS tm
            ON tm.id = tdc.moneda_id
        WHERE tdc.tipo_id IN ('1,2,3')
        AND tdc.prov_id = prov.id
        AND tdc.saldo > 0
        AND tdc.deleted_at = '0000-00-00 00:00:00') AS tabono,
        (SELECT -- Deudas -----------------------------------------------------------------------
              CASE
                WHEN SUM(tdc.saldo * tm.precio_usd) IS NULL THEN 0 ELSE SUM(tdc.saldo * tm.precio_usd)
              END AS saldo
        FROM tbl_docum_cp AS tdc
          INNER JOIN tbl_moneda AS tm
            ON tm.id = tdc.moneda_id
        WHERE tdc.tipo_id IN ('4,5')
        AND tdc.prov_id = prov.id
        AND tdc.saldo > 0
        AND tdc.deleted_at = '0000-00-00 00:00:00'
        AND tdc.id NOT IN (SELECT
          cuotas.nro_orig
        FROM tbl_docum_cp AS cuotas
        WHERE cuotas.tipo_id = 5
        GROUP BY cuotas.nro_orig)) AS tdeuda, -- Vencimiento ------------------------------------------------------------------
        CASE
            WHEN vence.vencido IS NULL THEN 0 ELSE vence.vencido
          END AS vencido,
        CASE
            WHEN vence.vence7 IS NULL THEN 0 ELSE vence.vence7
          END AS vence7,
        CASE
            WHEN vence.vence30 IS NULL THEN 0 ELSE vence.vence30
          END AS vence30,
        CASE
            WHEN vence.vence60 IS NULL THEN 0 ELSE vence.vence60
          END AS vence60,
        CASE
            WHEN vence.vence90 IS NULL THEN 0 ELSE vence.vence90
          END AS vence90,
        CASE
            WHEN vence.vence100 IS NULL THEN 0 ELSE vence.vence100
          END AS vence100 -- Deudas -----------------------------------------------------------------------
        FROM tbl_proveedor AS prov
          LEFT JOIN (SELECT
            tdc.prov_id,
            SUM(CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) <= 0 THEN 1 ELSE 0
              END) AS vencido,
            SUM(CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 1 AND 7 THEN 1 ELSE 0
              END) AS vence7,
            SUM(CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 8 AND 30 THEN 1 ELSE 0
              END) AS vence30,
            SUM(CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 31 AND 60 THEN 1 ELSE 0
              END) AS vence60,
            SUM(CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 61 AND 90 THEN 1 ELSE 0
              END) AS vence90,
            SUM(CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) > 90 THEN 1 ELSE 0
              END) AS vence100
          FROM tbl_docum_cp AS tdc
          WHERE tdc.tipo_id IN ('4,5')
          AND tdc.fecha_vence <> '0000-00-00 00:00:00'
          AND tdc.deleted_at = '0000-00-00 00:00:00'
          AND tdc.id NOT IN (SELECT
            cuotas.nro_orig
          FROM tbl_docum_cp AS cuotas
          WHERE cuotas.tipo_id = 5
          GROUP BY cuotas.nro_orig)
          GROUP BY tdc.prov_id) AS vence
            ON vence.prov_id = prov.id";
        $result = DB::select($qry);
        foreach ($result as $key => $val) {
            foreach ($val as $k => $v) {
                if(gettype($k)== "integer"){
                    unset($result[$key][$k]);
                }/*elseif($k == "tabono"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }elseif($k == "tdeuda"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }*/
            }
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
        $data = BankAccount::where("prov_id", $provid)->get();
        return $data;

    }


    /**lista de pagos hechas al proveedor CON FACTURA
     * @return mixed
     */
    public function getPayListFact($provId)
    {
        /*$pagos = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->payIds)->get();

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
        }*/

        $qry = "SELECT
            tdc.id,
            tdc.nro_factura,
            tdc.fecha,
            tdct.descripcion,
            tdc.saldo,
            (tdc.monto - tdc.saldo) AS pagado
          FROM tbl_docum_cp AS tdc
            INNER JOIN tbl_docum_cp_tipo AS tdct
            ON tdct.id = tdc.tipo_id
          WHERE tdc.tipo_id IN ('1,2,3')
          AND tdc.prov_id = $provId";
        $result = DB::select($qry);
        foreach ($result as $key => $val) {
            foreach ($val as $k => $v) {
                if(gettype($k)== "integer"){
                    unset($result[$key][$k]);
                }/*elseif($k == "saldo"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }elseif($k == "pagado"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }*/
            }
        }
        
        return $result;
    }


    /**deudas del proveedor
     * @return mixed
     */
    public function getDebtsList($provId)
    {

        /////puras facturas no pagadas por completo
        /*$deudas = DocumentCP::where("prov_id", $provId)->where("estatus", 1)->whereIn('tipo_id', $this->debtsIds)->get();
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
        }*/
        
        $qry = "SELECT
            tdc.id,
            tdc.nro_factura,
            tdc.fecha,
            tdc.fecha_vence AS vence,
            (CASE
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) <= 0 THEN 'v0'
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 1 AND 7 THEN 'v7'
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 8 AND 30 THEN 'v30'
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 31 AND 60 THEN 'v60'
                WHEN DATEDIFF(tdc.fecha_vence, CURDATE()) BETWEEN 61 AND 90 THEN 'v90' ELSE 'v100'
              END) AS vencido,
            tdct.descripcion,
            tdc.saldo,
            tdc.monto,
            (SELECT
              COUNT(qots.id) AS cuotas
            FROM tbl_docum_cp AS qots
            WHERE qots.tipo_id = 5
            AND qots.nro_orig = tdc.id
            AND tdc.deleted_at = '0000-00-00 00:00:00') AS cuotas,
            (tdc.monto - tdc.saldo) AS pagado
          FROM tbl_docum_cp AS tdc
            INNER JOIN tbl_docum_cp_tipo AS tdct
              ON tdct.id = tdc.tipo_id
          WHERE tdc.tipo_id = 4
          AND tdc.prov_id = $provId
          AND tdc.estatus = 1
          AND tdc.deleted_at = '0000-00-00 00:00:00'";
        $result = DB::select($qry);
        foreach ($result as $key => $val) {
            foreach ($val as $k => $v) {
                if(gettype($k)== "integer"){
                    unset($result[$key][$k]);
                }/*elseif($k == "saldo"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }elseif($k == "monto"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }elseif($k == "pagado"){
                    $result[$key][$k] = number_format($v, 2, ',', '.');
                }*/
            }
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
