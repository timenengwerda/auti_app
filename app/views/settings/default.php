<link href="/public/stylesheet/instellingen.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript" src="/public/javascript/settings.js"></script>
<div class="columnFull">
				<div class="title">
					<h1>Instellingen</h1>
					<h1> - Gebruikers beheren</h1>
					<!--<img src="/public/stylesheet/images/button_adduser.png" height="75%" class="buttons" alt="Voeg gebruiker toe"/>
					<img src="/public/stylesheet/images/button_addclient.png" height="75%" class="buttons" alt="Voeg gebruiker toe"/>-->
				</div>
<?php

if(!empty($this->data['userInfo'])){
	//Laat user zien
	echo '<div class="userData"><h3 class="titel">Eigen informatie</h3><div class="user">
			<table border="0">
			<tr class="data">';
				foreach($this->data['userInfo'] as $user){
						echo '
						<td width="150">
							Naam
						</td>
						<td>
							' . $user['name'] . ' ' . $user['surname'] . '
						</td>
					</tr>
					<tr class="data">
						<td>
							E-mailadres
						</td>
						<td>
							' . $user['email'] . '
						</td>
					</tr>
					<tr class="data">
						<td>
							Wachtwoord
						</td>
						<td>
							********
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<a href="/settings/edituser/' . $user['userID'] . '">Gegevens wijzigen</a>
						</td>';	
				}
	echo '</tr>
		</table></div><!-- end user -->';
}

if(!empty($this->data['clientInfo'])){
	//Laat clienten zien
	echo '<h3 class="titel">Informatie over mijn kind</h3>
	<div class="client">
		<table border="0">
			<tr class="data">
				';
				foreach($this->data['clientInfo'] as $client){
						$canRead = ($client['can_read'] == 1) ? "Ja" : "Nee";
						echo '
						<td width="150">
							Naam
						</td>
						<td>
							' . $client['name'] . ' ' . $client['surname'] . ' 
						</td>
					</tr>
					<tr class="data">
						<td>
							Verjaardag
						</td>
						<td>
							' . date('d-m-Y', strtotime($client['birthdate'])) . '
						</td>
					</tr>
					<tr class="data">
						<td>Kleur</td>
						<td id="editcolourblock">
							<div class="colourblock" style="background: ' . $client['color'] . ';">
						</td>
					</tr>
					<tr class="data">
						<td>Kan lezen</td>
						<td>' . $canRead . '</td>
					</tr>
					<tr class="data">
						<td>Karakter</td>';
						$letter = $client['character'];
						$img = (count(getimagesize(BASEURL.'/public/images/character/'.$letter . '.png')) > 0) ? '/public/images/character/'.$letter . '.png' : '/public/images/character/t.png';
						echo '<td><img width="50" src="'.$img.'" alt="' . $letter . '"></td>';
					echo '</tr>
					<tr class="data">
						<td>Authenticatie code</td>
						<td><strong>' . $client['apikey'] . '</strong></td>
					</tr>
					<tr class="data">
						<td colspan="2">
							<a href="/settings/editclient/' . $client['clientID'] . '">Gegevens wijzigen</a>
						</td>';	
				}
	echo '	</tr>
		</table></div><!-- end client--></div> <!-- end userData-->';
}
		$custom_pictograms = $this->data['custom_pictograms'];
		
		if(!empty($custom_pictograms)){
			echo '<h3 class="titel">Geuploade Pictogrammen</h3>';
			echo '<div class="pictogramContainer">';
			
			foreach($custom_pictograms as $custom_picto){
				
				echo '<a href="javascript:void(0);" onclick="delImage('.$custom_picto['pictogramID'].')">
				<span class="deleteCross"></span>
				<img id="image_'.$custom_picto['pictogramID'].'" class="custom_picto" src="/public/images/custom/' . $custom_picto['filename'] . '"/></a>';
			}
			echo '</div>';
		}

?>
		</div>	
	</div>
</div>	
