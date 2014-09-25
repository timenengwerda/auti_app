<script src="form.js" type="text/javascript"></script>

<form action="" method="post" id="reactie">
	<label for="reply">Reageer</label>
	<br/>
	<textarea name="reply" id="reply"></textarea>
	<br/>
	<input type="hidden" name="reply_to" id="reply_to" value="<?php echo $this->data['replyID']; ?>" />
	<input type="submit" name="replyShout" value="Plaats reactie" />
</form>