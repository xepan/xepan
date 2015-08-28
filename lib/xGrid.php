<?php

class xGrid extends Grid{
	public $grid_template = 'grid';
	public $grid_template_path = "";//epan-components/
	function precacheTemplate(){

	}

	function defaultTemplate(){
		if($this->grid_template_path){
			$this->app->pathfinder->base_location->addRelativeLocation(
			    $this->grid_template_path, array(
			        'php'=>'lib',
			        'template'=>'templates',
			        'css'=>array('templates/css','templates/js'),
			        'img'=>array('templates/css','templates/js'),
			        'js'=>'templates/js',
			    )
			);
		}
		return array($this->grid_template);
	}	
}
