<script>
/*$.get('/shoutbox/replies', function(data) {
jQuery('.reaction').html(data);

});*/
jQuery(document).ready(function() {
	jQuery('.toonreacties').click(function(){
		var id = $(this).attr('id');
		$.get('/shoutbox/replies/'+id, function(data) {
			jQuery('.reaction'+id).html(data);

		});
		if($('.reaction'+id).html().length > 0) {
			$('.reaction'+id).toggle("normal"); 
		}
		$.get('/shoutbox/reply/'+id, function(data) {
			jQuery('.joucke'+id).html(data);

		});
		if($('.joucke'+id).html().length > 0) {
			$('.joucke'+id).toggle("normal"); 
		}

		return false;
	});
	
	jQuery('.reply').click(function(){
		var id = $(this).attr('id');
		
		if($('.joucke'+id).html().length > 0) {
			$('.joucke'+id).toggle("normal"); 
		}
		var formulier = '<form action="" id="replyForm" method="post"><textarea  name="reply"></textarea><input type="submit" name="submitReply" class="submitReply" id="'+id+'" value="reageer"> </form>';
		$('.joucke'+id).html(formulier);
		if($('.reaction'+id).html().length > 0) {
			$('.reaction'+id).toggle("normal"); 
		}
		
		$.get('/ajax/shoutbox.php?action=getReplies&id='+id, function(data) {
			//alert(data);
		});
		
		jQuery('.submitReply').click(function(){
			var id = $(this).attr('id');
			var reply = jQuery('#replyForm').serialize();
			//alert('/ajax/shoutbox.php?action=saveReply&id='+id+'&'+reply);
			$.get('/ajax/shoutbox.php?action=saveReply&id='+id+'&'+reply, function(data) {
				$('.joucke'+id).prepend(data);
			});
			return false;
		});
		
		return false;
	});
		
});

	function del_message(id){
		jQuery.ajax({
			type : "GET",
			url: "ajax/shoutbox.php",
			data: "action=delete&id="+id+"",
			 success: function(msg){
			 	alert(msg);
			    $('#post_'+id).hide();
			  }
		})
	}
</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>

<style>

h1 {
	font-family: Tahoma;
	font-size: 20px;
	margin-left: 15px;
	padding-top: 10px;
}

label {
	font-family: Tahoma;
}

.container {
	width: 500px;
	height: 250px;
	background-color: light blue;
	border: double fuchsia;	
}

form#bericht {
	float: right;
	padding-right: 15px;
}

textarea#message {
	height: 160px;
}

.banaan	{
	margin-top: 2px;
	float: left; 
	margin-left: 15px;
	width: 300px; 
	height: auto;
	font-family: Tahoma;
	font-size: 14px;
	overflow-right: scroll;
}

span {
	color: teal;
	font-size: 11px;
	float: right;
	margin-left: 192px;
	
	padding: 2px;
}

p.bericht {
	border: 1px solid grey;
	padding: 5px;
}

.reply {
	text-decoration: underline;
	color: blue;
}

a.toonreacties {
	font-size: 10px;
	float: right;
	font-family: Tahoma;
	padding: 2px;
	padding-right: 10px;
}

a.verwijder {
	font-size: 10px;
	font-family: Tahoma;
	float: left;
	color: red;
	padding: 2px;
}

p.reply {
	font-size: 10px;
	float: right;
	padding: 2px;
}

form#reactie {
	margin-top: 15px;
	float: left;
}

textarea#reply {
	width: 300px;
	height: 70px;
}


</style>




<div class="container">

<h1>Vraagbaak</h1>
<form action="" method="post" id="bericht">
	<label for="message">Bericht</label>
	<br/>
	<textarea name="message" id="message"></textarea>
	<br/>
	<input type="submit" name="submitShout" value="Plaats bericht" />
</form>
<?php
 
foreach($this->data['messages'] as $m)
{
	
  echo ' <div class="test"> <br />';
  echo '<div class="banaan" id="post_'.$m['messageID'].'"><span>' . $m['post_date'].'</span><p class="bericht">'.$m['message'] . '</p>';
  	if($m['userID'] == $_SESSION['userID']){
		echo '<a href="javascript:void(0);" class="verwijder" onclick="del_message('.$m['messageID'].')" id="'. $m['messageID'] .'"> Verwijder</a>';
	}
  echo '<p class="reply" id="'. $m['messageID'] .'">reply</p>';
  echo '<div class="joucke' .$m['messageID'] .'"></div>';
  echo '<a href="#" class="toonreacties" id="'. $m['messageID'] .'"> Toon reacties ('.$m['replycount'].')</a></div>';
  echo '<div class="reaction'.$m['messageID'].'"></div></div>';

}

?>
</div>

