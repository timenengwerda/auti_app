<?php
session_start();
error_reporting(E_ALL);

require_once('includes/config.php');
require_once('app/controllers/login/login.controller.php');

// stuurt de gebruiker maar 1 keer door, wordt maar 1 keer gecheckt of de cookie bestaat bij binnenkomst.
$i 			= 0;
$no_check 	= 0;
$login      = new LoginController();

// als er een first setup is, niet checken naar inlog
if(isset($_GET['page']) && $_GET['page'] == "register"){
	$no_check = 1;
}

// als er een first setup is, niet checken naar inlog
if(isset($_SESSION['first_setup']) && $_SESSION['first_setup'] == 1){
	$no_check = 1;
}

// anders checken naar inlog
if($no_check == 0){
	
	// is er een inlog, en is er een user id, zo ja prima 
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1 && isset($_SESSION['userID'])){
		//stuurt pas door als er daad werkelijk een login is
		require_once('app/controllers/base.controller.php');
		$bc 		= new BaseController();		
	}
	
	// is er geen sessie en is er niemand ingelogd?
	if(!isset($_SESSION['userID']) && !isset($_SESSION['logged_in'])){
		
		// als er een cookie gezet is kijk even wat je dan kan doen.
		if(isset($_COOKIE['autistenbeheer_login'])){
				
			// als er daadwerkelijk iemand is met deze cookie
			if($login->checkCookie($_COOKIE['autistenbeheer_login']) > 0 && $i == 0){
				
				$_SESSION['userID'] 	= $login->checkCookie($_COOKIE['autistenbeheer_login']);
				$_SESSION['logged_in'] 	= 1;
				
				$i++;
				
				//stuurt pas door als er daad werkelijk een login is
				require_once('app/controllers/base.controller.php');
				$bc 		= new BaseController();
				
				echo '<meta http-equiv="refresh" content="0; url='.BASEURL.'dashboard">';
				
			}
			else{
				// cookies niet lekker ontvangen, opnieuw inloggen
				echo '<meta http-equiv="refresh" content="0; url='.BASEURL.'login.php">';
			}
		}
		else{
			//geen sessions en cookies, inloggen maar
			echo '<meta http-equiv="refresh" content="0; url='.BASEURL.'login.php">';
		}
	}
}else{
	//stuurt pas door als er daad werkelijk een login is
	require_once('app/controllers/base.controller.php');
	$bc 		= new BaseController();
}
