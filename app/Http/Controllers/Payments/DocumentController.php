<?php
/**
 * Created by PhpStorm.
 * User: delimce
 * Date: 15/5/2016
 * Time: 4:08 PM
 */

namespace app\Http\Controllers\Payments;

use App\Libs\Api\RestApi;
use App\Models\Sistema\Payments\DocumentCP;
use App\Models\Sistema\Payments\DocumentCPType;
use App\Models\Sistema\Payments\Payment;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;

class DocumentController extends BaseController
{

    private $payIds = array(1, 2, 3); ///tipos de abono ADE,NDC,RBAY
    private $debtsIds = array(4); ///facturas
    private $documentState = array(1, 2, 3); ///estatus de documentos nuevo,procesado,cancelado
    private $adeId = 1;
    private $ndcId = 2;
    private $rbayId = 3;

    public function __construct()
    {

        $this->middleware('auth');
    }


    /**tipos de documentos
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getDocumentTypes()
    {

        $dtype = DocumentCPType::all();

        return $dtype;
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
        $data["doc_vencimiento"] = 'v' . $doc->vencimiento(); ///color del punto
        $data["doc_descripcion"] = $doc->descripcion;
        if (in_array($doc->tipo_id, $this->debtsIds)) { ////en caso de ser una deuda

            $cdata = array();
            if ($doc->ncuotas() > 0) { ////factura con cuotas
                $cuotas = $doc->cuotas();
                foreach ($cuotas as $cc) {

                    $temp = array();
                    $temp["id"] = $cc->id;
                    $temp["fecha_vence"] = $cc->fecha_vence;
                    $temp["nro_factura"] = $cc->nro_factura;
                    $temp["descripcion"] = $cc->descripcion;
                    $temp["saldo"] = $cc->saldo;
                    $temp["monto"] = $cc->monto;
                    $temp["vencimiento"] = 'v' . $cc->vencimiento();
                    $cdata[] = $temp;
                }

                $data["factura_tipo"] = 'cc'; ///con cuota

            } else { ///factura sin cuotas (es la propia deuda)

                $temp = array();
                $temp["id"] = $doc->id;
                $temp["fecha_vence"] = $doc->fecha_vence;
                $temp["nro_factura"] = $doc->nro_factura;
                $temp["descripcion"] = $doc->descripcion;
                $temp["saldo"] = $doc->saldo;
                $temp["monto"] = $doc->monto;
                $temp["vencimiento"] = 'v' . $doc->vencimiento();
                $cdata[] = $temp;

                $data["factura_tipo"] = 'sc'; ///sin cuota, para direfenciar

            }


            $data["doc_cuotas"] = $cdata;

        }


        return $data;

    }


    /**pagos hechos sin factura
     * @return array todo: chequear si son todos? o si son los que no se han procesado (segun vista)
     */
    public function getAbonoList($type)
    {


        $abonos = DocumentCP::whereIn('tipo_id', $this->payIds)->orderBy('id', 'desc');

        /////si esta seleccionado el proveedor / sino trae todos los documentos
        if (Session::has('PROVID')) {
            $provId = Session::get("PROVID");
            $abonos = $abonos->where("prov_id", $provId);
        }


        if ($type == "new") {
            $abonos = $abonos->where("estatus", 1); ///sin usar
        }


        $lista = $abonos->get();


        $result = array();
        foreach ($lista as $pago) {

            $temp = array();
            $temp["id"] = $pago->id;
            $temp["nro_factura"] = $pago->nro_factura;
            $temp["origen"] = $pago->org_factura;
            $temp["fecha"] = $pago->fecha;
            $temp["monto"] = $pago->monto;
            $temp["moneda"] = $pago->moneda->codigo;
            $temp["tasa"] = $pago->tasa;
            try {
                $temp["tipo"] = $pago->tipo->descripcion;
            } catch (\Exception $e) {
                $temp["tipo"] = "N/A";
            }

            $temp["saldo"] = $pago->saldo;
            $temp["pagado"] = $pago->monto - $pago->saldo;
            $temp["montoUsado"] = $pago->monto; ///dispuesto a usar

            $result[] = $temp;
        }

        return $result;

    }


    /***trae todos los abonos realizados
     * @return mixed
     */
    public function getDocumentPayTypes()
    {
        $dtype = DocumentCPType::find($this->payIds);
        return $dtype;
    }


    /********************************************************************************
     * ******************************OPERACIONES CRUD*****************************************
     *********************************************************************************/


    public function abonoSaveOrUpdate(Request $req)
    {

        $rest = new RestApi();

        //////////validation
        $validator = Validator::make($req->all(), [

            'nro_doc' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $rest->setError("por favor, verifique los datos de entrada");

        } else {  ///ok


            try {

                DB::beginTransaction();


                $doc = new DocumentCP(); ///asignando datos del documento
                $doc->tipo_id = $req->tipo_id;
                $doc->prov_id = Session::get("PROVID");
                $doc->nro_factura = $req->nro_doc;
                $doc->moneda_id = $req->moneda_id;


                $doc->fecha = $req->fecha;
                $doc->monto = $req->monto;
                $doc->saldo = $req->monto;
                $doc->tasa = $req->tasa;
                $doc->descripcion = $req->descripcion;
                $doc->save(); ////edita/inserta el documento


                //*********************en caso de un adelanto*************************

                if ($this->adeId == $req->tipo_id) { ///se debe crear un pago porque genera mov cash


                    $pago = new Payment(); ///asignado datos del pago
                    $pago->prov_id = Session::get("PROVID");
                    $pago->moneda_id = $req->moneda_id;
                    $pago->tasa = $req->tasa;
                    $pago->fecha_pago = $req->fecha;
                    $pago->monto = $req->monto;
                    ///////////nro de cuenta del proveedor
                    $pago->prov_cuenta_id = $req->cuenta_id;
                    $pago->save();


                    /////creando relacion documento  pago

                    $payDoc = new PaymentDocumentCP();
                    $payDoc->pago_id = $pago->id;
                    $payDoc->documento_cp_id = $doc->id;
                    $payDoc->monto = $req->monto;
                    $payDoc->abono = $req->monto;
                    $payDoc->save();

                    //////forma de pago, porque genera mov de cash

                    $form = new PaymentForm();
                    $form->pago_id = $pago->id;
                    $form->tipo_id = $req->tipo_pago_id; ////tipo de pago
                    $form->banco = $req->banco; ////banco del pago
                    $form->ref_pago = $req->ref_pago; ////referencia del pago
                    $form->monto = $req->monto;


                }


                DB::commit();
                $rest->setContent("registro guardado con éxito");


            } catch (Exception $e) {
                // Woopsy
                DB::rollback();
                $rest->setError("error en la Transacción");
            }


        }

        return $rest->responseJson();


    }


    /**para pagos directos de cuotas o facturas sin cuotas (con o sin movimiento de cash)
     * @param Request $req
     */
    public function paymentDocuments(Request $req)
    {
        $rest = new RestApi();

        //////////validation
        $validator = Validator::make($req->all(), [

            'nro_doc' => 'required'

        ]);

        if ($validator->fails()) { ///ups... erorres

            $rest->setError("por favor, verifique los datos de entrada");

        } else {  ///ok


            try{


                /////se genera el pago
                $pago = new Payment(); ///asignado datos del pago
                $pago->prov_id = Session::get("PROVID"); ///mandatory
                $pago->moneda_id = $req->moneda_id; ///mandatory
                $pago->tasa = $req->tasa; ///mandatory
                $pago->fecha_pago = $req->fecha; ///mandatory
                $pago->monto = $req->monto; ////mandatory monto total del pago, documentos + cash
                ///////////nro de cuenta del proveedor
                $pago->prov_cuenta_id = $req->cuenta_id; //opc
                $pago->save();


                //////haciendo la relacion de que estoy pagando?? con que???


            }catch (\Exception $e){

                // Woopsy
                DB::rollback();
                $rest->setError("error en la Transacción");

            }





        }
    }


}