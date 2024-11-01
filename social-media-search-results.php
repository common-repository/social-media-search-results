<?php
/*
Plugin Name: Social Media Search Results
Plugin URI: http://22media.com/plugins/social-media-real-time-search-results-plugin
Description: A simple plugin that allows users to embed "Social Media Search" results
Version: 1.0
Author: Joe Hall
Author URI: http://22media.com/
License: GPL2
*/

//JAVASCRIPTS AND CSS

wp_enqueue_script('jquery');
add_action('wp_ajax_SocialSeach22', 'SocialSeach22_callback');
add_action('wp_ajax_nopriv_SocialSeach22', 'SocialSeach22_callback');
function SocialSeach22_callback() {
$facebook = plugins_url('parser/facebookapi.php?q=MONKEYS' , __FILE__ );
//MAIN PARSER
require_once('parser/parser.php');
die();
}

function socialHead22(){
?>
<script type="text/javascript">
var ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function($) {
	var data = {
		action: 'SocialSeach22',
		q: $("#query22").val(),
	};
	jQuery.post(ajaxurl, data, function(response) {
		$("#ssocial22").empty().append($(response));
	});
});
</script>
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('css/style.css', __FILE__ ); ?>" />
<?php	
}
add_action('wp_head', 'socialHead22');


//SHORTCODE

function socialss22( $atts ) {
	extract( shortcode_atts( array(
		'q' => '22media',
	), $atts ) );
?>
<h2>Social Search Results For: <?php echo $q; ?></h2>
<div id="ssocial22">
<input id="query22" type="hidden" value="<?php echo $q; ?>">
<center>
<img src="<?php echo plugins_url('img/ajax-loader.gif', __FILE__ ); ?>" /><br/>
Please stand by while the results are populated...
</center>
</div>
<?php

}
add_shortcode( 'Social Search', 'socialss22' );

?>