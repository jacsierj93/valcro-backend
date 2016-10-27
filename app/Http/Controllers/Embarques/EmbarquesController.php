<?php

namespace App\Http\Controllers\Embarques;


use App\Models\Sistema\Masters\Country;
use App\Models\Sistema\Masters\FileModel;
use App\Models\Sistema\Masters\Line;
use App\Models\Sistema\Masters\Ports;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\Product\Product;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Providers\ProviderAddress;
use App\Models\Sistema\Purchase\Purchase;
use App\Models\Sistema\Purchase\PurchaseItem;
use App\Models\Sistema\Shipments\Container;
use App\Models\Sistema\Shipments\Shipment;
use App\Models\Sistema\Shipments\ShipmentAttachment;
use App\Models\Sistema\Shipments\ShipmentItem;
use App\Models\Sistema\Tariffs\FreigthForwarder;
use App\Models\Sistema\Tariffs\Naviera;
use App\Models\Sistema\Tariffs\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;


class EmbarquesController extends BaseController
{
    private  $user = null;
    private $minAproxDay = 100;


    public function __construct(Request $req)
    {
        $this->user['id']= $req->session()->get('DATAUSER')['id'];
        $this->middleware('auth');
    }

    /************************* SYSTEM ***********************************/
    public function getNotifications(){
        $result = [];

        $aux= Shipment::selectraw('id')->whereNotNull('session_id');// sesiones vivas
        $aux= $aux->get();
        if(sizeof($aux) > 0){
            $result[] = array('titulo'=>"Embarques pendientes", 'key'=>'uncloset','cantidad'=>sizeof($aux), 'data'=> $aux);
        }

        return $result;
    }

    /**Docuemntos con sesion abierta*/
    public function getUncloset(){
        return json_encode(Shipment::whereNotNull('session_id')->get());
    }

    /************************* PROVIDER ***********************************/
    public  function  getProvList(){
        $prov  = Provider::where('id','<' ,100)->get();
        return $prov;
    }
    public  function  getProvDir(Request $req){
        $data =[];
        $paises = ProviderAddress::selectraw('pais_id')
            ->where('prov_id', $req->id)
            ->where(function ($query){$query->where('tipo_dir',2)->orWhere('tipo_dir',3);})
            ->distinct('pais_id')->get();

        foreach($paises as $pais){
            $contry = Country::find($pais->pais_id);
            $contry['ports'] = $contry->ports()->get();
            $data []= $contry;
        }
        return $data;
    }

    /************************* Order ***********************************/

    public function getOrdersForAsignment(Request $req){
        $data  = [];
        $models = Purchase::selectRaw(
            'tbl_compra_orden.id,
             tbl_compra_orden.fecha_produccion, 
             tbl_compra_orden.prov_id, 
             tbl_compra_orden.fecha_aprob_gerencia, 
             tbl_compra_orden.fecha_aprob_compra, 
             tbl_compra_orden.nro_proforma, 
             tbl_compra_orden.monto, 
             tbl_compra_orden.mt3 
             ')
            ->whereRaw(' (select sum(saldo) from tbl_compra_orden_item where doc_id = tbl_compra_orden.id ) > 0')
            ->get();
        foreach($models as $aux){
            $aux->items = $aux->items()->get();

            if(sizeof(ShipmentItem::where('doc_origen_id', $aux->id)->where('tipo_origen_id', 23)->where('embarque_id', $req->embarque_id)->get()) > 0){
                $aux->asignado=true;
            }
            $data[]= $aux;
        }

        return $data;
    }

    public function getOrdersAsignment(Request $req){
        $models = ShipmentItem::where('embarque_id',$req->embarque_id)->where('tipo_origen_id', '23')->get();
        $odc = new Purchase();

        foreach ($models as $aux){
            $odc->Orwhere('id', $aux->doc_origen_id);
        }
        foreach($odc->get() as $aux){
            $odc = [];
            $odc['id']=$aux->id;
            $odc['fecha_producion']=$aux->fecha_producion;
            $odc['fecha_aprob_gerencia']=$aux->fecha_aprob_gerencia;
            $odc['fecha_aprob_compra']=$aux->fecha_aprob_compra;
            $odc['nro_proforma']=$aux->nro_proforma;
            $odc['nro_proforma']=$aux->nro_proforma;
            $odc['monto']=$aux->monto;
            $odc['mt3']=$aux->mt3;
            $odc['peso']=$aux->peso;
            $odc['asignado']=true;
            $odc['isTotal']=1;
            $items = $aux->items()->get();
            foreach ($items as $item){
                $shipItem = $models->where('origen_item_id',$item->id);
                if(sizeof( $shipItem) == 0){
                    $odc['isTotal'] = 0;
                    break;
                }else{
                    if(floatval($shipItem[0]->saldo) < floatval($item->saldo)){
                        $odc['isTotal'] = 0;
                        break;
                    }
                }
            }
            $data[]= $odc;
        }
        return $data;


    }

    public function getOrder(Request $req){
        $model= Purchase::findOrFail($req->id);
        $prods =[];
        $data['id']= $model->id;
        $data['titulo']= $model->titulo;
        $data['fecha_produccion']= $model->fecha_produccion;
        $data['fecha_aprob_gerencia']= $model->fecha_aprob_gerencia;
        $data['nro_proforma']=['documento'=>$model->nro_proforma, 'adjs'=>[]];
        $data['monto']= $model->monto;
        $data['peso']= $model->peso;
        $data['mt3']= $model->mt3;
        $data['prods'] =[];
        $items = $model->items()->get() ;
        foreach ($items as $aux){

            $prd  = Product::selectRaw(
                'tbl_compra_orden_item.id, 
                tbl_compra_orden_item.descripcion, 
                tbl_compra_orden_item.doc_id, 
                tbl_compra_orden_item.tipo_origen_id, 
                tbl_compra_orden_item.origen_item_id, 
                tbl_compra_orden_item.producto_id, 
                tbl_compra_orden_item.saldo as cantidad, 
                tbl_compra_orden_item.saldo as disponible, 
                tbl_producto.codigo, 
                tbl_producto.codigo_barra, 
                tbl_producto.codigo_profit, 
                tbl_producto.codigo_fabrica
                ')
                ->join('tbl_compra_orden_item','tbl_compra_orden_item.producto_id','=','tbl_producto.id' )
                ->where('tbl_producto.id', $aux->producto_id)->first();
            $item =  ShipmentItem::where('doc_origen_id', $model->id)
                ->where('tipo_origen_id', '23')
                ->where('origen_item_id',$aux->id)
                ->where('embarque_id', $req->embarque_id)
                ->first();
            $prd->asignado= false;



            if($item != null){
                $data['asinado']= true;
                $prd->asignado = true;
                $prd->embarque_item_id = $item->id;
                $prd->disponible = floatval(floatval($prd->cantidad) + floatval($item->cantidad) );

                $prd->saldo = $item->cantidad;

            }else{
                $prd->saldo = 0;
            }

            $origen =   $this->getFirstProducto($aux);
            $source = SourceType::find($origen->tipo_origen_id);
            $prd->origen = ['text'=>$source->descripcion, 'key'=>$source->id];
            $prods[] =$prd;

        }

        if($req->has('embarque_id')){
            $data['isTotal'] = 1;
            $models = ShipmentItem::where('embarque_id',$req->embarque_id)->where('tipo_origen_id', '23')->get();
            foreach ($items as $item){
                $shipItem = $models->where('origen_item_id',$item->id);
                if(sizeof( $shipItem) == 0){
                    $data['isTotal'] = 0;
                    break;
                }else{

                    if(floatval($shipItem->first()->saldo) < floatval($item->saldo)){
                        $data['isTotal'] = 0;
                        break;
                    }
                }
            }
        }



        $data['prods'] =$prods ;
        return $data;
    }

    /************************* TARIFF ***********************************/

    public function getPortCountry(Request $req){
        return json_encode(Ports::select("id","Main_port_name","pais_id")->where('pais_id', $req->pais_id)->get());
    }



    public function getFreightForwarder(Request $req){
        $models = FreigthForwarder::selectRaw('distinct tbl_freight_forwarder.id,tbl_freight_forwarder.nombre')
            ->leftJoin('tbl_tarifa','tbl_tarifa.freight_forwarder_id','=','tbl_freight_forwarder.id' )
            ->whereNotNull('tbl_tarifa.usuario_conf_id')
            ->get();
        return $models;
    }

    public function getNaviera(Request $req){
        return ($req->has('ff_id') ? Naviera::where('freight_forwarder_id', $req->ff_id)->get(): Naviera::get());
    }


    public function getTariffs(Request $req){
        $data= [];
        $model =Tariff::where('puerto_id', $req->puerto_id)->get();
        foreach($model as $aux ){
            $aux->objs = $aux->objs();
            $data[]= $aux;
        }
        return $data ;
    }

    public function saveTariff(Request $req){
        $model = new Tariff();
        $ff = new FreigthForwarder();
        $nav = new Naviera();
        $rs = ['accion'=>'new'];
        if($req->has("freight_forwarder_id")){
            $ff = FreigthForwarder::findOrFail($req->freight_forwarder_id);
        }else{
            $ff->nombre = $req->ff;
            $ff->usuario_created_id = $req->session()->get('DATAUSER')['id'];
            $ff->save();
            $rs['createdff']= true;

        }if($req->has("naviera_id")){
            $nav = Naviera::findOrFail($req->naviera_id);
        }else{
            $nav->nombre = $req->nav;
            $nav->usuario_created_id = $req->session()->get('DATAUSER')['id'];
            $nav->save();
            $rs['created nav']= true;

        }

        $model->pais_id = $req->pais_id ;
        $model->puerto_id = $req->puerto_id ;
        $model->moneda_id = $req->moneda_id ;
        $model->vencimiento = $req->vencimiento ;
        $model->naviera_id= $nav->id;
        $model->freight_forwarder_id= $ff->id;


        if($req->has("dias_tt")){
            $model->dias_tt = $req->dias_tt ;
        }

        if($req->has("grt")){
            $model->grt = $req->grt ;
        }
        if($req->has("documento")){
            $model->documento = $req->documento ;
        }
        if($req->has("mensajeria")){
            $model->mensajeria = $req->mensajeria ;
        }
        if($req->has("seguros")){
            $model->seguros = $req->seguros ;
        }
        if($req->has("consolidadion")){
            $model->consolidadion = $req->consolidadion ;
        }
        if($req->has("sd20")){
            $model->sd20 = $req->sd20 ;
        }
        if($req->has("sd40")){
            $model->sd40 = $req->sd40 ;
        }
        if($req->has("hc40")){
            $model->hc40 = $req->hc40 ;
        }
        if($req->has("ot40")){
            $model->ot40 = $req->ot40 ;
        }
        $model->save();
        $fModel = Tariff::findOrFail($model->id);
        $fModel->objs =  $fModel->objs();

        $rs['model'] = $fModel;

        return $rs;

    }

    /************************* CONTAINERS ***********************************/
    public function saveContainer(Request $req){
        $model = new Container();
        $result = ['action' =>'new'];
        if($req->has("id")){
            $result['action'] = 'upd';
            $model = Container::findOrfail($req->id);
        }
        $model->cantidad = $req->cantidad;
        $model->peso = $req->cantidad;
        $model->tipo = $req->tipo;
        $model->volumen = $req->volumen;
        $model->peso = $req->cantidad;
        $model->embarque_id= $req->embarque_id;
        $model->save();

        $result['id'] = $model->id;
        $result['model'] = Container::findOrfail($model->id);
        return $result;
    }

    public function DeleteContainer(Request $req){
        $model = Container::findOrFail($req->id);
        return ['accion'=>'del','response'=> $model->destroy($model->id) ];
    }


    /************************* SHIPMENT ***********************************/
    public  function  getShipment(Request $req){

        $model = Shipment::findOrfail($req->id);
        $tarifa = null;
        if($model->tarifa_id != null){
            $tarifa = Tariff::find($model->tarifa_id);
            $tarifa->objs = $tarifa->objs();

        }

        $data = [];

        $data['id'] = $model->id;
        $data['emision'] = $model->emision;
        $data['prov_id'] = $model->prov_id;
        $data['titulo'] = $model->titulo;
        $data['session_id'] = $model->session_id;
        $data['pais_id'] = $model->pais_id;
        $data['puerto_id'] = $model->puerto_id;
        $data['tarifa_id'] = $model->tarifa_id;
        $data['flete_nac'] = $model->flete_nac;
        $data['flete_dua'] = $model->flete_dua;
        $data['flete_tt'] = $model->flete_tt;

        $data['moneda_id'] = $model->flete_dua;
        $data['flete'] = ($model->flete_dua ==  null ? 0 : floatval($model->flete_nac))+($model->flete_dua ==  null ? 0 : floatval($model->flete_dua ));
        $data['containers'] = $model->containers()->get();

        // aprobaciones
        $data['conf_f_carga'] = ($model->usuario_conf_f_carga == null )? false: true;
        $data['conf_f_vnz'] = ($model->usuario_conf_f_vnz == null )? false: true;
        $data['conf_f_tienda'] = ($model->usuario_conf_f_tienda == null )? false: true;
        $data['conf_monto_ft_tt'] = ($model->usuario_conf_monto_ft_tt == null )? false: true;
        $data['conf_monto_ft_nac'] = ($model->usuario_conf_monto_ft_nac == null )? false: true;
        $data['conf_monto_ft_dua'] = ($model->usuario_conf_monto_ft_dua == null )? false: true;

        // adjuntos
        $data['nro_mbl'] = ['documento'=>$model->nro_mbl,'emision'=> $model->emsion_mbl,'adjs'=> $model->attachmentsFile("nro_mbl") ];
        $data['nro_hbl'] = ['documento'=>$model->nro_hbl,'emision'=> $model->emsion_hbl, 'adjs'=> $model->attachmentsFile("nro_hbl") ];
        $data['nro_dua'] = ['documento'=>$model->nro_dua, 'emision'=> $model->emision,'adjs'=> $model->attachmentsFile("nro_dua") ];

        // items
        $Mitems  =ShipmentItem::selectRaw(
            'tbl_embarque_item.id,'.
            'tbl_embarque_item.embarque_id,'.
            'tbl_embarque_item.descripcion,'.
            'tbl_embarque_item.saldo,'.
            'tbl_embarque_item.cantidad,'.
            'tbl_embarque_item.origen_item_id,'.
            'tbl_embarque_item.producto_id,'.
            'tbl_embarque_item.tipo_origen_id,'.
            'tbl_embarque_item.doc_origen_id,'.
            'tbl_embarque_item.id as embarque_item_id,'.
            ' tbl_producto.codigo,'.
            ' tbl_producto.codigo_fabrica,'.
            ' tbl_producto.precio,'.
            '(tbl_producto.precio  * tbl_embarque_item.cantidad) as total '
        )
            ->join('tbl_producto','tbl_producto.id','=','tbl_embarque_item.producto_id' )
            ->get();
        $data['items'] = [];
        foreach ($Mitems as $aux){
            if($aux->tipo_origen_id == '23'){
                $p = PurchaseItem::find($aux->origen_item_id);
                $aux->disponible= floatval(floatval($p->saldo) + $aux->cantidad);
            }
            $data['items'][] = $aux;
        }


        // odc
        $data['odcs']= $this->getOrdersAsignmentModel($model->id);

        // foraneos
        $data['objs'] =[
            'pais_id'=>($model->pais_id == null) ? null: Country::find($model->pais_id),
            'puerto_id'=>($model->puerto_id == null) ? null: Ports::find($model->puerto_id),
            'tarifa_id'=>($tarifa == null ) ? [] :
                [
                    'model'=> $tarifa,
                    'freight_forwarder'=> $tarifa->objs['freight_forwarder_id'],
                    'naviera'=> $tarifa->objs['naviera_id']
                ] ,
            'prov_id'=>($model->prov_id == null) ? null: Provider::find($model->prov_id),
        ];


        // calculados
        $fecha_carga = ['value'=>$model->fecha_carga,'method'=>'db'];
        $fecha_vnz = ['value'=>$model->fecha_vnz,'method'=>'db'];
        $fecha_tienda = ['value'=>$model->fecha_tienda,'method'=>'db'];
        /*if($model->emision != null){
            $auxFecha= date_create($model->emision);

            $emision= Carbon::createFromDate($auxFecha->format("Y"),$auxFecha->format("m"),$auxFecha->format("d"));
            if($tarifa != null){
                if($tarifa->dias_tt != null){
                    if( $model->fecha_vnz == null){
                        $fecha_carga = ['value'=>$emision->copy()->addDay(intval($tarifa->dias_tt)),'method'=>'estimate'];
                    }


                }
            }
        }*/


        //$data['fechas']= $model->getDates();



        return $data ;
    }

    public  function  getShipmentDates(Request $req){
        $model = Shipment::findOrFail($req->id);
        $fecha_carga = ['value'=>$model->fecha_carga,'method'=>'db', 'confirm'=>($model->usuario_conf_f_carga != null)];
        $fecha_vnz = ['value'=>$model->fecha_vnz,'method'=>'db', 'confirm'=>($model->usuario_conf_f_vnz != null)];
        $fecha_tienda = ['value'=>$model->fecha_tienda,'method'=>'db', 'confirm'=>($model->usuario_conf_f_tienda != null)];

        if($model->emision != null){
            $rs = Shipment::selectRaw('')->get();
        }
        $return =[$fecha_carga,$fecha_vnz,$fecha_tienda];
        dd($return);

    }


    public function saveShipment(Request $req){
        $return = ['accion'=>'new'];
        $model = new Shipment();
        $validator = Validator::make($req->all(), [
            'prov_id' => 'required',
            'titulo' => 'required',
            'tarifa_id' => 'required'
        ]);
        if(!$req->has('session_id')){
            $model->session_id = uniqid('', true);// removeer en function closeShipment
        }

        if($req->has('id')){
            $return['accion']='edit';
            $model = $model->findOrFail($req->id);
        }
        if(!$validator->fails()  ){
            if(!$req->has('emision')){
                $model->emision = Carbon::now();
            }
            $return['valid'] = true;
            $return['emision'] =  $model->emision;
        }

        if($model->usuario_id == null){$model->usuario_id = $req->session()->get('DATAUSER')['id'];}
        if($req->has('prov_id')){$model->prov_id= $req->prov_id;}
        if($req->has('titulo')){ $model->titulo= $req->titulo;}
        if($req->has('pais_id')){ $model->pais_id= $req->pais_id;}
        if($req->has('puerto_id')){ $model->puerto_id= $req->puerto_id;}
        if($req->has('tarifa_id')){ $model->tarifa_id= $req->tarifa_id;}

        if($req->has('flete_nac')){ $model->flete_nac= $req->flete_nac;}
        if($req->has('flete_dua')){ $model->flete_dua= $req->flete_dua;}

        if($req->has('nro_mbl')){
            if(array_key_exists('documento',$req->nro_mbl)){
                $model->nro_mbl=$req->nro_mbl['documento'];
            }
            if(array_key_exists('emision',$req->nro_mbl)){
                $model->emision_mbl=$req->nro_mbl['emision'];
            }
        }
        if($req->has('nro_hbl')){
            if(array_key_exists('documento',$req->nro_hbl)){
                $model->nro_hbl=$req->nro_hbl['documento'];
            }
            if(array_key_exists('emision',$req->nro_hbl)){
                $model->emision_hbl=$req->nro_hbl['emision'];
            }
        }
        if($req->has('nro_dua')){

            if(array_key_exists('documento',$req->nro_dua)){
                $model->nro_dua=$req->nro_hbl['documento'];
            }
            if(array_key_exists('emision',$req->nro_dua)){
                $model->emision_dua=$req->nro_dua['emision'];
            }
        }

        /*        if($req->has('fecha_carga')){

                    $model->fecha_carga= $req->fecha_carga['value'];
                }
                if($req->has('fecha_vnz')){ $model->fecha_vnz= $req->fecha_vnz['value'];}
                if($req->has('fecha_tienda')){ $model->fecha_tienda= $req->fecha_tienda['value'];}*/
        $model->save();


        $return['id']= $model->id;
        $return['session_id']=  $model->session_id;
        return $return ;
    }

    public function SaveAttachment(Request $req){
        $file = FileModel::findOrFail($req->archivo_id);
        $model = new ShipmentAttachment();
        $model->embarque_id= $req->embarque_id;
        $model->documento = $req->documento;
        $model->archivo_id	 = $req->archivo_id;
        $model->comentario	 = ($req->has('comentario') ? $req->comentario : null );
        $model->save();
        $att['id'] = $model->id;
        $att['archivo_id'] = $model->archivo_id;
        $att['documento'] = $model->documento;
        $att['comentario'] = $model->comentario;
        $att['thumb']=$file->getThumbName();
        $att['tipo']=$file->tipo;
        $att['file'] = $file->archivo;
        return $att;
    }

    public function SaveOrderItem(Request $req){
        $model = new ShipmentItem();
        $disponible   = null;
        $result['accion'] = 'new';
        // antes de la edicion
        if($req->has('id')){
            $model = ShipmentItem::findOrFail($req->id);
            $result['accion'] = 'upd';

            if($req->tipo_origen_id == '23'){
                $odItem = PurchaseItem::findOrFail($req->origen_item_id);
                $odItem->saldo  = floatval($odItem->saldo) + floatval($model->cantidad);
                $odItem->save();
                $result['restoire']= $odItem->saldo ;
            }
        }

        $model->tipo_origen_id= $req->tipo_origen_id;
        $model->embarque_id= $req->embarque_id;
        $model->descripcion= $req->descripcion;
        $model->doc_origen_id= ($req->has('doc_origen_id')) ? $req->doc_origen_id : null;
        $model->origen_item_id= $req->origen_item_id;
        $model->producto_id= $req->producto_id;

        if(!$req->has("cantidad")){
            $model->cantidad= $req->saldo;
            $model->saldo= $req->saldo;
        }else{
            $model->cantidad= $req->cantidad;
            $model->saldo= $req->saldo;
        }

        $model->save();

        // despues de la edicion
        if($req->tipo_origen_id == '23' ){
            $odItem = PurchaseItem::findOrFail($req->origen_item_id);
            $odItem->saldo  = floatval( floatval($odItem->saldo) - floatval($req->saldo) );
            $disponible = floatval( floatval($odItem->saldo) + floatval($req->saldo));
            $odItem->save();
            $result['rst']= $odItem->saldo;

// confirmacion de estado del pedido original
            $itemIns = ShipmentItem::where('doc_origen_id', $req->doc_origen_id)
                ->where('embarque_id',$req->embarque_id)
                ->get() ;
            if($req->tipo_origen_id == '23' && !$req->has('id') && sizeof($itemIns) == 1)
            {
                $pr =  Purchase::find($req->doc_origen_id);
                $items = $pr->items()->get();
                $models = ShipmentItem::where('embarque_id',$req->embarque_id)->where('tipo_origen_id', '23')->get();
                foreach ($items as $item){
                    $shipItem = $models->where('origen_item_id',$item->id);

                    if(sizeof( $shipItem) == 0){
                        $pr['isTotal'] = 0;
                        break;
                    }else{
                        if(floatval($shipItem->first()->saldo) < floatval($item->saldo)){
                            $pr['isTotal'] = 0;
                            break;
                        }
                    }
                }

                $result['doc_origen_id'] =$pr;

            }
            $result['cantidad']= $odItem->saldo;
            $result['sizeOf']=$itemIns;
        }

        $result['id']= $model->id;
        $result['saldo']=$model->saldo;
        $model = ShipmentItem::selectRaw(
            'tbl_embarque_item.id,'.
            'tbl_embarque_item.embarque_id,'.
            'tbl_embarque_item.descripcion,'.
            'tbl_embarque_item.saldo,'.
            'tbl_embarque_item.producto_id,'.
            'tbl_embarque_item.origen_item_id,'.
            'tbl_embarque_item.doc_origen_id,'.
            'tbl_embarque_item.tipo_origen_id,'.
            'tbl_embarque_item.cantidad,'.
            'tbl_embarque_item.id as embarque_item_id,'.
            ' tbl_producto.codigo,'.
            ' tbl_producto.codigo_fabrica,'.
            ' tbl_producto.precio,'.
            '(tbl_producto.precio  * tbl_embarque_item.cantidad) as total '
        )
            ->join('tbl_producto','tbl_producto.id','=','tbl_embarque_item.producto_id' )
            ->where('tbl_embarque_item.id', $model->id)
            ->get()->first();


        // finales

        if($disponible != null){
            $model->disponible= $disponible;
        }
        $result['model']= $model;


        return $result;

    }

    public function DeleteOrderItem(Request $req){
        $result =['accion'=>'del'];
        $result['id']= $req->id;
        $model = ShipmentItem::findOrFail($req->id);

        if($model->tipo_origen_id=='23'){
            $pr = PurchaseItem::findOrFail($model->origen_item_id);
            $pr->saldo = floatval($model->cantidad) + floatval( $pr->saldo);
            $pr->save();
            $result['cantidad']=$pr->saldo;
        }
        $result['response'] = ShipmentItem::destroy($model->id);

        $resta = ShipmentItem::where('tipo_origen_id','23')
            ->where('doc_origen_id',$model->doc_origen_id)
            ->where('embarque_id',$model->embarque_id)
            ->get();
        $result['resta']= $resta;

        if($model->tipo_origen_id =='23'){
            if(sizeof( $resta)== 0 ){
                $result['rm_odc']=$model->doc_origen_id;
            }
        }



        return $result;
    }

    public function SaveOrder (Request $req){
        $odcItem = PurchaseItem::where('doc_id', $req->doc_origen_id)->get();
        $shipITem = ShipmentItem::where('tipo_origen_id', '23')->where('embarque_id', $req->embarque_id)->get();
        $isNew = true;
        $new  = [];
        $old  = [];
        $return =['accion'=>'new'];
        foreach ($odcItem as $aux){
            if(floatval($aux) > 0){
                if(sizeof($shipITem->where('origen_item_id',  $aux->id)) == 0){
                    $it = new ShipmentItem();
                    $it->tipo_origen_id = '23' ;
                    $it->embarque_id= $req->embarque_id;
                    $it->descripcion= $aux->descripcion;
                    $it->doc_origen_id= $req->doc_origen_id;
                    $it->origen_item_id= $aux->id;
                    $it->cantidad = $aux->saldo;
                    $it->saldo = $aux->saldo;
                    $aux->saldo= 0;
                    $aux->save();
                    $it->save();
                    $new[]=['pItem'=>$aux, 'shipItem'=>$it];
                }else{
                    $return['accion'] = 'upd';
                    $isNew = false;
                    $it= $shipITem->where('origen_item_id',  $aux->id)->first();
                    $dif = floatval($aux->saldo) - floatval($it->cantidad);
                    $it->cantidad = floatval($it->cantidad) +$dif;
                    $it->saldo = floatval($it->cantidad) +$dif;
                    $aux->saldo= 0;
                    $aux->save();
                    $it->save();
                    $old[]=['pItem'=>$aux, 'shipItem'=>$it, 'dif'=>$dif];
                }
            }
        }
        if($isNew){
            $return['doc_origen_id']= Purchase::findOrFail($req->doc_origen_id);
        }
        $return['old']=$old;
        $return['new']=$new;
        return $return;
    }

    public function DeleteOrder (Request $req){
        $result =['accion'=>'del'];
        $shipItems = ShipmentItem::where('tipo_origen_id', '23')->where('doc_origen_id', $req->doc_origen_id)->get();
        $odcItems = PurchaseItem::where('doc_id')->get();
        $result['restore'] =[];
        foreach($shipItems as $aux){
            $it = $odcItems->where('id', $aux->origen_item_id)->first();
            $it->saldo = floatval($it->saldo) + floatval($aux->cantidad);
            $it->save();
            $result['restore'][]=  $it;
            $aux->destroy($aux->id);
        }
        return $result;

    }


    /************************* products  ***********************************/

    public function getLineas(){
        return Line::get();
    }

    public function createOnSaveProduct(Request $req){
        $Productmodel = new Product();
        $shipItemModel = new ShipmentItem();
        $result = ['accion'=>'new'];
        $Productmodel->prov_id = $req->prov_id;
        $Productmodel->linea_id = $req->linea_id;
        $Productmodel->almacen_id = $req->almacen_id;
        $Productmodel->codigo_profit = $req->codigo_profit;
        $Productmodel->codigo_fabrica = $req->codigo_profit;
        $Productmodel->descripcion = $req->descripcion;
        $Productmodel->serie = $req->serie;
        $Productmodel->tipo_producto_id = 2;

        if($req->has('codigo')){
            $Productmodel->codigo = $req->codigo;

        }
        if($req->has('codigo_barra')){
            $Productmodel->codigo_barra = $req->codigo_barra;

        }
        if($req->has('precio')){
            $Productmodel->precio = $req->precio;

        }
        $result['responseProd']= $Productmodel->save();
        $result['producto_id']= $Productmodel->id;
        $Productmodel= Product::find($Productmodel->id);;
        $result['producto_model']=$Productmodel;

        $shipItemModel->cantidad = $req->cantidad;
        $shipItemModel->saldo = $req->cantidad;
        $shipItemModel->producto_id =$Productmodel->id;
        $shipItemModel->origen_item_id =$Productmodel->id;
        $shipItemModel->descripcion =$Productmodel->descripcion;
        $shipItemModel->tipo_origen_id =1;

        $result['responseItem']= $shipItemModel->save();
        $result['id']= $shipItemModel->id;
        $result['model']=ShipmentItem::selectRaw(
            'tbl_embarque_item.id,'.
            'tbl_embarque_item.descripcion,'.
            'tbl_embarque_item.cantidad,'.
            'tbl_embarque_item.producto_id,'.
            'tbl_embarque_item.tipo_origen_id,'.
            'tbl_embarque_item.origen_item_id,'.
            'tbl_producto.codigo,'.
            'tbl_producto.codigo_fabrica,'.
            'tbl_producto.precio'
        )
            ->where('tbl_embarque_item.id',$shipItemModel->id)
            ->join('tbl_producto','tbl_producto.id','=','tbl_embarque_item.producto_id' )
            ->first();

        return $result;




    }

    public function getFinishedProduc(Request $req){
        $data=[];
        $Shipmodels = ShipmentItem::where('embarque_id',$req->embarque_id)->where('tipo_origen_id', '23')->get();

        $models = PurchaseItem::selectRaw('
         distinct tbl_compra_orden_item.id, '.
            'tbl_compra_orden_item.saldo as cantidad,'.
            'tbl_compra_orden_item.descripcion,'.
            'tbl_compra_orden_item.doc_id,'.
            'tbl_compra_orden_item.producto_id,'.
            '(tbl_producto.precio  * tbl_compra_orden_item.saldo) as total ,'.
            'tbl_compra_orden.fecha_produccion,'.
            'tbl_producto.codigo,'.
            'tbl_producto.codigo_fabrica,'.
            ' tbl_lineas.linea,'.
            ' tbl_prov_tiempo_fab.min_dias,'.
            ' tbl_prov_tiempo_fab.max_dias,'.
            ' DATEDIFF(ADDDATE(tbl_compra_orden.fecha_produccion, interval tbl_prov_tiempo_fab.min_dias DAY ), CURDATE()) as minDays,'.
            ' ADDDATE(tbl_compra_orden.fecha_produccion, interval tbl_prov_tiempo_fab.min_dias DAY ) as minProducion,'.
            ' ADDDATE(tbl_compra_orden.fecha_produccion, interval tbl_prov_tiempo_fab.max_dias DAY ) as maxProducion,'.
            'tbl_producto.precio'
        )
            ->rightJoin('tbl_producto','tbl_producto.id','=','tbl_compra_orden_item.producto_id' )
            ->join('tbl_compra_orden','tbl_compra_orden.id','=','tbl_compra_orden_item.doc_id' )
            ->leftJoin('tbl_lineas','tbl_lineas.id','=','tbl_producto.linea_id' )
            ->join('tbl_prov_tiempo_fab','tbl_producto.linea_id','=','tbl_prov_tiempo_fab.linea_id' )
            ->where('saldo','>', 0)
            ->whereRaw('DATEDIFF(ADDDATE(tbl_compra_orden.fecha_produccion, interval tbl_prov_tiempo_fab.min_dias DAY ), CURDATE()) < '.$this->minAproxDay)
            ->get();

        foreach ($models as $aux){
            $item = $Shipmodels->where('origen_item_id', $aux->id);
            if(sizeof($item) == 0){
                $aux->asignado = false;
                $aux->disponible = $aux->cantidad;
                $aux->saldo = 0;
                $data[]= $aux;
            }

        }

        return $data;
    }

    /************************* Private opt master ***********************************/
    private function getFirstProducto($model){
        $aux = $model->replicate();

        $i =0;
        $traza= array();
        //dd($type);
        while(true || $i <5){
            if($aux->tipo_origen_id == 2 || $aux->tipo_origen_id == 3 || $aux->tipo_origen_id == 1){
                break;
            }
            if($aux->tipo_origen_id  = 21){
                $aux = Solicitude::findOrFail($aux->origen_item_id);
            }else  if($aux->tipo_origen_id  = 22){
                $aux = OrderItem::findOrFail($aux->origen_item_id);
            }else{
                $aux = Purchase::findOrFail($aux->origen_item_id);
            }

            $i = $i +1;
            $traza[]= $aux;
        }

        return $aux;
    }

    public function getOrdersAsignmentModel($model){
        $models = Purchase::selectRaw(
            'tbl_compra_orden.id ,
            tbl_compra_orden.fecha_produccion ,
            tbl_compra_orden.fecha_aprob_gerencia ,tbl_compra_orden.fecha_aprob_compra ,
            tbl_compra_orden.nro_proforma ,
            tbl_compra_orden.monto,
            tbl_compra_orden.mt3 ,
            tbl_compra_orden.peso '
        )->where('embarque_id',$model)
            ->join('tbl_embarque_item','tbl_embarque_item.doc_origen_id','=','tbl_compra_orden.id' )
            ->where('tipo_origen_id', '23')
            ->whereNull('tbl_embarque_item.deleted_at')
            ->groupBy('tbl_embarque_item.doc_origen_id')
            ->get();
        $data = [];
        foreach($models as $aux){
            $odc = [];
            $odc['id']=$aux->id;
            $odc['fecha_producion']=$aux->fecha_producion;
            $odc['fecha_aprob_gerencia']=$aux->fecha_aprob_gerencia;
            $odc['fecha_aprob_compra']=$aux->fecha_aprob_compra;
            $odc['nro_proforma']=$aux->nro_proforma;
            $odc['monto']=$aux->monto;
            $odc['mt3']=$aux->mt3;
            $odc['peso']=$aux->peso;
            $odc['asignado']=true;
            $odc['isTotal']=1;
            $items = $aux->items()->get();
            foreach ($items as $item){
                $shipItem = $models->where('origen_item_id',$item->id);
                if(sizeof( $shipItem) == 0){
                    $odc['isTotal'] = 0;
                    break;
                }else{
                    if(floatval($shipItem->first()->saldo) < floatval($item->saldo)){
                        $odc['isTotal'] = 0;
                        break;
                    }
                }
            }
            $data[]= $odc;
        }
        return $data;


    }

    /************************* Another module ***********************************/

    public  function getFregthForwarder(){
        return [];
    }

    /**@deprecated */
    public function getEmbarquesList(){
        /*$embarques = Embarques2::all();

         foreach($embarques AS $embarque){
             $embarque['nombres'] = $embarque->nombres()->get();
             $embarque['direcciones'] = $embarque-> direcciones()->get();
         }



         return $embarques;*/
    }




}