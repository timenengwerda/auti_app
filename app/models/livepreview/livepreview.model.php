<?php
	class LivePreviewModel{
		public $db;
		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		
		
		function getday($userID){

			$queryString = "SELECT 
								* , DATE_FORMAT(`activities`.`start_time`, '%H:%i:%s') AS real_time
								  , `custom_pictograms`.`filename` AS custom_filename
							FROM 
								`activities` 
								
							INNER JOIN 
								`client_user` ON `client_user`.`clientID` = `activities`.`clientID`
								
							INNER JOIN
								`clients` ON `clients`.`clientID` = `client_user`.`clientID`
																
							LEFT JOIN 
								`custom_pictograms` ON `activities`.`custompictogram` = `custom_pictograms`.`pictogramID`
								
							LEFT JOIN 
								`pictograms` ON `activities`.`pictogram` = `pictograms`.`pictogramID`
								 
							WHERE 
								`activities`.`userID` = '".$userID."'
								
							AND `activities`.`start_time` > DATE_SUB(NOW(), INTERVAL 1 HOUR) 
								
							ORDER BY 
								`activities`.`start_time` ASC 
							LIMIT 
								1
							";
			
			return $this->db->Select($queryString);
			
			//return $queryString;
		}

		

}
?>