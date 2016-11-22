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
use App\Models\Sistema\Criterios\OpcionList as Lista ;
use App\Models\Sistema\Criterios\CritOption;


class CritController extends BaseController
{
   /* public function __construct()
    {

        $this->middleware('auth');
    }*/

    public function getCampos(){
        return json_encode(Campos::all());
    }
    public function getListType(){
        return json_encode(Lista::all());
    }
    public function getOptions(){
        return json_encode(CritOption::all());
    }

    public function getAvaiableLines(){
       $lines = Line::all();
        foreach ($lines as $line){
            $line['hasCrit'] = $line->criterios()->count() > 0;
        }
        return $lines;

    }
    
    public function getTypes(){
        $types = Types::all();
        foreach ($types as $tip){
            $tip['cfg'] = $tip->config()->get();
        }
        return json_encode($types);
    }
    
    public function getCriterio($line){
        $crit = Criterio::where("linea_id",$line)->get();
        foreach ($crit as $field){
            $field->line;
            $field->field;
            $field->type;
            $field['options'] = $field->options()->get();
        }
        return  json_encode($crit);
    }

    public function createLine(Request $rq){
        $ret = array("action"=>"new","id"=>false);
        $usr = $rq->session()->get('DATAUSER');
        if($rq->id){
            $line = Line::find($rq->id);
            $ret["action"]="upd";
        }else{
            $line = new Line();
        }
        $line->linea = $rq->name;
        $line->siglas = $rq->letter;
        $line->user_id = $usr['id'];

        $line->save();
        $ret["id"] = $line->id;
        return $ret;
    }

    public function createOptionList(Request $rq){
        $ret = array("action"=>"new","id"=>false);
        $exist = Lista::where("nombre",$rq->name)->count();
        if($exist>0){
            $ret["action"]="error";
        }else{
            $opt = new Lista();
            $opt->nombre = $rq->name;
            $opt->save();
            $ret["id"] = $opt->id;
            return $ret;
        }

    }

    public function saveCritField(Request $rq){
        $ret = array("action"=>"new","id"=>false,"ready"=>false);
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
        $ret["ready"] = ($crit->linea_id && $crit->campo_id && $crit->tipo_id);
        return $ret;

    }

    public function saveOptions(Request  $reqs){
        $ret = array();
        foreach ($reqs->request as $k=>$rq){
            if($k != "opts"){
                if($rq['id']){
                    $opt = Options::find($rq['id']);

                    if($opt->value == $rq['valor'] && $opt->message == $rq['msg']){
                        continue;
                    }
                    $ret[$k]["action"]="upd";
                }else{
                    $opt = new Options();
                }
                $opt->lct_id = $rq['field_id'];
                $opt->opc_id = $rq['opc_id'];
                $opt->value = $rq['valor'];
                $opt->message = $rq['msg'];

                $opt->save();
                $ret[$k]["id"] = $opt->id;
            }else{
                /*elimina todos los registros que no esten en el array que se recibe del request*/
                Options::where("lct_id",$rq['field_id'])->where("opc_id",$rq['opc_id'])->whereNotIn("value",$rq['valor'])->delete();

                $regs = Options::where("lct_id",$rq['field_id'])->where("opc_id",$rq['opc_id'])->lists("value");

                foreach ($rq['valor'] as $opcion){

                    if(!$regs->contains($opcion)){
               
                        $opt = new Options();
                        $opt->lct_id = $rq['field_id'];
                        $opt->opc_id = $rq['opc_id'];
                        $opt->value = $opcion;
                        $opt->save();
                        $ret[$k]["id"] = $opt->id;
                    }
                }
            }


        }
        return $ret;

    }
}