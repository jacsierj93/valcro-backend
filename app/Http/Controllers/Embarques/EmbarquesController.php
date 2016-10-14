<?php

namespace App\Http\Controllers\Embarques;


use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Shipments\Shipment;
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

        $aux= Shipment::selectRaw("count(id)")->whereNotNull('session_id');// sesiones vivas
        $aux= $aux->get();
        if($aux[0][0] > 0){
            $result[] = array('titulo'=>"Embarques pendientes", 'key'=>'uncloset','cantidad'=>$aux[0][0]);
        }

        return $result;
    }
    /************************* PROVIDER ***********************************/

    public  function  getProvList(){
        $prov  = Provider::where('id','<' ,100)->get();
        return $prov;
    }

    /************************* SHIPMENT ***********************************/
    public  function  getShipment(Request $req){
        $model = Shipment::findOrfail($req->id);
        $data = [];
        $data['id'] = $model->id;
        $data['session_id'] = $model->session_id;
        $data['pais_id'] = $model->pais_id;
        $data['puerto_id'] = $model->puerto_id;
        $data['tarifa_id'] = $model->tarifa_id;
        $data['fecha_carga'] = $model->fecha_carga;
        $data['fecha_vnz'] = $model->fecha_vnz;
        $data['fecha_tienda'] = $model->fecha_tienda;
        $data['flete_nac'] = $model->flete_nac;
        $data['flete_dua'] = $model->flete_dua;
        $data['flete'] = ($model->flete_dua ==  null ? 0 : floatval($model->flete_nac))+($model->flete_dua ==  null ? 0 : floatval($model->flete_dua ));

        $data['objs'] =[
            'pais_id'=>null,
            'puerto_id'=>null,
            'tarifa_id'=>null
        ];

        return $data ;
    }

    /************************* SAVE ***********************************/
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