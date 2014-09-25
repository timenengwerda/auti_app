<link href="/public/stylesheet/instellingen.css" rel="stylesheet" type="text/css" media="screen" />


	<div id="content">
		<div class="columnFull">
				<div class="title">
					<h1>Instellingen</h1>
					<h1> - Gegevens wijzigen</h1>
				</div>
<?php
if(!empty($this->data['userInfo'])){
	//Laat clienten zien
	foreach($this->data['userInfo'] as $user){?>
	<form action="" method="post" id="settingsForm">
			<p class="edituserinfo">
				<label>Naam</label>
					<input type="text" class="editfield" name="name" value="<?php echo (!empty($_POST['name'])) ? $_POST['name'] : $user['name'] ?>">
			</p>
			<p class="edituserinfo">
				<label>Achternaam</label>
					<input type="text" class="editfield" name="surname" value="<?php echo (!empty($_POST['surname'])) ? $_POST['surname'] : $user['surname'] ?>">
			</p>
			<p class="edituserinfo">
				<label>E-mailadres</label>
					<input type="text" class="editfield" name="email" value="<?php echo (!empty($_POST['email'])) ? $_POST['email'] : $user['email'] ?>">
			</p>
			<p class="edituserinfo">
				<label>Wachtwoord</label>
					<input type="password" class="editfield" name="password">
			</p>
			<p class="edituserinfo">
				<label>Wachtwoord check</label>
					<input type="password" class="editfield" name="passwordcheck">
			</p>
			<p>
				<label id="test" >&nbsp;</label>
				<a href="<?php echo BASEURL; ?>settings" style="margin-left:11px;" class="backButton">Terug</a>
				<input type="submit" class="button blueSmall" src="/public/stylesheet/images/save_button.png"  value="Opslaan" name="userEditSubmit">
			</p>
		</form>
	<?php }
}
?>

	</div>
</div>