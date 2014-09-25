<?php
	class LoginModel{
		public $db;
		function __construct(){
		
			require_once('db/db.data.php');
			require_once('db/db.model.php');
			
			$this->db = new DatabaseHandler();
		}
		
		function checkLogin($email, $password){
			$qry = "SELECT * FROM users 
								  WHERE email = '".mysql_real_escape_string($email)."' 
								  AND `password` LIKE '".$password."' AND `activation` = 1";
			    
			$r = $this->db->Select($qry);		
			$count = count($r);
			
			if($count > 0){
				return $r[0]['userID'];
			}
			else{
				return false;
			}
		}
		
		function updateCookie($arr, $userID){
			return $this->db->Update('users', $arr, "WHERE userID='" . mysql_real_escape_string($userID) . "'");
		}
		
		
		function checkEmail($email){
			$qry = "SELECT * FROM users 
								  WHERE email = '".mysql_real_escape_string($email)."'";
			    
			$r = $this->db->Select($qry);		
			$count = count($r);
			
			if($count > 0){
				return $r[0]['userID'];
			}
			else{
				return $qry;
			}
		}
		
		function updatePassword($arr, $userID){
			return $this->db->Update('users', $arr, "WHERE userID='" . mysql_real_escape_string($userID) . "'");
		}
		
}

?>