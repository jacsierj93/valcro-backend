<?php

namespace App\Http\Controllers\Embarques;


use App\Models\Sistema\Masters\Country;
use App\Models\Sistema\Masters\FileModel;
use App\Models\Sistema\Masters\Ports;
use App\Models\Sistema\Other\SourceType;
use App\Models\Sistema\Product\Product;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Providers\ProviderAddress;
use App\Models\Sistema\Purchase\Purchase;
use App\Models\Sistema\Shipments\Container;
use App\Models\Sistema\Shipments\Shipment;
use App\Models\Sistema\Shipments\ShipmentAttachment;
use App\Models\Sistema\Tariffs\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;


class EmbarquesController extends BaseController
{
    private  $user = null;

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

    public function getOrders(Request $req){
        $data  = [];
        $models = Purchase::get();
        foreach($models as $aux){
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
            $odc['asignado']=false;
            /*            $odc['isTotal']=0;*/
            $odc['items'] = $aux->items()->get();
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

        foreach ($model->items()->get() as $aux){

            $prd  = Product::selectRaw(
                'tbl_compra_orden_item.id, 
                tbl_compra_orden_item.descripcion, 
                tbl_compra_orden_item.tipo_origen_id, 
                tbl_compra_orden_item.origen_item_id, 
                tbl_compra_orden_item.producto_id, 
                tbl_compra_orden_item.saldo as cantidad, 
                tbl_producto.codigo, 
                tbl_producto.codigo_barras, 
                tbl_producto.codigo_profit, 
                tbl_producto.codigo_fabrica
                ')
                ->join('tbl_compra_orden_item','tbl_compra_orden_item.producto_id','=','tbl_producto.id' )
                ->where('tbl_producto.id', $aux->producto_id)->first()
            ;
        $prd->saldo='0';
            $origen =   $this->getFirstProducto($aux);
            $source = SourceType::find($origen->tipo_origen_id);
            $prd->origen = ['text'=>$source->descripcion, 'key'=>$source->id];
            $prods[] =$prd;

        }
        $data['prods'] =$prods ;

/*        $data['prods'][]= ['id'=>'-1', 'cod'=>'-1', 'cod_fabrica'=>'-1','descripcion'=>'demo demo ','origen'=>['text'=>'Producto','key'=>'-1'], 'cantidad'=>'0', 'saldo'=>'0','total'=>'0'];
        $data['prods'][]= ['id'=>'-12', 'cod'=>'-1', 'cod_fabrica'=>'-1','descripcoin'=>'demo demo ','origen'=>['text'=>'Producto','key'=>'-1'], 'cantidad'=>'0','saldo'=>'0','total'=>'0'];*/


        return $data;
    }

    /************************* TARIFF ***********************************/

    public function getPortCountry(Request $req){
        return json_encode(Ports::select("id","Main_port_name","pais_id")->where('pais_id', $req->pais_id)->get());
    }

    public function getTariffs(Request $req){
        $data= [];
        $model =Tariff::where('puerto_id', $req->puerto_id)->get();
        foreach($model as $aux ){
            $aux->objs =['puerto_id'=>Ports::find($aux->puerto_id)];
            $data[]= $aux;
        }
        return $data ;
    }
    public function saveTariff(Request $req){
        $model = new Tariff();
        $model->fregth_forwarder = $req->fregth_forwarder ;
        $model->pais_id = $req->pais_id ;
        $model->puerto_id = $req->puerto_id ;
        $model->moneda_id = $req->moneda_id ;
        $model->vencimiento = $req->vencimiento ;

        if($req->has("dias_tt")){
            $model->dias_tt = $req->dias_tt ;
        }
        if($req->has("naviera")){
            $model->naviera = $req->naviera ;
        }
        if($req->has("grt")){
            $model->grt = $req->grt ;
        }
        if($req->has("documento")){
            $model->documento = $req->documento ;
        }
        if($req->has("mensajeria")){
            $model->mensajeria = $req->tt ;
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
        return['accion'=>'new', 'id'=>$model->id, 'model'=>Tariff::findOrFail($model->id)];
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
        $tarifa = ($model->tarifa_id == null) ? null: Tariff::find($model->tarifa_id);
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

        // odc
        $data['odc'] = [];

        //demo odc
        $data['odcs'][] = $model->orders();

        // foraneos
        $data['objs'] =[
            'pais_id'=>($model->pais_id == null) ? null: Country::find($model->pais_id),
            'puerto_id'=>($model->puerto_id == null) ? null: Ports::find($model->puerto_id),
            'tarifa_id'=>$tarifa,
            'prov_id'=>($model->prov_id == null) ? null: Provider::find($model->prov_id),
        ];


        // calculados
        $fecha_carga = ['value'=>$model->fecha_carga,'method'=>'db'];
        $fecha_vnz = ['value'=>$model->fecha_vnz,'method'=>'db'];;
        $fecha_tienda = ['value'=>$model->fecha_tienda,'method'=>'db'];;
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


        $data['fecha_carga'] = $fecha_carga;
        $data['fecha_vnz'] = $fecha_vnz;
        $data['fecha_tienda'] = $fecha_tienda;


        return $data ;
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