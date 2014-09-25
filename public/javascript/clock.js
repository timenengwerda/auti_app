jQuery(document).ready(function() {

	updateClock ();
	setInterval('updateClock()', 1000 )
	
	getDay();
	
});

function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  document.getElementById("clock").firstChild.nodeValue = currentTimeString;
}

function getDay(){
	
	var d=new Date();
	var weekday=new Array(7);
	weekday[0]="Zondag";
	weekday[1]="Maandag";
	weekday[2]="Dinsdag";
	weekday[3]="Woensdag";
	weekday[4]="Donderdag";
	weekday[5]="Vrijdag";
	weekday[6]="Zaterdag";
	
	var day = weekday[d.getDay()];
	
	jQuery('#iphone .top_bar .date').html(day);
	
}