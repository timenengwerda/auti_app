jQuery(document).ready(function() {
	jQuery('.popupDel').click(function(){
		closePopup();
	});
	
	jQuery('#forgot_password').click(function(){
		hideLogin();
		showForgot();
	});
	
	jQuery('.forget_back').click(function(){
		showLogin();
		hideForgot();
	});
	
	checkCookie();
	
	jQuery('#emailAdres').bind('click keyup change', function() {  
	checkEmail();
	});
	
});

function checkCookie(){
	var fontsize=getCookie("fontsize");

	if (fontsize!=null && fontsize!=""){
		toggleSize(fontsize);
	}else {
		if (fontsize!=null && fontsize!=""){
			setCookie("fontsize", 12, 365);
		}
	}
}

function setCookie(c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name){
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++){
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name){
			return unescape(y);
		}
	}
}


function toggleSize(fontsize){
	
	jQuery('body').css('font-size', fontsize+'px');
	setCookie("fontsize", fontsize, 365);
	return false;
}

function popPopup(text, width, height){
	
	jQuery('.popupTxt').html(text);
	//Show the popup and make the background become slightly less opaque
	jQuery('.popup').css('height', height);
	jQuery('.popup').css('width', width);
	jQuery('.popup').css('z-index', 10);
	
	jQuery('.popupTxt').css('height', height);
	jQuery('.popupTxt').css('width', width);
	
	jQuery('.popup').css('left', (jQuery(window).width()/2) - width/2);
	jQuery('.popup').css('top', (jQuery(window).height()/2) - height/2);
	
	jQuery('.popup').show("fast");
	
	jQuery(".bg").css('display', 'block');
	jQuery(".bg").css('z-index', 9);	
	jQuery(".bg").animate({opacity:0.5}, 400);
}
function closePopup(){
	jQuery('.popup').hide("fast");
	jQuery(".bg").animate({opacity:0}, 400, function(){
		jQuery(".bg").css('display', 'none');
		jQuery('.popupTxt').html("");
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


function hideLogin(){jQuery('.form_container').hide("fast");}
function showLogin(){jQuery('.form_container').show("fast");}
function hideForgot(){jQuery('.password_forget_box').hide("fast");}
function showForgot(){jQuery('.password_forget_box').show("fast");}
