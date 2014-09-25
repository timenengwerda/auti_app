<?php
if($this->data['finished']){ ?>
	<div class="setupBlock">
		<div class="top">
			<h1>Registreren</h1>
			<h2> - Afgerond</h2>
			<div class="progress">
				<img src="/public/stylesheet/images/setupProgressdone.png" alt="Afgerond">
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
				<li>
						Stap 3<br>
						<strong>Gegevens check</strong>
				</li>
				<li class="active">
						Stap 4<br>
						<strong>Afgerond</strong>
				</li>
			</ul>
		</div><!--Einde menu-->
		<div class="content">
			<p class="activationComplete">
				De activatie en registratie is geslaagd. U kunt nu de mobiele applicatie activeren met de onderstaande sleutel.<br>
				Vervolgens kunt u doorgaan naar het <a href="/login.php">inloggen in het beheersysteem</a>.
			</p>
			
			<h1 class="apiKey"><?php echo $this->data['finished']; ?></h1>
			<img src="<?php echo BASEURL; ?>public/stylesheet/images/uitleg_code_iphone.png" class="iphone_code_image">
			<p>
				Bovenstaande code is bedoel om in te loggen op de applicatie voor uw kind. Bewaar deze code dus goed!<br>
				Door de bovenstaande code en uw wachtwoord in te vullen in de iPhone applicatie zal uw kind toegang krijgen tot zijn dagplanning die u in dit systeem vullen kan.<br>

				Voor meer informatie lees de <a href="#">handleiding</a>
			</p>
		</div>
<?php }

?>