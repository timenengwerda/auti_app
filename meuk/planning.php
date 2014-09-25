<?php

$dbhost = 'localhost';
$dbuser = 'dagplannah';
$dbpass = 'hoepla';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die                      ('Error connecting to mysql');

$dbname = 'dagplanner_db';
mysql_select_db($dbname);

// Algemene instellingen
$date = time(); 
$day = date('d', $date); 
$month = date('m', $date);
$year = date('Y', $date);

// Eerste dag vd week
$first_day = mktime(0,0,0,$month, 1, $year);

// Huidige maand
$title = date('F', $first_day);

// Wat is de eerste dag van de maand
$day_of_week = date('D', $first_day) ; 

// De lege vakken berekenen
switch($day_of_week)
{ 
	case "Sun": $blank = 0; break; 
	case "Mon": $blank = 1; break; 
	case "Tue": $blank = 2; break; 
	case "Wed": $blank = 3; break; 
	case "Thu": $blank = 4; break; 
	case "Fri": $blank = 5; break; 
	case "Sat": $blank = 6; break; 
}

// deze telt van 0 naar 31 of 30

// Kijken hoeveel dagen er in de huidige maand zitten
$days_in_month = cal_days_in_month(0, $month, $year) ; 
 
echo "<table border=1 width=800>";
echo "<tr><th colspan=7> $title $year </th></tr>";
echo "<tr><td width=42>Zo</td><td width=42>Ma</td><td 
width=42>Di</td><td width=42>Wo</td><td width=42>Do</td><td 
width=42>Vr</td><td width=42>Za</td></tr>";

// dagen in de week 
$day_count = 1;
echo "<tr>";

//first we take care of those blank days
while ( $blank > 0 ) 
{ 
	echo "<td></td>"; 
	$blank = $blank-1; 
	$day_count++;
} 
//sets the first day of the month to 1 
$day_num = 1;

$query = "SELECT * FROM activities WHERE userID = 1";
$result = mysql_query($query);
$num   = mysql_num_rows($result);


//count up the days, untill we've done all of them in the month
while ( $day_num <= $days_in_month ) 
{ 
	echo "<td valign='top' class='hok'> ".$day_num;
	
	// hier staan alle data in van DB
  if($num > 0){
	//	$row = mysql_fetch_array($result);
		
		while($row = mysql_fetch_array($result)){
			//echo $row['what'];
			
				$start_date = date('j',strtotime($row['start_time']));

				echo $start_date;
				
				echo $day_num;
				
				if($start_date == $day_num){
					echo 'komt in voor';
				}
		}
	}

	// kijk naar welke data overeenkomen


	// komt hij overeen, dan vullen


	// komt hij niet overeen, dan leeg
	
	
	echo "</td>"; 
	$day_num++; 
	$day_count++;
	
	//Make sure we start a new row every week	
	if ($day_count > 7)
	{
		echo "</tr><tr>";
		$day_count = 1;
	}
} 


?>