<?php
class Template{

	public $error;
	public $succes;
	public $path;
	public $data;

	function __construct(){
		//path, pad naar het views	
		$this->path = "app/views";
	}

	
	// krijgt route en toRender binnen vanaf de basecontroller
	function render($route,$toRender){
						
		//zet het daadwerkelijke pad naar het bestand
		$view = $this->path .'/'. $route .'/'. $toRender. '.php';
		
		// haalt de header op
		require_once($this->path.'/layout/header.php');
		
		
		//Als er errors geset zijn in de template controller komen deze altijd bovenaan de pagina te staan.
		if(!empty($this->succes)){
			echo '<div class="succesBox">';
				foreach($this->succes as $succes){
					echo '' . $succes . '';
				}
			echo '</div>';
		}
		
		//Als er errors geset zijn in de template controller komen deze altijd bovenaan de pagina te staan.
		if(!empty($this->error)){
			echo '<div class="errorBox">';
				foreach($this->error as $error){
					echo '<br>'.$error;
				}
			echo '</div>';
		}
		
		// kijkt of het bestand daadwerkelijk bestaat		
		if (file_exists($view)) {
			// haalt de juiste view op, standaard:default.php	
									
			// haalt de view op
			require_once($view);
			
		}
		else {
			$this->setError($view.'bestaat niet');
		}
		
		//haalt de footer op
		require_once($this->path.'/layout/footer.php');
		
	}
	
	function setData($type, $data){

		//zet data aan binnegekomen type	
		$this->data[$type] = $data;
	}
	
	
	function setError($error){
		
		// kijkt of error een array is, zo niet maak array
		if(count($this->error) == 0){
			$this->error = array();
		}
		
		//zet alle opgegeven errors in array
		$this->error[] = $error;

	}
	
	function setSucces($succes){
		
		// kijkt of error een array is, zo niet maak array
		if(count($this->succes) == 0){
			$this->succes = array();
		}
		
		//zet alle opgegeven errors in array
		$this->succes[] = $succes;

	}
	
}
?>