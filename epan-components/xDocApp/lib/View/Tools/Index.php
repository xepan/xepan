<?php

namespace xDocApp;

use \Michelf\MarkdownExtra;

class View_Tools_Index extends \componentBase\View_Component{
	public $html_attributes=array(); // ONLY Available in server side components
	function init(){
		parent::init();

		$my_html = MarkdownExtra::defaultTransform(file_get_contents(getcwd().DS.'xepan-doc'.DS.'_Sidebar.md'));
		$this->add('View')->setHTML($my_html);

	}

	// defined in parent class
	// Template of this tool is view/namespace-ToolName.html
}