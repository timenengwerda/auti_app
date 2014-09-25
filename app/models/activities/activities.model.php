<?php
	class ActivitiesModel{
		public $db;

		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		function getActivityByDay($date, $id){
		
			//SELECT * FROM activities WHERE DATE_FORMAT(start_date, '%Y-%m-%d') = '2012-06-11'
			//echo "SELECT * FROM activities WHERE DATE_FORMAT(start_date, '%Y-%m-%d') = '".mysql_real_escape_string($date)."'";
			return $this->db->Select("
									SELECT 
										* 
									FROM 
										activities a,
										clients b										
									WHERE 
										DATE_FORMAT(a.start_time, '%Y-%m-%d') = '".mysql_real_escape_string($date)."'
									AND
										b.clientID = a.userID
									AND
										a.userID = '".mysql_real_escape_string($id)."'
									ORDER BY a.start_time ASC");		
		}
		
		function getActivityTitle($id){
			return $this->db->Select("SELECT * FROM pictograms WHERE pictogramID = '".mysql_real_escape_string($id)."'");
		}
		
		function ClientsByUser($userID){
			return $this->db->Select("
									SELECT 
										a.*, c.clientID, c.name, c.surname 
									FROM
										client_user a,
										clients c
									WHERE
										a.userID = '".mysql_real_escape_string($userID)."'
									AND
										c.clientID = a.clientID");
		}
		
		function getPictograms(){
			return $this->db->Select("SELECT * FROM pictograms");
		}
		
		function getActivity($id){
			return $this->db->Select("SELECT * FROM activities WHERE activityID = '".$id."'");
		}
				
		function getCustomPictograms($user){
				return $this->db->Select("SELECT * FROM custom_pictograms WHERE userID = '".$user."'");
		}
		
		// Moet nog toegevoegd worden aan TO
		function getActivities(){
			return $this->db->Select("SELECT * FROM activities ORDER by start_time");
		}
		
		function getCurrentDayActivities(){
			return $this->db->Select("	
					SELECT 
						a.*,
						b.*
					FROM 
						activities a, clients b
					WHERE 
						b.clientID = a.userID
					AND
						a.start_time BETWEEN DATE(NOW()) 
					AND DATE(NOW()) + INTERVAL 7 DAY 
				ORDER BY 
					a.start_time");
		}
		
		function getOverlap($qry){
			return $this->db->Select($qry);
		}
		
/*
$query = "SELECT
						a.*,
						b.*,
						c.*
					FROM
						activities a,
						client_user b,
						clients c
					INNER JOIN
						clients c
					ON
						c.clientID = a.clientID
					WHERE
						a.clientID = b.clientID
						AND
							a.start_time BETWEEN DATE(NOW()) 
						AND DATE(NOW()) + INTERVAL 7 DAY 
					ORDER BY 
						a.start_time";		
*/
				
		function getCurrentWeekActivities(){
/*
			return $this->db->Select("	
					SELECT 
						a.*,
						b.*
					FROM 
						activities a, clients b
					WHERE 
						b.clientID = a.userID
					AND
						a.start_time BETWEEN DATE(NOW()) 
					AND DATE(NOW()) + INTERVAL 7 DAY 
				ORDER BY 
					a.start_time");
*/


		}
				
		function getCurrentMonthActivities(){
			return $this->db->Select("	
					SELECT 
						a.*,
						b.*
					FROM 
						activities a, clients b
					WHERE 
						b.clientID = a.userID
					AND
						a.start_time BETWEEN DATE(NOW()) 
					AND DATE(NOW()) + INTERVAL 31 DAY 
				ORDER BY 
					a.start_time");
		}
		
		function addActivity($arr){
			return $this->db->Insert('activities', $arr);
		}
		
		function editActivity($arr, $route){
			return $this->db->Update('activities', $arr, 'WHERE activityID = "'.$route.'"');	
		}		

		function deleteActivity($route){
			return $this->db->Delete('activities', 'WHERE activityID = "'.$route.'"');	
		}		
				
		function saveCustomPictogram($arr){
			$result = $this->db->Insert('custom_pictograms', $arr);
			if($result){
				return mysql_insert_id();
			}else{
				return 0;
			}
		}
	}
?>