jQuery(document).ready(function() {

  jQuery('#emailAdres').bind('click keyup change', function() {  
	checkEmail();
  });

  		
	// live password check
	jQuery('#first_password, #second_password').bind('keyup', function() {
	  		
	  		var val = jQuery('#first_password').val();
	  		var second_val = jQuery('#second_password').val();
	  		var count = val.length;
	  		var error_count = 2;
	  		
	  		if(count < 8){
	  			 jQuery(this).addClass('input_error');
	  			 jQuery('.password_error').show();
	  		}
	  		
	  		if(count >= 8){
	  			jQuery(this).removeClass('input_error');
	  			jQuery('.password_error').hide();
	  			error_count --;
	  		}
	  		
	  		if(val != second_val){
		  		 jQuery(this).addClass('input_error');
	  			 jQuery('.password_error_same').show();
	  		}
	  		
	  		if(val == second_val){
		  		jQuery('.password_error_same').hide();
		  		jQuery(this).removeClass('input_error');
		  		jQuery('#first_password').removeClass('input_error');
		  		error_count --;
	  		}
	  		
	  		if(error_count == 0){
		  		$('#submitUser').attr('disabled', false);
		  		
		  		 jQuery('#first_password').addClass('input_succes');
		  		 jQuery("#second_password").addClass('input_succes');
	  		}
	  		else{
	  			 jQuery('#first_password').removeClass('input_succes');
		  		 jQuery("#second_password").removeClass('input_succes');
		  		 
		  		$('#submitUser').attr('disabled', true);
	  		}
	  		
		});


	jQuery("#editusername, #editusersurname, #editclientsurname, #editclientname").click(function(){
		//Haal de ID van de clickobject op
		var id = jQuery(this).attr('id');
		
		//Append het woord block er aan voor later gebruik
		var blockname = id + 'block';
		
		//Haal de huidige inhoud van de TD op om deze value in de te maken input te zetten.
		var currentContent = jQuery('#' + blockname).html();
		
		var toAppend = '<input type="text" id="'+ id +'edit" value="' + currentContent + '" onKeydown="javascript:fireKeyboard(\''+id+'\');"><a href="#" onClick="javascript:saveValue(\''+id+'\'); return false;"><img src="/public/stylesheet/images/vinkje.png" alt="Wijzig" /></a>';
		
		
		jQuery(this).css('display', 'none');
		jQuery('#' + blockname).html(toAppend);

		return false;
	});
	
	jQuery("#editbirthday").click(function(){
		jQuery('#currentBirthday').toggle();
		jQuery('#birthdayedit').toggle();
		jQuery('#editbirthday').toggle();
		jQuery('#savebirthday').toggle();
		return false;
	});
	
	jQuery("#editcharacter").click(function(){
		//var bl = jQuery('#editchar');
		var alphabet = new Array();
		alphabet[0] = 'a';
		alphabet[1] = 'b';
		alphabet[2] = 'c';
		alphabet[3] = 'd';
		alphabet[4] = 'e';
		alphabet[5] = 'f';
		alphabet[6] = 'g';
		alphabet[7] = 'h';
		alphabet[8] = 'i';
		alphabet[9] = 'j';
		alphabet[10] = 'k';
		alphabet[11] = 'l';
		alphabet[12] = 'm';
		alphabet[13] = 'n';
		alphabet[14] = 'o';
		alphabet[15] = 'p';
		alphabet[16] = 'q';
		alphabet[17] = 'r';
		alphabet[18] = 's';
		alphabet[19] = 't';
		alphabet[20] = 'u';
		alphabet[21] = 'v';
		alphabet[22] = 'w';
		alphabet[23] = 'x';
		alphabet[24] = 'y';
		alphabet[25] = 'z';
		
		
		
		var html = '';
		for(var i = 0; i < alphabet.length; i++){
			html = html + '<a href="javascript:void(0);" onclick="javascript: imageSelected(\'' + alphabet[i] + '\'); return false;" class="imgselect"><img src="/public/images/character/' + alphabet[i] + '.png" alt="' + alphabet[i] + '" width="50"></a>';
		}
		
		jQuery('.pickChar').html(html);
		jQuery('.pickChar').css('display', 'block');
		jQuery('.pickChar').css('left', (jQuery(window).width()/2) - 200/2);
		jQuery('.pickChar').css('top', (jQuery(window).height()/2) - 500/2);
		
		return false;
		
	});
		jQuery("#editcharacterSettings").click(function(){
		//var bl = jQuery('#editchar');
		var alphabet = new Array();
		alphabet[0] = 'a';
		alphabet[1] = 'b';
		alphabet[2] = 'c';
		alphabet[3] = 'd';
		alphabet[4] = 'e';
		alphabet[5] = 'f';
		alphabet[6] = 'g';
		alphabet[7] = 'h';
		alphabet[8] = 'i';
		alphabet[9] = 'j';
		alphabet[10] = 'k';
		alphabet[11] = 'l';
		alphabet[12] = 'm';
		alphabet[13] = 'n';
		alphabet[14] = 'o';
		alphabet[15] = 'p';
		alphabet[16] = 'q';
		alphabet[17] = 'r';
		alphabet[18] = 's';
		alphabet[19] = 't';
		alphabet[20] = 'u';
		alphabet[21] = 'v';
		alphabet[22] = 'w';
		alphabet[23] = 'x';
		alphabet[24] = 'y';
		alphabet[25] = 'z';
		
		
		
		var html = '';
		for(var i = 0; i < alphabet.length; i++){
			html = html + '<a href="javascript:void(0);" onclick="javascript: imageSelectedSettings(\'' + alphabet[i] + '\'); return false;" class="imgselect"><img src="/public/images/character/' + alphabet[i] + '.png" alt="' + alphabet[i] + '" width="50"></a>';
		}
		
		jQuery('.pickChar').html(html);
		jQuery('.pickChar').css('display', 'block');
		jQuery('.pickChar').css('left', (jQuery(window).width()/2) - 200/2);
		jQuery('.pickChar').css('top', (jQuery(window).height()/2) - 500/2);
		
		return false;
		
	});
	
	jQuery("#editread").click(function(){
		var ja = '';
		var nee = '';
		if(jQuery("#editcanread").html() == "Ja"){
			ja = 'checked="checked"';
		}else{
			nee = 'checked="checked"';
		}
		
		var toAppend = '<form id="read" style="width:auto; float:left;" action="#" method="post"><input type="radio" id="editcanreadedit" name="canread" ' + ja + ' value="1"> Ja <input type="radio" id="editcanreadedit" ' + nee + ' value="0" name="canread"> Nee</form> <a href="#" style="float:left;" onClick="javascript:saveRead(); return false;"><img src="/public/stylesheet/images/vinkje.png" alt="Wijzig" /></a>';
		
		
		jQuery(this).css('display', 'none');
		jQuery('#editcanread').html(toAppend);
		return false;
	});
	
	jQuery("#savebirthday").click(function(){
		var day = jQuery('.birthdateDay').val();
		var month = jQuery('.birthdateMonth').val();
		var year = jQuery('.birthdateYear').val();
		var newBirthday = year + '-' + month + '-' + day;
		saveBirthday(newBirthday);
		
		return false;
	});

});




function imageSelected(letter){

	var url = "/ajax/registration.php?action=editCharacter&name=clientLetter&value=" + letter + "";
	jQuery.get(url, function(msg) {
		
		jQuery('#editchar').html('<img src="/public/images/character/' + letter + '.png" alt="' + letter + '">');
		jQuery('.pickChar').css('display', 'none');
		jQuery('.pickChar').html('');
	});
	
	
}
function imageSelectedSettings(letter){
	jQuery('#editchar').html('<img width="50" src="/public/images/character/' + letter + '.png" alt="' + letter + '">');
	jQuery('.pickChar').css('display', 'none');
	jQuery('.pickChar').html('');
	jQuery('#characterInput').val(letter);
}

function saveRead(){
	
	var url = "/ajax/registration.php?action=edit&name=clientRead&value=" + jQuery('input:radio[name=canread]:checked').val() + "";
	jQuery.get(url, function(msg) {
		if(msg == 1){ var b = 'Ja'; }else{ var b = 'Nee'; }
		jQuery("#editcanread").html(b);
		jQuery("#editread").css('display', 'block');
	});
	return false;
	
}


function fireKeyboard(div){
	//Als er op ENTER gedrukt wordt mag er opgeslagen worden.
	if (event.which == 13) {
		saveValue(div);
	}
}

function saveValue(div){
	//Definieer de naam van de sessie alvast
	var sessionname = '';
	if(div == 'editusername'){
		sessionname = 'userName';
	}else if(div == 'editusersurname'){
		sessionname = 'userSurname';
	}else if(div == 'editclientname'){
		sessionname = 'clientName';
	}else if(div == 'editclientsurname'){
		sessionname = 'clientSurname';
	}
	
	//Stuur URL door naar registration.php waar de "name" wordt opgeslagen als session met value
	var valueToSave = jQuery("#"+div+"edit").val();
	var url = "/ajax/registration.php?action=edit&name=" + sessionname +"&value=" + valueToSave + "";
	jQuery.get(url, function(msg) {
		//De nieuwe value vervangt de oude tekst.
		jQuery('#'+div+"block").html(msg);
		jQuery('#'+div).css('display', 'block');
	});
}

function saveColour(hex){
	//Stuur URL door naar registration.php waar de "name" wordt opgeslagen als session met value
	var url = "/ajax/registration.php?action=edit&name=clientColor&value=" + encodeURIComponent(hex) + "";
	jQuery.get(url, function(msg) {
		alert('kleur opgeslagen');
	});
}

function saveBirthday(birthday){
	//Stuur URL door naar registration.php waar de "name" wordt opgeslagen als session met value
	var url = "/ajax/registration.php?action=edit&name=clientBirthday&value=" + encodeURIComponent(birthday) + "";
	jQuery.get(url, function(msg) {
		//Splits datum om te hervormen naar Nederlandse format
		var splits = msg.split('-');
		jQuery('#currentBirthday').html(splits[2]+'-'+splits[1]+'-'+splits[0]);
		
		//Draai alle displays weer om naar orginele staat
		jQuery('#currentBirthday').toggle();
		jQuery('#birthdayedit').toggle();
		jQuery('#editbirthday').toggle();
		jQuery('#savebirthday').toggle();
	});
}

function checkEmail(){
	jQuery(".error").hide();
	//jQuery('#submitEmail').attr('disabled', true);
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
 
	var emailaddressVal = $("#emailAdres").val();
	if(emailaddressVal == '') {
	  jQuery("#emailAdres").after('<span class="error">Geen e-mailadres ingevuld</span>');
	  var hasError = true;
	  
	}
 
	else if(!emailReg.test(emailaddressVal)) {
	  jQuery("#emailAdres").after('<span class="error">Voer een geldig e-mailadres in</span>');
	  var hasError = true;
	}
 
 
	if(hasError == true) { 
		//jQuery('#submitEmail').attr('disabled', true);
	}else{
		//jQuery('#submitEmail').attr('disabled', false);
	}
}