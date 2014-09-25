<script type="text/javascript" src="/public/javascript/activities.js"></script>
<script type="text/javascript" src="/public/javascript/dashboard.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="/public/stylesheet/activities.css" />
<style type="text/css">
.weekagenda {
  float: left;
  border-right: 1px solid #cacaca;
  height: 200px;
}
.weekagenda:first {
}
.weekagenda h3 {
	width: 83px;
	text-align: center;
	margin: 0 5px 0 5px;
	font-size: 14px;
}
.weekagenda a {
	text-decoration: none;
}
.weekagenda li {
	width: 75px;
	font-size: 13px;
	color: white;
	text-align: center;
	padding: 4px;
	margin: 5px 4px 0 4px;
	border: 1px solid #f73c2f;
	border-radius: 4px;
	background-color: #ff6e64;
	overflow: hidden;
}
.weekagenda li strong {
	font-weight: bold;
	display: block;
	font-size: 11px;
}
.weekagenda li:last-child {
	border-right: none;
	background: red;
}
</style>
	<div class="box toevoegen">
			<h2>Snel toevoegen</h2>
			<form method="POST" id="quickadd" action="">
				<label>Wat?</label>
				<div class="pictogramContainer">
					<?php 
					$pictograms = $this->data['pictograms'];
					if(!empty($pictograms)){
						foreach($pictograms as $picto){
							
							echo '<span class="pictogramSelection"><input id="default_'.$picto['pictogramID'].'" type="radio" class="defaultPictoRadio" name="defaultpicto" value="' . $picto['pictogramID'] . '">';
							echo '<img id="default_click_'.$picto['pictogramID'].'" class="defaultPictogram" src="/public/images/default/' . $picto['filename'] . '"><br>' . $picto['name'] . '</span>';
						}
					}

					?>
				</div>
				<label>Met wie?</label>
				<input type="text" class="textField" name="who" id="whoFocus" value="<?php echo (!empty($_POST['who'])) ? $_POST['who'] : "Alleen" ?>">
				
				<label>Startdatum</label>
				<input type="text" class="textField" name="startdate" value="<?php echo date('d-m-Y');?>" id="date1" class="textField">
				
				<label>Starttijd</label>
				<input type="text" name="starthour" value="<?php echo date('H');?>" class="textField timeInput"> 
				<span class="time_indicator">: </span>
				<input type="text" name="startminute" value="<?php echo date('i', strtotime("+5 minute"));?>" class="textField timeInput"> <span class="time_indicator">: </span>
				<input type="text" name="startsecond"  value="00" class="textField timeInput"><br>
				<label>Einddatum*</label>
				<input type="text" name="enddate" value="<?php echo date('d-m-Y');?>" id="date2" class="textField">
				<label>Eindtijd*</label>
				<input type="text" name="endhour" value="<?php echo date('H', strtotime("+1 hour"));?>" class="textField timeInput"> <span class="time_indicator">: </span>
				<input type="text" name="endminute" value="<?php echo date('i', strtotime("+5 minute"));?>" class="textField timeInput"> <span class="time_indicator">: </span> 
				<input type="text" name="endsecond" value="00" class="textField timeInput"><br>

				<label>Waar</label>
				<input type="text" class="textField" name="where" value="<?php echo (!empty($_POST['where'])) ? $_POST['where'] : "" ?>">
				<input type="submit" name="submitQuickadd" value="Toevoegen" class="button blueSmall quickaddButton"></span><br>
				<a href="/activities/add" style="clear:both; font-size:11px; color:#08c; float:right; display:block;">Of gebruik het uitgebreide formulier</a>
			</form>
			</p>
			
		</div>
		
		<div class="box activiteit">
			<h2 style="float:left;" >Activiteiten overzicht</h2>
			<a style="float:right;" class="button greenBig" href="/activities/add">Activiteit toevoegen</a>
			<div style="clear: both;"></div> <!-- Speciaal voor timen, en anders moet er maar een andere oplossing komen xd -->
			
			<?php
			// Vertaal alle dagen naar nederlandse dagen
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
			    echo '
					<ul class="weekagenda" style="margin-left: 0px;">
						<h3>'.$dagen[date('l', strtotime($year."W".$week_number.$day))].' '.date('j/m', strtotime($year."W".$week_number.$day)).'</h3>';
					
					foreach($this->data[$day] as $ac){
						$start = date('H:i', strtotime($ac['start_time']));
						$end = date('H:i', strtotime($ac['end_time'])); 
						
						echo '<a href="/activities"><li style="background: '.$ac['color'].'; border-color: '.$ac['color'].';"><strong>'.$start.' - '.$end.'</strong> '.$ac['what'].'</li></a>';
					}
					echo '</ul>';
			}
		
			?>			
		</div>

		<div class="box shoutbox">
			<h2>Vraagbaak</h2>
			<div class="shoutboxLeft">
				<style>
					.shoutInfo a{
						font-size:10px;
						color:#08c;
						margin-top:4px;
					}
				</style>
				<?php
				foreach($this->data['shouts'] as $shout){
					echo '
							<div class="shout" id="shout'.$shout['messageID'].'">
								<div class="shoutInfo">
									<span class="name">'.ucfirst($shout['name']).' '.ucfirst($shout['surname']).'</span>
									<span class="date">'.date('d-m-Y H:i:s', strtotime($shout['post_date'])).'</span>
								</div>
								<div class="shoutContent">
									<P>
										'.nl2br($shout['message']).'
									</p>
								</div>
								<div class="shoutInfo">
									<span class="name">';
										if($shout['userID'] == $_SESSION['userID']){
											echo '<a href="javascript:void(0);" class="verwijder" onclick="del_message('.$shout['messageID'].');"> Verwijder</a>';
										}
								echo '</span>
										<span class="date"><a href="javascript:void(0);" class="replies" onclick="get_replies('.$shout['messageID'].');">Reacties('.$shout['replycount'].')</a></span>
								</div>
								<div class="shoutReplies" style="display:none;" id="replyFrom'.$shout['messageID'].'">
								
								</div>
							</div>
					';
				}
				?>

			</div>
			<div class="shoutboxRight">
				<form method="post" id="shoutboxForm" action="">
					<h3>Nieuw bericht:</h2>
					<textarea name="shout" id="daShout" type="text"></textarea>
					<input type="submit" name="submitShout" value="Plaatsen" class="button blueSmall shoutboxButton submitShout">
				</form>
			</div>
			
		</div>
		
				<div id="iphone">
		
			<div class="iphone_wrapper">
					<h2>Live Preview</h2>
				<div class="top_bar">
					<div class="character">
					<?php
					if(!empty($this->data['day_activities'])){
						
						$letter = $this->data['day_activities'][0]['character'];
						
						$img = (count(getimagesize(BASEURL.'/public/images/character/'.$letter . '.png')) > 0) ? '/public/images/character/'.$letter . '.png' : '/public/images/character/t.png';
						echo '<img width="35" src="'.$img.'" alt="' . $letter . '">';

					}
					?>
						
					</div>
					<div class="date">
						<!-- zie clock.js !-->
					</div>
					<div class="time" id="clock">
						<!-- zie clock.js !-->
					</div>
				</div>
				<?php
						
				if(!empty($this->data['no_activities']) && $this->data['no_activities'] == 'true'){
					echo '<div class="activities_wrapper">';
						echo '<div class="no_activity">';
						echo 'Er zijn op dit moment geen activiteiten';
						echo '</div>';
					echo '</div>';
				}
				
				
				if(!empty($this->data['day_activities'])){
				
					foreach($this->data['day_activities'] as $day_activities){
						
						if($day_activities['custompictogram'] > 0){
							$path = "public/images/custom/";
							$filename = $day_activities['custom_filename'];
						}
						
						if($day_activities['pictogram'] > 0){
							$path = "public/images/default/";
							$filename = $day_activities['filename'];
						}

											
						echo '<div class="images_container">';	
							echo '<div class="current_picto">';
							echo'	<img src="'.$path.''.$filename.'"/>';
							echo '</div>';
						echo '</div>';
						
						
						echo '<div class="activities_wrapper">';
						
						echo '<div class="activity">';
							echo '<div class="activity_icon task"></div>';
							echo '<div class="activity_title">Taak:</div>';
							echo '<div class="activity_text">'.$day_activities['what'].'</div>';
							echo '</div>';
								
							echo '<div class="activity">';
								echo '<div class="activity_icon who"></div>';
								echo '<div class="activity_title">Met:</div>';
								echo '<div class="activity_text">'.$day_activities['who'].'</div>';
							echo '</div>';
							
							echo '<div class="activity">';
								echo '<div class="activity_icon activity_time"></div>';
								echo '<div class="activity_title">Tijd:</div>';
								echo '<div class="activity_text">'.$day_activities['real_time'].'</div>';
							echo '</div>';
						echo '</div>';						
					}
				}
				?>
									
			</div>
		
		</div>