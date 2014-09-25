<?php
$pictograms = $this->data['pictograms'];
if(!empty($this->data['activity'][0])){
	$activity = $this->data['activity'][0];
}
if(!empty($_POST['date'])){
	$startdate = date("d-m-Y", strtotime($_POST['date']));
	$enddate = date("d-m-Y", strtotime($_POST['date']));
}
elseif(!empty($activity)){
	$startdate = date("d-m-Y", strtotime($activity['start_time']));	
	$starthour = date("H", strtotime($activity['start_time']));	
	$startminute = date("i", strtotime($activity['start_time']));	
	
	$enddate = date("d-m-Y", strtotime($activity['end_time']));	
	$endhour = date("H", strtotime($activity['end_time']));	
	$endminute = date("i", strtotime($activity['end_time']));	
}
?>
<script type="text/javascript" src="/public/javascript/activities.js"></script>
<script type="text/javascript">
	$(function () {
		$(window).load(function () {
			document.forms['addActivity'].elements['what'].focus();
		});
	})
</script>
	<div id="columnLeft">
			<div class="blockLeft">
				<ul class="subMenu">
					<li class="active">
						<a href="<?php echo BASEURL; ?>activities/add">Activiteit toevoegen</a>
					</li>
					<li>
						<a href="<?php echo BASEURL; ?>activities">Activiteiten tonen</a>
					</li>
					<li>
						<a href="<?php echo BASEURL; ?>settings">Pictogrammen beheren</a>
					</li>

				</ul>
			</div>
	</div>
	<div id="columnRight">
		<div class="activitiesAdd">
			<div class="title">
				<h1>Activiteiten</h1>
				<h2> - Activiteit <?php echo (!empty($activity)) ? 'kopiëren' : 'toevoegen' ?></h2>	
				<div class="progressbar_container">
					<div id="progressbar"></div>
				</div>
				
				<div class="percentage">
				</div>
			</div>				
		<form action="" method="post" enctype="multipart/form-data" id="addActivity">
		<div class="addActivityAllForm">
		<?php //echo ($activity['pictogram'] == $picto['pictogramID']) ? 'checked' : ''; ?>
		<?php
		
		if(!empty($pictograms)){
			echo '<h3 style="margin-left:10px; margin-top:10px;">Pictogrammen</h3>';
			echo '<div class="pictogramContainer" id="normalPictogramContainer">';
			
			foreach($pictograms as $picto){
				if(!empty($activity)){
					$checked = ($activity['pictogram'] == $picto['pictogramID']) ? 'checked' : '';										
					$style = ($activity['pictogram'] == $picto['pictogramID']) ? 'border: 2px solid #08C; opacity: 1;' : 'border: 0px; opacity: 0.7;';
				} else {
					$checked = '';
					$style = '';
				}
				echo '<span class="pictogramSelection"><input id="default_'.$picto['pictogramID'].'" type="radio" class="defaultPictoRadio" name="defaultpicto" value="' . $picto['pictogramID'] . '" checked="'.$checked.'">';
				
				
				echo '<img style="'.$style.'" id="default_click_'.$picto['pictogramID'].'" class="defaultPictogram" src="/public/images/default/' . $picto['filename'] . '"> ' . $picto['name'] . '</span>';
			}
			echo '</div>';
			
		}
		
		$custom_pictograms = $this->data['custom_pictograms'];
		
		if(!empty($custom_pictograms)){
		
			echo '<div class="pictogramContainer" id="customPictogramContainer">';
			echo '<h3>Eigen pictogrammen</h3>';
			
			foreach($custom_pictograms as $custom_picto){
				if(!empty($activity)){
					$checked = ($activity['custompictogram'] == $custom_picto['pictogramID']) ? 'checked' : '';									
					$style = ($activity['custompictogram'] == $custom_picto['pictogramID']) ? 'border: 2px solid #08C; opacity: 1;' : 'border: 0px; opacity: 0.7;';
				} else {
					$checked = '';
					$style = '';
				}
				
				$checked = (!empty($activity['custompictogram']) == $custom_picto['pictogramID']) ? 'checked' : '';
				
				echo '<span class="pictogramSelection"><input id="custom_'.$custom_picto['pictogramID'].'"type="radio" class="defaultPictoRadio" name="custompicto" value="' . $custom_picto['pictogramID'] . '" checked="'.$checked.'">';
				
				echo '<img id="default_click_'.$custom_picto['pictogramID'].'" class="customPictogram" src="/public/images/custom/' . $custom_picto['filename'] . '"> ' . $custom_picto['name'] . '</span>';
			}
			echo '</div>';
		}
		
		?>
		<div class="OwnPictoButtons">
			<?php
				if(!empty($custom_pictograms)){
					echo '<a href="Javascript:void(0);" class="ownPicto button blueBig left ownImage">Eigen Pictogrammen</a>';
				}
			?>
			<a href="Javascript:void(0);" class="uploadCustomButton button blueBig left ownImage">Pictogram uploaden</a>
		</div>
		
		<div class="formColumnLeft">
			<div class="customPicto_upload">
				<label>Naam:</label>
				<input type="text" name="customPhotoName" id="customPhotoName">	
				<label>Bestand</label><input type="file" name="custompicto"/>
				
				<a href="javascript:void(0);" class="close_upload button redSmall left ownImage">Sluiten</a>
			</div>
			<p>
				<label>Wat</label>
				<input type="text" name="what" class="textField" value="<?php echo (!empty($activity['what'])) ? $activity['what'] : "" ?>">
			</p>
			<p>
				<label>Met wie?</label>
				<input type="text" name="who" class="textField" value="<?php echo (!empty($activity['who'])) ? $activity['who'] : "" ?>">
			</p>
			<p>
				<label>Startdatum</label>
				<input type="text" name="startdate" class="textField" id="date1" value="<?php echo (!empty($startdate)) ? $startdate : ""; ?>">
			</p>
			<p>
				<label>Starttijd</label>
				<input type="text" name="starthour" value="<?php echo (!empty($starthour)) ? $starthour : date('H') ?>" class="textField timeInput"> 
		
				<span class="time_indicator">: </span>
				<input type="text" name="startminute" value="<?php echo (!empty($startminute)) ? $startminute : date('i', strtotime("+5 minute")) ?>" class="textField timeInput"> <span class="time_indicator">: </span>
				<input type="text" name="startsecond"  value="00" class="textField timeInput"><br>
			</p>
			<p>
				<label>Einddatum*</label>
				<input type="text" name="enddate" class="textField" id="date2" value="<?php echo (!empty($enddate)) ? $enddate : "" ?>">
			</p>
			<p>
				<label>Eindtijd*</label>
				<input type="text" name="endhour" value="<?php echo (!empty($endhour)) ? $endhour : date('H', strtotime("+1 hour")) ?>" class="textField timeInput"> <span class="time_indicator">: </span>
				<input type="text" name="endminute" value="<?php echo (!empty($startminute)) ? $startminute : date('i', strtotime("+5 minute")) ?>" class="textField timeInput"> <span class="time_indicator">: </span> 
				<input type="text" name="endsecond" value="00" class="textField timeInput"><br>
			</p>
			<p>
				<label>Hoe</label>
				<textarea class="how" class="textField" name="how"><?php echo (!empty($activity['how'])) ? $activity['how'] : "" ?></textarea>
			</p>
			<p>
				<label>Waar</label>
				<input type="text" name="where" class="textField" value="<?php echo (!empty($activity['location'])) ? $activity['location'] : "" ?>">		
			</p>
			<p>
				<div id="repeat">
					<label class="repeatLabel">Herhaling</label>
					<select id="repeatMode" name="repeat">
						<option value="0" <?php echo (!empty($activity['repeatmode']) == '0') ? 'selected' : ''; ?>>Niet herhalen</option>
						<option value="1" <?php echo (!empty($activity['repeatmode']) == '1') ? 'selected' : ''; ?>>Dagelijks</option>
						<option value="2" <?php echo (!empty($activity['repeatmode']) == '2') ? 'selected' : ''; ?>>Wekelijks</option>
						<option value="3" <?php echo (!empty($activity['repeatmode']) == '3') ? 'selected' : ''; ?>>Maandelijks</option>
						<option value="4" <?php echo (!empty($activity['repeatmode']) == '4') ? 'selected' : ''; ?>>Jaarlijks</option>
					</select>
				</div>
			</p>
			<p>
				<?php
				$clientsFromUsers = $this->data['usersClients'];
				
				if(!empty($clientsFromUsers)){
				$amountClients = count($clientsFromUsers);
				
				if($amountClients > 1){
					echo '<label>Voor*</label>
					<select name="clientID">';
					foreach($clientsFromUsers as $client){ 
						echo '<option value="' . $client['clientID'] . '">
						' . $client['name'] . ' ' . $client['surname'] . '
						</option>';
					}
					echo '</select>';
				}
				else{
				?>
					<input type="hidden" name="clientID" value="<?php echo $clientsFromUsers[0]['clientID']; ?>">
				<?php 
					}
				}?>
			</p>
			</p>
			<p>
				<input type="hidden" id="another_activity" name="again" value="">
				<input type="submit" name="submitActivity" class="button blueBig submitActivityAndAgain" value="Opslaan en doorgaan">
				<input type="submit" name="submitActivity" class="button blueSmall" value="Toevoegen">
			</p>
			
				</div>
			</form>
</div></div>