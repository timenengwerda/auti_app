<?php
	class LoginController {
		public $model;
		public $error;
		public $succes;
		
		function __construct(){
			//handmatig in laden, deze controller gaat buiten de template om
			require_once('app/models/login/login.model.php');
			require_once('includes/mailer.php');
			
			$this->model = new LoginModel();		
			$this->login();
		}
		
		function setSucces($succes){
		
			// kijkt of error een array is, zo niet maak array
			if(count($this->succes) == 0){
				$this->succes = array();
			}
			
			//zet alle opgegeven errors in array
			$this->succes[] = $succes;
		}
		
		function setError($error){
		
			// kijkt of error een array is, zo niet maak array
			if(count($this->error) == 0){
				$this->error = array();
			}
			
			//zet alle opgegeven errors in array
			$this->error[] = $error;
		}
		
		function login(){
			$error = 0;
			if(isset($_POST['login'])){
				
				// kleine error checks, zonder feedback
				if(empty($_POST['email'])){
					$error++;
					$this->setError('emailadres is niet ingevuld');
				}
				if(empty($_POST['password'])){
					$error++;
					
					//$this->setError('wachtwoord is niet ingevuld');	
				 }
				
				if($error == 0){		
				
					//kijken of er een result terug komt, zo ja doorsturen, zo nee opgerot staat netjes.
					$password = md5(sha1($_POST['password']));	
					$email    = $_POST['email'];
					
					// als er een ID is
					if($this->model->checkLogin($email, $password) > 0){			
						
						
						$userID = $this->model->checkLogin($email, $password);
						
						$_SESSION['userID'] = $userID;
						$_SESSION['logged_in'] = 1;
						
						
						if(isset($_POST['keep_login']) && $_POST['keep_login'] == 1){
							
							// zet de cookie
							$value = md5(sha1(microtime().$_SESSION['userID']));	
							
							// zet cookie die verloren gaat na een jaar
							setcookie("autistenbeheer_login", $value, time()+60*60*24*365, '.envyum.nl');
						
							// data voor de cookie
							$arr = array(
								new DataHandler('cookie', $value)
							);
							
							//zet cookie, mag falen is niet vereist.
							$this->model->updateCookie($arr, $userID);	
						}
						
						// stuurt door naar pagina	
						echo '<meta http-equiv="refresh" content="0; url='.BASEURL.'dashboard">';

					}
					else{	
						//inloggegevens zijn niet correct
						$this->setError('Inloggegevens zijn niet correct');
					}
				}
				// alles gaat mis
				else{
					$this->setError('Inloggen was niet mogelijk');
				}
			}
		}
		
	function forgotPassword(){
	
		// als er een aanvraag is gedaan naar een wachtwoord vernieuwing
		if(isset($_POST['forgot_password'])){
			// zet error op nul
			$error = 0;
			
			// kleine checks
			if(empty($_POST['email'])){
				$error++;
				$this->setError('e-mailadres is niet ingevuld');
			}
			
			// alles is goed, check of het email klopt
			if($error == 0){	
			
				//model kijkt, als het goed is geeft hij de userID terug.
				if($this->model->checkEmail($_POST['email']) > 0){
				
					// de user bestaat, update de user zijn wachtwoord
					$userID 	= $this->model->checkEmail($_POST['email']);
					$password 	= $this->generatePassword(); 
				
					// data voor de password update
					$arr = array(
						new DataHandler('password', md5(sha1($password)))
					);
					
					// update het nieuwe wachtwoord in de database
					if($this->model->updatePassword($arr, $userID) == true){
						$this->emailPassword($_POST['email'], $password);
					}
					
				}
				else{
					//gebruiker bestaat niet
					$this->setError('Deze gebruiker bestaat niet');
				}
			}
			else{
				// geen email ingevuld
				$this->setError('Er is geen e-mailadres ingevuld');
			}
		}
	}
	
	function generatePassword($length = 8){
	
		// begint met een leeg wachtwoord
	    $password = "";
	
		// alle mogelijke karakters
	    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
	
	   	//kijken naar de lengte
	    $maxlength = strlen($possible);
	  
	    // mag niet langer dan de meegegeven lengte
	    if ($length > $maxlength) {
	      $length = $maxlength;
	    }
		
	    // kijk hoeveer karakters er zijn
	    $i = 0; 
	    
	    // random karakters loopen totdat totaal lengte is bereikt
	    while ($i < $length) { 
	
	      // random karakter kiezen
	      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
	        
	      // als hij al voorkomt, mag hij er niet in
	      if (!strstr($password, $char)) { 
	      
	        // komt niet voor komt erin
	        $password .= $char;
	        
	        //telt omhoog voor totaal
	        $i++;
	      
	      }
	    }
	 // klaar, retouneert wachtwoord
	 return $password;
	}
	
	function emailPassword($to, $password){
// Tegen de rand aan. De body ziet tabs als content!!!!
$body = 'Er is door iemand een nieuw wachtwoord aangevraagd op de dagplannerwebsite het nieuwe wachtwoord is als volgt: </br> '. $password .'<br/>  veranderen doe je in je account';
					$subject = "Nieuw wachtwoord aangevraagd.";
		if($mail = new Mail($to, $body, $subject)){
			//return true;
			
			$this->setSucces('E-mail is verzonden naar het ingestelde e-mailadres');
		}
		else{
			$this->setError('email kon niet worden verzonden');
		}	
	}
	
	function logout(){
		// zet cookie zodat deze direct afloopt
		$value = "";
		setcookie("autistenbeheer_login", $value, time() - 3600, '.envyum.nl');	

		
		unset($_SESSION['logged_in']);
		unset($_SESSION['userID']);
		
		
		$this->setSucces('U bent nu uitgelogd');
	}
	
	
	function checkCookie($cookie){
		require_once('db/db.data.php');
		require_once('db/db.model.php');

		$db = new DatabaseHandler();
		$qry = "SELECT * FROM users WHERE cookie='".$cookie."' LIMIT 1";
		$r = $db->Select($qry);	
			
		$count = count($r);
			
		if($count > 0){
			return $r[0]['userID'];
		}
		else{
			return false;
		}

		
	}
	
	
}
?>