<?php
class UsersController{
	public $model;
	public $template;
	function __construct($tmplate){
		require_once('app/models/users.model.php');
		$this->model = new UsersModel();
		$this->template = $tmplate;
	}
	
	function getUserinfo($userID){
		return $this->model->getUsers("WHERE userID = '" . mysql_real_escape_string($userID) . "'");
	}
	function getClientinfo($userID){
		return $this->model->getClientByUser($userID);
	}
	
	function getClientByID($clientID){
		return $this->model->getClients("WHERE clientID = '" . mysql_real_escape_string($clientID) . "'");
	}
	
	function checkActivation($email, $activation){
		if(!empty($email) && !empty($activation)){
			if(strlen($activation) == 15){
				return $this->model->getUsers("WHERE email = '" . mysql_real_escape_string($email) . "' AND activation = '" . mysql_real_escape_string($activation) . "'");
			}
		}
	}
	
	function updateUser($arr, $userID){
		if(is_numeric($userID)){
			return $this->model->updateUser($arr, $userID);
		}
	}
	
	function saveClient($arr, $userID){
		if(is_numeric($userID)){
			if(!empty($arr)){
				$clientSaved = $this->model->saveClient($arr);
				if($clientSaved){
					return $this->mergeClientAndUser(mysql_insert_id(), $userID);
				}else{
					return false;
				}
			}
		}
	}
	function mergeClientAndUser($clientID, $userID){
		if(is_numeric($clientID) && is_numeric($userID)){
			$arr = array(
						new DataHandler('clientID', $clientID),
						new DataHandler('userID', $userID)
						);
			return $this->model->mergeClientAndUser($arr);
		}
	}
	
	function checkPasswords($password, $passwordcheck){
			//Check of wachtwoorden gevuld zijn
			if(!empty($password) && !empty($passwordcheck)){
				//Check of wachtwoorden overeen komen
				if($password == $passwordcheck){
					if(ctype_alnum($password)){
						if(strlen($password) > 7){
							return true;
						}else{
							
							$this->template->setError("Het wachtwoord moet minstens 8 tekens lang zijn.");
							return false;
						}
					}else{
						$this->template->setError('Wachtwoord mag alleen a-z 0-9 bevatten.');
						return false;
					}		
				}else{
					$this->template->setError('Wachtwoorden komen niet overeen.');
					return false;
				}
			}else{
				$this->template->setError('Wachtwoorden niet correct ingevuld.');
				return false;
			}
		}
}
?>