<?php
	class ShoutboxController extends BaseController{
		public $template;
		public $route;
		public $model;
		public $shoutbox;
		
		function __construct($template, $route){
			$this->route = $route;
			$this->template = $template;
			$this->model = new ShoutboxModel();
			
			if(isset($_POST['submitShout'])){
				if(!empty($_POST['shout'])){
					$this->addShout($_POST['shout']);
				}else{
					$this->template->setError('Geen bericht ingevuld.');
				}
			}
		}
		
		function addShout($shout, $reply = '0'){
			//Kijk of user gesubmit heeft
			if(!empty($shout)){
				if(!empty($_SESSION['userID'])){
					//Hij is gevuld. Dus kijk of ie lang of kort genoeg is.
					if(strlen($shout) <= 250){
						$array = array(
							new DataHandler("message", $shout),
							new DataHandler("userID", $_SESSION['userID']),
							new DataHandler("reply_to", $reply),
							new DataHandler("post_date", "NOW()", false)
						);
						$this->model->saveMessage($array);
					}else{
						$this->template->setError('Bericht mag niet meer dan 250 tekens.');
					}
				}else{
					$this->template->setError('user id bestaat niet');
				}
				//Check of alles ingevuld is
			}	
		}
			/*if(!empty($this->route[1])){
				switch($this->route[1]){
					case 'reply':
						$this->replyShouts();
						$this->template->setData('replyID', $this->route[2]);
					break;
					case 'replies':
						$replies = $this->model->getReplies($this->route[2]);
						$this->template->setData('replies', $replies);
					break;
					default:
						$this->saveMessage();
					break;
				}
			}else{
				$this->saveMessage();
				$messages = $this->model->getShouts();
				$i = 0;
				foreach($messages as $message){
					$messages[$i]['replycount'] = count($this->model->getReplies($message['messageID']));
					$i++;					
				}
				$this->template->setData('messages', $messages);
				$this->replyShouts();

			}
		
	}

	function saveMessage(){
			//Kijk of user gesubmit heeft
			if(isset($_POST['submitShout'])){
				if(!empty($_SESSION['userID'])){
					// dan mag je door om te checken of het bericht gevuld is etc
					if(!empty($_POST['message'])){
						//Hij is gevuld. Dus kijk of ie lang of kort genoeg is.
						if(strlen($_POST['message']) <= 250){
							$array = array(
								new DataHandler("message", $_POST['message']),
								new DataHandler("userID", $_SESSION['userID']),
								new DataHandler("post_date", "NOW()", false)
							);
							$this->model->saveMessage($array);
						}else{
							$this->template->setError('"Bericht mag niet meer dan 250 tekens.');
						}
					}else{
						$this->template->setError('"Geen bericht ingvuld.');
					}
				}else{
					$this->template->setError('user id bestaat niet');
				}
				//Check of alles ingevuld is
			}
	}
	
	
		function replyShouts(){
			//Kijk of user gesubmit heeft
			if(isset($_POST['replyShout'])){
				if(!empty($_SESSION['userID'])){
					// dan mag je door om te checken of het bericht gevuld is etc
					if(!empty($_POST['reply'])){
						//Hij is gevuld. Dus kijk of ie lang of kort genoeg is.
						if(strlen($_POST['reply']) <= 250){
							$array2 = array(
								new DataHandler("message", $_POST['reply']),
								new DataHandler("userID", $_SESSION['userID']),
								new DataHandler("reply_to", $_POST['reply_to']),
								new DataHandler("post_date", "NOW()", false)
							);
							$this->model->replyShouts($array2);
						}else{
							$this->template->setError('"Bericht mag niet meer dan 250 tekens.');
						}
					}else{
						$this->template->setError('"Geen bericht ingvuld.');
					}
				}else{
					$this->template->setError('user id bestaat niet');
				}
				//Check of alles ingevuld is
		}
	}*/
}					
		
		
?>