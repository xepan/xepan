<?php

namespace baseElements;

class View_Tools_Columns extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();
		$this->owner->add('componentBase/View_Options',array('namespace'=>$this->namespace,'component_type'=>'Row'));
	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}