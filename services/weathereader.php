<?php
include "conn.php";
$query = "select * from t_clima where vigente='OK' order by lectura desc limit 7";
$result = pg_query($query) or die('Result can not be obtained: ' . pg_last_error());

$datos = array();

$n=0;
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
	
	$datos[$n]=$line;
	switch($line['ciudad']){
		case 'Quito':
			$datos[$n]['coords']='-78.52,-0.23';
			break;
		case 'Ibarra':
			$datos[$n]['coords']='-78.12, 0.35';
			break;
		case 'Cayambe':
			$datos[$n]['coords']='-78.13, 0.05';
			break;
		case 'Cumbayá':
			$datos[$n]['coords']='-78.43, -0.02';
			break;
		case 'Cuenca':
			$datos[$n]['coords']='-78.98, -2.88';
			break;
		case 'Latacunga':
			$datos[$n]['coords']='-78.62, -0.93';
			break;
		case 'Guayaquil':
			$datos[$n]['coords']='-79.90, -2.17';
			break;
		}
	
	$n++;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($datos);

?>