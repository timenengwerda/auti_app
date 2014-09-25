<?php
define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");

require_once('db/db.data.php');
require_once('db/db.model.php');
//include('xml.xml');
$db = new DatabaseHandler();

$users = $db->Select("SELECT * FROM activities");
//var_dump($xmlWr);


$xmlstr = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<activities>
</activities>
XML;


/*
$activities = array ( 
	array ( 
		'id' => 2,
		'what' => 'Op bezoek', 
		'how' => 'Met de auto', 
		'who' => 'Joucke'  
	),
 	array ( 
		'id' => 3, 	
    'what' => 'Naar een pretpark', 
    'how' => 'Met het vliegtuig', 
    'who' => 'Groep 8'  
  )    
); 
var_dump($activities);
*/
$sxe = new SimpleXMLElement($xmlstr);



$activities = $db->Select("SELECT * FROM activities");
if(!empty($users)){
	foreach($activities as $act){
	$activity = $sxe->addChild('activity');
	$activity->addAttribute('id', $act['activityID']);
	$what = $activity->addChild('what', $act['what']);
	$how = $activity->addChild('how', $act['how']);
	$who = $activity->addChild('who', $act['who']);		}
}

echo $sxe->asXML();
?>

