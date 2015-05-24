<?php

class page_cron_fetchemails extends Page {
	function page_index(){
		ini_set('memory_limit', '2048M');
		set_time_limit(0);

		$this->add('xHR/Model_Department')->each(function($dept){
			$dept->add('xCRM/Model_Email')->fetchDepartment($dept,'UNSEEN');
		});
	}
}