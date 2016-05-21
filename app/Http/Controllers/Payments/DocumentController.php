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
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;

class DocumentController extends BaseController
{

    private $payIds = array(1, 2, 3); ///tipos de abono ADE,NDC,RBAY
    private $debtsIds = array(4); ///facturas
    private $documentState = array(1, 2, 3); ///estatus de documentos nuevo,procesado,cancelado
    private $ndcId = 2;
    private $adeId = 1;
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

            $cuotas = $doc->cuotas();
            $cdata = array();
            foreach ($cuotas as $cc) {

                $temp["id"] = $cc->id;
                $temp["fecha_vence"] = $cc->fecha_vence;
                $temp["nro_factura"] = $cc->nro_factura;
                $temp["descripcion"] = $cc->descripcion;
                $temp["saldo"] = $cc->saldo;
                $temp["vencimiento"] = 'v' . $cc->vencimiento();
                $cdata[] = $temp;
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

        $provId = Session::get("PROVID");
        $abonos = DocumentCP::where("prov_id", $provId)->whereIn('tipo_id', $this->payIds)->orderBy('id', 'desc');

        if ($type == "new") {
            $abonos = $abonos->where("estatus", 1);
        }


        $lista = $abonos->get();


        $result = array();
        foreach ($lista as $pago) {

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
                $doc->save(); ////edita/inserta el docmento


                //*********************en caso de un adelanto*************************

                if ($this->adeId == $req->tipo_id) {


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

                    //////forma de pago

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


}