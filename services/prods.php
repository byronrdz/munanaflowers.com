<?php
	$color = $_GET["color"];
	$variedad = $_GET["var"];
	$tipo_flor = $_GET["flower"];
	$notas = $_GET["note"];
	$elements = $_GET["elements"];
	$page = $_GET["page"];
	$img_dir= $_GET["img_dir"];		
	if (is_null($color)) $color='%';
	if (is_null($variedad)) $variedad='%';
	if (is_null($tipo_flor)) $tipo_flor='%';
	if (is_null($notas)) $notas='%';
	if (is_null($page)) $page = 1;
	if (is_null($elements)) $elements = 5;
	if (is_null($img_dir)) $img_dir = htmlentities('imgs/galeria/');
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
//    	header('Content-encoding: gzip');
	$datos = array('empresa'=>'Munanaflowers S.A.','elements'=>$cuenta ,'variedades'=>$datos);
	echo json_encode($datos,JSON_UNESCAPED_SLASHES);
?>
