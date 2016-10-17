<?php

namespace App\Http\Controllers\Embarques;


use App\Models\Sistema\Masters\Country;
use App\Models\Sistema\Masters\Ports;
use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Providers\ProviderAddress;
use App\Models\Sistema\Shipments\Shipment;
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

    /************************* TARIFF ***********************************/

    public function getPortCountry(Request $req){
        return json_encode(Ports::select("id","Main_port_name","pais_id")->where('pais_id', $req->pais_id)->get());
    }

    public function getTariffs(Request $req){
        return Tariff::where('puerto_id', $req->puerto_id)->get();
    }
    public function saveTariff(Request $req){
        $model = new Tariff();
        $model->fregth_forwarder = $req->fregth_forwarder ;
        $model->pais_id = $req->pais_id ;
        $model->puerto_id = $req->puerto_id ;
        $model->moneda_id = $req->moneda_id ;
        $model->vencimiento = $req->vencimiento ;

        if($req->has("tt")){
            $model->tt = $req->tt ;
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
        return['accion'=>'new', 'id'=>$model->id];
    }

    /************************* SHIPMENT ***********************************/
    public  function  getShipment(Request $req){
        $model = Shipment::findOrfail($req->id);
        $data = [];
        $data['id'] = $model->id;
        $data['emision'] = $model->emision;
        $data['prov_id'] = $model->prov_id;
        $data['titulo'] = $model->titulo;
        $data['session_id'] = $model->session_id;
        $data['pais_id'] = $model->pais_id;
        $data['puerto_id'] = $model->puerto_id;
        $data['tarifa_id'] = $model->tarifa_id;
        $data['fecha_carga'] = $model->fecha_carga;
        $data['fecha_vnz'] = $model->fecha_vnz;
        $data['fecha_tienda'] = $model->fecha_tienda;
        $data['flete_nac'] = $model->flete_nac;
        $data['flete_dua'] = $model->flete_dua;
        $data['flete_tt'] = $model->flete_tt;
        $data['nro_mbl'] = $model->nro_mbl;
        $data['nro_hbl'] = $model->nro_hbl;
        $data['nro_exp_aduana'] = $model->nro_exp_aduana;
        $data['moneda_id'] = $model->flete_dua;
        $data['flete'] = ($model->flete_dua ==  null ? 0 : floatval($model->flete_nac))+($model->flete_dua ==  null ? 0 : floatval($model->flete_dua ));
        // aprobaciones

        $data['conf_f_carga'] = ($model->usuario_conf_f_carga == null )? false: true;
        $data['conf_f_vnz'] = ($model->usuario_conf_f_vnz == null )? false: true;
        $data['conf_f_tienda'] = ($model->usuario_conf_f_tienda == null )? false: true;
        $data['conf_monto_ft_tt'] = ($model->usuario_conf_monto_ft_tt == null )? false: true;
        $data['conf_monto_ft_nac'] = ($model->usuario_conf_monto_ft_nac == null )? false: true;
        $data['conf_monto_ft_dua'] = ($model->usuario_conf_monto_ft_dua == null )? false: true;




        $data['objs'] =[
            'pais_id'=>($model->pais_id == null) ? null: Country::find($model->pais_id),
            'puerto_id'=>($model->puerto_id == null) ? null: Ports::find($model->puerto_id),
            'tarifa_id'=>($model->tarifa_id == null) ? null: Tariff::find($model->tarifa_id),
            'prov_id'=>($model->prov_id == null) ? null: Provider::find($model->prov_id),
        ];

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
               if($req->has('fecha_carga')){ $model->fecha_carga= $req->fecha_carga;}
               if($req->has('fecha_vnz')){ $model->fecha_vnz= $req->fecha_vnz;}
               if($req->has('fecha_tienda')){ $model->fecha_tienda= $req->fecha_tienda;}
               if($req->has('flete_nac')){ $model->flete_nac= $req->flete_nac;}
               if($req->has('flete_dua')){ $model->flete_dua= $req->flete_dua;}
               $model->save();


               $return['id']= $model->id;
               $return['session_id']=  $model->session_id;
        return $return ;
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