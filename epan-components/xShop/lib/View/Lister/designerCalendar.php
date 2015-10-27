<?php

namespace xShop;
class View_Lister_designerCalendar extends \View{
	function init(){
		parent::init();

        $this->api->stickyGET('month');
        $this->api->stickyGET('years');
        $this->api->stickyGET('events');
        $this->api->stickyGET('from_date');
        $this->api->stickyGET('to_date');
        // echo "string".$_GET['month'];
        // echo "string".$_GET['years'];
        // echo "string".$_GET['events'];
        // echo "string".$_GET['from_date'];
        // echo "string".$_GET['to_date'];


        $number = cal_days_in_month(CAL_GREGORIAN, 10, 2015); // 31
        $str="";

        // echo  $number. "days in August 2003";
        $this->template->set('date_block',$str);

	}

	function defaultTemplate(){
    $this->app->pathfinder->base_location->addRelativeLocation(
        'epan-components/xShop', array(
            'php'=>'lib',
            'template'=>'templates',
            'css'=>array('templates/css','templates/js'),
            'img'=>array('templates/css','templates/js'),
            'js'=>'templates/js',
        )
    );
      return array('view/calendar/calendar');
  }
}