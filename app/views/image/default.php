<form action="" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<input type="submit" name="submit" value="Submit" />
</form>


<?php

	if(isset($_POST)){
	
		print_r($_FILES);
	}

?>