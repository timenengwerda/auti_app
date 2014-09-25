<?php
session_start();
define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");

require_once('../../../db/db.data.php');
require_once('../../../db/db.model.php');
$db = new DatabaseHandler();

$userString = "";

$customPicto = "LEFT JOIN `custom_pictograms` ON  `activities`.`custompictogram` = `custom_pictograms`.`pictogramID` ";
$normalPicto = "LEFT JOIN `pictograms` ON  `activities`.`pictogram` = `pictograms`.`pictogramID` ";

$whereClause = "WHERE 1 ";

if($_SESSION['userID']) {
	$user = mysql_real_escape_string($_SESSION['userID']);
	$userString = "INNER JOIN `clients` ON `activities`.`clientID` = `clients`.`clientID` ";
	$whereClause.="AND `activities`.`userID`='{$user}' ";
}

/*
Jaarlijkse events herhalen op dag en maand vanaf startdatum tot einddatum
Maandelijkse events herhalen op dag vanaf startdatum tot einddatum
Wekelijkse events herhalen op dag vd week vanaf startdatum tot einddatum
Dagelijkse events herhalen op elke dag vanaf startdatum tot einddatum
*/

$queryString = "SELECT *, `clients`.`color` AS color, `custom_pictograms`.`filename` AS custom_filename, `pictograms`.`filename` as filename FROM `activities` {$customPicto}{$normalPicto}{$userString}{$whereClause}";

/*
					DATE_FORMAT(a.start_time, '%d-%m-%Y') = '".$startdate."'
					OR
						a.repeatmode = 1
					OR
						(a.repeatmode = 2 AND DATE_FORMAT(a.start_time, '%w') = '".$startWeekday."')
					OR
						(a.repeatmode = 3 AND DATE_FORMAT(a.start_time, '%d') = '".$startDay."')
					OR
						(a.repeatmode = 4 AND DATE_FORMAT(a.start_time, '%d-%m') = '".$startDayMonth."')
						
*/

$activities = $db->Select($queryString);
$json = array();

$custompath = 'public/images/custom/';
$path		= 'public/images/default/';

foreach($activities as $k=>$data) {
	
	$checked=true;
/*
	list($d,$startTime)=explode(" ",$data['start_time']);
	list($date,$endTime)=explode(" ",$data['end_time']);
	$datetime=strtotime($data['end_time']);
	$startTime=strtotime($startTime);
*/
/*
	switch($data['repeatmode']) {
		case "1":
			// daily repeat. check if end_time hasn't passed yet. also check if date of start_date has passed.
			if(strtotime($endTime)>strtotime($currentTime) && strtotime($currentDate)>=strtotime($d)) {
				$checked=true;
			}
			$jsonData[$startTime][] = array(
				'activityID' 				=> $data['activityID'],
				'title' 						=> $data['what'],
				'how' 							=> $data['how'],
				'who' 							=> $data['who'],
				'userID' 						=> $data['userID'],
				'location'					=> $data['location'],	
				'repeatmode'				=> $data['repeatmode'],								
				'pictogram'    			=> $pictogram,											
				'color'							=> $data['color'],
				'start'							=> $data['start_time'],							
				'end' 							=> $data['end_time'],
				'activityID'				=> $data['activityID']
							);
			break;
		case "2":
			// weekly repeat. check day of week equals current day of week and end_time hasn't passed yet. also check if date of start_date has passed.
			if(date("w",$datetime)==date("w") && strtotime($endTime)>strtotime($currentTime) && strtotime($currentDate)>=strtotime($d)) {
				$checked=true;
			}
			break;
		case "3":
			// monthly repeat. check day of month equals current day of month and end_time hasn't passed yet. also check if date of start_date has passed.
			if(date("d",$datetime)==date("d") && strtotime($endTime)>strtotime($currentTime) && strtotime($currentDate)>=strtotime($d)) {
				$checked=true;
			}
			break;
		case "4":
			// yearly repeat. check dd-mm equals current dd-mm and end_time hasn't passed yet. also check if date of start_date has passed.
			if(date("d-m",$datetime)==date("d-m") && strtotime($endTime)>strtotime($currentTime) && strtotime($currentDate)>=strtotime($d)) {
				$checked=true;
			}
			break;
		default:
			// repeatmode 0 - no repeat, so no date/time check needed
			$checked=true;
			break;
	}
*/
	
	if($checked) {
/*
		if(isset($data['custom_filename'])){
			$pictogram = BASEURL.$custompath.$data['custom_filename'];
		}
		if(isset($data['pictogram'])){
			$pictogram = BASEURL.$path.$data['filename'];
		}
*/

		if(!empty($data['custom_filename'])){
			$pictogram = BASEURL.$custompath.$data['custom_filename'];
		}
		else{
			$pictogram = BASEURL.$path.$data['filename'];
		}

		$jsonData[$startTime][] = array('activityID' 		=> $data['activityID'],
							'title' 						=> $data['what'],
							'how' 							=> $data['how'],
							'who' 							=> $data['who'],
							'userID' 						=> $data['userID'],
							'location'						=> $data['location'],	
							'repeatmode'						=> $data['repeatmode'],								
							'pictogram'    					=> $pictogram,											
							'color'							=> $data['color'],
							'start'							=> $data['start_time'],							
							'end' 							=> $data['end_time'],
							'activityID'					=> $data['activityID']
							);
	}
}

ksort($jsonData);

//print_r($jsonData);

foreach($jsonData as $data) {
	foreach($data as $realdata) {
		$json[]=$realdata;	
	}
}
//var_dump($json);

echo json_encode($json);
?>