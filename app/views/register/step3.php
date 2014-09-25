<script type="text/javascript" src="/public/javascript/colourpicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/public/javascript/registration.js"></script>
<script>
$(document).ready(function () {
	jQuery('.colourpicker').bind('colorpicked', function () {
	  saveColour(jQuery(this).val());
	});
  });
</script>
<style>
	table a{
		color:#08c;
		text-decoration:none;
	}
</style>
<?php

if(!empty($this->data['userSave'])){ $user = $this->data['userSave']; }
if(!empty($this->data['clientSave'])){ $client = $this->data['clientSave']; }

if(!empty($user) && !empty($client)){ ?>
	<div class="setupBlock">
		<div class="top">
			<h1>Registreren</h1>
			<h2> - Controle</h2>
			<div class="progress">
				<img src="/public/stylesheet/images/setupProgress3.png" alt="stap 3">
			</div>
		</div>
		<div class="stepsMenu">
			<ul>
				<li>
						Stap 1<br>
						<strong>Gebruikersgegevens</strong>
				</li>
				<li>
						Stap 2<br>
						<strong>Cli&euml;ntgegevens</strong>
				</li>
				<li class="active">
						Stap 3<br>
						<strong>Gegevens check</strong>
				</li>
				<li>
						Stap 4<br>
						<strong>Afgerond</strong>
				</li>
			</ul>
		</div><!--Einde menu-->
		<div class="content">
			<?php echo '
				<p>Alles compleet? Lees alles nog even rustig door. Geen zorgen; u kunt deze gegevens later alsnog wijzigen.</p>
				<h3>Gebruikersgegevens</h3>';
			echo '<table border="0">
					<tr>
						<td><strong>Naam</strong></td>
						<td id="editusernameblock">' . $user['userName'] . '</td>
						<td><a href="#" id="editusername">Wijzig</a></td>
					</tr>
					<tr>
						<td><strong>Achternaam</strong></td>
						<td id="editusersurnameblock">' . $user['userSurname'] . '</td>
						<td><a href="#" id="editusersurname">Wijzig</a></td>
					</tr>
				</table>';

			$canRead = ($client['clientRead'] == 1) ? "Ja" : "Nee";
			echo '<h3>Cli&euml;ntgegevens</h3>';
			echo '<table border="0">
					<tr>
						<td><strong>Naam</strong></td>
						<td id="editclientnameblock">' . $client['clientName'] . '</td>
						<td><a href="#" id="editclientname">Wijzig</a></td>
					</tr>
					<tr>
						<td><strong>Achternaam</strong></td>
						<td id="editclientsurnameblock">' . $client['clientSurname'] . '</td>
						<td><a href="#" id="editclientsurname">Wijzig</a></td>
					</tr>
					<tr>
						<td><strong>Verjaardag</strong></td>
						<td>
							<span id="currentBirthday">' . date('d-m-Y', strtotime($client['clientBirthday'])) . '</span>
							<div id="birthdayedit" style="display:none;">
								<select name="birthdateDay" class="birthdateDay">';
									
									for($i = 1; $i < 32; $i++){
										$i = (strlen($i) == 2) ? $i : '0'.$i;
										$selected = (date('d', strtotime($client['clientBirthday'])) == $i) ? 'selected=selected' : '';
										echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
									}
									?>
								</select>
								<select name="birthdateMonth" class="birthdateMonth">
									<?php $maand = date('m', strtotime($client['clientBirthday']));?>
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
										$selected = (date('Y', strtotime($client['clientBirthday'])) == $i) ? 'selected=selected' : '';
										echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
									}
									echo ' 
								</select>
								
							</div>
						</td>
						<td>
							<a href="#" id="editbirthday">Wijzig</a>
							<a href="#" id="savebirthday" style="display:none;">Opslaan</a>
						</td>
					</tr>
					<tr>
						<td><strong>Kleur</strong></td>
						<td id="editcolourblock">
							<input class="colourpicker" type="color" name="color" value="' . $client['clientColor'] . '" data-hex="true" style="height:20px;">
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td><strong>Kan lezen</strong></td>
						<td id="editcanread">' . $canRead . '</td>
						<td>
							<a href="#" id="editread">Wijzig</a>
						</td>
					</tr>
					<tr>
						<td><strong>Karakter</strong></td>
						<style>
							#editchar img{
								width:50px;
							}
						</style>
						<td id="editchar">' . $client['clientCharacter'] . '</td>
						<td>
							<a href="#" id="editcharacter">Wijzig</a>
						</td>
					</tr>
				</table>
				
				';?>				
				<form action="/register/finish" method="post">
					<p>
						<input type="submit" name="finishRegistration" class="button blueMedium stepButton" value="Afronden">
					</p>
				</form>
		</div>
<?php
}else{
	echo 'Niet alle voorgaande gegevens zijn ingevuld.';
}
?>
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
	}
		.pickChar a{
			margin:2px;
		}
</style>
<div class="pickChar">

</div>
