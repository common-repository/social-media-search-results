<?php 
date_default_timezone_set('America/New_York');
$q = urlencode($_GET['q']);
header("Content-Type: application/xml; charset=UTF-8"); 
echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<atom:link href="" rel="self" type="application/rss+xml" />
		<title>Facebook Results For: <?php echo $q; ?>.</title>
		<link></link>
		<description>Facebook Results For: <?php echo $q; ?>.</description> 
		<language>en-us</language>
<?php
$url = "http://graph.facebook.com/search?q=".$q."&type=post&limit=100";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($ch);
curl_close($ch);
$farray = array();
$farray = json_decode($json, true);
foreach ($farray as $value)
  {
	  foreach ($value as $item)
  		{ 
	  		$uparts = explode('_',$item["id"]);
	  		$url = utf8_encode(htmlentities("http://www.facebook.com/profile.php?id=".$uparts[0]."&story_fbid=".$uparts[1]."&v=wall"));
	  		$order = array("\r\n", "\n", "\r");	  		
	  		$title = str_replace('&', '%26', html_entity_decode(utf8_encode(str_replace($order, '', strip_tags(substr($item["message"], 0, 140)))), ENT_QUOTES, 'UTF-8'));
	  		$description = str_replace('&', '%26', html_entity_decode(utf8_encode(str_replace($order, '', strip_tags(substr($item["message"], 0, 300)))), ENT_QUOTES, 'UTF-8'));
	  	if(strlen($title)==0){}
	  	elseif(strlen($uparts[1])==0){}
	  	else{ ?>		
		<item>
			<title><?php echo $title; ?></title>
			<link><?php echo $url; ?></link>
			<description><?php echo $description; ?></description>
			<pubDate><?php 
			$datest = explode("T", $item["updated_time"]);
			$date = explode("-", $datest[0]);
			$time = explode(":", $datest[1]);
			$second = substr($time[2], 0, -5);
			
		echo date("r",mktime($time[0]-4,$time[1],$second,$date[1],$date[2],$date[0]));			
			
			
			 ?></pubDate>
			<guid><?php echo $url; ?></guid>
		</item>
<?php }}} ?>	
	</channel>
</rss>
