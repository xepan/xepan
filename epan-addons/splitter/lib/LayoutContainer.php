<?php

namespace splitter;

class LayoutContainer extends \View{

	public $options=array();
	public $panes=array();

	function init(){
		parent::init();
		$this->addStyle(array('width'=>'100%','min-height'=>'500px'));
		$this->js(true)->css('height', $this->js()->_selectorWindow()->height());

		// $this->options=array(
		// 		'size'=> "auto"
		// ,	'minSize'=>				50
		// // ,	'paneClass'=>				"pane" 		// default = 'ui-layout-pane'
		// // ,	'resizerClass'=>			"resizer"	// default = 'ui-layout-resizer'
		// // ,	'togglerClass'=>			"toggler"	// default = 'ui-layout-toggler'
		// ,	'buttonClass'=>			"button"	// default = 'ui-layout-button'
		// ,	'contentSelector'=>		".content"	// inner div to auto-size so only it scrolls, not the entire pane!
		// ,	'contentIgnoreSelector'=>	"span"		// 'paneSelector' for content to 'ignore' when measuring room for content
		// ,	'togglerLength_open'=>		35			// WIDTH of toggler on north/south edges - HEIGHT on east/west edges
		// ,	'togglerLength_closed'=>	35			// "100%" OR -1 = full height
		// ,	'hideTogglerOnSlide'=>		true		// hide the toggler when pane is 'slid open'
		// ,	'togglerTip_open'=>		"Close This Pane"
		// ,	'togglerTip_closed'=>		"Open This Pane"
		// ,	'resizerTip'=>				"Resize This Pane"
		// //	effect defaults - overridden on some panes
		// ,	'fxName'=>					"slide"		// none, slide, drop, scale
		// ,	'fxSpeed_open'=>			750
		// ,	'fxSpeed_close'=>			1500
		// ,	'fxSettings_open'=>		array('easing'=> "easeInQuint" )
		// ,	'fxSettings_close'=>		array( 'easing'=> "easeOutQuint" )

		// 	);

		$this->options=array('applyDefaultStyles'=>true);

		$this->addPane('center');
	}

	function hasPane($position){
		return isset($this->panes[$position]);
	}

	function addPane($position='center',$options=array()){
		if($this->hasPane($position)) {
			$p=$this->getPane($position);
			if(count($options)) $this->setOptions($position,$options);
			return $p;
		}

		$obj = $this->panes[$position]= $this->add('View')->addClass('ui-layout-'.$position)->add('View');
		if(count($options)) $this->options[$position] = $options;
		return $obj;
	}

	function getPane($position){
		return $this->panes[$position];
	}

	function debug(){
		$this->debug=true;
	}

	function setOptions($position,$options){
		$this->options[$position] = $options;
	}

	function setOption($position,$option,$value){
		$this->options[$position][$option] = $value;
	}

	function addToggleButton($pane){
		$this->js(true)->layout('addToggleBtn','#'.$this->name.' ui-layout-'.$pane,$pane);
	}

	function render(){

		$addon_location = $this->api->locate('addons', __NAMESPACE__);
        $this->api->pathfinder->addLocation(array(
            'js'=>'templates/js',
            'css'=>'templates/js'
            ))
            ->setBasePath($this->api->pathfinder->base_location->base_path.'/'.$addon_location)
            ->setBaseURL($this->api->pm->base_path.'/'.$addon_location);
        ;
		$this->api->jquery->addStaticStyleSheet('layout-default-latest');
		if($this->debug){
			echo "<pre>";
			print_r($this->options);
			echo "</pre>";
		}
		$this->js(true)->_load('jquery.layout-latest')->layout($this->options);
		parent::render();
	}
}