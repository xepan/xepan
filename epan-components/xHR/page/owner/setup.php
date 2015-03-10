<?php

class page_xHR_page_owner_setup extends page_xHR_page_owner_main {
	function init(){
		parent::init();
		$this->app->layout->template->trySetHTML('page_title','<i class="fa fa-users"></i> '.$this->component_name. '<small>  Configuration</small>');

		$splitter = $this->app->layout->add('splitter/LayoutContainer');
		
		$west=$splitter->addPane('west');
		$center = $splitter->addPane('center');

		$this->populateSetupMenu($west);
		
	// 	$tab = $center->add('Tabs');
	// 		$tab->addTabURL('xHR/page/owner/department','Department');
	// 		$tab->addTabURL('xHR/page/owner/employees','Employees');
	// 		$tab->addTabURL('xHR/page/owner/holidayblock','Holiday Blocks');
	// 		$tab->addTabURL('xHR/page/owner/employee/post','Posts');
	// 		$tab->addTabURL('xHR/page/owner/salary','Salary');
	// 		$tab->addTabURL('xHR/page/owner/salarytemplate','Salary Templates');
	// 		$tab->addTabURL('xHR/page/owner/salarytype','Salary Type');
	
	}

	function populateSetupMenu($parent){
		$l=$parent->add('Lister');
		$l->template->loadTemplateFromString('<a href="#a">{$name}</a><br/>');
		$l->setSource(
			array(
				array('name'=>'Employement Type'),
				array('name'=>'Departments'),
				array('name'=>'Designations'),
				array('name'=>'Earning Types'),
				array('name'=>'Deduction Types'),
				array('name'=>'Salary Structure'),
				array('name'=>'Leave Type'),
				array('name'=>'Leave Allocation'),
				array('name'=>'Leave Block List'),
				array('name'=>'Holiday List'),
				array('name'=>'Appraisal Template'),
				array('name'=>'Expense Claim'),
				)
			);		
	}
}