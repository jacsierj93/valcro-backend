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
use App\Models\Sistema\Criterios\CritDependency;
use App\Models\Sistema\Criterios\CritDependencyAction;


class CritController extends BaseController
{
    /*public function __construct()
    {

        $this->middleware('auth');
    }*/

    public function getCampos(){
        $fields  = Campos::all();
        foreach ($fields as $field ){
            $field["lineas"] = $field->getLine()->lists("linea");
        }
        return json_encode($fields);
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
        $crit = Criterio::where("linea_id",$line)
            ->whereNotNull("campo_id")
            ->whereNotNull("tipo_id")
            ->get();
        foreach ($crit as $field){
            $field->line;
            $field->field;
            $field->type;
            $field['deps'] = $field->dependency()->get();
            foreach ($field['deps'] as $dep){
                $dep['parent'] = $dep->parent()->first();
                if(!($dep['accion']=="true" || $dep['accion']=="false")){
                    $dep['accion'] = explode(",",$dep['accion']);
                }
            }
            $field['options'] = $field->options()->get()->groupBy("descripcion");

            if(!$field['options']->has("Opcion")){
                continue;
            }

            foreach ($field['options']['Opcion'] as $opt){
                $opt["elem"] = Lista::find($opt->pivot->value);
            }


        }
        return  json_encode($crit);
    }
    public function treeMap($line){
        $tree = Criterio::selectRaw('id ,linea_id, tipo_id,campo_id,RAND() as randon')->where("linea_id",$line)
            ->doesntHave("dependency")
            /*->has("children")*/
            ->with(array('field'=>function($query){
                $query->selectRaw('id,descripcion,RAND() as random');
            }))
            ->with("children")
            ->get();
        /*foreach ($tree as $branch){
            self::recursive($branch);
        }*/
        return $tree;


    }

    private static function recursive ($child){
        //$child->field['cod']=$child->field['id'];

        foreach ($child->childCfg as $cur){

            $child['children'] = $cur->children;
            self::recursive($cur['children'][0]);
        }
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

    public function saveField(Request $rq){
        $ret = array("action"=>"new","id"=>false,"ready"=>false);
        if($rq->id){
            $crit = Campos::find($rq->id);
            $ret["action"]="upd";

        }else{
            $crit = new Campos();
        }

        $crit->descripcion = $rq->descripcion;
        $crit->tipo_id = $rq->tipo_id;

        $crit->save();
        $ret["id"] = $crit->id;
        //$ret["ready"] = ($crit->linea_id && $crit->campo_id && $crit->tipo_id);
        return $ret;

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
                if(!$rq['id'] && $rq['valor']==""){
                    continue;
                }
                if($rq['id']){
                    $opt = Options::find($rq['id']);

                    if($opt->value == $rq['valor'] && $opt->message == $rq['msg']){
                        continue;
                    }

                    if($rq['valor']==""){
                        $opt->delete();
                        $ret[$k]["action"]="del";
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

    public function saveDependency(Request $rq){
        $ret = array("action"=>"new","id"=>false,"ready"=>false);
        if($rq->id){
            $dep = CritDependency::find($rq->id);
            $ret["action"]="upd";

        }else{
            $dep = CritDependency::where("lct_id",$rq->parent_id)->where("operador",$rq->operator)->where("valor",$rq->condition)->first();
           // dd($dep);
            if($dep){
                $ret["action"]="upd";

            }else{
                $dep = new CritDependency();
            }
        }


            $dep->lct_id = $rq->parent_id;
            $dep->operador = $rq->operator;
            $dep->valor = $rq->condition;
            $dep->accion = (gettype($rq->action) == "array")?implode(",",$rq->action):$rq->action;
            $dep->sub_lct_id = $rq->lct_id;
            $dep->save();
            $ret['id'] = $dep->id;
        //}
        return $ret;
    }
}