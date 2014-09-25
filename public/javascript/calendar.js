function delActivity(id){
	if(confirm("Weet u zeker dat u deze activiteit wilt verwijderen? Alle herhaalde activiteiten worden ook verwijderd.")){
		jQuery.get("/ajax/activities.php?action=delete&id="+id, function(msg) {
			if(msg == 1){			
				//jQuery('#image_'+id).hide();
				window.location.reload()
			}else{
				alert('Het verwijderen is niet gelukt');
			}
		});
	}	
}	

jQuery(document).ready(function() {
	var calendar = jQuery('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		events : "/app/controllers/activities/json-events2.php",			
		editable: false,
		selectable: true,
		selectHelper: true,			
		dayClick: function(date, allDay, jsEvent, e) {
		
			var currentDate = new Date();
			currentDate.setMinutes(0);
			currentDate.setHours(0);
			currentDate.setSeconds(0);

			if(Math.round(date/1000) >= Math.round(currentDate/1000)){
				jQuery('.quickadd').replaceWith(+date+'<div style="text-align: left;" class="quickadd"><form method="post" action="/activities/add" id="quickAdd"><label for="what">Wat</label> <input class="what" type="text" name="what" placeholder="Welke taak?" /><input type="hidden" name="date" value="'+date+'" /><input type="submit" value="Nieuwe taak" /></form><a style="float: right;" class="close" href="javascript:void();"><img src="http://community.gotomanage.com/images/chrome/dialog_close_button.png?1221758752" alt="Venster sluiten" /></a></div>');
				jQuery('.quickadd').css("left", jsEvent.pageX+20);				
				jQuery('.quickadd').css("top", jsEvent.pageY-23);
				jQuery('.what').focus();			    
				jQuery('.close').click(function(){
					jQuery(this).parent('.quickadd').hide();							
				});
			}else{
				jQuery('.quickadd').hide();										
			}
			jQuery('.popover').hide();							
			var d = jQuery('#calendar').fullCalendar('getDate');
			var Datum = Math.round(date/1000);
		},
		timeFormat: 'H:mm{ - H:mm}\n', // uppercase H for 24-hour clock
		eventClick: function(calEvent, jsEvent, e) {
			var start = jQuery.fullCalendar.formatDate(calEvent.start, "dd-MM-yyyy HH:mm:ss");
			var end = jQuery.fullCalendar.formatDate(calEvent.end, "dd-MM-yyyy HH:mm:ss");
			jQuery('.quickadd').hide();		
			if(calEvent.how == ''){
				calEvent.how='Er is geen hoe opgegeven';
			}							
			jQuery('.popover').replaceWith('<div style="text-align: left;" class="popover"><img style="float:right; height: 75px; width: 75px margin: 10px;" src="'+calEvent.pictogram+'" alt="'+calEvent.title+'" /><h2>'+calEvent.title+'</h2><p>Met wie: '+calEvent.who+'<br/>Hoe: '+calEvent.how+'<br/>Locatie: '+calEvent.location+'<br/>Start tijd: '+start+'<br/>Eind tijd: '+end+'</p><a href="/activities/edit/'+calEvent.activityID+'"><img src="/public/stylesheet/images/icon-edit.png" alt="Activiteit bewerken" /></a> <a href="javascript:void(0);" onclick="delActivity('+calEvent.activityID+')"><img src="/public/stylesheet/images/icon-delete.png" alt="Activiteit verwijderen" /></a><a style="color:#fff;" href="/activities/add/'+calEvent.activityID+'">Kopieer</a><a style="float: right;" class="close" href="javascript:void();"><img src="http://community.gotomanage.com/images/chrome/dialog_close_button.png" alt="Venster sluiten" /></a></div>');
			jQuery('.popover').css("left", jsEvent.pageX+15);				
			jQuery('.popover').css("top", jsEvent.pageY-30);				    
	
			jQuery('.close').click(function(){
				jQuery(this).parent('.popover').hide();							
			});
			calendar.fullCalendar('unselect');
		},
    eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {	
      alert(
          event.title + " was moved " +
          dayDelta + " days and " +
          minuteDelta + " minutes."         
      );
    }
	});
});