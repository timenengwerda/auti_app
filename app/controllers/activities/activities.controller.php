<?php
	class ActivitiesController extends BaseController{
		public $template;
		public $route;
		public $model;
		public $users;
		
		function __construct($template, $route){
			$this->route = $route;
			$this->template = $template;
			
			require_once('app/controllers/users.controller.php');
			$this->users = new UsersController($template);
			
			$this->model = new ActivitiesModel();
			if(!empty($this->route[1])){
				switch($this->route[1]){
					case 'add':
						$this->addActivity();
						if(!empty($this->route[2])){
							$this->template->setData('activity', $this->model->getActivity($this->route[2]));						
						}					
					break;
					
					case 'edit':
						$this->editActivity();
					break;
					
					case 'delete':
						$this->deleteActivity();
					break;
					
					case 'day':
						$this->getCurrentDayCalendar();
						$this->template->setData('activities', $this->model->getCurrentDayActivities());												
					break;

					case 'week':
						$this->getCurrentWeekCalendar();											
					break;

					case 'month':
						$this->getCurrentMonthCalendar();						
						$this->template->setData('activities', $this->model->getCurrentMonthActivities());		
					break;
															
					case 'delete':
					break;															
				}
			}else{
				$this->getCurrentMonthCalendar();
				$this->template->setData('activities', $this->model->getCurrentMonthActivities());
			}
			if(!empty($this->route[1])){
				$this->template->setData('route1', $this->route[1]);								
			}
		}
		
		function first_day_of_week(){
			$first_day = mktime(0,0,0,date('d', time()), 1, date('Y', time()));
			return $this->template->setData('first_day', $first_day);
		}
				
		function getCurrentDayCalendar(){
			$date = time();
			if(!empty($this->route[2])){
				$this->template->setData('current_month', $this->route[2]);
			} else {
				$this->template->setData('current_month', date('m', $date));
			}
		
			if(!empty($this->route[3])){
				$this->template->setData('current_year', $this->route[3]);
			} else {
				$this->template->setData('current_year', date('Y', $date));
			}			
			$this->template->setData('current_day', date('d', $date));
		}			

		function getCurrentMonthCalendar(){
			$date = time();
			if(!empty($this->route[2])){
				$this->template->setData('current_month', $this->route[2]);
			} else {
				$this->template->setData('current_month', date('m', $date));
			}
		
			if(!empty($this->route[3])){
				$this->template->setData('current_year', $this->route[3]);
			} else {
				$this->template->setData('current_year', date('Y', $date));
			}			
			$this->template->setData('current_day', date('d', $date));
		}	

		function getClientsByUser($userID){
			if(is_numeric($userID)){
				return $this->model->ClientsByUser($userID);
			}
		}
		
		function days_in_month($month, $year){
			return cal_days_in_month(CAL_GREGORIAN, $month, $year);
		}
		
		function first_day_of_month($month, $year){
			return date("w", mktime(0,0,0,$month-1,1,$year));
		}
		
		// Moet nog toegevoegd worden aan TO
		function getActivities(){
			$this->template->setData('activities', $this->model->getActivities());
		}		

		
		function addActivity(){
			//var_dump($_POST);
			//var_dump($_FILES);
			
			//Haal alle clienten van de beheerder op
			$this->template->setData('usersClients', $this->getClientsByUser($_SESSION['userID']));
			//Haal alle standaard pictogrammen op
			$this->template->setData('pictograms', $this->model->getPictograms());
			
			
			$client = $this->users->getClientinfo($_SESSION['userID']);
			$clientID = $client[0]['clientID'];
			
			
			
			//Haal alle custom pictogrammen op
			$this->template->setData('custom_pictograms', $this->model->getCustomPictograms($_SESSION['userID']));
			
			$error = 0;
			$defaultPictogram = 0;
			$customPictogram  = 0;
			$succesUpload     = 0;
			
			if(isset($_POST['submitActivity']) || isset($_POST['submitQuickadd'])){
				if(isset($_POST['submitActivity']) && empty($_POST['what'])){
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

				if(empty($_POST['where'])){
					$error++; $this->template->setError('"Waar" is niet ingevuld.');
				}

				// is er een default? dan overschrijft dat de custom
				if(isset($_POST['defaultpicto']) && !empty($_POST['defaultpicto'])){
					$defaultPictogram = $_POST['defaultpicto'];
					$customPictogram = 0;
				}
				
				// is er een custom gezet? dan overschrijft dat de default.			
				if(isset($_POST['custompicto']) && !empty($_POST['custompicto'])){
					$customPictogram = $_POST['custompicto'];
					$defaultPictogram = 0;
				}
								
				// dubbel gezet, mag ook niet
				if(isset($_POST['custompicto']) && isset($_POST['defaultpicto'])){
					$error++; 
					
					$this->template->setError('Er zijn twee pictogrammen geselecteerd.');
				}
				
				// opslaan van upload als deze er is
				if(isset($_FILES) && !empty($_FILES['custompicto']['name'])){
						
					// als er een custom pictogram is gezet, is het niet mogelijk om een default te kiezen.
					$defaultPictogram = 0;
										
					// stuurt door naar imagehandle, check, save, upload
					if($customPictogram = $this->imageHandle($_FILES , $_POST['customPhotoName'], $_SESSION['userID'])){
						
						
						$succesUpload = 1;
					}
					else{
						$error ++;
						$this->template->setError('Het uploaden van de afbeelding is niet gelukt');
					}		
				}
				
				// alles leeg, en geen nieuwe upload
				if(empty($_POST['defaultpicto']) && empty($_POST['custompicto']) && $succesUpload == 0){
					$error++; 
					
					$this->template->setError('Er is geen pictogram geselecteerd');
				}	
											
				//Combineer starttijd
				$starttime = $_POST['starthour'] . ':' . $_POST['startminute'] . ':' . $_POST['startsecond'];
				
				//Combineer eind tijd
				$endtime = $_POST['endhour'] . ':' . $_POST['endminute'] . ':' . $_POST['endsecond'];
				
				$startdate = strtotime($_POST['startdate'].' '. $starttime);
				$enddate = strtotime($_POST['enddate'].' '. $endtime);
				
				if($this->activiesOverflow($startdate, $enddate, $clientID) === true){
					$error++; $this->template->setError('Activiteiten mogen elkaar niet overlappen.');
				}
				
				if($error == 0){
					
					// als er een custompictogram geselecteerd is heeft deze voorrang.
					if(!empty($_POST['custompicto']) && isset($_POST['custompicto'])){
						$customPictogram =  $_POST['custompicto'];
					}
										
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
								$_POST['what'] = (!empty($_POST['what'])) ? $_POST['what'] : $this->getActivityTitle($defaultPictogram);
								$_POST['how'] = (!empty($_POST['how'])) ? $_POST['how'] : '';
								$_POST['repeat'] = (!empty($_POST['repeat'])) ? $_POST['repeat'] : '0';
								$arr = array(
										new DataHandler('what', $_POST['what']),
										new DataHandler('who', $_POST['who']),
										new DataHandler('location', $_POST['where']),
										new DataHandler('how', $_POST['how']),
										new DataHandler('start_time', $formattedStart),
										new DataHandler('end_time', $formattedEnd),
										new DataHandler('userID', $_SESSION['userID']),
										new DataHandler('clientID', $clientID),
										new DataHandler('pictogram', $defaultPictogram),
										new DataHandler('custompictogram', $customPictogram),
										new DataHandler('repeatmode', $_POST['repeat'])
										);
								
								if($this->model->addActivity($arr)){
									// als er nog een activiteit moet worden toegevoegd			
									if(isset($_POST['again']) && $_POST['again'] == 'true'){
										$this->template->setSucces('De activiteit is opgeslagen!');
										unset($_POST);
										
									}else{
										// stuurt terug naar activities
										header('location:'.BASEURL.'activities');
									}
									
								}
								else{
									$this->template->setError('De activiteit is niet opgeslagen. Probeer het opnieuw.');
								}
								
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
		
		function activiesOverflow($start, $end, $clientID){
			$startdate = date('d-m-Y', $start);
			$starttime = date('H:i:s', $start);
			
			$enddate = date('d-m-Y', $end);
			$endtime = date('H:i:s', $end);
			
			$startWeekday = date('w', $start);
			$startDay = date('d', $start);
			$startDayMonth = date('d-m', $start);
			 $sql = "
				SELECT 
					a.* 
				FROM 
					activities a 
				WHERE 
					a.clientID ='" . mysql_real_escape_string($clientID) . "'
				AND
				(
					(
						DATE_FORMAT(a.start_time, '%H:%i:%s') > '".$starttime."' 
						AND 
						DATE_FORMAT(a.end_time, '%H:%i:%s') < '".$endtime."'
					) 
					OR (
					(
						DATE_FORMAT(a.start_time, '%H:%i:%s') < '".$starttime."' 
						AND
						DATE_FORMAT(a.end_time, '%H:%i:%s') < '".$endtime."'
						AND
						DATE_FORMAT(a.end_time, '%H:%i:%s') > '".$starttime."'
					)
				)
					OR (
					(
						DATE_FORMAT(a.start_time, '%H:%i:%s') < '".$endtime."' 
						AND
						DATE_FORMAT(a.start_time, '%H:%i:%s') > '".$starttime."'
						AND
						DATE_FORMAT(a.end_time, '%H:%i:%s') > '".$endtime."'
					)
				)
					OR(
						DATE_FORMAT(a.start_time, '%H:%i:%s') < '".$starttime."' 
						AND
						DATE_FORMAT(a.end_time, '%H:%i:%s') > '".$endtime."'
					)
				)
				AND
				(
					DATE_FORMAT(a.start_time, '%d-%m-%Y') = '".$startdate."'
					OR
						a.repeatmode = 1
					OR
						(a.repeatmode = 2 AND DATE_FORMAT(a.start_time, '%w') = '".$startWeekday."')
					OR
						(a.repeatmode = 3 AND DATE_FORMAT(a.start_time, '%d') = '".$startDay."')
					OR
						(a.repeatmode = 4 AND DATE_FORMAT(a.start_time, '%d-%m') = '".$startDayMonth."')
				)";
				
		 	return (count($this->model->getOverlap($sql)) > 0) ? true : false;
		}
		
		function getActivityTitle($pictoID){
			if($pictoID != 0){
				$pic = $this->model->getActivityTitle($pictoID);
				if(!empty($pic)){
					return $pic[0]['name'];
				}
			}
			return '';
		}
		
		
		function editActivity(){
			// Haal alle informatie van de activiteit op waarvan de id gelijk is aan die in de url staat
			$this->template->setData('activity', $this->model->getActivity($this->route[2]));
			
			// Haal alle custom pictogrammen op van de ingelogde user
			$this->template->setData('custom_pictograms', $this->model->getCustomPictograms($_SESSION['userID']));			
			
			// Haal alle iconen op die in de database staan
			$this->template->setData('pictograms', $this->model->getPictograms());				
			
			// Haal alle informatie op van de ingelogde user
			$this->template->setData('usersClients', $this->getClientsByUser($_SESSION['userID']));			
			$error = 0;
			

			$client = $this->users->getClientinfo($_SESSION['userID']);
			$clientID = $client[0]['clientID'];

			
			if(isset($_POST['editActivity'])){
				if(isset($_POST['editActivity']) && empty($_POST['what'])){
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

				if(empty($_POST['where'])){
					$error++; $this->template->setError('"Waar" is niet ingevuld.');
				}
/*
				if(empty($_POST['clientID'])){
					$error++; $this->template->setError('"Client" is niet ingevuld.');
				}
				
				
*/				
				// is er een default? dan overschrijft dat de custom
				if(isset($_POST['defaultpicto']) && !empty($_POST['defaultpicto'])){
					$defaultPictogram = $_POST['defaultpicto'];
					$customPictogram = 0;
				}
				
				// is er een custom gezet? dan overschrijft dat de default.			
				if(isset($_POST['custompicto']) && !empty($_POST['custompicto'])){
					$customPictogram = $_POST['custompicto'];
					$defaultPictogram = 0;
				}
								
				// dubbel gezet, mag ook niet
				if(isset($_POST['custompicto']) && isset($_POST['defaultpicto'])){
					$error++; 
					
					$this->template->setError('Er zijn twee pictogrammen geselecteerd.');
				}
				
				// opslaan van upload als deze er is
				if(isset($_FILES) && !empty($_FILES['custompicto']['name'])){
						
					// als er een custom pictogram is gezet, is het niet mogelijk om een default te kiezen.
					$defaultPictogram = 0;
										
					// stuurt door naar imagehandle, check, save, upload
					if($customPictogram = $this->imageHandle($_FILES , $_POST['customPhotoName'], $_SESSION['userID'])){
						
						
						$succesUpload = 1;
					}
					else{
						$error ++;
						$this->template->setError('Het uploaden van de afbeelding is niet gelukt');
					}		
				}
					
												
				//Combineer starttijd
				$starttime = $_POST['starthour'] . ':' . $_POST['startminute'] . ':' . $_POST['startsecond'];
				
				//Combineer eind tijd
				$endtime = $_POST['endhour'] . ':' . $_POST['endminute'] . ':' . $_POST['endsecond'];
				
				$startdate = strtotime($_POST['startdate'].' '. $starttime);
				$enddate = strtotime($_POST['enddate'].' '. $endtime);
				
/*
				if($this->activiesOverflow($startdate, $enddate, $clientID) === true){
					$error++; $this->template->setError('Activiteiten mogen elkaar niet overlappen.');
				}
*/
				
			
				if($error == 0){
					

					// als er een custompictogram geselecteerd is heeft deze voorrang.
					if(!empty($_POST['custompicto']) && isset($_POST['custompicto'])){
						$customPictogram =  $_POST['custompicto'];
					}

										
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
								$_POST['what'] = (!empty($_POST['what'])) ? $_POST['what'] : $this->getActivityTitle($defaultPictogram);
								$_POST['how'] = (!empty($_POST['how'])) ? $_POST['how'] : '';
								$_POST['repeat'] = (!empty($_POST['repeat'])) ? $_POST['repeat'] : '0';
								$arr = array(
										new DataHandler('what', $_POST['what']),
										new DataHandler('who', $_POST['who']),
										new DataHandler('location', $_POST['where']),
										new DataHandler('how', $_POST['how']),
										new DataHandler('start_time', $formattedStart),
										new DataHandler('end_time', $formattedEnd),
										new DataHandler('userID', $_SESSION['userID']),
										new DataHandler('clientID', $clientID),
										new DataHandler('pictogram', $defaultPictogram),
										new DataHandler('custompictogram', $customPictogram),
										new DataHandler('repeatmode', $_POST['repeat'])
										);
								
								if($this->model->editActivity($arr, $this->route[2])){
									// als er nog een activiteit moet worden toegevoegd			
									if(isset($_POST['again']) && $_POST['again'] == 'true'){
										$this->template->setSucces('De activiteit is opgeslagen!');
										unset($_POST);
										
									}else{
										// stuurt terug naar activities
										header('location:'.BASEURL.'activities');
									}
								}
								else{
									$this->template->setError('De activiteit is niet opgeslagen. Probeer het opnieuw.');
								}
								
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
		
		function deleteActivity(){
			// Aan de model doorgeven welke activiteit er moet worden verwijderd
			if($this->model->deleteActivity($this->route[2])){
				$this->template->setSucces('De activiteit is succesvol verwijderd!');
			}
		}
		
		function imageHandle($_FILES, $file_name, $user_id){
			require_once('app/controllers/images.controller.php');
			$handler = new ImagesController($this->template, $this->route);	
					
			return $handler->uploadImage($_FILES, $file_name, $user_id);
		}
		function showActivity(){
		}			
	}

?>