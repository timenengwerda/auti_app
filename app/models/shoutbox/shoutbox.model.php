<?php
	class ShoutboxModel{
		public $db;
		function __construct(){
			$this->db = new DatabaseHandler();
		}
		
		
		function saveMessage($array){
			return $this->db->Insert('shoutbox', $array);
		}		
		
		
		function getShouts(){
			return $this->db->Select("SELECT a.*, b.name, b.surname
									 FROM shoutbox a, users b
									WHERE a.reply_to=0 
									AND b.userID = a.userID
									ORDER BY a.post_date DESC
									LIMIT 5");
		}


		function replyShouts($array2){
			return $this->db->Insert('shoutbox', $array2);
		}

		function getReplies($id){
			return $this->db->Select("SELECT * FROM shoutbox WHERE reply_to=$id");
		}
		

		function deleteMessage(){
			//return $this->db->Delete("DELETE * FROM shoutbox WHERE");
		}
		

}
?>