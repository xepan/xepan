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

        $this->setUpCurrentEpan();


        $this->add('Auth')->setModel('Users');

        $this->add('Controller_PatternRouter')
            ->link('v1/book',array('id','method','arg1','arg2'))
            ->route();
    }

    function setUpCurrentEpan(){
        $site_parameter= $this->getConfig( 'url_site_parameter' );
        $page_parameter= $this->getConfig( 'url_page_parameter' );


        $this->website_requested = $this->getConfig( 'default_site' );
        /**
         * $this->page_requested finds and gets the requested page
         * Always required in both multi site mode and single site mode
         *
         * @var String
         */
        $this->page_requested=trim( $_GET[$page_parameter], '/' )
            ?  trim( $_GET[$page_parameter], '/' )
            : $this->getConfig( 'default_page' );

        
        $this->current_website = $this->add( 'Model_Epan' )->tryLoadBy( 'name', $this->website_requested );
        if ( $this->current_website->loaded() ) {
            $this->current_page = $this->current_website->ref( 'EpanPage' )
            ->addCondition( 'name', $this->page_requested )
            ->tryLoadAny();
        }else {
            $this->exec_plugins( 'error404', $this->website_requested );
        }

        $this->add( 'Controller_EpanCMSApp' )->frontEnd();
        
        date_default_timezone_set($this->current_website['time_zone']?:'UTC');
        $this->today = date('Y-m-d');
        $this->now = date('Y-m-d H:i:s');
        $this->current_employee = $this->add('xHR/Model_Employee');
    }
}
