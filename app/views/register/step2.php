<script type="text/javascript" src="/public/javascript/colourpicker.js" charset="UTF-8"></script>
<style>
.mColorPicker{
	width:85px !important;
	height:25px !important;
	margin-top:5px !important;
}
.mColorPickerTrigger{
	margin-top:9px;
}
</style>
	<script type="text/javascript">
		$(function () {
			$(window).load(function () {
				document.forms['second_step'].elements['name'].focus();
			});
		})

	</script>

<?php

if(!empty($_SESSION['userName']) && !empty($_SESSION['userSurname'])){?>
	<div class="setupBlock">
		<div class="top">
			<h1>Registreren</h1>
			<h2> - Cli&euml;ntgegevens</h2>
			<div class="progress">
				<img src="/public/stylesheet/images/setupProgress2.png" alt="stap 2">
			</div>
		</div>
		<div class="stepsMenu">
			<ul>
				<li>
						Stap 1<br>
						<strong>Gebruikersgegevens</strong>
				</li>
				<li class="active">
						Stap 2<br>
						<strong>Cli&euml;ntgegevens</strong>
				</li>
				<li>
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
			
			<form id="second_step"action="/register/step3/" method="post">
				<p>
					<strong>Bij deze stap van de registratie kunt u de gegevens van uw kind of cli&euml;nt invullen.</strong>
				</p>
				<p>
					<label>*Voornaam kind</label>
					<input type="text" class="textField" name="name">
				</p>
				<p>
					<label>*Achternaam kind</label>
					<input type="text" class="textField" name="surname">
				</p>
				<p>
					<label>*Kan uw kind lezen?</label>
						<input type="radio" name="canread" value="1" checked="checked"> Ja
						<input type="radio" name="canread" value="0"> Nee 
				</p>
				<p>
					<label>Geboortedatum kind</label>
						<select name="birthdateDay">
							<?php
							for($i = 1; $i < 32; $i++){
								echo '<option value="' . $i . '">' . $i . '</option>';
							}
							?>
						</select>
						<select name="birthdateMonth">
							<option value="1">Januari</option>
							<option value="2">Februari</option>
							<option value="3">Maart</option>
							<option value="4">April</option>
							<option value="5">Mei</option>
							<option value="6">Juni</option>
							<option value="7">Juli</option>
							<option value="8">Augustus</option>
							<option value="9">September</option>
							<option value="10">Oktober</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>
						<select name="birthdateYear">
							<?php
							for($i = date('Y')-20; $i <= date('Y'); $i++){
								echo '<option value="' . $i . '">' . $i . '</option>';
							}
							?>
						</select>
				</p>
				<p>
						<label>Favoriete kleur</label>
						<input class="textField" type="color" name="color" value="#ff0667" data-hex="true" style="height:25px !important; margin-top:10px;" >
				</p>
				<p>
					<input type="submit" name="submitClient" class="button blueMedium stepButton" value="Volgende stap">
				</p>
			</form>
		</div>
<?php }else{
	echo 'Niet alle voorgaande gegevens zijn ingevuld.';
}
?>
