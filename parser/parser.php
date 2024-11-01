<?php


function thedate_diff($date, $date2 = 0){
    if(!$date2)
        $date2 = mktime();

    $date_d = array('seconds'  => '',
                       'minutes'  => '',
                       'hours'    => '',
                       'days'     => '',
                       'weeks'    => '',
                       
                       'tseconds' => '',
                       'tminutes' => '',
                       'thours'   => '',
                       'tdays'    => '',
                       'tdays'    => '');

    ////////////////////
    
    if($date2 > $date)
        $tmp = $date2 - $date;
    else
        $tmp = $date - $date2;

    $seconds = $tmp;

    // Relative ////////
    $date_d['weeks'] = floor($tmp/604800);
    $tmp -= $date_d['weeks'] * 604800;

    $date_d['days'] = floor($tmp/86400);
    $tmp -= $date_d['days'] * 86400;

    $date_d['hours'] = floor($tmp/3600);
    $tmp -= $date_d['hours'] * 3600;

    $date_d['minutes'] = floor($tmp/60);
    $tmp -= $date_d['minutes'] * 60;

    $date_d['seconds'] = $tmp;
    
    // Total ///////////
    $date_d['tweeks'] = floor($seconds/604800);
    $date_d['tdays'] = floor($seconds/86400);
    $date_d['thours'] = floor($seconds/3600);
    $date_d['tminutes'] = floor($seconds/60);
    $date_d['tseconds'] = $seconds;

    return $date_d; }


    
$feedQuery = $_POST['q'];
$rawfeeds = array($facebook,'http://search.twitter.com/search.atom?q=MONKEYS',
'http://blogsearch.google.com/blogsearch_feeds?q=MONKEYS&num=100&scoring=d');
$feedArray = array();
foreach($rawfeeds as $feed)
{
$newfeed = str_replace("MONKEYS", $feedQuery, $feed);
array_push($feedArray, $newfeed);
}
require_once('simplepie.inc');
$feed = new SimplePie();
$feed->set_feed_url($feedArray);
$feed->set_item_limit(100);
$feed->strip_htmltags(array('br','a','p','b'));
$feed->enable_cache(false);
$feed->init();
$feed->handle_content_type();
$feed->set_favicon_handler('handler_image.php','favicon');
$feed->set_image_handler('handler_image.php');

$item_count = $feed->get_item_quantity(); 

if($item_count == 0){
?>Oh no! There are no results at this time! Check back later and have a great day!<?php	
}else{

	foreach ($feed->get_items() as $item):
	?><p class="ssocial-border22"><a target="_blank" charset="UTF-8" href="<?php echo $item->get_permalink(); ?>"><?php echo substr($item->get_title(), 0, 85)."..."; ?></a></p>
<small><a class="time" href="<?php echo $item->get_permalink(); ?>"><img src="<?php echo $feed->get_favicon(); ?>" /><?php 
$time1 = time();
$time2 = $item->get_date('U');
$diff = thedate_diff($time1, $time2);
if($diff['weeks']>0){echo $diff['weeks']." weeks, ";}
if($diff['days']>0){echo $diff['days']." days, ";}
if($diff['hours']>0){echo $diff['hours']." hours, ";}
if($diff['minutes']>0){echo $diff['minutes']." minutes and ";}
if($diff['seconds']>0){echo $diff['seconds']." seconds ago.";} ?></a></small>
<?php 
endforeach; 
}




?>