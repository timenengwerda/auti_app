<?php
session_start();
define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");


require_once('../db/db.data.php');
require_once('../db/db.model.php');

$db = new DatabaseHandler();

if(isset($_GET['action'])){
	switch($_GET['action']){
		case 'edit':
			if(!empty($_GET['name'])){
				if(!empty($_GET['value']) || $_GET['value'] == "0"){
					$_SESSION[$_GET['name']] = urldecode($_GET['value']);
					echo $_SESSION[$_GET['name']];
				}else{
					echo 'Value is leeg.';
				}
			}else{
				echo 'Name is leeg.';
			}
		break;
		case 'editCharacter':
			if(!empty($_GET['name'])){
				if(!empty($_GET['value']) || $_GET['value'] == "0"){
					$_SESSION[$_GET['name']] = urldecode($_GET['value']);
					
					$_SESSION['clientCharacter'] = '<img src="/public/images/character/'.urldecode($_GET['value']).'.png" alt="' . urldecode($_GET['value']) . '">';
					
					echo '<img src="/public/images/character/'.$_GET['value'].'.png" alt="' . $_GET['value'] . '">';
				}else{
					echo 'Value is leeg.';
				}
			}else{
				echo 'Name is leeg.';
			}
		break;
	}
}
?>