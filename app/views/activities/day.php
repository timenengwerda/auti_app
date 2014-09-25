<link rel='stylesheet' type='text/css' href='http://dagplanner.envyum.nl/public/stylesheet/fullcalendar.css' />
<script type='text/javascript' src='http://dagplanner.envyum.nl/public/javascript/fullcalendar.js'></script>

<script type='text/javascript'>
	jQuery(document).ready(function() {		
		var calendar = jQuery('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			events : "/app/controllers/activities/json-events2.php",			
			editable: true,
			selectable: true,
			selectHelper: true,			
			dayClick: function(date, allDay, jsEvent, e) {
					jQuery('.popover').hide();							
					
			    //var relativeX = e.pageX - this.offsetLeft;
			    //var relativeY = e.pageY - this.offsetTop;
					jQuery('.quickadd').replaceWith('<div style="text-align: left;" class="quickadd"><form action="/activities/add"><label for="what">Wat</label><input type="text" name="what" placeholder="Welke taak?" /><input type="hidden" name="date" value="'+date+'" /><input type="submit" value="Nieuwe taak" /></form><a class="close" href="javascript:void();">Sluiten</a></div>');
					jQuery('.quickadd').css("left", jsEvent.pageX+20);				
					jQuery('.quickadd').css("top", jsEvent.pageY-23);				    
			
					jQuery('.close').click(function(){
						jQuery(this).parent('.quickadd').hide();							
					});
			},
			timeFormat: 'H:mm{ - H:mm}\n', // uppercase H for 24-hour clock
			eventClick: function(calEvent, jsEvent, e) {
					jQuery('.quickadd').hide();											
					jQuery('.popover').replaceWith('<div style="text-align: left;" class="popover"><img style="float:right; height: 100px; width: 100px margin: 10px;" src="'+calEvent.pictogram+'" alt="'+calEvent.title+'" /><h3>'+calEvent.title+'</h3><p>Met wie: '+calEvent.who+'<br/>Hoe: '+calEvent.how+'<br/>Locatie: '+calEvent.location+'<br/>Start tijd: '+calEvent.start+'<br/>Eind tijd: '+calEvent.end+'</p><a class="close" href="javascript:void();">Sluiten</a></div>');
					jQuery('.popover').css("left", jsEvent.pageX+15);				
					jQuery('.popover').css("top", jsEvent.pageY-30);				    
			
					jQuery('.close').click(function(){
						jQuery(this).parent('.popover').hide();							
					});
					calendar.fullCalendar('unselect');
			},

	    eventDrop: function(event,dayDelta,minuteDelta,revertFunc) {
	        if (!confirm("is this okay?")) {
	            revertFunc();
	        }
		    }		
		});
	});

</script>

<style type='text/css'>
body {
	text-align: center;
	font-size: 14px;
}

#calendar {
	float: right;
	width: 960px;
	margin-bottom: 20px;
}
.add {
	text-decoration:none;
	float: right;
  display: inline-block;
  *display: inline;
  padding: 4px 10px 4px;
  margin-bottom: 10px;
  *margin-left: .3em;
  font-size: 13px;
  line-height: 18px;
  *line-height: 20px;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  border: 1px solid #cccccc;
  *border: 0;
  border-bottom-color: #b3b3b3;
  -webkit-border-radius: 5px;
     -moz-border-radius: 5px;
          border-radius: 5px;
  background-color: #5bb75b;
  *background-color: #51a351;
  background-image: -ms-linear-gradient(top, #62c462, #51a351);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351));
  background-image: -webkit-linear-gradient(top, #62c462, #51a351);
  background-image: -o-linear-gradient(top, #62c462, #51a351);
  background-image: -moz-linear-gradient(top, #62c462, #51a351);
  background-image: linear-gradient(top, #62c462, #51a351);
  background-repeat: repeat-x;
  border-color: #51a351 #51a351 #387038;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  filter: progid:dximagetransform.microsoft.gradient(startColorstr='#62c462', endColorstr='#51a351', GradientType=0);
  filter: progid:dximagetransform.microsoft.gradient(enabled=false);
  *zoom: 1;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
     -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
          box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
          
}
.popover {
	position: absolute;
	width: 250px;
	top: -15px;
	left: 142px;
	background: #08c;
	border-radius: 10px;
	padding: 20px;
	font: 16px/20px Arial;
	color: #fff;
	z-index: 10;
	box-shadow: 0px 5px 20px rgba(0,0,0,.5);
	margin-bottom: 100px;
	
}
.popover p {
	color: #fff;
	line-height: 18px;
}
.popover:before {
	content: "";
	z-index: -1;
	width: 16px;
	height: 16px;
	background: #08c;
	margin-left: -10px;
	position: absolute;
	left: 2px;
	-webkit-transform: rotate(45deg);
	-moz-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	transform: rotate(45deg);
}
.quickadd {
	position: absolute;
	width: 250px;
	top: -15px;
	left: 142px;
	background: #75ff70;
	border-radius: 10px;
	padding: 20px;
	font: 16px/20px Arial;
	color: #fff;
	z-index: 10;
	box-shadow: 0px 5px 20px rgba(0,0,0,.5);
	margin-bottom: 100px;
	
}
.quickadd p {
	color: #fff;
	line-height: 18px;
}
.quickadd:before {
	content: "";
	z-index: -1;
	width: 16px;
	height: 16px;
	background: #75ff70;
	margin-left: -10px;
	position: absolute;
	left: 2px;
	-webkit-transform: rotate(45deg);
	-moz-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	transform: rotate(45deg);
}

</style>
<a class="add" href="/activities/add">Activiteit toevoegen</a>

<div style="display: none;" class="popover"></div>
<div style="display: none;" class="quickadd"></div>

<div id='calendar'></div>