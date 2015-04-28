<?php
require('../wp-blog-header.php');


class GradientColor{
	public $value1;
	public $value2;
}
class Parameter
{
	public $title;
	public $name;
	public $value; // GradientColor value1, value2
	public $defaultValue;
	public $description;
	public $themeDefault;
	public $theme_id;
	private $getID;
	function __construct(){
		$this->value = new GradientColor;
		}
}

class SpiderFCTheme{

	private $wpdb;
	public $properties;
	
	
	function __construct($theme_id){
		 global $wpdb;
		 $this->wpdb = & $wpdb;
		 
 		if($theme_id != -1){
		 
			 $query = "SELECT * FROM  ". $this->wpdb->prefix."spiderfc_theme WHERE theme_id = ".$theme_id." ORDER BY id LIMIT 0, 56";
			 $result = $this->wpdb->get_results($query);
			 //$row= $this->wpdb->get_row($query);
			 $this->ReadResult($result);
		}
	}
	
	private function ReadResult($result){
		$i = 0;
		foreach( $result as $params){
		
			$this->properties[$i] = new Parameter();
			$this->properties[0]->title = $params->title;
			$this->properties[0]->themeDefault = $params->theme_default;
			$this->properties[$i]->name = $params->paramsname;								
			$this->properties[$i]->description = $params->paramsdescrip;
			
			if(	$params->paramsname == "bgColors" 				|| $params->paramsname == "headerBgColors" ||
				$params->paramsname == "datesBgColors" 			|| $params->paramsname == "eventsListHeaderbgColors" || 
				$params->paramsname == "eventContentBgColors" 	 )		
			{
				$grad = explode(" ", $params->paramsvalue);
				$this->properties[$i]->value->value1 = $grad[0];
				$this->properties[$i]->value->value2 = $grad[1];
			}	else{
				
				$this->properties[$i]->value = $params->paramsvalue;
			}
			$i++;
		}
	}
	/*Save or Update parameters to DB*/
	public function SaveToDB($id){
		
		if($id == -1)
		{			
			if(count($this->properties) >0 ){
			 	$qmax = $this->wpdb->get_row("SELECT max(id) as max FROM ".$this->wpdb->prefix."spiderfc_theme ");
				$index = $qmax->max;
				
				$newtheme_id = $this->FindIDTheme();
				
				foreach($this->properties as $params){
					$index++;
					if(isset($params->value->value1))
					{
						$value = $params->value->value1.';'.$params->value->value2;
					}else{
						$value = $params->value;
					}
					
					$default = 0; //$params->themeDefault
					$q = "INSERT INTO ".$this->wpdb->prefix."spiderfc_theme VALUES ('".$index."', '".$params->title."',
																						'".$params->name."',
																						'".$params->description."',
																						'".$value."',
																						'".$default."',
																						'".$newtheme_id."')"; 
					  $this->wpdb->query($q); 
					
				}
				
			/*	if($this->properties[0]->themeDefault == 1)
				{
					$q = "UPDATE ".$this->wpdb->prefix."spiderfc_theme SET theme_default='0' WHERE theme_id !='".$newtheme_id."'";
																		
					$this->wpdb->query($q);
				} */
			}
		}else {
			$bdef = false;
			if($this->properties[0]->themeDefault == 0){
				
				$q = $this->wpdb->get_row("SELECT COUNT(theme_default) as cnt FROM ".$this->wpdb->prefix."spiderfc_theme WHERE theme_default='1' AND theme_id !='".$id."'" );
			
				if($q->cnt > 0){ $bdef = true; } 
				
			}
			
			foreach($this->properties as $params){
				if(isset($params->value->value1))
				{
					$value = $params->value->value1.';'.$params->value->value2;
				}else{
					$value = $params->value;
				}
				
				//if($bdef == true){ $default = $params->themeDefault; }else{ $default=1;}
				$default = 0;
				 $q = "UPDATE ".$this->wpdb->prefix."spiderfc_theme SET  title='".$params->title."', 
																	paramsvalue='".$value."' 
																	WHERE theme_id='".$id."' and paramsname='".$params->name."'";
																	
				$this->wpdb->query($q);
		
				
			}
			/* if($this->properties[0]->themeDefault == 1)
			{
				$q = "UPDATE ".$this->wpdb->prefix."spiderfc_theme SET theme_default='0' WHERE theme_id !='".$id."'";
																	
				$this->wpdb->query($q);
			} */
			
			
		}
		
	}
	
	/* search free index into db*/
	private function FindIDTheme(){
	
		$query1 = $this->wpdb->get_results("select DISTINCT(theme_id) as theme_id FROM ".$this->wpdb->prefix."spiderfc_theme");
		$query2 = $this->wpdb->get_row("select MAX(theme_id) as maxid FROM ".$this->wpdb->prefix."spiderfc_theme");	
	
		$b = false;
	 	$newid = $query2->maxid;
		for($i = 1; $i <= $query2->maxid; $i++)
		{
			
			foreach($query1 as $rows){
		
				if($i != $rows->theme_id){
					$b = true;
					
					break;		
				}
			}
		}
		
		if($b == true)
			$newid = $i;
		else
			 $newid++;
			 
		return $newid;
		
		
	}
	
	public function SetDefaultTheme($id){
		$this->getID = $id;
		$this->SetPropertyTheme();
		$this->SaveToDB($this->getID);
	}
	
	public function addProperty($title, $name, $desc, $value, $default, $themeid) {
		//$property = new Parameter($this->getID);
		$property = new Parameter();
		$property->title = $title;
		$property->themeDefault = $default;	
		$property->name = $name;								
		$property->description = $desc;
		$str = explode(';',$value);
		if(count($str)>1 ){
			$property->value->value1 = $str[0]; 
			$property->value->value2 = $str[1];
			}else{
			$property->value = $value;
		}
		$property->theme_id = $themeid;
		$this->properties[] = $property;
		
	}
	function SetPropertyTheme()
	{
		//$this->properties = array();
		$this->addProperty('','startWithMonday','','1','1','1');
		$this->addProperty('','dateFormat','','%d-%m-%y %t','1','1');
		$this->addProperty('','dateFormatShort','','%t','1','1');
		$this->addProperty('','time','','0','1','1');
		
		$this->addProperty('','appMaxWidth','','','1','1');
		$this->addProperty('','appMaxHeight','','','1','1');
		$this->addProperty('','appMinWidth','','','1','1');
		$this->addProperty('','appMinHeight','','','1','1');
		
		$this->addProperty('','startViewSize','','viewSizeMax','1','1');
		$this->addProperty('','startViewState','','viewStateDays','1','1');
		
		$this->addProperty('','bgColors','','FFFFFF;FFFFFF','1','1');	
		$this->addProperty('','bgCornerRadius','','','1','1');
		$this->addProperty('','strokeColor','','FFFFFF','1','1');
		
		$this->addProperty('','headerHeight','','','1','1');
		$this->addProperty('','headerPadding','','','1','1');
		$this->addProperty('','headerBgColors','','FFFFFF;FFFFFF','1','1');										
		$this->addProperty('','headerBgStrokeColor','','FFFFFF','1','1');
		$this->addProperty('','headerContentColor','','FFFFFF','1','1');
//		$this->addProperty('','headerContentHoverColor','','E6E6E6','1','1');
		$this->addProperty('','headerContentStrokeColor','','FFFFFF','1','1');									
		$this->addProperty('','headerFontSize','','','1','1');
		
		$this->addProperty('','daysNamesColor','','FFFFFF','1','1');
		$this->addProperty('','daysNamesFontSize','','','1','1');
//		$this->addProperty('','daysNamesHeight','','30','1','1');
		
		$this->addProperty('','datesBgColors','','FFFFFF;FFFFFF','1','1');
		

		//$this->addProperty('','datesBgStrokeColor','','808080','1','1');
		
		$this->addProperty('','priority0Color','','FFFFFF','1','1');
		$this->addProperty('','priority1Color','','FFFFFF','1','1');
		$this->addProperty('','priority2Color','','FFFFFF','1','1');
		$this->addProperty('','priority3Color','','FFFFFF','1','1');
		
		$this->addProperty('','dateFontSize','','','1','1');
		$this->addProperty('','dateColor','','FFFFFF','1','1');
		$this->addProperty('','dateStrokeColor','','FFFFFF','1','1');
		$this->addProperty('','showDateEventsCount','','1','1','1');
		$this->addProperty('','dateEventsCountFontSize','','','1','1');
		$this->addProperty('','dateEventsCountColor','','FFFFFF','1','1');
		
		$this->addProperty('','eventsListHeaderHeight','','','1','1');										

//		$this->addProperty('','eventsListHeaderStrokeColor','','808080','1','1');
		$this->addProperty('','eventsListHeaderbgColors','','FFFFFF;FFFFFF','1','1');		
		$this->addProperty('','eventsListHeaderColor','','FFFFFF','1','1');
//		$this->addProperty('','eventsListHeaderHoverColor','','808080','1','1');
		$this->addProperty('','eventsListHeaderFontSize','','','1','1');
		
		$this->addProperty('','eventHeaderHeight','','','1','1');
		$this->addProperty('','eventHeaderFontSize','','','1','1');		
		$this->addProperty('','eventHeaderColor','','FFFFFF','1','1');
//		$this->addProperty('','eventHeaderHoverColor','','404040','1','1');

		$this->addProperty('','eventContentBgColors','','FFFFFF;FFFFFF','1','1');		
		$this->addProperty('','eventContentDatesFontSize','','','1','1');
		$this->addProperty('','eventContentDatesColor','','FFFFFF','1','1');
		$this->addProperty('','eventContentDescriptionFontSize','','','1','1');
		$this->addProperty('','eventContentDescriptionColor','','FFFFFF','1','1');
		
		$this->addProperty('','footerHeight','','','1','1');
		$this->addProperty('','footerColor','','FFFFFF','1','1');
//		$this->addProperty('','footerHoverColor','','E6E6E6','1','1');
		
		$this->addProperty('','mediaDefaultAutoplay','','1','1','1');
		$this->addProperty('','mediaScaleType','','scaleTypeTouchFromOutside','1','1');
		$this->addProperty('','mediaShowDuration','','5','1','1');
		$this->addProperty('','videoDefaultVolume','','50','1','1');
		$this->addProperty('','videoAutoplay','','0','1','1');
		$this->addProperty('','mediaBgColor','','FFFFFF','1','1');
		$this->addProperty('','mediaCtrlsBgColor','','FFFFFF','1','1');
		$this->addProperty('','mediaCtrlsBgAlpha','','50','1','1');
		$this->addProperty('','mediaCtrlsColor','','FFFFFF','1','1');
//		$this->addProperty('','mediaCtrlsHoverColor','','FFFFFF','1','1');
		$this->addProperty('','mediaCtrlsAlpha','','50','1','1');
		
}	
	
	
}

?>