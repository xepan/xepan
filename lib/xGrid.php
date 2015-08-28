<?php

class xGrid extends Grid{
	public $grid_template = 'grid';

	function precacheTemplate(){

	}

	function defaultTemplate(){
		return array($this->grid_template);
	}	
}
