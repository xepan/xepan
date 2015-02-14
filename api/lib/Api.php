<?php

class Api extends App_REST {
    function init(){
        parent::init();

        $this->dbConnect();

        $this->api->pathfinder
            ->addLocation(array(
                'addons' => array('atk4-addons','epan-components', 'vendor'),
	        	'php'=>array('lib'),
	            'page'=>array('epan-components','epan-addons'),
	            'js'=>array('templates/js'),
	            'css'=>array('templates/js','templates/css'),
            ))
            ->setBasePath($this->pathfinder->base_location->getPath() . '/..');

        $this->add('Auth')->setModel('Users');

        $this->add('Controller_PatternRouter')
            ->link('v1/book',array('id','method','arg1','arg2'))
            ->route();
    }
}
