jQuery(document).ready(function() {
	jQuery( "#date1, #date2" ).datepicker( {minDate: -0, altField: "#date2", dateFormat: "dd-mm-yy"} );
	jQuery(".timeInput").focus(function(){
		jQuery(this).val("");
	});
	
	jQuery('.close_upload').click(function(){
		jQuery(".customPicto_upload").hide();
		jQuery('.uploadCustomButton').show();
		jQuery("#normalPictogramContainer").show();
		jQuery(".ownPicto").show();
	});
	
	jQuery(".defaultPictogram").click(function(){
		//Reset eerder gezette radio buttons
		jQuery(".defaultPictogram").css('border', '0px');
		jQuery(".defaultPictogram").css('opacity', '0.7');
		jQuery("input:radio").removeAttr("checked");
		

		//Strip ID van image af
		var strippedID = jQuery(this).attr('id').substr(14, 100);
		
		//Gebruik gestripte ID om radio button te checken en image omlijning te gevens
		jQuery("#default_"+strippedID).attr('checked', true);
		jQuery(this).css('border', '2px solid #08C')
		jQuery(this).css('opacity', '1');
	});
	
	jQuery(".customPictogram").click(function(){
		//Reset eerder gezette radio buttons
		jQuery(".customPictogram").css('border', '0px');
		jQuery(".defaultPictogram").css('opacity', '0.7');
		jQuery("input:radio").removeAttr("checked");
		
		//Strip ID van image af
		var strippedID = jQuery(this).attr('id').substr(14, 100);
		
		//Gebruik gestripte ID om radio button te checken en image omlijning te gevens
		jQuery("#custom_"+strippedID).attr('checked', true);
		jQuery(this).css('border', '2px solid #08C');
		jQuery(this).css('opacity', '1');
	});
	
	jQuery(".ownPicto").click(function(){
			jQuery('#normalPictogramContainer').toggle();
			jQuery('#customPictogramContainer').toggle();
			
			jQuery(".defaultPictogram").css('border', '0px');
			jQuery(".defaultPictogram").css('opacity', '1');
			jQuery("input:radio").removeAttr("checked");
			
			jQuery(".customPictogram").css('border', '0px');
			jQuery(".customPictogram").css('opacity', '1');
			jQuery("input:radio").removeAttr("checked");
			
			if ( jQuery('#customPictogramContainer').is(':visible')){
				 jQuery(this).text('Standaard Pictogram');
			}
			if ( jQuery('#normalPictogramContainer').is(':visible')){
				 jQuery(this).text('Eigen Pictogram');
			}		
	});
	
	jQuery(".submitActivityAndAgain").click(function(){
			jQuery('#another_activity').attr('value','true');
			
	});
	
	jQuery(".uploadCustomButton").click(function(){
		jQuery(".customPicto_upload").show();
		jQuery(".ownPicto").hide();
		
		
		if ( jQuery('#customPictogramContainer').is(':visible')){
				jQuery("#customPictogramContainer").hide();
		}
		if ( jQuery('#normalPictogramContainer').is(':visible')){
				jQuery("#normalPictogramContainer").hide();
		}
		
		jQuery(".defaultPictogram").css('border', '0px');
		jQuery(".defaultPictogram").css('opacity', '1');
		jQuery("input:radio").removeAttr("checked");
		
		jQuery(".customPictogram").css('border', '0px');
		jQuery(".customPictogram").css('opacity', '1');
		jQuery("input:radio").removeAttr("checked");

		
		jQuery(this).hide();
	});
	
	
	jQuery("#repeatMode").click(function(){
		jQuery("#repeatBlock").toggle();
		var currentValue = jQuery("#repeatBox").val();
		if(currentValue == 0){
			jQuery("#repeatBox").val('1');
		}else{
			jQuery("#repeatBox").val('0');
		}
		return false;
	});
	
	jQuery('.whatPicto').click(function(){
		jQuery('#defaultPicto').toggle();
		jQuery('#ownPicto').toggle();
		jQuery('.defaultPictoRadio').prop('checked', false);
		jQuery('.customWhat').val('');
		return false;
	});
	
	jQuery('.webcamPhoto').click(function(){
		var url = "/public/webcam/cam.html";
		jQuery.get(url, function(msg) {
			popPopup(msg, 500, 400);
		});
		return false;
	});	
	
	 // kijkt of er al velden zijn ingevuld
	   checkProgress();
	   
	   // wanneer een veld active is voer de check uit
	   jQuery('#addActivity :input, #addActivity .defaultPictoRadio').focus(function() {
			checkProgress();
		});
		
		// kijkt bij het selecteren van de select nog een keer
		jQuery('select#repeatMode').change(function(){
			checkProgress();
		});
  
	  // check het totaal aantal ingevulde velden en geef percentage terug
	  function checkProgress(){
	  
			//haalt alle inputs en zet ze in een array
			var jQueryinputs = jQuery('#addActivity :input:not(input[type=submit], input[type=hidden], input[type=radio], input[name=custom_what], input[name=custompicto], input[type=file], input[name=startdate])');
		
			
			// zet count en complete op 0
			var count   = 0;
			var completed = 0;
			
			// zet alle values in een array
			var values = {};
		
			// kijkt in alle velden welke niet leeg zijn.
			jQueryinputs.each(function() {
				
				//totaal ingevuld
				if(jQuery(this).val()){
				
					if(jQuery(this).attr('name') != undefined){
						completed ++;
					}
				}

				// telt het totaal aantal velden
				count++;        	
			});
			
			if (jQuery(".defaultPictoRadio").is(':checked')){
				completed++;
			}
			
			// berekent het percentage ingevuld / totaal keer 100
			var percent = Math.floor(completed / count * 100);
			
			// zet het percentage in een class
			jQuery('.percentage').html(percent +'%');
			
			// genereert de progressbar
			jQuery("#progressbar" ).progressbar({
				value: percent
			});
		}
	
});