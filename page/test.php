<?php

use Omnipay\Common\GatewayFactory;

class page_test extends Page {
	function init(){
		parent::init();

		$l=$this->add('splitter/LayoutContainer');
		$l->getPane('center')->add('View')->set('Center');
		$l->addPane('north')->add('View')->set('North');
		// $l->addPane('south')->add('View')->set('South');
		// $l->addPane('east')->add('View')->set('East');
		$l->addPane('west',array(
				'size'=>					250
		,	'spacing_closed'=>			21			// wider space when closed
		,	'togglerLength_closed'=>	21			// make toggler 'square' - 21x21
		,	'togglerAlign_closed'=>	"top"		// align to top of resizer
		,	'togglerLength_open'=>		0			// NONE - using custom togglers INSIDE west-pane
		,	'togglerTip_open'=>		"Close West Pane"
		,	'togglerTip_closed'=>		"Open West Pane"
		,	'resizerTip_open'=>		"Resize West Pane"
		,	'slideTrigger_open'=>		"click" 	// default
		,	'initClosed'=>				true
		//	add 'bounce' option to default 'slide' effect
		,	'fxSettings_open'=>		array('easing'=> "easeOutBounce" )


			))->add('View')->set('West');



	}

	// function defaultTemplate(){
	// 	return array('test');
	// }

	function render(){
		parent::render();
	}
}