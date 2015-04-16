<?php

namespace clippy;

class Agent extends \View {

	function initializeTemplate(){
		$this->app->pathfinder->base_location->addRelativeLocation(
		    'epan-addons/'.__NAMESPACE__, array(
		        'php'=>'lib',
		        'template'=>'templates',
		        'css'=>'js',
		        'js'=>'js',
		    )
		);

		parent::initializeTemplate();
	}

	function render(){
		$agents = array('Bonzi','Clippy','F1','Genius','Genie','Links');
		$this->js(true)->_load('xclippy')->univ()->loadAgent('Genie');
		parent::render();
	}
}