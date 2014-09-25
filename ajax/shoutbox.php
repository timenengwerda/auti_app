<?php session_start(); ?>

<?php

define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");


require_once('../db/db.data.php');
require_once('../db/db.model.php');

$db = new DatabaseHandler();

if($_GET['action'] == "delete"){
	$id = $_GET['id'];
	if(is_numeric($id)){
		if($db->Query("DELETE FROM shoutbox WHERE messageID='".mysql_real_escape_string($id)."' LIMIT 1")){
			$db->Query("DELETE FROM shoutbox WHERE reply_to='".mysql_real_escape_string($id)."'");
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
}elseif($_GET['action'] == 'getReplies'){
	if(isset($_GET['id'])){
		//Query om replies van $_GET['id'] op te halen
		if(is_numeric($_GET['id'])){
			?>
			<style>
				.shout2{
					margin-top:7px !important; 
					padding-left:20px  !important; 
					width:210px !important; 
					border:0px !important; 
					border-top:1px solid #ccc !important;
					float:left !important;
				}
					 .sb{
						width:210px !important;
					}
			</style>
			<?php
			$qry = "SELECT a.*, b.name, b.surname
						 FROM shoutbox a, users b
						WHERE a.reply_to = '".mysql_real_escape_string($_GET['id'])."' 
						AND b.userID = a.userID
						ORDER BY a.post_date ASC
						LIMIT 5";
			$a = $db->Select($qry);
			if(!empty($a)){
				foreach($a as $shout){
					echo '
							<div class="shout shout2" id="shout'.$shout['messageID'].'">
								<div class="shoutInfo sb">
									<span class="name" style="width:100px;">'.ucfirst($shout['name']).' '.ucfirst($shout['surname']).'</span>
									<span class="date">'.date('d-m-Y H:i:s', strtotime($shout['post_date'])).'</span>
								</div>
								<div class="shoutContent sb">
									<P>
										'.nl2br($shout['message']).'
									</p>
								</div>';
								if($shout['userID'] == $_SESSION['userID']){
									echo '<div class="shoutInfo sb">
									<span class="name">
										<a href="javascript:void(0);" class="verwijder" onclick="del_message('.$shout['messageID'].')"> Verwijder</a>
									</span>
									<span class="date"></span>';
								}
								echo '</div>
							</div>
					';
					
				}
			}
				echo '
				<div class="newReply"></div>
				<div class="shout shout2">
						<form id="replyShoutForm-'.$_GET['id'].'" action="" method="post">
							<label class="name"><strong>Reageer</strong></label>
							<textarea name="shout" id="reply"></textarea>
							<input type="submit" value="Reageer" class="submitShout blueSmall shoutboxButton button submitShout" name="replyShout" onclick="addReply('.$_GET['id'].'); return false;">
						</form>
					</div>';
			
		}
	}
	
}elseif($_GET['action'] == 'saveShout'){
	$shout = $_GET['shout'];
	$reply = (is_numeric($_GET['reply_to'])) ? $_GET['reply_to'] : '0';
	$style = "";
	if($reply > 0){
		$style = "border:0px; border-top:1px solid #ccc;";
	}
	if(!empty($shout)){
		if(!empty($_SESSION['userID'])){
			//Hij is gevuld. Dus kijk of ie lang of kort genoeg is.
			if(strlen($shout) <= 250){
				$array = array(
					new DataHandler("message", htmlspecialchars($shout)),
					new DataHandler("userID", $_SESSION['userID']),
					new DataHandler("reply_to", $reply),
					new DataHandler("post_date", "NOW()", false)
				);
				$db->Insert('shoutbox', $array);
				$lastReply = $db->Select("SELECT * FROM shoutbox ORDER BY post_date DESC LIMIT 1");
				foreach($lastReply as $reply){
					$name = $db->Select("SELECT * FROM users WHERE userID = '".mysql_real_escape_string($reply['userID'])."'");
					echo '<div class="shout" style="float:left; '.$style.'">
						<div class="shoutInfo">
							<span class="name">'.$name[0]['name'].' '.$name[0]['surname'].'</span>
							<span class="date">'.date('d-m-Y H:i:s', strtotime($reply['post_date'])).'</span>
						</div>
						<div class="shoutContent">
							<P>
								'.nl2br($reply['message']).'
							</p>
						</div>
					</div>';
				}
			}else{
				echo 'Bericht mag niet meer dan 250 tekens.';
			}
		}else{
			echo 'user id bestaat niet';
		}
		//Check of alles ingevuld is
	}	
}
?>
