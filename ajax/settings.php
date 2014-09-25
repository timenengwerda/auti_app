<?php session_start(); ?>

<?php

define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");


require_once('../db/db.data.php');
require_once('../db/db.model.php');

$db = new DatabaseHandler();

if($_GET['action'] == "delete"){
	$id = $_GET['id'];
	if(is_numeric($id)){
		if($db->Query("DELETE FROM custom_pictograms WHERE pictogramID='".mysql_real_escape_string($id)."' LIMIT 1")){
			$db->Query("DELETE FROM activities WHERE custompictogram='".mysql_real_escape_string($id)."'");
			echo 1;
		}
		else{
			echo 0;
		}
	}else{
		echo 0;
	}
}
?>