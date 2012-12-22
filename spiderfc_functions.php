<?php

include_once("include/spiderfcTheme.php");


//delete spiderfc calendar and evens
function delete_spiderfc($id)
{
	global $wpdb;
	
	$sqll="DELETE FROM ".$wpdb->prefix."spiderfc_calendar WHERE id='".$id."'";
	$wpdb->query($sqll);
	$sqll="DELETE FROM ".$wpdb->prefix."spiderfc_events WHERE id_calendar='".$id."'";
	$wpdb->query($sqll);
}
/*Delete calendar theme*/

function delete_themes($id){
	
	global $wpdb;
	
	if(!empty($id)){
	
		$q = $wpdb->get_row("SELECT COUNT(theme_default) as thcount FROM ".$wpdb->prefix."spiderfc_theme WHERE theme_id='".$id."'");
				
		if($q->thcount > 0){
			$sqll="DELETE FROM ".$wpdb->prefix."spiderfc_theme WHERE theme_id='".$id."'";
		
			$wpdb->query($sqll);
		}
	}
	
}

function delete_events($id){
	
	global $wpdb;
	
	if(!empty($id)){
	
	 	$sqll="DELETE FROM ".$wpdb->prefix."spiderfc_events WHERE id='".$id."'";
	
		$wpdb->query($sqll);
	}
	
}

// edit spider fc
function edit_spiderfc($id)
{
	$objtheme = new SpiderFCTheme(-1); 
	
	$title = $_POST['SpiderFC_themeTitle'];
	$themeDefault = 0;//$_POST['SpiderFC_themeDefault'];	
	
	$objtheme->addProperty($title,'startWithMonday','', $_POST['SpiderFC_Width_in_monday'],$themeDefault,$id);
	$objtheme->addProperty($title,'dateFormat','', $_POST['SpiderFC_dateFormat'],$themeDefault,$id);	
	$objtheme->addProperty($title,'dateFormatShort','', $_POST['SpiderFC_dateFormatShort'],$themeDefault,$id);	
	$objtheme->addProperty($title,'time','', $_POST['SpiderFC_time'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'appMaxWidth','', $_POST['SpiderFC_appmaxWidth'],$themeDefault,$id);	
	$objtheme->addProperty($title,'appMaxHeight', '', $_POST['SpiderFC_appmaxHeight'],$themeDefault,$id);
	$objtheme->addProperty($title,'appMinWidth','', $_POST['SpiderFC_appminWidth'],$themeDefault,$id);
	$objtheme->addProperty($title,'appMinHeight','', $_POST['SpiderFC_appminHeight'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'startViewSize', '',$_POST['SpiderFC_startViewSize'],$themeDefault,$id);
	$objtheme->addProperty($title,'startViewState','', $_POST['SpiderFC_startViewState'],$themeDefault,$id);	
	$objtheme->addProperty($title,'bgColors', '', $_POST['SpiderFC_bgColors1']. " " . $_POST['SpiderFC_bgColors2'],$themeDefault,$id);	
	$objtheme->addProperty($title,'bgCornerRadius','', $_POST['SpiderFC_bgCornerRadius'],$themeDefault,$id);
	$objtheme->addProperty($title,'strokeColor','', $_POST['SpiderFC_strokeColor'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'headerHeight','', $_POST['SpiderFC_headerHeight'],$themeDefault,$id);	
	$objtheme->addProperty($title,'headerPadding','', $_POST['SpiderFC_headerPadding'],$themeDefault,$id);
	$objtheme->addProperty($title,'headerBgColors','',$_POST['SpiderFC_headerBgColors1']." ".$_POST['SpiderFC_headerBgColors2'],$themeDefault,$id);
	$objtheme->addProperty($title,'headerBgStrokeColor','', $_POST['SpiderFC_headerBgStrokeColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'headerContentColor', '',$_POST['SpiderFC_headerContentColor'],$themeDefault,$id);
//	$objtheme->addProperty($title,'headerContentHoverColor','', $_POST['SpiderFC_headerContentHoverColor'],$themeDefault,$id);	
	$objtheme->addProperty($title,'headerContentStrokeColor','', $_POST['SpiderFC_headerContentStrokeColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'headerFontSize','', $_POST['SpiderFC_headerFontSize'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'daysNamesColor','', $_POST['SpiderFC_daysNamesColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'daysNamesFontSize','', $_POST['SpiderFC_daysNamesFontSize'],$themeDefault,$id);
//	$objtheme->addProperty($title,'daysNamesHeight','', $_POST['SpiderFC_daysNamesHeight'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'datesBgColors','', $_POST['SpiderFC_datesBgColors1']." ".$_POST['SpiderFC_datesBgColors2'],$themeDefault,$id);
//	$objtheme->addProperty($title,'datesBgStrokeColor','', $_POST['SpiderFC_datesBgStrokeColor'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'priority0Color','', $_POST['SpiderFC_priority0Color'],$themeDefault,$id);
	$objtheme->addProperty($title,'priority1Color','', $_POST['SpiderFC_priority1Color'],$themeDefault,$id);
	$objtheme->addProperty($title,'priority2Color','', $_POST['SpiderFC_priority2Color'],$themeDefault,$id);
	$objtheme->addProperty($title,'priority3Color','', $_POST['SpiderFC_priority3Color'],$themeDefault,$id);
	$objtheme->addProperty($title,'dateFontSize','', $_POST['SpiderFC_dateFontSize'],$themeDefault,$id);
	$objtheme->addProperty($title,'dateColor','', $_POST['SpiderFC_dateColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'dateStrokeColor','', $_POST['SpiderFC_dateStrokeColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'showDateEventsCount','', $_POST['SpiderFC_showDateEventsCount'],$themeDefault,$id);
	$objtheme->addProperty($title,'dateEventsCountFontSize','', $_POST['SpiderFC_dateEventsCountFontSize'],$themeDefault,$id);	
	$objtheme->addProperty($title,'dateEventsCountColor','', $_POST['SpiderFC_dateEventsCountColor'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'eventsListHeaderHeight','', $_POST['SpiderFC_eventsListHeaderHeight'],$themeDefault,$id);
//	$objtheme->addProperty($title,'eventsListHeaderStrokeColor','', $_POST['SpiderFC_eventsListHeaderStrokeColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventsListHeaderbgColors','', $_POST['SpiderFC_eventsListHeaderbgColors1']." ".$_POST['SpiderFC_eventsListHeaderbgColors2'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventsListHeaderColor','', $_POST['SpiderFC_eventsListHeaderColor'],$themeDefault,$id);
//	$objtheme->addProperty($title,'eventsListHeaderHoverColor','', $_POST['SpiderFC_eventsListHeaderHoverColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventsListHeaderFontSize','', $_POST['SpiderFC_eventsListHeaderFontSize'],$themeDefault,$id);

	$objtheme->addProperty($title,'eventHeaderHeight','', $_POST['SpiderFC_eventHeaderHeight'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventHeaderFontSize','', $_POST['SpiderFC_eventHeaderFontSize'],$themeDefault,$id);	
	$objtheme->addProperty($title,'eventHeaderColor','', $_POST['SpiderFC_eventHeaderColor'],$themeDefault,$id);
	
//	$objtheme->addProperty($title,'eventHeaderHoverColor','', $_POST['SpiderFC_eventHeaderHoverColor'],$themeDefault,$id);

	$objtheme->addProperty($title,'eventContentBgColors','', $_POST['SpiderFC_eventContentBgColors1']." ".$_POST['SpiderFC_eventContentBgColors2'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventContentDatesFontSize','', $_POST['SpiderFC_eventContentDatesFontSize'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventContentDatesColor','', $_POST['SpiderFC_eventContentDatesColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventContentDescriptionFontSize','', $_POST['SpiderFC_eventContentDescriptionFontSize'],$themeDefault,$id);
	$objtheme->addProperty($title,'eventContentDescriptionColor','', $_POST['SpiderFC_eventContentDescriptionColor'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'footerHeight','', $_POST['SpiderFC_footerHeight'],$themeDefault,$id);
	$objtheme->addProperty($title,'footerColor','', $_POST['SpiderFC_footerColor'],$themeDefault,$id);
//	$objtheme->addProperty($title,'footerHoverColor','', $_POST['SpiderFC_footerHoverColor'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'mediaDefaultAutoplay','', $_POST['SpiderFC_mediaDefaultAutoplay'],$themeDefault,$id);
	$objtheme->addProperty($title,'mediaScaleType','', $_POST['SpiderFC_mediaScaleType'],$themeDefault,$id);	
	$objtheme->addProperty($title,'mediaShowDuration','', $_POST['SpiderFC_mediaShowDuration'],$themeDefault,$id);
	$objtheme->addProperty($title,'videoDefaultVolume','', $_POST['SpiderFC_videoDefaultVolume'],$themeDefault,$id);
	
	$objtheme->addProperty($title,'videoAutoplay','', $_POST['SpiderFC_videoAutoplay'],$themeDefault,$id);
	$objtheme->addProperty($title,'mediaBgColor','',$_POST['SpiderFC_mediaBgColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'mediaCtrlsBgColor','', $_POST['SpiderFC_mediaCtrlsBgColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'mediaCtrlsBgAlpha','', $_POST['SpiderFC_mediaCtrlsBgAlpha'],$themeDefault,$id);
	$objtheme->addProperty($title,'mediaCtrlsColor','', $_POST['SpiderFC_mediaCtrlsColor'],$themeDefault,$id);	
//	$objtheme->addProperty($title,'mediaCtrlsHoverColor','', $_POST['SpiderFC_mediaCtrlsHoverColor'],$themeDefault,$id);
	$objtheme->addProperty($title,'mediaCtrlsAlpha','', $_POST['SpiderFC_mediaCtrlsAlpha'],$themeDefault,$id);



	
	//$objtheme->properties = $properties;
		
	if(isset($id))
	{
		$objtheme->SaveToDB($id);
	}	
		
}
function save_calendars($id){
	include_once('include/spiderfcCalendar.php');
	$obj = new SpideFCCalendar($id);
	
	$obj->title =  $_POST['SpiderFC_Calendar'];
	$obj->theme =  $_POST['SpiderFC_caltheme'];
	$obj->published =  $_POST['SpiderFC_published'];
	$obj->ChangeToDB($id);
}

/*Edit calendars list */
function edit_Calendars($id){
	
	global $wpdb;
	
	$title = "";
	$theme_id = 0;
	$published = "";
	
	include_once('include/spiderfcCalendar.php');
		
	$objcalendar = new SpideFCCalendar($id);

	$themeresult =$wpdb->get_results("SELECT DISTINCT title, theme_id, theme_default FROM ".$wpdb->prefix."spiderfc_theme ");
	
	if($id!=-1)
	{
	echo "<h2>" .__( 'Spider FC Calendar') . "</h2>"; 
	}
	else {echo "<h2>" .__( 'Spider FC Calendar - Add') . "</h2>";}
	
	if($id!=-1)
	{
		$title = $objcalendar->title;
		$theme_id = $objcalendar->theme;
		$published = $objcalendar->published;
	}else{
		$theme_id = $wpdb->get_row("SELECT DISTINCT theme_id FROM ".$wpdb->prefix."spiderfc_theme WHERE theme_default='1'")->theme_id;
		
	}
	
	?>
    <div style="visibility:hidden; height:0px" id="title_Required_Field" class="updated"><p><strong><?php _e('"Title" Required Field' ); ?></strong></p></div>
	<form action="admin.php?page=SpiderFC&task=save&id=<?php echo $id;?>" method="post" name="formm" id="parametrs_for_local_fc" >
    <table class="form-table">
    <tr><th style="min-width:100px"><?php _e("Title:"); ?></th><td>
    <input type="text" name="SpiderFC_Calendar"  value="<?php echo $title;?>" id="title_for_spider_fc" /></td></tr>
      <tr><th><?php _e("Theme:"); ?></th><td>
   
    <select name="SpiderFC_caltheme" >
    <?php foreach ($themeresult as $theme ) {
		 
		?><option value="<?php echo $theme->theme_id;?>" <?php if( $theme->theme_id == $theme_id) echo 'selected="selected"'; ?>>
														 <?php echo $theme->title;?></option><?php 	
	}
		?>   	
    
    </select></td></tr>
     <tr><th style="min-width:100px"><?php _e("Published:"); ?></th><td>
    <input type="radio" value="0" name="SpiderFC_published" <?php if($published == 0) echo 'checked="checked"';?>/>No
    <input type="radio" value="1" name="SpiderFC_published"  <?php if($published == 1) echo 'checked="checked"';?> <?php if($published=="") echo 'checked="checked"'; ?>/>Yes
    </td></tr>
    </table><?php $i ="apply";?>
      <p class="submit">
     	<input type="hidden" id="fc_hidden1" name="send" value="save" />
        <input type="hidden" name="snd" value="save" />
        <input type="button" value="<?php _e('Save') ?>"   onclick="if(document.getElementById('title_for_spider_fc').value==''){document.getElementById('title_Required_Field').style.visibility='visible'; document.getElementById('title_Required_Field').style.height='30px';} else {document.getElementById('parametrs_for_local_fc').submit() }" name="Submit" /> 
        <input type="button" onclick="if(document.getElementById('title_for_spider_fc').value==''){document.getElementById('fc_hidden1').value='<?php echo $i ?>';document.getElementById('title_Required_Field').style.visibility='visible'; document.getElementById('title_Required_Field').style.height='30px';} else {document.getElementById('parametrs_for_local_fc').action='admin.php?page=SpiderFC&task=apply&id=<?php echo $id;?>'; document.getElementById('parametrs_for_local_fc').submit()}" value="<?php _e('Apply') ?>" /> 
        <input type="button" name="cancel" value="Cancel" onclick="window.location.href='admin.php?page=SpiderFC<?php if($id!=-1) echo "&task=SpiderFC&id=".$id.""?>'" />
        </p>
    </form>
	
	<?php
}

function spider_mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
			'wmv' =>'video/wmv',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        else {
			$parsed_url = parse_url($filename);
			if($parsed_url['host'] == 'youtube.com' || $parsed_url['host'] == 'www.youtube.com' || $parsed_url['host'] == 'youtu.be' || $parsed_url['host'] == 'www.youtu.be' ){				
				return 'youtube';
			}else{
            	return 'application/octet-stream';
			}
        }
    }

function checkType($path){
	
	$type =	spider_mime_content_type($path);
	$ex = explode('/',$type);
		if($ex[0]== 'image' ){
			return 'image';
		}else if($ex[0]=='video')
		{
			return 'vidHttp';
		}else if($ex[0]=='youtube') {			
			
				return 'vidYoutube';
		}		
	
}

function Change_CalendarsEvents($id, &$idevent = -1){
		 
 if(!empty($_REQUEST['send']) )
	{
		include_once('include/spiderfcEvents.php');
			$eventsobj = new SpiderFCEvents($idevent);
			
			
			$eventsobj->id_calendar = $id;
			$eventsobj->calendar = $_POST['SpiderFC_EventTitle'];
			$eventsobj->date_begin = $_POST['SpiderFC_date1'];
			$eventsobj->date_end = $_POST['SpiderFC_date2'];
			if($_POST['SpiderFC_time1']=="" && $_POST['SpiderFC_minut1']=="") 
			$eventsobj->event_time_begin='';
			else
			$eventsobj->event_time_begin = $_POST['SpiderFC_time1'].":".$_POST['SpiderFC_minut1'];
			if($_POST['SpiderFC_time2']=="" && $_POST['SpiderFC_minut2']=="")
			$eventsobj->event_time_end='';
			else
			$eventsobj->event_time_end = $_POST['SpiderFC_time2'].":".$_POST['SpiderFC_minut2'];
			$eventsobj->title = $_POST['SpiderFC_EventTitle'];
			if( $_POST['SpiderFC_eventtype'] == "text")
				$eventsobj->text = $_POST['texthtml'];
			else
				$eventsobj->html = $_POST['content'];
				
			$eventsobj->css = $_POST['Spiderfc_eventcss'];			
			$eventsobj->htmlUrl = $_POST['SpiderFC_htmlurl'];
					
		
			$eventsobj->type = $_POST['SpiderFC_type'];
			$eventsobj->priority = $_POST['SpiderFC_priority'];
			
			$eventsobj->event_type =  $_POST['SpiderFC_eventtype'];
			
			if(is_array($_POST['post_image'])){
				foreach($_POST['post_image'] as $rows){
					
					$linktype = checkType($rows);
					if($rows !="")
						$eventsobj->items .= 'type='.$linktype.','."url=".$rows.";";
				}
			}
			
			
			$eventsobj->published = $_POST['SpiderFC_published']; 
			
		
			$eventsobj->ChangeToDB($idevent);
			if($idevent == -1)
				$idevent = $eventsobj->getNewID();
			
	
			
	}	 
	
}
function edit_CalendarsEvents($id, $idevent = -1){

	global $wpdb;
	$events = array();
	if($idevent != -1)
		$events = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."spiderfc_events WHERE id='".$idevent."'");
		
	?>
	 <div style="visibility:hidden; height:0px" id="title_Required_Field" class="updated"><p><strong><?php _e('"Title" Required Field' ); ?></strong></p></div>

        
            
         <?php 
		 
		 $get_title1=$wpdb->get_results("SELECT title FROM ".$wpdb->prefix."spiderfc_calendar WHERE id=".$id);
		 $spiderfc_title='Add SpiderFC Event - '.$get_title1[0]->title;   echo "<h2>" . __($spiderfc_title) . "</h2>"; ?>
         
	<form action="admin.php?page=SpiderFC&task=events&action=edit&id=<?php echo $id;?>&idevent=<?php echo $idevent;?>" method="post" name="formm" id="form_for_edit_item_into_FC" class="parametrs_for_local_fc" >
    <table class="form-table">
    <tr><th style="min-width:50px"><label><?php _e("Title:"); ?></label></th><td>
    <input type="text" name="SpiderFC_EventTitle"  value="<?php echo $events->title;?>" id="title_for_spider_fc" /></td></tr>
    
    <tr><th style="min-width:50px"><label><?php _e("Time:"); ?></label></th><td>
            <input type="text" id="selhour" name="SpiderFC_time1" value="<?php if($events->event_time_begin!="00:00:00"){if($events->event_time_begin !=':'){ echo substr($events->event_time_begin,0,2);} }?>" style="width:30px" onkeypress="return checkhour('selhour')" onblur="add_0('selhour')" />:
        <input type="text" id="selminute" name="SpiderFC_minut1" value="<?php if($events->event_time_begin!="00:00:00"){if($events->event_time_begin !=':'){ echo substr($events->event_time_begin,3,2);}} ?>" style="width:30px" onkeypress="return checkminute('selminute')"  onblur="add_0('selminute')"  /> -
       
       <input type="text" id="selhour2" name="SpiderFC_time2" value="<?php if($events->event_time_end!="00:00:00"){if($events->event_time_end !=':'){ echo substr($events->event_time_end,0,2);}} ?>" style="width:30px" onkeypress="return checkhour('selhour2')" onblur="add_0('selhour2')" />:
        <input type="text" id="selminute2" name="SpiderFC_minut2" value="<?php if($events->event_time_end!="00:00:00"){if($events->event_time_end !=':'){ echo substr($events->event_time_end,3,2);}} ?>" style="width:30px" onkeypress="return checkminute('selminute2')"  onblur="add_0('selminute2')"  />

    </td>
    </tr>
      <tr><th style="min-width:100px"><label><?php _e("Date:"); ?></label></th><td>
    <input type="text" name="SpiderFC_date1"  value="<?php if(isset($events->date_begin)) {echo $events->date_begin;} else {echo date('Y-m-d');} ?>" id="popupDateField1" class="tcal"  /> -
    <input type="text" name="SpiderFC_date2"  value="<?php if(isset($events->date_end)) {echo $events->date_end;} else {echo date('Y-m-d');} ?>" id="popupDateField2" class="tcal" /> </td></tr>
    
     <tr>
   
   
   
    <td><strong><label><?php _e("Add items:"); ?></strong></td>
        <td>Add Image, Video or Video from Youtube
          <a class="button lu_upload_button" id="add" href="#" >Select</a>
        <div class="inputs"> 
		<?php if(isset($events->items) ){ 
				$items = explode(";",$events->items); 
				$j=0;
				foreach($items as $item){
					if($item !=""){
						$item1 = explode(',',$item);
						$item2 = explode('=',$item1[0]);
					?> <div><div id="imgurl_<?php echo $j?>" class="imgurl"><div><?php echo $item1[1]; ?> </div><div style="font-size:9px">Type=<?php echo $item2[1]?></div></div><a href="#" onclick="RemoveTag(<?php echo $j?>)" id="remove_<?php echo $j?>" >Remove</a></div><input type="hidden" class="text_input" name="post_image[]" id="post_image_<?php echo $j?>" value="<?php echo substr($item1[1],4,strlen($item)-4); ?>" /> <div class="clear"></div><?php
					$j++;
					}
				} 
			}?>  </div> 

         
	<script type="text/javascript">
		var k = 0;	

		jQuery(function() {
		
	 	var i = jQuery('.text_input').size();

		jQuery('#add').click(function() { // bind click event to out form button

	 		i++;
			 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true'); /* type= can be image too, browse codex for another option*/
			 return false;
		});
		 

		window.send_to_editor = function(html) {<?php /*echo $row->image;*/?> /* when insert into post is clicked */
	
		
		imgurl = jQuery('img',html).attr('src');

		if(  imgurl == undefined ){	
		
			imgurl = jQuery(html).attr('href');
		
			if(imgurl == undefined)	
				imgurl = jQuery(html).attr('src');
		}
	
			
			if(k > 0){ 
				i = i-k;
			}			
			k =0;
			 jQuery('.inputs').append('<div><div id="imgurl_'+i+'" class="imgurl">'+imgurl+'</div><a href="#" onclick="RemoveTag('+i+')" id="remove_'+i+'" >Remove</a> <input type="hidden" class="text_input" name="post_image[]" id="post_image_'+i+'" value="'+imgurl+'" /> <div class="clear"></div> </div>');
       		 
			 tb_remove();
		
		};	
	jQuery(".inline").colorbox({inline:true, height: "480px", width: "700px", scrolling: true});
	
});


 </script>
    

</td>
        </tr>
    
    <tr><th style="min-width:100px"><label><?php _e("Event type:"); ?></label></th><td>
  	<input type="radio" name="SpiderFC_eventtype"  value="text" onchange="change_event_type('text')" <?php if($events->event_type == "text") echo 'checked="checked"';else if(!isset($events->event_type)) echo 'checked="checked"'; ?>/> Text 
    <input type="radio" name="SpiderFC_eventtype"  value="html" onchange="change_event_type('html')" <?php if($events->event_type == "html") echo 'checked="checked"';  ?>/>HTML </td></tr>
    
    <tr style="height:300px;"><th style="min-width:100px"><label><?php _e("Text:"); ?></label></th><td >
       <!-- Start Editor -->
       <?php if( $events->event_type == "html" )
	   { ?>
       <script type="text/javascript">
	   	jQuery(function() { change_event_type('html');});	
	   </script>
	   <?php
		 
		 }else{
			  ?>
       <script type="text/javascript">
	   		jQuery(function() { change_event_type('text');});
	   </script>
	   <?php
			 
			}
	   
	   ?>
       <textarea id="html" name="texthtml" cols="35" rows="6" style="width:100%; height:250px;" class="mce_editable"> <?php echo $events->text;?></textarea>
    <div  id="poststuff" style="width: 600px;" >
<div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea" ><?php the_editor( $events->html);  ?>
</div>
</div>
    </td></tr>    
   
   <tr class="hidetext"><th style="min-width:100px"><label><?php _e("CSS:"); ?></label></th><td>
  	<textarea name="Spiderfc_eventcss" rows="5" cols="30"><?php echo $events->css;?> </textarea></td></tr>
    
    <tr class="hidetext"><th style="min-width:100px"><label><?php _e("HTML URL:"); ?></label></th><td>
	 <?php if(isset( $events->htmlUrl)){
		$ID = explode('page_id=',$events->htmlUrl);
		if(isset($ID[1]))
		$html_url = get_the_title($ID[1]);
		else $html_url="";
		
	}

?>
<div id="dialog-view"> <?php echo $html_url;?></div>



	<?php
    if($html_url!="")
	{
		
	?>
    <p><a class="inline"  style="display:none" href="#htmlurlfrm">Select a Page</a></p>
    
	<p><a href="#htmlurl" class="remove" onclick="Remove()">Remove Page</a> </p>
	<?php } 
	else
	{
	?>
    <p><a class="inline"   href="#htmlurlfrm">Select a Page</a></p> 
	<p><a href="#htmlurl" style="display:none" class="remove" onclick="Remove()">Remove Page</a> </p>
    <?php }?>
 




  <input type="hidden" name="SpiderFC_htmlurl" id="htmlurl" value="<?php echo $events->htmlUrl;?>">
  
 
  
  <div style='display:none'>
			<div id='htmlurlfrm' style='padding:10px; background:#fff;'>
<table class="widefat">
 <thead>
 <TR>
 <th>ID</th>
 <th>Title</th>
 <th>Author</th>
 <th>Published</th>
 <th>Date</th>

 </TR>
 </thead>
 
 <tbody>
 

 <?php //get_page_link
  $pages = get_pages(); 

  foreach ( $pages as $page ) {
	
	$contentpath = plugins_url( '' , __FILE__ ).'/content.php?page_id='.$page->ID;
   
   ?><tr><td> <?php echo  $page->ID;?></td><td> <a href="#" onclick="getArticle('<?php echo $page->ID; ?>','<?php echo esc_attr($page->post_title)?> ','<?php echo $contentpath; /*get_page_link($page->ID);*/ ?>')">
   <?php echo  esc_attr($page->post_title ); ?> </a></td> <td><?php echo get_userdata( $page->post_author)->display_name;?></td>
    <td><?php if($page->post_status =="publish") echo "Yes"; else echo "No"; ?></td><td><?php echo  esc_attr($page->post_date );?></td> </tr>
   <?php
	  }
 ?>
 </tbody>
</table>

</div>
		</div>
    
    </td></tr>
     
    
    <tr><th style="min-width:100px"><label><?php _e("Type:"); ?></label></th><td>
    <input type="text" name="SpiderFC_type"  value="<?php echo $events->type;?> " size="50" />
    </td></tr> 
     <tr><th style="min-width:100px"><label><?php _e("Priority:"); ?></label></th><td>
   <select name="SpiderFC_priority">

    <option value="0" <?php if($events->priority == 0)echo 'selected="selected"'; ?> >No Priority</option>
    <option value="1" <?php if($events->priority == 1)echo 'selected="selected"'; ?> >Low Priority</option>
    <option value="2" <?php if($events->priority == 2)echo 'selected="selected"'; ?> >Medium Priority </option>
    <option value="3" <?php if($events->priority == 3)echo 'selected="selected"'; ?> >High Priority</option>
   
   </select>
    </td></tr>
    
     <tr><th style="min-width:100px"><label><?php _e("Published:"); ?></label></th><td>
   <input type="radio" name="SpiderFC_published"  value="0" <?php if($events->published == 0)echo 'checked="checked"'; ?>  />
	<label>No</label>
	<input type="radio" name="SpiderFC_published"  value="1"  <?php if($events->published == 1)echo 'checked="checked"';else if(!isset($events->published)) echo 'checked="checked"'; ?> />
	<label >Yes</label>
    </td></tr> 
    
     </table><?php $i ="apply";?>
      <p class="submit">
        <input type="hidden" id="Spider_fc_hidden" name="send" value="save" />
        <input type="hidden" name="snd" value="save" />
        <input type="button" value="Save Changes" onclick="if(document.getElementById('popupDateField1').value) {document.getElementById('form_for_edit_item_into_FC').submit();} else { document.getElementById('dont_date').style.visibility='visible'; document.getElementById('dont_date').style.height='90px'} " />
        <input type="button" onclick="if(document.getElementById('popupDateField1').value){document.getElementById('Spider_fc_hidden').value='<?php echo $i ?>';document.getElementById('form_for_edit_item_into_FC').submit();} else { document.getElementById('dont_date').style.visibility='visible'; document.getElementById('dont_date').style.height='30px'}" value="Apply"  />

        <input type="button" onclick="window.location.href='admin.php?page=SpiderFC&task=events&id=<?php echo $id;?>'" value="Cancel" />
        </p>
        </form>
       
		
    <?php

} 

function edit_Theme($id)
{
	
	global $wpdb;
	$objtheme = new SpiderFCTheme($id);

	$theme_ids=array(1,2,3,4,5,6,7,8,9,10);
	?>
    <script>
	
	jQuery(function() {

		change_theme_slider('mediaCtrlsAlpha', 'slider-mediaCtrlsAlpha' );
		change_theme_slider('mediaCtrlsBgAlpha', 'slider-mediaCtrlsBgAlpha' );
		change_theme_slider('videoDefaultVolume', 'slider-videoDefaultVolume' );
	});

	</script>		
    <form name="formm" id="parametrs_for_local_fc" method="post" action="admin.php?page=spfcthemes&task=save&id=<?php echo $id;?>">  
        <input type="hidden" name="spider_add_parametrs" value="<?php echo $id; ?>">  
        <div style="visibility:hidden; height:0px" id="title_Required_Field" class="updated"><p><strong><?php _e('"Title" Required Field' ); ?></strong></p></div>
        <?php 
		 if($id==-1){  
			 echo "<h2>" .__( 'Spider FC Parameters - Add') . "</h2>"; 
			
			 $objtheme->SetPropertyTheme();
		 } else {
			 $param_name = 'Spider FC Parameters';//.$title; 
			 echo  "<h2>" .__( $param_name) . "</h2>";
			 
		}
		?>  
        
      <div id="themeparams">
       <div class="divfieldset">
       <?php if($id==-1) { ?>
       
       <b><i><?php _e("Inherit from theme:"); ?></i></b>
       <select name="SpiderFC_themeDefault" id="slect_theme" onchange="set_theme()" >
					<option value="0"> Custom </option>
					<option value="1"> Simple blue </option>
					<option value="2"> Black </option>
					<option value="3"> Simple grey </option>
					<option value="4"> Light brown </option>
					<option value="5"> Red blur </option>
					<option value="6"> Dodger Blue </option>
					<option value="7"> Indian Red </option>
					<option value="8"> Sky blue </option>
					<option value="9"> Midnight blue </option>
					<option value="10"> Baby blue </option>
					</select>
         
    <?php
	   }
	 
	 
	 
	$theme_id1 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."spiderfc_theme WHERE theme_id=".$id." LIMIT 0, 56");

		$array = array(
    "startWithMonday" => "",
   	"dateFormat" => "",
	"dateFormatShort" => "",
	"time" => "",
	"appMaxWidth" => "",
	"appMaxHeight" => "",
	"appMinWidth" => "",
	"appMinHeight" => "",
	"startViewSize" => "",
	"startViewState" => "",
	"bgColors" => "",
	"bgCornerRadius" => "",
	"strokeColor" => "",
	"headerHeight" => "",
	"headerPadding" => "",
	"headerBgColors" => "",
	"headerBgStrokeColor" => "",
	"headerContentColor" => "",
	"headerContentStrokeColor" => "",
	"headerFontSize" => "",
	"daysNamesColor" => "",
	"daysNamesFontSize" => "",
	"datesBgColors" => "",
	"priority0Color" => "",
	"priority1Color" => "",
	"priority2Color" => "",
	"priority3Color" => "",
	"dateFontSize" => "",
	"dateColor" => "",
	"dateStrokeColor" => "",
	"showDateEventsCount" => "",
	"dateEventsCountFontSize" => "",
	"dateEventsCountColor" => "",
	"eventsListHeaderHeight" => "",
	"eventsListHeaderbgColors" => "",
	"eventsListHeaderColor" => "",
	"eventsListHeaderFontSize" => "",
	"eventHeaderHeight" => "",
	"eventHeaderFontSize" => "",
	"eventHeaderColor" => "",
	"eventContentBgColors" => "",
	"eventContentDatesFontSize" => "",
	"eventContentDatesColor" => "",
	"eventContentDescriptionFontSize" => "",
	"eventContentDescriptionColor" => "",
	"footerHeight" => "",
	"footerColor" => "",
	"mediaDefaultAutoplay" => "",
	"mediaScaleType" => "",
	"mediaShowDuration" => "",
	"videoDefaultVolume" => "",
	"videoAutoplay" => "",
	"mediaBgColor" => "",
	"mediaCtrlsBgColor" => "",
	"mediaCtrlsBgAlpha" => "",
	"mediaCtrlsColor" => "",
	"mediaCtrlsAlpha" => ""	
);

foreach($theme_id1 as $choosen_theme)
{
	$array[$choosen_theme->paramsname]=$choosen_theme->paramsvalue;
}
	 ?>
         
                
       <fieldset ><legend>General Parameters </legend>     
     <table class="form-table">
      
	<tr><th style="min-width:100px"><?php _e("Title:"); ?></th>
   <td> <input  type="text" id="title" name="SpiderFC_themeTitle" value="<?php if($id!=-1) {echo $objtheme->properties[0]->title; }?>" size="20"  /></td>
                   </tr>

					<tr><th style="min-width:100px"><?php _e("Start week with monday"); ?></th>
                   <td> <input  type="radio" name="SpiderFC_Width_in_monday" value="0" id="startWithMonday1" size="20" <?php if($array['startWithMonday'] == 0){ echo 'checked="checked"';} ?> /> NO 
                   <input type="radio"  name="SpiderFC_Width_in_monday" value="1" id="startWithMonday2" size="20"  <?php  if($array['startWithMonday'] == 1){ echo 'checked="checked"';} ?> /> Yes</td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Date Format"); ?></th>
                   <td><input  type="text" id="dateFormat" name="SpiderFC_dateFormat" value="<?php echo $array['dateFormat'];?>" size="20" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Date Format Short"); ?></th>
                   <td><input  type="text" id="dateFormatShort" name="SpiderFC_dateFormatShort" value="<?php echo $array['dateFormatShort'];?>" size="20" /></td>
                   </tr>
                   
					<tr><th style="min-width:100px"><?php _e("Time 12 Hours"); ?></th>
                   <td><input  type="radio" name="SpiderFC_time" id="time12Hours1" value="0" <?php  if($array['time'] == 0){ echo 'checked="checked"';}?> />NO <input type="radio" name="SpiderFC_time" id="time12Hours2" value="1"  <?php  if($array['time'] == 1){ echo 'checked="checked"';} ?> /> Yes</td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Width in the large mode"); ?></th>
                   <td><input  type="text" id="appMaxWidth" name="SpiderFC_appmaxWidth" value="<?php echo $array['appMaxWidth'];?>" size="20" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Height in the large mode"); ?></th>
                   <td><input  type="text" id="appMaxHeight" name="SpiderFC_appmaxHeight" value="<?php echo $array['appMaxHeight'];?>" size="20" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Width in the small mode"); ?></th>
                   <td><input  type="text" id="appMinWidth" name="SpiderFC_appminWidth" value="<?php echo $array['appMinWidth'];?>" size="20" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Height in the small mode:"); ?></th>
                   <td><input  type="text" id="appMinHeight" name="SpiderFC_appminHeight" value="<?php echo $array['appMinHeight'];?>" size="20" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Size mode at start"); ?></th>
                   <td>
                   <select name="SpiderFC_startViewSize" id="startViewSize"> 
                   <option value="viewSizeMax" <?php if($array['startViewSize'] == "viewSizeMax"){ echo 'selected="selected"';} ?>>Max Size</option>
                   <option value="viewSizeMin" <?php if($array['startViewSize'] == "viewSizeMin"){ echo 'selected="selected"';} ?>>Min Size</option>
                   </select>
                   </td></tr>
                   
                   <tr><th style="min-width:100px"><?php _e("View mode at start"); ?></th>
                   <td>
                   <select name="SpiderFC_startViewState" id="startViewState"> 
                   <option value="viewStateDays"   <?php if($array['startViewState'] == "viewStateDays"){ echo 'selected="selected"';}?>>Days</option>
                   <option value="viewStateMonths" <?php if($array['startViewState'] == "viewStateMonths"){ echo 'selected="selected"';}?>>Months</option>
                   <option value="viewStateYears"  <?php if($array['startViewState'] == "viewStateYears"){ echo 'selected="selected"';}?>>Years</option>
                   </select>
                   </td></tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Main background color(gradient)"); $bgcl = explode(" ", $array['bgColors']);?></th>
                   <td>                 
                   <input  type="text" id="bgColors1" name="SpiderFC_bgColors1" value="<?php echo $bgcl[0];?>" size="5"  class="color"/> &nbsp;
                   <input  type="text" id="bgColors2" name="SpiderFC_bgColors2" value="<?php echo $bgcl[1];?>" size="5"  class="color" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Main border radius"); ?></th>
                   <td><input  type="text" id="bgCornerRadius" name="SpiderFC_bgCornerRadius" value="<?php echo $array['bgCornerRadius'];?>" size="20" /> </td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Main border color"); ?></th>
                   <td><input  type="text" id="bgStrokeColor" name="SpiderFC_strokeColor" value="<?php echo $array['strokeColor'];?>" size="20"  class="color" /> </td>
                   </tr></table></fieldset></div>
                   
                   <div class="divfieldset" <?php if($id==-1){?> style="margin-top:26px;" <?php } ?>> <fieldset ><legend>Header Parameters </legend>     
                     <table class="form-table">
                     <tr><th style="min-width:100px"><?php _e("Header height"); ?></th>
                   <td><input  type="text" id="headerHeight" name="SpiderFC_headerHeight" value="<?php echo $array['headerHeight'];?>" size="20" /> </td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Header padding"); ?></th>
                   <td><input  type="text" id="headerPadding" name="SpiderFC_headerPadding" value="<?php echo $array['headerPadding'];?>" size="20" /> </td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Header background color (gradient)"); $hdcol = explode(" ", $array['headerBgColors']);?></th>
                   <td>                 
                   <input  type="text" id="headerBgColors1" name="SpiderFC_headerBgColors1" value="<?php echo $hdcol[0];?>" size="5"  class="color" /> &nbsp;
                   <input  type="text" id="headerBgColors2" name="SpiderFC_headerBgColors2" value="<?php echo $hdcol[1];?>" size="5" class="color" /></td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Header border color"); ?></th>
                   <td><input  type="text" id="headerBgStrokeColor" name="SpiderFC_headerBgStrokeColor" value="<?php echo $array['headerBgStrokeColor'];?>" size="20" class="color" /> </td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Header content color"); ?></th>
                   <td><input  type="text" id="headerContentColor" name="SpiderFC_headerContentColor" value="<?php echo $array['headerContentColor'];?>" size="20" class="color" /> </td>
                   </tr>
                   
					                   
                   <tr><th style="min-width:100px"><?php _e("Header content stroke color"); ?></th>
                   <td><input  type="text" id="headerContentStrokeColor" name="SpiderFC_headerContentStrokeColor" value="<?php echo $array['headerContentStrokeColor'];?>" size="20" class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Header content font size"); ?></th>
                   <td><input  type="text" id="headerFontSize" name="SpiderFC_headerFontSize" value="<?php echo $array['headerFontSize'];?>" size="20" /> </td>
                   </tr>
                   
                   
                   <tr><td coslpan="2">
                    <?php if($id!=-1 && $id<10) { ?>	
					<img onclick="reset_theme_<?php echo $id ?>();" src="<?php echo plugins_url( 'images/reset_theme.png' , __FILE__ )?>" />
					 </td></tr>
					<?php } ?>

                     </table></fieldset></div><div class="clear"></div>
					 
                     <div class="divfieldset">
                    <fieldset ><legend>Body Parameters </legend>     
                     <table class="form-table">
                    <tr><th style="min-width:100px"><?php _e("Weekdays text color"); ?></th>
                   <td><input  type="text" id="daysNamesColor" name="SpiderFC_daysNamesColor" value="<?php echo $array['daysNamesColor'];?>" size="20" class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Weekdays text font size:");?></th>
                   <td><input  type="text" id="daysNamesFontSize" name="SpiderFC_daysNamesFontSize" value="<?php echo $array['daysNamesFontSize'];?>" size="20" /> </td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Days background color (gradient)"); $dayscl = explode(" ", $array['datesBgColors']);?></th>
                   <td><input  type="text" id="datesBgColors1" name="SpiderFC_datesBgColors1" value="<?php echo $dayscl[0];?>" size="5" class="color"/>  &nbsp;
                   <input  type="text" id="datesBgColors2" name="SpiderFC_datesBgColors2" value="<?php echo $dayscl[1];?>" size="5" class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Background color of a cell with event with no priority"); ?></th>
                   <td><input  type="text" id="priority0Color" name="SpiderFC_priority0Color" value="<?php echo $array['priority0Color'];?>" size="20"  class="color"/> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Background color of a cell with event with low priority"); ?></th>
                   <td><input  type="text" id="priority1Color" name="SpiderFC_priority1Color" value="<?php echo $array['priority1Color'];?>" size="20"  class="color"/> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Background color of a cell with event with medium priority"); ?></th>
                   <td><input  type="text" id="priority2Color" name="SpiderFC_priority2Color" value="<?php echo $array['priority2Color'];?>" size="20" class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Background color of a cell with event with high priority"); ?></th>
                   <td><input  type="text" id="priority3Color" name="SpiderFC_priority3Color" value="<?php echo $array['priority3Color'];?>" size="20"  class="color"/> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Cell content font size"); ?></th>
                   <td><input  type="text" id="dateFontSize" name="SpiderFC_dateFontSize" value="<?php echo $array['dateFontSize'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Cell content color"); ?></th>
                   <td><input  type="text" id="dateColor" name="SpiderFC_dateColor" value="<?php echo $array['dateColor'];?>" size="20"  class="color"/> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Current day cell border color"); ?></th>
                   <td><input  type="text" id="dateStrokeColor" name="SpiderFC_dateStrokeColor" value="<?php echo $array['dateStrokeColor'];?>" size="20" class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Show number of events:"); ?></th>
                   <td><input type="radio" name="SpiderFC_showDateEventsCount" id="showDateEventsCount1" value="0" <?php if($array['showDateEventsCount'] == 0){ echo 'checked="checked"';}?> /> NO 
                   <input type="radio" name="SpiderFC_showDateEventsCount" id="showDateEventsCount2" value="1" <?php if($array['showDateEventsCount'] == 1){ echo 'checked="checked"';}?> /> Yes </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Number of events font size"); ?></th>
                   <td><input  type="text" id="dateEventsCountFontSize" name="SpiderFC_dateEventsCountFontSize" value="<?php echo $array['dateEventsCountFontSize'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Number of events color:"); ?></th>
                   <td><input  type="text" id="dateEventsCountColor" name="SpiderFC_dateEventsCountColor" value="<?php echo $array['dateEventsCountColor'];?>" size="20"  class="color"/> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Events list header height"); $evtlistcl = explode(" ", $array['eventsListHeaderHeight']);?></th>
                   <td><input  type="text" id="eventsListHeaderHeight" name="SpiderFC_eventsListHeaderHeight" value="<?php echo $evtlistcl[0];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Events list header background color (gradient)"); $evtcl = explode(" ", $array['eventsListHeaderbgColors']);?></th>
                   <td><input  type="text" id="eventsListHeaderbgColors1" name="SpiderFC_eventsListHeaderbgColors1" value="<?php echo $evtcl[0];?>" size="5" class="color" />  &nbsp;
                   <input  type="text" id="eventsListHeaderbgColors2" name="SpiderFC_eventsListHeaderbgColors2" value="<?php echo $evtcl[1];?>" size="5"  class="color"/></td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Events list header content color"); ?></th>
                   <td><input  type="text" id="eventsListHeaderColor" name="SpiderFC_eventsListHeaderColor" value="<?php echo $array['eventsListHeaderColor'];?>" size="20"  class="color"/> </td>
                   </tr>
                   
                   <tr><th style="min-width:100px"><?php _e("Events list header content font size"); ?></th>
                   <td><input  type="text" id="eventsListHeaderFontSize" name="SpiderFC_eventsListHeaderFontSize" value="<?php echo $array['eventsListHeaderFontSize'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event header height"); ?></th>
                   <td><input  type="text" id="eventHeaderHeight" name="SpiderFC_eventHeaderHeight" value="<?php echo $array['eventHeaderHeight'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event header content font size"); ?></th>
                   <td><input  type="text" id="eventHeaderFontSize" name="SpiderFC_eventHeaderFontSize" value="<?php echo $array['eventHeaderFontSize'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event header content color"); ?></th>
                   <td><input  type="text" id="eventHeaderColor" name="SpiderFC_eventHeaderColor" value="<?php echo $array['eventHeaderColor'];?>" size="20" class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event content background color (gradient)"); $evtconbg = explode(" ", $array['eventContentBgColors']);?></th>
                   <td><input  type="text" id="eventContentBgColors1" name="SpiderFC_eventContentBgColors1" value="<?php echo $evtconbg[0];?>" size="5"  class="color"/> &nbsp;
                   <input  type="text" id="eventContentBgColors2" name="SpiderFC_eventContentBgColors2" value="<?php echo $evtconbg[1];?>" size="5"  class="color"/></td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event content dates font size"); ?></th>
                   <td><input  type="text" id="eventContentDatesFontSize" name="SpiderFC_eventContentDatesFontSize" value="<?php echo $array['eventContentDatesFontSize'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event content dates color"); ?></th>
                   <td><input  type="text" id="eventContentDatesColor" name="SpiderFC_eventContentDatesColor" value="<?php echo $array['eventContentDatesColor'];?>" size="20"  class="color"/> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event content description font size"); ?></th>
                   <td><input  type="text" id="eventContentDescriptionFontSize" name="SpiderFC_eventContentDescriptionFontSize" value="<?php echo $array['eventContentDescriptionFontSize'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Event content description color"); ?></th>
                   <td><input  type="text" id="eventContentDescriptionColor" name="SpiderFC_eventContentDescriptionColor" value="<?php echo $array['eventContentDescriptionColor'];?>" size="20"  class="color" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Footer height"); ?></th>
                   <td><input  type="text" id="footerHeight" name="SpiderFC_footerHeight" value="<?php echo $array['footerHeight'];?>" size="10" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Footer content color"); ?></th>
                   <td><input  type="text" id="footerColor" name="SpiderFC_footerColor" value="<?php echo $array['footerColor'];?>" size="20"  class="color"/> </td>
                   </tr> </table></fieldset></div>
                   
                   <div class="divfieldset">
                    <fieldset ><legend>Media Parameters </legend>     
                     <table class="form-table">
                     <tr><th style="min-width:100px"><?php _e("Media autoplay at start"); ?></th>
                   <td><input type="radio" name="SpiderFC_mediaDefaultAutoplay" id="mediaDefaultAutoplay1" value="0" <?php if($array['mediaDefaultAutoplay'] == 0){ echo 'checked="checked"';}?> /> NO 
                   <input type="radio" name="SpiderFC_mediaDefaultAutoplay" id="mediaDefaultAutoplay2" value="1" <?php if($array['mediaDefaultAutoplay'] == 1){ echo 'checked="checked"';}?> /> Yes</td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Media scale type"); ?></th>
                   <td> <select name="SpiderFC_mediaScaleType" id="mediaScaleType"> 
                   <option value="scaleTypeTouchFromInside"   <?php if($array['mediaScaleType'] == "scaleTypeTouchFromInside"){ echo 'selected="selected"';}?>>Inside</option>
                   <option value="scaleTypeTouchFromOutside" <?php if($array['mediaScaleType'] == "scaleTypeTouchFromOutside"){ echo 'selected="selected"';}?>>Outside</option>
                   <option value="scaleTypeStratch"  <?php if($array['mediaScaleType'] == "scaleTypeStratch"){ echo 'selected="selected"';}?>>Stratch</option>
                   </select></td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Media change duration"); ?></th>
                   <td><input  type="text" id="mediaShowDuration" name="SpiderFC_mediaShowDuration" value="<?php echo $array['mediaShowDuration'];?>" size="20" /> </td>
                   </tr>
				   
                   <tr><th style="min-width:100px"><?php _e("Video default volume:"); ?></th>
                   <td><input  type="text"  name="SpiderFC_videoDefaultVolume" id="videoDefaultVolume" value="<?php echo $array['videoDefaultVolume'];?>" style="width: 30px;" /> %   
                   <div id="slider-videoDefaultVolume" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" style="width:107px">	</div>          
				</td>
                   </tr
                   
                   ><tr><th style="min-width:100px"><?php _e("Video Autoplay in media slider"); ?></th>
                   <td><input type="radio" name="SpiderFC_videoAutoplay" id="videoAutoplay1" value="0" <?php if($array['videoAutoplay'] == 0){ echo 'checked="checked"';}?> /> NO 
                   <input type="radio" name="SpiderFC_videoAutoplay" id="videoAutoplay2" value="1" <?php if($array['videoAutoplay'] == 1){ echo 'checked="checked"';}?> /> Yes</td> 
                                     </tr>	
                                     	   
                   <tr><th style="min-width:100px"><?php _e("Media background color"); ?></th>
                  <td><input  type="text" id="mediaBgColor" name="SpiderFC_mediaBgColor" value="<?php echo $array['mediaBgColor'];?>" size="10"  class="color"/>  </td>  
                                     </tr>	
                                     				   
                   <tr><th style="min-width:100px"><?php _e("Media control buttons background color"); ?></th>
                <td><input  type="text" id="mediaCtrlsBgColor" name="SpiderFC_mediaCtrlsBgColor" value="<?php echo $array['mediaCtrlsBgColor'];?>" size="10"  class="color"/> </td>                       </tr>	
                				   
                   <tr><th style="min-width:100px"><?php _e("Media control buttons background transparency"); ?></th>
              <td><input  type="text" id="mediaCtrlsBgAlpha" name="SpiderFC_mediaCtrlsBgAlpha"   value="<?php echo $array['mediaCtrlsBgAlpha'];?>" style="width: 30px;" /> %
              
                   <div id="slider-mediaCtrlsBgAlpha" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" style="width:107px">	</div>
</td>                         </tr>	


				   
                   <tr><th style="min-width:100px"><?php _e("Media control buttons color"); ?></th>
            <td><input  type="text" id="mediaCtrlsColor" name="SpiderFC_mediaCtrlsColor" value="<?php echo $array['mediaCtrlsColor'];?>" size="10"  class="color"/> </td> 
                                      </tr>	
                                      				   
                   <tr><th style="min-width:100px"><?php _e("Media control buttons transparency"); ?></th>
          <td><input  type="text" id="mediaCtrlsAlpha" name="SpiderFC_mediaCtrlsAlpha"  value="<?php echo $array['mediaCtrlsAlpha'];?>" style="width: 30px;"/>%
                <div id="slider-mediaCtrlsAlpha" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" style="width:107px">	</div>

                    </td>                             </tr>	
                    
                    </table>					  
                    </fieldset></div></div>	    
	<div class="clear"></div>
    	
        
        <p class="submit"><?php $i ="apply";?>
		<input type="hidden" id="fc_hidden" name="send" value="save" />
        <input type="hidden" name="fsnd" value="save" />		
        <input type="button" name="Submit" value="<?php _e('Save') ?>" onclick="if(document.getElementById('title').value==''){document.getElementById('title_Required_Field').style.visibility='visible'; document.getElementById('title_Required_Field').style.height='30px';} else {document.getElementById('parametrs_for_local_fc').submit() }"/> 
		<input type="button" onclick="if(document.getElementById('title').value==''){document.getElementById('fc_hidden').value='<?php echo $i ?>';document.getElementById('title_Required_Field').style.visibility='visible'; document.getElementById('title_Required_Field').style.height='30px';} else {document.getElementById('parametrs_for_local_fc').action='admin.php?page=spfcthemes&task=apply&id=<?php echo $id;?>'; document.getElementById('parametrs_for_local_fc').submit()}" value="<?php _e('Apply') ?>" />
        <input type="button" name="cancel" value="Cancel" onclick="window.location.href='admin.php?page=spfcthemes'" /><?php //if($id!=-1) echo "&task=edit&id=".$id.""?>	
        </p>
        
	</form>
   
	
	<?php

}

?>