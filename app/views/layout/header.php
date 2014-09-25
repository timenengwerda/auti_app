
<?php

$pages = (!empty($_GET['page'])) ? $_GET['page'] : 'dashboard/';

//Check laatste character. Als dit / is moet deze verwijderd worden.
$lastChar = substr($pages, -1);
if($lastChar == '/' || $lastChar == "\\"){
	$pages = substr($pages, 0, -1);
}

//Paginas uit elkaar halen
$explodedPages = explode('/', $pages);

//Return laatste arrayRecord
$lastArray = count($explodedPages)-1;
$title = $explodedPages[0];
$currentpage = (count($explodedPages) > 1) ? ' | ' . ucfirst($explodedPages[1]) : '';

?>
<html>
<head> 
<title>Dagplanner | <?php echo ucfirst($title) . $currentpage; ?></title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
<link rel="stylesheet" type="text/css" media="all" href="/public/stylesheet/jquery-ui-1.8.19.custom.css" />
<link rel="stylesheet" type="text/css" media="all" href="/public/stylesheet/style.css" />
<link rel="stylesheet" type="text/css" media="all" href="/public/stylesheet/<?php echo $title; ?>.css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/javascript/functions.js"></script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
	<div id="header">
		<div id="tagline">
			<a href="<?php echo BASEURL; ?>dashboard">Dagplanner</a>
		</div>
		<ul id="menu">
			<li><a href="<?php echo BASEURL; ?>dashboard">Dashboard</a></li>
			<li><a href="<?php echo BASEURL; ?>activities">Activiteiten</a></li>
			<!--<li><a href="<?php echo BASEURL; ?>media">Media</a></li>!-->
			<li><a href="<?php echo BASEURL; ?>settings">Mijn Gegevens</a></li>
		</ul>
		<?php if(isset($_SESSION['userID'])){ ?>
			<div class="logout"><a href="/login.php?action=logout">Uitloggen > </a></div>
		<?php } ?>
	</div>
	<div class="letters">
		<ul>
			<li>
				<a href="javascript:void(0);" onclick="toggleSize(12);">a</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="toggleSize(14);">a</a>
			</li>
			<li>
				<a href="javascript:void(0);" onclick="toggleSize(16);">a</a>
			</li>
		</ul>
	</div>
	<div class="content">