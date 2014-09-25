<?php
class ImagesController extends BaseController{
	public $template;
	public $route;
	public $model;
	private $imageheight;
	private $imagewidth;
	private $type;
	private $max_file_size;
	private $uploadpath;
	
	
	function __construct($template, $route){
		require_once('app/models/image.model.php');
		$this->model = new ImageModel();
		$this->uploadpath = 'public/images/custom';
		$this->template = $template;
		
		// zet de maximale breedte en hoogte voor het pictogram
		$this->imageheight 	= 300;
		$this->imagewidth 	= 300;
		
		//toegestaande bestandstypen.
		$this->type = array('jpg', 'png');
		
		// maximale bestandsgrootte in KB
		$this->max_file_size = 100;
		
	}
	
	function uploadImage($_FILES, $file_name, $user_id){
		
		//zet error op 0
		$error = 0;
		  		
  		 // zet de naam, grootte in KB en bestandstype.
	    $fname = $_FILES['custompicto']['name'];  
    	$fsize = $_FILES['custompicto']['size'] / 1024;
    	$ftmp  = $_FILES['custompicto']['tmp_name'];
    	$ftype = end(explode('.', strtolower($fname)));
    	
    	// voor ouwe IE upload, veranderd alle jpeg naar jpg
    	if($ftype == "jpeg"){	
	    	$ftype = "jpg";
    	}

    	$getsize = getimagesize($ftmp);
    	$fwidth  = $getsize[0];
    	$fheight = $getsize[1];
		
		
		if(empty($file_name)){
			$this->template->setError('Deze afbeelding heeft nog geen naam!)');
			
			$error++;
		}
		
		// kijkt of bestand niet corrupt is
		if ($_FILES["custompicto"]["error"] > 0) {
		
			$error++;
		
			$this->template->setError('Dit bestand is niet corrupt of niet volledig');
  		}
		// kijkt of de geldige bestandstype is
		if (!in_array($ftype, $this->type)) {
					
			$error++;
		
			$this->template->setError('Bestandstype is niet geldig alleen(.jpg,png)');
		}
		
		//kijkt naar de maximale grootte 100KB
		if ($fsize >= $this->max_file_size) {
		
			$error++;
		
			$this->template->setError('Bestand is te groot (max 100kb)');
		}
		
		// als er errors zijn, mag je niet uploaden
		if ($error == 0 ) {	
			//check nog een keer of dit nou echt een image is.
 		 	if (strpos($_FILES['custompicto']['type'], 'image') !== false) {
 		 	
     			$this->uploadpath.$ftmp;
     			
       			 if (move_uploaded_file($ftmp, $this->uploadpath.$ftmp)) {
       			 	
					// resized de image
					return $this->resizeImage($ftmp, $ftype, $fwidth, $fheight, $file_name, $user_id);
					
					
       			 }else{
       			 	$this->template->setError('kon het bestand niet uploaden');
       			 	return false;
       			 }
   			 }
   			 else{
	   			 return false;
   			 }       
		}
		else{
			return false;
		}
		

			
	}
	
	function resizeImage($ftmp, $ftype, $fwidth, $fheight, $file_name, $user_id){
		
		//maakt een nieuwe image en resized het naar 100x100
		$newsize = imagecreatetruecolor($this->imagewidth, $this->imageheight);
		$newname = strtolower(md5(microtime()));
		switch($ftype){
			case 'jpg':
				$src = imagecreatefromjpeg($this->uploadpath . $ftmp);
				imagecopyresampled($newsize, $src, 0, 0, 0, 0, $this->imagewidth, $this->imageheight, $fwidth, $fheight);
				imagejpeg($newsize, $this->uploadpath .'/'. $newname.'.'.$ftype, 100) or die('Fail');
			break;
			case 'png':
				$src = imagecreatefrompng($this->uploadpath . $ftmp);
				imagecopyresampled($newsize, $src, 0, 0, 0, 0, $this->imagewidth, $this->imageheight, $fwidth, $fheight);
				imagepng($newsize, $this->uploadpath .'/'. $newname.'.'.$ftype) or die('Fail');
			break;
		
		}
		//verwijder de tmp file
		unlink($this->uploadpath.$ftmp);
		
		$image = $newname.'.'.$ftype;
				
		// opslaan en in de database zetten
		return $this->saveImage($file_name, $image, $user_id);
		
	}
	
	function saveImage($file_name, $image, $user_id){
	
		$arr = array(
			  new DataHandler('name', $file_name),
			  new DataHandler('filename', $image),
			  new DataHandler('UserID', $user_id)
		);
		
		return $this->model->addImage($arr);
		
	}
		
	
}


?>