jQuery(document).ready(function() {

	// update clock live preview
	updateClock ();
	setInterval('updateClock()', 1000 )
	
	// haalt de dag op live preview
	getDay();

	// leegt het hoe veld
	jQuery("#whoFocus").focus(function(){
		if(jQuery(this).val() == "Alleen"){
			jQuery(this).val("");
		}
	});
	
	jQuery(".submitShout").click(function(){
		var data = jQuery("#shoutboxForm").serialize();
		var url = "/ajax/shoutbox.php?action=saveShout&reply_to=0&"+data;
		jQuery.get(url, function(msg) {
			//jQuery(".shoutboxLeft").prepend(msg).slideDown();
			jQuery(msg).hide().prependTo(".shoutboxLeft").slideDown();
			jQuery("#daShout").val("");
		});
		return false;
	});
});

function del_message(id){
	jQuery.get("/ajax/shoutbox.php?action=delete&id="+id, function(msg) {

		if(msg == 1){
			jQuery('#shout'+id).slideUp();
		}else{
			alert('Niet verwijderd.');
		}
	});
}
function get_replies(id){
	if(jQuery('#replyFrom'+id).css('display') == "none"){
		jQuery.get("/ajax/shoutbox.php?action=getReplies&id="+id, function(msg) {
			if(msg != ""){
				
				jQuery('#replyFrom'+id).css('display', 'block');
				jQuery('#replyFrom'+id).html("");
				jQuery(msg).hide().appendTo('#shout' + id + ' .shoutReplies').slideDown();
			}
		});	
	}else{
		
		jQuery('#replyFrom'+id).css('display', 'none');
	}
}

function addReply(id){
	var a = jQuery("#replyShoutForm-"+id).serialize();
	
	//alert("ajax/shoutbox.php?action=saveShout&reply_to="+id+"&shout="+encodeURIComponent(a));
	jQuery.get("ajax/shoutbox.php?action=saveShout&reply_to="+id+"&"+a, function(msg) {
		//alert(msg);
		if(msg != ""){
			//jQuery('.shoutReplies').html("");
			jQuery('#shout' + id + ' .newReply').prepend(msg);
			jQuery("#reply").val("");
		}
	});
	return false;
}


function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes;

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