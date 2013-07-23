<?php
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

echo '<?xml version="1.0" encoding="utf-8"?>

<events>';


if(!empty($_GET['spiderid']))
{
	$id = (int)$_GET['spiderid'];
	$row = $wpdb->get_row("SELECT id FROM  ".$wpdb->prefix."spiderfc_calendar WHERE id ='".$id."' and published=1 ");

	if($row->id){
		
		$q = "SELECT * FROM  ".$wpdb->prefix."spiderfc_events WHERE id_calendar= '".$row->id."' and published=1";
		$events = $wpdb->get_results($q);
	


	foreach($events as $event){
		$date_begin = substr($event->date_begin,8,2).'-'.substr($event->date_begin,5,2).'-'.substr($event->date_begin,0,4);
		$date_end = substr($event->date_end,8,2).'-'.substr($event->date_end,5,2).'-'.substr($event->date_end,0,4);
		
		
		$time_begin="";
		if(substr( $event->event_time_begin,0,5)!=""){
			
			$time_begin=substr( $event->event_time_begin,0,5);
			
			}
			$time_end ='';
			 if(substr($event->event_time_end,0,5)!="" ){
				 $time_end =substr($event->event_time_end,0,5);
			 }

		echo '		
		<eventFree>
		<startDate>'.$date_begin.' '.$time_begin.'</startDate>
		<endDate>'.$date_end.' '.$time_end.'</endDate>
		<title>'.$event->title.'</title>
		<description>
			<text>'.$event->text.'</text>
			<html>'.htmlspecialchars(apply_filters('the_content', $event->html)).'</html>
			<css>'.$event->css.'</css>
			<htmlUrl>'.$event->htmlUrl.'</htmlUrl>
			<cssUrl>'.$event->cssUrl.'</cssUrl>
			
			
		</description>
		<media>';
		
		
		$rows = explode(';',$event->items );
		
		foreach($rows as $r )
		{
			$st = explode(',', $r);
			$type = explode('=',$st[0]); 
			$url = substr($st[1],4, strlen($st[1])-4); // remove 'url='
		
		if($type[1]=='image')
			echo '<item type="img" url="'.$url.'" />';
	
		if($type[1]=='vidHttp')
			echo '<item type="vidHttp" url="'.$url.'" />';
		if($type[1]=='vidYoutube')
			echo '<item type="vidYoutube" url="'.$url.'" />';	
		}
		
		echo'</media>
		<type>'.$event->type.'</type>
		<priority>'.$event->priority.'</priority>
		
		 </eventFree>';
	}
		}
	
}
echo '</events>';
?>