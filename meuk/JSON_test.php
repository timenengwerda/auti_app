<?php
define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");

require_once('db/db.data.php');
require_once('db/db.model.php');
$db = new DatabaseHandler();

$activities = $db->Select("SELECT * FROM activities");
$JSON = "{\n\t\"activities\": [\n";
foreach($activities as $k=>$data) {
	$JSON.= "\t\t{\n";
	foreach($data as $key=>$value) {
		$JSON.="\t\t\t\"$key\": \"$value\",\n";
	}
	$JSON = rtrim($JSON,",\n")."\n";
	$JSON.= "\t\t},\n";
}
$JSON = rtrim($JSON,",\n")."\n";
$JSON.= "\t]\n}";
echo json_encode($JSON);
?>