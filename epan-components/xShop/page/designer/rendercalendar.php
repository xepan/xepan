<?php

class page_xShop_page_designer_rendercalendar extends Page {
	function init(){
		parent::init();

		$options=array();
		
		$zoom = $options['zoom'] = $_GET['zoom'];
		
		$now = new \DateTime('now');
   		$current_month = $now->format('m');
   		$current_year = $now->format('Y');

		$options['font_size'] = $_GET['font_size'] * ($zoom / 1.328352013);
		$options['font'] = $_GET['font'];
		$options['month'] = $_GET['month'];

		$options['header_font_size'] = $_GET['header_font_size'] * ($zoom / 1.328352013);
		$options['day_date_font_size'] = $_GET['day_date_font_size'] * ($zoom / 1.328352013);
		$options['day_name_font_size'] = $_GET['day_name_font_size'] * ($zoom / 1.328352013);
		$options['event_font_size'] = $_GET['event_font_size'] * ($zoom / 1.328352013);

		$options['zindex'] = $_GET['zindex'];
		$options['width'] = $_GET['width'] * $zoom;
		$options['height'] = $_GET['height'];
		
		$options['starting_date'] = $now;
		$options['starting_month']= $current_month;
		$options['starting_year'] = $current_year;

		if($_GET['starting_date']){
			$options['starting_date'] = $_GET['starting_date'];
		}
		if($_GET['starting_month']){
			$options['starting_month'] = $_GET['starting_month'];
		}
		if($_GET['starting_year'])
			$options['starting_year'] = $_GET['starting_year'];
		
		$options['resizable']= $_GET['resizable'];
		$options['movable']= $_GET['movable'];
		$options['colorable']= $_GET['colorable'];
		$options['x'] = $_GET['x'];
		$options['y'] = $_GET['y'];

		//calculate the year and month on basis of month and starting-Year for which Calendar will be draw
		//ex:  Starting month= "Nov 2015" and month is "8" then calendar will draw 8th month from Nov 2015 that is "July 2016"
		if(!$_GET['month'])
			$options['month'] = $options['starting_month'];
		
   		if($options['month'] < $options['starting_month']){
   			$options['year'] = $options['starting_year'] + 1;
   		}

		$cont = $this->add('xShop/Controller_RenderCalendar',array('options'=>$options));
		$cont->show('png',3,true,false);

	}
}