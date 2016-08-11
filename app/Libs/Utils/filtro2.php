<?php
	namespace App\Libs\Utils;
    $hostname_valcro = "valcrolindes01";
    $database_valcro = "valcro_db2";
    $username_valcro = "userVal";
    $password_valcro = "ntmJX2zn92CQFc6P";
	$tabla = "proveedores";
	$field = "razon_social";
	$render = $_REQUEST['render'] || false;
	$find = strtoupper($_GET['find']);
    $valcro = mysql_connect($hostname_valcro, $username_valcro, $password_valcro) or trigger_error(mysql_error(),E_USER_ERROR);
	$lawletters = ["S.L.U.","S.L.","CO, LTD.","LLC","S.A.","LDA","S.P.A.","s.p.a.","LIMITED","CORP.","S.A.E","S.L.","S.R.L.","S.A.S","INC.","INC","GMBH CO.KG","NV","CO."];
	$find = str_replace($lawletters,"", $find);
   	mysql_select_db($database_valcro);
	//echo $find;
	
	$split = explode(" ", $find);
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
		
		$query = mysql_query("select id, $field as nombre from $tabla having nombre like '$currentWord' or nombre like '%$currentWord%' or nombre like '%$firstinp%' or nombre like '%$midinp%' or nombre like '%$endinp%' ");
		if($query){
			while($data = mysql_fetch_array($query)){
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
	if($render) {
		echo "<h1>" . $auxWords . "</h1>"; //palabra "CORREGIDA"
	}
	$wordsNew = explode(" ", $auxWords);
	$newQuery = "select id, $field as nombre from $tabla having nombre like '$newFind' or nombre like '%$newFind%' or (";
	$unionQuery = "select id, $field as nombre from $tabla having";
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
	$finalQuery = mysql_query($newQuery);
	
	if($finalQuery){
		if(mysql_num_rows($finalQuery)){
			while($data=mysql_fetch_assoc($finalQuery)){
				foreach ($wordsNew as $key => $value) {
					if($value!=""){
						$prefinal[$data['id']] = array('incident'=>0,'nombre'=>$data['nombre']); //carga el array de incidencia
						if($render) {
							$data['nombre'] = str_replace($value, "<b>$value</b>", $data['nombre']); //marca en un array el punto de coincidencia
						}
					}
				}
				if($render){
					echo $data['nombre']."<br>"; //imprime coincidencias si requerido
				}

			}
		}
	}
	
	foreach ($wordsNew as $key => $value) {
		sbQuery("select id, $field as nombre from $tabla having nombre like '%$value%'",$prefinal);
	}

	usort($prefinal, function($a, $b) {
		return $a['incident'] + $b['incident'];
	});
	if($render) {
		print_r($prefinal);
	}else{
		echo json_encode($prefinal);
	}
	function sbQuery($query,$prefinal){
    	global $prefinal;
        $rs=mysql_query($query);
        if($rs){
            while($data=mysql_fetch_array($rs)){
              if(key_exists($data['id'], $prefinal)){
              	$prefinal[$data['id']]['incident']++;
              }
            }
            //echo json_encode($list);
        }
    }
    
	
	//echo json_encode($words);    
	//print_r($words);
  	
    //$lengInp= strlen($find);
	//$division = round(($lengInp*30)/100);
	
	
?>