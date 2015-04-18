<?php

class page_xHR_page_owner_dashboard extends page_xHR_page_owner_main{
	function init(){
		parent::init();
		$this->app->title=$this->api->current_department['name'] .': Dashboard';

// 		$x = <<<EOF
// 		Employee count present/absent
// 		Late Comers (name grid)
// 		On Todays Leave
// 		On Leave Tomorrow & in next week
// 		Recent JOb Applicants
// 		Today & Next Schedules
		

// EOF;

		//$this->add('View')->setHTML(nl2br($x));
		$is_superuser_login = false;
		if($this->api->auth->model->id == $this->api->auth->model->isDefaultSuperUser()){
			$is_superuser_login =true;
		}
		

		$col = $this->add('Columns');
		$col_1 = $col->addColumn(2);
		$col_2 = $col->addColumn(2);
		$col_3 = $col->addColumn(2);
		$col_4 = $col->addColumn(2);
		$col_5 = $col->addColumn(2);
		$col_6 = $col->addColumn(2);
		

		// Today Present Absent Employee 
		$today_present_employee_tile = $col_1->add('View_Tile')->addClass('atk-swatch-yellow')->setStyle('box-shadow','');
		$today_present_employee_tile->setTitle('Today Present/Absent Employee');

		$today_late_comers_employee_tile = $col_2->add('View_Tile')->addClass('atk-swatch-blue')->setStyle('box-shadow','');
		$today_late_comers_employee_tile->setTitle('Today Late Comers Employee');
		
		$today_on_leave_employee_tile = $col_3->add('View_Tile')->addClass('atk-swatch-red')->setStyle('box-shadow','');
		$today_on_leave_employee_tile->setTitle('On Today Leave');

		$today_on_leave_tomorrow_tile = $col_4->add('View_Tile')->addClass('atk-swatch-green')->setStyle('box-shadow','');
		$today_on_leave_tomorrow_tile->setTitle('On Leave Tomorrow & in next week');

		$recent_job_applicants_tile = $col_5->add('View_Tile')->addClass('atk-swatch-green')->setStyle('box-shadow','');
		$recent_job_applicants_tile->setTitle('Recent JOb Applicants');

		$today_next_schedules_tile = $col_6->add('View_Tile')->addClass('atk-swatch-yellow')->setStyle('box-shadow','');
		$today_next_schedules_tile->setTitle('Today & Next Schedules');
	}
}