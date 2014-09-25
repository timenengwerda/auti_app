$(document).ready(function(){

	var camera = $('#camera'),
		photos = $('#photos'),
		screen =  $('#screen'),
		path = "http://dagplanner.envyum.nl/";

	var template = '<a href="public/images/custom/{src}" rel="cam" '
		+'style="background-image:url(public/images/custom/{src})"></a>';

	/*----------------------------------
		Setting up the web camera
	----------------------------------*/


	webcam.set_swf_url('/public/webcam/assets/webcam/webcam.swf');
	webcam.set_api_url('/public/webcam/assets/webcam/upload.php');	// The upload script
	webcam.set_quality(80);				// JPEG Photo Quality
	webcam.set_shutter_sound(true, '/public/webcam/assets/webcam/shutter.mp3');

	// Generating the embed code and adding it to the page:	
	screen.html(
		webcam.get_html(screen.width(), screen.height())
	);


	/*----------------------------------
		Binding event listeners
	----------------------------------*/


	var shootEnabled = false;
		
	$('#shootButton').click(function(){
		
		if(!shootEnabled){
			return false;
		}
		
		webcam.freeze();
		togglePane();
		return false;
	});
	
	$('#cancelButton').click(function(){
		webcam.reset();
		togglePane();
		return false;
	});
	
	$('#uploadButton').click(function(){
		webcam.upload();
		webcam.reset();
		togglePane();
		return false;
	});

	camera.find('.settings').click(function(){
		if(!shootEnabled){
			return false;
		}
		
		webcam.configure('camera');
	});

	// Showing and hiding the camera panel:
	
	var shown = false;
	$('.camTop').click(function(){
		
		$('.tooltip').fadeOut('fast');
		
		if(shown){
			camera.animate({
				bottom:-466
			});
		}
		else {
			camera.animate({
				bottom:-5
			},{easing:'easeOutExpo',duration:'slow'});
		}
		
		shown = !shown;
	});

	$('.tooltip').mouseenter(function(){
		$(this).fadeOut('fast');
	});


	/*---------------------- 
		Callbacks
	----------------------*/
	
	
	webcam.set_hook('onLoad',function(){
		// When the flash loads, enable
		// the Shoot and settings buttons:
		shootEnabled = true;
	});
	
	webcam.set_hook('onComplete', function(msg){
		
		// This response is returned by upload.php
		// and it holds the name of the image in a
		// JSON object format:
			
		msg = jQuery.parseJSON(msg);
		if(msg.error){
			alert(msg.message);
		}
		else {
			
			// Adding it to the page;
			closePopup();
			jQuery("#cropIt").html("<img style='width:100px;' id='CroptheImage' src=\""+path+"public/images/custom/"+msg.filename+"\" />");
			jQuery("#cropIt").append('<input type="hidden" name="customPhoto" value="'+msg.filename+'">');
			jQuery("#cropIt").append('Afbeeldingsnaam: <input type="text" name="customPhotoName">');
			//photos.prepend(templateReplace(template,{src:msg.filename}));
		}
	});
	
	webcam.set_hook('onError',function(e){
		screen.html(e);
	});
	
	
	/*-------------------------------------
		Populating the page with images
	-------------------------------------*/
	
	var start = '';
	/*
	function loadPics(){
	
		// This is true when loadPics is called
		// as an event handler for the LoadMore button:
		
		if(this != window){
			if($(this).html() == 'Loading..'){
				// Preventing more than one click
				return false;
			}
			$(this).html('Loading..');
		}
		
		// Issuing an AJAX request. The start parameter
		// is either empty or holds the name of the first
		// image to be displayed. Useful for pagination:
		
		$.getJSON('browse.php',{'start':start},function(r){
			
			photos.find('a').show();
			var loadMore = $('#loadMore').detach();
			
			if(!loadMore.length){
				loadMore = $('<span>',{
					id			: 'loadMore',
					html		: 'Load More',
					click		: loadPics
				});
			}
			
			$.each(r.files,function(i,filename){
				photos.append(templateReplace(template,{src:filename}));
			});

			// If there is a next page with images:			
			if(r.nextStart){
				
				// r.nextStart holds the name of the image
				// that comes after the last one shown currently.
				
				start = r.nextStart;
				photos.find('a:last').hide();
				photos.append(loadMore.html('Load More'));
			}
			
			// We have to re-initialize fancybox every
			// time we add new photos to the page:
			
			initFancyBox();
		});
		
		return false;
	}

	// Automatically calling loadPics to
	// populate the page onload:
	
	loadPics();*/
	

	/*----------------------
		Helper functions
	------------------------*/

	
	// This function initializes the
	// fancybox lightbox script.
	
	function initFancyBox(filename){
		photos.find('a:visible').fancybox({
			'transitionIn'	: 'elastic',
			'transitionOut'	: 'elastic',
			'overlayColor'	: '#111'
		});
	}


	// This function toggles the two
	// .buttonPane divs into visibility:
	
	function togglePane(){
		var visible = $('#camera .buttonPane:visible:first');
		var hidden = $('#camera .buttonPane:hidden:first');
		
		visible.fadeOut('fast',function(){
			hidden.show();
		});
	}
	
	
	// Helper function for replacing "{KEYWORD}" with
	// the respectful values of an object:
	
	function templateReplace(template,data){
		return template.replace(/{([^}]+)}/g,function(match,group){
			return data[group.toLowerCase()];
		});
	}
});
