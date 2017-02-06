<?php
	$color = '%';
	$variedad = '%';
	$tipo_flor = '%';
	$notas = '%';
	$elements = 20;
	$page = 1;
	$img_dir = 'imgs/galeria/';
	if(isset($_GET["color"])){$color = $_GET["color"];}
	if(isset($_GET["var"])){$variedad = $_GET["var"];}
	if(isset($_GET["flower"])){$tipo_flor = $_GET["flower"];}
	if(isset($_GET["note"])){$notas = $_GET["note"];}
	if(isset($_GET["elements"])){$elements = $_GET["elements"];}
	if(isset($_GET["page"])){$page = $_GET["page"];}
	if(isset($_GET["img_dir"])){$img_dir= $_GET["img_dir"];}
	$page = ($page-1) * $elements;

	include 'conn.php';
	$query = 'SELECT variedad,tipo_flor,color,unidad,notas FROM t_producto WHERE color LIKE \''.$color.'%\' AND tipo_flor LIKE \''.$tipo_flor.'\' AND variedad LIKE \''.$variedad.'\' AND notas LIKE \''.$notas.'\' order by tipo_flor, color, variedad LIMIT '.$elements.' OFFSET '.$page;
	$result = pg_query($query) or die('Result can not be obtained: ' . pg_last_error());
	$datos = array();
	$m = 0;
	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		$linea = array();
		$n = 0;				
		foreach ($line as $key => $col_value){
			$linea[$key] = $col_value;
			$n++;
		}
		$linea['thumbnail'] = $img_dir.'th_'.strtolower(str_replace(' ','',$linea['variedad'])).'.jpg';
		$linea['image'] = $img_dir.'pr_'.strtolower(str_replace(' ','',$linea['variedad'])).'.jpg';		
		$datos[$m] = $linea;
		$m++;		
    	}
	pg_free_result($result);
	$query = 'SELECT COUNT(id_producto) FROM t_producto WHERE color LIKE \''.$color.'%\' AND tipo_flor LIKE \''.$tipo_flor.'\' AND variedad LIKE \''.$variedad.'\'AND notas LIKE \''.$notas.'\'';
	$result = pg_query($query) or die('Count can not be obtained: ' . pg_last_error());
	$cuenta = pg_fetch_result($result,0,0);
	pg_free_result($result);
	pg_close($con);
    	header('Content-type: application/json; charset=utf-8');
	$datos = array('empresa'=>'Munanaflowers S.A.','elements'=>$cuenta ,'variedades'=>$datos);
	$jdata = json_encode($datos);
	$jdata = str_replace('\\','',$jdata);
	echo $jdata;
?>
