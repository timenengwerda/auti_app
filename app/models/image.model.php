<?php
	class ImageModel{
		public $db;
		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		function addImage($arr){
		
			if($this->db->Insert('custom_pictograms', $arr)){
			
				return mysql_insert_id();
			}
			else{
				return false;
			}
			
			
		}
		
	}
?>