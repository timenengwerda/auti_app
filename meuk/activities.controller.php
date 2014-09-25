<?php
	class ActivitiesController extends BaseController{
		public $template;
		public $route;
		public $model;
		
		function __construct($template, $route){
			$this->route = $route;
			$this->template = $template;
			$this->model = new ActivitiesModel();
			if(!empty($this->route[1])){
				switch($this->route[1]){
					case 'add':
						$this->addActivity();
					break;
					
					case 'edit':
						$this->editActivity();
					break;
					
					case 'delete':
						$this->deleteActivity();
					break;
				}
			}else{
				$this->showActivity();
			}
		}
		
		function showActivity(){
			
		}
		
		function getClientsByUser($userID){
			if(is_numeric($userID)){
				return $this->model->ClientsByUser($userID);
			}
		}

		
		function addActivity(){
			var_dump($_POST);
			var_dump($_FILES);
			//Haal alle clienten van de beheerder op
			$this->template->setData('usersClients', $this->getClientsByUser($_SESSION['userID']));
			//Haal alle standaard pictogrammen op
			$this->template->setData('pictograms', $this->model->getPictograms());
			
			$error = 0;
			$defaultPictogram = 0;
			
			if(isset($_POST['submitActivity'])){
				if(empty($_POST['what'])){
					$error++; $this->template->setError('"Wat" is niet ingevuld.');
				}
				if(empty($_POST['who'])){
					$error++; $this->template->setError('"Wie" is niet ingevuld.');
				}
				if(empty($_POST['startdate'])){
					$error++; $this->template->setError('"Startdatum" is niet ingevuld.');
				}
				if(empty($_POST['starthour']) && empty($_POST['startminute']) && empty($_POST['startsecond'])){
					$error++; $this->template->setError('"Starttijd" is niet ingevuld.');
				}
				if(empty($_POST['enddate'])){
					$error++; $this->template->setError('"Einddatum" is niet ingevuld.');
				}
				if(empty($_POST['endhour']) && empty($_POST['endminute']) && empty($_POST['endsecond'])){
					$error++; $this->template->setError('"Eindtijd" is niet ingevuld.');
				}
				if(empty($_POST['how'])){
					$error++; $this->template->setError('"Hoe" is niet ingevuld.');
				}
				if(empty($_POST['where'])){
					$error++; $this->template->setError('"Waar" is niet ingevuld.');
				}
				if(empty($_POST['clientID'])){
					$error++; $this->template->setError('"Client" is niet ingevuld.');
				}
				
				if(isset($_POST['defaultpicto']) && !empty($_POST['defaultpicto'])){
					$defaultPictogram = $_POST['defaultpicto'][0];
				}
				
				if(isset($_FILES) && !empty($_FILES)){
					$this->imageHandle($_FILES , $_POST['custom_what'], $_POST['clientID']);
				}
				
				if($error == 0){
					//Combineer starttijd
					$starttime = $_POST['starthour'] . ':' . $_POST['startminute'] . ':' . $_POST['startsecond'];
					//Combineer eind tijd
					$endtime = $_POST['endhour'] . ':' . $_POST['endminute'] . ':' . $_POST['endsecond'];
					
					//Combineer en strtotime startdatum+starttijd
					$start = strtotime($_POST['startdate'] . ' ' . $starttime);
					//Combineer en strtotime einddatum+eindtijd
					$end = strtotime($_POST['enddate'] . ' ' . $endtime); 
					
					//De huidige starttijd moet in de toekomst zijn
					if($start > time()){
						if($end > time()){
							if($end > $start){
								//Format de datums naar de standaard datetime format
								$formattedStart = date('Y-m-d H:i:s', $start);
								$formattedEnd = date('Y-m-d H:i:s', $end);
								$arr = array(
										new DataHandler('what', $_POST['what']),
										new DataHandler('who', $_POST['who']),
										new DataHandler('location', $_POST['where']),
										new DataHandler('how', $_POST['how']),
										new DataHandler('start_time', $formattedStart),
										new DataHandler('end_time', $formattedEnd),
										new DataHandler('userID', $_SESSION['userID']),
										new DataHandler('clientID', $_POST['clientID']),
										new DataHandler('pictogram', $defaultPictogram)
										);
								/*if($this->model->addActivity($arr)){
									$this->template->setError('Succes!');
								}else{
									$this->template->setError('Faal!');
								}*/
							}else{
								$this->template->setError('Eind tijd is lager dan de start tijd');
							}
						}else{
							$this->template->setError('Eind tijd is lager dan de huidige datum');
						}
					}else{
						$this->template->setError('Startdatum is lager dan huidige datum!');
					}
				}
			}
		}
		
		function editActivity(){
			echo 'editactivity';
		}
		
		function deleteActivity(){
			echo 'delete';
		}
		
		function imageHandle($_FILES, $file_name, $user_id){
			require_once('image.controller.php');
			$handler = new ImageController($this->template, $this->route);
			
			var_dump($handler);
			$this->$handler->ImageController->uploadImage($_FILES, $file_name, $user_id);

		}
		
	}

?>