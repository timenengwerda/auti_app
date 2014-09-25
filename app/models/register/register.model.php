<?php
	class RegisterModel{
		public $db;
		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		function getEmail($email){
			return $this->db->Select("SELECT email FROM users WHERE email = '".mysql_real_escape_string($email)."'");
		}
		
		function saveEmail($userInfo){
			return $this->db->Insert('users', $userInfo);
		}

		function saveName($userInfo){
			return $this->db->Insert('users', $userInfo);
		}
		
		function getApiKey($num){
			return $this->db->Select("SELECT * FROM clients WHERE apikey = '" . $num . "'");
		}
		
}


?>