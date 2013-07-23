<?php 
/**
 * @package SpiderFC
 * @author Web-Dorado
 * @copyright (C) 2011 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
$path  = '';  
if ( !defined('WP_LOAD_PATH') ) {

	/** classic root path if wp-content and plugins is below wp-config.php */
	$classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
	
	if (file_exists( $classic_root . 'wp-load.php') )
		define( 'WP_LOAD_PATH', $classic_root);
	else
		if (file_exists( $path . 'wp-load.php') )
			define( 'WP_LOAD_PATH', $path);
		else
			exit("Could not find wp-load.php");
}
// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');

global $wpdb;

	//$theme=$this->theme;
	//$startWithMonday = $theme->startWithMonday;
if(!empty($_GET['spiderid']))
{
	$id = (int)$_GET['spiderid'];
	$q = "SELECT ".$wpdb->prefix."spiderfc_theme.paramsvalue FROM  ".$wpdb->prefix."spiderfc_theme JOIN ".$wpdb->prefix."spiderfc_calendar 
				ON ".$wpdb->prefix."spiderfc_theme.theme_id=".$wpdb->prefix."spiderfc_calendar.id_theme 
				WHERE  ".$wpdb->prefix."spiderfc_calendar.id=".$id." and 
				".$wpdb->prefix."spiderfc_theme.paramsname='startWithMonday' ORDER BY ".$wpdb->prefix."spiderfc_theme.id";
$parameters = $wpdb->get_row($q);
$startWithMonday = $parameters->paramsvalue;
echo '<lang>
	<months>'.__('January','spiderfc').', '.__('February','spiderfc').', '.__('March','spiderfc').', '.__('April','spiderfc').', '.__('May','spiderfc').', '.__('June','spiderfc').', '.__('July','spiderfc').', '.__('August','spiderfc').', '.__('September','spiderfc').', '.__('October','spiderfc').', '.__('November','spiderfc').', '.__('December','spiderfc').'</months>
	<monthsShort>'.__('Jan','spiderfc').', '.__('Feb','spiderfc').', '.__('Mar','spiderfc').', '.__('Apr','spiderfc').', '.__('May','spiderfc').', '.__('Jun','spiderfc').', '.__('Jul','spiderfc').', '.__('Aug','spiderfc').', '.__('Sep','spiderfc').', '.__('Oct','spiderfc').', '.__('Nov','spiderfc').', '.__('Dec','spiderfc').'</monthsShort>';

if($startWithMonday==1)	
{
	echo'	
	<days>'.__('Monday','spiderfc').', '.__('Tuesday','spiderfc').', '.__('Wednesday','spiderfc').', '.__('Thursday','spiderfc').', '.__('Friday','spiderfc').', '.__('Saturday','spiderfc').', '.__('Sunday','spiderfc').'</days>
	<daysShort>'.__('Mon','spiderfc').', '.__('Tue','spiderfc').', '.__('Wed','spiderfc').', '.__('Thu','spiderfc').', '.__('Fri','spiderfc').', '.__('Sat','spiderfc').', '.__('Sun','spiderfc').'</daysShort>';
}
else{
	echo'	
	<days>'.__('Sunday','spiderfc').', '.__('Monday','spiderfc').', '.__('Tuesday','spiderfc').', '.__('Wednesday','spiderfc').', '.__('Thursday','spiderfc').', '.__('Friday','spiderfc').', '.__('Saturday','spiderfc').'</days>
	<daysShort>'._('Sun','spiderfc').', '.__('Mon','spiderfc').', '.__('Tue','spiderfc').', '.__('Wed','spiderfc').', '.__('Thu','spiderfc').', '.__('Fri','spiderfc').', '.__('Sat','spiderfc').'</daysShort>';
}
	
echo'	
	<event>'.__('Event','spiderfc').'</event>
	<events>'.__('Events','spiderfc').'</events>
	<priority>'.__('Priority','spiderfc').'</priority>
	<priority0Text>'.__('No Priority','spiderfc').'</priority0Text>
	<priority1Text>'.__('Low Priority','spiderfc').'</priority1Text>
	<priority2Text>'.__('Medium Priority','spiderfc').'</priority2Text>
	<priority3Text>'.__('High Priority','spiderfc').'</priority3Text>
	
	<time>'.__('Time','spiderfc').'</time>
	<startDate>'.__('From','spiderfc').'</startDate>
	<endDate>'.__('To','spiderfc').'</endDate>
	
	<eventsListHeaderTitleText>'.__('Events On','spiderfc').'</eventsListHeaderTitleText>
	
	<type>Type</type>
</lang>';
}
?>