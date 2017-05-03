<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Masters\MasterProductController;

use App\Libs\Api\RestApi;

use App\Libs\Utils\Files;
use App\Models\Sistema\Masters\Country;
use App\Models\Sistema\CustomOrders\CustomOrder;
use App\Models\Sistema\Masters\FileModel;
use App\Models\Sistema\Order\OrderAnswer;
use App\Models\Sistema\Order\OrderAnswerAttachment;
use App\Models\Sistema\Order\OrderAttachment;
use App\Models\Sistema\Product\Product;
use App\Models\Sistema\CustomOrders\CustomOrderPriority;
use App\Models\Sistema\CustomOrders\CustomOrderReason;
use  App\Models\Sistema\CustomOrders\CustomOrderItem;
use App\Models\Sistema\KitchenBoxs\KitchenBox;
use App\Models\Sistema\Masters\Monedas;
use App\Models\Sistema\MailModels\MailModule;
use App\Models\Sistema\MailModels\MailModuleDestinations;
use App\Models\Sistema\Order\Order;
use App\Models\Sistema\Order\OrderCondition;
use App\Models\Sistema\Order\OrderItem;
use App\Models\Sistema\Order\OrderPriority;
use App\Models\Sistema\Order\OrderReason;
use App\Models\Sistema\Order\OrderStatus;
use App\Models\Sistema\Order\OrderType;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\Payments\PaymentType;
use App\Models\Sistema\Masters\Ports;
use App\Models\Sistema\Masters\Language;
use App\Models\Sistema\Product\ProductType;
use App\Models\Sistema\Providers\ContactField;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Providers\ProviderAddress;
use App\Models\Sistema\Providers\ProviderCondPay;
use App\Models\Sistema\Providers\ProvTipoEnvio;
use App\Models\Sistema\Purchase\Purchase;
use App\Models\Sistema\Purchase\PurchaseAnswer;
use App\Models\Sistema\Purchase\PurchaseAnswerAttaments;
use App\Models\Sistema\Purchase\PurchaseAttachment;
use App\Models\Sistema\Purchase\PurchaseItem;
use App\Models\Sistema\Purchase\PurchaseItemCondition;
use App\Models\Sistema\Solicitude\Solicitude;
use App\Models\Sistema\Solicitude\SolicitudeAnswer;
use App\Models\Sistema\Solicitude\SolicitudeAnswerAttachment;
use App\Models\Sistema\Solicitude\SolicitudeAttachment;
use App\Models\Sistema\Solicitude\SolicitudeItem;
use App\Models\Sistema\User;
use App\Models\Sistema\Views\ItemsInMdlOrders;
use Carbon\Carbon;
use DB;
use Log;
use PDF;
use Storage;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Laravel\Lumen\Routing\Controller as BaseController;
use Validator;
use App;
class OrderController extends BaseController
{


    private $defaulString = '';
    private $defaulInt = 0;
    private $request;
    private $emailTemplate = ['ProviderEstimate' => [
        'default' => 'emails.modules.Order.External.ProviderEstimate',
        'es' => 'emails.modules.Order.External.es.ProviderEstimate',
        'en' => 'emails.modules.Order.External.en.ProviderEstimate'
    ]];

    private $profile = ['gerente' => '6', 'trabajador' => '10', 'jefe' => '9','gerente_adm'=>'8'];
    private $departamentos = ['compras' => '17', 'propetario' => '18', 'auditoria' => '22','gerente_dp' => '21','gerente_adm' => '21'];
    private $user = null;

    public function test(Request $req){
        $model= Order::findOrFail(23);
        $user = $this->user;
        $model->makedebt();
        $data =  [
            'subjet'=>'daee',
            'model'=>$model,
            'texto'=>'sadfsadf',
            'articulos'=>$model->items()->with('producto')->get(),
            'user'=>$user];
        return View('emails.Purchase.InternalManager.es',$data);
    }

    public function __construct(Request $req)
    {

        $this->middleware('auth');
        $this->request = $req;
        if ($this->user == null) {
            $this->user = User::selectRaw('tbl_usuario.id,tbl_usuario.nombre, tbl_usuario.email,tbl_usuario.apellido, tbl_usuario.cargo_id , tbl_cargo.departamento_id')
                ->join('tbl_cargo', 'tbl_usuario.cargo_id', '=', 'tbl_cargo.id')->where('tbl_usuario.id', $req->session()->get('DATAUSER')['id'])->first();
        }
    }

    /*********************** SYSTEM ************************/

    public function getPermision()
    {
        if ($this->user->departamento_id == 22) {
            return ['created' => false];
        } else {
            return ['created' => true, 'profile' => $this->user];
        }
    }

    /**
     * trae los documentos que estan si revisar
     */
    public function getOldReviewDoc(Request $req)
    {
        $allDocs = array();
        $oldDocs = array();
        $monedas = Monedas::get();
        $oldReviewDays = $this->oldReview();
        $data ['dias'] = $oldReviewDays;

        $allDocs[0] = Solicitude::selectRaw("*, datediff( curdate(),ult_revision) as review ")
            ->whereNotNull("final_id")
            ->whereRaw(" datediff( curdate(),ult_revision) >=" . $oldReviewDays . "")
            ->get();

        $allDocs[1] = Order::
        selectRaw("*, datediff( curdate(),ult_revision) as review ")
            ->whereNotNull("final_id")
            ->whereRaw(" datediff( curdate(),ult_revision) >=" . $oldReviewDays . "")
            ->get();
        $allDocs[2] = Purchase::selectRaw("*, datediff( curdate(),ult_revision) as review ")
            ->whereNotNull("final_id")
            ->whereRaw(" datediff( curdate(),ult_revision) >=" . $oldReviewDays . "")
            ->get();

        foreach ($allDocs as $docs) {

            foreach ($docs as $aux) {
                $temp = array();
                $temp['id'] = $aux->id;
                $temp['documento'] = $aux->getTipo();
                $temp['tipo'] = $aux->getTipoId();
                $temp['titulo'] = $aux->titulo;
                $temp['monto'] = $aux->monto;
                $temp['symbol'] = $monedas->where('id', $aux->prov_moneda_id)->first()->simbolo;
                $temp['emision'] = $aux->emision;
                $temp['comentario'] = $aux->comentario;
                $temp['prov_id'] = $aux->prov_id;
                $temp['review'] = $aux->review;
                $temp['prov_id'] = $aux->prov_id;
                $temp['proveedor'] = Provider::findOrFail($aux->prov_id)->razon_social;
                $temp['productos'] = $this->getProductoItem($aux);

                $oldDocs[] = $temp;


            }
        }
        $data['docs'] = $oldDocs;
        return $data;
    }

    /**
     * trae los documentos que no fueron fnalizados
     */
    public function getUnClosetDocument(Request $req)
    {
        $docsUnclose = array();
        $data = array();
        $monedas = Monedas::get();


        $docsUnclose[0] = Solicitude::whereNull("final_id")->where('edit_usuario_id', $req->session()->get('DATAUSER')['id'])
            ->whereNull('cancelacion');
        $docsUnclose[1] = Order::whereNull("final_id")->where('edit_usuario_id', $req->session()->get('DATAUSER')['id'])
            ->whereNull('cancelacion');
        $docsUnclose[2] = Purchase::whereNull("final_id")->where('edit_usuario_id', $req->session()->get('DATAUSER')['id'])
            ->whereNull('cancelacion');

        $docsUnclose[0] = $docsUnclose[0]->get();
        $docsUnclose[1] = $docsUnclose[1]->get();
        $docsUnclose[2] = $docsUnclose[2]->get();
        foreach ($docsUnclose as $docs) {
            foreach ($docs as $aux) {
                $prov = Provider::find($aux->prov_id);
                $temp = array();
                $temp['id'] = $aux->id;
                $temp['documento'] = $aux->getTipo();
                $temp['tipo'] = $aux->getTipoId();
                $temp['titulo'] = $aux->titulo;
                $temp['fecha_envio'] = $aux->fecha_envio;
                $temp['monto'] = $aux->monto;
                $temp['uid'] = $aux->uid;
                $temp['symbol'] = ($aux->prov_moneda_id != null && $aux->prov_moneda_id != 0) ? $monedas->where('id', $aux->prov_moneda_id)->first()->simbolo : '' ;
                $temp['emision'] = $aux->emision;
                $temp['comentario'] = $aux->comentario;
                $temp['prov_id'] = $aux->prov_id;
                $temp['proveedor'] = ($prov == null) ? '' : $prov->razon_social;
                // $temp['productos'] = $this->getProductoItem($aux);


                $data[] = $temp;


            }
        }
        return $data;
    }

    /**
     * trae las notificaciones del sistema
     */
    public function getNotifications(Request $req)
    {
        $result = [];
        $oldReviewDays = $this->oldReview();

        $aux = Solicitude::whereNotNull("final_id")
            ->where("disponible", '1')
            ->whereNotNull("ult_revision")
            ->whereRaw(" datediff( ult_revision,curdate()) >" . $oldReviewDays . "")
            ->count();


        if ($aux > 0) {
            $result[] = array('titulo' => 'Solicitudes con mas de ' . $oldReviewDays . " dias sin revisar ", 'key' => 'priorityDocs', 'cantidad' => $aux);
        }

        $aux = Order::selectRaw("count(id)")
            ->where("disponible", '1')
            ->whereNotNull("ult_revision")
            ->whereRaw(" datediff( ult_revision,curdate()) >" . $oldReviewDays . "")
            ->count();

        if ($aux > 0) {
            $result[] = array('titulo' => 'Proformas con mas de ' . $oldReviewDays . " dias sin revisar ", 'key' => 'priorityDocs', 'cantidad' =>$aux);
        }

        $aux = Purchase::selectRaw("count(id)")
            ->where("disponible", '1')
            ->whereNotNull("ult_revision")
            ->whereRaw(" datediff( ult_revision,curdate()) >" . $oldReviewDays . "")
            ->count();


        if ($aux > 0) {
            $result[] = array('titulo' => 'Ordenes de compra con mas de ' . $oldReviewDays . " dias sin revisar ", 'key' => 'priorityDocs', 'cantidad' => $aux);
        }

        // sin culminar
        $aux = Solicitude::selectRaw("count(id)")
            ->where("disponible", '1')
            ->whereNull("final_id")
            ->whereNull('cancelacion')
            ->where('edit_usuario_id', $req->session()->get('DATAUSER')['id']);

        $aux = $aux->count();
        if ($aux > 0) {
            $result[] = array('titulo' => "Solicitudes sin culminar", 'key' => 'unclosetDoc', 'cantidad' =>$aux);
        }

        $aux = Order::selectRaw("count(id)")
            ->where("disponible", '1')
            ->whereNull("final_id")
            ->whereNull('cancelacion')
            ->where('edit_usuario_id', $req->session()->get('DATAUSER')['id']);
        $aux = $aux->count();

        if ($aux > 0) {
            $result[] = array('titulo' => "Proformas sin culminar", 'key' => 'unclosetDoc', 'cantidad' => $aux);
        }

        $aux = Purchase::selectRaw("count(id)")
            ->where("disponible", '1')
            ->whereNull("final_id")
            ->whereNull('cancelacion')
            ->where('edit_usuario_id', $req->session()->get('DATAUSER')['id']);
        $aux = $aux->count();
        if ($aux > 0) {
            $result[] = array('titulo' => "Ordenes de compra sin culminar", 'key' => 'unclosetDoc', 'cantidad' => $aux);
        }

        return $result;


    }


    public function resendEmail(Request $req){
        $model = MailModule::findOrFail($req->id);
        return $model->resend();
    }


    public function sendMail(Request $req){

        $mail = new MailModule();
        $mail->tipo_origen_id = 20;
        $mail->asunto =$req->has('asunto') ? $req->asunto : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'email';
        $adjs = [];
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto,'from'=>$req->from];

        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){


            foreach ($req->adjs as $f){
                $att = new App\Models\Sistema\MailModels\MailModuleAttachment();
                $att->doc_id= $mail->id;
                $att->archivo_id= $f['id'];
                $att->nombre= $f['file'];
                $att->save();
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }

        }
        $resul['email'] = $mail->sendMail($req->content, $destinations);
        return $resul;
    }

    public function getSenderEmails(Request $req){
        $models= MailModule::
        whereNotnull('send')
            ->where('tipo','user')
           // ->where('modulo','email')
            ->with('senders')
            ->get()
        ;

        foreach ($models as $model){
            $model->countAttachments = $model->countAttachments();
        }

        return $models;
    }

    /*********************** PROVIDER ************************/

    public function getProvidersEmails (Request $req){

        $correos = [];
        $data = App\Models\Sistema\Providers\Contactos::selectRaw('tbl_contacto.id, nombre')->
        join('tbl_prov_cont','tbl_contacto.id','=','tbl_prov_cont.cont_id')->get();
        foreach ($data as $contact){
            foreach ($contact->campos()->where('campo', 'email')->get() as $aux2){
                foreach ($contact->contacto_proveedor()->get() as $prov){
                    $e =  ['nombre'=>$contact->nombre, 'correo'=>$aux2->valor, 'prov'=> ['prov_id'=>$prov->id,'razon_social'=>$prov->razon_social] ];
                    $e['langs'] = array_map('strtolower', $contact->idiomas()->lists('iso_lang')->toarray());
                    $correos[] =$e ;
                }
            }
        }
        return $correos;
    }

    /**
     * obtiene la lista de proveedores
     */
    public function getProviderList()
    {
        /*    $data =[];
            $cPaises =[];*/

        $rawn = "id, razon_social ,contrapedido,(select sum(monto)
         from tbl_proveedor as proveedor inner join tbl_compra_orden on proveedor.id = tbl_compra_orden.prov_id
         where tbl_compra_orden.prov_id = tbl_proveedor.id and tbl_compra_orden.deleted_at is null  ) as deuda";
        $rawn .= " ,(select count(id) from tbl_compra_orden where prov_id = tbl_proveedor.id and tbl_compra_orden.deleted_at is null
         and final_id is null and fecha_sustitucion is null and fecha_aprob_compra != null
         and fecha_aprob_gerencia != null and estado_id != 3
         ) as contraPedidos ";

        $rawn .= " , (" . $this->generateProviderEmit("emision", "<=0") . ") as emit0 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 1 and  7 ") . ") as emit7 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 7 and  30 ") . ") as emit30 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 31 and  60 ") . ") as emit60 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 61 and  90 ") . ") as emit90 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " > 90 ") . ") as emit100 ";

        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", "<=0") . ") as review0 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 1 and  7 ") . ") as review7 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 7 and  30 ") . ") as review30 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 31 and  60 ") . ") as review60 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 61 and  90 ") . ") as review90 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " > 90 ") . ") as review100 ";

            /*$qry = "SELECT
            id,
            razon_social,
            contrapedido,
            (SELECT
              SUM(monto)
            FROM tbl_proveedor AS proveedor
              INNER JOIN tbl_compra_orden
                ON proveedor.id = tbl_compra_orden.prov_id
            WHERE tbl_compra_orden.prov_id = tbl_proveedor.id AND tbl_compra_orden.deleted_at IS NULL) AS deuda,
            (SELECT
              COUNT(id)
            FROM tbl_compra_orden
            WHERE prov_id = tbl_proveedor.id AND tbl_compra_orden.deleted_at IS NULL
            AND final_id IS NULL AND fecha_sustitucion IS NULL AND fecha_aprob_compra != NULL
            AND fecha_aprob_gerencia != NULL AND estado_id != 3) AS contraPedidos,
            emisiones.emit0,
            emisiones.emit7,
            emisiones.emit30,
            emisiones.emit60,
            emisiones.emit90,
            emisiones.emit100,
            revisiones.review0,
            revisiones.review7,
            revisiones.review30,
            revisiones.review60,
            revisiones.review90,
            revisiones.review100
          FROM tbl_proveedor
            LEFT JOIN (SELECT
              SUM(vce.emit0) AS emit0,
              SUM(vce.emit7) AS emit7,
              SUM(vce.emit30) AS emit30,
              SUM(vce.emit60) AS emit60,
              SUM(vce.emit90) AS emit90,
              SUM(vce.emit100) AS emit100,
              vce.prov_id
            FROM view_compras_emisiones AS vce
            GROUP BY vce.prov_id) AS emisiones
              ON emisiones.prov_id = tbl_proveedor.id
            LEFT JOIN (SELECT
              SUM(vcr.review0) AS review0,
              SUM(vcr.review7) AS review7,
              SUM(vcr.review30) AS review30,
              SUM(vcr.review60) AS review60,
              SUM(vcr.review90) AS review90,
              SUM(vcr.review100) AS review100,
              vcr.prov_id
            FROM view_compras_revisiones AS vcr
            GROUP BY vcr.prov_id) AS revisiones
              ON revisiones.prov_id = tbl_proveedor.id
          GROUP BY tbl_proveedor.id";
        $provs = DB::select($qry);
        
        foreach ($provs as $key => $val) {
            foreach ($val as $k => $v) {
                if(gettype($k)== "integer"){
                    unset($provs[$key][$k]);
                }
            };
        };*/
        
        
        $provs = Provider::selectRaw($rawn)
            ->with('getProviderCoin','getPaymentCondition','contacts')
            ->get();
        /*     foreach($provs as $aux){
                 $paises= [];
                 foreach( $aux->getCountry() as $p){
                     $paises[] = $p->short_name;
                     if (in_array($p->short_name, $cPaises)) {
                         $cPaises[] = $p->short_name;
                     }
                 }
                 $aux['paises'] =$paises ;
             }
             $data['proveedores'] = $provs;
             $data['paises'] = $cPaises;*/

        return $provs;
    }

    /**
     * deprecated
     * cuentas los provedores que pueden hacer pedidos
     */
    public function countProvider()
    {
        //$data =Provider::selectRaw("count('id')")->get()->get(0)[0];
        $data['value'] = Provider::selectRaw("count('id')")->get()->get(0)[0];

        return $data;
    }

    /**@depreccated
     * traue a los provedores
     */
    public function getProviders(Request $req)
    {
        $data = array();
        $provs = Provider::
        //   where('id', 2)->
        Orderby('razon_social')->
        skip($req->skit)->take($req->take)->


        get();
        $data = array();
        //  $auxCp= Collection::make(array());

        foreach ($provs as $prv) {
            $paso = true;
            if (sizeof($prv->getCountry()) > 0) {
                $paso = true;
            }
            /* if($req->has('skitProv')){
                 $exclu = json_decode($req->skitProv);
                foreach($req->skitProv as $aux){
                    if($aux['id'] == $prv->id ){
                        $paso= false;
                        break;
                    }
                }
             }*/
            if ($paso) {
                $temp["id"] = $prv->id;
                $temp["razon_social"] = $prv->razon_social;
                $temp['deuda'] = $prv->purchase()->whereNotNull('final_id')->sum('monto');
                //  $temp['productos']= $prv->proveedor_product()->get();
                $temp['paises'] = $prv->getCountry();
                $peds = $prv->getOrderDocuments();


                $nCp = 0;
                $nE0 = 0;
                $nE7 = 0;
                $nE30 = 0;
                $nE60 = 0;
                $nE90 = 0;
                $nE100 = 0;

                $nR0 = 0;
                $nR7 = 0;
                $nR30 = 0;
                $nR60 = 0;
                $nR90 = 0;
                $nR100 = 0;

                foreach ($peds as $ped) {
                    $arrival = $ped->daysCreate();

                    if ($arrival == 0) {
                        $nE0++;
                    } else if ($arrival == 7) {
                        $nE7++;
                    } else if ($arrival == 30) {
                        $nE30++;
                    } else if ($arrival == 60) {
                        $nE60++;
                    } else if ($arrival == 90) {
                        $nE90++;
                    } else if ($arrival == 100) {
                        $nE100++;
                    }
                    if ($ped->comentario_cancelacion == null && $ped->aprob_compras == 0 && $ped->aprob_gerencia == 0) {
                        $review = $ped->catLastReview();
                        if ($review == 0) {
                            $nR0++;
                        } else if ($review == 7) {
                            $nR7++;
                        } else if ($review == 30) {
                            $nR30++;
                        } else if ($review == 60) {
                            $nR60++;
                        } else if ($arrival == 90) {
                            $nR90++;
                        } else if ($review == 100) {
                            $nR100++;
                        }
                    }

                    if ($ped->getTipoId() == 23) {
                        $nCp += $ped->getNumItem(2);
                    }


                }
                $temp['emit0'] = $nE0;
                $temp['emit7'] = $nE7;
                $temp['emit30'] = $nE30;
                $temp['emit60'] = $nE60;
                $temp['emit90'] = $nE90;
                $temp['emit100'] = $nE100;

                $temp['review0'] = $nE0;
                $temp['review7'] = $nE7;
                $temp['review30'] = $nE30;
                $temp['review60'] = $nE60;
                $temp['review90'] = $nE90;
                $temp['review100'] = $nE100;


                $temp['contraPedido'] = $nCp;
                $data[] = $temp;
            }

        }

        return $data;
    }

    /**
     * traue a los provedores
     */
    public function getProvider(Request $req)
    {
        $rawn = "id, razon_social ,contrapedido,(select sum(monto)
         from tbl_proveedor as proveedor inner join tbl_compra_orden on proveedor.id = tbl_compra_orden.prov_id
         where tbl_compra_orden.prov_id = tbl_proveedor.id and tbl_compra_orden.deleted_at is null  ) as deuda";

        $rawn .= " , (" . $this->generateProviderEmit("emision", "<=0") . ") as emit0 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 1 and  7 ") . ") as emit7 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 7 and  30 ") . ") as emit30 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 31 and  60 ") . ") as emit60 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " BETWEEN 61 and  90 ") . ") as emit90 ";
        $rawn .= " , (" . $this->generateProviderEmit("emision", " > 90 ") . ") as emit100 ";

        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", "<=0") . ") as review0 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 1 and  7 ") . ") as review7 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 7 and  30 ") . ") as review30 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 31 and  60 ") . ") as review60 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " BETWEEN 61 and  90 ") . ") as review90 ";
        $rawn .= " , (" . $this->generateProviderQuery("ult_revision", " > 90 ") . ") as review100 ";
        $prov = Provider::selectRaw($rawn)->where('id', $req->id)->first();


        return $prov;
    }


    public function getAddressrPort(Request $req)
    {
        return (!$req->has('id')) ? ProviderAddress::findOrfail($req->direccion_id)->ports()->get() : Ports::where('id', $req->id)->get();

    }

    /**
     * @see
     * regresa la lista de docuemnts segun id del provedor
     */
    public function getProviderListOrder(Request $req)
    {
        $prov = Provider::findOrFail($req->id);

        $docs = Collection::make(array());


        $solic = $prov->solicitude();
        $odc = $prov->purchase();
        $order = $prov->Order();
        /**
         * Aquellos que han sido asignados a otros documentos se marcan como disponibles 0 (No disponibles para asignacion)
         * en caso contrario se marcan como disponibles 1 (disponibles para asignacion)
         */
        if(!$req->has('all')|| !$req->all){
            $solic = $prov->solicitude()->where('disponible', 1);
            $odc = $prov->purchase()->where('disponible', 1);
            $order = $prov->Order()->where('disponible', 1);
        }

        if ($this->user->cargo_id == $this->profile['trabajador']) {
            $solic = $solic->where('usuario_id', $req->session()->get('DATAUSER')['id']);
            $odc = $odc->where('usuario_id', $req->session()->get('DATAUSER')['id']);
            $order = $odc->where('usuario_id', $req->session()->get('DATAUSER')['id']);
        }

        $docs->push($solic->get());
        $docs->push($odc->get());
        $docs->push($order->get());
        $docs = $docs->collapse();


        $data = Array();
        $items = $docs;
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad = OrderPriority::get();
        $estados = OrderStatus::get();
        $paises = Country::get();
        foreach ($items as $aux) {
            //para maquinas

            $aux['proveedor'] = $prov->razon_social;
            $aux['documento'] = $aux->getTipo();
            $aux['tipo'] = $aux->getTipoId();
            $aux['diasEmit'] = $aux->daysCreate();
            $aux['estado'] = $estados->where('id', $aux->estado_id)->first()->estado;


            if ($aux->motivo_id) {
                $aux['motivo'] = $motivo->where('id', $aux->motivo_id)->first()->motivo;
            }
            if ($aux->pais_id) {
                $aux['pais'] = $paises->where('id', $aux->pais_id)->first()->short_name;
            }
            if ($aux->prioridad_id) {
                $aux['prioridad'] = $prioridad->where('id', $aux->prioridad_id)->first()->descripcion;
            }
            if ($aux->prov_moneda_id) {
                $aux['moneda'] = $coin->where('id', $aux->prov_moneda_id)->first()->nombre;
            }
            if ($aux->prov_moneda_id) {
                $aux['symbol'] = $coin->where('id', $aux->prov_moneda_id)->first()->simbolo;
            }
            if ($aux->tipo_id != null) {
                $aux['tipo'] = $type->where('id', $aux->tipo_id)->first()->tipo;
            }


           // $tem['productos'] = $this->getProductoItem($aux);


            /**actualizar cuando este el final**/
            $tem['almacen'] = "Desconocido";

            // TODO modificar cuando se sepa la logica
          /*  $tem['aero'] = 1;
            $tem['version'] = 1;
            $tem['maritimo'] = 1;
          */
            $data[] = $aux;
        }
        //print_r($data);

        /*$data = DB::select("SELECT * FROM view_compras_docs AS docs WHERE docs.prov_id = ".$req->id);
        foreach ($data as $key => $val) {
            foreach ($val as $k => $v) {
                if(gettype($k)== "integer"){
                    unset($data[$key][$k]);
                }
            };
        };*/
        return $data;

    }

    public function getProviderContacts(Request $req)
    {
        $resut = [];
        $lang = Collection::make([]);
        $contacts = Provider::findOrFail($req->prov_id)->contacts()->get();
        $es = Language::findOrFail(27);
        $en = Language::findOrFail(186);
        $eval = [];

        $default = $es;

        foreach ($contacts as $contc) {
            $eml['nombre'] = $contc->nombre;
            $eml['id'] = $contc->id;
            $eml['email'] = $contc->campos()->where('campo', 'email')->get();
            $ls = $contc->idiomas()->get();
            $eml['idiomas'] = $ls;

            foreach ($ls as $l) {
                $eval[] = $l;
                if (array_key_exists($l->iso_lang, $this->emailTemplate['ProviderEstimate'])) {
                } else {
                    if (strpos($l->iso_lang, 'es')) {
                        $lang->push($es);
                    } else {
                        $lang->push($en);
                        $default = $en;
                    }
                }
            }
            $resut[] = $eml;
        }

        return ['contactos' => $resut, 'idiomas' => $lang->unique()->values(), 'default' => $default, 'eval' => $eval, 'all' => $lang];
    }

    /*********************** GENERICOS ************************/
    public function getDocument(Request $req){
        $model = $this->getDocumentIntance($req->tipo);
        $model = $model->findOrFail($req->id);
        $prov= Provider::find($model->prov_id);
        $objs =[];
        //para maquinas
        $tem = array();
        $tem['id']=$model->id;
        $tem['tipo']=$model->getTipoId();
        $tem['pais_id']=$model->pais_id;
        $tem['fecha_envio']=$model->fecha_envio;
        $tem['puerto_id']=$model->puerto_id;
        $tem['final_id']=$model->final_id;
        $tem['direccion_almacen_id']=$model->direccion_almacen_id;
        $tem['direccion_facturacion_id']=$model->direccion_facturacion_id;
        $tem['prov_id']=$model->prov_id;
        $tem['condicion_pago_id']=$model->condicion_pago_id;
        $tem['motivo_pedido_id']=$model->motivo_pedido_id;
        $tem['prioridad_id']=$model->prioridad_id;
        $tem['condicion_pedido_id']=$model->condicion_pedido_id;
        $tem['prov_moneda_id']=$model->prov_moneda_id;
        $tem['estado_id']=$model->estado_id;
        $tem['doc_parent_id']=$model->doc_parent_id;
        $tem['doc_parent_origen_id']=$model->doc_parent_origen_id;
        $tem['uid']=$model->uid;
        // pra humanos
        $tem['comentario']=$model->comentario;
        $tem['tasa']=$model->tasa;
        $tem['proveedor']=($prov != null)? $prov->razon_social: '';
        $tem['documento']= $model->type;
        $tem['titulo']= $model->titulo;
        $tem['diasEmit']=$model->daysCreate();
        $tem['fecha_aprob_compra'] =$model->fecha_aprob_compra ;
        $tem['fecha_aprob_gerencia'] =$model->fecha_aprob_gerencia ;
        $tem['img_aprob'] =$model->fecha_aprob_compra ;
        $tem['isAprobado'] = ($model->fecha_aprob_compra != null || $model->fecha_aprob_gerencia != null);
        $tem['aprobado'] = ['nro_doc'=>$model->nro_doc,'adjs'=>[]];
        $tem['condicion_cp'] =$model->condicion_cp ;
        $tem['pago_factura_id'] =$model->pago_factura_id ;

        $tem['estado']=OrderStatus::findOrFail($model->estado_id)->estado;

        if($model->motivo_id){
            $tem['motivo']=OrderReason::findOrFail($model->motivo_id)->motivo;
        }
        if($model->pais_id){
            $tem['pais']=Country::findOrFail($model->pais_id)->short_name;
        }
        if($model->prioridad_id){
            $tem['prioridad']=OrderPriority::findOrFail($model->prioridad_id)->descripcion;
        }

        if($model->prov_moneda_id){
            $mone=Monedas::findOrFail($model->prov_moneda_id);
            $tem['moneda']=$mone->nombre;
            $tem['symbol']=$mone->simbolo;

        }

        if($model->tipo_id != null){
            $tem['tipo']= OrderType::findOrFail($model->tipo_id)->tipo;
        }

        $tem['nro_proforma']= ['doc'=>$model->nro_proforma, 'adjs'=>[]];
        $tem['nro_factura']= ['doc'=>$model->nro_factura, 'adjs'=>[]];
        $tem['nro_doc']=$model->nro_doc;
        $tem['img_proforma']=$model->img_proforma;
        $tem['img_factura']=$model->img_factura;
        $tem['mt3']=$model->mt3;
        $tem['peso']=$model->peso;
        $tem['emision']=$model->emision;
        $tem['usuario_id']=$model->usuario_id;
        $tem['monto']=$model->monto;
        $tem['productos'] =$this->getProductoItem($model);
        $objs['prov_id']=$prov;
        $objs['prov_moneda_id'] = Monedas::find($model->prov_moneda_id);
        $objs['direccion_facturacion_id'] = ProviderAddress::find($model->direccion_facturacion_id);
        $objs['direccion_almacen_id'] = ProviderAddress::find($model->direccion_almacen_id);
        $objs['pais_id'] = Country::find($model->pais_id);
        $objs['condicion_pago_id'] =  ProviderCondPay::find($model->condicion_pago_id);
        $objs['puerto_id'] = Ports::find($model->puerto_id);
        /**actualizar cuando este el final**/
        $tem['almacen']="Desconocido";

        // modificar cuando se sepa la logica
        $tem['aero']=1;
        $tem['version']=$model->version;
        $tem['maritimo']=1;
        $atts = array();


        foreach($model->attachments()->where('documento','PROFORMA')->get() as $aux){
            $att = attachment_file($aux->archivo_id);
            foreach ($att as $key => $value){
                $att[$key]= $value;
            }
            $tem['nro_proforma']['adjs'] = $att;
        }
        foreach($model->attachments()->where('documento','FACTURA')->get() as $aux){
            $att = attachment_file($aux->archivo_id);
            foreach ($att as $key => $value){
                $att[$key]= $value;
            }
            $tem['nro_factura']['adjs'] = $att;
        }
        foreach($model->attachments()->whereRaw('documento like \'ap_%\'')->get() as $aux){
            $att = attachment_file($aux->archivo_id);
            foreach ($att as $key => $value){
                $att[$key]= $value;
            }
            $tem['Aprobado']['adjs'] = $att;
        }
        $tem['adjuntos'] = $atts;

        $tem['objs']=$objs;

        $tem['permit'] = $this->getPermisionDoc($model);



        return $tem;

    }
    /*********************** PRODUCTOS ************************/
    public function getProviderProducts(Request $req)
    {
        $data = array();
        $items = Provider::findOrFail($req->id)
            ->proveedor_product()
            ->where('tipo_producto_id', '<>', 3)
            ->get();

        $model = $this->getDocumentIntance($req->tipo);
        $model = $model->findOrFail($req->doc_id);
        $modelIts = $model->items()->where('tipo_origen_id', '1')->get();

        foreach ($items as $aux) {
            try{

                $aux->puntoCompra = false;
                $aux->cantidad = 0;
                $aux->saldo = 0;
                $aux->asignado = false;
                $itMo = $modelIts->where('producto_id', $aux->id)->first();
                $aux->otre = $itMo;
                $aux->descripcion = ($aux->descripcion == null || $aux->descripcion == '') ? $aux->descripcion_profit : $aux->descripcion;

                if ($itMo != null) {
                    $aux->asignado = true;
                    $aux->saldo = $itMo->saldo;
                    $aux->cantidad = $itMo->cantidad;

                    $aux->reng_id = $itMo->id;
                    $aux->costo_unitario = $itMo->costo_unitario;
                    $aux->uid = $itMo->uid;

                }
                $data[] = $aux;

        }
        catch (\Exception $e){
            dd($aux);
        }
        }


        return $data;

    }

    /**
     * crea un producto temporarl
     */
    public function createTemp(Request $req)
    {
        $prodTemp = MasterProductController::createProduct($req->all(),"pedidos");
        $temp = array();
        $temp['id'] = $prodTemp->id;
        $temp['descripcion'] = $prodTemp->descripcion;
        $temp['codigo'] = $prodTemp->codigo;
        $temp['codigo_fabrica'] = $prodTemp->codigo_fabrica;
        $temp['puntoCompra'] = false;
        $temp['cantidad'] = 0;
        $temp['saldo'] = 0;


        $temp['stock'] = 0;
        $temp['tipo_producto_id'] = $prodTemp->tipo_producto_id;
        $temp['tipo_producto'] = ProductType::findOrFail($prodTemp->tipo_producto_id)->descripcion;
        $temp['asignado'] = false;
        if ($prodTemp->descripcion == null) {
            $temp['descripcion'] = "Profit " . $prodTemp->descripcion_profit;
        }
        if ($req->has('saldo')) {
            $temp['cantidad'] = $req->saldo;
            $temp['saldo'] = $req->saldo;
        }


        return $prodTemp;
    }

    /**************************************************************SOLICITUD**************************************************************/

    /**** SOLICITUD GET *********/

    /**
     * obtiene todos las solicitudes que son sustituibles
     **/
    public function getSolicitudeSubstitutes(Request $req)
    {
        $data =Collection::make(array());
        $model = Solicitude::findOrFail($req->doc_id);
        $items = Solicitude::where('id','<>', $req->doc_id)
            ->where('prov_id', $req->prov_id)
            ->WhereNull('fecha_sustitucion')
            ->get();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad = OrderPriority::get();
        $estados = OrderStatus::get();
        $paises = Country::get();

        foreach($items as $aux){
            $aux->asignado =false;
            $data->push($aux);

        }
        foreach ($model->items()->where('tipo_origen_id','22')->get() as $aux){
            if(!$data->contains($aux->doc_origen_id)){
                $doc = Solicitude::findOrFail($aux->doc_origen_id);
                $doc->asignado =true;
                $data->push($doc);
            }

        }
        foreach($data as $aux){
            $aux['documento'] = $aux->getTipo();
            $aux['diasEmit'] = $aux->daysCreate();
            $aux['estado'] = $estados->where('id', $aux->estado_id)->first()->estado;

            if ($aux->motivo_id) {
                $aux['motivo'] = $motivo->where('id', $aux->motivo_id)->first()->motivo;
            }
            if ($aux->pais_id) {
                $aux['pais'] = $paises->where('id', $aux->pais_id)->first()->short_name;
            }
            if ($aux->prioridad_id) {
                $aux['prioridad'] = $prioridad->where('id', $aux->prioridad_id)->first()->descripcion;
            }
            if ($aux->prov_moneda_id) {
                $aux['moneda'] = $coin->where('id', $aux->prov_moneda_id)->first()->nombre;
            }
            if ($aux->prov_moneda_id) {
                $aux['symbol'] = $coin->where('id', $aux->prov_moneda_id)->first()->simbolo;
            }
            if ($aux->tipo_id != null) {
                $aux['tipo'] = $type->where('id', $aux->tipo_id)->first()->tipo;
            }
        }        return $data;
    }

    /**
     * obtiene las versones anterioriores de la solictuc
     */
    public function getOldSolicitude(Request $req){
        $model = Solicitude::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $data = [];
        $olds = Solicitude::where('id','<>', $model->id)
            ->where('uid', $model->uid)
            ->get();

        foreach ($olds as $aux){
            $aux->proveedor = $prov->razon_social;
            $aux->tipo = $aux->getTipoId();
            $data[] = $aux;
        }
        return $olds;
    }

    /**
     * contrulle el resumen preliminar de la solicitud
     */
    public function getSolicitudeSummary(Request $req){
        $data = array();
        $prod = array();
        $model= Solicitude::findOrFail($req->id);
        $provProd = Product::where('prov_id',$model->prov_id)->get();
        $items =$model->items()->get();
        foreach($items as $aux){
            $p= $provProd->where('id',$aux->producto_id)->first();
            if($p != null){
                $aux['codigo']=$p->codigo;
                $aux['codigo_fabrica']=$p->codigo_fabrica;
            }
            $prod[]= $aux;
        }


        //$data['adjuntos']= $atts;
        $data['productos']= $prod;

        return $data;
    }

    /**
     * obitene las plantillas par el envio del correo al proveedor
     */
    public function getProviderSolicitudeTemplate(Request $req)
    {
        $model = Solicitude::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'texto'=>$content['contents']->first(),
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Solicitude', 'toProviders', $fn)['good']];

        $model->comentario_cancelacion = 'ddd';
        $correos = [];
        $to = [];
        foreach ($prov->contacts()->get() as  $aux){
            foreach ($aux->campos()->where('campo', 'email')->get() as $aux2){
                $e =  ['nombre'=>$aux->nombre, 'correo'=>$aux2->valor];
                $e['langs'] = array_map('strtolower', $aux->idiomas()->lists('iso_lang')->toarray());
                $correos[] =$e ;
                if($aux->pivot->default == 1){
                    $to[] = $e;
                }
            }

        }
        $data['correos'] = $correos;
        $data['to'] = $to;
        return $data;


    }

    /**
     * obtiens las plantillas para envio interno de informacion
     */
    public function getInternalSolicitudeTemplate (Request $req){
        $model = Solicitude::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'texto'=>$content['contents']->first(),
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Solicitude', 'created', $fn)['good']];

        $correos = [];



        foreach (User::get() as  $aux){
            $correos[] = ['nombre'=>$aux->nombre,'correo'=>$aux->email, 'langs'=>['es']];
        }
        $data['correos'] = $correos;
        return $data;
    }

    /**
     * obtiens las plantillas para envio interno de informacion
     */
    public function getCancelSolicitudeTemplate (Request $req){
        $model = Solicitude::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Solicitude', 'cancel', $fn)['good']];

        $correos = [];
        $to = [];

        foreach ($prov->contacts()->get() as  $aux){
            foreach ($aux->campos()->where('campo', 'email')->get() as $aux2){
                $e =  ['nombre'=>$aux->nombre, 'correo'=>$aux2->valor];
                $e['langs'] = array_map('strtolower', $aux->idiomas()->lists('iso_lang')->toarray());
                $correos[] =$e ;
                if($aux->pivot->default == 1){
                    $to[] = $e;
                }
            }

        }

        $data['correos'] = $correos;
        $data['to'] = $to;
        return $data;
    }

    /**
     * obtiene las respuesta a un provedor
     **/
    public function getAnswerdsSolicitude(Request $req){
        $model = Solicitude::findOrFail($req->id);
        $resul = [];

        foreach ($model->answerds()->get() as $aux){
            $aux->adjs = $aux->attachments()->lists('archivo_id');
            $resul[] = $aux;
        }


        return  $resul;

    }


    /**** SOLICITUD POST ********/

    /**
     * gurada la solicitud
     */
    public function saveSolicitude(Request $req)
    {

        $result = [];
        $result["action"] = "new";
        $model = new Solicitude();
        $uid = null;

        if ($req->has('id')) {
            $model = $model->findOrFail($req->id);
            $result["action"] = "edit";
        }
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'titulo' => 'required',
            'tasa' => 'required',
            'prov_moneda_id' => 'required'

        ]);
        if ($validator->fails()) {
            $result = array("error" => "errores en campos de formulario");
            if ($model->uid == null) {
                $model->uid = uniqid('', true);
            }

        } else {
            $result['success'] = "Registro guardado con éxito";

        }
        $model = $this->setDocItem($model, $req);
        $model->save();
        $result['id'] = $model->id;
        $result['user'] = $model->usuario_id;
        $result['uid'] = $model->uid;
        return $result;

    }

    /**
     * agrega un producto a la solicitud
     */
    public function saveSolicitudItemProduc(Request $req)
    {
        $resul['accion'] = "new";
        $model = new SolicitudeItem();
        if ($req->has('reng_id')) {
            $model = SolicitudeItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
        }
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $req->id;

        $model->doc_origen_id = $req->has('doc_origen_id') ? $req->doc_origen_id : null;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;
        $model->unidad_compra_id = $req->has('uni_producto') ? $req->uni_producto : null;
        $model->producto_id = $req->producto_id;
        $model->descripcion = $req->descripcion;
        $model->uid = $req->has('uid') ? $req->uid : uniqid('', true);


        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }

        $resul['response'] = $model->save();
        $resul['reng_id'] = $model->id;
        $resul['cantidad'] = $model->cantidad;
        $resul['saldo'] = $model->saldo;

        return $resul;
    }

    /**
     *elimina el producto de la solcitud
     **/
    public function DeleteSolicitudItemProduc(Request $req)
    {
        $result['accion'] = 'del';
        $result['response'] = SolicitudeItem::destroy($req->id);
        $result['id'] = $req->id;
        return $result;
    }

    /**
     * agreaga el iten de cotnra pedido a la solicutud
     */
    public function saveSolicitudItemCustomOrder(Request $req)
    {
        $resul['accion'] = "new";
        $model = new SolicitudeItem();
        $co = App\Models\Sistema\CustomOrders\CustomOrderItem::findOrFail($req->origen_item_id);
        if ($req->has('reng_id')) {
            $model = SolicitudeItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
        }

        $model->tipo_origen_id = 2;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $co->id;
        $model->descripcion = $co->descripcion;
        $model->producto_id = $co->producto_id;
        $model->doc_origen_id = $co->doc_id;
        $model->uid = $co->uid;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;

        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }
        $model->save();

        $resul['reng_id'] = $model->id;
        $resul['disponible'] = floatval($co->saldo) + floatval($model->cantidad);
        $resul['inDoc'] = $co->cantidad;;
        $resul['inDocBlock'] = floatval($co->cantidad) - floatval($model->saldo);
        return $resul;
    }

    /**
     * elimina el contra pedido
     */
    public function DeleteSolicitudItemCustomOrder(Request $req)
    {
        $result['accion'] = 'del';
        $result['response'] = SolicitudeItem::destroy($req->id);
        $result['id'] = $req->id;
        return $result;
    }

    /**
     * coloca la solicutd en un estado sin finalizar
     */
    public function SolicitudeUpdate(Request $req)
    {
        $resul['action'] = "upd";
        $model = Solicitude::findOrFail($req->id);
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'titulo' => 'required',
            'tasa' => 'required',
            'prov_moneda_id' => 'required'

        ]);
        if ($validator->fails()) {
            $model->edit_usuario_id = $this->user->id;
            $model->final_id = null;
            $model->save();
        }else{
            $resul["action"] = "copy";
            $newItems = array();
            $newModel = new Solicitude();

            $newModel = $this->transferDataDoc($model, $newModel);
            $newModel->parent_id = $model->id;
            $newModel->version = $model->version + 1;
            $newModel->uid = $model->uid;
            $newModel->save();
            $model->cancelacion = Carbon::now();
            $model->comentario_cancelacion = "#sistema: copiado por new id#" . $newModel->id;
            $model->save();

            foreach ($model->items()->get() as $aux) {
                $it = new  SolicitudeItem();
                $it->tipo_origen_id = $aux->tipo_origen_id;
                $it->doc_id = $newModel->id;
                $it->origen_item_id = $aux->origen_item_id;
                $it->doc_origen_id = $aux->doc_origen_id;
                $it->cantidad = $aux->cantidad;
                $it->saldo = $aux->saldo;
                $it->producto_id = $aux->producto_id;
                $it->descripcion = $aux->descripcion;
                $it->costo_unitario = $aux->costo_unitario;
                $it->save();
                $newItems[] = $it;

            }

            $resul['id'] = $newModel->id;
            $resul['doc'] = $newModel;
            $resul['oldItems'] = $newItems;
        }


        return $resul;
    }

    /**
     * guarda el item de la solcicitud
     */
    public function ChangeItemSolicitude(Request $req){
        $resul['accion']= "upd";
        $model = SolicitudeItem::findOrFail($req->id);

        $model->tipo_origen_id = ($req->has('tipo_origen_id')) ? $req->tipo_origen_id : null;
        $model->doc_id = ($req->has('doc_id')) ? $req->doc_id : null;
        $model->origen_item_id = ($req->has('origen_item_id')) ? $req->origen_item_id : null;
        $model->doc_origen_id = ($req->has('doc_origen_id')) ? $req->doc_origen_id : null;
        $model->producto_id = ($req->has('producto_id')) ? $req->producto_id : null;
        $model->descripcion = ($req->has('descripcion')) ? $req->descripcion : null;
        $model->costo_unitario = ($req->has('costo_unitario')) ? $req->costo_unitario : null;
        if( $model->tipo_origen_id == '21' ){
            $prevI= SolicitudeItem::find($model->origen_item_id);
            if($prevI != null){
                $prevI->saldo = floatval($prevI->saldo ) + floatval($model->cantidad ) ;
                $prevI->saldo = floatval($prevI->saldo ) - floatval($req->saldo) ;
                $dif= floatval($model->saldo) - floatval($req->saldo);
                $model->saldo= floatval($model->saldo)  + $dif;

                $prevI->save();
                $prevI->save();
                $resul['data'] = ['old'=>$prevI, 'moel'=>$model];
                $doc =  $prevI->document;
                $doc->disponible=1;
                $doc->save();
            }
        }else{
            $model->cantidad = ($req->has('cantidad')) ? $req->cantidad : null;
            $model->saldo = ($req->has('saldo')) ? $req->saldo : null;
            $model->uid = ($req->has('uid')) ? $req->uid : uid('', true);
        }



        $resul['response']=$model->save();
        $resul['id']=$model->id;
        $resul['model']=$model;
        return $resul;
    }

    /**
     * elimina un item de la solicitud
     */
    public function DeleteItemSolicitude(Request $req){
        $resul= ['accion'=>'del'];
        $model = SolicitudeItem::find($req->id);

        if( $model->tipo_origen_id == '21' ){
            $prevI= SolicitudeItem::find($model->origen_item_id);
            if($prevI != null){
                $prevI->saldo = floatval($prevI->saldo ) + floatval($model->cantidad);
                $prevI->save();
                $doc =  $prevI->document;
                $doc->disponible=1;
                $doc->save();
            }
        }
        $resul['response']= $model->destroy($model->id);
        return $resul;

    }

    /**
     * regresa a la solicud anterior
     **/
    public function restoreSolicitude(Request $req){
        $resul = array();
        $princi = Solicitude::findOrFail($req->princ_id);
        $reemplaze = Solicitude::findOrFail($req->reemplace_id);
        $model = new Solicitude();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);

        $princi->version = ($princi->parent_id == null) ? $princi->version + 1 : $princi->version;
        $princi->parent_id = $reemplaze->id;


        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->uid= $princi->uid;


        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();
        $reemplaze->ult_revision= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $model->ult_revision= Carbon::now();

        $princi->disponible= 0;
        $reemplaze->disponible= 0;

        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new SolicitudeItem();
            $newItem->tipo_origen_id = $oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->cantidad; // precaucion el inten se restaura con la cantidad original
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newIts[] = $newItem;
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    /**
     * restaura un item eliminado con softdelete
     */
    public function restoreItemSolicitude(Request $req){
        $resul= ['accion'=>'restore'];
        $model = SolicitudeItem::withTrashed()->where('id',$req->id )->first();
        $resul['response']= $model->restore();
        if( $model->tipo_origen_id == '21' ){
            $prevI= SolicitudeItem::find($model->origen_item_id);
            if($prevI != null){
                $prevI->saldo = floatval($prevI->saldo ) - floatval($model->cantidad);
                $prevI->save();
                $doc =  $prevI->document;
                if($doc->items()->sum('saldo') == 0){
                    $doc->disponible = 0;
                    $doc->save();
                }
            }

        }
        return $resul;
    }


    /**
     * asigna el contra pedido
     *
     **/
    public function addCustomOrderSolicitud(Request $req)
    {

        $model = CustomOrder::findOrFail($req->id);
        $items = $model->CustomOrderItem()->get();
        $resul = array();
        $resul['action'] = "new";
        $newItems = array();
        $oldItems = array();
        $doc = Solicitude::findOrFail($req->doc_id);

        $docItms = $doc->items()->where("tipo_origen_id", 2)->get();
        foreach ($items as $aux) {
            if (
                sizeof($docItms->where('origen_item_id', $aux->id)->where('doc_origen_id', $req->id)) == 0
            ) {
                $item = $doc->newItem();
                $item->tipo_origen_id = 2;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id = $aux->id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->descripcion = $aux->descripcion;
                $item->producto_id = $aux->producto_id;
                $item->doc_origen_id = $model->id;
                $item->uid = $aux->uid;
                $oldItems[] = $aux;
                $newItems[] = $item;
            }
        }
        $resul['newitems'] = $newItems;
        $resul['oldItems'] = $oldItems;
        $doc->items()->saveMany($newItems);
        return $resul;
    }

    /**
     * remueve el contra pedido de la solictud
     **/
    public function RemoveCustomOrderSolicitud(Request $req)
    {
        $resul["accion"] = "del";
        $model = SolicitudeItem::where('doc_origen_id', $req->id)
            ->where('doc_id', $req->doc_id)
            ->where('tipo_origen_id', 2)
            ->get();
        $ids = array();

        foreach ($model as $aux) {
            $ids[] = $aux->id;
        }

        SolicitudeItem::destroy($ids);
        $resul["keys"] = $ids;
        return $resul;

    }


    /**
     * asigna un kitchenbox a un pedido
     **/
    public function addkitchenBoxSolicitude(Request $req)
    {
        $doc = Solicitude::findOrFail($req->doc_id);
        $k = KitchenBox::findOrFail($req->id);
        $item = new SolicitudeItem();
        $resul['action'] = "new";
        if ($req->has('reng_id')) {
            $resul['action'] = 'upd';
            $item = SolicitudeItem::findOrFail($req->reng_id);
        }
        $item->tipo_origen_id = 3;
        $item->doc_id = $req->doc_id;
        $item->origen_item_id = $k->id;
        $item->cantidad = 1;
        $item->saldo = 1;
        $item->descripcion = $req->has('descripcion') ? $req->descripcion : $k->titulo;
        $item->producto_id = $k->producto_id;
        $item->uid = $req->uid;
        $item->costo_unitario = $req->costo_unitario;
        $item->doc_origen_id = $k->id;/// reemplazr cuando se sepa la logica
        $resul['response'] = $item->save();
        $resul['item'] = $item;
        return $resul;
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBoxSolicitude(Request $req)
    {
        $resul["accion"] = "del";
        $model = SolicitudeItem::findOrFail($req->id);
        SolicitudeItem::destroy($model->id);
        $resul["id"] = $req->id;
        return $resul;
    }

    /**
     *aprueba la solicutud dependiendo del usuario logeado
     */
    public function ApprovedSolicitude(Request $req)
    {

        $result = [];
        $model = Solicitude::findOrFail($req->id);

        if($this->user->cargo_id == '6' || $this->user->cargo_id == '8'){
            $model->fecha_aprob_gerencia= $req->fecha;
            $model->nro_doc = $req->nro_doc;
            $result['accion']='ap_gerencia';
            $result['fecha'] = $model->fecha_aprob_gerencia;
        }else{
            $model->fecha_aprob_compra = $req->fecha;
            $result['fecha'] = $model->fecha_aprob_compra;
            $model->nro_doc = $req->nro_doc;
            $result['accion']='ap_compras';

        }
        if($req->has("adjs")){

            foreach($req->adjs as $aux){
                $adj= new SolicitudeAttachment();
                $adj->doc_id = $model->id;
                $adj->archivo_id = $aux['id'];
                $adj->documento = $result['accion'];
                $adj->save();
                $att[] = $adj;

            }
        }
        $model->save();

        $result['nro_doc'] = $model->nro_doc;
        $result['response'] = $model->save();
        return $result;

    }

    /**
     * cancela la solcitud
     **/
    public function cancelSolicitude(Request $req)
    {

        $response = [];
        $model = Solicitude::findOrFail($req->id);

        $model->comentario_cancelacion = $req->comentario;
        $model->final_id = $this->getFinalId($model);
        $model->disponible = 0;
        $response['response'] = $model->save();

        $response['accion'] = $model->comentario_cancelacion == null ? 'new' : 'upd';
        $response['success'] = 'Solicitud Cancelada';

        $mail = new MailModule();
        $mail->doc_id = $model->id;
        $mail->tipo_origen_id = 21;
        $mail->asunto =$req->has('subject') ? $req->subject : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'solicitude';
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto];
        $mail->clave= "cancel";
        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){
            foreach ($req->adjs as $f){
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }
        }

        $resul['email'] = $mail->sendMail($req->content, $destinations);


        return $response;

    }


    /**
     * determina la accion a realizar dependiendo de los permisos de usuario he estado de la solictud
     **/
    public function closeActionSolicitude(Request $req)
    {
        $model = Solicitude::findOrFail($req->id);

        $result =[];
        $result['actions'] = ['sendPrv','save'];
        $senders =MailModule::where('tipo_origen_id','21')
            ->where('doc_id',$model->id)
            ->where('tipo','user')
            ->get();
        $result['send']= sizeof($senders);
        return $result;
    }

    /**
     * cierra la solicitud
     */
    public function CloseSolicitude(Request $req)
    {
        $result['success'] = "Registro guardado con éxito!";
        $result['action'][] = "close";
        $model = Solicitude::findOrFail($req->id);
        $model->ult_revision = Carbon::now();
        $model->final_id = $this->getFinalId($model);

        $model->save();
        return ['id'=>$req->id];
    }


    /**
     * agrega adjuntos a la solicutd
     **/
    public function addAttachmentsSolicitude(Request $req)
    {
        $model = Solicitude::findOrFail($req->id);
        $resul = [ 'size' => sizeof($req->adjs) ,'files'=>[]];
        foreach ($req->adjs as $aux) {
            if(!array_key_exists('id',$aux )){
                $attac = new SolicitudeAttachment();
                $attac->archivo_id = $aux['archivo_id'];
                $attac->doc_id = $model->id;
                $attac->documento = strtoupper($aux['documento']);
                $attac->save();

                $file= attachment_file($aux['archivo_id']);
                foreach ($file as $key => $value){
                    $attac[$key]= $value;
                }
                $resul['files'][]=$attac;
            }
        }


        return $resul;
    }

    /**
     *  envia la solictud
     */
    public function sendSolicitude(Request $req){
        $resul = ['action'=>'send'];
        $model = Solicitude::findOrFail($req->id);
        $sends =MailModule::where('tipo_origen_id','21')
            ->where('doc_id',$model->id)
            ->where('tipo','user')
            ->whereNotNull('send')
            ->get();
        $mail = new MailModule();
        $mail->doc_id = $model->id;
        $mail->tipo_origen_id = 21;
        $mail->asunto =$req->has('subject') ? $req->subject : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'solicitude';
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto];
        if(sizeof($sends) == 0){
            $mail->clave= 'created';
        }
        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){
            foreach ($req->adjs as $f){
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }
        }

        $resul['email'] = $mail->sendMail($req->content, $destinations);
        if(!$resul['email']['is']){
            $model->final_id= null;

        }else{
            $model->ult_revision = Carbon::now();
            $model->final_id = $this->getFinalId($model);

            /** envio de notificaciones **/
            $options = $this->templateNotif($model, 'emails.Solicitude.internalManager.es','solicitude','sendPrv');

            $options['atts'][]= ['data'=>$resul['email']['attOff']['data'],'nombre'=>$model->id.'_A_Proveedor.pdf'];
            $dest = $this->geUsersEMail('tbl_cargo.id = '.$this->profile['gerente_adm']);
            $resul['email']['attOff'] ='';
            $options['to'] = $dest;
            $mail = new MailModule();
            $mail->doc_id = $model->id;
            $mail->tipo_origen_id = 21;
            $mail->asunto =$options['subject'];
            $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
            $mail->tipo = 'sis';
            $mail->modulo = 'solicitude';
            $mail->save();
            $resul['nofs']=  $mail->sendMail($options['template'], $options);

        }
        $model->save();
        return $resul;
    }


    /**
     * regresa a la solictud anterior
     **/
    public function AddAnswerSolicitude(Request $req){
        $response =[];
        $att =[];
        $doc= Solicitude::findOrFail($req->id);
        $model = new SolicitudeAnswer();
        $model->descripcion = $req->descripcion;
        $model->doc_id= $req->id;
        $model->save();

        $doc->ult_revision  = Carbon::now();
        $doc->save();
        $response['accion']= "new";
        if($req->has("adjs")){

            foreach($req->adjs as $aux){
                $adj= new SolicitudeAnswerAttachment();
                $adj->doc_id = $doc->id;
                $adj->archivo_id = $aux['id'];
                $adj->save();
                $att[] = $adj;

            }
        }
        $model = SolicitudeAnswer::findOrFail($model->id);
        $model->adjs =  $model->attachments()->lists('archivo_id');
        $response['id']=$model->id;
        $response['doc_id']=$model->doc_id;
        $response['model']=$model;
        $response['data']=$model;
        $response['items']=$att;
        return $response;

    }


    /**
     * agrega la solicitud al nuevo documento
     * marca
     */
    public  function  addSustituteSolicitude(Request $req){
        $resul = array();
        $princi = Solicitude::findOrFail($req->princ_id);
        $reemplaze = Solicitude::findOrFail($req->reemplace_id);
        $model = new Solicitude();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);


        $princi->version = ($princi->parent_id == null) ? $princi->version + 1 : $princi->version;
        $princi->parent_id = $reemplaze->id;


        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;

        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();
        $reemplaze->ult_revision= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $model->ult_revision= Carbon::now();

        $princi->disponible= 0;
        $reemplaze->disponible= 0;

        $princi->uid = $reemplaze->uid;
        $model->uid = $reemplaze->uid;
        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($princi->items()->get() as $oldItem){
            $newItem = new SolicitudeItem();
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newItem->uid =$oldItem->uid;
            $newIts[] = $newItem;
            $oldItem->saldo = 0;
            $oldItem->save();

        }
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new SolicitudeItem();
            $newItem->tipo_origen_id =21;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$reemplaze->id;
            $newItem->cantidad =$oldItem->saldo;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newItem->uid =$oldItem->uid;

            $newIts[] = $newItem;
            $oldItem->saldo = 0;
            $oldItem->save();
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;

    }

    /**
     * remueve la solicitud al documento
     */
    public function removeSustiteSolicitude(Request $req){
        $resul = array();
        $princi = Solicitude::findOrFail($req->princ_id);
        $reemplaze = Solicitude::findOrFail($req->reemplace_id);

        ///dd($princi);
        $model = new Solicitude();
        $model = $this->transferDataDoc($princi,$model);
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->uid = $princi->uid;
        $princi->fecha_sustitucion= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $princi->disponible= 0;
        $princi->final_id= $this->getFinalId($princi);
        $princi->save();
        $model->save();
        $newIts= array();

        $import = $princi->items()->where( function ($query) use ($reemplaze) {
            $query->where('doc_origen_id','<>', $reemplaze->id)
                ->orWhereNull('doc_origen_id')
            ;
        })->get();

        foreach($import as $oldItem){
            $newItem = new SolicitudeItem();
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->uid =$oldItem->uid;
            $newItem->costo_unitario =$oldItem->costo_unitario;

            $newIts[] = $newItem;

            $oldItem->saldo = 0;
            $oldItem->save();
        }


        foreach($princi->items()->where('doc_origen_id', $reemplaze->id)->get() as $oldItem){
            $ri = $reemplaze->items()->where('id', $oldItem->origen_item_id)->first();
            $ri->saldo = $oldItem->cantidad;
            $oldItem->saldo = 0;
            $oldItem->save();
            $ri->save();
        }


        $resul['accion']= "inpor";
        $resul['id']= $model->id;
        $reemplaze->fecha_sustitucion=null;
        $reemplaze->final_id= $this->getFinalId($reemplaze);
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    /**
     * crea una copia del documento
     * @param id del documento a copiar
     * @param tipo de documento
     */
    public function copySolicitude(Request $req)
    {
        $resul["action"] = "copy";
        $newItems = array();
        $newModel = new Solicitude();
        $oldModel = Solicitude::findOrFail($req->id);

        $newModel = $this->transferDataDoc($oldModel, $newModel);
        $newModel->parent_id = $oldModel->id;
        $newModel->version = $oldModel->version + 1;
        $newModel->uid = $oldModel->uid;
        $newModel->save();
        $oldModel->cancelacion = Carbon::now();
        $oldModel->comentario_cancelacion = "#sistema: copiado por new id#" . $newModel->id;
        $oldModel->save();

        foreach ($oldModel->items()->get() as $aux) {
            $it = new  SolicitudeItem();
            $it->tipo_origen_id = $aux->tipo_origen_id;
            $it->doc_id = $newModel->id;
            $it->origen_item_id = $aux->origen_item_id;
            $it->doc_origen_id = $aux->doc_origen_id;
            $it->cantidad = $aux->cantidad;
            $it->saldo = $aux->saldo;
            $it->producto_id = $aux->producto_id;
            $it->descripcion = $aux->descripcion;
            $it->costo_unitario = $aux->costo_unitario;
            $it->save();
            $newItems[] = $it;

        }

        $resul['id'] = $newModel->id;
        $resul['doc'] = $newModel;
        $resul['oldItems'] = $newItems;
        return $resul;

    }

    /**
     * Asigna el parent a un pedido(proforma)
     */
    public function setParentSolicitude(Request $req){

        $resul = array();
        $model = Solicitude::findOrFail($req->princ_id);
        $model->doc_parent_id= $req->doc_parent_id;
        $model->doc_parent_origen_id= $req->doc_parent_origen_id;
        $model->save();
        $resul['accion']='upd';

        return $resul;
    }

    /************************************************************** FIN DE SOLICITUD **************************************************************/


    /************************************************************** PEDIDO O PROFORMA *************************************************************/
    /**** PEDIDO GET *********/

    public function getOrderSubstitutes(Request $req){
        $data = Collection::make(Array());

        $model = Order::findOrFail($req->doc_id);
        $items = Order::where('id','<>', $req->doc_id)
            ->where('prov_id', $req->prov_id)
            ->WhereNull('fecha_sustitucion')
            ->get();

        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();
        foreach($items as $aux){
            $aux->asignado =false;
            $data->push($aux);
        }
        foreach ($model->items()->where('tipo_origen_id','22')->get() as $aux){
            if(!$data->contains($aux->doc_origen_id)){
                $doc = Order::findOrFail($aux->doc_origen_id);
                $doc->asignado =true;
                $data->push($doc);

            }

        }
        foreach($data as $aux){
            $aux['documento'] = $aux->getTipo();
            $aux['diasEmit'] = $aux->daysCreate();
            $aux['estado'] = $estados->where('id', $aux->estado_id)->first()->estado;

            if ($aux->motivo_id) {
                $aux['motivo'] = $motivo->where('id', $aux->motivo_id)->first()->motivo;
            }
            if ($aux->pais_id) {
                $aux['pais'] = $paises->where('id', $aux->pais_id)->first()->short_name;
            }
            if ($aux->prioridad_id) {
                $aux['prioridad'] = $prioridad->where('id', $aux->prioridad_id)->first()->descripcion;
            }
            if ($aux->prov_moneda_id) {
                $aux['moneda'] = $coin->where('id', $aux->prov_moneda_id)->first()->nombre;
            }
            if ($aux->prov_moneda_id) {
                $aux['symbol'] = $coin->where('id', $aux->prov_moneda_id)->first()->simbolo;
            }
            if ($aux->tipo_id != null) {
                $aux['tipo'] = $type->where('id', $aux->tipo_id)->first()->tipo;
            }
        }
        return $data;
    }

    /**
     * obtiene las versionesa anteriores del documento
     */
    public function getOldOrden(Request $req){
        $model = Order::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $data = [];
        $olds = Order::where('id','<>', $model->id)
            ->where('uid', $model->uid)
            ->get();

        foreach ($olds as $aux){
            $aux->proveedor = $prov->razon_social;
            $aux->tipo = $aux->getTipoId();
            $data[] = $aux;
        }
        return $olds;
    }

    /**
     * construye el resumen preliminar del pedido
     */
    public function getOrderSummary(Request $req)
    {
        $data = array();
        $prod = array();
        $model= Order::findOrFail($req->id);
        $provProd = Product::where('prov_id',$model->prov_id)->get();
        $items =$model->items()->get();
        foreach($items as $aux){
            $p= $provProd->where('id',$aux->producto_id)->first();
            if($p != null){
                $aux['codigo']=$p->codigo;
                $aux['codigo_fabrica']=$p->codigo_fabrica;
            }
            $prod[]= $aux;
        }

        $data['productos']= $prod;

        return $data;
    }

    /**
     * obtiene las plantillas par el envio del correo al proveedor
     */
    public function getProviderOrderTemplate(Request $req)
    {
        $model = Order::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'texto'=>$content['contents']->first(),
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Order', 'toProviders', $fn)['good']];

        $correos = [];

        foreach ($prov->contacts()->get() as  $aux){
            foreach ($aux->campos()->where('campo', 'email')->get() as $aux2){
                $e =  ['nombre'=>$aux->nombre, 'correo'=>$aux2->valor];
                $e['langs'] = array_map('strtolower', $aux->idiomas()->lists('iso_lang')->toarray());
                $correos[] =$e ;
            }

        }
        $data['correos'] = $correos;
        return $data;
    }

    /**
     * obtiens las plantillas para envio interno de informacion
     */
    public function getInternalOrderTemplate (Request $req){
        $model = Order::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'texto'=>$content['contents']->first(),
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Order', 'created', $fn)['good']];
        $correos = [];
        foreach (User::get() as  $aux){
            $correos[] = ['nombre'=>$aux->nombre,'correo'=>$aux->email, 'langs'=>['es']];
        }
        $data['correos'] = $correos;
        return $data;
    }

    /***/
    public function getCancelOrderTemplate(Request $req){
        $model = Order::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Order', 'cancel', $fn)['good']];

        $correos = [];
        $to = [];

        foreach ($prov->contacts()->get() as  $aux){
            foreach ($aux->campos()->where('campo', 'email')->get() as $aux2){
                $e =  ['nombre'=>$aux->nombre, 'correo'=>$aux2->valor];
                $e['langs'] = array_map('strtolower', $aux->idiomas()->lists('iso_lang')->toarray());
                $correos[] =$e ;
                if($aux->pivot->default == 1){
                    $to[] = $e;
                }
            }

        }

        $data['correos'] = $correos;
        $data['to'] = $to;
        return $data;
    }
    /**
     * obtiene las respuesta a un provedor
     **/
    public function getAnswerdsOrder(Request $req){
        $model = Order::findOrFail($req->id);
        $resul = [];

        foreach ($model->answerds()->get() as $aux){
            $aux->adjs = $aux->attachments()->lists('archivo_id');
            $resul[] = $aux;
        }


        return  $resul;

    }

    /**
     * obtiene las sodocumentos actos para importacion
     */
    public function getDocOrderImport(Request $req)
    {
        $data = array();
        $items = Solicitude::where('disponible', 1)->get();
        $type = OrderType::get();
        $prov = Provider::findOrFail($req->prov_id);
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad = OrderPriority::get();
        $estados = OrderStatus::get();
        $paises = Country::get();
        foreach ($items as $aux) {
            $aux->diasEmit = $aux->daysCreate();
            $data[] = $aux;
        }


        return $data;

    }

    /**** PEDIDO POST *********/

    /**
     * Make the payments doc the order
     */
    public function MakePaymentsOrder(Request $req){
        $model = Order::findOrFail($req->id);
        $result = [];
        $result['accion']='make';
        $result['response'] = $model->builtPaymentDocs();
        return $result;
    }
    /**
     * Guarda un registro en la base de datos
     * @param $req la data del registro a guradar
     * @return json donde el primer valor representa 'error' en caso de q falle y
     * 'succes' si se realizo la accion
     */
    public function saveOrder(Request $req)
    {
        $result =  [];
        $result["action"]="new";
        $model = new Order();

        if ($req->has('id') && $req->id) {
            $model = $model->findOrFail($req->id);
            $result["action"]="edit";
        }
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'titulo' => 'required',
            'tasa' => 'required',
            'prov_moneda_id' => 'required',
            'nro_proforma' => 'required'

        ]);
        if ($validator->fails() && sizeof($model->attachments()->where('documento','PROFORMA')->get()) == 0 ) {
            $result = array("error" => "errores en campos de formulario");


        }else{
            $result['success']= "Registro guardado con éxito";
        }
        $model= $this->setDocItem($model, $req);
        $model->save();
        $result['id']= $model->id;
        $result['user']= $model->usuario_id;
        $result['uid']=$model->uid ;

        return $result;

    }

    /**
     * guarda el producto de la orden
     */
    public  function  SaveProductoOrden (Request $req){
        $resul['accion'] = "new";
        $model = new OrderItem();
        if ($req->has('reng_id')) {
            $model = OrderItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
        }
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $req->id;

        $model->doc_origen_id = $req->has('doc_origen_id') ? $req->doc_origen_id : null;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;
        $model->producto_id = $req->producto_id;
        $model->descripcion = $req->descripcion;
        $model->uid = $req->has('uid') ? $req->uid : uniqid('', true);


        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }

        $resul['response'] = $model->save();
        $resul['reng_id'] = $model->id;
        $resul['cantidad'] = $model->cantidad;
        $resul['saldo'] = $model->saldo;

        return $resul;

    }

    /**
     * agrega un producto
     */
    public function saveOrderItemProduc(Request $req)
    {
        $resul['accion'] = "new";
        $model = new OrderItem();
        if ($req->has('reng_id')) {
            $model = OrderItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
        }
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $req->id;

        $model->doc_origen_id = $req->has('doc_origen_id') ? $req->doc_origen_id : null;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;
        $model->producto_id = $req->producto_id;
        $model->descripcion = $req->descripcion;
        $model->uid = $req->has('uid') ? $req->uid : uniqid('', true);


        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }

        $resul['response'] = $model->save();
        $resul['reng_id'] = $model->id;
        $resul['cantidad'] = $model->cantidad;
        $resul['saldo'] = $model->saldo;

        return $resul;
    }

    /**
     *elimina el producto
     **/
    public function DeleteOrderItemProduc(Request $req)
    {
        $result['accion'] = 'del';
        $result['response'] = OrderItem::destroy($req->id);
        $result['id'] = $req->id;
        return $result;
    }

    /**
     * agreaga el iten de cotnra pedido a la solicutud
     */
    public function saveOrderItemCustomOrder(Request $req)
    {
        $resul['accion'] = "new";
        $model = new OrderItem();
        $co = App\Models\Sistema\CustomOrders\CustomOrderItem::findOrFail($req->origen_item_id);
        if ($req->has('reng_id')) {
            $model = SolicitudeItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
            $co->saldo = floatval( $co->saldo) + floatval( $model->cantidad);

        }

        $model->tipo_origen_id = 2;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $co->id;
        $model->descripcion = $co->descripcion;
        $model->producto_id = $co->producto_id;
        $model->doc_origen_id = $co->doc_id;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;
        $model->uid = $co->uid;
        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }
        $co->saldo = floatval( $co->saldo) - floatval( $model->cantidad);

        $co->save();
        $model->save();

        $resul['reng_id'] = $model->id;
        $resul['disponible'] = floatval($co->saldo) + floatval($model->cantidad);
        $resul['inDoc'] = $co->cantidad;;
        $resul['inDocBlock'] = floatval($co->cantidad) - floatval($model->saldo);
        return $resul;
    }

    /**
     * elimina el contra pedido
     */
    public function DeleteOrderItemCustomOrder(Request $req)
    {
        $model = SolicitudeItem::find($req->id);
        $co= CustomOrderItem::find($model->origen_item_id);
        $co->saldo = floatval( $co->saldo) + floatval( $model->cantidad);
        $co->save();
        $result['accion'] = 'del';
        $result['response'] = SolicitudeItem::destroy($req->id);
        $result['id'] = $req->id;
        return $result;
    }

    public function UpdateOrder(Request $req)
    {
        $resul['action'] = "upd";
        $model = Order::findOrFail($req->id);
        $model->final_id = null;
        $model->edit_usuario_id = $this->user->id;
        $model->save();
        return $resul;
    }

    /**
     * cambia el item
     */
    public function changeItemOrder(Request $req){
        $resul['accion']= "upd";
        $model = OrderItem::findOrFail($req->id);

        $model->tipo_origen_id = ($req->has('tipo_origen_id')) ? $req->tipo_origen_id : null;
        $model->doc_id = ($req->has('doc_id')) ? $req->doc_id : null;
        $model->origen_item_id = ($req->has('origen_item_id')) ? $req->origen_item_id : null;
        $model->doc_origen_id = ($req->has('doc_origen_id')) ? $req->doc_origen_id : null;
        $model->producto_id = ($req->has('producto_id')) ? $req->producto_id : null;
        $model->descripcion = ($req->has('descripcion')) ? $req->descripcion : null;
        $model->costo_unitario = ($req->has('costo_unitario')) ? $req->costo_unitario : null;

        $old = null;
        if($model->tipo_origen_id == 2){
            $old = CustomOrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 3){ // no requiere actualizacion por ahora

        }else if($model->tipo_origen_id == 21){
            $old = SolicitudeItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 22){
            $old = OrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else{
            $model->cantidad = ($req->has('cantidad')) ? $req->cantidad : null;
            $model->saldo = ($req->has('saldo')) ? $req->saldo : null;
            $model->uid = ($req->has('uid')) ? $req->uid : uid('', true);
        }
        if($old != null){
            $old->saldo = floatval($old->saldo ) + floatval($model->cantidad ) ;
            $old->saldo = floatval($old->saldo ) - floatval($req->saldo) ;
            $dif= floatval($model->saldo) - floatval($req->saldo);
            $model->cantidad = $req->saldo;
            $model->saldo= floatval($model->saldo)  + $dif;
            $old->save();
            $model->save();
            $resul['data'] = ['old'=>$old, 'moel'=>$model];
            if($model->tipo_origen_id == 21 || $model->tipo_origen_id == 22 ){
                $doc =  $old->document;
                $doc->disponible=1;
                $doc->save();
            }
        }
        $resul['response']=$model->save();
        $resul['id']=$model->id;
        $resul['model']=$model;
        return $resul;
    }

    /**
     * elimina un item del documento
     */
    public function DeleteItemOrder(Request $req){
        $resul= ['accion'=>'del'];
        $model = OrderItem::find($req->id);

        $old = null;
        if($model->tipo_origen_id == 2){
            $old = CustomOrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 3){ // no requiere actualizacion por ahora

        }else if($model->tipo_origen_id == 21){
            $old = SolicitudeItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 22){
            $old = OrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }
        if($old != null){
            $old->saldo = floatval($old->saldo ) + floatval($model->cantidad ) ;
            $old->save();
            $resul['data'] = ['old'=>$old, 'moel'=>$model];
        }
        $resul['response']= $model->destroy($model->id);
        return $resul;

    }

    /**
     * restaura un item eliminado con softdelete
     */
    public function RestoreItemOrder(Request $req){
        $resul= ['accion'=>'restore'];
        $model = OrderItem::withTrashed()->where('id',$req->id )->first();
        $resul['response']= $model->restore();
        $old = null;
        if($model->tipo_origen_id == 2){
            $old = CustomOrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 3){ // no requiere actualizacion por ahora

        }else if($model->tipo_origen_id == 21){
            $old = SolicitudeItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 22){
            $old = OrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else{
            $model->cantidad = ($req->has('cantidad')) ? $req->cantidad : null;
            $model->saldo = ($req->has('saldo')) ? $req->saldo : null;
            $model->uid = ($req->has('uid')) ? $req->uid : uid('', true);
        }
        if($old != null){
            $old->saldo = floatval($old->saldo ) - floatval($req->saldo) ;
            $old->save();
            $doc =  $old->document;
            $resul['data'] = ['old'=>$old, 'moel'=>$model];
            if($model->tipo_origen_id == 21 || $model->tipo_origen_id == 22 ){
                if($doc->items()->sum('saldo') == 0){
                    $doc->disponible = 0;
                    $doc->save();
                }
            }
        }
        return $resul;
    }

    /**
     * asigna el contra pedido al documento
     *
     **/
    public function addCustomOrderOrder(Request $req){

        $model= CustomOrder::findOrFail($req->id);
        $items = $model->CustomOrderItem()->get();
        $resul= array();
        $resul['action']= "new";
        $newItems= array();
        $oldItems= array();
        $doc =Order::findOrFail($req->doc_id);

        $docItms= $doc->items()->where("tipo_origen_id",2)->get();
        foreach($items as $aux){
            if(
                sizeof($docItms->where('origen_item_id',$aux->id)->where('doc_origen_id',$req->id)) == 0){
                $item = $doc->newItem();
                $item->tipo_origen_id = 2;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id = $aux->id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->descripcion = $aux->descripcion;
                $item->producto_id = $aux->producto_id;
                $item->doc_origen_id = $model->id;
                $item->uid = $aux->uid;
                $aux->saldo= 0;
                $oldItems[] = $aux;
                $newItems[] = $item;
            }
        }
        $resul['newitems']=$newItems;
        $resul['oldItems']=$oldItems;
        $doc->items()->saveMany($newItems);
        $model->CustomOrderItem()->saveMany($oldItems);
        return $resul;
    }

    /**
     * elimina los item del contra pedido
     **/
    public function RemoveCustomOrderOrder(Request $req){
        $resul["accion"]= "del";
        $model = OrderItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->where('tipo_origen_id', 2)
            ->get();
        $ids = array();
        $cOrders= CustomOrder::find($req->id);
        $cOrdersItem = $cOrders->items()->get();
        $cOrderNI=[];
        foreach($model as $aux){
            $ids[]= $aux->id;
            $coI = $cOrdersItem->where('id',$aux->origen_item_id)->first();
            if($coI != null){
                $coI->saldo =  floatval($coI->saldo) + floatval($aux->cantidad);
                $cOrderNI[] =$coI;
            }

        }

        OrderItem::destroy($ids);
        $cOrders->items()->saveMany($cOrderNI);
        $resul["keys"]=$ids;
        $resul["restore"]=$cOrderNI;

        return $resul;

    }

    /**
     * asigna un kitchenbox a un pedido
     **/
    public function SavekitchenBoxOrder(Request $req){

        $resul['action']="new";
        $k = KitchenBox::findOrFail($req->id);
        $item = new OrderItem();
        if ($req->has('reng_id')) {
            $resul['action'] = 'upd';
            $item = OrderItem::findOrFail($req->reng_id);
        }
        $item->tipo_origen_id = 3;
        $item->doc_id = $req->doc_id;
        $item->origen_item_id = $k->id;
        $item->cantidad = 1;
        $item->saldo = 1;
        $item->descripcion = $req->has('descripcion') ? $req->descripcion : $k->titulo;
        $item->producto_id = $k->producto_id;
        $item->uid = $req->uid;
        $item->costo_unitario = $req->costo_unitario;
        $item->doc_origen_id = $k->id;/// reemplazar cuando se sepa la logica
        $resul['response'] = $item->save();
        $resul['item'] = $item;
        return $resul;

    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function RemovekitchenBoxOrder(Request $req){
        $resul["accion"] = "del";
        $model = OrderItem::findOrFail($req->id);
        OrderItem::destroy($model->id);
        $resul["id"] = $req->id;
        return $resul;


    }

    /**
     *aprueba la solicutud dependiendo del usuario logeado
     */
    public function ApprovedOrder(Request $req)
    {
        $result = [];
        $model = Order::findOrFail($req->id);
        if($this->user->cargo_id == '6' || $this->user->cargo_id == '8'){
            $model->fecha_aprob_gerencia= $req->fecha;
            $model->nro_doc = $req->nro_doc;
            $result['accion']='ap_gerencia';
            $result['fecha'] = $model->fecha_aprob_gerencia;
        }else{
            $model->fecha_aprob_compra = $req->fecha;
            $model->nro_doc = $req->nro_doc;
            $result['accion']='ap_compras';
            $result['fecha'] = $model->fecha_aprob_compra;

        }

        if($req->has("adjs")){

            foreach($req->adjs as $aux){
                $adj= new OrderAttachment();
                $adj->doc_id = $model->id;
                $adj->archivo_id = $aux['id'];
                $adj->documento = $result['accion'];
                $adj->save();
                $att[] = $adj;

            }
        }
        $model->save();

        $result['nro_doc'] = $model->nro_doc;
        $result['response'] = $model->save();
        return $result;
    }

    /**
     * cancela la orden
     **/
    public function cancelOrder(Request $req)
    {

        $response = [];
        $model = Order::findOrFail($req->id);

        $model->comentario_cancelacion = $req->comentario;
        $model->final_id = $this->getFinalId($model);
        $model->disponible = 0;
        $response['response'] = $model->save();
        $response['success'] = 'Pedido Cancelado';
        $response['accion'] = $model->comentario_cancelacion == null ? 'new' : 'upd';

        foreach ($model->customOrderItems()->get() as $aux){
            $co = CustomOrderItem::where('uid',$aux->uid)->first();
            if($co != null){
                $co->saldo = floatval($co->saldo) + floatval($aux->cantidad);
                $co->save();
            }
        }
        foreach ($model->kitchenBoxs()->get() as $aux){
            $aux->saldo = 0;
            $aux->save();
        }
        $mail = new MailModule();
        $mail->doc_id = $model->id;
        $mail->tipo_origen_id = 22;
        $mail->asunto =$req->has('subject') ? $req->subject : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'order';
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto];
        $mail->clave= "cancel";
        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){
            foreach ($req->adjs as $f){
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }
        }

        $response['email'] = $mail->sendMail($req->content, $destinations);

        return $response;

    }

    /**
     * agrega el pedido al nuevo documento
     */
    public  function  addSustituteOrder(Request $req){

        $resul =[];
        $resul['kitchen'] = [];
        $resul['cp'] = [];
        $princi = Order::findOrFail($req->princ_id);
        $reemplaze = Order::findOrFail($req->reemplace_id);
        $model = new Order();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);


        $princi->version = ($princi->parent_id == null) ? $princi->version + 1 : $princi->version;
        $princi->parent_id = $reemplaze->id;


        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;

        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();
        $reemplaze->ult_revision= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $model->ult_revision= Carbon::now();

        $princi->disponible= 0;
        $reemplaze->disponible= 0;

        $princi->uid = $reemplaze->uid;
        $model->uid = $reemplaze->uid;
        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($princi->items()->get() as $oldItem){
            $newItem = new OrderItem();
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newItem->uid =$oldItem->uid;
            $newIts[] = $newItem;
            $oldItem->saldo = 0;
            $oldItem->save();

        }
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new OrderItem();
            $newItem->tipo_origen_id =22;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$reemplaze->id;
            $newItem->cantidad =$oldItem->saldo;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newItem->uid =$oldItem->uid;

            $newIts[] = $newItem;
            $oldItem->saldo = 0;
            $oldItem->save();
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);

        return $resul;


    }

    /**
     * remueve el pedido al documento
     */
    public function removeSustituteOrder(Request $req){
        $resul = array();
        $princi = Order::findOrFail($req->princ_id);
        $reemplaze = Order::findOrFail($req->reemplace_id);

        ///dd($princi);
        $model = new Order();
        $model = $this->transferDataDoc($princi,$model);
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->uid = $princi->uid;
        $princi->fecha_sustitucion= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $princi->disponible= 0;
        $princi->final_id= $this->getFinalId($princi);
        $princi->save();
        $model->save();
        $newIts= array();

        $import = $princi->items()->where( function ($query) use ($reemplaze) {
            $query->where('doc_origen_id','<>', $reemplaze->id)
                ->orWhereNull('doc_origen_id')
            ;
        })->get();

        foreach($import as $oldItem){
            $newItem = new OrderItem();
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->uid =$oldItem->uid;
            $newItem->costo_unitario =$oldItem->costo_unitario;

            $newIts[] = $newItem;

            $oldItem->saldo = 0;
            $oldItem->save();
        }


        foreach($princi->items()->where('doc_origen_id', $reemplaze->id)->get() as $oldItem){
            $ri = $reemplaze->items()->where('id', $oldItem->origen_item_id)->first();
            $ri->saldo = $oldItem->cantidad;
            $oldItem->saldo = 0;
            $oldItem->save();
            $ri->save();
        }


        $resul['accion']= "inpor";
        $resul['id']= $model->id;
        $reemplaze->fecha_sustitucion=null;
        $reemplaze->final_id= $this->getFinalId($reemplaze);
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    public function restoreOrden(Request $req){
        $resul = array();
        $princi = Order::findOrFail($req->princ_id);
        $reemplaze = Order::findOrFail($req->reemplace_id);
        $model = new Order();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);

        $princi->version = ($princi->parent_id == null) ? $princi->version + 1 : $princi->version;
        $princi->parent_id = $reemplaze->id;


        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->uid= $princi->uid;


        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();
        $reemplaze->ult_revision= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $model->ult_revision= Carbon::now();

        $princi->disponible= 0;
        $reemplaze->disponible= 0;

        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new OrderItem();
            $newItem->tipo_origen_id = $oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->cantidad; // precaucion el inten se restaura con la cantidad original
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newIts[] = $newItem;
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }
    /**
    determina la accion a realizar segun el estado del documento y los permisos del usuario
     */
    public function closeActionOrder(Request $req)
    {
        $model = Order::findOrFail($req->id);

        $result['actions'] = ['save'];
        $senders =MailModule::where('tipo_origen_id','22')
            ->where('doc_id',$model->id)
            ->where('tipo','user')
            ->get();
        $result['send']= sizeof($senders);

        if(($model->fecha_aprob_compra != null || $model->fecha_aprob_gerencia != null) ){
            $result['actions'][] = 'sendPrv';
            return $result;
        }else{
            $result['actions'][] = 'sendIntern';
        }
        return $result;

    }

    /**
    agregar respuesta del proveedor
     */
    public function AddAnswerOrder(Request $req){
        $response =[];
        $att =[];
        $doc= Order::findOrFail($req->id);
        $model = new OrderAnswer();
        $model->descripcion = $req->descripcion;
        $model->doc_id= $req->id;
        $model->save();

        $doc->ult_revision  = Carbon::now();
        $doc->save();
        $response['accion']= "new";
        if($req->has("adjs")){

            foreach($req->adjs as $aux){
                $adj= new OrderAnswerAttachment();
                $adj->doc_id = $doc->id;
                $adj->archivo_id = $aux['id'];
                $adj->save();
                $att[] = $adj;

            }
        }
        $model = OrderAnswer::findOrFail($model->id);
        $model->adjs =  $model->attachments()->lists('archivo_id');
        $response['id']=$model->id;
        $response['doc_id']=$model->doc_id;
        $response['model']=$model;
        $response['data']=$model;
        $response['items']=$att;
        return $response;

    }

    /**
     * adjuntos para el pedido
     **/
    public function addAttachmentsOrder(Request $req)
    {
        $model = Order::findOrFail($req->id);
        $resul = [ 'size' => sizeof($req->adjs) ,'files'=>[]];
        foreach ($req->adjs as $aux) {
            if(!array_key_exists('id',$aux )){
                $attac = new OrderAttachment();
                $attac->archivo_id = $aux['archivo_id'];
                $attac->doc_id = $model->id;
                $attac->documento = strtoupper($aux['documento']);
                $attac->save();

                $file= attachment_file($aux['archivo_id']);
                foreach ($file as $key => $value){
                    $attac[$key]= $value;
                }
                $resul['files'][]=$attac;
            }
        }


        return $resul;
    }

    /**
    Cierra el pedido
     */
    public function CloseOrder(Request $req)
    {
        $result['success'] = "Registro guardado con éxito!";
        $result['action'][] = "close";
        $model = Order::findOrFail($req->id);
        $model->ult_revision = Carbon::now();
        $model->final_id = $this->getFinalId($model);
        $model->save();
        return ['id'=>$req->id];

    }

    /**
     * crea una copia del documento
     * @param id del documento a copiar
     * @param tipo de documento
     */
    public function copyOrder(Request $req)
    {
        $resul["action"] = "copy";
        $newItems = array();
        $newModel = new Order();
        $oldModel = Order::findOrFail($req->id);
        $newModel = $this->transferDataDoc($oldModel, $newModel);
        $newModel->parent_id = $oldModel->id;
        $newModel->version = $oldModel->version + 1;
        $newModel->uid = $oldModel->uid;
        $newModel->save();
        $oldModel->save();

        foreach ($oldModel->items()->get() as $aux) {
            $it = new OrderItem();
            $it->tipo_origen_id = $aux->tipo_origen_id;
            $it->doc_id = $newModel->id;
            $it->origen_item_id = $aux->origen_item_id;
            $it->doc_origen_id = $aux->doc_origen_id;
            $it->cantidad = $aux->cantidad;
            $it->saldo = $aux->saldo;
            $it->producto_id = $aux->producto_id;
            $it->descripcion = $aux->descripcion;
            $it->costo_unitario = $aux->costo_unitario;
            $it->save();
            $newItems[] = $it;

        }

        $resul['id'] = $newModel->id;

        return $resul;

    }

    /**
     * envio de correo
     */
    public function sendOrder(Request $req){
        $resul = ['action'=>'send'];
        $model = Order::findOrFail($req->id);
        $sends =MailModule::where('tipo_origen_id','21')
            ->where('doc_id',$model->id)
            ->whereNotNull('send')
            ->where('tipo','user')
            ->get();
        $mail = new MailModule();
        $mail->doc_id = $model->id;
        $mail->tipo_origen_id = 21;
        $mail->asunto =$req->has('subject') ? $req->subject : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'solicitude';
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto];
        if(sizeof($sends) == 0){
            $mail->clave= 'created';
        }
        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){
            foreach ($req->adjs as $f){
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }
        }

        $resul['email'] = $mail->sendMail($req->content, $destinations);
        if(!$resul['email']['is']){
            $model->final_id= null;

        }else{
            $model->ult_revision = Carbon::now();
            $model->final_id = $this->getFinalId($model);

            /** envio de notificaciones **/
            $options = $this->templateNotif($model, 'emails.Order.InternalManager.es','order',$req->action);
            $options['atts'][]= ['data'=>$resul['email']['attOff']['data'],'nombre'=>$model->id.'_A_Proveedor.pdf'];
            $resul['email']['attOff'] ='';
            if($req->action == 'sendPrv'){
                $dest = $this->geUsersEMail('tbl_departamento.id = '.$this->departamentos['compras']);
            }else{
                $dest = $this->geUsersEMail('tbl_cargo.id = '.$this->profile['gerente_adm']);
            }
            $options['to'] = $dest;
            $mail = new MailModule();
            $mail->doc_id = $model->id;
            $mail->tipo_origen_id = 22;
            $mail->asunto =$options['subject'];
            $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
            $mail->tipo = 'sis';
            $mail->modulo = 'solicitude';
            $mail->save();
            $resul['nofs']=  $mail->sendMail($options['template'], $options);
        }
        $model->save();
        return $resul;


    }

    /**
     * Asigna el parent a un pedido(proforma)
     */
    public function setParentOrder(Request $req){
        $resul = ['accion'=>'upd', 'changes' => [],'new'=>[], 'old'=>[],'co'=>[]];
        $model = Order::findOrFail($req->id);
        $so = Solicitude::findOrFail($req->doc_parent_id);
        $model->doc_parent_id= $req->doc_parent_id;
        $model->doc_parent_origen_id= $req->doc_parent_origen_id;

        if($req->has('monto')){
            $model->monto = $req->monto;
            $resul['changes']['monto']=$model->monto;
        }
        if($req->has('titulo')){
            $model->titulo = $req->titulo;
            $resul['changes']['titulo']=$model->titulo;
        }
        if($req->has('pais_id')){
            $model->pais_id = $req->pais_id;
            $resul['changes']['pais_id']=$model->pais_id;
        }

        if($req->has('motivo_id')){
            $model->motivo_id = $req->motivo_id;
            $resul['changes']['motivo_id'] =$model->motivo_id;
        }
        if($req->has('prov_moneda_id')){
            $model->prov_moneda_id = $req->prov_moneda_id;
            $resul['changes']['prov_moneda_id']= $model->prov_moneda_id;
        }

        if($req->has('mt3')){
            $model->mt3 = $req->mt3;
            $resul['changes']['mt3'] = $model->mt3;
        }
        if($req->has('peso')){
            $model->peso = $req->peso;
            $resul['changes']['peso']= $model->peso;
        }
        if($req->has('direccion_almacen_id')){
            $model->direccion_almacen_id = $req->direccion_almacen_id;
            $resul['changes']['direccion_almacen_id']= $model->direccion_almacen_id;
        }
        if($req->has('direccion_facturacion_id')){
            $model->direccion_facturacion_id = $req->direccion_facturacion_id;
            $resul['changes']['direccion_facturacion_id']= $model->direccion_facturacion_id;
        }
        if($req->has('puerto_id')){
            $model->puerto_id = $req->puerto_id;
            $resul['changes']['puerto_id']= $model->puerto_id;
        }
        if($req->has('condicion_id')){
            $model->condicion_id = $req->condicion_id;
            $resul['changes']['condicion_id'] = $model->condicion_id;
        }
        if($req->has('tasa')){
            $model->tasa = $req->tasa;
            $resul['changes']['tasa']= $model->tasa;
        }
        if($req->has('comentario')){
            $model->comentario = $req->comentario;
            $resul['changes']['comentario'] = $model->comentario;
        }
        if($req->has('items')){
            foreach ($req->items as $id){
                $aux = SolicitudeItem::findOrFail($id);
                $item= new OrderItem();
                $item->tipo_origen_id = $req->doc_parent_origen_id;
                $item->doc_id = $model->id;
                $item->origen_item_id =$aux->id;
                $item->doc_origen_id =$aux->doc_id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->producto_id = $aux->producto_id;
                $item->descripcion = $aux->descripcion;
                $item->costo_unitario = $aux->costo_unitario;
                $aux->saldo = 0;
                $aux->save();
                $item->save();
                $co= $aux->customOrder;
                if($co !=  null){
                    $co->saldo =  0;
                    $co->save();
                    $resul['co']= $co;
                }

                $resul['new'][]= $item;
                $resul['old'][]= $aux;

            }
        }
        $so->disponible= 0;
        $so->save();
        $model->save();
        return $resul;
    }

    /**
     *  compara una solicitud  y un pedido y muestra las diferencias por campos entre ellos
     */
    public function getOrderCompareSolicitud(Request $req)
    {
        $data = array();
        $error = array();
        $asigna = [];
        $compare = array('titulo', 'pais_id', 'motivo_id', 'prov_moneda_id', 'mt3', 'peso',
            'direccion_almacen_id', 'direccion_facturacion_id', 'puerto_id', 'condicion_id', 'tasa', 'comentario'
        );
        $princi = Order::findOrFail($req->id);// id de la proforma
        $import = Solicitude::findOrFail($req->compare);// id de la solicitud
        $asigna['monto'] = $princi->monto + $import->monto;
        $asigna['mt3'] = $princi->mt3 + $import->mt3;


        foreach ($compare as $aux) {
            $ordval = $princi->getAttributeValue($aux);
            $solval = $import->getAttributeValue($aux);
            $data['comp'][] = array('ord' => $ordval, 'solv' => $solval, 'key' => $aux);
            if ($solval == null && $ordval != null) {
                $asigna[$aux] = $ordval;
            } else if ($solval != null && $ordval == null) {
                $asigna[$aux] = $solval;
            } else
                if ($solval != null && $ordval != null) {

                    if ($solval != $ordval) {
                        $temp0 = array();
                        $temp1 = array();
                        $temp0['key'] = $solval;
                        $temp1['key'] = $ordval;

                        switch ($aux) {

                            case "prov_moneda_id":
                                $mon = Monedas::findOrFail($solval);
                                $mon2 = Monedas::findOrFail($ordval);
                                $temp0['text'] = $mon->nombre;
                                $temp1['text'] = $mon2->nombre;
                                break;
                            case "pais_id":
                                $mon = Country::find($solval);
                                $mon2 = Country::find($ordval);
                                if ($mon != null) {
                                    $temp0['text'] = $mon->short_name;
                                }
                                if ($mon2 != null) {
                                    $temp1['text'] = $mon2->short_name;
                                }
                                break;
                            case "motivo_id":
                                $mon = OrderReason::findOrFail($solval);
                                $mon2 = OrderReason::findOrFail($ordval);
                                $temp0['text'] = $mon->motivo;
                                $temp1['text'] = $mon2->motivo;
                                break;
                            case "direccion_almacen_id" || "direccion_facturacion_id":
                                $mon = ProviderAddress::find($solval);
                                $mon2 = ProviderAddress::find($ordval);
                                if ($mon != null) {
                                    $temp0['text'] = $mon->short_name;
                                }
                                if ($mon2 != null) {
                                    $temp1['text'] = $mon2->short_name;
                                }

                                break;
                            /*       case "direccion_facturacion_id":
                                       $mon=ProviderAddress::findOrFail($solval);
                                       $mon2=ProviderAddress::findOrFail($ordval);
                                       $temp0['text'] =$mon->direccion;
                                       $temp1['text'] =$mon2->direccion;
                                       break;*/
                            case "puerto_id" :
                                $mon = Ports::findOrFail($solval);
                                $mon2 = Ports::findOrFail($ordval);
                                $temp0['text'] = $mon->Main_port_name;
                                $temp1['text'] = $mon2->Main_port_name;
                                break;
                            case "condicion_id" :
                                $mon = OrderCondition::findOrFail($solval);
                                $mon2 = OrderCondition::findOrFail($ordval);
                                $temp0['text'] = $mon->Main_port_name;
                                $temp1['text'] = $mon2->Main_port_name;
                                break;


                        }
                        $error[$aux][] = $temp0;
                        $error[$aux][] = $temp1;

                    }
                }
        }
        $data['error'] = $error;
        $data['asignado'] = $asigna;
        $solItms = $import->items()->where('saldo','>', 0)->get();
        $data['items'] = $solItms;


        return $data;
    }

    /************************************************************** FIN PEDIDO O PROFORMA *************************************************************/

    /************************************************************** ORDEN DE COMPRA *************************************************************/
    /**** ORDEN DE COMPRA GET *********/

    /**
     * obtiene todos las ordenes de compras que son sustituibles
     **/
    public function getPurchaseSubstitutes(Request $req){
        $data =  Collection::make(Array());
        $model = Purchase::findOrFail($req->doc_id);
        $items = Purchase::where('id','<>', $req->doc_id)
            ->where('prov_id', $req->prov_id)
            ->WhereNull('fecha_sustitucion')
            ->get();
        $type = OrderType::get();
        $coin = Monedas::get();
        $motivo = OrderReason::get();
        $prioridad= OrderPriority::get();
        $estados= OrderStatus::get();
        $paises= Country::get();

        foreach($items as $aux){
            $aux->asignado =false;
            $data->push($aux);
        }
        foreach ($model->items()->where('tipo_origen_id','22')->get() as $aux){
            if(!$data->contains($aux->doc_origen_id)){
                $doc = Purchase::findOrFail($aux->doc_origen_id);
                $aux->asignado =false;
                $data->push($doc);
            }

        }
        foreach($data as $aux){
            $aux['documento'] = $aux->getTipo();
            $aux['diasEmit'] = $aux->daysCreate();
            $aux['estado'] = $estados->where('id', $aux->estado_id)->first()->estado;

            if ($aux->motivo_id) {
                $aux['motivo'] = $motivo->where('id', $aux->motivo_id)->first()->motivo;
            }
            if ($aux->pais_id) {
                $aux['pais'] = $paises->where('id', $aux->pais_id)->first()->short_name;
            }
            if ($aux->prioridad_id) {
                $aux['prioridad'] = $prioridad->where('id', $aux->prioridad_id)->first()->descripcion;
            }
            if ($aux->prov_moneda_id) {
                $aux['moneda'] = $coin->where('id', $aux->prov_moneda_id)->first()->nombre;
            }
            if ($aux->prov_moneda_id) {
                $aux['symbol'] = $coin->where('id', $aux->prov_moneda_id)->first()->simbolo;
            }
            if ($aux->tipo_id != null) {
                $aux['tipo'] = $type->where('id', $aux->tipo_id)->first()->tipo;
            }
        }
        return $data;

    }

    public function getOldPurchase(Request $req){
        $model = Purchase::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $data = [];
        $olds = Purchase::where('id','<>', $model->id)
            ->where('uid', $model->uid)
            ->get();

        foreach ($olds as $aux){
            $aux->proveedor = $prov->razon_social;
            $aux->tipo = $aux->getTipoId();
            $data[] = $aux;
        }
        return $olds;
    }

    /**
     * construye el resumen preliminar del pedido
     */
    public function getPurchaseSummary(Request $req)
    {
        $data = array();
        $prod = array();
        $model= Purchase::findOrFail($req->id);
        $provProd = Product::where('prov_id',$model->prov_id)->get();
        $items =$model->items()->get();
        foreach($items as $aux){
            $p= $provProd->where('id',$aux->producto_id)->first();
            if($p != null){
                $aux['codigo']=$p->codigo;
                $aux['codigo_fabrica']=$p->codigo_fabrica;
            }
            $prod[]= $aux;
        }

        $data['productos']= $prod;

        return $data;

    }
    /**
     * obitene las plantillas par el envio del correo al proveedor
     */
    public function getProviderPurchaseTemplate(Request $req)
    {
        $model = Purchase::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'texto'=>$content['contents']->first(),
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Purchase', 'toProviders', $fn)['good']];

        $correos = [];

        foreach ($prov->contacts()->get() as  $aux){
            foreach ($aux->campos()->where('campo', 'email')->get() as $aux2){
                $e =  ['nombre'=>$aux->nombre, 'correo'=>$aux2->valor];
                $e['langs'] = array_map('strtolower', $aux->idiomas()->lists('iso_lang')->toarray());
                $correos[] =$e ;
            }

        }
        $data['correos'] = $correos;
        return $data;
    }

    /**
     * obtiens las plantillas para envio interno de informacion
     */
    public function getInternalPurchaseTemplate (Request $req){
        $model = Purchase::findOrFail($req->id);
        $user =   $this->user;
        $tipo = 'created';
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'texto'=>$content['contents']->first(),
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };

        if($model->nro_factura != null && $model->attachments()->where('document','nro_factura')->count() > 0){
            $tipo = 'update';
        }
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Purchase', $tipo, $fn)['good']];
        $correos = [];
        foreach (User::get() as  $aux){
            $correos[] = ['nombre'=>$aux->nombre,'correo'=>$aux->email, 'langs'=>['es']];
        }
        $data['tipo']=$tipo;
        $data['correos'] = $correos;
        return $data;
    }


    /***/
    public function getCancelPurchaseTemplate(Request $req){
        $model = Purchase::findOrFail($req->id);
        $prov = Provider::findOrFail($model->prov_id);
        $user =   $this->user;
        $fn =  function ($content, $file) use ($model,$user)  {
            $template = View::make($file,[
                'subjet'=>$content['subjet'],
                'model'=>$model,
                'articulos'=>$model->items()->with('producto')->get(),
                'user'=>$user
            ])->render();

            return $template;
        };
        $data = ['templates'=>App\Http\Controllers\Masters\EmailController::builtTemplates('Purchase', 'cancel', $fn)['good']];

        $correos = [];
        $to = [];

        foreach ($prov->contacts()->get() as  $aux){
            foreach ($aux->campos()->where('campo', 'email')->get() as $aux2){
                $e =  ['nombre'=>$aux->nombre, 'correo'=>$aux2->valor];
                $e['langs'] = array_map('strtolower', $aux->idiomas()->lists('iso_lang')->toarray());
                $correos[] =$e ;
                if($aux->pivot->default == 1){
                    $to[] = $e;
                }
            }

        }

        $data['correos'] = $correos;
        $data['to'] = $to;
        return $data;
    }
    /**
     * obtiene las respuesta a un provedor
     **/
    public function getAnswerdsPurchase(Request $req){
        $model = Purchase::findOrFail($req->id);
        $resul = [];

        foreach ($model->answerds()->get() as $aux){
            $aux->adjs = $aux->attachments()->lists('archivo_id');
            $resul[] = $aux;
        }


        return  $resul;

    }

    /**
     * obtiene las sodocumentos actos para importacion
     */
    public function getDocPurchaseImport(Request $req)
    {
        $data = array();

        $model = Purchase::findOrfail($req->id);
        $items = Order::where('disponible', 1);

        if($model->pago_factura_id != null){
            $items = $items->whereNull('pago_factura_id');
        }
        $items = $items->get();
        /*   $type = OrderType::get();
           $prov = Provider::findOrFail($req->prov_id);
           $coin = Monedas::get();
           $motivo = OrderReason::get();
           $prioridad = OrderPriority::get();
           $estados = OrderStatus::get();
           $paises = Country::get();*/
        foreach ($items as $aux) {
            $aux->diasEmit = $aux->daysCreate();
            $data[] = $aux;
        }


        return $data;

    }
    /**** ORDEN DE COMPRA POST *********/
    public function savePurchaseOrder(Request $req){

        $result =  [];
        $result["action"]="new";
        $model = new Purchase();
        $uid=null;

        if ($req->has('id')) {
            $model = $model->findOrFail($req->id);
            $result["action"]="edit";
        }
        $model= $this->setDocItem($model, $req);
        if($req->has('condicion_cp')){
            $model->condicion_cp = $req->condicion_cp;

        }
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'titulo' => 'required',
            'tasa' => 'required',
            'prov_moneda_id' => 'required',
            'nro_proforma' => 'required',
            'condicion_pago_id'=> 'required'
        ]);
        if ($validator->fails()) {
            $result = array("error" => "errores en campos de formulario");
            if($model->uid == null){
                $model->uid =uniqid('', true);
            }

        }else{
            $result['success']= "Registro guardado con éxito";
        }

        $model->save();
        $result['id']= $model->id;
        $result['user']= $model->usuario_id;
        $result['uid']=$model->uid ;

        return $result;

    }

    /**asigna el producto a la solicitud */
    public  function  changeProductoPurchase (Request $req){
        $resul['accion'] = "new";
        $model = new PurchaseItem();
        if ($req->has('reng_id')) {
            $model = OrderItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
        }
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $req->id;

        $model->doc_origen_id = $req->has('doc_origen_id') ? $req->doc_origen_id : null;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;
        $model->producto_id = $req->producto_id;
        $model->descripcion = $req->descripcion;
        $model->uid = $req->has('uid') ? $req->uid : uniqid('', true);


        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }

        $resul['response'] = $model->save();
        $resul['reng_id'] = $model->id;
        $resul['cantidad'] = $model->cantidad;
        $resul['saldo'] = $model->saldo;

        return $resul;

    }

    /**
     * agreaga el iten de cotnra pedido a la solicutud
     */
    public function savePurchaseItemCustomOrder(Request $req)
    {
        $resul['accion'] = "new";
        $model = new PurchaseItem();
        $co =CustomOrderItem::findOrFail($req->origen_item_id);
        if ($req->has('reng_id')) {
            $model = SolicitudeItem::findOrFail($req->reng_id);
            $resul['accion'] = 'upd';
            $co->saldo = floatval( $co->saldo) + floatval( $model->cantidad);

        }

        $model->tipo_origen_id = 2;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id = $co->id;
        $model->descripcion = $co->descripcion;
        $model->producto_id = $co->producto_id;
        $model->doc_origen_id = $co->doc_id;
        $model->uid = $co->uid;
        $model->costo_unitario = $req->has('costo_unitario') ? $req->costo_unitario : null;

        if ($resul['accion'] == 'new' || $model->cantidad == $model->saldo) {
            $model->cantidad = $req->saldo;
            $model->saldo = $req->saldo;
        } else {
            $dif = floatval($req->saldo) - floatval($model->cantidad);
            $model->saldo = floatval($model->saldo) + $dif;
            $model->cantidad = $req->saldo;
        }
        $co->saldo = floatval( $co->saldo) - floatval( $model->cantidad);

        $co->save();
        $model->save();

        $resul['reng_id'] = $model->id;
        $resul['disponible'] = floatval($co->saldo) + floatval($model->cantidad);
        $resul['inDoc'] = $co->cantidad;;
        $resul['inDocBlock'] = floatval($co->cantidad) - floatval($model->saldo);
        return $resul;
    }

    /**
     * elimina el contra pedido
     */
    public function DeletePurchaseItemCustomOrder(Request $req)
    {
        $model = PurchaseItem::find($req->id);
        $co= CustomOrderItem::find($model->origen_item_id);
        $co->saldo = floatval( $co->saldo) + floatval( $model->cantidad);
        $co->save();
        $result['accion'] = 'del';
        $result['response'] = PurchaseItem::destroy($req->id);
        $result['id'] = $req->id;
        return $result;
    }

    /**
     *elimina el producto
     **/
    public function DeletePurchaseItemProduc(Request $req)
    {
        $result['accion'] = 'del';
        $result['response'] = PurchaseItem::destroy($req->id);
        $result['id'] = $req->id;
        return $result;
    }

    public function PurchaseUpdate(Request $req)
    {
        $resul['action'] = "upd";
        $model = Purchase::findOrFail($req->id);
        $model->edit_usuario_id = $this->user->id;

        $model->final_id = null;
        $model->save();
        return $resul;
    }

    public function changeItemPurchase(Request $req){
        $resul['accion']= "upd";
        $model = PurchaseItem::findOrFail($req->id);
        $model->tipo_origen_id = $req->tipo_origen_id;
        $model->doc_id = $req->doc_id;
        $model->origen_item_id= $req->origen_item_id;
        $model->doc_origen_id= $req->doc_origen_id;
        $model->cantidad= $req->cantidad;
        $model->saldo= $req->saldo;
        $model->producto_id= $req->producto_id;
        $model->descripcion= $req->descripcion;
        if($req->has("final_id")){
            $model->final_id= $req->final_id;
        }
        $resul['response']=$model->save();
        $resul['id']=$model->id;
        return $resul;
    }
    /**
     * elimina un item del documento
     */
    public function DeleteItemPurchase(Request $req){
        $resul= ['accion'=>'del'];
        $model = OrderItem::find($req->id);

        $old = null;
        if($model->tipo_origen_id == 2){
            $old = CustomOrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 3){ // no requiere actualizacion por ahora

        }else if($model->tipo_origen_id == 21){
            $old = SolicitudeItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 22){
            $old = OrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 23){
            $old = PurchaseItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }
        if($old != null){
            $old->saldo = floatval($old->saldo ) + floatval($model->cantidad ) ;
            $old->save();
            $resul['data'] = ['old'=>$old, 'moel'=>$model];
        }
        $resul['response']= $model->destroy($model->id);
        return $resul;

    }


    /**
     * restaura un item eliminado con softdelete
     */
    public function RestoreItemPurchase(Request $req){
        $resul= ['accion'=>'restore'];
        $model = PurchaseItem::withTrashed()->where('id',$req->id )->first();
        $resul['response']= $model->restore();
        $old = null;
        if($model->tipo_origen_id == 2){
            $old = CustomOrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 3){ // no requiere actualizacion por ahora

        }else if($model->tipo_origen_id == 21){
            $old = SolicitudeItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 22) {
            $old = OrderItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else if($model->tipo_origen_id == 23){
            $old = PurchaseItem:: find($model->origen_item_id);
            $resul['onRestore'] = $old;
        }else{
            $model->cantidad = ($req->has('cantidad')) ? $req->cantidad : null;
            $model->saldo = ($req->has('saldo')) ? $req->saldo : null;
            $model->uid = ($req->has('uid')) ? $req->uid : uid('', true);
        }
        if($old != null){
            $old->saldo = floatval($old->saldo ) - floatval($req->saldo) ;
            $old->save();
            $doc =  $old->document;
            $resul['data'] = ['old'=>$old, 'moel'=>$model];
            if($model->tipo_origen_id == 21 || $model->tipo_origen_id == 22 ){
                if($doc->items()->sum('saldo') == 0){
                    $doc->disponible = 0;
                    $doc->save();
                }
            }
        }
        return $resul;
    }

    /**
     * asigna el contra pedido a la orden de compra
     *
     **/
    public function addCustomOrderPurchase(Request $req){


        $model= CustomOrder::findOrFail($req->id);
        $items = $model->CustomOrderItem()->get();
        $resul= array();
        $resul['action']= "new";
        $newItems= array();
        $oldItems= array();
        $doc =Purchase::findOrFail($req->doc_id);

        $docItms= $doc->items()->where("tipo_origen_id",2)->get();
        foreach($items as $aux){
            if(
                sizeof($docItms->where('origen_item_id',$aux->id)->where('doc_origen_id',$req->id)) == 0){
                $item = $doc->newItem();
                $item->tipo_origen_id = 2;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id = $aux->id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->descripcion = $aux->descripcion;
                $item->producto_id = $aux->producto_id;
                $item->doc_origen_id = $model->id;
                $item->uid = $aux->uid;
                $aux->saldo= 0;
                $oldItems[] = $aux;
                $newItems[] = $item;
            }
        }
        $resul['newitems']=$newItems;
        $resul['oldItems']=$oldItems;
        $doc->items()->saveMany($newItems);
        $model->CustomOrderItem()->saveMany($oldItems);
        return $resul;
    }

    /**
     * elimina los item
     **/
    public function RemoveCustomOrderPurchase(Request $req){
        $resul["accion"]= "del";
        $model = PurchaseItem::where('doc_origen_id', $req->id)
            ->where('doc_id',$req->doc_id)
            ->where('tipo_origen_id', 2)
            ->get();
        $ids = array();
        $cOrders= CustomOrder::find($req->id);
        $cOrdersItem = $cOrders->items()->get();
        $cOrderNI=[];
        foreach($model as $aux){
            $ids[]= $aux->id;
            $coI = $cOrdersItem->where('id',$aux->origen_item_id)->first();
            if($coI != null){
                $coI->saldo =  floatval($coI->saldo) + floatval($aux->cantidad);
                $cOrderNI[] =$coI;
            }

        }

        PurchaseItem::destroy($ids);
        $cOrders->items()->saveMany($cOrderNI);
        $resul["keys"]=$ids;
        $resul["restore"]=$cOrderNI;

        return $resul;

    }


    /**
     * asigna un kitchenbox a un pedido
     **/
    public function addkitchenBoxPurchase(Request $req){

        $resul['action']="new";
        $doc = Purchase::findOrFail($req->doc_id);
        $k = KitchenBox::findOrFail($req->id);
        $item = new PurchaseItem();
        if ($req->has('reng_id')) {
            $resul['action'] = 'upd';
            $item = PurchaseItem::findOrFail($req->reng_id);
        }
        $item->tipo_origen_id = 3;
        $item->doc_id = $req->doc_id;
        $item->origen_item_id = $k->id;
        $item->cantidad = 1;
        $item->saldo = 1;
        $item->descripcion = $req->has('descripcion') ? $req->descripcion : $k->titulo;
        $item->producto_id = $k->producto_id;
        $item->uid = $req->uid;
        $item->costo_unitario = $req->costo_unitario;
        $item->doc_origen_id = $k->id;/// reemplazr cuando se sepa la logica
        $resul['response'] = $item->save();
        $resul['item'] = $item;
        return $resul;
    }

    /**
     * elimina el kitchenbox de un pedido
     **/
    public function removekitchenBoxPurchase(Request $req){
        $resul["accion"] = "del";
        $model = PurchaseItem::findOrFail($req->id);
        PurchaseItem::destroy($model->id);
        $resul["id"] = $req->id;
        return $resul;
    }

    /**
     *aprueba la solicutud dependiendo del usuario logeado
     */
    public function ApprovedPurchase(Request $req)
    {
        $result = [];
        $model = Purchase::findOrFail($req->id);
        if($this->user->cargo_id == '6' || $this->user->cargo_id == '8'){
            $model->fecha_aprob_gerencia= $req->fecha;
            $model->nro_doc = $req->nro_doc;
            $result['accion']='ap_gerencia';
        }else{
            $model->fecha_aprob_compra = $req->fecha;
            $model->nro_doc = $req->nro_doc;
            $result['accion']='ap_compras';

        }
        if($req->has("adjs")){

            foreach($req->adjs as $aux){
                $adj= new PurchaseAttachment();
                $adj->doc_id = $model->id;
                $adj->archivo_id = $aux['id'];
                $adj->documento = $result['accion'];
                $adj->save();
                $att[] = $adj;

            }
        }
        $model->save();
        $result['fecha'] = $model->fecha_aprob_gerencia;
        $result['nro_doc'] = $model->nro_doc;
        $result['response'] = $model->save();
        return $result;
    }


    public function cancelPurchase(Request $req)
    {
        $response = [];
        $model = Purchase::findOrFail($req->id);
        $model->comentario_cancelacion = $req->comentario_cancelacion;
        $model->final_id = $this->getFinalId($model);
        $model->disponible = 0;
        $response['response'] = $model->save();
        $response['success'] = 'Pedido Cancelado';
        $response['accion'] = $model->comentario_cancelacion == null ? 'new' : 'upd';

        foreach ($model->customOrderItems()->get() as $aux){
            $co = CustomOrderItem::where('uid',$aux->uid)->first();
            if($co != null){
                $co->saldo = floatval($co->saldo) + floatval($aux->cantidad);
                $co->save();
            }
        }
        foreach ($model->kitchenBoxs()->get() as $aux){
            $aux->saldo = 0;
            $aux->save();
        }

        $mail = new MailModule();
        $mail->doc_id = $model->id;
        $mail->tipo_origen_id = 22;
        $mail->asunto =$req->has('subject') ? $req->subject : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'order';
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto];
        $mail->clave= "cancel";
        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){
            foreach ($req->adjs as $f){
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }
        }

        $response['email'] = $mail->sendMail($req->content, $destinations);

        return $response;

    }


    /**
     * agrega el pedido al nuevo documento
     */
    public  function  addSustitutePurchase(Request $req){

        $resul = array();
        $princi = Purchase::findOrFail($req->princ_id);
        $reemplaze = Purchase::findOrFail($req->reemplace_id);
        $model = new Purchase();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);


        $princi->version = ($princi->parent_id == null) ? $princi->version + 1 : $princi->version;
        $princi->parent_id = $reemplaze->id;


        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;

        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();
        $reemplaze->ult_revision= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $model->ult_revision= Carbon::now();

        $princi->disponible= 0;
        $reemplaze->disponible= 0;

        $princi->uid = $reemplaze->uid;
        $model->uid = $reemplaze->uid;
        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($princi->items()->get() as $oldItem){
            $newItem = new PurchaseItem();
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newItem->uid =$oldItem->uid;
            $newIts[] = $newItem;
            $oldItem->saldo = 0;
            $oldItem->save();

        }
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new PurchaseItem();
            $newItem->tipo_origen_id =23;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->id;
            $newItem->doc_origen_id =$reemplaze->id;
            $newItem->cantidad =$oldItem->saldo;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newItem->uid =$oldItem->uid;

            $newIts[] = $newItem;
            $oldItem->saldo = 0;
            $oldItem->save();
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);

        return $resul;


    }

    /**
     * remueve el pedido al documento
     */
    public function removeSustitutePurchase(Request $req){
        $resul = array();
        $princi = Purchase::findOrFail($req->princ_id);
        $reemplaze = Purchase::findOrFail($req->reemplace_id);

        ///dd($princi);
        $model = new Purchase();
        $model = $this->transferDataDoc($princi,$model);
        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->uid = $princi->uid;
        $princi->fecha_sustitucion= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $princi->disponible= 0;
        $princi->final_id= $this->getFinalId($princi);
        $princi->save();
        $model->save();
        $newIts= array();

        $import = $princi->items()->where( function ($query) use ($reemplaze) {
            $query->where('doc_origen_id','<>', $reemplaze->id)
                ->orWhereNull('doc_origen_id')
            ;
        })->get();

        foreach($import as $oldItem){
            $newItem = new PurchaseItem();
            $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->saldo;
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->uid =$oldItem->uid;
            $newItem->costo_unitario =$oldItem->costo_unitario;

            $newIts[] = $newItem;

            $oldItem->saldo = 0;
            $oldItem->save();
        }

        foreach($princi->items()->where('doc_origen_id', $reemplaze->id)->get() as $oldItem){
            $ri = $reemplaze->items()->where('id', $oldItem->origen_item_id)->first();
            $ri->saldo = $oldItem->cantidad;
            $oldItem->saldo = 0;
            $oldItem->save();
            $ri->save();
        }


        $resul['accion']= "inpor";
        $resul['id']= $model->id;
        $reemplaze->fecha_sustitucion=null;
        $reemplaze->final_id= $this->getFinalId($reemplaze);
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
    }

    public function restorePurchase(Request $req){
        $resul = array();
        $princi = Purchase::findOrFail($req->princ_id);
        $reemplaze = Purchase::findOrFail($req->reemplace_id);
        $model = new Purchase();
        $model = $this->transferDataDoc($princi,$model);
        $princi->final_id= $this->getFinalId($princi);
        $reemplaze->final_id= $this->getFinalId($reemplaze);

        $princi->version = ($princi->parent_id == null) ? $princi->version + 1 : $princi->version;
        $princi->parent_id = $reemplaze->id;


        $model->version = $princi->version + 1;
        $model->parent_id = $princi->id;
        $model->uid= $princi->uid;


        $princi->fecha_sustitucion= Carbon::now();
        $reemplaze->fecha_sustitucion= Carbon::now();
        $reemplaze->ult_revision= Carbon::now();
        $princi->ult_revision= Carbon::now();
        $model->ult_revision= Carbon::now();

        $princi->disponible= 0;
        $reemplaze->disponible= 0;

        $princi->save();
        $reemplaze->save();
        $model->save();
        $newIts = array();
        foreach($reemplaze->items()->get() as $oldItem){
            $newItem = new PurchaseItem();
            $newItem->tipo_origen_id = $oldItem->tipo_origen_id;
            $newItem->doc_id =$model->id;
            $newItem->origen_item_id =$oldItem->origen_item_id;
            $newItem->doc_origen_id =$oldItem->doc_origen_id;
            $newItem->cantidad =$oldItem->cantidad;
            $newItem->saldo =$oldItem->cantidad; // precaucion el inten se restaura con la cantidad original
            $newItem->producto_id =$oldItem->producto_id;
            $newItem->descripcion =$oldItem->descripcion;
            $newItem->costo_unitario =$oldItem->costo_unitario;
            $newIts[] = $newItem;
        }

        $resul['accion']= "impor";
        $resul['id']= $model->id;
        $reemplaze->save();

        $resul['response']= $model->items()->saveMany($newIts);
        return $resul;
    }

    public function closeActionPurchase(Request $req)
    {
        $model = Purchase::findOrFail($req->id);


        $result['actions'] = ['save'];
        $senders =MailModule::where('tipo_origen_id','22')
            ->where('doc_id',$model->id)
            ->where('tipo','user')
            ->get();
        $result['send']= sizeof($senders);

        if(($model->fecha_aprob_compra != null || $model->fecha_aprob_gerencia != null) ){
            $result['actions'][] = 'sendPrv';
            return $result;
        }else{
            $result['actions'][] = 'sendIntern';
        }
        return $result;
    }
    /**
    agregar respuesta del proveedor
     */
    public function AddAnswerPurchase(Request $req){
        $response =[];
        $att =[];
        $doc= Purchase::findOrFail($req->id);
        $model = new PurchaseAnswer();
        $model->descripcion = $req->descripcion;
        $model->doc_id= $req->id;
        $model->save();

        $doc->ult_revision  = Carbon::now();
        $doc->save();
        $response['accion']= "new";
        if($req->has("adjs")){

            foreach($req->adjs as $aux){
                $adj= new PurchaseAnswerAttaments();
                $adj->doc_id = $doc->id;
                $adj->archivo_id = $aux['id'];
                $adj->save();
                $att[] = $adj;

            }
        }
        $model = PurchaseAnswer::findOrFail($model->id);
        $model->adjs =  $model->attachments()->lists('archivo_id');
        $response['id']=$model->id;
        $response['doc_id']=$model->doc_id;
        $response['model']=$model;
        $response['data']=$model;
        $response['items']=$att;
        return $response;

    }



    /**
     * adjuntos para la ordern de compra
     **/
    public function addAttachmentsPurchase(Request $req)
    {
        $model = Purchase::findOrFail($req->id);
        $resul = [ 'size' => sizeof($req->adjs) ,'files'=>[]];
        foreach ($req->adjs as $aux) {
            if(!array_key_exists('id',$aux )){
                $attac = new PurchaseAttachment();
                $attac->archivo_id = $aux['archivo_id'];
                $attac->doc_id = $model->id;
                $attac->documento = strtoupper($aux['documento']);
                $attac->save();

                $file= attachment_file($aux['archivo_id']);
                foreach ($file as $key => $value){
                    $attac[$key]= $value;
                }
                $resul['files'][]=$attac;
            }
        }


        return $resul;
    }

    /***/
    public function ClosePurchase(Request $req)
    {
        $result['success'] = "Registro guardado con éxito!";
        $result['action'][] = "close";
        $model = Purchase::findOrFail($req->id);

        $model->ult_revision = Carbon::now();
        $model->final_id = $this->getFinalId($model);
        $model->save();
        $result['id'] = $model->id;

        if($model->pago_factura_id == null){
            $result['fac']= $model->builtPaymentDocs();
        }
        if($model->nro_factura != null && $model->attachments()->where('documento','FACTURA')->count() > 0){
            /** envio de notificaciones **/
            $model->makedebt();
            $options = $this->templateNotif($model, 'emails.Purchase.InternalManager.es','purchase','update');

            $dest= array_merge($this->geUsersEMail('tbl_departamento.id = '.$this->departamentos['compras']), $this->geUsersEMail('tbl_cargo.id = '.$this->profile['gerente_adm']));
            $options['to'] = $dest;
            $mail = new MailModule();
            $mail->doc_id = $model->id;
            $mail->tipo_origen_id = 23;
            $mail->asunto =$options['subject'];
            $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
            $mail->tipo = 'sis';
            $mail->modulo = 'solicitude';
            $mail->save();
            $result['nofs']=  $mail->sendMail($options['template'], $options);


        }
        return $result;
    }

    /**
     * crea una copia del documento
     * @param id del documento a copiar
     * @param tipo de documento
     */
    public function copyPurchase(Request $req)
    {
        $resul["action"] = "copy";
        $newItems = array();
        $newAtt = array();
        $newModel = new Purchase();
        $oldModel = Purchase::findOrFail($req->id);

        $newModel = $this->transferDataDoc($oldModel, $newModel);
        $newModel->parent_id = $oldModel->id;
        $newModel->version = $oldModel->version + 1;
        $newModel->uid = $oldModel->uid;
        $newModel->save();
        $oldModel->cancelacion = Carbon::now();
        $oldModel->comentario_cancelacion = "#sistema: copiado por new id#" . $newModel->id;
        $oldModel->save();

        foreach ($oldModel->items()->get() as $aux) {
            $it = new PurchaseItem();
            $it->tipo_origen_id = $aux->tipo_origen_id;
            $it->doc_id = $newModel->id;
            $it->origen_item_id = $aux->origen_item_id;
            $it->doc_origen_id = $aux->doc_origen_id;
            $it->cantidad = $aux->cantidad;
            $it->saldo = $aux->saldo;
            $it->producto_id = $aux->producto_id;
            $it->descripcion = $aux->descripcion;
            $it->save();
            $newItems[] = $it;

        }
        foreach ($oldModel->items()->get() as $aux) {
            $it = new PurchaseItem();
            $it->tipo_origen_id = $aux->tipo_origen_id;
            $it->doc_id = $newModel->id;
            $it->origen_item_id = $aux->origen_item_id;
            $it->doc_origen_id = $aux->doc_origen_id;
            $it->cantidad = $aux->cantidad;
            $it->saldo = $aux->saldo;
            $it->producto_id = $aux->producto_id;
            $it->descripcion = $aux->descripcion;
            $it->save();
            $newItems[] = $it;

        }

        $resul['id'] = $newModel->id;
        return $resul;

    }


    public function sendPurchase(Request $req){
        $resul = ['action'=>'send'];
        $model = Purchase::findOrFail($req->id);
        $sends =MailModule::where('tipo_origen_id','23')
            ->where('doc_id',$model->id)
            ->where('tipo','user')
            ->whereNotNull('send')
            ->get();
        $mail = new MailModule();
        $mail->doc_id = $model->id;
        $mail->tipo_origen_id = 21;
        $mail->asunto =$req->has('subject') ? $req->subject : '' ;
        $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
        $mail->tipo = 'user';
        $mail->modulo = 'solicitude';
        $destinations = ['to'=>[],'cc'=>[], 'ccb'=>[],'attsData'=>[],'subject'=>$mail->asunto];
        if(sizeof($sends) == 0){
            $mail->clave= 'created';
        }
        if($req->has('to')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'to' ;
                $destinations['to'][] =$dest;
            }
        }
        if($req->has('cc')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'cc' ;
                $destinations['cc'][] =$dest;

            }
        }
        if($req->has('ccb')){
            foreach ($req->to as $aux){
                $dest = new MailModuleDestinations();
                $dest->email = $aux['correo'];
                $dest->nombre = $aux['nombre'];
                $dest->tipo = 'ccb' ;
                $destinations['ccb'][] =$dest;
            }
        }
        $mail->save();
        $mail->senders()->saveMany($destinations['to']);
        $mail->senders()->saveMany($destinations['cc']);
        $mail->senders()->saveMany($destinations['ccb']);
        if($req->has('adjs')){
            foreach ($req->adjs as $f){
                $destinations['atts'][] = ['data'=>storage_disk_path('orders',$f['tipo'].$f['file']),'nombre'=>$f['file']];
            }
        }

        $resul['email'] = $mail->sendMail($req->content, $destinations);
        if(!$resul['email']['is']){
            $model->final_id= null;

        }else{
            $model->ult_revision = Carbon::now();
            $model->final_id = $this->getFinalId($model);
            $model->ult_revision = Carbon::now();
            $model->final_id = $this->getFinalId($model);

            /** envio de notificaciones **/
            $options = $this->templateNotif($model, 'emails.Purchase.InternalManager.es','order',$req->action);
            $options['atts'][]= ['data'=>$resul['email']['attOff']['data'],'nombre'=>$model->id.'_A_Proveedor.pdf'];
            $resul['email']['attOff'] ='';
            $dest= array_merge($this->geUsersEMail('tbl_departamento.id = '.$this->departamentos['compras']), $this->geUsersEMail('tbl_cargo.id = '.$this->profile['gerente_adm']));
            $options['to'] = $dest;
            $mail = new MailModule();
            $mail->doc_id = $model->id;
            $mail->tipo_origen_id = 23;
            $mail->asunto =$options['subject'];
            $mail->usuario_id = $req->session()->get('DATAUSER')['id'];
            $mail->tipo = 'sis';
            $mail->modulo = 'solicitude';
            $mail->save();
            $resul['nofs']=  $mail->sendMail($options['template'], $options);
        }

        if($model->pago_factura_id == null){
            $result['fac']= $model->builtPaymentDocs();
        }
        $model->save();
        return $resul;

    }

    /**
     * Asigna el parent a un pedido(proforma)
     */
    public function setParentPurchase(Request $req){
        $resul = ['accion'=>'upd', 'changes' => [],'new'=>[], 'old'=>[],'co'=>[]];
        $model = Purchase::findOrFail($req->id);
        $so = Order::findOrFail($req->doc_parent_id);
        $model->doc_parent_id= $req->doc_parent_id;
        $model->doc_parent_origen_id= $req->doc_parent_origen_id;

        if($req->has('monto')){
            $model->monto = $req->monto;
            $resul['changes']['monto']=$model->monto;
        }
        if($req->has('titulo')){
            $model->titulo = $req->titulo;
            $resul['changes']['titulo']=$model->titulo;
        }
        if($req->has('pais_id')){
            $model->pais_id = $req->pais_id;
            $resul['changes']['pais_id']=$model->pais_id;
        }

        if($req->has('motivo_id')){
            $model->motivo_id = $req->motivo_id;
            $resul['changes']['motivo_id'] =$model->motivo_id;
        }
        if($req->has('prov_moneda_id')){
            $model->prov_moneda_id = $req->prov_moneda_id;
            $resul['changes']['prov_moneda_id']= $model->prov_moneda_id;
        }

        if($req->has('mt3')){
            $model->mt3 = $req->mt3;
            $resul['changes']['mt3'] = $model->mt3;
        }
        if($req->has('peso')){
            $model->peso = $req->peso;
            $resul['changes']['peso']= $model->peso;
        }
        if($req->has('direccion_almacen_id')){
            $model->direccion_almacen_id = $req->direccion_almacen_id;
            $resul['changes']['direccion_almacen_id']= $model->direccion_almacen_id;
        }
        if($req->has('direccion_facturacion_id')){
            $model->direccion_facturacion_id = $req->direccion_facturacion_id;
            $resul['changes']['direccion_facturacion_id']= $model->direccion_facturacion_id;
        }
        if($req->has('puerto_id')){
            $model->puerto_id = $req->puerto_id;
            $resul['changes']['puerto_id']= $model->puerto_id;
        }
        if($req->has('condicion_id')){
            $model->condicion_id = $req->condicion_id;
            $resul['changes']['condicion_id'] = $model->condicion_id;
        }
        if($req->has('tasa')){
            $model->tasa = $req->tasa;
            $resul['changes']['tasa']= $model->tasa;
        }
        if($req->has('comentario')){
            $model->comentario = $req->comentario;
            $resul['changes']['comentario'] = $model->comentario;
        }
        if($req->has('items')){
            foreach ($req->items as $id){
                $aux = OrderItem::findOrFail($id);
                $item= new PurchaseItem();
                $item->tipo_origen_id = $req->doc_parent_origen_id;
                $item->doc_id = $model->id;
                $item->origen_item_id =$aux->id;
                $item->doc_origen_id =$aux->doc_id;
                $item->cantidad = $aux->saldo;
                $item->saldo = $aux->saldo;
                $item->producto_id = $aux->producto_id;
                $item->descripcion = $aux->descripcion;
                $item->costo_unitario = $aux->costo_unitario;
                $aux->saldo = 0;
                $aux->save();
                $item->save();
                $co= $aux->customOrder;
                if($co !=  null){
                    $co->saldo =  0;
                    $co->save();
                    $resul['co']= $co;
                }

                $resul['new'][]= $item;
                $resul['old'][]= $aux;

            }
        }
        $so->disponible= 0;
        $so->save();
        $model->save();
        return $resul;
    }


    /**
     *  compara una proforma  y una orden de compra y muestra las diferencias por campos entre ellos
     */
    public function getOrderCompareOrder(Request $req)
    {
        $data = array();
        $error = array();
        $asigna = [];
        $compare = array('titulo', 'pais_id', 'motivo_id', 'prov_moneda_id', 'mt3', 'peso',
            'direccion_almacen_id', 'direccion_facturacion_id', 'puerto_id', 'condicion_id', 'tasa', 'comentario'
        );
        $princi = Purchase::findOrFail($req->id);// id de la proforma
        $import = Order::findOrFail($req->compare);// id de la solicitud
        $asigna['monto'] = $princi->monto + $import->monto;
        $asigna['mt3'] = $princi->mt3 + $import->mt3;


        foreach ($compare as $aux) {
            $ordval = $princi->getAttributeValue($aux);
            $solval = $import->getAttributeValue($aux);
            $data['comp'][] = array('ord' => $ordval, 'solv' => $solval, 'key' => $aux);
            if ($solval == null && $ordval != null) {
                $asigna[$aux] = $ordval;
            } else if ($solval != null && $ordval == null) {
                $asigna[$aux] = $solval;
            } else
                if ($solval != null && $ordval != null) {

                    if ($solval != $ordval) {
                        $temp0 = array();
                        $temp1 = array();
                        $temp0['key'] = $solval;
                        $temp1['key'] = $ordval;

                        switch ($aux) {

                            case "prov_moneda_id":
                                $mon = Monedas::findOrFail($solval);
                                $mon2 = Monedas::findOrFail($ordval);
                                $temp0['text'] = $mon->nombre;
                                $temp1['text'] = $mon2->nombre;
                                break;
                            case "pais_id":
                                $mon = Country::find($solval);
                                $mon2 = Country::find($ordval);
                                if ($mon != null) {
                                    $temp0['text'] = $mon->short_name;
                                }
                                if ($mon2 != null) {
                                    $temp1['text'] = $mon2->short_name;
                                }
                                break;
                            case "motivo_id":
                                $mon = OrderReason::findOrFail($solval);
                                $mon2 = OrderReason::findOrFail($ordval);
                                $temp0['text'] = $mon->motivo;
                                $temp1['text'] = $mon2->motivo;
                                break;
                            case "direccion_almacen_id" || "direccion_facturacion_id":
                                $mon = ProviderAddress::find($solval);
                                $mon2 = ProviderAddress::find($ordval);
                                if ($mon != null) {
                                    $temp0['text'] = $mon->short_name;
                                }
                                if ($mon2 != null) {
                                    $temp1['text'] = $mon2->short_name;
                                }

                                break;
                            /*       case "direccion_facturacion_id":
                                       $mon=ProviderAddress::findOrFail($solval);
                                       $mon2=ProviderAddress::findOrFail($ordval);
                                       $temp0['text'] =$mon->direccion;
                                       $temp1['text'] =$mon2->direccion;
                                       break;*/
                            case "puerto_id" :
                                $mon = Ports::findOrFail($solval);
                                $mon2 = Ports::findOrFail($ordval);
                                $temp0['text'] = $mon->Main_port_name;
                                $temp1['text'] = $mon2->Main_port_name;
                                break;
                            case "condicion_id" :
                                $mon = OrderCondition::findOrFail($solval);
                                $mon2 = OrderCondition::findOrFail($ordval);
                                $temp0['text'] = $mon->Main_port_name;
                                $temp1['text'] = $mon2->Main_port_name;
                                break;


                        }
                        $error[$aux][] = $temp0;
                        $error[$aux][] = $temp1;

                    }
                }
        }
        $data['error'] = $error;
        $data['asignado'] = $asigna;
        $solItms = $import->items()->where('saldo','>', 0)->get();
        $data['items'] = $solItms;


        return $data;
    }

    /************************************************************** FIn orden de compra *************************************************************/


    /**agrega o quita item de la solicitud*/
    public function addRemoveSolicitudItems(Request $req){
        $resul['accion']= "new";
        $asig= array();
        $remo= array();
        $model= Solicitude::findOrFail($req->doc_id);
        foreach($req->items  as $aux){
            if($req->asignado){
                $item = new SolicitudeItem();
                $item->tipo_origen_id = $aux->tipo_origen_id;
                $item->doc_id = $req->doc_id;
                $item->origen_item_id= $aux->origen_item_id;
                $item->doc_origen_id= $aux->doc_origen_id;
                $item->cantidad= $aux->cantidad;
                $item->saldo= $aux->saldo;
                $item->producto_id= $aux->producto_id;
                $item->descripcion= $aux->descripcion;
                $item->save();
                $asig[]=$item;

            }else{
                $remo[]= $aux->id;
                $resul['accionSub']= "del";

            }
        }

        $resul['new']= $asig;
        $resul['del']= $remo;
        $resul['success']= "Items agregados";
        $model->item()->destroy($remo);

        return $resul;
    }

    /**agrega o quita item de la solicitud*/
    public function addRemovePurchaseItems(Request $req){
        $resul['accion']= "new";
        $asig= array();
        $remo= array();
        $model= Purchase::findOrFail($req->doc_id);
        foreach($req->items  as $aux){
            if($req->asignado){
                $item = new PurchaseItem();
                $item->tipo_origen_id = $aux['tipo_origen_id'];
                $item->doc_id = $req->doc_id;
                $item->origen_item_id= $aux['origen_item_id'];
                $item->doc_origen_id= $aux['doc_origen_id'];
                $item->cantidad= $aux['saldo'];
                $item->saldo= $aux['saldo'];
                $item->producto_id= $aux['producto_id'];
                $item->descripcion= $aux['descripcion'];
                $item->save();
                $asig[]=$item;

            }else{
                $remo[]= $aux->id;
                $resul['accionSub']= "del";
            }
        }

        $resul['new']= $asig;
        $resul['del']= $remo;
        $resul['success']= "Items agregados";
        $model->destroy($remo);

        return $resul;
    }


    /**agrega o quita item de la solicitud*/
    public function addRemovePurchaseItem(Request $req){
        $resul['accion']= "new";
        if($req->asignado){
            $model = new PurchaseItem();
            $model->tipo_origen_id = $req->tipo_origen_id;
            $model->doc_id = $req->doc_id;
            $model->origen_item_id= $req->origen_item_id;
            $model->doc_origen_id= $req->doc_origen_id;
            $model->cantidad= $req->cantidad;
            $model->saldo= $req->saldo;
            $model->producto_id= $req->producto_id;
            $model->descripcion= $req->descripcion;
            if($req->has("final_id")){
                $model->final_id= $req->final_id;

            }
            $resul['response']=$model->save();
            $resul['renglon_id']=$model->id;


        }else{
            $resul['accion']= "del";
            $resul['response']=PurchaseItem::destroy($req->id);
        }
        return $resul;
    }

    /**agrega o quita item de la solicitud*/
    public function addRemoveOrderItem(Request $req){
        $resul['accion']= "new";
        if($req->asignado){
            $model = new OrderItem();
            $model->tipo_origen_id = $req->tipo_origen_id;
            $model->doc_id = $req->doc_id;
            $model->origen_item_id= $req->origen_item_id;
            $model->doc_origen_id= $req->doc_origen_id;
            $model->cantidad= $req->cantidad;
            $model->saldo= $req->saldo;
            $model->producto_id= $req->producto_id;
            $model->descripcion= $req->descripcion;
            if($req->has("final_id")){
                $model->final_id= $req->final_id;

            }
            $resul['response']=$model->save();
            $resul['renglon_id']=$model->id;


        }else{
            $resul['accion']= "del";
            $resul['response']=OrderItem::destroy($req->id);
        }
        return $resul;
    }


    /**
     * cambio el estado de una solicitud
     */
    public function setStatusSolicitude(Request $req){
        $resul = array();
        $model = Solicitude::findOrFail($req->id);
        $status = OrderStatus::findOrfail($req->estado_id);
        $model->estado_id = $req->estado_id;
        $model->save();
        $resul['success']='Estado actualizado';
        $resul['accion']='upd';
        $resul['item'] = $status;
        return $resul;
    }



    /**
     * cambio el estado de una solicitud
     */
    public function setStatusOrder(Request $req){
        $resul = array();
        $model = Order::findOrFail($req->id);
        $status = OrderStatus::findOrfail($req->estado_id);
        $model->estado_id = $req->estado_id;
        $model->save();
        $resul['success']='Estado actualizado';
        $resul['accion']='upd';
        $resul['item'] = $status;
        return $resul;
    }
    /**
     * cambio el estado de una solicitud
     */
    public function setStatusPurchase(Request $req){
        $resul = array();
        $model = Purchase::findOrFail($req->id);
        $status = OrderStatus::findOrfail($req->estado_id);
        $model->estado_id = $req->estado_id;
        $model->save();
        $resul['accion']='upd';
        $resul['success']='Estado actualizado';
        $resul['item'] = $status;
        return $resul;
    }





    /**
     * llena los camppos de los filtros
     */
    public function getFilterData()
    {

        $data= Array();
        $data['monedas']= Monedas::select('nombre', 'id')->where("deleted_at",NULL)->get();
        $data['tipoEnvio']= ProvTipoEnvio::select('nombre', 'id')->where("deleted_at",NULL)->get();
        return $data;
    }


    /**
     * obtine el pedido con sus item sin separar
     */
    public function getOrderSustitute(Request $req){

        $doc= $this->getDocumentIntance($req->tipo);
        $model= $doc->findOrFail($req->id);
        $docIts= $doc->findOrFail($req->doc_id)->items()->get();

        $prov= Provider::findOrFail($model->prov_id);

        $tipos = SourceType::get();

        //para maquinas
        $tem = array();
        $tem['id']=$model->id;
        $tem['tipo_id']=$model->tipo_id;
        $tem['pais_id']=$model->pais_id;
        $tem['final_id']=$model->final_id;
        $tem['direccion_almacen_id']=$model->direccion_almacen_id;
        $tem['condicion_pago_id']=$model->condicion_pago_id;
        $tem['motivo_pedido_id']=$model->motivo_pedido_id;
        $tem['prioridad_id']=$model->prioridad_id;
        $tem['condicion_pedido_id']=$model->condicion_pedido_id;
        $tem['prov_moneda_id']=$model->prov_moneda_id;
        $tem['estado_id']=$model->estado_id;
        $tem['doc_parent_id']=$model->doc_parent_id;
        $tem['doc_parent_origen_id']=$model->doc_parent_origen_id;
        // pra humanos
        $tem['comentario']=$model->comentario;
        $tem['tasa']=$model->tasa;
        $tem['proveedor']=$prov->razon_social;
        $tem['documento']= $model->type;
        $tem['titulo']= $model->titulo;
        $tem['diasEmit']=$model->daysCreate();
        $tem['fecha_aprob_compra'] =$model->fecha_aprob_compra ;
        $tem['fecha_aprob_gerencia'] =$model->fecha_aprob_compra ;
        $tem['img_aprob'] =$model->fecha_aprob_compra ;
        $tem['condicion_cp'] =$model->condicion_cp ;

        $tem['estado']=OrderStatus::findOrFail($model->estado_id)->estado;

        if($model->motivo_id){
            $tem['motivo']=OrderReason::findOrFail($model->motivo_id)->motivo;
        }
        if($model->pais_id){
            $tem['pais']=Country::findOrFail($model->pais_id)->short_name;
        }
        if($model->prioridad_id){
            $tem['prioridad']=OrderPriority::findOrFail($model->prioridad_id)->descripcion;
        }
        if($model->prov_moneda_id){
            $mone=Monedas::findOrFail($model->prov_moneda_id);
            $tem['symbol']=$mone->simbolo;
            $tem['moneda']=$mone->nombre;
        }
        if($model->direccion_facturacion_id != null){
            $tem['dir_facturacion']= ProviderAddress::findOrFail($model->direccion_facturacion_id)->direccion;
        }

        if($model->direccion_almacen_id != null){
            $tem['dir_almacen']= ProviderAddress::findOrFail($model->direccion_almacen_id)->direccion;
        }
        if($model->condicion_pago_id != null && $model->condicion_pago_id != 0 ){
            $aux = ProviderCondPay::findOrFail($model->condicion_pago_id);
            $items = $aux->getItems()->get();
            $text='';
            if(sizeof($items) > 0){
                foreach( $items  as $aux2){
                    $text=$text.$aux2->porcentaje.'% al '.$aux2->descripcion.$aux2->dias.' dias';
                }
            }else{
                $text = $aux->titulo;
            }
            $tem['condicion_pago']= $text;

        }
        if($model->puerto_id != null){
            $tem['puerto'] = Ports::findOrFail($model->puerto_id)->Main_port_name;
        }





        $tem['nro_proforma']=$model->nro_proforma;
        $tem['nro_factura']=$model->nro_factura;
        $tem['img_proforma']=$model->img_proforma;
        $tem['img_factura']=$model->img_factura;
        $tem['mt3']=$model->mt3;
        $tem['peso']=$model->peso;
        $tem['emision']=$model->emision;
        $tem['monto']=$model->monto;


        $prods = [];
        foreach($model->items()->get() as $item){
            $produc=Product::findOrFail($item->producto_id);
            $prod = [];
            // $prod = $item;
            $prod['id']= $item->id;
            $prod['producto_id']= $item->producto_id;
            //$prod['asignadoOtro']= [];
            $prod['codigo']= $item->codigo;
            $prod['descripcion']= $item->descripcion;
            $prod['doc_id']= $item->doc_id;
            $prod['cantidad']= $item->cantidad;
            $prod['saldo']= $item->saldo;
            $prod['cod_fabrica']= $produc->cod_fabrica;
            $prod ['documento'] = $tipos->where('id', $item->tipo_origen_id )[0]->descripcion;
            $prod['asignado']= false;
            $prod['inDoc']= 0;


            if(sizeof($docIts->where('tipo_origen_id', $req->tipo)->where('origen_item_id',$item->id))){
                $di =  $docIts->where('tipo_origen_id', $req->tipo)->where('origen_item_id',$item->id)->first();
                $prod['asignado']= true;
                $prod['reng_id']=$di->id;
                $prod['inDoc']= $di->cantidad;
            }

            $prods[]=$prod;

        }
        $tem['productos'] = $prods;


        // modificar cuando se sepa la logica
        $tem['aero']=1;
        $tem['version']=1;
        $tem['maritimo']=1;
        $atts = array();

        foreach($model->attachments()->get() as $aux){
            $auxFile= array();
            $file= FileModel::findOrFail($aux->archivo_id);
            $att['id'] = $aux->id;
            $att['final_id'] = $aux->final_id;
            $att['archivo_id'] = $aux->archivo_id;
            $att['doc_id'] = $aux->doc_id;
            $att['documento'] = $aux->documento;
            $att['comentario'] = $aux->comentario;

            $auxFile['id']=$file->id;
            $auxFile['thumb']=$file->getThumbName();
            $auxFile['tipo']=$file->tipo;
            $auxFile['file'] = $file->archivo;
            $att['file'] = $auxFile;
            $atts[]= $att;



        }
        $tem['adjuntos'] = $atts;



        /* $items= $model->items()->get();
         $products= Array();
         foreach($items as $aux){

             // $aux['origen']=MasterOrderController::getTypeProduct($aux)['descripcion'];
             $aux['asignado']=false;
             $ordI= OrderItem::where('pedido_id', $req->pedido_id)
                 ->where('origen_item_id', $aux->id)
                 ->first();
             if($ordI != null){
                 $aux['asignado']=true;
             }

             $products[]=$aux;
         }
         $model['productos']= $products;

         return $model;*/
        return $tem;
    }



    /*********************************** CONTRAPEDIDOS ***********************************/

    /**
    regresa el estado de un contra pedidos
     * incluye informacion de si esta se ha utilizado en otros documentos
     *
     **/
    public function  getCustomOrderReview (Request $req){

        $items = CustomOrderItem::where('doc_id', $req->id)->get();
        $model = $this->getDocumentIntance($req->tipo);
        $model  = $model->findOrFail($req->doc_id);
        $data = [];
        foreach ($items as $aux){
            $hh = ItemsInMdlOrders::where('uid', $aux->uid)
                ->where('tbl_disponible','1')
                ->where('tbl_uid','<>',$model->uid)
                ->where('saldo','>','0')
                ->get();
            if(sizeof($hh)  > 0) {
                $data = array_merge($data,$hh->toarray() );
            }
        }


        return $data;


    }


    /**
     * obtiene un contra pedido con sus productos
     */
    public function getCustomOrder(Request $req){

        $model=CustomOrder:: findOrFail($req->id);
        $doc= $this->getDocumentIntance($req->tipo);
        $doc = $doc->findOrFail($req->doc_id);
        $prods = array();
        $docIts = $doc->items()->get();
        $items =$model->CustomOrderItem()->get();
        $prodsProv= Product::where('prov_id', $model->prov_id)->get();

        $sourceType = SourceType::get();

        foreach($items as $aux){
            $aux->asignado = false;

            $asigOtro = array();
            $paso = true;
            if($aux->saldo <= 0){
                //$tem['saldo'] = $aux->saldo;
                $paso= false;
            }
            switch ($req->tipo){
                case  21:
                    $solIts = SolicitudeItem::where('uid',$aux->uid)
                        ->where('doc_origen_id','<>',$doc->id)
                        ->get();
                    $orderIts = OrderItem::where('uid',$aux->uid)->get();
                    $purchaIts = PurchaseItem::where('uid',$aux->uid)->get();

                    if(sizeof($orderIts->where('origen_item_id',$aux->id)) > 0){

                        $asigOtro[] = array( $sourceType->where('id','21')->first()->descripcion,$orderIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($purchaIts->where('origen_item_id',$aux->id)) > 0){
                        $asigOtro[] = array( $sourceType->where('id','23')->first()->descripcion ,$purchaIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($solIts->where('origen_item_id',"<>",$aux->id)) > 0){
                        $asigOtro[] = array( $sourceType->where('id','22')->first()->descripcion,$solIts->where('doc_origen_id',$aux->id) );
                    }
                    ;break;
                case  22:
                    $solIts = SolicitudeItem::where('uid',$aux->uid)->get();
                    $orderIts = OrderItem::where('uid',$aux->uid)
                        ->where('doc_origen_id','<>',$doc->id)
                        ->get();
                    $purchaIts = PurchaseItem::where('uid',$aux->uid)->get();
                    if(sizeof($solIts->where('origen_item_id',$aux->id)) > 0){
                        $asigOtro[] = array($sourceType->where('id','21')->first()->descripcion ,$solIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($purchaIts->where('origen_item_id',$aux->id)) > 0){
                        $asigOtro[] = array($sourceType->where('id','23')->first()->descripcion ,$purchaIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($orderIts->where('doc_origen_id',"<>",$aux->id)) > 0){
                        $asigOtro[] = array($sourceType->where('id','22')->first()->descripcion ,$orderIts->where('doc_origen_id',$aux->id) );
                    }

                    ;break;
                case  23:
                    $solIts = SolicitudeItem::where('uid',$aux->uid)->get();
                    $orderIts = OrderItem::where('uid',$aux->uid)->get();
                    $purchaIts = PurchaseItem::where('uid',$aux->uid)
                        ->where('doc_origen_id','<>',$doc->id)
                        ->get();
                    if(sizeof($solIts->where('origen_item_id',$aux->id)) > 0){
                        $asigOtro[] = array($sourceType->where('id','21')->first()->descripcion ,$solIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($orderIts->where('origen_item_id',$aux->id)) > 0){
                        $asigOtro[] = array($sourceType->where('id','22')->first()->descripcion ,$orderIts->where('doc_origen_id',$aux->id) );
                    }
                    if(sizeof($purchaIts->where('origen_item_id',"<>",$aux->id)) > 0){
                        $asigOtro[] = array($sourceType->where('id','23')->first()->descripcion  ,$purchaIts->where('doc_origen_id',$aux->id) );
                    }
                    ;break;
            }
            if($paso){
                $prd = $prodsProv->where('id',$aux->producto_id)->first();

                $aux['asignadoOtro']=  $asigOtro;
                //pertence a productos
                $aux['codigo_fabrica'] =$prd->codigo_fabrica;
                $aux['codigo'] =$prd->codigo;
                $aux->disponible = floatval($aux->saldo);
                $aux->costo_unitario = ($aux->costo_unitario == null) ? $aux->costo_unitario : floatval($aux->costo_unitario);

                $exist =$docIts->where('uid', $aux->uid)->first();

                if(sizeof($exist) >0 ){
                    $aux->asignado = true;
                    $aux->reng_id = $exist->id;
                    $aux->disponible = floatval($aux->saldo) + floatval($exist->cantidad) ;
                    $aux->inDoc = $exist->cantidad ;
                    $aux->inDocBlock = floatval($exist->cantidad) -  floatval($exist->saldo );
                }


                $prods[]= $aux;

            }

        }


        $model['motivo_contrapedido'] = (CustomOrderReason::find($model->motivo_contrapedido_id) != null) ? CustomOrderReason::find($model->motivo_contrapedido_id)->motivo : 'Desconocido';
        $model['motivo_contrapedido_id'] =$model->motivo_contrapedido_id;
        $model['tipo_envio'] = (ProvTipoEnvio::find($model->tipo_envio_id) != null) ? ProvTipoEnvio::find($model->tipo_envio_id)->nombre : 'Desconocido';
        $model['prioridad'] = (CustomOrderPriority::find($model->prioridad_id) != null ) ? CustomOrderPriority::find($model->prioridad_id)->descripcion : 'Desconocido' ;
        $model['moneda'] = (Monedas::find($model->moneda_id)) ? Monedas::find($model->moneda_id)->simbolo.Monedas::find($model->moneda_id)->nombre : 'Desconocido';
        $model['items']= $prods;

        return $model;
    }


    public function getCustomOrders(Request $req){

        $data = Array();
        $items = CustomOrder::
        where('aprobada','1')
            ->where('prov_id',$req->prov_id)
            ->get();

        $doc= $this->getDocumentIntance($req->tipo);
        $doc = $doc->findOrFail($req->doc_id);
        $docIts = $doc->items()->get();
        $remplace= $docIts->where('tipo_origen_id', $req->tipo);
        $imports= array();
        if($req->tipo == 22){
            $imports = $docIts->where('tipo_origen_id','21');
        }
        if($req->tipo == 23){
            $imports = $docIts->where('tipo_origen_id','22');

        }
        foreach($items as $aux){
            $auxIts = $aux->CustomOrderItem()->get();
            $paso=true;
            $tem['asignado'] = false;

            // fue asignado
            if(sizeof($docIts->where('doc_origen_id', $aux->id)->where('tipo_origen_id','2'))>0){
                $tem['asignado'] = true;
            }

            // vino de otro docuemento igual?
            if(sizeof($remplace->where('doc_origen_id', $aux->id))>0){
                $tem['asignado'] = true;
            }

            // fue importado
            foreach($imports as $imps){
                $first= $this->getFirstProducto($imps);
                if($first->tipo_origen_id == 2 && $first->doc_origen_id == $aux->id){
                    $tem['asignado'] = true;
                    $tem['import'] = $imps;
                }
            }

            if(!$tem['asignado'] && sizeof($auxIts->sum('saldo')) == 0){
                $paso= false;
            }

            else{


            }

            if($paso){
                $tem['id'] =$aux->id;
                $tem['fecha'] =$aux->fecha;
                $tem['motivo_contrapedido_id'] =$aux->motivo_contrapedido_id;
                $tem['tipo_envio_id'] =$aux->tipo_envio_id;
                $tem['prioridad_id'] =$aux->prioridad_id;
                $tem['comentario'] =$aux->comentario;
                $tem['prov_id'] =$aux->prov_id;
                $tem['fecha_ref_profit'] =$aux->fecha_ref_profit;
                $tem['cod_ref_profit'] =$aux->cod_ref_profit;
                $tem['img_ref_profit'] =$aux->img_ref_profit;
                $tem['fecha_aprox_entrega'] =$aux->fecha_aprox_entrega;
                $tem['monto'] =$aux->monto;
                $tem['moneda_id'] =$aux->moneda_id;
                $tem['abono'] =$aux->abono;
                $tem['img_abono'] =$aux->img_abono;
                $tem['fecha_abono'] =$aux->fecha_abono;
                $tem['tipo_pago_contrapedido_id'] =$aux->tipo_pago_contrapedido_id;
                $tem['aprobada'] =$aux->aprobada;
                $tem['titulo'] =$aux->titulo;
                $data[]=$tem;
            }
            // }
        }
        return $data;
    }



    /*********************************** kitchen box (cocinas)*********************************************/

    /**
    regresa el estado de un contra pedidos
     * incluye informacion de si esta se ha utilizado en otros documentos
     *
     **/
    public function  getKitchenBoxReview (Request $req){
        $model = $this->getDocumentIntance($req->tipo);
        $model  = $model->findOrFail($req->doc_id);
        $data = ItemsInMdlOrders::where('doc_origen_id',  $req->id)
            ->where('tbl_disponible','1')
            ->where('saldo','>','0')
            ->where('tbl_uid','<>',$model->uid)
            ->get();

        return $data;


    }

    public function getKitchenBox(Request $req){
        $model=KitchenBox:: findOrFail($req->id);

        return $model;
    }
    /**
     * falta incluir a algortimo que determina si esta aprobado o no
     * obtiene los kitchen box de un proveedor
     */
    public function getKitchenBoxs(Request $req){

        $data = Array();
        $items = KitchenBox::
        where('prov_id',$req->prov_id)
            ->where('precio_bs','<>',0)
            ->whereNotNull('img_conf_gerente')
            ->whereNotNull('fecha_conf_gerente')
            ->get();

        $doc= $this->getDocumentIntance($req->tipo);
        $doc = $doc->findOrFail($req->doc_id);
        $docIts = $doc->items()->get();


        foreach($items as $aux){
            $aux['asignado'] =false;

            $it = $docIts->where('uid', $aux->uid)->first();

            if($it != null){

                $aux['asignado'] = true;
                $aux['reng_id'] = $it->id;
                $aux['costo_unitario'] = $it->costo_unitario;
            }
            $data[]= $aux;


        }


        return $data;
    }


    /*************************************** ORDEDENES DE COMPRA *****************************************

    /**
     * @deprecated
     * obtiene las ordenes de compra de un pedido
     */
    public function getOrdenPurchaseOrder(Request $req){
        return Order::findOrFail($req->id)->item()->where('pedido_tipo_origen_id',1);
    }

    /**
     * @deprecated
     * obtiene toda la data de un pedido
     */
    public function getOrden(Request $req){
        $aux=Order::findOrFail($req->id);
        $tem['id']=$aux->id;
        $tem['tipo_pedido_id']=$aux->tipo_pedido_id;
        $tem['pais_id']=$aux->pais_id;
        $tem['direccion_almacen_id']=$aux->direccion_almacen_id;
        $tem['condicion_pago_id']=$aux->condicion_pago_id;
        $tem['motivo_pedido_id']=$aux->motivo_pedido_id;
        $tem['prioridad_id']=$aux->prioridad_id;
        $tem['condicion_pedido_id']=$aux->condicion_pedido_id;
        $tem['prov_moneda_id']=$aux->prov_moneda_id;
        // pra humanos
        $tem['comentario']=$aux->comentario;
        $tem['proveedor']=Provider::findOrFail($aux->prov_id)->razon_social;
        $tem['motivo']=OrderReason::findOrFail($aux->motivo_pedido_id)->motivo;
        $tem['pais']=Country::findOrFail($aux->pais_id)->short_name;
        $tem['nro_proforma']=$aux->nro_proforma;
        $tem['nro_factura']=$aux->nro_factura;
        $tem['img_proforma']=$aux->img_proforma;
        $tem['img_factura']=$aux->img_factura;
        $tem['mt3']=$aux->mt3;
        $tem['peso']=$aux->peso;
        $tem['emision']=$aux->emision;
        $tem['monto']=$aux->monto;
        $tem['estado']=OrderStatus::findOrFail($aux->estado_id)->estado;
        $tem['prioridad']=OrderPriority::findOrFail($aux->prioridad_id)->descripcion;
        $tem['moneda']=Monedas::findOrFail($aux->prov_moneda_id)->nombre;
        $tem['symbol']=Monedas::findOrFail($aux->prov_moneda_id)->simbolo;
        $tem['diasEmit']=$aux->daysCreate();
        $tem['tipo']= OrderType::findOrFail($aux->tipo_pedido_id)->tipo;
        // $tem['productos'] = $this->getProductoOrden($aux);
        /**actualizar cuando este el final**/
        $tem['almacen']="Desconocido";

        // modificar cuando se sepa la logica
        $tem['aero']=1;
        $tem['version']=1;
        $tem['maritimo']=1;

        return $tem;

    }


    /**
     * obtiene los paises en que un provedor tiene
     * almacen
     **/
    public function getProviderCountry(Request $req){

        return (!$req->has('id')) ? $this->getCountryProvider($req->prov_id) : Country::where('id',$req->id)->get();
    }


    /**
     * obtiene los direcciones de
     * donde un proveeed
     * almacen
     **/
    public function getInvoiceAddressCountry(Request $req){
        if($req->has('id')){
            return ProviderAddress::where('id',$req->id)->get();
        }
        $data =ProviderAddress::where('prov_id', $req->prov_id)->where(
            function ($query){
                $query->where('tipo_dir',1)->orWhere('tipo_dir',3);
            })->get();
        if($req->has('pais_id')){
            $data = $data->where('pais_id', $req->pais_id);
        }
        return $data;
    }

    public function getStoreAddressCountry(Request $req){
        if($req->has('id')){
            return ProviderAddress::where('id',$req->id)->get();
        }
        $data =ProviderAddress::where('prov_id', $req->prov_id)->where(
            function ($query){
                $query->where('tipo_dir',2)->orWhere('tipo_dir',3);
            });
        if($req->has('pais_id')){
            $data->where('pais_id', $req->pais_id);
        }
        return $data->get();
    }

    /**
     * Las getProviderCoin de un proveedro
     * @deprecated
     **/
    public function getProviderCoins(Request $req){
        $model=  Provider::findOrFail($req->id);
        return $model->getProviderCoin()->get();
    }
    /**
     * Condiciones de pago de un proveedor
     **/
    public function getProviderPaymentCondition(Request $req){

        $auxCond = (!$req->has('id')) ?Provider::findOrFail($req->prov_id)->getPaymentCondition()->get() : ProviderCondPay::where('id',$req->id)->get();
        //$auxCond=Provider::findOrFail($req->prov_id)->getPaymentCondition()->get();
        $cond= Array();
        $i=0;
        $text='';
        foreach( $auxCond as $aux){
            $cond[$i]['id']= $aux->id;
            $items=$aux->getItems()->get();
            if(sizeof($items) > 0){
                foreach( $items  as $aux2){
                    $text=$text.$aux2->porcentaje.'% al '.$aux2->descripcion.$aux2->dias.' dias';
                }
            }else{
                $text = $aux->titulo;
            }
            $cond[$i]['titulo']= $text;
            $text='';
            $i++;
        }
        return $cond;
    }



    /*************************************** EXCEPTIONS *****************************************/

    /**
     * agregar una condicon de pago adicional a un producto
     */
    public function addProdConditionPurchase(Request $req){
        $resul = [];
        $item = new PurchaseItemCondition();
        $item->doc_id = $req->doc_id;
        $item->item_id=$req->id;
        $item->cantidad=$req->cantidad;
        $item->dias=$req->dias;
        $item->monto=$req->monto;
        $item->save();
        $resul['accion']= "new";

        $resul['item']= $item;

        return $resul;

    }

    /**
     * eliminae una condicon de pago adicional de un producto
     */
    public function removeProdConditionPurchase(Request $req){
        $resul = [];

        PurchaseItemCondition::destroy($req->id);
        $resul['accion']= "del";
        return $resul;

    }

    /*************************************** private *****************************************/


    /**
     * obtiene todos los producto de un pedido
     * @param obj Order
     * @return array de productos
     */
    private function getProductoItem($order){

        $items= $order->items()->get();

        $origen = SourceType::get();
        $contra=Collection::make(Array());
        $kitchen= Collection::make(Array());
        $pediSus= Collection::make(Array());
        $import= Collection::make(Array());
        $all= Collection::make(Array());
        $prod_prov = Product::where('prov_id', $order->prov_id)->get();

        /** contra pedido*/
        foreach($items->where('tipo_origen_id', '2') as $aux){
            if(!$contra->contains($aux->doc_origen_id)){
                $contra->push(CustomOrder::find($aux->doc_origen_id));
            }

        }
        /** kitceh box*/
        foreach($items->where('tipo_origen_id', '3') as $aux){
            $k = KitchenBox::find($aux->origen_item_id);
            $k->titulo = $aux->descripcion;
            $kitchen->push($k);
        }

        /** importados */
        foreach($items->where('tipo_origen_id', ''.$order->getTipoId()) as $aux){
            $first= $this->getFirstProducto($aux);
            switch($first->tipo_origen_id){
                case 2:
                    $tem= CustomOrder::findOrFail($first->doc_origen_id);
                    $tem['sustitute'] = $aux->doc_origen_id;
                    $contra->push($tem);
                    break;
                case 3:
                    $kitchen->push($aux);
                    $tem= KitchenBox::findOrFail($first->doc_origen_id);
                    $tem['sustituto'] = $aux->doc_origen_id;
                    break;
            }
            if(!$pediSus->contains($aux->doc_origen_id)){
                $pediSus[]=$order::find($aux->doc_origen_id);
            }

        }

        /** todos */
        foreach($items as $aux){
            $aux['asignado']= true;
            $doc = $origen->where('id', $aux->tipo_origen_id)->first();
            $aux['documento']=  $doc->descripcion;
            $aux['first']= $this->getFirstProducto($aux);
            $aux->producto;
            if($aux->producto != null){
                $aux->codigo_fabrica=  $aux->producto->codigo_fabrica;
                $aux->codigo=  $aux->producto->codigo_fabrica;
                $aux->cod_profit=  $aux->producto->cod_profit;
                $aux->cod_barra=  $aux->producto->cod_barra;
            }
            $all->push($aux);
        }

        if($order->getTipoId() == '22'){
            foreach($items->where('tipo_origen_id','21') as $aux){
                if(!$import->contains($aux->doc_origen_id)){
                    $tem = Solicitude::find($aux->doc_origen_id);
                    $tem->sustituto = $aux->id;
                    $import->push($tem);
                }
            }
        }
        if($order->getTipoId() == '23'){
            foreach($items->where('tipo_origen_id','22') as $aux){
                if(!$import->contains($aux->doc_origen_id)){
                    $tem = Order::find($aux->doc_origen_id);
                    $tem->sustituto = $aux->id;
                    $import->push($tem);
                }
            }
        }
        $data['contraPedido'] = $contra;
        $data['kitchenBox'] = $kitchen;
        $data['pedidoSusti'] = $pediSus;
        $data['import'] = $import;
        $data['todos'] = $all;
        return $data;
    }


    /**
     * obtiene los paises donde un provedor tiene paises
     */
    private function getCountryProvider($id){
        $model=  ProviderAddress::where('prov_id',$id)->get();
        $data= Collection::make(array());
        foreach($model as $aux){
            if(!$data->contains($aux->pais_id)){
                $p=Country::find($aux->pais_id);
                $data->push($p);
            }

        }
        return $data;
    }

    private function getDocumentIntance($tipo){
        switch($tipo){
            case 21:
                return new Solicitude();
                break;
            case 22:
                return new Order();
                break;
            case 23:
                return new  Purchase();
                break;
        }
    }

    /**
     * setea toda la data del modelo
     **/
    private function setDocItem($model, Request $req){
        $model->ult_revision = Carbon::now();
        if($model->usuario_id == null){
            $model->usuario_id = $req->session()->get('DATAUSER')['id'];
        }
        if($model->emision == null || !$req->has('emision')){
            $model->emision =  Carbon::now();
        }
        if($model->uid == null ){
            $model->uid = uniqid('',true);
        }

        $model->edit_usuario_id =$req->session()->get('DATAUSER')['id'];

        if($req->has('monto')){
            $model->monto = $req->monto;
        }
        if($req->has('tasa')){
            $model->tasa = ($req->tasa == '0') ? null : $req->tasa;
        }
        if($req->has('direccion_facturacion_id')){
            $model->direccion_facturacion_id = ($req->direccion_facturacion_id."" == "-1") ? null: $req->direccion_facturacion_id ;
        }


        if($req->has('prov_id')){
            $model->prov_id = ($req->prov_id."" == "-1") ? null: $req->prov_id;
        }
        if($req->has('monto')){
            $model->monto = $req->monto;
        }
        if($req->has('tasa')){
            $model->tasa = floatval( $req->tasa);
        }
        if($req->has('pais_id')){
            $model->pais_id = ($req->pais_id."" == "-1") ? null:$req->pais_id;
        }
        if($req->has('condicion_pago_id')){
            $model->condicion_pago_id = ($req->condicion_pago_id."" == "-1") ? null : $req->condicion_pago_id ;
        }
        if($req->has('prov_moneda_id')){
            $model->prov_moneda_id = ($req->prov_moneda_id."" == "-1") ? null: $req->prov_moneda_id ;
        }
        if($req->has('nro_proforma')  && array_key_exists('doc', $req->nro_proforma)){
            $model->nro_proforma = array_key_exists('doc', $req->nro_proforma) ? $req->nro_proforma['doc'] : null;
        }
        if($req->has('nro_factura')){
            $model->nro_factura =  array_key_exists('doc', $req->nro_factura) ? $req->nro_factura['doc'] : null;
        }
        if($req->has('comentario')){
            $model->comentario = $req->comentario;
        }
        if($req->has('estado_id')){
            $model->estado_id = $req->estado_id;
        }
        if($req->has('direccion_almacen_id')){
            $model->direccion_almacen_id = ($req->direccion_almacen_id."" == "-1") ? null :$req->direccion_almacen_id;
        }
        if($req->has('puerto_id')){
            $model->puerto_id = $req->puerto_id;
        }

        if($req->has('mt3')){
            $model->mt3 = $req->mt3;
        }
        if($req->has('peso')){
            $model->peso = $req->peso;
        }
        if($req->has('puerto_id')){
            $model->puerto_id = ($req->puerto_id."" == "-1") ? null : $req->puerto_id;
        }
        if($req->has('nro_doc')){
            $model->nro_doc = $req->nro_doc;
        }

        if($req->has('comentario_cancelacion','cancelacion')){
            $model->comentario_cancelacion = $req->comentario_cancelacion;
            $model->cancelacion = $req->cancelacion;
        }

        if($req->has('aprob_compras')){
            $model->aprob_compras = $req->aprob_compras;
        }

        if($req->has('aprob_gerencia')){
            $model->aprob_gerencia = $req->aprob_gerencia;
        }

        if($req->has('titulo')){
            $model->titulo = $req->titulo;
        }

        if($req->has('doc_parent_id')){
            $model->doc_parent_id = $req->doc_parent_id;
        }

        if($req->has('doc_parent_origen_id')){
            $model->doc_parent_id = $req->doc_parent_id;
        }


        return $model;

    }

    private function transferDataDoc($oldmodel, $newModel){
        /*        $newModel->nro_proforma = $oldmodel->nro_proforma;
                $newModel->nro_factura = $oldmodel->nro_factura;*/
        $newModel->usuario_id = $this->user->id;
        $newModel->edit_usuario_id = $this->user->id;
        $newModel->emision = $oldmodel->emision;
        $newModel->monto = $oldmodel->monto;
        $newModel->comentario = $oldmodel->comentario;
        $newModel->prov_id = $oldmodel->prov_id;
        $newModel->pais_id = $oldmodel->pais_id;
        $newModel->condicion_pago_id = $oldmodel->condicion_pago_id;
        //   $newModel->estado_id = $oldmodel->estado_id;
        $newModel->prov_moneda_id = $oldmodel->prov_moneda_id;
        $newModel->direccion_almacen_id = $oldmodel->direccion_almacen_id;
        $newModel->direccion_facturacion_id = $oldmodel->direccion_facturacion_id;
        $newModel->puerto_id = $oldmodel->puerto_id;
        //    $newModel->comentario_cancelacion = $oldmodel->comentario_cancelacion;
        $newModel->condicion_id = $oldmodel->condicion_id;
        $newModel->mt3 = $oldmodel->mt3;
        $newModel->peso = $oldmodel->peso;
        //     $newModel->fecha_aprob_compra = $oldmodel->fecha_aprob_compra;
        //     $newModel->fecha_aprob_gerencia = $oldmodel->fecha_aprob_gerencia;
        //    $newModel->aprob_compras = $oldmodel->aprob_compras;
        //       $newModel->aprob_gerencia = $oldmodel->aprob_gerencia;
        $newModel->culminacion = $oldmodel->culminacion;
        $newModel->nro_doc = $oldmodel->nro_doc;
        $newModel->tasa = $oldmodel->tasa;
        $newModel->version = $oldmodel->version;
        $newModel->titulo = $oldmodel->titulo;
        return $newModel;
    }

    /**obtiene los correos segun el departamento*/
    private function  geUsersEMail($condicion = null , $tipo = 'to'){
        $resul = [];
        $emails =  User::selectRaw(' distinct tbl_usuario.email as email,concat(tbl_usuario.nombre, \' \' ,tbl_departamento.nombre) as nombre')
            ->join('tbl_cargo','tbl_cargo.id','=','tbl_usuario.cargo_id')
            ->join('tbl_departamento','tbl_departamento.id','=','tbl_cargo.departamento_id');
        if($condicion != null){
            $emails = $emails->whereRaw($condicion);
        }
        $emails= $emails->get();
        foreach ($emails as $aux){
            $dest = new MailModuleDestinations();
            $dest->email = $aux->email;
            $dest->nombre = $aux->nombre;
            $dest->tipo = $tipo ;
            $dest->save();
            $resul[]= $dest;

        }
        return $resul;
    }
    public function templateNotif( $model,$file, $modulo, $proposito ){
        $lang = 'es';

        $result  = ['subject'=>'','to'=>[],'cc'=>[], 'ccb'=>[],'atts'=>[],'attsData'=>[]];
        $mailPart= App\Models\Sistema\MailModels\MailPart::where('modulo',$modulo)->where('proposito',$proposito)->first();
        $texto = $mailPart->subjets()->where('iso_lang',$lang)->orderByRaw('rand()')->first()->texto;
        $user =   $this->user;
        $result['subject'] = $texto;
        $template = View::make($file,[
            'subjet'=>'',
            'model'=>$model,
            'texto'=>$texto,
            'articulos'=>$model->items()->with('producto')->get(),
            'user'=>$user
        ])->render();
        $result['template']= $template;

        return $result;
    }


    /**@deprecated*/
    private  function  transferItem($oldItem, $newItem){
        //$newItem->final_id =$oldItem->final_id;
        $newItem->tipo_origen_id =$oldItem->tipo_origen_id;
        $newItem->doc_id =$oldItem->doc_id;
        $newItem->origen_item_id =$oldItem->origen_item_id;
        $newItem->doc_origen_id =$oldItem->doc_origen_id;
        $newItem->cantidad =$oldItem->cantidad;
        $newItem->saldo =$oldItem->saldo;
        $newItem->producto_id =$oldItem->producto_id;
        $newItem->descripcion =$oldItem->descripcion;

        return $newItem;

    }

    private function getFirstProducto($model){
        $aux = $model->replicate();

        $i =0;
        $traza= array();
        //dd($type);
        while(true || $i <5){
            if($aux->tipo_origen_id == 2 || $aux->tipo_origen_id == 3 || $aux->tipo_origen_id == 1){
                break;
            }
            if($aux->tipo_origen_id  == 21){

                $aux = SolicitudeItem::findOrFail($aux->origen_item_id);
            }else  if($aux->tipo_origen_id  == 22){
                $aux = OrderItem::findOrFail($aux->origen_item_id);
            }else{
                $aux = PurchaseItem::findOrFail($aux->origen_item_id);
            }


            $i = $i +1;
            $traza[]= $aux;
        }

        return $aux;
    }


    private function getFinalId($model){
        return  "tk".$model->id."-v".$model->version."-i".sizeof($model->items()->get())
        ."-a".sizeof($model->attachments()->get());
    }

    private function generateProviderEmit($campo, $condicion){
        $q= "IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
            ." tbl_compra_orden where tbl_proveedor.id= prov_id and tbl_compra_orden.deleted_at is null
             and tbl_compra_orden.fecha_sustitucion is null ),0) "
            ." + "
            ."IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
            ." tbl_pedido where tbl_proveedor.id= prov_id  and tbl_pedido.deleted_at is null
             and tbl_pedido.fecha_sustitucion is null  ),0) "
            ." + "
            ."IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
            ." tbl_solicitud where tbl_proveedor.id= prov_id and tbl_solicitud.deleted_at is null
             and tbl_solicitud.fecha_sustitucion is null),0) "
            .""
        ;
        return $q;
    }    private function generateProviderQuery($campo, $condicion){
    $q= "IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
        ." tbl_compra_orden where tbl_proveedor.id= prov_id and tbl_compra_orden.deleted_at is null
             and tbl_compra_orden.fecha_sustitucion is null  and tbl_compra_orden.comentario_cancelacion is null  ),0) "
        ." + "
        ."IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
        ." tbl_pedido where tbl_proveedor.id= prov_id  and tbl_pedido.deleted_at is null
             and tbl_pedido.fecha_sustitucion is null and tbl_pedido.comentario_cancelacion is null  ),0) "
        ." + "
        ."IFNULL((select sum(case WHEN datediff( curdate(),".$campo.") ".$condicion." then 1 else 0 END) from "
        ." tbl_solicitud where tbl_proveedor.id= prov_id and tbl_solicitud.deleted_at is null
             and tbl_solicitud.fecha_sustitucion is null and tbl_solicitud.comentario_cancelacion is null),0) "
        .""
    ;
    return $q;
}


    private function oldReview(){
        return 30;
    }

    private function outputDate($databd){
        return  date_format(date_create($databd),'d-m-Y');
    }

    private function parseDocToSummaryEmail($model){
        $data = [];
        $items = $model->items()->get();
        $data['id'] = $model->id;
        $data['tipo'] = $model->getTipoId();
        $data['emision'] =  $this->outputDate($model->emision);
        $data['version'] = $model->version;
        $data['documento'] = $model->getTipo();
        $data['titulo'] = $model->titulo;
        $data['proveedor'] = Provider::findOrFail($model->prov_id)->razon_social;
        $data['responsable'] =$this->request->session()->get('DATAUSER')['nombre'];
        $data['correo'] = $this->request->session()->get('DATAUSER')['email'];
        $data['nro_proforma'] = ($model->nro_proforma != null) ? $model->nro_proforma : $this->defaulString;
        $data['nro_factura'] = ($model->nro_factura != null) ? $model->nro_factura : $this->defaulString;
        $data['monto'] =($model->prov_moneda_id == null) ? $this->defaulString:Monedas::findOrFail($model->prov_moneda_id)->symbolo.$model->monto;
        $data['pais'] = ($model->pais_id == null) ? $this->defaulString: Country::findOrFail($model->pais_id)->short_name;
        $data['tasa'] = number_format(floatval($model->tasa),2);
        $data['comentario'] = $model->comentario;
        $data['condicion_pago'] = ($model->condicion_pago_id == null ) ? $this->defaulString: ProviderCondPay::findOrFail($model->condicion_pago_id)->getText();
        $data['mt3'] =  ($model->mt3 == null ) ? $this->defaulInt :  $model->mt3 ;
        $data['peso'] =  ($model->peso == null ) ? $this->defaulInt :  $model->peso ;
        $data['fecha_cancelacion'] =( $model->cancelacion == null) ? $this->defaulString :  $this->outputDate($model->cancelacion);
        $data['comentario_cancelacion'] =( $model->comentario_cancelacion == null) ? $this->defaulString :  $model->comentario_cancelacion;
        $data['fecha_aprobacion_compras'] = ( $model->fecha_aprob_compra == null) ? $this->defaulString :  $this->outputDate($model->fecha_aprob_compra);
        $data['nro_doc'] = $model->nro_doc;
        $data['fecha_aprobacion_gerencia'] = ( $model->fecha_aprob_gerencia == null) ? $this->defaulString :  $this->outputDate($model->fecha_aprob_gerencia);

        $data['aprob_compras']=  ($model->fecha_aprobacion_compras != null )? true : false;
        $data['cancelado']= ($model->cancelacion != null)? true : false;;
        $data['aprob_gerencia']= ($model->fecha_aprobacion_gerencia != null)? true : false;
        $data['dir_almacen'] =  ($model->direccion_almacen_id == null ) ?$this->defaulString:  ProviderAddress::findOrFail($model->direccion_almacen_id)->direccion ;
        $data['dir_facturacion'] =  ($model->direccion_facturacion_id == null ) ?$this->defaulString:  ProviderAddress::findOrFail($model->direccion_facturacion_id)->direccion ;

        $data['articulos'] = sizeof(($items));
        $data['articulos_kitchenBox'] =0;
        $data['articulos_contraPedido'] =0;

        foreach($items as $aux){
            $p= $this->getFirstProducto($aux);
            switch($p->tipo_origen_id){
                case 2:$data['articulos_contraPedido'] ++;break;
                case 3:$data['articulos_kitchenBox'] ++;break;
            }
        }

        return $data;

    }

    private function parseDocToEstimateEmail($model, $texto){
        $data = [];

        $data['id'] = $model->id;
        $data['emision'] = $this->outputDate($model->emision);
        $data['titulo'] = $model->titulo;
        $data['responsable'] = $this->request->session()->get('DATAUSER')['nombre'];
        $data['proveedor'] = Provider::findOrFail($model->prov_id);
        $data['correo'] = $this->request->session()->get('DATAUSER')['email'];

        $data['texto'] = $texto;
        $items = $model->items()->selectRaw("*, sum(saldo) as cant")->groupBy('producto_id')->get();
        $prod = [];
        foreach ($items as $aux) {
            $temp = array();

            $p = Product::find($aux->producto_id);
            $temp['id'] = $aux->id;
            $temp['codigo_fabrica'] = $p->codigo_fabrica;
            $temp['descripcion'] = $aux->descripcion;
            $temp['cantidad'] = $aux->cant;
            $prod[] = $temp;
        }
        $data['articulos'] = $prod;
        return $data;

    }



    private function gettemplate($name, $leng, $default = true){

        if(array_key_exists($name,$this->emailTemplate)){

            $template =$this->emailTemplate[$name];
            if(array_key_exists($leng,$template)){
                return ['template'=>$template[$leng], 'metodo'=>'exact'];
            }else{
                if(strlen($name) > 2){
                    if(array_key_exists(substr($leng,0,2),$template)){
                        return ['template'=>$template[substr($leng,0,2)], 'metodo'=>'aprox'];
                    }
                }
            }

        }
        return ['template'=>$template['default'], 'metodo'=>'default'];
    }



    /*
     * determian los permiso del docuemnto segun las carcateristicas del mismo
     * **/
    private function getPermisionDoc($model){
        $permit=  ['aprob_compras'=>false,'update'=>false,'cancel'=>false, 'delete'=>false,'metodo'=>'default'];

        if($this->user->cargo_id == $this->profile['gerente']){
            return ['aprob_gerencia'=>true,'aprob_compras'=>true,'update'=>true,'cancel'=>true, 'delete'=>true,'metodo'=>'mas alto'];

        }
        else
            if($this->user->id === $model->usuario_id){
                if($model->uid != null){
                    $permit['update']=true;
                    $permit['delete']=true;
                    $permit['delete']="no create";

                }else{
                    if($this->user->cargo_id == $this->profile['trabajador']){
                        $notif = NotificationModule::where('doc_id',$model->id)->where('doc_tipo_id',$model->getTipoId());
                        if(sizeof($notif->where('usuario_id','<>',$model->usuario_id)->get()) == 0){
                            $permit['update']=true;
                            $permit['metodo']='sin cambios';
                        }
                    }else if($this->user->cargo_id == $this->profile['jefe']) {
                        $noti = User::selectRaw('tbl_usuario.id,tbl_usuario.cargo_id, count(tbl_noti_pedido.id) as noti ')
                            ->join('tbl_noti_pedido','tbl_noti_pedido.usuario_id','=','tbl_usuario.id' )
                            ->where('doc_id',$model->id)
                            ->where('doc_tipo_id',$model->getTipoId())
                            ->where('cargo_id',$this->profile['gerente'])
                            ->groupBy('tbl_usuario.cargo_id')
                            ->get();
                        if(sizeof($noti) == 0){
                            $permit['update'] = true;
                        }
                    }


                }
            }else{
                $user = User::find($model->usuario_id);
                /*$noti = User::selectRaw('tbl_usuario.id,tbl_usuario.cargo_id, count(tbl_noti_pedido.id) as noti ')
                    ->join('tbl_noti_pedido','tbl_noti_pedido.usuario_id','=','tbl_usuario.id' )
                    ->where('doc_id',$model->id)
                    ->where('doc_tipo_id',$model->getTipoId())
                    ->where('cargo_id',$this->profile['gerente'])
                    ->groupBy('tbl_usuario.cargo_id')
                    ->get();*/

                if($this->user->cargo_id == $this->profile['jefe'] && $user->cargo_id ==  $this->profile['trabajador']) {
                    if($model->fecha_aprobacion_compras == null && $model->estado_id == 1){$permit['aprob_compras']= true;$permit['update']= true;};
                    if($model->cancelacion == null && $model->estado_id == 1){$permit['cancel']= true;$permit['update']= true;};
                }

            }
        return $permit;
    }

}