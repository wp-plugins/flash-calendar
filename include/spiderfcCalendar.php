<?php
require('../wp-blog-header.php');

class SpideFCCalendar{
	
	private $wpdb;
	private $id;
	public $title;
	public $theme;
	public $published;
	
	public function __construct($cal_id){
		global $wpdb;
		$this->wpdb = & $wpdb;
	
		if($cal_id != -1){
		 
			 $query = "SELECT * FROM  ". $this->wpdb->prefix."spiderfc_calendar 
			 					WHERE id =".$cal_id." ORDER BY id";
			 $result = $this->wpdb->get_row($query);
			 
			 $this->SetResult($result);
		}
	}
	
	private function SetResult($result){
			$this->id = $result->id;
			$this->title = 	$result->title;
			$this->theme = $result->id_theme;
			$this->published = $result->published;		
		
	} 
	
	public function ChangeToDB($id){
		
		if($id == -1)
		{

			$theme = $this->wpdb->get_row("SELECT theme_id FROM ". $this->wpdb->prefix."spiderfc_theme WHERE theme_id='".$this->theme."' ");
			
			if(isset($theme->theme_id)){
				$newid = $this->FindIndex();
				
				$q = "INSERT INTO ". $this->wpdb->prefix."spiderfc_calendar VALUES ('".$newid."','".$this->title."',
																			'".$this->theme."', '".$this->published."'  )";	
				$this->wpdb->query($q);
			}
			
		}else{
			
			$q = "UPDATE ". $this->wpdb->prefix."spiderfc_calendar SET title='".$this->title."', 
																	id_theme='".$this->theme."', published='".$this->published."' 
																	WHERE id='".$id."'";
			$this->wpdb->query($q);	
		}
		
		
	}
	/* search free index into db*/
	private function FindIndex(){
	
		$query1 = $this->wpdb->get_results("select id FROM ".$this->wpdb->prefix."spiderfc_calendar");
		$query2 = $this->wpdb->get_row("select MAX(id) as maxid FROM ".$this->wpdb->prefix."spiderfc_calendar");	
	
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