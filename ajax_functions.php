<?php
function spider_flash_calendar_window(){
global $wpdb;
	?>
	<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Spider Flash Calendar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/jquery/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
    <link rel="stylesheet" href="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/themes/advanced/skins/wp_theme/dialog.css?ver=342-20110630100">
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option("siteurl"); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<base target="_self">
</head>
<body id="link"  style="" dir="ltr" class="forceColors">
	<div class="tabs" role="tablist" tabindex="-1">
		<ul>
			<li id="spider_calendar_tab" class="current" role="tab" tabindex="0"><span><a href="javascript:mcTabs.displayTab('spider_calendar_tab','spider_calendar_panel');" onMouseDown="return false;" tabindex="-1">Spider Flash Calendar</a></span></li>
		</ul>
	</div>
    <style>
    .panel_wrapper{
		height:100px !important;
	}
    </style>
    	<div class="panel_wrapper">
			<div id="spider_calendar_panel" class="panel current">
                <table>
              	  <tr>
               		 <td style="height:100px; width:100px; vertical-align:top;">
                		Select a Calendar 
                	</td>
                	<td style="vertical-align:top">
<select name="spiderfcname" id="spiderfcname" style="width:200px;" >
<option value="- Select SpiderFC -" selected="selected">- Select Calendar -</option>
<?php   $ids_SpiderFC=$wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spiderfc_calendar where published=1 order by title",0);
var_dump($ids_SpiderFC);
	   foreach($ids_SpiderFC as $arr_SpiderFC)
	   {
		   ?>
           <option value="<?php echo $arr_SpiderFC->id; ?>"><?php echo $arr_SpiderFC->title; ?></option>
           <?php }?>
</select>
 </td>
                </tr>
                </table>
                </div>
        </div>
        <div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="Cancel" onClick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="Insert" onClick="insert_spiderfc();" />
		</div>
	</div>
<script type="text/javascript">
function insert_spiderfc() {
	if(document.getElementById('spiderfcname').value=='- Select SpiderFC -')
	{
		tinyMCEPopup.close();
	}
	else
	{
	   var tagtext;
	   tagtext='[spiderfc id="'+document.getElementById('spiderfcname').value+'"]';
	   window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
	   tinyMCEPopup.editor.execCommand('mceRepaint');
	   tinyMCEPopup.close();		
	}
	
}
</script>
</body></html>
<?php
die();
}


function calendar_xml_main(){
	

echo '<?xml version="1.0" encoding="utf-8"?>

<events>';

global $wpdb;
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
die();
	
	
	
	}










function calendar_language_flash(){
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
die();
	
	
}
	
}

function calendar_theme_flash(){
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
die();
	
	
	
}



 ?>