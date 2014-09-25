<script type="text/javascript" src="/public/javascript/registration.js"></script>
<?php
$user = $this->data['user'];
//Kijk of de user gevuld is. Zo ja, dan mag de registratie verder gaan.
if(!empty($user)){
?>
	<script type="text/javascript">
		$(function () {
			$(window).load(function () {
				document.forms['first_setup'].elements['name'].focus();
			});
		})

	</script>
	<div class="setupBlock">
		<div class="top">
			<h1>Registreren</h1>
			<h2> - Gebruikersgegevens</h2>
			<div class="progress">
				<img src="/public/stylesheet/images/setupProgress1.png" alt="stap 1">
			</div>
		</div>
		<div class="stepsMenu">
			<ul>
				<li class="active">
						Stap 1<br>
						<strong>Gebruikersgegevens</strong>
				</li>
				<li>
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
		<p>De volgende gegevens zijn nodig voor het registeren van uw account, 
		met dit wachtwoord in combinatie met het ingevulde e-mailadres kunt u, na het voltooien van de 4 stappen, 
		inloggen op het beheersysteem.
		
		</p>
		
			<form id="first_setup" action="/register/step2/<?php echo $user[0]['userID']; ?>" method="post">
				<p>
					<label>Naam*</label>
					<input type="text" class="textField" name="name">
				</p>
				<p>
					<label>Achternaam*</label>
					<input type="text" class="textField" name="surname">
				</p>

				<p>
					<label>Wachtwoord*</label>
					<input id="first_password" class="textField" type="password" name="password">
					<span class="password_error">Het wachtwoord moet minstens 8 tekens lang zijn</span>
				</p>
				<p>
					<label>Wachtwoord verificatie*</label>
					<input id="second_password" class="textField" type="password" name="passwordcheck">
					<span class="password_error_same">Wachtwoorden komen niet overeen</span>
				</p>
				<p>
					<input type="submit" id="submitUser" name="submitUser" class="button blueMedium stepButton" value="Volgende stap">
				</p>
			</form>
		</div>
<?php
}
?>
