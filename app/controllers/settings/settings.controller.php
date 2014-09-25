<?php
	class SettingsController extends BaseController{
		public $template;
		public $route;
		public $model;
		public $users;
		
		function __construct($template, $route){
			require_once('app/controllers/users.controller.php');
			$this->users = new UsersController($template);			
			
			$this->route = $route;
			$this->template = $template;
			$this->model = new SettingsModel();
			
			if(isset($_SESSION['userID'])){
				if(!empty($this->route[1])){
					switch($this->route[1]){
						case 'editclient':
							if(!empty($this->route[2]) && $this->clientBelongsToUser($_SESSION['userID'], $this->route[2])){
								if(isset($_POST['clientEditSubmit'])){
									$this->editClient($_POST);
								}
								$this->showClients();
							}
						break;
						case 'edituser':
							if(!empty($this->route[2]) && $this->route[2] == $_SESSION['userID']){
								if(isset($_POST['userEditSubmit'])){
									$this->editUser($_POST);
								}
								$this->showUsers();
							}
						break;
					}
				}else{
					$this->showUsers($_SESSION['userID']);
					$this->showClients($_SESSION['userID']);
					$this->showMedia($_SESSION['userID']);
				}
			}
		}
		
		function clientBelongsToUser($userID, $clientID){
			foreach($this->users->getClientinfo($userID) as $client){
				if($clientID == $client['clientID']){
					if($userID == $client['userID']){
						return true;
					}
					return false;
				}
			}
		}
		
		function showUsers($id=''){
			if(!empty($this->route[2])){
				$this->template->setData('userInfo', $this->users->getUserinfo($this->route[2]));
			}else{
				$this->template->setData('userInfo', $this->users->getUserinfo($id));
			}
		}
		
		function showClients($id=''){
			if(!empty($this->route[2])){
				$this->template->setData('clientInfo', $this->users->getClientByID($this->route[2]));
			}else{
				$this->template->setData('clientInfo', $this->users->getClientinfo($id));
			}
		
		}
		
		function editClient($post){
			if(!empty($post['name']) && !empty($post['surname']) && !empty($post['color'])){
			//var_dump($post);
				$birthdate = $post['birthdateYear'] . '-' . $post['birthdateMonth'] . '-' . $post['birthdateDay'];

				if(strlen($post['character']) == 1){
					if(!empty($birthdate)){
						if(is_numeric($this->route[2])){
							$arr = array(
								new DataHandler('name', $post['name']),
								new DataHandler('surname', $post['surname']),
								new DataHandler('color', $post['color']),
								new DataHandler('can_read', $post['canread']),
								new DataHandler('`character`', $post['character']),
								new DataHandler('birthdate', $birthdate)
								);
							if($this->model->saveClient($arr, $this->route[2])){
								$this->template->setSucces('Formulier opgeslagen. <a href="'.BASEURL.'settings">Terug naar instellingen</a>');
							}
						}else{
							$this->template->setError('ClientID is onjusit.');
						}
					}else{
						$this->template->setError('Verjaardag is niet ingevuld.');
					}
				}else{
					$this->template->setError('Het karakter klopt niet.');
				}
			}else{
				$this->template->setError('&Eacute;&eacute;n of meerdere velden zijn niet ingevuld.');
			}
		}
		
		function emailExists($email, $userID){
			//Haal emailadres en userID op
			$emailadres = $this->model->getEmail($email);
			
			//Als de userID die opgehaald wordt gelijk is aan de user die ge-edit wordt mag het emailadres door gelaten worden
			//
			if($userID != $emailadres[0]['userID']){
				if(count($emailadres) == 0){
					return false;
				}else{
					return true;
				}
			}else{
				return false;
			}
		}
		
		function editUser($post){
			if(!empty($post['name']) && !empty($post['surname']) && !empty($post['email'])){
				if(is_numeric($this->route[2])){
					if($this->emailExists($_POST['email'], $this->route[2]) == false){
						if(isset($post['password']) && !empty($post['password'])){
							//Als het wachtwoord ingevuld is moet deze kloppen voordat de gebruiker opgeslagen kan worden
							// Als het wachtwoord niet ingevuld wordt dan wordt de gebruiker in de else opgeslagen zonder nieuw wachtwoord
							if($this->users->checkPasswords($post['password'], $post['passwordcheck'])){
								$arr = array(new DataHandler('name', $post['name']),
									new DataHandler('surname', $post['surname']),
									new DataHandler('email', $post['email']),
									new DataHandler('password', md5(sha1($post['password'])))
									);
								if($this->model->saveUser($arr, $this->route[2])){
									$this->template->setSucces('Gebruiker opgeslagen <a href="'.BASEURL.'settings">Terug naar instellingen</a>');
								}
							}
						}else{
							$arr = array(new DataHandler('name', $post['name']),
								new DataHandler('surname', $post['surname']),
								new DataHandler('email', $post['email'])
								);
							if($this->model->saveUser($arr, $this->route[2])){
								$this->template->setSucces('Gebruiker opgeslagen <a href="'.BASEURL.'settings">Terug naar instellingen</a>');
							}
						}
					}else{
						$this->template->setError('Het emailadres bestaat al');
					}
				}else{
					$this->template->setError('userID is onjuist.');
				}
			}else{
				$this->template->setError('&Eacute;&eacute;n of meerdere velden zijn niet ingevuld.');
			}
			
		}
		
		
		function showMedia($userID){
			//Haal alle custom pictogrammen op
			$this->template->setData('custom_pictograms', $this->model->getCustomPictograms($userID));			
		}
	}
?>