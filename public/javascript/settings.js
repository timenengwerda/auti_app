

function delImage(id){

	if(confirm("Weet u zeker dat u deze afbeelding wilt verwijderen? Alle gekoppelde activiteiten worden ook verwijderd.")){

		jQuery.get("/ajax/settings.php?action=delete&id="+id, function(msg) {
			if(msg == 1){			
				jQuery('#image_'+id).hide();
			}else{
				alert('Het verwijderen is niet gelukt');
			}
		});
	}	
}