<?php
	$xmlstr =  	
	"<rss version='2.0'>
		<channel>
			<title>Munanaflowers RSS News Channel</title>
			<link>https://www.munanaflowers.com</link>
			<description>Munanaflowers RSS News Channel</description>
			<image>
				<url>https://www.munanaflowers.com/imgs/munana-logo.jpg</url>
				<link>https://www.munanaflowers.com</link>
				<title>Munanaflowers Logo</title>
			</image>
		</channel>
	</rss>";


	include 'conn.php';
	$query = 'SELECT * FROM	 t_news ORDER BY pubdate DESC LIMIT 100';
	$result = pg_query($query) or die('Result can not be obtained: ' . pg_last_error());

	$sxe = new SimpleXMLElement($xmlstr);


	while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
		
		$item = $sxe->channel->addChild('item');	
		
		$cont_title = $line['title'];
		$title = $item->addChild('title', $cont_title);

		$cont_pubdate = date('r',strtotime($line['pubdate']));
		$pubDate = $item->addChild('pubDate',$cont_pubdate);

		$author = $item->addChild('author',$line['author']);		
		$link = $item->addChild('link',$line['link']);
		$guid = $item->addChild('guid',$line['guid']);
		
		$cont_description = htmlspecialchars("<div style='width:100%;height:auto'><div style='width:120px;position=relative;top=0px;left=5px;display:inline-block;overflow:hidden;vertical-align:middle'><img src= '".$line['image']."' width=120px alt=''></div><div style='margin:2px;display:inline-block; position:relative;left:5px; width:70%; height:auto; color:#606060;display:inline-block;overflow:hidden;vertical-align:middle;font-size:14px'>  ".htmlentities($line['description'])."</div></div>"); 
				
		$description = $item->addChild('description',$cont_description);		

		$source = $item ->addChild('source',$line['source']);
		$source->addAttribute('url',$line['source_url']);
	}
	pg_free_result($result);

	$salida = ($sxe->asXML());
	$salida = str_replace("<?xml version=\"1.0\"?>","",$salida);
	echo $salida;

?>