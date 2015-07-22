<?php
/**
 * Created by PhpStorm.
 * User: vadym
 * Date: 12/03/15
 * Time: 20:22
 */

namespace markdown;

class Initiator {


    protected $locations_added = false;


    function addLocation($app) {

        $this->app->pathfinder->base_location->addRelativeLocation(
            'epan-addons/'.__NAMESPACE__, array(
                'php'=>'lib',
                'template'=>'templates',
                'css'=>'css',
                'js'=>'js',
            )
        );
        // parent::initializeTemplate();
    }











    /* --------------------------------------------------
     |
     |
     |                Singleton stuff
     |
     |
    */

    private static $instance;
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Initiator();
        }
        return self::$instance;
    }
    protected function __construct() {}

}