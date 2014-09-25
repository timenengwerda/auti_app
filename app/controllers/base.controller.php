<?php
class BaseController{
	public $route;
	public $template;
	public $instanceController;
	public $instanceModel;
	public $db;
	
	function __construct(){
		//De route in public var zetten zodat deze in de rest van de pagina te gebruiken is
		$this->route = ($this->router() != false) ? $this->router() : 0;
		//Als de route leeg is wordt als default dashboard ingezet.
		if($this->route == 0){
			$this->route = array('dashboard');
		}
		
		
		//Template initieren voor later gebruik
		$this->template = new Template();
		//Als de route gevuld is worden de model, controller en view opgehaald.
		if($this->route != 0 or $this->route != false){
			//Haal model op
			$this->getModel();
			
			//Haal controller op
			$this->getController();
			
			//Als de route leeg is na de plural moet default view worden aangeroepen.
			//Wanneer de route user/add/ is moet de add view worden aangeroepen.
			$toRender = (count($this->route) == 1) ? 'default' : $this->route[1];		
			
			//Vraag de template controller om de juiste view te renderen.	
			$this->template->render($this->route[0], $toRender);
			
		}
	}
	
	function getController(){
		//Routestart kleine letters maken zodat deze makkelijker manipuleerbaar is indien nodig
		$routeStart = strtolower($this->route[0]);
		
		//De controller naam is het meervoud van de route+.controller.php
		$controllerName = strtolower($routeStart) . '.controller.php';
		
		//Kijk of het bestand bestaat.
		if(is_file('app/controllers/' . $routeStart . '/'.$controllerName)){
			//Bestand bestaat en wordt ingeladen.
			require_once('app/controllers/' . $routeStart . '/'.$controllerName);

			//Instantieer de controller volgens de conventie NaamController.
			// Stuur template object mee om gebruik te maken van setError en setData!
			$instanceName = ucfirst($routeStart) . 'Controller';
			$this->instanceController = new $instanceName($this->template, $this->route);
		}else{
			//Vraag de template om de error op te slaan.
			$this->template->setError('app/controllers/' . $routeStart . '/'.$controllerName . ' bestaat niet!');
		}
	}
	function getModel(){
		//Routestart kleine letters maken zodat deze makkelijker manipuleerbaar is indien nodig
		$routeStart = strtolower($this->route[0]);
		
		//De model naam is het meervoud van de route+.model.php
		$modelName = $routeStart . '.model.php';
		if(is_file('app/models/' . $routeStart . '/' . $modelName)){
			//Model bestaat dus wordt ingeladen
			require_once('app/models/' . $routeStart . '/' . $modelName);

		}else{
			$this->template->setError('app/models/' . $routeStart . '/' . $modelName . ' bestaat niet!');
		}
	}
	
	function router(){
		//Alle info ophalen na domein.nl
		if(empty($_GET['page'])){
			return false;
		}else{
			$pages = $_GET['page'];
			$pages = strtolower($pages);
			//Check laatste character. Als dit / is moet deze verwijderd worden.
			$lastChar = substr($pages, -1);
			if($lastChar == '/' || $lastChar == "\\"){
				$pages = substr($pages, 0, -1);
			}
	
			//Paginas uit elkaar halen
			$explodedPages = explode('/', $pages);
	
			//Return array met subpagina's
			return $explodedPages;
			/*
			Usage:
			$pages = allSubPages();
			echo $pages[0];
			0 is eerste pagina, 1 is tweede pagina etc.
			*/
		}
	}
	
	function setSession($name, $value){
		$_SESSION[$name] = $value;
	}
		
	


}
?>