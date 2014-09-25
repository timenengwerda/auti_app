<?php
define("BASEURL", "http://dagplanner.envyum.nl/");
define("DBUSER", "dagplannah");
define("DBPASS", "hoepla");
define("DBNAME", "dagplanner_db");

setlocale(LC_ALL, 'nl_NL');
date_default_timezone_set('Europe/Amsterdam');

require_once('includes/mailer.php');
require_once('db/db.data.php');
require_once('db/db.model.php');
require_once('app/controllers/template.controller.php');


?>