<?php
/**
 * Created by PhpStorm.
 * User: jacsiel
 * Date: 20/10/16
 * Time: 04:03 PM
 */

namespace App\Http\Controllers\Criterio;


use App\Models\Sistema\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use Validator;

use App\Models\Sistema\Providers\Provider;
use App\Models\Sistema\Criterios\CritCampos as Campos;
use App\Models\Sistema\Criterios\CritTipoCamp as Types;
use App\Models\Sistema\Masters\Line;
use App\Models\Sistema\Criterios\CritLinCamTip as Criterio;
use App\Models\Sistema\Criterios\CritCampoOption as Options;

class CritController extends BaseController
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function getCampos(){
        return json_encode(Campos::all());
    }
    
    public function getTypes(){
        $types = Types::all();
        foreach ($types as $tip){
            $tip['cfg'] = $tip->config()->get();
        }
        return json_encode($types);
    }
    
    public function getCriterio(){
        $crit = Criterio::where("linea_id","1")->get();
        foreach ($crit as $field){
            $field->line;
            $field->field;
            $field->type;
            $field['options'] = $field->options()->get();
        }
        return  json_encode($crit);
    }

    public function saveCritField(Request $rq){
        $ret = array("action"=>"new","id"=>false);
        if($rq->id){
            $crit = Criterio::find($rq->id);
            $ret["action"]="upd";
        }else{
            $crit = new Criterio();
        }
        $crit->linea_id = $rq->line;
        $crit->campo_id = $rq->field;
        $crit->tipo_id = $rq->type;

        $crit->save();
        $ret["id"] = $crit->id;
        return $ret;

    }

    public function saveOptions(Request  $reqs){
        $ret = array();
        foreach ($reqs->request as $k=>$rq){

            if($rq['id']){
                $opt = Options::find($rq['id']);
                if($opt->value == $rq['valor']){
                    continue;
                }
                $ret[$k]["action"]="upd";
            }else{
                $opt = new Options();
            }
            $opt->lct_id = $rq['field_id'];
            $opt->opc_id = $rq['opc_id'];
            $opt->value = $rq['valor'];

            $opt->save();
            $ret[$k]["id"] = $opt->id;
            return $ret;
        }


    }
}