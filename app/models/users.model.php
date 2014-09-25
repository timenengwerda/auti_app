<?php
class UsersModel{
	public $db;
		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		function getUsers($where = ''){
			return $this->db->Select("SELECT * FROM users " . $where);
		}
		
		function getClients($where = ''){
			return $this->db->Select("SELECT * FROM clients " . $where);
		}
		
		function updateUser($arr, $userID){
			return $this->db->Update('users', $arr, "WHERE userID = '" . $userID . "'");
		}
		
		function saveClient($arr){
			return $this->db->Insert('clients', $arr);
		}
		function mergeClientAndUser($arr){
			return $this->db->Insert('client_user', $arr);
		}
		
		function getClientByUser($userID){
			return $this->db->Select("SELECT 
										a.*, b.* 
									FROM 
										client_user a, clients b
									WHERE
										a.userID = '" . mysql_real_escape_string($userID) . "'
									AND
										b.clientID = a.clientID");
		}
}
?>