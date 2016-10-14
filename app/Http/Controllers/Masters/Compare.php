<?php
/**
 * Created by PhpStorm.
 * User: laptoHPWhite
 * Date: 11/08/2016
 * Time: 14:47
 */

namespace App\Http\Controllers\Masters;
/*use App\Libs\Api\RestApi;
use App\Models\Sistema\FileModel;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Log;*/
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use Session;
use DB;
//use Storage;


class Compare extends BaseController
{

 /*   private $hostname_valcro = "valcrolindes01";
    private $database_valcro = "valcro_db2";
    private $username_valcro = "userVal";
    private $password_valcro = "ntmJX2zn92CQFc6P";*/
    private $tabla;
    private $field;
    private $render;
    private $find;
    private $prefinal = [];

    public function __construct()
    {

       // $this->middleware('auth');
    }

    public function search(Request $filt){
        $this->tabla = $filt->table;
        $this->field = $filt->campo;
        $this->render = false;
        $this->find = $filt->search;
        //$valcro = mysql_connect($hostname_valcro, $username_valcro, $password_valcro) or trigger_error(mysql_error(),E_USER_ERROR);
        $lawletters = ["S.L.U.","S.L.","CO, LTD.","LLC","S.A.","LDA","S.P.A.","s.p.a.","LIMITED","CORP.","S.A.E","S.L.","S.R.L.","S.A.S","INC.","INC","GMBH CO.KG","NV","CO."];
        $this->find = str_replace($lawletters,"", $this->find);
       //mysql_select_db($database_valcro);
        //echo $find;

        $split = explode(" ", $this->find);
        /*ARRAY RELACIONAL CUYAS CLAVES SON LAS PALABRAS */
        $words = [];
        for($i=0;$i<count($split);$i++){
            $currentWord = $split[$i];
            $words[$currentWord]=[];
            $lengInp= strlen($currentWord);
            $division = round(($lengInp*30)/100);

            $firstinp=substr($currentWord, 0, $division);
            $midinp=substr($currentWord,  $division, $division);
            $endinp=substr($currentWord, ($division*2));
            $query = DB::select("select id, $this->field as nombre from $this->tabla having nombre like '$currentWord' or nombre like '%$currentWord%' or nombre like '%$firstinp%' or nombre like '%$midinp%' or nombre like '%$endinp%' ");
            //$query = mysql_query("select id, $field as nombre from $tabla having nombre like '$currentWord' or nombre like '%$currentWord%' or nombre like '%$firstinp%' or nombre like '%$midinp%' or nombre like '%$endinp%' ");
            if($query){
                foreach($query as $data){
                //while($data = mysql_fetch_array($query)){
                    $name = $data['nombre'];
                    $aux = 0;
                    $correct = "";
                    $name = str_replace([",","."], " ", $name);
                    $splitbd = explode(" ", $name);
                    foreach($splitbd as $key => $valor ){
                        similar_text($currentWord, $valor, $percent);
                        if($percent>$aux){
                            $aux = $percent;
                            $correct = $valor;
                        }
                    }

                    $arrayAux = ["index" => $aux, "palabra" => $correct];
                    if(!in_array($arrayAux, $words[$currentWord])){
                        $words[$currentWord][]=["index" => $aux, "palabra" => $correct];
                    }


                }
            }

            arsort($words[$currentWord]);
            //print_r($new);
        }

        $newFind ="";
        $auxWords = "";
        foreach($words as $key => $val){
            $internalKey=key($words[$key]);
            do{
                $internalKeydo=key($words[$key]);
                $auxWords.= " ".$val[$internalKeydo]['palabra'];
                $current = $val[$internalKeydo]['index'];
                next($words[$key]);
            }while($current==$val[key($words[$key])]['index']);

            $newFind.=$val[$internalKey]['palabra'];
            $newFind.=" ";
        }
        //echo $newFind;
        if($this->render) {
            echo "<h1>" . $auxWords . "</h1>"; //palabra "CORREGIDA"
        }
        $wordsNew = explode(" ", $auxWords);
        $newQuery = "select id, $this->field as nombre from $this->tabla having nombre like '$newFind' or nombre like '%$newFind%' or (";
        $unionQuery = "select id, $this->field as nombre from $this->tabla having";
        foreach ($wordsNew as $key => $value) {
            if($value!=""){
                $newQuery .= " nombre like '%$value%' and";
                $unionQuery .= " nombre like '%$value%' or";
            }

        }

        /*busca en la bd coincidencias con la frace ya corregida*/
        $newQuery = rtrim($newQuery,"and");
        $unionQuery = rtrim($unionQuery,"or");
        $newQuery.=") union $unionQuery";
        //echo $newQuery;
        $finalQuery = DB::select($newQuery);

        if($finalQuery){
            if(sizeof($finalQuery)){
                foreach($finalQuery as $data){
                //while($data=mysql_fetch_assoc($finalQuery)){
                    foreach ($wordsNew as $key => $value) {
                        if($value!=""){
                            $this->prefinal[$data['id']] = array('incident'=>0,'nombre'=>$data['nombre']); //carga el array de incidencia
                            if($this->render) {
                                $data['nombre'] = str_replace($value, "<b>$value</b>", $data['nombre']); //marca en un array el punto de coincidencia
                            }
                        }
                    }
                    if($this->render){
                        echo $data['nombre']."<br>"; //imprime coincidencias si requerido
                    }

                }
            }
        }

        foreach ($wordsNew as $key => $value) {
            $this->sbQuery("select id, $this->field as nombre from $this->tabla having nombre like '%$value%'");
        }
        arsort($this->prefinal);
        /*usort($this->prefinal, function($a, $b) {
            return $a['incident'] + $b['incident'];
        });*/
        if($this->render) {
            print_r($this->prefinal);
        }else{
            if($filt->provId) {

                return (array_key_exists($filt->provId,$this->prefinal))?1:0;
            }

        }
    }

    public function sbQuery($query){
        $rs=DB::select($query);
        if($rs){
            foreach($rs as $data){
                //while($data=mysql_fetch_array($rs)){
                if(key_exists($data['id'], $this->prefinal)){
                    $this->prefinal[$data['id']]['incident']++;
                }
            }
            //echo json_encode($list);
        }
    }
}