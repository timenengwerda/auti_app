<?php
session_start();

error_reporting(E_ALL);

define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");

require_once('app/controllers/login/login.controller.php');

$login  = new LoginController();

if(isset($_POST['forgot_password'])){ $login->forgotPassword();}
if(isset($_GET['action']) && $_GET['action'] == 'logout'){ $login->logout();}
?>
<html>
<head> 
<title>Dagplanner | Inloggen</title>
<link rel="stylesheet" type="text/css" media="all" href="/public/stylesheet/jquery-ui-1.8.19.custom.css" />
<link rel="stylesheet" type="text/css" media="all" href="/public/stylesheet/style.css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/javascript/functions.js"></script>

<style>
.email_small{width:30px!important;}
</style>
</head>

<body>
<div class="container">
	<div class="login_box">		
		
		
		<?php		
		if(!empty($login->error)){
			echo '<div class="error_container">';
			echo '<ul>';
			
			foreach($login->error as $error){
				echo '<br><li style="color:red;">' . $error . '</li>';
			}
			
			echo '</ul>';
			echo '</div>';
		}
		
		if(!empty($login->succes)){
			
			echo '<div class="succesBox_login">';

			foreach($login->succes as $succes){
				echo '' . $succes . '';
			}
			
			echo '</div>';
		}
		
		?>
		
		<div class="form_container">
			<h1>Inloggen - beheersysteem</h1>
			<div class="grey_line"></div>
			<form action="" id="login" method="post">
				<label for="email">Email</label>
					<input type="text" class="txt" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" name="email">
				<label for="password">Wachtwoord</label>
					<input type="password" class="txt" name="password">
				
				<label for="keep_login">&nbsp;</label>
					<input type="checkbox" value="1" name="keep_login"  class="keep_login"/> <label class="loginTxt">Ingelogd blijven</label>
				<a href="javascript:void(0);" class="button blueBig left" style="clear:both;" id="forgot_password">Wachtwoord vergeten</a>
				<input type="submit" class="submit button greenMedium" value="Inloggen" name="login">
				
	
				<div class="clear"></div>
			</form>
			
			<p>Wilt u zich <a href="<?php echo BASEURL ?>register">registeren</a> voor dit systeem?
			Dit kan op de <a href="<?php echo BASEURL ?>register">registratiepagina.</a>
			</p>
		</div>
		
		<div class="password_forget_box">
			<h1>Inloggen - wachtwoord vergeten</h1>
			<div class="grey_line"></div>
			
			<form action="" id="login" method="post">
				<label class="email_small"for="email">Email</label>
			<input type="text" class="txt" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" id="emailAdres" name="email">
			<input type="submit" class="button blueBig greenMedium" value="Aanvragen" name="forgot_password">

				<div class="clear"></div>
			</form>
				<a href="javascript:void(0);" class="forget_back backButton">Terug</a>	
		</div>
		
	</div>
	

</div>
</body>
</html>