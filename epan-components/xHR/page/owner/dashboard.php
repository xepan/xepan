<?php

class page_xHR_page_owner_dashboard extends page_xHR_page_owner_main{
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Dashboard';

		$x = <<<EOF
		Employee count present/absent
		Late Comers (name grid)
		On Todays Leave
		On Leave Tomorrow & in next week
		Recent JOb Applicants
		Today & Next Schedules
		

EOF;

		$this->add('View')->setHTML(nl2br($x));

	}
}