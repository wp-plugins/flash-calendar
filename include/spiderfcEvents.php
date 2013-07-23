<?php

require('../wp-blog-header.php');

class SpiderFCEvents{
	private $wpdb;
	private $id;	
	public $id_calendar;
	public $calendar;
	public $date_begin;
	public $date_end;
	public $event_time_begin;
	public $event_type_end;
	public $title;
	public $text;
	public $html;
	public $css;
	public $htmlUrl;
	public $type;
	public $priority;
	public $event_type;
	public $items;
	public $published; 
	
	private $newid;
	
	function __construct($event_id)
	{
		global $wpdb;
		$this->wpdb = & $wpdb;
		
		if($event_id != -1)
		{
		
			$this->id = (int) $event_id;
			$result = $this->wpdb->get_results("SELECT  ".$this->wpdb->prefix."spiderfc_events.*,
														".$this->wpdb->prefix."spiderfc_calendar.title as calendar
												FROM ".$this->wpdb->prefix."spiderfc_events 
												LEFT JOIN ".$this->wpdb->prefix."spiderfc_calendar 
												ON  ".$this->wpdb->prefix."spiderfc_events.id_calendar=".$this->wpdb->prefix."spiderfc_calendar.id 
												WHERE ".$this->wpdb->prefix."spiderfc_events.id='".$this->id."' ORDER BY id ");
			$this->SetResult($result);
		}
	
	}
	
	private function SetResult($result){
			$this->id = $result->id;
			$this->id_calendar = $result->id_calendar;
			$this->calendar = $result->calendar;			
			$this->date_begin = $result->date_begin;
			$this->date_end = $result->date_end;
			$this->event_time_begin = $result->event_time_begin;
			$this->event_time_end = $result->event_time_end;
			$this->title = $result->title;
			$this->text = $result->text;
			$this->html = $result->html;
			$this->css = $result->css;
			$this->htmlUrl = $result->htmlUrl;			
			$this->type = $result->type;
			$this->priority = $result->priority;
			$this->event_type = $result->event_type;
			$this->items = $result->items;
			$this->published = $result->published; 
					
		
	} 
	
	public function ChangeToDB($id){
		
		if($id == -1)
		{

			if(isset($this->id_calendar)){
				$this->newid = $this->FindIndex();
				
				$q = "INSERT INTO ". $this->wpdb->prefix."spiderfc_events VALUES ('".$this->newid."','".$this->id_calendar."',
																			'".$this->date_begin."', '".$this->date_end."',
																			'".$this->event_time_begin."', '".$this->event_time_end."',
																			'".$this->title."',
																			'".$this->text."', '".$this->html."',
																			'".$this->css."', '".$this->htmlUrl."',
																			 '".$this->type."', 
																			'".$this->priority."', '".$this->event_type."',
																			'".$this->items."', '".$this->published."' )";	
				$this->wpdb->query($q);
			}
			
		}else{
			
			 $q = "UPDATE ". $this->wpdb->prefix."spiderfc_events SET 			
												id_calendar='".$this->id_calendar."',		date_begin='".$this->date_begin."', 
												date_end='".$this->date_end."',				event_time_begin='".$this->event_time_begin."', 
												event_time_end='".$this->event_time_end."',	title='".$this->title."',
												text='".$this->text."', 					html='".$this->html."',
												css='".$this->css."',						htmlUrl='".$this->htmlUrl."',
												type='".$this->type."', 
												priority='".$this->priority."', 			event_type='".$this->event_type."',
												items='".$this->items."',					published='".$this->published."'
												WHERE id='".$id."'";
			 $this->wpdb->query($q);	
		}
	}
	public function getNewID(){
		return $this->newid;
	}
	/* search free index into db*/
	private function FindIndex(){
	
		$query1 = $this->wpdb->get_results("select id FROM ".$this->wpdb->prefix."spiderfc_events");
		$query2 = $this->wpdb->get_row("select MAX(id) as maxid FROM ".$this->wpdb->prefix."spiderfc_events");	
	
		$b = false;
	 	$newid = $query2->maxid;
		for($i = 1; $i <= $query2->maxid; $i++)
		{
			
			foreach($query1 as $rows){
		
				if($i != $rows->id){
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
	
	
}

?>