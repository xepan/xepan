<?php

class page_xShop_page_designer_rendercalendar extends Page {
	function init(){
		parent::init();

		$options=array();
		
		$zoom = $options['zoom'] = $_GET['zoom'];
		$options['font_size'] = $_GET['font_size'] * ($zoom / 1.328352013);
		$options['font'] = $_GET['font'];
		$options['width'] = $_GET['width'] * $zoom;
		$options['height'] = $_GET['height'];
		$options['year'] = $_GET['year'];
		$options['month'] = $_GET['month'];

		$cont = $this->add('xShop/Controller_RenderCalendar',array('options'=>$options));
		$cont->show('png',3,true,false);

	}
}