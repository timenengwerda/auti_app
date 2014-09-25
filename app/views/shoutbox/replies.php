<?php
foreach($this->data['replies'] as $r)
	{
	echo '<p>'.$r['message'] . "</p> <sub>" . $r['post_date'].'</sub>';
	}
?>

