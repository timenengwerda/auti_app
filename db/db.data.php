<?php
class DataHandler{
	private $column;
	private $data;
	private $escape;

	public function __construct($column, $data, $escape = true)
	{
		$this->column = $column;
		$this->data = $data;
		$this->escape = $escape;
	} 

	//getters hier
	public function getColumn() { 
		return $this->column; 
	}
	public function getData() { 
		return $this->data;
	}
	public function getEscape() { 
		return $this->escape; 
	}
}
?>