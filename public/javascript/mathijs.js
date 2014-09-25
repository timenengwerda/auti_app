jQuery(document).ready(function() {
	jQuery('.infoPopup').click(function(){
		jQuery(this).next().next(".popup").css("display","block");
		return false;
	});
	
	function getActivities() {
	  var url = "activities.contrfoller.php";
	  jQuery(".hok").load(url);
	}
	// Roept de functie getActivities elke 10 seconden opnieuw op
	//setInterval(getActivities, 2000);
});