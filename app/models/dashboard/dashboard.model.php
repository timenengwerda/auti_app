<?php
	class DashboardModel{
		public $db;
		function __construct(){
			$this->db = new DatabaseHandler();
			//var_dump($this->db);
		}
		function getUsers(){
			return $this->db->Select("SELECT * FROM users");
		}
		
		function getStatisticsByClients($id){
			 $qry = "SELECT *
						FROM activities
						RIGHT JOIN clients
						ON activities.clientID=clients.clientID
						WHERE clients.clientID = '".mysql_real_escape_string($id)."'";
			return $this->db->Select($qry);
		}
		
		function getClientByUser($id){
			return $this->db->Select("SELECT * FROM client_user WHERE userID = '".mysql_real_escape_string($id)."'");
		}
	}
?>