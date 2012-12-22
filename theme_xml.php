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

global $wpdb;
if(!empty($_GET['spiderid']))
{
	$id = (int)$_GET['spiderid'];
	$q = "SELECT ".$wpdb->prefix."spiderfc_theme.* FROM  ".$wpdb->prefix."spiderfc_theme JOIN ".$wpdb->prefix."spiderfc_calendar 
													ON ".$wpdb->prefix."spiderfc_theme.theme_id=".$wpdb->prefix."spiderfc_calendar.id_theme 
													WHERE  ".$wpdb->prefix."spiderfc_calendar.id=".$id." ORDER BY ".$wpdb->prefix."spiderfc_theme.id";
$parameters = $wpdb->get_results($q);

echo 	'<?xml version="1.0" encoding="UTF-8"?>

<settings>';
foreach($parameters as $params){
	$bg ="";
switch($params->paramsname){
	
	
			case 'startWithMonday': 
				$bevent = 'true';
				if($params->paramsvalue == 0) $bevent = 'false'; 
				$string .= '<startWithMonday>'.$bevent.'</startWithMonday>';
				break;
			case 'dateFormat':
				$string .=  '<dateFormat>'.$params->paramsvalue.'</dateFormat>';
				break;
			case 'dateFormatShort':
				$string .=  '<dateFormatShort>'.$params->paramsvalue.'</dateFormatShort>';
				break;
			case 'time': 
				$bevent = 'true';
				if($params->paramsvalue == 0) $bevent = 'false'; 
				$string .= '<time12Hours>'.$bevent.'</time12Hours>';
				break;
					
			case 'appMaxWidth':
				$string .=  '<appMaxWidth>'.$params->paramsvalue.'</appMaxWidth>';	
				$maxWidth = $params->paramsvalue;
				break;
			
			case 'appMaxHeight':
				$string .= '<appMaxHeight>'.$params->paramsvalue.'</appMaxHeight>';
				break;
			case 'appMinWidth':
				$string .= '<appMinWidth>'.$params->paramsvalue.'</appMinWidth>';
				break;
			
			case 'appMinHeight':
				$string .= '<appMinHeight>'.$params->paramsvalue.'</appMinHeight>';
				break;
			
			case 'startViewSize':
					$string .=	'<startViewSize>'.$params->paramsvalue.'</startViewSize>';	
					
				break;
			case 'startViewState':			
					$string .= '<startViewState>'.$params->paramsvalue.'</startViewState>';
				break;

			case 'bgColors':
					$bg = explode(' ',$params->paramsvalue);
					$string .= '<bgColors>0x'.$bg[0].', 0x'.$bg[1].'</bgColors>';
				break;
			
			
			case 'bgCornerRadius':
					$string .= '<bgCornerRadius>'.$params->paramsvalue.'</bgCornerRadius>';
				break;
				
			case 'strokeColor':
					$string .= '<strokeColor>0x'.$params->paramsvalue.'</strokeColor>';
				break;
			case 'headerHeight':
					$string .= '<headerHeight>'.$params->paramsvalue.'</headerHeight>';
				break;
			case 'headerPadding':
					$string .= '<headerPadding>'.$params->paramsvalue.'</headerPadding>';
				break;
			case 'headerBgColors':
				$bg = explode(' ',$params->paramsvalue);
				$string .= '<headerBgColors>0x'.$bg[0].', 0x'.$bg[1].'</headerBgColors>';
				break;
			case 'headerBgStrokeColor':
					$string .= '<headerBgStrokeColor>0x'.$params->paramsvalue.'</headerBgStrokeColor>';
				break;
			case 'headerContentColor':
					$string .= '<headerContentColor>0x'.$params->paramsvalue.'</headerContentColor>';
				break;
	/*		case 'headerContentHoverColor':
					$string .= '<headerContentHoverColor>0x'.$params->paramsvalue.'</headerContentHoverColor>';
				break;*/
			case 'headerContentStrokeColor':
					$string .= '<headerContentStrokeColor>0x'.$params->paramsvalue.'</headerContentStrokeColor>';
				break;	
			case 'headerFontSize':
					$string .= '<headerFontSize>'.$params->paramsvalue.'</headerFontSize>';
				break;	
				
			case 'daysNamesColor':
					$string .= '<daysNamesColor>0x'.$params->paramsvalue.'</daysNamesColor>';
				break;		
			case 'daysNamesFontSize':
					$string .= '<daysNamesFontSize>'.$params->paramsvalue.'</daysNamesFontSize>';
				break;	
				
		/*	case 'daysNamesHeight':
					$string .= '<daysNamesHeight>'.$params->paramsvalue.'</daysNamesHeight>';
				break;	*/				
			case 'datesBgColors':
					$bg = explode(' ',$params->paramsvalue);
					$string .= '<datesBgColors>0x'.$bg[0].', 0x'.$bg[1].'</datesBgColors>';
				break;	
			
	/*		case 'datesBgStrokeColor':
					$string .= '<datesBgStrokeColor>0x'.$params->paramsvalue.'</datesBgStrokeColor>';
				break;	*/				
				
			case 'priority0Color':
					$string .= '<priority0Color>0x'.$params->paramsvalue.'</priority0Color>';
				break;
			case 'priority1Color':
					$string .= '<priority1Color>0x'.$params->paramsvalue.'</priority1Color>';
				break;
			case 'priority2Color':
					$string .= '<priority2Color>0x'.$params->paramsvalue.'</priority2Color>';
				break;	
			case 'priority3Color':
					$string .= '<priority3Color>0x'.$params->paramsvalue.'</priority3Color>';
				break;
			case 'dateFontSize':
					$string .= '<dateFontSize>'.$params->paramsvalue.'</dateFontSize>';
				break;
			case 'dateColor':
					$string .= '<dateColor>0x'.$params->paramsvalue.'</dateColor>';
				break;
			case 'dateStrokeColor':
					$string .= '<dateStrokeColor>0x'.$params->paramsvalue.'</dateStrokeColor>';
				break;
				
			case 'showDateEventsCount':
				$bevent = 'true';
				if($params->paramsvalue == 0) $bevent = 'false';  
					$string .= '<showDateEventsCount>'.$bevent.'</showDateEventsCount>';
				break;	
				
			case 'dateEventsCountFontSize':
					$string .= '<dateEventsCountFontSize>'.$params->paramsvalue.'</dateEventsCountFontSize>';
				break;	
				
			case 'dateEventsCountColor':
					$string .= '<dateEventsCountColor>0x'.$params->paramsvalue.'</dateEventsCountColor>	';
				break;	
				
			case 'eventsListHeaderHeight':
					$string .= '<eventsListHeaderHeight>'.$params->paramsvalue.'</eventsListHeaderHeight>';
				break;		
				
	/*		case 'eventsListHeaderStrokeColor':
					$string .= '<eventsListHeaderStrokeColor>0x'.$params->paramsvalue.'</eventsListHeaderStrokeColor>';
				break;		*/
				
			case 'eventsListHeaderbgColors':
					$bg = explode(' ',$params->paramsvalue);
					$string .= '<eventsListHeaderbgColors>0x'.$bg[0].', 0x'.$bg[1].'</eventsListHeaderbgColors>';
				break;		
			case 'eventsListHeaderColor':
					$string .='<eventsListHeaderColor>0x'.$params->paramsvalue.'</eventsListHeaderColor>';
				break;		
	/*		case 'eventsListHeaderHoverColor':
					$string .= '<eventsListHeaderHoverColor>0x'.$params->paramsvalue.'</eventsListHeaderHoverColor>';
				break;*/
			case 'eventsListHeaderFontSize':
					$string .= '<eventsListHeaderFontSize>'.$params->paramsvalue.'</eventsListHeaderFontSize>';
				break;				
				
			case 'eventHeaderHeight':
					$string .= '<eventHeaderHeight>'.$params->paramsvalue.'</eventHeaderHeight>';
				break;	
			case 'eventHeaderFontSize':
					$string .= '<eventHeaderFontSize>'.$params->paramsvalue.'</eventHeaderFontSize>';
				break;		
			case 'eventHeaderColor':
					$string .= '<eventHeaderColor>0x'.$params->paramsvalue.'</eventHeaderColor>';
				break;	
	/*		case 'eventHeaderHoverColor':
					$string .= '<eventHeaderHoverColor>0x'.$params->paramsvalue.'</eventHeaderHoverColor>';
				break;*/
			case 'eventContentBgColors':
				$bg = explode(' ',$params->paramsvalue);
					$string .= '<eventContentBgColors>0x'.$bg[0].', 0x'.$bg[1].'</eventContentBgColors>';
				break;	
				
			case 'eventContentDatesFontSize':
					$string .= '<eventContentDatesFontSize>'.$params->paramsvalue.'</eventContentDatesFontSize>';
				break;
			case 'eventContentDatesColor':
					$string .= '<eventContentDatesColor>0x'.$params->paramsvalue.'</eventContentDatesColor>';
				break;	
			case 'eventContentDescriptionFontSize':
					$string .= '<eventContentDescriptionFontSize>'.$params->paramsvalue.'</eventContentDescriptionFontSize>';
				break;	
			case 'eventContentDescriptionColor':
					$string .= '<eventContentDescriptionColor>0x'.$params->paramsvalue.'</eventContentDescriptionColor>	';
				break;

				
			case 'mediaDefaultAutoplay':
				$bevent = 'true';
				if($params->paramsvalue == 0) $bevent = 'false';  
					$string .= '<mediaDefaultAutoplay>'.$bevent.'</mediaDefaultAutoplay>';
				break;
				
			case 'mediaScaleType':
					$string .= '<mediaScaleType>'.$params->paramsvalue.'</mediaScaleType>';
				break;	
			case 'mediaShowDuration':
					$string .= '<mediaShowDuration>'.$params->paramsvalue.'</mediaShowDuration>';
				break;	
			case 'videoDefaultVolume':
					$string .= '<videoDefaultVolume>'.$params->paramsvalue/100 .'</videoDefaultVolume>';
				break;	
			case 'videoAutoplay':
				$bevent = 'true';
				if($params->paramsvalue == 0) $bevent = 'false'; 
					$string .= '<videoAutoplay>'.$bevent.'</videoAutoplay>';
				break;
			case 'mediaBgColor':
					$string .= '<mediaBgColor>0x'.$params->paramsvalue.'</mediaBgColor>';
				break;		
			case 'mediaCtrlsBgColor':
					$string .= '<mediaCtrlsBgColor>0x'.$params->paramsvalue.'</mediaCtrlsBgColor>';
				break;		
			case 'mediaCtrlsBgAlpha':
					$string .= '<mediaCtrlsBgAlpha>'.$params->paramsvalue/100 .'</mediaCtrlsBgAlpha>';
				break;
			case 'mediaCtrlsColor':
					$string .= '<mediaCtrlsColor>0x'.$params->paramsvalue.'</mediaCtrlsColor>';
				break;	
/*			case 'mediaCtrlsHoverColor':
					$string .= '<mediaCtrlsHoverColor>0x'.$params->paramsvalue.'</mediaCtrlsHoverColor>';
				break;*/
			case 'mediaCtrlsAlpha':
					$string .= '<mediaCtrlsAlpha>'.$params->paramsvalue/100 .'</mediaCtrlsAlpha>';
				break;	
			case 'footerHeight':
					$string .= '<footerHeight>'.$params->paramsvalue.'</footerHeight>';
				break;	
			case 'footerColor':
					$string .= '<footerColor>0x'.$params->paramsvalue.'</footerColor>';
				break;
	/*		case 'footerHoverColor':
					$string .= '<footerHoverColor>0x'.$params->paramsvalue.'</footerHoverColor>';
				break;		*/		
			}
}
echo $string;		
echo'</settings>';


}


?>