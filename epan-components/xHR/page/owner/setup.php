<?php

class page_xHR_page_owner_setup extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Configuration</small>');

			
		$tab = $this->add('Tabs');
			$tab->addTabURL('xHR/page/owner/holidayblock','Holiday Blocks');
			// $tab->addTabURL('xHR/page/owner/salary','Salary');
			$tab->addTabURL('xHR/page/owner/salarytype','Salary Type');
			$tab->addTabURL('xHR/page/owner/leave_leavetype','Leave Type');
			$tab->addTabURL('xHR/page/owner/leave_leaveallocation','Leave Allocation');
			$tab->addTabURL('xHR/page/owner/leave/leaveblock','Leave Block List');
			$tab->addTabURL('xHR_page_owner_epmloyeeattendance','Employement Attendance');
	}

}