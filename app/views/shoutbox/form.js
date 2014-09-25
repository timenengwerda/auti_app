$(function() {
	$(".button").click(function() {
	
		var reply = $("input#reply").val();   
		var dataString = 'reply='+ reply;
		//alert(dataString);return false;
		$.ajax({
			type: "POST",
			url "process.php",
			data: dataString,
			succes: function() {
				$('#reactie'),html("<div id='message'></div>");
				}
		});
		return false;
	});
});