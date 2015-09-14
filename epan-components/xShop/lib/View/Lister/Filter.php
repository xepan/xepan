<?php

namespace xShop;

class View_Lister_Filter extends \CompleteLister{
	public $html_attributes = array();
	public $specification_id = null;

	function defaultTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-components/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'templates/css',
		        'js'=>'templates/js',
		    )
		);
		return array('view/xShop-Lister-Filter');		
	}
}