<link href="/public/stylesheet/instellingen.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript" src="/public/javascript/colourpicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/public/javascript/registration.js"></script>

	<div id="content">
	<div class="columnFull">
	<div class="title">
		<h1>Instellingen</h1>
		<h1> - Gegevens wijzigen</h1>
	</div>

<?php
if(!empty($this->data['clientInfo'])){
	//Laat clienten zien
	foreach($this->data['clientInfo'] as $client){
			if($client['can_read'] == 1){
				$yesread = 'checked="checked"';
				$noread = '';
			}else{
				$noread = 'checked="checked"';
				$yesread = '';	
			}?>
			<form action="" method="post" id="settingsForm">
				<p class="edituserinfo">
					<label>Naam</label>
						<input type="text" class="editfield" name="name" value="<?php echo (!empty($_POST['name'])) ? $_POST['name'] : $client['name'] ?>">
				</p>
				<p class="edituserinfo">
					<label>Achternaam</label>
						<input type="text" class="editfield" name="surname" value="<?php echo (!empty($_POST['surname'])) ? $_POST['surname'] : $client['surname'] ?>">
				</p>
				<p class="edituserinfo">
					<label>Verjaardag</label>
					<select name="birthdateDay" class="birthdateDay">';
							<?php for($i = 1; $i < 32; $i++){
								$i = (strlen($i) == 2) ? $i : '0'.$i;
								$selected = (date('d', strtotime($client['birthdate'])) == $i) ? 'selected=selected' : '';
								echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
							}
							?>
						</select>
						<select name="birthdateMonth" class="birthdateMonth">
							<?php $maand = date('m', strtotime($client['birthdate']));?>
							<option value="01" <?php if($maand == '01'){ echo 'selected=selected'; } ?>>Januari</option>
							<option value="02" <?php if($maand == '02'){ echo 'selected=selected'; } ?>>Februari</option>
							<option value="03" <?php if($maand == '03'){ echo 'selected=selected'; } ?>>Maart</option>
							<option value="04" <?php if($maand == '04'){ echo 'selected=selected'; } ?>>April</option>
							<option value="05" <?php if($maand == '05'){ echo 'selected=selected'; } ?>>Mei</option>
							<option value="06" <?php if($maand == '06'){ echo 'selected=selected'; } ?>>Juni</option>
							<option value="07" <?php if($maand == '07'){ echo 'selected=selected'; } ?>>Juli</option>
							<option value="08" <?php if($maand == '08'){ echo 'selected=selected'; } ?>>Augustus</option>
							<option value="09" <?php if($maand == '09'){ echo 'selected=selected'; } ?>>September</option>
							<option value="10" <?php if($maand == '10'){ echo 'selected=selected'; } ?>>Oktober</option>
							<option value="11" <?php if($maand == '11'){ echo 'selected=selected'; } ?>>November</option>
							<option value="12" <?php if($maand == '12'){ echo 'selected=selected'; } ?>>December</option>
						</select>
						<select name="birthdateYear" class="birthdateYear">
							<?php
							for($i = date('Y')-20; $i <= date('Y'); $i++){
								$selected = (date('Y', strtotime($client['birthdate'])) == $i) ? 'selected=selected' : '';
								echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
							}
							echo ' 
						</select>
				</p>
				<p class="edituserinfo2">
					<label>Kleur</label>
						<input class="colourpicker" type="color" name="color" value="' . $client['color'] . '" data-hex="true" style="height:20px;">
				</p>
				<p class="edituserinfo2">
					<label>Kan lezen</label>
						<input type="radio" name="canread" ' . $yesread . ' value="1"><span>Ja</span>
						<input type="radio" name="canread" ' . $noread . ' value="0"><span>Nee</span>
				</p>';
				$letter = $client['character'];
				$img = (count(getimagesize(BASEURL.'/public/images/character/'.$letter . '.png')) > 0) ? '/public/images/character/'.$letter . '.png' : '/public/images/character/t.png';
				echo '
				<p class="edituserinfo2">
					<label>Karakter</label>
					<span id="editchar" style="float:left; margin-right:10px;"><img width="50" src="'.$img.'" alt="' . $letter . '"></span>
					<a href="#" id="editcharacterSettings" style="float:left; margin-top:10px;">Wijzig</a>
					<input type="hidden" value="' . $letter . '" name="character" id="characterInput">
				</p>
				<p>
					<label>&nbsp;</label>
					<a href="'.BASEURL.'settings" class="backButton">Terug</a>
					<input type="submit" src="/public/stylesheet/images/save_button.png" class="button blueSmall" value="Opslaan" name="clientEditSubmit">
				</p>
			</form>';
	}
}
?>



	</div>
</div>

<style>
	.pickChar{
		width:250px;
		height:400px;
		padding:15px;
		background:#FFF;
		border-radius:5px;
		border:1px solid #CCC;
		position:absolute;
		display:none;
		z-index:9;
	}
		.pickChar a{
			margin:2px;
		}
</style>
<div class="pickChar">

</div>