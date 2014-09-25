<?php
	class DashboardController extends BaseController{
		public $template;
		public $activitiesModel;
		public $activitiesController;
		
		function __construct($template){
			$this->template = $template;
			$this->model = new DashboardModel();

			// je probeert naar binnen te cheaten
			if(isset($_SESSION['first_setup']) && $_SESSION['logged_in'] == 0){
				unset($_SESSION['first_setup']);
				
				echo '<meta http-equiv="refresh" content="0; url='.BASEURL.'login.php">';
				
			}	
			
			//var_dump($_COOKIE);
			//var_dump($_SESSION);
			
			$this->quickAdd();
			$this->weekCalendar();			
			$this->statistics();
			$this->shoutbox();
			$this->live_preview();
		}
		
		function shoutbox(){
			require_once('app/models/shoutbox/shoutbox.model.php');
			$this->shoutboxModel = new shoutboxModel();

			$messages = $this->shoutboxModel->getShouts();
			$i = 0;
			//$this->template->setData('shouts', $this->activitiesModel->getShouts());
			foreach($messages as $message){
				$messages[$i]['replycount'] = count($this->shoutboxModel->getReplies($message['messageID']));
				$i++;					
			}
			
			$this->template->setData('shouts', $messages);
		}
		
		
		function live_preview(){
			
			require_once('app/models/livepreview/livepreview.model.php');
			$this->activitiesModel = new LivePreviewModel();

			$activities = $this->activitiesModel->getDay($_SESSION['userID']);
			
			$count = count($activities);
			
			if($count == 1){
				$this->template->setData('day_activities', $activities);
			}
			else{
				$this->template->setData('no_activities', 'true');
			}
			
		}
		
		function statistics(){
			$clients = $this->model->getClientByUser($_SESSION['userID']);
			$data = array();
			foreach($clients as $client){
				
				$a = $this->model->getStatisticsByClients($client['clientID']);
				$client = array();
				$client['amountActivities'] = 0;
				$client['amountFinished'] = 0;
				foreach($a as $b){
					if($b['activityID'] > 0){
						$client['amountActivities']++;
						if($b['finished'] == 1){
							$client['amountFinished']++;
						}
					}
				}
				
				$client['lastSync'] = $a[0]['last_sync'];
				$client['lastLocation'] = $a[0]['last_location'];
				$client['name'] = ucfirst($a[0]['name']) .' '. ucfirst($a[0]['surname']);
				$data[] = $client;
			}
			$this->template->setData('clientStats', $data);
		}
		
		function quickAdd(){
			require_once('app/models/activities/activities.model.php');
			$this->activitiesModel = new ActivitiesModel();
			require_once('app/controllers/activities/activities.controller.php');
			$this->activitiesController = new activitiesController($this->template, $this->route);
			if(isset($_POST['submitQuickadd'])){
				$this->activitiesController->addActivity();
			}else{
				$this->template->setData('pictograms', $this->activitiesModel->getPictograms());
			}
		}
		
		function weekCalendar(){
			$dagen = array(); 
			$dagen['Monday'] = "Maandag"; 
			$dagen['Tuesday'] = "Dinsdag"; 
			$dagen['Wednesday'] = "Woensdag"; 
			$dagen['Thursday'] = "Donderdag"; 
			$dagen['Friday'] = "Vrijdag"; 
			$dagen['Saturday'] = "Zaterdag"; 
			$dagen['Sunday'] = "Zondag"; 	
					
			// Bekijk wat het huidige weeknummer is
			$week_number = date('W');
			// Huidige jaar 
			$year = date('Y');
			// Loop door alle dagen heen van maandag t/m vrijdag
			for($day=1; $day<=7; $day++)
			{
				$this->template->setData($day, $this->activitiesModel->getActivityByDay(date('Y-m-d', strtotime($year."W".$week_number.$day)), $_SESSION['userID']));				
			}			
		}
		
	}

?>