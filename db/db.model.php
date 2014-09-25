<?php

/*Usage

/*For insert and Update you need to make an object for every item you wanna save.
$array = array(
		new Data("title", $post['title']),
		new Data("content", $post['content']),
		new Data("submitdate", "NOW()", false),
		new Data("author", "Timen")
	);
1st value = column of database
2nd value = value you want to save
3rd value = optional. If this is false, it will not escape the values. THis is very useful for mysql functions like NOW().



Insert:
	$array = array(
		new DataHandler("title", $post['title']),
		new DataHandler("content", $post['content']),
		new DataHandler("submitdate", "NOW()", false),
		new DataHandler("author", "Timen")
	);
	$result = $db->Insert('project', $array);
	if($result){
		echo 'Succes!';
	}

Select:
	$db->Select(complete select query);
	
Update:
	$array = array(
		new DataHandler("title", $post['title']),
		new DataHandler("content", $post['content']),
		new DataHandler("submitdate", "NOW()", false),
		new DataHandler("author", "Timen")
	);
	$result = $db->Update('project', $array, 'WHERE idproject=4');
	if($result){
		Succes
	}


*/


class DatabaseHandler extends DataHandler{
	function __construct(){
		$conn = mysql_connect('localhost', DBUSER, DBPASS);
		if (!$conn) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db(DBNAME);
	}
	
	function Query($query){
		//echo $query;
		return mysql_query($query);
	}
	
	function Insert($table, $values){
		
		if(!empty($table)){
			if(!empty($values)){
				$cols = '';
				$vals = '';
				
				foreach($values as $key=>$value){
					$cols .= '`'.$value->getColumn().'`, ';
					$vals .= (!$value->getEscape()) ? $value->getData().", " : "'".mysql_real_escape_string($value->getData())."', ";
				}
				$cols = substr($cols, 0, -2);
				$vals = substr($vals, 0, -2);
				$qry = "INSERT 
							INTO ".$table."(".$cols.") 
							VALUES (".$vals.")";
				$result = $this->Query($qry);
				if($result){
					return $result;
				}else{
					die(mysql_error());
				}
			}else{
				die('Values niet ingevuld.');
			}
		}else{
			die('Tabel niet ingevuld.');
		}
	}

	function Select($qry){
		//Results ophalen
		$result = $this->Query($qry);
		
		//Array maken voor de te retourneren items
		$items = array();
		//Als query result terug geeft
		if($result){
			//Tellen hoe veel kolommen in de tabel zitten
			$numOfCols = mysql_num_fields($result);

			$j = 0;
			while($row = mysql_fetch_array($result)){
				
				for($i = 0; $i < $numOfCols; $i++){
					//array vullen op record(per while record omhoog) en sorteren op kolomnaam en vullen met de result van de kolom.
					$items[$j][mysql_field_name($result, $i)] = stripslashes($row[mysql_field_name($result, $i)]);
				}
				$j++;
			}
			//Retourneren voor gebruik
	
			return $items;
			
		}else{
			//Result is fout!
			echo 'b';
			return false;
		}
	}
	
	function Delete($table, $where, $limit=1){
		//Check voor lege variables
		if(!empty($table)){
			if(!empty($where)){
				//Query schrijven
				$qry = "DELETE FROM ".$table."
						WHERE ".$where."
						LIMIT ". $limit;
				//Query uitvoeren
				if($this->Query($qry)){
					//True retourneren voor goed-melding
					return true;
				}else{
					//Fout
					die(mysql_error());
				}
			}else{
				//Fout
				die('WHERE niet ingevuld.');
			}
		}else{
			//Fout
			die('Tabel niet ingevuld');
		}
	}
	
	function Update($table, $rowResults, $where, $limit = 1){
		if(!empty($table)){
			if(!empty($rowResults)){
				if(!empty($where)){
					$val = $this->mergeArray($rowResults);
					$qry = "UPDATE ".$table." SET ".$val." ".$where." LIMIT ".$limit;
					if($this->Query($qry)){
						//True retourneren voor goed-melding
						return true;
					}else{
						//Fout
						die(mysql_error());
					}
				}else{
					//Fout
					die('WHERE is leeg');
				}
			}else{
				//Fout
				die('De te wijzigen kolommen/results zijn niet toegevoegd');
			}
		}else{
			//Fout
			die('Tabel niet ingevuld');
		}
	}
	
	function mergeArray($array){
		if(!empty($array)){
			$vals = '';
			foreach($array as $key=>$value){
				$vals.= $value->getColumn().'=';
				$vals .= (!$value->getEscape()) ? $value->getData().", " : "'".mysql_real_escape_string($value->getData())."', ";
			}
			return substr($vals, 0, -2);
		}else{
			return '';
		}
	}
}
?>