<?php
	class RegisterController extends BaseController{
		public $template;
		public $route;
		public $model;
		public $users;
		public $characterdir;
		
		function __construct($template, $route){
			require_once('app/controllers/users.controller.php');
			$this->users = new UsersController($template);
			
			$this->route = $route;
			$this->template = $template;
			$this->model = new RegisterModel();
			
			$this->characterdir = '/public/images/character/';
			
			$_SESSION['first_setup'] = 1;
			
			if(!empty($this->route[1])){
				switch($this->route[1]){
					case 'step1':
						$this->stepOneRegistration();
					break;
					case 'step2':
						$this->stepTwoRegistration();
					break;
					case 'step3':
						$this->stepThreeRegistration();
					break;
					case 'finish':
						$this->finishRegistration();
					break;
				}
			}else{
				$this->registerUser();
			}
		}
		
		function stepOneRegistration(){
			
		
			//Route 2 en route 3dienen aanwezig te zijn. Zo niet klopt de pagina bij voorbaat niet.
			if(!empty($this->route[2]) && !empty($this->route[3])){
				//Check of de email en activatie combinatie klopt in de database. Indien deze klopt wordt de user geretourneerd
				$user = $this->users->checkActivation($this->route[2], $this->route[3]);
				
				if(!empty($user)){
					$this->template->setData('user', $user);
				}else{
					
					$this->template->setError('De combinatie van e-mailadres en code komen niet overeen.');
				}
			}else{
				$this->template->setError('Er zijn ontbrekende gegevens. Probeer het opnieuw met de activatielink in uw e-mail');
			}
		}
		
		function stepTwoRegistration(){
			//Kijk of user gesubmit heeft
			if(isset($_POST['submitUser'])){
				$error = 0;
				//Check of alles ingevuld is
				if(empty($_POST['name'])){
					$error++; $this->template->setError('"Naam" is niet ingevuld.');
				}
				if(empty($_POST['surname'])){
					$error++; $this->template->setError('"Achternaam" is niet ingevuld.');
				}
				if(empty($_POST['password'])){
					$error++; $this->template->setError('"Wachtwoord" is niet ingevuld.');
				}
				

				if($error == 0){
					//Check het wachtwoord
					if($this->users->checkPasswords($_POST['password'], $_POST['passwordcheck'])){
						//Als alles klopt wordt alle data in een sessie gezet voor later gebruik.
						$this->setSession('userName', $_POST['name']);
						$this->setSession('userSurname', $_POST['surname']);
						$this->setSession('userPassword', $_POST['password']);
						$this->setSession('userID', $this->route[2]);
						
						unset($_POST);
					}else{
						$this->template->setError('<a href="javascript:history.go(-1);">Ga terug</a>');
					}
				}
				
			}
		}
		
		function stepThreeRegistration(){
			//Kijk of user gesbmit heeft
			if(isset($_POST['submitClient'])){
				$error = 0;
			
				//Kijken of verplichte velden zijn gevuld.
				if(empty($_POST['name'])){
					$error++; $this->template->setError('"Naam" is niet ingevuld.');
				}
				if(empty($_POST['surname'])){
					$error++; $this->template->setError('"Achternaam" is niet ingevuld.');
				}

				if(empty($_POST['color'])){
					$error++; $this->template->setError('"Kleur" is niet ingevuld.');
				}
				
				if($_POST['canread'] != "0" && $_POST['canread'] != "1"){
					$error++; $this->template->setError('"Kan lezen" is niet ingevuld.');
				}
				
				//Voeg verjaardag bij elkaar
				$birthday = $_POST['birthdateYear'] . '-' . $_POST['birthdateMonth'] . '-' . $_POST['birthdateDay'];
				
				if($error == 0){
					//Zet alle info in sessie voor gebruik in step3 + opslag
					$this->setSession('clientColor', $_POST['color']);
					$this->setSession('clientName', $_POST['name']);
					$this->setSession('clientSurname', $_POST['surname']);
					$this->setSession('clientRead', $_POST['canread']);
					$this->setSession('clientBirthday', $birthday);
					$this->setSession('clientCharacter', $this->getCharacterByLetter(strtolower(substr($_POST['name'], 0, 1))));
					$this->setSession('clientLetter', strtolower(substr($_POST['name'], 0, 1)));
					
					unset($_POST);
				}else{
					$this->template->setError('<a href="javascript:history.go(-1);">Ga terug</a>');
				}
			}
			
			if(!empty($_SESSION['userName']) && !empty($_SESSION['userSurname']) && 
				!empty($_SESSION['userPassword']) && !empty($_SESSION['userID'])){
					//Vul de data met alle gezette sessies voor zowel client als user. Deze worden getoond in step3.php
					$arrayUser = array('userName' => $_SESSION['userName'],
								'userSurname' => $_SESSION['userSurname'],
								'userPassword' => $_SESSION['userPassword'],
								'userUserID' => $_SESSION['userID']);
					$this->template->setData('userSave', $arrayUser);
			}

			
			if(!empty($_SESSION['clientColor']) && !empty($_SESSION['clientName']) && 
				!empty($_SESSION['clientSurname']) && !empty($_SESSION['clientBirthday'])){
					$arrayClient = array('clientColor' => $_SESSION['clientColor'],
								'clientName' => $_SESSION['clientName'],
								'clientSurname' => $_SESSION['clientSurname'],
								'clientBirthday' => $_SESSION['clientBirthday'],
								'clientRead' => $_SESSION['clientRead'],
								'clientCharacter' => $_SESSION['clientCharacter'],
								'clientLetter' => $_SESSION['clientLetter']);
					$this->template->setData('clientSave', $arrayClient);
			}
		}
		
		
		function getCharacterByLetter($letter){
			$letter = strtolower($letter);
			
			$img = (count(getimagesize(BASEURL.$this->characterdir.$letter . '.png')) > 0) ? $this->characterdir.$letter . '.png' : $this->characterdir . 't.png';
			return '<img src="'.$img.'" alt="' . $letter . '">';
		}
		
		function finishRegistration(){
			if(!empty($_SESSION['userName']) && !empty($_SESSION['userSurname']) && 
				!empty($_SESSION['userPassword']) && !empty($_SESSION['userID']) &&
				!empty($_SESSION['clientColor']) && !empty($_SESSION['clientName']) && 
				!empty($_SESSION['clientSurname']) && !empty($_SESSION['clientBirthday'])){
						$userSave = array(
									new DataHandler('name', $_SESSION['userName']),
									new DataHandler('surname', $_SESSION['userSurname']),
									new DataHandler('activation', 1),
									new DataHandler('password', md5(sha1($_SESSION['userPassword']))));
						if($this->users->updateUser($userSave, $_SESSION['userID'])){
							$apikey = $this->generateApikey();
							$client = array(
										new DataHandler('name', $_SESSION['clientName']),
										new DataHandler('surname', $_SESSION['clientSurname']),
										new DataHandler('color', $_SESSION['clientColor']),
										new DataHandler('birthdate', $_SESSION['clientBirthday']),
										new DataHandler('can_read', $_SESSION['clientRead']),
										new DataHandler('character', $_SESSION['clientLetter']),
										new DataHandler('apikey', $apikey));
							if($this->users->saveClient($client, $_SESSION['userID'])){
								unset($_SESSION['userName']);
								unset($_SESSION['userSurname']);
								unset($_SESSION['userPassword']);
								unset($_SESSION['userID']);
								unset($_SESSION['clientColor']);
								unset($_SESSION['clientName']);
								unset($_SESSION['clientSurname']);
								unset($_SESSION['clientBirthday']);
								unset($_SESSION['clientRead']);
								unset($_SESSION['clientLetter']);
								unset($_SESSION['clientCharacter']);

								$this->template->setData('finished', $apikey);
							}else{
								$this->template->setError('Registratie gefaald!');
								$this->template->setError('<a href="javascript:history.go(-1);">Ga terug</a>');
							}
						}
				}
		}
		
		function generateApikey(){
			$number = $this->randomNumber();
			if($number){
				return $number;
			}
		}
		
		function randomNumber(){
			$number = rand(0, 99999);
			while(strlen($number) < 5){
				$number = '0'.$number;
			}
			if($this->numberIsUnique($number)){
				return $number;
			}else{
				$this->generateApiKey();
			}
		}
		
		function numberIsUnique($num){
			if(count($this->model->getApiKey($num)) > 0){
				return false;
			}else{
				return true;
			}
		}
		
		
		
		function registerUser(){
			//Kijk of email geset en gevuld is
			if(isset($_POST['email']) && !empty($_POST['email'])){
				//Kijk of het emailadres wel een ECHT emailadres is
				if($this->realEmail($_POST['email'])){
					//Kijk of het emailadres nog niet bestaat in de database
					if($this->emailExists($_POST['email']) == false){
						//Genereer een activatiecode
						$activationCode = md5(microtime().$_POST['email']);
						
						//Knip de eerste 15 tekens van de activatiecode af
						$activationCode = substr($activationCode, 0, 15);
						
						//Maak een array die doorgestuurd wordt ter INSERT
						$array = array(
							new DataHandler("email", $_POST['email']),
							new DataHandler("activation", $activationCode)
						);
						
						if($this->model->saveEmail($array)){
							//Hier moet nog een mailfunctie die de code opstuurt (Zie lib/swift)
							$to = $_POST['email'];
// Tegen de rand aan. De body ziet tabs als content!!!!
$body = 'Bedankt voor je aanmelding bij de dagplannerappdinges. Activeer je account door
op onderstaande link te klikken.<br><br>
<a href="http://dagplanner.envyum.nl/register/step1/' . $_POST["email"] . '/' . $activationCode.'">http://dagplanner.envyum.nl/register/step1/' . $_POST["email"] . '/' . $activationCode.'</a>';
							$subject = "Uw account dient geactiveerd te worden.";
							$mail = new Mail($to, $body, $subject);
							$this->template->setSucces('Uw e-mailadres is opgeslagen. U ontvangt zeer spoedig een e-mail met uitleg om uw registratie af te ronden. *tip: check uw spamfilter!');
						}else{
							$this->template->setError('Hij is niet opgeslagen. Probeer nog maar s');	
						}
					}else{
						$this->template->setError("Het emailadres bestaat al!!!!!");
					}
				}else{
					$this->template->setError("Het emailadres is niet echt!!!!!");
				}
			}
		}
		
		function emailExists($email){
			$emailadres = $this->model->getEmail($email);
			if(count($emailadres) == 0){
				return false;
			}else{
				return true;
			}
		}
		
		function realEmail($email){
			//Hier moet nog een emailcheckding komen
			//Als het een daadwerkelijke email is. Dan return true. Anders return false
			return true;
		}
	
	}
	

?>