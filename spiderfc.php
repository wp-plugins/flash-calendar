<?php
/*
Plugin Name: Spider Flash Calendar Free
Plugin URI: http://web-dorado.com/products/wordpress-events-calendar.html
Description: This product is a highly configurable Flash calendar plugin which allows you to have multiple organized events.
Version: 1.0.3
Author: http://web-dorado.com/
License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

/*LANGUAGE localization */
//// load languages
add_action( 'init', 'spiderfc_language_load' );
function spiderfc_language_load() {
	 load_plugin_textdomain('spiderfc', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

function Spider_FC_shotrcode($atts) {
     extract(shortcode_atts(array(
	      'id' => 'no Spider FC',
     ), $atts));
     return front_end($atts['id'] );
}
add_shortcode('spiderfc', 'Spider_FC_shotrcode');


function front_end($id)  
{
	?>
	<script>
    function disableMWheelForId(id) {
		
    var obj = document.getElementById(id);

    obj.onmousewheel = function(){ stopWheel(); } /* IE7, IE8 */
    if(obj.addEventListener){ /* Chrome, Safari, Firefox */
        obj.addEventListener('DOMMouseScroll', stopWheel, false);
    }
    function stopWheel(e){
        if(!e){ e = window.event; } /* IE7, IE8, Chrome, Safari */
        if(e.preventDefault) { e.preventDefault(); } /* Chrome, Safari, Firefox */
        e.returnValue = false; /* IE7, IE8 */
    }
   }
  
   </script>
   <script>
   function flashSetWidthHeight(width, height) {
		document.getElementById('flashContent').style.width = width + "px";
		document.getElementById('flashContent').style.height = height + "px";
		document.getElementById('flashContent').style.overflow = 'hidden';
   }

   </script>
	<?php	 
 global $post;
 $id_for_posts = $post->ID; 
global $wpdb;
$row_calendar= $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spiderfc_calendar WHERE id=".$id);
if(!$row_calendar)
{
return;
}


	   	     $row=$wpdb->get_var("SELECT paramsvalue FROM  ".$wpdb->prefix."spiderfc_theme WHERE theme_id='".$row_calendar->id_theme."' and paramsname='appMaxWidth' ");		  
		    $row1=$wpdb->get_var("SELECT paramsvalue FROM  ".$wpdb->prefix."spiderfc_theme WHERE theme_id='".$row_calendar->id_theme."' and paramsname='appMaxHeight' "); 
		  
		  
		  
		   $width= $row; 
		   $height= $row1; 
		  
		   
		  /* $row2=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spiderfc_theme WHERE id=".$id);
		var_dump($row2);*/
		  

		   
	
	
ob_start();		
	 	
		  
?>			   

	
	
		<div id="flashContent" style="width:<?php echo $width?>px; height:<?php echo $height?>px;">
			<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="<?php echo $width?>px" height="<?php echo $height?>px" id="spiderfcswfIE" align="middle">
				<param name="movie" value="<?php echo  plugins_url( '/' , __FILE__ );?>loader.swf" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
			<param  name="flashvars" value="settingsUrl=<?php echo plugins_url( '' , __FILE__ ).'/theme_xml.php?spiderid='.$id;?>&eventsListUrl=<?php echo plugins_url( '' , __FILE__ ).'/calendar_xml.php?spiderid='.$id;?>&langUrl=<?php echo plugins_url( '' , __FILE__ ).'/lang_xml.php?spiderid='.$id;?>&swfUrl=<?php echo plugins_url( '' , __FILE__ );?>/calendar.swf">
           
                
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="<?php echo  plugins_url( '/' , __FILE__ );?>/loader.swf" width="<?php echo $width?>px" height="<?php echo $height ?>px" id="spiderfcswf">
					<param name="movie" value="<?php echo plugins_url( '/' , __FILE__ );?>loader.swf" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
					<param name="flashvars" id="spiderfcswf" value="settingsUrl=<?php echo plugins_url('' , __FILE__ ).'/theme_xml.php?spiderid='.$id;?>&eventsListUrl=<?php echo plugins_url('' , __FILE__ ).'/calendar_xml.php?spiderid='.$id;?>&langUrl=<?php echo plugins_url( '' , __FILE__ ).'/lang_xml.php?spiderid='.$id;?>&swfUrl=<?php echo plugins_url( '' , __FILE__ );?>/calendar.swf">
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>
		</div>
	<script>disableMWheelForId('spiderfcswf');</script>
		   <?php


	$content=ob_get_contents();
                ob_end_clean();
				return $content;
				
				
}



//// add front end

//// add editor new mce button
add_filter('mce_external_plugins', "SpiderFC_register");
add_filter('mce_buttons', 'SpiderFC_add_button', 0);

/// function for add new button
function SpiderFC_add_button($buttons)
{
    array_push($buttons, "SpirderFC_mce");
    return $buttons;
}
 /// function for registr new button
function SpiderFC_register($plugin_array)
{
    $url = plugins_url( 'js/editor_plugin.js' , __FILE__ ); 
    $plugin_array["SpiderFC_mce"] = $url;
    return $plugin_array;
}
///// when activated plugin
function SpiderFC_activate()
{	
	global $wpdb;	
	$sql = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."spiderfc_events ( 
												id INT(11) NOT NULL AUTO_INCREMENT,
												id_calendar INT(11) NOT NULL,
												date_begin DATE NOT NULL,
												date_end DATE NOT NULL,
												event_time_begin varchar(255) NOT NULL,
												event_time_end varchar(255) NOT NULL,
												title VARCHAR(255) NOT NULL,
												text LONGTEXT NOT NULL,
												html LONGTEXT NOT NULL,
												css TEXT NOT NULL,
												htmlUrl VARCHAR(255) NOT NULL,												
												type VARCHAR(255) NOT NULL,
												priority VARCHAR(255) NOT NULL,
												event_type VARCHAR(255) NOT NULL,
												items TEXT NOT NULL,
												published TINYINT(1) NOT NULL default '0',
												PRIMARY KEY (id) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	$wpdb->query($sql);	
	$sql1 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."spiderfc_calendar (
															  id INT(11) NOT NULL AUTO_INCREMENT,
															  title VARCHAR(200) NOT NULL,
															  id_theme INT(11) NOT NULL,
															  published INT(11) NOT NULL,
															  PRIMARY KEY (id)
															)ENGINE=MyISAM  DEFAULT CHARSET=utf8";
	$wpdb->query($sql1);
	
	$sql2 = "CREATE TABLE IF NOT EXISTS ".$wpdb->prefix."spiderfc_theme (
		id INT(11) NOT NULL AUTO_INCREMENT,
		title VARCHAR(200) NOT NULL, 
		paramsname VARCHAR(255) NOT NULL,
		paramsdescrip TEXT NOT NULL,  
		paramsvalue VARCHAR(200) NOT NULL,
		theme_default INT(2) NOT NULL default '0', 
		theme_id INT(11) NOT NULL default '0',
		PRIMARY KEY (id) ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
		$wpdb->query($sql2);

$sql_insert = "INSERT INTO ".$wpdb->prefix."spiderfc_theme(title,paramsname,paramsdescrip, paramsvalue, theme_default, theme_id) 
					VALUES
( 'Simple blue', 'startWithMonday', '', '1', 1, 1),
( 'Simple blue', 'dateFormat', '', '%m-%d-%y %t', 1, 1),
( 'Simple blue', 'dateFormatShort', '', '%t', 1, 1),
( 'Simple blue', 'time', '', '0', 1, 1),
( 'Simple blue', 'appMaxWidth', '', '600', 1, 1),
( 'Simple blue', 'appMaxHeight', '', '550', 1, 1),
( 'Simple blue', 'appMinWidth', '', '360', 1, 1),
( 'Simple blue', 'appMinHeight', '', '420', 1, 1),
( 'Simple blue', 'startViewSize', '', 'viewSizeMax', 1, 1),
( 'Simple blue', 'startViewState', '', 'viewStateDays', 1, 1),
( 'Simple blue', 'bgColors', '', 'FFFFFF FFFFFF', 1, 1),
( 'Simple blue', 'bgCornerRadius', '', '15', 1, 1),
( 'Simple blue', 'strokeColor', '', '808080', 1, 1),
( 'Simple blue', 'headerHeight', '', '100', 1, 1),
( 'Simple blue', 'headerPadding', '', '20', 1, 1),
( 'Simple blue', 'headerBgColors', '', 'AADCFF 9ECFF2', 1, 1),
( 'Simple blue', 'headerBgStrokeColor', '', '203540', 1, 1),
( 'Simple blue', 'headerContentColor', '', '', 1, 1),
( 'Simple blue', 'headerContentStrokeColor', '', '404040', 1, 1),
( 'Simple blue', 'headerFontSize', '', '40', 1, 1),
( 'Simple blue', 'daysNamesColor', '', '808080', 1, 1),
( 'Simple blue', 'daysNamesFontSize', '', '24', 1, 1),
( 'Simple blue', 'datesBgColors', '', 'F3F3F3 E6E6E6', 1, 1),
( 'Simple blue', 'priority0Color', '', '55FF00', 1, 1),
( 'Simple blue', 'priority1Color', '', '55FF00', 1, 1),
( 'Simple blue', 'priority2Color', '', 'FFD400', 1, 1),
( 'Simple blue', 'priority3Color', '', 'FF0000', 1, 1),
( 'Simple blue', 'dateFontSize', '', '40', 1, 1),
( 'Simple blue', 'dateColor', '', '404040', 1, 1),
( 'Simple blue', 'dateStrokeColor', '', '404040', 1, 1),
( 'Simple blue', 'showDateEventsCount', '', '1', 1, 1),
( 'Simple blue', 'dateEventsCountFontSize', '', '12', 1, 1),
( 'Simple blue', 'dateEventsCountColor', '', '606060', 1, 1),
( 'Simple blue', 'eventsListHeaderHeight', '', '50', 1, 1),
( 'Simple blue', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 1, 1),
( 'Simple blue', 'eventsListHeaderColor', '', '404040', 1, 1),
( 'Simple blue', 'eventsListHeaderFontSize', '', '20', 1, 1),
( 'Simple blue', 'eventHeaderHeight', '', '40', 1, 1),
( 'Simple blue', 'eventHeaderFontSize', '', '20', 1, 1),
( 'Simple blue', 'eventHeaderColor', '', '000000', 1, 1),
( 'Simple blue', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 1, 1),
( 'Simple blue', 'eventContentDatesFontSize', '', '18', 1, 1),
( 'Simple blue', 'eventContentDatesColor', '', '808080', 1, 1),
( 'Simple blue', 'eventContentDescriptionFontSize', '', '16', 1, 1),
( 'Simple blue', 'eventContentDescriptionColor', '', '404040', 1, 1),
( 'Simple blue', 'footerHeight', '', '30', 1, 1),
( 'Simple blue', 'footerColor', '', '808080', 1, 1),
( 'Simple blue', 'mediaDefaultAutoplay', '', '1', 1, 1),
( 'Simple blue', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 1, 1),
( 'Simple blue', 'mediaShowDuration', '', '5', 1, 1),
( 'Simple blue', 'videoDefaultVolume', '', '80', 1, 1),
( 'Simple blue', 'videoAutoplay', '', '0', 1, 1),
( 'Simple blue', 'mediaBgColor', '', '000000', 1, 1),
( 'Simple blue', 'mediaCtrlsBgColor', '', '363D40', 1, 1),
( 'Simple blue', 'mediaCtrlsBgAlpha', '', '80', 1, 1),
( 'Simple blue', 'mediaCtrlsColor', '', 'D3DADE', 1, 1),
( 'Simple blue', 'mediaCtrlsAlpha', '', '100', 1, 1),

('Black', 'startWithMonday', '', '1', 0, 2),
('Black', 'dateFormat', '', '%m-%d-%y %t', 0, 2),
('Black', 'dateFormatShort', '', '%t', 0, 2),
('Black', 'time', '', '0', 0, 2),
('Black', 'appMaxWidth', '', '600', 0, 2),
('Black', 'appMaxHeight', '', '550', 0, 2),
('Black', 'appMinWidth', '', '360', 0, 2),
('Black', 'appMinHeight', '', '420', 0, 2),
('Black', 'startViewSize', '', 'viewSizeMax', 0, 2),
('Black', 'startViewState', '', 'viewStateDays', 0, 2),
('Black', 'bgColors', '', '0A0A0A 101010', 0, 2),
('Black', 'bgCornerRadius', '', '12', 0, 2),
('Black', 'strokeColor', '', '08BDF4', 0, 2),
('Black', 'headerHeight', '', '100', 0, 2),
('Black', 'headerPadding', '', '14', 0, 2),
('Black', 'headerBgColors', '', '0A0A0A 101010', 0, 2),
('Black', 'headerBgStrokeColor', '', '08BDF4', 0, 2),
('Black', 'headerContentColor', '', 'FFFFFF', 0, 2),
('Black', 'headerContentStrokeColor', '', '404040', 0, 2),
('Black', 'headerFontSize', '', '40', 0, 2),
('Black', 'daysNamesColor', '', 'C7C7C7', 0, 2),
('Black', 'daysNamesFontSize', '', '20', 0, 2),
('Black', 'datesBgColors', '', '050507 050507', 0, 2),
('Black', 'priority0Color', '', 'A9FF9C', 0, 2),
('Black', 'priority1Color', '', '61FF7B', 0, 2),
('Black', 'priority2Color', '', '0A0A0A', 0, 2),
('Black', 'priority3Color', '', 'FF0000', 0, 2),
('Black', 'dateFontSize', '', '40', 0, 2),
('Black', 'dateColor', '', 'A6A6A6', 0, 2),
('Black', 'dateStrokeColor', '', 'D90000', 0, 2),
('Black', 'showDateEventsCount', '', '1', 0, 2),
('Black', 'dateEventsCountFontSize', '', '12', 0, 2),
('Black', 'dateEventsCountColor', '', '08BDF4', 0, 2),
('Black', 'eventsListHeaderHeight', '', '50', 0, 2),
('Black', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 2),
('Black', 'eventsListHeaderColor', '', '404040', 0, 2),
('Black', 'eventsListHeaderFontSize', '', '20', 0, 2),
('Black', 'eventHeaderHeight', '', '40', 0, 2),
('Black', 'eventHeaderFontSize', '', '20', 0, 2),
('Black', 'eventHeaderColor', '', 'FFFFFF', 0, 2),
('Black', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 2),
('Black', 'eventContentDatesFontSize', '', '18', 0, 2),
('Black', 'eventContentDatesColor', '', '808080', 0, 2),
('Black', 'eventContentDescriptionFontSize', '', '16', 0, 2),
('Black', 'eventContentDescriptionColor', '', '404040', 0, 2),
('Black', 'footerHeight', '', '30', 0, 2),
('Black', 'footerColor', '', 'FCFCFC', 0, 2),
('Black', 'mediaDefaultAutoplay', '', '1', 0, 2),
('Black', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 2),
('Black', 'mediaShowDuration', '', '5', 0, 2),
('Black', 'videoDefaultVolume', '', '80', 0, 2),
('Black', 'videoAutoplay', '', '0', 0, 2),
('Black', 'mediaBgColor', '', '000000', 0, 2),
('Black', 'mediaCtrlsBgColor', '', '363D40', 0, 2),
('Black', 'mediaCtrlsBgAlpha', '', '80', 0, 2),
('Black', 'mediaCtrlsColor', '', 'D3DADE', 0, 2),
('Black', 'mediaCtrlsAlpha', '', '100', 0, 2),

( 'Simple grey ', 'startWithMonday', '', '1', 0, 3),
( 'Simple grey ', 'dateFormat', '', '%m-%d-%y %t', 0, 3),
( 'Simple grey ', 'dateFormatShort', '', '%t', 0, 3),
( 'Simple grey ', 'time', '', '1', 0, 3),
( 'Simple grey ', 'appMaxWidth', '', '600', 0, 3),
( 'Simple grey ', 'appMaxHeight', '', '550', 0, 3),
( 'Simple grey ', 'appMinWidth', '', '340', 0, 3),
( 'Simple grey ', 'appMinHeight', '', '400', 0, 3),
( 'Simple grey ', 'startViewSize', '', 'viewSizeMax', 0, 3),
( 'Simple grey ', 'startViewState', '', 'viewStateDays', 0, 3),
( 'Simple grey ', 'bgColors', '', '2D2D2D 222222', 0, 3),
( 'Simple grey ', 'bgCornerRadius', '', '0', 0, 3),
( 'Simple grey ', 'strokeColor', '', '000000', 0, 3),
( 'Simple grey ', 'headerHeight', '', '100', 0, 3),
( 'Simple grey ', 'headerPadding', '', '2', 0, 3),
( 'Simple grey ', 'headerBgColors', '', '2D2D2D 222222', 0, 3),
( 'Simple grey ', 'headerBgStrokeColor', '', '203540', 0, 3),
( 'Simple grey ', 'headerContentColor', '', 'FFFFFF', 0, 3),
( 'Simple grey ', 'headerContentStrokeColor', '', '404040', 0, 3),
( 'Simple grey ', 'headerFontSize', '', '40', 0, 3),
( 'Simple grey ', 'daysNamesColor', '', 'FFFFFF', 0, 3),
( 'Simple grey ', 'daysNamesFontSize', '', '20', 0, 3),
( 'Simple grey ', 'datesBgColors', '', 'E1E1E1 F5F5F5', 0, 3),
( 'Simple grey ', 'priority0Color', '', '55FF00', 0, 3),
( 'Simple grey ', 'priority1Color', '', '55FF00', 0, 3),
( 'Simple grey ', 'priority2Color', '', 'FFD400', 0, 3),
( 'Simple grey ', 'priority3Color', '', 'FF0000', 0, 3),
( 'Simple grey ', 'dateFontSize', '', '40', 0, 3),
( 'Simple grey ', 'dateColor', '', '404040', 0, 3),
( 'Simple grey ', 'dateStrokeColor', '', '404040', 0, 3),
( 'Simple grey ', 'showDateEventsCount', '', '1', 0, 3),
( 'Simple grey ', 'dateEventsCountFontSize', '', '12', 0, 3),
( 'Simple grey ', 'dateEventsCountColor', '', '606060', 0, 3),
( 'Simple grey ', 'eventsListHeaderHeight', '', '50', 0, 3),
( 'Simple grey ', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 3),
( 'Simple grey ', 'eventsListHeaderColor', '', '404040', 0, 3),
( 'Simple grey ', 'eventsListHeaderFontSize', '', '20', 0, 3),
( 'Simple grey ', 'eventHeaderHeight', '', '40', 0, 3),
( 'Simple grey ', 'eventHeaderFontSize', '', '20', 0, 3),
( 'Simple grey ', 'eventHeaderColor', '', '000000', 0, 3),
( 'Simple grey ', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 3),
( 'Simple grey ', 'eventContentDatesFontSize', '', '18', 0, 3),
( 'Simple grey ', 'eventContentDatesColor', '', '808080', 0, 3),
( 'Simple grey ', 'eventContentDescriptionFontSize', '', '16', 0, 3),
( 'Simple grey ', 'eventContentDescriptionColor', '', '404040', 0, 3),
( 'Simple grey ', 'footerHeight', '', '30', 0, 3),
( 'Simple grey ', 'footerColor', '', '808080', 0, 3),
( 'Simple grey ', 'mediaDefaultAutoplay', '', '1', 0, 3),
( 'Simple grey ', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 3),
( 'Simple grey ', 'mediaShowDuration', '', '5', 0, 3),
( 'Simple grey ', 'videoDefaultVolume', '', '80', 0, 3),
( 'Simple grey ', 'videoAutoplay', '', '0', 0, 3),
( 'Simple grey ', 'mediaBgColor', '', '000000', 0, 3),
( 'Simple grey ', 'mediaCtrlsBgColor', '', '363D40', 0, 3),
( 'Simple grey ', 'mediaCtrlsBgAlpha', '', '80', 0, 3),
( 'Simple grey ', 'mediaCtrlsColor', '', 'D3DADE', 0, 3),
( 'Simple grey ', 'mediaCtrlsAlpha', '', '100', 0, 3),

( 'Light brown', 'startWithMonday', '', '1', 0, 4),
( 'Light brown', 'dateFormat', '', '%m-%d-%y %t', 0, 4),
( 'Light brown', 'dateFormatShort', '', '%t', 0, 4),
( 'Light brown', 'time', '', '0', 0, 4),
( 'Light brown', 'appMaxWidth', '', '600', 0, 4),
( 'Light brown', 'appMaxHeight', '', '550', 0, 4),
( 'Light brown', 'appMinWidth', '', '360', 0, 4),
( 'Light brown', 'appMinHeight', '', '420', 0, 4),
( 'Light brown', 'startViewSize', '', 'viewSizeMax', 0, 4),
( 'Light brown', 'startViewState', '', 'viewStateDays', 0, 4),
( 'Light brown', 'bgColors', '', '523F30 8F6E54', 0, 4),
( 'Light brown', 'bgCornerRadius', '', '15', 0, 4),
( 'Light brown', 'strokeColor', '', '808080', 0, 4),
( 'Light brown', 'headerHeight', '', '100', 0, 4),
( 'Light brown', 'headerPadding', '', '20', 0, 4),
( 'Light brown', 'headerBgColors', '', 'BE7530 E7C892', 0, 4),
( 'Light brown', 'headerBgStrokeColor', '', '203540', 0, 4),
( 'Light brown', 'headerContentColor', '', 'FFFFFF', 0, 4),
( 'Light brown', 'headerContentStrokeColor', '', '404040', 0, 4),
( 'Light brown', 'headerFontSize', '', '40', 0, 4),
( 'Light brown', 'daysNamesColor', '', 'FFFFFF', 0, 4),
( 'Light brown', 'daysNamesFontSize', '', '20', 0, 4),
( 'Light brown', 'datesBgColors', '', '7E5F43 BD8E64', 0, 4),
( 'Light brown', 'priority0Color', '', '55FF00', 0, 4),
( 'Light brown', 'priority1Color', '', '55FF00', 0, 4),
( 'Light brown', 'priority2Color', '', 'FFD400', 0, 4),
( 'Light brown', 'priority3Color', '', 'FF0000', 0, 4),
( 'Light brown', 'dateFontSize', '', '40', 0, 4),
( 'Light brown', 'dateColor', '', 'EBEBEB', 0, 4),
( 'Light brown', 'dateStrokeColor', '', 'E7C892', 0, 4),
( 'Light brown', 'showDateEventsCount', '', '1', 0, 4),
( 'Light brown', 'dateEventsCountFontSize', '', '12', 0, 4),
( 'Light brown', 'dateEventsCountColor', '', '606060', 0, 4),
( 'Light brown', 'eventsListHeaderHeight', '', '50', 0, 4),
( 'Light brown', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 4),
( 'Light brown', 'eventsListHeaderColor', '', '404040', 0, 4),
( 'Light brown', 'eventsListHeaderFontSize', '', '20', 0, 4),
( 'Light brown', 'eventHeaderHeight', '', '40', 0, 4),
( 'Light brown', 'eventHeaderFontSize', '', '20', 0, 4),
( 'Light brown', 'eventHeaderColor', '', '000000', 0, 4),
( 'Light brown', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 4),
( 'Light brown', 'eventContentDatesFontSize', '', '18', 0, 4),
( 'Light brown', 'eventContentDatesColor', '', '808080', 0, 4),
( 'Light brown', 'eventContentDescriptionFontSize', '', '16', 0, 4),
( 'Light brown', 'eventContentDescriptionColor', '', '404040', 0, 4),
( 'Light brown', 'footerHeight', '', '30', 0, 4),
( 'Light brown', 'footerColor', '', '808080', 0, 4),
( 'Light brown', 'mediaDefaultAutoplay', '', '1', 0, 4),
( 'Light brown', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 4),
( 'Light brown', 'mediaShowDuration', '', '5', 0, 4),
( 'Light brown', 'videoDefaultVolume', '', '80', 0, 4),
( 'Light brown', 'videoAutoplay', '', '0', 0, 4),
( 'Light brown', 'mediaBgColor', '', '000000', 0, 4),
( 'Light brown', 'mediaCtrlsBgColor', '', '363D40', 0, 4),
( 'Light brown', 'mediaCtrlsBgAlpha', '', '80', 0, 4),
( 'Light brown', 'mediaCtrlsColor', '', 'D3DADE', 0, 4),
( 'Light brown', 'mediaCtrlsAlpha', '', '100', 0, 4),

( 'Red blur', 'startWithMonday', '', '1', 0, 5),
( 'Red blur', 'dateFormat', '', '%m-%d-%y %t', 0, 5),
( 'Red blur', 'dateFormatShort', '', '%t', 0, 5),
( 'Red blur', 'time', '', '0', 0, 5),
( 'Red blur', 'appMaxWidth', '', '600', 0, 5),
( 'Red blur', 'appMaxHeight', '', '550', 0, 5),
( 'Red blur', 'appMinWidth', '', '360', 0, 5),
( 'Red blur', 'appMinHeight', '', '420', 0, 5),
( 'Red blur', 'startViewSize', '', 'viewSizeMax', 0, 5),
( 'Red blur', 'startViewState', '', 'viewStateDays', 0, 5),
( 'Red blur', 'bgColors', '', 'FFFFCD C7C7A0', 0, 5),
( 'Red blur', 'bgCornerRadius', '', '6', 0, 5),
( 'Red blur', 'strokeColor', '', '000000', 0, 5),
( 'Red blur', 'headerHeight', '', '100', 0, 5),
( 'Red blur', 'headerPadding', '', '12', 0, 5),
( 'Red blur', 'headerBgColors', '', '9A0000 B50000', 0, 5),
( 'Red blur', 'headerBgStrokeColor', '', '203540', 0, 5),
( 'Red blur', 'headerContentColor', '', 'FFFFFF', 0, 5),
( 'Red blur', 'headerContentStrokeColor', '', '404040', 0, 5),
( 'Red blur', 'headerFontSize', '', '36', 0, 5),
( 'Red blur', 'daysNamesColor', '', '000000', 0, 5),
( 'Red blur', 'daysNamesFontSize', '', '22', 0, 5),
( 'Red blur', 'datesBgColors', '', 'CECB96 DEDBA2', 0, 5),
( 'Red blur', 'priority0Color', '', '55FF00', 0, 5),
( 'Red blur', 'priority1Color', '', '55FF00', 0, 5),
( 'Red blur', 'priority2Color', '', 'FFD400', 0, 5),
( 'Red blur', 'priority3Color', '', 'FF0000', 0, 5),
( 'Red blur', 'dateFontSize', '', '33', 0, 5),
( 'Red blur', 'dateColor', '', '000000', 0, 5),
( 'Red blur', 'dateStrokeColor', '', '9A0000', 0, 5),
( 'Red blur', 'showDateEventsCount', '', '1', 0, 5),
( 'Red blur', 'dateEventsCountFontSize', '', '12', 0, 5),
( 'Red blur', 'dateEventsCountColor', '', '606060', 0, 5),
( 'Red blur', 'eventsListHeaderHeight', '', '50', 0, 5),
( 'Red blur', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 5),
( 'Red blur', 'eventsListHeaderColor', '', '404040', 0, 5),
( 'Red blur', 'eventsListHeaderFontSize', '', '20', 0, 5),
( 'Red blur', 'eventHeaderHeight', '', '40', 0, 5),
( 'Red blur', 'eventHeaderFontSize', '', '20', 0, 5),
( 'Red blur', 'eventHeaderColor', '', '000000', 0, 5),
( 'Red blur', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 5),
( 'Red blur', 'eventContentDatesFontSize', '', '18', 0, 5),
( 'Red blur', 'eventContentDatesColor', '', '808080', 0, 5),
( 'Red blur', 'eventContentDescriptionFontSize', '', '16', 0, 5),
( 'Red blur', 'eventContentDescriptionColor', '', '404040', 0, 5),
( 'Red blur', 'footerHeight', '', '30', 0, 5),
( 'Red blur', 'footerColor', '', '3D3D3D', 0, 5),
( 'Red blur', 'mediaDefaultAutoplay', '', '1', 0, 5),
( 'Red blur', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 5),
( 'Red blur', 'mediaShowDuration', '', '5', 0, 5),
( 'Red blur', 'videoDefaultVolume', '', '80', 0, 5),
( 'Red blur', 'videoAutoplay', '', '0', 0, 5),
( 'Red blur', 'mediaBgColor', '', '000000', 0, 5),
( 'Red blur', 'mediaCtrlsBgColor', '', '363D40', 0, 5),
( 'Red blur', 'mediaCtrlsBgAlpha', '', '80', 0, 5),
( 'Red blur', 'mediaCtrlsColor', '', 'D3DADE', 0, 5),
( 'Red blur', 'mediaCtrlsAlpha', '', '100', 0, 5),

( 'Dodger Blue', 'startWithMonday', '', '1', 0, 6),
( 'Dodger Blue', 'dateFormat', '', '%m-%d-%y %t', 0, 6),
( 'Dodger Blue', 'dateFormatShort', '', '%t', 0, 6),
( 'Dodger Blue', 'time', '', '0', 0, 6),
( 'Dodger Blue', 'appMaxWidth', '', '600', 0, 6),
( 'Dodger Blue', 'appMaxHeight', '', '550', 0, 6),
( 'Dodger Blue', 'appMinWidth', '', '360', 0, 6),
( 'Dodger Blue', 'appMinHeight', '', '420', 0, 6),
( 'Dodger Blue', 'startViewSize', '', 'viewSizeMax', 0, 6),
( 'Dodger Blue', 'startViewState', '', 'viewStateDays', 0, 6),
( 'Dodger Blue', 'bgColors', '', 'EDEDED 4196E9', 0, 6),
( 'Dodger Blue', 'bgCornerRadius', '', '6', 0, 6),
( 'Dodger Blue', 'strokeColor', '', '000000', 0, 6),
( 'Dodger Blue', 'headerHeight', '', '100', 0, 6),
( 'Dodger Blue', 'headerPadding', '', '20', 0, 6),
( 'Dodger Blue', 'headerBgColors', '', '4196E9 6782AD', 0, 6),
( 'Dodger Blue', 'headerBgStrokeColor', '', '203540', 0, 6),
( 'Dodger Blue', 'headerContentColor', '', 'FFFFFF', 0, 6),
( 'Dodger Blue', 'headerContentStrokeColor', '', '404040', 0, 6),
( 'Dodger Blue', 'headerFontSize', '', '40', 0, 6),
( 'Dodger Blue', 'daysNamesColor', '', '000000', 0, 6),
( 'Dodger Blue', 'daysNamesFontSize', '', '24', 0, 6),
( 'Dodger Blue', 'datesBgColors', '', 'E2EDF7 C6D0D9', 0, 6),
( 'Dodger Blue', 'priority0Color', '', '55FF00', 0, 6),
( 'Dodger Blue', 'priority1Color', '', '55FF00', 0, 6),
( 'Dodger Blue', 'priority2Color', '', 'FFD400', 0, 6),
( 'Dodger Blue', 'priority3Color', '', '3E90E0', 0, 6),
( 'Dodger Blue', 'dateFontSize', '', '40', 0, 6),
( 'Dodger Blue', 'dateColor', '', '050505', 0, 6),
( 'Dodger Blue', 'dateStrokeColor', '', '050505', 0, 6),
( 'Dodger Blue', 'showDateEventsCount', '', '1', 0, 6),
( 'Dodger Blue', 'dateEventsCountFontSize', '', '12', 0, 6),
( 'Dodger Blue', 'dateEventsCountColor', '', 'FFFFFF', 0, 6),
( 'Dodger Blue', 'eventsListHeaderHeight', '', '50', 0, 6),
( 'Dodger Blue', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 6),
( 'Dodger Blue', 'eventsListHeaderColor', '', '404040', 0, 6),
( 'Dodger Blue', 'eventsListHeaderFontSize', '', '20', 0, 6),
( 'Dodger Blue', 'eventHeaderHeight', '', '40', 0, 6),
( 'Dodger Blue', 'eventHeaderFontSize', '', '20', 0, 6),
( 'Dodger Blue', 'eventHeaderColor', '', '000000', 0, 6),
( 'Dodger Blue', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 6),
( 'Dodger Blue', 'eventContentDatesFontSize', '', '18', 0, 6),
( 'Dodger Blue', 'eventContentDatesColor', '', '808080', 0, 6),
( 'Dodger Blue', 'eventContentDescriptionFontSize', '', '16', 0, 6),
( 'Dodger Blue', 'eventContentDescriptionColor', '', '404040', 0, 6),
( 'Dodger Blue', 'footerHeight', '', '30', 0, 6),
( 'Dodger Blue', 'footerColor', '', 'D6D6D6', 0, 6),
( 'Dodger Blue', 'mediaDefaultAutoplay', '', '1', 0, 6),
( 'Dodger Blue', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 6),
( 'Dodger Blue', 'mediaShowDuration', '', '5', 0, 6),
( 'Dodger Blue', 'videoDefaultVolume', '', '80', 0, 6),
( 'Dodger Blue', 'videoAutoplay', '', '0', 0, 6),
( 'Dodger Blue', 'mediaBgColor', '', '000000', 0, 6),
( 'Dodger Blue', 'mediaCtrlsBgColor', '', '363D40', 0, 6),
( 'Dodger Blue', 'mediaCtrlsBgAlpha', '', '80', 0, 6),
( 'Dodger Blue', 'mediaCtrlsColor', '', 'D3DADE', 0, 6),
( 'Dodger Blue', 'mediaCtrlsAlpha', '', '100', 0, 6),

( 'Indian Red', 'startWithMonday', '', '1', 0, 7),
( 'Indian Red', 'dateFormat', '', '%m-%d-%y %t', 0, 7),
( 'Indian Red', 'dateFormatShort', '', '%t', 0, 7),
( 'Indian Red', 'time', '', '1', 0, 7),
( 'Indian Red', 'appMaxWidth', '', '600', 0, 7),
( 'Indian Red', 'appMaxHeight', '', '550', 0, 7),
( 'Indian Red', 'appMinWidth', '', '360', 0, 7),
( 'Indian Red', 'appMinHeight', '', '420', 0, 7),
( 'Indian Red', 'startViewSize', '', 'viewSizeMax', 0, 7),
( 'Indian Red', 'startViewState', '', 'viewStateDays', 0, 7),
( 'Indian Red', 'bgColors', '', 'FFEFA3 5D2117', 0, 7),
( 'Indian Red', 'bgCornerRadius', '', '6', 0, 7),
( 'Indian Red', 'strokeColor', '', '808080', 0, 7),
( 'Indian Red', 'headerHeight', '', '100', 0, 7),
( 'Indian Red', 'headerPadding', '', '2', 0, 7),
( 'Indian Red', 'headerBgColors', '', '7E3F30 9C4E3B', 0, 7),
( 'Indian Red', 'headerBgStrokeColor', '', '203540', 0, 7),
( 'Indian Red', 'headerContentColor', '', 'FFFFFF', 0, 7),
( 'Indian Red', 'headerContentStrokeColor', '', '404040', 0, 7),
( 'Indian Red', 'headerFontSize', '', '40', 0, 7),
( 'Indian Red', 'daysNamesColor', '', '000000', 0, 7),
( 'Indian Red', 'daysNamesFontSize', '', '20', 0, 7),
( 'Indian Red', 'datesBgColors', '', '7E3F30 7E3F30', 0, 7),
( 'Indian Red', 'priority0Color', '', 'FFFFFF', 0, 7),
( 'Indian Red', 'priority1Color', '', 'FFE8B9', 0, 7),
( 'Indian Red', 'priority2Color', '', 'FFD400', 0, 7),
( 'Indian Red', 'priority3Color', '', 'FF0000', 0, 7),
( 'Indian Red', 'dateFontSize', '', '40', 0, 7),
( 'Indian Red', 'dateColor', '', 'FBEDBE', 0, 7),
( 'Indian Red', 'dateStrokeColor', '', '404040', 0, 7),
( 'Indian Red', 'showDateEventsCount', '', '1', 0, 7),
( 'Indian Red', 'dateEventsCountFontSize', '', '12', 0, 7),
( 'Indian Red', 'dateEventsCountColor', '', '606060', 0, 7),
( 'Indian Red', 'eventsListHeaderHeight', '', '50', 0, 7),
( 'Indian Red', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 7),
( 'Indian Red', 'eventsListHeaderColor', '', '404040', 0, 7),
( 'Indian Red', 'eventsListHeaderFontSize', '', '20', 0, 7),
( 'Indian Red', 'eventHeaderHeight', '', '40', 0, 7),
( 'Indian Red', 'eventHeaderFontSize', '', '20', 0, 7),
( 'Indian Red', 'eventHeaderColor', '', '000000', 0, 7),
( 'Indian Red', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 7),
( 'Indian Red', 'eventContentDatesFontSize', '', '18', 0, 7),
( 'Indian Red', 'eventContentDatesColor', '', '808080', 0, 7),
( 'Indian Red', 'eventContentDescriptionFontSize', '', '16', 0, 7),
( 'Indian Red', 'eventContentDescriptionColor', '', '404040', 0, 7),
( 'Indian Red', 'footerHeight', '', '30', 0, 7),
( 'Indian Red', 'footerColor', '', '808080', 0, 7),
( 'Indian Red', 'mediaDefaultAutoplay', '', '1', 0, 7),
( 'Indian Red', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 7),
( 'Indian Red', 'mediaShowDuration', '', '5', 0, 7),
( 'Indian Red', 'videoDefaultVolume', '', '80', 0, 7),
( 'Indian Red', 'videoAutoplay', '', '0', 0, 7),
( 'Indian Red', 'mediaBgColor', '', '000000', 0, 7),
( 'Indian Red', 'mediaCtrlsBgColor', '', '363D40', 0, 7),
( 'Indian Red', 'mediaCtrlsBgAlpha', '', '80', 0, 7),
( 'Indian Red', 'mediaCtrlsColor', '', 'D3DADE', 0, 7),
( 'Indian Red', 'mediaCtrlsAlpha', '', '100', 0, 7),

( 'Sky blue', 'startWithMonday', '', '1', 0, 8),
( 'Sky blue', 'dateFormat', '', '%m-%d-%y %t', 0, 8),
( 'Sky blue', 'dateFormatShort', '', '%t', 0, 8),
( 'Sky blue', 'time', '', '0', 0, 8),
( 'Sky blue', 'appMaxWidth', '', '600', 0, 8),
( 'Sky blue', 'appMaxHeight', '', '550', 0, 8),
( 'Sky blue', 'appMinWidth', '', '360', 0, 8),
( 'Sky blue', 'appMinHeight', '', '420', 0, 8),
( 'Sky blue', 'startViewSize', '', 'viewSizeMax', 0, 8),
( 'Sky blue', 'startViewState', '', 'viewStateDays', 0, 8),
( 'Sky blue', 'bgColors', '', 'FFFFFF FFFFFF', 0, 8),
( 'Sky blue', 'bgCornerRadius', '', '8', 0, 8),
( 'Sky blue', 'strokeColor', '', '808080', 0, 8),
( 'Sky blue', 'headerHeight', '', '100', 0, 8),
( 'Sky blue', 'headerPadding', '', '0', 0, 8),
( 'Sky blue', 'headerBgColors', '', '37BEFE 37BEFE', 0, 8),
( 'Sky blue', 'headerBgStrokeColor', '', '203540', 0, 8),
( 'Sky blue', 'headerContentColor', '', 'FFFFFF', 0, 8),
( 'Sky blue', 'headerContentStrokeColor', '', '404040', 0, 8),
( 'Sky blue', 'headerFontSize', '', '40', 0, 8),
( 'Sky blue', 'daysNamesColor', '', '17506B', 0, 8),
( 'Sky blue', 'daysNamesFontSize', '', '20', 0, 8),
( 'Sky blue', 'datesBgColors', '', 'FFFFFF FFFFFF', 0, 8),
( 'Sky blue', 'priority0Color', '', '55FF00', 0, 8),
( 'Sky blue', 'priority1Color', '', '55FF00', 0, 8),
( 'Sky blue', 'priority2Color', '', 'FFF700', 0, 8),
( 'Sky blue', 'priority3Color', '', 'FF0000', 0, 8),
( 'Sky blue', 'dateFontSize', '', '33', 0, 8),
( 'Sky blue', 'dateColor', '', '404040', 0, 8),
( 'Sky blue', 'dateStrokeColor', '', '404040', 0, 8),
( 'Sky blue', 'showDateEventsCount', '', '1', 0, 8),
( 'Sky blue', 'dateEventsCountFontSize', '', '12', 0, 8),
( 'Sky blue', 'dateEventsCountColor', '', '606060', 0, 8),
( 'Sky blue', 'eventsListHeaderHeight', '', '50', 0, 8),
( 'Sky blue', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 8),
( 'Sky blue', 'eventsListHeaderColor', '', '404040', 0, 8),
( 'Sky blue', 'eventsListHeaderFontSize', '', '20', 0, 8),
( 'Sky blue', 'eventHeaderHeight', '', '40', 0, 8),
( 'Sky blue', 'eventHeaderFontSize', '', '20', 0, 8),
( 'Sky blue', 'eventHeaderColor', '', '000000', 0, 8),
( 'Sky blue', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 8),
( 'Sky blue', 'eventContentDatesFontSize', '', '18', 0, 8),
( 'Sky blue', 'eventContentDatesColor', '', '808080', 0, 8),
( 'Sky blue', 'eventContentDescriptionFontSize', '', '16', 0, 8),
( 'Sky blue', 'eventContentDescriptionColor', '', '404040', 0, 8),
( 'Sky blue', 'footerHeight', '', '30', 0, 8),
( 'Sky blue', 'footerColor', '', '2FA4DB', 0, 8),
( 'Sky blue', 'mediaDefaultAutoplay', '', '1', 0, 8),
( 'Sky blue', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 8),
( 'Sky blue', 'mediaShowDuration', '', '5', 0, 8),
( 'Sky blue', 'videoDefaultVolume', '', '80', 0, 8),
( 'Sky blue', 'videoAutoplay', '', '0', 0, 8),
( 'Sky blue', 'mediaBgColor', '', '000000', 0, 8),
( 'Sky blue', 'mediaCtrlsBgColor', '', '363D40', 0, 8),
( 'Sky blue', 'mediaCtrlsBgAlpha', '', '80', 0, 8),
( 'Sky blue', 'mediaCtrlsColor', '', 'D3DADE', 0, 8),
( 'Sky blue', 'mediaCtrlsAlpha', '', '100', 0, 8),

( 'Midnight blue', 'startWithMonday', '', '1', 0, 9),
( 'Midnight blue', 'dateFormat', '', '%m-%d-%y %t', 0, 9),
( 'Midnight blue', 'dateFormatShort', '', '%t', 0, 9),
( 'Midnight blue', 'time', '', '0', 0, 9),
( 'Midnight blue', 'appMaxWidth', '', '600', 0, 9),
( 'Midnight blue', 'appMaxHeight', '', '550', 0, 9),
( 'Midnight blue', 'appMinWidth', '', '360', 0, 9),
( 'Midnight blue', 'appMinHeight', '', '420', 0, 9),
( 'Midnight blue', 'startViewSize', '', 'viewSizeMax', 0, 9),
( 'Midnight blue', 'startViewState', '', 'viewStateDays', 0, 9),
( 'Midnight blue', 'bgColors', '', 'FFFFFF FFFFFF', 0, 9),
( 'Midnight blue', 'bgCornerRadius', '', '15', 0, 9),
( 'Midnight blue', 'strokeColor', '', '808080', 0, 9),
( 'Midnight blue', 'headerHeight', '', '100', 0, 9),
( 'Midnight blue', 'headerPadding', '', '2', 0, 9),
( 'Midnight blue', 'headerBgColors', '', '025F9C 025F9C', 0, 9),
( 'Midnight blue', 'headerBgStrokeColor', '', '203540', 0, 9),
( 'Midnight blue', 'headerContentColor', '', 'FFFFFF', 0, 9),
( 'Midnight blue', 'headerContentStrokeColor', '', '404040', 0, 9),
( 'Midnight blue', 'headerFontSize', '', '40', 0, 9),
( 'Midnight blue', 'daysNamesColor', '', '025287', 0, 9),
( 'Midnight blue', 'daysNamesFontSize', '', '20', 0, 9),
( 'Midnight blue', 'datesBgColors', '', 'CFEBFF AFDDFF', 0, 9),
( 'Midnight blue', 'priority0Color', '', '55FF00', 0, 9),
( 'Midnight blue', 'priority1Color', '', '55FF00', 0, 9),
( 'Midnight blue', 'priority2Color', '', 'FFD400', 0, 9),
( 'Midnight blue', 'priority3Color', '', 'FF0000', 0, 9),
( 'Midnight blue', 'dateFontSize', '', '33', 0, 9),
( 'Midnight blue', 'dateColor', '', '404040', 0, 9),
( 'Midnight blue', 'dateStrokeColor', '', '404040', 0, 9),
( 'Midnight blue', 'showDateEventsCount', '', '1', 0, 9),
( 'Midnight blue', 'dateEventsCountFontSize', '', '12', 0, 9),
( 'Midnight blue', 'dateEventsCountColor', '', '606060', 0, 9),
( 'Midnight blue', 'eventsListHeaderHeight', '', '50', 0, 9),
( 'Midnight blue', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 9),
( 'Midnight blue', 'eventsListHeaderColor', '', '404040', 0, 9),
( 'Midnight blue', 'eventsListHeaderFontSize', '', '20', 0, 9),
( 'Midnight blue', 'eventHeaderHeight', '', '40', 0, 9),
( 'Midnight blue', 'eventHeaderFontSize', '', '20', 0, 9),
( 'Midnight blue', 'eventHeaderColor', '', '000000', 0, 9),
( 'Midnight blue', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 9),
( 'Midnight blue', 'eventContentDatesFontSize', '', '18', 0, 9),
( 'Midnight blue', 'eventContentDatesColor', '', '808080', 0, 9),
( 'Midnight blue', 'eventContentDescriptionFontSize', '', '16', 0, 9),
( 'Midnight blue', 'eventContentDescriptionColor', '', '404040', 0, 9),
( 'Midnight blue', 'footerHeight', '', '30', 0, 9),
( 'Midnight blue', 'footerColor', '', '025F9C', 0, 9),
( 'Midnight blue', 'mediaDefaultAutoplay', '', '1', 0, 9),
( 'Midnight blue', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 9),
( 'Midnight blue', 'mediaShowDuration', '', '5', 0, 9),
( 'Midnight blue', 'videoDefaultVolume', '', '80', 0, 9),
( 'Midnight blue', 'videoAutoplay', '', '0', 0, 9),
( 'Midnight blue', 'mediaBgColor', '', '000000', 0, 9),
( 'Midnight blue', 'mediaCtrlsBgColor', '', '363D40', 0, 9),
( 'Midnight blue', 'mediaCtrlsBgAlpha', '', '80', 0, 9),
( 'Midnight blue', 'mediaCtrlsColor', '', 'D3DADE', 0, 9),
( 'Midnight blue', 'mediaCtrlsAlpha', '', '100', 0, 9),

( 'Baby blue', 'startWithMonday', '', '1', 0, 10),
( 'Baby blue', 'dateFormat', '', '%m-%d-%y %t', 0, 10),
( 'Baby blue', 'dateFormatShort', '', '%t', 0, 10),
( 'Baby blue', 'time', '', '0', 0, 10),
( 'Baby blue', 'appMaxWidth', '', '600', 0, 10),
( 'Baby blue', 'appMaxHeight', '', '550', 0, 10),
( 'Baby blue', 'appMinWidth', '', '360', 0, 10),
( 'Baby blue', 'appMinHeight', '', '420', 0, 10),
( 'Baby blue', 'startViewSize', '', 'viewSizeMax', 0, 10),
( 'Baby blue', 'startViewState', '', 'viewStateDays', 0, 10),
( 'Baby blue', 'bgColors', '', '84CFEE 499BD5', 0, 10),
( 'Baby blue', 'bgCornerRadius', '', '15', 0, 10),
( 'Baby blue', 'strokeColor', '', '808080', 0, 10),
( 'Baby blue', 'headerHeight', '', '100', 0, 10),
( 'Baby blue', 'headerPadding', '', '0', 0, 10),
( 'Baby blue', 'headerBgColors', '', '4CA0DE 7FCDF3', 0, 10),
( 'Baby blue', 'headerBgStrokeColor', '', '4CA0DE', 0, 10),
( 'Baby blue', 'headerContentColor', '', 'FFFFFF', 0, 10),
( 'Baby blue', 'headerContentStrokeColor', '', '404040', 0, 10),
( 'Baby blue', 'headerFontSize', '', '40', 0, 10),
( 'Baby blue', 'daysNamesColor', '', 'FFFFFF', 0, 10),
( 'Baby blue', 'daysNamesFontSize', '', '24', 0, 10),
( 'Baby blue', 'datesBgColors', '', '9EC8E0 9EC8E0', 0, 10),
( 'Baby blue', 'priority0Color', '', '55FF00', 0, 10),
( 'Baby blue', 'priority1Color', '', '55FF00', 0, 10),
( 'Baby blue', 'priority2Color', '', 'FFD400', 0, 10),
( 'Baby blue', 'priority3Color', '', 'FF0000', 0, 10),
( 'Baby blue', 'dateFontSize', '', '40', 0, 10),
( 'Baby blue', 'dateColor', '', 'FFFFFF', 0, 10),
( 'Baby blue', 'dateStrokeColor', '', '404040', 0, 10),
( 'Baby blue', 'showDateEventsCount', '', '1', 0, 10),
( 'Baby blue', 'dateEventsCountFontSize', '', '12', 0, 10),
( 'Baby blue', 'dateEventsCountColor', '', '606060', 0, 10),
( 'Baby blue', 'eventsListHeaderHeight', '', '50', 0, 10),
( 'Baby blue', 'eventsListHeaderbgColors', '', 'F3F3F3 E6E6E6', 0, 10),
( 'Baby blue', 'eventsListHeaderColor', '', '404040', 0, 10),
( 'Baby blue', 'eventsListHeaderFontSize', '', '20', 0, 10),
( 'Baby blue', 'eventHeaderHeight', '', '40', 0, 10),
( 'Baby blue', 'eventHeaderFontSize', '', '20', 0, 10),
( 'Baby blue', 'eventHeaderColor', '', '000000', 0, 10),
( 'Baby blue', 'eventContentBgColors', '', 'F3F3F3 E6E6E6', 0, 10),
( 'Baby blue', 'eventContentDatesFontSize', '', '18', 0, 10),
( 'Baby blue', 'eventContentDatesColor', '', '808080', 0, 10),
( 'Baby blue', 'eventContentDescriptionFontSize', '', '16', 0, 10),
( 'Baby blue', 'eventContentDescriptionColor', '', '404040', 0, 10),
( 'Baby blue', 'footerHeight', '', '30', 0, 10),
( 'Baby blue', 'footerColor', '', 'D1D1D1', 0, 10),
( 'Baby blue', 'mediaDefaultAutoplay', '', '1', 0, 10),
( 'Baby blue', 'mediaScaleType', '', 'scaleTypeTouchFromOutside', 0, 10),
( 'Baby blue', 'mediaShowDuration', '', '5', 0, 10),
( 'Baby blue', 'videoDefaultVolume', '', '80', 0, 10),
( 'Baby blue', 'videoAutoplay', '', '0', 0, 10),
( 'Baby blue', 'mediaBgColor', '', '000000', 0, 10),
( 'Baby blue', 'mediaCtrlsBgColor', '', '363D40', 0, 10),
( 'Baby blue', 'mediaCtrlsBgAlpha', '', '80', 0, 10),
( 'Baby blue', 'mediaCtrlsColor', '', 'D3DADE', 0, 10),
( 'Baby blue', 'mediaCtrlsAlpha', '', '100', 0, 10)	";

	$wpdb->query($sql_insert);
}

register_activation_hook( __FILE__, 'SpiderFC_activate' );
// function create in menu
function SpiderFC_options_panel(){
  add_menu_page('Theme page title', 'SpiderFC', 'manage_options', 'SpiderFC', 'Manage_Spider');
  $page_cal=add_submenu_page( 'SpiderFC', 'SpiderFC Calendars', 'SpiderFC Calendars', 'manage_options', 'SpiderFC', 'Manage_Spider');
  $page_theme=add_submenu_page( 'SpiderFC', 'SpiderFC Parameters', 'SpiderFC Themes', 'manage_options', 'spfcthemes', 'SpiderFC_params');
  add_submenu_page( 'SpiderFC', 'Uninstall SpiderFC', 'Uninstall SpiderFC', 'manage_options', 'Uninstall_SpiderFC', 'Uninstall_SpiderFC');
add_action('admin_print_styles-' . $page_theme, 'sp_fc_admin_styles_scriptsaa');
add_action('admin_print_styles-' . $page_cal, 'sp_fc_admin_styles_scriptsaa');
}

add_action('admin_menu', 'SpiderFC_options_panel');



function sp_fc_admin_styles_scriptsaa()
  {
	 
	if(get_bloginfo('version')>3.3){
	
	wp_enqueue_script("jquery");
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script("jquery-ui-widget");
	wp_enqueue_script("jquery-ui-mouse");
	wp_enqueue_script("jquery-ui-slider");
	wp_enqueue_script("jquery-ui-sortable");
	}
	else
	{
		 wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js');
		wp_enqueue_script( 'jquery' );
		wp_deregister_script( 'jquery-ui-slider');
		wp_register_script( 'jquery-ui-slider', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js');
		wp_enqueue_script( 'jquery-ui-slider' );

	}
	
	
	
	
	wp_enqueue_script("tcal",plugins_url('js/calendar/tcal.js', __FILE__));
	wp_enqueue_script( "jscolor_js", plugins_url('jscolor/jscolor.js', __FILE__));
	wp_enqueue_script( "jscolorbox", plugins_url('js/jquery.colorbox.js', __FILE__));
	
	wp_enqueue_script( "script_js", plugins_url('js/script.js', __FILE__));
	
	
	wp_enqueue_style("jquery_ui_css",plugins_url('js/elements/jquery-ui.css', __FILE__));
	wp_enqueue_style("jquery_ui_css",plugins_url('js/elements/jquery-ui.css', __FILE__));
	wp_enqueue_style("parseTheme",plugins_url('js/elements/parseTheme.css', __FILE__));
	wp_enqueue_style("colorbox_css",plugins_url('stylesheets/colorbox.css', __FILE__));
	wp_enqueue_style("cal_css",plugins_url('js/calendar/tcal.css', __FILE__));
	wp_enqueue_style("fc_css",plugins_url('stylesheets/spiderfcstyle.css', __FILE__));
	

	wp_enqueue_script( "theme_reset_js", plugins_url('js/theme_reset.js', __FILE__));
	
	
  }


// add style head
function add_button_style()
{
echo '<style type="text/css">
.wp_themeSkin span.mce_SpirderFC_mce {background:url('.plugins_url( 'images/CalendarIcon.png' , __FILE__ ).') no-repeat !important;}
.wp_themeSkin .mceButtonEnabled:hover span.mce_SpirderFC_mce,.wp_themeSkin .mceButtonActive span.mce_SpirderFC_mce
{background:url('.plugins_url( 'images/CalendarIconHover.png' , __FILE__ ).') no-repeat !important;}
</style>';
}
add_action('admin_head', 'add_button_style');
////end////
 function Uninstall_SpiderFC(){
	global $wpdb;	
$base_name = plugin_basename('Spider_FC');
$base_page = 'admin.php?page='.$base_name;
$mode = trim($_GET['mode']);
if(!empty($_POST['do'])) {
	if($_POST['do']=="UNINSTALL Spider_FC") {
			check_admin_referer('Spider_FC uninstall');
			if(trim($_POST['Spider_FC_yes']) == 'yes') {
				
				echo '<div id="message" class="updated fade">';
				echo '<p>';
				echo "Table 'SpiderFC_Calendar' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spiderfc_calendar");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo "Table 'SpiderFC_events' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spiderfc_events");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo "Table 'SpiderFC_theme' has been deleted.";
				$wpdb->query("DROP TABLE ".$wpdb->prefix."spiderfc_theme");
				echo '<font style="color:#000;">';
				echo '</font><br />';
				echo '</p>';
				echo '</div>'; 
				
				$mode = 'end-UNINSTALL';
			}
		}
}
switch($mode) {
		case 'end-UNINSTALL':
			$deactivate_url = wp_nonce_url('plugins.php?action=deactivate&amp;plugin='.plugin_basename(__FILE__), 'deactivate-plugin_'.plugin_basename(__FILE__));
			echo '<div class="wrap">';
			echo '<h2>Uninstall SpiderFC</h2>';
			echo '<p><strong>'.sprintf('<a href="%s">Click Here</a> To Finish The Uninstallation And SpiderFC Will Be Deactivated Automatically.', $deactivate_url).'</strong></p>';
			echo '</div>';
			break;
	// Main Page
	default:
?>
<form method="post" action="<?php echo admin_url('admin.php?page=Uninstall_SpiderFC'); ?>">
  <?php wp_nonce_field('Spider_FC uninstall'); ?>
  <div class="wrap">
	<div id="icon-Spider_FC" class="icon32"><br /></div>
	<h2><?php echo 'Uninstall SpiderFC'; ?></h2>
	<p>
		<?php echo 'Deactivating SpiderFC plugin does not remove any data that may have been created. To completely remove this plugin, you can uninstall it here.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo'WARNING:'; ?></strong><br />
		<?php echo 'Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first.'; ?>
	</p>
	<p style="color: red">
		<strong><?php echo 'The following WordPress Options/Tables will be DELETED:'; ?></strong><br />
	</p>
	<table class="widefat">
		<thead>
			<tr>
				<th><?php echo 'WordPress Tables'; ?></th>
			</tr>
		</thead>
		<tr>
			<td valign="top">
				<ol>
				<?php
						echo '<li>SpiderFC_Calendar</li>'."\n";
						echo '<li>SpiderFC_events</li>'."\n";
						echo '<li>SpiderFC_theme</li>'."\n";
				?>
				</ol>
			</td>
		</tr>
	</table>
	<p style="text-align: center;">
		<?php echo 'Do you really want to uninstall SpiderFC?'; ?><br /><br />
		<input type="checkbox" name="Spider_FC_yes" value="yes" />&nbsp;<?php echo 'Yes'; ?><br /><br />
		<input type="submit" name="do" value="<?php echo 'UNINSTALL Spider_FC'; ?>" class="button-primary" onclick="return confirm('<?php echo 'You Are About To Uninstall SpiderFC From WordPress.\nThis Action Is Not Reversible.\n\n Choose [Cancel] To Stop, [OK] To Uninstall.'; ?>')" />
	</p>
</div>
</form>
<?php
}
}

function Manage_Spider(){
	
	global $wpdb;
	
	//echo "aa=";tp_init_locale();
  wp_enqueue_script('word-count');
  wp_enqueue_script('post');
  wp_enqueue_script('editor');
  wp_enqueue_script('media-upload');
  wp_admin_css('thickbox');
  wp_print_scripts('media-upload'); 
  wp_print_scripts('editor-functions');
  do_action('admin_print_styles');
  wp_enqueue_script("jquery");
  wp_tiny_mce();
/*Remove Upload/Insert button from WP editor*/
 remove_action( 'media_buttons', 'media_buttons' );
	include 'spiderfc_functions.php';
	$pagebool = false;
	if(!empty($_REQUEST['id']))
	{
		$newid = (int) $_REQUEST['id'];
		
		if( 'edit' == $_REQUEST['task']){
			$pagebool = true;
			edit_Calendars($newid);	
		}else if( 'events' == $_REQUEST['task']){
			$pagebool = true;
			SpiderFC_events($newid);				
		}else if('save' == $_REQUEST['task']){
			save_calendars($newid);
			
		}
		else if('apply' == $_REQUEST['task']){
			save_calendars($newid);
			if($newid=='-1')
			{
			$maxid = $wpdb->get_row("select MAX(id) as maxid FROM ".$wpdb->prefix."spiderfc_calendar");
			edit_Calendars($maxid->maxid);	
			}
			else
			edit_Calendars($newid);
			
			$pagebool = true;
			
		}
		else if('delete' == $_REQUEST['task']){	
			delete_spiderfc($newid);
		}
		
		
	}

	

	
	
	
	///edit spiderfc
	if($pagebool == false )
	{
	?>
    <form action="admin.php?page=SpiderFC" id="table_edit_events" method="post">
    <script type="text/javascript">
	 function ordering(x,y)
	 {
		document.getElementById('asc_or_desc_by').value=x;
		document.getElementById('asc_or_desc').value=y;
		document.getElementById('table_edit_events').submit();
 	}
</script>

<?php 
$row2=$wpdb->get_results("SELECT title, theme_id, theme_default FROM  ".$wpdb->prefix."spiderfc_theme GROUP BY theme_id ORDER BY title ".$asc_desc); 
if(!$row2->theme_default){
?>

<script>
function confirmation(href,title) {
		var answer = confirm("Are you sure you want to delete '"+title+"'?")
		if (answer){
			document.getElementById('table_edit_events').action=href;
			document.getElementById('table_edit_events').submit();
		}
		
	}
	</script>
 <?php
}

    if(isset($_POST['asc_or_desc_by']))
	{
		$sql_order='';
		if($_POST['asc_or_desc_by']=='title')	
		{
			if($_POST['asc_or_desc']==1)
			{
				$sql_order =' ORDER BY title ASC';
				$style_class_title="manage-column column-title sorted asc";
				$sort_title=2; 
			}
			if($_POST['asc_or_desc']==2)
			{
				$sql_order=' ORDER BY title DESC';
				$style_class_title="manage-column column-title sorted desc";
				$sort_title=1;
			}
		}
    }
	else
	{
		$style_class_title="manage-column column-title sortable desc";
		$sort_title=1;
	} 
	?>
    <table border="0" style="width:100%; table-layout:fixed">
    <tr>
    <td style="width:190px">
    <?php    echo "<h2>" . __( 'SpiderFC Manager' ) . "</h2>"; ?>
    </td>
    <td>       
    <p class="submit">
    <input type="hidden" id="asc_or_desc_by" name="asc_or_desc_by" value="<?php echo $_POST['asc_or_desc_by']; ?>"/>
  	<input type="hidden" id="asc_or_desc" name="asc_or_desc" value="<?php echo $_POST['asc_or_desc']; ?>"/>
    <input type="button" value="Add a Calendar" onclick="window.location.href='admin.php?page=SpiderFC&task=edit&id=-1'" />
    </p>
    </td>
    <td style="text-align:right;font-size:16px;padding:20px; padding-right:50px">
		<a href="http://webdorado.org/files/fromSpiderFC.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url( 'images/header.png' , __FILE__ ); ?>" border="0" alt="www.webdorado.org/files/fromSpiderFC.php" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
	</td>
    </tr>
    </table>

    
 <table class="widefat" style="width:95%; table-layout:fixed">
 <thead>
 <TR>
 <th scope="col" id="title" class="<?php echo $style_class_title; ?>" style="" ><a href="javascript:ordering('title',<?php echo $sort_title?>)" style="table-layout:fixed"><span>Title</span><span class="sorting-indicator"></span></a></th>
 <th>Published</th>
 <th>Manage Events</th>
 <th style="width:60px">Edit</th>
 <th style="width:60px">Delete</th>
 </TR>
 </thead>
 <tbody>
 <?php 
  if($sql_order=="")
 {
	$sql_order=' ORDER BY id DESC';
 }
	  $row=$wpdb->get_results("SELECT * FROM  ".$wpdb->prefix."spiderfc_calendar ".$sql_order);
	  for($i=0; $i<count($row);$i++){                 
		    ?>
 <tr>
 	<td>
	 <a href="admin.php?page=SpiderFC&task=edit&id=<?php echo $row[$i]->id;?>"> 
 			<?php if($row[$i]->title!="") 
 						echo $row[$i]->title; 
				else 
						echo "No Title";  ?> </a>
	 </td>
      <td><?php if($row[$i]->published==1) {echo 'Yes';} else {echo 'No';}  ?> </td>
      <td><a href="admin.php?page=SpiderFC&task=events&id=<?php echo $row[$i]->id;?>" >Manage Events</a> </td>
      <td><a href="admin.php?page=SpiderFC&task=edit&id=<?php echo $row[$i]->id; ?>">Edit</a> </td>
      <td><a href="javascript:confirmation('admin.php?page=SpiderFC&task=delete&id=<?php echo $row[$i]->id; ?>','<?php if($row[$i]->title!="") echo addslashes($row[$i]->title); else echo "(No Title)" ?>')">Delete</a> </td>
 </tr>
 <?php
    }
	?>
 </tbody>
 </table>
 </form>
 <?php
	}
}
function SpiderFC_events($id){ //$id -is calendar id
	global $wpdb;
	include_once 'spiderfc_functions.php';
	$pagebool = false;
	if(!empty($_REQUEST['id']))
	{	$newid = (int)$_REQUEST['id'];
		$idevent = (int)$_REQUEST['idevent'];
	}
	if( 'edit' == $_REQUEST['action']){
			$pagebool = true;
			if('save' == $_POST['snd']){
				if( 'save' ==  $_POST['send']){
					$pagebool = false;
				}
				Change_CalendarsEvents($newid, $idevent);	
			}							
			if($pagebool != false)
				edit_CalendarsEvents($newid, $idevent); // function declaration edit_CalendarsEvents($newid, &$idevent); 
	}else if( 'delete' == $_REQUEST['action']){			
		if($idevent != -1){	delete_events($idevent);} /*Delete events*/
	}
	if($pagebool == false){
?>	
	 <form action="admin.php?page=SpiderFC&task=events&id=<?php echo $id;?>" id="table_edit_events" method="post">
    <script type="text/javascript">
	 function ordering(x,y)
	 {
		document.getElementById('asc_or_desc_by').value=x;
		document.getElementById('asc_or_desc').value=y;
		document.getElementById('table_edit_events').submit();
 	}

 	</script>

<?php 
$row2=$wpdb->get_results("SELECT title, theme_id, theme_default FROM  ".$wpdb->prefix."spiderfc_theme GROUP BY theme_id ORDER BY title ".$asc_desc); 
if(!$row2->theme_default){
?>

<script>
 	function confirmation(href,title) {
		if(title!='No Title'){
		var answer = confirm("Are you sure you want to delete '"+title+"'?")
		if (answer){
			document.getElementById('table_edit_events').action=href;
			document.getElementById('table_edit_events').submit();
		}
		else{
		}
	}
	else alert("You can't delete default theme!");
	
	}
	</script>
 <?php
}
    
    ?>
     <?php
    if(isset($_POST['asc_or_desc_by']))
	{
		$sql_order='';
		if($_POST['asc_or_desc_by']=='title')	
		{
			if($_POST['asc_or_desc']==1)
			{
				$sql_order =' ORDER BY title ASC';
				$style_class_title="manage-column column-title sorted asc";
				$sort_title=2;	 
			}
			if($_POST['asc_or_desc']==2)
			{
				$sql_order=' ORDER BY title DESC';
				$style_class_title="manage-column column-title sorted desc";
				$sort_title=1;
			}
		}
    }
	else
	{
		$style_class_title="manage-column column-title sortable desc";
		$sort_title=1;
	}
	if($sql_order=="")
	 {
		$sql_order=' ORDER BY id DESC';
	 }
	?>
    <table width="100%" style="table-layout:fixed">
    <tr>
    <td  style="width:190px">
    <?php
	$get_title=$wpdb->get_results("SELECT title FROM ".$wpdb->prefix."spiderfc_calendar WHERE id=".$id);
	echo "<h2>" . __( 'SpiderFC Events - '.$get_title[0]->title). "</h2>"; ?>
    </td>
    <td>       
    <p class="submit">
      <input type="hidden" id="asc_or_desc_by" name="asc_or_desc_by" value="<?php echo $_POST['asc_or_desc_by']; ?>"/>
  	 <input type="hidden" id="asc_or_desc" name="asc_or_desc" value="<?php echo $_POST['asc_or_desc']; ?>"/>
    <input type="button" value="Add an Event" onclick="window.location.href='admin.php?page=SpiderFC&task=events&action=edit&id=<?php echo $id;?>&idevent=-1'" /> <!--edit_Theme(-1)-->
    </p>
    </td>
     <td style="text-align:right;font-size:16px;padding:20px; padding-right:50px">
		<a href="http://webdorado.org/files/fromSpiderFC.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url( 'images/header.png' , __FILE__ ); ?>" border="0" alt="www.webdorado.org/files/fromSpiderFC.php" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
	</td>
    </tr>
    </table>
	 <table class="widefat" style="width:95%; table-layout:fixed">
 <thead>
 <TR>
 	<th>ID</th>
	 <th scope="col" id="title" class="<?php echo $style_class_title; ?>" style="" >
 	<a href="javascript:ordering('title',<?php echo $sort_title?>)"><span>Title</span><span class="sorting-indicator"></span></a></th>
	<th>Date</th>
	<th>Time</th>
 	<th>Publish</th>
	<th style="width:60px">Edit</th>
 	<th style="width:60px">Delete</th>
 </TR>
 </thead>
 <tbody>
 <?php 
 	$events = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spiderfc_events WHERE id_calendar='".$id."' ".$sql_order.";");
	foreach($events as $event)
	{
		?><tr> 
        <td><?php echo $event->id?></td>
        <td><a href="admin.php?page=SpiderFC&task=events&action=edit&id=<?php echo $id?>&idevent=<?php echo $event->id?>"><?php echo $event->title?></a></td>
        <td><?php echo $event->date_begin."-".$event->date_end;?></td>       
        <td><?php if($event->event_time_begin=='' ) {echo $event->event_time_end; } else if($event->event_time_end=="") {echo  $event->event_time_begin;} else {echo $event->event_time_begin.'-'.$event->event_time_end;} ?></td> 
        <td><?php if($event->published == 0){ echo "No";} else {echo "Yes";} ?></td>
        <td><a href="admin.php?page=SpiderFC&task=events&action=edit&id=<?php echo $id?>&idevent=<?php echo $event->id?>">Edit</a></td>
        <td><a href="admin.php?page=SpiderFC&task=events&action=delete&id=<?php echo $id?>&idevent=<?php echo $event->id?>">Delete</a></td>
        </tr><?php	
	}
 ?>
 </tbody>
 </table>
 <?php
	}
}
/*Calendar themes */
function SpiderFC_params(){
	global $wpdb;
	if($_GET["task"] == 'default') {
	 $query1  = $wpdb->query("UPDATE ".$wpdb->prefix."spiderfc_theme SET theme_default='0'");
	 $query2  = $wpdb->query("UPDATE ".$wpdb->prefix."spiderfc_theme SET theme_default='1' WHERE theme_id = '".$_GET["id"]."' ");
 }
	$pagebool = false;
	include 'spiderfc_functions.php';
	//task=edit
	if(!empty($_REQUEST['id']))
		$newid = (int) $_REQUEST['id'];
	if('edit' == $_REQUEST['task']){
			edit_Theme($newid);
			$pagebool = true;	
	}else if('delete' == $_REQUEST['task']){
				delete_themes($newid);
	}else if('save' == $_REQUEST['task']){
			edit_spiderfc($newid);
	}
	else if('apply' == $_REQUEST['task'])
	{
			edit_spiderfc($newid);
			
			if($newid=='-1')
			{
			
				$maxId = $wpdb->get_row("select MAX(theme_id) as maxid FROM ".$wpdb->prefix."spiderfc_theme");
				edit_Theme($maxId->maxid);
				
			}
			else
			edit_Theme($newid);
			$pagebool = true;	
	}
	
	
	if($pagebool == false){
	?>
     <form action="<?php echo admin_url('admin.php?page=spfcthemes'); ?>" id="table_edit_events" method="post">
    <script type="text/javascript">
	function ordering(x,y)
	 {
		document.getElementById('order_by_1').value=x;
		document.getElementById('asc_or_desc_1').value=y;
		document.getElementById('table_edit_events').submit();
 	}
</script>

<?php 
$row2=$wpdb->get_results("SELECT title, theme_id, theme_default FROM  ".$wpdb->prefix."spiderfc_theme GROUP BY theme_id ORDER BY title ".$asc_desc); 
if(!$row2->theme_default){
?>

<script>
 	function confirmation(href,title) {
		if(title!='No Title'){
		var answer = confirm("Are you sure you want to delete '"+title+"'?")
		if (answer){
			document.getElementById('table_edit_events').action=href;
			document.getElementById('table_edit_events').submit();
		}
		else{
		}
	}
	else alert("You can't delete default theme!");
	}
	</script>
 <?php
}
    
    ?>

    <table width="100%" style="table-layout:fixed">
    <tr>
    <td style="width:190px">
    <?php    
		echo "<h2>" . __( 'SpiderFC Themes' ) . "</h2>"; 
		if(isset($_POST['order_by_1'])){
		$sort["sortid_by"]=$_POST['order_by_1'];
		if($_POST['asc_or_desc_1']==1)
		{
		 $asc_desc = 'ASC';
		 $sort["custom_style"]="manage-column column-title sorted asc";
		 $sort["1_or_2"]=2;
		}
			else{ $asc_desc = 'DESC';	
			$sort["custom_style"]="manage-column column-title sorted desc";
			$sort["1_or_2"]=1;
			}
	}	
	?>
    </td>
    <td>       
    <p class="submit">
      <input type="hidden" id="asc_or_desc_1" name="asc_or_desc_1" value="<?php echo $_POST['asc_or_desc_by']; ?>"/>
    <input type="hidden" name="order_by_1" id="order_by_1" value="<?php echo $_POST['order_by'] ?>" >
  
    <input type="button" value="Add a Theme" onclick="window.location.href='admin.php?page=spfcthemes&task=edit&id=-1'" /> <!--edit_Theme(-1)-->
    </p>
    </td>
     <td style="text-align:right;font-size:16px;padding:20px; padding-right:50px">
		<a href="http://webdorado.org/files/fromSpiderFC.php" target="_blank" style="color:red; text-decoration:none;">
		<img src="<?php echo plugins_url('images/header.png' , __FILE__ ); ?>" border="0" alt="www.webdorado.org/files/fromSpiderFC.php" width="215"><br>
		Get the full version&nbsp;&nbsp;&nbsp;&nbsp;
		</a>
	</td>
    </tr>
    </table>
 
<?php
	if(isset($_POST['order_by_1']))
	{
		if($_POST['order_by_1']=='title')	
		{	$sql_order = 'title';
		}
	else if($_POST['order_by_1']=='theme_id'){
		$sql_order = 'theme_id';
		}
	else if($_POST['order_by_1']==''){
		$sql_order = 'theme_id';
		}
			$row=$wpdb->get_results("SELECT title, theme_id, theme_default FROM  ".$wpdb->prefix."spiderfc_theme GROUP BY theme_id ORDER BY ".$sql_order." ".$asc_desc);
		}
	else {
			$row=$wpdb->get_results("SELECT title, theme_id, theme_default FROM  ".$wpdb->prefix."spiderfc_theme GROUP BY theme_id ORDER BY theme_id ".$asc_desc);
		}
?>
 <input type="hidden" name="post_name" style="width:153px; font-size:11px;" onchange="submit_form_postid(this)">    
	<table class="wp-list-table widefat plugins" style="width:95%"">
         <thead>
             <TR>
                 <th  width="50" scope="col" id="id" class="<?php if($sort["sortid_by"]=="theme_id") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="" >
                     <a href="javascript:ordering('theme_id',<?php if($sort["sortid_by"]=="theme_id") echo $sort["1_or_2"]; else echo "1"; ?>)">
                         <span>ID</span>
                         <span class="sorting-indicator"></span>
                     </a>
                 </th>
                 <th scope="col" id="title" class="<?php if($sort["sortid_by"]=="title") echo $sort["custom_style"]; else echo $sort["default_style"]; ?>" style="">
                     <a href="javascript:ordering('title',<?php if($sort["sortid_by"]=="title") echo $sort["1_or_2"]; else echo "1"; ?>)">
                          <span>Title</span>
                         <span class="sorting-indicator"></span>
                     </a>
               	 </th>      
             	 <th>Default</th>              
                 <th style="width:60px">Edit</th>  
                 <th style="width:60px">Delete</th>
         	</TR>
 </thead>
 <tbody>
 <?php
             for($i=0; $i<count($row);$i++){ 
                  ?>
                  <tr>
                    <td><?php echo $row[$i]->theme_id; ?></td>
                    <td><a  href="admin.php?page=spfcthemes&task=edit&id=<?php echo $row[$i]->theme_id; ?>"><?php echo $row[$i]->title?></a></td>
                    <td><a <?php if(!$row[$i]->theme_default) echo 'style="color:#C00"';  ?>  href="admin.php?page=spfcthemes&task=default&id=<?php echo $row[$i]->theme_id?>"><?php if($row[$i]->theme_default) echo "Default"; else echo "Not Default";?></a></td>
                    <td><a  href="admin.php?page=spfcthemes&task=edit&id=<?php echo $row[$i]->theme_id; ?>">Edit</a> </td>
                    <td><a href="javascript:confirmation('admin.php?page=spfcthemes&task=delete&id=<?php echo $row[$i]->theme_id; ?>',
                 '<?php if(!$row[$i]->theme_default) echo addslashes($row[$i]->title); else echo "No Title" ?>')">Delete</a> </td></tr>
                   <?php 
			 }
 ?>
 </tbody>
 </table>
 </form>
	<?php
	}
}
?>