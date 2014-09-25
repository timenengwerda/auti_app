
<?php
error_reporting(E_ALL);
if(isset($_GET)){
	if(!empty($_GET['img'])){
		//Filename is found in the GET(sent by JS) so set path, image and source
		$path = "http://www.envyum.nl/cam/uploads/original/";
		$img = $_GET['img'];
		$src = $path.$img;
		
		//secho $src;
		
		if(!empty($_GET['blockWidth']) && !empty($_GET['blockHeight'])){
			//The width and height is found in the GET so set them in a var along with the jpeg quality
			$targ_w = $_GET['blockWidth'];
			$targ_h = $_GET['blockHeight'];
			$jpeg_quality = 100;
			
			if(!empty($_GET['posX']) && !empty($_GET['posY'])){
				//The positions are found in the GET. Put them in vars for easier use.
				$posX = $_GET['posX'];
				$posY = $_GET['posY'];
				
				//SInce everything is found we can resize and crop the image.
				$srce = imagecreatefromjpeg($src);
				
				$newsize = imagecreatetruecolor($targ_w, $targ_h);
				
				imagecopyresampled($newsize, $srce, 0, 0, $posX, $posY, $targ_w, $targ_h, $targ_w, $targ_h) or die('faal');
				
				//header('Content-type: image/jpeg');
				if(imagejpeg($newsize,'uploads/original/def'.$img, 100)){
					unlink('uploads/original/'.$img);
					echo $path.'def'.$img;
				}else{
					echo 0;
				}
			}
		}
	}
}
?>