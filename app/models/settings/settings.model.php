<?php
	class SettingsModel{
		public $db;
		
		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		function saveClient($arr, $clientID){
			return $this->db->Update('clients', $arr, "WHERE clientID='" . mysql_real_escape_string($clientID) . "'");
		}
		function saveUser($arr, $userID){
			return $this->db->Update('users', $arr, "WHERE userID='" . mysql_real_escape_string($userID) . "'");
		}
		
		function getEmail($email){
			return $this->db->Select("SELECT * FROM users WHERE email = '".mysql_real_escape_string($email)."'");
		}
		function getCustomPictograms($user){
			return $this->db->Select("SELECT * FROM custom_pictograms WHERE userID = '".$user."'");
			
		}
		
}


?>