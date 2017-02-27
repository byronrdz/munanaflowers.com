<?php
$ind=0;
if(isset($_GET['ind'])){$ind = intval($_GET['ind']);}

$fuente = 'https://www.munanaflowers.com/pruebas-new-model/munanaflowers.com/services/newschannel.php';
$noticia = array();

    $xml = simplexml_load_file($fuente);

if($xml){
	
 	$titulo = $xml->channel->item[$ind]->title;
	$fecha =  $xml->channel->item[$ind]->pubDate;
    $nota = $xml->channel->item[$ind]->description;
    $fuente = $xml->channel->item[$ind]->source;	
    $autor = $xml->channel->item[$ind]->author;
    $link = $xml->channel->item[$ind]->link;	
	
    $noticia['titulo'] =htmlentities((string) $titulo);
    $noticia['fecha'] =htmlentities((string) $fecha);
    $noticia['fuente'] =htmlentities((string) $fuente);
    $noticia['autor'] =htmlentities((string) $autor);	
    $noticia['link'] =htmlentities((string) $link);	

    $noticia['nota'] =(string) $nota;
    
    $noticia = json_encode($noticia);
	//$noticia = str_replace('\\','',$noticia);  
    header('Content-type: application/json; charset=utf-8');
    
    echo($noticia);
    
} else {
	echo 'Error:'.'<br>';
    exit('Failed to open address.');
}
?>

